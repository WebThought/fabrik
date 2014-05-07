// Emprendimientos
window.addEvent('fabrik.loaded', function() {    	
    // Nomenclatura
    jQuery('#gjr_emprendimiento___circunscripcion, #gjr_emprendimiento___seccion, #gjr_emprendimiento___chacra_quinta, #gjr_emprendimiento___fraccion, #gjr_emprendimiento___manzana, #gjr_emprendimiento___parcela, #gjr_emprendimiento___unidad_funcional').bind('keyup change', function() {			
        var string = new Array();
        if ( jQuery('#gjr_emprendimiento___circunscripcion').val().length > 0 )
            string.push('Circunscripción: ' + jQuery('#gjr_emprendimiento___circunscripcion').val());
        if ( jQuery('#gjr_emprendimiento___seccion').val().length > 0 )
            string.push('Sección: ' + jQuery('#gjr_emprendimiento___seccion').val());
        if ( jQuery('#gjr_emprendimiento___chacra_quinta').val().length > 0 )
            string.push('Chacra/Quinta: ' + jQuery('#gjr_emprendimiento___chacra_quinta').val());
        if ( jQuery('#gjr_emprendimiento___fraccion').val().length > 0 )
            string.push('Fracción: ' + jQuery('#gjr_emprendimiento___fraccion').val());
        if ( jQuery('#gjr_emprendimiento___manzana').val().length > 0 )
            string.push('Manzana: ' + jQuery('#gjr_emprendimiento___manzana').val());
        if ( jQuery('#gjr_emprendimiento___parcela').val().length > 0 )
            string.push('Parcela: ' + jQuery('#gjr_emprendimiento___parcela').val());
        if ( jQuery('#gjr_emprendimiento___unidad_funcional').val().length > 0 )
            string.push('UF: ' + jQuery('#gjr_emprendimiento___unidad_funcional').val());

        jQuery('#gjr_emprendimiento___nomenclatura').val( string.join(' | ') );
    });

    jQuery('#form_group_gjr_emprendimiento___fecha_boleto, #form_group_gjr_emprendimiento___vendedores, #form_group_gjr_emprendimiento___compradores').wrapAll( "<div id='escritura_boleto'></div>" );
    jQuery('#form_group_gjr_emprendimiento___fecha_escritura, #form_group_gjr_emprendimiento___numero_escritura, #form_group_gjr_emprendimiento___fecha_inscripcion, #form_group_gjr_emprendimiento___numero_inscripcion').wrapAll( "<div id='escritura_escritura'></div>" );
    jQuery('#escritura_boleto').prepend('<h3>Boleto</h3>');
    jQuery('#escritura_escritura').prepend('<h3>Escritura</h3>');

    // Solapa Proyecto
    jQuery('.fabrikRepeatGroup___gjr_emprendimiento_69_repeat___gastos_titulo, .fabrikRepeatGroup___gjr_emprendimiento_69_repeat___beneficios_titulo').removeClass('col-lg-6').addClass('col-lg-12');
    jQuery('.fabrikRepeatGroup___gjr_emprendimiento_69_repeat___periodo_beneficio_estimado, .fabrikRepeatGroup___gjr_emprendimiento_69_repeat___periodo_recupero_capital, .fabrikRepeatGroup___gjr_emprendimiento_69_repeat___porcentaje_beneficio_estimado').removeClass('col-lg-6').addClass('col-lg-4');

});	

