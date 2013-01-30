<?php
require_once ('src/view/menuView.class.php');
require_once ('src/classes/controlCliente.class.php');
session_start();
function beginIndex()
{
?>
<!DOCTYPE html> 
<html> 
<head> 
   
   <title>Gest Kontrol</title> 
   
   <meta charset="utf-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1"> 

   <link rel="stylesheet" href="src/css/jquery.mobile-1.1.0.min.css" />
   <link rel="stylesheet" href="src/css/estilos.css" />
   <link rel="stylesheet" type="text/css" href="src/css/jqm-datebox.min.css" /> 
   <link rel="stylesheet" type="text/css" href="src/css/jquery.mobile.simpledialog.min.css" /> 
      
   <script src="src/js/jquery-1.7.1.min.js"></script>
   <script src="src/js/jquery.mobile-1.1.0.min.js"></script>
   
  <!------------- Nuevos JS  ---------------> 
   <script type="text/javascript" src="src/js/jqm-datebox.core.min.js"></script>
   <script type="text/javascript" src="src/js/jqm-datebox.mode.calbox.min.js"></script>
   <script type="text/javascript" src="src/js/jqm-datebox.mode.datebox.min.js"></script>   
<!------------- Fin --------------->
   <script type="text/javascript" src="src/js/jquery.mobile.simpledialog2.min.js"></script>	
   
 
</head> 


<body>
<?php 


?>
<!-- HEADER  -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#headerView').load("headerView.php?privilegio=<?php echo $_SESSION["usuario_gk"]->getPrivilegio();?>&idUsuario=<?php echo $_SESSION["usuario_gk"]->getidUsuario()?>&idCliente=<?php echo $_SESSION["usuario_gk"]->getidCliente();?>").fadeIn("slow");
	});
	var auto_refresh = setInterval(
		function ()
		{
			$('#headerView').load("headerView.php?privilegio=<?php echo $_SESSION["usuario_gk"]->getPrivilegio();?>&idUsuario=<?php echo $_SESSION["usuario_gk"]->getidUsuario()?>&idCliente=<?php echo $_SESSION["usuario_gk"]->getidCliente();?>").fadeIn("slow");
		}, 10000); // refresh every 10000 milliseconds
</script>

		<?php 
			$cliente = controlCliente::getCliente($_SESSION["usuario_gk"]->getidCliente());
		?>
			
		
	<div class="gk-header">
	
	
		<div class="titular">
         	<a href="index.php" rel="external"><img src="src/img/gk-logo.png" width="143" height="40"></a>
        	 <!-- <h4 style="text-align:left"></h4> -->
      	</div>
      	<div class="gk-menu">  
      		<ul id="menu">
	      		<li class="menu_right principal imagen">
	      		 	<a href="#">
			     		<?php 
			     		if (file_exists('src/img/usuarios/'.$_SESSION["usuario_gk"]->getidUsuario().'.jpg'))
						{
						?>
							<img src="src/img/usuarios/<?php echo $_SESSION["usuario_gk"]->getidUsuario()?>.jpg" alt="Avatar" height="100" width="100">
						<?php 
						}
						else 
						{
						?>
							<img src="src/img/avatar.jpg" alt="Avatar" height="100" width="100">
						<?php 
						}
						?>
		        	</a>
		        	<div class="dropdown_1column align_right_final">
		        		<div class="col_1">
	                        <h3><?php if(count($cliente)==1){echo $cliente->getnombreEmpresa();}else{echo " ";}?></h3>
	                        <p><strong><?php echo $_SESSION["usuario_gk"]->getuserFullName();?></strong></p>
		        		</div>
		        		<div class="col_1">
		        			<ul class="greybox">
		                          <li><a href="#mi-perfil" class="botonVistaUsuario">Configuracion</a></li>
		                    </ul>
		                    <?php if ($_SESSION["usuario_gk"]->getPrivilegio()>3){?>
		
		                    <ul class="greybox">
		                    	<li><a href="#Administrar-perfiles" class="botonVistaUsuario">Agregar Usuario</a></li>
		                    </ul>
		
		                   <ul class="greybox">
		                   		<li><a href="#editar-usuario-cliente" class="botonVistaUsuario">Editar Usuarios</a></li>
		                   </ul>
		                   <?php if ($_SESSION["usuario_gk"]->getPrivilegio()>=5){?>
		                   <ul class="greybox">
		                       <li><a href="#Panel-de-control" class="botonVistaPanelControl">Panel de Control</a></li>
		                   </ul>
		                   <?php  }}?> 
		                   <ul class="greybox">
	                          <li><a href="login.php" rel="external">Salir</a></li>
	                        </ul>   
		                    
		        		</div>
		        	</div>
		        </li>
		       	<div id="headerView"></div>
	        </ul>
		</div>
	</div>
<!-- FIN HEADER  -->
<script>
// Invocadores del contenido de las vistas
	
	$(document).ready(function () {

		  var ur = window.location.href;
		  
		  if(ur.indexOf("#")>0)
		  {
			  ur=ur.split("#");
			  ur=ur[1];
			 //alert(ur.indexOf("validar"));
			 if(ur.indexOf("validar")>=0||ur.indexOf("modificar")>=0||ur.indexOf("verificar")>=0)
			 {
			  atributo1="content-"+ur; 
			  $('#'+atributo1).load('cargadorVistasVerVal.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 
			 else if(ur.indexOf("Panel")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasPanelControl.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 else if(ur.indexOf("piso")>=0||ur.indexOf("estacionamiento")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasEdificio.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 else if(ur.indexOf("tarjeta")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasTarjetas.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 else if(ur.indexOf("usuario")>=0||ur.indexOf("perfil")>=0)
			 {
				 //alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasUsuario.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 else if(ur.indexOf("cliente")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasCliente.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
		 			});
			 }
			 else if(ur.indexOf("mensaje")>=0||ur.indexOf("bandeja")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					});
			 }
			 else if(ur.indexOf("proveedor")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasProveedor.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					});
			 }
			 else if(ur.indexOf("visita")>=0)
			 {
				// alert(ur);
				 atributo1="content-"+ur; 
					
				 $('#'+atributo1).load('cargadorVistasVisitas.php?do='+atributo1+'',function(){
					 $('#'+atributo1).trigger('create');
					});
			 }
			 
		  }
        
		 $(".botonVistaVal").bind('tap',function (){ //EVENTO TAP QUE FUNCIONA EN TABLET
				 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasVerVal.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate'); //CREACION DE LA PAGINA QUE CARGA ESTILOS EN TABLET
	 			});
			 
		 });
		 /*$(".botonVistaMensaje").click(function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('create');
				});
				 
		 });*/
		$(".botonVistaPanelControl").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasPanelControl.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		$(".botonVistaEdificio").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasEdificio.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		$(".botonVistaTarjeta").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasTarjetas.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		$(".botonVistaCliente").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasCliente.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		$(".botonVistaUsuario").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasUsuario.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		 $(".botonVistaProveedor").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasProveedor.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });

		 $(".botonVistaVisitas").bind('tap',function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasVisitas.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('pagecreate');
	 			});
			 
		 });
		
			 
	});
