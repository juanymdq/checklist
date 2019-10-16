<?

//------------------------------------------------------------------------------------------------------------------------------------
//INICIO DE CLASE TAREA
//------------------------------------------------------------------------------------------------------------------------------------
class tarea{
		
	var $id_tarea;
	var $d_tarea;	
	var $n_tarea;
	
	
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_datos_tarea (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM tareas";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS PENDIENTES
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_pendientes (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM tareas WHERE estado='P'";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS COMPLETADAS
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_completadas (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM tareas WHERE estado='TC'";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
 //-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE DESRIPCION DE LAS TAREAS
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_descripcion_tarea ($codigo){
		//conexion a base de datos
		if(mysql_connect("localhost","root","")	){	
			
			$this->codigo = $codigo;							
			//preparo la consulta a la base
			$consulta = "SELECT d_tarea FROM tareas WHERE id_tarea='$this->codigo'";				
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
			$datos = mysql_query($consulta);						
		} //FIN MYSQL_CONNECT
		return $datos;
	}//FIN OBTIENE DESCRIPCION			
 //-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE DATOS DE UNA TAREA
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_datos_de_un_tarea ($codigo){
		//conexion a base de datos
		if(mysql_connect("localhost","root","")	){				
				//preparo la consulta a la base
				$this->id_tarea = $codigo;
				$consulta = "SELECT * FROM tareas WHERE id_tarea='$this->id_tarea;'";				
				mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
				$datos = mysql_query($consulta) or die(mysql_error());;						
		} //FIN MYSQL_CONNECT
		return $datos;
	}//FIN OBTIENE DATOS			
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE DATOS DE TAREAS GUARDADAS ERROENAMENTE
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_erroneas (){
		//conexion a base de datos
		if(mysql_connect("localhost","root","")	){				
				//preparo la consulta a la base				
				$consulta = "SELECT * FROM log_diario WHERE id_usuario=0";				
				mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
				$datos = mysql_query($consulta) or die(mysql_error());;						
		} //FIN MYSQL_CONNECT
		return $datos;
	}//FIN OBTIENE DATOS	
    				
//-------------------------------------------------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
	function inserta_datos_tarea(){
		mysql_connect("localhost","root","");
		
		mysql_select_db("check");

		// INICIAR TRANSACCION
		$consulta = "START TRANSACTION";
		
		if (!mysql_query($consulta)){	
			$error = "si";	
		}
		
		$this->d_tarea = $_POST["d_tarea"];	
		$this->n_tarea = $_POST["n_tarea"];
	
		//$opcional = $_POST["opcional"];
	
		$consulta = "INSERT INTO tareas VALUES ('','$this->n_tarea','$this->d_tarea')";
		if (mysql_query($consulta)){	
			$error = "si!";	
		} //FIN GUARDAR NIVEL
		$id = mysql_insert_id();
			
		// FIN DE LA TRANSACCION
		
		if ($error == "si"){
			$consulta = "ROLLBACK";//VOLVER TODO ATRAS
			mysql_db_query($base,$consulta);	
			echo "ERROR!!";
		} elSe {
			$consulta = "COMMIT";//CONCRETAR LA TRANSACCION
			mysql_query($consulta);
			header("location: principal.php?id=tareas_principal&accion=1&edita=1");//Envia la confirmacion de guradado a administracionnivel.php	
			
		}	
	}	//FIN FUNCTION INSERTA
    //------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS DE UNA TAREA
//------------------------------------------------------------------------------------------------
	function edita_datos_tarea(){
		
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {
			
			// 2. Preparamos la consulta
			$this->id_tarea = $_POST['codigo'];
			$this->d_tarea = $_POST["d_tarea"];	
			$this->n_tarea = $_POST["n_tarea"];				
			
			$consultaEdit = "UPDATE tareas SET d_tarea='$this->d_tarea',n_tarea='$this->n_tarea' WHERE id_tarea='$this->id_tarea'";
			
			// 3. Ejecutar la consulta
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');
			if(mysql_query($consultaEdit)){
				header("location: principal.php?id=tareas_principal&accion=2");//Envia la confirmacion de editado a administracionnivel.php	
			}
		}
	}//FIN EDITA DATOS TAREA
	//---------------------------------------------------------------------------------------------
//	BORRA LOS DATOS DE UNA TAREA
//--------------------------------------------------------------------------------------------
	function borrar_datos_tarea($codigo){	
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {	
			$this->codigo = $codigo;
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 					
			mysql_query("DELETE FROM tareas WHERE id_tarea=$this->codigo");		
			if(mysql_affected_rows()==1){
				return TRUE;//Envia TRUE si se pudo borrar el registro
			}else{					
				return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
			}
		}
	}//FIN BORRAR DATOS TAREA
	//Esta funcion esta destinada a borrar las tareas que previamente se guardaron como id_usuario=0    
    function eliminar_tarea_erronea($codigo){	
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {	
			$this->codigo = $codigo;
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 					
			mysql_query("DELETE FROM log_diario WHERE id_tarea=$this->codigo");		
			/*if(mysql_affected_rows()==1){
				return TRUE;//Envia TRUE si se pudo borrar el registro
			}else{					
				return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
			}*/
		}
	}//FIN BORRAR DATOS TAREA
}//FIN CLASE
?> 
