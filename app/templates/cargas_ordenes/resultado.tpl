{$Form->create("Camion")}

<div id="stylized" class="myform" style="width:800px;">

<h1>Carga Autom&aacute;tica de Ordenes</h1>
<p>Datos para cargar ordenes autom&aacute;ticamente</p>

{if $errores gt 0}
<h2 style="color:red">Favor revisar listado con errores</h2>
{/if}

<table border=1>
<tr style="font-weight:bold;">
<td align="center">Grado</td>	         	 
<td align="center">Nombres</td>
<td align="center">Origen</td>	         	         
<td align="center">Destino</td>	            
<td align="center">Mts3</td>
<td align="center">Direcci&oacute;n</td>
<td align="center">O.Compra    </td>
</tr>

{foreach from=$listado item=rec}
<tr>
<td>{$rec.grado}    </td>	         	 
<td>{$rec.nombres}  </td>
<td>{$rec.origen}   </td>	         	         
<td>{$rec.destino}  </td>	            
<td>{$rec.mts}      </td>
<td>{$rec.direccion}</td>
<td>{$rec.orden}    </td>
</tr>
{/foreach}


</table>

{if $errores eq 0}
<!--<button id="btnOk">Cargar</button>-->
{glink caption="Subir archivo" confirm="Seguro cargar Archivo?" action="subirRegistros"}/{$archivo}{/glink}
{/if}

<div class="spacer"></div>
{literal}
<script language="javascript">

   document.getElementBYId("btnOk").onclick = function () {
      document.frm.action="{/literal}{$APP_HTTP}{literal}/cargas_ordenes/subirRegistros/{/literal}{$archivo}{literal}";
      document.frm.submit();
   }
   
</script>
{/literal}
</form>
</div>
