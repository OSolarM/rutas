{$Form->create("Acoplado")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Acoplados</h1>
<p>Datos básicos de los acoplados</p>
<table>
   <tr><td align="right">{lbl}acop_patente{/lbl}    </td><td>{input name="acop_patente"     size="10"}</td></tr>
   <tr><td align="right">{lbl}acop_descripcion{/lbl}</td><td>{input name="acop_descripcion" size="25"}</td></tr>
   <tr><td align="right">{lbl}Vencto.Patente{/lbl}  </td><td>{input name="acop_patente_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}Vencto.Permiso{/lbl}  </td><td>{input name="acop_permiso_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}Vencto.Seguros{/lbl}  </td><td>{input name="acop_seguros_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}acop_bloqueo{/lbl}    </td><td>{select name="acop_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>