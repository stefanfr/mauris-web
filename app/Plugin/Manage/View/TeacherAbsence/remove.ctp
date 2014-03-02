<?
$this->Html->addCrumb(__('Teacher absence'), array('action' => 'index')); 
$this->Html->addCrumb(
    __('Remove absence report'),
    $this->here
);
?>
<h1><?=h(__('Remove absence report'))?></h1>
<?
echo $this->Form->postButton(
    '<span class="glyphicon glyphicon-trash"></span> ' . h(__('Remove')),
    array($id),
    array(
        'class' => 'btn btn-default',
    )
);
?>
