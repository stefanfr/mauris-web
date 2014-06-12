var first = true;

var currentDisplay = '';
var currentDisplayId = -1;

var availableDisplays = [];

$(function () {

	console.log(targetData);

	var currentCookie = readCookie('selected_schedule');

	var currentDisplay = null;
	var currentDisplayId = null;

	if (currentCookie != null) {
		var cookieSplit = currentCookie.split('_');

		currentDisplay = cookieSplit[0];
		currentDisplayId = cookieSplit[1];
	}

	if (targetData['classId'] != undefined) {
		currentDisplay = 'class';
		currentDisplayId = targetData['classId'];
	}
	if (targetData['teacherId'] != undefined) {
		currentDisplay = 'teacher';
		currentDisplayId = targetData['teacherId'];
	}
	if (targetData['classroomId'] != undefined) {
		currentDisplay = 'classroom';
		currentDisplayId = targetData['classroomId'];
	}

	$('[id^="selector-"] option[disabled]').attr('selected', '');

	if (currentDisplayId) {
		$('#selector-' + currentDisplay + ' option[disabled]').removeAttr('selected');
		$('#selector-' + currentDisplay + ' option[value=' + currentDisplayId + ']').attr('selected', '');
	}

	$('[id^="selector-"]').each(function (element) {

		var type = $(this).attr('id').split('-')[1];

		availableDisplays.push(type);

		$('#' + $(this).attr('id')).change(function (element) {
			var type = $(this).attr('id').split('-')[1];

			createCookie('selected_schedule', type + '_' + $(this).val(), 99999);

			currentDisplay = type;
			currentDisplayId = $(this).val();

			history.pushState({}, '', '/schedule/' + currentDisplay + ':' + currentDisplayId);

			var pushData = {
				'event': 'schedule-selector-change',
				'scheduleSelectorType': currentDisplay,
				'selectedValue': currentDisplayId,
				'selectedText': $('#selector-' + type + ' option:selected').text(),
			};

			//dataLayer.push(pushData);

			console.log(pushData);

			$('[id^="selector-"]:not([id="selector-' + type + '"]) option[disabled]').attr('selected', '');
			$('#calendar').fullCalendar('refetchEvents');
		});

	});

	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: false,
		weekends: false,
		weekNumbers: true,
		defaultView: 'agendaWeek',
		minTime: '8',
		maxTime: '17',
		weekMode: 'liquid',
		year: targetData.dateDate.getFullYear(),
		month: targetData.dateDate.getMonth(),
		date: targetData.dateDate.getDate(),
		titleFormat: {
			month: 'MMMM',
			week: "MMM d{ '&#8212;'[ MMM] d}",
			day: 'dddd, MMM d'
		},
		ignoreTimezone: false,
		eventSources: [{
			url: App.fullBaseUrl + '/api/schedule/view.json',
			data: function () {
				var returnArray = {};

				if (availableDisplays.indexOf(currentDisplay) == -1) {
					returnArray['class'] = -1; //dummy
				} else {
					returnArray[currentDisplay] = currentDisplayId;
				}

				return returnArray;
			}
		}, {
			url: App.fullBaseUrl + '/events.json',
			data: function () {
				var returnArray = {};

				returnArray['school'] = targetData.schoolId;
				returnArray['department'] = targetData.departmentId;

				return returnArray;
			}
		}, ],
		timeFormat: 'HH:mm{ - HH:mm}',
		axisFormat: 'HH:mm',
		eventDataTransform: function (eventData) {
			return eventData;
		},
		loading: function (bool) {
			if (bool) {
				$('#loading-modal').modal('show').modal('lock');
			} else {
				$('#loading-modal').modal('unlock').modal('hide');
			}
		},
		monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		monthNamesShort: ['Jan', 'Feb', 'Maa', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
		dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		dayNamesShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		allDayText: '',
		buttonText: {
			today: 'vandaag',
			month: 'maand',
			week: 'week',
			day: 'dag'
		},
		viewDisplay: function (view) {
			if (first) {
				first = false;
			} else {
				window.clearInterval(timelineInterval);
			}

			timelineInterval = window.setInterval(setTimeline, 1000);

			setTimeline();
		},
		eventAfterRender: function (event, element, view) {

			var content = '';

			if (currentDisplay == 'class') {
				if (event.teacher_abbreviation != null) {
					content += 'Docent: <i>' + ((event.teacher_name != null) ? event.teacher_name + ' (' + event.teacher_abbreviation + ')' : event.teacher_abbreviation) + '</i><br/>';
				}
			} else if (currentDisplay == 'teacher') {
				content += 'Klas: <i>' + event.class_name + '</i><br/>';
			}

			if (event.classroom_code !== undefined) {
				content += 'Klaslokaal: <i>' + ((event.classroom_title != null) ? event.classroom_title + ' (' + event.classroom_code + ')' : event.classroom_code) + '</i><br/>';
			}

			if (content.length > 0) {
				content += '<br>';
			}

			if (event.assignments !== undefined) {
				content += 'Opgaves:<br/>';

				if (event.assignments.length > 0) {
					console.log(this);

					$.each(event.assignments, function () {
						var stateClass;
						if ($.inArray('make', this.state) !== -1) {
							stateClass = 'make';
						}
						if ($.inArray('done', this.state) !== -1) {
							stateClass = 'done';
						}
						if ($.inArray('check', this.state) !== -1) {
							stateClass = 'check';
						}
						content += '<i class="assignment-state-' + stateClass + '">' + this.title + '</i><br>';

						if (this.description != '') {
							content += '<i><small>' + this.description + '</small></i><br>';
						}
					});
				} else {
					content += '<i>Geen bekend</i>';
				}
			}

			if (event.description !== undefined) {
				content += 'Omschrijving: <br>';
				content += event.description;
			}

			var title;
			if (event.title !== undefined) {
				title = event.title;
			} else {
				title = ((event.subject_title != null) ? event.subject_title + ' (' + event.subject_abbreviation + ')' : event.subject_abbreviation);
			}

			console.log(content);
			$(element)
				.popover({
					html: true,
					content: content,
					placement: function(tip, element) {
						var event = $(element);
						var position = event.position();
						
						if(event.width() > 500){
							return 'top';
						}
						
						if (position.left > 515) {
							return 'left';
						}
						
						if (position.left < 515) {
							return 'right';
						}
						
						if (position.top < 110){
							return 'bottom';
						}
						
						return 'top';
					},
					trigger: 'hover',
					container: 'body',
					title: title
				});
		},
		eventRender: function (event, element, view) {
			if (event.cancelled) {
				$(element).addClass('eventCancelled');
			}

			if (event.start.getMonth() !== view.start.getMonth() && view.name == 'month') {
				$(element).css('opacity', '0.3');
			}
		},
		viewRender: function (view, element) {
			var pushData = {
				'event': 'schedule-view-change',
				'viewName': view.name,
			};

			//dataLayer.push(pushData);

			console.log(pushData);
		}
	});
});

