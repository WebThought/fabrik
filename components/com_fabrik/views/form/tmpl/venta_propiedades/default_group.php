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

<ul class="nav nav-tabs" id="mainTab">
	<li class="active">
		<a href="#group<?php echo $this->groups['Venta de Propiedades: General']->id; ?>" data-toggle="tab"><?php echo $this->groups['Venta de Propiedades: General']->title; ?></a>
	</li>
	<li id="boleto_tab">
		<a href="#boleto_pane" data-toggle="tab"><?php echo JText::_('JR_VENTAPROPIEDADES_BOLETO'); ?></a>
	</li>
	<li id="financiacion_tab">
		<a href="#financiacion_pane" data-toggle="tab"><?php echo JText::_('JR_VENTAPROPIEDADES_FINANCIACION'); ?></a>
	</li>
	<li>
		<a href="#group<?php echo $this->groups['Venta de Propiedades: Datos Relacionados']->id; ?>" data-toggle="tab"><?php echo $this->groups['Venta de Propiedades: Datos Relacionados']->title; ?></a>
	</li>
</ul>

<div class="tab-content">
	
	<?php
	/*
	 * This code sets up your first group.
	 */
		reset($this->groups);
		$this->group = current($this->groups);
		$this->elements = $this->group->elements;
	?>
	<div class="fabrikGroup tab-pane active" id="group<?php echo $this->group->id;?>" style="<?php echo $this->group->css;?>">
		<?php if ($this->group->intro !== '') {?>
			<div class="groupintro"><?php echo $this->group->intro ?></div>
		<?php }?>
		<div class="row">
			<div class="form-group col-lg-6">
				<?php
					$this->element = $this->elements['date_time'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-lg-4">
				<?php
					$this->element = $this->elements['inmueble'];
					echo $this->loadTemplate('element');
				?>
			</div>		
			<div class="form-group col-lg-2">
				<?php
					$this->element = $this->elements['inmobiliaria'];
					echo $this->loadTemplate('element');
				?>
			</div>			
			<div class="form-group col-lg-2">
				<?php
					$this->element = $this->elements['monto'];
					echo $this->loadTemplate('element');
				?>
			</div>			
			<div class="form-group col-lg-2">
				<?php
					$this->element = $this->elements['monto_moneda'];
					echo $this->loadTemplate('element');
				?>
			</div>
			<div class="form-group col-lg-2">
				<?php
					$this->element = $this->elements['tc_referencia'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-lg-12">
				<div class="well forma-pago">
					<h3><?php echo JText::_('JR_VENTAPROPIEDADES_FORMAPAGO'); ?></h3>
					<?php
						$this->element = $this->elements['forma_pago'];
						echo $this->loadTemplate('element');
					?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		
		<?php
			$this->group = $this->groups['Venta de Propiedades: Reserva'];
		?>
		<div id="reserva">
			<h3><?php echo JText::_('JR_VENTAPROPIEDADES_RESERVA'); ?></h3>
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
		</div><!-- #reserva -->
		
		<?php
			$this->group = $this->groups['Venta de Propiedades: Boleto'];
			$this->elements = $this->group->elements;
		?>	
		<div class="row">
			<div class="form-group col-lg-6">				
				<?php
					$this->element = $this->elements['boleto'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
		
	</div>	

	<div class="tab-pane" id="boleto_pane" style="<?php echo $this->group->css;?>">
	
		<?php
			$this->group = $this->groups['Venta de Propiedades: Boleto'];
			$this->elements = $this->group->elements;
		?>
		<h3><?php echo JText::_('JR_VENTAPROPIEDADES_BOLETO'); ?></h3>
		
		<div class="row">			
			<div class="form-group form-group-boleto col-lg-6">				
				<?php
					$this->element = $this->elements['fecha_firma'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>		
		<div class="row">
			<div class="form-group form-group-boleto col-lg-6">		
				<?php
					$this->element = $this->elements['comprador'];
					echo $this->loadTemplate('element');
				?>
			</div>
			<div class="form-group form-group-boleto col-lg-6">				
				<?php
					$this->element = $this->elements['vendedor'];
					echo $this->loadTemplate('element');
				?>
			</div>
		</div>
		
		<div id="honorarios_contado" class="row">
			<div class="form-group form-group-boleto col-lg-6">
				<?php
					$this->group = $this->groups['Venta de Propiedades: Honorarios Comprador'];
				?>
				<h3><?php echo JText::_('JR_VENTAPROPIEDADES_HONORARIOSCOMPRADOR'); ?></h3>
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
			</div>
			<div class="form-group form-group-boleto col-lg-6">				
				<?php
					$this->group = $this->groups['Venta de Propiedades: Honorarios Vendedor'];
				?>
				<h3><?php echo JText::_('JR_VENTAPROPIEDADES_HONORARIOSVENDEDOR'); ?></h3>
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
			</div>
		</div><!-- #honorarios_contado -->		
		
		<?php
			// Boleto Saldo: Se usa para las operaciones de venta contado de inmobiliaria
			$this->group = $this->groups['Venta de Propiedades: Boleto - Saldo'];				
		?>
		<div id="boleto_saldo" class="row">
			<div class="col-lg-12">
				<h3><?php echo JText::_('JR_VENTAPROPIEDADES_SALDO'); ?></h3>
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
			</div>
		</div><!-- #boleto_saldo -->
		
	</div>
	
	<div class="tab-pane" id="financiacion_pane">
	
		<?php
			// Financiación - Anticipo
			$this->group = $this->groups['Venta de Propiedades: Financiación - Anticipo'];				
		?>
		<h3><?php echo JText::_('JR_VENTAPROPIEDADES_ANTICIPO'); ?></h3>
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
		
		<h3><?php echo JText::_('JR_VENTAPROPIEDADES_CUOTAS'); ?></h3>
		<?php
			$this->group = $this->groups['Venta de Propiedades: General'];
			$this->elements = $this->group->elements;
		?>
		<div class="row">
			<div class="form-group col-lg-6">
				<?php
					$this->element = $this->elements['fecha_primer_vencimiento'];
					echo $this->loadTemplate('element');
				?>
			</div>
			<div id="total_financiacion" class="col-lg-3 pull-right"></div>
		</div>
		<?php
			// Financiación - Cuotas
			$this->group = $this->groups['Venta de Propiedades: Financiación - Cuotas'];				
		?>		
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
				
		<?php
			$this->group = $this->groups['Venta de Propiedades: General'];
			$this->elements = $this->group->elements;
		?>
		<div class="row">
			<div class="form-group col-lg-6 col-offset-6">
				<h3><?php echo JText::_('JR_VENTAPROPIEDADES_TOTALFINANCIACION'); ?></h3>
				<?php
					$this->element = $this->elements['total_financiacion'];
					echo $this->loadTemplate('element');
				?>
			</div>
			<div id="total_financiacion" class="col-lg-3 pull-right"></div>
		</div>
		
		
	</div>
	
	<?php
		// Datos Relacionados
		$this->group = $this->groups['Venta de Propiedades: Datos Relacionados'];		
		$this->elements = $this->group->elements;
	?>
	<div class="fabrikGroup tab-pane" id="group<?php echo $this->group->id;?>" style="<?php echo $this->group->css;?>"> 		

		<?php if ($this->group->intro !== '') {?>
			<div class="groupintro"><?php echo $this->group->intro ?></div>
		<?php }?>
		
		<?php
			$this->element = $this->elements['operacion_reserva'];
			if (intval($this->element->value)): ?>
				<div class="row">
					<div class="form-group col-lg-3">
						<?php echo $this->loadTemplate('element'); ?>
					</div>
					<div class="form-group col-lg-3">				
						<a href="<?php JRoute::_('index.php?option=com_fabrik&view=details&formid=13&rowid='.$this->element->value); ?>" class="btn btn-block btn-info"><?php echo JText::_('JR_VENTAPROPIEDADES_VEROPERACION'); ?></a>				
					</div>
				</div>
		<?php endif; ?>
		
		<?php
			$this->element = $this->elements['operacion_devolucion_reserva'];
			if (intval($this->element->value)): ?>
				<div class="row">
					<div class="form-group col-lg-3">
						<?php echo $this->loadTemplate('element'); ?>
					</div>
					<div class="form-group col-lg-3">				
						<a href="<?php JRoute::_('index.php?option=com_fabrik&view=details&formid=13&rowid='.$this->element->value); ?>" class="btn btn-block btn-info"><?php echo JText::_('JR_VENTAPROPIEDADES_VEROPERACION'); ?></a>				
					</div>
				</div>
		<?php endif; ?>
		
		<?php
			$this->element = $this->elements['operacion_boleto'];
			if (intval($this->element->value)): ?>
				<div class="row">
					<div class="form-group col-lg-3">
						<?php echo $this->loadTemplate('element'); ?>
					</div>
					<div class="form-group col-lg-3">				
						<a href="<?php JRoute::_('index.php?option=com_fabrik&view=details&formid=13&rowid='.$this->element->value); ?>" class="btn btn-block btn-info"><?php echo JText::_('JR_VENTAPROPIEDADES_VEROPERACION'); ?></a>				
					</div>
				</div>
		<?php endif; ?>
		
		<?php
			$this->element = $this->elements['operacion_anticipo'];
			if (intval($this->element->value)): ?>
				<div class="row">
					<div class="form-group col-lg-3">
						<?php echo $this->loadTemplate('element'); ?>
					</div>
					<div class="form-group col-lg-3">				
						<a href="<?php JRoute::_('index.php?option=com_fabrik&view=details&formid=13&rowid='.$this->element->value); ?>" class="btn btn-block btn-info"><?php echo JText::_('JR_VENTAPROPIEDADES_VEROPERACION'); ?></a>				
					</div>
				</div>
		<?php endif; ?>
		
	</div>
	
</div>

<?php
/* This must be the last thing that happens in this template.  It adds
 * all hidden elements to the form, and also finds any non-hidden elements
 * which haven't been displayed, and adds them as hidden elements (this
 * prevents JavaScript errors where element handler code can't find the actual
 * DOM structures for their elements)
 */
	echo $this->loadTemplate('group_hidden');
?>
