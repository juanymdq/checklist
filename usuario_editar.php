<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edición de Mozo</title>

</head>
<style>
#tusuario{
    margin: 30px 0px 50px 400px;/*FIREFOX*/
    /*border: green 3px solid;*/
    width: 350px;
    
}

#tusuario td{
    padding: 15px 0 0 0;
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
<?php     			  	      
  $codigo = $_GET["codigo"];
  include('clases/c_usuario.php');  
  $user = new usuario;
  $datos = $user->obtiene_datos_de_un_usuario($codigo);
  $fila = mysql_fetch_array($datos);           
?>
    <br />
    <br />    
    <center><h2>EDICION DE USUARIO</h2></center>  	
    <form id="form1" name="form1" method="post" action="">
            <table id="tusuario">                  
                <tr>
                    <td><input type="hidden" name="codigo" id="codigo" value="<?php echo $fila['id_usuario'];?>" /></td>   			 
                    <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
                </tr>
                <tr>
                    <th><label for="nombre">Nombre:</label></th>   			 
                    <td><input type="text" name="nombre" id="nombre" size="20" value="<?php echo $fila['nombre'];?>" /></td>
                </tr>
                <tr>
                    <th><label for="apellido">Apellido:</label></th>   
                    <td><input type="text" name="apellido" id="apellido" size="20" value="<?php echo $fila['apellido']?>"  /></td>
                </tr>
                <tr>
                    <th><label for="email">Email:</label></th>   
                    <td><input type="text" name="email" id="email" size="20" value="<?php echo $fila['email']?>"  /></td>
                </tr>
                <tr>
                    <th><label for="nivel">Seleccionar Nivel:</label></th>
                    <td><select name="nivel" id="nivel">
                    <?php
                        include("clases/c_nivel.php");
                        $nivel = new nivel;
                        $res = $nivel->obtiene_datos_nivel();
                        while($datos = mysql_fetch_array($res)){
                            if ($datos['id_nivel']==$fila['id_nivel']){
                                echo "<option selected='selected' value='".$datos[0]."'>".$datos[1]."</option>";	
                            } else {
                                echo "<option value='".$datos[0]."'>".$datos[1]."</option>";
                            }
                        }										
                        ?>						
                    </select></td>      				
                </tr>               
                <tr>
                    <th><label for="legajo">Legajo:</label></th>
                    <td><input type="text" name="legajo" id="legajo" value="<?php echo $fila['legajo']?>" /></td>
                </tr> 
                <tr>
                    <th><label for="usuario">Usuario:</label></th>
                    <td><input type="text" name="usuario" id="usuario" value="<?php echo $fila['usuario']?>" /></td>
                </tr>                      
                <tr>
                <tr height="30px">
                    <td></td>
                    <td></td>
                </tr>
                <tr height="50">
                    <td><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar"/></td>
                    <td><a href="principal.php?id=usuarios_principal&edita=1" >Volver</a></td>
                </tr>
        </table>
        
  </form>
	<?
        if (isset($_POST['edita'])){					
            $user->edita_datos_usuario();				  
        }
    ?> 
</body>
</html>