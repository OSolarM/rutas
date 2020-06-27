<?php
   class OrdenCompra extends AppModel {
      var $name="OrdenCompra";
      var $useTable="ordenes_compras";
      
      var $belongsTo = array("institucion" => array("className" => "Institucion",
                                                    "foreignKey" => "institucion_id",
                                                    "fields"     => array("inst_razon_social"),
                                              ),
                            );
      
      var $validate=array(
                          "institucion_id"    => "required",
                          "orco_orden_compra" => "required",
                          "orco_fecha"        => "required|type=date",
                          "orco_total"        => "required|type=number",
                          "orco_iva"          => "required|type=number",
                          "orco_total"        => "required|type=number",
                          "orco_bloqueo"      => "required",
                          "orco_estado"       => "required",
                         );
   }