<?php
require_once ('src/view/gestionCalendarioView.class.php');
require_once 'src/classes/usuario.php';


session_start();
$usuario=$_SESSION['usuario_gk'];

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-calendario":
			gestionCalendarioView::getCalendario($usuario->getidCliente());
			break;
		default: header("Location: login.php");
	}
}
else header("Location: login.php");


?>