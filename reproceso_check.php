<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reproceso de Fechas</title>
<link rel="stylesheet" href="estilos/jquery.contextMenu.css" />
<script src="jquery.js"></script>
<script src="jquery-1.7.2.min.js"></script>
<script src="js/jquery.contextMenu.js"></script>
<script src="js/jquery.ui.position.js"></script>

<script type="text/javascript">
   
      //Todos los objetos con la propiedad CLASS="check", realizaran esta funcion.
    //guarda las tareas que poseen checkbox. Guarda la hora, el usuario, el estado
    
 $(document).ready(function(){
    
        var id_user = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
        document.getElementById('user').value = id_user;
        $(".check").click(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas check
              ctrlfdp = $( "#fdp" ).attr("value");
              var id = $(this).attr("value"); // Le pasa el valor del checkbox TAREA      
              if( ctrlfdp != ""){   
                
                  var resp = confirm("Desea guardar la tarea "+id+" ?");
                  if (resp == true) {
                      if($( "#fdp" ).attr("disabled",false)){
                            $( "#fdp" ).attr("disabled",true);
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
                      idu=id_user;
                      var idt=id;   //obtiene el ID de la tarea. La misma viene del VALUE del checkbox
                      //var e='ABIERTA';//ESTADO
                      var fdp = fechabd();//fecha de produccion
                      var h=hora; //pasa la hora
                      $.ajax({url:"inserta_rep.php?val=0",cache:false,type:"POST",data:{idt:idt,idu:idu,fdp:fdp,e:0,h:h,v:0,ids:0}});   //Inserta los datos a la bd sin recargar la pagina
                      
                      //seconds_left = seconds_left*60;
                      $("#checkbox"+id).attr("disabled", true); //deshabilita el checkbox                   
                      $('#'+id).css("background-color", "LightGreen");
                      envio_mail(id);
                      //llama a la funcion envia_mail(id). Abrira el correo con plantillas predeterminadas                             
                      //envio_mail(id);                                           
                  }else{    //resp == FALSE      
                      $("#checkbox"+id).attr("checked", false); //deshabilita el checkbox */
                  }
              }else{
                alert('Debe seleccionar una Fecha de Produccion');
                $("#checkbox"+id).attr("checked", false); //deshabilita el checkbox 
              }
        });
     
     //--------------------------------------------------------------------------------------------------------
//Todos los objetos con la propiedad CLASS="text", realizaran esta funcion.
//Se guardan los datos que se cargan en input type TEXT
    $(".text").change(function(){ // Obtiene todos los objetos con la propiedad CLASS llamadas text
            
          var id = $(this).attr("name"); // Le pasa el name del text
          //id 35 es el text de cantidad de maquinas sin contadores         
                      
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
          var idu=id_user; //id de usuario
          var v = document.getElementById('control6').value; //text de comentarios                  
          var h=hora; //pasa la hora
          var fdp = fechabd();//fecha de produccion
                    
          $.ajax({url:"inserta_rep.php?val=0",cache:false,type:"POST",data:{idt:idt,idu:idu,fdp:fdp,e:0,h:h,v:v,ids:0}});   //Inserta los datos a la bd sin recargar la pagina
          alert('Comentario Guardado');
         
          $("#control"+id).attr("disabled", true); //deshabilita el checkbox
          seconds_left = <? echo $_SESSION['limite'];?>;//al guardar se resetea el tiempo de expiracion
          seconds_left = seconds_left*60;
    });     
    
});    
function fechabd(){    
    fecha = document.getElementById('fdp').value;   
    fechax = fecha.split('/');    
    fechaform = fechax[2]+'-'+fechax[1]+'-'+fechax[0];   
    return fechaform;    
}
function envia_cierre(){
    var cantEle = document.getElementById("form1").elements.length;
    var j=0; 
    for(var i=0;i < cantEle;i++){
        if (document.getElementById("form1").elements[i].type=='checkbox'){
            if (document.getElementById("form1").elements[i].checked){           
                j +=1;
            }
        } 
    }
    if(j==5){  
        var id_user = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
        var idu=id_user;
        var idt = 7; // Le pasa el name del text
        var fecha = document.getElementById('fdp').value;
        var resp = confirm("Las tareas se encuentran completadas. Desea cerrar el reproceso?");
        if (resp == true) {   
            var e = "PENDIENTE";
            var fdp = fechabd();
            var v = document.getElementById('control6').value;
            
            if(v==""){
                v="-";               
                $.ajax({url:"inserta_rep.php?val=0",cache:false,type:"POST",data:{idt:idt,idu:idu,fdp:fdp,e:0,h:0,v:v,ids:0}});   //Inserta los datos a la bd sin recargar la pagina
            }
            $.ajax({url:"inserta_rep.php?val=3",cache:false,type:"POST",data:{e:e,fdp:fdp}});
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Fecha Reprocesada - FDP  dd/mm  CASINO:&body=Fecha reprocesada","_blank");            
            window.location.href = 'principal.php?id=reproceso&guardo=true&fecha='+fecha;
        }  
           // document.getElementById("boton").style.visibility = "hidden";
    }else{
        alert("Existen tareas sin completar");
    }
    
}
function envio_mail(id){   
    var enlace="";
    switch(parseInt(id)){        
        case 1://Autorizacion de reproceso de fechas
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Autorizacion modificacion de FDP dd/mm/AAAA&body=Sres. %0A%0A Se solicita autorizacion para modificacion de FDP: dd/mm/AAAA %0A%0A SALA: %0A%0A Slot afectado en la modificacion: %0A%0A Detalles de la modificacion:","_blank");            
            break;
        case 3://Envio de archivos a Computos IPLYC
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=dipaunor@loteria.gba.gov.ar;estebces@loteria.gba.gov.ar;recioadr@loteria.gba.gov.ar;gaggiand@loteria.gba.gov.ar;toffedan@loteria.gba.gov.ar;luaceseb@loteria.gba.gov.ar;maldoemi@loteria.gba.gov.ar;vecchgon@loteria.gba.gov.ar;panefra@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Actualizacion FTP&body=Se copio en FTP, en fecha   /  /   , el archivo:","_blank");           
            break;
        case 4://envio BIBO
            window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=gamadori@boldt.com.ar;jMamczak@boldt.com.ar;procesosbi@boldt.com.ar;gcastell@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=BIBO - CORECENTRAL - FDP: "+mailfdp+" &body=%0A ENVIADO!!!","_blank");         
            break;
    }
}
//----------------------------------------------------------------------------------------------------
//Menu contextual para dejar tareas pendientes
$(function(){       
        $.contextMenu({           
                selector: '.tarea', 
                items: {
                    "ELIMINAR":{name: "Eliminar Tarea", icon: "delete", callback: function(){//ELIMINA LA TAREA
                        var idt = $(this).attr("id");//id tarea                        
                        var obj = document.getElementById(idt).style.backgroundColor;                          
                        var id_user = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
                        var idu=id_user;
                        var h=obtiene_hora(); 
                        fdp=obtiene_fecha();                        
                        v=idt+"-"+document.getElementById(idt).innerHTML;                        
                        se="ELIMINADO";
                        if(obj==''){
                            alert('Imposible eliminar. La tarea no se encuentra realizada');
                        }else{
                            var resp = confirm("Desea eliminar la tarea "+idt+" ?");
                            if (resp == true) {
                               $.ajax({url:"inserta_rep.php?val=8",cache:false,type:"POST",data:{idt:idt,idu:0,h:0,fdp:fdp,v:0,e:0,ids:0}});   //Elimina la tarea
                               //$.ajax({url:"inserta_rep.php?val=9",cache:false,type:"POST",data:{idt:0,ids:0,idu:idu,h:h,v:v,e:e}});   //guarda el log
                                $('#checkbox'+idt).attr('checked', false);//destilda
                                $("#checkbox"+idt).attr("disabled", false); //habilita el checkbox                                 
                                $("#hora"+idt).attr("value","");//elimina la hora
                                $('#'+idt).css("background-color", ""); //elimina el color
                            }
                        }
                      }
                    },//FIN ELIMINAR
                    sep1: "---------",
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
function obtiene_hora(){
    var tiempo = new Date();  //obtiene la fecha y hora
    var horas = tiempo.getHours();    //extrae las horas
    var minutos = tiempo.getMinutes();    //extrae los minutos 
    if (horas<=9){  //si los minutos poseen un digito, les coloca 0 adelante
      horas = '0'+horas;
    }   
    if (minutos<=9){  //si los minutos poseen un digito, les coloca 0 adelante
      minutos = '0'+minutos;
    }  
    var h = horas+':'+minutos;     //coloca la hora completa en la variable hora
    return h;
}
function obtiene_fecha(){
    var fdp = document.getElementById('fdp').value;    
    var fch = fdp.split('/');     
    return fch[2]+'-'+fch[1]+'-'+fch[0];
}
</script>
 <style>
    #r_titulo{
        margin: 25px 1px 1px 1px;        
        font-weight: bold;
        font-size: 20px;
        text-decoration: underline;
    }   
   
    #boton{
        float: left;
    }
    #t_tareas{
        text-align: left;
        margin: 5px 0 0 400px;
        
    }
    #t_tareas td{
        border: green 1px solid;
    }
    #t_fdp{
        margin: 15px 1px 15px 550px;/*FIREFOX*/
    }  
    #t_botones{
        margin: 5px 0 0 500px;/*firefox*/        
    }
    #t_botones td{        
        padding: 0 100px 0 0;
    }    
    #t_pie{
        margin: 5px 0 0 150px;
    }
    #fr{
        font-size: 10px;
    }
    #ur{
        margin: 10px 0 10px 0;
        font-size: 10px;
    }
    #es{
        margin: 10px 0 0 0;
        font-size: 10px;
        color: red;
    }
    #su{
       margin: 10px 0 0 0;
        font-size: 10px; 
    }
 </style>
