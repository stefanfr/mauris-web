<?php
$this->Title->setSeparator(' - ');
$this->Title->setSiteTitle(__('%1$s - Installer', 'Mauris'));

$this->element('Parts/copyright');

$this->startIfEmpty('brand');
echo $this->Html->link($this->Title->getSiteTitle(),
	'/', array('class' => 'navbar-brand')
);
$this->end();

$this->startIfEmpty('footer');
?>
<hr>
<footer>
	<span>
		<?php echo $this->fetch('copyright'); ?>
	</span>
	<span class="pull-right">
		<?php echo h('Mauris') ?>
	</span>
</footer>
<?php
$this->end();
?>
<!DOCTYPE html>
<html lang="en" itemscope=""
      itemtype="http://schema.org/<?php echo (isset($schema_type_for_layout)) ? $schema_type_for_layout : 'WebPage' ?>">
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
	echo $this->Html->script('install');
	?>

	<!-- page specific scripts -->
	<?php
	echo $this->fetch('script');
	?>
</head>
<body>

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
				$this->append(
					'left_menu',
					$this->Menu->item($this->Html->link(
							$this->Html->tag('span', '', array(
									'class' => 'glyphicon glyphicon-home')
							),
							array(
								'plugin'     => 'install',
								'controller' => 'install'
							),
							array('escapeTitle' => false)
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

<div class="container">
	<?php
	if (!(isset($hideCrumb) && $hideCrumb)):
		echo $this->Html->getCrumbList(
			array(
				'class'      => 'breadcrumb',
				'firstClass' => false,
				'lastClass'  => 'active'
			),
			__('Installer')
		);
	endif;

	echo $this->Session->flash();
	echo $this->fetch('content');
	?>
	<!-- Footer -->
	<?php echo $this->fetch('footer') ?>
</div>

</body>
</html>

