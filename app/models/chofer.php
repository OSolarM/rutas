<?php
   class Chofer extends AppModel {
      var $name    ="Chofer";
      var $useTable="choferes";
      var $validate= array (
         "chof_rut"       => "type=rut",
         "chof_apellidos" => "required",
         "chof_nombres"   => "required",
         "chof_bloqueo"   => "required",
      );
   }//Chofer
