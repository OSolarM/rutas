<?php 
   class Rendicion extends AppModel {
      var $name="Rendicion";
      var $useTable="rendiciones";
      
      var $validate=array("rend_nro"                    => "required|type=integer",
                          "rend_fecha"                  => "required|type=date",
                          "expe_tipo"                   => "required",
                          "expe_id"                     => "required|type=integer",
                          "fondo_id"                    => "required|type=integer",
                          "rend_fecha_salida"           => "required|type=date",
                          //"rend_lugar_salida"           => "required",
                          "rend_kms_salida"             => "required|type=number",
                          "rend_fecha_llegada"          => "required|type=date",
                          //"rend_lugar_llegada"          => "required",
                          "rend_kms_llegada"            => "required|type=number",
                          "rend_dias_viaje_nac"         => "required|type=integer",
                          "rend_dias_viaje_int"         => "required|type=integer",
	                      "rend_bloqueo"                => "required",
	                      "rend_estado"                 => "required",
	                      "rend_fec_carga"              => "type=date", //"required|type=date",
	                      "rend_fec_aduana"             => "type=date", //"required|type=date",
	                      "rend_fec_bodega"             => "type=date", //"required|type=date",
	                      "rend_fec_descarga"           => "type=date", //"required|type=date",
	                      "rend_fec_carga_imp"          => "type=date",
	                      "rend_fec_aduana_imp"         => "type=date",
	                      "rend_fec_bodega_imp"         => "type=date",
	                      "rend_fec_descarga_imp"       => "type=date",
	                      "rend_peonetas"               => "required|type=integer",
	                      "rend_litros_ida_mendoza"     => "required|type=number",
	                      "rend_litros_regreso_mendoza" => "required|type=number",
	                      "rend_fallida"                => "required",
	                      "rend_fec_ida_mendoza"        => "type=date",
	                      "rend_fec_regreso_mendoza"    => "type=date",
                     );                                                        
   }