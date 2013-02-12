<?php
require_once ('src/classes/fechaHora.php');
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

class controlLogSistema
{
	/*
	 * Campos de la base de datos:
	 * 
	 * idLog
	 * fechaHora
	 * tipo
	 * resumen
	 * uri
	 * aplicacion
	 * usuario
	 * ip
	 * estadoRevision
	 * observaciones
	 * 
	 */
	public function crateLogSistema($datos)
	{
		date_default_timezone_set('America/Santiago');
		$param = array();
		$resultado = null;
		//getFechaHoraI()
		$sql=conexionMySQLi::getInstance();
		//INSERT INTO reserva(idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$sentencia = "INSERT INTO logSistema(fechaHora,tipo,resumen,uri,ip,aplicacion,usuario,estadoRevision,observaciones) VALUES(NOW(),?,?,?,?,?,?,?,?)";
		
		if($datos!=null && count($datos)>0)
		{
			$resultado = $sql->ejecutarSentencia($sentencia,$datos);
						
		}
		
		return $resultado;
				
	}
	
}
?>