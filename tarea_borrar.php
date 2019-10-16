<?php

$codigo=$_GET["codigo"];
include("clases/c_tareas.php");
$tarea = new tarea;
if(@$_REQUEST['action']=="del"){	
	if($tarea->borrar_datos_tarea($codigo)){
		header("location: principal.php?id=tareas_principal&accion=3&edita=1"); 
	}else{
		header("location: principal.php?id=tareas_principal&accion=4&edita=1"); 
	}
}
?>
