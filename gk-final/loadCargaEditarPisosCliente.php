<?php
require_once ('src/view/gestionClienteView.php');
if(isset($_GET))
{	
	
	switch ($_GET) 
	{
		case isset($_GET["editarPisos"]):
			
			gestionClienteView::getEditarPisoCliente($_GET["idCliente"]);
			
		break;
		
		case isset($_GET["editarEstac"]):
			
			gestionClienteView::geteditarEstacionamiento($_GET["idCliente"]);
			//print_r($_GET);
			break;
			
		default:
			
		break;
	}
	
	//echo "hola";
}


?>