<?php
   class Dexpedicion extends AppModel {
      var $name="Dexpedicion";
      var $useTable="dexpediciones";

      var $validate=array(                       
                       "dexp_guia"         => "required|type=integer|userDefined=chkGuia",
                       //"dexp_remitente"    => "required",
                       //"dexp_destinatario" => "required",
                       "dexp_cobra"        => "required|userDefined=valCobra",
                       "dexp_factura"      => "type=integer",
                       "dexp_val_factura"  => "type=integer",
                    );

      function valCobra($valor) {
         if ($valor=="S") {
            if ($this->data["Dexpedicion"]["dexp_factura"]=="")
               $this->errorList["dexp_factura"] = "&iexcl;Obligatorio!";

            if ($this->data["Dexpedicion"]["dexp_val_factura"]=="")
               $this->errorList["dexp_val_factura"] = "&iexcl;Obligatorio!";  
         }
      }
      
      function chkGuia($dexp_guia) {
	     if ($dexp_guia==0) return;
	     
	     $className="OrdenNacional";
	     
	     if (!file_exists(APP_PATH."/app/models/"._aNombreArchivo($className).".php")) 
	                throw new Exception("findAll: Clase '$className' no encontrada!");
	             
	     include_once(APP_PATH."/app/models/"._aNombreArchivo($className).".php");
	     
	     $Orden = new OrdenNacional();
	     
	     $arr = $Orden->findAll("orna_no_guia=$dexp_guia and orna_nula<>'S'");
	     
	     if (count($arr)==0) 
	        $this->errorList["dexp_guia"] = "&iexcl;Gu&iacute;a no encontrada!";  
	     else {
		    $arr = $this->findAll("dexp_guia=$dexp_guia");
		    
		    //if (count($arr) > 0)
		    //   $this->errorList["dexp_guia"] = "&iexcl;Gu&iacute;a ya ha sido ingresada!";  
	     }
      }
   }
