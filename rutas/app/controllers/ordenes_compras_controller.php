<?php
   class OrdenesComprasController extends AppController {
      var $name="OrdenesCompras";
      var $uses=array("OrdenCompra", "Institucion", "OrdenNacional");

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
         
         $sql = "select a.*, b.inst_razon_social ".
                "  from ordenes_compras a ".
                "      ,instituciones   b ".
                " where a.institucion_id=b.id ";
                
         //echo $sql."<br>";
         
         $arreglo = $this->OrdenCompra->findSql($sql . " order by ".$sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         //$arreglo = $this->OrdenCompra->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         $pagination = new pagination("/ordenes_compras/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->OrdenCompra->count(), $recsXPage);
         
         $this->assign("ordenes_compras", $arreglo);
         $this->assign('pagination', $pagination->links());
         
    
          $g = new MiGrid();
          
          $g->addField ("Id",                 "id"                );
          //$g->addField ("Instituci&oacute;n", "institucion_id"    );
          $g->addField ("Instituci&oacute;n", "inst_razon_social"    );
          $g->addField ("Orden de Compra",    "orco_orden_compra" );
          $g->addField ("Autom&oacute;vil",          "orco_auto",      array("align" => "center", 
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   ));
          $g->addField ("Escuela",            "orco_escuela",      array("align" => "center", 
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   ));                                                                             
          $g->addField ("Fecha",              "orco_fecha"        );
          $g->addField ("Neto",               "orco_neto",       array("format" => "money", "align" => "right"));
          $g->addField ("Iva",                "orco_iva",        array("format" => "money", "align" => "right"));
          $g->addField ("Total",              "orco_total",      array("format" => "money", "align" => "right"));
          //$g->addField ("Observaciones",      "orco_observaciones");
          $g->addField ("Bloqueo",            "orco_bloqueo",      array("align" => "center", 
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   ));
          $g->addField ("Estado",             "orco_estado",       array("align" => "center", 
                                                                   "trad"  => array("I"=>"Ingresado", "N" => "Nulo", "C" => "Cerrado")
                                                                   ));  
          $g->addField ("&nbsp", "comandos");          
                      
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
          
          //echo $g->show();
           
      }

      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->OrdenCompra->save($this->data))
               $this->redirect("/ordenes_compras");
         }
         if (empty($this->data)) {

            $this->data["OrdenCompra"]["orco_fecha"        ]=date("d/m/Y");
            $this->data["OrdenCompra"]["orco_neto"        ]=0;
            $this->data["OrdenCompra"]["orco_iva"         ]=0;
            $this->data["OrdenCompra"]["orco_total"        ]=0;
            $this->data["OrdenCompra"]["orco_bloqueo"      ]="N";
            $this->data["OrdenCompra"]["orco_estado"       ]="I";
         }
         
         $this->llenaListas();
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->OrdenCompra->save($this->data)) {
               $this->redirect("/ordenes_compras");
            }
         }
         if (empty($this->data)) {
            $this->data = $this->OrdenCompra->read(null, $id);
         }
         
         $this->llenaListas();
      }
      
      function llenaListas() {
	     $arr = $this->Institucion->findAll(null, null, "inst_razon_social");
	     $listado="|";
	     
	     foreach($arr as $r) {
		    $listado .= ",".$r["inst_razon_social"]."|".$r["id"];
	     }
	     
	     $this->set("instituciones", $listado);
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->OrdenCompra->delete($id)) 
            $this->redirect("/ordenes_compras");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function addOrder($idOrigen=null, $orna_orden_compra=null, $institucion_id=null, $order=1) {
         if (!empty($this->data)) {
	        
	        $orna_orden_compra = $_REQUEST["orna_orden_compra"];  
	        $order             = $_REQUEST["order"];  
	        $idOrigen          = $_REQUEST["idOrigen"];  
	        
	        $this->set("orna_orden_compra", $orna_orden_compra);
	        $this->set("order", $order);
	        $this->set("idOrigen", $idOrigen);
	         
            if ($this->OrdenCompra->save($this->data)) {
	           $orco_orden_compra = $this->data["OrdenCompra"]["orco_orden_compra"];
	           
	           if ($orco_orden_compra!=$orna_orden_compra) {
		          if ($idOrigen!="") {
			         $data = $this->OrdenNacional->read(null, $idOrigen);
			         
			         if ($order==1)
			            $data["OrdenNacional"]["orna_orden_compra"] = $orco_orden_compra;			           
			         elseif ($order==2)
			            $data["OrdenNacional"]["orna_orden_compra2"] = $orco_orden_compra;
			         else
			            $data["OrdenNacional"]["orna_orden_compra_auto"] = $orco_orden_compra;
			            
			         $this->OrdenNacional->save($data);
			          
		          }
		          else {
			         if ($order==1)
			            $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_orden_compra='$orna_orden_compra'"); 
			         elseif ($order==2)
			            $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_orden_compra2='$orna_orden_compra'"); 
			         else
			            $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_orden_compra_auto='$orna_orden_compra'"); 
			            
			         foreach($arr as $r) {
				        if ($order==1)
				           $r["orna_orden_compra"] = $orco_orden_compra;
				        elseif ($order==2)
				           $r["orna_orden_compra2"] = $orco_orden_compra;
				        else
				           $r["orna_orden_compra_auto"] = $orco_orden_compra;
				           
				        $data=array();   
				        $data["OrdenNacional"] = $r;
				        
				        $this->OrdenNacional->save($data);
				           
			         }
		          }
	           }
	           
               $this->redirect("/ordenes_nacionales/imprimirFacturas");
            }
         }
         
         if (empty($this->data)) {

	        $this->data["OrdenCompra"]["institucion_id"    ]=$institucion_id;
	        $this->data["OrdenCompra"]["orco_orden_compra" ]=$orna_orden_compra; 
            $this->data["OrdenCompra"]["orco_fecha"        ]=date("d/m/Y");
            $this->data["OrdenCompra"]["orco_auto"         ]="N";
            $this->data["OrdenCompra"]["orco_escuela"      ]="N";
            $this->data["OrdenCompra"]["orco_neto"         ]=0;
            $this->data["OrdenCompra"]["orco_iva"          ]=0;
            $this->data["OrdenCompra"]["orco_total"        ]=0;
            $this->data["OrdenCompra"]["orco_bloqueo"      ]="N";
            $this->data["OrdenCompra"]["orco_estado"       ]="I";
            
            $this->set("orna_orden_compra", $orna_orden_compra);
            $this->set("order", $order);
            $this->set("idOrigen", $idOrigen);
            
         }
         
         $this->llenaListas();
      }
   }

   class MiGrid extends Grid {
	  function showField($f, $row) {	     
	     $name    = $f["name"];
	     
	     if ($name!="comandos")
	        return parent::showField($f, $row);
	     else {
		    $id = $row["id"];
		    return "<td style=\"background:white\"><a href=\"".APP_HTTP."/ordenes_compras/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }    
      }
   }