<?php

$this->Title->setPageTitle('Mauris Systems');

$this->Seo->setDescription(__('Easy to use scheduling and information providing software for educational institutions'));
$this->Seo->setKeywords(
	array('Mauris', 'Mauris Systems', 'Schedules', 'information', 'education institutions')
);

echo $this->element('page_header');
?>
<div class="row">
	<div class="col-sm-12 col-lg-9">
		<h1><?php echo h(__('What is Mauris?')); ?></h1>
		<p>
			<?php echo h(__('Mauris is scheduling and information spreading software for educational institutions looking to improve communications in their organization. Our software allows students, teachers and the staff of the institute to get the information they need for their job with ease in a timely fashion.')); ?>
		</p>
	</div>
	<div class="col-sm-12 col-lg-3">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<div class="row">
					<div class="col-xs-2">
						<i class="fa fa-users fa-5x"></i>
					</div>
					<div class="col-xs-10 text-right">
						<p class="announcement-heading">Help</p>
					</div>
				</div>
			</header>
			<div class="panel-body">
				<p><?php echo h(__('Contribute to %1$s by helping with translations, code and other things', 'Mauris')) ?></p>
			</div>
			<footer class="panel-footer announcement-bottom">
				<a href="<?php echo Router::url(array('controller' => 'contributions')) ?>">
					<div class="row">
						<div class="col-xs-10">
							<?php echo h(__('Learn more')) ?>
						</div>
						<div class="col-xs-2 text-right">
							<i class="fa fa-arrow-circle-right"></i>
						</div>
					</div>
				</a>
			</footer>
		</div>
	</div>
</div>