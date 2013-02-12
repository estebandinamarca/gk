<?php
require_once ('src/classes/usuario.php');
session_start();
if(!isset($_SESSION["usuario_sbr"])) header("Location: login.php");
require_once("src/views/HTMLViews.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Sistema De Bienes Raíces para el Edificio Transoceanica</title>
	<link rel="stylesheet" href="src/css/index.css" type="text/css" media="screen" />
	<script type="text/javascript" src="src/js/ajax.js"></script>
	<script type="text/javascript" src="src/jquery/jquery.js"></script>
	<script>
	/*
	$(document).ready(function()
		{
			$("#subCuerpo").load("ViewBegin.php");
			var refreshId = setInterval(function() {
		      	$("#subCuerpo").load("ViewBegin.php");
		   		}, 9000);
		   		$.ajaxSetup({ cache: false });			
		});*/
	</script>
	
	
</head>
<body>
<?php HTMLViews::getHeader($_SESSION["usuario_sbr"]); ?>

<div id="subTi">
<table summary="" id="tabBegin" border="0">
<tr><td>&nbsp;</td></tr>
</table>
</div>
<div class="cuerpo" style="padding-top: 30px;">
		<center>
			<!--<img src="src/img/icons/martillo.png" alt="en construccion" />-->
			<!--<p style="font-size: 20px; color: #606060; font-weight: bolder;">Funcionalidad En construcción</p>-->
			<p style="font-size: 20px; color: #606060; font-weight: bolder;">Dirección no encontrada</p>
			<p>Lo sentimos, el enlace al que intenta acceder no se encuentra.</p>
			<p style="padding-bottom: 50px;">Si tiene dudas contacte al administrador.</p>
		</center>
<!--   <table summary="" id="tabCuerpo" border="1">
<tr valign="top">
	<td height="85">
		<div id="subCuerpo">
			
		</div>
		<div id="elementosBR">
		</div>
		
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

</table>-->
<div class="clear"></div>
</div>
</body>

</html>
