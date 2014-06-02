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
	<div class="row" itemscope itemtype="http://schema.org/BlogPosting">
		<div class="col-md-12">
			<h2 itemprop="name"><?= h($post['Post']['title']) ?></h2>
		</div>
		<div class="col-md-9">
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
		<div class="col-md-3" itemprop="creator" itemscope itemtype="http://schema.org/Person">
			<?= $this->Gravatar->gravatar(($post['PostedBy']['system_email']) ? $post['PostedBy']['system_email'] : $post['PostedBy']['username'], array('s' => 64, 'd' => 'identicon')) ?>
			<br>
			<?= h(__('Posted by')) ?> <a itemprop="url"
			                              href="<?= Router::url(array('controller' => 'users', 'action' => 'profile', $post['PostedBy']['id'])) ?>">
				<span itemprop="name"><?= h($this->App->buildName($post['PostedBy'], false)) ?></span>
			</a>
		</div>
	</div>
<? endforeach; ?>

<?php echo $this->element('pagination') ?>