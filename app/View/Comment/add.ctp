<?
$this->Html->addCrumb(__('News'), array('controller' => 'posts', 'action' => 'index'));
$this->Html->addCrumb($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
$this->Html->addCrumb(__('Add comment'), $this->here);
?>
<?php echo $this->Form->create('Comment'); ?>
    <fieldset>
        <legend><?php echo __('Add comment'); ?></legend>
        <?=$this->Form->hidden('post_id')?>
        <?=$this->Form->hidden('reply_to')?>
        <?=$this->Form->textarea('body')?>
    </fieldset>
<?php echo $this->Form->end(__('Add comment')); ?>