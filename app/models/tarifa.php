<?php
   class Tarifa extends AppModel {
      var $name="Tarifa";
      var $useTable="tarifas";
      
      var $validate = array(
	                        "tari_descripcion" => "required",
	                        "tari_valor" 	   => "required|type=number",
	                        "tari_bloqueo"     => "required",
	                       );
   }
