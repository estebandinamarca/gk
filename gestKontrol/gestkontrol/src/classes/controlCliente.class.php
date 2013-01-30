<?php
require_once ('src/classes/cliente.class.php');
require_once ('src/classes/detalleCliente.class.php');
require_once ('src/classes/estacionamiento.class.php');
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

class controlCliente
{
	public function getCliente($idCliente=null)
	{
		$sql = conexionMySQLi::getInstance();
		//die($idCliente);
		$query = "SELECT idCliente,rutp,dvp,nombreEmpresa,direccion From cliente ";
		
		if($idCliente!=null)
		{
			$busqueda = "WHERE idCliente = ?";
			$sentencia = $query.$busqueda;
			$cliente = null;
			//die($sentencia);
			$resulset = $sql->devDatos($sentencia,array($idCliente));
			$resulset ->bind_result($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
			if($resulset->fetch())
			{
				$cliente = new cliente($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
			}
		}
		else
		{
			$sentencia = $query;
			$resulset = $sql->devDatos($sentencia);
			$cliente = array();
			while($value = $resulset->fetch_assoc())
			{
				$cliente[] = new cliente($value["idCliente"],$value["rutp"],$value["dvp"],$value["nombreEmpresa"],$value["direccion"]);
			}
			
		}
		return $cliente;
		
	}
	
	
	
	public function getDetalleCliente($idClientes=null,$soloPisos=null,$estadoBusqueda=null) //si es nulo se asume que es solo piso, si no retorna los pisos asociados a sus respectivas oficinas 
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT detalleCliente.idDetalleCliente,detalleCliente.idCliente,detalleCliente.oficina,detalleCliente.piso,detalleCliente.orientacion,detalleCliente.telefono,detalleCliente.contacto,detalleCliente.email "; //from detalleCliente
		$bandeta = false;
		$detalleCliente = null;
		$filtro = null;
		//echo $idCliente."_".$soloPisos."_DDD";
		if($idClientes!=null && $soloPisos!=null && $soloPisos<2) // de un cliente particular, solo retorna los pisos.
		{
			$filtro = "FROM detalleCliente,cliente WHERE detalleCliente.idCliente = cliente.idCliente AND cliente.idCliente = ? GROUP BY detalleCliente.piso asc";
			$sentencia = $sentencia.$filtro;
			
			//die();
			$resulset = $sql->devDatos($sentencia,array($idClientes));

			$resulset->bind_result($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
				//die("hola");
			while($resulset->fetch())
			{
				$detalleCliente[] = new detalleCliente($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
			}
			//print_r($detalleCliente);
			//die();
		}
		
		if($idClientes!=null && $soloPisos==null && $estadoBusqueda==null) // Muestra todo los pisos y oficinas asociados a un cliente en particular
		{
			
			$filtro = "FROM detalleCliente,cliente WHERE detalleCliente.idCliente = cliente.idCliente AND cliente.idCliente = ? ORDER BY detalleCliente.piso asc";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia,array($idClientes));
			$resulset->bind_result($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
			
			while($resulset->fetch())
			{
				$detalleCliente[] = new detalleCliente($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
			}
		}
		
		if($idClientes == null && $soloPisos==null && $estadoBusqueda==null) // muertra todo lo que tiene la tabla detalleCliente
		{
			
			$filtro = "FROM detalleCliente";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia);
			
			while($value = $resulset->fetch_assoc())
			{
				$detalleCliente[] = new detalleCliente($value["idDetalleCliente"],$value["idCliente"],$value["oficina"],$value["piso"],$value["orientacion"],$value["telefono"],$value["contacto"],$value["email"]);
			}
		}
		
		if($idClientes == null && $soloPisos!=null && $soloPisos<2) // muestra solo los pisos asociados a la tabla detalleCliente( solo 1 ves por piso).
		{
			
			$filtro = "FROM detalleCliente GROUP BY piso";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia);
				
			while($value = $resulset->fetch_assoc())
			{
				$detalleCliente[] = new detalleCliente($value["idDetalleCliente"],$value["idCliente"],$value["oficina"],$value["piso"],$value["orientacion"],$value["telefono"],$value["contacto"],$value["email"]);
			}
		}
		if($idClientes==null && $soloPisos!=null && $soloPisos>2) // esta funcion se realizara con el fin de buscar por los pisos las oficinas relacionadas a el
		{
			
			$filtro="FROM detalleCliente WHERE piso = ? ";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia,array($soloPisos));
			$resulset->bind_result($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
				
			while($resulset->fetch())
			{
				$detalleCliente[] = new detalleCliente($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
			}	
		}
		if($idClientes!=null && $soloPisos==null && $estadoBusqueda!=null)
		{
			
			$filtro="FROM detalleCliente WHERE idDetalleCliente = ? AND idCliente = ? ";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia,array($estadoBusqueda,$idCliente));
			$resulset->bind_result($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
				
			while($resulset->fetch())
			{
				$detalleCliente[] = new detalleCliente($idDetalleCliente,$idCliente,$oficina,$piso,$orientacion,$telefono,$contacto,$email);
			}	
		}
		return $detalleCliente;
	}
	
	public function getClienteId($idCliente)
	{
		$sql = conexionMySQLi::getInstance();
		$cliente = null;
		$sentencia = "SELECT idCliente, rutp, dvp, nombreEmpresa, direccion FROM cliente WHERE idCliente = ?";
		$resulset = $sql->devDatos($sentencia,array($idCliente));
		$resulset->bind_result($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
		while($resulset->fetch())
		{
			$cliente = new cliente($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
		}
		return $cliente;
	}
	
	public function updateDataClientes($data)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "UPDATE cliente SET rutp=?,dvp=?,nombreEmpresa = ?,direccion = ? WHERE idCliente = ?";
		$sql->ejecutarSentencia($sentencia,$data);
		return 1;
	}
	
	public function vinculoPisoOficinaCliente($data)
	{
		$sql = conexionMySQLi::getInstance(); //,telefono = ?,contacto = ?,email = ?
		$respuesta = -2;
		$sentencia = "UPDATE detalleCliente SET idCliente = ? WHERE idDetalleCliente = ?";
		$sql->ejecutarSentencia($sentencia,$data);
		$respuesta = 1;
		return $respuesta;
	
	}
	public function getestacionamieto($idCliente = null,$subterraneos = null,$idEsta = null)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idEstacionamiento,idCliente,subterraneo,numero ";
		$estacionamientos = null;
		$filtro = null;
		
		if($idCliente!=null && $subterraneos==null && $idEsta==null) // retorna todo los estacionamientos asociados a un cliente
		{
			
			$filtro = "FROM estacionamiento WHERE idCliente = ?";
			$sentencia = $sentencia.$filtro;
			
			$resulset = $sql->devDatos($sentencia,array($idCliente));
			$resulset->bind_result($idEstacionamiento,$idCliente,$subterraneo,$numero);
			
			while($resulset->fetch())
			{
				$estacionamientos[]= new estacionamiento($idEstacionamiento,$idCliente,$subterraneo,$numero);
			}
			
		}
		if($idCliente==null && $subterraneos!=null && $subterraneos>2 && $idEsta==null)//retorna solos subterraneos .
		{
			//echo " no si no";
			$filtro = "FROM estacionamiento GROUP BY subterraneo desc";
			$sentencia = $sentencia.$filtro;
			//echo "aqui Antes";die();
			$resulset = $sql->devDatos($sentencia);
			
			while($value = $resulset->fetch_assoc())
			{
				$estacionamientos[] = new estacionamiento($value["idEstacionamiento"],$value["idCliente"],$value["subterraneo"],$value["numero"]);
			}
		}
		if($idCliente!=null && $subterraneos!=null && $idEsta==null) // retorna los datos de un estacionamiento asociado a un cliente y un suberraneo
		{
			
			$filtro = "FROM estacionamiento WHERE idCliente = ? AND subterraneo = ?";
			$sentencia = $sentencia.$filtro;
			
			$resulset = $sql->devDatos($sentencia,array($idCliente,$subterraneos));
			$resulset->bind_result($idEstacionamiento,$idCliente,$subterraneo,$numero);
			
			while($resulset->fetch())
			{
				$estacionamientos[]= new estacionamiento($idEstacionamiento,$idCliente,$subterraneo,$numero);
			}
		}
		
		if($idCliente==null && $subterraneos!=null && $subterraneos<0 && $idEsta==null) // retorna los datos de un estacionamiento asociado aun subterraneo
		{
			$filtro = "FROM estacionamiento WHERE subterraneo = ?";
			$sentencia = $sentencia.$filtro;
			//echo "aqui";die();
			$resulset = $sql->devDatos($sentencia,array($subterraneos));
			$resulset->bind_result($idEstacionamiento,$idCliente,$subterraneo,$numero);
			
			while($resulset->fetch())
			{
				$estacionamientos[]= new estacionamiento($idEstacionamiento,$idCliente,$subterraneo,$numero);
			}
		}
		
		if($idCliente==null && $subterraneos == null && $idEsta==null) // retorna todo el contenido de la tabla estacionamiento
		{
			$filtro = "FROM estacionamiento";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia);
			
			while($value = $resulset->fetch_assoc())
			{
				$estacionamientos[] = new estacionamiento($value["idEstacionamiento"],$value["idCliente"],$value["subterraneo"],$value["numero"]);
			}
			
		}
		if($idCliente!=null && $idEsta!=null && $subterraneos==null)
		{
			$filtro = "FROM estacionamiento WHERE idCliente = ? && idEstacionamiento = ?";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia,array($idCliente,$idEsta));
			$resulset->bind_result($idEstacionamiento,$idCliente,$subterraneo,$numero);
			
			while($resulset->fetch())
			{
				$estacionamientos[]= new estacionamiento($idEstacionamiento,$idCliente,$subterraneo,$numero);
			}
		}
		return $estacionamientos;
	}
	public function getcoutestacionamiento($idCliente=null,$subterraneo=null)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT COUNT(idEstacionamiento) as contar FROM estacionamiento ";
		$total = null;
		$filtro = null;
		
		if($idCliente == null && $subterraneo!=null)
		{
			$filtro ="WHERE subterraneo = ?";
			$sentencia = $sentencia.$filtro;
			$resulset = $sql->devDatos($sentencia,array($subterraneo));
			$resulset->bind_result($contar);
			if($resulset->fetch())
			{
				$total = $contar;
			}
		}
				
		return $total;
	}
	public function vinculoEstacionamientoCliente($data)
	{
		$sql = conexionMySQLi::getInstance(); //,telefono = ?,contacto = ?,email = ?
		$respuesta = -2;
		$sentencia = "UPDATE estacionamiento SET idCliente = ? WHERE idEstacionamiento = ?";
		$sql->ejecutarSentencia($sentencia,$data);
		$respuesta = 1;
		return $respuesta;
	
	}
/*
aqui comienza la parte de nicolas castillo
*/

public function insertCliente($data)
	{
		$rutemp=$data[0];
		$idNuevoCliente = -2;
		if (controlCliente::existeCliente($rutemp)==null)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "INSERT INTO cliente (rutp,dvp,nombreEmpresa,direccion)VALUES (?,?,?,?)";
			$idNuevoCliente = $sql->ejecutarSentencia($sentencia,$data);
			return $idNuevoCliente;
		}
		else return -2; /*Existe Cliente en ese piso (rut ya ingresado)*/
	}
	
	
	
	public function existeCliente($rutCli)
	{
		
		$sql = conexionMySQLi::getInstance();
		$cliente=null;
		  
		$sentencia="SELECT rutp,dvp,nombreEmpresa,direccion FROM cliente WHERE rutp= ? ";
		$resulset = $sql->devDatos($sentencia,array($rutCli));
		$resulset->bind_result($rutp,$dvp,$nombreEmpresa,$direccion);
		if($resulset->fetch())
		{
			$cliente = new cliente($rutp,$dvp,$nombreEmpresa,$direccion);
		}
		
		return $cliente;
	}
	
	public function listaClientes($id,$op)
	{
		//die($op);
		$sql = conexionMySQLi::getInstance();
		if($op=='1')
		{
			$sentencia="SELECT idCliente,rutp,dvp,nombreEmpresa,direccion FROM cliente where cliente.idCliente = ? order by cliente.nombreEmpresa";
		}
		if($op=='6')
		{
			$sentencia="SELECT idCliente,rutp,dvp,nombreEmpresa,direccion FROM cliente where cliente.idCliente <> ? order by cliente.nombreEmpresa";
		}
		else
		{ 
			$sentencia="SELECT idCliente,rutp,dvp,nombreEmpresa,direccion FROM cliente where cliente.nombreEmpresa <> ? AND cliente.idCliente!=43 order by cliente.nombreEmpresa";
			$id="' '";
		}
		
		$resulset = $sql->devDatos($sentencia,array($id));
		$resulset->bind_result($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
		while($resulset->fetch())
		{
			$cliente[] = new cliente($idCliente,$rutp,$dvp,$nombreEmpresa,$direccion);
		}
		
		return $cliente;
		
	}
		
	public function nombreCliente($id)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia="SELECT nombreEmpresa FROM cliente where idCliente = ? ";
		$resulset = $sql->devDatos($sentencia,array($id));
		$resulset->bind_result($nombreEmpresa);
	
		if ($resulset->fetch())
		{
			$arr = $nombreEmpresa;
			//echo $piso;
		}
	
		return $arr;
	}
	public function getidCliente($name)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia="SELECT idCliente FROM cliente where nombreEmpresa = ? ";
		$resulset = $sql->devDatos($sentencia,array($name));
		$resulset->bind_result($idCliente);
	
		if ($resulset->fetch())
		{
			$arr = $idCliente;
			//echo $piso;
		}
	
		return $arr;
	}
}
?>
