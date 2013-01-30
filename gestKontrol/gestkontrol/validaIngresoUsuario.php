<?php
require_once ("src/classes/controlUsuario.class.php");
require_once ("src/classes/controlCliente.class.php");
require_once ("src/classes/controlOperador.class.php");
/*
 * Script PHP para ingreso de nuevo cliente
*
*
*/

if($_POST!=null)
{
	$flagInsercion=false;
	$insOpOK=false;
	if ($_POST["contrasenaUsuario"]!=$_POST["contrasenaUsuarioConf"]) echo "-3"; // Contraseñas no coinciden
	else
	{
		switch ($_POST)
		{
			case isset($_POST["nombreUsuario"]):


				/*			echo "<pre>";
			 	print_r($_GET);
			 	echo "<pre/>";
			 	
			 	//echo "1";
			 	die();*/
				//rut,dv,pasaporte,nombre,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa
			
				if($_POST["nombreCompletoUsuario"]!=""&&$_POST["nombreUsuario"]!=""&&$_POST["contrasenaUsuario"]!=""&&
					$_POST["contrasenaUsuarioConf"]!=""&&$_POST["correoUsuario"]!="") //Usuario  no esta ingresado en la DB
			
				{
					$operador=false;		
					//$nombre = $_POST["nombre"]." ".$_POST["apellido"];
	
					if ($_POST["radioOpcion"]=="usuarioCliente")
					{
						$nombreEmpresa=controlCliente::nombreCliente($_POST["select-empresa"]);
					
					
						$data = array($_POST["select-empresa"],$_POST["nombreUsuario"],$_POST["nombreCompletoUsuario"],md5($_POST["contrasenaUsuario"]),$_POST["correoUsuario"],
							$_POST["nivelUsuario"],	$nombreEmpresa);
						$flagInsercion=true;
					}
					else 
					{
						if ($_POST["telefonoOperador"]!=""&&$_POST["celularOperador"]!=""&&
								$_POST["ubicacionOperador"]!=""&&$_POST["orientacionOperador"]!="")
						{
							$seguridad=controlCliente::getidCliente("Seguridad");
							$data = array($seguridad,$_POST["nombreUsuario"],$_POST["nombreCompletoUsuario"],md5($_POST["contrasenaUsuario"]),$_POST["correoUsuario"],
									$_POST["nivelUsuario"],	"Seguridad");
							$operador=true;
							$flagInsercion=true;
						}
					}
					if ($flagInsercion==true)
					{
						switch(controlUsuario::insertUsuario($data))
						{
							case 1:
								if($operador==true)
								{
									$datos=array($_POST["telefonoOperador"],$_POST["celularOperador"],$_POST["ubicacionOperador"]
											,$_POST["orientacionOperador"],controlUsuario::getIdUsername($_POST["nombreUsuario"]));
									
									switch (controlOperador::insertOperador($datos))
									{
										case "1": $insOpOK=true;
												break;
										case "-1": $insOpOK=false;//
												break;
										
									}
									if($insOpOK==true)
									{
										echo "1"; // se realizo todo ok
											
										break;
									}
									else 
									{
										echo "-4"; //Operador ya ingresado
										break;
									}
								}
							
								echo "1"; // se realizo  todo ok
							
								break;

							case -2:
							
								echo "-2";	// La persona ya esta en el sistema
							
								break;

							default:
							
								echo "2"; //Problemas con el SQL
						}
					}
					else echo "-1";	  // No se han enviado todo los datos de operador.
					
					
					
				}
				else
				{
					echo "0";	  // No se han enviado todo los datos .
				}
				break;

			case isset($_POST["nombreClientes"]):

					//print_r($_POST);

					$nombreCompletoU = isset($_POST["nombreCompletoUsuario"])?$_POST["nombreCompletoUsuario"] : null;
					$nombreUsuario   = isset($_POST["nombreUsuarioCliente"])?$_POST["nombreUsuarioCliente"] : null;
					$contrasena = isset($_POST["contrasenaUsuario"])? $_POST["contrasenaUsuario"] : null;
					$contrasenaCf = isset($_POST["contrasenaUsuarioConf"])? $_POST["contrasenaUsuarioConf"] : null;
					$correoElec = isset($_POST["correoUsuario"])? $_POST["correoUsuario"] : null;
					$nivelUsuario = isset($_POST["nivelUsuario"]) && $_POST["nivelUsuario"]!=0 ? $_POST["nivelUsuario"] : null; 
					$idCliente = $_POST["nombreClientes"];
					
					$nombreEmpresa=controlCliente::nombreCliente($idCliente);
					
					$respuesta = null;
					//echo $nombreCompletoU."_".$nombreUsuario."_".$contrasena."_".$contrasenaCf."_".$correoElec."_".$nivelUsuario;
					if($idCliente!=null)
					{
						if($nombreCompletoU!=null && $nombreUsuario!=null && $contrasena!=null && $contrasenaCf!=null && $nivelUsuario!=null)
						{
							if($contrasena==$contrasenaCf)
							{
								$data = array($idCliente,$nombreUsuario,$nombreCompletoU,md5($contrasena),$correoElec,$nivelUsuario,$nombreEmpresa);
								$respuesta = controlUsuario::insertUsuario($data);
								// -2 el nombre de usuario ya existe
								// 1 exito en la insercion del nuevo usuario
								// 2 no se logro insertar la informacion
							}
							else
							{
								$respuesta = "-3"; // las contraseás no coinciden
								
							}
							//controlUsuario::insertUsuario($data)
						}
						else
						{
							$respuesta = "-1"; // no se completaron todo los cambos con (*)
						}
					}
					else 
					{
						$respuesta = "406"; //falla de Sistema
					}
					
					echo $respuesta;
					
				break;	
			default:
				echo "<pre>";
				//print_r($_POST);
				echo "</pre>";

			//case isset($_POST["rut"])
		}
	}
}
else
{
	//echo "<pre>";
	print_r($_GET["id"]);
	//echo "</pre>";
}
?>
