<?php
   class DexpedicionEx extends AppModel {
      var $name="DexpedicionEx";
      var $useTable="dexpediciones_ex";
      
      var $belongsTo=array("crt"   => array("className" => "Crt",
                                            "foreignKey" => "crt_id",
                                            "fields" => array("crts_numero", "cliente_id", "destinatario_id")
                                      ),                                         
                         );

      var $validate=array(                       
                       "crt_id"         => "required|type=integer",
                       //"dexp_remitente"    => "required",
                       //"dexp_destinatario" => "required",
                       //"dexp_cobra"        => "required|userDefined=valCobra",
                       //"dexp_factura"      => "type=integer",
                       //"dexp_val_factura"  => "type=integer",
                    );

      //function valCobra($valor) {
      //   if ($valor=="S") {
      //      if ($this->data["DexpedicionEx"]["dexp_factura"]=="")
      //         $this->errorList["dexp_factura"] = "&iexcl;Obligatorio!";
      //
      //      if ($this->data["DexpedicionEx"]["dexp_val_factura"]=="")
      //         $this->errorList["dexp_val_factura"] = "&iexcl;Obligatorio!";  
      //   }
      //}
      
      function chkGuia($crt_id) {
	     $className="OrdenNacional";
	     
	     if ($crt_id=="") return;
	     
	     if (!file_exists(APP_PATH."/app/models/"._aNombreArchivo($className).".php")) 
	                throw new Exception("findAll: Clase '$className' no encontrada!");
	             
	     include_once(APP_PATH."/app/models/"._aNombreArchivo($className).".php");
	     
	     $Orden = new OrdenNacional();
	     
	     $arr = $Orden->findAll("orna_no_guia=$crt_id and orna_nula<>'S'");
	     
	     if (count($arr)==0) 
	        $this->errorList["crt_id"] = "&iexcl;Gu&iacute;a no encontrada!";  
	     else {
		    $arr = $this->findAll("crt_id=$crt_id");
		    
		    //if (count($arr) > 0)
		    //   $this->errorList["crt_id"] = "&iexcl;Gu&iacute;a ya ha sido ingresada!";  
	     }
      }
   }
