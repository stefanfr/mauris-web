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

echo $this->element('page_header');

echo $this->ModelForm->create('School');
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
