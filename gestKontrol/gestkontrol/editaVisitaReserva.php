<?php
require_once ('src/view/gestionVisitasView.class.php');
require_once ('src/classes/controlVisita.class.php');
if($_GET!=null)
{
	switch ($_GET["nombre"])
	{
		case 1:
				$visita = controlVisita::getVisitaWithId($_GET["id"]);
				echo $visita->getnombre()."\n";
				echo $visita->getrut()."-".$visita->getdv()."\n";
				
				/*echo "<pre>";
					print_r($visita);
				echo "</pre>";*/
			break;
		case 2:
			gestionVisitasView::getIngresoVisita($_GET["id"]);
			
			break;
			
	}
	//gestionVisitasView::getIngresoVisita();
}
else
{
	echo "nada";
}
if($_POST!=null)
{
	echo "vamosss";
}
?>