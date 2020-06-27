<h1>Libro de Ventas mes de {$mes} de {$agno_lvta}</h1>


{$Form->create("Cliente")}

<table style="background:lightgray;">
<tr>

   <td bgcolor="#aabbcc" align="center">Fecha</td>   
   <td bgcolor="#aabbcc" align="center">Rut</td>   
   <td bgcolor="#aabbcc" align="center">Razón Social</td>   
   <td bgcolor="#aabbcc" align="center">Doc</td>   
   <td bgcolor="#aabbcc" align="center">Número</td>   
   <td bgcolor="#aabbcc" align="center">Fec/Emisión</td>   
   <td bgcolor="#aabbcc" align="center">Fec/Vencto.</td>   
   <td bgcolor="#aabbcc" align="center">Neto</td>   
   <td bgcolor="#aabbcc" align="center">Iva</td>   
   <td bgcolor="#aabbcc" align="center">Total</td>   
                                     
</tr>

{foreach from=$libro item=rec name=foo}
<tr>

   <td bgcolor="white">{$rec.fecha}  </td>   
   <td bgcolor="white">{$rec.rut}    </td>   
   <td bgcolor="white">{$rec.razon}  </td>   
   <td bgcolor="white">{$rec.docto}  </td>   
   <td bgcolor="white">{$rec.numero} </td>   
   <td bgcolor="white">{$rec.emision}</td>   
   <td bgcolor="white">{$rec.vencto} </td>   
   <td bgcolor="white" align="right">{$rec.neto|number_format:0:",":"."}   </td>   
   <td bgcolor="white" align="right">{$rec.iva|number_format:0:",":"."}    </td>   
   <td bgcolor="white" align="right">{$rec.total|number_format:0:",":"."}  </td>   
                                     
</tr>
{/foreach}
<tr>

   <td bgcolor="white" colspan="7" align="right">TOTALES</td>   
   <td bgcolor="white" align="right">{$rec.neto|number_format:0:",":"."}   </td>   
   <td bgcolor="white" align="right">{$rec.iva|number_format:0:",":"."}    </td>   
   <td bgcolor="white" align="right">{$rec.total|number_format:0:",":"."}  </td>   
                                     
</tr>

<table>

</form>
