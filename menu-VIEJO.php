<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CHECKLIST V 2.7</title>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('ul li:has(ul)').hover(function(e) {
         $(this).find('ul').css({display: "block"});
     },
     function(e) {
         $(this).find('ul').css({display: "none"});
     });
});
 </script>
<style type="text/css">

ul.menu {
 float:left;
 display:block;
 margin-top: 1px;
 margin-left: 2px;
 list-style-type:none;
 border: 1px solid black;
 
 }
 /*USUARIOS-----------------------*/
 .menu #us {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #us a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #us a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #us ul {
 display:none;
 position:absolute;
 top:30px;
 right: -90px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #us ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #us ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #us ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #us ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*CHECK-------------------------------*/
 .menu #ch {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #ch a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #ch a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #ch ul {
 display:none;
 position:absolute;
 top:30px;
 right: -150px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #ch ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #ch ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #ch ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #ch ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*PLANTILLAS-------------------------------*/
 .menu #pl {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #pl a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #pl a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #pl ul {
 display:none;
 position:absolute;
 top:30px;
 right: -150px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #pl ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #pl ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #pl ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #pl ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*TAREAS--------------------------------*/
 .menu #ta {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #ta a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #ta a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #ta ul {
 display:none;
 position:absolute;
 top:30px;
 right: -140px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #ta ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #ta ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #ta ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #ta ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*TURNOS------------------------*/
 .menu #tu {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #tu a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #tu a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #tu ul {
 display:none;
 position:absolute;
 top:30px;
 right: -140px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #tu ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #tu ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #tu ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #tu ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*CONFIGURACION----------------------*/
 .menu #co {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #co a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #co a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #co ul {
 display:none;
 position:absolute;
 top:30px;
 right: -80px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #co ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #co ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #co ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #co ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*FICHAJE------------------------*/
 .menu #fi {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #fi a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #fi a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #fi ul {
 display:none;
 position:absolute;
 top:30px;
 right: -65px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #fi ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #fi ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #fi ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #fi ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
 /*REPROCESO DE FECHAS---------------------*/
 .menu #rf {
 line-height:18px;
 font-size:13px;
 position:relative;
 float:left;
 border: 1px solid black; 
 padding: 5px 5px 5px 5px;
 }
 .menu #rf a {
 color: #000;
 text-transform:uppercase;
 padding: 5px 20px;
 text-decoration:none;
 }
 .menu #rf a:hover {
 background: dodgerblue;
 color: white;
 }
 .menu #rf ul {
 display:none;
 position:absolute;
 top:30px;
 right: -35px; 
 background-color: #f4f4f4; 
 list-style-type:none;
 }
 .menu #rf ul li {
 width: 200px;
 border: 1px solid black;
 border-top:none;
 padding: 10px 20px;
 background:dodgerblue; 
 }
 .menu #rf ul li:first-child {
 border-top: 1px solid #9c0101; 
 }
.menu #rf ul li a {
 width: 240px;
 margin: 10px 0 0 0;
 padding:0;
 
 }
.menu #rf ul li a:hover {
 width: 240px;
 margin: 0;
 color: white;
 background: none;
 }
</style>
</head>

<body>  
<?
 //Reanudamos la sesión
    @session_start();
	if($_SESSION['iniciada']!="SI"){
		header("location:index.php?error=2");
		exit();
	}
