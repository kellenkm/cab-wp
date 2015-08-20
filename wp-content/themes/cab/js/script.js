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
		var s = skrollr.init();
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