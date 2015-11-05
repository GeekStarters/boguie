////////////////STRING FUNCTIONS////////////////
var arrInvalidDomain=new Array( "yahoomail.com","yahoo.com",
				"yahoomail.co.in","yahoo.co.in",
				"yahoo.com.in","yahoo.co.in",
				"redifmail.com","rediffmail.com",
				"radiffmail.com","rediffmail.com"
);
function redirect(){
setTimeout("location.href='index.php'", 5000);
}

function isNumericpank(str){ //Numeric Validation
  var re = /[\D]/g
  return (re.test(str));
}
function poptastic(url)
{
	newwindow=window.open(url,'name','height=650,width=650,scroling=no,scrollbars=no');
	if (window.focus) {newwindow.focus()}
}

function numbersonly(e){
var unicode=e.charCode? e.charCode : e.keyCode
if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
if (unicode<48||unicode>57) //if not a number
return false //disable key press
}
}

/*
var tmpmail = email.value.split("@");
		for ( i = 0; i < arrInvalidDomain.length; i = i+2)
		{
			if (tmpmail[1] == arrInvalidDomain[i])
			{
				
				 "This Email Id Seems Incorrect. Did You Mean <b>"+tmpmail[0]+"@" +arrInvalidDomain[i+1]+ "</b>";
				check = false;
			}
		}


*/

function trim( str ) {
	// Immediately return if no trimming is needed
	if( (str.charAt(0) != ' ') && (str.charAt(str.length-1) != ' ') ) { return str; }
	// Trim leading spaces
	while( str.charAt(0)  == ' ' ) {
		str = '' + str.substring(1,str.length);
	}
	// Trim trailing spaces
	while( str.charAt(str.length-1)  == ' ' ) {
		str = '' + str.substring(0,str.length-1);
	}
	return str;
}

// Remove characters that might cause security problems from a string 
function removeBadCharacters(string) {
	if (string.replace) {
		string.replace(/[<>\"\'%;\)\(&\+]/, '');
	}
	return string;
}

// Check that a string contains only letters
function isAlphabetic(string) {
	return isAlphabetic1(string, true);
}

function isAlphabetic1(string, ignoreWhiteSpace) {
	if (string.search) {
		if ((ignoreWhiteSpace && string.search(/[^a-zA-Z\s]/) != -1) || (!ignoreWhiteSpace && string.search(/[^a-zA-Z]/) != -1)) return false;
	}
	return true;
}

// Check that a string contains only numbers
function isNumeric(string) {
	return isNumeric1(string, false);
}

function isNumeric1(string, ignoreWhiteSpace) {
	if (string.search) {
		if ((ignoreWhiteSpace && string.search(/[^\d\s]/) != -1) || (!ignoreWhiteSpace && string.search(/\D/) != -1)) return false;
	}
	return true;
}

// Remove all spaces from a string
function trimAll(string) {
	var newString = '';
	for (var i = 0; i < string.length; i++) {
		if (string.charAt(i) != ' ') newString += string.charAt(i);
	}
	return newString;
}

// Check that a string contains only letters and numbers
function isAlphanumeric(string) {
	return isAlphanumeric1(string, false);
}
function isAlphanumeric1(string, ignoreWhiteSpace) {
	if (string.search) {
		if ((ignoreWhiteSpace && string.search(/[^\w\s]/) != -1) || (!ignoreWhiteSpace && string.search(/\W/) != -1)) return false;
	}
	return true;
}

// Check that the number of characters in a string is between a max and a min
function isValidLength(string, min, max) {
	if (string.length < min || string.length > max) return false;
	else return true;
}

// Check that an email address is valid based on RFC 821 (?)//address.indexOf('@') < 1 it changed 3 to 1 on the client request
function isValidEmail(address) {
	if (address.indexOf('@') < 1) return false;
	var name = address.substring(0, address.indexOf('@'));
	var domain = address.substring(address.indexOf('@') + 1);
	if (name.indexOf('(') != -1 || name.indexOf(')') != -1 || name.indexOf('<') != -1 || name.indexOf('>') != -1 || name.indexOf(',') != -1 || name.indexOf(';') != -1 || name.indexOf(':') != -1 || name.indexOf('\\') != -1 || name.indexOf('"') != -1 || name.indexOf('[') != -1 || name.indexOf(']') != -1 || name.indexOf(' ') != -1) return false;
	if (domain.indexOf('(') != -1 || domain.indexOf(')') != -1 || domain.indexOf('<') != -1 || domain.indexOf('>') != -1 || domain.indexOf(',') != -1 || domain.indexOf(';') != -1 || domain.indexOf(':') != -1 || domain.indexOf('\\') != -1 || domain.indexOf('"') != -1 || domain.indexOf('[') != -1 || domain.indexOf(']') != -1 || domain.indexOf(' ') != -1) return false;
	return true;
}
// Check that an email address has the form something@something.something
// This is a stricter standard than RFC 821 (?) which allows addresses like postmaster@localhost
function isValidEmailStrict(address) {
	if (isValidEmail(address) == false) return false;
	var domain = address.substring(address.indexOf('@') + 1);
	if (domain.indexOf('.') == -1) return false;
	if (domain.indexOf('.') == 0 || domain.indexOf('.') == domain.length - 1) return false;
	return true;
}


////////////////////////////////////////////////
////////////////DATE VALIDATION/////////////////
////////////////////////////////////////////////
function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return (false);
    }
    // All characters are numbers.
    return (true);
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
    return (returnString);
}
function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31;
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30;}
		if (i==2) {this[i] = 29;}
   } 
   return (this);
}
function isDate(dtStr){
	var dtCh= "/";
	var minYear=1900;
	var maxYear=2100;
	
	var daysInMonth = DaysArray(12);
	var pos1 = dtStr.indexOf(dtCh);
	var pos2 = dtStr.indexOf(dtCh,pos1+1);
	var strMonth = dtStr.substring(0, pos1);
	var strDay = dtStr.substring(pos1+1,pos2);
	var strYear = dtStr.substring(pos2+1);
	strYr = strYear;
	if (strDay.charAt(0) == "0" && strDay.length > 1) strDay = strDay.substring(1);
	if (strMonth.charAt(0) == "0" && strMonth.length > 1) strMonth = strMonth.substring(1);
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0) == "0" && strYr.length > 1) strYr = strYr.substring(1);
	}
	month = parseInt(strMonth);
	day = parseInt(strDay);
	year = parseInt(strYr);
	if (pos1 == -1 || pos2 == -1){
		//alert("The date format should be : mm/dd/yyyy");
		return (false);
	}
	if (strMonth.length<1 || month<1 || month>12){
		//alert("Please enter a valid month");
		return (false);
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		//alert("Please enter a valid day");
		return (false);
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		//alert("Please enter a valid 4 digit year");// between "+minYear+" and "+maxYear);
		return (false);
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		//alert("Please enter a valid date");
		return (false);
	}
	
	return (true);
}

//
function checkAllCB(cb, blnVal) {
	var iCnt;
	for (iCnt=0; iCnt < cb.length; iCnt++) {
		cb[iCnt].checked = blnVal;
	}
}

function checkAllFRM(frm, blnVal) {
	var iCnt;
	for (iCnt=0; iCnt < frm.elements.length; iCnt++) {
		if (frm.elements[iCnt].type == 'checkbox') {
			frm.elements[iCnt].checked = blnVal;
		}
	}
}

function isAllChecked(cb, resCb) {
	var iCnt;
	for (iCnt=0; iCnt < cb.length; iCnt++) {
		if (!cb[iCnt].checked) {
			break;
		}
	}
	if (iCnt == cb.length)
		resCb.checked = true;
	else
		resCb.checked = false;
}

function isAnyCheckedFRM(frm, msg) {
	for (var iCnt = 0; iCnt < frm.elements.length; iCnt++) {
		if (frm.elements[iCnt].type.toLowerCase() == "checkbox") {
			if (frm.elements[iCnt].checked) {
				return (true);
			}
		}
	 }
	alert(msg);
	return (false);
}

//
function openFixedWindow(argURL, argSize) {
	window.open(argURL, "newWindow", "resizable=no," + argSize);
}

function openImageWindow(argURL, argSize) {
	window.open(argURL, "newImageWindow", "resizable=yes,scrollbars=yes," + argSize);
}

function clearCombo(varCombo) {
	for (var iCnt = varCombo.options.length; iCnt >= 0; --iCnt)
		varCombo.options[iCnt] = null;
}


function Highlight(e) {
	var r = null;
	
	r = document.getElementById("tr_" + e.value).className;
	
	if (r == "trListValue")
		r = "trListValue1";
	else
		r = "trListValue";
	
	document.getElementById("tr_" + e.value).className = r;
}

function createIDs(e) {
	var nm = e.name;
	var cb = eval("document.frmMain." + e.name);
	
	var t = "";
	var f = "";
	
	if (cb.length) {
		for (var i = 0; i < cb.length; i++) {
			if (cb[i].checked)
				t += "'" + cb[i].value + "',";
			else
				f += "'" + cb[i].value + "',";
		}
		t = t.substr(0, t.length - 1);
		f = f.substr(0, f.length - 1);
	}
	else {
		if (cb.checked)
			t = "'" + cb.value + "'";
		else
			f = "'" + cb.value + "'";
	}
	
	document.getElementById(nm.replace("cb_", "h_")).value = t + "|" + f;
}

function doChangeWay(ctl, val) {
	document.getElementById(ctl).value = val;
	//eval("document.frmMain." + ctl + ".value = val;");
	document.frmMain.submit();
}

function doChangeSort(argSort) {
	var sort = document.frmMain.sort.value;
	var order = document.frmMain.order.value.toLowerCase();
	
	if (sort == argSort) {
		if (order == "asc")
			order = "desc";
		else
			order = "asc";
	}
	else {
		order = "asc";
	}
	document.location = document.frmMain.action + "?sort=" + argSort + "&order=" + order;
}

var popUpWin=0;
function popUpWindow(URLStr,width,height,top,left)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'SendSms', 'width='+width+',height='+height+',top='+top+',left='+left+'');
}

function messageWindow(title, msg)
{
  var width="300", height="125";
  var left = (screen.width/2) - width/2;
  var top = (screen.height/2) - height/2;
  var styleStr = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+',top='+top+',screenX='+left+',screenY='+top;
  var msgWindow = window.open("","msgWindow", styleStr);
  var head = '<head><title>'+title+'</title></head>';
  var body = '<center>'+msg+'<br><p><form><input type="button" value="   Done   " onClick="self.close()"></form>';
  msgWindow.document.write(head + body);
}
// JavaScript Document
/*
FormatTelNo method takes in the current element of the form and formats the phone number 
in "(123 456-7890" format. This method should be fired on every key entry 
(using onKeyUp method) in the current element of the form. If any key other than 0 to 9 
is entered, it erases that entry rightaway. Maxlength and size of the current
element of the form should be 13.
Eg. <netui:textBox size="13" maxlength="13" onKeyUp="JavaScript:formatTelNo (this);" onBlur="JavaScript:checkTelNo (this);" onKeyDown="JavaScript:formatTelNo (this);"/>    
*/
function formatTelNo (telNo)
{
    // If it's blank, save yourself some trouble by doing nothing.
    if (telNo.value == "") return false;

    

    var phone = new String (telNo.value);
    
    phone = phone.substring(0,14);

    /*
    "." means any character. If you try to use "(" and ")", the regular expression becomes 
    complicated sice both are reserve characters and escaping them sometimes fails. So just 
    use "." for any character and replace it later.
    */
    if (phone.match (".[0-9]{3}.[0-9]{3}-[0-9]{4}") == null)
    {
        /*
        Following "if" is for user making any changes to the formatted tel. no. If you don't put this 
        "if" condition, the user can not correct a digit by first deleting it and then entering a 
        correct one, since this will fire two "onkeyup" events : first one on deleting a 
        character and second one on entering the correct one. The first "onkeyup" event will fire this 
        function which will reformatt the tel no before the user gets a chace to correct the digit. This 
        will surely confuse the user. The "if" condition below eliminates that.
        */
        if (phone.match (".[0-9]{2}.[0-9]{3}-[0-9]{4}|" + ".[0-9].[0-9]{3}-[0-9]{4}|" +
            ".[0-9]{3}.[0-9]{2}-[0-9]{4}|" + ".[0-9]{3}.[0-9]-[0-9]{4}") == null)
        {
            /*
            You will reach here only if the user is still typing the number or if he/she has 
            messed up already formatted number. 
            */
            var phoneNumeric = phoneChar = "", i;
            // Loop thru what user has entered.
            for (i=0;i<phone.length;i++)
            {
                // Go thru what user has entered one character at a time.
                phoneChar = phone.substr (i,1);
    
                // If that character is not a number or is a White space, ignore it. Only if it is a digit, 
                // concatinate it with a number string.
                if (!isNaN (phoneChar) && (phoneChar != " ")) phoneNumeric = phoneNumeric + phoneChar;
            }
    
            phone = "";
            // At this point, you have picked up only digits from what user has entered. Loop thru it.
            for (i=0;i<phoneNumeric.length;i++)
            {
                // If it's the first digit, throw in "(" before that.
                if (i == 0) phone = phone + "(";
                // If you are on the 4th digit, put ") " before that.
                if (i == 3) phone = phone + ") ";
                // If you are on the 7th digit, insert "-" before that.
                if (i == 6) phone = phone + "-";
                // Add the digit to the phone charatcer string you are building.
                phone = phone + phoneNumeric.substr (i,1)
            }
        }
    }
    else
    { 
        // This means the tel no is in proper format. Make sure by replacing the 0th, 4th and 8th character.
        phone = "(" + phone.substring (1,4) + ") " + phone.substring (5,8) + "-" + phone.substring(9,13); 
    }
    // So far you are working internally. Refresh the screen with the re-formatted value.
    if (phone != telNo.value) telNo.value = phone;
}

/*
CheckTelNo method takes in current element of the form as input. This method should be 
fired as the user attempts to leave the current element in the form (by using onBlur method). 
It checks to see if the format of the phone is "(123) 456-7890".
Eg. <netui:textBox size="13" maxlength="13" onBlur="JavaScript:checkTelNo (this);" onKeyUp="JavaScript:formatTelNo (this);" onKeyDown="JavaScript:formatTelNo (this);"/>  
*/      
function checkTelNo (telNo)
{
    if (telNo.value == "") return;
    if (telNo.value.match (".[0-9]{3}.[0-9]{3}-[0-9]{4}") == null)
    {
        if (telNo.value.match ("[0-9]{10}") != null)
            formatTelNo (telNo)              
    }
}


function formatSSNNo (SSNNo)
{
    // If it's blank, save yourself some trouble by doing nothing.
    if (SSNNo.value == "") return;

    

    var phone = new String (SSNNo.value);
    
    phone = phone.substring(0,11);

    /*
    "." means any character. If you try to use "(" and ")", the regular expression becomes 
    complicated sice both are reserve characters and escaping them sometimes fails. So just 
    use "." for any character and replace it later.
    */
    if (phone.match ("[0-9]{3}-[0-9]{2}-[0-9]{4}") == null)
    {
        /*
        Following "if" is for user making any changes to the formatted tel. no. If you don't put this 
        "if" condition, the user can not correct a digit by first deleting it and then entering a 
        correct one, since this will fire two "onkeyup" events : first one on deleting a 
        character and second one on entering the correct one. The first "onkeyup" event will fire this 
        function which will reformatt the tel no before the user gets a chace to correct the digit. This 
        will surely confuse the user. The "if" condition below eliminates that.
        */
        if (phone.match ("[0-9]{2}-[0-9]{2}-[0-9]{4}|" + "[0-9]-[0-9]{2}-[0-9]{4}|" +
            "[0-9]{3}-[0-9]-[0-9]{4}") == null)
        {
            /*
            You will reach here only if the user is still typing the number or if he/she has 
            messed up already formatted number. 
            */
            var phoneNumeric = phoneChar = "", i;
            // Loop thru what user has entered.
            for (i=0;i<phone.length;i++)
            {
                // Go thru what user has entered one character at a time.
                phoneChar = phone.substr (i,1);
    
                // If that character is not a number or is a White space, ignore it. Only if it is a digit, 
                // concatinate it with a number string.
                if (!isNaN (phoneChar) && (phoneChar != " ")) phoneNumeric = phoneNumeric + phoneChar;
            }
    
            phone = "";
            // At this point, you have picked up only digits from what user has entered. Loop thru it.
            for (i=0;i<phoneNumeric.length;i++)
            {
                // If it's the first digit, throw in "(" before that.
              //  if (i == 0) phone = phone + "(";
                // If you are on the 4th digit, put ") " before that.
                // If you are on the 7th digit, insert "-" before that.
                if (i == 3) phone = phone + "-";
                if (i == 5) phone = phone + "-";
                // Add the digit to the phone charatcer string you are building.
                phone = phone + phoneNumeric.substr (i,1)
            }
        }
    }
    else
    { 
//		alert("asdfa");
// This means the tel no is in proper format. Make sure by replacing the 0th, 4th and 8th character.
//        phone = "" + phone.substring (1,4) + "-" + phone.substring (5,8) + "-" + phone.substring(9,13); 
    }
    // So far you are working internally. Refresh the screen with the re-formatted value.
    if (phone != SSNNo.value) SSNNo.value = phone;
}


function checkSSNNo (SSNNo)
{
    if (SSNNo.value == "") return;
    if (SSNNo.value.match ("[0-9]{3}-[0-9]{2}-[0-9]{4}") == null)
    {
        if (SSNNo.value.match ("[0-9]{9}") != null)
            formatSSNNo (SSNNo)              
    }
}


//==========================================
 //////////////EIN FORMAT//////////////////
//==========================================

