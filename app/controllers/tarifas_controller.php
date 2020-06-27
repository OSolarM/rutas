<?php
   class TarifasController extends AppController {
      var $name="Tarifas";
      var $uses=array("Tarifa");

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
            if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="tari_descripcion";
            if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="asc";
         }
         else {
            $page    = 1;
            $sortKey ="tari_descripcion";
            $orderKey="asc";
         }

         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);

         $arreglo = $this->Tarifa->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/tarifas/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Tarifa->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());

          $g = new MiGrid();
          
          $g->addField("Tramo",  "tari_descripcion" );
          $g->addField("Valor",  "tari_valor", array("align" => "right"));
          $g->addField("Bloqueo","tari_bloqueo", array("align" => "center",
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
	        //print_r($this->data); return;
	        
            if ($this->Tarifa->save($this->data))
               $this->redirect("/tarifas");
         }
         if (empty($this->data)) {
            $this->data["Paridad"] = array("tari_valor"       => 0.0
                                          ,"tari_bloqueo"     => "N"
                                          );
         }

      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Tarifa->save($this->data)) {
               $this->redirect("/tarifas");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Tarifa->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Tarifa->delete($id))
            $this->redirect("/tarifas");
         else
            $this->redirect("/errores/idNotFound");
      }
   }

   class MiGrid extends Grid {
      function showField($f, $row) {
         $name    = $f["name"];

         if ($name=="tari_valor") {
	        $tari_valor = $row["tari_valor"];
	        
            return "<td style=\"background:white\" align=\"right\">".number_format($tari_valor, 0, ",", ".")."</td>";
         }
         else if ($name!="comandos")
            return parent::showField($f, $row);
         else {
            $id = $row["id"];
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/tarifas/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }   