<?php
session_start();

$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);

$idt=$_POST['idt']; //id de la tarea
$idh=$_POST['idh']; //id de la hoja
$idu=$_POST['idu']; //id de usuario
$h=$_POST['h']; //hora
$v=$_POST['v']; //descripcion
$p=$_POST['p']; //pendiente / trae el valor para la tabla log_diario_mov (guardado)
$val = $_GET['val'];
switch ($val){
    case 0://MODIFICA EL ESTADO DEL TURNO A CERRADO
        $res="UPDATE turnos SET testado='CERRADO' WHERE id_hoja='$idh' and id_usuario=$idu";
        mysql_query($res);
        break;
    case 1://CAMBIA EL VALOR DE LA TAREA
        $res="UPDATE log_diario SET id_usuario='$idu', hora='$h',valor='$v', estado='$p' WHERE id_hoja='$idh' and id_tarea='$idt'";
        mysql_query($res);
        break;
    case 2://MODIFICA EL ESTADO DE LA HOJA A CERRADO
            //O SEA CIERRA LA FDP               
        $res="UPDATE hoja SET estado='CERRADA',id_usuario=$idu,horacierre='$h' WHERE id_hoja='$idh'";
        mysql_query($res);
        break;
    case 3://MODIFICA EL ESTADO DEL TURNO A ABIERTO
        $res="UPDATE turnos SET testado='ABIERTO' WHERE id_hoja='$idh' and id_usuario=$idu";
        mysql_query($res);
        break;
    case 4://CIERRA TODOS LOS TURNOS ABIERTOS
        $res = "UPDATE turnos SET testado='CERRADO'";
        mysql_query($res);
        break;
    case 5://
        $res = "SELECT id_hoja,MAX(fdp) as fdp FROM hoja WHERE estado like 'ABIERTA'";
        $resval = mysql_query($res);
        if(mysql_num_rows($resval)<>0){
            $fila = mysql_fetch_array($resval);
            echo $fila[0];
        }
        break;        
    case 6://ENVIA EL VALOR DEL COMENTARIO PARA MODIFICAR - SOLO SUPERVISORES
        $res = "SELECT valor FROM log_diario WHERE id_hoja='$idh' and id_tarea='$idt'";
        $resval = mysql_query($res);
        if(mysql_num_rows($resval)<>0){
            $fila = mysql_fetch_array($resval);
            echo $fila[0];
        }
        break;
    case 7://EDITA EL VALOR DE LA TAREA - VIENE DE abm_tareas.php
        $res="UPDATE log_diario SET valor='$v' WHERE id_hoja='$idh' and id_tarea='$idt'";
        mysql_query($res);
        break;
    case 8://ELIMINA LA TAREA - VIENE DE check.php
        $res = "DELETE FROM log_diario WHERE id_tarea=$idt and id_hoja=$idh";
        mysql_query($res);
        //GUARDA EN BD EL SEGUIMIENTO - LOG DE OPERACIONES
        //$idu=id_usuario - $v=tarea - $h=fecha - $p=accion;
        //$sql="INSERT INTO seguimiento (id_usuario,tarea,fecha,accion) VALUES ('$idu','$v','$h','$p')";
        //mysql_query($sql);
        break;
    case 9://GUARDA EN BD EL SEGUIMIENTO - LOG DE OPERACIONES
        //$idu=id_usuario - $v=tarea - $h=fecha - $p=accion;
        $res="INSERT INTO seguimiento (id_usuario,tarea,fecha,accion) VALUES ('$idu','$v','$h','$p')";
        mysql_query($res);
        break;
    //----------------------------CONSULTAS PARA EL CHECK MOVIMIENTO DE MAQUINAS----------------
 /*   case 8://INSERTA TAREAS DE CHECK - VIENE DE check_maquinas.php
        $res = "INSERT INTO log_diario_mov (id_tarea,id_mov,id_usuario,hora,valor,guardado) VALUES ('$idt','$idh','$idu','$h','$v','$p')";
        break;*/  
}
//mysql_query($res);
//mysql_query($sql);
unset($_POST['idt']);
unset($_POST['idu']);
unset($_POST['idh']);
unset($_POST['h']);
unset($_POST['v']);
unset($_POST['p']);
//mysql_free_result($res);
//mysql_free_result($sql);
?>