<?php
require_once ('src/classes/cliente.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/estacionamiento.class.php');

class gestionClienteView
{
	public function getIngresoCliente()
	{
		$pisoall = controlCliente::getDetalleCliente(null,1);
		$totalTabla = count(controlCliente::getDetalleCliente());
		?>
		
			<h3>Inicio » Nuevo Cliente</h3>
			<hr>
			<!-- Datos personales Visita -->
			<form action="post" id="ingreso-cliente">
				<div data-role="fieldcontain">
					<label for="name"><strong class="red">*</strong> RUT (xxxxxxxx-x) :</label>
					<input type="text" name="rutCliente" id="name" value=""  />
				</div>
			
				<div data-role="fieldcontain">
					<label for="name"><strong class="red">*</strong> Nombre Empresa:</label>
					<input type="text" name="nombreCliente" id="name" value=""  />
				</div>
			
				<div data-role="fieldcontain">
					<label for="name"><strong class="red"></strong> Direccion:</label>
					<input type="text" name="direccionCliente" id="name" value=""  />
					<input type="text" name="totalTabla" id="name" style="display: none;" value="<?php echo $totalTabla;?>"  />
				</div>
								
				<h3>Detalles de Oficina</h3>


<div data-role="collapsible-set" data-content-theme="e">

<?php 
if($pisoall!=null)
{
 $pisos = null;
 $inicio = 0;
 $fin = 10;
 $finbloke = 1;
 $totalob= count($pisoall);
 $largoBloke = count($pisoall)/10;
 //echo round($largoBloke);
 if(count($pisoall)>0)
 {	
	while(round($largoBloke)>=$finbloke)
	{	
		
?>

	<div data-role="collapsible">
	 <h2>Pisos <?php echo $pisoall[$inicio]->getpiso()." - ".$pisoall[$fin]->getpiso();?></h2>
	  <ul data-role="listview" data-inset="true" data-theme="c">
	<?php 
		$itera = $inicio;
		$bandera = null;
		while($itera<=$fin)
		{
			$detPiso = controlCliente::getDetalleCliente(null,$pisoall[$itera]->getpiso());
			
				//echo $itera;
				
				
				
	?>
	 	 
			
			<li>
				 <div data-role="fieldcontain" style="margin:0px;">
			        	
			        	<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" style="margin:0px;">
		        	   	 <legend><h2><?php echo "Piso ".$pisoall[$itera]->getpiso().":"; ?></h2></legend>
		        	   		<?php 
		        	   		$name = "checkbox-";
		        	   		$bandera = true;
		        	   		foreach ($detPiso as $clienteDeta)
		        	   		{
		        	   		?>	
    	  		  			   <input type="checkbox" name="<?php echo $name.$clienteDeta->getidDetallecliente();?>" id="<?php echo $name.$clienteDeta->getidDetallecliente();?>" class="custom" <?php echo $clienteDeta->getidCliente()!=null? "disabled=disabled ":""; ?> />
        					   <label for="<?php echo $name.$clienteDeta->getidDetallecliente();?>">Of. <?php echo $clienteDeta->getoficina();?></label>
				    	       <?php 
				    	       	
				    	       	if($bandera)
				    	       	{
				    	       ?>
								<!--  	<label for="username" class="ui-hidden-accessible">Fono:</label>
          					  		 <input type="text" name="<?php echo "telefono-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Fono" style="width:80px; margin:0 0 0 7px;  float:right"/>
         						   <label for="username" class="ui-hidden-accessible">Correo:</label>
      							   <input type="text" name="<?php echo "correo-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Correo" style="width:140px; margin:0 0 0 7px;  float:right"/>                     
                         	      <label for="username" class="ui-hidden-accessible">Contacto:</label>
                         	     <input type="text" name="<?php echo "nombreRecep-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Contacto" style="width:130px; margin:0 0 0 10px; float:right"/>
                         	     -->  				    	       
				    	       <?php 
				    	       		$bandera = false;
				    	       	}
				    	       ?>
    			       		<?php 
		        	   		}
    			       		?>     
    			       		    
			        	</fieldset>
			        	
    	   			</div>
			</li>
	
		
			
	<?php 
			
			
			$itera++;
		}
	?>
	</ul>
	</div>
<?php
		if($inicio == 0)
		{
			$inicio= $inicio+11;
		}
		else
		{
			$inicio = $inicio+10;
		}
		$fin = $fin+10;
		if($fin>$totalob)
		{
			$fin = $totalob-1; 
		}	
		$finbloke++;
 	}
 }
 else 
 {
 	//detalleCliente no posee nada
 }
}
else
{
	//No hay nada en la tabla
}
?>	
	<!-- 
		 <div data-role="collapsible">
			<h2>Pisos 3 - 9</h2>
		</div>
	-->
	
	
</div>
		
			
				<hr>
		
				<fieldset class="ui-grid-a">
					<a href="#" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="guardar-cliente"  onclick="guardarCliente()">Guardar</a>
					<a href="#" data-rel="dialog" data-role="button" data-theme="c" rel="back" onclick="location.replace('index.php');" data-inline="true">Volver</a>
				</fieldset>
		
			</form>
			<script>


	
	function guardarCliente()
	{

		var datos = $("#ingreso-cliente").serialize();//Serializamos los datos a enviar
	   //alert(datos);
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
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
	    			  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='back' data-icon='check'>Aceptar</a>"
	    		      
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
	}
	


</script>
		
		<?php 
	}	
	
