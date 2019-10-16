<? session_start();
//*********CHECK DE TAREAS DIARIAS DE CDC MAR DEL PLATA*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 10/04/2016 -******************************

//************************************************************************************************

//VERSION 2.7: AGREGA A USUARIOS EL FILTRO ACTIVOS E INACTIVOS                          20/07/2017
//--------------------------------------------------------------------------------------------------
//VERSION 2.8: AGREGA EN EL MENU CONTEXTUAL LA OPCION "No se realiza por..."            19/12/2017
//--------------------------------------------------------------------------------------------------
//VERSION 2.9: MODIFIQUE TODO EL MENU DE BOTONES POR UNO NUEVO Y ADAPTABLE A FIREFOX    05/09/2018
//--------------------------------------------------------------------------------------------------
//VERSION 3.0:  - SE SEPARA EL FICHAJE A UNA PAGINA NUEVA fichajecodigo.php
//              - SE AGREGA LA PAGINA funcionalidadfichaje.php FUNCIONALIDAD DEL FICHAJE
//              - SE AGREGA LA PAGINA vistafichaje.php PARA VISUALIZAR LOS FICHAJE EN CHECKLIST
//              - SE MODIFICO principal.php SE CAMBIO LA PAGINA DE INICIO A vistafichaje.php
//              - SE MODIFICO menu.php OPCION DE VER LOS FICHAJES
//              - SE MODIFICO LA CLASE c_fichaje.php MODIFICACION DE LA CONSULTA QUE USA vistafichaje.php
//              - SE MODIFICO LA TABLA FICHAJE EN BD: Se eliminaron los campos just_entrada y just_salida
//                y se agregao uno solo llamado "justificacion"
//              - SE AGREGO UNA CARPETA CON LOS CODIGOS DE BARRAS DE LOS OPERADORES 
//              20/04/2019
//--------------------------------------------------------------------------------------------------

//************************************************************************************************
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="estilos/estilo1.css" />
<link rel="stylesheet" href="estilos/jquery.contextMenu.css" />
<script src="jquery-1.7.2.min.js"></script>
<script src="jquery.js"></script>
<script src="js/jquery.contextMenu.js"></script>
<script src="js/jquery.ui.position.js"></script>


<title>CHECKLIST v 3.0</title>
<script type="text/javascript">
//VARIABLE GLOBAL
var ctrlbill=0;//controla los items de billetes
var bandera=0;//Con esta variable controlo cuando queda pendiente una tarea de billetes
                //y se pasa a completada
var cierreturno=false;
var user = '<? echo $_SESSION['usuario']; ?>';//nombre de usuario
var id_user = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
var minutos, seconds;
//Agrega la variable de sesion
var seconds_left = <? echo $_SESSION['limite'];?>;

