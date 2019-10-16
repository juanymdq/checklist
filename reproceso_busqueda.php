<!doctype html>
<html lang="en">
<head>
	<title></title>
	<script>
    function cierra_reproceso(){
      
            var combo = document.getElementById("idfdp");
            var selected = combo.options[combo.selectedIndex].text;            
            var xEstado = selected.split('-');//separa los 3 valores
            var xe = xEstado[1];//toma el valor estado
            xe = $.trim(xe);//elimina los espacios en blanco
            switch (xe){
                case 'ABIERTA':
                        var resp = confirm('El reproceso se encuentra ABIERTO. Desea cerrarlo?');
                        if (resp == true) {  
                            var ids = obtiene_supervisor();
                            var fdp = document.getElementById('idfdp').value;
                            var e = 'CERRADA';
                            $.ajax({url:"inserta_rep.php?val=4",cache:false,type:"POST",data:{idu:0,fdp:fdp,e:e,v:0,ids:ids}});   //Inserta los datos a la bd sin recargar la pagina
                            alert('Fecha Cerrada!!');
                            window.location.href = 'principal.php?id=reproceso_busqueda';
                        }
                        break;
                case 'PENDIENTE':
                        var resp = confirm("Desea cerrar el reproceso de FDP: "+xEstado[0]+" ?");
                        if (resp == true) {  
                            var ids = obtiene_supervisor();
                            var fdp = document.getElementById('idfdp').value;
                            var e = 'CERRADA';
                            $.ajax({url:"inserta_rep.php?val=4",cache:false,type:"POST",data:{idu:0,fdp:fdp,e:e,v:0,ids:ids}});   //Inserta los datos a la bd sin recargar la pagina
                            alert('Fecha Cerrada!!');
                            window.location.href = 'principal.php?id=reproceso_busqueda';
                        }
                        break;                            
                case 'CERRADA':
                        alert('El reproceso ya se encuentra cerrado')
                        break;
            }
                
    }
    function ver_reproceso(){
        var combo = document.getElementById("idfdp");
        var selected = combo.options[combo.selectedIndex].text;            
        var xEstado = selected.split('-');//separa los 3 valores
        var fecha = xEstado[0];//toma el valor estado
        fecha = $.trim(fecha);//elimina los espacios en blanco     
        if(fecha=='Seleccionar'){
            alert('Se debe seleciconar una fecha');
        }else{
            window.location.href = 'principal.php?id=reproceso_check&fdp='+fecha+'&ver=false&rseek=1';
        }
    }
    function elimina_reproceso(){
        var combo = document.getElementById("idfdp");
        var selected = combo.options[combo.selectedIndex].text;            
        var xEstado = selected.split('-');//separa los 3 valores
        var fecha = xEstado[0];//toma el valor estado
        fecha = $.trim(fecha);//elimina los espacios en blanco 
        if(fecha=='Seleccionar'){
            alert('Se debe seleciconar una fecha');
        }else{   
            var resp = confirm('Esta seguro de eliminar la fecha: '+fecha+' ?');
            if (resp == true) {  
                if(existen_tareasFdp()){
                    alert('IMPOSIBLE ELIMINAR!!!!!\nLa fecha posee tareas asociadas');
                }else{
                    var fdp = document.getElementById('idfdp').value;
                    $.ajax({url:"inserta_rep.php?val=5",cache:false,type:"POST",data:{idu:0,fdp:fdp,e:0,v:0,ids:0}});            
                    alert('Fecha: '+fecha+ ' ELIMINADA!!!!');
                    window.location.href = 'principal.php?id=reproceso_busqueda';
                }
            }
        }
    }
    //COMPTUEBA SI EXISTEN TAREAS ASOCIADAS A UNA FECHA
    function existen_tareasFdp(){
            var fdp = document.getElementById('idfdp').value;                       
            var coment = $.ajax({
                url:"inserta_rep.php?val=6",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",               
                data:{idt:0,idu:0,fdp:fdp,e:0,v:0,h:0,ids:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto
             if(coment == ""){ 
                    //no existe la FDP
                    return false;
             }else{                     
                    //la FDP se encuentra reprocesada
                    return true;
             } 
    }
    //TRAE EL NOMBRE DEL SUPERVISOR
    function obtiene_supervisor(){
        var ids = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
        var coment = $.ajax({
                url:"inserta_rep.php?val=7",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",               
                data:{idt:0,idu:0,fdp:0,e:0,v:0,h:0,ids:ids}
            }).responseText;  //ejecuta la consulta y devuelve formato texto            
            return coment;        
    }    
    </script>
    <style>
      
        /*DIV CON COMBO DE FDP´S CERRADAS*/
         #fechasCerradas{
            margin: 50px 10px 0px 350px;/*FIREFOX*/
            padding: 30px 0 0 0;
            width: 500px;
            height: 200px;
            /*border: green 1px solid;*/
        }
        /*TABLA DE VISTA PREVIO DE CHECK CERRADOS*/
        #t_fdp_cerradas{
            margin: 30px 0 0 120px;
            
        }
        #t_fdp_cerradas tr{
            padding: 0 25px 0 0;
            
        }
        #t_fdp_cerradas td{
            padding: 0 25px 0 0;
            
        }
        /*----------------------------------------*/       
        /*DIV DE TITULOS*/
        #t_cab{
            margin: 0 0 30px 50px;
        }
        #td_cab{
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            vertical-align: central;
            text-decoration: underline;
            
        }      
        /*DIV QUE MUESTRA EL MENSAJE DE ERROR*/
        #msg{
            margin-top: 30px;
            font-size: 13px;
            color: red;            
        }
     
    </style> 
    
</head>
<body>

    <form id="form1" name="form1" method="post" action="buscar_hoja.php">
    
        <div id="fechasCerradas">
            <table id="t_cab">
                <tr>
                    <td colspan="2" id="td_cab">SELECCIONAR FECHA REPROCESADA</td>
                </tr>  
            </table>
             <?
                if($_SESSION['d_nivel']=='SUPERVISOR'){
                    echo "<input type='button' value='VER' onclick='ver_reproceso()'/>";
                      
                    echo "<input type='button' value='CERRAR' onclick='cierra_reproceso()'/>";
                       
                    echo "<input type='button' value='ELIMINAR' onclick='elimina_reproceso()'/>";
                }else{
                    echo "<input type='button' value='VER' onclick='ver_reproceso()'/>";
                }
                
               
            include('clases/c_diario.php');      
            $diario = new diario;
            $dato = $diario->obtiene_fechas_abiertas_pendientes();            
            ?>     
            <table id="t_fdp_cerradas">                
               
                <tr>
                    <td>
                    <select name="idfdp" id="idfdp" style="width:250px">
                        <option value="todos">Seleccionar</option>"
                  <?  while($fila = mysql_fetch_array($dato)){
                            list($año, $mes, $dia) = explode("-",$fila['fdp']);
                            $fecha = $dia."/".$mes."/".$año;                            
                            echo "<option value='".$fila['fdp']."'>".$fecha." - ". $fila['estado']." - ". $fila['usuario']."</option>";							        
                        }                                                                
                        mysql_free_result($res);
                  ?>
                   </select>
                  </td>
             </table>    
        </div>       
        <input type="hidden" id="date" name="date" />
    </form>

</body>
</html>
