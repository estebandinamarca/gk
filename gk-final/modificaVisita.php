<?php
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');

$id = $_GET['id'];
$opc = $_GET['opc'];
/*echo "$id ";
echo "$opc";
*/
$retorno=null;
$visita=controlVisita::getVisitaByIdReserva($id);
if($visita->gettipoVisita()=="proveedor"||$visita->gettipoVisita()=="Proveedor"||$visita->gettipoVisita()=="PROVEEDOR")
{
	$proveedor=controlReserva::getReservaPorId($id);
	if($proveedor->gettipoReserva()=="Vehicular"||$proveedor->gettipoReserva()=="Vehiculo")
	{
		$estacionamiento = $proveedor->getestacionamientoAsignado();
		if(controlReserva::modificarVisita($id,$opc)!=null)
		{
			if(controlEstacionamiento::desocuparEstNumero($estacionamiento)!=null)
			{
				if(controlReserva::actualizaEstAsignado($id,"0")!=null)	echo "1";
				else echo "0";
			}
			else echo "0";
		}
		else "0";
	}
	else $retorno=controlReserva::modificarVisita($id,$opc);
}

else $retorno=controlReserva::modificarVisita($id,$opc);
echo $retorno;

?>