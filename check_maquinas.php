<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Maquinas</title>
<link rel="stylesheet" href="estilos/jquery.contextMenu.css" />
<script src="jquery.js"></script>
<script src="jquery-1.7.2.min.js"></script>
<script src="js/jquery.contextMenu.js"></script>
<script src="js/jquery.ui.position.js"></script>
<script type="text/javascript">

//VARIABLES GLOBALES
var elimino=false;     
var seconds_left = <? echo $_SESSION['limite'];?>;
  
seconds_left = seconds_left*60;  
// Determinamos la url donde redireccionar con un parametro que sirve para cerrar las SESSIONS en el index 
var url="index.php?caducada=1";
//********************************************************
setInterval(function () {   
    //si se hacen las 23:45 y no se ha cerrado FDP, se procedera a cerrar la misma
    //de manera automatica
    var fechaHora = new Date();
	var horas_act = fechaHora.getHours();
	var min = fechaHora.getMinutes();
	var seg = fechaHora.getSeconds();
	if(horas_act < 10) { horas_act = '0' + horas_act; }
	if(min < 10) { min = '0' + min; }
	if(seg < 10) { seg = '0' + seg; }
	document.getElementById("reloj").innerHTML = horas_act+':'+min+':'+seg;
    var hfdp = horas_act+':'+min+':'+seg;     
    
    //Divide los segundos y coloca el cociente como minutos
    minutos = parseInt(seconds_left / 60);
    //Agrega un 0 a la izquierda si los minutos son menores a 10
    if(minutos < 10){
        minutos = "0" + minutos;
    }
    //El resto los coloca como segundos
    seconds = parseInt(seconds_left % 60);
    //Agrega un 0 a la izquierda si los segundos son menores a 10
    if(seconds < 10){
        seconds = "0" + seconds;
    }
    //Muestra el tiempo restante en la etiqueta "Cuenta Atras"
    document.getElementById('CuentaAtras').innerHTML = "La sesi\u00f3n expira en: " + minutos + ":" + seconds;
    //Controla que se expire la sesion cuando se haya terminado todo el tiempo 
     if(minutos==0){
        if(seconds==0){
            //Cuando se agote el tiempo, redirige al index.php
            window.location=url;   
        }        
     }else{
        if(minutos==0){
            window.location=url;
        }          
    }
     //Restamos un segundo al tiempo restante 
    seconds_left-=1;
    
    
}, 1000);  

      //Todos los objetos con la propiedad CLASS="check", realizaran esta funcion.
    //guarda las tareas que poseen checkbox. Guarda la hora, el usuario, el estado

 $(document).ready(function(){
        var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
        var ida = document.getElementById('id_mov').value;//id del movimiento guardado al ingresar al check 
        var user = '<? echo $_SESSION['usuario']; ?>';//nombre de usuario
        //document.getElementById('user').value = id_user;
        $(".check").click(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas check              
              var idt = $(this).attr("value"); // Le pasa el valor del checkbox TAREA              
              var resp = confirm("Desea guardar la tarea "+idt+" ?");
              if (resp == true) {                     
                  var tiempo = new Date();  //obtiene la fecha y hora                     
                  var horas = tiempo.getHours();    //extrae las horas
                  var minutos = tiempo.getMinutes();    //extrae los minutos
                  var segundos = '00';
                  if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
        		      minutos = '0'+minutos;
      	          }  
                  var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora       
                      
                  document.getElementById('hora'+idt).value = hora;  //inserta la hora en el campo de hora
                  var g = '- TAREA '+idt+' REALIZADA -\nUsuario: '+user;//pasa el usuario que realizo la tarea
                  var e = 1;
                  
                  var h=hora; //pasa la hora                   
                  $.ajax({url:"inserta_mov.php?val=3",cache:false,type:"POST",data:{idt:idt,idu:idu,ida:ida,fmov:0,d:0,fact:0,h:h,e:e,g:g}});   //Inserta los datos a la bd sin recargar la pagina
                  
                  //seconds_left = seconds_left*60;
                  $("#checkbox"+idt).attr("disabled", true); //deshabilita el checkbox                   
                  $('#'+idt).css("background-color", "LightGreen");
                  envio_mail(idt);                                                        
              }else{    //resp == FALSE      
                  $("#checkbox"+idt).attr("checked", false); //deshabilita el checkbox */
              } 
                          
        });
    
     //--------------------------------------------------------------------------------------------------------
//Todos los objetos con la propiedad CLASS="text", realizaran esta funcion.
//Se guardan los datos que se cargan en input type TEXT
    $(".text").change(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas text
          var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
          var ida = document.getElementById('id_mov').value;//id del movimiento guardado al ingresar al check 
          var user = '<? echo $_SESSION['usuario']; ?>';//nombre de usuario
          var id = $(this).attr("name"); // Le pasa el name del text
                      
          var tiempo = new Date();  //obtiene la fecha y hora
          var horas = tiempo.getHours();    //extrae las horas
          var minutos = tiempo.getMinutes();    //extrae los minutos
          var segundos = '00';
          if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
		      minutos = '0'+minutos;
	       }  
          var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
           
          document.getElementById('hora'+id).value = hora;  //inserta la hora en el campo de hora          
          var idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox         
          var d = document.getElementById('control'+id).value; //text de comentarios                  
          var h=hora; //pasa la hora
          var g = '- TAREA '+id+' REALIZADA -\nUsuario: '+user;//pasa el usuario que realizo la tarea
          $.ajax({url:"inserta_mov.php?val=3",cache:false,type:"POST",data:{idt:idt,ida:ida,idu:idu,h:h,d:d,g:g,e:1,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina         
         
          $("#control"+id).attr("disabled", true); //deshabilita el checkbox
          $('#'+id).css("background-color", "LightGreen");
          seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
          seconds_left = seconds_left*60;
         
    });
    //--------------------------------------------------------------------------------------------------------
    //Todos los objetos con la propiedad CLASS="select", realizaran esta funcion.    
    $(".select").change(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas select
        var id = $(this).attr("name"); // Le pasa el valor del select           
        var sel = $("#select"+id+" option:selected").html();       
        if(sel!='SELECCIONAR'){
          var id = $(this).attr("name"); // Le pasa el valor del select           
          var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
          var ida = document.getElementById('id_mov').value;//id del movimiento guardado al ingresar al check   
          var tiempo = new Date();  //obtiene la fecha y hora
          var horas = tiempo.getHours();    //extrae las horas
          var minutos = tiempo.getMinutes();    //extrae los minutos
          var segundos = '00';
          if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
		      minutos = '0'+minutos;
	       }  
          var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora    
              
          var resp = confirm("Desea guardar la tarea "+id+" ?");
          if (resp == true) {  
              idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox              
              h=hora; //pasa la hora   
              document.getElementById('hora'+id).value = hora;  //inserta la hora en el campo de hora 
              d=$("#select"+id+" option:selected").html();//Le pasa el valor del campo comentarios
              var g = '- TAREA '+id+' REALIZADA -\nUsuario: '+user;//pasa el usuario que realizo la tarea            
              $.ajax({url:"inserta_mov.php?val=3",cache:false,type:"POST",data:{idt:idt,ida:ida,idu:idu,h:h,d:d,g:g,e:1,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina             
              seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
              seconds_left = seconds_left*60;   
              $("#select"+id).attr("disabled", true); //deshabilita el checkbox 
              $('#'+id).css("background-color", "LightGreen");
          }
        }else{
            if(!elimino){//variable que controla si se elimino la tarea, no da el mensaje de error-VIENE DEL MENU CONTEXTUAL "ELIMINAR"
                alert('Debe seleccionar una opcion');
            }
        }
    });     
    
});

