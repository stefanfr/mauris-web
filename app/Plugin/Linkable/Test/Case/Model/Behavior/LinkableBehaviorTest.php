<?php

App::uses('Model', 'Model');
App::uses('Controller', 'Controller');

class LinkableBehaviorTest extends CakeTestCase {

	public $fixtures = array(
		'plugin.linkable.user',
		'plugin.linkable.profile',
		'plugin.linkable.generic',
		'plugin.linkable.comment',
		'plugin.linkable.post',
		'plugin.linkable.posts_tag',
		'plugin.linkable.tag',
		'plugin.linkable.legacy_product',
		'plugin.linkable.legacy_company',
		'plugin.linkable.shipment',
		'plugin.linkable.order_item',
		'plugin.linkable.news_article',
		'plugin.linkable.news_category',
		'plugin.linkable.news_articles_news_category',
	);

	public $User;

	public function startTest($method) {
		$this->User = ClassRegistry::init('User');
	}

	public function endTest($method) {
		unset($this->User);
	}

	public function testBelongsTo() {
		$arrayExpected = array(
			'User' => array('id' => 1, 'username' => 'CakePHP'),
			'Profile' => array ('id' => 1, 'user_id' => 1, 'biography' => 'CakePHP is a rapid development framework for PHP that provides an extensible architecture for developing, maintaining, and deploying applications.')
		);

		$arrayResult = $this->User->find('first', array(
			'contain' => array(
				'Profile'
			)
		));
		$this->assertTrue(isset($arrayResult['Profile']), 'belongsTo association via Containable: %s');
		$this->assertEquals($arrayResult, $arrayExpected, 'belongsTo association via Containable: %s');

		// Same association, but this time with Linkable
		$arrayResult = $this->User->find('first', array(
			'fields' => array(
				'id',
				'username'
			),
			'contain' => false,
			'link' => array(
				'Profile' => array(
					'fields' => array(
						'id',
						'user_id',
						'biography'
					)
				)
			)
		));

		$this->assertTrue(isset($arrayResult['Profile']), 'belongsTo association via Linkable: %s');
		$this->assertTrue(!empty($arrayResult['Profile']), 'belongsTo association via Linkable: %s');
		$this->assertEquals($arrayResult, $arrayExpected, 'belongsTo association via Linkable: %s');

		// Linkable association, no field lists
		$arrayResult = $this->User->find('first', array(
			'contain' => false,
			'link' => array(
				'Profile'
			)
		));

		$this->assertTrue(isset($arrayResult['Profile']), 'belongsTo association via Linkable (automatic fields): %s');
		$this->assertEquals($arrayResult, $arrayExpected, 'belongsTo association via Linkable (automatic fields): %s');

		// On-the-fly association via Linkable
		$arrayExpected = array(
			'User' => array('id' => 1, 'username' => 'CakePHP'),
			'Generic' => array('id' => 1, 'text' => '')
		);

		$arrayResult = $this->User->find('first', array(
			'contain' => false,
			'link' => array(
				'Generic' => array(
					'class' => 'Generic',
					'conditions' => array('exactly' => 'User.id = Generic.id'),
					'fields' => array(
						'id',
						'text'
					)
				)
			)
		));

		$this->assertTrue(isset($arrayResult['Generic']), 'On-the-fly belongsTo association via Linkable: %s');
		$this->assertEquals($arrayResult, $arrayExpected, 'On-the-fly belongsTo association via Linkable: %s');

		// On-the-fly association via Linkable, with order on the associations' row and using array conditions instead of plain string
		$arrayExpected = array(
			'User' => array('id' => 4, 'username' => 'CodeIgniter'),
			'Generic' => array('id' => 4, 'text' => '')
		);

		$arrayResult = $this->User->find('first', array(
			'contain' => false,
			'link' => array(
				'Generic' => array(
					'class' => 'Generic',
					'conditions' => array('exactly' => array('User.id = Generic.id')),
					'fields' => array(
						'id',
						'text'
					)
				)
			),
			'order' => 'Generic.id DESC'
		));

		$this->assertEquals($arrayResult, $arrayExpected, 'On-the-fly belongsTo association via Linkable, with order: %s');
	}

