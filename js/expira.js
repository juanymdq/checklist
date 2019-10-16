var minutos, seconds;
//Agrega la variable de sesion
var seconds_left = <? echo $_SESSION['limite'];?>;
seconds_left = seconds_left*60;  
/* Determinamos la url donde redireccionar con un parametro que sirve para cerrar las SESSIONS en el index */
var url="index.php?caducada=1";
setInterval(function () {   
    
    //Divide los segundos y coloca el cociente como minutos
    minutos = parseInt(seconds_left / 60);
    //Agrega un 0 a la izquierda si los minutos son menores a 10
    if(minutos < 10){
        minutos = "0" + minutos;
    }
    //El resto los coloca como segundos
    seconds = parseInt(seconds_left % 60);
    //Agrega un 0 a la izquierda si los segundos son menores a 10
    if(seconds < 10){
        seconds = "0" + seconds;
    }
    //Muestra el tiempo restante en la etiqueta "Cuenta Atras"
    document.getElementById('CuentaAtras').innerHTML = "La sesi\u00f3n expira en: " + minutos + ":" + seconds;
    //Controla que se expire la sesion cuando se haya terminado todo el tiempo 
     if(minutos==0){
        if(seconds==0){
            //Cuando se agote el tiempo, redirige al index.php
            window.location=url;   
        }        
     }else{
        if(minutos==0){
            window.location=url;
        }          
    }
    /* Restamos un segundo al tiempo restante */ 
    seconds_left-=1;
    
    
}, 1000);