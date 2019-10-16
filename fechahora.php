<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="jquery-1.7.2.min.js"></script>
<script src="jquery.js"></script>
<title>S.I.A</title>
<style>
#titulo{
    font-size: 30px;    
}
#reloj{
    float: left;
    margin-top:-1em;
}
#fechahora{
    margin:-1em 0 0px 480px;
    float: left;
}
</style>

<script language="javascript">

function muestraReloj() {
     
	var fechaHora = new Date();
	var horas = fechaHora.getHours();
	var minutos = fechaHora.getMinutes();
	var segundos = fechaHora.getSeconds();
	if(horas < 10) { horas = '0' + horas; }
	if(minutos < 10) { minutos = '0' + minutos; }
	if(segundos < 10) { segundos = '0' + segundos; }
	document.getElementById("reloj").innerHTML = horas+':'+minutos+':'+segundos;
    var h = horas+':'+minutos+':'+segundos;
    
    if(h=='23:45:00'){    
        
        var coment = $.ajax({
            url:"editar.php?val=5",
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idu:0,idh:0,idt:0,h:0,v:0,p:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto       
       if(coment != ''){
            idh = coment;
            alert('SE CERRARA AUTOMATICAMENTE LA FDP ACTUAL');
            //res = coment.split()
            $.ajax({url:"editar.php?val=2",cache:false,type:"POST",data:{idh:idh,idu:1,h:h}});            
            window.location.href = 'principal.php?id=fichaje';            
       }    
       
       //var idu = document.getElementById('iduser').value;      
       $.ajax({url:"editar.php?val=4",cache:false,type:"POST",data:{idh:0,idu:0}});        
    }
    /*if(h=='00:00:00'){
       window.location.href = 'principal.php?id=hoja_principal'; 
    }*/
}
	window.onload = function() {
	setInterval(muestraReloj, 1000);
    
}

</script>
</head>
<body>

<div id="titulo">SEGUIMIENTO DE TAREAS DIARIAS DE CDC MAR DEL PLATA</div>
<?php 
	date_default_timezone_set("America/Argentina/Buenos_Aires");
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
    $dia = $dias[date('w')];
    $mes = $meses[date('n')];
    echo "<div id='fechahora'>- ".$dia . " " . date('j') . " de " . $mes . " de " .date('Y')." -</div>";					
	unset($mes);					
	unset($dia); 
    
?>

<div id="reloj"></div>

</body>
</html>