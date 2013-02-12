<?php
require_once 'src/classes/controlCliente.class.php';

if($_GET)
{
	$piso=isset($_GET['piso'])!=null?$_GET['piso']:null;
	$retorno=null;
	if($piso!=null)
	{
		$clientes=controlCliente::getDetalleCliente(null,$piso);
		//print_r($clientes);
		if(isset($clientes))
		{
			foreach($clientes as $result)
			{
				if($result->getidCliente()!=null)
				{
					$empresa=controlCliente::getCliente($result->getidCliente());
					$retorno.=$empresa->getidCliente()."&&".$empresa->getNombreEmpresa()."&&".$result->getoficina()."*";
				}
			}
		}
	}
	echo $retorno;
}

?>