<div id="stylized" class="myform" style="width:850px;">
{$Form->create("Crt")}
<h1>Facturaci&oacute;n CRT</h1>
<p>Datos b&aacute;sicos para facturar</p>

<table cellspacing="3px" cellpadding="3px">
   <tr><td align="right">{lbl}Sres{/lbl}           </td><td>{$razon}</td></tr>
   <tr><td align="right">{lbl}Direcci&oacute;n{/lbl}</td><td>{$direccion}</td></tr>
   <tr><td align="right">{lbl}&nbsp;{/lbl}         </td><td>{$comuna}-{$ciudad}</td></tr>
   <tr><td align="right">{lbl}&nbsp;{/lbl}</td><td>{$pais}</td></tr>
   <tr><td align="right">{lbl}Rut{/lbl}  </td><td>{$rut}</td></tr>
   <tr><td align="right">{lbl}No.Factura{/lbl}           </td><td>
     <table>
      <tr>
         <td>{input name="no_factura" size="10"}</td>
         <td>{lbl}Fecha{/lbl}</td>           
         <td>{input name="fec_factura" size="10"}</td>
      </tr>
     </table> 

       </td></tr>
   <tr><td align="right">{lbl}Valor Flete{/lbl}    </td><td><b>{$crts_mon_flete}&nbsp;{input name="crts_valor_flete" style="text-align:right" readonly="false" class="sololectura"}</b></td></tr>
   <tr><td align="right">{lbl}Flete desde{/lbl}    </td><td>{input name="desde" size="40"}</td></tr>
   <tr><td align="right">{lbl}Flete hasta{/lbl}    </td><td>{input name="hasta" size="40"}</td></tr>
   <tr><td align="right">{lbl}Forma de Pago{/lbl}  </td><td>{input name="fpago" size="20"}</td></tr>
   <tr><td align="right">{lbl}Por concepto de{/lbl}</td><td>{area name="concepto" rows="9" cols="80"}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Facturar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="facturas_pendientes"}{/glink}

<div class="spacer"></div>
{literal}
<script language="javascript">
valor = document.getElementById("crts_valor_flete").value;

s = "";
for (i=0; i < valor.length; i++)
   if (valor.charAt(i) >= "0" && valor.charAt(i) <="9")
      s = s + valor.charAt(i);

document.getElementById("crts_valor_flete").value= s;
</script>
{/literal}
</form>
</div>