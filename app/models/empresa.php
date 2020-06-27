<?php
   class Empresa extends AppModel {
      var $name       = "Empresa";
      var $useTable   = "empresas";

      var $validate = array(
                         'empr_run'   => "required|type=integer",
                         'empr_dv'    => "required",
                         'empr_razon' => "required"
                       );

   }//class Empresa