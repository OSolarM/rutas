<?php
   class LibroCompra extends AppModel {
      var $name="LibroCompra";
      var $validate = array("empresa" => "required|integer"
                           ,"mes"     => "required|integer|min=1|max=12"
                           ,"agno"    => "required|integer"
                           );
      
      function getFieldList() {
	     return array("empresa", "mes", "agno");
      }
   }