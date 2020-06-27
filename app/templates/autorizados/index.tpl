<h1>Lista de Autorizados</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{glink caption="Agregar" action="add"}{/glink}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>{t}A&ntilde;o{/t}</strong></td>
    <td align=center><strong>{t}Mts3{/t}</strong></td>
    <td align=center><strong>{t}Grado{/t}</strong></td>
    <td align=center><strong>{t}Apellidos{/t}</strong></td>
    <td align=center><strong>{t}Nombres{/t}</strong></td>
    <td align=center><strong>{t}Rut{/t}</strong></td>
    <td align=center><strong>{t}Origen{/t}</strong></td>
    <td align=center><strong>{t}Destino{/t}</strong></td>
    <td align=center><strong>{t}Bloqueo{/t}</strong></td>
    <td align=center> </td>
</tr>

{foreach from=$autorizados item=rec}
<tr>
    <td bgcolor=white>{$rec.auto_agno}</td>
    <td bgcolor=white>{$rec.auto_mts3}</td>
    <td bgcolor=white>{$rec.auto_grado}</td>
    <td bgcolor=white>{$rec.auto_apellidos}</td>
    <td bgcolor=white>{$rec.auto_nombres}</td>
    <td bgcolor=white>{$rec.auto_rut}</td>
    <td bgcolor=white>{$rec.auto_origen_nombre}</td>
    <td bgcolor=white>{$rec.auto_destino_nombre}</td>
    <td bgcolor=white>{if $rec.auto_bloqueo eq "S"}S&iacute;{else}No{/if}</td>
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
