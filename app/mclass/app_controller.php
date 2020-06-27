<?php
   class AppController extends Controller {	        
      function AppController () {
	     $uses = array("ModuloAcceso", "Modulo", "Acceso");
	     
	     foreach($uses as $u)
	        if (!in_array($u, $this->uses))
	           $this->uses[] = $u;
	     
             //print_r($this->uses);   
	     parent::Controller();
	     
	     $user = isset($_SESSION["user"])?$_SESSION["user"]:null;
		 
		 //print_r($user);
	     
	     if ($user!=null) {
		    if ($this->Acceso->findByUser($user)) {
			   $acceso_id = $this->Acceso->data["Acceso"]["id"];
			   
			   $arreglo = $this->Modulo->findAll("id in (select modulo_id from modulos_accesos where acceso_id=$acceso_id)");
			   
			   //print_r($arreglo);
			   
			   $this->set("menu", $arreglo);
		    }
	     }
	
      }
   
   	function log($msg, $tipo_msg = "Error"){
   		
   		if($tipo_msg == "Error" || $tipo_msg == "Debug"){
   			$nombre_archivo = APP_PATH."/app/templates_c/" . strftime('%d%m%Y') ."_" . $tipo_msg .".txt";
   		}else{
   			echo "El parametro tipo_msg debe ser Error o Debug";
   			exit;
   		}
   		
   		$contenido = $this->name . "	". $this->action . "	" . strftime('%H:%M:%S') . "	" . $msg . "\n";
   		
		if (!$gestor = fopen($nombre_archivo, 'a+')) {
		         echo "No se puede abrir el archivo $nombre_archivo";
		         exit;
		}
		if (fwrite($gestor, $contenido) === FALSE) {
		        echo "No se puede escribir al archivo ($nombre_archivo)";
		        exit;
		}
		fclose($gestor);
   	}
   	
   	function render() 
    {
	     global $smarty; 
		 
		 if (!isset($smarty->_tpl_vars["MsgFlash"]))
			$smarty->assign("MsgFlash", "");
	     	     	    	
         if ($this->noRender) return;
		 
	     if (isset($_SESSION["MsgFlash"]))
	     {
		    $smarty->assign("MsgFlash", $_SESSION["MsgFlash"]);
		    
		    unset($_SESSION["MsgFlash"]);
	     }
	     
	     $this->set("needLogin", $this->needLogin?"S":"N");
	     	     	        
	     $smarty->assign('f',           $this);
	     $smarty->assign("tpl_include", _aNombreArchivo($this->name)."/".$this->layout.".tpl");
	     $smarty->display('main/main.tpl');
	     
    }//render
   }
