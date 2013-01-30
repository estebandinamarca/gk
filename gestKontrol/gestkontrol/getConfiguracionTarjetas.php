<?php
require_once ('src/classes/controlConfiguracionGK.class.php');


echo controlConfiguracionGK::getConfiguracion(null,"Tarjetas")->getestado();

?>