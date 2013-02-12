<?php
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlUsuario.class.php');
require_once 'src/classes/controlCliente.class.php';
require_once ("src/classes/controlDetalleVisita.class.php");
require_once 'src/classes/controlReserva.class.php';
require_once 'src/classes/controlNumerico.class.php';
require_once ('src/core/conexionMySQLi.class.php');
require_once ('src/core/conexionBD.php');
require_once ('src/core/conf.class.php');
require_once ('src/classes/sendEmail.class.php');
require_once ('src/classes/generaQR.class.php');
require_once ('src/classes/controlLogSistema.php');
require_once ("src/classes/phpqrcode.php");

//session_start();
//$arr= array("16556710","2","NULL","Gonzalo Heredia","las vervenas 06","5465877","gheredia@debian.cl","Info","NULL","Peatonal","DreamIT");
//controlVisita::insertVisita($arr);
//$arr = array("BECHTEL","Solo es una prueba",md5("123456"),"prueba@BECHTEL.cl","3");
//controlUsuario::insertUsuario($arr);
//print_r(controlCliente::getCliente(2));
//controlDetalleVisita::insertVisitaCliente("42","1");
//print_r($_SESSION["usuario_gk"]);
/*$rutc = "165567102-";

$cut = strpos($rutc,"-");
if($cut==8)
{
	echo "ok";
}
else
{
	echo "_".$cut;
}
*/
//QRcode::png("asdasd","/var/www/html/gestkontrol/"."ok.png","Q","6","2");
//generaQR::creaQR("Solo es una prueba de la totalidad del sistema","","codigoAcceso.png");
//echo "asdasdasdasdadasdasd";

//$data = array($_POST["idcliente"],"null",$_POST["idvisita"],$fechaEntrada,"null",$peatonOauto,$frecuencia,$_POST["Piso"],$_POST["Oficina"],"null","null","null",$_POST["idvisita"]*10,"null");
/*$data =  array(42,null,50,"2012-07-17 18:00:00",null,"Peatonal",1,10,201,null,"Reservado",null,50*10,null);
$dia = array("lunes"=>1,"martes"=>0,"miercoles"=>1,"jueves"=>0,"viernes"=>0,"sabado"=>0,"domingo"=>0);
//echo $dia["martes"];
//print_r(controlReserva::insertReservaFrecuente($data,$dia));*/
//print_r(controlReserva::getReservaAssClienteVisita(41,55,"2012-07-17 06:06:00"));
//  UPDATE visita SET rut = ?,dv = ?,pasaporte = ?,nombre =?, contacto = ? WHERE idVisita = ?
//print_r(controlVisita::editaVisita(array("17856123","4","123","Cambio Total","cambio@cambio.cl",50)));
//fechaEntrada = ?, tipoReserva = ?,piso = ?, oficina = ?,estacionamientoAsignado = ?,patenteVehiculo = ?  WHERE idCliente = ? ,idVisita = ?,idReserva = ?
//print_r(controlReserva::updateReserva(array("2012-07-24","Peatonal",5,202,null,null,41,55,16),null));
/*$fechahora = new FechaHora();
print_r($fechahora->getFechaHoraI());
*/
//fechaHora,tipo,resumen,uri,ip,aplicacion,usuario,estadoRevision,observaciones
//print_r(controlLogSistema::crateLogSistema(array("Log Sistema","Reporte Rutina Diaria","s/uri","x","Gestkontrol","root","Sin estado","Una rutina que regulariza las reservas del sistema gestkontrol")));

//$horaEntradaRfE = split("","12:25 AM");
//print_r($horaEntradaRfE);
//rut,dv,pasaporte,nombre,direccion,telefono,contacto,rubro,servicio,tipoVisita,empresa,idCliente
/*if(count(controlVisita::verificaSiRutNoEx(null,array(null,null,null,"Gonzalo Heredia",null,"gheredia@dreamit.cl",null,null,null,"normal",null,42)))==1)
{
	print_r(controlVisita::verificaSiRutNoEx(null,array(null,null,null,"Gonzalo Heredia",null,"gheredia@dreamit.cl",null,null,null,"normal",null,42)));
}
else
{
	echo "wuena";
}*/
/*$and = false;
$filtro = $and? " AND dv=?":" dv=?";

echo $filtro;*/
//print_r(controlVisita::countVisitaCliente(42));
/*$clientes = controlCliente::listaClientes(" ");
foreach ($clientes as $cli)
{
	print_r($cli);
}*/
//print_r(controlReserva::getReservas(null,null,42,55));
/*print_r($rut);
echo "<br>";
print_r(trim($rut));*/
/*$vis = controlVisita::getVisita(42);
$ada = array(1);
if(count($ada)==1)
{
	print_r($ada[0]);
}
else 
{
	echo "no";
}*/
//$dv = "k";
//print_r(controlNumerico::validadorRut($rut,$dv));
/*$multi = 2;
$suma=0;
$mod = 11;
for($i= strlen($rut); $i>0; $i--)
{
	if($multi>7)
	{
		$multi= 2;
	}
	$suma = ($rut%10)*$multi+$suma;
	//echo $suma."<br>";
	$rut = $rut/10;
	$multi ++;
}
switch ($dv)
{
	case "k":
		$dv = 10;
		break;
		
	case "0":
		$dv = 11;
		break;
}


$control = $mod-($suma%$mod);
//echo $control;
if($control == $dv)
{
	echo "wuena sapbe";
}
else
{
	echo "no sapbe";
}*/
//echo $control;

