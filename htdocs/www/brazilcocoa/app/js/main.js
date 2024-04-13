// APP START START
$(document).ready( function()
{
	$(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
    $(this).removeClass("btn-default").addClass("btn-primary");   
	});
	
	if (window.history && window.history.pushState)
	{
        $(window).on('popstate', function () {
            if (!window.userInteractionInHTMLArea) 
			{
				hide_pop();
				hide_pop_form();
			}
		if(window.onBrowserHistoryButtonClicked ){
		window.onBrowserHistoryButtonClicked ();
            }
        });
    }
	
	vm = {
		// REGFIELDS
		regUName : ko.observable(),
		regUMail : ko.observable(),
		regUaddress : ko.observable(),
		regUphone : ko.observable(),
		regUpass : ko.observable(),
		regUsex : ko.observable(),
		regUbday : ko.observable(),
		regUtype : ko.observable()
	}
	
	if(!localStorage.getItem("lup")){localStorage.setItem("lup", "v1.0");}
	
	ko.applyBindings(vm);
	tail = "?r="+Math.random();
	loadCheck();
	liveRefresh();
});
function loadCheck()
{

	// if (location.protocol != 'https:')
	// {
		// location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
	// }
	
	langPickIni();
	infoIcon = "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>";
	
	actualSaveType = "1";
	theCroppie = null;
	document.querySelector('#userLoginBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	document.querySelector('#userPassBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	
	// document.getElementById("regCountrySelector").onchange = function(){pickedCountry(this.value)};
	// document.getElementById("regRegionSelector").onchange = function(){pickedDto(this.value)};
	
	jQuery.datetimepicker.setLocale("es");
	jQuery('#regBday').datetimepicker({timepicker:false,format:'Y-m-d',}).on('change', function(){$('.xdsoft_datetimepicker').hide(); var str = $(this).val(); str = str.split(".");});
	
	var picSelector = document.getElementById("picSelector");
	picSelector.addEventListener('change', handleFileSelect, false);
	
	
	prepareImgCropper();
	
	videoPromoRuning = 0;
	saveDateState = "0";
	editDateCode = "";
	jQuery.datetimepicker.setLocale("es");
	
	prepareImgCropper2();
	
	document.getElementById("agendaToday").innerHTML = "Hoy "+formatDate(getNow(0,"justDay"));
	
	
	jQuery('#finidate').datetimepicker();
	jQuery('#fenddate').datetimepicker();
	
	jQuery('#iniDate').datetimepicker();
	jQuery('#endDate').datetimepicker();
	
	// jQuery('#finidate').datetimepicker
	// ({
			// timepicker:false,
			// format:'Y-m-d',
		// }).on('change', function() {
			// $('.xdsoft_datetimepicker').hide();
			// var str = $(this).val();
			// str = str.split(".");
			
	// });
	
	// jQuery('#fenddate').datetimepicker
	// ({
			// timepicker:false,
			// format:'Y-m-d',
		// }).on('change', function() {
			// $('.xdsoft_datetimepicker').hide();
			// var str = $(this).val();
			// str = str.split(".");
			
	// });
	

}
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	imported.src = 'js/live.js';
	if(loc.includes("192")){document.head.appendChild(imported);}
}
function checkDirect()
{

	if(findGetParameter("first_name"))
	{
		dbname = findGetParameter("first_name");
		dbemail = findGetParameter("email");
		dbname = dbname.replaceAll("+", " ");
	}
	else
	{
		return;
	}
	console.log(dbname)
	console.log(dbemail)
	if(dbname != null)
	{
		directBuy = 1;
		sendPayCO("lifetime");
		document.getElementById("loginBox").style.display = "none";
	}
	else
	{
		directBuy = 0;
	}

	
	
}
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
function findGetParameter(parameterName) 
{
	var result = null,
	tmp = [];
	location.search
	.substr(1)
	.split("&")
	.forEach(function (item) 
	{
		tmp = item.split("=");
		if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
	});
	
	return result;
}
function langPickIni()
{
	
	if (!localStorage.getItem("langPl")) 
	{
		lang = "es_co"; 
		langGetIni(lang);
	}
	else
	{
		lang = localStorage.getItem("langPl");
		langGetIni(lang);
	}

}
function langGetIni(l) 
{
	var info ={};
	info.lang = l;
	
	
	
	sendAjax("lang","langGet",info,function(response)
	{
		
		language = response.message;
		
		
		var lastUp = localStorage.getItem("lup");
		var newUp = language["lup"];
		
		
		
		if(lastUp != newUp)
		{
			getNocache = 1;
			cacheRefresh();
			return;
		}
		
		
		setLang();
		
		checkLogin();

		
		// var dtoSelector = document.getElementById("regRegionSelector");
		// dtoSelector.innerHTML = '<option id="regRegionBlank" value="">'+language["regRegionBlank"]+'</option>';
		
		checkDirect();
		
	});
}
function clearCa()
{
	location.reload(true);
}
function cacheRefresh()
{
	localStorage.setItem("lup", language["lup"]);
	
	if(localStorage.getItem("aud"))
	{
		localStorage.removeItem("aud");
	}
	
	window.location.reload(true);
}
function setLang()
{
	for (var text in language)
	{
		
		if(text == "platInstrucctions"){continue}
		
		if(document.getElementById(text))
		{
			var element = document.getElementById(text);
			element.innerHTML = language[text];

			if(element.type == "text" || element.type == "password"){element.placeholder = language[text];}
			if(element.type == "textarea" || element.type == "password"){element.innerHTML = "";element.placeholder = language[text];}
		}
	}
}
function resSet()
{
	var width = document.getElementById('mainContainerWeb').offsetWidth;
	var mainMid = document.getElementById('mainContainerWeb');
	
	centerer(document.getElementById("mainContainerWeb"));
	centererLogin(document.getElementById("loginBox"));
}
function setMenuItems(value)
{
	
	
	mainMenu = document.getElementById("mainMenu");
	mainMenu.innerHTML = "";
	
	document.getElementById("sShop").style.display = "none";
	document.getElementById("sServs").setAttribute( 'style', 'display: none !important' );
	
	if(value == "1")
	{
		
		mainMenu.appendChild(menuCreator("sHome", "menHome"));
		
		if(aud.UTYPE == "E")
		{
			// mainMenu.appendChild(menuCreator("bcClients", "menClients"));
			// UNBCOMMENT TO RESTORE MY CLIENTS
			// document.getElementById("bcClients").setAttribute( 'style', 'display: flex !important' );
			// document.getElementById("bcClients").setAttribute( 'style', 'display: flex !important' );
			mainMenu.appendChild(menuCreator("sControl", "menControl"));
			document.getElementById("bcClients").setAttribute( 'style', 'display: none !important' );
			document.getElementById("sGame").setAttribute( 'style', 'display: none !important' );
		}
		else
		{
			document.getElementById("bcClients").setAttribute( 'style', 'display: none !important' );
		}
		
		
		
		mainMenu.appendChild(menuCreator("sAgenda", "menAgenda"));
		// mainMenu.appendChild(menuCreator("sShop", "menShop"));
		// mainMenu.appendChild(menuCreator("sServs", "sesBlog"));
		mainMenu.appendChild(menuCreator("sBlog", "menBlog"));
		// mainMenu.appendChild(menuCreator("sGame", "menGame"));
		mainMenu.appendChild(menuCreator("goMyWeb", "menGoMyWeb"));
		mainMenu.appendChild(menuCreator("goMyGames", "menGoGames"));
		mainMenu.appendChild(menuCreator("goWeb", "menGoWeb"));
		mainMenu.appendChild(menuCreator("goUrl", "menGoUrl"));
		mainMenu.appendChild(menuCreator("sExit", "menExit"));
		
	}

}
function goMyWeb()
{
	window.open("mysite/index.html?id="+aud.UCODE , 'blank');
}
function menuCreator(id, txt, custom)
{
		var iface = "if"+id.split("menu")[1];
        
		var item = document.createElement("a");
		item.href = "#"+id;
		item.className = "nav-link js-scroll-trigger";
		item.innerHTML = language[txt];
		if(custom != null)
		{
			item.innerHTML = custom;
		}
		if(id == "sExit")
		{
			item.onclick = function()
			{
				item.href = "#sProd";
				logout();
				$('.navbar-collapse').collapse('hide');
			}
			$('.navbar-collapse').collapse('hide');
		}
		else if(id == "goWeb")
		{
			item.onclick = function()
			{
				var newWin = window.open("http://brazilcocoa.com/");             

				if(!newWin || newWin.closed || typeof newWin.closed=='undefined') 
				{ 
					// POPUP BLOCKED
					alertBox(language["alert"], language["popBlocked"], 300);
				}
				else
				{
					console.log("opended")
				}
				$('.navbar-collapse').collapse('hide');
				
			}
		}
		else if(id == "goUrl")
		{
			item.onclick = function()
			{
				setTimeout(function(){showSellerUrl() }, 2000);
				$('.navbar-collapse').collapse('hide');
			}
		}
		else if(id == "goMyGames")
		{
			item.onclick = function(){connectAG();}
		}
		else if(id == "sControl")
		{
			item.onclick = function()
			{
				console.log("control");
				controlRefresh(0);
				$('.navbar-collapse').collapse('hide');
			}
		}
		else
		{
			item.onclick = function(){$('.navbar-collapse').collapse('hide');}
		}
		var li = document.createElement("li");
		li.className = "nav-item";
		li.appendChild(item);
		
		return li;
}
function showSellerUrl()
{
	
	// actualShopUrl = "http://192.168.0.60:9090/www/instashop/stores/store150/index.php?link=index&ucode="+aud.UCODE;
	actualShopUrl = "https://miplataforma.co/stores/store150/index.php?link=index&ucode="+aud.UCODE;
	
	alertBox(language["alert"], language["shareSellerLink"], 300);
	
	
}
function copyShopLink()
{
	var input = document.getElementById("hiddenInput");
	input.value = actualShopUrl;
	input.select();
	input.setSelectionRange(0, 99999);
	input.className = "hiddenInput";
	document.execCommand("copy");
	alertBox(language["alert"], language["copiedLink"], 300);
}
function connectAG()
{
	var info = {};
	info.umail = aud.EMAIL;
	info.bcdata = aud;
	
	console.log(info);

	sendAjax("users","connectAG",info,function(response)
	{
		var ans = response.message;
		var url = "https://www.incocrea.com/algratin/?bcdirectlo182b8457fb9157d0eb3a32c65e3ab423"+ans;
		// var url = "http://192.168.0.60:9090/www/algratin/?bcdirectlo182b8457fb9157d0eb3a32c65e3ab423"+ans;
		
		
		if(ans != "")
		{
			document.getElementById("gamesFrame").src = url;
		}
		else
		{
			console.log("no exist");
		}
		
		
		
	});
}
// IFLOAD
function ifLoad(code)
{
	var ifc = document.getElementById(code);
	var box = document.getElementById("wa");
	var limbo = document.getElementById("hidden");
	if(box.children.length > 0)
	{
		limbo.appendChild(box.children[0]);
	}

	box.appendChild(ifc);
	
	if(code == "ifAdmin"){}

	
}
// APP START END
// LOGIN AND SESSION START
function checkLogin()
{

	var ancho = document.getElementById("mainContainerWeb").offsetWidth;
	if(ancho <= 768)
	{
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");
		history.pushState("", "Brazil Cocoa", "");

	}

	if (window.localStorage.getItem("aud")) 
	{

		var workArea = document.getElementById("mainContainerWeb");
		workArea.style.display = "block";
		var loginCover = document.getElementById("loginArea");
		loginCover.style.display = "none";
		
		var c = localStorage.getItem("aud");
		var info = {};
		info.c = c;

		sendAjax("users","rlAud",info,function(response)
		{
			aud = response.message;
			

			if(aud.STATUS == "0"){alertBox(language["alert"],language["userIsBan"],300);logOut();return;}
			
			setMenuItems("1");
			
			// if(aud.HP == "1")
			// {
				// document.getElementById("imageSample").src = "ppics/"+aud.UCODE+".jpg"
			// }
			// else
			// {
				// document.getElementById('imageSample').src = "ppics/dummy.jpg";
			// }
			
			var profPanel = document.getElementById("agPanelE");
			profPanel.style.display = "none";
			document.getElementById("mbcServTime").value = aud.SERVTIME;
			
			if(aud.UTYPE != "E")
			{
				
				profPanel.style.display = "none";
			}
			else
			{
				
				profPanel.style.display = "flex";
				
			}
			refreshPros(aud.PROS);
			refreshProducts();
			
			var today = getNow().split(" ")[0];
			document.getElementById("finidate").value = today+" 00:00:00";
			document.getElementById("fenddate").value = today+" 23:59:00";
			
			
			
			controlRefresh(0);
			
		});
		

	}
	else
	{
		var workArea = document.getElementById("mainContainerWeb");
		workArea.style.display = "none";
		var loginCover = document.getElementById("loginArea");
		loginCover.style.display = "block";

		if(localStorage.getItem("aud"))
		{
			localStorage.removeItem("aud");
		}
		setTimeout(function(){ resSet() }, 200);
	}
	
	if(self !== top) 
	{
		window.parent.setHeight();
	}
	
	if(!localStorage.getItem("lastMail"))
	{
		document.getElementById("userLoginBox").value = localStorage.getItem("lastMail");
	}
	
	
}
function login()
{
	var info = {};

	var email = document.getElementById("userLoginBox").value; 
	var pin = encry(document.getElementById("userPassBox").value); 

	if(email == "")
	{
		alertBox(language["alert"],language["sys005"],300);
		return;
	}
	if(pin == "")
	{
		alertBox(language["alert"],language["sys006"],300);
		return;
	}
	
	info.autor = email;
	info.pssw = pin;

	sendAjax("users","login",info,function(response)
	{
		var ans = response.message;
		
		if(ans == "Disabled")
		{
				alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Este usuario se encuentra desactivado.",300);
				return;
		}

		if(response.status)
		{

			localStorage.setItem("lastMail", document.getElementById("userLoginBox").value);
			aud = ans;
			actualUcode = aud.UCODE;
			actualUname = aud.BNAME;
			localStorage.setItem("aud",actualUcode);
			var loginCover = document.getElementById("loginArea");
			loginCover.style.display = "none";
			var workArea = document.getElementById("mainContainerWeb");
			workArea.style.display = "block";
			var profPanel = document.getElementById("agPanelE");
			if(aud.UTYPE != "E"){profPanel.style.display = "none";}
			else{profPanel.style.display = "flex";}
			document.getElementById("mbcServTime").value = aud.SERVTIME;
			refreshPros(aud.PROS);
			refreshProducts();
			setMenuItems("1");
		}
		else
		{
			alertBox(language["alert"],language["missAuth"],300);
		}
		
		if(!localStorage.getItem("lastMail"))
		{
			document.getElementById("userLoginBox").value = localStorage.getItem("lastMail");
		}
		
		
		
		var today = getNow().split(" ")[0];
		console.log(today)
		
		document.getElementById("finidate").value = today+" 00:00:00";
		document.getElementById("fenddate").value = today+" 23:59:00";
		controlRefresh(0);
		
		
	});

}
function refreshPros(list)
{
	var picker = document.getElementById("mbcSelect");
	picker.innerHTML = "";
	
	actualProList = list;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		var option = document.createElement("option");
		option.value = item.PRCODE;
		option.innerHTML = item.PRNAME;
		
		picker.appendChild(option);
	}
}
function logout()
{
	// hide_pop();
	hide_pop_form();
	var loginCover = document.getElementById("loginArea");
	loginCover.style.display = "block";
	var workArea = document.getElementById("mainContainerWeb");
	workArea.style.display = "none";
	localStorage.removeItem("aud");

	actualUtype = null;
	aud = null;

	document.getElementById("loginTitle1").innerHTML = language["loginTitle1"];
	document.getElementById("loginTitle2").innerHTML = language["loginTitle2"];
	resSet();


}
// LOGIN AND SESSION END
// REG AND PROFILE START
function openRegForm()
{
	
	document.getElementById("regAcceptButton").innerHTML = language["regAcceptButton"];
	document.getElementById("regAcceptButton").className = "dualButton";
	document.getElementById("regUMail").disabled = false;
	document.getElementById("regUphone").disabled = false;
	document.getElementById("conditionsAcceptLink").style.display = "table";
	document.getElementById("regBox").style.height = "300px";
	formBox("regBox",language["regTitle"],600);
	uFormClear();
	regMode = 1;
	condsFrom = "reg";
}
function openProForm()
{
	document.getElementById("regAcceptButton").innerHTML = language["regSaveButton"];
	document.getElementById("regAcceptButton").className = "dualButton";
	document.getElementById("regBox").style.height = "280px";
	regMode = 0;
	condsFrom = "";
	document.getElementById("regUMail").disabled = true;
	
	
	document.getElementById("conditionsAcceptLink").style.display = "none";

	var info = {};
	info.ucode = aud.UCODE;
	
	// actualUserType = aud.UTYPE;
	actualUserType = "E";
	
	sendAjax("users","getUdata",info,function(response)
	{
		var ans = response.message;
		
		vm.regUName(ans.NAME);
		vm.regUMail(ans.EMAIL);
		vm.regUaddress(ans.ADDRESS);
		vm.regUphone(ans.PHONE);
		vm.regUpass( "******");
		vm.regUsex(ans.SEX);
		vm.regUbday(ans.BDAY);
		vm.regUtype(ans.UTYPE);
		
		console.log(ans.PHONE)
		
		if(ans.PHONE == "Mi teléfono aquí")
		{
			document.getElementById("regUphone").disabled = false;
		}
		else
		{
			document.getElementById("regUphone").disabled = true;
		}
		
		document.getElementById("regCountrySelector").value = ans.COUNTRY;
		// $("#regCountrySelector").trigger("change");
		actualUdpto =  ans.DPTO;
		actualUcity =  ans.CITY;
		
		document.getElementById("regRegionSelector").value = ans.DPTO;
		document.getElementById("regCitySelector").value = ans.CITY;
		
		// setTimeout(function()
		// {
			// var selector = document.getElementById("regRegionSelector");
			// var options = selector.children;
			
			// for(var i=0; i<options.length; i++)
			// {
				// var option = options[i].innerHTML.toUpperCase();
				
				// if(option == actualUdpto)
				// {
					// options[i].selected = true;
					// $("#regRegionSelector").trigger("change");
					// break
				// }
			// }
		// }, 50);
		
		// setTimeout(function()
		// {

			// var selector = document.getElementById("regCitySelector");
			// var options = selector.children;
			
			// for(var i=0; i<options.length; i++)
			// {
				// var option = options[i].innerHTML.toUpperCase();
				
				// if(option == actualUcity)
				// {
					// options[i].selected = true;
					// break
				// }
			// }
		// }, 150);

		actualEditPass = ans.PASSWD;
		
		formBox("regBox",language["miProfileTitle"],600);
		
	});
	
}
function getCdata(phone)
{
	if(phone != "")
	{
		var info = {};
		info.phone = phone;
		info.ucode = aud.UCODE;
	
		console.log(info);	
		sendAjax("users","getCdata",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			var udata = response.message.udata;
			var services = response.message.services;
			var pros = response.message.pros;
			
			if(udata.length > 0)
			{
				document.getElementById("scname").value = udata[0].NAME;
				document.getElementById("scmail").value = udata[0].EMAIL;
				
				document.getElementById("stcname").value = udata[0].NAME;
				document.getElementById("stcmail").value = udata[0].EMAIL;
			}
			else
			{
				document.getElementById("scname").value = "";
				document.getElementById("scmail").value = "";
			}
			actualservices = services;
			setServices(services);
			setPros(pros);
			
		});
	}
	
}
function setServices(services)
{
	var picker = document.getElementById("scservice");
	picker.innerHTML = "";
	
	var picker2 = document.getElementById("stcservice");
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.innerHTML = "Selecciona servicio";
	option.value = "";
	
	picker.appendChild(option);
	
	var option = document.createElement("option");
	option.innerHTML = "Selecciona servicio";
	option.value = "";
	
	picker2.appendChild(option);
	
	for(var i=0; i<services.length; i++)
	{
		var item = services[i];
		
		var option = document.createElement("option");
		option.innerHTML = item.DETAIL;
		option.value = item.SRCODE;
		picker.appendChild(option);
		
		var option = document.createElement("option");
		option.innerHTML = item.DETAIL;
		option.value = item.SRCODE;
		picker2.appendChild(option);
		
	}
}
function setPros(pros)
{
	var picker = document.getElementById("scpro");
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.innerHTML = "Selecciona profesional";
	option.value = "";
	picker.appendChild(option);
	
	for(var i=0; i<pros.length; i++)
	{
		var item = pros[i];
		
		var option = document.createElement("option");
		option.innerHTML = item.PRNAME;
		option.value = item.PRCODE;
		picker.appendChild(option);
		
	}
}
function setActualPoints(code)
{
	for(var i=0; i<actualservices.length; i++)
	{
		var item  = actualservices[i];
		if(item.SRCODE == code)
		{
			actualSerPoints = item.GIVE;
			break;
		}
	}
}
function saveSale()
{
	
	var info = {};
	console.log(aud)
	
	
	
	info.COUNTRY = aud.COUNTRY;
	info.DPTO = aud.DPTO;
	info.CITY = aud.CITY;
	info.STNAME = aud.NAME;
	info.STCODE = aud.UCODE;
	info.DATE = getNow();
	info.SAVETYPE = actualSaveType;
	
	

	
	if(actualSaveType == "1")
	{
		info.UPHONE = document.getElementById("scCell").value;
		info.UNAME = document.getElementById("scname").value;
		info.UMAIL = document.getElementById("scmail").value;
		info.SECODE = document.getElementById("scservice").value;
		info.SENAME = $("#scservice option:selected" ).text();
		info.SEVALUE = document.getElementById("scprice").value;
		info.PROCODE = document.getElementById("scpro").value;
		info.PRONAME = $("#scpro option:selected" ).text();
		info.BONIF = document.getElementById("scBonus").value;
	
	
		if(info.UPHONE == ""){alertBox(language["alert"], language["mustCphone"], 300);	return;}
		if(info.UNAME == ""){alertBox(language["alert"], language["mustCname"], 300);	return;}
		if(info.UMAIL == ""){alertBox(language["alert"], language["mustCmail"], 300);	return;}
		if(info.SECODE == ""){alertBox(language["alert"], language["mustCservice"], 300);	return;}
		if(info.SEVALUE == ""){alertBox(language["alert"], language["mustCserviceVal"], 300);	return;}
		if(info.PROCODE == ""){alertBox(language["alert"], language["mustCpro"], 300); return;}
		if(info.COMISION == ""){alertBox(language["alert"], language["mustCom"], 300);	return;}
		
		info.SESCORE = actualSerPoints;
		info.COMISION = document.getElementById("scpercentage").value;
		info.OBS = document.getElementById("scobs").value;
		console.log("save 1")
	
	}
	
	if(actualSaveType == "2")
	{
		info.PDETAIL = document.getElementById("scproduct").value;
		info.PVALUE = document.getElementById("scpprice").value;
		info.PQTY = document.getElementById("scppqty").value;
		info.BONIF = document.getElementById("prBonus").value;
		
		if(info.PDETAIL == ""){alertBox(language["alert"], language["mustProduct"], 300); return;}
		if(info.PQTY == ""){alertBox(language["alert"], language["mustProductQ"], 300); return;}
		if(info.PVALUE == ""){alertBox(language["alert"], language["mustProductV"], 300); return;}

		console.log("save 2")
		
	}

	if(actualSaveType == "3")
	{
		console.log("save 3")
		info.SPENDETAIL = document.getElementById("spendDet").value;
		info.SPENDVALUE = document.getElementById("spendPrice").value;

	}
	
	if(actualSaveType == "4")
	{
		info.UPHONE = document.getElementById("stcCell").value;
		info.UNAME = document.getElementById("stcname").value;
		info.UMAIL = document.getElementById("stcmail").value;
		info.SECODE = document.getElementById("stcservice").value;
		info.SENAME = $("#stcservice option:selected" ).text();
		info.CDESC = document.getElementById("stcdesc").value;
	
	
		if(info.UPHONE == ""){alertBox(language["alert"], language["mustCphone"], 300);	return;}
		if(info.UNAME == ""){alertBox(language["alert"], language["mustCname"], 300);	return;}
		if(info.UMAIL == ""){alertBox(language["alert"], language["mustCmail"], 300);	return;}
		if(info.SECODE == ""){alertBox(language["alert"], language["mustCservice"], 300);	return;}

		info.OBS = document.getElementById("stcobs").value;
		console.log("save 4")
	
	}
	
	document.getElementById("saveSaleB1").onclick = function (){console.log("locked");return;}
	document.getElementById("saveSaleB2").onclick = function (){console.log("locked");return;}
	document.getElementById("saveSaleB3").onclick = function (){console.log("locked");return;}
	document.getElementById("saveSaleB4").onclick = function (){console.log("locked");return;}
	
	sendAjax("users","saveSale",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		controlRefresh(0);
		
		document.getElementById("saveSaleB1").onclick = function (){saveSale();}
		document.getElementById("saveSaleB2").onclick = function (){saveSale();}
		document.getElementById("saveSaleB3").onclick = function (){saveSale();}
		document.getElementById("saveSaleB4").onclick = function (){saveSale();}
		
		document.getElementById("scCell").value = "";
		document.getElementById("stcCell").value = "";
		document.getElementById("scname").value = "";
		document.getElementById("stcname").value = "";
		document.getElementById("scmail").value = "";
		document.getElementById("stcmail").value = "";
		document.getElementById("scservice").value = "";
		document.getElementById("stcservice").value = "";
		document.getElementById("scpro").value = "";
		document.getElementById("scpercentage").value = "";
		document.getElementById("scprice").value = "";
		document.getElementById("scproduct").value = "";
		document.getElementById("scpprice").value = "";
		document.getElementById("scobs").value = "";
		document.getElementById("spendDet").value = "";
		document.getElementById("spendPrice").value = "";
		document.getElementById("stcdesc").value = "";
		document.getElementById("stcobs").value = "";
		
	});
	
}
function enderRow(line)
{
        var row = document.createElement("div");
        row.className = "rowT";
        
        for(var i=0; i<line.length; i++)
        {
                var content = line[i];
                
                var cell = document.createElement("div");
                cell.className = "column totalCell";
                cell.setAttribute('data-label',name);
                cell.innerHTML = decodeURIComponent(content);
                
                row.appendChild(cell);
        }
        
        return row;
}
function controlRefresh(expo)
{
	// SET FILTERS SET COMM
	
	var info = {};
	info.fscCell = document.getElementById("fscCell").value;
	info.fscservice = document.getElementById("fscservice").value;
	info.finidate = document.getElementById("finidate").value;
	info.fenddate = document.getElementById("fenddate").value;
	info.expo = expo;
	info.actualSaveType = actualSaveType;
	info.stcode = aud.UCODE;
	
	
	
	info.index = "";
	// return;
	
	sendAjax("users","getControList",info,function(response)
	{
		
		var ans = response.message;
		var fname = response.fname;
		console.log(ans)
		
		if(actualSaveType == "1"){tableCreator("controListS", ans);}
		if(actualSaveType == "2"){tableCreator("controListP", ans);}
		if(actualSaveType == "3"){tableCreator("controListG", ans);}
		if(actualSaveType == "4"){tableCreator("controListSt", ans);}
		
		if(info.expo == 1)
		{
			
			var url = "control/"+fname+".xls";
			console.log(url)
			downloadReport(decry(url));
		}
		
	});
}
function downloadReport(url) 
{
	document.getElementById('downframe').setAttribute("href", url);
	document.getElementById('downframe').click();
};
function pickMoveMode(pick)
{
	console.log(pick);
	
	document.getElementById("fscCell").value = "";
	document.getElementById("fscservice").value = "";
	// document.getElementById("finidate").value = "";
	// document.getElementById("fenddate").value = "";
	document.getElementById("scname").value = "";
	document.getElementById("scmail").value = "";
	document.getElementById("stcname").value = "";
	document.getElementById("stcmail").value = "";
	document.getElementById("stcobs").value = "";
	
	
	
	if(pick == "1")
	{
		document.getElementById("serviceSale").style.display = "flex";
		document.getElementById("productSale").style.display = "none";
		document.getElementById("boxSale").style.display = "none";
		document.getElementById("statesSale").style.display = "none";
		
		document.getElementById("controListP").style.display = "none";
		document.getElementById("controListS").style.display = "table";
		document.getElementById("controListG").style.display = "none";
		document.getElementById("controListSt").style.display = "none";

		document.getElementById("cellBoxF").style.display = "block";
		document.getElementById("servBoxF").style.display = "block";
		
		document.getElementById("moveTile").innerHTML = "Control venta servicios";

	}
	if(pick == "2")
	{
		document.getElementById("serviceSale").style.display = "none";
		document.getElementById("productSale").style.display = "flex";
		document.getElementById("boxSale").style.display = "none";
		document.getElementById("statesSale").style.display = "none";
		
		document.getElementById("controListP").style.display = "table";
		document.getElementById("controListS").style.display = "none";
		document.getElementById("controListG").style.display = "none";
		document.getElementById("controListSt").style.display = "none";
		
		document.getElementById("cellBoxF").style.display = "none";
		document.getElementById("servBoxF").style.display = "none";
		
		document.getElementById("moveTile").innerHTML = "Control venta productos";
	}
	if(pick == "3")
	{
		document.getElementById("serviceSale").style.display = "none";
		document.getElementById("productSale").style.display = "none";
		document.getElementById("statesSale").style.display = "none";
		document.getElementById("boxSale").style.display = "flex";
		
		document.getElementById("controListP").style.display = "none";
		document.getElementById("controListS").style.display = "none";
		document.getElementById("controListSt").style.display = "none";
		document.getElementById("controListG").style.display = "table";
		
		document.getElementById("cellBoxF").style.display = "none";
		document.getElementById("servBoxF").style.display = "none";
		
		document.getElementById("moveTile").innerHTML = "Control gastos de caja";
	}
	if(pick == "4")
	{
		document.getElementById("statesSale").style.display = "flex";
		document.getElementById("serviceSale").style.display = "none";
		document.getElementById("productSale").style.display = "none";
		document.getElementById("boxSale").style.display = "none";
		
		document.getElementById("controListP").style.display = "none";
		document.getElementById("controListS").style.display = "none";
		document.getElementById("controListSt").style.display = "table";
		document.getElementById("controListG").style.display = "none";
		
		
		document.getElementById("cellBoxF").style.display = "block";
		document.getElementById("servBoxF").style.display = "block";
		
		document.getElementById("moveTile").innerHTML = "Fichas de ingreso";

	}
	
	
	actualSaveType = pick;
	controlRefresh(0);
}
function condsFromReg()
{
	condsFrom = "reg";
	formBox("conditionsBox",language["conditionsBoxTitle"],600);
}
function hideConds()
{
	if(condsFrom == "reg")
	{
		hide_pop_form();
		formBox("regBox",language["regTitle"],600);
	}
	else
	{
		hide_pop_form();
	}
}
function uFormClear()
{
	vm.regUName("");
	vm.regUMail("");
	vm.regUaddress("");
	vm.regUphone("");
	vm.regUpass("");
	vm.regUsex("");
	vm.regUbday("");
	
	document.getElementById("regCountrySelector").value = ("");
	document.getElementById("regRegionSelector").value = ("");
	document.getElementById("regCitySelector").value = ("");
	
	
	document.getElementById("condCheck").checked = false;
	
}
function checkReg()
{

	infoReg = {};
	
	infoReg.name = $("#regUName").val();
	infoReg.mail = $("#regUMail").val();
	infoReg.country = $("#regCountrySelector").val();
	infoReg.dpto = $("#regRegionSelector").val();
	infoReg.city = $("#regCitySelector").val();
	infoReg.sex = $("#regSexSelector").val();
	infoReg.bday = $("#regBday").val();
	// infoReg.btype = $("#regTypeSelector").val();
	infoReg.btype = "E";
	infoReg.address = $("#regUaddress").val();
	infoReg.phone = $("#regUphone").val();
	infoReg.pass = $("#regUpass").val();
	infoReg.lang = lang;
	
	var condBox = document.getElementById("condCheck");
	
	if(infoReg.name == ""){alertBox(language["alert"],language["sys011"],300);return}
	if(infoReg.mail == ""){alertBox(language["alert"],language["sys005"],300);return}
	// if(!validateEmail(infoReg.mail))
	// {
		// alertBox(language["alert"], language["sys005"],300);
		// return;
	// }
	if(infoReg.address == ""){alertBox(language["alert"],language["sys017"],300);return}
	if(infoReg.phone == ""){alertBox(language["alert"],language["sys018"],300);return}
	if(infoReg.pass == ""){alertBox(language["alert"],language["sys006"],300);return}
	if($("#regCountrySelector option:selected").text() == language["regCountryBlank"]){alertBox(language["alert"],language["sys014"],300);return}
	if(infoReg.dpto.capitalize() == language["regRegionBlank"]){alertBox(language["alert"],language["sys015"],300);return}
	if(infoReg.city.capitalize() == language["regCityBlank"]){alertBox(language["alert"],language["sys016"],300);return}
	
	if(infoReg.sex.capitalize() == ""){alertBox(language["alert"],language["sys021"],300);return}
	
	if(infoReg.bday.capitalize() == ""){alertBox(language["alert"],language["sys022"],300);return}
	
	if(infoReg.btype.capitalize() == ""){alertBox(language["alert"],language["sys023"],300);return}

	if(infoReg.pass.length < 6)
	{
		alertBox(language["alert"], language["sys007"],300);
		return;
	}
	
	if( infoReg.pass.match(/[\<\>!#\$%^&\,]/) ) 
	{
		alertBox(language["alert"], language["sys008"],300);
		return;
	}
	
	if(condsFrom == "reg")
	{
		if(!condBox.checked)
		{
			alertBox(language["alert"], language["sys020"],300);
			return;
		}
	}
	
	console.log(infoReg)
	
	if(regMode == 1)
	{
		passConfirm();
	}
	else
	{
		uedSave();
	}
}
function uedSave()
{
	if(infoReg.pass == "******")
	{
		infoReg.pass = actualEditPass;
		infoReg.passChanged = "0";
	}
	else
	{
		infoReg.passChanged = "1";
	}
	infoReg.isreging = "0";
	sendAjax("users","register",infoReg,function(response)
	{
		if(response.message == "pcompleted")
		{
			alertBox(language["alert"],language["pcompleted"],300);
		}
		else
		{
			alertBox(language["alert"],language["sys019"],300);
		}
		hide_pop_form();
		aud.NAME = infoReg.name;
		aud.CITY = infoReg.city;
		
		if(actualUserType != infoReg.btype)
		{
			logout();
		}
		else
		{
			refreshProducts();
		}
		
		
		
		
	});
}
function passConfirm()
{
	
	var rList = [];
	var m = $.rand([0,1,2,3])
	
	var container = document.getElementById("passCheckDiv");

	container.innerHTML = "";

	for(var r=0; r < 4; r++)
	{
		var optionDiv = document.createElement("canvas");
		optionDiv.className = "optionDiv";
		
		if(r == m)
		{
			var ctx = optionDiv.getContext("2d");
			ctx.canvas.width  = "235";
			ctx.canvas.height = "30";
			ctx.font="18px Calibri";
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			var x = 120;
			var y = 14;
			ctx.fillStyle = '#272E36;';
			ctx.fillText(infoReg.pass,x,y);
			optionDiv.onclick = function()
				{
					infoReg.isreging = "1";
					
					sendAjax("users","register",infoReg,function(response)
					{

						console.log(response.message);
						
						if(response.message == "exist")
						{

							alertBox(language["alert"], language["sys002"], 300);
							hide_pop_form();
							return;
						}
						if(response.message == "existP")
						{

							alertBox(language["alert"], language["sys002P"], 300);
							hide_pop_form();
							return;
						}
						
						if(response.status)
						{
							
							uFormClear();
							hide_pop_form();
							alertBox(language["congratz"],language["sys001"],300);
							
							document.getElementById("userLoginBox").value = infoReg.mail;
							document.getElementById("userPassBox").value = infoReg.pass;
							
						}
						else
						{

							hide_pop_form();
							alertBox(language["alert"],language["sys002"],300);
							reloaded = 0;
							// openRegForm();
						}
					});
				}
		}
		else
		{
			var ctx = optionDiv.getContext("2d");
			ctx.canvas.width  = "235";
			ctx.canvas.height = "30";
			ctx.font="18px Calibri";
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			var x = 120;
			var y = 14;
			ctx.fillStyle = '#272E36;';
			ctx.fillText(infoReg.pass.shuffle(),x,y);
			optionDiv.onclick = function()
				{
					hide_pop_form();
					alertBox(language["alert"],language["sys003"],300);
					reloaded = 0;
					formBox("regBox",language["regTitle"],600);
					document.getElementById("regUpass").value = "";
					
				}
		}
		container.appendChild(optionDiv);
	}
	
	var regCancel = document.createElement("div");
	regCancel.className = "singleButton";
	regCancel.innerHTML = language["cancel"];
	regCancel.onclick = hide_pop_form;
	
	container.appendChild(regCancel);
	
	formBox("passCheckDiv",language["sys004"],272);
}
// REG AND PROFILE END

// LOAD TABULAR SECTIONS START
function loadSection(section)
{
	if(section == "profile")
	{
		console.log("load home");
	}
}
// LOAD TABULAR SECTIONS END

// IMAGE MANAGE
function prepareImgCropper()
{
	var options =
	{
		imageBox: '.imageBox',
		thumbBox: '.thumbBox',
		spinner: '.spinner',
		imgSrc: 'irsc/imageSample.png'
	}
	var cropper = new cropbox(options);
	document.querySelector('#picSelector').addEventListener('change', function()
	{
		var reader = new FileReader();
		reader.onload = function(e) 
		{
			options.imgSrc = e.target.result;
			cropper = new cropbox(options);
		}
		reader.readAsDataURL(this.files[0]);
		var img = cropper.getDataURL();
	})
	document.querySelector('#btnCrop').addEventListener('click', function(){
		var img = cropper.getDataURL();
		document.querySelector('.cropped').innerHTML += '<img src="'+img+'">';
		document.getElementById("imageSample").src = img;
		
		actualCroppedPic = img;
		savepPic()
		hide_pop_form();
		var pickSelector = document.getElementById('picSelector').value = "";
		
	})
	document.querySelector('#btnZoomIn').addEventListener('click', function(){
		cropper.zoomIn();
	})
	document.querySelector('#btnZoomOut').addEventListener('click', function(){
		cropper.zoomOut();
	})
}
function openPicSelector()
{
	document.getElementById("picSelector").click();
}
function handleFileSelect(evt) 
{
	var pickSelector = document.getElementById('picSelector');
	var format = pickSelector.value.split(".")[1];
	
	var blankImg = document.createElement("img");
	blankImg.src = "irsc/imageSample.png";
	blankImg.id = "imageSample";
	blankImg.className = "imageSample";
	
	if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
	{
		alertBox(language["alert"], language["wrongFormatPic"], 300);
		pickSelector.value = "";
		document.getElementById('imageSample').src = "ppics/dummy.jpg";
		actualCroppedPic = "";
		return;
	}
	
	picIsNew = 1;
	
	formBox("cropBoxBox",language["cbTitle"],233);

}
function savepPic()
{
	var info = {};
	info.pic = actualCroppedPic;
	info.ucode = aud.UCODE;
	
	console.log(info)

	sendAjax("users","ppicsave",info,function(response)
	{
		var ans = response.message;
	});
}
function savepPicF()
{
	var info = {};
	info.pic = actualCroppedPic;
	info.ucode = aud.UCODE;

	sendAjax("users","ppicsaveF",info,function(response)
	{
		var ans = response.message;
		document.getElementById("frontSample").src = actualCroppedPic;
		document.getElementById("picSelector2").value = "";
		hide_pop_form();
	});
}
// IMAGE MANAGE END
// UPDATER PRODUCT CATALOG
function refreshProducts()
{
	var info = {};
	info.ucode = aud.UCODE;
	info.utype = aud.UTYPE;
	sendAjax("users","getPList",info,function(response)
	{
		var ans = response.message;
		
		actualPlist = ans.products;
		actualTrans = ans.trans;
		actualInsts = ans.insts;
		actualServs = ans.servs;
		actualSaloons = ans.saloons;
		actualAllpros = ans.allpros;
		actualProList = ans.mypros;
		actualDatesList = ans.datesList;
		
		if(ans.myclients.length != [])
		{
			myClients = getMyClients(ans.myclients);
		}
		else
		{
			myClients = [];
		}
		

		showFiltered(0);

		setActualCities(actualSaloons);
		
		var sectionP = document.getElementById("sPromo");
		var condsLink = document.getElementById("pCons");
		
		if(ans.promo.length > 0)
		{
			var promoData = ans.promo[0];
			var condsBox = document.getElementById("conditionsTextBoxP");
			condsBox.innerHTML = promoData.CONDS
			
			actualPromoCode = promoData.PCODE;
			actualPsdate = promoData.SDATE;
			actualPedate = promoData.EDATE;
			
			setMenuItems("1");
			
			if(ans.promoScore[0]["SCORE"] != null)
			{
				document.getElementById("promoScore").innerHTML = addCommas(ans.promoScore[0]["SCORE"]);
			}
			else
			{
				document.getElementById("promoScore").innerHTML = "0";
			}
			
			
			var promoMenu = menuCreator("sPromo", "menPromo",promoData.NAME);
			mainMenu.insertBefore(promoMenu, mainMenu.children[1]);
			document.getElementById("sPromo").setAttribute( 'style', 'display: block !important' );
			
			var banner = document.getElementById("promoBanner");
			banner.src = "../bcadmin/img/prpics/"+promoData.PCODE+".jpg"+tail;
			
			var pinfo = document.getElementById("pInfo");
			pinfo.innerHTML = promoData.DETAIL;
		}
		else
		{
			console.log("no hay proms")
			document.getElementById("sPromo").setAttribute( 'style', 'display: none !important' );

		}
		
		(function($) {
  "use strict"; // Start of use strict
			
	// Smooth scrolling using jQuery easing
	  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
				if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				  var target = $(this.hash);
				  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				  if (target.length) 
				  {
					var w = window.innerWidth;
					if(w > 980)
					{
						var topO = target.offset().top-50;
					}
					else
					{
						var topO = target.offset().top-120;
					}
					
					$('html, body').animate({scrollTop: (topO)}, 900,"easeInSine");
					return false;
				  }
				}
			  });

			  // Closes responsive menu when a scroll trigger link is clicked
			  $('.js-scroll-trigger').click(function() {
				$('.navbar-collapse').collapse('hide');
			  });

			  // Activate scrollspy to add active class to navbar items on scroll
			  $('body').scrollspy({
				target: '#sideNav'
			  });

			})(jQuery); // End of use strict
		
		
		setCoins();
		
		
		
		tableCreator("transList", actualTrans);
		tableCreator("mycbcList", myClients);
		
	});
}
function setActualCities(saloons)
{
	var list = saloons;
	actualCits = [];

	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		var city = item.CITY;
		var depto = item.DPTO;
		var detail = city+"-("+depto+")";
		
		var ncity = {};
		ncity.VALUE = city;
		ncity.DETAIL = detail;
		
		var ppl = getSaloonPros(item.UCODE);

		var add = JSON.stringify(ncity);
		
		if(!actualCits.in_array(add))
		{
			if(ppl.length > 0)
			{
				actualCits.push(add);
			}
		}
		
	}
	
}
function getSaloonPros(code)
{
	
	var mypros = [];
	
	for(var i=0; i<actualAllpros.length; i++)
	{
		var item = actualAllpros[i];
		if(item.UCODE == code)
		{
			
			if(JSON.parse(item.SKILLS).length > 0)
			{
				mypros.push(item);
			}
		}
		
	}
	
	return mypros;

}
function refreshServsList()
{
	
	var containerSk = document.getElementById("skillContainer");
	containerSk.innerHTML = "";
	
	
	var list = actualServs;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var skillBox = document.createElement("div");
		skillBox.className = "skillBoxNormal";
		skillBox.innerHTML = item.DETAIL;
		skillBox.code = item.SRCODE;
		skillBox.onclick = function()
		{
			console.log(this.className);
			if(this.className == "skillBoxNormal")
			{
				this.className = "skillBoxPicked";
				console.log(this.code);
			}
			else
			{
				this.className = "skillBoxNormal";
				console.log(this.code);
			}
		}
		
		containerSk.appendChild(skillBox);
		
	}
	
	// pickSkills();
}
function showRanking()
{
	
	var info = {};
	info.pcode = actualPromoCode;
	
	console.log(info)

	sendAjax("users","getRanking",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		formBox("rankingBoxP","Tabla de puntajes",600);
		
		tableCreator("rankList", ans);
	
	});
}
function setCoins()
{
	var list = actualTrans;
	
	var pos = 0;
	var neg = 0;
	actualPcodes = [];
	
	var posB = 0;
	var negB = 0;
	
	
	
	for(var i=0; i<list.length; i++)
	{
		var type = list[i].TYPE;
		var value = parseInt(list[i].VALUE);
		
		actualPcodes.push(list[i].PCODE);
		
		if(type == "0" || type == "3")
		{
			neg += value;
		}
		if(type == "1")
		{
			pos += value;
		}
		if(type == "5")
		{
			posB += value;
		}
		if(type == "6")
		{
			negB += value;
		}
		
	}
	
	var actualCoins = pos - neg;
	
	actualCoinsB = posB - negB;
	
	
	if(aud.UTYPE == "E")
	{
		console.log("test 4")
		if(aud.PREMIUM == "1")
		{
			var prendate = aud.PRENDATE.split(" ")[0];
			// document.getElementById("actualCoins").innerHTML = "<span class='topSpan darkBg'>"+language["premiumTo"]+prendate+"</span>"+" <span onclick='transferCoinsBox()' class='topSpan'><b>Regalar Brazil Coins</b></span>";
			document.getElementById("actualCoins").innerHTML = "<span class='topSpan darkBg'>"+language["premiumTo"]+prendate+"</span><span onclick='showMyScores()' class='topSpan'>"+language["showMyScoreTit"]+"</span>";
		}
		else
		{
			document.getElementById("actualCoins").innerHTML = "<span onclick='openPayOptions()' class='topSpan'>"+language["userCoinsLabel"]+"</span>"+" <span onclick='transferCoinsBox()' class='topSpan'><b>Dar Brazil Coins</b></span>";
		}
		
		// document.getElementById("addDateButton").style.display = "none";
		
	}
	else
	{
		document.getElementById("actualCoins").innerHTML = "<span onclick='showMyScores()' class='topSpan'>"+language["showMyScoreTit"]+"</span>";
		// document.getElementById("addDateButton").style.display = "block";
		
	}
	
	
	
	document.getElementById("welcometit").innerHTML = "<b>Hola, "+aud.NAME+"</b>"+"<span class='editProfileLink' onclick='openProForm()'> Editar perfil</span>";
	
	
	
	refreshPlist();
	
	if(aud.HPF == "1")
	{
		document.getElementById("frontSample").src = "mysite/img/frontPics/"+aud.UCODE+".jpg";
	}
	else
	{
		document.getElementById("frontSample").src = "mysite/img/frontPics/default.jpg";
	}
	document.getElementById("aboutField").innerHTML = aud.ABOUT;
	
}
function saveAbout ()
{
	var info = {};
	info.about = document.getElementById("aboutField").value;
	info.ucode = aud.UCODE;
	console.log(info)
	
	sendAjax("users","saveAbout",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
	});
}
function openPayOptions()
{
	hide_pop();
	hide_pop_form();
	formBox("buyOptions",language["buyOptionsTit"],300);
}
function showMyScores()
{
	
	var info = {};
	info.ucode = aud.UCODE;
	
	sendAjax("users","getUserScores",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		var list = getTotalsByStore(ans);
		
		tableCreator("myScoreList", list);
		formBox("myScores",language["showMyScore"],400);
			
	});

}
function getTotalsByStore(lists)
{
	
	console.log(lists)
	
	var incomes = lists.ins;
	var outcomes = lists.outs;
	
	
	
	
	console.log(ransom)
	var list = incomes;
	var list2 = outcomes;
	var totalized = [];
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		var scode = item.SCODE;
		var totaled = item.income;
		for(var j=0; j<list2.length; j++)
		{
			var item2 = list2[j];
			var scode2 = item2.SCODE;
			
			if(scode == scode2)
			{
				var totaled = parseInt(item.income) - parseInt(item2.outcome);
				break;
			}
			else
			{
				var totaled = item.income;
			}
		}
		
		var line = {"name": item.SNAME, "total": totaled};
		
		totalized.push(line);
	}
	
	if(lists.ransom.length > 0)
	{
		var ransom = lists.ransom[0].ransom;
		var line = {"name": "Comisiones de tienda", "total": ransom};
		totalized.push(line);
	}
	else{var ransom = 0;}
	
	return totalized;
	
}
function getMyClients(lists)
{
	var incomes = lists.ins;
	var outcomes = lists.outs;
	var list = incomes;
	var list2 = outcomes;
	var totalized = [];
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		var scode = item.UCODE;
		for(var j=0; j<list2.length; j++)
		{
			var item2 = list2[j];
			var scode2 = item2.UCODE;
			
			if(scode == scode2)
			{
				var totaled = parseInt(item.income) - parseInt(item2.outcome);
				break;
			}
			else
			{
				var totaled = parseInt(item.income);
			}
		}

		totalized.push({"name": item.NAME, "total": totaled, "email": item.EMAIL, "phone": item.PHONE});
	}
	
	return totalized;
	
}
function openbuyCplanBox()
{
	formBox("buyCplanBox",language["buyCplanTit"],300);
}
function refreshPlist()
{

	var plistBox = document.getElementById("plistBox");
	plistBox.innerHTML = "";
	var slistBox = document.getElementById("slistBox");
	slistBox.innerHTML = "";
	var clistBox = document.getElementById("clistBox");
	clistBox.innerHTML = "";
	
	var barInserted = 0;
	
	

	for(var i=0; i<actualPlist.length; i++)
	{
		var data = actualPlist[i];
		if(data.HP == "0")
		{
			continue;
		}

		
		if(actualPcodes.in_array(data.CODE))
		{
			 if(data.TYPE == "c")
			 {
				data.PRICE = "gratis";
			 }
		}
		
		// MAIN BOX
		var mainPbox = document.createElement("div");
		mainPbox.className = "col-xl-3 col-lg-3 col-6";
		mainPbox.data = data;
		
		var text = data.PNAME;

		// CONTENT BOX
		var subPbox = document.createElement("div");
		subPbox.className = "card card-product";
		
		var imgWrap = document.createElement("div");
		imgWrap.data = data;
		imgWrap.className = "img-wrapper";
		imgWrap.onclick = function()
		{
			showDetail(this.data);
		}
		
		// IMG
		var img = document.createElement("img");
		img.className = "card-img-top";
		img.src = "../bcadmin/img/products/"+data.CODE+".jpg"+tail;
				
		imgWrap.appendChild(img);
		
		
		var promoBadge = document.createElement("span");
		promoBadge.className = "badge badge-danger custom-badge arrowed-right label label-top-left";
		promoBadge.innerHTML = "Disponible";
		
		imgWrap.appendChild(promoBadge);
		
		var bButton = document.createElement("button");
		bButton.data = data;
		bButton.className = "buyButton";
		if((data.TYPE == "c" && data.PRICE.toUpperCase() == "GRATIS") || aud.PREMIUM == "1")
		{
			bButton.innerHTML = "Ver";
		}
		else
		{
			bButton.innerHTML = "Ver";
		}
		
		bButton.onclick = function()
		{
			
			if((this.data.TYPE == "c" && this.data.PRICE.toUpperCase() == "GRATIS") || aud.PREMIUM == "1")
			{
				console.log("ver video")
				videoStart(this.data)
			}
			else
			{
				var param = [this.data];
				
				sendPayCO(this.data);
				return;
				
				if(parseInt(actualCoinsB) > 0)
				{
					confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Deseas canjear <img src='../bcadmin/irsc/coin.png' class='coinQty'/>"+addCommas(this.data.PRICE)+" por<br> "+this.data.PNAME+"<br><br>Tienes <img src='../bcadmin/irsc/coinB.png' class='coinQty'/>"+addCommas(actualCoinsB)+" monedas de cortesía, ¡Activa la casilla si deseas usarlas para esta compra! <input type='checkbox' id='useBcoinsBox' onchange='setUseB(this.checked)'/>", buyThis, 300, param);
					
					useBState = false;
					actualBcoinsState = 1;
				}
				else
				{
					confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Deseas canjear <img src='../bcadmin/irsc/coin.png' class='coinQty'/>"+addCommas(this.data.PRICE)+" por<br> "+this.data.PNAME, buyThis, 300, param);
					
					useBState = false;
					actualBcoinsState = 0;
				}
				
			}
		}
		
		// INFO WRAP
		var infoWrap = document.createElement("div");
		infoWrap.className = "card-body text-center";
		infoWrap.data = data;
		
		// INFO TITLE
		var infoTitle = document.createElement("p");
		infoTitle.className = "card-text fixedH";
		infoTitle.innerHTML = "<b>"+data.PNAME+"</b>"+" <br>";
		infoWrap.appendChild(infoTitle);

		var pricesLine = document.createElement("ul");
		pricesLine.className = "badge badge-primary custom-badge label label-top-right";
		infoWrap.onclick = function()
		{
			showDetail(this.data);
		}

		if(data.TYPE == "p")
		{
			pricesLine.innerHTML = "$"+addCommas(data.PRICE);
		}
		else
		{
			if(data.PRICE.toUpperCase() != "GRATIS")
			{
				if(aud.PREMIUM != "1")
				{
					pricesLine.innerHTML = "$"+addCommas(data.PRICE);
				}
				else
				{
					pricesLine.innerHTML = "Gratis";
				}
				
			}
			else
			{
				pricesLine.innerHTML = "Gratis";
			}
			
		}
		
		infoWrap.appendChild(pricesLine);
		subPbox.appendChild(imgWrap);
		subPbox.appendChild(bButton)
		subPbox.appendChild(infoWrap);
		mainPbox.appendChild(subPbox);
		
		if(data.TYPE == "p")
		{
			plistBox.appendChild(mainPbox);
		}
		else
		{
			
			if(data.POS > 5 && barInserted == 0)
			{
				
				var linkDivider = document.createElement("span")
				linkDivider.className = "linkDivider";
				linkDivider.innerHTML = "Descarga archivos del curso Bioseguridad";
				linkDivider.onclick = function ()
				{
					document.getElementById("my_iframe").src = "docs/documentos.zip";
				}
				clistBox.appendChild(linkDivider);
				
				barInserted = 1;
			}
			
			if(data.POS > 20 && barInserted == 1)
			{
			
				var linkDivider = document.createElement("span")
				linkDivider.className = "linkDivider";
				linkDivider.innerHTML = "Descarga archivos Brazil Cocoa";
				linkDivider.onclick = function ()
				{
					console.log("docs/documentosBC.zip");
					document.getElementById("my_iframe").src = "docs/documentosBC.zip";
				}
				
				clistBox.appendChild(linkDivider);
				
				barInserted = 2;
			}

			clistBox.appendChild(mainPbox);
		}
		
		if(data.TYPE == "s")
		{
			slistBox.appendChild(mainPbox);
		}
	}
	
	var linkDivider = document.createElement("span")
	linkDivider.className = "linkDivider";
	linkDivider.innerHTML = "Descarga Bioseguridad Aplicada a la Cosmetologia";
	linkDivider.onclick = function ()
	{
		document.getElementById("my_iframe").src = "docs/Bioseguridad Aplicada a la Cosmetologia.zip";
	}
	clistBox.appendChild(linkDivider);
	
	var linkDivider = document.createElement("span")
	linkDivider.className = "linkDivider";
	linkDivider.innerHTML = "Descarga Maquillaje Social";
	linkDivider.onclick = function ()
	{
		console.log("docs/documentosAC.zip");
		document.getElementById("my_iframe").src = "docs/Maquillaje Social.zip";
	}
	clistBox.appendChild(linkDivider);
	
	var linkDivider = document.createElement("span")
	linkDivider.className = "linkDivider";
	linkDivider.innerHTML = "Descarga Limpieza Facial";
	linkDivider.onclick = function ()
	{
		document.getElementById("my_iframe").src = "docs/Limpieza Facial.zip";
	}
	clistBox.appendChild(linkDivider);
	
	var linkDivider = document.createElement("span")
	linkDivider.className = "linkDivider";
	linkDivider.innerHTML = "Descarga Visajismo y Asesoria de Imagen";
	linkDivider.onclick = function ()
	{
		document.getElementById("my_iframe").src = "docs/Visajismo y Asesoria de Imagen.zip";
	}
	clistBox.appendChild(linkDivider);
	
	
	
	
	
	barInserted = 2;
	
	return;


}
function setUseB(state)
{
	useBState = state;
}
function showDetail(data)
{
	console.log(data)
	
	var detail = "<br><img src='../bcadmin/img/products/"+data.CODE+".jpg' class='detailImg'/>"+"<br>"+data.DETAIL;
	
	alertBox(language["alert"], detail, 300);
}
function buyThis(param)
{
	
	var info = {};
	info.UCODE = aud.UCODE;
	info.CODE = param[0].CODE;
	info.PTYPE = param[0].TYPE;
	info.USEB = useBState;
	
	console.log(info)
	
	sendAjax("users","buyItem",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(ans == "nomony")
		{
			alertBox(language["alert"], language["nomony"], 300);
		}
		else
		{
			if(info.PTYPE == "p")
			{
				alertBox(language["alert"], language["sold"], 300);
			}
			else
			{
				alertBox(language["alert"], language["soldC"], 300);
			}
			
			refreshProducts();
		}
	});
	
	
}
function videoStart(data)
{
	var container = document.getElementById("homeVidiv");
	container.innerHTML = "";
	
	var videoBox = document.createElement("iframe");
	videoBox.className = "promoVid2";
	videoBox.setAttribute('allowFullScreen', '')
	
	var title = data.PNAME;
	var url = data.LINK;
	
	videoBox.src  = url;
	console.log(url);

	console.log(title)
	
	container.appendChild(videoBox);
	videoPromoRuning = 1;
	
	formBox("homeVidBox",title,574);
}
function hidePromoPop()
{
	var container = document.getElementById("homeVidiv");
	container.innerHTML = "";
	videoPromoRuning = 0;
	hide_pop_form();
	
}
function showPconds(item)
{
	console.log(item.conds)
	formBox("conditionsBoxP",language["conditionsBoxTitleP"],600);
}

