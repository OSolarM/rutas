<?php
   class Particular extends AppModel {
      var $name    ="Particular";
      var $useTable="particulares";
      var $validate= array ("rut"              => "type=rut", 
                            "razon"            => "required",          
                            "direccion"        => "required",           
                            "pais"             => "required",        
                            "email"            => "type=mail",         
                            "bloqueo"          => "required",          
      );
   }//Particulares
