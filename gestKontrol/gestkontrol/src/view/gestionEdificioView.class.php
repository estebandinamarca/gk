<?php
require_once 'src/classes/controlEdificio.class.php';
require_once 'src/classes/controlCliente.class.php';

class gestionEdificioView
{
	public function getIngresoPisoOficina()
	{
		?>
		
		
			<h3>Inicio » Nuevo Piso - Oficinas</h3>
			<hr>
			
			
			<form action="post" id="ingreso-piso-oficinas">
			
				<div data-role="fieldcontain">
					<label for="file"> Utilice un archivo preconfigurado para facilitar el ingreso:</label>
					<!--  input type="button" name="" id="name" value="Examinar"  data-mini="true" data-inline="true"/>
					<input type="text" name="archivoIngresoPiso" id="name" value=""--> 
					<script type="text/javascript">
					// Popup window code
					function newPopup(url) {
						window.open(
							url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
					}
					</script>
					<a href="#" onclick="newPopup('uploaderOficina.php');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir archivo</a>
					
				</div>
				<hr>
				<div data-role="fieldcontain">
					<label> O agregue manualmente los pisos y oficinas: </label>
					<br>
					<label for="comboPiso" data-inline="true" >Cantidad de pisos </label>
					<select  id='comboPiso'  tabindex='-1' onchange="poblaPisosOficinas(this.value);" data-inline="true">
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='5'>5</option>
						<option value='10'>10</option>
					</select>
				</div>
				<label>Ingrese las oficinas separadas con una coma (cuando ingrese mas de una oficina)</label>
				<div id="cantidadPisosOficinas" data-role='fieldcontain' data-inline="true"></div>
		
				<script>
				$(document).ready(function(){
					poblaPisosOficinas("1");
					});
					function poblaPisosOficinas(pisos)
					{
						//alert(pisos);
						$("#cantidadPisosOficinas").empty();
						for (i=1;i<=pisos;i++)
							{
								$("#cantidadPisosOficinas").append("<label for='name'>Piso:</label>");
								$("#cantidadPisosOficinas").append("<input type='text' name='pisoConComa"+i+"' id='name' value='' class='botonCi' />");
								$("#cantidadPisosOficinas").append("<label for='name'>Oficina(s):</label>");
								$("#cantidadPisosOficinas").append("<input type='text' name='ofConComa"+i+"' id='name' value='' class='botonCi' />");
								$("#cantidadPisosOficinas").append("<br>");
								$("#cantidadPisosOficinas").append("<hr>");
								
							}
						$('.botonCi').textinput();
					}
				</script>
		
				
		
				<fieldset class="ui-grid-a">
					<a href="" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-piso-oficina" onclick="ingresaNuevoPisoOficina()">Guardar</a>
					<a href="#inicio" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
					<!--  input type="submit" name="subir" id="subir" value="Cargar Archivo"/-->
				</fieldset>
			</form>
		
	<script>
		function ingresaNuevoPisoOficina()
		{
			//alert($("#ingreso-piso-oficinas").serialize());
			$.post('uploaderEdificio.php',$('#ingreso-piso-oficinas').serialize(),function(data)
				{
					
					switch (data)
					{
					case "1": 
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Informacion',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Ingreso exitoso</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
			    			//  NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "-1":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Error en DB</strong></p>"+
			    			  "<p class='centrado'><strong>Contactese con el administrador para solucionar el problema</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "-2":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Fallo en la integridad de los datos</strong></p>"+
			    			  "<p class='centrado'><strong>Asegúrese que los datos sean solo numericos y que los campos no esten vacios.</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					
					default:
						
						$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
				    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
				    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
				    		      
				    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
					}
				
				});
		}
	</script>
	<?php 
			
	}
	
	public function editPisosOficinas()
	{
		?>
		
				<h3>Inicio » Edicion Piso - Oficinas</h3>
				<div id="editarPisosOficinas">
					<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme="d">
						<?php
						$pisosOficina=controlEdificio::listPisosOficinas();
						$piso="";
						if(count($pisosOficina)>0)
						{
							foreach ($pisosOficina as $result)
							{
								if($result['idCliente']==null)$cliente="Sin Cliente Asignado";
								else $cliente=controlCliente::nombreCliente($result['idCliente']);
								if($piso!=$result['piso'])
								{
								?>
									<li data-role="list-divider">Piso <?php echo $result['piso'];?>
										
									</li>
								<?php 
								}
								$piso=$result['piso'];
								?>
									<li data-icon="gear">
										<br>
										<p>Oficina: <?php echo $result["oficina"];?> </p>
										<p>Cliente: <?php echo $cliente;?> </p>
										
										<hr>
										<div data-role='controlgroup' data-type='horizontal' data-mini='true' data-inline='true'>
											<a href='#edicion-oficina' data-role='button' data-icon='grid' 
												onclick="enviaEdicionOficina('<?php echo $result["idDetalleCliente"];?>','<?php echo $result["oficina"]; ?>','<?php echo $cliente;?>');"
												data-rel='dialog'>Editar</a>
										 	<!--  a href='#'data-role='button' data-icon='delete' 
										 	onclick = "deleteTarjeta('<?php //echo $result["idtarjeta"];?>','<?php //echo $result["numeroTarjeta"]; ?>');">Eliminar</a-->
										 	
										</div>
									</li>
								<?php
							}	
						}
						?>
					</ul>	 
				</div>
			
		<script>
			function enviaEdicionOficina(idOf,ofi,cli)
			{
				botonVistaEdificio("#edicion-oficina");
				$("#eidOf").val(idOf);
	            $("#eOfi").val(ofi);
	            $("#eCli").val(cli);
	            
	            
			}
			function botonVistaEdificio(atributo)
			{
				 
				 //var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				 //alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
				 $.ajaxSetup({async: false});	
				 $('#'+atributo1).load('cargadorVistasEdificio.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
				 
			 }
		</script>
	<?php 
	}
	public function edicionOficina()
	{
		?>
			
					<form action="post" id="edicion-oficina-popup">
						<div data-role="fieldcontain" style="display:none;">
							<label for="name" ><strong class="red">*</strong> idOficina:</label>
							<input type="text" name="eidOf" id="eidOf" value=""/>
						</div>
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Oficina:</label>
							<input type="text" name="eOfi" id="eOfi" value=""  />
						</div>
							
						<div data-role="fieldcontain">
							<label><strong>Importante:</strong><br></label>
							<label>Para asignar o cambiar al cliente de una oficina, dirijase al modulo "Edicion Cliente"</label>
							<br><br>
							<label for="name"><strong class="red">*</strong> Cliente:</label>
							<input type="text" name="eCli" id="eCli" value="" disabled="disabled" />
						</div>
						
						<a href='#' data-role='button' data-role='button' data-role="button"
							data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog' onclick="editaOficina();">Editar</a>
						<a href='#edit-piso' data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l' >Volver</a>
					</form>
				
			<script>
			function editaOficina()
			{
				//alert($("#edicion-oficina-popup").serialize());
				$.get("editaEdificio.php", $("#edicion-oficina-popup").serialize(),function(datos){
					switch (datos)
					{
					case "1": 
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Informacion',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Edicion Exitosa</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
			    			//  NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "0":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>No se edito nada</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "-1":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>No estan todos los datos</strong></p>"+
			    			  "<p class='centrado'><strong>Asegurese que ingresó todos los datos requeridos</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					
					default:
						
						$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
				    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
				    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
				    		      
				    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
					}
					});
			}			
			</script>
		
	<?php 
	}
				
	public function getIngresoPisoEstacionamiento()
	{
		?>
			
			
				<h3>Inicio » Nuevo Estacionamiento</h3>
				<hr>
				
				
				<form action="post" id="ingreso-estacionamiento">
				
					<div data-role="fieldcontain">
						<label for="file"> Utilice un archivo preconfigurado para facilitar el ingreso:</label>
						<!--  input type="button" name="" id="name" value="Examinar"  data-mini="true" data-inline="true"/>
						<input type="text" name="archivoIngresoPiso" id="name" value=""  /--> 
					<script type="text/javascript">
					// Popup window code
					function newPopup(url) {
						window.open(
							url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
					}
					</script>
					<a href="#" onclick="newPopup('uploaderEstacion.php');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir archivo</a>
						
					</div>
					<hr>
					<div data-role="fieldcontain">
						<label> O agregue manualmente los estacionamientos: </label>
						<br>
						<label for="comboPiso" data-inline="true" >Cantidad de pisos o subterraneos </label>
						<select  id='comboPiso'  tabindex='-1' onchange="poblaEstacionamientos(this.value);" data-inline="true">
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='5'>5</option>
							<option value='10'>10</option>
						</select>
					</div>
					<label>Ingrese los estacionamientos separados con una coma (cuando ingrese mas de un estacionamiento)</label>
					<div id="cantidadEstacionamientos" data-role='fieldcontain' data-inline="true" data-type='horizontal'></div>
			
					<script>
					$(document).ready(function(){
						poblaEstacionamientos("1");
						});
						function poblaEstacionamientos(pisos)
						{
							//alert(pisos);
							$("#cantidadEstacionamientos").empty();
							for (i=1;i<=pisos;i++)
							{
								$("#cantidadEstacionamientos").append("<label for='name'>Piso o Subterraneo:</label>");
								$("#cantidadEstacionamientos").append("<input type='text' name='pisoConComa"+i+"' id='name' value='' class='botonCi' />");
								$("#cantidadEstacionamientos").append("<label for='name'>Estacionamiento(s):</label>");
								$("#cantidadEstacionamientos").append("<input type='text' name='estConComa"+i+"' id='name' value='' class='botonCi' />");
								$("#cantidadEstacionamientos").append("<label for='esProv"+i+"'>Proveedor</label>");
								$("#cantidadEstacionamientos").append("<input type='checkbox' name='esProv"+i+"' id='esProv"+i+"' class='comboCi' data-type='horizontal'/>");
								$("#cantidadEstacionamientos").append("<br>");
								$("#cantidadEstacionamientos").append("<hr>");
							}
							$('.comboCi').checkboxradio();
							$('.botonCi').textinput();
							
						}
					</script>
			
					
			
					<fieldset class="ui-grid-a">
						<a href="" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-estacionamiento" onclick="ingresaNuevoEstacionamiento()">Guardar</a>
						<a href="#inicio" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
						<!--  input type="submit" name="subir" id="subir" value="Cargar Archivo"/-->
					</fieldset>
				</form>
			
		<script>
			function ingresaNuevoEstacionamiento()
			{
				//alert($("#ingreso-estacionamiento").serialize());
				$.post('uploaderEdificio.php',$('#ingreso-estacionamiento').serialize(),function(data)
					{
						
						switch (data)
						{
						case "1": 
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Informacion',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Ingreso exitoso</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
				    			//  NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						case "-1":
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Error en DB</strong></p>"+
				    			  "<p class='centrado'><strong>Contactese con el administrador para solucionar el problema</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			  //NOTE: the use of rel="close" causes tTarjetahis button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						case "-2":
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Fallo en la integridad de los datos</strong></p>"+
				    			  "<p class='centrado'><strong>Asegúrese que los datos sean solo numericos y que los campos no esten vacios.</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			  //NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						
						default:
							
							$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Error',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
					    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
					    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
						}
					
					});
			}
		</script>
		<?php 
				
		}
		
	public function editEstacionamientos()
	{
	?>
		
				<h3>Inicio » Edicion Estacionamientos</h3>
				<div id="editarEstacionamiento">
					<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme="d">
						<?php
						$estacionamientos=controlEdificio::listEstacionamientos();
						$piso="";
						if(count($estacionamientos)>0)
						{
							foreach ($estacionamientos as $result)
							{
								if($result['idCliente']==null)$cliente="Sin Cliente Asignado";
								else $cliente=controlCliente::nombreCliente($result['idCliente']);
								if($piso!=$result['subterraneo'])
								{
								?>
									<li data-role="list-divider">Piso <?php echo $result['subterraneo'];?>
										
									</li>
								<?php 
								}
								if ($result['proveedor']=="1") $prove= "Proveedor";
								else $prove= "Visitas";
								$piso=$result['subterraneo'];
								?>
									<li data-icon="gear">
										<br>
										<p>Numero Estacionamiento: <?php echo $result["numero"];?> </p>
										<p>Cliente: <?php echo $cliente;?> </p>
										<p>Tipo de estacionemiento: <?php echo $prove;?></p>
										
										<hr>
										<div data-role='controlgroup' data-type='horizontal' data-mini='true' data-inline='true'>
											<a href='#edicion-estacionamiento' data-role='button' data-icon='grid' 
												onclick="enviaEdicionEstacionamiento('<?php echo $result["idEstacionamiento"];?>','<?php echo $result["numero"]; ?>','<?php echo $cliente;?>','<?php echo $prove;?>');"
												data-rel='dialog'>Editar</a>
											<?php if ($result['estado']=='1'){?>
											<a href='#'data-role='button' data-icon='check' 
									 		onclick = "liberaEstacionamiento('<?php echo $result["numero"];?>')">Liberar</a>
											<?php }?>
										 	<!--  a href='#'data-role='button' data-icon='delete' 
										 	onclick = "deleteTarjeta('<?php //echo $result["idtarjeta"];?>','<?php //echo $result["numeroTarjeta"]; ?>');">Eliminar</a-->
										 	
										</div>
									</li>
								<?php
							}	
						}
						?>
					</ul>	 
				</div>
			
		<script>
			function enviaEdicionEstacionamiento(idEst,num,cli,prove)
			{
				botonVistaEdificio("#edicion-estacionamiento");
				$("#eidEst").val(idEst);
	            $("#eNumEst").val(num);
	            $("#eCliEst").val(cli);
	            if(prove == "Proveedor")
	            { 
	            	$('#estProveSi').attr('checked', 'checked');
	            	$('#estProveSi').checkboxradio("refresh");
	            }
		        else
			    { 
				    $('#estProveNo').attr('checked', 'checked');
				    $('#estProveNo').checkboxradio("refresh");				
				}
	         }
	         function botonVistaEdificio(atributo)
			{
				 
				 //var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				 //alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
				 $.ajaxSetup({async: false});	
				 $('#'+atributo1).load('cargadorVistasEdificio.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
				 
			}
			function liberaEstacionamiento(idEst)
			{
				$.get("editaEdificio.php", {'libEst':idEst},function(datos){
					switch (datos)
					{
					case "1": 
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Informacion',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Liberacion Exitosa</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
			    			//  NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "0":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>No se libero nada</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					case "-1":
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Error',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>No se enviaron todos los datos</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
			    			  //NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
			      		
				      	    break;
					
					default:
						
						$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
				    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
				    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
				    		      
				    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
					}
					});
			}
		</script>
	<?php 
	}
	public function edicionEstacionamiento()
	{
		?>
				
						<form action="post" id="edicion-estacionamiento-popup">
							<div data-role="fieldcontain" style="display:none;">
								<label for="name" ><strong class="red">*</strong> idEstacionamiento:</label>
								<input type="text" name="eidEst" id="eidEst" value=""/>
							</div>
							<div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Numero de Estacionamiento:</label>
								<input type="text" name="eNumEst" id="eNumEst" value=""  />
							</div>
								
							<div data-role="fieldcontain">
								<label><strong>Importante:</strong><br></label>
								<label>Para asignar o cambiar al cliente de un estacionamiento, dirijase al modulo "Edicion Cliente"</label>
								<br><br>
								<label for="name"><strong class="red">*</strong> Cliente:</label>
								<input type="text" name="eCli" id="eCliEst" value="" disabled="disabled" />
							</div>
							<div data-role="fieldcontain" data-type='horizontal'>
								<label>Para Proveedores? (elija una opcion si quiere cambiar el estado)</label>
								<label for='estProveSi'>Si</label>
								<input type='radio' name='estProve' id='estProveSi' data-type='horizontal' value="1"/>
								<label for='estProveNo'>No</label>
								<input type='radio' name='estProve' id='estProveNo' data-type='horizontal' value="0"/>
							</div>
							
							
							
							<a href='#' data-role='button' data-role='button' data-role="button"
								data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog' onclick="editaEstacionamiento();">Editar</a>
							<a href='#edit-estacionamiento' data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l' >Volver</a>
						</form>
					
				<script>
				function editaEstacionamiento()
				{
					//alert($("#edicion-estacionamiento-popup").serialize());
					$.get("editaEdificio.php", $("#edicion-estacionamiento-popup").serialize(),function(datos){
						switch (datos)
						{
						case "1": 
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Informacion',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Edicion Exitosa</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
				    			//  NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						case "0":
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>No se edito nada</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			  //NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						case "-1":
							$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>No estan todos los datos</strong></p>"+
				    			  "<p class='centrado'><strong>Asegurese que ingresó todos los datos requeridos</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			  //NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      		
					      	    break;
						
						default:
							
							$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Error',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
					    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
					    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
						}
						});
				}			
				</script>
			
		<?php 
		}
		
		public function vistasEdificio()
		{
			?>
				<div data-role="page" id="nuevo-piso">
					<div data-role="content" id="content-nuevo-piso"></div>
				</div>
				<div data-role="page" id="edit-piso">
					<div data-role="content" id="content-edit-piso"></div>
				</div>
				<div data-role="dialog" id="edicion-oficina">
					<div data-role="header" data-theme="b">
						<h1>Editar Oficina</h1>
					</div>
				
					<div data-role="content" id="content-edicion-oficina"></div>
				</div>
				<div data-role="page" id="nuevo-estacionamiento">
					<div data-role="content" id="content-nuevo-estacionamiento"></div>
				</div>
				<div data-role="page" id="edit-estacionamiento">
					<div data-role="content" id="content-edit-estacionamiento"></div>
				</div>
				<div data-role="dialog" id="edicion-estacionamiento">
					<div data-role="header" data-theme="b">
						<h1>Editar Estacionamiento</h1>
					</div>
					<div data-role="content" id="content-edicion-estacionamiento"></div>
				</div>
			<?php 
		}

		
}


?>