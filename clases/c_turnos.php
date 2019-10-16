<?

//---------------------------------------------------------------------------------------------
//INICIO DE CLASE TURNOS
//---------------------------------------------------------------------------------------------
class turnos{
		
    var $hoja;	
	var $usuario;	
	var $estado;	
	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN TURNO
//----------------------------------------------------------------------------------------------
	function obtiene_estado_turno ($hoja,$usuario){
        $this->hoja=$hoja;
        $this->usuario=$usuario;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT t.testado,h.estado FROM turnos as t,hoja as h WHERE t.id_hoja=h.id_hoja and t.id_usuario=".$this->usuario." and t.id_hoja=".$this->hoja;				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE TURNOS ABIERTOS
    function obtiene_turnos_abiertos (){
        //$this->hoja=$hoja;        
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM turnos as t,usuario as u WHERE testado='ABIERTO' and u.id_usuario=t.id_usuario";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS TURNO
    function obtiene_turnos_x_hoja (){
        //$this->hoja=$hoja;        
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM turnos as t,usuario as u WHERE u.id_usuario=t.id_usuario and t.id_hoja=".$this->hoja;				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS TURNO
 }
 ?>