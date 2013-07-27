//Disable caching of AJAX responses
$(document).ready(function(){
	$.ajaxSetup ({
		cache: false,
		async:false
	});

	/*
	$('.loading')
    .hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    });
    */

	/*$('.timepicker').timepicker({
		showPeriodLabels: false,
		minutes: {
			starts: 0,                  // first displayed minute
			ends: 55,                   // last displayed minute
			interval: 5                 // interval of displayed minutes
		}
	});*/
});

//display notification message
function show_notification(msg, msg_type)
{
	$(document).ready(function(){
		if(msg_type=='success')
		{
			$("#notifications").html('<div class="clean-ok">'+msg+'</div>');
		}
		else
		if(msg_type=='normal')
		{
			$("#notifications").html('<div class="clean-white">'+msg+'</div>');
		}
		else
		if(msg_type=='warning')
		{
			$("#notifications").html('<div class="clean-yellow">'+msg+'</div>');
		}
		else
		if(msg_type=='error')
		{
			$("#notifications").html('<div class="clean-error">'+msg+'</div>');
		}

		$("#notifications").show().animate({opacity: 1.0}, 2000).fadeOut(1500);
	});
}

//get loading message
function get_loading()
{
	var loading='<div id="ajaxLoadAni"><img src="images/ajax-loader.gif" /><span>Loading...</span></div>';
	return loading;
}

//check all/ check none checkboxes
function toggle_check()
{
	var checked_status = document.getElementById("check_all").checked;

	var theForm = document.form_data;
    for (i=0; i<theForm.elements.length; i++) {
        if (theForm.elements[i].name=='check_id[]')
            theForm.elements[i].checked = checked_status;
    }
}

//check if any checkbox is checked or not
function any_checked()
{
	return_val=false;
	var theForm = document.form_data;
    for (i=0; i<theForm.elements.length; i++) {
        if (theForm.elements[i].name=='check_id[]' && theForm.elements[i].checked === true )
		{
			return_val=true;
		}
    }

	return return_val;
}


//trim string
function trim(str)
{
    if(!str || typeof str != 'string')
        return null;

    return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

//convert string to slug
function slug(str)
{
	slug_str=str.split(/[^a-zA-Z0-9-]+/).join("-");
	slug_str=slug_str.toLowerCase();
	return(slug_str);
}


//====== RETURN CURRENT PAGE NAME ======//
function current_page()
{
	return location.href.split('/').pop();
}

//====== FORMAT NUMBER TO CURRENCY ======//
function CurrencyFormatted(amount) {
        var i = parseFloat(amount);
        if(isNaN(i)) { i = 0.00; }
        var minus = '';
        if(i < 0) { minus = '-'; }
        i = Math.abs(i);
        i = parseInt((i + .005) * 100);
        i = i / 100;
        s = new String(i);
        if(s.indexOf('.') < 0) { s += '.00'; }
        if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
        s = minus + s;
        return s;
}

//====== GET QUERYSTRING VARIABLE VALUE ======//
function getQueryVariable(variable) {
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}

//====== GET YOUTUBE KEY FROM VIDEO LINK ======//
function get_youtube_key(youtube_link) {
	var youtubeVideoKey = youtubeLink.substr(youtube_link.lastIndexOf("v=") + 2, 11);
	return youtubeVideoKey;
}

//====== REDIRECT TO SPECIFIC URL ======//
function redirect(url) {
	window.location = url;
}

//====== TOGGLE VISIBILITY OF AN ELEMENT ======//
function toggle_visibility(id) {
   var e = document.getElementById(id);
   if(e.style.display == 'block')
	  e.style.display = 'none';
   else
	  e.style.display = 'block';
}

//====== CHECK EMAIL ADDRESS VALID/INVALID ======//
function email_check(str)
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   return false
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		return false
	}

	 if (str.indexOf(at,(lat+1))!=-1){
		return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		return false
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
		return false
	 }

	 if (str.indexOf(" ")!=-1){
		return false
	 }

	 return true
}

//====== HIDE VALIDATION ERROR ======//
function hide_error(control)
{
	$(control).fadeOut("fast");
}

//====== DATE VALIDATION IN DD-MM-YYYY FORMAT ======//
//Declaring valid date character, minimum year and maximum year
var dtCh= "-";
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

// Check Decimal number
function isDecimal(sText)
{
	var ValidChars = "0123456789.";
	var IsDecimal=true;
	var Char;

	for (i = 0; i < sText.length && IsDecimal == true; i++)
	{
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1)
		{
			IsDecimal = false;
		}
	}
	return IsDecimal;
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
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strDay=dtStr.substring(0,pos1)
	var strMonth=dtStr.substring(pos1+1,pos2)
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
		//alert("The date format should be : dd/mm/yyyy")
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


//====== TIME VALIDATION IN HH:MM FORMAT ======//
function IsTime(strTime)
{
	pattern='^((\\d)|(0\\d)|(1\\d)|(2[0-3]))\\:((\\d)|([0-5]\\d))$';
	if(strTime.match(new RegExp(pattern)))
	{
		console.log("Valid");
	}
	else
	{
		console.log("Invalid");
	}
}

//======  delete checked action ======//
function delete_checked()
{
	if(!any_checked())
	{
		alert("Please select atleast one record to delete.");
	}
	else
	{
		if(confirm("Are you sure you want to delete seleted record(s)?")==true)
		{
			document.form_data.submit();
		}
	}
	return false;
}

//======  delete checked action ======//
function delete_single()
{
	if(confirm("Are you sure you want to delete this record?")==true)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//======  delete checked action ======//
function resend_sms()
{
	if(confirm("Are you sure you want to send this message again?")==true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
