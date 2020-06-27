<?php
   class CalceGuiasController extends AppController {
      var $name = "CalceGuias";
      var $uses = array("Guia", "DetGuias");

      function index($page=null) {
         if ($page==null) $page=1;

         $recsXPage=10;

         $arreglo = $this->Guia->findAll(null, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/tie/calce_guias/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->Guia->count(), $recsXPage);
         
         $this->assign('guia', $arreglo);
         $this->assign('pagination', $pagination->links());
      }//index

      function add() {
         $this->layout = "form";
		 $this->Guia->validates["codigo"] = "required";
		 $this->Guia->validates["cantidad"] = "required|integer";

         if (!empty($this->data)) {
            if ($this->Guia->save($this->data)) {	
               $data = $this->Guia->findAll("id=(select max(id) from guias)");
               
			   $data = $data[0];
               $guia_id = $data["id"];

               $this->data["DetGuias"]["guia_id"] = $guia_id; 			   
			   $this->DetGuias->save($this->data);
               $this->redirect("/calce_guias/edit/$guia_id");
			}
            else {
               //Aquí chequear errores DB
               if ($this->Guia->sqlcode !=0)
                  echo $this->Guia->sqlerrm."<br>";

               foreach($this->Guia->errorList as $key => $val)
                  $this->set("msg_$key", $val);
            }
         }
         else {
            //Aquí van las inicializaciones
         }
      }//add

      function edit($id=null) {
         $this->layout = "form";
		 $this->Guia->validates["codigo"] = "required";
		 //$this->Guia->validates["cantidad"] = "required|integer";		 

         if ($id==null)
            $this->redirect("/errores/idNull");

         if (empty($this->data)) {
            if ($this->Guia->findByPk($id)) 
               $this->data = $this->Guia->data;
            else
               $this->redirect("/errores/idNotFound");
         }
         elseif ($this->Guia->save($this->data)) {
	         $codigo = $this->data["DetGuias"]["codigo"];
	         
	         $arr = explode("\'", $codigo);
	         
	         if (count($arr) == 3)
	            $codigo = $arr[1];
	        
	        $this->DetGuias->tbl->where = "guia_id=".$id. " and codigo='$codigo'";
	        
	        //echo "Where: ".$this->DetGuias->tbl->where."<br/>";
	        
	        $this->DetGuias->tbl->prepQuery();
	        
	        if (!$this->DetGuias->tbl->getRow()) {
		       $this->set("msg_error", "Codigo '".$codigo."' no ha sido ingresado!");
		       $this->data["DetGuias"]["codigo"] = "";
	        }
	        else { 
		       $cantidad     = $this->DetGuias->tbl->get("cantidad");
		       $cant_pistola = $this->DetGuias->tbl->get("cant_pistola") + 1;
		       
		       if ($cant_pistola > $cantidad){
		          $this->set("msg_error", "Codigo '".$codigo."' ya ha sido completado!");
		          $this->data["DetGuias"]["codigo"] = "";
	           }
		       else {
		       		          
			      $this->DetGuias->tbl->set("cant_pistola", $cant_pistola);
			      $this->DetGuias->tbl->update();
			       		          
                  $this->redirect("/calce_guias/edit/$id");
               }
		    }
		 }
         else {
            if ($this->Guia->sqlcode !=0)
               echo $this->Guia->sqlerrm."<br>";

            foreach($this->Guia->errorList as $key => $val)
               $this->set("msg_$key", $val);
         }
		 
		 $arreglo = $this->DetGuias->findAll("guia_id=$id", null, "codigo");
		 
		 //print_r($arreglo);
		 $cant_pistola = 0;
		 $cant         = 0;
		 
		 foreach($arreglo as $f) {
			$cant_pistola += $f["cant_pistola"];
			$cant         += $f["cantidad"];
		 }
		 
		 $this->set("cant_pistol", $cant_pistola);
		 $this->set("cant",        $cant);
		 $this->set("faltantes",   $cant - $cant_pistola);
		 
		 $this->set("det_guias", $arreglo);
      }//edit

      function delete($id=null) {
	     $this->layout = "form";
         if ($id==null)
            $this->redirect("/errores/idNull");

         if ($this->Guia->findByPk($id)) {
            if ($this->Guia->delete($id)) 
               $this->redirect("/calce_guias/index");
            else
               $this->redirect("/errores/errDatabase");
         }
         else
            $this->redirect("/errores/idNotFound");

      }//delete
	  
	  function deleteLine($id=null) {
	     $this->layout = "form";
         if ($id==null)
            $this->redirect("/errores/idNull");

	     $data = $this->DetGuias->findAll("id=$id");
		 $data = $data[0];
		 
		 //print_r($data);
		 		 
         $guia_id = $data["guia_id"];
		 		 
         if ($this->DetGuias->findByPk($id)) {
            if ($this->DetGuias->delete($id)) 
               $this->redirect("/calce_guias/edit/$guia_id");
            else
               $this->redirect("/errores/errDatabase");
         }
         else
            $this->redirect("/errores/idNotFound");

      }//delete
	  
	  function excel($id) {
	     $this->noRender = true;
		 
	     $this->DetGuias->tbl->where="guia_id=$id";
		 $this->DetGuias->tbl->aExcel();
	  }
   }//class GuiasController