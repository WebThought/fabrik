<?php
/**
 * Proyecto: Sistema de Gesti髇 para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_operaciones.php");

class Cobranza {

	public $date_time;
	public $operacion;
	public $operaciones_cobro;
	public $inmueble_id;
	public $cliente_id;
	public $descripcion;
	public $monto;
	public $vencimiento;
	public $estado;
	public $fecha_cobro;
	private $cobros;

	public function __construct() {
    	$this->monto = new Monto();
    }

    public static function conID( $id ) {
    	$instance = new self();
    	$instance->cargarId( $id );
    	return $instance;
    }
	
	public static function conDatos( $values ) {
    	$instance = new self();
    	$instance->cargar( $values );
    	return $instance;
    }

	protected function cargarId( $id ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_cobranza')
			->where('id = '.$id);
		$db->setQuery($query);		
		$result = $db->loadAssoc();
	
    	$this->cargar( $result );
		$this->getCobros();
    }
	
	protected function getCobros() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_cobranza_102_repeat')
			->where('parent_id = '.$this->id);
		$db->setQuery($query);		
		$cobros = $db->loadAssocList('id');
    }

    protected function cargar( array $values ) {
		$this->date_time			= $values['date_time'];
		$this->operacion			= $values['operacion'];
		if ($values['operaciones_cobro'] != '')
			$this->operaciones_cobro	= explode(',', $values['operaciones_cobro']);
		else
			$this->operaciones_cobro	= array();
		$this->inmueble_id			= $values['inmueble_id'];
		$this->cliente_id			= $values['cliente_id'];
		$this->descripcion			= $values['descripcion'];
		$this->vencimiento			= $values['vencimiento'];
		$this->estado				= $values['estado'];
		$this->fecha_cobro			= $values['fecha_cobro'];
    	$this->parent_id 			= $values['parent_id'];		
		
		if (get_class($values['monto']) == 'Monto')
			$this->monto = $values['monto'];
		else {
			$this->monto->monto = $values['monto'];
			$this->monto->moneda = $values['moneda'];
			$this->monto->tc = $values['tc'];
		}    
    }
	
	public function set($param, $value)
	{
		$this->$param = $value;	
		return;
	}

	public function crear()
	{
		$db = JFactory::getDbo();
		
		if (is_array($this->operaciones_cobro))
			$operaciones_cobro = implode(',',$this->operaciones_cobro);
		else 
			$operaciones_cobro = $this->operaciones_cobro;
		
		$query = $db->getQuery(true); 
		$columns = array( 'date_time', 'operacion', 'operaciones_cobro', 'inmueble_id', 'cliente_id', 'descripcion', 'monto', 'moneda',	'vencimiento','estado','fecha_cobro' ); 
		$values = array(		
			"'".$this->date_time."'",
			"'".$this->operacion."'",
			"'".$operaciones_cobro."'",
			"'".$this->inmueble_id."'",
			"'".$this->cliente_id."'",
			"'".$this->descripcion."'",
			"'".$this->monto->monto."'",
			"'".$this->monto->moneda."'",		
			"'".$this->vencimiento."'",				
			"'".$this->estado."'",
			"'".$this->fecha_cobro."'"
		);
		
		$query
			->insert($db->quoteName('gjr_cobranza'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));
		$db->setQuery($query);
		
		//echo $query;	
		try {
			// Execute the query
			$result = $db->query();		
		}
		catch (Exception $e) {
			$this->setError($e);
			return false;	
		}
		
		$this->id = $db->insertid();
		
		return $this->id;
	}
	
	public function cargarCobro(array $cobros, $honorarios)
	{
		$db = JFactory::getDbo();
	
		if ($cobros == NULL)
			return FALSE;
		
		foreach ($cobros as $cobro) {
			if (get_class($cobro['cobro_monto']) == 'Monto') {
				$cobro['cobro_tc_referencia'] = $cobro['cobro_monto']->tc_referencia;
				$cobro['cobro_moneda'] = $cobro['cobro_monto']->moneda;
				$cobro['cobro_monto'] = $cobro['cobro_monto']->monto;
			}
							
			$query = $db->getQuery(true); 
			$columns = array(
				'parent_id',
				'cuenta',
				'cobro_monto',
				'cobro_moneda',
				'cobro_tc_referencia',
				'cobro_honorarios'
			); 
			$values = array(		
				"'".$this->id."'",
				"'".$cobro['cuenta'][0]."'",
				"'".$cobro['cobro_monto']."'",
				"'".$cobro['cobro_moneda']."'",
				"'".$cobro['cobro_tc_referencia']."'",
				"'".$cobro['cobro_honorarios']."'"
			);
			$query
				->insert($db->quoteName('gjr_cobranza_102_repeat'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values));
			$db->setQuery($query);
			$result = $db->query();
		}		
	}
	
	/* GENERACI脫N DE OPERACIONES DE COBRO ASOCIADAS */
	/* Ver documentaci贸n para entender los asientos */	
	public function cargarOperacionesCobro(array $cobros, $honorarios = true)
	{
		$db = JFactory::getDbo();
		
		$ejercicio = Operacion::getEjercicio($this->fecha_cobro);		
		
		// Generaci贸n de Operaci贸n 0 - Venta de Propiedad del Emprendimiento				
		$operacion0 = Operacion::conDatos( array(
			'date_time'			=> $this->fecha_cobro,
			'fecha_operacion' 	=> $this->fecha_cobro,
			'ejercicio'			=> $ejercicio,
			'descripcion' 		=> 'Cobro - '.$this->descripcion,
			'tipo'				=> 'I',
			'concepto' 			=> 39, // 39: Venta de Propiedades de Emprendimientos
			'tabla_relacionada' => 'gjr_cobranza',
			'relacion_id'		=> $this->id
		));
		foreach ($cobros as $cobro) {
			$operacion0->crearAsiento('entrada',  AsientoContable::conDatos(array(				
				'cuenta' => $cobro['cuenta'][0],
				'monto' => $cobro['cobro_monto']
			)));
			$operacion0->crearAsiento('salida',  AsientoContable::conDatos(array(				
				'cuenta' => 39, // 39: Venta de Propiedades de Emprendimientos
				'monto' => $cobro['cobro_monto']
			)));
		}
		$operacion0->crear();		
		
		if ($honorarios) {
			// Generaci贸n de Operaci贸n 1 - Gastos del Emprendimiento: Honorarios Inmobiliarios
			$operacion1 = Operacion::conDatos( array(
				'date_time'			=> $this->fecha_cobro,
				'fecha_operacion' 	=> $this->fecha_cobro,
				'ejercicio'			=> $ejercicio,
				'descripcion' 		=> 'Honorarios por Cobro - '.$this->descripcion,
				'tipo'				=> 'E',
				'concepto' 			=> 40, // 40: Honorarios Inmobiliarios de Emprendimientos
				'tabla_relacionada' => 'gjr_cobranza',
				'relacion_id'		=> $this->id
			));
			
			// Generaci贸n de Operaci贸n 2 - Honorarios Inmobiliarios			
			$operacion2 = Operacion::conDatos( array(
				'date_time'			=> $this->fecha_cobro,
				'fecha_operacion' 	=> $this->fecha_cobro,
				'ejercicio'			=> $ejercicio,
				'descripcion' 		=> 'Honorarios por Cobro - '.$this->descripcion,
				'tipo'				=> 'I',
				'concepto' 			=> 37, // 37: Honorarios Inmobiliarios por Emprendimientos
				'tabla_relacionada' => 'gjr_cobranza',
				'relacion_id'		=> $this->id
			));
			
			foreach($cobros as $cobro) {
				var_dump($cobro);
				$operacion1->crearAsiento('entrada',  AsientoContable::conDatos(array(				
					'cuenta' => 40, // 40: Honorarios Inmobiliarios de Emprendimientos
					'monto' => new Monto($cobro['cobro_honorarios'], $cobro['cobro_monto']->moneda, $cobro['cobro_monto']->tc)
				)));			
				$operacion1->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => $cobro['cuenta'][0],
					'monto' => new Monto($cobro['cobro_honorarios'], $cobro['cobro_monto']->moneda, $cobro['cobro_monto']->tc)
				)));
				
				$operacion2->crearAsiento('entrada',  AsientoContable::conDatos(array(									
					'cuenta' => $cobro['cuenta'][0],
					'monto' => new Monto($cobro['cobro_honorarios'], $cobro['cobro_monto']->moneda, $cobro['cobro_monto']->tc)
				)));			
				$operacion2->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => 37, // Honorarios Inmobiliarios por Emprendimientos		
					'monto' => new Monto($cobro['cobro_honorarios'], $cobro['cobro_monto']->moneda, $cobro['cobro_monto']->tc)
				)));				
			
			}
			
			$operacion1->crear();
			$operacion2->crear();			
		
		}		
		
		// Generaci贸n de Operaci贸n 3 - Disminuci贸n de Deuda Contable
		$operacion3 = Operacion::conDatos( array(
			'date_time'			=> $this->fecha_cobro,
			'fecha_operacion' 	=> $this->fecha_cobro,
			'ejercicio'			=> $ejercicio,
			'descripcion' 		=> 'Disminuci贸n de Deuda por Pago - '.$this->descripcion,
			'tipo'				=> 'E',
			'concepto' 			=> 38, // 38: Financiaci贸n de Propiedades
			'tabla_relacionada' => 'gjr_cobranza',
			'relacion_id'		=> $this->id
		));
		$operacion3->crearAsiento('entrada',  AsientoContable::conDatos(array(
			'cuenta' => 38, // 38: Financiaci贸n de Propiedades
			'monto' => $this->monto // Monto por el que fue asentada la deuda de la cobranza			
		)));
		$operacion3->crearAsiento('salida',  AsientoContable::conDatos(array(
			'cuenta' => 3, // Cuentas por Cobrar
			'monto' => $this->monto
		)));
		$operacion3->crear();		
		
		if ( count($this->operaciones_cobro) == '') {			
			$this->operaciones_cobro[] = $operacion0->id;
			if ($operacion1->id)
				$this->operaciones_cobro[] = $operacion1->id;
			if ($operacion2->id)
				$this->operaciones_cobro[] = $operacion2->id;
			$this->operaciones_cobro[] = $operacion3->id;
			
			$operacionesCobro = implode (',',$this->operaciones_cobro);
			$db->setQuery("UPDATE gjr_cobranza SET operaciones_cobro = '{$operacionesCobro}' WHERE cobranza_id = ".$this->id);
			$db->query();
			
		} else {		
			$operacion0->set('id', $this->operaciones_cobro[0]);
			$operacion0->actualizar();
			$operacion1->set('id', $this->operaciones_cobro[1]);
			$operacion1->actualizar();
			$operacion2->set('id', $this->operaciones_cobro[2]);
			$operacion2->actualizar();
			$operacion3->set('id', $this->operaciones_cobro[3]);
			$operacion3->actualizar();
		}
				
		return $this->operaciones_cobro;
	}
	
	function getInmuebleCobranza($operacion_id)
	{	
		$db = JFactory::getDbo();
		$db->setQuery("SELECT inmueble FROM gjr_venta_propiedad WHERE operacion_id = ".$operacion_id);
		return $db->loadResult();
	}

	public function getNombreInmueble($inmueble_id)
	{	
		$db = JFactory::getDbo();
		$db->setQuery("SELECT CONCAT(direccion, ', ', ciudad) AS value FROM gjr_inmueble WHERE id = ".$inmueble_id);
		return $db->loadResult();
	}
	
	public function eliminarCobranzaOperacion($operacion_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	 
		$query->delete('gjr_cobranza');
		$query->where('operacion = ' . $operacion_id);
		$db->setQuery($query);
		//echo $query;
		try {
			// Execute the query
			$result = $db->query();
		} catch (Exception $e) {
			$this->setError($e);
			return false;
		}	
		
		return;
	}
}

