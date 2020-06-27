<div id="stylized" class="myform" style="width:550px;">
{$Form->create("Camion")}
<h1>Consumos de Combustibles</h1>
<p>Datos consumo de combustible de los camiones</p>

<table>
   <tr><td align="right">{lbl}Fecha{/lbl}                 </td><td>{input name="fecha"      size="10"}</td></tr>

   <tr><td align="right">{lbl}Tipo Expedici&oacute;n{/lbl}</td><td>{select name="expe_tipo"}|,Nacional|N,Internacional|I{/select}</td></tr>
   <tr><td align="right">{lbl}Expedici&oacute;n No{/lbl}  </td><td>{input name="expe_nro" size="10" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Chofer{/lbl}                </td><td>{input name="chofer"   size="50" readonly="true" class="sololectura"}</td></tr>
   <tr><td align="right">{lbl}Cami&oacute;n{/lbl}         </td><td>{input name="cami_patente" size="10" readonly="true" class="sololectura"}</td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}               </td><td>{input name="expe_destino" size="40" readonly="true" class="sololectura"}</td></tr>
   <tr><td align="right">{lbl}Kilometraje al partir{/lbl} </td><td>{input name="kms"     size="8" style="text-align:right"}</td></tr>   
   <tr><td align="right">{lbl}Litros{/lbl}                </td><td>{input name="litros"  size="8" style="text-align:right"}</td></tr>
 
   <tr><td align="right">{lbl}Kilometraje al regreso{/lbl}</td><td>{input name="kms_llegada"     size="8" style="text-align:right"}</td></tr>

   <tr><td colspan="2">{lbl}&nbsp;{/lbl}</td></tr>

   <tr><td align="right">{lbl}Bloqueo{/lbl}               </td><td>{select name="bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{hidden name="expe_id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
{literal}
<script language="javascript">

$("#expe_nro").blur(function(){
  expe_nro  = $("#expe_nro").val();
  expe_tipo = $("#expe_tipo").val();

  //alert(expe_tipo+" "+expe_nro);

  //if (expe_nro=="" || expe_tipo="") return;

  $.ajax({url:"http://www.ruta-chile.com/rutas/combustibles/getExpedicion/"+expe_tipo+"/"+expe_nro,success:function(result){
    //$("#div1").html(result);

    l = result.split("@@");

    //alert(l[0]);
    document.getElementById("chofer").value=l[0].trim();
    document.getElementById("cami_patente").value=l[1].trim();
    document.getElementById("expe_destino").value=l[2].trim();
    document.getElementById("expe_nro").value=l[3].trim();
  }});
});
</script>
{/literal}
</form>
</div>