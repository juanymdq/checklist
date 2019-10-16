<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reproceso de Fechas</title>
<link type="text/css" href="estilos/ui.all.css" rel="stylesheet" />
<link type="text/css" href="estilos/ui.datepicker.css" rel="stylesheet" />
<link type="text/css" href="estilos/jquery-ui.css" rel="stylesheet" />

<script src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>    
<script src="js/jquery.ui.position.js"></script>    
<script type="text/javascript">       
	  $(function() {	  
        $( "#fecha" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });   
      $(document).ready(function(){
        var fecha = new Date();
         $( "#fechaHora" ).val(fecha);   
      });
            
       
        function fechabd(){    
            fecha = document.getElementById('fecha').value;   
            fechax = fecha.split('/');    
            fechaform = fechax[2]+'-'+fechax[1]+'-'+fechax[0];   
            return fechaform;    
        }
        function fechabd_mov(fch){
            fecha = fch;
            fechax = fecha.split('/');    
            fechaform = fechax[2]+'-'+fechax[1]+'-'+fechax[0];   
            return fechaform;
        }
        function obtiene_fecha_actual(){    
            var d = new Date();    
            mes = d.getMonth()+1;
            dia = d.getDate();                
            if(dia<10){
                dia = '0'+dia;        
            }
            if(mes<10){
                mes = '0'+mes;
            }            
            return(d.getFullYear()+'-'+mes+'-'+dia);
        }
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
        function valida_campos(ctrl){
            var fecha = document.getElementById('fecha').value;
            var area =  document.getElementById('area').value;           
            var desc = document.getElementById('desc').value;   
            var est = document.getElementById('estado').innerHTML;
            var idmov = document.getElementById('id_mov').value;            
            if(ctrl==1){//1 implica que esta guardado el movimiento pero puede no estar completo
                window.location.href = 'check_maquinas.php?idmov='+idmov+'&fecha='+fecha+'&estado='+est;
            }else{               
               if(fecha == ''){
                    alert('Fecha no puede ser vacio');
               }else if(area == ''){
                    alert('Debe seleccionar un area');            
                }else if(desc == ''){
                    alert('Descripcion no puede ser vacio');
                }else{
                    var resp = confirm("Se guardara el movimiento con fecha: "+fecha+" ?");
                    if (resp == true) {  
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario                          
                        var ida = area;//id del area                        
                        var fmov = fechabd();//variable fdp formateada para bd mysql                       
                        var d = desc //descripcion del movimiento 
                        var fact = obtiene_fecha_actual();//variable fecha y hora actual                     
                        var h = obtiene_hora(); //hora actual
                        var e = 'SIN COMPLETAR';
                        //*******pasa la descripcion del area****************
                        var aSelect = document.getElementById('area'); 
                        var g = aSelect.options[aSelect.selectedIndex].text;
                        //***************************************************                                          
                        //guarda los datos
                        $.ajax({url:"inserta_mov.php?val=1",cache:false,type:"POST",data:{idu:idu,ida:ida,fmov:fmov,d:d,fact:fact,h:h,e:e,g:g,idt:0}});   //Inserta los datos a la bd sin recargar la pagina                        
                        alert('Se guardo el movimiento con fecha: '+fecha);                                              
                        var a = $("#area option:selected").html();                        
                        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=MOVIMIENTO DE MAQUINAS INICIADO - "+a+" - FECHA: "+fecha+"&body= EL MOVIMIENTO DE FECHA: "+fecha+" SE HA INICIADO%0A%0ADESCRIPCION: "+d,"_blank");                        
                        var u = '<? echo $_SESSION['usuario']; ?>';
                        var f = fecha;//FECHA DEL MOVIMIENTO
                        var ar = a;//DESCRIPCION DEL AREA
                        var ap = u+' - '+fact+ ' '+h;//FECHA ACTUAL MAS HORA
                        var d = desc; //DESCRIPCION DEL MOVIMIENTO                        
                        //window.open('pdf_mov_maquinas.php?f='+f+'&ar='+ar+'&ap='+ap+'&d='+d,'_blank');                                              
                        var idmov = obtiene_id();//ID DEL MOVIMIENTO GUARDADO RECIENTEMENTE                                             
                        //window.location.href = 'check_maquinas.php?idmov='+idmov;                        
                        window.location.href = 'check_maquinas.php?idmov='+idmov;
                    }
                }
            }
        }          
        //obtiene el ultimo ID ingresado
        function obtiene_id(){            
            var coment = $.ajax({
                url:"inserta_mov.php?val=7",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",
                data:{idt:0,idu:0,ida:0,fmov:0,d:0,fact:0,h:0,e:0,g:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto            
            return coment;
        } 
        //funcion que trae los movimientos para una fecha en particular
        function trae_areas(){             
        	document.getElementById('fcmov').options.length = 0;	
            var xfch = fechabd();           
        	var num_mov = document.getElementById('selmov').length;	
        	var objOption = document.getElementById('fcmov');		
        	var x=1;
            objOption.options[0] = new Option('Nuevo Movimiento');
        	for(var i=0; i<num_mov; i++){		
        		if(xfch== document.form1.selmov.options[i].value){
        			objOption.options[x] = new Option(document.form1.selmov.options[i].text);
        			x++;
        		}		
        	}
            var aSelect = document.getElementById('fcmov'); 
            var ida = aSelect.options[aSelect.selectedIndex].text;
            if(ida=='Nuevo Movimiento'){
                var aSelect = document.getElementById('area');        	    
                aSelect.disabled=false;
                var val_aSelect = aSelect.options[aSelect.selectedIndex].text= 'Seleccionar Area';
                document.getElementById('desc').value = "";
                document.getElementById('desc').disabled = false;
                document.getElementById('estado').innerHTML = "";
                document.getElementById('userc').innerHTML = "";                   
                document.getElementById('fchcierre').innerHTML = "";
                document.getElementById('user').innerHTML = "";
                document.getElementById('f_act').innerHTML = "";
                document.getElementById('hora').innerHTML = "";
                document.getElementById('boton').innerHTML = '<input type="button" id="boton" value="Guardar y Acceder" onclick="valida_campos(0)"/>'; 
            }
                  
        }
        //cuando se selecciona mediante el select algun movimiento cerrado
        function sel_movimientos_cerrados(){
            var aSelect = document.getElementById('chkcerrados'); 
            var ida = aSelect.options[aSelect.selectedIndex].text;//Obtiene el texto del select
            var valfecha = ida.substring(0,10);//obtiene fecha
            document. getElementById('fecha').value = valfecha;//coloca la fecha del movimiento en campo fecha
            document.getElementById('fecha').disabled = true;//deshabilita el campo fecha
            var cant = ida.length; //obtiene la cantidad de caracteres del texto del select
            var valmov = aSelect.options[aSelect.selectedIndex].value;//OBTIENE ID DEL MOVIMIENTO
            document.getElementById('id_mov').value = valmov; //coloca el ID del movimiento en un campo oculto
            var valarea = ida.substring(11,cant);//obtiene area                   
            var valfecha = fechabd_mov(valfecha);   //caoloca en variable la fecha estilo BD MYSQL (AAAA-mm-dd)                  
            verifica_fecha(valmov,valarea,valfecha); //llama a funcion verificar fecha
        }       
        //cuando se selecciona fecha con el calendario
        function sel_fecha_pendientes(){
            var aSelect = document.getElementById('fcmov'); 
            var ida = aSelect.options[aSelect.selectedIndex].text;           
            var fmov = fechabd();
            verifica_fecha(ida,fmov);     
        }
        //cuando se selecciona el link a algun movimiento pendiente
        function sel_movimientos_pendientes(){
            var val='';
            val = document.getElementById('pend');            
            val = val.innerHTML;  
            alert(val);          
            var valfecha = val.substring(0,10);//obtiene fecha
            document.getElementById('fecha').value = valfecha;            
            var cant = val.length;                        
            var valarea = val.substring(11,cant);//obtiene area                               
            //var valfecha = fechabd_mov(valfecha);
            verifica_fecha(valarea,valfecha);
        }
        
        function verifica_fecha(idmov,area,fecha){          
            var idt = idmov;
            var ida = area;
            var fmov = fecha;     
            $('#aviso').html(" ");
            // FUNCION AJAX PARA TRAER LOS DATOS DEL MOVIMIENTO SELECCIONADO
            var coment = $.ajax({
                url:"inserta_mov.php?val=0",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",
                data:{idt:idt} //PASA EL ID DEL MOVIMIENTO               
            }).responseText;  //ejecuta la consulta y devuelve formato texto                 
            if(coment == ";;;;;;;;;"){//SI DEVUELVE VACIO 
                    //tarea no realizada                    
                    var aSelect = document.getElementById('area');        	    
                    aSelect.disabled=false;
                    var val_aSelect = aSelect.options[aSelect.selectedIndex].text= 'Seleccionar Area';
                    document.getElementById('desc').value = "";
                    document.getElementById('desc').disabled = false;
                    document.getElementById('estado').innerHTML = "";
                    document.getElementById('userc').innerHTML = "";                   
                    document.getElementById('fchcierre').innerHTML = "";
                    document.getElementById('user').innerHTML = "";
                    document.getElementById('f_act').innerHTML = "";
                    document.getElementById('hora').innerHTML = "";
                    document.getElementById('boton').innerHTML = '<input type="button" id="boton" value="Guardar y Acceder" onclick="valida_campos(0)"/>';
                    return false;
            }else{                 
                //en coment los datos vienen de la siguiente manera:
                //         0         1      2           3                  4         5        6         7           8
                //ej: 2016-09-11 ; prueba ; 4 ; Casino Hotel SASSO ; fecha actual ; hora ; usuario ; estado ; fecha de cierre
                var datos = coment.split(';');//separo el text por ";"
                //coloco el area en el select y deshabilito el combo
                var aSelect = document.getElementById('area'); 
        	    var val_aSelect = aSelect.options[aSelect.selectedIndex].text= datos[3];                
                aSelect.disabled=true;
                //coloco la descripcion del movimiento y deshabilito el text
                document.getElementById('desc').value = datos[1];
                document.getElementById('desc').disabled = true;
                document.getElementById('estado').innerHTML = datos[7];//estado del movimiento
                document.getElementById('userc').innerHTML = '<div id="userc">Usuario que cerro: <b><font size="2" color="salmon">'+datos[9]+'</font></b></div>';//usuario que cerro
                if(datos[8]=='0000-00-00 00:00:00'){
                    document.getElementById('userc').innerHTML = '';
                    document.getElementById('fchcierre').innerHTML = '';
                }else{
                    //fecha de cierre de movimiento
                    //        [0]   [1]       [2]
                    //tfch =  año   mes     dia hora
                    var tfch =datos[8].split('-');//tfch[0]= año - tefch[0] = dia - tfch[1]= mes
                    //        [0]     [1]
                    //tefch = dia    hora 
                    var tefch = tfch[2].split(' ');                                        
                    var fch = tefch[0]+'/'+tfch[1]+'/'+tfch[0]+' '+tefch[1];
                   
                    document.getElementById('fchcierre').innerHTML = '<div id="fchcierre">Fecha de cierre: <b><font size="2" color="salmon">'+fch+'</font></b></div>';//fecha de cierre
                }
                document.getElementById('user').innerHTML = '<div id="user">'+datos[6]+'</div>';//usuario que guardo
                document.getElementById('f_act').innerHTML = '<div id="f_act">'+datos[4]+'</div>';//fecha actual
                document.getElementById('hora').innerHTML = '<div id="hora">'+datos[5]+'</div>';//hora
                //en onclick se envia un 1 para controlar si la fecha ya estaba guardada o no             
                document.getElementById('boton').innerHTML = '<input type="button" id="boton" value="Acceder" onclick="valida_campos(1)"/>';            
            }
        }
        //FUNCION PARA LIMITAR EL INGRESO DE CARACTERES AL CAMPO DESCRIPCION DEL MOVIMIENTO
        function Numeros(string){//solo letras y numeros
            var out = '';
            //Se añaden las letras validas
            var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890- ';//Caracteres validos        	
            for (var i=0; i<string.length; i++)
               if (filtro.indexOf(string.charAt(i)) != -1) 
        	     out += string.charAt(i);
            return out;
        }
</script>
 <style>
    #cont{
        float: left;
        width: 600px;
        height: 400px;
        border: green 1px solid;
        margin: 10px 0 0 70px;
    }
    /*****Estado del movimiento*****/
    #estados{
        float: left;
        border: green 1px solid;
        margin: 10px 0 0 5px;
        width: 450px;
        height: 150px;
        padding-top: 1px;
    }
    #t_estados{
        font-size: 16px;
        font-weight: bold;
        font: 10px;
        color: navy;
        text-decoration: underline;
    }
    #estado{        
        font-weight: bold;
        font-size: 14px;        
        color: teal;
    }
    #userc{        
        font-weight: bold;
        margin-top: 5px;
        margin-left: 5px;
        text-align: left;
    }   
    #fchcierre{        
        font-weight: bold;
        margin-top: 5px;
        margin-left: 5px;
        text-align: left;       
   }
    /**************************/
    /***movimientos pendientes*/
    #mov_iniciados{
        float: left;
        border: green 1px solid;
        margin: 5px 0 0 5px;
        width: 450px;
        height: 120px;
    }
    #t_movini{
        font-size: 16px;
        font-weight: bold;
        font: 10px;
        color: navy;
        text-decoration: underline;
        margin: 0 50px 0 0;
        
    }
    #cont_movini{        
         width: 440px;
         height: 90px;
         overflow-y: scroll;
         overflow-x: hidden;
         text-align: left;
         margin-top: 3px;
    }
    #pend{
        width: 275px;
        float: left;
        margin: 0 0 0 15px;
        
        
    }
    #linkpend{
        float: left;
        margin: 0 0 0 3px;
        
    }
    /****************************/
    /******BUSCAR CHECK CERRADOS******/
    #b_checkcerrados{
        float: left;
        border: green 1px solid;
        margin: 5px 0 0 5px;
        width: 450px;
        height: 120px;
    }
    #t_checkcerrados{
        font-size: 16px;
        font-weight: bold;
        font: 10px;
        color: navy;
        text-decoration: underline;  
              
    }
    #select_movcerrados{
        margin: 15px 0 0 0;
        
    }
    
    /**********************************/
    /*TITULO DEL REPORTE*/
    #r_titulo{
        margin: 30px 1px 1px 1px;        
        font-weight: bold;
        font-size: 16px;
        text-decoration: underline;
    } 
    /***********************************/
    #boton{
        margin: 20px 0 0 15px;
    }
    #tabla{
        margin: 10px 1px 1px 1px;        
    }
    #tabla tr{
        margin: 5px 0px 0px 0px;        
    }
    #td_fdp1{
        text-align: right;
    }
    #td_fdp2{
        text-align: left;
    }
    #td_a1{
        text-align: right;
        padding: 20px 0 20px 0;
    }
    #td_a2{
         text-align: left;
        padding: 20px 0 20px 0;
    }
    #td_d1{
        text-align: right;
    }
    #td_d2{
        text-align: left;
    }
    #aviso{
        
        margin: 25px 0 0 0;
        font-weight: bold;
        color: red;
    }
    /*-------DIV QUE INFORMA EL USUARIO QUE GUARDO EL MOVIMIENTO MAS FECHA Y HORA*/
    #encabezado{
       border: green 1px solid;
       width: 350px;
       height: 20px;
       margin: 10px 0 0 200px;
    }
    #encusap{
        font-weight: bold;
        margin: 10px 0 0 0;
    }
    #guardado{
        border: green 1px solid;
       width: 350px;
       height: 20px;
       margin: 5px 0 0 200px;
    }
    #user{float: left; width: 100px;}
    #f_act{float: left; width: 100px;}
    #hora{float: left; width: 100px;}
    #tuser{float: left; width: 100px;}
    #tf_act{float: left; width: 100px;}
    #thora{float: left; width: 100px;}
    
    /*-----------------------------------------------------------*/
 </style>
