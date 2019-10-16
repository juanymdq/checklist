<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>S.I.A</title>

<link href="estilos/estilo_web.css" rel="stylesheet" type="text/css" />
<style>
h4{
    margin: 100px 0 0 0;
}

</style>
</head>
 
<body onload='document.forms["form1"]["pass"].focus()'>

			<?
				if(isset($_GET['error'])){
					if($_GET['error']==1){
						echo "<h4 align='center'>Las contraseñas no coinciden.</h4>";
					}
				}
			?>
        	<h4 align="center" style="text-decoration:underline"><strong>BLANQUEO DE CONTRASEÑA</strong></h4>
            <table id="tablaLogin" align="center" bordercolor="#000000" style="margin-top:20px">            
            	<tr height="30">
                    <td id="loginTd" colspan="2"><?  if($_GET['resetea']==1){echo $_GET['nombre']. " " .$_GET['apellido'];} ?></td>    
                </tr>  
                <tr height="10px">
                	<td></td>
                    <td></td>
                </tr>
              <form id="form1" name="form1" method="post" action="usuario.php">
                <tr>                  	 
	                <td><input type="hidden" name="codigo" id="codigo" value="<?php if($_GET['resetea']==1){echo $_GET['codigo'];}?>" /></td> 
    	            <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
                </tr>
                  
                <tr>           
                	<th><label for="pass">Contraseña:</label></th>
           		  	<td><input type="password" name="pass" id="pass" /></td>  
                </tr>
                <tr>                   
                	<th><label for="repass">Repetir Contraseña:</label></th>
           		  	<td><input type="password" name="repass" id="repass" /></td>           		 
                </tr>                
                <tr>
                <tr height="10px">
                	<td><input type="hidden" name="resetea" id="resetea" value="<?php echo $_GET['resetea'];?>" /></td>
                    <td></td>
                </tr>
          <tr>
                    <th><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar" /></th>
                     <td id="volver"><a href="principal.php" >Volver</a></td>
                </tr>
                </form>
            </table>
       </body>
</html>