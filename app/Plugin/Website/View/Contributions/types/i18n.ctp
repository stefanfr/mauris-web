<?php
$this->Title->addSegment(__('Contributions'));
$this->Title->addSegment(__('Contribute'));
$this->Title->setPageTitle(__('Contribute i18n'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	array('action' => 'contribute'),
	$this->here
));
?>
<h1><?php echo h($this->Title->getPageTitle())?></h1>
<div class="row">
	<main class="col-lg-9">
		<div class="well">
			<?php echo h(__('Nothing yet?'))?>
		</div>
	</main>
	<div class="col-lg-3">
		<div class="row">
			<nav class="panel panel-primary">
				<header class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<i class="fa fa-globe fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<p class="announcement-heading"><?php echo h(__('I18n'))?></p>
						</div>
					</div>
				</header>
				<div class="panel-body">
					<p><?php echo h(__('Go to %2$s to help translate %1$s easily without having work on the code directly', 'Mauris', 'Weblate'))?></p>
					<a href="http://weblate.cvo-technologies.com/engage/mauris/?utm_source=widget" target="_blank">
						<?php
						echo $this->Html->image(
							'http://weblate.cvo-technologies.com/widgets/mauris-287x66-white.png',
							array(
								'width' => '287px',
								'height' => '66px',
								'alt' => __('Mauris translation status')
							)
						);
						?>
					</a>
				</div>
				<footer class="panel-footer announcement-bottom">
					<a href="http://weblate.cvo-technologies.com/engage/mauris/" target="_blank">
						<div class="row">
							<div class="col-xs-7">
								<?php echo h(__('Go to'))?>
							</div>
							<div class="col-xs-5 text-right">
								Weblate <i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</a>
				</footer>
			</nav>
		</div>
	</div>
</div>