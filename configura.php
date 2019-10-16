<?php 
    include("clases/c_config.php");
    include_once('caducarsesion.php');		
	//include("clase_fichaje.php");
    $conf = new config;
	//$ficha = new fichaje;	
    switch ($_POST["edita"]) {
        case 1: //si se edita
            $conf->edita_datos_config();
            break;
        case 2: // si se agrega	
	         $conf->inserta_datos_config();
            break;
	}//FIN SWITCH
?>
                