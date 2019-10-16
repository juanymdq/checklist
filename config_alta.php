<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Configuracion</title>


<style>
h2{
    margin: 20px 0 0 0;
}
#tusuario{
    margin: 30px 0px 50px 420px;/*FIREFOX*/
    /*border: green 3px solid;*/
    width: 350px;
    
}
#tusuario th{
    font-size: 10px;
    margin: 0px 0px 50px 0px;
    text-align: right;
    
}
#tusuario td{
    text-align: left;
    padding: 15px 0 0 0;
}
#tdBoton1{   
    padding: 0 0 5px 10px;
}
#tdBoton2{   
    padding: 0 0 5px 170px;
}
</style>
</head>

<body>

  			
<br />
<br /> 


<center><h2>ALTA DE PARAMETRO</h2></center>
<form id="fomr1" name="form1" method="post" action="configura.php">
      <table id="tusuario">              
            <tr>                  	 
              <td><input type="hidden" name="edita" id="edita" value="<?php echo $_GET['edita'];?>" /></td>  
            </tr>
            <tr>
                <th><label for="decripcion">Descripcion:</label></th>   			 
                <td><input type="text" name="d_config" id="d_config" size="30"/></td>
            </tr>
            <tr>
                <th><label for="valor">Valor:</label></th>   
                <td><input type="text" name="valor" id="valor" size="20"/></td>
            </tr>
            <tr>
                <th><label for="clave">Palabra Clave:</label></th>   
                <td><input type="text" name="clave" id="clave" size="5"/></td>
            </tr>            
              <tr>
                    <tr height="30px">
                        <td></td>
                        <td></td>
                    </tr>    
              </tr>
            <tr>
                <td id="tdBoton1"><input type="submit" style='width:70px; height:25px'  name="guardar" id="guardar" value="Guardar" /></td>
                <td id="tdBoton2"><a href="principal.php?id=config_principal&edita=1" >Volver</a></td>
            </tr>
    </table>
</form> 
              
</body>
