<?php
   class Autorizado extends AppModel {
      var $name    ="Autorizado";
      var $useTable="autorizados";
      var $validate= array (
         "auto_agno"      => "required|type=I",
         "auto_mts3"      => "required|type=I",
         "auto_grado"     => "required",
         "auto_apellidos" => "required",
         "auto_nombres"   => "required",
         "auto_rut"       => "required",
         "auto_origen"    => "required|type=I",
         "auto_destino"   => "required|type=I",
         "auto_bloqueo"    => "required",
      );
   }//Autorizado