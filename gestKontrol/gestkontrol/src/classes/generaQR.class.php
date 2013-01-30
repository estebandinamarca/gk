<?php
require_once ("src/classes/phpqrcode.php");

class generaQR
{
	const rutaImagenQR = "/var/www/html/gestkontrol/src/gqr/";
	const calidad = "Q";
	const sizeS = "6";
	const meD = "2"; 
	
	//QRcode::png($url,$img,"Q","5",2);
	
	public function creaQR($codigo,$rutaImagen=null,$nombreImagen,$calidadQR=null,$size=null,$med=null)
	{
		if($rutaImagen=="" || $rutaImagen==null)
		{
			$rutaImagen = self::rutaImagenQR;
		}
		if($calidadQR==null)
		{
			$calidadQR = self::calidad;
		}
		if($size==null)
		{
			$size = self::sizeS;
		}
		if($med==null)
		{
			$med = self::meD;
		}
		//echo $codigo."_".$rutaImagen."_".$nombreImagen."_".$calidadQR;
		//echo $codigo."_".$rutaImagen.$nombreImagen."_".$calidadQR."_".$size."_".$med;
	 	QRcode::png($codigo,$rutaImagen.$nombreImagen,$calidadQR,$size,$med);	
		 return $nombreImagen;
		
	}
	
}
?>
