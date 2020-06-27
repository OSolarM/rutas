<div id="stylized" class="myform" style="width:650px;">
{$Form->create("Camion")}
<h1>Ordenes de Compra</h1>
<p>Datos de la &oacute;rden de compra</p>


<table>
   <tr><td align="right">{lbl}Instituci&oacute;n{/lbl} </td><td>{select name="institucion_id" readonly="true" class="sololectura" size="40"}{$instituciones}{/select}</td></tr>
   <tr><td align="right">{lbl}Orden de Compra{/lbl}    </td><td>{input name="orco_orden_compra" size="20"}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}              </td><td>{input name="orco_fecha"        }</td></tr>
   <tr><td align="right">{lbl}Autom&oacute;vil{/lbl}   </td><td>{select name="orco_auto"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right">{lbl}Escuela{/lbl}            </td><td><table><tr><td>{select name="orco_escuela"}|,S&iacute;|S,No|N{/select}</td><td>{lbl}(Solo si es Carabineros){/lbl}</td></tr></table></td></tr>
   <tr><td align="right">{lbl}Texto Factura Escuela{/lbl}      </td><td>{area  name="orco_texto_factura" rows="5"}</td></tr>
   <tr><td align="right">{lbl}Neto{/lbl}</td>          <td>{input name="orco_neto"        size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Iva {/lbl}</td>          <td>{input name="orco_iva"        size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Total{/lbl}</td>         <td>{input name="orco_total"        size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Observaciones{/lbl}      </td><td>{area  name="orco_observaciones"}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}            </td><td>{select name="orco_bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>     
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{hidden name="orco_estado"}
{hidden name="orna_orden_compra"}
{hidden name="order"}
{hidden name="idOrigen"}
{glink caption="Volver" controller="ordenes_nacionales" action="imprimirFacturas"}{/glink}

<div class="spacer"></div>
</form>
</div>