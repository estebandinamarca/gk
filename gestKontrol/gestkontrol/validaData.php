<?php
require_once ('src/classes/controlUsuario.class.php');
define('PATH_SOURCE_CLASSES','src/classes/');
define('PATH_SOURCE_CORE','src/core/');
define('PATH_ABSOLUTE',dirname(__FILE__).DIRECTORY_SEPARATOR);
if(!defined('PATH_SOURCE_CORE')) die ('Directorio de fuentes del nucleo no esta definida, por favor contacte al administrador o implementador.');
require_once(PATH_SOURCE_CORE.'conexionMySQLi.class.php');
require_once(PATH_SOURCE_CORE.'conf.class.php');
session_start();
switch ($_POST)
{
	case isset($_POST["password"]):
		
		$user = $_POST["usuario"];
		$pass = $_POST["password"];
		if($user!= null && $pass!= null)
		{
		  $respuesta = controlUsuario::comparaLogin($user,md5($pass));
		  
		  print_r($respuesta);
		  if(isset($respuesta) && $respuesta!= null)
		  {
		  	
		  }
		  else
		  {
		  	
		  }
		  echo "<pre/>";
		  
		}
		//echo "1";
		
		break;
}




?>