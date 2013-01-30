<?php
require_once 'src/classes/controlMensajes.class.php';

if($_POST)
{
	if(isset($_POST['idMensaje']))$idMensaje=$_POST['idMensaje']; else $idMensaje=null;
	if(isset($_POST['opc']))$opcion=$_POST['opc']; else $opcion=null;
	
	if($idMensaje==null||$opcion==null) echo "-2"; //Error en envio de datos
	else
	{
		
		
		if (controlMensajeria::cambiarEstadoMensaje($idMensaje,$opcion)!="-1") echo "1";
		else echo  "-1";


	}

}
else
{
	echo "0";
}
?>