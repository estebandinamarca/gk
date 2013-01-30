<?php
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once 'src/core/conf.class.php';

require_once 'src/classes/controlEdificio.class.php';

class controlArchivo
{
	public function upload($arch)
	{
	
		if($_FILES && $_FILES["archivo"]["type"]=="text/plain" && $_FILES["archivo"]["size"]<=1073741824)
		{
			//$prefijo = substr(md5(uniqid(rand())),0,6);
			$ruta = "src/file/";
			$archivo = $_FILES["archivo"]['name'];
			$destino = $ruta.$archivo; //$ruta.$archivo;
			//print_r($_FILES);
			//echo "____";
			//print_r($destino);
			move_uploaded_file($_FILES['archivo']['tmp_name'],$destino);
			//echo "upload".$destino."_".$arch["radio1"];
			$control = controlArchivo::load($destino,$arch["opc"]);
			//unlink($destino);//una ves cargado el archivo a la base de datos se eliminara
			
			return $control;
			 
		}
		else
		{
			if($_FILES && $_FILES["archivo"]["type"]=="image/jpeg"&& $_FILES["archivo"]["size"]<=1073741824)
			{
				$ruta="src/img/";
				$opc=explode(",",$arch["opc"]);
				switch($opc[0])
				{
					case "vis":
						$ruta=$ruta."visitas/";
						break;
					case "prove":
						$ruta=$ruta."proveedor/";
						break;
					case "cli":
						$ruta=$ruta."clientes/";
						break;
					case "user":
						$ruta=$ruta."usuarios/";
						break;
				}
				$archivo = $opc[1].".jpg";
				$destino = $ruta.$archivo; //$ruta.$archivo;
				//print_r($_FILES);
				//echo "____";
				//print_r($opc[1]." ".$archivo);
				if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino))return "1";
				else return "-1";
				
				
			}
			else return "-1";
		}
	
	}
	public function load($root,$type=null)
	{
		/*
		 * type corresponde a la tabla que se genera la carga de datos estan pueden ser:
		* tienda,rubro,productos,marcas,promociones
		*
		*/
		$files = file($root);//("src/file/maestro.txt");
		$arr = array();
		$arrTem = null;
		//var_dump($files);
		foreach ($files as $linea)
		{
			//print_r($linea);
			switch($type)
			{
				case "of":
					$arrTem= explode(",",$linea);
					if(isset($arrTem) && count($arrTem)==2 && $arrTem[0]!=null)
					{
						$arr[] = array("piso"=>trim($arrTem[0]),"oficina"=>trim($arrTem[1]));
					}
					break;
				case "est":
					$arrTem= explode(",",$linea);
					if(isset($arrTem) && count($arrTem)==3 && $arrTem[0]!=null)
					{
						$arr[] = array("subterraneo"=>trim($arrTem[0]),"estacionamiento"=>trim($arrTem[1]),"proveedor"=>trim($arrTem[2]));
					}
					break;
					
			}
		}
			
		switch ($type)
		{
			case "of":
				if(count($arr)>0)
			 	{
					foreach ($arr as $oficina)
				 	{
				 		controlEdificio::insertPisoOficina($oficina);
				 	}
				 	return "1";
			 	}
			 	else
			 	{
			 		return "-1";
			 	}
				break;
			
			case "est":
				if(count($arr)>0)
				{
					foreach ($arr as $estacionamiento)
					{
						controlEdificio::insertSubEstacionamiento($estacionamiento);
					}
					return "1";
				}
				else
				{
					return "-1";
				}
				break;
		}
	}
}

?>