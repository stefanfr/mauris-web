<div class="media" itemscope itemtype="http://schema.org/Comments">
    <a class="pull-left" href="<?=Router::url(array('controller' => 'users', 'action' => 'profile', $reply['PostedBy']['id']))?>">
      <?=$this->Gravatar->gravatar($reply['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon'))?>
    </a>
    <div class="media-body">
      <h4 class="media-heading" itemprop="creator" itemscope itemtype="http://schema.org/Person">
         <span itemprop="name"><?=$this->App->buildName($reply['PostedBy'])?></spa>
      </h4>
       <span itemprop="commentText"><?=$reply['Comment']['body']?></span>
      <br>
      <? if ($can_comment): ?>
        <?=$this->Html->link(
            __('Reply'),
            array('controller' => 'comment', 'action' => 'add', 'comment' => $reply['Comment']['id'])
        );?>
        <? endif; ?>
      <!-- Nested media object -->
      <? foreach ($reply['Replies'] as $subReply): ?>
      <?=$this->element('reply', array('reply' => $subReply)); ?>
      <? endforeach; ?>
    </div>
</div>