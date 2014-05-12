<?
$this->Html->css(
    'Billboard.billboard',
    array('block' => 'css')
);
$this->Html->scriptStart(array('block' => 'script'));
?>
var App = {};
App.fullBaseUrl = <?php echo json_encode(substr(Router::url('/'), 0, -1)); ?>;
<?php
$this->Html->scriptEnd();
$this->Html->script(
    'Billboard.billboard',
    array('block' => 'script')
);

// Copyright
$this->start('copyright');
?>
<span class="navbar-text navbar-right"><?php echo h(__('Copyright %d-%d ©', 2013, date('Y'))) ?> - CVO-Technologies & Dev App ("0100Dev")</span>
<?php
$this->end();

// Before container
$this->start('beforeContainer');
$this->end();

// Footer
$this->start('footer');
?>
<footer></footer>
<?php
$this->end();

// Right menu
$this->start('rightMenu');
echo $this->fetch('copyright');
$this->end();

// Brand
$this->start('brand');
?>
Mauris - Billboard
<?php
$this->end();

// Header
$this->start('header');
?>
<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
		<div class="row">
			<div class="col-md-5"><span class="navbar-brand"><? echo $this->fetch('brand') ?></span></div>
			<div class="col-md-2"><span class="navbar-brand time" id="clock"></span></div>
			<div class="col-md-5"><?php echo $this->fetch('rightMenu') ?></div>
		</div>
	</div>
</div>
<?php
$this->end();

$this->set('hideCrumb', true);

echo $this->fetch('content');

$this->extend('MaurisTheme.bootstrap');
