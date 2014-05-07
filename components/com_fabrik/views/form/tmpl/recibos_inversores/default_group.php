<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */ 

/* This code sets up your first group. */
reset($this->groups);
$this->group = current($this->groups);
$this->elements = $this->group->elements;

$this->element = $this->elements['posiciones_inversor'];
$posiciones_inversor = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';
			
$this->element = $this->elements['posicion_valor'];
$posicion_valor = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['posiciones'];
$posiciones = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['inversion_total'];
$inversion_total = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';
			
$this->element = $this->elements['inversor'];
$inversor = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['inversor_nacionalidad'];
$nacionalidad = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['inversor_idn'];
$idn = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['inversor_cuit_cuil'];
$cuit_cuil = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['inversor_domicilio'];
$domicilio = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['aportes_textos'];
$aportes_textos = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['posicion_valor_texto'];
$posicion_valor_texto = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['emprendimiento'];
$emprendimiento = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['emprendimiento_direccion'];
$emprendimiento_direccion = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['emprendimiento_nomenclatura'];
$emprendimiento_nomenclatura = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['emprendimiento_descripcion'];
$emprendimiento_descripcion = '<span class="descripcionproyecto">'.$this->loadTemplate('element').'</span>';

// Gastos 
$this->element = $this->elements['gasto_costo_terreno'];
$gasto_costo_terreno = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['gasto_honorarios_comprador'];
$gasto_honorarios_comprador = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['gasto_planos'];
$gasto_planos = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['gasto_escritura'];
$gasto_escritura = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['gasto_desmonte_calle_electricidad'];
$gasto_desmonte_calle_electricidad = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

$this->element = $this->elements['gasto_administracion'];
$gasto_administracion = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';


$this->element = $this->elements['ubicacion'];
$ubicacion = '<span class="inline-input">'.$this->loadTemplate('element').'</span>';

