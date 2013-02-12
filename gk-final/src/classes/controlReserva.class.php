<?php
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/fechaHora.php');
require_once ('src/classes/verificacionValidacion.class.php');
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');
require_once ('src/classes/controlTarjeta.class.php');
require_once ('src/classes/controlConfiguracionGK.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');

class controlReserva
{
	public function insertaReserva($data)
	{
		$resultado = null;
		$sql= conexionMySQLi::getInstance();
		$sentencia = "INSERT INTO reserva(idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$resultado = $sql-> ejecutarSentencia($sentencia,$data);
		//print_r($data);
		
		return $resultado;
	}

	public function insertReservaFrecuente($data,$dataDias)
	{

		$reserva = null;
		$resultado = null;
		//print_r($data);
		//die();
		$resInserRe = controlReserva::insertaReserva($data);
		if($resInserRe>0)
		{
			$sql = conexionMySQLi::getInstance();
			$sentencia = "INSERT INTO reservaFrecuente(idReserva,lunes,martes,miercoles,jueves,viernes,sabado,domingo) VALUES(?,?,?,?,?,?,?,?)";
			$reserva = controlReserva::isReservaFrecuente($data[0],$data[2]);
			$dataS = array($reserva->getidReserva(),$dataDias["lunes"],$dataDias["martes"],$dataDias["miercoles"],$dataDias["jueves"],$dataDias["viernes"],$dataDias["sabado"],$dataDias["domingo"]);
			$resultado = $sql-> ejecutarSentencia($sentencia,$dataS);
			
			if($resultado<=0)
			{
				controlReserva::eliminarRegistro($resInserRe);
			  	$resultado = "-1";
			}
			else
			{
				$resultado = $resInserRe;
			}
			return $resultado;
		}
		else
		{
			return -1;
		}

	}
	
	public function eliminarRegistro($idReserva)
    	{
    		$sql = conexionMySQLi::getInstance();
    		$sentencia = "DELETE FROM reserva WHERE idReserva = ?";
	    	
		if($idReserva!=null)
    		{
    			$sql->ejecutarSentencia($sentencia,array($idReserva));
    			return 1;
	    	}
	    	else 
	    	{
	    		return -1;
	    	}
    	
    	
	    }	
		
	public function insertaReservaYretornaidReserva($data) //nueva funcion para validaVisita
	{
		$sql= conexionMySQLi::getInstance();
		$idReserva = null;
		$flag = controlReserva::isHaveReserva($data[0],$data[2],$data[6],$data[3]);//se consulta si hay reserva en el dia siguiente que 
		//deberia ir la visita.. si no hay visita y la fecha de entrada es menor o igual a la fecha de salida (data[3]<=data[4])
		// se agrega una nueva reserva...sino se le otrorga un codigo que valida la visita pero sin ingresar la nueva reserva
		//var_dump($flag);echo "->flag ".$data[3]."-> data3 ".$data[4]."-> data4";	
		if ($flag==null&&$data[3]<=$data[4])
		{
			$sentencia = "INSERT INTO reserva(idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$idReserva = $sql-> ejecutarSentencia($sentencia,$data);
		}
		else $idReserva="-2";
		return $idReserva;
	}

	public function updateReservaFrecuenteSoloIdReserva($cambio) //nueva funcion para validaVisita
	{
		$sql= conexionMySQLi::getInstance();
		$sentencia = "UPDATE reservaFrecuente SET idReserva = ? WHERE idReserva = ?";
		$sql->ejecutarSentencia($sentencia,$cambio);
		return 1;

	}

	public function isHaveReserva($idcl,$idvi,$tipoFrecuencia=null,$fechaEntrada=null)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva ";
		$reserva = null;

		if($fechaEntrada!=null)
		{
			//$fechahora = new FechaHora();
			//$fechaEntrada = $fechahora->getFechaI();


			$filtro = "WHERE idCliente = ? AND idVisita = ? AND tipoFrecuencia = ? AND DATE(fechaEntrada) = ? AND estadoValidacion = 'Reservada'";
			$consulta = $sentencia.$filtro;
			//echo $consulta."<br>";
			//echo $idcl.$idvi.$tipoFrecuencia.$fechaEntrada;
			$resulset = $sql->devDatos($consulta,array($idcl,$idvi,$tipoFrecuencia,$fechaEntrada));
			$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);

