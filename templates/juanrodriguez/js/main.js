jQuery.noConflict();
jQuery(function($) {
	$(document).ready(function() {
		
		// Twitter Bootstrap: Dropdown on Hover
		jQuery('ul.nav li.dropdown').hover(function() {
			jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
		}, function() {
			jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
		});
		
		$('.scrollto').click(function() {
			var elementClicked = $(this).attr("href");
			var destination = $(elementClicked).offset().top;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
			return false;
		});
		
		if ( $('.affix').length > 0	) {
			$('.affix').affix();			
		}	
		
		// Facebook Login
		if ( $('#user4 .facebook_button_bg').length > 0 ) {
			$('#user4 .facebook_button_bg').detach().appendTo('#user4 .header-links > div:last-child');
		}
		
		/*if ( $('#header_links .login').length > 0 ) {
			// User is not logged in
			$('nav .item-114 a').bind('click', function(event) {
				event.preventDefault();
				window.location = '/registration';
			});
		}*/
		
	});
});