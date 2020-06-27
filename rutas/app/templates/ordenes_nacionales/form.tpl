{$Form->create("OrdenNacional")}

<div class="container">

<div class="card">
  <div class="card-header">Ordenes de Transporte Nacionales</div>
  <div class="card-body">

<table>
<tr>
    <td align="center">{lbl}orna_numero{/lbl}</td>
    <td align="center">{lbl}orna_fecha{/lbl}</td>
    <td align="center">{lbl}Cliente{/lbl}</td>
    <td align="center">{lbl}Orden de Compra{/lbl}</td>
</tr>
<tr>
    <td>{input name="id"   size="11" readonly="true" style="text-align:right"}</td>
    <td>{input name="orna_fecha"    size="10"}</td>
    <td>{select name="particular_id" size="50"}{$clientes}{/select}</td>
    <td>{input name="orna_orden_compra"  size="20"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Terceros{/lbl}</td>
    <td align="center">{lbl}orna_m3{/lbl}</td>
    <td align="center">{lbl}Apellidos{/lbl} </td>
    <td align="center">{lbl}Nombres{/lbl} </td>
    <td align="center">{lbl}orna_rut{/lbl}</td>
</tr>
<tr><td>{select name="orna_terceros"}|,S&iacute;|S,No|N{/select}</td>
    <td>{input name="orna_m3"      size="3" style="text-align:right"}</td>
    <td>{input name="orna_apellidos" size="25"}</td>
    <td>{input name="orna_nombres" size="25"}</td>
    <td>{input name="orna_rut"     size="12"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Correo Electr&oacute;nico{/lbl}</td>
    <td align="center">{lbl}T&eacute;lefono fijo{/lbl} </td>
    <td align="center">{lbl}Celular{/lbl} </td>
    <td align="center">{lbl}Dep&oacute;sito{/lbl} </td>
    <td align="center">{lbl}Monto ${/lbl} </td>
</tr>
<tr><td>{input name="orna_email"       size="40"}</td>
    <td>{input name="orna_fono"        size="15"}</td>
    <td>{input name="orna_celular"     size="15"}</td>
    <td>{input name="orna_deposito"    size="15" style="text-align:right"}</td>
    <td>{input name="orna_monto_dep"   size="11" style="text-align:right"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Neto{/lbl}</td>
    <td align="center">{lbl}Iva{/lbl} </td>
    <td align="center">{lbl}Total{/lbl}</td>
</tr>
<tr><td>{input name="orna_valor_guia" size="12" style="text-align:right"}</td>
    <td>{input name="orna_iva"        size="12" style="text-align:right"}</td>
    <td>{input name="orna_total"      size="12" style="text-align:right"}</td>
</tr>
</table>

<table>
<tr>
   <td align="center">{lbl}orna_tipo_em{/lbl}</td>
   <td align="center">{lbl}orna_origen{/lbl}</td>
   <td align="center">{lbl}orna_destino{/lbl}</td>
</tr>
<tr>
   <td>{select name="orna_tipo_em" size="25"}|,Menaje|M,Efectos Personales|E,Solo Automovil|A,Cajas|C{/select}</td>
   <td>{select name="orna_origen" size="25"}{$origenes}{/select}</td>
   <td>{select name="orna_destino" size="25"}{$destinos}{/select}</td>
</tr>
</table>

<table>
<tr>
   <td align="center">{lbl}orna_auto{/lbl}</td>
   <td align="center">{lbl}Patente{/lbl}</td>
   <td align="center">{lbl}Marca{/lbl}</td>
   <td align="center">{lbl}Modelo{/lbl}</td>
</tr>
<tr>
   <td>{select name="orna_auto" size="1"}|,S&iacute;|S,No|N{/select}</td>
   <td>{input name="orna_patente" size="15"}</td>
   <td>{input name="orna_marca"   size="20"}</td>
   <td>{input name="orna_modelo"  size="20"}</td>
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
   <td>{input name="orna_repo_fecha"       size="10"}</td>
   <td><input type="button" id="retiros" value=".."/></td>
   <td>{input name="orna_repo_direccion"  size="60"}</td>
   <td>{input name="orna_repo_comuna"     size="25" maxlength="25"}</td>
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
   <td>{input name="orna_fecha_llegada"   size="10"}</td>
   <td><input type="button" id="llegadas" value=".."/></td>
   <td>{input name="orna_direc_despacho"  size="60"}</td>
   <td>{input name="orna_comuna_despacho" size="25"}</td>
   </tr>
</table>

<table>
   <tr>   <td align="center">{lbl}orna_repo_observa{/lbl}  </td>
   </tr>
   <tr>
   <td>{area name="orna_repo_observa"  cols="80" rows="8"}</td>
   </tr>
</table>


<table width="100%">
<tr><td>{glink caption="Volver" action="index"}{/glink}</td>
    <td align="right"><button type="submit" {if $form_readonly eq "true"}disabled{/if} class='btn btn-primary'>Grabar</button></td>
</tr>
</table>

</div>
</div>
</div>

{hidden name="orna_no_guia"}
{hidden name="orna_estado"}

{hidden name="id"}
{hidden name="institucion_id"}

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
</script>
{/literal}
</form>