// Fin invocadores del contenido de las vistas	 
</script>

<?php 
/*
 * 
 * ###############    CARGA MENU #########################3
 * 
 */
?>
	
<div data-role="page" id="inicio">
	<?php 
		menuView::getMenu($_SESSION["usuario_gk"]);
		//print_r($_SESSION["usuario_gk"]);
		//die();
	?>
	<?php 
/*
 * 
 * ###############  FIN CARGA MENU #########################3
 * 
 */
?>

	<div id="nueva-visita"></div>

</body>
<script>
	$(document).ready(function(){

		$(".editarReserva").click(function(){

			var titulo = $(this).attr("title");
			var arrD = titulo.split("&");
			//alert(arrD);
			var datos;
					
				 $('#editarReservaVisita').load('cargaVisitaReserva.php?idCliente='+arrD[1]+'&idVisitaEdir='+arrD[0],function(){
				 $('#editarReservaVisita').trigger('create');
		 			});
		 	});
		
		});
</script>
<!-- -AQUI VA  EL CONTROL DE EDITAR RESERVA DE VISITAS -->

<script>
$(document).ready(function(){
	$("#EditaGuardaVisitaDatP").click(function(){

			var datos = $("#editarVisitaDatosPer").serialize();

			$.ajax({
		  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
		  		   url: "capturaDataVisiYreservafe.php",   //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
		  		   data: datos, //Variable que transferira los datos
		  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
		  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
		  		     						 //Mostrar mensaje que se esta procesando el script
		  		   },
		  		   dataType: "html",
		  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

		  			   //alert(datos);
		  			   switch(datos)
		  			   {
		  				   	case "1":

									//alert("update ok"); 	//falta preparar las salidas avisando que todo se realizo exitosamente
									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong> Los cambios se afectuaron exitosamente</strong></p>"+
						    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	  			   			
			  				   	break;
		  				   	case "3":
									//alert("se actualizo los datos menos el rut ya que no es valido");
									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Se efectuaron cambios</strong></p>"+
						    			  "<p class='centrado'><strong>El cambio de rut no se efectuo ya que no es valido</strong></p>"+
						    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	  			   			
			  				   	break;
			  				   	
		  				   	case "-1":
			  				   	
									//alert("no se updateo"); 	// falta preparar la salida 
									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Se efectuaron los cambios</strong></p>"+
						    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	  			   			
									
		  			   			break;  	
			  		   }
		  			   		  			 /*var arr = datos.split("&");
		          //alert(arr);
		          
		          if(arr.length>0)
		          {
		             //alert(arr[0]); 
		             $("#enombre").val(arr[0]);
		             $("#eapellido").val(arr[1]);
		             $("#erut").val(arr[2]);
		             $("#epasaporte").val(arr[3]);
		             $("#examinar").val(arr[4]);
		             $("#ecorreo").val(arr[5]);
		          }*/
		  			   

		  		   }
		  		 });
		  		return false;
			//alert("GuardaEdit");
		});
		
});
</script>
<script>
$('#enable').click(function(){
    $('#agendar').removeClass('ui-disabled');
    clicked = false; 
});
</script>

