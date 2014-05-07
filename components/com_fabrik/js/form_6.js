window.addEvent('fabrik.loaded', function() {    
	jQuery('#gjr_persona___persona_juridica').on('click', function() {				
		var checked = jQuery('#gjr_persona___persona_juridica input').prop('checked');				
		
		if (checked)
			/* Hide */ jQuery('#gjr_persona___idn, #gjr_persona___pais_documento-auto-complete, #gjr_persona___sexo, #gjr_persona___fecha_nacimiento').parents('.control-group').fadeOut();
		else
			/* Display */ jQuery('#gjr_persona___idn, #gjr_persona___pais_documento-auto-complete, #gjr_persona___sexo, #gjr_persona___fecha_nacimiento').parents('.control-group').fadeIn();
	});
    
    // Update Alert Counter
    jQuery(document).on('click', '.fabrikRepeatGroup___gjr_persona_117_repeat___leido label' , function() {        
		var badgeCount = jQuery('.fabrikRepeatGroup___gjr_persona_117_repeat___leido label.btn-danger').length; 
        if (badgeCount == 0) {
            jQuery('#group117_tab .badge').remove();
        } else {            
            jQuery('#group117_tab').html('Alertas <span class="badge badge-important">' + badgeCount + '</span>');
        }
	});	
    
});	