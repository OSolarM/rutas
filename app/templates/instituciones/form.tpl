{$Form->create("Institucion")}

<div id="stylized" class="myform" style="width:720px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Instituciones</h1>
<p>Datos de la Instituciones</p>
<table>
   <tr><td align="right">{lbl}Rut{/lbl}         </td><td>{input name="inst_rut"          size="12"}</td></tr>
   <tr><td align="right">{lbl}Raz&oacute;n Social{/lbl}</td><td>{input name="inst_razon_social" size="45"}</td></tr>
   <tr><td align="right">{lbl}Correo 1{/lbl}</td><td>{input name="inst_correo1" size="35"}</td></tr>
   <tr><td align="right">{lbl}Correo 2{/lbl}</td><td>{input name="inst_correo2" size="35"}</td></tr>
   <tr><td align="right">{lbl}Mail Cliente{/lbl}            </td><td>{area name="inst_texto_cliente" cols="80"}</td></tr>
   <tr><td align="right">{lbl}Mail Instituci&oacute;n{/lbl} </td><td>{area name="inst_texto_institucion" cols="80"}</td></tr>
   <tr><td align="right">{lbl}Mail Orden Ok{/lbl}           </td><td>{area name="inst_texto_ok" cols="80"}</td></tr>
   <tr><td align="right">{lbl}Mail Orden No Ok{/lbl}        </td><td>{area name="inst_texto_no_ok" cols="80"}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}     </td><td>{select name="inst_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td colspan="2" align="right"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
<br>
{glink caption="Volver" action="index"}{/glink}
<div class="spacer"></div>
</form>
</div>