<script>
$('#enable2').click(function() {
    $('#agendar2').removeClass('ui-disabled');
    clicked = false; 
});
</script>
<script>
$(document).ready(function(){
	
	$("#GuardarDatVisita").click(function (){
	   var datos = $("#ingresoDatosVisita").serialize();//Serializamos los datos a enviar
	   	//alert(datos);
	   var arr = datos.split("=");
	   //alert(arr);
	   //id = arr[5].split("=");
	   var rvi= arr[3].split("&"); 
	   var pasvi = arr[4].split("&");
	   //alert(rvi[0]+"_"+pasvi[0]);
	   //alert(arr[7]);
	   $.ajax({
	   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	   url: "capturaDataVisiYreservafe.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	   data: datos, //Variable que transferira los datos
	   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	     						 //Mostrar mensaje que se esta procesando el script
	   },
	   dataType: "html",
	   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

		  //alert(datos+"__"+arr[9]+"_"+rvi[0]+"__"+pasvi[0]);
		/*$('#reservaAgregaVisita').load('loadReservaDeAgregarVisita.php?id='+arr[9]+"&rvi="+rvi[0]+"&"+"pasvi="+pasvi[0],function(){
				$('#reservaAgregaVisita').trigger('create');
				});
				$('#agendar').removeClass('ui-disabled');*/
				//alert(datos);  
	   		
		  switch(datos)
	      {
	      	case "1": 
		      		
	      		 $('<div>').simpledialog2({

	      			 	mode: 'blank',
		    		    headerText: 'Ingreso de nueva visita',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
		    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
		    		      // NOTE: the use of rel="close" causes this button to close the dialog.
		    		      
		    		  });
	      			
	      			$('#reservaAgregaVisita').load('loadReservaDeAgregarVisita.php?id='+arr[9]+"&rvi="+rvi[0]+"&"+"pasvi="+pasvi[0],function(){
					$('#reservaAgregaVisita').trigger('create');
					});
					$('#agendar').removeClass('ui-disabled');
					
					
						      			
	      			
		      	break;
			case "4": 

	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Ingreso de nueva visita',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
	    			  "<p class='centrado'><strong>Sugerencia : 'No fue ingresado el correo en los datos personales de la visita, antes de agendar una reserva edite el perfil de la visita agregando el correo para que el sistema pueda generar el correo de invitacion '</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"location.replace('#editar-visitas');window.location.reload();\" rel='' data-icon='check'>Ir a Editar/Reservar</a>"+	
	    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
      			
      			/*$('#reservaAgregaVisita').load('loadReservaDeAgregarVisita.php?id='+arr[9]+"&rvi="+rvi[0]+"&"+"pasvi="+pasvi[0],function(){
				$('#reservaAgregaVisita').trigger('create');
				});
				$('#agendar').removeClass('ui-disabled');*/

		      	break;
		      	 
	      	case "5": 

	      		 $('<div>').simpledialog2({

	      			 	mode: 'blank',
		    		    headerText: 'Ingreso de nueva visita',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
		    			  "<h4 class='centrado'><strong>Estimado para realizar una reserva rapida debe ingresar el rut</strong></h4>"+
		    			  "<h4 class='centrado'><strong>En el caso que no tenga el rut, favor dirigirse a Agendar y Editar Visita</strong></h4>"+
		    			  "<p class='centrado'><strong>Sugerencia : 'No fue ingresado el correo en los datos personales de la visita, antes de agendar una reserva edite el perfil de la visita agregando el correo para que el sistema pueda generar el correo de invitacion '</strong></p>"+
		    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"location.replace('#editar-visitas');window.location.reload();\" rel='' data-icon='check'>Ir a Editar/Reservar</a>"+
		    		      "<a data-role='button' href='#'  onClick=\"window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
		    		     
		    		      
		    		  });

		      	break; 	 	      	
	      	case "3":

	      		 $('<div>').simpledialog2({

	      			 	mode: 'blank',
		    		    headerText: 'Ingreso de nueva visita',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
		    			  "<h4 class='centrado'><strong>Estimado para realizar una reserva rapida debe ingresar el rut</strong></h4>"+
		    			  "<h4 class='centrado'><strong>En el caso que no tenga el rut, favor de dirigirse a Editar Visita</strong></h4>"+
		    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"location.replace('#editar-visitas');window.location.reload();\" rel='' data-icon='check'>Ir a Editar/Reservar</a>"+
		    		      "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
		    		     
		    		      
		    		  });
	      		
		      	break;   
		      	   	
	      	case "0":
		      	
	      		$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problema',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Ingrese los campos solicitados con un *</strong></p>"+
	    			  "<h5 class='centrado'><strong>El rut debe ser sin puntos y con guion</strong></h5>"+
	    			  "<h5 class='centrado'><strong>Información: puede ser rut o pasaporte y/o ambos.</strong></h5>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Volver</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  })
	      		
		      	    break;
	      	    
	      	case "-2":
		      	
	      	$('<div>').simpledialog2({
    		    mode: 'blank',
    		    headerText: 'Problema',
    		    headerClose: true,
    		    blankContent : 
    			  "<p class='centrado'><strong>La visita que esta ingresando ya esta almacenada en el sistema</strong></p>"
    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
    		      
    		  })
      				break;
			 default:
				//alert(datos);	
				$('<div>').simpledialog2({
		    		    mode: 'blank',
		    		    headerText: 'Problema',
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
	});
	
	});
	
	 

</script>
<!-- PARTE CLIENTES! -->
<script>
$(document).ready(function(){
	$(".editarEmpresas").click(function(){
		var titulo = $(this).attr("title");
		var datos;
		$.ajax({
	  		   type: "GET", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoCliente.php?idClienteEmpresaEdit="+titulo, //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	  		   data: datos, //Variable que transferira los datos
	  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	  		     						 //Mostrar mensaje que se esta procesando el script
	  		   },
	  		   dataType: "html",
	  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
	  			// alert(datos);
	  			 //$('input[name="erut"]').val(arr[2]);	
		  		 var arr = datos.split("&");
		  		 $('input[name="idclienteEmpresa"]').val(arr[0]);
		  		 $('input[name="ClienteRut"]').val(arr[1]);
	             $('input[name="ClienteEmpresa"]').val(arr[2]);
	             $('input[name="ClienteDireccion"]').val(arr[3]);
	             //$('input[name="erut"]').val(arr[4]);
	             //$('input[name="erut"]').val(arr[5]);
	  		   }
	  		 });
		//return false;
	
	});

	$(".editarPisosEmpresa").click(function(){

		var titulo = $(this).attr("title");
		var datos;
		 $('#carga').load('loadCargaEditarPisosCliente.php?idCliente='+titulo+'&editarPisos=1',function(){
		$('#carga').trigger('create');
		});
		

		});

	$(".editarEstacionamientos").click(function(){
		var titulo = $(this).attr("title");
		
		 $('#cargaEstac').load('loadCargaEditarPisosCliente.php?idCliente='+titulo+'&editarEstac=1',function(){
		$('#cargaEstac').trigger('create');
		});
	});
	
});

</script>

<script>
$(document).ready(function(){

	$("#EditaGuardaClientesaDatP").click(function(){

		var datos = $("#editarClienteDatosPer").serialize();
		
		$.ajax({
	  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoCliente.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	  		   data: datos, //Variable que transferira los datos
	  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	  		     						 //Mostrar mensaje que se esta procesando el script
	  		   },
	  		   dataType: "html",
	  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
	  			 //alert(datos);
	  			 switch(datos)
	  	     	 {
		  	      	case "1": 
	  		      		
		  	      		 $('<div>').simpledialog2({

	  	    		  			mode: 'blank',
			  		    		  headerText: 'Edicion Cliente',
		  		    		    headerClose: true,
		  		    		    blankContent : 
	  			    			  "<p class='centrado'><strong>La edicion fue exitosa</strong></p>"+
	  			    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	  		    			      // NOTE: the use of rel="close" causes this button to close the dialog.
	  		    			      
	  		    			  });
	  	      				      			
	  		      	break;
	  		      	
		  	      	case "0":

		  	      		 $('<div>').simpledialog2({

	  		      			 	mode: 'blank',
	  			    		    headerText: 'Problemas',
	  		    			    headerClose: true,
	  		    			    blankContent : 
	  		    				  "<p class='centrado'><strong>Lo sentimos no se han ingresado todo los campos con (*) o el rut no es valido</strong></p>"+
	  		    				  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	  		    		     
	  		    		      
	  			    		  });
	  	      		
	  		    	  	break;   
		  	      	default:

		  	      	 $('<div>').simpledialog2({

		      			 	mode: 'blank',
			    		    headerText: 'Ingreso de nueva visita',
		    			    headerClose: true,
		    			    blankContent : 
		    				  "<p class='centrado'><strong>Lo sentimos no se han ingresado todo los campos con (*)</strong></p>"+
		    				  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
		    		     
		    		      
			    		  });
			  	      	 	
	  	      	  }	
	  		   }
	  		 });
		return false;
		});
});
</script>
<!-- FIN CLIENTES! -->
<!-- INICIO PROVEEDORES -->
<script>
$(document).ready(function(){

	$(".editarProveedorPerfil").click(function(){

		var titulo = $(this).attr("title");

		//alert("shietEditarPerfilProveedor"+titulo);
		
		 $('#editperproveedor').load('cargaProveedorYreservaPro.php?idCliente='+titulo+'&proveedorEdirP=1',function(){
				$('#editperproveedor').trigger('create');
		 });

		});
	
	$(".editarProveedorReserva").click(function(){

		var titulo = $(this).attr("title");
		var arr = titulo.split("&");
			
		//alert(arr);
		 $('#reservaProveedor').load('cargaProveedorYreservaPro.php?idCliente='+arr[1]+'&idProveedorReserva='+arr[0],function(){
				$('#reservaProveedor').trigger('create');
		 });
		
		});
});
</script>
<!-- FIN PROVEEDORES -->
<script>
/*$(document).ready(function(){
	$("#opendialog-editar").click(function (){
		
		//var datos = $("#opendialog-editar").val();
		var titulo = $(this).attr("title");
		alert(titulo);
		//alert(document.title);
		
  		/*$.ajax({
  		   type: "get", //Establecemos como se van a enviar los datos puede POST o GET
  		   url: "validaIngresoVisita.php?id="+titulo, //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
  		   data: datos, //Variable que transferira los datos
  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
  		     						 //Mostrar mensaje que se esta procesando el script
  		   },
  		   dataType: "html",
  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
  			 alert(datos);
  		      
  		   }
  		 });
  		return false;*/
