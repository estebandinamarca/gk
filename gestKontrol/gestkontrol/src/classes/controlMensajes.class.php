<?php
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

require_once 'src/classes/mensaje.class.php';

class controlMensajeria
{
	public function enviarMensaje($data)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		if ($data!=null)
		{
			$sentencia = "INSERT INTO mensajeria(mensajeria.from,mensajeria.to,asunto,contenido,fecha,estado) VALUES(?,?,?,?,NOW(),'No Leido')";
			$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		}
		
		else $resultado="-1";
		//print_r($resultado);
		return $resultado;
	}
	public function cambiarEstadoMensaje($idMensaje,$opcion)
	{
		$sql = conexionMySQLi::getInstance();
		$consulta= "UPDATE mensajeria SET estado =  ? WHERE  idmensajeria = ? ";
		if ($idMensaje!=null&&$opcion!=null) return $sql->ejecutarSentencia($consulta,array($opcion,$idMensaje));
		else return "-1";
	}
	public function getMensajes($idUsuario,$opcion=null)
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=array();$opc=null;
		
		$consulta = "SELECT mensajeria.idmensajeria, mensajeria.from, mensajeria.to, mensajeria.asunto, mensajeria.contenido, mensajeria.estado,mensajeria.fecha 
		FROM mensajeria 
		WHERE ";
		if ($opcion=="Enviados") $opc=" mensajeria.from = ? ";
		else $opc= "  mensajeria.to = ? ";
		$consulta= $consulta.$opc." ORDER BY fecha DESC";
		//echo $consulta;
		if($idUsuario!=null)
		{
			$result = $sql->devDatos($consulta,$idUsuario);
		//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
			$result->bind_result($idMensaje,$from,$to,$asunto,$contenido,$fecha,$estado);
			while($result->fetch())
			
			//while ($fila = $result->fetch_assoc())
			{
				$retorno[] = new mensaje($idMensaje,$from,$to,$asunto,$contenido,$fecha,$estado);
			}
			
			
		}
		else $retorno="-1";		
		return $retorno;
	}
	
	public function getUltimosMensajesRecibidos($idUsuario, $opc=null)
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idmensajeria,from,to,asunto,contenido,fecha,estado
		FROM mensajeria
		WHERE estado= 'No Leido'
		AND to = ?
		ORDER BY fecha ASC";
		if ($opc!=null)	$consulta=$consulta." LIMIT 0,5";
		
		if($idUsuario!=null)
		{
			$result = $sql->devDatos($consulta,$idUsuario);
			//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
			while ($fila = $result->fetch_assoc())
			{
				$retorno[] = $fila;
			}
		}
		else $retorno="-1";
		return $retorno;
	}
}
?>