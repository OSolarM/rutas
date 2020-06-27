<?php
   class CiudadesController extends AppController {
      var $name="Ciudades";
      var $uses=array("Ciudad");

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

         $arreglo = $this->Ciudad->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/ciudades/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Ciudad->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();

          $g->addField("Nombre", "ciud_nombre" );
          $g->addField("Regi&oacute;n", "ciud_region" );
          $g->addField("Bloqueo",          "ciud_bloqueo", array("align" => "center",
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
            if ($this->Ciudad->save($this->data))
               $this->redirect("/ciudades");
         }
         if (empty($this->data)) {
            //Inicializar
         }
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Ciudad->save($this->data)) {
               $this->redirect("/ciudades");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Ciudad->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Ciudad->delete($id))
            $this->redirect("/ciudades");
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
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/ciudades/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }