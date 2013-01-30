<?php
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlVisita.class.php');

$hoy = null;
$piso = null;
$frecuente = null;
$emp = null;
$trans = null;
$apellido = null;
$hoy = isset($_GET['hoy'])? $_GET['hoy'] : null; 
$piso = isset($_GET['piso'])? $_GET['piso'] : null;
$frecuente= isset($_GET['frecuente'])? $_GET['frecuente'] : null;
$emp= isset($_GET['emp'])? $_GET['emp'] : null;
$trans= isset($_GET['trans'])? $_GET['trans'] : null;

$apellido=isset($_GET['apellido'])? $_GET['apellido'] : null;
$rutCap=isset($_GET['rut'])? $_GET['rut'] : null;
$dvCap=isset($_GET['dv'])? $_GET['dv'] : null;
/*echo $hoy."<br>";
echo $piso."<br>";
echo $frecuente."<br>";
echo $emp."<br>";
echo $trans."<br>";
*/

$estado = "Reservada";

//$visitas = controlReserva::listarVisitasPorValidarGlobal($estado);
//################################################################3
if($hoy!=null&&$piso==null&&$frecuente==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy);
if($piso!=null&&$hoy==null&&$frecuente==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso);
if($frecuente!=null&&$hoy==null&&$piso==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,$frecuente);
if($trans!=null&&$hoy==null&&$frecuente==null&&$emp==null&&$piso==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,null,$trans);
if($emp!=null&&$hoy==null&&$piso==null&&$frecuente==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,null,null,$emp);
if($hoy!=null&&$piso!=null&&$frecuente==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso);
if($piso!=null&&$trans!=null&&$hoy==null&&$frecuente==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,null,$trans);
if($piso!=null&&$emp!=null&&$hoy==null&&$frecuente==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,null,null,$emp);
if($hoy!=null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp!=null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,$frecuente,$trans,$emp);
if($hoy!=null&&$piso!=null&&$frecuente!=null&&$trans!=null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,$frecuente,$trans);
if($hoy!=null&&$piso!=null&&$frecuente!=null&&$emp!=null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,$frecuente,null,$emp);
if($hoy!=null&&$piso!=null&&$frecuente!=null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,$frecuente);
if($hoy!=null&&$piso!=null&&$trans!=null&&$emp!=null&&$frecuente==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,null,$trans,$emp);
if($hoy!=null&&$piso!=null&&$trans!=null&&$frecuente==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,null,$trans);
if($hoy!=null&&$piso!=null&&$emp!=null&&$frecuente==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,$piso,null,null,$emp);
if($hoy!=null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$piso==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,$frecuente,$trans,$emp);
if($hoy!=null&&$frecuente!=null&&$trans!=null&&$piso==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,$frecuente,$trans);
if($hoy!=null&&$frecuente!=null&&$emp!=null&&$piso==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,$frecuente,null,$emp);
if($hoy!=null&&$frecuente!=null&&$piso==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,$frecuente);
if($hoy!=null&&$trans!=null&&$emp!=null&&$piso==null&&$frecuente==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,null,$trans,$emp);
if($hoy!=null&&$trans!=null&&$frecuente==null&&$piso==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,null,$trans,null);
if($hoy!=null&&$trans==null&&$emp!=null&&$piso==null&&$frecuente==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,$hoy,null,null,null,$emp);
if($piso!=null&&$frecuente!=null&&$trans!=null&&$emp!=null&&$hoy==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,$frecuente,$trans,$emp);
if($piso!=null&&$frecuente!=null&&$trans!=null&&$hoy==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,$frecuente,$trans);
if($piso!=null&&$frecuente!=null&&$emp!=null&&$hoy==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,$frecuente,null,$emp);
if($piso!=null&&$frecuente!=null&&$hoy==null&&$emp==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,$frecuente);
if($piso!=null&&$trans!=null&&$emp!=null&&$hoy==null&&$frecuente==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,$piso,null,$trans,$emp);
if($frecuente!=null&&$trans!=null&&$emp!=null&&$hoy==null&&$piso==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,$frecuente,$trans,$emp);
if($frecuente!=null&&$trans!=null&&$hoy==null&&$emp==null&&$piso==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,$frecuente,$trans,null);
if($frecuente!=null&&$emp!=null&&$hoy==null&&$piso==null&&$trans==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,$frecuente,null,$emp);
if($frecuente==null&&$emp!=null&&$hoy==null&&$piso==null&&$trans!=null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,null,$trans,$emp);
if($hoy==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado);

