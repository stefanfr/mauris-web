<?
$this->Title->addSegment(__('Sitemaps'));
$this->Title->setPageTitle(__('Pages'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<ul>
    <?php foreach ($pages as $page):?>
    <li>
        <?=$this->Html->link($page['Page']['title'], array('controller' => 'pages', 'action' => 'show', $page['Page']['id'], Inflector::slug($page['Page']['title'])))?>
    </li>
    <?php endforeach; ?>
</li>
