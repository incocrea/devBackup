$(document).ready( function(){iniLoader();});
function iniLoader()
{
	fileTail = "r="+Math.random();
	
	var mainGeneral = document.createElement('script');
	mainGeneral.src = 'js/main.js?'+fileTail;
	
	addCss("css/main.css?"+fileTail);

	setTimeout(function(){document.head.appendChild(mainGeneral);},300);

}
function addCss(fileName) 
{
	var link = $("<link />",{rel: "stylesheet",type: "text/css",href: fileName });
	$('head').append(link);
}