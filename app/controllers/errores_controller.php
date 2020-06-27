<?php
   class ErroresController extends AppController {
      var $name="Errores";
      var $needLogin=false;

      function pkNotFound() {
      }

      function idNotFound() {
      }

      function controllerNotFound($cname) {
         $this->set("error", "Controlador \"$cname\" no encontrado!");
      }

      function actionNotFound($action) {
         $this->set("error", "Acci&oacute; $action no encontrada!");
      }
      
      function mensaje($mensaje) {
	     $this->layout="controllerNotFound";
	     
         $this->set("error", "Sin permiso para acceder a '$mensaje'!");
      }
   }
