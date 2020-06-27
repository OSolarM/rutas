<h1>Camiones: Ingreso Fechas Vencimientos</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create("Camion")}


<table style="background:lightgray;" cellpadding="3px">
<tr>
    <td bgcolor="#aabbcc" align=center><strong>{t}Patente{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center><strong>{t}Seg.oblig.{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center><strong>{t}Rev.T&eacute;cnica{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center><strong>{t}Permiso Circ.{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center><strong>{t}Seg.Internacional{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center><strong>{t}Perm.Internacional{/t}</strong></td>
    <td bgcolor="#aabbcc" align=center>&nbsp;</td>
</tr>


{foreach from=$camiones item=rec name=foo}
<tr>
    
    <td bgcolor=white align="left">{$rec.cami_patente}</td>
    <td bgcolor=white align="center">{$rec.cami_patente_vcto}</td>
    <td bgcolor=white align="center">{$rec.cami_permiso_vcto}</td>
    <td bgcolor=white align="center">{$rec.cami_seguros_vcto}</td>
    <td bgcolor=white align="center">{$rec.cami_seg_int_vcto}</td>
    <td bgcolor=white align="center">{$rec.cami_perm_int_vcto}</td>
    <td bgcolor="white" align=center>&nbsp;</td>
</tr>
{/foreach}

</table>
{hidden name="seleccionados"}

{literal}
<script language="javascript">
</script>
{/literal}
</form>
