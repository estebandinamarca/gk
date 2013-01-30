<?php

require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/controlLogSistema.php');

date_default_timezone_set('America/Santiago');
//print_r(controlCliente::getCliente());

$ayer          = mktime(0, 0, 0, date("m"),date("d")-1, date("Y"));
$hoy = date("y-m-d");
$mañana        = mktime(0, 0, 0, date("m"),date("d")+1, date("Y"));
$mes_anterior  = mktime(0, 0, 0, date("m")-1,date("d"),   date("Y"));
$año_siguiente = mktime(0, 0, 0, date("m"),date("d"),   date("Y")+1);

$ayer = date("y-m-d",$ayer);
$mañanas = date("y-m-d",$mañana);

//echo $ayer."_".$hoy."_".$mañanas;

/*
 * Inicia la regularización de las visitas frecuentes
 */
controlLogSistema::crateLogSistema(array("Inicia Rutina Gestkontrol","Reporte Rutina Diaria","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
//$tipoFrecuencia=null,$estadoValidacion=null,$fechaInicio=null,$fechaTermino=null,$fechaTentativaNueva=null,$tipoReserva=null,$comparacion=null,$inicioOfin=null
$reservas = controlReserva::getReservaEstadoReserva(1,"Reservada",$ayer,null,null,null,null,null);
$reservaEs = controlReserva::getReservaEstadoReserva(0,"Reservada",$ayer,null,null,null,null,null);

//echo "<pre>";

//print_r($reservas);
//print_r($reservaEs);

$dias = array();
$diaDeHoy = date("w");
$diaReservaNexHoy = null;
$bandera = true;
$param = array();
$fechaTentativa=null;
//die();
if($reservas!=null && count($reservas)>0)
{

	controlLogSistema::crateLogSistema(array("Ingresa a reservas frecuentes","Regularizando","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));	

	foreach ($reservas as $reserva)
	{
		if($reserva->getdomingo()!=null)
		{
			$dias[0] = "sunday";
		}else{$dias[0] = "0";}
		//$fechaTentativa=null;
		if($reserva->getlunes()!=null)
		{
			$dias[1] = "monday";  
		}else{$dias[1] = "0";}
	
		if($reserva->getmartes()!=null)
		{
			$dias[2] = "tuesday";
		}else{$dias[2]="0";}
	
		if($reserva->getmiercoles()!=null)
		{
			$dias[3] = "wednesday";
		}else{$dias[3]="0";}
	
		if($reserva->getjueves()!=null)
		{
			$dias[4] = "thursday";
		}else{$dias[4] = "0";}
	
		if($reserva->getviernes()!=null)
		{
			$dias[5] = "friday";
		}else{$dias[5] = "0";}
	
		if($reserva->getsabado()!=null)
		{
			$dias[6] = "saturday";
		}else{$dias[6] = "0";}
	
		for($i=$diaDeHoy;$i<=6;$i++)
		{
			if($dias[$i]!="0")
			{
				$diaReservaNexHoy= $i;
				$i=7;
				$bandera = false;
			}
		}
		if($bandera)
		{
			for($i=0;$i<=6;$i++)
			{
				if($dias[$i]!="0")
				{
					$diaReservaNexHoy= $i;
					$i=7;
				}
			}
		}
	
		if($diaDeHoy==$diaReservaNexHoy)
		{
			$fechaTentativa =  date('Y-m-d', strtotime('now '.$dias[$diaReservaNexHoy]));
		}
		else
		{
			$fechaTentativa =  date('Y-m-d', strtotime('next '.$dias[$diaReservaNexHoy]));
		}
		
		$fechaSalida = $reserva->getfechaSalida();
		$fecha_Termino = strtotime($fechaSalida);
		$fecha_TentativaNueva = strtotime($fechaTentativa);
		
		if($fecha_Termino>=$fecha_TentativaNueva)
		{
			//echo $fechaTentativa."_T_S_".$fechaSalida." id=".$reserva->getidVisita();
			$actualizacion = null;
			//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
			$param = array(null,null,null,null,null,null,null,null,null,null,"Falto",null,null,null);
			//print_r($param);
			$actualizacion = controlReserva::updateReservaGlobal($param,$reserva->getidReserva());
		
			//echo "Actualizacion efectuada".$actualizacion;
	
			if($actualizacion!=null && $actualizacion>0)
			{
					$param = array($reserva->getidCliente(),$reserva->getidOperador(),$reserva->getidVisita(),$fechaTentativa,$reserva->getfechaSalida(),$reserva->gettipoReserva(),$reserva->getttipoFrecuencia(),$reserva->getpiso(),$reserva->getoficina(),$reserva->getestacionamientoAsignado(),$reserva->getestadoValidacion(),$reserva->getmomentoReserva(),$reserva->getcodigoReserva(),$reserva->getpatenteVehiculo());
					$idReservaN=null;
					$idReservaN = controlReserva::insertaReservaYretornaidReserva($param);
					if($idReservaN>0)
					{
						$resultado = controlReserva::updateReservaFrecuenteSoloIdReserva(array($idReservaN,$reserva->getidReserva()));
						if($resultado>0)
						{
							
						}
						else
						{
							controlLogSistema::crateLogSistema(array("Problemas en la actualización de reserva ".$reserva->getidReserva(),"Reserva Frecuente","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
						}
					}
					else 
					{
						//echo "No se logro insertar la nueva reserva";
						controlLogSistema::crateLogSistema(array("No se logro insertar la reserva N ".$reserva->getidReserva(),"Reserva Frecuente","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
					}
					echo $resultado;
			}	
		}
		else
		{
			//echo " NO".$fechaTentativa."_T_S_".$fechaSalida." id=".$reserva->getidVisita();
			//echo "Si falto una visita frecuente y no se cumplio la condicion de fecha entonces se Termina la visita";
		
			$paramF = array(null,null,null,null,null,null,null,null,null,null,"Falto",null,null,null);
			$actualizacion = controlReserva::updateReservaGlobal($paramF,$reserva->getidReserva());
			if($actualizacion>0)
			{
				controlLogSistema::crateLogSistema(array("Problemas en rangos de fechas".$reserva->getidReserva(),"Reserva Frecuente","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
			}
			//echo "<br>";
		}
		$bandera = true;
	//print_r($dias[$diaReservaNexHoy]);
	//print_r($diaReservaNexHoy);
	}
}
else
{
	//echo "no hay datos frecuentes para regularizar"."<pre>";
	controlLogSistema::crateLogSistema(array("No hay datos ","Reserva Frecuente","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
}

/*
 * Inicia regularización de las visitas esporadicas
 * 
 */
$reservaE = null;
$paramEs = array();
$respuesta= null;


if($reservaEs!=null && count($reservaEs)>0)
{
	foreach ($reservaEs as $reservaE)
	{
		$paramEs = array(null,null,null,null,null,null,null,null,null,null,"Falto",null,null,null);
		$respuesta = controlReserva::updateReservaGlobal($paramEs,$reservaE->getidReserva());
	
		if($respuesta>0)
		{
			//echo "regularizacion para esporadicos se ejecuto exitosamente";
			controlLogSistema::crateLogSistema(array("Se regularizaron las reservas","Reserva Esporadica","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
		}
		else 
		{
			//echo "problemas con la regularización de reservas esporadicas";
			controlLogSistema::crateLogSistema(array("Problemas en regularización","Reserva Esporadica","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
		}
	}	
}
else
{
	//echo "no hay datos esporadicos para regularizar";
	controlLogSistema::crateLogSistema(array("No hay datos","Reserva Esporadica","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
	
}//print_r($reservaE);

/*
 * Inicia liberacion de estacionamientos de los proveedores
 */
$estaProveedores = null;
$estaProveedores = controlEstacionamiento::getEstacionamientosProveedor();
$respuesta = null;
//actualizaEstAsignado($idRes,$numEst)
if($estaProveedores!=null && count($estaProveedores)>0)
{
	foreach ($estaProveedores as $estacionamiento)
	{
		$respuesta = controlEstacionamiento::desocuparEstNumero($estacionamiento->getnumero());
		
		if($respuesta>0)
		{
			//echo "estacionamiento liberado".$estacionamiento->getnumero();
			controlLogSistema::crateLogSistema(array("estacionamiento liberado ".$estacionamiento->getnumero(),"Reserva Esporadica","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
		}
		else 
		{
			//echo "estacionamiento no puede ser liberado".$estacionamiento->getnumero();
			controlLogSistema::crateLogSistema(array("No esta ocupado este estacionamiento ".$estacionamiento->getnumero(),"Reserva Esporadica","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol"));
		}
		
	}
}




?>