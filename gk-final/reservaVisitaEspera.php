<?php
require_once 'src/classes/controlReserva.class.php';
require_once 'src/classes/controlVisita.class.php';
require_once 'src/classes/controlVisitasEnEspera.class.php';
//echo date('Y-m-d H:i:s');

if($_POST)
{
	
	if(isset($_POST['idCliente']))$idCliente=$_POST['idCliente']; else $idCliente=null;
	if(isset($_POST['idVisita']))$idVisita=$_POST['idVisita']; else $idVisita=null;
	if(isset($_POST['idVisitaEnEspera']))$idVisitaEnEspera=$_POST['idVisitaEnEspera']; else $idVisitaEnEspera=null;
	if(isset($_POST['opc']))$opc=$_POST['opc']; else $opc=null;
	
	if($opc!=null)
	{
		switch ($opc)
		{
			case "res":	
				if($idVisita!=null&&$idCliente!=null)
				{
					$data=array($idCliente,null,$idVisita,date('Y-m-d H:i:s'),null,"Peatonal",'0',null,null,null,'Reservada',null,null,'0');
					$retorno=controlReserva::insertaReserva($data);
					//echo $retorno;
					if($retorno>0)
					{
						if(controlVisita::cambiaEstadoEsperaVisita($idVisita,'ocu')>0)
						{
							if (controlVisitasEnEspera::terminarVisitaEspera($idVisitaEnEspera,$idVisita)>0)echo "1"; //todo OK
							else echo "-1";
						}
						else echo "-1"; //error DB
					} 
					else echo "-1";	//error DB
					
				}
				else echo "0";//POST Vacio
				break;
			case "bor":
				if($idVisita!=null&&$idCliente!=null)
				{
					
					$retorno=controlVisita::eliminaVisitaEspera($idVisita,$idCliente);
					//echo $retorno;
					if($retorno>0)
					{
						if(controlVisita::cambiaEstadoEsperaVisita($idVisita,'ocu')>0)echo "1"; //todo OK
						else echo "-1"; //error DB
					}
					else echo "-1";	//error DB
				
				}
				else echo "0";//POST Vacio
				break;
		}
	}
	else echo "0"; //POST Vacio
}
else echo "error, no se recibio POST";


?>