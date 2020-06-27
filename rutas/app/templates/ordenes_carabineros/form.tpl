{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:690px;">
<h1>Carabineros de Chile</h1>
<p>Ordenes de Transporte Nacionales</p>

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
    <td>{input name="orna_fecha"    size="10"}</td>
    <!--<td>{select name="institucion_id"}{$instituciones}{/select}</td>-->
    <td>{input name="orna_orden_compra"  size="20"}</td>
    <!--<td>{select name="lista_carabineros"}{$lista_carabineros}{/select}</td>-->
    <!--<td>{input name="orna_valor_guia"    size="10" style="text-align:right"}</td>
    <td>{input name="orna_no_guia"       size="10" style="text-align:right"}</td>-->

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
<tr><td>{input name="orna_m3"      size="5" style="text-align:right"}</td>
    <td>{select name="orna_grado" }{$grados}{/select}</td>
    <td>{input name="orna_apellidos" size="25"}</td>
    <td>{input name="orna_nombres" size="25"}</td>
    <td>{input name="orna_rut"     size="12"}</td>
</tr>
</table>

<table>
<tr><td align="center">{lbl}Correo Electr&oacute;nico{/lbl}</td>
    <td align="center">{lbl}T&eacute;lefono fijo{/lbl} </td>
    <td align="center">{lbl}Celular{/lbl} </td>
    <!--<td align="center">{lbl}Dep&oacute;sito{/lbl} </td>
    <td align="center">{lbl}Monto ${/lbl} </td>-->
</tr>
<tr><td>{input name="orna_email"       size="40"}</td>
    <td>{input name="orna_fono"        size="15"}</td>
    <td>{input name="orna_celular"     size="15"}</td>
    <!--<td>{input name="orna_deposito"    size="15" style="text-align:right"}</td>
    <td>{input name="orna_monto_dep"   size="11" style="text-align:right"}</td>-->
{hidden name="orna_deposito"}
{hidden name="orna_monto_dep"}
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
   <td>{select name="orna_tipo_em"         size="1"}|,Menaje|M,Efectos Personales|E,Solo Automovil|A{/select}</td>
   <td>{select name="orna_origen"}{$origenes}{/select}</td>
   <td>{select name="orna_destino"}{$destinos}{/select}</td>
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
   <td>{input name="orna_repo_fecha" size="10" class="sololectura"}</td>
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
   <td>{input name="orna_fecha_llegada"   size="10" class="sololectura"}</td>
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
    <td align="right"><table><tr>
                             <td><button type="submit">Grabar</button></td>
                             
                             {if $id ne ""}
                             <!--<td><button type="button" id="btnCerrar">Cerrar e Imprim</button></td>-->
                             <td><button type="button" id="btnAnular">Anular</button></td>
                             <td><button type="button" id="btnADup">Anular y Duplicar</button></td>
                             {else}
                                {hidden name="btnCerrar"}
                                {hidden name="btnAnular"}
                                {hidden name="btnADup"  }
                             {/if}
                             
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
{hidden name="orna_email1"}
{hidden name="orna_email2"}
{hidden name="orna_email3"}



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
      if (confirm("Seguro de anular guia?")) 
         location.href="http://www.ruta-chile.com/rutas/ordenes_carabineros/anular/"+id;
   
   }
   document.getElementById("btnADup").onclick= function() {
      if (confirm("Seguro de anular y duplicar guia?")) 
         location.href="http://www.ruta-chile.com/rutas/ordenes_carabineros/anular_dup/"+id;
   
   }
   
   /*
   document.getElementById("lista_carabineros").onchange = function() {
      var e = this.value.split("ç");
      document.getElementById("orna_m3").value        =e[0];
      document.getElementById("orna_grado").value     =e[1];
      document.getElementById("orna_apellidos").value =e[2];
      document.getElementById("orna_nombres").value   =e[3];
      document.getElementById("orna_rut").value       =e[4];
      document.getElementById("orna_auto").value      =e[5];
      document.getElementById("orna_origen").value    =e[6];
      document.getElementById("orna_destino").value   =e[7];

   }
   */
</script>
{/literal}
</form>
</div>
