<?php
$this->Title->setSeparator(' - ');
$this->Title->setSiteTitle($this->Naming->title());

$this->element('Parts/copyright');

$this->element('Parts/NavbarElements/brand');
$this->element('Parts/NavbarElements/right_menu');
?>
<!DOCTYPE html>
<html lang="en" itemscope="" itemtype="http://schema.org/<?php echo (isset($schema_type_for_layout)) ? $schema_type_for_layout : 'WebPage'?>">
	<head>
		<?php
		echo $this->Html->charset();
		echo $this->Title->title();
		?>

		<!--  meta info -->
		<?php
		echo $this->Html->meta(array(
			'http-equiv' => 'X-UA-Compatible',
			'content'    => 'IE=edge'
		));
		echo $this->Html->meta(array(
			'name'    => 'viewport',
			'content' => 'width=device-width, initial-scale=1'
		));
		if (isset($description_for_layout)):
			$this->Html->meta(array(
				'name'     => 'description',
				'content'  => $description_for_layout,
				'itemprop' => 'description'
			));
		endif;
		if (isset($keywords_for_layout)):
			$this->Html->meta(
				'keywords',
				implode(', ', $keywords_for_layout)
			);
		endif;
		echo $this->Html->meta(array(
			'name'    => 'author',
			'content' => 'CVO-Technologies - 0100Dev'
		));

		echo $this->fetch('meta');
		?>

		<!-- styles -->
		<?php
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('custom.bootstrap');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css(Router::url(
			array(
				'plugin'     => 'api',
				'controller' => 'style',
				'ext'        => 'css'
			)
		));

		echo $this->fetch('css');
		?>

		<!-- scripts -->
		<?php
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('respond.min.js');
		?>

		 <!-- page specific scripts -->
		<?php
		echo $this->fetch('script');
		?>

		<!-- icons -->
		<?php
		echo $this->Html->meta('icon', $this->webroot . 'img/favicon.ico');
		echo $this->Html->meta(array(
			'rel' => 'apple-touch-icon',
			'href'=> $this->webroot . 'img/apple-touch-icon.png'
		));
		echo $this->Html->meta(array(
			'rel'  => 'apple-touch-icon',
			'href' => $this->webroot . 'img/apple-touch-icon.png',
			'sizes'=>'72x72'
		));
		echo $this->Html->meta(array(
			'rel'  => 'apple-touch-icon',
			'href' => $this->webroot . 'img/apple-touch-icon.png',
			'sizes'=> '114x114'
		));
		?>

		<!-- Microsoft stuff -->
		<?php
		echo $this->Html->meta(array(
			'name'    => 'application-name',
			'content' => $this->Naming->brand()
		));
		echo $this->Html->meta(array(
			'name'    => 'msapplication-TileColor',
			'content' => '#3351B5'
		));
		echo $this->Html->meta(array(
			'name'    => 'msapplication-notification',
			'content' => 'frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=http://ictcollege.eu/posts.rss&amp;id=5; cycle=1'
		));
		echo $this->Html->meta(array(
			'name'    => 'msapplication-task',
			'content' => 'name=' . __('Schedule') . ';action-uri=' . Router::url(array('controller' => 'schedule'))
		));
		?>

		<?php
		if ($this->fetch('additionalStyle') != ''):
		?>
		<!-- additional style -->
		<style>
			<?php
			echo $this->fetch('additionalStyle');
			?>
		</style>
		<?php
		endif;
		?>
	</head>
	<body>
		<? if (Configure::read('debug') == 0): ?>
		<!-- Google Tag Manager -->
		<noscript>
			<iframe
				src="//www.googletagmanager.com/ns.html?id=GTM-WJVJJD"
				height="0"
				width="0"
				style="display:none;visibility:hidden">
			</iframe>
		</noscript>
		<?php
		$this->Html->scriptStart();
		?>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-WJVJJD');
		<?php
		echo $this->Html->scriptEnd();
		?>
		<!-- End Google Tag Manager -->
		<? endif; ?>

		<?php
		$this->startIfEmpty('header');
		?>
		<header class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php
					echo $this->fetch('brand');
					?>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<?php
						if (CakePlugin::loaded('Website')):
							$homeRoute = array(
								'plugin'  => null,
								'controller' => 'home',
								'action'  => 'index',
								'website' => true
							);
						else:
							$homeRoute = '/';
						endif;
						$this->append(
							'left_menu',
							$this->Menu->item($this->Html->link(
								$this->Html->tag('span', '', array(
									'class' => 'glyphicon glyphicon-home')
								),
								$homeRoute,
								array('escapeTitle' => false)
							)
						));
						$this->append(
							'left_menu',
							$this->Menu->item($this->Html->link(
								__('News'),
								array(
									'plugin'     => null,
									'controller' => 'posts',
									'action'  => 'index',
									'website' => false
								)
							)
						));

						if (CakePlugin::loaded('Schedule')):
							$this->append(
								'left_menu',
								$this->Menu->item($this->Html->link(
									__('Schedule'),
									array(
										'plugin'     => 'schedule',
										'controller' => 'schedule'
									)
								)
							));
						endif;
						if ($can_manage):
							$this->append(
								'left_menu',
								$this->Menu->item($this->Html->link(
									__('Manage'),
									array(
										'plugin'     => null,
										'controller' => 'home',
										'action'     => 'index',
										'manage'     => true
									)
								)
							));
						endif;

						$this->append(
							'left_menu',
							$this->Menu->item($this->Html->link(
								__('Organization'),
								array(
									'plugin'     => null,
									'controller' => 'pages',
									'action'     => 'display',
									'organization'
								)
							)
						));

						echo $this->fetch('left_menu');
						?>
					</ul>
					<?php
					$rightMenuBlock = $this->fetch('rightMenu'); // Deprecated
					if ($rightMenuBlock) {
						CakeLog::warning(__('Block \'%1$s\' is deprecated! Use right_menu instead.', 'rightMenu'), 'view');

						$this->assign('right_menu', $rightMenuBlock); // Assign the content to the new block
					}
					echo $this->fetch('right_menu');
					?>
				</div>
			</div>
		</header>
		<?php
		$this->end();
		echo $this->fetch('header');
		?>

		<?php
		echo $this->fetch('beforeContainer');
		?>

		<div class="container">
			<?php
			if (!(isset($hideCrumb) && $hideCrumb)):
				echo $this->Html->getCrumbList(
					array(
						'class'      => 'breadcrumb',
						'firstClass' => false,
						'lastClass'  => 'active'
					),
					'Home'
				);
			endif;

			echo $this->Session->flash();
			echo $this->fetch('content');
			?>

			<!-- Footer -->
			<?php
			echo $this->element('Parts/footer');
			?>
		</div>
		<?php
		if ((isset($loadingModal) && $loadingModal)):
			echo $this->element('loadingModal');
		endif;
		?>
	</body>
</html>
