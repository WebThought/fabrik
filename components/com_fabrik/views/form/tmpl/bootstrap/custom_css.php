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

/* Operaciones */
#{$view}_$c #form_group_gjr_operacion___tipo, #{$view}_$c #form_group_gjr_operacion___descripcion { clear: left; }

/* Recibos */
#{$view}_$c #group65 legend { display: none; }

/* Inmuebles */
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria { clear: right; }
#{$view}_$c #form_group_gjr_inmueble___direccion_geo { float: right; }
#{$view}_$c #form_group_gjr_inmueble___direccion_geo .geo { display: none; }
#{$view}_$c #form_group_gjr_inmueble___tipo,
#{$view}_$c #form_group_gjr_inmueble___estado,
#{$view}_$c #form_group_join___265___gjr_inmueble_repeat_fotos___fotos,
#{$view}_$c #form_group_gjr_inmueble___superficie_total,
#{$view}_$c #form_group_gjr_inmueble___tasacion_moneda,
#{$view}_$c #form_group_gjr_inmueble___codigo,
#{$view}_$c #form_group_gjr_inmueble___direccion,
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria_descripcion { clear: left; }
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria_descripcion,
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria_financia,
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria_persona,
#{$view}_$c #form_group_gjr_inmueble___inmobiliaria_link { display: none; }	

/* Cobranza */
#{$view}_$c #form_group_gjr_cobranza___monto { clear: left; }
#{$view}_$c #group82 legend { display: none; }

/* Gastos */
#{$view}_$c #group108 legend { display: none; }
#{$view}_$c #form_group_gjr_gasto___descripcion,
#{$view}_$c #form_group_gjr_gasto___operacion_id { clear: left; }
#{$view}_$c #form_group_gjr_gasto___emprendimiento,
#{$view}_$c #form_group_gjr_gasto___prorratear { display: none; }
#{$view}_$c #form_group_gjr_gasto___descripcion textarea { width: 100%; }

";
?>