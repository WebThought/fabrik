<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

require_once(dirname(__FILE__)."/helper_operaciones.php");
require_once(dirname(__FILE__)."/helper_cobranza.php");

class VentaPropiedad
{
	private $tabla;
	private $formModel;
	public $id;
	public $forma_pago;
	public $inmobiliaria;
	public $inmueble_id;
	public $comprador;
	public $vendedor;
	public $operacionRelacionada;
	public $fecha_operacion;
	public $boleto;
	public $reservas;
	public $saldosBoleto;
	public $honorariosBoletoComprador;
	public $honorariosBoletoVendedor;
	public $anticipos;
	public $primerVencimiento;
	public $cuotasTipo;
	public $cuotasCant;
	public $cuotasValor;
	public $cuotasMoneda;
	public $cuotasTCRef;
	public $cuotasFrecuencia;
	public $cuotasVencimiento;

	public function __construct(&$formModel)
	{
		$this->tabla = 'gjr_venta_propiedad';
		$this->formModel = $formModel;
		$this->id = $formModel->getElementData('gjr_venta_propiedad___id');
		$this->forma_pago = $formModel->getElementData('gjr_venta_propiedad___forma_pago');
		$this->inmobiliaria = $formModel->getElementData('gjr_venta_propiedad___inmobiliaria');	
		$this->inmueble_id = $formModel->getElementData('gjr_venta_propiedad___inmueble');
		$this->comprador = $formModel->getElementData('gjr_venta_propiedad_87_repeat___comprador');
		$this->vendedor = $formModel->getElementData('gjr_venta_propiedad_87_repeat___vendedor');
		$this->fecha_operacion = $formModel->getElementData('gjr_venta_propiedad___date_time');				
		$this->boleto = $formModel->getElementData('gjr_venta_propiedad_87_repeat___boleto');	
		$this->boleto = intval($this->boleto[0]);
		
		$this->primerVencimiento = $formModel->getElementData('gjr_venta_propiedad___fecha_primer_vencimiento');
		$this->cuotasTipo = $formModel->getElementData('gjr_venta_propiedad_80_repeat___cuotas_tipo');
		$this->cuotasCant = $formModel->getElementData('gjr_venta_propiedad_80_repeat___cuotas_cantidad');
		$this->cuotasValor = $formModel->getElementData('gjr_venta_propiedad_80_repeat___cuotas_valor');
		$this->cuotasMoneda = $formModel->getElementData('gjr_venta_propiedad_80_repeat___cuotas_moneda');
		$this->cuotasTCRef = $formModel->getElementData('gjr_venta_propiedad_80_repeat___tc_referencia');
		$this->cuotasFrecuencia = $formModel->getElementData('gjr_venta_propiedad_80_repeat___cuotas_frecuencia');
		$this->cuotasVencimiento = $formModel->getElementData('gjr_venta_propiedad_80_repeat___especial_vencimiento');
		
		// Operaciones Relacionadas
		$this->operacionRelacionada->reserva = $this->formModel->getElementData('gjr_venta_propiedad___operacion_reserva');	
		$this->operacionRelacionada->devolucion_reserva = $this->formModel->getElementData('gjr_venta_propiedad___operacion_devolucion_reserva');	
		$this->operacionRelacionada->boleto = $this->formModel->getElementData('gjr_venta_propiedad___operacion_boleto');	
		$this->operacionRelacionada->anticipo = $this->formModel->getElementData('gjr_venta_propiedad___operacion_anticipo');
		$this->operacionRelacionada->honorarios->egreso_emprendimiento = $this->formModel->getElementData('gjr_venta_propiedad___operacion_honorarios_egreso_emprendimiento');
		$this->operacionRelacionada->honorarios->ingreso_inmobiliaria = $this->formModel->getElementData('gjr_venta_propiedad___operacion_honorarios_ingreso_inmobiliaria');
		$this->operacionRelacionada->financiacion = $this->formModel->getElementData('gjr_venta_propiedad___operacion_financiacion');
		
		// Reservas
		$this->reservas = array();
		$reservas = $this->formModel->getElementData('gjr_venta_propiedad_88_repeat___reserva');
		$reservas_moneda = $this->formModel->getElementData('gjr_venta_propiedad_88_repeat___reserva_moneda');		
		foreach ($reservas as $key => $reserva) {
			$reservaMonto = new Monto(
				$reserva,
				$reservas_moneda[$key][0],
				NULL
			);			
			$this->reservas[] = $reservaMonto;
		}
		
		// Saldo Boleto
		$this->saldosBoleto = array();
		$saldos = $this->formModel->getElementData('gjr_venta_propiedad_105_repeat___saldo');
		$saldos_moneda = $formModel->getElementData('gjr_venta_propiedad_105_repeat___saldo_moneda');
		$saldos_tc_referencia = $formModel->getElementData('gjr_venta_propiedad_105_repeat___saldo_tc_referencia');		
		$saldos_comprador= $formModel->getElementData('gjr_venta_propiedad_105_repeat___saldo_honorarios_comprador');
		$saldos_vendedor = $formModel->getElementData('gjr_venta_propiedad_105_repeat___saldo_honorarios_vendedor');
		foreach ($saldos as $saldo) {
			$saldoDescontado = $saldo - $saldos_comprador[$key] - $saldos_vendedor[$key];
			$saldoDescontado = new Monto($saldoDescontado, $saldos_moneda[$key][0], $saldos_tc_referencia[$key]);
			$honorarios = $saldos_comprador[$key] + $saldos_vendedor[$key];
			$honorarios = new Monto($honorarios, $saldos_moneda[$key][0], $saldos_tc_referencia[$key]);			
			$saldo = new Monto($saldo, $saldos_moneda[$key][0], $saldos_tc_referencia[$key]);
			$this->saldosBoleto[] = array(
				'saldoDescontado' => $saldoDescontado,
				'honorarios' => $honorarios,
				'saldo' => $saldo
			);			
		}
		
		// Honorarios Boleto
		$this->honorariosBoletoComprador = $this->honorariosBoletoVendedor = array();
		$honorarios_comprador = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_monto');
		$honorarios_comprador_moneda = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda');
		$honorarios_comprador_tc_referencia = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda');
		foreach($honorarios_comprador as $key => $honorario) {
			$this->honorariosBoletoComprador[] = new Monto($honorario, $honorarios_comprador_moneda[$key][0], $honorarios_comprador_tc_referencia[$key]);
		}
		$honorarios_vendedor = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_monto');
		$honorarios_vendedor_moneda = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda');
		$honorarios_vendedor_tc_referencia = $this->formModel->getElementData('gjr_venta_propiedad_100_repeat___honorarios_comprador_moneda');
		foreach($honorarios_vendedor as $key => $honorario) {
			$this->honorariosBoletoVendedor[] = new Monto($honorario, $honorarios_vendedor_moneda[$key][0], $honorarios_vendedor_tc_referencia[$key]);
		}
		
		// Anticipos
		$this->anticipos = array();		
		$anticipos = $formModel->getElementData('gjr_venta_propiedad_89_repeat___anticipo');		
		$anticipos_moneda = $formModel->getElementData('gjr_venta_propiedad_89_repeat___anticipo_moneda');
		$anticipos_tc_referencia = $formModel->getElementData('gjr_venta_propiedad_89_repeat___tc_referencia');
		$anticipos_comprador= $formModel->getElementData('gjr_venta_propiedad_89_repeat___anticipo_honorarios_comprador');
		$anticipos_vendedor = $formModel->getElementData('gjr_venta_propiedad_89_repeat___anticipo_honorarios_vendedor');			
		foreach ($anticipos as $key => $anticipo) {
			$anticipoDescontado = $anticipo - $anticipos_comprador[$key] - $anticipos_vendedor[$key];
			$anticipoDescontado = new Monto($anticipoDescontado, $anticipos_moneda[$key][0], $anticipos_tc_referencia[$key]);
			$honorarios = $anticipos_comprador[$key] + $anticipos_vendedor[$key];
			$honorarios = new Monto($honorarios, $anticipos_moneda[$key][0], $anticipos_tc_referencia[$key]);	
			$anticipo = new Monto($anticipo, $anticipos_moneda[$key][0], $anticipos_tc_referencia[$key]);			
			$this->anticipos[] = array(
				'anticipoDescontado' => $anticipoDescontado,
				'honorarios' => $honorarios,
				'anticipo' => $anticipo
			);
		}
				
	}
	
