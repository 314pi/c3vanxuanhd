/*
* @version		$Id: slider.js 2008 vargas $ @package Joomla
*/
var fn_csbustcachevar=0;
var fn_enabletransition=1;
var fn_csloadstatustext="Loading...";
var fn_csexternalfiles=[];
var fn_enablepersist=true;
var fn_slidernodes=new Object();
var fn_csloadedobjects="";

function FN_ContentSlider(sliderid, autorun, customNextText){
	var slider=document.getElementById(sliderid);
	if (typeof customNextText!="undefined" && customNextText!="")
		slider.nextText=customNextText;
	fn_slidernodes[sliderid]=[];
	FN_ContentSlider.loadobjects(fn_csexternalfiles);
	var alldivs=slider.getElementsByTagName("div");
	for (var i=0; i<alldivs.length; i++){
		if (alldivs[i].className=="opacitylayer")
			slider.opacitylayer=alldivs[i];
		else if (alldivs[i].className=="fn_news"){
			fn_slidernodes[sliderid].push(alldivs[i]);
			if (typeof alldivs[i].getAttribute("rel")=="string")
				FN_ContentSlider.ajaxpage(alldivs[i].getAttribute("rel"), alldivs[i]);
		}
	}
	FN_ContentSlider.buildpagination(sliderid);
	var loadfirstcontent=true;
	if (fn_enablepersist && getCookie(sliderid)!=""){
		var cookieval=getCookie(sliderid).split(":"); 
		if (document.getElementById(cookieval[0])!=null && typeof fn_slidernodes[sliderid][cookieval[1]]!="undefined"){ 
			FN_ContentSlider.turnpage(cookieval[0], parseInt(cookieval[1]));
			loadfirstcontent=false;
		}
	}
	if (loadfirstcontent==true)
		FN_ContentSlider.turnpage(sliderid, 0);
	if (typeof autorun=="number" && autorun>0)
		window[sliderid+"timer"]=setTimeout(function(){FN_ContentSlider.autoturnpage(sliderid, autorun)}, autorun);
}

FN_ContentSlider.buildpagination=function(sliderid){
	var slider=document.getElementById(sliderid);
	var paginatediv=document.getElementById("paginate-"+sliderid);
	var pcontent="";
	for (var i=0; i<fn_slidernodes[sliderid].length; i++)
		pcontent+='<a href="#" onClick=\"FN_ContentSlider.turnpage(\''+sliderid+'\', '+i+'); return false\">'+(i+1)+'</a> ';
	pcontent+='<a href="#" style="font-weight: bold;" onClick=\"FN_ContentSlider.turnpage(\''+sliderid+'\', parseInt(this.getAttribute(\'rel\'))); return false\">'+(slider.nextText || "")+'</a>';
	paginatediv.innerHTML=pcontent;
	paginatediv.onclick=function(){
	if (typeof window[sliderid+"timer"]!="undefined")
		clearTimeout(window[sliderid+"timer"]);
	}
}

FN_ContentSlider.turnpage=function(sliderid, thepage){
	var paginatelinks=document.getElementById("paginate-"+sliderid).getElementsByTagName("a"); //gather pagination links
	for (var i=0; i<fn_slidernodes[sliderid].length; i++){
		paginatelinks[i].className="";
		fn_slidernodes[sliderid][i].style.display="none";
	}
	paginatelinks[thepage].className="selected";
	if (fn_enabletransition){
		if (window[sliderid+"fadetimer"])
			clearTimeout(window[sliderid+"fadetimer"]);
		this.setopacity(sliderid, 0.1);
	}
	fn_slidernodes[sliderid][thepage].style.display="block";
	if (fn_enabletransition)
		this.fadeup(sliderid, thepage);
	paginatelinks[paginatelinks.length-1].setAttribute("rel", thenextpage=(thepage<paginatelinks.length-2)? thepage+1 : 0);
	if (fn_enablepersist)
		setCookie(sliderid, sliderid+":"+thepage);
}

FN_ContentSlider.autoturnpage=function(sliderid, autorunperiod){
	var paginatelinks=document.getElementById("paginate-"+sliderid).getElementsByTagName("a"); 
	var nextpagenumber=parseInt(paginatelinks[paginatelinks.length-1].getAttribute("rel")); 
	FN_ContentSlider.turnpage(sliderid, nextpagenumber);
	window[sliderid+"timer"]=setTimeout(function(){FN_ContentSlider.autoturnpage(sliderid, autorunperiod)}, autorunperiod);
}

FN_ContentSlider.setopacity=function(sliderid, value){
	var targetobject=document.getElementById(sliderid).opacitylayer || null; 
	if (targetobject && targetobject.filters && targetobject.filters[0]){
		if (typeof targetobject.filters[0].opacity=="number")
			targetobject.filters[0].opacity=value*100;
		else
			targetobject.style.filter="alpha(opacity="+value*100+")";
		}
	else if (targetobject && typeof targetobject.style.MozOpacity!="undefined")
		targetobject.style.MozOpacity=value;
	else if (targetobject && typeof targetobject.style.opacity!="undefined")
		targetobject.style.opacity=value;
	targetobject.currentopacity=value;
}

FN_ContentSlider.fadeup=function(sliderid){
	var targetobject=document.getElementById(sliderid).opacitylayer || null;
	if (targetobject && targetobject.currentopacity<1){
		this.setopacity(sliderid, targetobject.currentopacity+0.1);
		window[sliderid+"fadetimer"]=setTimeout(function(){FN_ContentSlider.fadeup(sliderid)}, 100);
	}
}

function getCookie(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); 
	if (document.cookie.match(re))
		return document.cookie.match(re)[0].split("=")[1];
	return "";
}

function setCookie(name, value){
	document.cookie = name+"="+value;
}

FN_ContentSlider.ajaxpage=function(url, thediv){
	var page_request = false;
	var bustcacheparameter="";
	if (window.XMLHttpRequest)
		page_request = new XMLHttpRequest();
	else if (window.ActiveXObject){
		try {
		page_request = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e){
		try{
		page_request = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e){}
		}
	}
	else
		return false;
	thediv.innerHTML=fn_csloadstatustext;
	page_request.onreadystatechange=function(){
		FN_ContentSlider.loadpage(page_request, thediv);
	}
	if (fn_csbustcachevar)
		bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime();
	page_request.open('GET', url+bustcacheparameter, true);
	page_request.send(null);
}

FN_ContentSlider.loadpage=function(page_request, thediv){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
		thediv.innerHTML=page_request.responseText;
}

FN_ContentSlider.loadobjects=function(externalfiles){ 
	for (var i=0; i<externalfiles.length; i++){
		var file=externalfiles[i];
		var fileref="";
		if (fn_csloadedobjects.indexOf(file)==-1){ 
			if (file.indexOf(".js")!=-1){
				fileref=document.createElement('script');
				fileref.setAttribute("type","text/javascript");
				fileref.setAttribute("src", file);
			}
			else if (file.indexOf(".css")!=-1){
				fileref=document.createElement("link");
				fileref.setAttribute("rel", "stylesheet");
				fileref.setAttribute("type", "text/css");
				fileref.setAttribute("href", file);
			}
		}
		if (fileref!=""){
			document.getElementsByTagName("head").item(0).appendChild(fileref);
			fn_csloadedobjects+=file+" "; 
		}
	}
}
