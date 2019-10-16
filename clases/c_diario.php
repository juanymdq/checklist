<?
//*********CHECK DE TAREAS DIARIAS DE CDC MAR DEL PLATA*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 10/04/2016 -******************************
//---------------------------------------------------------------------------------------------
//INICIO DE CLASE DIARIO
//---------------------------------------------------------------------------------------------
include("clases/conexion.php");

class diario{
    
	//var $codigo_usuario;
	var $codigo_tarea;
    var $codigo_hoja;	
    var $id_usuario;	
	var $hora;	
    var $valor;
    var $estado;
	var $comentario;
    var $fdp;
    var $id_mov;
    var $d_area;
    var $id_area;	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN DIARIO
//----------------------------------------------------------------------------------------------
	function obtiene_datos_tarea ($id){
		$this->codigo_hoja = $id;
		$consulta = "SELECT * FROM log_diario as l,usuario as u WHERE l.estado=1 and l.id_usuario=u.id_usuario and id_hoja=".$this->codigo_hoja;				
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas ($id){
	   $this->codigo_hoja = $id;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario WHERE estado <> 1 and id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS			    
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS PENDIENTES
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_pendientes ($id){
	   $this->codigo_hoja = $id;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario WHERE estado like 'P' and id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS				
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS COMPLETADAS
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_completadas ($id){
	   $this->codigo_hoja = $id;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario WHERE estado like 'TC' and id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS TAREAS DE BILLETES
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_billetes ($id){
	   $this->codigo_hoja = $id;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario WHERE estado like 'GB' and id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LAS TAREAS DE UN USUARIO
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_tareas_usuario ($user,$hoja){
	   $this->id_usuario = $user;
       $this->codigo_hoja = $hoja;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario as l,tareas as t,hoja as h,usuario as u WHERE u.id_usuario=l.id_usuario and l.id_hoja=h.id_hoja and l.id_tarea=t.id_tarea and l.id_usuario=".$this->id_usuario." and l.id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//-------------------------------------------------------------------------------------------------------------------------------------
//	OBTIENE LAS TAREAS DE UN USUARIO
//-------------------------------------------------------------------------------------------------------------------------------------
	function obtiene_estado_tarea ($tarea,$hoja){
	   $this->codigo_tarea = $tarea;
       $this->codigo_hoja = $hoja;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT d_estado FROM log_diario as l, estado as e WHERE l.estado=e.id_estado and id_tarea=".$this->codigo_tarea." and id_hoja=".$this->codigo_hoja;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
        
    function obtiene_tareas_all ($fdp){		
		$consulta = "SELECT * FROM log_diario as l,hoja as h,tareas as t WHERE l.id_hoja=h.id_hoja and l.id_tarea=t.id_tarea";				
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //FUNCIONES DESTINADAS AL REPROCESO DE FECHAS
    //----------------------------------------------------------------------------------------------------
    function obtiene_reproceso_tareas_x_fdp (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM reproceso_tareas WHERE fdp='".$this->fdp."'";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
    function obtiene_reproceso_x_fdp (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT r.fecha_actual,u.usuario,r.estado,r.super FROM reproceso as r, usuario as u WHERE r.id_usuario=u.id_usuario and fdp='".$this->fdp."'";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
    function obtiene_fechas_abiertas_pendientes (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM reproceso as r, usuario as u WHERE r.id_usuario=u.id_usuario ORDER BY fdp DESC";
        // and (estado='ABIERTA' or estado='PENDIENTE')			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    //FUNCIONES DESTINADAS AL MOVIMIENTO DE MAQUINAS
    //----------------------------------------------------------------------------------------------------
    function obtiene_movimientos_x_fdp (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
        $consulta = "SELECT * FROM movimiento_fecha as m, usuario as u,area as a WHERE m.id_usuario=u.id_usuario and m.id_area=a.id_area and m.id_mov=".$this->id_mov;
		//$consulta = "SELECT * FROM movimiento_fecha as m, usuario as u,area as a WHERE m.id_usuario=u.id_usuario and m.id_area=a.id_area and fecha_mov='".$this->fdp."' and a.d_area='".$this->d_area."'";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_id_mov (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT id_mov FROM movimiento_fecha WHERE fecha_mov='".$this->fdp."' and id_area=".$this->id_area;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_datos_mov (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM movimiento_fecha WHERE id_mov=".$this->id_mov;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_tareas_mov (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM log_diario_mov WHERE id_mov=".$this->id_mov;			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_fechas_mov (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM movimiento_fecha as m, area as a WHERE m.id_area=a.id_area";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_mov_sin_completar (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM movimiento_fecha as m, area as a WHERE m.id_area=a.id_area and m.estado='SIN COMPLETAR' ORDER BY m.fecha_mov DESC";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    function obtiene_mov_completos (){	   
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM movimiento_fecha as m, area as a WHERE m.id_area=a.id_area and m.estado='COMPLETO' ORDER BY m.fecha_mov DESC";			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    //-----------------------------------------------------------------------------------------------------
    
    
}//FIN CLASE DIARIO
?> 
