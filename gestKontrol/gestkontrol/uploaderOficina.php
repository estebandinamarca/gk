<?php
require_once 'src/classes/controlArchivo.class.php';

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
						<input type="button" onclick="window.location='uploaderOficina.php'" value="Volver">
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
 <title>Subir Archivo de Oficina - GestKontrol</title>
 </head> 
	<body>
	
		<form action="uploaderOficina.php" method="post" enctype="multipart/form-data">
			<div data-role="fieldcontain" style="display:none;">
				<label for="name" ><strong class="red">*</strong> Opcion</label>
				<input type="text" name="opc" id="eidEst" value="of"/>
			</div>
			<label for="archivo">Archivo:</label>
			<input type="file" name="archivo" id="archivo" /> 
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