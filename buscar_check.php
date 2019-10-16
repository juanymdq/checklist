<!doctype html>
<html lang="en">
<head>
	<title></title>	
    <style>
        /*DIV GENERAL*/
        #cont{
            margin: 50px 0px 0px 250px;
            width: 700px;
            height: 200px;
          /* border: green 1px solid;*/
        }     
        .titulo{
            color:  navy;
            font-size: 18px;
            margin: 10px 0 0 0;
          /*  border: green 1px solid;*/
        } 
        .cbo_check{
            margin: 50px 0 0 220px;
            width: 250px;
           /* border: green 1px solid;*/
        }
        /*TABLA DE VISTA PREVIO DE CHECK CERRADOS*/
        #t_fdp_cerradas{
            margin: 0px 0 0 0px;
        }
        #t_fdp_cerradas td{
            padding: 0 20px 0 0;
        }
      
      
    </style> 
    <script>
         function ver_check_lista(){
            if(document.getElementById('idfdp').value=="todos"){
                alert('No se ha seleccionado una fecha');     
            }else{
                //hace el submit del form  
                document.getElementById('date').value = document.getElementById('idfdp').value;         
                document.getElementById("form1").submit();
            }        
         }  
    </script>
</head>
<body>
<div id="cont">
    <form id="form1" name="form1" method="post" action="buscar_hoja.php">
        <div class="titulo">SELECCIONAR FECHAS DE PRODUCCION CERRADAS</div>
        <div class="cbo_check">                 
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