	public function testHasMany() {
		// hasMany association via Containable. Should still work when Linkable is loaded
		$arrayExpected = array(
			'User' => array('id' => 1, 'username' => 'CakePHP'),
			'Comment' => array(
				0 => array(
					'id' => 1,
					'user_id' => 1,
					'body' => 'Text'
				),
				1 => array(
					'id' => 2,
					'user_id' => 1,
					'body' => 'Text'
				),
			)
		);

		$arrayResult = $this->User->find('first', array(
			'contain' => array(
				'Comment'
			),
			'order'	=> 'User.id ASC'
		));
		$this->assertTrue(isset($arrayResult['Comment']), 'hasMany association via Containable: %s');
		$this->assertEquals($arrayResult, $arrayExpected, 'hasMany association via Containable: %s');

		// Same association, but this time with Linkable
		$arrayExpected = array(
			'User' => array('id' => 1, 'username' => 'CakePHP'),
			'Comment' => array(
				'id' => 1,
				'user_id' => 1,
				'body' => 'Text'
			)
		);

		$arrayResult = $this->User->find('first', array(
			'fields' => array(
				'id',
				'username'
			),
			'contain' => false,
			'link' => array(
				'Comment' => array(
					'fields' => array(
						'id',
						'user_id',
						'body'
					)
				)
			),
			'order' => 'User.id ASC',
			'group' => 'User.id'
		));

		$this->assertEquals($arrayResult, $arrayExpected, 'hasMany association via Linkable: %s');
	}

	public function testComplexAssociations() {
		$this->Post = ClassRegistry::init('Post');

		$arrayExpected	= array(
			'Post' => array('id' => 1, 'title' => 'Post 1', 'user_id' => 1),
			'Tag' => array('name' => 'General'),
			'Profile' => array('biography' => 'CakePHP is a rapid development framework for PHP that provides an extensible architecture for developing, maintaining, and deploying applications.'),
			'MainTag' => array('name' => 'General'),
			'Generic' => array('id' => 1,'text' => ''),
			'User' => array('id' => 1, 'username' => 'CakePHP')
		);

		$arrayResult = $this->Post->find('first', array(
			'conditions' => array(
				'MainTag.id' => 1
			),
			'link' => array(
				'User' => array(
					'Profile' => array(
						'fields' => array(
							'biography'
						),
						'Generic' => array(
							'class'	=> 'Generic',
							'conditions' => array('exactly' => 'User.id = Generic.id'),
						)
					)
				),
				'Tag' => array(
					'table'	=> 'tags',
					'fields' => array(
						'name'
					)
				),
				'MainTag' => array(
					'class'	=> 'Tag',
					'conditions' => array('exactly' => 'PostsTag.post_id = Post.id'),
					'fields' => array(
						'name'
					)
				)
			)
		));

		$this->assertEquals($arrayExpected, $arrayResult, 'Complex find: %s');

		// Linkable and Containable combined
		$arrayExpected = array(
			'Post' => array('id' => 1, 'title' => 'Post 1', 'user_id' => 1),
			'Tag' => array(
				array('id' => 1, 'name' => 'General', 'parent_id' => null, 'PostsTag' => array('id' => 1, 'post_id' => 1, 'tag_id' => 1, 'main' => 0)),
				array('id' => 2, 'name' => 'Test I', 'parent_id' => 1, 'PostsTag' => array('id' => 2, 'post_id' => 1, 'tag_id' => 2, 'main' => 1))
			),
			'User' => array('id' => 1, 'username' => 'CakePHP')
		);

		$arrayResult = $this->Post->find('first', array(
			'contain' => array(
				'Tag'
			),
			'link' => array(
				'User'
			)
		));

		$this->assertEquals($arrayResult, $arrayExpected, 'Linkable and Containable combined: %s');
	}

