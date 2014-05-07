<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

class Cuenta
{
	public $date_time;
	public $nombre;
	public $tipo;
	public $fecha_inicio;
	public $fecha_cierre;
	
	public function __construct($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from('gjr_cuenta')
			->where('id = '.$id);
		$db->setQuery($query);		
		return $db->loadAssoc();
	}
	
}

function alta_cuenta($data) {	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true); 
	$columns = array('date_time', 'nombre', 'tipo', 'fecha_inicio', 'fecha_cierre', 'debe', 'haber', 'saldo'); 
	$values = array(
		"'".$data['date_time']."'",		
		"'".$data['nombre']."'",
		"'".$data['tipo']."'",
		"'".$data['fecha_inicio']."'",
		"'".$data['fecha_cierre']."'",
		"'NULL'",
		"'NULL'",
		"'NULL'",
	);
	
	$query
		->insert($db->quoteName('gjr_cuenta'))
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
	return $db->insertid();
}

function eliminar_cuenta($cuenta_id) {	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	 
	$query->delete($db->quoteName('gjr_cuenta'));
	$query->where('id = ' . $cuenta_id);
	$db->setQuery($query);
	
	try {
		// Execute the query
		$result = $db->query();
	} catch (Exception $e) {
		$this->setError($e);
		return false;
	}	
}

function asociar_cuenta($tabla, $campos, $condiciones) {	
	
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	
	foreach ($campos as $key => $datum) 
		$fields[] = $key."="."'".$datum."'";
	
	foreach ($condiciones as $key => $datum) 
		$conditions[] = $key."="."'".$datum."'";
	
	$query->update($db->quoteName($tabla))->set($fields)->where($conditions);
	$db->setQuery($query); 
	try {
		$result = $db->query();
	} catch (Exception $e) {
		$this->setError($e);
	}
}

?>