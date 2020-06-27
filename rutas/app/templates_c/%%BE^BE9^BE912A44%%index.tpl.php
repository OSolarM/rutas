<?php /* Smarty version 2.6.31, created on 2020-06-15 15:36:26
         compiled from ordenes_nacionales/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'glink', 'ordenes_nacionales/index.tpl', 8, false),array('function', 'hidden', 'ordenes_nacionales/index.tpl', 16, false),)), $this); ?>
<form id="frm" name="frm" method="post">
<h1>Ordenes Nacionales</h1>

<?php if ($this->_tpl_vars['MsgFlash'] != ""): ?>
   <h4><?php echo $this->_tpl_vars['MsgFlash']; ?>
</h4>
<?php endif; ?>

<?php $this->_tag_stack[] = array('glink', array('img' => "add.png",'caption' => 'Nuevo','action' => 'add')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>


<?php echo $this->_tpl_vars['grilla']; ?>


<?php if (! empty ( $this->_tpl_vars['pagination'] )): ?>
            <div class="pagination"><?php echo $this->_tpl_vars['pagination']; ?>
</div>
        <?php endif; ?>
<?php echo smarty_function_hidden(array('name' => 'sortKey'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orderKey'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'page'), $this);?>

<?php echo '
<script language="javascript">
   function setOrder(cOrder) {
      
      if (document.frm.sortKey.value==cOrder) {

         if (document.frm.orderKey.value=="asc")
            document.frm.orderKey.value="desc";
         else
            document.frm.orderKey.value="asc";
   
      }  
      else
         document.frm.orderKey.value="asc";

      document.frm.sortKey.value=cOrder;
      document.frm.submit();
   }
</script>
'; ?>

</form>