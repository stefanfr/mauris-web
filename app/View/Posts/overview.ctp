<?php
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle(__('Overview'));

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));

foreach ($posts as $post):
?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
  <h2 class="blog-post-title" itemprop="name"><span><?php echo h($post['Post']['title']); ?></span></h2>
  <p class="blog-post-meta" itemprop="creator" itemscope itemtype="http://schema.org/Person">
    <?php echo h(__('Posted by:'))?> <span itemprop="name"><?php echo h($this->App->buildName($post['PostedBy'])); ?></span> - <?php echo h($this->Time->i18nFormat($post['Post']['created'], '%A', null, 'Europe/Amsterdam')); ?>
  </p>

  <?php
  if ($post['Post']['summary']):
    echo h($post['Post']['summary']);
  else:
    echo $this->Text->truncate($post['Post']['body'], 500);
  endif;
  ?>
  <br><br>

  <?php echo h(__n('%d comment', '%d comments', count($post['Comment']), count($post['Comment']))); ?> - <?php echo h(__('You can reply at: %1$s', Router::url(array('controller' => 'home', 'action' => 'index'), true))); ?>
</div>
<?php endforeach; ?>