//Consulta a la BD si se realizo la tarea
function muestra_caja(id){    
    idt=id;        
    idh=$("#id_mov").val();//id movimiento    
    var coment = $.ajax({
        url:"traecomentarios.php?val=4",
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idt:idt,idh:idh,idu:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto           
     if(coment != ""){    
        //tarea realizada
        alert(coment);
        //window.location.href = 'check_maquinas.php';    
     }else{
        alert('La tarea se encuentra sin realizar');
     } 
}
function trae_valor(id){
    idt=id;        
    idh=$("#id_mov").val();//id movimiento    
    var coment = $.ajax({
        url:"traecomentarios.php?val=4",
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idt:idt,idh:idh,idu:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto           
    return coment;
}
/*---------------------------CIERRA EL MOVIMIENTO----------------------------------------*/
function cierra_mov(){  
    var resp = confirm("Desea completar el movimiento?");
    if (resp == true) {
        var ida = $('#id_mov').attr('value');//id de movimiento
        
        var fch = $('#div_f2').html();//fecha de movimiento
        
        var idu = '<? echo $_SESSION['usuario']; ?>';//nombre de usuario
        
        var fmov = obtiene_fecha_hora();//fecha actual
        
        //edita los datos para cierre
        $.ajax({url:"inserta_mov.php?val=2",cache:false,type:"POST",data:{idu:idu,ida:ida,fmov:fmov}});
        alert('Movimiento Completado');
        window.location.href = 'principal.php?id=check_maquinas_sel_fecha&guardo=true&fecha='+fch;
      }
}  

/*-------------------------*/
function obtiene_fecha_hora(){    
    var d = new Date();    //obtiene fecha completa    
    mes = d.getMonth()+1;  //obtiene mes (0 a 5. Por eso se suma 1)   
    dia = d.getDate();    //obtiene dia actual    
    hora = obtiene_hora(); //obtiene la hora actual 
    
    if(dia < 10){   //agrega un 0 para los dias 0 a 9. Quedaria 09.
        dia = '0'+dia;        
    }
    if(mes<10){ //agrega un 0 para los meses 0 a 9. Quedaria 09.
        mes = '0'+mes;
    } 
    
    return(d.getFullYear()+'-'+mes+'-'+dia+' '+hora); //retorna la fecha de entrada con formato MYSQL (Y-m-d)
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
//----------------------------------------------------------------------------------------------------
/*MENU CONTEXTUAL*/
 $(function() {
        $.contextMenu({
            selector: '.tarea',           
            items: {
                "NOREALIZA": {name: "NO SE REALIZA", icon: "cut",callback: function() {
                        
                        var idt = $(this).attr("id");//id tarea
                        var ida = $('#id_mov').attr('value');//id de movimiento
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';
                        var user = '<? echo $_SESSION['usuario']; ?>';
                        
                        var g = 'NO SE REALIZA - \nUsuario: '+user;
                        
                        var obj = document.getElementById(idt).style.backgroundColor;   
                                     
                        switch(obj){
                            case ''://tarea sin realizar                            
                                //e=4 TAREAS QUE NO SE REALIZAN
                                $.ajax({url:"inserta_mov.php?val=3",cache:false,type:"POST",data:{idt:idt,ida:ida,idu:idu,h:0,d:0,g:g,e:4,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina
                                $('#checkbox'+idt).attr('checked', false);
                                $("#checkbox"+idt).attr("disabled", true); //deshabilita el checkbox                                    
                                $('#'+idt).css("background-color", "lightgoldenrodyellow"); //color amarillo claro
                                if(idt==3){//opcion CASTITO - deshabilita el combo
                                    document.getElementById("select3").disabled=true;
                                }
                                if(idt==6){//opcion de MDC - deshabilita el textbox
                                    document.getElementById("control6").disabled=true;
                                }                                        
                                break;
                                //aca hacemos la tarea de pendiente
                            case 'lightgreen'://tarea realizada
                                alert('La tarea se encuentra realizada');
                                break;
                            case 'LightSkyBlue'://tarea completada
                                alert('La tarea se encuentra completada');
                                break;
                            case '#ff5c54'://taera pendiente color rojo
                                alert('La tarea se encuentra pendiente');
                                break;
                            case 'lightgoldenrodyellow'://LA TAREA NO SE REALIZA
                                alert('La tarea NO SE RELIZA');
                                break;
                        }
                    }
                },
                "PENDIENTE": {name: "Dejar tarea pendiente", icon: "edit", callback: function() {
                        var idt = $(this).attr("id");//id tarea
                        var ida = $('#id_mov').attr('value');//id de movimiento
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';
                        var user = '<? echo $_SESSION['usuario']; ?>';
                        
                        var g = 'PENDIENTE - \nUsuario: '+user;
                        
                        var obj = document.getElementById(idt).style.backgroundColor;   
                                     
                        switch(obj){
                            case '': case 'lightgoldenrodyellow'://tarea sin realizar                            
                                //e=2 para tareas pendientes
                                $.ajax({url:"inserta_mov.php?val=3",cache:false,type:"POST",data:{idt:idt,ida:ida,idu:idu,h:0,d:0,g:g,e:2,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina
                                $('#checkbox'+idt).attr('checked', true);
                                $("#checkbox"+idt).attr("disabled", true); //deshabilita el checkbox                                    
                                $('#'+idt).css("background-color", "#ff5c54"); //color rojo
                                break;
                                //aca hacemos la tarea de pendiente
                            case 'lightgreen'://tarea realizada
                                alert('La tarea se encuentra realizada');
                                break;
                            case 'LightSkyBlue'://tarea completada
                                alert('La tarea se encuentra completada');
                                break;
                            case '#ff5c54'://taera pendiente color rojo
                                alert('La tarea ya se encuentra pendiente');
                                break;
                        }
                    }//fin function pendiente
                },//fin pendiente               
                "COMPLETAR": {name: "Completar Tarea", icon: "confirm", callback: function() {
                        var idt = $(this).attr("id");//id tarea
                        var ida = $('#id_mov').attr('value');//id de movimiento
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';
                        var user = '<? echo $_SESSION['usuario']; ?>';
                        
                        var obj = document.getElementById(idt).style.backgroundColor;   
                                     
                        switch(obj){
                            case ''://tarea sin realizar                            
                                alert('Tarea sin realizar');
                                break;
                                //aca hacemos la tarea de pendiente
                            case 'lightgreen'://tarea realizada
                                alert('La tarea se encuentra realizada');
                                break;
                            case 'LightSkyBlue'://tarea completada
                                alert('La tarea ya se encuentra completada');
                                break;
                            case '#ff5c54': case 'lightgoldenrodyellow'://taera pendiente color rojo
                                var tiempo = new Date();  //obtiene la fecha y hora
                                var horas = tiempo.getHours();    //extrae las horas
                                var minutos = tiempo.getMinutes();    //extrae los minutos
                                var segundos = '00';
                                if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
                    		        minutos = '0'+minutos;
                    	         }  
                                var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
                                var h= hora;
                                var gtemp = trae_valor(idt);
                                var g = gtemp+'\nCOMPLETADA - \nUsuario: '+user;
                                //e=3 para tareas completadas
                                $.ajax({url:"inserta_mov.php?val=4",cache:false,type:"POST",data:{idt:idt,ida:0,idu:0,h:h,d:0,g:g,e:3,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina
                                $('#checkbox'+idt).attr('checked', true);
                                $("#checkbox"+idt).attr("disabled", true); //deshabilita el checkbox                                    
                                $('#'+idt).css("background-color", "LightSkyBlue"); //color rojo
                                break;                                
                           /* case 'yellow'://tarea completada
                                alert('La tarea NO SE RELIZA');
                                break;*/
                        }
                    }//fin function comnpletar
                },//fin completar
                "ELIMINAR": {name: "Eliminar Tarea", icon: "delete", callback: function() {
                        var idt = $(this).attr("id");//id tarea
                        var obj = document.getElementById(idt).style.backgroundColor;   
                        if(obj==''){
                            alert('Imposible eliminar. La tarea no se encuentra realizada');
                        }else{
                            var resp = confirm("Desea eliminar la tarea "+idt+" ?");
                            if (resp == true) {                                
                                var ida = $('#id_mov').attr('value');//id de movimiento
                                $.ajax({url:"inserta_mov.php?val=5",cache:false,type:"POST",data:{idt:idt,ida:ida,idu:0,h:0,d:0,g:0,e:0,fmov:0,fact:0}});   //Inserta los datos a la bd sin recargar la pagina
                                $('#checkbox'+idt).attr('checked', false);//destilda
                                $("#checkbox"+idt).attr("disabled", false); //habilita el checkbox                                 
                                $("#hora"+idt).attr("value","");//elimina la hora
                                $('#'+idt).css("background-color", ""); //elimina el color
                                if(idt==3){//select de opcion CASTITO
                                    document.getElementById("select3").disabled=false;//habilita el combo           
                                    $("#select3").val("SELECCIONAR");//se posiciona en la opcion seleccionar
                                    elimino=true;//Coloca quen true para no mostrar mensaje de error del select                           
                                    $('#select3').change();//realiza el cambio
                                }
                                if(idt==6){//textbox de MDC
                                    document.getElementById("control6").value='';//vacia el text
                                    document.getElementById("control6").disabled=false;//habilita el text
                                }      
                            }
                        }
                    }
                },//fin eliminar
                sep2: "---------",
                    "Reenviar": {//REGENERA PLANTILLA DE MAIL
                        name: "Regenerar Mail",
                        icon: "reenvio",
                        callback: function() {
                            var id = $(this).attr("id");                           
                            envio_mail(id);
                        }
                    }
            }//FIN ITEMS:
        });
    });

function envio_mail(id){
    var fch = document.getElementById('div_f2').innerHTML;
    var enlace="";
    switch(parseInt(id)){        
        case 14: case 39://MAIL A PATRIMONIO    
            var a = document.getElementById('div_a2').innerHTML;  
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=perezali@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=MOVIMIENTOS "+a+" FECHA: "+fch+"&body= Se adjuntan movimientos realizados ","_blank"); 
            break;
        case 13: case 38://MAIL Computos IPLYC
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=dipaunor@loteria.gba.gov.ar;estebces@loteria.gba.gov.ar;recioadr@loteria.gba.gov.ar;gaggiand@loteria.gba.gov.ar;toffedan@loteria.gba.gov.ar;luaceseb@loteria.gba.gov.ar;maldoemi@loteria.gba.gov.ar;vecchgon@loteria.gba.gov.ar;panefra@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Actualizacion FTP&body=Se copio en FTP, en fecha "+fch+" , el/los archivo/s:","_blank");            
            break;       
    }
}

</script>
 <style>
    body{
        background-color: aqua;
    }
    #r_titulo{
        margin: 5px 1px 10px 1px;
        text-align: center;        
        font-weight: bold;
        font-size: 26px;
        text-decoration: underline;
    }   
    #tareas{
        float: left;
        width: 600px;
        height: 185px;        
        margin: 30px 1px 1px 250px;
    }
    #boton{
        float: left;
    }
    #t_tareas{
        text-align: left;
    }
    #t_tareas td{
        border: green 1px solid;
    }
    #t_fdp{
        margin: 30px 1px 1px 1px;
    }  
    #t_botones{
        margin: 20px 0 0 0;
    }
    #t_botones td{        
        padding: 0 100px 0 0;
    }    
    #t_pie{
        text-align: left;
        margin: 20px 0 0 0;
    }
     #t_pie td{
        text-align: left;
     }
    /*------------------ENCABEZADOS--------------------------------*/
    #div_f{/*div de fecha*/    
        float:  left;
        width: 400px;
        font-size: 20px;
        border: green 2px solid;
        text-align: center;
    }
    #div_f1{
       margin: 0 0 0 5px;
       float:  left;
    } 
    #div_f2{
        color: red;
        margin: 0 0 0 10px;
        float:  left;  
    }    
    #div_a{/*div de area*/        
        float:  left;    
        width: 400px;   
        font-size: 20px;
        border: green 2px solid;
        text-align: center;
    }
    #div_a1{
        margin: 0 0 0 5px;
        float:  left;
    }
    #div_a2{
        color: red;
        margin: 0 0 0 10px;
        float:  left;
    }
    #div_ap{/*div de usuario y fecha y hora actuales*/
        float:  left;    
        width: 400px;   
        font-size: 20px;
        border: green 2px solid;
        text-align: center;
    } 
    #div_ap1{
        margin: 0 0 0 5px;
        float:  left;
    }  
    #div_ap2{
        color: red;
        margin: 0 0 0 10px;
        float:  left;  
    }
    #div_d{/*div de descripcion*/
        float:  left;    
        width: 1205px;   
        font-size: 20px;
        border: green 2px solid;
        margin: 5px 0 5px 0;
    }
    #div_d1{
        margin: 0 0 0 5px;
        float:  left;
    }
    #div_d2{
        color: red;
        margin: 0 0 0 10px;
        float:  left;  
    }
    #select3{ /* SELECT de opciones TITO*/
        font-size: 10px;
    }
    /*----------------------------------------------------*/
    /*contiene todo el check*/
    #contenedor {
    width: 1205px;
    height: 1100px;
    border: green 1px solid;
    }
    /*TITULO DE ALTAS Y BAJAS*/
    #alta{
        float: left;
        width: 964px;
        font-size: 20px;
        text-align: center;
        font-weight: bolder;
        border: green 1px solid;
        margin: 1px 1px 1px 1px;
        background-color: cadetblue;
    }
    /*DIV IZQUIERDO*/
    #izquierda{
      float: left;
      width: 460px;
      height: 570px;
      border: green 1px solid;
     margin: 1px 1px 1px 1px;
    }
    /*DIV DERECHO*/
    #derecha {
      float: left;
      width: 503px;
      height: 590px;
      border: green 1px solid;
      margin: 1px 1px 1px 1px;
    }
    /*DIV IZQUIERDO*/
    #b_izquierda{
      float: left;
      width: 460px;
      height: 280px;
      border: green 1px solid;
     margin: 1px 1px 1px 1px;
    }
    /*DIV DERECHO*/
    #b_derecha {
      float: left;
      width: 503px;
      height: 280px;
      border: green 1px solid;
      margin: 1px 1px 1px 1px;
    }
    /*-------------------------------------------------------*/
    /*-------------------------------------------------*/
