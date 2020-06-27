{$Form->create("Paridad")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Paridades de Monedas y Valor del Combustible</h1>
<p>Paridades de Monedas por Fechas y Valor del Combustible</p>

<table>
   <tr><td align="right">{lbl}Moneda{/lbl} </td><td>{select name="mon_id"}{$monedas}{/select}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}  </td><td>{input name="par_fecha"  size="10"}</td></tr>
   <tr><td align="right">{lbl}Paridad{/lbl}</td><td>{input name="par_valor"  size="11"  style="text-align:right"}</td></tr>
      <tr><td align="right">{lbl}Litro Combustible{/lbl}</td><td>{input name="par_valor_litro"  size="11" style="text-align:right"}&nbsp;(En moneda del país)</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}</td><td>{select name="par_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
