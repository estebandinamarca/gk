<?php
require_once 'src/classes/controlTarjeta.class.php';

if(isset($_GET['idTarjeta']))$idTarjeta = $_GET['idTarjeta'];else $idTarjeta=null;

if ($idTarjeta==null||$idTarjeta=="")
{
	echo "-1"; //No se enviaron los datos
}
else
{
	
	echo controlTarjeta::deleteTarjeta($idTarjeta);


}
?>