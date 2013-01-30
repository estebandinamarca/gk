<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');


if(isset ($_GET['eidUserProvee']))$idReserva = $_GET['eidUserProvee']; else $idReserva=null;
if(isset ($_GET['patenteProveedor']))$patente = $_GET['patenteProveedor']; else $patente=null;
if(isset ($_GET['cantEst']))$cantEst = $_GET['cantEst']; else $cantEst=null;
if(isset ($_GET['opEstProv']))$operador = $_GET['opEstProv']; else $operador=null;
if(isset ($_GET['radioEst']))$estacionamiento = $_GET['radioEst']; else $estacionamiento=null;
$exitoOf=null;

if ($patente==null||$patente=="S/P"||$patente=="0") echo $idReserva."%".$operador."&"."0"; // Faltan campos
else
{
	if ($estacionamiento==null) echo $idReserva."%".$operador."&"."-2"; //No hay estacionamientos
	else 
	{
		$estAsignado=controlReserva::actualizaEstAsignado($idReserva,$estacionamiento);
		if (controlEstacionamiento::ocuparEstNumero($estacionamiento)=="1" && ($estAsignado =="1"|| $estAsignado =="0") )
		{
			//echo "paso ocupar";
			$actualizaPat=controlReserva::actualizaPatente($idReserva,$patente);
			if($actualizaPat=="1"||$actualizaPat=="0")
			{
				//echo "paso actualizar";
				if(controlReserva::getFrecuenciaPorId($idReserva)=="1")
				{
					//echo "es frecuente <br>";
					$id=$idReserva;
					$op=$operador;
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
					$idVisita=controlReserva::getidVisita($idReserva);
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
				
					$visitaActual= controlReserva::getReservaPorId($idReserva);
				
					$data=array($visitaActual->getidCliente(),$visitaActual->getidOperador(),$visitaActual->getidVisita(),
							$newFechaEntrada,$visitaActual->getfechaSalida(),$visitaActual->gettipoReserva(),"1",$visitaActual->getpiso(),
							$visitaActual->getoficina(),$visitaActual->getestacionamientoAsignado(),
							"Reservada",NULL,$id,$visitaActual->getpatenteVehiculo());
					//controlReserva::insertaReserva($data);
					
					$idNuevaReserva = controlReserva::insertaReservaYretornaidReserva($data);
					//echo $idNuevaReserva." ->idnuevareserva";
					if($idNuevaReserva>0)
					{
						if(controlReserva::updateReservaFrecuenteSoloIdReserva(array($idNuevaReserva,$idReserva))==1) // updatea la tabla reservaFrecuente idanterior por idNuevoReserva
						{
							$exitoOf = true;
						}
								
					}
					if($idNuevaReserva=="-2")$exitoOf = true;
					if($exitoOf)
					{
						//$recibido=controlReserva::validarVisita($idReserva,$op);
						$recibido="1";
					}
					else
					{
						$recibido= "-1";
					}
					$visitante= controlVisita::getVisitaByIdReserva($idReserva);
					echo $id."%".$op.$visitante->getempresa()."+".$recibido;
				
				}
				else
				{
					//if(controlReserva::validarVisita($idReserva,$operador)=="1")
					//{
					//	$visitante= controlVisita::getVisitaByIdReserva($idReserva);
						echo $id."%".$op."&".$visitante->getempresa()."+"."1"; //Todo OK
					//}
					//else echo $id."%".$op."-1";//error en SQL
				}
			}
			else echo $id."%".$op."&"."-1"; //error en SQL
		}
		else echo $id."%".$op."&"."-1"; //Error en SQL
	}
}

?>