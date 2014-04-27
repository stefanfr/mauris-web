<h1><?php echo h(__('Welcome to %1$s', 'Mauris'))?></h1>
<div class="row">
	<div class="col-lg-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-2">
						<i class="fa fa-users fa-5x"></i>
					</div>
					<div class="col-xs-10 text-right">
						<p class="announcement-heading">Help</p>
					</div>
				</div>
			</div>
			<p><?php echo h(__('Contribute to %1$s by helping with translations, code and other things', 'Mauris'))?></p>
			<a href="<?php echo Router::url(array('controller' => 'contributions'))?>">
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
</div>