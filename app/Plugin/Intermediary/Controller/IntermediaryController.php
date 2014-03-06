<?php

class IntermediaryController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('check');
    }
    
    public function check($url) {
        $this->set('page_url', $url);
        $this->set('page_info', $this->_getPageInfo($url));
    }
    
    private function _getPageInfo($url) {
        $content = @file_get_contents($url);
        
        $info = array();
        
        $checkedKeys = array(
            'title', 'description', 'keywords', 'copyright', 'publisher',
            'author', 'language'
        );
        
        //parsing begins here:
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        if ($nodes->item(0)) {
            $info['title'] = $nodes->item(0)->nodeValue;
        }

        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            
            switch ($meta->getAttribute('name')) {
                case 'description':
                    $info['description'] = utf8_encode(trim($meta->getAttribute('content')));
                    break;
                case 'language':
                    $info['language'] = utf8_encode(trim($meta->getAttribute('content')));
                    break;
                case 'copyright':
                    $info['copyright'] = utf8_encode(trim($meta->getAttribute('content')));
                    break;
                case 'publisher':
                    $info['publisher'] = utf8_encode(trim($meta->getAttribute('content')));
                    break;
                case 'author':
                    $info['author'] = utf8_encode(trim($meta->getAttribute('content')));
                    break;
                case 'keywords':
                    $info['keywords'] = array_filter(
                        explode(',', trim($meta->getAttribute('content')))
                    );
                    break;
            }
        }

        foreach ($checkedKeys as $key) {
            if (isset($info[$key])) {
                if (is_string($info[$key])) {
                    if (!strlen(trim($info[$key]))) {
                        unset($info[$key]);
                    }
                }
                if (empty($info[$key])) {
                    unset($info[$key]);
                }
            }
        }
        
        return $info;
    }
    
}