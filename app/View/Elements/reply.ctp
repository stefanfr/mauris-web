<div class="media" itemscope itemtype="http://schema.org/Comments">
    <a class="pull-left" href="<?=Router::url(array('controller' => 'users', 'action' => 'profile', $reply['PostedBy']['id']))?>">
      <?=$this->Gravatar->gravatar($reply['PostedBy']['email'], array('s' => 64, 'd' => 'identicon'))?>
    </a>
    <div class="media-body">
      <h4 class="media-heading" itemprop="creator" itemscope itemtype="http://schema.org/Person">
         <span itemprop="name"><?=$this->App->buildName($reply['PostedBy'])?></span> <small>- <?php echo $this->Time->timeAgoInWords($reply['Comment']['created']); ?></small>
      </h4>
       <span itemprop="commentText"><?=$reply['Comment']['body']?></span>
      <br>
	    <div class="btn-group btn-group-xs">
		    <?php if ($can_comment): ?>
			    <button type="button" class="btn btn-primary comment-button"
			            data-comment-id="<?php echo h($reply['Comment']['id']); ?>"><?php echo h(__('Comment')); ?></button>
		    <? endif; ?>
	    </div>
	    <div id="comment-box-comment-<?php echo h($reply['Comment']['id']); ?>"
	         style="display:none;"></div>
      <!-- Nested media object -->
      <?php foreach ($reply['children'] as $subReply): ?>
      <?=$this->element('reply', array('reply' => $subReply)); ?>
      <? endforeach; ?>
    </div>
</div>