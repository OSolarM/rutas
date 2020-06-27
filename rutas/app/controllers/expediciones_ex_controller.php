<?php
   class ExpedicionesExController extends AppController {
      var $name="ExpedicionesEx";
      var $uses=array("ExpedicionEx", "DexpedicionEx", "Chofer", "Camion", "Acoplado", "Ciudad", "Institucion", "Crt", "Combustible", "Tarifa");

      function getFormVar($cVar) {
	     if (isset($_REQUEST[$cVar]) || isset($_SESSION[$cVar]))
		    $value = ltrim(rtrim(isset($_REQUEST[$cVar])?$_REQUEST[$cVar]:$_SESSION[$cVar]));		    
	     else
	        $value = "";
	        
	     $_SESSION[$cVar] = $value;		    
	     
	     return $value;
      }
      
      function index($page=1) {
	      
	     //echo "$page <hr>"; 
	     
         $recsXPage=20;
         
         if (isset($_REQUEST["page"])) {
	        //$page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
            //echo "$sortKey $orderKey $page <hr>";
         }
         else {
	        //$page    = 1;
            $sortKey ="expe_nro";
            $orderKey="desc";
         }
         
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         
         $where = "1=1";  
         if (isset($_REQUEST["expe_nro"])) {
            $expe_nro = $_REQUEST["expe_nro"];
                        
            if (isInteger($expe_nro) && trim($expe_nro)!="")
               $where .=" and expe_nro=$expe_nro";
               
            $this->set("expe_nro", $expe_nro);
         }
         
         //Criterio apellidos chofer
         $chof_apellidos = $this->getFormVar("chof_apellidos");
                     
         if ($chof_apellidos !="") {            
            $where .=" and chof_id in (select id from choferes where chof_apellidos like '$chof_apellidos%')";
         }               
         $this->set("chof_apellidos", $chof_apellidos);
            
         //Criterio expedición cerrada
         $expe_cerrado = $this->getFormVar("expe_cerrado");
         if ($expe_cerrado!="") {
            $where .=" and expe_cerrado='$expe_cerrado'";
         }               
         $this->set("expe_cerrado", $expe_cerrado);
         
         
         //echo $where."<hr/>";
         
         
         $arreglo = $this->ExpedicionEx->findAll($where, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         for($i=0; $i < count($arreglo); $i++) {
	        $id = $arreglo[$i]["id"];
	        
	        $aa = $this->Combustible->findAll("expe_id=$id and expe_tipo='I'");
	        
	        if (count($aa) > 0)
	           $arreglo[$i]["combustible"]="S";
	        else
	           $arreglo[$i]["combustible"]="N";
         }
         
         //print_r($arreglo);
         
         $pagination = new pagination("/expediciones_ex/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->ExpedicionEx->count(), $recsXPage);
         
         $this->assign("expediciones", $arreglo);
         $this->assign('pagination', $pagination->links());
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
         
         $lista="|";
         //$arr = $this->Crt->findAll("crts_estado='C' and id not in (select crt_id from dexpediciones_ex)", null, "id");
         $arr = $this->Crt->findAll("crts_estado='C'", null, "id");
         foreach($arr as $r)
            $lista .= ",".$r["crts_numero"]."|".$r["id"];
         
         $this->set("lcrts", $lista);
         
         $lista="|";
         
         $arr = $this->Tarifa->findAll(null, null, "id");
         foreach($arr as $r)
            $lista .= ",".$r["tari_descripcion"]."|".$r["id"];
         
         $this->set("ltarifas", $lista);
      }
      
      function ultimoNumero() {
	      $arr = $this->ExpedicionEx->findSql("select max(expe_nro) expe_nro from expediciones_ex");
            
          if (count($arr) > 0)
             $expe_nro=$arr[0]["expe_nro"] + 1;
          else
             $expe_nro=1;
               
          return $expe_nro;  
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
	        //print_r($this->data); 
	        
	        $expe_lastre = $this->data["ExpedicionEx"]["expe_lastre"];
	        $crt_id      = $this->request("crt_id");
	        
	        if ($expe_lastre=="N" && $crt_id!=null) {
               $data["DexpedicionEx"]["crt_id"]        = $this->request("crt_id");
               
               $d = $this->Crt->read(null, $data["DexpedicionEx"]["crt_id"]);
               
               if (count($d) > 0) {
	              $data["DexpedicionEx"]["dexp_remitente"]   = $d["Crt"]["razon_a"];
                  $data["DexpedicionEx"]["dexp_destinatario"]= $d["Crt"]["razon_b"];
               }
               else {
                  $data["DexpedicionEx"]["dexp_remitente"]   = $this->request("dexp_remitente");
                  $data["DexpedicionEx"]["dexp_destinatario"]= $this->request("dexp_destinatario");
               }      
            }              
            
            $this->ExpedicionEx->setData($this->data);
            
            if ($expe_lastre=="N")
               $this->DexpedicionEx->setData($data);

            $t1 = $this->ExpedicionEx->validates();
            
            if ($expe_lastre=="N")
               $t2 = $this->DexpedicionEx->validates();         
            else
               $t2 = true;   
             
            
            
            if ($t1 && $t2) {
               if ($this->ExpedicionEx->save($this->data)) {
	              $expe_id = $this->ExpedicionEx->tbl->insertId();
	               
	              if ($expe_lastre=="N") {
                     $expe_id = $this->ExpedicionEx->tbl->insertId();
                     $data["DexpedicionEx"]["expe_id"] = $expe_id;
                     $data["DexpedicionEx"]["id"]      = null;
                     
                     //print_r($data);
                     
                     $this->DexpedicionEx->save($data);  
                  }
                  
                  //Voy a modo edición, continua ingresando registros.
                  $this->redirect("/expediciones_ex/edit/$expe_id");
               }
               else
                  print_r($this->ExpedicionEx->errorList);
            }
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["ExpedicionEx"]["expe_fecha"]   = date("d/m/Y");
            $this->data["ExpedicionEx"]["expe_destino"] = "";
            $this->data["ExpedicionEx"]["expe_bloqueo"] = "N";
            $this->data["ExpedicionEx"]["expe_lastre"] = "N";
            $this->data["ExpedicionEx"]["expe_fondos"]  = 0;
               
            $this->data["ExpedicionEx"]["expe_nro"]  = $this->ultimoNumero();
            
            $data["DexpedicionEx"]["dexp_cobra"]  = "N";   
         }

         $this->data["ExpedicionEx"]["expe_fondos"] = 0;
          
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

         $arr = $this->DexpedicionEx->findAll("expe_id=$id", null, "id");

         $this->set("hijos", $arr);

         $this->layout="form";

         $cmdLin = $this->request("cmdLin", "add");
         $id_linea = $this->request("id_linea", null);

         if (!empty($this->data)) {
	        $expe_lastre = $this->data["ExpedicionEx"]["expe_lastre"];
	        $crt_id      = $this->request("crt_id");
	        
	        if ($expe_lastre=="N" && $crt_id!=null) {
               $data["DexpedicionEx"]["crt_id"]        = $this->request("crt_id");        
               $data["DexpedicionEx"]["dexp_remitente"]   = $this->request("dexp_remitente");   
               $data["DexpedicionEx"]["dexp_destinatario"]= $this->request("dexp_destinatario");
               
               if ($data["DexpedicionEx"]["crt_id"]!="") {
                  $d = $this->Crt->read(null, $data["DexpedicionEx"]["crt_id"]);
                  
                  if (count($arr) > 0) {
	                 $data["DexpedicionEx"]["dexp_remitente"]   = $d["Crt"]["razon"];
                     $data["DexpedicionEx"]["dexp_destinatario"]= $d["Crt"]["razon_a"];
                  }
               }
            }
              
            //$this->data["ExpedicionEx"]["expe_nro"]  = $this->ultimoNumero();  
                                                                                           
            $this->ExpedicionEx->setData($this->data);                                       
            if ($expe_lastre=="N") $this->DexpedicionEx->setData($data);                                            
                                                                                           
            $t1 = $this->ExpedicionEx->validates();  
            
            if ($expe_lastre=="N")                                        
               $t2 = $this->DexpedicionEx->validates();                                         
            else
               $t2 = true;
                                                                                           
            if ($t1 && $t2) {                                                              
               //echo "A grabar!";                                                         
               $this->ExpedicionEx->save($this->data);    
               
               $expe_id = $this->ExpedicionEx->tbl->insertId();
               
               if ($expe_lastre=="N") {                                   
                  $crt_id = $this->ExpedicionEx->tbl->insertId();                              
                  $data["DexpedicionEx"]["expe_id"] = $id;                                 
                  $data["DexpedicionEx"]["id"]      = null;                                     
                                                                                              
                  //print_r($data);                                                           
                                                                                              
                  $this->DexpedicionEx->save($data);                                            
               }
                                                                                          
               //Voy a modo edición, continua ingresando registros.                        
               $this->redirect("/expediciones_ex/edit/$id");                             
            }                                                                              
         }
         
         if (empty($this->data)) {
            $this->data = $this->ExpedicionEx->read(null, $id);
            
            $data["DexpedicionEx"]["dexp_cobra"]  = "N";       
         }
         
         //print_r($this->data);
         
         if ($this->data["ExpedicionEx"]["expe_cerrado"]=="S")
            $this->layout="form_cerrado";
         
         $arr = $this->DexpedicionEx->findAll("expe_id=$id", null, "id");
         
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
                        
         $data = $this->DexpedicionEx->read(null, $idRec);
         
         $id = $data["DexpedicionEx"]["expe_id"];
         
         $this->set("idRec", $idRec);
         
         $this->set("idPadre", $id);

         $arr = $this->DexpedicionEx->findAll("crt_id=$id", null, "id");

         $this->set("detalle", $arr);

         if (!empty($this->data)) {
	        $data["DexpedicionEx"]["id"]               = $idRec;  
	        $data["DexpedicionEx"]["crt_id"]          = $id;      
            $data["DexpedicionEx"]["crt_id"]        = $this->request("crt_id");    
            
            $d = $this->Crt->read(null, $data["DexpedicionEx"]["crt_id"]);
            
            if (count($d) > 0) {
	           $data["DexpedicionEx"]["dexp_remitente"]   = $d["Crt"]["razon"];
               $data["DexpedicionEx"]["dexp_destinatario"]= $d["Crt"]["razon_a"];
            }
            else {
               $data["DexpedicionEx"]["dexp_remitente"]   = $this->request("dexp_remitente");
               $data["DexpedicionEx"]["dexp_destinatario"]= $this->request("dexp_destinatario");
            }   
                                                                                           
            $this->ExpedicionEx->setData($this->data);                                       
            $this->DexpedicionEx->setData($data);                                            
                                                                                           
            $t1 = $this->ExpedicionEx->validates();                                          
            $t2 = $this->DexpedicionEx->validates();                                         
                                                                                           
            if ($t1 && $t2) {                                                              
               //echo "A grabar!";                                                         
               $this->ExpedicionEx->save($this->data);                                                                    
                                                   
               $this->DexpedicionEx->save($data);                                            
                                                                                           
               //Voy a modo edición, continua ingresando registros.                        
               $this->redirect("/expediciones_ex/edit/$id");                             
            }                                                                              
         }
         
         if (empty($this->data)) {
            $this->data = $this->ExpedicionEx->read(null, $id);
            
            $data = $this->DexpedicionEx->read(null, $idRec);
            
            $this->set("idRec", $idRec);
            
            unset($this->data["DexpedicionEx"]["id"]);
            $this->data["DexpedicionEx"] = $data["DexpedicionEx"];
         }

         $this->llenaListas();         
         
         $lista="|";
         $arr = $this->Crt->findAll("crts_estado='C' and id not in (select crt_id from dexpediciones_ex where expe_id<>$idRec)", null, "id");
         foreach($arr as $r)
            $lista .= ",".$r["crts_numero"]."|".$r["id"];
         
         $this->set("lcrts", $lista);
      }

      function cerrar($id) {
         $data = $this->ExpedicionEx->read(null, $id); 
         $data["ExpedicionEx"]["expe_cerrado"] = "S";
         
         $this->ExpedicionEx->validate["tarifa_id"]="";

         $this->ExpedicionEx->save($data); 

         $this->redirect("/expediciones_ex/edit/$id"); 
      
      }

      function delRecord($id=null) {
	     $this->layout="form";
	     
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
         $data = $this->DexpedicionEx->read(null, $id);
         
         $expe_id = $data["DexpedicionEx"]["expe_id"];

         if ($this->DexpedicionEx->delete($id)) 
            $this->redirect("/expediciones_ex/edit/$expe_id");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function abrir($id=null) {
	     $this->layout="form";
	     
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }
          
         $this->ExpedicionEx->validate["tarifa_id"]="";
          
         $data = $this->ExpedicionEx->read(null, $id);
         
         $data["ExpedicionEx"]["expe_cerrado"] = "N";
         
         $this->ExpedicionEx->save($data);
         
         $this->redirect("/expediciones_ex/edit/$id");
      }
      
      function imprimir_guia($id) {
      }
      
      function addOc() {
         $this->layout="formOc";
         
         $this->ExpedicionEx->validate["orna_orden_compra"]="required";

         if (!empty($this->data)) {
	        $this->data["ExpedicionEx"]["expe_nro"]  = $this->ultimoNumero();  
	        
            $this->ExpedicionEx->setData($this->data);
            
            $orna_orden_compra = $_REQUEST["orna_orden_compra"];

            $t1 = $this->ExpedicionEx->validates();
            //$t2 = $this->DexpedicionEx->validates();            
             
            if ($t1) {
               //echo "A grabar!";
               if ($this->ExpedicionEx->save($this->data)) {
                  $crt_id = $this->ExpedicionEx->tbl->insertId();
                  
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
	                 
	                 $data["DexpedicionEx"]["id"	             ] = ""; 	 	 	 	 	 	
	                 $data["DexpedicionEx"]["crt_id"	         ] = $crt_id; 	 	 	
	                 $data["DexpedicionEx"]["crt_id"	     ] = $r["orna_no_guia"]; 	 	 	
	                 $data["DexpedicionEx"]["dexp_remitente"	 ] = "CARABINEROS";		 	 	 	 	 	 	 
	                 $data["DexpedicionEx"]["dexp_destinatario"] = $r["orna_nombres"]." ".$r["orna_apellidos"];		 	 	 	 	 	 	 
	                 $data["DexpedicionEx"]["dexp_cobra"	     ] = "N";		 	 	 	 	 	 	 
	                 $data["DexpedicionEx"]["dexp_factura"	 ] = ""; 	 	 	 	
	                 $data["DexpedicionEx"]["dexp_val_factura" ] = "";
	                 
	                 $this->DexpedicionEx->save($data);
	                  
                  }
                  
                  
                  //$this->redirect("/expediciones_ex/edit/$crt_id");
               }
               else
                  print_r($this->ExpedicionEx->errorList);
            }
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["ExpedicionEx"]["expe_fecha"]   = date("d/m/Y");
            $this->data["ExpedicionEx"]["expe_destino"] = "N";
            $this->data["ExpedicionEx"]["expe_bloqueo"] = "N";
            $this->data["ExpedicionEx"]["expe_fondos"]  = 0;
            $this->data["ExpedicionEx"]["expe_nro"]  = $this->ultimoNumero();  
         }

         $this->data["ExpedicionEx"]["expe_fondos"] = 0;
          
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
      
      function getDatosCrt($id) {	     
	     $data = $this->Crt->read(null, $id);
	                 
         if ($data!=null) {
	        $dexp_remitente    = $data["Crt"]["razon"];
            $dexp_destinatario = $data["Crt"]["razon_a"];
         }
         else {
            $dexp_remitente    = "No encontrado";
            $dexp_destinatario = "";
         }
            
	     echo "$dexp_remitente@@$dexp_destinatario@@";
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
			   
		       $linea="&nbsp;<a href=\"javascript:if (confirm('Seguro abrir expedicion?')) location.href='$camino/expediciones_ex/abrir/$id';\">Abrir</a>";
	       }
		    else
		       $linea="";
		       
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/expediciones_ex/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a>".
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