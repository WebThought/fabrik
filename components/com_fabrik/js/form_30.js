Fabrik.addEvent('fabrik.form.elements.added', function (block) {

	jQuery('.inputbox, textarea, select').addClass('form-control');	
	jQuery('select.input-large').removeClass('input-large');
	jQuery('input.input-small').removeClass('input-small');

	console.log(dataObject);	
	
	if ( typeof(dataObject) != "undefined" ) {
		
		jQuery('#gjr_recibos_inversores___posiciones_inversor, .fake_gjr_recibos_inversores___posiciones_inversor').val( dataObject.posiciones_inversor );
		jQuery('#gjr_recibos_inversores___posicion_valor, .fake_gjr_recibos_inversores___posicion_valor').val( dataObject.posicion_valor );
		jQuery('#gjr_recibos_inversores___inversion_total, .fake_gjr_recibos_inversores___inversion_total').val( dataObject.inversion_total );
		jQuery('#gjr_recibos_inversores___posiciones').val( dataObject.posiciones );
		
		jQuery('#gjr_recibos_inversores___inversor, .fake_gjr_recibos_inversores___inversor').val( dataObject.inversor.nombre );
		jQuery('#gjr_recibos_inversores___inversor_nacionalidad').val( dataObject.inversor.nacionalidad );
		jQuery('#gjr_recibos_inversores___inversor_idn, .fake_gjr_recibos_inversores___inversor_idn').val( dataObject.inversor.idn );
		jQuery('#gjr_recibos_inversores___inversor_cuit_cuil').val( dataObject.inversor.cuit_cuil );
		jQuery('#gjr_recibos_inversores___inversor_domicilio, .fake_gjr_recibos_inversores___inversor_domicilio').val( dataObject.inversor.domicilio );
		
		jQuery('#gjr_recibos_inversores___aportes_textos').val( dataObject.aportes_textos );		
		jQuery('#gjr_recibos_inversores___posicion_valor_texto').val( dataObject.posicion_valor_texto );		
		
		jQuery('#gjr_recibos_inversores___emprendimiento, .fake_gjr_recibos_inversores___emprendimiento').val( dataObject.emprendimiento.nombre );
		jQuery('#gjr_recibos_inversores___emprendimiento_nomenclatura').val( dataObject.emprendimiento.nomenclatura );
		jQuery('#gjr_recibos_inversores___emprendimiento_direccion').val( dataObject.emprendimiento.direccion );
		jQuery('#gjr_recibos_inversores___emprendimiento_descripcion').val( dataObject.emprendimiento.descripcion );
		
		// Gastos
		jQuery('#gjr_recibos_inversores___gasto_costo_terreno').val( dataObject.gastos.gasto_costo_terreno );
		jQuery('#gjr_recibos_inversores___gasto_honorarios_comprador').val( dataObject.gastos.gasto_honorarios_comprador );
		jQuery('#gjr_recibos_inversores___gasto_planos').val( dataObject.gastos.gasto_planos );
		jQuery('#gjr_recibos_inversores___gasto_escritura').val( dataObject.gastos.gasto_escritura );
		jQuery('#gjr_recibos_inversores___gasto_desmonte_calle_electricidad').val( dataObject.gastos.gasto_desmonte_calle_electricidad );
		jQuery('#gjr_recibos_inversores___gasto_administracion').val( dataObject.gastos.gasto_administracion );
		
	}

});	