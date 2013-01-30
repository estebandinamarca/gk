<?php
require_once ('src/view/gestionVisitasView.class.php');

if(isset($_GET))
{
	//print_r($_GET);
 gestionVisitasView::getReservaDeAgregaVisita($_GET["id"],$_GET["rvi"],$_GET["pasvi"]);
}

//echo $_GET["id"];
?>