</head>

<body>

<div id="r_titulo">REPROCESO DE FECHAS - MDPCORE -</div>
<form id="form1" name="form1" method="post" action="">
<table id="t_fdp">
    <tr>
        <td id="td_fdp">FDP:</td>
        <? 
         include("clases/c_diario.php");
         $diario = new diario;   
        
        if(isset($_GET['fdp'])){//
        
            echo "<td><input type='text' id='fdp' name='fdp' size='10' value='". $_GET['fdp'] ."' disabled/></td>";
            list($dia, $mes, $año) = explode("/",$_GET['fdp']);
            $fecha = $año."-".$mes."-".$dia;    
            $diario->fdp = $fecha;   
            $resp = $diario->obtiene_reproceso_x_fdp();
            $filar = mysql_fetch_array($resp);
            
            echo "<div id='ur'>USUARIO: ".$filar[1]."</div>";
            echo "<div id='fr'>FECHA DE REPROCESO: ".$filar[0]."</div>";
            echo "<div id='es'>ESTADO: ".$filar[2]."</div>";
            echo "<div id='su'>SUPERVISOR: ".$filar[3]."</div>";
            
        }    
        ?>
    </tr>
</table>                       
</table> 
<div id="pie">    
    <table id="t_pie">
        <tr>Informar motivos del reproceso:</tr>
        <tr>
            <td><input type="text" name="6" id="control6" size="120" class="text"/></td>           
            <td><input name="hora6" type="text" id="hora6" readonly="true" size="7"/></td>
           
        </tr>        
    </table>
