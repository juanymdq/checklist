<?php

//---------------------------------------------------------------------------------------------
//INICIO DE CLASE FICHAJE
//---------------------------------------------------------------------------------------------
class fichaje{
		
	var $usuario;		
	var $fecha;
    var $hentrada;
    var $hsalida;
    var $justificacion;	
	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS
//----------------------------------------------------------------------------------------------
	function obtiene_ficha_x_usuario (){
	    //$this->usuario = $user;
        //$this->fecha = $fch;
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM fichaje WHERE id_usuario=".$this->usuario." and fecha='".$this->fecha."'";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
    function obtiene_8_fichajes (){
	    $this->usuario = $_SESSION['legajo'];
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base        
        $consulta = "SELECT * FROM fichaje WHERE id_usuario=".$this->usuario." ORDER BY id_fichaje DESC LIMIT 8";
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
    function obtiene_ultimo_fichaje (){
	    $this->usuario = $_SESSION['legajo'];
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base        
        $consulta = "SELECT * FROM fichaje WHERE id_usuario=".$this->usuario." ORDER BY id_fichaje DESC LIMIT 1";
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
    
    function obtiene_ficha ($user,$fchd,$fchh){
	    $this->usuario = $user;
    	//conexion a base de datos
        mysql_connect("localhost","root","");
        if($this->usuario=='todos'){
            $consulta = "SELECT u.usuario,f.fecha,f.hentrada,f.hsalida,f.justificacion FROM fichaje as f,usuario as u WHERE f.id_usuario=u.legajo AND f.fecha BETWEEN '$fchd' AND '$fchh'";
        }else{		
		  $consulta = "SELECT u.usuario,f.fecha,f.hentrada,f.hsalida,f.just_entrada,f.just_salida FROM fichaje as f,usuario as u WHERE f.id_usuario=".$this->usuario." and f.id_usuario=u.id_usuario and fecha BETWEEN '$fchd' AND '$fchh'";
        }				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS

 }
 ?>