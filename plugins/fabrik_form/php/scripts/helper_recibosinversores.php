<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once (dirname(__FILE__)."/helper_monto.php");
require_once (dirname(__FILE__)."/helper_inmuebles.php");
require_once (dirname(__FILE__)."/helper_personas.php");
require_once (dirname(__FILE__)."/helper_emprendimientos.php");

class HandlerRecibosInversores
{

	public function __construct(&$session, &$dataObject)
	{
		if (isset($session['com_fabrik.form.data'])) {
		
			$data = $session['com_fabrik.form.data'];
			//var_dump($data);
			//var_dump($data['join']);

			$emprendimiento = Emprendimiento::conID($data['gjr_aporte_inversor___emprendimiento'][0]);			
			$inversor = Persona::conID($data['gjr_aporte_inversor___inversor'][0]);
			//var_dump($dataObject->emprendimiento);
			//var_dump($dataObject->inversor);
			
			$dataObject->emprendimiento->nombre = $emprendimiento->nombre;
			$dataObject->emprendimiento->nomenclatura = $emprendimiento->nomenclatura_catastral;
			$dataObject->emprendimiento->direccion = $emprendimiento->direccion();
			$dataObject->emprendimiento->descripcion = $emprendimiento->descripcion;
			
			$dataObject->inversor->nombre = $inversor->nombre.' '.$inversor->apellido;
			$dataObject->inversor->nacionalidad = $inversor->nacionalidad();
			$dataObject->inversor->idn = $inversor->idn;
			$dataObject->inversor->cuit_cuil = $inversor->cuit_cuil;			
			$dataObject->inversor->domicilio = $inversor->direccion('Legal');
			
			$posiciones_inversor = $data['join'][351]['gjr_aporte_inversor_86_repeat___posiciones'];
			$dataObject->posiciones_inversor = array_sum($posiciones_inversor);
			$dataObject->posiciones = $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['posiciones'];
			$posicion_valor = new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['posicion_valor'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['posicion_moneda']);
			$dataObject->posicion_valor = (string) $posicion_valor;
			$dataObject->posicion_valor_texto = $posicion_valor->enLetras();
			$dataObject->inversion_total =  (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['inversion_total'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['posicion_moneda']);
			
			$aportes = $data['join'][351]['gjr_aporte_inversor_86_repeat___aporte_monto'];
			$aportes_moneda = $data['join'][351]['gjr_aporte_inversor_86_repeat___aporte_moneda'];			
			foreach ($aportes as $key => $aporte) {
				$aportesAux[] = new Monto($aporte, $aportes_moneda[$key][0]);				
			}			
			foreach ($aportesAux as $aporte)
				$aportesTextos[] = $aporte->enLetras().' ('.$aporte.')';
			$dataObject->aportes_textos = implode(', ', $aportesTextos);
						
			// Gastos
			$dataObject->gastos->gasto_costo_terreno = (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_costo_terreno'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			
			$dataObject->gastos->gasto_honorarios_comprador = (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_honorarios_comprador'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			
			$gasto_plano_municipal = new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_costo_terreno'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			$gasto_ph = new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_ph'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			$dataObject->gastos->gasto_planos = (string) Monto::sumar($gasto_plano_municipal,$gasto_ph);
			
			$dataObject->gastos->gasto_escritura = (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_escritura'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			
			$dataObject->gastos->gasto_desmonte_calle_electricidad = (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_desmonte_calle_electricidad'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			
			$dataObject->gastos->gasto_administracion = (string) new Monto($emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gasto_administracion'], $emprendimiento->versiones_proyecto[$emprendimiento->version_proyecto_valida]['gastos_moneda']);
			
		}	
		
		unset($this->session['com_fabrik.form.13.data']);
		return;
	}
	
	public function buildFake($name, &$elements)
	{		
		$view = JRequest::getVar('view');
		
		if ($view == 'form')
			return '<span class="inline-input"><input type="text" class="fake_gjr_recibos_inversores___'.$name.' form-control" value="'.$elements[$name]->value.'" readonly="readonly"/></span>';
		else
			return $elements[$name]->value;
	}
	
}