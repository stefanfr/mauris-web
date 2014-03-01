<?
$this->Html->addCrumb('Nieuws', array('controller' => 'posts', 'action' => 'index'));
$this->Html->addCrumb($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
$this->Html->addCrumb('Commentaar toevoegen', $this->here);
?>
<?php echo $this->Form->create('Comment'); ?>
    <fieldset>
        <legend><?php echo __('Voeg commentaar toe'); ?></legend>
        <?=$this->Form->hidden('post_id')?>
        <?=$this->Form->hidden('reply_to')?>
        <?=$this->Form->textarea('body')?>
    </fieldset>
<?php echo $this->Form->end(__('Plaats commentaar')); ?>