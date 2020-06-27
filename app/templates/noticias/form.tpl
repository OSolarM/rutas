{$Form->create('Noticia')}
  <h2>Mantención de Noticias</h2>
  <table>          
     <tr><td>Título</td><td>{text name="noti_titulo" size="60"}</td></tr>
     <tr><td>Resumen</td><td>{area name="noti_resumen" size="60" maxlength="120"}</td></tr>
     <tr><td>Texto</td><td>{area name="noti_texto" size="2000" rows="10"}</td></tr>
     <tr><td>Publicar</td><td>{select name="noti_publicar"}|,No|0,Sí|1{/select}</td></tr>
     <tr><td colspan="2" align="right">{submit value="Enviar" class="miboton"}</td></tr>
     <tr><td colspan="2" align="left">{glink caption="Volver" action="index"}{/glink}</td></tr>
  </table>
  {hidden name="id"}  
</form>
