/*
	========================================================
	Module: Linktracker
	--------------------------------------------------------
	Copyright: Damien Majer
	License: http://creativecommons.org/licenses/by-sa/3.0/
	http://www.damienmajer.com
	--------------------------------------------------------
	This addon may be used free of charge.
	--------------------------------------------------------
	EE 1 version by Oliver Heine http://utilitees.silenz.org
	========================================================
	File: linktracker.js
	--------------------------------------------------------
	Purpose: Adds mousedown events to all links with an id.
             Makes an XMLHttpRequest to the module's action
             addclick() once one of the links is clicked.
	========================================================
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF
	ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
	LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
	FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO 
	EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
	FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
	AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE 
	OR OTHER DEALINGS IN THE SOFTWARE.
	========================================================
*/

function addLinkTracker()
{
	if (!document.getElementsByTagName) return false;

	linksElements = document.getElementsByTagName('a')
	for (var i = 0; i < linksElements.length; i++) 
	{
		// Add event to all links with id 
		if (! linksElements[i].getAttribute('id') ) {
		} else {
     addEvent(linksElements[i], 'mousedown', recordClick, false);
		}
	}
}


function recordClick(e)
{

	if (typeof e == 'undefined')
		var e = window.event;

	var source;
	if (typeof e.target != 'undefined') 
	{
		source = e.target;
	} else if (typeof e.srcElement != 'undefined') {
		source = e.srcElement;
	} else {
		return true;
	}

	if (source.nodeType == 3)
		source = source.parentNode;
		
	var id, target, URL, label
	
	if( source.tagName == "IMG" )
	{
		if( source.parentNode.tagName == "A" )
		{
			id = source.parentNode.getAttribute('id');
			target = source.parentNode.getAttribute('href');
		}
		label = escape(source.getAttribute("alt"));		
	}else{
		id = source.getAttribute('id');
		target = source.getAttribute('href');		
		label = escape(source.childNodes[0].nodeValue);
	}
	url = document.location.href;
	//---------------------------------
	
	var pars = '';	
	apiurl = actionurl + "id=" + escape(id) + "&label=" + label + "&target=" + encode64(target) + "&url=" + encode64(url) + "&rand="+Math.random();
	sendRequest(apiurl,passThrough);

	return false;	
}



function passThrough( req )
{
	// alert( req.responseText );
}

//------------------------------------------------------------------

function encode64(input) {
   var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
   var output = "";
   var chr1, chr2, chr3;
   var enc1, enc2, enc3, enc4;
   var i = 0;

   do {
      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);

      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;

      if (isNaN(chr2)) {
         enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
         enc4 = 64;
      }

      output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) + 
         keyStr.charAt(enc3) + keyStr.charAt(enc4);
   } while (i < input.length);
   
   return output;
}

function sendRequest(url,callback,postData) {
	var req = createXMLHTTPObject();

	if (!req) return;
	var method = (postData) ? "POST" : "GET";
	req.open(method,url,true);
	req.setRequestHeader('User-Agent','XMLHTTP/1.0');
	if (postData)
		req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	req.onreadystatechange = function () {
		if (req.readyState != 4) return;
		callback(req);
	}
	if (req.readyState == 4) return;
	req.send(postData);
}

var XMLHttpFactories = [
	function () {return new XMLHttpRequest()},
	function () {return new ActiveXObject("Msxml2.XMLHTTP")},
	function () {return new ActiveXObject("Msxml3.XMLHTTP")},
	function () {return new ActiveXObject("Microsoft.XMLHTTP")}
];

function createXMLHTTPObject() {
	var xmlhttp = false;
	for (var i=0;i<XMLHttpFactories.length;i++) {
		try {
			xmlhttp = XMLHttpFactories[i]();
		}
		catch (e) {
			continue;
		}
		break;
	}
	return xmlhttp;
}

//------------------------------------------------------------------

document.getElementsByClassName = function(className) 
{
  var children = document.getElementsByTagName('*') || document.all;
  var elements = new Array();
  for (var i = 0; i < children.length; i++) {
    var child = children[i];
    var classNames = child.className.split(' ');
    for (var j = 0; j < classNames.length; j++) {
      if (classNames[j] == className) {
        elements.push(child);
        break;
      }
    }
  }
  return elements;
}

function addEvent(elm, evType, fn, useCapture) 
{
  // cross-browser event handling for IE5+, NS6 and Mozilla By Scott Andrew 
  if (elm.addEventListener) { 
    elm.addEventListener(evType, fn, useCapture); 
    return true; 
  } else if (elm.attachEvent) { 
    var r = elm.attachEvent('on' + evType, fn); 
    return r; 
  } else {
    elm['on' + evType] = fn;
  }
}

