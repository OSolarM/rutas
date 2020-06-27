<?php
/**
 * Detalles de TTable
 */

class TField {
	var $name;
	var $type;
	var $len;
	var $dec;
	var $pk;
	var $req;
	var $value;
	var $auto;
	

	function TField($name, $type, $len, $dec, $pk, $req) {
		$this->name = $name;
		$this->type = $type;
		$this->len = $len;
		$this->dec = $dec;
		$this->pk = $pk;
		$this->req = $req;
		$this->value = "";
		$this->auto  = false;
	}
}

/**
 * TTable : Clase para encapsular tabla sql permite insertar, modificar, eliminar y recorrer.
 * @author  Osciel Solar M.<osolar@salfa.cl>
 * @version 1.0, Enero 2006
 * @copyright Copyright &copy; 2006, O.Solar M.
 */
class TTable {
	/**Nombre de la tabla SQL asociada al objeto
	 *@var string
	 */
	var $name;
	/**Lista de campos de tipo TField
	 *@var array
	 */
	var $fields;
	/**Cla?sula "where" para filtrar datos
	 *@var string
	 */
	var $where;
	/**Cla?sula "order" para ordenar lista de registros
	 *@var string
	 */
	var $order;
	/**
	 *@access private
	 */
	var $row;
	/**
	 *@access private
	 */
	var $result;

	var $dbcon;
	
	var $debug;
	
	var $dbErrorMessage;
        var $ownPk;

	function __construct($name) {
		global $oConexion;
		
		//echo "Clase a construir $name\n";
		
		$this->name = $name;		
		$this->fields = array ();
		$this->where = "";
		$this->order = "";
		$this->debug=false;
		
		$this->dbcon = $oConexion;
		
		$this->fillStructure();
	}
	
	function __destruct() {
		
		//echo "TTable: destructor<hr/>";
		//$this->dbcon->Close();	   
	}

	function fillStructure() {
		//echo "select * from $this->name where 1=2\n";
		$this->result = $this->dbcon->Execute("select * from $this->name where 1=2");
				
		for ($i = 0; $i < $this->result->FieldCount(); $i ++) {
			$field = $this->result->FetchField($i);

			$type = $this->result->MetaType($field->type, $field->max_length);

			switch ($type) {
				case "C" :
				case "X" :
					$type = "C";
					break;

				case "I" :
				    $type = "I";
				    break;
				    
				case "N" :
				case "R" :
					$type = "N";
					break;

				case "T" :
				case "D" :
					$type = "D";
					break;
			}

			$pk = false;
			$req = false;

			
			$this->addField($field->name, $type, $field->max_length, 0, $pk, $req);
		}
		
		$this->result->Close();
		
		//c?digo para MYSQL
        $rs = $this->dbcon->Execute("desc $this->name");
        
        while (!$rs->EOF) {
	       $pk=false;
	       $req=true;
	       $nombre=$rs->fields["Field"];
	       
	       if ($rs->fields["Null"]=="YES") 
	          $req=false;
	          
	       if ($rs->fields["Key"]=="PRI") {
		      $pk=true;
		      $req=true;
	       }
	       
	       for ($i=0; $i < count($this->fields); $i++) 
	          if ($this->fields[$i]->name==$nombre) {
		         $this->fields[$i]->pk =$pk;
		         $this->fields[$i]->req=$req;
		         break;
	          }
	          
	       $rs->MoveNext();
        }
        
        $rs->Close();		
        
	} //fillStructure

	function clear() {
	    for ($i=0; $i < count($this->fields); $i++)
	       $this->fields[$i]->value="";

	} //clear   

	function free() {
		//$this->dbcon->Close();
	}

	function addField($name, $type, $len, $dec, $pk, $req) {
		//echo "$name $type $len $dec $pk $req<br>";

		$this->fields[] = new TField($name, $type, $len, $dec, $pk, $req);
	}

	function set($cField, $cValue) {
		for ($i = 0; $i < count($this->fields); $i ++) {
			//echo $this->fields[$i]->name."<br>"; 
			if ($this->fields[$i]->name == $cField) {
				//echo "Asigno value<br>";
				$this->fields[$i]->value = $cValue;

				//echo $this->fields[$i]->value."<br>";
				break;
			}
		}
	}

	function get($cField) {
		for ($i = 0; $i < count($this->fields); $i ++)
			if ($this->fields[$i]->name == $cField)
				return $this->fields[$i]->value;

		return "";
	}

