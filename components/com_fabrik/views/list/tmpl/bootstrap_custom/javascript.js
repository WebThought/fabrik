window.addEvent('fabrik.loaded', function() {	    
	jQuery(document).on('click', '.fabrik_row', function () {		        
		var checkbox = jQuery(this).find('input[type="checkbox"]');
		if (checkbox.prop('checked')) {
			checkbox.prop('checked', false);
			jQuery(this).removeClass('warning');
		} else {
			checkbox.prop('checked', true);
			jQuery(this).addClass('warning');
		}
	});			
});