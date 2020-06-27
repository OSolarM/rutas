<?php
   class FondoEx extends AppModel {
      var $name="FondoEx";
      var $useTable="fondos_ex";
      
      var $validate=array("fond_fecha"   => "required|type=date",
                         "fond_monto"   => "required|type=number",
                         "fond_monto2"   => "required|type=number",
                         "fond_monto3"   => "required|type=number",
                         "id_moneda2"    => "userDefined=chkMon2",
                         "id_moneda3"    => "userDefined=chkMon3",
                         "expe_id"      => "required|type=integer",
                         "fond_bloqueo" => "required"
                        );
                        
      var $belongsTo=array("expedicion_ex" => array("className"  => "ExpedicionEx",
                                                    "foreignKey" => "expe_id",
                                                    "fields"     => array("expe_nro", "expe_destino")
                                              ),
                           "mone"         => array("className"  => "Moneda",
                                                    "foreignKey" => "id_moneda2",
                                                    "fields"     => array("mone_cod", "mone_descripcion")
                                              ),    
                           "mone2"         => array("className"  => "Moneda",
                                                    "foreignKey" => "id_moneda3",
                                                    "fields"     => array("mone_cod", "mone_descripcion")
                                              ),                
                          );
                                                  
      function chkMon2($id_moneda2) {
	     if (!isset($this->data["FondoEx"]["fond_monto2"])) return;
	     
	     $fond_monto2 = $this->data["FondoEx"]["fond_monto2"];
	     
	     //echo "'$id_moneda2' '$fond_monto2'<hr>";
	     
	     if ($fond_monto2=="" && $id_moneda2!="")
	        $this->errorList["fond_monto2"] = "¡Debe seleccionar el monto!";
	        
	     //print_r($this->errorList);
      }
      
      function chkMon3($id_moneda3) {
	     if (!isset($this->data["FondoEx"]["fond_monto3"])) return;
	     
	     $fond_monto3 = $this->data["FondoEx"]["fond_monto3"];
	     
	     if ($fond_monto3=="" && $id_moneda3!="")
	        $this->errorList["fond_monto3"] = "¡Debe seleccionar el monto!";
      }
   
   }