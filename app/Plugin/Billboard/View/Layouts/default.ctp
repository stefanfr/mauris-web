<!DOCTYPE html>
<html lang="en">
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$this->get('school_name')?> - <?=$this->get('department_name')?> - <?=$title_for_layout; ?></title>
  
	<!--  meta info -->
	<?php
    echo $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'));
    echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=600px, initial-scale=1'));
    echo $this->Html->meta(array('name' => 'description', 'content' => 'this is the description'));
    echo $this->Html->meta(array('name' => 'author', 'content' => '0100Dev - CVO-Technologies'));
	?>
  
	<!-- styles -->
	<?php
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('custom.bootstrap');
    echo $this->Html->css(Router::url(array('plugin' => 'api', 'controller' => 'style', 'ext' => 'css')));
	?>
  
	<!-- scripts -->
	<?php
    echo $this->Html->script('jquery.min');
    echo $this->Html->script('bootstrap.min');
	?>
  
	<!-- icons -->
	<?php
    echo $this->Html->meta('icon', $this->webroot.'img/favicon.ico');
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png'));
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png', 'sizes'=>'72x72'));
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png', 'sizes'=>'114x114'));
	?>
        
	<!-- page specific scripts -->
    <?=$scripts_for_layout; ?>
    <?=$this->fetch('script')?>
    <?=$this->fetch('css')?>
    <?php if($this->fetch('additionalStyle') != ''): ?>
    <!-- additional style -->
    <style>
		<?=$this->fetch('additionalStyle'); ?>
    </style>
    <?php endif; ?>
</head>
<body>
    <? if (Configure::read('debug') == 0): ?>
    <!-- Google Tag Manager -->
	<noscript>
		<iframe src="//www.googletagmanager.com/ns.html?id=GTM-WJVJJD" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-WJVJJD');
	</script>
	<!-- End Google Tag Manager -->
        <? endif; ?>
	
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					</button>
				<span class="navbar-brand"><?=($this->get('department_name')) ? $this->get('department_name') : $this->get('school_name')?> - <?=__('Billboard')?></span>
			</div>
			<div class="navbar-collapse collapse">
				<p class="nav navbar-text navbar-right">Copyright 2013 - <?=date('Y'); ?> &copy; CVO-Technologies &amp; Dev App ("0100Dev")</p>
			</div>
		</div>
	</div>
	
	<?=$this->fetch('beforeContainer'); ?>
	
	<div class="container">	
        <?=$content_for_layout; ?>
	</div>
	
	<?=((isset($loadingModal) && $loadingModal) ? $this->element('loadingModal') : ''); ?>
</body>
</html>