class HandlerCobranza {
	
	public $tabla;
	public $formModel;
	
	public function __construct(&$formModel)
	{
		$this->tabla = 'gjr_cobranza';
		$this->formModel = $formModel;
		$this->id = $formModel->getElementData('gjr_cobranza___id');
		$this->date_time = $formModel->getElementData('gjr_cobranza___date_time');
		
		$this->inmueble_id = $formModel->getElementData('gjr_cobranza___inmueble_id');
		$this->cliente_id = $formModel->getElementData('gjr_cobranza___cliente_id');
		$this->descripcion = $formModel->getElementData('gjr_cobranza___descripcion');
		$monto_moneda = $formModel->getElementData('gjr_cobranza___moneda');
		$this->monto = new Monto($formModel->getElementData('gjr_cobranza___monto'), $monto_moneda[0]);
		$this->vencimiento = $formModel->getElementData('gjr_cobranza___vencimiento');	
		$this->estado = $formModel->getElementData('gjr_cobranza___estado');
		$this->fecha_cobro = $formModel->getElementData('gjr_cobranza___fecha_cobro');
		
		// Operaciones Relacionadas
		$this->operacionRelacionada->operacion = $this->formModel->getElementData('gjr_cobranza___operacion');	
		$this->operacionRelacionada->operaciones_cobro = explode(',', $this->formModel->getElementData('gjr_cobranza___operaciones_cobro'));	
		
		// Cobros
		$this->cobros = array();
		$cobros = $this->formModel->getElementData('gjr_cobranza_102_repeat___cobro_monto');
		$cobros_moneda = $this->formModel->getElementData('gjr_cobranza_102_repeat___cobro_moneda');
		$cobros_tc_referencia = $this->formModel->getElementData('gjr_cobranza_102_repeat___cobro_tc_referencia');
		$cobros_cuenta = $this->formModel->getElementData('gjr_cobranza_102_repeat___cuenta');
		$cobros_honorarios = $this->formModel->getElementData('gjr_cobranza_102_repeat___cobro_honorarios');
		foreach ($cobros as $key => $cobro) {
			$cobroMonto = new Monto(
				$cobro,
				$cobros_moneda[$key][0],
				$cobros_tc_referencia[$key]
			);
			// Se prepara para la funci髇 cargarOperacionesCobro
			$cobroAux['cobro_monto'] = $cobroMonto;
			$cobroAux['cuenta'] = $cobros_cuenta[$key];
			$cobroAux['cobro_honorarios'] = $cobros_honorarios[$key];
			$this->cobros[] = $cobroAux;
		}
		
	}
	
