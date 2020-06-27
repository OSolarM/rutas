<?php
   class Combustible extends AppModel {
      var $name    ="Combustible";
      var $useTable="combustibles";
      var $validate= array (
                            "fecha"                  => "required|type=date",
                            "kms"                    => "required|type=integer",
                            "litros"                 => "required|type=number",
                            "expe_tipo"              => "required",
                            "expe_nro"               => "required|type=integer",
                            "bloqueo"                => "required",
      );
      
      function chkUnique($expe_nro) {
	     
      }
   }//Camion
