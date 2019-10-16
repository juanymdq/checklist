<?
//*********CHECK DE TAREAS DIARIAS DE CDC MAR DEL PLATA*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 10/04/2016 -******************************
//---------------------------------------------------------------------------------------------
//INICIO DE CLASE CONFIGURACION
//---------------------------------------------------------------------------------------------
class config{
		
	var $codigo;
	var $d_config;	
	var $valor;	
    var $clave;
	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS 
//----------------------------------------------------------------------------------------------
	function obtiene_datos_config (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM config";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
  }
//---------------------------------------------------------------------------------------------
	function obtiene_una_config ($cod){
	   $this->codigo=$cod;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM config WHERE id_config=".$this->codigo;				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}
//-------------------------------------------------------------------------------------------	
	function obtiene_config_x_clave ($cl){
	   $this->clave=$cl;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT valor FROM config WHERE clave like '".$this->clave."'";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}				
//--------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS
//--------------------------------------------------------------------------------------------
	function inserta_datos_config(){
		mysql_connect("localhost","root","");
		mysql_select_db("check");
		$this->d_config = $_POST["d_config"];	
		$this->valor = $_POST["valor"];	
        $this->clave = $_POST["clave"];
	
		$consulta = "INSERT INTO config VALUES ('','$this->d_config','$this->valor','$this->clave')";
		mysql_query($consulta);	
	
        header("location: principal.php?id=config_principal&accion=1&edita=1");//Envia la confirmacion de guradado a administracionnivel.php	
			
			
	}	//FIN FUNCTION INSERTA
	
//------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS
//------------------------------------------------------------------------------------------------
	function edita_datos_config(){
		
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {
			
			// 2. Preparamos la consulta
			$this->codigo = $_POST['codigo'];
			$this->d_config = $_POST["d_config"];	
            $this->valor = $_POST["valor"];
            $this->clave = $_POST["clave"];					
			
			$consultaEdit = "UPDATE config SET config_descr='$this->d_config',valor='$this->valor',clave='$this->clave' WHERE id_config='$this->codigo'";
			
			// 3. Ejecutar la consulta
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');
			if(mysql_query($consultaEdit)){
				header("location: principal.php?id=config_principal&accion=2");//Envia la confirmacion de editado a administracionnivel.php	
			}
		}
	}//FIN EDITA DATOS
	
//---------------------------------------------------------------------------------------------
//	BORRA LOS DATOS
//--------------------------------------------------------------------------------------------
	function borrar_datos_config($codigo){	
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {	
			$this->codigo = $codigo;
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 					
			mysql_query("DELETE FROM config WHERE id_config=$this->codigo");		
			if(mysql_affected_rows()==1){
				return TRUE;//Envia TRUE si se pudo borrar el registro
			}else{					
				return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
			}
		}
	}//FIN BORRAR DATOS 
	
}//FIN CLASE
?> 
