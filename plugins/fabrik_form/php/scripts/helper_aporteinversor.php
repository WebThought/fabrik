<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_operaciones.php");

class AporteInversor
{
	public $formModel;
	public $id;
	public $fecha_aporte;
	public $ejercicio;
	public $inversor_id;
	public $aportes;
	
	public function __construct(&$formModel)
	{
		$this->formModel = $formModel;
		$this->id = $formModel->getElementData('gjr_aporte_inversor___id');
		$this->fecha_aporte = $formModel->getElementData('gjr_aporte_inversor___fecha_aporte');
		$this->ejercicio = Operacion::getEjercicio($this->fecha_aporte);
		$this->inversor_id = $formModel->getElementData('gjr_aporte_inversor___inversor');
		
		$aporteMontos = $this->formModel->getElementData('gjr_aporte_inversor_86_repeat___aporte_monto');
		$aporteMonedas = $this->formModel->getElementData('gjr_aporte_inversor_86_repeat___aporte_moneda');
		$aporteTCReferencia = $this->formModel->getElementData('gjr_aporte_inversor_86_repeat___tc_referencia');
		foreach($aporteMontos as $key => $aporte) {
			$this->aportes[] = new Monto($aporte, $aporteMonedas[$key][0], $aporteTCReferencia[$key]);
		}
		
		$this->operacion_id = $formModel->getElementData('gjr_aporte_inversor___operacion_id');
	}
	
	protected function getNombreInversor($inversor_id)
	{	
		$db = JFactory::getDbo();
		$db->setQuery("SELECT CONCAT(apellido, ', ', nombre) AS value FROM gjr_persona WHERE id = ".$inversor_id);
		return $db->loadResult();
	}
	
	/*
	* onBeforeStore: Generación de Operación Relacionada
	*/
	public function onBeforeStore()
	{
		// Generación de Operación
		$operacion = Operacion::conDatos( array(
			'date_time'			=> $this->fecha_aporte,
			'fecha_operacion' 	=> $this->fecha_aporte,
			'ejercicio'			=> $this->ejercicio,		
			'descripcion' 		=> 'Aporte de Inversor: '.$this->getNombreInversor($this->inversor_id[0]),
			'tipo'				=> 'I',
			'concepto' 			=> 35, // 35: Aportes de Inversores
			'tabla_relacionada' => 'gjr_aporte_inversor',
			'relacion_id'		=> $this->id
		));
		foreach($this->aportes as $aporte) {
			$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
				'cuenta' => 1, // Caja
				'monto' => $aporte // Se pasa el objeto				
			)));
			$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
				'cuenta' => 35, // Aportes de Inversores	
				'monto' => $aporte // Se pasa el objeto					
			)));
		}
		
		if ( $this->id == '' || intval($this->operacion_id) == 0) {
			$this->operacion_id = $operacion->crear();
			$this->formModel->updateFormData('gjr_aporte_inversor___operacion_id', $this->operacion_id, true);	
		} else {
			$operacion->set('id', $this->operacion_id);	
			$operacion->actualizar();		
		}
		
		return;
	}
	
	public function onAfterProcess()
	{
		Operacion::asociarRelacion($this->operacion_id, $this->id);	
	}
}
?>