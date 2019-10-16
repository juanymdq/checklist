<?php 
            include("clases/c_usuario.php");
            include_once('caducarsesion.php');		
			//include("clase_fichaje.php");
            $user = new usuario;
			//$ficha = new fichaje;	
            switch ($_POST["edita"]) {
                case 1: //si se edita
                    $user->obtiene_datos_usuario();
                    break;
                case 2: // si se agrega
					if(($_POST['pass'])<>($_POST['repass'])){
						//echo "<h4 align='center'>Las contraseñas no coinciden. Por favor complete nuevamente los datos.</h4>";
						header ('location: usuario_alta.php?error=1&edita=2');
						//echo "<h3 align='center'><a href='principal.php?id=agregarcliente&error=1'>Volver</a></h3>";
					} else {						
						$user->inserta_datos_usuario();						
					}
                    break;	
				case 4://login al sistema
					$ingreso = $user->obtiene_password();					
					$fila = mysql_fetch_array($ingreso);
                    
                    if($fila['id_nivel']==4){
                        header("location:index.php?error=3");//implica que el usuario esta INACTIVO
                    }else{                    					
    					if(mysql_num_rows($ingreso) > 0){
    						session_start();
    						$_SESSION['id_usuario']=$fila['id_usuario'];
    						$_SESSION['usuario']=$fila['usuario'];
    						$_SESSION['id_nivel']=$fila['id_nivel'];
    						$_SESSION['d_nivel']=$fila['d_nivel'];
                            $_SESSION['legajo']=$fila['legajo'];
    						$_SESSION['iniciada'] = "SI";
                            $_SESSION['limite'] = limite;
    						header("location:principal.php");										
    					}else {						
    						header("location:index.php?error=1");
    					}
                    }
					break;
				case 5: //si se edita la password
					if(($_POST['pass'])<>($_POST['repass'])){
						header ('location: principal.php?id=resetear_password&error=1&edita=5&resetea=0');
					}else{
						$user->edita_pass_usuario();
					}
					break;
			}//FIN SWITCH
            ?>
                			