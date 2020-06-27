<h1>Indicadores Ej&eacute;rcito, Fuerza A&eacute;rea, Carabineros</h1>


{$Form->create("OrdenNacional")}



<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1>
<tr bgcolor="#ebf4fb">
    <td align=center><strong>{t}Instituci&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Ordenes Pendientes{/t}</strong></td>
    <td align=center><strong>{t}Ordenes Cerradas{/t}</strong></td>
    <td align=center><strong>{t}Ordenes Cerradas sin O/C{/t}</strong></td>
    <td align=center><strong>{t}Gu&iacute;as pend. facturaci&oacute;n{/t}</strong></td>
</tr>

{foreach from=$indicadores item=rec}
<tr>
    <td bgcolor="white" align="left">{$rec.institucion}</td>
    <td bgcolor="white" align="right">{$rec.opendientes}</td>
    <td bgcolor="white" align="right">{$rec.ocerradas}</td>
    <td bgcolor="white" align="right">{$rec.osinoc}</td>
    <td bgcolor="white" align="right">{$rec.gpend}</td>
</tr>
{/foreach}

<tr>
    <td bgcolor="white" align="left"><strong>TOTALES</strong></td>
    <td bgcolor="white" align="right">{$sopendientes}</td>
    <td bgcolor="white" align="right">{$socerradas}</td>
    <td bgcolor="white" align="right">{$sosinoc}</td>
    <td bgcolor="white" align="right">{$sgpend}</td>
</tr>
</table>


<br/>

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1>
<tr bgcolor="#ebf4fb">
    <td align=center><strong>{t}Expediciones Abiertas{/t}</strong></td>
    <td align=center><strong>{t}Expediciones Cerradas{/t}</strong></td>
</tr>
<tr>
    <td align="right" bgcolor="white">{$expe_abierta}</td>
    <td align="right" bgcolor="white">{$expe_cerrada}</td>
</tr>
</table>

</form>
