{$Form->create("Acoplado")}

<div id="stylized" class="myform" style="width:850px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Expediciones</h1>
<p>Datos b&aacute;sicos de los acoplados</p>
<table>
   
   <tr><td align="right">{lbl}N&uacute;mero{/lbl}    </td><td>{input name="expe_nro" size="10" readonly="true" style="text-align:right" class="sololectura"}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}    </td><td>{input name="expe_fecha" size="10" readonly="true" class="sololectura"}</td></tr>
   <tr><td align="right">{lbl}Chofer{/lbl}  </td><td>   {select name="chof_id" readonly="true" size="40"}{$choferes}{/select}</td></tr>
   <tr><td align="right">{lbl}Patente{/lbl}  </td><td>  {select name="cami_id" readonly="true" size="20"}{$camiones}{/select} </td></tr>
   <tr><td align="right">{lbl}Acoplado{/lbl}  </td><td> {select name="acop_id" readonly="true" size="20"}{$patentes}{/select} </td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}  </td><td>  {input name="expe_destino" size="35" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}Tarifa{/lbl}  </td><td>  {select name="tarifa_id" size="35" readonly="true"}{$ltarifas}{/select}</td></tr>
   <tr><td align="right">{lbl}Lastre{/lbl}  </td><td>  {select name="expe_lastre" readonly="true"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="expe_bloqueo" readonly="true"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td colspan="2"><table border="1">
             <tr><td align="center">Gu&iacute;a</td>
                 <td align="center">Remitente</td>
                 <td align="center">Destinatario</td>
                 <td align="center">&nbsp;</td>
             </tr>            


             {foreach from=$detalle item=rec}
             <tr><td>{$rec.crts_numero}</td>
                 <td              >{$rec.dexp_remitente}</td>
                 <td              >{$rec.dexp_destinatario}</td>
                 <td align="center">{if $expe_cerrado ne "S"}
                                    {glink caption="Modifica" action="editRecord"}/{$rec.id}{/glink}                                  
                                    {glink caption="Elimina" confirm="Seguro borrar registro?" action="delRecord"}/{$rec.id}{/glink}
                                    {/if}
                 </td>
             </tr>
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
</script>
{/literal}
</form>
</div>
