<?php
require_once ('src/view/gestionClienteView.php');

if($_GET)
{
	switch($_GET["do"])
	{
		case "content-nuevo-cliente":
			gestionClienteView::getIngresoCliente();
			break;
		case "content-editar-cliente":
			gestionClienteView::getEditarCliente();
			break;
		
		default: header("Location: login.php");
	}
}
else header("Location: login.php");

?>





