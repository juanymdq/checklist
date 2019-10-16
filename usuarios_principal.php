<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administración de Usuarios</title>
<link href="estilos/estilo_index.css" rel="stylesheet" type="text/css" />
<script>
function genera_activos(){
    val = document.getElementById('selact').value;      
    location.href="principal.php?id=usuarios_principal&act="+val;    
} 

</script>
<style type="text/css">
.fila{background-color:#21E8F8;}
.filaalterna{background-color:#A0FAFA;}
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
#selact{
    font-size: 15px;
    width: 100px;
}
</style>
</head>
<body>
	<br />    
    
    <br />
		<h2>ADMINISTRACION DE USUARIOS</h2>
        <!-- Este select sirve para ver los usuarios activos e inactivos -->
        <select id="selact">
            <option value="1">Activos</option>
            <option value="0">Inactivos</option>
        </select>  
        <input type="button" value="Buscar" onclick="genera_activos()"/>
		<?
		//variable accio: sirve para indicar cuando los datos se guardan, actualizan o borran
		if (isset($_GET['accion'])){
				$valor = $_GET['accion'];
		}else{
				$valor=0;	
		}
		switch($valor){
			case 0: break;
			case 1:	echo "<center><font color='#0000FF'></br>Los datos se guardaron correctamente!!!</font></center>";
					break;
			case 2:	echo "<center><font color='#0000FF'></br>Los datos se actualizaron correctamente!!!</font></center>";
					break;
			case 3:	echo "<center><font color='#0000FF'></br>Se ha borrado el mozo de la base de datos!!!</font></center>";
					break;
			case 4:	echo "<center><font color='#FF0000'></br>No se ha borrado el mozo de la base de datos.</font></center>";
					break;
			case 5:	echo "<center><font color='#FF0000'></br>La contraseña se modifico correctamente!!!</font></center>";
					break;
		}	
		include("clases/c_usuario.php");		
	    
		$user = new usuario;
        //trae la variable act que contiene 1=ACTIVOS - 0=INACTIVOS
        if(isset($_GET['act'])){            
    		$user->optbusca = $_GET['act'];            
        }else{
           $user->optbusca = 1; 
        }
		$datos = $user->obtiene_datos_usuario();
		require 'DataGrid.php';
		echo "<p>";
		//echo "<div id='restablecer'><a href='principal.php?id=usuarios_principal&edita=1'>Reestablecer Tabla</a> - <a href='principal.php?edita=1'>Volver a Menu</a></div>";		
		//PARA PONER UN CAMPO DESPUÉS PARA EDICIÓN
       
		$users=array();
		while ($fila = mysql_fetch_assoc($datos)){
			$users[]=$fila;
		}
		
		Fete_ViewControl_DataGrid::getInstance($users)
		->setGridAttributes(array('border' => '1' , 'align' => 'center'))
		->enableSorting(true)
		->removeColumn('id_usuario')	
		->removeColumn('pass')
		->removeColumn('nivel')
		->removeColumn('id_nivel')	
		->removeColumn('d_numero')
		->setup(array(			
			'nombre' => array('header' => 'Nombre'),
			'apellido' => array('header' => 'Apellido'),
            'email' => array('header' => 'Email'),
			'legajo' => array('header' => 'Legajo'),			
			'usuario' => array('header' => 'Usuario'),
			'd_nivel' => array('header' => 'Nivel')
		))
		->addColumnBefore('Contador', '%counter%.', 'Num', array('align' => 'right'))						
		->addColumnAfter('actions', '<a href="principal.php?id=usuario_editar&edita=1&codigo=$id_usuario$"><img align="middle" src="imagenes/editar.png" width="30" height="30" border="0" title="Editar Usuario"/></a>','│Add:', array('align' => 'center'))
		
		->addColumnAfter('actions1', '<a href="principal.php?id=usuario_borrar&action=del&codigo=$id_usuario$" onclick="return confirm(\'Desea eliminar el usuario : $apellido$, $nombre$?\')"><img align="middle" src="imagenes/eliminar.png" width="30" height="30" border="0" title="Eliminar Usuario"/></a>', '<a href="principal.php?id=usuario_alta&edita=2"><img align="middle" src="imagenes/agregar.png"  width="30" height="30" border="0" title="Agregar Usuario"/></a>' , array('align' => 'center'))
		
		->addColumnAfter('actions3', '<a href="principal.php?id=resetear_password&codigo=$id_usuario$&nombre=$nombre$&apellido=$apellido$&edita=5&resetea=1"><img align="middle" src="imagenes/pass.png"  width="30" height="30" border="0" title="Blanquear Contraseña"/></a>','',  array('align' => 'center'))
/*
*Crea una columna al final de la grilla con el link para cambiar el estado de la reparacion. Ademas coloca el link para agregar reparaciones.
*/
		->setStartingCounter(1)
		->setRowClass('fila')
		->setAlterRowClass('filaalterna')
		->render()
				
?>

</body>
</html>