<?php
   class FondosController extends AppController {
      var $name="Fondos";
      var $uses=array("Fondo", "Expedicion", "Dexpedicion", "Chofer", "Camion", "Acoplado", "Combustible");

      function index($page=1) {
	      
	     $criterio= $this->request("criterio", "S");
	     
	     $this->set("criterio", $criterio);
	     
	     $this->agrega_pendientes();
	     
         $recsXPage=20;
         
         $sAdicional="fond_cierre is null";
         if ($criterio=="S")
            $sAdicional .=" and fond_monto=0";
         
         $arreglo = $this->Fondo->findAll($sAdicional, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
         //echo $sAdicional."<hr>"; 
         
         $pagination = new pagination("/fondos/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Fondo->count(), $recsXPage);
     
         //print_r($arreglo);
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $data = $this->Expedicion->read(0, $arreglo[$i]["expe_id"]);
	        
	        //print_r($data);
	        
	        $chof_id = $data["Expedicion"]["chof_id"]; 
	        $cami_id = $data["Expedicion"]["cami_id"]; 
	        $acop_id = $data["Expedicion"]["acop_id"]; 
	        
            if ($this->Chofer->findByPk($chof_id))
               $arreglo[$i]["chof_nombres"] = $this->Chofer->data["Chofer"]["chof_apellidos"]." ".$this->Chofer->data["Chofer"]["chof_nombres"];

            if ($this->Camion->findByPk($cami_id))
               $arreglo[$i]["cami_patente"] = $this->Camion->data["Camion"]["cami_patente"];

            if ($acop_id!="" && $this->Acoplado->findByPk($acop_id))
               $arreglo[$i]["acop_patente"] = $this->Acoplado->data["Acoplado"]["acop_patente"];
               
            $expe_id = $arreglo[$i]["id"];
	         
	        $data = $this->Combustible->findAll("expe_tipo='N' and expe_id=$expe_id");
	        
	        if (count($data) > 0)
	           $arreglo[$i]["combustible"]="Si";
	        else
	           $arreglo[$i]["combustible"]="No";             
 
         }

         //print_r($arreglo); 
         
         $this->assign("expediciones", $arreglo);
         $this->assign('pagination', $pagination->links());
      }
      
      function agrega_pendientes() {
	     $arr = $this->Expedicion->findAll("expe_cerrado='S' and id not in (select expe_id from fondos)");
	     
	     foreach($arr as $r) {
		    $data["Fondo"]["id"          ] = "";
		    $data["Fondo"]["expe_id"     ] = $r["id"];
            $data["Fondo"]["fond_fecha"  ] = $r["expe_fecha"];
            $data["Fondo"]["fond_glosa"  ] = "FONDOS EXPEDICION ".$r["expe_nro"];
            $data["Fondo"]["fond_monto"  ] = "0";
            $data["Fondo"]["fond_monto_adicional"  ] = "0";
            $data["Fondo"]["fond_bloqueo"] = "N";
            
            $this->Fondo->save($data);
	     }
      }

      function index_imprimir($page=1) {
         $recsXPage=10;
         
         $arreglo = $this->Fondo->findAll("expe_id in (select id from expediciones)", null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/fondos/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Fondo->count(), $recsXPage);
     
         //print_r($arreglo);
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $data = $this->Expedicion->read(0, $arreglo[$i]["expe_id"]);
	        
	        //print_r($data);
	        
	        $chof_id = $data["Expedicion"]["chof_id"]; 
	        $cami_id = $data["Expedicion"]["cami_id"]; 
	        $acop_id = $data["Expedicion"]["acop_id"]; 
	        
            if ($this->Chofer->findByPk($chof_id))
               $arreglo[$i]["chof_nombres"] = $this->Chofer->data["Chofer"]["chof_apellidos"]." ".$this->Chofer->data["Chofer"]["chof_nombres"];

            if ($this->Camion->findByPk($cami_id))
               $arreglo[$i]["cami_patente"] = $this->Camion->data["Camion"]["cami_patente"];

            if ($acop_id!="" && $this->Acoplado->findByPk($acop_id))
               $arreglo[$i]["acop_patente"] = $this->Acoplado->data["Acoplado"]["acop_patente"];
 
         }

         //print_r($arreglo); 
         
         $this->assign("expediciones", $arreglo);
         $this->assign('pagination', $pagination->links());
      }
      
      function add() {
	     $this->layout="form";
	      
	     if (!empty($this->data)) {
		    print_r($this->data);
		    if ($this->Fondo->save($this->data))
		       $this->redirect("/fondos"); 
		    else
	           print_r($this->Fondo->errorList);
	     }
	     
	     
	     if (empty($this->data["Fondo"])) {
		    $this->data["Fondo"]["fond_fecha"] = date("d/m/Y"); 
		    $this->data["Fondo"]["fond_monto"] = "0"; 
		    $this->data["Fondo"]["fond_bloqueo"] = "N"; 		 
		    
		    $arr = $this->Fondo->findSql("select max(id) id from fondos");
		    
		    if (count($arr)==0)
		       $id = 1;
		    else    
		       $id = $arr[0]["id"]+ 1;
		       
		    //$this->data["Fondo"]["id"] = $id; 		    
	     }
	     
	     
	     
	     
	     $arreglo = $this->Expedicion->findAll("expe_cerrado='S'", null, "id desc");
         $s="|";
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $chof_id = $arreglo[$i]["chof_id"]; 
	        $cami_id = $arreglo[$i]["cami_id"]; 
	        $acop_id = $arreglo[$i]["acop_id"]; 
	        
	        $expe_id = $arreglo[$i]["id"]; 
	        $chof_nombres="";
	           
            if ($this->Chofer->findByPk($chof_id))
               $chof_nombres = $this->Chofer->data["Chofer"]["chof_apellidos"]." ".$this->Chofer->data["Chofer"]["chof_nombres"];

            if ($s!="") $s .= ",";
            
            $s .= $chof_nombres."|".$expe_id;
            
         }
         
         //echo $s;
         $this->set("choferes", $s);
      }
      
      function edit($id=null) {
         $this->layout="form";
 
	     $this->layout="form";
	      
	     if (!empty($this->data)) {
		    if ($this->Fondo->save($this->data))
		       $this->redirect("/fondos"); 
	     }
	     
	     if (empty($this->data)) {
		    $this->data = $this->Fondo->read(null, $id); 		    
	     }
	     
	     
	     $arreglo = $this->Expedicion->findAll("expe_cerrado='S'", null, "id desc");
         $s="|";
         
         //print_r($arreglo);
         for ($i=0; $i < count($arreglo); $i++) {
	        $chof_id = $arreglo[$i]["chof_id"]; 
	        $cami_id = $arreglo[$i]["cami_id"]; 
	        $acop_id = $arreglo[$i]["acop_id"]; 
	        
	        $expe_id = $arreglo[$i]["id"]; 
	        $chof_nombres="";
	           
            if ($this->Chofer->findByPk($chof_id))
               $chof_nombres = $this->Chofer->data["Chofer"]["chof_apellidos"]." ".$this->Chofer->data["Chofer"]["chof_nombres"];

            if ($s!="") $s .= ",";
            
            $s .= $chof_nombres."|".$expe_id;
            
         }
         
         //echo $s;
         $this->set("choferes", $s);
	     
	     
         //print_r($this->data);
      }

      function runPdf($id) {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
	     $data = $this->Fondo->read(null, $id);
	     
	     //print_r($data);
	     
	     $id = $data["Fondo"]["expe_id"];
	     $expe_id=$id;
	     
	     $arr = $this->Fondo->findAll("expe_id=$expe_id");
	     
	     $fondos = 0;
	     for ($i=0; $i < count($arr); $i++) {
		    $fondos += $arr[$i]["fond_monto"];
         }
	     
         // Instanciation of inherited class
         $pdf = new PDF("L");

         $this->data = $this->Expedicion->read(null, $id);

         $d = $this->data["Expedicion"];


         if ($this->Chofer->findByPk($d["chof_id"])) {
            $nombre = $this->Chofer->data["Chofer"]["chof_apellidos"]." ".$this->Chofer->data["Chofer"]["chof_nombres"];

            $pdf->chof_nombres =  $nombre;
         }


         if ($this->Camion->findByPk($d["cami_id"]))
            $pdf->cami_patente = $this->Camion->data["Camion"]["cami_patente"];

         if ($d["acop_id"]!="" && $this->Acoplado->findByPk($d["acop_id"]))
            $pdf->acop_patente = $this->Acoplado->data["Acoplado"]["acop_patente"];
         
         $pdf->expe_nro = $d["expe_nro"];
         $pdf->expe_fecha = $d["expe_fecha"];
         $pdf->expe_destino = $d["expe_destino"];
         $pdf->expe_fondos = $fondos;

         $pdf->lista = $this->Dexpedicion->findAll("expe_id=$id", null, "id");
         
         $pdf->SetFont('Times','',12);
         $pdf->Run();
         $pdf->Output();
      }

   }

