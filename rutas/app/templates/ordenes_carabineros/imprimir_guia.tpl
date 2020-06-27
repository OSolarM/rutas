{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:690px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Carabineros de Chile</h1>
<p>Impresi&oacute;n Gu&iacute;a</p>

<table>
<tr>
    <td align="center">{lbl}orna_numero{/lbl}</td>
    <td align="center">{lbl}orna_fecha{/lbl}</td>
    <!--<td align="center">{lbl}institucion_id{/lbl}</td>-->
    <td align="center">{lbl}Orden de Compra{/lbl}</td>
    <!--<td align="center">{lbl}Lista Autorizaciones{/lbl}</td>-->
    <!--<td align="center">{lbl}Valor Gu&iacute;a{/lbl}</td>
    <td align="center">{lbl}No Gu&iacute;a{/lbl}</td>-->
</tr>
<tr>
    <td>{input name="id"   size="11" readonly="true" style="text-align:right" class="sololectura"}</td>
    <td>{input name="orna_fecha"    size="10" readonly="true" class="sololectura"}</td>
    <!--<td>{select name="institucion_id"}{$instituciones}{/select}</td>-->
    <td>{input name="orna_orden_compra"  size="20" readonly="true" class="sololectura"}</td>
    <!--<td>{select name="lista_carabineros"}{$lista_carabineros}{/select}</td>-->
    <!--<td>{input name="orna_valor_guia"    size="10" style="text-align:right"}</td>
    <td>{input name="orna_no_guia"       size="10" style="text-align:right"}</td>-->

    {hidden name="orna_valor_guia"}
    {hidden name="orna_no_guia"}

</tr>
</table>

<table>
<tr><td align="center">{lbl}orna_m3{/lbl}</td>
    <td align="center">{lbl}orna_grado{/lbl} </td>
    <td align="center">{lbl}Apellidos{/lbl} </td>
    <td align="center">{lbl}Nombres{/lbl} </td>
    <td align="center">{lbl}orna_rut{/lbl}</td>
</tr>
<tr><td>{input name="orna_m3"      size="5" style="text-align:right" readonly="true" class="sololectura"}</td>
    <td>{select name="orna_grado"  readonly="true" class="sololectura" size="25"}{$grados}{/select}</td>
    <td>{input name="orna_apellidos" size="25" readonly="true" class="sololectura"}</td>
    <td>{input name="orna_nombres" size="25" readonly="true" class="sololectura"}</td>
    <td>{input name="orna_rut"     size="12" readonly="true" class="sololectura"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Correo Electr&oacute;nico{/lbl}</td>
    <td align="center">{lbl}T&eacute;lefono fijo{/lbl} </td>
    <td align="center">{lbl}Celular{/lbl} </td>
    <!--<td align="center">{lbl}Dep&oacute;sito{/lbl} </td>
    <td align="center">{lbl}Monto ${/lbl} </td>-->
</tr>
<tr><td>{input name="orna_email"       size="30" readonly="true" class="sololectura"}</td>
    <td>{input name="orna_fono"        size="15" readonly="true" class="sololectura"}</td>
    <td>{input name="orna_celular"     size="15" readonly="true" class="sololectura"}</td>
    <!--<td>{input name="orna_deposito" size="15" style="text-align:right"}</td>
    <td>{input name="orna_monto_dep"   size="11" style="text-align:right"}</td>-->
{hidden name="orna_deposito"}
{hidden name="orna_monto_dep"}
</tr>
</table>

<table>
<tr>
   <td align="center">{lbl}orna_tipo_em{/lbl}</td>
   <td align="center">{lbl}orna_auto{/lbl}</td>
   <td align="center">{lbl}orna_origen{/lbl}</td>
   <td align="center">{lbl}orna_destino{/lbl}</td>
</tr>
<tr>
   <td>{select name="orna_tipo_em"         size="15" readonly="true" class="sololectura"}|,Menaje|M,Efectos Personales|E{/select}</td>
   <td>{select name="orna_auto" size="1" readonly="true" class="sololectura"}|,S&iacute;|S,No|N{/select}</td>
   <td>{select name="orna_origen" readonly="true" class="sololectura" size="25"}{$origenes}{/select}</td>
   <td>{select name="orna_destino" readonly="true" class="sololectura" size="25"}{$destinos}{/select}</td>
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
   <td>{input name="orna_repo_fecha" size="10" class="sololectura" readonly="true" class="sololectura"}</td>
   <td><input type="button" id="retiros" value=".." readonly="true" class="sololectura"/></td>
   <td>{input name="orna_repo_direccion"  size="60" readonly="true" class="sololectura"}</td>
   <td>{input name="orna_repo_comuna"     size="25" maxlength="25" readonly="true" class="sololectura"}</td>
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
   <td>{input name="orna_fecha_llegada"   size="10" readonly="true" class="sololectura"}</td>
   <td><input type="button" id="llegadas" value=".." readonly="true" class="sololectura"/></td>
   <td>{input name="orna_direc_despacho"  size="60" readonly="true" class="sololectura"}</td>
   <td>{input name="orna_comuna_despacho" size="25" readonly="true" class="sololectura"}</td>
   </tr>
</table>

<table>
   <tr>   <td align="center">{lbl}orna_repo_observa{/lbl}  </td>
   </tr>
   <tr>
   <td>{area name="orna_repo_observa"  cols="80" rows="8" readonly="true" class="sololectura"}</td>
   </tr>
</table>



<table width="100%">
<tr><td>{glink caption="Volver" action="index"}{/glink}</td>
    <td align="right"><table><tr>
                             <td><button type="submit">Imprimir</button></td>
                             
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
   document.getElementById("frm").onsubmit = function() {
      return confirm("Seguro imprimir guia?");
   }

</script>
{/literal}
</form>
</div>
