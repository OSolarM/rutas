<?php
   class GradosController extends AppController {
      var $name="Grados";
      var $uses=array("Grado", "Institucion");

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
         
         
         
         $arreglo = $this->Grado->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/grados/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->Grado->count(), $recsXPage);
         
         $this->assign('pagination', $pagination->links());
         
         //echo $pagination->links()."<hr/>";
         
          $g = new MiGrid();
          
	 	 	 	 	 	 	
	      $g->addField("Instituci&oacute;n", "inst_razon_social", array("sortColumn" => false)	 );
	      $g->addField("Grado", "grad_descripcion");	 	 	 	 	 
	      $g->addField("D&iacute;as Retiro", "grad_dias", array("align" => "right"));
	      $g->addField("Bloqueo", "grad_bloqueo", array("align" => "center", "trad" => array("S" => "S&iacute;", "N" => "No"))    );          
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }


      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Grado->save($this->data))
               $this->redirect("/grados");
         }
         
         $this->set("instituciones", $this->Institucion->getInstituciones());
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Grado->save($this->data)) {
               $this->redirect("/grados");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Grado->read(null, $id);
         }

         $this->set("instituciones", $this->Institucion->getInstituciones());
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Grado->delete($id)) 
            $this->redirect("/grados");
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
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/grados/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }   