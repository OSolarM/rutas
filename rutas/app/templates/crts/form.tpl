{$Form->create("Crt")}                                                                                                                                  
<div id="stylized" class="myform" style="width:820px;">                                                                                                 
                                                                                                                                                        
<h1>C R T</h1>                                                                                                                                          
<p>Carta de Porte Internacional por Carretera</p>                                                                                                       
                                                                                                                                                        
<table>                                                                                                                                                 
<tr><td>{lbl}Fecha{/lbl}        </td><td>{input class="smallFont"   name="fecha" size="10"}</td></tr>                                                                      
<tr><td>{lbl}Tipo de Operaci&oacute;n{/lbl}        </td><td>{select name="tipo_operacion" class="smallFont"}|,Exportaci&oacute;n|E,Importaci&oacute;n|I{/select}</td></tr>
<tr><td>{lbl}Valor del flete{/lbl}        </td><td><table><tr>                                                                                          
                                                   <td>{input class="smallFont"  name="crts_valor_flete" size="12" style="text-align:right"}</td>                          
                                                   <td>&nbsp;{lbl}Moneda{/lbl}&nbsp;</td>                                                               
                                                   <td>{input class="smallFont"  name="crts_mon_flete" size="3"}</td>                                                      
                                                   </tr>                                                                                                
                                                   </table>                                                                                             
                                               </td>                                                                                                    
</tr>                                                                                                                                                   
<tr><td>{lbl}Cliente      {/lbl}</td><td>{select name="cliente_id" class="smallFont"}      {$clientes}{/select}</td></tr>                                                 
<tr><td>{lbl}Destinatario {/lbl}</td><td>{select name="destinatario_id" class="smallFont"} {$clientes}{/select}</td></tr>                                                 
<tr><td>{lbl}Consignatario{/lbl}</td><td>{select name="consignatario_id" class="smallFont"}{$clientes}{/select}</td></tr> 
<tr><td>{lbl}Facturar a{/lbl}</td><td>{select name="facturar_id" class="smallFont"}{$clientes}{/select}</td></tr>          
<tr><td>{lbl}Factura{/lbl}</td><td>{input name="crts_factura" size="20" class="smallFont"}</td></tr>   
<tr><td>{lbl}Gu&iacute;a Cliente{/lbl}</td><td>{input name="crts_guia_cliente" size="20" class="smallFont"}</td></tr>      
<tr><td>{lbl}Gu&iacute;a Aduanera{/lbl}</td><td>{input name="crts_guia_aduanera" size="20" class="smallFont"}</td></tr>      
<tr><td>{lbl}Desde{/lbl}</td><td>{input name="crts_desde" size="24" class="smallFont"}</td></tr>   
<tr><td>{lbl}Hasta{/lbl}</td><td>{input name="crts_hasta" size="24" class="smallFont"}</td></tr>   
<tr><td>{lbl}Es Facturable{/lbl}</td><td>{select name="crts_facturable" class="smallFont"}|,S&iacute;|S,No|N{/select}</td></tr>                                            
<tr><td>{lbl}Estado{/lbl}</td><td>{select name="crts_estado" class="smallFont"}|,Ingresado|I,Cerrado|C{/select}</td></tr>                                                 
                                                                                                                                                        
