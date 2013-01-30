function onMouse(valor)
{
	var objeto= document.getElementById("Plano");
	if(valor==1)
	{
		objeto.style.backgroundImage="url(src/imgControl/Piso1Cof.10.png)";
	}
	if(valor==2)
	{
		objeto.style.backgroundImage="url(src/imgControl/Piso1Cof.9.png)";
	} 
}
function outMouse()
{
	
	var objeto= document.getElementById("Plano");
	objeto.style.backgroundImage="url(src/imgControl/Piso1CInicio.png)";
}
function camuna()
{
	alert("hola");
}