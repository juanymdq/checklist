<?php

$con = mysql_connect("localhost","root","");
mysql_select_db("check",$con);

$idu=$_POST['idu'];//ID USUARIO
$he=$_POST['he'];//HORA ENTRADA
$hs=$_POST['hs'];//HORA SALIDA
$f=$_POST['f'];//FECHA
$je=$_POST['je'];//justificacion
$js=$_POST['js'];//justificacion
$val=$_GET['val'];
switch($val){
    case 0://inserta en la bd
        $res="INSERT INTO fichaje (id_usuario,fecha,hentrada,hsalida,just_entrada,just_salida) VALUES ('$idu','$f','$he','','-','-')";
        mysql_query($res);
        break;
    case 1://consulta de fecha
        $res="SELECT fecha FROM fichaje WHERE id_usuario=".$idu." ORDER BY id_fichaje DESC LIMIT 1";
        //$res="SELECT COUNT(fecha) FROM fichaje WHERE id_usuario=".$idu." and fecha='".$f."'";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break; 
    case 2: //inserta en la bd con justificacion
        $res="INSERT INTO fichaje (id_usuario,fecha,hentrada,hsalida,just_entrada,just_salida) VALUES ('$idu','$f','$he','','$je','-')";
        mysql_query($res);
        break;
    case 3://modifica el horario de salida
        $res="UPDATE fichaje SET hsalida='$hs' WHERE id_usuario='$idu' and fecha='$f'";
         mysql_query($res);
        break;   
    case 4://modifica el horario de salida con justificacion
        $res="UPDATE fichaje SET hsalida='$hs',just_salida='$js' WHERE id_usuario='$idu' and fecha='$f'";
         mysql_query($res);
        break;
    case 5://consulta de hora entrada
        $res="SELECT hentrada FROM fichaje WHERE id_usuario=".$idu." ORDER BY id_fichaje DESC LIMIT 1";
        //$res="SELECT COUNT(fecha) FROM fichaje WHERE id_usuario=".$idu." and fecha='".$f."'";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break; 
    case 6://OBTIENE FEHCA Y HORA DEL SERVIDOR
        $res = "SELECT NOW()";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break;        
}

//mysql_query($res);
unset($_POST['idu']);
unset($_POST['he']);
unset($_POST['hs']);
unset($_POST['f']);
unset($_POST['j']);


?>