	public function getEditarCliente()
	{
		?>
			
				<h3>Inicio » Editar Cliente </h3>
				<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
					
			<!-- FILTRON DE BUSQUEDA DEL VALIDAR VISITA -->
						
			<!-- ES LA LISTA DEL VALIDAR VISITA!!! -->
			<div id="edicionCliente">
			<ul data-role="listview" data-inset="true" data-filter="true" data-dividertheme=d> 
			<?php 
				
				$nombre=" ";
				$clientes = controlCliente::listaClientes($nombre,0);
				
					
				
			if(count($clientes)>0)
			{
				
			
				foreach ($clientes as $result)
				{
					
									
					$rut="Rut: ".$result->getrut().'-'.$result->getdv();
					//if($empresa!=$result->getnombreEmpresa())echo "<li data-role=\"list-divider\">".$result->getnombreEmpresa()."</li>";
					//$empresa=$result->getnombreEmpresa();
					//print_r($result);
					$idCliente = $result->getidCliente();
					$nombreEmpresa= $result->getnombreEmpresa();
					?>
					
					<li data-role="list-divider"><?php echo $nombreEmpresa;?></li>
					<li data-icon="gear">
						<?php if (file_exists('src/img/clientes/'.$idCliente.'.jpg'))
						 {?>
						 <img src="src/img/clientes/<?php echo $idCliente?>.jpg" alt="Avatar" height="120" width="120">
						 <?php }
						 else {?>
						 
						 <img src="src/img/avatar.jpg" alt="Avatar" height="120" width="120">
						 <?php }?>
					<h3 class="list-divider"><?php echo $result->getnombreEmpresa(); ?></h3>
					<p><?php echo $rut; ?></p>
					<p>Direccion: <?php echo $result->getdireccion(); ?></p>
					<div data-role="controlgroup" data-type="horizontal" data-mini="true" data-inline="true">
						<a href="#editar-perfil-cliente" class="editarEmpresas"  data-role="button" data-transition="pop" data-rel="dialog" title="<?php echo $idCliente;?>">Editar Perfil</a>
						<a href="#popup-editar-cliente-piso" class="editarPisosEmpresa"  data-role="button" data-transition="pop" data-rel="dialog"  title="<?php echo $idCliente;?>">Editar Pisos Asociados</a>
						  <a href="#popup-editar-cliente-estacionamientos" data-role="button" class="editarEstacionamientos" data-transition="pop" data-rel="dialog" title="<?php echo $idCliente;?>">Editar Estacionamientos</a>
						  <script type="text/javascript">
					// Popup window code
					function newPopup(url) {
						window.open(
							url,'Subir Archivo Oficina','height=150,width=500,left=10,top=10,resizable=no,scrollbars=no,toolbar=0,menubar=0,location=no,directories=no,status=no')
					}
					</script>
					<a href="#" onclick="newPopup('uploadFoto.php?idcliente=<?php echo $idCliente;?>');" data-role="button" data-theme="c" rel="back" data-inline="true">Subir o Editar Foto</a>
						<!--  <a href="#" data-role="button" class="eliminarEmpresas" data-transition="pop" data-rel="dialog" title="<?php echo $idCliente;?>">Eliminar Cliente </a>-->
					</div>	
					</li>
					
					<?php 
				}
				
			
			}
			else
			{
				?>
				<li class="no-results" style= 'display:none;'>No se encontraron resultados.</li>
				<?php 
			}	
				?>
				</ul>
				</div>
				<script>
				$(".botonVistaCliente").click(function (){
			 
			 var atributo=$(this).attr("href");
			 //alert("boton apretado");
			 atributo=atributo.split("#");
			 //alert(atributo[1]);
			 atributo1="content-"+atributo[1]; 
				
			 $('#'+atributo1).load('cargadorVistasCliente.php?do='+atributo1+'',function(){
				 $('#'+atributo1).trigger('create');
	 			});
			 
			  });
				 </script>
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
				
				<?php
				
	}
	public function getEditDatosPersoalesClientes()
	{
		?>
		<div data-role="page" id="editar-perfil-cliente">
			<div data-role="header" data-theme="b">	<h1>Editar Perfil Cliente</h1></div>
			<div data-role="content" id="content-editar-perfil-cliente">

		<h3 style="text-align: center" class="textoReservaFrecuente"></h3>

		<h3>Datos Personales</h3>
		<form action="post" id="editarClienteDatosPer">
			
			<div data-role="fieldcontain">
				<label for="name"><strong class="red">*</strong> RUT (xxxxxxxx-x):</label> <input
					type="text" name="ClienteRut" id="name" value="" />
			</div>
			
			<div data-role="fieldcontain">
					<label for="name"><strong class="red">*</strong>Nombre Empresa:</label>
					<input type="text" name="ClienteEmpresa" id="name" value="" />
			</div>
			<div data-role="fieldcontain">
				<label for="name"><strong class="red"></strong> Direccion:</label>
				<input type="text" name="ClienteDireccion" id="name" value="" />
				<input type="text" style="display: none;" name="idclienteEmpresa" id="idclienteEmpresa" value=""/>
			</div>
		
			<hr>

			<fieldset class="ui-grid-a">
				<a href="#" data-rel="dialog" data-role="button" data-theme="b" id="EditaGuardaClientesaDatP" data-inline="true">Guardar</a>
				<a href="#editar-cliente" data-role="button"  data-theme="c" rel="close" data-inline="true">Volver</a> <!-- onClick="location.replace('#editar-visitas');window.location.reload('#editar-visitas');" -->
			</fieldset>
		</form>
	</div>
	<!-- /content	 -->

</div>
		
		<?php 
		
	}
	
