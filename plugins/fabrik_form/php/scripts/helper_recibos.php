<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once (dirname(__FILE__)."/helper_inmuebles.php");
require_once (dirname(__FILE__)."/helper_personas.php");

class HandlerRecibos
{
	public function __construct(&$session, &$dataObject, &$tipoRecibo)
	{
		$data = $session['com_fabrik.form.data'];
		//var_dump($data);
		//var_dump($data['join']);		
		
		/**** Operaciones ****/
		if (isset($data['gjr_operacion___id'])) {

			foreach ($data['join'][145]['gjr_operacion_44_repeat___monto'] as $key => $importe) {
				$dataObject['detalle'][$key]['descripcion'] = $data['gjr_operacion___descripcion'];
				$dataObject['detalle'][$key]['vencimiento'] = date('d/m/Y', strtotime($data['gjr_operacion___date_time']));
				$dataObject['detalle'][$key]['moneda'] = $data['join'][145]['gjr_operacion_44_repeat___moneda_raw'][$key];
				$dataObject['detalle'][$key]['importe'] = $importe;
			}
			
		}
		
		/**** Venta de Propiedad ****/
		if (isset($data['gjr_venta_propiedad___id'])) {
			
			$comprador = Persona::conID( $data['join'][368]['gjr_venta_propiedad_87_repeat___comprador'][0] );
			$dataObject['cliente']['id'] = $comprador->id;
			$dataObject['cliente']['nombre'] = $comprador->nombre;
			$dataObject['nomenclatura']['id'] = $data['gjr_venta_propiedad___inmueble'][0];
			$dataObject['nomenclatura']['nombre'] = $this->getNomenclatura($data['gjr_venta_propiedad___inmueble'][0]);
		
			$forma_pago = $data['gjr_venta_propiedad___forma_pago'][0];
			if ( $forma_pago == 'Contado' ) {
				$boleto = $data['join'][368]['gjr_venta_propiedad_87_repeat___boleto'][0];
				if ( $boleto != 1) {
					// Reserva
					$dataObject['segun'] = '0';	
					foreach ($data['join'][366]['gjr_venta_propiedad_88_repeat___reserva'] as $key => $importe) {
						$dataObject['detalle'][$key]['descripcion'] = JText::_('JR_VENTAPROPIEDADES_RESERVA');
						$dataObject['detalle'][$key]['vencimiento'] = date('d/m/Y', strtotime($data['gjr_venta_propiedad___date_time']));
						$dataObject['detalle'][$key]['moneda'] = $data['join'][366]['gjr_venta_propiedad_88_repeat___reserva_moneda_raw'][$key];
						$dataObject['detalle'][$key]['importe'] = $importe;
					}
				} else {
				
					$inmobiliaria = $data['gjr_venta_propiedad___inmobiliaria'];				
					if ($inmobiliaria == 'No') {
						// Saldo Boleto
						$dataObject['segun'] = '1';	
						foreach ($data['join'][468]['gjr_venta_propiedad_105_repeat___saldo'] as $key => $importe) {
							$dataObject['detalle'][$key]['descripcion'] = JText::_('JR_VENTAPROPIEDADES_SALDO');
							$dataObject['detalle'][$key]['vencimiento'] = date('d/m/Y', strtotime($data['gjr_venta_propiedad___date_time']));
							$dataObject['detalle'][$key]['moneda'] = $data['join'][468]['gjr_venta_propiedad_105_repeat___saldo_moneda'][$key][0];
							$dataObject['detalle'][$key]['importe'] = $importe;
						}
					} else {
						// Honorarios Comprador
						$dataObject['segun'] = '1';	
						foreach ($data['join'][405]['gjr_venta_propiedad_100_repeat___honorarios_comprador_monto'] as $key => $importe) {
							$dataObject['detalle'][$key]['descripcion'] = JText::_('JR_VENTAPROPIEDADES_HONORARIOSCOMPRADOR');
							$dataObject['detalle'][$key]['vencimiento'] = date('d/m/Y', strtotime($data['gjr_venta_propiedad___date_time']));
							$dataObject['detalle'][$key]['moneda'] = $data['join'][405]['gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda'][$key][0];
							$dataObject['detalle'][$key]['importe'] = $importe;
						}
					}
				
				}
				
			} else {		
				$dataObject['segun'] = '1';	
				foreach ($data['join'][369]['gjr_venta_propiedad_89_repeat___anticipo'] as $key => $importe) {
					$dataObject['detalle'][$key]['descripcion'] = JText::_('JR_VENTAPROPIEDADES_ANTICIPO');
					$dataObject['detalle'][$key]['vencimiento'] = date('d/m/Y', strtotime($data['gjr_venta_propiedad___date_time']));
					$dataObject['detalle'][$key]['moneda'] = $data['join'][369]['gjr_venta_propiedad_89_repeat___anticipo_moneda'][$key][0];
					$dataObject['detalle'][$key]['importe'] = $importe;
				}			
			}			
			$dataObject['codigo'] = getCodigo($data['gjr_venta_propiedad___inmueble'][0]);
						
			//unset($session['com_fabrik.form.25.data']);
		}
	
		/**** Cobranza ****/
		if (isset($data['gjr_cobranza___id'])) {
			
			$cliente = Persona::conID( $data['gjr_cobranza___cliente_id'][0] );
			$dataObject['cliente']['id'] = $cliente->id;
			$dataObject['cliente']['nombre'] = $cliente->nombre;
			$dataObject['nomenclatura']['id'] = $data['gjr_cobranza___inmueble_id'][0];
			$dataObject['nomenclatura']['nombre'] = $this->getNomenclatura($data['gjr_cobranza___inmueble_id'][0]);
			
			$descripcion = strtolower($data['gjr_cobranza___descripcion']);
			if (strstr($descripcion, 'cuota'))
				$dataObject['segun'] = '2';
			elseif (strstr($descripcion, 'anticipo') || strstr($descripcion, 'reserva'))
				$dataObject['segun'] = '1';
			else
				$dataObject['segun'] = ' ';
			$dataObject['codigo'] = $data['gjr_cobranza___inmueble_id'][0];		
			
			foreach ($data['join'][437]['gjr_cobranza_102_repeat___cobro_monto'] as $key => $importe) {
				$dataObject['detalle'][$key]['descripcion'] = $data['gjr_cobranza___descripcion'];
				$dataObject['detalle'][$key]['vencimiento'] = $data['gjr_cobranza___vencimiento'];
				$dataObject['detalle'][$key]['moneda'] = $data['join'][437]['gjr_cobranza_102_repeat___cobro_moneda'][$key][0];
				$dataObject['detalle'][$key]['importe'] = $importe;
			}
			$tipoRecibo = 'Cobranza';
			//unset($session['com_fabrik.form.27.data']);
		}
				
		return;
	}
	
	public function getNomenclatura($inmueble_id)
	{	
		$db = JFactory::getDbo();
		$db->setQuery("SELECT nomenclatura FROM gjr_inmueble WHERE id = ".$inmueble_id);
		return $db->loadResult();
	}

}