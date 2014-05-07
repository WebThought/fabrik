!function ($) {
  $(function(){
		jQuery('*[rel=tooltip]').tooltip()
		jQuery('*[rel=popover]').popover({trigger: "hover"})

		// sidebar Toggle
	$(".sidebar-toggle").click(function(){
		$(".sidebar").toggleClass("active");
		$(".content").toggleClass("content-sidebar");
		$("body").toggleClass("body-sidebar");
		$(".navbar-fixed-top").toggleClass("header-sidebar");
		return false;
	});
	$('.sidebar').bind('clickoutside', function (event) {
		$(".sidebar").removeClass("active");
	});
	// aside Toggle
	$(".aside-toggle").click(function(){
		$(".aside").toggleClass("active");
		$(".content").toggleClass("content-aside");
		$("body").toggleClass("body-aside");
		$(".navbar-fixed-top").toggleClass("header-aside");
		return false;
	});
	$('.aside').bind('clickoutside', function (event) {
		$(".aside").removeClass("active");
	});

	// auto-toggle sidebar
	/*
	function checkWidth(init)
	{
	    if ($(window).width() > 992) {
	    	$(".sidebar").addClass("active");
	        $('.content').addClass('content-sidebar');
	        $(".navbar-fixed-top").addClass("header-sidebar");
	    }
	    else {
	        if (!init) {
	        	$(".sidebar").removeClass("active");
	            $('.content').removeClass('content-sidebar');
	            $(".navbar-fixed-top").removeClass("header-sidebar");
	        }
	    }
	}

	$(document).ready(function() {
	    checkWidth(true);

	    $(window).resize(function() {
	        checkWidth(false);
	    });
	});
	*/

	//Affix toolbar
	$('.btn-toolbar-top').affix()
	$(function() {
	    $(".btn-toolbar-top").height();
	    
	    $('.btn-toolbar-top').affix({
	        offset: { top: $('.btn-toolbar-top').offset().top }
	    });
	});

    // Animate progress bars
    $(function(){
			$('.progress .progress-bar').each(function() {
				var bar = $(this);
				var perc = bar.attr("aria-valuenow");
				var current_perc = 0;
	            var progress = setInterval(function() {
					if (current_perc>=perc) {
						clearInterval(progress);
					} else {
						current_perc +=1;
						bar.css('width', (current_perc)+'%');
					}
				}, 0);
			});
		});
	})
  
}(window.jQuery)