</head>
<?
include('clases/c_area.php');
include('clases/c_diario.php');
$area = new area;
$diario = new diario;
?>
<body>

<div id="cont">
    <div id="r_titulo">MOVIMIENTOS DE MAQUINAS</div>
   
    <form id="form1" name="form1" method="post" >
        <div>
            <table id="tabla">
                <tr>
                    <td id="td_fdp1">Seleccionar fecha:</td>
                    <td id="td_fdp2"><input type="text" id="fecha" name="fecha" size="10" onchange="trae_areas()"/></td>                   
                </tr>
                <tr>
                    <td id="td_a1">Mov. iniciados:</td>
                    <td id="td_a2">
                        <select name="fcmov" id="fcmov" style="width:250px" onchange="sel_fecha_pendientes()">                                             						
                        </select>
                    </td>
                </tr>                
                <tr>
                    <td id="td_a1">AREA:</td>
                    <td id="td_a2">
                        <select name="" id="area">
                            <?php  															                            
                            $res = $area->obtiene_areas();
                            echo "<option value=''>Seleccionar Area</option>";
                            while($fila = mysql_fetch_array($res)){                            
                                echo "<option value='".$fila[0]."'>".$fila[2]."</option>";                            							        
                            }                                                                
                            mysql_free_result($res);
                            ?>                        						
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td id="td_d1">Descr. del Movimiento:</td>
                    <td id="td_d2"><input type="text" id="desc" name="desc" size="60" onkeyup="this.value=Numeros(this.value)"/></td>                   
                </tr>
            </table>
            <div id="encusap">APERTURA</div>
            <div id="encabezado">
                <div id="tuser">Usuario</div>            
                <div id="tf_act">Fecha</div>
                <div id="thora">Hora</div>
            </div>
            <div id="guardado">
                <div id="user"></div>            
                <div id="f_act"></div>
                <div id="hora"></div>
            </div>
        </div>
        <div id="boton">
            <input type="button" id="boton" value="Guardar y Acceder" onclick="valida_campos(0)"/>
        </div>
        <!-- INPUT DONDE SE GUARDA EL ID DEL MOVIMIENTO CERRADO SELECCIONADO -->
        <input type="text" name="id_mov" id="id_mov" style="visibility:hidden"/>
        <select name="selmov" id="selmov" style="visibility:hidden">
        	<?php  															                            
            $resd = $diario->obtiene_fechas_mov();          
            while($filad = mysql_fetch_array($resd)){                            
                echo "<option value='".$filad[3]."'>".$filad[12]."</option>";                            							        
            }                                                                
            mysql_free_result($resd);
            ?>     		
        </select>       
    </form>
