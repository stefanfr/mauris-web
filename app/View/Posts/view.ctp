<?
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle($post['Post']['title']);

$this->Html->addCrumb($this->Title->getTopSegment(1), array('controller' => 'posts', 'action' => 'index'));
$this->Html->addCrumb($this->Title->getTopSegment(), $this->here);

if ($post['Post']['summary']):
    $this->set('description_for_layout', $post['Post']['summary']);
else:
    $this->set('description_for_layout', $this->Text->truncate($post['Post']['body'], 200));
endif;
?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
	<h2 class="blog-post-title" itemprop="name"><?=h($this->Title->getPageTitle())?></h2>
  <div class="pull-right">
    <?=$this->Gravatar->gravatar($post['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon'))?>
  <p class="blog-post-meta"><?=h(__('Posted by:'))?> <span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?=h($this->App->buildName($post['PostedBy']))?></span></span></p>
  </div>
  <span itemprop="articleBody">
<?=nl2br(h($post['Post']['body']))?>
</span>    
  
  <br><br>
  <a href="<?=$post['PostedBy']['google_profile']?>?rel=author"><?=__('%s profile', 'Google+')?></a>

<? if ($can_comment): ?>
<?=$this->Html->link(
    __('Comment'),
    array('controller' => 'comment', 'action' => 'add', 'post' => $post['Post']['id'])
);?>
<? endif; ?>

<? if ($can_view_comments): ?>
    <ul class="media-list">
    <? foreach ($comments as $comment): ?>
        <li class="media" itemprop="comment" itemscope itemtype="http://schema.org/UserComments">
            <a class="pull-left" href="<?=Router::url(array('controller' => 'profile', 'action' => 'view', $comment['PostedBy']['id']))?>">
              <?=$this->Gravatar->gravatar($comment['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon'))?>
            </a>
            <div class="media-body">
              <h4 class="media-heading" itemprop="creator" itemscope itemtype="http://schema.org/Person">
                  <span itemprop="name"><?=$this->App->buildName($comment['PostedBy'])?></span>
              </h4>
              <span itemprop="commentText"><?=$comment['Comment']['body']?></span>
              <br>
      <? if ($can_comment): ?>
        <?=$this->Html->link(
            __('Reply'),
            array('controller' => 'comment', 'action' => 'add', 'comment' => $comment['Comment']['id']),
                array('itemprop' => 'replyToUrl')
        );?>
    <? else: ?>
        <?=$this->Html->meta(array('itemprop' => 'replyToUrl', 'content' => Router::url(array('controller' => 'comment', 'action' => 'add', 'comment' => $comment['Comment']['id']), true)))?>
        <? endif; ?>
              <? foreach ($comment['Replies'] as $reply): ?>
                <?=$this->element('reply', array('reply' => $reply)); ?>
            <? endforeach; ?>
            </div>
          </li>
    <? endforeach; ?>
    </ul>
<? endif; ?>
</div>