class PDF extends FPDF
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
    
    $this->SetFont('Arial','B',12);
    $this->row +=10;
    $this->SetXY(0, $this->row);
    $this->Cell(0,10,utf8_decode('EXPEDICIÓN'),0,0,'C');

    $this->SetFont('Arial','',10);

    $this->row +=10; $this->SetXY(20, $this->row); $this->Cell(20, 5, utf8_decode("Número: "));   $this->Cell(20, 5, $this->expe_nro);
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, "Fecha: ");    $this->Cell(20, 5, $this->expe_fecha);
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, "Chofer: ");   $this->Cell(20, 5, $this->chof_nombres);
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, utf8_decode("Camión: "));   $this->Cell(20, 5, $this->cami_patente);    
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, "Acoplado: "); $this->Cell(20, 5, $this->acop_patente);    
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, "Destino: ");  $this->Cell(20, 5, $this->expe_destino);    
    $this->row += 5; $this->SetXY(20, $this->row); $this->Cell(20, 5, "Fondos: ");   $this->Cell(20, 5, "$".number_format($this->expe_fondos, 0, ",", "."));        
    // Line break
    $this->Ln(1);
    
    $this->row += 10;

    $this->SetXY(20, $this->row); 

    $this->Cell(20, 5, utf8_decode("Guía N°")     , 'TLB', 0, ''   );
    $this->Cell(40, 5, "Remitente"    , 'TB', 0, ''   );	
    $this->Cell(120, 5, "Destinatario" , 'TB', 0, ''   );
    $this->Cell(25, 5, "Cobra destino", 'TB', 0, ''   );
    $this->Cell(25, 5, "Factura Nro",   'TB', 0, 'R'     );
    $this->Cell(20, 5, "Valor",         'TRB', 0, 'R' );

    $this->SetXY(20, $this->row); 
}

