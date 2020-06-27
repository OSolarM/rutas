{$Form->create("Chofer")}

<div class="container">
<div class="row">
   <div class="col-lg-2">
   </div>
   <div class="col-lg-7">
<div class="card">
  <div class="card-header">Datos básicos de los choferes</div>
  <div class="card-body">

<form id="form" name="form" method="post" action="index.html">  
<table>

<tr><td>{lbl}chof_rut{/lbl}      </td><td>{input name="chof_rut"       size="12"}</td></tr>
<tr><td>{lbl}chof_apellidos{/lbl}</td><td>{input name="chof_apellidos" size="25"}</td></tr>
<tr><td>{lbl}chof_nombres{/lbl}  </td><td>{input name="chof_nombres"   size="25"}</td></tr>
<tr><td>{lbl}chof_direccion{/lbl}</td><td>{input name="chof_direccion" size="60"}</td></tr>
<tr><td>{lbl}chof_comuna{/lbl}   </td><td>{input name="chof_comuna"    size="25"}</td></tr>
<tr><td>{lbl}chof_ciudad{/lbl}   </td><td>{input name="chof_ciudad"    size="25"}</td></tr>
<tr><td>{lbl}chof_region{/lbl}   </td><td>{input name="chof_region"    size="2"} </td></tr>
<tr><td>{lbl}chof_telefono{/lbl} </td><td>{input name="chof_telefono"  size="12"}</td></tr>
<tr><td>{lbl}chof_celular{/lbl}  </td><td>{input name="chof_celular"   size="12"}</td></tr>
<tr><td>{lbl}chof_email{/lbl}    </td><td>{input name="chof_email"     size="25"}</td></tr>
<tr><td>{lbl}chof_bloqueo{/lbl}  </td><td>{select name="chof_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
<tr><td align="right" colspan="2"><button type="submit" class="btn btn-primary">Grabar</button></td></tr>
</table>
{hidden name="id"}
<br/>
{glink caption="Volver" action="index"}{/glink}

<div class="spacer"></div>
</form>


   </div>
</div>
  </div>
</div>  

</div>