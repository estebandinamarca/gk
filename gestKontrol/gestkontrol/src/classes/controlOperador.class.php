<?php
require_once ('src/classes/operador.class.php');
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');

class controlOperador
{
	public function insertOperador($data)
	{
		$sql = conexionMySQLi::getInstance();
		if ((controlOperador::getIdOperador($data[4]))==null)
		{
			$sentencia = "INSERT INTO operador (telefono, celular,ubicacionEdificio,orientacionPos, idUser)  VALUES (?,?,?,?,?)";
			$sql-> ejecutarSentencia($sentencia,$data);
			return "1"; // Todo OK
		}
		else return "-1"; // Operador ya ingresado
	}
	
	public function getIdOperador($idUser)
	{
		//buscar en la DB si el operador ya existe, si no existe retornar algo
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idOperador FROM operador WHERE idUser = ? ";
		$resulset = $sql->devDatos($sentencia,$idUser);
		$resulset-> bind_result($idOperador);
		
		if($resulset->fetch())
		{
			return $idOperador; //SI ENCUENTRA EN NOMBRE DE USUARIO, LO RETORNA.
				
		}
		return null;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
	}
	
	
	// <!-- ##########################################  NICO  ##################################################################### -->
	
	public function getOperador($idUser)
	{
		//buscar en la DB si el operador ya existe, si no existe retornar algo
		$sql = conexionMySQLi::getInstance();
		$op=null;
		$sentencia = "SELECT idOperador,telefono,celular,ubicacionEdificio,orientacionPos,idUser FROM operador WHERE idUser = ? ";
		$resulset = $sql->devDatos($sentencia,$idUser);
		$resulset-> bind_result($idOperador,$telefono,$cel,$ubi,$ori,$idus);
		
		
	
		if($resulset->fetch())
		{
			$op = new operador($idOperador,$telefono,$cel,$ubi,$ori,$idus); //SI ENCUENTRA EN NOMBRE DE USUARIO, LO RETORNA.
			
	
		}
		/*echo "<br>-------------------<br>";
		var_dump($op);
		echo "-------------------<br>";*/
		return $op;	// retorna -1 si el NOMBRE DE USUARIO, no se encuentra en la BD
	}
	
	public function editOperator($id,$elems)
	{
		//$elems=$elem[0];
		$sql = conexionMySQLi::getInstance();
		
		$sentencia = "UPDATE operador SET telefono = ?, celular = ?, ubicacionEdificio = ?, orientacionPos = ? WHERE idUser = ?";
		$data = array($elems[0],$elems[1],$elems[2], $elems[3], $id);
		
	
			
		return $sql-> ejecutarSentencia($sentencia,$data);
	}
	
	public function deleteOperador($id)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE usuarios SET userName = null, password= null, mail = null, level=null, company=null WHERE idUser = '". $id ."'";
		return $result = $sql-> devDatos($sentencia);
	}
	
	//<!-- ##########################################  NICO  ##################################################################### -->
}
?>
