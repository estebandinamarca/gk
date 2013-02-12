<?php 
require_once ('functions.php');
require_once ('src/classes/controlReserva.class.php');
require_once ('src/classes/controlVisita.class.php');
require_once ('src/classes/controlCliente.class.php');
require_once ('src/classes/usuario.php');


session_start();
if(!isset($_SESSION["usuario_gk"]))  header("Location: login.php");
//print_r($_GET);
//print_r($_POST);
$visitaA = null;
$usuario = $_SESSION["usuario_gk"];
//print_r($usuario->getidCliente());
//echo $usuario->getidCliente(); 
$idCliente = $usuario->getidCliente();
$reserva = controlReserva::getReservaAuxId(isset($_GET["id"])?$_GET["id"]:null);
$fechaInicio = isset($_GET["start"])?$_GET["start"]:"";
$fechaInicio = $fechaInicio!=""?explode(" ",$fechaInicio):"";
$fechaTermino = isset($_GET["end"])?$_GET["end"]:"";
$fechaTermino = $fechaTermino!=""?explode(" ",$fechaTermino):"";
$estacion=isset($_GET['est'])?$_GET['est']:'todos';
//echo print_r($fechaInicio)." ".print_r($fechaTermino);
if($reserva!=null)
{
	$visita = controlVisita::getVisitaWithId($reserva->getidVisita());
}
if($usuario!=null)
{
	$visitaA = controlVisita::getVisita($usuario->getidCliente(),null);
}
//print_r($visitaA);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta charset="utf-8">
    <title>Calendario</title>    

<script src="wdCalendar/wdCalendar/src/jquery.js" type="text/javascript"></script>

<link href="src/js/autocomplete/jquery.ui.autocomplete.css" rel="stylesheet" type="text/css" />   

<link href="src/js/autocomplete/jquery.ui.base.css" rel="stylesheet" type="text/css" />   
<link href="src/js/autocomplete/jquery.ui.theme.css" rel="stylesheet" type="text/css" />  
<script src="src/js/autocomplete/jquery.ui.core.js"></script>
<script src="src/js/autocomplete/jquery.ui.widget.js"></script>
<script src="src/js/autocomplete/jquery.ui.position.js"></script>
<script src="src/js/autocomplete/jquery.ui.autocomplete.js"></script>
<link href="src/js/autocomplete/demos.css" rel="stylesheet" type="text/css" />

    <link href="wdCalendar/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />       
    <link href="wdCalendar/wdCalendar/css/dp.css" rel="stylesheet" />    
    <link href="wdCalendar/wdCalendar/css/dropdown.css" rel="stylesheet" />    
    <link href="wdCalendar/wdCalendar/css/colorselect.css" rel="stylesheet" />   
     
    <script src="wdCalendar/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>        
    <script src="wdCalendar/wdCalendar/src/Plugins/jquery.form.js" type="text/javascript"></script>     
    <script src="wdCalendar/wdCalendar/src/Plugins/jquery.validate.js" type="text/javascript"></script>     
    <script src="wdCalendar/wdCalendar/src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>        
    <script src="wdCalendar/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>     
    <script src="wdCalendar/wdCalendar/src/Plugins/jquery.dropdown.js" type="text/javascript"></script>     
    <script src="wdCalendar/wdCalendar/src/Plugins/jquery.colorselect.js" type="text/javascript"></script> 

    <script type="text/javascript">
        if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "datafeed.php";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = 0; i < 24; i++) {
                arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) });
            }
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            var estacion='<?php echo $estacion;?>';
            if (estacion!='todos'&&estacion!='0')
            {
            	$('#patente').attr('checked', true);
                
            	$("#patente").show();
				$("#estacionamiento").show();
				$('input[name^="p"]').val("S/P");
				$('select[name^="estacioReservaCalendar"]').val(estacion);
            }
            var chek2 = $("#vehicular").click(function(e){
            	   
                
				if(this.checked)
					{
						$("#patente").show();
						$("#estacionamiento").show();
						$('input[name^="p"]').val("S/P");	
					}
				else
					{
					
						$("#patente").val(2).hide();
						$("#estacionamiento").hide();
						
						$('input[name^="p"]').val("R");	
					}	
					
				
                });
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            $("#Savebtn").click(function() { $("#fmEdit").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
                    var param = [{ "name": "calendarId", value: 8}];                
                    $.post(DATA_FEED_URL + "?method=remove",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    CloseModelWindow(null,true);                            
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
            
           $("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>"});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }
                }
            };
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            $("#fmEdit").validate({
                submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#fmEdit");             
                error.appendTo(form).css(newpos);
            }
        });
    </script>      
    <style type="text/css">     
    .calpick     {        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("wdCalendar/wdCalendar/sample-css/cal.gif") no-repeat center -3px;        
        margin-left:-22px;    
    }      
