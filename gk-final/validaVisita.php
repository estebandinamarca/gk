<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');



if(isset($_GET['id']))$id = $_GET['id'];
else $id=null;
if(isset($_GET['op']))$op = $_GET['op'];
else $op=null; 
if(isset($_GET['rut']))$rut = $_GET['rut'];
else $rut=null;
if(isset($_GET['dv']))$dv = $_GET['dv'];
else $dv=null;
$actualizarut=null;
$exitoOf = false;
//echo $id." ".$rut." ".$dv." ".$op."<br>";
//die("stop");
//print_r(validaVisitas($id,$op)
//print_r($_GET);die();


/*
 *
 * ############################## INICIO VALIDACION PROVEEDORES ###############################################3
 *
*/

$visitante= controlVisita::getVisitaByIdReserva($id);
if ($visitante->gettipoVisita()=="proveedor"||$visitante->gettipoVisita()=="Proveedor")
{
	if ($rut!=null&&$dv!=null)
	{
		$reservaRut = controlVisita::existeRut($id);
		//	var_dump($reservaRut);
	
		if($reservaRut->getrut()==NULL)
		{
			$actualizarut=controlVisita::actualizaRut($reservaRut->getidVisista(),$rut,$dv);
			//var_dump($actualizarut);
		}
		if($actualizarut=="0") echo $id."%".$op."&"."0"; //error en SQL
		else
		{
			$visitaActual= controlReserva::getReservaPorId($id);
			if ($visitaActual->gettipoReserva()=="Vehicular"||$visitaActual->gettipoReserva()=="Vehiculo")
			{
				if ($visitaActual->getpatenteVehiculo()!=null || $visitaActual->getpatenteVehiculo()!="0")
				{
					echo $id."%".$op."&"."-1";
				}
				else echo $id."%".$op."&"."-2";
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
					
					echo $id."%".$op."&".$recibido;
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
				echo $id."%".$op."&"."-1";
			}
			else echo $id."%".$op."&"."-2";
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

/*
 * 
 * ############################## FIN VALIDACION PROVEEDORES ###############################################3
 * 
 */ 

else
{
	if ($rut!=null&&$dv!=null)
	{
		$reservaRut = controlVisita::existeRut($id);
		//	var_dump($reservaRut);
		//print_r($reservaRut);
		if($reservaRut->getrut()==NULL)
		{
			$actualizarut=controlVisita::actualizaRut($reservaRut->getidVisista(),$rut,$dv);
			//var_dump($actualizarut);
		}
		if($actualizarut=="0") echo $id."%".$op."&"."0"; //error en SQL
		else
		{
		
			//var_dump($actualizarut);
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
					
					echo $id."%".$op."&".$recibido;
				}
				else echo $id."%".$op."&"."2"; //Visita no es de hoy
		}
	}
	else 
	{
		//die("no por aqui");
		//echo "por aca";
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
?>
