<?php
include("clases/c_usuario.php");
$id = $_GET['usuario'];
$nuser=$_GET['nuser'];
$fd = $_GET['fd'];
$fh = $_GET['fh'];
$cluser = new usuario;
$datos = $cluser->obtiene_log($id,$fd,$fh);

function cleanData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// file name for download
//$filename = date('d-m-Y') . ".xlsx";
$filename = $nuser.'-desde'.$fd.'hasta'.$fh.'.xlsx';

header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");//Office 2007
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=\"$filename\"");

/*
header("Content-Disposition: attachment; filename=\"$filename\"");
header("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Type: application/vnd.ms-excel");*/

$flag = false;
while ($row = mysql_fetch_assoc($datos)) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\n";
}

exit;

?>