<?php
if(!defined('PATH_SOURCE_CLASSES')) define('PATH_SOURCE_CLASSES','src/classes/');
if(!defined('PATH_SOURCE_CORE')) define('PATH_SOURCE_CORE','src/core/');
if(!defined('PATH_SOURCE_CSS')) define('PATH_SOURCE_CSS','src/css/');
if(!defined('PATH_SOURCE_IMAGES')) define('PATH_SOURCE_IMAGES','src/img/');
if(!defined('PATH_SOURCE_JS')) define('PATH_SOURCE_JS','src/js/');
if(!defined('PATH_SOURCE_LIB')) define('PATH_SOURCE_LIB','src/lib/');
if(!defined('PATH_SOURCE_MODULES')) define('PATH_SOURCE_MODULES','src/modulos/');
if(!defined('PATH_ABSOLUTE')) define('PATH_ABSOLUTE',dirname(__FILE__).DIRECTORY_SEPARATOR);

require_once(PATH_SOURCE_CORE.'conf.class.php');
require_once(PATH_SOURCE_CORE.'conexionMySQLi.class.php');
require_once(PATH_SOURCE_CLASSES."fechaHora.php");
/*
 add
get
del
list
*/
class reporteControl{
	
	public function getReporte($data){
		
		$sql = conexionMySQLi::getInstance();

		$query = reporteControl::getQueryProcesed($data);

		if(count($query) > 1){
			$query_args = $query[1];
			$query = $query[0];
		}else{
			return null;
		}
		
		$query = "COUNT(1) FROM reservaHistory, tarjetaHistory, clienteHistory WHERE clienteHistory.idClienteHistory = tarjetaHistory.idClienteHistory AND reservaHistory.idCliente = tarjetaHistory.idTarjeta".$query;
		
		$group = "Sin Agrupamiento";
		
		if(isset($data["group"]) && $data["group"]!= null && $data["group"] != "undefined"){
			//$query = "SELECT ".$campo.",".$query;
			switch ($data["group"]){
				case "piso":
					$query = "SELECT piso,".$query;
				break;
				case "empresa":
					$query = "SELECT clienteHistory.nombre,".$query;
				break;
				case "horas":
					$query = "SELECT HOUR(fechaEntrada),".$query;
				break;
				case "dias":
					$query = "SELECT DATE(fechaEntrada),".$query;
				break;
			}
			$group = "Datos Agrupados por ".$data["group"];
		}else
			$query = "SELECT ".$query;
		
		
		//print_r($query);
		//print_r($query_args);
		//die;

		$res = $sql->devDatos($query,$query_args);
			
		if($group == "Sin Agrupamiento"){
			$res->bind_result($count);
			
			$return = array();
			
			while($res ->fetch())
			{
				//return array();
				$return[] = $count;
			}
				
		}else{
			$res->bind_result($dato, $count);
		
			$return = array();

			while($res ->fetch())
			{
				//return array();
				$return[] = array($dato,$count);
			}
		
		}
		return array(
					"fechaHora"=>fechaHora::getNowI(),
					"group"=>$group,
					"data"=>$return
				);
	}


