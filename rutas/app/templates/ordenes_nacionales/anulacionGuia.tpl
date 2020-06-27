{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:720px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Ordenes de Transporte Nacionales</h1>
<p>Anulaci&oacute;n de Gu&iacute;as</p>

{if $error_guia ne ""}
   <label style="color:red;font-size=18px;font-weight:bold;">{$error_guia}</label><br/>
{/if}

<table>
<tr>
    <tr><td align="right">{lbl}Instituci&oacute;n{/lbl}</td><td>{select name="institucion_id"}{$instituciones}{/select}</td></tr>
    <tr><td align="right">{lbl}Gu&iacute;a N&uacute;mero{/lbl}</td><td>{input name="orna_no_guia" size="11" style="text-align:right"}</td></tr>
    <tr><td align="right" colspan="2"><button type="submit">Anular</button></td></tr>
</table>    


{hidden name="id"}

<div class="spacer"></div>
{literal}
<script language="javascript">
   document.getElementById("frm").onsubmit = function() {
      return confirm("Seguro anular guia?");
   }
</script>
{/literal}
</form>
</div>
