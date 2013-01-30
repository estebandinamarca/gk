<?php
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlReserva.class.php');
class gestionProveedorView
{
	public function getIngresoProveedor($idCliente)
	{
		?>
	
<h3 style="text-align:center">Inicio » Nuevo Proveedor</h3>
<hr>

<h4>Nuevo Proveedor</h4>

<form action="post" id="ingreso-proveedores">

<div data-role="collapsible" data-content-theme="c" data-theme="b" data-collapsed="false">
<h3>Datos del Proveedor</h3>

<div data-role="fieldcontain">
    <label for="name"><strong class="red">*</strong>Nombre Proveedor :</label>
    <input type="text" name="NombreProveedor" id="name" value=""/>
</div>

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Rut Proveedor :</label>
    <input type="text" name="rutProveedor" id="name" value=""/>
</div>	

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Rubro :</label>
    <input type="text" name="RubroProveedor" id="name" value=""/>
</div>

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Dirección :</label>
    <input type="text" name="direccionProveedor" id="name" value=""/>
</div>

<div data-role="fieldcontain">
    <label for="name">Teléfono :</label>
    <input type="text" name="telefenoProveedor" id="name" value=""/>
</div>

<!--  <div data-role="fieldcontain">
    <label for="name">Celular :</label>
    <input type="text" name="celularProveedor" id="name" value=""/>
</div>
-->		

<div data-role="fieldcontain">
    <label for="name">Correo electrónico :</label>
    <input type="text" name="correoProveedor" id="name" value=""/>
    <input type="text" name="idClienteaProveedor" id="idClienteaProveedor" value="<?php echo $idCliente;?>" style="display: none;"/>
</div>	
<hr>
<fieldset>
	<a href="#" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="GuarDatosProveedores">Guardar</a>	
	<a href="index.php"  data-direction="reverse" data-transition="slide" data-role="button" data-theme="c" rel="back" data-inline="true">Volver</a>
</fieldset>
</div>

</form>


<script>
$(document).ready(function(){

	$("#GuarDatosProveedores").click(function(){

		//alert("hola listo para guardar");
		var datos = $("#ingreso-proveedores").serialize();
		//alert("EditarPisosCliente");
		$.ajax({
			type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoProveedorYreserva.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	  		   data: datos, //Variable que transferira los datos
	  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	  		     						 //Mostrar mensaje que se esta procesando el script
	  		   },
	  		   dataType: "html",

	  		   success: function(datos)
	  		   {

	  			 switch(datos)
			  	{	   
		  		 	case "2":

		 				$('<div>').simpledialog2({

	    	  			 	mode: 'blank',
		    			    headerText: 'Problemas',
	    				    headerClose: true,
	    				    blankContent : 
	    					  "<p class='centrado'><strong>Lo sentimos no podemos ejecturar esta accion en estos momentos</strong></p>"+
		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	    		     
	    		      
			    		  });	
					
			 			break;

	 				case "3":

	 					 $('<div>').simpledialog2({

	      				 	mode: 'blank',
		    		    	headerText: 'Problemas',
		    			    headerClose: true,
		    			    blankContent : 
	    					  "<p class='centrado'><strong>Se efectuó la edición, pero el rut ingresado no es valido</strong></p>"+
	    					  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
		    			  });
		    		  
						break;	

			 		case "1":
			 		
			 			 $('<div>').simpledialog2({

	 				 		mode: 'blank',
		    			  	headerText: 'Edicion Proveedor',
	    		    		headerClose: true,
	    		    		blankContent : 
		    			  	"<p class='centrado'><strong>La edición fue exitosa</strong></p>"+
		    			  	"<a data-role='button' href='#' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
   				      	// NOTE: the use of rel="close" causes this button to close the dialog.
   			      
   				 		 });
   			 			 break;
   			 		 
			 		case "-2":
			 		
			 			 $('<div>').simpledialog2({

		 			 		mode: 'blank',
			    		  	headerText: 'Edicion Proveedor',
	    			    	headerClose: true,
	    			    	blankContent : 
	    				  	"<p class='centrado'><strong>El proveedor ya está almacenado</strong></p>"+
	    			  		"<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	  			      	// NOTE: the use of rel="close" causes this button to close the dialog.
  			      
  				 		 });
  			 		 
  				 		 break;
  			 		 	   			 		 
		   			
			  	}
			   			  
		  	   }
				



 			});
			return false;
		});
	});
</script>
		<?php 
	
	}

	public function getEditarProveedor($idCliente=null)
	{
		$tipoVisita = "proveedor";
		$proveedor = controlVisita::getVisita($idCliente,$tipoVisita);
		?>
		
				<h3>Inicio » Editar o Reservar visita de Proveedores</h3>
				<div class="margen-inferior">
					<div data-role="controlgroup" data-type="horizontal" data-mini="true" class="botones-centrados">
						
					</div>
				</div>
				<div>
					<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme="d">
						<?php 
						if(count($proveedor)>0)
						{
							foreach ($proveedor as $vis)
							{
								$reserva = controlReserva::getReservas("Reservada",null,$idCliente,$vis->getidVisista());
								//print_r($reserva);
								?>
						<li data-role="list-divider"><?php echo $vis->getempresa();?></li>
		
						<li data-icon="gear">
							<?php if (file_exists('src/img/proveedor/'.$idCliente.'.jpg'))
						 {?>
						 <img src="src/img/proveedor/<?php echo $idCliente?>.jpg" alt="Avatar" height="120" width="120">
						 <?php }
						 else {?>
						 
						 <img src="src/img/avatar.jpg" alt="Avatar" height="120" width="120">
						 <?php }?>
							<!--  <a id="opendialog-editar" href="#" title="<?php echo $vis->getidVisista();?>" data-transition="pop"></a>-->
		
							<h3 class="ui-li-heading"> Proveedor :
								<?php echo $vis->getempresa();?>
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
								if($reserva!=null && $reserva[0]->gettipoReserva()=="Vehicular")
								{
							?>
							<p class="ui-li-desc">
								Patenten :
								<?php echo $reserva!=null? $reserva[0]->getpatenteVehiculo() : "S/P"; ?>
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
								<a href="#editar-perfil-proveedor" class="editarProveedorPerfil" title="<?php echo $vis->getidVisista()?>" data-role="button" data-rel="dialog">Editar Perfil</a> 
								<a href="#reservaS-proveedor" data-rel="dialog" class="editarProveedorReserva" title="<?php echo $vis->getidVisista()."&".$idCliente;?>"	data-role="button">Reservar visita Proveedor / Editar </a>
								<script type="text/javascript">
									// Popup window code
									function newPopup(url) {
										window.open(
											url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
									}
									</script>
								<a href="#" onclick="newPopup('uploadFoto.php?idproveedor=<?php echo $vis->getidVisista();?>');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir o Editar Foto</a>
								<?php 
									if($reserva[0]!=null && false)
									{
								?> 
										<a href="#popup-eliminar-visita" data-rel="dialog" class="cancelReserva" title="<?php echo $vis->getidVisista()."&".$idCliente;?>" data-role="button">Cancelar Reserva</a>
								<?php 
									}
								?>
								<?php 
								if(false)
								{
								?>
								<a href="#popup-eliminar-visita" data-rel="dialog" class="eliminarVisita" title="<?php echo $vis->getidVisista()."&".$idCliente;?>" data-role="button">Eliminar</a>
								<?php 
								}
								?>
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
			
		
		<?php 
	}
	public function geteditarPerfilProveedorDiv()
	{
		?>
		<div data-role="page" id="editar-perfil-proveedor">
		<div data-role="header" data-theme="b">	<h1>Editar Perfil Proveedor</h1></div>
			
			<div data-role="content" id="editperproveedor">
			
			</div>
			
		</div>
		<?php 
	}
	public function getEditPerfilProveedor($idProveedor=null)
	{
		$proveedor = controlVisita::getVisitaWithId($idProveedor);
		//print_r($proveedor);
		//die();
		?>
		<h3>Datos Personales</h3>
		<form action="post" id="editarPerfilProveedor">
			
			<div data-role="fieldcontain">
    <label for="name"><strong class="red">*</strong>Nombre Proveedor :</label>
    <input type="text" name="NombreProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->getempresa()!=null?$proveedor->getempresa(): ""; ?>"/>
</div>

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Rut Proveedor :</label>
    <input type="text" name="rutProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->getrut()!=null?$proveedor->getrut()."-".$proveedor->getdv(): ""; ?>"/>
</div>	

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Rubro :</label>
    <input type="text" name="RubroProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->getrubro()!=null?$proveedor->getrubro(): ""; ?>"/>
</div>

<div data-role="fieldcontain">
    <label for="name"><strong class="red"></strong>Dirección :</label>
    <input type="text" name="direccionProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->getdireccion()!=null?$proveedor->getdireccion(): ""; ?>"/>
</div>

<div data-role="fieldcontain">
    <label for="name">Teléfono :</label>
    <input type="text" name="telefenoProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->gettelefono()!=null?$proveedor->gettelefono(): ""; ?>"/>
</div>

<!--  <div data-role="fieldcontain">
    <label for="name">Celular :</label>
    <input type="text" name="celularProveedor" id="name" value=""/>
</div>
-->		

<div data-role="fieldcontain">
    <label for="name">Correo electrónico :</label>
    <input type="text" name="correoProveedor" id="name" value="<?php echo isset($proveedor) && $proveedor->getcontacto()!=null?$proveedor->getcontacto(): ""; ?>"/>
    <input type="text" style="display: none;" name="idProveedorPerfil" id="idProveedorPerfil" value="<?php echo $idProveedor;?>"/>
</div>	
<hr>
	<fieldset class="ui-grid-a">
			<a href="#" data-rel="dialog" data-role="button" data-theme="b" id="EditaGuardaDatProveedor" data-inline="true">Guardar</a>
			<a href="#editar-proveedor" data-role="button"  data-theme="c" rel="close" data-inline="true">Volver</a> <!-- onClick="location.replace('#editar-visitas');window.location.reload('#editar-visitas');" -->
	</fieldset>
</form>

<script>
$(document).ready(function(){

	$("#EditaGuardaDatProveedor").click(function(){

		var datos = $("#editarPerfilProveedor").serialize();
		//alert("EditarPisosCliente");
		$.ajax({
	  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoProveedorYreserva.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
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
 			 			case "-5":

 			 				$('<div>').simpledialog2({

 	  		      			 	mode: 'blank',
 	  			    		    headerText: 'Problemas',
 	  		    			    headerClose: true,
 	  		    			    blankContent : 
 	  		    				  "<p class='centrado'><strong>Lo sentimos no podemos ejecturar esta accion en estos momentos</strong></p>"+
 	  		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
 	  		    		     
 	  		    		      
 	  			    		  });	
							
	 			 			break;

 			 			case "3":

 			 				 $('<div>').simpledialog2({

 	  		      			 	mode: 'blank',
 	  			    		    headerText: 'Problemas',
 	  		    			    headerClose: true,
 	  		    			    blankContent : 
 	  		    				  "<p class='centrado'><strong>Se efectuo la edicion, pero el rut ingresado no es valido</strong></p>"+
 	  		    				  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
 	  		    		     
 	  		    		      
 	  			    		  });
 	  			    		  
							break;	

	 			 		case "1":
		 			 		
	 			 			 $('<div>').simpledialog2({

			 			 		mode: 'blank',
		  		    		  	headerText: 'Edicion Proveedor',
	  		    		    	headerClose: true,
	  		    		    	blankContent : 
  			    			  	"<p class='centrado'><strong>La edicion fue exitosa</strong></p>"+
  			    			  	"<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
  		    			      	// NOTE: the use of rel="close" causes this button to close the dialog.
  		    			      
  		    			  });

	 			 			break;	
	 			 			
	  		   		 }
	  		    }
	  		 });
		return false;
		});
	
	});
	
</script>
		<?php 
	}
	
	public function getReservaProveedorDiv()
	{
		?>
		<div data-role="page" id="reservaS-proveedor">
		
			<div data-role="header" data-theme="b">	<h1>Agendar visita proveedor</h1></div>
				
			<div data-role="content" id="reservaProveedor">
			
			</div>
			
		</div>
		<?php 
	}
	
	public function getReservaProveedor($idCliente,$idProveedor)
	{
		$reserva = controlReserva::getReservaAssClienteVisita($idCliente,$idProveedor);
		//print_r($reserva);
		//echo $idCliente."_".$idProveedor;
		//die();
		$visita = controlVisita::AllDatosVisita($idProveedor);
		//print_r($visita);
		?>
		<h3 style="text-align: center" class=""><?php echo $visita[0]->getempresa();?></h3>
		<br>
	  	<div data-role="navbar" data-iconpos="top"  data-mini="true" id="peatonalVehicular"  class="<?php echo $reserva!=null?"":"ui-disabled"?>">
			<ul>
				<li><a href="#" class="<?php if($reserva!=null){echo $reserva->gettipoReserva()=="Peatonal"?"ui-btn-active":"";}else{echo "ui-btn-active"; } ?>" id="visitaReservaPeaton" data-icon="back">Peatón</a></li>
				<li><a href="#" class="<?php if($reserva!=null){echo $reserva->gettipoReserva()=="Vehicular"?"ui-btn-active":"";};?>" id="visitaReservaVehicular" data-icon="back">Automóvil</a></li>
			</ul>
		</div>
	<form  action="post" id="EditreservaProveedorS">
	
	<div data-role="fieldcontain" id="radios">
		
    		<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
    			<legend>Tipo reserva:</legend>
	        	<input type="radio" name="radioOpcion" id="radio-proveedorF" value="Frecuente" <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"checked=checked":"";?> onClick="opcionesReservaP('F');" />
        		<label for="radio-proveedorF">Frecuente</label>
				<input type="radio" name="radioOpcion" id="radio-proveedorE" value="solo"  <?php echo $reserva!=null && $reserva->getttipoFrecuencia()==0?"checked=checked":"";?> onClick="opcionesReservaP('S');" />
	         	<label for="radio-proveedorE">Solo una vez</label>
			</fieldset>
			
		</div>
		
	<h3>Entrada</h3>
	
	<div data-role="fieldcontain" id="diasP" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;"; ?>">
		    
		    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
		    
			   <legend><strong class="red">*</strong> Aplicar los dias:</legend>
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
	
	<div data-role="fieldcontain" id="horaEstimadaIngresoP" style="<?php echo $reserva!=null?" ":"display: none;";?>">

			
		<label for="hora"><strong class="red">*</strong> Hora Estimada de Ingreso:</label>
		<input name="horaEstimada" id="hora" type="text" data-role="datebox" value="<?php if($reserva!=null){ $horaEstimada = split(" ",$reserva->getfechaEntrada()); echo $horaEstimada[1];}  ?>" data-options='{"mode": "timebox", "overrideTimeFormat": 24}'> 
	
	</div>
	
	<div data-role="fieldcontain" id="fechaP" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==0?"":"display: none;";?>">   
		
		<label for="mydate"><strong class="red">*</strong> Fecha</label>
		<input name="fechaPr" id="mydate" type="date" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==0){ $horaEstimadayFecha = split(" ",$reserva->getfechaEntrada()); echo $horaEstimadayFecha[0];}  ?>" data-role="datebox" data-options='{"mode": "calbox"}'>
 	
 	</div>
 	<div  data-role="fieldcontain" id="fechaInicioP" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;";?>">
				<label for="mydate"><strong class="red">*</strong>Fecha Inicio:</label> 
				<input	name="fechaInicio" id="mydate" type="date" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==1){ $horaEstimadayFecha = split(" ",$reserva->getfechaEntrada()); echo $horaEstimadayFecha[0];}  ?>" data-role="datebox"	data-options='{"mode": "calbox"}'>
			</div>
			
			<div  data-role="fieldcontain" id="fechaTerminoP" style="<?php echo $reserva!=null && $reserva->getttipoFrecuencia()==1?"":"display: none;";?>">
				<label for="mydate"><strong class="red">*</strong>Fecha Termino:</label> 
				<input	name="fechaTermino" id="mydate" type="date" value="<?php if($reserva!=null && $reserva->getttipoFrecuencia()==1){ $horaEstimadayFecha = split(" ",$reserva->getfechaSalida()); echo $horaEstimadayFecha[0];}  ?>" data-role="datebox"	data-options='{"mode": "calbox"}'>
			</div>
	
	<div data-role="fieldcontain" id="pisoP" style="<?php echo $reserva!=null?"":"display: none;";?>">
		
		<label for="select-choice-a" class="select ui-select">Piso:</label>
			
			<select name="pisoP" id="pisoP" data-native-menu="false" tabindex="-1">
				<option value="0">Selecione</option>
				<?php 
				
				$detalleClientesPiso = controlCliente::getDetalleCliente($idCliente,1,null);
				print_r($detalleClientesPiso);
				//echo "hola";
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

	<div data-role="fieldcontain"  id="oficinaP" style="<?php echo $reserva!=null?"":"display: none;";?>">
	    
	    <label for="name">Oficina:</label>
    	<select name="OficinaP" id="name" data-native-menu="false" tabindex="-1">
				  <option value="0">Seleccione Piso Primero..</option>
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
	</div>
 	
 	<div data-role="fieldcontain" class="estacionamiento" style="<?php echo $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"":"display: none;";?>">
	    <label for="name">Patente Automóvil:</label>
    	<input type="text" name="patenteP" id="patenteP" value="<?php echo $reserva!=null && $reserva->getpatenteVehiculo()==0 ?$reserva->getpatenteVehiculo():""; ?>"  />
    	<input type="text" name="idCliente" id="idCliente" value="<?php echo $idCliente;?>" style="display: none;" />
    	<input type="text" name="idProveedorReserva" id="idProveedorReserva" value="<?php echo $idProveedor;?>" style="display: none;" />
    </div>

	<hr>
 
	<a href="#" class="<?php echo $reserva!=null?"":"ui-disabled"?>" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardarReserProveedor">Guardar</a>	
	<a href="#editar-proveedor" class="<?php echo $reserva!=null?"":"ui-disabled"?>" data-rel="dialog" data-role="button" data-theme="c" rel="close"  rel="back" data-inline="true" id="volverRP">Volver</a>
	</form>
	
	

<script type="text/javascript">
				  
function opcionesReservaP(opc)
{
	
	if (opc=="F")
		{

			
			$("#peatonalVehicular").removeClass("ui-disabled").addClass("");
			$("#fechaP").css("display","none");
			$("#titulo").css("display","block");
			$("#diasP").css("display","block");	
			$("#horaEstimadaIngresoP").css("display","block");
			$("#pisoP").css("display","block");		
			$("#oficinaP").css("display","block");
			$("#fechaInicioP").css("display","block");
			$("#fechaTerminoP").css("display","block");
			$("#estimaPermanencia").css("display","block");
			$("#guardarReserProveedor").removeClass("ui-disabled").addClass("");
			$("#volverRP").removeClass("ui-disabled").addClass("");
			//document.frecuente.horaEstimadaIngresoP.value="";
			//document.frecuente.estacionamientosP.value="";	
			//document.frecuente.patenteP.value="";	
			//document.frecuente.pisoP.value="-1";				
			//document.frecuente.name.value="";
			
		}
   	else
	   	{
	   	
   			
   			$("#peatonalVehicular").removeClass("ui-disabled").addClass("");
	   		$("#fechaP").css("display","block");
	   		$("#horaEstimadaIngresoP").css("display","block");
   			$("#guardarReserProveedor").removeClass("ui-disabled").addClass("");
   			$("#volverRP").removeClass("ui-disabled").addClass("");
   			$("#pisoP").css("display","block");		
			$("#oficinaP").css("display","block");
			$("#estimaPermanencia").css("display","block");
			/*------corte none------*/
			$("#diasP").css("display","none");
			$("#fechaInicioP").css("display","none");
			$("#fechaTerminoP").css("display","none");
			/*------fin corte------*/
			//document.frecuente.horaEstimadaIngresoP.value="";
			//document.frecuente.estacionamientosP.value="";	
			//document.frecuente.patenteP.value=""; 	
			//document.frecuente.pisoP.value="-1";		
			//document.frecuente.name.value="";			
   		}
}				  
$(document).ready(function(){

	$("#visitaReservaPeaton").click(function(){

		//alert("peatonal");
		$(".auto").css("display","none");
		$(".estacionamiento").css("display","none");
		$("#patenteP").val("");
		});

	$("#visitaReservaVehicular").click(function(){

		//alert("automovil");
		$(".auto").css("display","block");
		$(".estacionamiento").css("display","block");
		//document.EditreservaProveedorS.patenteP.value="0";
		<?php 
			if($reserva==null || ($reserva!=null && $reserva->getpatenteVehiculo()==0))
			{
		?>
			$("#patenteP").val("S/P");
		<?php 
			}
		?>
		});
	
	$("#guardarReserProveedor").click(function(){
		//alert("hola");
		var datos = $("#EditreservaProveedorS").serialize();

		$.ajax({
	  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoProveedorYreserva.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
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
			 			case "-1":

			 				$('<div>').simpledialog2({

	  		      			 	mode: 'blank',
	  			    		    headerText: 'Problemas',
	  		    			    headerClose: true,
	  		    			    blankContent : 
	  		    				  "<p class='centrado'><strong>No se ingresaron los campos con (*) en el formulario de reserva</strong></p>"+
	  		    				  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	  		    		     
	  		    		      
	  			    		  });	
							
	 			 			break;

			 			case "-2":

			 				$('<div>').simpledialog2({

	  		      			 	mode: 'blank',
	  			    		    headerText: 'Problemas',
	  		    			    headerClose: true,
	  		    			    blankContent : 
	  		    				  "<p class='centrado'><strong>No se ingresaron los campos con (*) en el formulario de reserva</strong></p>"+
	  		    				  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	  		    		     
	  		    		      
	  			    		  });	
	  			    		  
							break;	

	 			 		case "1":
		 			 		
	 			 			 $('<div>').simpledialog2({

			 			 		mode: 'blank',
		  		    		  	headerText: 'Edicion Proveedor',
	  		    		    	headerClose: true,
	  		    		    	blankContent : 
			    			  	"<p class='centrado'><strong>La edicion fue exitosa</strong></p>"+
			    			  	"<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
		    			      	// NOTE: the use of rel="close" causes this button to close the dialog.
		    			      
		    			  });

	 			 			break;	
	 			 		default:
							alert("estimado comunicar este numero:"+datos+" al administrador");		
	  		   		 }
	  		    }
	  		 });
		return false;
		});
	
	});

				  
</script>		
		<?php 
	}
	public function vistasProveedor()
	{
		?>
		<div data-role="page" id="nuevo-proveedor">
			<div data-role="content" id="content-nuevo-proveedor">
			</div>
		</div>
		<div data-role="page" id="editar-proveedor">
			<div data-role="content" id="content-editar-proveedor"></div>
		</div>
			
		<?php 
	}
}
?>
