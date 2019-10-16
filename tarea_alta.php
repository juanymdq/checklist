<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Tareas</title>

</head>
<body>  			
<br />
<br />  

<center><h2>ALTA DE TAREAS</h2></center>
<form id="fomr1" name="form1" method="post" action="">
      <table id="tablaEdicion" align="center">              
            <tr>                  	 
              <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
            </tr>
            <tr>
                <th><label for="nombre">Código de la tarea:</label></th>   			 
                <td><input type="text" name="n_tarea" id="n_tarea" size="15"/></td>
            </tr>
            <tr>
                <th><label for="nombre">Descricpión de la tarea:</label></th>   			 
                <td><input type="text" name="d_tarea" id="d_tarea" size="80"/></td>
            </tr>            
              <tr>
                    <tr height="30px">
                        <td></td>
                        <td></td>
                    </tr>    
              </tr>
        </table>
        <table align="center" id="tablaBotones">
            <tr height="50">
                <td><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar" /></td>
                <td><a href="principal.php?id=tareas_principal&edita=1" >Volver</a></td>
            </tr>
    	</table>
   </form> 
<?			
			include("clases/c_tareas.php");
			$tarea = new tarea;
			if(isset($_POST['d_tarea'])){
				$tarea->inserta_datos_tarea();
			}
			?>
            
        
              
</body>
</html>