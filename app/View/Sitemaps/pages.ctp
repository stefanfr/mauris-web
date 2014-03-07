<?
$this->Html->addCrumb(__('Sitemaps'), array('action' => 'index')); 
$this->Html->addCrumb(__('Pages'), $this->here); 

$this->set('title_for_layout', __('Sitemaps') . ' - ' . __('Pages'));
?>
<h1><?=__('Sitemaps')?></h1>
<h2><?=__('Pages')?></h2>
<ul>
    <?php foreach ($pages as $page):?>
    <li>
        <?=$this->Html->link($page['Page']['title'], array('controller' => 'pages', 'action' => 'show', $page['Page']['id'], Inflector::slug($page['Page']['title'])))?>
    </li>
    <?php endforeach; ?>
</li>
