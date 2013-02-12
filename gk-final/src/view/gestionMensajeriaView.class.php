<?php
require_once 'src/classes/controlMensajes.class.php';
require_once 'src/classes/controlUsuario.class.php';

class gestionMensajeriaView
{
	public function nuevoMensaje($idUser)
	{
		$usuarios=controlUsuario::listUsuarios();
		$userFrom=controlUsuario::getuserFullName($idUser);
		?>
		
				<h3 style="text-align:center">Inicio » Nuevo Mensaje</h3>
				<fieldset class="ui-grid-a">
					<a href="#" data-rel="dialog" data-role="button" data-theme="b"  data-inline="true" onclick="senderMensajes()" class="botonVistaMensaje">Enviar</a>
					
					<a href="#bandeja-entrada" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
				</fieldset>
				<form id="nuevoMensaje">
					<div data-role="fieldcontain" style="display: none">
						<label for="name"><strong class="red">*</strong>Id De :</label>
						<input type="text" name="msgIdFrom" id="name" value="<?php echo $idUser;?>" />
					</div>
					<div data-role="fieldcontain">
						<label for="name"><strong class="red">*</strong> De :</label>
						<input type="text" name="msgFrom" id="name" value="<?php echo $userFrom;?>"  disabled="disabled"/>
					</div>
					<div data-role="fieldcontain">
						<label for="msgTo"><strong class="red">*</strong> Para:</label>
						<select name='msgTo' id='msgTo'  tabindex='-1'>
							<option value='nadie'>Seleccione una persona</option>
					<?php 
						foreach($usuarios as $result)
						{
							?>
								<option value='<?php echo $result['idUser']?>'><?php echo $result['userFullName']." - ".$result['company']; ?></option>
							<?php 
						}
					?>
						</select>
					</div>
					<div data-role="fieldcontain">
						<label for="msgSubject">Asunto :</label>
						<input type="text" name="msgSubject" id="msgSubject" value=""  />
					</div>
					<div data-role="fieldcontain">
						
						<textarea name="msgContent" id="msgContent" style="width: 82.2%; height:200px;" placeholder="Escriba aqui el cuerpo del mensaje"></textarea>
					</div>
					
				</form>
				
			
		<script>
			function senderMensajes()
			{
				//alert($("#nuevoMensaje").serialize());
				$.post("senderMensaje.php", $("#nuevoMensaje").serialize(),function(datos){
					//alert(datos);
					switch(datos)
					      {
					      	case "1": 
						      		
					      		 $('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Información',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Mensaje enviado</strong></p>"+
						    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
					      		//	document.getElementById("ingreso").reset();
						      	break;


					      	case "0":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en envio del mensaje, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
							      	
					      
					      	case "-1":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en SQL, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
					      	
					      	case "-2":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>No se seleccionó el destinatario</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      				break;
					       default:
									
								$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
						    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
					    		 
						      	 	
					      
						  }
					
					});
			}
		</script>
		<script>
		$(".botonVistaMensaje").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
				});
				 
		 });

		</script>
		
				
		<?php 
	}
	
	public function bandejaEntrada($idUser)
	{
		?>
			
				<h3 style="text-align:center">Inicio » Bandeja de Entrada</h3>
				<fieldset class="ui-grid-a">
					<a href="#redactar-mensaje" data-role="button" data-theme="b"  data-inline="true" onclick="limpiarMsj()" class="botonVistaMensaje">Redactar</a>
					
					<a href="#mensajes-enviados" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Enviados</a>
					<a href="#mensajes-eliminados" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Eliminados</a>
				</fieldset>
				
				<script>
					function limpiarMsj()
					{
						$("#msgSubject").val("");
						$("#msgTo").val('nadie');
						$('#msgTo').selectmenu('refresh', true);
						$("#msgContent").val("");
						
					}
				</script>
		<?php 
		$mensajesRecibidos=controlMensajeria::getMensajes($idUser,"Recibidos");
		?>
				<table data-role="table" id="bandejaEntrada" class="ui-responsive">
					<thead>
						<tr>
						<th></th>
						<th>De</th>
						<th>Asunto</th>
						<th>Fecha</th>
						<th>Eliminar</th>
						
						</tr>
					</thead>
					<tbody>
		<?php 
		$i=1;
		if(count($mensajesRecibidos)>0)
		{
			foreach($mensajesRecibidos as $result)
			{
				if($result->getestado()!="Eliminado")
				{
					$userFrom=controlUsuario::getuserFullName($result->getfrom());
					$userTo=controlUsuario::getuserFullName($result->getto());
					$dataRecibidos=$result->getidMensaje()."$%&&%$".$userFrom."$%&&%$".$userTo."$%&&%$".$result->getasunto()."$%&&%$".$result->getcontenido()."$%&&%$".$result->getfecha()."$%&&%$".$result->getfrom()."$%&&%$".$result->getto();
					$dataRecibidos=nl2br($dataRecibidos);
					//$data=str_replace("<br />","<br>",$data);
					$dataRecibidos=eregi_replace("[\n|\r|\n\r]", ' ' , $dataRecibidos);
					//echo $data;
					$dataRecibidos=str_replace("'", "\'", $dataRecibidos);
					$dataRecibidos=str_replace('"', '\"', $dataRecibidos);
					//echo $dataRecibidos;
					
					if($result->getestado()=="No Leido")
					{
					?>
					<tr style="font-weight:bold" id="mensaje<?php echo $i;?>">
					<?php 
					}
					else{ ?>
					<tr id="mensaje<?php echo $i;?>">
					<?php }?>
					<script>
					var dataRecibidos<?php echo $i;?> = new Array("<?php echo $dataRecibidos;?>");
					</script>
							
							<td><?php echo $i;?></td>
							<td><?php echo $userFrom;?></td>
							<td><?php echo $result->getasunto();?></td>
							<td><?php echo $result->getfecha();?></td>
							
							<td><a href="#"onclick="eliminarMensaje('<?php echo $i;?>','<?php echo $result->getidMensaje();?>')">Eliminar</a></td>
							<td><a href="#" onclick="marcarLeido(<?php echo $i;?>, <?php echo $result->getidMensaje();?>)">Marcar como Leido</a></td>
							<td><a href="#ventana-mensaje" onclick="verMensajeRecib(dataRecibidos<?php echo $i;?>,<?php echo $i;?>,<?php echo $result->getidMensaje();?>);">Ver mensaje</a></td>
							
					</tr>
					
							
					<?php
					
					$i++;
				}
				
			}
		}
		else
		{
			echo "Bandeja de Entrada Vacia";
		}
		?>
		<script>
			function marcarLeido(idFila,idMensaje)
			{
				document.getElementById("mensaje"+idFila).style.fontWeight = 'normal';
				// AQUI VA UN $post a la db para cambiar el estado del mensaje
				$.post("cambiaEstadoMensaje.php",{"idMensaje":idMensaje, "opc":"Leido"},function(datos){
					//alert(datos);
					switch(datos)
					      {
					      	case "1": 
						      		
					      		 
						      	break;


					      	case "0":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en cambio del mensaje, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
							      	
					      
					      	case "-1":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en SQL, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
					      	
					      	case "-2":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>No se seleccionó el destinatario</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      				break;
					       default:
									
								$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
						    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
					    	}
					
					});
			}
			function eliminarMensaje(idFila,idMensaje)
			{
				//document.getElementById("mensaje"+idFila).style.fontWeight = 'normal';
				// AQUI VA UN $post a la db para cambiar el estado del mensaje
				$.post("cambiaEstadoMensaje.php",{"idMensaje":idMensaje, "opc":"Eliminado"},function(datos){
					//alert(datos);
					switch(datos)
					      {
					      	case "1": 
					      		$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Información',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Mensaje Eliminado</strong></p>"+
					    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
				      		//	document.getElementById("ingreso").reset();
					      	break;
					      		 
						      	break;


					      	case "0":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en cambio del mensaje, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
							      	
					      
					      	case "-1":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en SQL, contactese con administracion</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		break;
					      	
					      	case "-2":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>No se seleccionó el destinatario</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      				break;
					       default:
									
								$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
						    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
					    	}
					
					});
			}
			function botonVistaMensaje(atributo)
			{
				
				 //var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				 //alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
				 $.ajaxSetup({async: false});	
				 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					 
					});
					 
			}
			function verMensajeRecib(data,fila,idMensaje)
			{
				//alert(data);
				data= data[0].split("$%&&%$");
				//alert(data);
				marcarLeido(fila,idMensaje);
				botonVistaMensaje('#ventana-mensaje');
				$("#idMensaje").text(data[0]);
				$("#mensajeDe").text(data[1]);
				$("#mensajePara").text(data[2]);
				$("#mensajeAsunto").text(data[3]);
				if (data[4]!=0)	$("#mensajeContenido").html(data[4]);
				else $("#mensajeContenido").text("Sin Contenido");
				$("#mensajeFecha").text(data[5]);
				$("#mensajeDeId").text(data[6]);
				$("#mensajeParaId").text(data[7]);
				 

				
				
			}
		</script>
					</tbody>
				</table>
				<script>
		$(".botonVistaMensaje").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			// alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
				});
				 
		 });

		</script>
			
		<?php 
		
	}
	
	public function viewMensaje()
	{
		?>
		
				<h3 style="text-align:center">Inicio » Bandeja de Entrada » Mensaje</h3>
				<table data-role="table" id="viewMensaje" class="ui-responsive">
					<tr style="display:none">
						<td >idMensaje:</td>
						<td id="idMensaje"></td>
					</tr>
					<tr style="display:none">
						<td >DeId:</td>
						<td id="mensajeDeId"></td>
					</tr>
					
					<tr style="display:none">
						<td>ParaId:</td>
						<td id="mensajeParaId"></td>
					</tr>
					<tr>
						<td>De:</td>
						<td id="mensajeDe"></td>
					</tr>
					<tr>
						<td>Para:</td>
						<td id="mensajePara"></td>
					</tr>
					<tr>
						<td>Fecha:</td>
						<td id="mensajeFecha"></td>
					</tr>
					<tr>
						<td>Asunto:</td>
						<td id="mensajeAsunto"></td>
					</tr>
						
				</table>
				<hr>
				<div id="mensajeContenido"></div>
				<br><br>
				<fieldset class="ui-grid-a">
					<a href="#redactar-mensaje" data-role="button" data-theme="b"  data-inline="true" onclick="responderMensaje()" >Responder</a>
					
					<a href="#bandeja-entrada" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Volver</a>
				</fieldset>
				<script>
					function responderMensaje()
					{
						
						botonVistaMensaje('#redactar-mensaje');
						//alert(document.getElementById("mensajeDeId").textContent);
						
						idMensaje = document.getElementById("idMensaje").textContent;
						
						idFrom = document.getElementById("mensajeDeId").textContent;
						idTo = document.getElementById("mensajeParaId").textContent;
						nameFrom = document.getElementById("mensajeDe").textContent;
						nameTo = document.getElementById("mensajePara").textContent;
						date = document.getElementById("mensajeFecha").textContent;
						subject = document.getElementById("mensajeAsunto").textContent;
						content = document.getElementById("mensajeContenido").innerText==null?document.getElementById("mensajeContenido").textContent:document.getElementById("mensajeContenido").innerText;
						//alert(idMensaje+" "+idFrom+" "+idTo+" "+nameFrom+" "+nameTo+" "+date+" "+subject+" "+content);

						$("#msgSubject").val("RE: "+subject);
						var txt="\n\r\n\r__________\nEl dia "+date+", "+nameFrom+" escribió: "+'\n\r'+content+"";
						$("#msgContent").val(txt);
						$("#msgTo").val(idFrom);
						$('#msgTo').selectmenu('refresh', true);
						
						
						
						
					}
				</script>
				<script>
			function botonVistaMensaje(atributo)
			{
				
				 //var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				 //alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
				 $.ajaxSetup({async: false});
				 
				 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					 //$('#msgTo').selectmenu('refresh', true);
					 	
					});
				 
					 
			}
			

		</script>
			
			
		<?php 
	}
	public function mensajesEnviados($idUser)
	{
		?>
			
					<h3 style="text-align:center">Inicio » Mensajes Enviados</h3>
					<fieldset class="ui-grid-a">
						<a href="#redactar-mensaje" data-role="button" data-theme="b"  data-inline="true" onclick="limpiarMsj()" class="botonVistaMensaje">Redactar</a>
						
						<a href="#bandeja-entrada" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Bandeja de Entrada</a>
						<a href="#mensajes-eliminados" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Eliminados</a>
					</fieldset>
					
					<script>
						function limpiarMsj()
						{
							$("#msgSubject").val("");
							$("#msgTo").val('nadie');
							$('#msgTo').selectmenu('refresh', true);
							$("#msgContent").val("");
							
						}
					</script>
			<?php 
			$mensajesEnviados=controlMensajeria::getMensajes($idUser,"Enviados");
			?>
					<table data-role="table" id="bandejaEntrada" class="ui-responsive">
						<thead>
							<tr>
							<th></th>
							<th>Para</th>
							<th>Asunto</th>
							<th>Fecha</th>
							
							
							</tr>
						</thead>
						<tbody>
			<?php 
			$i=1;
			if(count($mensajesEnviados)>0)
			{
				foreach($mensajesEnviados as $result)
				{
					$userFrom=controlUsuario::getuserFullName($result->getfrom());
					$userTo=controlUsuario::getuserFullName($result->getto());
					$dataEnviados=$result->getidMensaje()."$%&&%$".$userFrom."$%&&%$".$userTo."$%&&%$".$result->getasunto()."$%&&%$".$result->getcontenido()."$%&&%$".$result->getfecha()."$%&&%$".$result->getfrom()."$%&&%$".$result->getto();
					$dataEnviados=nl2br($dataEnviados);
					//$data=str_replace("<br />","<br>",$data);
					$dataEnviados=eregi_replace("[\n|\r|\n\r]", ' ' , $dataEnviados);
					//echo $data;
					$dataEnviados=str_replace("'", "\'", $dataEnviados);
					$dataEnviados=str_replace('"', '\"', $dataEnviados);
					//echo $dataEnviados;
					if($result->getestado()=="No Leido")
					{
					?>
					<tr style="font-weight:bold" id="mensaje<?php echo $i;?>">
					<?php 
					}
					else{ ?>
					<tr id="mensaje<?php echo $i;?>">
					<?php }?>
					<script>
						var dataEnviados<?php echo $i;?> = new Array("<?php echo $dataEnviados;?>");
					</script>
							
							<td><?php echo $i;?></td>
							<td>Para: <?php echo $userTo;?></td>
							<td><?php echo $result->getasunto();?></td>
							<td><?php echo $result->getfecha();?></td>
							<td><a href="#ventana-mensaje" onclick="verMensajeLeido(dataEnviados<?php echo $i;?>,<?php echo $i;?>);">Ver mensaje</a></td>
							
					</tr>
					<?php
					$i++;
				}
			}
			else
			{
				echo "Sin mensajes enviados";
			}
			?>
			<script>
				
				function verMensajeLeido(data,fila)
				{
					botonVistaMensaje('#ventana-mensaje');
					data= data[0].split("$%&&%$");
					
					
					$("#idMensaje").text(data[0]);
					$("#mensajeDe").text(data[1]);
					$("#mensajePara").text(data[2]);
					$("#mensajeAsunto").text(data[3]);
					$("#mensajeContenido").html(data[4]);
					$("#mensajeFecha").text(data[5]);
					$("#mensajeDeId").text(data[6]);
					$("#mensajeParaId").text(data[7]);
					 
	
					
					
				}
			</script>
						</tbody>
					</table>
					<script>
			function botonVistaMensaje(atributo)
			{
				
				 //var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				 //alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
				 $.ajaxSetup({async: false});	
				 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					});
					 
			}
			$(".botonVistaMensaje").bind('tap',function (){
				 
				 var atributo=$(this).attr("href");
				 //alert("boton apretado");
				 atributo=atributo.split("#");
				// alert(atributo[1]);
				 atributo1="content-"+atributo[1]; 
					
				 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('pagecreate');
					});
					 
			 });
			

		</script>
				
			<?php 
			
		}
		public function mensajesEliminados($idUser)
		{
			?>
			
						<h3 style="text-align:center">Inicio » Mensajes Eliminados</h3>
						<fieldset class="ui-grid-a">
							<a href="#redactar-mensaje" data-role="button" data-theme="b"  data-inline="true" onclick="limpiarMsj()" class="botonVistaMensaje">Redactar</a>
							<a href="#bandeja-entrada" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Bandeja de Entrada</a>
							<a href="#mensajes-enviados" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true" class="botonVistaMensaje">Enviados</a>
						</fieldset>
						
						<script>
							function limpiarMsj()
							{
								$("#msgSubject").val("");
								$("#msgTo").val('nadie');
								$('#msgTo').selectmenu('refresh', true);
								$("#msgContent").val("");
								
							}
						</script>
				<?php 
				$mensajesEliminados=controlMensajeria::getMensajes($idUser);
				 
				$j=0;
				if(count($mensajesEliminados)>0)
				{
					
					?>
					
					<table data-role="table" id="bandejaEntrada" class="ui-responsive">
							<thead>
								<tr>
								<th></th>
								<th>De</th>
								<th>Asunto</th>
								<th>Fecha</th>
								
								
								</tr>
							</thead>
							<tbody>
					<?php 
					foreach($mensajesEliminados as $result)
					{
						
						if($result->getestado()=="Eliminado")
						{
							$j++;
							$userFrom=controlUsuario::getuserFullName($result->getfrom());
							$userTo=controlUsuario::getuserFullName($result->getto());
							$dataEliminados=$result->getidMensaje()."$%&&%$".$userFrom."$%&&%$".$userTo."$%&&%$".$result->getasunto()."$%&&%$".$result->getcontenido()."$%&&%$".$result->getfecha()."$%&&%$".$result->getfrom()."$%&&%$".$result->getto();
							$dataEliminados=nl2br($dataEliminados);
							//$data=str_replace("<br />","<br>",$data);
							$dataEliminados=eregi_replace("[\n|\r|\n\r]", ' ' , $dataEliminados);
							//echo $data;
							$dataEliminados=str_replace("'", "\'", $dataEliminados);
							$dataEliminados=str_replace('"', '\"', $dataEliminados);
							
							if($result->getestado()=="No Leido")
							{
							?>
							<tr style="font-weight:bold" id="mensaje<?php echo $j;?>">
							<?php 
							}
							else{ ?>
							<tr id="mensaje<?php echo $j;?>">
							<?php }?>
							<script>
							var dataEliminados<?php echo $j;?> = new Array('<?php echo $dataEliminados;?>');
							</script>
									
									<td><?php echo $j;?></td>
									<td><?php echo $userFrom;?></td>
									<td><?php echo $result->getasunto();?></td>
									<td><?php echo $result->getfecha();?></td>
									<td><a href="#" onclick="reestablecerMensaje(<?php echo $j;?>, <?php echo $result->getidMensaje();?>)">Reestablecer</a></td>
									<td><a href="#ventana-mensaje" onclick="verMensajeElim(dataEliminados<?php echo $j;?>,<?php echo $j;?>);">Ver mensaje</a></td>
									
							</tr>
							
									
							<?php
							
							
							
						}
						
						
					}
					
				}
				else
				{
					echo "Sin mensajes eliminados";
				}
				?>
				<script>
					
					function verMensajeElim(data,fila)
					{
						botonVistaMensaje("#ventana-mensaje");
						data= data[0].split("$%&&%$");
						
					
						$("#idMensaje").text(data[0]);
						$("#mensajeDe").text(data[1]);
						$("#mensajePara").text(data[2]);
						$("#mensajeAsunto").text(data[3]);
						$("#mensajeContenido").html(data[4]);
						$("#mensajeFecha").text(data[5]);
						$("#mensajeDeId").text(data[6]);
						$("#mensajeParaId").text(data[7]);
						 
		
						
						
					}
					function reestablecerMensaje(idFila,idMensaje)
					{
						//document.getElementById("mensaje"+idFila).style.fontWeight = 'normal';
						// AQUI VA UN $post a la db para cambiar el estado del mensaje
						$.post("cambiaEstadoMensaje.php",{"idMensaje":idMensaje, "opc":"Leido"},function(datos){
							//alert(datos);
							switch(datos)
							      {
							      	case "1":
							      		$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Información',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Mensaje Reestablecido</strong></p>"+
							    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    		      
							    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  }); 
								      		
							      		 
								      	break;


							      	case "0":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en cambio del mensaje, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      		break;
									      	
							      
							      	case "-1":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en SQL, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      		break;
							      	
							      	case "-2":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>No se seleccionó el destinatario</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							       default:
											
										$('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Información de ingreso',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
								    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"+
								    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  })
							    	}
							
							});
					}
				</script>
							</tbody>
						</table>
							<script>
		function botonVistaMensaje(atributo)
		{
			
			 //var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
			 $.ajaxSetup({async: false});	
			 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
				});
				 
		}
		$(".botonVistaMensaje").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			// alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
				});
				 
		 });
		

		</script>
					
				<?php 
				
			}
			public function vistasMensajeria()
	{
		?>
		<div data-role="page" id="mensajes-eliminados">
			<div data-role="content" id="content-mensajes-eliminados"></div>
		</div>		
		
		<div data-role="page" id="mensajes-enviados">
			<div data-role="content" id="content-mensajes-enviados"></div>
		</div>	
		
		<div data-role="page" id="ventana-mensaje">
			<div data-role="content" id="content-ventana-mensaje"></div>
		</div>
		
		<div data-role="page" id="bandeja-entrada">
			<div data-role="content" id="content-bandeja-entrada"></div>
		</div>
		
		<div data-role="page" id="redactar-mensaje">
			<div data-role="content" id="content-redactar-mensaje"></div>
		</div>
				
		<?php 
	}	
		
	
}
?>