seconds_left = seconds_left*60;  
/* Determinamos la url donde redireccionar con un parametro que sirve para cerrar las SESSIONS en el index */
var url="index.php?caducada=1";
$(document).ready(function(){
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
        if(hfdp=='23:45:00'){        
            h= hfdp;
            //idh=$("#hoja").val();//id hoja  
            //Obtiene la ultima fecha abierta      
            var coment = $.ajax({
                url:"editar.php?val=5",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",
                data:{idu:0,idh:0,idt:0,h:0,v:0,p:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto 
          //si existe fecha abierta
           if(coment != ''){  
                idh = coment;
                alert('SE CERRARA AUTOMATICAMENTE LA FDP ACTUAL');
                //val=2 cierra la FDP
                $.ajax({url:"editar.php?val=2",cache:false,type:"POST",data:{idh:idh,idu:1,h:h}});
           }
           
           //val=0 cierra los turnos abiertos 
           $.ajax({url:"editar.php?val=4",cache:false,type:"POST",data:{idh:0,idu:0}});           
           //redirecciona a hoja principal
           window.location.href = 'principal.php?id=fichaje';  
        }
        
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
        /* Restamos un segundo al tiempo restante */ 
        seconds_left-=1;
        
        
    }, 1000);
});

//Todos los objetos con la propiedad CLASS="check", realizaran esta funcion.
//guarda las tareas que poseen checkbox. Guarda la hora, el usuario, el estado
$(document).ready(function(){
   
    $(".check").click(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas check        
          var id = $(this).attr("value"); // Le pasa el valor del checkbox 
          if(!(verifica_tarea(id))){
              var resp = confirm("Desea guardar la tarea "+id+" ?");
              if (resp == true) {
                  var tiempo = new Date();  //obtiene la fecha y hora
                  var horas = tiempo.getHours();    //extrae las horas
                  var minutos = tiempo.getMinutes();    //extrae los minutos
                  var segundos = '00';
                  if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
        		      minutos = '0'+minutos;
      	          }  
                  var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora                  
                  document.getElementById('hora'+id).value = hora;  //inserta la hora en el campo de hora
                  idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox
                  idh=$("#hoja").val();     //pasa el id de la hoja. La misma se encuentra en la variable de sesion de mismo nombre          
                  h=hora; //pasa la hora          
                  v='- TAREA '+id+' REALIZADA -\nUsuario: '+user;//pasa el usuario que realizo la tarea
                  p=1;
                  t='ABIERTA';                                  
                  $.ajax({url:"insertar.php",cache:false,type:"POST",data:{idt:idt,idh:idh,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
                  seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
                  seconds_left = seconds_left*60;
                  $("#checkbox"+id).attr("disabled", true); //deshabilita el checkbox                   
                  $('#'+id).css("background-color", "LightGreen");                                 
                  //llama a la funcion envia_mail(id). Abrira el correo con plantillas predeterminadas                             
                  envio_mail(id);                                           
              }else{    //resp == FALSE      
                $("#checkbox"+id).attr("checked", false); //deshabilita el checkbox 
              }
        }else{//verifica_tarea(id)
            var con = consulta_valor(id);
            alert(con);             
            window.location.href = 'check.php'; 
        }   
          
    });
//--------------------------------------------------------------------------------------------------------
//Todos los objetos con la propiedad CLASS="select", realizaran esta funcion.
//Se guardan los datos de usuarios y temperaturas
    $(".select").change(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas check
          var id = $(this).attr("name"); // Le pasa el valor del select           
          var us = $(this).attr("value"); // Le pasa el valor del select
          var tiempo = new Date();  //obtiene la fecha y hora
          var horas = tiempo.getHours();    //extrae las horas
          var minutos = tiempo.getMinutes();    //extrae los minutos
          var segundos = '00';
          if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
		      minutos = '0'+minutos;
	       }  
          var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
          if(!(verifica_tarea(id))){ 
              idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox
              idh=$("#hoja").val();     //pasa el id de la hoja. La misma se encuentra en la variable de sesion de mismo nombre
              h=hora; //pasa la hora   
              v=us;//Le pasa el valor del campo comentarios         
              p=1;              
              t='ABIERTA';
              //alert(idt);
              $.ajax({url:"insertar.php",cache:false,type:"POST",data:{idt:idt,idh:idh,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
              alert('Tarea guardada');
              seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
              seconds_left = seconds_left*60;   
              $("#control"+id).attr("disabled", true); //deshabilita el checkbox              
          }else{
                //var con = consulta_valor(id);
                alert('La tarea ya se encuentra realizada!!!');
                window.location.href = 'check.php';
          }
    });
//--------------------------------------------------------------------------------------------------------
//Todos los objetos con la propiedad CLASS="text", realizaran esta funcion.
//Se guardan los datos que se cargan en input type TEXT
    $(".text").change(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas text            
          var id = $(this).attr("name"); // Le pasa el name del text
          //id 35 es el text de cantidad de maquinas sin contadores y el 90 de billetes
          if(!(verifica_tarea(id))){
              if(id==35 || id==90){
                var valor = $(this).attr("value"); // Le pasa el valor del text
                valor = "Maquinas sin contadores -"+valor+"- "; 
              }else{
                valor = $(this).attr("value"); // Le pasa el valor del text
              }          
              var tiempo = new Date();  //obtiene la fecha y hora
              var horas = tiempo.getHours();    //extrae las horas
              var minutos = tiempo.getMinutes();    //extrae los minutos
              var segundos = '00';
              if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
    		      minutos = '0'+minutos;
    	       }  
              var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
               
              document.getElementById('hora'+id).value = hora;  //inserta la hora en el campo de hora          
              idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox
              idh=$("#hoja").val();     //pasa el id de la hoja. La misma se encuentra en la variable de sesion de mismo nombre              
              h=hora; //pasa la hora 
              if(id==35 || id==90){  
                v=valor+user;
              }else{
                v=valor+" - "+user;
              }        
              p=1;
              t='ABIERTA';
              $.ajax({url:"insertar.php",cache:false,type:"POST",data:{idt:idt,idh:idh,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
              alert('Comentario Guardado');
              if(id==35 || id==90){
                $("#checkbox"+id).attr("disabled", true); //deshabilita el checkbox
                $("#checkbox"+id).attr("checked", true); //deshabilita el checkbox  
                $('#'+id).css("background-color", "LightGreen");
              }
              $("#control"+id).attr("disabled", true); //deshabilita el checkbox
              seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
              seconds_left = seconds_left*60; 
          }else{
            var con = consulta_valor(id);
            alert('La tarea ya se encuentra realizada!!!');
            window.location.href = 'check.php';
          }
    });    
       
}); 
//----------------------------------------------------------------------------------------------------

//Eliminar usuarios de los select
function borra_operador(val){
    //alert($("#control"+val).val());
    if($("#control"+val).val()!=''){
        var idt=val;//id de tarea
        var idh=$("#hoja").val();//id hoja 
        idu=id_user;//id de usuario
        h=obtiene_fechahora(); //fecha y hora actual
        v=idt+"-"+$("#control"+val).val();
        p="ELIMINADO";//accion
        var resp = confirm("Desea eliminar la tarea "+idt+" ?");
        if (resp == true) {
            $.ajax({url:"editar.php?val=8",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:idu,h:h,v:v,p:p}});   //Elimina la tarea
            $("#control"+idt).attr("disabled", false); //habilita el checkbox
            alert('Usuario Removido!!!');
            //inserta el seguimiento
            //$.ajax({url:"editar.php?val=9",cache:false,type:"POST",data:{idt:0,idh:0,idu:idu,h:h,v:v,p:p}});   //seguimiento
            window.location.href = 'check.php';
        }
    }    
}
//ELIMINA LOS COMENTARIOS AL PIE
function borra_comentario(val){
    //alert($("#control"+val).val());
    if($("#control"+val).val()!=''){
        var idt=val;
        var idh=$("#hoja").val();//id hoja 
        idu=id_user;
        h=obtiene_fechahora();        
        v=idt+"-"+$("#control"+val).val();
        p="ELIMINADO";
        var resp = confirm("Desea eliminar el comentario?");
        if (resp == true) {            
            $.ajax({url:"editar.php?val=8",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:0,h:0,v:0,p:0}});   //Elimina la tarea
            $.ajax({url:"editar.php?val=9",cache:false,type:"POST",data:{idt:0,idh:0,idu:idu,h:h,v:v,p:p}});   //guarda el log
            $("#control"+idt).attr("disabled", false); //habilita el text
            $("#control"+idt).attr("value",""); //habilita el select
            $("#hora"+idt).attr("value",""); //habilita el select
            //alert('Comentario Eliminado!!!');
            //window.location.href = 'check.php';
        }
    }
    
}
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Menu contextual al hacer click derecho sobre cualquier tarea. MENU:
//No se realiza: Para tareas que no se realicen en la fecha                                         - color: lightgoldenrodyellow
//No se realiza por... : Para tareas que no se realicen por x motivo. Permite colocar justificacion - color: gold
//Dejar tarea pendiente: Cuando se deben dejar tareas para otros turnos                             - color: #ff5c54 (rojo)
//Completar tarea: Cuando se deben completar tareas pendientes                                      - color: LightSkyBlue
//Eliminar tarea: Para borrar cualquier tarea
//Regenerar mail: si por x motivo no se genero el mail al realizar una tarea. Con esta opcion se puede regenerar el mismo.
$(function(){       
        $.contextMenu({           
                selector: '.tarea', 
                items: {
                    "NOREALIZA": {name: "No se realiza", icon: "cut",callback: function() {
                        
                        var idt = $(this).attr("id");//id tarea
                        idh=$("#hoja").val();//id hoja
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';
                        var user = '<? echo $_SESSION['usuario']; ?>';
                        var h = obtiene_hora()+':00';
                        var v = 'NO SE REALIZA - \nUsuario: '+user;//DESCRIPCION DE LA TAREA
                        var p=5;
                        var t='ABIERTA';
                        var obj = document.getElementById(idt).style.backgroundColor;   
                                     
                        switch(obj){
                            case ''://tarea sin realizar                            
                                //e=4 TAREAS QUE NO SE REALIZAN
                                $.ajax({url:"insertar.php",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:idu,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
                                $('#checkbox'+idt).attr('checked', true);
                                $("#checkbox"+idt).attr("disabled", true); //deshabilita el checkbox                                    
                                $('#'+idt).css("background-color", "lightgoldenrodyellow"); //amarillo claro
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
                                alert('La tarea NO SE REALIZA');
                                break;
                        }
                    }
                },
                "NOREALIZAPOR": {name: "No se realiza por...", icon: "quit",callback: function() {
                    var id = $(this).attr("id");
                    var obj = document.getElementById(id).style.backgroundColor;   
                                     
                    switch(obj){
                        case ''://tarea sin realizar    
                            
                            content = document.getElementById(id);                        
                            document.getElementById('titulo').innerHTML = content.innerHTML;
                            document.getElementById('tpend').value = id;
                            document.getElementById('texto').value = id;
                            controlar_form() 
                            $('#popup').fadeIn('slow');
                            $('.popup-overlay').fadeIn('slow');
                            $('.popup-overlay').height($(window).height());
                            ctrlbill=2;
                            break;
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
                            alert('La tarea NO SE REALIZA');
                            break;
                        }
                    }
                },
                    sep1: "---------",
                    "Pendiente": {//DEJA TAREAS EN ESTADO PENDIENTE
                        name: "Dejar tarea pendiente",
                        icon: "edit",
                        
                        callback: function() {
                            var id = $(this).attr("id");
                            if(!(verifica_tarea(id))){ 
                                
                                //var user = '<? echo $_SESSION['usuario']; ?>';
                                if( $('#checkbox'+id).prop('checked') ) {                        
                                    if($('#hora'+id).val()==""){
                                        alert('- TAREA PENDIENTE -\nUsuario: '+user);
                                    }else{
                                        alert('- TAREA REALIZADA -\nUsuario: '+user);
                                    }                
                                }else{
                                    content = document.getElementById(id);                        
                                    document.getElementById('titulo').innerHTML = content.innerHTML;
                                    document.getElementById('texto').value = id;
                                    document.getElementById('tpend').value = id;
                                    document.getElementById('cpend').value = '';
                                    //deshabilita todos los controles del form1
                                    controlar_form() 
                                    $('#popup').fadeIn('slow');
                                    $('.popup-overlay').fadeIn('slow');
                                    $('.popup-overlay').height($(window).height());
                                    var subtitulo = '';
                                    switch(parseInt(id)){
                                        case 18: case 22: case 25: case 28: case 31:
                                            subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                                            document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR                                           
                                            break;
                                        case 19: case 23: case 26: case 29: case 32:
                                            subtitulo = 'Comentar casos de diferencias significativas';
                                            document.getElementById('subtitulo').innerHTML = subtitulo;
                                            break;                                           
                                    }      
                                    ctrlbill=0;
                                    bandera=0;                                               
                                }
                            }else{                            
                                alert('La tarea se encuentra realizada');
                                //window.location.href = 'check.php';
                            }//FIN if(!(verifica_tarea(id)
                        }//FIN CALLBACK
                        
                    },
                    "Completar": {//COMPLETA LAS TAREAS PENDIENTES
                        name: "Completar Tarea",
                        icon: "confirm",
                        callback: function() {
                            var id = $(this).attr("id");
                            var str = trae_estado(id);
                            if(str == 'COMPLETADA'){
                                alert('La tarea ya se encuentra realizada!!!');
                                //window.location.href = 'check.php'; 
                            }else{                               
                                if( $('#checkbox'+id).prop('checked') ) {
                                    //var user = '<? echo $_SESSION['usuario']; ?>';
                                    if( $('#checkbox'+id).prop('checked') && $('#hora'+id).val()==""){
                                        document.getElementById('texto').value = id;
                                        document.getElementById('tpend').value = id;                        
                                        var comp = confirm("La tarea "+ id +" sera completada");
                                        if (comp == true) {                                 
                                            var subtitulo = '';
                                            switch(parseInt(id)){
                                                case 18: case 22: case 25: case 81: 
                                                //deshabilita todos los controles del form1
                                                    controlar_form()                                               
                                                    $('#popup').fadeIn('slow');
                                                    $('.popup-overlay').fadeIn('slow');
                                                    $('.popup-overlay').height($(window).height());    
                                                    subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                                                    document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR
                                                    document.getElementById('cpend').value = "TOTAL CAS:\nDIFERENCIAS:"
                                                    ctrlbill=1;// DIFERENCIA EN TRE TAREA PENDIENTE Y CONTROL DE BILLETES
                                                    bandera=0;
                                                    break;
                                                case 31:
                                                    controlar_form()                                               
                                                    $('#popup').fadeIn('slow');
                                                    $('.popup-overlay').fadeIn('slow');
                                                    $('.popup-overlay').height($(window).height());    
                                                    subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                                                    document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR
                                                    document.getElementById('cpend').value = "TOTAL CAS CENTRAL:\nTOTAL CAS DEL MAR:\nTOTAL CAS SASSO:\nDIFERENCIAS CENTRAL:\nDIFERENCIAS DEL MAR:\nDIFERENCIAS SASSO:"
                                                    ctrlbill=1;// DIFERENCIA EN TRE TAREA PENDIENTE Y CONTROL DE BILLETES
                                                    bandera=0;
                                                    break;
                                                case 19: case 26: case 32: case 82:
                                                //deshabilita todos los controles del form1
                                                    controlar_form()
                                                    $('#popup').fadeIn('slow');
                                                    $('.popup-overlay').fadeIn('slow');
                                                    $('.popup-overlay').height($(window).height());    
                                                    subtitulo = 'Comentar casos de diferencias significativas';
                                                    document.getElementById('subtitulo').innerHTML = subtitulo;
                                                    ctrlbill=1;// DIFERENCIA EN TRE TAREA PENDIENTE Y CONTROL DE BILLETES
                                                    bandera=0;
                                                    break;
                                                case 28:
                                                    controlar_form()                                               
                                                    $('#popup').fadeIn('slow');
                                                    $('.popup-overlay').fadeIn('slow');
                                                    $('.popup-overlay').height($(window).height());    
                                                    subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                                                    document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR
                                                    document.getElementById('cpend').value = "RECAUDACION POR REGISTRO:\nRECAUDACION POR FISICO:\nDIFERENCIA:"
                                                    ctrlbill=1;// DIFERENCIA EN TRE TAREA PENDIENTE Y CONTROL DE BILLETES
                                                    bandera=0;
                                                    break;
                                                default:                                 
                                                                                 
                                                    var tiempo = new Date();  //obtiene la fecha y hora
                                                    var horas = tiempo.getHours();    //extrae las horas
                                                    var minutos = tiempo.getMinutes();    //extrae los minutos
                                                    var segundos = '00';
                                                    if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
                                            	      minutos = '0'+minutos;
                                                    }
                                                    idt=id;//id tarea 
                                                    idh=$("#hoja").val();//id hoja
                                                    idu=id_user;
                                                    p=3;
                                                    //con esta funcion, trae los comentarios de la tarea que habia quedado pendiente
                                                    var v = consulta_valor(idt)+"\nUsuario que Completo: "+user;                                      
                                                    var h = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
                                                    //Edita la tarea pendiente sin recargar la pagina 
                                                    $.ajax({url:"editar.php?val=1",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:idu,h:h,v:v,p:p}});
                                                    //coloca la hora completa en la variable hora
                                                    document.getElementById('hora'+id).value = horas+':'+minutos+':'+segundos;     
                                                    document.getElementById('checkbox'+id).checked=true;
                                                    document.getElementById('checkbox'+id).disabled=true;                                                    
                                                    //Pinta de celeste la tarea completada
                                                    document.getElementById(id).style.backgroundColor= 'LightSkyBlue';
                                                    //llama a la funcion envia_mail(id). Abrira el correo con plantillas predeterminadas                             
                                                     
                                            }
                                            envio_mail(id);
                                        }
                                    }else{
                                        if($('#hora'+id).val()==""){
                                            alert('- TAREA PENDIENTE -\nUsuario: '+user);
                                        }else{
                                            alert('- TAREA REALIZADA -\nUsuario: '+user);
                                        }
                                    }                
                                }else{
                                    alert('No se puede completar la tarea '+id+'\nLa misma se encuentra sin realizar');
                                }//FIN CHECKED
                            
                            }
                        }
                    },//FIN COMPLETAR:
                    "ELIMINAR":{name: "Eliminar Tarea", icon: "delete", callback: function(){//ELIMINA LA TAREA
                        var idt = $(this).attr("id");//id tarea
                        var obj = document.getElementById(idt).style.backgroundColor;  
                        var idh=$("#hoja").val();//id hoja 
                        idu=id_user;
                        h=obtiene_fechahora();        
                        v=idt+"-"+document.getElementById(idt).innerHTML;                        
                        p="ELIMINADO";
                        if(obj==''){
                            alert('Imposible eliminar. La tarea no se encuentra realizada');
                        }else{
                            var resp = confirm("Desea eliminar la tarea "+idt+" ?");
                            if (resp == true) {
                                $.ajax({url:"editar.php?val=8",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:0,h:0,v:0,p:0}});   //Elimina la tarea
                                $.ajax({url:"editar.php?val=9",cache:false,type:"POST",data:{idt:0,idh:0,idu:idu,h:h,v:v,p:p}});   //guarda el log
                                $('#checkbox'+idt).attr('checked', false);//destilda
                                $("#checkbox"+idt).attr("disabled", false); //habilita el checkbox                                 
                                $("#hora"+idt).attr("value","");//elimina la hora
                                $('#'+idt).css("background-color", ""); //elimina el color
                                if(idt==35 || idt==90){
                                    $("#control"+idt).attr("value","");//elimina las maquinas sin comunicacion
                                    $("#control"+idt).attr("disabled", false); //habilita el text
                                }
                            }
                        }
                      }
                    },//FIN ELIMINAR
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
     //   }//FIN IF
    });
});  

//--------------------------------------------------------------------------------
//esta funcion cierra el formulario de justificacion de pendiente y guarda los datos en la BD
$(document).ready(function(){    
    $('#btnaceptar').click(function(){
        //COLOCO LOS DATOS DEL TEXTAREA EN VARIABLE pendt
        var pendt = document.getElementById('cpend').value;
        //verifico que se coloquen datos en el textarea
        if(pendt.length==24){
            alert("Se debe colocar una justificacion!");
        }else if(pendt.length==0){
            alert("Se debe colocar una justificacion!");
            }else{
                //cierra el popup
                $('#popup').fadeOut('slow');
                $('.popup-overlay').fadeOut('slow');
                //coloco en variable texto el valor del textarea
                var texto = document.getElementById('cpend').value;
                //coloco el id de la tarea en variable id
                var id = document.getElementById('texto').value;
                          
                //---------------------------------
                
                idt=id;//id tarea                                 
                idh=$("#hoja").val();//id hoja                
                idu=id_user;//id usuario
                var tiempo = new Date();  //obtiene la fecha y hora
                var horas = tiempo.getHours();    //extrae las horas
                var minutos = tiempo.getMinutes();    //extrae los minutos
                var segundos = '00';
                if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
        	      minutos = '0'+minutos;
                }  
                var h = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
                if(ctrlbill==1){//Controla si se estan haciendo tareas de billetes o alguna otra
                    //coloca la hora completa en la variable hora 
                    document.getElementById('hora'+id).value = horas+':'+minutos+':'+segundos;     
                    //bandera sirve cuando quiere completar una tarea pendiente de billetes
                    if(bandera==0){
                        p=3;//TAREA COMPLETADA                    
                        texta = document.getElementById('cpend').value;
                        var msg1 = consulta_valor(id);
                        var msg2 = texta+"\nUsuario que Completo: "+user;
                        var v = msg1+msg2 
                        //pinta la celda de color azul, significa tarea completada
                        $('#'+id).css("background-color", "LightSkyBlue");
                        //Edita la tarea pendiente sin recargar la pagina
                        $.ajax({url:"editar.php?val=1",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:idu,h:h,v:v,p:p}});   
                    }else{
                        p=4;//TAREA DE BILLETES
                        v=texto+'\nRealizada por Usuario: '+user;//CARGA LA JUSTIFICACION DE LA TAREA
                        $('#'+id).css("background-color", "LightGreen");
                    }                                
                    aviso = 'se ha guardado'; 
                    envio_mail(id);   
                //tarea pendiente        
                }else if(ctrlbill==0){
                    p=2;
                    $('#'+id).css("background-color", "#ff5c54"); //color rojo
                    v=texto+'\nPendiente por Usuario: '+user+"\n";//CARGA LA JUSTIFICACION DE LA TAREA               
                    aviso = 'ha quedado pendiente';
                    envio_mail_pendientes(id,texto);//llama a funcion para enviar billetes//
                //ctrlbill==2 es cuando no se realiza una tarea y se justifica 
                }else if(ctrlbill==2){                    
                    p=6;//TAREA QUE NO SE REALIZA CON JUSTIFICACION
                    $('#'+id).css("background-color", "gold"); //color oro
                    v='No se realiza por: '+texto+'\nUsuario: '+user+"\n";//CARGA LA JUSTIFICACION DE LA TAREA               
                    aviso = 'se ha guardado';
                }
                $('#checkbox'+id).attr('checked', true);
                $('#checkbox'+id).attr('disabled', true); 
                t='ABIERTA';            
                $.ajax({url:"insertar.php",cache:false,type:"POST",data:{idt:idt,idh:idh,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
                alert('La tarea '+id+' '+aviso);
                habilita_ctrl();//recarga la pagina para habilitar los controles                
                //envio_mail(id);
                return false;
         }
      
    });
    $('#btncancelar').click(function(){
        $('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        var id = document.getElementById('texto').value;            
        if(bandera==1){    
            $('#checkbox'+id).attr('checked', false);
        }    
        habilita_ctrl();//recarga la pagina por la cancelacion del modal
        return false;
    });
});
//------------------------------------------------------------------------------------------------
//ENVIO POR FTP DE ARCHIVOS TXT Y MD5 DE MDPCORE A COMPUTOS IPLYC

$(document).ready(function(){    
    $(".checkftp").click(function(){//al checkear la tarea 40 se abre el modal de envio FTP                
        controlar_form();
        $('#popupftp').fadeIn('slow');
        $('.popup-overlayftp').fadeIn('slow');
        $('.popup-overlayftp').height($(window).height());        
    });
    $('#btnenviarftp').click(function(){//boton de envio de FTP    
        if((document.getElementById('archivo1').value=='') || (document.getElementById('archivo2').value=='')){
            alert('Debe seleccionar los 2 archivos');
        }else{
            var arch1 = document.getElementById('archivo1').value;
            var arch2 = document.getElementById('archivo2').value;            
            window.location.href = 'sube_ftp.php?a1='+arch1+'&a2='+arch2;
        }
    });
    $('#archivo1').change(function(){//controla que se seleccione el archivo correcto TXT
        var tarch = document.getElementById('archivo1').value;
        var txtarch = tarch.split('.');        
        if(txtarch[1] != 'txt'){            
            alert('El archivo seleccionado no corresponde. Debe ser .TXT');
            var control = $("#archivo1")           
            control.replaceWith( control.val('').clone( true ) );
        }
    });
    $('#archivo2').change(function(){////controla que se seleccione el archivo correcto MD5
        var tarch = document.getElementById('archivo2').value;
        var txtarch = tarch.split('.');        
        if(txtarch[1] != 'md5'){            
            alert('El archivo seleccionado no corresponde. Debe ser .MD5');
            var control = $("#archivo2")           
            control.replaceWith( control.val('').clone( true ) );
        }
    });
    $('#btncancelarftp').click(function(){//cancela la accion y cierra el modal. Habilita el check
        $('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');        
        habilita_ctrl();//recarga la pagina por la cancelacion del modal  
    });
    
});
/*-----------------------------------------------------------------------*/
  
//-----------------------------------------------------------------------------------------------------
//Al hacer click en alguna tarea, mostrara el campo valor del mismo
//Este campo es para comentarios al dejar tareas pendientes y al hacer
//las tareas de billetes
function consulta_valor(id){
        idt=id;        
        idh=$("#hoja").val();//id hoja 
        var coment = $.ajax({
            url:"traecomentarios.php?val=1",
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idt:idt,idh:idh,idu:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto            
         if(coment == ""){
                var res = 'La tarea '+id+' se encuentra sin realizar';
                //alert('La tarea '+id+' se encuentra sin realizar');
                return res;
         }else{            
                //alert(coment);
                return coment;
         }          
}
//obtiene el estado de la tarea
function trae_estado(id){
    idt=id;           
    idh=$("#hoja").val();//id hoja 
    var coment = $.ajax({
        url:"traecomentarios.php?val=0",
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idt:idt,idh:idh,idu:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto            
    return coment;
}
function muestra_caja(id){
    var c = consulta_valor(id);
    var e = trae_estado(id);   
    alert(c+'\n'+e);
    seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
    seconds_left = seconds_left*60;
}
//funcion especial para mostrar los comentarios del text de maquinas sin contadores
function muestra_cajaesp(id){
    var val = document.getElementById("control35").value;
    //si es vacio no mostrara nada al hacer click
    if(val != ""){
        var c = consulta_valor(id);
        var e = trae_estado(id);   
        alert(c+'\n'+e);
    }
}
//-----------------------------------------------------------------------------------------------------

$(document).ready(function(){
   
    $(".checkbill").click(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas check 
        var id = $(this).attr("value"); // Le pasa el valor del checkbox      
        if(!(verifica_tarea(id))){  
            content = document.getElementById(id);//COLOCA EL OBJETO ID (EL TITULO) EN LA VARIABLE CONTENT     
            document.getElementById('titulo').innerHTML = content.innerHTML;//COLOCA EL TITULO PARA MOSTRAR
            //document.getElementById('subtitulo').innerHTML = subtitulo;
            document.getElementById('texto').value = id;//CAMPO OCULTA QUE TIENE EL ID
            document.getElementById('tpend').value = id;//NUMERO DE TAREA A MOSTRAR
            document.getElementById('cpend').value = '';        
            //deshabilita todos los controles del form1
            controlar_form();   
            
            $('#popup').fadeIn('slow');
            $('.popup-overlay').fadeIn('slow');
            $('.popup-overlay').height($(window).height());
            var subtitulo = '';
            switch(parseInt(id)){
                case 18: case 22: case 25: case 81:
                    subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                    document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR
                    document.getElementById('cpend').value = "TOTAL CAS:\nDIFERENCIAS:"
                    break;
                case 19: case 26: case 32:
                    subtitulo = 'Comentar casos de diferencias significativas';
                    document.getElementById('subtitulo').innerHTML = subtitulo;
                    break;
                case 28://SFECORE
                    subtitulo = 'Agregar Total Billetes segun mail recibido';
                    document.getElementById('cpend').value = "RECAUDACION POR REGISTRO:\nRECAUDACION POR FISICO:\nDIFERENCIA:"
                    break;
                case 31://billetes MDPCORE
                    subtitulo = 'Agregar Total Billetes CAS y Total Diferencias';
                    document.getElementById('subtitulo').innerHTML = subtitulo;//COLOCA EL SUBTITULO A MOSTRAR
                    document.getElementById('cpend').value = "TOTAL CAS CENTRAL:\nTOTAL CAS RIVADAVIA:\nTOTAL CAS RAMBLA:\nDIFERENCIAS CENTRAL:\nDIFERENCIAS RIVADAVIA:\nDIFERENCIAS RAMBLA:";                   
                    break;
            }
           ctrlbill=1;// DIFERENCIA ENTRE TAREA PENDIENTE Y CONTROL DE BILLETES
           bandera=1;
        }else{
            alert('La tarea ya se encuentra realizada!!!');
            window.location.href = 'check.php'; 
        } 
           
    });
  
});
//-------------------------------------------------------------------------------
//VERIFICA QUE NO QUEDEN TAREAS SIN REALIZAR ANTES DE CERRAR LA FDP
function Verifica_Comentarios() { 
        //VERIFICA SI LAS TAREAS SE ENCUENTRAN REALIZADAS EN SU TOTALIDAD
          var cantEle = document.getElementById("form1").elements.length;
          var cont=0;
          var text='Las tareas: ';
          var j=1; 
          for(var i=0;i < cantEle;i++){
            if (document.getElementById("form1").elements[i].type=='checkbox'){
                if (!document.getElementById("form1").elements[i].checked){           
                    j +=1;
                    text += document.getElementById("form1").elements[i].value+ ' - ';
                }
            } 
          }
          //-------------------------------------
          //Obtiene la hora para controlar si se debe cerrar la FDP
          //entre las 21:00 y las 23:59 se debera cerrar la FDP, de lo contrario no
          //permitira cerrar el turno 
          var hora = obtiene_hora();     
          h=hora;     
          var idu=id_user;
          var idh = <? echo $_SESSION['id_hoja']; ?>    
          if(j==1){ //Si es 1, implica que todas las tareas se encuentran realizadas                  
                var resp = confirm("Las tareas se encuentran completadas. Se cerrara la FDP actual. Desea hacerlo?");
                if (resp == true) {        
                    //val=0 indica que cerrara el turno
                     $.ajax({url:"editar.php?val=0",cache:false,type:"POST",data:{idh:idh,idu:idu}});
                    //val=2 indica que cerrara la FDP 
                    //alert(h);           
                    $.ajax({url:"editar.php?val=2",cache:false,type:"POST",data:{idh:idh,idu:idu,h:h}});
                    //Redirecciona a la vista previa de cierre de turno
                    //coloca variablew cierrefdp en verdadero que indica que se cierra la FDP tambien
                    window.location.href = 'mailcierre.php?cierrefdp=verdadero';    
                }else{
                    //si se cancela el cierre, redirecciona a la hoja principal
                    window.location.href = 'principal.php?id=hoja_principal';                
                }
           //cuando existan tareas sin realizar pero se este en el rango de cierre de FDP, dara un aviso
          }else if((hora > "21:00") && (hora < "23:59")){
                var t = j -1;//t=cantidad de tareas sin completar
                alert('Restan '+t+' tareas sin realizar. Por favor, completar o dejar pendientes para cerrar la FDP');
          }else{                
                //si no esta en el rango de cierre de FDP, simplemente cerrara el turno
                $.ajax({url:"editar.php?val=0",cache:false,type:"POST",data:{idh:idh,idu:idu}});
                window.location.href = 'mailcierre.php?cierrefdp=falso';
          }          
}

//pregunta si se desea cerrar el turno y se dirige a Verifica_Comentarios
function cierra_turno(){  
    var resp = confirm("Desea cerrar el turno?");
    if (resp == true) {        
        Verifica_Comentarios();
    }else{
        window.location.href = 'principal.php?id=hoja_principal'; 
    }   
}
//al abrir el form modal, deshabilita todo el fondo
function deshabilita_ctrl(){
    fr = document.form1;
    for (i=0; ele=fr.elements[i]; i++){
        ele.disabled = true;
    }
    //elementos del modal de pendientes
    document.getElementById('cpend').disabled=false;
    document.getElementById('btnaceptar').disabled=false;
    document.getElementById('btncancelar').disabled=false;
    document.getElementById('volver').style.visibility = 'hidden';
    //elementos del modal de envio FTP
    document.getElementById('archivo1').disabled=false;
    document.getElementById('archivo2').disabled=false;
    document.getElementById('btnenviarftp').disabled=false;
    document.getElementById('btncancelarftp').disabled=false;
}
function habilita_ctrl(){
    window.location.href = 'check.php';
}
function controlar_form(){
    //deshabilita todos los controles del form1
    deshabilita_ctrl();
    //pinta el fondo de color gris transparente        
    $("body").css({'position':'fixed','left':'0','top':'0','background-color':'#ccc','opacity':'0.6','filter':'alpha(opacity=60)'});
}
//Consulta a la BD si se realizo la tarea
function verifica_tarea(id){
        idt=id;        
        idh=$("#hoja").val();//id hoja 
        var coment = $.ajax({
            url:"traecomentarios.php?val=1",
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idt:idt,idh:idh,idu:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto            
         if(coment == ""){ 
                //tarea no realizada
                return false;
         }else{                     
                //tarea realizada
                return true;
         } 
}
function obtiene_hora(){
    var tiempo = new Date();  //obtiene la fecha y hora
    var horas = tiempo.getHours();    //extrae las horas
    var minutos = tiempo.getMinutes();    //extrae los minutos    
    if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
      minutos = '0'+minutos;
    }  
    var h = horas+':'+minutos;     //coloca la hora completa en la variable hora
    return h;

}
//OBTIENE FECHA Y HORA PARA GUARDAR EN BD MYSQL
function obtiene_fechahora(){
    var hoy = new Date();    
    var dd = hoy.getDate();
    var mm = hoy.getMonth();
    mm = mm + 1;
    var yyyy = hoy.getFullYear();
    var h = hoy.getHours();    //extrae las horas
    var m = hoy.getMinutes();    //extrae los minutos    
    if(dd<10){
        dd='0'+dd;
    }
    if(mm<10){
        mm='0'+mm;
    }
    
    if(h<10){
        h='0'+h;
    }
    if(m<10){
        m='0'+m;
    }
    hoy = yyyy+'-'+mm+'-'+dd+' '+h+':'+m+':00';
    
    return hoy;
}
//trae la fdp en proceso
function trae_fdp(){        
    var coment = $.ajax({
        url:"traecomentarios.php?val=3",
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idt:0,idh:0,idu:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto
    var x = coment.split('-');
    var xt = x[2]+'/'+x[1]+'/'+x[0];   
    return xt;  
}
//obtiene fecha actual para generar mail de cintas de backup
function fecha_actual(){
    var f = new Date();
    var d = f.getDate();
    var m = f.getMonth() +1;
    if(d < 10){
        d= '0'+d;        
    }
    if(m < 10){
       m = '0'+m; 
    }    
    var fc = d + "/" + m + "/" + f.getFullYear();
    return fc;
}

//Abre el mail con plantillas predeterminadas de envio a diferentes areas
function envio_mail(id){    
    var mailfdp = trae_fdp(); //obtiene la FDP para colocarsela en los mails      
    var enlace="";
    switch(parseInt(id)){        
        case 10://cvc 
            //linea para enviar mail por outlook                     
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=AuditoriaMaquinas@casinovictoria.com.ar;mdp_operadores@boldt.com.ar&subject=Cierre FDP: "+mailfdp+" CASINO VICTORIA&body=Sres.%0A%0ASe encuentra cerrada la FDP: "+mailfdp+" %0A%0A Saludos.","_blank");           
            break;        
        case 4://sfe y mlc envio de archivos finales
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=controlcasinos@santafe.gov.ar;mdp_operadores@boldt.com.ar&subject=Envio de archivos finales CAS - FDP: "+mailfdp+"&body=%0A","_blank");
            break;        
        case 20://envio de conciliacion de paraguay
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=Jcf.americangaming@gmail.com;sargumedo@7saltos.com;spuente@boldt.com.ar;jbecker@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Resumen conciliacion - 7 Saltos&body=%0A%0A%0A","_blank");
            break;
        case 31://control de billetes MDPCORE
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=FDP: "+mailfdp+" DIF. BILL CCE $0 ; CRI $0 ; CCR $ 0  &body= ","_blank");     
            break;  
        /*case 39://envio BIBO
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=gamadori@boldt.com.ar;jMamczak@boldt.com.ar;procesosbi@boldt.com.ar;gcastell@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=BIBO - CORECENTRAL - FDP: "+mailfdp+" &body=%0A ENVIADO!!!","_blank");
            break;*/
       case 34://esperado a Casino Tandil
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=casinotandil@loteria.gba.gov.ar;HJaimon@boldt.com.ar;SDiluca@boldt.com.ar;ASantama@boldt.com.ar;SDurruty@boldt.com.ar;GMazza@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Esperado de billetes Casino Tandil FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");
            break;
      /*  case 42://envio rogre a CDM
            enlace = "mailto:CCordara@boldt.com.ar;HBracco@boldt.com.ar?cc=mdp_operadores@boldt.com.ar&subject=Progresivo Casino del Mar FDP: "+mailfdp+" &body=%0A";             
            location.href=enlace;
            break;*/
        case 43://envio progre semanal
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jMamczak@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Progresivos Semanal Pcia. Bs. As.&body=%0A ","_blank");          
            break;
        case 45://MAIL Contabilidad IPLYC TK EN PP
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=deppejos@loteria.gba.gov.ar;ghizznic@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Envio de TK PP y para Anular&body=Se adjunta planilla con Tk en Proceso de pago y para anular","_blank");
            break;   
        case 48://Controles de contadores contables y billetes en CORE
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Controles de contadores contables y billetes en CORE "+mailfdp+" &body=%0A","_blank");
            break;
        case 52://Cambio de Cintas - Control de Backups / Mail con comentarios
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Cambio de Cintas - Control de Backups "+fecha_actual()+" &body=%0A","_blank");
            break; 
        case 54://Control de Resumenes de Contadores de Billetes y Contables / Mail c/comentarios           
            break;     
        case 84://OVALLE - envio diferencias de conciliacion
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=computos@ovallecasinoresort.cl;JSalaber@boldt.com.ar;spuente@boldt.com.ar;Patricio.orrego@OvalleCasinoResort.cl;mdp_operadores@boldt.com.ar&subject=FDP: "+mailfdp+" - CONCILIACION OVALLE &body=%0A","_blank");
            break;
        case 86://OVALLE - envio de pedido de anulacio o completado de PP
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=patricio.orrego@ovallecasinoresort.cl;computos@ovallecasinoresort.cl;Bunker@ovallecasinoresort.cl;mdp_operadores@boldt.com.ar;spuente@boldt.com.ar&subject=OVALLE FDP: "+mailfdp+" - Pedido de completado de PP &body=%0ABunker:%0A%0ASe solicita completar los siguientes TK que estan en Proceso de Pago.%0A%0A* Se adjunta imagen solo con los TK que se deben completar, el resto de los que puedan aparecer en pantalla no deben completarse.%0A%0A* Se realiza desde el Menu CASTITO: control Operativo / tratamiento de TK en PP para FDP de ayer.%0A%0ARealizado esto, las diferencias en conciliacion compensaran con fecha de hoy.","_blank");
            break;
        case 91://OVALLE - envio de pedido de anulacio o completado de PP
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=patricio.orrego@ovallecasinoresort.cl;computos@ovallecasinoresort.cl;Bunker@ovallecasinoresort.cl;mdp_operadores@boldt.com.ar;spuente@boldt.com.ar&subject=OVALLE FDP: "+mailfdp+" - Pedido de anulacion de TK &body=%0ABunker:%0A%0ASe solicita anular los siguientes TK que se han pagado como PFS.","_blank");
            break;
        case 92://esperado a Casino del Mar
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=casinohermitage@loteria.gba.gov.ar;casinohermitage@iplyc.gov.ar;ghizznic@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Esperado de billetes Casino Del Mar FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");           
            break; 
        case 95://esperado a SASSO HOTEL
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=casinosasso@loteria.gba.gov.ar;ghizznic@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Esperado de billetes Casino Hotel SASSO FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");
            break;
        case 99://Ganancia de contadores a Trilenium
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jmamczak@boldt.com.ar;operador@trileniumcasino.com.ar;marsabjul@hotmail.com;mdp_operadores@boldt.com.ar&subject=Ganancia por Contadores y Resultado de Contadores con Promo Ticket Casinos Bs. As. FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");          
            break;
        case 100://Envio de sumarizado de ticket por maquina a MAMCZACK
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jmamczak@boldt.com.ar;rmartine@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Reporte Movimiento Sumarizado de Ticket por Maquina Casinos Bs. As. FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");          
            break;
        case 101://Envio de promo ticket por maquina y comparacion meter fisico conciliado a MAMCZACK
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jmamczak@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Reporte Promo Ticket por Maquina (Central-Miramar-Tandil) FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");          
            break;
     }      
}
//EMAIL DE PENDIENTES
function envio_mail_pendientes(id,texto){    
    var mailfdp = trae_fdp(); 
    var enlace="";
    switch(parseInt(id)){ 
        case 1://PENDIENTE: INFORME DIARIO SFE
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - SFE - INFORME DIARIO FDP: "+mailfdp+"&body=%0A%0A%0A "+texto,"_blank");
            break;  
        case 6://PENDIENTE: INFORME DIARIO VICTORIA
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - VICTORIA - INFORME DIARIO FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;       
        case 13://PENDIENTE: INFORME DIARIO 7 SALTOS PARAGUAY
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - 7 SALTOS PARAGUAY - INFORME DIARIO FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;       
        case 18://PENDIENTE: BILLETES PARAGUAY
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - 7 SALTOS PARAGUAY - BILLETES FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;              
        case 22://PENDIENTE: BILLETES VICTORIA
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - VICTORIA - BILLETES FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;    
        case 25://PENDIENTE: BILLETES MELINCUE
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - MELINCUE - BILLETES FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;
        case 28://PENDIENTE: BILLETES SFE
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=TAREA PENDIENTE - SFE - BILLETES FDP: "+mailfdp+"&body=%0A%0A%0A"+texto,"_blank");
            break;
    }
}
</script>

<style>
body{
    background-color: aqua;
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
    padding-right: 100px;
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
/*----------------------------------------------*/
/*----------------------------------------------*/
/*FORM MODAL DE ENVIO FTP*/
#popupftp {
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1001;
}

.content-popupftp {
    margin:0px auto;
    margin-top:120px;
    position:relative;
    padding:10px;
    width:560px;
    min-height:10px;
    border-radius:4px;
    background-color: black;
    box-shadow: 0 2px 5px #666666;
}

.content-popupftp h2 {
    color:#48484B;
    border-bottom: 1px solid #48484B;
    margin-top: 0;
    padding-bottom: 4px;
}

.popup-overlayftp {
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

#fmodalftp{
    padding: 5px 55px 5px 5px;
    background-color: aqua;
    width: 500px;
    height: 150px;
}
h2{
    font-size: 16px;
}


/*----------------------------------*/
/*CONTENEDOR - Contiene todo el check*/
#contenedor {
    width: 1240px;
    height: 1590px;
    border: green 1px solid;
}

#tdhora{
    width: 0.50;
}
#td{
    border: green 1px solid;
}
/*DIV IZQUIERDO*/
#izquierda{
  float: left;
  width: 500px;
  height: 1400px;
  border: green 1px solid;
 margin: 1px 1px 1px 1px;
}
/*DIV DERECHO*/
#derecha {
  float: left;
  width: 520px;
  height: 1400px;
  border: green 1px solid;
  margin: 1px 1px 1px 1px;
}
/*CSS DE MENU - INCLUYE LA FDP Y EL BOTON DE CERRAR*/
#menu{
    float: left;
    width: 205px;
    height: 375px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#t_menu{
    width: 14px;
    margin: 0 0 0 50px;
}
#menuII{
    float: left;
    width: 205px;
    height: 170px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#menuII h3{
    margin: 10px 0 5px 0;
    text-align: center;
    text-decoration: underline;
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
    width: 205px;
    height: 50px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
    padding: 25px 0px 0 0px;
    text-align: center;
    
}
    /*div de aviso de envio FTP*/
    #avisos{
        float: left;
        width: 205px;
        height: 125px;
        border: green 1px solid;
        margin: 1px 1px 1px 1px;   
        text-align: center;
        padding: 10px 0px 0 0px;
    }
    #aviso_title{
        color: red;
        text-decoration: underline;
        font-weight: bold;
        margin: 0 0 20px 0;
    }
    #aviso_cont{
        color: red;
    }
    /*--------------------------*/
    /*Usuario que realiza el cierre de check*/
    #div_usercierre{
        float: left;
        width: 205px;
        height: 125px;
        border: green 1px solid;
        margin: 1px 1px 1px 1px;   
        text-align: center;
        padding: 10px 0px 0 0px;
    }
    #usercierre{
        float: left;
        width: 205px;
        height: 30px;  
        margin: 1px 1px 1px 1px;
        padding: 10px 0px 0 0px;
        text-align: center;
        color: red;
        font-weight: bold;
    }
    /*----------------------------------------*/
