<?php /* Smarty version 2.6.31, created on 2020-06-15 16:28:19
         compiled from main/main.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gestión de Transportes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Gestión de Transportes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
	  <!--
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
	  -->

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Principal
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		
		  <?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mm']):
?>
             <a class="dropdown-item" href="javascript:location.href='/rutas/<?php echo $this->_tpl_vars['mm']['pagina']; ?>
'"><?php echo $this->_tpl_vars['mm']['titulo']; ?>
</a></br>
          <?php endforeach; endif; unset($_from); ?>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<a href="/rutas/accesos/salir">Salir</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </div>
</nav>

<div id="container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tpl_include'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<!--
<div id="completo">
   <div id="header"><h2>TRANSPORTES RUTACHILE S.A.</h2>
   </div>
   <div id="izquierdo" <?php if ($this->_tpl_vars['needLogin'] == 'N'): ?> style="display:none" <?php endif; ?>>
   
   MEN&Uacute; PRINICIPAL<br/><br/>
   <?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mm']):
?>
    <a href="javascript:location.href='/rutas/<?php echo $this->_tpl_vars['mm']['pagina']; ?>
'" style="font-size:120%;"><?php echo $this->_tpl_vars['mm']['titulo']; ?>
</a></br>
   <?php endforeach; endif; unset($_from); ?>
   <a href="/rutas/accesos/salir">Salir</a>
   </div>
   <div id="derecho">
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tpl_include'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   </div>
</div>-->
<?php echo '
<script language="javascript">
$(\'.calendario\').datepick({buttonImageOnly: true, showOn: \'button\',
                           showTrigger: 
    \'<img src="'; ?>
<?php echo $this->_tpl_vars['APP_HTTP']; ?>
<?php echo '/app/images/calendar-blue.gif" alt="Popup" class="trigger" style="padding-top:5px;">\'});
</script>
'; ?>

</body>
</html>