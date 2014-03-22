<div id="temp-data" style="display: none;"></div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="billboard-content billboard-content-main">
                    <div class="billboard-actual-content">
                        <h1><?=__('Latest news')?></h1>
                        <div id="news-content"></div>
                    </div>
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
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h1><?=__('Cancelled subjects')?></h1>
                                    <div id="cancelled-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h1><?=__('Absent teachers')?></h1>
                                    <div id="absent-teacher-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h1><?=__('Events')?></h1>
                                    <div id="event-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h1><?=__('Public transit')?></h1>
                                    <div id="transit-content"></div>
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