<?php



?>
<script>
$(document).ready(function(){
	$('#horario').change(function(){
		var hor = document.getElementById("horario").value;
		if(hor == "interval"){
			document.getElementById("horarioi").style.display="block";
			document.getElementById("horariot").style.display="block";
		}else{
			document.getElementById("horarioi").style.display="none";
			document.getElementById("horariot").style.display="none";
		}
	});
	$('#periodo').change(function(){
		var hor = document.getElementById("periodo").value;
		if(hor == "day"){
			document.getElementById("fesp").style.display="block";
			document.getElementById("fechai").style.display="none";
			document.getElementById("fechat").style.display="none";			
		}else{
			if(hor == "interval"){
				document.getElementById("fesp").style.display="none";
				document.getElementById("fechai").style.display="block";
				document.getElementById("fechat").style.display="block";
			}else{
				document.getElementById("fesp").style.display="none";
				document.getElementById("fechai").style.display="none";
				document.getElementById("fechat").style.display="none";
			}
		}
	});
	$('#GenReport').click(function(){
		var nombre = document.getElementById("registro").value;
		var piso = document.getElementById("piso").value;
		var empresa = document.getElementById("empresa").value;
		var horario = document.getElementById("horario").value;

		var horarioi = document.getElementById("horai").value;
		var horariot = document.getElementById("horat").value;
		
		var periodo = document.getElementById("periodo").value;

		var fechai = $('input[name=fechain]').val();//document.getElementById("fechai").value;
		var fechat = $('input[name=fechate]').val(); //document.getElementById("fechat").value;
		var fesp = $('input[name=fesp]').val();//document.getElementById("fesp").value;
		
		var result = document.getElementById("result").value;
		var group = document.getElementById("group").value;

		var url = 'reporteGen.php?registro='+nombre+'&piso='+piso+'&empresa='+empresa+'&horario='+horario+'&horarioi='+horarioi+'&horariot='+horariot+'&periodo='+periodo+'&fechai='+fechai+'&fechat='+fechat+'&fesp='+fesp+'&result='+result+'&group='+group;
		
		$("#reporte").load(url,function(){
			 $('#reporte').trigger('create');
	 	});
	});
});
</script>
<div data-role="content">
		<h3 style="text-align: center">
			<?php 
				if(isset($cliente) && count($cliente)>0)
				{
					echo $cliente->getnombreEmpresa();
				}
				else
				{
					echo " ";
				}
			?>
		</h3>
		<h3 style="text-align: center">Inicio » Nuevo Reporte</h3>
		<hr>
		<!-- /navbar -->

		<h4>Nueva visita</h4>
		<!-- Datos personales Visita -->
		<form action="get" id="reporteForm">
			<div data-role="collapsible" data-content-theme="c" data-theme="b" data-collapsed="false">
				<h3>Datos de Reporte</h3>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Tipo de registro:</label>
						<select name="nombre" id="registro">
							<option value="Ingreso">Entradas</option>
							<option value="Salida">Salidas</option>
							<option value="Agendada">Agendadas</option>
							<option value="Validada">Validadas</option>
							<option value="Caducada">Caducadas</option>
							<option value="todos" selected="selected">Todos</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Piso:</label>

					<select name="piso" id="piso">
						<option value="todos">Todos</option>
						<?php 
							for($i = -7; $i<55; $i++){
								if($i!=0){
									?><option value="<?php  echo $i; ?>">Piso <?php  echo $i; ?></option><?php
								}
							}
						?>
					</select>
						
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Cliente / Empresa:</label>
					<select name="empresa" id="empresa">
					<option value="todos">Todos</option>
					<?php 
					require_once("src/classes/controlCliente.class.php");
					//<input type="text" name="empresa" id="name" value="" />
					$clientes = controlCliente::listClienteHistory();
					
					foreach($clientes as $cliente){
						?><option value="<?php echo $cliente->getidCliente(); ?>"><?php  echo $cliente->getnombreEmpresa(); ?></option><?php
					}
					?>
					</select>
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Horario:</label>
					<!-- <input type="text" name="nombre" id="name"
						value="" /> -->
						<select name="horario" id="horario">
							<option value="todos">Todos</option>
							<option value="dia">09:00 - 19:00</option>
							<option value="noche">19:01 - 08:59</option>
							<option value="interval" >Intervalos</option>
						</select>
				</div>
				<div data-role="fieldcontain" id="horarioi" style="display: none;">
					<label for="name"><strong class="red"></strong> Hora de Inicio (HH:mm):</label>
						<input type="text" name="horaAnterior" id="horai"
						value="" />
				</div>
				<div data-role="fieldcontain" id="horariot" style="display: none;">
					<label for="name"><strong class="red"></strong> Hora de Término (HH:mm):</label>
						<input type="text" name="horaActual" id="horat"
						value="" />
						<input type="text" name="null" id="name" style="display: none;"
						value="" />
				</div>								
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Periodo:</label>
						<select name="periodo" id="periodo">
							<option value="todos">Todo</option>
							<option value="dia" >Este dia</option>
							<option value="semana" >Esta semana</option>
							<option value="mes" >Este Mes</option>
							<option value="anual" >Este Año</option>
							<option value="interval" >Intervalos</option>
							<option value="day" >Dia específico</option>
						</select>
				</div>
				<div data-role="fieldcontain" id="fechai" style="display: none;">
					<label for="name"><strong class="red"></strong> Fecha de Inicio (dd-mm-aaaa):</label>
						<input	name="fechain" id="mydate" type="date" data-role="datebox"	data-options='{"mode": "calbox"}'>
				</div>
				<div data-role="fieldcontain" id="fechat" style="display: none;">
					<label for="name"><strong class="red"></strong> Fecha de Término (dd-mm-aaaa):</label>
						<input	name="fechate" id="mydate" type="date" data-role="datebox"	data-options='{"mode": "calbox"}'>
				</div>								
				<div data-role="fieldcontain" id="fesp" style="display: none;">
					<label for="name"><strong class="red"></strong> Fecha Específica (dd-mm-aaaa):</label>
						<input	name="fesp" id="mydate" type="date" data-role="datebox"	data-options='{"mode": "calbox"}'>
				</div>								
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Resultado esperado:</label>
						<select name="result" id="result">
							<option value="report">Reporte procesado</option>
							<option value="granel">Tabla de datos</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong>Datos Agrupados por:</label>
						<select name="group" id="group">
							<option value="null">Sin agrupamiento</option>
							<option value="piso">Piso</option>
							<option value="empresa">Empresa</option>
							<option value="horas">Horas</option>
							<option value="dias">Días</option>
						</select>
				</div>
				<hr />

				<fieldset class="ui-grid-a">
					<a href="#" data-rel="dialog" data-role="button" data-theme="b"	data-inline="true" id="GenReport">Generar</a> 
						<a href="#"	data-rel="dialog" data-role="button" data-theme="c" rel="back" onClick="location.replace('index.php');"	data-inline="true">Volver</a> <!-- window.location.reload('index.php'); -->
				</fieldset>
			</div>
		</form>

	</div>