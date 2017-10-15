// bbCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);


// Define the bbCode tags
bbcode = new Array();
//bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
bbtags = new Array('[b]','[/b]','[i]','[/i]','[list]','[/list]','[img]','[/img]','[url]','[/url]','[quote]', '[/quote]', '[u]', '[/u]', '[center]', '[/center]');
imageTag = false;


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function insertValueAfterSelection(textarea, val){ // insertValueAfterSelection + decaleCurseur + replaceScrollBar + focus
	if (textarea.selectionEnd >= 0 && textarea.setSelectionRange) {
		var initialScrollTop = textarea.scrollTop;
		var textLength = textarea.textLength;
		var selEnd = textarea.selectionEnd; // to mimic IE, assume the caret is the end of the selection
		var s1 = (textarea.value).substring(0, selEnd);
		var s2 = (textarea.value).substring(selEnd, textLength);
		textarea.value = s1 + val + s2;
		textarea.setSelectionRange(selEnd+val.length, selEnd+val.length);
		textarea.scrollTop = initialScrollTop;
		textarea.focus();
	} else if (textarea.createTextRange && textarea.caretPos) {
      var caretPos = textarea.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + val + ' ' : caretPos.text + val;
      textarea.focus();
   } else if(document.selection) {
		textarea.focus();
		range = document.selection.createRange();
		range.moveStart('character', range.text.length);
		range.text = val;
		range.select();
   } else { // dans ce cas extrême on ajoute simplement le texte à la fin de la textarea et on focus()
      textarea.value  += val;
      textarea.focus();
   }
}

function emoticon(text, message) {
   var txtarea = document.getElementById(message);
   text = ' ' + text + ' ';
   insertValueAfterSelection(txtarea, text);
}

function bbfontstyle(bbopen, bbclose, message) {
	var txtarea = document.getElementById(message);

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		theSelection = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber, message) {
	var txtarea = document.getElementById(message);
	
	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			insertValueAfterSelection(txtarea, bbtags[butnumber + 1]); // txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.getElementById("addbbcode' + butnumber + '").value');
			eval('document.getElementById("addbbcode' + butnumber + '").value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		var originRange = document.selection.createRange();
		var theSelection = originRange.text;
		if(theSelection){
			// Add tags around selection
			var range = originRange.duplicate();
			range.text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			originRange.moveEnd("character", bbtags[bbnumber].length+theSelection.length+bbtags[bbnumber+1].length);
			originRange.select();
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}

	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				insertValueAfterSelection(txtarea, bbtags[butnumber + 1]); // txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.getElementById("addbbcode' + butnumber + '").value');
				eval('document.getElementById("addbbcode' + butnumber + '").value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			return;
	} else { // Open tags
		if (imageTag && (bbnumber != 6)) {		// Close image tag before adding another
			insertValueAfterSelection(txtarea, bbtags[7]); // txtarea.value += bbtags[7];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.getElementById('addbbcode6').value = "Img";	// Return button back to normal state
			imageTag = false;
		}

		// Open tag
		insertValueAfterSelection(txtarea, bbtags[bbnumber]); // txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval('document.getElementById("addbbcode' + bbnumber + '").value += "*"');
		return;
	}
	storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var initialScrollTop = txtarea.scrollTop;
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;	
	txtarea.setSelectionRange(selStart, selEnd+open.length+close.length);
	txtarea.scrollTop = initialScrollTop;
	txtarea.focus();
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
