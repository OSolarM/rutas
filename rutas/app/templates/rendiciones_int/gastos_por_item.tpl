<div id="stylized" class="myform" style="width:350px;">
{$Form->create("Rendicion")}
<h1>Informe de Gastos por Item</h1>
<p>Parámetros del Informe</p>

<table>
   <tr><td align="right">{lbl}Fecha Inicial{/lbl}    </td><td>{input name="fecini" size="10"}</td></tr>
   <tr><td align="right">{lbl}Fecha Final{/lbl}      </td><td>{input name="fecfin" size="10"}</td></tr>
   <tr><td align="right">{lbl}Peso Argentino{/lbl}   </td><td>{input name="argentino" size="10" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Litro Combustible{/lbl}</td><td>{input name="combustible" size="10" style="text-align:right"}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Aceptar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>