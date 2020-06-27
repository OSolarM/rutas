{$Form->create("Autorizado")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Lista de Autorizados</h1>
<p>Autorizados por Carabineros</p>
<table>
   <tr><td align="right">{lbl}A&ntilde;o{/lbl}     </td><td>{input name="auto_agno"      size="4"}</td></tr>
   <tr><td align="right">{lbl}Mts3{/lbl}     </td><td>{input name="auto_mts3"      size="4"}</td></tr>
   <tr><td align="right">{lbl}Grado{/lbl}    </td><td>{input name="auto_grado"     size="20"}</td></tr>
   <tr><td align="right">{lbl}Apellidos{/lbl}</td><td>{input name="auto_apellidos" size="25"}</td></tr>
   <tr><td align="right">{lbl}Nombres{/lbl}  </td><td>{input name="auto_nombres"   size="25"}</td></tr>
   <tr><td align="right">{lbl}Rut{/lbl}      </td><td>{input name="auto_rut"       size="12"}</td></tr>
   <tr><td align="right">{lbl}Origen{/lbl}   </td><td>{select name="auto_origen"}{$origenes}{/select}</td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}  </td><td>{select name="auto_destino"}{$destinos}{/select}</td></tr>
   <tr><td align="right">{lbl}Autom&oacute;vil{/lbl}  </td><td>{select name="auto_auto"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="auto_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
