<?
$this->Title->addSegment(__('News'));
$this->Title->setPageTitle($post['Post']['title']);

$this->Title->addCrumbs(array(
	array('action' => 'index'),
	$this->here
));

$this->Seo->setPageType('post');

if ($post['Post']['summary']):
	$this->Seo->setDescription($post['Post']['summary']);
else:
	$this->Seo->setDescription($this->Text->truncate($post['Post']['body'], 200));
endif;
?>
<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
	<h1 class="blog-post-title" itemprop="name"><?= h($this->Title->getPageTitle()) ?></h1>

	<div class="pull-right">
		<?= $this->Gravatar->gravatar($post['PostedBy']['email'], array('s' => 64, 'd' => 'identicon')) ?>
		<p class="blog-post-meta">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person">
				<a href="<?php echo $this->App->url(array('controller' => 'users', 'action' => 'profile', $post['PostedBy']['id'])); ?>"><?php echo h(__('By')); ?>
					<span itemprop="name"><?= h($this->App->buildName($post['PostedBy'], false)) ?></span>
				</a>
				<?php
				if ($post['PostedBy']['google_profile'] != ''):
					?>
					<div class="btn-group">
						<a type="button" class="btn btn-default"
						   href="<?= $post['PostedBy']['google_profile'] ?>?rel=author"><?= __('%s profile', 'Google+') ?></a>
					</div>
				<?php
				endif;
				?>
			</span>
		</p>
	</div>
	<span itemprop="articleBody">
		<?php echo $this->Text->autoParagraph(h($post['Post']['body'])) ?>
	</span>
	<div class="btn-toolbar" role="toolbar">
		<div class="btn-group">
			<?php if ($can_comment): ?>
				<button type="button" id="comment-button" class="btn btn-primary comment-button" data-post-id="<?php echo h($post['Post']['id']); ?>"><?php echo h(__('Comment')); ?></button>
			<?php endif; ?>
		</div>
	</div>
	<script>
		$(function () {
			$('.comment-button').click(function () {
				var postUrlTemplate = <?php echo json_encode($this->App->url(array('controller' => 'comment', 'action' => 'add', 'post' => 'post-id'))); ?>;
				var commentUrlTemplate = <?php echo json_encode($this->App->url(array('controller' => 'comment', 'action' => 'add', 'comment' => 'comment-id'))); ?>;
				var url;
				var button = this;
				if ($(this).data('post-id')) {
					url = postUrlTemplate.replace('post-id', $(this).data('post-id'));
				}
				if ($(this).data('comment-id')) {
					url = commentUrlTemplate.replace('comment-id', $(this).data('comment-id'));
				}
				var id = '#comment-box-';
				if ($(button).data('post-id')) {
					id += 'post-' + $(button).data('post-id');
				}
				if ($(button).data('comment-id')) {
					id += 'comment-' + $(button).data('comment-id');
				}
				if ($(id).is(':visible')) {
					$(id).hide();
					$(button).removeClass('active');
				} else {
					$.ajax({
						url     : url,
						success : function (html) {
							$(id).html(html);
							$(id).show();
							$(button).addClass('active');
						},
						datatype: 'html'
					});
				}
			});
		});
	</script>

	<div id="comment-box-post-<?php echo h($post['Post']['id']); ?>" style="display:none;"></div>

	<? if ($can_view_comments): ?>
		<ul class="media-list">
			<? foreach ($comments as $comment): ?>
				<li class="media" itemprop="comment" itemscope itemtype="http://schema.org/UserComments">
					<a class="pull-left"
					   href="<?= Router::url(array('controller' => 'users', 'action' => 'view', $comment['PostedBy']['id'])) ?>">
						<?= $this->Gravatar->gravatar($comment['PostedBy']['email'], array('s' => 64, 'd' => 'identicon')) ?>
					</a>

					<div class="media-body">
						<h4 class="media-heading" itemprop="creator" itemscope itemtype="http://schema.org/Person">
							<span itemprop="name"><?= $this->App->buildName($comment['PostedBy']) ?></span>
							<small>- <?php echo $this->Time->timeAgoInWords($comment['Comment']['created']); ?></small>
						</h4>
						<span itemprop="commentText"><?= $comment['Comment']['body'] ?></span>
						<br>
						<?= $this->Html->meta(array('itemprop' => 'replyToUrl', 'content' => Router::url(array('controller' => 'comment', 'action' => 'add', 'comment' => $comment['Comment']['id']), true))) ?>
						<div class="btn-group btn-group-xs">
							<?php if ($can_comment): ?>
								<button type="button" class="btn btn-primary comment-button"
								        data-comment-id="<?php echo h($comment['Comment']['id']); ?>"><?php echo h(__('Comment')); ?></button>
							<? endif; ?>
						</div>
						<div id="comment-box-comment-<?php echo h($comment['Comment']['id']); ?>"
						     style="display:none;"></div>
						<?php
						foreach ($comment['children'] as $reply):
							echo $this->element('reply', array('reply' => $reply));
						endforeach;
						?>
					</div>
				</li>
			<? endforeach; ?>
		</ul>
	<? endif; ?>
</div>