/*-----------------TABLAS DE TAREAS----------------*/
    #encabezado_tabla{
        font-size: 18px;
        text-align: center;
        background-color: aquamarine
    }
    #tabla{
        font-size: 10px;
        border: green 1px solid;
        margin: 1px 1px 1px 1px;
    }
    #tabla td{    
        border: green 1px solid;      
    }
    #c_tabla{
        margin: 15px 0 0 20px;
    }
    #tdc_tabla{
        width: 20px;
        height: 20px; 
    }  
    .tarea{
        font-size: 12px;
        width: 200px;   
    } 
    .check{
        width: 160px;
    }
    #control6{        
        text-align: center;
    }
    /*----------------------------------------------------------*/
    /*CSS DE MENU - INCLUYE LA FDP Y EL BOTON DE CERRAR*/
    #menu{
        float: left;
        width: 170px;
        height: 410px;
        border: green 1px solid;
        margin: 1px 1px 1px 30px;
    }
    #t_menu{
        width: 14px;
        margin: 0 0 0 30px;
    }
    #menuII{
        float: left;
        width: 170px;
        height: 120px;
        border: green 1px solid;
        margin: 1px 1px 1px 30px;
    }
    #t_menu tr{
        font-size: 18px;
        border: green 1px solid;
        margin: 10px 1px 1px 1px;
        padding: 20px 0px 50px 0px;
    }
    #t_menu td{
        text-align: center;
        font-weight:bold;    
        border: green 1px solid;
        padding: 20px 5px 20px 5px;
        width: 150px;    
    }
    /*estilo perteneciente a la expiracion de sesion*/
    #CuentaAtras{
        float: left;
        width: 170px;
        height: 50px;
        border: green 1px solid;
        margin: 1px 1px 1px 30px;
        padding: 25px 0px 0 0px;
        text-align: center;
        
    }
    #avisoc{
        color: red;
    }
    /*--------FORM MODAL DE PENDIENTES-----------------------*/

    #popup {
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
        padding-right: 190px;
        margin-top: 20px;
    }
    #bcancelar{
        float: left;
        margin-top: 20px;
    }
    #fmodal{
        padding: 5px 55px 5px 5px;
        background-color: aqua;
        width: 300px;
        height: 250px;
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
    /*--------------FIN MODAL PEMDIENTES----------------------------*/
 </style>
