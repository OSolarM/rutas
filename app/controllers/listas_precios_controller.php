<?php
   class ListasPreciosController extends AppController {
      var $name="ListasPrecios";
      var $uses=array("ListaPrecio", "Institucion", "Ciudad");

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

         $arreglo = $this->ListaPrecio->findAll("institucion_id=2", null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/listas_precios/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->ListaPrecio->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();

          $g->addField("A&ntilde;o", "lista_agno"  );
          $g->addField("Origen",  "ciud_nombre"  , array("sortColumn" => false));
          $g->addField("Destino", "ciud_nombre_a", array("sortColumn" => false));
          $g->addField("Auto", "list_auto"   , array("align" => "center",
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   ));
          $g->addField("Precio", "list_precio", array("format" => "money") );

          $g->addField("Bloqueo",          "list_bloqueo", array("align" => "center",
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
            if ($this->ListaPrecio->save($this->data))
               $this->redirect("/listas_precios");
         }
         if (empty($this->data)) {
            //Inicializar
            $this->data["ListaPrecio"]["institucion_id"] = "2";
            $this->data["ListaPrecio"]["lista_agno"]     = date("Y");
            $this->data["ListaPrecio"]["list_auto"]      = "N";
            $this->data["ListaPrecio"]["list_bloqueo"]   = "N";
            
         }
         
            $r = $this->Institucion->findAll(null, null, "inst_razon_social");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["inst_razon_social"]."|".$v["id"];
            }

            $this->set("instituciones", $lista);

            $r = $this->Ciudad->findAll(null, null, "ciud_nombre");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["ciud_nombre"]."|".$v["id"];
            }

            $this->set("origenes", $lista);
            $this->set("destinos", $lista);
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->ListaPrecio->save($this->data)) {
               $this->redirect("/listas_precios");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->ListaPrecio->read(null, $id);
         }
         
             $r = $this->Institucion->findAll(null, null, "inst_razon_social");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["inst_razon_social"]."|".$v["id"];
            }
            
            $this->set("instituciones", $lista);

            $r = $this->Ciudad->findAll(null, null, "ciud_nombre");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["ciud_nombre"]."|".$v["id"];
            }

            $this->set("origenes", $lista);
            $this->set("destinos", $lista);

      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->ListaPrecio->delete($id)) 
            $this->redirect("/listasprecios");
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
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/listas_precios/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }