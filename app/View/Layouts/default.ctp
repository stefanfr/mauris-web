<!DOCTYPE html>
<html lang="en" itemscope="" itemtype="http://schema.org/<?=(isset($schema_type_for_layout)) ? $schema_type_for_layout : 'WebPage'?>">
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$title_for_layout; ?> - <?=$this->get('school_name')?><? if ($this->get('department_name')): ?> - <?=$this->get('department_name')?><?endif?></title>
  
	<!--  meta info -->
    <?=$this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'))?>
    <?=$this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'))?>
    <? if (isset($description_for_layout)): ?>
        <?=$this->Html->meta(array('name' => 'description', 'content' => $description_for_layout, 'itemprop' => 'description'))?>
    <? endif; ?>
    <? if (isset($keywords_for_layout)): ?>
        <?=$this->Html->meta('keywords', implode(', ', $keywords_for_layout))?>
    <? endif; ?>
    <?=$this->Html->meta(array('name' => 'author', 'content' => 'CVO-Technologies - 0100Dev'))?>
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
    echo $this->Html->script('respond.min.js');
	?>
  
	<!-- icons -->
	<?php
    echo $this->Html->meta('icon', $this->webroot.'img/favicon.ico');
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png'));
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png', 'sizes'=>'72x72'));
    echo $this->Html->meta(array('rel' => 'apple-touch-icon', 'href'=> $this->webroot.'img/apple-touch-icon.png', 'sizes'=>'114x114'));
	?>
        <meta name="application-name" content="<?=(isset($department_name)) ? $department_name : $school_name?>"/>
<meta name="msapplication-TileColor" content="#3351B5"/>
<meta name="msapplication-notification" content="frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=5; cycle=1"/>
<meta content="name=<?=__('Schedule')?>;
      action-uri=<?=Router::url(array('controller' => 'schedule'))?>" name="msapplication-task" />        

	<!-- page specific scripts -->
    <?=$scripts_for_layout; ?>
        
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
				<a class="navbar-brand" href="<?=$this->webroot; ?>"><?=(isset($department_name)) ? $department_name : $school_name?></a>
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
                                        <?=$this->Menu->item($this->Html->link(__('Organization'), array('controller' => 'pages', 'action' => 'display', 'organization'))); ?>
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
			<span class="pull-right"><?=$this->get('school_name')?><?if ($this->get('department_name')):?> (<?=$this->get('department_name')?>)<?endif?></span>
		</footer>
	</div>
	<?=((isset($loadingModal) && $loadingModal) ? $this->element('loadingModal') : ''); ?>
</body>
</html>
