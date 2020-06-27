<?php
   class UsuariosController extends AppController {
      var $name = "Usuarios";
      var $uses = array("Acceso", "Modulo", "ModuloAcceso");

      function index($page=null) {
         $recsXPage=10;

         if (isset($_REQUEST["page"])) {
            $page     = $_REQUEST["page"];
            $sortKey  = $_REQUEST["sortKey"];
            $orderKey = $_REQUEST["orderKey"];
         }
         else if ($page!=null) {
            $e       = explode(":", $page);
            if (count($e) >= 1) $page    =$e[0]; else $page=1;
            if (count($e) >= 2) $sortKey =$e[1]; else $sortKey="id";
            if (count($e) >= 3) $orderKey=$e[2]; else $orderKey="asc";
         }
         else {
            $page    = 1;
            $sortKey ="id";
            $orderKey="asc";
         }

         //echo "$sortKey $orderKey<hr>";
         $this->set("sortKey", $sortKey);
         $this->set("orderKey", $orderKey);
         $this->set("page",     $page);

         $arreglo = $this->Acceso->findAll(null, null, $sortKey." ".$orderKey, ($page-1)*$recsXPage + 1, $recsXPage);

         $pagination = new pagination("/usuarios/index", $page, ":".$sortKey.":".$orderKey);

         $arreglo = $pagination->generate($arreglo, $this->Acceso->count(), $recsXPage);

         $this->assign('pagination', $pagination->links());


          $g = new MiGrid();

          $g->addField("Usuario", "user"     );
          //$g->addField("", "pass"     );
          $g->addField("Apellidos", "apellidos");
          $g->addField("Nombres", "nombres"  );

          $g->addField("Bloqueo",          "bloqueo", array("align" => "center",
                                                                   "trad"  => array("S"=>"Sí", "N" => "No")
                                                                   )
                      );
          $g->addField("&nbsp;", "comandos");

          $g->setData($arreglo);
          $this->set("grilla", $g->show());
      }

      function add() {
         $this->Acceso->validate["pass2"] = "required|eq=pass";      
         
         $this->layout="form";

         if (!empty($this->data)) {
            $this->data["Acceso"]["pass2"] = $_REQUEST["pass2"]; 
               
            $pass = $this->data["Acceso"]["pass"];
            $pass2 = $this->data["Acceso"]["pass2"];
            
            if ($this->Acceso->save($this->data)) {
               $this->data["Acceso"]["pass"] = md5($pass);
            
               $this->Acceso->save($this->data);
               
               $user = $this->Acceso->data["Acceso"]["user"];
               
               if ($this->Acceso->findByUser($user))
                  $id = $this->Acceso->data["Acceso"]["id"];
               
               $lista = $this->ModuloAcceso->findAll("acceso_id=$id");
               
               foreach($lista as $l) 
                  $this->ModuloAcceso->delete($l["id"]);
                  
               $lfields = $_REQUEST["lfields"];   
               
               $lista = explode(",", $lfields);
               
               //print_r($lista);
               
               foreach($lista as $modulo_id) {
                  $data["ModuloAcceso"]["id"] = ""; 
                  $data["ModuloAcceso"]["acceso_id"] = $id;
                  $data["ModuloAcceso"]["modulo_id"] = $modulo_id;
                  
                  $this->ModuloAcceso->save($data);
                  
               }
               
               $this->redirect("/usuarios");
            }            
            else {
               $this->data["Acceso"]["pass"]  = $pass;
               $this->data["Acceso"]["pass2"] = $pass2;
            }
         }
         if (empty($this->data)) {
            //Inicializar
         }
         
         $arreglo = $this->Modulo->findAll();
         
         $this->set("modulos", $arreglo);
      }

      function edit($id=null) {
          
         //print_r($this->Acceso->validate);
          
         //print_r($this->data);
         
         $this->Acceso->validate["pass2"] = "required|eq=pass";
         
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         $this->layout="form";

         if (!empty($this->data)) {
            $this->data["Acceso"]["pass2"] = $_REQUEST["pass2"]; 
               
            $pass = $this->data["Acceso"]["pass"];
            $pass2 = $this->data["Acceso"]["pass2"];
            
            if ($this->Acceso->save($this->data)) {
               $this->data["Acceso"]["pass"] = md5($pass);
            
               $this->Acceso->save($this->data);
               
               $lista = $this->ModuloAcceso->findAll("acceso_id=$id");
               
               foreach($lista as $l) 
                  $this->ModuloAcceso->delete($l["id"]);
                  
               $lfields = $_REQUEST["lfields"];   
               
               $lista = explode(",", $lfields);
               
               //print_r($lista);
               
               foreach($lista as $modulo_id) {
                  $data["ModuloAcceso"]["id"] = ""; 
                  $data["ModuloAcceso"]["acceso_id"] = $id;
                  $data["ModuloAcceso"]["modulo_id"] = $modulo_id;
                  
                  $this->ModuloAcceso->save($data);
                  
               }
               
               $this->redirect("/usuarios");
            }            
            else {
               $this->data["Acceso"]["pass"]  = $pass;
               $this->data["Acceso"]["pass2"] = $pass2;
            }
         }
         if (empty($this->data)) {
            $this->data = $this->Acceso->read(null, $id);
            $this->data["Acceso"]["pass"]="";
         }
         
         $arreglo = $this->Modulo->findAll("id not in (select modulo_id from modulos_accesos where acceso_id=$id)");
         $arreglo2 = $this->Modulo->findAll("id in (select modulo_id from modulos_accesos where acceso_id=$id)");
         
         $this->set("modulos", $arreglo);
         $this->set("modulos_sel", $arreglo2);   
      }

      function delete($id=null) {
         if ($id==null) {
            $this->redirect("/errores/pkNotFound");
            return;
          }

         if ($this->Acceso->delete($id)) 
            $this->redirect("/usuarios");
         else
            $this->redirect("/errores/idNotFound");
      }
   }
   
   class MiGrid extends Grid {
      function showField($f, $row) {
         $name    = $f["name"];

         if ($name!="comandos")
            return parent::showField($f, $row);
         else {
            $id = $row["id"];
            return "<td style=\"background:white\"><a href=\"".APP_HTTP."/usuarios/edit/$id\"><img src=\"".APP_HTTP."/app/img/edit.gif\">Modifica</a></td>";
         }
      }
   }