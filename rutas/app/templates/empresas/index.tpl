<h1>Mantención de Empresas</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{glink caption="Agregar" action="add"}{/glink}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>Id</strong></td>
    <td align=center><strong>Rut</strong></td>
    <td align=center><strong>Razón Social</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$empresa item=rec}
<tr>
    <td bgcolor=white>{$rec.id}</td>
    <td bgcolor=white>{$rec.empr_run}-{$rec.empr_dv}</td>
    <td bgcolor=white>{$rec.empr_razon}</td>
    <td bgcolor=white> {glink caption="Editar"   action="edit"}/{$rec.id}{/glink}
         {glink caption="Eliminar" confirm="¿Seguro elimina registro?" action="delete"}/{$rec.id}{/glink}
         
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