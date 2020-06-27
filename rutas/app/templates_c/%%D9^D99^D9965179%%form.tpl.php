<?php /* Smarty version 2.6.31, created on 2020-06-27 17:20:37
         compiled from ordenes_carabineros/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'lbl', 'ordenes_carabineros/form.tpl', 8, false),array('block', 'select', 'ordenes_carabineros/form.tpl', 19, false),array('block', 'glink', 'ordenes_carabineros/form.tpl', 145, false),array('function', 'input', 'ordenes_carabineros/form.tpl', 17, false),array('function', 'hidden', 'ordenes_carabineros/form.tpl', 25, false),array('function', 'area', 'ordenes_carabineros/form.tpl', 138, false),)), $this); ?>
﻿<?php echo $this->_tpl_vars['Form']->create('OrdenNacional'); ?>

<div id="stylized" class="myform" style="width:690px;">
<h1>Carabineros de Chile</h1>
<p>Ordenes de Transporte Nacionales</p>

<table>
<tr>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_numero<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_fecha<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <!--<td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>institucion_id<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>-->
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Orden de Compra<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <!--<td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Lista Autorizaciones<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>-->
    <!--<td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Valor Gu&iacute;a<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>No Gu&iacute;a<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>-->
</tr>
<tr>
    <td><?php echo smarty_function_input(array('name' => 'id','size' => '11','readonly' => 'true','style' => "text-align:right",'class' => 'sololectura'), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_fecha','size' => '10'), $this);?>
</td>
    <!--<td><?php $this->_tag_stack[] = array('select', array('name' => 'institucion_id')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['instituciones']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>-->
    <td><?php echo smarty_function_input(array('name' => 'orna_orden_compra','size' => '20'), $this);?>
</td>
    <!--<td><?php $this->_tag_stack[] = array('select', array('name' => 'lista_carabineros')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['lista_carabineros']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>-->
    <!--<td><?php echo smarty_function_input(array('name' => 'orna_valor_guia','size' => '10','style' => "text-align:right"), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_no_guia','size' => '10','style' => "text-align:right"), $this);?>
</td>-->

    <?php echo smarty_function_hidden(array('name' => 'orna_no_guia'), $this);?>


</tr>
</table>

<table>
<tr><td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_m3<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_grado<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Apellidos<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Nombres<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_rut<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
</tr>
<tr><td><?php echo smarty_function_input(array('name' => 'orna_m3','size' => '5','style' => "text-align:right"), $this);?>
</td>
    <td><?php $this->_tag_stack[] = array('select', array('name' => 'orna_grado')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['grados']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td><?php echo smarty_function_input(array('name' => 'orna_apellidos','size' => '25'), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_nombres','size' => '25'), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_rut','size' => '12'), $this);?>
</td>
</tr>
</table>

<table>
<tr><td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Correo Electr&oacute;nico<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>T&eacute;lefono fijo<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Celular<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <!--<td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Dep&oacute;sito<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Monto $<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>-->
</tr>
<tr><td><?php echo smarty_function_input(array('name' => 'orna_email','size' => '40'), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_fono','size' => '15'), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_celular','size' => '15'), $this);?>
</td>
    <!--<td><?php echo smarty_function_input(array('name' => 'orna_deposito','size' => '15','style' => "text-align:right"), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_monto_dep','size' => '11','style' => "text-align:right"), $this);?>
</td>-->
<?php echo smarty_function_hidden(array('name' => 'orna_deposito'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_monto_dep'), $this);?>

</tr>
</table>


<table>
<tr><td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Neto<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Iva<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
    <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Total<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
</tr>
<tr><td><?php echo smarty_function_input(array('name' => 'orna_valor_guia','size' => '12','style' => "text-align:right"), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_iva','size' => '12','style' => "text-align:right"), $this);?>
</td>
    <td><?php echo smarty_function_input(array('name' => 'orna_total','size' => '12','style' => "text-align:right"), $this);?>
</td>
</tr>
</table>

<table>
<tr>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_tipo_em<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_origen<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_destino<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
</tr>
<tr>
   <td><?php $this->_tag_stack[] = array('select', array('name' => 'orna_tipo_em','size' => '1')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>|,Menaje|M,Efectos Personales|E,Solo Automovil|A<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td><?php $this->_tag_stack[] = array('select', array('name' => 'orna_origen')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['origenes']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td><?php $this->_tag_stack[] = array('select', array('name' => 'orna_destino')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['destinos']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
</tr>
</table>

<table>
<tr>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_auto<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Patente<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Marca<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Modelo<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
</tr>
<tr>
   <td><?php $this->_tag_stack[] = array('select', array('name' => 'orna_auto','size' => '1')); $_block_repeat=true;smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>|,S&iacute;|S,No|N<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
   <td><?php echo smarty_function_input(array('name' => 'orna_patente','size' => '15'), $this);?>
</td>
   <td><?php echo smarty_function_input(array('name' => 'orna_marca','size' => '20'), $this);?>
</td>
   <td><?php echo smarty_function_input(array('name' => 'orna_modelo','size' => '20'), $this);?>
</td>
</tr>
</table>


<table>
   <tr>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Fecha Retiro<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>     </td>
   <td align="center">&nbsp;</td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Direcci&oacute;n Retiro<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_repo_comuna<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>    </td>
   </tr>
   <tr>
   <td><?php echo smarty_function_input(array('name' => 'orna_repo_fecha','size' => '10','class' => 'sololectura'), $this);?>
</td>
   <td><input type="button" id="retiros" value=".."/></td>
   <td><?php echo smarty_function_input(array('name' => 'orna_repo_direccion','size' => '60'), $this);?>
</td>
   <td><?php echo smarty_function_input(array('name' => 'orna_repo_comuna','size' => '25','maxlength' => '25'), $this);?>
</td>
   </tr>
</table>

<table>
   <tr>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Fecha Llegada<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
   <td align="center">&nbsp;</td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Direcci&oacute;n Entrega<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> </td>
   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_repo_comuna<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>    </td>

   </tr>
   <tr>
   <td><?php echo smarty_function_input(array('name' => 'orna_fecha_llegada','size' => '10','class' => 'sololectura'), $this);?>
</td>
   <td><input type="button" id="llegadas" value=".."/></td>
   <td><?php echo smarty_function_input(array('name' => 'orna_direc_despacho','size' => '60'), $this);?>
</td>
   <td><?php echo smarty_function_input(array('name' => 'orna_comuna_despacho','size' => '25'), $this);?>
</td>
   </tr>
</table>

<table>
   <tr>   <td align="center"><?php $this->_tag_stack[] = array('lbl', array()); $_block_repeat=true;smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>orna_repo_observa<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_lbl($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>  </td>
   </tr>
   <tr>
   <td><?php echo smarty_function_area(array('name' => 'orna_repo_observa','cols' => '80','rows' => '8'), $this);?>
</td>
   </tr>
</table>



<table width="100%">
<tr><td><?php $this->_tag_stack[] = array('glink', array('caption' => 'Volver','action' => 'index')); $_block_repeat=true;smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_glink($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></td>
    <td align="right"><table><tr>
                             <td><button type="submit">Grabar</button></td>
                             
                             <?php if ($this->_tpl_vars['id'] != ""): ?>
                             <!--<td><button type="button" id="btnCerrar">Cerrar e Imprim</button></td>-->
                             <td><button type="button" id="btnAnular">Anular</button></td>
                             <td><button type="button" id="btnADup">Anular y Duplicar</button></td>
                             <?php else: ?>
                                <?php echo smarty_function_hidden(array('name' => 'btnCerrar'), $this);?>

                                <?php echo smarty_function_hidden(array('name' => 'btnAnular'), $this);?>

                                <?php echo smarty_function_hidden(array('name' => 'btnADup'), $this);?>

                             <?php endif; ?>
                             
                             </tr></table></td>
                             </tr>
                      </table>
    </td>
</table>
<?php echo smarty_function_hidden(array('name' => 'orna_estado','size' => '1'), $this);?>



<?php echo smarty_function_hidden(array('name' => 'id'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'institucion_id'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_cerrar'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_nula'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_email1'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_email2'), $this);?>

<?php echo smarty_function_hidden(array('name' => 'orna_email3'), $this);?>




<div class="spacer"></div>
<?php echo '
<script language="javascript">
  function venRetiros() {
      win = window.open("http://www.ruta-chile.com/rutas/calendarios/retiros", "Calendario de Retiros", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("retiros").onclick = function() {
      venRetiros();
   }

  function venLlegadas() {
      win = window.open("http://www.ruta-chile.com/rutas/calendarios/llegadas", "Calendario de Llegadas", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("llegadas").onclick = function() {
      venLlegadas();
   }
   
   //document.getElementById("btnCerrar").onclick= function() {
   //   document.frm.orna_cerrar.value="S";
   //   document.frm.submit();
   //}
   
   var id = '; ?>
<?php if ($this->_tpl_vars['id'] != ""): ?><?php echo $this->_tpl_vars['id']; ?>
<?php else: ?>0<?php endif; ?><?php echo ';
   document.getElementById("btnAnular").onclick= function() {
      if (confirm("Seguro de anular guia?")) 
         location.href="http://www.ruta-chile.com/rutas/ordenes_carabineros/anular/"+id;
   
   }
   document.getElementById("btnADup").onclick= function() {
      if (confirm("Seguro de anular y duplicar guia?")) 
         location.href="http://www.ruta-chile.com/rutas/ordenes_carabineros/anular_dup/"+id;
   
   }
   
   /*
   document.getElementById("lista_carabineros").onchange = function() {
      var e = this.value.split("ç");
      document.getElementById("orna_m3").value        =e[0];
      document.getElementById("orna_grado").value     =e[1];
      document.getElementById("orna_apellidos").value =e[2];
      document.getElementById("orna_nombres").value   =e[3];
      document.getElementById("orna_rut").value       =e[4];
      document.getElementById("orna_auto").value      =e[5];
      document.getElementById("orna_origen").value    =e[6];
      document.getElementById("orna_destino").value   =e[7];

   }
   */
</script>
'; ?>

</form>
</div>