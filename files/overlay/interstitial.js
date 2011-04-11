//Interstitial Content Box v1.1- http://www.dynamicdrive.com/dynamicindex17/interstitial.htm
//Last modified: Nov 26th, 06' (New: disable webpage scrollbar, auto hide after x seconds options, 

var interstitialBox={
//1) list of files on server to randomly pick from and display
displayfiles: ['sites/default/files/overlay/impact.php'],

//2) display freqency: ["frequency_type", "frequency_value"]
displayfrequency: ["chance", "1"],

//3) HTML for the header bar portion of the interstitial box
defineheader: '<div class="headerbar"><a href="codebox" ><img src="sites/default/files/overlay/closeit.gif" style="border: 0" title="Close Box"/></a></div>',

//4) cookie setting: ["cookie_name", "cookie_path"]
cookiesetting: ["stitialcookie", "path=/"],

//5) bust caching of pages fetched via Ajax?
ajaxbustcache: true,

//6) Disable browser scrollbars while interstitial is shown (Only applicable in IE7/Firefox/Opera8+. IE6 will just auto scroll page to top)?
disablescrollbars: true,

//7) Auto hide Interstitial Box after x seconds (0 for no)?
autohidetimer: 0,

////No need to edit beyond here//////////////////////////////////

ie7: window.XMLHttpRequest && document.all && !window.opera,
ie7offline: this.ie7 && window.location.href.indexOf("http")==-1, //check for IE7 and offline
launch:false,
scrollbarwidth: 16,

ajaxconnect:function(url, thediv){
var page_request = false
var bustcacheparameter=""
if (window.XMLHttpRequest && !this.ie7offline) // if Mozilla, IE7 online, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE6 or below, or IE7 offline (for testing purposes)
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
page_request.onreadystatechange=function(){
interstitialBox.loadpage(page_request, thediv)
}
if (this.ajaxbustcache) //if bust caching of external page
bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
page_request.open('GET', url+bustcacheparameter, true)
page_request.send(null)
},

loadpage:function(page_request, thediv){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)){
document.getElementById("interContent").innerHTML=page_request.responseText
}
},

createcontainer:function(){
//write out entire HTML for Interstitial Box:
document.write('<div id="interContainer">'+this.defineheader+'<div id="interContent"></div></div><div id="interVeil"></div>')
this.interContainer=document.getElementById("interContainer") //reference interstitial container
this.interVeil=document.getElementById("interVeil") //reference veil
this.standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body //create reference to common "body" across doctypes
},


showcontainer:function(){
if (this.interContainer.style.display=="none") return //if interstitial box has already closed, just exit (window.onresize event triggers function)
var ie=document.all && !window.opera
var dom=document.getElementById
var scroll_top=(ie)? this.standardbody.scrollTop : window.pageYOffset
var scroll_left=(ie)? this.standardbody.scrollLeft : window.pageXOffset
var docwidth=(ie)? this.standardbody.clientWidth : window.innerWidth-this.scrollbarwidth
var docheight=(ie)? this.standardbody.clientHeight: window.innerHeight
var docheightcomplete=(this.standardbody.offsetHeight>this.standardbody.scrollHeight)? this.standardbody.offsetHeight : this.standardbody.scrollHeight
var objwidth=this.interContainer.offsetWidth
var objheight=this.interContainer.offsetHeight
this.interVeil.style.width=docwidth+"px" //set up veil over page
this.interVeil.style.height=docheightcomplete+"px" //set up veil over page
this.interVeil.style.left=0 //Position veil over page
this.interVeil.style.top=0 //Position veil over page
this.interVeil.style.visibility="visible" //Show veil over page
this.interContainer.style.left=docwidth/2-objwidth/2+"px" //Position interstitial box
var topposition=(docheight>objheight)? scroll_top+docheight/2-objheight/2+"px" : scroll_top+5+"px" //Position interstitial box
this.interContainer.style.top=Math.floor(parseInt(topposition))+"px"
this.interContainer.style.visibility="visible" //Show interstitial box
if (this.autohidetimer && parseInt(this.autohidetimer)>0 && typeof this.timervar=="undefined")
this.timervar=setTimeout("interstitialBox.closeit()", this.autohidetimer*1000)
},


