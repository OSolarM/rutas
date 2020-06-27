<?php /* Smarty version 2.6.31, created on 2020-06-27 17:35:36
         compiled from choferes/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'lbl', 'choferes/form.tpl', 15, false),array('block', 'select', 'choferes/form.tpl', 25, false),array('block', 'glink', 'choferes/form.tpl', 30, false),array('function', 'input', 'choferes/form.tpl', 15, false),array('function', 'hidden', 'choferes/form.tpl', 28, false),)), $this); ?>
<?php echo $this->_tpl_vars['Form']->create('Chofer'); ?>


<div class="container">
<div class="row">
   <div class="col-lg-2">
   </div>
   <div class="col-lg-7">
<div class="card">
  <div class="card-header">Datos básicos de los choferes</div>
  <div class="card-body">

<form id="form" name="form" method="post" action="index.html">  
<table>

<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_rut<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>      </td><td><?php echo smarty_function_input(array('name' => 'chof_rut','size' => '12'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_apellidos<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td><td><?php echo smarty_function_input(array('name' => 'chof_apellidos','size' => '25'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_nombres<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php echo smarty_function_input(array('name' => 'chof_nombres','size' => '25'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_direccion<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td><td><?php echo smarty_function_input(array('name' => 'chof_direccion','size' => '60'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_comuna<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'chof_comuna','size' => '25'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_ciudad<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'chof_ciudad','size' => '25'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_region<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'chof_region','size' => '2'), $this);?>
 </td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_telefono<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td><td><?php echo smarty_function_input(array('name' => 'chof_telefono','size' => '12'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_celular<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php echo smarty_function_input(array('name' => 'chof_celular','size' => '12'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_email<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>    </td><td><?php echo smarty_function_input(array('name' => 'chof_email','size' => '25'), $this);?>
</td></tr>
<tr><td><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>chof_bloqueo<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php $this->_tag_stack[] = array('select', array('name' => 'chof_bloqueo')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>|,Sí|S,No|N<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td></tr>
<tr><td align="right" colspan="2"><button type="submit" class="btn btn-primary">Grabar</button></td></tr>
</table>
<?php echo smarty_function_hidden(array('name' => 'id'), $this);?>

<br/>
<?php $this->_tag_stack[] = array('glink', array('caption' => 'Volver','action' => 'index')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<div class="spacer"></div>
</form>


   </div>
</div>
  </div>
</div>  

</div>