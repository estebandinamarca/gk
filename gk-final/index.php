<?php
//if(!isset($_SESSION["usuario_gk"])) header("Location: login.php");
require_once ('indexView.php');
require_once ('src/classes/usuario.php');
//session_start();
if(!isset($_SESSION["usuario_gk"])) header("Location: login.php");
beginIndex();
?>
