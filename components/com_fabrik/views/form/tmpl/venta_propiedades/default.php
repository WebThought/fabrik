<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */

JFactory::getDocument()->addScript(JURI::root().'templates/juanrodriguez/js/jquery.observe_field.js');
?>


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
	<?php
	if ($this->showEmail) {
		echo $this->emailLink;
	}
	if ($this->showPDF) {
		echo $this->pdfLink;
	}
	if ($this->showPrint) {
		echo $this->printLink;
	}

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