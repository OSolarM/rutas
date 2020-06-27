<?php
   class Acoplado extends AppModel {
      var $name    ="Acoplado";
      var $useTable="acoplados";
      var $validate= array (
         "acop_patente"     => "required",
         "acop_bloqueo"     => "required",
      );
   }//Acoplado
