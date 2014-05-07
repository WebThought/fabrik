<?php
/**
 * Cobalt by MintJoomla
 * a component for Joomla! 1.7 - 2.5 CMS (http://www.joomla.org)
 * Author Website: http://www.mintjoomla.com/
 * @copyright Copyright (C) 2012 MintJoomla (http://www.mintjoomla.com). All rights reserved.
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die();

class FabrikControllerGJAlertas extends JControllerLegacy
{
    protected $input;
    
    public function __construct($config = array())
	{
		parent::__construct($config);
		
		if(!$this->input)
		{
			$this->input = JFactory::getApplication()->input;
		}
	}
    
	public function ajaxMarcarComoLeido()
	{
		$user = JFactory::getUser();
		if (!$user->get('id')) {
			AjaxHelper::error('Información no disponible.');
			return;
		}
		
		$alerta_id = $this->input->getInt('id');
        $tabla_alerta = $this->input->getVar('table');
		if (!$alerta_id || $tabla_alerta == '') {
			AjaxHelper::error('Se debe seleccionar un curso');			
			return;
		}
		
        $db = JFactory::getDbo();
        $query = "UPDATE {$tabla_alerta} SET leido = 1 WHERE id = {$alerta_id}";
		$db->setQuery($query);		
        $db->execute();
        
        header('Content-type: application/json');
        echo json_encode('');
        exit;
	}		
}
