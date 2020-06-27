<?php
   class ParticularesController extends AppController {
      var $name="Particulares";
      var $uses=array("Particular", "Crt", "OrdenNacional");

      function index($page=null) {
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
         
         $arreglo = $this->Particular->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/particulares/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Particular->count(), $recsXPage);
         
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
            if ($this->Particular->save($this->data))
               $this->redirect("/particulares");
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["Particular"]["estadia"] = 0;
            $this->data["Particular"]["bloqueo"] = "N";
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Particular->save($this->data)) {
               $this->redirect("/particulares");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Particular->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Particular->delete($id)) 
            $this->redirect("/particulares");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      
   }

   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    $id = $row["id"];
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/particulares/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }
   
   