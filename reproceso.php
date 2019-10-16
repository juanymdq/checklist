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
        $( "#fdp" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });   
      $(document).ready(function(){
        var fecha = new Date();
         $( "#fechaHora" ).val(fecha);   
      });
        //al presionar el boton de acceder, guardara la fecha de produccion en la tabla reproceso
        function accede_check(){
            var fecha = document.getElementById('fdp').value;
            if(fecha==''){
                alert('El campo fecha se encuentra vacio');
            }else{           
                //trae la fdp seleccionada
                if(verifica_fdp()){                
                    var resp = confirm("La FDP seleccionada ya se encuentra reprocesada. Desea acceder para visualizarla");
                    if (resp == true) {
                        window.location.href = 'principal.php?id=reproceso_check&fdp='+fecha+'&ver=false&rseek=0';                
                    }
                }else{                            
                    var resp = confirm("Desea acceder a reprocesar la FDP: "+fecha+" ?");
                    if (resp == true) {  
                        var idu = '<? echo $_SESSION['id_usuario']; ?>';//id de usuario
                        var e = 'ABIERTA';//variable estado de reproceso
                        var v = obtiene_fecha_actual();//variable fecha y hora actual
                        var fdp = fechabd();//variable fdp formateada para bd mysql
                        var ids=0;
                        //guarda los datos
                        $.ajax({url:"inserta_rep.php?val=1",cache:false,type:"POST",data:{idu:idu,fdp:fdp,e:e,v:v,ids:ids}});   //Inserta los datos a la bd sin recargar la pagina
                        //direcciona a reproceso_check.php - variable rseek es para controlar si viene desde reproceso = 0
                        //o desde reproceso_busqueda = 1
                        window.location.href = 'principal.php?id=reproceso_check&fdp='+fecha+'&ver=true&rseek=0';
                    
                    }
                }
            }
        }
        function fechabd(){    
            fecha = document.getElementById('fdp').value;   
            fechax = fecha.split('/');    
            fechaform = fechax[2]+'-'+fechax[1]+'-'+fechax[0];   
            return fechaform;    
        }
        function obtiene_fecha_actual(){    
            var d = new Date();    
            mes = d.getMonth()+1;
            dia = d.getDate();
            hora = obtiene_hora();       
            if(d.getDate()<10){
                dia = '0'+d.getDate();        
            }
            if(mes<10){
                mes = '0'+mes;
            }            
            return(d.getFullYear()+'-'+mes+'-'+dia+" "+hora);
        }
        function obtiene_hora(){
            var d = new Date();
            horas = d.getHours();
            minutos = d.getMinutes();
            segundos = d.getSeconds();
            if(horas < 10){
                horas = '0'+d.getHours();
            }
            if(minutos < 10){
                minutos = '0'+d.getMinutes();
            }
            if(segundos < 10){
                segundos = '0'+d.getSeconds();
            }
            return(horas+':'+minutos+':'+segundos); 
        }
        function verifica_fdp(){
            fdp=fechabd();                       
            var coment = $.ajax({
                url:"inserta_rep.php?val=2",
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
</script>
 <style>
    #cont{
        width: 550px;
        /*border: green 1px solid;*/
        margin: 50px 0 0 350px;/*FIREFOX*/
    }
    #r_titulo{
        margin: 30px 1px 1px 1px;        
        font-weight: bold;
        font-size: 16px;
        text-decoration: underline;
    } 
    #boton{
        margin: 20px 0 0 0;
    }
    #t_fdp{
        margin: 30px 1px 1px 200px;/*FIREFOX*/
    }
    #aviso{
        margin: 50px 0 0 0;
        font-weight: bold;
        color: red;
    }
 </style>
</head>

<body>
<?
if(isset($_GET['guardo'])){
    if($_GET['guardo']){
        echo "<div id='aviso'>Se cerro el reproceso de FDP: ".$_GET['fecha']."</div>";
    }
}
?>
<div id="cont">
    <div id="r_titulo">SELECCIONAR FECHA DE REPROCESO - MDPCORE -</div>
    <form id="form1" name="form1" method="post" >
        <div>
            <table id="t_fdp">
                <tr>
                    <td id="td_fdp">FDP:</td>
                    <td><input type="text" id="fdp" name="fdp" size="10"/></td>                   
                </tr> 
            </table>
        </div>
        <div id="boton">
            <input type="button" id="boton" value="Acceder" onclick="accede_check()"/>
        </div>
    </form>
</div>

</body>

</html>