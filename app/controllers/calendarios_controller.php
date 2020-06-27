<?php
   class CalendariosController extends AppController {
      var $name="Calendarios";
      var $uses=array("OrdenNacional", "Ciudad", "Institucion", "Grado");
      var $needLogin=false;
      

      function index($mes=null, $agno=null) {
         $this->layout = "muestra_calendario";

         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $dia = "1";

         if ($mes==null)  $mes = date("m")*1;
         if ($agno==null) $agno = date("Y")*1;
  
         //echo $dia." ".$mes." ".$agno."<br>";
         $primerDia = date("w", mktime(0, 0, 0, $mes, $dia, $agno))."<br>";

         $numDias   = cal_days_in_month(CAL_GREGORIAN, $mes, $agno)."<br>";
  
         if ($primerDia==0) $primerDia=7;
  
         $s = "<table border=1>\n";
         $s .= "<tr><td></td><td colspan=\"5\" align=\"center\">".$meses[($mes*1)-1]." de ".$agno."</td><td></td></tr>";
         $s .= "<tr><td align=\"center\">Lun</td>".
               "<td align=\"center\">Mar</td>".
               "<td align=\"center\">Mi&eacute;</td>".
               "<td align=\"center\">Jue</td>".
               "<td align=\"center\">Vie</td>".
               "<td align=\"center\">S&aacute;b</td>".
               "<td align=\"center\">Dom</td>";
         $s .= "<tr>";
  
         $n=0;
         for ($i=1; $i < $primerDia; $i++) {
            $s .= "<td>&nbsp;</td>";     
            $n++;
         }
  
         $numDias *=1;
         $primerDia *=1;
  
         for ($i=1; $i <= $numDias; $i++) {	
            $ff= $agno."-".($mes < 10?"0":"").$mes."-".($i < 10?"0":"").$i;

            $arreglo = $this->OrdenNacional->findAll("orna_repo_fecha='$ff'");

            $ss = "<table>\n";
            foreach($arreglo as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $ss .= "<tr style=\"color:red\"><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td></tr>\n";
            }
            $ss .= "</table>";

            $arreglo2 = $this->OrdenNacional->findAll("orna_fecha_llegada='$ff'");

            $sss = "<table>\n";
            foreach($arreglo2 as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $sss .= "<tr style=\"color:red\"><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td></tr>\n";
            }
            $sss .= "</table>";


	    $s .= "<td> <table>
	             <tr><td align=\"center\">$i</td></tr>
	             <tr><td><div>
	                     <div id=\"tpl$i\">
	                     Retiros<br>
                             $ss</br>
	                     Despachos<br>
                             $sss
	                    
	                     </div>
	             </td></tr>	             
	             </table>
	        </td>";
	     $n++;
	 
	     if ($n%7==0)
	        $s .= "</tr>\n<tr>";
	  
          }  
  
         if ($n%7 != 0) {
	    $i = $n + 1;
	    while ($i%7 != 0) {
		$s .= "<td>&nbsp;</td>";  
		$i++; 
	    }
	    $s.= "<td>&nbsp;</td></tr>\n";
          }
  
          $s .= "</table>\n";
  

          $this->set("calendario", $s);
      }

      function entregas($mes=null, $agno=null) {
         $this->layout = "muestra_calendario";

         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $dia = "1";

         if ($mes==null)  $mes = date("m")*1;
         if ($agno==null) $agno = date("Y")*1;
  
         //echo $dia." ".$mes." ".$agno."<br>";
         $primerDia = date("w", mktime(0, 0, 0, $mes, $dia, $agno))."<br>";

         $numDias   = cal_days_in_month(CAL_GREGORIAN, $mes, $agno)."<br>";
  
         if ($primerDia==0) $primerDia=7;
  
         if ($mes==12) {
            $mes_sig=1;
            $agno_sig=$agno + 1;
         }
         else
            $mes_sig=$mes + 1;

         if ($mes==1) {
            $mes_sig=12;
            $agno_sig=$agno - 1;
         }
         else
            $mes_sig=$mes - 1;
    
       
         /*
         $s  = "<table border=1>\n";
         $s .= "<tr><td colspan=\"7\" align=\"center\">Calendario de Entregas</td></tr>\n"; 
         $s .= "<tr><td></td><td colspan=\"5\" align=\"center\">".$meses[($mes*1)-1]." de ".$agno."</td><td></td></tr>";
         $s .= "<tr><td align=\"center\">Lun</td>".
               "<td align=\"center\">Mar</td>".
               "<td align=\"center\">Mi&eacute;</td>".
               "<td align=\"center\">Jue</td>".
               "<td align=\"center\">Vie</td>".
               "<td align=\"center\">S&aacute;b</td>".
               "<td align=\"center\">Dom</td>";
         $s .= "<tr>";
         */
 
         $s ="";
  
         $n=0;
         for ($i=1; $i < $primerDia; $i++) {
            $s .= "<td>&nbsp;</td>";     
            $n++;
         }
  
         $numDias *=1;
         $primerDia *=1;
  
         for ($i=1; $i <= $numDias; $i++) {	
            $ff= $agno."-".($mes < 10?"0":"").$mes."-".($i < 10?"0":"").$i;

            $arreglo = $this->OrdenNacional->findAll("orna_repo_fecha='$ff'");

            $ss = "<table>\n";
            foreach($arreglo as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $ss .= "<tr style=\"color:red\"><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td></tr>\n";
            }
            $ss .= "</table>";

            $arreglo2 = $this->OrdenNacional->findAll("orna_fecha_llegada='$ff' and orna_nula='N'");

            $sss = "<table>\n";
            
            foreach($arreglo2 as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $orna_fono    = $e["orna_fono"];
              $orna_celular = $e["orna_celular"];
              $institucion_id = $e["institucion_id"];

              switch($institucion_id) {
                 case "1": $institucion = "EJE"; break;
                 case "2": $institucion = "FAE"; break;
                 case "3": $institucion = "CAR"; break;
                 default : $institucion = "PAR"; break;
              }
              $sss .= "<tr style=\"color:red\"><td>$institucion</td><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td><td>$orna_fono</td><td>$orna_celular
</td></tr>\n";
            }
            $sss .= "</table>";


	    $s .= "<td> <table>
	             <tr><td align=\"center\">$i</td></tr>
	             <tr><td><div>
	                     <div id=\"tpl$i\">

	                     
                             $sss
	                    
	                     </div>
	             </td></tr>	             
	             </table>
	        </td>";
	     $n++;
	 
	     if ($n%7==0)
	        $s .= "</tr>\n<tr>";
	  
          }  
  
         if ($n%7 != 0) {
	    $i = $n + 1;
	    while ($i%7 != 0) {
		$s .= "<td>&nbsp;</td>";  
		$i++; 
	    }
	    $s.= "<td>&nbsp;</td></tr>\n";
          }
  
          //$s .= "</table>\n";
  

          $this->set("calendario", $s);
      }

      function retiros($mes=null, $agno=null) {	      
         $this->layout = "muestra_calendario";

         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $dia = "1";

         if ($mes==null)  $mes = date("m")*1;  else $mes = $mes*1;
         if ($agno==null) $agno = date("Y")*1; else $agno = $agno*1;
  
         $primerDia = date("w", mktime(0, 0, 0, $mes, $dia, $agno))."<br>";

         $numDias   = cal_days_in_month(CAL_GREGORIAN, $mes, $agno)."<br>";
  
         if ($primerDia==0) $primerDia=7;
  
         if ($mes==12) {
            $mes_sig=1;
            $agno_sig=$agno + 1;
         }
         else {
            $mes_sig=$mes + 1;
            $agno_sig=$agno;
         }

         if ($mes==1) {
            $mes_ant=12;
            $agno_ant=$agno - 1;
         }
         else {
            $mes_ant=$mes - 1;
            $agno_ant=$agno;
         }
  
         $s = "";
  
         $n=0;
         for ($i=1; $i < $primerDia; $i++) {
            $s .= "<td>&nbsp;</td>";     
            $n++;
         }
  
         $numDias *=1;
         $primerDia *=1;
  
         for ($i=1; $i <= $numDias; $i++) {	
            $ff= $agno."-".($mes < 10?"0":"").$mes."-".($i < 10?"0":"").$i;

            $arreglo = $this->OrdenNacional->findAll("orna_repo_fecha='$ff'");

            $ss = "<table>\n";
            foreach($arreglo as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $ss .= "<tr style=\"color:red\"><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td></tr>\n";
            }
            $ss .= "</table>";

            $arreglo2 = $this->OrdenNacional->findAll("orna_repo_fecha='$ff' and orna_nula='N'");

            $sss = "<table>\n";
            
            foreach($arreglo2 as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] =0;

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $orna_fono    = $e["orna_fono"];
              $orna_celular = $e["orna_celular"];
              $institucion_id = $e["institucion_id"];

              switch($institucion_id) {
                 case "1": $institucion = "EJE"; break;
                 case "2": $institucion = "FAE"; break;
                 case "3": $institucion = "CAR"; break;
                 default : $institucion = "PAR"; break;
              }

              if ($this->Grado->findByPk($e["orna_grado"]))
                 $grado = $this->Grado->data["Grado"]["grad_descripcion"];
              else
                 $grado = "PAR";

              $sss .= "<tr style=\"color:red\"><td>$institucion</td><td>".$grado."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td><td>$orna_fono</td><td>$orna_celular
</td></tr>\n";
            }
            $sss .= "</table>";

            $fecha = (($i < 10)?"0":"").$i."/".(($mes < 10)?"0":"").$mes."/".$agno;

	    $s .= "<td style='background:white;'> <table>
	             <tr><td align=\"center\"><a href=\"javascript:selecciona('$fecha');\">$i</a></td></tr>
	             <tr><td>
	                     <div id=\"tpl$i\">

	                     
                             $sss
	                    
	                     </div>
	             </td></tr>	             
	             </table>
	        </td>";
	     $n++;
	 
	     if ($n%7==0)
	        $s .= "</tr>\n<tr>";
	  
          }  
  
         if ($n%7 != 0) {
	    $i = $n + 1;
	    while ($i%7 != 0) {
		$s .= "<td style='background:white;'>&nbsp;</td>";  
		$i++; 
	    }
	    $s.= "<td style='background:white;'>&nbsp;</td></tr>\n";
          }
  
          $this->set("calendario", $s);
          $this->set("mes",      $mes);
          $this->set("agno",     $agno);
          $this->set("mes_sig",  $mes_sig);
          $this->set("agno_sig", $agno_sig);
          $this->set("mes_ant",  $mes_ant);
          $this->set("agno_ant", $agno_ant);
          $this->set("titulo",   "Calendario de Retiros");
          $this->set("mespal",   $meses[($mes*1)-1]);
          $this->set("tipo",     "retiros");          
      }

      function llegadas($mes=null, $agno=null) {
         $this->layout = "muestra_calendario";

         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $dia = "1";

         if ($mes==null)  $mes = date("m")*1;  else $mes = $mes*1;
         if ($agno==null) $agno = date("Y")*1; else $agno = $agno*1;
  
         $primerDia = date("w", mktime(0, 0, 0, $mes, $dia, $agno))."<br>";

         $numDias   = cal_days_in_month(CAL_GREGORIAN, $mes, $agno)."<br>";
  
         if ($primerDia==0) $primerDia=7;
  
         if ($mes==12) {
            $mes_sig=1;
            $agno_sig=$agno + 1;
         }
         else {
            $mes_sig=$mes + 1;
            $agno_sig=$agno;
         }

         if ($mes==1) {
            $mes_ant=12;
            $agno_ant=$agno - 1;
         }
         else {
            $mes_ant=$mes - 1;
            $agno_ant=$agno;
         }
  
         $s = "";
  
         $n=0;
         for ($i=1; $i < $primerDia; $i++) {
            $s .= "<td>&nbsp;</td>";     
            $n++;
         }
  
         $numDias *=1;
         $primerDia *=1;
  
         for ($i=1; $i <= $numDias; $i++) {	
            $ff= $agno."-".($mes < 10?"0":"").$mes."-".($i < 10?"0":"").$i;

            $arreglo = $this->OrdenNacional->findAll("orna_fecha_llegada='$ff' and orna_nula='N'");

            $ss = "<table>\n";
            foreach($arreglo as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] ="Part.";

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $ss .= "<tr style=\"color:red\"><td>".$e["orna_grado"]."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td></tr>\n";
            }
            $ss .= "</table>";

            $arreglo2 = $this->OrdenNacional->findAll("orna_fecha_llegada='$ff'");

            $sss = "<table>\n";
            
            foreach($arreglo2 as $e) {
              if ($e["orna_grado"]=="") $e["orna_grado"] =0;

              if ($this->Ciudad->findByPk($e["orna_origen"]))  $e["orna_origen"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];
              if ($this->Ciudad->findByPk($e["orna_destino"])) $e["orna_destino"] = $this->Ciudad->data["Ciudad"]["ciud_nombre"];

              $orna_fono    = $e["orna_fono"];
              $orna_celular = $e["orna_celular"];
              $institucion_id = $e["institucion_id"];

              switch($institucion_id) {
                 case "1": $institucion = "EJE"; break;
                 case "2": $institucion = "FAE"; break;
                 case "3": $institucion = "CAR"; break;
                 default : $institucion = "PAR"; break;
              }

              if ($this->Grado->findByPk($e["orna_grado"]))
                 $grado = $this->Grado->data["Grado"]["grad_descripcion"];
              else
                 $grado = "PAR";

              $sss .= "<tr style=\"color:red\"><td>$institucion</td><td>".$grado."</td><td>".$e["orna_m3"]."</td><td>".$e["orna_origen"]."</td><td>".$e["orna_destino"]."</td><td>$orna_fono</td><td>$orna_celular
</td></tr>\n";
            }
            $sss .= "</table>";

            $fecha = (($i < 10)?"0":"").$i."/".(($mes < 10)?"0":"").$mes."/".$agno;

	    $s .= "<td style='background:white;'> <table>
	             <tr><td align=\"center\"><a href=\"javascript:selecciona2('$fecha');\">$i</a></td></tr>
	             <tr><td>
	                     <div id=\"tpl$i\">

	                     
                             $sss
	                    
	                     </div>
	             </td></tr>	             
	             </table>
	        </td>";
	     $n++;
	 
	     if ($n%7==0)
	        $s .= "</tr>\n<tr>";
	  
          }  
  
         if ($n%7 != 0) {
	    $i = $n + 1;
	    while ($i%7 != 0) {
		$s .= "<td style='background:white;'>&nbsp;</td>";  
		$i++; 
	    }
	    $s.= "<td style='background:white;'>&nbsp;</td></tr>\n";
          }
  
          $this->set("calendario", $s);
          $this->set("mes",      $mes);
          $this->set("agno",     $agno);
          $this->set("mes_sig",  $mes_sig);
          $this->set("agno_sig", $agno_sig);
          $this->set("mes_ant",  $mes_ant);
          $this->set("agno_ant", $agno_ant);
          $this->set("titulo",   "Calendario de Llegadas");
          $this->set("mespal",   $meses[($mes*1)-1]);
          $this->set("tipo",     "llegadas");          
      }

      function render() {
	     global $smarty; 
	     	     	    	
         if ($this->noRender) return;
		 
	     if (isset($_SESSION["MsgFlash"]))
	     {
		    $smarty->assign("MsgFlash", $_SESSION["MsgFlash"]);
		    
		    unset($_SESSION["MsgFlash"]);
	     }
	     
	     $this->set("needLogin", $this->needLogin?"S":"N");
	     	     	        
	     $smarty->assign('f',           $this);
	     $smarty->assign("tpl_include", _aNombreArchivo($this->name)."/".$this->layout.".tpl");
	     $smarty->display('main/main2.tpl');
	     
    }//render

   }