#horacierre{
    float: left;
    width: 205px;
    height: 20px;  
   
    text-align: center;
    color: red;
    font-weight: bold;
}
#t_usercierre{
    float: left;
    width: 205px;
    height: 50px;  
    margin: 1px 1px 1px 1px;
    padding: 5px 0px 0 0px;
    text-align: center;
}
/*-------------------------------------------------*/
/*-----------------TABLAS DE TAREAS----------------*/
#encabezado_tabla{
    font-size: 13px;
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
/*-------------------------------------------------*/
/*------------TAREAS-------------------*/
.tarea{
    width: 380px;
    height: 0px;
}
/*-----------DIV QUE CONTIENE LOS OPERADORES------*/
#der_divizq{
    float: left;
    width: 280px;
    height: 185px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#der_divder{
    float: left;
    width: 230px;
    height: 185px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#t_divizq{
    vertical-align: central;
    width: 270px;
    height: 170px;
    font-size: 10px;
    border: green 1px solid;
    margin: 5px 1px 1px 5px;
}
#t_divder{
    width: 225px;
    height: 175px;
    font-size: 10px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#pie{
    float: left;
    width: 1230px;
    height: 170px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#t_pie{
    float: left;
    width: 1225px;
    height: 75px;
    font-size: 10px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#t_pie td{
    float: left;
}
#comentarios{
    float: left;
    width: 450px;
    height: 150px;
    border: green 1px solid;
    margin: 1px 1px 1px 1px;
}
#control35{
    margin: 0 0 0 0px;
    text-align: center;
}
#control90{
    margin: 0 0 0 0px;
    text-align: center;
}

