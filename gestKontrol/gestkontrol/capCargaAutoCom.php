<?php
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/visita.class.php');

if(isset($_GET))
{
	
	$idc = isset($_GET["idC"])? $_GET["idC"]: null;
	$nombre = isset($_GET["nombre"])? $_GET["nombre"]: null;
	$apellido = isset($_GET["apellido"])? $_GET["apellido"]: null;
	$datos = null;
	$and = true;
	;
	//rut,dv,pasaporte,nombre,apellido,direccion,telefono,contacto,rubro,servicios,empresa,idCliente
	$visitas = controlVisita::busquedaGlobalDeVisitas(array(null,null,null,$nombre,$apellido,null,null,null,null,null,null,null,$idc)); 
	//echo $nombre;
	///print_r($visitas);
	//die();
	if(isset($visitas) && $visitas!=null)
	{
		if(count($visitas)==1)
		{
			foreach ($visitas as $va)
			{
				$datos = "1_".$va->getidVisista()."*".$va->getapellido()."*".$va->getcontacto();
			}
		}
		else 
		{
			foreach ($visitas as $va)
			{
				$datos =$and?"1_".$va->getidVisista()."*".$va->getapellido()."*".$va->getcontacto():"1_".$va->getidVisista()."*".$va->getapellido()."*".$va->getcontacto();
				$and = false;
			}	
		}
			echo $datos;
	}
	else 
	{
		echo "1";
	}
}

?>