</table>                                                                                                                                                
<div style="float:left; width: 820px; height: 400px; border: 1px solid black;">                                                                         
    <div style="float:left; width: 450px; height: 398px; border-right: 1px solid black;">                                                               
        <div style="float:left; width: 448px; height: 100px;border-bottom: 1px solid black;">                                                           
            {lbl}1. Nombre y domicilio del remitente{/lbl}                                                                                              
            {area class="smallFont"  name="crts_nombre_domicilio1" rows="4" cols="50" class="courierFont"}                                                                                         
        </div>                                                                                                                                          
         <div style="float:left; width: 448px; height: 100px;border-bottom: 1px solid black;">                                                          
            {lbl}4. Nombre y domicilio del destinatario{/lbl}                                                                                           
            {area class="smallFont"  name="crts_nom_dom_destin" rows="4" cols="50" class="courierFont"}                                                                                            
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 100px;border-bottom: 1px solid black;">                                                           
            {lbl}6. Nombre y domicilio del consignatario{/lbl}                                                                                          
            {area class="smallFont"  name="crts_nom_dom_consig" rows="4" cols="50" class="courierFont"}                                                                                            
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 100px;">                                                                                          
            {lbl}9. Notificar a{/lbl}                                                                                                                   
            {area class="smallFont"  name="crts_notificar_a" rows="4" cols="50" class="courierFont"}                                                                                               
        </div>                                                                                                                                          
    </div>                                                                                                                                              
                                                                                                                                                        
    <div style="float:left; width: 364px; height: 390px;">                                                                                              
        <div style="float:left; width: 370px; height: 28px; border-bottom: 1px solid black;">                                                           
            <table>                                                                                                                                     
            <tr><td>{lbl}2. Número{/lbl}</td><td>{input class="smallFont"  name="crts_numero" size="20"}</td></tr>                                                         
            </table>                                                                                                                                    
        </div>                                                                                                                                          
        <div style="float:left; width: 370px; height: 100px; border-bottom: 1px solid black;">                                                          
            {lbl}&nbsp;3. Nombre y domicilio del transportador{/lbl}                                                                                    
            {area name="crts_nom_dom_transp" rows=5 cols=47 readonly="true" class="sololectura smallFont"}                                                       
        </div>                                                                                                                                          
        <div style="float:left; width: 370px; height: 40px; border-bottom: 1px solid black;">                                                           
            {lbl}&nbsp;5. Lugar y país de emisión{/lbl}                                                                                                 
            {input class="smallFont"  name="crts_lug_pais_emis" size="45" maxlength="50"}                                                                                  
        </div>                                                                                                                                          
         <div style="float:left; width: 370px; height: 58px; border-bottom: 1px solid black;">                                                          
            {lbl}&nbsp;7. Lugar, país y fecha en que el portador se hace cargo de las mercancías{/lbl}                                                  
            {input class="smallFont"  name="crts_lug_pais_fec" size="45" maxlength="50"}                                                                                   
        </div>                                                                                                                                          
         <div style="float:left; width: 370px; height: 42px; border-bottom: 1px solid black;">                                                          
            {lbl}&nbsp;8. Lugar, país y plazo de entrega{/lbl}                                                                                          
            {input class="smallFont"  name="crts_lug_pais_plaz" size="45" maxlength="50"}                                                                                  
        </div>                                                                                                                                          
         <div style="float:left; width: 370px; height: 42px; border-bottom: 1px solid black;">                                                          
            {lbl}&nbsp;10. Portadores sucesivos{/lbl}                                                                                                   
            {input class="smallFont"  name="crts_port_sucesivos" size="45" maxlength="50"}                                                                                 
        </div>                                                                                                                                          
    </div>                                                                                                                                              
                                                                                                                                                        
</div>                                                                                                                                                  
                                                                                                                                                        
