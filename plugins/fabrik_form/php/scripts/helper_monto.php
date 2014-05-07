<?php
/**
 * Proyecto: Sistema de Gestión para Juan Rodriguez
 * Autor: http://www.webthought.co
 * Fecha: 12/2013 
 */
defined('_JEXEC') or die();

class Monto
{
	public $monto;
	public $moneda;
	public $tc;
	public $simbolos;
	
	public function __construct($monto = NULL, $moneda = NULL, $tc = NULL)
	{
		$this->simbolos = array(
			7 => 'AR$',
			47 => '€',
			128 => 'R$',
			144 => 'US$',
		);
		$this->codigos = array(
			7 => 'ARS',
			47 => 'EUR',
			128 => 'BRL',
			144 => 'USD',
		);
		$this->nombres = array(
			7 => array( 'singular' => 'Peso', 'plural' => 'Pesos'),
			47 => array( 'singular' => 'Euro', 'plural' => 'Euros'),
			128 => array( 'singular' => 'Real', 'plural' => 'Reales'),
			144 => array( 'singular' => 'Dólar', 'plural' => 'Dólares'),
		);
		
		if (!is_numeric($moneda)) {
			$id = array_search($moneda, $this->codigos);
			if ($id) $this->moneda = $id;
			
			$id = array_search($moneda, $this->simbolos);
			if ($id) $this->moneda = $id;			
			
		} else
			$this->moneda = $moneda;			
			
		$this->monto = $monto;		
		$this->tc = $tc;		
		return;		
	}
	
	public function __toString()
	{		
		return $this->simbolo($this->moneda) . ' '. number_format($this->monto, 2, ',', '.');
	}
	
