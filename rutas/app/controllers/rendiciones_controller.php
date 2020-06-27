<?php
   class RendicionesController extends AppController {
      var $name="Rendiciones";
      var $uses=array("Rendicion", "Fondo", "FondoEx", "Expedicion", "ExpedicionEx", "DexpedicionEx", "Dexpedicion", 
                      "Chofer", "Drendicion", "ItemGasto", "Moneda", "Camion", "Acoplado", "Crt", "Parametro", "Cliente", "Combustible", "Giro", "Tarifa");

      function index($page=1) {
	     $this->llena_rendiciones();
	     
         $recsXPage=20;
         
         
         if (!isset($_SESSION["opcion"])) {
            $opcion = "I";
            $_SESSION["opcion"] = $opcion;
         }
         
         $opcion = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
         
         if ($opcion=="")
            $opcion = $_SESSION["opcion"];
         else
            $_SESSION["opcion"] = $opcion;
         
         
         
                 
         if ($opcion=="I")
            $where="rend_estado<>'C' and expe_tipo='N'";
         else
            $where="expe_tipo='N'";
            
         $this->set("opcion", $opcion);
            
         //echo "$opcion  $where <hr>";
         
         $arreglo = $this->Rendicion->findAll($where, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
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
         
         $pagination = new pagination("/rendiciones/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Rendicion->count(), $recsXPage);
         
         $this->assign("rendiciones", $arreglo);
         $this->assign('pagination', $pagination->links());
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

         $this->layout="form";

         if (!empty($this->data)) {
	        //print_r($this->data);
	        
	        unset($this->Rendicion->validate["rend_fec_carga"]);
	        
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
 
               $this->redirect("/rendiciones/runPdf/$id");
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
	           $this->redirect("/rendiciones/edit/$idPadre");
	        
	        $this->Rendicion->setData($this->data);
	        
	        $this->data["Drendicion"]["id"] = $idHijo;
	        $this->data["Drendicion"]["rendicion_id"] = $idPadre;
	        
	        $this->Drendicion->setData($this->data);
	        
	        $t  = $this->Rendicion->validates();
	        $t2 = $this->Drendicion->validates();
	        
	         
            if ($t && $t2) {
	           $this->Rendicion->save($this->data);
	           $this->Drendicion->save($this->data); 
               $this->redirect("/rendiciones/edit/$idPadre");
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
            $this->redirect("/rendiciones/edit/$idPadre");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function runPdf($id) {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
         $data = $this->Rendicion->read(null, $id);
 
         
         $r = $data["Rendicion"];
         
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
         
           
         // Instanciation of inherited class
         $pdf = new PDF("L");
         
         $pdf->SetFont('Times','',12);
         
         //print_r($nacional);
         
         $pdf->Run($r, $nacional, $mon2, $mon3, $moneda2, $moneda3, $fondo);
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
      var $rendicion;
      var $fondo;
      
   // Page header
   
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
          $this->Cell(40, 4, "Fecha aduana   ".$rend_fec_aduana);
          $this->Cell(40, 4, "Fecha bodega   ".$rend_fec_bodega);
          $this->Cell(44, 4, "Fecha descarga ".$rend_fec_descarga);
          
          $dias=0;
          $dias1=0;
          $dias2=0;
          
          if ($rend_fec_aduana!="" && $rend_fec_bodega!="") {
	         $dias1 = $this->diffDates($rend_fec_aduana, $rend_fec_bodega);
          }
          
          
          if ($rend_fec_bodega!="" && $rend_fec_descarga!="") {
	         $dias2 = $this->diffDates($rend_fec_bodega, $rend_fec_descarga);
          }
          
          if ($dias1 > 2) $dias += $dias1 - 2;
          
          if ($dias2 > 2) $dias += $dias2 - 2;
          
          $this->Cell(12, 4, "D�as ".$dias);
          
          $this->Cell(25, 4, "Valor estad�a $". number_format(round($dias*12000,0), 0, ",", "."));
          
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
	  	  
	  $this->row += 24;
	  
	  $this->SetXY(20, $this->row);
	  $this->Cell(60, 4, "FIRMA CHOFER",  "T", 0, "C");
	  $this->Cell(50, 4, "",              0,   0, "L");
	  $this->Cell(60, 4, "FIRMA REVISOR", "T", 0, "C");
	  
	  
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
