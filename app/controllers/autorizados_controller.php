<?php
   class AutorizadosController extends AppController {
      var $name="Autorizados";
      var $uses=array("Autorizado", "Ciudad");

      function index($page=1) {
         $recsXPage=10;
         
         $arreglo = $this->Autorizado->findAll(null, null, null, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/autorizados/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Autorizado->count(), $recsXPage);
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $arreglo[$i]["auto_origen_nombre"]="";
	        $arreglo[$i]["auto_destino_nombre"]=""; 
	        if ($this->Ciudad->findByPk($arreglo[$i]["auto_origen"])) {
		       $arreglo[$i]["auto_origen_nombre"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];  
	        }
	        
   	        if ($this->Ciudad->findByPk($arreglo[$i]["auto_destino"])) {
		       $arreglo[$i]["auto_destino_nombre"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];  
	        }

         }
         
         
         $this->assign("autorizados", $arreglo);
         $this->assign('pagination', $pagination->links());
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Autorizado->save($this->data))
               $this->redirect("/autorizados");
         }
         if (empty($this->data)) {
            //Inicializar
         }
         
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
            if ($this->Autorizado->save($this->data)) {
               $this->redirect("/autorizados");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Autorizado->read(null, $id);
         }
         
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

         if ($this->Autorizado->delete($id)) 
            $this->redirect("/autorizados");
         else
            $this->redirect("/errores/idNotFound");
      }
   }
