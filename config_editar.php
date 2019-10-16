<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edición de Parametros</title>

</head>
<style>
h2{
    margin: 20px 0 0 0;
}
#tusuario{
    margin: 30px 0px 50px 430px;/*FIREFOX*/
    /*border: green 3px solid;*/
    width: 350px;
    
}
#tusuario th{
    font-size: 10px;
    margin: 0px 0px 50px 0px;
    text-align: right;
    
}
#tusuario td{
    text-align: left;
    padding: 15px 0 0 0;
}
#tdBoton1{   
    padding: 10px 0 5px 10px;
}
#tdBoton2{   
    padding: 10px 0 5px 170px;
}
</style>
<script>
window.onload = function(){//se ejecuta al abrir la pagina
    //obtiene elementos del select
    var sel = document.getElementById('valor');
    //obtiene cantidad de elementos a recorrer
    var x = document.getElementById("valor").options.length;
    //obtiene el dato guardado en la BD
    var selbd = document.getElementById('valbd').value;
    //recorre uno a uno los elementos del select
    for (var i = 0; i < x; i++) 
	{
	   //en variable opt va colocando los elementos del select
	   var opt = sel[i];        
       if(opt.value == selbd){//cuando el elemento sea igual al guardado lo coloca en el combo            
            document.getElementById("valor").value = selbd;
       }   
    }
}

</script>
</head>

<body>
<?php     			  	      
  $codigo = $_GET["codigo"];
  include('clases/c_config.php');  
  $conf = new config;
  $datos = $conf->obtiene_una_config($codigo);
  $fila = mysql_fetch_array($datos);           
?>
    <br />
    <br />    
    <center><h2>EDICION DE PARAMETROS</h2></center>  	
    <form id="form1" name="form1" method="post" action="configura.php">
            <table id="tusuario">                  
                <tr>
                    <td><input type="hidden" name="codigo" id="codigo" value="<?php echo $fila['id_config'];?>" /></td>   			 
                    <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
                </tr>
                <tr>
                    <th><label for="descripcion">Descripcion:</label></th>   			 
                    <td><input type="text" name="d_config" id="d_config" size="35" value="<?php echo $fila['config_descr'];?>" /></td>
                </tr>
                <tr>                   
                    <th><label for="valor">Valor:</label></th>
                    <td><select name="valor" id="valor">
                    
                        <option value='0.25'>15 seg</option>;
                        <option value='0.50'>30 seg</option>;
                        <option value='1'>1 min</option>;
                        <option value='5'>5 min</option>;
                        <option value='10'>10 min</option>;
                        <option value='20'>20 min</option>;
                        <option value='30'>30 min</option>;
                        <option value='40'>40 min</option>;
                        <option value='50'>50 min</option>;
                        <option value='60'>60 min</option>;
                     </select>
                    
                    <?php
                        include_once("clases/c_config.php");
                        $conf = new config;
                        $val="TES";
                        $dato = $conf->obtiene_config_x_clave($val);
                        $filav = mysql_fetch_array($dato);                       					
                        ?>						
                      <input type="text" value="<? echo $filav[0] ?>" size="5" id="valbd" style="visibility:hidden"/>    
                    </td>
                </tr>
                <tr>
                    <th><label for="clave">Palabra Clave:</label></th>   
                    <td><input type="text" name="clave" id="clave" size="5" value="<?php echo $fila['clave']?>"  /></td>
                </tr>
                
                <tr>
                    <td id="tdBoton1"><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar"/></td>
                    <td id="tdBoton2"><a href="principal.php?id=config_principal&edita=1" >Volver</a></td>
                </tr>
        </table>
        
  </form>
	<?
        if (isset($_POST['edita'])){					
            $conf->edita_datos_config();				  
        }
    ?> 
</body>
</html>