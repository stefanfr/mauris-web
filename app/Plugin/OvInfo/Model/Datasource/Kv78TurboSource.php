<?

App::uses('HttpSocket', 'Network/Http');

class Kv78TurboSource extends DataSource {

/**
 * An optional description of your datasource
 */
    public $description = 'A far away datasource';

/**
 * Create our HttpSocket and handle any config tweaks.
 */
    public function __construct($config) {
        parent::__construct($config);
        
        $this->Http = new HttpSocket();
    }

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */

/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just ``return null``.
 */
    public function listSources($data = null) {
        return null;
    }

/**
 * describe() tells the model your schema for ``Model::save()``.
 *
 * You may want a different schema for each model but still use a single
 * datasource. If this is your case then set a ``schema`` property on your
 * models and simply return ``$model->schema`` here instead.
 */
    public function describe($model) {
        return $this->_schema;
    }

/**
 * calculate() is for determining how we will count the records and is
 * required to get ``update()`` and ``delete()`` to work.
 *
 * We don't count the records here but return a string to be passed to
 * ``read()`` which will do the actual counting. The easiest way is to just
 * return the string 'COUNT' and check for it in ``read()`` where
 * ``$data['fields'] === 'COUNT'``.
 */
    public function calculate(Model $model, $func, $params = array()) {
        return 'COUNT';
    }

/**
 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
 */
    public function read(Model $model, $queryData = array(),
        $recursive = null) {
        //debug($model);
        //debug($queryData);
        /**
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
        
        $data = array();
        
        /**
         * Now we get, decode and return the remote data.
         */
        
        if ((!isset($queryData['conditions']['id'])) && ($model->id)) {
            $queryData['conditions']['id'] = array($model->id);
        }
        
        if (isset($queryData['conditions']['id'])) {
            if (!is_array($queryData['conditions']['id'])) {
                $queryData['conditions']['id'] = array($queryData['conditions']['id']);
            }
            
            $rows = $this->getDataByIds($model->table, $queryData['conditions']['id']);
        } else {
            $rows = $this->getTableData($model->table);
        }
        
        
        
        
        foreach ($rows as $index => $row) {
            $accepted = true;
            foreach ($queryData['conditions'] as $field => $condition) {
                if (isset($row[$field])) {
                    //debug($row[$field]);
                    if (substr($condition, 0, 1) == ':') {
                        if (!preg_match(substr($condition, 1), $row[$field])) {
                            $accepted = false;

                            break;
                        }
                    } else {
                        if ($row[$field] != $condition) {
                            $accepted = false;

                            break;
                        }
                    }
                }
            }
            
            if ($accepted) {
                $data[$index] = $row;
            }
        }
        
        if ($queryData['recursive']) {
            foreach ($model->belongsTo as $alias => $options) {
                foreach ($data as &$row) {
                    if (isset($options['container'])) {
                        $containerData = $row[$options['container']];
                        foreach ($containerData as $index => $entryData) {
                            $subModel = ClassRegistry::init($options['className']);

                            if ($options['foreignKey'] == 'index') {
                                $id = $index;
                            } else {
                                $id = $entryData[$options['foreignKey']];
                            }

                            $subModelData = $subModel->find(
                                'all',
                                array(
                                    'conditions' => array(
                                        'id' => $id
                                    ),
                                    'recursive' => $queryData['recursive'] - 1,
                                    'limit' => 1
                                )
                            );

                            $row[$options['container']][$index][$alias] = $subModelData[$subModel->alias];
                        }
                    } else {
                        $subModel = ClassRegistry::init($options['className']);

                        $id = null;
                        if ($options['foreignKey'] == 'index') {
                            $id = $index;
                        } else {
                            if (isset($row[$options['foreignKey']])) {
                                $id = $row[$options['foreignKey']];
                            }
                        }
                        
                        if (!$id) {
                            continue;
                        }

                        $subModelData = $subModel->find(
                            'all',
                            array(
                                'conditions' => array(
                                    'id' => $id
                                ),
                                'recursive' => $queryData['recursive'] - 1,
                                'limit' => 1
                            )
                        );

                        $row[$alias] = $subModelData[$subModel->alias];
                    }
                }
            }
        }
        
        if ($queryData['limit']) {
            $data = array_slice($data, 0, $queryData['limit']);
        }
        
        /*if ($queryData['limit'] == 1) {
            $data = $data[0];
        }*/
        
        /*if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }*/
        return array($model->alias => $data);
    }

/**
 * Implement the C in CRUD. Calls to ``Model::save()`` without $model->id
 * set arrive here.
 */
    public function create(Model $model, $fields = null, $values = null) {}

/**
 * Implement the U in CRUD. Calls to ``Model::save()`` with $Model->id
 * set arrive here. Depending on the remote source you can just call
 * ``$this->create()``.
 */
    public function update(Model $model, $fields = null, $values = null,
        $conditions = null) {}

/**
 * Implement the D in CRUD. Calls to ``Model::delete()`` arrive here.
 */
    public function delete(Model $model, $id = null) {}
    
    private function getTableData($table) {
        if ($data = Cache::read('turbo-' .  $table)) {
            return $data;
        }
        
        $json = $this->Http->get(
            'http://kv78turbo.ovapi.nl/' . $table . '/'
        );
        
        $data = json_decode($json, true);
        
        Cache::write('turbo-' .  $table, $data);
        
        return $data;
    }
    
    private function getDataByIds($table, array $ids) {
        $key = 'turbo-' .  $table . '-' . md5(implode(',', $ids));
        
        /*if ($data = Cache::read($key)) {
            return $data;
        }*/
        
        $json = $this->Http->get(
            'http://v0.ovapi.nl/' . $table . '/' . implode(',', $ids)
        );
        
        $data = json_decode($json, true);
        
        Cache::write($key, $data);
        
        return $data;
    }

}