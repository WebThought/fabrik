<?php
/**
 * Contacts Custom Form Template
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 
require_once JPATH_ROOT . DIRECTORY_SEPARATOR . 'plugins/fabrik_form/php/scripts/helper_recibos.php';

/* Creación de objetos JS para relleno de datos */
$dataObject = null;
$tipoRecibo = null;	
$handler = new HandlerRecibos($_SESSION['__default'], $dataObject, $tipoRecibo);

?>
<script>
	<?php if (isset($tipoRecibo)): ?>
		var tipoRecibo = JSON.parse('<?php echo json_encode($tipoRecibo) ?>');
	<?php endif; ?>
	<?php if (isset($dataObject)): ?>
		var dataObject = JSON.parse('<?php echo json_encode($dataObject) ?>');
	<?php endif; ?>
</script>

<?php if ($this->params->get('show_page_title', 1)) { ?>
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php } ?>
<?php $form = $this->form;
//echo $form->startTag;
if ($this->params->get('show-title', 1)) {?>
<h1><?php echo $form->label;?></h1>
<?php }
echo $form->intro;
echo $form->startTag;
echo $this->plugintop;
$active = ($form->error != '') ? '' : ' fabrikHide';
echo "<div class=\"fabrikMainError fabrikError$active\">$form->error</div>";?>
<div class="row">
	<div class="col-lg-12">
		<?php
		if ($this->showEmail) {
			echo $this->emailLink;
		}
		if ($this->showPDF) {
			echo $this->pdfLink;
		}
		if ($this->showPrint) :?>
			<a href="#" class="btn btn-default pull-right printlink" onclick="window.open('/index.php?option=com_fabrik&amp;tmpl=component&amp;view=details&amp;formid=<?php echo $form->id; ?>&amp;listid=<?php echo $this->list->id; ?>&amp;rowid=<?php echo $this->rowid; ?>&amp;iframe=1&amp;print=1','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=400,height=350,directories=no,location=no;');return false;" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>
	</div>
</div>
	<?php endif;

	echo $this->loadTemplate('group');

	echo $this->hiddenFields;
	echo $this->pluginbottom;
	?>
	<?php if ($this->hasActions) :?>
		<div class="fabrikActions pull-right">			
			<?php echo $form->prevButton?>
			<?php echo $form->nextButton?>
			<?php echo $form->gobackButton;?>
			<?php echo $form->applyButton;?>
			<?php echo $form->copyButton  . ' ' . $form->deleteButton . ' ' . $this->message ?>
			<?php echo $form->resetButton;?>		
			<?php echo $form->submitButton;?>
		</div>
		<div class="clearfix"></div>
	<?php endif; ?>

<?php

echo $form->endTag;
echo $form->outro;

echo $this->pluginend;
echo FabrikHelperHTML::keepalive();?>