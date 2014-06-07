<div class="panel panel-danger">
	<div class="panel-heading">
		<h1><?php echo __('It appears something bad has happened :-('); ?></h1>
	</div>
	<div class="panel-body">
		<h2><?php echo $name; ?></h2>
		<?php
		if (Configure::read('debug') > 0):
			echo $this->element('exception_stack_trace');
		endif;
		?>
	</div>
</div>
