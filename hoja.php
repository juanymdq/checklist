<?
/*
EL OBJETIVO DE ESTE ARCHIVO ES SIMPLEMENTE ENVIAR EL ID DE HOJA PARA PODER
EDITAR EL VALOR DE LAS TAREAS.

TARGET: abm_tareas.php
*/
$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);

$fdp = $_POST['fdp'];

$res = "SELECT id_hoja FROM hoja WHERE fdp='$fdp'";
$resval = mysql_query($res);
if(mysql_num_rows($resval)<>0){
    $fila = mysql_fetch_array($resval);
    echo $fila[0];
}

 

?>