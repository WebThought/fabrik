jQuery.noConflict();
jQuery(function($) {
	$(document).ready(function() {
		
		$('#form_group_gjr_cuenta___haber, #form_group_gjr_cuenta___debe, #form_group_gjr_cuenta___saldo').hide();
		$('#form_group_gjr_cuenta___tipo, #form_group_gjr_cuenta___subtipo, #form_group_gjr_cuenta___fecha_inicio, #form_group_gjr_cuenta___fecha_cierre').removeClass('col-lg-12').addClass('col-lg-6');
		
	});
});	