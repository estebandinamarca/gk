<?php
//if(!defined('PATH_SOURCE_CORE')) die ('Directorio de fuentes del nucleo no esta definida, por favor contacte al administrador o implementador.');
require_once("src/core/conexionMySQLi.class.php");
require_once("src/core/conf.class.php");

class controlVisitasEnEspera
{
	public function getVisitasEnEspera($idVisitaEnEspera=null,$idCliente=null)
	{
		$sql = conexionMySQLi::getInstance();
		$query = "SELECT idVisitasEnEspera,visitasEnEspera.idVisita,horaDeInicio,horaDeTermino,envioCorreo
		FROM visitasEnEspera";
		$retorno=null;
		if($idVisitaEnEspera==null&&$idCliente!=null)
		{
			$query.= ",visita WHERE visita.enEspera = 1 
			AND visita.idVisitaEnEspera=visitasEnEspera.idVisitasEnEspera
			AND visitasEnEspera.idCliente= ?";
			$result = $sql->devDatos($query,$idCliente);
			
			$result->bind_result($idVisEsp,$idVis,$horIni,$horFin,$correo);
			
			while ($result->fetch())
			{
				$retorno[] = array('idVisitasEnEspera'=>$idVisEsp,'idVisita'=>$idVis,'horaDeInicio'=>$horIni,'horaDeTermino'=>$horFin,'envioCorreo'=>$correo);
			}
		}
		else
		{
			$query.=" WHERE idVisitasEnEspera = ?";
			$result = $sql->devDatos($query);
				
			if ($fila = $result->fetch_assoc())
			{
				$retorno = $fila;
			}
		}
		return $retorno;
		
	}
	
	public function addVisitaEnEspera($data=null)
	{
		// En $data viene = (idVisita, horaDeInicio= date('Y-m-d H:i:s'), horaDeTermino=null
		$sql = conexionMySQLi::getInstance();
		//die($idCliente);
		if ($data!=null)
		{
			$sentencia = "INSERT INTO visitasEnEspera(idVisita,idCliente,horaDeInicio,horaDeTermino) VALUES(?,?,NOW(),?)";
			$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		}
		
		else $resultado="-1";
		return $resultado;
		//En la capa de control, capturar el idVisitaEnEspera
		
	}
	
	public function terminarVisitaEspera($idVisitaEnEspera=null,$idVisita=null)
	{
		//Actualiza la hora de termino de espera de una visita
		$sql = conexionMySQLi::getInstance();
		$consulta= "UPDATE visitasEnEspera SET horaDeTermino = NOW() WHERE  idVisitasEnEspera =? AND idVisita = ? ";
		if ($idVisitaEnEspera!=null&&$idVisita!=null) return $sql->ejecutarSentencia($consulta,array($idVisitaEnEspera,$idVisita));
		else return "-1";
	}
	
	public function actualizaVisitaEnEspera($idVisitaEnEspera=null,$idVisita=null)
	{
		$sql = conexionMySQLi::getInstance();
		
		$consulta= "UPDATE visita SET idVisitaEnEspera = ? WHERE idVisita = ? ";
		if ($idVisitaEnEspera!=null&&$idVisita!=null) return $sql->ejecutarSentencia($consulta,array($idVisitaEnEspera,$idVisita));
		else return "-1";
	}
}


?>