</style>
</head>

<body>
		<?
		//variable accio: sirve para indicar cuando los datos se guardan, actualizan o borran
		if (isset($_GET['accion'])){
    		$valor = $_GET['accion'];
		}else{
				$valor=0;	
		}
		switch($valor){
			case 0: break;
			case 1:	echo "<center><font color='#0000FF'></br>Los datos se guardaron correctamente!!!</font></center>";                    
					break;
			case 2:	echo "<center><font color='#0000FF'></br>Los datos se actualizaron correctamente!!!</font></center>";
					break;
			case 3:	echo "<center><font color='#0000FF'></br>Se ha borrado la tarea de la base de datos!!!</font></center>";
					break;
			case 4:	echo "<center><font color='#FF0000'></br>No se ha borrado la tarea de la base de datos.</font></center>";
					break;
		}	
		?>
<form id="form1" name="form1" method="post" action="guardar_tareas.php">
<!--
--------------------TURNO MAÑANA - OPERACION CASINOS SANTA FE - MELINCUE----------------------------------
-->
<div id="contenedor">
<div id="izquierda">
<?


?>
<input type="hidden" value="<? echo $_SESSION['id_hoja'] ?>" id="hoja"/>
<input type="hidden" value="<? echo $_SESSION['usuario'] ?>" id="txtuser"/>
<?
if(isset($_GET['ctrl'])){  
?>
<input type="hidden" value="<? echo $_GET['ctrl'] ?>" id="ctrl"/>
<?}?>
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO MA&Ntilde;ANA - OPERACION CASINOS SANTA FE - MELINCUE</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
        
    <tr>        
    	<td>1</td>
    	<td id="1" class="tarea" onclick="muestra_caja(1)">Generaci&oacute;n contadores con discontinuidad - CONTABLES Y BILLETES</td>
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
    	<td id="2" class="tarea" onclick="muestra_caja(2)">Controlar y Completar Informe Diario</td>
        <td><input name="checkbox2" type="checkbox" value="2" id="checkbox2" class="check"/></td>
        <td><input name="hora2" type="text" id="hora2" readonly="true" size="6"/></td> 
               
    </tr>
	<tr>
    	<td>3</td>
    	<td id="3" class="tarea" onclick="muestra_caja(3)">Responder mail de cierre con OK del control a Barracas</td>
        <td><input name="checkbox3" type="checkbox" value="3" id="checkbox3" class="check"/></td>
        <td><input name="hora3" type="text" id="hora3" readonly="true" size="6"/></td> 
         
    </tr>
    <tr>
    	<td>4</td>
    	<td id="4" class="tarea" onclick="muestra_caja(4)">Envio de archivos finales a Loteria Santa Fe ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox4" type="checkbox" value="4" id="checkbox4" class="check"/></td>
        <td><input name="hora4" type="text" id="hora4" readonly="true" size="6"/></td>
              
    </tr>
    <tr>
    	<td>98</td>
    	<td id="98" class="tarea" onclick="muestra_caja(98)">Generar y guardar reporte: LIQUIDACI&Oacute;N IMPUESTO AL JUEGO desde CRW</b></td>
      	<td><input name="checkbox98" type="checkbox" value="98" id="checkbox98" class="check"/></td>        
        <td><input name="hora98" type="text" id="hora98" readonly="true" size="6"/></td>  
       
    </tr> 
    <tr>
    	<td>5</td>
    	<td id="5" class="tarea" onclick="muestra_caja(5)">MELINCUE - Exportaci&oacute;n y Upload de archivo CASTITO</td>
        <td><input name="checkbox5" type="checkbox" value="5" id="checkbox5" class="check"/></td>
        <td><input name="hora5" type="text" id="hora5" readonly="true" size="6"/></td>
         
        
    </tr>

