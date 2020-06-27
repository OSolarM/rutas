{$Form->create("Acceso")}
<div id="stylized" class="myform" style="width:300px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Control de Acceso</h1>
<p>Datos b&aacute;sicos para conexi&oacute;n</p>

<table aling="center">	
   <tr><td align="right">{lbl}Usuario{/lbl}          </td><td>{input name="user"       size="12"}</td></tr>
   <tr><td align="right">{lbl}Contrase&ntilde;a{/lbl}</td><td>{input name="pass" size="12" kind="password"}</td></tr>
   <tr><td colspan="2" align="right"><button type="submit">Ingresar</button></td></tr>
</table>
{hidden name="id"}
<br>
<div class="spacer"></div>

<script language="javascript">
   document.getElementById("user").focus();
</script>
</form>
</div>
