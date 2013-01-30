<?php
require_once ("src/classes/controlUsuario.class.php");
require_once ("src/classes/controlCliente.class.php");

if($_POST!=null && isset($_POST))
{
	switch ($_POST)
	{
		case isset($_POST["euserNameFull"]):
			
			$passActual = trim($_POST["enewPassActual"]);
			$pasNueva = trim($_POST["enewPass"]);
			$passConfNueva = trim($_POST["enewPassConf"]);
			//$idUsuario = $_POST["idUsuario"];
			$nombreUserFull = trim($_POST["euserNameFull"]);
			$nomUserNick = trim($_POST["euserName"]);
			$correo = trim($_POST["email"]);
			$level = isset($_POST["nivelUsuario"])?$_POST["nivelUsuario"]:null;			
			$respuesta = null;
			
			$respuesta = controlUsuario::CambiaContraseOdata($nomUserNick,$nombreUserFull,$passActual,$pasNueva,$passConfNueva,$correo,$level);
			
			echo $respuesta;
			
		break;
		
		case isset($_POST["editUsuaCliente"]):
			
			//print_r($_POST);
			
			$nombreFull = trim($_POST["nombreCompletoUsuario"]);
			$nick = trim($_POST["editUsuaCliente"]);
			$passUser = trim($_POST["contrasenaUsuario"]);
			$pasUserConf = trim($_POST["contrasenaUsuarioConf"]);
			$correo = trim($_POST["correoUsuario"]);
			$level = $_POST["nivelUsuario"];
			//print_r($nick);
			$respuesta = controlUsuario::CambiaContraseOdata($nick,$nombreFull,null,$passUser,$pasUserConf,$correo,$level,1);
			
			echo $respuesta;
			
			break;
	}
	
}
?>