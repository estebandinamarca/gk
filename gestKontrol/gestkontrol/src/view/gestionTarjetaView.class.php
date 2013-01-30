<?php
require_once ('src/classes/controlTarjeta.class.php');

class gestionTarjetaView
{
	public function ingresaTarjeta()
	{
		?>
			
					<h3>Inicio » Nueva Tarjeta</h3>
					<hr>
					<!-- Datos personales Visita -->
					<form action="post" id="ingreso-nueva-tarjeta">
												
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Numero de la tarjeta:</label>
							<input type="text" name="numTarjeta" id="name" value=""  />
						</div>
																			
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Codigo de barras:</label>
							<input type="text" name="codBarra" id="name" value=""  />
						</div>
							
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Codigo RFID:</label>
							<input type="text" name="codRfid" id="name" value=""  />
						</div>
						<fieldset class="ui-grid-a">
							<a href="#" data-rel="dialog" data-role="button" data-theme="b" onclick="guardaTarjeta();" data-inline="true" id="guardar-tarjeta" >Guardar</a>
							<a href="#inicio" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
						</fieldset>
					</form>
				
			
			<script>
			function guardaTarjeta(){
				//alert($("#ingreso-nueva-tarjeta").serialize());
				$.get("validaIngresoTarjeta.php", $("#ingreso-nueva-tarjeta").serialize(),function(datos){
					switch (datos)
					{
					case "1": 
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Informacion',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Tarjeta ingresada existosamente</strong></p>"+
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
			    			  "<p class='centrado'><strong>Error en DB</strong></p>"+
			    			  "<p class='centrado'><strong>Contactese con el administrador para solucionar el problema</strong></p>"+
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
			    			  "<p class='centrado'><strong>Asegúrese que ingresó todos los datos requeridos</strong></p>"+
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
			    			  "<p class='centrado'><strong>La tarjeta ya esta ingresada en el sistema</strong></p>"+
			    			  "<p class='centrado'><strong>Compruebe que el numero de la tarjeta este correctamente, si esto no es asi, contactese con el administrador</strong></p>"+
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
	
	public function editaTarjeta()
	{
		
		?>
		
				<h3>Inicio » Editar Tarjeta </h3>
				
				<div id="editarTarjetas"> 
					<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme="d">
					<?php 
					$tarjetas=controlTarjeta::listTarjeta();
						if(count($tarjetas)>0)
						{
							foreach ($tarjetas as $result)
							{
								if ($result["estado"]=='0') $estado="Libre";
								else $estado="Ocupado";
								?>
								<li data-icon="gear">
									<h3 class="ui-li-heading">Numero de Tarjeta:<?php echo $result["numeroTarjeta"];?></h3>
									<br>
									<p>Codigo de barras: <?php echo $result["codigBarraTarjeta"];?> </p>
									<p>Codigo RFID: <?php echo $result["codigoRfid"];?> </p>
									<hr>
									<p>Estado: <?php echo $estado;?> </p>
									<div data-role='controlgroup' data-type='horizontal' data-mini='true' data-inline='true'>
										<a href='#edicion-tarjeta' data-role='button' data-icon='grid' 
											onclick="enviaEdicionTarjeta('<?php echo $result["idtarjeta"];?>','<?php echo $result["numeroTarjeta"]; ?>','<?php echo $result["codigBarraTarjeta"];?>','<?php echo $result["codigoRfid"];?>');"
											data-rel='dialog'>Editar</a>
									 	<a href='#'data-role='button' data-icon='delete' 
									 	onclick = "deleteTarjeta('<?php echo $result["idtarjeta"];?>','<?php echo $result["numeroTarjeta"]; ?>');">Eliminar</a>
									 	<?php if ($result["estado"]!="0")
									 	{
									 	?>
									 	<a href='#'data-role='button' data-icon='check' 
									 	onclick = "liberaTarjeta('<?php echo $result["idtarjeta"];?>')">Liberar</a>
									 	<?php }?>
									</div>
								</li>
							<?php 
								
							}
							?>
							<li class="no-results" style= "display:none;">No se encontraron resultados.</li>
							
						<?php 
						}
						else
						{?> 
							<li class="no-results">No se encontraron resultados.</li>
						<?php
						}
					?>
					</ul>
										
				</div>
			
		<script>
		function liberaTarjeta(idTar)
		{
			$.get("editaTarjeta.php", {'libIdTar':idTar},function(datos){
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
		function enviaEdicionTarjeta(idTar,numTar,codBar,codRfid)
		{
			botonVistaTarjeta('#edicion-tarjeta');
			$("#eidTarjeta").val(idTar);
            $("#enumTarj").val(numTar);
            $("#ecodBar").val(codBar);
            $("#ecodRfid").val(codRfid);
            
		}

		function deleteTarjeta(idTar,numero)
		{
			$('<div>').simpledialog2({
    		    mode: 'blank',
    		    headerText: 'Confirmacion',
    		    headerClose: true,
    		    blankContent : 
    			  "<p class='centrado'><strong>Elimina tarjeta "+numero+"?</strong></p>"+
    			  "<a data-role='button' href='#' data-transition='pop' onClick='sendDeleteTarjeta("+idTar+");' rel='close' data-icon='check'>Aceptar</a>"+
    			  "<a data-role='button' href='#editar-tarjeta' data-transition='pop'  rel='close' data-icon='delete'>Cancelar</a>"
    			//  NOTE: the use of rel="close" causes this button to close the dialog.
    		      
    		  });
		}
		function botonVistaTarjeta(atributo)
		{
			 
			 //var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
			 $.ajaxSetup({async: false});
			 $('#'+atributo1).load('cargadorVistasTarjetas.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('create');
	 			});
			 
		 }

		function sendDeleteTarjeta(idTarjeta)
		{
			$.get("deleteTarjeta.php", {'idTarjeta':idTarjeta },function(datos){
				switch (datos)
				{
				case "1": 
					$('<div>').simpledialog2({
		    		    mode: 'blank',
		    		    headerText: 'Informacion',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>Eliminacion Exitosa</strong></p>"+
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
		    			  "<p class='centrado'><strong>No se elimino nada</strong></p>"+
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
		    			  "<p class='centrado'><strong>No se enviaron los datos</strong></p>"+
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
		
		public function edicionTarjeta()
		{
		?>
			
				
				
					<form action="post" id="edicion-tarjeta-popup">
						<div data-role="fieldcontain"style= 'display:none;'>
							<label for="name" ><strong class="red">*</strong> idTarjeta:</label>
							<input type="text" name="eidTarjeta" id="eidTarjeta" value=""/>
						</div>
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Numero de Tarjeta:</label>
							<input type="text" name="enumTarj" id="enumTarj" value=""  />
						</div>
							
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Codigo de barra:</label>
							<input type="text" name="ecodBar" id="ecodBar" value=""  />
						</div>
						
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Codigo RFID:</label>
							<input type="text" name="ecodRfid" id="ecodRfid" value=""  />
						</div>
							
						
						<a href='#' data-role='button' data-role='button' data-role="button"
							data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog' onclick="editaTarjeta();">Editar</a>
						<a href='#editar-tarjeta' data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l' >Volver</a>
					</form>
				
			<script>
			function editaTarjeta(){
				//alert($("#ingreso-nueva-tarjeta").serialize());
				$.get("editaTarjeta.php", $("#edicion-tarjeta-popup").serialize(),function(datos){
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

		public function vistasTarjeta()
		{
			?>
			<div data-role="page" id="ingresa-tarjeta">
				<div data-role="content" id="content-ingresa-tarjeta"></div>
			</div>
			
			<div data-role="page" id="editar-tarjeta">
				<div data-role="content" id="content-editar-tarjeta"></div>
			</div>
			
			<div data-role="dialog" id="edicion-tarjeta">
				<div data-role="header" data-theme="b">
					<h1>Editar Tarjeta</h1>
				</div>
				<div data-role="content" id="content-edicion-tarjeta"></div>
			</div>
			
			<?php 
		}
}
?>