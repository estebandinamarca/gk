<?php
require_once 'src/classes/reporteControl.class.php';


//print_r($_GET); die;
$dataGetted = reporteControl::getRequest($_GET);
$tabla = true;

if(isset($_GET["result"]) && $_GET["result"] == "report") $tabla = false;
if(!isset($dataGetted["li"])) $dataGetted["li"] = 100; 
$reporte = $tabla?reporteControl::getTabla($dataGetted):reporteControl::getReporte($dataGetted);
//print_r($reporte);
/*
 *     [0] =&gt; Array
        (
            [idReserva] =&gt; 3654
            [idCliente] =&gt; 3648
            [idOperador] =&gt; 
            [idVisita] =&gt; 
            [fechaEntrada] =&gt; 2011-08-01 13:03:55
            [fechaSalida] =&gt; 
            [tipoReserva] =&gt; cliente
            [tipoFrecuencia] =&gt; 
            [piso] =&gt; 
            [oficina] =&gt; 
            [estacionamientoAsignado] =&gt; 
            [estadoValidacion] =&gt; Salida
            [momentoValidacion] =&gt; 
            [codigoReserva] =&gt; 
            [nombres] =&gt; Cecilia Celis Atria
            [empresa] =&gt; WINTER
        )
 * 
 * */
if(!$tabla){
	
	//print_r($reporte);
	
	?>
<table style="border: solid 1px #CCC;">
<tr>
	<th colspan="2">Reporte Generado</th>
</tr>
<tr>
	<th><?php echo $_GET["group"];//echo $reporte["group"]; ?></th><th>Registros</th>
</tr>
<?php 
$reporte = $reporte["data"];
foreach($reporte as $r){ ?>
<tr>
	<td><?php echo $r[0]; ?></td>
	<td><?php echo $r[1]; ?></td>
</tr>
<?php } ?> 
</table>	
	<?php

}else{

?>
<table style="border: solid 1px #CCC;">
<tr>
<th>Nombres</th>
<th>Fecha Hora</th>
<th>Tipo de evento</th>
<th>Cliente / Empresa</th>
</tr>
<?php foreach($reporte as $r){ ?>
<tr>
<td><?php echo $r["nombres"]; ?></td>
<td><?php echo $r["fechaEntrada"]; ?></td>
<td><?php echo $r["tipoReserva"]; ?></td>
<td><?php echo $r["estadoValidacion"]; ?></td>
<td><?php echo $r["empresa"]; ?></td>
</tr>
<?php } ?> 
</table>
<?php } ?>