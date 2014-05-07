jQuery.noConflict();
jQuery(function($) {
	$(document).ready(function() {
		
		// TC Referencia Entrada
		jQuery.fn.handlerTCRefEntrada = function() {
			var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_operacion_44_repeat___tc_referencia input');
			if ( jQuery(this).val() == 7 )
				tcinput.val(0).fadeOut();
			else 
				tcinput.fadeIn();			
		};
		// TC Referencia Salida
		jQuery.fn.handlerTCRefSalida = function() {
			var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_operacion_45_repeat___tc_referencia input');
			if ( jQuery(this).val() == 7 )
				tcinput.val(0).fadeOut();
			else 
				tcinput.fadeIn();			
		};
	
		function handlerMovimiento() {
			$('#group45 #join___146___gjr_operacion_45_repeat___monto_0').val( $('#group44 #join___145___gjr_operacion_44_repeat___monto_0').val() );			
		}
	
		function revisarTipoOperacion() {
			if ( $('#gjr_operacion___tipo').val() == 'M' ) {
				/* Display */
				$('#group44, #group45').fadeIn();
				
				var form = Fabrik.blocks.form_13;
				
				jQuery('#group44 .fabrikSubGroup').each( function(z) {
					if ( z >= 1 ) {
						var btn = jQuery(this).find('.deleteGroup img').get(0);				
						if (typeOf(btn) !== 'null') {
							var e = new Event.Mock(btn, 'click');
							console.log(e);
							form.deleteGroup(e);					
						}
					}					
				});
				
				jQuery('#group45 .fabrikSubGroup').each( function(z) {
					if ( z >= 1 ) {
						var btn = jQuery(this).find('.deleteGroup img').get(0);				
						if (typeOf(btn) !== 'null') {
							var e = new Event.Mock(btn, 'click');
							console.log(e);
							form.deleteGroup(e);					
						}
					}					
				});
				
				/* Hide */
				$('#group44 .addGroup, #group45 .addGroup, #group44 .deleteGroup, #group45 .deleteGroup').hide();
				$('#group45 #join___146___gjr_operacion_45_repeat___monto_0').attr('readonly', 'readonly').hide();
				
				$('#group44 .inputbox.decimal').bind( 'change', handlerMovimiento );
			} else if ($('#gjr_operacion___tipo').val() == 'I') {
				/* Hide */
				$('#group45').fadeOut();
				
				/* Display */
				$('#group44').fadeIn();
				$('#group44 .addGroup, #group45 .addGroup, #group44 .deleteGroup, #group45 .deleteGroup').show();				
				
				$('#group44 .inputbox.decimal').unbind( 'change', handlerMovimiento );
			} else if ($('#gjr_operacion___tipo').val() == 'E') {
				/* Hide */
				$('#group44').fadeOut();
				
				/* Display */
				$('#group45').fadeIn();
				$('#group44 .addGroup, #group45 .addGroup, #group44 .deleteGroup, #group45 .deleteGroup').show();				
				
				$('#group45 #join___146___gjr_operacion_45_repeat___monto_0').removeAttr('readonly').show();
				$('#group44 .inputbox.decimal').unbind( 'change', handlerMovimiento );
			} else
				alert('Movimiento no reconocido');
		}
		
		$('#gjr_operacion___tipo').bind('change', revisarTipoOperacion);
		revisarTipoOperacion();
		
		jQuery('.fabrikRepeatGroup___gjr_operacion_44_repeat___moneda select').live('change', function() {
			jQuery(this).handlerTCRefEntrada();
		}).handlerTCRefEntrada();
		jQuery('.fabrikRepeatGroup___gjr_operacion_45_repeat___moneda select').live('change', function() {
			jQuery(this).handlerTCRefSalida();
		}).handlerTCRefSalida();
		
	});
});	