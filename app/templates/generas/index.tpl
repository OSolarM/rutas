<html>
<body bgcolor="#aabbcc">
{$Form->create('Genera')}
  <table>
     <tr><td>
            <div style="border-style:solid; border-width:1px;">
            <table>
               <tr><td><h2>Generación de MVC</h2></td></tr>
               <tr><td><table>
                       <tr><td>Título      </td><td>{input name="titulo"        size="50"}</td></tr>
                       <tr><td>Modelo      </td><td>{input name="modelo"        size="30"}</td></tr>
                       <tr><td>Controlador </td><td>{input name="controlador"   size="30"}</td></tr>
                       </table>
                    </td>
               <tr><td><table border=1>
                          <tr>
                             <td align=center>Nro</td>
                             <td align=center>Etiqueta</td>
                             <td align=center>Campo</td>
                             <td align=center>Largo</td>
                             <td align=center>Requerido</td>
                             <td align=center>Tipo</td>
                             <td align=center>Mínimo</td>
                             <td align=center>Máximo</td>
                             <td align=center>&nbsp</td>                                       
                          </tr>
                          <tr>
                             <td>{input name="nro" size="3" readonly="true"}</td>
                             <td>{input name="etiqueta" size="20" maxlength="35"}</td>
                             <td>{input name="campo" size="20" maxlength="30"}</td>
                             <td>{input name="largo" size="4"}</td>
                             <td>{select name="required"}|,Sí|S,No|N{/select}</td>
                             <td>{select name="type"}|,date|date,number|number,integer|integer,run|rut,email|email{/select}</td>
                             <td>{input name="min" size="20" maxlength="100"}</td>
                             <td>{input name="max" size="20" maxlength="100"}</td>
                             <td>{button value="Agregar" onclick="agregar()"}</td>                                       
                          </tr>   
                          {$malla}                                 
                       </table>
                   </td>
               </tr>               
               <tr><td align="right">&nbsp;</td></tr>
               <tr><td align="right">{button value="Generar todo" onclick="generate()"}</td></tr>
            </table> 
            </div>
        </td>
     </tr>
  </table>
  <input type="hidden" name="lista"   value="{$lista}">
  <input type="hidden" name="comando">
  <input type="hidden" name="linea">
{literal}
<script language="javascript">
   function agregar() {
      document.frm.action="/tie/generas/add";
      document.frm.submit();
   }
   
   function editar(n) {
      document.frm.action="/tie/generas/edit/"+n;
      document.frm.submit();
   }
   
   function eliminar(n) {
      if (confirm("¿Seguro elimina fila "+n+"!")) {
         document.frm.action="/tie/generas/del/"+n;
         document.frm.submit();
      }
   }
   
   function generate() {
      if (confirm("¿Seguro genera código?")) {
         document.frm.action="/tie/generas/generate";
         document.frm.submit();
      }
   }
      
</script>
{/literal}  
</form>
</body>
</html>