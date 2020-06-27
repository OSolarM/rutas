<?php
   class Giro extends AppModel {
      var $name    ="Giros";
      var $useTable="giros";
      var $validate= array (                           
                           "giro_nro" 	  => "required|type=integer",
                           "giro_fecha"   => "required|type=date",
                           "chof_id" 	  => "required|type=integer",
                           "expe_tipo" 	  => "required",
                           "expe_id" 	  => "required|type=integer",
                           "giro_detalle" => "required|",
                           "mone_id" 	  => "required|type=integer",
                           "giro_monto"   => "required|type=number",
                           "giro_bloqueo" => "required",
      );
      
      var $belongsTo = array("chofer" => array("className" => "Chofer",
                                               "foreignKey" => "chof_id",
                                               "fields"     => array("chof_apellidos", "chof_nombres"),
                                         ),
                             "moneda" => array("className" => "Moneda",
                                               "foreignKey" => "mone_id",
                                               "fields"     => array("mone_descripcion"),
                                         ),
                       );
   }//Chofer
