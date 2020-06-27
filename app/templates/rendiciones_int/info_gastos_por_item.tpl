<h1>Informe de Gastos por Item</h1>

Desde el {$fecini} al {$fecfin}
<br/>

<table>
<tr>
<td valign="top">
<table celpadding="1" cellspacing="1" border="1">
{foreach from=$resumenes item=rec}
   <tr><td style="background:white" ><a href="javascript:muestra('{$rec.tabla}');">{$rec.item_descripcion}</a></td>
       <td style="background:white;{if $rec.item_descripcion eq "GIROS" or
                                       $rec.item_descripcion eq "ASIGNACION DE FONDOS" or
                                       $rec.item_descripcion eq "CARGA INICIAL COMBUSTIBLE"}color:red;{/if}" align="right">{$rec.dren_monto}</td></tr>
{/foreach}

<tr><td style="background:white;font-weight:bold;" >TOTAL</td>
    <td style="background:white;font-weight:bold;" align="right">{$suma}</td></tr>  
</table>
<label style="color:red;">(*)Montos en rojo no se consideran en el total</label>
</td>
<td><div id="medio" style="width:150px"></div></td>
<td valign="top">
<div id="contenido" style="background:lightgray;">
</div>
</td>
</tr>
</table>

{literal}
<script language="javascript">
   function muestra(tabla) {
      document.getElementById("contenido").innerHTML = "&nbsp;";
      document.getElementById("contenido").innerHTML = tabla;
   }
</script>
{/literal}