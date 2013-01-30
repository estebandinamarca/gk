<?php
require_once 'src/classes/controlMensajes.class.php';
require_once 'src/classes/controlReserva.class.php';
require_once 'src/classes/controlVisita.class.php';
require_once 'src/classes/controlVisitasEnEspera.class.php';

if (isset($_GET['privilegio']))$privilegio=$_GET['privilegio']; else $privilegio=null;
if (isset($_GET['idUsuario']))$idUsuario=$_GET['idUsuario']; else $idUsuario=null;
if (isset($_GET['idCliente']))$idCliente=$_GET['idCliente']; else $idCliente=null;


$mensajes=controlMensajeria::getMensajes($idUsuario,"Recibidos");
$cont=0;
$contVisEsp=controlVisita::getVisitasEspera($idCliente,"1");

foreach($mensajes as $contadorMensajes)
{
	if($contadorMensajes->getestado()=="No Leido") $cont++;
}
?>
	<li class="menu_right principal menu-mensajes"><a id="cantCorreo"  href="#bandeja-entrada" onClick="location.replace('index.php#bandeja-entrada');" class="drop botonVistaMensaje"><?php if ($cont>0){?><span><?php echo $cont;?></span><?php }?></a><!-- Begin 4 columns Item -->
             
    </li>
    <script>
    $(".botonVistaMensaje").bind('tap',function (){
		 
		 var atributo=$(this).attr("href");
		 //alert("boton apretado");
		 atributo=atributo.split("#");
		 //alert(atributo[1]);
		 atributo1="content-"+atributo[1]; 
			
		 $('#'+atributo1).load('cargadorVistasMensajeria.php?do='+atributo1+'',function(){
			 $('#'+atributo1).trigger('pagecreate');
			});
			 
	 });
    $(".botonVistaUsuario").bind('tap',function (){
		 
		 var atributo=$(this).attr("href");
		 //alert("boton apretado");
		 atributo=atributo.split("#");
		 //alert(atributo[1]);
		 atributo1="content-"+atributo[1]; 
			
		 $('#'+atributo1).load('cargadorVistasUsuario.php?do='+atributo1+'',function(){
			 $('#'+atributo1).trigger('pagecreate');
			});
		 
	 });
    </script>

    
    <!-- End 4 columns Item -->


<?php 
if($privilegio>2)
{
	$totalVisitasHoy=controlReserva::contadorVisitasHoy(null,$idCliente);
	$visitasHoyManana=controlReserva::contadorVisitasHoy("manana",$idCliente);
	$visitasHoyTarde=controlReserva::contadorVisitasHoy("tarde",$idCliente);
	$totalVisitasSemana=controlReserva::contadorVisitasSemana(null,$idCliente);
	$visitasSemanaManana=controlReserva::contadorVisitasSemana("manana",$idCliente);
	$visitasSemanaTarde=controlReserva::contadorVisitasSemana("tarde",$idCliente);
	$visitasEspera=controlVisitasEnEspera::getVisitasEnEspera(null,$idCliente);
	if(count($visitasEspera)>0)
	{
		
		foreach($visitasEspera as $visEsp)
		{
			
			$t1=strtotime($visEsp['horaDeInicio']);
			$t2=strtotime(date('Y-m-d H:i:s'));
			//echo $visEsp['horaDeInicio']->diff(date('Y-m-d H:i:s'));
			//echo "<br>".. " minute";
			if(round(abs($t2 - $t1) / 60)>5 && $visEsp['envioCorreo']==0)
			{ 
				//echo "Envio Correo de: ".print_r($visEsp);
				//echo '<script>alert("VISITA EN ESPERA!");</script>';
				echo '<script>alert("Tiene una visita en Espera!. Dirijase al modulo Visitas en Espera.");</script>';
				
			}
			
		}
	}

?>

		<li class="menu_right principal"><a href="#lista-visitas-en-espera" class="drop"><img src="src/img/time-menu.png" onClick="location.replace('index.php#lista-visitas-en-espera');"><?php if ($contVisEsp>0) {?><span class="rojo"><?php echo $contVisEsp;?></span><?php }?></a>
			<div class="dropdown_1column align_right">
	    		<div class="col_1">
	    		<ul class="greybox">
	    			<li><a href="#lista-visitas-en-espera" onClick="location.replace('index.php#lista-visitas-en-espera');">Visitas en espera</a></li>
	    		</ul> 
	    		</div> 
	    	</div>
		</li>

          <li class="menu_right principal menu-semana"><a href="#"><?php if ($totalVisitasSemana>0){?><span><?php echo $totalVisitasSemana;?></span><?php }?></a><!-- Begin 3 columns Item -->
              <div class="dropdown_1column align_right">
                  <div class="col_1">
                    <h2>Semana</h2>
                  </div>                
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">Total: <strong><?php echo $totalVisitasSemana;?></strong></a></li>
                      </ul>   
                  </div>
                  
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">En la mañana: <strong><?php echo $visitasSemanaManana;?></strong></a></li>
                      </ul>   
                  </div>

                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">En la tarde: <strong><?php echo $visitasSemanaTarde;?></strong></a></li>
                      </ul>   
                  </div>
               </div>
            </li>
            <li class="menu_right principal menu-dia"><a href="#"><?php if ($totalVisitasHoy>0){?><span><?php echo $totalVisitasHoy; ?></span><?php }?></a>
            
              <div class="dropdown_1column align_right">
                  <div class="col_1">
                    <h2>Hoy</h2>
                  </div>
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">Total: <strong><?php echo $totalVisitasHoy; ?></strong></a></li>
                      </ul>   
                  </div>
                  
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">En la mañana: <strong><?php echo $visitasHoyManana; ?></strong></a></li>
                      </ul>   
                  </div>

                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="nueva-visita-calendario.php" rel="external" class="ui-link-inherit">En la tarde: <strong><?php echo $visitasHoyTarde; ?></strong></a></li>
                      </ul>   
                  </div>
              </div>  
          </li>
<?php 
}
?>
     