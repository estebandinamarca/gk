<?php
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');


?>

<!DOCTYPE html>
 
<html> 
<head> 
  <title>Gest Kontrol</title> 
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 

   

  

  
  <script src="src/js/jquery-1.7.1.min.js"></script>
  <script src="src/js/jquery.mobile-1.1.0.min.js"></script> 
  

  
 

  <link rel="stylesheet" href="src/css/jquery.mobile-1.1.0.min.css" /> 
  <link rel="stylesheet" href="src/css/estilos.css" />
  <!---Estilos Fabián---->
  <link href="src/css/estilos_f.css" rel="stylesheet" type="text/css" />

    

</head> 

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
         	<a href="index.php" onClick="location.replace('index.php');window.location.reload();" rel="external"><img src="src/img/gk-logo.png" width="143" height="40"></a>
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
		                          <li><a href="index.php#mi-perfil" onClick="location.replace('index.php');window.location.reload();" rel="external">Configuracion</a></li>
		                    </ul>
		                    <?php if ($_SESSION["usuario_gk"]->getPrivilegio()>3){?>
		
		                    <ul class="greybox">
		                    	<li><a href="index.php#Administrar-perfiles" onClick="location.replace('index.php');window.location.reload();" rel="external">Agregar Usuario</a></li>
		                    </ul>
		
		                   <ul class="greybox">
		                   		<li><a href="index.php#editar-usuario-cliente" rel="external">Editar Usuarios</a></li>
		                   </ul>
		                   <?php if ($_SESSION["usuario_gk"]->getPrivilegio()>=5){?>
		                   <ul class="greybox">
		                       <li><a href="index.php#Panel-de-control" onClick="location.replace('index.php');window.location.reload();" rel="external">Panel de Control</a></li>
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





<!--body> 
<!-- Start of first page -->

	
	
		  
		           
		
		
	</div><!-- end content -->
</div><!-- /page -->
</body>
</html>
