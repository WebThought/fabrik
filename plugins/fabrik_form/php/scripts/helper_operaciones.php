<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_monto.php");

class AsientoContable
{
	private $tabla;
	public $id;
	public $parent_id;
	public $cuenta;
	public $monto;	
	
	public function __construct()
	{
		$this->monto = new Monto();
		return;		
	}

    public static function conID( $id, $tabla )
	{
    	$instance = new self();		
    	$instance->cargarId( $id, $tabla );
    	return $instance;
    }
	
	public static function conDatos( $values )
	{
    	$instance = new self();		
    	$instance->cargar( $values );		
    	return $instance;
    }

	protected function cargarId( $id, $tabla )
	{
		$this->tabla = $tabla;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from($this->tabla)
			->where('id = '.$id);
		$db->setQuery($query);		
		$result = $db->loadAssoc();	
		
	   	$this->cargar( $result );
    }

    protected function cargar( $values )
	{	
		$this->id			= $values['id'];
		$this->parent_id 	= $values['parent_id'];
		$this->cuenta 		= $values['cuenta'];
		
		if (get_class($values['monto']) == 'Monto')
			$this->monto = $values['monto'];
		else {
			$this->monto->monto = $values['monto'];
			$this->monto->moneda = $values['moneda'];
			
			if (isset($values['tc']))
				$this->monto->tc = $values['tc'];
			elseif (isset($values['tc_referencia']))
				$this->monto->tc = $values['tc_referencia'];
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
		$query = $db->getQuery(true);
		
		if (!$this->tabla || !$this->cuenta || !$this->parent_id || floatval($this->monto) == 0 ) {			
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_FALTANDATOSASIENTO') );
			return FALSE;
		}
		
		if (!isset($this->monto->tc) || $this->monto->tc == NULL)
			$this->monto->tc = 'NULL';
				
		$columns = array('parent_id', 'cuenta', 'monto', 'moneda', 'tc_referencia'); 
		$values = array(		
			"'".$this->parent_id."'",
			"'".$this->cuenta."'",
			"'".$this->monto->monto."'",		
			"'".$this->monto->moneda."'",
			"'".$this->monto->tc."'"
		);
		
		$query
			->insert($db->quoteName($this->tabla))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));
		$db->setQuery($query);
		
		//echo $query;	
		try {
			// Execute the query
			$result = $db->query();
		}
		catch (Exception $e) {
			JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_GENERACIONASIENTO', $e) );
			return FALSE;	
		}
		
		$this->id = $db->insertid();
		
		return $this->id;
	}
	
	public function eliminar()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if (!$this->id || !$this->tabla) {			
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_FALTANDATOSASIENTO') );
			return FALSE;
		}
			
		
		$conditions = array(
			'id='.$this->id
		);
		$query->delete($this->tabla);
		$query->where($conditions);
		$db->setQuery($query);
 
		try {
			$result = $db->query();			
		} catch (Exception $e) {
			JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_ELIMINACIONASIENTO', $e) );
			return FALSE;	
		}
		
		return TRUE;		
	}
}

class Operacion
{
	public $id;
	public $date_time;
	public $fecha_operacion;
	public $ejercicio;
	public $descripcion;
	public $tipo;
	public $concepto;
	public $tabla_relacionada;
	public $relacion_id;	
	public $asientosEntrada;
	public $asientosSalida;	
	private $tablaEntrada;
	private $tablaSalida;
	
	public function __construct() {
    	$this->tablaEntrada = 'gjr_operacion_44_repeat';
		$this->tablaSalida = 'gjr_operacion_45_repeat';
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
			->from('gjr_operacion')
			->where('id = '.$id);
		$db->setQuery($query);		
		$result = $db->loadAssoc();
	
		$this->cargar( $result );		
    }

