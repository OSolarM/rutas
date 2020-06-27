
function chk_fld(fname, n, obtype, required) {

   //alert(fname);
   
   showError(fname, "");	
   
   //alert(required);
   //alert(n.value.length);
   
   //if (n.value.length > 0)
   //   n.value = rightTrim(n.value);
   
   if (required) {
      if (n.value.length==0) {
	     showError(fname, fldNotEmpty); 
	     return;
      }	
   }
   
   //if (obtype=="N") alert(fname);
         
   if (obtype=="N")
      if (!isNumeric(n.value)) {
	     showError(fname, fldNumeric);
	     return;
      }
      
   if (obtype=="D")
      if (!isDate(n.value)) {
	     showError(fname, fldDate);
	     return;
      }
      
      
   if (obtype=="M")
      if (!echeck(n.value)) {
	     showError(fname, fldMail);
	     return;
      }
}

function showError(fname, error_message) {
   
   if (!document.getElementById("msg_"+fname)) alert("msg_"+fname)
   
   msg = document.getElementById("msg_"+fname);	
	 msg.style.display='none';
	 msg.style.height='0px';
  
   if (msg!=null && error_message.length>0) {
   	  msg.innerHTML=error_message;
    	msg.style.display='block';
    	msg.style.height='16px';
   }
   
   if (error_message.length==0)
      eval("document.frm.okfld_"+fname+".value=''");
   else
      eval("document.frm.okfld_"+fname+".value='F'");
}

function isDigit(ch) {
   return (ch >= "0") && (ch <= "9");
}

function isNumeric(s) {
   //alert(s);
   
   if (s=="") return true;
   
   s = s + "@";
   i = 0;
   
   if (s.charAt(i)=="+" || s.charAt(i)=="-")
      i++;
      
   if (!isDigit(s.charAt(i))) return false;
   
   while (isDigit(s.charAt(i))) i++;
   
   if (s.charAt(i)==".") i++;
   
   while (isDigit(s.charAt(i))) i++;
   
   return (s.charAt(i)=="@");   
}

function echeck(str) {
   var at="@"
   var dot="."
   var lat=str.indexOf(at)
   var lstr=str.length
   var ldot=str.indexOf(dot)
   
   if (str.length==0) return true; //Empty mails allowed
   
   if (str.indexOf(at)==-1){
      //alert("Invalid E-mail ID")
      return false
   }
   
   if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
      //alert("Invalid E-mail ID")
      return false
   }
   
   if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
       //alert("Invalid E-mail ID")
       return false
   }
   
    if (str.indexOf(at,(lat+1))!=-1){
       //alert("Invalid E-mail ID")
       return false
    }
   
    if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
       //alert("Invalid E-mail ID")
       return false
    }
   
    if (str.indexOf(dot,(lat+2))==-1){
       //alert("Invalid E-mail ID")
       return false
    }
   
    if (str.indexOf(" ")!=-1){
       //alert("Invalid E-mail ID")
       return false
    }
   
    return true					
}

var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){
	if (dtStr=="") return true;;
	
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		//alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		//alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		//alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		//alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		//alert("Please enter a valid date")
		return false
	}
return true
}

