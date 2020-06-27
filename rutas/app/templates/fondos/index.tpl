{$Form->create("Fondo")}
<h1>Asignaci&oacute;n Fondos Expediciones</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{*glink img="add.png" caption="Nuevo" action="add"}{/glink*}
{select name="criterio"}Sin asignar|S,Todos|T{/select}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>{t}Fecha{/t}</strong></td>
    <td align=center><strong>{t}Expedici&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Destino{/t}</strong></td>
    <td align=center><strong>{t}Chofer{/t}</strong></td>
    <td align=center><strong>{t}Monto{/t}</strong></td>   
    <td align=center><strong>{t}Combustible{/t}</strong></td> 
    <td align=center> </td>
</tr>

{foreach from=$expediciones item=rec}
<tr>
    <td bgcolor=white align="center">{$rec.fond_fecha}</td>
    <td bgcolor=white align="right">{$rec.expe_nro}</td>
    <td bgcolor=white align="left">{$rec.expe_destino}</td>
    <td bgcolor=white>{$rec.chof_nombres}</td>
    <td bgcolor=white align="right">${$rec.fond_monto|number_format:0:",":"."}</td>
    <td bgcolor=white align="center">{$rec.combustible}</td>
    <td bgcolor=white> {glink caption="Asignar fondos" action="edit"}/{$rec.id}{/glink}
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
{literal}
<script language="javascript">
   document.getElementById("criterio").onchange=function() {
      document.frm.submit();
   }
</script>
{/literal}
</form>
