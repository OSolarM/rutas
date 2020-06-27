<td align="right"              bgcolor="white">&nbsp;</td><div id="stylized" class="myform" style="{if $expe_tipo eq "I"}width:950px;{else}width:700px;{/if}">
{$Form->create("Fondo")}
<h1>Rendici&oacute;n Fondos Expediciones Nacionales</h1>

<p>Datos b&aacute;sicos de las expediciones</p>
   <table>   
   <tr>  <td align="center">{lbl}N&uacute;mero{/lbl}</td>
         <td align="center">{lbl}Fecha{/lbl}</td>
         <td align="center">{lbl}Tipo Expedici&oacute;n{/lbl}</td>
         <td align="center">{lbl}Expedici&oacute;n No{/lbl}</td>
         <td align="center">{lbl}Chofer{/lbl}</td>
   </tr>

   <tr>
         <td>{input name="rend_nro" size="10" style="text-align:right" readonly="true"}</td>
         <td>{input name="rend_fecha" size="10" }</td>
         <td>{select name="expe_tipo" readonly="true" size="15"}|,Nacional|N,Internacional|I{/select}</td>
         <td>{input name="expe_nro" size="10" style="text-align:right" readonly="true"}</td>
         <td>{select name="chof_id" size="40"  readonly="true"}{$choferes}{/select}</td>
   </tr>
   </table>

   <table>
   <tr>
         <td align="center">{lbl}Fec/Salida{/lbl}</td>
         <td align="center">{lbl}Kil&oacute;metros{/lbl}</td>
         <td align="center">{lbl}Fec/Llegada{/lbl}</td>
         <td align="center">{lbl}Kil&oacute;metros{/lbl}</td>
   </tr>

   <tr>
         <td>{input name="rend_fecha_salida" size="10" }</td>
         <td>{input name="rend_kms_salida" size="12" style="text-align:right" readonly="true" class="sololectura"}</td>
         <td>{input name="rend_fecha_llegada" size="10" }</td>
         <td>{input name="rend_kms_llegada" size="12" style="text-align:right" readonly="true" class="sololectura"}</td>

   </tr>
   </table>

   {if $expe_tipo eq "I"}
   <table>
   <tr>
         <td align="center">{lbl}Fec/Aduana{/lbl}</td>
         <td align="center">{lbl}Fec/Bodega{/lbl}</td>
         <td align="center">{lbl}Fec/Descarga{/lbl}</td>         
         <td align="center">{lbl}Valor Vuelta{/lbl}</td>
   </tr>

   <tr>
         <td>{input name="rend_fec_aduana"   size="10" }</td>
         <td>{input name="rend_fec_bodega"   size="10" }</td>
         <td>{input name="rend_fec_descarga" size="10" }</td>
         <td>{input name="rend_valor_vuelta" value="100.000" size="10" style="text-align:right"}</td>
 
   </tr>
   </table>
   {/if}

