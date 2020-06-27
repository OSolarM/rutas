<?php
      
   class ParametrosController extends AppController {
      var $name="Parametros";
      var $uses=array("Parametro");
      
      function index() {
	     if (!empty($this->data)) {
	        if ($this->Parametro->save($this->data))
	           $this->redirect("/principales");
         }
         
         if (empty($this->data)) {
	        $this->data = $this->Parametro->read(null, 1);
         }
         
         $this->set("lmeses", "|,Enero|1,Febrero|2,Marzo|2,Abril|4,Mayo|5,Junio|6,Julio|7,Agosto|8,Septiembre|9,Octubre|10,Noviembre|11,Diciembre|12");
      }
   }