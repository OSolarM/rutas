<?php
   class ListaPrecio extends AppModel {
      var $name    ="ListaPrecio";
      var $useTable="listas_precios";
      
      var $belongsTo=array("origen" => array("className" => "Ciudad",
                                             "foreignKey" => "list_origen",
                                             "fields"     => array("ciud_nombre"),
                                            ),
                           "destino" => array("className" => "Ciudad",
                                             "foreignKey" => "list_destino",
                                             "fields"     => array("ciud_nombre"),
                                            ),                                            
                          );
                          
      var $validate= array (
         "institucion_id"   => "required|type=I",
         "lista_agno"       => "required|type=I",
         "list_origen"      => "required|type=I",
         "list_destino"     => "required|type=I",
         "list_auto"        => "required",
         "list_precio"      => "required|type=N",
         "list_bloqueo"     => "required",
      );
   }//ListaPrecio