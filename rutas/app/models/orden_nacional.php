<?php
   include_once(APP_PATH."/libs/goodies/enletras.php");
   
   class OrdenNacional extends AppModel {
      var $name    ="OrdenNacional";
      var $useTable="ordenes_nacionales";
      var $uses    = array("Institucion");
      var $belongsTo = array(
                         "Institucion" => array("className"  => "Institucion", 
                                                "foreignKey" => "institucion_id", 
                                                "fields"     => array("inst_razon_social"
                                                                     ,"inst_rut"
                                                                     ,"inst_correo1"
	                                                                 ,"inst_correo2"
	                                                                 ,"inst_texto_cliente"
	                                                                 ,"inst_texto_institucion"
	                                                                 ,"inst_texto_ok"
	                                                                 ,"inst_texto_no_ok")
                                                ),
                         "Ciudad"      => array("className"  => "Ciudad", 
                                                "foreignKey" => "orna_origen", 
                                                "fields"     => array("ciud_nombre")
                                                ),
                         "Destino"     => array("className"  => "Ciudad", 
                                                "foreignKey" => "orna_destino", 
                                                "fields"     => array("ciud_nombre")
                                                ),
                         "Grado"       => array("className"  => "Grado",
                                                "foreignKey" => "orna_grado",
                                                "fields"     => array("grad_descripcion")
                                                ),
                       );
                             
      
      var $validate= array (
         "institucion_id"       => "type=integer",
         "orna_fecha"           => "required|type=date",
         "orden_id"             => "type=integer",
         "orna_m3"              => "required|type=number",
         "orna_grado"           => "required",
         "orna_rut"             => "required|type=rut",
         "orna_tipo_em"         => "required",
         "orna_carta_m3"        => "type=number",
         "orna_carta2_m3"       => "type=number",
         "orna_origen"          => "required|type=integer",
         "orna_destino"         => "required|type=integer",
         "orna_repo_fecha"      => "type=date|userDefined=valRepoFecha",
         "orna_estado"          => "required",
         "orna_fecha_llegada"      => "type=date|userDefined=valFechaLlegada",
      );
      
      function OrdenNacional() {
	     parent::Model();
	     
	     include_once(APP_PATH."/app/models/orden_compra.php");
      }
      
      function save($oData) {	     
	     $id                    = $oData["OrdenNacional"]["id"];
	     $orna_email1           = $oData["OrdenNacional"]["orna_email1"];
	     $orna_email2           = $oData["OrdenNacional"]["orna_email2"];
	     $orna_email3           = $oData["OrdenNacional"]["orna_email3"];
	     $institucion_id        = $oData["OrdenNacional"]["institucion_id"];
	     $orna_orden_compra     = $oData["OrdenNacional"]["orna_orden_compra"];
	     $orna_orden_compra2    = $oData["OrdenNacional"]["orna_orden_compra2"];
	     $orna_orden_flete1     = $oData["OrdenNacional"]["orna_orden_flete1"];
	     $orna_orden_flete2     = $oData["OrdenNacional"]["orna_orden_flete2"];
	     $orna_cant_ordenes     = $oData["OrdenNacional"]["orna_cant_ordenes"];
	     $orna_orden_flete_auto = $oData["OrdenNacional"]["orna_orden_flete_auto" ];
	     $orna_orden_compra_auto= $oData["OrdenNacional"]["orna_orden_compra_auto"];
	     $orna_carta_no         = $oData["OrdenNacional"]["orna_carta_no" ];
	     $orna_carta_m3         = $oData["OrdenNacional"]["orna_carta_m3" ];
	     $orna_carta2_no        = $oData["OrdenNacional"]["orna_carta2_no"];
	     $orna_carta2_m3        = $oData["OrdenNacional"]["orna_carta2_m3"];
	     $institucion_id        = $oData["OrdenNacional"]["institucion_id"];
	     
	     $t = parent::save($oData);
	     
	     if (!$t) return $t;
	     
	     if ($id=="")
            $id = $this->tbl->insertId();
         
         //echo "$institucion_id $orna_email1 $orna_carta_no $orna_carta2_no<hr>";
         
	     if ($orna_email1!="S") {
		    if ($institucion_id==1 && ($orna_orden_compra=="" || $orna_orden_compra2=="")) {			
		       $this->enviarCorreo($id, 1);
		    }
		    elseif ($institucion_id==2 && ($orna_carta_no=="" || $orna_carta2_no=="")) {
		       //Fuerza Aérea
		       $this->enviarCorreo($id, 1);
		    }
	     }
	     elseif ($orna_email2!="S") {
		    if ($institucion_id==1 && $orna_email2!="S"  && ($orna_orden_compra=="" || $orna_orden_compra2=="")) {			
			//echo "Voy a mandar correo22 $id!";
			
		       $this->enviarCorreo($id, 2);
		    }
		    elseif ($institucion_id==2 && $orna_email2!="S" && ($orna_carta_no=="" || $orna_carta2_no=="") ) {
		       //Fuerza Aérea
		       $this->enviarCorreo($id, 2);
		    }
	     }

	     	     	     
	     return $t;
      }   
      
     function enviarCorreo($id, $orden=1) {
	     //echo "Entre en enviarCorreo: $id, $orden";
	     
	     $data = $this->read(null, $id);
               
         $data["OrdenNacional"]["orna_email$orden"]="S";
               
         // print_r($data);
         $this->save($data);
	     
         $data = $this->findAll("id=$id");
         
         if (count($data)==0) return;
         
         $data = $data[0];
                 
	     $orna_nombres   = $data["orna_nombres"]." ".$this->data["OrdenNacional"]["orna_apellidos"];
	     $orna_fecha     = $data["orna_repo_fecha"];
	     $orna_origen    = $data["orna_origen"];
	     $orna_destino   = $data["orna_destino"];
	     $orna_email     = $data["orna_email"];
	     
	     if ($orna_email=="") return;
	     
	     $orna_carta_m3  = $data["orna_carta_m3"];
	     $orna_carta2_m3 = $data["orna_carta2_m3"];
	     $orna_mts       = $data["orna_m3"];
	     $orna_origen    = $data["ciud_nombre"];
	     $orna_destino   = $data["ciud_nombre_a"];
	     	     
	     $inst_correo1 = $data["inst_correo1"];
	     $inst_correo2 = $data["inst_correo2"];
	     
	     //$inst_correo1 = "vchilem@gmail.com";
	     //$inst_correo2 = "vchilem@gmail.com";
	        
	     if ($orden==1) {
	        $inst_texto_cliente = $data["inst_texto_cliente"];
	        $inst_texto_institucion = $data["inst_texto_institucion"];
         }
	     elseif ($orden==2) {
		    $inst_texto_cliente     = $data["inst_texto_no_ok"];
            $inst_texto_institucion = "";
	     }
	     elseif ($orden==3) {
		    $inst_texto_cliente     = $data["inst_texto_no_ok"];
            $inst_texto_institucion = "";		     
	     }
	     
	     $inst_texto_cliente = str_replace('@SR',      $orna_nombres, $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@FECHA',   $orna_fecha,   $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@ORIGEN',  $orna_origen,  $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@DESTINO', $orna_destino, $inst_texto_cliente);
	     $inst_texto_cliente = str_replace('@MTS',     $orna_mts,     $inst_texto_cliente);
	     
	     $inst_texto_institucion = str_replace('@SR',      $orna_nombres, $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@FECHA',   $orna_fecha,   $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@ORIGEN',  $orna_origen,  $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@DESTINO', $orna_destino, $inst_texto_institucion);
	     $inst_texto_institucion = str_replace('@MTS',     $orna_mts,     $inst_texto_institucion);
	     
	     //echo $inst_texto_cliente."<br>";
	     //echo $inst_texto_institucion;
	     
	     if ($inst_texto_institucion!="") {
	        $mail = new PHPMailer(); 
            
            //Luego tenemos que iniciar la validación por SMTP: 
            $mail->SMTPDebug = 1;
            
            $mail->IsSMTP(); 
            $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
            $mail->Username = "vchilem@gmail.com"; // Cuenta de e-mail 
            $mail->Password = "osm_segundo"; // Password 
             
             
            $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
            $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
            $mail->Port       = 465;  
            
            $mail->From = "vchilem@gmail.com"; 
            $mail->FromName = "RutaChile S.A."; 
            $mail->Subject = "IMPORTANTE"; 
            $mail->AddAddress($inst_correo1,"FUERZA AEREA DE CHILE"); 
            $mail->AddAddress($inst_correo2,"FUERZA AEREA DE CHILE"); 
            //$mail->AddAddress("nicolas@ruta-chile.com","RUTA CHILE"); 
             
            $mail->WordWrap = 100; 
             
            //$body  = "Hola, este es un…"; 
            //$body .= "<font color='red'> mensaje de prueba</font>"; 
             
            $mail->Body = strtoupper($inst_texto_institucion); 
             
            //$mail->Send(); 
             
             
            // Notificamos al usuario del estado del mensaje 
             
            if(!$mail->Send()){ 
               echo "No se pudo enviar el Mensaje.<br>"; 
               echo $mail->ErrorInfo;
            }else{ 
               echo "Mensaje enviado"; 
            } 
         }
                  
         $mail = new PHPMailer(); 
 
         //Luego tenemos que iniciar la validación por SMTP: 
         $mail->SMTPDebug = 1;
         
         $mail->IsSMTP(); 
         $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
         $mail->Username = "vchilem@gmail.com"; // Cuenta de e-mail 
         $mail->Password = "osm_segundo"; // Password 
          
          
         $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
         $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
         $mail->Port       = 465;  
  
         $mail->From = "vchilem@gmail.com"; 
         $mail->FromName = "RutaChile S.A."; 
         $mail->Subject = "IMPORTANTE"; 
         $mail->AddAddress($orna_email, $orna_nombres); 
         //$mail->AddAddress("nicolas@ruta-chile.com","RUTA CHILE"); 
         //$mail->AddAddress("vchilem@gmail.com","RUTA CHILE"); 
          
         $mail->WordWrap = 100; 
          
         //$body  = "Hola, este es un…"; 
         //$body .= "<font color='red'> mensaje de prueba</font>"; 
          
         $mail->Body = strtoupper($inst_texto_cliente); 
          
         //$mail->Send(); 
          
          
         // Notificamos al usuario del estado del mensaje 
          
         if(!$mail->Send()){ 
            echo "No se pudo enviar el Mensaje.<br>"; 
            echo $mail->ErrorInfo;
         }else{ 
            echo "Mensaje enviado"; 
            
            echo "id: $id<hr>";
            if ($id!="") {
               //$data = $this->read(null, $id);
               
               //$data["OrdenNacional"]["orna_email$orden"]="S";
               
              // print_r($data);
              // $this->update($data);
            }
         } 
	  }   

      
      function validaOrdenesCompra($cant) {
	     $orna_cant_ordenes      = $cant;	     
	     $orna_orden_flete1      = $this->data["OrdenNacional"]["orna_orden_flete1"];
	     $orna_orden_compra      = $this->data["OrdenNacional"]["orna_orden_compra"];
	     $orna_orden_flete2      = $this->data["OrdenNacional"]["orna_orden_flete2"];
	     $orna_orden_compra2     = $this->data["OrdenNacional"]["orna_orden_compra2"];	     
	     $orna_auto              = $this->data["OrdenNacional"]["orna_auto"];
	     $orna_orden_flete_auto  = $this->data["OrdenNacional"]["orna_orden_flete_auto"];
	     $orna_orden_compra_auto = $this->data["OrdenNacional"]["orna_orden_compra_auto"];
	     
	     if ($orna_orden_flete1=="") $this->errorList["orna_orden_flete1"] = "Debe ingresar un valor en este campo!";
	     if ($orna_orden_compra=="") $this->errorList["orna_orden_compra"] = "Debe ingresar un valor en este campo!";
	     
	     if ($orna_cant_ordenes==2) {
		    if ($orna_orden_flete2=="") $this->errorList["orna_orden_flete2"] = "Debe ingresar un valor en este campo!";
            if ($orna_orden_compra2=="") $this->errorList["orna_orden_compra2"] = "Debe ingresar un valor en este campo!";
	     }
	     
	     if ($orna_auto=="S") {
		    if ($orna_orden_flete_auto=="")  $this->errorList["orna_orden_flete_auto"]  = "Debe ingresar un valor en este campo!";
            if ($orna_orden_compra_auto=="") $this->errorList["orna_orden_compra_auto"] = "Debe ingresar un valor en este campo!";
	     }	     	     
      }

      function getNumRetiros($fecha, $id=null) {
         $f = substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);

         if ($id==null)
            $arr = $this->findAll("orna_repo_fecha=$f");   
         else
            $arr = $this->findAll("orna_repo_fecha=$f and id<>$id");  

         return 5 - count($arr);
      }

      function getNumLlegadas($fecha, $id) {
         $f = substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);

         if ($id==null)
            $arr = $this->findAll("orna_fecha_llegada=$f");   
         else
            $arr = $this->findAll("orna_fecha_llegada=$f and id<>$id");

         return 3 - count($arr);
      }

      function valRepoFecha($valor) {
         if (trim($valor)=="") return;

         $id = $this->data["OrdenNacional"]["id"];

         $n = $this->getNumRetiros($valor, $id);

         if ($n==0)
            $this->errorList["orna_repo_fecha"] = "Fecha retiro no disponible";

         
      }

      function valFechaLlegada($valor) {
         if (trim($valor)=="") return;

         $id = $this->data["OrdenNacional"]["id"];

         $n = $this->getNumLlegadas($valor, $id);

         if ($n==0)
            $this->errorList["orna_fecha_llegada"] = "Fecha llegada no disponible";
         
      }
      
      function imprimir_guia($id, $orna_no_guia, $Institucion, $Ciudad, $Grado, $Particular) {	      
		 $data = $this->read(null, $id);
		 
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
		 //$orna_no_guia        = $data["orna_no_guia"];		 
		 $inst_id             = $data["institucion_id"];
		 $orna_orden_compra   = $data["orna_orden_compra"];
		 $orna_repo_fecha     = $data["orna_repo_fecha"];
		 
		 $orna_grado          = $data["orna_grado"];
		 
		 $particular_id       = $data["particular_id"];
		 
		 if ($orna_grado!="") {		    
		    $g = $Grado->read(null, $orna_grado);
		    
		    $grad_descripcion = $g["Grado"]["grad_descripcion"];
	     }
	     else
	        $grad_descripcion="";
		 
		 $dd = $Institucion->read(null, $inst_id);
		 
		 $inst_razon_social = $dd["Institucion"]["inst_razon_social"];
		 $inst_rut          = $dd["Institucion"]["inst_rut"];
		 
		 
		 if ($particular_id!="") {
			$p = $Particular->read(null, $particular_id);
			$inst_razon_social   = $p["Particular"]["razon"];;
		    $inst_rut            = $p["Particular"]["rut"];
		    
		    /*
		    $orna_repo_direccion = $p["Particular"]["direccion"];
		    $orna_origen         = $p["Particular"]["comuna"]." ".$p["Particular"]["ciudad"];
		    
		    if (strlen($orna_repo_direccion) > 33) {
			   $orna_origen = substr($orna_repo_direccion, 33)." ".$p["Particular"]["ciudad"];
			   $orna_repo_direccion = substr($orna_repo_direccion, 0, 33);
		    }
		    */
			
		 }
		 
		 if ($Ciudad->findByPk($orna_origen)) $orna_origen = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 if ($Ciudad->findByPk($orna_destino)) $orna_destino = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 $orna_repo_direccion .= " ".$orna_origen;
		 $orna_direc_despacho .= " ".$orna_destino;
		 
		 if (strlen($orna_repo_direccion) > 33) {
			$orna_origen = substr($orna_repo_direccion, 33);
			$orna_repo_direccion = substr($orna_repo_direccion, 0, 33);
		 }
		 
		 if (strlen($orna_direc_despacho) > 30) {
			$orna_destino = substr($orna_direc_despacho, 30);
			$orna_direc_despacho = substr($orna_direc_despacho, 0, 30);
		 }
		 
		 //echo "<hr>".APP_PATH."/app/templates_c/$orna_no_guia".".prn";
		 $fd = fopen(APP_PATH."/app/templates_c/$orna_no_guia".".prn", "w");
		 for ($i=0; $i < 3; $i++)
		    fputs($fd, "\r\n");
		    
		 fputs($fd, str_pad("", 12).str_pad("",                  59)." "." "."         ".str_pad($orna_no_guia, 6, "0", STR_PAD_LEFT)."\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad("",                  39)." "." "."         ".$orna_orden_compra."\r\n");
		    
		 for ($i=0; $i < 1; $i++)
		    fputs($fd, "\r\n");
		    
		  //  0123456789
		  //  dd/mm/yyyy
		 $d = substr($orna_repo_fecha, 0, 2);
		 $m = substr($orna_repo_fecha, 3, 2);
		 $a = substr($orna_repo_fecha, 8, 2);
		 
		 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		 
		 fputs($fd, str_pad("", 12).str_pad("",                  49)." ".$d."         ".str_pad($meses[$m-1],20)." ".$a."\r\n");
		 fputs($fd, str_pad("", 66).$grad_descripcion."\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_razon_social,  53)." ".substr($orna_nombres." ".$orna_apellidos, 0, 29)."\r\n\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_rut,           47)." ".$orna_rut."\r\n"                        );
		 fputs($fd, str_pad("", 12).str_pad($orna_repo_direccion,51)." ".substr($orna_direc_despacho, 0, 30)."\r\n"             );
		 //fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad($orna_origen,        51)." ".$orna_destino."\r\n"                    );
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 16)."CELULAR: ".$orna_celular."\r\n");
		 		 
		 for ($i=0; $i < 10; $i++)
		    fputs($fd, "\r\n");     
		    
		 //if (!($inst_id==3 && trim($orna_direc_despacho)==""))
		 
		 switch($orna_tipo_em) {
			case "M": $mensaje = "Menaje hogar"; break;
			case "E": $mensaje = "Enseres personales"; break;
			case "C": $mensaje = "Traslado de Mercaderias"; break;
			case "A": $mensaje = "Solo automovil"; break;
			default : $mensaje = "******"; break;
		 }
		 
		 fputs($fd,str_pad("", 20)."Transporte de ".$mensaje);   
		 
		 //fputs($fd, chr(12));
		    
		 fclose($fd);
		 
		 $data = $this->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_no_guia"] = $orna_no_guia;
		 
		 $this->validate=array();
		 
		 $this->save($data);		 		
	  }	
	  
      function imprimir_guia_auto($id, $orna_no_guia, $Institucion, $Ciudad, $Grado) {	      
		 $data = $this->read(null, $id);
		 
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
		 //$orna_no_guia        = $data["orna_no_guia"];		 
		 $inst_id             = $data["institucion_id"];
		 $orna_orden_compra   = $data["orna_orden_compra"];
		 $orna_repo_fecha     = $data["orna_repo_fecha"];
		 
		 $orna_grado          = $data["orna_grado"];
		 
		 if ($orna_grado!="") {		    
		    $g = $Grado->read(null, $orna_grado);
		    
		    $grad_descripcion = $g["Grado"]["grad_descripcion"];
	     }
	     else
	        $grad_descripcion="";
		 
		 $orna_patente        = $data["orna_patente"];
		 $orna_marca          = $data["orna_marca"  ];
		 $orna_modelo         = $data["orna_modelo" ];
		 
		 
		 
		 $dd = $Institucion->read(null, $inst_id);
		 
		 $inst_razon_social = $dd["Institucion"]["inst_razon_social"];
		 $inst_rut          = $dd["Institucion"]["inst_rut"];
		 
		 if ($Ciudad->findByPk($orna_origen)) $orna_origen = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 if ($Ciudad->findByPk($orna_destino)) $orna_destino = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 //echo "<hr>".APP_PATH."/app/templates_c/$orna_no_guia".".prn";
		 $fd = fopen(APP_PATH."/app/templates_c/$orna_no_guia".".prn", "w");
		 for ($i=0; $i < 3; $i++)
		    fputs($fd, "\r\n");
		    
		 fputs($fd, str_pad("", 12).str_pad("",                  59)." "." "."         ".str_pad($orna_no_guia, 6, "0", STR_PAD_LEFT)."\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad("",                  39)." "." "."         ".$orna_orden_compra."\r\n");
		    
		 for ($i=0; $i < 1; $i++)
		    fputs($fd, "\r\n");
		    
			  //  0123456789
		  //  dd/mm/yyyy
		 $d = substr($orna_repo_fecha, 0, 2);
		 $m = substr($orna_repo_fecha, 3, 2);
		 $a = substr($orna_repo_fecha, 8, 2);
		 
		 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		 
		 fputs($fd, str_pad("", 12).str_pad("",                  49)." ".$d."         ".str_pad($meses[$m-1],20)." ".$a."\r\n");
		 fputs($fd, str_pad("", 66).$grad_descripcion."\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_razon_social,  53)." ".substr($orna_nombres." ".$orna_apellidos, 0, 29)."\r\n\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_rut,           47)." ".$orna_rut."\r\n"                        );
		 fputs($fd, str_pad("", 12).str_pad($orna_repo_direccion,51)." ".substr($orna_direc_despacho, 0, 29)."\r\n"             );
		 //fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad($orna_origen,        51)." ".$orna_destino."\r\n"                    );
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 16)."CELULAR: ".$orna_celular."\r\n");
		 		 
		 for ($i=0; $i < 10; $i++)
		    fputs($fd, "\r\n");     
		    
		 fputs($fd,str_pad("", 20)."Transporte de automovil patente: $orna_patente, marca: $orna_marca, modelo: $orna_modelo");   
		 
		 //fputs($fd, chr(12));
		    
		 fclose($fd);
		 
		 $data = $this->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_no_guia"] = $orna_no_guia;
		 
		 $this->validate=array();
		 
		 $this->save($data);		 		
	  }	  
	  
	  function imprimir_factura_old($id, $orna_no_factura, $Institucion, $Ciudad, $Grado, $OrdenCompra) {	      
		 $data = $this->read(null, $id);
		 
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
		 //$orna_no_factura        = $data["orna_no_factura"];		 
		 $inst_id             = $data["institucion_id"];
		 $orna_orden_compra   = $data["orna_orden_compra"];
		 
		 
		 
		 $orna_grado          = $data["orna_grado"];
		 
		 $g = $Grado->read(null, $orna_grado);
		 
		 $grad_descripcion = $g["Grado"]["grad_descripcion"];
		 
		 $dd = $Institucion->read(null, $inst_id);
		 
		 $inst_razon_social = $dd["Institucion"]["inst_razon_social"];
		 $inst_rut          = $dd["Institucion"]["inst_rut"];
		 
		 if ($Ciudad->findByPk($orna_origen)) $orna_origen = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 if ($Ciudad->findByPk($orna_destino)) $orna_destino = $Ciudad->data["Ciudad"]["ciud_nombre"];
		 
		 //echo "<hr>".APP_PATH."/app/templates_c/$orna_no_factura".".prn";
		 $fd = fopen(APP_PATH."/app/templates_c/$orna_no_factura".".prn", "w");
		 for ($i=0; $i < 3; $i++)
		    fputs($fd, "\r\n");
		    
		 fputs($fd, str_pad("", 12).str_pad("",                  59)." "." "."         ".str_pad($orna_no_factura, 6, "0", STR_PAD_LEFT)."\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad("",                  39)." "." "."         ".$orna_orden_compra."\r\n");
		    
		 for ($i=0; $i < 1; $i++)
		    fputs($fd, "\r\n");
		    
		 $d = date("d");
		 $m = date("m");
		 $a = date("y");
		 
		 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		 
		 fputs($fd, str_pad("", 12).str_pad("",                  49)." ".$d."         ".str_pad($meses[$m-1],20)." ".$a."\r\n");
		 fputs($fd, str_pad("", 66).$grad_descripcion."\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_razon_social,  53)." ".substr($orna_nombres." ".$orna_apellidos, 0, 29)."\r\n\r\n");
		 fputs($fd, str_pad("", 12).str_pad($inst_rut,           47)." ".$orna_rut."\r\n"                        );
		 fputs($fd, str_pad("", 12).str_pad($orna_repo_direccion,51)." ".substr($orna_direc_despacho, 0, 29)."\r\n"             );
		 //fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 12).str_pad($orna_origen,        51)." ".$orna_destino."\r\n"                    );
		 fputs($fd, "\r\n");
		 fputs($fd, str_pad("", 16)."CELULAR: ".$orna_celular."\r\n");
		 		 
		 for ($i=0; $i < 10; $i++)
		    fputs($fd, "\r\n");     
		    
		 fputs($fd,str_pad("", 20)."Transporte de ".($orna_tipo_em=="M"?"Menajes hogar":"Enseres personales"));   
		 
		 //fputs($fd, chr(12));
		    
		 fclose($fd);
		 
		 $data = $this->read(null, $id);
		 
		 $data["OrdenNacional"]["orna_no_factura"] = $orna_no_factura;
		 
		 $this->validate=array();
		 
		 $this->save($data);		 		
	  }	

	  
	  function chkNoGuia($orna_no_guia) {
		 $arr = $this->findAll("orna_no_guia=$orna_no_guia");
		       
		 if (count($arr) > 0)
		    $this->errorList["orna_no_guia"] = "N&uacute;mero de Gu&iacute;a ya ha sido utilizado!";
	  }
	  
	  function chkNoFactura($orna_no_factura) {
		 $arr = $this->findAll("orna_no_factura=$orna_no_factura");
		       
		 if (count($arr) > 0)
		    $this->errorList["orna_no_factura"] = "N&uacute;mero de Factura ya ha sido utilizado!";
	  }
	  
	  function chkOrdenCompra($orna_orden_compra) {
		 if ($orna_orden_compra=="")  return;

		 $institucion_id = $this->data["OrdenNacional"]["institucion_id"];
		 
		 if ($institucion_id=="") return;
		 
		 $arr = $this->findAll("institucion_id=$institucion_id and orna_orden_compra='$orna_orden_compra'");
		       
		 if (count($arr)==0)
		    $this->errorList["orna_orden_compra"] = "Orden de Compra no existe!";		 
	  }  
	  
	  function listadoGuias($orna_no_guia) {
		 $arr = $this->findAll("institucion_id in (1, 2, 3) and orna_cerrar='S' and orna_nula<> 'S' and (orna_no_guia is null or orna_no_guia=0)", null, "id, institucion_id");
		 
		 $fd = fopen(APP_PATH."/app/templates_c/listado_guias.txt", "w");
		 if (count($arr) > 0) {
			
		
			foreach($arr as $r) {
			   //print_r($r);
			   
			   echo $orna_no_guia."<hr>";
			   $lista  = $r["inst_razon_social"].";".
			             $r["grad_descripcion"].";".
			             $r["orna_apellidos"].";".
			             $r["orna_nombres"].";".
			             $r["ciud_nombre"].";".
			             $r["ciud_nombre_a"].";".
			             $r["orna_fecha"].";".			             
			             $r["id"].";".
			             $orna_no_guia++;
			             
			   fputs($fd, $lista."\r\n");  			             			            				  			   
			}						
		 }
		 
		 fclose($fd);
	  }
	  
	  function afterValidates() {
		 return;
		 
		 $oc = new OrdenCompra();
		 
		 $errorList = parent::validates();
		 
		 $institucion_id     = $this->data["OrdenNacional"]["institucion_id"    ];
		 $orna_orden_compra  = $this->data["OrdenNacional"]["orna_orden_compra" ];
		 $orna_orden_compra2 = $this->data["OrdenNacional"]["orna_orden_compra2"];
		 
		 if ($institucion_id!="" && $orna_orden_compra!="") {
			$arr = $oc->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra'");
			
			if (count($arr)==0 && !isset($this->errorList["orna_orden_compra"]))
			   $this->errorList["orna_orden_compra"] = "Orden de compra no existe!";
		 }
		 
		 if ($institucion_id!="" && $orna_orden_compra2!="") {
			$arr = $oc->findAll("institucion_id=$institucion_id and orco_orden_compra='$orna_orden_compra2'");
			
			if (count($arr)==0 && !isset($this->errorList["orna_orden_compra2"]))
			   $this->errorList["orna_orden_compra2"] = "Orden de compra no existe!";
		 } 		 
	  }
	  
	  function imprimir_factura($orna_no_compra, $id, $orna_no_factura, $Institucion, $Ciudad, $Grado, $OrdenNacional, $concepto, $direccion, $inst_razon_social, $inst_rut, $neto, $iva, $total) {	 
		 echo $orna_no_compra."<hr>";
		  
		 
		 $ss = file_get_contents(APP_PATH."/app/templates/ordenes_nacionales/factu_nac.fto");    
		 
		 //print_r($ss);
		 
		 if ($orna_no_compra!="")
		    $arr = $OrdenNacional->findAll("orna_orden_compra='$orna_no_compra'");
		 elseif ($id!="")
		    $arr = $OrdenNacional->findAll("id=$id");
		    
		 $orna_terceros = $arr[0]["orna_terceros"];   
		    
		 
		 $sTotal = strtoupper(num2letras($total, false, false));
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
		 
		 $direc1=$direccion;
		 $direc2="";
		 $lon = strlen("inst_direccion--------------------------------") + 1;
		 
		 if (strlen($direccion) > $lon) {
			$i = $lon-1;
			
			while (substr($direccion, $i, 1)!=" ") {
			   //echo substr($direccion, 0, $i)."<br/>";
			   $i--;
			}
			
			$direc2  = ltrim(substr($direccion, $i));
			$direc1  = ltrim(substr($direccion, 0, $i));
		 }
		 		    		 
		 $cont = array();
		 $cont["no_factu"                                       ] = $orna_no_factura;
		 $cont["dd"                                             ] = date("d");
		 $cont["mes------"                                      ] = strtoupper(mesPal(date("m")*1.0));
		 $cont["agno"                                           ] = date("y");
		 $cont["inst_razon_social"                              ] = $inst_razon_social;
		 $cont["inst_direccion--------------------------------" ] = $direc1;
		 $cont["inst_direccion2-------------------------------" ] = $direc2;
		 $cont["inst_rut"                                       ] = $inst_rut;
		 
		 if ($orna_terceros=="S") {
		    $cont["origen"                                         ] = "";
		    $cont["destino"                                        ] = "";			 
		 }
		 else {
		    $cont["origen"                                         ] = $arr[0]["ciud_nombre"];
		    $cont["destino"                                        ] = $arr[0]["ciud_nombre_a"];
	     }
	     
		 $cont["orna_no_guia"                                   ] = "";
		 $cont["monto_neto"                                     ] = "";
		 $cont["neto"                                           ] = str_pad(number_format($neto,  0, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["iva"                                            ] = str_pad(number_format($iva,   0, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["total"                                          ] = str_pad(number_format($total, 0, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["monto_pal--------------------------------------"] = $sTotal;
		 $cont["monto_pal2-------------------------------------"] = $sTotal2;
		 
		 $concepto = explode("\n", $concepto);
		 //print_r($concepto);
		 
		 for ($i=0; $i < count($concepto); $i++)
		    $cont["texto$i"] = $concepto[$i];
		    
		 while ($i < 10) {
			$cont["texto$i"] = ""; 
			$i++;
	     }
	     
		 
			
			foreach($cont as $c => $value) {
			   $cc = "@".$c;
			  
			   
			   if (strlen($cc) > strlen($value)) 
			      $largo = strlen($c);
			   else
			      $largo = strlen($value);
			      
			   $valor = str_pad($value, $largo, ' ', STR_PAD_RIGHT);
			   
			   $ss = str_replace('@'.$c, $valor, $ss);
			   
			}
			
			
			
			echo $ss."<hr/>";
			
			$fd = fopen(APP_PATH."/app/templates_c/$orna_no_factura".".fac", "w");
		
		    fputs($fd, $ss);
		
		    fclose($fd);
		 

	  }	
	  
	  //($id, $no_factura, $Crt, $Cliente, $desde, $hasta, $fpago, $fec_factura, $concepto)
	  
	  function imprimir_facturaEx($id, $no_factura, $fec_factura, $Crt, $Cliente, $origen, $destino, $fpago, $fec_factura2, $concepto) {	  
		 $ss = file_get_contents(APP_PATH."/app/templates/ordenes_nacionales/factu.fto");    
		 
		 //print_r($ss);
		 
		 $data = $Crt->read(null, $id);
		 
		 $crts_valor_flete = $this->reparaValor($data["Crt"]["crts_valor_flete"]);
		 $crts_mon_flete   = $data["Crt"]["crts_mon_flete"];
		 
		 
		 $facturar_id      = $data["Crt"]["facturar_id"];
		 
		 $dd = $Cliente->read(null, $facturar_id);
		 
		 $razon            = $dd["Cliente"]["razon"];
		 $direccion        = $dd["Cliente"]["direccion"]." ".
		                     $dd["Cliente"]["comuna"]." ".
		                     $dd["Cliente"]["ciudad"]." ".
		                     $dd["Cliente"]["pais"]." ";
		 $rut              = $dd["Cliente"]["rut"];
		 
		 
		 $neto = $crts_valor_flete;
		 $iva  = round($neto*0.0, 2);
		 $total= $neto + $iva;
		 
		 $sTotal = "SON: ".strtoupper(num2letras_int($crts_valor_flete, false, true)).".-";
		 $sTotal2="";
		 
		 $lon = strlen("monto_pal---------------------------------------------------") + 1;
		 
		 if (strlen($sTotal) > $lon) {
			$i = $lon-1;
			
			while (substr($sTotal, $i, 1)!=" ") {
			   echo substr($sTotal, 0, $i)."<br/>";
			   $i--;
			}
			
			$sTotal2 = ltrim(substr($sTotal, $i));
			$sTotal  = ltrim(substr($sTotal, 0, $i));
		 }
		 		    		 
		 
		 
		 $direc1=$direccion;
		 $direc2="";
		 $lon = strlen("inst_direccion--------------------------------") + 1;
		 
		 if (strlen($direccion) > $lon) {
			$i = $lon-1;
			
			while (substr($direccion, $i, 1)!=" ") {
			   //echo substr($direccion, 0, $i)."<br/>";
			   $i--;
			}
			
			$direc2  = ltrim(substr($direccion, $i));
			$direc1  = ltrim(substr($direccion, 0, $i));
		 }
		 
		 $dia_fact = substr($fec_factura, 0, 2);
		 $mes_fact = substr($fec_factura, 3, 2);
		 $agno_fact= substr($fec_factura, 6, 4);
		 
		 $cont = array();
		 $cont["no_factu"                                       ] = $no_factura;
		 $cont["dd"                                             ] = $dia_fact;
		 $cont["mes------"                                      ] = strtoupper(mesPal($mes_fact*1.0));
		 $cont["agno"                                           ] = $agno_fact;
		 $cont["inst_razon_social"                              ] = $razon;
		 $cont["inst_direccion--------------------------------" ] = $direc1;
		 $cont["inst_direccion2-------------------------------" ] = $direc2;
		 $cont["inst_rut"                                       ] = $rut;
		 $cont["fpago"                                          ] = strtoupper($fpago);
		 $cont["origen----------"                               ] = $origen;
		 $cont["destino----------"                              ] = $destino;
		 $cont["orna_no_guia"                                   ] = "";
		 
		 	 
		 $concepto = explode("\n", $concepto);
		 //print_r($concepto);
		 
		 for ($i=0; $i < count($concepto); $i++)
		    $cont["texto$i"                                         ] = $concepto[$i];
		    
		 while ($i < 10) {
			$cont["texto$i"] = ""; 
			$i++;
	     }
		 
		 
		 $cont["monto_neto"                                     ] = "";
		 $cont["neto"                                           ] = $crts_mon_flete." ".str_pad(number_format($neto,  0, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["iva"                                            ] = $crts_mon_flete." ".str_pad(number_format($iva,   0, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["total"                                          ] = $crts_mon_flete." ".str_pad(number_format($total, 2, ",", "."), 12, ' ', STR_PAD_LEFT);
		 $cont["monto_pal---------------------------------------------------"] = $sTotal;
		 $cont["monto_pal2--------------------------------------------------"] = $sTotal2;
		 
		 
// // // // 		 echo $ss;
		 
			
			foreach($cont as $c => $value) {
			   $cc = "@".$c;
			   
			   //echo "$c   $value<hr>";
			   
			   if (strlen($cc) > strlen($value)) 
			      $largo = strlen($c);
			   else
			      $largo = strlen($value);
			      
			   $valor = str_pad($value, $largo, ' ', STR_PAD_RIGHT);
			   
			   $ss = str_replace('@'.$c, $valor, $ss);
			   
			}
			
			//echo $ss."<hr/>";
			
		$fd = fopen(APP_PATH."/app/templates_c/$no_factura".".fin", "w");
		
		fputs($fd, $ss);
		
		fclose($fd);
		 

	  }		
	  
	  function reparaValor($n) {
		  $s="";
		  for($i=0; $i < strlen($n); $i++)
		     if (substr($n, $i, 1) >= "0" && substr($n, $i, 1) <= "9" || substr($n, $i, 1)==",") 
		        if (substr($n, $i, 1)==",")
		           $s .= ".";
		        else
		           $s .= substr($n, $i, 1);
		        
		  return $s;
	  }  
   }//OrdenNacional
