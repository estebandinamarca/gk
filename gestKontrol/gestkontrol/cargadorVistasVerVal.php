<?php
require_once ('src/view/gestionVerificaValidaView.class.php');
session_start();
if($_GET)
{
	switch($_GET["do"])
	{
		case "content-modificar-visitas":
			gestionVerificaValidaView::getViewModificarVisitas();
			break;
		case "content-verificar-visitas":
			gestionVerificaValidaView::getViewVerificarVisitas();
			break;
		case "content-validar-visitas-global":
			gestionVerificaValidaView::getViewValidarVisitasGlobal();
			break;
		case "content-envia-mensaje-espera":
			gestionVerificaValidaView::enviaMensajeVisitaEspera();
			break;
		case "content-guarda-visita-cliente":
			gestionVerificaValidaView::guardaVisitaDB();
			break;
		default: header("Location: login.php"); 
	}
}
else header("Location: login.php");
?>
				
				
				