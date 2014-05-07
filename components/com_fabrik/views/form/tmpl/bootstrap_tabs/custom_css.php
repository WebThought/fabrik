<?php
/**
 * Default Form Template: Custom CSS
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 ?>
<?php

/**
 * If you need to make small adjustments or additions to the CSS for a Fabrik
 * template, you can create a custom_css.php file, which will be loaded after
 * the main template_css.php for the template.
 *
 * This file will be invoked as a PHP file, so the view type and form ID
 * can be used in order to narrow the scope of any style changes.  You do
 * this by prepending #{$view}_$c to any selectors you use.  This will become
 * (say) #form_12, or #details_11, which will be the HTML ID of your form
 * on the page.
 *
 * See examples below, which you should remove if you copy this file.
 *
 * Don't edit anything outside of the BEGIN and END comments.
 *
 * For more on custom CSS, see the Wiki at:
 *
 * http://fabrikar.com/wiki/index.php/3.x_Form_Templates#Custom_CSS
 *
 * NOTE - for backward compatibility with Fabrik 2.1, and in case you
 * just prefer a simpler CSS file, without the added PHP parsing that
 * allows you to be be more specific in your selectors, we will also include
 * a custom.css we find in the same location as this file.
 *
 */

header('Content-type: text/css');
$c = (int) $_REQUEST['c'];
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'form';
echo "

/* Persona */
#{$view}_$c #gjr_persona___sexo { min-height: 45px; }
#{$view}_$c .fabrikRepeatGroup___gjr_persona_17_repeat___geo { float: right; }
#{$view}_$c select#gjr_persona___nacionalidad,
#{$view}_$c select#gjr_persona___pais_documento { font-size: 14px !important; min-height: 40px; }
.fabrikGroupRepeater { text-align: right; }
#{$view}_$c #form_group_gjr_persona___fecha_ingreso { clear: left; }

/* Recibos */
#{$view}_$c #group65 legend { display: none; }

/* Emprendimiento */
#{$view}_$c #form_group_gjr_emprendimiento___direccion_geo { float: right; }
#{$view}_$c #form_group_join___242___gjr_emprendimiento_72_repeat___costo_0 { clear: left; }
#{$view}_$c #group72 .fabrikSubGroup { border-bottom: 1px solid #EEE; padding-bottom: 20px; }
#{$view}_$c #escritura_boleto { float: left; width: 50%; }
#{$view}_$c #escritura_escritura { float: right; width: 50%; }
#{$view}_$c .fabrikRepeatGroup___gjr_emprendimiento_69_repeat___inversion_total span.fabrikinput { display: block; display: block; width: 100%; height: 38px; padding: 8px 12px; font-size: 14px; line-height: 1.428571429; color: #555; vertical-align: middle; background-color: #EEE; border: 1px solid #ccc; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075); box-shadow: inset 0 1px 1px rgba(0,0,0,0.075); -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; }
#{$view}_$c .fabrikRepeatGroup___gjr_emprendimiento_69_repeat___gastos_titulo,
.fabrikRepeatGroup___gjr_emprendimiento_69_repeat___beneficios_titulo { clear: left; }
#{$view}_$c #group69 .fabrikSubGroup { border: 1px solid #DDD; margin-bottom: 20px; border-radius: 5px; padding: 0 10px; }
#{$view}_$c #group69 .fabrikSubGroup .fabrikSubGroupElements { border-top: 1px solid #DDD; padding-top: 5px; }

/* Venta de Propiedades */
#{$view}_$c #form_group_gjr_venta_propiedad___inmueble { clear: left; }
#{$view}_$c #form_group_gjr_venta_propiedad___financiacion_moneda,
#{$view}_$c #form_group_gjr_venta_propiedad___fecha_primera_cuota { clear: left; }
#{$view}_$c #form_group_gjr_venta_propiedad___total_financiacion label,
#{$view}_$c #form_group_gjr_venta_propiedad___total_financiacion span.fabrikinput { float: left; }
#{$view}_$c #form_group_gjr_venta_propiedad___total_financiacion span.fabrikinput { clear: left; }
#{$view}_$c #form_group_gjr_venta_propiedad___button_operacion_detalle { text-align: left; padding-top: 28px !important; }
#{$view}_$c #form_group_gjr_venta_propiedad___button_agregar_cuotas { text-align: center; }

";
?>