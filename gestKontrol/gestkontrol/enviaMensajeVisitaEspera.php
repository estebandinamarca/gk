<?php
require_once 'src/classes/controlVisita.class.php';
require_once 'src/classes/controlVisitasEnEspera.class.php';
//date_default_timezone_set('UTC');

if ($_POST)
{
	
	if (isset($_POST['nomVisitaEspera'])) $nomVisitaEspera=$_POST['nomVisitaEspera']; else $nomVisitaEspera=null;
	if (isset($_POST['apeVisitaEspera'])) $apeVisitaEspera=$_POST['apeVisitaEspera']; else $apeVisitaEspera=null;
	if (isset($_POST['rutVisitaEspera'])) $rutVisitaEspera=$_POST['rutVisitaEspera']; else $rutVisitaEspera=null;
	if (isset($_POST['empVisitaEspera'])) $empVisitaEspera=$_POST['empVisitaEspera']; else $empVisitaEspera=null;
	
	$rutVisitaEspera=explode('-',$rutVisitaEspera);	
	$data=array($rutVisitaEspera[0],$rutVisitaEspera[1],null,$nomVisitaEspera,$apeVisitaEspera,null,null,null,null,null,null,null);
	
	$idVisita=controlVisita::insertVisitaYretId($data,$empVisitaEspera);
	
	if ($idVisita>0)
	{
		$retorno=controlVisita::cambiaEstadoEsperaVisita($idVisita,'esp');
		$dataVisitaEnEspera= array($idVisita,$empVisitaEspera,null); 
		$idVisitaEnEspera=controlVisitasEnEspera::addVisitaEnEspera($dataVisitaEnEspera);
		
		if ($idVisitaEnEspera>0) $retorno = controlVisitasEnEspera::actualizaVisitaEnEspera($idVisitaEnEspera,$idVisita);
		else $retorno="0";
		
	}
	else $retorno="0";
	echo $retorno;
}

?>