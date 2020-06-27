<?php
   class Grid {
      var $fields=array();
      var $data=array();
      
      function Grid() {
	     //echo "Grid<hr>";
      }
      
      function addField($caption, $field, $attrs=array()) {
         $this->fields[] = array("name" => $field,
                                 "caption" => $caption,
                                 "attrs"   => $attrs
                                );  
                                
         //print_r($this->fields);       
      }
      
      function setData($aData=array()) {
         $this->data = $aData;
      }
      
      function showColumn($f) {
	     //print_r($f);
	     
	     $s = "";
	     
         $caption = $f["caption"];
         $name    = $f["name"];
         $attrs   = $f["attrs"];
         
         $sortColumn = isset($attrs["sortColumn"])?$attrs["sortColumn"]:true;
         
         if (!$sortColumn)
            $s .= "<th align=\"center\" style=\"background:#aabbcc;font-weight:bold;padding:4px;\">$caption</th>";
         else
            $s .= "<th align=\"center\" style=\"background:#aabbcc;font-weight:bold;padding:4px;\"><a href=\"javascript:setOrder('$name');\">$caption</a></th>";
         
         return $s;
	      
      }
      
      function showSearchColumn($f) {
	     //print_r($f);
	     
	     $s = "";
	     
         $caption = $f["caption"];
         $name    = $f["name"];
         $attrs   = $f["attrs"];
         
         
         
         $searchColumn = isset($attrs["searchColumn"])?$attrs["searchColumn"]:false;
         
         if ($searchColumn) {
            $s .= "<td align=\"center\" style=\"background:#aabbcc;font-weight:bold;padding:4px;\"><a href=\"javascript:setOrder('$name');\">$caption</a></td>";
         }
         else
            $s .= "<td>&nbsp;</td>";
         
         return $s;
	      
      }
      
      function showHeader() {
	     //echo "showHeader<hr>";
	      
	      //print_r($this->fields);
	      $s = "";
	      $colSearch=false;
	      foreach($this->fields as $f) {
		     $attrs   = $f["attrs"];
         
             $searchColumn = isset($attrs["searchColumn"])?$attrs["searchColumn"]:false; 
             
             if ($searchColumn) {
	            $colSearch=true;
	            break;
             }
	      }
	      
	      if ($colSearch) {
		     $s .= "<tr>";
	         foreach($this->fields as $f) 
	            $s .= $this->showSearchColumn($f);
	         $s .= "</tr>\n";
	      }
	      
	      
	      
	      $s .= "<thead><tr>";
	      foreach($this->fields as $f)
	         $s .= $this->showColumn($f);
	      $s .= "</tr></thead>\n";
	      
	      return $s;
      }
      
      function showField($f, $row) {	     
	     //print_r($row);
	     $name    = $f["name"];
	     $attrs   = $f["attrs"];
	     $caption = $f["caption"];
	     
	     $ownShow = isset($attrs["ownShow"])?$attrs["ownShow"]:"";
	     
	     $format  = isset($attrs["format"])?$attrs["format"]:"";
	     
	     if ($ownShow!="") 
	        $value = $this->$ownShow($f, $row);
	     else
	        $value   = $row[$name];
	         
	     $trad = isset($attrs["trad"])?$attrs["trad"]:array();
	     
	     if (count($trad) > 0)
	        if (isset($trad[$value]))
	           $value = $trad[$value];
	        else
	           $value = "";
	        
	     if ($format=="money" && $value!="") 
	        $value = "$".number_format($value, 0, ",", ".");
	     
	     $align = isset($attrs["align"])?$attrs["align"]:"left";
	        
	     return "<td align=\"$align\" style=\"background:white;padding:4px;\" >$value</td>";	      
      }
      
      function showRow($row=array()) {
	      $s = "<tr>";
	      	      	      
	      foreach($this->fields as $f)
	         $s .= $this->showField($f, $row);
	         
	      $s .= "</tr>\n";
	      
	      //echo $s."<hr/>";
	      return $s;
      }
      
      function scColsPresent() {
	     foreach($this->fields as $f) {
		    $attrs = $f["attrs"];
		    		    
		    $searchCol = isset($attrs["searchCol"])?$attrs["searchCol"]:false;
		    
		    if ($searchCol) return true; //There are search columns
	     }
	     
	     return false; 
      }
      
      function showSearchField($f) {	     
	     //print_r($row);
	     $name    = $f["name"];
	     $attrs   = $f["attrs"];
	     $caption = $f["caption"];
	     
	     $searchCol = isset($attrs["searchCol"])?$attrs["searchCol"]:false;
	     
	     if ($searchCol) {	        
	        $scGadget = isset($attrs["scGadget"]) ?$attrs["scGadget"]:"Input";
	        $scType   = isset($attrs["scType"])?$attrs["scType"]:"C";
	        $scLen    = isset($attrs["scLen"]) ?$attrs["scLen"]:10;
	        
	        $value="";
	        
	        switch($scGadget) {
		       case "Input": $value = "<input type=\"text\" name=\"$name\" size=\"$scLen\" maxlength=\"$scLen\"";
		                     if ($scType=="N")
		                        $value .= " style=\"text-align:right\"";
		                        
		                     if (isset($_REQUEST[$name])) {
			                    $value .= " value=\"".$_REQUEST[$name]."\"";
		                     }
		                        
		                     $value .= "/>";
		       
	        }
         }
         else
            $value="";
	     
	     $align = isset($attrs["align"])?$attrs["align"]:"left";
	        
	     return "<td align=\"center\" style=\"background:white;padding:4px;\" >$value</td>";	      
      }
      
      function showSearchCols() {
	      if (!$this->scColsPresent())
	         return "";
	         
	      $s = "<tr>";
	      $n = 0;	  
	      
	      $size = count($this->fields);
	          	      
	      foreach($this->fields as $f) {	
		     $n++; 
		     
		     if ($n < $size) 
		        $s .= $this->showSearchField($f);
		     else 
		        $s .= "<td align=\"center\" style=\"background:white;padding:4px;\" ><input type=\"button\" id=\"searchButton\" value=\"Buscar\"  onclick=\"document.frm.submit();\"/></td>";
          }   
	      $s .= "</tr>\n";
	      
	      if ($n==0) $s="";
	      
	      //echo $s."<hr/>";
	      return $s;
      }
      
      
      function showRows() {
	     $ss = $this->showSearchCols();
	     
	     foreach($this->data as $row)
	        $ss .= $this->showRow($row);
	        
	     return $ss;
      }
      
      function showFooter() {
	     return "";
      }
      
      function show() {
	     //print_r($this->fields);
	     
	     //echo "show<hr>";
         return "<table class='table'>\n".
                $this->showHeader() .
                $this->showRows().
                $this->showFooter().
                "</table>\n</td></tr>\n</table>\n";
      }
   }