<?php
require_once ('src/view/gestionVisitasView.class.php');
if($_GET!=null)
{
	//print_r($_GET);
	gestionVisitasView::getEditarVisitaReserva($_GET["idCliente"],$_GET["idVisitaEdir"]);
}
?>