<?php
/* http://programarenphp.wordpress.com */
/* incluimos primeramente el archivo que contiene la clase fpdf */
 include('fpdf.php');
/* tenemos que generar una instancia de la clase */
        $pdf = new FPDF();
        $pdf->AddPage();

/* seleccionamos el tipo, estilo y tamaño de la letra a utilizar */
        $f= $_GET['f'];//FECHA DEL MOVIMIENTO
        $ar= $_GET['ar'];//DESCRIPCION DEL AREA
        $ap= $_GET['ap'];//FECHA ACTUAL MAS HORA
        $d= $_GET['d'];//descripcion del movimiento
        
        $pdf->Image("imagenes/Logo.JPG",1,1,30,30,"jpg","");
        $pdf->SetFont('Helvetica', 'B', 20);
        $pdf->SetFont('Helvetica', 'U', 20);
        $pdf->Ln(10);//salto de linea
        $pdf->Line(0,40,300,40);//impresión de linea
        $pdf->Ln(30);//salto de linea
        //$pdf->SetTextColor('255','0','0');//para imprimir en rojo 
        $pdf->Cell(0,10,"MOVIMIENTO DE MAQUINAS",0,0,'C');

		$pdf->Ln(40);//salto de linea
        $pdf->SetFont('Helvetica', 'I', 16);//seteo de fuente
       
        $pdf->Cell(350,7,"Descripcion del movimiento: ",0,0,'L');
        $pdf->Ln(8);         
        $pdf->MultiCell(0,10,$d,1,'L',"");//descripcion del movimiento    
            
		$pdf->Ln(20); //salto de linea
        $pdf->SetFont('Helvetica', 'I', 14);//seteo de fuente
		$pdf->Cell(100,7,"Fecha de movimiento:",0,0,'L');//fecha del movimiento
        $pdf->Ln(8);   
        $pdf->Cell(50,7,$f,1,0,'L');//fecha del movimiento
        
		$pdf->Ln(20);//ahora salta 20 lineas 		
        $pdf->Cell(100,7,"Area:",0,0,'L');//area del movimiento
        $pdf->Ln(8);   
        $pdf->Cell(80,7,$ar,1,0,'L');//fecha del movimiento
        
        $pdf->Ln(20);//ahora salta 20 lineas
        $pdf->Cell(100,7,"Apertura:",0,0,'L');//apertura del movimiento 
        $pdf->Ln(8);   
        $pdf->Cell(100,7,$ap,1,0,'L');//fecha del movimiento
                
	//	$pdf->Line(0,160,300,160);//impresión de linea
        $pdf->Ln(20);
        $pdf->Cell(100,7,"Comentarios:",0,0,'L');//apertura del movimiento
        $pdf->Ln(6);
        $pdf->Cell(0,30,"",1,2,'L');//apertura del movimiento  
        
        $ar = trim($ar);
        $f = str_replace('/','-',$f);
        $destino = "movmaquinas/".$ar."-".$f.".pdf";
        //$destino = "C:/xampp/htdocs/checklist/movmaquinas/";
        //$nom_archivo = $ar."-".$f.".pdf";
        //$apertura = $destino . $nom_archivo;
        $pdf->Output($destino,'F');
		echo "<script language='javascript'>window.open('".$destino."','_self','');            
        </script>";//para ver el archivo pdf generado
		exit;        
        
        
	?>
