<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

 <style>
    #cont{
        width: 550px;
       /* border: green 1px solid;*/
        margin: 70px 0 0 350px;/*FIREFOX*/
    }
    #r_titulo{
        margin: 30px 1px 1px 1px;        
        font-weight: bold;
        font-size: 16px;
        text-decoration: underline;
    } 
    #lab{
        text-align: right;
    }
    #tex{
        text-align: left;
    }
    #t_back td{
        padding: 20px 0 0 0;
    }
    #msg{
        margin: 20px 0 0 0;
        color: red;
    }
 </style>
</head>

<body>
<?
if(isset($_GET['accion'])){
    switch($_GET['accion']){
        case 1:
            echo "<div id='msg'>Se genero el backup de la BD</div>";
            break;        
    }
}

?>
<div id="cont">
    <div id="r_titulo">BACKUP DE BASE DE DATOS</div>
    <form id="form1" name="form1" method="post" action="backup.php" >
        <table id="t_back">
            <tr>
                <td id="lab">RUTA:</td>
                <td id="tex"><input type="text" id="ruta" name="ruta" size="50" value="C:/xampp/htdocs/checklist/BackupBD"/></td>                          
            </tr>
            <tr>
                <td id="lab">NOMBRE DE ARCHIVO:</td>
                <td id="tex"><input type="text" id="archivo" name="archivo" size="20" value="backup" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="BACKUP" /></td>                
            </tr>
        </table>
    </form>
</div>

</body>

</html>