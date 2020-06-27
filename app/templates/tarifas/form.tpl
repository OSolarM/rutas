{$Form->create("Tarifa")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Tarifas por Tramos</h1>
<p>Valor a pagar por vuelta según tramo</p>

<table>
   <tr><td align="right">{lbl}Tramo{/lbl}  </td><td>{input name="tari_descripcion"  size="60"}</td></tr>
   <tr><td align="right">{lbl}Valor{/lbl}  </td><td>{input name="tari_valor"        size="11"}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}</td><td>{select name="tari_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
