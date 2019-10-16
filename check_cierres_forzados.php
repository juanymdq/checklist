<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="jquery-1.7.2.min.js"></script>
<style>
/**************************/
    /***movimientos pendientes*/
    #mov_iniciados{
        float: left;
        /*border: green 1px solid;*/
        margin: 85px 0 0 400px;
        width: 500px;
        height: 150px;
    }
    #t_movini{
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        font: 10px;
        color: navy;
        text-decoration: underline;
        padding: 10px 0 0 50px;
        margin: 0 50px 0 0;
    }
    #cont_movini{        
         width: 400px;
         height: 100px;        
         text-align: center;
         margin: 10px 0 0 50px;
    }
    #pend{
        width: 230px;
        float: left;
        margin: 0 0 0 15px;
    }
    #linkpend{
        float: left;
        margin: 0 0 0 3px;
    }
    #fdp{
        float: left;
        font-size: 20px;
        margin: 40px 20px 0 20px; 
    }
    #cierre{
        float: left;
        font-size: 16px;
        margin: 40px 0px 0 0px;
    }
    /****************************/
</style>
<script>
function cierra_fdp(){  
    var Fdp = document.getElementById('fdp').value;//obtiene la fecha del input oculto    
    var resp = confirm("Esta por cerrar la fecha: "+Fdp+". Esta seguro de hacerlo?");
    if (resp == true) {
        //cierra todos los turnos abiertos
        //$.ajax({url:"editar.php?val=4",cache:false,type:"POST",data:{idt:0,idh:0,idu:0,h:0,v:0,p:0}});   //Inserta los datos a la bd sin recargar la pagina
        //id de hoja
        var idh = document.getElementById('idhoja').value;                
        var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
        //obtiene la hora de la funcion homonima
        var h = obtiene_hora();
        //edita la hoja a CERRADA con el id hoja del input oculto
        $.ajax({url:"editar.php?val=2",cache:false,type:"POST",data:{idt:0,idh:idh,idu:idu,h:h,v:0,p:0}});   //Inserta los datos a la bd sin recargar la pagina
        //FUNCION QUE CIERRA TODOS LOS TURNOS
        cierra_turnos();
        //redirecciona a hoja principal
        window.location.href = 'principal.php?id=hoja_principal&accion=1';
    }
}
function cierra_turnos(){
    //cierra todos los turnos abiertos
    $.ajax({url:"editar.php?val=4",cache:false,type:"POST",data:{idt:0,idh:0,idu:0,h:0,v:0,p:0}});   //Inserta los datos a la bd sin recargar la pagina
}
//obtiene la hora formateada
function obtiene_hora(){
    var d = new Date();
    horas = d.getHours();
    minutos = d.getMinutes();
    segundos = d.getSeconds();
    if(horas < 10){
        horas = '0'+horas;
    }
    if(minutos < 10){
        minutos = '0'+minutos;
    }
    if(segundos < 10){
        segundos = '0'+segundos;
    }
    return(horas+':'+minutos+':'+segundos); 
}

</script>
</head>
<body>
<div id="mov_iniciados">
    <div id="t_movini"> FECHA DE PRODUCCION</div>
    <div id="cont_movini">
        <?php  		
        //include("clases/c_hoja.php");
        //$hoja = new hoja;			
        if(isset($_GET['edita'])){
            if($_GET['edita']==1){                
                echo "<div>SE CERRO LA FDP DE PRODUCCION</div>";
            }
        }										                            
        $res = $hoja->obtiene_ultima_fecha_abierta_hoja(); 
         
        while($fila = mysql_fetch_array($res)){       
            //$fila[0] = id_hoja
            //$fila[1] = MAX(fdp)  
            if($fila[0]==null){
                echo "<div id='fdp'>NO EXISTE FECHA DE PRODUCCION ABIERTA</div>";
            }else{
                list($año, $mes, $dia) = explode("-",$fila[1]);      
                $fecha = $dia."/".$mes."/".$año; 
                echo "<input type='hidden' value='$fila[0]' id='idhoja'/>";
                echo "<input type='hidden' value='$fecha' id='fdp'/>";
                
                echo "<div id='fdp'>".$fecha."</div><div id='cierre'><input type='button' value='FORZAR CIERRE' id='btncerrar' onclick='cierra_fdp()'/></div>";
            }     
        }                                                           
        mysql_free_result($res);
        ?>     		
    </div>   
</div>
</body>
</html>