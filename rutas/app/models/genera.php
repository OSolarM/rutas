<?php
   class Genera extends Model {
      var $name="Genera";

      var $validate = array(
                         'titulo'       => "required",
                         'modelo'       => "required",
                         'controlador'  => "required",
                         'campo'        => "required",
                         'largo'        => "required|type=integer|min=1|max=4000",
                         'required'     => "required"
                      );

      function getFieldList() {
         return array("nro", "titulo", "modelo", "controlador", "etiqueta", "campo", "largo", "required", "type", "min", "max");
      }
      
   }
   
?>
