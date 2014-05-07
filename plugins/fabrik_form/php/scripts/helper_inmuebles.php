<?php
function getNomenclatura($inmueble_id) {	
	$db = JFactory::getDbo();
	$db->setQuery("SELECT nomenclatura FROM gjr_inmueble WHERE id = ".$inmueble_id);
	return $db->loadResult();
}

function getCodigo($inmueble_id) {	
	$db = JFactory::getDbo();
	$db->setQuery("SELECT codigo FROM gjr_inmueble WHERE id = ".$inmueble_id);
	return $db->loadResult();	
}
?>