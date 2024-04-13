fileTail = "r="+Math.random();
jQuery(document).ready( function(){iniLoader();});
function iniLoader()
{
	if(typeof imfoo !== 'undefined') 
	{
		if(imfoo == "Seattle")
		{localStorage.setItem("mainLocation", imfoo);var root = "";}
		if(imfoo == "catDisplay"){root ="../";}
		if(imfoo == "manage"){root ="../";}
		if(imfoo == "clientdetail"){root ="../";}
	}
	else{root ="../";}
	
	var main = document.createElement('script');
	main.src = root+'app/js/main.js?'+fileTail;
	
	var croppie = document.createElement('script');
	croppie.src = root+'app/croppie/croppie.js?'+fileTail;
	document.head.appendChild(croppie);
	
	var fontSelect = document.createElement('script');
	fontSelect.src = root+'app/js/jquery.fontpicker.js?'+fileTail;
	
	var zoomGallery = document.createElement('script');
	zoomGallery.src = root+'app/js/zoomify.js?'+fileTail;
	
	setTimeout(function()
	{
		document.head.appendChild(main);
		document.head.appendChild(fontSelect);
		document.head.appendChild(zoomGallery);
		
	},300);
	
	addCss(root+"app/css/main.css?"+fileTail);
	addCss(root+"app/css/zoomify.css?"+fileTail);
	addCss(root+"app/css/bootstrap/css/bootstrap.min.css?"+fileTail);
	addCss(root+"app/css/jquery.fontpicker.css?"+fileTail);
	addCss(root+"app/croppie/croppie.css?"+fileTail);
	


}
function addCss(fileName) 
{
	var link = jQuery("<link />",{rel: "stylesheet",type: "text/css",href: fileName });
	jQuery('head').append(link);
}