if($hoy==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido!=null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,null,null,null,$apellido);

if($hoy==null&&$piso==null&&$frecuente==null&&$trans==null&&$emp==null&&$apellido==null&&$rutCap!=null&&$dvCap!=null)$visitas = controlReserva::listarVisitasPorValidarGlobal($estado,null,null,null,null,null,null,$rutCap,$dvCap);

//###############################################################################################

$empresa="";
echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\">";
	
if(count($visitas)>0)
{
	foreach ($visitas as $result)
						{
							if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
							else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
							if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
							$empresa=$result->getnombreEmpresa();
							$idReserva = $result->getidReserva();
							$nombreVisita= $result->getnombreVisita()." ".$result->getapellido();
							$patente=$result->getpatente();
							$estacionamiento=$result->getestacionamientoAsignado();
							
							$provedor=controlVisita::getVisitaByIdReserva($result->getidReserva());
							
							if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
							else $tipoVisita = "Esporadico";
							if ($patente=="0"||$patente=="null")$patente="Sin Patente";
							$reser= controlReserva::getReservaPorId($result->getidReserva());
							
							if ($reser->gettipoReserva()=="Vehicular"||$reser->gettipoReserva()=="Vehiculo"||$patente!="Sin Patente")
							{
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
								{
									$nombreVisita=$provedor->getempresa();
									echo "<li data-icon=\"gear\" data-theme='a'>";
								}
								else echo "<li data-icon=\"gear\">";
								
								echo "<a name=\"$nombreVisita <br>Patente: $patente <br>Estacionamiento: $estacionamiento\" 
									id=\"opendialog-validar-vehiculo\" href=\"#\" data-transition=\"pop\"	title=\"$idReserva\">
									<p>Id: reserva".$result->getidReserva()."</p>";
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
									echo "Proveedor: ".$provedor->getempresa()."<br>";
									
								echo "<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
									<br>
									<p>$rut</p>
									<p>Patente: ".$patente." - Estacionamiento Asignado: ".$estacionamiento."</p>
									<p>Piso: ".$result->getpiso()." - Oficina: ".$result->getoficina()."</p>
									<p>Frecuencia visita: ".$tipoVisita." </p>
									<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> ".$result->getfechaEntrada()."</p>
									<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> ".$result->getfechaSalida()."</p>
									<br>
									Estado: ".$result->getestadoValidacion()."</a></li>";
							}
							else 
							{
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
									{
										$nombreVisita=$provedor->getempresa();
										echo "<li data-icon=\"gear\" data-theme='a'>";
									}
								else echo "<li data-icon=\"gear\">";
								
								echo "<a name=\"$nombreVisita\" id=\"opendialog-validar-peaton\" href=\"#\" data-transition=\"pop\"
									title=\"$idReserva\">";
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
									echo "Proveedor: ".$provedor->getempresa()."<br>";
								echo "
									<p>Id: reserva".$result->getidReserva()."</p>
									<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
									<br>
									<p>$rut</p>
									<p>Frecuencia visita: ".$tipoVisita." </p>
									<p>Piso: ".$result->getpiso()." - Oficina: ".$result->getoficina()."</p>
									<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> ".$result->getfechaEntrada()."</p>
									<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> ".$result->getfechaSalida()."</p>
									<br>
									Estado: ".$result->getestadoValidacion()."</a></li>";
							}
			
						}
			
					}
echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
			
echo "</ul>";

?>