//print_r(controlReserva::isHaveReserva(42,48,0));
//$fechahora = new FechaHora();
//print_r(controlUsuario::contarUsuarios());
//print_r($fechahora->inverFecha("2012-08-08"));

/*$prueba = "UPDATE ASLDOFGLD From Set jklasdnasd";
$prueba2 = "INSERT INTO visita VALUES()";
$control = strpos($prueba,"INTO");
echo $control;*/

/*$sql = conexionMySQLi::getInstance();
$visita = null;
$sentencia = "INSERT INTO visita (rut,dv,pasaporte,nombre,apellido,direccion,telefono,rubro,contacto,servicio,tipoVisita,empresa) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$arr= array("16556710","2",NULL,"Gonzalo,","Heredia","las vervenas 06","5465877","gheredia@debian.cl","Info",NULL,"Peatonal","DreamIT");
//$data = array(15652154,5,null,null,null,null,null,null,null,null,null,null);

echo "idVisita = ".$sql-> ejecutarSentencia($sentencia,$arr);
*/
//print_r(controlVisita::countVisitaCliente(43,"normal"));

//echo mail("estudiofenoma@gmail.com","Prueba","Este es el cuerpo del mensaje","From: Edificio Titanium <pepito@desarrolloweb.com>");
//print_r(date('Y-m-d', strtotime('next tuesday')));
//print_r(date("w"));
/*$x = 10;
$y = 5;
switch ($x)
{
	case $x>0:
			echo "hola".$y;
		break;
	
}*/
/*
 * htmlspecialchars(); formularios AGREGAR!!!!!!!
 * 
 * */

//print_r(controlVisita::verificaSiRutNoEx("16205568",null,null,null,null));
/*
$url = "yaaa po si es la wuea que deberia funcionar mejor";
$img = "src/gqr/codigo2.png";
QRcode::png($url,$img,"Q","5",2);

$casilla = 'gheredia@debian.cl';

$asunto = 'Acá va el asunto del email';

$cabeceras = "From: Gonzalo Heredia \n";
$cabeceras .= "Reply-To: prueba@prueba.cl \r\n";
$cabeceras .= "CC: desarrolloDreamit@dreamit.cl\r\n";
$cabeceras .= "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
$mensaje = '<html><body>';
$mensaje .= '<img src="http://localhost/workspace/gestkontrol/src/gqr/codigo2.png" alt="Space Invaders" />';
$mensaje .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$mensaje .= "<tr style='background: #eee;'><td><strong>Nombre:</strong> </td><td>Edificio Titaniun La Portada</td></tr>";
$mensaje .= "<tr><td><strong>Email:</strong> </td><td>email</td></tr>";
$mensaje .= "<tr><td><strong>Tipo:</strong> </td><td>Tipo</td></tr>";
$mensaje .= "<tr><td><strong>Prioridad:</strong> </td><td>prioridad</td></tr>";
$mensaje .= "<tr><td><strong>Nombre de usuario a cambiar (principal):</strong> </td><td>Gonzalo Heredia</td></tr>";
$addURLS = "user";
$agregarUsuario = "Gonzalo";
if (($agregarUsuario) != '') {
	$mensaje .= "<tr><td><strong>Nombre alternativo (adicional):</strong> </td><td>" . $agregarUsuario . "</td></tr>";
}
$curText = htmlentities("asdasdsad");
if (($curText) != '') {
	$mensaje .= "<tr><td><strong>Contenido actual:</strong> </td><td>Contenido Actual</td></tr>";
}
$mensaje .= "<tr><td><strong>Nuevo contenido:</strong> </td><td>nuevo contenido</td></tr>";
$mensaje .= "</table>";
$mensaje .= "</body></html>";

mail($casilla, $asunto, $mensaje, $cabeceras);
*/
/*$date = new DateTime("2012-07-05 16:43:21", new DateTimeZone('America/Santiago'));
date_default_timezone_set('America/Santiago');
echo "".date("Y-m-d h:iA", $date->format('U'));
*/
 
//mail("gheredia@debian.cl","bla bla","bla bla","hola");
//QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//$dato = array("DreamIT","Gonzalo Heredia","10/10/2012",34,340,"Peatonal","asd","asd");
//generaQR::creaQR("Solo es una prueba de la totalidad del sistema",null,"codigo Acceso.png");
//print_r(sendEmail::generaCuerpoMensaje($dato));

//sendEmail::enviarCorreos("ok","","Administracion Titanium La Portada","Usted tiene una invitacion de la empresa ".$dato[0],"gheredia@debian.cl",generaQR::creaQR("Solo es una prueba de la totalidad del sistema",null,"codigo42.png"),"Codigo de acceso.png",sendEmail::generaCuerpoMensaje($dato),true);
//phpinfo();
$primerDia=date('Y-m-d', strtotime('Monday this week'));
$ultimoDia=date('Y-m-d', strtotime('Sunday this week'));
echo $primerDia." ".$ultimoDia.'"';

?>

