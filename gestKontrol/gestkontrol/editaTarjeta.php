<?php
require_once 'src/classes/controlTarjeta.class.php';

if(isset($_GET['eidTarjeta']))$idTarjeta = $_GET['eidTarjeta'];else $idTarjeta=null;
if(isset($_GET['enumTarj']))$numTarjeta = $_GET['enumTarj'];else $numTarjeta=null;
if(isset($_GET['ecodBar']))$codBarra = $_GET['ecodBar'];else $codBarra=null;
if(isset($_GET['ecodRfid']))$codRfid = $_GET['ecodRfid'];else $codRfid=null;
if(isset($_GET['libIdTar']))$libIdTar = $_GET['libIdTar'];else $libIdTar=null;

if ($idTarjeta==null||$numTarjeta==null||$codBarra==null||$codRfid==null||$idTarjeta==""||$numTarjeta==""||$codBarra==""||$codRfid=="")
{
	if ($libIdTar==null||$libIdTar=="")	echo "-1"; //No se enviaron los datos
	else
	{
		echo controlTarjeta::liberaTarjeta($libIdTar);
	}
}
else
{
	$data=array($numTarjeta,$codBarra,$codRfid);
	echo controlTarjeta::updateTarjeta($idTarjeta,$data);


}
?>