	public function getTabla($data){
		$return = array();
		$sql = conexionMySQLi::getInstance();
		
		if(!isset($data["order"])){ 
			$data["order"] = "idReserva";
			$data["or"] = "a";
		}
		
		$query = reporteControl::getQueryProcesed($data);
		
		if(count($query) > 1){
			$query_args = $query[1];
			$query = $query[0];
		}else{
			return null;
		}
		   
		$query = "SELECT idReserva, idCliente, idOperador, idVisita, fechaEntrada, fechaSalida, tipoReserva, tipoFrecuencia, piso, oficina, estacionamientoAsignado, estadoValidacion, momentoValidacion, codigoReserva, tarjetaHistory.nombres, clienteHistory.nombre FROM reservaHistory, tarjetaHistory, clienteHistory WHERE clienteHistory.idClienteHistory = tarjetaHistory.idClienteHistory AND reservaHistory.idCliente = tarjetaHistory.idTarjeta".$query;
		
		
		//print_r($query);
		//print_r($query_args);
		//die;
		//INSERT IGNORE INTO clienteHistory(idClienteHistory,rutp,dvp,nombre,direccion) SELECT (idCliente+2000),rutp,dvp,nombreEmpresa,direccion FROM cliente;
		//NUEVA QUERY DE INSERCION: INSERT INTO tarjetaHistory(idTarjeta,nombres,idClienteHistory) SELECT (visita.idVisita+100000), CONCAT(nombre,' ',apellido),(cliente.idCliente+2000) FROM visita,`detalleVisita`,cliente WHERE visita.idVisita = detalleVisita.idVisita AND detalleVisita.idCliente = cliente.idCliente
		//INSERT INTO reservaHistory (idCliente, idOperador, idVisita, fechaEntrada, fechaSalida, tipoReserva, tipoFrecuencia, piso, oficina, estacionamientoAsignado, estadoValidacion, momentoValidacion, codigoReserva) SELECT idCliente, idOperador, idVisita, fechaEntrada, fechaSalida, tipoReserva, tipoFrecuencia, piso, oficina, estacionamientoAsignado, estadoValidacion, momentoValidacion, codigoReserva FROM reserva 
		$fichas = array();			
		
		$res = $sql->devDatos($query,$query_args);
		$res->bind_result($idReserva, $idCliente, $idOperador, $idVisita, $fechaEntrada, $fechaSalida, $tipoReserva, $tipoFrecuencia, $piso, $oficina, $estacionamientoAsignado, $estadoValidacion, $momentoValidacion, $codigoReserva, $nombres, $empresa);

		while($res->fetch())
		{
			//return array();
			$fichas[] = array("idReserva"=>$idReserva, "idCliente"=>$idCliente, "idOperador"=>$idOperador, "idVisita"=>$idVisita, "fechaEntrada"=>$fechaEntrada, "fechaSalida"=>$fechaSalida, "tipoReserva"=>$tipoReserva, "tipoFrecuencia"=>$tipoFrecuencia, "piso"=>$piso, "oficina"=>$oficina, "estacionamientoAsignado"=>$estacionamientoAsignado, "estadoValidacion"=>$estadoValidacion, "momentoValidacion"=>$momentoValidacion, "codigoReserva"=>$codigoReserva, "nombres"=>$nombres, "empresa"=>$empresa);

		}
		
		return $fichas;
	}

	public function getRequest($data){
		$return = array();
		
		if (isset($data["registro"]) && $data["registro"] != null && $data["registro"] != "undefined" && $data["registro"] != "todos") $return["registro"]=$data["registro"];
		if (isset($data["piso"]) && $data["piso"] != null && $data["piso"] != "undefined" && $data["piso"] != "todos") $return["piso"]=$data["piso"];
		if (isset($data["empresa"]) && $data["empresa"] != null && $data["empresa"] != "undefined" && $data["empresa"] != "todos") $return["empresa"]=$data["empresa"];
		if (isset($data["horario"]) && $data["horario"] != null && $data["horario"] != "undefined" && $data["horario"] != "todos") $return["horario"]=$data["horario"];
		if (isset($data["horarioi"]) && $data["horarioi"] != null && $data["horarioi"] != "undefined") $return["horarioi"]=$data["horarioi"];
		if (isset($data["horariot"]) && $data["horariot"] != null && $data["horariot"] != "undefined") $return["horariot"]=$data["horariot"];
		if (isset($data["periodo"]) && $data["periodo"] != null && $data["periodo"] != "undefined" && $data["periodo"] != "todos") $return["periodo"]=$data["periodo"];
		if (isset($data["fechai"]) && $data["fechai"] != null && $data["fechai"] != "undefined") $return["fechai"]=$data["fechai"];
		if (isset($data["fechat"]) && $data["fechat"] != null && $data["fechat"] != "undefined") $return["fechat"]=$data["fechat"];
		if (isset($data["fesp"]) && $data["fesp"] != null && $data["fesp"] != "undefined") $return["fesp"]=$data["fesp"];
		if (isset($data["result"]) && $data["result"] != null && $data["result"] != "undefined") $return["result"]=$data["result"];
		if (isset($data["group"]) && $data["group"] != null && $data["group"] != "undefined") $return["group"]=$data["group"];
		if (isset($data["order"]) && $data["order"] != null && $data["order"] != "undefined"){ 
			$return["order"]=$data["order"];
			if (isset($data["or"]) && $data["or"] != null && $data["or"] != "undefined")
				$return["or"]=$data["or"];
			else $return["or"]="a";
		}
		
		return $return;
	}
	