<div style="float:left; width: 820px; height: 272px; border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">       
    <div style="float:left; width: 450px; height: 270px; border-right: 1px solid black;">                                                               
        {lbl}11. Cantidad y clase de bultos, marcas y números, tipo de mercancías, contenedores y accesorios{/lbl}                                      
        {area class="smallFont"  name="crts_cant_clase_bultos" rows=13 cols=52 class="courierFont"}                                                                          
    </div>                                                                                                                                              
    <div style="float:left; width: 264px; height: 220px;">                                                                                              
        <div style="float:left; width: 370px; height: 80px;border-bottom: 1px solid black;">                                                            
            {lbl}12. Pesos brutos en Kg.{/lbl}                                                                                                          
            <table>                                                                                                                                     
                <tr><td>{lbl}P.B.{/lbl}</td><td>{input class="smallFont"  name="crts_peso_brut_kg" size="11"}</td></tr>                                                     
                <tr><td>{lbl}P.N.{/lbl}</td><td>{input class="smallFont"  name="crts_peso_neto_kg" size="11"}</td></tr>                                                     
            </table>                                                                                                                                    
        </div>                                                                                                                                         
        <div style="float:left; width: 370px; height: 45px;border-bottom: 1px solid black;">                                                            
            {lbl}13. Volumen en m.cu.{/lbl}                                                                                                             
            {input class="smallFont"  name="crts_vol_m3"            size="14"}                                                                                             
        </div>                                                                                                                                          
                                                                                                                                                        
        <div style="float:left; width: 370px; height: 45px;">                                                                                           
            {lbl}14. Valor{/lbl}                                                                                                                        
            {input class="smallFont"  name="crts_valor"             size="20"}                                                                                             
        </div>                                                                                                                                          
        <div style="float:left; width: 370px; height: 45px;">                                                                                           
            {lbl}Moneda{/lbl}                                                                                                                           
            {input class="smallFont"  name="crts_moneda"            size="3"}                                                                                              
        </div>                                                                                                                                          
    </div>                                                                                                                                              
</div>                                                                                                                                                  
                                                                                                                                                        
