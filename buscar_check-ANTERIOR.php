<!doctype html>
<html lang="en">
<head>
	<title>jQuery UI Datepicker - Default functionality</title>
	<link type="text/css" href="estilos/ui.all.css" rel="stylesheet" />
    <link type="text/css" href="estilos/ui.datepicker.css" rel="stylesheet" />
    <link type="text/css" href="estilos/jquery-ui.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.datepicker.js"></script>
	<script type="text/javascript">
	  $(function() {	  
        $( "#fch" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });
	</script>
    <style>
        /*DIV GENERAL*/
        #cont{
            margin: 20px 100px 0px 400px;
            width: 700px;
            height: 400px;
           /*border: green 1px solid;*/
        }
        /*------------------------------------------*/
        /*DIV DE BUSQUEDA DE FECHAS POR CALENDARIO*/
        #buscaFechas{
            margin: 50px 10px 0px 10px;
            width: 500px;
            height: 200px;
            /*border: green 1px solid;*/
        }
        #t_fdp{
            margin: 40px 0px 0px 80px;
        }
        #t_fdp td{
            text-align: center;
        }
        #td_fdp{
            font-size: 15px;
            font-weight: bold;
        }
        /*-------------------------------------------*/
        /*DIV CON COMBO DE FDP´S CERRADAS*/
         #fechasCerradas{
            margin: 50px 10px 0px 10px;
            width: 500px;
            height: 200px;
            /*border: green 1px solid;*/
        }
        /*TABLA DE VISTA PREVIO DE CHECK CERRADOS*/
        #t_fdp_cerradas{
            margin: 50px 0 0 150px;
        }
        #t_fdp_cerradas td{
            padding: 0 25px 0 0;
        }
        /*----------------------------------------*/       
        /*DIV DE TITULOS*/
        #td_cab{
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            vertical-align: central;
        }      
        /*DIV QUE MUESTRA EL MENSAJE DE ERROR*/
        #msg{
            margin-top: 30px;
            font-size: 13px;
            color: navy;            
        }
       /*DIV DE OPCIONES*/
        #options{
            margin-top: 30px;
            font-size: 20px;
            color: navy;  
        }
    </style> 
    <script>
function selDiv(){

    var i
    //cuenta la cantidad de elementos con el name "prueba"
    for (i=0;i<document.form1.prueba.length;i++){
        //si el selector esta checkeado sale del ciclo
       if (document.form1.prueba[i].checked){
          break;
       }
    }
    //en variable resp pasa el valor del selector que se ha seleccionado
    var resp = document.form1.prueba[i].value;
    if (resp==1){
        //BUSQUEDA POR CALENDARIO
        document.getElementById('fechasCerradas').style.display = 'none'
        document.getElementById('buscaFechas').style.display = 'block';
      
    }else{
        //BUSQUEDA POR LISTA DESPLEGABLE
        document.getElementById('buscaFechas').style.display = 'none';
        document.getElementById('fechasCerradas').style.display = 'block'    
    }

}
    //funcion que envia el formulario para ver el check de fecha deseada
    function ver_check_cal(){        
        if(document.getElementById('fch').value==""){
            alert('No se ha seleccionado una fecha');     
        }else{
            //hace el submit del form
            document.getElementById('date').value=document.getElementById('fch').value;
            document.getElementById("form1").submit();
        }        
    } 
    function ver_check_lista(){
        if(document.getElementById('idfdp').value=="todos"){
            alert('No se ha seleccionado una fecha');     
        }else{
            //hace el submit del form  
            document.getElementById('date').value=document.getElementById('idfdp').value;         
            document.getElementById("form1").submit();
        }        
    }  
   
    </script>
</head>
<body>
<div id="cont">

    <form id="form1" name="form1" method="post" action="buscar_hoja.php">
        <div id="options">
            <table>
                <tr>
                    <td colspan="2">BUSCAR POR:</td>
                </tr>
                <tr>
                    <td>Por Calendario: <input type="radio" name="prueba" value="1" onclick="selDiv()"/></td>
                    <td>Por Lista Desplegable: <input type="radio" name="prueba" value="2" onclick="selDiv()"/></td>
                </tr>
            </table>
        </div>
        <div id="buscaFechas" style="display: none;">
            <table id="">
                <tr>
                    <td colspan="2" id="td_cab">BUSCAR CHECKLIST DE FDP CERRADA</td>
                </tr>  
            </table>
            <table id="t_fdp">                    
                <tr>
                    <td id="td_fdp">FDP:</td>
                    <td><input type="text" id="fch" name="fch"/></td>                    
                    <td><input type="button" value="VER" onclick="ver_check_cal()" /></td>
                </tr> 
            </table>    
        </div>
        <div id="msg">
             <?                
                if(isset($_GET['estado'])){ 
                    if($_GET['estado']==0){
                        echo "<strong>LA FDP QUE INTENA CONSULTAR NO SE ENCUENTRA PROCESADA</strong>";
                    }
                }            
             ?>
        </div>
        <div id="fechasCerradas" style="display: none;">
            <table id="">
                <tr>
                    <td colspan="2" id="td_cab">SELECCIONAR FECHAS DE PRODUCCION CERRADAS</td>
                </tr>  
            </table>
            <?           
            $hoja = new hoja;
            $dato = $hoja->obtiene_hojas_cerradas();            
            ?>     
            <table id="t_fdp_cerradas">                
               
                <tr>
                    <td>
                    <select name="idfdp" id="idfdp" style="width:150px">
                        <option value="todos">Seleccionar</option>"
                  <?  while($fila = mysql_fetch_array($dato)){
                             $fch = $fila[1];
                            $dia = substr($fch,8,2);
                            $mes = substr($fch,5,2);
                            $ano = substr($fch,0,4);
                            $fecha = $dia.'/'.$mes.'/'.$ano;
                            echo "<option value='".$fecha."'>".$fecha."</option>";							        
                        }                                                                
                        mysql_free_result($res);
                  ?>
                   </select>
                  </td>
                  <td><input type="button" value="VER" onclick="ver_check_lista()" /></td>
                </tr>
                
            </table>
        </div>       
        <input type="hidden" id="date" name="date" />
    </form>
</div>
</body>
</html>
