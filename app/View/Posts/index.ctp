<? $this->Html->addCrumb(__('News'), array('controller' => 'posts', 'action' => 'index')); ?>
<div class="page-header"><h1><?=h(__('The latest news'))?></h1></div>
<? foreach ($posts as $post): ?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
  <h2 class="blog-post-title" itemprop="name"><h2><?=h($post['Post']['title'])?></h2></span>
  <p class="blog-post-meta" itemprop="creator" itemscope itemtype="http://schema.org/Person">
        <?=h(__('Posted by:'))?> <a itemprop="url" href="<?=Router::url(array('controller' => 'profile', 'action' => 'view', $post['PostedBy']['id']))?>">
            <span itemprop="name"><?=h($this->App->buildName($post['PostedBy']))?></span>
        </a>
  </p>

  <? if ($post['Post']['summary']): ?>
    <?=h($post['Post']['summary'])?>
  <? else: ?>
    <?=$this->Text->truncate($post['Post']['body'], 500)?>
  <? endif; ?>
  <br><br>
  <?=$this->Html->link(
    __('Read more'),
    array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
    array('itemprop' => 'url')
);?>
</div>
<? endforeach; ?>

<ul class="pagination">
<?=$this->Paginator->numbers(array('first' => 2, 'last' => 2, 'currentClass' => 'active', 'currentTag' => 'span'))?>
</ul>