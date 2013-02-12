<?php 
require_once ('src/classes/estacionamiento.class.php');
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

class controlEstacionamiento
{
	public function getEstacionamientosProveedor()
	{
		//buscar en la DB si el operador ya existe, si no existe retornar algo
		$sql = conexionMySQLi::getInstance();
		$resultado=array();
		$sentencia = "SELECT idEstacionamiento,idCliente,subterraneo,numero,estado
			FROM estacionamiento 
			WHERE proveedor = 1";
		$resulset = $sql->devDatos($sentencia);
		//$resulset-> bind_result($idEstacion,$idCli,$sub,$num,$est);
		
		
	
		while($value = $resulset->fetch_assoc())
		{
			$resultado[] = new estacionamiento($value['idEstacionamiento'],$value['idCliente'],$value['subterraneo'],$value['numero'],$value['estado']);
		}
		/*echo "<br>-------------------<br>";
		var_dump($op);
		echo "-------------------<br>";*/
		return $resultado;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
	}
	
	public function countEstacionamientosProveedor()
	{
		//buscar en la DB si el operador ya existe, si no existe retornar algo
		$sql = conexionMySQLi::getInstance();
		$resultado=null;
		$sentencia = "SELECT COUNT(proveedor) as total FROM estacionamiento WHERE proveedor=1";
		$resulset = $sql->devDatos($sentencia);
		//$resulset-> bind_result($total);
	
	
	
		while($value = $resulset->fetch_assoc())
		{
			$resultado= $value["total"];
		}
		return $resultado;	
	}
	
	public function ocuparEstNumero($numEst)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE estacionamiento 
			SET estado= 1 
			WHERE numero = ?";
		return $sql-> ejecutarSentencia($sentencia,$numEst);
		
	}
	public function desocuparEstNumero($numEst)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE estacionamiento
		SET estado = 0
		WHERE numero = ?";
		return $sql-> ejecutarSentencia($sentencia,$numEst);
	
	}
	
	public function getEstOcupadosProveedor()
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idEstacionamiento,idCliente,subterraneo,numero,estado FROM estacionamiento WHERE proveedor=1 AND estado=0 ";
	}
	
	public function getEstacionamientoCliente($idCliente=null)
	{
		//buscar en la DB si el operador ya existe, si no existe retornar algo
		$sql = conexionMySQLi::getInstance();
		$resultado=array();
		$sentencia = "SELECT idEstacionamiento,idCliente,subterraneo,numero,estado,proveedor,visita
		FROM estacionamiento
		WHERE idCliente = ?";
		$resulset = $sql->devDatos($sentencia,array($idCliente));
		$resulset-> bind_result($idEstacion,$idCli,$sub,$num,$est,$prov,$visita);
		
		if($idCliente!=null)
		{
			while($resulset->fetch())
			{
				$resultado[] = new estacionamiento($idEstacion,$idCli,$sub,$num,$est,$prov,$visita);
			}
		}
		else $resultado=0;
		/*echo "<br>-------------------<br>";
		 var_dump($op);
		echo "-------------------<br>";*/
		return $resultado;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la B
		
	}
	
}


?>