<div style="float:left; width: 820px; height: 500px; border: 1px solid black;">                                                                         
    <div style="float:left; width: 450px; height: 500px; border-right: 1px solid black;">                                                               
                                                                                                                                                        
       <div style="float:left; width: 358px; height: 186px;border-bottom: 1px solid black;">                                                            
           <table border="1">                                                                                                                           
              <tr><td>{lbl}15. Gastos a pagar{/lbl}</td>                                                                                                
                  <td>{lbl}Monto remitente{/lbl}</td>                                                                                                   
                  <td>{lbl}Moneda{/lbl}</td>                                                                                                            
                  <td>{lbl}Monto destinat.{/lbl}</td>                                                                                                   
                  <td>{lbl}Moneda{/lbl}</td>                                                                                                            
              </tr>                                                                                                                                     
              <tr><td>{input class="smallFont"  name="crts_flete"  size="18" maxlength="17"}</td>                                                                           
                  <td>{input class="smallFont"  name="crts_flete_monto"  size="8" style="text-align:right"}</td>                                                           
                  <td>{input class="smallFont"  name="crts_flete_moneda" size="3"}</td>                                                                                    
                  <td>{input class="smallFont"  name="crts_dest_flete"   size="8" style="text-align:right"}</td>                                                           
                  <td>{input class="smallFont"  name="crts_f_dest_moneda"  size="3"}</td>                                                                                  
              </tr>                                                                                                                                     
              <tr><td>{input class="smallFont"  name="crts_seguro"  size="18" maxlength="17"}</td>                                                                          
                  <td>{input class="smallFont"  name="crts_seguro_monto"  size="8" style="text-align:right"}</td>                                                          
                  <td>{input class="smallFont"  name="crts_seguro_moneda" size="3"}</td>                                                                                   
                  <td>{input class="smallFont"  name="crts_dest_seguro"   size="8" style="text-align:right"}</td>                                                          
                  <td>{input class="smallFont"  name="crts_s_dest_moneda"  size="3"}</td>                                                                                  
              </tr>                                                                                                                                     
              <tr><td>{input class="smallFont"  name="crts_otro"  size="18" maxlength="17"}</td>                                                                            
                  <td>{input class="smallFont"  name="crts_otro_monto"    size="8" style="text-align:right"}</td>                                                          
                  <td>{input class="smallFont"  name="crts_otro_moneda"   size="3"}</td>                                                                                   
                  <td>{input class="smallFont"  name="crts_dest_otro"     size="8" style="text-align:right"}</td>                                                          
                  <td>{input class="smallFont"  name="crts_o_dest_moneda" size="3"}</td>                                                                                   
              </tr>                                                                                                                                     
              <tr><td>{lbl}TOTAL{/lbl}</td>                                                                                                             
                  <td>{input class="smallFont"  name="crts_otro_monto_total"    size="8" style="text-align:right"}</td>                                                    
                  <td>{input class="smallFont"  name="crts_otro_moneda_total"   size="3"}</td>                                                                             
                  <td>{input class="smallFont"  name="crts_dest_otro_total"     size="8" style="text-align:right"}</td>                                                    
                  <td>{input class="smallFont"  name="crts_o_dest_moneda_total" size="3"}</td>                                                                             
              </tr>                                                                                                                                     
           </table>                                                                                                                                     
       </div>                                                                                                                                           
       <div style="float:left; width: 448px; height: 56px;border-bottom: 1px solid black;">                                                             
            {lbl}19. Monto del flete externo{/lbl}                                                                                                      
            <table>                                                                                                                                     
                <tr><td>US$</td><td>{input class="smallFont"  name="crts_monto_flete_ext"   size="14"}</td></tr>                                                           
            </table>                                                                                                                                    
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 46px;border-bottom: 1px solid black;">                                                            
            {lbl}20. Monto del reembolso contra entrega{/lbl}                                                                                           
            <table>                                                                                                                                     
                <tr><td>US$</td><td>{input class="smallFont"  name="crts_monto_reembolso"   size="14"}</td></tr>                                                           
            </table>                                                                                                                                    
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 56px;">                                                                                           
            {lbl}21. Nombre y firma del remitente o su representante{/lbl}                                                                              
            {input class="smallFont"  name="crts_nom_firma_remit"   size="45" maxlength="60"}                                                                              
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 30px;">                                                                                           
            <table>                                                                                                                                     
                <tr><td>{lbl}Fecha{/lbl}</td><td>{input class="smallFont"  name="crts_nom_firma_rfec"   size="10"}</td></tr>                                               
            </table>                                                                                                                                    
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 56px; border-top:1px solid black;">                                                               
            {lbl}23. Nombre, firma y sello del portador{/lbl}                                                                                           
            {input class="smallFont"  name="crts_nom_firma_sello"   size="45" maxlength="60" readonly="true" class="sololectura"}                                                                              
        </div>                                                                                                                                          
        <div style="float:left; width: 448px; height: 30px;">                                                                                           
            <table>                                                                                                                                     
                <tr><td>{lbl}Fecha{/lbl}</td><td>{input class="smallFont"  name="crts_nom_firma_sfec"   size="10"}</td></tr>                                               
            </table>                                                                                                                                    
        </div>                                                                                                                                          
    </div>                                                                                                                                              
                                                                                                                                                        
    <div style="float:left; width: 350px; height: 300px;">                                                                                              
                                                                                                                                                        
         <div style="float:left; width: 348px; height: 100px; border-bottom:1px solid black;">                                                          
           {lbl}16. Declaración del valor de las mercancias{/lbl}                                                                                       
           {area class="smallFont"  name="crts_decl_valor"  rows="4" cols="40" class="courierFont"}                                                                                            
                                                                                                                                                        
       </div>                                                                                                                                           
       <div style="float:left; width: 348px; height: 100px; border-bottom:1px solid black;">                                                            
           {lbl}17. Documentos anexos{/lbl}                                                                                                             
           {area class="smallFont"  name="crts_docto_anexo"  rows="4" cols="40" class="courierFont"}                                                                                           
                                                                                                                                                        
       </div>                                                                                                                                           
        <div style="float:left; width: 348px; height: 100px; border-bottom:1px solid black;">                                                           
           {lbl}18. Instrucciones sobre formalidades de aduana{/lbl}                                                                                    
           {area class="smallFont"  name="crts_inst_formal"  rows="4" cols="40" class="courierFont"}                                                                                           
                                                                                                                                                        
       </div>                                                                                                                                           
       <div style="float:left; width: 348px; height: 100px;">                                                                                           
           {lbl}22. Declaraciones y observaciones{/lbl}                                                                                                 
           {area name="crts_decl_observ"  rows="5" cols="48" readonly="true" class="sololectura smallFont"}                                                       
                                                                                                                                                        
       </div>                                                                                                                                           
       <div style="float:left; width: 348px; height: 60px;border-top:1px solid black;">                                                                 
           {lbl}24. Nombre y firma del destinatario o su representante{/lbl}                                                                            
           {input class="smallFont"  name="crts_nom_firma_des"   size="45" maxlength="60"}                                                                                 
                                                                                                                                                        
       </div>                                                                                                                                           
       <div style="float:left; width: 348px; height: 30px;">                                                                                            
            <table>                                                                                                                                     
                <tr><td>{lbl}Fecha{/lbl}</td><td>{input class="smallFont"  name="crts_nom_firma_sdes"   size="10"}</td></tr>                                               
            </table>                                                                                                                                    
        </div>                                                                                                                                          
                                                                                                                                                        
    </div>                                                                                                                                              
                                                                                                                                                        
