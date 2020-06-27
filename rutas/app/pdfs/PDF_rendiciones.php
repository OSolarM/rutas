<?php

class PDF_rendiciones extends FPDF
   {
      var $row = 5;
      var $expe_nro;
      var $expe_fecha;
      var $chof_nombres;
      var $cami_patente;
      var $acop_patente;
      var $expe_destino;
      var $expe_fondos;
      var $lista;
      var $rendicion;
      var $fondo;
      
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
	      	   
	   if ($this->PageNo() > 1) {
		  $this->row += 10;
		  return;
	   }
	   
 
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
       
       $rend_nro            = $this->rendicion["rend_nro"           ]; 
       $rend_fecha          = $this->rendicion["rend_fecha"         ];
       $expe_tipo           = $this->rendicion["expe_tipo"          ];
       $expe_id             = $this->rendicion["expe_id"            ];
       $fondo_id            = $this->rendicion["fondo_id"           ];
       $rend_fecha_salida   = $this->rendicion["rend_fecha_salida"  ];
       $rend_lugar_salida   = $this->rendicion["rend_lugar_salida"  ];
       $rend_kms_salida     = $this->rendicion["rend_kms_salida"    ];
       $rend_fecha_llegada  = $this->rendicion["rend_fecha_llegada" ];
       $rend_lugar_llegada  = $this->rendicion["rend_lugar_llegada" ];
       $rend_kms_llegada    = $this->rendicion["rend_kms_llegada"   ];
       $rend_dias_viaje_nac = $this->rendicion["rend_dias_viaje_nac"];
       $rend_dias_viaje_int = $this->rendicion["rend_dias_viaje_int"];  
       $expe_nro            = $this->rendicion["expe_nro"]; 
       $expe_destino        = $this->rendicion["expe_destino"]; 
       $expe_tipo           = $this->rendicion["expe_tipo"];       
       $chofer              = $this->rendicion["chofer"];  
       $cami_patente        = $this->rendicion["cami_patente"];  
       $acop_patente        = $this->rendicion["acop_patente"];  
       $crts                = $this->rendicion["crts"];  
       $rend_fec_aduana     = $this->rendicion["rend_fec_aduana"  ];
       $rend_fec_bodega     = $this->rendicion["rend_fec_bodega"  ];
       $rend_fec_descarga   = $this->rendicion["rend_fec_descarga"];
       $rend_fallida        = $this->rendicion["rend_fallida"];
       $tari_valor          = 0;
       $rend_fec_aduana_imp = $this->rendicion["rend_fec_aduana_imp"  ];
       $rend_fec_bodega_imp = $this->rendicion["rend_fec_bodega_imp"  ];
       
       $this->SetFont('Arial','B',11);
       $this->row +=2;
       $this->SetXY(0, $this->row);
       
       if ($expe_tipo=="N")
          $this->Cell(0,10,utf8_decode("RENDICIONES DE GASTO NACIONAL N° $rend_nro"),0,0,'C');
       else {
          if ($this->fondo["expe_lastre"] == "S")
             $lastre = "(LASTRE) ";
          else
             $lastre = "";
             
          $this->Cell(0,10,utf8_decode("RENDICIONES DE GASTO INTERNACIONAL ".$lastre."N° $rend_nro"),0,0,'C');
      }
      
      $giros = $this->fondo["giros"];
   
       $this->SetFont('Arial','',9);
       

   
       $this->row +=10; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Fecha de Rendición:"));   $this->Cell(20, 4, $rend_fecha);
       /*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(38, 4, utf8_decode("Número de Expedición: "));   $this->Cell(20, 4, $expe_nro);    
       
       $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, "Nombre Conductor: ");    $this->Cell(40, 4, utf8_decode($chofer));
       $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Camión: "));    $this->Cell(40, 4, $cami_patente);
       /*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(22, 4, utf8_decode("Acoplado: "));    $this->Cell(40, 4, $acop_patente);
       
       $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, "Fecha y lugar de salida: ");    $this->Cell(40, 4, $rend_fecha_salida." ".$rend_lugar_salida);
       $this->row += 4; $this->SetXY(20, $this->row); 
                        $this->Cell(42, 4, "Fecha y lugar de llegada: ");   
                        $this->Cell(40, 4, $rend_fecha_llegada." ".$rend_lugar_llegada);
                        
       if ($expe_tipo=="I" && $rend_fallida=="N") {
          $this->Cell(29, 4, "Aduana ".$rend_fec_aduana);
          $this->Cell(23, 4, "Lib ".$rend_fec_bodega);
          $this->Cell(39, 4, "Descarga ".$rend_fec_descarga);
          $this->Cell(29, 4, "Aduana ".$rend_fec_aduana_imp);
          $this->Cell(23, 4, "Lib ".$rend_fec_bodega_imp);
          
          $dias=0;
          $dias1=0;
          $dias2=0;
          $dias3=0;
          
          if ($rend_fec_aduana!="" && $rend_fec_bodega!="") {
	         $dias1 = $this->diffDates($rend_fec_aduana, $rend_fec_bodega);
          }
          
          
          if ($rend_fec_bodega!="" && $rend_fec_descarga!="") {
	         $dias2 = $this->diffDates($rend_fec_bodega, $rend_fec_descarga);
          }
          
           if ($rend_fec_aduana_imp!="" && $rend_fec_bodega_imp!="") {
	         $dias3 = $this->diffDates($rend_fec_aduana_imp, $rend_fec_bodega_imp);
          }
          
          if ($dias1 > 2) $dias += $dias1 - 2;
          
          if ($dias2 > 2) $dias += $dias2 - 2;
          
          if ($dias3 > 2) $dias += $dias3 - 2;
          
          
          
          $this->Cell(12, 4, "Dias ".$dias);
          
          $this->Cell(25, 4, "Estadia $". number_format(round($dias*12000,0), 0, ",", "."));
          
          $tarifa_id = $this->fondo["tarifa_id"];
          if ($tarifa_id!="") {
	         //$dd = $this->Tarifa->read(null, $id);
	         //$tari_valor = $dd["Tarifa"]["tari_valor"];
	         $tari_valor= $this->fondo["tari_valor"];
          }
          else 
             $tari_valor = 0;
                       
       }
      
       $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, "Destino: "); $this->Cell(120, 4, $expe_destino);    
       
          
       /*$this->row += 5; $this->SetXY(20, $this->row);*/ 
       
       if ($expe_tipo=="I") {
	       if ($rend_fallida=="N")
	          $this->Cell(40, 4, "Valor vuelta $". number_format($tari_valor, 0, ",", "."));
	       
	       $this->row += 4; 
	       $this->SetXY(20, $this->row); 
	       $this->Cell(42, 4, utf8_decode("Días de viaje nacional: "));  
	       $this->Cell(20, 4, $rend_dias_viaje_nac); 
	       $this->Cell(42, 4, utf8_decode("Días de viaje internacional: "));   
	       $this->Cell(20, 4, $rend_dias_viaje_int);        
       }
       else
          $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Días de viaje: "));  $this->Cell(20, 4, $rend_dias_viaje_nac); 
       
       if ($expe_tipo=="I") {
	      $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Crt(s): "));   $this->Cell(160, 4, $crts);        
       }
       else {
	      $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Guía(s): "));   $this->Cell(160, 4, $crts);        
       }
       
       $s = "";
       foreach($giros as $g) {
	      if ($g["mone_id"]==6) 
	         $moneda="$";
	      else
	         $moneda="ARS";
	         
	      $fecha = $g["giro_fecha"];
	      $monto = $g["giro_monto"];
	      $nro =   $g["giro_nro"];
	      
	      $s .= "N° $nro, $fecha, $moneda".number_format($monto,0,",",".").".- ";
	      
       }
          
          
       $this->row += 4; $this->SetXY(20, $this->row); $this->Cell(42, 4, utf8_decode("Giros y/o Depósitos(s): ")); 
       $this->Cell(80, 4, utf8_decode($s)); 
       
       
       
       // Line break
       $this->Ln(1);
       
       $this->row += 10;
   
       $this->SetXY(20, $this->row); 
   }
   
   function Run($aRend, $nac=array(), $mon2=array(), $mon3=array(), $moneda2="", $moneda3="", $fondo=array()) {
      
      //$this->AddPage();
      $this->rendicion = $aRend;
      $this->fondo     = $fondo;
      
      $this->AliasNbPages();
      $this->AddPage();
      
      $this->SetFont('Arial','B',9);    
      
      $this->SetXY(20, $this->row);
	  $this->Cell(40, 4, "MONEDA NACIONAL", 1, 0, "L");
	  $this->Cell(20, 4, "",1, 0, 'R'); 
	  $this->Cell(20, 4, "LITROS",1, 0, 'R'); 
	  $this->row += 4;
	  $this->SetFont('Arial','',8);
	         
	  $litros=0;
	  
	  $sumaGiro=0;
	  foreach($this->fondo["giros"] as $g) {
	      if ($g["mone_id"]==6) 
	         $sumaGiro += $g["giro_monto"];
	      
      }
	  
      $suma=0;
	  $rowInicio = $this->row;
	  
	  $this->SetXY(20, $this->row);
	  $this->Cell(40, 4, "LITROS ENT. PARA VIAJE", 1, 0, "L");
	  $this->Cell(20, 4, "",1, 0, 'R');   
	  $this->Cell(20, 4, number_format($aRend["litros_cargados"], 2, ",", "."),1, 0, 'R'); 
	  $litros += $aRend["litros_cargados"];
	  
	  $this->row += 4;
	     
      foreach($nac as $r) {
	     $suma += $r["dren_monto"];
	     
	     $this->SetXY(20, $this->row);
	     $this->Cell(40, 4, $r["item_descripcion"], 1, 0, "L");
	     $this->Cell(20, 4, $r["dren_monto"]>0?"$".number_format($r["dren_monto"], 0, ",", "."):"",1, 0, 'R'); 
	     
	     if ($r["item_litros"]=="S") {
	        $this->Cell(20, 4, number_format($r["dren_litros"], 2, ",", "."),1, 0, 'R'); 
	        $litros += $r["dren_litros"];
         }
	     //else
	        //$this->Cell(20, 5, "",1, 0, 'R');
	     
	     $this->row += 4;
      }
      $this->SetXY(20, $this->row);
      $this->Cell(40, 4, "SUB.TOTAL", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($suma, 0, ",", "."),1, 0, 'R'); 
      //$this->Cell(20, 5, "",1, 0, 'R'); 
      $this->row += 4;
      $this->SetXY(20, $this->row);
      $this->Cell(40, 4, "ASIGNADO", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($fondo["fond_monto"] + $sumaGiro, 0, ",", "."),1, 0, 'R'); 
      
      $this->row += 4;
      $this->SetXY(20, $this->row);
      $this->Cell(40, 4, "DIFERENCIA", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($fondo["fond_monto"] + $sumaGiro-$suma, 0, ",", "."),1, 0, 'R'); 
      
      $this->row += 4;
      $this->SetXY(20, $this->row);
      $this->Cell(40, 4, "DEVOLUCION DINEROS", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($aRend["rend_devol_chofer"], 0, ",", "."),1, 0, 'R');
      
      $saldo_empresa=0;
      $saldo_chofer =0;
      
      
      
      //$this->Cell(20, 5, "",1, 0, 'R'); 
      $this->row += 4;
      $this->SetXY(20, $this->row);
      

      
      if ( $fondo["fond_monto"]-$suma-$aRend["rend_devol_chofer"] > 0) {
         $this->Cell(40, 4, "SALDO A ENTREGAR", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($fondo["fond_monto"]+$sumaGiro-$suma-$aRend["rend_devol_chofer"], 0, ",", "."),1, 0, 'R'); 
         
         $saldo_empresa += $fondo["fond_monto"]+$sumaGiro-$suma-$aRend["rend_devol_chofer"];
      }
      
      if ( $fondo["fond_monto"]-$suma-$aRend["rend_devol_chofer"] < 0) 
      {
         $this->Cell(40, 4, "PAGAR A CHOFER", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format(-($fondo["fond_monto"]+$sumaGiro-$suma-$aRend["rend_devol_chofer"]), 0, ",", "."),1, 0, 'R'); 
         
         $saldo_chofer +=  -($fondo["fond_monto"]+$sumaGiro-$suma-$aRend["rend_devol_chofer"]);
      }      
      
      if ($aRend["rend_pagado_chofer"] > 0) 
      {
	     $this->row += 4;
         $this->SetXY(20, $this->row);
         $this->Cell(40, 4, "PAGADO CHOFER", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($aRend["rend_pagado_chofer"], 0, ",", "."),1, 0, 'R'); 
         
         $saldo_chofer +=  -$aRend["rend_pagado_chofer"];
      } 
      
      $rowFinal = $this->row;   
      
      //$this->Cell(20, 5, "",1, 0, 'R'); 
      
      if ($moneda2!="") {
	     
	     $this->row = $rowInicio-4;
	     $this->col = 130;
	     
	     $this->SetFont('Arial','B',9);
	     $this->SetXY($this->col, $this->row);
	     $this->Cell(40, 4, $moneda2, 1, 0, "L");
	     $this->Cell(20, 4, "",1, 0, 'R'); 
	     $this->Cell(20, 4, "PARIDAD",1, 0, 'R');
	     $this->Cell(20, 4, "LITROS",1, 0, 'R'); 
	     $this->row += 4;
	     
	     $this->SetFont('Arial','',8);
	     
	     $this->SetXY($this->col, $this->row);
	     $this->Cell(40, 4, "LITROS IDA MENDOZA", 1, 0, "L");
	     $this->Cell(20, 4, "",1, 0, 'R'); 	        
	     $this->Cell(20, 4, "",1, 0, 'R'); 
	        
	     $this->Cell(20, 4, number_format($aRend["rend_litros_ida_mendoza"], 2, ",", "."),1, 0, 'R'); 
	     $litros += $aRend["rend_litros_ida_mendoza"];
         
            
         $this->row += 4;   
         
         $this->SetXY($this->col, $this->row);
	     $this->Cell(40, 4, "LITROS REGRESO MENDZA", 1, 0, "L");
	     $this->Cell(20, 4, "",1, 0, 'R'); 	        
	     $this->Cell(20, 4, "",1, 0, 'R'); 
	        
	     $this->Cell(20, 4, number_format($aRend["rend_litros_regreso_mendoza"], 2, ",", "."),1, 0, 'R'); 
	     $litros += $aRend["rend_litros_regreso_mendoza"];
         
            
         $this->row += 4;   
	            
	     $sumaGiro=0;
	     $sumaNac =0;
	     foreach($this->fondo["giros"] as $g) {
	         if ($g["mone_id"]==1) 
	            $sumaGiro += $g["giro_monto"];
	         else
	            $sumaNac  += $g["giro_monto"];
	         
         }
      
         $fondo["fond_monto2"] += $sumaGiro;
         
         $suma=0;
	     $sPesos=0;
	     $tasa=0;
	     $tasa=0;
         foreach($mon2 as $r) {
	        $suma += $r["dren_monto"];
	     	         
	        $this->SetXY($this->col, $this->row);
	        $this->Cell(40, 4, $r["item_descripcion"], 1, 0, "L");
	        $this->Cell(20, 4, $r["dren_monto"]>0?"$".number_format($r["dren_monto"], 2, ",", "."):"",1, 0, 'R'); 
	        
	        $tasa    = $r["mone_paridad"];
	        $paridad = round($r["dren_monto"]*$r["mone_paridad"], 0);
	        
	        $sPesos += $paridad;
	        
	        $this->Cell(20, 4, $paridad>0?"$".number_format($paridad, 0, ",", "."):"",1, 0, 'R'); 
	        
	        if ($r["item_litros"]=="S") {
	           $this->Cell(20, 4, number_format($r["dren_litros"], 2, ",", "."),1, 0, 'R'); 
	           $litros += $r["dren_litros"];
            }
	        //else
	           //$this->Cell(20, 5, "",1, 0, 'R');
	        
	        $this->row += 4;
         }
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "SUB.TOTAL", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($suma, 2, ",", "."),1, 0, 'R'); 
         //$this->Cell(20, 5, "",1, 0, 'R'); 
         $this->Cell(20, 4, $sPesos>0?"$".number_format($sPesos, 0, ",", "."):"",1, 0, 'R');
         $this->row += 4;
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "ASIGNADO", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($fondo["fond_monto2"], 2, ",", "."),1, 0, 'R'); 
         $this->Cell(20, 4, number_format(round(($fondo["fond_monto2"])*$tasa,0), 0, ",", "."),1, 0, 'R');
         
         $this->row += 4;
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "DIFERENCIA", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($fondo["fond_monto2"]-$suma, 0, ",", "."),1, 0, 'R'); 
         $this->Cell(20, 4, "$".number_format(round(($fondo["fond_monto2"]-$suma)*$tasa,0), 0, ",", "."),1, 0, 'R');
         
         $this->row += 4;
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "DEVOLUCION DINEROS", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($aRend["rend_devol_chofer_mon2"], 0, ",", "."),1, 0, 'R'); 
         $this->Cell(20, 4, "$".number_format(round($aRend["rend_devol_chofer_mon2"]*$tasa,0), 0, ",", "."),1, 0, 'R');
         
         
         //$this->Cell(20, 5, "",1, 0, 'R'); 
         $this->row += 4;
         $this->SetXY($this->col, $this->row);
         
         if ( $fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"] > 0) {
            $this->Cell(40, 4, "DEUDA DEL CHOFER", 1, 0, "L");
            $this->Cell(20, 4, "$".number_format($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"], 0, ",", "."),1, 0, 'R'); 
            $this->Cell(20, 4, "$".number_format(round(($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"])*$tasa,0), 0, ",", "."),1, 0, 'R');
            
            $saldo_empresa += round(($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"])*$tasa,0);
         }
         
         if ( $fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"] < 0) 
         {
            $this->Cell(40, 4, "PAGAR A CHOFER", 1, 0, "L");
            $this->Cell(20, 4, "$".number_format(-($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"]), 0, ",", "."),1, 0, 'R'); 
            $this->Cell(20, 4, "$".number_format(-round(($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"])*$tasa,0), 0, ",", "."),1, 0, 'R');
            
            $saldo_chofer +=  -round(($fondo["fond_monto2"]-$suma-$aRend["rend_devol_chofer_mon2"])*$tasa,0);
         }    
         
         if ($aRend["rend_pagado_chofer_mon2"] > 0) 
         {
	        $this->row += 4;
            $this->SetXY($this->col, $this->row);
            $this->Cell(40, 4, "PAGADO A CHOFER", 1, 0, "L");
            $this->Cell(20, 4, "$".number_format($aRend["rend_pagado_chofer_mon2"], 0, ",", "."),1, 0, 'R'); 
            $this->Cell(20, 4, "$".number_format(round($aRend["rend_pagado_chofer_mon2"]*$tasa,0), 0, ",", "."),1, 0, 'R');
            
            $saldo_chofer +=  -round($aRend["rend_pagado_chofer_mon2"]*$tasa,0);
         }     
         
         
            
         //$this->Cell(20, 5, "$".number_format($fondo["fond_monto2"]-$suma, 2, ",", "."),1, 0, 'R'); 
         //$this->Cell(20, 5, "$".number_format($asignado-$sPesos, 0, ",", "."),1, 0, 'R'); 
         //$this->Cell(20, 5, "",1, 0, 'R');          
      }
      
      $this->col = 130;
      $this->row += 8;
      $this->SetXY($this->col, $this->row);
      $this->Cell(60, 4, "TOTALES", 1, 0, "C");
      
      $this->row += 4;
      $this->SetXY($this->col, $this->row);
      $this->Cell(40, 4, "SALDO FAVOR EMPRESA", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($saldo_empresa, 0, ",", "."),1, 0, 'R'); 
      
      $this->row += 4;
      $this->SetXY($this->col, $this->row);
      $this->Cell(40, 4, "SALDO FAVOR CHOFER", 1, 0, "L");
      $this->Cell(20, 4, "$".number_format($saldo_chofer, 0, ",", "."),1, 0, 'R'); 
      
      if ($saldo_empresa > $saldo_chofer) {
	     $this->row += 4;
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "DEBE A EMPRESA", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format($saldo_empresa - $saldo_chofer, 0, ",", "."),1, 0, 'R'); 
      }
      else {
	     $this->row += 4;
         $this->SetXY($this->col, $this->row);
         $this->Cell(40, 4, "DEBE A CHOFER", 1, 0, "L");
         $this->Cell(20, 4, "$".number_format(-($saldo_chofer-$saldo_empresa), 0, ",", "."),1, 0, 'R'); 	      
      }

      
      $rend_kms_salida   = $this->rendicion["rend_kms_salida"    ];
      $rend_kms_llegada  = $this->rendicion["rend_kms_llegada" ];
      
      $this->row = $rowFinal + 4;
	  
	  $this->SetFont('Arial','',8);
	  $this->row += 4; $this->SetXY(20, $this->row);$this->Cell(60, 4, "SALIDA VEHICULO KMS", 1, 0, "L");         $this->Cell(20, 4, number_format($rend_kms_salida                   > 0?$rend_kms_salida                  :0,2, ",", "."), 1, 0, "R"); 
	  $this->row += 4; $this->SetXY(20, $this->row);$this->Cell(60, 4, "LLEGADA VEHICULO KMS", 1, 0, "L");        $this->Cell(20, 4, number_format($rend_kms_llegada                  > 0?$rend_kms_llegada                 :0,2, ",", "."), 1, 0, "R"); 
	  $this->row += 4; $this->SetXY(20, $this->row);$this->Cell(60, 4, "TOTAL KILOMETROS RECORRIDOS", 1, 0, "L"); $this->Cell(20, 4, number_format($rend_kms_llegada-$rend_kms_salida > 0?$rend_kms_llegada-$rend_kms_salida:0,2, ",", "."), 1, 0, "R"); 
	  $this->row += 4; $this->SetXY(20, $this->row);$this->Cell(60, 4, "TOTAL LITROS CONSUMIDOS", 1, 0, "L");     $this->Cell(20, 4, number_format($litros                            > 0?$litros                           :0,2, ",", "."), 1, 0, "R"); 
	  
	  if ($litros > 0)
	     $rendimiento = ($rend_kms_llegada-$rend_kms_salida)/$litros;
	  
	  $this->row += 4; $this->SetXY(20, $this->row);$this->Cell(60, 4, "TOTAL RENDIMIENTO POR LITRO", 1, 0, "L"); $this->Cell(20, 4, $litros>0?number_format($rendimiento, 2, ",", "."):""                           , 1, 0, "R");            
	  	  
	  $this->row += 28;
	  
	  $this->SetXY(20, $this->row);
	  $this->Cell(60, 4, "FIRMA CHOFER",  "T", 0, "C");
	  $this->Cell(50, 4, "",              0,   0, "L");
	  $this->Cell(60, 4, "FIRMA REVISOR", "T", 0, "C");
	  
	  
   }
   
   //Page footer
   //function Footer()
   //{
   //    // Position at 1.5 cm from bottom
   //    $this->SetY(-1.5);
   //    // Arial italic 8
   //    $this->SetFont('Arial','I',8);
   //    // Page number
   //    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
   //}
}   
