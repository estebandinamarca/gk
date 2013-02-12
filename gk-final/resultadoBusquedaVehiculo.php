<?php 
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlCliente.class.php');

$hoy = $_GET['hoy'];
$piso = $_GET['piso'];

		$estado = "Validada";
		$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado);
		if($hoy!=null)$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado,$hoy);
		if($piso!=null)$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado,null,$piso);
		if($piso!=null&&$hoy!=null)$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado,$hoy,$piso);
		if($piso==null&&$hoy==null)$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado);
		$empresa="";
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\">";
			
	
		foreach ($visitas as $result)
		{
			if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
			else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
			if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
			$empresa=$result->getnombreEmpresa();
			$idReserva = $result->getidReserva();
			$nombreVisita= $result->getnombreVisita();
			$patente=$result->getpatente();
			$estacionamiento=$result->getestacionamientoAsignado();
			if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
			else $tipoVisita = "No frecuente";
			echo "<li data-icon=\"gear\"><a name=\"$nombreVisita <br>Patente: $patente <br>Estacionamiento: $estacionamiento\" 
			id=\"opendialog-validar-vehiculo\" href=\"#\" data-transition=\"pop\"	title=\"$idReserva\">
			<p>Id: reserva".$result->getidReserva()."</p>
			<h3 class=\"ui-li-heading\">".$result->getnombreVisita()."</h3>
			<br>
			<p>$rut</p>
			<p>Patente: ".$patente." - Estacionamiento Asignado: ".$estacionamiento."</p>
			<p>Piso: ".$result->getpiso()." - Oficina: ".$result->getoficina()."</p>
			<p>Tipo visita: ".$tipoVisita." </p>
			<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> ".$result->getfechaEntrada()."</p>
			<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> ".$result->getfechaSalida()."</p>
			<br>
			Estado: ".$result->getestadoValidacion()."</a></li>";
			
		}
		echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
	
		echo "</ul>";
		?>