closeit:function(){
	window.location='codebox'
this.interVeil.style.display="none"
this.interContainer.style.display="none"
if (this.disablescrollbars && window.XMLHttpRequest) //if disablescrollbars enabled and modern browsers- IE7, Firefox, Safari, Opera 8+ etc
this.standardbody.style.overflow="auto"
if (typeof this.timervar!="undefined") clearTimeout(this.timervar)

},

getscrollbarwidth:function(){
var scrollbarwidth=window.innerWidth-(this.interVeil.offsetLeft+this.interVeil.offsetWidth) //http://www.howtocreate.co.uk/emails/BrynDyment.html
this.scrollbarwidth=(typeof scrollbarwidth=="number")? scrollbarwidth : this.scrollbarwidth
},

hidescrollbar:function(){
if (this.disablescrollbars){ //if disablescrollbars enabled
if (window.XMLHttpRequest) //if modern browsers- IE7, Firefox, Safari, Opera 8+ etc
this.standardbody.style.overflow="hidden"
else //if IE6 and below, just scroll to top of page to ensure interstitial is in focus
window.scrollTo(0,0)
}
},

dotask:function(target, functionref, tasktype){ //assign a function to execute to an event handler (ie: onunload)
var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
if (target.addEventListener)
target.addEventListener(tasktype, functionref, false)
else if (target.attachEvent)
target.attachEvent(tasktype, functionref)
},

initialize:function(){
this.createcontainer() //write out interstitial container
this.ajaxconnect(this.displayfiles[Math.floor(Math.random()*this.displayfiles.length)], this.interContainer) //load page into content via ajax
this.dotask(window, function(){interstitialBox.hidescrollbar(); interstitialBox.getscrollbarwidth(); setTimeout("interstitialBox.showcontainer()", 100)}, "load")
this.dotask(window, function(){interstitialBox.showcontainer()}, "resize")
}
}

/////////////End of interstitialBox object declaration here ////////////////////////////////

function getCookie(Name){
var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
if (document.cookie.match(re)) //if cookie found
return document.cookie.match(re)[0].split("=")[1] //return its value
return null
}

function setCookie(name, value, days){
var expireDate = new Date()
//set "expstring" to either an explicit date (past or future)
if (typeof days!="undefined"){ //if set persistent cookie
var expstring=expireDate.setDate(expireDate.getDate()+parseInt(days))
document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()+"; "+interstitialBox.cookiesetting[1]
}
else //else if this is a session only cookie setting
document.cookie = name+"="+value+"; "+interstitialBox.cookiesetting[1]
}





//alert('hello');

var stitialvars=new Object() //temporary object to reference/ shorthand certain interstitialBox properties
stitialvars.freqtype=interstitialBox.displayfrequency[0] //"chance" or "cookie"
stitialvars.cookieduration=interstitialBox.displayfrequency[1] //"session" or int (integer specifying number of days)
stitialvars.cookiename=interstitialBox.cookiesetting[0] //name of cookie to use


if (stitialvars.freqtype=="chance"){ //IF CHANCE MODE
if (Math.floor(Math.random()*interstitialBox.displayfrequency[1])==0)
interstitialBox.launch=true
}
else if (stitialvars.freqtype=="cookie" && stitialvars.cookieduration=="session"){ //IF "SESSION COOKIE" MODE
if (getCookie(stitialvars.cookiename+"_s")==null){ //if session cookie is empty
setCookie(stitialvars.cookiename+"_s", "loaded")
interstitialBox.launch=true
}
}
else if (stitialvars.freqtype=="cookie" && typeof parseInt(stitialvars.cookieduration)=="number"){ //IF "PERSISTENT COOKIE" MODE
if (getCookie(stitialvars.cookiename)==null || parseInt(getCookie(stitialvars.cookiename))!=parseInt(stitialvars.cookieduration)){ //if persistent cookie is empty or admin has changed number of days to persist from that of the stored value (meaning, reset it)
setCookie(stitialvars.cookiename, stitialvars.cookieduration, stitialvars.cookieduration)
interstitialBox.launch=true
} 
}

if (interstitialBox.launch)
interstitialBox.initialize()


