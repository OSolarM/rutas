<div id="stylized" class="myform" style="width:500px;">
{$Form->create("Fondo")}
<h1>Asignaci&oacute;n Fondos Expediciones</h1>
<p>Datos b&aacute;sicos de los expediciones</p>
<table>
   
   <tr><td align="right">{lbl}N&uacute;mero{/lbl}    </td><td>{input name="id" size="10" readonly="true" class="sololectura" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}    </td><td>{input name="fond_fecha" size="10"}</td></tr>
   <tr><td align="right">{lbl}Glosa{/lbl}    </td><td>{input name="fond_glosa" size="60"}</td></tr>
   <tr><td align="right">{lbl}Monto{/lbl}    </td><td>{input name="fond_monto" size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Monto Adicional{/lbl}    </td><td>{input name="fond_monto_adicional" size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Expedici&oacute;n{/lbl}    </td><td>{input name="expe_nro" size="10" readonly="true" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}    </td><td>{input name="expe_destino" size="35" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}Chofer{/lbl}  </td><td> {select name="expe_id" readonly="true" size="35"}{$choferes}{/select}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="fond_bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td>{glink caption="Volver" action="index"}{/glink}</td>
   <td align="right"><button type="submit">Grabar</button></td></tr>
</table>

<div class="spacer"></div>

{literal}
<script language="javascript">
   document.getElementById("fond_monto").select();
   document.getElementById("fond_monto").focus();
</script>
{/literal}
</form>
</div>
