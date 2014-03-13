<?
$this->Html->addCrumb(__('Sitemaps'), array('action' => 'index')); 
$this->Html->addCrumb(__('Posts'), $this->here); 

$this->set('title_for_layout', __('Sitemaps') . ' - ' . __('Posts'));
?>
<h1><?=__('Sitemaps')?></h1>
<h2><?=__('Posts')?></h2>
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
