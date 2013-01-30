<?php
require_once 'src/classes/controlArchivo.class.php';

	if(isset($_GET['idvisita'])) $idvisita=$_GET['idvisita']; else $idvisita=null;
	if(isset($_GET['idprove'])) $idprove=$_GET['idprove']; else $idprove=null;
	if(isset($_GET['idcliente'])) $idcliente=$_GET['idcliente']; else $idcliente=null;
	if(isset($_GET['iduser'])) $iduser=$_GET['iduser']; else $iduser=null;	

if($_POST)
{
	$control = controlArchivo::upload($_POST); 
	//echo $control;
	
	if($control=="1")
	{
		?>
	<div class="titulomenuprincipal" >La carga se efectuo exitosamente</div>
	<div style="margin-top: 10px; text-align: center;">
	<!-- <a href="../TransSBRJ/addPropiedad.php">Volver</a>-->
	</div>
	 <div class="volver">
		<input type="button" onclick="window.close();" value="Salir">
	</div>  
		<?php 
	}
	else
	{
		if($control=="-1")
		{
			?>
			<div class="titulomenuprincipal" >No se puede efectuar la carga de datos<br> Si el problema persiste, contactese con administracion</div>
			<div style="margin-top: 10px; text-align: center;">
			<!-- <a href="../TransSBRJ/addPropiedad.php">Volver</a>-->
			</div>
			<div class="volver">
				<input type="button" onclick="window.location='uploadFoto.php'" value="Volver">
			</div>
			<?php 
		}
	}
}

else 
{
?>


<html>
<head>
 <title>Subir Foto - GestKontrol</title>
 </head> 
	<body>
	
		<form action="uploadFoto.php" method="post" enctype="multipart/form-data">
		<?php if ($idvisita!=null)
		{?>
			<div data-role="fieldcontain" style="display:none;">
				<label for="name" ><strong class="red">*</strong> Opcion</label>
				<input type="text" name="opc" id="eidEst" value="vis,<?php echo $idvisita;?>"/>
			</div>
		<?php }?>
		<?php if ($idprove!=null)
		{?>
			<div data-role="fieldcontain" style="display:none;">
				<label for="name" ><strong class="red">*</strong> Opcion</label>
				<input type="text" name="opc" id="eidEst" value="prove,<?php echo $idprove;?>"/>
			</div>
		<?php }?>
		<?php if ($idcliente!=null)
		{?>
			<div data-role="fieldcontain" style="display:none;">
				<label for="name" ><strong class="red">*</strong> Opcion</label>
				<input type="text" name="opc" id="eidEst" value="cli,<?php echo $idcliente;?>"/>
			</div>
		<?php }?>
		<?php if ($iduser!=null)
		{?>
			<div data-role="fieldcontain" style="display:none;">
				<label for="name" ><strong class="red">*</strong> Opcion</label>
				<input type="text" name="opc" id="eidEst" value="user,<?php echo $iduser;?>"/>
			</div>
		<?php }?>
			<label for="archivo">Archivo (el archivo debe ser con extensión 'jpg'):</label>
			<input type="file" name="archivo" id="archivo" accept="image/jpeg" capture="camera"/> 
			<br />
			<br>
			<input type="submit" name="submit" value="Enviar" />
		</form>
		<div class="volver">
				<input type="button" onclick="window.close();" value="Salir">
				
		</div> 
	
	</body>
</html>
<?php 
}
?>
