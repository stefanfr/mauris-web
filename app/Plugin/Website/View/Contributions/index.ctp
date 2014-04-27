<?php
$this->Html->addCrumb(__('Contributions'), $this->here);
?>
<div class="row">
	<main class="col col-sm-9">
		<div class="row">
			<div class="col col-sm-12">
				<section class="panel panel-primary">
					<header class="panel-heading">
						<h2><?php echo h(__('Want to contribute?'))?></h2>
					</header>
					<?php echo h(__('Want to contribute to %1$s? Click on \'%2$s\' for more information.', 'Mauris', __('Learn more'))) ?>
					<footer class="panel-footer">
						<a href="<?php echo Router::url(array('action' => 'contribute'))?>">
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
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col col-sm-12">
				<div class="well">
					<ul class="media-list">
						<?php foreach ($contributers as $contributer): ?>
						<li class="media" itemprop="comment" itemscope="" itemtype="http://schema.org/UserComments">
							<div class="media-body">
								<a class="pull-left" href="<?php echo $contributer['profile']?>" target="_blank">
									<header class="media-heading" itemprop="creator" itemscope="" itemtype="http://schema.org/Person">
										<div class="thumbnail"><?php echo $this->Gravatar->gravatar($contributer['gravatar_id'])?></div>
										<span itemprop="name"><?php echo $contributer['username']?></span>
									</header>
								</a>
								<span style="font-size: 3em;">Contributions: <?php echo $contributer['contributions']?></span>
								<div class="pull-right">
									<span class="fa fa-<?php echo $contributer['source']?> fa-5x"></span>
								</div>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</main>
	<div class="col col-sm-3">
		<div class="row">
			<section class="panel panel-primary">
				<header class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<i class="fa fa-code fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<h2><?php echo h(__('Contribute code'))?></h2>
						</div>
					</div>
				</header>

				<footer class="panel-footer">
					<a href="<?php echo Router::url(array('action' => 'info', 'code'))?>">
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
			</section>
		</div>
		<div class="row">
			<section class="panel panel-primary">
				<header class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<i class="fa fa-globe fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<h2><?php echo h(__('Contribute translations'))?></h2>
						</div>
					</div>
				</header>

				<footer class="panel-footer">
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
			</section>
		</div>
	</div>
</div>