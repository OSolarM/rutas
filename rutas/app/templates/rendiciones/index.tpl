<h1>Rendici&oacute;n Fondos Expediciones Nacionales</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create("Rendicion")}
{*glink img="add.png" caption="Nuevo" action="add"}{/glink*}
{select name="opcion"}Ingresados|I,Todos|T{/select}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="100%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>{t}N&uacute;mero{/t}</strong></td>
    <td align=center><strong>{t}Fecha{/t}</strong></td>
    <!--<td align=center><strong>{t}Tipo{/t}</strong></td>-->
    <td align=center><strong>{t}Expedici&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Fecha{/t}</strong></td>
    <td align=center><strong>{t}Chofer{/t}</strong></td>
    <td align=center><strong>{t}Asignado{/t}</strong></td> 
    <td align=center><strong>{t}Combustible cargado{/t}</strong></td> 
    <td align=center><strong>{t}Estado{/t}</strong></td> 
    <td align=center><strong>{t}Bloqueo{/t}</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$rendiciones item=rec}
<tr>
    <td bgcolor=white align="right">{$rec.rend_nro}</td>
    <td bgcolor=white align="center">{$rec.rend_fecha}</td>
    <!--<td bgcolor=white align="center">{if $rec.expe_tipo eq "N"}Nacional{else}Internacional{/if}</td>-->
    <td bgcolor=white align="right">{$rec.expe_nro}</td>
    <td bgcolor=white align="center">{$rec.expe_fecha}</td>
    <td bgcolor=white align="left">{$rec.chofer}</td>
    <td bgcolor=white align="right">${$rec.asignado|number_format:0:",":"."}</td>
    <td bgcolor=white align="center" style="color:red"><strong>{$rec.combustible_cargado}</strong></td> 
    <td bgcolor=white align="center">{if $rec.rend_estado eq "C"}Cerrado{else}Ingresado{/if}</td>
    <td bgcolor=white align="center">{if $rec.fond_bloqueo eq "S"}S&iacute;{else}No{/if}</td>
    <td bgcolor=white> {glink img="edit.gif" caption="Modifica" action="edit"}/{$rec.id}{/glink}
                       &nbsp;
                       {glink caption="Imprime" action="runPdf" target="_blank"}/{$rec.id}{/glink}
         
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
document.getElementById("opcion").onchange=function() {
   document.frm.submit();
}
</script>
{/literal}
</form>