// COIS FOR CODE
function openPriceDeliver()
{
	
	descBox = document.getElementById("prizeResumeBox");
	descBox.innerHTML = "";
	desCover = document.createElement("img");
	desCover.src = "irsc/desCover.png";
	descBox.appendChild(desCover);
	document.getElementById("codeCheckBox").value = "";
	actualDeliverCode = "";
	formBox("claimCodeDiv",language["claimPopTitle"],300);
	
}
function verifyCode()
{
	var code = document.getElementById("codeCheckBox").value;
	descBox.innerHTML = "";
	descSpan = document.createElement("span");
	descBox.appendChild(descSpan);
	
	if(code == "")
	{
		descSpan.innerHTML = language["noCodePrize"];
		return;
	}
	
	var info = {};
	info.code = code.toUpperCase();
	
	if (info.code.indexOf('-') < 0)
	{
		info.isser = "0";
		info.serie = "";
	}
	else
	{
		info.isser = "1";
		info.serie = info.code.split("-")[0];
		info.code = info.code.split("-")[1];
		
	}
	// return
	
	sendAjax("users","codeCheck",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(ans == "nf")
		{
			descSpan.innerHTML = language["invalidCodePrize"];
			adc = "";
			return
		}
		
		if(ans.STATUS == "2")
		{
			descSpan.innerHTML = language["alreadyDelivered"];
			adc = "";
		}
		else
		{
			
			if(ans.TYPE.split("-")[0] == "BC")
			{
				descSpan.innerHTML = language["deliverTitle1"]+ans.DETAIL+"<br>";
			}
			else
			{
				descSpan.innerHTML = language["deliverTitle1"]+ans.DETAIL+"<br>";
			}
			
			adc = ans.SERIE+"-"+ans.CODE;

			var modalArea = document.getElementById("modal");
			centererPop(modalArea);
		}

		
	});
	
}
function markPrize()
{
	var code = document.getElementById("codeCheckBox").value;

	if(code == "")
	{
		descBox.innerHTML = "";
		descSpan = document.createElement("span");
		descBox.appendChild(descSpan);
		descSpan.innerHTML = language["noDeliverCode"];
	}
	else
	{
		var info = {};
		info.code = code.toUpperCase();
		info.ucode = aud.UCODE;
		
		if(info.code.indexOf('-') < 0)
		{
			info.isser = "0";
			info.serie = "";
		}
		else
		{
			info.isser = "1";
			info.serie = info.code.split("-")[0];
			info.code = info.code.split("-")[1];
			
		}
		
		console.log(info)
		// return
		sendAjax("users","insertCode",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			if(ans == "GOOD")
			{
				descBox.innerHTML = "";
				descSpan = document.createElement("span");
				descBox.appendChild(descSpan);
				descSpan.innerHTML = language["addedPremium"];
				
				refreshProducts();
			}
			else if(ans == "NF")
			{
				descBox.innerHTML = "";
				descSpan = document.createElement("span");
				descBox.appendChild(descSpan);
				descSpan.innerHTML = language["notFound"];
			}
			else if(ans == "NBC")
			{
				descBox.innerHTML = "";
				descSpan = document.createElement("span");
				descBox.appendChild(descSpan);
				descSpan.innerHTML = language["addedCoins"];
				refreshProducts();
			}
			else if(ans == "USED")
			{
				descBox.innerHTML = "";
				descSpan = document.createElement("span");
				descBox.appendChild(descSpan);
				descSpan.innerHTML = language["usedCode"];
			}

		});
	}
}
function transferCoinsBox()
{
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";

	var input1 = document.createElement("input");
	input1.id = "input1";
	input1.type = "text";
	input1.className = "recMailBox";
	input1.placeholder = language["Bcoinsamonut"];
	
	var input2 = document.createElement("input");
	input2.id = "input2";
	input2.type = "text";
	input2.className = "recMailBox";
	input2.placeholder = language["Bcoinsdestiny"];
	
	var input3 = document.createElement("select");
	input3.id = "input3";
	input3.className = "dateCreateSelect";
	input3. onchange = function ()
	{
		var cost = this.value;
		if(cost != "")
		{
			document.getElementById("input1").value = this.value;
		}
		else
		{
			document.getElementById("input1").value = "";
		}
		
	}
		
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Calcular coins según servicio prestado";
	input3.appendChild(option);
	
	var list = actualServs;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		var option = document.createElement("option");
		option.value = parseInt(item.GIVE);
		option.innerHTML =  item.DETAIL+" -> "+(parseInt(item.GIVE));
		input3.appendChild(option);
	}
	
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButton";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
	{
		var info = {};
		info.amount = $("#input1").val();
		info.destiny = $("#input2").val();
		info.ucode = aud.UCODE;
		info.lang = lang;
		info.originMail = aud.EMAIL;
		info.sname = aud.NAME;
		
		// MUST PR ALERT
		// if(aud.PREMIUM != "1"){alertBox(language["alert"], language["mustBePr"], 300);return;}

		if(info.amount == "")
		{
			// hide_pop_form();
			alertBox(language["alert"], language["mustAmount"],300);
			return;
		}
		if(info.destiny == "")
		{
			// hide_pop_form();
			alertBox(language["alert"], language["mustDestiny"],300);
			return;
		}
		if(isNaN(info.amount))
		{
			// hide_pop_form();
			alertBox(language["alert"], language["mustNumber"],300);
			return;
		}
		if(info.destiny == aud.EMAIL)
		{
			// hide_pop_form();
			alertBox(language["alert"], language["sameMail"],300);
			return;
		}
		
		sendAjax("users","sendCoins",info,function(response)
		{
			var ans = response.message;
			
			
			
			
			if(ans == "EM")
			{
				hide_pop_form();
				alertBox(language["alert"],language["coinsSented"],300);
				refreshProducts();
				return
			}
			else if(ans == "NEM")
			{
				alertBox(language["alert"],language["sendBNEM"],300);
				return
			}
			else if(ans == "NOTE")
			{
				alertBox(language["alert"],language["sendBNOTE"],300);
				return
			}

		});
	}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButton";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input2);
	container.appendChild(input1);
	container.appendChild(input3);
	
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("pssRecBox",language["sendCoinsTitle"],300);
}
function pickSkills()
{
	
	var thiPro = document.getElementById("mbcSelect").value;
	
	for(var i=0; i<actualProList.length; i++)
	{
		var item = actualProList[i];
		if(item.PRCODE == thiPro)
		{
			var skills = item.SKILLS;
		}
	}
	
	var container = document.getElementById("skillsBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var skillContainer = document.createElement("div");
	skillContainer.id = "skillContainer";
	skillContainer.className = "skillContainer";
	
	
	var save = document.createElement("div");
	save.className = "dualButton";
	save.innerHTML = language["regSaveButton"];
	save.onclick = function()
	{
		
		var skills = getSelectedSkills();
		console.log(skills)
		
		var info = {};
		info.prcode = $("#mbcSelect").val();
		info.prskills = JSON.stringify(skills);
		info.ucode = aud.UCODE;
		
		// MUST PR ALERT
		// if(aud.PREMIUM != "1"){alertBox(language["alert"], language["mustBePr"], 300);return;}
		
		sendAjax("users","saveSkills",info,function(response)
		{
			var ans = response.message;
						
			alertBox(language["alert"],language["savedSkills"],300);
			hide_pop_form();
			refreshProducts();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButton";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(skillContainer);
	container.appendChild(save);
	container.appendChild(cancel);
	
	refreshServsList();
	
	markSkills(JSON.parse(skills));
	
	formBox("skillsBox",language["pickskillsTitle"],400);
}
function markSkills(skills)
{
	var containerSk = document.getElementById("skillContainer");
	var list = containerSk.children;
	
	for(var j=0; j<list.length; j++)
	{
		var item = list[j];
		item.className = "skillBoxNormal"
		var code = item.code;
		
		
		if(skills.in_array(code))
		{
			item.className = "skillBoxPicked"
			console.log(code)
		}
		else
		{
			item.className = "skillBoxNormal"
		}
		
	}
}
function getSelectedSkills()
{
	
	var containerSk = document.getElementById("skillContainer");
	var list = containerSk.children;
	
	var picked = [];
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		console.log(item.className)
		if(item.className == "skillBoxPicked")
		{
			picked.push(item.code);
		}
		
	}
	return picked;
	
	console.log(picked)
	
}
// CASH FOR COIN
function exchangeCoinsBox()
{
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";

	var input1 = document.createElement("input");
	input1.id = "input1";
	input1.type = "text";
	input1.className = "recMailBox";
	input1.placeholder = language["Bcoinsamonut"];
	
	var input2 = document.createElement("input");
	input2.id = "input2";
	input2.type = "text";
	input2.className = "recMailBox";
	input2.placeholder = language["confirmPass"];
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButton";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
		{
			var info = {};
			info.amount = $("#input1").val();
			info.pass = $("#input2").val();
			info.ucode = aud.UCODE;
			info.lang = lang;
			info.originMail = aud.EMAIL;
			
                        
			if(info.amount == "")
			{
				// hide_pop_form();
				alertBox(language["alert"], language["mustAmount"],300);
				return;
			}
			if(info.pass == "")
			{
				// hide_pop_form();
				alertBox(language["alert"], language["mustUserPass"],300);
				return;
			}
			if(isNaN(info.amount))
			{
				// hide_pop_form();
				alertBox(language["alert"], language["mustNumber"],300);
				return;
			}
						
			sendAjax("users","exchangeRequest",info,function(response)
			{
				var ans = response.message;
				console.log(ans)
				
				if(ans == "WP")
				{
					hide_pop_form();
					alertBox(language["alert"],language["wrongpsstns"],300);
					// refreshProducts();
					return
				}
				
				if(ans == "EM")
				{
					hide_pop_form();
					alertBox(language["alert"],language["exchangesent"],300);
					refreshProducts();
					return
				}
				else if(ans == "NOTE")
				{
					alertBox(language["alert"],language["sendBNOTE"],300);
					return
				}

			});
		}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButton";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input1);
	container.appendChild(input2);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("pssRecBox",language["exchangecoins"],300);
}

// TABLES
function tableCreator(tableId, list)
{
        var table = document.getElementById(tableId);
        tableClear(tableId);
        // setIFAutoFields(tableId, list);
        
        var qty = list.length+" Items";
        if(list.length == 1){var qty = list.length+" Item";}
		
        if(list.length == 0)
        {
                var nInYet = document.createElement("div");
                nInYet.innerHTML = language["noResults"];
                nInYet.className = "blankProducts";
                table.appendChild(nInYet);
                resSet();
                return;
        }
        // TRANS TABLE
        if(tableId == "transList")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Fecha', list[i].DATE);
				
				var type = "";
				
				if(list[i].TYPE == "0")
				{
					type = "Salida";
				}
				else if(list[i].TYPE == "1")
				{
					type = "Ingreso";
				}
				else if(list[i].TYPE == "2")
				{
					type = "Canje Brazil Coins";
				}
				else if(list[i].TYPE == "3")
				{
					type = "Código";
				}
				else if(list[i].TYPE == "4")
				{
					type = "Compra";
				}
				else if(list[i].TYPE == "8")
				{
					type = "Código promoción";
				}
				
				var b = cellCreator('Tipo', type);
				
				if(list[i].TYPE == "3")
				{
					var detail = "Obsequio Brazil Cocoa: "+list[i].DETAIL;
				}
				else
				{
					var detail = list[i].DETAIL;
				}
				
				var c = cellCreator('Detalle', detail);
				
				var code = list[i].PCODE;
				
				if(code.length > 8 && list[i].TYPE != "8")
				{
					code = "-";
				}
				else
				{
					code = code.split("-")[0];
				}
				
			
				if(list[i].PCODE[0]+list[i].PCODE[1] == "0-")
				{
					
					code = list[i].PCODE +" <img src='irsc/howclaim.png' class='howclaimIcon' onclick='showInstructions()'/>" 
				}
				
				var d = cellCreator('Código', code);
				
				var state = "";
				
				if(list[i].STATE == "0"){state = "<b style='color: green;'>Activo</b>";}
				if(list[i].STATE == "1"){state = "<b style='color: red;'>Usado</b>";}
				if(list[i].STATE == "4"){state = "<b style='color: red;'>Completa</b>";}
				
				
				if(list[i].DETAIL.includes("@"))
				{
					state = "<b style='color: red;'>Completa</b>";
				}
				
				if(list[i].STATE == "5" || list[i].STATE == "6"){state = "<b style='color: red;'>Usado</b>";}

				var e = cellCreator('Estado', state);
				
				
				if(list[i].TYPE == "4")
				{
					var f = cellCreator('Valor', addCommas(list[i].VALUE));
					var e = cellCreator('Estado', "Ingresado");
				}
				else if(list[i].TYPE == "3")
				{
					var f = cellCreator('Valor',"Código");
					var e = cellCreator('Estado', "Ingresado");
				}
				else
				{
					var f = cellCreator('Valor', "<img src='../bcadmin/irsc/coin.png' class='coinQty'/>"+addCommas(list[i].VALUE));
				}
				
				
				var icons = [];
				
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,f];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
					
			}
        }
		// RANKING TABLE
        if(tableId == "rankList")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var x = cellCreator('Nombre', i+1);
				var a = cellCreator('Nombre', list[i].NAME);
				var b = cellCreator('Puntos', list[i].SCORE);
				var c = cellCreator('Ciudad', list[i].CITY);

				var cells = [x,a,b,c];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
					
			}
        }
		// MY CLIENTS TABLE
        if(tableId == "mycbcList")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Nombre', list[i].name);
				var b = cellCreator('Email', list[i].email);
				var c = cellCreator('Teléfono', list[i].phone);
				var d = cellCreator('Brazil Coins', "<img src='../bcadmin/irsc/coin.png' class='coinQty'/>"+list[i].total);

				var cells = [a,b,c,d];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
					
			}
        }
		// MY SCORES TABLE
        if(tableId == "myScoreList")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Nombre', list[i].name);
				var b = cellCreator('Brazil Coins', "<img src='../bcadmin/irsc/coin.png' class='coinQty'/>"+list[i].total);

				var cells = [a,b];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
					
			}
        }
		// MY SALES TABLE
        if(tableId == "controListS")
        {
			var setotal = 0;

			for(var i=0; i<list.length; i++)
			{
				
				if(list[i].MTYPE != "1"){continue}
				
				
				var row = document.createElement("div");
				row.className = "rowT";
				
				
				var ba = cellCreator('Nombre', list[i].DATE);
				var a = cellCreator('Nombre', list[i].UNAME);
				var b = cellCreator('Celular', list[i].UPHONE);
				var c = cellCreator('Email', list[i].UMAIL);
				var d = cellCreator('Servicio', list[i].SENAME);
				var e = cellCreator('Estilista', list[i].PRONAME);
				var f = cellCreator("%", list[i].COMISION);
				var g = cellCreator('Valor', addCommas(list[i].SEVALUE));
				// var h = cellCreator('Productos', list[i].PDETAIL);
				var k = cellCreator('Observaciones', list[i].OBS);
				

				var cells = [ba,a,b,c,d,e,f,g,k];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
				
				setotal += parseInt(list[i].SEVALUE);
				prtotal += parseInt(pvalue);
					
			}
			
			var line = ["", "", "","", "", "Total servicios",addCommas(setotal), ""];
			var totalRow = enderRow(line);
			table.appendChild(totalRow);
        }
		// MY SALES TABLE PROD
        if(tableId == "controListP")
        {
			var prtotal = 0;
			
			console.log("entra")
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var ba = cellCreator('Nombre', list[i].DATE);

				var a = cellCreator('Productos', list[i].PDETAIL);
				var b = cellCreator('Cantidad', list[i].PQTY);
				var c = cellCreator('Valor unitario', list[i].PVALUE);
				
				if(list[i].PVALUE != "")
				{
					var pvalue = parseFloat(list[i].PVALUE)*parseFloat(list[i].PQTY);
					var d = cellCreator('Valor productos', addCommas(pvalue));
				}
				else
				{
					var pvalue = 0;
					var d = cellCreator('Valor productos', "0");
				}
				
				

				var cells = [ba,a,b,c,d];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
				

				prtotal += parseInt(pvalue);
					
			}
			
				var line = ["","","Total", addCommas(prtotal)];
				var totalRow = enderRow(line);
				table.appendChild(totalRow);
		}
		// MY SALES TABLE PROD
		if(tableId == "controListG")
		{
			var prtotal = 0;
			
			console.log("entra")
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var ba = cellCreator('Nombre', list[i].DATE);
				
				var a = cellCreator('Productos', list[i].SPENDETAIL);
				
				if(list[i].PVALUE != "")
				{
					var pvalue = parseFloat(list[i].SPENDVALUE);
					var b = cellCreator('Valor gasto', addCommas(pvalue));
				}
				else
				{
					var pvalue = 0;
					var b = cellCreator('Valor gasto', "0");
				}
				
				
				
				var cells = [ba,a,b];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
				

				prtotal += parseInt(pvalue);
					
			}
			
			var line = ["Total", addCommas(prtotal)];
			var totalRow = enderRow(line);
			table.appendChild(totalRow);
		}
		// MY FICHAS TABLE
        if(tableId == "controListSt")
        {
			var setotal = 0;

			for(var i=0; i<list.length; i++)
			{
				
				if(list[i].MTYPE != "4"){continue}
				
				
				var row = document.createElement("div");
				row.className = "rowT";
				
				
				var ba = cellCreator('Nombre', list[i].DATE);
				var a = cellCreator('Nombre', list[i].UNAME);
				var b = cellCreator('Celular', list[i].UPHONE);
				var c = cellCreator('Email', list[i].UMAIL);
				var d = cellCreator('Servicio', list[i].SENAME);
				var e = cellCreator('Descripción', list[i].CDESC);
				var k = cellCreator('Observaciones', list[i].OBS);
				

				var cells = [ba,a,b,c,d,e,k];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
					
			}
			
			// var line = ["", "", "","", "", "Total servicios",addCommas(setotal), ""];
			// var totalRow = enderRow(line);
			// table.appendChild(totalRow);
        }

}
function showInstructions()
{
		alertBox(language["alert"],"<pre class='preInst'><div class='instrubox'>"+actualInsts+"</div></pre>", 320);
	
}
function tableClear(tableId)
{
        var table = document.getElementById(tableId);
        var rows = table.children;
        
        while(rows.length > 1)
        {
                var elem = rows[1];
                elem.parentNode.removeChild(elem);
                var rows = table.children;
        }
}
function cellCreator(name, content)
{
        var cell = document.createElement("div");
        cell.className = "column";
        cell.setAttribute('data-label',name);
        cell.innerHTML = decodeURIComponent(content);
        
        return cell;
}

