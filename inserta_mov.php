<?php
session_start();
//include 'clases/conexion.php';

$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);

$idt=$_POST['idt'];//id de tarea
$idu=$_POST['idu'];//id usuario
$ida=$_POST['ida'];//id area - id movimiento
$fmov=$_POST['fmov'];//fecha del movimiento
$d=$_POST['d'];//descripcion - valor de tabla log_diario_mov
$fact=$_POST['fact'];//fecha actual
$h=$_POST['h'];//hora
$e=$_POST['e'];//estado
$g = $_POST['g'];//guardado (tabla log_diario_mov))
$val = $_GET['val'];
switch($val){
    case 0://OBTIENE TODOS LOS DATOS DE UN MOVIMIENTO CON RESPECTO AL ID DEL MOVIMIENTO       
        $res = "SELECT * FROM movimiento_fecha as m,area as a,usuario as u WHERE m.id_mov=$idt and m.id_usuario=u.id_usuario and m.id_area=a.id_area";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        $_SESSION['estadomov'] = $fila[7];
        $_SESSION['d_area'] = $fila[12];
        $_SESSION['fechamov'] = date('d/m/Y',strtotime($fila[3]));
        //----fecha------Descripcion----id area-----desc area---fecha act------hora---------usuario--------estado----fecha hora------usuario cierre
        echo $fila[3].";".$fila[4].";".$fila[2].";".$fila[12].";".$fila[5].";".$fila[6].";".$fila[20].";".$fila[7].";".$fila[8].";".$fila[9];
        break;
    case 1://viene check_maquinas_sel_fecha
        $sql="INSERT INTO movimiento_fecha (id_usuario,id_area,fecha_mov,mov_d,fecha_act,hora,estado,user_cierre,f_cierre) VALUES('$idu','$ida','$fmov','$d','$fact','$h','$e','','')";                 
        mysql_query($sql);                
        $_SESSION['fechamov'] = date('d/m/Y',strtotime($fmov));
        $_SESSION['estadomov'] = $e;
        $_SESSION['d_area'] = $g;               
        break;
    case 2://Edita el estado de la tabla movimiento_fecha - Llamdo desde check_maquinas.php
         $res="UPDATE movimiento_fecha SET user_cierre='$idu', f_cierre='$fmov', estado='COMPLETO' WHERE id_mov=$ida";
         mysql_query($res);
         break;
    case 3://INSERTA TAREAS DE CHECK - VIENE DE check_maquinas.php
        $res = "INSERT INTO log_diario_mov (id_tarea,id_mov,id_usuario,hora,valor,guardado,estado) VALUES ('$idt','$ida','$idu','$h','$d','$g','$e')";
        mysql_query($res);
        break; 
    case 4://MODIFICA LA TAREA DEW PENDIENTE A COMPLETADA - VIENE DE check_maquinas.php
        $res = "UPDATE log_diario_mov SET hora='$h',guardado='$g', estado='$e' WHERE id_tarea=$idt";
        mysql_query($res);
        break;
    case 5://ELIMINA LA TAREA - VIENE DE check_maquinas.php
        $res = "DELETE FROM log_diario_mov WHERE id_tarea=$idt and id_mov=$ida";
        mysql_query($res);
        break;
    case 6:
        $res = "SELECT * FROM movimiento_fecha as m, area as a WHERE m.id_area=a.id_area and fecha_mov='$fmov'";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);        
        echo json_encode($fila);        
        break; 
    case 7://OTIENE EL ID MAXIMO
        $res = mysql_query("SELECT MAX(id_mov) FROM movimiento_fecha");        
        $fila = mysql_fetch_array($res); 
        echo $fila[0];  
        break;
}
unset($_POST['idt']);
unset($_POST['idu']);
unset($_POST['ida']);
unset($_POST['fmov']);
unset($_POST['d']);
unset($_POST['fact']);
unset($_POST['h']);
unset($_POST['e']);
unset($_POST['g']);