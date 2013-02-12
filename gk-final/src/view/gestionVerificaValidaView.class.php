<?php
require_once ('src/classes/reserva.class.php');
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');
require_once ('src/classes/controlOperador.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlEdificio.class.php');

class gestionVerificaValidaView
{
	public function getViewValidarVisitasPeaton($idUsuario=null,$leveuser=null)
	{
		//echo $idUsuario."_".$leveuser;
		$idUser = null;
		$idUserLevel = null;
		if($idUsuario!=null && $leveuser!=null)
		{
			
		}
		?>
	<div data-role="page" id="validar-visitas-peaton">
	


	<div data-role="content">	
		<h3>Inicio » Validar Visitas Recepcion </h3>
		<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
			<div class="margen-inferior">
				<div data-role="controlgroup" data-type="horizontal" data-mini="true" class="botones-centrados">
	
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" >
							<input type="checkbox" name="fecha" id="fechaActual-peaton" class="custom"/>
         					<label for="fechaActual-peaton">Para Hoy</label>
         				
						<select name='select-choice-a' id='select-choice-a' data-native-menu='false' tabindex='-1' onchange="filtroPisoPeaton(this)">
							<option>Filtrar por Piso:</option>
							<option value='todos'>Todos</option>
							<?php
							$piso = controlCliente::listaPiso();
							foreach($piso as $resultado)
							{
								echo "<option value=".$resultado[0].">Piso ".$resultado[0]." </option>";
							}
							
							?>
							
						</select>
						</fieldset>
					</div>
				</div>
			</div>
	<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
				
	<!-- ES LA LISTA DEL VALIDAR VISITA!!! -->
	<div id="validacionPeaton"> 
	<?php 
		$estado = "Validada";
		$empresa="";
		$visitas = controlReserva::listaVisitasPorValidarPeaton($estado);
		
		
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\" id='resultadosPeaton'>";
		
		if ($visitas != null)
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
			else $tipoVisita = "Esporadico";	
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
		
		</div>
		</div><!-- /content -->
		</div><!-- /page -->
		<?php
		
	}
	
	
	public function getViewValidarVisitasVehiculo()
	{
		?>
		<div data-role="page" id="validar-visitas-vehiculo">
	


	<div data-role="content">	
		<h3>Inicio » Validar Visitas Vehiculares </h3>
		<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
			<div class="margen-inferior">
				<div data-role="controlgroup" data-type="horizontal" data-mini="true" class="botones-centrados">
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" >
							<input type="checkbox" name="fecha" id="fechaActual-vehiculo" class="custom"/>
         					<label for="fechaActual-vehiculo">Para Hoy</label>
         				
						<select name='select-choice-a' id='select-choice-a' data-native-menu='false' tabindex='-1' onchange="filtroPisoVehiculo(this)">
							<option>Filtrar por Piso:</option>
							<option value='todos'>Todos</option>
							<?php
							$piso = @controlCliente::listaPiso();
							foreach($piso as $resultado)
							{
								echo "<option value=".$resultado[0].">Piso ".$resultado[0]." </option>";
							}
							
							?>
							
						</select>
						</fieldset>
					</div>
				</div>
			</div>
	<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
				
	<!-- ES LA LISTA DEL VALIDAR VISITA!!! -->
	<div id="validacionVehiculo"> 
	<?php 
		$estado = "Validada";
		$visitas = controlReserva::listaVisitasPorValidarVehiculo($estado);
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
				$nombreVisita= $result->getnombreVisita();
				$patente=$result->getpatente();
				$estacionamiento=$result->getestacionamientoAsignado();
				if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
				else $tipoVisita = "Esporadico";
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
			
		}
		echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
			
		echo "</ul>";
			
