<?php
$this->Html->addCrumb(__('Contributions'), array('action' => 'index'));
$this->Html->addCrumb(__('Contribute'), $this->here);
?>
<h1><?php echo h(__('Contribute to %1$s', 'Mauris'))?></h1>
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
							<i class="fa fa-globe fa-5x"></i>
						</div>
						<div class="col-xs-10 text-right">
							<p class="announcement-heading">I18n</p>
						</div>
					</div>
				</div>
				<p><?php echo h(__('Help us bring %1$s to people around the globe by translating it to all kinds of languages', 'Mauris'))?></p>
				<a href="<?php echo Router::url(array('action' => 'info', 'i18n'))?>">
					<div class="panel-footer announcement-bottom">
						<div class="row">
							<div class="col-xs-10">
								<?php echo h(__('Learn more'))?>
							</div>
							<div class="col-xs-2 text-right">
								<i class="fa fa-arrow-circle-right"></i>
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
						<p class="announcement-heading">Code</p>
					</div>
				</div>
			</div>
			<p><?php echo h(__('Help us develop and improve %1$s by contributing code', 'Mauris'))?></p>
			<div class="panel-footer announcement-bottom">
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
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		
		</div>
	</div>
</div>