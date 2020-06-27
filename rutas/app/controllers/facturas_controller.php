<?php
   class FacturasController extends AppController {
      var $name="Facturas";
      var $uses=array("OrdenNacional");
      
      function index() {
	     
	     $guias_total = 0;
	      
	     $arr = $this->OrdenNacional->findAll("institucion_id=1 and orna_cerrar='S' and orna_no_guia is null and orna_valor_guia is not null");	      
	     $suma = 0;
	     for($i=0; $i < count($arr); $i++)
	        $suma += $arr[$i]["orna_valor_guia"];
	        
	     $guias_total += $suma;
	        
	     $this->set("guias_ejercito", $suma);
	     
	     $arr = $this->OrdenNacional->findAll("institucion_id=2 and orna_cerrar='S' and orna_no_guia is null and orna_valor_guia is not null");
	     $suma = 0;
	     for($i=0; $i < count($arr); $i++)
	        $suma += $arr[$i]["orna_valor_guia"];
	        
	     $guias_total += $suma;
	        
	     $this->set("guias_faerea", $suma);
	     
	     $arr = $this->OrdenNacional->findAll("institucion_id=3 and orna_cerrar='S' and orna_no_guia is null and orna_valor_guia is not null");
	     $suma = 0;
	     for($i=0; $i < count($arr); $i++)
	        $suma += $arr[$i]["orna_valor_guia"];
	        
	     $guias_total += $suma;
	        
	     $this->set("guias_carabineros", $suma);	     
	     
	     $this->set("guias_total", $guias_total);	   
	     
	     $this->set("monto_ejercito"   , 0);
	     $this->set("monto_faerea"     , 0);
	     $this->set("monto_carabineros", 0);  
	     
	     $this->set("monto_total",       0); 
      }
   }