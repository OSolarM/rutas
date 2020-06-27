<div id="stylized" class="myform" style="width:550px;">
{$Form->create("Particular")}
<h1>Clientes Particulares</h1>
<p>Ficha con datos b&aacute;sicos del Cliente</p>

<table>
  <tr><td align="right">{lbl}N&uacute;mero   {/lbl}</td>               <td>{input name="id" size="4" readonly="true" class="sololectura" style="text-align:right"}</td></tr>
  <tr><td align="right">{lbl}Rut     {/lbl}</td>               <td>{input name="rut"       size="12"}</td></tr>
  <tr><td align="right">{lbl}Raz&oacute;n Social    {/lbl}</td><td>{input name="razon"     size="50"}</td></tr>
  <tr><td align="right">{lbl}Giro Comercial     {/lbl}</td>    <td>{input name="giro"      size="50"}</td></tr>
  <tr><td align="right">{lbl}Direcci&oacute;n{/lbl}</td>              <td>{input name="direccion" size="60"}</td></tr>
  <tr><td align="right">{lbl}Comuna   {/lbl}</td>              <td>{input name="comuna"    size="30"}</td></tr>
  <tr><td align="right">{lbl}Ciudad   {/lbl}</td>              <td>{input name="ciudad"    size="30"}</td></tr>
  <tr><td align="right">{lbl}Regi&oacute;n   {/lbl}      </td><td>{input name="region"    size="2"} </td></tr>
  <tr><td align="right">{lbl}Pa&iacute;s   {/lbl}      </td><td>{input name="pais"    size="25"} </td></tr>
  <tr><td align="right">{lbl}Tel&eacute;fonos    {/lbl}   </td><td>{input name="fonos"     size="25"}</td></tr>
  <tr><td align="right">{lbl}Fax      {/lbl}             </td> <td>{input name="fax"       size="25"}</td></tr>
  <tr><td align="right">{lbl}Sitio Web{/lbl}             </td> <td>{input name="sitio_web" size="35"}</td></tr>
  <tr><td align="right">{lbl}E-Mail    {/lbl}            </td> <td>{input name="email"     size="35"}</td></tr>
  <tr><td align="right">{lbl}Contacto {/lbl}             </td> <td>{input name="contacto"  size="60"}</td></tr>
  <tr><td align="right">{lbl}Bloqueado  {/lbl}           </td> <td>{select name="bloqueo"}|,S&iacute;|S,No|N{/select}</td></tr>
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>