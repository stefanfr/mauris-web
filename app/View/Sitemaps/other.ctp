<?
$this->Html->addCrumb(__('Sitemaps'), array('action' => 'index')); 
$this->Html->addCrumb(__('Other'), $this->here); 

$this->set('title_for_layout', __('Sitemaps') . ' - ' . __('Other'));
?>
<h1><?=__('Sitemaps')?></h1>
<h2><?=__('Other')?></h2>
<ul>
    <?php foreach ($pages as $page):?>
    <li>
        <?=$this->Html->link($page['title'], $page['route'])?>
    </li>
    <?php endforeach; ?>
</li>
