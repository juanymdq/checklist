<? session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilos/estilo1.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>
<script src="jquery-1.7.2.min.js"></script>
<script src="jquery.js"></script>
<script type="text/javascript">
//ANIMACION DE IMAGEN GIF Y REDIRECCIONAMIENTO
$(document).ready(function() { 
        //Añadimos la imagen de carga en el contenedor      
        $('#content1').prepend('<img id="theImg1" src="imagenes/email.gif"  />');    
        //$('#content2').prepend('<img id="theImg2" src="imagenes/loading.gif"  />');   
        //añadimos el texto con la ubicacion del excel a teransferir     
        var ubic = document.getElementById('dir').value;
        $("#ubicacion").html(ubic);
        $.ajax({
            type: "GET",            
            success: function() {
                //Redirigimos la pagina retrasando segun la cantidad de segundos indicada 
                var ctrl = document.getElementById('ctrl').value;                
                if(ctrl==1){//indica que se cerro la FDP y cerrara los turnos abiertos 
                    setTimeout("location.href= 'principal.php?id=hoja_principal&accion=1&dato=datos'",5000);
                }else{
                    setTimeout("location.href= 'principal.php?id=hoja_principal&accion=2'",5000);
                }
            }
        });
}); 
//ANIMACION DE COUNTDOWN
$(document).ready(function() {

			/* delay function */
			jQuery.fn.delay = function(time,func){
				return this.each(function(){
					setTimeout(func,time);
				});
			};

			jQuery.fn.countDown = function(settings,to) {
				settings = jQuery.extend({
					startFontSize: '76px',
					endFontSize: '18px',
					duration: 1000,
					startNumber: 5,
					endNumber: 0,
					callBack: function() { }
				}, settings);
				return this.each(function() {

					if(!to && to != settings.endNumber) { to = settings.startNumber; }

					//set the countdown to the starting number
					$(this).text(to).css('fontSize',settings.startFontSize);

					//loopage
					$(this).animate({
						'fontSize': settings.endFontSize
					},settings.duration,'',function() {
						if(to > settings.endNumber + 1) {
							$(this).css('fontSize',settings.startFontSize).text(to - 1).countDown(settings,to - 1);
						}
						else
						{
							settings.callBack(this);
						}
					});

				});
			};

			$('#countdown').countDown({
				startNumber: 5
			
			});

		});   
</script>
<script>
function SendHTMLMail(mToMail, mSub) {
   
   try {
       
        Session = new ActiveXObject('Notes.NotesSession');
        
        if(Session != null) {
            
            var valor = document.getElementById('valor').value;
            
            UserName = Session.UserName;
            var usuario = document.getElementById('usuario').value;
            Session.ConvertMIME = false;
            
            MailDbName = UserName.substring(0, 1) + UserName.substring(UserName.indexOf(' ', 1) + 1, UserName.length) + '.nsf';
            
            Maildb = Session.GetDatabase('', MailDbName);
            if(Maildb.IsOpen != true) Maildb.OPENMAIL();
            MailDoc = Maildb.CREATEDOCUMENT();
            MailDoc.Form = 'Memo';
            MailDoc.Subject = 'Tareas Realizadas de: '+usuario;
            
            //DESTINATARIO
            MailDoc.sendto = valor;//CAMBIAR A MDP_OPERADORES
           
            
           //if(mCcpMail != '') MailDoc.copyTo = mCcpMail;
            //if(mCcoMail != '') MailDoc.BlindCopyTo = mCcoMail;
            Stream = Session.CreateStream();
            Body = MailDoc.CreateMIMEEntity();
            
            childHTML = Body.CreateChildEntity();
            //Stream.WriteText(mMsg);
            childHTML.SetContentFromText(Stream, 'text/html; charset = ISO-8859-1', 1731);
            Stream.Close();
            Attach = document.getElementById('dir').value;
            Stream.Open(Attach, 'binary');
            childPDF = Body.CreateChildEntity();
            
            var cuerpo = document.getElementById('dir').value;
            header = childPDF.CreateHeader('Content-disposition');
            header.SetHeaderVal('attachment;filename='+cuerpo);
            childPDF.SetContentFromBytes(Stream, 'application/vnd.ms-excel', 1729);
            Stream.Close();
            
            Session.ConvertMIME = true;
            MailDoc.SAVEMESSAGEONSEND = false;
            MailDoc.Send(false);
            MailDoc.Save(false, true);
        }
    }
    catch(err) {
        if(err == '[object Error]') alert('Error while sending mail, Please check Lotus Notes installed in your system');
        else alert('Error while sending mail');
    }  
}


</script>
<style>
body{
    background-color: aqua;
}
#theImg1{
    width: 100px;
    height: 100px;    
}#theImg2{
    width: 100px;
    height: 100px;    
}
#enviando{
    margin: 100px 0 0 0;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    
}
#ubicacion{
    text-align: center;
    font-size: 15px;
    margin: 20px 0 0 0;
    
}
#content1{
    width: 400px;    
    margin: 100px 0 0px 600px;
}
#content2{
    width: 400px;    
    margin: 100px 0 0px 600px;
}
#countdown{
    margin: 100px 0 0px 640px;     
}

</style>
</head>

<body onload="SendHTMLMail()">

<div id="enviando">Se esta enviando Mail con archivo adjunto desde la siguiente ruta...</div>
<div id="ubicacion"></div>
<div id="content1"></div>

<div id="countdown"></div>

<div id="content2"></div>

<input type="hidden" id="usuario" value="<? echo $_SESSION['usuario'] ?>" />
<?
if(isset($_GET['archivo'])){
    echo "<input type='hidden' value='".$_GET['ctrl']."' id='ctrl' />";    
    echo "<input type='hidden' size='100' value='". $_GET['archivo'] ."' id='dir' />";
}    
include_once("clases/c_config.php");
$conf = new config;
$val="MDE";
$dato = $conf->obtiene_config_x_clave($val);
$fila = mysql_fetch_array($dato);
echo "<input type='hidden' value='".$fila[0]."' id='valor' />";
?>

</body>
</html>







