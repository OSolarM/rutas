<?php
//session_name("sessionrutas");
session_start();
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", 1);
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//mysql_connect("localhost", "rutas", "20180119", "rutas") or die(mysql_error());
//
//mysql_select_db("rutas");
//
//$query = "select * from clientes";
//
//$q = mysql_query($query) or die(mysql_error());
//
//while ($d=mysql_fetch_array($q)) {
//	print_r($d);
//}
//
////phpinfo();
//
////echo "Entreeee<br/>";

  
   //define("APP_PATH", $_SERVER['DOCUMENT_ROOT']."/rutas");
   //define("APP_HTTP", "http://www.ruta-chile.com/rutas");
   
   define("APP_PATH", $_SERVER['DOCUMENT_ROOT']."/rutas");
   define("APP_HTTP", "http://localhost/rutas");

   //echo "Esta cosa no escribe";
 //echo APP_PATH;
 //echo $_SERVER['DOCUMENT_ROOT'];


   require_once(APP_PATH."/app/conf/conf.inc.php");
   require_once(APP_PATH."/app/lang/trad.inc.php");
   include_once(APP_PATH."/libs/conf.smarty.php");
   include_once(APP_PATH."/libs/adodb/adodb.inc.php");
   include_once(APP_PATH."/libs/goodies/pagination.class.php");
   include_once(APP_PATH."/libs/goodies/orderColumn.class.php");
   include_once(APP_PATH."/libs/goodies/funcs.inc.php");   
   include_once(APP_PATH."/libs/class/dbconnection.inc.php");
   include_once(APP_PATH."/libs/class/ttable.inc.php");
   include_once(APP_PATH."/libs/class/session_helper.inc.php");
   include_once(APP_PATH."/libs/class/model.inc.php");   
   include_once(APP_PATH."/libs/class/controller.inc.php");
   include_once(APP_PATH."/libs/class/grid.inc.php");
   
   include_once(APP_PATH."/libs/phpmailer/class.phpmailer.php");
   
   //include_once(APP_PATH."/libs/class/grid_form.inc.php");

   include_once(APP_PATH."/libs/fpdf/fpdf.php");
   
   
   $oDB = new DBConnection();                                      
   $oConexion = $oDB->getConn();
   
   include_once(APP_PATH."/app/mclass/app_model.php");
   include_once(APP_PATH."/app/mclass/app_controller.php");
   
   $smarty->assign("APP_PATH", APP_PATH);
   $smarty->assign("APP_HTTP", APP_HTTP);
    
   //echo "Entré al router<hr>";
   $url       = empty($_SERVER['REQUEST_URI']) ? false : $_SERVER['REQUEST_URI'];
   
   //echo $url."<hr>";
      
   $url       = str_replace("/rutas/", "", $url);
      
   //echo "Ruta: ".$url."<br>";


   if ($url=="")
      $url = "principales";
      
   $lista_args = explode("/", $url);
   
   //print_r($lista_args);
               
   $lista = explode("_", $lista_args[0]);
   
   //print_r($lista);
   
   $controller="";
   
   $fileName="";
   foreach($lista as $name) {	  
	  
	  
	  $controller .= ucfirst(strtolower($name));
	  
	  	 
   }
   
   if ($controller=="") $controller="Principales";
         
   $controller .= "Controller";
   $name        = $lista_args[0];
   
   //echo "Controlador: ".$controller."<br/>";

   
   if (file_exists(APP_PATH."/app/controllers/$name"."_controller.php"))
      include_once(APP_PATH."/app/controllers/$name"."_controller.php");
   else {
       $lista_args  = array("errores", "controllerNotFound", $name);

      $controller  = "ErroresController";
      $name        = "errores";
     
      include_once(APP_PATH."/app/controllers/$name"."_controller.php");
   }

   //echo APP_PATH."/app/controllers/$name"."_controller.php<br>";
   //echo "Controlador: ".$controller."<br/>";

   
   
   if (count($lista_args) > 1)
      $action    =$lista_args[1];
   else
      $action    ="index";
   
   //Rescato parámetros de la acción      
   $resto="";
   if (count($lista_args) > 2) {
	  for ($i=2; $i < count($lista_args); $i++) {
		 if ($resto!="") 
		    $resto .= ",";
		    
		 $resto .= "\"".$lista_args[$i]."\"";
	  }	   
   }  
   
   $obj = new $controller();
   
   

   //echo "Voy a llamar a la acción $controller $action";
   
   $obj->execution($controller, $action, $resto);

