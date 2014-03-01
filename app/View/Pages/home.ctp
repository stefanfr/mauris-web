<?=$this->start('additionalStyle'); ?>
.navbar-static-top{
	margin-bottom: 0px;
}
<?=$this->end(); ?>
<?=$this->start('beforeContainer'); ?>
<? if ($latest_post): ?>
<div class="jumbotron">
	<div class="container">
		<h1><?=__('Latest news')?></h1>
                <h2><?=h($latest_post['Post']['title'])?></h2>
                <p>
                <? if ($latest_post['Post']['summary']): ?>
                <?=h($latest_post['Post']['summary'])?>
                <? else: ?>
                <?=$this->Text->truncate($latest_post['Post']['body'], 500)?>
                <? endif; ?>
                </p>
                <p><?=$this->Html->link(__('Read more'), array('controller' => 'posts', 'action' => 'view', $latest_post['Post']['id']), array('class' => 'btn btn-primary btn-lg', 'role' => 'buttom'))?></p>
	</div>
</div>
<? endif; ?>
<?=$this->end(); ?>

<div class="row">
	<div class="col-md-4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	</div>
	<div class="col-md-4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	</div>
	<div class="col-md-4">
		<h2><?=_('Available classrooms')?></h2>
                <p><?=__('Classrooms available at: %s', strftime('%X', $classrooms_available_timestamp))?></p>
                <table class="table">
                    <tr>
                        <th><?=_('Classroom')?></th>
                        <th><?=_('Title')?></th>
                    </tr>
                    <? foreach ($classrooms_available as $classroom): ?>
                    <tr>
                        <th><?=$this->Html->link($classroom['Classroom']['code'], array('controller' => 'classroom', 'action' => 'view', $classroom['Classroom']['id']))?></th>
                        <th><?=@$classroom['MappingInformation']['ClassroomDetails']['title']?></th>
                    </tr>
                    <? endforeach; ?>
                </table>
	</div>
</div>