/* 	});
});
*/


 
 $(document).delegate('#opendialog-editar', 'click', function()
	{

	  	var datos = $(this).attr("title");
        var id = datos;		
        		$.ajax({
       		   type: "GET", //Establecemos como se van a enviar los datos puede POST o GET
       		   url: "editaVisitaReserva.php?nombre=1&id="+datos, //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
       		   data: datos, //Variable que transferira los datos
       		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
       		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
       		     						 //Mostrar mensaje que se esta procesando el script
       		   },
       		   dataType: "html",
       		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
       		  	arr = datos.split("\n");
       		  //alert(datos);
       		  	
          			$('<div>').simpledialog2({
           		    mode: 'blank',
           		    headerText: 'Visita',
           		    headerClose: true,
           		    blankContent : 
           		      "<p class='centrado'><img src='src/img/avatar.jpg' width='80' height='80'></p>"+
           			  "<h4 class='centrado'>"+arr[0]+"</h4>"+
           		      // NOTE: the use of rel="close" causes this button to close the dialog.
           		      "<a data-role='button' href='' onClick='prueba();' data-transition='pop' rel='close' data-icon='check'>Editar/Reservar</a>"+
           		      "<a data-role='button' href='#' data-transition='pop' data-icon='delete'>Eliminar</a>"+
           			  "<a rel='close' data-role='button' href='#' data-icon='back' data-theme='c'>Volver</a>"
           			  
           		  });
          			
          			//selcomuna
       		   }
       	
       		 });
       	
	});	
</script>
<script type="text/javascript">

/*$(document).ready(function(){

	$("#RyE").click(function()
		{
				alert("hola");
		});
	
});*/
function prueba()
	{
		alert("hola");
		$("#nueva-visita").load("test.php");
		
	}
</script>
<script>
$(document).ready(function(){
	$(".ui-btn-right").click(function (){
		
		//var datos = $("#opendialog-editar").val();
		var datos;
		//alert("hola");
		//alert(document.title);
		//alert("hola");
  		$.ajax({
  		   type: "GET", //Establecemos como se van a enviar los datos puede POST o GET
  		   url: "validaIngreLogin.php?logout=0", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
  		   data: datos, //Variable que transferira los datos
  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
  		     						 //Mostrar mensaje que se esta procesando el script
  		   },
  		   dataType: "html",
  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

  			 window.location = "login.php";
  		      
  		   }
  		 });
  		return false;
	});
});
</script>
<!-- ######################################## TERMINO CODIGO GONZALO DEVELOPER ##############################-->

<!-- ######################################## INICIO CODIGO NICO ############################################# -->

<script>
var nombre=null;
var modif=null;
var visita=null;
var id=null;
var resultado=false;
function guardaNombre(name)
{
	nombre=name;
}
function muestraNombre()
{
	return nombre;
}
function guardaId(Id)
{
	id=Id;
}
function muestraId()
{
	return id;
}
function tipoModif(modifica)
{
	modif=modifica;
}
function muestraModif()
{
	return modif;
}
function guardaBusqueda(busqueda)
{
	visita=busqueda;
}
function nombreVisita()
{
	return visita;
}


</script>


<!-- Page - Pop Up <EXITO VALIDACION> >> OK -->
<div data-role="dialog" id="popup-exito">
	<?php gestionVerificaValidaView::popUpExito();?>
</div>
<!-- /page -->

<!-- Page - Pop Up <EXITO MODIFICACION> >> OK -->
<div data-role="dialog" id="popup-modif">
	<?php gestionVerificaValidaView::popUpModif();?>
</div>
<!-- /page -->

<!-- Page - Pop Up <FRACASO VALIDACION PISTOLA> >> OK -->
<div data-role="dialog" id="popup-fracaso">
	<?php gestionVerificaValidaView::popUpFracaso();?>
</div>
<!-- /page -->

<!-- Page - Pop Up <FRACASO VALIDACION PISTOLA> >> OK -->
<div data-role="dialog" id="popup-fracaso-rut">
	<?php gestionVerificaValidaView::popUpFracasoRut();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <FRACASO VALIDACION PISTOLA> >> OK -->
<div data-role="dialog" id="popup-muchos-rut">
	<?php gestionVerificaValidaView::popUpMuchosRut();?>
</div>
<!-- /page -->

<!-- Page - Pop Up <FRACASO VALIDACION PISTOLA FRECUENTE> >> OK -->
<div data-role="dialog" id="popup-fracaso-frecuente">
	<?php gestionVerificaValidaView::popUpFracasoFrecuente();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <ERROR EN DB> >> OK -->
<div data-role="dialog" id="popup-error-db">
	<?php gestionVerificaValidaView::popUpErrorDb();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <ERROR EN DB> >> OK -->
<div data-role="dialog" id="popup-error-visita-validada">
	<?php gestionVerificaValidaView::popUpErrorVisitaValidada();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <ESTACIONAMIENTO CON PATENTE PROVEEDOR> >> OK -->
<div data-role="dialog" id="estacionamiento-proveedor">
	<?php gestionVerificaValidaView::popUpEstacionamientoProveedor();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <EXITO VALIDACION> >> OK -->
<div data-role="dialog" id="popup-exito-proveedor">
	<?php gestionVerificaValidaView::popUpExitoProveedor();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <RUT MAL INGRESADO> >>  -->
<div data-role="dialog" id="popup-rut-invalido">
	<?php gestionVerificaValidaView::popUpRutInvalido();?>
</div>
<!-- /page -->
<!-- Page - Pop Up <POPUP INGRESO CODIGO DE TARJETA> >> OK -->
<div data-role="dialog" id="pop-ingreso-tarjeta">
	<?php gestionVerificaValidaView::popUpIngresoTarjeta();?>
