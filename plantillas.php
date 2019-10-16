<!--
//*********PAGINA DE PLANTILLAS DE MAIL PARA OUTLOOK*************
//**************CREADO POR JUAN IGNACIO FERNANDEZ*******************
//**********************- 11/10/2017 -******************************
--> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>CHECKLIST v 2.7</title>

<style>
body {
	background-color:#eaeaea;
	color:#333;
	font:76% Verdana,sans-serif;	
	text-align:center;
	height: 500px;
}
.tituloPl{
    margin-top: 20px;
    font-size: 30px;
    color: #467aa7;
    
    text-shadow: #467aa7;
}
.inner {
	width:980px;
	margin: 0 auto;
	left: 40px;
}
/* Main wrap */
#wrap {clear:both;text-align:left;background:#fff;padding:20px 0 0 0;margin:0}

.espacio{
    height: 10px;
}
/* Headers */
h2, h3, h4 {margin:0 0 15px;color:#666;font-weight:normal;}
/* Sidebar */
#sidebar {
	text-align:left;
	float:left;
	margin:0;
	width:1020px;
	padding:0;
}
#sidebar .left {
	float:left;
	width:170px;
	height: 152px;
	margin: 0 0 -18px 0;
}
#sidebar .rightBilletes {float:left;width:200px;}
#sidebar .rightContables {float:left;width:180px;}
#sidebar .rightCasinos {float:left;width:300px;}
#sidebar .rightVarios {float:left;width:250px;}
#sidebar h2, #sidebar h3 {font-size:1.3em;padding:0;margin:0 0 5px 0;border-bottom:3px solid #ddd;}
#sidebar p, #sidebar ul ,#sidebar .textwidget,#sidebar form,#sidebar table {
	margin: 0 0 17px 0;
	line-height: 1.3em;
	font-size: 1em;
	padding: 0;
	color: #000000;
}
#sidebar table {width:160px}
#sidebar caption {font-size:1.3em;padding:0;margin:0 0 4px 0;text-align:left}
#sidebar ul li {list-style: none;width:158px;padding:0;margin:0 0 2px 0}
#sidebar ul li a {display: block;overflow: visible;padding:2px 0 2px 5px;background-color:#f8f8f8;color:#467aa7;font-weight:400;border:1px solid #eee;border-bottom:1px solid #ddd}
#sidebar ul li a:hover, #sidebar ul li.current_page_item a {border:1px solid #ccc;color:#555;background-color:#eaeaea;border-bottom:1px solid #aaa}
#sidebar ul li.current_page_item li a {background-color:#f8f8f8;color:#467aa7;border:1px solid #eee;border-bottom:1px solid #ddd}
#sidebar ul ul {margin:0;padding:2px 0 0 10px}
#sidebar ul ul li {width:148px}
#sidebar ul ul li a {font-size:0.9em;padding:1px 0 1px 5px}
#sidebar ul ul ul li {width:138px}
#sidebar ul ul ul li a {font-size:0.8em;padding:0 0 0 5px}
#sidebar p.sidebarlinks {line-height:1.6em}
/* Tags */
blockquote {padding:5px 15px 2px 15px;margin:10px;border-left:4px solid #eee;color:#777}
blockquote p {padding:2px 0;margin:0;font-weight:bold}
code {padding:5px;font-size:1.2em;display:block;margin: 5px 0 16px 0;background-color:#f4f4f4;border:1px solid #ccc}
/* Links */
a {color:#467aa7;font-weight:400;text-decoration:none}
a:hover {color:#303030;text-decoration:none}
a img {border:0}
/* Float fix */
.clearfix {overflow:hidden}
* html .clearfix {height:1px;overflow:visible}
* html .clearfix p {overflow:hidden;width:99%}

</style>
<script type="text/javascript">
//trae la fdp en proceso
function trae_fdp(){        
    var coment = $.ajax({
        url:"traecomentarios.php?val=3",
        dataType: 'text',//indicamos que es de tipo texto plano
        async: false,     //ponemos el parámetro asyn a falso            
        type:"POST",
        data:{idt:0,idh:0,idu:0}
    }).responseText;  //ejecuta la consulta y devuelve formato texto
    var x = coment.split('-');
    var xt = x[2]+'/'+x[1]+'/'+x[0];   
    return xt;  
}
//Abre el mail con plantillas predeterminadas de envio a diferentes areas
function abre_plantilla(id){ 
    var mailfdp = trae_fdp(); //obtiene la FDP para colocarsela en los mails 
    /*PLANTILLAS SIN CONTADORES CONTABLES***********************************/ 
    if(id==1){//CASINO CENTRAL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=shiftsmdp@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion CCE - CCR - CRI&body=En caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==2){//CASINO DEL MAR
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=gmontini@boldt.com.ar;GCastell@boldt.com.ar;JMachi@boldt.com.ar;VGimenez@boldt.com.ar;DLavande@boldt.com.ar;MSisti@boldt.com.ar;CPadin@boldt.com.ar;CCordara@boldt.com.ar;HBracco@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion CDM&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==3){//SASSO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jgonzalez@uthgrasasso.com.ar;yukonsasso@gmail.com;consultorapires@hotmail.com;yukontic@gmail.com;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion SASSO&body=En caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==4){//TANDIL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=HJaimon@boldt.com.ar;GMantia@boldt.com.ar;SDiluca@boldt.com.ar;JDeLoren@boldt.com.ar;ASantama@boldt.com.ar;SDurruty@boldt.com.ar;GMazza@boldt.com.ar;MGonzale@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion TANDIL&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");        
    }else if(id==5){//PINAMAR RUTA
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion PINAMAR RUTA&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==6){//PINAMAR BOSQUE
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=CHourcad@boldt.com.ar;GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion PINAMAR BOSQUE&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==7){//MIRAMAR
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=lorlando@boldt.com.ar;APorto@boldt.com.ar;GGirardi@boldt.com.ar;GAldana@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion MIRAMAR&body=En caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==8){//MAR DE AJO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=WMesa@boldt.com.ar;GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion MAR DE AJO&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==9){//MONTE HERMOSO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=gmillahualmonte@gmail.com;GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion MONTE HERMOSO&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==10){//SIERRA DE LA VENTANA
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=guillermoabeck@gmail.com;tecnicoscasinosdlv@gmail.com;ian_92@live.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion SIERRA DE LA VENTANA&body=En caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");
    }else if(id==11){//CASINO VICTORIA
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=servtecnico@casinovictoria.com.ar;spassadore@casinovictoria.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin comunicacion CASINO VICTORIA&body=%0A%0A%0AEn caso de que alguno de los Slots informados en el listado anterior se encuentre en produccion y en juego al publico, y no se logra solucionar el problema de comunicacion, se solicita el envio de informes tecnicos con los contadores contables y de billetes al cierre de la sala.","_blank");    
    /*******VARIOS*********************************************************************/
    }else if(id==12){//ANALISIS COMPLEMENTARIOS
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Analisis Complementarios MDPCORE FDP dd/mm&body=Se detallan analisis complementarios.","_blank");
    }else if(id==13){//ACTUALIZACION FTP
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=dipaunor@loteria.gba.gov.ar;estebces@loteria.gba.gov.ar;recioadr@loteria.gba.gov.ar;gaggiand@loteria.gba.gov.ar;toffedan@loteria.gba.gov.ar;luaceseb@loteria.gba.gov.ar;maldoemi@loteria.gba.gov.ar;vecchgon@loteria.gba.gov.ar;panefra@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=Actualizacion FTP&body=%0A%0A%0ASe copio en FTP, en fecha   /  /   , el archivo:","_blank");
    }else if(id==14){//PATRIMONIO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=perezali@loteria.gba.gov.ar;mdp_operadores@boldt.com.ar&subject=MOVIMIENTOS -AREA- FDP: DD/MM/AAAA&body= Se adjuntan movimientos realizados","_blank");
    }else if(id==34){//SUGAR
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=MesadeAyudaCAS@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=ALTA DE RECLAMO: &body=","_blank");
    }else if(id==35){//CCTV SFE
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=sistemas@casinostafe.com.ar;soporte@casinosantafe.com.ar;cr@casinostafe.com.ar;mdp_operadores@boldt.com.ar&subject=SFE - Pedido de control CCTV - FDP: &body=Sres:%0A%0ASe solicita revision CCTV de FDP: dd/mm realizado la ma&#241;ana del dd/mm","_blank");
    }else if(id==37){//PEDIDO DE IT
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=dlavande@boldt.com.ar;jmachi@boldt.com.ar;shiftsmdp@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=CASINO - PEDIDO DE IT - MAQUINA: XXXX - FDP: &body=Sres:%0A%0ASe detecto una caida de contadores a 0 en la maquina XXXX FDP DD/MM.%0A%0APor favor enviar IT con los trabajos realizados en la misma.%0A%0AGracias!!!","_blank");
    /*PLANTILLAS SIN CONTADORES DE BILLETES****************************************/    
    }else if(id==15){//CASINO CENTRAL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=shiftsmdp@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20CCE%20-%20CCR%20-%20CRI&body=Sres,%0A Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes,%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==16){//CASINO DEL MAR
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=gmontini@boldt.com.ar;GCastell@boldt.com.ar;JMachi@boldt.com.ar;VGimenez@boldt.com.ar;DLavande@boldt.com.ar;MSisti@boldt.com.ar;CPadin@boldt.com.ar;CCordara@boldt.com.ar;HBracco@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20DELMAR&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==17){//SASSO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jgonzalez@uthgrasasso.com.ar;yukonsasso@gmail.com;consultorapires@hotmail.com;yukontic@gmail.com;mdp_operadores@boldt.com.ar&subject=Slots sin contadores de billetes SASSO&body=Sres;Se adjunta listado de Slots sin contadores de billetes; por favor revisar o comentar la situacion del Slot en Sala..","_blank");
    }else if(id==18){//TANDIL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=HJaimon@boldt.com.ar;GMantia@boldt.com.ar;SDiluca@boldt.com.ar;JDeLoren@boldt.com.ar;ASantama@boldt.com.ar;SDurruty@boldt.com.ar;GMazza@boldt.com.ar;MGonzale@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20TANDIL&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==19){//PINAMAR BOSQUE
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=CHourcad@boldt.com.ar;GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20P. %20BOSQUE&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==20){//MIRAMAR
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=lorlando@boldt.com.ar;APorto@boldt.com.ar;GGirardi@boldt.com.ar;GAldana@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots sin contadores de billetes MIRAMAR&body=Sres;Se adjunta listado de Slots sin contadores de billetes; por favor revisar o comentar la situacion del Slot en Sala..","_blank");
    }else if(id==21){//MAR DE AJO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=WMesa@boldt.com.ar;GMantia@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20MAR DE AJO&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==22){//MONTE HERMOSO
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=GMillahu@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20MONTE HERMOSO&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    }else if(id==23){//SIERRA DE LA VENTANA
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=guillermoabeck@gmail.com;tecnicoscasinosdlv@gmail.com;ian_92@live.com.ar;mdp_operadores@boldt.com.ar&subject=Slots%20sin%20contadores%20de%20billetes%20SIERRA&body=Sres;%0A%20Se%20adjunta%20listado%20de%20Slots%20sin%20contadores%20de%20billetes;%20por%20favor%20revisar%20o%20comentar%20la%20situacion%20del%20Slot%20en%20Sala..","_blank");
    /****************************************************************************************************/
    }else if(id==24){//SANTA FE -  ENVIO DE ARCHIVOS FINALES
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=controlcasinos@santafe.gov.ar;mdp_operadores@boldt.com.ar&subject=Envio de archivos finales CAS - FDP: "+mailfdp+"&body=%0A","_blank");
    }else if(id==36){//MELINCUE -  ENVIO DE MAIL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=Computos@casinomelincue.com;mdp_operadores@boldt.com.ar&subject=MLC - Envio de ticket para completar y/o anular.&body=Sres:%0A%0ASe envian ticket en PP para completar","_blank");
    }else if(id==25){//VICTORIA - CIERRE DE FDP
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=AuditoriaMaquinas@casinovictoria.com.ar&subject=Cierre FDP: "+mailfdp+" CASINO VICTORIA&body=Sres.%0A%0ASe encuentra cerrada la FDP: "+mailfdp+" %0A%0A Saludos.","_blank");
    }else if(id==39){//PEDIDO DE IT
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=AuditoriaMaquinas@casinovictoria.com.ar;ggonzalvez@casinovictoria.com.ar;mdp_operadores@boldt.com.ar&subject=CASINO - PEDIDO DE IT - MAQUINA: XXXX - FDP: &body=Sres:%0A%0ASe detecto una caida de contadores a 0 en la maquina XXXX FDP DD/MM.%0A%0APor favor enviar IT con los trabajos realizados en la misma.%0A%0AGracias!!!","_blank");        
    }else if(id==26){//PARAGUAY - ENVIO DE CONCILIACION
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=Jcf.americangaming@gmail.com;sargumedo@7saltos.com;spuente@boldt.com.ar;jbecker@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Resumen conciliacion - 7 Saltos&body=%0A%0A%0A","_blank");
    }else if(id==27){//OVALLE - PEDIDO DE ANULACION
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=patricio.orrego@ovallecasinoresort.cl;computos@ovallecasinoresort.cl;Bunker@ovallecasinoresort.cl;mdp_operadores@boldt.com.ar;spuente@boldt.com.ar&subject=OVALLE FDP: "+mailfdp+" - Pedido de anulacion y/o completado de PP &body=%0ABunker:%0A%0ASe solicita completar los siguientes TK que estan en Proceso de Pago.%0A%0A* Se adjunta imagen solo con los TK que se deben completar, el resto de los que puedan aparecer en pantalla no deben completarse.%0A%0A* Se realiza desde el Menu CASTITO: control Operativo / tratamiento de TK en PP para FDP de ayer.%0A%0ARealizado esto, las diferencias en conciliacion compensaran con fecha de hoy.","_blank");
    }else if(id==28){//OVALLE - ENVIO DE CONCILIACION
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=computos@ovallecasinoresort.cl;JSalaber@boldt.com.ar;spuente@boldt.com.ar;Patricio.orrego@OvalleCasinoResort.cl;mdp_operadores@boldt.com.ar&subject=FDP: "+mailfdp+" - CONCILIACION OVALLE &body=%0A","_blank");
    }else if(id==38){//OVALLE - ENVIO DE REVISION DE MAQUINAS
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=computos@ovallecasinoresort.cl;tecnicos@ovallecasinoresort.cl;mdp_operadores@boldt.com.ar&subject=FDP: "+mailfdp+" - REVISION DE MAQUINA &body=%0A","_blank");
    }else if(id==29){//CAMBIO DE CINTAS Y CTRL DE BACKUP
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=Cambio de Cintas - Control de Backups dd/mm/AAAA&body=%0A","_blank");
    }else if(id==30){//ESPERADO TANDIL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=casinotandil@loteria.gba.gov.ar;HJaimon@boldt.com.ar;SDiluca@boldt.com.ar;ASantama@boldt.com.ar;SDurruty@boldt.com.ar;WVulcano@boldt.com.ar;GMazza@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Esperado CTA FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");
    }else if(id==31){//GANANCIA POR CONTADORES A TRILENIUM
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=jmamczak@boldt.com.ar;operador@trileniumcasino.com.ar;mdp_operadores@boldt.com.ar&subject=Ganancia por Contadores y Resultado de Contadores con Promo Ticket Casinos Bs. As. FDP: "+mailfdp+" &body=%0A%0A%0A","_blank");
    }else if(id==32){//PROGRE SEMANAL
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=amendoza@boldt.com.ar;jMamczak@boldt.com.ar;mdp_operadores@boldt.com.ar&subject=Progresivos Semanal Pcia. Bs. As.&body=%0A ","_blank");
    }else if(id==33){//ENVIO DIFERENCIAS BILLETES MDPCORE
        window.open("https://outlook.office.com/owa/?path=/mail/action/compose&to=mdp_operadores@boldt.com.ar&subject=FDP: "+mailfdp+" DIF. BILL CCE $0 ; CDM $0 Y CSA $ 0  &body= ","_blank");
    }
}

</script>
</head>
<body>

<div class="tituloPl"><u>PLANTILLAS DE MAIL OUTLOOK</u></div>
<div id="wrap">
  <div class="inner">
    <div id="sidebar">
      <div class="rightContables">
        <h2>Sin Contadores </h2>
        <p class="sidebarlinks"> 
            <a href="javascript:void(0);" onclick="abre_plantilla(1);">1-Casino Central </a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(2);">2-Casino Del Mar  </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(3);">3-Casino Sasso  </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(4);">4-Casino Tandil </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(5);">5-Casino P. Ruta </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(6);">6-Casino P. Bosque </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(7);">7-Casino Miramar </a><br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(8);">8-Casino Mar de Aj&oacute; </a><br />
    		9-Casino Necochea <br />
    		<a href="javascript:void(0);" onclick="abre_plantilla(9);">10-Casino Monte Hermoso </a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(10);">11-Casino S. de la Ventana </a><br />      
            <a href="javascript:void(0);" onclick="abre_plantilla(11);">12-Casino Victoria</a><br/>    
      </p>
      </div>
      <div class="rightVarios">
        <h2>Varios</h2>
        <p class="sidebarlinks"> 
            <a href="javascript:void(0);" onclick="abre_plantilla(12);">1-An&aacute;lisis Complementarios </a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(13);">2-Actualizaci&oacute;n FTP </a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(14);">3-Patrimonio</a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(29);">4-Cambio de cintas y ctrl de backup.</a><br />
            <a href="javascript:void(0);" onclick="abre_plantilla(34);">5-Generaci&oacute;n de reclamo SUGAR.</a><br />            
            <a href="javascript:void(0);" onclick="abre_plantilla(37);">5-Pedido de Informe T&eacute;cnico.</a><br />
        </p>
        <br class="clear" />
      </div>
      <div class="rightBilletes">
        <h2>Control Billetes </h2>
        <p class="sidebarlinks"> 
        <a href="javascript:void(0);" onclick="abre_plantilla(15);">1-Casino Central</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(16);">2-Casino Del Mar</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(17);">3-Casino Sasso</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(18);">4-Casino Tandil</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(19);">5-Casino P. Bosque</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(20);">6-Casino Miramar</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(21);">7-Casino Mar de Aj&oacute;</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(22)">8-Casino Monte Hermoso</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(23)">9-Casino S. de la Ventana</a><br/>
        </p>
      </div>
      <div class="rightCasinos">
        <h2>SANTA FE</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(24);">1-Env&iacute;o de archivos finales a Loter&iacute;a Santa Fe</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(35);">2-Pedido de CCTV a Santa Fe.</a><br />
        <div class="espacio"></div>
        <h2>MELINCUE</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(36);">1-Env&iacute;o de Ticket para anular o completar</a><br/>       
        <div class="espacio"></div>    
        <h2>VICTORIA</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(25);">1-Enviar confirmaci&oacute;n de cierre de FDP</a><br/>        
        <a href="javascript:void(0);" onclick="abre_plantilla(39);">2-Pedido de Informe T&eacute;cnico</a><br/>
        <div class="espacio"></div> 
        <h2>7 SALTOS PARAGUAY</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(26);">1-Env&iacute;o de resumen de conciliaci&oacute;n</a><br/>  
        <div class="espacio"></div> 
        <h2>OVALLE</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(27);">1-Pedido de anulaci&oacute;n y/o completado de PP</a><br/>         
        <a href="javascript:void(0);" onclick="abre_plantilla(28);">2-Env&iacute;o de resumen de conciliaci&oacute;n</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(38);">3-Pedido de revisi&oacute;n de maquina</a><br/>
        <div class="espacio"></div>
        <h2>CASINOS PCIA. BS. AS.</h2>
        <a href="javascript:void(0);" onclick="abre_plantilla(30);">1-Env&iacute;o de Esperado billetes Tandil</a><br/>         
        <a href="javascript:void(0);" onclick="abre_plantilla(31);">2-Env&iacute;o de Ganancia por contadores a Trilenium</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(32);">3-LUNES. Env&iacute;o de progresivos semanal</a><br/>
        <a href="javascript:void(0);" onclick="abre_plantilla(33);">4-Env&iacute;o de diferencias de Billetes</a><br/>
        <div class="espacio"></div>
      </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
    <p>&nbsp;</p>
  </div>
  <p><br class="clear" /></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<!--
a = &aacute;

é = &eacute;

í = &iacute;

ó = &oacute;

ú = &uacute;

ñ = &ntilde;
-->
</body>
</html>