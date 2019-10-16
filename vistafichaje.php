<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="js/jquery.min.js"></script>
<script>
//funcionalidad del boton aceptar del formulario justificaciion de salida
var idf;
$(document).ready(function(){
    $('#btnaceptar').click(function(){
        var texto = document.getElementById('textoj').value;    //coloca el texto de la justificacion
        if(texto==''){
            alert('Debe colocar una justificacion');
        }else{
            var js=texto;   //en variable js coloca la justificacion
            //val=5 indicara que modificara el registro con la justificacion
            $.ajax({url:"funcionalidadfichaje.php?val=5",cache:false,type:"POST",data:{id:idf,f:0,he:0,hs:0,js:js}});   //Modifica los datos a la bd sin recargar la pagina
            setTimeout(function(){//retarda el guardado en bd
                window.location.reload(1);
            }, 100);            
        }
    });
    $('#btncancelar').click(function(){
        $('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        habilita_ctrl();//recarga la pagina por la cancelacion del modal
        return false;
    });
});
function abre_justificacion(varidf,fch){        
        idf = varidf;       
        tempf = fch.split('-');
        textf = tempf[2]+'/'+tempf[1]+'/'+tempf[0];
        controlar_form();        
        $('#popupe').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
        document.getElementById('titulodiv').innerHTML = 'JUSTIFICAR ENTRADA/SALIDA';//COLOCA EL TITULO A MOSTRAR        
        document.getElementById('subtitulo').innerHTML = 'FECHA: ' + textf;//COLOCA EL SUBTITULO A MOSTRAR
}
function controlar_form(){
    //pinta el fondo de color gris transparente
    $("body").css({'position':'fixed','left':'0','top':'0','background-color':'#ccc','opacity':'0.6','filter':'alpha(opacity=60)'});
}
function habilita_ctrl(){
    window.location.href = 'principal.php?id=vistafichaje';
}

</script>
<style>
    h2{
        margin: 5px 0 0 0;
    }
    p{color: red}
    #t_fichaje td{
        padding: 10px 20px 10px 20px;
    }
    /*TABLA DE 5 ULTIMOS FICHAJES*/
    #d_fichaje{
        width: 950px;
        height: 210px;
        /*border: green 1px solid;*/
        margin: -0.5em 0 0 180px;
        font-size: 20px;
        color: green;
        padding: 0px 0px 0px 0px;
    }
    #t_muestra_fichaje{
        margin: 5px 0 0 0;
        padding: 0 5px 0 0;
    }
    #td_hora{
        border-top:green 1px solid;
        border-left:green 1px solid;
        border-right:green 1px solid;
        border-bottom:green 1px solid;
        color: blue;
        padding: 0 20px 0 20px;
        width: 100px;
    }
    #td_entrada{
        border-top:green 1px solid;
        border-left:green 1px solid;
        border-right:green 1px solid;
        border-bottom:green 1px solid;
        padding: 0 5px 0 5px;
        width: 180px;
    }
    #td_salida{
        border-top:green 1px solid;
        border-left:green 1px solid;
        border-right:green 1px solid;
        border-bottom:green 1px solid;
        color: red;
        padding: 0 5px 0 5px;
        width: 180px;
    }
    #td_juste{
        border-top:green 1px solid;
        border-left:green 1px solid;
        border-right:green 1px solid;
        border-bottom:green 1px solid;
        padding: 0 20px 0 20px;
        width: 300px;
    }
    /*-------------------------------*/
    #d_titulo{
        width: 500px;
        height: 30px;
        border: green 1px solid;
        margin: 20px 0 30px 350px;
        font-size: 20px;
        color: green;
        font-weight: bold;
    }
    #d_exportar{
        width: 200px;
        height: 50px;
        border: green 1px solid;
        margin: 20px 0 0 0;
        font-size: 30px;
        color: green;
        padding: 5px 5px 5px 5px;
    }
    /*--------FORM MODAL DE PENDIENTES-----------------------*/

    #popupe {
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1001;
    }
    #popups {
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1001;
    }
    .content-popup {
        margin:0px auto;
        margin-top:120px;
        position:relative;
        padding:10px;
        width:360px;
        min-height:10px;
        border-radius:4px;
        background-color: black;
        box-shadow: 0 2px 5px #666666;
    }

    .content-popup h2 {
        color:#48484B;
        border-bottom: 1px solid #48484B;
        margin-top: 0;
        padding-bottom: 4px;
    }
    .popup-overlay {
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 999;
        display:none;
        background-color: #777777;
        cursor: pointer;
        opacity: 0.7;
    }
    #textoj{
        resize: none;
        margin: 0 0 0 5px;
    }
    #baceptar{
        float: left;
        margin: 20px 0 0 70px;

    }
    #bcancelar{
        margin: 20px 0 0 70px;
    }
    #fmodal{
        padding: 5px 55px 5px 5px;
        background-color: aqua;
        width: 340px;
        height: 230px;
    }
    h2{
        font-size: 16px;
    }
    #titulodiv{
        font-size: 16px;
        font-weight: bold;
        padding-bottom: 10px;
        margin: 0 0 0 10px;
    }
    #subtitulo{
        font-size: 12px;
        font-weight: bold;
        padding-bottom: 5px;
    }
    /*-------------------------------*/
</style>

</head>

<body>
<div id="d_titulo">ULTIMOS 8 INGRESOS/EGRESOS A CDC</div>

<p>Click en celda justificaci&oacute;n para justificar entrada/salida</p>
<div id="d_fichaje">
    <?
    include('clases/c_fichaje.php');
    $mficha = new fichaje;
    $res = $mficha->obtiene_8_fichajes();
    ?>

    <table id="t_muestra_fichaje">
        <tr id="tr_ficha">
            <td id="td_hora">FECHA</td>
            <td id="td_entrada">HORA ENTRADA</td>
            <td id="td_salida">HORA SALIDA</td>
            <td id="td_juste">JUSTIFICACION</td>
        </tr>
        <?
        while($fila = mysql_fetch_array($res)){?>
            <tr>
                <td id="td_hora"><? echo date('d/m/Y',strtotime($fila[2])) ?></td>
                <td id="td_entrada"><? echo $fila[3] ?></td>
                <td id="td_salida"><? if($fila[4]=='00:00:00') {echo '-';}else{echo $fila[4];} ?></td>
                <td id="td_juste" onclick="abre_justificacion(<?php echo $fila[0]?>,'<?php echo $fila[2]?>')"><? echo $fila[5] ?></td>
            </tr>
        <?
        }
        ?>
    </table>
</div>
<div id="popupe" style="display: none;">
    <div class="content-popup">
        <div id="fmodal">            
            <div id="titulodiv"></div>
            <div id="subtitulo"></div>
            <div><textarea cols="39" rows="4" id="textoj" ></textarea></div>
            <div id="baceptar"><input type="button" id="btnaceptar" value="Aceptar" /></div>
            <div id="bcancelar"><input type="button" id="btncancelar" value="Cancelar" /></div>
        </div>
    </div>
</div>
</body>
</html>