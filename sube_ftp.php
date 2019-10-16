<?php
if(is_uploaded_file($_FILES["archivo1"]["tmp_name"]))
{
    $año = substr($_GET['a1'],16,4);     
    $mes = substr($_GET['a1'],20,2);
    $am = $año.$mes;    
    $d = substr($_GET['a1'],22,2);//dia
    switch($mes){
        case '02':
            $nmes = 'FEB'.$año;
            break;
    }
    //C:\fakepath\000_20160901_20160902.txt
    // \160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\2016\SEP2016\01
    //O:\Control\Archivos\2016\SEP2016\01\000_20160901_20160902.txt
    $arch1 =  substr($_GET['a1'],12,25);
    $arch2 =  substr($_GET['a2'],12,25);
    //AL MANDAR EL ENVIAR LOS ARCHIVOS POR EL SERVIDOR ES NECESARIO PASARLE LA RUTA COMPLETA
    //$rutalocal = "160.135.0.1\d$\Operaciones\CasinosBsAs\Control\Archivos\\".$año.'\\'.$nmes.'\\'.$d;
    $rutalocal = "O:\Control\Archivos\\".$año.'\\'.$nmes.'\\'.$d;
    $rlocal1 = $rutalocal.'\\'.$arch1;
    $rlocal2 = $rutalocal.'\\'.$arch2;
    
    # Definimos las variables
    	$host="172.18.20.249";
    	$port=21;
    	$user="iplc";
    	$password="Casino2020";
        $ruta = "Para Iplyc/201902/26/";
    	//$ruta="Para%20Iplyc/".$am."/".$d."/";
     
    	# Realizamos la conexion con el servidor
    	$conn_id=@ftp_connect($host,$port);
    	if($conn_id)
    	{
    		# Realizamos el login con nuestro usuario y contraseña
    		if(@ftp_login($conn_id,$user,$password))
    		{
    			# Canviamos al directorio especificado
    			if(@ftp_chdir($conn_id,$ruta))
    			{
    				# Subimos el fichero
    				if(@ftp_put($conn_id,$_FILES["archivo1"]["name"],$_FILES["archivo1"]["tmp_name"],FTP_BINARY)){
    					echo "Fichero subido correctamente";
    				}else{
    					echo "No ha sido posible subir el fichero";
                    }
                
    			}else{
    				echo "No existe el directorio especificado";
                }
    		}else{
    			echo "El usuario o la contraseña son incorrectos";
            }
    		# Cerramos la conexion ftp
    		ftp_close($conn_id);
    	}else{
    		echo "No ha sido posible conectar con el servidor";
        }
 }else{
     echo "Selecciona un archivo...";
 }
     
  ?>