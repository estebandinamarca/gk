<?php
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlOperador.class.php');

$idUser=$_GET['idUser'];
$ope=$_GET['ope'];

//echo $idUser;
//echo $ope;
$datosUsuario= controlUsuario::listUsuarios(null,$idUser);
//var_dump($datosUsuario);

if ($ope!="0")
{
	$datosOperador=controlOperador::getOperador($idUser);
	//var_dump($datosOperador);
	echo $datosUsuario[0]['userFullName']."&".$datosUsuario[0]['userName']."&".$datosUsuario[0]['mail']."&".$datosUsuario[0]['level']."&".$datosOperador->gettelefono()."&".$datosOperador->getcelular()."&".$datosOperador->getubicacionEdificio()."&".$datosUsuario[0]['idUser']."&".$datosOperador->getorientacionPos();
	
}
else echo $datosUsuario[0]['userFullName']."&".$datosUsuario[0]['userName']."&".$datosUsuario[0]['mail']."&".$datosUsuario[0]['level']."&".$datosUsuario[0]['idUser'];

?>