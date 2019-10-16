<?php
include("clases/conexion.php");
class usuario{
		
	var $codigo;
	var $nombre;	
	var $apellido;
    var $email;
	var $nivel;
	var $legajo;
	var $usuario;
	var $pass;	
	var $optbusca;
	var $txtbusca;	
//---------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN USUARIO
//----------------------------------------------------------------------------------------------------
	function obtiene_datos_usuario (){	
		//preparo la consulta a la base
        if($this->optbusca == 1){//TRAE LOS USUARIOS ACTIVOS
            $query = "SELECT * FROM usuario as u, nivel as n WHERE u.nivel=n.id_nivel and n.id_nivel <> 4";
        }else{//TRAE LOS USUARIOS INACTIVOS
            $query = "SELECT * FROM usuario as u, nivel as n WHERE u.nivel=n.id_nivel and n.id_nivel = 4";
        }								 		
		$datos = mysql_query($query);	
		return $datos;			
	}//FIN OBTIENE DATOS CLIENTE
//---------------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN USUARIO
//----------------------------------------------------------------------------------------------------
function obtiene_datos_de_un_usuario ($cod){
	       
		//conexion a base de datos		
		//mysql_connect("localhost","root","");		
		//preparo la consulta a la base
        $this->codigo = $cod;
		$query = "SELECT * FROM usuario as u, nivel as n 
WHERE u.nivel=n.id_nivel and u.id_usuario=".$this->codigo;			
		//mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($query);	
		return $datos;			
	}//FIN OBTIENE DATOS CLIENTE
//--------------------------------------------------------------------
//OBTIENE PASSWORD
//--------------------------------------------------------------------	
	function obtiene_password(){
		if(mysql_connect("localhost","root","")	){	
			$this->pass = md5($_POST['pass']);
			$this->usuario = $_POST['usuario'];
			$consulta = "SELECT  * FROM usuario AS u INNER JOIN nivel AS n ON u.nivel = n.id_nivel WHERE usuario='".$this->usuario."' and pass='".$this->pass."'";				
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
			$datos = mysql_query($consulta);
			return $datos;					
		}
	}
//--------------------------------------------------------------------
//OBTIENE UN USUARIO
//--------------------------------------------------------------------	
	function obtiene_cod_de_un_usuario ($user){					
			$this->optbusca = $user;
			$cod = extract(mysql_fetch_assoc(mysql_query("SELECT id_usuario FROM usuario WHERE usuario like '$this->optbusca'")));
			return $cod;				
	}//FIN OBTIENE DATOS USUARIO
//--------------------------------------------------------------------
//OBTIENE UN USUARIO POR LEGAJO
//--------------------------------------------------------------------	
function obtiene_usuario_Legajo ($codigo){
		//conexion a base de datos		
		if(mysql_connect("localhost","root","")	){				
			//preparo la consulta a la base								
			$this->codigo = $codigo;
			$consulta = "SELECT id_usuario FROM usuario WHERE legajo=$this->codigo";							
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
			$datos = mysql_query($consulta);	
			return $datos;		
		} //FIN MYSQL_CONNECT
	}//FIN OBTIENE USUARIO
//--------------------------------------------------------------------
//OBTIENE UN USUARIO POR NIVEL
//--------------------------------------------------------------------	
function obtiene_usuario_nivel ($codigo){
		//conexion a base de datos		
		if(mysql_connect("localhost","root","")	){				
			//preparo la consulta a la base								
			$this->nivel = $codigo;
            if($this->nivel==3){//trae solo los supervisores
                $consulta = "SELECT * FROM usuario WHERE nivel=".$this->nivel;			     
            }else{//si es operador, trae todos los usuarios menos los INACTIVOS: nivel==4
                $consulta = "SELECT * FROM usuario WHERE nivel > 1 and nivel <> 4";    
            }							
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
			$datos = mysql_query($consulta);	
			return $datos;		
		} //FIN MYSQL_CONNECT
	}//FIN OBTIENE USUARIO
     //OBTIENE EL LOG DE UN USUARIO
    //ESTA FUNCION ES LLAMADA PARA EL SEGUIMIENTO DE TAREAS DE UN USUARIO
     function obtiene_log ($user,$fchd,$fchh){
	    $this->usuario = $user;
    	//conexion a base de datos
        mysql_connect("localhost","root","");
        if($this->usuario=='todos'){
            $consulta = "SELECT u.nombre,u.apellido,s.tarea,s.fecha,s.accion FROM seguimiento as s,usuario as u WHERE s.id_usuario=u.id_usuario AND s.fecha BETWEEN '$fchd' AND '$fchh'";            
        }else{		
		  $consulta = "SELECT u.nombre,u.apellido,s.tarea,s.fecha,s.accion FROM seguimiento as s,usuario as u WHERE s.id_usuario=".$this->usuario." and s.id_usuario=u.id_usuario and s.fecha BETWEEN '$fchd' AND '$fchh'";
        }				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());;								
		return $datos;
	}//FIN OBTIENE DATOS
