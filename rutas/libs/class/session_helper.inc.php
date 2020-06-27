<?php
   class SessionHelper
   {
      var $message=null;
      
      function setFlash($message)
      {
	     echo ">>> $message<hr/>";
	     
	     $_SESSION["MsgFlash"] = $message;
      }     
   }