jQuery.noConflict();
jQuery(function($) {
	$(document).ready(function() {
	
		// Relación con Emprendimiento
		$.fn.handlerRelacionEmprendimiento = function() {
			if ( $(this).prop('checked') ) {			
				$('#form_group_gjr_gasto___prorratear, #form_group_gjr_gasto___emprendimiento').fadeIn();
			} else {
				$('#form_group_gjr_gasto___prorratear, #form_group_gjr_gasto___emprendimiento').fadeOut();
			}
		}	

		// TC Referencia Monto
		jQuery.fn.handlerTCMonto = function() {
			var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_gasto_110_repeat___tc_referencia input');
			if ( jQuery(this).val() == 7 )
				tcinput.val(0).fadeOut();
			else 
				tcinput.fadeIn();			
		};		
		
		// Init
		$('#form_group_gjr_cuenta___haber, #form_group_gjr_cuenta___debe, #form_group_gjr_cuenta___saldo').hide();
		$('#form_group_gjr_cuenta___tipo, #form_group_gjr_cuenta___subtipo, #form_group_gjr_cuenta___fecha_inicio, #form_group_gjr_cuenta___fecha_cierre').removeClass('col-lg-12').addClass('col-lg-6');
		$('#form_group_gjr_gasto___operacion_id, #form_group_gjr_gasto___relacion_emprendimiento, #form_group_gjr_gasto___emprendimiento, #form_group_gjr_gasto___prorratear').removeClass('col-lg-4').addClass('col-lg-3');
		$('#form_group_gjr_gasto___descripcion').removeClass('col-lg-4').addClass('col-lg-12');
		
		if ($('#gjr_gasto___operacion_id').val() == '') {
			$('#form_group_gjr_gasto___operacion_id').hide();
		} else {
			$('#gjr_gasto___operacion_id').after('<a href="/index.php?option=com_fabrik&view=details&formid=13&rowid='+$('#gjr_gasto___operacion_id').val()+'">Ver Operación</a>');
		}
		
		$('#form_group_gjr_gasto___relacion_emprendimiento input').live('change', function() {
			$(this).handlerRelacionEmprendimiento();
		}).handlerRelacionEmprendimiento();
		
		jQuery('.fabrikRepeatGroup___gjr_gasto_110_repeat___moneda select').live('change', function() {		
			jQuery(this).handlerTCMonto()
		}).handlerTCMonto();
		
	});
});	