		?>
		</div>
	</div><!-- /content -->
</div><!-- /page -->
		<?php 
	}
	
	public function getViewValidarVisitasGlobal()
	{
		//echo $idUsuario."_".$leveuser;
		$idUser = null;
		$idUserLevel = null;
		$idUsuario = null;
		if($idUsuario!=null && $leveuser!=null)
		{
				
		}
		$user=$_SESSION["usuario_gk"];
		$operator=controlOperador::getIdOperador($user->getIdUsuario());
		?>
			
				<h3>Inicio » Validar Visitas</h3>
				<!-- FILTROS DE BUSQUEDA DEL VALIDAR VISITA -->
					<div class="margen-inferior">
						<div data-role="controlgroup" data-type="horizontal"  data-mini="true" class="botones-centrados">
			
							<div data-role="fieldcontain">
								<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" >
									<!-- 
									<input type="checkbox" name="fecha" id="fechaActual-global" class="custom"/>
		         					<label for="fechaActual-global">Para Hoy</label>
		         					-->
		         					<input type="checkbox" name="fecha" id="frecuente-global" onclick="frecuenteGlobal()" class="custom"/>
		         					<label for="frecuente-global">Visitas Frecuentes</label>
		         					<select name='select-choice-a' id='select-choice-a' data-native-menu='false' tabindex='-1' onchange="filtroPisoGlobal(this)">
									<option>Filtrar por Piso:</option>
									<option value='todos'>Todos</option>
									<?php
									$piso=null;
									$s="a";
									$piso = controlReserva::listaPisoReserva($s);
									foreach($piso as $resultado)
									{
										echo "<option value=".$resultado[0].">Piso ".$resultado[0]." </option>";
									}
									
									?>
									
								</select>
		         					
		         				
		         				<select name='select-choice-a' id='select-choice-a' data-native-menu='false' tabindex='-1' onchange="filtroTransporteGlobal(this)">
									<option>Tipo de transporte:</option>
									<option value='todos'>Todos</option>
									<option value='Peatonal'>Peatonal</option>
									<option value='Vehicular'>Vehicular</option>
								</select>
								
								<select name='select-choice-a' id='select-choice-a' data-native-menu='false' tabindex='-1' onchange="filtroEmpGlobal(this)">
									<option>Cliente:</option>
									<option value='todos'>Todos</option>
									<?php
									$estado = "Reservada";
									$visitas = controlReserva::listarVisitasPorValidarGlobal($estado);
									$idempresa="";
									//$cliente = controlCliente::listaClientes($vac);
									if($visitas!=null && count($visitas)>0)
									{
									foreach($visitas as $result)
									{
										$idcliente=controlCliente::getidCliente($result->getnombreEmpresa());
										if($idcliente!=$idempresa)echo "<option value=".$idcliente.">".$result->getnombreEmpresa()." </option>";
										$idempresa=$idcliente;
										
									}
									}
									?>
									
								</select>
								
								<a href="#" data-role="button" data-icon="delete" onclick="window.location.reload();">Reestablecer</a>
		         				
								
								
								</fieldset>
							</div>
						</div>
					</div>
			<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
						
			<!-- ES LA LISTA DEL VALIDAR VISITA!!! -->
			<div id="validacionGlobal"> 
			
			<?php 
				
				$empresa="";
				?>
				<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme="d">
				<?php 
				if(count($visitas)>0)
					{
						foreach ($visitas as $result)
						{
							if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
							else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
							if($empresa!=$result->getnombreEmpresa()){?> <li data-role="list-divider"><?php echo $result->getnombreEmpresa();?></li><?php }
							$empresa=$result->getnombreEmpresa();
							$idReserva = $result->getidReserva();
							$nombreVisita= $result->getnombreVisita()." ".$result->getapellido();
							$patente=$result->getpatente();
							$estacionamiento=$result->getestacionamientoAsignado();
							
							if ($patente=="0"||$patente=="null")$patente="Sin Patente";
							$provedor=controlVisita::getVisitaByIdReserva($result->getidReserva());
							
							$reser= controlReserva::getReservaPorId($result->getidReserva());
							
							if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
							else $tipoVisita = "Esporadico";
							if ($reser->gettipoReserva()=="Vehicular"||$reser->gettipoReserva()=="Vehiculo"||$patente!="Sin Patente")
							{
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
								{
									$nombreVisita=$provedor->getempresa();
									?><li data-icon="gear" data-theme='a'><?php 
								}
								else { ?><li data-icon="gear"><?php }
								
								?>
								<a name="<?php echo $nombreVisita."<br>Patente: ".$patente." <br>Estacionamiento: ".$estacionamiento;?>" 
									id="opendialog-validar-vehiculo" href="#" data-transition="pop"	title="<?php echo $idReserva;?>">
									<p>Id: reserva<?php echo $result->getidReserva();?></p>
								<?php 
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
								{
									?>Proveedor: <?php echo $provedor->getempresa();?><br><?php 
								}
									
								?> <h3 class="ui-li-heading"><?php echo $result->getnombreVisita()." ".$result->getapellido();?></h3>
									<br>
									<p><?php echo $rut?></p>
									<p>Patente: <?php echo $patente;?> - Estacionamiento Asignado: <?php echo $estacionamiento;?>.</p>
									<p>Piso: <?php echo $result->getpiso();?> - Oficina: <?php echo $result->getoficina();?></p>
									<p>Frecuencia visita: <?php echo $tipoVisita;?> </p>
									<p class="ui-li-desc"><strong>Fecha de Entrada: </strong> <?php echo $result->getfechaEntrada();?></p>
									<p class="ui-li-desc"><strong>Fecha de Salida: </strong> <?php echo $result->getfechaSalida(); ?></p>
									<br>
									Estado: <?php echo $result->getestadoValidacion();?></a></li>
								<?php 
							}
							else 
							{
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
								{
									$nombreVisita=$provedor->getempresa();
									?>
									<li data-icon="gear" data-theme="a">
									<?php 
								}
								else 
								{
								?>
									<li data-icon="gear">
								<?php 
								}
								
								?>
								<a name="<?php echo $nombreVisita;?>" id="opendialog-validar-peaton" href="#" data-transition="pop"
									title="<?php echo $idReserva;?>">
								<?php 
								if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
								{
									?>Proveedor: <?php echo $provedor->getempresa();?>" <br><?php 
								}
								?>
									<p>Id: reserva<?php echo $result->getidReserva()?></p>
									<h3 class="ui-li-heading"><?php echo $result->getnombreVisita()." ".$result->getapellido();?></h3>
									<br>
									<p><?php echo $rut;?></p>
									<p>Frecuencia visita: <?php echo $tipoVisita;?></p>
									<p>Piso: <?php echo $result->getpiso();?> - Oficina: <?php echo $result->getoficina();?></p>
									<p class="ui-li-desc"><strong>Fecha de Entrada: </strong> <?php echo $result->getfechaEntrada();?></p>
									<p class="ui-li-desc"><strong>Fecha de Salida: </strong> <?php echo $result->getfechaSalida()?></p>
									<br>
									Estado: <?php echo $result->getestadoValidacion();?></a></li>
								<?php 
							}
			
						}
			
					}
					?>
				<!--li class="no-results" style= 'display:none;'>
					No se encontraron resultados. Puedo enviar un mensaje a la empresa para reservar a una visita. 
					<b><a onclick="botonVistaProv('#envia-mensaje-espera');" href="#envia-mensaje-espera" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" >Enviar Mensaje</a></b>
				</li-->
			
				</ul>
				
				</div>
				<script>
				function botonVistaProv(atributo)
				 {
					 //var atributo=$(this).attr("href");
					 //alert(atributo);
					 atributo=atributo.split("#");
					 //alert(atributo[1]);
					 atributo1="content-"+atributo[1]; 
					
					 $('#'+atributo1).load('cargadorVistasVerVal.php?do='+atributo1+'',function(){
						 $('#'+atributo1).trigger('create');
			 			});
				}
				</script>
				<script>
/*#####################----------Validacion peatonal y vehicular con pistola----------##############################*/
$(document).ready(function(){
	
	var esCarnet = false;
	var rutValido = false;
	var ope = "<?php echo $operator;?>";
	$("#validacionPeaton,#validacionVehiculo,#validacionGlobal").keydown(function(e) 
	{
		if (e.which=="13")
		{
			var reserva = $("input:jqmData(type='search')").attr('value');
			if (reserva != "" )
			{
					if (jQuery.inArray(";",reserva) > -1 && jQuery.inArray("-",reserva) > -1) esCarnet=true;
					if (esCarnet==true)
					{
						var partes = reserva.split(";");
						var rut = partes[0].split("-");
						$.ajaxSetup({async: false});
						$.get("verificaRut.php",{'rut':rut[0],'dv':rut[1]},function(datos){
							if (datos==1) rutValido=true;
							else rutValido=false; 
							});
						if (rutValido)
						{
							capturaRutDePistola(rut[0],rut[1]);
							capturaApellidoDePistola(partes[1]);
							//alert(rut[0]);
							$('#content-guarda-visita-cliente').load('cargadorVistasVerVal.php?do=content-guarda-visita-cliente',function(){
								 $('#content-guarda-visita-cliente').trigger('create'); //CREACION DE LA PAGINA QUE CARGA ESTILOS EN TABLET
								
	 						});
							 $.mobile.changePage($('#guarda-visita-cliente'),'pop',false,true);
							$("#apeVisitaGuardar").val(partes[1]);
							$("#rutVisitaGuardar").val(partes[0]);
							
							
					
							//AQUI VA LA PREGUNTA A LA CONFIGURACION!--
							
							//---------------------------------------
							
							/*
							$.get("validaConPistola.php",{'rut':rut[0],'dv':rut[1],'apellido':partes[1],'op':ope},function(datos){
								//alert(datos);
								datos=datos.split("&");
								piezas=datos[0].split("%");
								idReserva=piezas[0];
								idOperador=piezas[1];
								datos=datos[1];
								switch (datos)
								{
								
									case "1":
										//AQUI VA LA PREGUNTA A LA CONFIGURACION!--
										$.get("getConfiguracionTarjetas.php",function(data){
											switch(data)
											{
											case "1":
												$.mobile.changePage($('#pop-ingreso-tarjeta'),'pop',false,true);
												$("#idReservaTarjeta").val(idReserva);
												$("#idOperadorTarjeta").val(idOperador);
												break;
											case "0":
												$.get("validadorVisitasGeneral.php",{'idReservaTarjeta':idReserva,'idOperadorTarjeta':idOperador},function(dat){
													switch (dat)
													{
														case "1":
															document.getElementById("msgExito").innerHTML= "<h1 class=\"centrado\">"+rut[0]+"-"+rut[1]+"<br> "+partes[1]+"</h1>";
															$.mobile.changePage($('#popup-exito'),'pop',false,true);
															setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1000');
															break;
														default: 
															$.mobile.changePage($('#popup-error-db'),'pop',false,true);
															setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
															break;
													}
													});
												
											
												break;
											default: 
												$.mobile.changePage($('#popup-error-db'),'pop',false,true);
												setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
												break;
											

											}
											
											});
										//---------------------------------------
					 
										
										
										//document.getElementById("msgExito").innerHTML= "<h1 class=\"centrado\">"+rut[0]+"-"+rut[1]+"<br> "+partes[1]+"</h1>";
										
										//setTimeout(function(){window.location.reload();},'1000');
									
										break;
									case "2":
										document.getElementById("msgFracasoFrecuente").innerHTML= "<h1 class=\"centrado\">"+rut[0]+"-"+rut[1]+"<br> "+partes[1]+"</h1>";
										$.mobile.changePage($('#popup-fracaso-frecuente'),'pop',false,true);
										setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1500');
										break;
									case "3":
										document.getElementById("msgErrorVisitaValidada").innerHTML= "<h1 class=\"centrado\">"+rut[0]+"-"+rut[1]+"<br> "+partes[1]+"</h1>";
										$.mobile.changePage($('#popup-error-visita-validada'),'pop',false,true);
										setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1500');
										break;
									case "0":
										$.mobile.changePage($('#popup-error-db'),'pop',false,true);
										setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
										break;
									default:
																
										if(jQuery.inArray("+", datos)!="-1")
										{ 
											$.mobile.changePage($('#popup-muchos-rut'),'pop',false,true);
											setTimeout(function()
											{
												history.back();
												//window.location.reload();
												//$("input:jqmData(type='search') ul").listview('refresh');
											
												$('#validacionGlobal').load("resultadoBusquedaGlobal.php?rut="+rut[0]+"&dv="+rut[1]+"",function()
													{
														$('#validacionGlobal').trigger('create');
														$("input:jqmData(type='search')").val(rut[0]+"-"+rut[1]);
														$("input:jqmData(type='search')").prop('disabled', true);
													});
												
											},'1500');
										}
										else
										{ 
											$.mobile.changePage($('#popup-fracaso-rut'),'pop',false,true);						
											setTimeout(function()
											{
												history.back();
												//window.location.reload();
												//$("input:jqmData(type='search') ul").listview('refresh');
											
												$('#validacionGlobal').load("resultadoBusquedaGlobal.php?apellido="+partes[1]+"",function()
													{
														$('#validacionGlobal').trigger('create');
														$("input:jqmData(type='search')").val(partes[1]);
														$("input:jqmData(type='search')").prop('disabled', true);
													});
												
											},'1500');
										}
								}
							});*/
						} 
							//AQUI VA EL MENSAJE DE RUT NO VALIDO!!!!
						else 
						{
							$.mobile.changePage($('#popup-rut-invalido'),'pop',false,true);
							setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'2500');
						}	
						
					}
					//#####################  PROVEEDORES Y QR ##################################
					//## VER NOMENCLATURA DE LOS QR ##
					else
					{
						if(!isNaN(reserva))
						{
							var rutProv = reserva.slice(0,-1);
							var dvProv = reserva.slice(-1);
							$.ajaxSetup({async: false});
							$.get("verificaRut.php",{'rut':rutProv,'dv':dvProv},function(datos){
								if (datos==1) rutValido=true;
								else rutValido=false; 
								});
							if (rutValido)
							{
								$.ajaxSetup({async: true});
								capturaRutDePistola(rutProv,dvProv);
								$.get("validaConPistola.php",{'rut':rutProv,'dv':dvProv,'op':ope},function(datos){
									datos=datos.split("&");
									piezas=datos[0].split("%");
									idReserva=piezas[0];
									idOperador=piezas[1];
									datos=datos[1];
			
									if(jQuery.inArray("+", datos)!="-1")
									{
										datos=datos.split("+");
										nombreProveedor=datos[0];
										datos=datos[1];
									}
									else
									{
										nombreProveedor="";
									}
			
									
									switch (datos)
									{
									
										case "1":
											$.get("getConfiguracionTarjetas.php",function(data){
												switch(data)
												{
												case "1":
													$.mobile.changePage($('#pop-ingreso-tarjeta'),'pop',false,true);
													$("#idReservaTarjeta").val(idReserva);
													$("#idOperadorTarjeta").val(idOperador);
													break;
												case "0":
													$.get("validadorVisitasGeneral.php",{'idReservaTarjeta':idReserva,'idOperadorTarjeta':idOperador},function(dat){
														switch (dat)
														{
															case "1":
																document.getElementById("msgExito").innerHTML= "<h1 class=\"centrado\">Proveedor: <br>"+rutProv+"-"+dvProv+"<br>"+nombreProveedor+"</h1>";
																$.mobile.changePage($('#popup-exito'),'pop',false,true);
																setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'1000');
																break;
															default: 
																$.mobile.changePage($('#popup-error-db'),'pop',false,true);
																setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'2500');
																break;
														}
														});
													
												
													break;
												default: 
													$.mobile.changePage($('#popup-error-db'),'pop',false,true);
													setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'2500');
													break;
												

												}
												
												});
									

										break;
										case "2":
											document.getElementById("msgFracasoFrecuente").innerHTML= "<h1 class=\"centrado\">Proveedor: <br>"+rutProv+"-"+dvProv+"<br>"+nombreProveedor+"</h1>";
											$.mobile.changePage($('#popup-fracaso-frecuente'),'pop',false,true);
											setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'1500');
										break;
										case "3":
											document.getElementById("msgErrorVisitaValidada").innerHTML= "<h1 class=\"centrado\">Proveedor: <br>"+rutProv+"-"+dvProv+"<br>"+nombreProveedor+"</h1>";
											$.mobile.changePage($('#popup-error-visita-validada'),'pop',false,true);
											setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'1500');
										break;
										case "0":
											$.mobile.changePage($('#popup-error-db'),'pop',false,true);
											setTimeout(function(){url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();},'2500');
											break;
										case "-1":
											
											$.mobile.changePage($('#popup-muchos-rut'),'pop',false,true);
											setTimeout(function()
											{
												history.back();
												//window.location.reload();
												//$("input:jqmData(type='search') ul").listview('refresh');
											
												$('#validacionGlobal').load("resultadoBusquedaGlobal.php?rut="+rutProv+"&dv="+dvProv+"",function()
													{
														$('#validacionGlobal').trigger('create');
														$("input:jqmData(type='search')").val(rutProv+"-"+dvProv);
														$("input:jqmData(type='search')").prop('disabled', true);
													});
												
											},'1500');
											break;
										case "-2":
											$.mobile.changePage($('#estacionamiento-proveedor'),'pop',false,true);
											//Patente y estacionamientos habilitados
											$.get("getPatEst.php",{'rut':rutProv,'dv':dvProv,'pat':"1"},function(data){
											//alert(operador);
												$("#opEstProv").val(operador);
												data=data.split("#");
												$(".eNomProvee").html("<strong>"+data[0]+"</strong>");
										
												var datosRecibido= data[1].split("+");
												var idResProv = datosRecibido[0];
												$("#eidUserProvee").val(idResProv);
												datosRecibido = datosRecibido[1].split("$");
												$("#patenteProveedor").val(datosRecibido[0]);
												var estaciEstado= datosRecibido[1].split("-");
												//alert(datosRecibido[0]);
												//alert(estaciEstado.length);
												var estaciEstadi=new Array();
												for (i=0; i< estaciEstado.length;i++)
												{
													estaciEstadi.push(estaciEstado[i].split("_"));
												}
												//alert(estaciEstadi);
												for (i=0; i< estaciEstadi.length;i++)
												{
													//$("#est"+i).val(estaciEstadi[i][0]);
													//$("#lab"+i).text(estaciEstadi[i][0]);
													//alert(estaciEstado[i]);
													if(estaciEstadi[i][1]=="1")document.getElementById("est"+i).disabled = true;
													//document.getElementById("est"+i).innerText=estaciEstado[i];
													$("#est"+i).checkboxradio("refresh");
										
							            						
										
												}
											});
											break;
							
										case "-3":
											$.mobile.changePage($('#estacionamiento-proveedor'),'pop',false,true);
											//Patente y estacionamientos habilitados
											$.get("getPatEst.php",{'rut':rutProv,'dv':dvProv,'pat':"0"},function(data){
												$("#opEstProv").val(operador);
												data=data.split("#");
												$(".eNomProvee").html("<strong>"+data[0]+"</strong>");
												var datosRecibido= data[1].split("+");
												var idResProv = datosRecibido[0];
												$("#eidUserProvee").val(idResProv);
												var estaciEstado= datosRecibido[1].split("-");
												//alert(estaciEstado[1]);
												for (i=0; i< estaciEstado.length;i++)
												{
													$("#est"+i).val(estaciEstado[i]);
													if(estaciEstado[i+1]=="1")document.getElementById("est"+i).disabled = true;
													$("#est"+i).checkboxradio("refresh");
										
							            						
										
												}
									
											});
								
											break;	
											
										default:
														
											$.mobile.changePage($('#popup-fracaso'),'pop',false,true);
											setTimeout(function()
											{
												history.back();
												//window.location.reload();
												//$("input:jqmData(type='search') ul").listview('refresh');
											
												$('#validacionGlobal').load("resultadoBusquedaGlobal.php",function()
													{
														$('#validacionGlobal').trigger('create');
														
													});
												
											},'1500');
									}
								});
								
							}
							else
							{
								
								$.mobile.changePage($('#popup-rut-invalido'),'pop',false,true);
								setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
							}
							
						}
					}
					
				}
			}
	});
});

