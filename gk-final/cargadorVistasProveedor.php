<?php
require_once 'src/view/gestionProveedorView.class.php';
require_once 'src/classes/usuario.php';
session_start();
$usuario=$_SESSION['usuario_gk'];

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-nuevo-proveedor":
			gestionProveedorView::getIngresoProveedor($usuario->getidCliente());
		break;
		case "content-editar-proveedor":
			gestionProveedorView::getEditarProveedor($usuario->getidCliente());
		break;
		default: header("Location: login.php");
		break;
		}
}
else header("Location: login.php");

?>
				