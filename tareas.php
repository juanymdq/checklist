<?php
include("clases/c_tareas.php");		
//include("clase_fichaje.php");
$tareas = new tarea;
//$ficha = new fichaje;	
switch ($_POST["edita"]) {
    case 1: //si se edita
        //$cod = $_GET['codigo'];
        $tareas->edita_datos_tarea();
        break;
    case 2: // si se agrega								
        //$user->inserta_datos_usuario();
        break;	
	
}//FIN SWITCH
?>