</div>
<!-- /page -->

<?php 
$user=$_SESSION["usuario_gk"];
$operador = null;
$operator=controlOperador::getIdOperador($user->getIdUsuario());
echo $operador;
?>
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
					
							//AQUI VA LA PREGUNTA A LA CONFIGURACION!--
							
							//---------------------------------------
		
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
							});
						} //AQUI VA EL MENSAJE DE RUT NO VALIDO!!!!
						else 
						{
							$.mobile.changePage($('#popup-rut-invalido'),'pop',false,true);
							setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
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
									

										break;
										case "2":
											document.getElementById("msgFracasoFrecuente").innerHTML= "<h1 class=\"centrado\">Proveedor: <br>"+rutProv+"-"+dvProv+"<br>"+nombreProveedor+"</h1>";
											$.mobile.changePage($('#popup-fracaso-frecuente'),'pop',false,true);
											setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();;},'1500');
										break;
										case "3":
											document.getElementById("msgErrorVisitaValidada").innerHTML= "<h1 class=\"centrado\">Proveedor: <br>"+rutProv+"-"+dvProv+"<br>"+nombreProveedor+"</h1>";
											$.mobile.changePage($('#popup-error-visita-validada'),'pop',false,true);
											setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1500');
										break;
										case "0":
											$.mobile.changePage($('#popup-error-db'),'pop',false,true);
											setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
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

<script>

function activaExito(){
	if (muestraNombre()!=null)document.getElementById("msgExito").innerHTML= "<h1 class=\"centrado\">"+muestraNombre()+"</h1>";
	else
		{ 
		$.get("getNombreVisitaPorId.php",{'id':muestraId()},function(data){
			document.getElementById("msgExito").innerHTML= "<h1 class=\"centrado\">"+data+"</h1>";
			
		});
		
		}
}


function activaFracaso()
{
	document.getElementById("msgFracaso").innerHTML= "<h1 class=\"centrado\">"+nombreVisita()+"</h1>";
}

function activaModifica()
{
	document.getElementById("msgModifica").innerHTML= "<h1 class=\"centrado\">"+muestraNombre()+"</h1>";
}

//###################################3 VALIDACION DE VISITAS ######################################################

var operador="<?php echo $operator;?>";
function validaVisita(id){
	// Aqui deberia ir el identificador del operador para el seguimiento de la visita
		
	//-------------------------------------------------------------------------------
		guardaId(id);
		
		$.get("validaVisita.php",{'id':muestraId(),'op':operador,'rut':rutPistola,'dv':dvPistola},function(datos){
			//alert(data);
			datos=datos.split("&");
			piezas=datos[0].split("%");
			idReserva=piezas[0];
			idOperador=piezas[1];
			datos=datos[1];
			switch(datos)
			{
			
				case "1"://AQUI VA LA PREGUNTA A LA CONFIGURACION!--
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
										activaExito();
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
					
					break;

				case "0":
					$.mobile.changePage($('#popup-error-db'),'pop',false,true);
					setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'2500');
					break;

				case "-1":
					$.mobile.changePage($('#estacionamiento-proveedor'),'pop',false,true);
					//Patente y estacionamientos habilitados
					$.get("getPatEst.php",{'id':muestraId(),'pat':"1"},function(data){
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
						//alert(estaciEstado);
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
							$("#est"+i).checkboxradio("refresh");
							
				            						
							
						}
						});
					break;
				case "-2":
					$.mobile.changePage($('#estacionamiento-proveedor'),'pop',false,true);
					//Patente y estacionamientos habilitados
					$.get("getPatEst.php",{'id':muestraId(),'pat':"0"},function(data){

						$("#opEstProv").val(operador);
						var datosRecibido= data.split("+");
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
		    		activaFracaso();
					$.mobile.changePage($('#popup-fracaso'),'pop',false,true);
					setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'5000');  
					
			}
			return false;
		});
		
	}

$("#envia-validacion-proveedor").click(function(){
	//alert("hola");
	 //var datos = $("#edicion-operador-popup").serialize();//Serializamos los datos a enviar
	// alert(datos);
	$.get("validaProveedorAuto.php", $("#validacion-operador-popup").serialize(),function(datos){
		datos=datos.split("&");
		piezas=datos[0].split("%");
		idReserva=piezas[0];
		idOperador=piezas[1];
		datos=datos[1];
		if(jQuery.inArray("+",datos) > -1)
		{ 
			datos=datos.split("+");
		
			nombreProv=datos[0];
			datos=datos[1];
		}
		switch(datos)
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
									document.getElementById("msgExitoProveedor").innerHTML= "<h1 class=\"centrado\">Proveedor "+nombreProv+"</h1>";	 
						      		$.mobile.changePage($('#popup-exito-proveedor'),'pop',false,true);
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
	      		
				break;
			      	
	      	case "0":
		      	
	      		$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problema',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Ingrese todos los campos solicitados</strong></p>"+
	    			  "<p class='centrado'><strong>Ingrese una patente valida.</strong></p>"+
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
	    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
	    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  })
	      				break;
	      	case "-2":
	      	$('<div>').simpledialog2({
    		    mode: 'blank',
    		    headerText: 'Problema',
    		    headerClose: true,
    		    blankContent : 
    			  "<p class='centrado'><strong>No existen estacionamientos disponibles o no selecciono algun estacionamiento disponible</strong></p>"+
    			  "<p class='centrado'><strong>Si esto no es asi, contactese con el administrador</strong></p>"+
    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
    		      
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
		    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
		    		      
		    		      // NOTE: the use of rel="close" causes this button to close the dialog.
		    		      
		    		  })
	    		 
		      	 	
	      
		  }
		
		});
	});

//###################################3 VALIDACION DE VISITAS ######################################################

$("#envia-ingreso-tarjeta").click(function(){
	$.get("validadorVisitasGeneral.php", $("#validacion-tarjeta-popup").serialize(),function(datos){
		switch (datos)
		{
			case "1": 
					$.mobile.changePage($('#popup-exito'),'pop',false,true);
					setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1000');
					break;
			case "0":
		      	
	      		$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problema',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Error en SQL, comuniquese con administracion</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
	    			  
	    			  
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  })
	      		
		      	    break;
	      	
	      	
	      	case "-1":
		      	$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problema',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Tarjeta Ocupada</strong></p>"+
	    			  "<p class='centrado'><strong>Utilice otra tarjeta, si esto no es correcto, contactese con administracion</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
	    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  })
	      				break;
	      	case "-2":
	      	$('<div>').simpledialog2({
    		    mode: 'blank',
    		    headerText: 'Problema',
    		    headerClose: true,
    		    blankContent : 
    			  "<p class='centrado'><strong>No existe la tarjeta seleccionada</strong></p>"+
    			  "<p class='centrado'><strong>Si esto no es asi, contactese con el administrador</strong></p>"+
    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
    		      
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
			    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
			    		      
			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  })
		}
		
		});

});