// ONLINE BUY
function sendPayCO(itemData)
{
	
	if(itemData != null)
	{
		var plan = "itemBuy";
	}
	if(itemData == "lifetime")
	{
		var plan = "LTP";
	}
	else
	{
		var plan = document.getElementById("coinPpicker").value;
		
	}
	
	// if (top.location!= self.location)
	// {
		// top.location = self.location
	// }
	
	
	// TESTMODE NEW
	// baction = "https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu";
	// bTest = "1";
	// bApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
	// baccountid = "512321";
	// bmerchantId = "508029";

	
	
	// TRUEMODE BRAZIL COCOA
	baction = "https://checkout.payulatam.com/ppp-web-gateway-payu";
	bTest = "0";
	bApiKey = "KsrwBTfe3sdHCXm4X5Fx5aA60Z"; 
	baccountid = "738771";
	bmerchantId = "733739";
	
	if(plan == "PR-1")
	{
		bdesc = language["bPlan1"];
		bamount = "19";
		breferenceCode = "BPR_1"+"-"+makeid();
	}
	else if(plan == "PR-2")
	{
		bdesc = language["bPlan2"];
		bamount = "29";
		breferenceCode = "BPR_2"+"-"+makeid();
	}
	else if(plan == "PR-3")
	{
		bdesc = language["bPlan3"];
		bamount = "39";
		breferenceCode = "BPR_3"+"-"+makeid();
	}
	else if(plan == "PR-6")
	{
		bdesc = language["bPlan4"];
		bamount = "69";
		breferenceCode = "BPR_6"+"-"+makeid();
	}
	else if(plan == "PR-12")
	{
		bdesc = language["bPlan5"];
		bamount = "99";
		breferenceCode = "BPR_12"+"-"+makeid();
	}
	else if(plan == "itemBuy")
	{
		bdesc = itemData.PNAME;
		bamount = itemData.PRICE;
		breferenceCode = "CRS_"+itemData.CODE+"-"+makeid();
	}
	else if(plan == "LTP")
	{
		bdesc = language["bPlan6"];
		bamount = "5.99";
		breferenceCode = "BPR_1000"+"-"+makeid();
	}

	// return;
	
	btax1 = 0;
	btax2 = 0;
	bcurrency  = "COP";
	bcurrency  = "USD";

	var sign = bApiKey+"~"+bmerchantId+"~"+breferenceCode+"~"+bamount+"~"+bcurrency;
	var info = {};
	info.sign = sign;
	
	sendAjax("users","toMD5",info,function(response)
	{
		var  sign = response.message;
		
	
		document.getElementById("payBox-CO").action = baction;
		document.getElementById("pbCO-meid").value = bmerchantId;
		document.getElementById("pbCO-acid").value = baccountid;
		document.getElementById("pbCO-desc").value = bdesc;
		document.getElementById("pbCO-bref").value = breferenceCode;
		document.getElementById("pbCO-bamo").value = bamount;
		document.getElementById("pbCO-btax1").value = btax1;
		document.getElementById("pbCO-btax2").value = btax2;
		document.getElementById("pbCO-currency").value = bcurrency;
		document.getElementById("pbCO-bsign").value = sign;
		
		if(directBuy == 1)
		{
			// LIVE NAME
			document.getElementById("pbCO-bname").value = decodeURIComponent(dbname);
		// LIVE EMAIL
			document.getElementById("pbCO-bemail").value = dbemail;
		}
		else
		{
			// LIVE NAME
			document.getElementById("pbCO-bname").value = decodeURIComponent(aud.NAME);
			// LIVE EMAIL
			document.getElementById("pbCO-bemail").value = aud.EMAIL;
		}
	
		
		// TEST NAME
		// document.getElementById("pbCO-bname").value = "APPROVED";
		// TEST EMAIL
		// document.getElementById("pbCO-bemail").value = "test@test.com";
		
		document.getElementById("pbCO-brespurl").value = "https://www.brazilcocoa.com/app";
		document.getElementById("pbCO-bcomfurl").value = "https://www.brazilcocoa.com/buyConfirm.php";
		
		// console.log(document.getElementById("payBox-CO"));
		// return;
		
		document.getElementById("payBox-CO").submit();
	});
	
}
function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 8; i++ )
	{
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
    return text;
}

