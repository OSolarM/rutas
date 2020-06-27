<?php /* Smarty version 2.6.31, created on 2020-06-27 17:19:45
         compiled from ordenes_ejercitos/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'select', 'ordenes_ejercitos/index.tpl', 9, false),array('block', 'glink', 'ordenes_ejercitos/index.tpl', 11, false),array('block', 't', 'ordenes_ejercitos/index.tpl', 16, false),array('function', 'input', 'ordenes_ejercitos/index.tpl', 33, false),array('function', 'submit', 'ordenes_ejercitos/index.tpl', 38, false),)), $this); ?>
<h1>Ordenes de Transporte Nacionales Ej&eacute;rcito</h1>

<?php if ($this->_tpl_vars['MsgFlash'] != ""): ?>
   <h4><?php echo $this->_tpl_vars['MsgFlash']; ?>
</h4>
<?php endif; ?>

<?php echo $this->_tpl_vars['Form']->create('OrdenNacional'); ?>


<?php $this->_tag_stack[] = array('select', array('name' => 'despliegue')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Todos|T,Pendientes|P<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $this->_tag_stack[] = array('glink', array('img' => "add.png",'caption' => 'Nuevo','action' => 'add')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor="#ebf4fb">
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_numero<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_fecha<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_m3<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_grado<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Apellidos<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Nombres<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_rut<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Estado<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>
    <td align=center> </td>
</tr>

<tr style="background:white;">
    <td align=center><strong>
</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong><?php echo smarty_function_input(array('name' => 'orna_apellidos','size' => '25'), $this);?>
</strong></td>
    <td align=center><strong><?php echo smarty_function_input(array('name' => 'orna_nombres','size' => '25'), $this);?>
</strong></td>
    <td bgcolor=white>&nbsp;</td>
    <td align=center><strong><?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Estado<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></strong></td>

    <td align=center><?php echo smarty_function_submit(array('value' => 'Buscar','id' => 'btnBuscar'), $this);?>
</td>
</tr>


<?php $_from = $this->_tpl_vars['ordenesnacionales']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rec']):
?>
<tr>
    <td bgcolor=white align="right"><?php echo $this->_tpl_vars['rec']['id']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['orna_fecha']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['orna_m3']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['grad_descripcion']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['orna_apellidos']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['orna_nombres']; ?>
</td>
    <td bgcolor=white><?php echo $this->_tpl_vars['rec']['orna_rut']; ?>
</td>
    <td bgcolor=white>
       <?php if ($this->_tpl_vars['rec']['orna_nula'] == 'S'): ?>Nula
       <?php else: ?>
         <?php if ($this->_tpl_vars['rec']['orna_cerrar'] == 'S'): ?>
          Cerrada
         <?php else: ?>
          Pendiente
         <?php endif; ?>
       <?php endif; ?>
       
    </td>    
    <td bgcolor=white><?php $this->_tag_stack[] = array('glink', array('img' => "edit.gif",'caption' => 'Modifica','action' => 'edit')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>/<?php echo $this->_tpl_vars['rec']['id']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                       
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</td></tr>
<tr><td><?php if (! empty ( $this->_tpl_vars['pagination'] )): ?>
            <div class="pagination"><?php echo $this->_tpl_vars['pagination']; ?>
</div>
        <?php endif; ?>
   </td>
</tr>
</table>
<?php echo '
<script language="javascript">
   document.getElementById("despliegue").onchange = function() {
      document.frm.submit();
   }
</script>
'; ?>

</form>