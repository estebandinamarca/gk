<?php
require_once 'src/view/gestionVisitasView.class.php';
require_once 'src/classes/usuario.php';
session_start();
$usuario=$_SESSION['usuario_gk'];

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-nueva-visita":
			gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
			break;
		
		case "content-editar-visitas":
			gestionVisitasView::getVisitas($usuario->getidCliente());
			break;
		default: header("Location: login.php");
		break;
	}
}
else header("Location: login.php");


?>