<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Usuarios</title>

<script language="javascript">
function genera_usuario()
{
	var nom;
	var apel;
	var concatenado;
	nom = document.getElementById('nombre').value;
	nom = nom.charAt(0);
	apel = document.getElementById('apellido').value;
	concatenado = nom+apel;
	document.getElementById('usuario').value = concatenado.toLowerCase(concatenado);
}

</script>
<style>
#tusuario{
    margin: 15px 0px 50px 400px;/*FIREFOX*/
    /*border: green 3px solid;*/
    width: 350px;
    
}
#tusuario td{
    padding: 1px 0 0 0;
}
#tablaFDP td {    
    width: 250px;
    height: 50px;
}
#tusuario th{
    font-size: 10px;
    margin: 0px 0px 50px 0px;
    text-align: right;
}

</style>
</head>

<body>

  			

<br />  
<?
if (isset($_GET['error'])){
	if($_GET['error']==1){
		echo "Las contraseñas no coinciden";
	}
}
?>

<center><h2>ALTA DE USUARIO</h2></center>
<form id="fomr1" name="form1" method="post" action="usuario.php">
      <table id="tusuario">              
            <tr>                  	 
              <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
            </tr>
            <tr>
                <th><label for="nombre">Nombre:</label></th>   			 
                <td><input type="text" name="nombre" id="nombre" size="20"/></td>
            </tr>
            <tr>
                <th><label for="apellido">Apellido:</label></th>   
                <td><input type="text" name="apellido" id="apellido" size="20" onblur="genera_usuario()"/></td>
            </tr>
            <tr>
                <th><label for="email">Email:</label></th>   
                <td><input type="text" name="email" id="email" size="20"/></td>
            </tr>
            <tr>
                <th><label for="nivel">Seleccionar Nivel:</label></th>
                <td><select name="nivel" id="nivel">
                <?php
                    include("clases/c_nivel.php");
                    $niv = new nivel;
                    $res = $niv->obtiene_datos_nivel();
                    while($datos = mysql_fetch_array($res)){
                        echo "<option value='".$datos[0]."'>".$datos[1]."</option>";
                    }
					mysql_free_result($res);
                    ?>						
                </select></td>      				
            </tr>             
                                   
            <tr>
                <th><label for="legajo">Legajo:</label></th>
                <td><input type="text" name="legajo" id="legajo"/></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
                <th><label for="usuario">Usuario:</label></th>
                <td><input type="text" name="usuario" id="usuario" /></td>
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
                    <tr height="30px">
                        <td></td>
                        
                    </tr>    
              </tr>
            <tr height="50">
                <td id="tdBoton1"><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar" /></td>
                <td id="tdBoton2"><a href="principal.php?id=usuarios_principal&edita=1" >Volver</a></td>
            </tr>
    </table>
   </form> 
              
</body>
</html>