	//------    CONVERTIR NUMEROS A LETRAS         ---------------
	//------    Máxima cifra soportada: 18 dígitos con 2 decimales
	//------    999,999,999,999,999,999.99	
	function enLetras()
	{
		$xarray = array(0 => "Cero",
			1 => "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve",
			"diez", "once", "doce", "trece", "catorce", "quince", "dieciseis", "diecisiete", "dieciocho", "diecinueve",
			"veinti", 30 => "treinta", 40 => "cuarenta", 50 => "cincuenta", 60 => "sesenta", 70 => "setenta", 80 => "ochenta", 90 => "noventa",
			100 => "cien", 200 => "doscientos", 300 => "trescientos", 400 => "cuatrocientos", 500 => "quinientos", 600 => "seiscientos", 700 => "setecientos", 800 => "ochocientos", 900 => "novecientos"
		);
	
		$xcifra = trim($this->monto);
		$xlength = strlen($xcifra);
		$xpos_punto = strpos($xcifra, ".");
		$xaux_int = $xcifra;
		$xdecimales = "00";
		if (!($xpos_punto === false)) {
			if ($xpos_punto == 0) {
				$xcifra = "0" . $xcifra;
				$xpos_punto = strpos($xcifra, ".");
			}
			$xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
			$xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
		}

		$XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
		$moneda = $this->nombre($this->moneda, 'plural');
		$xcadena = "$moneda ";
		for ($xz = 0; $xz < 3; $xz++) {
			$xaux = substr($XAUX, $xz * 6, 6);
			$xi = 0;
			$xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
			$xexit = true; // bandera para controlar el ciclo del While
			while ($xexit) {
				if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
					break; // termina el ciclo
				}

				$x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
				$xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
				for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
					switch ($xy) {
						case 1: // checa las centenas
							if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
								
							} else {
								$key = (int) substr($xaux, 0, 3);
								if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
									$xseek = $xarray[$key];
									$xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
									if (substr($xaux, 0, 3) == 100)
										$xcadena = " " . $xcadena . " cien " . $xsub;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
									$xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
								}
								else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
									$key = (int) substr($xaux, 0, 1) * 100;
									$xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
									$xcadena = " " . $xcadena . " " . $xseek;
								} // ENDIF ($xseek)
							} // ENDIF (substr($xaux, 0, 3) < 100)
							break;
						case 2: // checa las decenas (con la misma lógica que las centenas)
							if (substr($xaux, 1, 2) < 10) {
								
							} else {
								$key = (int) substr($xaux, 1, 2);
								if (TRUE === array_key_exists($key, $xarray)) {
									$xseek = $xarray[$key];
									$xsub = $this->subfijo($xaux);
									if (substr($xaux, 1, 2) == 20)
										$xcadena = " " . $xcadena . " veinte " . $xsub;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
									$xy = 3;
								}
								else {
									$key = (int) substr($xaux, 1, 1) * 10;
									$xseek = $xarray[$key];
									if (20 == substr($xaux, 1, 1) * 10)
										$xcadena = " " . $xcadena . " " . $xseek;
									else
										$xcadena = " " . $xcadena . " " . $xseek . " Y ";
								} // ENDIF ($xseek)
							} // ENDIF (substr($xaux, 1, 2) < 10)
							break;
						case 3: // checa las unidades
							if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
								
							} else {
								$key = (int) substr($xaux, 2, 1);
								$xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
								$xsub = $this->subfijo($xaux);
								$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
							} // ENDIF (substr($xaux, 2, 1) < 1)
							break;
					} // END SWITCH
				} // END FOR
				$xi = $xi + 3;
			} // ENDDO

			if (substr(trim($xcadena), -5, 5) == "illón") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
				$xcadena.= " de";

			if (substr(trim($xcadena), -7, 7) == "illones") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
				$xcadena.= " de";

			// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
			if (trim($xaux) != "") {				
				switch ($xz) {
					case 0:
						if (trim(substr($XAUX, $xz * 6, 6)) == "1")
							$xcadena.= "un billón ";
						else
							$xcadena.= " billones ";
						break;
					case 1:
						if (trim(substr($XAUX, $xz * 6, 6)) == "1")
							$xcadena.= "un millón ";
						else
							$xcadena.= " millones ";
						break;
					case 2:
						if ($xcifra < 1) {							
							$xcadena = "cero con $xdecimales/100";
						}
						if ($xcifra >= 1 && $xcifra < 2) {							
							$xcadena = "un con $xdecimales/100";
						}
						if ($xcifra >= 2) {							
							$xcadena.= " con $xdecimales/100 "; //
						}
						break;
				} // endswitch ($xz)
			} // ENDIF (trim($xaux) != "")
			// ------------------      en este caso, para México se usa esta leyenda     ----------------
			$xcadena = str_replace("veinti ", "veinti", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
			$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
			$xcadena = str_replace("un un", "un", $xcadena); // quito la duplicidad
			$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
			$xcadena = str_replace("billón de millones", "billon de", $xcadena); // corrigo la leyenda
			$xcadena = str_replace("billones de millones", "billones de", $xcadena); // corrigo la leyenda
			$xcadena = str_replace("de un", "un", $xcadena); // corrigo la leyenda
		} // ENDFOR ($xz)
		return trim($xcadena);
	}
	
	/*
	* Esta función regresa un subfijo para la cifra
	*/
	function subfijo($xx)
	{ 	
		$xx = trim($xx);
		$xstrlen = strlen($xx);
		if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
			$xsub = "";
		
		if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
			$xsub = "mil";
		
		return $xsub;
	}

	
	public function set($param, $valor)
	{
		$this->$param = $valor;
		return;
	}
	
	public function simbolo($moneda_id)
	{	
		return $this->simbolos[$moneda_id];
	}
	
	public function nombre($moneda_id, $tipo)
	{		
		return $this->nombres[$moneda_id][$tipo];
	}
	
	public function sumar()
	{
		$montos = func_get_args();		
		$moneda = $montos[0]->moneda;
		$suma = 0;
		foreach ($montos as $monto) {			
			if (get_class($monto) != 'Monto')
				return FALSE;
				
			if ($monto->moneda != $moneda)
				return FALSE;
			
			// Está todo OK, entonces puedo sumar
			$suma += $monto->monto;
			
			$moneda = $monto->moneda; // Para próxima verificación
		}
		
		return new Monto($suma, $moneda);
	}
}
?>