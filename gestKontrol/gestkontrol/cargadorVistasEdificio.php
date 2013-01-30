<?php
require_once ('src/view/gestionEdificioView.class.php');


if($_GET)
{
	switch($_GET["do"])
	{
		case "content-nuevo-piso":
			gestionEdificioView::getIngresoPisoOficina();
			break;
		case "content-nuevo-estacionamiento":
			gestionEdificioView::getIngresoPisoEstacionamiento();
			break;
		case "content-edit-piso":
			gestionEdificioView::editPisosOficinas();
			break;
		case "content-edicion-oficina":
			gestionEdificioView::edicionOficina();
			break;
		case "content-edit-estacionamiento":
			gestionEdificioView::editEstacionamientos();
			break;
		case "content-edicion-estacionamiento":
			gestionEdificioView::edicionEstacionamiento();
			break;
		default: header("Location: login.php");
	}
}
else header("Location: login.php");


?>