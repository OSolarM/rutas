<?php
   class OrdenesNacionalesController extends AppController {
      var $name="OrdenesNacionales";
      var $uses=array("OrdenNacional", "Institucion", "Ciudad", "Grado", "Expedicion", "OrdenCompra", "Parametro", "Particular", "LibroVenta");

       var $validate = array(
                          "orna_fecha"            => "required|type=date",
                          "orna_m3"               => "required|type=number",
                          "orna_apellidos"        => "required",
                          "orna_nombres"          => "required",
                          "orna_rut"              => "required",
                          "orna_email"            => "type=mail",
                          "orna_deposito"         => "type=number",
                          "orna_monto_dep"        => "type=number",
                          "orna_tipo_em"          => "required",
                          "orna_auto"             => "required",
                          "orna_origen"           => "required",
                          "orna_destino"          => "required",
                          "orna_repo_fecha"       => "required|type=date",
                          "particular_id"         => "required",
                          "orna_terceros"         => "required",
                          //"orna_repo_direccion"   => "required",
                          //"orna_repo_comuna"      => "required",
                          "orna_fecha_llegada"    => "type=date",
                          //"orna_direc_despacho"   => "required",
                          //"orna_comuna_despacho"  => "required",
                          "orna_valor_guia"  => "required|type=number",
                          "orna_iva"         => "required|type=number",
                          "orna_total"       => "required|type=number",
                    );

                    
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
         
         $arreglo = $this->OrdenNacional->findAll("institucion_id=4", null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);
         
         for ($i=0; $i < count($arreglo); $i++) {
	        $orna_cerrar     = $arreglo[$i]["orna_cerrar"];
	        $orna_nula       = $arreglo[$i]["orna_nula"];
	        $orna_no_guia    = $arreglo[$i]["orna_no_guia"];
	        $orna_no_factura = $arreglo[$i]["orna_no_factura"];
	        
	        if ($orna_nula=="S")
	           $estado="Nula";
	        else if ($orna_cerrar!="S")
	           $estado="Pendiente";
	        else
	           $estado="Cerrada";
	           
	        $arreglo[$i]["estado"] = $estado;
         }
         
         $pagination = new pagination("/ordenes_nacionales/index", $page, ":".$sortKey.":".$orderKey);
         
         $arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         //$this->assign("camiones", $arreglo);
         $this->assign('pagination', $pagination->links());
         
    
          $g = new MiGrid();
          
          $g->addField("N&uacute;mero",     "id", array("align" => "right"));
          $g->addField("Fecha",             "orna_fecha");
          $g->addField("Mts3",              "orna_m3", array("align" => "right"));
          $g->addField("Apellidos",         "orna_apellidos");
          $g->addField("Nombres",           "orna_nombres");
          $g->addField("Rut",               "orna_rut");
          $g->addField("Gu&iacute;a",       "orna_no_guia"   , array("align" => "right"));
          $g->addField("Factura",           "orna_no_factura", array("align" => "right"));
          $g->addField("Estado",            "estado", array("sortColumn" => false));
          $g->addField("&nbsp;", "comandos");
          
          $g->setData($arreglo);
          $this->set("grilla", $g->show());
          
          $this->llena_listas();
           
      }

      function add() {
         $this->OrdenNacional->validate = $this->validate;

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->data["OrdenNacional"]["orna_auto"]=="S") {
               $this->OrdenNacional->validate["orna_patente"]="required";
               $this->OrdenNacional->validate["orna_marca"  ]="required";
               $this->OrdenNacional->validate["orna_modelo" ]="required";
            }

            $this->data["OrdenNacional"]["orna_cerrar"] = "N";
            $this->data["OrdenNacional"]["orna_nula"] = "N";
            $this->data["OrdenNacional"]["institucion_id"] = "4";
            
            $orna_terceros = $this->data["OrdenNacional"]["orna_terceros"];
            
            if ($orna_terceros=="S") {
	             unset($this->OrdenNacional->validate["orna_m3"       ]);
                 unset($this->OrdenNacional->validate["orna_apellidos"]);
                 unset($this->OrdenNacional->validate["orna_nombres"  ]);
                 unset($this->OrdenNacional->validate["orna_rut"      ]);
            }
            
            if ($this->OrdenNacional->save($this->data))
               $this->redirect("/ordenes_nacionales");
         }

         if (empty($this->data)) {
            $this->data["OrdenNacional"]["institucion_id"] = "4";
            $this->data["OrdenNacional"]["orna_fecha"] = date("d/m/Y");
            $this->data["OrdenNacional"]["orna_monto_dep"] = "0";
            $this->data["OrdenNacional"]["orna_estado"] = "I";
            $this->data["OrdenNacional"]["orna_terceros"] = "N";

         }

            //$r = $this->Institucion->findAll(null, null, "order by inst_razon_social");

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
            
            $this->llena_listas();
      }
      
      function llena_listas() {
	     $arr = $this->Particular->findAll(null, null, "razon");
	     $lista ="|";
	     
	     foreach($arr as $r) {
		    $lista .= ",".$r["razon"]." ".$r["rut"]."|".$r["id"];
	     }
		 
		 //echo $lista."<hr/>";
	     
	     $this->set("clientes", $lista);
	     
	     $r = $this->Institucion->findAll(null, null, "id");

         $lista = "|";
         foreach($r as $v) {
             if ($lista!="") $lista .= ",";

             $lista .= $v["inst_razon_social"]."|".$v["id"];
         }	
         
         $this->set("instituciones", $lista);     	     
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->OrdenNacional->validate = $this->validate;

         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->data["OrdenNacional"]["orna_auto"]=="S") {
               $this->OrdenNacional->validate["orna_patente"]="required";
               $this->OrdenNacional->validate["orna_marca"  ]="required";
               $this->OrdenNacional->validate["orna_modelo" ]="required";
            }

            $this->data["OrdenNacional"]["orna_cerrar"] = "S";
            
            $orna_terceros = $this->data["OrdenNacional"]["orna_terceros"];
            
            if ($orna_terceros=="S") {
	             unset($this->OrdenNacional->validate["orna_m3"       ]);
                 unset($this->OrdenNacional->validate["orna_apellidos"]);
                 unset($this->OrdenNacional->validate["orna_nombres"  ]);
                 unset($this->OrdenNacional->validate["orna_rut"      ]);
            }
            
            if ($this->OrdenNacional->save($this->data)) {
               $this->redirect("/ordenes_nacionales");
            }
            //else
            //   print_r($this->OrdenNacional->errorList);
         }
         
         if (empty($this->data)) {
            $this->data = $this->OrdenNacional->read(null, $id);
            
            if ($this->data["OrdenNacional"]["orna_cerrar"] == "S")
               $this->set("form_readonly", "true");
            
         }

         $r = $this->Ciudad->findAll(null, null, "ciud_nombre");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["ciud_nombre"]."|".$v["id"];
            }

            $this->set("origenes", $lista);
            $this->set("destinos", $lista);

         $this->llena_listas();
      }
      
      function show($id) {
	     $this->data = $this->OrdenNacional->read(null, $id);
	     
	     $this->llena_listas();
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->OrdenNacional->delete($id))
            $this->redirect("/ordenes_nacionales");
         else
            $this->redirect("/errores/idNotFound");
      }

      function listado_inspector() {
          $arreglo = $this->OrdenNacional->findAll("orna_m3=0", null, "institucion_id, orna_apellidos, orna_nombres");

          for ($i=0; $i < count($arreglo); $i++) {
             if ($this->Ciudad->findByPk($arreglo[$i]["orna_origen"]))
                $arreglo[$i]["ciudad"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
             else
                $arreglo[$i]["ciudad"] = "";

             if ($this->Institucion->findByPk($arreglo[$i]["institucion_id"]))
                $arreglo[$i]["institucion"] = $this->Institucion->data["Institucion"]["inst_razon_social"];
             else
                $arreglo[$i]["institucion"] = "";
          }

          $this->set("listado", $arreglo);

      }

      function impresionGuias() {
	     	      
         $this->OrdenNacional->validate=array("institucion_id" => "type=integer",
                                              "orna_no_guia"   => "required|type=integer|userDefined=chkNoGuia",
                                              "orna_orden_compra" => "userDefined=chkOrdenCompra",
                                        );

         $this->set("instituciones", $this->Institucion->getInstituciones());

         $arr = $this->OrdenNacional->findAll("orna_cerrar='S' and (orna_no_guia is null or orna_no_guia=0) and orna_nula<>'S' and orna_valor_guia > 0",
                                                           null,
                                                           "institucion_id, id"
                                                           );

         $orna_no_guia=$this->Parametro->proximaGuia();

         for ($i=0; $i < count($arr); $i++)
            $arr[$i]["orna_no_guia"] = $orna_no_guia++;

         $this->set("guias", $arr);

         if (!empty($this->data)) {
            $lista = isset($_REQUEST["lista"])?$_REQUEST["lista"]:array();

            $filtro            = $_REQUEST["filtro"           ];
            $institucion_id    = $_REQUEST["institucion_id"   ];
            $orna_orden_compra = $_REQUEST["orna_orden_compra"];
            $grad_descripcion  = $_REQUEST["grad_descripcion" ];
            $orna_apellidos    = $_REQUEST["orna_apellidos"   ];
            $orna_nombres      = $_REQUEST["orna_nombres"     ];            
            $orna_no_guia      = $_REQUEST["orna_no_guia"     ]; 

            if ($filtro=="S") {
               $condicion="orna_cerrar='S' and (orna_no_guia is null or orna_no_guia=0) and orna_nula<>'S'  and orna_estado='I'";
               
               if ($institucion_id!="") $condicion .=" and institucion_id=$institucion_id";
               
               if ($institucion_id!=4 && $grad_descripcion!="") {
                  $r = $this->Grado->findAll("id is not null and grad_descripcion like '".strtoupper($grad_descripcion)."%'");
                  
                  if (count($r) > 0) {
                     $lista="";
                     foreach($r as $s) {
                        if ($lista!="") $lista .=",";
               
                        $lista .= $s["id"];
                     }
               
                     $condicion .=" and orna_grado in ($lista)";
                  }
                  else {
                     $orna_grado=-1; //No se encontr?;
               
                     $condicion .=" and orna_grado=$orna_grado";
               
                  }
               }
               
               if ($orna_orden_compra!="") $condicion .= " and orna_orden_compra like '".strtoupper($orna_orden_compra)."%'";
               
               if ($orna_apellidos!="") $condicion .= " and orna_apellidos like '".strtoupper($orna_apellidos)."%'";
               
               if ($orna_nombres!="") $condicion .= " and orna_nombres like '".strtoupper($orna_nombres)."%'";
               
               //echo $condicion."<hr>";
               $arr = $this->OrdenNacional->findAll($condicion, null, "institucion_id, id");
               
               $this->set("guias", $arr);

            }
            else {
               
               //print_r($lista);
                              
               for ($i=0; $i < count($lista); $i++) {
                  $id = $lista[$i];
               
                  $data = $this->OrdenNacional->read(null, $id);
                  
                  $orna_tipo_em=$data["OrdenNacional"]["orna_tipo_em"];
               
                  $orna_auto = $data["OrdenNacional"]["orna_auto"];
                  
                  if ($orna_auto=="S") {
	                 //$orna_no_guia = $this->Parametro->proximaGuia();
                     $this->OrdenNacional->imprimir_guia_auto($id, $orna_no_guia, $this->Institucion, $this->Ciudad, $this->Grado, $this->Particular);
                     //$this->Parametro->actualizaGuia();             
                     $orna_no_guia++;        
                  }
               
                  if ($orna_tipo_em!="A") {
                     //$orna_no_guia = $this->Parametro->proximaGuia();
                     $this->OrdenNacional->imprimir_guia($id, $orna_no_guia, $this->Institucion, $this->Ciudad, $this->Grado, $this->Particular);
                     //$this->Parametro->actualizaGuia();
                     $orna_no_guia++;
                  }
               }
               
               $this->redirect("/ordenes_nacionales/impresionGuias");
               return;

            }
         }

         if (empty($this->data)) {
               $this->data["OrdenNacional"]["orna_no_guia"] = "";
         }
      }

      function impresionFacturas() {

         $this->OrdenNacional->validate=array("institucion_id" => "required",
                                              "orna_no_factura"   => "required|type=integer|userDefined=chkNoFactura",
                                              "orna_orden_compra" => "userDefined=chkOrdenCompra",
                                        );

         $this->set("instituciones", $this->Institucion->getInstituciones());

         if (!empty($this->data)) {
            $this->data["OrdenNacional"]["orna_no_factura"] = $this->Parametro->proximaFactura();
            $this->OrdenNacional->setData($this->data);

            if ($this->OrdenNacional->validates()) {
               $institucion_id=$this->data["OrdenNacional"]["institucion_id"];
               $orna_orden_compra=$this->data["OrdenNacional"]["orna_orden_compra"];
               $orna_no_factura=$this->data["OrdenNacional"]["orna_no_factura"];

               $condicion = "institucion_id=$institucion_id and orna_no_factura is null and orna_cerrar='S' and orna_nula<>'S'  and orna_estado='I'";

               if ($orna_orden_compra!="")
                  $condicion .=" and orna_orden_compra='$orna_orden_compra'";

               //echo $condicion."<hr/>";

               $arr = $this->OrdenNacional->findAll($condicion, null, "id");

               //print_r($arr);

               return;

               foreach($arr as $r) {
                  $id = $r["id"];

                  $orna_no_factura = $this->Parametro->proximaFactura();

                  $this->OrdenNacional->imprimir_factura($id, $orna_no_factura, $this->Institucion, $this->Ciudad, $this->Grado, $this->OrdenCompra);                                                                                          

                  $this->Parametro->actualizaFactura();
               }

            }
         }

         if (empty($this->data)) {
            $this->data["OrdenNacional"]["orna_no_factura"] = $this->Parametro->proximaFactura();
         }


      }

      function indicadores() {
         $arr = $this->Institucion->findAll(null, null, "id");

         $inst = array();
         $sopendientes=0;
         $socerradas=0;
         $sosinoc=0;
         $sgpend=0;
         $sgpend_fact=0;

         foreach($arr as $r) {
            $opendientes=0;
            $ocerradas=0;
            $osinoc=0;
            $gpend=0;
            $gpend_fact=0;

            $id = $r["id"];

            $ss = $this->OrdenNacional->findAll("institucion_id=$id and orna_estado='I' and (orna_cerrar is null or orna_cerrar<>'S') and orna_nula<>'S'");
            foreach($ss as $s)
               $opendientes++;

            $ss = $this->OrdenNacional->findAll("institucion_id=$id and orna_estado='I' and orna_cerrar='S' and orna_no_guia is null  and orna_nula<>'S'");
            foreach($ss as $s)
               $ocerradas++;

            if ($id==1) {
               $arreglo = $this->OrdenNacional->findAll("institucion_id=$id and orna_estado='I' and orna_cerrar='S' and orna_nula<>'S' and orna_no_guia is null");

               foreach($arreglo as $r2) {
                  $orna_cant_ordenes      = $r2["orna_cant_ordenes"];
                  $orna_orden_flete1      = $r2["orna_orden_flete1"];
                  $orna_orden_compra      = $r2["orna_orden_compra"];
                  $orna_orden_flete2      = $r2["orna_orden_flete2"];
                  $orna_orden_compra2     = $r2["orna_orden_compra2"];
                  $orna_auto              = $r2["orna_auto"];
                  $orna_orden_flete_auto  = $r2["orna_orden_flete_auto"];
                  $orna_orden_compra_auto = $r2["orna_orden_compra_auto"];

                  $errorList=array();

                  if (trim($orna_orden_flete1)=="") $errorList["orna_orden_flete1"] = "Debe ingresar un valor en este campo!";
                  if (trim($orna_orden_compra)=="") $errorList["orna_orden_compra"] = "Debe ingresar un valor en este campo!";

                  if ($orna_cant_ordenes==2) {
                     if (trim($orna_orden_flete2 )=="")  $errorList["orna_orden_flete2"] = "Debe ingresar un valor en este campo!";
                     if (trim($orna_orden_compra2)=="") $errorList["orna_orden_compra2"] = "Debe ingresar un valor en este campo!";
                  }

                  if ($orna_auto=="S") {
                     if (trim($orna_orden_flete_auto )=="") $errorList["orna_orden_flete_auto"]  = "Debe ingresar un valor en este campo!";
                     if (trim($orna_orden_compra_auto)=="") $errorList["orna_orden_compra_auto"] = "Debe ingresar un valor en este campo!";
                  }

                  //print_r($errorList);

                  if (count($errorList)>0)
                     $osinoc++;
               }

            }

            $ss = $this->OrdenNacional->findAll("institucion_id=$id and orna_estado='I' and orna_cerrar='S' and orna_no_guia is not null and orna_no_factura is null  and orna_nula<>'S'");
            foreach($ss as $s)
               $gpend++;

            $ss = $this->OrdenNacional->findAll("institucion_id=$id and orna_estado='I' and orna_cerrar='S' and orna_no_guia is not null and orna_no_factura is not null and orna_nula<>'S'");
            foreach($ss as $s)
               $gpend_fact++;

            $inst[] = array(
                         "institucion"  => $r["inst_razon_social"],
                         "opendientes"  => $opendientes,
                         "ocerradas"    => $ocerradas,
                         "osinoc"       => $osinoc,
                         "gpend"        => $gpend,
                         "gpend_fact"   => $gpend_fact,

                      );

            $sopendientes +=$opendientes ;
            $socerradas   +=$ocerradas   ;
            $sosinoc      +=$osinoc      ;
            $sgpend       +=$gpend       ;
            $sgpend_fact  +=$gpend_fact  ;
         }

         $this->set("indicadores", $inst);

         $this->set("sopendientes", $sopendientes);
         $this->set("socerradas"  , $socerradas  );
         $this->set("sosinoc"     , $sosinoc     );
         $this->set("sgpend"      , $sgpend      );
         $this->set("sgpend_fact" , $sgpend_fact );

         $expe_abierta=0;
         $expe_cerrada=0;

         $ss = $this->Expedicion->findAll("expe_bloqueo='N' and expe_cerrado='N'");
            foreach($ss as $s)
               $expe_abierta++;

         $ss = $this->Expedicion->findAll("expe_bloqueo='N' and expe_cerrado='S'");
         foreach($ss as $s)
            $expe_cerrada++;

         $this->set("expe_abierta", $expe_abierta);
         $this->set("expe_cerrada", $expe_cerrada);
      }

      function anulacionGuia() {
         $this->set("instituciones", $this->Institucion->getInstituciones());

         $this->OrdenNacional->validate=array("institucion_id" => "required",
                                              "orna_no_guia"   => "required|type=integer"
                                             );
         $this->set("error_guia", "");

         if (!empty($this->data)) {
            //echo $this->data["OrdenNacional"]["institucion_id"]."<br>";
            //echo $this->data["OrdenNacional"]["orna_no_guia"]."<hr>";
            $this->OrdenNacional->setData($this->data);
            if ($this->OrdenNacional->validates()) {

               $institucion_id=$this->data["OrdenNacional"]["institucion_id"];
               $orna_no_guia  =$this->data["OrdenNacional"]["orna_no_guia"];

               //echo "institucion_id=$institucion_id and orna_no_guia=$orna_no_guia<hr>";

               $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_no_guia=$orna_no_guia");
               
               foreach($arr as $r) {
	              $miId = $r["id"];
	              
	              $data = $this->OrdenNacional->read(0, $miId);
	              
	              $data["OrdenNacional"]["orna_no_guia"]="";
	              
	              $this->OrdenNacional->validate=array();
	              $this->OrdenNacional->save($data);
	              
               }
            }

            //print_r($this->OrdenNacional->errorList);
         }

         if (empty($this->data)) {
            $this->data["OrdenNacional"]["orna_no_guia"] = 0;
         }
      }

      function anulacionOc() {
         $this->set("instituciones", $this->Institucion->getInstituciones());

         $this->OrdenNacional->validate=array("institucion_id" => "required",
                                              "orna_orden_compra"   => "required"
                                             );

         $this->set("error_orden", "");

         if (!empty($this->data)) {
            $this->OrdenNacional->setData($this->data);
            if ($this->OrdenNacional->validates()) {

               $institucion_id=$this->data["OrdenNacional"]["institucion_id"];
               $orna_orden_compra=$this->data["OrdenNacional"]["orna_orden_compra"];

               $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_orden_compra=$orna_orden_compra");

               if (count($arr)==0) {
                   $this->set("error_orden", "Orden de Compra no encontrada!!");
                   $this->OrdenNacional->errorList["orna_orden_compra"] ="Orden de Compra no encontrada!!";
               }
               else {
                  $id = $this->data["OrdenNacional"]["id"];

                  //Proceso de anulaci?n


                  $this->redirect("/ordenes_nacionales/anulacionGuia");
               }
            }

            //print_r($this->OrdenNacional->errorList);
         }

         if (empty($this->data)) {
         }
      }

      function listadoGuias() {
         $orna_no_guia = $this->Parametro->proximaGuia();
         $this->OrdenNacional->listadoGuias($orna_no_guia);
      }

      function imprimir_una_guia($id, $orna_no_guia) {
         $this->layout="listadoGuias";

         $this->OrdenNacional->imprimir_guia($id, $orna_no_guia, $this->Institucion, $this->Ciudad, $this->Grado);

         $this->Parametro->actualizaGuia();

      }

      function imprimirFacturas() {
	     $this->set("no_factura", $this->Parametro->proximaFactura());
          
         if (!empty($this->data)) {
            $lista = $_REQUEST["lista"];
            
            print_r($lista);
         }

         //$this->OrdenNacional->imprimir_factura("", 489, 888, $this->Institucion, $this->Ciudad, $this->Grado, $this->OrdenNacional);

         //echo "institucion_id=1 and (orna_no_guia is not null or orna_no_guia>0) and (orna_no_factura is null or orna_no_factura=0) and orna_nula<>'S'";
         //"orna_cerrar='S' and orna_no_guia > 0 and (orna_no_factura is null or orna_no_factura=0) and orna_nula<>'S' and orna_estado='I' and orna_valor_guia >= 0"
         $arr = $this->OrdenNacional->findAll("orna_cerrar='S' and orna_no_guia > 0 and (orna_no_factura is null or orna_no_factura=0) and orna_nula<>'S' and orna_estado='I'", null, "institucion_id, id");

         
         
         //print_r($arr);
         
         $sNeto=0;
         $sIva=0;
         $sTotal=0;
         for ($i=0; $i < count($arr); $i++) {
	        $orna_iva   = isset($arr[$i]["orna_iva"])?$arr[$i]["orna_iva"]:null;
	        $orna_total = isset($arr[$i]["orna_total"])?$arr[$i]["orna_total"]:null;
	        
	        
	        if ($orna_iva==null || $orna_iva=="") {
		       $orna_valor_guia = isset($arr[$i]["orna_valor_guia"])?$arr[$i]["orna_valor_guia"]:0;
		       
		       if ($orna_valor_guia=="") $orna_valor_guia=0.0;
		       
		       $arr[$i]["orna_valor_guia"] = $orna_valor_guia;
		       
		       $orna_iva   = round($orna_valor_guia*0.19, 0);
		       $orna_total = $arr[$i]["orna_valor_guia"] + $orna_iva;
		       
		       $arr[$i]["orna_iva"]=$orna_iva;
		       $arr[$i]["orna_total"]=$orna_total;
		       
	        }
	        if (!isset($arr[$i]["orna_valor_guia"])) $arr[$i]["orna_valor_guia"] = 0;
	        if (!isset($arr[$i]["orna_iva"]))        $arr[$i]["orna_iva"] = 0;
	        if (!isset($arr[$i]["orna_total"]))      $arr[$i]["orna_total"] = 0;
	        
	        //echo $arr[$i]["orna_valor_guia"]."-";
	        //echo $arr[$i]["orna_iva"]."-";
	        //echo $arr[$i]["orna_total"]."<br/>";
	         
	        $sNeto += $arr[$i]["orna_valor_guia"];
	        $sIva  += $arr[$i]["orna_iva"];
	        $sTotal+= $arr[$i]["orna_total"];
         }
         
         //print_r($arr);
         
         $this->set("facturas", $arr);
         
         $this->set("sNeto",  $sNeto);
         $this->set("sIva",   $sIva);
         $this->set("sTotal", $sTotal);
      }
      
      function prnFact($id=null, $institucion_id=null, $orna_orden_compra=null) {
	      
	        
	     $this->OrdenNacional->validate=array();
	     	              
         if (!empty($this->data)) {
            $no_factura        = $_REQUEST["no_factura"       ];
            $fecha             = $_REQUEST["fecha"            ];
            $inst_razon_social = $_REQUEST["inst_razon_social"];
            $inst_rut          = $_REQUEST["inst_rut"         ];
            $direccion         = strtoupper($_REQUEST["direccion"]);
            $concepto          = strtoupper($_REQUEST["concepto" ]);
            $neto              = $_REQUEST["neto"             ];
            $iva               = $_REQUEST["iva"              ];
            $total             = $_REQUEST["total"            ];
            $id                = $_REQUEST["id"];
            $orna_orden_compra = $_REQUEST["orna_orden_compra"];
            $origen            = $_REQUEST["origen"];
            $destino           = $_REQUEST["destino"];
            $institucion_id    = $_REQUEST["institucion_id"];
            
            //echo "$orna_orden_compra, $id, $no_factura<hr>";
            
            //echo $concepto;
            
            $d = $this->OrdenNacional->read(null, $id);
            
            $d["OrdenNacional"]["orna_no_factura"]= $no_factura;
            
            $this->OrdenNacional->save($d);
            
            $this->Parametro->actualizaFactura();
            
            $this->OrdenNacional->imprimir_factura($orna_orden_compra, $id, $no_factura, 
                                                   $this->Institucion, $this->Ciudad, $this->Grado, $this->OrdenNacional, $concepto, $direccion, $inst_razon_social, $inst_rut, $neto, $iva, $total);
              
            $lv["LibroVenta"]["id"		  ] = "";
	        $lv["LibroVenta"]["tipo_docto"] = "N";
	        $lv["LibroVenta"]["crt_id"	  ] = "";
	        $lv["LibroVenta"]["fecha"	  ] = $fecha;
	        $lv["LibroVenta"]["rut"		  ] = $inst_rut;
	        $lv["LibroVenta"]["razon"	  ] = $inst_razon_social;
	        $lv["LibroVenta"]["docto"	  ] = "FA";
	        $lv["LibroVenta"]["numero"	  ] = $no_factura;
	        $lv["LibroVenta"]["emision"	  ] = $fecha;
	        $lv["LibroVenta"]["vencto"	  ] = $fecha;
	        $lv["LibroVenta"]["neto"	  ] = $neto;
	        $lv["LibroVenta"]["iva"		  ] = $iva;
	        $lv["LibroVenta"]["total"	  ] = $total;
	        $lv["LibroVenta"]["estado"    ] = "I";
	        
	        $this->LibroVenta->save($lv);                                     

            $this->redirect("/ordenes_nacionales/imprimirFacturas");                                                   
            
            return;


            
            $ss = file_get_contents(APP_PATH."/app/templates/ordenes_nacionales/factu.fto");    
            
            $sTotal = strtoupper(num2letras($total, false, false)).".-";
            $sTotal2="";
            
            $lon = strlen("monto_pal--------------------------------------") + 1;
            
            if (strlen($sTotal) > $lon) {
               $i = $lon-1;
               
               while (substr($sTotal, $i, 1)!=" ") {
                  echo substr($sTotal, 0, $i)."<br/>";
                  $i--;
               }
               
               $sTotal2 = ltrim(substr($sTotal, $i));
               $sTotal  = ltrim(substr($sTotal, 0, $i));
            }
            
            //$concepto = nl2br($concepto);
            
            $concepto = explode("\n", $concepto);
            
            print_r($concepto);
            
            
                                
            $cont = array();
            $cont["no_factu"                                       ] = $no_factura;
            $cont["dd"                                             ] = substr($fecha,0,2);;
            $cont["mes------"                                      ] = strtoupper(mesPal(substr($fecha, 3, 2)*1.0));
            $cont["agno"                                           ] = substr($fecha, 8, 2);
            $cont["inst_razon_social"                              ] = $inst_razon_social;
            $cont["inst_direccion"                                 ] = $direccion;
            $cont["inst_rut"                                       ] = $inst_rut;
            $cont["origen"                                         ] = "";
            $cont["destino"                                        ] = $origen;
            $cont["orna_no_guia"                                   ] = $destino;
            
            $cont["texto0"] = "";
            $cont["texto1"] = "";
            $cont["texto2"] = "";
            $cont["texto3"] = "";
            $cont["texto4"] = "";
            $cont["texto5"] = "";
            $cont["texto6"] = "";
            $cont["texto7"] = "";
            $cont["texto8"] = "";
            $cont["texto9"] = "";
            //$cont["texto10"] = "";
            //$cont["texto11"] = "";
            //$cont["texto12"] = "";
            //$cont["texto13"] = "";
            //$cont["texto14"] = "";
            //$cont["texto15"] = "";
            //$cont["texto16"] = "";
            //$cont["texto17"] = "";          
                                    
       
            for ($i=0; $i < count($concepto); $i++) {
	           $clave = "texto".$i;
	           //echo $clave."<hr>";
	           
               $cont[$clave] = $concepto[$i];
            }
               
            
            
            $cont["monto_neto"                                     ] = "";
            $cont["neto"                                           ] = str_pad(number_format($neto,  0, ",", "."), 12, ' ', STR_PAD_LEFT);
            $cont["iva"                                            ] = str_pad(number_format($iva,   0, ",", "."), 12, ' ', STR_PAD_LEFT);
            $cont["total"                                          ] = str_pad(number_format($total, 0, ",", "."), 12, ' ', STR_PAD_LEFT);
            $cont["monto_pal--------------------------------------"] = $sTotal;
            $cont["monto_pal2-------------------------------------"] = $sTotal2;
            
            //print_r($cont); return;
            
            
// // //    //          echo $ss;
            
               
               foreach($cont as $c => $value) {
                  $cc = "@".$c;
                  
                  echo "$c   $value<hr>";
                  
                  if (strlen($cc) > strlen($value)) 
                     $largo = strlen($c);
                  else
                     $largo = strlen($value);
                     
                  $valor = str_pad($value, $largo, ' ', STR_PAD_RIGHT);
                  
                  $ss = str_replace('@'.$c, $valor, $ss);
                  
               }
               
               
               
               
               
               $fd = fopen(APP_PATH."/app/templates_c/$no_factura".".fac", "w");
               fputs($fd, $ss);
               fclose($fd);
               
               //Actualizar Ordenes Nacionales
               
               $this->Parametro->actualizaFactura();
               
               if ($id!="") {
	              $data = $this->OrdenNacional->read(null, $id);
	              $data["OrdenNacional"]["orna_no_factura"] = $no_factura;
	              $this->OrdenNacional->save($data);
               }
               else {
	              $arr = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orna_orden_compra='$orna_orden_compra'");
	              
	              //echo "institucion_id=$institucion_id and orna_orden_compra='$orna_orden_compra'<hr>";
	              //echo count($arr)."<hr>";
	              
	              foreach($arr as $r) {
		             $data["OrdenNacional"]= $r;
		             $data["OrdenNacional"]["orna_no_factura"] = $no_factura;
		             
		             //print_r($data);
		             
		             $this->OrdenNacional->save($data);	  
		                        
                  }
               }
               
            
               $this->redirect("/ordenes_nacionales/imprimirFacturas");
               
               return;
               
         }
         
         if (empty($this->data)) {	        
	        $this->set("id", $id);
	        $this->set("institucion_id", $institucion_id);
	        $this->set("orna_orden_compra", $orna_orden_compra);
	        
	        $d = $this->OrdenNacional->read(0, $id);
	        
	        $orna_terceros = $d["OrdenNacional"]["orna_terceros"];
	        $orna_no_guia  = $d["OrdenNacional"]["orna_no_guia"];
	        $orna_tipo_em  = $d["OrdenNacional"]["orna_tipo_em"];  
	        $orna_m3       = $d["OrdenNacional"]["orna_m3"];  
	         $desde = $d["OrdenNacional"]["ciud_nombre"];
	           $hasta = $d["OrdenNacional"]["ciud_nombre_a"];
	           $nombre= $d["OrdenNacional"]["orna_nombres"]." ".
	                    $d["OrdenNacional"]["orna_apellidos"];
	                 
	        switch($orna_tipo_em) {
		       case "M": $orna_tipo_em = "MENAJE"; break;
		       case "E": $orna_tipo_em = "ENSERES PERSONALES"; break;
		       case "A": $orna_tipo_em = "SOLO AUTOMOVIL"; break;
		       case "C": $orna_tipo_em = "CAJAS"; break;
		       default : $orna_tipo_em = "******************"; break;
	        }
	            
	        
	           $concepto = "TRASLADO DE $orna_tipo_em \n\n".
	                       "DE $nombre \n\n".
	                       "DESDE $desde HASTA $hasta\n\n".
	                       "($orna_m3 MTS.CUBICOS)";

	        $this->set("concepto", $concepto);
	        
	        $particular_id = $d["OrdenNacional"]["particular_id"];
	        if ($particular_id!=null) {  
	           $d = $this->Particular->read(null, $particular_id);
	           
	           $this->data["OrdenNacional"]["inst_razon_social"]= $d["Particular"]["razon"];
	           $this->data["OrdenNacional"]["direccion"]               = $d["Particular"]["direccion"]." ".
	                                                                     $d["Particular"]["comuna"]." ".
	                                                                     $d["Particular"]["ciudad"];
               $this->data["OrdenNacional"]["inst_rut"]                     = $d["Particular"]["rut"];	   
           }
           else {
           }
	         
            $sNeto=0; $sIva=0; $sTotal=0;
            
            if ($id!="") {
               $data = $this->OrdenNacional->read(null, $id);
               $orna_orden_compra2     = $data["OrdenNacional"]["orna_orden_compra2"];
               $orna_orden_compra_auto = $data["OrdenNacional"]["orna_orden_compra_auto"];
               
               $this->set("origen",  $data["OrdenNacional"]["ciud_nombre"]);
               $this->set("destino", $data["OrdenNacional"]["ciud_nombre_a"]);
               
               if ($institucion_id==2 || $institucion_id==4) {
                  $neto = $data["OrdenNacional"]["orna_valor_guia"];
                  $iva  = round($neto*0.19, 0);
                  $total= $neto + $iva;
                  
                  $sNeto  += $neto;
                  $sIva   += $iva;
                  $sTotal += $total;
                  
                  
                  
               }
               else if ($orna_orden_compra != "") {
                  $data2 = $this->OrdenCompra->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra'");
                  
                  //echo "institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra'<hr>";
                  
                  //print_r($data2);
                  if (count($data2) > 0) {
                     $sNeto  += $data2[0]["orco_neto"];
                     $sIva   += $data2[0]["orco_iva"];
                     $sTotal += $data2[0]["orco_total"]; 
                     
                     if ($orna_orden_compra2!="") {
                        $data2 = $this->OrdenCompra->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra2'");
                        
                        $sNeto  += $data2[0]["orco_neto"];
                        $sIva   += $data2[0]["orco_iva"];
                        $sTotal += $data2[0]["orco_total"]; 
                     }
                     
                     if ($orna_orden_compra_auto!="") {
                        $data2 = $this->OrdenCompra->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra_auto'");
                        
                        $sNeto  += $data2[0]["orco_neto"];
                        $sIva   += $data2[0]["orco_iva"];
                        $sTotal += $data2[0]["orco_total"]; 
                     }
                  }               
               }
            }
            else {
               $data2 = $this->OrdenCompra->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra'");              
                  
               $sNeto  += $data2[0]["orco_neto"];
               $sIva   += $data2[0]["orco_iva"];
               $sTotal += $data2[0]["orco_total"]; 
               
               $orna_orden_compra2 = "";
               $orna_orden_compra_auto = "";
               
               if ($orna_orden_compra2!="") {
                  $data2 = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra2'");
                  
                  $sNeto  += $data2[0]["orco_neto"];
                  $sIva   += $data2[0]["orco_iva"];
                  $sTotal += $data2[0]["orco_total"]; 
               }
               
               if ($orna_orden_compra_auto!="") {
                  $data2 = $this->OrdenNacional->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra_auto'");
                  
                  $sNeto  += $data2[0]["orco_neto"];
                  $sIva   += $data2[0]["orco_iva"];
                  $sTotal += $data2[0]["orco_total"]; 
               }
               
               $d  = $this->Institucion->read(null, $institucion_id);                          
               $data["OrdenNacional"]["inst_razon_social"] = $d["Institucion"]["inst_razon_social"];                   
               $data["OrdenNacional"]["inst_rut"]          = $d["Institucion"]["inst_rut"];                
            }
            
            $data["OrdenNacional"]["neto"]  = $sNeto;    
            $data["OrdenNacional"]["iva"]   = $sIva;
            $data["OrdenNacional"]["total"] = $sTotal;
            
            $this->data = $data;
            
            $this->set("no_factura", $this->Parametro->proximaFactura());
            $this->set("fecha",      date("d/m/Y"));
            
            
            $monto = strtoupper(num2letras($sTotal, false, false)).".-";
            
            $this->set("monto", $monto);
            
         
            $institucion_id=$this->data["OrdenNacional"]["institucion_id"];
            
            if ($institucion_id==4) {
	           $d = $this->OrdenNacional->read(null, $id);
	           $desde = $d["OrdenNacional"]["ciud_nombre"];
	           $hasta = $d["OrdenNacional"]["ciud_nombre_a"];
	           $nombre= $d["OrdenNacional"]["orna_nombres"]." ".
	                    $d["OrdenNacional"]["orna_apellidos"];
	                    
	           $orna_terceros = $d["OrdenNacional"]["orna_terceros"];
	           $orna_no_guia  = $d["OrdenNacional"]["orna_no_guia"];
	           $orna_tipo_em = $d["OrdenNacional"]["orna_tipo_em"];  
	           $orna_m3      = $d["OrdenNacional"]["orna_m3"];  
	                    
	           switch($orna_tipo_em) {
		          case "M": $orna_tipo_em = "MENAJE"; break;
		          case "E": $orna_tipo_em = "ENSERES PERSONALES"; break;
		          case "A": $orna_tipo_em = "SOLO AUTOMOVIL"; break;
		          case "C": $orna_tipo_em = "CAJAS"; break;
		          default : $orna_tipo_em = "******************"; break;
	           }
	               
	           
	          	           
	           //echo "$desde $hasta $nombre $tipo<hr>";     
	           
	           if ($orna_terceros=="S") {
		          $concepto = "SERVICIO DE FLETE SEGUN GUIA $orna_no_guia\n\n".
		                      "DESDE $desde HASTA $hasta\n\n".
		                      "($orna_m3 METROS CUBICOS)";
	           }
	           else {
	           
	              $concepto = "TRASLADO DE $orna_tipo_em \n\n".
	                       "DE $nombre \n\n".
	                       "DESDE $desde HASTA $hasta\n\n".
	                       "($orna_m3 METROS CUBICOS)";
               }
	                       
	           //echo nl2br($concepto);
	                       
	           $this->set("concepto", $concepto);
	           
	           $particular_id = $d["OrdenNacional"]["particular_id"];
	           
	           $d = $this->Particular->read(null, $particular_id);
	           
	           $this->data["OrdenNacional"]["inst_razon_social"]= $d["Particular"]["razon"];
	           $this->data["OrdenNacional"]["direccion"]               = $d["Particular"]["direccion"]." ".
	                                                                     $d["Particular"]["comuna"]." ".
	                                                                     $d["Particular"]["ciudad"];
               $this->data["OrdenNacional"]["inst_rut"]                     = $d["Particular"]["rut"];	   
               
                                                                                       
            }   
            
            //print_r($this->data);
         }
      }
      
      function guias_pendientes($page=1) {
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
            $sortKey ="orna_no_guia";
            $orderKey="asc";
         }

         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);
         
         //echo "$sortKey, $orderKey<br>";

         $arreglo = $this->OrdenNacional->findAll("orna_no_guia is not null and orna_cerrar='S' and orna_nula<>'S' and orna_estado='I' and orna_no_guia not in (select dexp_guia from dexpediciones)", null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/ordenes_nacionales/guias_pendientes", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();
          
          $g->addField("Instituci&oacute;n", "inst_razon_social",array("sortColumn" => false));
          $g->addField("No.Gu&iacute;a", "orna_no_guia", array("align" => "right")    );
          $g->addField("Fecha Retiro", "orna_repo_fecha", array("align" => "center")  );
          $g->addField("Fecha Entrega", "orna_fecha_llegada", array("align" => "center"));
          $g->addField("Mts3", "orna_m3", array("align" => "right"));
          $g->addField("Grado", "grad_descripcion",array("sortColumn" => false) );
          $g->addField("Apellidos", "orna_apellidos"   );
          $g->addField("Nombres", "orna_nombres"     );
          $g->addField("Rut", "orna_rut"         );
          $g->addField("Origen", "ciud_nombre",array("sortColumn" => false)      );
          $g->addField("Destino", "ciud_nombre_a",array("sortColumn" => false)    );

          /*
          $g->addField("Nombre", "ciud_nombre" );
          $g->addField("Regi&oacute;n", "ciud_region" );
          $g->addField("Bloqueo",          "ciud_bloqueo", array("align" => "center",
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   )
                      );
          $g->addField("&nbsp;", "comandos");
          */

          $g->setData($arreglo);
          $this->set("grilla", $g->show());         
      }
      
      function reporteGuiasPendientes() {
	     $this->layout = "reporte";
	     
	     while (ob_get_level())
            ob_end_clean();
            
         header("Content-Encoding: None", true);

	     
         $pdf = new PDF("L");


         $pdf->lista = $this->OrdenNacional->findAll("orna_no_guia is not null and orna_cerrar='S' and orna_nula<>'S' and orna_estado='I' and orna_no_guia not in (select dexp_guia from dexpediciones)", null, "institucion_id, orna_no_guia");
         
         $pdf->SetFont('Times','',12);
         $pdf->Run();
         $pdf->Output();	      
      }
   }
   
   
   
   class MiGrid extends Grid {
      function showField($f, $row) {
         $name    = $f["name"];

         if ($name!="comandos")
            return parent::showField($f, $row);
         else {
            $id = $row["id"];
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/ordenes_nacionales/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }   
   
class PDF extends FPDF
{
   var $row = 5;
   var $expe_nro;
   var $expe_fecha;
   var $chof_nombres;
   var $cami_patente;
   var $acop_patente;
   var $expe_destino;
   var $expe_fondos;
   var $lista;
   
// Page header
function Header()
{
	$this->row=0; 
    $this->SetFont('Arial','BI',15);
    // Move to the right
    
    $this->SetXY(3, $this->row);
    // Title
    $this->Cell(40,10,'TRANSPORTES RUTACHILE S.A.',0,0,'L');
    
    $this->SetFont('Arial','',8);
    $this->row +=6;
    $this->SetXY(3, $this->row);
    $this->Cell(40,6,'         AV.CLAUDIO ARRAU 7656 - PUDAHUEL - SANTIAGO',0,0,'L');
    
    $this->row +=4;
    $this->SetXY(3, $this->row);
    $this->Cell(40,6,'               FONOS FAX: 749 8784 - 749 8785 - 749 8786',0,0,'L');
    
    $this->SetFont('Arial','B',12);
    $this->row +=10;
    $this->SetXY(0, $this->row);
    $this->Cell(0,10,'GUÍAS PENDIENTES DE DESPACHO AL '.date("d/m/Y"),0,0,'C');

    $this->SetFont('Arial','',8); 
    
     
    // Line break
    $this->Ln(1);
    
    $this->row += 15;
    
     $this->SetXY(20, $this->row); 
     $this->Cell(25, 4, "Institución"  , "TB", 0, 'L');
     $this->Cell(25, 4, "No.Guía"      , "TB", 0, 'R');
     $this->Cell(20, 4, "Fec/Retiro"   , "TB", 0, 'C');
     $this->Cell(20, 4, "Fec/Llegada"  , "TB", 0, 'C');
     $this->Cell(10, 4, "M3"           , "TB", 0, 'R');
     $this->Cell(25, 4, "Grado"        , "TB", 0, 'L');
     $this->Cell(30, 4, "Apellidos"    , "TB", 0, 'L');
     $this->Cell(30, 4, "Nombres"      , "TB", 0, 'L');
     $this->Cell(18, 4, "Rut"          , "TB", 0, 'L');
     $this->Cell(25, 4, "Origen"       , "TB", 0, 'L');
     $this->Cell(25, 4, "Destino"      , "TB", 0, 'L');
     //$this->row += 5;   

    $this->SetXY(20, $this->row); 
}

function Run() {
   
   //$this->AddPage();

   $nGuias=0;
   $nFacturas=0;
   $nLineas=100;
   
   $rowIni=$this->row;
   
   $this->SetFont('Arial','',8); 
   
   foreach($this->lista as $r) {
	   if ($nLineas >= 21) {
		  $this->row = 5;
		  $this->AliasNbPages();
		  $this->AddPage();
		  
		  $nLineas=0;
	   }
	   
	   $nGuias++;

       $this->row += 4.5; 
       $this->SetXY(20, $this->row); 

       /*
       $this->Cell(20, 5, utf8_decode($r["dexp_guia"])        , 0, 0, 'R'        );
       $this->Cell(40, 5, utf8_decode($r["dexp_remitente"]));	
       $this->Cell(120, 5, utf8_decode($r["dexp_destinatario"]));
       $this->Cell(25, 5, utf8_decode($r["dexp_cobra"]=="S"?"Si":"No")  , 0, 0, 'C'       );
       $this->Cell(25, 5, utf8_decode($r["dexp_factura"]), 0, 0, 'R'     );
       */
       
       $this->Cell(25, 4, utf8_decode($r["inst_razon_social"] ), 0, 0, 'L');
       $this->Cell(25, 4, utf8_decode($r["orna_no_guia"]      ), 0, 0, 'R');
       $this->Cell(20, 4, utf8_decode($r["orna_repo_fecha"]   ), 0, 0, 'C');
       $this->Cell(20, 4, utf8_decode($r["orna_fecha_llegada"]), 0, 0, 'C');
       $this->Cell(10, 4, utf8_decode($r["orna_m3"]           ), 0, 0, 'R');
       $this->Cell(25, 4, utf8_decode($r["grad_descripcion"]  ), 0, 0, 'L');
       $this->Cell(30, 4, utf8_decode($r["orna_apellidos"]    ), 0, 0, 'L');
       $this->Cell(30, 4, utf8_decode($r["orna_nombres"]      ), 0, 0, 'L');
       $this->Cell(18, 4, utf8_decode($r["orna_rut"]          ), 0, 0, 'L');
       $this->Cell(25, 4, utf8_decode($r["ciud_nombre"]       ), 0, 0, 'L');
       $this->Cell(25, 4, utf8_decode($r["ciud_nombre_a"]     ), 0, 0, 'L');
       
       $nLineas++;

   }
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}   