</table>
<!--
-----------------------------------TURNO MAÑANA - OPERACION CASINO VICTORIA-----------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO MA&Ntilde;ANA - OPERACION CASINO VICTORIA</td>        
    </tr>
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>  
    <tr>
    	<td>9</td>
    	<td id="9" class="tarea" onclick="muestra_caja(9)">Realizar cierre de Fecha de Producci&oacute;n (CASWEB)</td>
      	<td><input name="checkbox9" type="checkbox" value="9" id="checkbox9" class="check"/></td>        
        <td><input name="hora9" type="text" id="hora9" readonly="true" size="6"/></td> 
        
    </tr>  
    <tr>
    	<td>88</td>
    	<td id="88" class="tarea" onclick="muestra_caja(88)">Generaci&oacute;n contadores con discontinuidad - CONTABLES Y BILLETES</td>
        <td><input name="checkbox88" type="checkbox" value="88" id="checkbox88" class="check"/></td>        
        <td><input name="hora88" type="text" id="hora88" readonly="true" size="6" /></td> 
      
    </tr>
    <tr>
    	<td>6</td>
    	<td id="6" class="tarea" onclick="muestra_caja(6)">Generaci&oacute;n de Informe Diario - Controlar y Completar</td>
        <td><input name="checkbox6" type="checkbox" value="6" id="checkbox6" class="check"/></td>        
        <td><input name="hora6" type="text" id="hora6" readonly="true" size="6" /></td> 
      
    </tr>
    <!-- <tr>
    	<td>7</td>
    	<td id="7" class="tarea" onclick="muestra_caja(7)">Controlar y Completar Informe Diario</td>
        <td><input name="checkbox7" type="checkbox" value="7" id="checkbox7" class="check"/></td>        
        <td><input name="hora7" type="text" id="hora7" readonly="true" size="6" /></td> 
      
    </tr> -->
	<tr>
    	<td>8</td>
    	<td id="8" class="tarea" onclick="muestra_caja(8)">Exportaci&oacute;n y Upload de archivo CASTITO --------------------------------- <b><font size="4" color="red">09:00 hs.</font></b></td>
      	<td><input name="checkbox8" type="checkbox" value="8" id="checkbox8" class="check"/></td>        
        <td><input name="hora8" type="text" id="hora8" readonly="true" size="6"/></td>  
       
    </tr> 
    <tr>
    	<td>97</td>
    	<td id="97" class="tarea" onclick="muestra_caja(97)">Generar y guardar reporte: LIQUIDACI&Oacute;N IMPUESTO AL JUEGO desde CRW</b></td>
      	<td><input name="checkbox97" type="checkbox" value="97" id="checkbox97" class="check"/></td>        
        <td><input name="hora97" type="text" id="hora97" readonly="true" size="6"/></td>  
       
    </tr>    
    <tr>
    	<td>10</td>
    	<td id="10" class="tarea" onclick="muestra_caja(10)">Enviar confirmaci&oacute;n de cierre a Victoria ----<b><font size="2" color="red">(mail)</font></b></td>
      	<td><input name="checkbox10" type="checkbox" value="10" id="checkbox10" class="check"/></td>        
        <td><input name="hora10" type="text" id="hora10" readonly="true" size="6"/></td>  
           
    </tr>
</table>

<!--
-------------------------------TURNO MAÑANA - OPERACION OVALLE CHILE---------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO MA&Ntilde;ANA - OPERACION OVALLE - CHILE</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
        
    <tr>
    	<td>76</td>
    	<td id="76" class="tarea" onclick="muestra_caja(76)">Generaci&oacute;n de Informe: R&aacute;nking de M&aacute;quinas y Contadores con Discontinuidad</td>
        <td><input name="checkbox76" type="checkbox" value="76" id="checkbox76" class="check"/></td>        
        <td><input name="hora76" type="text" id="hora76" readonly="true" size="6"/></td> 
      
    </tr>
    <tr>
    	<td>77</td>
    	<td id="77" class="tarea" onclick="muestra_caja(77)">Generaci&oacute;n de Reporte: Comparaci&oacute;n de Premios</td>
        <td><input name="checkbox77" type="checkbox" value="77" id="checkbox77" class="check"/></td>
        <td><input name="hora77" type="text" id="hora77" readonly="true" size="6"/></td>   
    
    </tr>
    <tr>
    	<td>83</td>
    	<td id="83" class="tarea" onclick="muestra_caja(83)">Generaci&oacute;n de Reporte: TK Generados CASTITO mayores a $800.000</td>
        <td><input name="checkbox83" type="checkbox" value="83" id="checkbox83" class="check"/></td>
        <td><input name="hora83" type="text" id="hora83" readonly="true" size="6"/></td>   
    
    </tr>
	<tr>
    	<td>78</td>
    	<td id="78" class="tarea" onclick="muestra_caja(78)">Responder mail de cierre con OK del control a Barracas</td>
        <td><input name="checkbox78" type="checkbox" value="78" id="checkbox78" class="check"/></td>
        <td><input name="hora78" type="text" id="hora78" readonly="true" size="6"/></td>   
       
    </tr>
    <tr>
    	<td>79</td>
    	<td id="79" class="tarea" onclick="muestra_caja(79)">CASTITO: <b><font color="red">Pagos y cargas - Recaudaci&oacute;n - Movimiento de sala </font></b>--------<b><font color="red" size="3">10:45 hs.</font></b></td>
        <td><input name="checkbox79" type="checkbox" value="79" id="checkbox79" class="check"/></td>
        <td><input name="hora79" type="text" id="hora79" readonly="true" size="6"/></td>
            
    </tr>
    <tr>
    	<td>86</td>
    	<td id="86" class="tarea" onclick="muestra_caja(86)">Pedido de completado de PP-------------------------------<b><font color="red" size="3">11:15 hs. (mail)</font></b></td>
        <td><input name="checkbox86" type="checkbox" value="86" id="checkbox86" class="check"/></td>
        <td><input name="hora86" type="text" id="hora86" readonly="true" size="6"/></td>
            
    </tr>
    <tr>
    	<td>91</td>
    	<td id="91" class="tarea" onclick="muestra_caja(91)">Pedido de anulaci&oacute;n de TK---------------------------------<b><font color="red" size="3">11:15 hs. (mail)</font></b></td>
        <td><input name="checkbox91" type="checkbox" value="91" id="checkbox91" class="check"/></td>
        <td><input name="hora91" type="text" id="hora91" readonly="true" size="6"/></td>
            
    </tr>
    <tr>
    	<td>85</td>
    	<td id="85" class="tarea" onclick="muestra_caja(85)">Exportaci&oacute;n 5 WIN-----(Reporte Movimiento de Sala)</td>
        <td><input name="checkbox85" type="checkbox" value="85" id="checkbox85" class="check"/></td>
        <td><input name="hora85" type="text" id="hora85" readonly="true" size="6"/></td>
            
    </tr>   
</table>
<!--
-------------------------------BILLETES Y CONCILIACION A DEMANDA---------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">BILLETES Y CONCILIACION A DEMANDA</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>CASINO 7 SALTOS PARAGUAY</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
        
    <tr>
    	<td>17</td>
    	<td id="17" class="tarea" onclick="muestra_caja(17)">PARAGUAY - Recepci&oacute;n de mail BILLETES</td>
        <td><input name="checkbox17" type="checkbox" value="17" id="checkbox17" class="check"/></td>        
        <td><input name="hora17" type="text" id="hora17" readonly="true" size="6" /></td> 
    
    </tr>
    <tr>
    	<td>18</td>
    	<td id="18" class="tarea" onclick="muestra_caja(18)">PARAGUAY - Control de Billetes</td>
        <td><input name="checkbox18" type="checkbox" value="18" id="checkbox18" class="checkbill"/></td>
        <td><input name="hora18" type="text" id="hora18" readonly="true" size="6"/></td> 
     
         
    </tr>
	<tr>
    	<td>19</td>
    	<td id="19" class="tarea" onclick="muestra_caja(19)">PARAGUAY - Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox19" type="checkbox" value="19" id="checkbox19" class="checkbill"/></td>
        <td><input name="hora19" type="text" id="hora19" readonly="true" size="6"/></td>  
          
    </tr>
    <tr>
    	<td>20</td>
    	<td id="20" class="tarea" onclick="muestra_caja(20)">PARAGUAY - Env&iacute;o de Resumen de Conciliaci&oacute;n ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox20" type="checkbox" value="20" id="checkbox20" class="check"/></td>
        <td><input name="hora20" type="text" id="hora20" readonly="true" size="6"/></td>  
         
    </tr>   
</table>
<!--
-------------------------------------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<th>ID</th>
    	<th>CASINO VICTORIA ENTRE RIOS</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>21</td>
    	<td id="21" class="tarea" onclick="muestra_caja(21)">VICTORIA - Recepci&oacute;n de mail BILLETES</td>
        <td><input name="checkbox21" type="checkbox" value="21" id="checkbox21" class="check"/></td>        
        <td><input name="hora21" type="text" id="hora21" readonly="true" size="6"/></td>    
       
    </tr>
    <tr>
    	<td>22</td>
    	<td id="22" class="tarea" onclick="muestra_caja(22)">VICTORIA - Control de Billetes</td>
        <td><input name="checkbox22" type="checkbox" value="22" id="checkbox22" class="checkbill"/></td>
        <td><input name="hora22" type="text" id="hora22" readonly="true" size="6"/></td> 
             
    </tr>
	<tr>
    	<td>23</td>
    	<td id="23" class="tarea" onclick="muestra_caja(23)">VICTORIA - Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox23" type="checkbox" value="23" id="checkbox23" class="check"/></td>
        <td><input name="hora23" type="text" id="hora23" readonly="true" size="6"/></td>  
            
    </tr>  
</table>
<!--
-------------------------------------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<th>ID</th>
    	<th>CASINO MELINCUE</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>24</td>
    	<td id="24" class="tarea" onclick="muestra_caja(24)">MELINCUE - Recepci&oacute;n de mail BILLETES <b><font size="1" color="red">  ---- LUNES - JUEVES - S&Aacute;BADO ----</font></b></td>
        <td><input name="checkbox24" type="checkbox" value="24" id="checkbox24" class="check"/></td>        
        <td><input name="hora24" type="text" id="hora24" readonly="true" size="6"/></td>   
      
    </tr>
    <tr>
    	<td>25</td>
    	<td id="25" class="tarea" onclick="muestra_caja(25)">MELINCUE - Control de Billetes</td>
        <td><input name="checkbox25" type="checkbox" value="25" id="checkbox25"  class="checkbill"/></td>
        <td><input name="hora25" type="text" id="hora25" readonly="true" size="6"/></td> 
            
    </tr>
	<tr>
    	<td>26</td>
    	<td id="26" class="tarea" onclick="muestra_caja(26)">MELINCUE - Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox26" type="checkbox" value="26" id="checkbox26" class="checkbill"/></td>
        <td><input name="hora26" type="text" id="hora26" readonly="true" size="6"/></td>    
         
    </tr>   
