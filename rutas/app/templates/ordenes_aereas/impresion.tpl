<h1>Impresi&oacute;n Gu&iacute;as Ordenes de Transporte Fuerza A&eacute;rea</h1>


{$Form->create("OrdenNacional")}

<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor="#ebf4fb">
    <td align=center><strong>{t}orna_numero{/t}</strong></td>
    <td align=center><strong>{t}orna_fecha{/t}</strong></td>
    <td align=center><strong>{t}orna_grado{/t}</strong></td>
    <td align=center><strong>{t}Apellidos{/t}</strong></td>
    <td align=center><strong>{t}Nombres{/t}</strong></td>
    <td align=center><strong>{t}orna_rut{/t}</strong></td>    
    <td align=center><strong>{t}Origen{/t}</strong></td>
    <td align=center><strong>{t}Destino{/t}</strong></td>
    <td align=center><strong>{t}Autom&oacute;vil{/t}</strong></td>
        <td align=center><strong>{t}orna_m3{/t}</strong></td>
    <td align=center><strong>{t}Valor Gu&iacute;a{/t}</strong></td>
    <td align=center><strong>{t}No.Gu&iacute;a{/t}</strong></td>

    <td align=center> </td>
</tr>

<!--
<tr style="background:white;">
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>
</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>{input name="orna_apellidos" size="20"}</strong></td>
    <td align=center><strong>{input name="orna_nombres" size="20"}</strong></td>
    <td align=center>&nbsp</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center><strong>&nbsp;</strong></td>
    <td align=center>{submit value="Buscar" id="btnBuscar"}</td>
</tr>
-->

{foreach from=$ordenesnacionales item=rec}
<tr>
    <td bgcolor=white align="right">{$rec.id}</td>
    <td bgcolor=white>{$rec.orna_fecha}</td>

    <td bgcolor=white>{$rec.grad_descripcion}</td>
    <td bgcolor=white>{$rec.orna_apellidos}</td>
    <td bgcolor=white>{$rec.orna_nombres}</td>
    <td bgcolor=white>{$rec.orna_rut}</td>
    <td bgcolor=white>{$rec.orna_origen}</td>
    <td bgcolor=white>{$rec.orna_destino}</td>
    <td bgcolor=white align="center">{if $rec.orna_auto eq "S"}S&iacute;{else}No{/if}</td>
    <td bgcolor=white align="right">{$rec.orna_m3}</td>
    <td bgcolor=white align="right">$ {$rec.orna_valor_guia|number_format:0:",":"."}</td>
    <!--<td bgcolor=white>{$rec.orna_no_guia}</td>$smarty.foreach.foo.index-->
    <td bgcolor=white><input type="text" id="orna_no_guia{$rec.id}" name="orna_no_guia{$rec.id}" size=10 maxlength=10 style="text-align:right"/></td>
    <td bgcolor=white> 
       <!--{glink img="edit.gif" caption="Impresi&oacute;n" confirm="Seguro imprimir guia?" action="imprimir_guia"}/{$rec.id}{/glink}-->
       
       <input type="button" value="Imprimir" onclick="imprimir({$rec.id});"/>

    </td>
</tr>
{/foreach}
</table>
</td></tr>
<tr><td>{if !empty($pagination)}
            <div class="pagination">{$pagination}</div>
        {/if}
   </td>
</tr>
</table>
{literal}
<script language="javascript">
   function isInteger(s) {
      ss = s + "@";
      i  = 0;
      
      while (ss.charAt(i) >= "0" && ss.charAt(i) <= "9")
         i++;
         
      return ss.charAt(i)=="@"; 
      
   }
   
   function imprimir(n) {
      orna_no_guia = document.getElementById("orna_no_guia"+n);
      
      if (!isInteger(orna_no_guia.value) || orna_no_guia.value=="") {
         alert("Numero de guia incorrecto!");
         orna_no_guia.focus();
         return;
      }
      
      document.frm.action="{/literal}{$APP_HTTP}{literal}/ordenes_aereas/imprimir_guia/"+n+"/"+orna_no_guia.value;
      document.frm.submit();
   }
</script>
{/literal}

</form>
