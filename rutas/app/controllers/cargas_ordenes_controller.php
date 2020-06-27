<?php
   class CargasOrdenesController extends AppController {
      var $name="CargasOrdenes";
      var $uses=array("OrdenNacional", "Grado", "Ciudad", "OrdenCompra");
      
      var $listado=array();

      function carga() {
         //print_r($_FILES);

         if (!empty($_FILES))
            $this->subirArchivo();
            
      }

      function subirArchivo() {
         //print_r($_FILES);
    
         
         
         $allowedExts = array("csv", "txt");
         $extension = end(explode(".", $_FILES["file"]["name"]));
         if (true 
            /*($_FILES["file"]["type"] == "text/plain")*/
          )
         {
	      //print_r($_FILES); echo"<hr>";
	         
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
	print_r($_FILES); echo"<hr>";
	    
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
    
    unlink("upload/" . $_FILES["file"]["name"]);

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      //move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/virtual/ruta-chile.com/www/upload/" . $_FILES["file"]["name"]);      
      
      echo $_FILES["file"]["name"]."<br>";
      
      move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/virtual/ruta-chile.com/www/rutas/upload/" . $_FILES["file"]["name"]);      
      
      
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      
      $this->cargaArchivo($_FILES["file"]["name"]);
      }
    }
  }
