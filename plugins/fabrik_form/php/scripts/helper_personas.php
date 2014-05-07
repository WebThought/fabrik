<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

class Persona
{
	private $direcciones;
	
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
			->from('gjr_persona')
			->where('id = '.$id);
		$db->setQuery($query);		
		$result = $db->loadAssoc();	
		
	   	$this->cargar( $result );
		$this->getDirecciones();
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
	
	public function getDirecciones()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_persona_17_repeat')
			->where('parent_id = '.$this->id);
		$db->setQuery($query);
		$this->direcciones = $db->loadAssocList('tipo_direccion');			
		
		return;
	}
	
	public function crear() {	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
				
		$columns = array('apellido', 'nombre', 'persona_juridica', 'cuit_cuil'); 
		$values = array(		
			"'".$this->apellido."'",
			"'".$this->nombre."'",
			"'".$this->persona_juridica."'",		
			"'".$this->cuit_cuil."'"			
		);
		
		$query
			->insert('gjr_persona')
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
	
	public function eliminar()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		if (!$this->id)
			return FALSE;
		
		$conditions = array(
			'id='.$this->id
		);
		$query->delete('gjr_persona');
		$query->where($conditions);
		$db->setQuery($query);
 
		try {
			$result = $db->query();			
		} catch (Exception $e) {
			$this->setError($e);
		}
		
		return TRUE;		
	}
	
	public function direccion($tipo = 'Real')
	{	
		$direccion = '';
		if (isset($this->direcciones[$tipo])) {			
			
			if ($this->direcciones[$tipo]['direccion']) $direccion[] = $this->direcciones[$tipo]['direccion'];
			if ($this->direcciones[$tipo]['ciudad']) $direccion[] = $this->direcciones[$tipo]['ciudad'];
			if ($this->direcciones[$tipo]['codigo_postal']) $direccion[] = $this->direcciones[$tipo]['codigo_postal'];
			if ($this->direcciones[$tipo]['provincia']) $direccion[] = $this->getEstado($this->direcciones[$tipo]['provincia']);
			if ($this->direcciones[$tipo]['pais']) $direccion[] = $this->getPais($this->direcciones[$tipo]['pais']);			
			return implode(', ', $direccion);
			
		} elseif ( count($this->direcciones) ) {
		
			$elem = array_shift(array_values($this->direcciones));			
			if ($elem['direccion']) $direccion[] = $elem['direccion'];
			if ($elem['ciudad']) $direccion[] = $elem['ciudad'];
			if ($elem['codigo_postal']) $direccion[] = $elem['codigo_postal'];
			if ($elem['provincia']) $direccion[] = $elem['provincia'];
			if ($elem['pais']) $direccion[] = $this->getPais($elem['pais']);			
			return implode(', ', $direccion);
			
		}
		return NULL;
	}
	
	public function nacionalidad()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('pais')
			->from('gjr_pais')
			->where('id = '.$this->nacionalidad);
		$db->setQuery($query);		
		return $db->loadResult();		
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
}
?>