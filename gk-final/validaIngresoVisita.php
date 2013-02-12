<?php
require_once ('src/classes/controlUsuario.class.php');
require_once ("src/classes/controlVisita.class.php");
/*
 * esta script php realizar el ingreso tanto de ingreso de visitas como la reserva.
 * 
 */
if($_POST!=null)
{
	switch ($_POST)
	{
		case isset($_POST["rut"]):
		
		
		/*echo "<pre>";
			print_r($_POST);
			echo "<pre/>";
			die();*/
			//rut,dv,pasaporte,nombre,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa		 
		if( ($_POST["rut"]!= null || $_POST["pasaporte"]!= null) && (strpos($_POST["rut"], "-") == 8) && ($_POST["nombre"] || $_POST["apellido"]))
		{
			
			$nombre = $_POST["nombre"]." ".$_POST["apellido"];
			$rutc = split("-", $_POST["rut"]);
			$data = array($rutc[0],$rutc[1],$_POST["pasaporte"],$nombre,"null","null","null",$_POST["correo"],"null","normal","null");
			
			switch(controlVisita::insertVisita($data,$_POST["idcliente"]))
			{
				case 1:
					
					echo "1"; // se realizo ok
					
					break;
				
				case -2:
					
					echo "-2";	// La persona ya esta en el sistema
					
					break;
				
				default: 
					
					echo "2"; //Problemas con el SQL 	
			} 
			
			
		}
		else
		{
			echo "0";	  // No se han enviado todo los datos.
		}
		break;
		
		
		default:
				echo "<pre>";
					print_r($_POST);
				echo "</pre>";
			
	//case isset($_POST["rut"])
	}
}
else
{
	//echo "<pre>";
	//print_r($_GET["id"]);
	//echo "</pre>";
}


?>