			if($resulset->fetch())
			{
				$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);

			}
		}
		else
		{
			if($tipoFrecuencia==null)
			{
				$filtro = "WHERE idCliente = ? AND idVisita = ? AND estadoValidacion ='Reservada'";

				$consulta = $sentencia.$filtro;
				$resulset = $sql->devDatos($consulta,array($idcl,$idvi));
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
						
				}
			}
			else
			{
				$filtro = "WHERE idCliente = ? AND idVisita = ? AND tipoFrecuencia = ? AND estadoValidacion ='Reservada'";
					
				$consulta = $sentencia.$filtro;
				$resulset = $sql->devDatos($consulta,array($idcl,$idvi,$tipoFrecuencia));
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
						
				}
			}
		}

		return $reserva;
	}

	public function eliminarFrecuenciaDias($idReserva,$tipoF=null,$tipoNow=null)
	{
		$sql = conexionMySQLi::getInstance();

		$sentencia = "DELETE FROM reservaFrecuente WHERE idReserva = ?";
		$sql-> ejecutarSentencia($sentencia,array($idReserva));
		return 1;
	}

	public function updateReserva($dataReserva,$dataRefrecuencia=null,$changeFreaEspo=null)
	{
		$sql = conexionMySQLi::getInstance();

		//$sentencia = "UPDATE reserva SET fechaEntrada = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?";
		//print_r($dataReserva);
		//die();
		//$sql-> ejecutarSentencia($sentencia,$dataReserva);
		if($dataRefrecuencia!=null)
		{
			//die("aqui no");
			if($changeFreaEspo==null) // updatea una reserva frecuente siendo ya frecuente
			{
				$sentencia = "UPDATE reserva SET fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?";
				$sql-> ejecutarSentencia($sentencia,$dataReserva);
					
				$sentencia = "UPDATE reservaFrecuente SET lunes=?,martes=?,miercoles=?,jueves=?,viernes=?,sabado=?,domingo=? WHERE idReserva = ?";
				$sql->ejecutarSentencia($sentencia,$dataRefrecuencia);
			}
			else // transforma de una reserva esporadica a una frecuente...
			{
				$sentencia = "UPDATE reserva SET fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?";
				$sql-> ejecutarSentencia($sentencia,$dataReserva);

				$dataFrecuencia = array($dataRefrecuencia[7],$dataRefrecuencia[0],$dataRefrecuencia[1],$dataRefrecuencia[2],$dataRefrecuencia[3],$dataRefrecuencia[4],$dataRefrecuencia[5],$dataRefrecuencia[6]);
				$sentencia = "INSERT INTO reservaFrecuente(idReserva,lunes,martes,miercoles,jueves,viernes,sabado,domingo) VALUES(?,?,?,?,?,?,?,?)";
				$sql-> ejecutarSentencia($sentencia,$dataFrecuencia);

			}
				
				
		}
		else
		{
			//die("ok llego donde necesitamos");
			if($dataRefrecuencia==null && $changeFreaEspo!=null) // updadatea una reserva frecuente y la transforma a un esporadica
			{	//die("ok llego donde necesitamos");
				$sentencia = "UPDATE reserva SET fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ? ,tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?";
				$sql->ejecutarSentencia($sentencia,$dataReserva);
				controlReserva::eliminarFrecuenciaDias($dataReserva[10]);
				//return 1;
			}
			else
			{  // update una reserva esporadica siendo ya esporadica!!
				$sentencia = "UPDATE reserva SET fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ? ,tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?";
				$sql->ejecutarSentencia($sentencia,$dataReserva);
			}
		}

		return 1;
	}

	public function isReservaFrecuente($idcl,$idvi)
	{
		$sql = conexionMySQLi::getInstance();
		$reserva = null;
		$sentencia = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva WHERE idCliente = ? AND idVisita = ? AND tipoFrecuencia=1 AND estadoValidacion ='Reservada'";
		$resulset = $sql->devDatos($sentencia,array($idcl,$idvi));
		$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
		if($resulset->fetch())
		{
			$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
		}
		return $reserva;
	}
	public function getReservaAssClienteVisita($idcl,$idvi,$fechaEntrada=null)
	{
		$sql = conexionMySQLi::getInstance();
		$reserva = null;
		$sentenciaNoFrecuente = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva ";

		$sentenciaFrecuente = "SELECT reserva.idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo,reservaFrecuente.idreservaFrecuente,reservaFrecuente.lunes,reservaFrecuente.martes,reservaFrecuente.miercoles,reservaFrecuente.jueves,reservaFrecuente.viernes,reservaFrecuente.sabado,reservaFrecuente.domingo FROM reserva,reservaFrecuente ";
		$sentencia = null;
		$bandera = 0;
		//print_r(controlReserva::isReservaFrecuente($idcl,$idvi));
		//die();
		if(count(controlReserva::isReservaFrecuente($idcl,$idvi))>0)
		{
			$sentencia = $sentenciaFrecuente;
			$bandera = 1;
		}
		else
		{
			$sentencia = $sentenciaNoFrecuente;
		}

		if($fechaEntrada==null)
		{
				
			if($bandera==1)
			{
				//print_r($sentencia);
				//die();

				$where = "WHERE reserva.idCliente = ? AND reserva.idVisita = ? AND reservaFrecuente.idReserva=reserva.idReserva AND reserva.estadoValidacion ='Reservada'";

				$resulset = $sql->devDatos($sentencia.$where,array($idcl,$idvi));

				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idreservaFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);

				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idreservaFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
				}
			}
			else
			{
				$where = "WHERE reserva.idCliente = ? AND reserva.idVisita = ? AND estadoValidacion ='Reservada'";
				$resulset = $sql->devDatos($sentencia.$where,array($idcl,$idvi));

				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				}
				//print_r($reserva);
				//die();
			}
				
				
		}
		else
		{
				
			//$sentencia = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva WHERE idCliente = ? AND idVisita = ? AND estadoValidacion ='Reservada' AND fechaEntrada = ?";
				
				
			$where = "WHERE idCliente = ? AND idVisita = ? AND estadoValidacion ='Reservada' AND fechaEntrada = ?";
			$resulset = $sql->devDatos($sentencia.$where,array($idcl,$idvi,$fechaEntrada));
			/*$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
			 if($resulset->fetch())
			 {
			$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
			}*/
				
			if($bandera==1)
			{
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idreservFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idreservFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
				}
			}
			else
			{
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				if($resulset->fetch())
				{
					$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				}
			}
				
		}
		return $reserva;
		/*
		 * Es para la parte de generar una reserva con un cliente ya ingresado.....
		*/
	}

	public function getReservas($estadoValidacion=null,$tipoFrecuencia=null,$idcliente=null,$idVisita=null,$ultimaAccion=null)
	{
		$sql = conexionMySQLi::getInstance();

		$sentencia = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva ";
		$filtro = null;
		$param = array();
		$and = false;
		$reserva = null;
		$order = " Order by fechaEntrada desc";
		if($estadoValidacion!=null)
		{
			$filtro.= $and? " AND estadoValidacion = ?": "estadoValidacion = ?";
			$param[] = $estadoValidacion;
			$and = true;
		}
		if($tipoFrecuencia!=null)
		{
			$filtro.= $and? " AND tipoFrecuencia = ?": "tipoFrecuencia = ?";
			$param[] = $tipoFrecuencia;
			$and = true;
		}
		if($idcliente!=null)
		{
			$filtro.= $and? " AND idCliente = ?": "idCliente = ?";
			$param[] = $idcliente;
			$and = true;
		}
		if($idVisita!=null)
		{
			$filtro.= $and? " AND idVisita = ?": "idVisita = ?";
			$param[] = $idVisita;
			$and = true;
		}
		if($and)
		{
			$busqueda = "WHERE ";
			$resulset = $sql->devDatos($sentencia.$busqueda.$filtro.$order,$param);
			$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
			while($resulset->fetch())
			{
				$reserva[] = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
			}
		}
		else
		{
			$resulset = $sql->devDatos($sentencia);
			while($value = $resulset->fetch_assoc())
			{
				$reserva[] = new reserva($value["idReserva"],$value["idCliente"],$value["idOperador"],$value["idVisita"],$value["fechaEntrada"],$value["fechaSalida"],$value["tipoReserva"],$value["tipoFrecuencia"],$value["piso"],$value["oficina"],$value["estacionamientoAsignado"],$value["estadoValidacion"],$value["momentoValidacion"],$value["codigoReserva"],$value["patenteVehiculo"]);
			}
		}
		return $reserva;
	}
	
	/*AGREGAR ESTE AL SISTEMA COMPLETO*/
	public function getReservaAuxId($id)
	{
		$sql = conexionMySQLi::getInstance();
		$sentencia = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva Where idReserva = ? ";
		$reserva = null;
	
		$resulset = $sql->devDatos($sentencia,array($id));
		$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
	
		if($resulset->fetch())
		{
			$reserva = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
		}
		return $reserva;
	
	}
	/*ASDASDSA*/
	
	public function updateReservaGlobal($data,$idReserva)
	{
		//UPDATE reserva SET fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ? ,tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?
		$sql=conexionMySQLi::getInstance();
		$consulta = "UPDATE reserva SET ";
		$filtro = null;
		$and = false;
		$param = array(); // order de parametros idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
		$busqueda = " WHERE idReserva = ?";
		$resultado = null;
		if($data!=null && count($data)>0)
		{
			if($data[0]!=null)
			{
				$filtro .= $and? ",idCliente = ?":"idCliente = ?";
				$param[] = $data[0];
				$and = true;
			}
			if($data[1]!=null)
			{
				$filtro .= $and? ",idOperador = ?":"idOperador = ?";
				$param[] = $data[1];
				$and = true;
			}
			if($data[2]!=null)
			{
				$filtro .= $and? ",idVisita = ?":"idVisita = ?";
				$param[] = $data[2];
				$and = true;
			}
			if($data[3]!=null)
			{
				$filtro .= $and? ",fechaEntrada = ?":"fechaEntrada = ?";
				$param[] = $data[3];
				$and = true;
			}
			if($data[4]!=null)
			{
				$filtro .= $and? ",fechaSalida = ?":"fechaSalida = ?";
				$param[] = $data[4];
				$and = true;
			}
			if($data[5]!=null)
			{
				$filtro .= $and? ",tipoReserva = ?":"tipoReserva = ?";
				$param[] = $data[5];
				$and = true;
			}
			if($data[6]!=null)
			{
				$filtro .= $and? ",tipoFrecuencia = ?":"tipoFrecuencia = ?";
				$param[] = $data[6];
				$and = true;
			}
			if($data[7]!=null)
			{
				$filtro .= $and? ",piso = ?":"piso = ?";
				$param[] = $data[7];
				$and = true;
			}
			if($data[8]!=null)
			{
				$filtro .= $and? ",oficina = ?":"oficina = ?";
				$param[] = $data[8];
				$and = true;
			}
			if($data[9]!=null)
			{
				$filtro .= $and? ",estacionamientoAsignado = ?":"estacionamientoAsignado = ?";
				$param[] = $data[9];
				$and = true;
			}
			if($data[10]!=null)
			{
				$filtro .= $and? ",estadoValidacion = ?":"estadoValidacion = ?";
				$param[] = $data[10];
				$and = true;
			}
			if($data[11]!=null)
			{
				$filtro .= $and? ",momentoValidacion = ?":"momentoValidacion = ?";
				$param[] = $data[11];
				$and = true;
			}
			if($data[12]!=null)
			{
				$filtro .= $and? ",codigoReserva = ?":"codigoReserva = ?";
				$param[] = $data[12];
				$and = true;
			}	
			if($data[13]!=null)
			{
				$filtro .= $and? ",patenteVehiculo = ?":"patenteVehiculo = ?";
				$param[] = $data[13];
				$and = true;
			}
			
			if($idReserva!=null)
			{
				$sentencia = $consulta.$filtro.$busqueda;
				$param[] = $idReserva;
				//print_r($sentencia);
				//print_r($param);
				$resultado = $sql->ejecutarSentencia($sentencia,$param);
			}
			
				
		}
		return $resultado;
	}
	public function getReservaEstadoReserva($tipoFrecuencia=null,$estadoValidacion=null,$fechaInicio=null,$fechaTermino=null,$fechaTentativaNueva=null,$tipoReserva=null,$comparacion=null,$inicioOfin=null)
	{
		$sql=conexionMySQLi::getInstance();
		$reserva = null;
		$consultaF = "SELECT reserva.idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo,reservaFrecuente.idreservaFrecuente,reservaFrecuente.lunes,reservaFrecuente.martes,reservaFrecuente.miercoles,reservaFrecuente.jueves,reservaFrecuente.viernes,reservaFrecuente.sabado,reservaFrecuente.domingo FROM reserva,reservaFrecuente ";
		$consultaE = "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo FROM reserva ";
		$banderaFrecuencia = false;
		$and = false;
		$filtro = null;
		$param = array();

		if($tipoFrecuencia!=null)
		{
			$filtro.= $and? " AND reserva.tipoFrecuencia = ?":"reserva.tipoFrecuencia = ?";
			$param[] = $tipoFrecuencia;
			$and = true;
			if($tipoFrecuencia>0){
				$banderaFrecuencia = true;
			}
		}
		else
		{
				
			$filtro.= $and? " AND reserva.tipoFrecuencia = ?":"reserva.tipoFrecuencia = ?";
			$param[] = $tipoFrecuencia;
			$and = true;
		}
		if($estadoValidacion!=null)
		{
			$filtro.=$and? " AND reserva.estadoValidacion = ?":"reserva.estadoValidacion = ?";
			$param[] = $estadoValidacion;
			$and = true;
		}
		if($fechaInicio!=null && $comparacion==null)
		{
			$filtro.=$and? " AND reserva.fechaEntrada >= ? AND reserva.fechaEntrada <= ? ":"reserva.fechaEntrada >= ? AND reserva.fechaEntrada <= ?";
			$param[] = $fechaInicio." 00:00:00";
			$param[] = $fechaInicio." 23:59:59";
			$and = true;
		}
		if($fechaTermino!=null && $comparacion==null)
		{
			$filtro.=$and? " AND reserva.fechaSalida>=? AND reserva.fechaSalida <=?":"reserva.fechaSalida>=? AND reserva.fechaSalida <=?";
			$param[] = $fechaTermino." 00:00:00";
			$param[] = $fechaTermino." 23:59:59";
			$and = true;
		}
		if($fechaTentativaNueva!=null)
		{
			$filtro.=$and? " AND reserva.fechaSalida>= ?": "reserva.fechaSalida>=?";
			$param[]= $fechaTentativaNueva;
			$and = true;
		}
		if($tipoReserva!=null)
		{
			$filtro.=$and? " AND reserva.tipoReserva":"reserva.tipoReserva";
			$param[] = $tipoReserva;
			$and = true;
		}
		/*if($fechaInicio!=null && $fechaTermino!=null && $comparacion!=null && $inicioOfin!=null)
		 {
		if($comparacion==0 && $inicioOfin==0)
		{
		$filtro.=$and? "AND fechaEntrada >= ? AND fechaEntrada <= ? ":"fechaEntrada >= ? AND fechaEntrada <= ?";
		$param[] = "";
		$and = true;
		}
		}*/
		if($and)
		{
			$busqueda = "WHERE ";
			if($banderaFrecuencia)
			{
				$filtro.= " AND reservaFrecuente.idReserva=reserva.idReserva";
				/*print_r($consultaF.$busqueda.$filtro);
				 echo "<pre>";
				print_r($param);
				echo "<pre>";
				die();*/
				$resulset = $sql->devDatos($consultaF.$busqueda.$filtro,$param);
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idReservaFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
				while($resulset->fetch())
				{
					$reserva[] = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo,$idReservaFrecuente,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
				}
			}
			else
			{
				/*print_r($consultaF.$busqueda.$filtro);
				 echo "<pre>";

				print_r($param);
				echo "<pre>";
				die();*/

				$resulset = $sql->devDatos($consultaE.$busqueda.$filtro,$param);
				$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				while($resulset->fetch())
				{
					$reserva[] = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
				}
			}
				
		}

		return $reserva;
	}
	
	/*NUEVO METODO AGREGAR EL SISTEMA REAL*/
	
	public function getReservasforDate($estadoValidacion=null,$fechaEntradaI,$fechaTopeEntrada,$idc=null,$est=null)
	{
		$sql=conexionMySQLi::getInstance();
		$reserva = null;
		$estadoV = "Reservada";
		$filtro = " and idCliente = ?";
		$sentencia= "SELECT idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo 
		FROM reserva 
		WHERE estadoValidacion = ? AND fechaEntrada>= ? AND fechaEntrada<= ?";
		$horaInicio = " 00:00:00";
		$horaTermino = " 23:59:59";
		if($estadoValidacion==null)
		{
			$estadoValidacion = $estadoV;
		}
		
		if($idc!=null)
		{
			if($est!=null&&$est!="todos")
			{
				$sentencia = $sentencia.$filtro." AND estacionamientoAsignado = ?";
				
				$resulset = $sql->devDatos($sentencia,array($estadoV,$fechaEntradaI.$horaInicio,$fechaTopeEntrada.$horaTermino,$idc,$est));
			}
			else
			{
				$sentencia = $sentencia.$filtro;
				$resulset = $sql->devDatos($sentencia,array($estadoV,$fechaEntradaI.$horaInicio,$fechaTopeEntrada.$horaTermino,$idc));
			}
			
		}
		else 
		{
			if($est!=null&&$est!="todos")
			{
				$sentencia = $sentencia." AND estacionamientoAsignado = ?";
				$resulset = $sql->devDatos($sentencia,array($estadoV,$fechaEntradaI.$horaInicio,$fechaTopeEntrada.$horaTermino,$est));
			}
			else $resulset = $sql->devDatos($sentencia,array($estadoV,$fechaEntradaI.$horaInicio,$fechaTopeEntrada.$horaTermino));
		}
		
		$resulset ->bind_result($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
	
		while($resulset->fetch())
		{
			$reserva[] = new reserva($idReserva,$idCliente,$idOperador,$idVisita,$fechaEntrada,$fechaSalida,$tipoReserva,$tipoFrecuencia,$piso,$oficina,$estacionamientoAsignado,$estadoValidacion,$momentoValidacion,$codigoReserva,$patenteVehiculo);
		}
		return $reserva;
	}
	/*NUEVO METODO AGREGAR EL SISTEMA REAL*/
	
	//###################################### INICIO GESTION NICO #############################################


	public function listaVisitasPorValidarPeaton($nombre,$fecha=null,$piso=null)
	{
		$sql=conexionMySQLi::getInstance();
		$retorno= array();
		$arr= null;
		if ($fecha ==null&&$piso==null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.piso,reserva.oficina,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva <> 'Vehiculo'
			and reserva.estadoValidacion <> ?
			order by cliente.nombreEmpresa,visita.nombre ASC";

			$result= $sql->devDatos($consulta,array($nombre));
		}
		if ($fecha !=null&&$piso==null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.piso,reserva.oficina,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva <> 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";

			$result= $sql->devDatos($consulta,array($nombre));
		}
		if ($fecha ==null&&$piso!=null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.piso,reserva.oficina,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva <> 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and reserva.piso = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";

			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha !=null&&$piso!=null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.piso,reserva.oficina,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva <> 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and (DATE(reserva.fechaEntrada)=curdate())
			and reserva.piso = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";

			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}


		$result->bind_result($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,$piso,$oficina,
				$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);


		while ($result->fetch())
		{

			$arr[] = new verificacionValidacion($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,NULL,NULL,$piso,$oficina,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,NULL,NULL);
		}
		return $arr;
	}

	public function listaVisitasPorValidarVehiculo($nombre,$fecha=null,$piso=null)
	{
		$sql=conexionMySQLi::getInstance();
		$retorno= array();
		$arr = null;
		if ($fecha ==null&&$piso==null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
			reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva = 'Vehiculo'
			and reserva.estadoValidacion <> ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$result= $sql->devDatos($consulta,array($nombre));
		}

		if ($fecha !=null&&$piso==null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
			reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva = 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$result= $sql->devDatos($consulta,array($nombre));
		}
		if ($fecha ==null&&$piso!=null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
			reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva = 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and reserva.piso = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha !=null&&$piso!=null)
		{
			$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
			reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
			reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			from cliente,reserva,visita
			where reserva.idVisita=visita.idVisita
			and reserva.idCliente=cliente.idCliente
			and reserva.tipoReserva = 'Vehiculo'
			and reserva.estadoValidacion <> ?
			and reserva.piso = ?
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}




		$result->bind_result($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,$patente,$estacionamientoAsignado,$piso,
				$oficina,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);


		while ($result->fetch())
		{

			$arr[] = new verificacionValidacion($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,$patente,$estacionamientoAsignado,
					$piso,$oficina,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,NULL,NULL);
		}
		return $arr;
	}

public function listarVisitasPorValidarGlobal($nombre,$fecha=null,$piso=null,$frecuente=null,$trans=null,$emp=null,$apellido=null,$rutCap=null,$dvCap=null)
	{
		$sql=conexionMySQLi::getInstance();
		$retorno= array();
		$arr = null;
		$filtro = array();
		$consulta=null;
		$result=null;
		$caso=null;
		//echo $nombre."-nombre---".$fecha."-fecha---".$piso."-piso---".$frecuente."-frec---".$trans."-trans---".$emp."-emp---";
		$consultaBase="SELECT cliente.nombreEmpresa,reserva.idReserva, visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
		reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
		reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
		from cliente,reserva,visita
		where reserva.idVisita=visita.idVisita
		and DATE(reserva.fechaEntrada)= curdate()
		and reserva.idCliente=cliente.idCliente
		and reserva.estadoValidacion = ? ";
	
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
				
			$caso="order by cliente.nombreEmpresa, visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre));
		}
	
		if ($fecha!=null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre));
		}
		if ($fecha==null&&$piso!=null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.piso = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha==null&&$piso==null&&$frecuente!=null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente!=null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.piso = ?
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.piso = ?
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha!=null&&$piso==null&&$frecuente!=null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
				
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			//echo $consulta." ".$nombre."<br>";
			//$filtro = array($nombre);
			$result= $sql->devDatos($consulta,array($nombre));
				
				
		}
	
		if ($fecha==null&&$piso!=null&&$frecuente!=null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.piso = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans,$emp));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente!=null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$emp));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente==null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans,$emp));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente==null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente==null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$emp));
		}
		if ($fecha!=null&&$piso!=null&&$frecuente==null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.piso = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$emp));
		}
		if ($fecha!=null&&$piso==null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans,$emp));
		}
		if ($fecha!=null&&$piso==null&&$frecuente!=null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans));
		}
		if ($fecha!=null&&$piso==null&&$frecuente!=null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and DATE(reserva.fechaEntrada)= curdate()
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$emp));
		}
		if ($fecha!=null&&$piso==null&&$frecuente==null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans,$emp));
		}
		if ($fecha!=null&&$piso==null&&$frecuente==null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans));
		}
		if ($fecha!=null&&$piso==null&&$frecuente==null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and DATE(reserva.fechaEntrada)= curdate()
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$emp));
		}
		if ($fecha==null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans,$emp));
		}
		if ($fecha==null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.piso = ?
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans));
		}
		if ($fecha==null&&$piso!=null&&$frecuente!=null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.piso = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$emp));
		}
		if ($fecha==null&&$piso!=null&&$frecuente==null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.piso = ?
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans,$emp));
		}
		if ($fecha==null&&$piso!=null&&$frecuente==null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.piso = ?
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans));
		}
		if ($fecha==null&&$piso!=null&&$frecuente==null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.piso = ?
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$piso,$trans));
		}
		if ($fecha==null&&$piso==null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans,$emp));
		}
		if ($fecha==null&&$piso==null&&$frecuente!=null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans));
		}
		if ($fecha==null&&$piso==null&&$frecuente!=null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoFrecuencia = 1
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$emp));
		}
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans!=null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoReserva = ?
			and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans,$emp));
		}
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans!=null&&$emp==null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.tipoReserva = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$trans));
		}
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp!=null&&$apellido==null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and reserva.idCliente = ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$emp));
		}
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido!=null&&$rutCap==null&&$dvCap==null)
		{
			$caso="and visita.apellido LIKE ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$apellido."%"));
		}
		if ($fecha==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap!=null&&$dvCap!=null)
		{
			
			$caso="and visita.rut= ?
			and visita.dv= ?
			order by cliente.nombreEmpresa,visita.nombre ASC";
			$consulta=$consultaBase.$caso;
			$result= $sql->devDatos($consulta,array($nombre,$rutCap,$dvCap));
		}
	
		/*if ($fecha ==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null)$result= $sql->devDatos($consultaBase,array($nombre));
			else $result= $sql->devDatos($consulta,$filtro);
		*/
	
	
		$result->bind_result($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,$patente,$estacionamientoAsignado,$piso,$oficina,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);
	
	
		while ($result->fetch())
		{
	
			$arr[] = new verificacionValidacion($nombreEmpresa,$idReserva,$nombreVisita,$apellido,$rut,$dv,$pasaporte,$patente,$estacionamientoAsignado,
					$piso,$oficina,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,NULL,NULL);
		}
		//var_dump($arr);
		return $arr;
	}

	public function nombreReservasPorId($nombre)
	{
		$sql=conexionMySQLi::getInstance();

		$arr= array();
		$consulta="SELECT visita.nombre,visita.apellido
		from reserva,visita
		where visita.idVisita=reserva.idVisita
		and reserva.idReserva = ?";

		$result= $sql->devDatos($consulta,array($nombre));


		$result->bind_result($nombre,$apellido);

		if  ($result->fetch())
		{

			$arr[] =array($nombre,$apellido);

		}
		return $arr;
	}

	public function validarVisita($id,$op)
	{
		$visita=controlReserva::getReservaPorId($id);
		if($visita->gettipoReserva()=="Vehicular")
		{
			if($visita->getestacionamientoAsignado()!=null)	controlEstacionamiento::ocuparEstNumero($visita->getestacionamientoAsignado());
		}
		$sql=conexionMySQLi::getInstance();
		//echo $id."_".$op;
		//die();
		$consulta="UPDATE reserva,visita set estadoValidacion = \"Validada\",
		reserva.idOperador = '".$op."',reserva.momentoValidacion= NOW()
		where visita.idVisita=reserva.idVisita
		and reserva.idReserva = '".$id."' ";


		$retorno=$sql->ejecutarSentencia($consulta);


		return $retorno;
	}



	public function buscarVisitasVerificar($nombre)
	{
		$sql=conexionMySQLi::getInstance();
		$arr= array();
		$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva,visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
		reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.momentoValidacion,
		operador.ubicacionEdificio,usuarios.userFullName
		from cliente,reserva,visita,operador,usuarios
		where reserva.idVisita=visita.idVisita
		and reserva.idCliente=cliente.idCliente
		and reserva.idOperador = operador.idOperador
		and operador.idUser = usuarios.idUser
		and DATE(reserva.fechaEntrada)= curdate()
		and reserva.estadoValidacion = ?
		order by cliente.nombreEmpresa,visita.nombre ASC";

		$result= $sql->devDatos($consulta,array($nombre));
		//$result->bind_result($cliNombre,$visNombre,$resFechEnt,$resEstVal);

		$result->bind_result($nombreEmp,$idres,$nomVis,$apellidoVisita,$rut,$dv,$passport,$pat,$est,$piso,$oficina,$tipoFrecuencia,$fecEnt,$fecSal,$momVal,$ubica,$nomOpe);
		while ($result->fetch())
		{

			$arr[] =new verificacionValidacion($nombreEmp,$idres,$nomVis,$apellidoVisita,$rut,$dv,$passport,$pat,$est,$piso,$oficina,$tipoFrecuencia,
					$fecEnt,$fecSal,NULL,$momVal,$ubica,$nomOpe);

		}
		return $arr;
	}

	public function buscarVisitasModificar($nombre)
	{
		$sql=conexionMySQLi::getInstance();
		$arr= array();
		$consulta="SELECT cliente.nombreEmpresa,reserva.idReserva,visita.nombre,visita.apellido,visita.rut,visita.dv,visita.pasaporte,
		reserva.patenteVehiculo, reserva.estacionamientoAsignado,reserva.piso,reserva.oficina,reserva.tipoFrecuencia,
		reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion,reserva.momentoValidacion
		from cliente,reserva,visita
		where reserva.idVisita=visita.idVisita
		and reserva.idCliente=cliente.idCliente
		and DATE(reserva.fechaEntrada)= curdate()
		and reserva.estadoValidacion = ?

		order by cliente.nombreEmpresa,visita.nombre ASC";

		$result= $sql->devDatos($consulta,array($nombre));
		//$result->bind_result($cliNombre,$visNombre,$resFechEnt,$resEstVal);
		$result->bind_result($nombreEmp,$idRes,$nomVis,$apellidoVisita,$rut,$dv,$passport,$pat,$est,$piso,$ofi,$tpoFrec,$fecEnt,$fecSal,$estVal,$momVal);
		$i=0;
		while ($result->fetch())
		{

			$arr[] =new verificacionValidacion($nombreEmp,$idRes,$nomVis,$apellidoVisita,$rut,$dv,$passport,$pat,$est,$piso,
					$ofi,$tpoFrec,$fecEnt,$fecSal,$estVal,$momVal,NULL);

		}
		return $arr;
	}

	public function modificarVisita($id,$opc)
	{
		$sql=conexionMySQLi::getInstance();
		$arr= array();
		if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1") controlTarjeta::desOcupaTarjeta($id);
		$visita=controlReserva::getReservaPorId($id);
		if($visita->gettipoReserva()=="Vehicular")
		{
			controlEstacionamiento::desocuparEstNumero($visita->getestacionamientoAsignado());
		}
		switch ($opc)
		{
			case 1: {
				$estado="Reservada";break;
			}
			case 2: {
				$estado="Cancelada";break;
			}
			case 3: {
				$estado="Terminada";break;
			}
		}
		//echo $estado;
		$consulta="UPDATE gestkontrol.reserva,gestkontrol.visita set estadoValidacion = '".$estado."'
		where visita.idVisita=reserva.idVisita
		and reserva.idReserva = '".$id."'";

		$arr = $sql->ejecutarSentencia($consulta);
		return $arr;

	}

	public function existeVisitaHoy($rut,$dv,$estado=null)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT reserva.idReserva,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
			FROM reserva,visita
			WHERE DATE(reserva.fechaEntrada) = CURDATE()
			AND reserva.idVisita=visita.idVisita
			AND visita.rut = ?
			AND visita.dv = ?";
		if($estado!=null)
		{
			$consulta=$consulta." AND reserva.estadoValidacion = ?";
			$result= $sql->devDatos($consulta,array($rut,$dv,$estado));
		}
		else $result= $sql->devDatos($consulta,array($rut,$dv));
		$result->bind_result($idreserva,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);
		while ($result->fetch())
			$retorno[]=new verificacionValidacion(null,$idreserva,null,null,null,null,null,null,null,null,null,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,null,null);
		return $retorno;
	}
	public function existeVisitaIntervalo($rut,$dv)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT reserva.idReserva,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
		FROM reserva,visita
		WHERE DATE(reserva.fechaEntrada) <= CURDATE()
		AND DATE(reserva.fechaSalida)>= CURDATE()
		AND reserva.idVisita=visita.idVisita
		AND visita.rut = ?
		AND visita.dv = ?";
		$result= $sql->devDatos($consulta,array($rut,$dv));
		$result->bind_result($idreserva,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);
		if ($result->fetch())
			$retorno=new verificacionValidacion(null,$idreserva,null,null,null,null,null,null,null,null,null,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,null,null);
		return $retorno;
	}


	public function existeVisitaFrecuenteEnDia($idreserva,$dia)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT reservaFrecuente.idReserva
		FROM reservaFrecuente,reserva
		WHERE ".$dia." = 1
		AND CURDATE() <= DATE(reserva.fechaSalida)
		AND reservaFrecuente.idReserva= ?";
		$result= $sql->devDatos($consulta,array($idreserva));
		$result->bind_result($idreservaFrecuente);
		if ($result->fetch())$retorno=array($idreservaFrecuente);
		return $retorno;
	}
	public function listaPisoReserva($vac)
	{

		$retorno=array();
		$sql = conexionMySQLi::getInstance();
		$consulta = "SELECT piso
		FROM reserva
		WHERE piso <> ?
		AND estadoValidacion <> 'Validada'
		GROUP BY piso
		ORDER BY piso ASC ";
		$result = $sql->devDatos($consulta,array($vac));
		$result->bind_result($piso);
		while ($result->fetch())
		{
			$retorno[] = array($piso);
		}
		return $retorno;
	}

	public function getFrecuenciaPorId($id)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT tipoFrecuencia
		FROM reserva
		WHERE idReserva= ?
		AND CURDATE() <= DATE(reserva.fechaSalida)";
		$result= $sql->devDatos($consulta,array($id));
		$result->bind_result($frecuencia);
		if ($result->fetch())$retorno=$frecuencia;
		return $retorno;
	}



	public function getDetalleFrecuencia($id)
	{
		$retorno=array();
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT lunes,martes,miercoles,jueves,viernes,sabado,domingo
		FROM reservaFrecuente,reserva
		WHERE reserva.idReserva = reservaFrecuente.idReserva
		AND reserva.idVisita = ?";
		$result= $sql->devDatos($consulta,array($id));
		$result->bind_result($lun,$mar,$mie,$jue,$vie,$sab,$dom);
		if ($result->fetch())$retorno=new reserva(null,null,$lun,$mar,$mie,$jue,$vie,$sab,$dom);
		return $retorno;
	}

	public function getReservaPorId($id)
	{
		$retorno=array();
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT idCliente,idOperador,idVisita,fechaSalida,tipoReserva,piso,oficina,estacionaMientoAsignado,patenteVehiculo
		FROM reserva
		WHERE idReserva= ?";
		$result= $sql->devDatos($consulta,array($id));
		$result->bind_result($idcli,$idop,$idvi,$fecSal,$tipRe,$piso,$ofi,$estAsig,$pat);
		if ($result->fetch())$retorno=new reserva(null,$idcli,$idop,$idvi,null,$fecSal,$tipRe,null,$piso,$ofi,$estAsig,null,null,null,$pat);
		return $retorno;
	}

	public function getidVisita($id)
	{
		$retorno=array();
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT idVisita
		FROM reserva
		WHERE idReserva = ?";
		$result= $sql->devDatos($consulta,array($id));
		$result->bind_result($idvisita);
		if ($result->fetch())$retorno=$idvisita;
		return $retorno;
	}

	public function actualizaPatente($idRes,$patente)
	{
		$sql=conexionMySQLi::getInstance();
		//echo $id."_".$op;
		//die();

		$consulta="UPDATE reserva
		SET patenteVehiculo = '".$patente."'
		where idReserva= '".$idRes."'";


		return $sql->ejecutarSentencia($consulta);
	}

	public function actualizaEstAsignado($idRes,$numEst)
	{
		$sql=conexionMySQLi::getInstance();
		//echo $id."_".$op;
		//die();

		$consulta="UPDATE reserva
		SET estacionamientoAsignado = '".$numEst."'
		where idReserva= '".$idRes."'";


		return $sql->ejecutarSentencia($consulta);
	}
	public function existeVisitaHoyPorId($id)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT reserva.idReserva,reserva.tipoFrecuencia,reserva.fechaEntrada,reserva.fechaSalida,reserva.estadoValidacion
		FROM reserva,visita
		WHERE DATE(reserva.fechaEntrada) = CURDATE()
		AND reserva.idVisita=visita.idVisita
		AND reserva.idReserva = ?";
		$result= $sql->devDatos($consulta,array($id));
		$result->bind_result($idreserva,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion);
		if ($result->fetch())
			$retorno=new verificacionValidacion(null,$idreserva,null,null,null,null,null,null,null,null,null,$tipoFrecuencia,$fechaEntrada,$fechaSalida,$estadoValidacion,null,null);
		return $retorno;
	}
	public function contadorVisitasHoy($opcion=null,$idCliente)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$consulta="SELECT count(reserva.idReserva) as contador
		FROM reserva		
		WHERE idCliente = ? 
		AND estadoValidacion= 'Reservada'
		AND DATE(reserva.fechaEntrada) = CURDATE() ";
		if($opcion!=null)
		{
			switch ($opcion)
			{
				case "manana": 
					$consulta=$consulta."AND HOUR(`fechaEntrada`) <12";
					break;
				case "tarde":
					$consulta=$consulta."AND HOUR(`fechaEntrada`) >=12";
					break;
				
			}
		}
		$result= $sql->devDatos($consulta,$idCliente);
		$result->bind_result($contador);
		if ($result->fetch()) return $contador;
		else $retorno="-1";
		return $retorno;
	}
	public function contadorVisitasSemana($opcion=null,$idCliente)
	{
		$retorno=null;
		$sql=conexionMySQLi::getInstance();
		$primerDia=date('Y-m-d', strtotime('Monday this week'));
		$ultimoDia=date('Y-m-d', strtotime('Sunday this week'));
		$consulta="SELECT count(reserva.idReserva) as contador
		FROM reserva
		WHERE idCliente = ? 
		AND estadoValidacion= 'Reservada' 
		AND DATE(fechaEntrada) >= DATE(?) 
		AND DATE(fechaEntrada)<=DATE(?) ";
		if($opcion!=null)
		{
			switch ($opcion)
			{
				case "manana":
					$consulta=$consulta."AND HOUR(`fechaEntrada`) < 12";
					break;
				case "tarde":
					$consulta=$consulta."AND HOUR(`fechaEntrada`) >= 12";
					break;
		
			}
		}
		
		$result= $sql->devDatos($consulta,array($idCliente,$primerDia,$ultimoDia));
		$result->bind_result($contador);
		if ($result->fetch()) return $contador;
		else $retorno="-1";
		return $retorno;
	}


	//######################## FIN GESTION NICO ################################33

}
?>
