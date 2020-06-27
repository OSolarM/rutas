<div id="stylized" class="myform" style="width:550px;">
{$Form->create("LibroVenta")}
<h1>Libro de Ventas</h1>
<p>Documentos del Libro</p>

<table>
   <tr><td align="right">Tipo        </td><td>{select name="tipo_docto" readonly="true" class="sololectura" size="20"}Nacional|N,Exportación|I{/select}</td></tr>	
   <tr><td align="right">CRT No      </td><td>{input name="crts_numero"	   size="20" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Fecha       </td><td>{input name="fecha"	   size="10" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Rut         </td><td>{input name="rut"	       size="12" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Razón Social</td><td>{input name="razon"	   size="45" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Documento   </td><td>{input name="docto"	   size="2" readonly="true" class="sololectura"}</td></tr>  
   <tr><td align="right">Número      </td><td>{input name="numero"	   size="10" style="text-align:right;" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Fec/Emisión </td><td>{input name="emision"	   size="10" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Fec/Vencto  </td><td>{input name="vencto"	   size="10" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Neto        </td><td>{input name="neto"	   size="12" style="text-align:right;" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Iva         </td><td>{input name="iva"	       size="12" style="text-align:right;" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Total       </td><td>{input name="total"	   size="12" style="text-align:right;" readonly="true" class="sololectura"}</td></tr> 
   <tr><td align="right">Estado      </td><td>{select name="estado" readonly="true" class="sololectura" size="12"}Ingresado|I,Anulado|N{/select} </td></tr> 
   <tr><td align="right" colspan="2"><button type="submit">Anular</button></td></tr>   
</table>
{hidden name="id"}
{hidden name="crt_id"}
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>
</div>