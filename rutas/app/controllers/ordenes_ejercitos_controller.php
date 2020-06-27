<?php
   class OrdenesEjercitosController extends AppController {
      var $name="OrdenesEjercitos";
      var $uses=array("OrdenNacional", "Institucion", "Ciudad", "Grado");
      
      var $validate = array(
                          "orna_fecha"            => "required|type=date",
                          "orna_m3"               => "required|type=number",
                          "orna_grado"            => "required",
                          "orna_apellidos"        => "required",
                          "orna_nombres"          => "required",
                          "orna_rut"              => "required",
                          "orna_deposito"         => "type=number",
                          "orna_monto_dep"        => "type=number",
                          "orna_tipo_em"          => "required",
                          "orna_auto"             => "required",
                          "orna_origen"           => "required",
                          "orna_destino"          => "required",
                          "orna_repo_fecha"       => "required|type=date",
                          "orna_repo_direccion"   => "required",
                          "orna_repo_comuna"      => "required",
                          "orna_email"            => "type=mail",
                          "orna_cant_ordenes"     => "required|type=integer",
                          //"orna_fecha_llegada"    => "required|type=date",
                          //"orna_direc_despacho"   => "required",
                          //"orna_comuna_despacho"  => "required",   
                          "orna_valor_guia" => "type=number",
                          "orna_iva"        => "type=number",
                          "orna_total"      => "type=number",                          
                    );

      function index($page=1) {
         $recsXPage=10;
         
         $orna_apellidos = isset($_REQUEST["orna_apellidos"])?$_REQUEST["orna_apellidos"]:"";
         $orna_nombres   = isset($_REQUEST["orna_nombres"])?$_REQUEST["orna_nombres"]:"";


         $sql = "institucion_id=1 and orna_estado <>'B' and orna_no_guia is null";

         if ($orna_apellidos!="") $sql .=" and upper(orna_apellidos) like '".strtoupper(str_replace("'", "''", $orna_apellidos))."%'";

         if ($orna_nombres!="") $sql .=" and upper(orna_nombres) like '".strtoupper(str_replace("'", "''", $orna_nombres))."%'";

         $despliegue = $this->request("despliegue", "P");
         $this->set("despliegue", $despliegue);
         
         if ($despliegue=="P") 
            $sql .= " and (orna_nula <> 'S')";
         
         $arreglo = $this->OrdenNacional->findAll($sql, null, "id desc", ($page-1)*$recsXPage + 1, $recsXPage);

         for ($i=0; $i < count($arreglo); $i++) 
            if ($this->Grado->findByPk($arreglo[$i]["orna_grado"]))
               $arreglo[$i]["grad_descripcion"] = $this->Grado->data["Grado"]["grad_descripcion"];
            else
               $arreglo[$i]["grad_descripcion"] = "";
         
         $pagination = new pagination("/ordenes_ejercitos/index", $page);
         
         $arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         $this->assign("ordenesnacionales", $arreglo);
         $this->assign('pagination', $pagination->links());
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
	        
	        $this->data["OrdenNacional"]["institucion_id"] = "1";  
            if ($this->OrdenNacional->save($this->data))
               $this->redirect("/ordenes_ejercitos");
         }
         
         if (empty($this->data)) {
	        $this->data["OrdenNacional"]["institucion_id"] = "1"; 
	        $this->data["OrdenNacional"]["orna_fecha"] = date("d/m/Y");
	        $this->data["OrdenNacional"]["orna_monto_dep"] = "0";
	        $this->data["OrdenNacional"]["orna_estado"] = "I";
	        $this->data["OrdenNacional"]["orna_cerrar"] = "N";
	        $this->data["OrdenNacional"]["orna_nula"]   = "N";
	        $this->data["OrdenNacional"]["orna_cant_ordenes"]   = 1;

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

            $this->set("grados", $this->Grado->getGrados(1));
        
      }

      function edit($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            //$cerrar = isset($_REQUEST["orna_cerrar"])?$_REQUEST["orna_cerrar"]:"N";

            $this->OrdenNacional->setData($this->data);

            $v1 = $this->OrdenNacional->validates();

            //if ($cerrar=="S")  {
	           $this->OrdenNacional->validate["orna_fecha_llegada"  ] = "type=date";
               //$this->OrdenNacional->validate["orna_direc_despacho" ] = "required";
               //$this->OrdenNacional->validate["orna_comuna_despacho"] = "required";   
               //$this->OrdenNacional->validate["orna_orden_flete1"   ] = "required";
               //$this->OrdenNacional->validate["orna_orden_compra"   ] = "required";
               $this->OrdenNacional->validate["orna_email"          ] = "type=mail";
               $this->OrdenNacional->validate["orna_celular"        ] = "required";
               $this->OrdenNacional->validate["orna_cant_ordenes"   ] = "required|type=integer";
               //$this->OrdenNacional->validate["orna_valor_guia"   ]   = "required|type=integer";
               //$this->OrdenNacional->validate["orna_no_guia"   ]      = "required|type=number";

 
               //$this->extraValidation();
            //}
            
            //print_r($this->OrdenNacional->errorList);
            
            $this->data["OrdenNacional"]["orna_cerrar"] = "S";
            if ($this->data["OrdenNacional"]["orna_auto"]=="S") {
		       $this->OrdenNacional->validate["orna_patente"]="required";
		       $this->OrdenNacional->validate["orna_marca"  ]="required";
		       $this->OrdenNacional->validate["orna_modelo" ]="required";		       
	        }
            
            if ($this->OrdenNacional->save($this->data)) {               
	           //if ($this->data["OrdenNacional"]["orna_carta_no"]=="") 
	           //   $this->enviarCorreo();

	           //if ($cerrar=="S")
	           //   $this->redirect("/ordenes_ejercitos/imprimir_guia/$id");
	           //else
                  $this->redirect("/ordenes_ejercitos");
               
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

          $this->set("grados", $this->Grado->getGrados(1));
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
            $this->redirect("/ordenes_ejercitos");
         else
            $this->redirect("/errores/idNotFound");
      }
      
      function enviarCorreo() {
	     return;
	     
	     $orna_nombres= $this->data["OrdenNacional"]["orna_nombres"]." ".$this->data["OrdenNacional"]["orna_apellidos"];
	     $orna_fecha  = $this->data["OrdenNacional"]["orna_repo_fecha"];
	     $orna_origen = $this->data["OrdenNacional"]["orna_origen"];
	     $orna_destino= $this->data["OrdenNacional"]["orna_destino"];
	     $orna_email  = $this->data["OrdenNacional"]["orna_email"];
	     $orna_carta_m3  = $this->data["OrdenNacional"]["orna_carta_m3"];
	     $orna_carta2_m3 = $this->data["OrdenNacional"]["orna_carta2_m3"];
	     $orna_mts       = $this->data["OrdenNacional"]["orna_m3"];
	     
	     //echo $orna_carta_m3  . "<br>";
	     //echo $orna_carta2_m3 . "<br>";
	     
	     if ($this->Ciudad->findByPk($orna_origen)) $orna_origen = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
	     
	     if ($this->Ciudad->findByPk($orna_destino)) $orna_destino = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
	     
	     $data = $this->Institucion->read(0, 2);
	     
	     $inst_correo1 = $data["Institucion"]["inst_correo1"];
	     $inst_correo2 = $data["Institucion"]["inst_correo2"];
	     $inst_texto_cliente = $data["Institucion"]["inst_texto_cliente"];
	     $inst_texto_institucion = $data["Institucion"]["inst_texto_institucion"];
	     
	     $inst_texto_cliente = str_replace('@sr',      $orna_nombres, $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@fecha',   $orna_fecha,   $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@origen',  $orna_origen,  $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@destino', $orna_destino, $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@mts',     $orna_mts,     $inst_texto_cliente);
	     
	     $inst_texto_institucion = str_replace('@sr',      $orna_nombres, $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@fecha',   $orna_fecha,   $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@origen',  $orna_origen,  $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@destino', $orna_destino, $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@mts',     $orna_mts,     $inst_texto_institucion);
	     
	     //echo $inst_texto_cliente."<br>";
	     //echo $inst_texto_institucion;
	     
	     $mail = new PHPMailer(); 
 
         //Luego tenemos que iniciar la validación por SMTP: 
         $mail->SMTPDebug = 1;
         
         $mail->IsSMTP(); 
         $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
         $mail->Username = "vchilem@gmail.com"; // Cuenta de e-mail 
         $mail->Password = "20180119"; // Password 
          
          
         $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
         $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
         $mail->Port       = 465;  
  
         $mail->From = "vchilem@gmail.com"; 
         $mail->FromName = "RutaChile S.A."; 
         $mail->Subject = "IMPORTANTE"; 
         $mail->AddAddress("vchilem@gmail.com","FUERZA AEREA DE CHILE"); 
          
         $mail->WordWrap = 100; 
          
         //$body  = "Hola, este es un…"; 
         //$body .= "<font color='red'> mensaje de prueba</font>"; 
          
         $mail->Body = $inst_texto_institucion; 
          
         //$mail->Send(); 
          
          
         // Notificamos al usuario del estado del mensaje 
          
         if(!$mail->Send()){ 
            echo "No se pudo enviar el Mensaje.<br>"; 
            echo $mail->ErrorInfo;
         }else{ 
            echo "Mensaje enviado"; 
         } 
         
         $mail = new PHPMailer(); 
 
         //Luego tenemos que iniciar la validación por SMTP: 
         $mail->SMTPDebug = 1;
         
         $mail->IsSMTP(); 
         $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
         $mail->Username = "vchilem@gmail.com"; // Cuenta de e-mail 
         $mail->Password = "20180119"; // Password 
          
          
         $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
         $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
         $mail->Port       = 465;  
  
         $mail->From = "vchilem@gmail.com"; 
         $mail->FromName = "RutaChile S.A."; 
         $mail->Subject = "IMPORTANTE"; 
         $mail->AddAddress("vchilem@gmail.com","FUERZA AEREA DE CHILE"); 
          
         $mail->WordWrap = 100; 
          
         //$body  = "Hola, este es un…"; 
         //$body .= "<font color='red'> mensaje de prueba</font>"; 
          
         $mail->Body = $inst_texto_cliente; 
          
         //$mail->Send(); 
          
          
         // Notificamos al usuario del estado del mensaje 
          
         if(!$mail->Send()){ 
            echo "No se pudo enviar el Mensaje.<br>"; 
            echo $mail->ErrorInfo;
         }else{ 
            echo "Mensaje enviado"; 
         } 
	  }   

	  function imprimir_guia($id) {
		 $data = $this->OrdenNacional->read(null, $id);
		 
		 $data = $data["OrdenNacional"];
		 
		 $orna_repo_direccion = $data["orna_repo_direccion"];
		 $orna_origen         = $data["orna_origen"];
		 $orna_apellidos      = $data["orna_apellidos"];
		 $orna_nombres        = $data["orna_nombres"];
		 $orna_direc_despacho = $data["orna_direc_despacho"];
		 $orna_destino        = $data["orna_destino"];
		 $orna_rut            = $data["orna_rut"];
		 $orna_tipo_em        = $data["orna_tipo_em"];
		 $orna_celular        = $data["orna_celular"];
		 $orna_no_guia        = $data["orna_no_guia"];
		 
		 $inst_id = 1;
		 
		 $dd = $this->Institucion->read(null, $inst_id);
		 
		 $inst_razon_social = $dd["Institucion"]["inst_razon_social"];
		 $inst_rut          = $dd["Institucion"]["inst_rut"];
		 
		 if ($this->Ciudad->findByPk($orna_origen)) $orna_origen = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 if ($this->Ciudad->findByPk($orna_destino)) $orna_destino = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 $fd = fopen(APP_PATH."/app/templates_c/$orna_no_guia".".prn", "w");
		 for ($i=0; $i < 9; $i++)
		    fputs($fd, "\r\n");
		    
		 $d = date("d");
		 $m = date("m");
		 $a = date("y");
		 
		 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		 
		 fputs($fd, str_pad("", 12).str_pad("",                  49)." ".$d."         ".str_pad($meses[$m-1],20)." ".$a."\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_razon_social,  53)." ".$orna_nombres." ".$orna_apellidos."\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_rut,           47)." ".$orna_rut."\r\n"                        );
		 fputs($fd, str_pad("", 12).str_pad($orna_repo_direccion,51)." ".$orna_direc_despacho."\r\n"             );
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad($orna_origen,        51)." ".$orna_destino."\r\n"                    );
		 fputs($fd, "\r\n");

		 fputs($fd, str_pad("", 16)."CELULAR: ".$orna_celular);
		 
		 
		 for ($i=0; $i < 10; $i++)
		    fputs($fd, "\n");     
		    
		 fputs($fd,str_pad("", 20)."Transporte de ".($orna_tipo_em=="M"?"Menajes hogar":"Enseres personales"));   
		 
		 //fputs($fd, chr(12));
		    
		 fclose($fd);
		 
		 $this->set("archivo", APP_HTTP."/app/templates_c/$id".".prn");
	  }	  
	  
	  
	  function anular($id) {
		 $this->layout = "form"; 
		 		 
		 $data = $this->OrdenNacional->read(null, $id);
		 $this->data = $this->OrdenNacional->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_nula"] = "S";
		 
		 if ($this->OrdenNacional->save($data))		 
		    $this->redirect("/ordenes_ejercitos");		 		  
      }
      
      function anular_dup($id) {
	     $this->layout="form"; 
		 $data = $this->OrdenNacional->read(null, $id);
		 
		 $this->data = $this->OrdenNacional->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_nula"] = "S";
		 
		 $this->OrdenNacional->save($data);
		 
		 $data["OrdenNacional"]["orna_nula"] = "N";
		 $data["OrdenNacional"]["orna_cerrar"] = "N";
		 $data["OrdenNacional"]["orna_valor_guia"] = "";
		 $data["OrdenNacional"]["orna_no_guia"]    = "";
		 $data["OrdenNacional"]["id"] = "";
		 
		 $this->OrdenNacional->save($data);
		 
		 $this->redirect("/ordenes_ejercitos");		  
      }      
      
      function impresion($page=1) {
         $recsXPage=10;
         
         $orna_apellidos = isset($_REQUEST["orna_apellidos"])?$_REQUEST["orna_apellidos"]:"";
         $orna_nombres   = isset($_REQUEST["orna_nombres"])?$_REQUEST["orna_nombres"]:"";
         
         $sql = "institucion_id=1 and orna_estado <>'B' and orna_cerrar='S' and orna_no_guia is null";

         if ($orna_apellidos!="") $sql .=" and upper(orna_apellidos) like '".strtoupper(str_replace("'", "''", $orna_apellidos))."%'";

         if ($orna_nombres!="") $sql .=" and upper(orna_nombres) like '".strtoupper(str_replace("'", "''", $orna_nombres))."%'";

         $despliegue = $this->request("despliegue", "P");
         $this->set("despliegue", $despliegue);
         
         if ($despliegue=="P") 
            $sql .= " and (orna_nula <> 'S')";
         
         $arreglo = $this->OrdenNacional->findAll($sql, null, "id"); //, ($page-1)*$recsXPage + 1, $recsXPage);
                  
         for ($i=0; $i < count($arreglo); $i++) {
            if ($this->Grado->findByPk($arreglo[$i]["orna_grado"]))
               $arreglo[$i]["grad_descripcion"] = $this->Grado->data["Grado"]["grad_descripcion"];
            else
               $arreglo[$i]["grad_descripcion"] = "";
         
            if ($this->Ciudad->findByPk($arreglo[$i]["orna_origen"])) $arreglo[$i]["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
	         
	        if ($this->Ciudad->findByPk($arreglo[$i]["orna_destino"])) $arreglo[$i]["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];         
         }
        
         //$pagination = new pagination("/ordenes_aereas/impresion", $page);
         
         //$arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         $this->assign("ordenesnacionales", $arreglo);
         //$this->assign('pagination', $pagination->links());
      } 
      
      function asignar_orden($page=1) {
         $recsXPage=10;
         
         $orna_apellidos = isset($_REQUEST["orna_apellidos"])?$_REQUEST["orna_apellidos"]:"";
         $orna_nombres   = isset($_REQUEST["orna_nombres"])?$_REQUEST["orna_nombres"]:"";


         $sql = "institucion_id=1 and orna_estado <>'B' and orna_cerrar='S'";

         if ($orna_apellidos!="") $sql .=" and upper(orna_apellidos) like '".strtoupper(str_replace("'", "''", $orna_apellidos))."%'";

         if ($orna_nombres!="") $sql .=" and upper(orna_nombres) like '".strtoupper(str_replace("'", "''", $orna_nombres))."%'";

         $despliegue = $this->request("despliegue", "P");
         $this->set("despliegue", $despliegue);
         
         if ($despliegue=="P") 
            $sql .= " and (orna_nula <> 'S')";
         
         $arreglo = $this->OrdenNacional->findAll($sql, null, "id desc");
         
         $ss = array();
         foreach($arreglo as $r) { 
	        $orna_cant_ordenes      = $r["orna_cant_ordenes"];	     
	        $orna_orden_flete1      = $r["orna_orden_flete1"];
	        $orna_orden_compra      = $r["orna_orden_compra"];
	        $orna_orden_flete2      = $r["orna_orden_flete2"];
	        $orna_orden_compra2     = $r["orna_orden_compra2"];	     
	        $orna_auto              = $r["orna_auto"];
	        $orna_orden_flete_auto  = $r["orna_orden_flete_auto"];
	        $orna_orden_compra_auto = $r["orna_orden_compra_auto"];
	        
	        $errorList=array();
	        
	        if ($orna_orden_flete1=="") $errorList["orna_orden_flete1"] = "Debe ingresar un valor en este campo!";
	        if ($orna_orden_compra=="") $errorList["orna_orden_compra"] = "Debe ingresar un valor en este campo!";
	     
	        if ($orna_cant_ordenes==2) {
		       if ($orna_orden_flete2=="")  $errorList["orna_orden_flete2"] = "Debe ingresar un valor en este campo!";
               if ($orna_orden_compra2=="") $errorList["orna_orden_compra2"] = "Debe ingresar un valor en este campo!";
	        }
	        
	        if ($orna_auto=="S") {
		       if ($orna_orden_flete_auto=="")  $errorList["orna_orden_flete_auto"]  = "Debe ingresar un valor en este campo!";
               if ($orna_orden_compra_auto=="") $errorList["orna_orden_compra_auto"] = "Debe ingresar un valor en este campo!";
	        }	    
	     
	        //print_r($errorList);
	        
	        if (count($errorList)>0)
               $ss[] = $r;
         } 
         
         $arreglo = $ss;

         for ($i=0; $i < count($arreglo); $i++) 
            if ($this->Grado->findByPk($arreglo[$i]["orna_grado"]))
               $arreglo[$i]["grad_descripcion"] = $this->Grado->data["Grado"]["grad_descripcion"];
            else
               $arreglo[$i]["grad_descripcion"] = "";
         
         //$pagination = new pagination("/ordenes_ejercitos/asignar_orden", $page);
         
         //$arreglo = $pagination->generate($arreglo, $this->OrdenNacional->count(), $recsXPage);
         
         $this->assign("ordenesnacionales", $arreglo);
         //$this->assign('pagination', $pagination->links());
      }
      
      function asignar_orden_compra($id) {
	     $this->OrdenNacional->validate = array("orna_cant_ordenes" => "required|userDefined=validaOrdenesCompra");
	     
	     if (!empty($this->data)) {
		    //print_r($this->data);
		    if ($this->OrdenNacional->save($this->data))
		       $this->redirect("/ordenes_ejercitos/asignar_orden");
	     }
	     	     	    	     
	     if (empty($this->data)) 
	        $this->data = $this->OrdenNacional->read(null, $id);
	        
	     $r = $this->Ciudad->findAll(null, null, "ciud_nombre");

         $lista = "|";
         foreach($r as $v) {
             if ($lista!="") $lista .= ",";

             $lista .= $v["ciud_nombre"]."|".$v["id"];
         }

         $this->set("origenes", $lista);
         $this->set("destinos", $lista);

         $this->set("grados", $this->Grado->getGrados(1));
      }
   }