	public function onBeforeStore()
	{
		
		if ( $this->estado[0] == 'Cobrado' ) {

			$cobranza = Cobranza::conID($this->id);
			$operaciones_cobro = $cobranza->cargarOperacionesCobro($this->cobros, true);
			$this->operacionRelacionada->operaciones_cobro = implode(',', $operaciones_cobro);
			$this->formModel->updateFormData('gjr_cobranza___operaciones_cobro', $this->operacionRelacionada->operaciones_cobro, true);	
			
		} else {
			// Reviso si hay operaciones de cobro asociadas y si las hay borro los asientos.	
			
			if ( count($this->operacionRelacionada->operaciones_cobro) ) {
				foreach ($this->operacionRelacionada->operaciones_cobro as $operacion_cobro) {
					$operacion = Operacion::conID($operacion_cobro);
					$operacion->eliminar();
				}
			}
		}
	}
	
	/*
	* onAfterProcess: Asocia operaci髇
	*/
	public function onAfterProcess()
	{
		Operacion::asociarRelacion($this->operacionRelacionada->operacion, $this->id);
		
		if ( count($this->operacionRelacionada->operaciones_cobro) ) {
			foreach ($this->operacionRelacionada->operaciones_cobro as $operacion_cobro) {
				Operacion::asociarRelacion($operacion_cobro, $this->id);
			}
		}
	}
}
?>