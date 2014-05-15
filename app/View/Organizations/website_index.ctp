<?php

$this->Title->setPageTitle(__('Organizations'));

$this->Title->addCrumbs(array(
	array(
		'plugin' => null,
		'action' => 'index'
	)
));
?>
<style>
	.organization-logo {
		width: 400px;
	}
</style>
<h1><?php echo h(__('Organizations')) ?></h1>
<div class="row">
	<?php
	foreach ($organizations as $organization):
		?>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<header class="panel-heading">
					<h2><?php echo h($organization['School']['name']) ?></h2>
				</header>
				<div class="panel-body">
					<?php
					if ($organization['School']['logo']):
						?>
						<?php echo $this->Html->image($organization['School']['logo'], array('class' => 'organization-logo')) ?>
					<?php
					endif;
					?>
				</div>

				<footer class="panel-footer announcement-bottom">
					<?php
					if ($organization['School']['hostname']):
						$url = 'http://' . $organization['School']['hostname'] . Router::url('/');
						?>
						<a href="<?php echo $url ?>" target="_blank">
							<div class="row">
								<div class="col-xs-7">
									<?php echo h(__('Go to')) ?>
								</div>
								<div class="col-xs-5 text-right">
									<?php echo h(__('Mauris homepage')) ?> <i class="fa fa-arrow-circle-right"></i>
								</div>
							</div>
						</a>
					<?php endif; ?>
					<a href="<?php echo Router::url(array('action' => 'view', $organization['School']['id'], Inflector::slug($organization['School']['name']))) ?>">
						<div class="row">
							<div class="col-xs-7">
								<?php echo h(__('Go to')) ?>
							</div>
							<div class="col-xs-5 text-right">
								<?php echo h(__('Information')) ?> <i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</a>
					<?php
					if ($organization['School']['website']):
						?>
						<a href="<?php echo $organization['School']['website'] ?>" target="_blank">
							<div class="row">
								<div class="col-xs-7">
									<?php echo h(__('Go to')) ?>
								</div>
								<div class="col-xs-5 text-right">
									<?php echo h(__('Website')) ?> <i class="fa fa-arrow-circle-right"></i>
								</div>
							</div>
						</a>
					<?php endif; ?>
				</footer>
			</div>
		</div>
	<?php
	endforeach;
	?>
</div>
<ul class="pagination">
	<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span')) ?>
</ul>