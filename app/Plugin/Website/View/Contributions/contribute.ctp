<?php
$this->Title->addSegment(__('Contributions'));
$this->Title->setPageTitle(__('Contribute to %1$s', 'Mauris'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
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
	<aside class="col-lg-3">
		<div class="row">
			<div class="col-xs-6 col-lg-12">
				<nav class="panel panel-primary">
					<header class="panel-heading">
						<div class="row">
							<div class="col-xs-2">
								<i class="fa fa-globe fa-5x"></i>
							</div>
							<div class="col-xs-10 text-right">
								<p class="announcement-heading">I18n</p>
							</div>
						</div>
					</header>
					<div class="panel-body">
						<p><?php echo h(__('Help us bring %1$s to people around the globe by translating it to all kinds of languages', 'Mauris'))?></p>
					</div>
					<footer class="panel-footer announcement-bottom">
						<a href="<?php echo Router::url(array('action' => 'info', 'i18n'))?>">
							<div class="row">
								<div class="col-xs-10">
									<?php echo h(__('Learn more'))?>
								</div>
								<div class="col-xs-2 text-right">
									<i class="fa fa-arrow-circle-right"></i>
								</div>
							</div>
						</a>
					</footer>
				</nav>
			</div>
			<div class="col-xs-6 col-lg-12">
				<nav class="panel panel-primary">
					<header class="panel-heading">
						<div class="row">
							<div class="col-xs-2">
								<i class="fa fa-code fa-5x"></i>
							</div>
							<div class="col-xs-10 text-right">
								<p class="announcement-heading">Code</p>
							</div>
						</div>
					</header>
					<div class="panel-body">
						<p><?php echo h(__('Help us develop and improve %1$s by contributing code', 'Mauris'))?></p>
					</div>
					<footer class="panel-footer announcement-bottom">
						<div class="row">
							<a href="<?php echo Router::url(array('action' => 'info', 'code'))?>">
								<div class="col-xs-10">
									<?php echo h(__('Learn more'))?>
								</div>
								<div class="col-xs-2 text-right">
									<i class="fa fa-arrow-circle-right"></i>
								</div>
							</a>
						</div>
					</footer>
				</nav>
			</div>
		</div>
	</aside>
</div>
