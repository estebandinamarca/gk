<?php
if (isset($_GET['id']))$id=$_GET['id'];else $id=null;
if (isset($_GET['op']))$op=$_GET['op'];else $op=null;

switch ($op)
{
	case "vis":
		if (file_exists('src/img/visitas/'.$id.'.jpg')) echo "1";
		else echo "0";
		break;
	case "pro":
		if (file_exists('src/img/proveedor/'.$id.'.jpg')) echo "1";
		else echo "0";
		break;
	case "cli":
		if (file_exists('src/img/clientes/'.$id.'.jpg')) echo "1";
		else echo "0";
		break;
	case "user":
		if (file_exists('src/img/usuarios/'.$id.'.jpg')) echo "1";
		else echo "0";
		break;
}



?>