<h1>Rendici&oacute;n Fondos Expediciones Internacionales</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}


{if $nParidades gt 0}

<ul style="border:1px solid red; background:pink;">
{foreach from=$sParidades item=rec}
   <li style="font-weight:bold; color:red;font-size:14px;">{$rec}</li>
{/foreach}
</ul>

{/if}

{$Form->create("Rendicion")}
{*glink img="add.png" caption="Nuevo" action="add"}{/glink*}

<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="100%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>
    <td align=center><strong><a href="javascript:setOrder('rend_nro');">{t}N&uacute;mero{/t}</a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('rend_fecha');">{t}Fecha{/t}</a></strong></td>
    <td align=center><strong>{t}Expedici&oacute;n{/t}</strong></td>
    <td align=center><strong>{t}Fecha{/t}</a></td>
    <td align=center><strong>{t}Chofer{/t}</strong></td>
    <td align=center><strong><a href="javascript:setOrder('asignado');">{t}Asignado{/t}</a></strong></td> 
    <td align=center><strong><a href="javascript:setOrder('combustible_cargado');">{t}Combustible cargado{/t}</a></strong></td> 
    <td align=center><strong><a href="javascript:setOrder('rend_estado');">{t}Estado{/t}</a></strong></td> 
    <td align=center><strong>{t}Bloqueo{/t}</strong></td>
    <td align=center> </td>
</tr>

<tr>
    <td bgcolor=white>{input kind="number" name="rend_nro" size="10"  style="text-align:right"}</td>
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white align="right">&nbsp;</td>
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white align="left">{input name="chofer" size="30"}</td>
    <td bgcolor=white align="right">&nbsp;</td>
    <td bgcolor=white align="center" style="color:red">&nbsp;</td> 
    <td bgcolor=white align="center">{select name="opcion"}Ingresados|I,Todos|T{/select}</td>
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white> <input type="button" value="Buscar" onclick="document.frm.submit();"/>
         
    </td>
</tr>

{foreach from=$rendiciones item=rec}
<tr>
    <td bgcolor=white align="right">{$rec.rend_nro}</td>
    <td bgcolor=white align="center">{$rec.rend_fecha}</td>
    <td bgcolor=white align="right">{$rec.expe_nro}</td>
    <td bgcolor=white align="center">{$rec.expe_fecha}</td>
    <td bgcolor=white align="left">{$rec.chofer}</td>
    <td bgcolor=white align="right">${$rec.asignado|number_format:0:",":"."}</td>
    <td bgcolor=white align="center" style="color:red"><strong>{$rec.combustible_cargado}</strong></td> 
    <td bgcolor=white align="center">{if $rec.rend_estado eq "C"}Cerrado{else}Ingresado{/if}</td>
    <td bgcolor=white align="center">{if $rec.fond_bloqueo eq "S"}S&iacute;{else}No{/if}</td>
    <td bgcolor=white> {glink img="edit.gif" caption="Modifica" action="edit"}/{$rec.id}{/glink}
                       &nbsp;
                       {glink caption="Imprime" action="runPdf" target="_blank"}/{$rec.id}{/glink}
         
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

{hidden name="sortKey"}
{hidden name="orderKey"}
{hidden name="page"}   

{literal}
<script language="javascript">
   function setOrder(cOrder) {
      
      if (document.frm.sortKey.value==cOrder) {

         if (document.frm.orderKey.value=="asc")
            document.frm.orderKey.value="desc";
         else
            document.frm.orderKey.value="asc";
   
      }  
      else
         document.frm.orderKey.value="asc";

      document.frm.sortKey.value=cOrder;
      document.frm.submit();
   }
</script>
{/literal}
</form>