	public function testPagination() {
		$this->markTestSkipped('Needs revision');
            
		$objController = new Controller(new CakeRequest('/'), new CakeResponse());
		$objController->layout = 'ajax';
		$objController->uses = array('User');
		$objController->constructClasses();
		$objController->request->url = '/';

		$objController->paginate = array(
			'fields' => array(
				'username'
			),
			'contain' => false,
			'link' => array(
				'Profile' => array(
					'fields' => array(
						'biography'
					)
				)
			),
			'limit' => 2
		);

		$arrayResult = $objController->paginate('User');

		$this->assertEquals($objController->params['paging']['User']['count'], 4, 'Paging: total records count: %s');

		// Pagination with order on a row from table joined with Linkable
		$objController->paginate = array(
			'fields' => array(
				'id'
			),
			'contain' => false,
			'link' => array(
				'Profile' => array(
					'fields' => array(
						'user_id'
					)
				)
			),
			'limit'	=> 2,
			'order'	=> 'Profile.user_id DESC'
		);

		$arrayResult = $objController->paginate('User');

		$arrayExpected = array(
			0 => array(
				'User' => array(
					'id' => 4
				),
				'Profile' => array ('user_id' => 4)
			),
			1 => array(
				'User' => array(
					'id' => 3
				),
				'Profile' => array ('user_id' => 3)
			)
		);

		$this->assertEquals($arrayResult, $arrayExpected, 'Paging with order on join table row: %s');

		// Pagination without specifying any fields
		$objController->paginate = array(
			'contain' => false,
			'link' => array(
				'Profile'
			),
			'limit' => 2,
			'order'	=> 'Profile.user_id DESC'
		);

		$arrayResult = $objController->paginate('User');
		$this->assertEquals($objController->params['paging']['User']['count'], 4, 'Paging without any field lists: total records count: %s');
	}

/**
 * Series of tests that assert if Linkable can adapt to assocations that
 * have aliases different from their standard model names
 */
	public function testNonstandardAssociationNames() {
		$this->markTestSkipped('Needs revision');
                
		$this->Tag = ClassRegistry::init('Tag');

		$arrayExpected = array(
			'Tag' => array(
				'name' => 'Test I'
			),
			'Parent' => array(
				'name' => 'General'
			)
		);

		$arrayResult = $this->Tag->find('first', array(
			'fields' => array(
				'name'
			),
			'conditions' => array(
				'Tag.id' => 2
			),
			'link' => array(
				'Parent' => array(
					'fields' => array(
						'name'
					)
				)
			)
		));

		$this->assertEquals($arrayExpected, $arrayResult, 'Association with non-standard name: %s');

		$this->LegacyProduct = ClassRegistry::init('LegacyProduct');

		$arrayExpected = array(
			'LegacyProduct'	=> array(
				'name' => 'Velocipede'
			),
			'Maker'	=> array(
				'company_name' => 'Vintage Stuff Manufactory'
			),
			'Transporter' => array(
				'company_name' => 'Joe & Co Crate Shipping Company'
			)
		);

		$arrayResult = $this->LegacyProduct->find('first', array(
			'fields' => array(
				'name'
			),
			'conditions' => array(
				'LegacyProduct.product_id' => 1
			),
			'link' => array(
				'Maker'	=> array(
					'fields' => array(
						'company_name'
					)
				),
				'Transporter' => array(
					'fields' => array(
						'company_name'
					)
				)
			)
		));

		$this->assertEquals($arrayExpected, $arrayResult, 'belongsTo associations with custom foreignKey: %s');

		$arrayExpected = array(
			'ProductsMade' => array(
				'name' => 'Velocipede'
			),
			'Maker'	=> array(
				'company_name' => 'Vintage Stuff Manufactory'
			)
		);

		$arrayResult = $this->LegacyProduct->Maker->find('first', array(
			'fields' => array(
				'company_name'
			),
			'conditions' => array(
				'Maker.company_id' => 1
			),
			'link' => array(
				'ProductsMade' => array(
					'fields' => array(
						'name'
					)
				)
			)
		));

		$this->assertEquals($arrayExpected, $arrayResult, 'hasMany association with custom foreignKey: %s');
	}

