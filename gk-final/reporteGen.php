<?php
$reporte = array();
$tabla = true;

require_once "src/classes/fechaHora.php";

for($i=0; $i<10; $i++){
    $reporte[] = array("idReserva"=>$i,"nombres"=> "Nicolas Castillo", "idCliente"=>$i+10, "idOperador"=>$i+20, "idVisita"=>$i+15, "fechaEntrada"=> @fechaHora::getNowI(), "tipoReserva" => "Entrada", "estadoValidacion"=>"OK", "empresa"=>"prueba");
}
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
<h3>Inicio » Nuevo Reporte » Resultado</h3>
<hr>
<fieldset class="ui-grid-a">
    <a href="#reporte" data-direction="reverse" data-transition="fade" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
</fieldset>
<table class="ui-table">
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