?> 
            <table id="tablaInicio">
                <tr>                    
                    <td align="left" width="140"><? echo "<strong>Usuario:</strong> ".$_SESSION['usuario'] ?></td>                    
                    <td align="left" width="100"><? echo "<strong>Legajo:</strong> ".$_SESSION['legajo'] ?></td>
                    <td align="left" width="150"><? echo "<strong>Rol:</strong> ".$_SESSION['d_nivel']?></td>
                    
                    <td></td><!-- La variable resetea, sirve para comprobar si el cliente eligio resetear una password desde el link Cambiar Contraseña -->
                    <td align="right" width="150"><a href="principal.php?id=resetear_password&resetea=0&edita=5">Cambiar Contrase&ntilde;a</a></td>
                    <td align="right" width="100"><a href="index.php">Cerrar Sesi&oacute;n</a></td>
                  </tr>                 
            </table>       
     	
            <?
				switch ($_SESSION['id_nivel']){
					case 1://NIVEL ADMINISTRADOR
						echo "<td><a href=\"principal.php?id=usuarios_principal&edita=1\"><img src=\"imagenes/conference.png\" width='51' height='51' title='Administracion de Usuarios'></a></td>";
						echo "<td><a href=\"principal.php?id=hoja_principal&edita=1\"><img src=\"imagenes/Checklist.png\" width='51' height='51' title='Acceso a CheckList'></a></td>";
                        echo "<td><a href=\"principal.php?id=buscar_check&edita=1\"><img src=\"imagenes/buscar.png\" width='51' height='51' title='Buscar CheckList cerrados'></a></td>";
						echo "<td><a href=\"principal.php?id=tareas_principal&edita=1\"><img src=\"imagenes/tareas.png\" width='51' height='51' title='Administración de Tareas'></a></td>";
						break;
                    case 3://NIVEL SUPERVISOR
                    
                        echo "<ul class='menu'>";
                        //USUARIOS
                            echo "<li id='us'><a href='#'>Usuarios</a>";
                                echo "<ul>";
                                    echo "<li><a href=\"principal.php?id=usuarios_principal&edita=1\">ABM Usuarios</a></li>";
                                    echo "<li><a href=\"principal.php?id=seguimiento&edita=1\">Log de Operaciones</a></li>";
                                 echo "</ul>";
                            echo "</li>";
                            //CHECK
                            echo "<li id='ch'><a href='#'>Check</a>";
                                echo "<ul>";
                                     echo"<li><a href=\"principal.php?id=hoja_principal&edita=1\">Acceso a Check</a></li>";
                                     echo "<li><a href=\"principal.php?id=buscar_check&edita=1\">Buscar Check</a></li>";                             
                                     echo "<li><a href=\"principal.php?id=check_maquinas_sel_fecha&edita=1\">Movimiento de Maquinas</a></li>";
                                     echo "<li><a href=\"principal.php?id=check_cierres_forzados&edita=0\">Cierre Forzado de Check</a></li>";
                                 echo "</ul>";
                            echo "</li>";
                            //PLANTILLAS
                            echo "<li id='pl'><a href=\"principal.php?id=plantillas&edita=1\">Plantillas Mail</a></li>";  
                            //TAREAS
                            echo "<li id='ta'><a href='#'>Tareas</a>";
                                 echo "<ul>";
                                     echo"<li><a href=\"principal.php?id=tareas_principal&edita=1\">ABM Tareas</a></li>";
                                     echo "<li><a href=\"principal.php?id=abm_tareas\">Modificar Tareas</a></li>";                             
                                     echo "<li><a href=\"principal.php?id=eliminarTareas\">Eliminar Tareas Erroneas</a></li>";
                                 echo "</ul>";
                             echo "</li>";
                             //TURNOS
                            echo "<li id='tu'><a href=\"principal.php?id=turnos_principal&edita=1\">Turnos</a></li>";
                            //CONFIGURACION
                            echo "<li id='co'><a href='#'>Configuracion</a>";
                                echo "<ul>";
                                    echo "<li><a href=\"principal.php?id=config_principal&edita=1\">Parametros</a></li>";
                                    echo "<li><a href=\"principal.php?id=backup_principal&edita=1\">Backup</a></li>";                                    
                                echo "</ul>";
                            echo "</li>";
                            //FICHAJE
                            echo "<li id='fi'><a href='#'>Acceso a Fichaje</a>";
                                echo "<ul>";
                                     echo"<li><a href=\"principal.php?id=fichaje&edita=1\">Fichaje Diario</a></li>";
                                     echo "<li><a href=\"principal.php?id=ver_horas_fichada&edita=1\">Exportar Horas</a></li>";                             
                                 echo "</ul>";                        
                            echo "</li>";
                            //REPROCESO DE FECHAS
                            echo "<li id='rf'><a href='#'>Rep. de Fechas</a>";
                                echo "<ul>";                      
                                echo "<li><a href=\"principal.php?id=reproceso&edita=1\">Acceso a Reproceso</a></li>";
                                echo "<li><a href=\"principal.php?id=reproceso_busqueda&edita=1\">Buscar Reprocesos</a></li>";
                                echo "</ul>";
                            echo "</li>";
                        echo "</ul>";
						break;
                        
					case 2://NIVEL OPERADORES
                    
                        echo "<ul class='menu'>";                        
                            //CHECK
                            echo "<li id='ch'><a href='#'>Check</a>";
                                echo "<ul>";
                                     echo"<li><a href=\"principal.php?id=hoja_principal&edita=1\">Acceso a Check</a></li>";
                                     echo "<li><a href=\"principal.php?id=buscar_check&edita=1\">Buscar Check</a></li>";
                                     echo "<li><a href=\"principal.php?id=check_maquinas_sel_fecha&edita=1\">Movimiento de Maquinas</a></li>";
                                     echo "<li><a href=\"principal.php?id=check_cierres_forzados&edita=0\">Cierre Forzado de Check</a></li>";                             
                                 echo "</ul>";
                            echo "</li>";
                            //PLANTILLAS
                            echo "<li id='pl'><a href=\"principal.php?id=plantillas&edita=1\">Plantillas Mail</a></li>";                           
                            //FICHAJE
                            echo "<li id='fi'><a href=\"principal.php?id=fichaje&edita=1\">Fichaje</a></li>";
                            //REPROCESO DE FECHAS
                            echo "<li id='rf'><a href=\"principal.php?id=reproceso&edita=1\">Reproceso de Fechas</a></li>";                                
                        echo "</ul>";
						break;
                    
                    
                    
                    
                    
                    
                    /*
                        echo "<table id='t_menu'>";
                        echo "<tr>";
                        echo "<td></td>";					                   					
						echo "<td><a href=\"principal.php?id=hoja_principal&edita=1\"><img src=\"imagenes/Checklist.png\" width='51' height='51' title='Acceso a CheckList'></a></td>";
                        echo "<td><a href=\"principal.php?id=reproceso&edita=1\"><img src=\"imagenes/repro.jpg\" width='51' height='51' title='Reproceso de Fecha'></a></td>";
                        echo "<td><a href=\"principal.php?id=fichaje&edita=1\"><img src=\"imagenes/time_clock.gif\" width='51' height='51' title='Fichaje CDC'></a></td>";
                        echo "</tr>";
                        echo "</table>";*/
					
                    case 4://NIVEL BLOQUEADO
                        echo "<td></td>";					                   					
						echo "<td></td>";
						break;
						
                }
			?>
          
             <td style="width: ;"></td>
</body>
</html>