<?php

require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');
require_once ('src/classes/tarjeta.class.php');
require_once ('src/classes/detalleTarjeta.class.php');


class controlTarjeta
{
		
	public function getTarjetaPorNumero($numero)
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idTarjeta,numeroTarjeta,codigBarraTarjeta,codigoRfid,estado
		FROM tarjeta
		WHERE numeroTarjeta = ?";
		$result = $sql->devDatos($consulta,$numero);
		$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		if ($result->fetch())
		{
			$retorno = new tarjeta($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		}
		return $retorno;
	}
	
	public function getDetalleTarjetaPorReserva($idReserva)
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idDetalleTarjeta,idtarjeta,idVisita,idReserva,fechaSolicitud
		FROM detalleTarjeta
		WHERE idReserva = ?";
		$result = $sql->devDatos($consulta,$idReserva);
		$result->bind_result($idDetTar,$idTar,$idVis,$idRes,$fecha);
		if ($result->fetch())
		{
			$retorno = new detalleTarjeta($idDetTar,$idTar,$idVis,$idRes,$fecha);
		}
		return $retorno;
	}
	
	public function insertTarjetaHistorico($idTarj,$idVis,$idRes)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "INSERT INTO detalleTarjeta(idtarjeta,idVisita,idReserva,fechaSolicitud) VALUES(?,?,?,NOW())";
		$resultado = $sql-> ejecutarSentencia($sentencia,array($idTarj,$idVis,$idRes));
		//print_r($data);
		
		return $resultado;
	}
	
	public function ocupaTarjeta($num)
	{
		$sql=conexionMySQLi::getInstance();
		//echo $id."_".$op;
		//die();
		
		$consulta="UPDATE tarjeta
		SET estado = '1'
		where numeroTarjeta= '".$num."'";
		
		
		return $sql->ejecutarSentencia($consulta);
	}
	
	public function desOcupaTarjeta($idRes)
	{
		$sql=conexionMySQLi::getInstance();
		//echo $id."_".$op;
		//die();
	
		$consulta="UPDATE tarjeta,detalleTarjeta
		SET tarjeta.estado = '0'
		where tarjeta.idtarjeta = detalleTarjeta.idTarjeta
		and detalleTarjeta.idReserva='".$idRes."'" ;
	
	
		return $sql->ejecutarSentencia($consulta);
	}
	
	public function insertTarjeta($data)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "INSERT INTO tarjeta(numeroTarjeta,codigBarraTarjeta,codigoRfid) VALUES (?,?,?)";
		$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		//print_r($data);
		
		return $resultado;
	}
	
	public function listTarjeta()
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idtarjeta,numeroTarjeta,codigBarraTarjeta,codigoRfid,estado
		FROM tarjeta ORDER BY numeroTarjeta ASC";
		$result = $sql->devDatos($consulta);
	//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		while ($fila = $result->fetch_assoc())
		{
			$retorno[] = $fila;
		}
		return $retorno;
	}
	
	public function updateTarjeta($idTarjeta,$data)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "UPDATE tarjeta SET numeroTarjeta=? ,codigBarraTarjeta = ?,codigoRfid=? where idtarjeta = '".$idTarjeta."' ";
		$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		//print_r($data);
	
		return $resultado;
	}
	
	public function deleteTarjeta($idTarjeta)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "DELETE FROM tarjeta WHERE idtarjeta = '".$idTarjeta."' ";
		$resultado = $sql-> ejecutarSentencia($sentencia);
		//print_r($data);
	
		return $resultado;
	}
	
	public function liberaTarjeta($idTarjeta)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "UPDATE tarjeta SET estado = 0 where idtarjeta = '".$idTarjeta."' ";
		$resultado = $sql-> ejecutarSentencia($sentencia);
		//print_r($data);
	
		return $resultado;
	}
	
	
}


?>