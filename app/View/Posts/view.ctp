<?
$this->Html->addCrumb(__('News'), array('controller' => 'posts', 'action' => 'index'));
$this->Html->addCrumb($post['Post']['title'], $this->here);
?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
  <h2 class="blog-post-title" itemprop="name"><h2><?=h($post['Post']['title'])?></h2></span>
  <p class="blog-post-meta"><?=h(__('Posted by:'))?> <span itemprop="author"><?=h($this->App->buildName($post['PostedBy']))?></span></p><br>
    <?=nl2br(h($post['Post']['body']))?>
</div>

<? if ($can_comment): ?>
<?=$this->Html->link(
    __('Comment'),
    array('controller' => 'comment', 'action' => 'add', 'post' => $post['Post']['id'])
);?>
<? endif; ?>

<? if ($can_view_comments): ?>
    <ul class="media-list">
    <? foreach ($comments as $comment): ?>
        <li class="media">
            <a class="pull-left" href="<?=Router::url(array('controller' => 'profile', 'action' => 'view', $comment['PostedBy']['id']))?>">
              <?=$this->Gravatar->gravatar($comment['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon'))?>
            </a>
            <div class="media-body">
              <h4 class="media-heading"><?=$this->App->buildName($comment['PostedBy'])?></h4>
              <?=$comment['Comment']['body']?>
              <br>
      <? if ($can_comment): ?>
        <?=$this->Html->link(
            'Reageer',
            array('controller' => 'comment', 'action' => 'add', 'comment' => $comment['Comment']['id'])
        );?>
        <? endif; ?>
              <? foreach ($comment['Replies'] as $reply): ?>
                <?=$this->element('reply', array('reply' => $reply)); ?>
            <? endforeach; ?>
            </div>
          </li>
    <? endforeach; ?>
    </ul>
<? endif; ?>