<?php
/**
 * @var $style array
 */

$this->Title->addSegment(__('Styles'));
$this->Title->setPageTitle(__('Change %1$s', $style['Style']['title']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($style['Style']['id'])
));

$fieldsets = array(
	array(
		'title'  => __('Menu'),
		'fields' => array(
			'menu_background_color',
			'menu_text_color',
			'menu_link_color',
			'menu_hover_background_color',
			'menu_hover_link_color',
			'menu_brand_color',
			'menu_border_color',
			'menu_active_background_color',
			'menu_active_link_color',
			'menu_active_hover_background_color',
			'menu_active_hover_link_color'
		)
	),
	array(
		'title'  => __('Buttons'),
		'fields' => array(
			'button_background_color',
			'button_text_color',
			'button_hover_background_color',
			'button_hover_text_color',
			'button_active_background_color',
			'button_active_text_color'
		)
	),
	array(
		'title'  => __('Text'),
		'fields' => array(
			'text_color',
			'link_color'
		)
	)
);

$this->set('title_for_layout', $this->Title->getPageTitle());
?>
<h1><?php echo $this->Title->getPageTitle() ?></h1>
<?php
echo $this->Form->create('Style', array(
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
<?php
echo $this->Form->input('title');
echo $this->Form->input('school_id', array('empty' => 'None'));
echo $this->Form->input('base_style_id', array('empty' => 'None', 'options' => $styles));

foreach ($fieldsets as $fieldset):
	?>
	<fieldset>
		<legend><?php echo h($fieldset['title']) ?></legend>
		<?php
		foreach ($fieldset['fields'] as $index => $name):
			echo $this->Form->input($name);
		endforeach;
		?>
	</fieldset>
<?php
endforeach;

echo $this->Form->input('id', array('type' => 'hidden'));
?>
<div class="form-group">
	<?php
	echo $this->Form->submit('Change', array(
		'div'   => 'col col-md-9 col-md-offset-3',
		'class' => 'btn btn-default'
	));
	?>
</div>
<?php
echo $this->Form->end();
?>
