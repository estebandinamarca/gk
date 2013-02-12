<?php
require_once 'src/classes/controlMensajes.class.php';

if($_POST)
{
	if(isset($_POST['msgIdFrom']))$idFrom=$_POST['msgIdFrom']; else $idFrom=null;
	if(isset($_POST['msgTo']))$idTo=$_POST['msgTo']; else $idTo=null;
	if(isset($_POST['msgSubject']))$subject=$_POST['msgSubject']; else $subject=null;
	if(isset($_POST['msgContent']))$content=$_POST['msgContent']; else $content=null;
	
	if($idTo=="nadie") echo "-2"; //No se enviaron todos los datos
	else
	{
		$data=array($idFrom,$idTo,$subject,$content);
		if(controlMensajeria::enviarMensaje($data)!="-1") echo "1";
		else echo  "-1";
		
		
	}
	
}
else
{
	echo "0";
}

?>