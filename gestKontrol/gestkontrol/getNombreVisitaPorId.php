<?php
require_once ('src/classes/controlReserva.class.php');

$id = $_GET['id'];


nombreVisitasPorId($id);

function nombreVisitasPorId($id)
{
	
	$nombre = @controlReserva::nombreReservasPorId($id);
	echo $nombre[0][0];
	
}

?>
