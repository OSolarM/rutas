{$Form->create('Guia')}
  <table>
     <tr><td>
            <div style="border-style:solid; border-width:1px;">
            <table>
               <tr><td colspan=2><h2>Calce de Guias</h2></td></tr>
               <tr><td>Referencia</td><td>{input name="referencia" size="20" readonly="true"}</td></tr>
               <tr><td>Ingresado por</td><td>{input name="ingresado_por" size="30"}</td></tr>
               <tr><td>Observaciones</td><td>{area name="observa" rows=2}</td></tr>
               <tr><td>Cantidades</td><td><strong>{$cant_pistol} de un total de {$cant} faltantes {$faltantes}</strong></td></tr>
			   <tr><td colspan=2>
	             <table border=1 cellpadding=0 cellspacing=0 align="center">
		            <tr><td align="center">Código</td>
			            <td align="center">Cantidad</td>
			            <td align="center">Cant.Ingresada</td>
						<td>&nbsp;</td>
			        </tr>
			        {if $msg_error ne ""}
			        <tr><td colspan="3" align="center" style="color:red">ERROR:{$msg_error}</td></tr>
			        
                    <!--<embed height="200px" width="200px" src="sonido.mp3" />-->
                   
			        {/if}
			        <tr><td>{input name="codigo" size="40"}</td>
			            <td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right">{button type="submit" value="Enviar"}</td>
			        </tr>
					
					{foreach from=$det_guias item=rec}
                    <tr>
                    
                    <td>{$rec.codigo}</td>
                    <td align="right">{$rec.cantidad}</td>       
                    <td align="right" {if $rec.cantidad ne $rec.cant_pistola}style="color:red;"{/if}>{$rec.cant_pistola}</td>              
					<td>{if $rec.cantidad eq $rec.cant_pistola}OK{/if}</td>
                    </tr>
                    {/foreach}
					
					
		         </table>
	             </td>
	           </tr>               
            </table>
            </div>
        </td>
     </tr>
	 
  </table>
  {hidden name="id"}
  <br>
  {glink caption="Volver" action="index"}{/glink}&nbsp;
  {if $id ne ""}
  {glink caption="A Excel" action="excel"}/{$id}{/glink}
  {/if}
  {literal}
  <script language="javascript">
     document.frm.codigo.focus();
     
     document.frm.codigo.onblur = function() {
      this.value = this.value.toUpperCase();
      
      var n = this.value.indexOf("'");
      
      if (n >= 0)
         this.value = this.value.split("'")[1];
     }
       
  </script>
  {/literal}
</form>
