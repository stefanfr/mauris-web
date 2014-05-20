<?php
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle(__('Add post'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'add'),
));

echo $this->element('page_header');

echo $this->ModelForm->create('Post');

$scopes = array();
if (in_array('system', $allowed_scopes)) :
    $scopes['system'] = __('System wide');
endif;
if (in_array('school', $allowed_scopes)) :
    $scopes['school'] = __('School wide');
endif;
if (in_array('department', $allowed_scopes)) :
    $scopes['department'] = __('Department wide');
endif;
?>

<?=$this->Form->input('title')?>
<fieldset>
    <legend><?=__('Content')?></legend>
<?=$this->Form->input('summary', array('rows' => '3'))?>
<?=$this->Form->input('body', array('rows' => '5'))?>
<fieldset>
    <legend><?=__('Options')?></legend>
<?=$this->Form->input('scope', array(
        'options' => $scopes,
        'type' => 'select',
        'label' => __('Scope')
))?>
<?=$this->Form->input('published', array('options' => array(true => 'Yes', false => 'No'), 'type' => 'select', 'label' => 'Published'))?>
</fieldset>
<?=$this->Form->input('id', array('type' => 'hidden'))?>
<div class="form-group">
	<?php echo $this->Form->submit(__('Add'), array(
		'div' => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	)); ?>
</div>
<?php
echo $this->Form->end();
?>
