<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {area} function plugin
 *
 * Type:     function<br>
 * Name:     eval<br>
 * Purpose:  generate an html area field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_area($params, &$smarty)
{

    if (!isset($params['name'])) {
        $smarty->trigger_error("area: falta el parámetro 'name'.");
        return;
    }

    if($params['name'] == '') {
        $smarty->trigger_error("area: el parámetro 'name' debe contener un valor.");
        return;
    }
    
    $name=$params["name"];
    $value="";
    $readonly=false;
    $class="";
            
    //Si la variable, $name, había sido asignada,
    //recupero su valor
    if (isset($smarty->_tpl_vars[$name])) 
       $value = $smarty->_tpl_vars[$name];
    else if (isset($params['value']))     
       $value = $params['value'];
    
    if (isset($params['rows']))      
       $rows = $params['rows'];    
    else
       $rows = 3;
    
    if (isset($params['cols']))      
       $cols = $params['cols'];    
    else
       $cols = 50;
        
    if (isset($params['class']))     
       $class     = $params['class'];    
    else
       $class     = "";
       
    if (isset($params['readonly']))     
       $readonly  = $params['readonly'];    
    else
       $raedonly  = "";   
        
    $s = "<textarea name=\"$name\" id=\"$name\" rows=\"$rows\" cols=\"$cols\"";
    
    if ($readonly=="true") $s .=" readonly";
    
    if (isset($smarty->_tpl_vars["form_readonly"])) {
        $readonly="true";
        
        if ($class!="")
           $class .=" sololectura";
        else
           $class .=" sololectura";
    }
    
    if (!empty($class)) 
       $s .=" class=\"$class form-control\"";
       
    $s .= ">$value</textarea>";
    
    if (isset($smarty->_tpl_vars["msg_".$name])) 
       $value = ($smarty->_tpl_vars["msg_".$name]);
    else  
       $value = "";

    $s .= "<font color=\"red\"><label id=\"msg_$name\">$value</label></font>";

    return $s;
}
?>