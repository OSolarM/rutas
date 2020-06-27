<div id="stylized" class="myform" style="width:550px;">
{$Form->create("Camion")}
<h1>Camiones</h1>
<p>Datos b&aacute;sicos de los camiones</p>

<table>
   <tr><td align="right">{lbl}cami_patente{/lbl}    </td><td>{input name="cami_patente"      size="10"}</td></tr>
   <tr><td align="right">{lbl}cami_marca{/lbl}      </td><td>{input name="cami_marca"        size="20"}</td></tr>
   <tr><td align="right">{lbl}A&ntilde;o{/lbl}     </td><td>{input name="cami_agno"         size="11"}</td></tr>
   <tr><td align="right">{lbl}cami_descripcion{/lbl}</td><td>{input name="cami_descripcion"  size="25"}</td></tr>
   <tr><td align="right">{lbl}Vcto.Seguro obligatorio{/lbl}  </td><td>{input name="cami_patente_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}Vcto.Revisi&oacute;n T&eacute;cnica{/lbl}  </td><td>{input name="cami_permiso_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}Vcto.Permiso de circulaci&oacute;n{/lbl}  </td><td>{input name="cami_seguros_vcto" size="10"}</td></tr>
   <tr><td align="right">{lbl}cami_bloqueo{/lbl}    </td><td>{select name="cami_bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>