function modificaVisita(id){
	 guardaId(id);
	 mod = muestraModif();
	 $.get("modificaVisita.php",{'id':muestraId(),'opc':mod},function(datos){
		//alert(datos);
		if (datos=='1')
		{
			activaModifica();
			$.mobile.changePage($('#popup-modif'),'pop',false,true);
			setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'1000');
		}
		else
		{
			activaFracaso();
			$.mobile.changePage($('#popup-fracaso'),'pop',false,true);
			setTimeout(function(){url = window.location.href;url=url.split("&");window.location.replace(url[0]);window.location.reload();},'5000');
			
		}
		
		return null;
	 });
}
</script>



<script>
$(document).delegate('#opendialog-editar-empresa', 'click', function() {
  // NOTE: The selector can be whatever you like, so long as it is an HTML element.
  //       If you prefer, it can be a member of the current page, or an anonymous div
  //       like shown.
  var name = $(this).attr("name");
  var id= $(this).attr("title");
  guardaNombre(name);
  
  $('<div>').simpledialog2({
    mode: 'blank',
    headerText: 'Editar',
    headerClose: true,
    blankContent : 
	  "<p class='centrado'><img src='src/img/avatar.jpg' width='120' height='120'></p>"+
      "<h4 class='centrado'>"+name+"</h4>"+
      // NOTE: the use of rel="close" causes this button to close the dialog.
      "<a rel='close' data-role='button' data-rel='dialog' href='#' data-transition='pop' data-icon='check'>Editar</a>"+
	  "<a rel='close' data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-icon='back' data-theme='c'>Volver</a>"
	})
  
})
</script>

<script>
$(document).delegate('#opendialog-validar-peaton,#opendialog-validar-vehiculo', 'click', function() {
  // NOTE: The selector can be whatever you like, so long as it is an HTML element.
  //       If you prefer, it can be a member of the current page, or an anonymous div
  //       like shown.
  var name = $(this).attr("name");
  var id= $(this).attr("title");
  guardaNombre(name);
  
  $('<div>').simpledialog2({
    mode: 'blank',
    headerText: 'Validar',
    headerClose: true,
    blankContent : 
	  "<p class='centrado'><img src='src/img/avatar.jpg' width='120' height='120'></p>"+
      "<h4 class='centrado'>"+name+"</h4>"+
      // NOTE: the use of rel="close" causes this button to close the dialog.
      "<a rel='close' data-role='button' data-rel='dialog' href='#' data-transition='pop' data-icon='check' onclick=validaVisita("+id+");>Validar</a>"+
	  "<a rel='close' data-role='button' href='#' data-icon='back' data-theme='c'>Volver</a>"
	})
  
})
</script>

<script>
$(document).delegate('#opendialog-modificar', 'click', function() {
  // NOTE: The selector can be whatever you like, so long as it is an HTML element.
  //       If you prefer, it can be a member of the current page, or an anonymous div
  //       like shown.
  var name = $(this).attr("name");
  var id= $(this).attr("title");
  guardaNombre(name);

  $('<div>').simpledialog2({
    mode: 'blank',
    headerText: 'Confirmar',
    headerClose: true,
    blankContent : 
	  "<p class='centrado'><img src='src/img/avatar.jpg' width='120' height='120'></p>"+
      "<h4 class='centrado'>"+name+"</h4>"+
      // NOTE: the use of rel="close" causes this button to close the dialog.
      "<a rel='close' data-role='button' data-rel='dialog' href='#popup-modificar' data-transition='pop' name='1' onClick='tipoModif(1);modificaVisita("+id+");' data-icon='plus' data-theme='c'>Reservar</a>"+
      "<a rel='close' data-role='button' data-rel='dialog' href='#popup-modificar' data-transition='pop' name='2' onClick='tipoModif(2);modificaVisita("+id+");' data-icon='delete' data-theme='c'>Cancelar</a>"+
      "<a rel='close' data-role='button' data-rel='dialog' href='#popup-modificar' data-transition='pop' name='3' onClick='tipoModif(3);modificaVisita("+id+");' data-icon='minus' data-theme='c'>Terminar</a>"+
	  "<a rel='close' data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-icon='back' data-theme='c'>Volver</a>"
	})
  
})
</script>

<script>
//################-----SCRIPT DE ALERTA DE NO RESULTADOS-----##################################
$(document).delegate('[data-role="page"]', 'pageinit', function () {
    var $listview = $(this).find('[data-role="listview"]');
    
    $(this).delegate('input[data-type="search"]', 'keyup', function () {
         
    	if ($listview.children(':visible').not('.no-results').length == 2) {
        	resultado=true;
        
        	}
    	else resultado=false;
        if ($listview.children(':visible').not('.no-results').length == 0) {
            $('.no-results').fadeIn(500);
            
        } else {
            $('.no-results').fadeOut(250);
        }
        
    });
});

</script>

<script>
//###############-------FILTROS BUSQUEDA-----##################################

var pisoPeaton = 0;
$('#fechaActual-peaton').bind('click',function(e){  
    
    if($(this).is(':checked'))
        { 
        if (pisoPeaton!=0)
        $('#validacionPeaton').load("resultadoBusquedaPeaton.php?hoy=1&piso="+pisoPeaton+"",function(){
                $('#validacionPeaton').trigger('create')});
        else
        	$('#validacionPeaton').load("resultadoBusquedaPeaton.php?hoy=1",function(){
                $('#validacionPeaton').trigger('create')}); 
        }
    else
        { 
        if (pisoPeaton!=0)
        $('#validacionPeaton').load("resultadoBusquedaPeaton.php?piso="+pisoPeaton+"",function(){
                    $('#validacionPeaton').trigger('create')});
        else
        	$('#validacionPeaton').load('resultadoBusquedaPeaton.php',function(){
                $('#validacionPeaton').trigger('create')}); 
        }
    
});

