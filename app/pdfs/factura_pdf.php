<?php

class FacturaPDF extends FPDF
   {
      var $row = 5;
    
      var $filas=array();
      var $fecini="";
      var $fecfin="";
      
   function diffDates($d1, $d2) {
	  $d1 = date2Mysql($d1);
	  $d2 = date2Mysql($d2);
	  
	  $startTimeStamp = strtotime($d1);
      $endTimeStamp = strtotime($d2);
      
      $timeDiff = abs($endTimeStamp - $startTimeStamp);
      
      $numberDays = $timeDiff/86400;  // 86400 seconds in one day
      
      // and you might want to convert to integer
      $numberDays = intval($numberDays);
      
      return $numberDays;
   }
    
   function Header()
   {
	   $this->row=5;
	   
 
       $this->SetFont('Arial','BI',12);
       // Move to the right
       
       $this->SetXY(3, $this->row);
       // Title 
       $this->Cell(40,10,'TRANSPORTES RUTACHILE S.A.',0,0,'L');
       
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
       
       $this->Cell(0,10,utf8_decode("INFORME ESTADIA DE CHOFERES PERIODO ".$this->fecini." AL ".$this->fecfin),0,0,'C');
       
   
       $this->SetFont('Arial','',9);
       

       $this->Ln(1);
       
       $this->row += 10;
       
        $this->SetXY(20, $this->row);
             $this->Cell(15, 4, "",             "T", 0, "L");
             $this->Cell(15, 4, "",             "T", 0, "R");
             $this->Cell(45, 4, "EXPORTACION",       "T", 0, "C"); 
             $this->Cell(10, 4, "",             "T", 0, "R");
             $this->Cell(15, 4, "",             "T", 0, "R");
             $this->Cell(30, 4, "IMPORTACION",       "T", 0, "C"); 
             $this->Cell(10, 4, "",             "T", 0, "R");
             $this->Cell(15, 4, "",             "T", 0, "R");
             $this->Cell(10, 4, "",             "T", 0, "R");
             $this->Cell(15, 4, "",              "T", 0, "R");
             $this->Cell(20, 4, "",                   "T", 0, "R");
             $this->row += 4;
   
       		     $this->SetXY(20, $this->row);
             $this->Cell(15, 4, "Fecha",              "B", 0, "L");
             $this->Cell(15, 4, "No.Rend.",           "B", 0, "R");
             $this->Cell(15, 4, "Aduana",             "B", 0, "C"); 
             $this->Cell(15, 4, "Lib.Aduana",         "B", 0, "C"); 
             $this->Cell(15, 4, "Descarga",           "B", 0, "C");
             $this->Cell(10, 4, utf8_decode("Días"),  "B", 0, "R");
             $this->Cell(15, 4, "Valor",              "B", 0, "R");
             $this->Cell(15, 4, "Aduana",             "B", 0, "C"); 
             $this->Cell(15, 4, "Lib.Aduana",         "B", 0, "C"); 
             $this->Cell(10, 4, utf8_decode("Días"),  "B", 0, "R");
             $this->Cell(15, 4, "Valor",              "B", 0, "R");
             $this->Cell(10, 4, utf8_decode("T.Días"),  "B", 0, "R");
             $this->Cell(15, 4, "T.Valor",              "B", 0, "R");
             $this->Cell(20, 4, "Vuelta",             "B", 0, "R");
             $this->row += 8;
   }
   
   function Run($fecini, $fecfin, $filas=array()) {
      
	   $maxPag=180;
	   
      //$this->AddPage();
      $this->fecini = $fecini;
      $this->fecfin = $fecfin;
      
      $this->AliasNbPages();
      $this->AddPage();
      
      $this->SetFont('Arial','B',9);    
      
	  $this->SetFont('Arial','',8);
	         
	  $chof_id=0;
	  $sDias=0;
	  $sValor=0;
	  
	  $sDias2=0;
	  $sValor2=0;
	  $nFilas=0;
	  $sVuelta=0;
	  
	  $SumDias=0; $SumValor=0;
	  $SumDias2=0; $SumValor2=0;
	  
	  $SumVuelta=0;
	  
      foreach($filas as $key => $f) {
	      
	     if ($chof_id!=$f["chof_id"]) {
		     
		     if ($chof_id > 0) {
			    if ($nFilas > 1) {
			    $this->SetXY(20, $this->row);
	            $this->Cell(15, 4, "SUB.TOTAL",      "T", 0, "L");
	            $this->Cell(15, 4, "",      "T", 0, "R");
	            $this->Cell(15, 4, "",      "T", 0, "L"); 
                $this->Cell(15, 4, "",      "T", 0, "L"); 
                $this->Cell(15, 4, "",      "T", 0, "L");
                $this->Cell(10, 4, $sDias,                   "T", 0, "R");
                $this->Cell(15, 4, "$".number_Format($sValor, 0, ",", "."),                   "T", 0, "R"); 
                $this->Cell(15, 4, "",   "T", 0, "L"); 
                $this->Cell(15, 4, "",   "T", 0, "L"); 
                $this->Cell(10, 4, $sDias2,                   "T", 0, "R");
                $this->Cell(15, 4, "$".number_Format($sValor2, 0, ",", "."),                   "T", 0, "R"); 
                $this->Cell(10, 4, $sDias+$sDias2,                                             "T", 0, "R");
                $this->Cell(15, 4, "$".number_Format($sValor+$sValor2, 0, ",", "."),           "T", 0, "R");
                $this->Cell(20, 4, "$".number_Format($sVuelta, 0, ",", "."),                   "T", 0, "R");
                }
                
                $nFilas=0;
			     
                
			    $this->row += 8;
			    
			    if ($this->row > $maxPag) $this->AddPage();
		     }
		     
		     $chof_id=$f["chof_id"];
		     $sDias=0;
		     $sValor=0;
		     $sDias2 =0;
             $sValor2 =0;
		     $sVuelta=0;
		     
		     
		     if ($this->row > $maxPag) $this->AddPage();
		     
		     $this->SetXY(20, $this->row);
	         $this->Cell(40, 4, utf8_decode("Chofer: ".$f["chof_apellidos"]." ".$f["chof_nombres"]), 0, 0, "L");
		     $this->row += 4;
		     
		     //$this->SetXY(20, $this->row);
             //$this->Cell(15, 4, "",             "T", 0, "L");
             //$this->Cell(15, 4, "",             "T", 0, "R");
             //$this->Cell(45, 4, "EXPORTACION",       "T", 0, "C"); 
             //$this->Cell(10, 4, "",             "T", 0, "R");
             //$this->Cell(15, 4, "",             "T", 0, "R");
             //$this->Cell(30, 4, "IMPORTACION",       "T", 0, "C"); 
             //$this->Cell(15, 4, "",             "T", 0, "R");
             //$this->Cell(15, 4, "",             "T", 0, "R");
             //$this->row += 4;
		     
		     //$this->SetXY(20, $this->row);
             //$this->Cell(15, 4, "Fecha",              "B", 0, "L");
             //$this->Cell(15, 4, "No.Rend.",           "B", 0, "R");
             //$this->Cell(15, 4, "Aduana",             "B", 0, "C"); 
             //$this->Cell(15, 4, "Lib.Aduana",         "B", 0, "C"); 
             //$this->Cell(15, 4, "Descarga",           "B", 0, "C");
             //$this->Cell(10, 4, utf8_decode("Días"),  "B", 0, "R");
             //$this->Cell(15, 4, "Valor",              "B", 0, "R");
             //$this->Cell(15, 4, "Aduana",             "B", 0, "C"); 
             //$this->Cell(15, 4, "Lib.Aduana",         "B", 0, "C"); 
             //$this->Cell(10, 4, utf8_decode("Días"),  "B", 0, "R");
             //$this->Cell(15, 4, "Valor",              "B", 0, "R");
             //$this->row += 4;
             

	     }
	     
            $rend_fec_aduana   = $f["rend_fec_aduana"]  ; 
            $rend_fec_bodega   = $f["rend_fec_bodega"]  ; 
            $rend_fec_descarga = $f["rend_fec_descarga"];
            
            $dias=0; $dias1=0; $dias2=0;
            
            if ($rend_fec_aduana!="" && $rend_fec_bodega!="") {
	         $dias1 = $this->diffDates($rend_fec_aduana, $rend_fec_bodega);
            }
          
          
            if ($rend_fec_bodega!="" && $rend_fec_descarga!="") {
	           $dias2 = $this->diffDates($rend_fec_bodega, $rend_fec_descarga);
            }
            
            if ($dias1 > 2) $dias += $dias1 - 2;
            
            if ($dias2 > 2) $dias += $dias2 - 2;	     
            
            $valor = round($dias*12000, 0);
            
            $sDias += $dias;
            $sValor += $valor;
            
            $rend_fec_aduana_imp   = $f["rend_fec_aduana_imp"]  ; 
            $rend_fec_bodega_imp   = $f["rend_fec_bodega_imp"]  ; 
            
            $dias2=0; $dias1=0;
            
            if ($rend_fec_aduana_imp!="" && $rend_fec_bodega_imp!="") {
	         $dias1 = $this->diffDates($rend_fec_aduana_imp, $rend_fec_bodega_imp);
            }
            
            if ($dias1 > 2) $dias2 += $dias1 - 2;
                 
            
            $valor2 = round($dias2*12000, 0);
            
            $sDias2 += $dias2;
            $sValor2 += $valor2;
            
            
            $tari_valor = $f["tari_valor"];
	 
		    $this->SetXY(20, $this->row);
	        $this->Cell(15, 4, $f["rend_fecha"],        0, 0, "L");
	        $this->Cell(15, 4, $f["rend_nro"],          0, 0, "R");
	        $this->Cell(15, 4, $f["rend_fec_aduana"],   0, 0, "L"); 
            $this->Cell(15, 4, $f["rend_fec_bodega"],   0, 0, "L"); 
            $this->Cell(15, 4, $f["rend_fec_descarga"], 0, 0, "L");
            $this->Cell(10, 4, $dias,                   0, 0, "R");
            $this->Cell(15, 4, "$".number_Format($valor, 0, ",", "."),                   0, 0, "R");
            $this->Cell(15, 4, $f["rend_fec_aduana_imp"],   0, 0, "L"); 
            $this->Cell(15, 4, $f["rend_fec_bodega_imp"],   0, 0, "L"); 
            
            $this->Cell(10, 4, $dias2,                   0, 0, "R");
            $this->Cell(15, 4, "$".number_Format($valor2, 0, ",", "."),                   0, 0, "R");
            
            $this->Cell(10, 4, $dias+$dias2,                   0, 0, "R");
            $this->Cell(15, 4, "$".number_Format($valor+$valor2, 0, ",", "."),                   0, 0, "R");
            
            $this->Cell(20, 4, "$".number_Format($tari_valor, 0, ",", "."),                   0, 0, "R");
            
            $sVuelta += $tari_valor;
            $SumVuelta += $tari_valor;
            
            $SumDias += $dias;
            $SumValor += $valor;
            
            $SumDias2  += $dias2;
            $SumValor2 += $valor2;
            
            $nFilas++; 
            
            

	    
	     
	     $this->row += 4; 
	     
	     if ($this->row > $maxPag) $this->AddPage();
	     
      }  
      
      if ($nFilas > 1) {
		 $this->SetXY(20, $this->row);
	     $this->Cell(15, 4, "SUB.TOTAL",      "T", 0, "L");
	     $this->Cell(15, 4, "",      "T", 0, "R");
	     $this->Cell(15, 4, "",      "T", 0, "L"); 
         $this->Cell(15, 4, "",      "T", 0, "L"); 
         $this->Cell(15, 4, "",      "T", 0, "L");
         $this->Cell(10, 4, $sDias,                   "T", 0, "R");
         $this->Cell(15, 4, "$".number_Format($sValor, 0, ",", "."),                   "T", 0, "R"); 
         $this->Cell(15, 4, "",   "T", 0, "L"); 
         $this->Cell(15, 4, "",   "T", 0, "L"); 
         $this->Cell(10, 4, $sDias2,                   "T", 0, "R");
         $this->Cell(15, 4, "$".number_Format($sValor2, 0, ",", "."),                   "T", 0, "R"); 
         $this->Cell(10, 4, $sDias+$sDias2,                   "T", 0, "R");
         $this->Cell(15, 4, "$".number_Format($sValor + $sValor2, 0, ",", "."),                   "T", 0, "R"); 
         $this->Cell(20, 4, "$".number_Format($sVuelta, 0, ",", "."),                   "T", 0, "R");
         $this->row += 4;
      } 
      
      $this->SetXY(20, $this->row);
	  $this->Cell(15, 4, "TOTAL",      "T", 0, "L");
	  $this->Cell(15, 4, "",      "T", 0, "R");
	  $this->Cell(15, 4, "",      "T", 0, "L"); 
      $this->Cell(15, 4, "",      "T", 0, "L"); 
      $this->Cell(15, 4, "",      "T", 0, "L");
      $this->Cell(10, 4, $SumDias,                   "T", 0, "R");
      $this->Cell(15, 4, "$".number_Format($SumValor, 0, ",", "."),                   "T", 0, "R"); 
      $this->Cell(15, 4, "",   "T", 0, "L"); 
      $this->Cell(15, 4, "",   "T", 0, "L"); 
      $this->Cell(10, 4, $SumDias2,                   "T", 0, "R");
      $this->Cell(15, 4, "$".number_Format($SumValor2, 0, ",", "."),                   "T", 0, "R"); 
      $this->Cell(10, 4, $SumDias+$SumDias2,                   "T", 0, "R");
      $this->Cell(15, 4, "$".number_Format($SumValor + $SumValor2, 0, ",", "."),                   "T", 0, "R"); 
      $this->Cell(20, 4, "$".number_Format($SumVuelta, 0, ",", "."),                  "T", 0, "R");
      
	  
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
