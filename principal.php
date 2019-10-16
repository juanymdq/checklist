<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CHECKLIST v 3.0</title>

<style>
#fdppc{    
    width: 100%;
    background-color:#6CF;
    margin: 0px 0px 0px 0px;
    font-size: 20px;
    color: navy;
    text-align: center;
    border:black 1px solid;
}

</style>
</head>
<body>
<? ob_start(); ?>
<div id='wrapper'>
    <div id='container'>
        
        <div id='cabeza'><?php include ("fechahora.php");?> </div><!-- HEADER -->
        <div id='menu'> <?php include ("menu.php"); ?> </div>
        <?
        include('clases/c_hoja.php');
        $hoja = new hoja;
        $res = $hoja->obtiene_ultima_fecha_abierta_hoja();
        $fdp = mysql_fetch_array($res);
        if(!(empty($fdp[0]))){
            $fch = date('d/m/Y',strtotime($fdp[1]));
            $_SESSION['id_hoja']=$fdp[0];
        ?>             
            <div id='fdppc'>FDP:<? echo $fch. " - ABIERTA" ?></div>
        <?
        /*if(isset($_SESSION['fdp'])){
            if($_SESSION['estado']=='ABIERTA'){*/
                    //<?echo $_SESSION['fdp']." - ".$_SESSION['estado'] 
        }
        
        ?> 
        <div id='content'>
            <?php						
                if(!isset($_GET['id'])){
                    /*if(isset($_SESSION['id_nivel'])){//Verifica que NIVEL este seteado
                        if($_SESSION['id_nivel']==3){
                            include ('bienvenida.html');//Pantalla de bienvenida a SUPERVISORES
                        }else{
                            if($_SESSION['id_nivel']==2){
                                include ('bienvenidaop.html');//Pantalla de bienvenida a OPERADORES
                            }
                        }
                    } */
                    include('vistafichaje.php') ;
                }else{
                    include ($_GET['id'].'.php');													
                }
            ?>
        </div>
        <div id='foot'><?php include ("pie.php");?> </div>
    </div>
</div>
<? ob_end_flush(); ?>
</body>
</html>


<!--   
*****************VERSIONES******************
-1.0 - 01/04/2016: INICIO DE PROGRAMA
-2.4 - 27/10/2016: AGREGADO DE CHECK DE MOVIMIENTO DE MAQUINAS




Las funciones de control de salida te permiten escojer en que momento enviar el resultado de un script al navegador, lo que nos servirá por ejemplo si queremos enviar encabezados cuando ya se ha generado parte de la página, o calcular el peso de la página...

Esto se hace almacenando en un bufer el resultado del código en lugar de enviarlo al navegador, de esta manera, no se ha enviado nada al navegador y se puede seguir enviando encabezados, o se puede medir el contenido del buffer...

Lo primero que haremos es empezar a almacenar la salida en el buffer con ob_start(), y todo lo que vaya hacia la página a partir de entonces quedara en el bufer.

Luego pondremos el contenido de la página que queramos incluyendo headers y cookies, y finalmente pondremos ob_end_flush() para enviar el contenido del buffer al navegador.

Otras funciones que podemos usar para trabajar con el buffer són:
ob_clean - Borra el contenido del buffer
ob_end_clean() - Vacía el contenido del búfer sin enviarlo al navegador y para de guardar en el búffer
ob_flush() - Envia el contenido del buffer al navegador y sigue guardando en el buffer
ob_get_contents() - Devuelve el contenido del buffer
ob_get_length() - Devuelve la longitud del contenido del buffer

-->