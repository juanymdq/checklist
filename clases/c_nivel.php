<?

//---------------------------------------------------------------------------------------------
//INICIO DE CLASE NIVEL
//---------------------------------------------------------------------------------------------
class nivel{
		
	var $codigo;
	var $d_nivel;	
	var $numero;	
	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN NIVEL
//----------------------------------------------------------------------------------------------
	function obtiene_datos_nivel (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM nivel";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS NIVEL
	
	function obtiene_descripcion_nivel ($codigo){
		//conexion a base de datos
		if(mysql_connect("localhost","root","")	){	
			$this->codigo = $codigo;							
			//preparo la consulta a la base
			$consulta = "SELECT d_nivel FROM nivel WHERE id_nivel='$this->codigo'";				
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
			$datos = mysql_query($consulta);						
		} //FIN MYSQL_CONNECT
		return $datos;
	}//FIN OBTIENE DESCRIPCINO NIVEL			
	
	function obtiene_datos_de_un_nivel ($codigo){
		//conexion a base de datos
		if(mysql_connect("localhost","root","")	){				
				//preparo la consulta a la base
				$this->codigo = $codigo;
				$consulta = "SELECT * FROM nivel WHERE id_nivel='$this->codigo = $codigo;'";				
				mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
				$datos = mysql_query($consulta) or die(mysql_error());;						
		} //FIN MYSQL_CONNECT
		return $datos;
	}//FIN OBTIENE DATOS DE UN NIVEL				
					
//--------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS DE UN NIVEL
//--------------------------------------------------------------------------------------------
	function inserta_datos_nivel(){
		mysql_connect("localhost","root","");
		mysql_select_db("check");

		// INICIAR TRANSACCION
		$consulta = "START TRANSACTION";
		
		if (!mysql_query($consulta)){	
			$error = "si";	
		}
		
		$this->nivel = $_POST["nivel"];	
		$this->descripcion = $_POST["descripcion"];	
	
		//$opcional = $_POST["opcional"];*/
	
		$consulta = "INSERT INTO nivel VALUES ('','$this->d_nivel','$this->numero')";
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
			header("location: principal.php?id=administracion_nivel&accion=1&edita=1");//Envia la confirmacion de guradado a administracionnivel.php	
			
		}	
	}	//FIN FUNCTION INSERTA NIVEL
	
//------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS DE UN NIVEL
//------------------------------------------------------------------------------------------------
	function edita_datos_nivel(){
		
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {
			
			// 2. Preparamos la consulta
			$this->codigo = $_POST['codigo'];
			$this->d_nivel = $_POST["nivel"];	
			$this->numero = $_POST["descripcion"];				
			
			$consultaEdit = "UPDATE nivel SET d_nivel='$this->d_nivel',numero='$this->numero' WHERE id_nivel='$this->codigo'";
			
			// 3. Ejecutar la consulta
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');
			if(mysql_query($consultaEdit)){
				header("location: principal.php?id=administracion_nivel&accion=2");//Envia la confirmacion de editado a administracionnivel.php	
			}
		}
	}//FIN EDITA DATOS NIVEL
	
//---------------------------------------------------------------------------------------------
//	BORRA LOS DATOS DE UN NIVEL
//--------------------------------------------------------------------------------------------
	function borrar_datos_nivel($codigo){	
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {	
			$this->codigo = $codigo;
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 					
			mysql_query("DELETE FROM nivel WHERE id_nivel=$this->codigo");		
			if(mysql_affected_rows()==1){
				return TRUE;//Envia TRUE si se pudo borrar el registro
			}else{					
				return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
			}
		}
	}//FIN BORRAR DATOS NIVEL
	
}//FIN CLASE NIVEL
?> 
