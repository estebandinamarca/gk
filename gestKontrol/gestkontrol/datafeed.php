<?php
require_once ('src/classes/controlUsuario.class.php');
session_start();
if(!isset($_SESSION["usuario_gk"]))  header("Location: login.php");
	$ret = array();
	$ret['events'] = array();
	$ret["issort"] =true;
	$ret["start"] = php2JsTime($et);
	$ret["end"] = php2JsTime($ed);
	$ret['error'] = null;
				//echo $fecha->format('d/m/y H:i')
						$reserva->getidReserva(),
						$visita->getnombre()." ".$visita->getapellido()." * "." Reserva: ".$tipoReserva.$estac,
						php2JsTime($phpTimeI),
						php2JsTime($phpTimeS),
						0,
						0, //more than one day event
						0,//Recurring event
						$color, //5 azul, 1 rojo
						1, //editable
						"S/N",
						''//$attends
				);
	return $ret;
}
	  			$bandera = false;
	  		controlVisita::editaVisita($dataV);
	  		$dataR = array($idc,null,$idv,$st,$et,$tipoReserva,$tipoFrecuencia,$pisos,$oficina,$esta,$estadoValidación,null,$idv,$patente);
    	$ret = listCalendar($_POST["showdate"], $_POST["viewtype"],$usuario->getPrivilegio(),$usuario->getidCliente());