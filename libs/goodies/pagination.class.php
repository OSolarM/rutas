<?php
  /************************************************************\
  *
  *	  PHP Array Pagination Copyright 2007 - Derek Harvey
  *	  www.lotsofcode.com
  *
  *	  This file is part of PHP Array Pagination .
  *
  *	  PHP Array Pagination is free software; you can redistribute it and/or modify
  *	  it under the terms of the GNU General Public License as published by
  *	  the Free Software Foundation; either version 2 of the License, or
  *	  (at your option) any later version.
  *
  *	  PHP Array Pagination is distributed in the hope that it will be useful,
  *	  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *	  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
  *	  GNU General Public License for more details.
  *
  *	  You should have received a copy of the GNU General Public License
  *	  along with PHP Array Pagination ; if not, write to the Free Software
  *	  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA	02111-1307	USA
  *
  \************************************************************/

  class pagination {
	var $vars;
    var $page = 1; // Current Page
    var $perPage = 10; // Items on each page, defaulted to 10
    var $showFirstAndLast = false; // if you would like the first and last page options.
    var $currPage=""; //Current page where to navigate
    
    function pagination($currPage, $page, $vars=false){
	   $this->currPage = "/rutas".$currPage;
	   $this->page     = $page;
	   $this->vars	   = $vars;
    }
    
    function generate($array, $numRecs, $perPage = 10){
      // Assign the items per page variable
      if (!empty($perPage))
        $this->perPage = $perPage;
      
      // Take the length of the array
      $this->length = $numRecs;
      
      // Get the number of pages
      $this->pages = ceil($this->length / $this->perPage);
      
      // Calculate the starting point 
      $this->start  = ceil(($this->page - 1) * $this->perPage);
      
      // Return the part of the array we have requested
      //return array_slice($array, $this->start, $this->perPage);
      
      return $array;
    }
    
    function links(){
      // Initiate the links array
      $plinks = array();
      $links = array();
      $slinks = array();
      
      // If we have more then one pages
      if (($this->pages) > 1)
      {
        // Assign the 'previous page' link into the array if we are not on the first page
        if ($this->page != 1) {
          if ($this->showFirstAndLast) {
            $plinks[] = " <a href=\"$this->currPage\"/1\"$this->vars\"".">&laquo;&laquo; Primero </a> ";
          }
          $plinks[] = " <a href=\"$this->currPage"."/".($this->page - 1)."$this->vars"."\"\"$this->vars\">&laquo; Anterior</a> ";
        }        
        
        // Assign all the page numbers & links to the array
        for ($j = 1; $j < ($this->pages + 1); $j++) {
          if ($this->page == $j) {
            $links[] = ' <a class="selected">'.$j.'</a> '; // If we are on the same page as the current item
          } else {
            $links[] = " <a href=\"$this->currPage"."/".$j."$this->vars"."\">".$j."</a> "; // add the link to the array
          }
        }
  
        // Assign the 'next page' if we are not on the last page
        if ($this->page < $this->pages) {
          //$slinks[] = " <a href=\"$this->currPage"."/".($this->page + 1)."\"> Siguiente &raquo; </a> ";
		  $page = ($this->page + 1);
          //$slinks[] = " <a href=\"$this->currPage"."/".$page."\"> Siguiente &raquo; </a> ";
          $slinks[] = " <a href=\"$this->currPage"."/".$page."$this->vars"."\"> Siguiente &raquo; </a> ";
          	if ($this->showFirstAndLast) {
            	$slinks[] = " <a href=\"$this->currPage"."/".($this->pages)."$this->vars"."\"> Último &raquo;&raquo; </a> ";
          	}
        }
        
        //print_r($slinks);
        
        // Push the array into a string using any some glue
        return implode(' ', $plinks).implode(' ', $links).implode(' ', $slinks);
      }
      return;
    }
  }
?>
