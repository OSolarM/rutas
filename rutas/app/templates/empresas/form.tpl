{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create('Empresa')}

<fieldset class="frm_empresa" style="width:430px">
<legend>Mantención de Empresas</legend>

{input caption="Rut"          name="empr_run"   size="8"}
{input caption="Razón Social" name="empr_razon" size="45"}
{submit value="Grabar" class="miboton"}
</fieldset>            

  {hidden name="id"}
  <br>
  {glink caption="Volver" action="index"}{/glink}
</form>