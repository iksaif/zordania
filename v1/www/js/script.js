/*******************************
* Par Iksaif                   *
*******************************/
function my_popup(file, param, h, w)
{
	window.open(cfg_url+'?file='+file+param+'&only_file=true',file,'height='+h+',width='+w+',left=100,top=100,resizable=yes,scrollbars=no,toolbar=no,status=no');
	return false;	
}
function lien_bg(url)
{
	if(window.opener)
	{
		window.opener.location.href = url;
		window.close();
	}
	else
	{
		window.location.href= url;
	}
	return false;
}

function setActiveStyleSheet(title) {
   var i, a, main;
   createCookie("style", title, 365);
   for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
     if(a.getAttribute("rel").indexOf("style") != -1
        && a.getAttribute("title")) {
       a.disabled = true;
       if(a.getAttribute("title") == title) a.disabled = false;
     }
   }
}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function toggle(id)
{
	var i = 0;
	
	if(getStateById("descr_"+id+"_"+i) != "none")
	{
		document.getElementById(id+"_toggle").innerHTML = '<img src="img/plus.png" alt="+" />';
		while(document.getElementById("descr_"+id+"_"+i))
		{
			hideById("descr_"+id+"_"+i);
			i++;
		}
	}
	else
	{
		document.getElementById(id+"_toggle").innerHTML = '<img src="img/minus.png" alt="-" />';
		while(document.getElementById("descr_"+id+"_"+i))
		{
			showById("descr_"+id+"_"+i);
			i++;
		}
	}
}

function atq_hide(i)
{
	while(document.getElementById("atq_"+i))
	{
		hideById("atq_"+i);
		i++;
	}
}

function atq_show(i)
{
	showById("atq_"+i);
	if(document.getElementById("atq_"+(i+1)))
		setTimeout("atq_show("+(1+i)+")",1500);
}

function getStateById(id)
{
	if (document.getElementById) {
	return document.getElementById(id).style.display;
	} else if (document.all) {
	return document.all[id].style.display;
	} else if (document.layers) {
	return document.layers[id].display;
	}	
}

function showById(id) {
	if (document.getElementById) {
	document.getElementById(id).style.display="block";
	} else if (document.all) {
	document.all[id].style.display="block";
	} else if (document.layers) {
	document.layers[id].display="block";
	}
}

function hideById(id) {
	if (document.getElementById) {
	document.getElementById(id).style.display="none";
	} else if (document.all) {
	document.all[id].style.display="none";
	} else if (document.layers) {
	document.layers[id].display="none";
	}
}