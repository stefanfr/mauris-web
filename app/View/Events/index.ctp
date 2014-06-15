<?php
$this->Title->setPageTitle(__('Events'));

$this->Title->addCrumbs(array(
	array('action' => 'index')
));

$this->Seo->setDescription(__('List of events happening in and around the organization within the coming months'));

echo $this->element('page_header');
?>
<ul class="event-listings">
	<?php
	foreach ($events as $event):
		$dateTitle = $this->Time->i18nFormat($event['Event']['start'], '%A %d %B %Y', null, 'Europe/Amsterdam');
		$dateFormat = ($event['Event']['all_day']) ? '%A %d %B %Y' : '%A %d %B %Y %X';
		$dateFormatIso8601 = ($event['Event']['all_day']) ? 'o-m-d' : 'c';
		?>

		<li title="<?php echo h($event['Event']['title']); ?>" itemscope="" itemtype="http://schema.org/Event"
		    class="event">
			<a href="<?php echo $this->App->url(array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>"
			   itemprop="url">
				<h2 itemprop="name" class="name"><?php echo h($event['Event']['title']); ?></time></h2>
			</a>
			<time itemprop="startDate" datetime="<?php echo h(date($dateFormatIso8601, strtotime($event['Event']['start']))); ?>"
			      class="start"><?php echo h($this->Time->i18nFormat($event['Event']['start'], $dateFormat, null, 'Europe/Amsterdam')); ?></time>
			-
			<time itemprop="endDate" datetime="<?php echo h(date($dateFormatIso8601, strtotime($event['Event']['end']))); ?>"
			      class="end"><?php echo h($this->Time->i18nFormat($event['Event']['end'], $dateFormat, null, 'Europe/Amsterdam')); ?></time>

			<div itemprop="description" class="description">
				<?php echo $this->Text->autoParagraph(h($event['Event']['description'])); ?>
			</div>
		</li>
	<?php endforeach; ?>
</ul>