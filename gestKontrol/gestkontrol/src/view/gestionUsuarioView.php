<?php
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlOperador.class.php');
require_once ('src/classes/operador.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/cliente.class.php');

class gestionUsuarioView
{
	public function getIngresoUsuario($nivelUsuario,$idEmpresa){
		?>
				
					<h3>Inicio » Nuevo Usuario</h3>
					<hr>
					<!-- Datos personales Visita -->
					<form action="post" id="ingreso-usuario">
											
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre Completo (incluye apellido):</label>
							<input type="text" name="nombreCompletoUsuario" id="name" value=""  />
						</div>
																	
					    <div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre de Usuario:</label>
							<input type="text" name="nombreUsuario" id="name" value=""  />
						</div>
					
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Contraseña:</label>
							<input type="password" name="contrasenaUsuario" id="name" value=""  />
						</div>
					
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Confirme contraseña:</label>
							<input type="password" name="contrasenaUsuarioConf" id="name" value=""  />
						</div>
											
						<!--div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Correo electrónico:</label>
							<input type="text" name="correoUsuario" id="name" value=""  />
						</div-->
						
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nivel:</label>
							<select name='nivelUsuario' id='name'  tabindex='-1'>
								<?php switch ($nivelUsuario)
								{
									case "4":
									?>
										<option value='3'>Nivel 3: Usuario de una empresa</option>
										<option value='4'>Nivel 4: Administrador de una empresa</option>
									<?php 	
										break;
									case "5":?>
									
									<option value='1'>Nivel 1: Validador de visitas vehicular</option>
									<option value='2'>Nivel 2: Validador de visitas Peatonales</option>
									<option value='3'>Nivel 3: Usuario de una empresa</option>
									<option value='4'>Nivel 4: Administrador de una empresa</option>
									<option value='5'>Nivel 5: Administrador</option>
									
									<?php break;
									case "6":
										//die("ctm");
									?>
									
									<option value='1'>Nivel 1: Validador de visitas vehicular</option>
									<option value='2'>Nivel 2: Validador de visitas Peatonales</option>
									<option value='3'>Nivel 3: Usuario de una empresa</option>
									<option value='4'>Nivel 4: Administrador de una empresa</option>
									<option value='5'>Nivel 5: Administrador</option>
									<option value='6'>Nivel 6: Developer</option>
									<?php
									break; 
								}?>
									
							</select>
						</div>
					
						<hr>
											
						<div data-role="fieldcontain" id="radios">
    						<fieldset data-role="controlgroup" data-type="horizontal">
    						<legend>Tipo de Usuario:</legend>
    						<?php switch ($nivelUsuario)
								{
									case "4":?>
         						<input type="radio" name="radioOpcion" id="radio-cliente" value="usuarioCliente" checked="checked" />
         						<label for="radio-cliente">Cliente</label>
         						<script> opcionesUsuario('cli'); </script>
								<?php break;
								case "5" :?>
         						<input type="radio" name="radioOpcion" id="radio-cliente" value="usuarioCliente" onClick="opcionesUsuario('cli');" />
         						<label for="radio-cliente">Cliente</label>
         						<input type="radio" name="radioOpcion" id="radio-operador" value="usuarioOperador" onClick="opcionesUsuario('ope');" />
					         	<label for="radio-operador">Operador</label>
					         	<?php break;
					         	case "6":
					         	?>
					         		<input type="radio" name="radioOpcion" id="radio-cliente" value="usuarioCliente" onClick="opcionesUsuario('cli');" />
					         		<label for="radio-cliente">Cliente</label>
					         		<input type="radio" name="radioOpcion" id="radio-operador" value="usuarioOperador" onClick="opcionesUsuario('ope');" />
					         	   	<label for="radio-operador">Operador</label>
					         						         	
     						         	<?php 
					         		break;
								}?>
							</fieldset>
						</div>
						<script>
						
						
											
						
							function opcionesUsuario(opc)
							{
								
								if (opc=="cli"){
									$("#guardar-usuario").removeClass("ui-disabled").addClass("");
									$("#colapsable-menu").css("display","block");
									$("#colapsable-menuo").css("display","none");
									
									
									}
							   	else
								   	{
								   	$("#colapsable-menuo").css("display","block");
								   	$("#colapsable-menu").css("display","none");
								   	$("#guardar-usuario").removeClass("ui-disabled").addClass("");
							   		}
							}
						</script>
						<div id="colapsable-menu" data-role="fieldcontain" style="display: none;">
						<select name='select-empresa' id='select-empresa'>
						<?php 
						
						if ($nivelUsuario!=5 && $nivelUsuario!=6 )$cliente = controlCliente::listaClientes($idEmpresa,"1");
						else $cliente = controlCliente::listaClientes($idEmpresa,$nivelUsuario);
						if(count($cliente)>0)
						{
							foreach ($cliente as $cli)
							{
						?>
							<option value="<?php echo $cli->getidCliente();?>"><?php echo $cli->getnombreEmpresa();?></option>
						<?php 
							}
						}
						?>
						</select>
						 </div>
						 <div data-role="content" id="colapsable-menuo" style="display: none;">
						 	<div data-role='fieldcontain'>
								<label for='name'><strong class='red'>*</strong>Telefono Fijo:</label>
								<input type='text' name='telefonoOperador' id='name' class='entrada' value='' />
							</div>
							<br>
							<div data-role='fieldcontain'>
								<label for='name'><strong class='red'>*</strong>Celular:</label>
								<input type='text' name='celularOperador' id='name' class='entrada' value=''  />
							</div>
							<br>
							<div data-role='fieldcontain'>
								<label for='name'><strong class='red'>*</strong>Ubicacion en el edificio:</label>
								<input type='text' name='ubicacionOperador' id='name' class='entrada' value=''  />
							</div>
							<br>
							<div data-role='fieldcontain'>
								<label for='name'><strong class='red'>*</strong>Orientacion de la ubicacion:</label>
								<input type='text' name='orientacionOperador' id='name' class='entrada' value=''  />
							</div>
						 </div>
						
						
						<hr>
				
						<fieldset class="ui-grid-a">
							<a href="" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-usuario" class="ui-disabled">Guardar</a>
							<a href="#inicio" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
						</fieldset>
				
					</form>
					<script>
				//##########################----INICIO GUARDAR USUARIO--------###########################################3
				
					function guardarUsuario()
					{
					   var datos = $("#ingreso-usuario").serialize();//Serializamos los datos a enviar
					   //alert(datos);
					   $.ajax({
					   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
					   url: "validaIngresoUsuario.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
					   data: datos, //Variable que transferira los datos
					   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
					   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
					     						 //Mostrar mensaje que se esta procesando el script
					   },
					   dataType: "html",
					   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
					     
					      switch(datos)
					      {
					      	case "1": 
						      		
					      		 $('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
						    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
					      			document.getElementById("ingreso").reset();
						      	break;
							      	
					      	case "0":
						      	
					      		$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Ingrese todos los campos solicitados</strong></p>"
					    			  
					    			  
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      		
						      	    break;
					      	case "-1":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Ingrese todos los datos de operador</strong></p>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      				break;
					      	case "-2":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>El usuario ya esta ingresado en el sistema</strong></p>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  })
					      				break;
					      	case "-3":
					      	$('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Problema',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Las contraseñas no coinciden</strong></p>"
				    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  })
				      				break;
				
					      	case "-4":
						      	$('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Problema',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>El operador ya esta ingresado</strong></p>"
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
						    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
					    		 
						      	 	
					      
						  } 
					   }
					   });
					   return false;
					}
					
				
				//##########################----FIN GUARDAR USUARIO--------###########################################3
				</script>
				
				<?php 
	}
	public function getEditarUsuario($nivelUsuario,$idEmpresa)
	{
		?>
				
					<h3>Inicio » Editar Usuario </h3>
					<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
						
				<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
							
				<!-- ES LA LISTA DEL VALIDAR VISITA!!! -->
				<div id="editarUsuarios"> 
				<?php 
					
					
					if ($nivelUsuario>="5")$usuarios = controlUsuario::listUsuarios();
					else $usuarios = controlUsuario::listUsuarios($idEmpresa);
					
					echo "<ul data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-dividertheme=\"d\">";
					$empresa="";	
					if(count($usuarios)>0)
					{
				
					foreach ($usuarios as $result)
					{
						
						//var_dump($result);
						if($empresa!=$result['company'])echo "<li data-role=\"list-divider\">".$result['company']."</li>";
						$empresa=$result['company'];
						
						?>
							
						<li data-icon="gear">
						 <?php if (file_exists('src/img/usuarios/'.$result["idUser"].'.jpg'))
						 {?>
						 <img src="src/img/usuarios/<?php echo $result["idUser"]?>.jpg" alt="Avatar" height="120" width="120">
						 <?php }
						 else {?>
						 
						 <img src="src/img/avatar.jpg" alt="Avatar" height="120" width="120">
						 <?php }?>
						<h3 class="ui-li-heading"> <?php echo $result["userFullName"];?></h3>
						
						<br>
						<p>Correo:  <?php echo $result["mail"] ?></p>
						<p>Empresa: <?php echo $result["company"];?> </p>
						<p>Nivel: <?php echo $result["level"];?></p>
						<?php
						$fullname=$result["userFullName"];
						
						if($result["company"]=="Seguridad"&&controlOperador::getIdOperador($result["idUser"])!=null){
							$datosOperador=controlOperador::getOperador($result["idUser"]);
							
							echo "<hr>
									<p>Telefono del Operador: ".$datosOperador->gettelefono()."</p>
									<p>Celular del Operador: ".$datosOperador->getcelular()."</p>
									<p>Ubicacion del Operador dentro del edificio: ".$datosOperador->getubicacionEdificio()."</p>";
						}
						echo "<hr>";
						echo "<div data-role='controlgroup' data-type='horizontal' data-mini='true' data-inline='true'>";
						
						if($result["company"]=="Seguridad"&&controlOperador::getIdOperador($result["idUser"])!=null) 
							echo "<a href='#edicion-operador' data-role='button' class='editarUsuarios' 
										name ='1'data-icon='grid' data-rel='dialog' title='".$result["idUser"]."' >Editar</a>
									<a href='#eliminar-usuario' id='opendialog-eliminar-usuario' 
										title='".$result["idUser"]."' data-role='button' data-icon='delete' name=".$result["userFullName"].">Eliminar</a>";
						else echo "<a href='#edicion-usuario' data-role='button' name='0' class='editarUsuarios' 
										data-icon='grid' data-rel='dialog' title='".$result["idUser"]."' >Editar</a>
									<a href='#' id='opendialog-eliminar-usuario' name=".$fullname." 
										title='".$result["idUser"]."' data-role='button' data-icon='delete' >Eliminar</a>";
								?>
						<script type="text/javascript">
							// Popup window code
							function newPopup(url) {
								window.open(
									url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
							}
						</script>
						<a href="#" onclick="newPopup('uploadFoto.php?iduser=<?php echo $result["idUser"];?>');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir o Editar Foto</a>
					</div>
					<?php 
						echo "</li>";
					}
					echo "<li class=\"no-results\" style= 'display:none;'>No se encontraron resultados.</li>";
				
					
					}
					else
					{
						echo "<li class=\"no-results\">No se encontraron resultados.</li>";
					}
					echo "</ul>";
					?>
					
					</div>
					<script>
					//##########################----INICIO EDICION USUARIO---################################################
					$(document).ready(function(){
						
						

						$(".editarUsuarios").click(function(){
							var idUser = $(this).attr("title");
							var ope = $(this).attr("name");
							var datos;
							$.get("getDatosUsuario.php",{'idUser':idUser,'ope':ope},function(datos){
								//alert(datos);

								 var arr = datos.split("&");
								 if(arr.length>0)
						          {
							          if (ope=="0"){
							             //alert(arr[0]); 
							             $("#efullNameUser").val(arr[0]);
							             $("#euserNameUser").val(arr[1]);
							             $("#email").val(arr[2]);
							             $("#elevel").val(arr[3]);
							             $("#eidUser").val(arr[4]);
							            
							          }
							          else
							          {
								      	//alert(arr[0]); 
								        $("#efullNameOp").val(arr[0]);
								        $("#euserNameOp").val(arr[1]);
								        $("#emailOp").val(arr[2]);
								        $("#elevelOp").val(arr[3]);
								        $("#etelOp").val(arr[4]);
								        $("#ecelOp").val(arr[5]);
								        $("#eubiOp").val(arr[6]);
								        $("#eidUserOp").val(arr[7]); 
								        $("#eoriOp").val(arr[8]);   
								      }
						          }
								}
							);

							
					  		//return false;
						
						});

						$("#envia-edicion-usuario").click(function(){
							//alert("hola");
							 //var datos = $("#edicion-usuario-popup").serialize();//Serializamos los datos a enviar
							 //alert(datos);
							$.post("enviaEdicionUsuarios.php", $("#edicion-usuario-popup").serialize(),function(datos){
								//alert(data);
								switch(datos)
							      {
							      	case "1": 
								      		
							      		 $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Información',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>La edicion fue exitosa</strong></p>"+
								    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
							      			//document.getElementById("ingreso").reset();
								      	break;
									      	
							      	case "0":
								      	
							      		$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Ingrese todos los campos solicitados</strong></p>"+
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
							    			  "<p class='centrado'><strong>Error de envio nulo, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	
							      	case "2":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	case "3":
							      	$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Problema',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Las contraseñas no coinciden</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
						      				break;

							      	case "4":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Atencion',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>No se realizo ningun cambio</strong></p>"+
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
								    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  })
							    		 
								      	 	
							      
								  } 
								
								
								});
							});
						$("#envia-edicion-operador").click(function(){
							//alert("hola");
							 //var datos = $("#edicion-operador-popup").serialize();//Serializamos los datos a enviar
							// alert(datos);
							$.post("enviaEdicionUsuarios.php", $("#edicion-operador-popup").serialize(),function(datos){
								switch(datos)
							      {
							      	case "1": 
								      		
							      		 $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Información',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>La edicion fue exitosa</strong></p>"+
								    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
							      			//document.getElementById("ingreso").reset();
								      	break;
									      	
							      	case "0":
								      	
							      		$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Ingrese todos los campos solicitados</strong></p>"+
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
							    			  "<p class='centrado'><strong>Error de envio nulo, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	
							      	case "2":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	case "3":
							      	$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Problema',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Las contraseñas no coinciden</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
						      				break;
							      	case "4":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Atencion',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>No se realizo ningun cambio</strong></p>"+
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
								    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  })
							    		 
								      	 	
							      
								  }
								
								});
							});
						
						
						

						

					});
					
					$(document).delegate('#opendialog-eliminar-usuario', 'click', function() {
						  // NOTE: The selector can be whatever you like, so long as it is an HTML element.
						  //       If you prefer, it can be a member of the current page, or an anonymous div
						  //       like shown.
						  var name = $(this).attr("name");
						  var id= $(this).attr("title");
						  //alert(name);
						  //guardaNombre(name);
						  
						  $('<div>').simpledialog2({
						    mode: 'blank',
						    headerText: 'Eliminar Usuario',
						    headerClose: true,
						    blankContent : 
							  "<p class='centrado'><img src='src/img/avatar.jpg' width='120' height='120'></p>"+
						      "<h4 class='centrado'>"+name+"</h4>"+
						      // NOTE: the use of rel="close" causes this button to close the dialog.
						      "<a rel='close' data-role='button' data-rel='dialog' href='#' data-transition='pop' data-icon='delete' onClick=eliminaUsuario("+id+");>Eliminar</a>"+
							  "<a rel='close' data-role='button' href='#' data-icon='back' data-theme='c'>Volver</a>"
							})
						  
						});
					function eliminaUsuario(id)
					{
						//alert(id);
						
						$.post("enviaEdicionUsuarios.php", {'idUser':id},function(datos){
							//alert(datos);
							switch(datos)
							      {
							      	case "1": 
								      		
							      		 $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Información',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>La eliminacion fue exitosa</strong></p>"+
								    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
							      		//	document.getElementById("ingreso").reset();
								      	break;
									      	
							      
							      	case "-1":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error de envio nulo, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	
							      	case "2":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	case "4":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Atencion',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>No se realizo ningun cambio</strong></p>"+
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
								    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  })
							    		 
								      	 	
							      
								  }
							
							});
					}
					
		//##########################----FIN EDICION USUARIO---################################################

		</script>
					
					<?php
					
		}
		
		public function getVentanaEdicionUsuarios($level)
		{
			?>
			
			<div data-role="page" id="edicion-usuario">
				<div data-role="header" data-theme="b">
						<h1>Editar Usuario</h1>
				</div>
					
				<div data-role="content">
					<form action="post" id="edicion-usuario-popup">
						<div data-role="fieldcontain"style= 'display:none;'>
							<label for="name" ><strong class="red">*</strong> idUsuario:</label>
							<input type="text" name="eidUser" id="eidUser" value=""/>
						</div>
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre Completo (incluye apellido):</label>
							<input type="text" name="efullName" id="efullNameUser" value=""  />
						</div>
																	
					    <div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre de Usuario:</label>
							<input type="text" name="euserName" id="euserNameUser" value=""  />
						</div>
						
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Contraseña Nueva:</label>
							<input type="password" name="enewPass" id="name" value=""  />
						</div>
					
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Confirme contraseña Nueva:</label>
							<input type="password" name="enewPassConf" id="name" value=""  />
						</div>
											
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Correo electrónico:</label>
							<input type="text" name="email" id="email" value=""  />
						</div>
						<?php 
						if ($level=="5"){
						?>
						
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nivel:</label>
							<input type="text" name="elevel" id="elevel" value=""  />
						</div>
						<?php }?>
						<a href='#' data-role='button' id="envia-edicion-usuario" data-role='button' data-role="button"
									data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'   >Editar</a>
						<a href='#editar-usuario'  data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l'  >Volver</a>
					</form>
				</div>
			</div>
			
			
			
			
			<?php 
		}
		public function getVentanaEdicionOperador($level)
		{
			?>
					
				<div data-role="page" id="edicion-operador">
					<div data-role="header" data-theme="b">
						<h1>Editar Operador</h1>
					</div>
					<div data-role="content">
						<form action="post" id="edicion-operador-popup">
								<div data-role="fieldcontain" style= 'display:none;'>
									<label for="name" ><strong class="red">*</strong> idUsuario:</label>
									<input type="text" name="eidUserOp" id="eidUserOp" value=""  />
								</div>
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Nombre Completo (incluye apellido):</label>
									<input type="text" name="efullName" id="efullNameOp" value=""  />
								</div>
																			
							    <div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Nombre de Usuario:</label>
									<input type="text" name="euserName" id="euserNameOp" value=""  />
								</div>
													
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Contraseña Nueva:</label>
									<input type="password" name="enewPass" id="name" value=""  />
								</div>
							
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Confirme contraseña Nueva:</label>
									<input type="password" name="enewPassConf" id="name" value=""  />
								</div>
													
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Correo electrónico:</label>
									<input type="text" name="email" id="emailOp" value=""  />
								</div>
								<?php 
									if ($level=="5"){
								?>
								
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Nivel:</label>
									<input type="text" name="elevel" id="elevelOp" value=""  />
								</div>
								<?php 
									}
								?>
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Telefono:</label>
									<input type="text" name="etel" id="etelOp" value=""  />
								</div>
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Celular:</label>
									<input type="text" name="ecel" id="ecelOp" value=""  />
								</div>
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Ubicacion:</label>
									<input type="text" name="eubi" id="eubiOp" value=""  />
								</div>
								<div data-role="fieldcontain">
									<label for="name"><strong class="red">*</strong> Orientacion:</label>
									<input type="text" name="eori" id="eoriOp" value=""  />
								</div>
								
								<a href='#' data-role='button' id="envia-edicion-operador" data-role="button"
									data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'  >Editar</a>
								<a href='#editar-usuario' data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l'  >Volver</a>
						</form>
					</div>
				</div>
					
					
					
					
					<?php 
				}

		public function getMiPerfil($idCliente=null,$usuario=null)
				{
						
					
					?>
						
						
								
								<h3>Inicio » Edite sus datos personales</h3>
								
								<hr>
									<!-- Datos personales Visita -->
								<form action="post" id="miPerfilU">
									
										<div data-role="fieldcontain">
											<label for="name"><strong class="red">*</strong> Nombre de Usuario (Nombre y Apellido):</label>
											<input type="text" name="euserNameFull" id="euserNameFull" value="<?php echo isset($usuario) && $usuario!=null?$usuario->getuserFullName():"";?>"  />
										</div>
									
										<div data-role="fieldcontain">
											<label for="name"><strong class="red">*</strong> Nombre de Usuario (Nick Name):</label>
											<input type="text" name="euserName" id="euserNameOp" class="ui-disabled" value="<?php echo isset($usuario) && $usuario!=null?$usuario->getuserName():"";?>"  />
										</div>
										
										<div data-role="fieldcontain">
											<label for="name"><strong class="red">*</strong> Ingrese su contraseña actual:</label>
											<input type="password" name="enewPassActual" id="name" value=""  />
											
											
										</div>
															
										<div data-role="fieldcontain">
											<label for="name"><strong class="red">*</strong> Contraseña Nueva:</label>
											<input type="password" name="enewPass" id="name" value=""  />
										</div>
									
										<div data-role="fieldcontain">
											<label for="name"><strong class="red">*</strong> Confirme contraseña Nueva:</label>
											<input type="password" name="enewPassConf" id="name" value=""  />
										</div>
															
										<div data-role="fieldcontain">
											<label for="name"><strong class="red"></strong> Correo electrónico:</label>
											<input type="text" name="email" id="emailOp" value="<?php echo isset($usuario) && $usuario!=null?$usuario->getmailUsuario():"";?>"  />
										</div>
										<div data-role="fieldcontain">
											<label for="file"> Subir o Editar fotografia:</label>
											
											<script type="text/javascript">
											// Popup window code
											function newPopup(url) {
												window.open(
													url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
											}
											</script>
											<a href="#" onclick="newPopup('uploadFoto.php?iduser=<?php echo $usuario->getidUsuario();?>');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir o Editar Foto</a>
					
										</div>
									<hr>

									<fieldset class="ui-grid-a">
										<a href='#' data-role='button' id="editarPrefilUsuario" data-role="button" data-theme="b" data-inline="true" data-icon='grid' data-rel='dialog'  >Editar</a>
										<a href='#inicio' data-role="button"  data-theme="c" rel="close" data-inline="true" data-icon='arrow-l'  >Volver</a>				
									</fieldset>
														
								</form>
								
								
						
						<script type="text/javascript">

						$(document).ready(function(){

							$("#editarPrefilUsuario").click(function(){

								
								var datos = $("#miPerfilU").serialize();

								//alert("hola");

								$.ajax({
							  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
							  		   url: "capUsuarioMPerfil.php",   //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
							  		   data: datos, //Variable que transferira los datos
							  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
							  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos

											
								  					  			
							  		   },
							  		   dataType: "html",
							  		   success: function(datos){ 

								  			 //alert(datos);

								  			 switch(datos)
								  			   {
								  				   	case "1":

															//alert("update reservaFrecuente ok"); 	//falta preparar las salidas avisando que todo se realizo exitosamente

															$('<div>').simpledialog2({

											      			 	mode: 'blank',
												    		    headerText: 'Información de ingreso',
												    		    headerClose: true,
												    		    blankContent : 
												    			  "<p class='centrado'><strong>La edicion del usuarios fue exitosa, los cambios se reflejaran la proxima vez que inicio la sesion, desea cerrar la sesion?</strong></p>"+
												    			  "<a data-role='button' href='login.php' data-transition='slide' rel='back' data-icon='check'>Aceptar</a>"+
												    		      "<a data-role='button' href='#'  data-transition='pop' rel='close' data-icon='check'>Cerrar </a>"
												    		      // NOTE: the use of rel="close" causes this button to close the dialog.
												    		      
												    		  });
							  			   			
									  				   	break;

								  				   	case "0":
									  				   	
															//alert("no se updateo reservaFrecuente"); 	// falta preparar la salida 

															$('<div>').simpledialog2({

											      			 	mode: 'blank',
												    		    headerText: 'Información de ingreso',
												    		    headerClose: true,
												    		    blankContent : 
												    			  "<p class='centrado'><strong>No se encontraron datos para modificar</strong></p>"+
												    			  "<a data-role='button' href='#'rel='close' data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
												    		      
												    		      // NOTE: the use of rel="close" causes this button to close the dialog.
												    		      
												    		  });
															
								  			   			break;
								  				   	case "-1":
									  				   	
								  				   			//alert("la reserva se realizo exitosamente"); //primera reserva;

									  				   		$('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>Debe completar contraseña nueva y la confirmacion de ella </strong></p>"+
											    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });
								  				   			
									  				   	break;

								  				   	case "-2":

								  				   			//alert("no se realizo la reserva"); // problema en la primera reserva


									  				   		$('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>Para modificar la contraseña debe ingresar primero su contraseña actual</strong></p>"+
											    			  "<a data-role='button' href='#' data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });

									  				   	break;
										  				   		  
								  				   	case "-3":

								  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
								  				  $('<div>').simpledialog2({

									      			 	mode: 'blank',
										    		    headerText: 'Información',
										    		    headerClose: true,
										    		    blankContent : 
										    			  "<p class='centrado'><strong>Deben coincidir la contraseña nueva con la confirmacion de ella</strong></p>"+
										    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
										    		      
										    		      // NOTE: the use of rel="close" causes this button to close the dialog.
										    		      
										    		  });
								  				   			
									  				   	break;	

								  					case "-4":

									  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
									  				  $('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>Por favor ingrese el estacionamiento (*)</strong></p>"+
											    			  "<a data-role='button' href='#'   data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });
									  				   			
										  				   	break;	
										  				default:

											  				/*
											  					log de errores
											  				*/   		   	
									  				   		
								  					   	
									  		   }

								  		   }
								});
								
								});

							});
						
						</script>
						
					<?php 
				}
				public function getAdministrarPerfiles($idCliente=null,$usuario)
				{
					$idCliente = $usuario->getidCliente();
					//$usuarioAll= controlUsuario::getUserG($idCliente);
					/*
					 * Agregar el control indicando que solo puede haber un administrador por cliente los demas solo pueden ser usuarios normales
					 */
					?>
					
						<h3>Inicio » Nuevo Usuario</h3>
						<hr>
					<form action="post" id="ingreso-usuario-cliente">
					<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre Completo (incluye apellido):</label>
							<input type="text" name="nombreCompletoUsuario" id="name" value=""  />
						</div>
																	
					    <div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nombre de Usuario:</label>
							<input type="text" name="nombreUsuarioCliente" id="name" value=""  />
							<input type="text" name="nombreClientes" id="name" value="<?php echo $idCliente?>" style="display:none;" />
							
						</div>
					
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Contraseña:</label>
							<input type="password" name="contrasenaUsuario" id="name" value=""  />
						</div>
					
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Confirme contraseña:</label>
							<input type="password" name="contrasenaUsuarioConf" id="name" value=""  />
						</div>
											
						<div data-role="fieldcontain">
							<label for="name"><strong class="red"></strong> Correo electrónico:</label>
							<input type="text" name="correoUsuario" id="name" value=""  />
						</div>
						<div data-role="fieldcontain">
							<label for="name"><strong class="red">*</strong> Nivel:</label>
							<select name='nivelUsuario' id='name'  tabindex='-1'>
									<option value='0'>Seleccione el nivel del usuario</option>
									<?php 
									if($usuario->getPrivilegio()>4 || $usuario->getPrivilegio()!=4)
									{
									?>
										<option value='3'>Nivel 3: Usuario de una empresa</option>
										<option value='4'>Nivel 4: Administrador de una empresa</option>	
									<?php 
									}
									else
									{
									?>
										<option value='3'>Nivel 3: Usuario de una empresa</option>
									<?php 
									}
									?>
							</select>
						</div>
						<hr>
						<fieldset class="ui-grid-a">
							<a href="" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-usuario-cliente">Guardar</a>
							<a href="#inicio" data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
						</fieldset>	
					</form>	
						
					
					<script>

						$(document).ready(function(){

							$("#guardar-usuario-cliente").click(function(){
								
								var datos = $("#ingreso-usuario-cliente").serialize();
								//alert("hola");
								$.ajax({
							  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
							  		   url: "validaIngresoUsuario.php",   //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
							  		   data: datos, //Variable que transferira los datos
							  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
							  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos

											
								  					  			
							  		   },
							  		   dataType: "html",
							  		   success: function(datos){ 

								  			 //alert(datos);

								  			 switch(datos)
								  			   {
								  				   	case "1":

															//alert("update reservaFrecuente ok"); 	//falta preparar las salidas avisando que todo se realizo exitosamente

															$('<div>').simpledialog2({

											      			 	mode: 'blank',
												    		    headerText: 'Información de ingreso',
												    		    headerClose: true,
												    		    blankContent : 
												    			  "<p class='centrado'><strong>El ingreso del usuario fue exitoso</strong></p>"+
												    			  "<a data-role='button' href='#' data-transition='slide' rel='close' data-icon='check'>Aceptar</a>"
												    		      
												    		      // NOTE: the use of rel="close" causes this button to close the dialog.
												    		      
												    		  });
							  			   			
									  				   	break;

								  				   	case "-2":
									  				   	
															//alert("no se updateo reservaFrecuente"); 	// falta preparar la salida 

															$('<div>').simpledialog2({

											      			 	mode: 'blank',
												    		    headerText: 'Información de ingreso',
												    		    headerClose: true,
												    		    blankContent : 
												    			  "<p class='centrado'><strong>El nombre del usuario ya existe, por favor escriba otro nombre </strong></p>"+
												    			  "<a data-role='button' href='#'rel='close' data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
												    		      
												    		      // NOTE: the use of rel="close" causes this button to close the dialog.
												    		      
												    		  });
															
								  			   			break;
								  				   	case "-1":
									  				   	
								  				   			//alert("la reserva se realizo exitosamente"); //primera reserva;

									  				   		$('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>Por favor ingrese todo los campos que poseen el siguiente simbolo(*)</strong></p>"+
											    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });
								  				   			
									  				   	break;

								  				   	case "2":

								  				   			//alert("no se realizo la reserva"); // problema en la primera reserva


									  				   		$('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>No se logro efectuar la operación pro favor intente mas tarde</strong></p>"+
											    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });

									  				   	break;
										  				   		  
								  				   	case "-3":

								  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
								  				  $('<div>').simpledialog2({

									      			 	mode: 'blank',
										    		    headerText: 'Información',
										    		    headerClose: true,
										    		    blankContent : 
										    			  "<p class='centrado'><strong>Deben coincidir las contraseñas ingresadas</strong></p>"+
										    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
										    		      
										    		      // NOTE: the use of rel="close" causes this button to close the dialog.
										    		      
										    		  });
								  				   			
									  				   	break;	

								  					case "406":

									  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
									  				  $('<div>').simpledialog2({

										      			 	mode: 'blank',
											    		    headerText: 'Información',
											    		    headerClose: true,
											    		    blankContent : 
											    			  "<p class='centrado'><strong>Problemas en el sistema, por favor comunicarse con el administrador, error"+dato+"</strong></p>"+
											    			  "<a data-role='button' href='#'   data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
											    		      
											    		      // NOTE: the use of rel="close" causes this button to close the dialog.
											    		      
											    		  });
									  				   			
										  				   	break;	
										  				   	
										  				default:

											  				/*
											  					log de errores
											  				*/   		   	
									  				   		
								  					   	
									  		   }

								  		   }
								});
								});
							})
					
					</script>
					<?php 
				}
			
				public function getEditarUsuariosCliente($usuario)
				{
					$usuarios = controlUsuario::listadoUsuariosCliente($usuario->getidCliente(),$usuario->getIdUsuario());
					
					?>
					
				
							
							<h3>Inicio » Usuarios de la empresa</h3>
							<div>
			<ul data-role="listview" data-inset="true" data-filter="true"	data-dividertheme="d">
				<?php 
				if(count($usuarios)>0)
				{
					foreach ($usuarios as $user)
					{
						
						//print_r($reserva);
						?>
				<li data-role="list-divider"><?php echo $user->getuserFullName();?></li>

				<li data-icon="gear">
					

					<p class="ui-li-desc">
						Nombre de usuario :
						<?php echo $user->getuserName(); ?>
					</p>
					<p class="ui-li-desc">
						Correo :
						<?php echo $user->getmailUsuario(); ?>
					</p>
					<p class="ui-li-desc">
						Nivel del usuario :
						<?php echo $user->getPrivilegio(); ?>
					</p>
										
					<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
						<a href="#edicion-usuario-client" class="editarUsuarioClie" data-icon="grid" title="<?php echo $user->getuserName()."_".$usuario->getuserName();?>" data-role="button" data-rel="dialog">Editar</a> 
						<a href='#' id='opendialog-eliminar-usuario-C' data-rel="dialog" data-icon="delete"  title="<?php echo $user->getuserName();?>"	data-role="button">Eliminar</a>
						
					</div> 


				</li>
				<?php 
					}
				}
				else
				{
					?>
					<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
						<h3 align="center">No hay visitas registradas</h3>
					</div>
					<?php 
				}
				?>
			</ul>
		</div>
							
						
						</div>
						
				   </div>
				   <script type="text/javascript">
							/*
								vinculo entre capa vista y control, pasando por jquery
							*/
					$(document).ready(function(){

						$(".editarUsuarioClie").click(function(){

							var titulo = $(this).attr("title");
							var dato = titulo.split("_");
							//alert("shietEditarPerfilProveedor"+dato[0]);
							
							 $('#editarUusuariosDeCliente').load('cargaPerfilUsuarioCliente.php?idnick='+dato[0]+'&userClieteEdirP='+dato[1],function(){
									$('#editarUusuariosDeCliente').trigger('create');
							 });

								});
						});		
					</script>
					
					<script>

					$(document).delegate('#opendialog-eliminar-usuario-C', 'click', function() {
						  // NOTE: The selector can be whatever you like, so long as it is an HTML element.
						  //       If you prefer, it can be a member of the current page, or an anonymous div
						  //       like shown.
						  //var name = $(this).attr("name");
						  var id= $(this).attr("title");
						  //alert(name);
						  //guardaNombre(name);
						  
						  $('<div>').simpledialog2({
						    mode: 'blank',
						    headerText: 'Eliminar Usuario',
						    headerClose: true,
						    blankContent : 
							  "<p class='centrado'><img src='src/img/avatar.jpg' width='120' height='120'></p>"+
						      "<h4 class='centrado'>"+id+"</h4>"+
						      // NOTE: the use of rel="close" causes this button to close the dialog.
						      "<a rel='close' data-role='button' data-rel='dialog' href='#' class='' onClick=eli('"+id+"'); data-transition='pop' data-icon='delete' title='"+id+"'>Eliminar</a>"+
							  "<a rel='close' data-role='button' href='#' data-icon='back' data-theme='c'>Volver</a>"
							})
						  
						});
						function eli(id)
						{
							$.post("enviaEdicionUsuarios.php", {'userCliente':id},function(datos){
							//alert(datos);
							
						switch(datos)
							      {
							      	case "1": 
								      		
							      		 $('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Información',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>La eliminacion fue exitosa</strong></p>"+
								    			  "<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
							      		//	document.getElementById("ingreso").reset();
								      	break;
									      	
							      
							      	case "-1":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error de envio nulo, contactese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	
							      	case "2":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Problema',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
							    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
							      				break;
							      	case "4":
								      	$('<div>').simpledialog2({
							    		    mode: 'blank',
							    		    headerText: 'Atencion',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>No se realizo ningun cambio</strong></p>"+
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
								    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" rel='close' data-icon='check'>Aceptar</a>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  })
							    		 
								      	 	
							      
								  }
							
							});
						}
							
						
													
					</script>
					<?php 
					
				}
				
				public function getformIgresDiv() // Codigo generado por Gonzalo
				{
					?>
									<div data-role="page" id="edicion-usuario-client">
							
										<div data-role="header" data-theme="b">	<h1>Edicion de Usuario</h1></div>
										
										<div data-role="content" id="editarUusuariosDeCliente"></div>
								
									</div>
									
					<?php 	
				}
				public function getFormData($idnick,$idnickAc)	// Codigo generado por Gonzalo
				{
					$usuario = controlUsuario::getUserG(null,$idnick,null,null,null,null);
					$ac = controlUsuario::getUserG(null,$idnickAc,null,null,null,null);
					
					//print_r($ac);
					//die();
					?>
					<h3 style="text-align: center" class=""><?php echo $idnick?></h3>
					 
					 <form action="post" id="edit-usuario-cliente">
					 
						<div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Nombre Completo (incluye apellido):</label>
								<input type="text" name="nombreCompletoUsuario" id="name" value="<?php echo $usuario[0]->getuserFullName(); ?>"  />
							</div>
																		
						    <div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Nombre de Usuario:</label>
								<input type="text" name="nombreUsuarioCliente" id="name" value="<?php echo $usuario[0]->getuserName(); ?>" class="ui-disabled" />
								<input type="text" name="editUsuaCliente" id="name" value="<?php echo $idnick?>" style="display:none;" />
								
							</div>
						
							<div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Contraseña:</label>
								<input type="password" name="contrasenaUsuario" id="name" value=""  />
							</div>
						
							<div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Confirme contraseña:</label>
								<input type="password" name="contrasenaUsuarioConf" id="name" value=""  />
							</div>
												
							<div data-role="fieldcontain">
								<label for="name"><strong class="red"></strong> Correo electrónico:</label>
								<input type="text" name="correoUsuario" id="name" value="<?php echo $usuario[0]->getmailUsuario()!=null? $usuario[0]->getmailUsuario() :""; ?>"  />
							</div>
							<div data-role="fieldcontain">
								<label for="name"><strong class="red">*</strong> Nivel:</label>
								<select name='nivelUsuario' id='name'  tabindex='-1'>
										<option value='0'>Seleccione el nivel del usuario</option>
										<?php 
										switch ($ac[0]->getPrivilegio())
										{
											case 4:
												?>
													<option value='3' <?php echo $usuario[0]->getPrivilegio()==3?"selected=selected":""; ?>>Nivel 3: Usuario de una empresa</option>
												<?php 
												break;
												
											case 5:
												?>
													<option value='3' <?php echo $usuario[0]->getPrivilegio()==3? "selected=selected":""; ?>>Nivel 3: Usuario de una empresa</option>
													
												<?php
												 
												break;
												
										    case 6:

										    	?>
										    		<option value='3' <?php echo $usuario[0]->getPrivilegio()==3?"selected=selected":""; ?>>Nivel 3: Usuario de una empresa</option>
													<option value='4' <?php echo $usuario[0]->getPrivilegio()==4?"selected=selected":""; ?>>Nivel 4: Administrador de una empresa</option>
										    	<?php 
										    	
										    	break;
										}
										?>
									
								</select>
							</div>
							<hr>
							
							<fieldset class="ui-grid-a">
								<a href="" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-edicion-usuario-cliente">Guardar</a>
								<a href="#editar-usuario-cliente"  data-rel="dialog" data-role="button" data-theme="c" rel="back"  data-inline="true">Volver</a>
							</fieldset>
							
					</form>
					<script type="text/javascript">

					$(document).ready(function(){

						$("#guardar-edicion-usuario-cliente").click(function(){

							//alert("holaaaaa esta parte se deberia guardar los datos nuevos de los usuarios");
							 var datos = $("#edit-usuario-cliente").serialize();//Serializamos los datos a enviar
							   $.ajax({
							   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
							   url: "capUsuarioMPerfil.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
							   data: datos, //Variable que transferira los datos
							   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
							   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
							     						 //Mostrar mensaje que se esta procesando el script
							   },
							   dataType: "html",
							   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

								     alert(datos);
							     
							      switch(datos)
							      {
							  	case "1":

									//alert("update reservaFrecuente ok"); 	//falta preparar las salidas avisando que todo se realizo exitosamente

									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>La edición del usuario fue exitosa</strong></p>"+
						    			  "<a data-role='button' href='#' onClick=\"window.location.reload()\" data-transition='slide' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	  			   			
			  				   	break;

		  				   	case "-2":
			  				   	
									//alert("no se updateo reservaFrecuente"); 	// falta preparar la salida 

									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>El nombre del usuario ya existe, pro favor escriba otro nombre </strong></p>"+
						    			  "<a data-role='button' href='#'rel='close' data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
									
		  			   			break;
		  				   	case "-1":
			  				   	
		  				   			//alert("la reserva se realizo exitosamente"); //primera reserva;

			  				   		$('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Por favor ingrese todo los campos que poseen el siguiente simbolo(*)</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
		  				   			
			  				   	break;

		  				   	case "2":

		  				   			//alert("no se realizo la reserva"); // problema en la primera reserva


			  				   		$('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>No se logro efectuar la operación pro favor intente mas tarde</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });

			  				   	break;
				  				   		  
		  				   	case "-3":

		  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
				  				  $('<div>').simpledialog2({
		
					      			 	mode: 'blank',
						    		    headerText: 'Información',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Deben coincidir las contraseñas ingresadas</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
		  				   			
			  				   	break;	

		  				 	case "-5":

			  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
					  				  $('<div>').simpledialog2({
			
						      			 	mode: 'blank',
							    		    headerText: 'Información',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Debe ingresar los campos Nombre Completo y Nombre de Usuarios</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    		      
							    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  });
			  				   			
				  				   	break;	

		  					case "-6":

			  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
					  				  $('<div>').simpledialog2({
			
						      			 	mode: 'blank',
							    		    headerText: 'Información',
							    		    headerClose: true,
							    		    blankContent : 
							    			  "<p class='centrado'><strong>Debe llenar el campo Nombre de usuarios</strong></p>"+
							    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
							    		      
							    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  });
			  				   			
				  				   	break;	
									
		  					case "0":

			  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
			  				 
			  				   			
				  				   	break;			
								
		  					case "406":

			  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
			  				  $('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Problemas en el sistema, por favor comunicarse con el administrador, error"+dato+"</strong></p>"+
					    			  "<a data-role='button' href='#'   data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
			  				   			
				  				   	break;	
									   			
									 default:
											
										$('<div>').simpledialog2({
								    		    mode: 'blank',
								    		    headerText: 'Informacion de ingreso',
								    		    headerClose: true,
								    		    blankContent : 
								    			  "<p class='centrado'><strong>Lo sentimos </strong></p>"+
								    			  "<h4 class='centrado'><strong>Dentro de unos minutos el administrador resolvera su problema</strong></h4>"
								    		      
								    		      // NOTE: the use of rel="close" causes this button to close the dialog.
								    		      
								    		  });
							    		  //alert(datos); // SOLO PARA PRUEBAS //log a BD
							    		  
							    		 
								      	 	
							      
								  }
								  
							   }
							   });
							   return false;
							});
						
						});
							
					
					</script>	
					<?php 
					
				}
				public function vistasUsuario($privilegio)
				{
					?>
					<div data-role="page" id="mi-perfil">
						<div data-role="content" id="content-mi-perfil"></div>
					</div>
					<?php 
					
					switch ($privilegio)
					{
						case 5||6:
					?>
					<div data-role="page" id="nuevo-usuario">
						<div data-role="content" id="content-nuevo-usuario"></div>
					</div>
					<div data-role="page" id="editar-usuario">
						<div data-role="content" id="content-editar-usuario"></div>
					</div>
					<div data-role="page" id="Administrar-perfiles">
						<div data-role="content" id="content-Administrar-perfiles"></div>
					</div>
					<div data-role="page" id="editar-usuario-cliente">
						<div data-role="content" id="content-editar-usuario-cliente"></div>
					</div>
					<?php 
						break;
						case 4:
					?>
					
					<div data-role="page" id="Administrar-perfiles">
						<div data-role="content" id="content-Administrar-perfiles"></div>
					</div>
					<div data-role="page" id="editar-usuario-cliente">
						<div data-role="content" id="content-editar-usuario-cliente"></div>
					</div>
					
					<?php 
						break;
					}
				}

}


?>
