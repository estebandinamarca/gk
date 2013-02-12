<?php
require_once ('src/view/gestionProveedorView.class.php');
if($_GET!=null)
{
	switch ($_GET)
	{
		case isset($_GET["proveedorEdirP"]):
			
			gestionProveedorView::getEditPerfilProveedor($_GET["idCliente"]);
			
			break;
			
		case isset($_GET["idProveedorReserva"]);

			gestionProveedorView::getReservaProveedor($_GET["idCliente"],$_GET["idProveedorReserva"]);
			//print_r($_GET);	
		
			break;
	}
	//print_r($_GET);
}
?>