<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {button} function plugin
 *
 * Type:     function<br>
 * Name:     button<br>
 * Purpose:  generate an html button field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_button($params, &$smarty)
{

    if (!isset($params['value'])) {
        $smarty->trigger_error("button: missing 'value' parameter");
        return;
    }

    if($params['value'] == '') {
        $smarty->trigger_error("button: 'value' parameter must have a value");
        return;
    }

    $value=$params['value'];
    $type="button";    
    $readonly=false;
    $class="";
    $onclick="";
    $id="";
        
    if (isset($params['type']))      $type      = $params['type'];
    
    if (isset($params['class']))     $size      = $params['class'];    
        
    if (isset($params['readonly']))  $readonly  = $params['readonly'];    
    
    if (isset($params['class']))     $class     = $params['class'];    
    
    if (isset($params['onclick']))   $onclick   = $params['onclick'];

    if (isset($params['id']))        $id   = $params['id'];
    
    if (isset($smarty->_tpl_vars["form_readonly"])) {
        $readonly="true";
        
        if ($class!="")
           $class .=" sololectura";
        else
           $class .=" sololectura";
    }
        
    $s = "<input type=\"$type\" value=\"$value\"";

    if (!empty($id))
       $s .= " id=\"$id\"";

    if (!empty($class)) 
       $s .=" class=\"$class\"";
       
    if (!empty($onclick)) 
       $s .=" onclick=\"$onclick\"";   
       
    $s .= ">";

    return $s;
}
?>