// Fakes
$fake_inversor = $this->handler->buildFake('inversor', $this->elements);
$fake_inversor_idn = $this->handler->buildFake('inversor_idn', $this->elements);
$fake_inversor_domicilio = $this->handler->buildFake('inversor_domicilio', $this->elements);
$fake_posiciones_inversor = $this->handler->buildFake('posiciones_inversor', $this->elements);
$fake_posicion_valor = $this->handler->buildFake('posicion_valor', $this->elements);
$fake_emprendimiento = $this->handler->buildFake('emprendimiento', $this->elements);
$fake_inversion_total = $this->handler->buildFake('inversion_total', $this->elements);
?>
<article id="recibo_inversor">	
	
	<h1>
		<?php
			if  ($this->elements['posiciones_inversor']->value == 1)
				$pattern = 'Toma de <span class="inline-input">%s</span> posición de <span class="inline-input">%s</span>';
			else
				$pattern = 'Toma de <span class="inline-input">%s</span> posiciones de <span class="inline-input">%s</span>';
			
			echo sprintf($pattern, $posiciones_inversor, $posicion_valor);
		?>		
		<br/><small>(ad referéndum de la realización de la operación de compra venta)</small>
	</h1>
	<hr/>
	
	<div class="paragraph">
		<b>Recibí</b> de <b><u><?php echo $inversor; ?></u></b>, de nacionalidad <?php echo $nacionalidad; ?>, DNI N° <?php echo $idn; ?>, CUIT/CUIL <?php echo $cuit_cuil; ?>, con domicilio en <?php echo $domicilio; ?>, en adelante <b>“El Inversor”</b>, la suma de <span class="aportestextos"><?php echo $aportes_textos; ?></span>, para ser imputados en concepto de toma de <?php echo $fake_posiciones_inversor; ?> <?php echo ($this->elements['posiciones_inversor']->value == 1 ? 'posición' : 'posiciones'); ?> de <span class="aportestextos"><?php echo $posicion_valor_texto.' ('.$posicion_valor.')'; ?></span>, ad referéndum de la realización del  boleto de compraventa, por la compra del siguiente inmueble: <b><span class="nombre_emprendimiento">“<?php echo $emprendimiento; ?>”</span>, con dirección <?php echo $emprendimiento_direccion; ?>.  Nomenclatura Catastral: <?php echo $emprendimiento_nomenclatura; ?></b>. Con todo lo edificado, plantado y adherido al suelo, en el estado actual en que se encuentra, que el oferente conoce y acepta por haberla visitado y revisado antes de ahora. <?php echo $ubicacion; ?>.	
	</div>
	
	<div class="paragraph">
		<b>La presente toma de posiciones</b> se funda en que <b>“El Inversor”</b> ha decidido participar como tal en el proyecto <span class="nombre_emprendimiento">“<?php echo $fake_emprendimiento; ?>"</span>
	</div>	
	
	<h3>A continuación una minuta del mismo:</h3>
	<div class="paragraph">
		<b>Proyecto:</b> <?php echo $emprendimiento_descripcion; ?>
	</div>	
	<div class="paragraph">
		<b>Monto de la inversión:</b> <?php echo $inversion_total; ?>, con <?php echo $posiciones; ?> posiciones de <?php echo $fake_posicion_valor; ?> cada una.
	</div>
	
	<div class="paragraph">
		<b>Inclusiones: El valor de <?php echo $fake_inversion_total; ?> de la inversión incluye:</b>
	</div>
	
		<div class="paragraph">
		<table class="table gastos">		
			<tr>
				<td class="gasto"><?php echo $gasto_costo_terreno; ?>:</td>
				<td>Precio de compra.</td>
			</tr>
			<tr>
				<td class="gasto"><?php echo $gasto_honorarios_comprador; ?>:</td>
				<td>Honorarios parte compradora.</td>
			</tr>
			<tr>
				<td class="gasto"><?php echo $gasto_planos; ?>:</td>
				<td>Plano municipal y de Propiedad Horizontal.</td>
			</tr>
			<tr>
				<td class="gasto"><?php echo $gasto_escritura; ?>:</td>
				<td>Gastos de escrituración, por la compra del inmueble y por la confección y firma del fideicomiso.</td>
			</tr>
			<tr>
				<td class="gasto"><?php echo $gasto_desmonte_calle_electricidad; ?>:</td>
				<td>Infraestructura de movimiento de suelos y energía eléctrica.</td>
			</tr>
			<tr>
				<td class="gasto"><?php echo $gasto_administracion; ?>:</td>
				<td>Administración de proyecto.</td>
			</tr>      
		</table>
	</div>
	
	<div class="paragraph">
		TAREAS A LAS QUE SE COMPROMETE EL SR. JUAN CESAR RODRIGUEZ FUTURO FIDUCIARIO EN EL FIDEICOMISO A CONFORMARSE CON LOS INVERSORES POR EL DESARROLLO INMOBILIARIO: <span class="inline-input nombre_emprendimiento">“<?php echo $fake_emprendimiento; ?>"</span>
	</div>
	
	<div class="paragraph">
		Se incluye todas las tareas que corresponden a la gestión del fiduciario, del proyecto, desde la firma del boleto de compraventa hasta la venta de la última unidad funcional con liquidación final y entrega del patrimonio fiduciario a los coincidentemente beneficiarios.
	</div>

	<div class="paragraph">
		La constitución del fideicomiso, por escritura pública y sus respectivas inscripciones registrales y en la AFIP, apertura de cuenta en banco y demás erogaciones derivadas de su constitución: está incluida.
	</div>

	<div class="paragraph">
		A la venta de las unidades obtenidas por subdivisión en P.H., se abonará honorarios de la inmobiliaria que intervenga en la misma, por encima del valor que figura en el cuadernillo de reseña de la inversión.
	</div>
	
	<div class="paragraph">
		Los impuestos que por ley deba abonar el fideicomiso se solventarán con el patrimonio del mismo, caso de falta de liquidez con aportes de los inversores.
	</div>
	
	<div class="paragraph">
		Los impuestos que surjan en cabeza de cada fiduciante-beneficiario se compromete cada inversor a depositarlo por su lado, según lo que su posición impositiva defina.
	</div>
	
	<div class="paragraph">
		Me comprometo a proceder a la redacción del contrato de fideicomiso, que refleje claramente lo aquí expresado, el cual será sometido al chequeo y aprobación de los inversores, antes de proceder a la escrituración del mismo.
	</div>

	<div class="paragraph lugarfecha">
		<?php $this->element = $this->elements['lugar_fecha']; echo $this->loadTemplate('element'); ?>		
	</div>
	
	<hr/>

	<div class="row-fluid">
		<div class="firma col-lg-6">
			<br/><br/><br/><br/><br/>
		</div>
		<div class="firma col-lg-6">
			<br/><br/><br/><br/><br/>
		</div>
	</div>
	<div class="row-fluid">
		<div class="firma col-lg-6">
			<b>RECIBE EL IMPORTE</b>
			<br/>
			<?php
				$this->element = $this->elements['recibe'];
				echo $this->loadTemplate('element');
			?>			
		</div>
		<div class="firma col-lg-6">
			<b>REPRESENTANTE</b>
			<br/><?php echo $fake_inversor; ?>
			<br/><?php echo $fake_inversor_idn; ?>
			<br/><?php echo $fake_inversor_domicilio; ?>
		</div>
	</div>
	<div class="clearfix"></div>

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
