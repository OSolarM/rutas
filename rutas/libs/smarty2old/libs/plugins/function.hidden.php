<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {hidden} function plugin
 *
 * Type:     function<br>
 * Name:     eval<br>
 * Purpose:  generate an html hidden field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_hidden($params, &$smarty)
{

    if (!isset($params['name'])) {
        $smarty->trigger_error("hidden: falta el parámetro 'name'.");
        return;
    }

    if($params['name'] == '') {
        $smarty->trigger_error("hidden: el parámetro 'name' debe contener un valor.");
        return;
    }
    
    $name=$params["name"];
    $value="";
            
    //Si la variable, $name, había sido asignada,
    //recupero su valor
    if (isset($smarty->_tpl_vars[$name])) 
       $value = $smarty->_tpl_vars[$name];
    else if (isset($params['value']))     
       $value = $params['value'];
        
    $s = "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"$value\"/>";
    
    
    return $s;
}
?>