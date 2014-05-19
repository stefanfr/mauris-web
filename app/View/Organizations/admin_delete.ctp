<?php
/**
 * @var $organizations
 */

$this->Title->addSegment(__('Organizations'));
$this->Title->setPageTitle(__('Delete %1$s', $organization['School']['name']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($organization['School']['id'])
));


$this->set('title_for_layout', $this->Title->getPageTitle());
?>
<h1><?php echo h($this->Title->getPageTitle()) ?></h1>
<?php
echo $this->Form->create('School', array(
	'inputDefaults' => array(
		'div'       => 'form-group',
		'label'     => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class'     => 'form-control'
	),
	'class'         => 'form-horizontal'
));
?>
<div class="form-group">
	<?php
	echo $this->Form->submit(__('Delete'), array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-danger'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
