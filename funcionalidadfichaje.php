<?php
mysql_connect('localhost', 'root', '');
mysql_select_db('check');
$id=$_POST['id'];//ID USUARIO
$he=$_POST['he'];//HORA ENTRADA
$hs=$_POST['hs'];//HORA SALIDA
$f=$_POST['f'];//FECHA
$js=$_POST['js'];//justificacion
$val=$_GET['val'];
switch($val){
    case 0://inserta en la bd
        $consulta="INSERT INTO fichaje VALUES ('',$id,'$f','$he','','')";
        mysql_query($consulta);
        break;
    case 1://OBTIENE DATOS PARA INFORMAR EL INGRESO DEL USUARIO
        $consulta = "SELECT * FROM usuario WHERE legajo=$id";
        $datos = mysql_query($consulta);
        $fila = mysql_fetch_array($datos);
        //-----nombre---------apellido-----------legajo
        echo $fila['1']. '-' .$fila['2']. '-' .$fila['5'];
        break;
    case 2://OBTIENE FEHCA Y HORA DEL SERVIDOR
        $res = "SELECT NOW()";
        $datos = mysql_query($res);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break;
    case 3://OBTIENE EL LEGAJO PARA COMPROBAR SI EXISTE
        $consulta = "SELECT legajo FROM usuario WHERE legajo=$id";
        $datos = mysql_query($consulta);
        $fila = mysql_fetch_array($datos);
        echo $fila[0];
        break;
    case 4://OBTIENE EL ULTIMO INGRESO DEL USUARIO
        $consulta = "SELECT * FROM fichaje WHERE id_usuario=$id and fecha='$f'";
        $res = mysql_query($consulta);
        $fila = mysql_fetch_array($res);
        if(mysql_num_rows($res)!=0){//si encontro registro segun fecha y legajo

            //si encontro una entrada
            if($fila['hsalida']!="00:00:00"){
                if($fila['hentrada'] >= '22:30:00' && $fila['hentrada'] <= '23:45:00' && $fila['hsalida'] >= '06:00:00' && $fila['hsalida'] <= '08:00:00'){
                    echo 2;//significa que esta haciendo turno noche y hay que sumarle 1 (uno) a la fecha para el ingreso
                }else{
                    echo 4;//existe ya un ingreso
                }
            }else{//verifica si se egresa de horario intermedio
                if($fila['hentrada'] >= '18:00:00' && $fila['hentrada'] <= '20:00:00'){
                    //---ctrl---id_fichaje------id_usuario----------fecha---------hora entrada----hora salida
                    echo '3 -' .$fila['0']. '-' .$fila['1']. '-' .$fila['2']. '-' .$fila['3']. '-' .$fila['4'];
                }else{//si se egresa del resto de los horarios
                    //---ctrl---id_fichaje------id_usuario----------fecha---------hora entrada----hora salida
                    echo '1 -' .$fila['0']. '-' .$fila['1']. '-' .$fila['2']. '-' .$fila['3']. '-' .$fila['4'];
                }
            }
        }else{
            switch($he){
                case ($he >= '22:30:00' && $he <= '23:45:00')://ingreso turno noche
                    echo 2;
                    break;
                case ($he >= '06:00:00' && $he <= '21:00:00'):
                    echo 0;
                    break;
                case ($he >= '02:00:00' && $he <= '4:00:00')://controlo si se esta yendo a esas hora
                                                             //implica que que esta trabajando el dia anterior por lo que le resto uno a la fecha
                                                             //y hago la consulta para encontrar el registro
                    $temp = explode('-',$f);
                    $fch = $temp[2] - 1;
                    $f = $temp[0].'-'.$temp[1].'-'.$fch;
                    $consulta = "SELECT * FROM fichaje WHERE id_usuario=$id and fecha='$f'";
                    $res = mysql_query($consulta);
                    $fila = mysql_fetch_array($res);
                    if(mysql_num_rows($res)!=0){//si encontro registro segun fecha y legajo
                        //---ctrl---id_fichaje------id_usuario----------fecha---------hora entrada----hora salida
                        echo '3 -' .$fila['0']. '-' .$fila['1']. '-' .$fila['2']. '-' .$fila['3']. '-' .$fila['4'];
                    }
                    break;
            }
        }
        break;
    case 5://ACTUALIZA EL FICHAJE CON LA JUSTIFICACION
        $consulta = "UPDATE fichaje SET justificacion='$js' WHERE id_fichaje=$id";
        mysql_query($consulta);
        break;
    case 6://ACTUALIZA EL UTLIMO FICHAJE SEGUN LEGAJO
        $consulta="UPDATE fichaje SET hsalida='$hs' WHERE id_fichaje=$id";
        mysql_query($consulta);
        break;
    case 7://OBTIENE EL ULTIMO INGRESO DEL USUARIO----------NO SE USA
        $consulta = ("SELECT horae FROM fichaje WHERE idusuario=$id and fecha='$f'");
        $res = mysql_query($consulta);
        $fila = mysql_fetch_assoc($res);
        /*if(mysqli_num_rows($res)!=0 && $fila['horae']!='00:00:00'){
            echo 1;//si encontro una salida y posee hora distina a 00:00:00
        }else{
            echo 0;//si no encontro salida
        }*/
        if(mysql_num_rows($res)!=0){
            if($fila['horae']!='00:00:00'){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 2;
        }
        break;
}

//mysql_query($res);
unset($_POST['id']);
unset($_POST['he']);
unset($_POST['hs']);
unset($_POST['f']);


?>