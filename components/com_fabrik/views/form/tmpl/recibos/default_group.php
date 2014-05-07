<?php
/**
 * Contacts Custom Form Template: Group
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 ?>

<?php
/*
 * This is where you will do your main template modifications.
 *
 */
?>

<article id="recibo">	
	<?php
	/*
	 * This code sets up your first group.
	 */
		reset($this->groups);
		$this->group = current($this->groups);
		$this->elements = $this->group->elements;
	?>
	<div class="fabrikGroup" id="group<?php echo $this->group->id;?>" style="<?php echo $this->group->css;?>">
		<?php if ($this->group->intro !== '') {?>
			<div class="groupintro"><?php echo $this->group->intro ?></div>
		<?php }?>
				
		<div class="row">
			<div class="form-group col-lg-6">
				<?php
					$this->element = $this->elements['fecha_recibo'];
					echo $this->loadTemplate('element');
				?>
			</div>			
			<div class="form-group col-lg-6">
				<?php
					$this->element = $this->elements['cliente'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-lg-4">
				<?php
					$this->element = $this->elements['nomenclatura'];
					echo $this->loadTemplate('element');
				?>
			</div>			
			<div class="form-group col-lg-4">
				<?php
					$this->element = $this->elements['segun'];
					echo $this->loadTemplate('element');
				?>
			</div>
			<div class="form-group col-lg-4">
				<?php
					$this->element = $this->elements['codigo'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
	</div>
				
	<?php
		$this->group = $this->groups['Recibos: Detalle'];
	?>
	<div id="detalle">
		<h3><?php echo JText::_('JR_RECIBOS_DETALLE'); ?></h3>
		<div class="fabrikGroup" id="group<?php echo $this->group->id;?>" style="<?php echo $this->group->css;?>">
			<table class="table table-bordered table-responsive repeatGroupTable fabrikList">
				<thead>
					<tr>
						<?php
							// Add in the table heading							
							foreach ($this->group->subgroups[0] as $el) :
								$style = $el->hidden ? 'style="display:none"' : '';
							?>
								<th <?php echo $style; ?>>
									<?php echo $el->label?>
								</th>
							<?php endforeach;
							// This column will contain the add/delete buttons
							if ($this->group->editable) : ?>
								<th></th>
							<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$this->groupColumns = $this->group->columns;
						if ($this->group->canRepeat) {							
							foreach ($this->group->subgroups as $key => $subgroup) {
								$this->elements = $subgroup; ?>
									<tr class="fabrikSubGroupElements fabrikSubGroup">
										<?php
										foreach ( $this->elements as $element ) {
											$this->element = $element;
											echo $this->loadTemplate('element_cell');
										}
										if ($this->group->editable) : ?>
											<td class="fabrikGroupRepeater">
												<?php if ($this->group->canAddRepeat) : ?>
												<a class="addGroup" href="#">
													<?php echo FabrikHelperHTML::image('add.png', 'form', $this->tmpl, array('class' => 'fabrikTip', 'title' => JText::_('COM_FABRIK_ADD_GROUP')));?>
												</a>
												<?php
												endif;
												if ($this->group->canDeleteRepeat) : ?>
												<a class="deleteGroup" href="#">
													<?php echo FabrikHelperHTML::image('del.png', 'form', $this->tmpl, array('class' => 'fabrikTip', 'title' => JText::_('COM_FABRIK_DELETE_GROUP')));?>
												</a>
												<?php
												endif;
												?>
											</td>
										<?php
										endif;
										?>
									</tr>
								<?php					
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div><!-- #detalle -->		
	
</article>

<?php
/* This must be the last thing that happens in this template.  It adds
 * all hidden elements to the form, and also finds any non-hidden elements
 * which haven't been displayed, and adds them as hidden elements (this
 * prevents JavaScript errors where element handler code can't find the actual
 * DOM structures for their elements)
 */
	echo $this->loadTemplate('group_hidden');
?>
