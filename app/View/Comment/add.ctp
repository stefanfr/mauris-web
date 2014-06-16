<?php
$this->Title->addSegment(__('News'));
$this->Title->addSegment($post['Post']['title']);
$this->Title->setPageTitle(__('Add comment'));

$this->Title->addCrumbs(array(
	array('controller' => 'posts', 'action' => 'index'),
	array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
	$this->here
));

if (!$this->request->is('ajax')):
	echo $this->element('page_header');
endif;

echo $this->ModelForm->create('Comment');

echo $this->Form->input('body');
?>
	<div class="form-group">
		<?php echo $this->Form->submit(__('Add comment'), array(
			'div'   => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php
echo $this->Form->end();