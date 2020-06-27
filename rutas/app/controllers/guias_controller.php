<?php
   class GuiasController extends AppController {
      var $name = "Guias";
      var $uses = array("Guia", "DetGuias");

      function index($page=null) {
         if ($page==null) $page=1;

         $recsXPage=10;

         $arreglo = $this->Guia->findAll(null, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/tie/guias/index", $page);
         
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
               $this->redirect("/guias/edit/$guia_id");
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
		 $this->Guia->validates["cantidad"] = "required|integer";		 

         if ($id==null)
            $this->redirect("/errores/idNull");

         if (empty($this->data)) {
            if ($this->Guia->findByPk($id)) 
               $this->data = $this->Guia->data;
            else
               $this->redirect("/errores/idNotFound");
         }
         elseif ($this->Guia->save($this->data)) {
	        //print_r($this->data);
	        $codigo = $this->data["DetGuias"]["codigo"];
	        
	        $arr = explode("\'", $codigo);
	         
	        if (count($arr) == 3)
	           $codigo = $arr[1];
	        
	        $this->DetGuias->tbl->where = "guia_id=".$id. " and codigo='$codigo'";
	        
	        //echo "Where: ".$this->DetGuias->tbl->where."<br/>";
	        
	        $this->DetGuias->tbl->prepQuery();
	        
	        if ($this->DetGuias->tbl->getRow()) {
		       $this->set("msg_error", "Codigo '".$codigo."' ya ingresado!");
		       $this->data["DetGuias"]["codigo"] = "";
	        }
	        else {
	        
		       $this->data["DetGuias"]["id"]      = "";
			   $this->data["DetGuias"]["guia_id"] = $this->data["Guia"]["id"];
			   $this->data["DetGuias"]["cant_pistola"] = "0";
			   
			   //print_r($this->data["DetGuias"]);
			   
		       $this->DetGuias->save($this->data);
               $this->redirect("/guias/edit/$id");
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
		 
		 $this->set("det_guias", $arreglo);
      }//edit

      function delete($id=null) {
	     $this->layout = "form";
         if ($id==null)
            $this->redirect("/errores/idNull");

         if ($this->Guia->findByPk($id)) {
            if ($this->Guia->delete($id)) 
               $this->redirect("/guias/index");
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
               $this->redirect("/guias/edit/$guia_id");
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