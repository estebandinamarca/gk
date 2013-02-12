<?php
require_once ("src/classes/controlCliente.class.php");
require_once ('src/classes/controlNumerico.class.php');
/*
 * Script PHP para ingreso de nuevo cliente
 * 
 * 
 */

if($_POST!=null)
{
	switch ($_POST)
	{
		case isset($_POST["rutCliente"]):

			//print_r($_POST);
			/*echo "<pre>";
			 //print_r($_POST);
			 if(isset($_POST["totalTabla"]))
			 {
			 	$name = "checkbox-";
			 	$inicio = 1;
				$off = array();
				
				$fitro = null;
				while($inicio<=$_POST["totalTabla"])
			 	{
			 		$fitro = $name.$inicio;
			 		if(isset($_POST[$fitro]))
			 		{
			 			$off[] = $inicio;
			 			
			 			
			 		}
			 		$inicio++;
				}
				 
			 	
			 }
			 
				foreach ($off as $idas)
					{
						echo $idas;
						echo "<br>";
					}
			 echo "<pre/>";
			 	
			 //echo "1";
			 die();*/
			//rut,dv,pasaporte,nombre,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
			
			$rut = null;
			$dv = null;
			$nombreEmpresa = null;
			$dataRut = null;
			$direccionEmpresa = null;
			$dataPiso = null;
			
 			if($_POST["rutCliente"]!=null)
			{
				$dataRut = split("-",$_POST["rutCliente"]);
				if(count($dataRut)>1)
				{
					$rut = trim($dataRut[0]);
					$dv = trim($dataRut[1]);
				}
				if(controlNumerico::validadorRut($rut,$dv) && ($_POST["nombreCliente"]!=null))
				{
					$nombreEmpresa = trim($_POST["nombreCliente"]);
					$direccionEmpresa = trim($_POST["direccionCliente"]);
					$off = array();
					$resultado = null;
					$data = array($rut,$dv,$nombreEmpresa,$direccionEmpresa); //$_POST["oficinaCliente"],$_POST["pisoCliente"],$_POST["orientacionCliente"],$_POST["telefonoCliente"],$_POST["contactoCliente"],$_POST["correoCliente"]
					$IdClienteInsert = controlCliente::insertCliente($data); // 
					$dataOffPiso = null;
					if(isset($_POST["totalTabla"]) && $_POST["totalTabla"]>0 && $IdClienteInsert>0)
					{ // idCliente = ?,telefono = ?,contacto = ?, email = ? WHERE idDetalleCliente = ?
						$name = "checkbox-";
						$fono= "telefono-";
						$correo = "correo-";
						$contacto = "nombreRecep-";
						$inicio = 1;
						$fitro = null;
						
						while($inicio<=$_POST["totalTabla"])
						{
							$fitro = $name.$inicio;
							$tel = $fono.$inicio;
							$con = $contacto.$inicio;
							$mail = $correo.$inicio;
							//$bandera = $inicio;
							if(isset($_POST[$fitro]))
							{
								//$off[] = $inicio;
								
								
								 $dataOffPiso = array($IdClienteInsert,$inicio);
								 $resultado = controlCliente::vinculoPisoOficinaCliente($dataOffPiso);
								 								 
							}
							
							$inicio++;
						}
						
					}
				
					if($resultado!=null)
					{
						switch($resultado)
						{
							case 1:
									echo "1"; // se realizo ok el ingreso de cliente y ser vinculo con los pisos respectivos
								break;

							case -2:
									
									echo "-3"; // no se realizo el vinculo de los clientes con sus pisos y oficinas
									
								break;
						}
					}
					else 
					{
						switch ($IdClienteInsert)
						{
							case $IdClienteInsert>0:

									echo "1"; //se realizo el ingreso de cliente sin vinculación a pisos
								
								break;
							
							case -2:
								
									echo "-2"; //problemas con el ingreso de clientes
									
								break;
						}
					}
										
					
				}
				else
				{
					echo "0";	  // Es obligatorio ingresar el nombre de la empresa 
				}
					
			}
			else
			{
				echo "-4"; // es obligatorio ingresar el rut asociado a la empresa a ingresar
			}		
				break;
			case isset($_POST["ClienteRut"]):
				
				$nombreEmpresa = null;
				$clienteDireccion = null;
				$idClienteEmpresa = null;
				$ClienteRut = null;
				$rut = null;
				$dv = null;
				
				$ClienteRut = split("-",trim($_POST["ClienteRut"]));
				$rut = $ClienteRut[0];
				$dv = $ClienteRut[1];
				$nombreEmpresa = trim($_POST["ClienteEmpresa"]);
				$clienteDireccion = trim($_POST["ClienteDireccion"]);
				$idClienteEmpresa = $_POST["idclienteEmpresa"];
				$respuesta = 0;
				if(controlNumerico::validadorRut($rut,$dv) && $nombreEmpresa!=null && ($idClienteEmpresa!=null && $idClienteEmpresa>0))
				{
					$data = array($rut,$dv,$nombreEmpresa,$clienteDireccion,$idClienteEmpresa);
					$respuesta = controlCliente::updateDataClientes($data);
				}
				
				switch ($respuesta)
				{
					case 1:
						
						echo "1";
						
						break;
						
					case 0:

						echo "0"; //el rut no es valido, o faltan los datos.
						
						break;
				}
				break;

			case isset($_POST["pisoEditCliente"]):
				//print_r($_POST); die();
				
				$totaldet= null;
				$idCliente = null;
				$inicio = 1;
				$filtro = 0;
				$resultado = null;
				$totaldet = $_POST["totaldet"];
				
				$idCliente = $_POST["pisoEditCliente"];
				$dataUpdatePisooff = null; 
				$name = "checkbox_";
				
				if($totaldet!=null && $totaldet>0 && $idCliente!=null)
				{
					while($inicio<=$totaldet)
					{
						$filtro = $name.$inicio;
					
						if(isset($_POST[$filtro]))
						{
							$dataUpdatePisooff = array($idCliente,$inicio);
							$resultado = controlCliente::vinculoPisoOficinaCliente($dataUpdatePisooff);
				
						}
						else
						{
							if(controlCliente::getDetalleCliente($idCliente,null,$inicio)!=null) //si estaba seleccionado y luego fue des-seleccionado.....(para eso es esta parte)
							{
								$dataUpdatePisooff = array(null,$inicio);
								$resultado = controlCliente::vinculoPisoOficinaCliente($dataUpdatePisooff);
							}
						}
						
						$inicio++;
					}
				
				}
				else
				{
					$resultado = -5; //-5 no hay pisos almacenados en la tabla, no se logro capturar el idCliente, || -2 fala en el update, 1 todo esta ok. 
				}	
				
				echo $resultado;
				break;
				
			case isset($_POST["pisoEditEstac"]):
				//print_r($_POST);
				//die();
				$idCliente = null;
				$totaldet = null;
				$filtro = null;
				$inicio = 1;
				$resultado = null;
				
				$idCliente = $_POST["pisoEditEstac"];
				$totaldet = $_POST["totaldetEstac"];
				$dataUpdateEstacinamiento = null;
				$name = "checkbox__";
				
				if($totaldet!=null && $totaldet>0 && $idCliente!=null)
				{
					while($inicio<=$totaldet)
					{
						$filtro = $name.$inicio;
						
						if(isset($_POST[$filtro]))
						{
							$dataUpdateEstacinamiento = array($idCliente,$inicio);
							$resultado = controlCliente::vinculoEstacionamientoCliente($dataUpdateEstacinamiento);
						}
						else
						{
							//echo $inicio;
							//echo"<br>";
							if(controlCliente::getestacionamieto($idCliente,null,$inicio)!=null)
							{
								
								$dataUpdateEstacinamiento = array(null,$inicio);
								$resultado = controlCliente::vinculoEstacionamientoCliente($dataUpdateEstacinamiento);
							}
						}
						$inicio++;
					}
				}
				
				echo $resultado;
				
				break;
				case isset($_POST["pisoEditEstacVisita"]):
				
					//print_r($_POST);die();
					$idCliente = $_POST["pisoEditEstacVisita"];
				
					$tmp = urldecode($_POST["totaldetEstacVisita"]);
					$tmp = unserialize($tmp);
				
					$totalEstac =$tmp; //$_POST["totaldetEstacVisita"];
					//print_r($totalEstac);
					//die();
					$inicio = 1;
					$name = "checkbox___";
					$filtro = null;
					$resultado = "-2";
					$dataUpdateEstaVisitas = null;
					//print_r($_POST);
					if($totalEstac!=null && $totalEstac>0 && $idCliente!=null)
					{
							
						foreach ($totalEstac as $esta)
						{
							$filtro = $name.$esta->getidEstacionamiento();
							;
							if(isset($_POST[$filtro]))
							{
								//die("aqui");
								//print_r($filtro);
								//die();
								$dataUpdateEstaVisitas = array(1,$esta->getidEstacionamiento());
								$resultado = controlCliente::actualizaEstaVisitaDeCliente($dataUpdateEstaVisitas);
							}
							else
							{
									
								//en pruebas esta parte del codigo
								//print_r($filtro);
								if(controlCliente::getestacionamieto($idCliente,null,$esta->getidEstacionamiento())!=null)
								{
									$dataUpdateEstaVisitas = array(0,$esta->getidEstacionamiento());
									$resultado = controlCliente::actualizaEstaVisitaDeCliente($dataUpdateEstaVisitas);
								}
							}
				
				
						}
							
							
					}
				
					echo $resultado;
				
					break;
			default:
				/*echo "<pre>";
				print_r($_POST);
				echo "</pre>";*/
				
			//case isset($_POST["rut"])
	}
}
else
{
	if($_GET!=null)
	{
		switch ($_GET)
		{
			case isset($_GET["idClienteEmpresaEdit"]):
				
				$idCliente = null;
				$cliente = null;
				
				$idCliente = $_GET["idClienteEmpresaEdit"];
				$cliente = controlCliente::getClienteId($idCliente);
				
				echo $cliente->getidCliente()."&".$cliente->getrut()."-".$cliente->getdv()."&".$cliente->getnombreEmpresa()."&".$cliente->getdireccion(); 
				break;
			
			case isset($_GET["idClientePisos"]):
				
				$idCliente = null;
				$cliente = null;
				$detalleCliente = null;
				$dataajaxPisosOf = null;
				
				$idCliente = $_GET["idClientePisos"];
				$cliente = controlCliente::getClienteId($idCliente);
				$detalleCliente = controlCliente::getDetalleCliente($idCliente);
				
				if($detalleCliente!=null && count($detalleCliente)>0)
				{
					foreach ($detalleCliente as $detalle)
					{
						if($dataajaxPisosOf==null)
						{
							$dataajaxPisosOf = $detalle->getidDetallecliente();
						}
						else
						{
							$dataajaxPisosOf = $dataajaxPisosOf."&".$detalle->getidDetallecliente();
						}
					}
					
				}
					echo $dataajaxPisosOf."_".$cliente->getnombreEmpresa(); // agregar el nombre del cliente y los pisos que le corresponden(esta como opción)
					//$arr = array("asd","asd","123","234f","145236","qwesx");
					
						
				break;	
		}
	}
	
}
?>