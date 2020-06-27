<?php
        
	require_once(APP_PATH.'/libs/smarty/libs/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = APP_PATH."/app/templates";
	$smarty->compile_dir  = APP_PATH."/app/templates_c";
	$smarty->compile_check = true;
	$smarty->debugging = false;
	$smarty->assign("host", APP_PATH);
?>
