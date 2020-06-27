<?php
   class Peoneta extends AppModel {
      var $name    ="Peoneta";
      var $useTable="peonetas";
      var $validate= array (
         "pnta_rut"       => "required",
         "pnta_apellidos" => "required",
         "pnta_nombres"   => "required",
         "pnta_direccion" => "required",
         "pnta_comuna"    => "required",
         "pnta_ciudad"    => "required",
         "pnta_region"    => "required",
         "pnta_bloqueo"   => "required",
      );
   }//Peoneta
