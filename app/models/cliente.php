<?php
   class Cliente extends AppModel {
      var $name    ="Cliente";
      var $useTable="clientes";
      var $validate= array ("rut"              => "type=rut", 
                            "razon"            => "required",          
                            "direccion"        => "required",           
                            "pais"             => "required",    
                            "estadia"          => "required|type=integer",        
                            "valor"            => "required|type=number",
                            "email"            => "type=mail",         
                            "bloqueo"          => "required",    
                            "tarifa"           => "required",      
      );
   }//Clientes
