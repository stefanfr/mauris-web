var billboard = {
	/**
     * The interval at wich to update the billboard content
     *
	 * @type Number
	 */
	interval:    60,
	/**
	 * Miliseconds per pixel scrolling speed
     *
	 * @type Number
	 */
	scrollSpeed: 40,
    /**
     * All of the billboard data that can be updated using API calls
     *
     * @type Array
     */
	data: [
		{
			id:        'news',
			container: 'main',
			url:       App.fullBaseUrl + '/api/post?theme=Billboard',
		},
		{
			id:        'event',
			container: 'sidebar',
			url:       App.fullBaseUrl + '/api/event?theme=Billboard',
			//date:      'month'
		},
		{
			id:        'absent-teacher',
			container: 'sidebar',
			url:        App.fullBaseUrl + '/api/absent_teacher?theme=Billboard',
		},
		{
			id:        'cancelled',
			container: 'sidebar',
			url:       App.fullBaseUrl + '/api/schedule?theme=Billboard&cancelled=true&view=cancelled',
			date:      'day'
		},
		{
			id:        'transit',
			container: 'sidebar',
			url:       App.fullBaseUrl + '/api/public_transit?stop_area_code=hmonoo&theme=Billboard',
			date:      'day'
		}
	],
	version: {},
	/**
	 * Used to update all of the content on the billboard
	 *
	 * @returns {Void} Nothing
	 */
	update: function() {
		var subInterval = this.interval / this.data.length;
		var itemInterval = 0;
		for (var entryIndex in this.data) {
			var entry = this.data[entryIndex];

			entry.timeout = setTimeout(
				function(entry) {
					var url = entry.url;

					if (entry.date !== undefined) {
						var start = new Date();
						var end   = new Date();

						if (entry.date == 'day') {
							start.setHours(0, 0, 0, 0);
							end.setHours(23, 59, 59, 999);
						} else if (entry.date == 'month') {
							var date = new Date();
							var y    = date.getFullYear();
							var m    = date.getMonth();
							start = new Date(y, m, 1);
							end   = new Date(y, m + 1, 0);
						}

						url += '&start=' + start.getTime() / 1000;
						url += '&end=' + end.getTime() / 1000;
					}

					billboard._update(entry.id, url, entry);
				},
				itemInterval * 1000,
				entry
			);

			itemInterval += subInterval;
		}
	},
    /**
     * Checks if the version of the billboard currently running in the browser is the latest version. If not it causes
     * a reload of the page to make sure the latest version is loaded.
     */
	checkVersion: function() {
		if (billboard.version.current === undefined) {
			$.ajax({
				url: App.fullBaseUrl + '/billboard/version_check/check.json',
				cache: false,
				success: function(json) {
					billboard.version.current = json.version.current;
				},
				dataType: 'json'
			});
		} else {
			$.ajax({
				url: App.fullBaseUrl + '/billboard/version_check/check.json?hash=' + billboard.version.current,
				cache: false,
				success: function(json) {
					if (!json.version['up-to-date']) {
						$('#modal-reload').modal('show');

						setTimeout(
							function() {
								location.reload();
							},
							1000
						);
					}
				},
				dataType: 'json'
			});
		}
	},
    /**
     * Starts the scrolling animation on the provided selector
     *
     * @param selector The selector to the element that needs to scroll.
     * @param scrollDown True when the content should scroll down and vise-versa
     */
	scroll: function(selector, scrollDown) {
		if ($(selector).is(':animated')) {
			return;
		}

		var animateParameters = {};
		animateParameters.scrollTop = 0;

		if (scrollDown) {
			animateParameters.scrollTop = $(selector).height();
		}

		var scrollDone = function() {
			setTimeout(billboard.scroll, 5000, selector, !scrollDown);
		}

		var scrollDifference;
		if ($(selector).scrollTop() > animateParameters.scrollTop) {
			scrollDifference = $(selector).scrollTop() - animateParameters.scrollTop;
		} else {
			scrollDifference = animateParameters.scrollTop - $(selector).scrollTop();
		}

		var contentHeight = $('.panel', $(selector)).outerHeight(true);
		var animationDuration = billboard.scrollSpeed * scrollDifference;

		if (($(selector).scrollTop() != animateParameters.scrollTop) && ($(selector).outerHeight(false) < contentHeight)) {
			$(selector).animate(
				animateParameters, animationDuration, 'linear',
				scrollDone
			);
		} else {
			scrollDone();
		}
	},
	_update: function(id, url, entry) {
		$.ajax({
			url: url,
			cache: false,
			success: function(html) {
                var temp_data = $('#temp-data');
                var billboard_data = $('[data-billboard-id="' + id + '"]');

                temp_data.html(html);

				if (temp_data.html() !== billboard_data.html()) {
                    billboard_data.fadeOut(function() {
                        billboard_data.html(html).fadeIn(function() {
							billboard.scroll(
								'[data-billboard-container="' + entry.container + '"]',
								false
							);
						});
					});
				} else {
                    billboard_data.html(html);
				}

				$('#modal-server-unavailable').modal('hide');
			},
			error: function() {
				$('#modal-server-unavailable').modal('show');
			},
			dataType: 'html'
		});
	}
};

$(function() {
	billboard.update();
	billboard.checkVersion();

	$(window).resize(function() {
		$('[data-billboard-container="main"]').css('height',
			$(window).height() - $('[data-billboard-container="main"]').offset().top - 5
		);
		$('[data-billboard-container="sidebar"]').css('height',
			$(window).height() - $('[data-billboard-container="sidebar"]').offset().top - 5
		);
	}).resize();

	setInterval(
		function() {
			billboard.update();
		},
		billboard.interval * 1000
	);

    /**
     * Check for updates every 10 seconds
     */
	setInterval(
		function() {
			billboard.checkVersion();
		},
		10 * 1000
	);

	var nextSeperator = true;

	setInterval(
		function() {
			var date = new Date();

			$('#clock').html(
				('0' + date.getHours()).slice(-2) + '<span class="time-seperator">' + ((nextSeperator) ? ':' : ' ') + '</span>' + ('0' + date.getMinutes()).slice(-2)
			);

			nextSeperator = !nextSeperator;
		},
		1000
	);
});
