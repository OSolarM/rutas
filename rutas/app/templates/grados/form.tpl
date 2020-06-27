{$Form->create("Grado")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Grados</h1>
<p>Datos grados militares</p>
<table>
<tr><td align="right">{lbl}Instituci&oacute;n{/lbl}</td><td>{select name="institucion_id"}{$instituciones}{/select}</td></tr>
<tr><td align="right">{lbl}Grado{/lbl}             </td><td>{input name="grad_descripcion" size="25"}</td></tr>
<tr><td align="right">{lbl}D&iacute;as{/lbl}       </td><td>{input name="grad_dias"        size="1"}</td></tr>
<tr><td align="right">{lbl}Bloqueo{/lbl}           </td><td>{select name="grad_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
<tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
