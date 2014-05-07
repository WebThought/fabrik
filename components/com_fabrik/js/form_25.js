function totalFinanciacion() {
    var total = 0;
	jQuery('#group80 tr').each( function() {
		var moneda = jQuery(this).find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_moneda select').val();
		var cantidad = jQuery(this).find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_cantidad input').val();
		var valores = jQuery(this).find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_valor input').val();
		var tcRef = jQuery(this).find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___tc_referencia input').val();
		
		if ( moneda == undefined )
			return true; // Continue
		
		if ( moneda == 7 )
			total += parseFloat(cantidad*valores);
		else
			total += parseFloat(cantidad*valores*tcRef);
	});
	
	jQuery('#gjr_venta_propiedad___total_financiacion').val( 'ARS ' + total);
}

Fabrik.addEvent('fabrik.form.group.duplicate.end', function(form, event, groupId, repeatCounter) {	
	if (groupId = 80) // Cuotas
		totalFinanciacion();
});

Fabrik.addEvent('fabrik.form.submit.start', function(form, event, button) {
    // Remuevo disable de los select para poder enviarlos.
	jQuery('#group88 select').removeAttr('disabled');    
});

jQuery.noConflict();
jQuery(document).ready(function() {
	
	// TC Referencia Valor Venta
	jQuery.fn.handlerTCValorVenta = function() {
		var tcinput = jQuery('#gjr_venta_propiedad___tc_referencia');
		if ( jQuery(this).val() == 7 || jQuery(this).val() == 7 )
			tcinput.val(0).parents('.form-group').fadeOut();
		else 
			tcinput.parents('.form-group').fadeIn();
	}
	
	// Boleto
	jQuery.fn.handlerBoleto = function() {
		if ( jQuery(this).prop('checked') ) {			
			jQuery('#group88 input').attr('readonly', 'readonly');
			jQuery('#group88 select').attr('disabled', 'disabled');
			jQuery('#boleto_tab').show();
		} else {
			jQuery('#group88 input').removeAttr('readonly');
			jQuery('#group88 select').removeAttr('disabled');
			jQuery('#boleto_saldo').fadeOut();
			jQuery('#boleto_tab').hide();
		}
	}
	
	// Inmobiliaria
	jQuery.fn.handlerInmobiliaria = function() {
		if ( jQuery(this).val() == 'No' ) {			
			jQuery('#boleto_saldo').fadeIn();
			jQuery('#honorarios_contado').fadeOut();			
			jQuery('#join___368___gjr_venta_propiedad_87_repeat___vendedor').parents('.form-group').fadeIn();
		} else {
			jQuery('#boleto_saldo').fadeOut();
			jQuery('#honorarios_contado').fadeIn();
			jQuery('#join___368___gjr_venta_propiedad_87_repeat___vendedor').parents('.form-group').fadeOut();  // El vendedor no es necesario si la venta es de un emprendimiento
		}
	}
	
	// TC Referencia Anticipo
	jQuery.fn.handlerTCAnticipo = function() {
		var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_89_repeat___tc_referencia input');
		if ( jQuery(this).val() == 7 )
			tcinput.val(0).fadeOut();
		else 
			tcinput.fadeIn();			
	};	
		
	// TC Referencia Cuotas
	jQuery.fn.handlerTCCuotas = function() {
		var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___tc_referencia input');
		if ( jQuery(this).val() == 7 )
			tcinput.val(0).fadeOut();
		else 
			tcinput.fadeIn();
	};
	
	// TC Referencia Saldo Boleto
	jQuery.fn.handlerTCSaldo = function() {
		var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_105_repeat___saldo_tc_referencia input');
		if ( jQuery(this).val() == 7 )
			tcinput.val(0).fadeOut();
		else 
			tcinput.fadeIn();			
	};
	
	// TC Referencia Honorarios Comprador
	jQuery.fn.handlerTCHonorariosC = function() {		
		var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_100_repeat___honorarios_comprador_tc_referencia input');
		if ( jQuery(this).val() == 7 )
			tcinput.val(0).fadeOut();
		else 
			tcinput.fadeIn();			
	};
	
	// TC Referencia Honorarios Vendedor
	jQuery.fn.handlerTCHonorariosV = function() {
		var tcinput = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_101_repeat___honorarios_vendedor_tc_referencia input');
		if ( jQuery(this).val() == 7 )
			tcinput.val(0).fadeOut();
		else 
			tcinput.fadeIn();			
	};
		
	// Forma de Pago
	jQuery.fn.handlerFormaPago = function() {	
		formaPagoInput = jQuery(this).find('input:checked');		
		if( formaPagoInput.val() == 'Financiado' ) {
			jQuery('#financiacion_tab').fadeIn();
			jQuery('#reserva, #honorarios_contado').fadeOut();			
			jQuery('#boleto_saldo, #honorarios_contado').fadeOut();
		} else {
			jQuery('#financiacion_tab').fadeOut();		
			jQuery('#reserva').fadeIn();
			jQuery("#gjr_venta_propiedad___inmobiliaria").handlerInmobiliaria();			
		}
	};
	
	// Tipo de Cuota
	jQuery.fn.handlerTipoCuota = function() {			
		var input_cant_cuotas = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_cantidad input');
		var select_frecuencia = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_frecuencia select');
		var div_vencimiento = jQuery(this).parents('.fabrikSubGroup').find('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___especial_vencimiento .fabrikSubElementContainer');
		
		if ( jQuery(this).val() == 'Vencimiento' ) {
			input_cant_cuotas.val( 1 ).attr('readonly', true);
			select_frecuencia.val('').fadeOut();
			div_vencimiento.fadeIn();
		} else {
			input_cant_cuotas.attr('readonly', false);
			select_frecuencia.fadeIn();
			div_vencimiento.fadeOut().find('input').val('');
		}
	};
	
	/************ Init ************/
	jQuery('#mainTab a:last').tab('show');
	jQuery('#mainTab a').first().tab('show');
	jQuery('.inputbox, textarea, select').addClass('form-control');	
	jQuery('select.input-large').removeClass('input-large');
	
	jQuery('#gjr_venta_propiedad___monto_moneda').live('change', function() {
		jQuery(this).handlerTCValorVenta()
	}).handlerTCValorVenta();
	
	jQuery('#join___368___gjr_venta_propiedad_87_repeat___boleto input').live('change', function() {		
		jQuery(this).handlerBoleto();
	}).handlerBoleto();
	
	jQuery("#gjr_venta_propiedad___inmobiliaria").observe_field(1, function( ) {
		jQuery(this).handlerInmobiliaria();		
    });	
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_89_repeat___anticipo_moneda select').live('change', function() {
		jQuery(this).handlerTCAnticipo()
	}).handlerTCAnticipo();
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_105_repeat___saldo_moneda select').live('change', function() {		
		jQuery(this).handlerTCSaldo()
	}).handlerTCSaldo();
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda select').live('change', function() {		
		jQuery(this).handlerTCHonorariosC()
	}).handlerTCHonorariosC();
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_101_repeat___honorarios_vendedor_moneda select').live('change', function() {		
		jQuery(this).handlerTCHonorariosV()
	}).handlerTCHonorariosV();
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_moneda select').live('change', function() {
		jQuery(this).handlerTCCuotas()
	}).handlerTCCuotas();
	
	jQuery('#gjr_venta_propiedad___forma_pago li').live('click', function() {
		jQuery(this).handlerFormaPago()
	}).handlerFormaPago();
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_tipo select').live('change', function() {
		jQuery(this).handlerTipoCuota();
	}).each( function() {
		jQuery(this).handlerTipoCuota();
	});
	
	jQuery('.fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_moneda select, .fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_cantidad input, .fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___cuotas_moneda input, .fabrikRepeatGroup___gjr_venta_propiedad_80_repeat___tc_referencia input').live('change keyup', function() {
		totalFinanciacion();
	});
	totalFinanciacion();
	
});	