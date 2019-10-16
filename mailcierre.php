<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?
$email = "jfernand@boldt.com.ar";
$asunto = "Respuesta - Solicitud de Presupuestos"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vista Previa para envio de Mail</title>
<script src="jquery-1.7.2.min.js"></script>
<script src="jquery.js"></script>
<script>

function crear_mail(){    
    var idh = <? echo $_SESSION['id_hoja']; ?>;
    //Se redirige a realizar la vista previa del cierre de turno
    var ctrl = document.getElementById('ctrlturnos').value;     
    if(ctrl==1){//indica que se cerro la FDP y cerrara los turnos abiertos 
        //CIERRA TODAS LAS SESIONES ABIERTAS
        $.ajax({url:"editar.php?val=4",cache:false,type:"POST",data:{idh:0,idu:0}});      
        window.location.href = 'principal.php?id=hoja_principal&accion=1';
        //window.location.href = 'vistapreviamail.php?ctrl=1';
    }else{
        window.location.href = 'principal.php?id=hoja_principal&accion=2';
        //window.location.href = 'vistapreviamail.php?ctrl=2';
    }
   
}

</script>
<style>
body{
    background-color: aqua;
}
#tmail{
    margin: 5px 0px 0px 0px;
    border: green 3px solid;
    
}
#fila{
    border: green 1px solid;
    
}
#tmail th{
    border: green 1px solid;
    font-size: 15px;
    margin: 0px 0px 50px 0px;
}
#cabeceras{
    font-size: 20px;
    font-weight: bold;
    padding-bottom: 5px;
}
#boton{
    margin-top: 10px;
    margin-left: 550px;
}
#volver{
    font-size: 20px;
    font-weight: bolder;
}
</style>
</head>

<body>
<?
include('clases/c_diario.php');
$diario = new diario;
if(isset($_SESSION['id_hoja'])){
    $user = $_SESSION['id_usuario'];
    $hoja = $_SESSION['id_hoja'];
    $res = $diario->obtiene_tareas_usuario($user,$hoja);
    $fila = mysql_fetch_array($res);
    if(!(empty($fila[0]))){
        $fdp = date('d/m/Y',strtotime($fila['fdp']));
       
    }else{
        $fdp='';
    }
}
?>
<form>
    <?
    if(isset($_GET['cierrefdp'])){
        if($_GET['cierrefdp']=='verdadero'){
            echo "<h1>FECHA DE PRODUCCION ".$_SESSION['fdp']." CERRADA</h1>";
            echo "<h1>CIERRE DE TURNO - VISTA PREVIA </h1>";
            include('clases/c_hoja.php');
            $turno = new turnos;
            $dato="";
            $res = $turno->obtiene_turnos_abiertos();
            if(mysql_num_rows($res)==0){
                echo "<input type='hidden' id='ctrlturnos' value='0'/>";
                $_SESSION['datos'] = "NO EXISTEN TURNOS ABIERTOS";
            }else{
                while($fila = mysql_fetch_array($res)){
                    $dato .=$fila['nombre']." ".$fila['apellido']." - ";
                }
                $_SESSION['datos'] = $dato;
                echo "<input type='hidden' id='ctrlturnos' value='1'/>";
            }
        }else{
            echo "<h1>TURNO CERRADO - VISTA PREVIA </h1>";
            echo "<input type='hidden' id='ctrlturnos' value='0'/>";
        }
    }
    
    ?>
    
    <table id="tmail">
        <tr>
            <td colspan="2" id="cabeceras" ><label for="fdp">FDP: <? echo $fdp ?></label></td> 
                  
        </tr>
        <tr>
            <td colspan="2" id="cabeceras"><label for="usuario">USUARIO: <? echo $fila['nombre']." ".$fila['apellido'] ?></label></td>        
        </tr>
        
        <tr>        
            <td colspan="2" id="cabeceras"><label for="encab">TAREAS REALIZADAS</label></td>        
        </tr>       
        <tr>
            <th>Tarea Casino</th>        
            <th>Descripcion de la tarea</th>
            <th>Hora</th>
            <th>Comentarios</th>
        </tr>
                
        <?
        
        
        
        $res = $diario->obtiene_tareas_usuario($user,$hoja);
        while($filan = mysql_fetch_array($res)){?>        
        <tr>    
            <?                
                $t=substr($filan['n_tarea'],5,3);
                switch($t){
                    case 'SFE':
                        $texto = "Casinos Santa Fe";
                        break;
                    case 'CVC':
                        $texto = "Casino Victoria";
                        break;
                    case 'BCO':
                        $texto = "Bingos CODERE";
                        break;
                    case 'CSP':
                        $texto = "Casino 7 Saltos";
                        break;
                    case 'MDP':
                        $texto = "Casinos Bs. As.";
                        break;
                    case 'TTA':
                        $texto = "Turno Tarde";
                        break;
                    case 'TNO':
                        $texto = "Turno Noche";
                        break;
                    case 'OPE':
                        $texto = "Nombre Operadores";
                        break;
                    case 'SUP':
                        $texto = "Supervisores";
                        break;
                    case 'TEM':
                        $texto = "Temperatura";
                        break;
                    case 'MON':
                        $texto = "Monitoreo";
                        break;
                    case 'COM':
                        $texto = "Comentarios";
                        break;
                }
            ?>
            <td id="fila"><label for="casino"><? echo $texto ?></label></td>            
            <td id="fila"><label for="tarea"><? echo $filan['d_tarea'] ?></label></td>
            <td id="fila"><label for="hora"><? echo $filan['hora'] ?></label></td>
            <? $est=$diario->obtiene_estado_tarea($filan['id_tarea'],$hoja);
                $rst = mysql_fetch_array($est);?>            
            <td id="fila"><label for="valor"><? echo $filan['valor']." - ".$rst[0]; ?></label></td>
        </tr>
      
        <?}?>
        
    </table>
    <input type="button" id="boton" value="Cerrar y Volver" onclick="crear_mail()"/>    