function formatEINNo (EINNo)
{
    // If it's blank, save yourself some trouble by doing nothing.
    if (EINNo.value == "") return;

    

    var phone = new String (EINNo.value);
    
    phone = phone.substring(0,10);

    /*
    "." means any character. If you try to use "(" and ")", the regular expression becomes 
    complicated sice both are reserve characters and escaping them sometimes fails. So just 
    use "." for any character and replace it later.
    */
    if (phone.match ("[0-9]{2}-[0-9]{7}") == null)
    {
      
        if (phone.match ("[0-9]{2}-[0-9]{7}|" + "[0-9]-[0-9]{7}") == null)
        {
            /*
            You will reach here only if the user is still typing the number or if he/she has 
            messed up already formatted number. 
            */
            var phoneNumeric = phoneChar = "", i;
            // Loop thru what user has entered.
            for (i=0;i<phone.length;i++)
            {
                // Go thru what user has entered one character at a time.
                phoneChar = phone.substr (i,1);
    
                // If that character is not a number or is a White space, ignore it. Only if it is a digit, 
                // concatinate it with a number string.
                if (!isNaN (phoneChar) && (phoneChar != " ")) phoneNumeric = phoneNumeric + phoneChar;
            }
    
            phone = "";
            // At this point, you have picked up only digits from what user has entered. Loop thru it.
            for (i=0;i<phoneNumeric.length;i++)
            {
                // If it's the first digit, throw in "(" before that.
              //  if (i == 0) phone = phone + "(";
                // If you are on the 4th digit, put ") " before that.
                // If you are on the 7th digit, insert "-" before that.
                if (i == 2) phone = phone + "-";
                // Add the digit to the phone charatcer string you are building.
                phone = phone + phoneNumeric.substr (i,1)
            }
        }
    }
    else
    { 
// This means the tel no is in proper format. Make sure by replacing the 0th, 4th and 8th character.
//        phone = "" + phone.substring (1,4) + "-" + phone.substring (5,8) + "-" + phone.substring(9,13); 
    }
    // So far you are working internally. Refresh the screen with the re-formatted value.
    if (phone != EINNo.value) EINNo.value = phone;
}


function checkEINNo (EINNo)
{
    if (EINNo.value == "") return;
    if (EINNo.value.match ("[0-9]{2}-[0-9]{7}") == null)
    {
        if (EINNo.value.match ("[0-9]{9}") != null)
            formatEINNo (EINNo)              
    }
}




function drawTable(maxlength, tablewidth, tablename)
{
	if ((navigator.appName.indexOf("Microsoft") !=-1) && (parseInt(navigator.appVersion)>= 4))
	{
		var str;
	    str='<table id="box" name="'+maxlength+'" cellpadding="0" cellspacing="0" border="0" width="'+tablewidth+'">';
	    str += '<tr>';
	    str += '<td bgcolor="#003366" width="0"><img src="/images/dot.gif" name="'+tablename+'1" height="5" width="0"></td>';
	    str += '<td bgcolor="#8CAAE6" width="'+tablewidth+'"><img src="/images/dot.gif" name="'+tablename+'2" height="5" width="'+tablewidth+'"></td></tr>';
	    //str += '<tr><td colspan="2"><div><span name=tablename3 style="width:'+tablewidth/2+'px;"></span><span id="'+tablename+'4" style="width:'+tablewidth/2+'px;text-align:right;"></span></div></td></tr>';
	    str += '</table>';
		document.write(str);
	}
	else 
	{
	    document.write(' ');
	}
}

function funMycomment(a){
	obj=document.getElementById('box');
	tblwidth=obj.width;
	maxlen=obj.name;
	var aa
	aa=document.getElementById(a.id);
	x = maxlen - aa.value.length;
	if (x <0)
	{
	    aa.value=aa.value.substring(0,maxlen);
	    x=0;
	    alert('Maximum '+maxlen+' character used');
	}
	
	eval("document."+a.id+"1").width=tblwidth*(maxlen-x)/maxlen;
	eval("document."+a.id+"1").alt=maxlen-x+" chars used";
	eval("document."+a.id+"2").width=tblwidth*x/maxlen;
	eval("document."+a.id+"2").alt=x+" chars available";
	//document.getElementByName("tablename3").innerHTML=maxlen-x+" chars used";
	//document.getElementById("tablename4").innerHTML=x+" chars left";
}

	





function Inint_AJAX() {
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
};




function subcatcontent(catval) {
	var req = Inint_AJAX();
	// alert(req+'-------'+catval);
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			       alert(req.responseText)
			       return req.responseText; 
               } 
          }
     };
     req.open("GET", "catcontent.php?catval="+catval);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); //ส่งค่า
}/* end of code to show subcategory */

function showcityListing(cntID){
	//alert(cntID)
	if(cntID!=''){
		
		var req = Inint_AJAX();
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) { // alert(req.responseText);
				document.getElementById('myCity').innerHTML=""; 
			    document.getElementById('myCity').innerHTML=req.responseText; 
				
               } 
          }
     };
	
     req.open("GET", "citycontent.php?cntID="+cntID);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); 
	}
}


function showstatecitylist(cntID){
		if(cntID!=''){
		
		var req = Inint_AJAX();
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) { 
			    document.getElementById('myState').innerHTML='';
				document.getElementById('myState').innerHTML=req.responseText;
				//alert(document.getElementById('company_state'));
				showcityListing(cntID);
               } 
          }
     };
     req.open("GET", "statecontent.php?cntID="+cntID);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); 
	}
}

function showcostvalue(optionId){
	var req = Inint_AJAX();
     req.onreadystatechange = function (){ 
          if (req.readyState==4) {
               if (req.status==200) {
			     document.getElementById('amount_to_pay').value = req.responseText;	   
			   } 
          }
     };
     req.open("GET", "getcost.php?optionId="+optionId);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
     req.send(null); //ส่งค่า
}


// Validation Form For Company // 

function howMany(compid) {
   var selObj = document.getElementById(compid); 
   var totalChecked = 0;
   for (i = 0; i < selObj.options.length; i++) {
      if (selObj.options[i].selected) {
         totalChecked++;
      }
   }
   if (totalChecked > 0) {
      return true;
	  }else{ 
	  return false;  }
}




function checkuser(username,e_username)
{
	
	var re =  /^[A-Za-z]\w{3,}$/; 
	if(re.test(username))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () {  
          if (req.readyState==4) { 
               if (req.status==200) { 
			   				if(req.responseText==0){
							document.getElementById(e_username).innerHTML = "&nbsp;<font color='#009966'> Username available </font>";	return true;
							}
							if(req.responseText==1){
							document.getElementById(e_username).innerHTML = "&nbsp;<font color='#BC3300'>"+username+" not available </font>";	
							document.getElementById('username').value=''; return false;
							}
			   }
          }
     };
     req.open("GET", "check_username.php?username="+username);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(e_username).innerHTML = "<font color='#BC3300'> Enter valid username </font>";
		return false;
	}
}

function checkuseremail(user_email,e_user_email)
{
	//alert(user_email);
	if(isValidEmailStrict(user_email))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) { //alert(req.responseText);
			   if(req.responseText==0){
							document.getElementById(e_user_email).innerHTML = "&nbsp;<font color='#009966'><b> Email available </b></font>";	return true;
							}
							if(req.responseText==1){
							document.getElementById(e_user_email).innerHTML = "&nbsp;<font color='#BC3300'><b>"+user_email+" not available </b></font>";	
			
							document.getElementById('email').value=''; return false;
							}
			   } 
          }
     };
     req.open("GET", "check_email.php?email="+user_email);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(e_user_email).innerHTML = "<font color='#BC3300'>Please enter a valid email </font>";
		return false;
	}
}



function edituseremail(u_email,e_u_email)
{
	if(isValidEmailStrict(u_email))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) { alert(req.responseText);
			   if(req.responseText==0){
							document.getElementById(e_u_email).innerHTML = "&nbsp;<font color='#009966'> Email available </font>";	return true;
							}
							if(req.responseText==1){
							document.getElementById(e_u_email).innerHTML = "&nbsp;<font color='#BC3300'>"+u_email+" not available </font>";	
							document.getElementById('u_email').value=''; return false;
							}
			   } 
          }
     };
     req.open("GET", "edit_email.php?email="+u_email);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(e_u_email).innerHTML = "&nbsp;<font color='#BC3300'>Please enter a valid email </font>";
		return false;
	}
}

function CheckNumeric(checkStr)
{		//alert(checkStr);
		var checknotOK = "0123456789";
		var allValid = false;
		for (i = 0;  i < checkStr.length;  i++)
		{
			ch = checkStr.charAt(i);
			ch1 = checkStr.charAt(0);
			for (k=0; k < checknotOK.length; k++)
			{
				//alert(ch+"  "+checknotOK.charAt(k));
				if (ch == checknotOK.charAt(k))
				{
					allValid = true;
					break;
				}
				if (k == checknotOK.length)
				{
					 allValid = false;
					 break;
				}
			}
		}// alert(allValid);
		return allValid;
}