//------------------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS DE UN USUARIO
//------------------------------------------------------------------------------------------------------
	function inserta_datos_usuario(){
		mysql_connect("localhost","root","");		
		// INSERTAR UN MOZO
		$this->nombre = $_POST["nombre"];
		$this->apellido = $_POST["apellido"];
        $this->email = $_POST['email'];		
		$this->nivel = $_POST["nivel"];
		$this->usuario = $_POST["usuario"];
		$this->pass = md5($_POST["pass"]);
		$this->legajo = $_POST['legajo'];
	
		$consulta = "INSERT INTO usuario VALUES ('','$this->nombre','$this->apellido','$this->email','$this->nivel','$this->legajo','$this->usuario','$this->pass')";
		mysql_select_db("check");
		mysql_query($consulta);
		header("location: principal.php?id=usuarios_principal&accion=1&edita=1");//Envia la confirmacion de guradado a administracioncliente.php				
	}	//FIN FUNCTION INSERTA USUARIO
	
//-------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS DE UN USUARIO
//-------------------------------------------------------------------------------------------------
	function edita_datos_usuario(){
		
		// 1. PHP debe loguearse ante MySQL
		mysql_connect("localhost","root","");
			
		// 2. Preparamos la consulta
		$this->codigo = $_POST["codigo"];
		$this->nombre = $_POST["nombre"];
		$this->apellido = $_POST["apellido"];
        $this->email = $_POST['email'];
		$this->nivel = $_POST["nivel"];
		$this->usuario = $_POST["usuario"];			
		$this->legajo = $_POST['legajo'];
								
		//print_r($_POST);
		$consultaEdit = "UPDATE usuario SET nombre='$this->nombre',apellido='$this->apellido',email='$this->email',nivel='$this->nivel',legajo='$this->legajo',usuario='$this->usuario'WHERE id_usuario='$this->codigo'";
		
		// 3. Ejecutar la consulta
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');
		if(mysql_query($consultaEdit)){
			header("location: principal.php?id=usuarios_principal&accion=2&edita=1");//Envia la confirmacion de editado a administracioncliente.php	
		} 
	}//FIN EDITA DATOS USUARIO
//-------------------------------------------------------------------------
	function edita_pass_usuario(){
		
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {
			session_start();
			// 2. Preparamos la consulta
			if($_POST['resetea']==0){
				$this->codigo = $_SESSION["id_usuario"];				
			}elseif($_POST['resetea']==1){
				$this->codigo = $_POST["codigo"];
			}
			$this->pass = md5($_POST["pass"]);									
			
			$consultaEdit = "UPDATE usuario SET pass='$this->pass' WHERE id_usuario='$this->codigo'";
			
			// 3. Ejecutar la consulta
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');
			if(mysql_query($consultaEdit)){
				header("location: principal.php");//Envia la confirmacion de editado a administracioncliente.php	
			} 		
		} 
	}//FIN EDITA PASSWORD USUARIO
	
//----------------------------------------------------------------------------------------------------
//	BORRA LOS DATOS DE UN USUARIO
//----------------------------------------------------------------------------------------------------
	function borrar_datos_usuario($codigo){	
		// 1. PHP debe loguearse ante MySQL
		$this->codigo = $codigo;
		$conn = mysql_connect("localhost","root","");
		if (!$conn) {	
			die('No pudo conectar: ' . mysql_error());
		}
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		mysql_query("DELETE FROM usuario WHERE id_usuario=$this->codigo");	
		if(mysql_affected_rows()==1){
			return TRUE; //Envia TRUE si se pudo borrar el registro
		}else{
			return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
		}
	}//FIN BORRAR DATOS USUARIO
	
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
}//FIN CLASE USUARIO
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------