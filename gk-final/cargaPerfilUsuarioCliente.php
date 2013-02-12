<?php
require_once ('src/view/gestionUsuarioView.php');

//print_r($_GET);
if(isset($_GET))
{
	switch ($_GET)
	{
		case isset($_GET["userClieteEdirP"]):
			
			//print_r($_GET);	
			gestionUsuarioView::getFormData($_GET["idnick"],$_GET["userClieteEdirP"]);
			
			break;
					
	}
}
	
?>