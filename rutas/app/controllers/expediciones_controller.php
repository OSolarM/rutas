<?php
   class ExpedicionesController extends AppController {
      var $name="Expediciones";
      var $uses=array("Expedicion", "Dexpedicion", "Chofer", "Camion", "Acoplado", "OrdenNacional", "Ciudad", "Institucion", "Combustible");

      function index($page=1) {
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
                  
         $sql = "select expe_nro       ".
                "      ,expe_fecha     ".
                "      ,chof_apellidos ".
                "      ,chof_nombres   ".
                "      ,cami_patente   ".
                "      ,acop_id        ".
                "      ,expe_destino   ".
                "      ,expe_bloqueo   ".
                "      ,expe_cerrado   ".
                "      ,a.id           ".
                " from expediciones a, ".
                "      choferes     b, ".
                "      camiones     c  ".
                " where a.chof_id=b.id ".
                "   and a.cami_id=c.id ".
                "   and a.expe_cierre is null";
                //"   and a.expe_id not in (select expe_id from rendiciones where expe_tipo='N' and rend_estado='C')";
                
         //echo $sortKey."..<hr/>";
         
         if ($sortKey=="chof_id") {
               $order = "chof_apellidos";
         }
         else if ($sortKey=="cami_id") {
               $order = "cami_patente";
         }
         else
            $order = $sortKey;
            
         //echo $order."<br/>";   
                
         $arreglo = $this->Expedicion->findSql("$sql order by ".$order." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         for ($i=0; $i < count($arreglo); $i++) {
	         $expe_id = $arreglo[$i]["id"];
	         
	         $data = $this->Combustible->findAll("expe_tipo='N' and expe_id=$expe_id");
	         
	         if (count($data) > 0)
	            $arreglo[$i]["combustible"]="Si";
	         else
	            $arreglo[$i]["combustible"]="No";
         }
         
         //print_r($arr);
         
         //$arreglo = $this->Expedicion->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/expediciones/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Expedicion->count(), $recsXPage);
         
         $this->assign('pagination', $pagination->links());
                  
          $g = new MiGrid();
          
          $g->addField("N&uacute;mero", "expe_nro"	); 	
	      $g->addField("Fecha", "expe_fecha"	); 	
	      $g->addField("Chofer", "chof_id"	, array("ownShow" => "showChofer", "sortColumn" => true)); 	
	      $g->addField("Cami&oacute;n", "cami_patente", array("sortColumn" => true)); 	
	      //$g->addField("Acoplado",      "acop_id", array("sortColumn" => false, "ownShow" => "muestraAcoplado")	); 	 	
	      //$g->addField("Destino", "expe_destino");	
	      $g->addField("Combustible", "combustible", array("align" => "center"));  	 	 	 	 	 	 
	      $g->addField("Bloqueo", "expe_bloqueo", array("align" => "center", "trad" => array("S" => "S&iacute;", "N" => "No")));	 	 	 	 	 	 	 
	      $g->addField("Cerrado", "expe_cerrado", array("align" => "center", "trad" => array("S" => "S&iacute;", "N" => "No")));		 	 	 	 	 	 	 
          	 	 	 	 	 	 	        
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }
   
      function llenaListas() {
         $arr = $this->Chofer->findAll(null, null, "chof_apellidos, chof_nombres");
         $lista = "|";

         foreach($arr as $r)
            $lista .= ",".$r["chof_apellidos"]." ".$r["chof_nombres"]."|".$r["id"];

         $this->set("choferes", $lista);

         $arr = $this->Camion->findAll(null, null, "cami_patente");
         $lista = "|";

         foreach($arr as $r)
            $lista .= ",".$r["cami_patente"]."|".$r["id"];

         $this->set("camiones", $lista);

         $arr = $this->Acoplado->findAll(null, null, "acop_patente");
         $lista = "|";

         foreach($arr as $r)
            $lista .= ",".$r["acop_patente"]."|".$r["id"];

         $this->set("patentes", $lista);
      }
      
      function ultimoNumero() {
	      $arr = $this->Expedicion->findSql("select max(expe_nro) expe_nro from expediciones");
            
          if (count($arr) > 0)
             $expe_nro=$arr[0]["expe_nro"] + 1;
          else
             $expe_nro=1;
               
          return $expe_nro;  
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            $data["Dexpedicion"]["dexp_guia"]        = $this->request("dexp_guia");
            
            if ($this->request("dexp_guia")!="") {
               $arr = $this->OrdenNacional->findAll("orna_no_guia=".$data["Dexpedicion"]["dexp_guia"]);
               
               if (count($arr) > 0) {
	              $data["Dexpedicion"]["dexp_remitente"]   = $arr[0]["inst_razon_social"];
                  $data["Dexpedicion"]["dexp_destinatario"]= $arr[0]["orna_nombres"]." ".$arr[0]["orna_apellidos"];
               }
               else {
                  $data["Dexpedicion"]["dexp_remitente"]   = $this->request("dexp_remitente");
                  $data["Dexpedicion"]["dexp_destinatario"]= $this->request("dexp_destinatario");
               }
            }
            
            $data["Dexpedicion"]["dexp_cobra"]       = $this->request("dexp_cobra");
            $data["Dexpedicion"]["dexp_factura"]     = $this->request("dexp_factura");
            $data["Dexpedicion"]["dexp_val_factura"] = $this->request("dexp_val_factura");          

            $this->Expedicion->setData($this->data);
            $this->Dexpedicion->setData($data);

            $t1 = $this->Expedicion->validates();
            $t2 = $this->Dexpedicion->validates();            
             
            if ($t1 && $t2) {
               //echo "A grabar!";
               if ($this->Expedicion->save($this->data)) {
                  $expe_id = $this->Expedicion->tbl->insertId();
                  $data["Dexpedicion"]["expe_id"] = $expe_id;
                  $data["Dexpedicion"]["id"]      = null;
                  
                  //print_r($data);
                  
                  $this->Dexpedicion->save($data);  
                  
                  //Voy a modo edición, continua ingresando registros.
                  $this->redirect("/expediciones/edit/$expe_id");
               }
               else
                  print_r($this->Expedicion->errorList);
            }
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["Expedicion"]["expe_fecha"]   = date("d/m/Y");
            $this->data["Expedicion"]["expe_destino"] = "";
            $this->data["Expedicion"]["expe_bloqueo"] = "N";
            $this->data["Expedicion"]["expe_fondos"]  = 0;
               
            $this->data["Expedicion"]["expe_nro"]  = $this->ultimoNumero();
         }

         $this->data["Expedicion"]["expe_fondos"] = 0;
          
         $this->llenaListas();

         if (isset($_REQUEST["det"])) 
            $det = $_REQUEST["det"];
         else {
            $det = array();
         }

         $this->set("det", $det);
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
         }

         $arr = $this->Dexpedicion->findAll("expe_id=$id", null, "id");

         $this->set("hijos", $arr);

         $this->layout="form";

         $cmdLin = $this->request("cmdLin", "add");
         $id_linea = $this->request("id_linea", null);

         if (!empty($this->data)) {
            $data["Dexpedicion"]["dexp_guia"]        = $this->request("dexp_guia");        
            $data["Dexpedicion"]["dexp_remitente"]   = $this->request("dexp_remitente");   
            $data["Dexpedicion"]["dexp_destinatario"]= $this->request("dexp_destinatario");
            
            if ($data["Dexpedicion"]["dexp_guia"]!="") {
               $arr = $this->OrdenNacional->findAll("orna_no_guia=".$data["Dexpedicion"]["dexp_guia"]);
               
               if (count($arr) > 0) {
	              $data["Dexpedicion"]["dexp_remitente"]   = $arr[0]["inst_razon_social"];
                  $data["Dexpedicion"]["dexp_destinatario"]= $arr[0]["orna_nombres"]." ".$arr[0]["orna_apellidos"];
               }
            }
            
            $data["Dexpedicion"]["dexp_cobra"]       = $this->request("dexp_cobra");       
            $data["Dexpedicion"]["dexp_factura"]     = $this->request("dexp_factura");     
            $data["Dexpedicion"]["dexp_val_factura"] = $this->request("dexp_val_factura");     
               
            //$this->data["Expedicion"]["expe_nro"]  = $this->ultimoNumero();  
                                                                                           
            $this->Expedicion->setData($this->data);                                       
            $this->Dexpedicion->setData($data);                                            
                                                                                           
            $t1 = $this->Expedicion->validates();                                          
            $t2 = $this->Dexpedicion->validates();                                         
                                                                                           
            if ($t1 && $t2) {                                                              
               //echo "A grabar!";                                                         
               $this->Expedicion->save($this->data);                                       
               $expe_id = $this->Expedicion->tbl->insertId();                              
               $data["Dexpedicion"]["expe_id"] = $id;                                 
               $data["Dexpedicion"]["id"]      = null;                                     
                                                                                           
               //print_r($data);                                                           
                                                                                           
               $this->Dexpedicion->save($data);                                            
                                                                                           
               //Voy a modo edición, continua ingresando registros.                        
               $this->redirect("/expediciones/edit/$id");                             
            }                                                                              
         }
         
         if (empty($this->data)) {
            $this->data = $this->Expedicion->read(null, $id);
            
            $data["Dexpedicion"]["dexp_cobra"]  = "N";       
         }
         
         if ($this->data["Expedicion"]["expe_cerrado"]=="S")
            $this->layout="form_cerrado";
         
         $arr = $this->Dexpedicion->findAll("expe_id=$id", null, "id");
         
         $this->set("detalle", $arr);

         $this->llenaListas();         
      }
      
      function editRecord($idRec=null) {
         if ($idRec==null) {
            $this->redirect("/errores/pkNotFound");
            return;
         }
         
         if (isset($_REQUEST["idRec"]))
            $idRec = $_REQUEST["idRec"];
                        
         $data = $this->Dexpedicion->read(null, $idRec);
         
         $id = $data["Dexpedicion"]["expe_id"];
         
         $this->set("idRec", $idRec);
         
         $this->set("idPadre", $id);

         $arr = $this->Dexpedicion->findAll("expe_id=$id", null, "id");

         $this->set("detalle", $arr);

         if (!empty($this->data)) {
	        $data["Dexpedicion"]["id"]               = $idRec;  
	        $data["Dexpedicion"]["expe_id"]          = $id;      
            $data["Dexpedicion"]["dexp_guia"]        = $this->request("dexp_guia");    
            
            $arr = $this->OrdenNacional->findAll("orna_no_guia=".$data["Dexpedicion"]["dexp_guia"]);
            
            if (count($arr) > 0) {
	           $data["Dexpedicion"]["dexp_remitente"]   = $arr[0]["inst_razon_social"];
               $data["Dexpedicion"]["dexp_destinatario"]= $arr[0]["orna_nombres"]." ".$arr[0]["orna_apellidos"];
            }
            else {
               $data["Dexpedicion"]["dexp_remitente"]   = $this->request("dexp_remitente");
               $data["Dexpedicion"]["dexp_destinatario"]= $this->request("dexp_destinatario");
            }
                
            $data["Dexpedicion"]["dexp_cobra"]       = $this->request("dexp_cobra");       
            $data["Dexpedicion"]["dexp_factura"]     = $this->request("dexp_factura");     
            $data["Dexpedicion"]["dexp_val_factura"] = $this->request("dexp_val_factura");       
                                                                                           
            $this->Expedicion->setData($this->data);                                       
            $this->Dexpedicion->setData($data);                                            
                                                                                           
            $t1 = $this->Expedicion->validates();                                          
            $t2 = $this->Dexpedicion->validates();                                         
                                                                                           
            if ($t1 && $t2) {                                                              
               //echo "A grabar!";                                                         
               $this->Expedicion->save($this->data);                                                                    
                                                   
               $this->Dexpedicion->save($data);                                            
                                                                                           
               //Voy a modo edición, continua ingresando registros.                        
               $this->redirect("/expediciones/edit/$id");                             
            }                                                                              
         }
         
         if (empty($this->data)) {
            $this->data = $this->Expedicion->read(null, $id);
            
            $data = $this->Dexpedicion->read(null, $idRec);
            
            $this->set("idRec", $idRec);
            
            unset($this->data["Dexpedicion"]["id"]);
            $this->data["Dexpedicion"] = $data["Dexpedicion"];
         }

         $this->llenaListas();         
      }

      function cerrar($id) {
         $data = $this->Expedicion->read(null, $id); 
         $data["Expedicion"]["expe_cerrado"] = "S";

         $this->Expedicion->save($data); 

         $this->redirect("/expediciones/edit/$id"); 
      
      }

      function delRecord($id=null) {
	     $this->layout="form";
	     
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
         $data = $this->Dexpedicion->read(null, $id);
         
         $expe_id = $data["Dexpedicion"]["expe_id"];

         if ($this->Dexpedicion->delete($id)) 
            $this->redirect("/expediciones/edit/$expe_id");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function abrir($id=null) {
	     $this->layout="form";
	     
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
         $data = $this->Expedicion->read(null, $id);
         
         $data["Expedicion"]["expe_cerrado"] = "N";
         
         $this->Expedicion->save($data);
         
         $this->redirect("/expediciones/edit/$id");
      }
      
      function imprimir_guia($id) {
      }
      
      function addOc() {
         $this->layout="formOc";
         
         $this->Expedicion->validate["orna_orden_compra"]="required";

         if (!empty($this->data)) {
	        $this->data["Expedicion"]["expe_nro"]  = $this->ultimoNumero();  
	        
            $this->Expedicion->setData($this->data);
            
            $orna_orden_compra = $_REQUEST["orna_orden_compra"];

            $t1 = $this->Expedicion->validates();
            //$t2 = $this->Dexpedicion->validates();            
             
            if ($t1) {
               //echo "A grabar!";
               if ($this->Expedicion->save($this->data)) {
                  $expe_id = $this->Expedicion->tbl->insertId();
                  
                  $arr = $this->OrdenNacional->findAll("orna_orden_compra='$orna_orden_compra' and orna_cerrar='S' and orna_nula<>'S' and orna_no_guia is not null", null, "id");
                  
                  /*
                  $sql = "orna_no_guia in ( ".
                                            "450".
                                            ",510".
                                            ",528".
                                            ",539".
                                            ",516".
                                            ",535".
                                            ",447".
                                            ",458".
                                            ",513".
                                            ",508".
                                            ",460".
                                            ",543".
                                            ",623".
                                            ",758".
                                            ",761".
                                            ",485".
                                            ",444".
                                            ",574".
                                            ",600".
                                            ",523".
                                            ",520".
                                            ",518".
                                            ",454".
                                            ",470".
                                            ")";
                  
                          $arr = $this->OrdenNacional->findAll($sql, null, "orna_no_guia");
                  
                  
                  echo "orna_orden_compra='$orna_orden_compra' and orna_cerrar='S' and orna_nula<>'S' and orna_no_guia is not null<hr>";
                  */
                  
                  foreach($arr as $r) {
	                 $data=array();
	                 
	                 $data["Dexpedicion"]["id"	             ] = ""; 	 	 	 	 	 	
	                 $data["Dexpedicion"]["expe_id"	         ] = $expe_id; 	 	 	
	                 $data["Dexpedicion"]["dexp_guia"	     ] = $r["orna_no_guia"]; 	 	 	
	                 $data["Dexpedicion"]["dexp_remitente"	 ] = "CARABINEROS";		 	 	 	 	 	 	 
	                 $data["Dexpedicion"]["dexp_destinatario"] = $r["orna_nombres"]." ".$r["orna_apellidos"];		 	 	 	 	 	 	 
	                 $data["Dexpedicion"]["dexp_cobra"	     ] = "N";		 	 	 	 	 	 	 
	                 $data["Dexpedicion"]["dexp_factura"	 ] = ""; 	 	 	 	
	                 $data["Dexpedicion"]["dexp_val_factura" ] = "";
	                 
	                 $this->Dexpedicion->save($data);
	                  
                  }
                  
                  
                  //$this->redirect("/expediciones/edit/$expe_id");
               }
               else
                  print_r($this->Expedicion->errorList);
            }
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["Expedicion"]["expe_fecha"]   = date("d/m/Y");
            $this->data["Expedicion"]["expe_destino"] = "N";
            $this->data["Expedicion"]["expe_bloqueo"] = "N";
            $this->data["Expedicion"]["expe_fondos"]  = 0;
            $this->data["Expedicion"]["expe_nro"]  = $this->ultimoNumero();  
         }

         $this->data["Expedicion"]["expe_fondos"] = 0;
          
         $this->llenaListas();

         if (isset($_REQUEST["det"])) 
            $det = $_REQUEST["det"];
         else {
            $det = array();
         }

         $this->set("det", $det);
         
         $arr = $this->OrdenNacional->findAll("orna_cerrar='S' and orna_nula <> 'S' and orna_no_guia is not null");
         
         $lista=array();
         
         $listado = "|";
         foreach($arr as $r)
            if (!in_array($r["orna_orden_compra"], $lista)) {
               $lista[] = $r["orna_orden_compra"];
               
               $data = $this->Ciudad->read(null, $r["orna_origen"]);
               
               //print_r($data);
               
               $listado .= ",".$r["orna_orden_compra"]."-".$data["Ciudad"]["ciud_nombre"]."|".$r["orna_orden_compra"];
            }
          
         $this->set("ordenes", $listado);     
         
      }
      
      function hola($orna_no_guia) {
	     if ($orna_no_guia==0) {
		    echo "PENDIENTE@@PENDIENTE@@";
	     }
	     else {
	        
	        
	        $arr = $this->OrdenNacional->findAll("orna_no_guia=$orna_no_guia");
               
            if (count($arr) > 0) {
	           $dexp_remitente    = $arr[0]["inst_razon_social"];
               $dexp_destinatario = $arr[0]["orna_nombres"]." ".$arr[0]["orna_apellidos"];
            }
            else {
               $dexp_remitente    = "No encontrado";
               $dexp_destinatario = "";
            }
               
	        echo "$dexp_remitente@@$dexp_destinatario@@";
         }
      }
   }
   
   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     $expe_cerrado = $row["expe_cerrado"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    
		    $id = $row["id"];
		    
		    if ($expe_cerrado=="S") {
			   $camino = APP_HTTP;
			   
		       $linea="&nbsp;<a href=\"javascript:if (confirm('Seguro abrir expedicion?')) location.href='$camino/expediciones/abrir/$id';\">Abrir</a>";
	       }
		    else
		       $linea="";
		       
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/expediciones/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a>".
		           $linea        .
		           "</td>"
		           ;
         }    
      }
      
      function showChofer($f, $row) {
	     $valor = $row["chof_apellidos"]." ".$row["chof_nombres"];
	     return $valor;	    
      }
      
      function muestraAcoplado($f, $row) {
	     $acop_id = $row["acop_id"];
	     
	     return $acop_id;
      }
   }