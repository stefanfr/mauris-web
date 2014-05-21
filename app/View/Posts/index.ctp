<?php
$this->Title->setPageTitle(__('The latest news'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

echo $this->element('page_header');

if ($can_post):
	echo $this->Html->link(
		__('Create post'),
		array('controller' => 'posts', 'action' => 'add')
	);
endif;
?>
<? foreach ($posts as $post): ?>
	<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
		<h2 class="blog-post-title" itemprop="name"><?= h($post['Post']['title']) ?></h2>

		<p class="blog-post-meta pull-right" itemprop="creator" itemscope itemtype="http://schema.org/Person">
			<?= $this->Gravatar->gravatar($post['PostedBy']['system_email'], array('s' => 64, 'd' => 'identicon')) ?>
			<br>
			<?= h(__('Posted by:')) ?> <a itemprop="url"
			                              href="<?= Router::url(array('controller' => 'profile', 'action' => 'view', $post['PostedBy']['id'])) ?>">
				<span itemprop="name"><?= h($this->App->buildName($post['PostedBy'])) ?></span>
			</a>
		</p>

		<? if ($post['Post']['summary']): ?>
			<?= h($post['Post']['summary']) ?>
		<? else: ?>
			<?= $this->Text->truncate($post['Post']['body'], 500) ?>
		<? endif; ?>
		<br><br>

		<?= __n('%d comment', '%d comments', count($post['Comments']), count($post['Comments'])) ?>
		<br><br>
		<meta itemprop="interactionCount" content="UserComments:<?= count($post['Comments']) ?>"/>
		<?=
		$this->Html->link(
			__('Read more'),
			array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], Inflector::slug($post['Post']['title'])),
			array('itemprop' => 'url')
		);?>
	</div>
<? endforeach; ?>

<?php echo $this->element('pagination') ?>