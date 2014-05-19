<?
$this->Title->addSegment(__('Sitemaps'));
$this->Title->setPageTitle(__('Other'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<ul>
    <?php foreach ($pages as $page):?>
    <li>
        <?=$this->Html->link($page['title'], $page['route'])?>
    </li>
    <?php endforeach; ?>
</li>
