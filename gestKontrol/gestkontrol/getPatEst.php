<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');


if(isset($_GET['id']))$id = $_GET['id'];
else $id=null;

if(isset($_GET['pat']))$pat = $_GET['pat'];
else $pat=null;

if(isset($_GET['rut']))$rut = $_GET['rut'];
else $rut=null;

if(isset($_GET['dv']))$dv = $_GET['dv'];
else $dv=null;


if($rut!=null&&$dv!=null&&$id==null)
{
  $existeVisita=controlReserva::existeVisitaHoy($rut,$dv);
  $id=$existeVisita[0]->getidReserva();
}
/*Obtener estacionamientos disponibles y patente
 * 
 */ 
$nombreProveedor=controlVisita::getVisitaByIdReserva($id);

$est=controlEstacionamiento::getEstacionamientosProveedor();
if ($pat=="1")$patente=controlReserva::getReservaPorId($id);
$retorno=null;
 
foreach($est as $result)
{
	if($retorno==null) $retorno= $result->getnumero()."_".$result->getestado();
	else $retorno= $retorno."-".$result->getnumero()."_".$result->getestado();
	
  	
}

if ($pat=="1") $retorno = $patente->getpatenteVehiculo()."$".$retorno;

echo $nombreProveedor->getempresa()."#".$id."+".$retorno;
  
  
 

?>