	public function testAliasedBelongsToWithSameModelAsHasMany() {
            	$this->markTestSkipped('Needs revision');
            
		$this->OrderItem = ClassRegistry::init('OrderItem');

		$arrayExpected = array(
			0 => array(
				'OrderItem' => array(
					'id' => 50,
					'active_shipment_id' => 320
				),
				'ActiveShipment' => array(
					'id' => 320,
					'ship_date' => '2011-01-07',
					'order_item_id'	=> 50
				)
			)
		);

		$arrayResult = $this->OrderItem->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'ActiveShipment.ship_date' => date('2011-01-07'),
			),
			'link' => array('ActiveShipment'),
		));

		$this->assertEquals($arrayExpected, $arrayResult, 'belongsTo association with alias (requested), with hasMany to the same model without alias: %s');
	}
        
/**
 * Ensure that the correct habtm keys are read from the relationship in the models
 * 
 * @author David Yell <neon1024@gmail.com>
 * @return void
 */
        public function testHasAndBelongsToManyNonConvention() {
            $this->NewsArticle = ClassRegistry::init('NewsArticle');
            
            $expected = array(
                array(
                    'NewsArticle' => array(
                        'id' => '1',
                        'title' => 'CakePHP the best framework'
                    ),
                    'NewsCategory' => array(
                        'id' => '1',
                        'name' => 'Development'
                    )
                )
            );
            
            $result = $this->NewsArticle->find('all', array(
                'link' => array(
                    'NewsCategory'
                ),
                'conditions' => array(
                    'NewsCategory.id' => 1
                )
            ));
            
            $this->assertEqual($result, $expected);
        }
}

class TestModel extends CakeTestModel {

	public $recursive = 0;

	public $actsAs = array(
		'Containable',
		'Linkable.Linkable',
	);
}

class User extends TestModel {
	public $hasOne = array(
		'Profile'
	);

	public $hasMany	= array(
		'Comment',
		'Post'
	);
}

class Profile extends TestModel {
	public $belongsTo = array(
		'User'
	);
}

class Post extends TestModel {
	public $belongsTo = array(
		'User'
	);

	public $hasAndBelongsToMany = array(
		'Tag'
	);
}

class PostTag extends TestModel {
}

class Tag extends TestModel {
	public $hasAndBelongsToMany = array(
		'Post'
	);

	public $belongsTo = array(
		'Parent' => array(
			'className' => 'Tag',
			'foreignKey' => 'parent_id'
		)
	);
}

class LegacyProduct extends TestModel {
	public $primaryKey = 'product_id';

	public $belongsTo = array(
		'Maker'	=> array(
			'className' => 'LegacyCompany',
			'foreignKey' => 'the_company_that_builds_it_id'
		),
		'Transporter' => array(
			'className' => 'LegacyCompany',
			'foreignKey' => 'the_company_that_delivers_it_id'
		)
	);
}

class LegacyCompany extends TestModel {
	public $primaryKey = 'company_id';

	public $hasMany	= array(
		'ProductsMade' => array(
			'className' => 'LegacyProduct',
			'foreignKey' => 'the_company_that_builds_it_id'
		)
	);
}

class Shipment extends TestModel {
	public $belongsTo = array(
		'OrderItem'
	);
}

class OrderItem extends TestModel {
	public $hasMany	= array(
		'Shipment'
	);

	public $belongsTo = array(
		'ActiveShipment' => array(
			'className' => 'Shipment',
			'foreignKey' => 'active_shipment_id',
		),
	);
}

class NewsArticle extends TestModel {
    public $hasAndBelongsToMany = array(
        'NewsCategory' => array(
            'className' => 'NewsCategory',
            'joinTable' => 'news_articles_news_categories',
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'category_id',
            'unique' => 'keepExisting',
        )
    );
}

class NewsCategory extends TestModel {
    public $hasAndBelongsToMany = array(
        'NewsArticle' => array(
            'className' => 'NewsArticle',
            'joinTable' => 'news_articles_news_categories',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'article_id',
            'unique' => 'keepExisting',
        )
    );
}