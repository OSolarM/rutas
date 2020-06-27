<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {select}{/select} block plugin
 *
 * Type:     block function<br>
 * Name:     select<br>
 * Purpose:  format text a certain way with preset styles
 *           or custom wrap/indent settings<br>
 * @link http://smarty.php.net/manual/en/language.function.select.php {select}
 *       (Smarty online manual)
 * @param array
 * <pre>
 * Params:   style: string (email)
 *           indent: integer (0)
 *           wrap: integer (80)
 *           wrap_char string ("\n")
 *           indent_char: string (" ")
 *           wrap_boundary: boolean (true)
 * </pre>
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string string $content re-formatted
 */
function smarty_block_select($params, $content, &$smarty)
{

   if ($content==null) return;
   
   if (!isset($params['name'])) {
        $smarty->trigger_error("area: falta el parámetro 'name'.");
        return;
    }

    if($params['name'] == '') {
        $smarty->trigger_error("area: el parámetro 'name' debe contener un valor.");
        return;
    }
    
    $name=$params["name"];
    $id = isset($params["id"]) ? $params["id"] : $name;
    $value="";
    $readonly=false;
    $class="";
	
	//echo "contenido $name: ".$content."<hr/>";
    
    $readonly = isset($params["readonly"]) ? $params["readonly"] : "false";
    
    if (isset($smarty->_tpl_vars["form_readonly"])) {
        $readonly="true";
        
        if ($class!="")
           $class .=" sololectura";
        else
           $class .=" sololectura";
    }
    
    //Si la variable, $name, había sido asignada,
    //recupero su valor
    if (isset($smarty->_tpl_vars[$name])) 
       $value = $smarty->_tpl_vars[$name];
    else if (isset($params['value']))     
       $value = $params['value'];
    
    if ($readonly=="true") {
	   if (isset($params['size']))      
          $size = $params['size'];    
       else
          $size = 1;
       
	    $class = "sololectura";
	    if (isset($params['class'])) 
           $class .=" ".$params['class'];

	    $s = "<input type=\"hidden\" id=\"$name\" name=\"$name\" value=\"$value\"/>"; 
	    
	    $lista = explode(",", $content);
	    
		//echo "content $name: ".$content."<hr/>";
	    //print_r($lista); echo "<hr>"; echo $value."<hr>";
	    
	    $valor="";
	    foreach($lista as $e) {
		   //echo "E: ".$e."<hr/>";	
	       $v = explode("|", $e);
		   
		   //print_r($v);
	   
	       if ($v[1]==$value) {
	           $valor = $v[0];
	           break;
           }
        }
       
        $s .= "<input type=\"text\" name=\"$name"."_readonly"."\" value=\"$valor\" size=\"$size\" class=\"$class form-control\" readonly/>";
       
        return $s;
	    
    }
            

           
    if (isset($params['rows']))      
       $rows = $params['rows'];    
    else
       $rows = 1;
       
       
    if (isset($params['onchange'])) 
       $onchange=$params['onchange'];
    else
       $onchange="";
       
    if (isset($params['ondblclick'])) 
       $ondblclick=$params['ondblclick'];
    else
       $ondblclick="";
       
    if (isset($params['class'])) 
       $class=$params['class'];
    else
       $class="";
       
    if (isset($params['multiple'])) 
       $multiple=$params['multiple'];
    else
       $multiple="";       
       
    $s = "<select name=\"$name\" id=\"$id\"";
    
    if (!empty($onchange))   $s .= " onchange=\"$onchange\"";
    
    if (!empty($ondblclick)) $s .= " ondblclick=\"$ondblclick\"";
    
    if (!empty($class)) $s .= " class=\"$class\"";
    
    //if (!empty($rows))       $s .= " rows=\"$rows\"";
    
    if ($multiple =="true")  $s .= " multiple";
    
    $s .=">\n";
    //echo $content;
    $lista = explode(",", $content);
    
    //print_r($lista);
    
    foreach($lista as $e) {
	   $v = explode("|", $e);
	   
	   if ($v[1]==$value) 
	      $sSelected=" selected";
	   else
	      $sSelected="";
	      
	   $s .= "<option value=\"".$v[1]."\"$sSelected>".$v[0]."</option>\n";
    }
    
    $s .= "</select>\n";
    
    if (isset($smarty->_tpl_vars["msg_".$name])) 
       $value = $smarty->_tpl_vars["msg_".$name];
    else  
       $value = "";
       
    if ($value!="")
       $s .= "<img src=\"".APP_HTTP."/app/img/error2.png"."\" title=\"$value\">";
    
    return $s;
}

/* vim: set expandtab: */

?>
