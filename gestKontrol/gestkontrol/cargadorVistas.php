<?php
// Este archivo esta destinado a cargar las vistas de gestkontrol
// Recibe un get con lo que va a cargar y retorna el codigo bruto
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/cliente.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlConfiguracionGK.class.php');

require_once ('src/view/gestionVerificaValidaView.class.php');
require_once ('src/view/gestionClienteView.php');
require_once ('src/view/gestionUsuarioView.php');
require_once ('src/view/gestionVisitasView.class.php');
require_once ('src/view/gestionEdificioView.class.php');
require_once ('src/view/gestionProveedorView.class.php');
require_once ('src/view/gestionTarjetaView.class.php');
require_once ('src/view/gestionPanelControlView.php');
require_once ('src/view/gestionMensajeriaView.class.php');

//var_dump($_SESSION["usuario_gk"]);
session_start();
$usuario=$_SESSION["usuario_gk"];
//var_dump($usuario);
if (isset ($usuario)!=null)
{
	if($_GET)
	{
		switch($_GET["do"])
		{
			case "gestionVisita":
				gestionVisitasView::getIngresoVisita(null,$usuario->getidCliente());
				gestionVisitasView::getEditarVisitaDatosPersonales();
				//gestionVisitasView::getEditarVisitaReserva($usuario->getidCliente()); //EN CAMBIOS!!!
				
				gestionVisitasView::getReservaVisitaDiv();
				
				gestionVisitasView::getVisitas($usuario->getidCliente());
				gestionVisitasView::getVisitasEnEspera($usuario->getidCliente());
				break;
			case "gestionProveedor":
				gestionProveedorView::getIngresoProveedor($usuario->getidCliente());
				gestionProveedorView::getEditarProveedor($usuario->getidCliente()); // falta el eliminar
				gestionProveedorView::geteditarPerfilProveedorDiv();
				gestionProveedorView::getReservaProveedorDiv();
				break;
			case "gestionCliente":
				gestionClienteView::getIngresoCliente();
				gestionClienteView::getEditarCliente();
				gestionClienteView::getEditDatosPersoalesClientes();
				gestionClienteView::getEditarPisosClienteDivInicial();
				gestionClienteView::geteditarEstacionamientosDiv();
				break;
			case "gestionUsuario":
				gestionUsuarioView::getIngresoUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getEditarUsuario($usuario->getPrivilegio(),$usuario->getidCliente());
				gestionUsuarioView::getVentanaEdicionUsuarios($usuario->getPrivilegio());
				gestionUsuarioView::getVentanaEdicionOperador($usuario->getPrivilegio());
				gestionUsuarioView::getMiPerfil(null,$usuario);
				gestionUsuarioView::getAdministrarPerfiles(null,$usuario);
				gestionUsuarioView::getEditarUsuariosCliente($usuario);
				gestionUsuarioView::getformIgresDiv();
				break;
			case "gestionEdificio":
				gestionEdificioView::getIngresoPisoOficina(); //gestion de edificios
				gestionEdificioView::getIngresoPisoEstacionamiento(); //gestion de edificios
				gestionEdificioView::editPisosOficinas();
				gestionEdificioView::edicionOficina();
				gestionEdificioView::editEstacionamientos();
				gestionEdificioView::edicionEstacionamiento();
				break;
				
			case"gestionVerifValida":
				gestionVerificaValidaView::getViewValidarVisitasGlobal();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();
				gestionVerificaValidaView::enviaMensajeVisitaEspera();
				/*gestionVerificaValidaView::getViewValidarVisitasPeaton($usuario->getidCliente(),$usuario->getPrivilegio());
				 gestionVerificaValidaView::getViewValidarVisitasVehiculo();
				gestionVerificaValidaView::getViewVerificarVisitas();
				gestionVerificaValidaView::getViewModificarVisitas();*/
				break;
				
			case "gestionMensajeria":
				gestionMensajeriaView::bandejaEntrada($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEnviados($usuario->getIdUsuario());
				gestionMensajeriaView::mensajesEliminados($usuario->getIdUsuario());
				gestionMensajeriaView::viewMensaje();
				gestionMensajeriaView::nuevoMensaje($usuario->getIdUsuario());
				break;
			case "gestionPanelControl":
				gestionPanelControl::getPanelControl($usuario);
				break;
			case "gestionTarjetas":
				if (controlConfiguracionGK::getConfiguracion(null,"Tarjetas")!=null && controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado()=="1")
				{
					gestionTarjetaView::ingresaTarjeta();
					gestionTarjetaView::editaTarjeta();
					gestionTarjetaView::edicionTarjeta();
				}
				break;
			default: header("Location: login.php"); 
				
		}
	}
	else header("Location: login.php");
}
else header("Location: login.php");

?>