</table>
<!--
-------------------------------------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<th>ID</th>
    	<th>CASINO PUERTO SANTA FE</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>27</td>
    	<td id="27" class="tarea" onclick="muestra_caja(27)">SANTA FE - Recepci&oacute;n de mail BILLETES</td>
        <td><input name="checkbox27" type="checkbox" value="27" id="checkbox27" class="check"/></td>        
        <td><input name="hora27" type="text" id="hora27" readonly="true" size="6"/></td>   
       
    </tr>
    <tr>
    	<td>28</td>
    	<td id="28" class="tarea" onclick="muestra_caja(28)">SANTA FE- Control de Billetes</td>
        <td><input name="checkbox28" type="checkbox" value="28" id="checkbox28" class="checkbill"/></td>
        <td><input name="hora28" type="text" id="hora28" readonly="true" size="6"/></td>    
              
    </tr>
	<tr>
    	<td>29</td>
    	<td id="29" class="tarea" onclick="muestra_caja(29)">SANTA FE - Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox29" type="checkbox" value="29" id="checkbox29" class="check"/></td>
        <td><input name="hora29" type="text" id="hora29" readonly="true" size="6"/></td>  
            
    </tr>   
</table>
<!--
-------------------------------------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<th>ID</th>
    	<th>CASINO CENTRAL - ANEXOS</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>30</td>
    	<td id="30" class="tarea" onclick="muestra_caja(30)">MAR DEL PLATA -Pedido de Billetes a IPLyC</td>
        <td><input name="checkbox30" type="checkbox" value="30" id="checkbox30" class="check"/></td>        
        <td><input name="hora30" type="text" id="hora30" readonly="true" size="6"/></td>   
       
    </tr>
    <tr>
    	<td>31</td>
    	<td id="31" class="tarea" onclick="muestra_caja(31)">MAR DEL PLATA - Control de Billetes ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox31" type="checkbox" value="31" id="checkbox31" class="checkbill"/></td>
        <td><input name="hora31" type="text" id="hora31" readonly="true" size="6"/></td>              
    
    </tr>
	<tr>
    	<td>32</td>
    	<td id="32" class="tarea" onclick="muestra_caja(32)">MAR DEL PLATA -Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox32" type="checkbox" value="32" id="checkbox32" class="checkbill"/></td>
        <td><input name="hora32" type="text" id="hora32" readonly="true" size="6"/></td> 
          
    </tr>   
</table>
<!--
-------------------------------------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<th>ID</th>
    	<th>CASINO OVALLE</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>80</td>
    	<td id="80" class="tarea" onclick="muestra_caja(80)">OVALLE - Recepci&oacute;n de mail BILLETES</td>
        <td><input name="checkbox80" type="checkbox" value="80" id="checkbox80" class="check"/></td>        
        <td><input name="hora80" type="text" id="hora80" readonly="true" size="6"/></td>   
      
    </tr>
    <tr>
    	<td>81</td>
    	<td id="81" class="tarea" onclick="muestra_caja(81)">OVALLE - Control de Billetes</td>
        <td><input name="checkbox81" type="checkbox" value="81" id="checkbox81"  class="checkbill"/></td>
        <td><input name="hora81" type="text" id="hora81" readonly="true" size="6"/></td> 
            
    </tr>
	<tr>
    	<td>82</td>
    	<td id="82" class="tarea" onclick="muestra_caja(82)">OVALLE - Control de Conciliaci&oacute;n</td>
        <td><input name="checkbox82" type="checkbox" value="82" id="checkbox82" class="checkbill"/></td>
        <td><input name="hora82" type="text" id="hora82" readonly="true" size="6"/></td>    
         
    </tr> 
    <tr>
    	<td>84</td>
    	<td id="84" class="tarea" onclick="muestra_caja(84)">OVALLE - Envio resumen de Conciliaci&oacute;n ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox84" type="checkbox" value="84" id="checkbox84" class="check"/></td>        
        <td><input name="hora84" type="text" id="hora84" readonly="true" size="6"/></td>   
      
    </tr> 
</table>
</div><!-- FIN DIV IZQUIERDA -->

<div id="derecha">
<!--
------------------------------TURNO MAÑANA - PROVINCIA DE BUENOS AIRES-------------------------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO MA&Ntilde;ANA - PROVINCIA DE BUENOS AIRES</td>        
    </tr>
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
    <tr>
    	<td>35</td>
    	<td id="35" class="tarea" onclick="muestra_caja(35)">Contadores contables para todas las m&aacute;quinas</td>
        <td><input type="text" class="text" name="35" id="control35" size="2" /></td>
        <!-- <td><input name="checkbox35" type="checkbox" value="35" id="checkbox35" class="check"/></td> -->
        <td><input name="hora35" type="text" id="hora35" readonly="true" size="6"/></td>   
     
    </tr>
    <tr>
	   <td>90</td>
       <td id="90" class="tarea" onclick="muestra_caja(90)">Contadores de Billetes para todas las m&aacute;quinas --------------------------------- <b><font size="4" color="red">07:05 hs.</font></b></td>
       <td><input type="text" class="text" name="90" id="control90" size="2" /></td>
      <!-- <td><input name="checkbox90" type="checkbox" value="90" id="checkbox90" class="check"/></td> -->
       <td><input name="hora90" type="text" id="hora90" readonly="true" size="6"/></td> 
               
    </tr>
    <tr>
    	<td>41</td>
    	<td id="41" class="tarea" onclick="muestra_caja(41)">Realizar cierre de Fecha de Producci&oacute;n (CASWEB).</td>
        <td><input name="checkbox41" type="checkbox" value="41" id="checkbox41"  class="check"/></td>
        <td><input name="hora41" type="text" id="hora41" readonly="true" size="6"/></td> 
          
    </tr>
    <tr>
    	<td>33</td>
    	<td id="33" class="tarea" onclick="muestra_caja(33)">IMPRESO de Esperado a IPLyC - CASINO CENTRAL.-------------------- <b><font size="4" color="red">07:10 hs.</font></b></td>        
        <td><input name="checkbox33" type="checkbox" value="33" id="checkbox33" class="check"/></td>        
        <td><input name="hora33" type="text" id="hora33" readonly="true" size="6"/></td> 
     
    </tr>
<!--    <tr>
    	<td>92</td>
    	<td id="92" class="tarea" onclick="muestra_caja(92)">ENV&Iacute;O VIA MAIL de Esperado a Casino del Mar- <b><font size="4" color="red">07:10 hs.</font></b></td>
        <td><input name="checkbox92" type="checkbox" value="92" id="checkbox92" class="check"/></td>
        <td><input name="hora92" type="text" id="hora92" readonly="true" size="6"/></td>
          
         
    </tr> -->
    <tr>
    	<td>34</td>
    	<td id="34" class="tarea" onclick="muestra_caja(34)">ENV&Iacute;O VIA MAIL de Esperado a Tandil - (lun-mie-vie-sab)---------------- <b><font size="4" color="red">07:10 hs.</font></b></td>
        <td><input name="checkbox34" type="checkbox" value="34" id="checkbox34" class="check"/></td>
        <td><input name="hora34" type="text" id="hora34" readonly="true" size="6"/></td>
    </tr>
    <tr>
    	<td>95</td>
    	<td id="95" class="tarea" onclick="muestra_caja(95)">ENV&Iacute;O VIA MAIL de Esperado a SASSO HOTEL-(mar-sab)-------------- <b><font size="4" color="red">07:10 hs.</font></b></td>        
        <td><input name="checkbox95" type="checkbox" value="95" id="checkbox95" class="check"/></td>        
        <td><input name="hora95" type="text" id="hora95" readonly="true" size="6"/></td> 
     
    </tr>
    <tr>
    	<td>93</td>
    	<td id="93" class="tarea" onclick="muestra_caja(93)">ENV&Iacute;O FTP de ContadoresFinalesBilleteAjuste.csv</td>
        <td><input name="checkbox93" type="checkbox" value="93" id="checkbox93" class="check"/></td>
        <td><input name="hora93" type="text" id="hora93" readonly="true" size="6"/></td>
          
         
    </tr>
    <tr>
    	<td>87</td>
    	<td id="87" class="tarea" onclick="muestra_caja(87)">Generaci&oacute;n Contadores con discontinuidad. - CONTABLES Y BILLETES</td>
        <td><input name="checkbox87" type="checkbox" value="87" id="checkbox87"  class="check"/></td>
        <td><input name="hora87" type="text" id="hora87" readonly="true" size="6"/></td>   
          
    </tr>
    <tr>
    	<td>96</td>
    	<td id="96" class="tarea" onclick="muestra_caja(96)">Generar y guardar reporte: PROGRESIVOS - IMPUESTO AL JUEGO desde CRW</td>
        <td><input name="checkbox96" type="checkbox" value="96" id="checkbox96" class="check"/></td>        
        <td><input name="hora96" type="text" id="hora96" readonly="true" size="6"/></td> 
      
    </tr>
    <tr>
    	<td>37</td>
    	<td id="37" class="tarea" onclick="muestra_caja(37)">Generaci&oacute;n de Informe diario. Controlar y Completar</td>
        <td><input name="checkbox37" type="checkbox" value="37" id="checkbox37"  class="check"/></td>
        <td><input name="hora37" type="text" id="hora37" readonly="true" size="6"/></td>   
          
    </tr>
    <tr>
    	<td>99</td>
    	<td id="99" class="tarea" onclick="muestra_caja(99)">Generaci&oacute;n: Ganancia por Contadores - Resultado de Contadores con Promo Ticket-<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox99" type="checkbox" value="99" id="checkbox99"  class="check"/></td>
        <td><input name="hora99" type="text" id="hora99" readonly="true" size="6"/></td>   
          
    </tr>
    <tr>
    	<td>100</td>
    	<td id="100" class="tarea" onclick="muestra_caja(100)"><font color="red">CASTITO (Todos):</font> Reporte Movimiento Sumarizado de Ticket por M&aacute;quina--------<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox100" type="checkbox" value="100" id="checkbox100"  class="check"/></td>
        <td><input name="hora100" type="text" id="hora100" readonly="true" size="6"/></td>   
          
    </tr>
    <tr>
    	<td>101</td>
    	<td id="101" class="tarea" onclick="muestra_caja(101)"><font color="red">CASTITO (Central-Tandil-Miramar):</font> Promo ticket por VLT-----------------------------<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox101" type="checkbox" value="101" id="checkbox101"  class="check"/></td>
        <td><input name="hora101" type="text" id="hora101" readonly="true" size="6"/></td>   
          
    </tr>	
    <tr>
    	<td>40</td>
    	<td id="40" class="tarea" onclick="muestra_caja(40)">Env&iacute;o de Archivos Finales MD5 a IPLyC via FTP</td>
        <td><input name="checkbox40" type="checkbox" value="40" id="checkbox40" class="check"/></td><!--class=checkftp -->
        <td><input name="hora40" type="text" id="hora40" readonly="true" size="6"/></td>  
            
    </tr>    
    <tr>
    	<td>42</td>
    	<td id="42" class="tarea" onclick="muestra_caja(42)">Progresivos. Controlar Diferencias!!!!</td>
        <td><input name="checkbox42" type="checkbox" value="42" id="checkbox42" class="check"/></td>        
        <td><input name="hora42" type="text" id="hora42" readonly="true" size="6"/></td> 
      
    </tr>
    <tr>
    	<td>43</td>
    	<td id="43" class="tarea" onclick="muestra_caja(43)">Lunes: Env&iacute;o de Progresivos semanales ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox43" type="checkbox" value="43" id="checkbox43" class="check"/></td>
        <td><input name="hora43" type="text" id="hora43" readonly="true" size="6" /></td>   
          
    </tr>
	<tr>
    	<td>44</td>
    	<td id="44" class="tarea" onclick="muestra_caja(44)">Exportaci&oacute;n y upload de Archivo CASTITO. Todas las Salas. Incluso Cerradas</td>
        <td><input name="checkbox44" type="checkbox" value="44" id="checkbox44"  class="check"/></td>
        <td><input name="hora44" type="text" id="hora44" readonly="true" size="6"/></td>   
       
    </tr> 
    <tr>
    	<td>47</td>
    	<td id="47" class="tarea" onclick="muestra_caja(47)">Carga y control por Te&oacute;rico de Billetes para Anexos. Documentar Novedad.</td>
        <td><input name="checkbox47" type="checkbox" value="47" id="checkbox47" class="check"/></td>
        <td><input name="hora47" type="text" id="hora47" readonly="true" size="6"/></td> 
             
    </tr>  
    <tr>
    	<td>46</td>
    	<td id="46" class="tarea" onclick="muestra_caja(46)">Carga y Control de Tablero.</td>
        <td><input name="checkbox46" type="checkbox" value="46" id="checkbox46" class="check"/></td>
        <td><input name="hora46" type="text" id="hora46" readonly="true" size="6" /></td>             
    </tr>	   
    <tr>
    	<td>49</td>
    	<td id="49" class="tarea" onclick="muestra_caja(49)">Controles Pre-apertura Central-Del Mar. Documentar a Sala. --------------- <b><font size="4" color="red">10:00 hs.</font></b></td>
        <td><input name="checkbox49" type="checkbox" value="49" id="checkbox49" class="check"/></td>
        <td><input name="hora49" type="text" id="hora49" readonly="true" size="6"/></td>  
             
    </tr>
	<tr>
    	<td>50</td>
    	<td id="50" class="tarea" onclick="muestra_caja(50)">Controles Pre-apertura Tandil. Documentar a Sala. ---------------------------- <b><font size="4" color="red">10:00 hs.</font></b></td>
        <td><input name="checkbox50" type="checkbox" value="50" id="checkbox50" class="check"/></td>
        <td><input name="hora50" type="text" id="hora50" readonly="true" size="6" /></td> 
         
    </tr>           
