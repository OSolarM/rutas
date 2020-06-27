<?php

class PDF_info_crts extends FPDF
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
       
       $this->Cell(0,10,utf8_decode("INFORME DE CRTS PERIODO ".$this->fecini." AL ".$this->fecfin),0,0,'C');
       
   
       $this->SetFont('Arial','',9);
       

       $this->Ln(1);
       
       $this->row += 15;
       
       $this->SetXY(20, $this->row);
       $this->Cell(30,6,utf8_decode("Número"),     "TB", 0, 'L');
       $this->Cell(20,6,utf8_decode("Fecha"),      "TB", 0, 'C');
       $this->Cell(20,6,utf8_decode("Factura No"), "TB", 0, 'R');
       $this->Cell(80,6,utf8_decode("Cliente"),    "TB", 0, 'C');
       $this->Cell(20,6,"Correlativo",                  "TB", 0, 'L');
       
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

	  $sin = 0;
	  
      foreach($filas as $key => $f) {
	     if ($this->row > $maxPag) {
		    $this->AddPage();
	     }
	     
	     
	     $this->SetXY(20, $this->row);
         $this->Cell(30,6,ltrim($f["crts_numero"]), 0, 0, 'L');
         $this->Cell(20,6,$f["fecha"],              0, 0, 'C');
         $this->Cell(20,6,$f["factura_crt"],        0, 0, 'R');
         $this->Cell(80,6,$f["razon"],              0, 0, 'L');
         $this->Cell(20,6,$f["faltan"],             0, 0, 'L');
         
         $this->row +=5;    
         
	     if (trim($f["factura_crt"])=="")
	        $sin++;
         	
      } 
      
      $this->SetXY(20, $this->row);                                                                   
      $this->Cell(25,6,utf8_decode("SIN FACTURAR"),                               "T", 0, 'L');                       
      $this->Cell(20,6,number_format($sin,   0, ",", "."),              "T", 0, 'R');                       
      //$this->Cell(30,6,number_format($extranjero, 0, ",", "."),              "T", 0, 'R');               
      //$this->Cell(30,6,number_format($nacional + $extranjero, 0, ",", "."),  "T", 0, 'R');	  
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
