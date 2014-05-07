<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_personas.php");
require_once(dirname(__FILE__)."/helper_cuentas.php");
require_once(dirname(__FILE__)."/helper_operaciones.php");

class Emprendimiento
{
	public $versiones_proyecto;
	public $version_proyecto_valida;
	
	public static function conID( $id ) {
    	$instance = new self();		
    	$instance->cargarId( $id );
    	return $instance;
    }
	
	public static function conDatos( $values ) {
    	$instance = new self($tipo);		
    	$instance->cargar( $values );		
    	return $instance;
    }

	protected function cargarId( $id ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_emprendimiento')
			->where('id = '.$id);
		$db->setQuery($query);		
		$result = $db->loadAssoc();	
		
	   	$this->cargar( $result );
		$this->getProyectos();
    }

    protected function cargar( $values )
	{	
		foreach ($values as $param => $value)
			$this->$param = $value;
    }
	
	public function set($param, $value)
	{
		$this->$param = $value;	
		return;
	}
	
	private function getProyectos()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_emprendimiento_69_repeat')
			->where('parent_id = '.$this->id);
		$db->setQuery($query);		
		$this->versiones_proyecto = $db->loadAssocList('id');		
		$this->version_proyecto_valida = max(array_keys($this->versiones_proyecto));
		
		return;
	}
	
	public function onBeforeStore()
	{
		return;
	}
	
	public function onAfterProcess()
	{
		$this->asociarPersonaJuridica();
	}
	
	private function asociarPersonaJuridica()
	{	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if ($this->persona_juridica == '' OR $this->persona_juridica = 0) {
			$persona = Persona::conDatos(array(
				'nombre' 			=> $this->nombre,
				'apellido' 			=> $this->nombre,
				'persona_juridica'	=> true
			));
			$persona->crear();
		}			
		$this->persona_juridica = $persona->id;		
		$this->formModel->updateFormData('gjr_emprendimiento___persona_juridica', $this->persona_juridica, true);
		return;
	}
	
	public function direccion($tipo = 'real')
	{
		$direccion = array();
		if ($this->direccion) $direccion[] = $this->direccion;
		if ($this->ciudad) $direccion[] = $this->ciudad;
		if ($this->codigo_postal) $direccion[] = $this->codigo_postal;
		if ($this->provincia) $direccion[] = $this->getEstado($this->provincia);
		if ($this->pais) $direccion[] = $this->getPais($this->pais);
					
		return implode(', ', $direccion);
	}
	
	private function getPais($pais_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('pais')
			->from('gjr_pais')
			->where('id = '.$pais_id);
		$db->setQuery($query);		
		return $db->loadResult();		
	}
	
	private function getEstado($estado_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('estado')
			->from('gjr_estado')
			->where('id = '.$estado_id);
		$db->setQuery($query);		
		return $db->loadResult();		
	}
	
	/* SE DESPUBLICA PORQUE NO SE VA A USAR LA CUENTA DE ACTIVO ASOCIADO */
	/*public function asociarCuentaActivo($cuenta_activo)
	{	
		$data = array();

		if ($cuenta_activo == 0 || $cuenta_activo == '') {
			$data['date_time'] = $this->date_time;
			$data['nombre'] = $this->nombre;
			$data['tipo'] = 'A';
			$data['fecha_inicio'] = $this->date_time;
			$data['fecha_cierre'] = '0000-00-00 00:00:00';

			$id = alta_cuenta($data);
			$campos = array('cuenta_activo' => $id);
			$condiciones = array('id' => $this->id);
			asociar_cuenta('gjr_emprendimiento', $campos, $condiciones);
		}
	}*/
}
?>