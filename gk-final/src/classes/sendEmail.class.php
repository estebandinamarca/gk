<?php
require_once ('src/classes/class.phpmailer.php');
require_once ('src/classes/class.smtp.php');

class sendEmail
{
	const ruta = "/var/www/html/gestkontrol/src/gqr/"; // /var/www/html/workspace/gestkontrol/src/gqr/ 	
	const correoFrom = "prueba@prueba.cl";
	const autor = "visitastitanium@gmail.com";
	const pass = " titaniumvisitas123";
	const direccion = "Av.Isidora Goyenechea 2800";
	
	public function  enviarCorreos($host,$from,$fromName,$asunto,$destino,$rutaarchivoAdjunto,$nameArchivoAdjunto,$cuerpoDelMensaje,$cuerpoEnHTMLoPlain)
	{
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = "tls"; 
		$mail->Host = "ssl://smtp.googlemail.com:";//"ssl://smtp.googlemail.com";//smtp.gmail.com";// smtp.googlemail.com"; 
		$mail->Port = 465;
		$mail->Username =  self::autor;
		$mail->Password =  self::pass;
		//$mail->From = self::autor;	
		$mail->FromName = $fromName;
		$mail->Subject = $asunto;
		$mail->AddAddress($destino);
		
		if($rutaarchivoAdjunto!=null && $rutaarchivoAdjunto!= "" && false)
		{
			$mail->AddAttachment(self::ruta.$rutaarchivoAdjunto,$nameArchivoAdjunto);
		}
		
		if($cuerpoDelMensaje!="" && $cuerpoDelMensaje!=null)
		{
			$mail->Body = $cuerpoDelMensaje;
			$mail->IsHTML(true);
			$mail->IsHTML($cuerpoEnHTMLoPlain);
			
			if($mail->Send())
			{
				//print_r($destino);
				//echo "enviado";//.$destino;
				return 1;
			}
			else
			{
				//echo $mail->Send();
				//print_r);
				return -6;
			}
		}
		else 
		{
			/*
			 * Falla reportar en el el log de errores
			 */
			//echo "problemas";
		}	
		

	}
	
	public function generaCuerpoMensaje($data)
	{
		/*
		 * 
		 * Esta funcion es solo para gestkontrol
		 * La cual recibe datos y los empotra en un html para luego ser enviado 
		 * $datos es un array de los datos que son necesario para el cuerpo del correo
		 * 
		 * [0]: Nombre de la empresa que genera la reserva para la visita
		 * [1]: Nombre de la visita
		 * [2]: Fecha Reserva
		 * [3]: Piso
		 * [4]: Oficina
		 * [5]: Tipo Visita
		 * [6]: Estacionamiento
		 * [7]: Nivel Sub
		 * [8]: Numero de Telefono(Empresa)
		 * [9]: Contacto(Empresa)
		 * 
		 */
		
		$mensaje = null;
		 
		 if($data!=null)
		 {
			$mensaje = '<html><body>';
			$mensaje .='Estimado/a tiene un invitacion agendada para reunise con la empresa '.$data[0].' a continuacion los datos de su reserva '; 
			$mensaje .= '<h4>Datos de su reserva</h4>';
			$mensaje .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$mensaje .= "<tr style='background: #eee;'><td><strong>Reserva generada por la empresa :</strong> </td><td>".$data[0]."</td></tr>";
			$mensaje .= "<tr><td><strong>Nombre de la visita:</strong> </td><td>".$data[1]."</td></tr>";
			$mensaje .= "<tr><td><strong>Fecha Entrada:</strong> </td><td>".$data[2]."</td></tr>";
			$mensaje .= "<tr><td><strong>Fecha Termino:</strong> </td><td>".$data[3]."</td></tr>";
			$mensaje .= "<tr><td><strong>Piso :</strong> </td><td>".$data[4]."</td></tr>";
			$mensaje .= "<tr><td><strong>Oficina :</strong> </td><td>".$data[5]."</td></tr>";
			$mensaje .= "<tr><td><strong>Tipo Visita:</strong> </td><td>".$data[6]."</td></tr>";
			
			if(isset($data[7]) && $data[7]!=null )
			{
				$mensaje .= "<tr><td><strong>Estacionamiento :</strong> </td><td> Numero estacionamiento :".$data[7]."</td></tr>";
			}	
			$mensaje .="</table></body>";
			$mensaje .="</html>";
			$mensaje .="<br>";
			$mensaje.= "<h4>Es necesario que presente el codigo QR adjunto en el correo en recepcion para generar un ingreso rapido.</h4>";
			$mensaje.= "<br>";
			$mensaje.= "";
			$mensaje.= "<p>No responda este correo, ya que no estamos controlando esta bandeja de entrada.</p>";
			$mensaje.= "<br>";
			$mensaje.= "Edificio Titanium La Portada";
			$mensaje.= "<br>";
			$mensaje.= "Direccion :".self::direccion;
			
			
		 }	
		 
		return $mensaje;
	}
	
	
	
}
?>
