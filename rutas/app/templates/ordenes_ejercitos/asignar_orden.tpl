<h1>Asignaci&oacute;n Ordenes de Compra Ej&eacute;rcito</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create("OrdenNacional")}

{*{select name="despliegue"}Todos|T,Pendientes|P{/select}*}
{hidden name="despliegue" value="T"}

{*{glink img="add.png" caption="Nuevo" action="add"}{/glink}*}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor="#ebf4fb">
    <td align=center><strong>{t}orna_fecha{/t}</strong></td>
    <td align=center><strong>{t}orna_m3{/t}</strong></td>
    <td align=center><strong>{t}orna_grado{/t}</strong></td>
    <td align=center><strong>{t}Apellidos{/t}</strong></td>
    <td align=center><strong>{t}Nombres{/t}</strong></td>
    <td align=center><strong>{t}orna_rut{/t}</strong></td>
    <td align=center> </td>
</tr>

<tr style="background:white;">
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>{input name="orna_apellidos" size="25"}</strong></td>
    <td align=center><strong>{input name="orna_nombres" size="25"}</strong></td>
    <td bgcolor=white>&nbsp;</td>

    <td align=center>{submit value="Buscar" id="btnBuscar"}</td>
</tr>


{foreach from=$ordenesnacionales item=rec}
<tr>
    <td bgcolor=white>{$rec.orna_fecha}</td>
    <td bgcolor=white>{$rec.orna_m3}</td>
    <td bgcolor=white>{$rec.grad_descripcion}</td>
    <td bgcolor=white>{$rec.orna_apellidos}</td>
    <td bgcolor=white>{$rec.orna_nombres}</td>
    <td bgcolor=white>{$rec.orna_rut}</td>   
    <td bgcolor=white>{glink img="edit.gif"  caption="Asignar" action="asignar_orden_compra"}/{$rec.id}{/glink}
                      {*{glink img="delete.gif" caption="Elimina" confirm="?Seguro elimina registro?" action="delete"}/{$rec.id}{/glink}*}
 
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
   document.getElementById("despliegue").onchange = function() {
      document.frm.submit();
   }
</script>
{/literal}
</form>