</table>

<!--
-------------------------------TURNO MAÑANA - OPERACION 7 SALTOS PARAGUAY---------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO MA&Ntilde;ANA - OPERACION 7 SALTOS</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
        
    <tr>
    	<td>13</td>
    	<td id="13" class="tarea" onclick="muestra_caja(13)">Generaci&oacute;n contadores con discontinuidad - CONTABLES Y BILLETES</td>
        <td><input name="checkbox13" type="checkbox" value="13" id="checkbox13" class="check"/></td>        
        <td><input name="hora13" type="text" id="hora13" readonly="true" size="6"/></td> 
      
    </tr>
    <tr>
    	<td>14</td>
    	<td id="14" class="tarea" onclick="muestra_caja(14)">Generaci&oacute;n de Informe Diario - Controlar y Completar</td>
        <td><input name="checkbox14" type="checkbox" value="14" id="checkbox14" class="check"/></td>
        <td><input name="hora14" type="text" id="hora14" readonly="true" size="6"/></td>   
    
    </tr>
	<tr>
    	<td>15</td>
    	<td id="15" class="tarea" onclick="muestra_caja(15)">Responder mail de cierre con OK del control a Barracas</td>
        <td><input name="checkbox15" type="checkbox" value="15" id="checkbox15" class="check"/></td>
        <td><input name="hora15" type="text" id="hora15" readonly="true" size="6"/></td>   
       
    </tr>
    <tr>
    	<td>16</td>
    	<td id="16" class="tarea" onclick="muestra_caja(16)">Exportaci&oacute;n y Upload de archivo CASTITO para CAS</td>
        <td><input name="checkbox16" type="checkbox" value="16" id="checkbox16" class="check"/></td>
        <td><input name="hora16" type="text" id="hora16" readonly="true" size="6"/></td>
            
    </tr>   
</table>

<!--
------------------------------TURNO TARDE-----------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO TARDE</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th>        
       
    </tr>
        
    <tr>
    	<td>51</td>
    	<td id="51" class="tarea" onclick="muestra_caja(51)">Archivar reportes diarios</td>
        <td><input name="checkbox51" type="checkbox" value="51" id="checkbox51" class="check"/></td>        
        <td><input name="hora51" type="text" id="hora51" readonly="true" size="6" /></td> 
       
    </tr>
    <tr>
    	<td>52</td>
    	<td id="52" class="tarea" onclick="muestra_caja(52)">Cambio de Cintas FILESERVER (lun-mie-vie) - Control de Backups ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox52" type="checkbox" value="52" id="checkbox52" class="check"/></td>
        <td><input name="hora52" type="text" id="hora52" readonly="true" size="6" /></td>  
          
    </tr>
<!--    <tr>
    	<td>45</td>
    	<td id="45" class="tarea" onclick="muestra_caja(45)">Env&iacute;o de TK PP y para Anular a IPLyC via FTP-<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox45" type="checkbox" value="45" id="checkbox45" class="check"/></td>
        <td><input name="hora45" type="text" id="hora45" readonly="true" size="6"/></td>  
            
    </tr> -->	
    <tr>
    	<td>54</td>
    	<td id="54" class="tarea" onclick="muestra_caja(54)">Control de Res&uacute;menes de Contadores de Billetes y Contables ----<b><font size="2" color="red">(mail)</font></b></td>
        <td><input name="checkbox54" type="checkbox" value="54" id="checkbox54" class="check"/></td>
        <td><input name="hora54" type="text" id="hora54" readonly="true" size="6"/></td>   
          
    </tr>
    <tr>
    	<td>55</td>
    	<td id="55" class="tarea" onclick="muestra_caja(55)">MDPCORE/CVCCORE  - Realizar AJUSTES y Controlar discontinuidad</td>
        <td><input name="checkbox55" type="checkbox" value="55" id="checkbox55" class="check"/></td>
        <td><input name="hora55" type="text" id="hora55" readonly="true" size="6"/></td>
       
    </tr>
    <!-- <tr>ELIMINADA
    	<td>89</td>
    	<td id="89" class="tarea" onclick="muestra_caja(89)">FEPMT PINAMAR BOSQUE  - Reenv&iacute;o de paquete BAP desde Acciones FEP</td>
        <td><input name="checkbox89" type="checkbox" value="89" id="checkbox89" class="check"/></td>
        <td><input name="hora89" type="text" id="hora89" readonly="true" size="6"/></td>
       
    </tr> -->
</table>
<!--
------------------------------TURNO NOCHE---------------------------------------------------------------
-->
<table id="tabla">	
    <tr>
    	<td colspan="5" id="encabezado_tabla">TURNO NOCHE</td>        
    </tr>
    
    <tr>
    	<th>ID</th>
    	<th>TAREA</th>
        <th>CHECK</th>
    	<th>HORA</th> 
    </tr>
        
    <tr>
    	<td>56</td>
    	<td id="56" class="tarea" onclick="muestra_caja(56)">MDPCORE/CVCCORE - Control y env&iacute;o de Slots sin Contadores / Planilla</td>
        <td><input name="checkbox56" type="checkbox" value="56" id="checkbox56" class="check"/></td>        
        <td><input name="hora56" type="text" id="hora56" readonly="true" size="6" /></td>    
     
    </tr>
    <tr>
    	<td>57</td>
    	<td id="57" class="tarea" onclick="muestra_caja(57)">MDPCORE -  Generar y Guardar: M&aacute;quinas Enroladas Vigentes</td>
        <td><input name="checkbox57" type="checkbox" value="57" id="checkbox57" class="check"/></td>
        <td><input name="hora57" type="text" id="hora57" readonly="true" size="6"/></td>  
         
    </tr>
	<tr>
    	<td>58</td>
    	<td id="58" class="tarea" onclick="muestra_caja(58)">MDPCORE/CVCCORE  - Realizar AJUSTES y Controlar con Discontinuidad</td>
        <td><input name="checkbox58" type="checkbox" value="58" id="checkbox58" class="check"/></td>
        <td><input name="hora58" type="text" id="hora58" readonly="true" size="6" /></td> 
          
    </tr>
    <!-- ELIMINADA - NO SE USA MAS
    <tr>
    	<td>59</td>
    	<td id="59" class="tarea" onclick="muestra_caja(59)">MDPCORE /CVCCORE  - Generar y controlar  Parte Diario (sin imprimir)</td>
        <td><input name="checkbox59" type="checkbox" value="59" id="checkbox59" class="check"/></td>
        <td><input name="hora59" type="text" id="hora59" readonly="true" size="6" /></td>  
          
    </tr> -->
    <tr>
    	<td>94</td>
    	<td id="94" class="tarea" onclick="muestra_caja(94)">Generar y guardar reporte PROGRESIVOS desde CRW</td>
        <td><input name="checkbox94" type="checkbox" value="94" id="checkbox94" class="check"/></td>        
        <td><input name="hora94" type="text" id="hora94" readonly="true" size="6"/></td> 
      
    </tr>
    <tr>
    	<td>60</td>
    	<td id="60" class="tarea" onclick="muestra_caja(60)">MDPCORE - Carga de Progresivos</td>
        <td><input name="checkbox60" type="checkbox" value="60" id="checkbox60" class="check"/></td>
        <td><input name="hora60" type="text" id="hora60" readonly="true" size="6" /></td>
   
    </tr>
    <!-- ELIMINADA EL 20/07/2018 - NO SE USA MAS
    <tr>
    	<td>61</td>
    	<td id="61" class="tarea" onclick="muestra_caja(61)">Generar Tk en Proceso de Pago de CASINO VICTORIA <b><font size="4" color="red">06:10 hs.</font></b></td>
        <td><input name="checkbox61" type="checkbox" value="61" id="checkbox61" class="check"/></td>
        <td><input name="hora61" type="text" id="hora61" readonly="true" size="6" /></td>
       
    </tr> -->
    
</table>
<!--
------------------------------MONITOREO---------------------------------------------------------------
-->
   <?
    include('clases/c_usuario.php');
    $us = new usuario;
    
    //trae de la bd las tareas guardadas para rellenar el check
    include("clases/c_diario.php");
    $diario = new diario;
    
    include("clases/c_hoja.php");
    $hoja = new hoja;
    
    
    $turno = new turnos;
    ?> 
            
    <div id="der_divizq">
        <table id="t_divizq">
            <tr>
                <td>OPERADOR T. MA&Ntilde;ANA</td>
                <td>
                    <select name="62" id="control62" class="select" onchange="cambia()" >
                        <?php  															                            
                        $resu = $us->obtiene_usuario_nivel(0);
                        echo "<option value=''>Sel. Operador</option>";
                        while($user = mysql_fetch_array($resu)){
                            echo "<option value='".$user[6]."'>".$user[6]."</option>";
                        }                                                         
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td>                 
                 <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_operador(62)" alt="Remover Usuario"/></a></td>           
            </tr>
            <tr>
                <td>OPERADOR T. TARDE</td>
                <td>
                    <select name="63" id="control63" class="select" >
                        <?php  															                            
                        $resu = $us->obtiene_usuario_nivel(0);
                        echo "<option value=''>Sel. Operador</option>";
                        while($user = mysql_fetch_array($resu)){                            
                            echo "<option value='".$user[6]."'>".$user[6]."</option>";                            							        
                        }                                                                
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td>  
                <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_operador(63)" alt="Remover Usuario"/></a></td>  
            </tr>
            <tr>
                <td>OPERADOR T NOCHE</td>
                <td>
                    <select name="64" id="control64" class="select">
                        <?php  															                            
                        $resu = $us->obtiene_usuario_nivel(0);
                        echo "<option value=''>Sel. Operador</option>";
                        while($user = mysql_fetch_array($resu)){                            
                            echo "<option value='".$user[6]."'>".$user[6]."</option>";                            							        
                        }                                                                
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td> 
                <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_operador(64)" alt="Remover Usuario"/></a></td> 
            </tr>
            <tr>
                <td>SUPERVISOR T. MA&Ntilde;ANA</td>
                <td>
                    <select name="65" id="control65" class="select">
                        <?php  															                            
                        $resu = $us->obtiene_usuario_nivel(3);
                        echo "<option value=''>Sel. Supervisor</option>";
                        while($user = mysql_fetch_array($resu)){                            
                            echo "<option value='".$user[6]."'>".$user[6]."</option>";                            							        
                        }                                                                
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td>
                <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_operador(65)" alt="Remover Usuario"/></a></td>  
            </tr>
            <tr>
                <td>SUPERVISOR T NOCHE</td>
                <td>
                    <select name="66" id="control66" class="select">
                        <?php  															                            
                        $resu = $us->obtiene_usuario_nivel(3);
                        echo "<option value=''>Sel. Supervisor</option>";
                        while($user = mysql_fetch_array($resu)){                            
                            echo "<option value='".$user[6]."'>".$user[6]."</option>";                            							        
                        }                                                                
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td>
                <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_operador(66)" alt="Remover Usuario"/></a></td>   
            </tr>
        </table>
    </div>        
    
    
    
    <div id="der_divder">
        <table id="t_divder">
            <tr>
                <td>TEMP. RACK MA&Ntilde;ANA</td>
                <td>
                    <select name="67" id="control67" class="select">
                                                     						
                    </select>
                </td>    
            </tr>
            <tr>
                <td>TEMP. RACK TARDE</td>
                <td>
                    <select name="68" id="control68" class="select">
                        
                                                                      						
                    </select>
                </td>    
            </tr>
            <tr>
                <td>TEMP. RACK NOCHE</td>
                <td>
                    <select name="69" id="control69" class="select">
                        
                                                                      						
                    </select>
                </td>    
            </tr>
            <tr>                
                <td>H. MONIT M.</td>                   
                <td><input name="checkbox70" type="checkbox" value="70" id="checkbox70" class="check"/></td>
                <td><input name="hora70" type="text" id="hora70" readonly="true" size="6" onclick="muestra_caja(70)"/></td>
                <input name="id70" type="hidden" id="id70" readonly="true" size="3" hidden="true"/>
            </tr>
            <tr>
                <td>H. MONIT T.</td>
                <td><input name="checkbox71" type="checkbox" value="71" id="checkbox71" class="check"/></td>
                <td><input name="hora71" type="text" id="hora71" readonly="true" size="6" onclick="muestra_caja(71)"/></td>
                <input name="id71" type="hidden" id="id71" readonly="true" size="3" hidden="true"/>
            </tr>
            <tr>
                <td>H. MONIT N.</td>
                <td><input name="checkbox72" type="checkbox" value="72" id="checkbox72" class="check"/></td>
                <td><input name="hora72" type="text" id="hora72" readonly="true" size="6" onclick="muestra_caja(72)"/></td>
                <input name="id72" type="hidden" id="id72" readonly="true" size="3" hidden="true"/>
            </tr>
        </table>
    </div>
