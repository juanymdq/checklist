
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<style>
body{
/*background-image: -webkit-linear-gradient(top, #F4FA58, #FF0000); /* Chrome, Safari versiones relativamente modernas*/ 
/*background-image: -moz-linear-gradient(top, #F4FA58, #FF0000); /* Firefox versiones relativamente modernas*/
background-image:      -o-linear-gradient(top, #F4FA58, #FF0000); /* Opera versiones relativamente modernas*/
/*background-image:         linear-gradient(to bottom, #F4FA58, #FF0000); /* Chrome, Firefox, IE, Opera versiones actuales */
}

#tablaFDP{
    margin: 10px 0px 50px 430px;
    border: green 3px solid;
    alignment-adjust: -moz-central;
    
}
#tablaFDP td {
    border: green 1px solid;
    width: 350px;
    height: 40px;
}
#tablaFDP th{
    font-size: 20px;
    margin: 0px 0px 50px 0px;
}
#codHoja{
    width:200px;
}
#boton{
    padding: 50px 0px 0px 0px;
}
#fdp{
    font-size: 15px;
    font-weight: bold;
}
input[type=text] {
    text-align: center;
    font-size: 20px;
}
#estado{
    font-weight: bold;
    font-size: 13px;
    color: navy;  
}
/* ESTILO CUANDO SE MUESTRAN LAS SESIONES CERRADAS */
#sa{
    font-size: 18px;
    font-weight: bold;
    color: navy;
}
#sacoment{
    color: navy;
    font-size: 20px;
    font-weight: bold;
    margin: 15px 0px 10px 0px;
}
/* -------------------------------------------------- */
</style>
<script>
window.onload(){
    document.getElementById('fecha').value = "";
}
function muestra_fdp(){    
    str = document.getElementById('codHoja').value;
    x=str.split("-");
    //alert(x[0]);
    document.getElementById('fecha').value = x['2']+"-"+x['1']+"-"+x['0'];
}
</script>
</head>

<body> 
<form method="post" action="guardar_hoja.php"> 
    <?
     //Reanudamos la sesión
     /*   @session_start();
    	if($_SESSION['iniciada']!="SI"){
    		header("location:login.php?error=2");
    		exit();
    	}*/
    if (isset($_GET['accion'])){
        $valor = $_GET['accion'];
	}else{
		$valor=0;	
	}
    
	switch($valor){
		case 0: break;
		case 1:	echo "<center><font color='#0000FF'></br>La FDP se cerro correctamente!!!</font></center>";
                
                //if(isset($_GET['dato'])){
                if(isset($_SESSION['datos'])){
                    echo "<div id='sacoment'>";
                    echo "Se cerraron los siguientes turnos abiertos:</br>";
                    echo "</div>";
                    $array = explode("-", $_SESSION['datos']);
                    echo "<div id='sa'>";                    
                    for($i=0;$i<count($array);$i++){
                        
                        echo $array[$i];
                        echo "</br>"; 
                       
                    }
                    echo "</div>";
                    unset($_SESSION['id_hoja']);                    
                }
				break;
		case 2:	echo "<center><font color='#0000FF'></br>SE HA CERRADO EL TURNO DEL USUARIO: <h1>".$_SESSION['usuario']."</h1></font></center>";                
				break;
        //CIERRE DE SESION AUTOMATICA QUE VIENE DE CHECK
      
	}	
       
    //include('clases/c_hoja.php');
    //include('clases/c_turnos.php');
   
    $turno = new turnos;
    $hoja = new hoja;
    $cerrada=false;
    $fdpA = $hoja->obtiene_ultima_fecha_abierta_hoja();    
    $filaA = mysql_fetch_array($fdpA);   
    $_SESSION['id_hoja']=$filaA[0];
    $fdpC = $hoja->obtiene_ultima_fecha_cerrada();
    $filaC = mysql_fetch_array($fdpC);
    //$fecha = date('Y-m-j');
    if(empty($filaA[0])){
        $fecha = date('Y-m-d');
        if(strtotime($filaC[0])==strtotime('-1 day',strtotime($fecha))){            
            $nuevafecha = date('d/m/Y',strtotime($filaC[0])).' FDP CERRADA';
            $cerrada=true;
                     
        }else{
            //$fecha = date('Y-m-j');
            $nuevafecha = strtotime('-1 day',strtotime($fecha));
            $nuevafecha = date ( 'd/m/Y' , $nuevafecha );
            $est = 'SIN ABRIR';
            $textboton = "Abrir Fecha y Turno";
         }
     }else{
            $h=$_SESSION['id_hoja'];
            $u=$_SESSION['id_usuario'];
            $fturno = $turno->obtiene_estado_turno($h,$u);
            $filaT = mysql_fetch_array($fturno);
            $nuevafecha = date('d/m/Y',strtotime($filaA['fdp']));
            $est = 'ABIERTA';
            $textboton = "Ir a Check";
     }            
            
    ?>
    <table id="tablaFDP">
        <tr id="fdp">
            <td>FDP A PROCESAR</td>
        </tr>
        <tr>
            <td id="estado"><? if(isset($est)) echo $est ?></td>
        </tr>
        <tr id="fdp">
            <td><input type="text" id="date" name="date" value="<? echo $nuevafecha;?>" readonly="true" size="30" /></td>
        </tr>
        <? 
       
            if(!($cerrada)){
                if(isset($filaT)){
                    if(empty($filaT[0])){
                        $textboton='Abrir Turno';
                        echo "<tr id='boton'>        
                        <td><input type='submit' value='". $textboton ."' id='btn' /></td>
                        </tr>";
                    }else{
                        if($filaT[0]=='ABIERTO'){            
                            echo "<tr id='boton'>        
                                    <td><input type='submit' value='". $textboton ."' id='btn' /></td>
                                </tr>";
                        }elseif($filaT[0]=='CERRADO'){
                            echo "<tr id='boton'>        
                            <td><h2>SU TURNO SE ENCUENTRA CERRADO</h2></td>
                        </tr>";
                        }
                    }
                }else{
                    
                    echo "<tr id='boton'>        
                        <td><input type='submit' value='". $textboton ."' id='btn' /></td>
                    </tr>";
                }
                
            }else{
                echo "<tr id='boton'>        
                    <td></td>
                </tr>";
            }
        
        ?>
    </table> 
</form> 
</body>
</html>