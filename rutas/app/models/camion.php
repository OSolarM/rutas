<?php
   class Camion extends AppModel {
      var $name    ="Camion";
      var $useTable="camiones";
      var $validate= array (
         "cami_patente"     => "required",
         "cami_agno"        => "type=I",
         "cami_bloqueo"     => "required",
      );
   }//Camion
