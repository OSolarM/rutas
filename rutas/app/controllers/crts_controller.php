<?php
   class CrtsController extends AppController {
      var $name="Crts";
      var $uses=array("Crt", "Cliente");
      var $inputToUpper=false;

      function index($page=null) {
         $recsXPage=20;
            
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
         
                      
         $g = new MiGrid();
           	 	 	 	 	 	 
	     $g->addField("N&uacute;mero", "crts_numero", array("searchCol" => true, "scLen" => 20)); 	 
	     $g->addField("Fecha", "fecha"); 
	     $g->addField("Operaci&oacute;n", "tipo_operacion", array("trad" => array("E" => "Exportaci&oacute;n", "I" => "Importaci&oacute;n"))); 
	     $g->addField("Remitente", "razon", array("sortColumn" => false)); 
	     $g->addField("Lugar y pa&iacute;s de emisi&oacute;n", "crts_lug_pais_emis" );
	     $g->addField("Lugar, pa&iacute;s plazo entrega",      "crts_lug_pais_plaz" );
	     
	     $g->addField("Estado", "crts_estado", array("trad" => array('I' => "Ingresado", "C" => "Cerrado")) );
	     

         //$g->addField("Bloqueo",            "cami_bloqueo", array("align" => "center", 
         //                                                         "trad"  => array("S"=>"S", "N" => "No")
         //                                                         ));
         $g->addField("&nbsp;", "comandos");
         
         //La bsqueda
         
         //Recupera columnas de bsqueda
         
         $busqueda = "1=1";
         if ($g->scColsPresent()) {         
	        $crts_numero = isset($_REQUEST["crts_numero"])?$_REQUEST["crts_numero"]:"";
	        
	        if ($crts_numero!="") {
               $busqueda = "crts_numero like '%$crts_numero%'";
               $page = 1;
            }
         }
                  
         $arr = $this->Crt->findSql("select * from crts where $busqueda order by ".$sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);                  
         $arreglo = $this->Crt->findAll($busqueda, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);          
         $pagination = new pagination("/crts/index", $page, ":".$sortKey.":".$orderKey);         
         $arreglo = $pagination->generate($arreglo, $this->Crt->count(), $recsXPage);                        
         $this->assign('pagination', $pagination->links());
                  
         $g->setData($arreglo);
         $this->set("grilla", $g->show());
          
      }

      function llenaClientes() {
	     $arr = $this->Cliente->findAll(null, null, "razon");
	     
	     //print_r($arr);
	     $lista="|";
	     
	     foreach($arr as $r)
	        $lista .= ",".$r["razon"]."-".$r["ciudad"]." ".$r["comuna"]." ".$r["pais"]."|".$r["id"];
	        
	     //echo "<hr>$lista<hr>";
	        
	     $this->set("clientes", $lista);	     
      }
      
      function add() {
         $this->layout="form";

         if (!empty($this->data)) {
            if ($this->Crt->save($this->data))   {
	           
	           $id=$this->Crt->table->insertId();  
               $this->redirect("/crts/mprime/$id");
           }
         }
         if (empty($this->data)) {
            $this->data["Cliente"]["bloqueo"]    = "N";
            $this->data["Crt"]["fecha"]          = date("d/m/Y");
            $this->data["Crt"]["tipo_operacion"] = "E";
            $this->data["Crt"]["estado"]         = "I";
            $this->data["Crt"]["crts_valor_flete"]= 0;
            $this->data["Crt"]["crts_mon_flete"]  = "USD";
            $this->data["Crt"]["crts_estado"]     = "I";
            
            $s = "TRANSPORTES RUTA CHILE S.A.\n".
                 "AV.CLAUDIO ARRAU 7656 - PUDAHUEL\n".  
                 "SANTIAGO - CHILE";
                 
            $this->data["Crt"]["crts_nom_dom_transp"]     = $s;
            
            $s = "EL SEGURO DE LA PRESENTE MERCADERIA VIAJA POR CUENTA\n".
                 "Y ORDEN DEL IMPORTADOR/EXPORTADOR CON CLAUSULA\n".  
                 "DE NO REPETICION HACIA EMPRESA TRANSPORTADORA\n". 
                 "LIBERANDO A LA MISMA DE TODA RESPONSABILIDAD\n". 
                 "AL RESPECTO";
                 
            $this->data["Crt"]["crts_decl_observ"]     = $s;
            
            $this->data["Crt"]["crts_nom_firma_sello"] = "TRANSPORTES RUTA CHILE S.A.";
         }
         
         $this->llenaClientes();
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
	        
            if ($this->Crt->save($this->data)) {
               $this->redirect("/crts/imprime/$id");
               return;
            }
            
            //print_r($this->Crt->errorList);
         }
         if (empty($this->data)) {
            $this->data = $this->Crt->read(null, $id);
            
            $s = "TRANSPORTES RUTA CHILE S.A.\n".
                 "AV.CLAUDIO ARRAU 7656 - PUDAHUEL\n".  
                 "SANTIAGO - CHILE";
                 
            $this->data["Crt"]["crts_nom_dom_transp"]     = $s;
            
            $s = "EL SEGURO DE LA PRESENTE MERCADERIA VIAJA POR CUENTA\n".
                 "Y ORDEN DEL IMPORTADOR/EXPORTADOR CON CLAUSULA\n".  
                 "DE NO REPETICION HACIA EMPRESA TRANSPORTADORA\n". 
                 "LIBERANDO A LA MISMA DE TODA RESPONSABILIDAD\n". 
                 "AL RESPECTO";
                 
            $this->data["Crt"]["crts_decl_observ"]     = $s;        
            $this->data["Crt"]["crts_nombre_domicilio1"  ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nombre_domicilio1"  ]);
            $this->data["Crt"]["crts_numero"             ] = str_replace("rn", "\n", $this->data["Crt"]["crts_numero"             ]);
            $this->data["Crt"]["crts_nom_dom_transp"     ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_dom_transp"     ]);
            $this->data["Crt"]["crts_nom_dom_destin"     ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_dom_destin"     ]);
            $this->data["Crt"]["crts_lug_pais_emis"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_lug_pais_emis"      ]);
            $this->data["Crt"]["crts_nom_dom_consig"     ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_dom_consig"     ]);
            $this->data["Crt"]["crts_lug_pais_fec"       ] = str_replace("rn", "\n", $this->data["Crt"]["crts_lug_pais_fec"       ]);
            $this->data["Crt"]["crts_lug_pais_plaz"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_lug_pais_plaz"      ]);
            $this->data["Crt"]["crts_notificar_a"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_notificar_a"        ]);
            $this->data["Crt"]["crts_port_sucesivos"     ] = str_replace("rn", "\n", $this->data["Crt"]["crts_port_sucesivos"     ]);
            $this->data["Crt"]["crts_cant_clase_bultos"  ] = str_replace("rn", "\n", $this->data["Crt"]["crts_cant_clase_bultos"  ]);
            $this->data["Crt"]["crts_peso_brut_kg"       ] = str_replace("rn", "\n", $this->data["Crt"]["crts_peso_brut_kg"       ]);
            $this->data["Crt"]["crts_peso_neto_kg"       ] = str_replace("rn", "\n", $this->data["Crt"]["crts_peso_neto_kg"       ]);
            $this->data["Crt"]["crts_vol_m3"             ] = str_replace("rn", "\n", $this->data["Crt"]["crts_vol_m3"             ]);
            $this->data["Crt"]["crts_valor"              ] = str_replace("rn", "\n", $this->data["Crt"]["crts_valor"              ]);
            $this->data["Crt"]["crts_moneda"             ] = str_replace("rn", "\n", $this->data["Crt"]["crts_moneda"             ]);
            $this->data["Crt"]["crts_flete_monto"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_flete_monto"        ]);
            $this->data["Crt"]["crts_seguro_monto"       ] = str_replace("rn", "\n", $this->data["Crt"]["crts_seguro_monto"       ]);
            $this->data["Crt"]["crts_otro_monto"         ] = str_replace("rn", "\n", $this->data["Crt"]["crts_otro_monto"         ]);
            $this->data["Crt"]["crts_flete_moneda"       ] = str_replace("rn", "\n", $this->data["Crt"]["crts_flete_moneda"       ]);
            $this->data["Crt"]["crts_seguro_moneda"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_seguro_moneda"      ]);
            $this->data["Crt"]["crts_otro_moneda"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_otro_moneda"        ]);
            $this->data["Crt"]["crts_dest_flete"         ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_flete"         ]);
            $this->data["Crt"]["crts_dest_seguro"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_seguro"        ]);
            $this->data["Crt"]["crts_dest_otro"          ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_otro"          ]);
            $this->data["Crt"]["crts_dest_moneda"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_moneda"        ]);
            $this->data["Crt"]["crts_dest_o_moneda"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_o_moneda"      ]);
            $this->data["Crt"]["crts_decl_valor"         ] = str_replace("rn", "\n", $this->data["Crt"]["crts_decl_valor"         ]);
            $this->data["Crt"]["crts_docto_anexo"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_docto_anexo"        ]);
            $this->data["Crt"]["crts_inst_formal"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_inst_formal"        ]);
            $this->data["Crt"]["crts_monto_flete_ext"    ] = str_replace("rn", "\n", $this->data["Crt"]["crts_monto_flete_ext"    ]);
            $this->data["Crt"]["crts_monto_reembolso"    ] = str_replace("rn", "\n", $this->data["Crt"]["crts_monto_reembolso"    ]);
            $this->data["Crt"]["crts_nom_firma_remit"    ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_firma_remit"    ]);
            $this->data["Crt"]["crts_decl_observ"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_decl_observ"        ]);
            $this->data["Crt"]["crts_nom_firma_sello"    ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_firma_sello"    ]);
            $this->data["Crt"]["crts_nom_firma_des"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_nom_firma_des"      ]);
            $this->data["Crt"]["crts_f_dest_moneda"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_f_dest_moneda"      ]);
            $this->data["Crt"]["crts_s_dest_moneda"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_s_dest_moneda"      ]);
            $this->data["Crt"]["crts_o_dest_moneda"      ] = str_replace("rn", "\n", $this->data["Crt"]["crts_o_dest_moneda"      ]);
            $this->data["Crt"]["tipo_operacion"          ] = str_replace("rn", "\n", $this->data["Crt"]["tipo_operacion"          ]);
            $this->data["Crt"]["estado"                  ] = str_replace("rn", "\n", $this->data["Crt"]["estado"                  ]);
            $this->data["Crt"]["crts_valor_flete"        ] = str_replace("rn", "\n", $this->data["Crt"]["crts_valor_flete"        ]);
            $this->data["Crt"]["crts_mon_flete"          ] = str_replace("rn", "\n", $this->data["Crt"]["crts_mon_flete"          ]);
            $this->data["Crt"]["crts_estado"             ] = str_replace("rn", "\n", $this->data["Crt"]["crts_estado"             ]);
            $this->data["Crt"]["crts_otro_monto_total"   ] = str_replace("rn", "\n", $this->data["Crt"]["crts_otro_monto_total"   ]);
            $this->data["Crt"]["crts_otro_moneda_total"  ] = str_replace("rn", "\n", $this->data["Crt"]["crts_otro_moneda_total"  ]);
            $this->data["Crt"]["crts_dest_otro_total"    ] = str_replace("rn", "\n", $this->data["Crt"]["crts_dest_otro_total"    ]);
            $this->data["Crt"]["crts_o_dest_moneda_total"] = str_replace("rn", "\n", $this->data["Crt"]["crts_o_dest_moneda_total"]);
            $this->data["Crt"]["crts_flete"              ] = str_replace("rn", "\n", $this->data["Crt"]["crts_flete"              ]);
            $this->data["Crt"]["crts_seguro"             ] = str_replace("rn", "\n", $this->data["Crt"]["crts_seguro"             ]);
            $this->data["Crt"]["crts_otro"               ] = str_replace("rn", "\n", $this->data["Crt"]["crts_otro"               ]); 
         }
         
         $this->llenaClientes();
      }
      
      function getCliente($cliente_id=null) {     
	     if ($cliente_id=="") {
		    echo "@@";
	        return;
         }
	     
         try {
	        $data = $this->Cliente->read(null, $cliente_id);
         }
         catch(Exception $ee) {
	        $data=array();
         }

	     if (count($data)==0) {
		    echo "$cliente_id@@";
		    return;
	     }
	     
	     echo ($data["Cliente"]["razon"]."\n".
	          $data["Cliente"]["direccion"]." ".$data["Cliente"]["comuna"]." ".$data["Cliente"]["ciudad"]."\n".
	          $data["Cliente"]["pais"])."@@";
	   
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Crt->delete($id))
            $this->redirect("/crts");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      
      function imprime($id) {
         while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         	      
	     $layout = "form";
	     
	     $pdf = new PDF2("P", "mm", array(216, 330));
	     
	     $data = $this->Crt->read(null, $id);
	     
	     
	     $pdf->Run($data["Crt"]);
	     
	     $pdf->Output();
      }
      
      function imprime2($id) {
         while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         	      
	     $layout = "form";
	     
	     $pdf = new PDF2("P", "mm", array(216, 330));
	     
	     $data = $this->Crt->read(null, $id);
	     
	     
	     $pdf->Run($data["Crt"]);
	     
	     $pdf->Output();
      }      
      
      function control_crts($id=null) {
	     $arr = $this->Crt->findAll("crts_estado='C'", null, "fecha, crts_numero");
	     
	     $this->set("crts", $arr);
      }
      
      function edita_crts($id=null) {
	     $this->Crt->validate  = array("fec_carga"      => "required|date",
	                                   "fec_descarga"   => "required|date",
	                                   "fec_ent_aduana" => "", 
	                                   "fec_sal_aduana" => "",
	                                  );
	     if (!empty($this->data)) {
		    $d["Crt"] = $this->data["Crt"];
		    
		    //print_r($d);
		    
		    $id = $d["Crt"]["id"];
		    
		    $dd = $this->Crt->read(null, $id);
		    
		    $dd["Crt"]["fec_carga"]    = $d["Crt"]["fec_carga"];
		    $dd["Crt"]["fec_descarga"] = $d["Crt"]["fec_descarga"];
		    $dd["Crt"]["fec_ent_aduana"] = $d["Crt"]["fec_ent_aduana"];
            $dd["Crt"]["fec_sal_aduana"] = $d["Crt"]["fec_sal_aduana"];
		    $dd["Crt"]["crts_dias_extras"] = $d["Crt"]["crts_dias_extras"];
		    $dd["Crt"]["crts_valor_dias_extras"] = $d["Crt"]["crts_valor_dias_extras"];
		    
		    $this->data["Crt"]= $dd["Crt"];
		    
		    //print_r($this->data["Crt"]);

            if ($this->Crt->save($this->data)) {
               $this->redirect("/crts/control_crts");
               return;
            }
            
	     }
	     
	     if (empty($this->data)) {
		    $this->data = $this->Crt->read(null, $id);
		    
		    $cliente_id = $this->data["Crt"]["cliente_id"];
	     }
	     else
	        $cliente_id = $_REQUEST["cliente_id"];
	        
	     $data = $this->Cliente->read(null, $cliente_id);
	     
	     $this->set("estadia_maxima", $data["Cliente"]["estadia"]);   
	     $this->set("valor_dia_extra",      $data["Cliente"]["valor"]);
      }
      
      function calculos($cliente_id, $fec_carga, $fec_descarga, $fec_ent_aduana, $fec_sal_aduana) {
	     //01234567
	     //ddmmaaaa
	     $data = $this->Cliente->read(null, $cliente_id);
	     
	     $estadia = $data["Cliente"]["estadia"];
	     $valorP   = $data["Cliente"]["valor"];
	     
	     if ($fec_ent_aduana!="" && $fec_sal_aduana!="") {
		    $f1 = substr($fec_ent_aduana, 5, 4)."-".substr($fec_ent_aduana, 2,2)."-".substr($fec_ent_aduana, 0,2);
	        $f2 = substr($fec_sal_aduana, 5, 4)."-".substr($fec_sal_aduana, 2,2)."-".substr($fec_sal_aduana, 0,2);
	        	        
	        
            $ini = strtotime($f1);
            $fin = strtotime($f2);
            
            if ($fin > $ini) {
               $dias=$fin-$ini;
               $resultado = floor($dias/(60*60*24));
               $valor = ($resultado-$estadia)*$valorP;
            }
            else {
	           $dias = 0;
	           $resultado=0;
	           $valor=0;
            }
            
            $aDias     =$dias;
            $aResultado=$resultado;
            $aValor    =$valor;           
            
            if ($aDias > $estadia)
               $aDiasDif =$resultado-$estadia;
            else
               $aDiasDif = 0;
            
            //echo ($resultado-$estadia)."@@".$valor."@@";
            
		    $f1 = substr($fec_sal_aduana, 5, 4)."-".substr($fec_sal_aduana, 2,2)."-".substr($fec_sal_aduana, 0,2);
	        $f2 = substr($fec_descarga, 5, 4)."-".substr($fec_descarga, 2,2)."-".substr($fec_descarga, 0,2);
	        
            $ini = strtotime($f1);
            $fin = strtotime($f2);
            
            if ($fin > $ini) {
               $dias=$fin-$ini;
               $resultado = floor($dias/(60*60*24));
               $valor = ($resultado-$estadia)*$valorP;
            }
            else {
	           $dias = 0;
	           $resultado=0;
	           $valor=0;
            }
            
            $bDias     =$dias;
            $bResultado=$resultado;
            $bValor    =$valor;      
            
            if ($bDias > $estadia)
               $bDiasDif = $resultado-$estadia;   
            else
               $bDiasDif = 0;
            
            $mDias = $aDiasDif + $bDiasDif;
            
            $mValor= $aValor + $bValor;
            
            if ($mValor > 0)
               echo $mDias."@@".$mValor."@@"; 
            else
               echo "0@@0@@"; 
	     }
	     else {     
	        $f1 = substr($fec_carga, 5, 4)."-".substr($fec_carga, 2,2)."-".substr($fec_carga, 0,2);
	        $f2 = substr($fec_descarga, 5, 4)."-".substr($fec_descarga, 2,2)."-".substr($fec_descarga, 0,2);
	        
            $ini = strtotime($f1);
            $fin = strtotime($f2);
            
            if ($fin > $ini) {
               $dias=$fin-$ini;
               $resultado = floor($dias/(60*60*24));
               $valor = ($resultado-$estadia)*$valor;
            }
            else {
	           $dias = 0;
	           $resultado=0;
	           $valor=0;
            }
            
            if ($valor > 0)
               echo ($resultado-$estadia)."@@".$valor."@@";
            else
               echo "0@@0@@";
         }
	      
      }
      
      function info_crts() {
         $this->Crt->validate=array("fecini", "required|type=date",
	                                      "fecfin", "required|type=date"
	                                     );
	                                     
	     if (!empty($this->data)) {	  	  
	  	    $fecini =$_REQUEST["fecini"]; 
	  	    $fecfin =$_REQUEST["fecfin"];
	  	    $this->repo_info_crts($fecini, $fecfin); 
	     }
	     
	     if (empty($this->data)) {
	  	    $this->set("fecini", date("d/m/Y"));
	  	    $this->set("fecfin", date("d/m/Y"));	  	  
	     }	      
      }
      
      
      function repo_info_crts($fecini, $fecfin) {
	     while (ob_get_level())
            ob_end_clean();
         header("Content-Encoding: None", true);
         
         $f1 = date2Mysql($fecini);
         $f2 = date2Mysql($fecfin);
         
         
         $arr = $this->Crt->findAll("fecha between '$f1' and '$f2' ".
                                    "and    crts_estado='C'                         ".
                                    "and    crts_facturable='S'",
                                    null,
                                    "cliente_id, ltrim(rtrim(crts_numero))");
                                    
                                    
         $nCuenta = count($arr);
         for ($i=0; $i < $nCuenta; $i++) {
	        $arr[$i]["faltan"] = "";
	         
	        if ($i+1 <= $nCuenta-1) {
		       //echo $arr[$i]["crts_numero"]." ".$arr[$i+1]["crts_numero"]."<hr/>";
		        
		       $e1 = explode("/", ltrim(rtrim($arr[$i]["crts_numero"]  )));
		       $e2 = explode("/", ltrim(rtrim($arr[$i+1]["crts_numero"])));
		       
		       if (count($e1)==3 && count($e2)==3 && $e1[1]==$e2[1] && $e1[2]==$e2[2] &&
		           $arr[$i]["cliente_id"]==$arr[$i+1]["cliente_id"]       		       
		       ) {
			      $nro1 = $e1[0]*1.0;
			      $nro2 = $e2[0]*1.0;
			      
			      //echo "$nro1 $nro2<br>";
			      
			      if ($nro2-$nro1==1 || $nro1-$nro2==1)
			         $arr[$i]["faltan"] = "";
			      else if ($nro2==$nro1)
                     $arr[$i]["faltan"] = "Duplicados";
			      else
			         $arr[$i]["faltan"] = "Faltan";
			       
		       } 
	        }
         }
         
         //print_r($arr);
         
         
         include_once(APP_PATH."/app/pdfs/PDF_info_crts.php");
            
         $pdf = new PDF_info_crts("P");
            
         $pdf->SetFont('Times','',12);
            
         $pdf->Run($fecini, $fecfin, $arr);
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
		    $crts_estado = $row["crts_estado"];
		    
		    $ss = "<td style=\"background:white\"><a href=\"".APP_HTTP."/crts/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a>&nbsp;";
		    
		    if ($crts_estado !="C")
		       $ss .= "<a href=\"javascript:if (confirm('¿Seguro eliminar CRT?')) location.href='".APP_HTTP."/crts/delete/$id';\"><img src=\"".APP_HTTP."/app/img/delete.gif\">Elimina</a>&nbsp;";
		    
		    
		    $ss .= "<a href=\"".APP_HTTP."/crts/imprime/$id\" target=\"_blank\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Imprime</a></td>";
		    
		    return $ss;
         }    
      }
   }   
   
   class PDF_Ellipse extends FPDF
{
function Circle($x, $y, $r, $style='D')
{
    $this->Ellipse($x,$y,$r,$r,$style);
}

function Ellipse($x, $y, $rx, $ry, $style='D')
{
    if($style=='F')
        $op='f';
    elseif($style=='FD' || $style=='DF')
        $op='B';
    else
        $op='S';
    $lx=4/3*(M_SQRT2-1)*$rx;
    $ly=4/3*(M_SQRT2-1)*$ry;
    $k=$this->k;
    $h=$this->h;
    $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x+$rx)*$k,($h-$y)*$k,
        ($x+$rx)*$k,($h-($y-$ly))*$k,
        ($x+$lx)*$k,($h-($y-$ry))*$k,
        $x*$k,($h-($y-$ry))*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x-$lx)*$k,($h-($y-$ry))*$k,
        ($x-$rx)*$k,($h-($y-$ly))*$k,
        ($x-$rx)*$k,($h-$y)*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x-$rx)*$k,($h-($y+$ly))*$k,
        ($x-$lx)*$k,($h-($y+$ry))*$k,
        $x*$k,($h-($y+$ry))*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
        ($x+$lx)*$k,($h-($y+$ry))*$k,
        ($x+$rx)*$k,($h-($y+$ly))*$k,
        ($x+$rx)*$k,($h-$y)*$k,
        $op));
}
}
   
   class PDF extends PDF_Ellipse {	  
	  var $despX = 0;
	  var $despY = -5;
	  
	  function dibuja($col, $fil, $texto) {
		 $despX=$this->despX;
		 $despY=$this->despY;
		 $altura=4;
		 
		 $this->SetFont('Courier','B',7);
		 
		 //$texto  = nl2br($texto);
		 $lineas = explode("\n", $texto);
		 
		 $i=0;
		 foreach($lineas as $l) {
			$l = utf8_decode($l);
			
			$this->Text($col + $despX, $fil + $despY + $i*$altura, $l);
			$i++;
		 }
		 
		 //$this->Text($col + $despX, $fil + $despY + $i*$altura, count($lineas));
	  }
	  
	  function dibujaTitulo($col, $fil, $texto, $nro, $titulo, $titulo2=null) {
		 $despX=$this->despX;
		 $despY=$this->despY;
		 $altura=3;
		 
		 $this->SetFont('Times','B',8);
		 $this->Text($col-4 + $despX, $fil + $despY - 2, $nro);
		 
		 $this->SetFont('Times','',6);
		 $this->Text($col+1 + $despX, $fil + $despY - 2, $titulo);
		 
		 $despY += 2;
		 
		 if ($titulo2!=null) {
		    $this->Text($col+1 + $despX, $fil + $despY - 2, $titulo2);
		    $despY += 2;
		 }
		 
		 //$texto  = nl2br($texto);
		 $lineas = explode("\n", $texto);
		 
		 
		 $this->SetFont('Courier','B',7);
		 $i=0;
		 foreach($lineas as $l) {
			$l = utf8_decode($l);
			
			$this->Text($col + $despX , $fil + $despY + $i*$altura, $l);
			$i++;
		 }
		 
		 //$this->Text($col + $despX, $fil + $despY + $i*$altura, count($lineas));
	  }
	  
	  function rectangulo($col, $fil, $w, $h) {
		 $despX=$this->despX;
		 $despY=$this->despY;
		 $altura=4;
		  
		 $this->Rect($col + $despX, $fil + $despY, $w, $h);
	  }
	  
	  function Run($r) {
		  
       $id                     = $r["id"                    ];
       $crts_nombre_domicilio1 = $r["crts_nombre_domicilio1"];
       $crts_numero            = $r["crts_numero"           ];
       $crts_nom_dom_transp    = $r["crts_nom_dom_transp"   ];
       $crts_nom_dom_destin    = $r["crts_nom_dom_destin"   ];
       $crts_lug_pais_emis     = $r["crts_lug_pais_emis"    ];
       $crts_nom_dom_consig    = $r["crts_nom_dom_consig"   ];
       $crts_lug_pais_fec      = $r["crts_lug_pais_fec"     ];
       $crts_lug_pais_plaz     = $r["crts_lug_pais_plaz"    ];
       $crts_notificar_a       = $r["crts_notificar_a"      ];
       $crts_port_sucesivos    = $r["crts_port_sucesivos"   ];
       $crts_cant_clase_bultos = $r["crts_cant_clase_bultos"];
       $crts_peso_brut_kg      = $r["crts_peso_brut_kg"     ];
       $crts_peso_neto_kg      = $r["crts_peso_neto_kg"     ];
       $crts_vol_m3            = $r["crts_vol_m3"           ];
       $crts_valor             = $r["crts_valor"            ];
       $crts_moneda            = $r["crts_moneda"           ];
       $crts_flete_monto       = $r["crts_flete_monto"      ];
       $crts_seguro_monto      = $r["crts_seguro_monto"     ];
       $crts_otro_monto        = $r["crts_otro_monto"       ];
       $crts_flete_moneda      = $r["crts_flete_moneda"     ];
       $crts_seguro_moneda     = $r["crts_seguro_moneda"    ];
       $crts_otro_moneda       = $r["crts_otro_moneda"      ];
       $crts_dest_flete        = $r["crts_dest_flete"       ];
       $crts_dest_seguro       = $r["crts_dest_seguro"      ];
       $crts_dest_otro         = $r["crts_dest_otro"        ];
       $crts_dest_moneda       = $r["crts_dest_moneda"      ];
       $crts_dest_o_moneda     = $r["crts_dest_o_moneda"    ];
       $crts_decl_valor        = $r["crts_decl_valor"       ];
       $crts_docto_anexo       = $r["crts_docto_anexo"      ];
       $crts_inst_formal       = $r["crts_inst_formal"      ];
       $crts_monto_flete_ext   = $r["crts_monto_flete_ext"  ];
       $crts_monto_reembolso   = $r["crts_monto_reembolso"  ];
       $crts_nom_firma_remit   = $r["crts_nom_firma_remit"  ];
       $crts_nom_firma_rfec    = $r["crts_nom_firma_rfec"   ];
       $crts_decl_observ       = $r["crts_decl_observ"      ];
       $crts_nom_firma_sello   = $r["crts_nom_firma_sello"  ];
       $crts_nom_firma_sfec    = $r["crts_nom_firma_sfec"   ];
       $crts_nom_firma_des     = $r["crts_nom_firma_des"    ];
       $crts_nom_firma_dfec    = $r["crts_nom_firma_dfec"   ];
       $crts_f_dest_moneda     = $r["crts_f_dest_moneda"    ];
       $crts_s_dest_moneda     = $r["crts_s_dest_moneda"    ];
       $crts_o_dest_moneda     = $r["crts_o_dest_moneda"    ];		  
       $crts_flete             = $r["crts_flete"];
       $crts_seguro            = $r["crts_seguro"];
       $crts_otro              = $r["crts_otro"];  
       $crts_otro_monto_total    = $r["crts_otro_monto_total"];
       $crts_otro_moneda_total   = $r["crts_otro_moneda_total"];
       $crts_dest_otro_total     = $r["crts_dest_otro_total"];
       $crts_o_dest_moneda_total = $r["crts_o_dest_moneda_total"];

		 
		 $this->SetFont('Times','',8);
		 
		 $this->AddPage();
		 
		 $this->Circle(29,23, 6);
		 
		 $this->SetFont('Times','',10);
		 $this->Text(25.5,24, "CRT");
		 
		 $this->Text(38,18, "Carta de Porte Internacional");
		 $this->Text(38,21.5, "por Carretera");
		 
		 $this->Text(38,25.2, "Conhocimiento de Transporte");
		 $this->Text(38,28.7, "Internacional por Rodovia");
		 
		 $this->dibujaTitulo( 82, 25, "", "", "El transporte realizado bajo esta Carta de Porte Internacional est suejeto a las disposiciones del Convenio sobre el");
		 $this->dibujaTitulo( 82, 27, "", "", "contrato de transporte y la Responsabilidad Civil del Porteador en el Transporte Terrestre Internacional de Mercancas,");
		 $this->dibujaTitulo( 82, 29, "", "", "las cuales anula toda estipulacin que se aparte de ellas en perjuicio del remitente o del consignatario.");
		                       
	     $this->dibujaTitulo( 82, 33, "", "", "O transporte realizado ao amparo deste Chonhecimento de transporte Internacional est sujeto as disposices do Convenios");
		 $this->dibujaTitulo( 82, 35, "", "", "sbre o Contrato do Transporte e a Responsabilidade Civil do Transportador no Transporte Terrestre Internacional do");
		 $this->dibujaTitulo( 82, 37, "", "", "Mercaderas, as quais todo estipulaco contrria as mesmas en prejuizo em rematente ou do consignatrio.");
		  
		 
		 $this->dibujaTitulo( 25, 41, $crts_nombre_domicilio1, 1, "Nombre y docimicilio del remitente/Nome e enderecco do remetente");
		 
		 $this->dibujaTitulo(110, 41, $crts_numero, 2, "Numero / Numero");
		 
		 $this->dibujaTitulo(110, 50, $crts_nom_dom_transp, 3, "Nombre y domicilio del portador/Nome e enderecco do transportador");
		 
		 $this->dibujaTitulo( 25, 59, $crts_nom_dom_destin, 4, "Nombre y domicilio del destinatario/Nome e enderecco do destinatario"); 
		 
		 $this->dibujaTitulo(110, 66, $crts_lug_pais_emis, 5, "Lugar, pas de emisin/Localidade e pais do emissao"); 
		 
		 $this->dibujaTitulo( 25, 75, $crts_nom_dom_consig, 6, "Nombre y domicilio del consignatario/Nomme e enderecco do consignatario"); 
		 
		 $this->dibujaTitulo(110, 75, $crts_lug_pais_fec, 7, "Lugar, pas y fecha en que el porteador se hace cargo de la mercanca"
		                                                   , "Localidade, pais e data em que o transportador se responsabiliza pela mercadoria"
		                    ); 
		 
		 $this->dibujaTitulo(110, 85, $crts_lug_pais_plaz, 8, "Lugar, pas y plazo de entrega/Localidade, pais e prazo de entrega"); 
		 
		 $this->dibujaTitulo( 25, 92, $crts_notificar_a, 9, "Notificar a/Nofificar a"); 
		 
		 $this->dibujaTitulo(110, 97, $crts_port_sucesivos, 10, "Porteadores sucesivos/Transportadores sucesivos"); 
		 
		 $this->dibujaTitulo( 25,110, $crts_cant_clase_bultos, 11, "Cantidad y clase de bultos, marcas y nmeros, tipo de mercancas, contenedores y accesorios", 
		                                                           "Quantidade e categoria de volumenes, marcas e numeros, tipos de marcadorias, containeres e pecas"); 
		 
		 $this->dibujaTitulo(146,110, "PB: ".$crts_peso_brut_kg, 12, "Peso bruto en Kg./Peso bruto em Kg."); 
		 
		 $this->dibuja(168,112, "PN: ".$crts_peso_neto_kg); 
		 
		 $this->dibujaTitulo(146,124, $crts_vol_m3, 13, "Volumen en m.cu./Volumen en m.cu."); 
		 
		 $this->dibujaTitulo(146,137, $crts_valor, 14, "Valor/Valor"   ); 
		 
		 $this->dibujaTitulo(146,145, $crts_moneda, "", "Moneda/Moeda" );      
		 
		 
		 $nDelta = 80;
		 
		 $this->dibujaTitulo(109+$nDelta,154, $crts_decl_valor, 16, "OSDeclaracin del valor de las mercancas/Declaracao do valor das Mercadorias");
		 
		 $this->dibujaTitulo(109,169+$nDelta, $crts_docto_anexo, 17, "Documentos anexos/Documentos anexos");
		 
		 $this->dibujaTitulo(109,202, $crts_inst_formal, 18, "Instrucciones sobre formalidades de aduana", "Instrucoes sobre formalidades de la alfandega");
		 
		 $this->dibujaTitulo(25,202, $crts_monto_flete_ext, 19, "Monto del flete externo/Valor do frete externo");
		 
		 $this->dibujaTitulo( 25,214, $crts_monto_reembolso, 20, "Monto de reembolso contra entrega/Valor de reembolso contra entrega");
		 
		 $this->dibujaTitulo(25,227, $crts_nom_firma_remit, 21, "Nombre y firm del remitente o su representante", "Nome e assinatura do remitente ou seu representante" );
		 
		 $this->dibujaTitulo(25,240, $crts_nom_firma_rfec, "", "Fecha/Data" );
		 
		 $this->dibujaTitulo(109,227, $crts_decl_observ, 22, "Declaraciones y observaciones/Declaracoes e observacoes");
		 
		 $this->dibujaTitulo(25,249, "", "", "Las mercaderas consigandas en esta Carta de Porte fueron recibidas por el porteador", "aparentemente en buen estado, bajo las condiciones generales que figuran al dorso.");  
		 $this->dibujaTitulo(25,253, "", "", "As mercadorias consigandas nste Conbecimento do Transporte forram recebidas pelo", " transportador aparentemente em bom estado, sob as condicoes gerais que figuram no verso.");  
		 
		 $this->dibujaTitulo(25,258, $crts_nom_firma_sello, 23, "Nombre, firma y sello del porteador o su representante", "Nome, assinatura e carimbo do transportador ou seu representante");      
             
		 $this->dibuja( 35,267, $crts_nom_firma_sfec); 
		 
		 $this->dibujaTitulo(109,258, $crts_nom_firma_des, 24, "Nombre y firma del destinatario o su representante", "Nome e assinatura do destinatario ou seu representante"); 

		 $this->dibuja(120,267, $crts_nom_firma_dfec); 
		      
		 $this->rectangulo(20, 20, 169, 16);
		 
		 $this->rectangulo(20, 36, 85, 17);
		 
		 $this->rectangulo(20, 53, 85, 17);
		 
		 $this->rectangulo(20, 70, 85, 17);
		 
		 $this->rectangulo(20, 87, 85, 17);
		 
		 $this->rectangulo(20,104, 121, 45);
		 
		 $this->rectangulo(105.0, 36, 84, 9);
		 
		 $this->rectangulo(105.0, 45, 84, 16);
		 
		 $this->rectangulo(105.0, 61, 84,  9);
		 
		 $this->rectangulo(105.0, 70, 84, 10);
		 
		 $this->rectangulo(105.0, 80, 84, 12);
		 
		 $this->rectangulo(105.0, 92, 84, 12);
		 
		 $this->rectangulo(141.0, 104, 48, 14);
		 
		 $this->rectangulo(141.0, 118, 48, 14);
		 
		 $this->rectangulo(141.0, 132, 48, 17);
		 
		 $this->rectangulo(20, 149, 84, 48);
		 
		 $this->rectangulo(104, 149, 85, 48);
		 
		 $this->rectangulo(104, 149, 85, 15);
		 
         //$this->rectangulo(104, 164, 85, 20);
         
         $this->rectangulo(20, 197, 84,  12);
         
         $this->rectangulo(20, 209, 84, 13);
         
         $this->rectangulo(104, 197, 85, 25);
         
         $this->rectangulo(20, 222, 84,  22);
         
         $this->rectangulo(104, 222, 85, 31);
         
         $this->rectangulo(20, 244, 84,  29);
         
         $this->rectangulo(104, 253, 85, 20);
         
         $this->dibujaTitulo(25, 155,"", 15, "Gastos a pagar", "Gastos a pagar");
         $this->dibujaTitulo(42, 155,"", "", "Monto remitente", "Valor remetente");
         $this->dibujaTitulo(65, 155,"", "", "Moneda", "Moeda");
         
         $this->dibujaTitulo(75, 155,"", "", "Monto destinatario", "Valor destinatrio");
         $this->dibujaTitulo(94, 155,"", "", "Moneda", "Moeda");
         
         //$this->rectangulo(20, 155, 84,  1);
         $this->line(20, 152, 104, 152);
         
         $lin=162;
         
         $e = explode(" ", $crts_flete);
         
         $this->dibuja( 22,$lin, $e[0]); 
         $this->dibuja( 45,$lin, $crts_flete_monto); 
		 $this->dibuja( 67,$lin, $crts_flete_moneda); 
		 $this->dibuja( 75,$lin, $crts_dest_flete); 
		 $this->dibuja( 95,$lin, $crts_f_dest_moneda); 
		 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja( 22,$lin, $e[1]); 
		 }
		 
		 //$this->line(20, $lin-2, 104, $lin-2);
		 
		 $lin += 6;
		 

		 $e = explode(" ", $crts_seguro);
         
         $this->dibuja( 22,$lin, $e[0]); 
		 $this->dibuja( 45,$lin, $crts_seguro_monto); 
		 $this->dibuja( 67,$lin, $crts_seguro_moneda); 
		 $this->dibuja( 75,$lin, $crts_dest_seguro); 
		 $this->dibuja( 95,$lin, $crts_s_dest_moneda); 
		 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja( 22,$lin, $e[1]); 
		 }
		 
		 //$this->line(20, $lin-2, 104, $lin-2);
		 $lin += 6;
		 
		 $e = explode(" ", $crts_otro);
         
         $this->dibuja( 22,$lin, $e[0]); 
		 $this->dibuja( 45,$lin, $crts_otro_monto); 
		 $this->dibuja( 67,$lin, $crts_otro_moneda); 
		 $this->dibuja( 75,$lin, $crts_dest_otro); 
		 $this->dibuja( 95,$lin, $crts_o_dest_moneda); 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja( 22,$lin, $e[1]); 
		 }
		 //$this->line(20, $lin-2, 104, $lin-2);
		 $lin += 15;
		 
		 $this->dibuja( 22,$lin, "TOTALES"); 
         $this->dibuja( 45,$lin, $crts_otro_monto_total); 
		 $this->dibuja( 67,$lin, $crts_otro_moneda_total); 
		 $this->dibuja( 75,$lin, $crts_dest_otro_total); 
		 $this->dibuja( 95,$lin, $crts_o_dest_moneda_total); 
		 $this->line(20, $lin-8, 104, $lin-8);
		 $lin += 6;
		 
		 $this->line(40, 144, 40, 192);
		 
		 $this->line(60, 144, 60, 192);
		 
		 $this->line(74, 144, 74, 192);
		 
		 $this->line(94, 144, 94, 192);
           
	  }
	  
   }
   
   class PDF2 extends PDF_Ellipse {	  
	  var $despX = 0;
	  var $despY = -5;
	  
	  function dibuja($col, $fil, $texto) {
		 $despX=$this->despX-10;
		 $despY=$this->despY;
		 $altura=4;
		 
		 $this->SetFont('Courier','B', 8);
		 
		 //$texto  = nl2br($texto);
		 $lineas = explode("\n", $texto);
		 
		 $i=0;
		 foreach($lineas as $l) {
			$l = utf8_decode($l);
			
			$this->Text($col + $despX, $fil + $despY + $i*$altura, $l);
			$i++;
		 }
		 
		 //$this->Text($col + $despX, $fil + $despY + $i*$altura, count($lineas));
	  }
	  
	  function dibujaTitulo($col, $fil, $texto, $nro, $titulo, $titulo2=null) {
		 $despX=$this->despX-10;
		 $despY=$this->despY;
		 $altura=3.5;
		 
		 $this->SetFont('Times','B',8);
		 $this->Text($col-4 + $despX, $fil + $despY - 2, $nro);
		 
		 $this->SetFont('Times','',7);
		 $this->Text($col+1 + $despX, $fil + $despY - 2, $titulo);
		 
		 $despY += 2;
		 
		 if ($titulo2!=null) {
		    $this->Text($col+1 + $despX, $fil + $despY - 2, $titulo2);
		    $despY += 2;
		 }
		 
		 //$texto  = nl2br($texto);
		 $lineas = explode("\n", $texto);
		 
		 
		 $this->SetFont('Courier','B',8);
		 $i=0;
		 foreach($lineas as $l) {
			$l = utf8_decode($l);
			
			$this->Text($col + $despX , $fil + $despY + $i*$altura, $l);
			$i++;
		 }
		 
		 //$this->Text($col + $despX, $fil + $despY + $i*$altura, count($lineas));
	  }
	  
	  function rectangulo($col, $fil, $w, $h) {
		 $despX=$this->despX -10;
		 $despY=$this->despY;
		 $altura=4;
		  
		 $this->Rect($col + $despX, $fil + $despY, $w + 25, $h);
	  }
	  
	  function Run($r) {
		  
       $id                     = $r["id"                    ];
       $crts_nombre_domicilio1 = displayText($r["crts_nombre_domicilio1"], 56);
       $crts_numero            = displayText($r["crts_numero"           ], 56);
       $crts_nom_dom_transp    = displayText($r["crts_nom_dom_transp"   ], 56);
       $crts_nom_dom_destin    = displayText($r["crts_nom_dom_destin"   ], 56);
       $crts_lug_pais_emis     = displayText($r["crts_lug_pais_emis"    ], 56);
       $crts_nom_dom_consig    = displayText($r["crts_nom_dom_consig"   ], 56);
       $crts_lug_pais_fec      = displayText($r["crts_lug_pais_fec"     ], 56);
       $crts_lug_pais_plaz     = displayText($r["crts_lug_pais_plaz"    ], 56);
       $crts_notificar_a       = displayText($r["crts_notificar_a"      ], 56);
       $crts_port_sucesivos    = displayText($r["crts_port_sucesivos"   ], 56);
       $crts_cant_clase_bultos = displayText($r["crts_cant_clase_bultos"], 66);
       $crts_peso_brut_kg      = $r["crts_peso_brut_kg"     ];
       $crts_peso_neto_kg      = $r["crts_peso_neto_kg"     ];
       $crts_vol_m3            = $r["crts_vol_m3"           ];
       $crts_valor             = $r["crts_valor"            ];
       $crts_moneda            = $r["crts_moneda"           ];
       $crts_flete_monto       = $r["crts_flete_monto"      ];
       $crts_seguro_monto      = $r["crts_seguro_monto"     ];
       $crts_otro_monto        = $r["crts_otro_monto"       ];
       $crts_flete_moneda      = $r["crts_flete_moneda"     ];
       $crts_seguro_moneda     = $r["crts_seguro_moneda"    ];
       $crts_otro_moneda       = $r["crts_otro_moneda"      ];
       $crts_dest_flete        = $r["crts_dest_flete"       ];
       $crts_dest_seguro       = $r["crts_dest_seguro"      ];
       $crts_dest_otro         = $r["crts_dest_otro"        ];
       $crts_dest_moneda       = $r["crts_dest_moneda"      ];
       $crts_dest_o_moneda     = $r["crts_dest_o_moneda"    ];
       $crts_decl_valor        = displayText($r["crts_decl_valor"       ], 56);
       $crts_docto_anexo       = $r["crts_docto_anexo"      ];
       $crts_inst_formal       = $r["crts_inst_formal"      ];
       $crts_monto_flete_ext   = $r["crts_monto_flete_ext"  ];
       $crts_monto_reembolso   = $r["crts_monto_reembolso"  ];
       $crts_nom_firma_remit   = $r["crts_nom_firma_remit"  ];
       $crts_nom_firma_rfec    = $r["crts_nom_firma_rfec"   ];
       $crts_decl_observ       = displayText($r["crts_decl_observ"      ], 50);
       $crts_nom_firma_sello   = $r["crts_nom_firma_sello"  ];
       $crts_nom_firma_sfec    = $r["crts_nom_firma_sfec"   ];
       $crts_nom_firma_des     = $r["crts_nom_firma_des"    ];
       $crts_nom_firma_dfec    = $r["crts_nom_firma_dfec"   ];
       $crts_f_dest_moneda     = $r["crts_f_dest_moneda"    ];
       $crts_s_dest_moneda     = $r["crts_s_dest_moneda"    ];
       $crts_o_dest_moneda     = $r["crts_o_dest_moneda"    ];		  
       $crts_flete             = $r["crts_flete"];
       $crts_seguro            = $r["crts_seguro"];
       $crts_otro              = $r["crts_otro"];  
       $crts_otro_monto_total    = $r["crts_otro_monto_total"];
       $crts_otro_moneda_total   = $r["crts_otro_moneda_total"];
       $crts_dest_otro_total     = $r["crts_dest_otro_total"];
       $crts_o_dest_moneda_total = $r["crts_o_dest_moneda_total"];

		 
		 $this->SetFont('Times','',8);
		 
		 $this->AddPage();
		 
		 $this->Circle(18.5,23, 6);
		 
		 $this->SetFont('Times','',10);
		 $this->Text(15.5,24, "CRT");
		 
		 $this->Text(27,18, "Carta de Porte Internacional");
		 $this->Text(27,21.5, "por Carretera");
		 $this->Text(27,25.2, "Conhocimiento de Transporte");
		 $this->Text(27,28.7, "Internacional por Rodovia");
		 
		 $this->dibujaTitulo( 82, 25, "", "", "El transporte realizado bajo esta Carta de Porte Internacional est suejeto a las disposiciones del Convenio sobre el");
		 $this->dibujaTitulo( 82, 27, "", "", "contrato de transporte y la Responsabilidad Civil del Porteador en el Transporte Terrestre Internacional de Mercancas,");
		 $this->dibujaTitulo( 82, 29, "", "", "las cuales anula toda estipulacin que se aparte de ellas en perjuicio del remitente o del consignatario.");
		                       
	     $this->dibujaTitulo( 82, 33, "", "", "O transporte realizado ao amparo deste Chonhecimento de transporte Internacional est sujeto as disposices do Convenios");
		 $this->dibujaTitulo( 82, 35, "", "", "sbre o Contrato do Transporte e a Responsabilidade Civil do Transportador no Transporte Terrestre Internacional do");
		 $this->dibujaTitulo( 82, 37, "", "", "Mercaderas, as quais todo estipulaco contrria as mesmas en prejuizo em rematente ou do consignatrio.");
		  
		 
		 $this->dibujaTitulo( 25, 41, $crts_nombre_domicilio1, 1, "Nombre y docimicilio del remitente/Nome e enderecco do remetente");
		 
		 $this->dibujaTitulo(125, 41, $crts_numero, 2, "Numero / Numero");
		 
		 $this->dibujaTitulo(125, 50, $crts_nom_dom_transp, 3, "Nombre y domicilio del portador/Nome e enderecco do transportador");
		 
		 $this->dibujaTitulo( 25, 59, $crts_nom_dom_destin, 4, "Nombre y domicilio del destinatario/Nome e enderecco do destinatario"); 
		 
		 $this->dibujaTitulo(125, 66, $crts_lug_pais_emis, 5, "Lugar, pas de emisin/Localidade e pais do emissao"); 
		 
		 $this->dibujaTitulo( 25, 75, $crts_nom_dom_consig, 6, "Nombre y domicilio del consignatario/Nomme e enderecco do consignatario"); 
		 
		 $this->dibujaTitulo(125, 75, $crts_lug_pais_fec, 7, "Lugar, pas y fecha en que el porteador se hace cargo de la mercanca"
		                                                   , "Localidade, pais e data em que o transportador se responsabiliza pela mercadoria"
		                    ); 
		 
		 $this->dibujaTitulo(125, 85, $crts_lug_pais_plaz, 8, "Lugar, pas y plazo de entrega/Localidade, pais e prazo de entrega"); 
		 
		 $this->dibujaTitulo( 25, 92, $crts_notificar_a, 9, "Notificar a/Nofificar a"); 
		 
		 $this->dibujaTitulo(125, 97, $crts_port_sucesivos, 10, "Porteadores sucesivos/Transportadores sucesivos"); 
		 
		 $this->dibujaTitulo( 25,110, $crts_cant_clase_bultos, 11, "Cantidad y clase de bultos, marcas y nmeros, tipo de mercancas, contenedores y accesorios", 
		                                                           "Quantidade e categoria de volumenes, marcas e numeros, tipos de marcadorias, containeres e pecas"); 
		 
		 $this->dibujaTitulo(146,110, "PB: ".$crts_peso_brut_kg, 12, "Peso bruto en Kg./Peso bruto em Kg."); 
		 
		 $this->dibuja(178,112, "PN: ".$crts_peso_neto_kg); 
		 
		 $this->dibujaTitulo(146,124, $crts_vol_m3, 13, "Volumen en m.cu./Volumen en m.cu."); 
		 
		 $this->dibujaTitulo(146,137, $crts_valor, 14, "Valor/Valor"   ); 
		 
		 $this->dibujaTitulo(146,145, $crts_moneda, "", "Moneda/Moeda" );      
		 
		 
		 $this->dibujaTitulo(124,166, $crts_decl_valor, 16, "Declaracin del valor de las mercancas/Declaracao do valor das Mercadorias");
		 
		 $this->dibujaTitulo(124,183, $crts_docto_anexo, 17, "Documentos anexos/Documentos anexos");
		 
		 $this->dibujaTitulo(124,202, $crts_inst_formal, 18, "Instrucciones sobre formalidades de aduana", "Instrucoes sobre formalidades de la alfandega");
		 
		 $this->dibujaTitulo(25,202, $crts_monto_flete_ext, 19, "Monto del flete externo/Valor do frete externo");
		 
		 $this->dibujaTitulo( 25,214, $crts_monto_reembolso, 20, "Monto de reembolso contra entrega/Valor de reembolso contra entrega");
		 
		 $this->dibujaTitulo(25,227, $crts_nom_firma_remit, 21, "Nombre y firm del remitente o su representante", "Nome e assinatura do remitente ou seu representante" );
		 
		 $this->dibujaTitulo(25,240, $crts_nom_firma_rfec, "", "Fecha/Data" );
		 
		 $this->dibujaTitulo(124,227, $crts_decl_observ, 22, "Declaraciones y observaciones/Declaracoes e observacoes");
		 
		 $this->dibujaTitulo(25,249, "", "", "Las mercaderas consigandas en esta Carta de Porte fueron recibidas por el porteador", "aparentemente en buen estado, bajo las condiciones generales que figuran al dorso.");  
		 $this->dibujaTitulo(25,253, "", "", "As mercadorias consigandas nste Conbecimento do Transporte forram recebidas pelo", " transportador aparentemente em bom estado, sob as condicoes gerais que figuram no verso.");  
		 
		 $this->dibujaTitulo(25,258, $crts_nom_firma_sello, 23, "Nombre, firma y sello del porteador o su representante", "Nome, assinatura e carimbo do transportador ou seu representante");      
             
		 $this->dibuja( 35,267, $crts_nom_firma_sfec); 
		 
		 $this->dibujaTitulo(124,258, $crts_nom_firma_des, 24, "Nombre y firma del destinatario o su representante", "Nome e assinatura do destinatario ou seu representante"); 

		 $this->dibuja(124,267, $crts_nom_firma_dfec); 
		      
		 $this->rectangulo(20, 20, 169, 16);
		 
		 $this->rectangulo(20, 36, 75, 17);
		 
		 $this->rectangulo(20, 53, 75, 17);
		 
		 $this->rectangulo(20, 70, 75, 17);
		 
		 $this->rectangulo(20, 87, 75, 17);
		 
		 $this->rectangulo(20,104,96, 55);
		 
		 $this->rectangulo(120.0, 36, 69, 9);
		 
		 $this->rectangulo(120.0, 45, 69, 16);
		 
		 $this->rectangulo(120.0, 61, 69,  9);
		 
		 $this->rectangulo(120.0, 70, 69, 10);
		 
		 $this->rectangulo(120.0, 80, 69, 12);
		 
		 $this->rectangulo(120.0, 92, 69, 12);
		 
		 $this->rectangulo(141.0, 104, 48, 14);
		 
		 $this->rectangulo(141.0, 118, 48, 14);
		 
		 $this->rectangulo(141.0, 132, 48, 27);
		 
		 $this->rectangulo(20, 159, 74, 50);
		 
		 $this->rectangulo(119, 159, 70, 38);
		 
		 $this->rectangulo(119, 159, 70, 18);
		 
         //$this->rectangulo(104, 164, 85, 20);
         
         $this->rectangulo(20, 197, 74,  12);
         
         $this->rectangulo(20, 209, 74, 13);
         
         $this->rectangulo(119, 197, 70, 25);
         
         $this->rectangulo(20, 222, 74,  22);
         
         $this->rectangulo(119, 222, 70, 31);
         
         $this->rectangulo(20, 244, 74,  29);
         
         $this->rectangulo(119, 253, 70, 20);
         
         $this->dibujaTitulo(25, 165,"", 15, "Gastos a pagar", "Gastos a pagar");
         $this->dibujaTitulo(42, 165,"", "", "Monto remitente", "Valor remetente");
         $this->dibujaTitulo(65, 165,"", "", "Moneda", "Moeda");
         
         $this->dibujaTitulo(76, 165,"", "", "Monto destinatario", "Valor destinatrio");
         $this->dibujaTitulo(97, 165,"", "", "Moneda", "Moeda");
         
         //$this->rectangulo(20, 155, 84,  1);
         $this->line(10, 162, 109, 162);
         
         $lin=172;
         
         $e = explode(" ", $crts_flete);
         
         $this->dibuja( 22,$lin, $e[0]); 
         $this->dibuja( 45,$lin, $crts_flete_monto); 
		 $this->dibuja( 67,$lin, $crts_flete_moneda); 
		 $this->dibuja( 78,$lin, $crts_dest_flete); 
		 $this->dibuja( 97,$lin, $crts_f_dest_moneda); 
		 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja( 22,$lin, $e[1]); 
		 }
		 
		 //$this->line(20, $lin-2, 104, $lin-2);
		 
		 $lin += 6;
		 

		 $e = explode(" ", $crts_seguro);
         
         $this->dibuja( 22,$lin, $e[0]); 
		 $this->dibuja( 45,$lin, $crts_seguro_monto); 
		 $this->dibuja( 67,$lin, $crts_seguro_moneda); 
		 $this->dibuja( 78,$lin, $crts_dest_seguro); 
		 $this->dibuja( 97,$lin, $crts_s_dest_moneda); 
		 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja(22,$lin, $e[1]); 
		 }
		 
		 //$this->line(20, $lin-2, 104, $lin-2);
		 $lin += 6;
		 
		 $e = explode(" ", $crts_otro);
         
         $this->dibuja( 22,$lin, $e[0]); 
		 $this->dibuja( 45,$lin, $crts_otro_monto); 
		 $this->dibuja( 67,$lin, $crts_otro_moneda); 
		 $this->dibuja( 78,$lin, $crts_dest_otro); 
		 $this->dibuja( 97,$lin, $crts_o_dest_moneda); 
		 if (count($e) > 1) {
			$lin += 3;
			$this->dibuja( 22,$lin, $e[1]); 
		 }
		 //$this->line(20, $lin-2, 104, $lin-2);
		 $lin += 4;
		 
		 $this->dibuja( 22,$lin, "TOTALES"); 
         $this->dibuja( 45,$lin, $crts_otro_monto_total); 
		 $this->dibuja( 67,$lin, $crts_otro_moneda_total); 
		 $this->dibuja( 78,$lin, $crts_dest_otro_total); 
		 $this->dibuja( 97,$lin, $crts_o_dest_moneda_total); 
		 $this->line(10, $lin-8, 109, $lin-8);
		 $lin += 6;
		 
		 $col=8;
		 
		 $this->line(40-$col, 154, 40-$col, 192);
		 $this->line(60-$col, 154, 60-$col, 192);
		 $this->line(74-$col, 154, 74-$col, 192);
		 $this->line(94-$col, 154, 94-$col, 192);
           
	  }
	  
   }