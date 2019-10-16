<?php

$codigo=$_GET["codigo"];
include("clases/c_tareas.php");
$tarea = new tarea;
if(@$_REQUEST['action']=="del"){	
	if($tarea->eliminar_tarea_erronea($codigo)){
		header("location: principal.php?id=eliminarTareas&accion=1"); 
	}else{
		header("location: principal.php?id=eliminarTareas&accion=2"); 
	}
}
?>