	public function getQueryProcesed($data){
		
		$query = "";
		$query_args = array();
		
		
		if (isset($data["registro"]) && $data["registro"]!="undefined"){
			$query .= " AND estadoValidacion = ?"; $query_args[] =  $data["registro"];
		}
		if (isset($data["piso"]) && $data["piso"]!="undefined"){
			$query .= " AND piso = ?"; $query_args[] =  $data["piso"];
		}
		if (isset($data["empresa"]) && $data["empresa"]!="undefined"){
			$query .= " AND clienteHistory.idClienteHistory = ? "; 
			$query_args[] =  $data["empresa"];
		}
		
		if (isset($data["horario"]) && $data["horario"]!="undefined"){
			
			switch($data["horario"]){
				case "dia":
					$query .= " AND HOUR(fechaEntrada) >= 9 AND HOUR(fechaEntrada) < 19";
				break;
				case "noche":
					$query .= " AND (HOUR(fechaEntrada) >= 19 OR HOUR(fechaEntrada) < 9)";
				break;
				case "interval":
					if (isset($data["horarioi"])){
						$query .= " AND HOUR(fechaEntrada) >= ?"; $query_args[] =  $data["horarioi"];
					}
					if (isset($data["horariot"])){
						$query .= " AND HOUR(fechaEntrada) <= ?"; $query_args[] =  $data["horariot"];
					}
				break;
			}
				
		}
		
		if (isset($data["periodo"]) && $data["periodo"]!="undefined"){
			
			switch($data["periodo"]){
				case "dia":
					$query .= " AND fechaEntrada >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
				break;
				case "semana":
					$query .= " AND fechaEntrada >= DATE_SUB(NOW(),INTERVAL 7 DAY)";
				break;
				case "mes":
					$query .= " AND fechaEntrada >= DATE_SUB(NOW(),INTERVAL 31 DAY)";
				break;
				case "anual":
					$query .= " AND fechaEntrada >= DATE_SUB(NOW(),INTERVAL 1 YEAR)";
				break;
				case "interval":
					if (isset($data["fechai"])){
						$query .= " AND fechaEntrada >= STR_TO_DATE(?,'%Y-%m-%d')"; $query_args[] =  $data["fechai"];
					}
					if (isset($data["fechat"])){
						$query .= " AND fechaEntrada <= STR_TO_DATE(?,'%Y-%m-%d')"; $query_args[] =  $data["fechat"];
					}
				break;
				case "day":
					if (isset($data["fesp"])){
						$query .= " AND fechaEntrada >= STR_TO_DATE(?,'%Y-%m-%d %H:%i:%s') AND fechaEntrada <= STR_TO_DATE(?,'%Y-%m-%d %H:%i:%s')"; 
						$query_args[]=$data["fesp"].' 00:00:00';
						$query_args[]=$data["fesp"].' 23:59:59';
					}
				break;
			}
		}

		if(isset($data["group"]) && $data["group"]!="undefined" && $data["group"]!="null"){
			/*$query .= " GROUP BY ?";
			$query_args[] = $data["group"];*/
			
			switch ($data["group"]){
				case "piso":
					$query .= " GROUP BY piso";
				break;
				case "empresa":
					$query .= " GROUP BY clienteHistory.nombre";
				break;
				case "horas":
					$query .= " GROUP BY HOUR(fechaEntrada)";
				break;
				case "dias":
					$query .= " GROUP BY DATE(fechaEntrada)";
				break;
			}				
		}
		
		if(isset($data["order"])){
			$query .= " ORDER BY ".$data["order"];
			//$query_args[] = $data["order"];
			$query .= isset($data["or"]) && $data["or"] == "a"?" ASC":" DESC";
		}
		
		if(!isset($data["result"]) || (isset($data["result"]) && $data["result"] != "report")){
			if(isset($data["li"])){
				$query .= " LIMIT ?";
				$query_args[] = $data["li"];
			}
		
			if(isset($data["li"]) && isset($data["le"])){
				$query .= ",?";
				$query_args[] = $data["le"];
			}
		}
		

		/*
		if (isset($data["result"])){
			$query .= " AND estadoValidacion = ?"; $query_args[] =  $data["result"];
		}
		
		if (isset($data["group"])){
			$query .= " AND estadoValidacion = ?"; $query_args[] =  $data["group"];
		}
		*/
		
		return array($query,$query_args);
	}

}?>