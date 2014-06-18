<?
$this->Title->addSegment(__('Users'));
$this->Title->setPageTitle($this->App->buildName($user_account['User']));

$this->Title->addCrumbs(array(
	null,
	$this->here,
));

$this->Seo->setDescription(__('%1$s\'s %2$s profile', $this->App->buildName($user_account['User']), 'Mauris'));

$this->Seo->setPageType('profile');
$this->Seo->setImage($this->Gravatar->avatarUrl(($user_account['User']['email']) ? $user_account['User']['email'] : $user_account['User']['username'], array('s' => 250)), 'twitter');
$this->Seo->setImage($this->Gravatar->avatarUrl(($user_account['User']['email']) ? $user_account['User']['email'] : $user_account['User']['username'], array('s' => 1200)), 'open_graph');

echo $this->element('page_header');

$posts = $this->requestAction(array('controller' => 'posts', 'action' => 'by_author', $user_account['User']['id']));
?>
<div itemprop="about" itemscope itemtype="http://schema.org/Person">
	<div class="pull-right">
		<?php echo $this->Html->image($this->Gravatar->avatarUrl(($user_account['User']['email']) ? $user_account['User']['email'] : $user_account['User']['username'], array('s' => 250))); ?>
	</div>
	<strong><?php echo h(__('Name')); ?>:</strong> <span itemprop="name"><?php echo h($this->App->buildName($user_account['User'])); ?></span><br>
	<?php if ($user_account['User']['firstname']): ?>
	<strong><?php echo h(__('Firstname')); ?>:</strong> <span itemprop="givenName"><?php echo h($user_account['User']['firstname']); ?></span><br>
	<?php
	endif;
	if ($user_account['User']['middlename']):
	?>
		<strong><?php echo h(__('Middlename')); ?>:</strong> <span itemprop="additionalName"><?php echo h($user_account['User']['middlename']); ?></span><br>
	<?php
	endif;
	if ($user_account['User']['surname']):
	?>
	<strong><?php echo h(__('Surname')); ?>:</strong> <span itemprop="familyName"><?php echo h($user_account['User']['surname']); ?></span><br>
	<?php endif; ?>
</div>

<?php
if (count($posts)):
?>
	<h2><?php echo h(__n('Latest post by this user', 'Latest posts by this user', count($posts))); ?></h2>
<?php
endif;

foreach ($posts as $post):
	if (empty($post['Post']['summary'])):
		$summary = $this->Text->truncate($post['Post']['body'], 200);
	else:
		$summary = $post['Post']['summary'];
	endif;
	$summary = h($summary);
?>
	<div itemscope itemtype="http://schema.org/BlogPosting">
		<h3 itemprop="name"><a href="<?php echo $this->App->url(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>"><?php echo h($post['Post']['title']); ?></a> <small>- <?php echo h($this->Time->timeAgoInWords($post['Post']['created'])); ?></small></h3>
		<meta itemprop="url" content="<?php echo $this->App->url(array('controller' => 'posts', 'action' => 'view', $post['Post']['id']), true); ?>">
		<div>
			<?php echo $this->Text->autoParagraph($summary); ?>
		</div>
		<div class="btn-group">
		   <?php echo $this->Html->link(__('Read more'), array('controller' => 'posts', 'action' => 'view', $post['Post']['id']), array('class' => 'btn btn-default')); ?>
		</div>
	</div>
<?php endforeach; ?>
