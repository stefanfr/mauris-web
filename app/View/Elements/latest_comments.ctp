<div class="panel panel-default">
	<div class="panel-heading">
		<h2><?php echo h(__('Latest comments')); ?></h2>
	</div>
	<?php
	$latest_comments = $this->requestAction(array('controller' => 'comment', 'action' => 'latest'));
	?>
	<div class="panel-body">
		<ul class="media-list">
			<?php
			foreach ($latest_comments as $comment):
				?>
				<li class="media">
					<a class="pull-left"
					   href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile', $comment['CommentedOn']['id'])); ?>">
						<?php echo $this->Gravatar->gravatar(($comment['PostedBy']['email']) ? $comment['PostedBy']['email'] : $comment['PostedBy']['username'], array('s' => 64, 'd' => 'identicon')); ?>
					</a>
					<?php echo $this->App->buildName($comment['PostedBy']); ?>
					<div class="media-body">
						<h4 class="media-heading"><?php echo $this->Html->link($this->Text->truncate($comment['CommentedOn']['title'], 100), array('controller' => 'posts', 'action' => 'view', $comment['CommentedOn']['id'])); ?></h4>
						<?php echo $this->Time->i18nFormat($comment['Comment']['created'], '%c', null, 'Europe/Amsterdam'); ?><br>
						<?php echo h($this->Text->truncate($comment['Comment']['body'], 100)); ?>
					</div>
				</li>
			<?php
			endforeach;
			?>
		</ul>
	</div>
</div>