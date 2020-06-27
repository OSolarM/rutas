{$Form->create('Guia')}
  <table>
     <tr><td>
            <div style="border-style:solid; border-width:1px;">
            <table>
               <tr><td colspan=2><h2>Ingreso de Guias</h2></td></tr>
               <tr><td>Referencia</td><td>{input name="referencia" size="20"}</td></tr>
               <tr><td>Ingresado por</td><td>{input name="ingresado_por" size="30"}</td></tr>
               <tr><td>Observaciones</td><td>{area name="observa" rows=2}</td></tr>
			   <tr><td colspan=2>
	             <table border=1 cellpadding=0 cellspacing=0 align="center">
		            <tr><td align="center">Código</td>
			            <td align="center">Cantidad</td>
						<td>&nbsp;</td>
			        </tr>
			        {if $msg_error ne ""}
			       <tr><td colspan="3" align="center" style="color:red">ERROR:{$msg_error}</td></tr>
			        {/if}
					<tr><td>{input name="codigo" size="40"}</td>
			            <td>{input name="cantidad"   size="10" value="1"}
						    {hidden name="cant_pistola" value="0"}
						
						</td>
						<td colspan="2" align="right"><input type="button" value="Enviar" onclick="document.frm.submit();"/></td>
			        </tr>
			        
					{foreach from=$det_guias item=rec}
                    <tr>
                    
                    <td>{$rec.codigo}</td>
                    <td align="right">{$rec.cantidad}</td>                    
					<td><a href="javascript:if (confirm('Seguro borra guia?')) location.href='/tie/guias/deleteLine/{$rec.id}';">Eliminar</a></td>
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
     function isDigit(ch) {
        return ch >= "0" && ch <="9";
     }
     
     function isInteger(s) {
        var ii;
        
        //alert(s);
        
        for (ii=0; ii < s.length; ii++)
           if (!isDigit(s.charAt(ii)))
              return false;
              
        return true;
     }
     
     document.getElementById("frm").onsubmit = function () {
      var lista = new Array();
	  lista[0] = "referencia";
      lista[1] = "codigo";
      lista[2] = "cantidad";
	    
	  var i;
	  var v;
	  
	  for (i=0; i < 3; i++) {
	     v = document.getElementById(lista[i]);
		 
	     if (v.value=="") {
		    v.focus();
			alert("¡Debe ingresar un valor en este campo requerido!");
			return false;		    
		 }
		 
		 cantidad = document.frm.cantidad;
		 
		 if (!isInteger(cantidad.value)) {
		    cantidad.focus();
			alert("¡Debe ingresar un numero en este campo requerido!");
			return false;
		 }
		 
		 
	  }
	  	   
      return true;
   }   
   
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
