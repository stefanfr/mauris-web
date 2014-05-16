<?php
/**
 * @var $style ['Style']
 */

$this->Title->addSegment(__('Styles'));
$this->Title->setPageTitle(__('View %1$s', $style['Style']['title']));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array($style['Style']['id'])
));


$this->set('title_for_layout', $this->Title->getPageTitle());
?>
<style>
	.navbar-default {
		background-color: # <?=$style['Style']['menu_background_color']?>;
		border-color: # <?=$style['Style']['menu_border_color']?>;
	}

	.navbar-default .navbar-brand {
		color: # <?=$style['Style']['menu_brand_color']?>;
	}

	.navbar-default .navbar-text {
		color: # <?=$style['Style']['menu_text_color']?>;
	}

	.navbar-default .navbar-nav > li > a {
		color: # <?=$style['Style']['menu_link_color']?>;
	}

	.navbar-default .navbar-brand:hover, .navbar-default .navbar-nav > li > a:hover {
		color: # <?=$style['Style']['menu_hover_link_color']?>;
		background-color: # <?=$style['Style']['menu_hover_background_color']?>;
	}

	.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
		color: # <?=$style['Style']['menu_active_link_color']?>;
		background-color: # <?=$style['Style']['menu_active_background_color']?>;
	}

	.navbar-default .navbar-nav > .active > a:hover {
		color: # <?=$style['Style']['menu_active_hover_link_color']?>;
		background-color: # <?=$style['Style']['menu_active_hover_background_color']?>;
	}

	a {
		color: # <?=$style['Style']['link_color']?>;
	}

	body {
		color: # <?=$style['Style']['text_color']?>;
	}

	.btn-default, .btn-primary {
		color: # <?=$style['Style']['button_text_color']?>;
		background-color: # <?=$style['Style']['button_background_color']?>;
		border-color: # <?=$style['Style']['button_background_color']?>;
	}

	.btn-default:hover, .btn-default:focus, .btn-primary:hover, .btn-primary:focus {
		color: # <?=$style['Style']['button_hover_text_color']?>;
		background-color: # <?=$style['Style']['button_hover_background_color']?>;
	}

	.btn-default:active, .btn-default.active, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-default {
		color: # <?=$style['Style']['button_active_text_color']?>;
		background-color: # <?=$style['Style']['button_active_background_color']?>;
	}

	.pagination > li > a, .pagination > li > span {
		color: # <?=$style['Style']['button_text_color']?>;
		background-color: # <?=$style['Style']['button_background_color']?>;
	}

	.pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
		color: # <?=$style['Style']['button_hover_text_color']?>;
		background-color: # <?=$style['Style']['button_hover_background_color']?>;
	}

	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
		color: # <?=$style['Style']['button_active_text_color']?>;
		background-color: # <?=$style['Style']['button_active_background_color']?>;
	}
</style>
<h1><?php echo $this->Title->getPageTitle() ?></h1>
<div class="well">
	<p>
		<?php echo h(__('The style is being applied to this page')) ?>
	</p>
</div>
<?php
echo $this->Html->link(
	__('%1$s Edit', '<span class="glyphicon glyphicon-pencil"></span>'),
	array('action' => 'edit', $style['Style']['id']),
	array('class' => 'btn btn-default', 'escape' => false)
)
?>
</td>