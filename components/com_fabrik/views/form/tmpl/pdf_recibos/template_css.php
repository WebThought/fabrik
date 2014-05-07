<?php
/**
 * Default Form Template: CSS
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 ?>
<?php
header('Content-type: text/css');
$c = (int) $_REQUEST['c'];
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'form';
echo "

#recibo { border: 2px solid #990000; padding: 10px; margin: 10px auto; }
#recibo header { color: #990000; font-family: 'DinNBdCn'; letter-spacing: .1em; }
#recibo header .lead { margin-bottom: 0; }

#recibo hr { border-color: #990000; margin-top: 0; }

#recibo .form-horizontal label { float: left; width: 110px; }

#recibo .field-content > div { border: 1px solid #DDD; display: inline-block; padding: 3px; margin-bottom: 5px; }
#recibo_content table { margin: 20px auto 30px; }
#recibo_content table th { text-align: center; }
#recibo_content table td.fabrikRepeatGroup___gjr_recibos_66_repeat___vencimiento { text-align: center; }
#recibo_content table td.fabrikRepeatGroup___gjr_recibos_66_repeat___importe { text-align: right; }

#recibo_footer .firma_label { font-weight: bold; display: inline-block; float: left; margin-right: 10%; }
#recibo_footer .firma_box { float: left; border-bottom: 1px dashed #000; height: 50px; width: 70% !important; }

@media print {
	#recibo { margin: 0; }
	#recibo_content table th, #recibo_content table td { padding: 4px; }
}
";
?>