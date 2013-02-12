<?php

require_once ('src/classes/controlCliente.class.php');
$id=" ";
nombreClientesConId($id);

function nombreClientesConId($id)
{
	
	$nombre = controlCliente::listaClientes($id);
	//echo($id);
	//die();
	$i=0;
	$retorno=array();
	foreach ($nombre as $result)
	{
		$idEmpresa= $result->getidCliente();
		$nombreEmpresa= $result->getnombreEmpresa();
		$retorno=$idEmpresa.";".$nombreEmpresa.";";
		echo $retorno;
		
				
	}
		
}

?>