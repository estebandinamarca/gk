<?php

require_once 'src/classes/controlEdificio.class.php';
require_once 'src/classes/controlEstacionamiento.class.php';

if(isset($_GET['eidOf']))$idOficina = $_GET['eidOf'];else $idOficina=null;
if(isset($_GET['eOfi']))$numOfi = $_GET['eOfi'];else $numOfi=null;

if(isset($_GET['eidEst']))$idEstacionamiento = $_GET['eidEst'];else $idEstacionamiento=null;
if(isset($_GET['eNumEst']))$numEst = $_GET['eNumEst'];else $numEst=null;
if(isset($_GET['estProve']))$estProve = $_GET['estProve'];else $estProve=null;
if(isset($_GET['libEst']))$libEst = $_GET['libEst'];else $libEst=null;


if($idOficina!=null)
{
	if ($idOficina==null||$numOfi==null||$idOficina==""||$numOfi=="")
	{
		echo "-1"; //No se enviaron los datos
		
	}
	else
	{
		
		echo controlEdificio::updateOficina($idOficina,$numOfi);
	
	
	}
}
if($idEstacionamiento!=null)
{
	if ($idEstacionamiento==null||$numEst==null||$estProve==null||$idEstacionamiento==""||$numEst==""||$estProve=="")
	{
		echo "-1"; //No se enviaron los datos
	
	}
	else
	{
	
		echo controlEdificio::updateEdificio($idEstacionamiento,$numEst,$estProve);
	
	
	}
}

if($libEst!=null)
{
	echo controlEstacionamiento::desocuparEstNumero($libEst);
}
?>
