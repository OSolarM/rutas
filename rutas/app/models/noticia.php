<?php                                                                                     
   class Noticia extends AppModel {                                                       
      var $name       = "Noticia";                                                        
      var $useTable   = "noticias";                                                       
                                                     
                                                                                          
      var $validate = array(                                                              
                         'id'            => "type=integer",                                          
                         'noti_titulo'   => "required",                                     
                         'noti_resumen'  => "required",                                    
                         'noti_texto'    => "required",                                      
                         'noti_publicar' => "type=integer"                                
                       );                                                                                                                                     
   }//class Noticia                                                                       