// PROMO SECTION
function insertPromoCode()
{
	
	var code = document.getElementById("pcodeInput").value;
	var today = getNow(0,"justDay");
	
	if(today < actualPsdate)
	{
		alertBox(language["alert"], language["insertedPsdateW"], 300);
		return;
	}
	if(today > actualPedate)
	{
		alertBox(language["alert"], language["insertedPedateW"], 300);
		return;
	}
	
	if(code == "")
	{
		alertBox(language["alert"], language["mustPcode"], 300);
		return;
	}
	else
	{
		
		var info = {};
		
		info.ucode = aud.UCODE;
		info.pcode = actualPromoCode;
		info.code = code;
		
		
		sendAjax("users","insertPcode",info,function(response)
		{
			var  ans = response.message;
			
			if(ans == "marked")
			{
				alertBox(language["alert"], language["insertedPcode"], 300);
				document.getElementById("pcodeInput").value = "";
				refreshProducts();
				
			}
			else if(ans == "used")
			{
				alertBox(language["alert"], language["insertedPcodeUsed"], 300);
			}
			else if(ans == "nf")
			{
				alertBox(language["alert"], language["insertedPcodeNF"], 300);
			}
			
		});
		
		
		
	}
	
	
}

// AGENDA
function addPro()
{
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";

	var recMailBox = document.createElement("input");
	recMailBox.id = "recMailBox";
	recMailBox.type = "text";
	recMailBox.className = "recMailBox";
	recMailBox.placeholder = "Nombre del profesional";
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButton";
	recMailSend.innerHTML = "Guardar";
	recMailSend.onclick = function()
	{
		var info = {};
		info.name = $("#recMailBox").val();
		info.lang = lang;
		info.ucode = aud.UCODE;
		
		// MUST PR ALERT
		// if(aud.PREMIUM != "1"){alertBox(language["alert"], language["mustBePr"], 300);return;}
					
		if(info.name == "")
		{
			hide_pop_form();
			alertBox(language["alert"], language["mustProname"],300);
			return;
		}
		
		sendAjax("users","addPro",info,function(response)
		{
			var ans = response.message;
			
			if(ans == "exists")
			{
				alertBox(language["alert"], language["existsPro"],300);

			}
			else
			{
				alertBox(language["alert"], language["createdPro"],300);
				hide_pop_form();
				refreshProlist();
			}
		});
	}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButton";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(recMailBox);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("pssRecBox","Agregar profesional",300);
}
function delProCheck()
{
	var param = [];
	
	// MUST PR ALERT
		// if(aud.PREMIUM != "1"){alertBox(language["alert"], language["mustBePr"], 300);return;}
	
	confirmBox(language["confirm"], language["wishDelPro"], delPro, 300, param);
}
function delPro()
{
	var prcode = document.getElementById("mbcSelect").value;
	if(prcode == aud.UCODE)
	{
		alertBox(language["alert"], language["cantDelUpr"],300);
		return;
	}
	else
	{
		
		var info = {};
		info.ucode = aud.UCODE;
		info.prcode = prcode;

		sendAjax("users","delPro",info,function(response)
		{
			var ans = response.message;
			console.log(ans);
			
			alertBox(language["alert"], language["deletedPro"],300);
			hide_pop_form();
			refreshProlist();
			
		});
		
	}
}
function refreshProlist()
{

	var info = {};
	info.ucode = aud.UCODE;
	
	sendAjax("users","getProsList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		refreshPros(ans);
		
	});
	
}
function addDate()
{
	var container = document.getElementById("addDateBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";

	var input1 = document.createElement("select");
	input1.id = "input1";
	input1.className = "dateCreateSelect";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona ciudad";
	input1.appendChild(option);
	
	setDateCities(input1);
	
	input1.onchange = function()
	{
		
		clearfieldsDate("1");
		
		var city = this.value;
		var list = actualSaloons;
		var selectedSaloons = [];
		
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			if(item.CITY == city)
			{
				selectedSaloons.push(item)
			}
		}

		var list = selectedSaloons;
		var field = document.getElementById("input2Adate");
		field.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona salón o profesional";
		field.appendChild(option);

		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			
			var mypros = getSaloonPros(item.UCODE);
			var option = document.createElement("option");
			option.value = item.UCODE;
			option.innerHTML = item.NAME+" - "+item.ADDRESS;
			
			if(mypros.length > 0)
			{
				field.appendChild(option);
			}
		}
	}
	
	var input2 = document.createElement("select");
	input2.id = "input2Adate";
	input2.className = "dateCreateSelect";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona salón";
	input2.appendChild(option);
	
	input2.onchange = function()
	{
		clearfieldsDate("2");
		
		var saloon = this.value;
		var list = actualAllpros;
		var pickedPros = [];
		
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			if(item.UCODE == saloon)
			{
				if(JSON.parse(item.SKILLS).length > 0)
				{
					pickedPros.push(item);
				}
				
			}
			
		}
		
		var list = pickedPros;
		var field = document.getElementById("input3");
		field.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona profesional";
		field.appendChild(option);

		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			var option = document.createElement("option");
			option.value = item.PRCODE;
			option.innerHTML = item.PRNAME;
			field.appendChild(option);
		}
		getMyScoreForS(saloon);
	}
	
	var myscore = document.createElement("p");
	myscore.className = "myScore";
	myscore.id = "myScore";
	
	var input3 = document.createElement("select");
	input3.id = "input3";
	input3.className = "dateCreateSelect";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona profesional";
	input3.appendChild(option);
	
	input3.onchange = function()
	{
		clearfieldsDate("3");
		
		var pro = this.value;
		var list = actualAllpros;
		
		var skills = [];
		
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			if(item.PRCODE == pro)
			{
				var skills = JSON.parse(item.SKILLS);
			}
			
		}
	
		var list = skills;
		
		var field = document.getElementById("input4");
		field.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona procedimiento";
		field.appendChild(option);

		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			var option = document.createElement("option");
			option.value = item;
			option.innerHTML = getServDetail(item);
			
			field.appendChild(option);
		}
		

	}
	
	var input4 = document.createElement("select");
	input4.id = "input4";
	input4.className = "dateCreateSelect";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona procedimiento";
	input4.appendChild(option);
	
	input4.onchange = function()
	{
		getSkillCost(this.value);
		if(actualSaloonScore > 0)
		{
			
			var cost = getSkillCost(this.value);
			
			if(actualSaloonScore >= cost)
			{
				var exchangeLink = document.getElementById("exchangeLine");
				exchangeLink.style.display = "block";
				exchangeLink.innerHTML = "Canjear por "+cost+" puntos y crear cita";
				if(cost == 0)
				{
					exchangeLink.style.display = "none";
				}
			}
			else
			{
				var exchangeLink = document.getElementById("exchangeLine");
				exchangeLink.style.display = "none";

			}
			
		}
		actualSkillCost = getSkillCost(this.value);
	}
	
	var input5 = document.createElement("input");
	input5.id = "input5";
	input5.type = "text";
	input5.className = "dateCreateInput";
	input5.placeholder = "Selecciona fecha y hora";
	
	var exchange = document.createElement("p");
	exchange.className = "myScore exchange";
	exchange.id = "exchangeLine";
	exchange.onclick = function ()
	{
		var param = [];
		confirmBox(language["confirm"], language["checkExchange"], sendExChangeDate, 300, param);
		
	}
	
	var save = document.createElement("div");
	save.className = "dualButton";
	save.innerHTML = "Crear cita";
	save.onclick = function ()
	{
		saveDateSend(0);
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButton";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input1);
	container.appendChild(input2);
	container.appendChild(myscore);
	container.appendChild(input3);
	container.appendChild(input4);
	
	container.appendChild(input5);
	container.appendChild(exchange);
	container.appendChild(save);
	container.appendChild(cancel);
	
	jQuery('#input5').datetimepicker();
	
	
	// LOAD DATE DATA  
	if(saveDateState == "1")
	{
		input1.value = actualDateData.DCITY;
		input1.onchange();
		
		input1.disabled = true;
		
		input2.value = actualDateData.DSALOON;
		input2.onchange();
		
		input2.disabled = true;
		
		input3.value = actualDateData.DPROF;
		input3.onchange();
		
		input4.value = actualDateData.DTREAT;
		
		input5.value = actualDateData.DDATE;
		
	}
	if(saveDateState == "0")
	{
		formBox("addDateBox",language["createDate"],400);
	}
	else
	{
		formBox("addDateBox",language["saveDate"],400);
	}
	
	
}
function sendExChangeDate()
{
	saveDateSend(1);
}
function saveDateSend(payway)
{
	var info = {};
	info.city = $("#input1").val();
	info.saloon = $("#input2Adate").val();
	info.saloonName = $("#input2Adate option:selected").text();
	info.prof = $("#input3").val();
	info.profName = $("#input3 option:selected").text();
	info.treat = $("#input4").val();
	info.treatName = $("#input4 option:selected").text();
	info.saveDateState = saveDateState;
	info.editDateCode = editDateCode;
	info.payway = payway;
	// info.skillCost = actualSkillCost;
	info.skillCost = "";
	info.cuphone = aud.PHONE;

	if(saveDateState == "1")
	{
		info.date = $("#input5").val();
	}
	else
	{
		info.date = $("#input5").val()+":00";
	}
	
	info.ucode = aud.UCODE;
	info.uname = aud.NAME;
	
	var dateDate= new Date(info.date).getTime();
	var dateNow= new Date(getNow()).getTime();

	
	if(info.city == "")
	{
		alertBox(language["alert"], language["mustDateCity"],300);
		return;
	}
	if(info.saloon == "")
	{
		alertBox(language["alert"], language["mustDatePlace"],300);
		return;
	}
	if(info.prof == "")
	{
		alertBox(language["alert"], language["mustDatePro"],300);
		return;
	}
	if(info.treat == "")
	{
		alertBox(language["alert"], language["mustDateServ"],300);
		return;
	}
	if($("#input5").val() == "")
	{
		alertBox(language["alert"], language["mustDateDate"],300);
		return;
	}
	if(dateDate < dateNow)
	{
		alertBox(language["alert"], language["invaliDate"],300);
		return;
	}
	
	// TEST BLOCK
	// var strinfo = JSON.stringify({"city":"BALBOA","saloon":"xxx","saloonName":"Jesus Solano Polo Velez - cra 10 # 35-77","prof":"8e725bed8cb9e5f6b1079c1fa5eea939","profName":"Jesus Solano Polo Velez","treat":"10","treatName":"Corte de cabello dama - 45 Minutos aprox.","date":"2018/07/30 13:15","ucode":"73ea0567f655205cc0cd68c8c43efeaa","uname":"Harold Vélez Solano"})
	// var info = JSON.parse(strinfo);
	// TEST BLOCK

	// return

	sendAjax("users","createDate",info,function(response)
	{
		var ans = response.message;
		
		console.log(ans);
		// return;
		
		if(ans == "cool")
		{
			alertBox(language["alert"],language["dateCreated"],300);
			hide_pop_form();
			// refreshAgenda();
			refreshProducts();
		}
		else if(ans == "updated")
		{
			alertBox(language["alert"],language["dateUpdated"],300);
			hide_pop_form();
			// refreshAgenda();
			refreshProducts();
		}
		else if(ans == "NoProf")
		{
			alertBox(language["alert"],language["noprof"],300);
		}
		else if(ans == "NoServD")
		{
			alertBox(language["alert"],language["NoServD"],300);
		}
		else if(ans == "NoServH1")
		{
			alertBox(language["alert"],language["NoServH1"],300);
		}
		else if(ans == "NoServH2")
		{
			alertBox(language["alert"],language["NoServH2"],300);
		}
		else if(ans == "NoServH3")
		{
			alertBox(language["alert"],language["NoServH3"],300);
		}
		
		saveDateState = "0";
		
		

	});

}
function getMyScoreForS(saloon)
{
	var list = actualTrans;
	
	var plus = 0;
	var less = 0;
	actualSaloonScore = 0;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.SCODE == saloon && item.TYPE == "1")
		{
			plus += parseInt(item.VALUE);
		}
		if(item.SCODE == saloon && item.TYPE == "0")
		{
			less += parseInt(item.VALUE);
		}
	}
	
	actualSaloonScore = plus-less;
	
	if(actualSaloonScore > 0)
	{
		var scoreLabel = document.getElementById("myScore");
		scoreLabel.innerHTML = "Tienes "+actualSaloonScore+" Brazil Coins de este salón.";
		scoreLabel.style.display = "block";
	}
}
function getSkillCost(code)
{
	var list = actualServs;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.SRCODE == code)
		{
			return item.COST;
		}
	}
	return 0;

}
function convertTime24to12(time24)
{
	var tmpArr = time24.split(':'), time12;
	
	if(+tmpArr[0] == 12) 
	{
		time12 = tmpArr[0] + ':' + tmpArr[1] + ' pm';
	}
	else 
	{
		if(+tmpArr[0] == 00) 
		{
			time12 = '12:' + tmpArr[1] + ' am';
		}
		else 
		{
			if(+tmpArr[0] > 12) 
			{
				time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' pm';
			} 
			else 
			{
				time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' am';
			}
		}
	}
	
	return time12;
}
function refreshAgenda(filter)
{
	
	var info = {};
	info.ucode = aud.UCODE;
	info.utype = aud.UTYPE;
	info.filter = filter;
	
	sendAjax("users","getDatesList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		actualDatesList = ans;
		saveDateState = "0";
		showFiltered(document.getElementById("filterDatePicker").value);
	});
}
function showFiltered()
{
	
	var filter = document.getElementById("filterDatePicker").value;
	
	var list = actualDatesList;
	var picked = [];
	
	var iniDate = document.getElementById("iniDate").value.replace('/', '-');
	iniDate = iniDate.replace('/', '-')+":00";
	var enddate = document.getElementById("endDate").value.replace('/', '-');
	enddate = enddate.replace('/', '-')+":00";
	
	if(iniDate == ":00")
	{
		iniDate = "0000-00-00 00:00:00";
	}
	if(enddate == ":00")
	{
		enddate = "2100-00-00 00:00:00";
	}
	

	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		// console.log(item.DDATE)
		
		if(filter == 0)
		{
			if(item.DDATE > getNow() && item.DSTATE != "2" && item.DDATE >= iniDate && item.DDATE < enddate)
			{
				picked.push(item);
			}
			
		}
		if(filter == 1)
		{
			if(item.DDATE < getNow() && item.DDATE > iniDate && item.DDATE < enddate)
			{
				if(item.DSTATE == "0" || item.DSTATE == "1")
				{
					picked.push(item);
				}
			}
		}
		if(filter == 2)
		{
			if(item.DSTATE == "2" && item.DDATE >= iniDate && item.DDATE <= enddate)
			{
				picked.push(item);
			}
		}
	}
	
	refreshCalendar(picked)
	
}
function refreshCalendar(list)
{
	var cBox = document.getElementById("calendarContainer");
	cBox.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var rowBox = document.createElement("div");
		rowBox.className = "row ";
		
		var dateDataBox = document.createElement("div");
		dateDataBox.className = "col-xl-6 col-lg-6 col-12";
		
		var dateBox = document.createElement("div");
		dateBox.className = "event_item";
		
		var dot = document.createElement("div");
		dot.className = "ei_Dot dot_active";
		
		var timeampm = convertTime24to12(item.DDATE.split(" ")[1]);
		
		var titleTime = document.createElement("div");
		titleTime.className = "ei_Title";
		titleTime.innerHTML = formatDate(item.DDATE)+" "+timeampm;
		
		var dateDetail = document.createElement("div");
		dateDetail.className = "ei_Copy";
		dateDetail.innerHTML = item.DSALOONAME;

		var dateDetailP = document.createElement("div");
		dateDetailP.className = "ei_Copy";
		dateDetailP.innerHTML = "<b>Profesional:</b> "+item.DPROFNAME;
		
		var dateDetailP4 = document.createElement("div");
		dateDetailP4.className = "ei_Copy";
		dateDetailP4.innerHTML = "<b>Cliente:</b> "+item.CUNAME;
		
		var dateDetailP5 = document.createElement("div");
		dateDetailP5.className = "ei_Copy";
		dateDetailP5.innerHTML = "<b>Teléfono cliente:</b> "+item.CUPHONE;
		
		
		var dateDetailP2 = document.createElement("div");
		dateDetailP2.className = "ei_Copy";
		dateDetailP2.innerHTML = "<b>Tratamiento:</b> "+item.DTREATNAME.split(" - ")[0];
		
		var dateDetailP3 = document.createElement("div");
		dateDetailP3.className = "ei_Copy";
		
		if(item.PAYWAY == "0")
		{
			var pway = "<b style='color:red;'>Pago en el sitio.</b>"
		}
		else
		{
			var pway = "<b style='color:green;'>Canjeado por Brazil Coins.</b>"
		}
		
		dateDetailP3.innerHTML = "<b>Forma de pago:</b> "+pway;
		
		var dateActionsBox = document.createElement("div");
		dateActionsBox.className = "col-xl-6 col-lg-6 col-12";
		
		var dateBtnBox = document.createElement("div");
		dateBtnBox.className = "event_item row";
		
		var dateBtn1bx = document.createElement("div");
		dateBtn1bx.className = "col-4";
		var dateBtn1 = document.createElement("div");
		dateBtn1.className = "dateButton";
		dateBtn1.innerHTML = "Confirmar";
		dateBtn1.code = item.DCODE;
		
		
		var dateBtn2bx = document.createElement("div");
		dateBtn2bx.className = "col-4";
		var dateBtn2 = document.createElement("div");
		dateBtn2.className = "dateButton";
		dateBtn2.code = item.DCODE;
		
		dateBtn2.onclick = function ()
		{
			var param = [2, this.code];
	
			confirmBox(language["confirm"], language["wishDelDate"], setDateState, 300, param);
		}
		
		
		var dateBtn3bx = document.createElement("div");
		dateBtn3bx.className = "col-4";
		var dateBtn3 = document.createElement("div");
		dateBtn3.className = "dateButton";
		dateBtn3.innerHTML = "Editar";
		dateBtn3.item = item;
		dateBtn3bx.appendChild(dateBtn3);
		
		dateBtn3.onclick = function ()
		{
			console.log(this.item);
			saveDateState = "1";
			actualDateData = this.item;
			editDateCode = this.item.DCODE;
			addDate();
		}
		
		rowBox.appendChild(dateDataBox);
		rowBox.appendChild(dateActionsBox);
		dateDataBox.appendChild(dateBox);

		dateActionsBox.appendChild(dateBtnBox);
		
		if(item.DSTATE == "0")
		{
			dateBtn2bx.appendChild(dateBtn2);
			if(aud.UTYPE == "E")
			{
				dateBtn1bx.className = "col-4";
				dateBtn2bx.className = "col-4";
				dateBtn3bx.className = "col-4";
				dateBtnBox.appendChild(dateBtn3bx);
				dateBtnBox.appendChild(dateBtn1bx);
				dateBtn1bx.appendChild(dateBtn1);
				dateBtnBox.appendChild(dateBtn2bx);
				dateBtn2.innerHTML = "Cancelar";
				
				dateBtn1.onclick = function ()
				{
					var param = [1, this.code];
			
					confirmBox(language["confirm"], language["wishConfirmDate"], setDateState, 300, param);
				}
				
			}
			else
			{
				dateBtn1bx.className = "col-6";
				dateBtn2bx.className = "col-6";
				dateBtnBox.appendChild(dateBtn1bx);
				dateBtn2.innerHTML = "Cancelar este pendiente";
				var dateBtnConfirmed = document.createElement("div");
				dateBtnConfirmed.className = "dateButtonW";
				dateBtnConfirmed.innerHTML = "Esperando confirmación";
				dateBtn1bx.appendChild(dateBtnConfirmed);
				
				dateBtnBox.appendChild(dateBtn2bx);
			}
		}
		else if(item.DSTATE == "2")
		{
			dateBtn1bx.className = "col-6";
			dateBtn2bx.className = "col-6";
			dateBtnBox.appendChild(dateBtn1bx);
			dateBtn2.innerHTML = "Cancelar este pendiente";
			var dateBtnConfirmed = document.createElement("div");
			dateBtnConfirmed.className = "dateButtonW";
			dateBtnConfirmed.innerHTML = "Cita cancelada";
			dateBtn2bx.appendChild(dateBtnConfirmed);
			
			dateBtnBox.appendChild(dateBtn2bx);
			
			// dateBtnBox.appendChild(dateBtn2bx);
		}
		else if(item.DSTATE == "1")
		{
			dateBtn2bx.appendChild(dateBtn2);
			
			dateBtn1bx.className = "col-6";
			dateBtn2bx.className = "col-6";
			dateBtnBox.appendChild(dateBtn1bx);
			dateBtn2.innerHTML = "Cancelar este pendiente";
			var dateBtnConfirmed = document.createElement("div");
			dateBtnConfirmed.className = "dateButtonC";
			dateBtnConfirmed.innerHTML = "Confirmada por el profesional";
			dateBtn1bx.appendChild(dateBtnConfirmed);
			
			dateBtnBox.appendChild(dateBtn2bx);
		}
		
		
	
		cBox.appendChild(rowBox);
		dateBox.appendChild(dot);
		dateBox.appendChild(titleTime);
		if(aud.UTYPE == "C")
		{
			dateBox.appendChild(dateDetail);
		}
		dateBox.appendChild(dateDetailP);
		if(aud.UTYPE == "E")
		{
			dateBox.appendChild(dateDetailP4);
			dateBox.appendChild(dateDetailP5);
		}
		dateBox.appendChild(dateDetailP2);
		dateBox.appendChild(dateDetailP3);
	}
	
	
}
function setDateState(param)
{

	var info = {};
	info.state =  param[0];
	info.dcode = param[1];
	
	
	sendAjax("users","setDateState",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(info.state == 2)
		{
			alertBox(language["alert"], language["dateCanceled"],300);
		}
		else if(info.state == 1)
		{
			alertBox(language["alert"], language["dateConfirmed"],300);
		}
		 
		refreshAgenda();
		
	});
}
function clearfieldsDate(type)
{
	var scoreLabel = document.getElementById("myScore");
	
		
	if(type == "1")
	{
		scoreLabel.style.display = "none";
		var field2 = document.getElementById("input2Adate");
		field2.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona salón";
		field2.appendChild(option);
		
		var field3 = document.getElementById("input3");
		field3.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona profesional";
		field3.appendChild(option);
		
		var field4 = document.getElementById("input4");
		field4.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona procedimiento";
		field4.appendChild(option);
		
		
		
	}
	if(type == "2")
	{
		scoreLabel.style.display = "none";
		var field3 = document.getElementById("input3");
		field3.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona profesional";
		field3.appendChild(option);
		
		var field4 = document.getElementById("input4");
		field4.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona procedimiento";
		field4.appendChild(option);
	}
	if(type == "3")
	{
		
		var field4 = document.getElementById("input4");
		field4.innerHTML = "";
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona procedimiento";
		field4.appendChild(option);
	}

}
function getServDetail(code)
{
	var list = actualServs;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		if(item.SRCODE == code)
		{
			var detail = item.DETAIL+" - "+item.MINUTES+" Minutos aprox.";
		}
	}
	return detail;
}
function setDateCities(field)
{
	var list = actualCits.sort();
	
	for(var x=0; x<list.length; x++)
	{
		var item = JSON.parse(list[x]);
		var option = document.createElement("option");
		option.value = item.VALUE;
		option.innerHTML = item.DETAIL;

		field.appendChild(option);
	}
}
function formatDate(date)
{

	var parts = date.split("-");
	
	var months = ["", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
	
	var day = parts[2].split(" ")[0];
	var ndate = day+" de "+ months[parseInt(parts[1])]+" de "+parts[0];
	
	return ndate;
}
function saveServTime(value)
{
	
	var info = {};
	info.ucode = aud.UCODE;
	info.servtime = value;
	
	console.log(info)
	// return;
	
	sendAjax("users","saveServTime",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		alertBox(language["alert"], language["savedServTime"], 300);
		
	});
}


