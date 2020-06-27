<h1>Mantención de Noticias</h1>

{glink caption="Agregar" action="add"}{/glink}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1>
<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1>
<tr bgcolor=#aabbcc>
    <td align=center><strong>Id</strong></td>
    <td align=center><strong>Título</strong></td>
    <td align=center><strong>Resumen</strong></td>
    <td align=center><strong>Publicar</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$noticia item=rec}
<tr>
    <td bgcolor=white>{$rec.id}</td>
    <td bgcolor=white>{$rec.noti_titulo}</td>
    <td bgcolor=white>{$rec.noti_resumen}</td>
    <td bgcolor=white align=center>{if $rec.noti_publicar eq 1}Sí{else}No{/if}</td>
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