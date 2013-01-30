<?php
require_once("src/core/conexionMySQLi.class.php");
require_once("src/core/conf.class.php");

class controlDetalleVisita
{
	public function insertVisitaCliente($idVisita,$idCliente)
	{
		if($idVisita!=null && $idCliente!=null)
		{
			$sql = conexionMySQLi::getInstance();
			$arr = array($idVisita,$idCliente);
			$sentencia = "INSERT INTO detalleVisita (idVisita,idCliente) VALUES (?,?)";
			$sql->ejecutarSentencia($sentencia,$arr);
			return 1;
			
		}
		return 0;
	}
	
}

?>