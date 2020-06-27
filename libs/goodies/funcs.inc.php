<?php
   function isDigit($c) {
      return ($c >= "0" && $c <= "9");
   }

   function isInteger($val) {
      if (empty($val)) return true;

      $s = $val."@";
      $i = 0;

      if ($s[$i]=="+" || $s[$i]=="-")
         $i++;

      while (isDigit($s[$i])) $i++;

      return ($s[$i]=="@");
   }//isInteger

   function isNumber($val) {
      if (empty($val)) return true;

      $s = $val."@";
      $i = 0;

      if ($s[$i]=="+" || $s[$i]=="-")
         $i++;

      while (isDigit($s[$i])) $i++;

      if ($s[$i]==".") $i++;

      while (isDigit($s[$i])) $i++;

      return ($s[$i]=="@");
   }//isNumber

   function isDate($val) {
      if (empty($val)) return true;

      if (strlen($val)!=10) return false;

      $dia = substr($val, 0, 2);
      $mes = substr($val, 3, 2);
      $agno= substr($val, 6, 4);

      if (!isInteger($dia)) return false;

      if (!isInteger($mes)) return false;

      if (!isInteger($agno)) return false;

      return checkdate($mes, $dia, $agno);
   }//isDate
   
   function isEMail($email){
      if ($email=="") return true;

      $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
      $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
      $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
          '\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
      $quoted_pair = '\\x5c[\\x00-\\x7f]';
      $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
      $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
      $domain_ref = $atom;
      $sub_domain = "($domain_ref|$domain_literal)";
      $word = "($atom|$quoted_string)";
      $domain = "$sub_domain(\\x2e$sub_domain)*";
      $local_part = "$word(\\x2e$word)*";
      $addr_spec = "$local_part\\x40$domain";
      return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
   }//isEMail   

   /**
   * Verifica que el rut ingresado sea v&aacute;lido
   * Debe estar en formato xxxxxxxx-x
   * @return bool
   */
   function isRut($sUsr) {
      if (empty($sUsr))
         return true;

      if (!preg_match("/(\d{7,8})-([\dK])/", strtoupper($sUsr), $aMatch)) {
         return false;
      }

      $sRutBase = substr(strrev($aMatch[1]) , 0, 8 );
      $sCodigoVerificador = $aMatch[2];
      $iCont = 2;
      $iSuma = 0;
      for ($i=0; $i < strlen($sRutBase); $i++) {
         if ($iCont>7) {
            $iCont = 2;
         }
         $iSuma+= ($sRutBase{$i}) *$iCont;
         $iCont++;
      }
      $iDigito = 11-($iSuma%11);
      $sCaracter = substr("-123456789K0", $iDigito, 1);
      return ($sCaracter == $sCodigoVerificador);
   }
   
   function mysql2Date($d) {
       if (trim($d)=="")
          return "";
                       
       return substr($d, 8, 2)."/".substr($d, 5, 2)."/".substr($d, 0, 4);      
   }//mysql2Date
   
   function date2Mysql($d) {
       if (trim($d)=="")
          return "";
        
       return substr($d, 6, 4)."-".substr($d, 3, 2)."-".substr($d, 0, 2);      
   }//date2Mysql
   
   function isUpperCase($cChar) {
      return ($cChar >="A") && ($cChar <="Z");
   }
   
   function _aNombreArchivo($nombreClase) {
       
      //echo "Entre a a _aNombreArchivo: $nombreClase<hr>";
      $s = $nombreClase."@";
      $myClass="";
      
      //echo "$s<hr>";
      
      $i = 0;
      while ($s[$i] != "@") {
         //echo "Letra posicion $i: ".$s[$i]."<hr>";
         if (isUpperCase($s[$i])) {
            $v = $s[$i];
            
            $i++;
            while ($s[$i] !="@" && !isUpperCase($s[$i])) {
               $v .= $s[$i];
               
               $i++;
            }
            
            //echo $v."<hr>";
            
            if ($myClass !="") $myClass .= "_";
            
            $myClass .= strtolower($v);
            
            //echo "Letra posicion $i: ".$s[$i]."<hr>";
            
         }
         else
            $i++;
      }
      
      //echo $myClass."<hr>";
      return $myClass;    
   }  


/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 

*/ 
function num2letras($num, $fem = false, $dec = true) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . 'on'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   $end_num=ucfirst($tex); //.$float[1].'/100 M.N.';
   return $end_num; 
} 

function num2letras_int($num, $fem = false, $dec = true) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . 'on'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   //$end_num=ucfirst($tex); //.$float[1].'/100 M.N.';
   
   $end_num=ucfirst($tex).' dolares '.$float[1].'/100';
   return $end_num; 
} 

function mesPal($mes) {
   switch($mes) {
	  case 1:  return "Enero"; break;
	  case 2:  return "Febrero"; break;
	  case 3:  return "Marzo"; break;
	  case 4:  return "Abril"; break;
	  case 5:  return "Mayo"; break;
	  case 6:  return "Junio"; break;
	  case 7:  return "Julio"; break;
	  case 8:  return "Agosto"; break;
	  case 9:  return "Septiembre"; break;
	  case 10: return "Octubre"; break;
	  case 11: return "Noviembre"; break;
	  case 12: return "Diciembre"; break;
	  default: return "**********"; break;
   }
}

function displayLen($s, $lineLength=50) {
   $ss="";
   
   while (strlen($s)%$lineLength!=0)
      $s .= " ";
   
   $lon = strlen($s)/$lineLength;
   
   $i = 0;
   while ($i < $lon) {
	  $linea = substr($s, $i*$lineLength, $lineLength);
	  
	  //echo $linea ."<hr/>";
	  
	  if ($ss!= "") $ss .= "<br>";
	  
	  $ss .= rtrim($linea);
	  
	  $i += 1;
   }
   
   return $ss;
}

function displayText($s, $lineLength=50, $sl="\n") {   
   $ss="";
   $v=rtrim($s)."^";
   $i=0;
   $linea="";
   $palabra="";
   
   //echo $v."<br/>";
   
   while (substr($v, $i, 1)!="^") {
	  while (substr($v, $i, 1)==" ") {
		 $i++;
	  }
	  
	  $palabra= "";
	  while (substr($v, $i, 1)!=" "  && 
	         substr($v, $i, 1)!="\n" &&
	         substr($v, $i, 1)!="\t" &&
	         substr($v, $i, 1)!="^") {
		 //echo substr($v, $i, 1).$sl;
		 $palabra .= substr($v, $i, 1);
		 $i++;
	  }
	  
	  if (strlen($palabra) + 1 <= $lineLength - strlen($linea))
	     $linea .= " ".$palabra;
	  else {
		 //echo $linea;
		 $ss .= $linea.$sl;
		 $linea = $palabra;
	  }
   }
      
   return $ss.$linea;
}

function toControllerName($s) {
   $v = explode("_", $s);
   
   $vv = "";
   
   foreach($v as $pal) {
      $vv .= ucfirst(strtolower($pal));
   }
   
   return $vv;
}

function loadController($s, $controller) {
   $s .="_controller.php";
   
   //echo APP_PATH."/app/controllers/".$s."<br/>";
   
   include_once(APP_PATH."/app/controllers/".$s);
   
   $controller .= "Controller";
   
   //echo $controller."<br/>";
   
   $obj = new $controller;
   
   return $obj;
}