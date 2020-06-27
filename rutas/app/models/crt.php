<?php
   class Crt extends AppModel {
      var $name    ="Crt";
      var $useTable="crts";
      var $validate= array (
         "cliente_id"       => "required",
         "destinatario_id"        => "required",
         "consignatario_id"       => "required",
         "facturar_id"            => "required",
         "fecha"                  => "required|type=date",
         "crts_peso_brut_kg"      => "type=N",
         "crts_peso_neto_kg"      => "type=N",
         "crts_vol_m3"            => "type=N",
         "crts_valor"             => "type=N",
         "crts_flete_monto"       => "type=N",
         "crts_otro_monto"        => "type=N",
         "crts_dest_flete"        => "type=N",
         "crts_dest_otro"         => "type=N",
         "crts_monto_flete_ext"   => "type=N",
         "crts_monto_reembolso"   => "type=N",
         "crts_valor_flete"       => "required",
         "crts_mon_flete"         => "required",
         "crts_estado"            => "required",
         "crts_facturable"        => "required",
         "crts_factura"           => "required",
         "crts_desde"             => "required",
         "crts_hasta"             => "required",
         //"crts_guia_cliente"      => "required",
      );
      
      var $belongsTo = array("cliente" => array("className" => "Cliente",
                                                "foreignKey" => "cliente_id",
                                                "fields" => array("razon", "rut", "direccion", "comuna", "ciudad", "region", "pais")
                                          ),
                             "consigna"=> array("className" => "Cliente",
                                                "foreignKey" => "consignatario_id",
                                                "fields" => array("razon", "rut")
                                          ),
                             "destina" => array("className" => "Cliente",
                                                "foreignKey" => "destinatario_id",
                                                "fields" => array("razon", "rut")
                                          ),
                             "facturar"=> array("className" => "Cliente",
                                                "foreignKey" => "facturar_id",
                                                "fields" => array("razon", "rut", "direccion", "comuna", "ciudad", "region", "pais")
                                          ),
                       );
   }//Crt
