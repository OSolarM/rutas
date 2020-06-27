<?php
   include_once(APP_PATH."/libs/phpmailer/class.phpmailer.php");
   
   class OrdenesAereasController extends AppController {
      var $name="OrdenesAereas";
      var $uses=array("OrdenNacional", "Institucion", "Ciudad", "Grado", "Parametro", "ListaPrecio");

      var $validate = array(
                          "orna_fecha"            => "required|type=date",
                          "orna_m3"               => "required|type=number",
                          "orna_grado"            => "required",
                          "orna_apellidos"        => "required",
                          "orna_nombres"          => "required",
                          "orna_rut"              => "required|type=rut",
                          "orna_email"            => "type=mail",
                          "orna_deposito"         => "type=number",
                          "orna_monto_dep"        => "type=number",
                          "orna_tipo_em"          => "required",
                          "orna_auto"             => "required",
                          "orna_origen"           => "required",
                          "orna_destino"          => "required",
                          "orna_repo_fecha"       => "required|type=date",
                          "orna_repo_direccion"   => "required",
                          "orna_repo_comuna"      => "required",
                          "orna_fecha_llegada"    => "type=date",
                          //"orna_direc_despacho"   => "required",
                          //"orna_comuna_despacho"  => "required",   
                          "orna_carta_m3"        => "type=number",
                          "orna_carta2_m3"       => "type=number",                        
                    );

      function index($page=1) {
         $recsXPage=10;
         
         $orna_apellidos = isset($_REQUEST["orna_apellidos"])?$_REQUEST["orna_apellidos"]:"";
         $orna_nombres   = isset($_REQUEST["orna_nombres"])?$_REQUEST["orna_nombres"]:"";
         
         $sql = "institucion_id=2 and orna_estado <>'B'";

         if ($orna_apellidos!="") $sql .=" and upper(orna_apellidos) like '".strtoupper(str_replace("'", "''", $orna_apellidos))."%'";

         if ($orna_nombres!="") $sql .=" and upper(orna_nombres) like '".strtoupper(str_replace("'", "''", $orna_nombres))."%'";

         $despliegue = $this->request("despliegue", "P");
         $this->set("despliegue", $despliegue);
         
         if ($despliegue=="P") 
            $sql .= " and (orna_nula <> 'S')";
            
         $sql .= " and orna_no_factura is null ";   
         
         //echo $sql;
         
         $arreglo = $this->OrdenNacional->findAll($sql, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);

         for ($i=0; $i < count($arreglo); $i++) 
            if ($this->Grado->findByPk($arreglo[$i]["orna_grado"]))
               $arreglo[$i]["grad_descripcion"] = $this->Grado->data["Grado"]["grad_descripcion"];
            else
               $arreglo[$i]["grad_descripcion"] = "";
        
         $pagination = new pagination("/ordenes_aereas/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         $this->assign("ordenesnacionales", $arreglo);
         $this->assign('pagination', $pagination->links());
      }

      function add() {
	 
         $this->OrdenNacional->validate = $this->validate;
	      
         $this->layout="form";

         $enviar_correo = isset($_REQUEST["enviar_correo"])?$_REQUEST["enviar_correo"]:"N";
         
         if (!empty($this->data)) {
	        $this->data["OrdenNacional"]["institucion_id"] = "2";  
	        $this->data["OrdenNacional"]["orna_cerrar"] = "N";
	        $this->data["OrdenNacional"]["orna_nula"]   = "N";
	        
	        if ($this->data["OrdenNacional"]["orna_auto"]=="S") {
		       $this->OrdenNacional->validate["orna_patente"]="required";
		       $this->OrdenNacional->validate["orna_marca"  ]="required";
		       $this->OrdenNacional->validate["orna_modelo" ]="required";		       
	        }
	           	        
            if ($this->OrdenNacional->save($this->data)) {	                                             
               $this->redirect("/ordenes_aereas");
            }
         }
         
         if (empty($this->data)) {
	        $this->data["OrdenNacional"]["institucion_id"] = "2"; 
	        $this->data["OrdenNacional"]["orna_fecha"] = date("d/m/Y");
	        $this->data["OrdenNacional"]["orna_monto_dep"] = "0";
	        $this->data["OrdenNacional"]["orna_estado"] = "I";
	        $this->data["OrdenNacional"]["orna_cerrar"] = "N";
	        $this->data["OrdenNacional"]["orna_nula"]   = "N";

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

            
         $this->set("grados", $this->Grado->getGrados(2));
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         $enviar_correo = isset($_REQUEST["enviar_correo"])?$_REQUEST["enviar_correo"]:"N";
         
         //echo "Valor de enviar_correo: $enviar_correo<br>";
         
         if (!empty($this->data)) {
            $cerrar = isset($_REQUEST["orna_cerrar"])?$_REQUEST["orna_cerrar"]:"N";

            $this->OrdenNacional->setData($this->data);

            $v1 = $this->OrdenNacional->validates();

            //$cerrar='S';
            //if ($cerrar=="S")  {
	           $this->OrdenNacional->validate["orna_fecha_llegada"  ] = "type=date";
               //$this->OrdenNacional->validate["orna_direc_despacho" ] = "required";
               //$this->OrdenNacional->validate["orna_comuna_despacho"] = "required";   
               
            if ($this->data["OrdenNacional"]["orna_auto"]=="S") {
		       $this->OrdenNacional->validate["orna_patente"]="required";
		       $this->OrdenNacional->validate["orna_marca"  ]="required";
		       $this->OrdenNacional->validate["orna_modelo" ]="required";		       
	        }
 
               $this->extraValidation();
            //}
            
            //print_r($this->OrdenNacional->errorList);
            
            if (count($this->OrdenNacional->errorList)==0) {
               $this->data["OrdenNacional"]["orna_cerrar"] = "S";

               //print_r($this->data);
               	            
               if ($this->OrdenNacional->update($this->data)) {	             
                     
	              $this->redirect("/ordenes_aereas");                   
               }
            }
            else 
               $this->data["OrdenNacional"]["orna_cerrar"] = "N";
                 
         }
         if (empty($this->data)) {
            $this->data = $this->OrdenNacional->read(null, $id);
         }
         
         $r = $this->Ciudad->findAll(null, null, "ciud_nombre");

            $lista = "|";
            foreach($r as $v) {
                if ($lista!="") $lista .= ",";

                $lista .= $v["ciud_nombre"]."|".$v["id"];
            }

            $this->set("origenes", $lista);
            $this->set("destinos", $lista);

         $this->set("grados", $this->Grado->getGrados(2));
      }

      function delete($id=null) {
	     $this->layout="index";
	      
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
         }

         $data = $this->OrdenNacional->read(null, $id);
         $data["OrdenNacional"]["orna_estado"] = "B";
         
        
         
         if ( $this->OrdenNacional->save($data)) 
            $this->redirect("/ordenes_aereas");
         else
            $this->redirect("/errores/idNotFound");
      }

      function extraValidation() {
         global $smarty;

         $d = $this->OrdenNacional->data["OrdenNacional"];
         //print_r($d);

         $orna_m3        = $d["orna_m3"]!=""?$d["orna_m3"]:0;  
         $orna_carta_no  = $d["orna_carta_no"];
         $orna_carta_m3  = $d["orna_carta_m3"]!=""?$d["orna_carta_m3"]:0;
         $orna_carta2_no = $d["orna_carta2_no"];
         $orna_carta2_m3 = $d["orna_carta2_m3"]!=""?$d["orna_carta2_m3"]:0;
         $orna_deposito  = $d["orna_deposito"];
         $orna_monto_dep = $d["orna_monto_dep"]!=""?$d["orna_monto_dep"]:0;
         $orna_valor_guia= $d["orna_valor_guia"]!=""?$d["orna_valor_guia"]:0;
         $orna_no_guia   = $d["orna_no_guia"]!=""?$d["orna_no_guia"]:0;

         $this->OrdenNacional->validates();         
         
         if ($orna_m3==0) 
            $this->OrdenNacional->errorList["orna_m3"] = "Debe ingresar los m3!";
            
         if ($orna_carta_no=="") 
            $this->OrdenNacional->errorList["orna_carta_no"] = "Debe ingresar la carta!";
         if ($orna_carta_m3==0) 
            $this->OrdenNacional->errorList["orna_carta_m3"] = "Debe ingresar los metros cubicos de la carta!";
         if ($orna_m3!=$orna_carta_m3) {
            if ($orna_carta2_no=="") 
               $this->OrdenNacional->errorList["orna_carta2_no"] = "Debe ingresar la carta 2!";
            else if ($orna_carta2_m3==0) 
               $this->OrdenNacional->errorList["orna_carta2_m3"] = "Debe ingresar los metros cubicos de la carta 2!";    
            else if ($orna_m3 != $orna_carta_m3 + $orna_carta2_m3) {
               if ($orna_deposito=="") 
                  $this->OrdenNacional->errorList["orna_deposito"] = "Debe ingresar el numero de deposito!";
               else if ($orna_monto_dep==0) 
                  $this->OrdenNacional->errorList["orna_monto_dep"] = "Debe ingresar el monto del deposito!";     
            }
            
            
         }
         
         $data = $this->Parametro->read(null, 1);
         
         $agno           = $data["Parametro"]["agno"];
         $orna_origen    = $this->data["OrdenNacional"]["orna_origen"];
         $orna_destino   = $this->data["OrdenNacional"]["orna_destino"];
         $orna_auto      = $this->data["OrdenNacional"]["orna_auto"];
         $institucion_id = $this->data["OrdenNacional"]["institucion_id"];
         
         //echo "institucion_id=$institucion_id and lista_agno=$agno and list_origen=$orna_origen and list_destino=$orna_destino and list_auto='$orna_auto'<hr>";
         $arr = $this->ListaPrecio->findAll("institucion_id=$institucion_id and lista_agno=$agno and list_origen=$orna_origen and list_destino=$orna_destino and list_auto='$orna_auto'");
         
         if (count($arr)==0)
            $this->OrdenNacional->errorList["orna_destino"] = "No encontr&eacute; el tramo en la lista de precios!";
         else {
	        $list_precio = $arr[0]["list_precio"];
	        
	        if ($orna_auto=="N") {
		       $this->data["OrdenNacional"]["orna_valor_guia"] = round($list_precio*$orna_m3/30, 0); 
	        }
	        else
	           $this->data["OrdenNacional"]["orna_valor_guia"] = $list_precio;
         }   
         
         //if ($orna_valor_guia=="" || $orna_valor_guia <= 0) 
         //   $this->OrdenNacional->errorList["orna_valor_guia"] = "Debe ingresar el valor de la guia!";     
         
         //if ($orna_no_guia=="") 
         //   $this->OrdenNacional->errorList["orna_no_guia"] = "Debe ingresar el n&uacute;mero de la guia!";     
         

         //Paso errores a smarty
         foreach($this->OrdenNacional->errorList as $key => $val)
             $smarty->assign("msg_$key", $val);

         //print_r($this->OrdenNacional->errorList);
      }
      
	  function imprimir_guia($id, $orna_no_guia) {
		 		 
		 $arr = $this->OrdenNacional->findAll("institucion_id=2 and orna_no_guia=$orna_no_guia");
		 
		 if (count($arr) > 0) {
			$this->redirect("/ordenes_aereas/guia_erronea/$orna_no_guia");
			return; 
		 }
		  
		 $this->OrdenNacional->imprimir_guia($id, $this->Institucion, $this->Ciudad, $this->Grado);		 
		 $this->set("archivo", APP_HTTP."/app/templates_c/$id".".prn");
	  }	  
	  
	  function guia_erronea($orna_no_guia) {
		 $this->set("orna_no_guia", $orna_no_guia);
      }
	  
	  function anular($id) {
		 $this->layout = "form"; 
		 
		  
		 $data = $this->OrdenNacional->read(null, $id);
		 
		 
		 
		 $data["OrdenNacional"]["orna_nula"] = "S";
		 
		 $this->OrdenNacional->save($data);
		 
		 $this->redirect("/ordenes_aereas/edit/$id");
		 
		  
      }
      
      function anular_dup($id) {
	     $this->layout="form"; 
		 $data = $this->OrdenNacional->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_nula"] = "S";
		 
		 $this->OrdenNacional->save($data);
		 
		 $data["OrdenNacional"]["orna_nula"] = "N";
		 $data["OrdenNacional"]["orna_cerrar"] = "N";
		 $data["OrdenNacional"]["orna_valor_guia"] = "";
		 $data["OrdenNacional"]["orna_no_guia"]    = "";
		 $data["OrdenNacional"]["id"] = "";
		 
		 $this->OrdenNacional->save($data);
		 
		 $this->redirect("/ordenes_aereas");
      }
      
      function ejecutar_accion() {
	     $listado     = explode(",", $_REQUEST["seleccionados"]);
	     $accionLista = $_REQUEST["accionLista"];
	     
	     print_r($_REQUEST["listado"]);
	     
	     print_r($listado)."<hr>";
	     echo $accionLista;
	     
	     switch($accionLista) {
		    case "1":
		       for ($i=0; $i < count($listado); $i++)
		          $this->enviarCorreo($listado[$i]);
		          
		       $this->redirect("/ordenes_aereas");
		       break;
	     }
      }
      
      function impresion($page=1) {
         $recsXPage=10;
         
         $orna_apellidos = isset($_REQUEST["orna_apellidos"])?$_REQUEST["orna_apellidos"]:"";
         $orna_nombres   = isset($_REQUEST["orna_nombres"])?$_REQUEST["orna_nombres"]:"";
         
         $sql = "institucion_id=2 and orna_estado <>'B' and orna_cerrar='S' and orna_no_guia is null";

         if ($orna_apellidos!="") $sql .=" and upper(orna_apellidos) like '".strtoupper(str_replace("'", "''", $orna_apellidos))."%'";

         if ($orna_nombres!="") $sql .=" and upper(orna_nombres) like '".strtoupper(str_replace("'", "''", $orna_nombres))."%'";

         $despliegue = $this->request("despliegue", "P");
         $this->set("despliegue", $despliegue);
         
         if ($despliegue=="P") 
            $sql .= " and (orna_nula <> 'S')";
         
         $arreglo = $this->OrdenNacional->findAll($sql, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);
                  
         for ($i=0; $i < count($arreglo); $i++) {
            if ($this->Grado->findByPk($arreglo[$i]["orna_grado"]))
               $arreglo[$i]["grad_descripcion"] = $this->Grado->data["Grado"]["grad_descripcion"];
            else
               $arreglo[$i]["grad_descripcion"] = "";
         
            if ($this->Ciudad->findByPk($arreglo[$i]["orna_origen"])) $arreglo[$i]["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
	         
	        if ($this->Ciudad->findByPk($arreglo[$i]["orna_destino"])) $arreglo[$i]["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];         
         }
        
         $pagination = new pagination("/ordenes_aereas/impresion", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         $this->assign("ordenesnacionales", $arreglo);
         $this->assign('pagination', $pagination->links());
      }
      
      function enviarCorreo($id) {
	     if ($this->OrdenNacional->findByPk($id))
	        $data = $this->OrdenNacional->data;
	     else {
	        $data = array();
	        return;
         }
	     
         $this->data = $data;
         
         //Si tiene carta, no se reenvía el correo
         if ($this->data["OrdenNacional"]["orna_carta_no"]!="")
            return;
         
         //print_r($this->data);
         
         $data = $this->OrdenNacional->read(null, $id);
         
         $data["OrdenNacional"]["orna_email1"] = "";
         
         $this->OrdenNacional->save($data);
         
	  }   

   }
