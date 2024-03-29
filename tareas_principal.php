<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administración de tareas</title>
<link href="estilos/estilo_index.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.fila{background-color:#21E8F8;}
.filaalterna{background-color:#A0FAFA;}
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style>
</head>
<body>
	<br />
    <br />
		<h2>ADMINISTRACION DE TAREAS</h2>
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
			case 3:	echo "<center><font color='#0000FF'></br>Se ha borrado la tarea de la base de datos!!!</font></center>";
					break;
			case 4:	echo "<center><font color='#FF0000'></br>No se ha borrado la tarea de la base de datos.</font></center>";
					break;
		}	
		include("clases/c_tareas.php");
		
	
		$tarea = new tarea;		 
		
		$datos = $tarea->obtiene_datos_tarea();
		require 'DataGrid.php';
		echo "<p>";
		echo "<div id='restablecer'><a href='principal.php?id=tareas_principal&edita=1'>Reestablecer Tabla</a> - <a href='principal.php?edita=1'>Volver a Menu</a></div>";		
		//PARA PONER UN CAMPO DESPUÉS PARA EDICIÓN
		$users=array();
		while ($fila = mysql_fetch_assoc($datos)){
			$users[]=$fila;
		}
		
		Fete_ViewControl_DataGrid::getInstance($users)
		->setGridAttributes(array('border' => '1' , 'align' => 'center'))
		->enableSorting(true)			
		->setup(array(
            'id_tarea' => array('header' => 'Id'),
			'n_tarea' => array('header' => 'Código de Tarea'),	
			'd_tarea' => array('header' => 'Descripción de la Tarea'),						
		))								
		->addColumnAfter('actions', '<a href="principal.php?id=tarea_editar&edita=1&codigo=$id_tarea$"><img align="middle" src="imagenes/editar.png" width="30" height="30" border="0" title="Editar Tarea"/></a>','│Add:', array('align' => 'center'))
		
		->addColumnAfter('actions1', '<a href="principal.php?id=tarea_borrar&action=del&codigo=$id_tarea$" onclick="return confirm(\'Desea eliminar la tarea : $d_tarea$?\')"><img align="middle" src="imagenes/eliminar.png" width="30" height="30" border="0" title="Eliminar Tarea"/></a>', '<a href="principal.php?id=tarea_alta&edita=2"><img align="middle" src="imagenes/agregar.png"  width="30" height="30" border="0" title="Agregar Tarea"/></a>' , array('align' => 'center'))		
		
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