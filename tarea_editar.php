<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edición de Tarea</title>
<link href="estilos/estilo_menu.css" rel="stylesheet" type="text/css" />
</head>
</head>

<body>
			  <?php
			  	    			  	      
				  $codigo = $_GET["codigo"];
				  include('clases/c_tareas.php');  
				  $tarea = new tarea;
				  $datos = $tarea->obtiene_datos_de_un_tarea($codigo);
				  $fila = mysql_fetch_array($datos);			 
            ?>
           <br />
            <br />      	
           <center><h2>EDICION DE TAREAS</h2></center>
           <form id="form1" name="form1" method="post" action="tareas.php">
            <table id="tablaEdicion" align="center">
              <tr>
                    <td><input type="hidden" name="codigo" id="codigo" value="<?php echo $fila['id_tarea'];?>" /></td>   			 
                    <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
                </tr>
                <tr>
                    <th><label for="nombre">Número de la tarea:</label></th>
                    <td><input type="text" name="n_tarea" id="n_tarea" size="15" value='<?php echo $fila['n_tarea'] ?>' /></td>
                </tr>
                <tr>
                    <th><label for="nombre">Descricpión de la tarea:</label></th>    
                    <?php $d_tarea = htmlspecialchars( $fila['d_tarea'] ); ?> 			 
                    <td><input type="text" name="d_tarea" id="d_tarea" size="80" value='<?php echo $d_tarea ?>' /></td>
                </tr>
                <tr height="30px">
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table align="center" id="tablaBotones">
                <tr height="50">
                    <td><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar"/></td>
                    <td><a href="principal.php?id=tareas_principal&edita=1" >Volver</a></td>
                </tr>
             </table>
           </form>    
           <?
		    /*if (isset($_POST['edita'])){					
                $tarea->edita_datos_tarea();					  
            }*/
		   ?>        
</body>
</html>