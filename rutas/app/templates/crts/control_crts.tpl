<h1>Control de Crts</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create("OrdenNacional")}


<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor="#ebf4fb">
    <td align=center><strong>{t}N&uacute;mero{/t}</strong></td>
    <td align=center><strong>{t}Fecha{/t}</strong></td>
    <td align=center><strong>{t}Operaci&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Cliente{/t}</strong></td>
    <td align=center><strong>{t}Factura Crt{/t}</strong></td>
    <td align=center><strong>{t}Fecha Carga{/t}</strong></td>
    <td align=center><strong>{t}Fec/Ent/Aduana{/t}</strong></td>
    <td align=center><strong>{t}Fec/Sal/Aduana{/t}</strong></td>
    <td align=center><strong>{t}Fecha Descarga{/t}</strong></td>
    <td align=center><strong>{t}D&iacute;as extras{/t}</strong></td>
    <td align=center><strong>{t}Valor{/t}</strong></td>
    <td align=center><strong>{t}Factura Días{/t}</strong></td>
    <td align=center> </td>
</tr>


{foreach from=$crts item=rec}
<tr>
    <td bgcolor=white>{$rec.crts_numero}</td>
    <td bgcolor=white>{$rec.fecha}</td>
    <td bgcolor=white align="center">{if $rec.tipo_operacion eq "E"}Exportaci&oacute;n{else}Importaci&oacute;n{/if}</td>
    <td bgcolor=white>{$rec.razon}</td>
    <td bgcolor=white>{$rec.factura_crt}</td>
    <td bgcolor=white>{$rec.fec_carga}</td>
    <td bgcolor=white>{$rec.fec_ent_aduana}</td>
    <td bgcolor=white>{$rec.fec_sal_aduana}</td>
    <td bgcolor=white>{$rec.fec_descarga}</td>
    <td bgcolor=white align="center">{$rec.crts_dias_extras}</td>
    <td bgcolor=white>{$rec.crts_valor_dias_extras|number_format:0:",":"."}</td>
    <td bgcolor=white>{$rec.factura_dias}</td>    
    <td bgcolor=white>{glink img="edit.gif"  caption="Modifica" action="edita_crts"}/{$rec.id}{/glink}
                      {*glink img="delete.gif" caption="Elimina" confirm="?Seguro elimina registro?" action="delete"}/{$rec.id}{/glink}*}
 
    </td>
</tr>
{/foreach}
</table>
</td></tr>
<tr><td>{if !empty($pagination)}
            <div class="pagination">{$pagination}</div>
        {/if}
   </td>
</tr>
</table>
{literal}
<script language="javascript">
   document.getElementById("despliegue").onchange = function() {
      document.frm.submit();
   }
</script>
{/literal}
</form>
