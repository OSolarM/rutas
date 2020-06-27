{$Form->create("Crt")}

<div id="stylized" class="myform" style="width:550px;">
<h1>Modificaci&oacute;n de Crt</h1>
<p>Datos facturas, d&iacute;as estad&iacute;a</p>

<table>   
   <tr><td align="right">{lbl}N&uacute;mero    {/lbl}</td><td>{input name="crts_numero" size="20" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}Fecha            {/lbl}</td><td>{input name="fecha"       size="10" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}Operaci&oacute;n {/lbl}</td><td>{select name="tipo_operacion" readonly="true" size="20"}|,Importaci&oacute;n|I,Exportaci&oacute;n|E{/select}</td></tr>
   <tr><td align="right">{lbl}Cliente          {/lbl}</td><td>{hidden name="cliente_id"}{input name="razon" size="50" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}D&iacute;as estad&iacute;a{/lbl}</td><td>{input name="estadia_maxima" size="5" readonly="true" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Valor d&iacute;a extra          {/lbl}</td><td>{input name="valor_dia_extra" size="11" readonly="true" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Factura Crt      {/lbl}</td><td>{input name="factura_crt" size="10" readonly="true"}</td></tr>
   <tr><td align="right">{lbl}Fecha Carga      {/lbl}</td><td>{input name="fec_carga"    size="10"}</td></tr>
   <tr><td align="right">{lbl}Fec/Ent/Aduana   {/lbl}</td><td>{input name="fec_ent_aduana" size="10"}</td></tr>
   <tr><td align="right">{lbl}Fec/Sal/Aduana   {/lbl}</td><td>{input name="fec_sal_aduana" size="10"}</td></tr>
   <tr><td align="right">{lbl}Fecha Descarga   {/lbl}</td><td>{input name="fec_descarga" size="10"}</td></tr>
   <tr><td align="center">{lbl}D&iacute;as extras      {/lbl}</td><td>{input name="crts_dias_extras" size="5"   readonly="true" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Valor            {/lbl}</td><td>{input name="crts_valor_dias_extras" size="11" readonly="true" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Factura Días     {/lbl}</td><td>{input name="factura_dias" size="11" readonly="true"}</td></tr>

   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}

{glink caption="Volver" action="control_crts"}{/glink}

<div class="spacer"></div>
{literal}
<script language="javascript">
document.getElementById("fec_carga").focus();

$("#fec_descarga").blur(function(){
  cliente_id = $("#cliente_id").val();
  fec_carga = $("#fec_carga").val();
  fec_descarga = $("#fec_descarga").val();
  fec_ent_aduana = $("#fec_ent_aduana").val();
  fec_sal_aduana = $("#fec_sal_aduana").val();

  fec_carga=fec_carga.replace(/\//g, "");
  fec_descarga=fec_descarga.replace(/\//g, "");
  fec_ent_aduana=fec_ent_aduana.replace(/\//g, "");
  fec_sal_aduana=fec_sal_aduana.replace(/\//g, "");

  //alert(fec_carga+" "+fec_descarga);

  

  $.ajax({url:"http://www.ruta-chile.com/rutas/crts/calculos/"+cliente_id+"/"+fec_carga+"/"+fec_descarga+"/"+fec_ent_aduana+"/"+fec_sal_aduana,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[1]);

    document.getElementById("crts_dias_extras").value=l[0].trim();
    document.getElementById("crts_valor_dias_extras").value=l[1].trim();
  }});
});
</script>
{/literal}
</form>
</div>