/*    .mask{
        width:100%;
        height:100%;
        position:absolute;
        background-color:grey;
        z-index:1;
        filter:alpha(opacity=80);
        opacity:.8;
    }
    .mask div{
        width: 50%;
        text-align:center;
        position: absolute; 
        top: 50%;
        left: 25%;
        color:white;*/
        
    }
    </style>

<!-- Autocomplete! -->
    <script type="text/javascript">
    $(function() {
        var datasn ;
        <?php 
        	$dataSvis = "";
        	$and = true;
        	foreach ($visitaA as $vi)
        	{
        		$dataSvis.=$and?$vi->getnombre()."*".$vi->getapellido():"_".$vi->getnombre()."*".$vi->getapellido();
        		$and = false; 
        		
        	}
        	//$dataSvis=str_replace("'", " ", $dataSvis);
        	//$dataSvis=str_replace('"',"", $dataSvis);
        	//$dataSvis= preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($dataSvis, ENT_QUOTES));
        	//html_entities($dataSvis);
        	//echo $dataSvis;
        	
        	
        ?>
               datasn =  "<?php echo $dataSvis;?>"; //Soporte para comillas simples y caractres especiales
               //alert(datasn);
               var array_js = datasn.split("_");
               
               for(var i=0;i<array_js.length;i++)
               {
                   array_js[i]=array_js[i].replace("*","  ");
               }
              // alert(array_js);
               
        $( "#Nombre" ).autocomplete({
            source: array_js,
            focus: nombreFoco,
            minLength: 2,
            select: capturaDataText
            
        });
       
     
    });

    function nombreFoco(event, ui)
    {
        var nombreCompleto = ui.item.value.replace('*',' ');
        //console.log(nombreCompleto);
        //  
        event.preventDefault(); 
    	//$("").val("hola");
    }
    function capturaDataText(event, ui)
    {
		var nombreCa = ui.item.value;
		//alert(nombreCa);
		var corNom = nombreCa.split("  ");
		var nombre = null;
		var apellido = null;
		//alert(corNom);
		        /*
		        	controlar cuando hay mas de 1 nombre y mas de 1 aplellido.....
		        
		        */      
		       
		 if(corNom.length>2)
			 {
				for(var i=0; i< corNom.length; i++)
					{
						if(i<2)
							{
								nombre = nombre==null? nombre= corNom[i]: nombre+" "+corNom[i];
							}
						else
							{
								apellido = apellido==null? apellido= corNom[i]: apellido+" "+corNom[i];
							}
					}
			 }
		 else
			 {
				 nombre = corNom[0]; 
				 apellido = corNom[1];
				 
			 }          
		 
		//alert(nombre+" "+apellido);	
		console.log(nombre+" "+apellido);
		var corteD;
		var datacv;
		var idC    = '<?php echo $idCliente; ?>';
				 	$.get("capCargaAutoCom.php",{'idC':idC,'nombre':nombre,'apellido': apellido},function(datos){	
				 		//alert(datos+" nombre->" + nombre + " apellido->" + apellido);
						corteD = datos.split("_");
						//alert(datos);
						 $( "#Nombre" ).val(nombre);
						if(corteD[0]==1)
							{
							 datacv = corteD[1].split("*");
							 //alert(datacv[0]);				 
							 $("#Apellido").val(datacv[1]);
							 $("#idvP").val(datacv[0]);	
							 if(datacv[2]==0)
								 {
									 $("#Mail").val("S/C");
								 }
							 else
								 {
								 	$("#Mail").val(datacv[2]);
								 }
							 
							}
					 });
				
    }
    </script>

  </head>
  <body>  
    <!--  <div class="mask">
      <div>This feature is disabled. Please download this plugin and install it in your machine for full features</div>
    </div>-->  
    <div>      
      <div class="infocontainer">       
        <form action="datafeed.php?method=adddetails<?php echo $reserva?"&id=".$reserva->getidReserva()."&idc=".$usuario->getidCliente()."&idv=".$reserva->getidVisita():"&idc=".$usuario->getidCliente(); ?>" class="fform" id="fmEdit" method="post">                 
          <label for="Nombre"><span>* Nombre de la visita:</span></label>
            <input MaxLength="200" class="required safe" id="Nombre" name="Nombre" style="width:85%;" type="text" value="<?php echo isset($visita)?$visita->getnombre():""; ?>" />                     
          <label><span>* Apellido de la visita:</span></label>
            <input MaxLength="200" class="required safe" id="Apellido" name="Apellido" style="width:85%;" type="text" value="<?php echo isset($visita)?$visita->getapellido():""; ?>" />                     
          <label><span> Mail visita:</span></label>
            <input MaxLength="200" class="" id="Mail" name="Mail" style="width:85%;" type="text" value="<?php echo isset($visita) && $visita->getcontacto()!=0?$visita->getcontacto():""; ?>" />
            <input style="display: none" id="idvP" name="idvP" value="" />                      
        <br>
        <br>
          <label><span>* Fecha y hora de visita:</span></label>           
        <hr>  
            <div>  
              <?php if(isset($reserva) && count($reserva)>0)
              	
               {
              		$fechaE = new DateTime($reserva->getfechaEntrada());
              		$fechaS = new DateTime($reserva->getfechaSalida());
              		//date_format($date, 'd/m/Y H:i:s');
                 	// $sarr =  split(" ",$fechaE->format('m/d/y H:i')); //explode(" ", php2JsTime(mySql2PhpTime($event->StartTime)));
                  	// $earr = split(" ",$fechaS->format('m/d/y H:i')); //explode(" ", php2JsTime(mySql2PhpTime($event->EndTime)));
              		$sarr =  split(" ",date_format($fechaE,"m/d/Y H:i"));
              		$earr = split(" ",date_format($fechaS,"m/d/Y H:i"));
                }?>                    
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" style="padding-left:2px;width:113px;" type="text" value="<?php echo isset($reserva)?$sarr[0]:($fechaInicio!=""?$fechaInicio[0]:""); ?>" />                       
              <input MaxLength="5" class="required time tiempo" id="stparttime" name="stparttime" style="width:46px;" type="text" value="<?php echo isset($reserva)?$sarr[1]:($fechaInicio!=""?$fechaInicio[1]:""); ?>" /> a                      
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" style="padding-left:2px;width:113px;" type="text" value="<?php echo isset($reserva)?$earr[0]:($fechaTermino!=""?$fechaTermino[0]:""); ?>" />                       
              <input MaxLength="50" class="required time tiempo" id="etparttime" name="etparttime" style="width:46px;" type="text" value="<?php echo isset($reserva)?$earr[1]:($fechaTermino!=""?$fechaTermino[1]:""); ?>" />
                                                         
              <label class="checkp" type="hidden" style="display: none;"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox"  value="1" <?php if(isset($reserva) && $reserva==null) {echo "checked";} ?>/>Evento todo el día 
              </label>                    
            </div>                
                             
            
            <br>
            <span><strong>Ubicación</strong></span>
            <hr>
            <label class="alineados">Piso :</label>
                <select id="pisoss" name="pisoss">
            	<option value="0">Seleccione Piso</option>
	             <?php 
				//die($idCliente);
				//print_r($reserva);
				$detalleClientesPiso = controlCliente::getDetalleCliente($usuario->getidCliente(),1,null);
				if($detalleClientesPiso!=null && count($detalleClientesPiso)>0)
				{
					foreach($detalleClientesPiso as $piso)
					{
				?>
					<option value="<?php echo $piso->getpiso();?>" <?php echo isset($reserva) && $reserva!=null && $reserva->getpiso()==$piso->getpiso()?"selected=selected":"";?>><?php echo $piso->getpiso(); ?></option>
				<?php 
					}
				}
				?>	
            </select>    
                        
            <label class="alineados">Oficina :</label>
            <select id="oficinass" name="oficinass">
            	<option value="-1">Seleccione Oficina</option>
	            <?php 
						$dataOficinas = controlCliente::getDetalleCliente($usuario->getidCliente());
						if(count($dataOficinas)>0)
						{
							foreach ($dataOficinas as $ofi)
							{
				  ?>
				  			<option value="<?php echo $ofi->getoficina();?>" <?php echo isset($reserva) && $reserva->getoficina()==$ofi->getoficina()?"selected=selected":"";?>><?php echo $ofi->getoficina();?></option>
				  <?php
							}			  
						}
				  ?>
            </select>          
           <br>  
           <br> 
        <div>
            <label class="checkp"> 
                <input id="vehicular" name="vehicular" type="checkbox" value="1" <?php if(isset($reserva) && $reserva!=null && $reserva->gettipoReserva()=="Vehicular"||$estacion!='todos') {echo "checked";} ?>/>Vehicular
            </label>                 
        </div>

        <div>
            <label id="patente" style="<?php echo isset($reserva) && $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"":"display: none;" ; ?>">
           	<span>Patente:</span>
               	<input MaxLength="200" class="" id="patente" name="p" style="width:40%;" type="text" value="<?php echo isset($reserva)?$reserva->getpatenteVehiculo():"R"; ?>" />
            	
            </label>
            <!-- <br> -->
            <label id="estacionamiento" style="<?php echo isset($reserva) && $reserva!=null && $reserva->gettipoReserva()=="Vehicular"?"":"display: none;" ; ?>">   	
            <span>Estacionamiento:</span>   
            <select id="estacionamiento" name="estacioReservaCalendar">
            <option value="0">Sin estacionamiento</option>
          		 <?php 
						$dataEstacionamiento = controlCliente::getestacionamieto($usuario->getidCliente(),null,null);
						if(count($dataEstacionamiento)>0)
						{
		     				foreach ($dataEstacionamiento as $est)
							{
								if($est->getvisita()==1)
								{
		 			?>
		  				<option value="<?php echo $est->getnumero();?>" <?php echo isset($reserva) && $reserva!=null && $reserva->getestacionamientoAsignado()==$est->getnumero()?"selected=selected":""; ?>><?php echo $est->getnumero();?></option>
		  			<?php
								}
							}			  
						}
	 			 ?>
            </select>                
            </label>    
        </div>                      
          <input id="timezone" name="timezone" type="hidden" value="" />           

        </form>         
      </div>

      <div style="clear: both"></div>
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Guardar">Guardar</span>          
        </a>                           
       <!--  <?php if(isset($reserva) && $reserva){ ?>
        <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete(<u>D</u>)
          </span>                
        </a>             
        <?php } ?>  -->           
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Cerrar">Cerrar</span></a>            
      
      </div>                  
    </div>
  </body>
</html>