<? if (!empty($entries)): ?>
<table class="table">
    <tr>
        <th><?=__('Class')?></th>
        <th><?=__('Period')?></th>
        <th><?=__('Subject')?></th>
    </tr>
    <? foreach ($entries as $entry): ?>
    <tr>
        <td><?=h($entry['GivenToClass']['name'])?></td>
        <td><?=h($entry['GivenInPeriod']['period'])?></td>
        <td><?=h($entry['GivenSubject']['abbreviation'])?></td>
    </tr>
    <? endforeach; ?>
</table>
<? else: ?>
<span><?=__('No subjects have been cancelled')?></span>
<? endif; ?>
