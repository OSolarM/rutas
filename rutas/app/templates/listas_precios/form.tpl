{$Form->create("ListaPrecio")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Lista de Precios Fuerza A&eacute;rea</h1>
<p>Precios por Instituci&oacute;n</p>
<table>
   {hidden name="institucion_id" value="2"}
   <tr><td align="right">{lbl}A&ntilde;o{/lbl}      </td><td>{input name="lista_agno"       size="4"}</td></tr>
   <tr><td align="right">{lbl}Origen{/lbl}     </td><td>{select name="list_origen"}{$origenes}{/select}</td></tr>
   <tr><td align="right">{lbl}Destino{/lbl}    </td><td>{select name="list_destino"}{$destinos}{/select}</td></tr>
   <tr><td align="right">{lbl}Autom&oacute;vil{/lbl}</td><td>{select name="list_auto"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right">{lbl}Precio{/lbl}     </td><td>{input name="list_precio"      size="10" style="text-align:right"}</td></tr>
   
   <tr><td align="right">{lbl}Bloqueo{/lbl}    </td><td>{select name="list_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>