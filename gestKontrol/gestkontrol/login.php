<?php
//require_once ('src/classes/UsuarioControl.class.php'); Reparar!!!!
//require_once ('src/classes/usuario.php'); Reparar

/*
 * FALTA DESTRUIR LA VARIABLE DE SESION........ TENER PRESENTE
 * 
 * 
 * */
/*if(isset($_GET))
{
	session_start();
	session_destroy();
	
}*/
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
   <link rel="stylesheet" type="text/css" href="src/css/jqm-datebox.min.css" /> 
   <link rel="stylesheet" type="text/css" href="src/css/jquery.mobile.simpledialog.min.css" />
   <link rel="shortcut icon" href="src/img/logo-mini.png" type="image/x-icon">
   <!------------- Nuevos JS  ---------------> 
   <script type="text/javascript" src="src/js/jqm-datebox.core.min.js"></script>
   <script type="text/javascript" src="src/js/jqm-datebox.mode.calbox.min.js"></script>
   <script type="text/javascript" src="src/js/jqm-datebox.mode.datebox.min.js"></script>   
   <!------------- Fin --------------->
   <script type="text/javascript" src="src/js/jquery.mobile.simpledialog2.min.js"></script>	
   
   <!--  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" /> -->
   <!--  
   <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
   <script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
   -->
</head> 

<body> 

<!-- Start of first page -->
<div data-role="page" id="inicio" style="margin-top:0px;">
<script type="text/javascript">

$(document).ready(function(){
	$("#Ingresar").click(function (){
	   var datos = $("#ingreLogin").serialize();//Serializamos los datos a enviar
	   $.ajax({
	   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	   url: "validaIngreLogin.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	   data: datos, //Variable que transferira los datos
	   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
	     						 //Mostrar mensaje que se esta procesando el script
	   },
	   dataType: "html",
	   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
	      if(datos == 1)
	      { 
	    		  //alert(datos);
	    		  window.location = "index.php";
    		  
    		  
	      }
	      else 
	      { 
	    	  
	    	  $("#erro").css("display", "block"); 
	    	 // alert(datos);
	    	  
	      }
	      
	   }
	   
	   });
	   return false;
	});
	
	});
	
</script>
<div data-role="header" data-position="inline" data-theme="b">
	<h1>Gest Kontrol &#174;</h1>
</div><!-- /header -->
	
<!-- start content -->
<div data-role="content">
<div class="img-central"></div>

<label for="basic" class="login" id="erro" style="display: none; background: #A9BCF5;">Usuario o contraseña incorrectos</label>

	   <form id="ingreLogin" name="ingreLogin" method="post" >
           <label for="basic" class="login">Usuario:</label>
           <input type="text" name="usuario" id="basic" class="login" />
           <label for="password" class="login">Password:</label>
           <input type="password" name="password" id="password" value="" class="login" />
           <p class="login"><input type="submit" data-role="button" data-theme="b"  value="Ingresar" id="Ingresar" name="Ingresar"></p>
           <p class="login">¿No recuerda sus datos? <a href="#" rel="external">Ayuda</a></p>
       </form>
</div><!-- end content -->

</div><!-- /page -->
</body>

</html>