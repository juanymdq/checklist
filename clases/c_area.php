<?
//*********CHECK DE TAREAS DIARIAS DE CDC MAR DEL PLATA*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 10/04/2016 -******************************
//---------------------------------------------------------------------------------------------
//INICIO DE CLASE AREA
//---------------------------------------------------------------------------------------------
class area{
		
	var $id;
	var $n_area;	
	var $d_area;
    var $nomen_area;	
	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE AREA
//----------------------------------------------------------------------------------------------
	function obtiene_areas (){
		//conexion a base de datos
		mysql_connect("localhost","root","");
		//preparo la consulta a la base
		$consulta = "SELECT * FROM area";				
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 		
		$datos = mysql_query($consulta) or die(mysql_error());							
		return $datos;
	}//FIN OBTIENE DATOS NIVEL
	

//--------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS DE UN NIVEL
//--------------------------------------------------------------------------------------------
	function inserta_area(){
		mysql_connect("localhost","root","");
		mysql_select_db("check");

		$this->n_area = $_POST["n_area"];	
		$this->d_area = $_POST["d_area"];
        $this->nomen_area = $_POST["nomen_area"];	
	
		//$opcional = $_POST["opcional"];*/
	
		$consulta = "INSERT INTO area VALUES ('','$this->n_area','$this->d_area','$this->nomen_area')";
		mysql_query($consulta);	
			
	    header("location: principal.php?id=administracion_area&accion=1&edita=1");//Envia la confirmacion de guradado a administracionnivel.php
		
	}	//FIN FUNCTION INSERTA NIVEL
	
//------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS DE UN NIVEL
//------------------------------------------------------------------------------------------------
	function edita_area(){
		
		mysql_connect("localhost","root","");
			
		$this->n_area = $_POST["n_area"];	
		$this->d_area = $_POST["d_area"];
        $this->nomen_area = $_POST["nomen_area"];			
			
		$consultaEdit = "UPDATE area SET n_area='$this->n_area',d_area='$this->d_area',nomen_area='$this->nomen_area' WHERE id_area='$this->id'";
			
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');
		mysql_query($consultaEdit);
		header("location: principal.php?id=administracion_area&accion=2");//Envia la confirmacion de editado a administracionnivel.php
		
	}//FIN EDITA DATOS NIVEL
	
//---------------------------------------------------------------------------------------------
//	BORRA LOS DATOS DE UN NIVEL
//--------------------------------------------------------------------------------------------
	function borrar_area(){	
		// 1. PHP debe loguearse ante MySQL
		mysql_connect("localhost","root","");		
		mysql_select_db("check") or die('No pudo seleccionarse la BD.');						 					
		mysql_query("DELETE FROM area WHERE id_area=$this->id");		
		if(mysql_affected_rows()==1){
			return TRUE;//Envia TRUE si se pudo borrar el registro
		}else{					
			return FALSE;//Envia FALSE si NO se pudo borrar el registro por estar referenciado
		}
		
	}//FIN BORRAR DATOS NIVEL
	
}//FIN CLASE NIVEL
?> 
