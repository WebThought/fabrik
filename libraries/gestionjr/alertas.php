<?php
defined('_JEXEC') or die();

class AlertasHelper
{
    private $alertas;
    
	public function __construct($table, $parent_id) {
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
        
        $query = "SELECT * FROM {$table} WHERE parent_id = {$parent_id} AND leido = 0";
        $db->setQuery($query);
        $this->alertas = $db->loadAssocList();		
	}

	public function getAlertas()  {
        return $this->alertas;        
	}		
}