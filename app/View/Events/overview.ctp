<?php if (!empty($events)): ?>
<ul>
<?php foreach ($events as $event): ?>
    <li><?php echo h($this->Time->niceShort($event['Event']['start'], 'Europe/Amsterdam')); ?> - <?php echo h($event['Event']['title']) ?></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<span><?php echo h(__('No events in the near future')); ?></span>
<?php endif; ?>