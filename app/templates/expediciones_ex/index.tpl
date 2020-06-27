<h1>Expediciones Internacionales</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{$Form->create("ExpedicionEx")}
{*glink img="add.png" caption="Nuevo" action="add"}{/glink*}

<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="100%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor=#aabbcc>

	      
    <td align=center><strong><a href="javascript:setOrder('expe_nro');"    >Número     </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('expe_fecha');"  >Fecha      </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('chof_id');"     >Chofer     </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('cami_id');"     >Camión     </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('acop_id');"     >Acoplado   </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('expe_destino');">Destino    </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('combustible');" >Combustible</a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('expe_bloqueo');">Bloqueo    </a></strong></td>
    <td align=center><strong><a href="javascript:setOrder('expe_cerrado');">Cerrado    </a></strong></td>
    <td align=center> </td>
</tr>


<tr>
    <td bgcolor=white>{input kind="number" name="expe_nro" size="10"  style="text-align:right"}</td>
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white>             {input name="chof_apellidos" size="30"}</td>
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white align="left">&nbsp;</td>
    <td bgcolor=white align="right">&nbsp;</td>
    <td bgcolor=white align="center" style="color:red">&nbsp;</td> 
    <td bgcolor=white align="center">&nbsp;</td>
    <td bgcolor=white align="center">{select name="expe_cerrado"}|,,No|N,Sí|S{/select}</td>
    <td bgcolor=white> <input type="button" value="Buscar" onclick="document.frm.submit();"/>
         
    </td>
</tr>


	      
{foreach from=$expediciones item=rec}
<tr>
    <td style="padding:1px;" bgcolor=white align="right" > {$rec.expe_nro}</td>
    <td style="padding:1px;" bgcolor=white align="center">{$rec.expe_fecha}</td>
    <td style="padding:1px;" bgcolor=white               > {$rec.chof_apellidos}&nbsp;{$rec.chof_nombres}</td>
    <td style="padding:1px;" bgcolor=white               >{$rec.cami_patente}</td>
    <td style="padding:1px;" bgcolor=white align="left"  >{$rec.acop_patente}</td>
    <td style="padding:1px;" bgcolor=white               >{$rec.expe_destino}</td>
    <td style="padding:1px;" bgcolor=white align="center" style="color:red">{if $rec.combustible eq "N"}No{else}Sí{/if}</td> 
    <td style="padding:1px;" bgcolor=white align="center">{if $rec.expe_bloqueo eq "N"}No{else}Sí{/if}</td>
    <td style="padding:1px;" bgcolor=white align="center">{if $rec.expe_cerrado eq "S"}Sí{else}No{/if}</td>
    <td style="padding:1px;" bgcolor=white> {glink img="edit.gif" caption="Modifica" action="edit"}/{$rec.id}{/glink}
                       {if $rec.expe_cerrado eq "S"}{glink caption="Abrir" action="abrir"}/{$rec.id}{/glink}{/if}
                      
         
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