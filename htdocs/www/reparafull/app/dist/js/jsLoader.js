fileTail = "r="+Math.random();
styleL = document.createElement('style');

var coverLoad = document.createElement("div");
coverLoad.className = "coverLoad";
coverLoad.id = "coverLoad";
document.body.appendChild(coverLoad);

var loaderImg = document.getElementById("img");

$(document).ready( function(){iniLoader();});

function iniLoader()
{
	
	if(imfoo == "secure")
	{
		var css = ".coverLoad {position: fixed;	top: 0px;bottom: 0px;	left: 0px;right: 0px; background-color: #ffffff; z-index: 5000; background-image: url('../images/imgLoader.gif'); background-size: 250px 250px; 	background-position: center center; background-repeat: no-repeat;}";
		addCssRule(css);
		var main = document.createElement('script');
		main.src = 'js/main.js?'+fileTail;
		setTimeout(function(){document.head.appendChild(main);},300);
		addCss("css/main.css?"+fileTail);
	}
	else if(imfoo == "footer")
	{
		var mainFooter = document.createElement('script');
		mainFooter.src = 'js/mainFooter.js?'+fileTail;
		setTimeout(function(){document.head.appendChild(mainFooter);},300);
		addCss("css/main.css?"+fileTail);
	}
	else if(imfoo == "recover")
	{
		
		var css = ".coverLoad {position: fixed;	top: 0px;bottom: 0px;	left: 0px;right: 0px; background-color: #ffffff; z-index: 5000; background-image: url('images/imgLoader.gif'); background-size: 250px 250px; 	background-position: center center; background-repeat: no-repeat;}";
		
		addCssRule(css);
		
		var mainGeneral = document.createElement('script');
		mainGeneral.src = 'js/mainGeneral.js?'+fileTail;
		document.head.appendChild(mainGeneral);
		
	}
	else
	{
		var css = ".coverLoad {position: fixed;	top: 0px;bottom: 0px;	left: 0px;right: 0px; background-color: #ffffff; z-index: 5000; background-image: url('img/imgLoader.gif'); background-size: 250px 250px; 	background-position: center center; background-repeat: no-repeat;}";
		addCssRule(css);
		
		var mainGeneral = document.createElement('script');
		mainGeneral.src = 'dist/js/mainGeneral.js?'+fileTail;
		
		var typeahead = document.createElement('script');
		typeahead.src = 'dist/js/typeahead.js?'+fileTail;
		
		document.head.appendChild(mainGeneral);
		document.head.appendChild(typeahead);
		
	}
}
function addCss(fileName) 
{
	var link = $("<link />",{rel: "stylesheet",type: "text/css",href: fileName });
	$('head').append(link);
}
function addCssRule(css)
{
	if (styleL.styleSheet){styleL.styleSheet.cssText = css;}
	else{styleL.appendChild(document.createTextNode(css));}
	document.getElementsByTagName('head')[0].appendChild(styleL);
}