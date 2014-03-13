<?
$this->Html->addCrumb(__('Sitemaps'), $this->here); 
?>
<h1><?=__('Sitemaps')?></h1>
<p><?=__('The following sitemaps are available:')?></p>
<ul>
    <? foreach ($sitemaps as $sitemap): ?>
        <li><?=$this->Html->link(Inflector::humanize($sitemap), array('action' => 'view', $sitemap))?></li>
    <? endforeach; ?>
</ul>