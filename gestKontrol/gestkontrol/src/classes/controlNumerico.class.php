<?php

class controlNumerico
{
	public function validadorRut($rut,$digitoVerificador)
	{
		$multi = 2;
		$suma=0;
		$mod = 11;
		for($i= strlen($rut); $i>0; $i--)
		{
			if($multi>7)
			{
				$multi= 2;
			}
			$suma = ($rut%10)*$multi+$suma;
			//echo $suma."<br>";
			$rut = $rut/10;
			$multi ++;
		}
		switch ($digitoVerificador)
		{
			case "k":
				$digitoVerificador = 10;
				break;
		
			case "0":
				$digitoVerificador = 11;
				break;
		}
		
		
		$control = $mod-($suma%$mod);
		//echo $control;
		if($control == $digitoVerificador)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
}
?>