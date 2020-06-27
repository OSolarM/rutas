{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:720px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Impresi&oacute;n de Facturas</h1>
<p>Ordenes de Transporte Nacionales</p>

<table>
<tr>
    <tr><td align="right">{lbl}Instituci&oacute;n{/lbl}</td>  <td>{select name="institucion_id"}{$instituciones}{/select}</td></tr>
    <tr><td align="right">{lbl}No.Factura inicial{/lbl}</td><td>{input name="orna_no_factura" size="11" style="text-align:right" readonly="true" class="sololectura"}</td></tr>
    <tr><td align="right">{lbl}Orden de Compra{/lbl}</td><td>{input name="orna_orden_compra" size="20"}</td></tr>
    <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>


</table>


</form>
</div>
