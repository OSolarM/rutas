{$Form->create("Camion")}

<div id="stylized" class="myform" style="width:550px;">

<h1>Carga Autom&aacute;tica de Ordenes</h1>
<p>Datos para cargar ordenes autom&aacute;ticamente</p>

<table>
   <tr><td align="right">{lbl}Archivo a cargar{/lbl}    </td><td><input type="file" name="file" id="file" /></td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Cargar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
