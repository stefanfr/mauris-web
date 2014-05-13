<?php
$title_for_layout = __('Cache configuration: %1$s', $configuration_name);

$this->Html->addCrumb(__('Caches'), array('action' => 'index'));
$this->Html->addCrumb($title_for_layout, $this->here);

function humanBoolean($boolean) {
	return ($boolean) ? __('Yes') : __('No');
}

?>
<h1><?php echo h($title_for_layout) ?></h1>
<ul>
	<li><b><?php echo h(__('Engine')) ?>:</b> <?php echo h($configuration['engine']) ?></li>
	<li>
		<b><?php echo h(__('Settings')) ?>:</b>
		<ul>
			<li><b><?php echo h(__('Prefix')) ?>:</b> <?php echo h($configuration['settings']['prefix']) ?></li>
			<li><b><?php echo h(__('Duration in seconds')) ?>
					:</b> <?php echo h($configuration['settings']['duration']) ?></li>
			<li><b><?php echo h(__('Engine')) ?>:</b> <?php echo h($configuration['settings']['engine']) ?></li>
			<li><b><?php echo h(__('Path')) ?>:</b> <?php echo h($configuration['settings']['path']) ?></li>
			<li><b><?php echo h(__('Lock')) ?>:</b> <?php echo h(humanBoolean($configuration['settings']['lock'])) ?>
			</li>
			<li><b><?php echo h(__('Serialize')) ?>
					:</b> <?php echo h(humanBoolean($configuration['settings']['serialize'])) ?></li>
			<li><b><?php echo h(__('Windows')) ?>
					:</b> <?php echo h(humanBoolean($configuration['settings']['isWindows'])) ?></li>
			<li><b><?php echo h(__('Mask')) ?>:</b> <?php echo h($configuration['settings']['mask']) ?></li>
			<li><b><?php echo h(__('Propability')) ?>:</b> <?php echo h($configuration['settings']['probability']) ?>
			</li>
		</ul>
	</li>
</ul>