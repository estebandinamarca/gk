<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlConfiguracionGK.class.php');

if(isset ($_GET['rut']))$rut = $_GET['rut']; else $rut=null;
if(isset ($_GET['dv']))$dv = $_GET['dv']; else $dv=null;
if(isset ($_GET['apellido']))$apellido = $_GET['apellido']; else $apellido=null;
if(isset ($_GET['op']))$op = $_GET['op']; else $op=null;



$existeVisita=controlReserva::existeVisitaHoy($rut,$dv,"Reservada");
$visitante=null;
//var_dump($existeVisita);
//echo "conteo visita ".$existeVisita[0]->getfechaSalida();
if(count($existeVisita)>1)
{
	if($apellido!=null) echo $existeVisita[0]->getidReserva()."%".$op."&"."+".$apellido; //visita no encontrada en registros de hoy, se busca por apellido
	else echo $existeVisita[0]->getidReserva()."%".$op."&"."-1";
}
else
{ 
	if($existeVisita!=null)
	{
		$existeVisita = $existeVisita[0];
		$existeIntervaloVisita=controlReserva::existeVisitaIntervalo($rut,$dv);
	
		$id=$existeVisita->getidReserva();

		//echo "id: ".$id."<br>";
		$visitante= controlVisita::getVisitaByIdReserva($id);
	
		$exitoOf=null;

		if ($visitante->gettipoVisita()=="proveedor"||$visitante->gettipoVisita()=="Proveedor")
		{
			if ($rut!=null&&$dv!=null)
			{
				$reservaRut = controlVisita::existeRut($id);
		
				$actualizarut=null;

				if($reservaRut->getrut()==NULL)
				{
					$actualizarut=controlVisita::actualizaRut($reservaRut->getidVisista(),$rut,$dv);
				}
				if($actualizarut=="0") echo $id."%"."&".$op."0"; //error en SQL
				else
				{
					$visitaActual= controlReserva::getReservaPorId($id);
					if ($visitaActual->gettipoReserva()=="Vehicular"||$visitaActual->gettipoReserva()=="Vehiculo")
					{
						if ($visitaActual->getpatenteVehiculo()!=null || $visitaActual->getpatenteVehiculo()!="0")
						{
							echo $id."%".$op."&"."-2";
						}
						else echo $id."%".$op."&"."-3";
					}
					else
					{
						if (controlReserva::existeVisitaHoyPorId($id)!=null)
						{
							if(controlReserva::getFrecuenciaPorId($id)=="1")
							{
								$diaHoy= date("w");
								$diasSemana=array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
								$numDia=array("0","1","2","3","4","5","6");
								$nombreDiaHoy=$diasSemana[$diaHoy];
								$diaSiguiente=null;
								$diasgte=array();
								$newFechaEntrada = null;
								$flag=true;
								$idVisita=controlReserva::getidVisita($id);
								$dias=controlReserva::getDetalleFrecuencia($idVisita);
								if($dias->getlunes()!=null) $diasgte[1]="lunes";else $diasgte[1]="0";
								if($dias->getmartes()!=null) $diasgte[2]="martes";else $diasgte[2]="0";
								if($dias->getmiercoles()!=null) $diasgte[3]="miercoles";else $diasgte[3]="0";
								if($dias->getjueves()!=null) $diasgte[4]="jueves";else $diasgte[4]="0";
								if($dias->getviernes()!=null) $diasgte[5]="viernes";else $diasgte[5]="0";
								if($dias->getsabado()!=null) $diasgte[6]="sabado";else $diasgte[6]="0";
								if($dias->getdomingo()!=null) $diasgte[0]="domingo";else $diasgte[0]="0";
								for($i=$diaHoy+1;$i<=6;$i++)
								{
									if ($diasgte[$i]!="0")
									{
										$diaSiguiente=$diasgte[$i];
										$i=7;
										$flag=false;
									}
									else $flag=true;
								}
								if ($flag==true)
								{
									for($i=0;$i<=$diaHoy;$i++)
									{
										if ($diasgte[$i]!="0")
										{
											$diaSiguiente=$diasgte[$i];
											$i=$diaHoy+1;
										}
									}
								}
								$diasIngles=array("lunes"=>"monday","martes"=>"tuesday","miercoles"=>"wednesday","jueves"=>"thursday","viernes"=>"friday","sabado"=>"saturday","domingo"=>"sunday");
								$newFechaEntrada=date('Y-m-d', strtotime('next '.$diasIngles[$diaSiguiente]));
								$visitaActual= controlReserva::getReservaPorId($id);

								$data=array($visitaActual->getidCliente(),$visitaActual->getidOperador(),$visitaActual->getidVisita(),$newFechaEntrada,$visitaActual->getfechaSalida(),
										$visitaActual->gettipoReserva(),"1",$visitaActual->getpiso(),$visitaActual->getoficina(),$visitaActual->getestacionamientoAsignado(),"Reservada",NULL,$id,$visitaActual->getpatenteVehiculo());
								//controlReserva::insertaReserva($data);
								$idNuevaReserva = controlReserva::insertaReservaYretornaidReserva($data);
								if($idNuevaReserva>0)
								{
									if(controlReserva::updateReservaFrecuenteSoloIdReserva(array($idNuevaReserva,$id))==1) // updatea la tabla reservaFrecuente idanterior por idNuevoReserva
									{
										$exitoOf = true;
									}
										
								}
								if($idNuevaReserva=="-2")$exitoOf = true;
								if($exitoOf)
								{
									//$recibido=controlReserva::validarVisita($id,$op);
									$recibido="1";
								}
								else
								{
									$recibido= "0";
								}
									
							}
							else
							{
								//$recibido=controlReserva::validarVisita($id,$op);
								$recibido="1";
							}
								
							echo $id."%".$op."&".$visitante->getempresa()."+".$recibido;
						}
						else echo $id."%".$op."&"."2"; //Visita no es de hoy
					}
				}
			}
			else
			{
				$visitaActual= controlReserva::getReservaPorId($id);
				if ($visitaActual->gettipoReserva()=="Vehicular"||$visitaActual->gettipoReserva()=="Vehiculo")
				{
					if ($visitaActual->getpatenteVehiculo()!=null || $visitaActual->getpatenteVehiculo()!="0")
					{
						echo $id."%".$op."&"."-2";
					}
					else echo $id."%".$op."&"."-3";
				}
				else
				{
					if(controlReserva::getFrecuenciaPorId($id)=="1")
					{
						//echo "es frecuente <br>";
						$diaHoy= date("w");
						$diasSemana=array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
						$numDia=array("0","1","2","3","4","5","6");
						$nombreDiaHoy=$diasSemana[$diaHoy];
						$diaSiguiente=null;
						$recibido = null;
						$data = null;
						$diasgte=array();
						$diasIngles = array();
		
						$idNuevaReserva = null;
		
						$flag=true;
						$idVisita=controlReserva::getidVisita($id);
						$dias=controlReserva::getDetalleFrecuencia($idVisita);
						//print_r($dias->getlunes());
						if($dias->getlunes()!=null) $diasgte[1]="lunes";else $diasgte[1]="0";
						if($dias->getmartes()!=null) $diasgte[2]="martes";else $diasgte[2]="0";
						if($dias->getmiercoles()!=null) $diasgte[3]="miercoles";else $diasgte[3]="0";
						if($dias->getjueves()!=null) $diasgte[4]="jueves";else $diasgte[4]="0";
						if($dias->getviernes()!=null) $diasgte[5]="viernes";else $diasgte[5]="0";
						if($dias->getsabado()!=null) $diasgte[6]="sabado";else $diasgte[6]="0";
						if($dias->getdomingo()!=null) $diasgte[0]="domingo";else $diasgte[0]="0";
						for($i=$diaHoy+1;$i<=6;$i++)
						{
							if ($diasgte[$i]!="0")
							{
								$diaSiguiente=$diasgte[$i];
								$i=7;
								$flag=false;
							}
							else $flag=true;
						}
						if ($flag==true)
						{
							for($i=0;$i<=$diaHoy;$i++)
							{
								if ($diasgte[$i]!="0")
								{
									$diaSiguiente=$diasgte[$i];
									$i=$diaHoy+1;
										
								}
							}
						}
						$diasIngles=array("lunes"=>"monday","martes"=>"tuesday","miercoles"=>"wednesday","jueves"=>"thursday","viernes"=>"friday","sabado"=>"saturday","domingo"=>"sunday");
						$newFechaEntrada=null;
						$newFechaEntrada=date('Y-m-d', strtotime('next '.$diasIngles[$diaSiguiente]));
		
						$visitaActual= controlReserva::getReservaPorId($id);
		
						$data=array($visitaActual->getidCliente(),$visitaActual->getidOperador(),$visitaActual->getidVisita(),$newFechaEntrada,$visitaActual->getfechaSalida(),$visitaActual->gettipoReserva(),"1",$visitaActual->getpiso(),$visitaActual->getoficina(),$visitaActual->getestacionamientoAsignado(),"Reservada",NULL,$id,$visitaActual->getpatenteVehiculo());
						//controlReserva::insertaReserva($data);
						$idNuevaReserva = controlReserva::insertaReservaYretornaidReserva($data);
						
						if($idNuevaReserva>0)
						{
							if(controlReserva::updateReservaFrecuenteSoloIdReserva(array($idNuevaReserva,$id))==1) // updatea la tabla reservaFrecuente idanterior por idNuevoReserva
							{
								$exitoOf = true;
							}
								
						}
						if($idNuevaReserva=="-2")$exitoOf = true;
						if($exitoOf)
						{
							//$recibido=controlReserva::validarVisita($id,$op);
							$recibido="1";
						}
						else
						{
							$recibido= "0";
						}
		
					}
					else
					{
						//$recibido=controlReserva::validarVisita($id,$op);
						$recibido="1";
					}
		
					echo $id."%".$op."&".$recibido;
		
				}
			}
		}
		//var_dump($existeVisita);
		else
		{
			if ($existeIntervaloVisita!=null)
			{
				if ($existeIntervaloVisita->gettipoFrecuencia()=="1")
				{
					if ($existeVisita!=null)
					{
						if ($existeVisita->getestadoValidacion()!="Reservada")echo $id."%".$op."3";
						else
						{
				
							$diaHoy= date("w");
							$diasSemana=array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
						//	*******************************
							$numDia=array("0","1","2","3","4","5","6");
							$nombreDiaHoy=$diasSemana[$diaHoy];
							$diaSiguiente=null;
							$diasgte=array();
							$newFechaEntrada = null;
							$flag=true;
							$idVisita=controlReserva::getidVisita($id);
							$dias=controlReserva::getDetalleFrecuencia($idVisita);
							if($dias->getlunes()!=null) $diasgte[1]="lunes";else $diasgte[1]="0";
							if($dias->getmartes()!=null) $diasgte[2]="martes";else $diasgte[2]="0";
							if($dias->getmiercoles()!=null) $diasgte[3]="miercoles";else $diasgte[3]="0";
							if($dias->getjueves()!=null) $diasgte[4]="jueves";else $diasgte[4]="0";
							if($dias->getviernes()!=null) $diasgte[5]="viernes";else $diasgte[5]="0";
							if($dias->getsabado()!=null) $diasgte[6]="sabado";else $diasgte[6]="0";
							if($dias->getdomingo()!=null) $diasgte[0]="domingo";else $diasgte[0]="0";
							for($i=$diaHoy+1;$i<=6;$i++)
							{
								if ($diasgte[$i]!="0")
								{
									$diaSiguiente=$diasgte[$i];
									$i=7;
									$flag=false;
								}
								else $flag=true;
							}
							if ($flag==true)
							{
								for($i=0;$i<=$diaHoy;$i++)
								{
									if ($diasgte[$i]!="0")
									{
										$diaSiguiente=$diasgte[$i];
										$i=$diaHoy+1;
									}
								}
							}
			
							$diasIngles=array("lunes"=>"monday","martes"=>"tuesday","miercoles"=>"wednesday","jueves"=>"thursday","viernes"=>"friday","sabado"=>"saturday","domingo"=>"sunday");
							$newFechaEntrada=date('Y-m-d', strtotime('next '.$diasIngles[$diaSiguiente]));
				
							$visitaActual= controlReserva::getReservaPorId($id);
							$data=array($visitaActual->getidCliente(),$visitaActual->getidOperador(),$visitaActual->getidVisita(),$newFechaEntrada,$visitaActual->getfechaSalida(),
			
							$visitaActual->gettipoReserva(),"1",$visitaActual->getpiso(),$visitaActual->getoficina(),$visitaActual->getestacionamientoAsignado(),"Reservada",NULL,$id,$visitaActual->getpatenteVehiculo());
							//controlReserva::insertaReserva($data);
							//var_dump($data);
				
							$idNuevaReserva = controlReserva::insertaReservaYretornaidReserva($data);
					
							//echo $idNuevaReserva;
			
							if($idNuevaReserva>0)
							{
								if(controlReserva::updateReservaFrecuenteSoloIdReserva(array($idNuevaReserva,$id))==1) // updatea la tabla reservaFrecuente idanterior por idNuevoReserva
								{
									$exitoOf = true;
								}
							}
							if($idNuevaReserva=="-2")$exitoOf = true;
							//$visitaFrecuente=controlReserva::existeVisitaFrecuenteEnDia($existeIntervaloVisita->getidReserva(),$diasSemana[$diaHoy]);
			
							if($exitoOf) $validacion="1";//$validacion=controlReserva::validarVisita($id,$op);
							else $validacion= "0";//Error en SQL
		
							echo $id."%".$op."&".$validacion;
						
				
						//}
						//else echo "2"; //VISITA FRECUENTE NO ESTA EN EL DIA
						}
					}
				}
				else 
				{
					//$existeVisita=controlReserva::existeVisitaHoy($rut,$dv);
					if ($existeVisita!=null)
					{
						if($existeVisita->getestadoValidacion()=="Reservada")
						{
							/*$validacion=controlReserva::validarVisita($existeVisita->getidReserva(),$op);
							//var_dump($validacion);
							if($validacion!="0")*/echo $existeVisita->getidReserva()."%".$op."&"."1";//Visita esporadica que esta en el dia, se valida
							//else echo $existeVisita->getidReserva()."%".$op."0"; //error en SQL
						}
						else echo $existeVisita->getidReserva()."%".$op."&"."3";//VISITA YA VALIDADA EN EL DIA
					}
					else 
					{ 
						if($apellido!=null) echo $apellido; //visita no encontrada en registros de hoy, se busca por apellido
						else echo $existeVisita->getidReserva()."%".$op."&"."-4";
					} 
				}
			}
		
			else 
			{
				
				if ($existeVisita!=null)
				{
					if($existeVisita->getestadoValidacion()=="Reservada")
					{
						/*$validacion=controlReserva::validarVisita($existeVisita->getidReserva(),$op);
						//var_dump($validacion);
						if($validacion!="0")*/echo $id."%".$op."&"."1";//Visita esporadica que esta en el dia, se valida
						//else echo $id."%".$op."0"; //error en SQL
					}
					else echo $id."%".$op."3";//VISITA YA VALIDADA EN EL DIA
				}
				else 
				{ 
					if($apellido!=null) echo $apellido; //visita no encontrada en registros de hoy, se busca por apellido
					else echo $id."%".$op."&"."-4";
				}  
			} //visita no encontrada en registros de hoy, se busca por apellido
		}
	}
	else
	{
		if($apellido!=null) echo $id."%".$op."&".$apellido; //visita no encontrada en registros de hoy, se busca por apellido
		else echo $id."%".$op."&"."-4";
	}
}


?>