<?php
require_once ('src/view/gestionTarjetaView.class.php');

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-ingresa-tarjeta":
			gestionTarjetaView::ingresaTarjeta();
			break;
		case "content-editar-tarjeta":
			gestionTarjetaView::editaTarjeta();
			break;
		case "content-edicion-tarjeta":
			gestionTarjetaView::edicionTarjeta();
			break;
		default: header("Location: login.php");
	}
}
else header("Location: login.php");

?>
					
					