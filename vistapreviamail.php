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
session_start();
//CTRL viene de mailcierre.php con valor 1 significa que debera cerrar turnos abiertos
//CTRL==0 no existen turnos abiertos
if(isset($_GET['ctrl'])){   
    $ctrl = $_GET['ctrl'];
}
include('clases/c_diario.php');
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
header("location: enviamail.php?archivo=$dir&ctrl=$ctrl");