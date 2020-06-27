<?php
   class CombustiblesController extends AppController {
      var $name="Combustibles";
      var $uses=array("Combustible", "Chofer", "Camion", "Expedicion", "ExpedicionEx");

      function index($page=null) {
	     //$this->getExpedicion("I", 8);
	     
         $recsXPage=20;
            
         if (isset($_REQUEST["page"])) {
	        $page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
            
            //echo $sortKey."<hr>";
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
         
         $sql = "SELECT  a.id                                       ".
                "      , a.fecha                                    ".
                "      , a.expe_tipo                                ".
                "      , a.expe_id                                  ".
                "      , a.kms                                      ".
                "      , a.kms_llegada                              ".
                "      , a.litros                                   ".
                "      , a.bloqueo                                  ".
                "      , b.expe_nro                                 ".
                "      , b.expe_destino                             ".
                "      , c.chof_apellidos                           ".
                "      , c.chof_nombres                             ".
                "      , cc.cami_patente                            ".
                "FROM  combustibles a                               ".
                "     ,expediciones b                               ".
                "     ,choferes     c                               ".
                "     ,camiones     cc                              ".
                "where a.expe_id=b.id                               ".
                "and   a.cierre is null                             ".
                "and   b.chof_id=c.id                               ".
                "and   b.cami_id=cc.id                              ".
                "UNION                                              ".
                "SELECT  a.id                                       ".
                "      , a.fecha                                    ".
                "      , a.expe_tipo                                ".
                "      , a.expe_id                                  ".
                "      , a.kms                                      ".
                "      , a.kms_llegada                              ".
                "      , a.litros                                   ".
                "      , a.bloqueo                                  ".
                "      , b.expe_nro                                 ".
                "      , b.expe_destino                             ".
                "      , c.chof_apellidos                           ".
                "      , c.chof_nombres                             ".
                "      , cc.cami_patente                            ".
                "FROM  combustibles a                               ".
                "     ,expediciones_ex b                            ".
                "     ,choferes     c                               ".
                "     ,camiones     cc                              ".
                "where a.expe_id=b.id                               ".
                "and   a.cierre is null                             ".
                "and   b.chof_id=c.id                               ".
                "and   b.cami_id=cc.id                              ";
                
         //$sql = "select * from ($sql) a order by expe_tipo, expe_nro desc ";
                
     
                 
         
         $arreglo = $this->Combustible->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $expe_tipo = $arreglo[$i]["expe_tipo"];
	        $expe_id   = $arreglo[$i]["expe_id"];
	        
	        if ($expe_tipo=="N") {
		       $d = $this->Expedicion->read(null, $expe_id);
		       $chofer       = $d["Expedicion"]["chof_apellidos"]." ".$d["Expedicion"]["chof_nombres"];
		       $expe_destino = $d["Expedicion"]["expe_destino"];
		       $expe_nro     = $d["Expedicion"]["expe_nro"];
		       $cami_patente = $d["Expedicion"]["cami_patente"]; 
	        }
	        else {
               $d = $this->ExpedicionEx->read(null, $expe_id);
		       $chofer       = $d["ExpedicionEx"]["chof_apellidos"]." ".$d["ExpedicionEx"]["chof_nombres"];
		       $expe_destino = $d["ExpedicionEx"]["expe_destino"];	
		       $expe_nro     = $d["ExpedicionEx"]["expe_nro"];	 
		       $cami_patente = $d["ExpedicionEx"]["cami_patente"];        
	        }
	        
	        //print_r($d);
	        
	        $arreglo[$i]["chofer"      ] = $chofer;
	        $arreglo[$i]["expe_destino"] = $expe_destino;
	        $arreglo[$i]["expe_nro"]     = $expe_nro;
	        $arreglo[$i]["cami_patente"] = $cami_patente;
         }
         
         //print_r($arreglo);
         
         //$arreglo = $this->Combustible->findSql($sql, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/combustibles/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Combustible->count(), $recsXPage);
         
         $this->assign("camiones", $arreglo);
         $this->assign('pagination', $pagination->links());
         
    
          $g = new MiGrid();
                      
          $g->addField("Fecha",             "fecha");
          $g->addField("Tipo",              "expe_tipo",      array("trad" => array("N" => "Nacional", "I" => "Internacional")));
          $g->addField("Expedici&oacute;n", "expe_nro",       array("align" => "right", "sortColumn" => false));
          $g->addField("Chofer",            "chofer",         array("sortColumn" => false));
          $g->addField("Cami&oacute;n",     "cami_patente",   array("sortColumn" => false));
          $g->addField("Kilometraje",       "kms"      ,      array("align" => "right"));
          $g->addField("Litros",            "litros"   ,      array("align" => "right"));
          $g->addField("Destino",           "expe_destino",   array("sortColumn" => false)  );
          $g->addField("Kms.Llegada",       "kms_llegada",    array("align" => "right"));
          $g->addField("Bloqueo",           "bloqueo",        array("align" => "center", 
                                                                    "trad"  => array("S"=>"Sí", "N" => "No")
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
	        $expe_tipo = $this->data["Combustible"]["expe_tipo"];
	        $expe_nro  = $_REQUEST["expe_nro"];
	        
	        $this->data["Combustible"]["expe_nro"] = $expe_nro;
	        
	        
	        
	        if ($expe_tipo!="" && $expe_nro!="") {
		       if ($expe_tipo=="N") 
		          $arr = $this->Expedicion->findAll("expe_nro=$expe_nro");
		       else
		          $arr = $this->ExpedicionEx->findAll("expe_nro=$expe_nro");
		          
		       if (count($arr) > 0)
		          $this->data["Combustible"]["expe_id"]= $arr[0]["id"];
	          
	        }
	        //print_r($this->data);
            if ($this->Combustible->save($this->data)) {	            
               $this->redirect("/combustibles");
               return;
            }
            
            //print_r($this->Combustible->errorList);
         }
         if (empty($this->data)) {
	        $this->data["Combustible"]["fecha"] = date("d/m/Y");
            $this->data["Combustible"]["kms"] = 0;
            $this->data["Combustible"]["kms_llegada"] = 0;
            $this->data["Combustible"]["litros"] = 0;
            $this->data["Combustible"]["bloqueo"] = "N";
            $this->data["Combustible"]["expe_tipo"] = "N";
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            $expe_nro  = $_REQUEST["expe_nro"];
	        
	        $this->data["Combustible"]["expe_nro"] = $expe_nro;	         
	        
            if ($this->Combustible->save($this->data)) {
               $this->redirect("/combustibles");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Combustible->read(null, $id);
         }
         
         
         $expe_tipo=$this->data["Combustible"]["expe_tipo"];
         $expe_id  =$this->data["Combustible"]["expe_id"];
         
         if ($expe_tipo=="N") {
            $data = $this->Expedicion->read(null, $expe_id);   
            $chofer = $data["Expedicion"]["chof_apellidos"]." ".$data["Expedicion"]["chof_nombres"];    
            $cami_patente = $data["Expedicion"]["cami_patente"];
            $expe_destino = $data["Expedicion"]["expe_destino"];
            $expe_nro     = $data["Expedicion"]["expe_nro"];
         }
         else {
            $data = $this->ExpedicionEx->read(null, $expe_id);
            $chofer = $data["ExpedicionEx"]["chof_apellidos"]." ".$data["ExpedicionEx"]["chof_nombres"];
            $cami_patente = $data["ExpedicionEx"]["cami_patente"];
            $expe_destino = $data["ExpedicionEx"]["expe_destino"];
            $expe_nro     = $data["ExpedicionEx"]["expe_nro"];
         }
         
         $this->set("chofer", $chofer);
         $this->set("cami_patente", $cami_patente);
         $this->set("expe_destino", $expe_destino);
         $this->set("expe_nro",     $expe_nro);
      }
      
      function getExpedicion($expe_tipo, $expe_nro) {
      
         if ($expe_tipo=="N") {
	        $arr = $this->Expedicion->findAll("expe_nro=$expe_nro");

         }
         else {
	        $arr = $this->ExpedicionEx->findAll("expe_nro=$expe_nro");
         }
         
         //echo $expe_tipo." ".$expe_nro;
         
         if (count($arr) > 0) {
		    $r = $arr[0];
		    $chofer = $r["chof_apellidos"]." ".$r["chof_nombres"];
		    $cami_patente = $r["cami_patente"];
		    $expe_destino = $r["expe_destino"];
	     }
	     else {
		    $chofer="NO SE ENCONTRO LA EXPEDICION: $expe_nro";
		    $cami_patente="";
		    $expe_destino="";
		    $expe_nro="";
	     }
	     
	     echo $chofer."@@".$cami_patente."@@".$expe_destino."@@".$expe_nro."@@";
      }
      
      function llena_listas() {
	     $arr = $this->Chofer->findAll(null, null, "chof_apellidos,chof_nombres");
	     $lista="|";
	     
	     foreach($arr as $r)
	        $lista .=",".$r["chof_apellidos"]." ".$r["chof_nombres"]."|".$r["chof_id"];
	        
	     $this->set("lchoferes", $lista);
	     
	     $arr = $this->Camion->findAll(null, null, "cami_patente");
	     $lista="|";
	     
	     foreach($arr as $r)
	        $lista .=",".$r["cami_patente"]."|".$r["id"];
	        
	     $this->set("lcamiones", $lista);	     
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Combustible->delete($id)) 
            $this->redirect("/combustibles");
         else
            $this->redirect("/errores/idNotFound");
      }
   }

   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name=="comandos") {
	        $id = $row["id"];
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/combustibles/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
	     }
	     else if($name=="chofer_id") {
		    return "<td bgcolor=\"white\">".$row["chof_apellidos"]." ".$row["chof_nombres"]."</td>";
	     }
	     else if($name=="camion_id") {
		    return "<td bgcolor=\"white\">".$row["cami_patente"]."</td>";
	     }	     
	     else {
		      return parent::showField($f, $row);
         }    
      }
   }