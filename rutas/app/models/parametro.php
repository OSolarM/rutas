<?php
   class Parametro extends AppModel {
      var $name="Parametro";
      var $useTable="parametros";
      var $validate= array("agno"        => "required|type=I",
                           "iva"         => "required|type=N",
                           "ult_guia"    => "required|type=N",
                           "ult_factura" => "required|type=N",
                          );
                          
      function proximaGuia() {
	     $data = $this->read(null, 1);
	     
	     //print_r($data);
	     
	     //echo $data["Parametro"]["ult_guia"] + 1; echo "<hr>";
	     
	     return $data["Parametro"]["ult_guia"] + 1;	     
      }
      
      function proximaFactura() {
	     $data = $this->read(null, 1);
	     
	     return $data["Parametro"]["ult_factura"] + 1;	     
      }
      
      function actualizaGuia() {
	     $data = $this->read(null, 1);
	     
	     $ult_guia = $data["Parametro"]["ult_guia"];	  
	     
	     $data["Parametro"]["ult_guia"] = $ult_guia + 1;
	     
	     $this->save($data);
      }
      
      function actualizaFactura() {
	     $data = $this->read(null, 1);
	     
	     $data["Parametro"]["ult_factura"] += 1;	  
	     
	     $this->save($data);
      }
   }