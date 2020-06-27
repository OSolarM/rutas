<?php
   class LibrosVentasController extends AppController {
      var $name="LibrosVentas";
      var $uses=array("LibroVenta", "Crt");

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
	        if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="fecha";
	        if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="desc";
         }
         else {
	        $page    = 1;
            $sortKey ="fecha";
            $orderKey="desc";
         }
              
         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         $arreglo = $this->LibroVenta->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/libros_ventas/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->LibroVenta->count(), $recsXPage);
         
         $this->assign("camiones", $arreglo);
         $this->assign('pagination', $pagination->links());
         
         
         for ($i=0; $i < count($arreglo); $i++) {
	         $crt_id = ltrim(rtrim($arreglo[$i]["crt_id"]));
	         
	         $aa=array();
	         if ($crt_id!="") {
		        $aa = $this->Crt->findAll("id=$crt_id");		        		        
	         }
	         
	         if (count($aa) > 0)
	            $arreglo[$i]["crts_numero"] = $aa[0]["crts_numero"];
	         else
	            $arreglo[$i]["crts_numero"] = "";
	         
	         
	         
         }
         
    
          $g = new MiGrid();
   
          $g->addField("Tipo"        ,"tipo_docto",  array("trad" => array("N"=> "Nacional", "I" => "Exportación")));
          $g->addField("CRT No"      ,"crts_numero", array("sortColumn" => false)  );
          $g->addField("Fecha"       ,"fecha");
          $g->addField("Rut"         ,"rut");   
          $g->addField("Razón Social","razon");
          $g->addField("DC"          ,"docto");
          $g->addField("Número"      ,"numero", array("align" => "right"));
          $g->addField("Fec/Emisión" ,"emision");  
          $g->addField("Fec/Vencto." ,"vencto");
          $g->addField("Neto"        ,"neto", array("align" => "right"));
          $g->addField("Iva"         ,"iva", array("align" => "right"));   
          $g->addField("Total"       ,"total", array("align" => "right"));
          $g->addField("Estado"      ,"estado", array("trad" => array("I"=>"Ingresado", "N", "Nulo")));

          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
          
          //echo $g->show();
           
      }

      function anula($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
	        $this->data["LibroVenta"]["neto"]  =0;
	        $this->data["LibroVenta"]["iva"]   =0;
	        $this->data["LibroVenta"]["total"] =0;
	        $this->data["LibroVenta"]["estado"] ="N";
	        
	        $crt_id = $this->data["LibroVenta"]["crt_id"];
	         
            if ($this->LibroVenta->save($this->data)) {
	           if (trim($crt_id) !="") {
		          $aa = $this->Crt->findAll("id=$crt_id");
		          
		          if (count($aa) > 0) {
			         $aa[0]["factura_crt"]="";
			         
			         $data["Crt"]=$aa[0];
			         
			         $this->Crt->save($data);
		          }
	           }
	              
               $this->redirect("/libros_ventas");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->LibroVenta->read(null, $id);
            
            $crt_id=$this->data["LibroVenta"]["crt_id"];
            
            $aa=array();
            if (trim($crt_id) !="")
               $aa = $this->Crt->findAll("id=$crt_id");
               
            if (count($aa) > 0)
               $crts_numero = $aa[0]["crts_numero"];
            else
               $crts_numero = "";
               
            $this->set("crts_numero", ltrim(rtrim($crts_numero)));
         }
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->LibroVenta->delete($id)) 
            $this->redirect("/libros_ventas");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function fechas($id=null) {
	      
	     $arr = $this->LibroVenta->findAll(null, null, "cami_patente");
	     
	     $this->set("camiones", $arr);
      }
   }

   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    $id = $row["id"];
		    $estado = $row["estado"];
		    
		    if ($estado=="I")
		       return "<td style=\"background:white\"><a href=\"".APP_HTTP."/libros_ventas/anula/$id\"><img src=\"".APP_HTTP."/app/img/delete.gif\">Anula</a></td>";
		    else
		       return "<td style=\"background:white\"></td>";
         }    
      }
   }