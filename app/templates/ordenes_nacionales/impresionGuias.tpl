{$Form->create("OrdenNacional")}
<div id="stylized" class="myform" style="width:1150px;">
<h1>Impresi&oacute;n (Generaci&oacute;n) de Gu&iacute;as</h1>
<p>Ordenes de Transporte Nacionales</p>

<table>
<tr><td>{lbl}Pr&oacute;xima gu&iacute;a a usar{/lbl}</td><td>{input name="orna_no_guia" size="11" style="text-align:right;"}</td>
    <td><button type="submit">Imprimir</button></td>
</tr>
</table>
<br/>
<table style="background:lightgray">
<tr>
    <td bgcolor="white" >&nbsp;</td>
    <td bgcolor="white" >{select name="institucion_id"}{$instituciones}{/select}</td>
    <td bgcolor="white" >{input name="orna_orden_compra" size="20"}</td>
    <td bgcolor="white" >{input name="grad_descripcion" size="20"}</td>
    <td bgcolor="white" >{input name="orna_apellidos" size="20"}</td>
    <td bgcolor="white" >{input name="orna_nombres"   size="20"}</td>
    <td bgcolor="white" >&nbsp;</td>
    <td bgcolor="white" >&nbsp;</td>
    <td bgcolor="white" >&nbsp;</td>
    <td bgcolor="white" >{button value="Filtrar" id="filtrar"}</td>
</tr>
<tr>
    <td bgcolor="#aabbcc" style="padding:3px;"><input type="checkbox" name="todos" id="todos"/></td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Instituci&oacute;n{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Orden de Compra{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Grado{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Apellidos{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Nombres{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Origen{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Destino{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Fecha{/lbl}</td>
    <td bgcolor="#aabbcc" align="center" style="padding:3px;color:white;">{lbl}Auto{/lbl}</td>
</tr>
{foreach from=$guias item=rec name=foo}
<tr>
    <td bgcolor=white style="padding:3px;"><input type="checkbox" id="lista_{$smarty.foreach.foo.index}" name="lista[]" value="{$rec.id}"/></td>
    <td bgcolor=white style="padding:3px;">{$rec.inst_razon_social}</td>
    <td bgcolor=white style="padding:3px;">{$rec.orna_orden_compra}</td>
    <td bgcolor=white style="padding:3px;">{$rec.grad_descripcion}</td>
    <td bgcolor=white style="padding:3px;">{$rec.orna_apellidos}</td>
    <td bgcolor=white style="padding:3px;">{$rec.orna_nombres}</td>
    <td bgcolor=white style="padding:3px;">{$rec.ciud_nombre}</td>
    <td bgcolor=white style="padding:3px;">{$rec.ciud_nombre_a}</td>
    <td bgcolor=white style="padding:3px;">{$rec.orna_fecha}</td>
    <td bgcolor=white style="padding:3px;" align="center">{if $rec.orna_auto eq "S"}S&iacute;{else}No{/if}</td>

    </td>
</tr>
{/foreach}
<input type="hidden" name="ultimo" value="{$smarty.foreach.foo.index}"/>
{hidden name="filtro"}
</table>

{literal}
<script language="javascript">
   function isDigit(c) {
      return c >= "0" && c <= "9";
   }

   function isInteger(s) {
      if (s.length==0) return false;

      for (i=0; i < s.length; i++)
         if (!isDigit(s.charAt(i)))
            return false;

      return true;
   }

   document.getElementById("frm").onsubmit = function() {
      orna_no_guia=document.getElementById("orna_no_guia");

      //alert(orna_no_guia.value);

      if (!isInteger(orna_no_guia.value)) {
         alert("Debe ingresar el numero de guia!");
         orna_no_guia.focus();
         return false;
      }

      
      nRecords = cuenta();

      if (nRecords==0) {
         alert("No ha seleccionado guias a imprimir!");
         return false;
      }

      
         
      return confirm("Seguro de generar las guias?");
   }

   document.getElementById("todos").onclick = function() {

      ultimo = document.frm.ultimo.value;     

      for (i=0; i <= ultimo; i++)
         document.getElementById("lista_"+i).checked = this.checked;
   }   

   document.getElementById("filtrar").onclick = function() {
      document.frm.filtro.value="S";
      document.frm.submit();
   }

   function cuenta() {
      ultimo = document.frm.ultimo.value;

      n = 0;
      for (i=0; i <= ultimo; i++)
         if (document.getElementById("lista_"+i).checked) n++;

      return n;
   }
</script>
{/literal}
</form>
</div>