</head>

<body>

<div id="r_titulo">CHECK DE MOVIMIENTO DE MAQUINAS</div>
        <?         
        include("clases/c_diario.php");
        $diario = new diario;     //NUEVO OBJETO DIARIO
        $idmov = $_GET['idmov']; //Viene de la linea 76 de "check_maquinas_sel_fecha.php"
        $diario->id_mov = $idmov;
        $resp = $diario->obtiene_movimientos_x_fdp();//obtiene todos los datos del movimiento        
        $filar = mysql_fetch_array($resp);      //crea un array asociativo     
        list($año, $mes, $dia) = explode("-",$filar[3]);//extraigo y separo la fecha
        $fechaVista = $dia."/".$mes."/".$año;  //formatea la fecha para mostrar
        $fecha = $filar[3];    //formatea la fecha para mysql
        echo "  <div id='div_f'><div id='div_f1'>Fecha de Movimiento:</div><div id='div_f2'>". $fechaVista ."</div></div>
                <div id='div_a'><div id='div_a1'>Area:</div><div id='div_a2'>".$filar[20]."</div></div>";
        echo "               
            <div id='div_ap'><div id='div_ap1'>Apertura:</div><div id='div_ap2'>".$filar[16]." - ".$filar[5]." ".$filar[6]."</div></div>
            <div id='div_d'><div id='div_d1'>Descr. del Movimiento:</div><div id='div_d2'>".$filar[4]."</div></div>";
        echo "<input type='hidden' id='id_mov' value='".$idmov."'>";
        echo "<input type='hidden' id='fecha' value='".$fecha."'>";
        echo "<input type='hidden' id='fecha' value='".$_SESSION['id_nivel']."'>";          
        ?>
               
