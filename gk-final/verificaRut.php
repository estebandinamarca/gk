<?php
require_once 'src/classes/controlNumerico.class.php';

if(isset ($_GET['rut']))$rut = $_GET['rut']; else $rut=null;
if(isset ($_GET['dv']))$dv = $_GET['dv']; else $dv=null;

if (controlNumerico::validadorRut($rut,$dv))echo "1";
else echo "0";



?>