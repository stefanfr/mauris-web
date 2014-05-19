<?
$this->Title->setPageTitle(__('Sitemaps'));

$this->Title->addCrumbs(array(
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<p><?=__('The following sitemaps are available:')?></p>
<ul>
    <? foreach ($sitemaps as $sitemap): ?>
        <li><?=$this->Html->link(Inflector::humanize($sitemap), array('action' => 'view', $sitemap))?></li>
    <? endforeach; ?>
</ul>