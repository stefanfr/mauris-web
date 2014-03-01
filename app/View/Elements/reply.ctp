<div class="media">
<a class="pull-left" href="<?=Router::url(array('controller' => 'profile', 'action' => 'view', $reply['PostedBy']['id']))?>">
  <?=$this->Gravatar->gravatar($reply['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon'))?>
</a>
<div class="media-body">
  <h4 class="media-heading"><?=$this->App->buildName($reply['PostedBy'])?></h4>
  <?=$reply['Comment']['body']?>
  <br>
  <? if ($can_comment): ?>
    <?=$this->Html->link(
        'Reageer',
        array('controller' => 'comment', 'action' => 'add', 'comment' => $reply['Comment']['id'])
    );?>
    <? endif; ?>
  <!-- Nested media object -->
  <? foreach ($reply['Replies'] as $subReply): ?>
  <?=$this->element('reply', array('reply' => $subReply)); ?>
  <? endforeach; ?>
</div>
</div>