function filtroPisoPeaton(piso)
{
	var value = piso.options[piso.selectedIndex].value; 
	if (value!="todos")
		{
		if($('#fechaActual-peaton').is(':checked'))
			$('#validacionPeaton').load("resultadoBusquedaPeaton.php?hoy=1&piso="+value+"",function(){
                $('#validacionPeaton').trigger('create')});
		else $('#validacionPeaton').load("resultadoBusquedaPeaton.php?piso="+value+"",function(){
			$('#validacionPeaton').trigger('create')});
		pisoPeaton= value;
	    }
	else
		{ 
		if($('#fechaActual-peaton').is(':checked'))
			$('#validacionPeaton').load("resultadoBusquedaPeaton.php?hoy=1",function(){
                $('#validacionPeaton').trigger('create')});
		else
		$('#validacionPeaton').load("resultadoBusquedaPeaton.php",function(){
				    $('#validacionPeaton').trigger('create')});
		pisoPeaton=0;
	    }
}


var pisoVehiculo = 0;
$('#fechaActual-vehiculo').bind('click',function(e){  
    
    if($(this).is(':checked'))
        { 
        if (pisoVehiculo!=0)
        $('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?hoy=1&piso="+pisoVehiculo+"",function(){
                $('#validacionVehiculo').trigger('create')});
        else
        	$('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?hoy=1",function(){
                $('#validacionVehiculo').trigger('create')}); 
        }
    else
        { 
        if (pisoVehiculo!=0)
        $('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?piso="+pisoVehiculo+"",function(){
                    $('#validacionVehiculo').trigger('create')});
        else
        	$('#validacionVehiculo').load('resultadoBusquedaVehiculo.php',function(){
                $('#validacionVehiculo').trigger('create')}); 
        }
    
});

function filtroPisoVehiculo(piso)
{
	var value = piso.options[piso.selectedIndex].value; 
	if (value!="todos")
		{
		if($('#fechaActual-vehiculo').is(':checked'))
			$('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?hoy=1&piso="+value+"",function(){
                $('#validacionVehiculo').trigger('create')});
		else $('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?piso="+value+"",function(){
			$('#validacionVehiculo').trigger('create')});
		pisoVehiculo= value;
	    }
	else
		{ 
		if($('#fechaActual-vehiculo').is(':checked'))
			$('#validacionVehiculo').load("resultadoBusquedaVehiculo.php?hoy=1",function(){
                $('#validacionVehiculo').trigger('create')});
		else
		$('#validacionVehiculo').load("resultadoBusquedaVehiculo.php",function(){
				    $('#validacionVehiculo').trigger('create')});
		pisoVehiculo=0;
	    }
}

//######################################--------FIN FILTROS BUSQUEDA------#######################################
//######################################----------- FILTROS GLOBAL--------#######################################//
var pisoGlobal = 0;
var transGlobal = 0;
var empGlobal=0;

