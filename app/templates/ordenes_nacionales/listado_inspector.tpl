<h1>Ordenes de Transporte: Listado Inspector</h1>

<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong>{t}Instituci&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Grado{/t}</strong></td>
    <td align=center><strong>{t}Apellidos{/t}</strong></td>
    <td align=center><strong>{t}Nombres{/t}</strong></td>
    <td align=center><strong>{t}orna_rut{/t}</strong></td>
    <td align=center><strong>{t}Direcci&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Comuna{/t}</strong></td>
    <td align=center><strong>{t}Ciudad{/t}</strong></td>
    <td align=center><strong>{t}Tel&eacute;fono{/t}</strong></td>
    <td align=center><strong>{t}Celular{/t}</strong></td>
</tr>

{foreach from=$listado item=rec}
<tr>
    <td bgcolor=white>{$rec.institucion}</td>
    <td bgcolor=white>{$rec.orna_grado}</td>
    <td bgcolor=white>{$rec.orna_apellidos}</td>
    <td bgcolor=white>{$rec.orna_nombres}</td>
    <td bgcolor=white>{$rec.orna_rut}</td>
    <td bgcolor=white>{$rec.orna_repo_direccion}</td>
    <td bgcolor=white>{$rec.orna_repo_comuna}</td>
    <td bgcolor=white>{$rec.ciudad}</td>
    <td bgcolor=white>{$rec.orna_fono}</td>
    <td bgcolor=white>{$rec.orna_celular}</td>


</tr>
{/foreach}
</table>
</td></tr>
</table>
