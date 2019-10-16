<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Codificación MD5</title>

</head>

<body>
<h4>Ingrese el texto a codificar con MD5</h4>
<form id="form1" name="form1" method="post" action="md5.php">
     <input type="text" name="usuario" id="usuario" size="50" />
    <input type="submit" name="enviar" id="enviar" value="Aceptar" />
</form> 
</br>

<?
	if(isset($_POST['enviar'])){
		echo "<h4>Codificación MD5 para: <h2>". $_POST['usuario'] ."</h2></h4>";
		echo md5($_POST['usuario']);		
	
	}
?>

</body>
</html>



