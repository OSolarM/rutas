{$Form->create("OrdenNacional")}

<div id="stylized" class="myform" style="width:600px;">
<h1>Impresi&oacute;n de Facturas</h1>
<p>Proceso de generaci&oacute;n de facturas</p>

<table style="background: lightgray;">
<tr><td bgcolor=#aabbcc align="right">{lbl}No.Factura{/lbl}</td>
    <td bgcolor="white">{$no_factura}</td>
    <td bgcolor="white">&nbsp;</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Fecha{/lbl}</td>
    <td bgcolor="white">{$fecha}</td>
    <td bgcolor="white">&nbsp;</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Instituci&oacute;n{/lbl}</td>
    <td bgcolor="white" colspan="2">{$inst_razon_social}</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Direcci&oacute;n{/lbl}</td>
    <td bgcolor="white" colspan="2">{input name="direccion" size="60" maxlength="80"}</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Rut{/lbl}</td>
    <td bgcolor="white">{$inst_rut}</td>
    <td bgcolor="white">&nbsp;</td>    
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Por concepto de{/lbl}</td>
    <td bgcolor="white" colspan="2">{area name="concepto" rows="8"}</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Neto{/lbl}</td>
    <td bgcolor="white" align="right">{input name="neto" size="12" style="text-align:right"}</td>
    <td bgcolor="white">&nbsp;</td>
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Iva{/lbl}</td>
    <td bgcolor="white" align="right">{input name="iva" size="12" style="text-align:right"}</td>
    <td bgcolor="white">&nbsp;</td>    
</tr>

<tr><td bgcolor=#aabbcc align="right">{lbl}Total{/lbl}</td>
    <td bgcolor="white" align="right">{input name="total" size="12" style="text-align:right"}</td>
    <td bgcolor="white">&nbsp;</td>    
</tr>

<tr><td colspan="3" align="right" bgcolor="white"><button type="submit">Imprimir</button></td></tr>
</table>


{glink caption="Volver" action="imprimirFacturas"}{/glink}
   
{hidden name="id"}
{hidden name="no_factura"}
{hidden name="fecha"}
{hidden name="inst_razon_social"}
{hidden name="inst_rut"}
{hidden name="orna_orden_compra"}
{hidden name="orna_orden_compra2"}
{hidden name="orden_compra_auto"}
{hidden name="origen"}
{hidden name="destino"}
{hidden name="institucion_id"}


<div class="spacer"></div>
{literal}
<script language="javascript">
   //alert("Entre");

   institucion_id=document.getElementById("institucion_id").value;

   //if (institucion_id!=4) {
   //   document.getElementById("neto").readOnly=true;
   //   document.getElementById("neto").className="sololectura";
   //
   //   document.getElementById("iva").readOnly=true;
   //   document.getElementById("iva").className="sololectura";
   //
   //   document.getElementById("total").readOnly=true;
   //   document.getElementById("total").className="sololectura";
   //
   //}

   document.getElementById("frm").onsubmit = function() {
      //alert("onsubmit");
      direccion = document.getElementById("direccion");
      concepto  = document.getElementById("concepto");


      if (direccion.value=="") {
         alert("Debe ingresar la direccion!");
         direccion.focus();
         return false;
      }

      if (concepto.value=="") {
         alert("Debe ingresar el concepto!");
         concepto.focus();
         return false;
      }

      return confirm("Seguro imprime factura?");
   }
</script>
{/literal}

</form>
</div>
