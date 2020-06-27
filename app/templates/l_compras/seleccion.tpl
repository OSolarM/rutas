{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create('LibroCompras')}

<fieldset class="frm_empresa" style="width:430px">
<legend>Libro de Compras</legend>

{input caption="Empresa" name="empresa"   size="3"}
{input caption="Mes" name="mes" size="2"  style="text-align:right"}
{input caption="Año" name="agno" size="4" style="text-align:right"}
{submit value="Aceptar" class="miboton"}
</fieldset>            

</form>