{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:686px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Asignar Orden de Compra Ej&eacute;rcito de Chile</h1>
<p>Ordenes de Transporte Nacionales</p>

<table>
<tr>
    <td align="center">{lbl}orna_numero{/lbl}</td>
    <td align="center">{lbl}orna_fecha{/lbl}</td>
    <!--<td align="center">{lbl}institucion_id{/lbl}</td>-->
    <td align="center">{lbl}Cantidad de Ordenes{/lbl}</td>
    <!--<td align="center">{lbl}Valor Gu&iacute;a{/lbl}</td>
    <td align="center">{lbl}No Gu&iacute;a{/lbl}</td>    -->
</tr>
<tr>
    <td>{input name="id"   size="11" style="text-align:right" class="sololectura" readonly="true"}</td>
    <td>{input name="orna_fecha"    size="10"  class="sololectura" readonly="true"}</td>
    <!--<td>{select name="institucion_id"  class="sololectura" readonly="true"}{$instituciones}{/select}</td>-->
    <td align="center">{select name="orna_cant_ordenes"  class="sololectura" readonly="true"}|,1|1,2|2{/select}</td>
    <!--<td>{input name="orna_valor_guia"    size="10" style="text-align:right"}</td>
    <td>{input name="orna_no_guia"       size="10" style="text-align:right"  class="sololectura" readonly="true"}</td>-->
{hidden name="orna_valor_guia"}
{hidden name="orna_no_guia"}
</tr>
</table>

<table>
<tr>
    <td align="center">{lbl}Orden de Flete 1{/lbl}</td>
    <td align="center">{lbl}Orden de Compra 1{/lbl}</td>
    <td align="center">{lbl}Orden de Flete 2{/lbl}</td>    
    <td align="center">{lbl}Orden de Compra 2{/lbl}</td>
</tr>
<tr>
    <td>{input name="orna_orden_flete1" size="20"}</td>
    <td>{input name="orna_orden_compra" size="20"}</td>
    {if $orna_cant_ordene gt 1}
    <td>{input name="orna_orden_flete2" size="20"}</td>
    <td>{input name="orna_orden_compra2" size="20"}</td>
    {else}
    <td>{input name="orna_orden_flete2" size="20" class="sololectura" readonly="true"}</td>
    <td>{input name="orna_orden_compra2" size="20" class="sololectura" readonly="true"}</td>
    {/if}
    
</tr>
</table>

<table>
<tr><td align="center">{lbl}orna_m3{/lbl}</td>
    <td align="center">{lbl}orna_grado{/lbl} </td>
    <td align="center">{lbl}Apellidos{/lbl} </td>
    <td align="center">{lbl}Nombres{/lbl} </td>
    <td align="center">{lbl}orna_rut{/lbl}</td>
</tr>
<tr><td>{input name="orna_m3"      size="5" class="sololectura" readonly="true"}</td>
    <td>{select name="orna_grado" class="sololectura" readonly="true"}{$grados}{/select}</td>
    <td>{input name="orna_apellidos" size="25" class="sololectura" readonly="true"}</td>
    <td>{input name="orna_nombres" size="25" class="sololectura" readonly="true"}</td>
    <td>{input name="orna_rut"     size="12" class="sololectura" readonly="true"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Correo Electr&oacute;nico{/lbl}</td>
    <td align="center">{lbl}T&eacute;lefono fijo{/lbl} </td>
    <td align="center">{lbl}Celular{/lbl} </td>
    <!--<td align="center">{lbl}Dep&oacute;sito{/lbl} </td>
    <td align="center">{lbl}Monto ${/lbl} </td>-->
</tr>
<tr><td>{input name="orna_email"       size="30"  class="sololectura" readonly="true"}</td>
    <td>{input name="orna_fono"        size="15" class="sololectura" readonly="true"}</td>
    <td>{input name="orna_celular"     size="15" class="sololectura" readonly="true"}</td>
    <!--<td>{input name="orna_deposito"    size="15" style="text-align:right"}</td>
    <td>{input name="orna_monto_dep"   size="11" style="text-align:right"}</td>-->
    {hidden name="orna_deposito"}
    {hidden name="orna_monto_dep"}
</tr>
</table>


<table>
<tr>
   <td align="center">{lbl}orna_tipo_em{/lbl}</td>
   <td align="center">{lbl}orna_auto{/lbl}</td>
   <td align="center">{lbl}Orden Flete Auto{/lbl}</td>
   <td align="center">{lbl}Orden Compra Auto{/lbl}</td>
</tr>
<tr>
   <td>{select name="orna_tipo_em"         size="20" class="sololectura" readonly="true"}|,Menaje|M,Efectos Personales|E{/select}</td>
   <td>{select name="orna_auto" size="1" class="sololectura" readonly="true"}|,S&iacute;|S,No|N{/select}</td>
   {if $orna_aut eq "S"}
   <td>{input name="orna_orden_flete_auto"  size="25"}</td>
   <td>{input name="orna_orden_compra_auto" size="25"}</td>
   {else}
   <td>{input name="orna_orden_flete_auto"  size="25" class="sololectura" readonly="true"}</td>
   <td>{input name="orna_orden_compra_auto" size="25" class="sololectura" readonly="true"}</td>
   {/if}
</tr>
</table>

<table>
<tr>
   <td align="center">{lbl}orna_origen{/lbl}</td>
   <td align="center">{lbl}orna_destino{/lbl}</td>
</tr>
<tr>
   <td>{select name="orna_origen" class="sololectura" readonly="true" size="25"}{$origenes}{/select}</td>
   <td>{select name="orna_destino" class="sololectura" readonly="true" size="25"}{$destinos}{/select}</td>
</tr>
</table>


<table>
   <tr>
   <td align="center">{lbl}Fecha Retiro{/lbl}     </td>
   <td align="center">&nbsp;</td>
   <td align="center">{lbl}Direcci&oacute;n Retiro{/lbl} </td>
   <td align="center">{lbl}orna_repo_comuna{/lbl}    </td>
   </tr>
   <tr>
   <td>{input name="orna_repo_fecha"       size="10"  class="sololectura" readonly="true"}</td>
   <td><input type="button" id="retiros" value=".."    class="sololectura" disabled/></td>
   <td>{input name="orna_repo_direccion"  size="60" class="sololectura" readonly="true"}</td>
   <td>{input name="orna_repo_comuna"     size="25" maxlength="25" class="sololectura" readonly="true"}</td>
   </tr>
</table>

<table>
   <tr>
   <td align="center">{lbl}Fecha Llegada{/lbl} </td>
   <td align="center">&nbsp;</td>
   <td align="center">{lbl}Direcci&oacute;n Entrega{/lbl} </td>
   <td align="center">{lbl}orna_repo_comuna{/lbl}    </td>

   </tr>
   <tr>
   <td>{input name="orna_fecha_llegada"  size="10" class="sololectura"}</td>
   <td><input type="button" id="llegadas" value=".." class="sololectura" disabled/></td>
   <td>{input name="orna_direc_despacho"  size="60" class="sololectura" readonly="true"}</td>
   <td>{input name="orna_comuna_despacho"     size="25" class="sololectura" readonly="true"}</td>
   </tr>

</table>

<table>
   <tr>   <td align="center">{lbl}orna_repo_observa{/lbl}  </td>
   </tr>
   <tr>
   <td>{area name="orna_repo_observa"  cols="80" rows="8" class="sololectura" readonly="true"}</td>
   </tr>
</table>

<table width="100%">
<tr><td>{glink caption="Volver" action="asignar_orden"}{/glink}</td>
    <td align="right"><table><tr>
                             
                             
                             <td><button type="submit">Grabar</button></td>
                             
                             
                             
                             </tr></table></td>
                             </tr>
                      </table>
    </td>
</table>
{hidden name="orna_estado"        size="1"}


{hidden name="id"}
{hidden name="institucion_id"}
{hidden name="orna_cerrar"}
{hidden name="orna_nula"}



<div class="spacer"></div>
{literal}
<script language="javascript">
  function venRetiros() {
      win = window.open("http://www.ruta-chile.com/rutas/calendarios/retiros", "Calendario de Retiros", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("retiros").onclick = function() {
      venRetiros();
   }

  function venLlegadas() {
      win = window.open("http://www.ruta-chile.com/rutas/calendarios/llegadas", "Calendario de Llegadas", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("llegadas").onclick = function() {
      venLlegadas();
   }
   
   //document.getElementById("btnCerrar").onclick= function() {
   //   document.frm.orna_cerrar.value="S";
   //   document.frm.submit();
   //}
   
   var id = {/literal}{if $id ne ""}{$id}{else}0{/if}{literal};
   document.getElementById("btnAnular").onclick= function() {
      location.href="http://www.ruta-chile.com/rutas/ordenes_ejercitos/anular/"+id;
   
   }
   document.getElementById("btnADup").onclick= function() {
      location.href="http://www.ruta-chile.com/rutas/ordenes_ejercitos/anular_dup/"+id;
   
   }
</script>
{/literal}
</form>
</div>
