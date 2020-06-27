<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

<title>Pruebas</title>

<link type="text/css" rel="stylesheet" href="{$APP_HTTP}/app/css/style2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css">
<link rel="stylesheet" media="screen" type="text/css" href="{$APP_HTTP}/app/css/datepicker.css" />




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>

<!--<script type="text/javascript" src="{$APP_HTTP}/app/js/jquery.js"></script>-->
<script type="text/javascript" src="{$APP_HTTP}/app/js/eye.js"></script>
<script type="text/javascript" src="{$APP_HTTP}/app/js/utils.js"></script>
<script type="text/javascript" src="{$APP_HTTP}/app/js/layout.js?ver=1.0.2"></script>
<script type="text/javascript" src="{$APP_HTTP}/app/js/datepicker.js"></script>

</head>

<body>
<div id="completo">
   <div id="header">
   </div>
   <div id="izquierdo" style="display:none">
   MEN&Uacute; PRINICIPAL<br/><br/>
   {foreach from=$menu item=mm}
    <a href="javascript:location.href='/rutas/{$mm.pagina}'">{$mm.titulo}</a></br>
   {/foreach}
   <a href="/rutas/accesos/salir">Salir</a>
   </div>
   <div id="derecho">
   {include file=$tpl_include}
   </div>
</div>
</body>
</html>
