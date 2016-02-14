/*
* Par Iksaif
*/

/* Permet d'afficher un popup ... a n'utiliser que si on permet aussi d'afficher une page normale */
function myPopup(file, param, w, h)
{
	window.open(cfg_url+'?file='+file+param+'&display=popup',file,'height='+h+',width='+w+',left=100,top=100,resizable=yes,scrollbars=no,toolbar=no,status=no');
	return false;
}

/* Ou un lien dans la fenêtre qui a ouvert la page courante .. ouvre un lien dans la même fenêtre si c'est pas possible */
function goOpener(url)
{
	if(window.opener)
	{
		window.opener.location.href = url;
		window.close();
	} else {
		window.location.href= url;
	}
	return false;
}


/*
* Récuperer l'objet xmlhttp
*/
function getHTTPObject()
{
	var xmlhttp = false;

	/* Compilation conditionnelle d'IE */
	/*@cc_on
	@if (@_jscript_version >= 5)
		try
		{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (E)
			{
			xmlhttp = false;
			}
		}
	@else
		xmlhttp = false;
	@end @*/

	/* on essaie de creer l'objet si ce n'est pas deja fait */
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
	{
		try
		{
			xmlhttp = new XMLHttpRequest();
		}
		catch (e)
		{
			xmlhttp = false;
		}
	}
	return xmlhttp;
}

/*
* Faire une requette a partir de machins
*/
function ajaxRequest(xmlhttp, method, url, data, callback)
{
	if (!xmlhttp)
		return false;

	xmlhttp.onreadystatechange = callback;

	if(method == "GET")
	{
		if(data == 'null')
		{
			xmlhttp.open("GET", url, true); //ouverture asynchrone
		}
		else
		{
			xmlhttp.open("GET", url+"?"+data, true);
		}
		xmlhttp.send(null);
	}
	else if(method == "POST")
	{
		xmlhttp.open("POST", url, true); //ouverture asynchrone
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
	return true;
}

