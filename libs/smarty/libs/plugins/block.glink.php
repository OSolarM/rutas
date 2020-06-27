<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {glink}{/glink} block plugin
 *
 * Type:     block function<br>
 * Name:     glink<br>
 * Purpose:  format text a certain way with preset styles
 *           or custom wrap/indent settings<br>
 * @link http://smarty.php.net/manual/en/language.function.glink.php {glink}
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
function smarty_block_glink($params, $content, &$smarty)
{

	$caption="";    
	$img="";
    $controller="";
    $action="index";
    $target="";
    
    if (isset($params['caption'])) {
       if ($params['caption'] == '') {
          $smarty->trigger_error("glink: el parámetro 'caption' debe contener un valor.");
          return;
       }
       else
          $caption=$params['caption'];
    }
       
    if (isset($params['img'])) {    
       if ($params['img'] == '') {
          $smarty->trigger_error("glink: el parámetro 'img' debe contener un valor.");
          return;
       }
       else
          $img=$params['img'];
    }
       
    
    if (isset($params['controller'])) {
       if($params['controller'] == '') {
           $smarty->trigger_error("glink: el parámetro 'controller' debe contener un valor.");
           return;
       }
       else
          $controller=$params['controller'];
    }
    else
       $controller = $smarty->_tpl_vars["Form"]->controller;

    if (isset($params['action'])) {
       if($params['action'] == '') {
           $smarty->trigger_error("glink: el parámetro 'action' debe contener un valor.");
           return;
       }
       else
          $action = $params['action'];
    }
    else
       $action = $smarty->_tpl_vars["Form"]->action;
       
    if (empty($action))
       $action = "index";
       
    if (isset($params['confirm'])) $confirm = $params['confirm'];
    
    if (isset($params['target'])) $target = $params['target'];
    
    $APP_HTTP = $smarty->_tpl_vars["APP_HTTP"];

    if ($img!="") {
	   
	   $caption = "<img src=\"".$APP_HTTP."/app/img/$img"."\">$caption";
    }
    
    $comando = $APP_HTTP."/$controller/$action";
    
    //echo $comando."<hr/>";
    if (!empty($confirm))
       $s = "<a href=\"javascript:if (confirm('$confirm')) location.href='$APP_HTTP/$controller/$action$content';\"";
    else
       $s = "<a href=\"".$APP_HTTP."/$controller/$action$content\"";
       
    if ($target!="")
       $s .= " target=\"$target\"";
    
    return $s.">$caption</a>";;

}

/* vim: set expandtab: */

?>
