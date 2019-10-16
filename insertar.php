<?php
session_start();
//include 'clases/conexion.php';

$con = mysqli_connect("localhost","root","","check");
//mysql_select_db("check",$con);

/* comprobar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

$idt=$_POST['idt'];//id de tarea
$idh=$_POST['idh'];//id de hoja
$idu = $_SESSION['id_usuario'];
$h=$_POST['h'];//hora
$v=$_POST['v'];//valor
$p=$_POST['p'];//tipo de tarea
$t=$_POST['t'];//turno
$sql="INSERT INTO log_diario (id_tarea,id_hoja,id_usuario,hora,valor,estado,turno) VALUES('$idt','$idh','$idu','$h','$v','$p','$t')";
mysqli_query($con , $sql);
mysqli_close($con);
unset($_POST['idt']);
unset($_POST['idh']);
unset($_POST['h']);
unset($_POST['v']);
unset($_POST['p']);
unset($_POST['t']);
?>