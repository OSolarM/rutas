<?php
   class Fondo extends AppModel {
      var $name="Fondo";
      var $useTable="fondos";
      
      var $validate=array("fond_fecha"           => "required|type=date",
                          "fond_monto"           => "required|type=number",
                          "fond_monto_adicional" => "required|type=number",
                          "expe_id"              => "required|type=integer",
                          "fond_bloqueo"         => "required"
                         );
                         
      var $belongsTo=array("expedicion" => array("className" => "Expedicion",
                                                 "foreignKey" => "expe_id",
                                                 "fields"     => array("expe_nro"       
                                                                      ,"expe_fecha"   
                                                                      ,"chof_id"      
                                                                      ,"cami_id"      
                                                                      ,"acop_id"      
                                                                      ,"expe_destino" 
                                                                      ,"expe_bloqueo" 
                                                                      ,"expe_cerrado" 
                                                                 )
                                                ),
                          );
   
   }