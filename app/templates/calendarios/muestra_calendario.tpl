{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:720px;">
<form id="form" name="form" method="post" action="index.html">
<h1>{$titulo}</h1>
<p>Selecci&oacute;n de Fechas</p>

<table border=1>
{if $tipo eq "retiros"}
<tr><td>{glink caption="<<" action="retiros"}/{$mes_ant}/{$agno_ant}{/glink}</td>
    <td colspan="5" align="center"><h1>{$mespal} de {$agno}</h1></td>
    <td>{glink caption=">>" action="retiros"}/{$mes_sig}/{$agno_sig}{/glink}</td>
</tr>
{/if}

{if $tipo eq "llegadas"}
<tr><td>{glink caption="<<" action="llegadas"}/{$mes_ant}/{$agno_ant}{/glink}</td>
    <td colspan="5" align="center"><h1>{$mespal} de {$agno}</h1></td>
    <td>{glink caption=">>" action="llegadas"}/{$mes_sig}/{$agno_sig}{/glink}</td>
</tr>
{/if}

<tr><td align="center">Lun</td>
<td align="center">Mar</td>
<td align="center">Mi&eacute;</td>
<td align="center">Jue</td>
<td align="center">Vie</td>
<td align="center">S&aacute;b</td>
<td align="center">Dom</td>
<tr>
{$calendario}
</table>
{literal}
<script language="javascript">
   function selecciona(f) {
      //alert(f);

      window.opener.document.getElementById("orna_repo_fecha").value = f;

      window.close();
   }

  function selecciona2(f) {
      //alert(f);

      window.opener.document.getElementById("orna_fecha_llegada").value = f;

      window.close();
   }
</script>
{/literal}
</form>
</div>
