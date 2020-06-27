<?php /* Smarty version 2.6.31, created on 2020-06-27 17:45:09
         compiled from peonetas/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'lbl', 'peonetas/form.tpl', 14, false),array('block', 'select', 'peonetas/form.tpl', 24, false),array('block', 'glink', 'peonetas/form.tpl', 29, false),array('function', 'input', 'peonetas/form.tpl', 14, false),array('function', 'hidden', 'peonetas/form.tpl', 27, false),)), $this); ?>
<div class="container">
   <div class="row">
      <div class="col-lg-2">
	  </div>
	  <div class="col-lg-7">
	     <div class="card">
            <div class="card-header">Peonetas - Datos básicos de los peonetas</div>
            <div class="card-body">
               <?php echo $this->_tpl_vars['Form']->create('Peoneta'); ?>

               
               <form id="form" name="form" method="post" action="index.html">
               
               <table>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_rut<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>      </td><td><?php echo smarty_function_input(array('name' => 'pnta_rut','size' => '12'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_apellidos<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td><td><?php echo smarty_function_input(array('name' => 'pnta_apellidos','size' => '25'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_nombres<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php echo smarty_function_input(array('name' => 'pnta_nombres','size' => '25'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_direccion<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td><td><?php echo smarty_function_input(array('name' => 'pnta_direccion','size' => '60'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_comuna<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'pnta_comuna','size' => '25'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_ciudad<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'pnta_ciudad','size' => '25'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_region<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>   </td><td><?php echo smarty_function_input(array('name' => 'pnta_region','size' => '2'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_telefono<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td><td><?php echo smarty_function_input(array('name' => 'pnta_telefono','size' => '12'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_celular<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php echo smarty_function_input(array('name' => 'pnta_celular','size' => '12'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_email<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>    </td><td><?php echo smarty_function_input(array('name' => 'pnta_email','size' => '25'), $this);?>
</td></tr>
                  <tr><td align="right"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>pnta_bloqueo<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td><td><?php $this->_tag_stack[] = array('select', array('name' => 'pnta_bloqueo')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>|,Sí|S,No|N<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td></tr>
                  <tr><td colspan="2" align="right"><button type="submit" class="btn btn-primary">Grabar</button></td></tr>
               </table>
               <?php echo smarty_function_hidden(array('name' => 'id'), $this);?>

               <br>
               <?php $this->_tag_stack[] = array('glink', array('caption' => 'Volver','action' => 'index')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
               <div class="spacer"></div>
               
               
               </form>
            </div>			
		 </div>	
	  </div>
   </div>
</div>