// -----------CROPPIE--------------
function openSliderPick()
{
	document.getElementById("picSelector2").click();
}
function prepareImgCropper2()
{
	document.querySelector('#picSelector2').addEventListener('change', 					function()
	{
		var reader2 = new FileReader();
		reader2.onload = function(e) 
		{
			var img = new Image;
			var pickSelector2 = document.getElementById('picSelector2');
			var format = pickSelector2.value.split(".")[1];
			
			if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
			{
				actualCroppedPic = "";
				alertBox(language["alert"], infoIcon+language["wrongFormatJpgFile"], 300);
				pickSelector2.value = "";

				return;
			}
			
			var size = parseInt(e.loaded/1000);
			
			img.onload = function() 
			{
				var pickSelector2 = document.getElementById('picSelector2');
				var format = pickSelector2.value.split(".")[1];

				var w = img.width;
				var h = img.height;
				
				if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
				{
					actualCroppedPic = "";
					alertBox(language["alert"], infoIcon+language["wrongFormatJpgFile"], 300);
					pickSelector2.value = "";

					return;
				}
				console.log(size);
				if(size <= 499)
				{
					croppieQ = 0.7;
				}
				if(size <= 500 && size >= 999)
				{
					croppieQ = 0.45;
				}
				if(size >= 1000)
				{
					croppieQ = 0.3;
				}
				
				croppieSet();
				
				var args = 
				{
					url: e.target.result,
				}
				theCroppie.bind(args);
				actualCroppedPic = e.target.result;
			};
			
			img.src = reader2.result;
		}
		reader2.readAsDataURL(this.files[0]);
	})
}
function croppieSet()
{
	if(theCroppie != null){theCroppie.destroy();}
	
	var container = document.getElementById("croppieBox");
	container.innerHTML = "";
	var cpie = document.createElement("div");
	cpie.id = "cpie";
	
	var bbox1 = document.createElement("div");
	bbox1.className = "dualButtonPop";
	bbox1.onclick = function(){getCroppieR();}
	bbox1.innerHTML = "Guardar";
	
	var bbox2 = document.createElement("div");
	bbox2.className = "dualButtonPop";
	bbox2.innerHTML = "Cancelar";
	bbox2.onclick = function(){hide_pop_form();}
	
	container.appendChild(cpie);
	container.appendChild(bbox2);
	container.appendChild(bbox1);

	var opts = 
	{
		viewport: { width: 780, height: 350 },
		boundary: { width: 780, height: 350 },
		showZoomer: true,
		enableOrientation: true
	}
	theCroppie = new Croppie(document.getElementById('cpie'), opts);
	
	formBox("croppieBox","Acomoda tu portada",800);
	
	var cpb = document.getElementById("croppieBox");
	var cover = document.createElement("div");
	cover.className = "coverer";
	cpb.appendChild(cover)
	
}
function getCroppieR()
{
	var args =
	{
		type: 'base64',
		size: 'original',
		format: 'jpeg',
		quality: croppieQ,
		enableZoom: false,
		circle: false
	}	
	
	theCroppie.result(args).then(function(resp) 
	{
		actualCroppedPic = resp;
		savepPicF();
	});

}
// -----------CROPPIE--------------







