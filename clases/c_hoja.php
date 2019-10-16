<?
//---------------------------------------------------------------------------------------------
//INICIO DE CLASE DIARIO
//---------------------------------------------------------------------------------------------
include("clases/conexion.php");
if(!class_exists('YourClass')){ include("clases/c_turnos.php"); }
class hoja{
	var $codigo_hoja;
    var $codigo_usuario;
	var $fecha;	
	var $estado;
    var $hora;
    	
//-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN DIARIO
//----------------------------------------------------------------------------------------------
	function obtiene_fechas_hoja (){
		//preparo la consulta a la base
		$consulta = "SELECT * FROM hoja";				
		$datos = mysql_query($consulta);						
		return $datos;
	}//FIN OBTIENE DATOS NIVEL
    //-----------------------------------------------------------------------------------------------
//	OBTIENE LOS DATOS DE UN DIARIO
//----------------------------------------------------------------------------------------------
	function obtiene_hoja_usuarios (){
		//preparo la consulta a la base
        $fch = $_POST['date'];
        $dia = substr($fch,0,2);
        $mes = substr($fch,3,2);
        $ano = substr($fch,6,4);
        $this->fecha = $ano.'-'.$mes.'-'.$dia;
		$consulta = "SELECT h.id_hoja,h.fdp,u.nombre,u.apellido,h.estado FROM hoja as h, usuario as u WHERE h.id_usuario=u.id_usuario and h.estado='CERRADA' and h.fdp='".$this->fecha."'";				
		$datos = mysql_query($consulta);
        $fila = mysql_fetch_array($datos);
        if(empty($fila)){
            header("location: principal.php?id=buscar_check&estado=0");
        }else{
            //session_unset();
            session_start();
            $_SESSION['id_hoja']=$fila['id_hoja'];
            $_SESSION['fdp'] = date('d/m/Y',strtotime($fila['fdp']));
            $_SESSION['fdpsf'] = $fila['fdp'];         
            $_SESSION['estado'] = $fila['estado'];
            header("location: check.php?ctrl=1");//        	
        } 
       //header("location: principal.php?id=buscar_check&estado=estadofdp");*/   
        //header("location: buscar_check.php?estado=estadofdp");//Envia la confirmacion de guradado a administracionnivel.php		
		//return $datos;
	}//FIN OBTIENE DATOS NIVEL
 //-----------------------------------------------------------------------------------------------
//	OBTIENE LA ULTIMA FECHA ABIERTA
//----------------------------------------------------------------------------------------------   
	function obtiene_ultima_fecha_abierta_hoja (){
		//preparo la consulta a la base
		$consulta = "SELECT id_hoja,MAX(fdp) as fdp FROM hoja WHERE estado like 'ABIERTA'";        		
		$datos = mysql_query($consulta);						
        
       // $_SESSION['fdp'] = date('d/m/Y',strtotime($fila['fdp']));
        
                
      //  $_SESSION['estado'] = $fila['estado'];
		return $datos;
	}//FIN OBTIENE DATOS NIVEL	
  //-----------------------------------------------------------------------------------------------
//	OBTIENE LA ULTIMA FECHA CERRADA
//----------------------------------------------------------------------------------------------   
	function obtiene_ultima_fecha_cerrada (){
		//preparo la consulta a la base
		$consulta = "SELECT MAX(fdp) FROM hoja WHERE estado like 'CERRADA'";			
		$datos = mysql_query($consulta);						
		return $datos;
	}//FIN OBTIENE DATOS NIVEL	
//-----------------------------------------------------------------------------------------------
//	OBTIENE ESTADO DE UNA FECHA DE PRODUCCION
//----------------------------------------------------------------------------------------------
    function obtiene_estado_fecha ($val){
		//preparo la consulta a la base
        //$fch = date('Y-m-d',strtotime($val));
		$consulta = "SELECT * FROM hoja WHERE fdp = '".$val."'";				
		$datos = mysql_query($consulta);						
		return $datos;
	}//FIN OBTIENE DATOS NIVEL		
//-----------------------------------------------------------------------------------------------
//	OBTIENE ESTADO DE UNA FECHA DE PRODUCCION
//----------------------------------------------------------------------------------------------
    function obtiene_datos_segun_hoja ($val){
		//preparo la consulta a la base
        //$fch = date('Y-m-d',strtotime($val));
		$consulta = "SELECT * FROM hoja as h,usuario as u WHERE h.id_usuario=u.id_usuario and h.id_hoja = '".$val."'";				
		$datos = mysql_query($consulta);						
		return $datos;
	}//FIN OBTIENE DATOS NIVEL	
    //-----------------------------------------------------------------------------------------------
//	OBTIENE HOJAS CERRADAS
//----------------------------------------------------------------------------------------------
    function obtiene_hojas_cerradas (){
		//preparo la consulta a la base
        //$fch = date('Y-m-d',strtotime($val));
		$consulta = "SELECT * FROM hoja as h, usuario as u WHERE h.id_usuario=u.id_usuario and estado like 'CERRADA' ORDER BY fdp desc";				
		$datos = mysql_query($consulta);						
		return $datos;
	}//FIN OBTIENE DATOS NIVEL					
//--------------------------------------------------------------------------------------------
//	AGREGA LOS DATOS DE UNA HOJA
//--------------------------------------------------------------------------------------------
	function inserta_datos_hoja(){
        
        $fch = $_POST['date'];
        $ctrl = $_GET['control'];
        $dia = substr($fch,0,2);
        $mes = substr($fch,3,2);
        $ano = substr($fch,6,4);
        $fch = $ano.'-'.$mes.'-'.$dia;
       // $_SESSION['fdp'] = $fch;
        session_start();
        
        $res = $this->obtiene_estado_fecha($fch);
        $this->codigo_usuario = $_SESSION['id_usuario'];
        if(mysql_num_rows($res)==0){
            $this->fecha = $fch;             		
            $this->estado = "ABIERTA";
            $consulta = "INSERT INTO hoja VALUES ('','$this->fecha','$this->estado','$this->codigo_usuario','')";            
            mysql_query($consulta);
        }
        $res = $this->obtiene_estado_fecha($fch);
        $fila = mysql_fetch_array($res);
        $_SESSION['fdp'] = date('d/m/Y',strtotime($fila['fdp']));
        $_SESSION['fdpsf'] = $fila['fdp']; 
        $_SESSION['id_hoja'] = $fila[0];
        $tid=$fila[0];
        $_SESSION['estado'] = $fila['estado'];
        //guarda el turno del usuario
        $tconsulta = "INSERT INTO turnos VALUES ('$tid','$this->codigo_usuario','ABIERTO')";
        mysql_query($tconsulta);
        //ctrl sirve para controlar si se esta buscando un check
        //si es 1 deshabilita los context menu
        header("location: check.php?ctrl=0");//Envia la confirmacion de guradado a administracionnivel.php        	
		
	}	//FIN FUNCTION INSERTA HOJA
  
//------------------------------------------------------------------------------------------------
//	EDITA LOS DATOS DE LA HOJA
//------------------------------------------------------------------------------------------------
	function edita_datos_hoja(){
		session_start();
		// 1. PHP debe loguearse ante MySQL
		if (mysql_connect("localhost","root","")) {
			
			// 2. Preparamos la consulta
			$this->codigo_hoja = $_SESSION['id_hoja'];
			$this->estado = 'CERRADA';								
			$this->codigo_usuario = $_SESSION['id_usuario'];
			$consultaEdit = "UPDATE hoja SET estado='$this->estado',id_usuario='$this->codigo_usuario' WHERE id_hoja='$this->codigo_hoja'";
			
			// 3. Ejecutar la consulta
			mysql_select_db("check") or die('No pudo seleccionarse la BD.');
            //CIERRA LOS TURNOS ABIERTOS OLVIDADOS
            $turno = new turnos;
            //Trae todas las sesiones abiertas para informarlas en HOJA PRINCIPAL
            $res = $turno->obtiene_turnos_abiertos();            
            while($fila = mysql_fetch_array($res)){
                $dato .=$fila['nombre']." ".$fila['apellido']." - ";
            }            
            //Cierra todas las sesiones de la fecha abiertas
            $turnosEdit = "UPDATE turnos SET testado='CERRADO'";
            mysql_query($turnosEdit);
            //------------------------------------------         
			if(mysql_query($consultaEdit)){
				header("location: principal.php?id=hoja_principal&accion=1&val=$dato");//Envia la confirmacion de editado a administracionnivel.php
                unset($_SESSION['fdp']);	
                unset($_SESSION['estado']);
			}
		}
	}//FIN EDITA DATOS HOJA
}//FIN CLASE HOJA
?> 
