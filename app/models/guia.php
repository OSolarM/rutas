<?php
   class Guia extends AppModel {
      var $name       = "Guia";
      var $useTable   = "guias";
      var $primaryKey = "id";
      var $useSeq     = "tijo_seq";

      var $validate = array(
                         'id' => "type=integer",
                         'referencia' => "required"
                       );
  
   }//class Guia
?>