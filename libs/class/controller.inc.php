<?php
   error_reporting(6143);

   class Controller {
      var $name="";
      var $uses=array(); 
      var $data=array();
      var $helpers=array("Form");
      var $action="";
      var $layout="";
	  var $noRender=false;
	  var $needLogin=true;
	  var $inputToUpper=true;
      
      function Controller() {	    	                     
         $this->controls=array();
         
         $this->Session = new SessionHelper();
         
         //Creo los modelos que se van a usar
         foreach($this->uses as $modelName) {
	        //echo $this->name.".".$modelName."<hr>";
	        
	        include_once(APP_PATH."/app/models/"._aNombreArchivo($modelName).".php");
            $this->$modelName = new $modelName();
         }
            
         
         //Creo los helpers que sean necesarios
         foreach($this->helpers as $helper) {
	        include_once(APP_PATH."/app/helpers/"._aNombreArchivo($helper)."_helper.php"); 
	        $myClass = $helper."Helper";
	        //echo $helper."<hr>";
            $this->$helper = new $myClass();
         }
         
      }//Controller
      
      function __destruct() {
	      //echo "Controller: destructor<hr/>";
      }
           
      function redirect($page) {
	     //echo "Location: ".APP_HTTP.$page;
	     header("Location: ".APP_HTTP.$page);
	     return;
      }//redirect
      
      function assign($cLabel, $cValue) {
	     global $smarty;
	     
	     $smarty->assign($cLabel, $cValue);
      }//assign
      
      function set($cLabel, $cValue) {
	     global $smarty;
	     
	     $smarty->assign($cLabel, $cValue);
      }//set
      
      function render() 
      {
	     global $smarty; 
	     
	     $this->set("time", time());
	     	     	     
	     $smarty->display(_aNombreArchivo($this->name)."/".$this->layout.".tpl");
      }//render
      
      function requestData() {       
	     foreach($this->uses as $my_model) {
		    $lista = $this->$my_model->getFieldList();
		    		    
		    $listF = array();

		    foreach($lista as $field)
               if (isset($_REQUEST[$field])) {
	              if ($this->inputToUpper)
		             $listF[$field] = strtoupper($_REQUEST[$field]);
		          else
		             $listF[$field] = $_REQUEST[$field];
	           }
               else
		          $listF[$field] = "";
		          
		    $this->data[$this->$my_model->name] = $listF;
         }
      }//requestData

      function request($cName, $cValue="") {
         return isset($_REQUEST[$cName])?$_REQUEST[$cName]:$cValue;
      }
      
      function beforeFilter() {
      }//beforeFilter
      
      function afterFilter() {
      }//afterFilter
      
      function beforeRender() {
      }//beforeRender
      
      function afterRender() {
      }//afterRender
      
      function execution($controller, $action, $action_parameters=null) {	 
	      
	     $user = isset($_SESSION["user"])?$_SESSION["user"]:null; 
         $pass = isset($_SESSION["pass"])?$_SESSION["pass"]:null;
         $userPermit = isset($_SESSION["userPermit"])?$_SESSION["userPermit"]:array();
         
         //print_r($userPermit);
                                        
         if ($user==null && $this->needLogin) {
	       $this->redirect("/accesos");
	        return;
         }   
         
         //if (!in_array($controller, $userPermit)) {
	     //   $this->redirect("/errores/mensaje/$controller");
	     //   return;
         //}      
    
	     $this->data = array();               	   	   
    	     
	     if (!empty($_POST))
	        $this->requestData();
	        
	     $this->Form->setController($controller);   
	     $this->Form->setAction($action);   
	     	        
         $this->action = $action;
         $this->layout = $action;
         $this->beforeFilter();
                  
         eval("\$v = \$this->".$action."(".$action_parameters.");");                 
         
         //Muevo la data al helper Form
         $this->Form->setData($this->data);
         
         //Paso la data a smarty
         $this->Form->transferToSmarty();
         
         //Paso el objeto helper Form a smarty
         $this->assign("Form", $this->Form);
                  
         $this->afterFilter();
         $this->beforeRender();
         $this->render();
         $this->afterRender();	     
      }//execution
      
      function setFlash($msg) 
      {
	     $this->set("MsgFlash", $msg);
      }
            
   }//class Controller
