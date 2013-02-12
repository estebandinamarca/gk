function objetoAjax(){
	    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (E){
            xmlhttp = false;
        }
    }
    
    if (!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function onMouse()
{
	var objeto= document.getElementById("Plano");
	objeto.style.backgroundImage="url(src/imgControl/Piso1Cof.10.png)"; 
}
function outMouse()
{
	
	var objeto= document.getElementById("Plano");
	objeto.style.backgroundImage="url(src/imgControl/Piso1CInicio.png)";
}
function TableEsta(num)
{
	if(num==1)
	{
		var x=document.getElementById('tabDetMedidor').style.display='none';
	}	
}
function Control()
{
	var x = document.getElementById('Region').value;
	alert(x);
}
function updata()
{
	var y = document.getElementById('region').value;
	var x = document.getElementById('comuna').value;
	var z = document.getElementById('tipo').value;
	var w = document.getElementById('propietario').value;
	//alert(y+" "+x+" "+z);
	var data ="?"+"region="+y+"&"+"comuna="+x+"&"+"tipo="+z+"&"+"propietario="+w; 
	getUrl(data);
	
}

function getUrl(data)
{
	
    //el div donde se mostrara los resultados
divResultado = document.getElementById('tabDetalle');    
        // hacemos un aleatorio
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
    //uso del medotod GET
	//var url="listar.php"
	//url=url+"1";
	//alert("ALERT ALERT!!!");
    ajax.open("GET","./dinamiTablePropiedad.php"+data,true);
    //ajax.open("GET",url,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText;
        }
    };
    ajax.send(null);
	
}
function Sector()
{
	
	
	    // Obtengo el select que el usuario modifico
	    var selectOrigen=document.getElementById("region");
	   
	    // Obtengo la opcion que el usuario selecciono
	    var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	    // Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona estado..."
	    if(opcionSeleccionada==0)
	    {
	        var selectActual=null;
	        if(idSelectOrigen == "cboestado")
	            selectActual=document.getElementById("comuna");
	        selectActual.length=0;
	        var nuevaOpcion=document.createElement("option");
	        nuevaOpcion.value=0;
	        nuevaOpcion.innerHTML="Seleccione Estado";
	        selectActual.appendChild(nuevaOpcion); 
	        selectActual.disabled=true;
	    }
	    // Compruebo que el select modificado no sea el ultimo de la cadena
	    else{
	        if(idSelectOrigen == "cboestado")
	            var selectDestino=document.getElementById("comuna");
	        // Creo el nuevo objeto AJAX y envio al servidor la opcion seleccionada del select origen
	        var ajax=nuevoAjax();
	        ajax.open("GET", "../TransSBRJ/llenacomunas.php?opcion="+opcionSeleccionada+"&select="+idSelectOrigen, true);
	        ajax.onreadystatechange=function()
	        {
	            if (ajax.readyState==1)
	            {
	                // Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
	                selectDestino.length=0;
	                var nuevaOpcion=document.createElement("option");
	                nuevaOpcion.value=0;
	                nuevaOpcion.innerHTML="Cargando...";
	                selectDestino.appendChild(nuevaOpcion);
	                selectDestino.disabled=true;   
	            }
	            if (ajax.readyState==4)
	            {
	                selectDestino.parentNode.innerHTML=ajax.responseText;
	            }
	        };
	        ajax.send(null);
	    
   }	
}
/*function capMedDato(nSerie){

			var med =nSerie;
			var num ="?"+"num="+1;
			//alert("guardado :"+med);
			GuardarCookie("medidor",med,4);
			getDetalleMedidor(num);			
			//TableEsta();
			//getDetalleMedidor(medidor);
			//medidor=med;
        //alert("guardado :"+med);
        //TableEsta();
		/*var x = document.getElementById('marca').value;
		//var y = document.getElementById('familia').value;
		var datos;
			alert("Dato:"+x);
		if (typeof x!='undefined')
		{														
			//GuardarCookie("selec",x,1);
			datos= "?"+"marca="+x;
			//alert("Prueba"+datos);
			//
		}
		if (typeof y!='undefined')
		{
			//GuardarCookie("familia",y,1);
			datos= datos+"&"+"familia="+y;
			//alert("Prueba"+datos);
			//getDetalleProducto(datos);
		}
		//alert("MMMMMMM javaScript");
		getDetalleProducto(datos);*/
		/*
		
	
}

function ejec(num)
{
	//$.ajaxSetup({ cache: false });
	if(num==1)
	{
		var tab="?"+"num="+num;
	   getCargaCuerpoBienRaiz(tab);
	}
	if(num==2)
	{
		var tab2="?"+"num="+num;
		getCargaCuerpoBienRaiz(tab2)
		//alert("asda"+num);
	}
	if(num==3)
	{
		var tab2="?"+"num="+num;
		getCargaCuerpoBienRaiz(tab2)
	}
}
function EnviaPrecio()
{
var z = document.getElementById('precio').value;
//alert("dato"+z);
//GuardarCookie("precio",z,1); // EN PRUEBAS AUN!! NO OCUPAR.
//getDetalleProducto();
}

function TablaCar(num,codigo,precio){
var x = document.getElementById(num).value;
var y= codigo;
var z=precio; 
var dato= "?"+"num="+x+"&"+"codigo="+y+"&"+"precio="+z;
//alert(dato);
//return dato;
//GuardarCookie(num,dato,1);
CargaCarro(dato);
//updatecarro();
}
function CantidadPuntoV(num,codigo,precio)
{
var cantidad=document.getElementById(num).value;
var dato= "?"+"cantidad="+cantidad+"&"+"codigo="+codigo;
puntoDeVentas(dato);
}
function updatecarro()
{ // no esta en funcionamiento 
Cargatotal();
//alert("entro");
//CargaCarro();
}
function modificarEstado(id,nomcheck)
{
if(document.getElementById(nomcheck).checked)
		document.getElementById(id).disabled =false;
	else
		document.getElementById(id).disabled=true;

}
function modificarEstandar()
{
	var x = document.getElementById('Tipo').value;
	if(x=="Empresa")
	{
	  document.getElementById('giro').disabled= false;
	}
	else
	{
	 document.getElementById('giro').disabled= true;
	}
}
function verificador()
{
 var x=document.getElementById('Codbarra').value;
 var dato="?"+"codigo="+x;
 verificaEstado(dato);
}

function GuardarCookie (nombre, valor, caducidad) {  
    if(!caducidad)  
        caducidad = Caduca(0)  
  
    //crea la cookie: incluye el nombre, la caducidad y la ruta donde esta guardada  
    //cada valor esta separado por ; y un espacio  
    document.cookie = nombre + "=" + escape(valor) + "; expires=" + caducidad + "; path=/"  
}  
function Caduca(dias) {  
    var hoy = new Date();                    //coge la fecha actual  
    var msEnXDias = eval(dias) * 24 * 60 * 60 * 1000    //pasa los dias a mseg.  
  
    hoy.setTime(hoy.getTime() + msEnXDias);          //fecha de caducidad: actual + caducidad  
    return (hoy.toGMTString());
}
function getDetalleMedCliente(num)
{
	    
    //el div donde se mostrara los resultados
divResultado = document.getElementById('DatosMedidor');    
        // hacemos un aleatorio
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
    //uso del medotod GET
	//var url="listar.php"
	//url=url+"1";
	//alert("ALERT ALERT!!!");
    ajax.open("GET","./VistaDetMedidor.php"+num,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
	
}
function getDetalleMeDato(num){

    
    //el div donde se mostrara los resultados
divResultado = document.getElementById('DatosMedidor');    
        // hacemos un aleatorio
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
    //uso del medotod GET
	//var url="listar.php"
	//url=url+"1";
	//alert("ALERT ALERT!!!");
    ajax.open("GET","./VistaDetMedidor.php"+num,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)

}
  
function getCargaCuerpoBienRaiz(num){

    
    //el div donde se mostrara los resultados
divResultado = document.getElementById('subCuerpo');    
        // hacemos un aleatorio
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
    //uso del medotod GET
	//var url="listar.php"
	//url=url+"1";
	//alert("ALERT ALERT!!!");
    ajax.open("GET","./SelecVista.php"+num,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)

}
function CargaCarro(dato){
	//alert(dato);
	divResultado = document.getElementById('carga_carro');    
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
	//alert("ALERT ALERT!!!");
    ajax.open("GET", "./ContenidoCarro.php"+dato,true); 
	
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function()
	{  
        if (ajax.readyState==4) { 
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
		Cargatotal();
        }
    }
		
    ajax.send(null)

}
function Cargatotal(){
	//alert(dato);
	divResultado = document.getElementById('total');    
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
	//alert("ALERT ALERT!!!");
    ajax.open("GET", "./cargatotal.php",true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)

}    
function MostrarConsulta(datos){

        divResultado = document.getElementById('resultado');

        ajax=objetoAjax();

        ajax.open("GET", datos);

        ajax.onreadystatechange=function() {

               if (ajax.readyState==4) {

                       divResultado.innerHTML = ajax.responseText

               }

        }

        ajax.send(null)

}
function puntoDeVentas(datos)
{
divResultado = document.getElementById('Punto_ventas');    
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
	//alert("ALERT ALERT!!!");
    ajax.open("GET", "./capturaPuntoVentas.php"+datos,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
 
}
function verificaEstado(dato)
{
divResultado = document.getElementById('verificar');    
    var id=Math.random();
    //instanciamos el objetoAjax
    ajax=objetoAjax();
	//alert("ALERT ALERT!!!");
    ajax.open("GET", "./verificador.php"+dato,true); 
	// aqui es donde se ejecuta la funcion ajax y llama el tablaphp quien carga la tabla en la pantalla. 
	//alert(ajax.open("GET", url ,true));
    ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
        //mostrar resultados en esta capa
        divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
}
*/