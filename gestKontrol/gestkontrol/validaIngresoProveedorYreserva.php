<?php

require_once ('src/classes/controlNumerico.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/fechaHora.php');
require_once ('src/classes/controlReserva.class.php');

if(isset($_POST))
{
	
	switch ($_POST)
	{
		case isset($_POST["idClienteaProveedor"]):
			
			//print_r($_POST);
			//die();
			
			$idCliente = $_POST["idClienteaProveedor"];
			$EmpresaProv = null;
			$rutProv = null;
			$dvProv = null;
			$rubro = null;
			$direccionPro = null;
			$telefonoProv = null;
			$celularProv = null;
			$correoProv = null;
			$tipoVisita = "proveedor";
			$corteRut = array();
			$dataProveedor = array();
			
			if($_POST["NombreProveedor"]!=null)
			{
				$EmpresaProv = trim($_POST["NombreProveedor"]);
				$direccionPro = trim($_POST["direccionProveedor"]);
				$telefonoProv = trim($_POST["telefenoProveedor"]);
				$rubro = trim($_POST["RubroProveedor"]);
				//$celularProv = $_POST["celularProveedor"];
				$correoProv = trim($_POST["correoProveedor"]);
				
				if($_POST["rutProveedor"]!=null)
				{
					$corteRut = split("-",$_POST["rutProveedor"]);
					
					if(strlen($corteRut[0])>0 && is_numeric($corteRut[0]))
					{
						if(controlNumerico::validadorRut($corteRut[0],$corteRut[1]))
						{
							$rutProv = trim($corteRut[0]);
							$dvProv = trim($corteRut[1]);
						}	
					}
				}
				//rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
				$dataProveedor = array($rutProv,$dvProv,null,null,null,$direccionPro,$telefonoProv,$rubro,$correoProv,null,$tipoVisita,$EmpresaProv);
				//print_r($_POST);print_r($dataProveedor);die();
					//echo controlVisita::insertVisita($dataProveedor,$idCliente);			
				switch(controlVisita::insertVisita($dataProveedor,$idCliente)) //controlVisita::insertVisita($data,$_POST["idcliente"])
				{
					case 1:
				
						echo "1"; // se realizo ok
							
						break;
				
					case "-2":
							
						echo "-2";	// La persona ya esta en el sistema
							
						break;
							
					case 3:
							
						echo "3";   // se ingreso correctamente los datos personales de la visita, pero no se podrá realizar la reserva rapida, por que no posee el rut de la visita o pasaporte
							
						break;
							
					default:
							
						echo "2"; //Problemas con el SQL
				}
				
			}
			else
			{
				// sin nombre!!! la empresa es campo critico
			}
			
			
			break;
			
		case isset($_POST["idProveedorPerfil"]):
			
			//print_r($_POST);die();
			
			$idProveedor = $_POST["idProveedorPerfil"];
			$nombreProveedor = trim($_POST["NombreProveedor"]);
			$rutProveedor = null;
			$dvProveedor = null;
			$rubroProveedor = trim($_POST["RubroProveedor"]);
			$direccionProveedor = trim($_POST["direccionProveedor"]);
			$telefonoProveedor = trim($_POST["telefenoProveedor"]);
			$correoProveedor = trim($_POST["correoProveedor"]);
			$out = null;
			$dataUpdateProveedorPerfil = array();
			
			if($nombreProveedor!=null)
			{
				if($_POST["rutProveedor"]!=null)
				{	
					$corteRut = split("-",$_POST["rutProveedor"]);
					if(strlen($corteRut[0])>0 && is_numeric($corteRut[0]) && controlNumerico::validadorRut($corteRut[0],$corteRut[1]))
					{
						$rutProveedor = $corteRut[0];
						$dvProveedor = $corteRut[1];
						
					}
					else 
					{
						$out = -3;
					}
				}
				//UPDATE visita SET rut = ?,dv = ?,pasaporte = ?,nombre =?,apellido = ?, contacto = ?,telefono= ?,empresa = ?,rubro = ?,direccion = ? WHERE idVisita = ?
				
				$dataUpdateProveedorPerfil = array($rutProveedor,$dvProveedor,null,null,null,$correoProveedor,$telefonoProveedor,$nombreProveedor,$rubroProveedor,$direccionProveedor,$idProveedor);
				
				$resultado = controlVisita::editaVisita($dataUpdateProveedorPerfil);
				
				switch ($resultado)
				{
					case 1:
						
						if($out!=null)
						{
							echo 3;
						}
						else{echo 1;}
						
						break;
					default:

						echo -5;
				}
			}
			break;
			
		case isset($_POST["idProveedorReserva"]):
			
			//print_r($_POST);die();
			
			$lunes = null;
			$martes = null;
			$miercoles = null;
			$jueves = null;
			$viernes = null;
			$sabado = null;
			$domingo = null;
			$siDias = false;
			$dias = array();
			$data = array();
			$resultado = null;
			$reserva = null;
			$tipoReserva = "Peatonal";
			$estadoValidacion ="Reservada";
			$tipoFrecuencia = 0;
			$horaEstimada = null;
			$fechaEsporadicaPr = null;
			$fechaInicio = null;
			$fechaTermino = null;
			$parmanencia = null;
			$pisoP = null;
			$oficinaP = null;
			$patentenP = isset($_POST["patenteP"])?$_POST["patenteP"]: null;
			$idCliente = isset($_POST["idCliente"]) && $_POST["idCliente"]!=null? $_POST["idCliente"]: null;
			$idProveedor = isset($_POST["idProveedorReserva"]) && $_POST["idProveedorReserva"]!=null? $_POST["idProveedorReserva"]: null;
			$estacionamientoP = isset($_POST["estacionamientosP"])? $_POST["estacionamientosP"]: null; 
			$reserva = controlReserva::isHaveReserva($idCliente,$idProveedor);
			
			if($idCliente!=null && $idProveedor!=null)
			{
				if($patentenP!=null)
				{
					$tipoReserva = "Vehicular";
					
				}
				
				if($_POST["radioOpcion"]=="Frecuente")
				{
					$tipoFrecuencia = 1;
					if(isset($_POST["lunes"]))
					{
						$lunes = true;
						$siDias = true;
					}
					if(isset($_POST["martes"]))
					{
						$martes = true;
						$siDias = true;
					}
					if(isset($_POST["miercoles"]))
					{
						$miercoles = true;
						$siDias = true;
					
					}
					if(isset($_POST["jueves"]))
					{
						$jueves = true;
						$siDias = true;
					
					}
					
					if(isset($_POST["viernes"]))
					{
						$viernes = true;
						$siDias = true;
					
					}
					if(isset($_POST["sabado"]))
					{
						$sabado = true;
						$siDias = true;
					
					}
					
					if(isset($_POST["domingo"]))
					{
						$domingo = true;
						$siDias = true;
					
					}
					if($siDias)
					{
						$dias = array("lunes"=>$lunes,"martes"=>$martes,"miercoles"=>$miercoles,"jueves"=>$jueves,"viernes"=>$viernes,"sabado"=>$sabado,"domingo"=>$domingo);
						
						$fechaInicio = $_POST["fechaInicio"];
						$fechaTermino = $_POST["fechaTermino"];
						$horaEstimada = $_POST["horaEstimada"];
						//$parmanencia = $_POST["permanencia"];
						$pisoP = $_POST["pisoP"];
						$oficinaP = $_POST["OficinaP"];
						$patentenP = $_POST["patenteP"];
						$estacionamientoP = isset($_POST["estacionamientosP"])? $_POST["estacionamientosP"]: null;
						
						$dataupdate = array();
						$diasupdate = array();
						$diasupdateE = array();
						if($fechaInicio!=null && $fechaTermino!=null && $horaEstimada!=null)
						{
							
							$data = array($idCliente,null,$idProveedor,$fechaInicio." ".$horaEstimada,$fechaTermino,$tipoReserva,$tipoFrecuencia,$pisoP,$oficinaP,$estacionamientoP,$estadoValidacion,null,$idProveedor,$patentenP);
							//print_r($data);
							//print_r($dias);
							
							if($reserva!= null)
							{
								//fechaEntrada = ?,fechaSalida = ?,tipoFrecuencia = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?
								$dataupdate = array($fechaInicio." ".$horaEstimada,$fechaTermino,$tipoFrecuencia,$tipoReserva,$pisoP,$oficinaP,$estacionamientoP,$patentenP,$idCliente,$idProveedor,$reserva->getidReserva());
								$diasupdate = array($lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$reserva->getidReserva());
								
								if($reserva->getttipoFrecuencia()==1)
								{
									$resultado = controlReserva::updateReserva($dataupdate,$diasupdate,null); // updatea una reserva frecuente siendo ya frecuente
								}
								else
								{
									//$diasupdateE = array($reserva->getidReserva(),$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
									$resultado	= controlReserva::upadateReserva($dataupdate,$diasupdate,1); // de esporadica pasa a frecuente
								}
							}
							else
							{
								//$resultado = controlReserva::insertReservaFrecuente($data,$dias);
								$resultado = controlReserva::insertReservaFrecuente($data,$dias);
								if($resultado>0)
								{
									$resultado = 1;
								}
							}
							
							//$resultado = controlReserva::insertReservaFrecuente($data,$dias);
						}
						else
						{
							$resultado = -2; // no esta llenos todos los campos necesarios para realizar la reserva
						}
						
					}
					else 
					{
						$resultado = -1; // no se ingresaron los dias de la proveedor frecuente
					}
					echo $resultado;
				}
				else 
				{
					if($_POST["radioOpcion"]=="solo")
					{
						//print_r($_POST);
						$horaEstimada = $_POST["horaEstimada"];
						$fechaEsporadicaPr = $_POST["fechaPr"];
						//$parmanencia = $_POST["permanencia"];
						$pisoP = $_POST["pisoP"];
						$oficinaP = $_POST["OficinaP"];
						$patentenP = $_POST["patenteP"];
						$estacionamientoP = isset($_POST["estacionamientosP"])? $_POST["estacionamientosP"]: null;
						//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
						$data = array($idCliente,null,$idProveedor,$fechaEsporadicaPr." ".$horaEstimada,null,$tipoReserva,$tipoFrecuencia,$pisoP,$oficinaP,$estacionamientoP,$estadoValidacion,null,$idProveedor,$patentenP);
						$dataupdate = null;
						if($horaEstimada!=null && $fechaEsporadicaPr!=null)
						{
							if($reserva!=null) //
							{
								
								$dataupdate = array($fechaEsporadicaPr." ".$horaEstimada,null,$tipoFrecuencia,$tipoReserva,$pisoP,$oficinaP,$estacionamientoP,$patentenP,$idCliente,$idProveedor,$reserva->getidReserva());
								if($reserva->getttipoFrecuencia()==0)
								{
									$resultado =  controlReserva::updateReserva($dataupdate,null,null);
								}
								else 
								{
									$resultado = controlReserva::updateReserva($dataupdate,null,1);
								}
							}
							else 
							{
							   $resultado = controlReserva::insertaReserva($data);
							   if($resultado>0)
							   {
								$resultado = 1;
							   }
								
							}
						}
						else
						{
							$resultado = -1;
						}
					}
					
					echo $resultado;	
				}
			}
			
			
			
			break;
		
	}
}


?>
