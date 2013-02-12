<?php
require_once 'src/classes/detalleCliente.class.php';
require_once 'src/classes/estacionamiento.class.php';
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

class controlEdificio
{
	public function insertPisoOficina($data=null)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		if ($data!=null)
		{
			$sentencia = "INSERT INTO detalleCliente(idCliente,oficina,piso,orientacion,telefono,contacto,email) VALUES(NULL,?,?,NULL,NULL,NULL,NULL)";
			$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		}
		//print_r($data);
		else $resultado="-1";
		return $resultado;
		
	}
		
	public function insertSubEstacionamiento($data=null)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		if ($data!=null)
		{
			$sentencia = "INSERT INTO estacionamiento(idCliente,subterraneo,numero,estado,proveedor) VALUES(NULL,?,?,0,?)";
			$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		}
		//print_r($data);
		else $resultado="-1";
		return $resultado;
	}
	
	public function listPisosOficinas()
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idDetalleCliente,idCliente,oficina,piso,orientacion,telefono,contacto,email
		FROM detalleCliente ORDER BY piso ASC";
		$result = $sql->devDatos($consulta);
		//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		while ($fila = $result->fetch_assoc())
		{
			$retorno[] = $fila;
		}
		return $retorno;
	}
	
	public function listEstacionamientos()
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idEstacionamiento,idCliente,subterraneo,numero,estado,proveedor
		FROM estacionamiento ORDER BY subterraneo DESC, numero ASC";
		$result = $sql->devDatos($consulta);
		//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		while ($fila = $result->fetch_assoc())
		{
			$retorno[] = $fila;
		}
		return $retorno;
	}
	
	public function updateOficina($idOfi=null,$oficina=null)
	{
		$sql = conexionMySQLi::getInstance();
		$consulta= "UPDATE  detalleCliente SET oficina =  ? WHERE  idDetalleCliente = ? ";
		if ($idOfi!=null&&$oficina!=null) return $sql->ejecutarSentencia($consulta,array($oficina,$idOfi));
		else return "-1";
	}
	
	public function updateEdificio($idEstacionamiento=null,$numEst=null,$estProve=null)
	{
		$sql = conexionMySQLi::getInstance();
		$consulta= "UPDATE  estacionamiento SET numero =  ?,proveedor = ? WHERE  idEstacionamiento = ? ";
		if ($idEstacionamiento!=null&&$numEst!=null&&$estProve!=null) return $sql->ejecutarSentencia($consulta,array($numEst,$estProve,$idEstacionamiento));
		else return "-1";
	}
	
	public function listPisosOcupados()
	{
		$sql = conexionMySQLi::getInstance();
		$retorno=null;
		$consulta = "SELECT idDetalleCliente,idCliente,oficina,piso,orientacion,telefono,contacto,email
		FROM detalleCliente WHERE idCliente <> 'null' GROUP BY piso ORDER BY piso ASC";
		$result = $sql->devDatos($consulta);
		//	$result->bind_result($idTarj,$numTarj,$codBarTarj,$codRFID,$estado);
		while ($fila = $result->fetch_assoc())
		{
			$retorno[] = $fila;
		}
		return $retorno;
	}
	
	
}

?>