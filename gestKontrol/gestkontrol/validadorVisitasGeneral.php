<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');



if(isset($_GET['idReservaTarjeta']))$id = $_GET['idReservaTarjeta'];else $id=null;
if(isset($_GET['idOperadorTarjeta']))$op = $_GET['idOperadorTarjeta'];else $op=null;
if(isset($_GET['numTarjeta']))$numTarjeta = $_GET['numTarjeta'];else $numTarjeta=null;



if ($numTarjeta!=null)
{
	//ejecutar controlTarjeta para ocupar la tarjeta
	$visita=controlVisita::getVisitaByIdReserva($id);
	$tarjeta= controlTarjeta::getTarjetaPorNumero($numTarjeta);
	if($tarjeta=="") echo "-2"; //TARJETA INEXISTENTE
	else
	{
		if ($tarjeta->getestado()!=1)
		{
			if(controlTarjeta::insertTarjetaHistorico($tarjeta->getidTarjeta(),$visita->getidVisista(),$id)!=null)
			{
				if (controlTarjeta::ocupaTarjeta($numTarjeta)!=null)echo controlReserva::validarVisita($id,$op);
				else echo "0";
			}
			else echo "0";
			
		}
		else echo "-1"; //TARJETA OCUPADA!
	}
}

else echo controlReserva::validarVisita($id,$op);

?>