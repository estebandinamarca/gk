<?php
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/controlEstacionamiento.class.php');


class gestionCalendarioView
{
	public function getCalendario($cliente)
	{
		
	?>
		
		<div style="position:relative; width:auto; height:100%;">
			<div class="fechas_cal">
				<select name="select-choice-min" id="select-choice-min" data-mini="true" data-inline="true">
					<option value="todos">Estacionamientos: Todos</option>
					<?php
					//echo $usuario->getidCliente();
					$estacionamientos=controlEstacionamiento::getEstacionamientoCliente($cliente);
					if(count($estacionamientos)>0)
					{
						foreach($estacionamientos as $result)
						{
							if($result->getvisita()==1){
						?>
							<option value='<?php echo $result->getnumero();?>'>Estacionamiento: <?php echo $result->getnumero(); ?></option>
						<?php 
							}
						}
					}
					?>
				</select> 
			</div>
		</div>   

		<div id="contenidoCalendario"></div><!-- fin contenidoCalendario -->

		<script> 
		    $(document).ready(function() {  

		    	//
		    	/*var altura=document.documentElement.clientHeight;
		    	//alert(altura-500);
		    	altura-=500;
		    	$('#gridcontainer').css('height',altura+'!important');
		    	$('#dvtec').css({'height':altura+'!important'});*/
		
		    	$('#contenidoCalendario').empty();	
				$('#contenidoCalendario').load("contenidoCalendario.php?est=todos",function(){
						$('#contenidoCalendario').trigger('create');
				});
		    	$("#select-choice-min").change(function(){
		
		    		var estak = document.getElementById("select-choice-min").value;  
		    		//alert(estak);
		    		
		    		//alert(window.estaGlobal);
		    		
		    		$('#contenidoCalendario').empty();	
		    		$('#contenidoCalendario').load("contenidoCalendario.php?est="+estak,function(){
		   				$('#contenidoCalendario').trigger('create');
		    		});
		    	});
		    });
        </script>
		<?php 
		
	}
	
	public function vistasCalendario()
	{
		?>
		<div data-role="page" id="calendario" style=" margin-top : 0px;">
			<div class="calendario_margen"></div>
			<div data-role="content" id="content-calendario"></div>
		</div>
	<?php 
	}
}
?>