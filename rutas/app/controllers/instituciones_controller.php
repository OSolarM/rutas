<?php
   class InstitucionesController extends AppController {
      var $name="Instituciones";
      var $uses=array("Institucion");

      function index($page=1) {
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
         
         $arreglo = $this->Institucion->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/instituciones/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Institucion->count(), $recsXPage);
         
         $this->assign("camiones", $arreglo);
         $this->assign('pagination', $pagination->links());
         
          $g = new MiGrid();
          
          $g->addField("Rut", "inst_rut"	     );   
          $g->addField("Raz&oacute;n Social", "inst_razon_social");
          $g->addField("Correo 1", "inst_correo1"	 );   
          $g->addField("Correo 2", "inst_correo2"	 );   
          $g->addField("Bloqueo", "inst_bloqueo", array("align" => "center", "trad" => array("S" => "S&iacute;", "N" => "No"))     );
          
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Institucion->save($this->data))
               $this->redirect("/instituciones");
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
            if ($this->Institucion->save($this->data)) {
               $this->redirect("/instituciones");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Institucion->read(null, $id);
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Institucion->delete($id))
            $this->redirect("/instituciones");
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
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/instituciones/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }