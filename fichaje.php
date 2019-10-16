<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="jquery-1.7.2.min.js"></script>
<script src="jquery.js"></script>
<script src="js/jquery.contextMenu.js"></script>
<script src="js/jquery.ui.position.js"></script>
<script>
var id_user = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
var idu = id_user;
var f;//variable fecha
var he;//variable hora entrada
var hs;//variable hora salida
//funcionalidad de boton ingreso---------------------------------------
$(document).ready(function(){ 
    $("#b_ingreso").click(function() {         
        f = verifica_entrada();
        he = obtiene_hora();
        //obtenemos la ultima fecha de ingreso del usuario 
        var coment = $.ajax({
            url:"fichajeinsertar.php?val=1",
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idu:idu,f:f,he:he,hs:0,je:0,js:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto 
        //si la fecha obtrenida es igual a la actual, indica que el usuario ya posee un ingreso       
       if(coment==f){
        alert('YA EXISTE UN INGRESO');
       }else{               
         controla_ingresos();     
       }
    });
});
//funcionalidad del boton egreso---------------------------------------
$(document).ready(function(){ 
    $("#b_egreso").click(function() {   
      f = obtiene_fecha();   
      hs = obtiene_hora();   
    //obtenemos la ultima fecha de ingreso del usuario 
        var coment = $.ajax({
            url:"fichajeinsertar.php?val=1",    //val=1 consulta la ultima fecha de entrada en bd
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idu:idu,f:0,he:0,hs:0,je:0,js:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto         
        
        var control = controla_horas();       
        f=coment; //coloca la ultima fecha en bd para insertar la hora de salida        
        if(control==1){//1:si cumplio las 8 horas            
            //val=3 indica que modificara el horario de salida en el utlimo registro de la bd
            $.ajax({url:"fichajeinsertar.php?val=3",cache:false,type:"POST",data:{idu:idu,f:f,hs:hs}});
            fch = obtiene_fecha_formateada();
            alert('FECHA: '+fch+'\nHORA SALIDA: '+hs);
            window.location.href = 'principal.php?id=fichaje';
            document.getElementById('b_ingreso').disabled=false;
            document.getElementById('b_egreso').disabled=true;
            document.getElementById('td_ingreso').style.backgroundColor = 'green';
            document.getElementById('b_ingreso').style.backgroundColor = 'lightgreen';
            document.getElementById('td_egreso').style.backgroundColor = 'gray';
            document.getElementById('b_egreso').style.backgroundColor = 'gray';
            document.getElementById('d_fichaje').style.color = 'red';
        }else{  //control==2 si pasaron mas de 8 horas, debera justificar -
                //control==0 si es menor a 7 horas (se retira antes), debera justificar -  
            controlar_form(); 
            $('#popups').fadeIn('slow'); //abre un formulario de justificacion
            $('.popup-overlay').fadeIn('slow');
            $('.popup-overlay').height($(window).height());
        }
        
  });
});        
//verifica el horario de ingreso y egreso    
function controla_horas(){
    hs = obtiene_hora();
    var coment = $.ajax({   //consulta la ultima hora de ingreso
        url:"fichajeinsertar.php?val=5", //val=5 consulta la ultima hora de entrada en bd
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idu:idu,f:0,he:0,hs:0,je:0,js:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto
    var elem = coment.split(':');//separo la hora en tres campos
    horaE = elem[0];//extrae la hora de entrada que viene de la bd 
    horaS = parseInt(hs.substr(0,2));  //extrae la hora de salida
    if(horaE > horaS){
        dif = (24 - horaE) + horaS;      
    }else{
        dif = horaS - horaE;
    }    
    if(dif < 7){//si se retira antes
        return 0;
    }else if(dif >= 7 && dif <= 9){//si cumplio el horario
        return 1;
    }else if(dif > 9){//si se olvido de fichar o pasaron mas de 8 horas
        return 2;
    }
}
/*-------------------------------------------------------------------*/
/*-------------------------------------------------------------------*/
/*-------------------------------------------------------------------*/
//OBTIENE FECHA Y HORA DEL SEVIDOR
function obtiene_fecha(){    
    var coment = $.ajax({   //consulta la ultima hora de ingreso
        url:"fichajeinsertar.php?val=6", //val=6 obtiene la fecha y hora del servidor
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idu:0,f:0,he:0,hs:0,je:0,js:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto    
    var elem = coment.split(' ');//separo fecha de hora    
    return elem[0];
    //var hora = elem[1];
    
}
//verifica si se esta entrando en el horario de las 23:00.
//si es asi, ya se esta trabajando el dia siguiente.
function verifica_entrada(){
    var fecha = obtiene_fecha();       
    var hora = obtiene_hora();
    if(hora >= '22:30'){
        var fch = fecha.split('-');
        var dia = parseInt(fch[2]) + 1;
        return fch[0]+'-'+fch[1]+'-'+dia;
    }else{
        return fecha;
    }
}
function obtiene_hora(){    
    var coment = $.ajax({   //consulta la ultima hora de ingreso
        url:"fichajeinsertar.php?val=6", //val=6 obtiene la fecha y hora del servidor
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idu:0,f:0,he:0,hs:0,je:0,js:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto    
    var elem = coment.split(' ');//separo la fecha de hora
    return elem[1];
    //var hora = elem[1];
    
}
/*-------------------------------------------------------------------*/
/*-------------------------------------------------------------------*/
/*-------------------------------------------------------------------*/   

//obtiene la fecha con formato dd/mm/YYYY. Simplemente como presentacion
function obtiene_fecha_formateada(){
    var fch = verifica_entrada();
    var fecha = fch.split('-');
    return(fecha[2]+'/'+fecha[1]+'/'+fecha[0]);
}

//verifica si se esta ingresando tarde. Por lo tanto se debera justificar
function controla_ingresos(){    
    var ingreso = obtiene_hora();   //obtiene la hora del ingreso
    //mediante desiciones verifica si esta ingresando tarde segun los turnos de CDC
    if((ingreso > "07:15:00") && (ingreso < "07:45:00")){   //turno mañana     
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else if((ingreso > "15:15:00") && (ingreso < "18:45:00")){   //turno tarde
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else if((ingreso > "23:15:00") && (ingreso < "23:59:59")){   //turno noche
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else if((ingreso > "08:15:00") && (ingreso < "13:00:00")){     //turno jefe   
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else if((ingreso > "14:15:00") && (ingreso < "14:45:00")){   //turno supervisor tarde
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else if((ingreso > "19:15:00") && (ingreso < "21:45:00")){   //turno supervisor intermedio
        controlar_form(); 
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
    }else{  //si esta ingresando dentro del horario reglamentado, inserta la hora sin justificar
        //val=0 indica que insertara el registro en la bd con la fecha y la hora de ingreso
        $.ajax({url:"fichajeinsertar.php?val=0",cache:false,type:"POST",data:{idu:idu,f:f,he:he}});           
        fch = obtiene_fecha_formateada();   //fecha formateada para presentar
        alert('FECHA: '+fch+'\nHORA INGRESO: '+he); //muestra la fecha y hora de ingreso
        window.location.href = 'principal.php?id=fichaje';  //recarga la pagina para mostrar el ultimo ingreso
        document.getElementById('b_ingreso').disabled=true; //deshabilita el boton ingreso  
        document.getElementById('b_egreso').disabled=false; //habilita el boton ingreso
        document.getElementById('td_ingreso').style.backgroundColor = 'gray';   //pinta el td ingreso de gris
        document.getElementById('b_ingreso').style.backgroundColor = 'gray';    //pinta el boton ingreso de gris
        document.getElementById('td_egreso').style.backgroundColor = 'red';     //pinta el td de salida de rojo
        document.getElementById('b_egreso').style.backgroundColor = 'salmon';   //pinta el boton de salmon
        document.getElementById('d_fichaje').style.color = 'green';    //
    }
     
}
//funcionalidad del boton aceptar del formulario justificaciion de salida
$(document).ready(function(){    
    $('#btnaceptars').click(function(){
        var texto = document.getElementById('cpends').value;    //coloca el texto de la justificacion
        if(texto==''){
            alert('Debe colocar una justificacion');
        }else{                         
            js=texto;   //en variable js coloca la justificacion de salida
            //val=4 indicara que modificara el registro con la justificacion y la hora de salida           
            $.ajax({url:"fichajeinsertar.php?val=4",cache:false,type:"POST",data:{idu:idu,f:f,hs:hs,js:js}});   //Inserta los datos a la bd sin recargar la pagina          
            fch = obtiene_fecha_formateada();
            alert('FECHA: '+fch+'\nHORA EGRESO: '+hs);
            window.location.href = 'principal.php?id=fichaje';            
            document.getElementById('b_ingreso').disabled=false;
            document.getElementById('b_egreso').disabled=true;
            document.getElementById('td_ingreso').style.backgroundColor = 'green';
            document.getElementById('b_ingreso').style.backgroundColor = 'lightgreen';
            document.getElementById('td_egreso').style.backgroundColor = 'gray';
            document.getElementById('b_egreso').style.backgroundColor = 'gray';
            document.getElementById('d_fichaje').style.color = 'red';            
        }
    });
});
//funcionalidad del boton aceptar del formulario justificaciion de entrada
$(document).ready(function(){    
    $('#btnaceptare').click(function(){
        var texto = document.getElementById('cpende').value;
        if(texto==''){
            alert('Debe colocar una justificacion');
        }else{                         
            je=texto;                
            //val=2 indica que inserta en la bd pero con justificacion
            $.ajax({url:"fichajeinsertar.php?val=2",cache:false,type:"POST",data:{idu:idu,f:f,he:he,je:je}});          
            fch = obtiene_fecha_formateada();
            alert('FECHA: '+fch+'\nHORA INGRESO: '+he);
            window.location.href = 'principal.php?id=fichaje';
            document.getElementById('b_ingreso').disabled=true;  
            document.getElementById('b_egreso').disabled=false;
            document.getElementById('td_ingreso').style.backgroundColor = 'gray';
            document.getElementById('b_ingreso').style.backgroundColor = 'gray';
            document.getElementById('td_egreso').style.backgroundColor = 'red';
            document.getElementById('b_egreso').style.backgroundColor = 'salmon';
            document.getElementById('d_fichaje').style.color = 'green';
        }
    });
});
function controlar_form(){
    //deshabilita todos los controles del form1
    deshabilita_ctrl();
    //pinta el fondo de color gris transparente        
    $("body").css({'position':'fixed','left':'0','top':'0','background-color':'#ccc','opacity':'0.6','filter':'alpha(opacity=60)'});
}
function deshabilita_ctrl(){
    document.getElementById('b_ingreso').disabled = true;
}
function habilita_ctrl(){
    window.location.href = 'principal.php?id=fichaje'    
}

</script>
<style>
h2{
    margin: 5px 0 0 0;
}
#t_fichaje{
    width: 600px;
    margin: 20px 0 0 300px;
    border: green 1px solid;    
}
/*#td_ingreso{
    background-color: grey;
}
#td_egreso{
    background-color: red;
}*/

#b_ingreso{
    background-color: lightgreen;
}
#b_egreso{
    background-color: salmon;
}
#t_fichaje td{
    padding: 10px 20px 10px 20px;
}
/*TABLA DE 5 ULTIMOS FICHAJES*/
#d_fichaje{
    width: 750px;
    height: 210px;
    /*border: green 1px solid;*/ 
    margin: 0 0 0 180px;
    font-size: 20px;
    color: green;
    padding: 0px 0px 0px 0px;
}
#t_muestra_fichaje{
    margin: 5px 0 0 0;
    padding: 0 5px 0 0;
}
#td_hora{
    border-top:green 1px solid;
    border-left:green 1px solid;
    border-right:green 1px solid;
    border-bottom:green 1px solid;
    color: blue;
    padding: 0 20px 0 20px;
}
#td_entrada{
    border-top:green 1px solid;
    border-left:green 1px solid;
    border-right:green 1px solid;
    border-bottom:green 1px solid;
    padding: 0 20px 0 20px;
}
#td_salida{
    border-top:green 1px solid;
    border-left:green 1px solid;
    border-right:green 1px solid;
    border-bottom:green 1px solid;
    color: red;
    padding: 0 20px 0 20px;
}
#td_juste{
    border-top:green 1px solid;
    border-left:green 1px solid;
    border-right:green 1px solid;
    border-bottom:green 1px solid;
    padding: 0 20px 0 20px;
}
#td_justs{
    border-top:green 1px solid;
    border-left:green 1px solid;
    border-right:green 1px solid;
    border-bottom:green 1px solid;
    color: red;
    padding: 0 20px 0 20px;
}
#td_ficha{
    border-bottom:green 1px solid;
}
/*-------------------------------*/
#d_titulo{
    width: 500px;
    height: 30px;        
    border: green 1px solid; 
    margin: 20px 0 10px 350px;
    font-size: 20px;
    color: green;
    font-weight: bold;
}
#d_exportar{
    width: 200px;
    height: 50px;
    border: green 1px solid; 
    margin: 20px 0 0 0;
    font-size: 30px;
    color: green;
    padding: 5px 5px 5px 5px;
}
/*--------FORM MODAL DE PENDIENTES-----------------------*/

#popupe {
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1001;
}
#popups {
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1001;
}
.content-popup {
    margin:0px auto;
    margin-top:120px;
    position:relative;
    padding:10px;
    width:360px;
    min-height:10px;
    border-radius:4px;
    background-color: black;
    box-shadow: 0 2px 5px #666666;
}

.content-popup h2 {
    color:#48484B;
    border-bottom: 1px solid #48484B;
    margin-top: 0;
    padding-bottom: 4px;
}

.popup-overlay {
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 999;
    display:none;
    background-color: #777777;
    cursor: pointer;
    opacity: 0.7;
}

.close {
    position: absolute;
    right: 15px;
}
#baceptar{
    float: left;
    margin: 20px 0 0 70px;    
    
}
#fmodal{
    padding: 5px 55px 5px 5px;
    background-color: aqua;
    width: 340px;
    height: 230px;
}
h2{
    font-size: 16px;
}
#dtpend{
    padding-bottom: 5px;
}
#cpend{
    resize: none;
}
#tpenda{
    text-align: center;
}
#titulo{
    font-size: 16px;
    font-weight: bold;
    padding-bottom: 10px;
}
#subtitulo{
    font-size: 14px;
    font-weight: bold;
    padding-bottom: 10px;
    color: red;
}
/*-------------------------------*/
</style>

</head>

<body>
<div id="d_titulo">FICHAR INGRESO/EGRESO A CDC</div>
<table id="t_fichaje">
    <tr>
        <td id="td_ingreso"><input type="button" value="INGRESO" style='width:100px; height:50px' id="b_ingreso" /></td>
        <td>-</td>
        <td id="td_egreso"><input type="button" value="EGRESO" style='width:100px; height:50px' id="b_egreso" /></td>
    </tr>
</table>
<h2>ULTIMOS 5 INGRESOS</h2>
<div id="d_fichaje">
    <?
    include('clases/c_fichaje.php');
    $mficha = new fichaje;  
    $res = $mficha->obtiene_5_fichajes(); 
    ?>
    <table id="t_muestra_fichaje">
    <tr id="tr_ficha">
        <td  id="td_hora">FECHA</td>
        <td id="td_entrada">HORA ENTRADA</td>
        <td id="td_salida">HORA SALIDA</td>
        <td id="td_juste">JUSTIFICACION ENTRADA</td>
        <td id="td_justs">JUSTIFICACION SALIDA</td>
    </tr>
        <?
        while($fila = mysql_fetch_array($res)){?>
          <tr>  
          <td id="td_hora"><? echo date('d/m/Y',strtotime($fila[2])) ?></td>
          <td id="td_entrada"><? echo $fila[3] ?></td>
          <td id="td_salida"><? if($fila[4]=='00:00:00') {echo '-';}else{echo $fila[4];} ?></td>
          <td id="td_juste"><? echo $fila[5] ?></td>
          <td id="td_justs"><? echo $fila[6] ?></td>
           </tr>    
        <?
        }            
        ?>
    </table>
</div>
<div id="popupe" style="display: none;">
    <div class="content-popup">                
        <div id="fmodal">
            <div><input type="hidden" id="texto"/></div>
            <div id="titulo">JUSTIFICAR ENTRADA TARDE</div>
            <div><textarea cols="39" rows="4" id="cpende" ></textarea></div>
            <div id="baceptar"><input type="button" id="btnaceptare" value="Aceptar" /></div>                    
        </div>
    </div>
</div>
<div id="popups" style="display: none;">
    <div class="content-popup">                
        <div id="fmodal">
            <div><input type="hidden" id="texto"/></div>
            <div id="titulo">JUSTIFICAR SALIDA</div>
            <div><textarea cols="39" rows="4" id="cpends" ></textarea></div>
            <div id="baceptar"><input type="button" id="btnaceptars" value="Aceptar" /></div>                    
        </div>
    </div>
</div>
</body>
</html>
<?
$mficha->usuario = $_SESSION['id_usuario'];
$res = $mficha->obtiene_ultimo_fichaje();
$fila = mysql_fetch_array($res);
if(strcmp($fila[4],'00:00:00')==0){
    echo "<script> 
                           
        document.getElementById('b_ingreso').disabled=true;  
        document.getElementById('b_egreso').disabled=false;
        document.getElementById('td_ingreso').style.backgroundColor = 'gray';
        document.getElementById('b_ingreso').style.backgroundColor = 'gray';
        document.getElementById('td_egreso').style.backgroundColor = 'red';
        document.getElementById('b_egreso').style.backgroundColor = 'salmon';
        document.getElementById('d_fichaje').style.color = 'green';
    </script>";
}else{    
    echo "<script>            
        document.getElementById('b_ingreso').disabled=false;  
        document.getElementById('b_egreso').disabled=true;
        document.getElementById('td_ingreso').style.backgroundColor = 'green';
        document.getElementById('b_ingreso').style.backgroundColor = 'lightgreen';
        document.getElementById('td_egreso').style.backgroundColor = 'gray';
        document.getElementById('b_egreso').style.backgroundColor = 'gray';            
    </script>";
}
?>
