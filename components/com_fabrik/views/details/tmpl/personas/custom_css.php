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
$formid = $_REQUEST['c'];
$rowid = $_REQUEST['rowid'];
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'form';
$id = $view.'_'.$formid;
if ($rowid > 0) {
    $id .= '_'.$rowid;
}
echo "
/* Persona */
#{$id} #gjr_persona___sexo { 
    min-height: 45px;
}

#{$id} .fabrikRepeatGroup___gjr_persona_17_repeat___geo { 
    float: right;
}

#{$id} select#gjr_persona___nacionalidad,
#{$id} select#gjr_persona___pais_documento { 
    font-size: 14px !important;
    min-height: 40px;
}

.fabrikGroupRepeater { 
    text-align: right;
}

#{$id} #form_group_gjr_persona___fecha_ingreso { 
    clear: left;
}

#{$id} #group17 .fabrikSubGroupElements > .row-fluid:before,
#{$id} #group17 .fabrikSubGroupElements > .row-fluid:after {
    display: inline !important;
    content: none !important;
}

#{$id} #group17 .fabrikSubGroup {
    width: 100%;
    clear: both;
}

#{$id} #group17 .fabrikSubGroup .fabrikGroupRepeater {
    width: 100%;
}

";
?>