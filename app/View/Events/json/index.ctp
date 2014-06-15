<?php

$timezone = new DateTimeZone('Europe/Amsterdam');

$calendarEvents = array();
foreach ($events as $entry) {
	$startDate = new DateTime($entry['Event']['start']);
	$endDate = new DateTime($entry['Event']['end']);

	$startDate->setTimezone($timezone);
	$endDate->setTimezone($timezone);

	$event = array(
		'id' => $entry['Event']['id'],
		'title' => $entry['Event']['title'],
		'description' => $entry['Event']['description'],
		'start' => $startDate->format('c'),
		'end' => $endDate->format('c'),
		'allDay' => (bool) $entry['Event']['all_day'],
		'type' => $entry['Event']['type'],
	);

	$calendarEvents[] = $event;
}

echo json_encode(array('events' => $calendarEvents));
