<!DOCTYPE html>
<html lang="en">
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$this->get('school_name')?> - <?=$this->get('department_name')?> - <?=$title_for_layout; ?></title>
  
	<!--  meta info -->
	<?php
    echo $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'));
    echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'));
    echo $this->Html->meta(array('name' => 'description', 'content' => 'this is the description'));
    echo $this->Html->meta(array('name' => 'author', 'content' => 'CVO-Technologies - 0100Dev'));
	?>
  
	<!-- styles -->
	<?php
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('custom.bootstrap');
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
    
    <?php if($this->fetch('additionalStyle') != ''): ?>
    <!-- additional style -->
    <style>
		<?=$this->fetch('additionalStyle'); ?>
    </style>
    <?php endif; ?>
    
    <style>
        .navbar-default, .btn-primary {
            background-color: #<?=$this->get('header_background_color')?>;
            border-color: #<?=$this->get('header_border_color')?>;
        }
        .navbar-default .navbar-brand {
            color: #<?=$this->get('header_brand_color')?>;
        }
        .navbar-default .navbar-text {
            color: #<?=$this->get('header_text_color')?>;
        }
        .navbar-default .navbar-nav>li>a {
            color: #<?=$this->get('header_link_color')?>;
        }
        .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus {
            color: #<?=$this->get('header_active_link_color')?>;
            background-color: #<?=$this->get('header_active_background_color')?>;
        }
        a {
            color: #<?=$this->get('link_color')?>;
        }
        body {
            color: #<?=$this->get('text_color')?>;
        }
    </style>
</head>
<body>
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
	
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=$this->webroot; ?>"><?=$this->get('department_name')?></a>
			</div>
			<div class="navbar-collapse collapse">
				<?=$this->fetch('leftMenu'); ?>
				<ul class="nav navbar-nav">
					<?=$this->Menu->item($this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-home')), '/home', array('escapeTitle' => false))); ?>
                                        <?=$this->Menu->item($this->Html->link(__('News'), array('controller' => 'posts', 'action' => 'index'))); ?>
					<?=$this->Menu->item($this->Html->link(__('Schedule'), array('controller' => 'schedule'))); ?>
                                        <? if ($can_manage): ?>
                                            <?=$this->Menu->item($this->Html->link(__('Manage'), array('plugin' => 'manage', 'controller' => 'manage', 'action' => 'index'))); ?>
                                        <? endif; ?>
				</ul>
				<?=$this->startIfEmpty('rightMenu'); ?>
                                <? if (AuthComponent::user('id')): ?>
                                <p class="navbar-text navbar-right"><?=h(__('Logged in as %s', $this->App->buildName(AuthComponent::user())))?></p>
                                <? else: ?>
                                <?
                                    echo $this->Form->create(
                                        'User',
                                        array(
                                            'inputDefaults' => array(
                                                'label' => false,
                                                'div' => array(
                                                  'class' => 'form-group'
                                                ),
                                                'class' => 'form-control'
                                            ),
                                            'url' => array(
                                                'controller' => 'users',
                                                'action' => 'login'
                                            ),
                                            'class' => 'navbar-form navbar-right'
                                        )
                                    );
                                ?>
                                <?=$this->Form->input('username', array('placeholder' => __('Username')))?>
                                <?=$this->Form->input('password', array('placeholder' => _('Password')))?>
                                <? 
                                    echo $this->Form->end(array('div' => 'form-group', 'class' => 'btn btn-default'));
                                ?>
				<!--<form class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Gebruikersnaam" />
						<input type="password" class="form-control" placeholder="Wachtwoord" />
					</div>
				</form>-->
                                <? endif; ?>
				<?=$this->end(); ?>
				<?=$this->fetch('rightMenu'); ?>
			</div>
		</div>
	</div>
	
	<?=$this->fetch('beforeContainer'); ?>
	
	<div class="container">		
        <?=((isset($hideCrumb) && $hideCrumb) ? '' : $this->Html->getCrumbList(array('class' => 'breadcrumb', 'firstClass' => false, 'lastClass' => 'active'), 'Home')); ?>
        
		<?=$this->Session->flash(); ?>	
		
        <?=$content_for_layout; ?>
	
		<hr>
		<footer>
			<span><?=h(__('Copyright %d-%d ©', 2013, date('Y'))) . ' - '.  $this->Html->link('CVO-Technologies', 'http://mms-projects.net/', array('target' => '_BLANK')); ?> & <?=$this->Html->link('Dev App ("0100Dev")', 'http://devapp.nl/', array('target' => '_BLANK')); ?></span>
			<span class="pull-right"><?=$this->get('school_name')?> (<?=$this->get('department_name')?>)</span>
		</footer>
	</div>
	<?=((isset($loadingModal) && $loadingModal) ? $this->element('loadingModal') : ''); ?>
</body>
</html>
