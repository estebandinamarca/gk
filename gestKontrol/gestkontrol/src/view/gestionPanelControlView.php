<?php
require_once 'src/classes/controlConfiguracionGK.class.php';

class gestionPanelControl
{
	
	public function getPanelControl($usuario)
	{
		$correo=controlConfiguracionGK::getConfiguracion(null,'Correos');
		$tarjeta=controlConfiguracionGK::getConfiguracion(null,'Tarjetas');
		?>
		
				<h3>Inicio » Panel de Control </h3>
				<div data-role="collapsible" data-theme="a" data-content-theme="d">
					   <h3>Opciones de Sistema</h3>
					  
					  
				        <label for="flip-5">Envio de correos</label>
				        <select name="flip-5" id="flip-5" data-role="slider" data-theme="c" data-track-theme="a" onchange="activaSlide('Correos',this.value)">
				                <option value="no">No</option>
				                
				                <?php
				                if ($correo->getestado()=="1")
				                { 
				                ?> 
				                	<option value="yes" selected="selected">Yes</option>
				                <?php 
				                }
				                else
				                {
				                ?>
				                	<option value="yes">Yes</option>
				                <?php 
				                } 
				                ?>
				        </select>
				        
				        <hr>
				        
				         <label for="flip-5">Activar Tarjetas de recepción</label>
				        <select name="flip-6" id="flip-6" data-role="slider" data-theme="c" data-track-theme="a" onchange="activaSlide('Tarjetas',this.value)">
				                <option value="no">No</option>
				                <?php
				                if ($tarjeta->getestado()=="1")
				                { 
				                ?> 
				                	<option value="yes" selected="selected">Yes</option>
				                <?php 
				                }
				                else
				                {
				                ?>
				                	<option value="yes">Yes</option>
				                <?php 
				                } 
				                ?>
				        </select>
						
					   
				</div>
				<script>
				function activaSlide(config,estado)
				{
					//alert(funcion+" "+opc);
					if(estado=="yes")estado="1";else estado="0";
					$.get('updateConfiguracionGK.php',{config: config,estado:estado},function(data)
							{
								
								switch (data)
								{
								case "1": 
									$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Informacion',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Cambio Exitoso</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' onClick=\"url=window.location.href;url=url.split('&');window.location.replace(url[0]);window.location.reload();\" rel='close' data-icon='check'>Aceptar</a>"
						    			//  NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
						      		
							      	    break;
								case "0":
									$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Error',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Error en DB</strong></p>"+
						    			  "<p class='centrado'><strong>Contactese con el administrador para solucionar el problema</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			  //NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
						    		  })
						      		
							      	    break;
								case "-2":
									$('<div>').simpledialog2({
						    		    mode: 'blank',
						    		    headerText: 'Error',
						    		    headerClose: true,
						    		    blankContent : 
						    			  "<p class='centrado'><strong>Fallo en la integridad de los datos</strong></p>"+
						    			  "<p class='centrado'><strong>Asegúrese que los datos sean solo numericos y que los campos no esten vacios.</strong></p>"+
						    			  "<a data-role='button' href='#' data-transition='pop' rel='close' data-icon='check'>Aceptar</a>"
						    			  //NOTE: the use of rel="close" causes this button to close the dialog.
						    		      
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
							    			  "<a data-role='button' href='#' data-transition='pop'  rel='close' data-icon='check'>Aceptar</a>"
							    		      
							    		      // NOTE: the use of rel="close" causes this button to close the dialog.
							    		      
							    		  })
								}
							
							});
					

				}
				</script>
		
		
		<?php 			
	}
	public function vistasPanelControl()
	{
		?>
		<div data-role="page" id="Panel-de-control">
			<div data-role="content" id="content-Panel-de-control"></div>
		</div>
						
					
		<?php 
	}
	
}
?>