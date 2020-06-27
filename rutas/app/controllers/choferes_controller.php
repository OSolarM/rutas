<?php
   class ChoferesController extends AppController {
      var $name="Choferes";
      var $uses=array("Chofer");

      function index($page=null) {
         $recsXPage=10;


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

         $arreglo = $this->Chofer->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/choferes/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Chofer->count(), $recsXPage);

         $this->assign("choferes", $arreglo);
         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();

          $g->addField("Rut",              "chof_rut");      
          $g->addField("Apellidos",        "chof_apellidos");
          $g->addField("Nombres",          "chof_nombres");
          $g->addField("Direcci&oacute;n", "chof_direccion");
          $g->addField("Comuna",           "chof_comuna");
          $g->addField("Ciudad",           "chof_ciudad");
          $g->addField("Region",           "chof_region");

          $g->addField("Bloqueo",            "chof_bloqueo", array("align" => "center",
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   )
                      );
          $g->addField("&nbsp;", "comandos");

          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Chofer->save($this->data))
               $this->redirect("/choferes");
         }
         if (empty($this->data)) {
            $this->data["Chofer"]["chof_bloqueo"]="N";
            
            $this->data["Chofer"]["chof_direccion"] = "AVENIDA CLAUDIO ARRAU 7656";
            $this->data["Chofer"]["chof_comuna"   ] = "PUDAHUEL";
            $this->data["Chofer"]["chof_ciudad"   ] = "SANTIAGO";
            $this->data["Chofer"]["chof_region"   ] = "RM";
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Chofer->save($this->data)) {
               $this->redirect("/choferes");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Chofer->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Chofer->delete($id))
            $this->redirect("/choferes");
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
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/choferes/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }   