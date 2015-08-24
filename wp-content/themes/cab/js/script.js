var s, offset;
$(document).ready(function() {
	// $('#sidebar-nav').sticky({topSpacing:16});
	// $('#sidebar-nav').stickyMojo({footerID: '#phantom-footer', contentID: '#content-wrapper'});

	// $('#sidebar-nav h3 a').smoothScroll({});

	// smoothScroll.init({
	// 	speed: 500, // Integer. How fast to complete the scroll in milliseconds
	//     easing: 'easeInOutCubic', // Easing pattern to use
	//     updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
	// });
	$(window).load(function() {

		function adjustWindow(){
		     
		    // Init Skrollr for 768 and up
		    if( $(window).width() >= 768) {
		 
		        // Init Skrollr
		        s = skrollr.init({
		            smoothScrolling: false
		        });
		        offset = 0;
        		$('.bg-vibrant .program-header').scrollToFixed( {
			        marginTop: 0,
			        limit: function() {
			        	return $('.bg-vibrant').offset().top + $('.bg-vibrant').height() - $('.bg-vibrant .program-header').outerHeight() - offset
			        }
			    });
		 
		 
		    } else {
		    	offset = 10000;
		    	if(s) {
		    		s.destroy();
		    	}
		    }
		 
		}
		function initAdjustWindow() {
		    return {
		        match : function() {
		            adjustWindow();
		        },
		        unmatch : function() {
		            adjustWindow();
		        }
		    };
		}
		enquire.register("screen and (min-width : 768px)", initAdjustWindow(), false);
	});
	$('#show-all-exhibitors').click(function() {
		// $(this).toggle();
		$(this).add('.name-list#entire-list, .name-list#featured-list, #hide-all-exhibitors').toggle();
	});
	$('#hide-all-exhibitors').click(function() {
		$(this).add('.name-list#entire-list, .name-list#featured-list, #show-all-exhibitors').toggle();
		// $('html, body').animate({
	 //        scrollTop: $('#exhibitors').get(0).scrollHeight
	 //    }, 300);
	});
});