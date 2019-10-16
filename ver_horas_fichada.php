<!doctype html>
<html lang="en">
<head>
	<title>jQuery UI Datepicker - Default functionality</title>
	<link type="text/css" href="estilos/ui.all.css" rel="stylesheet" />
    <link type="text/css" href="estilos/ui.datepicker.css" rel="stylesheet" />
    <link type="text/css" href="estilos/jquery-ui.css" rel="stylesheet" />
    <script src="jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.datepicker.js"></script>
	<script type="text/javascript">
	  $(function() {	  
        $( "#dateDesde" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });
      $(function() {	  
        $( "#dateHasta" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });       
	</script>
    <style>
        #cont{
            margin: 50px 100px 0px 250px;/*FIREFOX*/
            width: 700px;
            height: 400px;
           /*border: green 1px solid;*/
        }
        #t_fdp{
            margin: 40px 0px 0px 0px;
        }
        #t_user{
            margin: 0 0 0 70px;
        }
        #t_fdp td{
            text-align: center;
        }
        #td_fdp{
            font-size: 15px;
            font-weight: bold;
        }
        #t_cab{
            width: 600px;
            margin: 50px 0px 0px 50px;
            border: blue 1px solid;
        }
        #td_cab{
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            vertical-align: central;
        }
        h2{
            margin-top: 100px;
            
        }
        #msg{
            margin-top: 30px;
            font-size: 13px;
            color: red;            
        }
        #td_tituloUser{
            font-size: 15px;
            font-weight: bold;
            padding: 20px 0 10px 0;
        }
        #td_user{
            font-size: 15px;
            font-weight: bold;
            padding: 5px 0 40px 0;
        }
        #b_horas{
            padding: 50px 0 0 0;
        }
    </style> 
    <script>
        function ver_check(){
            //carga el nombre de usuario para enviar al nombre de archivo
            var aSel = document.getElementById('s_usuarios'); 
    	    var val_aSel = aSel.options[aSel.selectedIndex].text;
                        
            var sval = document.getElementById('s_usuarios').value;
            
            //obtiene la fecha desde
            var fstr = document.getElementById('dateDesde').value;
            //elimina el separador /            
            vfstr = fstr.split("/",8);
            //doy vuelta la fecha (AAmmdd) para luego comparar
            vfstr = vfstr[2]+vfstr[1]+vfstr[0];
           
           //obtiene la fecha hasta
            var hstr = document.getElementById('dateHasta').value;
            //elimina el separador /
            vhstr = hstr.split("/",8);
            //doy vuelta la fecha (AAmmdd) para luego comparar
            vhstr = vhstr[2]+vhstr[1]+vhstr[0];
            
            if(hstr == ''){
                alert("Debe seleccionar un rango de fechas");            
           }else if(vfstr > vhstr){        
      		    alert("Fecha DESDE no puede ser mayor que fecha HASTA");		
            }else{
                //convierto a formato mysql para realizar la consulta
                fdesde = fstr.substr(6,4)+'-'+fstr.substr(3,2)+'-'+fstr.substr(0,2);
                fhasta = hstr.substr(6,4)+'-'+hstr.substr(3,2)+'-'+hstr.substr(0,2);
                if(sval == 'todos'){
                    window.location.href = 'generaHoras.php?usuario=todos&fd='+fdesde+'&fh='+fhasta+'&nuser=todos';
                }else{
                    window.location.href = 'generaHoras.php?usuario='+sval+'&fd='+fdesde+'&fh='+fhasta+'&nuser='+val_aSel;
                }
            }
        }   
        
        
        
    </script>
</head>
<body>
<?
include('clases/c_usuario.php');
$us = new usuario;
$us->optbusca = 1;//se coloca en 1 para que traiga los usuarios activos
?>
<div id="cont">
    <form id="form1" name="form1" method="post" action="buscar_hoja.php">
    
        <div>
            <table id="t_cab">
                <tr>
                    <td colspan="2" id="td_cab">EXPORTAR HORAS DE PERSONAL</td>
                </tr>  
            </table>
            <table id="t_user">  
                <tr>
                <td colspan="4" id="td_tituloUser">USUARIO:</td>
                </tr>
                <tr>
                <td colspan="4" id="td_user">
                    <select name="" id="s_usuarios" class="">
                        <?php  															                            
                        $resu = $us->obtiene_datos_usuario();
                        echo "<option value='todos'>Todos</option>";
                        while($user = mysql_fetch_array($resu)){                            
                            echo "<option value='".$user[0]."'>".$user[6]."</option>";                            							        
                        }                                                                                     
                        mysql_free_result($resu);
                        ?>                        						
                    </select>
                </td>    
                </tr>                  
                <tr>
                    <td id="td_fdp">FDP DESDE:</td>
                    <td><input type="text" id="dateDesde" name="dateDesde"/></td>
                    <td id="td_fdp">FDP HASTA:</td>
                    <td><input type="text" id="dateHasta" name="dateHasta"/></td>
                </tr> 
                <tr>
                    <td colspan="4" id="b_horas"><input type="button" value="EXPORTAR" onclick="ver_check()" /></td>
                </tr>
            </table>    
        </div>       
    
    </form>
</div>
</body>
</html>
