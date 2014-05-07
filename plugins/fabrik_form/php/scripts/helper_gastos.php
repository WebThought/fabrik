<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_operaciones.php");
require_once(dirname(__FILE__)."/helper_cobranza.php");

class Gasto
{
	private $tabla;
	private $formModel;
	public $id;
	public $date_time;
	public $cuenta;
	public $concepto;
	public $nombre;
	public $descripcion;
	public $relacionEmprendimiento;
	public $emprendimiento;
	public $prorratear;
	public $operacion_id;
	public $montosPorMoneda;

	public function __construct(&$formModel)
	{
		$this->tabla = 'gjr_gasto';
		$this->formModel = $formModel;
		$this->date_time = $formModel->getElementData('gjr_gasto___date_time');				
		$this->id = $formModel->getElementData('gjr_gasto___id');
		
		$this->cuenta = $formModel->getElementData('gjr_gasto___cuenta');
		$this->concepto = $formModel->getElementData('gjr_gasto___concepto');	
		$this->nombre = $formModel->getElementData('gjr_gasto___nombre');
		$this->descripcion = $formModel->getElementData('gjr_gasto___descripcion');
		
		$relacionEmprendimiento = $formModel->getElementData('gjr_gasto___relacion_emprendimiento');
		$this->relacionEmprendimiento = intval($relacionEmprendimiento[0]);
		$emprendimiento = $formModel->getElementData('gjr_gasto___emprendimiento');
		$this->emprendimiento = $emprendimiento[0];	
		$prorratear = $formModel->getElementData('gjr_gasto___prorratear');
		$this->prorratear = $prorratear[0];
		
		$this->operacion_id = $formModel->getElementData('gjr_gasto___operacion_id');
		
		// Montos
		$this->montos = array();
		$montos = $this->formModel->getElementData('gjr_gasto_110_repeat___monto');
		$montos_moneda = $this->formModel->getElementData('gjr_gasto_110_repeat___moneda');
		$montos_tc_referencia = $this->formModel->getElementData('gjr_gasto_110_repeat___tc_referencia');
		foreach ($montos as $key => $monto) {
			$montosAux[$montos_moneda[$key][0]]['monto'] += $monto;			
			$montosAux[$montos_moneda[$key][0]]['tc_referencia'] = $montos_tc_referencia[$key];
		}
		
		foreach ($montosAux as $key => $monto) {
			$montoAux = new Monto(
				$monto['monto'],
				$key,
				$monto['tc_referencia']
			);			
			$this->montosPorMoneda[] = $montoAux;
		}
		
	}
	
	/*
	* onBeforeStore: Generación de Operación Relacionada y Cobranza
	*/
	public function onBeforeStore()
	{	
	
		$ejercicio = Operacion::getEjercicio($this->date_time);
		
		// Generación de Operación
		$operacion = Operacion::conDatos( array(
			'date_time'			=> $this->date_time,
			'fecha_operacion' 	=> $this->date_time,
			'ejercicio'			=> $ejercicio,		
			'descripcion' 		=> 'Gasto'.($this->nombre[0] > 1 ? ' - '.$this->getNombre($this->nombre[0]) : '').(strlen($this->descripcion) > 1 ? ' - '.$this->descripcion : ''),
			'tipo'				=> 'E',
			'concepto' 			=> $this->concepto[0],
			'tabla_relacionada' => 'gjr_gasto',
			'relacion_id'		=> $this->id
		));
		foreach($this->montosPorMoneda as $monto) {
			$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
				'cuenta' => $this->concepto[0],
				'monto' => $monto
			)));
			$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
				'cuenta' => $this->cuenta['0'],
				'monto' => $monto
			)));
		}
		
		if ( $this->id == '' || intval($this->operacion_id) == 0) {			
			$this->operacion_id = $operacion->crear();
			$this->formModel->updateFormData('gjr_gasto___operacion_id', $this->operacion_id, true);	
		} else {			
			$operacion->set('id', $this->operacion_id);	
			$operacion->actualizar();		
		}
		
		// Generación de Cobranza
		if ($this->relacionEmprendimiento && $this->prorratear) {
			Cobranza::eliminarCobranzaOperacion($operacion->id);
			$ventas = $this->getVentasEmprendimiento($this->emprendimiento);
			
			if (count($ventas)) {
				foreach ($ventas as $venta) {
					
					$prorrateo = $monto->monto / count($ventas);
					$prorrateo = new Monto($prorrateo, $monto->moneda);
					
					$cobranza = Cobranza::conDatos(array(
						'date_time'			=> $operacion->date_time,
						'operacion'			=> $operacion->id,
						'operaciones_cobro'	=> '',
						'inmueble_id'		=> $venta['inmueble'],
						'cliente_id' 		=> $venta['comprador'],
						'descripcion' 		=> $operacion->descripcion,
						'monto' 			=> $prorrateo,
						'vencimiento'		=> $operacion->date_time,
						'estado'			=> 'Pendiente',
						'fecha_cobro'		=> 'NULL'
					));
					$cobranza->crear();
				}
			}
		}		
	
	}
	
	/*
	* onAfterProcess: Asociar Operación
	*/
	public function onAfterProcess()
	{	
		Operacion::asociarRelacion($this->operacion_id, $this->id);	
	}
	
	private function getVentasEmprendimiento($emprendimiento_id)
	{
		$db = JFactory::getDbo();
		
		if (!$emprendimiento_id)
			return FALSE;
			
		// Entrada
		$query = $db->getQuery(true);
		$query = "
			SELECT *
			FROM gjr_venta_propiedad vp
			INNER JOIN gjr_inmueble i ON vp.inmueble = i.id
			WHERE 
				i.estado = 'Vendida'
				AND i.emprendimiento = '{$emprendimiento_id}'
		";
		//echo $query;
		$db->setQuery($query);
		
		return $db->loadAssocList();
	}
	
	private function getNombre($nombre_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('nombre')
			->from('gjr_gasto_nombre')
			->where('id = '.$nombre_id);
		$db->setQuery($query);		
		return $db->loadResult();	
	}
	
}