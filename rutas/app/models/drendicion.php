<?php
   class Drendicion extends AppModel {
      var $name="Drendicion";
      var $useTable="drendiciones";
      
      var $validate=array("item_id"      => "required",
                          "moneda_id"    => "required",
                          "dren_monto"   => "required|type=number",
                          "dren_litros"  => "type=number",
                         );
   }