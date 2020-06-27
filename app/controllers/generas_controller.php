<?php
   class GenerasController extends Controller {
      var $name = "Generas";
      var $uses = array("Genera");
      
      function index() {
         $lista = "";
         if (isset($_REQUEST["lista"]))
            $lista = $_REQUEST["lista"]; 
         
         $this->genMalla($lista);                 
      }
      
      function add() {
	     $this->layout = "index";
	     
         $nro      = $this->data['Genera']['nro'     ];
         $etiqueta = $this->data['Genera']['etiqueta'];
         $campo    = $this->data['Genera']['campo'   ];
         $largo    = $this->data['Genera']['largo'   ];
         $required = $this->data['Genera']['required'];
         $type     = $this->data['Genera']['type'    ];
         $min      = $this->data['Genera']['min'     ];
         $max      = $this->data['Genera']['max'     ];       
         
         $lista="";
         if (isset($_REQUEST["lista"]))
            $lista = $_REQUEST["lista"]; 
            
         if($nro=="") {
           $rows = explode("|", $lista);
           
           $nro = count($rows) + 1;
           
           if ($lista!="") $lista .="|";
              
           $lista .= $nro      ."^".
                     $etiqueta ."^".
                     $campo    ."^".
                     $largo    ."^".
                     $required ."^".
                     $type     ."^".
                     $min      ."^".
                     $max;                        
         }                                              
         else {
            $rows = explode("|", $lista);
            $rec  = $rows[$nro-1];
            
            $lista = "";
            for ($i=0; $i < count($rows); $i++) {
            if ($lista !="") $lista .="|";
            
            if ($i == ($nro-1)) {
            $lista .= $nro      ."^".
                             $etiqueta ."^".
                             $campo    ."^".
                             $largo    ."^".
                             $required ."^".
                             $type     ."^".
                             $min      ."^".
                             $max;  
            }
            else 
               $lista .= $rows[$i];
            }
         }            
         
         $this->data['Genera']['nro'     ] = "";
         $this->data['Genera']['etiqueta'] = "";
         $this->data['Genera']['campo'   ] = "";
         $this->data['Genera']['largo'   ] = "";
         $this->data['Genera']['required'] = "";
         $this->data['Genera']['type'    ] = "";
         $this->data['Genera']['min'     ] = "";
         $this->data['Genera']['max'     ] = "";
                  
         $this->set("lista", $lista);             
         $this->genMalla($lista);                       
      }//add
      
      function edit($linea) {
	     $this->layout = "index";
	     
         $lista="";
         if (isset($_REQUEST["lista"]))
            $lista = $_REQUEST["lista"]; 
	      
         $rows = explode("|", $lista);
         $rec  = $rows[$linea-1];
         
         $r    = explode("^", $rec);
         
         $this->data['Genera']["nro"     ] = $r[0]; 
         $this->data['Genera']["etiqueta"] = $r[1]; 
         $this->data['Genera']["campo"   ] = $r[2]; 
         $this->data['Genera']["largo"   ] = $r[3]; 
         $this->data['Genera']["required"] = $r[4]; 
         $this->data['Genera']["type"    ] = $r[5]; 
         $this->data['Genera']["min"     ] = $r[6]; 
         $this->data['Genera']["max"     ] = $r[7];
          
         $this->set("lista", $lista);             
         $this->genMalla($lista);                        
      }
      
      function del($linea) {
	     $this->layout = "index";
	     
         $lista="";
         if (isset($_REQUEST["lista"]))
            $lista = $_REQUEST["lista"]; 
	      
         $rows = explode("|", $lista);
         
         $nRow = 1;
         $lista="";
         for ($i=0; $i < count($rows); $i++) {	         
            if ($i != $linea - 1) {
	           if ($lista !="") $lista .="|"; 
	           $l = explode("^", $rows[$i]);
	           //echo $l."<hr>";
	           
	           $lista .= $nRow . "^" .    
	                     $l[1] . "^" .    
	                     $l[2] . "^" .
	                     $l[3] . "^" .
	                     $l[4] . "^" .
	                     $l[5] . "^" .
	                     $l[6] . "^" .
	                     $l[7];	
	                     
	           $nRow++;            	           
            }
         }  
                   
         //echo "$lista<hr>";
         $this->set("lista", $lista);             
         $this->genMalla($lista);                        
      }      
      
      function generate() {
	     $titulo      = $this->data['Genera']['titulo'];
	     $modelo      = $this->data['Genera']['modelo'];
	     $controlador = $this->data['Genera']['controlador'];
	     
         $lista="";
         if (isset($_REQUEST["lista"]))
            $lista = $_REQUEST["lista"]; 
	      
         $rows = explode("|", $lista);

         $allRows=array();
         foreach($rows as $rr) {
	        $r = explode("^", $rr); 
	                     
            $nro        = $r[0]; 
            $etiqueta   = $r[1]; 
            $campo      = $r[2]; 
            $largo      = $r[3]; 
            $required   = $r[4]; 
            $type       = $r[5]; 
            $min        = $r[6]; 
            $max        = $r[7];
            
            $allRows[$campo] = array('caption'  => $etiqueta,
                                     'length'   => $largo,
                                     'required' => $required,
                                     'type'     => $type,
                                     'min'      => $min,
                                     'max'      => $max
                               );
         }
         
         //print_r($allRows);
         
         foreach($allRows as $key => $arr) {
	        $primaryKey = $key;
	        break;
         }
         
         $s  ="<?php\n";
         $s .= "   class $modelo extends AppModel {\n";
         $s .= "      var \$name       = \"$modelo\";\n";
         $s .= "      var \$useTable   = \""._aNombreArchivo($controlador)."\";\n";
         $s .= "      var \$primaryKey = \"".strtolower($primaryKey)."\";\n";
         
         $s .= "      var \$useSeq     = \"tijo_seq\";\n\n";
      
         $s .= "";
         
         $prepara="";
         
         $claves = array('required', 'type', 'min', 'max');

         $lCampos="";         
         foreach($allRows as $key => $arr) {
	        $l = "";
	        
	        if ($lCampos !="") $lCampos .=", ";
	        
	        $lCampos .= "\"$key\"";
	        
	        foreach($claves as $c) {
		       switch($c) {
			      case 'required' : if ($arr[$c] == "S") {
				                       if ($l !="") $l .= "|";
			                           $l .= "required"; 
		                            }
			                        break;
			      
			      case 'type'     : if ($arr[$c] !="") {
				                       if ($l !="") $l .= "|";
				                       $l .= "type=$arr[$c]"; 
			                        }
			                        break;
			      
			      case 'min'      : if ($arr[$c] !="") {
				                       if ($l !="") $l .= "|";
				                       $l .= "min=$arr[$c]"; 
			                        }
			                        break;
			      
			      case 'max'      : if ($arr[$c] !="") {   
				                       if ($l !="") $l .= "|";
				                       $l .= "max=$arr[$c]"; 
			                        }
			                        break;
		       }
	        }
	        
	        if ($l!="") {
		       if ($prepara != "") $prepara .=",\n";
		       
		       $prepara .= "                         '$key' => \"$l\"";
	        }	        
         }
         
         if ($prepara !="") {         
            $s .= "      var \$validate = array(\n$prepara\n";
            $s .= "                       );\n";
         }
            
         $s .= "      var \$dataTypes = array();\n";   
            
         if ($lCampos !="") {
	        $s .= "\n";
	        $s .= "      function getFieldList() {\n";
	        $s .= "         return array($lCampos);\n";
	        $s .= "      }\n";
         }
            
         
         $s .= "   }//class $modelo\n";
         $s .= "?>";

         $this->set("my_model", _aNombreArchivo($modelo));         
         $this->set("smodelo", $s);

         $s  ="<?php\n";
         $s .= "   class $controlador"."Controller extends AppController {\n";
         $s .= "      var \$name = \"$controlador\";\n";
         $s .= "      var \$uses = array(\"$modelo\");\n\n";
         $s .= "      function index(\$page=null) {\n";
         $s .= "         if (\$page==null) \$page=1;\n\n";
                  
         $s .= "         \$recsXPage=10;\n\n";
         $s .= "         \$arreglo = \$this->".$modelo."->findAll(null, null, null, (\$page-1)*\$recsXPage + 1, \$recsXPage);\n";
         $s .= "         \n";
         $s .= "         \$pagination = new pagination(\"/tie/"._aNombreArchivo($controlador)."/index\", \$page);\n";
         $s .= "         \n";        
         $s .= "         \$arreglo = \$pagination->generate(\$arreglo, \$this->".$modelo."->count(), \$recsXPage);\n";
         $s .= "         \n";
         $s .= "         \$this->assign('".strtolower($modelo)."', \$arreglo);\n";
         $s .= "         \$this->assign('pagination', \$pagination->links());\n";
         $s .= "      }//index\n\n";
         
         $s .= "      function add() {\n";
         $s .= "         \$this->layout = \"form\";\n\n";
         $s .= "         if (!empty(\$this->data)) {\n"; 
         $s .= "            if (\$this->".$modelo."->save(\$this->data))\n";
         $s .= "               \$this->redirect(\"/tie/"._aNombreArchivo($controlador)."/index\");\n";
         $s .= "            else {\n";
         $s .= "               //Aquí chequear errores DB\n";
         $s .= "               if (\$this->".$modelo."->sqlcode !=0)\n";
         $s .= "                  echo \$this->".$modelo."->sqlerrm.\"<br>\";\n\n";;         
         
         $s .= "               foreach(\$this->".$modelo."->errorList as \$key => \$val)\n";
         $s .= "                  \$this->set(\"msg_\$key\", \$val);\n";
         $s .= "            }\n";
         $s .= "         }\n";
         $s .= "         else {\n";
         $s .= "            //Aquí van las inicializaciones\n";
         $s .= "         }\n";
         $s .= "      }//add\n\n";         
         
         $s .= "      function edit(\$id=null) {\n";
         $s .= "         \$this->layout = \"form\";\n\n";
         $s .= "         if (\$id==null)\n";
         $s .= "            \$this->redirect(\"/tie/errores/idNull\");\n\n";
         $s .= "         if (empty(\$this->data)) {\n"; 
         $s .= "            if (\$this->".$modelo."->findByPk(\$id))\n";
         $s .= "               \$this->data = \$this->".$modelo."->data;\n";
         $s .= "            else\n";
         $s .= "               \$this->redirect(\"/tie/errores/idNotFound\");\n";
         $s .= "         }\n";
         $s .= "         elseif (\$this->".$modelo."->save(\$this->data))\n";
         $s .= "            \$this->redirect(\"/tie/"._aNombreArchivo($controlador)."/index\");\n";
         $s .= "         else {\n";
         $s .= "            if (\$this->".$modelo."->sqlcode !=0)\n";
         $s .= "               echo \$this->".$modelo."->sqlerrm.\"<br>\";\n\n";;         
         
         $s .= "            foreach(\$this->".$modelo."->errorList as \$key => \$val)\n";
         $s .= "               \$this->set(\"msg_\$key\", \$val);\n";         
         $s .= "         }\n";
         $s .= "      }//edit\n\n";                  

         $s .= "      function delete(\$id=null) {\n";         
         $s .= "         if (\$id==null)\n";
         $s .= "            \$this->redirect(\"/tie/errores/idNull\");\n\n";
         $s .= "         if (\$this->".$modelo."->findByPk(\$id)) {\n";
         $s .= "            if (\$this->".$modelo."->delete()) \n";
         $s .= "               \$this->redirect(\"/tie/"._aNombreArchivo($controlador)."/index\");\n";
         $s .= "            else\n";
         $s .= "               \$this->redirect(\"/tie/errores/errDatabase\");\n";
         $s .= "         }\n";
         $s .= "         else\n";
         $s .= "            \$this->redirect(\"/tie/errores/idNotFound\");\n\n";
         $s .= "      }//delete\n\n";           
         
         $s .= "      function view(\$id=null) {\n";
         $s .= "         \$this->layout = \"form\";\n\n";
         $s .= "         if (\$id==null)\n";
         $s .= "            \$this->redirect(\"/tie/errores/idNull\");\n\n";
         $s .= "         if (empty(\$this->data)) {\n"; 
         $s .= "            if (\$this->".$modelo."->findByPk(\$id))\n";
         $s .= "               \$this->data = \$this->".$modelo."->data;\n";
         $s .= "            else\n";
         $s .= "               \$this->redirect(\"/tie/errores/idNotFound\");\n";
         $s .= "         }\n";
         $s .= "      }//view\n\n";                                  
                  
         $s .= "   }//class $controlador"."Controller\n";
         $s .= "?>";

         $this->set("my_controller", _aNombreArchivo($controlador));
         $this->set("scontrolador", $s);
         
         $s = "";         
         $s .= "<h1>$titulo</h1>\n";
         $s .= "\n";
         $s .= "{glink caption=\"Agregar\" action=\"add\"}{/glink}\n";
         $s .= "<table><tr><td bgcolor=\"#cccccc\" cellspacing=1 cellpading=1>\n";
         $s .= "<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1>\n";
         $s .= "<tr bgcolor=#aabbcc>\n";
         foreach($allRows as $key => $arr)
            $s .= "    <td align=center><strong>".$arr["caption"]."</strong></td>\n";
         $s .= "    <td align=center>&nbsp;</td>\n";
         $s .= "</tr>\n";
         $s .= "\n";
         $s .= "{foreach from=\$".strtolower($modelo)." item=rec}\n";
         $s .= "<tr>\n";
         foreach($allRows as $key => $arr) 
            $s .= "    <td bgcolor=white>{\$rec.".$key."}</td>\n";
         
         $s .= "    <td bgcolor=white>&nbsp;{glink caption=\"Editar\"   action=\"edit\"}/{\$rec.".$primaryKey."}{/glink}\n";
         $s .= "        &nbsp;{glink caption=\"Eliminar\" confirm=\"¿Seguro elimina registro?\" action=\"delete\"}/{\$rec.".$primaryKey."}{/glink}\n";
         $s .= "        &nbsp;\n";
         $s .= "    </td>\n";
         $s .= "</tr>\n";
         $s .= "{/foreach}\n";
         $s .= "</table>\n";
         $s .= "</td></tr>\n";
         $s .= "<tr><td>{if !empty(\$pagination)}\n";
         $s .= "            <div class=\"pagination\">{\$pagination}</div>\n";
         $s .= "        {/if}\n";
         $s .= "   </td>\n";
         $s .= "</tr>\n";
         $s .= "</table>\n";
         
         $this->set("sindex", $s);
         
         $s  = "";
         $s .= "{\$Form->create('".$modelo."')}\n";
         $s .= "  <table>\n";
         $s .= "     <tr><td>\n";
         $s .= "            <div style=\"border-style:solid; border-width:1px;\">\n";
         $s .= "            <table>\n";
         $s .= "               <tr><td colspan=2><h2>$titulo</h2></td></tr>\n";
         foreach($allRows as $key => $arr) 
            $s .= "               <tr><td>".$arr["caption"]."</td><td>{input name=\"$key\" size=\"".$arr["length"]."\"}</td></tr>\n";
         $s .= "               <tr><td colspan=\"2\" align=\"right\">{button type=\"submit\" value=\"Enviar\"}</td></tr>\n";
         $s .= "            </table>\n"; 
         $s .= "            </div>\n";
         $s .= "        </td>\n";
         $s .= "     </tr>\n";
         $s .= "  </table>\n";
         $s .= "  <br>\n";
         $s .= "  {glink caption=\"Volver\" action=\"index\"}{/glink}\n";
         $s .= "\n";  
         $s .= "</form>\n";
         
         $this->set("sadd", $s);
         
         //$s  = "";
         //$s .= "{\$Form->create('".$modelo."')}\n";
         //$s .= "  <table>\n";
         //$s .= "     <tr><td>\n";
         //$s .= "            <div style=\"border-style:solid; border-width:1px;\">\n";
         //$s .= "            <table>\n";
         //$s .= "               <tr><td colspan=2><h2>$titulo</h2></td></tr>\n";
         //foreach($allRows as $key => $arr) 
         //   $s .= "               <tr><td>".$arr["caption"]."</td><td>{input name=\"$key\" size=\"".$arr["length"]."\"}</td></tr>\n";
         //$s .= "               <tr><td colspan=\"2\" align=\"right\">{button type=\"submit\" value=\"Enviar\"}</td></tr>\n";
         //$s .= "               <input type=\"hidden\" name=\"".$primaryKey."\" value=\"{\$$primaryKey}\">\n";
         //$s .= "            </table> \n";
         //$s .= "            </div>\n";
         //$s .= "        </td>\n";
         //$s .= "     </tr>\n";
         //$s .= "  </table>\n";
         //$s .= "  <br>\n";
         //$s .= "  {glink caption=\"Volver\" action=\"index\"}{/glink}\n";
         //$s .= "\n";  
         //$s .= "</form>\n";     
         //
         //$this->set("sedit", $s);    
         //
         //$s  = "";
         //$s .= "{\$Form->create('".$modelo."')}\n";
         //$s .= "  <table>\n";
         //$s .= "     <tr><td>\n";
         //$s .= "            <div style=\"border-style:solid; border-width:1px;\">\n";
         //$s .= "            <table>\n";
         //$s .= "               <tr><td colspan=2><h2>$titulo</h2></td></tr>\n";
         //foreach($allRows as $key => $arr) 
         //   $s .= "               <tr><td>".$arr["caption"]."</td><td>{\$$key}</td></tr>\n";
         //$s .= "               <tr><td colspan=\"2\" align=\"right\">{button type=\"submit\" value=\"Enviar\"}</td></tr>\n";
         //$s .= "               <input type=\"hidden\" name=\"".$primaryKey."\" value=\"{\$".$primaryKey."}\">\n";
         //$s .= "            </table> \n";
         //$s .= "            </div>\n";
         //$s .= "        </td>\n";
         //$s .= "     </tr>\n";
         //$s .= "  </table>\n";
         //$s .= "  <br>\n";
         //$s .= "  {glink caption=\"Volver\" action=\"index\"}{/glink}\n";
         //$s .= "\n";  
         //$s .= "</form>\n";     
         //
         //$this->set("sview", $s);             
         
      }
      
      function genMalla($lista) {         
         if (!empty($lista)) {           
            $recs = explode("|", $lista);
            $s ="";
            $rowNo = 1;
            foreach($recs as $fil) {
               $campos = explode("^", $fil);
               
               //print_r($campos); echo "<hr>";

               $n = 0;
               $s .="<tr>";
               foreach($campos as $field)  {                
                  if (empty($field)) $field="&nbsp";
                  
                  if ($n==0) $field = $rowNo;
                  
                  $n++;            
                 
                  $s .= "<td>$field</td>";
               }
                  
               $s .="<td><input type='button' value='Mod' onclick='editar(".$rowNo.")'><input type='button' value='Elim' onclick='eliminar(".$rowNo.")'></td></tr>\n";
               
               $rowNo++;
            }
         
            $this->set("malla", $s);
         }                
      }
      
   }//class Generas
?>