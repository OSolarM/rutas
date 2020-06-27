<?php
   class LibroVenta extends AppModel {
      var $name    ="LibroVenta";
      var $useTable="libros_ventas";
      
      var $validate= array (
         "tipo_docto" => "required",   
         "fecha"      => "required|type=date",
         "rut"        => "required|type=rut",   
         "razon"      => "required",
         "docto"      => "required",   
         "numero"     => "required|type=integer",
         "emision"    => "required|type=date",   
         "vencto"     => "required|type=date",   
         "neto"       => "required|type=number",
         "iva"        => "required|type=number",   
         "total"      => "required|type=number",
         "estado"     => "required",   
      );
   }//LibroVenta
