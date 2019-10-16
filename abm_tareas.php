
<!doctype html>
<html lang="en">
<head>
	<title></title>
	<link type="text/css" href="estilos/ui.all.css" rel="stylesheet" />
    <link type="text/css" href="estilos/ui.datepicker.css" rel="stylesheet" />
    <link type="text/css" href="estilos/jquery-ui.css" rel="stylesheet" />
    <script src="jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.datepicker.js"></script>   
    <script src="jquery.js"></script>  
    <script src="js/jquery.ui.position.js"></script>
	<script type="text/javascript">
	  $(function() {	  
        $( "#datefdp" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "dd/mm/yy"
        });           
      });     
	</script>
    <style>
        #cont{
            margin: 30px 0px 0px 250px;
            width: 550px;
            height: 300px;            
            float: left;
        } 
      
        #td_cab{
            height: 50px;
            font-size: 15px;
            font-weight: bold;
            vertical-align: central;
            text-align: center;
            border: green 1px solid;
            margin: 10px 0 0 0;
        }
        #b_edita{
            margin: 10px 0 0 0;
            text-align: center;
            border: green 1px solid;
            padding: 10px 10px 10px 10px;
        }      
        #td_user{
            font-size: 15px;
            font-weight: bold;
            margin: 0px 0px 0px 0px;
            padding: 10px 10px 10px 10px;
            border: green 1px solid;
        }
        #desde{
            font-size: 15px;
            font-weight: bold;
            padding: 10px 10px 10px 10px;
            border: green 1px solid;           
        }
        #valor{
            font-size: 15px;
            font-weight: bold;
            padding: 10px 10px 10px 10px;
            border: green 1px solid;
        }
    </style> 
    <script>
    var idh;
    var idt;
    
    $(document).ready(function(){ 
        $("#datefdp").change(function() {
            
       	    xfdp = document.getElementById('datefdp').value;
            var res = xfdp.split('/');
            fdp = res[2]+'-'+res[1]+'-'+res[0];
            
            //trae el id de la hoja en base a la fecha
            var coment = $.ajax({
                url:"hoja.php",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",
                data:{fdp:fdp}
            }).responseText;  //ejecuta la consulta y devuelve formato texto     
            //-------------------------------------------------
            idh = coment;
            document.getElementById('idtarea').options.length = 0;
           
            var num_art = document.getElementById('idt').length;
            var objOption = document.getElementById('idtarea');	
           // objOption.options[0] = new Option('- Seleccionar Tarea -');	
            var x=1;	
            for(var i=0; i<num_art; i++){		
                if(fdp == document.form1.idt.options[i].value){
                    objOption.options[x] = new Option(document.form1.idt.options[i].text);			 
                    x++;
                }		
            }
        });
        $('#idtarea').change(function(){
            document.getElementById('valor').value = "";
            var valor = $(this).val();
            var res = valor.split('-');
            idt = res[0]; 
          
            $('#valor').attr("disabled", false);
          
            var coment = $.ajax({
                //val=6 indica que consulta el id de la hoja en base a la fecha
                url:"editar.php?val=6",
                dataType: 'text',//indicamos que es de tipo texto plano
                async: false,     //ponemos el parámetro asyn a falso            
                type:"POST",
                data:{idt:idt,idh:idh,idu:0,h:0,v:0,p:0}
            }).responseText;  //ejecuta la consulta y devuelve formato texto         
            document.getElementById('valor').value = coment;  
        });
        $('#edita').click(function(){       
            v = document.getElementById('valor').value;
            //val=7 indica que modificara el valor de la tarea
            $.ajax({url:"editar.php?val=7",cache:false,type:"POST",data:{idt:idt,idh:idh,idu:0,h:0,v:v,p:0}});
            alert('La tarea '+idt+' fue modificada con exito');
            $('#valor').attr("disabled",true);
        });
    }); 
    
    </script>
</head>
<body>
<?
include('clases/c_diario.php');
$diario = new diario;
?>
<div id="cont">
    <form id="form1" name="form1" method="post" action="buscar_hoja.php">
    
        <div>
           
            <table id="t_user">  
                 <tr>
                    <td colspan="2" id="td_cab">EDITAR VALOR DE TAREA</td>
                </tr>
                <tr>
                    <td id="desde">SELECCIONAR FDP:</td>
                    <td id="desde"><input type="text" id="datefdp" name="datefdp" size="10"/></td>
                </tr>
                <tr>
                    <td id="td_user">TAREAS:</td>                                   
                    <td id="td_user">
                    <select name="idtarea" id="idtarea" style="width:350px">                                             						
                    </select>                  
                    </td>
                    <td>
                    <select name="idt" id="idt" style="visibility: hidden;">
                    <?php  															                            
                        $res = $diario->obtiene_tareas_all();
                        while($seltarea = mysql_fetch_array($res)){
                            echo "<option value='".$seltarea[8]."'>".$seltarea[0]." - ".$seltarea[14]."</option>";							        
                        }                                                                
                        mysql_free_result($res);
                    ?>                        						
                    </select>
                    
                    </td>
                   
                </tr> 
                <tr>
                    <td colspan="2"><textarea cols="60" rows="5" id="valor" disabled="true"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" id="b_edita"><input type="button" value="EDITAR" id="edita" /></td>
                </tr>
            </table>    
        </div>       
    
    </form>
</div>

</body>
</html>
