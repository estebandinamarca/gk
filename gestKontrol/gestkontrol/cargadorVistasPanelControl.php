<?php
require_once 'src/view/gestionPanelControlView.php';


session_start();
$usuario=$_SESSION['usuario_gk'];
//var_dump($usuario);

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-Panel-de-control":
			gestionPanelControl::getPanelControl($usuario);
			break;
		default: header("Location: login.php");
	}
}
else header("Location: login.php");
?>