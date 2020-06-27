<?php
   class Model {
      var $name="";
      var $useTable="";
      var $primaryKey="id";
      var $errorList=array();
      var $validate=array();
      var $tbl;
      var $data;
      var $countRecs=0;
      var $fields=array();
      var $belongsTo=array();

      function Model() {	  
         if (!empty($this->useTable)) {
            $this->tbl = new TTable($this->useTable);
            $this->fields = $this->tbl->fields;
         }
      }

      function get($cName) {
         return $this->tbl->get($cName);
      }

      function set($cName, $cValue) {
         $this->tbl->set($cName, $cValue);
      }
      
      function getDataType($cName) {
	     foreach($this->tbl->fields as $f)
	        if ($f->name==$cName)
	           return $f;
	           	     
         return null;
      }

      function validates() {  
	      global $smarty;
	              
          if (empty($this->data)) return true;
          
          if (isset($this->data[$this->name])) {
             foreach($this->validate as $field => $val) {
                $lista = explode("|", $val);
                                
                foreach($lista as $elem) {
                   $e = explode("=", $elem);
                   
                   //Valor actual del elemento
                   $valor = isset($this->data[$this->name][$field])?$this->data[$this->name][$field]:"";;
                   
                   //echo "$field ".$e[0]." = $valor<hr>";
                   
                   switch($e[0]) {
                      case "required"    : if (trim($valor)=="") 
                                              $this->errorList[$field] = "&iexcl;Obligatorio!";
                                           
                                           break;
                                           
                      case "type"        : switch($e[1]) {
                                              case "rut"     : if (!isRut($valor))
                                                                  $this->errorList[$field] = "&iexcl;Rut incorrecto!";
                                                                                       break;
                                              
                                              case "number"  : if (!isNumber($valor))
                                                                  $this->errorList[$field] = "&iexcl;Se esperaba un n&uacute;mero!";
                                                               break;
                                                                  
                                              case "integer" : if (!isInteger($valor))
                                                                  $this->errorList[$field] = "&iexcl;Se esperaba un n&uacute;mero entero!";
                                                               break;
                                              
                                              case "date"    : if (!isDate($valor))
                                                                  $this->errorList[$field] = "&iexcl;Fecha incorrecta (DD/MM/AAAA)!";
                                                               break;
                                                               
                                              case "mail"    : if (!isEMail($valor))
                                                                  $this->errorList[$field] = "&iexcl;E-Mail incorrecto!";
                                                               break;                                                              
                                           }
                                           break;
                                           
                      case "min"         : if ($valor < $e[1]) 
                                              $this->errorList[$field] = "&iexcl;Valor debe ser mayor o igual a \"".number_format($e[1], 0, ".", ",")."\"!";
                                           break;
                                           
                      case "max"         : if ($valor > $e[1]) 
                                              $this->errorList[$field] = "&iexcl;Valor debe ser menor o igual a \"".number_format($e[1], 0, ".", ",")."\"!";
                                           break;
                                           
                      case "eq"         :  $vv = $this->data[$this->name][$e[1]];
                                           if ($valor != $vv) 
                                              $this->errorList[$field] = "&iexcl;Valores son distintos!";
                                           break;
                                           
                                           
                      case "userDefined" : $funcion=$e[1];
                                           $this->$funcion($valor);
                                           break;
                                           
                      case "unique"      : if (isset($this->data[$this->name][$this->primaryKey]))
                                              $id = $this->data[$this->name][$this->primaryKey];
                                           else
                                              $id = null;
 
                                           $dd = $this->data[$this->name][$field];
                                           //print_r($this->data);
                                           
                                           $funcion = "findBy$field";
                                           if ($id==null && $this->$funcion($dd)) {
	                                          $this->errorList[$field] = "&iexcl;Valor duplicado!";
                                           }
                                           else {
	                                          $f = $this->getDataType($field);
	                                          
	                                          $valor="";
	                                          switch($f->type) {                                    
	                                             case "N": $valor = $dd; break;        
	                                             case "C": $valor = "'".$dd."'"; break;
	                                             case "D": $valor = "'".$dd."'"; break;
	                                             default : $valor = "null"; break;          
	                                          }                                           
	                                                                                         
	                                          $r = $this->findAll($this->primaryKey."<>$id and $field=$valor");       
	                                                                                         
	                                          if (!empty($r)) {
		                                         $this->errorList[$field] = "&iexcl;Valor duplicado!";
	                                          }                           
	                                          	                                          
                                           }
                                           break;
                   }//switch
                   
                   if (isset($this->errorList[$field]))
                      break;
                }//foreach
             }           
          }
          
          foreach($this->errorList as $key => $val)
             $smarty->assign("msg_$key", $val);
             
          $this->afterValidates();   
                          
          return (count($this->errorList) == 0);
      }//validates
      
      function afterValidates() {
      }

      function save($oData) {
         $this->setData($oData);
         
         if ($this->validates()) {
            $clave = $this->data[$this->name][$this->primaryKey];
            
            if (empty($clave)) 
               return $this->insert($this->data); 
            else 
               return $this->update($this->data);       
         }
         else
            return false;
      }
      
      function insert($oList) {
         foreach($oList[$this->name] as $fld => $val)
            $this->tbl->set($fld, $val);

         return $this->tbl->insert();
      }

      function update($oList) {
         //print_r($oList);
         $clave = $this->data[$this->name][$this->primaryKey];
         
         if ($this->findByPk($clave)) {
            foreach($oList[$this->name] as $fld => $val)
               $this->tbl->set($fld, $val);
               
            return $this->tbl->update();
         }
         else
            return false;
      }

      function delete($id) {
	     $this->tbl->set($this->primaryKey, $id);
		 return $this->tbl->delete();
      }

      function findAll($condition=null, $lFields=array(), $orderBy=null, $offset=0, $nRows=0) {
         //echo "findAll<br><hr>";

         $this->tbl->where=$condition;
         $this->tbl->order=$orderBy;

         $resultList=array();
         
         if ($lFields==null) {
	        $lFields=array();
            foreach($this->tbl->fields as $f)
               $lFields[] = $f->name;
         }

         //Ejecuta sentencia sql
         //echo "$nRows, $offset<br/>";
         
         $this->tbl->prepQuery($nRows, $offset-1);

         $lModels = array();
         
         //Recorre lista de elementos
         while ($this->tbl->getRow()) {
             $resultRow=array();

             foreach($lFields as $fn)
                $resultRow[$fn] = $this->tbl->get($fn);
                
             //print_r($resultRow); echo "<hr>";

             //$resultList[] = $resultRow;
             
             //print_r($this->belongsTo);
             
             //procesa belongsTo
             foreach($this->belongsTo as $b) {
	             $className = $b["className"];
	             $foreignKey= $b["foreignKey"];
	             $fields    = $b["fields"];	             	             
	             
	             if (!file_exists(APP_PATH."/app/models/"._aNombreArchivo($className).".php")) 
	                throw new Exception("findAll: Clase '$className' no encontrada!");
	             
	             include_once(APP_PATH."/app/models/"._aNombreArchivo($className).".php");

	             if (isset($resultRow[$foreignKey]))
	                $key  = $resultRow[$foreignKey];
	             else
	                $key = "";
	             
	             if (!isset($lModels[$className]))
	                $lModels[$className] = new $className;
	                
	             $clase = $lModels[$className];
	             
	             if ($key=="") {
		            foreach($fields as $fnombre)
	                   $data[$className][$fnombre]="";
	             }
	             else
	                $data = $clase->read($fields, $key);
	             
	                
	             if (count($data)==0) {
		            $data=array();
	                foreach($clase->tbl->fields as $f)
	                   $data[][$className][$f->name]="";
                 }
	             
                 //print_r($data);
	             //echo ">>>>>>$className $foreignKey $key<hr>";
	             
	             //print_r($fields);

	             foreach($fields as $fname)
	                if (isset($resultRow[$fname])) {
		               $letras = explode(",", "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z");
		               
		               foreach($letras as $letra)
		                  if (!isset($resultRow[$fname."_".$letra])) {
	                         $resultRow[$fname."_".$letra] = $data[$className][$fname]; 
	                         break;
                          }
                    }
	                else { 
		               //echo "Voy a agregar el campo!<hr>";
		               if (isset($data[$className][$fname]))
	                      $resultRow[$fname] = $data[$className][$fname];
	                   else
	                      $resultRow[$fname] = "";
                    }	 
                    
                 //echo "resultRow: ";
	             //print_r($resultRow);
	             //echo "==================<hr>";           	             
             }
             
             $resultList[] = $resultRow;
             
             //procesa hasMany             
             //print_r($resultRow);       
                                
         }
         
         //Cantidad de registros a recuperar         
         $this->countRecs = count($resultList);
         
         return $resultList;
         
         //echo "Salgo de findAll<hr>";
      }//findAll
      
      function count() {
	     echo $this->tbl->dbErrorMessage;
	     
         return $this->tbl->count();   
      }

      function findByPk($vId) {
         $this->tbl->set($this->primaryKey, $vId);
         
         $this->data = array();
         if ($this->tbl->seek()) {
            foreach($this->tbl->fields as $f)
               $this->data[$this->name][$f->name] = $this->tbl->get($f->name);
            return true;
        }
         else
            return false;

      }//findByPk
      
      function getFieldList() {
	     if ($this->useTable=="")
	        return array();
	        
         $lFields = array();
         
         foreach($this->fields as $f)
            $lFields[] = $f->name;
            
         return $lFields;
      }
      
      function setData($oData) {
         $this->data = $oData;
      }
      
      function __call($function, $args) {
         if (!(strpos(strtolower($function), "findby")===false)) {
          $function = strtolower($function);
                      
          $field = str_replace("findby", "", $function);
          
          //Busco el campo en el modelo
          $fields = $this->getFieldList();
          $hallado = false;
          foreach($fields as $f) {
             if ($f==$field) {
                $hallado = true;
                break;
             }
          }
                      
          if (!$hallado) {
             print "El campo '$field', no existe en el modelo '$this->model'<hr>";
             return;
            }
            
            //Busco el campo $field en la estructura de la tabla base
            foreach($this->tbl->fields as $f) 
             if ($f->name==$field) {
                $fld = $f;
                break;
             }
            
            switch($fld->type) {
             case "N": $valor = $args[0]; break;
             case "C": $valor = "'".$args[0]."'"; break;
             case "D": $valor = "'".$args[0]."'"; break;
             default : $valor = "null"; break;
            }
            
            $r = $this->findAll("$field=$valor");
            
            if (!empty($r)) {
             $this->data = array();
             
             $r = $r[0];
             
             foreach($r as $key => $val) 
                $this->data[$this->name][$key] = $val;
                
             //print_r($this->data);
                
             return true; 
            }
            else
               return false;
         
         }
         else {     
            $args = implode(', ', $args);
            print "Call to undefined $function() with args '$args' failed!\n";
        }
      }
      
      function read($aFields=array(), $id=null) {	        
	     $arr = $this->findAll($this->primaryKey."=".$id, $aFields);
	     
	     if ($arr!=null)
	        return array($this->name => $arr[0]);
	     else
	        return array();
      }
      
      function genJsp() {  
	      global $smarty;
	              
          $s = "";
          
          if (isset($this->data[$this->name])) {
             foreach($this->validate as $field => $val) {
                $lista = explode("|", $val);
                                
                foreach($lista as $elem) {
                   $e = explode("=", $elem);
                   
                   //Valor actual del elemento
                   $valor = $this->data[$this->name][$field];
                   
                   //echo "$field = $valor<hr>";
                   
                   switch($e[0]) {
                      case "required"    : if (trim($valor)=="") 
                                              $this->errorList[$field] = "�Obligatorio!";
                                           
                                           break;
                                           
                      case "type"        : switch($e[1]) {
                                              case "rut"     : if (!isRut($valor))
                                                                  $this->errorList[$field] = "�Run inv�lido!"; 
                                                                                       break;
                                              
                                              case "number"  : if (!isNumber($valor))
                                                                  $this->errorList[$field] = "�Se esperaba un n�mero!"; 
                                                               break;
                                                                  
                                              case "integer" : if (!isInteger($valor))
                                                                  $this->errorList[$field] = "�Se esperaba un n�mero entero!"; 
                                                               break;
                                              
                                              case "date"    : if (!isDate($valor))
                                                                  $this->errorList[$field] = "�Se esperaba una fecha (DD/MM/AAAA)!"; 
                                                               break;
                                                               
                                              case "mail"    : if (!isEMail($valor))
                                                                  $this->errorList[$field] = "�E-Mail incorrecto!"; 
                                                               break;                                                              
                                           }
                                           break;
                                           
                      case "min"         : if ($valor < $e[1]) 
                                              $this->errorList[$field] = "�Valor debe ser mayor o igual a \"".number_format($e[1], 0, ".", ",")."\"!";
                                           break;
                                           
                      case "max"         : if ($valor > $e[1]) 
                                              $this->errorList[$field] = "�Valor debe ser menor o igual a \"".number_format($e[1], 0, ".", ",")."\"!";
                                           break;
                                           
                                           
                      case "userDefined" : $funcion=$e[1];
                                           $this->$funcion($valor);
                                           break;
                   }//switch
                   
                   if (isset($this->errorList[$field]))
                      break;
                }//foreach
             }           
          }
                          
          return $s;
      }//validates
      
      function findSql($cSql, $offset=0, $nRows=0) {
         //echo "findAll<br><hr>";
         
         return $this->tbl->execQuery($cSql, $nRows, $offset-1);
     }
   }//class Model
