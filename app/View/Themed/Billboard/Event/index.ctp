<? if (!empty($events)): ?>
<ul>
<? foreach ($events as $event): ?>
    <li><?=h($this->Time->niceShort($event['start'], 'Europe/Amsterdam'))?> - <?=h($event['title'])?></li>
<? endforeach; ?>
</ul>
<? else: ?>
<span><?=__('No events in the near future')?></span>
<? endif; ?>