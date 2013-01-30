<?php
require_once ('src/classes/controlUsuario.class.php');
require_once ("src/classes/controlVisita.class.php");
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlNumerico.class.php');
require_once ('src/classes/fechaHora.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/sendEmail.class.php'); //agrear esta linea al a sistema en produccion
require_once ('src/classes/generaQR.class.php');   //agrear esta linea al a sistema en produccion
require_once ('src/classes/controlConfiguracionGK.class.php'); //agrear esta linea al a sistema en produccion
/*
 * esta script php realizar el ingreso tanto de ingreso de visitas como la reserva.
 * 
 */
if($_POST!=null)
{
 $dataConfiCorreo = controlConfiguracionGK::getConfiguracion(null,"Correos",null,null,null,null,"edita visita/reserva",null); // se encarga de cargar los config(activa o desactiva el envio de correos x ejemplo)
 	
	switch ($_POST)
	{
		case isset($_POST["visitaNuevaDt"]):
		
			
			/*echo "<pre>";
				print_r($_POST);
			echo "<pre/>";
			die();*/
			//rut,dv,pasaporte,nombre,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
		$rutVisita = null;
		$dvVisita = null;
		$pasaporte = null;
		$conOsinrut = 0;
		$verficaSiEstaElCorreo = null;
		$respuesta = null;
		
		if($_POST["rutDaVi"]!=null)
		{
			$rutc = split("-",$_POST["rutDaVi"]);
			
			
				if( isset($rutc[0]) && (strlen($rutc[0]>0)) && is_numeric($rutc[0]))
				{
					if(controlNumerico::validadorRut($rutc[0],$rutc[1]))
					{
						$rutVisita = trim($rutc[0]);
						$dvVisita = trim($rutc[1]);
						$conOsinrut = 1;
					}
					
					
				}
		}
		if($_POST["pasaporte"]!=null && (strlen($_POST["pasaporte"])<45))
		{
			$pasaporte = trim($_POST["pasaporte"]);
			$conOsinrut = 1;
		}	
		if( ($_POST["nombre"]!=null && is_string($_POST["nombre"])) && ($_POST["apellido"]!=null && is_string($_POST["apellido"])) ) // (($_POST["rutDaVi"]!= null) || $_POST["pasaporte"]!= null) && (strpos($_POST["rutDaVi"], "-") == 8) && ($_POST["nombre"] || $_POST["apellido"]))
		{
			//rut,dv,pasaporte,nombre,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
			
			$nombre = trim($_POST["nombre"]);
			
			$apellido = trim($_POST["apellido"]);
			$empresa = trim($_POST["empresa"]);
			$telefono = trim($_POST["telefono"]);
			$correo =   trim($_POST["correo"]); //agrear esta linea al a sistema en produccion
			//if($correo!=null && $correo)
			$data = array($rutVisita,$dvVisita,$pasaporte,$nombre,$apellido,null,$telefono,null,$correo,null,"normal",$empresa);
			//print_r($data);
			//print_r(controlVisita::insertVisita($data,$_POST["idcliente"]));
			//print_r(controlVisita::insertVisita($data,$_POST["idcliente"]));
			//echo "idcliente:".$_POST["idcliente"];//controlVisita::insertVisita($data,$_POST["idcliente"]));
			//die();
			/*$datos = controlVisita::insertVisita($data,$_POST["idcliente"]);
			if(count($datos)>0)
			{
				print_r($datos);
			}
			else
			{
				echo "solo pruebas";
			}*/
			$respuesta = controlVisita::insertVisita($data,$_POST["idcliente"]);  //agrear esta linea al a sistema en produccion
			if($respuesta=="1" && ($correo==null || $correo==""))//agrear esta linea al a sistema en produccion
			{
				$respuesta = "4";
			}
			if($respuesta=="3" && ($correo==null || $correo==""))//agrear esta linea al a sistema en produccion
			{
				$respuesta = "5";
			}
			
			
				switch($respuesta) //controlVisita::insertVisita($data,$_POST["idcliente"])
				{
					case 1:
						
						echo "1"; // se realizo ok
					
						break;
					case 4:
							echo "4"; //agrear esta linea al a sistema en produccion
							
						break;
						
					case 5:
							echo "5";//agrear esta linea al a sistema en produccion
							
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
			echo "0";	  // 0 No se han enviado todo los datos.
		} 
		break;
		
		case isset($_POST["rutvi"]): //con el id visita podemos deducir que se esta efectuando una reserva y si ha días asociados es una visita frecuente
			
			//print_r($_POST);
			//die();
			
			
			$data = array();
			$dia = array();
			$lunes = null;
			$martes = null;
			$miercoles = null;
			$jueves = null;
			$viernes = null;
			$sabado = null;
			$domingo = null;
			$frecuencia = 0;
			$peatonOauto = "Peatonal"; // 0 peatonal y 1 es vehicular
			$data = null;
			$dia = array();
			$fecha = new FechaHora();
			$rutdv = split("-",$_POST["rutvi"]);
			$visita = controlVisita::verificaSiRutNoEx($rutdv[0],null,null,null,$_POST["idcliente"]);//($rutdv[0]);
			$estacionamiento = isset($_POST["estacionamientosR"])? $_POST["estacionamientosR"] : null; 
			$patente = isset($_POST["patenteR"])? $_POST["patenteR"] : null;
			$controlEsta = 0;
			$cliente = controlCliente::getCliente($_POST["idcliente"]);
			$nombreImagen = null;
			$nombreImagen = "QR_";
			$flagHoy = null;
			//print_r($visita);
			//die("asdasd");
			
			/*
			 * Peatonal
			 * Vehicular
			 * Cliclista
			 * etc
			 * */
			if($visita!=null) // $visita!=null
			{	
				
				
					if(isset($_POST["lunes"]))
					{
						$lunes = true;
						$frecuencia = 1;
						
					}
					if(isset($_POST["martes"]))
					{
						$martes = true;
						$frecuencia = 1;
					}
					if(isset($_POST["miercoles"]))
					{
						$miercoles = true;
						$frecuencia = 1;
					}
					if(isset($_POST["jueves"]))
					{
						$jueves = true;
						$frecuencia = 1;
					}
					
					if(isset($_POST["viernes"]))
					{
						$viernes = true;
						$frecuencia = 1;
					}
					if(isset($_POST["sabado"]))
					{
						$sabado = true;
						$frecuencia = 1;
					}	
					
					if(isset($_POST["domingo"]))					
					{
						$domingo = true;
						$frecuencia = 1;
					}
				
					if(isset($_POST["radioPV"]) && $_POST["radioPV"]=="vehicular")
					{
						if($estacionamiento!=0 && $estacionamiento!=null)
						{
							$peatonOauto = "Vehicular";
						}
						else
						{
							$controlEsta= -5;
						}
					}
					
					
				//Arreglo de la hora para inserta en la tabla reserva
					
			//
			//idReserva,idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
				/*
				 * campos estadoValidación: Validada, Reservada, Cancelada y Terminada
				 */
					if($frecuencia==1 && $_POST["radioOpcion"]=="Frecuente") //Frecuente
					{
						//echo "Frecuente";
						//print_r($_POST);die();
						if($_POST["horaEstimadaRR"]!=null)
						{
							$corte = split(" ",$_POST["horaEstimadaRR"]);
							$fechaInicio = $fecha->inverFecha($_POST["fechaInicio"])." ".$corte[0];
							$fechaTermino = $fecha->inverFecha($_POST["fechaTermino"]);
							
							$data = array($_POST["idcliente"],null,$visita->getidVisista(),$fechaInicio,$fechaTermino,$peatonOauto,$frecuencia,$_POST["PisoR"],$_POST["OficinaR"],$estacionamiento,"Reservada",null,$visita->getidVisista(),$patente);
							
							$dia = array("lunes"=>$lunes,"martes"=>$martes,"miercoles"=>$miercoles,"jueves"=>$jueves,"viernes"=>$viernes,"sabado"=>$sabado,"domingo"=>$domingo);
							//print_r($data);
							//print_r($dia);
							//print_r($visita);
							//die();
							$idR = null;
							
							if($controlEsta==0)
							{
								$idR = controlReserva::insertReservaFrecuente($data,$dia); 
								if($idR>0)
								{
									if($dataConfiCorreo->getestado()>0)
									{
										$flagHoy = generaQR::creaQR($nombreImagen.$idR."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$frecuencia."_fec;".$_POST["fechaInicio"],null,"codigo".$nombreImagen.$idR."_".$visita->getidVisista().".png");
										//"DreamIT","Gonzalo Heredia","10/10/2012",34,340,"Peatonal"
										$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$_POST["fechaInicio"]." ".$corte[0],$_POST["fechaTermino"],$_POST["PisoR"],$_POST["OficinaR"],$peatonOauto,$estacionamiento);
										sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
									}	
									
									echo "1"; // se realizo correctamente la inserción.
								}
								else
								{
									echo "-1"; //Problemas en la inserción . . . .
								}
							}
							else
							{
								echo $controlEsta;
							}	
						}
						else
						{
							echo "-3"; // no se han ingresado la hora estimada de ingreso. fechaEntradaRFirstf
						}	
					}
					else
					{
						//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo 
						//fechaEntradaRFirstE
						//print_r($_POST);
						//echo "solo una ves"."<br>";
						//print_r($_POST);
						//die();
						
						if($_POST["fechaEntrada"]!=null && $_POST["horaEstimadaRR"]!=null)
						{
							$fechaEntradaRfE = $fecha->inverFecha($_POST["fechaEntrada"]);
							
							$arrHoraEntradaRfE = split(" ",$_POST["horaEstimadaRR"]);
							//$arrHoraSalidaRfE = split(" ",$_POST["horaEstimada"]);
							
							//$horaEntradaRfE = $arrHoraEntradaRfE[0];
							$fechaEnHoraRfE = $fechaEntradaRfE." ".$arrHoraEntradaRfE[0];
							$fechaEnHoraRfESa =null; //$fechaEntradaRfE." ".$arrHoraSalidaRfE[0];
							$data = array($_POST["idcliente"],null,$visita->getidVisista(),$fechaEnHoraRfE,$fechaEnHoraRfESa,$peatonOauto,$frecuencia,$_POST["PisoR"],$_POST["OficinaR"],$estacionamiento,"Reservada",null,$visita->getidVisista(),$patente);
							//print_r($data);
							//print_r($visita);
							//die();
							
							if($controlEsta==0)
							{
								$idR = controlReserva::insertaReserva($data);
								if($idR>0)
								{
									if($dataConfiCorreo->getestado()>0)
									{
										$flagHoy = generaQR::creaQR($nombreImagen.$idR."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$frecuencia."_fec;".$_POST["fechaEntrada"],null,"codigo".$nombreImagen.$idR."_".$visita->getidVisista().".png");
										//"DreamIT","Gonzalo Heredia","10/10/2012",34,340,"Peatonal"
										$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$_POST["fechaEntrada"]." ".$arrHoraEntradaRfE[0],$_POST["fechaEntrada"],$_POST["PisoR"],$_POST["OficinaR"],$peatonOauto,$estacionamiento);
										sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
									}
									echo "2"; //reserva esporadica exitosa
								}
								else
								{
									echo "-2"; // problemas en la reserva esporadica;
								}
							}
							else
							{
								echo $controlEsta;
							}	
						}
						else
						{
							echo "-4"; // debe completar la fecha y la hora del ingreso la visita 
						}	
					}
			
			}
			else
			{
				echo "mmm"; // problemas con la inserción de la visita.
			}
			/*echo "<pre>";
			print_r($_POST);
			print_r($dia);
			echo "</pre>";*/
			
			break;
			
		case isset($_POST["editvpersonal"]): //captura los datos personales y realiza el update para una visita.
				
			  $nombre = trim($_POST["enombre"]);
			  $apellido = trim($_POST["eapellido"]);
			  
			  $rut = null;
			  $dv = null;
			  $opcional = 1;
			  
			  if($_POST["erut"]!=null && isset($_POST["erut"]) && $_POST["erut"]!="S/R")
			  {
			  	$rutcompleto =split("-",trim($_POST["erut"]));
			  	//print_r($rutcompleto);
			  	//die();
			  	if(is_numeric($rutcompleto[0]) && isset($rutcompleto[1]) && controlNumerico::validadorRut($rutcompleto[0],$rutcompleto[1]))
			  	{
				  
				  $rut = $rutcompleto[0];
				  $dv = $rutcompleto[1];
				  
			  	} 
			  	else
			  	{
			  		$opcional = 3;
			  	} 
			  }
			  $pasaporte = trim($_POST["epasaporte"]);
			  $rutaImagen = null; // por el momento
			  $correo = trim($_POST["ecorreo"]);
			  $telefono = trim($_POST["telefono"]);
			  
			  $empresa = trim($_POST["empresa"]);
			  
			  $idVisita = $_POST["editvpersonal"];
			  
			  if( ($nombre!=null && is_string($nombre)) && ($apellido!=null && is_string($apellido)))
			  {
			  	
			  
				  if(controlVisita::editaVisita(array($rut,$dv,$pasaporte,$nombre,$apellido,$correo,$telefono,$empresa,null,null,$idVisita))==1)
				  {
				  	echo $opcional;
				  }
				  else
				  {
				  	echo "-1";
				  }
			  }
			  else
			  {
			  	"-2"; // no lleno el nombre ni el apellido!!! campos clave
			  }
			  
			break;
			
		case isset($_POST["editreservaFrecuente"]):

				
				//print_r($_POST); //edicion de una reserva...... frecuente
				//die();
				
				/*---------*/
				
				$fechahora = new FechaHora();
				$tipoFrecuencia = 0;
				$controlEsta = 0;
				if($_POST["radioOpcion"]=="Frecuente")
				{
					$tipoFrecuencia = 1;
				}
				
				$reserva = controlReserva::isHaveReserva($_POST["idcliente"],$_POST["idvit"]);
				$tipoReserva = "Peatonal";
				$estadiValidacion = "Reservada"; 
				$lunes = null;
				$martes = null;
				$miercoles = null;
				$jueves = null;
				$viernes = null;
				$sabado = null;
				$domingo = null;
				$visita = controlVisita::getVisitaWithId($_POST["idvit"]);
				$hora = split(" ", $_POST["horaIngreso"]);
				$dia = null;
				$siDias = false;
				
				$cliente = controlCliente::getCliente($_POST["idcliente"]);
				$nombreImagen = null;
				$nombreImagen = "QR_";
				$flagHoy = null;
				
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
				//print_r($reserva);
				//echo $tipoReserva;
					if($_POST["radioOpcion"]=="Frecuente")
					{
					
						$cambioFrecuencia = null;
						if($siDias && $hora[0]!=null && $_POST["fechaInicio"]!=null)
						{
							//$fechaInicio = $fechahora->inverFecha($_POST["fechaInicio"]);
							//$fechaTermino = $fechahora->inverFecha($_POST["fechaTermino"]);
								if(isset($_POST["radioPV"]) && $_POST["radioPV"]=="vehicular") // este filtro puede ser que no sea necesario, conversar cliente.
								{
									if($_POST["estacionamientoE"]!=0)
									{
										$tipoReserva = "Vehicular";
									}
									else
									{
										//echo "-4"; //Ingrese la patente y el estacionamiento para realizar la reserva vehicular;
										$controlEsta = -4;
									}
					
									
								}
						
							if(count($reserva)>0)
							{	//print_r($reserva);
								//UPDATE reserva SET fechaEntrada = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?
							
								//print_r($_POST);
								//print_r($reserva);
							
									$dataReserva = array($_POST["fechaInicio"]." ".$hora[0],$_POST["fechaTermino"],$tipoFrecuencia,$tipoReserva,$_POST["selecPiso"],$_POST["oficinaRe"],$_POST["estacionamientoE"],$_POST["patente"],$_POST["idcliente"],$_POST["idvit"],$reserva->getidReserva());
									if($reserva->getttipoFrecuencia()==0)
									{
										//echo "tipoFrecuencia".$reserva->getidreservaFrecuente();
										$cambioFrecuencia = 1;
									}		
								
									//die();
									//UPDATE reservaFrecuente SET lunes=?,martes=?,miercoles=?,jueves=?,viernes=?,sabado=?,domingo=? WHERE idReserva = ?
									$dataReFrecuente = array($lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo,$reserva->getidReserva());
									//print_r($dataReserva);
									//print_r($dataReFrecuente);
									//die();
									if($controlEsta==0)
									{
										if(controlReserva::updateReserva($dataReserva,$dataReFrecuente,$cambioFrecuencia)==1)
										{
											if($dataConfiCorreo->getestado()>0)
											{
												$flagHoy = generaQR::creaQR($nombreImagen.$reserva->getidReserva()."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$tipoFrecuencia."_fec;".$_POST["fechaInicio"],null,"codigo".$nombreImagen.$reserva->getidReserva()."_".$visita->getidVisista().".png");
												
												$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$_POST["fechaInicio"]." ".$hora[0],$_POST["fechaTermino"],$_POST["selecPiso"],$_POST["oficinaRe"],$tipoReserva,$_POST["estacionamientoE"]);
												sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
											}
											
											echo "1";
										
										}
										else{echo "-1";}
									}
									else
									{
										echo $controlEsta;
									}
							}
							else
							{
								//echo "no hay reserva";
								//die();
								//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
						
									$dataReserva = array($_POST["idcliente"],null,$_POST["idvit"],$fechahora->getFechaI()." ".$hora[0],$_POST["fechaTermino"],$tipoReserva,$tipoFrecuencia,$_POST["selecPiso"],$_POST["oficinaRe"],$_POST["estacionamientoE"],$estadiValidacion,null,$_POST["idvit"],$_POST["patente"]);
									$dia = array("lunes"=>$lunes,"martes"=>$martes,"miercoles"=>$miercoles,"jueves"=>$jueves,"viernes"=>$viernes,"sabado"=>$sabado,"domingo"=>$domingo);
									$idR = null;
									//print_r($dataReserva);
									//print_r($dia);
									if($controlEsta==0)
									{
										$idR = controlReserva::insertReservaFrecuente($dataReserva,$dia); 
										if($idR>0)
										{
											if($dataConfiCorreo->getestado()>0)
											{
												$flagHoy = generaQR::creaQR($nombreImagen.$idR."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$tipoFrecuencia."_fec;".$_POST["fechaInicio"],null,"codigo".$nombreImagen.$idR."_".$visita->getidVisista().".png");
												//"DreamIT","Gonzalo Heredia","10/10/2012",34,340,"Peatonal"
												$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$_POST["fechaInicio"]." ".$hora[0],$_POST["fechaTermino"],$_POST["selecPiso"],$_POST["oficinaRe"],$tipoReserva,$_POST["estacionamientoE"]);
												sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
											}										
											echo "2";
										}
										else
										{
											echo "-2";
										}
					
									}
									else 
									{
										echo $controlEsta;
									}
							}
						}
						else 
						{
							echo "-3";
						}	
					}
					else
					{
						//print_r($_POST);
						//die();
						if($_POST["fechaEntrada"]!=null && $_POST["horaIngreso"]!=null) // AGREGAR PISOOO!!!!! consultar
						{
							$cambioFrecuencia = null;
						
							if(count($reserva)>0)
							{
								//SET fechaEntrada = ?,fechaSalida = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?"
								
								
								//print_r($reserva);
								$hora = split(" ",$_POST["horaIngreso"]);
								$fechaEntrada = $fechahora->inverFecha($_POST["fechaEntrada"])." ".$hora[0];
								$fechaSalida = null; //$fecha->inverFecha($_POST["fechaEntrada"])." ".$horaS[0];
								
								if(isset($_POST["radioPV"]) && $_POST["radioPV"]=="vehicular") // este filtro puede ser que no sea necesario, conversar cliente.
								{
									if($_POST["estacionamientoE"]!=0)
									{
										$tipoReserva = "Vehicular";
									}
									else
									{
										$controlEsta = -4; //Ingrese la patente y el estacionamiento para realizar la reserva vehicular;
									}
					
									
								}
							
								if($reserva->getttipoFrecuencia()!=0)
								{
									//echo "tipoFrecuencia".$reserva->getidreservaFrecuente();
									$cambioFrecuencia = 1;
								}
								$dataReserEspo = array($fechaEntrada,$fechaSalida,$tipoFrecuencia,$tipoReserva,$_POST["selecPiso"],$_POST["oficinaRe"],$_POST["estacionamientoE"],$_POST["patente"],$_POST["idcliente"],$_POST["idvit"],$reserva->getidReserva());
								//print_r($dataReserEspo);
								//print_r($dataReserEspo);
								//die();
								if($controlEsta==0)
								{
									if(controlReserva::updateReserva($dataReserEspo,null,$cambioFrecuencia)==1)
									{
										if($dataConfiCorreo->getestado()>0)
										{
											$flagHoy = generaQR::creaQR($nombreImagen.$reserva->getidReserva()."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$tipoFrecuencia."_fec;".$_POST["fechaEntrada"],null,"codigo".$nombreImagen.$reserva->getidReserva()."_".$visita->getidVisista().".png");
											//"DreamIT","Gonzalo Heredia","10/10/2012",34,340,"Peatonal"
											$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$fechaEntrada,$_POST["fechaEntrada"],$_POST["selecPiso"],$_POST["oficinaRe"],$tipoReserva,$_POST["estacionamientoE"]);
											sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
										}
										
										echo "1";
									}
									else
									{
										echo "-1"; //problemas en la capa controlReserva, funcion updateReserva...
									}
								}
								else 
								{
									echo $controlEsta;
								}
					
					
							}
							else
							{
								//echo "aqui";
								//print_r($_POST);
								//die();
								$dataReserEspo = null;
								
								$hora = split(" ", $_POST["horaIngreso"]);
								$horaSalida = null;//split(" ", $_POST["horaSalida"]);
								$fechaEntrada = $fechahora->inverFecha($_POST["fechaEntrada"]);
								
								if(isset($_POST["radioPV"]) && $_POST["radioPV"]=="vehicular") // este filtro puede ser que no sea necesario, conversar cliente.
								{
									if($_POST["estacionamientoE"]!=0)
									{
										$tipoReserva ="Vehicular";
									}
									else
									{
										$controlEsta = -4; //Ingrese la patente y el estacionamiento para realizar la reserva vehicular;
									}
					
									
								}
								$idR = null;
								//die($tipoReserva);
								//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
								$dataReserEspo = array($_POST["idcliente"],null,$_POST["idvit"],$fechaEntrada." ".$hora[0],null,$tipoReserva,$tipoFrecuencia,$_POST["selecPiso"],$_POST["oficinaRe"],$_POST["estacionamientoE"],$estadiValidacion,null,$_POST["idvit"],$_POST["patente"]);

								if($controlEsta==0)
								{
									$idR = controlReserva::insertaReserva($dataReserEspo); 
									if($idR>0)
									{
										if($dataConfiCorreo->getestado()>0)
										{
											$flagHoy = generaQR::creaQR($nombreImagen.$idR."_".$visita->getidVisista()."_".$_POST["idcliente"]."_".$tipoFrecuencia."_fec;".$fechaEntrada,null,"codigo".$nombreImagen.$idR."_".$visita->getidVisista().".png");
											$dato = array($cliente->getnombreEmpresa(),$visita->getnombre()." ".$visita->getapellido(),$fechaEntrada." ".$hora[0],$fechaEntrada,$_POST["selecPiso"],$_POST["oficinaRe"],$tipoReserva,$_POST["estacionamientoE"]);
											sendEmail::enviarCorreos("","","Edificio Titanium La Portada","Usted tiene una invitacion de la empresa ".$cliente->getnombreEmpresa(),$visita->getcontacto(),$flagHoy,"Codigo de acceso ".$visita->getnombre()." ".$visita->getapellido().".png",sendEmail::generaCuerpoMensaje($dato),true);
										}
										echo "1";
									}
									else{echo "-1";}// no se realizo la
								// no se ingresaron los campos necesarios para realizar la reserva.
								}
								else 
								{
									echo $controlEsta;
								}
							}
						 }
						 else{ echo "-3";} //NO SE INGRESARON LOS CAMPOS REQUERIDOS PARA REALIZAR LA OPERACION
					//
					}
				
			break;

		/*case isset($_POST["editreservaEsporadica"]):
				
				print_r($_POST); die(); //edicion de una reserva...... esporadico
				$fecha = new FechaHora();
				$tipoReserva = "Peatonal";
				$estadoValidacion = "Reservada";
				$reserva = controlReserva::isHaveReserva($_POST["idcliente"],$_POST["idvisiEs"],0);
				$dataReserEspo = null;
				
				if($_POST["fechaEntrada"]!=null && $_POST["horaEntrada"]!=null) // AGREGAR PISOOO!!!!! consultar
				{
						if(count($reserva)>0)
						{
							//SET fechaEntrada = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ? WHERE idCliente = ? AND idVisita = ? AND idReserva = ?"
					
							
								//print_r($reserva);
								$hora = split(" ",$_POST["horaEntrada"]);
								$horaS = split(" ",$_POST["horaSalida"]);
								$fechaEntrada = $fecha->inverFecha($_POST["fechaEntrada"])." ".$hora[0];
								$fechaSalida = $fecha->inverFecha($_POST["fechaEntrada"])." ".$horaS[0];
								if($_POST["estacionamientoE"]!=0)
								{
									$tipoReserva = "Vehicular";
								}
								$dataReserEspo = array($fechaEntrada,$fechaSalida,$tipoReserva,$_POST["pisoEs"],$_POST["oficinaEs"],$_POST["estacionamientoE"],$_POST["patenteEspo"],$_POST["idcliente"],$_POST["idvisiEs"],$reserva->getidReserva());
								//print_r($dataReserEspo);
								if(controlReserva::updateReserva($dataReserEspo)==1)
								 {
										echo "1";
								 }
								 else
								 {
								 	echo "-1"; //problemas en la capa controlReserva, funcion updateReserva...	
								 }
							
										
				
						}
						else
						{
					
							$dataReserEspo = null;
							
								$hora = split(" ", $_POST["horaEntrada"]);
								$horaSalida = split(" ", $_POST["horaSalida"]);
								$fechaEntrada = $fecha->inverFecha($_POST["fechaEntrada"]);
					
								if($_POST["patenteEspo"]!=null) // este filtro puede ser que no sea necesario, conversar cliente.
								{
										if($_POST["estacionamientoE"]!=0)
									{
										$tipoReserva = "Vehicular";
									}
									else
									{
										echo "-4"; //Ingrese la patente y el estacionamiento para realizar la reserva vehicular;
									}
						
					
								}
						//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
									$dataReserEspo = array($_POST["idcliente"],null,$_POST["idvisiEs"],$fechaEntrada." ".$hora[0],$fechaEntrada." ".$horaSalida[0],$tipoReserva,0,$_POST["pisoEs"],$_POST["oficinaEs"],$_POST["estacionamientoE"],$estadoValidacion,null,$_POST["idvisiEs"]*10,$_POST["patenteEspo"]);
									if(controlReserva::insertaReserva($dataReserEspo)==1)
									{
										echo "1";
									}else{echo "-1";}// no se realizo la 
								 // no se ingresaron los campos necesarios para realizar la reserva.	
						}
			}
			else{ echo "-3";} // NO SE INGRESARON LOS CAMPOS REQUERIDOS PARA REALIZAR LA OPERACION	
							  //print_r($dataReserEspo);
				
			break;*/
			
		default:
				/*echo "<pre>";
					print_r($_POST);
				echo "</pre>";*/
			
	
	}
}
else
{
	if($_GET!=null)
	{
		switch($_GET)
		{
			case isset($_GET["editvp"]): // entra en el caso que se esta editando los datos personales de una visita...
					//echo "gonzalo&heredia";
					$visita = controlVisita::getVisitaWithId($_GET["editvp"]);
					$nombreYape = $visita->getnombre(); // [0]=>nombre y [1]=>apellido
					$apellido = $visita->getapellido();
					$rutdv = "S/R";
					if($visita->getrut()!=null)
					{
						$rutdv = $visita->getrut()."-".$visita->getdv();
					}
					echo $nombreYape."&".$apellido."&".$rutdv."&".$visita->getpasaporte()."&"."rutaImagen"."&".$visita->getcontacto()."&".$visita->gettelefono()."&".$visita->getempresa(); 
					
					//print_r($visita->getnombre());
				break;

			case isset($_GET["editvreserva"]):
				/*
				 * editar reserva o agendar reserva una vez ya previamente ingresado los datos del visitante
				 */
				//print_r($_GET);
				//die();
				
				$data = null;
				$reserva = null;
				$corteFechaHoraSalida = null;
				$reserva = controlReserva::getReservaAssClienteVisita($_GET["idc"],$_GET["editvreserva"]);
				$visita = controlVisita::getVisitaWithId($_GET["editvreserva"]);
				//print_r($reserva);
				//print_r($visita); 
				//die();
				if(count($reserva)>0)
				{	
					if($reserva->getttipoFrecuencia()==1)
					{
						$arrFechaHora = split(" ",$reserva->getfechaEntrada());
						$fechaTermino = split(" ",$reserva->getfechaSalida());
						$data = $reserva->getttipoFrecuencia()."&".$reserva->getlunes()."&".$reserva->getmartes()."&".$reserva->getmiercoles()."&".$reserva->getjueves()."&".$reserva->getviernes()."&".$reserva->getsabado()."&".$reserva->getdomingo()."&".$arrFechaHora[1]."&".$reserva->getpiso()."&".$reserva->getoficina()."&".$reserva->gettipoReserva()."&".$reserva->getestacionamientoAsignado()."&".$reserva->getpatenteVehiculo()."&".$arrFechaHora[0]."&".$fechaTermino[0];
					}
					else
					{
						$corteFechaHoraEntrada = split(" ",$reserva->getfechaEntrada());
						//$corteFechaHoraSalida = split(" ",$reserva->getfechaSalida());
						
						$data = $reserva->getttipoFrecuencia()."&".$corteFechaHoraEntrada[0]."&".$corteFechaHoraEntrada[1]."&".$corteFechaHoraSalida[1]."&".$reserva->getpiso()."&".$reserva->getoficina()."&".$reserva->getestacionamientoAsignado()."&".$reserva->getpatenteVehiculo()."&".$reserva->gettipoReserva();
					}
				}
				
				echo $data."&".$visita->getnombre()." ".$visita->getapellido();
				//print_r($reserva);
				//die();
				//print_r($arrFechaHora); //$_GET["idc"],$_GET["editvreserva"]
				
				break;
				
			case isset($_GET["eliminar"]):
					/*
					 * nada por el momento
					 */
				break;
				
				default:
				
					print_r($_GET);
		}
	}
	//echo "<pre>";
	
	//echo "</pre>";
}


?>
