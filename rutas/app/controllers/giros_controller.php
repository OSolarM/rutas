<?php
   class GirosController extends AppController {
      var $name="Giros";
      var $uses=array("Giro", "Expedicion", "ExpedicionEx", "Chofer", "Moneda");

      function index($page=1) {
	     //$this->getExpedicion(50); echo "<hr>";
	     
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
         
                         
         $arreglo = $this->Giro->findAll(null, null, "giro_nro desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/giros/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Giro->count(), $recsXPage);
         
         $this->assign('pagination', $pagination->links());
                  
          $g = new MiGrid();
                        
          $g->addField("Número",  "giro_nro"    , array("align" => "right"));
          $g->addField("Fecha",   "giro_fecha"  );
          $g->addField("Chofer",  "chof_id"     );
          $g->addField("Detalle", "giro_detalle");
          $g->addField("Moneda",  "mone_descripcion", array("sortColumn" => false)     );
          $g->addField("Monto",   "giro_monto", array("format" => "money")  );
     
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }
   
      function llenaListas() {
	     $sql = "id in (select chof_id from expediciones where expe_cierre is null) or ".
	            "id in (select chof_id from expediciones_ex where expe_cierre is null)";
	     
         $arr = $this->Chofer->findAll($sql, null, "chof_apellidos, chof_nombres");
         $lista = "|";

         foreach($arr as $r)
            $lista .= ",".$r["chof_apellidos"]." ".$r["chof_nombres"]."|".$r["id"];

         $this->set("lchoferes", $lista);
         
         $arr = $this->Moneda->findAll("id in (1, 6)", null, "mone_descripcion");
         $lista = "|";

         foreach($arr as $r)
            $lista .= ",".$r["mone_descripcion"]."|".$r["id"];

         $this->set("lmonedas", $lista);         
      }
      
      function ultimoNumero() {
	      $arr = $this->Giro->findSql("select max(giro_nro) giro_nro from giros");
            
          if (count($arr) > 0)
             $giro_nro=$arr[0]["giro_nro"] + 1;
          else
             $giro_nro=1;
               
          return $giro_nro;  
      }

      function form($id=null) {
         $this->layout="form";

         if (!empty($this->data)) {          
	        //print_r($this->data);
	         
            
            if ($this->Giro->save($this->data)) {
               $this->redirect("/giros");
            }
            //else
            //   print_r($this->Giro->errorList);

         }
         if (empty($this->data)) {
	        if ($id!=null) {
		       $this->data = $this->Giro->read(null, $id);
	        }
	        else {
               //Inicializar
               $this->data["Giro"]["giro_nro"    ] = $this->ultimoNumero();
               $this->data["Giro"]["giro_fecha"  ] = date("d/m/Y");;
               $this->data["Giro"]["mone_id"     ] = 6;
               //$this->data["Giro"]["giro_monto"  ] =;
               $this->data["Giro"]["giro_bloqueo"] ="N";
            }
         }

          
         $this->llenaListas();
      }
      
      function getExpedicion($chof_id) {
	     $arr = $this->Expedicion->findAll("chof_id=$chof_id and (expe_cierre is null or expe_cierre='N')", null, "id desc");
	     
	     //print_r($arr);
	     
	     $expe_id="";
	     $expe_tipo="";
	     
	     if (count($arr) > 0) {
		    $expe_id = $arr[0]["id"];
		    $expe_tipo = "N";
	     }
	     else {
		    $arr = $this->ExpedicionEx->findAll("chof_id=$chof_id and (expe_cierre is null or expe_cierre='N')", null, "id desc");
	     
		    //print_r($arr);
		    
	        if (count($arr) > 0) {
		       $expe_id = $arr[0]["id"];
		       $expe_tipo = "I";
	        }
	     }
	     
	     echo "$expe_tipo@@$expe_id@@";
	     
      }

      function delRecord($id=null) {
	     $this->layout="form";
	     
      }
      
   }
   
   class MiGrid extends Grid {
	  function showField($f, $row) {	
		 //print_r($row);
		 
	     $name    = $f["name"];
	     $id    = $row["id"];
	     
	     //echo $name.".<hr>";
	     	     	     
         if ($name=="chof_id") {
		    $chof_apellidos = $row["chof_apellidos"];
		    $chof_nombres   = $row["chof_nombres"];
		    
		    return "<td style=\"background:white\">$chof_apellidos $chof_nombres</td>";
		    
	     }
	     elseif ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
	
		       
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/giros/form/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a>".
		           "</td>"
		           ;
         }    
      }
   }