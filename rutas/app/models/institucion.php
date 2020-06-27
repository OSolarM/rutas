<?php
   class Institucion extends AppModel {
      var $name    ="Institucion";
      var $useTable="instituciones";
      var $validate= array (
         "inst_rut"          => "required|type=rut",
         "inst_razon_social" => "required",
         "inst_correo1"      => "type=mail",
         "inst_correo2"      => "type=mail",
         "inst_bloqueo"      => "required",
      );

      function getInstituciones() {
	     $arr = $this->findAll(null, null, "id");
	     
	     //print_r($arr);
	     $lista="|";
	     
	     foreach($arr as $r) {
		    $lista .= ",".$r["inst_razon_social"]."|".$r["id"];
	     }
	     
	     //echo $lista."<hr>";;
	     return $lista;
      }
   }//Institucion
