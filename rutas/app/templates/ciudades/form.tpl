{$Form->create("Ciudad")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Ciudades</h1>
<p>Datos básicos de las ciudades</p>

<table>
   <tr><td align="right">{lbl}ciud_nombre{/lbl} </td><td>{input name="ciud_nombre"  size="30"}</td></tr>
   <tr><td align="right">{lbl}ciud_region{/lbl} </td><td>{input name="ciud_region"  size="2"}</td></tr>
   <tr><td align="right">{lbl}ciud_bloqueo{/lbl}    </td><td>{select name="ciud_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>