	public function getEditarPisosClienteDivInicial()
	{
		?>
		<div data-role="page" id="popup-editar-cliente-piso"> <!-- data-role="page" id="popup-editar-cliente-piso" -->
		<div data-role="header" data-theme="b"><h1>Editar Clientes</h1></div>
		<div data-role="content" id="carga">	
		</div>
		</div><!-- /page -->
		<?php 
	}
	
	public function getEditarPisoCliente($idCliente)
	{
		$pisoall = null;
		$totalTabla = null;
		//$pisosDelCliente = null;
		$cliente = null;
		
		$pisoall = controlCliente::getDetalleCliente(null,1);
		$totalTabla = count(controlCliente::getDetalleCliente());
		//$pisosDelCliente = controlCliente::getDetalleCliente(null,1);
		$cliente = controlCliente::getClienteId($idCliente);
		?>
<!--  <div data-role="page" id="popup-editar-cliente-piso"> -->	

	
<form action="post" id="editar-cliente-P"> 
<h3 style="text-align:center"  class="textoPisosClientes"> <?php echo $cliente->getnombreEmpresa();?></h3>

<div data-role="collapsible-set" data-content-theme="e">

<?php 
if($pisoall!=null)
{
 $pisos = null;
 $inicio = 0;
 $fin = 10;
 $finbloke = 1;
 $totalob= count($pisoall);
 $largoBloke = count($pisoall)/10;
 //echo round($largoBloke);
 if(count($pisoall)>0)
 {	
	while(round($largoBloke)>=$finbloke)
	{	
		
?>

	<div data-role="collapsible">
	 <h2>Pisos <?php echo $pisoall[$inicio]->getpiso()." - ".$pisoall[$fin]->getpiso();?></h2>
	  <ul data-role="listview" data-inset="true" data-theme="c">
	<?php 
		$itera = $inicio;
		$bandera = null;
		while($itera<=$fin)
		{
			$detPiso = controlCliente::getDetalleCliente(null,$pisoall[$itera]->getpiso());
			
				//echo $itera;
				
				
				
	?>
	 	 
			
			<li>
				 <div data-role="fieldcontain" style="margin:0px;">
			        	
			        	<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" style="margin:0px;">
		        	   	 <legend><h2><?php echo "Piso ".$pisoall[$itera]->getpiso().":"; ?></h2></legend>
		        	   		<?php 
		        	   		$name = "checkbox_";
		        	   		$bandera = true;
		        	   		foreach ($detPiso as $clienteDeta)
		        	   		{
		        	   		?>	
    	  		  			   <input type="checkbox" name="<?php echo $name.$clienteDeta->getidDetallecliente();?>" id="<?php echo $name.$clienteDeta->getidDetallecliente();?>" class="custom" <?php echo $clienteDeta-> getidCliente() == $idCliente? "checked=checked": " ";?> <?php echo $clienteDeta->getidCliente()!=$idCliente && $clienteDeta->getidCliente()!=null? "disabled=disabled ":""; ?>  />
        					   <label for="<?php echo $name.$clienteDeta->getidDetallecliente();?>">Of. <?php echo $clienteDeta->getoficina();?></label>
				    	       <?php 
				    	       	
				    	       	if($bandera)
				    	       	{
				    	       ?>
								<!--  	<label for="username" class="ui-hidden-accessible">Fono:</label>
          					  		 <input type="text" name="<?php echo "telefono-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Fono" style="width:80px; margin:0 0 0 7px;  float:right"/>
         						   <label for="username" class="ui-hidden-accessible">Correo:</label>
      							   <input type="text" name="<?php echo "correo-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Correo" style="width:140px; margin:0 0 0 7px;  float:right"/>                     
                         	      <label for="username" class="ui-hidden-accessible">Contacto:</label>
                         	     <input type="text" name="<?php echo "nombreRecep-".$clienteDeta->getidDetallecliente();?>" id="username" value="" placeholder="Contacto" style="width:130px; margin:0 0 0 10px; float:right"/>
                         	     -->  				    	       
				    	       <?php 
				    	       		$bandera = false;
				    	       	}
				    	       ?>
    			       		<?php 
		        	   		}
    			       		?>     
    			       		    
			        	</fieldset>
			        	
    	   			</div>
			</li>
	
		
			
	<?php 
			
			
			$itera++;
		}
	?>
	</ul>
	</div>
<?php
		if($inicio == 0)
		{
			$inicio= $inicio+11;
		}
		else
		{
			$inicio = $inicio+10;
		}
		$fin = $fin+10;
		if($fin>$totalob)
		{
			$fin = $totalob-1; 
		}	
		$finbloke++;
 	}
 }
 else 
 {
 	//detalleCliente no posee nada
 }
}
else
{
	//No hay nada en la tabla
}
?>	
</div>
<hr>
<div class="ui-body ui-body-b">
<input type="text" name="pisoEditCliente" id="pisoEditCliente" value="<?php echo $idCliente?>" style="display: none;"/>
<input type="text" name="totaldet" id="totaldet" value="<?php echo $totalTabla;?>" style="display: none;"/>
<fieldset class="ui-grid-a">
<a href="#" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="EditarPisosCliente">Guardar</a>
<a href="#editar-cliente" data-role="button" data-theme="d" data-icon="back" data-inline="true" data-direction="reverse" data-transition="">Volver</a>
</fieldset>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){

	$("#EditarPisosCliente").click(function(){
		
			var datos = $("#editar-cliente-P").serialize();
			//alert("EditarPisosCliente");
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

	 			 		switch(datos)
	 			 		{
	 			 			case "-5":

	 			 				$('<div>').simpledialog2({

	 	  		      			 	mode: 'blank',
	 	  			    		    headerText: 'Problemas',
	 	  		    			    headerClose: true,
	 	  		    			    blankContent : 
	 	  		    				  "<p class='centrado'><strong>Comunicar la falla al administrador</strong></p>"+
	 	  		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	 	  		    		     
	 	  		    		      
	 	  			    		  });	
								
		 			 			break;

	 			 			case "-2":

	 			 				 $('<div>').simpledialog2({

	 	  		      			 	mode: 'blank',
	 	  			    		    headerText: 'Problemas',
	 	  		    			    headerClose: true,
	 	  		    			    blankContent : 
	 	  		    				  "<p class='centrado'><strong>Lo sentimos en estos momentos no podemos efectuar esta accion</strong></p>"+
	 	  		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
	 	  		    		     
	 	  		    		      
	 	  			    		  });
	 	  			    		  
								break;	

		 			 		case "1":
			 			 		
		 			 			 $('<div>').simpledialog2({

				 			 		mode: 'blank',
			  		    		  	headerText: 'Edicion oficinas cliente',
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
	public function geteditarEstacionamientosDiv()
	{
		?>
			<div data-role="page" id="popup-editar-cliente-estacionamientos"> <!-- data-role="page" id="popup-editar-cliente-piso" -->
				<div data-role="header" data-theme="b"><h1>Editar Estacionamientos </h1></div>
				<div data-role="content" id="cargaEstac">	
				</div>
			</div><!-- /page -->
		<?php 
	}
	public function geteditarEstacionamiento($idCliente)
	{
		$pisoall = null;
		$totalTabla = null;
		//$pisosDelCliente = null;
		$cliente = null;
		$inicio=0;
		$pisoall = controlCliente::getestacionamieto(null,3);
		$fin = count($pisoall);
		$itera = 0;
		$totalTabla = count(controlCliente::getestacionamieto());
		$cliente = controlCliente::getClienteId($idCliente);
		$EstaxSub = null;
		$totalEstaxSub = 0;
			?>
<!--  <div data-role="page" id="popup-editar-cliente-piso"> -->	

	
<form action="post" id="editar-cliente-Estacioaniento"> 
<h3 style="text-align:center"  class="textoPisosClientes"> <?php echo $cliente->getnombreEmpresa();?></h3>

<div data-role="collapsible-set" data-content-theme="e">
	<?php 
	while($inicio<$fin)
	{
		$EstaxSub = controlCliente::getestacionamieto(null, $pisoall[$inicio]->getsubterraneo());
		//print_r($EstaxSub);
		//die();
		$totalEstaxSub = count($EstaxSub);
		$subterraneo = null;
		$subNow = null;
		$name = null;
	?>
	<div data-role="collapsible">
		<h3><?php echo $pisoall[$inicio]->getsubterraneo();?></h3>
		  <div data-role="collapsible-set" data-mini="true" data-content-theme="c">
		  	<div data-role="collapsible">
		  	<h2><?php echo $EstaxSub[0]->getnumero()."-".($EstaxSub[$totalEstaxSub-1]->getnumero());?></h2>
		  	<div data-role="fieldcontain" style="margin:0px; width:100%">
		  		  <fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" style="margin:0px; width:100%">
		  	<?php 
		  		
		  		foreach ($EstaxSub as $estac)
		  		{
		  			$name = "checkbox__".$estac->getidEstacionamiento();
		 	 ?>
			  	           	<input type="checkbox" name="<?php echo $name;?>" id="<?php echo $name;?>" class="custom" <?php echo $estac->getidCliente() == $idCliente? "checked=checked": " ";?> <?php echo $estac->getidCliente()!=$idCliente && $estac->getidCliente()!=null? "disabled=disabled ":""; ?> />
                        	<label for="<?php echo $name;?>">Est.<?php echo $estac->getnumero();?></label>
                    	                                                                 
             <?php 
		  			
		  		}
			 ?>
			 	</fieldset>     	
			   </div>
			 </div> 	
		  </div>
	</div>
	<?php 
		$inicio++;
	}
	?>

</div>
<hr>
<div class="ui-body ui-body-b">
<input type="text" name="pisoEditEstac" id="pisoEditEstac" value="<?php echo $idCliente?>" style="display: none;"/>
<input type="text" name="totaldetEstac" id="totaldetEstac" value="<?php echo $totalTabla;?>" style="display: none;"/>
<fieldset class="ui-grid-a">
<a href="#" data-rel="dialog" data-role="button" data-theme="b" data-inline="true" id="EditarEstacCliente">Guardar</a>
<a href="#editar-cliente" data-role="button" data-theme="d" data-icon="back" data-inline="true" data-direction="reverse" data-transition="">Volver</a>
</fieldset>
</div>
</form>

<script>
	
$(document).ready(function(){

	$("#EditarEstacCliente").click(function(){

		var datos = $("#editar-cliente-Estacioaniento").serialize();
		$.ajax({
	  		   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	  		   url: "validaIngresoCliente.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	  		   data: datos, //Variable que transferira los datos
	  		   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	  		   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	  		     						 //Mostrar mensaje que se esta procesando el script
	  		   },
	  		   dataType: "html",

	  		   success: function(datos){

	  				switch(datos)
 			 		{
 			 			case "-5":

 			 				$('<div>').simpledialog2({

 	  		      			 	mode: 'blank',
 	  			    		    headerText: 'Problemas',
 	  		    			    headerClose: true,
 	  		    			    blankContent : 
 	  		    				  "<p class='centrado'><strong>Comunicar la falla al administrador</strong></p>"+
 	  		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
 	  		    		     
 	  		    		      
 	  			    		  });	
							
	 			 			break;

 			 			case "-2":

 			 				 $('<div>').simpledialog2({

 	  		      			 	mode: 'blank',
 	  			    		    headerText: 'Problemas',
 	  		    			    headerClose: true,
 	  		    			    blankContent : 
 	  		    				  "<p class='centrado'><strong>Lo sentimos en estos momentos no podemos efectuar esta accion</strong></p>"+
 	  		    				  "<a data-role='button' href='#'  onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload()\" data-transition='pop' rel='close' data-icon='check'>Volver</a>"
 	  		    		     
 	  		    		      
 	  			    		  });
 	  			    		  
							break;	

	 			 		case "1":
		 			 		
	 			 			 $('<div>').simpledialog2({

			 			 		mode: 'blank',
		  		    		  	headerText: 'Edicion estacionamiento',
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
	public function vistasCliente()
	{
		?>
		<div data-role="page" id="nuevo-cliente">
			<div data-role="content" id="content-nuevo-cliente"></div>
		</div>
		<div data-role="page" id="editar-cliente">
			<div data-role="content" id="content-editar-cliente"></div>
		</div>
		
		
		
				
		<?php 
	}
}
?>
