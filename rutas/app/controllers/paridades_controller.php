<?php
   class ParidadesController extends AppController {
      var $name="Paridades";
      var $uses=array("Paridad", "Moneda");

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
            if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="par_fecha";
            if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="desc";
         }
         else {
            $page    = 1;
            $sortKey ="par_fecha";
            $orderKey="desc";
         }

         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);

         $arreglo = $this->Paridad->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/paridades/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Paridad->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());

          $mons = $this->Moneda->findAll(null, null, "mone_descripcion");
          
          $monedas=array();
          
          foreach($mons as $r)
             $monedas[$r["id"]] = $r["mone_descripcion"];

          $g = new MiGrid();

          $g->addField("Moneda", "mon_id", array("trad" => $monedas) );
          $g->addField("Fecha",  "par_fecha" );
          $g->addField("Paridad $",  "par_valor", array("align" => "right"));
          $g->addField("Litro Combustible",  "par_valor_litro", array("align" => "right"));
          $g->addField("Bloqueo","par_bloqueo", array("align" => "center",
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
	        
            if ($this->Paridad->save($this->data))
               $this->redirect("/paridades");
         }
         if (empty($this->data)) {
            $this->data["Paridad"] = array("par_fecha"       => date("d/m/Y")
                                          ,"par_valor"       => 0.0
                                          ,"par_valor_litro" => 0.0
                                          ,"par_bloqueo"     => "N"
                                          );
         }
         
         $mons = $this->Moneda->findAll(null, null, "mone_descripcion");
          
         $lista="|";
          
          foreach($mons as $r)
             $lista .= ",".$r["mone_descripcion"]."|".$r["id"];
         
         $this->set("monedas", $lista);
         
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Paridad->save($this->data)) {
               $this->redirect("/paridades");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Paridad->read(null, $id);
         }
         
         $mons = $this->Moneda->findAll(null, null, "mone_descripcion");
          
         $lista="|";
          
          foreach($mons as $r)
             $lista .= ",".$r["mone_descripcion"]."|".$r["id"];
         
         $this->set("monedas", $lista);
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Paridad->delete($id))
            $this->redirect("/paridades");
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
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/paridades/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }