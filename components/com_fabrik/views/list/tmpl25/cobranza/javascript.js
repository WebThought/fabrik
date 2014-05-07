/**
 * @author Robert
 */
head.ready(function() {
	Array.from($$('.fabrikList tr')).each(function(r){
		document.id(r).addEvent('mouseover', function(e){
			if (r.hasClass('oddRow0') || r.hasClass('oddRow1')){
				r.addClass('fabrikHover');
			}
		}, r);
		
		document.id(r).addEvent('mouseout', function(e){
			r.removeClass('fabrikHover');
		}, r);
		
		document.id(r).addEvent('click', function(e){
			if (r.hasClass('oddRow0') || r.hasClass('oddRow1')){
				$$('.fabrikList tr').each(function(rx){
					rx.removeClass('fabrikRowClick');
				});
				r.addClass('fabrikRowClick');
			}
		}, r);
	});
})

jQuery(document).ready( function() {
	jQuery('a.clearFilters, a.advanced-search-link').addClass('btn btn-default');
	jQuery('a.advanced-search-link').empty().html('<span class="glyphicon glyphicon-search"></span> Búsqueda');
	jQuery('a.clearFilters').empty().html('<span class="glyphicon glyphicon-filter"></span> Limpiar filtros');
});
