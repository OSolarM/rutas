<?php
   class ClientesController extends AppController {
      var $name="Clientes";
      var $uses=array("Cliente", "Crt", "OrdenNacional", "LibroVenta", "Parametro", "Chofer");

      function index($page=null) {
         $recsXPage=20;
         
         //$fact["475/2013/CH"] = 1463;
         //$fact["486/2013/CH"] = 1466;
         //$fact["487/2013/CH"] = 1477;
         //$fact["490/2013/CH"] = 1468;
         //$fact["489/2013/CH"] = 1477;
         //$fact["491/2013/CH"] = 1478;
         //$fact["492/2013/CH"] = 1479;
         //$fact["493/2013/CH"] = 1480;
         //$fact["494/2013/CH"] = 1481;
         //$fact["495/2013/CH"] = 1482;
         //
         //foreach($fact as $key => $val) {
	     //    $sql = "update crts set factura_crt=$val where crts_numero='$key';";
	     //    
	     //    echo $sql."<hr>";
         //} 

            
         if (isset($_REQUEST["page"])) {
	        $page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
         }
         else if ($page!=null) {
	        $e       = explode(":", $page);
	        if (count($e) >= 1) $page    =$e[0]; else $page=1;
	        if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="id";
	        if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="asc";
         }
         else {
	        $page    = 1;
            $sortKey ="id";
            $orderKey="asc";
         }
              
         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         $arreglo = $this->Cliente->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/clientes/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Cliente->count(), $recsXPage);
         
         $this->assign("clientes", $arreglo);
         $this->assign('pagination', $pagination->links());
         
    
          $g = new MiGrid();
          
          $g->addField("N&uacute;mero","id", array("align" => "right"));
          $g->addField("Rut",          "rut");
          $g->addField("Raz&oacute;n Social", "razon");
          $g->addField("Direcci&oacute;n",    "direccion");
          $g->addField("Comuna",       "comuna");
          $g->addField("Ciudad",       "ciudad");          
          $g->addField("Regi&oacute;n",       "region", array("align" => "center"));
          $g->addField("Pa&iacute;s",       "pais");
          $g->addField("Bloqueo",            "bloqueo", array("align" => "center", 
                                                                   "trad"  => array("S"=>"S?", "N" => "No")
                                                                   )
                      );
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
          
          //echo $g->show();
           
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Cliente->save($this->data))
               $this->redirect("/clientes");
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["Cliente"]["estadia"] = 0;
            $this->data["Cliente"]["bloqueo"] = "N";
            $this->data["Cliente"]["valor"] = 0;
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Cliente->save($this->data)) {
               $this->redirect("/clientes");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Cliente->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Cliente->delete($id)) 
            $this->redirect("/clientes");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      
      function facturas_pendientes($page=null) {
         $recsXPage=20;

            
         if (isset($_REQUEST["page"])) {
	        $page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
         }
         else if ($page!=null) {
	        $e       = explode(":", $page);
	        if (count($e) >= 1) $page    =$e[0]; else $page=1;
	        if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="id";
	        if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="asc";
         }
         else {
	        $page    = 1;
            $sortKey ="id";
            $orderKey="asc";
         }
              
         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         $arreglo = $this->Crt->findAll("crts_facturable='S' and crts_estado='C' and (factura_crt is null or factura_crt=0) and facturar_id is not null", null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/clientes/facturas_pendientes", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Crt->count(), $recsXPage);
         
         $this->assign('pagination', $pagination->links());
         
    
          $g = new MiGrid2();
          
          $g->addField("N&uacute;mero","crts_numero");
          $g->addField("Fecha",          "fecha");
          $g->addField("Operaci&oacute;n", "tipo_operacion", array("trad" => array("E" => "Exportaci&oacute;n", "I" => "Importaci&oacute;n"))); 
          $g->addField("Rut",      "rut");
          $g->addField("Cliente", "razon");
          $g->addField("Destinatario", "razon_a");
          $g->addField("Valor", "crts_valor_flete");
          $g->addField("Moneda", "crts_mon_flete");
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
          
          //echo $g->show();	      
      }
      
      function reparaValor($n) {
		  $s="";
		  for($i=0; $i < strlen($n); $i++)
		     if (substr($n, $i, 1) >= "0" && substr($n, $i, 1) <= "9" || substr($n, $i, 1) == ",") 
		        $s .= ".";
		     else
		        $s .= substr($n, $i, 1);
		  
		  //echo "reparaValor: $s<br>";      
		  return $s;
	  }  
      
      function factura_crt($id) {
	     
	     if (!empty($this->data)) {
		    $fpago=$_REQUEST["fpago"];
		    
		    $id          = $_REQUEST["id"];
		    $no_factura  = $_REQUEST["no_factura"];
		    $fec_factura = $_REQUEST["fec_factura"];
		    $concepto    = $_REQUEST["concepto"];
		    $desde       = $_REQUEST["desde"];
		    $hasta       = $_REQUEST["hasta"];
		    
		    $this->set("concepto", $concepto);
		    $this->set("desde",    $desde);
		    $this->set("hasta",    $hasta);
		     
		    //Actualizo no_factura
		    $d = $this->Crt->read(null, $id);
		 
		    $crts_valor_flete = $this->reparaValor($d["Crt"]["crts_valor_flete"]);
		    $crts_mon_flete   = $d["Crt"]["crts_mon_flete"];
		    
		    $d["Crt"]["factura_crt"]=$no_factura;
		    
		    $this->Crt->save($d);
		    //===================================
		    
		    $this->OrdenNacional->imprimir_facturaEx($id, $no_factura, $fec_factura, $this->Crt, $this->Cliente, $desde, $hasta, $fpago, $fec_factura, $concepto);	
		    
		    //Pasar a libro de ventas
		    $d = $this->Crt->read(null, $id);
	        
	        $facturar_id=$d["Crt"]["facturar_id"];
	        
	        $dd = $this->Cliente->read(null, $facturar_id);
	        $rut   = $dd["Cliente"]["rut"];
	        $razon = $dd["Cliente"]["razon"];
	        
	        $vendor = $dd["Cliente"]["vendor"];
	        
	        $lv = array();
	        
	        $crts_valor_flete = $this->reparaValor($d["Crt"]["crts_valor_flete"]);
	        $crts_valor_flete = round($crts_valor_flete*496.89, 0);
	        
	        $lv["LibroVenta"]["id"		  ] = "";
	        $lv["LibroVenta"]["tipo_docto"] = "I";
	        $lv["LibroVenta"]["crt_id"	  ] = $id;
	        $lv["LibroVenta"]["fecha"	  ] = $fec_factura;
	        $lv["LibroVenta"]["rut"		  ] = $rut;
	        $lv["LibroVenta"]["razon"	  ] = $razon;
	        $lv["LibroVenta"]["docto"	  ] = "FA";
	        $lv["LibroVenta"]["numero"	  ] = $no_factura;
	        $lv["LibroVenta"]["emision"	  ] = $fec_factura;
	        $lv["LibroVenta"]["vencto"	  ] = $fec_factura;
	        $lv["LibroVenta"]["neto"	  ] = $crts_valor_flete;
	        $lv["LibroVenta"]["iva"		  ] = "0";
	        $lv["LibroVenta"]["total"	  ] = $crts_valor_flete;
	        $lv["LibroVenta"]["estado"    ] = "I";
	        
	        $this->LibroVenta->save($lv);
		    
	        //print_r($lv); print_r($this->LibroVenta->errorList);
		    
		    $this->redirect("/clientes/facturas_pendientes");
	     }
	      
	     if (empty($this->data))  {
	        $this->data = $this->Crt->read(null, $id);
	        
	        //echo $this->data["Crt"]["crts_valor_flete"]."<hr>";
	        
	        $facturar_id=$this->data["Crt"]["facturar_id"];
	        
	        $dd = $this->Cliente->read(null, $facturar_id);
	        
	        $vendor = $dd["Cliente"]["vendor"];
	        
	        
	        
	        $concepto = "TRASLADO DE MERCADERIAS DESDE\n".
	                    $this->data["Crt"]["crts_desde"]." A ".$this->data["Crt"]["crts_hasta"]."\n".
	                    "SEGUN CRT ".$this->data["Crt"]["crts_numero"]."\n\n\n".
	                    "AMPARADO POR FACTURA ".$this->data["Crt"]["crts_factura"]."\n";
	                    
	        if ($this->data["Crt"]["tipo_operacion"]=="I") {
		       $concepto .= $this->data["Crt"]["crts_cant_clase_bultos"]."\n".
		                    $this->data["Crt"]["crts_decl_valor"]." ".$this->data["Crt"]["crts_docto_anexo"];
	        }
	        else {
		       $concepto .= $this->data["Crt"]["crts_cant_clase_bultos"]."\n".
		                    $this->data["Crt"]["crts_decl_valor"]."\n".$this->data["Crt"]["crts_docto_anexo"];
	        }
	        
	        if ($vendor!="") $concepto .= "\nVENDOR: $vendor";
	        
	        $this->set("concepto", $concepto);
	        $this->set("desde", $this->data["Crt"]["crts_desde"]);
	        $this->set("hasta", $this->data["Crt"]["crts_hasta"]);
        }
	        
	     $this->set("fec_factura", date("d-m-Y"));
	     $this->set("fpago", "contado");        
      }
      
      function rep_facturas_pendientes() {
	     $this->layout = "facturas_pendientes";
	     
	     while (ob_get_level())
            ob_end_clean();
         
         $arreglo = $this->Crt->findAll("crts_facturable='S' and crts_estado='C' and (factura_crt is null or factura_crt=0) and facturar_id is not null ", null, "crts_numero");
         
          // Instanciation of inherited class
         $pdf = new PDF_Pendientes("L");
         
         $pdf->SetFont('Times','',12);
         
         //print_r($nacional);
         
         $pdf->Run($arreglo);
         $pdf->Output();
              
      }
      
      function rep_crts_ingresados() {
	     $this->layout = "facturas_pendientes";
	     
	     while (ob_get_level())
            ob_end_clean();
         
         $arreglo = $this->Crt->findAll("crts_facturable='S' and crts_estado<>'C'", null, "crts_numero");
         
          // Instanciation of inherited class
         $pdf = new PDF_Ingresados("L");
         
         $pdf->SetFont('Times','',12);
         
         //print_r($nacional);
         
         $pdf->Run($arreglo);
         $pdf->Output();
              
      }
      
      function libro_ventas() {
	     $d = $this->Parametro->read(null, 1);
	     $mes_lvta  = $d["Parametro"]["mes_lvta"];
	     $agno_lvta = $d["Parametro"]["agno_lvta"];
	     
	     $arr = $this->LibroVenta->findAll("month(fecha)=$mes_lvta and year(fecha)=$agno_lvta");
	     
	     $this->set("mes",  mesPal($mes_lvta));
	     $this->set("agno_lvta", $agno_lvta);
	     $this->set("libro", $arr);
      }
      
      function info_estadia() {
	     $this->Cliente->validate=array();
	     $this->Cliente->validate["fecini"]= "required|type=date";
	     $this->Cliente->validate["fecfin"]= "required|type=date";
	     if (!empty($this->data)) {
		    $fecini = $_REQUEST["fecini"];
		    $fecfin = $_REQUEST["fecfin"];
		    
		    $this->data["Cliente"]["fecini"] = $fecini;
		    $this->data["Cliente"]["fecfin"] = $fecfin;
		    $this->Cliente->setData($this->data);
		    
		    if ($this->Cliente->validates()) {
			   $this->imprimePdfEstadia($fecini, $fecfin);
		    }
	     }
	     
	     if (empty($this->data)) {
		    $this->set("fecini", date("d/m/Y"));
		    $this->set("fecfin", date("d/m/Y"));
	     }
      }
      
      
      function imprimePdfEstadia($fecini, $fecfin) {
         while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         	      
	     $layout = "form";
	     
	     include_once(APP_PATH."/app/pdfs/PDF_dias_choferes.php");
	     
	     $pdf = new PDF_dias_choferes("P");
	     
	     
	     $pdf->Run($this->Crt, $this->Chofer, $this->Parametro, $fecini, $fecfin);
	     
	     $pdf->Output();	      
      }
      
      function info_estadia_clientes() {
	     $this->Cliente->validate=array();
	     $this->Cliente->validate["fecini"]= "required|type=date";
	     $this->Cliente->validate["fecfin"]= "required|type=date";
	     if (!empty($this->data)) {
		    $fecini = $_REQUEST["fecini"];
		    $fecfin = $_REQUEST["fecfin"];
		    
		    $this->data["Cliente"]["fecini"] = $fecini;
		    $this->data["Cliente"]["fecfin"] = $fecfin;
		    $this->Cliente->setData($this->data);
		    
		    if ($this->Cliente->validates()) {
			   $this->imprimePdfEstadiaClientes($fecini, $fecfin);
		    }
	     }
	     
	     if (empty($this->data)) {
		    $this->set("fecini", date("d/m/Y"));
		    $this->set("fecfin", date("d/m/Y"));
	     }
      }
      
      function imprimePdfEstadiaClientes($fecini, $fecfin) {
         while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         	      
	     $layout = "form";
	     
	     include_once(APP_PATH."/app/pdfs/PDF_dias_clientes.php");
	     
	     $pdf = new PDF_dias_clientes("P");
	     
	     
	     $pdf->Run($this->Cliente, $this->Parametro, $fecini, $fecfin, $this);
	     
	     $pdf->Output();	      
      }            
   }

   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    $id = $row["id"];
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/clientes/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }
   
   
   class MiGrid2 extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    $id = $row["id"];
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/clientes/factura_crt/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Facturar</a></td>";
         }    
      }
   }
   
   class PDF_Pendientes extends FPDF
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
      
   // Page header
   function Header()
   {
   	$this->row=5; 
       $this->SetFont('Arial','BI',15);
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
       
       $this->row +=10;
       $this->SetFont('Arial','B',12);
       $this->SetXY(0, $this->row);
       
       $this->Cell(0,10,utf8_decode("Transporte Internacional: Reporte de Facturas Pendientes"),0,0,'C');
      
       $this->SetFont('Arial','',10);
       
       $this->row += 20;
       
       $this->SetXY(7, $this->row);
	   $this->Cell(30, 5, utf8_decode("Número"      ), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Fecha"       ), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Tipo Oper."  ), "TB", 0, "C");
	   $this->Cell(22, 5, utf8_decode("Rut"         ), "TB", 0, "C");
	   $this->Cell(75, 5, utf8_decode("Cliente"     ), "TB", 0, "C");
	   $this->Cell(75, 5, utf8_decode("Destinatario"), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Valor Flete" ), "TB", 0, "C");
	   $this->Cell(10, 5, utf8_decode("MDA"         ), "TB", 0, "C");
       
	   $this->row += 5;
 
   
       /*$this->row +=10; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Fecha de Rendición:"));   $this->Cell(20, 5, $rend_fecha);*/
       /*$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(38, 5, utf8_decode("Número de Expedición: "));   $this->Cell(20, 5, $expe_nro);    */
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Nombre Conductor: ");    $this->Cell(40, 5, $chofer);
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Camión: "));    $this->Cell(40, 5, $cami_patente);
       ///*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(22, 5, utf8_decode("Acoplado: "));    $this->Cell(40, 5, $acop_patente);
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Fecha y lugar de salida: ");    $this->Cell(40, 5, $rend_fecha_salida." ".$rend_lugar_salida);
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Fecha y lugar de llegada: ");   $this->Cell(40, 5, $rend_fecha_llegada." ".$rend_lugar_llegada);
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Destino: "); $this->Cell(20, 5, $expe_destino);    
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Días viaje nacional: "));  $this->Cell(20, 5, $rend_dias_viaje_nac);    
       ///*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(22, 5, utf8_decode("Días viaje internacional: "));   $this->Cell(20, 5, $rend_dias_viaje_int);        
       //
       //if ($crts!="") {
	   //   $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("CRT(s): "));   $this->Cell(20, 5, $crts);        
       //}
       //
       //// Line break
       //$this->Ln(1);
       //
       //$this->row += 10;
       //
       //$this->SetXY(20, $this->row); 
       
       
   }
   
   function Run($arreglo) {
      

      
      $this->AliasNbPages();
      $this->AddPage();
      
      $this->SetFont('Arial','',10);    
      
      foreach($arreglo as $r) {
	     $crts_numero       = $r["crts_numero"     ];
	     $fecha             = $r["fecha"           ];
	     $tipo_operacion    = $r["tipo_operacion" ];
	     $rut               = $r["rut"             ];
	     $razon             = $r["razon"           ];
	     $razon_a           = $r["razon_a"         ];
	     $crts_valor_flete  = $r["crts_valor_flete"];
	     $crts_mon_flete    = $r["crts_mon_flete"  ]; 
	      
	      
     
	     $this->SetXY(7, $this->row);
	     $this->Cell(30, 5, $crts_numero,            0, 0, "L");
	     $this->Cell(20, 5, $fecha,                  0, 0, "L");
	     $this->Cell(20, 5, $tipo_operacion=="I"?"Import.":"Export.",         0, 0, "L");
	     $this->Cell(22, 5, $rut,                    0, 0, "L");
	     $this->Cell(75, 5, substr($razon  , 0, 34), 0, 0, "L");
	     $this->Cell(75, 5, substr($razon_a, 0, 34), 0, 0, "L");
	     $this->Cell(20, 5, $crts_valor_flete,       0, 0, "R");
	     $this->Cell(10, 5, $crts_mon_flete,         0, 0, "L");
	     
	     $this->row += 5;
      }
   }
   
   // Page footer
   function Footer()
   {
       // Position at 1.5 cm from bottom
       $this->SetY(-15);
       // Arial italic 8
       $this->SetFont('Arial','I',8);
       // Page number
       $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
   }
   }   
   
   class PDF_Ingresados extends FPDF
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
      
   // Page header
   function Header()
   {
   	$this->row=5; 
       $this->SetFont('Arial','BI',15);
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
       
       $this->row +=10;
       $this->SetFont('Arial','B',12);
       $this->SetXY(0, $this->row);
       
       $this->Cell(0,10,utf8_decode("Transporte Internacional: Reporte de CRTS no cerrados"),0,0,'C');
      
       $this->SetFont('Arial','',10);
       
       $this->row += 20;
       
       $this->SetXY(7, $this->row);
	   $this->Cell(30, 5, utf8_decode("Número"      ), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Fecha"       ), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Tipo Oper."  ), "TB", 0, "C");
	   $this->Cell(22, 5, utf8_decode("Rut"         ), "TB", 0, "C");
	   $this->Cell(75, 5, utf8_decode("Cliente"     ), "TB", 0, "C");
	   $this->Cell(75, 5, utf8_decode("Destinatario"), "TB", 0, "C");
	   $this->Cell(20, 5, utf8_decode("Valor Flete" ), "TB", 0, "C");
	   $this->Cell(10, 5, utf8_decode("MDA"         ), "TB", 0, "C");
       
	   $this->row += 5;
 
   
       /*$this->row +=10; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Fecha de Rendición:"));   $this->Cell(20, 5, $rend_fecha);*/
       /*$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(38, 5, utf8_decode("Número de Expedición: "));   $this->Cell(20, 5, $expe_nro);    */
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Nombre Conductor: ");    $this->Cell(40, 5, $chofer);
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Camión: "));    $this->Cell(40, 5, $cami_patente);
       ///*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(22, 5, utf8_decode("Acoplado: "));    $this->Cell(40, 5, $acop_patente);
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Fecha y lugar de salida: ");    $this->Cell(40, 5, $rend_fecha_salida." ".$rend_lugar_salida);
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Fecha y lugar de llegada: ");   $this->Cell(40, 5, $rend_fecha_llegada." ".$rend_lugar_llegada);
       //
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, "Destino: "); $this->Cell(20, 5, $expe_destino);    
       //$this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("Días viaje nacional: "));  $this->Cell(20, 5, $rend_dias_viaje_nac);    
       ///*$this->row += 5; $this->SetXY(20, $this->row);*/ $this->Cell(22, 5, utf8_decode("Días viaje internacional: "));   $this->Cell(20, 5, $rend_dias_viaje_int);        
       //
       //if ($crts!="") {
	   //   $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(42, 5, utf8_decode("CRT(s): "));   $this->Cell(20, 5, $crts);        
       //}
       //
       //// Line break
       //$this->Ln(1);
       //
       //$this->row += 10;
       //
       //$this->SetXY(20, $this->row); 
       
       
   }
   
   function Run($arreglo) {
      

      
      $this->AliasNbPages();
      $this->AddPage();
      
      $this->SetFont('Arial','',10);    
      
      foreach($arreglo as $r) {
	     $crts_numero       = $r["crts_numero"     ];
	     $fecha             = $r["fecha"           ];
	     $tipo_operacion    = $r["tipo_operacion" ];
	     $rut               = $r["rut"             ];
	     $razon             = $r["razon"           ];
	     $razon_a           = $r["razon_a"         ];
	     $crts_valor_flete  = $r["crts_valor_flete"];
	     $crts_mon_flete    = $r["crts_mon_flete"  ]; 
	      
	      
     
	     $this->SetXY(7, $this->row);
	     $this->Cell(30, 5, $crts_numero,            0, 0, "L");
	     $this->Cell(20, 5, $fecha,                  0, 0, "L");
	     $this->Cell(20, 5, $tipo_operacion=="I"?"Import.":"Export.",         0, 0, "L");
	     $this->Cell(22, 5, $rut,                    0, 0, "L");
	     $this->Cell(75, 5, substr($razon  , 0, 34), 0, 0, "L");
	     $this->Cell(75, 5, substr($razon_a, 0, 34), 0, 0, "L");
	     $this->Cell(20, 5, $crts_valor_flete,       0, 0, "R");
	     $this->Cell(10, 5, $crts_mon_flete,         0, 0, "L");
	     
	     $this->row += 5;
      }
   }
   
   // Page footer
   function Footer()
   {
       // Position at 1.5 cm from bottom
       $this->SetY(-15);
       // Arial italic 8
       $this->SetFont('Arial','I',8);
       // Page number
       $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
   }
   }   
      