function ErrorMsg(msg)
{
		return "<span class='error'><span class='error_msg'>" + msg + "</span></span>";
}
function SuccessMsg(msg)
{
		return "<span class='success'><span class='success_msg'>&nbsp;" + msg + "</span></span>";
}
function trim(str, chars) 
{
    return ltrim(rtrim(str, chars), chars);
}
function ltrim(str, chars) 
{
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
function rtrim(str, chars) 
{
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}


function changecodevalue(ckid){
	document.getElementById(ckid).value='';
	}
function filecidevalue(ckid){
	if(document.getElementById(ckid).value==''){
		document.getElementById(ckid).value='Enter Code';
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function checkvalue(tocheck){
var rest = tocheck.split(' ');
var re =  /^[A-Za-z]/;
var chkrest = true;
	for(var i= 0;i< rest.length ; i++)
		{
			if(!isAlphabetic(rest[i])){
				chkrest = false;
			}
	}
		return chkrest;
	}	


function billingshipping(){
if(document.getElementById('billingship').checked==true)	
	{
		document.getElementById('saddress').value 	= document.getElementById('baddress').value;
		document.getElementById('szip_code').value 	= document.getElementById('bzip_code').value;
		document.getElementById('scity').value 		= document.getElementById('bcity').value;
		document.getElementById('sstate').value 	= document.getElementById('bstate').value;
		document.getElementById('scountry').value 	= document.getElementById('bcountry').value;
	}
	else{
		document.getElementById('saddress').value 	= "";
		document.getElementById('szip_code').value 	= "";
		document.getElementById('scity').value 		= "";
		document.getElementById('sstate').value 	= "";
		document.getElementById('scountry').value 	= "";
	}
	
}

function checkenquiry(frm){
	var	creturn 			= true;
	document.getElementById('e_enquiry').innerHTML			=	'';
	var your_name			=	frm.your_name.value;
	var f_subject			=	frm.f_subject.value;
	var email				=	frm.email.value;
	var address				=	frm.address.value;
	var comment				=	frm.comment.value;
	if(your_name==''){
		document.getElementById('e_enquiry').innerHTML = 'Enter Your Name';
		frm.your_name.focus();
		return false;
	 }
	 if(your_name!='')
	 {
		 if(!checkvalue(your_name)){
		    document.getElementById('e_enquiry').innerHTML = 'Enter Valid  Name';
			frm.your_name.focus();
			return false;
			 }
		 }
	if(f_subject==''){
		document.getElementById('e_enquiry').innerHTML = 'Enter Subject';
		frm.f_subject.focus();
		return false;
	 }
	/* if(f_subject!='')
	 {
		 if(!checkvalue(f_subject)){
		    document.getElementById('e_enquiry').innerHTML = 'Enter Valid Subject';
			frm.f_subject.focus();
			return false;
			 }
		 }*/
	if(email==''){
		document.getElementById('e_enquiry').innerHTML = 'Enter Email';
		frm.email.focus();
		return false;
	    }	
	if(email!='')
	{
		if(!isValidEmailStrict(email)){
			 document.getElementById('e_enquiry').innerHTML = 'Enter valid email id';
			frm.email.focus();
			return false;
			}
	 }	
	if(address==''){
		document.getElementById('e_enquiry').innerHTML = 'Enter Address';
		frm.address.focus();
		return false;
	 } 
	if(comment==''){
		document.getElementById('e_enquiry').innerHTML = 'Enter Comment';
		frm.comment.focus();
		return false;
	 }  
	return creturn;	 
}


function registervalidation(frm){
	var	creturn 			= true;
	var re =  /^[A-Za-z]\w{3,}$/; 
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var pattern = /[^a-zA-Z'\s]$/;

	document.getElementById('detail_error').innerHTML			=	'';
	document.getElementById('baddress_error').innerHTML			=	'';
	document.getElementById('contact_error').innerHTML			=	'';
	document.getElementById('saddress_error').innerHTML			=	'';
	document.getElementById('login_detail_error').innerHTML		=	'';
	document.getElementById('showmsge').innerHTML		=	'';
	var title			=	frm.title.value;
	var f_name			=	frm.f_name.value;
	var l_name			=	frm.l_name.value;
	var baddress		=	frm.baddress.value;
	var bzip_code		=	frm.bzip_code.value;
	var bcity			=	frm.bcity.value;
	var bstate			=	frm.bstate.value;
	var bcountry		=	frm.bcountry.value;
	var phone			=	frm.phone.value;
	var fax				=	frm.fax.value;
	var saddress		=	frm.saddress.value;
	var szip_code		=	frm.szip_code.value;
	var scity			=	frm.scity.value;
	var sstate			=	frm.sstate.value;	
	var scountry		=	frm.scountry.value;
	var email			=	frm.email.value;
	var pass			=	frm.pass.value;
	var c_pass			=	frm.c_pass.value;
	var security_codere	=	frm.security_codere.value;
	
	 if(title==''){
		document.getElementById('detail_error').innerHTML = 'Select Title First';
		frm.title.focus();
		return false;
	 }
	 
 	 if(f_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter First Name';
		frm.f_name.focus();
		return false;
	 }
	 if(f_name!='')
	 {
		 if(!checkvalue(f_name)){
		    document.getElementById('detail_error').innerHTML = 'Enter Valid First Name';
			frm.f_name.focus();
			return false;
			 }
		 }
	  if(l_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter Last Name';
		frm.l_name.focus();
		return false;
	    }
   	  if(l_name!='')
	  {
		  if(!checkvalue(l_name)){
			document.getElementById('detail_error').innerHTML = 'Enter Valid Last Name';
			frm.l_name.focus();
			return false;
				 }
		 }	 
	  if(baddress==''){
		document.getElementById('baddress_error').innerHTML = 'Enter Billing Address';
		frm.baddress.focus();
		return false;
	    }
		
		if(bzip_code==''){
		document.getElementById('baddress_error').innerHTML = 'Enter Post Code';
		frm.bzip_code.focus();
		return false;
	    }
	 if(bzip_code!='')
	  {
		 if(!isAlphanumeric(bzip_code)){
		    document.getElementById('baddress_error').innerHTML = 'Enter Valid Post Code';
			frm.bzip_code.focus();
			return false;
			 }
		 }
	if(bcity==''){
		document.getElementById('baddress_error').innerHTML = 'Enter City';
		frm.bcity.focus();
		return false;
	    }
   	  if(bcity!='')
	  {
		  if(!checkvalue(bcity)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid City';
			frm.bcity.focus();
			return false;
				 }
		 }	 
	if(bstate==''){
		document.getElementById('baddress_error').innerHTML = 'Enter State';
		frm.bstate.focus();
		return false;
	    }
   	  if(bstate!='')
	  {
		  if(!checkvalue(bstate)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid State';
			frm.bstate.focus();
			return false;
				 }
		 }	
	if(bcountry==''){
		document.getElementById('baddress_error').innerHTML = 'Select Country';
		frm.bcountry.focus();
		return false;
	    }
	 if(phone==''){
		document.getElementById('contact_error').innerHTML = 'Enter Phone Number';
		frm.phone.focus();
		return false;
	    }
		
	 /*if(fax==''){
		document.getElementById('contact_error').innerHTML = 'Enter Fax';
		frm.fax.focus();
		return false;
	    }*/
		
	 if(saddress==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Shipping Address';
		frm.saddress.focus();
		return false;
	    }
		
		if(szip_code==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Post Code';
		frm.szip_code.focus();
		return false;
	    }
	 if(szip_code!='')
	  {
		 if(!isAlphanumeric(szip_code)){
		    document.getElementById('saddress_error').innerHTML = 'Enter Valid Post Code';
			frm.szip_code.focus();
			return false;
			 }
		 }
	if(scity==''){
		document.getElementById('saddress_error').innerHTML = 'Enter City';
		frm.scity.focus();
		return false;
	    }
   	  if(scity!='')
	  {
		  if(!checkvalue(scity)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid City';
			frm.scity.focus();
			return false;
				 }
		 }	 
	if(sstate==''){
		document.getElementById('saddress_error').innerHTML = 'Enter State';
		frm.sstate.focus();
		return false;
	    }
   	  if(sstate!='')
	  {
		  if(!checkvalue(sstate)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid State';
			frm.sstate.focus();
			return false;
				 }
		 }	
	if(scountry==''){
		document.getElementById('saddress_error').innerHTML = 'Select Country';
		frm.scountry.focus();
		return false;
	    }
		
	if(email==''){
		document.getElementById('login_detail_error').innerHTML = 'Enter Email';
		frm.email.focus();
		return false;
	    }	
	if(email!='')
	{
		if(!isValidEmailStrict(email)){
			 document.getElementById('login_detail_error').innerHTML = 'Enter valid email id';
			frm.email.focus();
			return false;
			}
	 }
	if(pass==''){
		document.getElementById('login_detail_error').innerHTML = 'Enter Password';
		frm.pass.focus();
		return false;
	    }
	 if(pass!='')
	 {
		  if(!re2.test(pass)){
		  document.getElementById('login_detail_error').innerHTML = 'Enter Valid Password (Must Be Of 8 Character)';
			frm.pass.focus();
		    return false;
			 }
	 }
	if(c_pass==''){
		document.getElementById('login_detail_error').innerHTML = 'Enter Confirm Password';
		frm.c_pass.focus();
		return false;
	    }
	if(c_pass!='')
		{
		  if(pass!=c_pass){
			document.getElementById('login_detail_error').innerHTML = 'Password not matched';
			frm.c_pass.focus();
			return false;
			}
	 }
   if(security_codere=='')
	{
		document.getElementById('login_detail_error').innerHTML = 'Enter Security Code';
		frm.security_codere.focus();
		return false;
	}

 
	//alert(creturn);
	return creturn;
	
}



function editregisternye(frm){
	
	var	creturn 			= true;
	var re =  /^[A-Za-z]\w{3,}$/; 
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var pattern = /[^a-zA-Z'\s]$/;

	document.getElementById('detail_error').innerHTML			=	'';
	document.getElementById('baddress_error').innerHTML			=	'';
	document.getElementById('saddress_error').innerHTML			=	'';
	var title			=	frm.title.value;
	var f_name			=	frm.f_name.value;
	var l_name			=	frm.l_name.value;
	var phone			=	frm.phone.value;
	var fax				=	frm.fax.value;
	var baddress		=	frm.baddress.value;
	var bzip_code		=	frm.bzip_code.value;
	var bcity			=	frm.bcity.value;
	var bstate			=	frm.bstate.value;
	var bcountry		=	frm.bcountry.value;	
	var saddress		=	frm.saddress.value;
	var szip_code		=	frm.szip_code.value;
	var scity			=	frm.scity.value;
	var sstate			=	frm.sstate.value;	
	var scountry		=	frm.scountry.value;
	
	
	 if(title==''){
		document.getElementById('detail_error').innerHTML = 'Select Title First';
		frm.title.focus();
		return false;
	 }
	 
 	 if(f_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter First Name';
		frm.f_name.focus();
		return false;
	 }
	 if(f_name!='')
	 {
		 if(!checkvalue(f_name)){
		    document.getElementById('detail_error').innerHTML = 'Enter Valid First Name';
			frm.f_name.focus();
			return false;
			 }
		 }
	  if(l_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter Last Name';
		frm.l_name.focus();
		return false;
	    }
   	  if(l_name!='')
	  {
		  if(!checkvalue(l_name)){
			document.getElementById('detail_error').innerHTML = 'Enter Valid Last Name';
			frm.l_name.focus();
			return false;
				 }
		 }
	 if(phone==''){
		document.getElementById('detail_error').innerHTML = 'Enter Phone Number';
		frm.phone.focus();
		return false;
	    }
		
	 if(fax==''){
		document.getElementById('detail_error').innerHTML = 'Enter Fax';
		frm.fax.focus();
		return false;
	    }	 
	  if(baddress==''){
		document.getElementById('baddress_error').innerHTML = 'Enter Billing Address';
		frm.baddress.focus();
		return false;
	    }
		
		
		if(bcity==''){
		document.getElementById('baddress_error').innerHTML = 'Enter City';
		frm.bcity.focus();
		return false;
	    }
   	   if(bcity!='')
	   {
		  if(!checkvalue(bcity)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid City';
			frm.bcity.focus();
			return false;
				 }
		 }
		 
		if(bstate==''){
		document.getElementById('baddress_error').innerHTML = 'Enter State';
		frm.bstate.focus();
		return false;
	    }
   	  if(bstate!='')
	  {
		  if(!checkvalue(bstate)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid State';
			frm.bstate.focus();
			return false;
				 }
		 }	
	 if(bzip_code==''){
	   	 document.getElementById('baddress_error').innerHTML = 'Enter Post Code';
		 frm.bzip_code.focus();
	 	 return false;
	    }
	  if(bzip_code!='')
	   {
		 if(!isAlphanumeric(bzip_code)){
		    document.getElementById('baddress_error').innerHTML = 'Enter Valid Post Code';
			frm.bzip_code.focus();
			return false;
			 }
		 }	 
	if(bcountry==''){
		document.getElementById('baddress_error').innerHTML = 'Select Country';
		frm.bcountry.focus();
		return false;
	    } 
	
	 if(saddress==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Shipping Address';
		frm.saddress.focus();
		return false;
	    }
		
		
		
	if(scity==''){
		document.getElementById('saddress_error').innerHTML = 'Enter City';
		frm.scity.focus();
		return false;
	    }	 
	
   	  if(scity!='')
	  {
		  if(!checkvalue(scity)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid City';
			frm.scity.focus();
			return false;
				 }
		 }	 
	if(sstate==''){
		document.getElementById('saddress_error').innerHTML = 'Enter State';
		frm.sstate.focus();
		return false;
	    }
   	  if(sstate!='')
	  {
		  if(!checkvalue(sstate)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid State';
			frm.sstate.focus();
			return false;
				 }
		 }
	if(szip_code==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Post Code';
		frm.szip_code.focus();
		return false;
	    } 
	 if(szip_code!='')
	  {
		 if(!isAlphanumeric(szip_code)){
		    document.getElementById('saddress_error').innerHTML = 'Enter Valid Post Code';
			frm.szip_code.focus();
			return false;
			 }
		 }
	
	if(scountry==''){
		document.getElementById('saddress_error').innerHTML = 'Select Country';
		frm.scountry.focus();
		return false;
	    }
		
	
	
	
	
	
	
   

 
	//alert(creturn);
	return creturn;
	
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////

function validatecompany(frm){
	var creturn = true
	document.getElementById('page_name_error').innerHTML				=	'';
	document.getElementById('page_meta_title_error').innerHTML			=	'';
	document.getElementById('page_meta_keywords_error').innerHTML		=	'';
	document.getElementById('page_meta_description_error').innerHTML	=	'';
	document.getElementById('page_text_error').innerHTML				=	'';
	

	
	
	/* 	Variable to validate		*/
	var page_name				=	frm.page_name.value;
	var page_meta_title			=	frm.page_meta_title.value;
	var page_meta_keywords		=	frm.page_meta_keywords.value;
	var page_meta_description	=	frm.page_meta_description.value;
	//var page_text				=	frm.page_text;
	

	
	if(page_name==''){
		document.getElementById('page_name_error').innerHTML = '<font color="#BC3300">Enter page name</font>';
		creturn						=	false;
	 }
	
	
	 
	 if(page_meta_title==''){
		document.getElementById('page_meta_title_error').innerHTML = '<font color="#BC3300">Enter page title</font>';
		creturn						=	false;
	 }
	
	
	 
	 
	  if(page_meta_keywords==''){
		document.getElementById('page_meta_keywords_error').innerHTML = '<font color="#BC3300">Enter page meta keywords</font>';
		creturn						=	false;
	 }
	 
	  if(page_meta_description==''){
		document.getElementById('page_meta_description_error').innerHTML = '<font color="#BC3300">Enter page meta description</font>';
		creturn						=	false;
	 }

	return creturn;
	
}

function validate(frm)
{
	var creturn = true;
	document.getElementById('e_paypal_account').innerHTML ='';
	document.getElementById('e_paypal_url').innerHTML ='';
	document.getElementById('e_paypal_test_account').innerHTML ='';
	document.getElementById('e_paypal_test_url').innerHTML ='';
	var paypal_account		=	frm.paypal_account.value;
	var paypal_url			=	frm.paypal_url.value;
	var paypal_test_account	=	frm.paypal_test_account.value;
	var paypal_test_url		=	frm.paypal_test_url.value;
	if(paypal_account==''){
		document.getElementById('e_paypal_account').innerHTML = '<font color="#BC3300">Enter paypal account</font>';
		creturn						=	false;
	 }
	 
	 if(paypal_url==''){
		document.getElementById('e_paypal_url').innerHTML = '<font color="#BC3300">Enter paypal url</font>';
		creturn						=	false;
	 }
	 
	 if(paypal_test_account==''){
		document.getElementById('e_paypal_test_account').innerHTML = '<font color="#BC3300">Enter test paypal account</font>';
		creturn						=	false;
	 }
	 
	 if(paypal_test_url==''){
		document.getElementById('e_paypal_test_url').innerHTML = '<font color="#BC3300">Enter test paypal url</font>';
		creturn						=	false;
	 }
	 
	 return creturn;
}


function registerationcheck(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	document.getElementById('e_username').innerHTML 			='';
	document.getElementById('e_u_password').innerHTML			='';
	document.getElementById('e_conf_password').innerHTML 		='';
	document.getElementById('e_f_name').innerHTML 				='';
	document.getElementById('e_l_name').innerHTML				='';
	document.getElementById('e_u_email').innerHTML				='';
	document.getElementById('e_u_phone').innerHTML 				='';
	document.getElementById('e_billing_address').innerHTML 	    ='';
	document.getElementById('e_actual_address').innerHTML 	    ='';
	document.getElementById('e_u_city').innerHTML 	   			='';
	document.getElementById('e_u_state').innerHTML 	  			='';
	document.getElementById('e_u_country').innerHTML 	  		='';
	document.getElementById('e_u_house_number').innerHTML  		='';
	document.getElementById('e_ship_address').innerHTML  		='';
	document.getElementById('e_ship_postal').innerHTML  		='';
	document.getElementById('e_ship_state').innerHTML  			='';
	document.getElementById('e_ship_city').innerHTML			='';	
	document.getElementById('e_ship_country').innerHTML  		='';
	document.getElementById('e_postal_code').innerHTML			='';
	
	
	var username					=	frm.username.value;	
	var u_password					=	frm.u_password.value;	
	var conf_password				=	frm.conf_password.value;	
	var f_name						=	frm.f_name.value;	
	var l_name						=	frm.l_name.value;	
	var u_email						=	frm.u_email.value; //alert(u_email);
	var u_phone						=	frm.u_phone.value;
	var billing_address				=	frm.billing_address.value;
	var postal_code					=	frm.postal_code.value;
	var actual_address				=	frm.actual_address.value;
	var u_city						=	frm.u_city.value;
	var u_state						=	frm.u_state.value;
	var u_country					=	frm.u_country.value;	
	var u_house_number				=	frm.u_house_number.value;
	var ship_address				=	frm.ship_address.value;
	var ship_postal					=	frm.ship_postal.value;
	var	ship_city					=	frm.ship_city.value;
	var ship_state					=	frm.ship_state.value;
	var ship_country				=	frm.ship_country.value;
	if(username==''){
		document.getElementById('e_username').innerHTML 		= '<font color="#BC3300">&nbsp;Enter username</font>';
		creturn						=	false;
	 }
	 
	 if(u_password==''){
		document.getElementById('e_u_password').innerHTML 		= '<font color="#BC3300">&nbsp;Enter password</font>';
		creturn						=	false;
	 }
	 if(u_password!=''){
			 if(!re2.test(u_password)){
				document.getElementById('e_u_password').innerHTML = '<font color="#BC3300">Enter valid password (must be of 8 character)</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(conf_password==''){
		document.getElementById('e_conf_password').innerHTML    = '<font color="#BC3300">&nbsp;Enter confirm password</font>';
		creturn						=	false;
	 }
	 
	  if(conf_password!=''){
			  if(u_password!=conf_password){
				document.getElementById('e_conf_password').innerHTML = '<font color="#BC3300">Password not matched</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	   if(u_email==''){
		document.getElementById('e_u_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(u_email!=''){
		if(!isValidEmailStrict(u_email)){
		  document.getElementById('e_u_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	 
	  if(u_phone==''){
		document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }
	 /* if(u_phone!=''){
		  if(!CheckNumeric(u_phone)){
				document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
				creturn						=	false;
		  }
	 }*/
	 
	 
	if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number </font>';
		creturn						=	false;
	 }
	 
	/* if(billing_address!=''){
		if(!isAlphabetic(billing_address)) {
			document.getElementById('e_billing_address').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }*/
	 
	  if(actual_address==''){
		document.getElementById('e_actual_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing address</font>';
		creturn						=	false;
	 }
	 
	
	 
	 
	if(postal_code==''){
		document.getElementById('e_postal_code').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code </font>';
		creturn						=	false;
	 } 
  if(postal_code!=''){
		if(!isAlphanumeric(postal_code)) {
			document.getElementById('e_postal_code').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_city==''){
		document.getElementById('e_u_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter state </font>';
		creturn						=	false;
	 }
	 
	 if(u_city!=''){
		if(!isAlphabetic(u_city)) {
			document.getElementById('e_u_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_state==''){
		document.getElementById('e_u_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(u_state!=''){
		if(!isAlphabetic(u_state)) {
			document.getElementById('e_u_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_country==''){
		document.getElementById('e_u_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 if(u_house_number==''){
		document.getElementById('e_u_house_number').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number</font>';
		creturn						=	false;
	 }
	 
	 /*  if(u_house_number!=''){
		if(!isAlphanumeric(u_house_number)) {
			document.getElementById('e_u_house_number').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }*/
	 
	 if(ship_address==''){
		document.getElementById('e_ship_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter ship address</font>';
		creturn						=	false;
	 }
	 
	 
	 
	 if(ship_postal==''){
		document.getElementById('e_ship_postal').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code</font>';
		creturn						=	false;
	 }
	 
	 if(ship_postal!=''){
		if(!isAlphanumeric(ship_postal)) {
			document.getElementById('e_ship_postal').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_city==''){
		document.getElementById('e_ship_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 } 
	 
	 if(ship_city!=''){
		if(!isAlphabetic(ship_city)) {
			document.getElementById('e_ship_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_state==''){
		document.getElementById('e_ship_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(ship_state!=''){
		if(!isAlphabetic(ship_state)) {
			document.getElementById('e_ship_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(ship_country==''){
		document.getElementById('e_ship_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 
	 return creturn;
}

function validatefaq(frm){
	
	var creturn = true;
	document.getElementById('faq_question_error').innerHTML  		='';
	var faq_question	=	frm.faq_question.value;
	 if(faq_question==''){
		document.getElementById('faq_question_error').innerHTML  = '<font color="#BC3300">&nbsp;Enter question first</font>';
		creturn						=	false;
	 }
	
	return creturn;
	
}

function new_captcha()
{
var c_currentTime = new Date();
var c_miliseconds = c_currentTime.getTime();

document.getElementById('captcha').src = 'imageC.php?x='+ c_miliseconds;
}

function samplevalidation(frm){
	var creturn = true;
	document.getElementById('e_request_fname').innerHTML 				= 	'';
	document.getElementById('e_request_lname').innerHTML 				= 	'';
	document.getElementById('e_request_companyname').innerHTML 			= 	'';
	document.getElementById('e_request_email').innerHTML 				= 	'';	
	
	document.getElementById('e_request_address').innerHTML 				= 	'';
	document.getElementById('e_request_city').innerHTML 				= 	'';
	document.getElementById('e_request_state').innerHTML 				= 	'';
	document.getElementById('e_request_country').innerHTML 				= 	'';
	document.getElementById('e_request_pcode').innerHTML 				= 	'';
	document.getElementById('e_request_phone').innerHTML 				= 	'';
	document.getElementById('e_request_query').innerHTML 				= 	'';
	document.getElementById('e_security_codee').innerHTML 				= 	'';
	
	
	var request_fname													=	frm.request_fname.value;
	var request_lname													=	frm.request_lname.value;
	var request_companyname												=	frm.request_companyname.value;
	var request_email													=   frm.request_email.value;
	var request_address													=	frm.request_address.value;
	var request_city														=	frm.request_city.value;
	var request_state													=	frm.request_state.value;
	var request_country													=	frm.request_country.value;
	var request_pcode													=	frm.request_pcode.value;
	var request_phone													=	frm.request_phone.value;
	var request_query													=	frm.request_query.value;
    var security_codee													=	frm.security_codee.value
	
	if(request_fname==""){
		document.getElementById('e_request_fname').innerHTML = '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	if(!isAlphabetic(request_fname)){
		document.getElementById('e_request_fname').innerHTML = '<font color="#BC3300">Enter valid first name</font>';
		creturn						=	false;
	 }
	 
	 if(request_lname==""){
		document.getElementById('e_request_lname').innerHTML = '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	if(!isAlphabetic(request_lname)){
		document.getElementById('e_request_lname').innerHTML = '<font color="#BC3300">Enter valid last name</font>';
		creturn						=	false;
	 }
  
  
   if(request_companyname==''){
		document.getElementById('e_request_companyname').innerHTML = '<font color="#BC3300">&nbsp;Enter company name</font>';
		creturn						=	false;
	 }
	 
	
	if(!isAlphabetic(request_companyname)){
		document.getElementById('e_request_companyname').innerHTML = '<font color="#BC3300">&nbsp;Enter valid company name</font>';
		creturn						=	false;
	 }

  
   if(request_email==''){
		document.getElementById('e_request_email').innerHTML = '<font color="#BC3300">&nbsp;Enter company email id</font>';
		creturn						=	false;
	 }
	 
	 if(request_email!=''){
		if(!isValidEmailStrict(request_email)){
		  document.getElementById('e_request_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	
	 if(request_address==''){
		document.getElementById('e_request_address').innerHTML = '<font color="#BC3300">&nbsp;Enter address</font>';
		creturn						=	false;
	 }
	
	if(request_city==''){
		document.getElementById('e_request_city').innerHTML = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(request_city)){
		document.getElementById('e_request_city').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city</font>';
		creturn						=	false;
	 }
	if(request_state==''){
		document.getElementById('e_request_state').innerHTML = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(request_state)){
		document.getElementById('e_request_state').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state</font>';
		creturn						=	false;
	 }

	if(request_country==''){
		document.getElementById('e_request_country').innerHTML = '<font color="#BC3300">&nbsp;Selct country</font>';
		creturn						=	false;
	 }
	
	if(request_pcode==''){
		document.getElementById('e_request_pcode').innerHTML = '<font color="#BC3300">&nbsp;Enter pin code</font>';
		creturn						=	false;
	 }
		
	if(!isAlphanumeric(request_pcode)){
		document.getElementById('e_request_pcode').innerHTML = '<font color="#BC3300">&nbsp;Enter valid pin code</font>';
		creturn						=	false;
	 }
	 
	 if(request_phone==''){
		document.getElementById('e_request_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter phone number</font>';
		
		creturn						=	false;
	 }
		
	if(!isNumeric(request_phone)){
		document.getElementById('e_request_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
		creturn						=	false;
	 }
	 
	 if(request_query==''){
		document.getElementById('e_request_query').innerHTML = '<font color="#BC3300">&nbsp;Enter query</font>';
		creturn						=	false;
	 }
	 
	  if(security_codee==''){
		document.getElementById('e_security_codee').innerHTML = '<font color="#BC3300">&nbsp;Enter security code</font>';
		creturn						=	false;
	 }
	 
	 
	return creturn ;
	
}


function checkinquiry(frm)
{
	var creturn = true;
	document.getElementById('e_fname').innerHTML 				= 	'';
	document.getElementById('e_lname').innerHTML 				= 	'';
	document.getElementById('e_email').innerHTML 				= 	'';
	document.getElementById('e_phone').innerHTML 				= 	'';	
	document.getElementById('e_address').innerHTML 				= 	'';
	document.getElementById('e_zipcode').innerHTML 				= 	'';
	document.getElementById('e_city').innerHTML 				= 	'';
	document.getElementById('e_state').innerHTML 				= 	'';
	document.getElementById('e_country').innerHTML 				= 	'';country
	document.getElementById('e_comment').innerHTML 				= 	'';
	document.getElementById('e_security_code_re').innerHTML 	= 	'';
	
	var fname													=	frm.fname.value;
	var lname													=	frm.lname.value;
	var email													=   frm.email.value;
	var phone													=	frm.phone.value;
	var address													=	frm.address.value;
	var zipcode													=	frm.zipcode.value;
	var city													=	frm.city.value;
	var state													=	frm.state.value;
	var country													=	frm.country.value;
	var comment													=	frm.comment.value;
	var security_code_re										=   frm.security_code_re.value;
	if(fname==""){
		document.getElementById('e_fname').innerHTML = '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	if(!isAlphabetic(fname)){
		document.getElementById('e_fname').innerHTML = '<font color="#BC3300">Enter valid first name</font>';
		creturn						=	false;
	 }
	 
	 if(lname==""){
		document.getElementById('e_lname').innerHTML = '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	if(!isAlphabetic(lname)){
		document.getElementById('e_lname').innerHTML = '<font color="#BC3300">Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(email==''){
		document.getElementById('e_email').innerHTML = '<font color="#BC3300">&nbsp;Enter company email id</font>';
		creturn						=	false;
	 }
	 
	 if(email!=''){
		if(!isValidEmailStrict(email)){
		  document.getElementById('e_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	 
	 if(phone==''){
		document.getElementById('e_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter phone number</font>';
		
		creturn						=	false;
	 }
		
	if(!isNumeric(phone)){
		document.getElementById('e_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
		creturn						=	false;
	 }
	 
	  if(address==''){
		document.getElementById('e_address').innerHTML = '<font color="#BC3300">&nbsp;Enter address</font>';
		
		creturn						=	false;
	 }
	 
	 
	 if(zipcode==''){
		document.getElementById('e_zipcode').innerHTML = '<font color="#BC3300">&nbsp;Enter post code</font>';
		creturn						=	false;
	 }
		
	if(!isAlphanumeric(zipcode)){
		document.getElementById('e_zipcode').innerHTML = '<font color="#BC3300">&nbsp;Enter valid post code</font>';
		creturn						=	false;
	 }
	 
	 if(city==''){
		document.getElementById('e_city').innerHTML = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(city)){
		document.getElementById('e_city').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city</font>';
		creturn						=	false;
	 }
	 
	 if(state==''){
		document.getElementById('e_state').innerHTML = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(state)){
		document.getElementById('e_state').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state</font>';
		creturn						=	false;
	 }
	 
	  if(country==''){
		document.getElementById('e_country').innerHTML = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 if(comment==''){
		document.getElementById('e_comment').innerHTML = '<font color="#BC3300">&nbsp;Enter comment </font>';
		creturn						=	false;
	 }
	 
	  if(security_code_re==''){
		document.getElementById('e_security_code_re').innerHTML = '<font color="#BC3300">&nbsp;Enter security code </font>';
		creturn						=	false;
	 }
	 return creturn;
	 
}


function Checklogindetail(frm){
	//alert(frm);
	document.getElementById('errorM').innerHTML 		= 	'';
	var loginemail   							=  frm.loginemail.value;
	var loginpass								=  frm.loginpass.value;
	if(loginemail=='')
		{
			document.getElementById('errorM').innerHTML = 'Enter login email';	
			document.getElementById('loginemail').focus(); //alert(false);
			return false;
		}
	 if(loginemail!=''){
		if(!isValidEmailStrict(loginemail)){
		 	 document.getElementById('errorM').innerHTML = 'Enter valid email';
			 document.getElementById('loginemail').focus(); //alert(false);
			 return false;
			 }
	 }	
	if(loginpass=='')
		{
			document.getElementById('errorM').innerHTML = 'Enter password';
			document.getElementById('loginpass').focus();	// alert(false);
			return false;
		}
	
	return true;	
	
}



function editregister(frm){
	//alert('Called Return False;'); return false;
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	
	document.getElementById('e_f_name').innerHTML 								=	'';
	document.getElementById('e_l_name').innerHTML 								=	'';
	document.getElementById('e_user_phone').innerHTML 							=	'';
	document.getElementById('e_billing_address').innerHTML 						=	'';
	document.getElementById('e_billing_city').innerHTML 						=	'';
	document.getElementById('e_billing_state').innerHTML 						=	'';
	document.getElementById('e_billing_country').innerHTML 						=	'';
	document.getElementById('e_billing_zipcode').innerHTML 						=	'';
	document.getElementById('e_shipping_address').innerHTML 					=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_city').innerHTML 						=	'';
	document.getElementById('e_shipping_state').innerHTML 						=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_zipcode').innerHTML 					=	'';

	
	
	var f_name								=	frm.f_name.value;	
	var l_name								=	frm.l_name.value;
	var user_phone							=	frm.user_phone.value
	var billing_address						=	frm.billing_address.value;	
	var billing_city						=	frm.billing_city.value;
	var billing_state						=	frm.billing_state.value
	var billing_country						=	frm.billing_country.value;	
	var billing_zipcode						=	frm.billing_zipcode.value;
	var shipping_address					=	frm.shipping_address.value
	var shipping_city						=	frm.shipping_city.value;	
	var shipping_state						=	frm.shipping_state.value;
	var shipping_country					=	frm.shipping_country.value

	var shipping_zipcode					=	frm.shipping_zipcode.value;	

	
	 if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 if(user_phone==''){
		document.getElementById('e_user_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }	  
	 
	  if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter billing address</font>'; 
		creturn						=	false;
	 }	  
	 
	  if(billing_city==''){
		document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing city first </font>';
		creturn						=	false;
	 }
	 
	 if(billing_city!=''){
			if(!isAlphabetic(billing_city)) {
			document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(billing_state==''){
		document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing state first</font>';
		creturn						=	false;
	 }
	 
	 if(billing_state!=''){
			if(!isAlphabetic(billing_state)) {
			document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(billing_country==''){
		document.getElementById('e_billing_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select billing country</font>';
		creturn						=	false;
	 }	 
	 
	 if(billing_zipcode==''){
		document.getElementById('e_billing_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing zip code</font>';
		//alert(document.getElementById('e_billing_zipcode').innerHTML+'----'+billing_zipcode);
		creturn						=	false;
	 }
	 
	 if(billing_zipcode!=''){
		if(!isAlphanumeric(billing_zipcode)) {
			document.getElementById('e_billing_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid billing zip code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	
	 if(shipping_address==''){
		document.getElementById('e_shipping_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter shipping address</font>';
		creturn						=	false;
	 }	  
	 
	  if(shipping_city==''){
		document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping city first </font>';
		creturn						=	false;
	 }
	 
	 if(shipping_city!=''){
			if(!isAlphabetic(shipping_city)) {
			document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(shipping_state==''){
		document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping state first</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_state!=''){
			if(!isAlphabetic(shipping_state)) {
			document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(shipping_country==''){
		document.getElementById('e_shipping_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select shipping country</font>';
		creturn						=	false;
	 }	 
	 
	 if(shipping_zipcode==''){
		document.getElementById('e_shipping_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter shipping zip code</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_zipcode!=''){
		if(!isAlphanumeric(shipping_zipcode)) {
			document.getElementById('e_shipping_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid shipping zip code</font>';				
			creturn						=	false;
	 					}
	 }

	return creturn;	  

}


function editaccount(frm){

	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	//document.getElementById('e_username').innerHTML 			='';
	//document.getElementById('e_u_password').innerHTML			='';
	//document.getElementById('e_conf_password').innerHTML 		='';
	document.getElementById('e_f_name').innerHTML 				='';
	document.getElementById('e_l_name').innerHTML				='';
	document.getElementById('e_u_email').innerHTML				='';
	document.getElementById('e_u_phone').innerHTML 				='';
	document.getElementById('e_billing_address').innerHTML 	    ='';
	document.getElementById('e_actual_address').innerHTML 	    ='';
	document.getElementById('e_u_city').innerHTML 	   			='';
	document.getElementById('e_u_state').innerHTML 	  			='';
	document.getElementById('e_u_country').innerHTML 	  		='';
	document.getElementById('e_u_house_number').innerHTML  		='';
	document.getElementById('e_ship_address').innerHTML  		='';
	document.getElementById('e_ship_postal').innerHTML  		='';
	document.getElementById('e_ship_state').innerHTML  			='';
	document.getElementById('e_ship_city').innerHTML			='';	
	document.getElementById('e_ship_country').innerHTML  		='';
	document.getElementById('e_postal_code').innerHTML			='';
	
	
	//var username					=	frm.username.value;	
	//var u_password					=	frm.u_password.value;	
	//var conf_password				=	frm.conf_password.value;	
	var f_name						=	frm.f_name.value;	
	var l_name						=	frm.l_name.value;	
	var u_email						=	frm.u_email.value; //alert(u_email);
	var u_phone						=	frm.u_phone.value;
	var billing_address				=	frm.billing_address.value;
	var postal_code					=	frm.postal_code.value;
	var actual_address				=	frm.actual_address.value;
	var u_city						=	frm.u_city.value;
	var u_state						=	frm.u_state.value;
	var u_country					=	frm.u_country.value;	
	var u_house_number				=	frm.u_house_number.value;
	var ship_address				=	frm.ship_address.value;
	var ship_postal					=	frm.ship_postal.value;
	var	ship_city					=	frm.ship_city.value;
	var ship_state					=	frm.ship_state.value;
	var ship_country				=	frm.ship_country.value;
	/*if(username==''){
		document.getElementById('e_username').innerHTML 		= '<font color="#BC3300">&nbsp;Enter username</font>';
		creturn						=	false;
	 }
	 
	 if(u_password==''){
		document.getElementById('e_u_password').innerHTML 		= '<font color="#BC3300">&nbsp;Enter password</font>';
		creturn						=	false;
	 }
	 if(u_password!=''){
			 if(!re2.test(u_password)){
				document.getElementById('e_u_password').innerHTML = '<font color="#BC3300">Enter valid password (must be of 8 character)</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(conf_password==''){
		document.getElementById('e_conf_password').innerHTML    = '<font color="#BC3300">&nbsp;Enter confirm password</font>';
		creturn						=	false;
	 }
	 
	  if(conf_password!=''){
			  if(u_password!=conf_password){
				document.getElementById('e_conf_password').innerHTML = '<font color="#BC3300">Password not matched</font>';
				creturn						=	false;
			 }
	 }
	 */
	  if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	   if(u_email==''){
		document.getElementById('e_u_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(u_email!=''){
		if(!isValidEmailStrict(u_email)){
		  document.getElementById('e_u_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	 
	  if(u_phone==''){
		document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }
	  if(u_phone!=''){
		  if(!CheckNumeric(u_phone)){
				document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
				creturn						=	false;
		  }
	 }
	 
	 
	if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number </font>';
		creturn						=	false;
	 }
	 
	 if(billing_address!=''){
		if(!isAlphanumeric(billing_address)) {
			document.getElementById('e_billing_address').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(actual_address==''){
		document.getElementById('e_actual_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing address</font>';
		creturn						=	false;
	 }
	 
	
	 
	 
	if(postal_code==''){
		document.getElementById('e_postal_code').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code </font>';
		creturn						=	false;
	 } 
  if(postal_code!=''){
		if(!isAlphanumeric(postal_code)) {
			document.getElementById('e_postal_code').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_city==''){
		document.getElementById('e_u_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter state </font>';
		creturn						=	false;
	 }
	 
	 if(u_city!=''){
		if(!isAlphabetic(u_city)) {
			document.getElementById('e_u_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_state==''){
		document.getElementById('e_u_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(u_state!=''){
		if(!isAlphabetic(u_state)) {
			document.getElementById('e_u_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_country==''){
		document.getElementById('e_u_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 if(u_house_number==''){
		document.getElementById('e_u_house_number').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number</font>';
		creturn						=	false;
	 }
	 
	   if(u_house_number!=''){
		if(!isAlphanumeric(u_house_number)) {
			document.getElementById('e_u_house_number').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }
	 
	 if(ship_address==''){
		document.getElementById('e_ship_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter ship address</font>';
		creturn						=	false;
	 }
	 
	 
	 
	 if(ship_postal==''){
		document.getElementById('e_ship_postal').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code</font>';
		creturn						=	false;
	 }
	 
	 if(ship_postal!=''){
		if(!isAlphanumeric(ship_postal)) {
			document.getElementById('e_ship_postal').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_city==''){
		document.getElementById('e_ship_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 } 
	 
	 if(ship_city!=''){
		if(!isAlphabetic(ship_city)) {
			document.getElementById('e_ship_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_state==''){
		document.getElementById('e_ship_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(ship_state!=''){
		if(!isAlphabetic(ship_state)) {
			document.getElementById('e_ship_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(ship_country==''){
		document.getElementById('e_ship_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 
	 return creturn;	
	
}


function checkchangepassword(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	document.getElementById('e_change').innerHTML ='';
	var oldpassword								  = frm.oldpassword.value;
	var new_password							  = frm.new_password.value;	
	var	confirm_newwpassword					  = frm.confirm_newwpassword.value;	
	if(oldpassword==''){
		document.getElementById('e_change').innerHTML 		= 'Enter old password';
		frm.oldpassword.focus();
		return 	false;
	 }
	
 
	 if(new_password==''){
		document.getElementById('e_change').innerHTML = 'Enter new password';
		frm.new_password.focus();
		return		false;
	 }
	if(new_password!=''){
	  if(!re2.test(new_password)){
	   document.getElementById('e_change').innerHTML='Enter valid new password (must be of 8 character)';
	   frm.new_password.focus();
				return		false;
			 }
	 }
	 
	if(confirm_newwpassword==''){
	document.getElementById('e_change').innerHTML= 'Enter confirm password';
	frm.confirm_newwpassword.focus();
	return		false;
	 }
	 
	  if(confirm_newwpassword!=''){
		if(confirm_newwpassword!=new_password){
		document.getElementById('e_change').innerHTML = 'Password not matched';
		frm.confirm_newwpassword.focus();
		return		false;
		}
	 }
	 
	 return creturn;
}


function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}


function validattrade(frm){
	var creturn			=	true;
	
	document.getElementById('trader_title_error').innerHTML = "";
	document.getElementById('trade_image_error').innerHTML = "";
	document.getElementById('trade_smalldesc_error').innerHTML = "";
	var trader_title										=	frm.trader_title.value;	
	var trade_image											=	frm.trade_image.value;
	var	trade_smalldesc										=	frm.trade_smalldesc.value;	
	var trade_image1										=	frm.trade_image1.value
	if(trader_title==''){
		document.getElementById('trader_title_error').innerHTML  = '<font color="#BC3300">&nbsp;Enter trade title</font>';
		creturn						=	false;
	 }
	
	if(trader_title!='' ){
		if(!isAlphabetic(trader_title)) {
			document.getElementById('trader_title_error').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	
	if(trade_image=='' && trade_image1==''){
		document.getElementById('trade_image_error').innerHTML  = '<font color="#BC3300">&nbsp;Browse trade image</font>';
		creturn						=	false;
	 }

	if(trade_smalldesc==''){
		document.getElementById('trade_smalldesc_error').innerHTML  = '<font color="#BC3300">&nbsp;Enter small description</font>';
		creturn						=	false;
	 }

	 
	return creturn;
	  
}


function checkuploadimage(frm){
	var creturn 	=	true;
	var advert_name		=	frm.advert_name.value;
	var advert_email	=	frm.advert_email.value;
	var advert_company	=	frm.advert_company.value;
	var advert_position	=	frm.advert_position.value;
	var	imagename		=	frm.imagename.value;
	var advert_detail	=	frm.advert_detail.value;
	
	document.getElementById('e_advert_name').innerHTML  		= '';
	document.getElementById('e_advert_email').innerHTML  		= '';
	document.getElementById('e_advert_company').innerHTML  		= '';
	document.getElementById('e_advert_position').innerHTML  	= '';
	document.getElementById('e_imagename').innerHTML  			= '';
	document.getElementById('e_advert_detail').innerHTML  			= '';
	
	
	if(advert_name==''){
		document.getElementById('e_advert_name').innerHTML  = '<font color="#BC3300">&nbsp;Enter your name</font>';
		creturn						=	false;
	 }
	
	if(advert_name!='' ){
		if(!isAlphabetic(advert_name)) {
			document.getElementById('e_advert_name').innerHTML= '<font color="#BC3300">&nbsp;Enter valid name</font>';				
			creturn						=	false;
	 					}
	}
	if(advert_email==''){
		document.getElementById('e_advert_email').innerHTML  = '<font color="#BC3300">&nbsp;Enter your email</font>';
		creturn						=	false;
	 }

	
	if(advert_email!='' ){
		if(!isValidEmailStrict(advert_email)) {
			document.getElementById('e_advert_email').innerHTML= '<font color="#BC3300">&nbsp;Enter valid email</font>';				
			creturn						=	false;
	 					}
					
	 }
	 
	 if(advert_company==''){
		document.getElementById('e_advert_company').innerHTML  = '<font color="#BC3300">&nbsp;Enter company name</font>';
		creturn						=	false;
	 }
	
	if(advert_company!='' ){
		if(!isAlphabetic(advert_company)) {
			document.getElementById('e_advert_company').innerHTML= '<font color="#BC3300">&nbsp;Enter valid company name</font>';				
			creturn						=	false;
	 					}
	}
	if(advert_position==''){
		document.getElementById('e_advert_position').innerHTML  = '<font color="#BC3300">&nbsp;Select position </font>';
		creturn						=	false;
	 }

	 if(imagename==''){
		document.getElementById('e_imagename').innerHTML  = '<font color="#BC3300">&nbsp;Browse banner </font>';
		creturn						=	false;
	 }
	 
	  if(advert_detail==''){
		document.getElementById('e_advert_detail').innerHTML  = '<font color="#BC3300">&nbsp;Enter Detail </font>';
		creturn						=	false;
	 }
	 
	 
	
	 return creturn;
}	


function isNumericQuantity(quantity,curquantity){
if(!isNumeric(quantity.value)){
		quantity.value = curquantity;
	}
}



function checkfeedbackfrm(frm){
		//alert(frm.feedback_address.value);
		document.getElementById('e_feedback_fname').innerHTML		=	'';
		document.getElementById('e_feedback_lname').innerHTML		=	'';
		document.getElementById('e_feedback_email').innerHTML		=	'';
		document.getElementById('e_feedback_phone').innerHTML		=	'';
		document.getElementById('e_feedback_address').innerHTML		=	'';
		document.getElementById('e_feedback_zipcode').innerHTML		=	'';
		document.getElementById('e_feedback_city').innerHTML		=	'';
		document.getElementById('e_feedback_state').innerHTML		=	'';
		document.getElementById('e_feedback_country').innerHTML		=	'';
		document.getElementById('e_feedback_query').innerHTML		=	'';
		document.getElementById('e_security_codef').innerHTML		=	'';
		
		var creturn													=	true;
		var feedback_fname											=	frm.feedback_fname.value;
		var feedback_lname											=	frm.feedback_lname.value;
		var	feedback_email											=	frm.feedback_email.value;
		var feedback_phone											=	frm.feedback_phone.value;
		var	feedback_address										=	frm.feedback_address.value;
		var	feedback_zipcode										=	frm.feedback_zipcode.value;
		var	feedback_city											=	frm.feedback_city.value;
		var	feedback_state											=	frm.feedback_state.value;
		var	feedback_country										=	frm.feedback_country.value;
		var	feedback_query											=	frm.feedback_query.value;
		var	security_codef											=	frm.security_codef.value;
		    if(feedback_fname==""){
			document.getElementById('e_feedback_fname').innerHTML   ='&nbsp;<font color="#BC3300">&nbsp;Enter first name</font>';
			creturn						=	false;
	 		}
	 
			if(!isAlphabetic(feedback_fname)){
			document.getElementById('e_feedback_fname').innerHTML    ='&nbsp;<font color="#BC3300">Enter valid first name</font>';
			creturn						=	false;
			 }
			 
			 if(feedback_lname==""){
			 document.getElementById('e_feedback_lname').innerHTML='<font color="#BC3300">&nbsp;Enter last name</font>';
			 creturn						=	false;
			 }
			 
			if(!isAlphabetic(feedback_lname)){
			document.getElementById('e_feedback_lname').innerHTML='&nbsp;<font color="#BC3300">Enter last name</font>';
			creturn						=	false;
			 }
			 
		   if(feedback_email==''){
		   document.getElementById('e_feedback_email').innerHTML = '<font color="#BC3300">&nbsp;Enter company email id</font>';
		   creturn						=	false;
	 	    }
	 
			if(feedback_email!=''){
			   if(!isValidEmailStrict(feedback_email)){
				document.getElementById('e_feedback_email').innerHTML='<font color="#BC3300">&nbsp;Enter valid email id</font>';
				creturn						=	false;
			 }
			}
	 
		  if(feedback_phone==''){
			document.getElementById('e_feedback_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter phone number</font>';
			creturn						=	false;
			}
	      /*if(!isNumeric(feedback_phone)){
		    document.getElementById('e_feedback_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
		    creturn						=	false;
	       }*/
	   
	      if(feedback_address==''){
		   document.getElementById('e_feedback_address').innerHTML = '<font color="#BC3300">&nbsp;Enter address</font>';
		   creturn						=	false;
	        }
	 
	     if(feedback_zipcode==''){
		 document.getElementById('e_feedback_zipcode').innerHTML = '<font color="#BC3300">&nbsp;Enter post code</font>';
		 creturn						=	false;
	     }
		
	    if(!isAlphanumeric(feedback_zipcode)){
		document.getElementById('e_feedback_zipcode').innerHTML = '<font color="#BC3300">&nbsp;Enter valid post code</font>';
		creturn						=	false;
	    }
	    if(feedback_city==''){
		document.getElementById('e_feedback_city').innerHTML = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	    }
		
	  if(!isAlphabetic(feedback_city)){
		document.getElementById('e_feedback_city').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city</font>';
		creturn						=	false;
	    }
	 
	 if(feedback_state==''){
	    document.getElementById('e_feedback_state').innerHTML = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	    }
		
	 if(!isAlphabetic(feedback_state)){
		document.getElementById('e_feedback_state').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state</font>';
		creturn						=	false;
	    }
	 
	  if(feedback_country==''){
		document.getElementById('e_feedback_country').innerHTML = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	    }
	 
	 if(feedback_query==''){
		document.getElementById('e_feedback_query').innerHTML = '<font color="#BC3300">&nbsp;Enter comment </font>';
		creturn						=	false;
	    }
	 if(security_codef==''){
		document.getElementById('e_security_codef').innerHTML = '<font color="#BC3300">&nbsp;Enter security code </font>';
		creturn						=	false;
	    }	
		
	
	return creturn;
}

function validatecountries(frm){
		var creturn  				=	true; 
		document.getElementById('e_cont_code').innerHTML		=	'';
		document.getElementById('e_cont_name').innerHTML		=	'';
		var cont_code											=    frm.cont_code.value;
		var cont_name											=    frm.cont_name.value;
		if(cont_code==''){
		document.getElementById('e_cont_code').innerHTML = '<font color="#BC3300">&nbsp;Enter country code </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(cont_code)){
		document.getElementById('e_cont_code').innerHTML = '<font color="#BC3300">&nbsp;Enter valid country code</font>';
		creturn						=	false;
	    }
		
		if(cont_name==''){
		document.getElementById('e_cont_name').innerHTML = '<font color="#BC3300">&nbsp;Enter country name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(cont_name)){
		document.getElementById('e_cont_name').innerHTML = '<font color="#BC3300">&nbsp;Enter valid country name</font>';
		creturn						=	false;
	    }
		return creturn;		
}


function validatecity(frm){
		var creturn  				=	true; 
		document.getElementById('e_city_name').innerHTML		=	'';
		var city_name											=    frm.city_name.value;
		if(city_name==''){
		document.getElementById('e_city_name').innerHTML = '<font color="#BC3300">&nbsp;Enter city name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(city_name)){
		document.getElementById('e_city_name').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city name</font>';
		creturn						=	false;
	    }
		return creturn;		
}

function validatestate(frm){
		var creturn  				=	true; 
		document.getElementById('e_state_name').innerHTML		=	'';
		var state_name											=    frm.state_name.value;
		if(state_name==''){
		document.getElementById('e_state_name').innerHTML = '<font color="#BC3300">&nbsp;Enter state name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(state_name)){
		document.getElementById('e_state_name').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state name</font>';
		creturn						=	false;
	    }
		return creturn;		
}


function validateoptions(frm){
		var creturn  				=	true; 
		document.getElementById('e_option_name').innerHTML		=	'';
		document.getElementById('e_option_months').innerHTML		=	'';
		document.getElementById('e_option_cost').innerHTML		=	'';
		var option_name											=    frm.option_name.value;
		var	option_months										=	 frm.option_months.value	
		var option_cost											=    frm.option_cost.value;
		if(option_name==''){
		document.getElementById('e_option_name').innerHTML = '<font color="#BC3300">&nbsp;Enter option name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(option_name)){
		document.getElementById('e_option_name').innerHTML = '<font color="#BC3300">&nbsp;Enter valid option</font>';
		creturn						=	false;
	    }
		
		if(option_months=='' || option_months==0){
		document.getElementById('e_option_months').innerHTML = '<font color="#BC3300">&nbsp;Enter number of months </font>';
		creturn						=	false;
	    }
		if(!isNumeric(option_months)){
		document.getElementById('e_option_months').innerHTML = '<font color="#BC3300">&nbsp;Enter number of months in interger only</font>';
		creturn						=	false;
	    }
		
		
		if(option_cost==''){
		document.getElementById('e_option_cost').innerHTML = '<font color="#BC3300">&nbsp;Enter cost </font>';
		creturn						=	false;
	    }
		if(!isNumeric(option_cost)){
		document.getElementById('e_option_cost').innerHTML = '<font color="#BC3300">&nbsp;Enter interger only</font>';
		creturn						=	false;
	    }
		return creturn;		
}

function validatebusiness(frm){
		var creturn  				=	true; 
		document.getElementById('e_business_name').innerHTML		=	'';
		var business_name											=    frm.business_name.value;
		if(business_name==''){
		document.getElementById('e_business_name').innerHTML = '<font color="#BC3300">&nbsp;Enter business name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(business_name)){
		document.getElementById('e_business_name').innerHTML = '<font color="#BC3300">&nbsp;Enter valid business name</font>';
		creturn						=	false;
	    }
		return creturn;
}


function forgetpasswordchecks(frm){
	//alert("Called" + frm);
	document.getElementById('forgetErrror').innerHTML = '';
	if(frm.forgetemail.value==''){
		document.getElementById('forgetErrror').innerHTML = 	'Enter email';
		document.getElementById('forgetemail').focus();
		return false;
	}
	
	if(frm.forgetemail.value!=''){
		if(!isValidEmailStrict(frm.forgetemail.value)){
        	document.getElementById('forgetErrror').innerHTML='Enter valid email';
			document.getElementById('forgetemail').focus();
			return false;
		 }
	return true;	 
	}

}


function refertofriend(frm){
	
	/*document.getElementById('e_yourname').innerHTML	   =	'';
	document.getElementById('e_youremail').innerHTML   =	'';
	document.getElementById('e_friendname').innerHTML  =	'';
	document.getElementById('e_friendemail').innerHTML =	'';*/
	var yourname									   =	frm.yourname.value;
	var youremail									   =	frm.youremail.value;
	var friendname									   =	frm.friendname.value;
	var friendemail									   =	frm.friendemail.value;
	//alert(yourname+'-');
	if(yourname==''){
		document.getElementById('show_error').innerHTML = 	'<font color="#BC3300">&nbsp;Enter your name</font>';
		document.getElementById('yourname').focus();
		return false;
	}
	
	if(youremail==''){
		document.getElementById('show_error').innerHTML = 	'<font color="#BC3300">&nbsp;Enter your email</font>';
		document.getElementById('youremail').focus();
		return false;
	}
	
	if(youremail!=''){
		if(!isValidEmailStrict(youremail)){
        	document.getElementById('show_error').innerHTML='<font color="#BC3300">&nbsp;Enter valid email</font>';
			document.getElementById('youremail').focus();
			return false;
		 }
	}
	if(friendname==''){
		document.getElementById('show_error').innerHTML = 	'<font color="#BC3300">&nbsp;Enter friend name</font>';
		document.getElementById('friendname').focus();
		return false;
	}
	
	if(friendemail==''){
		document.getElementById('show_error').innerHTML = 	'<font color="#BC3300">&nbsp;Enter friend email </font>';
		document.getElementById('friendemail').focus();
		return false;
	}
	
	if(friendemail!=''){
		if(!isValidEmailStrict(friendemail)){
        	document.getElementById('show_error').innerHTML='<font color="#BC3300">&nbsp;Enter valid friend email</font>';
			document.getElementById('friendemail').focus();
			return false;
		 }
	}
	return true;
}
function HideText(myval){
	if(myval.value=="search"){
		myval.value = '';
	}
}
function DisplayText(myval){
	if(myval.value==''){
		myval.value	=	"search";
	}
	
}



function HideTextone(myval){
	if(myval.value=="Your Name"){
		myval.value = '';
	}
}
function DisplayTextone(myval){
	if(myval.value==''){
		myval.value	=	"Your Name";
	}
	
}




function checknewssubscription(frm){
	document.getElementById('newError').style.display		=	'none';
	document.getElementById('DispNewError').innerHTML		=	'';
	if(frm.news_name.value=="Your Name" || frm.news_name.value=="")
	{
			document.getElementById('newError').style.display	=	'block';
			document.getElementById('DispNewError').innerHTML	=	'<font color="#BC3300">&nbsp;Enter name</font>';
			frm.news_name.focus();
			return false;
	}
	
	if(frm.news_name.value!="Your Name" || frm.news_name.value!="")
	{
			if(!isAlphabetic(frm.news_name.value)){
			document.getElementById('newError').style.display	=	'block';
			document.getElementById('DispNewError').innerHTML	=	'<font color="#BC3300">&nbsp;Enter valid name</font>';
			frm.news_name.focus();
			return false;
			}
	}
	
	if(frm.newsEmail.value=="Your Email" || frm.newsEmail.value=="")
	{
			document.getElementById('newError').style.display	=	'block';
			document.getElementById('DispNewError').innerHTML	=	'<font color="#BC3300">&nbsp;Enter email</font>';
			frm.newsEmail.focus();	
			return false;
	}
	
	if(frm.newsEmail.value!="Your Email" || frm.newsEmail.value!="")
	{
			if(!isValidEmailStrict(frm.newsEmail.value)){
			document.getElementById('newError').style.display	=	'block';
			document.getElementById('DispNewError').innerHTML	=	'<font color="#BC3300">&nbsp;Enter valid email</font>';
			frm.newsEmail.focus();	
			return false;
			}
	}
	if(frm.takeaction[0].checked == false && frm.takeaction[1].checked==false)
	{
		document.getElementById('newError').style.display	=	'block';
			document.getElementById('DispNewError').innerHTML	=	'<font color="#BC3300">&nbsp;Check subscription</font>';
			frm.takeaction[0].focus();	
			return false;
	}

}

		
		
function checktestimonials(frm){
	var creturn 												=   true; 
	document.getElementById('e_sendername').innerHTML			=	"";
	document.getElementById('e_testimonial_title').innerHTML	=	"";
	document.getElementById('e_testimonial_content').innerHTML	=	"";
	document.getElementById('e_testimonial_email').innerHTML	=	"";
	
	
	
	var	sendername												=	frm.sendername.value;
	var	testimonial_title										=	frm.testimonial_title.value;
	var	testimonial_content										=	frm.testimonial_content.value;
	var testimonial_email										=	frm.testimonial_email.value;
	
	if(sendername==''){
		document.getElementById('e_sendername').innerHTML = '<font color="#BC3300">&nbsp;Enter  name </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(sendername)){
		document.getElementById('e_sendername').innerHTML = '<font color="#BC3300">&nbsp;Enter valid name</font>';
		creturn						=	false;
	    }
		
		if(testimonial_email==''){
		document.getElementById('e_testimonial_email').innerHTML = '<font color="#BC3300">&nbsp;Enter  email </font>';
		creturn						=	false;
	    }
		
		if(testimonial_email!=''){
		   if(!isValidEmailStrict(testimonial_email)){
			document.getElementById('e_testimonial_email').innerHTML='<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
			}
		
	if(testimonial_title==''){
		document.getElementById('e_testimonial_title').innerHTML = '<font color="#BC3300">&nbsp;Enter  title </font>';
		creturn						=	false;
	    }
		if(!isAlphabetic(testimonial_title)){
		document.getElementById('e_testimonial_title').innerHTML = '<font color="#BC3300">&nbsp;Enter valid title</font>';
		creturn						=	false;
	    }	
	if(testimonial_content==''){
		document.getElementById('e_testimonial_content').innerHTML = '<font color="#BC3300">&nbsp;Enter  description </font>';
		creturn						=	false;
	    }
	return creturn;
}


function validateorder(){
	document.getElementById('srcherror').innerHTML =  '';
	document.getElementById('srch').style.display  =  'none'; 
	 if(document.searchfrm.coupon_start_date.value == ""){
		 	document.getElementById('srch').style.display  =  'block'; 
			document.getElementById('srcherror').innerHTML = '<font color="#BC3300">&nbsp;Please enter to date.</font>';
			document.searchfrm.coupon_start_date.focus()
			return false;
		}	
		if(document.searchfrm.coupon_end_date.value == ""){
			document.getElementById('srch').style.display  =  'block'; 
			document.getElementById('srcherror').innerHTML = '<font color="#BC3300">&nbsp;Please enter from date.</font>';
			document.searchfrm.coupon_end_date.focus()
			return false;
		}	
		
	 if(document.searchfrm.coupon_start_date.value > document.searchfrm.coupon_end_date.value){
		document.getElementById('srch').style.display  =  'block'; 
			document.getElementById('srcherror').innerHTML = '<font color="#BC3300">&nbsp;From date is greater than to date.</font>'
		document.searchfrm.coupon_start_date.focus()
		return false;
	}
	return true;
	
}


function fillcontentaddress(frm){
	
	var creturn     = true;
	if(frm.checked) { 
			if(document.getElementById('billing_address').value==''){
				document.getElementById('billing_address').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Enter house number  first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			if(document.getElementById('actual_address').value==''){
				document.getElementById('actual_address').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Enter address  first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			
			if(document.getElementById('postal_code').value==''){
				document.getElementById('postal_code').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Enter post code first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			
			if(document.getElementById('u_city').value==''){
				document.getElementById('u_city').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Enter city first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			
			
			if(document.getElementById('u_state').value==''){
				document.getElementById('u_state').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Enter state first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			
			if(document.getElementById('u_country').value==''){
				document.getElementById('u_country').focus();
				document.getElementById('e_fillcontentaddress').innerHTML = '<font color="#BC3300">&nbsp;Select country first .</font>'
				document.getElementById('sameasbilling').checked = false;
				return false;
			}
			document.getElementById('u_house_number').value	=	document.getElementById('billing_address').value;
			document.getElementById('ship_address').value	=	document.getElementById('actual_address').value;
			document.getElementById('ship_postal').value	=	document.getElementById('postal_code').value;
			document.getElementById('ship_city').value		=	document.getElementById('u_city').value;
			document.getElementById('ship_state').value		=	document.getElementById('u_state').value;
			document.getElementById('ship_country').value	=	document.getElementById('u_country').value;
			return true;
	}
	else{
		
			document.getElementById('u_house_number').value	=	'';
			document.getElementById('ship_address').value	=	'';
			document.getElementById('ship_postal').value	=	'';
			document.getElementById('ship_city').value		=	'';
			document.getElementById('ship_state').value		=	'';
			document.getElementById('ship_country').value	=	'';
			return true;
	}
}



/*function registerationcheckwholesale(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	document.getElementById('e_username').innerHTML 			='';
	document.getElementById('e_u_password').innerHTML			='';
	document.getElementById('e_conf_password').innerHTML 		='';
	document.getElementById('e_f_name').innerHTML 				='';
	document.getElementById('e_l_name').innerHTML				='';
	document.getElementById('e_u_email').innerHTML				='';
	document.getElementById('e_u_phone').innerHTML 				='';
	document.getElementById('e_billing_address').innerHTML 	    ='';
	document.getElementById('e_actual_address').innerHTML 	    ='';
	document.getElementById('e_u_city').innerHTML 	   			='';
	document.getElementById('e_u_state').innerHTML 	  			='';
	document.getElementById('e_u_country').innerHTML 	  		='';
	document.getElementById('e_u_house_number').innerHTML  		='';
	document.getElementById('e_ship_address').innerHTML  		='';
	document.getElementById('e_ship_postal').innerHTML  		='';
	document.getElementById('e_ship_state').innerHTML  			='';
	document.getElementById('e_ship_city').innerHTML			='';	
	document.getElementById('e_ship_country').innerHTML  		='';
	document.getElementById('e_postal_code').innerHTML			='';
	document.getElementById('e_whole_sale_text').innerHTML			='';
	
	
	
	var username					=	frm.username.value;	
	var u_password					=	frm.u_password.value;	
	var conf_password				=	frm.conf_password.value;	
	var f_name						=	frm.f_name.value;	
	var l_name						=	frm.l_name.value;	
	var u_email						=	frm.u_email.value; //alert(u_email);
	var u_phone						=	frm.u_phone.value;
	var billing_address				=	frm.billing_address.value;
	var postal_code					=	frm.postal_code.value;
	var actual_address				=	frm.actual_address.value;
	var u_city						=	frm.u_city.value;
	var u_state						=	frm.u_state.value;
	var u_country					=	frm.u_country.value;	
	var u_house_number				=	frm.u_house_number.value;
	var ship_address				=	frm.ship_address.value;
	var ship_postal					=	frm.ship_postal.value;
	var	ship_city					=	frm.ship_city.value;
	var ship_state					=	frm.ship_state.value;
	var ship_country				=	frm.ship_country.value;
	var whole_sale_text				=	frm.whole_sale_text;
	if(username==''){
		document.getElementById('e_username').innerHTML 		= '<font color="#BC3300">&nbsp;Enter username</font>';
		creturn						=	false;
	 }
	 
	 if(u_password==''){
		document.getElementById('e_u_password').innerHTML 		= '<font color="#BC3300">&nbsp;Enter password</font>';
		creturn						=	false;
	 }
	 if(u_password!=''){
			 if(!re2.test(u_password)){
				document.getElementById('e_u_password').innerHTML = '<font color="#BC3300">Enter valid password (must be of 8 character)</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(conf_password==''){
		document.getElementById('e_conf_password').innerHTML    = '<font color="#BC3300">&nbsp;Enter confirm password</font>';
		creturn						=	false;
	 }
	 
	  if(conf_password!=''){
			  if(u_password!=conf_password){
				document.getElementById('e_conf_password').innerHTML = '<font color="#BC3300">Password not matched</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	   if(u_email==''){
		document.getElementById('e_u_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(u_email!=''){
		if(!isValidEmailStrict(u_email)){
		  document.getElementById('e_u_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	 
	  if(u_phone==''){
		document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }
	  if(u_phone!=''){
		  if(!CheckNumeric(u_phone)){
				document.getElementById('e_u_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter valid phone number</font>';
				creturn						=	false;
		  }
	 }
	 
	 
	if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number </font>';
		creturn						=	false;
	 }
	 
	 if(billing_address!=''){
		if(!isAlphabetic(billing_address)) {
			document.getElementById('e_billing_address').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(actual_address==''){
		document.getElementById('e_actual_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing address</font>';
		creturn						=	false;
	 }
	 
	
	 
	 
	if(postal_code==''){
		document.getElementById('e_postal_code').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code </font>';
		creturn						=	false;
	 } 
  if(postal_code!=''){
		if(!isAlphanumeric(postal_code)) {
			document.getElementById('e_postal_code').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_city==''){
		document.getElementById('e_u_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter state </font>';
		creturn						=	false;
	 }
	 
	 if(u_city!=''){
		if(!isAlphabetic(u_city)) {
			document.getElementById('e_u_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_state==''){
		document.getElementById('e_u_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(u_state!=''){
		if(!isAlphabetic(u_state)) {
			document.getElementById('e_u_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(u_country==''){
		document.getElementById('e_u_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 
	 if(u_house_number==''){
		document.getElementById('e_u_house_number').innerHTML  = '<font color="#BC3300">&nbsp;Enter house number</font>';
		creturn						=	false;
	 }
	 
	   if(u_house_number!=''){
		if(!isAlphanumeric(u_house_number)) {
			document.getElementById('e_u_house_number').innerHTML= '<font color="#BC3300">&nbsp;Enter valid house number</font>';				
			creturn						=	false;
	 					}
	 }
	 
	 if(ship_address==''){
		document.getElementById('e_ship_address').innerHTML  = '<font color="#BC3300">&nbsp;Enter ship address</font>';
		creturn						=	false;
	 }
	 
	 
	 
	 if(ship_postal==''){
		document.getElementById('e_ship_postal').innerHTML  = '<font color="#BC3300">&nbsp;Enter postal code</font>';
		creturn						=	false;
	 }
	 
	 if(ship_postal!=''){
		if(!isAlphanumeric(ship_postal)) {
			document.getElementById('e_ship_postal').innerHTML= '<font color="#BC3300">&nbsp;Enter valid postal code</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_city==''){
		document.getElementById('e_ship_city').innerHTML  = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 } 
	 
	 if(ship_city!=''){
		if(!isAlphabetic(ship_city)) {
			document.getElementById('e_ship_city').innerHTML= '<font color="#BC3300">&nbsp;Enter valid city</font>';				
			creturn						=	false;
	 					}
	 }
	 if(ship_state==''){
		document.getElementById('e_ship_state').innerHTML  = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
	 
	 if(ship_state!=''){
		if(!isAlphabetic(ship_state)) {
			document.getElementById('e_ship_state').innerHTML= '<font color="#BC3300">&nbsp;Enter valid state</font>';				
			creturn						=	false;
	 					}
	 }
	 
	  if(ship_country==''){
		document.getElementById('e_ship_country').innerHTML  = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	  if(whole_sale_text==''){
		document.getElementById('e_whole_sale_text').innerHTML  = '<font color="#BC3300">&nbsp;Enter description</font>';
		creturn						=	false;
	 }
	 
	 
	 
	 
	 return creturn;
}*/

function validatecolor(frm){
	document.getElementById('e_cont_name').innerHTML			='';
	document.getElementById('e_cont_color').innerHTML			='';
	var creturn = true;
	var re =  /^[A-Za-z]/;
		
	var cont_name	=  frm.cont_name.value;
	var cont_color	=  frm.cont_color.value;
    if(cont_name==''){
		document.getElementById('e_cont_name').innerHTML		= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	
	
	 
	 if(cont_name!=''){
			if(!re.test('cont_name')) {
			document.getElementById('e_cont_name').innerHTML	= '<font color="#BC3300">&nbsp;Enter valid color name</font>';				
			creturn						=	false;
	 					}
		  }
		  
	 if(cont_color==''){
		document.getElementById('e_cont_color').innerHTML		= '<font color="#BC3300">&nbsp;Enter color cost</font>';
		creturn						=	false;
	 }
	
	
	
	 if(cont_color!=''){
		 	var isNum	=	isNumeric(cont_color)
			if(isNum==false) {
			document.getElementById('e_cont_color').innerHTML	= '<font color="#BC3300">&nbsp;Enter valid color cost</font>';				
			creturn						=	false;
	 					}
		  }
		
	return creturn;
}

function checkaddsubcategory(frm){
	var creturn	=	true;
	document.getElementById('e_cont_name').innerHTML	=	"";
	var cont_name	=	frm.cont_name.value;
	if(cont_name==''){
		document.getElementById('e_cont_name').innerHTML		= '<font color="#BC3300">&nbsp;Enter subcategory name</font>';
		creturn						=	false;
	}
	 
	return creturn;
}


function checkcontact(frm)
{
	
	var creturn = true;
	document.getElementById('e_contact_name').innerHTML 				= 	'';
	
	document.getElementById('e_contact_email').innerHTML 				= 	'';
	document.getElementById('e_contact_address').innerHTML 				= 	'';
	
	document.getElementById('e_contact_zip_code').innerHTML 			= 	'';
	document.getElementById('e_contact_city').innerHTML 				= 	'';
	
	document.getElementById('e_contact_state').innerHTML 					= 	'';
	document.getElementById('e_contact_country').innerHTML 				= 	'';
	//return false;
	document.getElementById('e_contact_comment').innerHTML 				= 	'';
	document.getElementById('e_security_code_re').innerHTML 			= 	'';
	
	var contact_name													=	frm.contact_name.value;	
	var contact_email													=   frm.contact_email.value;	
	var contact_address													=	frm.contact_address.value;	
	var contact_zip_code												=	frm.contact_zip_code.value;
	var contact_city													=	frm.contact_city.value;
	var contact_state													=	frm.contact_state.value;
	var contact_country													=	frm.contact_country.value;
	var contact_comment													=	frm.contact_comment.value;
	var security_code_re												=   frm.security_code_re.value;
	//	
	if(contact_name==""){
		document.getElementById('e_contact_name').innerHTML = '<font color="#BC3300">&nbsp;Enter name</font>';
		creturn						=	false;
	 }
	 	

	if(!isAlphabetic(contact_name)){
		document.getElementById('e_contact_name').innerHTML = '<font color="#BC3300">Enter valid  name</font>';
		creturn						=	false;
	 }
	
	 if(contact_email==''){
		document.getElementById('e_contact_email').innerHTML = '<font color="#BC3300">&nbsp;Enter email id</font>';
		creturn						=	false;
	 }
	 
	 if(contact_email!=''){
		if(!isValidEmailStrict(contact_email)){
		  document.getElementById('e_contact_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 }
	 
	 
	 
	  if(contact_address==''){
		document.getElementById('e_contact_address').innerHTML = '<font color="#BC3300">&nbsp;Enter address</font>';
		
		creturn						=	false;
	 }
	 
	  
	if(contact_city==''){
		document.getElementById('e_contact_city').innerHTML = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(contact_city)){
		document.getElementById('e_contact_city').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city</font>';
		creturn						=	false;
	 }
	 if(contact_state==''){
		document.getElementById('e_contact_state').innerHTML = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false;
	 }
		
	if(!isAlphabetic(contact_state)){
		document.getElementById('e_contact_state').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state</font>';
		creturn						=	false;
	 }
	 
	 
	  if(contact_country==''){
		document.getElementById('e_contact_country').innerHTML = '<font color="#BC3300">&nbsp;Select country</font>';
		creturn						=	false;
	 }
	 if(contact_zip_code==''){
		document.getElementById('e_contact_zip_code').innerHTML = '<font color="#BC3300">&nbsp;Enter post code</font>';
		creturn						=	false;
	 }
		
		
	if(!isAlphanumeric(contact_zip_code)){
		document.getElementById('e_contact_zip_code').innerHTML = '<font color="#BC3300">&nbsp;Enter valid post code</font>';
		creturn						=	false;
	 } 	 
	 
	 if(contact_comment==''){
		document.getElementById('e_contact_comment').innerHTML = '<font color="#BC3300">&nbsp;Enter comment </font>';
		creturn						=	false;
	 }
	 
	 if(security_code_re==''){
		document.getElementById('e_security_code_re').innerHTML = '<font color="#BC3300">&nbsp;Enter security code </font>';
		creturn						=	false;
	 }
	
	 return creturn;
	 
}


function checkregister(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	
	document.getElementById('e_f_name').innerHTML 								=	'';
	document.getElementById('e_l_name').innerHTML 								=	'';
	document.getElementById('e_user_phone').innerHTML 							=	'';
	document.getElementById('e_billing_address').innerHTML 						=	'';
	document.getElementById('e_billing_city').innerHTML 						=	'';
	document.getElementById('e_billing_state').innerHTML 						=	'';
	document.getElementById('e_billing_country').innerHTML 						=	'';
	document.getElementById('e_billing_zipcode').innerHTML 						=	'';
	document.getElementById('e_shipping_address').innerHTML 					=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_city').innerHTML 						=	'';
	document.getElementById('e_shipping_state').innerHTML 						=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_zipcode').innerHTML 					=	'';
	document.getElementById('e_user_email').innerHTML 							=	'';
	document.getElementById('e_user_password').innerHTML 						=	'';
	document.getElementById('e_confirm_password').innerHTML 					=	'';
	document.getElementById('e_security_codere').innerHTML 					=	'';
	
	
	var f_name								=	frm.f_name.value;	
	var l_name								=	frm.l_name.value;
	var user_phone							=	frm.user_phone.value
	var billing_address						=	frm.billing_address.value;	
	var billing_city						=	frm.billing_city.value;
	var billing_state						=	frm.billing_state.value
	var billing_country						=	frm.billing_country.value;	
	var billing_zipcode						=	frm.billing_zipcode.value;
	var shipping_address					=	frm.shipping_address.value
	var shipping_city						=	frm.shipping_city.value;	
	var shipping_state						=	frm.shipping_state.value;
	var shipping_country					=	frm.shipping_country.value

	var shipping_zipcode					=	frm.shipping_zipcode.value;	
	var user_email							=	frm.user_email.value;
	var user_password						=	frm.user_password.value;
	
	var confirm_password					=	frm.confirm_password.value;	
	var security_codere						=	frm.security_codere.value;
	//var user_password						=	frm.user_password.value
	
	 if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 if(user_phone==''){
		document.getElementById('e_user_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }	  
	 
	  if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter billing address</font>'; 
		creturn						=	false;
	 }	  
	 
	  if(billing_city==''){
		document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing city first </font>';
		creturn						=	false;
	 }
	 
	 if(billing_city!=''){
			if(!isAlphabetic(billing_city)) {
			document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(billing_state==''){
		document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing state first</font>';
		creturn						=	false;
	 }
	 
	 if(billing_state!=''){
			if(!isAlphabetic(billing_state)) {
			document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(billing_country==''){
		document.getElementById('e_billing_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select billing country</font>';
		creturn						=	false;
	 }	 
	 
	 if(billing_zipcode==''){
		document.getElementById('e_billing_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing zip code</font>';
		//alert(document.getElementById('e_billing_zipcode').innerHTML+'----'+billing_zipcode);
		creturn						=	false;
	 }
	 
	 if(billing_zipcode!=''){
		if(!isAlphanumeric(billing_zipcode)) {
			document.getElementById('e_billing_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid billing zip code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	
	 if(shipping_address==''){
		document.getElementById('e_shipping_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter shipping address</font>';
		creturn						=	false;
	 }	  
	 
	  if(shipping_city==''){
		document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping city first </font>';
		creturn						=	false;
	 }
	 
	 if(shipping_city!=''){
			if(!isAlphabetic(shipping_city)) {
			document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(shipping_state==''){
		document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping state first</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_state!=''){
			if(!isAlphabetic(shipping_state)) {
			document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(shipping_country==''){
		document.getElementById('e_shipping_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select shipping country</font>';
		creturn						=	false;
	 }	 
	 
	 if(shipping_zipcode==''){
		document.getElementById('e_shipping_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter shipping zip code</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_zipcode!=''){
		if(!isAlphanumeric(shipping_zipcode)) {
			document.getElementById('e_shipping_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid shipping zip code</font>';				
			creturn						=	false;
	 					}
	 }

	 if(user_email==''){
		document.getElementById('e_user_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(user_email!=''){
		if(!isValidEmailStrict(user_email)){
		  document.getElementById('e_user_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 } 
	 
	 if(user_password==''){
		document.getElementById('e_user_password').innerHTML 		= '<font color="#BC3300">&nbsp;Enter password</font>';
		creturn						=	false;
	 }
	 if(user_password!=''){
			 if(!re2.test(user_password)){
				document.getElementById('e_user_password').innerHTML = '<font color="#BC3300">Enter valid password (must be of 8 character)</font>';
				creturn						=	false;
			 }
	 }
	 
	  if(confirm_password==''){
		document.getElementById('e_confirm_password').innerHTML    = '<font color="#BC3300">&nbsp;Enter confirm password</font>';
		creturn						=	false;
	 }
	 
	  if(confirm_password!=''){
			  if(confirm_password!=user_password){
				document.getElementById('e_confirm_password').innerHTML = '<font color="#BC3300">Password not matched</font>';
				creturn						=	false;
			 }
	 } 
	if(security_codere==''){
		document.getElementById('e_security_codere').innerHTML    = '<font color="#BC3300">&nbsp;Enter security code</font>';
		creturn						=	false;
	}
	 
	return creturn;	  

}



function Checkeditaccount(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	
	document.getElementById('e_f_name').innerHTML 								=	'';
	document.getElementById('e_l_name').innerHTML 								=	'';
	document.getElementById('e_user_phone').innerHTML 							=	'';
	document.getElementById('e_billing_address').innerHTML 						=	'';
	document.getElementById('e_billing_city').innerHTML 						=	'';
	document.getElementById('e_billing_state').innerHTML 						=	'';
	document.getElementById('e_billing_country').innerHTML 						=	'';
	document.getElementById('e_billing_zipcode').innerHTML 						=	'';
	document.getElementById('e_shipping_address').innerHTML 					=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_city').innerHTML 						=	'';
	document.getElementById('e_shipping_state').innerHTML 						=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_zipcode').innerHTML 					=	'';
	document.getElementById('e_user_email').innerHTML 							=	'';
	
	
	var f_name								=	frm.f_name.value;	
	var l_name								=	frm.l_name.value;
	var user_phone							=	frm.user_phone.value
	var billing_address						=	frm.billing_address.value;	
	var billing_city						=	frm.billing_city.value;
	var billing_state						=	frm.billing_state.value
	var billing_country						=	frm.billing_country.value;	
	var billing_zipcode						=	frm.billing_zipcode.value;
	var shipping_address					=	frm.shipping_address.value
	var shipping_city						=	frm.shipping_city.value;	
	var shipping_state						=	frm.shipping_state.value;
	var shipping_country					=	frm.shipping_country.value

	var shipping_zipcode					=	frm.shipping_zipcode.value;	
	var user_email							=	frm.user_email.value;
	
	//var user_password						=	frm.user_password.value
	
	 if(f_name==''){
		document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(f_name!=''){
			if(!isAlphabetic(f_name)) {
			document.getElementById('e_f_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(l_name==''){
		document.getElementById('e_l_name').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(l_name!=''){
			if(!isAlphabetic(l_name)) {
			document.getElementById('e_l_name').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 if(user_phone==''){
		document.getElementById('e_user_phone').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }	  
	 
	  if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter billing address</font>'; 
		creturn						=	false;
	 }	  
	 
	  if(billing_city==''){
		document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing city first </font>';
		creturn						=	false;
	 }
	 
	 if(billing_city!=''){
			if(!isAlphabetic(billing_city)) {
			document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(billing_state==''){
		document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing state first</font>';
		creturn						=	false;
	 }
	 
	 if(billing_state!=''){
			if(!isAlphabetic(billing_state)) {
			document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(billing_country==''){
		document.getElementById('e_billing_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select billing country</font>';
		creturn						=	false;
	 }	 
	 
	 if(billing_zipcode==''){
		document.getElementById('e_billing_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing zip code</font>';
		//alert(document.getElementById('e_billing_zipcode').innerHTML+'----'+billing_zipcode);
		creturn						=	false;
	 }
	 
	 if(billing_zipcode!=''){
		if(!isAlphanumeric(billing_zipcode)) {
			document.getElementById('e_billing_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid billing zip code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	
	 if(shipping_address==''){
		document.getElementById('e_shipping_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter shipping address</font>';
		creturn						=	false;
	 }	  
	 
	  if(shipping_city==''){
		document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping city first </font>';
		creturn						=	false;
	 }
	 
	 if(shipping_city!=''){
			if(!isAlphabetic(shipping_city)) {
			document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(shipping_state==''){
		document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping state first</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_state!=''){
			if(!isAlphabetic(shipping_state)) {
			document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(shipping_country==''){
		document.getElementById('e_shipping_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select shipping country</font>';
		creturn						=	false;
	 }	 
	 
	 if(shipping_zipcode==''){
		document.getElementById('e_shipping_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter shipping zip code</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_zipcode!=''){
		if(!isAlphanumeric(shipping_zipcode)) {
			document.getElementById('e_shipping_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid shipping zip code</font>';				
			creturn						=	false;
	 					}
	 }

	 if(user_email==''){
		document.getElementById('e_user_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(user_email!=''){
		if(!isValidEmailStrict(user_email)){
		  document.getElementById('e_user_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false;
			 }
	 } 
	 
	 
	return creturn;	  

}


function checkedituseremail(user_email,e_user_email)
{
	//alert(user_email);
	if(isValidEmailStrict(user_email))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {// alert(req.responseText);
			   if(req.responseText==0){ 
							document.getElementById(e_user_email).innerHTML = "&nbsp;<font color='#009966'> Email available </font>";	return true;
							}
							if(req.responseText==1){
							document.getElementById(e_user_email).innerHTML = "&nbsp;<font color='#BC3300'>"+user_email+" not available </font>";	
							
							document.getElementById('user_email').value=''; return false;
							}
			   } 
          }
     };
     req.open("GET", "check_email_edit.php?email="+user_email);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(e_user_email).innerHTML = "<font color='#BC3300'>Please enter a valid email </font>";
		return false;
	}
}



function quotevalidate(frm){
	var creturn = true;
	document.getElementById('e_quote_name').innerHTML 				= 	'';
	document.getElementById('e_quote_title').innerHTML 				= 	'';
	document.getElementById('e_quote_companyname').innerHTML 		= 	'';
	document.getElementById('e_quote_address').innerHTML 			= 	'';
	document.getElementById('e_quote_city').innerHTML 				= 	'';
	document.getElementById('e_quote_state').innerHTML 				= 	'';
	document.getElementById('e_quote_country').innerHTML 			= 	'';
	document.getElementById('e_quote_pcode').innerHTML 				= 	'';
	document.getElementById('e_quote_phone').innerHTML 				=	'';		
	document.getElementById('e_quote_ext').innerHTML 				= 	'';
	document.getElementById('e_quote_fax').innerHTML 				= 	'';
	document.getElementById('e_quote_email').innerHTML 				= 	'';
	document.getElementById('e_quote_website').innerHTML 				= 	'';
	
	document.getElementById('e_quote_product').innerHTML 			= 	'';
	document.getElementById('e_quote_productcode').innerHTML 		= 	'';
	document.getElementById('e_quote_productquantity').innerHTML 	= 	'';
	document.getElementById('e_quote_requirement').innerHTML 		= 	'';
	document.getElementById('e_quote_codee').innerHTML 				= 	'';

	
	
	
	
	var quote_name													=	frm.quote_name.value;
	var quote_title													=	frm.quote_title.value;
	var quote_companyname											=	frm.quote_companyname.value;
	var quote_address												=   frm.quote_address.value;
	var quote_city													=   frm.quote_city.value;
	var quote_state													=   frm.quote_state.value;
	var quote_country												=	frm.quote_country.value;
	var	quote_pcode													=	frm.quote_pcode.value;	
	var	quote_phone													=	frm.quote_phone.value;
	var quote_ext													=	frm.quote_ext.value;
	var	quote_fax													=	frm.quote_fax.value;
	var	quote_email													=	frm.quote_email.value;	
	var quote_website												=	frm.quote_website.value;
	var quote_product												=	frm.quote_product.value;
	var quote_productcode											=	frm.quote_productcode.value;
	var quote_productquantity										=	frm.quote_productquantity.value;
	var quote_requirement											=	frm.quote_requirement.value;
	var quote_codee													=	frm.quote_codee.value

	if(quote_name==""){
		document.getElementById('e_quote_name').innerHTML = '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;  //alert(creturn+'1');
	 }
	 
	if(!isAlphabetic(quote_name)){
		document.getElementById('e_quote_name').innerHTML = '<font color="#BC3300">Enter valid first name</font>';
		creturn						=	false; //alert(creturn+'2');
	 }
	 
	 if(quote_title==""){
		document.getElementById('e_quote_title').innerHTML = '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false; //alert(creturn+'3');
	 }
	 
	if(!isAlphabetic(quote_title)){
		document.getElementById('e_quote_title').innerHTML = '<font color="#BC3300">Enter valid last name</font>';
		creturn						=	false; //alert(creturn+'4');
	 }
	 
	 if(quote_companyname==''){
		document.getElementById('e_quote_companyname').innerHTML = '<font color="#BC3300">&nbsp;Enter company name</font>';
		creturn						=	false;  //alert(creturn+'5');
	 }
	 
	
	if(!isAlphabetic(quote_companyname)){
		document.getElementById('e_quote_companyname').innerHTML = '<font color="#BC3300">&nbsp;Enter valid company name</font>';
		creturn						=	false; //alert(creturn+'6');
	 }
	 
	  if(quote_address==''){
		document.getElementById('e_quote_address').innerHTML = '<font color="#BC3300">&nbsp;Enter address</font>';
		creturn						=	false;  //alert(creturn+'7');
	 }
	
	if(quote_city==''){
		document.getElementById('e_quote_city').innerHTML = '<font color="#BC3300">&nbsp;Enter city</font>';
		creturn						=	false; //alert(creturn+'8');
	 }
		
	if(!isAlphabetic(quote_city)){
		document.getElementById('e_quote_city').innerHTML = '<font color="#BC3300">&nbsp;Enter valid city</font>';
		creturn						=	false;   // alert(creturn+'9');
	 }
	 
	 if(quote_state==''){
		document.getElementById('e_quote_state').innerHTML = '<font color="#BC3300">&nbsp;Enter state</font>';
		creturn						=	false; //alert(creturn+'10');
	 }
		
	if(!isAlphabetic(quote_state)){
		document.getElementById('e_quote_state').innerHTML = '<font color="#BC3300">&nbsp;Enter valid state</font>';
		creturn						=	false; //alert(creturn+'11');
	 }
	 if(quote_country==''){
		document.getElementById('e_quote_country').innerHTML = '<font color="#BC3300">&nbsp;Selct country</font>';
		creturn						=	false; //alert(creturn+'12');
	 }
	 
	 if(quote_pcode==''){
		document.getElementById('e_quote_pcode').innerHTML = '<font color="#BC3300">&nbsp;Enter pin code</font>';
		creturn						=	false; //alert(creturn+'13');
	 }
		
	if(!isAlphanumeric(quote_pcode)){
		document.getElementById('e_quote_pcode').innerHTML = '<font color="#BC3300">&nbsp;Enter valid pin code</font>';
		creturn						=	false; //alert(creturn+'14');
	 }
	 
	  if(quote_phone==''){
		document.getElementById('e_quote_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter phone number</font>';
		
		creturn						=	false; //alert(creturn+'15');
	 }
	 
	 if(!isAlphanumeric(quote_phone)){
		document.getElementById('e_quote_phone').innerHTML = '<font color="#BC3300">&nbsp;Enter valid phone </font>';
		creturn						=	false; alert(creturn+'16');
	 }
	 if(quote_ext==''){
		document.getElementById('e_quote_ext').innerHTML = '<font color="#BC3300">&nbsp;Enter extension code</font>';
		creturn						=	false; //alert(creturn+'17');
	 }
		
	if(!isAlphanumeric(quote_ext)){
		document.getElementById('e_quote_ext').innerHTML = '<font color="#BC3300">&nbsp;Enter valid extension code</font>';
		creturn						=	false; //alert(creturn+'18');
	 }
	 
	if(quote_fax==''){
		document.getElementById('quote_fax').innerHTML = '<font color="#BC3300">&nbsp;Enter fax</font>';
		
		creturn						=	false; //alert(creturn+'19');
	 }
		
	if(!isNumeric(quote_fax)){
		document.getElementById('quote_fax').innerHTML = '<font color="#BC3300">&nbsp;Enter valid fax</font>';
		creturn						=	false; //alert(creturn+'20');
	 }
	
	if(quote_email==''){
		document.getElementById('e_quote_email').innerHTML = '<font color="#BC3300">&nbsp;Enter company email id</font>';
		creturn						=	false; //alert(creturn+'21');
	 }
	 
	 if(quote_email!=''){
		if(!isValidEmailStrict(quote_email)){
		  document.getElementById('e_quote_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
			creturn						=	false; //alert(creturn+'22');
			 }
	 }
	 
	 if(quote_website==''){
		 document.getElementById('e_quote_website').innerHTML = '<font color="#BC3300">&nbsp;Enter website</font>';
		 creturn						=	false; //alert(creturn+'23');
	 }
	if(quote_product==""){
		document.getElementById('e_quote_product').innerHTML = '<font color="#BC3300">&nbsp;Enter product name</font>';
		creturn						=	false; //alert(creturn+'24');
	 }
	 
	if(!isAlphabetic(quote_name)){
		document.getElementById('e_quote_product').innerHTML = '<font color="#BC3300">Enter valid product name</font>';
		creturn						=	false;  //alert(creturn+'25');
	 }
	 
	 
	 if(quote_productcode==""){
		document.getElementById('e_quote_productcode').innerHTML = '<font color="#BC3300">&nbsp;Enter product code</font>';
		creturn						=	false;  alert(creturn+'26');
	 }
	 
	if(!isAlphabetic(quote_productcode)){
		document.getElementById('e_quote_productcode').innerHTML = '<font color="#BC3300">Enter valid product code</font>';
		creturn						=	false;  //alert(creturn+'27');
	 }
	 
	 if(quote_productquantity==''){
		document.getElementById('e_quote_productquantity').innerHTML = '<font color="#BC3300">&nbsp;Enter product quantity</font>';
		creturn						=	false; //alert(creturn+'28');
	 }
		
	if(!isNumeric(quote_productquantity)){
		document.getElementById('e_quote_productquantity').innerHTML = '<font color="#BC3300">&nbsp;Enter valid product quantity</font>';
		creturn						=	false; //alert(creturn+'29');
	 }
	 
	  if(quote_requirement==''){
		document.getElementById('e_quote_requirement').innerHTML = '<font color="#BC3300">&nbsp;Enter requirement</font>';
		
		creturn						=	false; //alert(creturn+'30');
	 }
	 
	 if(quote_codee==''){
		document.getElementById('e_quote_codee').innerHTML = '<font color="#BC3300">&nbsp;Enter security code</font>';
		creturn						=	false; //alert(creturn+'31');
	 }
//	 alert(creturn);
	 return creturn;
}


function Checkcart(frm){
	var creturn											 = true;
	document.getElementById('e_prod_quantity').innerHTML = '';
	var prod_quantity									 = frm.prod_quantity.value;
	if(prod_quantity=='' || prod_quantity==0){
	document.getElementById('e_prod_quantity').innerHTML = '<font color="#BC3300">&nbsp;Enter product quantity </font>';	
	creturn = false;
	}
	if(!isNumeric(prod_quantity)){
			document.getElementById('e_prod_quantity').innerHTML = '<font color="#BC3300">&nbsp;Enter numeric value</font>';	
			creturn = false;	
	}
	//alert('creturn : = '+creturn);
	//alert(frm);
	return creturn;
}

function checkoutquantity(curElement,beforevalue){
	if(curElement.value==0)
	{
		curElement.value = beforevalue;
	}
	if(!isNumeric(prod_quantity)){
			 curElement.value = beforevalue;	
	}
	return true;
}


function checkpaymentaddress(frm){
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var	validationexpression=	/^[0-9a-zA-Z' ']{5,}/;
	
	document.getElementById('e_firstname').innerHTML 							=	'';
	document.getElementById('e_lastname').innerHTML 							=	'';
	document.getElementById('e_phonenumber').innerHTML 							=	'';
	document.getElementById('e_billing_address').innerHTML 						=	'';
	document.getElementById('e_billing_city').innerHTML 						=	'';
	document.getElementById('e_billing_state').innerHTML 						=	'';
	document.getElementById('e_billing_country').innerHTML 						=	'';
	document.getElementById('e_billing_zipcode').innerHTML 						=	'';
	document.getElementById('e_shipping_address').innerHTML 					=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';
	document.getElementById('e_shipping_city').innerHTML 						=	'';
	document.getElementById('e_shipping_state').innerHTML 						=	'';
	document.getElementById('e_shipping_country').innerHTML 					=	'';

	
	
	var firstname								=	frm.firstname.value;	
	var lastname								=	frm.lastname.value;
	var phonenumber							=	frm.phonenumber.value
	var billing_address						=	frm.billing_address.value;	
	var billing_city						=	frm.billing_city.value;
	var billing_state						=	frm.billing_state.value
	var billing_country						=	frm.billing_country.value;	
	var billing_zipcode						=	frm.billing_zipcode.value;
	var shipping_address					=	frm.shipping_address.value
	var shipping_city						=	frm.shipping_city.value;	
	var shipping_state						=	frm.shipping_state.value;
	var shipping_country					=	frm.shipping_country.value

	var shipping_zipcode					=	frm.shipping_zipcode.value;	

	
	 if(firstname==''){
		document.getElementById('e_firstname').innerHTML			= '<font color="#BC3300">&nbsp;Enter first name</font>';
		creturn						=	false;
	 }
	 
	 if(firstname!=''){
			if(!isAlphabetic(firstname)) {
			document.getElementById('e_firstname').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid first name</font>';				
			creturn						=	false;
	 					}
		  }
	 
	  if(lastname==''){
		document.getElementById('e_lastname').innerHTML 			= '<font color="#BC3300">&nbsp;Enter last name</font>';
		creturn						=	false;
	 }
	 
	  if(lastname!=''){
			if(!isAlphabetic(lastname)) {
			document.getElementById('e_lastname').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid last name</font>';				
			creturn						=	false;
	 					}
		  }
	 if(phonenumber==''){
		document.getElementById('e_phonenumber').innerHTML 			= '<font color="#BC3300">&nbsp;Enter phone number</font>';
		creturn						=	false;
	 }	  
	 
	  if(billing_address==''){
		document.getElementById('e_billing_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter billing address</font>'; 
		creturn						=	false;
	 }	  
	 
	  if(billing_city==''){
		document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing city first </font>';
		creturn						=	false;
	 }
	 
	 if(billing_city!=''){
			if(!isAlphabetic(billing_city)) {
			document.getElementById('e_billing_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(billing_state==''){
		document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter billing state first</font>';
		creturn						=	false;
	 }
	 
	 if(billing_state!=''){
			if(!isAlphabetic(billing_state)) {
			document.getElementById('e_billing_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid billing state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(billing_country==''){
		document.getElementById('e_billing_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select billing country</font>';
		creturn						=	false;
	 }	 
	 
	 if(billing_zipcode==''){
		document.getElementById('e_billing_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter billing zip code</font>';
		//alert(document.getElementById('e_billing_zipcode').innerHTML+'----'+billing_zipcode);
		creturn						=	false;
	 }
	 
	 if(billing_zipcode!=''){
		if(!isAlphanumeric(billing_zipcode)) {
			document.getElementById('e_billing_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid billing zip code</font>';				
			creturn						=	false;
	 					}
	 }
	 
	
	 if(shipping_address==''){
		document.getElementById('e_shipping_address').innerHTML 			= '<font color="#BC3300">&nbsp;Enter shipping address</font>';
		creturn						=	false;
	 }	  
	 
	  if(shipping_city==''){
		document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping city first </font>';
		creturn						=	false;
	 }
	 
	 if(shipping_city!=''){
			if(!isAlphabetic(shipping_city)) {
			document.getElementById('e_shipping_city').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping city</font>';				
			creturn						=	false;
	 					}
		  }
		  
		  
   if(shipping_state==''){
		document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter shipping state first</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_state!=''){
			if(!isAlphabetic(shipping_state)) {
			document.getElementById('e_shipping_state').innerHTML			= '<font color="#BC3300">&nbsp;Enter valid shipping state</font>';				
			creturn						=	false;
	 					}
		  }
		
	 if(shipping_country==''){
		document.getElementById('e_shipping_country').innerHTML 			= '<font color="#BC3300">&nbsp;Select shipping country</font>';
		creturn						=	false;
	 }	 
	 
	 if(shipping_zipcode==''){
		document.getElementById('e_shipping_zipcode').innerHTML  = '<font color="#BC3300">&nbsp;Enter shipping zip code</font>';
		creturn						=	false;
	 }
	 
	 if(shipping_zipcode!=''){
		if(!isAlphanumeric(shipping_zipcode)) {
			document.getElementById('e_shipping_zipcode').innerHTML= '<font color="#BC3300">&nbsp;Enter valid shipping zip code</font>';				
			creturn						=	false;
	 					}
	 }

	 
	return creturn;	  

}


function makepaysecond(frm){
	alert(frm);
	if(frm.howpay[0].checked==true || frm.howpay[1].checked==true){
		return true;	
	}else{
		document.getElementById('show_error').innerHTML = '<font color="#BC3300">&nbsp;Check payment type</font>';
		return false;		
	}
	
}

function checkacceptterms(frm){
	if(frm.acceptterms.checked==true)
		{
			return true;	
		}
		else{
		document.getElementById('show_error').innerHTML = '<font color="#BC3300">&nbsp;Check payment type</font>';
		return false;	
		}
	return false;
}


function checkpaymentsection(frm)
{
	var creturn = true;
	document.getElementById('e_member_ship_duration').innerHTML 	=	'';
	document.getElementById('show_error').innerHTML 				=	'';
	var member_ship_type								=	frm.member_ship_type.value;	
	var member_ship_duration							=	frm.member_ship_duration.value;
	var amount_to_pay									=	frm.amount_to_pay.value
	if(member_ship_type==1 && member_ship_duration=='' )
		{
			document.getElementById('e_member_ship_duration').innerHTML = '<font color="#BC3300">&nbsp;Select member ship duration</font>';
			creturn	=	 false;				
		}
	if(amount_to_pay=='')
	{
			document.getElementById('show_error').innerHTML = '<font color="#BC3300">&nbsp;Enter amount </font>';
			creturn	=	 false;		
	}
	if(amount_to_pay!='')
	{	
		if(frm.howpay[0].checked==false && frm.howpay[1].checked==false){
			document.getElementById('show_error').innerHTML = '<font color="#BC3300">&nbsp;Check payment type</font>';
			creturn	=	 false;		
		}
	}
	
		
		//alert( creturn);
		return creturn;
}

function checkdonateID(check)
	{
		if(check==0){
				document.getElementById('neel').style.display =	'none' 
			}
		if(check==1){
				document.getElementById('neel').style.display =	'block' 
			}
	}
	
function checkdonateouterID(check)
	{
		if(check==0){
				document.getElementById('neel').style.display =	'none' 
				document.getElementById('outerpayment').style.display =	'block' 
				
			}
		if(check==1){
				document.getElementById('neel').style.display =	'block' 
				document.getElementById('outerpayment').style.display =	'none' 
				//alert(document.getElementById('outerpayment').style.display );
			}
	}	
	
function showhidecontact(check){
	if(check=="Yes")
	{
			
		document.getElementById('showcontact').style.display="block";	
	}
	if(check=="No")
	{
		window.location.href='login.php';
	}
	
}

function registerstep1(frm)
{
	var creturn = true;
	var re =  /^[A-Za-z]\w{3,}$/;
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	document.getElementById('e_user_email').innerHTML 							=	'';
	document.getElementById('e_user_password').innerHTML 						=	'';
	document.getElementById('e_conf_user_password').innerHTML 					=	'';
	var user_email				= frm.user_email.value;
	var user_password			= frm.user_password.value;
	var conf_user_password		= frm.conf_user_password.value;
	if(user_email==''){
		document.getElementById('e_user_email').innerHTML	= '<font color="#BC3300">&nbsp;Enter email</font>';
		creturn						=	false;
	 }
	 
	 
	  if(user_email!=''){
		if(!isValidEmailStrict(user_email)){
		 document.getElementById('e_user_email').innerHTML = '<font color="#BC3300">&nbsp;Enter valid email id</font>';
		creturn						=	false;
			 }
	 } 
	 
	  if(user_password==''){
		document.getElementById('e_user_password').innerHTML 		= '<font color="#BC3300">&nbsp;Enter password</font>';
		creturn						=	false;
	 }
	 if(user_password!=''){
			 if(!re2.test(user_password)){
				document.getElementById('e_user_password').innerHTML = '<font color="#BC3300">Enter valid password (must be of 8 character)</font>';
				creturn						=	false;
			 }
	 }
	 
	   if(conf_user_password==''){
		document.getElementById('e_conf_user_password').innerHTML    = '<font color="#BC3300">&nbsp;Enter confirm password</font>';
		creturn						=	false;
	 }
	 
	  if(conf_user_password!=''){
			  if(conf_user_password!=user_password){
				document.getElementById('e_conf_user_password').innerHTML = '<font color="#BC3300">Password not matched</font>';
				creturn						=	false;
			 }
	 } 
	return creturn;
}


function substractValue(getID){
		if(document.getElementById(getID).value>1){
		document.getElementById(getID).value = 	parseInt(document.getElementById(getID).value) -1;
	}
}

function addValue(getID){
		document.getElementById(getID).value = 	parseInt(document.getElementById(getID).value) +1;
}

function checkcartvalues(frm){
	alert(frm);
	alert(frm.quantity.length)
	
	return false;
}

function checkquantity(tocheck,actaulval){
	document.getElementById('showP').innerHTML	=	"";
	alert(actaulval);
	if(!CheckNumeric(tocheck.value))
	{
		document.getElementById('showP').innerHTML	=	"Not a numeric value";
		document.getElementById(tocheck.id).value	=	actaulval;
	}
	if(tocheck.value<=0)
	{
		document.getElementById('showP').innerHTML	=	"Enter +ve value for quantity";
		document.getElementById(tocheck.id).value	=	actaulval;
	}
}


function checkoutvalidation(frm){
	var	creturn 			= true;
	var re =  /^[A-Za-z]\w{3,}$/; 
	var re2 =  /^[A-Za-z0-9]\w{7,}$/;
	var pattern = /[^a-zA-Z'\s]$/;
	//alert(frm); return false;
	document.getElementById('detail_error').innerHTML			=	'';
	document.getElementById('baddress_error').innerHTML			=	'';
	document.getElementById('saddress_error').innerHTML			=	'';

	var f_name			=	frm.f_name.value;
	var l_name			=	frm.l_name.value;
	var baddress		=	frm.baddress.value;
	var bzip_code		=	frm.bzip_code.value;
	var bcity			=	frm.bcity.value;
	var bstate			=	frm.bstate.value;
	var bcountry		=	frm.bcountry.value;
	var phone			=	frm.phone.value;
	var fax				=	frm.fax.value;
	var saddress		=	frm.saddress.value;
	var szip_code		=	frm.szip_code.value;
	var scity			=	frm.scity.value;
	var sstate			=	frm.sstate.value;	
	var scountry		=	frm.scountry.value;
	//var	contact_detail	=	frm.contact_detail.value
	
	 
 	 if(f_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter First Name';
		frm.f_name.focus();
		return false;
	 }
	 if(f_name!='')
	 {
		 if(!checkvalue(f_name)){
		    document.getElementById('detail_error').innerHTML = 'Enter Valid First Name';
			frm.f_name.focus();
			return false;
			 }
		 }
	  if(l_name==''){
		document.getElementById('detail_error').innerHTML = 'Enter Last Name';
		frm.l_name.focus();
		return false;
	    }
   	  if(l_name!='')
	  {
		  if(!checkvalue(l_name)){
			document.getElementById('detail_error').innerHTML = 'Enter Valid Last Name';
			frm.l_name.focus();
			return false;
				 }
		 }	 
	  if(baddress==''){
		document.getElementById('baddress_error').innerHTML = 'Enter Bussiness Address';
		frm.baddress.focus();
		return false;
	    }
		
		
	 if(bzip_code!='')
	  {
		 if(!isAlphanumeric(bzip_code)){
		    document.getElementById('baddress_error').innerHTML = 'Enter Valid Post Code';
			frm.bzip_code.focus();
			return false;
			 }
		 }
	if(bcity==''){
		document.getElementById('baddress_error').innerHTML = 'Enter City';
		frm.bcity.focus();
		return false;
	    }
   	  if(bcity!='')
	  {
		  if(!checkvalue(bcity)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid City';
			frm.bcity.focus();
			return false;
				 }
		 }	 
	if(bstate==''){
		document.getElementById('baddress_error').innerHTML = 'Enter State';
		frm.bstate.focus();
		return false;
	    }
   	  if(bstate!='')
	  {
		  if(!checkvalue(bstate)){
			document.getElementById('baddress_error').innerHTML = 'Enter Valid State';
			frm.bstate.focus();
			return false;
				 }
		 }	
	if(bcountry==''){
		document.getElementById('baddress_error').innerHTML = 'Select Country';
		frm.bcountry.focus();
		return false;
	    }
		
	if(bzip_code==''){
		document.getElementById('baddress_error').innerHTML = 'Enter Post Code';
		frm.bzip_code.focus();
		return false;
	    }	
	if(bzip_code!='')
	  {
		 if(!isAlphanumeric(bzip_code)){
		    document.getElementById('baddress_error').innerHTML = 'Enter Valid Post Code';
			frm.bzip_code.focus();
			return false;
			 }
		 }
	
		
	 if(saddress==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Shipping Address';
		frm.saddress.focus();
		return false;
	    }
		
	if(scity==''){
		document.getElementById('saddress_error').innerHTML = 'Enter City';
		frm.scity.focus();
		return false;
	    }
   	  if(scity!='')
	  {
		  if(!checkvalue(scity)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid City';
			frm.scity.focus();
			return false;
				 }
		 }	 
	if(sstate==''){
		document.getElementById('saddress_error').innerHTML = 'Enter State';
		frm.sstate.focus();
		return false;
	    }
   	  if(sstate!='')
	  {
		  if(!checkvalue(sstate)){
			document.getElementById('saddress_error').innerHTML = 'Enter Valid State';
			frm.sstate.focus();
			return false;
				 }
		 }	
	if(scountry==''){
		document.getElementById('saddress_error').innerHTML = 'Select Country';
		frm.scountry.focus();
		return false;
	    }
	if(szip_code==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Post Code';
		frm.szip_code.focus();
		return false;
	    }
	  if(szip_code!='')
	  {
		 if(!isAlphanumeric(szip_code)){
		    document.getElementById('saddress_error').innerHTML = 'Enter Valid Post Code';
			frm.szip_code.focus();
			return false;
			 }
		 }
	/*if(contact_detail=='')
		{
		document.getElementById('saddress_error').innerHTML = 'Enter Contact Information';
		frm.contact_detail.focus();
		return false;
		}*/
	 if(phone==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Phone Number';
		frm.phone.focus();
		return false;
	    }
		
	 if(fax==''){
		document.getElementById('saddress_error').innerHTML = 'Enter Fax';
		frm.fax.focus();
		return false;
	    }
	
	
 
	//alert(creturn);
	return creturn;
	
}

function checkpaymentmode(frm)
{
	document.getElementById('modeE').innerHTML	=	"";
	if(frm.payment[0].checked==false && frm.payment[1].checked==false)
	{
		document.getElementById('modeE').innerHTML	=	"Select Payment Mode";	
		frm.payment[0].focus();
		return false;	
	}
	return true;
}


function checkreferconetnt(frm){
	var	creturn 			= true;
	document.getElementById('refer_error').innerHTML			=	'';
	
	var yourname			=	frm.yourname.value;
	var youremail			=	frm.youremail.value;
	var toname				=	frm.toname.value;
	var toemail				=	frm.toemail.value;

	
 	 if(yourname==''){
		document.getElementById('refer_error').innerHTML = 'Enter Name';
		frm.yourname.focus();
		return false;
	 }
	 if(yourname!='')
	 {
		 if(!checkvalue(yourname)){
		    document.getElementById('refer_error').innerHTML = 'Enter Valid  Name';
			frm.yourname.focus();
			return false;
			 }
		 }
		 
	if(youremail==''){
		document.getElementById('refer_error').innerHTML = 'Enter Your Email';
		frm.youremail.focus();
		return false;
	    }	
	if(youremail!='')
	{
		if(!isValidEmailStrict(youremail)){
			 document.getElementById('refer_error').innerHTML = 'Enter Valid Email ';
			frm.youremail.focus();
			return false;
			}
	 }	 
	 if(toname==''){
		document.getElementById('refer_error').innerHTML = 'Enter Friend Name';
		frm.toname.focus();
		return false;
	 }
	 if(toname!='')
	 {
		 if(!checkvalue(toname)){
		    document.getElementById('refer_error').innerHTML = 'Enter Valid Name';
			frm.toname.focus();
			return false;
			 }
		 }		
	if(toemail==''){
		document.getElementById('refer_error').innerHTML = 'Enter Friend Email';
		frm.toemail.focus();
		return false;
	    }	
	if(toemail!='')
	{
		if(!isValidEmailStrict(toemail)){
			 document.getElementById('refer_error').innerHTML = 'Enter Valid Email ';
			frm.toemail.focus();
			return false;
			}
	 }	 
	//alert(creturn);
	return creturn;
	
}




function checknewsubscription(frm){
	var	creturn 			= true;
	document.getElementById('newsError').innerHTML			=	'';
	
	var subname				=	frm.subname.value;
	var subemail			=	frm.subemail.value;
	
 	 if(subname==''){
		document.getElementById('newsError').innerHTML = 'Enter Name';
		frm.subname.focus();
		return false;
	 }
	 if(subname!='')
	 {
		 if(!checkvalue(subname)){
		    document.getElementById('newsError').innerHTML = 'Enter Valid  Name';
			frm.subname.focus();
			return false;
			 }
		 }
		 
	if(subemail==''){
		document.getElementById('newsError').innerHTML = 'Enter Your Email';
		frm.subemail.focus();
		return false;
	    }	
	if(subemail!='')
	{
		if(!isValidEmailStrict(subemail)){
		    document.getElementById('newsError').innerHTML = 'Enter Valid Email ';
			frm.subemail.focus();
			return false;
			}
	 }
	if(frm.subscription[0].checked==false && frm.subscription[1].checked==false) 
	{
		 document.getElementById('newsError').innerHTML = 'Check Subscription';
		 frm.subscription[0].focus();
		 return false;
		}
	//alert(creturn);
	return creturn;
	
}


function validatesubscript(frm){
	var	creturn 			= true;
	document.getElementById('newsError').innerHTML			=	'';
	var subemail			=	frm.subemail.value;
	if(subemail==''){
		document.getElementById('newsError').innerHTML = 'Enter Your Email';
		frm.subemail.focus();
		return false;
	    }	
	if(subemail!='')
	{
		if(!isValidEmailStrict(subemail)){
		    document.getElementById('newsError').innerHTML = 'Enter Valid Email ';
			frm.subemail.focus();
			return false;
			}
	 }
	//alert(creturn);
	return creturn;
}

function checkheader(){
//	alert(document.getElementById('searchtxt').value);
	window.location.href="product-list.php?search="+document.getElementById('searchtxt').value;
//	return false;
}

function validationnew(frm){
	var creturn			=	true;
	document.getElementById('e_newemail').innerHTML	=	'';
	var newemail		=	frm.newemail.value;
	if(newemail!='')
		{
			if(!isValidEmailStrict(newemail)){
		    document.getElementById('e_newemail').innerHTML = 'Enter Valid Email ';
			creturn	=	false;
			}	
		}
	return creturn;
}