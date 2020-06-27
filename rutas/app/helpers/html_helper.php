<?php
   class HtmlHelper {
	  var $controller;
	  
      function HtmlHelper() {
      }
      
      function setController($cController) {
	     $this->controller = str_replace("_controller", "", _aNombreArchivo($cController));
      }
      
      function genLink($cCaption, $oLink) {
	     if (is_array($oLink)) {
		    if (!isset($oLink["controller"]))
		       $oLink["controller"] = $this->controller;
		     
		    if (!isset($oLink["action"]))
		       $oLink["action"] = "index";
		        
		    $s="/tie/".$oLink["controller"]."/".$oLink["action"];
		    foreach($oLink as $field => $val)
		       if ($field!="controller" && $field!="action")
		          $s .="/$val";
		       
		    return "<a href=\"$s\">$cCaption</a>"; 
	     }
	     else {
		    return "<a href=\"/tie$oLink\">$cCaption</a>"; 
	     } 
      }
      
      function hola() {
	     return "Hola!";
      }
   }
?>
