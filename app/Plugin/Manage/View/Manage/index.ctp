<div class="row">
	<div class="col-lg-3">
		<?php
		echo $this->element(
			'announcement',
			array(
				'heading' => $amount = 1,
				'text'    => __n('Organization', 'Organizations', $amount),
				'icon'    => 'fa-building-o',
				'link'    => array(
					'url'   => array('controller' => 'organizations'),
					'label' => __('View organizations')
				)
			)
		)
		?>
	</div>
	<div class="col-lg-3">
		<?php
		echo $this->element(
			'announcement',
			array(
				'type'    => 'warning',
				'heading' => $amount = 5,
				'text'    => __n('Absent teacher', 'Absent teachers', $amount),
				'icon'    => 'fa-' . (($amount == 1) ? 'user' : 'users'),
				'link'    => array(
					'url'   => array('controller' => 'teacher_absence'),
					'label' => __('View absent teachers')
				)
			)
		)
		?>
	</div>
	<div class="col-lg-3">
		<?php
		echo $this->element(
			'announcement',
			array(
				'type'    => 'info',
				'heading' => __('Cache'),
				'text'    => __('Cache'),
				'icon'    => 'fa-code',
				'link'    => array(
					'url'   => array('controller' => 'caches'),
					'label' => __('View cache information')
				)
			)
		)
		?>
	</div>
</div>