/*#####################----------FIN Validacion peatonal y vehicular con pistola----------##############################*/
rutPistola="";
dvPistola="";
apPistola="";
function capturaRutDePistola(rut,dv)
{
	rutPistola=rut;
	dvPistola=dv;
}
function capturaApellidoDePistola(apellido)
{
	apPistola=apellido;
}

</script>
				
				<?php
				
	}
	
	
	public function getViewVerificarVisitas()
	{
		?>
		
			<h3>Inicio » Verificar Visitas </h3>
			<div class="margen-inferior">
			<!-- <div data-role="controlgroup" data-type="horizontal" data-mini="true" class="botones-centrados">
				<a href="#" data-role="button">Hoy</a>
				<a href="#" data-role="button">Semana</a>
				<a href="#" data-role="button">Mes</a>
			</div>-->
		</div> 

		<div id="verificar">
		
		<?php 
		$empresa="";
		$nombre = "Validada";
		$visitas = controlReserva::buscarVisitasVerificar($nombre);
			
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\">";
		
		foreach ($visitas as $result)
		{
		
		
			if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
			else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
			if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
			$empresa=$result->getnombreEmpresa();
			$idReserva = $result->getidReserva();
			$nombreVisita= $result->getnombreVisita()." ".$result->getapellido();
			$patente=$result->getpatente();
			if ($patente=="0"||$patente=="null")$patente="Sin Patente";
			$provedor=controlVisita::getVisitaByIdReserva($result->getidReserva());
			
			$reser= controlReserva::getReservaPorId($result->getidReserva());
			
			$estacionamiento=$result->getestacionamientoAsignado();
			if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
			else $tipoVisita = "Esporadico";
			
			if ($reser->gettipoReserva()=="Vehicular"||$reser->gettipoReserva()=="Vehiculo"||$patente!="Sin Patente")
			{
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "<li data-icon=\"gear\" data-theme='a'>";
				else echo "<li data-icon=\"gear\">";
				
				echo "<a><p>Id: reserva".$result->getidReserva()."</p>";
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "Proveedor: ".$provedor->getempresa()."<br>";
				
				echo"
				<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
				<br>
				<p>$rut</p>
				<p>Piso: ".$result->getPiso()." - Oficina: ".$result->getoficina()."</p>
				<p>Tipo visita: ".$tipoVisita." </p>
				<p>Patente: ".$patente." - Estacionamiento Asignado: ".$estacionamiento."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> " .$result->getfechaEntrada()."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> " .$result->getfechaSalida()."</p>
				<p class=\"ui-li-desc\"><strong>Momento Validacion: </strong> " .$result->getmomentoValidacion()."</p>
				<br>
				Operador: ".$result->getnomOperador()."<br>
				Ubicacion: ".$result->getubicacion()."</a></li>";
			}
			else
			{
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "<li data-icon=\"gear\" data-theme='a'>";
				else echo "<li data-icon=\"gear\">";
				
				echo "<a><p>Id: reserva".$result->getidReserva()."</p>";
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "Proveedor: ".$provedor->getempresa()."<br>";
				
				echo "
				<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
				<br>
				<p>$rut</p>
				<p>Piso: ".$result->getPiso()." - Oficina: ".$result->getoficina()."</p>
				<p>Tipo visita: ".$tipoVisita." </p>
				<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> " .$result->getfechaEntrada()."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> " .$result->getfechaSalida()."</p>
				<p class=\"ui-li-desc\"><strong>Momento Validacion: </strong> " .$result->getmomentoValidacion()."</p>
				<br>
				Operador: ".$result->getnomOperador()."<br>
				Ubicacion: ".$result->getubicacion()."</a></li>";
			}
		}
		echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
		echo "</ul>";
		?>
			
		</div>
	

	
		<?php 
		
	}
	
	public function getViewModificarVisitas()
	{
		?>
			
			<h3>Inicio » Modificar Validaciones Efectuadas </h3>
			 <div class="margen-inferior">
			<!--<div data-role="controlgroup" data-type="horizontal" data-mini="true" class="botones-centrados">
				<a href="#" data-role="button">Hoy</a>
				<a href="#" data-role="button">Semana</a>
				<a href="#" data-role="button">Mes</a>
			</div>-->
		</div>  

		<div id="modificar">
		<?php 
		$empresa="";
		$nombre = "Validada";
		$visitas = @controlReserva::buscarVisitasModificar($nombre);
			
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\">";
	
		foreach ($visitas as $result)
		{
			if($result->getrut()==null&&$result->getdv()==null)$rut="Numero de pasaporte: ".$result->getpasaporte();
			else $rut="RUT: ".$result->getrut().'-'.$result->getdv();
			if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
			$empresa=$result->getnombreEmpresa();
			$idReserva = $result->getidReserva();
			$nombreVisita= $result->getnombreVisita()." ".$result->getapellido();
			if ($result->gettipoFrecuencia()==1)$tipoVisita = "Frecuente";
			else $tipoVisita = "Esporadico";
			
			$patente=$result->getpatente();
			
			if ($patente=="0"||$patente=="null")$patente="Sin Patente";
			$provedor=controlVisita::getVisitaByIdReserva($result->getidReserva());
							
			$reser= controlReserva::getReservaPorId($result->getidReserva());
			
			$estacionamiento=$result->getestacionamientoAsignado();
			if ($reser->gettipoReserva()=="Vehicular"||$reser->gettipoReserva()=="Vehiculo"||$patente!="Sin Patente")
			{
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
				{
					$nombreVisita=$provedor->getempresa();
					echo "<li data-icon=\"gear\" data-theme='a'>";
				}
				else echo "<li data-icon=\"gear\">";
								
				echo "<a name=\"$nombreVisita\" id=\"opendialog-modificar\" href=\"#\" data-transition=\"pop\"
				title=\"$idReserva\">
				<p>Id: reserva".$result->getidReserva()."</p>";
				
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "Proveedor: ".$provedor->getempresa()."<br>";
				
				echo"
				<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
				<br>
				<p>$rut</p>
				<p>Piso: ".$result->getPiso()." - Oficina: ".$result->getoficina()."</p>
				<p>Tipo visita: ".$tipoVisita." </p>
				<p>Patente: ".$patente." - Estacionamiento Asignado: ".$estacionamiento."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> " .$result->getfechaEntrada()."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> " .$result->getfechaSalida()."</p>
				<p class=\"ui-li-desc\"><strong>Momento Validacion: </strong> " .$result->getmomentoValidacion()."</p>
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
				
				echo "<a name=\"$nombreVisita\" id=\"opendialog-modificar\" href=\"#\" data-transition=\"pop\"
				title=\"$idReserva\">
				<p>Id: reserva".$result->getidReserva()."</p>";
				
				if ($provedor->gettipoVisita()=="proveedor"||$provedor->gettipoVisita()=="Proveedor")
					echo "Proveedor: ".$provedor->getempresa()."<br>";
								
				echo "
				<h3 class=\"ui-li-heading\">".$result->getnombreVisita()." ".$result->getapellido()."</h3>
				<br>
				<p>$rut</p>
				<p>Piso: ".$result->getPiso()." - Oficina: ".$result->getoficina()."</p>
				<p>Tipo visita: ".$tipoVisita." </p>
				<p class=\"ui-li-desc\"><strong>Fecha de Entrada: </strong> " .$result->getfechaEntrada()."</p>
				<p class=\"ui-li-desc\"><strong>Fecha de Salida: </strong> " .$result->getfechaSalida()."</p>
				<p class=\"ui-li-desc\"><strong>Momento Validacion: </strong> " .$result->getmomentoValidacion()."</p>
				<br>
				Estado: ".$result->getestadoValidacion()."</a></li>";
			}
		}
		echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
		echo "</ul>";
		?>
			
		</div>
	
		
		<?php 
	}
	
	
	
	public function popUpExito()
	{
		?>
		
		<div data-role="content" data-theme="c">
		<p class="centrado"><strong id="msgExito"></strong></p>
		<p class="centrado"><strong><h1 class="centrado">VALIDADA</h1></strong></p>
		</div>
		<?php 
	}
	
	public function popUpExitoProveedor()
	{
		?>
			
			<div data-role="content" data-theme="c">
			<p class="centrado"><strong id="msgExitoProveedor"></strong></p>
			<p class="centrado"><strong><h1 class="centrado">VALIDADA</h1></strong></p>
			</div>
			<?php 
		}
	
	public function popUpModif()
	{
		?>
			<div data-role="content" data-theme="c">
			<p class="centrado"><strong id="msgModifica"></strong></p>
			<p class="centrado"><strong><h1 class="centrado">VISITA MODIFICADA</h1></strong></p>
			</div>
			<?php 
	}
	
	public function popUpFracaso()
	{
		?>
				<div data-role="content" data-theme="c">
				<p class="centrado"><strong id="msgFracaso"></strong></p>
				<p class="centrado"><strong><h1 class="centrado">NO SE ENCUENTRA EN REGISTROS</h1></strong></p>
				</div>
		<?php 
	}
	
	public function popUpFracasoRut()
	{
		?>
					<div data-role="content" data-theme="c">
					<p class="centrado"><strong id="msgFracasoRut"></strong></p>
					<p class="centrado"><strong><h1 class="centrado">RUT NO ENCONTRADO</h1></strong></p>
					<p class="centrado"><strong><h1 class="centrado">SE BUSCA APELLIDO</h1></strong></p>
					</div>
			<?php 
	}
	
	public function popUpMuchosRut()
	{
		?>
						<div data-role="content" data-theme="c">
						<p class="centrado"><strong id="msgMuchosRut"></strong></p>
						<p class="centrado"><strong><h1 class="centrado">RUT CON VARIAS RESERVAS</h1></strong></p>
						<p class="centrado"><strong><h1 class="centrado">SE BUSCA RUT</h1></strong></p>
						</div>
				<?php 
		}
	
	public function popUpFracasoFrecuente()
	{
		?>
						<div data-role="content" data-theme="c">
						<p class="centrado"><strong id="msgFracasoFrecuente"></strong></p>
						<p class="centrado"><strong><h1 class="centrado">NO PERTENECE A DIA DE HOY</h1></strong></p>
						</div>
				<?php 
	}
	
	public function popUpErrorDb()
	{
		?>
							<div data-role="content" data-theme="c">
							<p class="centrado"><strong id="msgErrorDb"></strong></p>
							<p class="centrado"><strong><h1 class="centrado">ERROR</h1></strong></p>
							<p class="centrado"><strong><h1 class="centrado">CONTACTESE CON ADMINITRACION</h1></strong></p>
							</div>
		<?php 
	}
	public function popUpErrorVisitaValidada()
	{
		?>
								<div data-role="content" data-theme="c">
								<p class="centrado"><strong id="msgErrorVisitaValidada"></strong></p>
								<p class="centrado"><strong><h1 class="centrado">VISITA YA VALIDADA</h1></strong></p>
								
								</div>
		<?php 
	}
	public function popUpEstacionamientoProveedor()
	{
		?>
			<div data-role="header" data-theme="b">
				<h1>Asignar Estacionamiento a Proveedor</h1>
			</div>
			<div data-role="content">
				<form  id="validacion-operador-popup">
					
					<div data-role="fieldcontain" style= 'display:none;'>
						<label for="eidUserProvee" ><strong class="red">*</strong> idUsuario:</label>
						<input type="text" name="eidUserProvee" id="eidUserProvee" value=""  />
					</div>
					
					<div data-role="fieldcontain">
						<label for="eNomProvee" >Proveedor: </label>
						<label for="eNomProvee" class = "eNomProvee" ></label>
						
					</div>
				
					<div data-role="fieldcontain">
						<label>Compruebe o ingrese la patente del proveedor.<br></label>
						<label for="patenteProveedor" ><strong class="red">*</strong> Patente:</label>
						<input type="text" name="patenteProveedor" id="patenteProveedor" value=""  />
					</div>
					<div data-role="fieldcontain">
    					<fieldset data-role="controlgroup" >
    						<legend>Estacionamientos:</legend>
    						<?php 
						$cantEstacion=controlEstacionamiento::countEstacionamientosProveedor();
						$estacion = controlEstacionamiento::getEstacionamientosProveedor();
						if($cantEstacion>0)
						{
							$i=0;
							foreach ($estacion as $result)
							{
								?>
         						<input type="radio" name="radioEst" id="est<?php echo $i;?>" value="<?php echo $result->getnumero();?>" />
         						<label for="est<?php echo $i;?>" id="lab<?php echo $i;?>"><?php echo $result->getnumero();?></label>
         						
         						<?php
         						$i++; 
							}	
						}
						?>

         						
    					</fieldset>
					</div>
					
					<div data-role="fieldcontain" style= 'display:none;'>
						<label for="eidUserProvee" ><strong class="red">*</strong> Cantidad Estacionamientos:</label>
						<input type="text" name="cantEst" id="cantEst" value="<?php echo $cantEstacion;?>"  />
					</div>
					<div data-role="fieldcontain" style= 'display:none;'>
						<label for="opEstProv" ><strong class="red">*</strong> Operador:</label>
						<input type="text" name="opEstProv" id="opEstProv" value=""  />
					</div>						
												
					<a href='#' data-role='button' id="envia-validacion-proveedor" data-role="button"
							data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'  >Validar</a>
					<a href='#validar-visitas-global' data-role="button"  data-theme="c" rel="close" 
							data-inline="true" data-icon='arrow-l'>Volver</a>
				</form>
			</div>
					 
						
						
						
						
	<?php 
	}
		
	public function popUpRutInvalido()
	{
	?>
		<div data-role="content" data-theme="c">
			<p class="centrado"><strong id="popupRutInvalido"></strong></p>
			<p class="centrado"><strong><h1 class="centrado">EL RUT INGRESADO NO ES VALIDO</h1></strong></p>
		</div>
	<?php 
	}
	
	public function popUpIngresoTarjeta()
	{
		?>
				<div data-role="header" data-theme="b">
					<h1>Ingrese el numero de tarjeta</h1>
				</div>
				<div data-role="content">
					<form  id="validacion-tarjeta-popup">
						
						<div data-role="fieldcontain" style= 'display:none;'>
							<label for="idReservaTarjeta" ><strong class="red">*</strong> idReserva:</label>
							<input type="text" name="idReservaTarjeta" id="idReservaTarjeta" value=""  />
						</div>
						<div data-role="fieldcontain" style= 'display:none;'>
							<label for="idOperadorTarjeta" ><strong class="red">*</strong> idOperador:</label>
							<input type="text" name="idOperadorTarjeta" id="idOperadorTarjeta" value=""  />
						</div>
						
						<div data-role="fieldcontain">
							<label for="numTarjeta" >Numero de tarjeta: </label>
							<input type="text" name="numTarjeta" id="numTarjeta" value=""  />
						</div>
						<a href='#' data-role='button' id="envia-ingreso-tarjeta" data-role="button"
								data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'>Validar</a>
						<a href='#validar-visitas-global' data-role="button"  data-theme="c" rel="close" 
								data-inline="true" data-icon='arrow-l'>Volver</a>
					</form>
				</div>
		<?php 
	}

	public function enviaMensajeVisitaEspera()
		{
			$cliente= controlCliente::getCliente();
		
			?>
				
						<form id="redacta-mensaje-a-empresa">
							
							<div data-role="fieldcontain">
								<label for="nomVisitaEspera" ><strong class="red">*</strong> Nombre: </label>
								<input type="text" name="nomVisitaEspera" id="nomVisitaEspera" value=""  />
							</div>
							<div data-role="fieldcontain" >
								<label for="apeVisitaEspera" ><strong class="red">*</strong> Apellido:</label>
								<input type="text" name="apeVisitaEspera" id="apeVisitaEspera" value=""  />
							</div>
							<div data-role="fieldcontain">
								<label for="rutVisitaEspera" ><strong class="red">*</strong> RUT: </label>
								<input type="text" name="rutVisitaEspera" id="rutVisitaEspera" value=""  />
							</div>
							<div data-role="fieldcontain">
								<label for="empVisitaEspera"><strong class="red">*</strong> Empresa:</label>
								<select name='empVisitaEspera' id='empVisitaEspera'  tabindex='-1'>
									<option value='nadie'>Seleccione un Cliente</option>
							<?php 
								foreach($cliente as $result)
								{
									?>
										<option value='<?php echo $result->getidCliente()?>'><?php echo $result->getnombreEmpresa(); ?></option>
									<?php 
								}
							?>
								</select>
							</div>
							
							<a href='#' data-role='button' id="envia-mensaje-visita-espera" data-role="button" onclick='enviaMensaje()'
									data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'>Enviar</a>
							<a href='#validar-visitas-global' data-role="button"  data-theme="c" rel="close" 
									data-inline="true" data-icon='arrow-l'>Volver</a>
						</form>
					
				
				<script>
					function enviaMensaje()
					{
						//alert($('#empVisitaEspera').val());
						if($('#nomVisitaEspera').val()!=''&&$('#apeVisitaEspera').val()!=''&&$('#rutVisitaEspera').val()!=''&&$('#empVisitaEspera').val()!='nadie')
						{
							$.ajaxSetup({async: false});
							var rutEspera=$('#rutVisitaEspera').val();
							//alert($.inArray('-',rutEspera));
							if($.inArray('-',rutEspera)>-1)
							{ 
								rutEspera=rutEspera.split('-');
								$.get("verificaRut.php",{'rut':rutEspera[0],'dv':rutEspera[1]},function(datos){
									if (datos==1) rutValido=true;
									else rutValido=false; 
								});
		
								if (rutValido)
								{
									$.post('enviaMensajeVisitaEspera.php',$('#redacta-mensaje-a-empresa').serialize(),function (data){
										
										switch (data)
										{
											case "1": $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Exito',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>Mensaje enviado.</strong></p>"+
								    			  "<p class='centrado'>Espere mientras el cliente reserva a la visita.</p>"+
								    			  "<a data-role='button' href='#' data-transition='pop' rel='close' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-icon='check'>Aceptar</a>"
								    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
								    		  break;
		
											case "0": $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Error',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>Visita no se pudo insertar.</strong></p>"+
								    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
								    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
								    		  break;
		
								    		  default:
								    		  	$('<div>').simpledialog2({
									    		    mode: 'blank',
									    		    headerText: 'Error',
									    		    headerClose: true,
									    		    blankContent : 
									    			  "<p class='centrado'><strong>Error en DB.</strong></p>"+
									    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
									    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
									    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
									    		      
									    		  });
		
								    		  
										}
									});
								}
								else
								{
									$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'RUT Invalido',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>El RUT no es valido.</strong></p>"+
						    			  "<p class='centrado'>Verifiquelo e ingreselo nuevamente.</p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
								}
							}
							else
							{
								$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Error',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>El RUT debe estar escrito sin puntos y con guion (XXXXXXXX-X)</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
							}
						}
						else
						{
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Debe completar todos los cuadros y seleccionar un cliente</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  });
						}
						
					}
				</script>
				<?php 
			}
			
	public function guardaVisitaDB()
	{
		$cliente= controlCliente::getCliente();
		$user=$_SESSION["usuario_gk"];
		$operator=controlOperador::getIdOperador($user->getIdUsuario());
		$pisos=controlEdificio::listPisosOcupados();
			
?>
		
				<form id="form-guarda-visita">
					<div data-role="fieldcontain" style="display:none;">
						<label for="idOperador" ><strong class="red">*</strong> idOperador: </label>
						<input type="text" name="idOperador" id="idOperador" value="<?php echo $operator;?>"  />
					</div>
					<div data-role="fieldcontain">
						<label for="nomVisitaEspera" ><strong class="red">*</strong> Nombre: </label>
						<input type="text" name="nomVisitaGuardar" id="nomVisitaGuardar" value=""  />
					</div>
					<div data-role="fieldcontain" >
						<label for="apeVisitaEspera" ><strong class="red">*</strong> Apellido:</label>
						<input type="text" name="apeVisitaGuardar" id="apeVisitaGuardar" value=""  />
					</div>
					<div data-role="fieldcontain">
						<label for="rutVisitaEspera" ><strong class="red">*</strong> RUT: </label>
						<input type="text" name="rutVisitaGuardar" id="rutVisitaGuardar" value=""  />
					</div>
					
					<div data-role="fieldcontain" id="botonesVisitaGuardar" >
						<fieldset data-role="controlgroup" data-type="horizontal" > 
							<select name='pisoVisitaGuardar1' id='pisoVisitaGuardar1'  tabindex='-1' onchange="abrePiso(this)">
								<option value='nadie'>Piso</option>
								<?php 
									$pisosSep="";
									foreach ($pisos as $result)
									{
										?>
										<option value='<?php echo $result['piso'];?>'>Piso <?php echo $result['piso']; ?></option>
										<?php 
										$pisosSep.=$result['piso'].'**';
									}
								?>
							</select>
							<select name='empVisitaGuardar1' id='empVisitaGuardar1'  tabindex='-1'>
								<option value='nadie'>Cliente</option>
								
								
							</select>
						</fieldset>
					</div>
					<hr>
					<div data-role="fieldcontain">
						<a href='#' data-role='button' data-role="button" onclick='aumentaVisita()'
							data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'>Añadir otro.</a>
					</div>
					<div data-role="fieldcontain" style="display:none;">
						<label for="cantVisitaEspera"  ><strong class="red">*</strong> Cantidad de pisos: </label>
						<input type="text" name="cantVisitaGuardar" id="cantVisitaGuardar" value="1"  />
					</div>
					
					<a href='#' data-role='button' id="envia-mensaje-visita-espera" data-role="button" onclick='guardaVisita()'
							data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'>Enviar</a>
					<a href='#validar-visitas-global' data-role="button"  data-theme="c" rel="close" 
							data-inline="true" data-icon='arrow-l'>Volver</a>
				</form>
			
		
		<script>
		var cantVisitas=1;
			function aumentaVisita()
			{
				cantVisitas++;
				sepPisos='<?php echo $pisosSep;?>';
				sepPisos=sepPisos.split('**');
				$("#botonesVisitaGuardar").append('<hr>');
				var agregar="";
				agregar +='<fieldset data-role="controlgroup" data-type="horizontal" id="field'+cantVisitas+'">';
				agregar +="<select name='pisoVisitaGuardar"+cantVisitas+"' id='pisoVisitaGuardar"+cantVisitas+"' tabindex='-1' onchange='abrePiso(this)'>";
				agregar +="<option value='nadie'>Piso</option>";
							
				for(i=0;i<sepPisos.length-1;i++)
				{
					agregar+= '<option value='+sepPisos[i]+'>Piso '+sepPisos[i]+'</option>';
				}
				agregar+= '</select>';	
				agregar+= '<select name="empVisitaGuardar'+cantVisitas+'" id="empVisitaGuardar'+cantVisitas+'" tabindex="-1" class="comboVis">';
				agregar+= '<option value="nadie">Cliente</option>';
				agregar+= '</select>';
				agregar+= '</fieldset>';
				
				//$("#pisoVisitaGuardar"+cantVisitas).selectmenu("refresh");
				$("#botonesVisitaGuardar").append(agregar); 
				$("#botonesVisitaGuardar").trigger( "create" );
				//refresca();
				$("#cantVisitaGuardar").val(cantVisitas);
				
			}
			function refresca()
			{
				
				$('#pisoVisitaGuardar'+cantVisitas).selectmenu('refresh');
				$('#empVisitaGuardar'+cantVisitas).selectmenu('refresh');
				$('#field'+cantVisitas).addClass("ui-corner-all ui-controlgroup ui-controlgroup-horizontal");
				$('#botonesVistaGuardar').trigger( "refresh" );
			}
			function abrePiso(piso)
			{
				id=piso.id;
				id=id.split("pisoVisitaGuardar");
				piso=piso.value;
				if(piso!=null)
				{
					$.get("getClientePorPiso.php",{'piso':piso},function(datos){
						datos=datos.split("*");
						//alert(datos.length);
						
						$("#empVisitaGuardar"+id[1]).empty();
						$("#empVisitaGuardar"+id[1]).append("<option value='nadie'>Cliente</option>");
						$("#empVisitaGuardar"+id[1]).val('nadie');
						$('#empVisitaGuardar'+id[1]).trigger('change');
						for(i=0;i<datos.length-1;i++)
						{
							empresa=datos[i].split("&&");
							$("#empVisitaGuardar"+id[1]).append("<option value='"+empresa[0]+"'>"+empresa[1]+" - Of: "+empresa[2]+"</option>");
							//alert(datos[i]);
						}
					});
				}
			}
			function guardaVisita()
			{
				//alert($('#empVisitaEspera').val());
				if($('#nomVisitaGuardar').val()!=''&&$('#apeVisitaGuardar').val()!=''&&$('#rutVisitaGuardar').val()!=''&&$('#empVisitaGuardar1').val()!='nadie'&&$('#pisoVisitaGuardar1').val()!='nadie')
				{
					$.ajaxSetup({async: false});
					var rutEspera=$('#rutVisitaGuardar').val();
					//alert($.inArray('-',rutEspera));
					if($.inArray('-',rutEspera)>-1)
					{ 
						rutEspera=rutEspera.split('-');
						$.get("verificaRut.php",{'rut':rutEspera[0],'dv':rutEspera[1]},function(datos){
							if (datos==1) rutValido=true;
							else rutValido=false; 
						});

						if (rutValido)
						{
							$.post('guardaVisitaEmpresa.php',$('#form-guarda-visita').serialize(),function (data){
								
								switch (data)
								{
									case "1": $('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Exito',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Visita almacenada.</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
						    		  break;

									case "0": $('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Error',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Visita no se pudo insertar.</strong></p>"+
						    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
						    		  break;

						    		  default:
						    		  	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Error',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en DB.</strong></p>"+
							    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  });

						    		  
								}
							});
						}
						else
						{
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'RUT Invalido',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>El RUT no es valido.</strong></p>"+
				    			  "<p class='centrado'>Verifiquelo e ingreselo nuevamente.</p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  });
						}
					}
					else
					{
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>El RUT debe estar escrito sin puntos y con guion (XXXXXXXX-X)</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  });
					}
				}
				else
				{
					$('<div>').simpledialog2({
		    		    mode: 'blank',
		    		    headerText: 'Error',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>Debe completar todos los cuadros, seleccionar un cliente y un piso</strong></p>"+
		    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
		    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
		    		      
		    		  });
				}
				
			}
		</script>
		<?php 
	}
	public function vistasValidacion()
	{
		?>
		<div data-role="page" id="modificar-visitas">
			<div data-role="content" id="content-modificar-visitas"></div>
		</div>
		<div data-role="page" id="verificar-visitas">
			<div data-role="content" id="content-verificar-visitas"></div>
		</div>
		<div data-role="page" id="validar-visitas-global">
			<div data-role="content" id="content-validar-visitas-global"></div>
		</div>
		<div data-role="dialog" id="envia-mensaje-espera">
			<div data-role="header" data-theme="b">
				<h1>Envia Mensaje de Visita en Espera</h1>
			</div>
			<div data-role="content" id="content-envia-mensaje-espera"></div>
		</div>
		<div data-role="dialog" id="guarda-visita-cliente">
			<div data-role="header" data-theme="b">
				<h1>Indique a que empresa va la visita</h1>
			</div>
			<div data-role="content" id="content-guarda-visita-cliente"></div>
		</div>
					
				
		<?php 
	}

	
	
}

?>
