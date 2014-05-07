<?php
/**
 * Default Form Template
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

/* The default template includes the following folder and files:

images - this is the folder for the form template's images
- add.png
- alert.png
- delete.png
default.php - this file controls the layout of the form
default_group.php - this file controls the layout of the individual form groups
default_relateddata.php - this file controls the layout of the forms related data
template_css.php - this file controls the styling of the form

CSS classes and id's included in this file are:

componentheading - used if you choose to display the page title
<h1> - used if you choose to show the form label
fabrikMainError -
fabrikError -
fabrikGroup -
groupintro -
fabrikSubGroup -
fabrikSubGroupElements -
fabrikGroupRepeater -
addGroup -
deleteGroup -
fabrikTip -
fabrikActions -

Other form elements that can be styled here are:

legend
fieldset

To learn about all the different elements in a basic form see http://www.w3schools.com/tags/tag_legend.asp.

If you have set to show the page title in the forms layout parameters, then the page title will show */

$form = $this->form;
?>

<?php 
	// Form intro and start
	echo $form->intro;
	echo $form->startTag;
	echo $this->plugintop;

	// Error message
	$active = ($form->error != '') ? '' : ' fabrikHide';
	echo '<div class="fabrikMainError fabrikError' . $active . '">';
	echo FabrikHelperHTML::image('alert.png', 'form', $this->tmpl);
	echo "$form->error</div>";

	echo '<div class="btn-group pull-right hidden-print">';
	// Buttons
	if ($this->showEmail) :
		//echo $this->emailLink;
		echo '<a class="btn btn-default" href="' . $this->emailURL . '"><i class="glyphicon glyphicon-envelope"></i></a>';
	endif;
	if ($this->showPDF) :
		//echo $this->pdfLink;
		echo '<a class="btn btn-default" href="' . $this->pdfURL . '"><i class="glyphicon glyphicon-file"></i></a>';
	endif;
	if ($this->showPrint) :
		//echo $this->printLink;
		echo '<a class="btn btn-default" href="#" onclick="window.open(\''.$this->printURL.'\',\'win2\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=400,height=350,directories=no,location=no;\');return false;" ><i class="glyphicon glyphicon-print"></i></a>';
	endif;
	echo '</div>';
?>
<div class="clearfix"></div>

<article id="recibo" class="wrapper">
	
	<header class="row">
		<div class="col-lg-4"><div class="text-center"><img style="width: 100%; max-width: 300px;" src="<?php echo JURI::base() ?>/templates/juanrodriguez/images/logo_juanrodriguez.png" /></div></div>
		<div class="col-lg-8">
			<div class="pull-right">
				<p class="lead">02320-423425 / 423003 / 435230</p>
				<p class="">Casa Central - Ruta 197 casi esq. Paunero</p>
				<p class="">Sucursal 01 - Croacia esq. Piñero, José C. Paz</p>
			</div>
		</div>
	</header>
	<hr/>
	<section id="recibo_content">
		<div class="row form-horizontal">
			<div class="col-lg-2"><?php echo $this->groups['Recibos']->elements['fecha_recibo']->label;?></div>
			<div class="col-lg-4"><span class="field-content"><?php echo $this->groups['Recibos']->elements['fecha_recibo']->element; ?></span></div>			
			<div class="col-lg-2"><?php echo $this->groups['Recibos']->elements['cliente']->label;?></div>
			<div class="col-lg-4">
				<span class="field-content">
				<?php if (JRequest::getVar('view') == 'form') : ?>
					<?php echo $this->groups['Recibos']->elements['cliente']->element; ?>
				<?php else: ?>
					<?php echo strip_tags($this->groups['Recibos']->elements['cliente']->element); ?>
				<?php endif; ?>
				</span>
			</div>			
		</div>
		<div class="row form-horizontal">
			<div class="col-lg-2"><?php echo $this->groups['Recibos']->elements['nomenclatura']->label;?></div>
			<div class="col-lg-10"><span class="field-content"><?php echo $this->groups['Recibos']->elements['nomenclatura']->element; ?></span></div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php
					$this->group = $this->groups['Recibos: Detalle'];
					$this->elements = $this->group->elements;
					echo $this->loadTemplate($this->group->tmpl);
				?>
			</div>
		</div>
	</section>
	
	<section id="recibo_footer" class="row form-horizontal">
		<div class="col-lg-6">
			<?php echo $this->groups['Recibos']->elements['segun']->label;?>					
			<span class="field-content"><?php echo $this->groups['Recibos']->elements['segun']->element; ?></span>
			<div class="clearfix"></div>
			<?php echo $this->groups['Recibos']->elements['codigo']->label;?>					
			<span class="field-content"><?php echo $this->groups['Recibos']->elements['codigo']->element; ?></span>
		</div>
		<div class="col-lg-6">
			<span class="firma_label">Firma:</span>
			<div class="firma_box"></span>
		</div>
	</section>
</article>

<?php
// Add the form's hidden fields
echo $this->hiddenFields;

// Add any content assigned by form plug-ins
echo $this->pluginbottom;

// Render the form's buttons
if ($this->hasActions) :?>
	<div class="fabrikActions hidden-print pull-right">
		<?php echo $form->resetButton;?>
		<?php echo $form->submitButton;?>
		<?php echo $form->prevButton?>
		<?php echo $form->nextButton?>
		<?php echo $form->applyButton;?>
		<?php echo $form->copyButton  . ' ' . $form->gobackButton . ' ' . $form->deleteButton . ' ' . $this->message ?>
	</div>
<?php
endif;
echo $form->endTag;
echo $form->outro;
echo $this->pluginend;
echo FabrikHelperHTML::keepalive();
