<?
$this->Html->css(
    'Billboard.billboard',
    array('block' => 'css')
);
$this->Html->script(
    'Billboard.billboard',
    array('block' => 'script')
);
?>
<div id="temp-data" style="display: none;"></div>
<div class="row">
    <div class="col-md-8">
		<div class="billboard-content billboard-content-main">
			<div class="billboard-actual-content">
				<div class="panel panel-info">
					<header class="panel-heading"><h2><?=__('Latest news')?></h2></header>
					<div class="panel-body" id="news-content"></div>
				</div>
			</div>
        </div>
    </div>
    <div class="col-md-4">
        <!--<div class="panel panel-default">
            <div class="panel-body">-->
                <div class="billboard-content billboard-content-sidebar">
                    <div class="billboard-actual-content">
                        <div class="row">
                            <div class="panel panel-info">
								<header class="panel-heading"><h2><?=__('Cancelled subjects')?></h2></header>
                                <div class="panel-body" id="cancelled-content">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-info">
								<header class="panel-heading"><h2><?=__('Absent teachers')?></h2></header>
                                <div class="panel-body" id="absent-teacher-content">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-info">
								<header class="panel-heading"><h2><?=__('Events')?></h2></header>
                                <div class="panel-body" id="event-content">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-info">
								<header class="panel-heading"><h2><?=__('Public transit')?></h2></header>
                                <div class="panel-body" id="transit-content">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</div>
        </div>-->
    </div>
</div>			

<div id="time-content" style="display: none"></div>

<!-- Modal -->
<div class="modal fade" id="modal-server-unavailable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=__('Server unavailable')?></h4>
      </div>
      <div class="modal-body">
        <?=__('The server can\'t be reached. The information may be incorrect or out-dated')?>
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