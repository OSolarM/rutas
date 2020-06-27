<?php

class PDF_dias_clientes extends FPDF
   {
      var $row = 5;
      var $maxPage=220;
      var $fecini;
      var $fecfin;
      
   // Page header
   
   function diffDates($d1, $d2) {
	  $d1 = date2Mysql($d1);
	  $d2 = date2Mysql($d2);
	  
	  $startTimeStamp = strtotime($d1);
      $endTimeStamp = strtotime($d2);
      
      //$timeDiff = abs($endTimeStamp - $startTimeStamp);
      
      $timeDiff = ($endTimeStamp - $startTimeStamp);
      
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

       $this->SetXY(-20, 3);                                                                         
       $this->Cell(10,10, $this->PageNo());
       
       
       
       
       $this->row +=6;
       $this->SetXY(3, $this->row);
       $this->Cell(40,6,'         AV.CLAUDIO ARRAU 7656 - PUDAHUEL - SANTIAGO',0,0,'L');
       
       $this->row +=4;
       $this->SetXY(3, $this->row);
       $this->Cell(40,6,'               FONOS FAX: 749 8784 - 749 8785 - 749 8786',0,0,'L');
       
       $this->SetFont('Arial','B',11);
       $this->row +=6;
       $this->SetXY(0, $this->row);
       
                
      $this->Cell(0,10,utf8_decode("Informe de Días Estadía Clientes desde el $this->fecini al $this->fecfin"),0,0,'C');
      
      $this->row +=10;
 
   }
   
   function Run($Cliente, $Parametro, $fecini, $fecfin, $controller) {
      $this->fecini = $fecini;
      $this->fecfin = $fecfin;
      
      
      $sql = "select c.*                                                        ".
             "from   clientes c                                                 ".
             "      ,(                                                          ".
             "select distinct facturar_id                                       ".
             "from crts                                                         ".
             "where id in (select crt_id from dexpediciones_ex                  ".
             "              where expe_id in (select expe_id                    ".
             "                                  from rendiciones                ".
             "                                 where expe_tipo='I'              ".
             "                                   and rend_fecha >= '".date2Mysql($fecini)."' ".
             "                                   and rend_fecha <= '".date2Mysql($fecfin)."' ".
             "                               )                                  ".
             "            )                                                     ".
             ") b                                                               ".
             "where c.id =b.facturar_id                                         ".
             "order by c.razon                                                  ";
      
             
      $arr = $Cliente->findSql($sql);
      
      //print_r($arr);
      
      $this->AddPage();
      
      $this->SetFont('Arial','',8);
      
      foreach($arr as $r) {
	     if ($this->row > $this->maxPage) $this->AddPage();
	     
	     $facturar_id = $r["id"];
	     $estadia     = $r["estadia"];
	     $valor       = $r["valor"];
	     $tarifa      = $r["tarifa"];
	     
	     $this->SetXY(20, $this->row);
         $this->Cell(60, 5 ,utf8_decode(" Cliente: ".$r["rut"]." ".$r["razon"]),0,0,"L");
	    
         $this->row +=5; 
         
                
         $sql = "SELECT *                                                        ".
                " FROM rendiciones                                               ".
                "where rend_fecha >= '".date2Mysql($fecini)."'                   ".
                "  and rend_fecha <= '".date2Mysql($fecfin)."'                   ".
                "  and expe_tipo='I'                                             ".
                "  and expe_id in (select expe_id                                ".
                "                    from dexpediciones_ex                       ".
                "                   where crt_id in (select id                   ".
                "                                      from crts                 ".
                "                                     where facturar_id=$facturar_id ".
                "                                       and crts_facturable='S'  ".
                "                                   )                            ".
                "                  )                                             ".
                "order by rend_fecha, rend_nro                                   ";
                
         $arr2 = $Cliente->findSql($sql);
         
         if (count($arr) > 0) {
	         if ($this->row > $this->maxPage) $this->AddPage();
	         
	        $this->SetXY(20, $this->row);

	        if ($tarifa=="1") {
	           $this->Cell(15, 5, "Fecha"   ,"TB", 0, 0);
	           $this->Cell(15, 5, "Rend.No" ,"TB", 0, 0);
	           $this->Cell(19, 5, "Fec/Carga"  ,"TB", 0, 0);
               $this->Cell(19, 5, "Fec/Descarga"  ,"TB", 0, 0);
               $this->Cell(19, 5, "Fec/Carga","TB", 0, 0);
               $this->Cell(19, 5, "Fec/Descarga"  ,"TB", 0, 0);
               $this->Cell(12, 5, "Dias"    ,"TB", 0, 0);            
               $this->Cell(25, 5, "Monto"   ,"TB", 0, 0);		        
	        }
	        else { 	           
	           $this->Cell(15, 5, "Fecha"   ,"TB", 0, 0);
	           $this->Cell(15, 5, "Rend.No" ,"TB", 0, 0);
	           $this->Cell(15, 5, "Aduana"  ,"TB", 0, 0);
               $this->Cell(15, 5, "Lib.Ad"  ,"TB", 0, 0);
               $this->Cell(15, 5, "Descarga","TB", 0, 0);
               $this->Cell(15, 5, "Aduana"  ,"TB", 0, 0);
               $this->Cell(15, 5, "Lib.Ad"  ,"TB", 0, 0);            
               $this->Cell(12, 5, "Dias"    ,"TB", 0, 0);            
               $this->Cell(25, 5, "Monto"   ,"TB", 0, 0);
            }
            $this->row +=5;
         }
         
         foreach($arr2 as $rr) {
	        $this->SetXY(20, $this->row);

	        $rend_fec_aduana     = mysql2Date($rr["rend_fec_aduana"]);
	        $rend_fec_bodega     = mysql2Date($rr["rend_fec_bodega"]);
	        $rend_fec_descarga   = mysql2Date($rr["rend_fec_descarga"]);
	        $rend_fec_aduana_imp = mysql2Date($rr["rend_fec_aduana_imp"]);
	        $rend_fec_bodega_imp = mysql2Date($rr["rend_fec_bodega_imp"]); 
	        
	        $rend_fec_carga        = mysql2Date($rr["rend_fec_carga"]);
	        $rend_fec_descarga     = mysql2Date($rr["rend_fec_descarga"]);
	        $rend_fec_carga_imp    = mysql2Date($rr["rend_fec_carga_imp"]);
	        $rend_fec_descarga_imp = mysql2Date($rr["rend_fec_descarga_imp"]);
	        
	        if ($tarifa=="1") {
	           $this->Cell(15, 5, mysql2Date($rr["rend_fecha"]));
	           $this->Cell(15, 5, $rr["rend_nro"], 0, 0, "R");
	           $this->Cell(19, 5, $rend_fec_carga);
               $this->Cell(19, 5, $rend_fec_descarga);
               $this->Cell(19, 5, $rend_fec_carga_imp);
               $this->Cell(19, 5, $rend_fec_descarga_imp);
            }	        
	        else {
	           $this->Cell(15, 5, mysql2Date($rr["rend_fecha"]));
	           $this->Cell(15, 5, $rr["rend_nro"], 0, 0, "R");
	           $this->Cell(15, 5, $rend_fec_aduana);
               $this->Cell(15, 5, $rend_fec_bodega);
               $this->Cell(15, 5, $rend_fec_descarga);
               $this->Cell(15, 5, $rend_fec_aduana_imp);
               $this->Cell(15, 5, $rend_fec_bodega_imp);
            }
          
            $dias=0;
            $dias1=0;
            $dias2=0;
            $dias3=0;
            
            $controller->log($tarifa." - ".$rend_fec_carga." - ".$rend_fec_descarga, "Debug");
            if ($tarifa=="1") {
               if ($rend_fec_carga!="" && $rend_fec_descarga!="") {
	              $dias1 = $this->diffDates($rend_fec_carga, $rend_fec_descarga);	              	              
               }	  
               
               $controller->log($rr["rend_nro"]." '".$rend_fec_carga."' '".$rend_fec_descarga."' ".$dias1, "Debug");
               
               if ($rend_fec_carga_imp!="" && $rend_fec_descarga_imp!="") {
	              $dias2 = $this->diffDates($rend_fec_carga_imp, $rend_fec_descarga_imp);
               }                         
            }
            else {
               if ($rend_fec_aduana!="" && $rend_fec_bodega!="") {
	              $dias1 = $this->diffDates($rend_fec_aduana, $rend_fec_bodega);
               }
               
               
               if ($rend_fec_bodega!="" && $rend_fec_descarga!="") {
	              $dias2 = $this->diffDates($rend_fec_bodega, $rend_fec_descarga);
               }
               
                if ($rend_fec_aduana_imp!="" && $rend_fec_bodega_imp!="") {
	              $dias3 = $this->diffDates($rend_fec_aduana_imp, $rend_fec_bodega_imp);
               }
            }
            
            if ($dias1 > $estadia) $dias += $dias1 - $estadia;
            
            if ($dias2 > $estadia) $dias += $dias2 - $estadia;
            
            if ($dias3 > $estadia) $dias += $dias3 - $estadia;
            
            
            
            $this->Cell(12, 5, $dias, 0, 0 , "R");
            
            $this->Cell(25, 5, "US$". number_format(round($dias*$valor), 2, ",", "."), 0, 0, "R");
	    
            $this->row +=5; 
         
         }
         
          if ($this->row > $this->maxPage) $this->AddPage();
          
         $this->SetXY(20, $this->row);	       
	     $this->Cell(15, 5, "","T", 0, 0);
	     $this->Cell(15, 5, "","T", 0, 0);
	     $this->Cell(15, 5, "","T", 0, 0);
         $this->Cell(15, 5, "","T", 0, 0);
         $this->Cell(15, 5, "","T", 0, 0);
         $this->Cell(15, 5, "","T", 0, 0);
         $this->Cell(15, 5, "","T", 0, 0);            
         $this->Cell(12, 5, "","T", 0, 0);            
         $this->Cell(25, 5, "","T", 0, 0);
         
         $this->row +=10;
         
       
      }

	  
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
