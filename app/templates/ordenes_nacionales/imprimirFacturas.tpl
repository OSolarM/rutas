{$Form->create("OrdenNacional")}

<div id="stylized" class="myform" style="width:1200px;">
<h1>Impresi&oacute;n de Facturas</h1>
<p>Proceso de generaci&oacute;n de facturas</p>

<table>
<tr><td>{lbl}Pr&oacute;xima factura a usar{/lbl}</td><td>{input name="no_factura" size="11" style="text-align:right;" readonly="true" class="sololectura"}</td>
</tr>
</table>

<table style="background: lightgray;">



<tr>
    <td bgcolor=#aabbcc align="center">{lbl}Instituci&oacute;n{/lbl}</td>
    <!--<td bgcolor=#aabbcc align="center">{lbl}No.Factura{/lbl}</td>-->
    <!--<td bgcolor=#aabbcc align="center">{lbl}Orden de Compra{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Orden de Compra 2{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Orden de Compra auto{/lbl}</td>-->
    <td bgcolor=#aabbcc align="center">{lbl}Grado{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Apellidos{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Nombres{/lbl}</td>
    <!--<td bgcolor=#aabbcc align="center">{lbl}Rut{/lbl}</td>-->
    <td bgcolor=#aabbcc align="center">{lbl}Gu&iacute;a No{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Neto{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Iva{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}Valor{/lbl}</td>
    <td bgcolor=#aabbcc align="center">{lbl}&nbsp;{/lbl}</td>

</tr>

{foreach from=$facturas item=rec}
<tr>
    <!--
    <td bgcolor=white>{if $rec.facturar_ok eq "S"}
                         <input type="checkbox" id="l_{$rec.indice}" name="lista[]" value="{$rec.id},{$rec.orna_orden_compra},{$rec.orna_orden_compra2}" onclick="cuenta(this);"/>
                      {/if}
                      </td>
    -->
    <td bgcolor=white>{if $rec.institucion_id eq 4}{$rec.razon}{else}{$rec.inst_razon_social}{/if}</td>
    <!--<td bgcolor=white>{$rec.orna_no_factura}</td>-->
    <!--<td bgcolor=white>{if $rec.oc_ok eq "S"}
                         {$rec.orna_orden_compra}
                      {else}
                         <a href="{$APP_HTP}/rutas/ordenes_compras/addOrder/{$rec.id}/{$rec.orna_orden_compra}/{$rec.institucion_id}/1" style="color:red">{if $rec.orna_orden_compra ne ""}{$rec.orna_orden_compra}{else}Falta orden{/if}</a>
                      {/if}

                      </td>
    <td bgcolor=white>{if $rec.oc2_ok eq "S"}
                         {$rec.orna_orden_compra2}
                      {else}
                         <a href="{$APP_HTP}/rutas/ordenes_compras/addOrder/{$rec.id}/{$rec.orna_orden_compra2}/{$rec.institucion_id}/2" style="color:red">{if $rec.orna_orden_compra2 ne ""}{$rec.orna_orden_compra2}{else}Falta orden{/if}</a>
                      {/if}
    </td>

    <td bgcolor=white>{if $rec.ocauto_ok eq "S"}
                         {$rec.orna_orden_compra_auto}
                      {else}
                         <a href="{$APP_HTP}/rutas/ordenes_compras/addOrder/{$rec.id}/{$rec.orna_orden_compra_auto}/{$rec.institucion_id}/3" style="color:red">{if $rec.orna_orden_compra_auto ne ""}{$rec.orna_orden_compra_auto}{else}Falta orden{/if}</a>
                      {/if}
    </td>
    -->
    <td bgcolor=white>{$rec.grad_descripcion}</td>
    <td bgcolor=white>{$rec.orna_apellidos}</td>
    <td bgcolor=white>{$rec.orna_nombres}</td>
    <!--<td bgcolor=white>{$rec.orna_rut}</td>-->
    <td bgcolor=white align="right">{$rec.orna_no_guia}</td>
    <td bgcolor=white align="right">${$rec.orna_valor_guia|number_format:0:",":"."}</td>
    <td bgcolor=white align="right">${$rec.orna_iva|number_format:0:",":"."}</td>
    <td bgcolor=white align="right">${$rec.orna_total|number_format:0:",":"."}</td>
    <td bgcolor=white align="center">
                         {glink caption="Imprimir" confirm="Seguro de imprimir?" action="prnFact"}/{$rec.id}/{$rec.institucion_id}/{$rec.orna_orden_compra}{/glink} 
                      
                      </td>
</tr>
{/foreach}
<tr>
<td colspan="5" bgcolor="white" align="right">TOTALES</td>
<td bgcolor="white" align="right">${$sNeto|number_format:0:",":"."}</td>
<td bgcolor="white" align="right">${$sIva|number_format:0:",":"."}</td>
<td bgcolor="white" align="right">${$sTotal|number_format:0:",":"."}</td>
<td bgcolor="white" align="right">&nbsp;</td>
</tr>

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
