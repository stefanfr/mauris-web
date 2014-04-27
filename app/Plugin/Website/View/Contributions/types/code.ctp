<?php
$this->Html->addCrumb(__('Contributions'), array('action' => 'index'));
$this->Html->addCrumb(__('Contribute'), array('action' => 'contribute'));
$this->Html->addCrumb(__('Code'), $this->here);
?>
<div class="row">
	<main class="col-lg-9">
		<div class="well">
			<?php echo h(__('Nothing yet?'))?>
		</div>
	</main>
	<div class="col-lg-3">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<i class="fa fa-calendar fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<p class="announcement-heading"><?php echo h(__('Issues'))?></p>
						</div>
					</div>
				</div>
				<p><?php echo h(__('Contribute to %1$s by helping with translations, code and other things', 'Mauris'))?></p>
				<a href="http://redmine.cvo-technologies.com/projects/schedule-system-website" target="_blank">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-7">
								<?php echo h(__('Go to'))?>
							</div>
							<div class="col-xs-5 text-right">
								Redmine <i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<i class="fa fa-code fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<p class="announcement-heading"><?php echo h(__('Repo'))?></p>
						</div>
					</div>
				</div>
				<p><?php echo h(__('Contribute to %1$s by helping with translations, code and other things', 'Mauris'))?></p>
				<a href="https://github.com/MMS-Projects/mauris-web" target="_blank">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-7">
								<?php echo h(__('Go to'))?>
							</div>
							<div class="col-xs-5 text-right">
								GitHub <i class="fa fa-arrow-circle-right"></i>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>