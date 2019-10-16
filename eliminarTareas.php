<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administración de Usuarios</title>
<link href="estilos/estilo_index.css" rel="stylesheet" type="text/css" />

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
		<h2>ELIMINAR TAREAS GUARDADAS ERRONEAMENTE</h2>
        
		<?
		//variable accion: sirve para indicar cuando los datos se guardan, actualizan o borran
		if (isset($_GET['accion'])){
				$valor = $_GET['accion'];
		}else{
				$valor=0;	
		}
		switch($valor){
			case 0: break;			
			case 1:	echo "<center><font color='#0000FF'></br>Se ha borrado la tarea de la base de datos!!!</font></center>";
					break;
			
		}	
		include("clases/c_tareas.php");		
	    
		$user = new tarea;
        $datos = $user->obtiene_tareas_erroneas();
        require 'DataGrid.php';
		$users=array();
		while ($fila = mysql_fetch_assoc($datos)){
			$users[]=$fila;
		}
		
		Fete_ViewControl_DataGrid::getInstance($users)
		->setGridAttributes(array('border' => '1' , 'align' => 'center'))
		->enableSorting(true)
		->removeColumn('estado')	
		->removeColumn('turno')		
		->setup(array(			
			'id_tarea' => array('header' => 'ID Tarea'),
			'id_hoja' => array('header' => 'ID Hoja'),
            'id_usuario' => array('header' => 'ID USUARIO'),
			'hora' => array('header' => 'Hora'),			
			'valor' => array('header' => 'Comentario')			
		))
		->addColumnBefore('Contador', '%counter%.', 'Num', array('align' => 'right'))
		->addColumnAfter('actions1', '<a href="principal.php?id=borrarTarea&action=del&codigo=$id_tarea$" onclick="return confirm(\'Desea eliminar la tarea : $id_tarea$?\')"><img align="middle" src="imagenes/eliminar.png" width="30" height="30" border="0" title="Eliminar Tarea"/></a>')
		->setStartingCounter(1)
		->setRowClass('fila')
		->setAlterRowClass('filaalterna')
		->render()
				
?>

</body>
</html>