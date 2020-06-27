<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {submit} function plugin
 *
 * Type:     function<br>
 * Name:     submit<br>
 * Purpose:  generate an html submit field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_submit($params, &$smarty)
{

    if (!isset($params['value'])) {
        $smarty->trigger_error("submit: missing 'value' parameter");
        return;
    }

    if($params['value'] == '') {
        $smarty->trigger_error("submit: 'value' parameter must have a value");
        return;
    }

    $value=$params['value'];
    $type="submit";    
    $readonly=false;
    $class="";
    $onclick="";
         
    if (isset($params['class']))     $size      = $params['class'];    
        
    if (isset($params['readonly']))  $readonly  = $params['readonly'];    
    
    if (isset($params['class']))     $class     = $params['class'];    
    
    if (isset($params['onclick']))   $onclick   = $params['onclick'];    
        
    $s = "<input type=\"submit\" value=\"$value\"";
    
    if (!empty($class)) 
       $s .=" class=\"$class\"";
       
    if (!empty($onclick)) 
       $s .=" onclick=\"$onclick\"";   
       
    $s .= "/>";

    return $s;
}
?>