</div>

    <table id="t_tareas">
        <tr>
        	<td>1</td>
        	<td id="1" class="tarea" onclick="muestra_caja(1)">Solicitar autorizacion para reproceso --------- EMAIL</td>
            <td><input name="checkbox1" type="checkbox" value="1" id="checkbox1" class="check"/></td>
            <td><input name="hora1" type="text" id="hora1" readonly="true" size="7"/></td> 
                   
        </tr>
        <tr>
        	<td>2</td>
        	<td id="2" class="tarea" onclick="muestra_caja(2)">Controlar y Completar Informe Diario</td>
            <td><input name="checkbox2" type="checkbox" value="2" id="checkbox2" class="check"/></td>
            <td><input name="hora2" type="text" id="hora2" readonly="true" size="7"/></td> 
                   
        </tr>
        <tr>
        	<td>3</td>
        	<td id="3" class="tarea" onclick="muestra_caja(3)">Envio de Archivos Finales MD5 a IPLyC --------- EMAIL</td>
            <td><input name="checkbox3" type="checkbox" value="3" id="checkbox3" class="check"/></td>
            <td><input name="hora3" type="text" id="hora3" readonly="true" size="7"/></td> 
                   
        </tr>
 <!--       <tr>
        	<td>4</td>
        	<td id="4" class="tarea" onclick="muestra_caja(4)">BIBO - Exportacion, envio por FTP, Mail a:Mamczak - Mendoza</td>
            <td><input name="checkbox4" type="checkbox" value="4" id="checkbox4" class="check"/></td>
            <td><input name="hora4" type="text" id="hora4" readonly="true" size="7"/></td> 
                   
        </tr> -->
        <tr>
        	<td>5</td>
        	<td id="5" class="tarea" onclick="muestra_caja(5)">Carga y Control de Tablero.</td>
            <td><input name="checkbox5" type="checkbox" value="5" id="checkbox5" class="check"/></td>
            <td><input name="hora5" type="text" id="hora5" readonly="true" size="7"/></td> 
                   
        </tr>
        
        
    </table>


<table id="t_botones">
    <tr>
        <td></td>
        <? if(isset($_GET['ver'])){
                if($_GET['ver']=='true'){
                    //echo "<td><input type='button' id='boton' value='Cerrar' onclick='envia_cierre()'/></td>";
                    
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
</form>
</body>
<?
//trae de la bd las tareas guardadas para rellenar el check
   
    list($dia, $mes, $año) = explode("/",$_GET['fdp']);
    $fecha = $año."-".$mes."-".$dia;    
    $diario->fdp = $fecha;
    $res = $diario->obtiene_reproceso_tareas_x_fdp();
    while($fila = mysql_fetch_array($res)){
        echo "<script type='text/javascript'>        
                document.getElementById('checkbox'+".$fila[1].").checked=true;
                document.getElementById('checkbox'+".$fila[1].").disabled=true;                  
                document.getElementById('hora'+".$fila[1].").value ='".$fila[4]."';               
                document.getElementById(".$fila[1].").style.backgroundColor= 'LightGreen';  
                  
            </script>";        
        echo "<script type='text/javascript'>
                document.getElementById('control'+".$fila[1].").value ='".$fila[5]."';
                document.getElementById('hora'+".$fila[1].").value ='".$fila[4]."';           
                document.getElementById('control'+".$fila[1].").disabled=true;
            </script>";
    }
        
?>
</html>