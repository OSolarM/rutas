{$Form->create("Acoplado")}

<div id="stylized" class="myform" style="width:950px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Expediciones</h1>
<p>Datos b&aacute;sicos de los acoplados</p>
<table>
   
   <tr><td align="right">{lbl}N&uacute;mero{/lbl}    </td><td>{input name="expe_nro" size="10" readonly="true" class="sololectura" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Fecha{/lbl}    </td><td>{input name="expe_fecha" size="10"}</td></tr>
   <tr><td align="right">{lbl}Chofer{/lbl}  </td><td>   {select name="chof_id"}{$choferes}{/select}</td></tr>
   <tr><td align="right">{lbl}Patente{/lbl}  </td><td>  {select name="cami_id"}{$camiones}{/select} </td></tr>
   <tr><td align="right">{lbl}Acoplado{/lbl}  </td><td> {select name="acop_id"}{$patentes}{/select} </td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}  </td><td>  {select name="expe_destino"}|,Norte|N,Sur|S{/select}</td></tr>
   <tr><td align="right">{lbl}Orden de Compra{/lbl}    </td><td>{select name="orna_orden_compra"}{$ordenes}{/select}</td></tr>
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="expe_bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>

   <tr><td colspan="2" align="right"><input type="submit" value="Procesar" id="btnAdd" style="float:right"/></td></tr>

   
   <tr><td colspan="2">{glink caption="Volver" action="index"}{/glink}</td><tr>
</table>
{hidden name="id"}
{hidden name="cmdLin"}
{hidden name="cmdId"}
{hidden name="expe_cerrado"}
{hidden name="expe_fondos"}


<div class="spacer"></div>
</form>
</div>
