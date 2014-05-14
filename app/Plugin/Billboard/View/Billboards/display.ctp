<?php
if (!empty($billboard)) {
	$configuration =  array_diff_key($billboard['Billboard'], array_flip(array(
		'organization_id', 'location_id', 'department_id'
	)));
} else {
	$configuration = array(
		'location'   => __('Unknown'),
		'title'      => __('Billboard'),
		'show_clock' => true,
	);
}

$this->Title->setPageTitle($configuration['title']);

$this->set(compact('configuration'));
?>
<div id="temp-data" style="display: none;"></div>
<div class="row">
    <div class="col-md-8">
		<div data-billboard-container="main">
			<div class="row">
				<div class="panel panel-info">
					<header class="panel-heading"><h2><?php echo h(__('Latest news'))?></h2></header>
					<div class="panel-body" data-billboard-id="news"></div>
				</div>
			</div>
        </div>
    </div>
    <div class="col-md-4">
		<div data-billboard-container="sidebar">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-info">
						<header class="panel-heading"><h2><?php echo h(__('Cancelled subjects'))?></h2></header>
						<div class="panel-body" data-billboard-id="cancelled"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-info">
						<header class="panel-heading"><h2><?php echo h(__('Absent teachers'))?></h2></header>
						<div class="panel-body" data-billboard-id="absent-teacher"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-info">
						<header class="panel-heading"><h2><?php echo h(__('Events'))?></h2></header>
						<div class="panel-body" data-billboard-id="event"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-info">
						<header class="panel-heading"><h2><?php echo h(__('Public transit'))?></h2></header>
						<div class="panel-body" data-billboard-id="transit"></div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>			

<div id="time-content" style="display: none"></div>

<!-- Modal -->
<div class="modal fade" id="modal-server-unavailable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo h(__('Server unavailable'))?></h4>
      </div>
      <div class="modal-body">
        <?php echo h(__('The server can\'t be reached. The information may be incorrect or out-dated'))?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-reload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=__('Reloading')?></h4>
      </div>
      <div class="modal-body">
        <?=__('The billboard is reloading...')?>
      </div>
    </div>
  </div>
</div>