<?php
$panelClasses = array('panel');
if (!isset($type)) {
	$type = 'primary';
}
if ($type) {
	$panelClasses[] = 'panel-' . $type;
}
?>
<div class="<?php echo implode(' ', $panelClasses) ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-2">
				<i class="fa <?php echo $icon; ?> fa-5x"></i>
			</div>
			<div class="col-xs-10 text-right">
				<p class="announcement-heading"><?php echo h($heading); ?></p>
				<p class="announcement-text"><?php echo h($text); ?></p>
			</div>
		</div>
	</div>
	<?php if ((isset($link)) && ($link)): ?>
		<a href="<?php echo Router::url($link['url']); ?>">
			<div class="panel-footer announcement-bottom">
				<div class="row">
					<div class="col-xs-10">
						<?php echo h($link['label']); ?>
					</div>
					<div class="col-xs-2 text-right">
						<i class="fa fa-arrow-circle-right"></i>
					</div>
				</div>
			</div>
		</a>
	<?php endif; ?>
</div>