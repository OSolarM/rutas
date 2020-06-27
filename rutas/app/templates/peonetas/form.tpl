<div class="container">
   <div class="row">
      <div class="col-lg-2">
	  </div>
	  <div class="col-lg-7">
	     <div class="card">
            <div class="card-header">Peonetas - Datos básicos de los peonetas</div>
            <div class="card-body">
               {$Form->create("Peoneta")}
               
               <form id="form" name="form" method="post" action="index.html">
               
               <table>
                  <tr><td align="right">{lbl}pnta_rut{/lbl}      </td><td>{input name="pnta_rut"       size="12"}</td></tr>
                  <tr><td align="right">{lbl}pnta_apellidos{/lbl}</td><td>{input name="pnta_apellidos" size="25"}</td></tr>
                  <tr><td align="right">{lbl}pnta_nombres{/lbl}  </td><td>{input name="pnta_nombres"   size="25"}</td></tr>
                  <tr><td align="right">{lbl}pnta_direccion{/lbl}</td><td>{input name="pnta_direccion" size="60"}</td></tr>
                  <tr><td align="right">{lbl}pnta_comuna{/lbl}   </td><td>{input name="pnta_comuna"    size="25"}</td></tr>
                  <tr><td align="right">{lbl}pnta_ciudad{/lbl}   </td><td>{input name="pnta_ciudad"    size="25"}</td></tr>
                  <tr><td align="right">{lbl}pnta_region{/lbl}   </td><td>{input name="pnta_region"    size="2"}</td></tr>
                  <tr><td align="right">{lbl}pnta_telefono{/lbl} </td><td>{input name="pnta_telefono"  size="12"}</td></tr>
                  <tr><td align="right">{lbl}pnta_celular{/lbl}  </td><td>{input name="pnta_celular"   size="12"}</td></tr>
                  <tr><td align="right">{lbl}pnta_email{/lbl}    </td><td>{input name="pnta_email"     size="25"}</td></tr>
                  <tr><td align="right">{lbl}pnta_bloqueo{/lbl}  </td><td>{select name="pnta_bloqueo"}|,Sí|S,No|N{/select}</td></tr>
                  <tr><td colspan="2" align="right"><button type="submit" class="btn btn-primary">Grabar</button></td></tr>
               </table>
               {hidden name="id"}
               <br>
               {glink caption="Volver" action="index"}{/glink}
               <div class="spacer"></div>
               
               
               </form>
            </div>			
		 </div>	
	  </div>
   </div>
</div>
