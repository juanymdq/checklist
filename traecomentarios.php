<?php

$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);
$idu=$_POST['idu'];
$idt=$_POST['idt'];
$idh=$_POST['idh'];
$val = $_GET['val'];
switch ($val){
    case 0://obtiene el estado de la tarea val=0
            $res="SELECT d_estado FROM log_diario as l, estado as e WHERE l.estado=e.id_estado and id_tarea=".$idt." and id_hoja=".$idh;
            break;
    case 1://obtiene comentarios de la tarea val=1 / Tambien se usa para veriicar si la tarea se realizo
            $res="SELECT valor FROM log_diario WHERE id_tarea=".$idt." and id_hoja=".$idh."";
            break;
    case 2://Obtiene el usuario de la tabla USUARIO para cerrar un turno
            $res="SELECT usuario FROM usuario WHERE id_usuario=".$idu."";
            break;
    case 3://selecciona la FDP abierta
            $res="SELECT fdp FROM hoja WHERE estado = 'ABIERTA'";           
            break; 
    case 4://trae el usuario que guardo la tarea a la hoja check_maquinas.php
            $res="SELECT guardado FROM log_diario_mov WHERE id_tarea=".$idt." and id_mov=".$idh."";
            break;
}   
/*if($val==1){
    //obtiene comentarios de la tarea val=1 / Tambien se usa para veriicar si la tarea se realizo
    $res="SELECT valor FROM log_diario WHERE id_tarea=".$idt." and id_hoja=".$idh."";
}elseif($val==0){    
    //obtiene el estado de la tarea val=0
    $res="SELECT d_estado FROM log_diario as l, estado as e WHERE l.estado=e.id_estado and id_tarea=".$idt." and id_hoja=".$idh;
}*/
$resval = mysql_query($res);
if(mysql_num_rows($resval)<>0){
    $fila = mysql_fetch_array($resval);
    echo $fila[0];
}



?>