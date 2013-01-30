<?php
require_once ('src/classes/controlUsuario.class.php');
session_start();

if($_GET!=null && $_GET["logout"]==0)
{
	session_destroy();
	$_GET=null;
	echo "1";	
	
}
else 
{	
switch ($_POST)
{
	case  isset($_POST["password"]):

		$user = $_POST["usuario"];
		$pass = $_POST["password"];
		if($user!= null && $pass!= null)
		{
			$respuesta = controlUsuario::comparaLogin($user,md5($pass));
			
			
			if(isset($respuesta) && $respuesta!= null)
			{
				$_SESSION["usuario_gk"] = $respuesta;
				
				echo "1"; // esto lo capta ajax y da la orden de enviar al login
				/*echo "<pre>";
					//print_r($respuesta);
					echo $_SESSION["usuario_gk"]->getuserName();
					echo $_SESSION["usuario_gk"]->getPrivilegio();
					echo $_SESSION["usuario_gk"]->getuserName();
				echo "</pre>";*/
			}
			else
			{
				 echo "0";
			}
			

		}
		//echo "1";

		break;
		
	
		
	default:
		
		
}
}
?>