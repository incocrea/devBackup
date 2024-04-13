fileTail = "r="+Math.random();
jQuery(document).ready( function(){iniLoader();});
function iniLoader()
{
	if(imfoo == "home"){var root = "";}
	else{root ="../";}
	
	var main = document.createElement('script');
	main.src = root+'app/js/main.js?'+fileTail;
	
	var typeahead = document.createElement('script');
	typeahead.src = 'app/js/typeahead.js?'+fileTail;
	
	document.head.appendChild(typeahead);
	
	var  dp = document.createElement('script');
	dp.src = root+'app/js/dp/build/jquery.datetimepicker.full.min.js?'+fileTail;
	document.head.appendChild(dp);
	
	var  charts = document.createElement('script');
	charts.src = root+'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js?'+fileTail;
	document.head.appendChild(charts);
	
	// var  tp = document.createElement('script');
	// tp.src = root+'app/js/tp/jquery.timepicker.js?'+fileTail;
	// document.head.appendChild(tp);
	
	var croppie = document.createElement('script');
	croppie.src = root+'app/croppie/croppie.js?'+fileTail;
	document.head.appendChild(croppie);
	
	setTimeout(function(){document.head.appendChild(main);},300);
	
	addCss(root+"app/css/main.css?"+fileTail);
	addCss(root+"app/css/bootstrap/css/bootstrap.min.css");
	addCss(root+"app/croppie/croppie.css?"+fileTail);
	// addCss(root+"app/js/tp/jquery.timepicker.css?"+fileTail);
}
function addCss(fileName) 
{
	var link = jQuery("<link />",{rel: "stylesheet",type: "text/css",href: fileName });
	jQuery('head').append(link);
}