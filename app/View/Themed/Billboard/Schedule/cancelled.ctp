<? if (!empty($entries)): ?>
<table class="table">
    <tr>
        <th><?=__('Klas')?></th>
        <th><?=__('Period')?></th>
        <th><?=__('Vak')?></th>
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
<span><?=__('No teachers are reported as absent at the moment')?></span>
<? endif; ?>
