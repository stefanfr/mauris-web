var billboard = {
    /**
     * @type Number The interval at wich to update the billboard content
     */
    interval: 10,
    /**
     * 
     * @type Number Miliseconds per pixel scrolling speed
     */
    scrollSpeed: 40, 
    data: [
        {
            id: 'news',
            container: 'main',
            url: App.fullBaseUrl + '/api/post?theme=Billboard',
        },
        {
            id: 'event',
            container: 'sidebar',
            url: App.fullBaseUrl + '/api/event?theme=Billboard',
            //date: 'month'
        },
        {
            id: 'absent-teacher',
            container: 'sidebar',
            url: App.fullBaseUrl + '/api/absent_teacher?theme=Billboard',
        },
        {
            id: 'cancelled',
            container: 'sidebar',
            url: App.fullBaseUrl + '/api/schedule?theme=Billboard&cancelled=true&view=cancelled',
            date: 'day'
        },
        {
            id: 'transit',
            container: 'sidebar',
            url: App.fullBaseUrl + '/api/public_transit?stop_area_code=hmonoo&theme=Billboard',
            date: 'day'
        }
    ],
    version: {},
    /**
     * Used to update all of the content on the billboard
     * 
     * @returns {Void} Returns nothing
     */
    update: function () {
        var subInterval = this.interval / this.data.length;
        var itemInterval = 0;
        for (var entryIndex in this.data) {
            var entry = this.data[entryIndex];
            
            entry.timeout = setTimeout(function(entry) {
                var url = entry.url;
                //console.log('Update: ' + entry.id);
                
                if (entry.date !== undefined) {
                    var start = new Date();
                    var end = new Date();
                    
                    if (entry.date == 'day') {
                        start.setHours(0,0,0,0);
                        end.setHours(23,59,59,999);
                    } else if (entry.date == 'month') {
                        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
                        start = new Date(y, m, 1);
                        end = new Date(y, m + 1, 0);
                    }
                    
                    url += '&start=' + start.getTime() / 1000;
                    url += '&end=' + end.getTime() / 1000;
                }
                
                //console.log(url);
                
                billboard._update(entry.id, url, entry);
            }, itemInterval * 1000, entry);
            
            itemInterval += subInterval;
        }
    },
    checkVersion: function () {
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
                        
                        setTimeout(function () {
                            location.reload(); 
                        }, 1000);
                    }
                },
                dataType: 'json'
            });
        }
    },
    scroll: function(selector, scrollDown) {      
        if ($(selector).is(':animated')) {
            console.log('Already animated: ' + selector);
            return;
        }
        
        var animateParameters = {};
        animateParameters.scrollTop = 0;

        if (scrollDown){
            animateParameters.scrollTop = $(selector).height();
        }	
        
        var scrollDone = function () {
            console.log('Scroll for ' + selector + ' done. Waiting for next scroll movement');
            
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
        
        console.log($(selector).scrollTop());
        console.log(animateParameters.scrollTop);
        console.log(scrollDifference);
        
        if (($(selector).scrollTop() != animateParameters.scrollTop) && ($(selector).outerHeight(false) < contentHeight)) {
            console.log('Scroll for ' + selector + ' initiated');

            console.log('Initiating scroll to ' + selector + ': ' + animateParameters.scrollTop);
            console.log(contentHeight);
            console.log('Scroll time: ' + animationDuration + 'ms');

            $(selector).animate(
                animateParameters, animationDuration, 'linear',
                scrollDone
            );	
        } else {
            console.log('No need to scroll ' + selector + '.');
            
            scrollDone();
        }
    },
    _update: function (id, url, entry) {
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                $('#temp-data').html(html);
                
                if ($('#temp-data').html() != $(id).html()) {
                    $('[data-billboard-id="' + id + '"]').fadeOut(function () {
                        $('[data-billboard-id="' + id + '"]').html(html);
                        $('[data-billboard-id="' + id + '"]').fadeIn(function () {
                            billboard.scroll('[data-billboard-container="' + entry.container + '"]', false);
                        });
                    });
                } else {
                    $('[data-billboard-id="' + id + '"]').html(html);
                }
                
                $('#modal-server-unavailable').modal('hide');
            },
            error: function () {
                $('#modal-server-unavailable').modal('show');
            },
            dataType: 'html'
        });
    }
};

$(function(){
	var limit = 5;
	        
	billboard.update();
	billboard.checkVersion();
        
        $(window).resize(function() {
            $('[data-billboard-container="main"]').css('height', $(window).height() - $('[data-billboard-container="main"]').offset().top - 25);
            $('[data-billboard-container="sidebar"]').css('height', $(window).height() - $('[data-billboard-container="sidebar"]').offset().top - 25);
        }).resize();
        
	setInterval(function(){
		billboard.update();
	}, billboard.interval * 1000);
	
	setInterval(function(){                
		billboard.checkVersion();
	}, 2 * 1000);
	
	var nextSeperator = true;
	
	setInterval(function(){
		var date = new Date();
		
		$('#clock').html(('0' + date.getHours()).slice(-2) + '<span class="time-seperator">' + ((nextSeperator) ? ':' : ' ') + '</span>' + ('0' + date.getMinutes()).slice(-2));
		
		nextSeperator = !nextSeperator;
	}, 1000);
});
