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
            id: '#news-content',
            container: '.billboard-content-main',
            url: '/api/post?theme=Billboard',
        },
        {
            id: '#event-content',
            container: '.billboard-content-sidebar',
            url: '/api/event?theme=Billboard',
            //date: 'month'
        },
        {
            id: '#absent-teacher-content',
            container: '.billboard-content-sidebar',
            url: '/api/absent_teacher?theme=Billboard',
        },
        {
            id: '#cancelled-content',
            container: '.billboard-content-sidebar',
            url: '/api/schedule?theme=Billboard&cancelled=true&view=cancelled',
            date: 'day'
        },
        {
            id: '#transit-content',
            container: '.billboard-content-sidebar',
            url: '/api/public_transit?stop_area_code=hmonoo&theme=Billboard',
            date: 'day'
        },
        {
            id: '#time-content',
            container: '.billboard-content-sidebar',
            url: 'http://ictcollege.eu/time.php?theme=Billboard&cancelled=true&view=cancelled',
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
                url: '/billboard/version_check/check.json',
                cache: false,
                success: function(json) {
                    billboard.version.current = json.version.current;
                },
                dataType: 'json'
            });
        } else {
            $.ajax({
                url: '/billboard/version_check/check.json?hash=' + billboard.version.current,
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
        
        var contentHeight = $('.billboard-actual-content', $(selector)).outerHeight(true);
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
                    $(id).fadeOut(function () {
                        $(id).html(html);
                        $(id).fadeIn(function () {                            
                            billboard.scroll(entry.container, false);
                        });
                    });
                } else {
                    $(id).html(html);
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
            $('.billboard-content-main').css('height', $(window).height() - $('.billboard-content-main').offset().top - 25);
            $('.billboard-content-sidebar').css('height', $(window).height() - $('.billboard-content-sidebar').offset().top - 25);
        }).resize();
        
	setInterval(function(){
		billboard.update();
	}, billboard.interval * 1000);
	
	setInterval(function(){                
		billboard.checkVersion();
	}, 2 * 1000);
});
