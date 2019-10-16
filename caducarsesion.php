<?php
/**
 * Estos son los detalles de inicio de sesión de la base de datos: 
 */  
include_once("clases/c_config.php");
$conf = new config;
$val="TES";
$dato = $conf->obtiene_config_x_clave($val);
$fila = mysql_fetch_array($dato);
define("limite", $fila[0]); //Expresado en Minutos - Especifica el tiempo de caducacion de sesion


?>                	