</div>
<div id="estados">
    <div id="t_estados"> Estado del Movimiento</div>
    <?
    if(isset($_GET['guardo'])){
        if($_GET['guardo']){
            echo "<div id='aviso'>Se completo el movimiento con fecha: ".$_GET['fecha']."</div>";
        }
    }
    
    ?>
    <div id="estado"></div>
    <div id="userc"></div>
    <div id="fchcierre"></div>
</div>
<div id="b_checkcerrados">
    <div id="t_checkcerrados"> Movimientos Cerrados</div>
    <div id="select_movcerrados">
        <select name="" id="chkcerrados" onchange="sel_movimientos_cerrados()">
            <?php  															                            
            $resb = $diario->obtiene_mov_completos();
            echo "<option value=''>Seleccionar Movimiento</option>";
            while($filab = mysql_fetch_array($resb)){
                list($año, $mes, $dia) = explode("-",$filab[3]);      
                $fecha = $dia."/".$mes."/".$año;
                echo "<option value='".$filab[0]."'>".$fecha."  ".$filab[12]."</option>";                            							        
            }                                                                
            mysql_free_result($resb);
            ?>                        						
        </select>        
    </div>
</div>
<div id="mov_iniciados">
    <div id="t_movini"> Movimientos Pendientes</div>
    <div id="cont_movini">
        <?php  															                            
        $resp = $diario->obtiene_mov_sin_completar();          
        while($filap = mysql_fetch_array($resp)){ 
            list($año, $mes, $dia) = explode("-",$filap[3]);
         //   list($dia, $mes, $año) = explode("/",$_GET['fecha']);
            $fecha = $dia."/".$mes."/".$año;            
            $idmov = $filap[0];//id del movimiento
            $fch_act = $_SESSION['usuario']. "-" .$filap[5]. " " . $filap[6];
            //echo "<div id='pend'>".$fecha."  ".$filap[12]."</div><div id='linkpend'><a href='check_maquinas.php?idmov=$idmov>Ver</a></div></br>";
            echo "<div id='pend'>".$fecha."  ".$filap[12]."</div><div id='linkpend'><a href='check_maquinas.php?idmov=$idmov&fch=$fecha&area=$filap[12]&completo=0'>Ver</a></div>&nbsp;|&nbsp;<a href='pdf_mov_maquinas.php?f=$fecha&ar=$filap[12]&ap=$fch_act&d=$filap[4]' target='_blank'>Imp. Portada</a></br>";                            							        
        }                                                                
        mysql_free_result($resp);
        ?>        		
    </div>   
</div>



</body>

</html>