</form>
<?php
/** 
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'clases/PHPExcel.php';

$objPHPExcel = new PHPExcel();
//session_start();
//CTRL viene de mailcierre.php con valor 1 significa que debera cerrar turnos abiertos
//CTRL==0 no existen turnos abiertos
if(isset($_GET['ctrl'])){   
    $ctrl = $_GET['ctrl'];
}
//include('clases/c_diario.php');
$user = $_SESSION['id_usuario'];
$hoja = $_SESSION['id_hoja'];
$diario = new diario;
$res = $diario->obtiene_tareas_usuario($user,$hoja);
$fila = mysql_fetch_array($res);
//$us = $fila['nombre']." ".$fila['apellido'];
$us=$fila['usuario'];


$objPHPExcel->getProperties()->setCreator("BOLDT")
							 ->setLastModifiedBy("BOLDT")
							 ->setTitle("TAREAS REALIZADAS")
							 ->setSubject("TAREAS REALIZADAS")
							 ->setDescription("Tareas realizadas por usuario")
							 ->setKeywords("")
							 ->setCategory("");


$fdp = date('d/m/Y',strtotime($fila['fdp']));

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $fdp)
            ->setCellValue('A2', $us)
            ->setCellValue('A3', 'TAREAS REALIZADAS')
            ->setCellValue('A4', 'Tareas Casino')
            ->setCellValue('B4', 'Descripcion de la Tarea')
            ->setCellValue('C4', 'Hora')
            ->setCellValue('D4', 'Comentarios');
mysql_free_result($res);
//vacio la consulta para poder generar correctamente los archivos excel
$res = $diario->obtiene_tareas_usuario($user,$hoja);
$i=5;
while($filan = mysql_fetch_array($res)){
    $t=substr($filan['n_tarea'],5,3);
    switch($t){
        case 'SFE':
            $texto = "Casinos Santa Fe";
            break;
        case 'CVC':
            $texto = "Casino Victoria";
            break;
        case 'BCO':
            $texto = "Bingos CODERE";
            break;
        case 'CSP':
            $texto = "Casino 7 Saltos";
            break;
        case 'MDP':
            $texto = "Casinos Bs. As.";
            break;
        case 'TTA':
            $texto = "Turno Tarde";
            break;
        case 'TNO':
            $texto = "Turno Noche";
            break;
        case 'OPE':
            $texto = "Nombre Operadores";
            break;
        case 'SUP':
            $texto = "Supervisores";
            break;
        case 'TEM':
            $texto = "Temperatura";
            break;
        case 'MON':
            $texto = "Monitoreo";
            break;
        case 'COM':
            $texto = "Comentarios";
            break;
    }
    $est=$diario->obtiene_estado_tarea($filan['id_tarea'],$hoja);
    $rst = mysql_fetch_array($est);
    $valor = $filan['valor']." - ".$rst[0];
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $texto)
            ->setCellValue('B'.$i, $filan['d_tarea'])
            ->setCellValue('C'.$i, $filan['hora'])
            ->setCellValue('D'.$i, $valor);
    $i++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('TAREAS');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$fdp = date('d-m-Y',strtotime($fila['fdp']));
$archivo = $fdp."-".$us.".xlsx";
$dir="C:/xampp/htdocs/checklist/generados/".$archivo;
//$dir = "C:/Users/jfernandez/Downloads/generados/".$archivo;
// Save Excel 2007 file
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
//$objWriter->save("C:\Users\jfernandez\Downloads\generados\Tareas.xlsx");

// Save Excel 95 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
$objWriter->save($dir);
//echo 'Se creo el archivo en: ' , getcwd() , EOL;

?>    

		
</body>
</html>