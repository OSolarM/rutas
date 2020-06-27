<?php
   class Paridad extends AppModel {
      var $name    ="Paridad";
      var $useTable="paridades";
      
      var $validate=array(
                          "mon_id"          => "required|type=integer",
                          "par_fecha"       => "required|type=date",
                          "par_valor"       => "required|type=number",
                          "par_valor_litro" => "required|type=number",
                          "par_bloqueo"     => "required",

                    );
                    
      public function getParidad($mon_id, $par_fecha) {	        
	     $arr = $this->Paridad->findAll("mon_id=$mon_id and $par_fecha='".date2MySql($par_fecha)."'");
	     
	     if (count($arr) > 0)
	        return $arr[0]["par_valor"];
	     else
	        return 0;
      }
      
      public function getValorLitro($mon_id, $par_fecha) {	        
	     $arr = $this->Paridad->findAll("mon_id=$mon_id and $par_fecha='".date2MySql($par_fecha)."'");
	     
	     if (count($arr) > 0)
	        return $arr[0]["par_valor_litro"];
	     else
	        return 0;
      }
   }//Paridad
