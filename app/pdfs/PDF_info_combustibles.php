<?php

class PDF_info_combustibles extends FPDF
   {
      var $row = 5;
    
    
   function Header()
   {
	   $this->row=5;
	   
 
       $this->SetFont('Arial','BI',12);
       // Move to the right
       
       $this->SetXY(3, $this->row);
       // Title 
       $this->Cell(40,10,'TRANSPORTES RUTACHILE S.A.',0,0,'L');
       
       $this->SetFont('Arial','',8);
       $this->SetXY(-20, $this->row);
       $this->Cell(40,10,$this->PageNo(),0,0,'L');
       
       
       
       $this->SetFont('Arial','',8);
       $this->row +=6;
       $this->SetXY(3, $this->row);
       $this->Cell(40,6,'         AV.CLAUDIO ARRAU 7656 - PUDAHUEL - SANTIAGO',0,0,'L');
       
       $this->row +=4;
       $this->SetXY(3, $this->row);
       $this->Cell(40,6,'               FONOS FAX: 749 8784 - 749 8785 - 749 8786',0,0,'L');
       
       
       $this->SetFont('Arial','',9);
       $this->row +=6;
       $this->SetXY(0, $this->row);
       
       $this->Cell(0,10,utf8_decode("REPORTE DE CARGA DE COMBUSTIBLES PERIODO ".$this->fecini." AL ".$this->fecfin),0,0,'C');
       
   
       $this->SetFont('Arial','',9);
       

       $this->Ln(1);
       
       $this->row += 15;
       
       $this->SetXY(35, $this->row);
       $this->Cell(15,6,"Fecha", "TB", 0, 'L');
       $this->Cell(15,6,utf8_decode("Número"), "TB", 0, 'L');
       $this->Cell(75,6,utf8_decode("Conductor"), "TB", 0, 'L');
       $this->Cell(25,6,utf8_decode("Litros Cargados"), "TB", 0, 'L');
       
       $this->row +=5;
        
       

   }
   
   function Run($fecini, $fecfin, $filas=array()) {
      
	   $maxPag=270;
	   
      //$this->AddPage();
      $this->fecini = $fecini;
      $this->fecfin = $fecfin;
      
      $this->AliasNbPages();
      $this->AddPage();
      
      $this->SetFont('Arial','B',9);    
      
	  $this->SetFont('Arial','',8);

	  $litros=0;
	  
      foreach($filas as $key => $f) {
	     if ($this->row > $maxPag) {
		    $this->AddPage();
	     }
	     
	     
	     $this->SetXY(35, $this->row);
         $this->Cell(15,6,$f["rend_fecha"],           0, 0, 'C');
         $this->Cell(15,6,$f["rend_nro"],             0, 0, 'R');
         $this->Cell(75,6,utf8_decode($f["chofer"]),  0, 0, 'L');
         $this->Cell(25,6,number_format($f["litros"], 1, ",", "."),  0, 0, 'R');
         
         $this->row +=5;    
         
         $litros += $f["litros"];
		
      } 
      
      $this->SetXY(35, $this->row);
      $this->Cell(15,6,"LITROS TOTALES", "T", 0, 'L');
      $this->Cell(15,6,"",               "T", 0, 'R');
      $this->Cell(75,6,"",               "T", 0, 'L');
      $this->Cell(25,6,number_format($litros,1, ",", "."),          "T", 0, 'R');
      
   
      
	  
   }
   
   // Page footer
   function Footer()
   {
       // Position at 1.5 cm from bottom
       $this->SetY(-1.5);
       // Arial italic 8
       $this->SetFont('Arial','I',8);
       // Page number
       $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
   }
}   
