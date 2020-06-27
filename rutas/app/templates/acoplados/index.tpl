<form id="frm" name="frm" method="post">
<h1>Acoplados</h1>

{if $MsgFlash ne ""}
   <h4>{$MsgFlash}</h4>
{/if}

{glink img="add.png" caption="Nuevo" action="add"}{/glink}


{$grilla}

{if !empty($pagination)}
            <div class="pagination">{$pagination}</div>
        {/if}
{hidden name="sortKey"}
{hidden name="orderKey"}
{hidden name="page"}
{literal}
<script language="javascript">
   function setOrder(cOrder) {
      
      if (document.frm.sortKey.value==cOrder) {

         if (document.frm.orderKey.value=="asc")
            document.frm.orderKey.value="desc";
         else
            document.frm.orderKey.value="asc";
   
      }  
      else
         document.frm.orderKey.value="asc";

      document.frm.sortKey.value=cOrder;
      document.frm.submit();
   }
</script>
{/literal}
</form>