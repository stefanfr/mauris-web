<?
$infoAvailable = false;
foreach ($passes as $stopAreaCode => $stopData):
    if (isset($stopData['StopData'])):
        $infoAvailable = true;
    else:
        continue;
    endif;
?>
<h2><?=h($stopData['StopData']['TimingPointName'])?></h2>
<table>
    <tr>
        <th><?=__('Type')?></th>
        <th><?=__('Destination')?></th>
        <th><?=__('Departure')?></th>
    </tr>
<? foreach ($stopData['Journeys'] as $pass): ?>
    <?
    $delay = strtotime($pass['JourneyData']['ExpectedDepartureTime']) - strtotime($pass['JourneyData']['TargetDepartureTime']);
    $delayed = (bool) $delay;
    
    $rowClasses = array();
    if ($delayed) {
        $rowClasses[] = 'transit-delayed';
    }
    ?>
    <tr class="<?=implode(' ', $rowClasses)?>">
        <td><?=h($pass['JourneyData']['TransportType'])?></td>
        <td><?=h($pass['JourneyData']['DestinationName50'])?></td>
        <td><?=h($this->Time->format($pass['JourneyData']['ExpectedDepartureTime'], '%X'))?><?=($delay) ? ' (' . h($delay) . ')' : ''?></td>
    </tr>
<? endforeach; ?>
</table>
<? endforeach; ?>
<? if (!$infoAvailable): ?>
<p><?=__('No transit information available')?></p>
<? endif; ?>