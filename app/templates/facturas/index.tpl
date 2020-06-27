{$Form->create("Factura")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Proceso de Facturaci&oacute;n</h1>
<p>Ingresar montos para prorrateo</p>
<table border=2>
   <tr><td align="center">{lbl}Instituci&oacute;n{/lbl}</td> 
       <td align="center">{lbl}Pendiente por Facturar{/lbl}</td>
       <td align="center">{lbl}Prorrateo{/lbl}</td>
   </tr>
   <tr><td>{lbl}Ej&eacute;rcito{/lbl}    </td><td align="right">${$guias_ejercito|number_format:0:",":"."}   </td><td>{input name="monto_ejercito"     size="11" style="text-align:right"}</td></tr>
   <tr><td>{lbl}Fuerza A&eacute;rea{/lbl}</td><td align="right">${$guias_faerea|number_format:0:",":"."}     </td><td>{input name="monto_faerea"       size="11" style="text-align:right"}</td></tr>
   <tr><td>{lbl}Carabineros{/lbl}        </td><td align="right">${$guias_carabineros|number_format:0:",":"."}</td><td>{input name="monto_carabineros"  size="11" style="text-align:right"}</td></tr>
   
   <tr><td>{lbl}TOTAL{/lbl}</td><td align="right">${$guias_total|number_format:0:",":"."}</td><td>{input name="monto_total"  size="11" style="text-align:right" readonly="true"}</td></tr>
   <tr><td colspan="3" align="right"><button type="submit" style="float:right">Procesar</button></td></tr>
</table>
{hidden name="id"}
<!--{glink caption="Volver" action="index"}{/glink}-->

<div class="spacer"></div>
{literal}
<script language="javascript">
   function isInteger(s) {
      ss = s + "@";
      i  = 0;
      
      while (ss.charAt(i) >= "0" && ss.charAt(i) <= "9")
         i++;
         
      return ss.charAt(i)=="@"; 
      
   }
   
   document.getElementById("monto_ejercito").onblur = function() {
      tope = {/literal}{$guias_ejercito}{literal};
      
      if (!isInteger(this.value))
         this.value=0;
         
      if (tope==0) 
         this.value=0;
      else if (this.value > tope)
         this.value=tope;
         
      sumaTotales();
   }
   
   document.getElementById("monto_faerea").onblur = function() {
      tope = {/literal}{$guias_faerea}{literal};
      
      if (!isInteger(this.value))
         this.value=0;
         
      if (tope==0) 
         this.value=0;
      else if (this.value > tope)
         this.value=tope;
         
      sumaTotales();
   }
   
   document.getElementById("monto_carabineros").onblur = function() {
      tope = {/literal}{$guias_carabineros}{literal};
      
      if (!isInteger(this.value))
         this.value=0;
         
      if (tope==0) 
         this.value=0;
      else if (this.value > tope)
         this.value=tope;
 
      sumaTotales();        
    }   
   
   function sumaTotales() {
      valor =parseInt(document.getElementById("monto_ejercito").value   )+
             parseInt(document.getElementById("monto_faerea").value     )+
             parseInt(document.getElementById("monto_carabineros").value);  
                                                   
      document.getElementById("monto_total").value = formatNo(valor);                                               
   
   }
   
   function formatNo(n) {
     s = ""+n;
     
     while (s.length%3!=0)
        s = "0"+ s;
        
     largo = s.length/3; //How many groups of 3 chars
     
     //alert(largo);
     
     ss="";
     for (i=0; i < largo; i++)  {
        if (ss !="") ss = ss + ".";
         
        ss = ss + s.substr(i*3, 3);
     }
          
     i=0;
     
     while (i < ss.length - 1 && (ss.charAt(i)=="0" || ss.charAt(i)=="."))
        i++;
        
     return "$"+ss.substr(i);
   }
   
   document.getElementById("frm").onsubmit = function() {
      valor =parseInt(document.getElementById("monto_ejercito").value   )+
             parseInt(document.getElementById("monto_faerea").value     )+
             parseInt(document.getElementById("monto_carabineros").value); 
             
      if (valor==0) {
         alert("Debe prorratear los montos!");
         return;
      }
      
      return confirm("Seguro factura guias?");
              
   }
   
</script>
{/literal}
</form>
</div>