    protected function cargar( $values ) {		
    	foreach ($values as $key => $value) 
			$this->$key = $value;
		
		if ($this->id) {
			$this->getAsientos();
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
		$app = JFactory::getApplication();
		
		if (!isset($this->tabla_relacionada) || $this->tabla_relacionada == NULL)
			$this->tabla_relacionada = 'NULL';
		if (!isset($this->relacion_id) || $this->relacion_id == NULL)
			$this->relacion_id = 'NULL';
			
		if (!$this->validarOperacion()) {
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_OPERACIONNOVALIDA') );
			return FALSE;
		}

		$query = $db->getQuery(true); 
		$columns = array('date_time', 'fecha_operacion', 'ejercicio', 'descripcion', 'tipo', 'concepto', 'tabla_relacionada', 'relacion_id'); 
		$values = array(		
			"'".$this->date_time."'",
			"'".$this->fecha_operacion."'",
			"'".$this->ejercicio."'",
			"'".$this->descripcion."'",
			"'".$this->tipo."'",				
			"'".$this->concepto."'",
			"'".$this->tabla_relacionada."'",
			"'".$this->relacion_id."'"
		);
		
		$query
			->insert($db->quoteName('gjr_operacion'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));
		$db->setQuery($query);
		
		//echo $query;	
		try {
			// Execute the query
			$result = $db->query();					
			$this->id = $db->insertid();
			
			// Creación de Asientos
			foreach ($this->asientosEntrada as $asiento) {
				$asiento->parent_id = $this->id;
				$asiento->crear();
			}
			foreach ($this->asientosSalida as $asiento) {
				$asiento->parent_id = $this->id;
				$asiento->crear();
			}
		}
		catch (Exception $e) {
			JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_GENERACIONOPERACION', $e) );
			return FALSE;
		}		
		
		return $this->id;
	}
	
	public function actualizar()
	{	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
				
		if (!$this->id) {			
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_SINID') );
			return FALSE;
		}
			
		if (!$this->validarOperacion()) {
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_OPERACIONNOVALIDA') );
			return FALSE;
		}
		
		$fields = array(
			'date_time = '.$db->quote($this->date_time),
			'fecha_operacion = '.$db->quote($this->fecha_operacion),
			'ejercicio = '.$db->quote($this->ejercicio),
			'descripcion = '.$db->quote($this->descripcion),
			'tipo = '.$db->quote($this->tipo),
			'concepto = '.$db->quote($this->concepto),
			'tabla_relacionada = '.$db->quote($this->tabla_relacionada),
			'relacion_id = '.$db->quote($this->relacion_id)				
		);
		$conditions = array(
			'id='.$this->id, 
		);
		$query->update($db->quoteName('gjr_operacion'))->set($fields)->where($conditions);
		$db->setQuery($query); 
		
		//echo $query;	
		try {
			$result = $db->query();
			
			// Borrado específico: No se debe usar la función eliminarAsientos ya que borra BD y variables de objeto. Al actualizar, yo necesito borrar nada más que la BD
			if (count($this->asientosEntrada) || count($this->asientosSalida)) {
				$query = $db->getQuery(true);
				$query->delete($this->tablaEntrada);
				$query->where('parent_id = ' . $this->id);
				$db->setQuery($query);
				$result = $db->query();
					
				$query = $db->getQuery(true);
				$query->delete($this->tablaSalida);
				$query->where('parent_id = ' . $this->id);
				$db->setQuery($query);
				$result = $db->query();				
			}
			
			// Creación de Asientos
			foreach ($this->asientosEntrada as $asiento) {				
				$asiento->crear();
			}
			foreach ($this->asientosSalida as $asiento) {				
				$asiento->crear();
			}
		} catch (Exception $e) {
			JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_ACTUALIZACIONOPERACION', $e) );
			return FALSE;
		}
	}
	
	public function eliminar($operacion_id = NULL)
	{			
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if (!$operacion_id)
			$operacion_id = $this->id;
		
		if (!$this->id) {
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_SINID') );
			return FALSE;
		}

		$conditions = array(
			'id='.$operacion_id
		);
		$query->delete('gjr_operacion');
		$query->where($conditions);
		$db->setQuery($query);
 
		//echo $query;	
		try {
			$result = $db->query();			
			$this->eliminarAsientos();
		} catch (Exception $e) {
			JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_ELIMINACIONOPERACION', $e) );
			return FALSE;
		}
		
		// No hay necesidad de borrar asientos ya que se borren vía SQL TRIGGER
		
		return TRUE;		
	}
	
	public function getEjercicio($date)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('id'))
			->from('gjr_ejercicio')
			->where($date >= ' fecha_inicio AND ' . $date .' <= fecha_cierre');
		$db->setQuery($query);
		$idEjercicio = $db->loadResult();	
		return intval($idEjercicio);
	}
	
	public function getAsientos()
	{
		$db = JFactory::getDbo();
		
		if (!$this->id) {
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_SINID') );
			return FALSE;
		}
			
		// Entrada
		$query = $db->getQuery(true);
		$query
			->select('id')
			->from($this->tablaEntrada)
			->where('parent_id = ' .  $this->id);
		$db->setQuery($query);
		$result = $db->loadAssocList();
		
		foreach ($result as $res) {			
			$asientoEntrada = AsientoContable::conID($res['id'], $this->tablaEntrada);
			$asientoEntrada->set('tabla', $this->tablaEntrada);			
			$this->asientosEntrada[] = $asientoEntrada;
		}
		
		// Salida
		$query = $db->getQuery(true);
		$query
			->select('id')
			->from($this->tablaSalida)
			->where('parent_id = ' . $this->id);
		$db->setQuery($query);
		$result = $db->loadAssocList();
		
		foreach ($result as $res) {						
			$asientoSalida = AsientoContable::conID($res['id'], $this->tablaSalida);
			$asientoSalida->set('tabla', $this->tablaSalida);						
			$this->asientosSalida[] = $asientoSalida;
		}		
		
		return TRUE;
	}
	
	public function crearAsiento($tabla, AsientoContable $asiento)
	{
		$asiento->set('parent_id', $this->id);
		
		if ($tabla == 'entrada') {
			$asiento->set('tabla', $this->tablaEntrada);
			$this->asientosEntrada[] = $asiento;
		} elseif ($tabla == 'salida') {
			$asiento->set('tabla', $this->tablaSalida);
			$this->asientosSalida[] = $asiento;				
		} else
			return FALSE;
		
		return;
	}
		
	function existenAsientos($operacion_id = NULL) {		
		$db = JFactory::getDbo();
		
		if ($operacion_id) {
			$query = $db->getQuery(true);
			$query
				->select(array('operacion_id'))
				->from($this->tablaEntrada)
				->where('operacion_id = ' . $operacion_id);
			$db->setQuery($query);
			$rowsEntrada = $db->loadObjectList();
					
			$query = $db->getQuery(true);
			$query
				->select(array('operacion_id'))
				->from($this->tablaSalida)
				->where('operacion_id = ' . $operacion_id);
			$db->setQuery($query);
			$rowsSalida = $db->loadObjectList();		
			
			return count($rowsEntrada) || count($rowsSalida);
		}
		
		return count($this->asientosEntrada) || count($this->asientosSalida);
	}

	public function eliminarAsientos($tabla = NULL) 
	{
		if ($tabla == NULL) {			
			$db = JFactory::getDbo();			
			 
			try {
				$query = $db->getQuery(true);
				$query->delete($this->tablaEntrada);
				$query->where('parent_id = ' . $this->id);
				$db->setQuery($query);
				$result = $db->query();
				
				$query = $db->getQuery(true);
				$query->delete($this->tablaSalida);
				$query->where('parent_id = ' . $this->id);
				$db->setQuery($query);
				$result = $db->query();								
				
				$this->asientosEntrada = NULL;
				$this->asientosSalida = NULL;
			} catch (Exception $e) {
				JError::raiseWarning( 100, JText::sprintf('JR_OPERACIONES_ERROR_ELIMINACIONASIENTOS', $e) );
				return FALSE;
			}
			return;
		}
		
		if ($tabla == 'entrada') {
			foreach ($this->asientosEntrada as $asiento) 
				$asiento->eliminar();
			$this->asientosEntrada = NULL;
		}
		if ($tabla == 'salida') {
			foreach ($this->asientosSalida as $asiento)
				$asiento->eliminar();			
			$this->asientosSalida = NULL;
		}
		
		return;
	}
	
	/*
	* Esta función se usa para hacer un relación dura de otros elementos a la operación una vez que esos elementos son guardados (Gastos, Aportes, etc).
	*/
	public function asociarRelacion($operacion_id, $relacion_id)
	{	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if (!$operacion_id || !$relacion_id) {
			JError::raiseWarning( 100, JText::_('JR_OPERACIONES_ERROR_SINID') );
			return FALSE;
		}
		
		$fields = array('relacion_id = '.$db->quote($relacion_id));
		$conditions = array('id='.$operacion_id);
		$query->update($db->quoteName('gjr_operacion'))->set($fields)->where($conditions);
		$db->setQuery($query); 
		try {
			$result = $db->query();
		} catch (Exception $e) {
			$this->setError($e);
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function validarOperacion()
	{
		if (empty($this->asientosEntrada) || empty($this->asientosSalida)) {
			return FALSE;
		}
		$totalDebePorMoneda = array();
		$totalHaberPorMoneda = array();
		
		foreach ($this->asientosEntrada as $asiento) {
			$totalDebePorMoneda[$asiento->monto->moneda] += $asiento->monto->monto;
		}		
		foreach ($this->asientosSalida as $asiento) {
			$totalHaberPorMoneda[$asiento->monto->moneda] += $asiento->monto->monto;
		}
		
		foreach ($totalDebePorMoneda as $moneda => $totalDebe) {
			if (!array_key_exists($moneda, $totalHaberPorMoneda))
				return FALSE;
			if ($totalHaberPorMoneda[$moneda] != $totalDebe)
				return FALSE;
		}
		
		return TRUE;
	}
}

class HandlerOperaciones
{
	public $formModel;
	public $operacion;
	
	public function __construct(&$formModel, $operacion)
	{
		$this->formModel = $formModel;
		$this->operacion = $operacion;		
	}
	
	public function onAfterProcess()
	{
		if ($this->operacion->tipo == 'I') {	
			$tabla = 'salida'; // Tabla de Egreso se resetea
			$cuentas = $this->formModel->getElementData('gjr_operacion_44_repeat___cuenta');
			$monedas = $this->formModel->getElementData('gjr_operacion_44_repeat___moneda');
			$montos = $this->formModel->getElementData('gjr_operacion_44_repeat___monto');	
			$tc_referencia = $this->formModel->getElementData('gjr_operacion_44_repeat___tc_referencia');
		} elseif ($this->operacion->tipo == 'E') {
			$tabla = 'entrada'; // Tabla de Ingreso se resetea
			$cuentas = $this->formModel->getElementData('gjr_operacion_45_repeat___cuenta');
			$monedas = $this->formModel->getElementData('gjr_operacion_45_repeat___moneda');
			$montos = $this->formModel->getElementData('gjr_operacion_45_repeat___monto');
			$tc_referencia = $this->formModel->getElementData('gjr_operacion_45_repeat___tc_referencia');
		}

		$totalContraPartida = array();		
		
		foreach ( $cuentas AS $key => $cuenta ) {				
			$totalContraPartida[$monedas[$key][0]]['valor'] += floatval($montos[$key]);
			$totalContraPartida[$monedas[$key][0]]['tc_referencia'] = floatval($tc_referencia[$key]);
		}	
		
		$this->operacion->eliminarAsientos($tabla);		
		foreach ($totalContraPartida as $key => $totalPorMoneda) {			
			$total = new Monto($totalPorMoneda['valor'], $key, $totalPorMoneda['tc_referencia']);			
			$this->operacion->crearAsiento($tabla,  AsientoContable::conDatos(array(				
				'cuenta' => $this->operacion->concepto,
				'monto' => $total // Se pasa el objeto
			)));			
		}
		$this->operacion->actualizar();

		return;
	}
}