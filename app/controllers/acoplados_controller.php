<?php
   class AcopladosController extends AppController {
      var $name="Acoplados";
      var $uses=array("Acoplado");

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

         $arreglo = $this->Acoplado->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/acoplados/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Acoplado->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();

          $g->addField("Patente", "acop_patente"	 ); 	 	 	 	 	 
	      $g->addField("Descripci&oacute;n", "acop_descripcion");
          $g->addField("Bloqueo",            "acop_bloqueo", array("align" => "center",
                                                                   "trad"  => array("S"=>"S�", "N" => "No")
                                                                   )
                      );
          $g->addField("&nbsp;", "comandos");

          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Acoplado->save($this->data))
               $this->redirect("/acoplados");
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["Acoplado"]["acop_bloqueo"]="N";
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Acoplado->save($this->data)) {
               $this->redirect("/acoplados");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Acoplado->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Acoplado->delete($id)) 
            $this->redirect("/acoplados");
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
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/acoplados/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }