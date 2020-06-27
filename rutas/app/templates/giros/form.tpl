{$Form->create("Expedicion")}

<div id="stylized" class="myform" style="width:550px;">
<h1>Giros y Dep&oacute;sitos a Expediciones</h1>
<p>Dineros girados y/o depositados</p>
<table><tr><td>
<table>
<tr><td align="right">{lbl}N&uacute;mero  {/lbl}</td><td>{input name="giro_nro"     size="8" readonly="true" style="text-align:right"}</td></tr>
<tr><td align="right">{lbl}Fecha  {/lbl}</td><td>{input name="giro_fecha"   size="10"}</td></tr>
<tr><td align="right">{lbl}Chofer	   {/lbl}</td><td>{select name="chof_id"}{$lchoferes}{/select} </td></tr>
<tr><td align="right">{lbl}Detalle{/lbl}</td><td>{input name="giro_detalle" size="60"}</td></tr>
<tr><td align="right">{lbl}Moneda	   {/lbl}</td><td>{select name="mone_id"}{$lmonedas}{/select} </td></tr>
<tr><td align="right">{lbl}Monto  {/lbl}</td><td>{input name="giro_monto" size="10" style="text-align:right"}</td></tr>
<tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>

{hidden name="id"}
{hidden name="expe_tipo"}
{hidden name="expe_id"}	
{hidden name="giro_bloqueo"}

{glink caption="Volver" action="index"}{/glink}


<!---->
{literal}
<script language="javascript">
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}


$("#chof_id").change(function(){
  chof_id = $("#chof_id").val();

  //alert(chof_id);

  $.ajax({url:"http://www.ruta-chile.com/rutas/giros/getExpedicion/"+chof_id,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[0]);
    document.getElementById("expe_tipo").value=l[0].trim();
    document.getElementById("expe_id").value=l[1].trim();
  }});
});
</script>
{/literal}


</form>

</div>