function Run() {
   
   //$this->AddPage();

   $nGuias=0;
   $nFacturas=0;
   $nLineas=100;
   
   $rowIni=$this->row;
   
   foreach($this->lista as $r) {
	   if ($nLineas >= 21) {
		  $this->row = 5;
		  $this->AliasNbPages();
		  $this->AddPage();
		  
		  $nLineas=0;
	   }
	   
	   $nGuias++;

       $this->row += 5; 
       $this->SetXY(20, $this->row); 

       $this->Cell(20, 5, utf8_decode($r["dexp_guia"])        , 0, 0, 'R'        );
       $this->Cell(40, 5, utf8_decode(substr($r["dexp_remitente"], 0, 12)));	
       $this->Cell(120, 5, utf8_decode($r["dexp_destinatario"]));
       $this->Cell(25, 5, utf8_decode($r["dexp_cobra"]=="S"?"Si":"No")  , 0, 0, 'C'       );
       $this->Cell(25, 5, utf8_decode($r["dexp_factura"]), 0, 0, 'R'     );
       
       if ($r["dexp_val_factura"]=="")
          $this->Cell(20, 5, "", 0, 0, 'R' );
       else {
          $this->Cell(20, 5, "$".number_format($r["dexp_val_factura"], 0, ",", "."), 0, 0, 'R' );
          $nFacturas++;
       }
       
       $nLineas++;

   }
   
   $this->row += 10; 
   $this->SetXY(20, $this->row); 

   $this->Cell(20, 5, "", "T", 0, 'R'        );
   $this->Cell(40, 5, "", "T", 0, 'C'   );	
   $this->Cell(40, 5, "", "T", 0, 'C');
   $this->Cell(25, 5, "", "T", 0, 'C'       );
   $this->Cell(25, 5, "", "T", 0, 'R'     );       
   $this->Cell(20, 5, "", "T", 0, 'R' );
   
   $s = "Declaro haber recibido de Transportes RutaChile S.A., $nGuias guías";
   if ($nFacturas > 0)
      $s .=", $nFacturas facturas";
      
   $this->row += 5; 
   $this->SetXY(20, $this->row); 
   $this->Cell(200, 5, utf8_decode($s), 0, 0, 'L'        );      
   
   $this->row += 5; 
   $this->SetXY(20, $this->row); 
   $this->Cell(200, 5, utf8_decode("y la cantidad de \$".number_format($this->expe_fondos, 0, ",", "."))." pesos.", 0, 0, 'L'        );  
   
    
   $this->row += 20; 
   $this->SetXY(20, $this->row); 
   $this->Cell(20, 5, "", 0, 0, 'R'        );
   $this->Cell(40, 5, "", 0, 0, 'C'   );	
   $this->Cell(40, 5, "", 0, 0, 'C');
   $this->Cell(25, 5, "", 0, 0, 'C'       );
   $this->Cell(25, 5, "", "T", 0, 'R'     );       
   $this->Cell(20, 5, "", "T", 0, 'R' );
   
   
   
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

?>