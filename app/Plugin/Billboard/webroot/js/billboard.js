$(function(){
	var limit = 5;
	
	updateNews(limit);
        updateEvents(limit);
        updateAbsentTeachers(limit);
        updateCancelledScheduleEntries(limit);
	
	setInterval(function(){
		updateNews(limit);
                updateEvents(limit);
                updateAbsentTeachers(limit);
                updateCancelledScheduleEntries(limit);
	}, 5000);
});

function updateNews(limit) {
	$.ajax({
		url: "http://api.ictcollege.eu/post?school=1&department=1&language=nld&theme=Billboard&limit=" + limit,
		cache: false,
		success: function(html) {
			$('#news-content').html(html);
		},
		dataType: 'html'
	});
}
function updateEvents(limit) {
	$.ajax({
		url: "http://api.ictcollege.eu/event?school=1&department=1&language=nld&theme=Billboard&limit=" + limit,
		cache: false,
		success: function(html) {
			$('#event-content').html(html);
		},
		dataType: 'html'
	});
}

function updateAbsentTeachers(limit) {
	$.ajax({
		url: "http://api.ictcollege.eu/absent_teacher?school=1&department=1&language=nld&theme=Billboard&limit=" + limit,
		cache: false,
		success: function(html) {
			$('#absent-teacher-content').html(html);
		},
		dataType: 'html'
	});
}

function updateCancelledScheduleEntries(limit) {
	$.ajax({
		url: "http://api.ictcollege.eu/schedule?school=1&department=1&language=nld&theme=Billboard&cancelled=true&view=cancelled",
		cache: false,
		success: function(html) {
			$('#cancelled-content').html(html);
		},
		dataType: 'html'
	});
}