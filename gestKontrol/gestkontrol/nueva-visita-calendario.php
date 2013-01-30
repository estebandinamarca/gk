<?php
require_once ('src/classes/usuario.php');
require_once ('src/classes/controlUsuario.class.php');
require_once ('src/classes/controlCliente.class.php');
session_start();
if(!isset($_SESSION["usuario_gk"]))  header("Location: login.php");

$usuario = $_SESSION["usuario_gk"];
?>

<!DOCTYPE html>
 
<html> 
<head> 
  <title>Gest Kontrol</title> 
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 

  <link href="wdCalendar/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
  <link href="wdCalendar/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" /> 
  <link href="wdCalendar/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />   
  <link href="wdCalendar/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" /> 
  <link href="wdCalendar/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />

  <script src="src/js/jquery-1.7.1.min.js"></script>
  <script src="src/js/jquery.mobile-1.1.0.min.js"></script> 
  <script src="wdCalendar/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>    
  <script src="wdCalendar/wdCalendar/src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
  <script src="wdCalendar/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>
  <script src="wdCalendar/wdCalendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>    
  <script src="wdCalendar/wdCalendar/src/Plugins/jquery.ifrmdailog.js" type="text/javascript"></script>
  <script src="wdCalendar/wdCalendar/src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
  <script src="wdCalendar/wdCalendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>

  <link rel="stylesheet" href="src/css/jquery.mobile-1.1.0.min.css" /> 
  <link rel="stylesheet" href="src/css/estilos.css" />

    <script type="text/javascript">
        $(document).ready(function() {     

        	$("#select-choice-min").click(function(){

        		var estak = document.getElementById("select-choice-min").value;
        		//alert(estak);
        		
            	});
            var view="week";          
            var DATA_FEED_URL = "datafeed.php";
            var op = {
                view: view,
                theme:3,
                showday: new Date(),
                EditCmdhandler:Edit,
                DeleteCmdhandler:Delete,
                ViewCmdhandler:View,    
                onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest,
                onAfterRequestData: cal_afterrequest,
                onRequestDataError: cal_onerror, 
                autoload:true,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"        
            };
            //alert("asdsad"+DATA_FEED_URL);
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                          
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {
                var t="Cargando Datos...";
                switch(type)
                {
                    case 1:
                        t="Cargando Datos...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="Procesando...";                                   
                        break;
                }
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show();    
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#loadingpannel").html("Hecho!");
                        window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break;
                }              
               
            }
            function cal_onerror(type,data)
            {
                $("#errorpannel").show();
               
            }
            function Edit(data)
            {
               var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";
               
                if(data)
                {
                    var url = StrFormat(eurl,data);
                     
                    OpenModelWindow(url,{ width: 600, height: 460, caption:"Agendar Visita",onclose:function(){
                       $("#gridcontainer").reload();
                       
                    }});
                }
            }    
            function View(data)
            {
            	
                var str = "";
                $.each(data, function(i, item){
                    str += "[" + i + "]: " + item + "\n";
                });
                alert(str);   
                       
            }    
            function Delete(data,callback)
            {           
                //alert(data);
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancelar";  
                hiConfirm("¿Estas seguro de eliminar esta reserva?", 'Confirmar',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
            	
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
            /*
            	$("#showestacionamientoSemanalbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("esta").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            */
            
            $("#showreflashbtn").click(function(e){
                $("#gridcontainer").reload();
            });
            
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="edit.php";
                
                OpenModelWindow(url,{ width: 500, height: 460, caption: "Create New Calendar"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
        });
    </script>    

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
<div data-role="page" id="inicio">



<!-- start content -->
<div data-role="content">

<!-- <div class="ui-grid-a">
   <div class="ui-block-a">
      <div class="titular">
         <img src="src/img/avatar.jpg" width="100" height="100">
         <h4 style="text-align:left">ASDF Enterprices. <br/> Administrador</h4>
      </div>   
   </div>
   <div class="ui-block-b">

      <ul id="menu">

         <li class="menu_right"><a href="#" class="drop"><img src="src/img/sistema-menu.png">Sistema</a>
            <div class="dropdown_1column align_right">
                      <div class="col_1">
                        <ul class="greybox">
                          <li><a href="#">Configuración</a></li>
                        </ul>

                        <ul class="greybox">
                          <li><a href="#">Mi Perfil</a></li>
                        </ul>

                        <ul class="greybox">
                          <li><a href="#">Mi Perfil</a></li>
                        </ul>  
                      </div>
            </div>
         </li>

          <li class="menu_right"><a href="#" class="drop"><img src="src/img/msje-menu.png">Mensajes <span>1</span></a><!-- Begin 4 columns Item -->
             <!--  <div class="dropdown_2columns align_right"><!-- Begin 4 columns container -->
                <!--   <div class="col_2">
                      <h2>Ultimos Mensajes</h2>
                  </div>
                  <div class="col_1">
                      <h3>Recibidos de:</h3>
                      <ul>
                          <li><a href="#">Juan Los Palotes</a></li>
                          <li><a href="#">Nicolas Castillo</a></li>
                          <li><a href="#">ActiveDen</a></li>
                          <li><a href="#">VideoHive</a></li>
                          <li><a href="#">3DOcean</a></li>
                      </ul>   
                  </div>
                  <div class="col_1">
                      <h3>Enviados a:</h3>
                      <ul>
                          <li><a href="#">Nicolas Castillo</a></li>
                          <li><a href="#">Gonzalo Heredia</a></li>
                          <li><a href="#">PsdTuts</a></li>
                          <li><a href="#">PhotoTuts</a></li>
                          <li><a href="#">ActiveTuts</a></li>
                      </ul>   
                  </div>
              </div><!-- End 4 columns container -->
          <!--/li><!-- End 4 columns Item -->

         <!-- <li class="menu_right"><a href="#" class="drop"><img src="src/img/time-menu.png">En Espera <span class="rojo">2</span></a>
            <div class="dropdown_2columns align_right">
                      <div class="col_1">
                        <ul class="greybox">
                          <li><a href="#">Juanito los Palotes Rut: 16381214-2</a><button style="height:10px;" data-mini="true">Hola!</button><button>Hola!</button></li>
                        </ul>

                        <ul class="greybox">
                          <li><a href="#">Juanito los Palotes Rut: 16381214-2</a></li>
                        </ul>  
                      </div>
                      <div class="col_1">
                        <ul class="greybox">
                          <li><a href="#">Juanito los Palotes Rut: 16381214-2</a></li>
                        </ul>

                        <ul class="greybox">
                          <li><a href="#">Juanito los Palotes Rut: 16381214-2</a></li>
                        </ul>  
                      </div>

            </div>
         </li>


          <li class="menu_right"><a href="#" class="drop"><img src="src/img/semana-menu.png">Semanal <span>45</span></a><!-- Begin 3 columns Item -->
              <!--div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
                 <!--  <div class="col_3">
                      <h2>Visitas para esta Semana</h2>
                  </div>
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">Total: (12)</a></li>
                      </ul>   
                  </div>
                  
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">En la mañana: (11)</a></li>
                      </ul>   
                  </div>

                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">En la tarde: (1)</a></li>
                      </ul>   
                  </div>

                  <div class="col_3">
                      <h2>Otros Comentarios</h2>
                  </div>
                  
                  <div class="col_3">
                      <p>Maecenas eget eros lorem, nec pellentesque lacus. Aenean dui orci, rhoncus sit amet tristique eu, tristique sed odio.</p>   
                  </div>       
              </div><!-- End 3 columns container -->
          <!--/li><!-- End 3 columns Item -->



          <!-- <li class="menu_right"><a href="#" class="drop"><img src="src/img/user-menu.png">Hoy <span>12</span></a><!-- Begin 3 columns Item -->
              <!--div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
                 <!--  <div class="col_3">
                      <h2>Visitas para Hoy</h2>
                  </div>
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">Total: (12)</a></li>
                      </ul>   
                  </div>
                  
                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">En la mañana: (11)</a></li>
                      </ul>   
                  </div>

                  <div class="col_1">
                      <ul class="greybox">
                          <li><a href="#">En la tarde: (1)</a></li>
                      </ul>   
                  </div>

                  <div class="col_3">
                      <h2>Otros Comentarios</h2>
                  </div>
                  
                  <div class="col_3">
                      <p>Maecenas eget eros lorem, nec pellentesque lacus. Aenean dui orci, rhoncus sit amet tristique eu, tristique sed odio.</p>   
                  </div>       
              </div><!-- End 3 columns container -->
          <!--/li><!-- End 3 columns Item -->
     <!--  </ul>
       
   </div>    
</div> 
<hr>-->
 <br>
      <div id="calhead" style="padding-left:1px;padding-right:0px;">
        <div class="cHead"><div class="ftitle">Reserva Rápida</div>
          <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando...</div>
          <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Por el momento no podemos cargar el contenido...</div>
        </div>          
        

    <div class="ui-grid-b">
      <div class="ui-block-a">
        <!-- <div id="caltoolbar" class="ctoolbar">            
            <div data-role="fieldcontain"> -->
            <div style="width:auto; height:100%; border-left: 1px solid #CCC; padding: 25px 10px;">
              <fieldset data-role="controlgroup" data-type="horizontal" >
                <input type="radio" name="radio-choice-2" id="radio-choice-21" value="choice-1" />
                <label for="radio-choice-21" id="faddbtn">Nueva Visita</label>

                <input type="radio" name="radio-choice-2" id="radio-choice-22" value="choice-2"  />
                <label for="radio-choice-22" id="showdaybtn">Día</label>

                <input type="radio" name="radio-choice-2" id="radio-choice-23" value="choice-3" checked="checked" />
                <label for="radio-choice-23" id="showweekbtn">Semana</label>

                <input type="radio" name="radio-choice-2" id="radio-choice-24" value="choice-4"  />
                <label for="radio-choice-24" id="showmonthbtn">Mes</label>
              </fieldset>
            </div>
            
              
          <!-- </div>            
        </div> -->    
      </div>
      
     <div class="ui-block-b">
  <!-- <div id="caltoolbar" class="ctoolbar ctoolbar-right"> -->
          <div style="width:auto; height:100%; padding: 25px 10px;">
          <!--<select name="select-choice-min" id="select-choice-min" data-mini="true" data-inline="true">
             <option value="standard">Estacionamientos: Todos</option>
             <option value="0">E: 999</option>             
             <option value="1">E: 1000</option>
             <option value="2">E: 1001</option>
             <option value="3">E: 1002</option>
             <option value="4">E: 1000</option>
             <option value="5">E: 1001</option>
             <option value="6">E: 1002</option>
             <option value="7">E: 1000</option>
             <option value="8">E: 1001</option>
             <option value="9">E: 1002</option>                                   
          </select> --> 
          </div>           
      </div>        
      
    <div class="ui-block-c">
  <!-- <div id="caltoolbar" class="ctoolbar ctoolbar-right"> -->
        <div style="width:auto; height:100%; border-right: 1px solid #CCC; padding: 25px 10px;">
            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
              <a href="#" id="sfprevbtn" data-role="button" data-icon="arrow-l">Anterior</a>
              <a href="#" id="sfnextbtn" data-role="button" data-icon="arrow-r" data-iconpos="right">Siguiente</a>
              <a href="#" id="txtdatetimeshow" style="font-size: 15px; color:#000; padding-left: 15px;">Esta Semana</a>  
            </div>
        </div>    
        <!-- </div> -->

    </div>      
    </div>

  </div>

      <div style="padding:0px;">
        <div class="t1 chromeColor">&nbsp;</div>
        <div class="t2 chromeColor">&nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
          <div id="gridcontainer" style="overflow-y: visible;"></div>
        </div>
        <div class="t2 chromeColor">&nbsp;</div>
        <div class="t1 chromeColor">&nbsp;</div>   
      </div>
     
</div><!-- end content -->

</div><!-- /page -->
</body>
</html>