</div><!-- FIN DIV TABLA DERECHA -->
<!-- 
*****************************************************************************************
MENU QUE CONTIENE: HORA - USUARIO - DIA Y FECHA - BOTON DE CIERRE DE TURNO - VOLVER - 

REFERENCIAS - EXPIRACION DE SESION - NOMBRE DE USUARIO QUE CERRO LA FECHA
*****************************************************************************************
 -->
<div id="menu">
    <table id="t_menu"> 
        <tr><!-- HORA -->
            <td id="reloj"></td>
        </tr> 
        <tr><!-- USUARIO -->
            <td><? echo $_SESSION['usuario'] ?></td>
        </tr>       
        <tr>
         <td><!-- DIA DE LA SEMANA -->
            <?
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                $fch= $_SESSION['fdpsf'];             
                $dia = $dias[date('w',strtotime($fch))];
                echo $dia;              
    	     ?>   
               <!-- FECHA COMPLETA -->
              <? echo $_SESSION['fdp'] ?>         
            </td>
        </tr>
        <tr><!-- BOTON DE CIERRE DE TURNO Y FDP -->
            <td><input type="button" class="button" name="btnturno" id="btnturno" value="Cierre de&#13;&#10;Turno" style='width:95px; height:45px' onclick="cierra_turno()" /></td>            
        </tr>
    <!--    <tr>
            <td><input type="button" class="button" name="btnprint" id="btnprint" value="Imprime" style='width:95px; height:45px' onclick="imprime_turno()" /></td>            
        </tr> -->          
        <tr><!-- VOLVER ATRAS -->
            <td><a href="principal.php?id=hoja_principal" id="volver">VOLVER</a></td>
        </tr>           
    </table>
<script>
//IMPRIME EL CHECK
function imprime_turno(){
    window.print()
}
</script>
</div><!-- FIN DIV MENU -->
<div id="menuII"><!-- REFERENCIAS DE COLORES DE LAS TAREAS -->
    <h3>REFERENCIAS</h3>
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
            <td id="tdc_tabla" style="background-color: lightgoldenrodyellow"></td>
            <td>No se realiza</td>
        </tr> 
        <tr>
            <td id="tdc_tabla" style="background-color: gold"></td>
            <td>No se realiza por...</td>
        </tr>           
    </table>
</div>
<div id='CuentaAtras'></div><!-- TEMPORIZADOR DE EXPIRACION DE SESION -->
<!--<div id="avisos">
   <div id="aviso_title">ALERTAS:</div> -->   
<?/*
if(isset($_GET['aviso'])){
    switch($_GET['aviso']){
        case 1://ERROR EN LA CONEXION
            $aviso = "Fallo en la conexión";
            break;
        case 2://SI SE TRANSFIRIERON CORRECTAMENTE LOS ARCHIVOS, SE GUARDA LA TAREA EN LA BD     
            $aviso = "Los archivos TXT y MD5 fueron enviados por FTP";
            echo "<script type='text/javascript'>  
            var user = document.getElementById('txtuser').value;//nombre de usuario
            var tiempo = new Date();  //obtiene la fecha y hora
            var horas = tiempo.getHours();    //extrae las horas
            var minutos = tiempo.getMinutes();    //extrae los minutos
            var segundos = '00';
            if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
              minutos = '0'+minutos;
            }  
            var hora = horas+':'+minutos+':'+segundos;     //coloca la hora completa en la variable hora
            
            idt=40;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox
            idh=document.getElementById('hoja').value;     //pasa el id de la hoja. La misma se encuentra en la variable de sesion de mismo nombre          
            h=hora; //pasa la hora          
            v='- TAREA 40 REALIZADA - Usuario: '+user;//pasa el usuario que realizo la tarea
            p=1;
            t='ABIERTA';                                  
            $.ajax({url:'insertar.php',cache:false,type:'POST',data:{idt:idt,idh:idh,h:h,v:v,p:p,t:t}});   //Inserta los datos a la bd sin recargar la pagina
                              
            document.getElementById('checkbox40').checked=true;
            document.getElementById('checkbox40').disabled=true;                  
            document.getElementById('hora40').value =hora;        
            document.getElementById('40').style.backgroundColor= 'LightGreen';        
            </script>"; 
                    
            break;
        case 3://NO SE PUDIERON TRANSFERIR LOS ARCHIVOS
            $aviso = "Hubo un problema durante la transferencia de los archivos";
            break;
        case 4://SE SELECCIONARON OTROS ARCHIVOS           
            $aviso = "Los archivos seleccionados no pertenecen a la FDP en curso";
            break;
        case 6://SE SELECCIONARON OTROS ARCHIVOS           
            $aviso = $_GET['fecha'];
            break;
        default:
        $aviso = "";
            break;
        
    }
    unset ($_GET['aviso']);
    echo "<div id='aviso_cont'>".$aviso."</div>";
}*/
?>
<!-- </div> --> 
<div id='div_usercierre'><!-- USUARIO QUE CERRO LA FDP CON FECHA Y HORA -->
    <div id='t_usercierre'></div>
    <div id='usercierre'></div>
    <div id='horacierre'></div>
</div>
<div id="pie">    
    <table id="t_pie">
        <tr>Comentarios:</tr>
        
        <tr>
            <td><input type="text" name="73" id="control73" size="180" class="text"/></td>
            <td><input name="hora73" type="text" id="hora73" readonly="true" size="6" onclick="muestra_caja(73)"/></td>
            <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_comentario(73)" alt="Remover Comentario"/></a></td>
        </tr>
        <tr>
            <td><input type="text" name="74" id="control74" size="180" class="text"/></td>
            <td><input name="hora74" type="text" id="hora74" readonly="true" size="6" onclick="muestra_caja(74)"/></td>
            <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_comentario(74)" alt="Remover Comentario"/></a></td>
        </tr>
        <tr>
            <td><input type="text" name="75" id="control75" size="180" class="text"/></td>
            <td><input name="hora75" type="text" id="hora75" readonly="true" size="6" onclick="muestra_caja(75)"/></td>
            <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_comentario(75)" alt="Remover Comentario"/></a></td>
        </tr>
        <tr>
            <td><input type="text" name="76" id="control76" size="180" class="text"/></td>
            <td><input name="hora76" type="text" id="hora76" readonly="true" size="6" onclick="muestra_caja(76)"/></td>
            <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_comentario(76)" alt="Remover Comentario"/></a></td>
        </tr>
        <tr>
            <td><input type="text" name="77" id="control77" size="180" class="text"/></td>
            <td><input name="hora77" type="text" id="hora77" readonly="true" size="6" onclick="muestra_caja(77)"/></td>
            <td><a href="javascript:void(0);"><img src="imagenes/close.png" width="10" height="10" onclick="borra_comentario(77)" alt="Remover Comentario"/></a></td>
        </tr>              
    </table>
</div>

</div><!-- FIN DIV CONTENEDOR -->
<input name="bandera" type="hidden" id="bandera" value="1" />
<?    
    $id = $_SESSION['id_hoja']; 
    $idus = $_SESSION['id_usuario'];   
    $res = $diario->obtiene_datos_tarea($id); //obtiene tareas guardadas directamente
    $restr = $turno->obtiene_estado_turno($id,$idus);//OBTIENE EL ESTADO DEL TURNO
    //Esto servira por si vuelve la pagina atras al cerrar el turno
    $estado = mysql_fetch_array($restr);    
    if(($estado[0]=='CERRADO') && ($estado[1]=='ABIERTA')){
        //si volvio atras, implica que el turno se cerro y redireccionara a la hoja principal
        echo "<script type='text/javascript'>        
        window.location.href = 'principal.php?id=hoja_principal'
        </script>";        
    }else{
        //$resp = $tarea->obtiene_tareas_pendientes($id);//tareas pendientes
        //$resc = $tarea->obtiene_tareas_completadas($id);//tareas completadas
        //$resb = $tarea->obtiene_tareas_billetes($id);//tareas de billetes
        $nhoja = $hoja->obtiene_datos_segun_hoja($id);
        $nfila = mysql_fetch_array($nhoja);
        //Llena los combos de temperatura
        echo "<script>
            for(var k=67;k<=69;k++){
                var j=0;       
                document.getElementById('control'+k).options[j] = new Option('-Temp-');        
                for(var i=10;i<=40;i+=0.5){
                    j=j+1;
                    document.getElementById('control'+k).options[j] = new Option(i);
                    document.getElementById('control'+k).options[j].value = i;                     
                }
            }
        </script>";
        //-----------------------------------------------------------------------
        //$fila[0] = id tarea
        //$fila[3] = hora
        //$fila[4] = valor o datos adicionales
        while($fila = mysql_fetch_array($res)){//TAREAS GUARDADAS NORMALES (CHECK)
        
            echo "<script type='text/javascript'>     
               
            document.getElementById('checkbox'+".$fila[0].").checked=true;
            document.getElementById('checkbox'+".$fila[0].").disabled=true;                  
            document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';        
            document.getElementById(".$fila[0].").style.backgroundColor= 'LightGreen';        
            </script>";
            
            echo "<script>
            var aSelect = document.getElementById('control'+".$fila[0]."); 
    	    var val_aSelect = aSelect.options[aSelect.selectedIndex].text='".$fila[4]."';
            aSelect.disabled=true;
            </script>";  
            
            //Controla el text de maquinas sin contadores y trae la cantidad de maquinas
            if($fila[0]==35 || $fila[0]==90){
                $expl = explode("-",$fila[4]);            
                echo"<script>
                document.getElementById('control'+".$fila[0].").value ='".$expl[1]."';
                document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';           
                document.getElementById('control'+".$fila[0].").disabled=true;
                document.getElementById(".$fila[0].").style.backgroundColor= 'LightGreen';
                </script>";
            }else{
                echo"<script>
                document.getElementById('control'+".$fila[0].").value ='".$fila[4]."';
                document.getElementById('hora'+".$fila[0].").value ='".$fila[3]."';           
                document.getElementById('control'+".$fila[0].").disabled=true;
                </script>";
            }
               
        }
        //formatea las tareas. Trae las tareas checkeadas de la BD y las colorea
        $rest = $diario->obtiene_tareas($id); 
        while($filat = mysql_fetch_array($rest)){      
          switch($filat['estado']){
                case 5://TAREAS QUE NO SE REALIZAN
                    echo "<script type='text/javascript'>
                    document.getElementById('hora'+".$filat['id_tarea'].").value = '".$filat['hora']."';
                    document.getElementById(".$filat['id_tarea'].").style.backgroundColor= 'lightgoldenrodyellow';                
                    </script>";
                    break;
                case 4://TAREAS DE BILLETES
                    echo "<script type='text/javascript'>
                    document.getElementById('hora'+".$filat['id_tarea'].").value = '".$filat['hora']."';
                    document.getElementById(".$filat['id_tarea'].").style.backgroundColor= 'LightGreen';                
                    </script>";
                    break;
                case 2://TAREAS PENDIENTES
                    echo "<script type='text/javascript'>
                    document.getElementById(".$filat['id_tarea'].").style.backgroundColor= '#ff5c54';
                    document.getElementById('hora'+".$filat['id_tarea'].").value = '';                
                    </script>";
                    break;
                case 3://TAREAS COMPLETADAS
                    echo "<script type='text/javascript'>
                    document.getElementById(".$filat['id_tarea'].").style.backgroundColor= 'LightSkyBlue';
                    document.getElementById('hora'+".$filat['id_tarea'].").value = '".$filat['hora']."';                
                    </script>";
                    break; 
                case 6://TAREAS QUE NO SE REALIZAN CON JUSTIFICACION
                    echo "<script type='text/javascript'>
                    document.getElementById(".$filat['id_tarea'].").style.backgroundColor= 'gold';
                    document.getElementById('hora'+".$filat['id_tarea'].").value = '".$filat['hora']."';                
                    </script>";
                    break; 
            }        
            echo "<script type='text/javascript'>        
            document.getElementById('checkbox'+".$filat['id_tarea'].").checked=true;
            document.getElementById('checkbox'+".$filat['id_tarea'].").disabled=true;  
            </script>";        
            
        }   
        if($nfila[2]=='CERRADA'){
           echo "<script>            
                document.getElementById('btnturno').disabled=true;
                document.getElementById('t_usercierre').innerHTML = 'USUARIO QUE CERRO LA FDP';
                document.getElementById('control73').disabled=true;
                document.getElementById('control74').disabled=true;
                document.getElementById('control75').disabled=true;
                document.getElementById('control76').disabled=true;
                document.getElementById('control77').disabled=true;
            </script>"; 
            if($nfila[6]=="AUTOMATICO"){
                echo "<script>
                document.getElementById('usercierre').innerHTML = '".$nfila[6]."';
                document.getElementById('horacierre').innerHTML = '".$nfila[4]."';
                </script>"; 
            }else{
                echo "<script>
                document.getElementById('usercierre').innerHTML = '".$nfila[6]." ".$nfila[7]."';
                document.getElementById('horacierre').innerHTML = '".$nfila[4]."';
                </script>"; 
            }
        }
    }//FIN $estado=='CERRADO'  
   
?>

</form>

</body>
</html>