	function seek() {	
		$this->dbErrorMessage="";
		   	
		$lista = "";
		foreach ($this->fields as $c) {
			if ($lista != "")
				$lista .= ",";

			if ($c->type == "D")
				$lista .= $c->name;
			else
				$lista .= $c->name;
		}

		$lista2 = "";
		foreach ($this->fields as $c)
			if ($c->pk) {
				if ($lista2 != "")
					$lista2 .= " and ";

				//echo "<h1>value: ".$c->value."</h1>";

				if ($c->type == "C")
					$lista2 .= $c->name."='".$c->value."'";
				else
					if ($c->type == "D")
						$lista2 .= "$c->name=convert(char(10), '$c->value', 101)";
					else
						$lista2 .= $c->name."=".$c->value;

			}

		$sql = "select $lista from $this->name where $lista2";

		//echo $sql;

		$rs = $this->dbcon->Execute($sql);

		if (!$rs)
			die("seek: $sql fall?!");

		if (!$rs->EOF) {

			for ($i = 0; $i < count($this->fields); $i ++) {
				$name = $this->fields[$i]->name;
				$this->fields[$i]->value = $rs->fields["$name"];
				
				if ($this->fields[$i]->type=="D")
				   $this->fields[$i]->value = mysql2Date($this->fields[$i]->value);

				//echo $name.'='.$this->fields[$i]->value."<br>";
			}

			$salida = true;
		} else {
			$salida = false;
        }
		$rs->Close();

		return $salida;
	} //seek

	function update() {
		$this->dbErrorMessage="";
		
		//echo "Estoy en update!<hr>";
		$lista = "";
		foreach ($this->fields as $c)
			if ($c->pk) {
				if ($lista != "")
					$lista .= " and ";
			    
				if ($c->type == "C") 
					$lista .= $c->name."='".$c->value."'";
				elseif ($c->type == "D")
				   $lista .= "$c->name = '$c->value'";
				else
					$lista .= $c->name."=".$c->value;
			}

		$lista2 = "";
		foreach ($this->fields as $c) {
		    if ($c->name=="modified") 
		       $c->value="now()";
		       
			if (!$c->pk) {
			   if ($lista2 != "")
					$lista2 .= ", ";

				//echo "<h1>name: ".$c->name." ".$c->type."</h1>";

                               if (trim($c->value)=="")
                                      $lista2 .= "$c->name=null";
                               elseif ($c->type == "C") {
				   $lista2 .= "$c->name=".$this->dbcon->qstr($c->value)."";
				}
				elseif ($c->type == "D") {
				   if ($c->name=="modified")
				      $lista2 .= "$c->name=now()";
				   else
				      $lista2 .= "$c->name='".date2Mysql($c->value)."'";
			        }
			        else {
                                   
				      $lista2 .= "$c->name=".$c->value; //(trim($c->value)!="")?$c->value:"NULL";
                                }

			}
		}

		$sql = "update $this->name set $lista2 where $lista";

	        //echo $sql."<br>";	  

		$rs = $this->dbcon->Execute($sql);
		
		if ($rs) {
           $rs->Close();
		   return true;
	    }
		else {
		   $this->dbErrorMessage = $this->dbcon->ErrorMsg();
		   return false;
	    }
	}

	function insert() {
		//echo "Estoy en insert!<hr>";
		$this->dbErrorMessage="";
		
		$lista = "";
		foreach ($this->fields as $c) 
		   if (!$c->pk) {
			  if ($lista != "")
				 $lista .= ",";

			$lista .= $c->name;
		  }

		  
		$lista2 = "";
		foreach ($this->fields as $c) 
		   if (!$c->pk) {
			if ($lista2 != "")
				$lista2 .= ", ";

			//echo "<h1>value: ".$c->value."</h1>";

			if ($c->name=="created") {
			   $lista2 .= "now()";
			}			
			elseif     ($c->value=="") 
			    $lista2 .= 'NULL';			    
			elseif ($c->type == "C") {
			    $c->value = $this->dbcon->qstr($c->value);
				$lista2 .= stripslashes($c->value);
			}
			elseif ($c->type == "D") 
			   $lista2 .= "'".date2Mysql($c->value)."'";
			else
				$lista2 .= $c->value;

		}

		$sql = "insert into $this->name ($lista) values ($lista2)";

		//echo $sql."<hr>";

		$rs = $this->dbcon->Execute($sql);

                $this->ownPk = $this->dbcon->Insert_ID();
		
		if ($rs) {
           $rs->Close();
		   return true;
	    }
		else {
		   $this->dbErrorMessage = $this->dbcon->ErrorMsg();
                   echo $this->dbErrorMessage;
		   return false;
	    }
	}

        function insertId() {
           return $this->ownPk;
        }

	function delete() {
		$this->dbErrorMessage="";
		
		$lista = "";
		foreach ($this->fields as $c)
			if ($c->pk) {
				if ($lista != "")
					$lista .= " and ";

				if ($c->type == "C")
					$lista .= $c->name."='".$c->value."'";
				elseif ($c->type == "D")
				    $lista .= "$c->name='$c->value'";
				else
					$lista .= $c->name."=".$c->value;
			}

		$sql = "delete from $this->name where $lista";

		//echo $sql."<br>";	  

		$rs = $this->dbcon->Execute($sql);
		
  	    if ($rs) {
           $rs->Close();
		   return true;
	    }
		else {
		   $this->dbErrorMessage = $this->dbcon->ErrorMsg();
		   return false;
	    }
	}

