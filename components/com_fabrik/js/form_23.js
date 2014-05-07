Fabrik.addEvent('fabrik.form.elements.added', function (block) {

	jQuery('#mainTab a:last').tab('show');
	jQuery('#mainTab a').first().tab('show');
	jQuery('.inputbox, textarea, select').addClass('form-control');	
	jQuery('select.input-large').removeClass('input-large');
	jQuery('input.input-small').removeClass('input-small');

	//console.log(dataObject);
	//console.log(tipoRecibo);
	
	if ( typeof(dataObject) != "undefined" ) {
		jQuery('#gjr_recibos___cliente-auto-complete').val( dataObject.cliente.nombre );
		jQuery('#gjr_recibos___cliente').val( dataObject.cliente.id );
		
		jQuery('#gjr_recibos___nomenclatura-auto-complete').val( dataObject.nomenclatura.nombre );
		jQuery('#gjr_recibos___nomenclatura').val( dataObject.nomenclatura.id );
		
		jQuery('#gjr_recibos___segun').val( dataObject.segun );
		
		jQuery('#gjr_recibos___codigo').val( dataObject.codigo );
		
		jQuery(window).load( function() {
			var repeat_num = dataObject.detalle.length-1;				
			while(repeat_num){
				repeat_num--;						
				jQuery('#group66 a.addGroup').last()[0].click();						
			}
			
			for(var i=0, len = dataObject.detalle.length; i<len; i++){
				//console.log(dataObject.detalle[i]);
				jQuery('#join___203___gjr_recibos_66_repeat___descripcion_' + i).val( dataObject.detalle[i].descripcion );
				jQuery('#join___203___gjr_recibos_66_repeat___vencimiento_' + i + '_cal').val( dataObject.detalle[i].vencimiento );
				jQuery('#join___203___gjr_recibos_66_repeat___moneda_' + i).val( dataObject.detalle[i].moneda );
				jQuery('#join___203___gjr_recibos_66_repeat___importe_' + i).val( dataObject.detalle[i].importe );
			}
		});
	}
	/* tipoRecibo y dataObject son variables cargadas en la plantilla del recibo		
	switch ( tipoRecibo ) {
		
		case 'Operación':
				var counter = params.gjr_operacion_44_repeat___monto.value.length;
				//console.log(counter);
				
				addGroup('group66', counter);
				
				for(var i=0, len = params.gjr_operacion_44_repeat___monto.value.length; i<len; i++){
					jQuery('#join___203___gjr_recibos_66_repeat___descripcion_' + i).val( 'Ingreso: ' + params.gjr_operacion___descripcion );
					jQuery('#join___203___gjr_recibos_66_repeat___moneda_' + i).val( params.gjr_operacion_44_repeat___moneda.value.value[i] );
					jQuery('#join___203___gjr_recibos_66_repeat___importe_' + i).val( params.gjr_operacion_44_repeat___monto.value[i] );
				}
			break;
		
		case 'Cobranza':
			
				jQuery('#gjr_recibos___cliente-auto-complete').val( dataObject.cliente.nombre );
				jQuery('#gjr_recibos___cliente').val( dataObject.cliente.id );
				
				jQuery('#gjr_recibos___nomenclatura-auto-complete').val( dataObject.nomenclatura.nombre );
				jQuery('#gjr_recibos___nomenclatura').val( dataObject.nomenclatura.id );
				
				jQuery('#gjr_recibos___segun').val( dataObject.segun );
				
				jQuery('#gjr_recibos___codigo').val( dataObject.codigo );
				
				jQuery(window).load( function() {
					var repeat_num = dataObject.detalle.length-1;				
					while(repeat_num){
						repeat_num--;						
						jQuery('#group66 a.addGroup').last()[0].click();						
					}
					
					for(var i=0, len = dataObject.detalle.length; i<len; i++){
						//console.log(dataObject.detalle[i]);
						jQuery('#join___203___gjr_recibos_66_repeat___descripcion_' + i).val( dataObject.detalle[i].descripcion );
						jQuery('#join___203___gjr_recibos_66_repeat___vencimiento_' + i + '_cal').val( dataObject.detalle[i].vencimiento );
						jQuery('#join___203___gjr_recibos_66_repeat___moneda_' + i).val( dataObject.detalle[i].moneda );
						jQuery('#join___203___gjr_recibos_66_repeat___importe_' + i).val( dataObject.detalle[i].importe );
					}
				});
				
			break;
	
	}*/

});	