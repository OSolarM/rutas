<h1>Ordenes de Transporte Fuerza A&eacute;rea</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{literal}
<script language="javascript">
   //var listado = new Array();

  

   var nCuenta=0;

   function cliquea(n) {
      if (n.checked) 
         nCuenta++;
      else
         nCuenta--;

      //alert(nCuenta);
   } 
</script>
{/literal}

{$Form->create("OrdenNacional")}
{select name="despliegue"}Todos|T,Pendientes|P{/select}

{glink img="add.png" caption="Nuevo" action="add"}{/glink}
<table><tr><td bgcolor="#cccccc" cellspacing=1 cellpading=1 width="90%">

<table border=0 bgcolor=#cccccc cellspacing=1 cellpading=1 width="100%">
<tr bgcolor="#ebf4fb">
    <td align=center><strong>&nbsp;</strong>
    <td align=center><strong>{t}orna_numero{/t}</strong></td>
    <td align=center><strong>{t}orna_fecha{/t}</strong></td>
    <td align=center><strong>{t}orna_m3{/t}</strong></td>
    <td align=center><strong>{t}orna_grado{/t}</strong></td>
    <td align=center><strong>{t}Apellidos{/t}</strong></td>
    <td align=center><strong>{t}Nombres{/t}</strong></td>
    <td align=center><strong>{t}orna_rut{/t}</strong></td>
    <td align=center><strong>{t}Estado{/t}</strong></td>
    <td align=center><strong>{t}Correo{/t}</strong></td>

    <td align=center> </td>
</tr>

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

{foreach from=$ordenesnacionales item=rec name=foo}
<tr>
    {if $rec.orna_carta_no eq ""}
    <td bgcolor=white align="center"><input type="checkbox" name="listado" value="{$rec.id}" onclick="cliquea(this);"/></td>
    {else}
    <td bgcolor=white align="center">&nbsp;</td>
    {/if}
    <td bgcolor=white align="right">{$rec.id}</td>
    <td bgcolor=white>{$rec.orna_fecha}</td>
    <td bgcolor=white align="right">{$rec.orna_m3}</td>
    <td bgcolor=white>{$rec.grad_descripcion}</td>
    <td bgcolor=white>{$rec.orna_apellidos}</td>
    <td bgcolor=white>{$rec.orna_nombres}</td>
    <td bgcolor=white>{$rec.orna_rut}</td>
    <td bgcolor=white>
       {if $rec.orna_nula eq "S"}Nula
       {else}
         {if $rec.orna_cerrar eq "S"}
          Cerrada
         {else}
          Pendiente
         {/if}
       {/if}
       
    </td>
    <td bgcolor=white>{if $rec.orna_estado eq "1"}Enviado{else}No Enviado{/if}</td>
    <td bgcolor=white> 
       {glink img="edit.gif"  caption="Modifica" action="edit"}/{$rec.id}{/glink}
       {glink img="delete.gif" caption="Elimina" confirm="?Seguro elimina registro?" action="delete"}/{$rec.id}{/glink}

    </td>
</tr>
{/foreach}
<input type="hidden" id="nRecords" value="{$smarty.foreach.foo.index}"/>
</table>
</td></tr>
<tr><td>{if !empty($pagination)}
            <div class="pagination">{$pagination}</div>
        {/if}
   </td>
</tr>
</table>
<table>
<tr><td>Con los marcados</td>
    <td>{select name="accionLista"}|,Enviar 1er correo|1{/select}</td>
    <td>{button value="Aceptar" id="btnOk"}
</tr>
</table>
{hidden name="seleccionados"}

{literal}
<script language="javascript">
   document.getElementById("despliegue").onchange = function() {
      document.frm.submit();
   }
   
   document.getElementById("btnOk").onclick = function() {
      listado = document.getElementById("frm").listado;
      accionLista = document.getElementById("accionLista");

      nRecords = document.getElementById("nRecords").value;

      //alert(nCuenta);

      lista="";

      //alert(listado.length);
 
      if (nRecords > 1 && nCuenta > 0) {
         for (i=0; i < listado.length; i++) 
            if (listado[i].checked) {
               if (lista!="") lista = lista + ",";
            
               lista = lista + listado[i].value;
            }
      }
      else if (nRecords==1 && nCuenta==1)
         lista = document.getElementById("frm").listado.value;
         
      //alert(lista);

      document.getElementById("seleccionados").value=lista;

      //alert(document.getElementById("seleccionados").value);
      
      if (nCuenta==0) {
         alert("¡Debe seleccionar algunas filas!");
         return;
      }
      
      if (accionLista.value=="") {
         alert("¡Debe seleccionar una acción!");
         accionLista.focus();
         return;
      }
      
      if (confirm("¿Está seguro?")) {
         document.frm.action="{/literal}{$APP_HTTP}{literal}/ordenes_aereas/ejecutar_accion";
         document.frm.submit();
         return;
      }
   }
</script>
{/literal}
</form>
