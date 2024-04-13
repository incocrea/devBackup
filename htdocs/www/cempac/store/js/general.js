// APP START START
$(document).ready( function()
{
	brands = ["Tesa", "Parchesitos", "Kilométrico", "Norma", "Faber castell", "Primavera", "Pelikan", "Festicolor", "Ofiplus", "Offiesco", "Tdk", "Berol", "Doricolor", "Scribe", "Papyer", "Magicolor", "Kores", "Marden", "Sempertex", "Edding", "Expo", "Trazo", "Sharpie"];
	
	// liveRefresh();
});
function checkValidZone(loc)
{
	var pickValid = ["Armenia", "Ibague", "Manizales", "Neiva", "Pereira", "Tuluá", "Pasto", 
	"Pitalito Huila", "Florencia Caqueta"];

	if(pickValid.in_array(loc))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function getActualTop(reg)
{

	if(reg.DRANGE == "" || reg.DRANGE ==  null)
	{
		console.log("lol")
		actualTop = reg.BTOP;
	}
	else
	{
		var d1 = reg.DRANGE.split("<->")[0];
		var d2 = reg.DRANGE.split("<->")[1];
		
		var d3 = getNow(null, "1");
		
		if(d3 >= d1 && d3 < d2)
		{
			actualTop = reg.DTOPT;
		}
		else
		{
			actualTop = reg.BTOP;
		}
	}
	// console.log(d1)
	// console.log(d2)
	// console.log(d3)
	// console.log(actualTop)
	return actualTop;
}
function showTerms()
{
	$("#termsModal").modal("show");
}
function liveRefresh()
{
	var loc = window.location.href;
	
	if(loc.includes("192.168.1.58:9090"))
	{
		var imported = document.createElement('script');
		imported.src = 'js/live.js';
		document.head.appendChild(imported);
	}
	if(loc.includes("192.168.0.58:9090"))
	{
		var imported = document.createElement('script');
		imported.src = 'js/live.js';
		document.head.appendChild(imported);
	}
	
}
setCss();
function setCss()
{
	actualMainColor = language["cc"];
	
	style = document.createElement('style');
	
	
	
	var css = "#pExit {background-color: #43576d !important;}";
	addCssRule(css);
	var css = ".dropdown-item.active, .dropdown-item:active {background-color: #b9d9fb !important;}";
	addCssRule(css);
	var css = ".card-product {border-color: #ced4da;}";
	addCssRule(css);
	var css = ".modal {color: #000000;}";
	addCssRule(css);
	var css = ".condsLink {float: left; width: 100%;text-align:center; margin-bottom: 20px;}";
	addCssRule(css);
	var css = ".modalTerms {background-color: #eeeeee !important; width: 96%; margin-left: 2%; max-height: 400px; overflow-y: auto; color: #000000; text-align: justify; padding: 5px;}";
	addCssRule(css);
	addCssRule(css);
	var css = ".nav-link:hover {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".top-header {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".navbar-theme .navbar-nav .nav-link:hover, .navbar-theme .navbar-nav .show>.nav-link, .navbar-theme .navbar-nav .active>.nav-link {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-theme {border-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-theme {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".badge-theme {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".input-group-qty input[type='text'] {border-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".activePrice {color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".activePriceCart {color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".topGuide {color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".title {border-bottom: 3px solid "+actualMainColor+" !important;}";
	addCssRule(css);
	var css = ".form-control:focus {border-color: "+actualMainColor+" !important;}";
	addCssRule(css);
	var css = ".title>span {border-bottom: 3px solid "+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-outline-theme:hover {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-outline-theme {border-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-outline-theme {color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-outline-theme:hover {color: #ffffff !important;}";
	addCssRule(css);
	var css = ".price {color: "+actualMainColor+"!important;}";
	addCssRule(css);
	// var css = ".infoIcon {background-color: "+actualMainColor+"!important;}";
	// addCssRule(css);
	var css = ".custom-checkbox .custom-control-input:checked ~ .custom-control-label::before, .custom-radio .custom-control-input:checked ~ .custom-control-label::before {background-color: "+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".card-product:before {border-color: "+actualMainColor+"!important;}";
	addCssRule(css);
	
	var css = ".navbar-theme .navbar-nav .nav-link:hover, .navbar-theme .navbar-nav .show>.nav-link, .navbar-theme .navbar-nav .active>.nav-link {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	
	
	
	if(document.getElementsByClassName("col-2 col-sm-1 d-block d-lg-none").length > 0)
	{
		
		
		var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		if(w < 990)
		{
			
			document.getElementsByClassName("col-4 col-sm-4 col-md-3 col-lg-3 d-none d-sm-block")[0].className = "col-6 col-sm-6 col-md-4 col-lg-4 d-none d-sm-block marginTB";
			
			document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-6 col-sm-6 col-md-8 col-lg-8 marginTB";
			
			// if(imfoo != "checkout")
			// {
				
			// }
			// else
			// {
				// document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-6 col-sm-6 col-md-8 col-lg-8 marginTB";
			// }
			
			console.log("lol")
		
		}

	}
	
	
	
}
function addCssRule(css)
{
	if (style.styleSheet){style.styleSheet.cssText = css;}
	else{style.appendChild(document.createTextNode(css));}
	document.getElementsByTagName('head')[0].appendChild(style);
}
function closeTerms()
{
	$("#termsModal").modal("hide");
}
function alertBox(header, message)
{
	var tittle = document.getElementById("alertsBoxTitle");
	tittle.innerHTML = header;
	var content = document.getElementById("alertsBoxMessage");
	content.innerHTML = message;
	var accept = document.getElementById("acceptButton");
	accept.innerHTML = language["accept"];

	$("#alertsBox").modal("show");
}
function openContact()
{
	closeOffsetMenu();
	document.getElementById("nameField").value = "";
	document.getElementById("mailField").value = "";
	document.getElementById("messageField").value = "";
	showModal("contactModal");
}
function contactSend()
{
	var info = {};
	info.name = document.getElementById("nameField").value;
	info.mail = document.getElementById("mailField").value;
	info.message = document.getElementById("messageField").value;

	if(info.name == "" || info.mail == "" || info.message == "")
	{
		alertBox(language["alert"],language["mustFieldsContact"]);
		return;
	}
	
	sendAjax("users","contactSend",info,function(response)
	{
		var ans = response.message;
		alertBox(language["alert"],language["messageSent"]);
		hideModal("contactModal");
	});
}
function showModal(id)
{
	$("#"+id).modal("show");
}
function hideModal(id)
{
	$("#"+id).modal("hide");
}
function formatDate(date)
{

	var parts = date.split("-");
	
	var months = ["", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
	
var ndate = parts[2]+" de "+ months[parseInt(parts[1])]+" de "+parts[0];
	
	return ndate;
}
