{$Form->create("Acoplado")}

<div id="stylized" class="myform" style="width:1050px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Expediciones</h1>
<p>Datos b&aacute;sicos de los acoplados</p>
<table>
   
   <tr><td align="right">{lbl}N&uacute;mero{/lbl}    </td><td>{input name="expe_nro" size="10" readonly="true" class="sololectura" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}    </td><td>{input name="expe_fecha" size="10"}</td></tr>
   <tr><td align="right">{lbl}Chofer{/lbl}  </td><td>   {select name="chof_id"}{$choferes}{/select}</td></tr>
   <tr><td align="right">{lbl}Patente{/lbl}  </td><td>  {select name="cami_id"}{$camiones}{/select} </td></tr>
   <tr><td align="right">{lbl}Acoplado{/lbl}  </td><td> {select name="acop_id"}{$patentes}{/select} </td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}  </td><td>  {input name="expe_destino" size="35"}</td></tr>
   <tr><td align="right">{lbl}Tarifa{/lbl}  </td><td>  {select name="tarifa_id"}{$ltarifas}{/select}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="expe_bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td colspan="2" style="background:lightgray"><table cellpading="1" cellspacing="1">
             <tr><td align="center">Gu&iacute;a</td>
                 <td align="center">Remitente</td>
                 <td align="center">Destinatario</td>
                 <td align="center">&nbsp;</td>
             </tr>
             <tr style="background:white">{hidden name="idRec"}
                 <td align="center">{select name="crt_id"}{$lcrts}{/select}</td>
                 <td align="center">{input  name="dexp_remitente"    size="40" readonly="true" class="sololectura"}</td>
                 <td align="center">{input  name="dexp_destinatario" size="40" readonly="true" class="sololectura"}</td>
                 <td align="center">
                 
                 <input type="submit" value="Modificar" id="btnAdd"/>
                 {glink caption="Cancelar" action="edit"}/{$idPadre}{/glink}
                  
             
                 </td>
             </tr>


             {foreach from=$detalle item=rec}
             {if $rec.id ne $idRec}
             <tr style="background:white"><td>{$rec.crts_numero}</td>
                 <td              >{$rec.dexp_remitente}</td>
                 <td              >{$rec.dexp_destinatario}</td>
                 <td align="center">&nbsp;
                 </td>
             </tr>
             {/if}
             {/foreach}
           </table>
       </td>
   </tr>
   <tr><td>{glink caption="Volver" action="index"}{/glink}</td>
   <td align="right">{if $id ne "" && $expe_cerrado ne "S"}{glink caption="Cerrar Expedici&oacute;n" confirm="Seguro cerrar expedici&oacute;n?" action="cerrar"}/{$rec.id}{/glink}{else}Cerrado{/if}<!--<button type="submit">Grabar</button>--></td></tr>
</table>
{hidden name="id"}
{hidden name="cmdLin"}
{hidden name="cmdId"}
{hidden name="expe_cerrado"}
{hidden name="expe_fondos"}


<div class="spacer"></div>
{literal}
<script language="javascript">
   function edita(id) {
      document.getElementById("cmdId").value=id;
      document.getElementById("cmdLin").value="edit";      
      document.frm.submit();
   }

   function elimina(id) {
      if (confirm("Seguro elimina registro?")) {
         document.getElementById("cmdId").value=id; 
         document.getElementById("cmdLin").value="del";
         document.frm.submit();
      } 
   }

   function cancela(id) {
      document.getElementById("cmdId").value=id;
      document.getElementById("cmdLin").value="cancel";
      document.frm.submit();
   }

$("#crt_id").change(function(){
  crt_id = $("#crt_id").val();

  if (crt_id=="") return;

  $.ajax({url:"http://www.ruta-chile.com/rutas/expediciones_ex/getDatosCrt/"+crt_id,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[0]);
    document.getElementById("dexp_remitente").value=l[0].trim();
    document.getElementById("dexp_destinatario").value=l[1].trim();
  }});
});
</script>
{/literal}
</form>
</div>
