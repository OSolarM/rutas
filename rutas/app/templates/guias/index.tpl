<h1>Ingreso de Guias</h1>

{glink caption="Agregar" action="add"}{/glink}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1>
<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1>
<tr bgcolor=#aabbcc>
    <td align=center><strong>id</strong></td>
    <td align=center><strong>Referencia</strong></td>
    <td align=center><strong>Ingresado por</strong></td>
    <td align=center><strong>Observaciones</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$guia item=rec}
<tr>
    <td bgcolor=white>{$rec.id}</td>
    <td bgcolor=white>{$rec.referencia}</td>
    <td bgcolor=white>{$rec.ingresado_por}</td>
    <td bgcolor=white>{$rec.observa}</td>
    <td bgcolor=white> {glink caption="Editar"   action="edit"}/{$rec.id}{/glink}
         {*{glink caption="Eliminar" confirm="¿Seguro elimina registro?" action="delete"}/{$rec.id}{/glink}*}
         
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