{hidden name="rend_lugar_salida"}
{hidden name="rend_lugar_llegada"}

   <table>
   <tr>
         <td align="center">{lbl}Destino{/lbl}</td>
         <td align="center">{lbl}D&iacute;as{/lbl}</td>
         <td align="center">{lbl}D&iacute;as/Nac{/lbl}</td>
         {if $expe_tipo eq "I"}
         <td align="center">{lbl}D&iacute;as/Int{/lbl}</td>
         {else}
         <td align="center">{lbl}Peonetas{/lbl}</td>
         {/if}
         <td align="center">{lbl}Bloqueo{/lbl}</td>
         <td align="center">{lbl}Estado{/lbl}</td>
         <td align="center">{lbl}Fallida{/lbl}</td>
         <td align="center">{lbl}Motivo{/lbl}</td>
   </tr>

   <tr>
         <td>{input name="expe_destino" size="35" readonly="true"}</td>
         <td>{input name="dias" size="4" readonly="true" class="sololectura" style="text-align:right"}</td>
         <td>{input name="rend_dias_viaje_nac" size="4" style="text-align:right"}</td>
         {if $expe_tipo eq "I"}
         <td>{input name="rend_dias_viaje_int" size="4" style="text-align:right"}</td>
          {hidden name="rend_peonetas"}
          
         {else}
              {hidden name="rend_dias_viaje_int"}
              
              <td>{input name="rend_peonetas" size="2" style="text-align:right"}</td>
         {/if}
         <td>{select name="rend_bloqueo"}|,S&iacute;|S,No|N{/select}</td>
         <td>{select name="rend_estado"}|,Ingresado|I,Cerrado|C{/select}</td> 
         <td>{select name="rend_fallida"}|,S&iacute;|S,No|N{/select}</td> 
         <td>{input name="rend_detalle" size="40" maxlength="60"}</td> 
   </tr>
   </table>

   <br>

   {if $cuenta_detalle gt 0}
   <table>
   <table style="border:1px solid black">
   <tr>  <td align="center" bgcolor="#aabbcc">{lbl}Cliente{/lbl}</td> 
         <td align="center" bgcolor="#aabbcc">{lbl}Direcci&oacute;n{/lbl}</td> 
         <td align="center" bgcolor="#aabbcc">{lbl}Crt{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Valor Flete{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Moneda{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Factura{/lbl}</td>
   </tr>
   </tr>
   {foreach from=$detalle_cliente item=rec}
    <tr>
       <td bgcolor="white">{$rec.cliente}</td>
       <td bgcolor="white">{$rec.direccion}</td>
       <td bgcolor="white">{$rec.crts_numero}</td>
       <td bgcolor="white" align="right">{$rec.crts_valor_flete}</td>
       <td bgcolor="white" align="center">{$rec.crts_mon_flete}</td>
       <td bgcolor="white">{$rec.factura_crt}</td>
    </tr>
   {/foreach}
   </table>
<br/>
   {/if}

   <table cellspacing="5px">
   <tr>
   <td valign="top">

   <table style="border:1px solid black">
   <tr>  <td align="center" bgcolor="#aabbcc" colspan="3">{lbl}MONEDA NACIONAL{/lbl}</td> 
   </tr>
   <tr>  <td align="center" bgcolor="#aabbcc">{lbl}Item de Gasto{/lbl}</td> 
         <td align="center" bgcolor="#aabbcc">{lbl}Monto{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Litros{/lbl}</td>
   </tr>
   <tr><td                            bgcolor="white">LITROS CARGADOS</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
       <td align="right"              bgcolor="white">{input name="litros_inicio" size="6" readonly="true" class="sololectura" style="text-align:right"}</td>
   </tr>
   {foreach from=$gasto_nacional item=rec}
   <tr><td                            bgcolor="white">{$rec.item_descripcion}</td>
       <td align="right"              bgcolor="white"><input type="text" id="monto_{$rec.item_id}" name="monto_{$rec.item_id}" value="{$rec.dren_monto}" size=12 style="text-align:right" {if $rec.item_id==9}readonly class="sololectura"{else}onblur="sumNacional(this);"{/if}/></td>
       <td align="right"              bgcolor="white">{if $rec.item_litros eq "S"}
                                                         <input type="text" id="litros_{$rec.item_id}" name="litros_{$rec.item_id}" value="{$rec.dren_litros}" size=6 style="text-align:right" onblur="chkLItros(this);"/>
                                                      {else}
                                                           &nbsp;
                                                      {/if}
       </td>
   </tr>
{/foreach}
   <tr><td                            bgcolor="white">{lbl}TOTAL{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="totNac" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}ASIGNADO{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="fond_monto" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white"><strong><label id="lbl_difNac" for="difNac">DIFERENCIA</label></strong></td>
       <td align="right"              bgcolor="white">{input name="difNac" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}DEVOLUCION DINEROS{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_devol_chofer" size="12" style="text-align:right"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}SALDO PEND.CHOFER{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_pendiente_chofer" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}PAGADO A CHOFER{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_pagado_chofer" size="12" style="text-align:right"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   </table>
   </td>
   <td>
   {if $id_moneda2 ne ""}
   <table style="border:1px solid black">
   <tr>  <td align="center" bgcolor="#aabbcc" colspan="3">{lbl}{$moneda2}{/lbl}</td> 
   </tr>
   <tr>  <td align="center" bgcolor="#aabbcc">{lbl}Item de Gasto{/lbl}</td> 
         <td align="center" bgcolor="#aabbcc">{lbl}Monto{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Litros{/lbl}</td>
   </tr>

   <tr><td                            bgcolor="white">LITROS IDA MENDOZA</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
       <td align="right"              bgcolor="white">{input name="rend_litros_ida_mendoza" size="6" style="text-align:right"}</td>
   </tr>

   <tr><td                            bgcolor="white">LITROS REGRESO MENDOZA</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
       <td align="right"              bgcolor="white">{input name="rend_litros_regreso_mendoza" size="6" style="text-align:right"}</td>
   </tr>
   
   {foreach from=$gasto_nacional_moneda2 item=rec}
   <tr><td                            bgcolor="white">{$rec.item_descripcion}</td>
       <td align="right"              bgcolor="white"><input type="text" id="monto_mon2_{$rec.item_id}" name="monto_mon2_{$rec.item_id}" value="{$rec.dren_monto}" size=12 style="text-align:right" {if $rec.item_id eq 20}readonly class="sololectura"{else}onblur="sumMoneda2(this);"{/if}/></td>
       <td align="right"              bgcolor="white">{if $rec.item_litros eq "S"}
                                                         <input type="text" id="litros_mon2_{$rec.item_id}" name="litros_mon2_{$rec.item_id}" value="{$rec.dren_litros}" size=6 style="text-align:right" onblur="chkLItros2(this);"/>
                                                      {else}
                                                           &nbsp;
                                                      {/if}
       </td>
   </tr>
   {/foreach}

   <tr><td                            bgcolor="white">{lbl}TOTAL{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="totNac2" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}ASIGNADO{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="fond_monto2" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white"><strong><label id="lbl_difNac2" for="difNac2">DIFERENCIA</label></td>
       <td align="right"              bgcolor="white">{input name="difNac2" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}DEVOL.CHOFER{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_devol_chofer_mon2" size="12" style="text-align:right"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}SALDO PEND.CHOFER{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_pendiente_chofer2" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}PAGADO A CHOFER{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="rend_pagado_chofer_mon2" size="12" style="text-align:right"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   </table>
   {else}
   {hidden name="rend_devol_chofer_mon2"}
   {/if}
   </td>
   <td>
   {if $fond_monto3 > 0}

   <table style="border:1px solid black">
   <tr>  <td align="center" bgcolor="#aabbcc" colspan="3">{lbl}MONEDA3{/lbl}</td> 
   </tr>
   <tr>  <td align="center" bgcolor="#aabbcc">{lbl}Item de Gasto{/lbl}</td> 
         <td align="center" bgcolor="#aabbcc">{lbl}Monto{/lbl}</td>
         <td align="center" bgcolor="#aabbcc">{lbl}Litros{/lbl}</td>
   </tr>
   {foreach from=$gasto_nacional_moneda3 item=rec}
   <tr><td                            bgcolor="white">{$rec.item_descripcion}</td>
       <td align="right"              bgcolor="white"><input type="text" id="monto_mon3_{$rec.item_id}" name="monto_mon3_{$rec.item_id}" value="{$rec.dren_monto}" size=12 style="text-align:right" {if $rec.item_id eq 20}readonly class="sololectura"{else}onblur="sumMoneda3(this);"{/if}/></td>
       <td align="right"              bgcolor="white">{if $rec.item_litros eq "S"}
                                                         <input type="text" id="litros_mon3_{$rec.item_id}" name="litros_mon3_{$rec.item_id}" value="{$rec.dren_litros}" size=6 style="text-align:right" onblur="chkLItros3(this);"/>
                                                      {else}
                                                           &nbsp;
                                                      {/if}
       </td>
   </tr>
   {/foreach}
   <tr><td                            bgcolor="white">{lbl}TOTAL{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="totNac3" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}ASIGNADO{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="fond_monto3" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   <tr><td                            bgcolor="white">{lbl}DIFERENCIA{/lbl}</td>
       <td align="right"              bgcolor="white">{input name="difNac3" size="12" style="text-align:right" readonly="true"}</td>
       <td align="right"              bgcolor="white">&nbsp;</td>
   </tr>
   </table>
   {/if}
   </td>
   </tr>
   <tr><td>{glink caption="Volver" action="index"}{/glink}</td>
       <td>&nbsp;</td>
       <td>{submit value="Grabar"}</td>
   </tr>
   </table>
 

<div class="spacer"></div>
{hidden name="id"}
{hidden name="cmdLin"}
{hidden name="det_id"}
{hidden name="comision_vuelta"}
{hidden name="dias_espera"}
{hidden name="viatico_chile"}
{hidden name="viatico_argentina"}
{hidden name="id_moneda2"}
{hidden name="id_moneda3"}
{hidden name="expe_id"}
{hidden name="fondo_id"}

{literal}
<script language="javascript">

$(document).ready(function() {
   //alert("Entrando!");

   actualizaValores();

   sumNacional(0);
   sumMoneda2(0);




});



   function sumNacional(n) {
      document.getElementById("totNac").value = 
                                                parseInt(document.getElementById("monto_1" ).value) +
                                                parseInt(document.getElementById("monto_10").value) +
                                                parseInt(document.getElementById("monto_2" ).value) +
                                                parseInt(document.getElementById("monto_3" ).value) +
                                                parseInt(document.getElementById("monto_4" ).value) +
                                                parseInt(document.getElementById("monto_5" ).value) +
                                                parseInt(document.getElementById("monto_6" ).value) +
                                                parseInt(document.getElementById("monto_7" ).value) +
                                                parseInt(document.getElementById("monto_8" ).value) +
                                                parseInt(document.getElementById("monto_9" ).value);

      document.getElementById("difNac").value = parseInt(document.getElementById("fond_monto").value) -
                                                parseInt(document.getElementById("totNac").value);

      difNac = document.getElementById("difNac").value;

      if (difNac >= 0) 
         document.getElementById("lbl_difNac").innerHTML="CHOFER DEBE PAGAR";
      else
         document.getElementById("lbl_difNac").innerHTML="SE ADEUDA A CHOFER";


      difNac = parseInt(document.getElementById("difNac").value);
      devol  = parseInt(document.getElementById("rend_devol_chofer").value);

      //alert(devol);

      if (difNac > 0) {
         if (difNac > devol) {
            document.getElementById("rend_pendiente_chofer").value = parseInt(difNac)-parseInt(devol); 
         }
         else
            document.getElementById("rend_pendiente_chofer").value = "0"; 
      }
      else
         document.getElementById("rend_pendiente_chofer").value = "0"; 

         
      
   }

   function chkLitros(n) {
   } 

   function sumMoneda2(n) {                                                                                                                                                                        
                                                                                                         
      document.getElementById("totNac2").value =                                                         
                                                parseInt(document.getElementById("monto_mon2_11" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_12" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_13" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_14" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_15" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_16" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_17" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_18" ).value) +    
                                                parseInt(document.getElementById("monto_mon2_19" ).value) +  
                                                parseInt(document.getElementById("monto_mon2_21" ).value) +      
                                                parseInt(document.getElementById("monto_mon2_20" ).value);     
                                                                                                         
      document.getElementById("difNac2").value = parseInt(document.getElementById("fond_monto2").value) -
                                                parseInt(document.getElementById("totNac2").value);   

      difNac2 = document.getElementById("difNac2").value;

      if (difNac2 >= 0) 
         document.getElementById("lbl_difNac2").innerHTML="CHOFER DEBE PAGAR";
      else
         document.getElementById("lbl_difNac2").innerHTML="SE ADEUDA A CHOFER";


      difNac2 = parseInt(document.getElementById("difNac2").value);
      devol2  = parseInt(document.getElementById("rend_devol_chofer_mon2").value);

      //alert(devol);

      if (difNac2 > 0) {
         if (difNac2 > devol2) {
            document.getElementById("rend_pendiente_chofer2").value = parseInt(difNac2)-parseInt(devol2); 
         }
         else
            document.getElementById("rend_pendiente_chofer2").value = "0"; 
      }
      else
         document.getElementById("rend_pendiente_chofer2").value = "0";  
                                                                                                         
   }   

   function chkLitros2(n) {
   } 

   function sumMoneda3(n) {                                                                                                                                                                        
                                                                                                         
      document.getElementById("totNac3").value =                                                         
                                                parseInt(document.getElementById("monto_mon3_11" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_12").value) +    
                                                parseInt(document.getElementById("monto_mon3_13" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_14" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_15" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_16" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_17" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_18" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_19" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_21" ).value) +    
                                                parseInt(document.getElementById("monto_mon3_20" ).value);     
                                                                                                         
      document.getElementById("difNac3").value = parseInt(document.getElementById("fond_monto3").value) -
                                                parseInt(document.getElementById("totNac3").value);      
                                                                                                         
   }   

   function chkLitros3(n) {
   } 

   function actualizaValores() {

      //alert("actualizaValores");
      dias_nac = parseInt(document.getElementById("rend_dias_viaje_nac").value);
      dias_int = parseInt(document.getElementById("rend_dias_viaje_int").value);
      peonetas = parseInt(document.getElementById("rend_peonetas").value) + 1;


      //alert("Viaticos");

      viatico_chile     = parseInt(document.getElementById("viatico_chile").value);
      viatico_argentina = parseInt(document.getElementById("viatico_argentina").value);

      id_moneda2 = document.getElementById("id_moneda2").value;
      id_moneda3 = document.getElementById("id_moneda3").value;

      //alert(viatico_chile);

      

      document.getElementById("monto_9").value = parseInt(dias_nac)*parseInt(viatico_chile)*parseInt(peonetas);

      if (id_moneda2==1) {
         document.getElementById("monto_mon2_20").value = parseInt(dias_int)*parseInt(viatico_argentina)*parseInt(peonetas);
         
      }

      if (id_moneda3==1) {
         document.getElementById("monto_mon3_20").value = parseInt(dias_int)*parseInt(viatico_argentina)*parseInt(peonetas);
         
      }


      difNac = parseInt(document.getElementById("difNac").value);
      devol  = parseInt(document.getElementById("rend_devol_chofer").value);

      //alert(devol);

      if (difNac > 0) {
         if (difNac > devol) {
            document.getElementById("rend_pendiente_chofer").value = parseInt(difNac)-parseInt(devol); 
         }
         else
            document.getElementById("rend_pendiente_chofer").value = "0"; 
      }
      else
         document.getElementById("rend_pendiente_chofer").value = "0"; 


      sumNacional(0);

      sumMoneda2(0);

   }

   document.getElementById("rend_dias_viaje_nac").onblur=function() {
      actualizaValores();
   }

   document.getElementById("rend_dias_viaje_int").onblur=function() {
      actualizaValores();
   }

   document.getElementById("rend_peonetas").onblur=function() {
      actualizaValores();
   }

   document.getElementById("rend_devol_chofer").onblur=function() {
      actualizaValores();
   }

   document.getElementById("rend_devol_chofer_mon2").onblur=function() {
      actualizaValores();
   }



$("#rend_fecha_llegada").blur(function(){
  //alert("Llegada");

  f1 = $("#rend_fecha_llegada").val();
  f2  = $("#rend_fecha_salida").val();

  ff  =f1.split("/");

  fini  = ff[0]+"."+ff[1]+"."+ff[2];

  ff  =f2.split("/");

  ffin  = ff[0]+"."+ff[1]+"."+ff[2];

  if (rend_fecha_llegada=="" || rend_fecha_salida=="") return;

  $.ajax({url:"http://www.ruta-chile.com/rutas/rendiciones/getDias/"+fini+"/"+ffin,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[0]);
    document.getElementById("dias").value=l[0].trim();
  }});


});

$("#rend_fecha_salida").blur(function(){
  f1 = $("#rend_fecha_llegada").val();
  f2  = $("#rend_fecha_salida").val();

  ff  =f1.split("/");

  fini  = ff[0]+"."+ff[1]+"."+ff[2];

  ff  =f2.split("/");

  ffin  = ff[0]+"."+ff[1]+"."+ff[2];

  if (rend_fecha_llegada=="" || rend_fecha_salida=="") return;

  $.ajax({url:"http://www.ruta-chile.com/rutas/rendiciones/getDias/"+fini+"/"+ffin,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[0]);
    document.getElementById("dias").value=l[0].trim();
  }});
});

</script>   
{/literal}
</form>
</div>
