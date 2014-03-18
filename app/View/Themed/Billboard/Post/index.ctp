<? foreach ($posts as $post): ?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
  <h2 class="blog-post-title" itemprop="name"><h2><?=h($post['Post']['title'])?></h2></span>
  <p class="blog-post-meta" itemprop="creator" itemscope itemtype="http://schema.org/Person">
        <?=h(__('Posted by:'))?> <span itemprop="name"><?=h($this->App->buildName($post['PostedBy']))?></span>
  </p>

  <? if ($post['Post']['summary']): ?>
    <?=h($post['Post']['summary'])?>
  <? else: ?>
    <?=$this->Text->truncate($post['Post']['body'], 500)?>
  <? endif; ?>
  <br><br>

  <?=__n('%d comment', '%d comments', count($post['Comments']), count($post['Comments']))?>
</div>
<? endforeach; ?>