<form id="form1" name="form1" method="post">  
<div id="contenedor">
    <div id="alta">ALTA DE MAQUINAS</div>
    <div id="izquierda">
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">CAS</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>1</td>
            	<td id="1" class="tarea" onclick="muestra_caja(1)">Creacion de Maquina</td>
                <td><input name="checkbox1" type="checkbox" value="1" id="checkbox1" class="check"/></td>        
                <td><input name="hora1" type="text" id="hora1" readonly="true" size="6" /></td>
                
                <div id="popup" style="display: none;">
                    <div class="content-popup">                
                        <div id="fmodal">
                            <div><input type="hidden" id="texto"/></div>
                            <div id="titulo"></div>
                            <div id="dtpend">Tarea N&deg;: <input type="text" id="tpend" disabled="true" size="2"/></div>
                            <div id="subtitulo"></div>                    
                            <div><textarea cols="39" rows="4" id="cpend" ></textarea></div>
                            <div id="baceptar"><input type="button" id="btnaceptar" value="Aceptar" /></div>
                            <div id="bcancelar"><input type="button" id="btncancelar" value="Cancelar" /></div>
                        </div>
                    </div>
                </div>
                
                <div id="popupftp" style="display: none;">
                    <div class="content-popupftp">                
                        <div id="fmodalftp">                   
                            <p><font size="2" face="Verdana, Tahoma, Arial"> 
                            Seleccionar archivo TXT: <input name="archivo1" type="file" id="archivo1" size="70"/><br />
                            Seleccionar archivo MD5: <input name="archivo2" type="file" id="archivo2" size="70"/><br /><br />
                            <input type="button" value="Enviar por FTP" id="btnenviarftp" />                        
                            <input type="button" value="Cancelar" id="btncancelarftp" />                    
                            </font><font size="2" face="Verdana, Tahoma, Arial"> </font> </p>                   
                        </div>
                    </div>
                </div>    
                       
         
            </tr>
            <tr>
            	<td>2</td>
            	<td id="2" class="tarea" onclick="muestra_caja(2)">Club de Jugadores</td>
                <td><input name="checkbox2" type="checkbox" value="2" id="checkbox2" class="check"/></td>
                <td><input name="hora2" type="text" id="hora2" readonly="true" size="6"/></td> 
                       
            </tr>
            <tr>
            	<td>44</td>
            	<td id="44" class="tarea" onclick="muestra_caja(44)">IMPUESTO</td>
                <td><input name="checkbox44" type="checkbox" value="44" id="checkbox44" class="check"/></td>
                <td><input name="hora44" type="text" id="hora44" readonly="true" size="6"/></td> 
                       
            </tr>
        	<tr>
            	<td>3</td>
            	<td id="3" class="tarea" onclick="muestra_caja(3)">Modalidad TITO</td>
                <td><select id="select3" name="3" class="select">
                    <option>SELECCIONAR</option>
                    <option>TITO PROMO FULL</option>
                    <option>SIN TITO</option>
                    <option>TITO SIN PROMO</option>
                    <option>TITO CON CANJE PROMO</option>
                </select></td>
                <td><input name="hora3" type="text" id="hora3" readonly="true" size="6"/></td> 
                 
            </tr>
            <tr>
            	<td>4</td>
            	<td id="4" class="tarea" onclick="muestra_caja(4)">Marca de Billetes</td>
                <td><input name="checkbox4" type="checkbox" value="4" id="checkbox4" class="check"/></td>
                <td><input name="hora4" type="text" id="hora4" readonly="true" size="6"/></td>
                      
            </tr>
            <tr>
            	<td>5</td>
            	<td id="5" class="tarea" onclick="muestra_caja(5)">MDC</td>
                <td><input name="checkbox5" type="checkbox" value="5" id="checkbox5" class="check"/></td>
                <td><input name="hora5" type="text" id="hora5" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>6</td>
            	<td id="6" class="tarea" onclick="muestra_caja(6)">Version MDC</td>
                <td align='center'><input type="text" class="text" name="6" id="control6" size="5" /></td>       
                <td><input name="hora6" type="text" id="hora6" readonly="true" size="6" /></td>       
            </tr>
            <tr>
            	<td>7</td>
            	<td id="7" class="tarea" onclick="muestra_caja(7)">Asignacion a FEP</td>
                <td><input name="checkbox7" type="checkbox" value="7" id="checkbox7" class="check"/></td>        
                <td><input name="hora7" type="text" id="hora7" readonly="true" size="6" /></td>      
            </tr>
        	<tr>
            	<td>8</td>
            	<td id="8" class="tarea" onclick="muestra_caja(8)">Habilitacion desde FEP</td>
              	<td><input name="checkbox8" type="checkbox" value="8" id="checkbox8" class="check"/></td>        
                <td><input name="hora8" type="text" id="hora8" readonly="true" size="6"/></td>         
            </tr>
            <tr>
            	<td>43</td>
            	<td id="43" class="tarea" onclick="muestra_caja(43)"><b>RECONEXION DE MDC&#39;S</b></td>
              	<td><input name="checkbox43" type="checkbox" value="43" id="checkbox43" class="check"/></td>        
                <td><input name="hora43" type="text" id="hora43" readonly="true" size="6"/></td>         
            </tr>
         </table>
     
         <table id="tabla">
            <tr>
            	<td colspan="4" id="encabezado_tabla">ASIGNACION DE FEP (Solo maquinas de Central)</td>        
            </tr>
            <tr>
            	<td>9</td>
            	<td id="9" class="tarea" onclick="muestra_caja(9)">FEP CENTRAL</td>
              	<td><input name="checkbox9" type="checkbox" value="9" id="checkbox9" class="check"/></td>        
                <td><input name="hora9" type="text" id="hora9" readonly="true" size="6"/></td> 
                
            </tr>
            <tr>
            	<td>10</td>
            	<td id="10" class="tarea" onclick="muestra_caja(10)">FEP RIVADAVIA</td>
              	<td><input name="checkbox10" type="checkbox" value="10" id="checkbox10" class="check"/></td>        
                <td><input name="hora10" type="text" id="hora10" readonly="true" size="6"/></td>  
                   
            </tr>
        </table>
        <!--
        -----------------------------------IPLYC-----------------------------
        -->
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">IPLYC</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>11</td>
            	<td id="11" class="tarea" onclick="muestra_caja(11)">Generar Altas XLS (Envio FTP)</td>
              	<td><input name="checkbox11" type="checkbox" value="11" id="checkbox11" class="check"/></td>        
                <td><input name="hora11" type="text" id="hora11" readonly="true" size="6"/></td>  
                   
            </tr>
            <!--<tr>
            	<td>12</td>
            	<td id="12" class="tarea" onclick="muestra_caja(12)">Iniciales de Billetes (Mail a CDC)</td>
              	<td><input name="checkbox12" type="checkbox" value="12" id="checkbox12" class="check"/></td>        
                <td><input name="hora12" type="text" id="hora12" readonly="true" size="6"/></td>  
                   
            </tr> -->
            <tr>
            	<td>13</td>
            	<td id="13" class="tarea" onclick="muestra_caja(13)">MAIL A COMPUTOS IPLYC</td>
                <td><input name="checkbox13" type="checkbox" value="13" id="checkbox13" class="check"/></td>        
                <td><input name="hora13" type="text" id="hora13" readonly="true" size="6"/></td> 
              
            </tr>
             <tr>
            	<td>14</td>
            	<td id="14" class="tarea" onclick="muestra_caja(14)">MAIL A PATRIMONIO (Bucciardi)</td>
                <td><input name="checkbox14" type="checkbox" value="14" id="checkbox14" class="check"/></td>
                <td><input name="hora14" type="text" id="hora14" readonly="true" size="6"/></td>   
            
            </tr>
        </table>
    </div><!--FIN DIV IZQUIERDA -->
    <div id="derecha">
        <table id="tabla">	
                <tr>
                	<td colspan="4" id="encabezado_tabla">CASTITO</td>        
                </tr>
                <tr>
                	<th>ID</th>
                	<th>TAREA</th>
                    <th>CHECK</th>
                	<th>HORA</th>
                </tr>
                <tr>
        	<td>15</td>
            	<td id="15" class="tarea" onclick="muestra_caja(15)">Alta - Verificar ASSET NUMBER</td>
                <td><input name="checkbox15" type="checkbox" value="15" id="checkbox15" class="check"/></td>
                <td><input name="hora15" type="text" id="hora15" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>16</td>
            	<td id="16" class="tarea" onclick="muestra_caja(16)">Modificacion de Isla</td>
                <td><input name="checkbox16" type="checkbox" value="16" id="checkbox16" class="check"/></td>
                <td><input name="hora16" type="text" id="hora16" readonly="true" size="6"/></td>
            </tr>   
            <tr>
            	<td>17</td>
            	<td id="17" class="tarea" onclick="muestra_caja(17)">Marca de PROMO</td>
                <td><input name="checkbox17" type="checkbox" value="17" id="checkbox17" class="check"/></td>        
                <td><input name="hora17" type="text" id="hora17" readonly="true" size="6" /></td> 
            </tr>
            <tr>
            	<td>18</td>
            	<td id="18" class="tarea" onclick="muestra_caja(18)">Agregar a Grupo PROMO</td>
                <td><input name="checkbox18" type="checkbox" value="18" id="checkbox18" class="check"/></td>
                <td><input name="hora18" type="text" id="hora18" readonly="true" size="6"/></td>
            </tr>
        	<tr>
            	<td>19</td>
            	<td id="19" class="tarea" onclick="muestra_caja(19)">Activar Maquina</td>
                <td><input name="checkbox19" type="checkbox" value="19" id="checkbox19" class="check"/></td>
                <td><input name="hora19" type="text" id="hora19" readonly="true" size="6"/></td>
            </tr>
        </table>
    
    
    <!-----------------PLANILLAS--------->
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">PLANILLAS</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <!--<tr>
        	    <td>20</td>
            	<td id="20" class="tarea" onclick="muestra_caja(20)">Agregar a Billetes</td>
                <td><input name="checkbox20" type="checkbox" value="20" id="checkbox20" class="check"/></td>
                <td><input name="hora20" type="text" id="hora20" readonly="true" size="6"/></td>
            </tr> -->   
            <tr>
            	<td>21</td>
            	<td id="21" class="tarea" onclick="muestra_caja(21)">Modificar Rutas en Esperado</td>
                <td><input name="checkbox21" type="checkbox" value="21" id="checkbox21" class="check"/></td>        
                <td><input name="hora21" type="text" id="hora21" readonly="true" size="6"/></td>    
               
            </tr>
            <tr>
            	<td>22</td>
            	<td id="22" class="tarea" onclick="muestra_caja(22)">Modificar Esperado a Loteria</td>
                <td><input name="checkbox22" type="checkbox" value="22" id="checkbox22" class="check"/></td>
                <td><input name="hora22" type="text" id="hora22" readonly="true" size="6"/></td>
            </tr>
        	<tr>
            	<td>23</td>
            	<td id="23" class="tarea" onclick="muestra_caja(23)">Control CASTITO</td>
                <td><input name="checkbox23" type="checkbox" value="23" id="checkbox23" class="check"/></td>
                <td><input name="hora23" type="text" id="hora23" readonly="true" size="6"/></td>
            </tr> 
            <tr>
            	<td>24</td>
            	<td id="24" class="tarea" onclick="muestra_caja(24)">Generar maquinas enroladas vigentes</td>
                <td><input name="checkbox24" type="checkbox" value="24" id="checkbox24" class="check"/></td>        
                <td><input name="hora24" type="text" id="hora24" readonly="true" size="6"/></td> 
            </tr>  
        </table>
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">CONTROL</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
             <tr>
            	<td>25</td>
            	<td id="25" class="tarea" onclick="muestra_caja(25)">Denominacion (FM F4)</td>
                <td><input name="checkbox25" type="checkbox" value="25" id="checkbox25"  class="check"/></td>
                <td><input name="hora25" type="text" id="hora25" readonly="true" size="6"/></td> 
            </tr>
        	<tr>
            	<td>26</td>
            	<td id="26" class="tarea" onclick="muestra_caja(26)">PB% (FM F4)</td>
                <td><input name="checkbox26" type="checkbox" value="26" id="checkbox26" class="check"/></td>
                <td><input name="hora26" type="text" id="hora26" readonly="true" size="6"/></td>
            </tr>   
            <tr>
            	<td>27</td>
            	<td id="27" class="tarea" onclick="muestra_caja(27)">Meters en CORE</td>
                <td><input name="checkbox27" type="checkbox" value="27" id="checkbox27" class="check"/></td>        
                <td><input name="hora27" type="text" id="hora27" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>28</td>
            	<td id="28" class="tarea" onclick="muestra_caja(28)">Verificar CRC erroneos</td>
                <td><input name="checkbox28" type="checkbox" value="28" id="checkbox28" class="check"/></td>
                <td><input name="hora28" type="text" id="hora28" readonly="true" size="6"/></td>
            </tr>
            <!--<tr>
            	<td>45</td>
            	<td id="45" class="tarea" onclick="muestra_caja(45)">Forzar iniciales de billetes</td>
                <td><input name="checkbox45" type="checkbox" value="45" id="checkbox45" class="check"/></td>
                <td><input name="hora45" type="text" id="hora45" readonly="true" size="6"/></td>
            </tr> -->
        </table>
    </div><!--FIN DIV DERECHA --> 
   
    <!-- ------------------------------------------------------------------------ -->
    <div id="menu">
        <table id="t_menu"> 
            <tr>
                <td id="reloj"></td>
            </tr> 
            <tr>
                <td><? echo $_SESSION['usuario'] ?></td>
            </tr>       
            <tr>
             <td>
                <?
                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");                    
                    $fch = $fechaVista;          
                    $dia = $dias[date('w',strtotime($fch))];
                    echo $dia;              
        	     ?>   
                   
                  <? echo $fechaVista; ?>         
                </td>
            </tr>
            <tr>
                <? if($_SESSION['id_nivel']==3){//nivel de supervisor es el unico que puede cerrar el movimiento 
                    if(isset($_GET['completo'])){//VIENE DE MOVIMIENTOS PENDIENTES
                        echo "<td><input type='button' class='button' name='btnturno' id='btnturno' value='Completar&#13;&#10;Movimiento' style='width:95px; height:45px' onclick='cierra_mov()' /></td>";                        
                    }else{
                        if($_SESSION['estadomov']=='SIN COMPLETAR'){
                            echo "<td><input type='button' class='button' name='btnturno' id='btnturno' value='Completar&#13;&#10;Movimiento' style='width:95px; height:45px' onclick='cierra_mov()' /></td>";
                        }else {
                            echo "<td id='avisoc'>El movimiento esta completo</td>";
                        }
                     }              
                 }
                 ?>            
            </tr>         
            <tr>
                <td><a href="principal.php?id=check_maquinas_sel_fecha" id="volver">VOLVER</a></td>
            </tr>           
        </table>
    </div><!-- FIN DIV MENU -->
    <div id="menuII">
        <table id="c_tabla">
            <tr>
                <td id="tdc_tabla" style="background-color: LightGreen"></td>
                <td>Tarea Realizada</td>
            </tr>
            <tr>
                <td id="tdc_tabla" style="background-color: LightSkyBlue"></td>
                <td>Tarea Completada</td>
            </tr>
            <tr>
                <td id="tdc_tabla" style="background-color: red;"></td>
                <td>Tarea pendiente</td>
            </tr> 
            <tr>
                <td id="tdc_tabla" style="background-color: lightgoldenrodyellow;"></td>
                <td>NO SE REALIZA</td>
            </tr>     
        </table>
    </div>
    <div id='CuentaAtras'></div>
        
   
   
    <div id="alta">BAJA DE MAQUINAS</div>
    <div id="b_izquierda">
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">CAS</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>29</td>
            	<td id="29" class="tarea" onclick="muestra_caja(29)">Deshabilitacion</td>
                <td><input name="checkbox29" type="checkbox" value="29" id="checkbox29" class="check"/></td>
                <td><input name="hora29" type="text" id="hora29" readonly="true" size="6"/></td>
            </tr> 
            <tr>
            	<td>30</td>
            	<td id="30" class="tarea" onclick="muestra_caja(30)">Desasignacion</td>
                <td><input name="checkbox30" type="checkbox" value="30" id="checkbox30" class="check"/></td>        
                <td><input name="hora30" type="text" id="hora30" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>31</td>
            	<td id="31" class="tarea" onclick="muestra_caja(31)">Baja/Eliminacion de Maquina</td>
                <td><input name="checkbox31" type="checkbox" value="31" id="checkbox31" class="check"/></td>
                <td><input name="hora31" type="text" id="hora31" readonly="true" size="6"/></td>
            </tr>
        	<tr>
            	<td>32</td>
            	<td id="32" class="tarea" onclick="muestra_caja(32)">Baja/Eliminacion de MDC</td>
                <td><input name="checkbox32" type="checkbox" value="32" id="checkbox32" class="check"/></td>
                <td><input name="hora32" type="text" id="hora32" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>33</td>
            	<td id="33" class="tarea" onclick="muestra_caja(33)">Drop de Billetes</td>        
                <td><input name="checkbox33" type="checkbox" value="33" id="checkbox33" class="check"/></td>        
                <td><input name="hora33" type="text" id="hora33" readonly="true" size="6"/></td>
            </tr>  
         </table>
         <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">CASTITO</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>34</td>
            	<td id="34" class="tarea" onclick="muestra_caja(34)">Inactiva</td>
                <td><input name="checkbox34" type="checkbox" value="34" id="checkbox34" class="check"/></td>
                <td><input name="hora34" type="text" id="hora34" readonly="true" size="6"/></td>
            </tr>
         </table> 
    </div><!--FIN DIV B_IZQUIERDA -->
    <div id="b_derecha">
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">PLANILLAS</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>35</td>
            	<td id="35" class="tarea" onclick="muestra_cajaesp(35)">Marcar baja en bill (NO BORRAR) - En color Amarillo</td>
                <td><input name="checkbox35" type="checkbox" value="35" id="checkbox35" class="check"/></td>
                <td><input name="hora35" type="text" id="hora35" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>36</td>
            	<td id="36" class="tarea" onclick="muestra_caja(36)">Eliminar de la ruta</td>
                <td><input name="checkbox36" type="checkbox" value="36" id="checkbox36" class="check"/></td>        
                <td><input name="hora36" type="text" id="hora36" readonly="true" size="6"/></td>
            </tr>
            
        </table>
        <table id="tabla">	
            <tr>
            	<td colspan="4" id="encabezado_tabla">IPLYC</td>        
            </tr>
            <tr>
            	<th>ID</th>
            	<th>TAREA</th>
                <th>CHECK</th>
            	<th>HORA</th>
            </tr>
            <tr>
            	<td>37</td>
            	<td id="37" class="tarea" onclick="muestra_caja(37)">Generar Bajas XLS (Envio FTP)</td>
                <td><input name="checkbox37" type="checkbox" value="37" id="checkbox37"  class="check"/></td>
                <td><input name="hora37" type="text" id="hora37" readonly="true" size="6"/></td>
            </tr>
            <tr>
            	<td>38</td>
            	<td id="38" class="tarea" onclick="muestra_caja(38)">MAIL A COMPUTOS IPLYC</td>
                <td><input name="checkbox38" type="checkbox" value="38" id="checkbox38" class="check"/></td>
                <td><input name="hora38" type="text" id="hora38" readonly="true" size="6"/></td>
            </tr> 
            <tr>
            	<td>39</td>
            	<td id="39" class="tarea" onclick="muestra_caja(39)">MAIL A PATRIMONIO (Bucciardi)</td>
                <td><input name="checkbox39" type="checkbox" value="39" id="checkbox39" class="check"/></td>
                <td><input name="hora39" type="text" id="hora39" readonly="true" size="6"/></td>
            </tr>           
        </table>
    </div><!--FIN DIV B_DERECHA -->
    
    
    <div id="pie">    
        <table id="t_pie">
            <tr>Comentarios:</tr>
            <tr>
                <td><input type="text" name="40" id="control40" size="180" class="text"/></td>
                <td><input name="hora40" type="text" id="hora40" readonly="true" size="6" onclick="muestra_caja(40)"/></td>
            </tr> 
            <tr>
                <td><input type="text" name="41" id="control41" size="180" class="text"/></td>
                <td><input name="hora41" type="text" id="hora41" readonly="true" size="6" onclick="muestra_caja(41)"/></td>
            </tr>
            <tr>
                <td><input type="text" name="42" id="control42" size="180" class="text"/></td>
                <td><input name="hora42" type="text" id="hora42" readonly="true" size="6" onclick="muestra_caja(42)"/></td>
            </tr>                
        </table>
    </div>
    