else
  {
   // 	  echo "<hr>";
   //print_r($_FILES); echo"<hr>";
  echo "Invalid file";
  }
      }
      
        
      function CargaArchivo($archivo) {
	      $this->redirect("/cargas_ordenes/resultado/$archivo");
	           
      }
 

      function resultado($archivo) {	      
	      $fd=fopen("/var/www/html/virtual/ruta-chile.com/www/rutas/upload/" . $archivo, "r");

          $nErrores=0;
          $nLinea=0;
	      while (($linea = fgets($fd))!=null) {
		     $e = explode(";", strtoupper($linea));
		     
		     $nLinea++;
		     //echo $nLinea."<hr>";
		     
		     $grado     = trim(ltrim($e[1]));
	         
	         $arr = $this->Grado->findAll("grad_descripcion='$grado' and institucion_id=3");
	         
	         if (count($arr) ==0) {
	            $grado = "<label style='color:red'>$grado</label>";
	            $nErrores++;	            
             }
         
	         $nombres   = trim(ltrim($e[2]));
	         $origen    = trim(ltrim($e[3]));
	         
	         $arr = $this->Ciudad->findAll("ciud_nombre='$origen'");
	         
	         if (count($arr) == 0) {
		        $origen = "<label style='color:red'>$origen</label>";
	            $nErrores++;
             }
	         
	         
	         $destino   = trim(ltrim($e[4]));
	         
	         $arr = $this->Ciudad->findAll("ciud_nombre='$destino'");
	         
	         if (count($arr)== 0) {
		        $destino0 = $destino;
		        $destino = "<label style='color:red'>$destino</label>"; 
	            $nErrores++;
	            
	             $cData=array();
	             $cData["Ciudad"]["id" ] = ""; 
		         $cData["Ciudad"]["ciud_nombre" ] = $destino0; 
                 $cData["Ciudad"]["ciud_region" ] = "7";
                 $cData["Ciudad"]["ciud_bloqueo"] = "N";
                 
                 if (!$this->Ciudad->save($cData)) { print_r($cData); die ("Error");}
             }
	            
	         $mts       = trim(ltrim($e[5]));
	         $direccion = trim(ltrim($e[6]));
	         $orden     = trim(ltrim($e[7]));
	         
	         $oldOrder=$orden;
	         $arr = $this->OrdenNacional->findAll("orna_orden_compra='$orden'");
	         if (count($arr)> 0) {		      
		        $orden = "<label style='color:red'>$orden</label>"; 
	            $nErrores++;
             }
             
             //echo "institucion_id=3 and orco_orden_compra='$orden'";
             
             $arr = $this->OrdenCompra->findAll("institucion_id=3 and orco_orden_compra='$oldOrder'");
             if (count($arr)==0) {		      
		        $orden = "<label style='color:red' title='Orden de Compra no encontrada'>$orden</label>"; 
	            $nErrores++;
             }
             
	         
	         $listado[] = array (
	                         "grado"     => $grado    ,
                             "nombres"   => $nombres  ,
                             "origen"    => $origen   ,
                             "destino"   => $destino  ,
                             "mts"       => $mts      ,
                             "direccion" => $direccion,
                             "orden"     => $orden    
	                      );
	      }
	      
	      fclose($fd);
	      
	      $this->set("listado", $listado);
	      $this->set("errores", $nErrores);
	      $this->set("archivo", $archivo);
      }

      
      function subirRegistros($archivo) {
	      $fd=fopen("/var/www/html/virtual/ruta-chile.com/www/upload/" . $archivo, "r");
          
          $nSubidos=0;
          $nErrores=0;
	      while (($linea = fgets($fd))!=null) {
		     
		     //echo $linea."<hr>";
		     
	         $e = explode(";", strtoupper($linea));
	         
	         $grado     = trim(ltrim($e[1]));
	         
	         $arr = $this->Grado->findAll("grad_descripcion='$grado' and institucion_id=3");
	         
	         if (count($arr) > 0)
	            $grado = $arr[0]["id"];
	         else
	            $nErrores++;	            
	         
	         $nombres   = trim(ltrim($e[2]));
	         $origen    = trim(ltrim($e[3]));
	         $sOrigen   = $origen;
	         
	         $arr = $this->Ciudad->findAll("ciud_nombre='$origen'");
	         
	         if (count($arr) > 0)
	            $origen = $arr[0]["id"];
	         else
	            $nErrores++;
	         
	         
	         $destino   = trim(ltrim($e[4]));
	         $sDestino  = $destino;
	         
	         $arr = $this->Ciudad->findAll("ciud_nombre='$destino'");
	         
	         if (count($arr) > 0)
	            $destino = $arr[0]["id"];
	         else {
		        
	            $nErrores++;
             }
	            
	         $mts       = trim(ltrim($e[5]));
	         $direccion = trim(ltrim($e[6]));
	         $orden     = trim(ltrim($e[7]));
	         
	         //$arr = $this->OrdenNacional->findAll("orna_orden_compra='$orden'");
	         //if (count($arr)> 0) {		      
		     //   $orden = "<label style='color:red'>$orden</label>"; 
	         //   $nErrores++;
             //}
	         
	         
	         $n = explode(" ", $nombres);
	         
	         $sNombres = $n[0]." ".$n[1];
	         
	         $sApellidos = "";
	         
	         for ($i=2; $i < count($n); $i++) {
		         if ($sApellidos!="") $sApellidos .= " ";
		         
		         $sApellidos .= $n[$i];
	         }
	         
	         
	         $data=array();
	                                
	         $data["OrdenNacional"]["id"                  ] = "";
             $data["OrdenNacional"]["institucion_id"      ] = 3;
             $data["OrdenNacional"]["orna_rut"            ] = "1-9";         
             $data["OrdenNacional"]["orna_fecha"          ] = date("d/m/Y");                                                    
             $data["OrdenNacional"]["orna_m3"             ] = $mts;                  
             $data["OrdenNacional"]["orna_grado"          ] = $grado;               
             $data["OrdenNacional"]["orna_tipo_em"        ] = "M";
             $data["OrdenNacional"]["orna_auto"           ] = "N";
             $data["OrdenNacional"]["orna_origen"         ] = $origen;              
             $data["OrdenNacional"]["orna_destino"        ] = $destino;             
             $data["OrdenNacional"]["orna_repo_direccion" ] = $direccion;
             $data["OrdenNacional"]["orna_repo_comuna"    ] = $sOrigen;
             $data["OrdenNacional"]["orna_repo_ciudad"    ] = $sOrigen;
             $data["OrdenNacional"]["orna_comuna_despacho"] = $sDestino;
             $data["OrdenNacional"]["orna_estado"         ] = "I";
             $data["OrdenNacional"]["orna_apellidos"      ] = $sNombres;
             $data["OrdenNacional"]["orna_nombres"        ] = $sApellidos;
             $data["OrdenNacional"]["orna_cerrar"         ] = "S";                         
             $data["OrdenNacional"]["orna_nula"           ] = "N";
             $data["OrdenNacional"]["orna_orden_compra"   ] = $orden;

             $this->OrdenNacional->validate=array();
             
             $this->OrdenNacional->save($data);   
             
             $nSubidos++;
             
              
          }   
	           
	      fclose($fd);	      
	      
	      $this->set("subidos", $nSubidos);
      }
           
   }