$('#fechaActual-global').bind('click',function(e){  
    
    if ($(this).is(':checked'))
	{ 
        if (pisoGlobal!=0)
        {
        	if($('#frecuente-global').is(':checked'))
            {
        		if (transGlobal!=0)
            		{
            			if (empGlobal!=0)
                		{
                			if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                			else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    			
                		}
            			else
                		{  
            				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                		}
        			}
        		else
            		{
        				if (empGlobal!=0)
            			{
            				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
        				else 
            			{
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
            		}
        	}
        	else            	
            {
        		if (transGlobal!=0)
        			{
        				if (empGlobal!=0)
            			{	
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                		}
        				else
            			{ 
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
            		}
        		else
            		{
    					if (empGlobal!=0) 
        				{
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
        				else 
            			{
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                		}
            		}
        	}
        }
        else
        {
        	if ($('#frecuente-global').is(':checked'))
            	{
            	if (transGlobal!=0)
        			{
        				if (empGlobal!=0)
            			{
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
        				else
            			{ 
        					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
    				}
    			else
        			{
    					if (empGlobal!=0)
        				{
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
    					else
        				{ 
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            			}
        			}
            	        			
            	}
        	else
        	{
        		if (transGlobal!=0)
        		{
        			if (empGlobal!=0) 
            		{
        				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            		}
        			else 
            		{
                		if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                		else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        			}
            	}
        		else
            	{
        			if (empGlobal!=0) 
            		{
                		if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                		else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
            		}
        			else
            		{ 
                		if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1",function(){$('#validacionGlobal').trigger('create')});
                		else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                	}
            	}
        	} 
        }
    }
    
    else
        { 
        	if (pisoGlobal!=0)
        	{
            	if($('#frecuente-global').is(':checked'))
                	{
            		if (transGlobal!=0)
                		{
                			if (empGlobal!=0)
                    		{
                    			if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                    			else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    		}
                			else 
                    		{	
                				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    		}
            			}
            		else
                		{
            				if (empGlobal!=0)
                			{
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    		}
            				else
                			{ 
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    		}
                		}
            		}
            	else            	
                {
            		if (transGlobal!=0)
            			{
            				if (empGlobal!=0)
                			{
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
            				else
                			{ 
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
                		}
            		else
                		{
            				if (empGlobal!=0)
               				{ 
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                   			}
            				else
                			{ 
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
                		}
            	}
        	}
        	else
        	{
            	if($('#frecuente-global').is(':checked'))
                {
                	if (transGlobal!=0)
            			{
            				if (empGlobal!=0)
                			{
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    		}
            				else
                			{ 
            					if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            					else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
        				}
        			else
            			{
        					if (empGlobal!=0)
            				{
        						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
        						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
        					else
            				{ 
        						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1",function(){$('#validacionGlobal').trigger('create')});
        						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                			}
            			}
                	        			
                }
            	else
            	{
            		if (transGlobal!=0)
            		{
            			if (empGlobal!=0)
                		{
            				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    	}
            			else
                		{ 
                    		if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
                    		else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                    	}
                	}
            		else
                	{
            			if (empGlobal!=0)
                		{ 
            				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
                		}
            			else
               			{ 
                   			if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php",function(){$('#validacionGlobal').trigger('create')});
                   			else $('#validacionGlobal').load("resultadoBusquedaGlobal.php&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
               			}
                	}
            	} 
       		}
       }
    
});

function filtroPisoGlobal(piso)
{
	var valuePiso = piso.options[piso.selectedIndex].value; 
	if (valuePiso!="todos")
		{
		pisoGlobal= valuePiso;
		if ($('#fechaActual-global').is(':checked'))
			{
				if($('#frecuente-global').is(':checked'))
    			{
					if (transGlobal!=0)
    				{
    					if (empGlobal!=0)
        				{
            				if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
            				else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
    					else
        				{ 
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
					}
					else
    				{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
    				}
				}
				else
				{
					if (transGlobal!=0)
    				{
    					if (empGlobal!=0)
        				{
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
    					else
        				{ 
    						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
    						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
        				}
					}
					else
    				{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
    				}
				}
			}
		else            	
    		{
    			if($('#frecuente-global').is(':checked'))
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
				else
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
			}
		
		}
				
	else
		{ 
			if($('#fechaActual-global').is(':checked'))
			{
				if($('#frecuente-global').is(':checked'))
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
				else
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
			}
			else            	
			{
				if($('#frecuente-global').is(':checked'))
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else 
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
				else
				{
					if (transGlobal!=0)
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else 
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
					else
					{
						if (empGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
			}
		pisoGlobal= 0;
	    }
}

function frecuenteGlobal()
{  
    
    if($('#frecuente-global').is(':checked'))
        { 
        if (pisoGlobal!=0)
            {
        	if($('#fechaActual-global').is(':checked'))
            	{
            		if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else 
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
					else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
				}
        	else
        		{
            		if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
					else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
                }
            }
        else
        	{
        	if($('#fechaActual-global').is(':checked'))
        		{
        			if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
					else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
        		}
        	else
            	{
        			if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
					else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
        		}
        	}
        }
    else
        { 
    	if (pisoGlobal!=0)
        		{
    				if($('#fechaActual-global').is(':checked'))
        			{
        				if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else 
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
						else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
					}
    				else
    				{
        				if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
						else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
            		}
        		}
   		else
    		{
    			if($('#fechaActual-global').is(':checked'))
    				{
	    				if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
						else
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
    				}
    			else
        			{
    					if (transGlobal!=0)
						{
							if (empGlobal!=0)
							{
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							
							else
							{ 
								if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
						else
						{
							if (empGlobal!=0)
							{
								if(apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
							else
							{ 
								if(apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php",function(){$('#validacionGlobal').trigger('create')});
								else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
							}
						}
    				}
    		}
        }
    
}

function filtroTransporteGlobal(trans)
{
	var valueTrans = trans.options[trans.selectedIndex].value; 
	if (valueTrans!="todos")
		
	{
		transGlobal = valueTrans;
		if($('#frecuente-global').is(':checked'))
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else 
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
	    	}
			else 
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

			}
		}
		else
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

	    	}
			else 
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

			}

		}
	}
	
	else
	{
		if($('#frecuente-global').is(':checked'))
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
	    	}
			else 
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

			}
		}
		else
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

	    	}
			else 
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
		        }
				else
				{
					if (empGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}

			}

		}

		transGlobal = 0;
	}
	
}

function filtroEmpGlobal(emp)
{
	var valueEmp = emp.options[emp.selectedIndex].value; 
	if (valueEmp!="todos")
		{
		empGlobal = valueEmp;
		if($('#frecuente-global').is(':checked'))
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
	        	}
				else
				{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
	    	}
			else
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
	        	}
				else
				{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
			}
		}
		else
		{
			if (pisoGlobal!=0)
    		{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
	        	}
				else
				{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
	    	}
			else
			{
				if($('#fechaActual-global').is(':checked'))
        		{
					if (transGlobal!=0)
					{
						if (apPistola=="")$('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else 
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
	        	}
				else
				{
					if (transGlobal!=0)
					{
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
					else
					{ 
						if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?&emp="+empGlobal+"",function(){$('#validacionGlobal').trigger('create')});
						else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?&emp="+empGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
					}
				}
			}
		}
		
		
		}
	else
		{
		if($('#frecuente-global').is(':checked'))
			{
				if (pisoGlobal!=0)
    			{
					if($('#fechaActual-global').is(':checked'))
        			{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
	        		}
					else
					{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
	    		}
				else
				{
					if($('#fechaActual-global').is(':checked'))
        			{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
	        		}
					else
					{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?frecuente=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
			}
		else
			{
				if (pisoGlobal!=0)
    			{
					if($('#fechaActual-global').is(':checked'))
        			{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
	        		}
					else
					{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?piso="+pisoGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
	    		}
				else
				{
					if($('#fechaActual-global').is(':checked'))
        			{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else
						{ 
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?hoy=1&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
	        		}
					else
					{
						if (transGlobal!=0)
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?trans="+transGlobal+"&apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
						else 
						{
							if (apPistola=="") $('#validacionGlobal').load("resultadoBusquedaGlobal.php",function(){$('#validacionGlobal').trigger('create')});
							else $('#validacionGlobal').load("resultadoBusquedaGlobal.php?apellido="+apPistola+"",function(){$('#validacionGlobal').trigger('create');$("input:jqmData(type='search')").val(apPistola);$("input:jqmData(type='search')").prop('disabled', true);});
						}
					}
				}
			}
		
		empGlobal = 0;
		}
}

//######################################-----------FIN FILTROS GLOBAL--------#######################################//
</script>

<script>

$(document).ready(function(){
	
	$("#guardar-cliente").click(function (){

		   var datos = $("#ingreso-cliente").serialize();//Serializamos los datos a enviar
	   
	   $.ajax({
	   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	   url: "validaIngresoCliente.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	   data: datos, //Variable que transferira los datos
	   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	     						 //Mostrar mensaje que se esta procesando el script
	   },
	   dataType: "html",
	   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

		     //alert(datos);
	      switch(datos)
	      {
	      	case "1": 

	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>El ingreso del cliente fue exitoso</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
	      		document.getElementById("ingreso-cliente").reset();
	      		
		      	break;
	      	
	    	case "-3":

	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>No se vincularon las oficinas con el cliente</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });

		      		break;			 		
      				      	
	      	case "0":

	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>No se llenaron correctamente los campos</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
	      		      		
	    			
	      		
		      	    break;
	      	case "-2":
		      	
	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>La empresa ya esta ingresada</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
	    		  
    		 
		      		
      				break;
	      	case "-4":

	      		$('<div>').simpledialog2({

      			 	mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>No se a llenado el campo rut de empresa</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });

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
		    		  setTimeout(function(){
			      			
		    			  $.mobile.sdCurrentDialog.close();
				      		},'2000');
	    		 
		      	 	
	      
		  } 
	   }
	   })
	   return false;
	});
	
	});

</script>

<script>
//##########################----INICIO GUARDAR USUARIO--------###########################################3
$(document).ready(function(){
	$("#guardar-usuario").click(function (){
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
		    			  "<a data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
		    		      
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
	});
	
	});
//##########################----FIN GUARDAR USUARIO--------###########################################3



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
						    			  "<a data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
						    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
						    		      
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
						    			  "<a data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
				    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
						    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
						    		      
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
						    			  "<a data-role='button' href='#' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    		      
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
					    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
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
						    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url = window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
					    		 
						      	 	
					      
						  }
					
					});
			}
			
//##########################----FIN EDICION USUARIO---################################################

</script>
<!-- ##########################################  USUARIOS ##################################################################### -->
</html>

<?php	
}
?>
