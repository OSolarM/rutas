<?php
   class Acceso extends AppModel {
      var $name="Acceso";
      var $useTable="accesos";
      
      var $validate=array("user" => "required", 
                          "pass" => "required", 
                          "apellidos" => "required", 
                          "nombres" => "required", 
                          "bloqueo" => "required"
                         );
   }