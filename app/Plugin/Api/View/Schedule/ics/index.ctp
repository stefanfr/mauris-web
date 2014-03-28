<? foreach ($entries as $entry): ?>
BEGIN:VEVENT
UID:uid1@example.com
DTSTAMP:<?=date('Ymd\THis')?>

ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
DTSTART:<?=date('Ymd\THis', strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['start']))?>

DTEND:<?=date('Ymd\THis', strtotime($entry['ScheduleEntry']['date'] . ' ' . $entry['GivenInPeriod']['end']))?>

SUMMARY:<?=$entry['GivenSubject']['abbreviation']?>

END:VEVENT
<? endforeach; ?>