function createCookie(name, value, days) {
	var expires;

	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();
	} else {
		expires = "";
	}

	document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = escape(name) + "=";
	var ca = document.cookie.split(';');

	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];

		while (c.charAt(0) === ' ')
			c = c.substring(1, c.length);

		if (c.indexOf(nameEQ) === 0)
			return unescape(c.substring(nameEQ.length, c.length));
	}

	return null;
}


function setTimeline(view) {
	var parentDiv = $('.fc-agenda-slots:visible').parent();
	var timeline = parentDiv.children('.timeline');

	if (timeline.length == 0) {
		timeline = $('<hr>').addClass('timeline');
		parentDiv.prepend(timeline);
	}

	var curTime = new Date();

	var curCalView = $('#calendar').fullCalendar('getView');

	if (curCalView.visStart < curTime && curCalView.visEnd > curTime) {
		timeline.show();
	} else {
		timeline.hide();
		return;
	}

	var curSeconds = ((curTime.getHours() - curCalView.opt('minTime')) * 60 * 60) + (curTime.getMinutes() * 60) + curTime.getSeconds();
	var percentOfDay = curSeconds / ((curCalView.opt('maxTime') - curCalView.opt('minTime')) * 3600);
	var topLoc = Math.floor(parentDiv.height() * percentOfDay);

	timeline.css('top', topLoc + 'px');

	if (curCalView.name == 'agendaWeek') {
		var dayCol = $('.fc-today:visible');
		var left = dayCol.position().left + 1;
		var width = dayCol.width() - 2;

		timeline.css({
			left: left + 'px',
			width: width + 'px'
		});
	}

}

var _hide = $.fn.modal.Constructor.prototype.hide;

$.extend($.fn.modal.Constructor.prototype, {
	lock: function () {
		this.options.locked = true;
	},
	unlock: function () {
		this.options.locked = false;
	},
	hide: function () {
		if (this.options.locked) return;

		_hide.apply(this, arguments);
	}
});
