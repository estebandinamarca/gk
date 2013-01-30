<?php
require_once 'src/classes/controlVisita.class.php';

//rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
if ($_POST)
{
	if (isset($_POST['nomVisitaGuardar'])) $nomVisitaGuardar=$_POST['nomVisitaGuardar']; else $nomVisitaGuardar=null;
	if (isset($_POST['apeVisitaGuardar'])) $apeVisitaGuardar=$_POST['apeVisitaGuardar']; else $apeVisitaGuardar=null;
	if (isset($_POST['rutVisitaGuardar'])) $rutVisitaGuardar=$_POST['rutVisitaGuardar']; else $rutVisitaGuardar=null;
	if (isset($_POST['empVisitaGuardar'])) $empVisitaGuardar=$_POST['empVisitaGuardar']; else $empVisitaGuardar=null;
	
	$rutVisitaGuardar=explode('-',$rutVisitaGuardar);	
	$data=array($rutVisitaGuardar[0],$rutVisitaGuardar[1],null,$nomVisitaGuardar,$apeVisitaGuardar,null,null,null,null,null,null,null);
	
	$idVisita=controlVisita::insertVisitaYretId($data,$empVisitaGuardar);
	if ($idVisita!=null) echo "1"; //Todo OK
	else echo "0"; //Algo salio mal
}


?>