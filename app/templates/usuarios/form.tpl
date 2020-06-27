{$Form->create("Acceso")}

<div id="stylized" class="myform" style="width:550px;">
<form id="form" name="form" method="post" action="index.html">
<h1>Usuarios</h1>
<p>Datos b&aacute;sicos de los usuarios</p>
<table>
   <tr><td align="right">{lbl}Usuario{/lbl}          </td><td>{input name="user"  size="12"}</td></tr>
   <tr><td align="right">{lbl}Contrase&ntilde;a{/lbl}       </td><td>{input name="pass" size="12"}</td></tr>
   <tr><td align="right">{lbl}Repita Contrase&ntilde;a{/lbl}</td><td>{input name="pass2" size="12"}</td></tr>
   <tr><td align="right">{lbl}Apellidos{/lbl}        </td><td>{input name="apellidos" size="25"}</td></tr>
   <tr><td align="right">{lbl}Nombres{/lbl}          </td><td>{input name="nombres" size="25"}</td></tr>
   <tr><td align="right">{lbl}acop_bloqueo{/lbl}     </td><td>{select name="bloqueo"}|,Sí|S,No|N{/select}</td></tr>
   <tr><td colspan="2">
         <table border=1>
   <tr>
   <td>
   <select id="flds" size=10 style="width:200px" multiple="multiple">
   {foreach from=$modulos item=mm}
   <option value='{$mm.id}'>{$mm.titulo}</option>
   {/foreach}
   </select>
   </td>
   <td valign="middle">
       <table>
       <tr><td><input type="button" id="btnDer" value=" -> " /></td></tr>
       <tr><td></td></tr>
       <tr><td><tr><td><input type="button" id="btnIzq" value=" <- " /></td></tr></td></tr>

       </table>
   </td>
   <td>
   <select id="lsels" size=10 style="width:200px" multiple="multiple">
   {foreach from=$modulos_sel item=mm}
   <option value='{$mm.id}'>{$mm.titulo}</option>
   {/foreach}
   </select>   
   </td>
   
   </tr>
   </table>
       </td>
   </tr>
   
   <tr><td align="right" colspan="2"><button type="submit">Grabar</button></td></tr>
</table>
{hidden name="id"}
{hidden name="lfields"}

{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
{literal}
   <script language="javascript">
      document.getElementById("frm").onsubmit = function() {
	     l = document.getElementById("lsels");
	     
	     s = "";
	     
	     for (i=0; i < l.length; i++) {
		    if (s!="") s = s + ",";
		    
		    s = s + l.options[i].value;
	     }
	     
	     if (s.length > 0) {
		    document.getElementById("lfields").value = s;
            return true;	
         }     
         else {
	        alert("�Debe seleccionar elementos!");
	        return true;
         }
      }
      
      document.getElementById("btnDer").onclick=function() {
	     flds  = document.getElementById("flds");
	     lsels = document.getElementById("lsels");
	     
	     moveOptions(flds, lsels);
      }
      
      document.getElementById("btnIzq").onclick=function() {
	     flds  = document.getElementById("flds");
	     lsels = document.getElementById("lsels");
	     
	     moveOptions(lsels, flds);
      }

var NS4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) < 5);
      
function addOption(theSel, theText, theValue)
{
  var newOpt = new Option(theText, theValue);
  var selLength = theSel.length;
  theSel.options[selLength] = newOpt;
}

function deleteOption(theSel, theIndex)
{ 
  var selLength = theSel.length;
  if(selLength>0)
  {
    theSel.options[theIndex] = null;
  }
}

function moveOptions(theSelFrom, theSelTo)
{
  
  var selLength = theSelFrom.length;
  var selectedText = new Array();
  var selectedValues = new Array();
  var selectedCount = 0;
  
  var i;
  
  // Find the selected Options in reverse order
  // and delete them from the 'from' Select.
  for(i=selLength-1; i>=0; i--)
  {
    if(theSelFrom.options[i].selected)
    {
      selectedText[selectedCount] = theSelFrom.options[i].text;
      selectedValues[selectedCount] = theSelFrom.options[i].value;
      deleteOption(theSelFrom, i);
      selectedCount++;
    }
  }
  
  // Add the selected text/values in reverse order.
  // This will add the Options to the 'to' Select
  // in the same order as they were in the 'from' Select.
  for(i=selectedCount-1; i>=0; i--)
  {
    addOption(theSelTo, selectedText[i], selectedValues[i]);
  }
  
  if(NS4) history.go(0);
}
      
   </script>
{/literal}   
</form>
</div>
