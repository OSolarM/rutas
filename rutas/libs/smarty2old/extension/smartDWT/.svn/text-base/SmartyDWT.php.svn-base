<?php
/**
*	SmartyDWT class
*
*	This class extends the Smarty class. 
*	It adds prefiltering which is needed to convert all 
*	smarty tags used within dreamweaver to the standard
*	tag format used within smarty. 
*
*	smartyDWT is published under the CC-GNU LGPL:
*	http://creativecommons.org/licenses/LGPL/2.1/
*
*	It is provided as is. No warrenties. No support.
*	Use it. Improve it. Let me know.
*
*	KLITSCHE.DE // DIRK ALBAN ADLER
*
*	http://smartydwt.klitsche.org
*/
require_once ("smarty/Smarty.class.php");

/**
*	Prefilter for Smarty to rewrite smarty tags used within
*	the SmartyDWT Macromedia Dreamweaver extionsion.
*
*	TODO:
*	+ don´t rewrite in literal tags
*/
function rewriteDreamweaverExtension ($source, &$smarty)
{

	$pattern = array ('|\{\$([^}]+)\}|i', '|\{#([^#]+)#\}|i');
	$replace = array ("<" . "?smarty:\$$1?" . ">", "<" . "?smarty:#$1#?" . ">");
	$ret = preg_replace ($pattern, $replace, $source);
	return $ret;
}

class SmartyDWT extends Smarty
{
	function SmartyDWT ()
	{
		$this -> left_delimiter = "<" . "?smarty:";
		$this -> right_delimiter = "?" . ">";
		$this -> register_prefilter ("rewriteDreamweaverExtension");
		$this -> register_modifier ("strpad", "str_pad");
	}
	
/**
*	Fetches a part of a template that is included between the comment tags
*	<!-- smartyBegin --> and <!-- smartyEnd -->
*	
*	I use this to keep the outer design, style sheets, etc of a template in Dreamweavers design view.
*/
	function fetchSub ($template)
	{
		preg_match ("|<\!--\s*smartyBegin\s*-->(.*)<\!--\s*smartyEnd\s*-->|sim", $this -> fetch ($template), $m);
		return $m[1];
	}
}
?>