</div>                                                                                                                                                  
<table>                                                                                                                                                 
   <tr><td colspan="2" align="right"><button type="submit">Grabar</button></td></tr>                                                                    
</table>                                                                                                                                                
{hidden name="id"}                                                                                                                                      
{hidden name="fec_carga"}                                                                                                                               
{hidden name="fec_descarga"}                                                                                                                            
{hidden name="factura_crt"}                                                                                                                             
{hidden name="factura_dias"}                                                                                                                            
{hidden name="estado"}                                                                                                                                  
                                                                                                                                                        
<br>                                                                                                                                                    
{glink caption="Volver" action="index"}{/glink}                                                                                                         
<div class="spacer"></div>                                                                                                                              
                                                                                                                                                        
{literal}                                                                                                                                               
<script language="javascript">                                                                                                                          
$("#cliente_id").change(function(){                                                                                                                     
  cliente_id = $("#cliente_id").val();                                                                                                                  
                                                                                                                                                        
  //alert("cliente: "+cliente_id);                                                                                                                      
                                                                                                                                                        
  $.ajax({url:"http://www.ruta-chile.com/rutas/crts/getCliente/"+cliente_id,success:function(result){                                                   
    //$("#div1").html(result);                                                                                                                          
                                                                                                                                                        
    l = result.split("@@");                                                                                                                             
                                                                                                                                                        
    //alert(l[0]);                                                                                                                                      
    document.getElementById("crts_nombre_domicilio1").value=l[0].trim();                                                                                
  }});                                                                                                                                                  
});                                                                                                                                                     
                                                                                                                                                        
$("#destinatario_id").change(function(){                                                                                                                
  destinatario_id = $("#destinatario_id").val();                                                                                                        
                                                                                                                                                        
  $.ajax({url:"http://www.ruta-chile.com/rutas/crts/getCliente/"+destinatario_id,success:function(result){                                              
    //$("#div1").html(result);                                                                                                                          
                                                                                                                                                        
    l = result.split("@@");                                                                                                                             
                                                                                                                                                        
    //alert(l[0]);                                                                                                                                      
    document.getElementById("crts_nom_dom_destin").value=l[0].trim();                                                                                   
  }});                                                                                                                                                  
});                                                                                                                                                     
                                                                                                                                                        
$("#consignatario_id").change(function(){                                                                                                               
  consignatario_id = $("#consignatario_id").val();                                                                                                      
                                                                                                                                                        
  $.ajax({url:"http://www.ruta-chile.com/rutas/crts/getCliente/"+consignatario_id,success:function(result){                                             
    //$("#div1").html(result);                                                                                                                          
                                                                                                                                                        
    l = result.split("@@");                                                                                                                             
                                                                                                                                                        
    //alert(l[0]);                                                                                                                                      
    document.getElementById("crts_nom_dom_consig").value=l[0].trim();                                                                                   
    document.getElementById("crts_notificar_a").value=l[0].trim();                                                                                      
                                                                                                                                                        
                                                                                                                                                        
  }});                                                                                                                                                  
});                                                                                                                                                     
</script>                                                                                                                                               
{/literal}                                                                                                                                              
</form>                                                                                                                                                 
</div>                                                                                                                                                  
                                                                                                                                                        
                                                                                                                                                        