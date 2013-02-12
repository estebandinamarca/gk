<?php
require_once 'src/classes/controlVisita.class.php';
require_once 'src/classes/controlReserva.class.php';

//rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa

//print_r($_POST);
if ($_POST)
{
	if (isset($_POST['nomVisitaGuardar'])) $nomVisitaGuardar=$_POST['nomVisitaGuardar']; else $nomVisitaGuardar=null;
	if (isset($_POST['apeVisitaGuardar'])) $apeVisitaGuardar=$_POST['apeVisitaGuardar']; else $apeVisitaGuardar=null;
	if (isset($_POST['rutVisitaGuardar'])) $rutVisitaGuardar=$_POST['rutVisitaGuardar']; else $rutVisitaGuardar=null;
	if (isset($_POST['idOperador'])) $idOperador=$_POST['idOperador']; else $idOperador=null;
	$cantVisitaGuardar=isset($_POST['cantVisitaGuardar'])?$_POST['cantVisitaGuardar']:null;
	if($cantVisitaGuardar>0)
	{
		for($i=1;$i<=$cantVisitaGuardar;$i++)
		{
			$empVisitaGuardar[]= isset($_POST['empVisitaGuardar'.$i])?$_POST['empVisitaGuardar'.$i]:null;
			$pisoVisitaGuardar[]= isset($_POST['pisoVisitaGuardar'.$i])?$_POST['pisoVisitaGuardar'.$i]:null;
		}
	}
	
	/*print_r($empVisitaGuardar);
	print_r($pisoVisitaGuardar);*/
	$rutVisitaGuardar=explode('-',$rutVisitaGuardar);	
	$nomVisitaGuardar=strtoupper($nomVisitaGuardar);
	$apeVisitaGuardar=strtoupper($apeVisitaGuardar);
	$data=array($rutVisitaGuardar[0],$rutVisitaGuardar[1],null,$nomVisitaGuardar,$apeVisitaGuardar,null,null,null,null,null,null,null);
	
	for($j=0;$j<$cantVisitaGuardar;$j++)
	{
		if($empVisitaGuardar[$j]!='nadie'||$empVisitaGuardar[$j]!=null&&$pisoVisitaGuardar[$j]!='nadie'||$pisoVisitaGuardar[$j]!=null)
		{
			//echo $empVisitaGuardar[$j]." ->empresa ".$pisoVisitaGuardar[$j]." ->piso ";
			
			$idVisita=controlVisita::insertVisitaYretId($data,$empVisitaGuardar[$j]);
			//echo $empVisitaGuardar[$j]." ->empresa ".$pisoVisitaGuardar[$j]." ->piso ".$idVisita." ->idVisita ";
			if ($idVisita!=null)
			{
				//idCliente,idOperador,idVisita,fechaEntrada,fechaSalida,tipoReserva,tipoFrecuencia,piso,oficina,
				//estacionamientoAsignado,estadoValidacion,momentoValidacion,codigoReserva,patenteVehiculo
			
				$data2=array($empVisitaGuardar[$j],$idOperador,$idVisita,date("Y-m-d H:i:s"),date("Y-m-d H:i:s",time(date("Y-m-d H:i:s"))+60*60),'Peatonal','0',$pisoVisitaGuardar[$j],'0','0','Validada',date("Y-m-d H:i:s"),null,'S/P');
			
				$reserva=controlReserva::insertaReservaYretornaidReserva($data2);
				///echo $reserva."->reserva.<br>";
				if($reserva>0)$retorno[]='1'; //Todo OK
				else $retorno[]='0';//Algo salio mal
			
			}
			else $retorno[]='0'; //Algo salio mal*/
		}
	}
	if(in_array('0',$retorno))echo '0';
	else echo '1';
	
	
}


?>