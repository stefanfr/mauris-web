<?
$this->Title->addSegment(__('Sitemaps'));
$this->Title->setPageTitle(__('Pages'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<p>
<?=__('For a nicer news overview go to the news page.')?><br>
<?=$this->Html->link(__('Click here'), array('controller' => 'posts', 'action' => 'index'))?>
</p>
<ul>
    <?php foreach ($posts as $post):?>
    <li>
        <?=$this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], Inflector::slug($post['Post']['title'])))?>
    </li>
    <?php endforeach; ?>
</li>
