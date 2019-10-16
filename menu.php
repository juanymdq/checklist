<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ejemplo de Bootstrap 3</title>
  <link href="estilos/bootstrap.min.css" rel="stylesheet"/>
  <link href="estilos/main.css" rel="stylesheet"/>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style>
  
  .navbar{
    background-color: #33C7FF;
    border:1px solid #33C7FF;
    height: 5px;
    margin-top: -0.5em;
    text-align: center;
    color: navy;
  }
  #tablaInicio td{
    color: navy;
  }
  </style>
</head>
<body>
 <?
    //Reanudamos la sesi�n
    @session_start();
	if($_SESSION['iniciada']!="SI"){
		header("location:index.php?error=2");
		exit();
	}
    ?> 
        <table id="tablaInicio">
            <tr>                    
                <td "align="left" width="140"><? echo "<strong>Usuario:</strong> ".$_SESSION['usuario'] ?></td>                    
                <td align="left" width="100"><? echo "<strong>Legajo:</strong> ".$_SESSION['legajo'] ?></td>
                <td align="left" width="150"><? echo "<strong>Rol:</strong> ".$_SESSION['d_nivel']?></td>
                
                <td></td><!-- La variable resetea, sirve para comprobar si el cliente eligio resetear una password desde el link Cambiar Contrase�a -->
                <td align="right" width="150"><a href="principal.php?id=resetear_password&resetea=0&edita=5">Cambiar Contrase&ntilde;a</a></td>
                <td align="right" width="100"><a href="index.php">Cerrar Sesi&oacute;n</a></td>
              </tr>                 
        </table>       
        <div class="container" style="padding-top: 1px;">
          <nav class="navbar navbar-default" role="navigation">
            <?
				switch ($_SESSION['id_nivel']){
					case 3://NIVEL SUPERVISOR
                ?>
                    <!-- Agrupar los enlaces de navegaci�n, los formularios y cualquier
                         otro elemento que se pueda ocultar al minimizar la barra -->
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                      <ul class="nav navbar-nav">
                        <!-- USUARIOS -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Usuarios <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=usuarios_principal&edita=1">ABM Usuarios</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=seguimiento&edita=1">Log de Operaciones</a></li>                            
                          </ul>
                        </li>
                        <!-- CHECKLIST -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Check <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=hoja_principal&edita=1">Acceso a Check</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=buscar_check&edita=1\">Buscar Check</a></li>   
                            <li class="divider"></li>                        
                            <li><a href="principal.php?id=check_maquinas_sel_fecha&edita=1">Movimiento de Maquinas</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=check_cierres_forzados&edita=0">Cierre Forzado de Check</a></li>
                            <!-- <li class="divider"></li> -->                            
                          </ul>
                        </li>
                        <!-- PLANTILLAS MAIL -->
                        <li><a href="principal.php?id=plantillas&edita=1" style="color: black;">Plantillas Mail</a></li>
                        <!-- TAREAS -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Tareas <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=tareas_principal&edita=1">ABM Tareas</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=abm_tareas">Modificar Tareas</a></li>
                            <li class="divider"></li>                     
                            <li><a href="principal.php?id=eliminarTareas">Eliminar Tareas Erroneas</a></li>                         
                          </ul>
                        </li>                        
                        <!-- TURNOS -->
                        <li><a href="principal.php?id=turnos_principal&edita=1" style="color: black;">Turnos</a></li>                 
                        <!-- CONFIGURACION -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Configuraci&oacute;n <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=config_principal&edita=1">Parametros</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=backup_principal&edita=1">Backup</a></li>                         
                          </ul>
                        </li>  
                        <!-- FICHAJE -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Acceso a Fichaje <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=vistafichaje&edita=1">Ver Ingresos/Egresos</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=ver_horas_fichada&edita=1">Exportar Horas</a></li>                         
                          </ul>
                        </li>  
                        <!-- REPROCESO DE FECHAS -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Reproceso de Fechas <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=reproceso&edita=1">Acceso a Reproceso</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=reproceso_busqueda&edita=1">Buscar Reprocesos</a></li>                     
                          </ul>
                        </li>
                      </ul>
                    </div>
                  <?
                  break;
                  case 2://NIVEL OPERADORES
                    ?>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                      <ul class="nav navbar-nav">  
                      
                        <!-- CHECKLIST -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">
                            Check <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="principal.php?id=hoja_principal&edita=1">Acceso a Check</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=buscar_check&edita=1\">Buscar Check</a></li>   
                            <li class="divider"></li>                        
                            <li><a href="principal.php?id=check_maquinas_sel_fecha&edita=1">Movimiento de Maquinas</a></li>
                            <li class="divider"></li>
                            <li><a href="principal.php?id=check_cierres_forzados&edita=0">Cierre Forzado de Check</a></li>
                            <!-- <li class="divider"></li> -->                            
                          </ul>
                        </li>
                        
                        <!-- PLANTILLAS MAIL -->
                        <li><a href="principal.php?id=plantillas&edita=1" style="color: black;">Plantillas Mail</a></li>                       
                        
                        <!-- FICHAJE -->
                        <li><a href="principal.php?id=vistafichaje&edita=1" style="color: black;">Ver Ingresos/Egresos</a></li>
                        
                        <!-- REPROCESO DE FECHAS -->
                        <li><a href="principal.php?id=reproceso&edita=1" style="color: black;">Reproceso de Fechas</a></li>                               
                      </ul> 
                    </div>
                   
				<?
                    break;
                
                }
                ?>
          </nav>
        </div>

</body>
</html>