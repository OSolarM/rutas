<?php
   class Expedicion extends AppModel {
      var $name="Expedicion";
      var $useTable="expediciones";
      
      var $belongsTo=array("chofer" => array("className" => "Chofer",
                                            "foreignKey" => "chof_id",
                                            "fields" => array("chof_apellidos", "chof_nombres")
                                      ),
                          "camion" => array("className" => "Camion",
                                            "foreignKey" =>"cami_id",
                                            "fields"     => array("cami_patente")
                                           ),
                          "acoplado" => array("className" => "Acoplado",
                                            "foreignKey" =>"acop_id",
                                            "fields"     => array("acop_patente")
                                           ),                                           
                         );

      var $validate=array( 
                            "expe_nro"     => "required|type=integer",
                            "expe_fecha"   => "required|type=date",
                            "chof_id"      => "required|type=integer",
                            "cami_id"      => "required|type=integer",
                            "expe_destino" => "required",
                            "expe_bloqueo" => "required",
                           
                          );
   }
