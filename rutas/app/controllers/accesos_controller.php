<?php
   class AccesosController extends AppController {
      var $name="Accesos";
      var $uses=array("Acceso", "Modulo");
      var $needLogin=false;
      
      function index() {	      
	     $this->Acceso->validate = array("user" => "required", "pass" => "required");
	     
	     if (!empty($this->data)) {
		    $user   = $this->data["Acceso"]["user"];
		    $pass   = $this->data["Acceso"]["pass"];
		    
		    $this->Acceso->setData($this->data);
		    if ($this->Acceso->validates()) {
		       if ($this->Acceso->findByUser($user)) {
			      $userId = $this->Acceso->data["Acceso"]["id"];
			      
			      if (md5($pass)==$this->Acceso->findByUser($user)) {   
				     //echo "id in (select modulo_id from modulos_accesos where acceso_id=$userId)<hr>";
				     
				     $arr = $this->Modulo->findAll("id in (select modulo_id from modulos_accesos where acceso_id=$userId)");
				     
				     //echo "id in (select modulo_id from modulos_accesos where acceso_id=$userId)<hr>";
				     
				     //print_r($arr);
				     
				     $permisos = array("errores");
				     
				     foreach($arr as $r) {
					    $e = explode('/', $r["pagina"]);
					    
					    $permisos[] = $e[0];
				     }
				     
				     //print_r($permisos);
				     
				        
				     $_SESSION["userId"]     = $userId;
			         $_SESSION["user"]       = $user;
			         $_SESSION["pass"]       = $pass;
			         $_SESSION["userPermit"] = $permisos;
			         $this->redirect("/principales");
	              }
               }
            }
	     }
	      
      }
      
      function salir() {
	      unset($_SESSION["userId"]);
	      unset($_SESSION["user"]);
	      unset($_SESSION["pass"]);
	      $this->redirect("/principales");
      }
   }
