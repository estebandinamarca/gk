<?php
//setcookie ("PHPSESSID", "", time() - 1);
session_start();
if(!isset($_SESSION["usuario_gk"]))  header("Location: login.php");
$est=isset($_GET['est'])?$_GET['est']:"todos";
/*print_r($_GET['est']);
print_r($_COOKIE);*/

?>

  
  <link href="wdCalendar/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
  <link href="wdCalendar/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" /> 
  <link href="wdCalendar/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />   
  <link href="wdCalendar/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" /> 
  <link href="wdCalendar/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />

    <!---Estilos Fabián---->
  <link href="src/css/estilos_f.css" rel="stylesheet" type="text/css" />
  
 
  
  

<script type="text/javascript">

        $(document).ready(function() {  
        	//$("#estacionamientoRQ").val('<?php echo $_GET['est'];?>');

        	var view="week";          
            var DATA_FEED_URL = "datafeed.php";
            var estaGlobal='<?php echo $est;?>';
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
                url: DATA_FEED_URL + "?method=list&est="+estaGlobal,  
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
            	
            	var eurl="";
               eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&est={5}&title={1}";
              
                if(data)
                {
                    var url=StrFormat(eurl,data);;
                   
                    
                    //estaGlobal;
                   // alert(url); 
                     //url=url+"&est="+estaGlobal;
                    OpenModelWindow(url,{ width: 600, height: 460, caption:"Agendar Visita",onclose:function(){
                      $("#gridcontainer").reload();
                       
                    }});
                   
                    //alert($("#estacionamientoRQ").val());
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
                var url ="edit.php?est=<?php echo $est;?>";
                
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

            //---------------------------------------//
            
            
        });
    </script>    

      <div id="calhead">
      	<!--  div class="cHead"><div class="ftitle">Reserva Rápida</div-->
          <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando...</div>
          <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Por el momento no podemos cargar el contenido...</div>
        </div>          
        

	    <div class="ui-grid-a">
	      <div class="ui-block-a">
	        <!-- <div id="caltoolbar" class="ctoolbar">            
	            <div data-role="fieldcontain"> -->
	            <div >
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
	      </div>
      
          
      
	    <div class="ui-block-c" >
	  	<!-- <div id="caltoolbar" class="ctoolbar ctoolbar-right"> -->
	         <div class="ui-block-c-c">
	            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
	            <div class="semamas_f">	
	            	<a href="#" id="txtdatetimeshow">Esta Semana</a>  
	              <a href="#" id="sfprevbtn" data-role="button" data-icon="arrow-l">Anterior</a>
	              <a href="#" id="sfnextbtn" data-role="button" data-icon="arrow-r" data-iconpos="right">Siguiente</a>
	              </div>
	            </div>
	        </div>    
	        <!-- </div> -->
	
	    </div>      
    </div>

  </div>

      <div>
        <div class="t1 chromeColor">&nbsp;</div>
        <div class="t2 chromeColor">&nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
          <div id="gridcontainer" style="overflow-y: visible;"></div>
        </div>
        <div class="t2 chromeColor">&nbsp;</div>
        <div class="t1 chromeColor">&nbsp;</div>   
      </div>
     
    