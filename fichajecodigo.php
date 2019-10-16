
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/jquery.min.js"></script>
    <title>FICHAJE v 1.0</title>
    <style type="text/css">

        html {
            background: url(imagenes/imagen2.jpg) no-repeat center center fixed;
            background-size: cover;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
        h1{font-size:48px;color: #f5f5f5}
        #legajo {font-size:56px;text-align:center;font-weight:400}
        #tLegajo{margin-top:2px;margin-bottom: 50px; text-align: center}
        #reloj{font-size:58px;text-align:center;color: #ffffff}
        #fecha{
            /*-webkit-text-stroke: 1px white;*/
            font-size:38px;text-align:center;color: #ffffff}
        #datosU{
            width: 600px;
            height: 100px;
            margin: 0 auto;
        }
        #nombre, #leg{font-size: 45px;color: #ffffff}
        #horai{font-size: 55px;color: #ffff00}
        #derechos{font-size: 9px;color: white;}
    </style>
    <script>
        var id; //legajo
        var f;  //variable fecha
        var he; //variable hora entrada
        var hs; //variable hora salida
        var js; //variable de justificacion
        var ie; //variable para informar si ingreso o salio
        var tm;
        var temptx;
        $(document).ready(function(){
            $("#datosU").hide();//OCULTA EL DIV QUE MUESTRA DATOS DE INGRESO/EGRESO
            setInterval(muestraReloj, 1000);
            $("#legajo").val('');
            $("#legajo").focus();
        });
        //----------------------------------------------------------------------------
        //LEEE CODIGO DE BARRAS Y REALIZA EL INGRESO/EGRESO AL TURNO
        function validar(e,v) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==13){

                id = v;//legajo
                leg = obtiene_legajo();//OBTIENE EL LEGAJO DEL USUARIO
                if(id==''){
                    alert('DEBE INGRESAR UN LEGAJO!!!');
                }else if(leg == ''){
                    alert('LEGAJO - ' + id + ' - INEXISTENTE!!!');
                    $("#legajo").val('');//VACIA EL INPUT LEGAJO
                    $("#legajo").focus();//COLOCA EL FOCO EN EL INPUT LEGAJO
                }else{
                    var res = obtiene_fecha_hora_server();//OBTIENE LA HORA DEL SERVIDOR
                    var fh = res.split(' ');//viene junto y lo separa 2019-04-09 11:00:00
                    f = fh[0];//fecha
                    fechaF = formatea_fecha();//fecha para mostrar en mensaje de alerta
                    he = fh[1];//hora
                    var ves = verifica_e_s();//con fecha y legajo controla el ingreso/egreso
                    temptx = ves.split('-');
                    tm = temptx[0];
                    switch(parseInt(tm)){
                        case 0 ://si es ==0 NO EXISTE INGRESO
                            //GUARDA EL INGRESO EN LA BD-------------------------------------------------------------------------
                            $.ajax({url:"funcionalidadfichaje.php?val=0",cache:false,type:"POST",data:{id:id,f:f,he:he,hs:0,js:0}});
                            ie = 'i';//variable para informar ingreso
                            obtiene_datos_usuario();//visualiza los datos del usuario por ciertos segundos
                            break;
                        case 1://ACTUALIZA EL FICHAJE CON LA HORA DE SALIDA
                            var idf = temptx[1];
                            $.ajax({url:"funcionalidadfichaje.php?val=6",cache:false,type:"POST",data:{id:idf,f:0,he:0,hs:he,js:0}});
                            ie = 's';//variable para informar salida
                            obtiene_datos_usuario();
                            break;
                        case 2://INGRESO PARA EL TURNO NOCHE
                            //GUARDA EL INGRESO EN LA BD-------------------------------------------------------------------------
                            f = suma_dia();
                            $.ajax({url:"funcionalidadfichaje.php?val=0",cache:false,type:"POST",data:{id:id,f:f,he:he,hs:0,js:0}});
                            ie = 'i';//variable para informar ingreso
                            obtiene_datos_usuario();//visualiza los datos del usuario por ciertos segundos
                            break;
                        case 3://ACTUALIZA EL FICHAJE CON LA HORA DE SALIDA
                            var idf = temptx[1];
                            f = resta_dia();
                            $.ajax({url:"funcionalidadfichaje.php?val=6",cache:false,type:"POST",data:{id:idf,f:0,he:0,hs:he,js:0}});
                            ie = 's';//variable para informar salida
                            obtiene_datos_usuario();
                            break;
                        case 4://SI YA EXISTE UN FICHAJE PARA EL DIA
                            alert('YA EXISTE UN FICHAJE DEL LEGAJO ' + id + ' PARA LA FECHA ' + fechaF);
                            $("#legajo").val('');//VACIA EL INPUT LEGAJO
                            $("#legajo").focus();//COLOCA EL FOCO EN EL INPUT LEGAJO
                            break;
                    }


                }
            }

        }
        //----------------------------------------------------------------------------
        //Obtiene la entrada y la salida del usuario en base a legajo y fecha
        function verifica_e_s(){
            var coment = $.ajax({   //consulta la ultima hora de ingreso
                url:"funcionalidadfichaje.php?val=4", //val=6 obtiene la fecha y hora del servidor
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parametro asyn a falso
                type:"POST",
                data:{id:id,f:f,he:he,hs:0,js:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto
            return coment;

        }
        //----------------------------------------------------------------------------
        //LE SUMA UNO A LA FECHA ACTUAL
        function suma_dia(){
            var fch = f.split('-');
            var dia = parseInt(fch[2]) + 1;
            return fch[0]+'-'+fch[1]+'-'+dia;
        }
        //----------------------------------------------------------------------------
        //LE RESTA UNO A LA FECHA ACTUAL
        function resta_dia(){
            var fch = f.split('-');
            var dia = parseInt(fch[2]) - 1;
            return fch[0]+'-'+fch[1]+'-'+dia;
        }
        //----------------------------------------------------------------------------
        //RELOJ DEL SISTEMA
        function muestraReloj() {
            var fechaHora = new Date();
            var horas = fechaHora.getHours();
            var minutos = fechaHora.getMinutes();
            var segundos = fechaHora.getSeconds();
            if(horas < 10) { horas = '0' + horas; }
            if(minutos < 10) { minutos = '0' + minutos; }
            if(segundos < 10) { segundos = '0' + segundos; }
            document.getElementById("reloj").innerHTML = horas+':'+minutos+':'+segundos;
        }
        //----------------------------------------------------------------------------
        //OBTIENE EL LEGAJO PARA COMPROBAR SI EXISTE
        function obtiene_legajo(){
            var coment = $.ajax({   //consulta la ultima hora de ingreso
                url:"funcionalidadfichaje.php?val=3", //val=6 obtiene la fecha y hora del servidor
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el par�metro asyn a falso
                type:"POST",
                data:{id:id,f:0,he:0,hs:0,js:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto
            return coment;
        }
        //----------------------------------------------------------------------------
        //OBTIENE FECHA Y HORA
        function obtiene_fecha_hora_server(){
            var coment = $.ajax({   //consulta la ultima hora de ingreso
                url:"funcionalidadfichaje.php?val=2", //val=6 obtiene la fecha y hora del servidor
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el par�metro asyn a falso
                type:"POST",
                data:{id:0,f:0,he:0,hs:0,js:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto
            return coment;
        }
        //----------------------------------------------------------------------------
        //LE DA FORMATO A LA FECHA QUE VIENE DE LA BD
        function formatea_fecha(){
            datof = f.split('-');
            return datof[2] + '/' + datof[1] + '/' + datof[0];
        }
        //----------------------------------------------------------------------------
        //
        function obtiene_datos_usuario(){
            $("#legajo").val('');//VACIA EL INPUT LEGAJO
            $("#legajo").focus();
            texto = obtiene_usuario();//OBTIENE DATOS DEL USUARIO QUE INGRESO
            elem = texto.split('-');//SEPARA LOS DATOS CON EL "-"
            $("#nombre").text('Usuario: ' + elem[0] + ' ' + elem[1]);//CONCATENA NOMBRE Y APELLIDO Y LO AGREGA AL DIV
            $("#leg").text('Legajo: ' + elem[2]);//AGREGA EL LEGAJO AL DIV
            if(ie == 'i'){
                $("#horai").text('Ingreso: ' + he);//AGREGA LA HORA DE INGRESO AL DIV
            }else{
                $("#horai").text('Salida: ' + he);//AGREGA LA HORA DE SALIDA AL DIV
            }
           $("#datosU").show();//MUESTRA EL DIV
           $("#datosU").delay(6000).hide(600);//LUEGO DE 6 SEGUNDOS OCULTA EL DIV

        }
        //----------------------------------------------------------------------------
        //OBTIENE DATOS PARA INFORMAR EL INGRESO DEL USUARIO
        function obtiene_usuario(){
            var coment = $.ajax({   //consulta la ultima hora de ingreso
                url:"funcionalidadfichaje.php?val=1", //val=6 obtiene la fecha y hora del servidor
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el par�metro asyn a falso
                type:"POST",
                data:{id:id,f:0,he:0,hs:0,js:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto
            return coment;
        }

        //---------------------------------------------------------------------------------
        //FUNCION PARA LIMITAR EL INGRESO DE CARACTERES AL CAMPO DESCRIPCION DEL MOVIMIENTO
        function Numeros(string){//solo letras y numeros
            var out = '';
            var filtro = '1234567890';//Caracteres validos
            for (var i=0; i<string.length; i++)
                if (filtro.indexOf(string.charAt(i)) != -1)
                    out += string.charAt(i);
            return out;
        }
    </script>
</head>
<body>
    <?php

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $dia = $dias[date('w')];
    $mes = $meses[date('n')];
    $fecha ="- ".$dia . " " . date('j') . " de " . $mes . " de " .date('Y')." -";
    unset($mes);
    unset($dia);
    ?>
    <fieldset style="border:6px groove #ccc">
        <?php echo "<div id='fecha'>".$fecha."</div>" ?>
        <div id="reloj"></div>
        <div id="derechos">Version 1.0 - Abril 2019 - Copyright - JIF -</div>
    </fieldset>
    <h1 align="center">INGRESO / EGRESO CDC MAR DEL PLATA</h1>
    <table align="center" id="tLegajo">
            <tr>
                <th colspan="2"><h1>Ingrese Nº de Legajo</h1></th>
            </tr>
            <tr>
                <td colspan="2"><input type="text" id="legajo" name="legajo" value="" maxlength="4" size="7" onkeypress="validar(event,this.value);" onkeyup="this.value=Numeros(this.value)"/></td>
            </tr>
    </table>
    <div id="datosU">
        <div id="nombre"></div>
        <div id="leg"></div>
        <div id="horai"></div>
    </div>
</body>
</html>
</body>
</html>