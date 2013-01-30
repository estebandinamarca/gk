function evaluateSubmit(Cadena, Cadena2){
	var Fecha= new String(Cadena); // Crea un string
	var Fecha2 = new String(Cadena2);
	var RealFecha= new Date();	// Para sacar la fecha de hoy
	// Cadena AÃ±o document.getElementById('tr1').style.backgroundColor = '#F78181';
	var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length));
	// Cadena Mes
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")));
	// Cadena DÃ­a
	var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")));

	// Cadena AÃ±o
	var Ano2= new String(Fecha2.substring(Fecha2.lastIndexOf("-")+1,Fecha2.length));
	var Mes2= new String(Fecha2.substring(Fecha2.indexOf("-")+1,Fecha2.lastIndexOf("-")));
	var Dia2= new String(Fecha2.substring(0,Fecha2.indexOf("-")));

	if(Cadena.length==0 && Cadena2.length==0){
		document.getElementById("lecturaActual").style.backgroundColor = '#F78181';
		document.getElementById("lecturaActual").style.border = 'solid 1px #000';
		document.getElementById("lecturaAnterior").style.backgroundColor = '#F78181';
		document.getElementById("lecturaAnterior").style.border = 'solid 1px #000';
		alert('Campos de Fechas Vacios');
		return false;
	}

	if(Cadena.length==0){
		document.getElementById("lecturaAnterior").style.backgroundColor = '#F78181';
		document.getElementById("lecturaAnterior").style.border = 'solid 1px #000';
		alert('Campo Fecha Anterior Vacio');
		return false;
	}

	if(Cadena2.length==0){
		document.getElementById("lecturaActual").style.backgroundColor = '#F78181';
		document.getElementById("lecturaActual").style.border = 'solid 1px #000';
		alert('Campo Fecha Actual Vacio');
		return false;
	}

	var hoy = '';
	if((RealFecha.getMonth()+1)<10)
		hoy = RealFecha.getFullYear()+'-0'+(RealFecha.getMonth()+1)+'-'+RealFecha.getDate();
	else
		hoy = RealFecha.getFullYear()+'-'+(RealFecha.getMonth()+1)+'-'+RealFecha.getDate();

	if(hoy<invertir(Fecha)){
			document.getElementById("lecturaAnterior").style.backgroundColor = '#F78181';
			document.getElementById("lecturaAnterior").style.border = 'solid 1px #000';
			alert('Fecha anterior ingresada es mayor a hoy ');
			return false;
	}

	if(hoy<invertir(Fecha2)){
			document.getElementById("lecturaActual").style.backgroundColor = '#F78181';
			document.getElementById("lecturaActual").style.border = 'solid 1px #000';
			alert('Fecha actual ingresada es mayor a hoy '+hoy);
			return false;
	}

	if(invertir(Fecha)>invertir(Fecha2)){
			document.getElementById("lecturaAnterior").style.backgroundColor = '#F78181';
			document.getElementById("lecturaAnterior").style.border = 'solid 1px #000';
			alert('Fecha anterior ingresada es mayor a Fecha actual');
			return false;
	}

  //para que envie los datos, quitar las  2 lineas siguientes
  //alert("Fecha correcta.")
  //return false
}

function invertir(fecha){
	return (fecha.substring(fecha.lastIndexOf("-")+1,fecha.length)+'-'+fecha.substring(fecha.indexOf("-")+1,fecha.lastIndexOf("-"))+'-'+fecha.substring(0,fecha.indexOf("-")));
}