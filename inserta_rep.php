<?php
session_start();
//include 'clases/conexion.php';

$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);

$idt=$_POST['idt'];//id de tarea
$idu=$_POST['idu'];//id usuario
$fdp=$_POST['fdp'];//fdp
$e=$_POST['e'];//estado
$ids=$_POST['ids'];//id supervisor
$h=$_POST['h'];//hora
$v=$_POST['v'];//valor del comentario
$val = $_GET['val'];
switch($val){
    case 0://viene de reproceso_check
        $sql="INSERT INTO reproceso_tareas (id_tarea,fdp,id_usuario,hora,valor) VALUES('$idt','$fdp','$idu','$h','$v')";
        mysql_query($sql);
        break;
    case 1://viene de reproceso.php - en este caso se usa la variable v para la fecha actual
        $sql="INSERT INTO reproceso (fdp,id_usuario,estado,fecha_actual,super) VALUES('$fdp','$idu','$e','$v','$ids')";
        mysql_query($sql);
        break;  
    case 2://llamado desde reproceso.php para comprobar si la fecha se encuentra abierta, pendiente o cerrada
        $res="SELECT fdp FROM reproceso WHERE fdp='".$fdp."' and (estado = 'PENDIENTE' or estado = 'CERRADA')";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];        
        break; 
    case 3: //llamado desde reproceso_check.php para editar el campo estado de la tabla reproceso
        $sql="UPDATE reproceso SET estado='$e' WHERE fdp='$fdp'";
        mysql_query($sql);
        break;
    case 4: //llamado desde reproceso_check.php para editar el campo estado y super de la tabla reproceso
        $sql="UPDATE reproceso SET estado='$e',super='$ids' WHERE fdp='$fdp'";
        mysql_query($sql);
        break;
    case 5://llamado desde busqueda_reproceso.php para eliminar la fecha
        $sql="DELETE FROM reproceso WHERE fdp='$fdp'";
        mysql_query($sql);
        break;
    case 6://este select traera todas las tareas para una fecha determinada
        $res = "SELECT * FROM reproceso_tareas WHERE fdp='$fdp'";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break;
    case 7://este select traera todas las tareas para una fecha determinada
        $res = "SELECT usuario FROM usuario WHERE id_usuario='$ids'";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break;
    case 8://ELIMINA LA TAREA - VIENE DE check.php
        $res = "DELETE FROM reproceso_tareas WHERE id_tarea=$idt and fdp='$fdp'";
        mysql_query($res);
        $sql="INSERT INTO seguimiento (id_usuario,tarea,fecha,accion) VALUES ('$idu','$v','$h','$e')";
        mysql_query($sql);
        break;
}
unset($_POST['idt']);
unset($_POST['idu']);
unset($_POST['fdp']);
unset($_POST['e']);
unset($_POST['ids']);
unset($_POST['h']);
unset($_POST['v']);
?>