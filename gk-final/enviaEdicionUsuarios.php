<?php
require_once "src/classes/controlUsuario.class.php";
require_once "src/classes/controlOperador.class.php";
//echo "llego";

$data = null;
$datos = null;

if($_POST!=null)
{
	switch ($_POST)
		{
			case isset($_POST["eidUser"]):
				//$daOriUser= controlUsuario::listUsuarios(null,$_POST["eidUser"]);
				if ($_POST['enewPass']!=null&&$_POST['enewPassConf']!=null)
				{
					if ($_POST['enewPass']!=$_POST['enewPassConf']) echo "3"; // No coincide pass nueva con antigua
					else 
					{
						if($_POST['elevel']!=null) $data=array($_POST['euserName'],$_POST['efullName'],md5($_POST['enewPass']),$_POST['email'],$_POST['elevel']);
						else $data=array($_POST['euserName'],$_POST['efullName'],md5($_POST['enewPass']),$_POST['email'],null);
					}
				}
				else 
				{
					if($_POST['elevel']!=null) $data=array($_POST['euserName'],$_POST['efullName'],null,$_POST['email'],$_POST['elevel']);
					else $data=array($_POST['euserName'],$_POST['efullName'],null,$_POST['email'],null);
				}
				
				switch (controlUsuario::editUser($_POST["eidUser"],$data))
				{
					case "1":
						echo "1"; //Todo OK
						break;
					case "0": 
						echo "4"; //No se realizo ningun cambio
						break;
					default:
						echo "2"; //Error SQL
				}
				break;
				
			case isset($_POST["eidUserOp"]):
				
				if ($_POST['enewPass']!=null&&$_POST['enewPassConf']!=null)
				{
					if ($_POST['enewPass']!=$_POST['enewPassConf']) echo "3"; // No coincide pass nueva con antigua
					else
					{
						if($_POST['elevel']!=null) $data=array($_POST['euserName'],$_POST['efullName'],md5($_POST['enewPass']),$_POST['email'],$_POST['elevel']);
						else $data=array($_POST['euserName'],$_POST['efullName'],md5($_POST['enewPass']),$_POST['email'],null);
					}
				}
				else
				{
					if($_POST['elevel']!=null) $data=array($_POST['euserName'],$_POST['efullName'],null,$_POST['email'],$_POST['elevel']);
					else $data=array($_POST['euserName'],$_POST['efullName'],null,$_POST['email'],null);
				}
				
				switch (controlUsuario::editUser($_POST["eidUserOp"],$data))
				{
					case "1":
						$datos= array($_POST['etel'],$_POST['ecel'],$_POST['eubi'],$_POST['eori']); 
						switch(controlOperador::editOperator($_POST['eidUserOp'],$datos))
						{
							case "1":
								echo "1"; //Todo OK
								break;
							case "0": 
								echo "1"; //No se realizo ningun cambio
								break;
							default:
								echo "2"; //Error SQL
						}
						break;
					case "0":
						$datos= array($_POST['etel'],$_POST['ecel'],$_POST['eubi'],$_POST['eori']);
						switch(controlOperador::editOperator($_POST['eidUserOp'],$datos))
						{
							case "1":
								echo "1"; //Todo OK
								break;
							case "0": 
								echo "4"; //No se realizo ningun cambio
							break;
							default:
								echo "2"; //Error SQL
						}
						break;
					
						
					default:
						echo "2"; //Error SQL
				}
				break;
				
			case isset($_POST["idUser"]):
				//echo $_POST["idUser"];
				$borraOp=false;
				if(controlOperador::getOperador($_POST["idUser"])!=null)
				{ 
					switch(controlOperador::deleteOperador($_POST["idUser"]))
					{
						case "1": 
							echo "1"; //Todo OK
							break;
						case "0":
							echo "4"; //no se afectaron filas
							break;
						default:
							echo "2"; //error SQL
					}
				}
				else{
					switch(controlUsuario::borrarUser($_POST["idUser"]))
					{
						case "1":
							echo "1";//Todo OK
							break;
						case "0":
							echo "4"; //No se afectaron filas
							break;
						default:
							echo "2"; //error SQL
					
					}
				}
				break;
				
			case isset($_POST["userCliente"]):

				//print_r($_POST);
				switch(controlUsuario::borrarUserG($_POST["userCliente"]))
				{
					case "1":
						echo "1";//Todo OK
						break;
					case "0":
						echo "4"; //No se afectaron filas
						break;
					default:
						echo "2"; //error SQL
				}
				
				break;
				
				default:
					echo "Falla";
		}
}
	

else
{
	echo "-1"; //Post nulo, notificar a admin
}
?>