<?php
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');

class controlCron
{
	public function EstablescerReservas()
	{
		date_default_timezone_set('America/Santiago');
		$ayer          = mktime(0, 0, 0, date("m"),date("d")-1, date("Y"));
		$mañana        = mktime(0, 0, 0, date("m"),date("d")+1, date("Y"));
		$mes_anterior  = mktime(0, 0, 0, date("m")-1,date("d"),   date("Y"));
		$año_siguiente = mktime(0, 0, 0, date("m"),date("d"),   date("Y")+1);
		
		$ayer = date("y-m-d",$ayer);
		$hoy = date("y-m-d");
		$mañanas = date("y-m-d",$mañana);
		
		
		
	}
	
}
?>