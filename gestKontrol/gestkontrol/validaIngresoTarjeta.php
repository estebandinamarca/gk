<?php
require_once 'src/classes/controlTarjeta.class.php';
require_once 'src/view/gestionTarjetaView.class.php';

if(isset($_GET['numTarjeta']))$numTarjeta = $_GET['numTarjeta'];else $numTarjeta=null;
if(isset($_GET['codBarra']))$codBarra = $_GET['codBarra'];else $codBarra=null;
if(isset($_GET['codRfid']))$codRfid = $_GET['codRfid'];else $codRfid=null;

if ($numTarjeta==null||$codBarra==null||$codRfid==null||$numTarjeta==""||$codBarra==""||$codRfid=="") echo "-1"; //No se enviaron los datos
else 
{
	if(controlTarjeta::getTarjetaPorNumero($numTarjeta)==null)
	{
		$data=array($numTarjeta,$codBarra,$codRfid);
		if (controlTarjeta::insertTarjeta($data)!=null) echo "1";//Todo OK
		else echo "0"; // Error en DB
	}
	else echo "-2"; //Numero de Tarjeta ya existe
}



?>