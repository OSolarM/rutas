<?php
   class ItemGasto extends AppModel {
      var $name="ItemGasto";
      var $useTable="items_gastos";
      
      var $validate=array("item_id" => "required",
                          "moneda_id" => "required",
                          "drend_monto" => "required|type=number",
                          "drend_litros" => "type=number",
                         );
   }