// GENERAL METHODS
function cellOptionsCreator(name, icons)
{
	var cell = document.createElement("div");
	cell.className = "column opts";
	cell.setAttribute('data-label',name);
	
	for(var i = 0; i<icons.length; i++)
	{
			cell.appendChild(icons[i]);
	}

	return cell;
}
function cellCheckCreator(name, icons)
{
	var cell = document.createElement("div");
	cell.className = "column checks";
	cell.setAttribute('data-label',name);
	
	for(var i = 0; i<icons.length; i++)
	{
			cell.appendChild(icons[i]);
	}

	return cell;
}
function celloneIconCreator(name, icons)
{
        var cell = document.createElement("div");
        cell.className = "column loneIconCell";
        cell.setAttribute('data-label',name);
        
        for(var i = 0; i<icons.length; i++)
        {
                cell.appendChild(icons[i]);
        }

        return cell;
}
function cellChildrenCreator(name, children)
{
	var cell = document.createElement("div");
	cell.className = "column noPads";
	cell.setAttribute('data-label',name);
	
	cell.appendChild(children);
	
	return cell;
}
function openInNewTab(url) 
{
  var win = window.open(url, '_blank');
  win.focus();
}
function checkStart()
{
        var d = window.location.href;
        
        var t = d.split("?");
		if(t.length > 1){var a = t[1];ifLoad('ifPassRec');pssReCode = a.split("key=")[1];pssReCode = pssReCode.split("&")[0];history.pushState({}, null, "http://incocrea.com/gold/");return true;}
			return false
        
}

