{$Form->create("Parametro")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Par&aacute;metros Generales</h1>
<p>Par&aacute;metros</p>
<table>
   <tr><td align="right">{lbl}A&ntilde;o{/lbl} </td>                      <td>{input name="agno"   size="4" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}I.V.A.{/lbl}     </td>                      <td>{input name="iva"    size="5" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}&Uacute;ltima Gu&iacute;a usada{/lbl} </td> <td>{input name="ult_guia"       size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}&Uacute;ltima Factura usada{/lbl}     </td> <td>{input name="ult_factura"    size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Comisi&oacute;n por Vuelta{/lbl}     </td>  <td>{input name="comision_vuelta"    size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}D&iacute;as espera sobre 48 horas{/lbl}</td><td>{input name="dias_espera"    size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Viatico Chile(CLP){/lbl}     </td>          <td>{input name="viatico_chile"    size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Viatico Argentina(ARS){/lbl}     </td>      <td>{input name="viatico_argentina"    size="11" style="text-align:right"}</td></tr>
   <tr><td align="right">{lbl}Libro de Ventas{/lbl}     </td>             <td><table>
                                                                                 <tr><td>{select name="mes_lvta"}{$lmeses}{/select}</td>
                                                                                     <td>{input name="agno_lvta" size="4" style="text-align:right;"}</td>
                                                                                 </tr>
                                                                              </table>
                                                                          </td>
</tr>
   
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}

<div class="spacer"></div>
</form>
</div>