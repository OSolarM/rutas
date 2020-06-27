<?php
   class FormHelper {
	  var $controller;
	  var $action;
	  var $keyVal="";
	  var $data = array();
	  
	  function FormHelper() {
	  }
	  
	  function setController($cController) {
		 $this->controller = str_replace("_controller", "", _aNombreArchivo($cController));
	  }
	  
	  function setAction($cAction) {
		 $this->action = $cAction; 
	  } 
	  
	  function setData($aData) {
		 $this->data = $aData;

                 //print_r($this->data);
	  }
	  
	  function transferToSmarty() {
		 global $smarty;
		 
		 foreach($this->data as $lista) {	
			$n = 0; 		 
			foreach($lista as $key => $val) {
                           //echo "$key = $val<br>";
			   $smarty->assign($key, $val);
			   
			   if ($n==0) $this->keyVal = $val;
			   
			   $n++;
		    }
		 }
	  }
	  
	  function create($cModel) {
		 if ($this->keyVal!="") 
		    $ss="/$this->keyVal";
		 else
		    $ss="";
		    
		 $s = "<form name=\"frm\" id=\"frm\" enctype=\"multipart/form-data\"  method=\"POST\" action=\"".APP_HTTP."/$this->controller/$this->action$ss\">";
		 
		 return $s;
		  
	  }
   }
