<?php
require_once ('src/classes/controlCliente.class.php');
if($_GET!=null)
{
	//echo "hola1";
	$dataOficinas = controlCliente::getDetalleCliente($_GET["pisoR"]);
	?>
		
				  <?php
				 //echo "hola2"; 
				  	if(count($dataOficinas)>0)
				  	{
				  		//echo "hola3";
				  		foreach ($dataOficinas as $oficinas)
				  		{
				  ?>
				  		<option value="<?php echo $oficinas->getidDetallecliente();?>"><?php echo $oficinas->getoficina();?></option>
				  <?php 
				  		}
				  	}
				  ?>
				
	<?php 
}
?>