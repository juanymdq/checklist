<? session_start(); 
//*********CHECK DE TAREAS DIARIAS DE CDC MAR DEL PLATA*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 10/04/2016 -******************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN CHECK</title>
<link href="estilos/estilo_web.css" rel="stylesheet" type="text/css" />
<script>
function Inicializar() {
            
    document.form1.login.focus();
}

</script>

</head>
<body onload="Inicializar();">

		<div id='wrapper'>
			<div id='container'>
				<div id='cabeza'> <?php include ("fechahora.php"); ?> </div><!-- HEADER -->
                <?
					if(isset($_SESSION['usuario'])){
						session_unset();                        
					}
				?>
				<div id='menu'></div>                
				<div id='contenido'>
                    <div id="imagen"><img src="imagenes/navidad.png" width="100" height="100"/></div>
                    <div id="tlogin">
                         <table id="tablaLogin" align="center" style="margin-top:50px">
                            <tr height="30px">
                                <td id="loginTd" colspan="3">Acceso al sistema</td>
                             </tr>
                             <form id="form1" name="form1" method="post" action="usuario.php"><br />
                             <tr>                  	 
                                <td><input type="hidden" name="edita" id="edita" value="4" /></td>  
                            </tr>
                             <tr height="10px">
                                <td></td>
                                <td></td>
                              </tr>
                             <tr>
                               <p>
                                 <th><label for="usuario">Usuario:</label></th>
                                 <td><input type="text" name="usuario" id="usuario" /></td>
                                 <td rowspan="2"><img src="imagenes/user-login.png" width="80" height="80"/></td>
                                    
                             </p>
                             </tr>
                             <tr>
                               <p>
                                 <th><label for="pass">Contraseña:</label></th>
                                 <td><input type="password" name="pass" id="pass" /></td>                          
                               </p>
                              </tr>
                              <tr height="10px">
                                <td></td>
                                <td></td>
                              </tr>
                              <tr>
                               <td colspan="3" align="center"><input type="submit" name="enviar" id="enviar" value="Aceptar" /></td>
                              </tr>
                               <tr height="10px">
                                <td colspan="3" style="color:#F00"><?
                                    //************************
                                    //$_GET['error']) viene de usuario.php
                                    if(!isset($_GET['error'])){
                                        echo " ";
									}else{
									   switch($_GET['error']){
									       case 1:
                                                echo "Usuario o Contraseña incorrecta!!!";
                                                break;
                                           case 2:
                                                echo "No se pudo establecer conexion. Intente mas tarde";	
                                                break;
                                           case 3:
                                                echo "EL USUARIO SE ENCUENTRA INACTIVO";
                                                break;
									   }
									}
                                ?></td>
                
                              </tr>                          
                            </form>            
                		</table>
                </div>
                <?
                include_once('caducarsesion.php');
                if(isset($_GET['caducada'])){
                        if($_GET['caducada']==1){
                            session_destroy();
	                        unset($_SESSION);
                            echo "<br/>";
                            echo "<br/>";
                            echo "<br/>";
                            echo "<h2 style='color: red;'>SESION EXPIRADA</h2>";
                            echo "<h3 style='color: red;'>La sesion excedi&oacute los " . limite . " minutos de inactividad</h3>";
                                   
                        }
                    }
                ?>  
                
         </div><!-- DIV Contenido -->
		
    </div><!-- DIV Conteiner -->
    <div id='foot'><?php include ("pie.php"); ?> </div>
</div><!-- DIV Wrapper -->
	  
 
</body>
</html>
