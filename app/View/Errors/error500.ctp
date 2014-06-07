<div class="panel panel-danger">
	<div class="panel-heading">
		<h1><?php echo __('It appears something bad has happened :-('); ?></h1>
	</div>
	<div class="panel-body">
		<?php
		if (Configure::read('debug') == 0):
			if (stristr($message, 'database')):
				$name = __('Apparently our database is having trouble?');
			endif;
		endif;
		?>
		<h2><?php echo $name; ?></h2>
		<p>
			<?php echo $message; ?>
		</p>
		<?php if (Configure::read('debug') > 0): ?>
			<p>
				<?php echo $this->element('exception_stack_trace'); ?>
			</p>
		<?php endif; ?>
	</div>
</div>
