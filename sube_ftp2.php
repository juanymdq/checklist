<?php

##### http://www.lawebdelprogramador.com #####

 
# FUNCIONES FTP

# CONSTANTES
# Cambie estos datos por los de su Servidor FTP
define("SERVER","172.18.20.249"); //IP o Nombre del Servidor
define("PORT",21); //Puerto
define("USER","iplc"); //Nombre de Usuario
define("PASSWORD","Casino2020"); //Contraseña de acceso
define("PASV",true); //Activa modo pasivo

# FUNCIONES

function ConectarFTP(){
    //Permite conectarse al Servidor FTP
    $id_ftp=ftp_connect(SERVER); //Obtiene un manejador del Servidor FTP
    $resultado = ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
    if ((!$id_ftp) || (!$resultado)) {
		//echo "Fallo en la conexión"; 
        die;
        header('location: check.php?aviso=1');
	} else {
		echo "Conectado.";
	}
    
    ftp_pasv($id_ftp,PASV); //Establece el modo de conexión
    return $id_ftp; //Devuelve el manejador a la función
}


$año = substr($_GET['a1'],16,4);     
$mes = substr($_GET['a1'],20,2);
$am = $año.$mes;    
$d = substr($_GET['a1'],22,2);//dia
switch($mes){
    case '02':
        $nmes = 'FEB'.$año;
        break;
}





$arch1 =  substr($_GET['a1'],12,25);
$arch2 =  substr($_GET['a2'],12,25);

//C:\fakepath\000_20160901_20160902.txt
// \160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\2016\SEP2016\01
//O:\Control\Archivos\2016\SEP2016\01\000_20160901_20160902.txt

//AL MANDAR EL ENVIAR LOS ARCHIVOS POR EL SERVIDOR ES NECESARIO PASARLE LA RUTA COMPLETA
$rutalocal = "160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\\".$año.'\\'.$nmes.'\\'.$d;

$rlocal1 = $rutalocal.'\\'.$arch1;
$rlocal2 = $rutalocal.'\\'.$arch2;

//echo $rlocal1.'----'.$rlocal2;

//$fdp = $_SESSION['fdp'];
//OBTIENE LA FDP PARA CONTROLAR QUE LOS ARCHIVOS ENVIADOS SEAN LOS CORRECTOS
session_start();
list($dia, $m, $aa) = explode("/",$_SESSION['fdp']);
if((strcmp($d,$dia)==0) && (strcmp($mes,$m)==0) && (strcmp($año,$aa)==0)){
    
   // $id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP

   // $rutaftp=ftp_pwd($id_ftp); //Devuelve ruta actual p.e./C:/FTP/
    
    
  //  $rutaftp1="IPLYC/Para Iplyc/".$am."/".$d."/";
    //$rutaftp2="IPLYC/Para Iplyc/".$am."/".$d."/";
 //---------------------------------------------------------------------  
      // establecer una conexión básica
    $ftp_server = '172.18.20.249';
    $ftp_user_name = 'iplc';
    $ftp_user_pass = 'Casino2020';
    $conn_id = ftp_connect($ftp_server);
    
    // iniciar sesión con nombre de usuario y contraseña
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
    
    // check connection
    if ((!$conn_id) || (!$login_result)) {
        die("La conexión FTP ha fallado!");
    }
    //$rutaftp1="IPLYC/Para Iplyc/".$am."/".$d."/";
    $rutaftp1="Para%20Iplyc/".$am."/".$d."/";
    echo "Directorio actual: " . ftp_pwd($conn_id) . "\n";
    
    // intenta cambiar el directorio a somedir
    if (ftp_chdir($conn_id, $rutaftp1)) {
        echo "El directorio actual es: " . ftp_pwd($conn_id) . "\n";
    } else { 
        echo "No se pudo cambiar al directorio\n";
    }
    
   
    
  //  $path = "\\\\".$rutalocal."\\";   
    
  //   $path.= $arch1;
  //   echo $path;
    $directorio = opendir("\\"); //ruta actual
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {
        if (is_dir($archivo))//verificamos si es o no un directorio
        {
            echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
        }
        else
        {
            echo $archivo . "<br />";
        }
    }
    
    // cargar un archivo
 /*   if (ftp_put($conn_id, $arch1, $path, FTP_ASCII)) {
     echo "se ha cargado $path con éxito\n";
    } else {
     echo "Hubo un problema durante la transferencia de $path\n";
    }
*/
// cerrar la conexión ftp
ftp_close($conn_id);
    
   
 //----------------------------------------------------------------------- 
   
   
   
   
   
    
    //IPLYC/Para Iplyc/201608/01/
    
    
//    echo $rutaftp.'<br/>';
//    echo $rutaftp1.'----'.$rutaftp2.'<br/>';
//    echo $rlocal1.'-----'.$rlocal2.'<br/>';
 
 //$rutaftf1 = IPLYC/Para Iplyc/201609/05/000_20160905_20160906.txt
 //$rutaftp2 = IPLYC/Para Iplyc/201609/05/000_20160905_20160906.md5
 
// $rlocal1 = \\160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\2016\AGO2016\05\000_20160905_20160906.txt
// $rlocal2 = \\160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\2016\AGO2016\05\000_20160905_20160906.md5

                                                                             
    //ftp_put($id_ftp,$rutaftp.'IPLYC/Para Iplyc/201608/01/000_20160801_20160802.txt','O:\Control\Archivos\2016\AGO2016\01\000_20160801_20160802.txt',FTP_ASCII);
  /*  if((ftp_put($id_ftp,$rutaftp1,$rlocal1,FTP_ASCII)) && (ftp_put($id_ftp,$rutaftp2,$rlocal2,FTP_BINARY))){
        //echo "se ha cargado $file con éxito\n";
        header('location: check.php?aviso=2');
    }else {
        //echo "Hubo un problema durante la transferencia de $file\n";
        header('location: check.php?aviso=3');
    }
    
    ftp_quit($id_ftp); //Cierra la conexion FTP

    
}else{
    header('location: check.php?aviso=4');
   */
}
//Obriene ruta del directorio del Servidor FTP (Comando PWD)

?>
