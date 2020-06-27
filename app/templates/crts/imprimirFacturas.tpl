{$Form->create("OrdenNacional")}

<div id="stylized" class="myform" style="width:1200px;">
<h1>Impresi&oacute;n de Facturas Internacionales</h1>
<p>Proceso de generaci&oacute;n de facturas</p>

<table>
<tr><td>{lbl}Pr&oacute;xima factura a usar{/lbl}</td><td>{input name="no_factura" size="11" style="text-align:right;" readonly="true" class="sololectura"}</td>
</tr>
</table>

<table style="background: lightgray;">



<tr>
    <td bgcolor=#aabbcc align="center">{lbl}Cliente{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Destinatario{/lbl}</td>
    <!--<td bgcolor=#aabbcc align="center">{lbl}No.Factura{/lbl}</td>-->
    <td bgcolor=#aabbcc align="center">{lbl}N&uacute;mero{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Valor{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Moneda{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}&nbsp;{/lbl}</td>

</tr>

{foreach from=$facturas item=rec}
<tr>
    <td bgcolor=white>{$rec.razon}</td>
    <td bgcolor=white>{$rec.razon_a}</td>
    <td bgcolor=white>{$rec.crts_numero}</td>
    <td bgcolor=white align="right">{$rec.crts_valor_flete}</td>

    <td bgcolor=white>{$rec.crts_mon_flete}</td>
    <td bgcolor=white align="center">{if $rec.facturar_ok eq "S"}
                         {glink caption="Imprimir" confirm="Seguro de imprimir?" action="prnFact"}/{$rec.id}/{$rec.institucion_id}/{$rec.orna_orden_compra}{/glink} 
                      {/if}
                      </td>
</tr>
{/foreach}

</table>

{*glink caption="Volver" action="index"}{/glink*}
   
{hidden name="id"}
{hidden name="cmdLin"}
{hidden name="cmdId"}
{hidden name="expe_cerrado"}
{hidden name="expe_fondos"}


<div class="spacer"></div>

</form>
</div>
