<?php
require_once ('src/view/gestionUsuarioView.php');
session_start();
$usuario=$_SESSION['usuario_gk'];
//var_dump($usuario);

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-nuevo-usuario":
			gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
			break;
		case "content-editar-usuario":
			gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
			break;
		case "content-mi-perfil":
			gestionUsuarioView::getMiPerfil(null,$usuario);
			break;
		case"content-Administrar-perfiles":
			gestionUsuarioView::getAdministrarPerfiles(null,$usuario);
			break;
		case "content-editar-usuario-cliente":
			gestionUsuarioView::getEditarUsuariosCliente($usuario);
			break;
			
		default: header("Location: login.php");
	}
}
else header("Location: login.php");
// en menu view -> gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
// en menu view -> gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
// en menu view -> gestionUsuarioView::getformIgresDiv();
?>

