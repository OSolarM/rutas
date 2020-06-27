{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:870px;">
<h1>Órdenes de Transporte</h1>
<p>Datos para identificar la operación de transporte</p>

<table>
<tr><td align="center">Orden Número<td>
    <td align="center">Fecha<td>
    <td align="center">Procedencia<td>
</tr>

<tr><td>{input name="id"   size="11" readonly="true" style="text-align:right"}<td>
    <td>{input name="orna_fecha"    size="10"}<td>
    <td>{select name="institucion_id"}{$instituciones}{/select}<td>
</tr>
</table>

<table>
<tr><td><fieldset>
           <legend style="font-size:16px;">Identificación del Cliente</legend>
           <table border="1">
           <tr><td><label id="lblgrado"        >Grado    </label></td><td>{select name="orna_grado" }{$grados}{/select}</td></tr> 
           <tr><td><label name="orna_rut"      >Rut      </label></td><td>{input name="orna_rut"         size="12"}    </td></tr>
           <tr><td><label name="orna_apellidos">Apellidos</label></td><td>{input name="orna_apellidos"   size="25"}  </td></tr>
           <tr><td><label name="orna_nombres"  >Nombres  </label></td><td>{input name="orna_nombres"     size="25"}    </td></tr>
           <tr><td><label name="orna_fono"     >Teléfono </label></td><td>{input name="orna_fono"        size="15"}</td></tr>
           <tr><td><label name="orna_celular"  >Celular  </label></td><td>{input name="orna_celular"     size="15"}</td></tr>      
           <tr><td><label name="orna_email"    >E-Mail   </label></td><td>{input name="orna_email"       size="40"}</td></tr>    
           </table>
        </fieldset>
    </td>
    <td>
        <fieldset>
           <legend style="font-size:16px;">Qué Transporta</legend>
           <div style="height:180px;width:350px;float:left;">
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">Transporta</label><div style="float:left;">{select name="orna_tipo_em" size="25"}|,Menaje|M,Efectos Personales|E,Solo Automovil|A,Cajas|C{/select}</div>
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">M3        </label><div style="float:left;">{input name="orna_m3"      size="3" style="text-align:right"}                                          </div>
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">Automóvil </label><div style="float:left;">{select name="orna_auto" size="1"}|,S&iacute;|S,No|N{/select}                                          </div>
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">Patente   </label><div style="float:left;">{input name="orna_patente" size="15"}                                                                  </div>
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">Marca     </label><div style="float:left;">{input name="orna_marca"   size="20"}                                                                  </div>
              <div style="float:left;clear:both;"><label style="width:90px;float:left;padding:6px;">Modelo    </label><div style="float:left;">{input name="orna_modelo"  size="20"}                                                                  </div>
           </div>
        </fieldset>    
    </td>
</tr>
<tr>      
    <td><fieldset>
           <legend style="font-size:16px;">Origen/Destino</legend>
           <div style="height:200px;width:450px;float:left;">
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Fecha Retiro</label><div style="float:left;">{input name="orna_repo_fecha"       size="10"}<input type="button" id="retiros" value=".."/></div>
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Dirección</label><div style="float:left;">{input name="orna_repo_direccion"  size="60"}               </div>
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Comuna</label><div style="float:left;">{input name="orna_repo_comuna"     size="25" maxlength="25"}</div>
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Fecha Llegada</label><div style="float:left;">{input name="orna_fecha_llegada"   size="10"}<input type="button" id="llegadas" value=".."/></div>
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Dirección</label><div style="float:left;">{input name="orna_direc_despacho"  size="60"}               </div>
              <div style="float:left;clear:both;"><label style="width:100px;float:left;padding:6px;">Comuna</label><div style="float:left;">{input name="orna_comuna_despacho" size="25"}               </div>
           </div>           
        </fieldset>
    </td>
    
    <td><fieldset>
           <legend style="font-size:16px;">Forma de Pago</legend>
                   
        </fieldset>
    </td>
</tr>    
<tr><td colspan="2">
{lbl}Notas{/lbl}
{area name="orna_repo_observa"  cols="100" rows="4"}

</td>
</tr>
</table>


<!--
<fieldset>
<legend>Forma de Pago</legend>
{select name="orna_destino" size="25"}{$destinos}{/select}


</fieldset>


{select name="particular_id" size="50"}{$clientes}{/select}


{select name="orna_origen" size="25"}{$origenes}{/select}

   {input name="orna_orden_compra"  size="20"}





    {input name="orna_deposito"    size="15" style="text-align:right"}
    {input name="orna_monto_dep"   size="11" style="text-align:right"}




{lbl}Neto{/lbl}
    {lbl}Iva{/lbl} 
    {lbl}Total{/lbl}

{input name="orna_valor_guia" size="12" style="text-align:right"}
    {input name="orna_iva"        size="12" style="text-align:right"}
    {input name="orna_total"      size="12" style="text-align:right"}
   

      {lbl}orna_repo_observa{/lbl}  
   
   
   
   


-->
<table width="100%">
{glink caption="Volver" action="index"}{/glink}
    <td align="right"><button type="submit" {if $form_readonly eq "true"}disabled{/if}>Grabar</button>



{hidden name="orna_no_guia"}
{hidden name="orna_estado"}

{hidden name="id"}

{hidden name="orna_terceros"}

<div class="spacer"></div>
{literal}
<script language="javascript">
  function venRetiros() {
      win = window.open("{/literal}{$APP_HTTP}{literal}/calendarios/retiros", "Calendario de Retiros", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("retiros").onclick = function() {
      venRetiros();
   }

  function venLlegadas() {
      win = window.open("{/literal}{$APP_HTTP}{literal}/calendarios/llegadas", "Calendario de Llegadas", "location=1,status=1,scrollbars=1,width=900,height=500,toolbars=0,resizable=1");
   } 

   document.getElementById("llegadas").onclick = function() {
      venLlegadas();
   }
   
   document.getElementById("institucion_id").onchange = function() {
      procedencia = document.getElementById("institucion_id").value;
      
      //alert(procedencia);
      
      if (procedencia=="4") {
         document.getElementById("lblgrado").style.display = "none";
         document.getElementById("divgrado").style.display = "none";
      }
      else {
         document.getElementById("lblgrado").style.display = "block";
         document.getElementById("divgrado").style.display = "block";      
      }
   }
</script>
{/literal}
</form>
</div>
