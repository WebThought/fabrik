jQuery.noConflict();
jQuery(function($) {
	$(document).ready(function() {
		
		$('#form_group_gjr_inmueble___inmobiliaria').removeClass('col-lg-3').addClass('col-lg-6');
		$('#form_group_gjr_inmueble___codigo, #form_group_gjr_inmueble___nomenclatura').removeClass('col-lg-3').addClass('col-lg-6');
		$('#form_group_gjr_inmueble___circunscripcion, #form_group_gjr_inmueble___seccion, #form_group_gjr_inmueble___chacra_quinta, #form_group_gjr_inmueble___fraccion, #form_group_gjr_inmueble___manzana').removeClass('col-lg-3').addClass('col-lg-2');
		$('#form_group_gjr_inmueble___parcela, #form_group_gjr_inmueble___unidad_funcional').removeClass('col-lg-3').addClass('col-lg-1');
		$('#form_group_join___265___gjr_inmueble_repeat_fotos___fotos').removeClass('col-lg-3').addClass('col-lg-6');
		$('#form_group_gjr_inmueble___superficie_total, #form_group_gjr_inmueble___superficie_cubierta, #form_group_gjr_inmueble___antiguedad, #form_group_gjr_inmueble___largo_terreno, #form_group_gjr_inmueble___ancho_terreno, #form_group_gjr_inmueble___cantidad_ambientes, #form_group_gjr_inmueble___precioventa, #form_group_gjr_inmueble___precioventa_moneda').removeClass('col-lg-3').addClass('col-lg-2');
		
		$('#gjr_inmueble___circunscripcion, #gjr_inmueble___seccion, #gjr_inmueble___chacra_quinta, #gjr_inmueble___fraccion, #gjr_inmueble___manzana, #gjr_inmueble___parcela, #gjr_inmueble___unidad_funcional').bind('keyup change', function() {			
			var string = new Array();
			if ( $('#gjr_inmueble___circunscripcion').val().length > 0 )
				string.push('Circunscripción: ' + $('#gjr_inmueble___circunscripcion').val());
			if ( $('#gjr_inmueble___seccion').val().length > 0 )
				string.push('Sección: ' + $('#gjr_inmueble___seccion').val());
			if ( $('#gjr_inmueble___chacra_quinta').val().length > 0 )
				string.push('Chacra/Quinta: ' + $('#gjr_inmueble___chacra_quinta').val());
			if ( $('#gjr_inmueble___fraccion').val().length > 0 )
				string.push('Fracción: ' + $('#gjr_inmueble___fraccion').val());
			if ( $('#gjr_inmueble___manzana').val().length > 0 )
				string.push('Manzana: ' + $('#gjr_inmueble___manzana').val());
			if ( $('#gjr_inmueble___parcela').val().length > 0 )
				string.push('Parcela: ' + $('#gjr_inmueble___parcela').val());
			if ( $('#gjr_inmueble___unidad_funcional').val().length > 0 )
				string.push('UF: ' + $('#gjr_inmueble___unidad_funcional').val());
			
			$('#gjr_inmueble___nomenclatura').val( string.join(' | ') );
		});
		
		$('input[name="gjr_inmueble___inmobiliaria[]"]').bind('change', function() {	
			if( $(this).val() == 'Sí' ) {
				/* Hide */ $('#form_group_gjr_inmueble___direccion, #form_group_gjr_inmueble___ciudad, #form_group_gjr_inmueble___codigo_postal, #form_group_gjr_inmueble___direccion_geo, #form_group_gjr_inmueble___provincia, #form_group_gjr_inmueble___pais, #form_group_gjr_inmueble___emprendimiento, #form_group_gjr_inmueble___nomenclatura, #form_group_gjr_inmueble___circunscripcion, #form_group_gjr_inmueble___seccion, #form_group_gjr_inmueble___chacra_quinta, #form_group_gjr_inmueble___fraccion, #form_group_gjr_inmueble___manzana, #form_group_gjr_inmueble___parcela, #form_group_gjr_inmueble___unidad_funcional, #form_group_gjr_inmueble___tipo, #form_group_gjr_inmueble___superficie_total, #form_group_gjr_inmueble___superficie_cubierta, #form_group_gjr_inmueble___antiguedad, #form_group_gjr_inmueble___largo_terreno, #form_group_gjr_inmueble___ancho_terreno, #form_group_gjr_inmueble___cantidad_ambientes').fadeOut();
				
				$('#form_group_gjr_inmueble___inmobiliaria_descripcion, #form_group_gjr_inmueble___inmobiliaria_financia, #form_group_gjr_inmueble___inmobiliaria_persona, #form_group_gjr_inmueble___inmobiliaria_link').fadeIn();
			} else {
				/* Display */ $('#form_group_gjr_inmueble___direccion, #form_group_gjr_inmueble___ciudad, #form_group_gjr_inmueble___codigo_postal, #form_group_gjr_inmueble___direccion_geo, #form_group_gjr_inmueble___provincia, #form_group_gjr_inmueble___pais, #form_group_gjr_inmueble___emprendimiento, #form_group_gjr_inmueble___nomenclatura, #form_group_gjr_inmueble___circunscripcion, #form_group_gjr_inmueble___seccion, #form_group_gjr_inmueble___chacra_quinta, #form_group_gjr_inmueble___fraccion, #form_group_gjr_inmueble___manzana, #form_group_gjr_inmueble___parcela, #form_group_gjr_inmueble___unidad_funcional, #form_group_gjr_inmueble___tipo, #form_group_gjr_inmueble___superficie_total, #form_group_gjr_inmueble___superficie_cubierta, #form_group_gjr_inmueble___antiguedad, #form_group_gjr_inmueble___largo_terreno, #form_group_gjr_inmueble___ancho_terreno, #form_group_gjr_inmueble___cantidad_ambientes').fadeIn();
				
				$('#form_group_gjr_inmueble___inmobiliaria_descripcion, #form_group_gjr_inmueble___inmobiliaria_financia, #form_group_gjr_inmueble___inmobiliaria_persona, #form_group_gjr_inmueble___inmobiliaria_link').fadeOut();
			}
		});	

	});
});	