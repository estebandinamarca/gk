<?php
require_once 'src/classes/controlConfiguracionGK.class.php';

if($_GET)
{
	if(isset($_GET['config'])!=null) $configuracion=$_GET['config'];else $configuracion=null;
	if(isset($_GET['estado'])!=null) $estado=$_GET['estado'];else $estado=null;
	echo controlConfiguracionGK::updateConfiguracion($configuracion,$estado);
}
else echo "-2"; //No se recibieron los datos

?>