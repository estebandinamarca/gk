<?php
require_once ('src/classes/visita.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlReserva.class.php');
class gestionVisitasView
{
	public function getIngresoVisita($id=null,$idCliente=null)
	{
		$visita = null;
		if($id!=null)
		{
			$visita = controlVisita::getVisitaWithId($id);
			$arrNombApe = split(" ",$visita->getnombre());
			$rut = $visita->getrut()."-".$visita->getdv();
			$pasaporte = $visita->getpasaporte();
			$foto = "ver esta foto";
			$correo = $visita->getcontacto();
				
		}
		if($idCliente!=null)
		{
			$cliente = controlCliente::getCliente($idCliente);
		}

		?>

		<h3 style="text-align: center">
			<?php 
				if(count($cliente)>0)
				{
					echo $cliente->getnombreEmpresa();
				}
				else
				{
					echo " ";
				}
			?>
		</h3>
		<h3 style="text-align: center">Inicio » Nueva Visita</h3>
		<hr>

		
		<!-- /navbar -->

		<h4>Nueva visita</h4>
		<!-- Datos personales Visita -->
		<form action="post" id="ingresoDatosVisita">
			<div data-role="collapsible" data-content-theme="c" data-theme="b" data-collapsed="false">
				<h3>Datos Personales</h3>

				<div data-role="fieldcontain">
					<label for="name"><strong class="red">*</strong> Nombre Visita:</label>
					<input type="text" name="nombre" id="name"
						value="" />
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red">*</strong> Apellido Visita:</label>
					<input type="text" name="apellido" id="name"
						value="" />
				</div>

				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> RUT (xxxxxxxx-x) :</label>
					<input type="text" name="rutDaVi" id="name"	value="" />
					<input type="text" style="display: none;" name="visitaNuevaDt" id="name"value="" />
				</div>

				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Pasaporte:</label>
					<input type="text" name="pasaporte" id="name"
						value="" />
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Teléfono:</label>
					<input type="text" name="telefono" id="name"
						value="" />
				</div>
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Empresa:</label>
					<input type="text" name="empresa" id="name"
						value="" />
				</div>
				<!--div data-role="fieldcontain">
					<label for="name">Subir Fotografía:</label>
					<button type="submit" class="ui-btn-hidden" aria-disabled="false" data-inline="true" data-mini="true">Examinar</button>
				</div-->
				<div data-role="fieldcontain">
					<label for="name">Correo electrónico:</label> <input type="text"
						name="correo" id="name"
						value="" /> 
						<input type="text" style="display: none;" name="idcliente" id="idcliente" value="<?php echo $idCliente;?>" />
				</div>
				<hr>

				<fieldset class="ui-grid-a">
					<a href="#" data-rel="dialog" data-role="button" data-theme="b"	data-inline="true" id="GuardarDatVisita">Guardar</a> 
						<a href="#"	data-rel="dialog" data-role="button" data-theme="c" rel="back" onClick="location.replace('index.php');"	data-inline="true">Volver</a> <!-- window.location.reload('index.php'); -->
				</fieldset>
			</div>
		</form>
		<!-- Fin Datos personales Visita -->
		<!--######################### Inicio Visita frecuente peatonal -->
		<div data-role="collapsible" data-content-theme="b" id="agendar"class="ui-disabled" data-theme="b" data-collapsed="false"> <!-- ui-disabled -->
			<!-- para desactivar el none -->
			<h3>Reserva rapida </h3>
			<div data-role="collapsible-set" id="reservaAgregaVisita">
			
			</div>

		</div>
		<!-- fin solo te visita frecuente y esporadica -->
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
					$('#reservaAgregaVisita').trigger('pagecreate');
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
		    		      "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
		    		     
		    		      
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
		    		      "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
		    		     
		    		      
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" data-transition='pop' rel='back' data-icon='check'>Volver</a>"
	    		      
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
	
<!-- /page -->

<!-- /page -->
<?php 

	}
	public function getReservaDeAgregaVisita($idCliente,$rutvi=null,$pasaporte=null)
	{
		//controlgetlastVisitaAssCliente
		//echo "hola".$idCliente;
		//die("asdasd");
		if($rutvi==null)
		{
			$rutvi = "";
		}
		if($pasaporte==null)
		{
			$pasaporte = "";
		}
		?>
<!-- Div donde se montara el contenido de la reserva  <div data-role="collapsible-set" > -->

		
		
  <div data-role="collapsible" id="frecuenteV" data-content-theme="c" data-theme="d" data-collapsed="false"> 

		<h3>Reservar</h3>
		<hr> 
		<form id="VisiFrecuente" name="frecuente" action="post">
		
	  	<div class="radio-responsivo">
				<fieldset data-role="controlgroup" data-type="horizontal" data-ajax="true" class="row-b">
		    	 	<input type="radio" name="radioPV" id="radio-peaton" value="peatonal" />
    			 	<label for="radio-peaton">Peatonal</label>
		    	 	<input type="radio" name="radioPV" id="radio-vehicular" value="vehicular"/>
	    	 		<label for="radio-vehicular">Vehicular</label>
				</fieldset>
		</div>
		
		
		
		<div data-role="fieldcontain" id="radios">
		
    		<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
    			<legend>Tipo reserva:</legend>
	        	<input type="radio" name="radioOpcion" id="radio-cliente" value="Frecuente" onClick="opcionesReserva('F');" />
        		<label for="radio-cliente">Frecuente</label>
				<input type="radio" name="radioOpcion" id="radio-operador" value="solo" onClick="opcionesReserva('S');" />
	         	<label for="radio-operador">Solo una vez</label>
			</fieldset>
			
		</div>
		
			<h3 style="display:none;" id="titulo">Entrada</h3>

			<div data-role="fieldcontain" id="aplicarDias" style="display: none;">
				<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
					<legend>
						<strong class="red">*</strong> Aplicar los dias:
					</legend>
					<input type="checkbox" name="lunes" id="checkbox-1" class="custom" />
					<label for="checkbox-1">Lun</label> <input type="checkbox"
					name="martes" id="checkbox-2" class="custom" /> <label
					for="checkbox-2">Mar</label> <input type="checkbox"
					name="miercoles" id="checkbox-3" class="custom" /> <label
					for="checkbox-3">Mie</label> <input type="checkbox" name="jueves"
					id="checkbox-4" class="custom" /> <label for="checkbox-4">Jue</label>
					<input type="checkbox" name="viernes" id="checkbox-5" class="custom" />
					<label for="checkbox-5">Vie</label> <input type="checkbox"
					name="sabado" id="checkbox-6" class="custom" /> <label
					for="checkbox-6">Sab</label> <input type="checkbox" name="domingo"
					id="checkbox-7" class="custom" /> <label for="checkbox-7">Dom</label>
				</fieldset>
			</div>
		
		<!-- 
		    <div data-role="fieldcontain">
				<label for="hora">*Hora:</label>
				<input name="hora" id="hora" type="date" data-role="datebox"  data-options='{"mode": "timebox", "overrideTimeFormat": 24}'>
			</div>
		-->			
									
			<div data-role="fieldcontain" id="fechaEspo" style="display: none;">
				<label for="mydate"><strong class="red">*</strong> Fecha</label> 
				<input	name="fechaEntrada" id="fechaEntrada" type="date" data-role="datebox" data-options='{"mode": "calbox"}'>
			</div>
			
			<div data-role="fieldcontain" id="hEstimada" style="display: none;">
				<label for="hora"><strong class="red">*</strong> Hora Estimada de Ingreso:</label> 
				<input name="horaEstimadaRR" id="hora" type="text" data-role="datebox" data-options='{"mode": "timebox", "overrideTimeFormat": 24}'> 
								
				<input	type="text" style="display: none;" name="idcliente" id="idcliente"	value="<?php echo $idCliente;?>" /> 
				<input type="text"	style="display: none;" name="rutvi" id="rutvi" value="<?php echo $rutvi;?>"/>
				<input type="text"	style="display: none;" name="pasaporvi" id="pasaporvi" value="<?php echo $pasaporte;?>"/>
			</div>
			
			<div  data-role="fieldcontain" id="fechaInicio" style="display: none;">
				<label for="mydate"><strong class="red">*</strong>Fecha Inicio:</label> 
				<input	name="fechaInicio" id="mydate" type="date" data-role="datebox"	data-options='{"mode": "calbox"}'>
			</div>
			
			<div  data-role="fieldcontain" id="fechaTermino" style="display: none;">
				<label for="mydate"><strong class="red">*</strong>Fecha Termino:</label> 
				<input	name="fechaTermino" id="mydate" type="date" data-role="datebox"	data-options='{"mode": "calbox"}'>
			</div>
			
			<div data-role="fieldcontain" id="pisoReserva" style="display: none;">
				<label for="select-choice-a" class="select ui-select">Piso:</label> 
				<select name="PisoR" id="PisoR" data-native-menu="false" tabindex="-1">
				
				<option value="0">Selecione</option>
				<?php 
				//die($idCliente);
				$detalleClientesPiso = controlCliente::getDetalleCliente($idCliente,1,null);
				if($detalleClientesPiso!=null && count($detalleClientesPiso)>0)
				{
					foreach($detalleClientesPiso as $piso)
					{
				?>
					<option value="<?php echo $piso->getpiso();?>"><?php echo $piso->getpiso(); ?></option>
				<?php 
					}
				}
				?>	
				</select>
			</div>

			<div data-role="fieldcontain" id="oficinaReserva" style="display: none;"><!-- OficinaRFirstf -->
				<label for="name">Oficina:</label>
				 <select name="OficinaR" id="name" data-native-menu="false" tabindex="-1">
				  <option value="0">Seleccione Piso Primero..</option>
				  <?php 
						$dataOficinas = controlCliente::getDetalleCliente($idCliente);
						if(count($dataOficinas)>0)
						{
							foreach ($dataOficinas as $ofi)
							{
				  ?>
				  			<option value="<?php echo $ofi->getoficina();?>"><?php echo $ofi->getoficina();?></option>
				  <?php
							}			  
						}
				  ?>
				 </select>
				 
			</div>
			
			<div data-role="fieldcontain" class="auto" style="display:none;">
				<label for="name">Patente Automóvil:</label> 
				<input type="text"	name="patenteR" id="patenteR" value=""/>
			</div>

			<div data-role="fieldcontain" class="estacionamiento" style="display:none;">
			
				<label for="select-choice-a" class="select ui-select"><strong class="red">*</strong> Estacionamiento:</label> 
				       
				        <select	name="estacionamientosR" id="estacionamientosR"	data-native-menu="false" tabindex="-1">
								<option value="0">Seleccione..</option>
							<?php 
									$dataEstacionamiento = controlCliente::getestacionamieto($idCliente,null,null);
									if(count($dataEstacionamiento)>0)
									{
										foreach ($dataEstacionamiento as $est)
										{
				 			 ?>
				  				<option value="<?php echo $est->getnumero();?>"><?php echo $est->getnumero();?></option>
				  			<?php
										}			  
									}
				 			 ?>
						</select>
			</div>
		
			<hr>
			<a href="#" class="ui-disabled" data-rel="dialog" data-role="button" data-theme="b"	data-inline="true"  id="GuardarVF">Guardar</a>
			 <a href="#" class="ui-disabled" data-rel="dialog" data-role="button" data-theme="c" rel="back" data-inline="true" id="volvarR">Volver</a>
		</form>

  </div>

<!-- 
	MANDAMOS EL SCRIPT EN JAVASCRIPT PARA QUE PODAMOS  MANIPULAR LOS DATOS QUE ENVIA ESTE FORMULARIO
	UNA VES CARGADOS LOS DATOS MANDAMOS LOS DATOS DEL FORMULARIO A UNA PHP QUE SE LLAMA .
-->
<script type="text/javascript">

function opcionesReserva(opc)
{
	
	if (opc=="F")
		{

			
			$("#peatonalVehicular").removeClass("ui-disabled").addClass("");
			$("#fechaEspo").css("display","none");
			$("#titulo").css("display","block");
			$("#aplicarDias").css("display","block");	
			$("#hEstimada").css("display","block");
			$("#pisoReserva").css("display","block");		
			$("#oficinaReserva").css("display","block");
			$("#fechaInicio").css("display","block");
			$("#fechaTermino").css("display","block");
			$("#GuardarVF").removeClass("ui-disabled").addClass("");
			$("#volvarR").removeClass("ui-disabled").addClass("");
			document.frecuente.horaEstimada.value="";
			document.frecuente.estacionamientosR.value="";	
			document.frecuente.patenteR.value="";	
			document.frecuente.PisoR.value="-1";				
			document.frecuente.name.value="";
		}
   	else
	   	{
	   	
   			
   			$("#peatonalVehicular").removeClass("ui-disabled").addClass("");
	   		$("#fechaEspo").css("display","block");
	   		$("#hEstimada").css("display","block");
   			$("#GuardarVF").removeClass("ui-disabled").addClass("");
   			$("#pisoReserva").css("display","block");		
			$("#oficinaReserva").css("display","block");
			/*------corte none------*/
			$("#aplicarDias").css("display","none");
			$("#fechaInicio").css("display","none");
			$("#fechaTermino").css("display","none");
			/*------fin corte------*/
			$("#volvarR").removeClass("ui-disabled").addClass("");
			document.frecuente.horaEstimada.value="";
			document.frecuente.estacionamientosR.value="";	
			document.frecuente.patenteR.value=""; PisoR	
			document.frecuente.PisoR.value="-1";		
			document.frecuente.name.value="";			
   		}
}
/*$(document).ready(function(){

	$("#PisoR").change(function(){
		var piso = document.getElementById("PisoR").value;
		//alert("hola");
		//$("select[name=OficinaR]").load("cargaOficinasYestacionamientos.php?pisoR="+piso);
		 $("select[name=OficinaR]").load("cargaOficinasYestacionamientos.php?pisoR="+piso,function(){
				$('select[name=OficinaR]').trigger('create');
				});
		});
	
	});*/		
$(document).ready(function(){

	$("#radio-peaton").click(function(){

		//alert("peatonal");
		$(".auto").css("display","none");
		$(".estacionamiento").css("display","none");

		});

	$("#radio-vehicular").click(function(){

		//alert("automovil");
		$(".auto").css("display","block");
		$(".estacionamiento").css("display","block");
		$("#patenteR").val("S/P");
		});
	/*$("#frecuenteV").click(function(){
		//$("#esporadicaV").css("display","block");
		 
		
		});
	$("#esporadicaV").click(function(){
		//alert("hola");
		var bandera = true;
		if(bandera)
			{
				$('#frecuenteV').addClass('ui-disabled');
				bandera = false;
			}
		else
			{
				$('#frecuenteV').removeClass('ui-disabled');
				bandera = true;
			}
		});*/
		
	});
		
$(document).ready(function(){
	
	$("#GuardarVF").click(function (){
	   var datos = $("#VisiFrecuente").serialize();//Serializamos los datos a enviar
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

		     //alert(datos);
	     
	      switch(datos)
	      {
	      	case "1": 
		      		
	      		 $('<div>').simpledialog2({
		    		    mode: 'blank',
		    		    headerText: 'Informacion de ingreso',
		    		    headerClose: true,
		    		    blankContent : 
		    			  "<p class='centrado'><strong>El ingreso fue exitoso</strong></p>"+
		    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
		    		      
		    		      // NOTE: the use of rel="close" causes this button to close the dialog.
		    		      
		    		  });
	      			document.getElementById("VisiFrecuente").reset();
		      	break;
			      	
	      	case "0":
		      	
	      		$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problema',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Ingrese los campos solicitados</strong></p>"+
	    			  "<h5 class='centrado'><strong>El rut debe ser sin puntos y con guion</strong></h5>"+
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  })
	      		
		      	    break;
	      	case "2":
			   	
		   		//alert("se registro la nueva reserva esporadica de forma exitosa");
		   	 $('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Información de ingreso',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>La reserva esporadica se efectuo exitosame</strong></p>"+
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
		   			document.getElementById("VisiFrecuente").reset();
		   		
			   	break;
			   	    
	      	case "-1":
		      	
	      	$('<div>').simpledialog2({
    		    mode: 'blank',
    		    headerText: 'Problema',
    		    headerClose: true,
    		    blankContent : 
    			  "<p class='centrado'><strong>La visita que esta ingresando ya esta almacenada en el sistema</strong></p>"+
    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
    		      
    		  })
      				break;
				
	      	case "-2":
		   		
		   		$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problemas con la reserva',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Lo sentimos intente nuevamente en unos minutos mas</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });
		   		
			   	break;

		   	case "-3":

			   	//alert("no se han ingresado la hora estimada de ingreso");
			   	$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problemas con la reserva',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Por favor ingrese la hora de ingreso estimada(*)</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });

			   	break;	
			   	
		   	case "-4":

			   	//alert("debe completar la fecha y la hora del ingreso la visita");
			   	$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problemas con la reserva',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Por favor ingrese la fecha y la hora (*)</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
	    		      
	    		      // NOTE: the use of rel="close" causes this button to close the dialog.
	    		      
	    		  });

			   	break;	   	
		   	case "-5":

			   	//alert("debe completar la fecha y la hora del ingreso la visita");
			   	$('<div>').simpledialog2({
	    		    mode: 'blank',
	    		    headerText: 'Problemas con la reserva',
	    		    headerClose: true,
	    		    blankContent : 
	    			  "<p class='centrado'><strong>Por favor ingrese el estacionamiento</strong></p>"+
	    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
	    		      
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
<!--  </div> -->
<?php 

	}
	public function getVisitas()
	{
		$idc = null;
		//print_r(func_get_arg(0));
		//die();
		if(func_num_args()>0 && func_num_args()<2)
		{
			$idc = func_get_arg(0);
		}
		$visita = controlVisita::getVisita($idc);
		$reserva = controlReserva::getReservas(null,null,$idc);
		//print_r($visita);
		?>

		<h3>Inicio » Editar Visitas</h3>
		<div class="margen-inferior">
			<div data-role="controlgroup" data-type="horizontal" data-mini="true"	class="botones-centrados">
				<!-- 
								<a href="#" data-role="button">Hoy</a>
								<a href="#" data-role="button">Semana</a>
								<a href="#" data-role="button">Mes</a>
							-->
			</div>
		</div>
		<div>
			<ul data-role="listview" data-inset="true" data-filter="true"	data-dividertheme="d">
				<?php 
				if(count($visita)>0)
				{
					foreach ($visita as $vis)
					{
						$reserva = controlReserva::getReservas("Reservada",null,$idc,$vis->getidVisista());
						//print_r($reserva);
						?>
				<li data-role="list-divider"><?php echo $vis->getnombre();?></li>

				<li data-icon="gear" data-theme= <?php if($reserva!=null){ echo isset($reserva)  && $reserva[0]->gettipoReserva()=="Peatonal"?"b":"e"; }else {echo ""; } ?>>
					<?php if (file_exists('src/img/visitas/'.$vis->getidVisista().'.jpg'))
						 {?>
						 <img src="src/img/visitas/<?php echo $vis->getidVisista();?>.jpg" alt="Avatar" height="120" width="120">
						 <?php }
						 else {?>
						 
						 <img src="src/img/avatar.jpg" alt="Avatar" height="120" width="120">
						 <?php }?>
					<!--  <a id="opendialog-editar" href="#" title="<?php echo $vis->getidVisista();?>" data-transition="pop"></a>-->

					<h3 class="ui-li-heading">
						<?php echo $vis->getnombre()." ".$vis->getapellido();?>
					</h3>
					<p class="ui-li-desc">
						Rut :
						<?php echo $vis->getrut()."-".$vis->getdv(); ?>
					</p>
					<p class="ui-li-desc">
						Teléfono :
						<?php echo $vis->gettelefono(); ?>
					</p>
					<p class="ui-li-desc">
						Correo :
						<?php echo $vis->getcontacto(); ?>
					</p>
					<p class="ui-li-desc">
						Empresa :
						<?php echo $vis->getempresa(); ?>
					</p>
					<p class="ui-li-desc">
						Tipo Frecuencia :
						<?php 
							if($reserva!=null)
							{
								echo $reserva!=null && $reserva[0]->getttipoFrecuencia()==1 ? "Frecuente" : "Esporadico";
							}
							else 
							{
								echo "S/R";
							} 
						
						?>
					</p>
					
					<p class="ui-li-desc">
						Piso :
						<?php echo $reserva!=null && $reserva[0]->getpiso()!=null ? $reserva[0]->getpiso() : " S/P"; ?>
					</p>
					<p class="ui-li-desc">
						Oficina :
						<?php echo $reserva!=null && $reserva[0]->getoficina()!=null ? $reserva[0]->getoficina() : " S/OF"; ?>
					</p>
					<p class="ui-li-desc">
						Estado Reserva :
						<?php echo $reserva!=null? $reserva[0]->getestadoValidacion(): "S/R"; ?>
					</p>
					<p class="ui-li-desc">
						Tipo Reserva :
						<?php echo $reserva!=null? $reserva[0]->gettipoReserva() : "S/D"; ?>
					</p>
					<?php 
						if($reserva!=null && $reserva[0]->gettipoReserva()!="Peatonal")
						{	
					?>
						<p class="ui-li-desc">
						Patente :
							<?php echo $reserva[0]->getpatenteVehiculo(); ?>
						</p>
						<p class="ui-li-desc">
						Estacionamiento Asignado :
							<?php echo $reserva[0]->getestacionamientoAsignado(); ?>
						</p>
					<?php 
						}
					?>
					<p class="ui-li-desc">
						Fecha Inicio :
						<?php echo $reserva!=null? $reserva[0]->getfechaEntrada() : "S/D"; ?>
					</p>
					<?php 
					if($reserva!=null && $reserva[0]->getttipoFrecuencia()==1)
					{
					?>
					<p class="ui-li-desc">
						Fecha Termino :
						<?php echo $reserva!=null? $reserva[0]->getfechaSalida():"S/D"; ?>
					</p>
					<?php 
					}
					?>
					<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
						<a href="#editar-perfil" class="editarClientes" title="<?php echo $vis->getidVisista();?>" data-role="button" data-rel="dialog">Editar Perfil</a> 
						<a href="#popup-agendar-visita" data-rel="dialog" class="editarReserva" title="<?php echo $vis->getidVisista()."&".$idc;?>"	data-role="button">Reservar / Editar Reserva</a>
						<script type="text/javascript">
							// Popup window code
							function newPopup(url) {
								window.open(
									url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
							}
						</script>
						<a href="#" onclick="newPopup('uploadFoto.php?idvisita=<?php echo $vis->getidVisista();?>');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir o Editar Foto</a>
						<?php 
							if($reserva[0]!=null && false)
							{
						?> 
								<a href="#popup-eliminar-visita" data-rel="dialog" class="cancelReserva" title="<?php echo $vis->getidVisista()."&".$idc;?>" data-role="button">Cancelar Reserva</a>
						<?php 
							}
						?>
						<?php 
						if(false)
						{
						?>
						<a href="#popup-eliminar-visita" data-rel="dialog" class="eliminarVisita" title="<?php echo $vis->getidVisista()."&".$idc;?>" data-role="button">Eliminar</a>
						<?php 
						}
						?>
					</div> 


				</li>

				<!-- 
							   <li>
										<h3 class="ui-li-heading">Berríos Javier</h3>
										<p class="ui-li-desc"><strong>12/08/12 | Ingreso:</strong> 12:30 - <strong>Salida:</strong> 18:00</p>
										<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
										<a href="#editar-perfil" data-role="button" data-rel="dialog">Editar Perfil</a>
										<a href="#popup-agendar-visita" data-rel="dialog" data-role="button">Reservar / Editar Visita</a>
										<a href="#popup-eliminar-visita" data-rel="dialog" data-role="button">Eliminar</a>
										</div> 
								</li>
							   
							    -->


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
		<script>
$(document).ready(

	function()
			{

			$(".editarClientes").click(function(){
				
				var titulo = $(this).attr("title");
				var datos;

				$.ajax({
		  		   type: "GET", //Establecemos como se van a enviar los datos puede POST o GET
		  		   url: "capturaDataVisiYreservafe.php?editvp="+titulo, //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
		  		   data: datos, //Variable que transferira los datos
		  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
		  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
		  		     						 //Mostrar mensaje que se esta procesando el script
		  		   },
		  		   dataType: "html",
		  		   success: function(datos){ //Funcion que retorna los datos procesados del script PHP

		  			//alert(datos);   	
		          var arr = datos.split("&");
		          
		          //alert(arr);
		          $(".textoReservaFrecuente").html(arr[0]+" "+arr[1]); //nombre de la visita
		          if(arr.length>0)
		          {
		             //alert(arr[0]); 
		             $("#enombre").val(arr[0]);
		             $("#eapellido").val(arr[1]);
		             $('input[name="erut"]').val(arr[2]);
		             $("#epasaporte").val(arr[3]);
		             $("#examinar").val(arr[4]);
		             $("#ecorreo").val(arr[5]);
		             $("#editvpersonal").val(titulo);
		             $('input[name="telefono"]').val(arr[6]);
		             $('input[name="empresa"]').val(arr[7]);
		          }
		  			   
 
		  		   }
		  		 });
		  		//return false;
			
			});

			$(".eliminarVisita").click(function(){

				alert("Estamos en desarrollo en estos momento");	
				/*
					Eliminar visitas, en la parte editar visitas.
				*/

				
		
			});		
	}
);		
</script>
	

<?php 

	}

	public function getEditarVisitaDatosPersonales($cliente=null)
	{
		?>

<div data-role="page" id="editar-perfil">
	<!--  <form action="post" id="editarVisitaDatosPer"> -->
	<div data-role="header" data-theme="b">
		<h1>Editar Perfil</h1>
	</div>


	<div data-role="content" id="content-editar-perfil">

		<h3 style="text-align: center" class="textoReservaFrecuente"></h3>

		<h3>Datos Personales</h3>
		<form action="post" id="editarVisitaDatosPer">
			<div data-role="fieldcontain">
				<label for="name"><strong class="red">*</strong> Nombre Visita:</label>
				<input type="text" name="enombre" id="enombre" value="" /> <input
					type="text" style="display: none;" name="editvpersonal"	id="editvpersonal" value="" />
			</div>

			<div data-role="fieldcontain">
				<label for="name"><strong class="red">*</strong> Apellido Visita:</label>
				<input type="text" name="eapellido" id="eapellido" value="" />
			</div>

			<div data-role="fieldcontain">
				<label for="name"><strong class="red"></strong> RUT (xxxxxxxx-x):</label> <input
					type="text" name="erut" id="name" value="" />
			</div>

			<div data-role="fieldcontain">
				<label for="name"><strong class="red"></strong> Pasaporte:</label>
				<input type="text" name="epasaporte" id="epasaporte" value="" />
			</div>
			
			<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Teléfono:</label>
					<input type="text" name="telefono" id="name"
						value="" />
			</div>
			
			<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Empresa:</label>
					<input type="text" name="empresa" id="name"
						value="" />
			</div>
			
			<div data-role="fieldcontain">
				<label for="name">Subir Fotografía:</label>
				<button type="submit" class="ui-btn-hidden" aria-disabled="false"
					data-inline="true" data-mini="true">Examinar</button>
			</div>

			<div data-role="fieldcontain">
				<label for="name">Correo electrónico:</label> <input type="text"
					name="ecorreo" id="ecorreo" value="" />
			</div>

			<hr>

			<fieldset class="ui-grid-a">
				<a href="#popup-agendar-ok" data-rel="dialog" data-role="button"
					data-theme="b" id="EditaGuardaVisitaDatP" data-inline="true">Guardar</a>
				<a href="#editar-visitas" data-role="button"  data-theme="c" rel="close" data-inline="true">Volver</a> <!-- onClick="location.replace('#editar-visitas');window.location.reload('#editar-visitas');" -->
			</fieldset>
		</form>
	</div>
	<!-- /content	 -->

</div>
<!-- /page -->


<?php 
	}
	public function getReservaVisitaDiv()
	{
	  ?>
			<div data-role="page" id="popup-agendar-visita">
			
				<div data-role="header" data-theme="b">	<h1>Agendar Visita</h1></div>
				
				<div data-role="content" id="editarReservaVisita"></div>
				
			</div>
	  <?php 
	}
	public function getEditarVisitaReserva($idCliente,$idVisita)
	{
		$reserva = controlReserva::getReservaAssClienteVisita($idCliente,$idVisita);
		$visita = controlVisita::AllDatosVisita($idVisita);
		//print_r($visita);
		?>

	<!-- <form action="post" id="editarReservaVisitaFrecuente"> -->
	
	 <form action="post" id="editarReservaVisitaFrecuente">
	<div data-role="content">
	
	<h3 style="text-align: center" class=""><?php echo $visita[0]->getnombre()." ".$visita[0]->getapellido();?></h3>
	
	<br>
	
		<div class="radio-responsivo">
				<fieldset data-role="controlgroup" data-type="horizontal" data-ajax="true" class="row-b">
		    	 	<input type="radio" name="radioPV" id="radio-peaton" value="peatonal" <?php echo $reserva!=null && $reserva->gettipoReserva()=="Peatonal"?"checked=checked" : "";?> />
    			 	<label for="radio-peaton">Peatonal</label>
		    	 	<input type="radio" name="radioPV" id="radio-vehicular" value="vehicular" <?php echo $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"checked=checked" : "";?>/>
	    	 		<label for="radio-vehicular">Vehicular</label>
				</fieldset>
		</div>
		<!--  <div data-role="collapsible" data-content-theme="b" data-theme="b" data-collapsed="false">
			<h3>Agendar Visita</h3>-->

			<div data-role="collapsible-set">
			
				<div data-role="collapsible" data-content-theme="c" data-theme="d" data-collapsed="false">
									
					<h3>Reservar</h3>
					
					<!-- <form action="post" id="editarReservaVisitaFrecuente"> -->
					<div data-role="fieldcontain" id="radios">
		
			    		<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
 	   						<legend>Tipo reserva:</legend>
					        <input type="radio" name="radioOpcion" id="radio-cliente" value="Frecuente" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"checked=checked":"";?> onClick="opcionesReservaEdicion('F');" />
        					<label for="radio-cliente">Frecuente</label>
							<input type="radio" name="radioOpcion" id="radio-operador" value="solo" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==0?"checked=checked":"";?> onClick="opcionesReservaEdicion('S');" />
	    		     		<label for="radio-operador">Solo una vez</label>
						</fieldset>
			
					</div>
					
						<div data-role="fieldcontain" id="controlDias"style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;"; ?>">
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
								
								<legend>
									<strong class="red">*</strong> Aplicar los dias:
								</legend>
								
								<input type="checkbox" name="lunes" id="checkbox-1" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getlunes()!=null? "checked=checked":""; ?> />
			   					<label for="checkbox-1">Lun</label>
				    		   <input type="checkbox" name="martes" id="checkbox-2" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getmartes()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-2">Mar</label>
		    				   <input type="checkbox" name="miercoles" id="checkbox-3" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getmiercoles()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-3">Mie</label>
	    					   <input type="checkbox" name="jueves" id="checkbox-4" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getjueves()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-4">Jue</label>
	    					   <input type="checkbox" name="viernes" id="checkbox-5" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getviernes()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-5">Vie</label>
				    		   <input type="checkbox" name="sabado" id="checkbox-6" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getsabado()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-6">Sab</label>
    						   <input type="checkbox" name="domingo" id="checkbox-7" class="custom" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1 && $reserva->getdomingo()!=null? "checked=checked":""; ?> />
							   <label for="checkbox-7">Dom</label>

							</fieldset>
						</div>
						
						<div data-role="fieldcontain" id="horaEstimadaIngreso" style="display: none;" style="<?php echo $reserva!=null?" ":"display: none;";?>">
							<label for="hora"><strong class="red">*</strong> Hora Estimada de Ingreso:</label> 
							<input name="horaIngreso" id="hora" type="text" data-role="datebox" value="<?php if($reserva!=null){ $horaEstimada = split(" ",$reserva->getfechaEntrada()); echo $horaEstimada[1];}  ?>" data-options='{"mode": "timebox", "overrideTimeFormat": 24}'>
						</div>
						
						<div data-role="fieldcontain" id="fechaEntradaS" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==0?"":"display: none;";?>">
							<label for="mydate"><strong class="red">*</strong> Fecha</label>
							<input	name="fechaEntrada" id="fechaEntrada" type="date" data-role="datebox" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==0){ $horaEstimadayFecha = split(" ",$reserva->getfechaEntrada()); echo $horaEstimadayFecha[0];}  ?>" data-options='{"mode": "calbox"}'>
						</div>
											
						<div  data-role="fieldcontain" id="fechaInicio" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;";?>">
							<label for="mydate"><strong class="red">*</strong>Fecha Inicio:</label> 
							<input	name="fechaInicio" id="mydate" type="date" data-role="datebox" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==1){ $horaEstimadayFecha = split(" ",$reserva->getfechaEntrada()); echo $horaEstimadayFecha[0];}  ?>"	data-options='{"mode": "calbox"}'>
						</div>
			
						<div  data-role="fieldcontain" id="fechaTermino" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;";?>">
							<label for="mydate"><strong class="red"></strong>Fecha Termino:</label> 
							<input	name="fechaTermino" id="mydate" type="date" data-role="datebox" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==1){ $horaEstimadayFecha = split(" ",$reserva->getfechaSalida()); echo $horaEstimadayFecha[0];}  ?>"	data-options='{"mode": "calbox"}'>
						</div>
							<!-- horaIngreso -->
						<div data-role="fieldcontain" id="EditPisos" style="<?php echo $reserva!=null?"":"display: none;";?>">
							<label for="select-choice-a" class="select ui-select">Piso:</label>
							<select name="selecPiso" id="selecPiso" data-native-menu="false" tabindex="-1">
								<option>Seleccione.</option>
								<?php 
				
									$detalleClientesPiso = controlCliente::getDetalleCliente($idCliente,1,null);
									if($detalleClientesPiso!=null && count($detalleClientesPiso)>0)
									{
										foreach($detalleClientesPiso as $piso)
										{
								?>
											<option value="<?php echo $piso->getpiso();?>" <?php echo $reserva!=null && $reserva->getpiso()==$piso->getpiso()? "selected=selected":""?> ><?php echo $piso->getpiso(); ?></option>
								<?php 
										}
									}
								?>	
							</select>
						</div>

						<div data-role="fieldcontain" id="editOff" style="<?php echo $reserva!=null?"":"display: none;";?>">
							<label for="name">Oficina:</label>
							 <!--  <input type="text" name="oficinaRe" id="oficinaRe" value="" />-->
							  <select name="oficinaRe" id="oficinaRe" data-native-menu="false" tabindex="-1">
								  <option value="0">Seleccione Piso Primera..</option>
									  <?php 
										$dataOficinas = controlCliente::getDetalleCliente($idCliente);
										if(count($dataOficinas)>0)
										{
											foreach ($dataOficinas as $ofi)
											{
				  					   ?>
									  			<option value="<?php echo $ofi->getoficina();?>" <?php echo $reserva!=null && $reserva->getoficina()==$ofi->getoficina()? "selected=selected":""?>><?php echo $ofi->getoficina();?></option>
									  <?php
											}			  
										}
				  					  ?>
				 				</select>
							  <input type="text" name="idcliente" id="idcliente" value="<?php echo $idCliente?>" style="display: none;" />
							  <input type="text" style="display: none;" name="idvit" id="idvit" value="<?php echo $idVisita;?>"/>
							  <input type="text" name="editreservaFrecuente" id="editreservaFrecuente" value="" style="display: none;" />
						</div>

						<div data-role="fieldcontain" class="auto" style="<?php echo $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"":"display: none;";?>">
							<label for="name">Patente Automóvil:</label> 
							<input type="text" name="patente" id="patente" value="<?php echo $reserva!=null && $reserva->getpatenteVehiculo()==0 ?$reserva->getpatenteVehiculo():""; ?>" />
						</div>

						<div data-role="fieldcontain" class="estacionamiento" style="<?php echo $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"":"display: none;";?>">
						
							<label for="select-choice-a" class="select ui-select">
							<strong	class="red">*</strong> Estacionamiento:</label> 
							<select	name="estacionamientoE" id="estacionamientoE" data-native-menu="false" tabindex="-1">
								<option value= "0">Seccione...</option>
								<?php 
									$dataEstacionamiento = controlCliente::getestacionamieto($idCliente,null,null);
									if(count($dataEstacionamiento)>0)
									{
										foreach ($dataEstacionamiento as $est)
										{
				 			 ?>
				  						<option value="<?php echo $est->getnumero();?>" <?php echo $reserva!=null && $reserva->getestacionamientoAsignado()==$est->getnumero()?"selected=selected":""?>><?php echo $est->getnumero();?></option>
				  			<?php
										}			  
									}
				 			 ?>
							</select>
						</div>

						<!--  <h3>Salida</h3>

								<div data-role="fieldcontain">select-choice-a
									<label for="mydate">Hora Salida:</label>
									<input name="mydate" id="mydate" type="date" data-role="datebox" data-options='{"mode": "timeflipbox"}'>
								</div>-->
						<hr>
						<a href="#popup-agendar-ok" data-rel="dialog" data-role="button" data-theme="b" id="GuardaEditReserFrecuente" data-inline="true">Guardar</a>
						<a href="#editar-visitas" data-rel="dialog" data-role="button" data-theme="c" rel="back"  data-inline="true" onClick="history.back();">Volver</a> <!-- onClick="location.replace('#editar-visitas');window.location.reload('#editar-visitas');" -->
					<!-- </form>  -->
			 </div>
					
			</div>

		<!-- eliminar </div> -->
	</div>
	 <!-- <form> -->
	 </form>
	<!-- /content -->

<!-- /page -->

<script type="text/javascript">

function opcionesReservaEdicion(opc)
{
	if(opc=="F")
		{
			$("#controlDias").css("display","block"); //solo frecuente
	 		
			$("#editOff").css("display","block");
			$("#EditPisos").css("display","block");
			$("#horaEstimadaIngreso").css("display","block");

			$("#fechaInicio").css("display","block"); //solo frecuente
			$("#fechaTermino").css("display","block"); //solo frecuente

			$("#fechaEntradaS").css("display","none");
		}
	else
		{
			$("#controlDias").css("display","none"); //solo frecuente
			$("#fechaInicio").css("display","none"); //solo frecuente
			$("#fechaTermino").css("display","none"); //solo frecuente
		
			$("#editOff").css("display","block");
			$("#EditPisos").css("display","block");
			$("#horaEstimadaIngreso").css("display","block");
			$("#fechaEntradaS").css("display","block");
			
		}
}
$("#radio-peaton").click(function(){

	//alert("peatonal");
	$(".auto").css("display","none");
	$(".estacionamiento").css("display","none");

	});

$("#radio-vehicular").click(function(){

	//alert("automovil");
	$(".auto").css("display","block");
	$(".estacionamiento").css("display","block");

	});
</script>
<script>
$(document).ready(function(){
	
	$("#GuardaEditReserFrecuente").click(function(){  // captura los datos y actualiza las reservas o reserva dependiendo de que es

		
		var datos = $("#editarReservaVisitaFrecuente").serialize();
			//alert("hola");
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
		  			   
		  			 //$("#enombre").val(arr[0]);
		  			   switch(datos)
		  			   {
		  				   	case "1":

									//alert("update reservaFrecuente ok"); 	//falta preparar las salidas avisando que todo se realizo exitosamente

									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>La edicion de la reserva fue exitosa</strong></p>"+
						    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	  			   			
			  				   	break;

		  				   	case "-1":
			  				   	
									//alert("no se updateo reservaFrecuente"); 	// falta preparar la salida 

									$('<div>').simpledialog2({

					      			 	mode: 'blank',
						    		    headerText: 'Información de ingreso',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Lo sentimos intente mas tarde</strong></p>"+
						    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
						    		      
						    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
									
		  			   			break;
		  				   	case "2":
			  				   	
		  				   			//alert("la reserva se realizo exitosamente"); //primera reserva;

			  				   		$('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información de ingreso',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Se realizo exitosamente la reserva</strong></p>"+
					    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
		  				   			
			  				   	break;

		  				   	case "-2":

		  				   			//alert("no se realizo la reserva"); // problema en la primera reserva


			  				   		$('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información de ingreso',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Lo sentimos intente mas tarde</strong></p>"+
					    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
					    		      
					    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });

			  				   	break;
				  				   		  
		  				   	case "-3":

		  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
		  				  $('<div>').simpledialog2({

			      			 	mode: 'blank',
				    		    headerText: 'Información de ingreso',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Por favor ingrese los campos obligatorios (*)</strong></p>"+
				    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    		      
				    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  });
		  				   			
			  				   	break;	

		  					case "-4":

			  				   	//alert("No ingresaron los campos claves para realizar la reserva"); // no se llenaron ni los días ni la hora estimada de ingreso
			  				  $('<div>').simpledialog2({

				      			 	mode: 'blank',
					    		    headerText: 'Información de ingreso',
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

		});

	
});
</script>
<?php 
		
	}
	
	public function getReservaRapidaCalendar($idCliente)
	{
		
	}
	public function getVisitasEnEspera($idCliente)
	{
		$visita=controlVisita::getVisitasEspera($idCliente);
		//print_r($visita);
		?>
			<div data-role="page" id="lista-visitas-en-espera">
				<div data-role="content">
				<h3>Inicio » Visitas en espera</h3>
				
				<div>
					<ul data-role="listview" data-inset="true" data-filter="true"	data-dividertheme="d">
						<?php
						
						if(count($visita)>0)
						{
							//print_r($visita);
							foreach ($visita as $vis)
							{
								$idVisitaEnEspera=controlVisita::getIdVisitasEnEspera($vis->getidVisista());
								//echo $idVisitaEnEspera;
								
								?>
								<li data-role="list-divider"><?php echo $vis->getnombre()." ".$vis->getapellido();?></li>
								<li data-icon="gear">
									<?php if (file_exists('src/img/visitas/'.$vis->getidVisista().'.jpg'))
									 {?>
									 <img src="src/img/visitas/<?php echo $vis->getidVisista();?>.jpg" alt="Avatar" height="120" width="120">
									 <?php }
									 else {?>
									 <img src="src/img/avatar.jpg" alt="Avatar" height="120" width="120">
									 <?php }?>
									<!--  <a id="opendialog-editar" href="#" title="<?php echo $vis->getidVisista();?>" data-transition="pop"></a>-->
							
									<h3 class="ui-li-heading">
										<?php echo $vis->getnombre()." ".$vis->getapellido();?>
									</h3>
									<p class="ui-li-desc">
										Rut : <?php echo $vis->getrut()."-".$vis->getdv(); ?>
									</p>
									<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
										 
										<a href="#" data-rel="dialog" onclick="reservaVisitaEspera(<?php echo $vis->getidVisista();?>,<?php echo $idCliente;?>,<?php echo $idVisitaEnEspera;?>);"	data-role="button">Reservar Visita</a>
											
										<a href="#" data-rel="dialog" onclick="eliminaVisitaEspera(<?php echo $vis->getidVisista();?>,<?php echo $idCliente;?>,'conf')" data-role="button">Eliminar Visita</a>
										
										
									</div> 
								</li>
								<?php 
							}
						}
						else
						{
							?>
							<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
								<h3 align="center">No hay visitas en espera</h3>
							</div>
							<?php 
						}
						?>
					</ul>
				</div>
			</div>
			<script>
				function reservaVisitaEspera(idVisita,idCliente,idVisitaEnEspera)
				{
					//alert(idVisita);
					$.post('reservaVisitaEspera.php',{idVisita: idVisita,idCliente: idCliente,idVisitaEnEspera:idVisitaEnEspera,opc:"res"},function (data){
						
						switch (data)
						{
							case "1": $('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Exito',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Visita Reservada.</strong></p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-icon='check'>Aceptar</a>"
				    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  });
				    		  break;
	
							case "0": $('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>POST Vacio.</strong></p>"+
				    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
				    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
				    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
				    		      
				    		  });
				    		  break;
				    		  
							case "-1": $('<div>').simpledialog2({
				    		    mode: 'blank',
				    		    headerText: 'Error',
				    		    headerClose: true,
				    		    blankContent : 
				    			  "<p class='centrado'><strong>Error en BD.</strong></p>"+
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
					    			  "<p class='centrado'><strong>Error en envio de datos.</strong></p>"+
					    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
	
				    		  
						}
					});
				}
				function eliminaVisitaEspera(idVisita,idCliente,opc)
				{
					switch (opc)
					{
					
					case "conf":
						
						$('<div>').simpledialog2({
			    		    mode: 'blank',
			    		    headerText: 'Confirmacion',
			    		    headerClose: true,
			    		    blankContent : 
			    			  "<p class='centrado'><strong>Eliminar visita?.</strong></p>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' onClick= 'eliminaVisitaEspera("+idVisita+","+idCliente+",\"bor\")' data-icon='check'>Aceptar</a>"+
			    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='delete' data-theme='c'>Volver</a>"
			    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
			    		      
			    		  });
			    		  break;
					case "bor":
						$.post('reservaVisitaEspera.php',{idVisita: idVisita,idCliente: idCliente,opc:"bor"},function (data){
							
							switch (data)
							{
								case "1": $('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Exito',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Visita Eliminada.</strong></p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
					    		  break;
	
								case "0": $('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Error',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>POST Vacio.</strong></p>"+
					    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
					    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
					    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
					    		      
					    		  });
					    		  break;
					    		  
								case "-1": $('<div>').simpledialog2({
					    		    mode: 'blank',
					    		    headerText: 'Error',
					    		    headerClose: true,
					    		    blankContent : 
					    			  "<p class='centrado'><strong>Error en BD.</strong></p>"+
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
						    			  "<p class='centrado'><strong>Error en envio de datos.</strong></p>"+
						    			  "<p class='centrado'>Comuniquese con administracion para solucionar el error.</p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			    		      // NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  });
	
					    		  
							}
						});
						break;
						
						
					}
				}
			</script>
			<!-- /content -->
		</div>
			<?php 
		}
		public function vistasVisitas()
		{
			?>
			<div data-role="page" id="nueva-visita">
				<div data-role="content" id="content-nueva-visita"></div>
			</div>
			
			
			<div data-role="page" id="editar-visitas">
				<div data-role="content" id="content-editar-visitas"></div>
			</div>
			<?php 
		}
	
}
?>
