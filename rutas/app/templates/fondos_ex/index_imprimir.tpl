<h1>Impresi&oacute;n de Expediciones Internacionales</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}


<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>{t}N&uacute;mero{/t}</strong></td>
    <td align=center><strong>{t}Fecha{/t}</strong></td>
    <td align=center><strong>{t}Glosa{/t}</strong></td>
    <td align=center><strong>{t}Monto{/t}</strong></td>    
    <td align=center><strong>{t}Chofer{/t}</strong></td>
    <td align=center><strong>{t}Patente{/t}</strong></td>
    <td align=center><strong>{t}Acoplado{/t}</strong></td>   
    <td align=center><strong>{t}Bloqueo{/t}</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$expediciones item=rec}
<tr>
    <td bgcolor=white align="right">{$rec.id}</td>
    <td bgcolor=white align="center">{$rec.fond_fecha}</td>
    <td bgcolor=white align="center">{$rec.fond_glosa}</td>
    <td bgcolor=white align="center">{$rec.fond_monto}</td>
    <td bgcolor=white>{$rec.chof_nombres}</td>
    <td bgcolor=white>{$rec.cami_patente}</td>
    <td bgcolor=white>{$rec.acop_patente}</td>
    <td bgcolor=white align="center">{if $rec.fond_bloqueo eq "S"}S&iacute;{else}No{/if}</td>
    <td bgcolor=white> 
         {glink img="delete.gif" caption="Imprime" action="runPdf" target="_blank"}/{$rec.id}{/glink}

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
