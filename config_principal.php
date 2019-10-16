<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Configuracion</title>
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
		<h2>CONFIGURACION</h2>
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
                    include_once('caducarsesion.php');//incluye el fichero caducarsesion.php
                    $_SESSION['limite']=limite;//inserta la variable limite definida en caducarsesion.php con el tiempo                    
					break;
			case 3:	echo "<center><font color='#0000FF'></br>Se ha borrado el mozo de la base de datos!!!</font></center>";
					break;
			case 4:	echo "<center><font color='#FF0000'></br>No se ha borrado el mozo de la base de datos.</font></center>";
					break;
			case 5:	echo "<center><font color='#FF0000'></br>La contraseña se modifico correctamente!!!</font></center>";
					break;
		}	
		include_once("clases/c_config.php");
		
	
		$conf = new config;		 
		
		$datos = $conf->obtiene_datos_config();
		require 'DataGrid.php';
		echo "<p>";
		echo "<div id='restablecer'><a href='principal.php?id=config_principal&edita=1'>Reestablecer Tabla</a> - <a href='principal.php?edita=1'>Volver a Menu</a></div>";		
		//PARA PONER UN CAMPO DESPUÉS PARA EDICIÓN
		$users=array();
		while ($fila = mysql_fetch_assoc($datos)){
			$users[]=$fila;
		}
		
		Fete_ViewControl_DataGrid::getInstance($users)
		->setGridAttributes(array('border' => '1' , 'align' => 'center'))
		->enableSorting(true)
        ->removeColumn('id_config')
		->setup(array(			
			'id_config' => array('header' => 'Id'),
			'config_descr' => array('header' => 'Descripcion de la Configuracion'),
            'valor' => array('header' => 'Valor'),			
            'clave' => array('header' => 'Palabra Clave')
		))
		->addColumnBefore('Contador', '%counter%.', 'Num', array('align' => 'right'))						
		->addColumnAfter('actions', '<a href="principal.php?id=config_editar&edita=1&codigo=$id_config$"><img align="middle" src="imagenes/editar.png" width="30" height="30" border="0" title="Editar Parametro"/></a>','Add:', array('align' => 'center'))
		
		->addColumnAfter('actions1', '', '<a href="principal.php?id=config_alta&edita=2"><img align="middle" src="imagenes/agregar.png"  width="30" height="30" border="0" title="Agregar Parametro"/></a>' , array('align' => 'center'))		
	
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