</div><!--FIN DIV CONTENEDOR -->


<table id="t_botones">
    <tr>
        <td></td>
        <? if(isset($_GET['ver'])){
                if($_GET['ver']=='true'){
                    echo "<td><input type='button' id='boton' value='Cerrar' onclick='envia_cierre()'/></td>";
                    
                }
                if($_GET['rseek']==1){
                    echo "<td><a href='principal.php?id=reproceso_busqueda&edita=1'>VOLVER</a></td>";
                }else{
                    echo "<td><a href='principal.php?id=reproceso&edita=1'>VOLVER</a></td>";
                }
           }
         ?>
       <!-- <td><a href="principal.php?id=reproceso&edita=1">VOLVER</a></td> -->
        <td><input type="hidden" id="user" /></td>
        
    </tr>
</table>

<?
//trae de la bd las tareas guardadas para rellenar el check
   
    $diario->id_mov = $_GET['idmov'];
  /*  $a = $_GET['a'];
    $d = $_GET['d'];
    $fecha = $_GET['fecha'];   
    echo "<script type='text/javascript'>        
        window.open('https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=MOVIMIENTO DE MAQUINAS INICIADO - '". $a . "' - FECHA: '". $fecha . "'&body= EL MOVIMIENTO DE FECHA: '" . $fecha . "' SE HA INICIADO%0A%0ADESCRIPCION: '" . $d ."','_blank');                       
    </script>";*/    
    
    //$diario->id_mov = $idmov;
    $res = $diario->obtiene_tareas_mov();
    while($fila = mysql_fetch_array($res)){  
      switch($fila[6]){
            case 1://TAREAS NORMALES
                echo "<script type='text/javascript'>        
                    document.getElementById('checkbox'+".$fila[0].").checked=true;
                    document.getElementById('checkbox'+".$fila[0].").disabled=true;                  
                    document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';               
                    document.getElementById(".$fila[0].").style.backgroundColor= 'LightGreen';                    
                </script>"; 
                  //agrega el dato al las clases TEXT (comentarios y version de MDC)
                echo "<script type='text/javascript'>                              
                    document.getElementById('control'+".$fila[0].").value ='".$fila[4]."'; 
                    document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';           
                    document.getElementById('control'+".$fila[0].").disabled=true;
                    document.getElementById(".$fila[0].").style.backgroundColor= 'LightGreen';                 
                </script>";      
                //agerga datos al select TITO
                echo "<script type='text/javascript'>
                        var aSelect = document.getElementById('select'+".$fila[0]."); 
                	    var val_aSelect = aSelect.options[aSelect.selectedIndex].text='".$fila[4]."';
                        aSelect.disabled=true;               
                        document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';           
                        document.getElementById('select'+".$fila[0].").disabled=true;
                        document.getElementById(".$fila[0].").style.backgroundColor= 'LightGreen';                 
                    </script>"; 
                break;
            case 2://TAREAS PENDIENTES
                echo "<script type='text/javascript'>
                document.getElementById('checkbox'+".$fila[0].").checked=true;
                document.getElementById('checkbox'+".$fila[0].").disabled=true;     
                document.getElementById(".$fila[0].").style.backgroundColor= '#ff5c54';
                document.getElementById('hora'+".$fila[0].").value = '';                
                </script>";
                break;
            case 3://TAREAS COMPLETADAS
                echo "<script type='text/javascript'>
                document.getElementById(".$fila[0].").style.backgroundColor= 'LightSkyBlue';
                document.getElementById('hora'+".$fila[0].").value = '".$fila[3]."';                
                </script>";
                break; 
            case 4://TAREAS QUE NO SE REALIZAN
                echo "<script type='text/javascript'>
                    document.getElementById(".$fila[0].").style.backgroundColor= 'lightgoldenrodyellow';                                           
                    document.getElementById('checkbox'+".$fila[0].").disabled=true;
                    document.getElementById('hora'+".$fila[0].").value = '';
                </script>";
                echo "<script type='text/javascript'>
                    document.getElementById('control'+".$fila[0].").disabled=true; 
                </script>";
                echo "<script type='text/javascript'>                      
                    document.getElementById('select'+".$fila[0].").disabled=true;
                </script>";
                break;           
        } 
    }       
        
?>
</form>
</body>
</html>