	/*
	* onBeforeStore: Generación de Operación Relacionada y Cobranza
	*/
	public function onBeforeStore()
	{	
	
		$ejercicio = Operacion::getEjercicio($this->fecha_operacion);		
		$nombreInmueble = Cobranza::getNombreInmueble($this->inmueble_id[0]);
	
		if ( $this->forma_pago == 'Contado' ) {
			
			/******** 1) FORMA DE PAGO: CONTADO ********/
			/*******************************************/
			
			if ( $this->boleto != 1 ) {
				
				/******** 1.1) SOLO RESERVA ********/				
								
				//////////////////////////////////////////////////////////////////////////////////////////////////
				// Generación de Operación de Reserva								
				$operacion = Operacion::conDatos( array(
					'date_time'			=> $this->fecha_operacion,
					'fecha_operacion' 	=> $this->fecha_operacion,
					'ejercicio'			=> $ejercicio,		
					'descripcion' 		=> 'Reserva de Propiedad: '.$nombreInmueble,
					'tipo'				=> 'I',
					'concepto' 			=> 36, // 36: Anticipos Cobrados por Ventas
					'tabla_relacionada' => 'gjr_venta_propiedad',
					'relacion_id'		=> $this->id
				));
								
				foreach($this->reservas as $reserva) {
					$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
						'cuenta' => 1, // Caja
						'monto' => $reserva // Se pasa el objeto
					)));
					$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
						'cuenta' => 36, // 36: Anticipos Cobrados por Ventas
						'monto' => $reserva // Se pasa el objeto				
					)));
				}
				
				if ( $this->id == '' || intval($this->operacionRelacionada->reserva) == 0) {
					$this->operacionRelacionada->reserva = $operacion->crear();
					$this->formModel->updateFormData('gjr_venta_propiedad___operacion_reserva', $this->operacionRelacionada->reserva, true);					
				} else {
					$operacion->set('id', $this->operacionRelacionada->reserva);	
					$operacion->actualizar();		
				}
				
				// Generación de Cobranza
				Cobranza::eliminarCobranzaOperacion($operacion->id);
				foreach($this->reservas as $reserva) {
					$cobranza = Cobranza::conDatos(array(
						'date_time'			=> $operacion->date_time,
						'operacion'			=> $operacion->id,
						'operaciones_cobro'	=> '',
						'inmueble_id'		=> $this->inmueble_id[0],
						'cliente_id' 		=> $this->comprador[0],
						'descripcion' 		=> $operacion->descripcion,
						'monto' 			=> $reserva,
						'vencimiento'		=> $operacion->date_time,
						'estado'			=> 'Cobrado',
						'fecha_cobro'		=> $operacion->date_time
					));
					$cobranza->crear();
					$cobranza->cargarCobro(
						array(array( // Es un Array de array ya que pueden enviarse varios cobros
						'cuenta' 			=> 1, // Caja
						'cobro_monto'		=> $reserva,
						'cobro_honorarios'	=> 0 // La reserva no lleva honorarios
						)),
						false // La reserva no lleva honorarios
					);
				}
				//////////////////////////////////////////////////////////////////////////////////////////////////

			} else {			
				
				/******** 1.2) RESERVA + BOLETO ********/
								
				if ($this->inmobiliaria == 'Sí') {
				
					/******** 1.2.1) CONTADO NORMAL: Se reciben sólo los honorarios ********/
					
					//////////////////////////////////////////////////////////////////////////////////////////////////
					// Se revierte Reserva
					$operacion = Operacion::conDatos( array(
						'date_time'			=> $this->fecha_operacion,
						'fecha_operacion' 	=> $this->fecha_operacion,
						'ejercicio'			=> $ejercicio,		
						'descripcion' 		=> 'Devolución - Reserva de Propiedad: '.$nombreInmueble,
						'tipo'				=> 'I',
						'concepto' 			=> 36, // 36: Anticipos Cobrados por Ventas
						'tabla_relacionada' => 'gjr_venta_propiedad',
						'relacion_id'		=> $this->id
					));
										
					foreach($this->reservas as $reserva) {
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 36, // Anticipos Cobrados por Ventas
							'monto' => $reserva // Se pasa el objeto	
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // 1: Caja
							'monto' => $reserva // Se pasa el objeto		
						)));
					}
					
					if ( $this->id == '' || intval($this->operacionRelacionada->devolucion_reserva) == 0) {
						$this->operacionRelacionada->devolucion_reserva = $operacion->crear();
						$this->formModel->updateFormData('gjr_venta_propiedad___operacion_devolucion_reserva', $this->operacionRelacionada->devolucion_reserva, true);	
					} else {
						$operacion->set('id', $this->operacionRelacionada->devolucion_reserva);	
						$operacion->actualizar();		
					}
					
					Cobranza::eliminarCobranzaOperacion($operacion->id);
					//////////////////////////////////////////////////////////////////////////////////////////////////
					
					
					//////////////////////////////////////////////////////////////////////////////////////////////////
					// Generación de Operación Boleto					
					$operacion = Operacion::conDatos( array(
						'date_time'			=> $this->fecha_operacion,
						'fecha_operacion' 	=> $this->fecha_operacion,
						'ejercicio'			=> $ejercicio,		
						'descripcion' 		=> 'Honorarios Inmobiliarios por Venta de Propiedad: '.$nombreInmueble,
						'tipo'				=> 'I',
						'concepto' 			=> 18, // 18: Honorarios Inmobiliarios por Ventas de Propiedades
						'tabla_relacionada' => 'gjr_venta_propiedad',
						'relacion_id'		=> $this->id
					));					
					
					// Boleto Comprador y Vendedor
					foreach($this->honorariosBoletoComprador as $honorario) {
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // Caja
							'monto' => $honorario		
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
							'cuenta' => 18, // 18: Honorarios Inmobiliarios por Ventas de Propiedades
							'monto' => $honorario				
						)));						
					}
					foreach($this->honorariosBoletoVendedor as $honorario) {
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // Caja
							'monto' => $honorario		
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
							'cuenta' => 18, // 18: Honorarios Inmobiliarios por Ventas de Propiedades
							'monto' => $honorario				
						)));						
					}
					
					if ( $this->id == '' || intval($this->operacionRelacionada->boleto) == 0) {
						$this->operacionRelacionada->boleto = $operacion->crear();
						$this->formModel->updateFormData('gjr_venta_propiedad___operacion_boleto', $this->operacionRelacionada->boleto, true);	
					} else {
						$operacion->set('id', $this->operacionRelacionada->boleto);	
						$operacion->actualizar();		
					}
				
					// Generación de Cobranza Boleto Comprador y Vendedor
					Cobranza::eliminarCobranzaOperacion($operacion->id);
					foreach($this->honorariosBoletoComprador as $honorario) {						
						$cobranza = Cobranza::conDatos(array(
							'date_time'			=> $operacion->date_time,
							'operacion'			=> $operacion->id,
							'operaciones_cobro'	=> '',
							'inmueble_id'		=> $this->inmueble_id[0],
							'cliente_id' 		=> $this->comprador[0],
							'descripcion' 		=> $operacion->descripcion,
							'monto' 			=> $honorario,
							'vencimiento'		=> $operacion->date_time,
							'estado'			=> 'Cobrado',
							'fecha_cobro'		=> $operacion->date_time
						));
						$cobranza->crear();
						$cobranza->cargarCobro(
							array(array(
									'cuenta' 			=> 1, // Caja
									'cobro_monto'		=> $honorario,
									'cobro_honorarios'	=> 0 // La reserva no lleva honorarios
							)),
							false
						);												
					}					
					foreach($this->honorariosBoletoComprador as $honorario) {						
						$cobranza = Cobranza::conDatos(array(
							'date_time'			=> $operacion->date_time,
							'operacion'			=> $operacion->id,
							'operaciones_cobro'	=> '',
							'inmueble_id'		=> $this->inmueble_id[0],
							'cliente_id' 		=> $this->vendedor[0],
							'descripcion' 		=> $operacion->descripcion,
							'monto' 			=> $honorario,
							'vencimiento'		=> $operacion->date_time,
							'estado'			=> 'Cobrado',
							'fecha_cobro'		=> $operacion->date_time
						));
						$cobranza->crear();
						$cobranza->cargarCobro(
							array(array(
									'cuenta' 			=> 1, // Caja
									'cobro_monto'		=> $honorario,
									'cobro_honorarios'	=> 0 // La reserva no lleva honorarios
							)),
							false
						);													
					}	
					//////////////////////////////////////////////////////////////////////////////////////////////////
			
				} else {

					/******** 1.2.2) CONTADO DE EMPRENDIMIENTO: Se recibe el total del valor ********/
					/******************************************************************************/
					
					foreach($this->saldosBoleto as $saldo) {
					
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// Generación de Operación Saldos						
						$operacion = Operacion::conDatos( array(
							'date_time'			=> $this->fecha_operacion,
							'fecha_operacion' 	=> $this->fecha_operacion,
							'ejercicio'			=> $ejercicio,		
							'descripcion' 		=> 'Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
							'tipo'				=> 'I',
							'concepto' 			=> 39, // 39: Venta de Propiedad de Emprendimientos
							'tabla_relacionada' => 'gjr_venta_propiedad',
							'relacion_id'		=> $this->id
						));
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // Caja
							'monto' => $saldo['saldo']
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(
							'cuenta' => 39, // 39: Venta de Propiedades de Emprendimientos
							'monto' => $saldo['saldo']								
						)));						
						
						if ( $this->id == '' || intval($this->operacionRelacionada->boleto) == 0) {
							$this->operacionRelacionada->boleto = $operacion->crear();
							$this->formModel->updateFormData('gjr_venta_propiedad___operacion_boleto', $this->operacionRelacionada->boleto, true);	
						} else {
							$operacion->set('id', $this->operacionRelacionada->boleto);	
							$operacion->actualizar();		
						}
		
						Cobranza::eliminarCobranzaOperacion($operacion->id);
						//////////////////////////////////////////////////////////////////////////////////////////////////
						
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// Generación de Operación Honorarios - Egreso del Emprendimiento						
						$operacion = Operacion::conDatos( array(
							'date_time'			=> $this->fecha_operacion,
							'fecha_operacion' 	=> $this->fecha_operacion,
							'ejercicio'			=> $ejercicio,		
							'descripcion' 		=> 'Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
							'tipo'				=> 'I',
							'concepto' 			=> 39, // 39: Venta de Propiedad de Emprendimientos
							'tabla_relacionada' => 'gjr_venta_propiedad',
							'relacion_id'		=> $this->id							
						));
						
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 40, // 40: Honorarios Inmobiliarios de Emprendimientos
							'monto' => $saldo['honorarios']		
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // Caja
							'monto' => $saldo['honorarios']			
						)));						
						
						if ( $this->id == '' || intval($this->operacionRelacionada->honorarios->egreso_emprendimiento) == 0) {
							$this->operacionRelacionada->honorarios->egreso_emprendimiento = $operacion->crear();
							$this->formModel->updateFormData('gjr_venta_propiedad___operacion_honorarios_egreso_emprendimiento', $this->operacionRelacionada->honorarios->egreso_emprendimiento, true);	
						} else {
							$operacion->set('id', $this->operacionRelacionada->honorarios->egreso_emprendimiento);	
							$operacion->actualizar();		
						}
						
						Cobranza::eliminarCobranzaOperacion($operacion->id);
						//////////////////////////////////////////////////////////////////////////////////////////////////
						
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// Generación de Operación Honorarios - Ingreso Inmobiliaria del Emprendimiento						
						$operacion = Operacion::conDatos( array(
							'date_time'			=> $this->fecha_operacion,
							'fecha_operacion' 	=> $this->fecha_operacion,
							'ejercicio'			=> $ejercicio,		
							'descripcion' 		=> 'Honorarios por Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
							'tipo'				=> 'I',
							'concepto' 			=> 37, // 37: Honorarios Inmobiliarios por Emprendimientos
							'tabla_relacionada' => 'gjr_venta_propiedad',
							'relacion_id'		=> $this->id
						));
						$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
							'cuenta' => 1, // Caja
						'monto' => $saldo['honorarios']	
						)));
						$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
							'cuenta' => 37, // 37: Honorarios Inmobiliarios por Emprendimientos
							'monto' => $saldo['honorarios']		
						)));
						
						if ( $this->id == '' || intval($this->operacionRelacionada->honorarios->ingreso_inmobiliaria) == 0) {
							$this->operacionRelacionada->honorarios->ingreso_inmobiliaria = $operacion->crear();
							$this->formModel->updateFormData('gjr_venta_propiedad___operacion_honorarios_ingreso_inmobiliaria', $this->operacionRelacionada->honorarios->ingreso_inmobiliaria, true);	
						} else {
							$operacion->set('id', $this->operacionRelacionada->honorarios->ingreso_inmobiliaria);	
							$operacion->actualizar();		
						}
								
						Cobranza::eliminarCobranzaOperacion($operacion->id);
						//////////////////////////////////////////////////////////////////////////////////////////////////
						
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// Generación de Cobranza Saldo
						$cobranza = Cobranza::conDatos(array(
							'date_time'			=> $operacion->date_time,
							'operacion'			=> $operacion->id,
							'operaciones_cobro'	=> '',
							'inmueble_id'		=> $this->inmueble_id[0],
							'cliente_id' 		=> $this->comprador[0],
							'descripcion' 		=> $operacion->descripcion . ' - Saldo',
							'monto' 			=> $saldo,
							'vencimiento'		=> $operacion->date_time,
							'estado'			=> 'Cobrado',
							'fecha_cobro'		=> $operacion->date_time
						));
						$cobranza->crear();
						$cobranza->cargarCobro(
							array(array(
									'cuenta' 			=> 1, // Caja
									'cobro_monto'		=> $saldo['saldo'],
									'cobro_honorarios'	=> 0
							)),
							false // Ya se cargaron los honorarios
						);
						//////////////////////////////////////////////////////////////////////////////////////////////////
			
					}
				}
			}	

		} else {

			/******** 2) FORMA DE PAGO: FINANCIADO ********/
			/**********************************************/

			//////////////////////////////////////////////////////////////////////////////////////////////////
			// Generación de Operaciones Anticipos y Honorarios
			$operacionAnticipo = Operacion::conDatos( array(
				'date_time'			=> $this->fecha_operacion,
				'fecha_operacion' 	=> $this->fecha_operacion,
				'ejercicio'			=> $ejercicio,		
				'descripcion' 		=> 'Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
				'tipo'				=> 'I',
				'concepto' 			=> 22, // 22: Anticipos Cobrados por Emprendimientos
				'tabla_relacionada' => 'gjr_venta_propiedad',
				'relacion_id'		=> $this->id
			));
			$operacionHonorarios1 = Operacion::conDatos( array(
				'date_time'			=> $this->fecha_operacion,
				'fecha_operacion' 	=> $this->fecha_operacion,
				'ejercicio'			=> $ejercicio,		
				'descripcion' 		=> 'Honorarios por Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
				'tipo'				=> 'E',
				'concepto' 			=> 40, // 40: Honorarios Inmobiliarios de Emprendimientos
				'tabla_relacionada' => 'gjr_venta_propiedad',
				'relacion_id'		=> $this->id
			));
			$operacionHonorarios2 = Operacion::conDatos( array(
				'date_time'			=> $this->fecha_operacion,
				'fecha_operacion' 	=> $this->fecha_operacion,
				'ejercicio'			=> $ejercicio,		
				'descripcion' 		=> 'Honorarios por Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
				'tipo'				=> 'I',
				'concepto' 			=> 37, // 37: Honorarios Inmobiliarios por Emprendimientos
				'tabla_relacionada' => 'gjr_venta_propiedad',
				'relacion_id'		=> $this->id
			));
			
			foreach($this->anticipos as $anticipo) {
				$operacionAnticipo->crearAsiento('entrada',  AsientoContable::conDatos(array(				
					'cuenta' => 1, // Caja
					'monto' => $anticipo['anticipo']	
				)));
				$operacionAnticipo->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => 22, // 22: Anticipos Cobrados por Emprendimientos
					'monto' => $anticipo['anticipo']					
				)));
				$operacionHonorarios1->crearAsiento('entrada',  AsientoContable::conDatos(array(				
					'cuenta' => 40, // 40: Honorarios Inmobiliarios de Emprendimientos
					'monto' => $anticipo['honorarios']		
				)));
				$operacionHonorarios1->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => 1, // Caja
					'monto' => $anticipo['honorarios']		
				)));
				$operacionHonorarios2->crearAsiento('entrada',  AsientoContable::conDatos(array(				
					'cuenta' => 1, // Caja
					'monto' => $anticipo['honorarios']								
				)));
				$operacionHonorarios2->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => 37, // 37: Honorarios Inmobiliarios por Emprendimientos
					'monto' => $anticipo['honorarios']
				)));
			}
			
			if ( $this->id == '' || intval($this->operacionRelacionada->anticipo) == 0) {
				$this->operacionRelacionada->anticipo = $operacionAnticipo->crear();
				$this->formModel->updateFormData('gjr_venta_propiedad___operacion_anticipo', $this->operacionRelacionada->anticipo, true);	
			} else {
				$operacionAnticipo->set('id', $this->operacionRelacionada->anticipo);	
				$operacionAnticipo->actualizar();		
			}
			
			if ( $this->id == '' || intval($this->operacionRelacionada->honorarios->egreso_emprendimiento) == 0) {
				$this->operacionRelacionada->honorarios->egreso_emprendimiento = $operacionHonorarios1->crear();
				$this->formModel->updateFormData('gjr_venta_propiedad___operacion_honorarios_egreso_emprendimiento', $this->operacionRelacionada->honorarios->egreso_emprendimiento, true);	
			} else {
				$operacionHonorarios1->set('id', $this->operacionRelacionada->honorarios->egreso_emprendimiento);	
				$operacionHonorarios1->actualizar();		
			}
			
			if ( $this->id == '' || intval($this->operacionRelacionada->honorarios->ingreso_inmobiliaria) == 0) {
				$this->operacionRelacionada->honorarios->ingreso_inmobiliaria = $operacionHonorarios2->crear();
				$this->formModel->updateFormData('gjr_venta_propiedad___operacion_honorarios_ingreso_inmobiliaria', $this->operacionRelacionada->honorarios->ingreso_inmobiliaria, true);	
			} else {
				$operacionHonorarios2->set('id', $this->operacionRelacionada->honorarios->ingreso_inmobiliaria);	
				$operacionHonorarios2->actualizar();		
			}
				
			Cobranza::eliminarCobranzaOperacion($operacionAnticipo->id);
			Cobranza::eliminarCobranzaOperacion($operacionHonorarios1->id);
			Cobranza::eliminarCobranzaOperacion($operacionHonorarios2->id);
			
			foreach($this->anticipos as $anticipo) {
														
				// Generación de Cobranza Anticipo
				$cobranza = Cobranza::conDatos(array(
					'date_time'			=> $operacionAnticipo->date_time,
					'operacion'			=> $operacionAnticipo->id,
					'operaciones_cobro'	=> '',
					'inmueble_id'		=> $this->inmueble_id[0],
					'cliente_id' 		=> $this->comprador[0],
					'descripcion' 		=> $operacionAnticipo->descripcion . ' - Anticipo',
					'monto' 			=> $anticipo['anticipo'],
					'vencimiento'		=> $operacionAnticipo->date_time,
					'estado'			=> 'Cobrado',
					'fecha_cobro'		=> $operacionAnticipo->date_time
				));
				$cobranza->crear();
				$cobranza->cargarCobro(
					array(
						array(
							'cuenta' 			=> 1, // Caja
							'cobro_monto'		=> $anticipo['anticipo'],
							'cobro_honorarios'	=> 0 // Ya se cobraron
						)
					),
					false // Ya se cobraron
				);
							
			}			
			//////////////////////////////////////////////////////////////////////////////////////////////////
			
						
			/******** 2.2) CUOTAS ********/
			/******************************/			
						
			// Generación de Cobranza Cuotas
			$fechaCuota = $this->primerVencimiento;
			$financiacionCuotas = array();
			foreach($this->cuotasTipo as $key => $tipoCuota) {	
				
				switch($tipoCuota[0]) {
				
					case 'Normal':
					case 'Especial':
						for($i = 1; $i<=$this->cuotasCant[$key] ; $i++) {
							$monto = new Monto($this->cuotasValor[$key], $this->cuotasMoneda[$key][0], $this->cuotasTCRef[$key][0]);							
							$cobranza = Cobranza::conDatos(array(
								'date_time'			=> $operacionAnticipo->date_time,
								'operacion'			=> $operacionAnticipo->id,								
								'inmueble_id'		=> $this->inmueble_id[0],
								'cliente_id' 		=> $this->comprador[0],
								'descripcion' 		=> $operacionAnticipo->descripcion . ' - ' . $tipoCuota[0] . ' - ' . "Cuota {$i} de {$this->cuotasCant[$key]}",
								'monto' 			=> $monto,
								'vencimiento'		=> $fechaCuota,
								'estado'			=> 'Pendiente',
								'fecha_cobro'		=> 'NULL'
							));							
							$cobranza->crear();							
							$financiacionCuotas[$this->cuotasMoneda[$key][0]]['monto'] += $this->cuotasValor[$key];							
							$financiacionCuotas[$this->cuotasMoneda[$key][0]]['tc'] = $this->cuotasTCRef[$key][0];
							$fechaCuota = date( "Y-m-d", strtotime( $fechaCuota . ' +' . $this->cuotasFrecuencia[$key][0] . ' day' ) );							
							
						}
						break;
						
					case 'Vencimiento':
						$monto = new Monto($this->cuotasValor[$key], $this->cuotasMoneda[$key][0], $this->cuotasTCRef[$key][0]);
						$cobranza = Cobranza::conDatos(array(
							'date_time'			=> $operacionAnticipo->date_time,
							'operacion'			=> $operacionAnticipo->id,								
							'inmueble_id'		=> $this->inmueble_id[0],
							'cliente_id' 		=> $this->comprador[0],
							'descripcion' 		=> $operacionAnticipo->descripcion . ' - ' . $tipoCuota[0],
							'monto' 			=> $monto,
							'vencimiento'		=> $fechaCuota,
							'estado'			=> 'Pendiente',
							'fecha_cobro'		=> 'NULL'
						));
						$cobranza->crear();											
						$financiacionCuotas[$this->cuotasMoneda[$key][0]]['monto'] += $this->cuotasValor[$key];
						$financiacionCuotas[$this->cuotasMoneda[$key][0]]['tc'] = $this->cuotasTCRef[$key][0];
						break;
				
				}				
			}
			
			foreach ($financiacionCuotas as $key => $valor) {
			
				$totalPorMoneda = new Monto($valor['monto'], $key, $valor['tc']);
				
				//////////////////////////////////////////////////////////////////////////////////////////////////
				// Generación de Operación Honorarios - Ingreso Inmobiliaria del Emprendimiento				
				$operacion = Operacion::conDatos( array(
					'date_time'			=> $this->fecha_operacion,
					'fecha_operacion' 	=> $this->fecha_operacion,
					'ejercicio'			=> $ejercicio,		
					'descripcion' 		=> 'Financiación por Venta de Propiedad de Emprendimiento: '.$nombreInmueble,
					'tipo'				=> 'I',
					'concepto' 			=> 38, // 38: Financiación de Propiedades
					'tabla_relacionada' => 'gjr_venta_propiedad',
					'relacion_id'		=> $this->id
				));
				$operacion->crearAsiento('entrada',  AsientoContable::conDatos(array(				
					'cuenta' => 3, // Cuentas por Cobrar
					'monto' => $totalPorMoneda
				)));
				$operacion->crearAsiento('salida',  AsientoContable::conDatos(array(				
					'cuenta' => 38, // 38: Financiación de Propiedades
					'monto' => $totalPorMoneda
				)));
				
				if ( $this->id == '' || intval($this->operacionRelacionada->financiacion) == 0) {										
					$this->operacionRelacionada->financiacion = $operacion->crear();										
					$this->formModel->updateFormData('gjr_venta_propiedad___operacion_financiacion', $this->operacionRelacionada->financiacion, true);	
				} else {					
					$operacion->set('id', $this->operacionRelacionada->financiacion);	
					$operacion->actualizar();		
				}				
				
			}
		
		}
	}
	
	public function onAfterProcess()
	{
		$this->actualizarInmueble();
		$this->corregirOperaciones();
		
		if (isset($this->operacionRelacionada->reserva) && $this->operacionRelacionada->reserva != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->reserva, $this->id);
			
		if (isset($this->operacionRelacionada->devolucion_reserva) && $this->operacionRelacionada->devolucion_reserva != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->devolucion_reserva, $this->id);	
		
		if (isset($this->operacionRelacionada->boleto) && $this->operacionRelacionada->boleto != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->boleto, $this->id);	
		
		if (isset($this->operacionRelacionada->anticipo) && $this->operacionRelacionada->anticipo != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->anticipo, $this->id);	

		if (isset($this->operacionRelacionada->honorarios->egreso_emprendimiento) && $this->operacionRelacionada->honorarios->egreso_emprendimiento != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->honorarios->egreso_emprendimiento, $this->id);
		
		if (isset($this->operacionRelacionada->honorarios->ingreso_inmobiliaria) && $this->operacionRelacionada->honorarios->ingreso_inmobiliaria != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->honorarios->ingreso_inmobiliaria, $this->id);
		
		if (isset($this->operacionRelacionada->financiacion) && $this->operacionRelacionada->financiacion != 0)
			Operacion::asociarRelacion($this->operacionRelacionada->financiacion, $this->id);
	}
	
	/*
	* Actualización de estado de inmueble
	*/
	private function actualizarInmueble()
	{
		// UPDATE DE INMUEBLE
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		if ( $this->forma_pago == 'Contado' && !$this->boleto )
			$fields = array('estado='.$db->quote('Reservada'));
		else
			$fields = array('estado='.$db->quote('Vendida'));	

		$conditions = array('id='.$this->inmueble_id[0]);
		$query->update($db->quoteName('gjr_inmueble'))->set($fields)->where($conditions);

		$db->setQuery($query); 
		try {
			$result = $db->query();
		} catch (Exception $e) {
			$this->setError($e);
		}
		//echo $query;
	}
	
	/*
	* Corrección de Operaciones (para mantener integridad en caso de que se cambie la forma de pago con datos existentes)	
	*/
	private function corregirOperaciones()
	{	
		if ($this->forma_pago[0] == 'Financiado' && (intval($this->operacionRelacionada->reserva) || intval($this->operacionRelacionada->devolucion_reserva) || intval($this->operacionRelacionada->boleto))) {			
			Operacion::eliminar($this->operacionRelacionada->reserva);
			$this->formModel->updateFormData('gjr_venta_propiedad___operacion_reserva', 0, true);	
			Operacion::eliminar($this->operacionRelacionada->devolucion_reserva);
			$this->formModel->updateFormData('gjr_venta_propiedad___operacion_devolucion_reserva', 0, true);	
			Operacion::eliminar($this->operacionRelacionada->boleto);
			$this->formModel->updateFormData('gjr_venta_propiedad___operacion_boleto', 0, true);	
		}
		
		if ($this->forma_pago == 'Contado' && (intval($this->operacionRelacionada->anticipo) || intval($this->operacionRelacionada->financiacion))) {
			Operacion::eliminar($this->operacionRelacionada->anticipo);			
			$this->formModel->updateFormData('gjr_venta_propiedad___operacion_anticipo', 0, true);	
		}
		
	}
}