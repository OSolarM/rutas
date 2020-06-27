<div id="stylized" class="myform" style="width:350px;">
{$Form->create("Rendicion")}
<h1>Reporte de Carga de Combustibles</h1>
<p>Parámetros del Reporte</p>

<table>
   <tr><td align="right">{lbl}Fecha Inicial{/lbl}    </td><td>{input name="fecini" size="10"}</td></tr>
   <tr><td align="right">{lbl}Fecha Final{/lbl}      </td><td>{input name="fecfin" size="10"}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Aceptar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>