	function count() {
		$this->dbErrorMessage="";
		
		$sql = "select count(*) CUENTA from $this->name ";

		if ($this->where != "")
			$sql .= " where $this->where";

		//echo "count: $sql <br>";   

		$rs = $this->dbcon->Execute($sql);

		if (!$rs)
			die($sql."fall?!");

		$cuenta = $rs->fields["CUENTA"];

		$rs->Close();

		return $cuenta;

	} //count      

	function prepQuery($nRows = 0, $offset = 0) {
		//echo ">>>>prepQuery: $nRows  $offset<hr>";
		$this->dbErrorMessage="";
		
		$lista = "";
		foreach ($this->fields as $c) {
			if ($lista != "")
				$lista .= ",";

			if ($c->type == "D")
				$lista .= "$c->name";
			else
				$lista .= $c->name;
		}

		$sql = "select $lista from $this->name ";

		if ($this->where != "")
			$sql .= " where $this->where";

		if ($this->order != "")
			$sql .= " order by $this->order";
	
		if ($this->debug)
			echo "prepQuery: $sql<br>";

		if ($nRows == 0)
			$this->result = $this->dbcon->Execute($sql);
		else {
			//echo "Voy a SelectLimit $sql<br>";

			$this->result = $this->dbcon->SelectLimit($sql, $nRows, $offset);
		}

		//echo $sql."<hr/>";
	} //prepQuery

	function closeQuery() {
		$this->dbErrorMessage="";
		$this->result->Close();
	} //closeQuery

	function getRow() {
		//echo "Tabla nombre >>>>: '".$this->name."'<br/>";
		
		if ($this->name=="") return false;
		
		//echo "Tabla nombre XXXXXX: '".$this->name."'<br/>";
		
		//foreach($this->fields as $f)
		//   echo $f->name."<br/>";
		
		//print_r($this);
		
		if (!$this->result->EOF) {
			//echo "Halle fila!<br>";
			for ($i = 0; $i < count($this->fields); $i ++) {
				$this->fields[$i]->value = $this->result->fields[$this->fields[$i]->name];

				if ($this->fields[$i]->type == "N")
					$this->fields[$i]->value = str_replace(",", ".", $this->fields[$i]->value);
					
				
                if ($this->fields[$i]->type == "D") {
					$this->fields[$i]->value = mysql2Date($this->fields[$i]->value);					
				}
			}

			$this->result->MoveNext();

			return true;
		} else
			return false;
	} //getRow

	function genListaPk() {
		$lista = "";

		foreach ($this->fields as $c)
			if ($c->pk) {
				if ($lista != "")
					$lista .= ", ";

				$lista .= $c->name;
			}

		return $lista;
	} //genListaPk()  

	function gather() {
		for ($i = 0; $i < count($this->fields); $i ++) {
			$nombre = $this->fields[$i]->name;

			if (isset ($_REQUEST["$nombre"]))
				$this->fields[$i]->value = $_REQUEST["$nombre"];
			else
				$this->fields[$i]->value = "";
		}
	} //gather   
	
	
   function aExcel() {
   
   $this->prepQuery();
   
  $header="";
   
   foreach ($this->fields as $c)
      $header .= $c->name . "\t";
      
   $data="";   
   
   while ($this->getRow()) {
      $line="";
   
      foreach($this->fields as $c) {
        $value = $this->get($c->name);
        
        if ((!isset($value)) OR ($value == "")) { 
             $value = "\t"; 
        } else { 
             $value = str_replace('"', '""', $value); 
             $value = '"' . $value . '"' . "\t"; 
        } 
        $line .= $value; 		   			   
      }
      $data .= trim($line)."\n"; 
   }

   $data = str_replace("\r","",$data);	     
   $this->closeQuery();
   

      header("Content-type: application/x-msdownload"); 
      header("Content-Disposition: attachment; filename=salida.xls"); 
      header("Pragma: no-cache"); 
      header("Expires: 0"); 
      print "$header\n$data";  
   
   }//aExcel	
   
   function execQuery($sql, $nRows = 0, $offset = 0) {
		//echo " $sql $nRows  $offset<hr>";
		$this->dbErrorMessage="";

		if ($nRows == 0)
			$this->result = $this->dbcon->Execute($sql);
		else {
			//echo "Voy a SelectLimit $sql<br>";

			$this->result = $this->dbcon->SelectLimit($sql, $nRows, $offset);
		}
		
		$arr = $this->result->getRows();
		
		$this->result->Close();
		
		for ($i=0; $i < count($arr); $i++) 
		   foreach($this->fields as $f)
		      if (isset($arr[$i][$f->name])) {
			    $valor = $arr[$i][$f->name];

				if ($f->type == "N")
					$arr[$i][$f->name] = str_replace(",", ".", $valor);
					
				
                if ($f->type == "D") 
					$arr[$i][$f->name] = mysql2Date($valor);					
				
			     
		      }
			
		return $arr;

   } //execQuery

} // TTable
