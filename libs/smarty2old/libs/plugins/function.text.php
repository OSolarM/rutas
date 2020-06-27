<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {text} function plugin
 *
 * Type:     function<br>
 * Name:     eval<br>
 * Purpose:  generate an html text field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_text($params, &$smarty)
{

    if (!isset($params['name'])) {
        $smarty->trigger_error("text: falta el parametro 'name'.");
        return;
    }

    if($params['name'] == '') {
        $smarty->trigger_error("text: el parametro 'name' debe contener un valor.");
        return;
    }


    $name      = isset($params["name"] )     ?$params["name"]     :"NONAME";
    $size      = isset($params["size"] )     ?$params["size"]     :10;
    $maxlength = isset($params["maxlength"] )?$params["maxlength"]:$size;
    $readonly  = isset($params["readonly"] ) ?$params["readonly"] :"false";
    $type      = isset($params["type"] )     ?$params["type"]     :"C";
    $class     = isset($params["class"] )    ?$params["class"]    :"";
    $style     = isset($params["style"] )    ?$params["style"]    :"";
    $before    = isset($params["before"] )   ?$params["before"]   :"";
    $middle    = isset($params["middle"] )   ?$params["middle"]   :"";
    $after     = isset($params["after"]  )   ?$params["after"]    :"";
    $caption   = isset($params["caption"])   ?$params["caption"]  :"";
    $div       = isset($params["div"])       ?$params["div"]      :"true";
    
    if (isset($smarty->_tpl_vars[$name]))
       $value = $smarty->_tpl_vars[$name];
    else if (isset($params['value']))
       $value = $params['value'];




    $s = "<input type=\"text\"";

    $s .= " name=\"$name\" id=\"$name\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\"";
    
    if (!empty($class)) $s .=" class=\"$class\"";
    
    if (!empty($style)) $s .=" style=\"$style\"";
    
    
    if ($readonly=="true") $s .=" readonly";

    $s .= "/>";

   if (isset($smarty->_tpl_vars["msg_".$name])) 
       $value = $smarty->_tpl_vars["msg_".$name];
    else  
       $value = "";
    
    $s = "$before$caption$middle$s$after"."<font color=\"red\"><label id=\"msg_$name\">$value</label></font>"."\n";

    return $s;             
    
}