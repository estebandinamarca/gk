<?php
require_once ('src/view/gestionMensajeriaView.class.php');
require_once 'src/classes/usuario.php';


session_start();
$usuario=$_SESSION['usuario_gk'];
//var_dump($usuario);

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-bandeja-entrada":
			gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
			break;
		case "content-mensajes-enviados":
			gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
			break;
		case "content-mensajes-eliminados":
			gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
			break;
		case "content-ventana-mensaje":
			gestionMensajeriaView::viewMensaje();
			break;
		case "content-redactar-mensaje":
			gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());
			break;
		default: header("Location: login.php");
	}
}
else header("Location: login.php");

?>