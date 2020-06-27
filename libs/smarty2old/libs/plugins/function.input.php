<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {input} function plugin
 *
 * Type:     function<br>
 * Name:     eval<br>
 * Purpose:  generate an html input field
 * @author Osciel Solar
 * @param array
 * @param Smarty
 */
function smarty_function_input($params, &$smarty) {

    if (!isset($params['name'])) {
        $smarty->trigger_error("input: falta el parametro 'name'.");
        return;
    }

    if ($params['name'] == '') {
        $smarty->trigger_error("input: el parametro 'name' debe contener un valor.");
        return;
    }


    $name = isset($params["name"]) ? $params["name"] : "NONAME";
    $id = isset($params["id"]) ? $params["id"] : $name;
    $size = isset($params["size"]) ? $params["size"] : 10;
    $maxlength = isset($params["maxlength"]) ? $params["maxlength"] : $size;
    $readonly = isset($params["readonly"]) ? $params["readonly"] : "false";
    $type = isset($params["type"]) ? $params["type"] : "C";
    $class = isset($params["class"]) ? $params["class"] : "";
    $style = isset($params["style"]) ? $params["style"] : "";
    $before = isset($params["before"]) ? $params["before"] : "";
    $middle = isset($params["middle"]) ? $params["middle"] : "";
    $after = isset($params["after"]) ? $params["after"] : "";
    
    $kind = isset($params["kind"]) ? $params["kind"] : "input";

    $div = isset($params["div"]) ? $params["div"] : "true";

    if (isset($smarty->_tpl_vars[$name]))
        $value = $smarty->_tpl_vars[$name];
    else if (isset($params['value']))
        $value = $params['value'];
	else
		$value="";

        
    if (isset($smarty->_tpl_vars["form_readonly"])) {
        $readonly="true";
        
        if ($class!="")
           $class .=" sololectura";
        else
           $class ="sololectura";
    }

    $s = "<input type=\"$kind\"";

    $s .= " name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\"";
    
    //echo strpos($name, "fecha")== true ?$name:"";
    //echo strpos($name, '_fec_')== true ?$name:"";
    //if ((strpos($name, "fecha") == true || strpos($name, '_fec_') == true) && $readonly!="true" && $size==10) 
    //   $class="calendario";

    if (!empty($class))
        $s .=" class=\"$class\"";

    if (!empty($style))
        $s .=" style=\"$style\"";


    if ($readonly == "true")
        $s .=" readonly class=\"sololectura\"";

    $s .= "/>";

    if (isset($smarty->_tpl_vars["msg_" . $name]))
        $msg_error = $smarty->_tpl_vars["msg_" . $name];
    else
        $msg_error = "";

    //$s = "$before$caption$middle$s$after"."<font color=\"red\"><label id=\"msg_$name\">$value</label></font>"."\n";
    //$s = "$before$caption$middle$s$after";
    //if ($div=="true") {
    //   $caption   = isset($params["caption"])?$params["caption"]:$name;
    //   $s ="<div><label for=\"$name\">$caption</label>$s</div>";
    //}

    if ($msg_error != "")
        $s .= "<img src=\"".APP_HTTP."/app/img/error2.png"."\" title=\"$msg_error\">";

    return $s;
}
