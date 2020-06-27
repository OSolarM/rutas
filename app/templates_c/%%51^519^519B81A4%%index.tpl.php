<?php /* Smarty version 2.6.31, created on 2020-06-15 15:34:48
         compiled from accesos/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'lbl', 'accesos/index.tpl', 8, false),array('function', 'input', 'accesos/index.tpl', 8, false),array('function', 'hidden', 'accesos/index.tpl', 12, false),)), $this); ?>
<?php echo $this->_tpl_vars['Form']->create('Acceso'); ?>

<div id="stylized" class="myform" style="width:300px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Control de Acceso</h1>
<p>Datos b&aacute;sicos para conexi&oacute;n</p>

<table aling="center">	
   <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Usuario<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>          </td><td><?php echo smarty_function_input(array('name' => 'user','size' => '12'), $this);?>
</td></tr>
   <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Contrase&ntilde;a<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td><td><?php echo smarty_function_input(array('name' => 'pass','size' => '12','kind' => 'password'), $this);?>
</td></tr>
   <tr><td colspan="2" align="right"><button type="submit">Ingresar</button></td></tr>
</table>
<?php echo smarty_function_hidden(array('name' => 'id'), $this);?>

<br>
<div class="spacer"></div>

<script language="javascript">
   document.getElementById("user").focus();
</script>
</form>
</div>