fileTail = "r="+Math.random();
styleL = document.createElement('style');

var coverLoad = document.createElement("div");
coverLoad.className = "coverLoad";
coverLoad.id = "coverLoad";
document.body.appendChild(coverLoad);

var loaderImg = document.getElementById("img");
var css = ".coverLoad {position: fixed;	top: 0px;bottom: 0px;	left: 0px;right: 0px; background-color: #ffffff; z-index: 5000; background-image: url('../app/img/imgLoader.gif'); background-size: 250px 250px; 	background-position: center center; background-repeat: no-repeat;}";

var  dp = document.createElement('script');
dp.src = "js/dp/build/jquery.datetimepicker.full.min.js?"+fileTail;
document.head.appendChild(dp);

var typeahead = document.createElement('script');
typeahead.src = 'js/typeahead.js?'+fileTail;


$(document).ready( function(){iniLoader();});

function iniLoader()
{
	
	if(imfoo == "login")
	{
		
		
		var mainGeneral = document.createElement('script');
		mainGeneral.src = 'js/mainGeneral.js?'+fileTail;
		var typeahead = document.createElement('script');
		typeahead.src = 'js/typeahead.js?'+fileTail;
		document.head.appendChild(mainGeneral);
		document.head.appendChild(typeahead);

		addCss("../app/css/styles.css?"+fileTail);
		addCssRule(css);
	}
	else
	{
		
		var mainGeneral = document.createElement('script');
		mainGeneral.src = 'js/mainGeneral.js?'+fileTail;
		var typeahead = document.createElement('script');
		typeahead.src = 'js/typeahead.js?'+fileTail;
		document.head.appendChild(mainGeneral);
		document.head.appendChild(typeahead);

		addCss("../app/css/styles.css?"+fileTail);
		addCssRule(css);
		
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