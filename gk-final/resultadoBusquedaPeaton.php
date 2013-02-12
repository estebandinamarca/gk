<?php 
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlCliente.class.php');

$hoy = null;
$hoy = isset($_GET['hoy'])?$_GET['hoy']: null;
$piso = isset($_GET['piso'])?$_GET["piso"]:null;

		$estado = "Validada";
		$empresa="";
		if($hoy!=null)$visitas = controlReserva::listaVisitasPorValidarPeaton($estado,$hoy);
		if($piso!=null)$visitas = controlReserva::listaVisitasPorValidarPeaton($estado,null,$piso);
		if($piso!=null&&$hoy!=null)$visitas = controlReserva::listaVisitasPorValidarPeaton($estado,$hoy,$piso);
		if($piso==null&&$hoy==null)$visitas = controlReserva::listaVisitasPorValidarPeaton($estado);
		
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\" id='resultadosPeaton'>";
		//Notice: Undefined index: hoy in /var/www/html/workspace/gestkontrol/resultadoBusquedaPeaton.php on line 6
		if ($visitas != "")
		{
	
		foreach ($visitas as $result)
		{
			if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
			else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
			if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
			$empresa=$result->getnombreEmpresa();
			$idReserva = $result->getidReserva();
			$nombreVisita= $result->getnombreVisita();
			if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
			else $tipoVisita = "No frecuente";	
			echo "<li data-icon=\"gear\"><a name=\"$nombreVisita\" id=\"opendialog-validar-peaton\" href=\"#\" data-transition=\"pop\"
			title=\"$idReserva\">
			<p>Id: reserva".$result->getidReserva()."</p>
			<h3 class=\"ui-li-heading\">".$result->getnombreVisita()."</h3>
			<br>
			<p>$rut</p>
			<p>Tipo visita: ".$tipoVisita." </p>
			<p>Piso: ".$result->getpiso()." - Oficina: ".$result->getoficina()."</p>
			<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> ".$result->getfechaEntrada()."</p>
			<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> ".$result->getfechaSalida()."</p>
			<br>
			Estado: ".$result->getestadoValidacion()."</a></li>";
		}
		}
		echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
		
		
		echo "</ul>";
?>