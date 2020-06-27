<?php
   class RendicionesIntController extends AppController {
      var $name="RendicionesInt";
      var $uses=array("Rendicion", "Fondo", "FondoEx", "Expedicion", 
                      "ExpedicionEx", "DexpedicionEx", "Dexpedicion", 
                      "Chofer", "Drendicion", "ItemGasto", "Moneda", 
                      "Camion", "Acoplado", "Crt", "Parametro", 
                      "Cliente", "Combustible", "Giro", "Tarifa", "Paridad", "Resumen"
                     );

      function index($page=1) {
         $this->layout="index_int";
         
	     $this->llena_rendiciones();
	     
         $recsXPage=20;
         
         if (isset($_REQUEST["page"])) {
	        //$page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
         }
         else {
	        //$page    = 1;
            $sortKey ="rend_nro";
            $orderKey="desc";
         }
         
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         
         if (!isset($_SESSION["opcion"])) {
            $opcion = "I";
            $_SESSION["opcion"] = $opcion;
         }
         
         $opcion = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
         
         $this->set("opcion", $opcion);
         
         if ($opcion=="")
            $opcion = $_SESSION["opcion"];
         else
            $_SESSION["opcion"] = $opcion;
                  
         if ($opcion=="I")
            $where="rend_estado<>'C' and expe_tipo='I'";
         else
            $where="expe_tipo='I'";
            
         if (isset($_REQUEST["rend_nro"])) {
            $rend_nro = $_REQUEST["rend_nro"];
            
            if (isInteger($rend_nro) && trim($rend_nro)!="")
               $where .=" and rend_nro=$rend_nro";
               
            $this->set("rend_nro", $rend_nro);
         }
         
         if (isset($_REQUEST["chofer"])) {
	        $chofer = strtoupper($_REQUEST["chofer"]);
	        
	        if ($chofer!="") {
	           $where .= " and expe_id in (select id from expediciones_ex where chof_id in (select id from choferes where chof_apellidos like '$chofer%'))";
	          
	           $this->set("chofer", $chofer);
           }
         }
            
         $this->set("opcion", $opcion);
            
         //echo "$opcion  $where <hr>";
         
         $arreglo = $this->Rendicion->findAll($where, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         //print_r($arreglo);
         
         for($i=0; $i < count($arreglo); $i++) {
	        $id = $arreglo[$i]["id"];
	        
	        //print_r($arreglo[$i]);
	        
	        $fondo_id = $arreglo[$i]["fondo_id"];
	        
	        if ($arreglo[$i]["expe_tipo"]=="N") {
	           $d = $this->Fondo->read(null, $fondo_id);
	           $fond_monto = $d["Fondo"]["fond_monto"];
	           $expe_id    = $d["Fondo"]["expe_id"];
	           
	           $giros = $this->Giro->findAll("expe_tipo='N' and expe_id=$expe_id");
	           
	           //print_r($giros);
	           
	           $sumaGiro=0;
	           foreach($giros as $g) {
		          if ($g["mone_id"]==1)
		             $sumaGiro += $g["giro_monto"];
	           }
	           
	           //$fond_monto += $sumaGiro;
            }
	        else {
	           $d = $this->FondoEx->read(null, $fondo_id);
	           
	           //echo $fondo_id."<br>"; 
	           
	           //print_r($d);
	           
	           $fond_monto = $d["FondoEx"]["fond_monto"];
	           $expe_id    = $d["FondoEx"]["expe_id"];
           }
           
           //print_r($d);
	        
	        
	        
	        $total=$fond_monto;
	        
	        $arr = $this->Drendicion->findAll("rendicion_id=$id and rendicion_id in (select id from rendiciones)", null, "id");
	        
            for ($ii=0; $ii < count($arr); $ii++) {
	           $item_id = $arr[$ii]["item_id"];
	           
	           $total += $arr[$ii]["dren_monto"];
	           //echo $item_id;
	           
	           if ($this->ItemGasto->findByPk($item_id)) $arr[$ii]["item_descripcion"] = $this->ItemGasto->data["ItemGasto"]["item_descripcion"]; 
            }
            
            
            if ($arreglo[$i]["expe_tipo"]=="N") {
	           //echo $expe_id."<hr>";
               $d = $this->Expedicion->read(null, $expe_id);
               
               $expe_nro   = $d["Expedicion"]["expe_nro"];
               $expe_fecha = $d["Expedicion"]["expe_fecha"];
               $chof_id    = $d["Expedicion"]["chof_id"];
            }
            else {
               $d = $this->ExpedicionEx->read(null, $expe_id);
               
               $expe_nro   = $d["ExpedicionEx"]["expe_nro"];
               $expe_fecha = $d["ExpedicionEx"]["expe_fecha"];
               $chof_id    = $d["ExpedicionEx"]["chof_id"];	            
            }
            
            $d = $this->Chofer->read(null, $chof_id);
            
            $chofer = $d["Chofer"]["chof_apellidos"]." ".$d["Chofer"]["chof_nombres"];
            
            $arreglo[$i]["asignado"]=$fond_monto;
            $arreglo[$i]["gastado"] =$total;
            $arreglo[$i]["devolucion"]=$fond_monto-$total;
            
            $arreglo[$i]["expe_nro"  ] = $expe_nro  ;
            $arreglo[$i]["expe_fecha"] = $expe_fecha;
            $arreglo[$i]["chofer"    ] = $chofer    ;
            
            
            $expe_tipo = $arreglo[$i]["expe_tipo"];
	        $expe_id   = $arreglo[$i]["expe_id"];
	     
	     
	        $d = $this->Combustible->findAll("expe_tipo='$expe_tipo' and expe_id=$expe_id");
	     
	        if (count($d) > 0) {
		       $arreglo[$i]["combustible_cargado"] = "Si";
		        
	        }
	        else
	           $arreglo[$i]["combustible_cargado"] = "No";
         }
         
         $pagination = new pagination("/rendiciones_int/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Rendicion->count(), $recsXPage);
         
         $this->assign("rendiciones", $arreglo);
         $this->assign('pagination', $pagination->links());
         
         $this->chequearParidades();
      }
      
      function chequearParidades() {
	     $fechaHoy = date('Y-m-d');
	     
	     $arr = $this->Paridad->findAll("mon_id=6 and par_fecha='$fechaHoy'");
	     
	     $sParidades = array();
	     if (count($arr)==0)
	        $sParidades[] = "¡Falta ingresar paridad peso chileno para hoy!";
	        
	     $arr = $this->Paridad->findAll("mon_id=1 and par_fecha='$fechaHoy'");
	     
	     if (count($arr)==0)
	        $sParidades[] = "¡Falta ingresar paridad peso argentino para hoy!";
	     
	     //print_r($sParidades);
	     
	     $nParidades = count($sParidades);
	     
	     $this->set("nParidades", $nParidades);
	     $this->set("sParidades", $sParidades);   
	        
      }
  
      function llena_rendiciones() {
	     $this->Rendicion->validate=array();
	        
	     $arr = $this->Fondo->findAll("id not in (select fondo_id from rendiciones where expe_tipo='N')");
	     
	     //print_r($arr);
	     
	     foreach($arr as $r) {
		    $arrr = $this->Fondo->findSql("select max(rend_nro) maximo from rendiciones");
		    	     
	        if (count($arrr) > 0)
	           $rend_nro=$arrr[0]["maximo"] + 1;
	        else
	           $rend_nro=1; 
		     
		    $d["Rendicion"]["id"                     ] = "";
            $d["Rendicion"]["rend_nro"               ] = $rend_nro;
            $d["Rendicion"]["rend_fecha"             ] = date("d/m/Y");
            $d["Rendicion"]["expe_tipo"              ] = "N";
            $d["Rendicion"]["expe_id"                ] = $r["expe_id"];
            $d["Rendicion"]["fondo_id"               ] = $r["id"];
            $d["Rendicion"]["rend_bloqueo"           ] = "N";
            $d["Rendicion"]["rend_devol_chofer"      ] = "0";
            $d["Rendicion"]["rend_pagado_chofer"     ] = "0";
            $d["Rendicion"]["rend_devol_chofer_mon2" ] = "0";
            $d["Rendicion"]["rend_pagado_chofer_mon2"] = "0";
            $d["Rendicion"]["rend_peonetas"          ] = "0";
            $d["Rendicion"]["rend_estado"] = "I";     
            $d["Rendicion"]["rend_litros_ida_mendoza"    ]="0";
            $d["Rendicion"]["rend_litros_regreso_mendoza"]="0";
            $d["Rendicion"]["rend_fallida"]="N";
            
            //echo "A grabar";
            //print_r($d);
            
            
            $this->Rendicion->save($d);
            
            $rendicion_id=$this->Rendicion->tbl->insertId();
            
            $gastos = $this->ItemGasto->findAll("item_procedencia='N'", null, "item_orden");
            foreach($gastos as $g) {
	           $d["Drendicion"]["id"          ] = "";
	           $d["Drendicion"]["rendicion_id"] = $rendicion_id;
	           $d["Drendicion"]["item_id"     ] = $g["id"];
	           $d["Drendicion"]["dren_monto"  ] = "0";
	           $d["Drendicion"]["moneda_id"   ] = "6";
	           $d["Drendicion"]["dren_litros"] = "0";
	           
	           //print_r($d);
	           $this->Drendicion->save($d);
            }
            
	     }
	     
	     $arr = $this->FondoEx->findAll("id not in (select fondo_id from rendiciones where expe_tipo='I')");
	     foreach($arr as $r) {
		    $arrr = $this->FondoEx->findSql("select max(rend_nro) maximo from rendiciones");
		    	     
	        if (count($arrr) > 0)
	           $rend_nro=$arrr[0]["maximo"] + 1;
	        else
	           $rend_nro=1; 
		     
		    $d["Rendicion"]["id"                 ] = "";
            $d["Rendicion"]["rend_nro"           ] = $rend_nro;
            $d["Rendicion"]["rend_fecha"         ] = date("d/m/Y");
            $d["Rendicion"]["expe_tipo"          ] = "I";
            $d["Rendicion"]["expe_id"            ] = $r["expe_id"];
            $d["Rendicion"]["fondo_id"           ] = $r["id"];
            $d["Rendicion"]["rend_bloqueo"       ] = "N";
            $d["Rendicion"]["rend_estado"        ] = "I";
            $d["Rendicion"]["rend_devol_chofer"      ] = "0";
            $d["Rendicion"]["rend_pagado_chofer"     ] = "0";
            $d["Rendicion"]["rend_devol_chofer_mon2" ] = "0";
            $d["Rendicion"]["rend_pagado_chofer_mon2"] = "0";         
            $d["Rendicion"]["rend_estado"] = "I";       
            $d["Rendicion"]["rend_peonetas"] = "0";
            $d["Rendicion"]["rend_litros_ida_mendoza"    ]="0";
            $d["Rendicion"]["rend_litros_regreso_mendoza"]="0";
            $d["Rendicion"]["rend_fallida"]="N";

            
            //print_r($d);
            
            
            $this->Rendicion->save($d);
            
            $rendicion_id=$this->Rendicion->tbl->insertId();
            $id_moneda2 = $r["id_moneda2"];
            $id_moneda3 = $r["id_moneda3"];
            $fond_monto = $r["fond_monto"];
            $fond_monto2= $r["fond_monto2"];
            $fond_monto3= $r["fond_monto3"];
            
            if ($fond_monto!="") {
               $gastos = $this->ItemGasto->findAll("item_procedencia='N'", null, "item_orden");
               foreach($gastos as $g) {
	              $d["Drendicion"]["id"          ] = "";
	              $d["Drendicion"]["rendicion_id"] = $rendicion_id;
	              $d["Drendicion"]["item_id"     ] = $g["id"];
	              $d["Drendicion"]["dren_monto"  ] = "0";
	              $d["Drendicion"]["moneda_id"   ] = "6";
	              $d["Drendicion"]["dren_litros"] = "0";
	              
	              //print_r($d);
	              $this->Drendicion->save($d);
               }
            }
            
            
            if ($id_moneda2!=null) {
               $gastos = $this->ItemGasto->findAll("item_procedencia='I'", null, "item_orden");
               foreach($gastos as $g) {
	              $d["Drendicion"]["id"          ] = "";
	              $d["Drendicion"]["rendicion_id"] = $rendicion_id;
	              $d["Drendicion"]["item_id"     ] = $g["id"];
	              $d["Drendicion"]["dren_monto"  ] = "0";
	              $d["Drendicion"]["moneda_id"   ] = $id_moneda2;
	              $d["Drendicion"]["dren_litros"] = "0";
	              
	              $this->Drendicion->save($d);
               }
            }
            
            if ($id_moneda3!=null) {
               $gastos = $this->ItemGasto->findAll("item_procedencia='I'", null, "item_orden");
               foreach($gastos as $g) {
	              $d["Drendicion"]["id"          ] = "";
	              $d["Drendicion"]["rendicion_id"] = $rendicion_id;
	              $d["Drendicion"]["item_id"     ] = $g["id"];
	              $d["Drendicion"]["dren_monto"  ] = "0";
	              $d["Drendicion"]["moneda_id"   ] = $id_moneda3;
	              $d["Drendicion"]["dren_litros"] = "0";
	              
	              $this->Drendicion->save($d);
               }
            }                        
	     }	     
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
          if (isset($_REQUEST["id"])) {
	         $data = $this->Drendicion->read(null, $id);
	         
	         //print_r($data);
	         //$id = $data[]  
          }

         $this->layout="form_int";

         if (!empty($this->data)) {
	        //print_r($this->data);
	        
	        $fondo_id  = $this->data["Rendicion"]["fondo_id"];	        
	        $fondo_id  = $this->data["Rendicion"]["fondo_id"];
	        $expe_id   = $this->data["Rendicion"]["expe_id"];
	        $expe_tipo = $this->data["Rendicion"]["expe_tipo"];
	        $id        = $this->data["Rendicion"]["id"];
	        
	        if ($expe_tipo=="N") {
			   $this->data["Rendicion"]["rend_litros_ida_mendoza"] ="0";
			   $this->data["Rendicion"]["rend_litros_regreso_mendoza"] ="0";
			   
			   $this->data["Rendicion"]["rend_fec_aduana"]   =date("d/m/Y");
			   $this->data["Rendicion"]["rend_fec_bodega"]   =date("d/m/Y");
			   $this->data["Rendicion"]["rend_fec_descarga"] =date("d/m/Y");
		    }
	        
	        //print_r($this->data);
	        
	        if ($expe_tipo=="N") {
		       $d = $this->Fondo->findAll("id=$fondo_id");
	           
	           if (count($d) > 0) {
	              $fond_monto = $d[0]["fond_monto"];
	              $expe_id    = $d[0]["expe_id"];
	              
	              //print_r($d);
               }
	           else
	              $fond_monto = 0;
	           
	           $this->set("fond_monto", $fond_monto);
	           	           	           
	           $d = $this->Expedicion->read(null, $expe_id);
	           
	           $this->set("expe_nro", $d["Expedicion"]["expe_nro"]);
	           $this->set("expe_destino", $d["Expedicion"]["expe_destino"]);
	        }
	        else {
		       $d = $this->FondoEx->findAll("id=$fondo_id");
		       
		       //print_r($d);
               
               if (count($d) > 0) {
                  $fond_monto = $d[0]["fond_monto"];
                  $fond_monto2 = isset($d[0]["fond_monto2"])?$d[0]["fond_monto2"]:"";
                  $fond_monto3 = isset($d[0]["fond_monto3"])?$d[0]["fond_monto3"]:"";;
                  
                  $id_moneda2 = $d[0]["id_moneda2"];
                  $id_moneda3 = $d[0]["id_moneda3"];
                  $expe_id    = $d[0]["expe_id"];
               }
               else {
                  $fond_monto = 0;
                  $fond_monto2 = 0;
                  $fond_monto3 = 0;
                  $id_moneda2=null;
                  $id_moneda3=null;
               }
               
               
               
               $this->set("fond_monto", $fond_monto);
               $this->set("fond_monto2", $fond_monto2);
               $this->set("fond_monto3", $fond_monto3);
               
               $this->set("id_moneda2", $id_moneda2);
               $this->set("id_moneda3", $id_moneda3);
               
               $d = $this->ExpedicionEx->read(null, $expe_id);
	           
	           $this->set("expe_nro", $d["ExpedicionEx"]["expe_nro"]);
	           $this->set("expe_destino", $d["ExpedicionEx"]["expe_destino"]);	    
            }    
	        
            $this->data["Rendicion"]["expe_id"] = $expe_id;
            
	        $this->Rendicion->setData($this->data);
	        
	        $this->data["Drendicion"]["id"] = "";
	        $this->data["Drendicion"]["rendicion_id"] = $id;
	        
	        $this->Drendicion->setData($this->data);
	        
	        $t  = $this->Rendicion->validates();
	        //$t2 = $this->Drendicion->validates();
	        
	         
            if ($this->Rendicion->save($this->data)) {
	           $this->graba_detalle($id, $expe_tipo);
	           
	           if ($this->data["Rendicion"]["rend_estado"]=="C") {
		          //print_r($this->data);
		          
		          $expe_tipo = $this->data["Rendicion"]["expe_tipo"];
		          $expe_id   = $this->data["Rendicion"]["expe_id"];
		          $fond_id   = $this->data["Rendicion"]["fondo_id"];
		          
		          
		          
		          
		          
		          if ($expe_tipo=="N") {
			         $d = $this->Expedicion->read(null, $expe_id);
			         $d["Expedicion"]["expe_cierre"] = "S";
			         
			         $this->Expedicion->save($d);
			         
			         $d = $this->Fondo->read(null, $fond_id);
			         $d["Fondo"]["fond_cierre"] = "S";
			         
			         $this->Fondo->save($d);
		          }
		          else {
			         $d = $this->ExpedicionEx->read(null, $expe_id);
			         $d["ExpedicionEx"]["expe_cierre"] = "S";
			         
			         $this->ExpedicionEx->save($d);
			         
			         $d = $this->FondoEx->read(null, $fond_id);
			         $d["FondoEx"]["fond_cierre"] = "S";
			         
			         $this->FondoEx->save($d);
		          }
		          
		          $d = $this->Combustible->finAll("expe_tipo='$expe_tipo' and expe_id='$expe_id'");
		          
		          if (count($d) > 0) {
			         $d["Combustible"] = $d[0];
			         
			         $d["Combustible"]["cierre"] = "S";
			         
			         $this->Combustible->save($d);
		          }
		          
		          
	           }
 
               $this->redirect("/rendiciones_int/runPdf/$id");
           }
           
           //print_r($this->Rendicion->errorList);
           
           $this->llena_detalle($id, $expe_tipo, true);                                           
         }
         
         if (empty($this->data)) {
	        //print_r($this->data);
	        
	        $this->data = $this->Rendicion->read(null, $id);
	        $fondo_id   = $this->data["Rendicion"]["fondo_id"];
	        
	         
	        
	        $fondo_id  = $this->data["Rendicion"]["fondo_id"];
	        $expe_id   = $this->data["Rendicion"]["expe_id"];
	        $expe_tipo = $this->data["Rendicion"]["expe_tipo"];
	        
	        //$rend_lugar_salida  = $this->data["Rendicion"]["rend_lugar_salida"];
	        //$rend_lugar_llegada = $this->data["Rendicion"]["rend_lugar_llegada"];
	        
	        $rend_fecha_salida   = $this->data["Rendicion"]["rend_fecha_salida"]; 
	        $rend_fecha_llegada  = $this->data["Rendicion"]["rend_fecha_llegada"];
	        $rend_dias_viaje_nac = $this->data["Rendicion"]["rend_dias_viaje_nac"];
	        $rend_dias_viaje_int = $this->data["Rendicion"]["rend_dias_viaje_int"];
	        
	        
	        if ($rend_dias_viaje_nac=="") $this->data["Rendicion"]["rend_dias_viaje_nac"] = "0";
	        if ($rend_dias_viaje_int=="") $this->data["Rendicion"]["rend_dias_viaje_int"] = "0";
	        
	        //if ($rend_lugar_salida=="")  $this->data["Rendicion"]["rend_lugar_salida"] = "SANTIAGO";
	        
	        //if ($rend_lugar_llegada=="")  $this->data["Rendicion"]["rend_lugar_llegada"] = "SANTIAGO";
	        
	        if ($rend_fecha_salida=="")  $this->data["Rendicion"]["rend_fecha_salida"] = date("d/m/Y");

            if ($rend_fecha_llegada=="")  $this->data["Rendicion"]["rend_fecha_llegada"] = date("d/m/Y");  
	        
	        if ($expe_tipo=="N") {
		       $d = $this->Fondo->findAll("id=$fondo_id");
	           
	           if (count($d) > 0)
	              $fond_monto = $d[0]["fond_monto"];
	           else
	              $fond_monto = 0;
	              
	           $expe_id = $d[0]["expe_id"];
		       
		       $aa = $this->Expedicion->read(null, $expe_id);
		       
		       $this->set("chof_id", $aa["Expedicion"]["chof_id"]);
		       
		       $giros = $this->Giro->findAll("expe_tipo='$expe_tipo' and expe_id=$expe_id");
		       
		       //print_r($giros);
		       
               $sumaGiro=0;
	           foreach($giros as $g) {
		          if ($g["mone_id"]==6)
		             $sumaGiro += $g["giro_monto"];
	           }
	           
	           //echo $fond_monto+$sumaGiro;
	           
	           $this->set("fond_monto", $fond_monto+$sumaGiro);
	           
	           $d = $this->Expedicion->read(null, $expe_id);
	           
	           $this->set("expe_nro", $d["Expedicion"]["expe_nro"]);
	           $this->set("expe_destino", $d["Expedicion"]["expe_destino"]);
	        }
	        else {
		       $d = $this->FondoEx->findAll("id=$fondo_id");
		       
		       $expe_id = $d[0]["expe_id"];
		       
		       $aa = $this->ExpedicionEx->read(null, $expe_id);
		       
		       $this->set("chof_id", $aa["ExpedicionEx"]["chof_id"]);
		       
		       //print_r($d);
               
               if (count($d) > 0) {
                  $fond_monto = $d[0]["fond_monto"];
                  $fond_monto2 = isset($d[0]["fond_monto2"])?$d[0]["fond_monto2"]:"";
                  $fond_monto3 = isset($d[0]["fond_monto3"])?$d[0]["fond_monto3"]:"";;
                  
                  $id_moneda2 = $d[0]["id_moneda2"];
                  $id_moneda3 = $d[0]["id_moneda3"];
               }
               else {
                  $fond_monto = 0;
                  $fond_monto2 = 0;
                  $fond_monto3 = 0;
                  $id_moneda2=null;
                  $id_moneda3=null;
               }
               
               $giros = $this->Giro->findAll("expe_tipo='$expe_tipo' and expe_id=$expe_id");
		       
		       //print_r($giros);
		       
               $sumaGiro=0;
               $sumaNac=0;
	           foreach($giros as $g) {
		          if ($g["mone_id"]==1)
		             $sumaGiro += $g["giro_monto"];
		          else
		             $sumaNac += $g["giro_monto"];
	           }
	           
               $this->set("fond_monto", $fond_monto + $sumaNac);
               $this->set("fond_monto2", $fond_monto2 + $sumaGiro);
               $this->set("fond_monto3", $fond_monto3);
               
               $this->set("id_moneda2", $id_moneda2);
               $this->set("id_moneda3", $id_moneda3);
               
               $d = $this->ExpedicionEx->read(null, $expe_id);
	           
	           $this->set("expe_nro", $d["ExpedicionEx"]["expe_nro"]);
	           $this->set("expe_destino", $d["ExpedicionEx"]["expe_destino"]);
	           
	           $gastos = $this->ItemGasto->findAll("item_procedencia='I'", null, "item_orden");
               foreach($gastos as $g) {
	              $d["Drendicion"]["id"          ] = "";
	              $d["Drendicion"]["rendicion_id"] = $id;
	              $d["Drendicion"]["item_id"     ] = $g["id"];
	              $d["Drendicion"]["dren_monto"  ] = "0";
	              $d["Drendicion"]["moneda_id"   ] = $id_moneda2;
	              $d["Drendicion"]["dren_litros"] = "0";
	              
	              $arr = $this->Drendicion->findAll("rendicion_id=$id and item_id=".$g["id"]);
	              
	              if (count($arr)==0) 	              
	                 $this->Drendicion->save($d);
               }
		        
	        }
	        	        
	        
	        $this->llena_detalle($id, $expe_tipo);
         }
         
         //$fond_monto = 0;
         //if ($fondo_id!="") {
	     //   $d = $this->Fondo->read(null, $fondo_id);
	     //   
	     //   $fond_monto = $d["Fondo"]["fond_monto"];
	     //   $this->set("fond_monto", $fond_monto);
         //}
            
         
         $this->lista_choferes();
         
         $arr = $this->ItemGasto->findAll(null, null, "item_descripcion");
         
         $lista="|";
         for ($i=0; $i < count($arr); $i++) {
	        $lista .= ",".$arr[$i]["item_descripcion"]."|".$arr[$i]["id"];
         }
         
         $this->set("litems", $lista);
         
         $arr = $this->Drendicion->findAll("rendicion_id=$id", null, "id");
         
         $fondo_id = $this->data["Rendicion"]["fondo_id"];
         
         //$d = $this->Fondo->read(null, $fondo_id);
         
         //$total=$d["Fondo"]["fond_monto"];
         //for ($i=0; $i < count($arr); $i++) {
	     //   $item_id = $arr[$i]["item_id"];
	     //   
	     //   $total += $arr[$i]["dren_monto"];
	     //   //echo $item_id;
	     //   
	     //   if ($this->ItemGasto->findByPk($item_id)) $arr[$i]["item_descripcion"] = $this->ItemGasto->data["ItemGasto"]["item_descripcion"]; 
         //}
         //
         //$this->set("drendiciones", $arr);
         //$this->set("total", $total);
         
         $this->llena_listas();
         
         $p = $this->Parametro->read(null, 1);
         $this->set("comision_vuelta"  , $p["Parametro"]["comision_vuelta"  ]);
         $this->set("dias_espera"      , $p["Parametro"]["dias_espera"      ]);
         $this->set("viatico_chile"    , $p["Parametro"]["viatico_chile"    ]);
         $this->set("viatico_argentina", $p["Parametro"]["viatico_argentina"]);         
         
         if ($expe_tipo=="I") {
	        $arr = $this->DexpedicionEx->findAll("expe_id=$expe_id");
	        //print_r($arr);
	        
	        for ($i=0; $i < count($arr); $i++) {
		       $crt_id = $arr[$i]["crt_id"];		      
		       
		       $d = $this->Crt->read(null, $crt_id);
		       $cliente_id  = $d["Crt"]["cliente_id"];
		       $crts_numero = $d["Crt"]["crts_numero"];
		       $crts_valor_flete = $d["Crt"]["crts_valor_flete"];
		       $crts_mon_flete   = $d["Crt"]["crts_mon_flete"];
		       $factura_crt      = $d["Crt"]["factura_crt"];
		       
		       
		       $d = $this->Cliente->read(null, $cliente_id);
		       $cliente   = $d["Cliente"]["razon"];
		       $direccion = $d["Cliente"]["direccion"]." ".$d["Cliente"]["comuna"]." ".$d["Cliente"]["ciudad"]." ".$d["Cliente"]["pais"];
		       
		       $arr[$i]["crts_numero"]     =$crts_numero;
		       $arr[$i]["crts_valor_flete"]=$crts_valor_flete;
		       
		       $arr[$i]["crts_mon_flete"]  =$crts_mon_flete;
		       $arr[$i]["factura_crt"]     =$factura_crt;
		       $arr[$i]["cliente"]         =$cliente;
		       $arr[$i]["direccion"]       =$direccion;
	        }
	        
	        $this->set("detalle_cliente", $arr);
	        $this->set("cuenta_detalle", count($arr));
         }
         
         $rend_fecha_salida  = $this->data["Rendicion"]["rend_fecha_salida"];
         $rend_fecha_llegada = $this->data["Rendicion"]["rend_fecha_llegada"];
         
         $date1 = date2Mysql($rend_fecha_salida);
         $date2 = date2Mysql($rend_fecha_llegada);

         $diff = abs(strtotime($date2) - strtotime($date1));

         $years = floor($diff / (365*60*60*24));
         $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
         $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
         
         //$this->set("dias", $this->getDias($rend_fecha_salida, $rend_fecha_llegada));
         
         //$this->getDias("30-09-2013", "22-08-2013");
         
         $expe_tipo = $this->data["Rendicion"]["expe_tipo"];
	     $expe_id   = $this->data["Rendicion"]["expe_id"];
	     
	     //echo "$expe_tipo, $expe_id<hr>";
	     
	     $d = $this->Combustible->findAll("expe_tipo='$expe_tipo' and expe_id=$expe_id");
	     
	     if (count($d) > 0) {
		    //print_r($d);
		    //if (empty($this->data["Rendicion"]["rend_kms_salida"]))		    
		       $this->data["Rendicion"]["rend_kms_salida"] = $d[0]["kms"];
		       
		    //if (empty($this->data["Rendicion"]["rend_kms_llegada"]))		    
		       $this->data["Rendicion"]["rend_kms_llegada"] = $d[0]["kms_llegada"];
		    
		    $this->set("litros_inicio", $d[0]["litros"]);
		        
	     }
      }
      
      function getDias($fini, $ffin) {
	     $date1 = date2Mysql($fini);
         $date2 = date2Mysql($ffin);

         $days = (strtotime($date1) - strtotime($date2)) / (60 * 60 * 24) + 1;
         
         echo round($days,0)."@@";
      }
      
      function llena_detalle($id, $expe_tipo, $html=false) {
         $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                "  from drendiciones a, ".
                "       items_gastos b,  ".
                "       monedas      c   ".
                " where rendicion_id = $id ".
                "   and a.item_id=b.id ".
                "   and a.moneda_id=c.id ".
                "   and c.id=6 ".
                " order by item_orden ";
                
         $arr = $this->Drendicion->findSql($sql);
         
         for($i=0; $i < count($arr); $i++) {
	        //echo $arr[$i]["item_id"]."<br>";
	        
	        if ($arr[$i]["item_id"]==9) {
		       
		       $d = $this->Rendicion->read(null, $id);
		       $rend_dias_viaje_nac = $d["Rendicion"]["rend_dias_viaje_nac"];
		       
		       $p = $this->Parametro->read(null, 1);
		       $viatico_chile = $p["Parametro"]["viatico_chile"];
		       
		       $arr[$i]["dren_monto"] = round($rend_dias_viaje_nac*$viatico_chile, 0);
		       
		       break;
	        }
         }
         
         if ($html) {
	        for ($i=0; $i < count($arr); $i++) {
		       $item_id = $arr[$i]["item_id"];
		       
		       //echo $item_id."<hr>";
		       $monto  = isset($_REQUEST["monto_$item_id"])?$_REQUEST["monto_$item_id"]:"0";
		       $litros = isset($_REQUEST["litros_$item_id"])?$_REQUEST["litros_$item_id"]:"0";
		       
		       $arr[$i]["dren_monto"] =  $monto;
		       $arr[$i]["dren_litros"]=  $litros;
	        }
	        
	        $totNac     = isset($_REQUEST["totNac"]    )?$_REQUEST["totNac"]    :"0";
	        $fond_monto = isset($_REQUEST["fond_monto"])?$_REQUEST["fond_monto"]:"0";
	        $difNac     = isset($_REQUEST["difNac"]    )?$_REQUEST["difNac"]    :"0";
	        
	        $this->set("totNac",     $totNac    );
	        $this->set("fond_monto", $fond_monto);
	        $this->set("difNac",     $fond_monto-$totNac    );
         }
         
         
         $this->set("gasto_nacional", $arr);     
         
         if ($expe_tipo=="I") {
	        $d = $this->Rendicion->read(null, $id);
	        
	        $fondo_id = $d["Rendicion"]["fondo_id"];
	        
	        $d = $this->FondoEx->read(null, $fondo_id);
	        
	        $id_moneda2 = $d["FondoEx"]["id_moneda2"];
	        $id_moneda3 = $d["FondoEx"]["id_moneda3"];
	        
	        $fond_monto2 = $d["FondoEx"]["fond_monto2"];
	        $fond_monto3 = $d["FondoEx"]["fond_monto3"];
	        
	        if ($id_moneda2!="" && $fond_monto2!="") {
		       $d = $this->Moneda->read(null, $id_moneda2);
		       
		       $this->set("moneda2", $d["Moneda"]["mone_descripcion"]);
		       
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda2 ".
                      " order by item_orden ";                                       
       
                $arr = $this->Drendicion->findSql($sql);
                
                //echo $id_moneda2."<br>";
                if ($id_moneda2==1) {
	               for($i=0; $i < count($arr); $i++) {
	                  //echo $arr[$i]["item_id"]."<br>";
	                  
	                  if ($arr[$i]["item_id"]==20) {
		                 
		                 $d = $this->Rendicion->read(null, $id);
		                 $rend_dias_viaje_int = $d["Rendicion"]["rend_dias_viaje_int"];
		                 
		                 $p = $this->Parametro->read(null, 1);
		                 $viatico_argentina = $p["Parametro"]["viatico_argentina"];

		                 $arr[$i]["dren_monto"] = round($rend_dias_viaje_int*$viatico_argentina, 0);
		                 
		                 break;
	                  }
                   }
                }
                
                if ($html) {
	               for ($i=0; $i < count($arr); $i++) {
		              $item_id = $arr[$i]["item_id"];
		              
		              //echo $item_id."<hr>";
		              $monto  = isset($_REQUEST["monto_mon2_$item_id"])?$_REQUEST["monto_mon2_$item_id"]:"0";
		              $litros = isset($_REQUEST["litros_mon2_$item_id"])?$_REQUEST["litros_mon2_$item_id"]:"0";
		              
		              $arr[$i]["dren_monto"] =  $monto;
		              $arr[$i]["dren_litros"]=  $litros;
	               }
	               
	               $totNac2     = isset($_REQUEST["totNac2"]    )?$_REQUEST["totNac2"]    :"0";
	               $fond_monto2 = isset($_REQUEST["fond_monto2"])?$_REQUEST["fond_monto2"]:"0";
	               $difNac2     = isset($_REQUEST["difNac2"]    )?$_REQUEST["difNac2"]    :"0";
	               
	               $this->set("totNac2",     $totNac2    );
	               $this->set("fond_monto2", $fond_monto2);
	               $this->set("difNac2",     $difNac2    );
                }
                      
                $this->set("gasto_nacional_moneda2", $arr);      
		        
	        }
	        
	        if ($id_moneda3!="" && $fond_monto3!="") {
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda3 ".
                      " order by item_orden ";                                       
       
                $arr = $this->Drendicion->findSql($sql);
                
                if ($id_moneda3==1) {
	               for($i=0; $i < count($arr); $i++) {
	                  //echo $arr[$i]["item_id"]."<br>";
	                  
	                  if ($arr[$i]["item_id"]==20) {
		                 
		                 $d = $this->Rendicion->read(null, $id);
		                 $rend_dias_viaje_int = $d["Rendicion"]["rend_dias_viaje_int"];
		                 
		                 $p = $this->Parametro->read(null, 1);
		                 $viatico_argentina = $p["Parametro"]["viatico_argentina"];
		                 		                 
		                 $arr[$i]["dren_monto"] = round($rend_dias_viaje_int*$viatico_argentina, 0);
		                 
		                 break;
	                  }
                   }
                }
                
                if ($html) {
	               for ($i=0; $i < count($arr); $i++) {
		              $item_id = $arr[$i]["item_id"];
		              
		              //echo $item_id."<hr>";
		              $monto  = isset($_REQUEST["monto_mon3_$item_id"])?$_REQUEST["monto_mon3_$item_id"]:"0";
		              $litros = isset($_REQUEST["litros_mon3_$item_id"])?$_REQUEST["litros_mon3_$item_id"]:"0";
		              
		              $arr[$i]["dren_monto"] =  $monto;
		              $arr[$i]["dren_litros"]=  $litros;
	               }
	               
	               $totNac3     = isset($_REQUEST["totNac3"]    )?$_REQUEST["totNac3"]    :"0";
	               $fond_monto3 = isset($_REQUEST["fond_monto3"])?$_REQUEST["fond_monto3"]:"0";
	               $difNac3     = isset($_REQUEST["difNac3"]    )?$_REQUEST["difNac3"]    :"0";
	               
	               $this->set("totNac3",     $totNac3    );
	               $this->set("fond_monto3", $fond_monto3);
	               $this->set("difNac3",     $difNac3    );
                }
                      
                $this->set("gasto_nacional_moneda3", $arr);      
		        
	        }	        
	        
         }
      }
      
      function graba_detalle($id, $expe_tipo, $html=false) {
	     //echo "Graba detalle: $id  $expe_tipo<hr>";
	     
         $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                "  from drendiciones a, ".
                "       items_gastos b,  ".
                "       monedas      c   ".
                " where rendicion_id = $id ".
                "   and a.item_id=b.id ".
                "   and a.moneda_id=c.id ".
                "   and c.id=6 ".
                " order by item_orden ";
                
         $arr = $this->Drendicion->findSql($sql);
         
         foreach($arr as $r) {
	        $rendicion_id = $r["rendicion_id"];
	        $item_id      = $r["item_id"];
	        $r["dren_monto"]  = isset($_REQUEST["monto_$item_id"])?$_REQUEST["monto_$item_id"]:"0";
	        $r["dren_litros"] = isset($_REQUEST["litros_$item_id"])?$_REQUEST["litros_$item_id"]:"0";
	        
	        $data["Drendicion"] = $r;
	        
	        //print_r($data);
	        
	        $this->Drendicion->save($data);  
         }  
         
         if ($expe_tipo=="I") {
	        $d = $this->Rendicion->read(null, $id);
	        
	        $fondo_id = $d["Rendicion"]["fondo_id"];
	        
	        $d = $this->FondoEx->read(null, $fondo_id);
	        
	        $id_moneda2 = $d["FondoEx"]["id_moneda2"];
	        $id_moneda3 = $d["FondoEx"]["id_moneda3"];
	        
	        $fond_monto2 = $d["FondoEx"]["fond_monto2"];
	        $fond_monto3 = $d["FondoEx"]["fond_monto3"];
	        
	        if ($id_moneda2!="" && $fond_monto2!="") {
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda2 ".
                      " order by item_orden ";
                      
               $arr = $this->Drendicion->findSql($sql);
               
               foreach($arr as $r) {
	              $rendicion_id = $r["rendicion_id"];
	              $item_id      = $r["item_id"];
	              $r["dren_monto"]  = isset($_REQUEST["monto_mon2_$item_id"])?$_REQUEST["monto_mon2_$item_id"]:"0";
	              $r["dren_litros"] = isset($_REQUEST["litros_mon2_$item_id"])?$_REQUEST["litros_mon2_$item_id"]:"0";
	              
	              $data["Drendicion"] = $r;
	              
	              $this->Drendicion->save($data);  
               }		        
	        }
	        
	        if ($id_moneda3!="" && $fond_monto3!="") {
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda3 ".
                      " order by item_orden ";
                      
               $arr = $this->Drendicion->findSql($sql);
               
               foreach($arr as $r) {
	              $rendicion_id = $r["rendicion_id"];
	              $item_id      = $r["item_id"];
	              $r["dren_monto"]  = isset($_REQUEST["monto_mon3_$item_id"])?$_REQUEST["monto_mon3_$item_id"]:"0";
	              $r["dren_litros"] = isset($_REQUEST["litros_mon3_$item_id"])?$_REQUEST["litros_mon3_$item_id"]:"0";
	              
	              $data["Drendicion"] = $r;
	              
	              $this->Drendicion->save($data);  
               }		        		        
	        }	        	        
         }
      }
      
      function llena_listas() {
	      
	     $arr = $this->Moneda->findAll(null, null, "mone_descripcion");
	     $lista="|";
	     
	     foreach($arr as $r)
	        $lista .=",".$r["mone_descripcion"]."|".$r["id"];
	        
	     $this->set("lmonedas", $lista);
      }
      
      function lista_choferes() {
	     $arr = $this->Chofer->findAll(null, null, "chof_apellidos, chof_nombres");
	     
	     $lista = "|";
	     for ($i=0; $i < count($arr); $i++) {
		     $d = $arr[$i];
		     $chofer = $d["chof_apellidos"]." ".$d["chof_nombres"];
	     		     
		     $lista .=", ".$chofer."|".$d["id"];
	     }
	     
         $this->set("choferes", $lista);	      
      }
      
      function editRecord($id=null) {
          if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
          
          if (isset($_REQUEST["idHijo"])) 
	         $idHijo = $_REQUEST["idHijo"];
	      else
	         $idHijo = $id;
	         
	         	         
	      $data = $this->Drendicion->read(null, $idHijo);
	      $idPadre=$data["Drendicion"]["rendicion_id"]; 
	      
	      $id = $idPadre;

	     $this->set("idHijo", $idHijo);
	     $this->set("idPadre", $idPadre);
	     
	     $id = $idHijo;

         if (!empty($this->data)) {
	        if ($this->Drendicion->save($this->data))
	           $this->redirect("/rendiciones_int/edit/$idPadre");
	        
	        $this->Rendicion->setData($this->data);
	        
	        $this->data["Drendicion"]["id"] = $idHijo;
	        $this->data["Drendicion"]["rendicion_id"] = $idPadre;
	        
	        $this->Drendicion->setData($this->data);
	        
	        $t  = $this->Rendicion->validates();
	        $t2 = $this->Drendicion->validates();
	        
	         
            if ($t && $t2) {
	           $this->Rendicion->save($this->data);
	           $this->Drendicion->save($this->data); 
               $this->redirect("/rendiciones_int/edit/$idPadre");
           }
         }
         
         if (empty($this->data)) {
	        $this->data = $this->Rendicion->read(null, $idPadre);
	        $data       = $this->Drendicion->read(null, $idHijo);
	        
	        unset($data["Drendicion"]["id"]);
	        $this->data["Drendicion"] = $data["Drendicion"];
	        
            $fondo_id   = $this->data["Rendicion"]["fondo_id"];
         }
         
         $fond_monto = 0;
         if ($fondo_id!="") {
	        $d = $this->Fondo->read(null, $fondo_id);
	        
	        $fond_monto = $d["Fondo"]["fond_monto"];
	        $this->set("fond_monto", $fond_monto);
         }
         
         
         
         $arreglo = $this->Expedicion->findAll("expe_cierre='S'", null, "id desc");
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
         
         $arr = $this->Item->findAll(null, null, "item_descripcion");
         
         $lista="|";
         for ($i=0; $i < count($arr); $i++) {
	        $lista .= ",".$arr[$i]["item_descripcion"]."|".$arr[$i]["id"];
         }
         
         $this->set("items", $lista);
         
         $arr = $this->Drendicion->findAll("rendicion_id=$idPadre", null, "id");
         
         $total=$this->data["Rendicion"]["rend_monto"];
         for ($i=0; $i < count($arr); $i++) {
	        $item_id = $arr[$i]["item_id"];
	        
	        $total += $arr[$i]["dren_monto"];
	        //echo $item_id;
	        
	        if ($this->Item->findByPk($item_id)) $arr[$i]["item_descripcion"] = $this->Item->data["ItemGasto"]["item_descripcion"]; 
         }
         
         $this->set("drendiciones", $arr);
         $this->set("total", $total);
         $this->set("devolucion", $fond_monto - $total);
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
         $data = $this->Drendicion->read(null, $id);
         $idPadre = $data["Drendicion"]["rendicion_id"];
         
         if ($this->Drendicion->delete($id)) 
            $this->redirect("/rendiciones_int/edit/$idPadre");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function runPdf($id) {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
         $data = $this->Rendicion->read(null, $id);
 
         
         $r = $data["Rendicion"];
         
         //print_r($r);
         
         $expe_id   = $r["expe_id"];
         $expe_tipo = $r["expe_tipo"];
         
         $r["expe_tipo"] = $expe_tipo;
         
         $d = $this->Combustible->findAll("expe_tipo='$expe_tipo' and expe_id=$expe_id");
         
         if (count($d) > 0)
	        $r["litros_cargados"] = $d[0]["litros"];
	     else
	        $r["litros_cargados"] = "0";
         
         if ($expe_tipo=="N") {
	        $d = $this->Expedicion->read(null, $expe_id);
	        
	        $r["expe_nro"] = $d["Expedicion"]["expe_nro"];
	        $r["expe_destino"] = $d["Expedicion"]["expe_destino"];
	        $r["chofer"] = $d["Expedicion"]["chof_apellidos"]." ".$d["Expedicion"]["chof_nombres"];
	        $cami_id     = $d["Expedicion"]["cami_id"];
	        $acop_id     = $d["Expedicion"]["acop_id"];
	        
	        $dd = $this->Camion->read(null, $cami_id);
	        $r["cami_patente"] = $dd["Camion"]["cami_patente"];
	        
	        //print_r($d);
	        
	        //echo "<hr>Acoplado: $acop_id<hr>";
	        
	        if ($acop_id!="") {
		       $dd = $this->Acoplado->read(null, $acop_id);
	           $r["acop_patente"] = $dd["Acoplado"]["acop_patente"];
	        }
	        else
	           $r["acop_patente"]="";
	           
	        $aGuias = $this->Dexpedicion->findAll("expe_id=$expe_id", null, "dexp_guia");
	        
	        $lista = "";
	        foreach($aGuias as $s) {
		       if ($lista!="") $lista .=", ";
		       
		       $lista .= $s["dexp_guia"];
	        }
	           
	        $r["crts"]=$lista;
         }
         else {
	        $d = $this->ExpedicionEx->read(null, $expe_id);
	        
	        $r["expe_nro"] = $d["ExpedicionEx"]["expe_nro"];
	        $r["expe_destino"] = $d["ExpedicionEx"]["expe_destino"];	  
	        $r["chofer"] = $d["ExpedicionEx"]["chof_apellidos"]." ".$d["ExpedicionEx"]["chof_nombres"];  
	        
	        $cami_id     = $d["ExpedicionEx"]["cami_id"];
	        $acop_id     = isset($d["ExpedicionEx"]["acop_id"])?$d["ExpedicionEx"]["acop_id"]:"";
	        
	        $dd = $this->Camion->read(null, $cami_id);
	        $r["cami_patente"] = $dd["Camion"]["cami_patente"];
	        
	        if ($acop_id!="") {
		       $dd = $this->Acoplado->read(null, $acop_id);
	           $r["acop_patente"] = $dd["Acoplado"]["acop_patente"];
	        }
	        else
	           $r["acop_patente"]="";     
	           
	        $crts = "";
	        
	        $arr = $this->DexpedicionEx->findAll("expe_id=$expe_id");
	        
	        
	        
	        foreach($arr as $rr) {
		       $crt_id = $rr["crt_id"];
		       
		       $dd = $this->Crt->read(null, $crt_id);
		       
		       if ($crts!="") $crts .=", ";
		       
		       $crts .= $dd["Crt"]["crts_numero"];
	        }
	        
	        $r["crts"]=$crts;
         }
         
         //Detalles
         $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros, c.mone_paridad ".
                "  from drendiciones a, ".
                "       items_gastos b,  ".
                "       monedas      c   ".
                " where rendicion_id = $id ".
                "   and a.item_id=b.id ".
                "   and a.moneda_id=c.id ".
                "   and c.id=6 ".
                " order by item_orden ";
                
         $nacional = $this->Drendicion->findSql($sql);
         $mon2 = array();
         $mon3 = array();
         $moneda2="";
         $moneda3="";       
         $fondo  =array();
          
         $expe_lastre="";
         
         if ($expe_tipo=="I") {
	         
	         
	        $d = $this->Rendicion->read(null, $id);
	        
	        $fondo_id = $d["Rendicion"]["fondo_id"];
	        $expe_id  = $d["Rendicion"]["expe_id"];
	        
	        $d = $this->FondoEx->read(null, $fondo_id);
	        
	        $dd = $this->ExpedicionEx->read(null, $expe_id);
	        
	        $expe_lastre = $dd["ExpedicionEx"]["expe_lastre"];
	        $tarifa_id   = $dd["ExpedicionEx"]["tarifa_id"]; 
	        
	        $giros = $this->Giro->findAll("expe_tipo='I' and expe_id=$expe_id");
	        
	        
	        $id_moneda2 = $d["FondoEx"]["id_moneda2"];
	        $id_moneda3 = $d["FondoEx"]["id_moneda3"];
	        
	        $fond_monto  = $d["FondoEx"]["fond_monto"];
	        $fond_monto2 = $d["FondoEx"]["fond_monto2"];
	        $fond_monto3 = $d["FondoEx"]["fond_monto3"];
	        
	        $tari_valor=0;
	        if ($tarifa_id!="") {
		       $tt = $this->Tarifa->read(null, $tarifa_id);
		       $tari_valor = $tt["Tarifa"]["tari_valor"];
	        }
	        
	        $fondo = array("fond_monto" => $fond_monto,
	                       "fond_monto2" => $fond_monto2,
	                       "fond_monto3" => $fond_monto3,
	                       "expe_lastre" => $expe_lastre,
	                       "giros"       => $giros,
	                       "tarifa_id"   => $tarifa_id,
	                       "tari_valor"  => $tari_valor,
	                      );              
	                       
	        
	        if ($id_moneda2!="" && $fond_monto2!="") {
		       $d = $this->Moneda->read(null, $id_moneda2);
		       $moneda2 = $d["Moneda"]["mone_descripcion"];
		       
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros,c.mone_paridad ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda2 ".
                      " order by item_orden ";                                       
       
                $mon2 = $this->Drendicion->findSql($sql); 
		        
	        }
	        
	        if ($id_moneda3!="" && $fond_monto3!="") {
		       $d = $this->Moneda->read(null, $id_moneda3);
		       $moneda3 = $d["Moneda"]["mone_descripcion"];
		       
		       $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros, c.mone_paridad ".
                      "  from drendiciones a, ".
                      "       items_gastos b,  ".
                      "       monedas      c   ".
                      " where rendicion_id = $id ".
                      "   and a.item_id=b.id ".
                      "   and a.moneda_id=c.id ".
                      "   and c.id=$id_moneda3 ".
                      " order by item_orden ";                                       
       
                $mon3 = $this->Drendicion->findSql($sql); 
		        
	        }	        
	        
         }         
         else {
            $d = $this->Rendicion->read(null, $id);
	        
	        $fondo_id = $d["Rendicion"]["fondo_id"];
	        $expe_id  = $d["Rendicion"]["expe_id"];
	        
	        $d = $this->Fondo->read(null, $fondo_id);
	        
	        $fond_monto  = $d["Fondo"]["fond_monto"];
	        
	        $giros = $this->Giro->findAll("expe_tipo='N' and expe_id=$expe_id");
	        
	        $fondo = array("fond_monto" => $fond_monto,
	                       "fond_monto2" => 0,
	                       "fond_monto3" => 0,
	                       "expe_lastre" => $expe_lastre,
	                       "giros"       => $giros,
	                       "tarifa_id"   => "",
	                       "tari_valor"  => "",
	                      );	         
         }
         
           
         include_once(APP_PATH."/app/pdfs/PDF_rendiciones.php");
         
         $pdf = new PDF_rendiciones("L");
         
         $pdf->SetFont('Times','',12);
         
         //print_r($nacional);
         
         $pdf->Run($r, $nacional, $mon2, $mon3, $moneda2, $moneda3, $fondo);
         $pdf->Output();
      }
      
   
   
   function infoChoferes() {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
         $sql = "SELECT e.chof_id, c.chof_apellidos, c.chof_nombres, ca.cami_patente, ".
                "       a.expe_id, a.rend_fecha, a.rend_nro, a.rend_fec_carga, a.rend_fec_aduana, ".
                "       a.rend_fec_bodega, a.rend_fec_descarga, a.rend_fec_carga_imp, ".
                "       a.rend_fec_aduana_imp, a.rend_fec_bodega_imp,                 ".
                "       a.rend_fec_descarga_imp,                                      ".
                "       a.rend_bodega,                                                ".
                "       e.tarifa_id                                                   ".
                "FROM rendiciones a, expediciones_ex e, choferes c, camiones ca       ".
                "WHERE a.expe_id = e.id                                               ".
                "AND a.expe_tipo =  'I'                                               ".
                "AND e.chof_id = c.id                                                 ".
                "AND e.cami_id = ca.id                                                ".
                "AND a.rend_fecha between '2013-01-01' and '2013-10-31' ".
                "ORDER BY e.chof_id, a.id, a.rend_fecha                               ";
                
          $arr = $this->Rendicion->findSql($sql);
          
          for($i=0; $i < count($arr); $i++) {
	         $tarifa_id = $arr[$i]["tarifa_id"];
	         
	         if ($tarifa_id=="")
	            $arr[$i]["tari_valor"] = 0;
	         else {
		        $d = $this->Tarifa->read(null, $tarifa_id);
		        
		        $arr[$i]["tari_valor"] = $d["Tarifa"]["tari_valor"];
		        
	         }
          }
          
          //print_r($arr);

               
           
         include_once(APP_PATH."/app/pdfs/PDF_choferes.php");
         
         $pdf = new PDF_choferes("L");
         
         $pdf->SetFont('Times','',12);
         
         //print_r($nacional);
         
         $pdf->Run("01/10/2013", "31/10/2013", $arr);
         $pdf->Output();
         
   }
   
   function repo_combustibles() {
	  $this->Rendicion->validate=array("fecini", "required|type=date",
	                                   "fecfin", "required|type=date"
	                                  );
	                                  
	  if (!empty($this->data)) {
		 
		 $fecini =$_REQUEST["fecini"]; 
		 $fecfin =$_REQUEST["fecfin"];
		 $this->info_combustibles($fecini, $fecfin); 
	  }
	  
	  if (empty($this->data)) {
		 $this->set("fecini", date("d/m/Y"));
		 $this->set("fecfin", date("d/m/Y"));
		 
	  }
   }
   
   
   function info_combustibles($fecini, $fecfin) {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
         $f1 = date2Mysql($fecini);
         $f2 = date2Mysql($fecfin);
                        
         $arr = $this->Rendicion->findAll("expe_tipo='I' and rend_estado='C' and rend_fecha between '$f1' and '$f2'",
                                          null,
                                         "rend_fecha, rend_nro"
                                         );
                                         
         
         for ($i=0; $i < count($arr); $i++) {
	        $expe_id = $arr[$i]["expe_id"];
	        
	        
	        $rr = $this->ExpedicionEx->findAll("id=$expe_id");
	        
	        $arr[$i]["chofer"] = $rr[0]["chof_apellidos"]." ".$rr[0]["chof_nombres"];
	        
	        $arr[$i]["litros"] = $arr[$i]["rend_litros_ida_mendoza"] + $arr[$i]["rend_litros_regreso_mendoza"];
	        
         }
                                         
           
         include_once(APP_PATH."/app/pdfs/PDF_info_combustibles.php");
         
         $pdf = new PDF_info_combustibles("P");
         
         $pdf->SetFont('Times','',12);
         
         $pdf->Run($fecini, $fecfin, $arr);
         $pdf->Output();
         
   }
   
   function gastos_por_item() {
	  $this->Rendicion->validate=array("fecini"      => "required|type=date",
	                                   "fecfin"      => "required|type=date",
	                                   "argentino"   => "required|type=number",
	                                   "combustible" => "required|type=number",
	                                  );
	                                  
	  if (!empty($this->data)) {		 
		 $fecini      =$_REQUEST["fecini"]; 
		 $fecfin      =$_REQUEST["fecfin"];
		 $argentino   =$_REQUEST["argentino"];
		 $combustible =$_REQUEST["combustible"];
		 
		 $f1 = date2Mysql($fecini);
         $f2 = date2Mysql($fecfin);
      
		 $this->redirect("/rendiciones_int/info_gastos_por_item/$f1/$f2/$argentino/$combustible"); 
	  }
	  
	  if (empty($this->data)) {
		 $this->set("fecini", date("d/m/Y"));
		 $this->set("fecfin", date("d/m/Y"));
		 $this->set("argentino", 55);
		 $this->set("combustible", 500);
		 
	  }
   }
   
   function info_gastos_por_item($f1, $f2, $argentino, $combustible) {
 
      $this->set("fecini", mysql2Date($f1));
      $this->set("fecfin", mysql2Date($f2));
 
      
      $r = $this->Resumen->findAll();
      
      foreach($r as $d)
         $this->Resumen->delete($d["id"]);
      
                     
      $sql = "select id, expe_id, rend_litros_ida_mendoza, rend_litros_regreso_mendoza ".
             "from   rendiciones         ".
             "where  expe_tipo='I'       ".
             "and    rend_estado='C'     ".
             "and    rend_fecha between '$f1' and '$f2' ".
             "order by id";
             
      	
      $suma=0;
             
      $arr = $this->Rendicion->findSql($sql); 
      
      foreach ($arr as $r) {
	     //print_r($r);
	     
	     
	     
	     
	     $expe_id = $r["expe_id"];
	     
	     $bb = $this->Combustible->findAll("expe_id=$expe_id and expe_tipo='I'");
	     
	     if (count($bb) > 0) {
	        
	        $data["Resumen"]["id"]               = "";               
            $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
            $data["Resumen"]["item_id"]          = 97;            
            $data["Resumen"]["dren_monto"]       = 0;
            $data["Resumen"]["moneda_id"]        = 6;
            $data["Resumen"]["dren_litros"]      = $bb[0]["litros"]      ;
            
            $data["Resumen"]["dren_monto"]       = round($bb[0]["litros"]*$combustible, 0);     
                                    
            $data["Resumen"]["item_descripcion"] = "CARGA INICIAL COMBUSTIBLE" ;
            
            $this->Resumen->save($data);
         }     
         
         //if ($r["rend_litros_ida_mendoza"]>0) {
         //   $data["Resumen"]["id"]               = "";               
         //   $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
         //   $data["Resumen"]["item_id"]          = 98;            
         //   $data["Resumen"]["dren_monto"]       = 0;
         //   $data["Resumen"]["moneda_id"]        = 1;
         //   $data["Resumen"]["dren_litros"]      = $r["rend_litros_ida_mendoza"]      ;
         //                           
         //   
         //   $v = round($r["rend_litros_ida_mendoza"]*$combustible, 0);
         //   
         //   //echo $v."<br/>";
         //   
         //   if ($v==0) $v="0";
         //   
         //   $data["Resumen"]["dren_monto"]       =  $v;
         //   
         //   $data["Resumen"]["item_descripcion"] = "COMBUSTIBLE IDA MENDOZA" ;
         //   
         //   $this->Resumen->save($data);
         //}
         //
         //if ($r["rend_litros_regreso_mendoza"]>0) {
         //   $data["Resumen"]["id"]               = "";               
         //   $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
         //   $data["Resumen"]["item_id"]          = 98;            
         //   $data["Resumen"]["dren_monto"]       = 0;
         //   $data["Resumen"]["moneda_id"]        = 1;
         //   $data["Resumen"]["dren_litros"]      = $r["rend_litros_regreso_mendoza"]      ;
         //   
         //   $v = round($r["rend_litros_regreso_mendoza"]*$combustible,0)      ;                        
         //   
         //   if ($v==0) $v = "0";
         //   
         //   $data["Resumen"]["dren_monto"]       = $v;
         //   $data["Resumen"]["item_descripcion"] = "COMBUSTIBLE REGRESO MENDOZA" ;
         //   
         //   $this->Resumen->save($data);
         //}
         //
         
         $bb = $this->Giro->findAll("expe_id=$expe_id and expe_tipo='I' and giro_monto > 0");
         
         foreach($bb as $b) {
	        //echo $b["giro_monto"]."<br/>";
	        
	        $data["Resumen"]["id"]               = "";               
            $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
            $data["Resumen"]["item_id"]          = 99;            
            $data["Resumen"]["dren_monto"]       = 0;
            $data["Resumen"]["moneda_id"]        = $b["mone_id"];
            $data["Resumen"]["dren_litros"]      = "0";
            
            if ($b["mone_id"]==1)
               $data["Resumen"]["dren_monto"]       = round($b["giro_monto"]*$argentino);
            else
               $data["Resumen"]["dren_monto"]       = $b["giro_monto"];
               
            $data["Resumen"]["item_descripcion"] = "GIROS" ;
            
            $this->Resumen->save($data);
         }
         
         $bb = $this->FondoEx->findAll("expe_id=$expe_id");
         
         foreach($bb as $b) {
	        //print_r($b);
	        
	        if ($b["fond_monto"] > 0) {
	           $data["Resumen"]["id"]               = "";               
               $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
               $data["Resumen"]["item_id"]          = 100;            
               $data["Resumen"]["dren_monto"]       = 0;
               $data["Resumen"]["moneda_id"]        = 6;
               $data["Resumen"]["dren_litros"]      = "0";
               $data["Resumen"]["dren_monto"]       = $b["fond_monto"];
                  
               $data["Resumen"]["item_descripcion"] = "ASIGNACION DE FONDOS" ;
               
               $this->Resumen->save($data);
            }
            
            if ($b["fond_monto2"] > 0) {
	           $data["Resumen"]["id"]               = "";               
               $data["Resumen"]["rendicion_id"]     = $r["id"]     ;
               $data["Resumen"]["item_id"]          = 100;            
               $data["Resumen"]["dren_monto"]       = 0;
               $data["Resumen"]["moneda_id"]        = $b["id_moneda2"];
               $data["Resumen"]["dren_litros"]      = "0";
               
               $data["Resumen"]["dren_monto"]       = round($b["fond_monto2"]*$argentino);
         
                  
               $data["Resumen"]["item_descripcion"] = "ASIGNACION DE FONDOS" ;
               
               $this->Resumen->save($data);
            }
         }
	     
	     
         
         $arr2 = $this->Drendicion->findAll("rendicion_id=".$r["id"]." and dren_monto > 0", null, "id");
	     
	     foreach($arr2 as $s) {
		    //print_r($s);
		    
            $data["Resumen"]["id"]               = "";               
            $data["Resumen"]["rendicion_id"]     = $s["rendicion_id"]     ;
            $data["Resumen"]["item_id"]          = $s["item_id"]          ;
            
            if ($s["moneda_id"]==1)
               $data["Resumen"]["dren_monto"]       = round($s["dren_monto"]*$argentino,0)       ;
            else
               $data["Resumen"]["dren_monto"]       = $s["dren_monto"]       ;
               
            $suma += $data["Resumen"]["dren_monto"];   
               
            $data["Resumen"]["moneda_id"]        = $s["moneda_id"]        ;
            $data["Resumen"]["dren_litros"]      = $s["dren_litros"]      ;
            
            $aa = $this->ItemGasto->findAll("id=".$s["item_id"]);
            
            $data["Resumen"]["item_descripcion"] = $aa[0]["item_descripcion"] ;
            
            $this->Resumen->save($data);            
		    
	     }
      }
      
      $arr = $this->Resumen->findSql("select item_descripcion, sum(dren_monto) dren_monto from resumenes group by item_descripcion");
      
      
      for ($i=0; $i < count($arr); $i++) {
	     $arr[$i]["dren_monto"] = number_format($arr[$i]["dren_monto"], 0, ".", ",");
	     
	     $item_descripcion = $arr[$i]["item_descripcion"];
	     
	     $r = $this->Resumen->findAll("item_descripcion='$item_descripcion'", null, "rendicion_id");
	     
	     $s  = "";
	     $s .= "<table cellpadding=\'1\' cellspacing=\'1\' style=\'background:lighgray;\'>\n";
         $s .="<tr><td align=\'center\' style=\'background:white;\' colspan=\'5\'><h3>$item_descripcion</h3></td></tr>\n";
	     $s .="<tr><td align=\'center\' style=\'background:#aabbcc\'>Rendición No.</td>
	               <td align=\'center\' style=\'background:#aabbcc\'>Fecha</td>
	               <td align=\'center\' style=\'background:#aabbcc\'>Monto Pesos</td>
	               <td align=\'center\' style=\'background:#aabbcc\'>Moneda Original</td>
	               <td align=\'center\' style=\'background:#aabbcc\'>Litros</td>
	           </tr>
	          ";	     
	          
	     $total = 0;
	     foreach($r as $d) {
		    $id = $d["rendicion_id"];
		    
		    //echo "id=$id and expe_tipo='I'<br/>";
		    
		    $aa = $this->Rendicion->findAll("id=$id and expe_tipo='I'");
		    
		    //print_r($aa);
		    
		    $rend_nro         = $aa[0]["rend_nro"];
		    $rend_fecha       = $aa[0]["rend_fecha"];
		    $item_descripcion = $item_descripcion;
		    $dren_monto       = $d["dren_monto"];
		    $moneda_id        = $d["moneda_id"];
		    $rend_litros      = $d["dren_litros"];
		    
		    if ($moneda_id=="1")
		       $moneda='ARS';
		    else
		       $moneda='CLP';
		    
		    $total += $dren_monto;
		    $dren_monto = number_format($dren_monto, 0, ".", ",");
		    
		    $s .="<tr><td align=\'right\' style=\'background:white;padding:2px;\'>$rend_nro</td>
		          <td                     style=\'background:white;padding:2px;\'>$rend_fecha</td>
		          <td align=\'right\'     style=\'background:white;padding:2px;\'>$dren_monto</td>
		          <td align=\'center\'    style=\'background:white;padding:2px;\'>$moneda</td>
		          <td align=\'right\'     style=\'background:white;padding:2px;\'>$rend_litros</td>
		          </tr>";
	     }
	     
	     $total = number_format($total, 0, ".", ",");
	     
	     $s .= "<tr><td style=\'background:white\'></td>
	                <td style=\'background:white\'>TOTAL</td>
	                <td style=\'background:white\' align=\'right\'>$total</td>
	                <td style=\'background:white\'></td>
	                <td style=\'background:white\'></td>
	            </tr>\n
	           ";
	               
	     $s .= "</table>\n";
	     
	     $arr[$i]["tabla"] = $s;
      }
      
      $this->set("resumenes", $arr); 
      
      $suma = number_format($suma, 0, ".", ",");
      $this->set("suma",      $suma);
         
   }
   
   
   function adeudado_conductores() {
	  $this->Rendicion->validate=array("fecini", "required|type=date",
	                                   "fecfin", "required|type=date"
	                                  );
	                                  
	  if (!empty($this->data)) {
		 
		 $fecini =$_REQUEST["fecini"]; 
		 $fecfin =$_REQUEST["fecfin"];
		 $this->repo_adeudado_conductores($fecini, $fecfin); 
	  }
	  
	  if (empty($this->data)) {
		 $this->set("fecini", date("d/m/Y"));
		 $this->set("fecfin", date("d/m/Y"));
		 
	  }
   }
   
   function repo_adeudado_conductores($fecini, $fecfin) {
	  while (ob_get_level())
         ob_end_clean();
      header("Content-Encoding: None", true);
      
      $f1 = date2Mysql($fecini);
      $f2 = date2Mysql($fecfin);
      
      $query = "select chof_apellidos, chof_nombres, id, 0 adeudado, 0 adeudado_i             ".
               "from   choferes c,                                         ".
               "(                                                          ".
               "SELECT distinct chof_id chof_id                            ".
               "from rendiciones r, expediciones_ex e                      ".
               "where r.expe_id=e.id                                       ".
               "and    r.rend_fecha between '$f1' and '$f2' ".
               "and    r.expe_tipo='I'                                     ".
               ") a                                                        ".
               "where c.id=a.chof_id ".
               "order by chof_apellidos, chof_nombres";
      
      
      $arr = $this->Chofer->findSql($query);
      
      
      //print_r($arr);
      
      for ($i=0; $i < count($arr); $i++) {
	     
	     $chofer = $arr[$i]["chof_apellidos"].' '.$arr[$i]["chof_nombres"];
	     
	     $arr[$i]["chofer"] = $chofer;
	     
	     $chof_id           = $arr[$i]["id"];
	     
	     $query = "SELECT distinct r.id id ".
                  "from rendiciones r, expediciones_ex e ".
                  "where r.expe_id=e.id ".
                  "  and e.chof_id=$chof_id and rend_fecha between '$f1' and '$f2'".
                  "  and r.expe_tipo='I'";
                  
         //echo $query."<hr/>";
                                           
	     $ids = $this->Rendicion->findSql($query);
	     
	     
	     //print_r($ids);
	     

	     foreach ($ids as $r) {
		    $id = $r["id"]; 
		     
		    $rend = $this->Rendicion->read(0, $id);
		    $fondo_id = $rend["Rendicion"]["fondo_id"];
		    $expe_id  = $rend["Rendicion"]["expe_id"];
		    
		    $ff = $this->FondoEx->read(0,$fondo_id);
		     
		    $fond_monto        = $ff["FondoEx"]["fond_monto"];
		    
		    
	        $rend_devol_chofer = $rend["Rendicion"]["rend_devol_chofer"];
	        
	        $ss = $this->Giro->findAll("expe_id=$expe_id and expe_tipo='I' and mone_id=6");
	        
	        if (count($ss) > 0) 
	           $giro_monto = $ss[0]["giro_monto"];
	        else
	           $giro_monto = 0;
	        
            
	        
	        //echo "fond_monto: $fond_monto rend_devol_chofer: $rend_devol_chofer<hr/>";
		    
	     
	        $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                   "  from drendiciones a, ".
                   "       items_gastos b,  ".
                   "       monedas      c   ".
                   " where rendicion_id = $id ".
                   "   and a.item_id=b.id ".
                   "   and a.moneda_id=c.id ".
                   "   and c.id=6 ".
                   " order by item_orden ";
                   
            $arrd = $this->Drendicion->findSql($sql);
            
            
            $dren_monto=0;  
            for($ii=0; $ii < count($arrd); $ii++) {
	              
	           if ($arrd[$ii]["item_id"]==9) {
		             
		           //echo "A viaticos<hr/>";
		           		        
		             $d = $this->Rendicion->read(null, $id);
		             $rend_dias_viaje_nac = $d["Rendicion"]["rend_dias_viaje_nac"];
		             
		             //echo $d["Rendicion"]["rend_nro"]."<hr/>";
		             
		             $p = $this->Parametro->read(null, 1);
		             $viatico_chile = $p["Parametro"]["viatico_chile"];
		             
		             $arrd[$ii]["dren_monto"] = round($rend_dias_viaje_nac*$viatico_chile, 0);
		             
		             $dren_monto        += $arrd[$ii]["dren_monto"];
		             
		             break;
	              }
	              
	              $dren_monto        += $arrd[$ii]["dren_monto"];
	           }
	           
	        //print_r($arrd);
	           
	        $arr[$i]["adeudado"] = $fond_monto + $giro_monto - $dren_monto - $rend_devol_chofer;
	        
	        
	        //echo "chof_id: $chof_id  adeudado:".$arr[$i]["adeudado"]."<hr/>";
	        
	        //echo "fond_monto: $fond_monto  dren_monto: $dren_monto rend_devol_chofer: $rend_devol_chofer<hr/>";
	        
         
	     
         }
         
         
         $dren_monto = 0;
         
         foreach ($ids as $r) {
		    $id = $r["id"]; 
		     
		    $rend = $this->Rendicion->read(0, $id);
		    $fondo_id = $rend["Rendicion"]["fondo_id"];
		    $expe_id  = $rend["Rendicion"]["expe_id"];
		    
		    $ff = $this->FondoEx->read(0,$fondo_id);
		     
		    $fond_monto        = $ff["FondoEx"]["fond_monto2"];
		    
		    
	        $rend_devol_chofer = $rend["Rendicion"]["rend_devol_chofer_mon2"];
	        
	        $ss = $this->Giro->findAll("expe_id=$expe_id and expe_tipo='I' and mone_id=1");
	        
	        if (count($ss) > 0)
	           $giro_monto = $ss[0]["giro_monto"];
	        else
	           $giro_monto = 0;
            
	        
	        //echo "fond_monto: $fond_monto rend_devol_chofer: $rend_devol_chofer<hr/>";
		    
	     
	        $sql = "select a.*, b.item_descripcion, b.item_procedencia, b.item_litros ".
                   "  from drendiciones a, ".
                   "       items_gastos b,  ".
                   "       monedas      c   ".
                   " where rendicion_id = $id ".
                   "   and a.item_id=b.id ".
                   "   and a.moneda_id=c.id ".
                   "   and c.id=1 ".
                   " order by item_orden ";
                   
            $arrd = $this->Drendicion->findSql($sql);
            
            //print_r($arrd);
            
            
            $dren_monto=0;  
            for($ii=0; $ii < count($arrd); $ii++) {
	              
	           if ($arrd[$ii]["item_id"]==20) {
		                 
		                 $d = $this->Rendicion->read(null, $id);
		                 $rend_dias_viaje_int = $d["Rendicion"]["rend_dias_viaje_int"];
		                 
		                 $p = $this->Parametro->read(null, 1);
		                 $viatico_argentina = $p["Parametro"]["viatico_argentina"];

		                 $arrd[$ii]["dren_monto"] = round($rend_dias_viaje_int*$viatico_argentina, 0);
		                 
		                 $dren_monto += $arrd[$ii]["dren_monto"];
		                 
		                 break;
	           }
	              
	           $dren_monto        += $arrd[$ii]["dren_monto"];
	        }
	           
		        //print_r($arrd);
	           
	        $arr[$i]["adeudado_i"] = ($fond_monto + $giro_monto - $dren_monto - $rend_devol_chofer)*55;
	        
            //echo ($fond_monto - $dren_monto - $rend_devol_chofer)*55; echo "<hr/>";
	     
         }

         
         //print_r($arr);
                             
           
         
            
      }
      
      include_once(APP_PATH."/app/pdfs/PDF_adeudado_conductores.php");
         
      $pdf = new PDF_adeudado_conductores("P");
         
      $pdf->SetFont('Times','',12);
         
      $pdf->Run($fecini, $fecfin, $arr);
      $pdf->Output();
         
   }
   
  

}