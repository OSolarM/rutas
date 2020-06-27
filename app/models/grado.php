<?php
   class Grado extends AppModel {
      var $name="Grado";
      var $useTable="grados";
      
      var $belongsTo = array("institucion" => array("className" => "Institucion",
                                                    "foreignKey" => "institucion_id",
                                                    "fields" => array("inst_razon_social")
                                                   ),
                       );
      
      var $validate=array("institucion_id"   => "required",
                          "grad_descripcion" => "required",
                          "grad_dias"        => "required|integer",
                          "grad_bloqueo"     => "required"
                          );
                          
      function getGrados($inst) {
	     if ($inst==null) 
	        $arr = $this->findAll(null, null, "grad_descripcion");
	     else
	        $arr = $this->findAll("institucion_id=$inst", null, "grad_descripcion");
	     $lista="|";
	     
	     foreach($arr as $r) {
		    $lista .= ",".$r["grad_descripcion"]."|".$r["id"];
	     }
	     
	     return $lista;
      }
   }
