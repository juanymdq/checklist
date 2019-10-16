<?php

$codigo=$_GET["codigo"];
include("clases/c_usuario.php");
$user = new usuario;
if(@$_REQUEST['action']=="del"){	
	if($user->borrar_datos_usuario($codigo)){
		header("location: principal.php?id=usuarios_principal&accion=3&edita=1"); 
	}else{
		header("location: principal.php?id=usuarios_principal&accion=4&edita=1"); 
	}
}
?>