// ------------------- DELETE --------------------


function fillChecker(fields, alerts)
{
        for(var i=0; i<fields.length; i++)
        {
                var field = document.getElementById(fields[i]);
                if(field.value == "")
                {
                        var warning = alerts[i];
                        
                        alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes "+warning,300); return false;
                }
        }
        return true;
}
function clearFields(items, release)
{
        if(release == "a-provider"){}
        if(release == "a-product"){actualProviders = []}

        for(var i = 0; i<items.length; i++)
        {
                document.getElementById(items[i]).value = "";
        }
        
}
function pssChange(mail, type)
{
	var container = document.getElementById("pssChangeBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var changePassBox = document.createElement("input");
	changePassBox.id = "changePassBox";
	changePassBox.type = "text";
	changePassBox.className = "recMailBox";
	changePassBox.placeholder = language["newPass"];
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButtonPop";
	recMailSend.innerHTML = language["change"];
	recMailSend.onclick = function()
		{
			var info = {};
			info.mail = mail;
			info.newPass = $("#changePassBox").val();
			info.lang = lang;
                        
                        info.type = type;
                        info.autor = aud.RESPNAME;
                        info.target = mail;
                        info.date = getNow();
                        
                        if(info.newPass.length < 6)
                        {
                                alertBox(language["alert"], language["sys007"],300);
                                return;
                        }
                        
                        if(info.newPass.match(/[\<\>!#\$%^&\,]/) ) 
                        {
                                alertBox(language["alert"], language["sys008"],300);
                                return;
                        }
			
			if(info.newPass == "")
			{
				hide_pop_form();
				alertBox(language["alert"], language["sys006"],300);
				return;
			}
			
			sendAjax("users","changePass",info,function(response)
			{
				if(response.status)
				{
					hide_pop_form();
					alertBox(language["alert"],language["sys013"],300);
				}
			});
		}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButtonPop";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(changePassBox);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("pssChangeBox",language["changePass"]+" para "+mail,300);
}
function getdDiff(startDate, endDate) 
{
        var startTime = new Date(startDate); 
        var endTime = new Date(endDate);
        var difference = endTime.getTime() - startTime.getTime();
        return Math.round(difference / 60000);
}
function loadFile(param)
{

        var fileSelector = document.getElementById("fileSelector");

        if(fileSelector.value == "")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un archivo para cargar",300);
		return;
	}
        // document.getElementById(param+'_upload_process').style.display = 'block';
	document.getElementById("upButton").click();
}
function loadFinish(result)
{
        if (result == 1)
        {
                alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Carga completada",300);
                
                var info = {};
                info.code = actualUploadCode;
                info.date = getNow();
                info.name = actualFileName;
                
                
                sendAjax("users","setFileLink",info,function(response)
                {
                        var ans = response.message;
                        providerGet();
                        hide_pop_form();
                });
        }
        else 
        {
                alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Error en la carga",300);
        }
        
        document.getElementById("fileSelector").value = "";

}
function downloadFile(url) 
{
        
		document.getElementById('downframe').setAttribute("href", url);
        document.getElementById('downframe').click();
};
function selectByText(fieldId, value)
{
        var field = document.getElementById(fieldId);
        var options = field.options;
        for (var n = 0; n<options.length; n++) 
        {
                if (field.options[n].text === value) 
                {
                        field.selectedIndex = n;
                         field.onchange();
                        break;
                }
        }
}
function selectNull()
{
        return;
}
function infoHarvest(items)
{
        var info = {};
        for(var i = 0; i<items.length; i++)
        {
                info[items[i]] = document.getElementById(items[i]).value;
        }
        return info;
}
function infoFiller(items, targets)
{
        var info = {};
        for(var i = 0; i<items.length; i++)
        {
               document.getElementById(targets[i]).value= items[i];
        }
        $('#workArea').scrollTop(0);
}







function generateRecepit()
{
        var info= {};
        
        info.picks = actualRecOrders.reverse();
        info.date = getNow();
        info.diedate = getNow(parseInt(document.getElementById("recLife").value));
        if(document.getElementById("retCheck").checked){info.retCheck = "1";}else{info.retCheck = "0";}

        if(info.life == "")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir el OTT de dias de vigencia de la factura", 300);
                return;
        }
        
        document.getElementById("sendPrefacButton").onclick = function(){console.log("locked")}

        sendAjax("users","generateRecepit",info,function(response)
        {
                
                var ans = response.message;

                
                if(ans == "fullres")
                {
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha agotado la resolución de facturación, debe ingresar una nueva para continuar facturando", 300);
                        return;
                }
                
                hide_pop_form();
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha generado exitosamente la factura", 300);
                // ifLoad('ifMasterF');
                ordeGet();
                document.getElementById("sendPrefacButton").onclick = function(){generateRecepit();}
                downloadFile(ans);
        });
        
        
}
function pssRec()
{
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";

	var recMailBox = document.createElement("input");
	recMailBox.id = "recMailBox";
	recMailBox.type = "text";
	recMailBox.className = "recMailBox";
	recMailBox.placeholder = language["recMailBox"];
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButton";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
		{
			var info = {};
			info.mail = $("#recMailBox").val();
			info.lang = lang;
                        
			if(info.mail == "")
			{
				hide_pop_form();
				alertBox(language["alert"], language["sys005"],300);
				return;
			}
			
			sendAjax("users","mailExist",info,function(response)
			{
                                
				if(response.status)
				{
					hide_pop_form();
					alertBox(language["alert"],language["sys009"],300);
				}
				else
				{
					hide_pop_form();
					alertBox(language["alert"],language["sys010"],300);
				}
			});
		}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButton";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(recMailBox);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("pssRecBox",language["passRecTitle"],300);
}
function setNewPass()
{

        
        var info = {};
        info.newPass = document.getElementById("newUpass").value;
        info.code = pssReCode;
        
        if(info.newPass.length < 6)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Tu contraseña debe tener al menos 6 caracteres",300);
                return;
        }
        
        if(info.newPass.match(/[\<\>!#\$%^&\,]/) ) 
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No debes usar ninguno de estos caracteres en tu contraseña <br> [\<\>!#\$%^&\*,]",300);
                return;
        }
        
        sendAjax("users","setRecoPass",info,function(response)
        {
               var ans = response.message;

               alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha establecido la nueva contraseña", 300);
               setTimeout(function(){window.location.replace('http://incocrea.com/gold/');}, 2500)
               

        });
        
}

// ------------------- DELETE --------------------


// -------------------SPECIAL BLOCK ---------------------------
// -------------------SPECIAL BLOCK ---------------------------
// -------------------SPECIAL BLOCK ---------------------------

function makeBoxpand(id, titleClosed, titleOpened, iniState)
{
	var main = document.getElementById(id);
	if(main.created == 1){return}

	var tBar = document.createElement("div");
	tBar.className = "tBar";
	var title = document.createElement("span");

	var expandIcon = document.createElement("img");
	expandIcon.className = "expandIcon";
	expandIcon.state = iniState;
	expandIcon.tO = titleOpened;
	expandIcon.tC = titleClosed;
        
	tBar.appendChild(title);
	tBar.appendChild(expandIcon);

	var tmpBox = document.createElement("div");
	tmpBox.className = "hidden";
	var contentBox = document.createElement("div");

	while (main.childNodes.length > 0) 
	{
		contentBox.appendChild(main.childNodes[0]);
	}

	main.appendChild(tBar);
	main.appendChild(contentBox);
	
	if(iniState == 0)
	{
		title.innerHTML = titleClosed;
		main.style.maxHeight = "30px";
                expandIcon.src = "irsc/expandIcon.png";
	}
	else
	{
		title.innerHTML = titleOpened;
                expandIcon.src = "irsc/expandIconG.png";
		main.style.maxHeight = "initial";
	}
	
	main.className = "mainbs";
	
	expandIcon.onclick = function()
	{
		var daddy = this.parentNode;
		var title = daddy.children[0];

		if(this.state == 0)
		{
			daddy.parentNode.style.maxHeight = "initial";
			this.state = 1;
			title.innerHTML = this.tO;
                        this.src = "irsc/expandIconG.png";
		}
		else
		{
			daddy.parentNode.style.maxHeight = "30px";
			this.state = 0;
                        this.src = "irsc/expandIcon.png";
			title.innerHTML = this.tC;
			
		}
	
		centerer(document.getElementById("wa"));
	}
	
	main.created = 1;
}
function getNow(extra, justDay)
{
	var currentdate = new Date(); 
	
	if(extra != null)
	{
		currentdate.setMonth(currentdate.getMonth() + (extra));
	}
	
	var year = currentdate.getFullYear();
	var month = (currentdate.getMonth()+1);
	var day = currentdate.getDate();
	var hour = currentdate.getHours();
	var minute = currentdate.getMinutes();
	var second = currentdate.getSeconds();
	
	if(parseFloat(month) < 10){month = "0"+month};
	if(parseFloat(day) < 10){day = "0"+day};
	if(parseFloat(hour) < 10){hour = "0"+hour};
	if(parseFloat(minute) < 10){minute = "0"+minute};
	if(parseFloat(second) < 10){second = "0"+second};
	
	var datetime =  year + "-" +  month + "-" + day + " "  + hour + ":"  + minute + ":"  + second;	
	if(justDay != null)
	{
		var datetime =  year + "-" +  month + "-" + day + " 00:00:00";	
	}
	
	return datetime;
}
function getNowCustom(start, extra)
{
	var currentdate = new Date(start+":00"); 
	
	if(extra != null)
	{
		currentdate.setMonth(currentdate.getMonth() + (extra));
	}
	
	var year = currentdate.getFullYear();
	var month = (currentdate.getMonth()+1);
	var day = currentdate.getDate();
	var hour = currentdate.getHours();
	var minute = currentdate.getMinutes();
	var second = currentdate.getSeconds();
	
	if(parseFloat(month) < 10){month = "0"+month};
	if(parseFloat(day) < 10){day = "0"+day};
	if(parseFloat(hour) < 10){hour = "0"+hour};
	if(parseFloat(minute) < 10){minute = "0"+minute};
	if(parseFloat(second) < 10){second = "0"+second};
	
	var datetime =  year + "-" +  month + "-" + day + " "  + hour + ":"  + minute + ":"  + second;	
	
	return datetime;
}
function getFirstday()
{
	
	var date = new Date(), y = date.getFullYear(), m = date.getMonth();
	var firstDay = new Date(y, m, 1);
	
	var currentdate = firstDay; 

	var year = currentdate.getFullYear();
	var month = (currentdate.getMonth()+1);
	var day = currentdate.getDate();
	var hour = currentdate.getHours();
	var minute = currentdate.getMinutes();
	var second = currentdate.getSeconds();
	
	if(parseFloat(month) < 10){month = "0"+month};
	if(parseFloat(day) < 10){day = "0"+day};
	if(parseFloat(hour) < 10){hour = "0"+hour};
	if(parseFloat(minute) < 10){minute = "0"+minute};
	if(parseFloat(second) < 10){second = "0"+second};
	
	var datetime =  year + "-" +  month + "-" + day + " "  + hour + ":"  + minute + ":"  + second;	
	
	return datetime;
}
function validateEmail(mail) 
{ 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(mail);
} 	
function addCommas(nStr)
{
	nStr = parseFloat(nStr);
	
	var d = 0;
        var actualCurrency = "USD";
	
	if(actualCurrency == "COP")
	{
		d = 0;
		var currency = "$";
	}
	if(actualCurrency == "CLP")
	{
		d = 0;
		var currency = "$";
	}
	if(actualCurrency == "PEN")
	{
		d = 2;
		var currency = "S/";
	}
	if(actualCurrency == "MXN")
	{
		d = 2;
		var currency = "$";
	}
	if(actualCurrency == "ARS")
	{
		d = 2;
		var currency = "$";
	}
	if(actualCurrency == "USD")
	{
		d = 2;
		var currency = "$";
	}
	if(actualCurrency == "EUR")
	{
		d = 2;
		var currency = "€";
	}
	if(actualCurrency == "GBP")
	{
		d = 2;
		var currency = "£";
	}
	
	d = 0;
	
	var currency = "";
	
	return currency + "" + nStr.toFixed(d).replace(/./g, function(c, i, a) 
	{
		return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	});

}
function sendAjax(obj, method, data, responseFunction, noLoader, asValue)
{
	 showLoader = 1;
	 
	 if(!noLoader)
	 {
		setTimeout(function()
		{
			if(showLoader == 1)
			{
				$("#loaderDiv").fadeIn();
			}	
		},1000);
	 }

	 // var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
	 var info = {};
	 info.class = obj;
	 info.method = method;
	 info.data = data;
		
	
	// UNCOMMENT FOR DEVELOPMENT
	$.ajax({
			type: 'POST',
			url: 'libs/php/mentry.php',
			contentType: 'application/json',
			data: JSON.stringify(info),
			cache: false,
			async: true,
			success: function(data){

				 try
				 {
					var tmpJson = $.parseJSON(data);
					responseFunction(tmpJson.data);
					$("#loaderDiv").fadeOut();
					showLoader = 0;
				 }
				 catch(e)
				 {
					 console.log(data);
					 $("#loaderDiv").fadeOut();
					 showLoader = 0;
				 }
			},
			error: function( jqXhr, textStatus, errorThrown )
			{ 
				$("#loaderDiv").fadeOut();
				console.log( errorThrown );
			}
		});
}
function doesConnectionExist()
{
	var xhr = new XMLHttpRequest();
	var file = "http://www.simplebryc.com/irsc/addCash.png";
	var randomNum = Math.round(Math.random() * 10000);

	xhr.open('HEAD', file + "?rand=" + randomNum, false);

	try 
	{
		xhr.send();

		if (xhr.status >= 200 && xhr.status < 304) 
		{
			return true;
		} 
		else {
		  return false;
	}
	}
	catch (e) 
	{
		return false;
	}
}
function encry (str) 
{  
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);  
}
function decry (str) 
{  
    return decodeURIComponent(str);  
}
function contactOpen()
{
	var nameBox = document.getElementById("contactName");
	var emailBox = document.getElementById("contactMail");
	
	if(aud == null)
	{
		nameBox.style.display = "block";
		emailBox.style.display = "block";
	}
	else
	{
		nameBox.style.display = "none";
		emailBox.style.display = "none";
	}
	
	formBox("contactDiv",language["contactLink"],400);
	
}
function sendContact()
{
	var nameBox = document.getElementById("contactName");
	var emailBox = document.getElementById("contactMail");
	
	if(aud == null)
	{
		var name = nameBox.value;
		var email = emailBox.value;
	}
	else
	{
		var name = decodeURIComponent(aud.RESPNAME);
		var email = aud.MAIL;
	}
	
	var message = document.getElementById("contactMessage").value;
	
	if(name == "" && aud == null)
	{
		alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir un nombre.",300);
		return;
	}
	if(email == "" && aud == null)
	{
		alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir un Email.",300);
		return;
	}
	if(message == "")
	{
		alertBox(language["alert"],language["mustMessage"],300);
		return;
	}
	
	var info = {};
	
	info.message = message;
	info.email = email;
	info.name = name;

	sendAjax("users","tagContact",info,function(response)
	{
		hide_pop_form();
		alertBox(language["alert"],language["contactSent"],300);

		document.getElementById("contactName").value = "";
		document.getElementById("contactMail").value = "";
		document.getElementById("contactMessage").value = "";
	});
	
}
Array.prototype.in_array=function()
{ 
        for(var j in this)
        { 
                if(this[j]==arguments[0])
                {
                        return true; 
                } 
        } 
        return false;     
} 
String.prototype.capitalize = function()
{
        return this.toLowerCase().replace( /\b\w/g, function (m) 
        {
            return m.toUpperCase();
        });
};
String.prototype.shuffle = function ()
{
	var a = this.split(""),
	n = a.length;

	for(var i = n - 1; i > 0; i--)
	{
		var j = Math.floor(Math.random() * (i + 1));
		var tmp = a[i];
		a[i] = a[j];
		a[j] = tmp;
	}
	return a.join("");
}
String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
} 
$.rand = function(arg) {if ($.isArray(arg)){return arg[$.rand(arg.length)];}else if (typeof arg === "number"){return Math.floor(Math.random() * arg);}else{return 4;}};
// -------------------SPECIAL BLOCK ---------------------------
// -------------------SPECIAL BLOCK ---------------------------
// -------------------SPECIAL BLOCK ---------------------------