
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>
 
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript">
//ESTA FUNCION GENERA EL EFECTO SLIDE DE TAREAS EN CADA USUARIO
$(document).ready(function(){    
    $('.user').live('click',function(){
        $(this).parent().find('ul').slideToggle('slow');                          
    });
});

function cerrar_turno(user,estado){
        
        //trae el ID de usuario
        var idu = user;
        //en base al id de usuario consulta mediante ajax el nombre de usuario
        //sin recargar la pagina
        var coment = $.ajax({
            url:"traecomentarios.php?val=2",
            dataType: 'text',//indicamos que es de tipo texto plano
            async: false,     //ponemos el parámetro asyn a falso            
            type:"POST",
            data:{idu:idu,idt:0,idh:0}
        }).responseText;  //ejecuta la consulta y devuelve formato texto            
              
       //obtiene el numero de hoja
        var idh = document.getElementById('hoja').value;
        if(estado==1){//Igual a 1 cierra el turno
            var resp = confirm("Desea cerrar el turno del usuario "+coment+"?");
            if (resp == true) {
                //edita el estado del turno a CERRADO
                $.ajax({url:"editar.php?val=0",cache:false,type:"POST",data:{idh:idh,idu:idu}});
                alert('Turno de '+coment+' CERRADO!!!'); 
            }
        }else{//Igual a 0 abrira el turno
            var resp = confirm("Desea abrir el turno del usuario "+coment+"?");
            if (resp == true) {
                //edita el estado del turno a CERRADO
                $.ajax({url:"editar.php?val=3",cache:false,type:"POST",data:{idh:idh,idu:idu}});
                alert('Turno de '+coment+' ABIERTO!!!');             
            }            
        }
        //recarga la pagina para actualizar los turnos
        window.location.href = 'principal.php?id=turnos_principal';
}   

</script>
<style>
#sidebar {	
    float: left;/*FIREFOX*/
    padding: 0 0 10px 0;
    margin: 10px 0 0 200px;
}
.block {
    width:100%;    
    margin-bottom:1px;
    border-bottom-color: black;
}

.block h2 {
    width:96%;
    font-size: 15px;
    background-color:#336600;
    color:#FFFFFF;
    cursor:pointer;
    margin:0px;
    padding:5px;
}

.block ul {
    float: left;
    width: 100%;   
    margin: 0;
    padding: 2px;
    display:none;
}

.block ul li {
    float: left;
    background-color: #33CC00;
    border-bottom: 1px solid #336600;
    font-size: 10px;
    text-align: left;
    list-style: none outside none;
    padding: 5px;
    width: 500px;
    margin: 0 0 0 120px;
}
.user{
    float: left;
    width:300px;
    margin: 0 0 0 0;
    
}.cabuser{
    font-size: 20px;
    font-weight: bold;
    float: left;
    margin: 0 0 0 300px;
}
#estado{    
    font-size: 15px;
    font-weight: bold;
    background-color:#336600;
    color:#FFFFFF;
    cursor:pointer;
    margin:0 0 0 90px;
    padding:5px;
    width: 100px;
    float: left; 
      
}
.cabestado{
    font-size: 20px;
    font-weight: bold;
    margin: 0 0 0 190px;
    float: left;
}
.accion{
    font-size: 14px;
    font-weight: bold;    
    float: left;
    margin: 0 0 0 35px;
   
}.cabaccion{
    font-size: 20px;
    font-weight: bold;    
    float: left;
    margin: 0 0 0 40px;
}

h1{
    margin: 50px 0 30px 0;
    text-decoration-line: underline;
}
#aviso{
    
    font-size: 16px;
    color: red;
    margin: 50px 0 0 0;
}
.sin_turnos{
    color: red;
    margin: 120px 0 0 0;
    
}
</style>
</head>

<body>

<h1><u>ADMINISTRACION DE TURNOS</u></h1>
<?

if(!class_exists('turnos')){ include("clases/c_turnos.php"); } 
if(!class_exists('diario')){ include("clases/c_diario.php"); }
if(!class_exists('hoja')){ include("clases/c_hoja.php"); }
$turno = new turnos;
$logd = new diario;
$hoja = new hoja;
$resp = $hoja->obtiene_ultima_fecha_abierta_hoja();//OBTIENE LA ULTIMA FECHA ABIERTA
$fila = mysql_fetch_array($resp);
if(!empty($fila[0])){//SIN NO EXISTE FECHA ABIERTA, DEVOLVERA NULL
    if(isset($_SESSION['id_hoja'])){//SI LA HOJA ESTA SETEADA
        $turno->hoja = $_SESSION['id_hoja'];//COLOCA EL ID DE HOJA EN VARIABLE $HOJA DE LA CLASE TURNOS
        $rest = $turno->obtiene_turnos_x_hoja();//OBTIENE LOS TURNOS SEGURN EL NUMERO DE HOJA
        //ESCRIBE LOS ENCABEZADOS
        echo "<span class='cabuser'><u>USUARIO</u></span>";
        echo "<span class='cabestado'><u>ESTADO</u></span>";
        echo "<span class='cabaccion'><u>ACCION</u></span>";
        //RECORRE EL ARRAY CON LOS TURNOS ABIERTOS Y LOS ESCRIBE
        while($filat = mysql_fetch_array($rest)){
            $hoja = $filat['id_hoja'];
            $use = $filat['id_usuario'];
            $dato = $filat['id_usuario']."-".$filat['usuario'];
            $resl = $logd->obtiene_tareas_usuario($use,$hoja);
            echo "
                <div id='sidebar'>
                   <div class='block'>                        
                        <span class='user'><h2>".$filat['nombre']." ".$filat['apellido']."</h2></span>
                        <div id='estado'>".$filat['testado']."</div>";                        
                        if($filat['testado']=='ABIERTO'){
                            echo "<span class='accion'><a href='#' onclick='cerrar_turno(".$filat['id_usuario'].",1)'>Cerrar Turno</a></span>";                                             
                        }elseif($filat['testado']=='CERRADO'){
                            echo "<span class='accion'><a href='#' onclick='cerrar_turno(".$filat['id_usuario'].",0)'>Abrir Turno</a></span>";                                              
                        }
                        echo "<span><input id='hoja' type='hidden' value='".$filat['id_hoja']."'</span>";
                        //RECORRE LAS TAREAS REALIZADAS POR EL USUARIO Y LAS ESCRIBE
                        while($filal = mysql_fetch_array($resl)){
                        echo"<ul>                    
                                <li>".$filal['id_tarea']." - ".$filal['d_tarea']."</li>";
                        echo "</ul>";
                        }
             echo " </div>
                </div>
            ";
        }
    }
}else{
    //SIN NO HAY HOJA ABIERTA, LO INFORMA
    echo "<span class='sin_turnos'>NO HAY TURNOS ABIERTOS</span>";
} 
?>

</body>
</html>