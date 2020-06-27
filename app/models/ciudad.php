<?php
   class Ciudad extends AppModel {
      var $name    ="Ciudad";
      var $useTable="ciudades";
      var $validate= array (
         "ciud_nombre"  => "required",
         "ciud_region"  => "required",
         "ciud_bloqueo" => "required",
      );
   }//Ciudad
