// APP START START
$(document).ready( function()
{

	vm = {
		// REGFIELDS
		regUName : ko.observable(),
	}
	
	ko.applyBindings(vm);
	
	loadCheck();
	liveRefresh();
});
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	imported.src = 'js/live.js';
	if(loc.includes("192")){document.head.appendChild(imported);}
}
function loadCheck()
{

	langPickIni();

	document.querySelector('#userLoginBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	document.querySelector('#userPassBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	
	jQuery.datetimepicker.setLocale("es");
	jQuery('#sEndate').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });
	
	jQuery('#promoSdate').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });
	
	jQuery('#promoEdate').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });

	
	actualScode = "";
	eServiceCode = "";
	actualCroppedPic = "";
	actualPromocode = "";
	prepareImgCropper1();

	
	return

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
		setLang();
		checkLogin();

	});
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
	var mainMenu = document.getElementById("mainMenu");
	mainMenu.innerHTML = "";

	if(value == "1")
	{
		
		mainMenu.appendChild(menuCreator("sHall", "menHallAd"));
		mainMenu.appendChild(menuCreator("sShopAd", "menShopAd"));
		mainMenu.appendChild(menuCreator("sProd", "menProd"));
		// mainMenu.appendChild(menuCreator("sExchange", "menChange"));
		mainMenu.appendChild(menuCreator("sUsers", "menUsers"));
		mainMenu.appendChild(menuCreator("sPromo", "menPromos"));
		mainMenu.appendChild(menuCreator("sServs", "menServs"));
		mainMenu.appendChild(menuCreator("sAdminG", "menAdminG"));

		mainMenu.appendChild(menuCreator("sExit", "menExit"));
		
	}
	
	(function($) 
	{
	  "use strict"; // Start of use strict

	// Smooth scrolling using jQuery easing
	  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		  if (target.length) {
			$('html, body').animate({
			  scrollTop: (target.offset().top)
			}, 600, "easeInOutExpo");
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

	
	starter();
	
	
	
}
function starter()
{

	var info = {};
	info.index = "";

	sendAjax("users","starter",info,function(response)
	{
		var ans = response.message;

		tableCreator("productsList", ans.products);
		tableCreator("sitesList", ans.sites);
		// tableCreator("exList", ans.tns);
		tableCreator("usersList", ans.users);
		tableCreator("promosList", ans.promos);
		tableCreator("servicesList", ans.services);
		cListRefresh(0);
		
		actualProductsList = ans.products;
		
		actualPromoList = ans.promos;
		codeTypeFiller();

		document.getElementById("pInstrucs").value = ans.inst;
		
	});
	
}
function codeTypeFiller()
{
	
	var list = actualPromoList;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.ACTIVE == "1")
		{
			var activeData = {"PCODE": item.PCODE, "PDESC":item.DETAIL, "PNAME": item.NAME};
			break;
		}
		else
		{
			var activeData = {"PCODE": "", "PDESC":"", "PNAME": ""};
		}
		
	}
		
	var options = [];
	
	options[0] = {"V":"", "T":"Tipo"};
	options[1] = {"V":"CO", "T":"Cortesía"};
	options[2] = {"V":"PR-1", "T":"1 mes membresía Premium"};
	options[3] = {"V":"PR-3", "T":"3 meses membresía Premium"};
	options[4] = {"V":"PR-6", "T":"6 meses membresía Premium"};
	options[5] = {"V":"PR-12", "T":"12 meses membresía Premium"};
	
	
		
	var list = options;
	var picker = document.getElementById("cType");
	picker.innerHTML = "";
	
	var pickerF = document.getElementById("fType");
	pickerF.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var option = document.createElement("option");
		option.value = item.V;
		option.innerHTML = item.T;
		
		picker.appendChild(option);
		pickerF.appendChild(option.cloneNode(true));
		
	}
	
	if(activeData.PCODE != "")
	{
		var option = document.createElement("option");
		option.value = "promo-"+activeData.PCODE+"-"+activeData.PNAME;
		option.innerHTML = "Promo: "+activeData.PNAME;
		
		picker.appendChild(option);
		// pickerF.appendChild(option.cloneNode(true));
	}
	
}
function menuCreator(id, txt)
{
        var iface = "if"+id.split("menu")[1];
        
        var item = document.createElement("a");
		item.href = "#"+id;
		item.className = "nav-link js-scroll-trigger";
		item.innerHTML = language[txt];
		
		if(id == "sExit")
		{
			item.onclick = function()
			{
				item.href = "#sProd";
				logout();
				$('.navbar-collapse').collapse('hide');
			}
		}
		if(id == "sAdminG")
		{
			item.onclick = function()
			{
				var newWin = window.open("http://www.incocrea.com/algratin/?admingrati182b8457fb9157d0eb3a32c65e3ab423");             

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
		
        
        
        var li = document.createElement("li");
		li.className = "nav-item";
        li.appendChild(item);
		
        return li;
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
	
	if(code == "ifAdmin")
	{
		// document.getElementById("menuHome").click();
		console.log("test")
	}

	
}
// APP START END
// LOGIN AND SESSION START
function checkLogin()
{
	
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
		});
		

	}
	else
	{
		
		console.log("not logued")
		
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
			// document.getElementById("userPassBox").value = ""; 
		
			aud = ans;
			
			actualUcode = aud.UCODE;
			actualUname = aud.BNAME;
			localStorage.setItem("aud",actualUcode);
					
			var loginCover = document.getElementById("loginArea");
			loginCover.style.display = "none";
			
			var workArea = document.getElementById("mainContainerWeb");
			workArea.style.display = "block";
			
			setMenuItems("1");
                        
		}
		else
		{
			alertBox(language["alert"],language["missAuth"],300);
		}
		
	});

}
function logout()
{

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
		
		document.getElementById("regCountrySelector").value = "COLOMBIA";
		$("#regCountrySelector").trigger("change");
		actualUdpto =  ans.DPTO;
		actualUcity =  ans.CITY;
		
		document.getElementById("regRegionSelector").value = ans.DPTO;
		
		setTimeout(function()
		{
			var selector = document.getElementById("regRegionSelector");
			var options = selector.children;
			
			for(var i=0; i<options.length; i++)
			{
				var option = options[i].innerHTML.toUpperCase();
				
				if(option == actualUdpto)
				{
					options[i].selected = true;
					$("#regRegionSelector").trigger("change");
					break
				}
			}
		}, 50);
		
		setTimeout(function()
		{

			var selector = document.getElementById("regCitySelector");
			var options = selector.children;
			
			for(var i=0; i<options.length; i++)
			{
				var option = options[i].innerHTML.toUpperCase();
				
				if(option == actualUcity)
				{
					options[i].selected = true;
					break
				}
			}
		}, 150);

		actualEditPass = ans.PASSWD;
		
		formBox("regBox",language["miProfileTitle"],600);
		
	});
	
}
function pickedCountry(selection)
{
	var dtoSelector = document.getElementById("regRegionSelector");
	var ctySelector = document.getElementById("regCitySelector");
	ctySelector.innerHTML = '<option id="regCityBlank" value="">'+language["regCityBlank"]+'</option>';

	actualRegCountry = selection;
	
	if(selection == "")
	{
		dtoSelector.innerHTML = '<option id="regRegionBlank" value="">'+language["regRegionBlank"]+'</option>';
	}
	else
	{
		dtoSelector.innerHTML = '<option id="regRegionBlank" value="">'+language["regRegionBlank"]+'</option>';
		
		if(selection == "COLOMBIA")
		{
			actualDptos = deptosCol;
		}
		
		var index = Object.keys(actualDptos);
		for(var i = 0; i<index.length; i++)
		{
			var value = index[i];
			var inner = actualDptos[index[i]].capitalize();
			var option = document.createElement("option");
			option.value = value;
			option.innerHTML = inner;
			dtoSelector.appendChild(option);
		}
	}

}
function pickedDto(selection)
{
	var ctySelector = document.getElementById("regCitySelector");
	ctySelector.innerHTML = '<option id="regCityBlank" value="">'+language["regCityBlank"]+'</option>';
	
	if(selection == "")
	{
		ctySelector.innerHTML = '<option id="regCityBlank" value="">'+language["regCityBlank"]+'</option>';
	}
	else
	{
		ctySelector.innerHTML = '<option id="regRegionBlank" value="">'+language["regCityBlank"]+'</option>';
		

		if(actualRegCountry == "COLOMBIA")
		{
			actualCities = mpiosCol;
		}
		
		var cityList = actualCities[selection];
		var index = Object.keys(cityList);
		
		for(var i = 0; i<index.length; i++)
		{
			var value = index[i];
			var inner = cityList[index[i]].capitalize();
			var option = document.createElement("option");
			option.value = value;
			option.innerHTML = inner;
			ctySelector.appendChild(option);
		}
	}
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
// REG AND PROFILE END

// APP CORE START
function generateSerie()
{
	
	var info = {};
	info.sType = document.getElementById("cType").value;
	info.sDetail = document.getElementById("sDetail").value;
	info.sValue = document.getElementById("sValue").value;
	info.sQty = document.getElementById("sQty").value;
	
	if(info.sType == "")
	{
		alertBox(language["alert"],language["mustType"],300);
		return;
	}
	if(info.sDetail == "")
	{
		alertBox(language["alert"],language["mustDetail"],300);
		return;
	}
	if(info.sValue == "")
	{
		alertBox(language["alert"],language["mustValue"],300);
		return;
	}
	if(info.sQty == "")
	{
		alertBox(language["alert"],language["mustQty"],300);
		return;
	}
	
	console.log(actualPromoCcode)
	if(actualPromoCcode != "")
	{
		info.pCode = actualPromoCcode;
		info.sType = "promo";
		
		
	}
	else
	{
		info.pCode = "";
	}
	
	console.log(info)
	
	// return;

	sendAjax("users","generateSerie",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(ans == "NF")
		{
			alertBox(language["alert"],language["notFoundMail"],300);
			return;
		}
		else
		{
			document.getElementById("cType").value ="";
			document.getElementById("sDetail").value ="";
			document.getElementById("sValue").value ="";
			document.getElementById("sQty").value ="";
			document.getElementById("sQty").disabled = false;
			document.getElementById("sDetail").disabled = false;
			document.getElementById("sValue").disabled = false;
			
			if(info.sType == "CR")
			{
				alertBox("Completado", language["createdCr"]+info.sDetail, 300);
			}
			else
			{
				alertBox("Completado", language["createdSerie"]+ans, 300);
			}
			
			
			
			document.getElementById("fSerie").value = ans;
			document.getElementById("fType").value = "";
			document.getElementById("fCode").value = "";
			document.getElementById("fDetail").value = "";
			document.getElementById("fState").value = "";
			
			cListRefresh(0);
		}
	
		
		

		
	});
	
}
function generateProduct(saver)
{
	var action = saver.innerHTML;
	
	var info = {};
	
	if(action == "Crear")
	{
		action = "c";
	}
	else
	{
		action = "e";
		info.eCode = actualPcode;
	}
	
	
	
	info.pName = document.getElementById("pName").value;
	info.pDetail = document.getElementById("pDetail").value;
	info.pType = document.getElementById("pType").value;
	info.pValue = document.getElementById("pValue").value;
	info.pQty = document.getElementById("pQty").value;
	info.pLink = document.getElementById("pLink").value;
	info.pPlace = document.getElementById("pPlace").value;
	info.action = action;
	
	if(info.pName == "")
	{
		alertBox(language["alert"],language["mustNameP"],300);
		return;
	}
	if(info.pDetail == "")
	{
		alertBox(language["alert"],language["mustDetailP"],300);
		return;
	}
	if(info.sValue == "")
	{
		alertBox(language["alert"],language["mustType"],300);
		return;
	}
	if(info.sQty == "")
	{
		alertBox(language["alert"],language["mustQty"],300);
		return;
	}


	sendAjax("users","generateProduct",info,function(response)
	{
		var ans = response.message;

		document.getElementById("pName").value ="";
		document.getElementById("pDetail").value ="";
		document.getElementById("pValue").value ="";
		document.getElementById("pType").value ="p";
		document.getElementById("pQty").value ="";
		document.getElementById("pLink").value ="";
		document.getElementById("pPlace").value ="";
		
		if(info.action == "c")
		{
			alertBox("Completado", language["createdProduct"], 300);
		}
		else
		{
			alertBox("Completado", language["editedProduct"], 300);
			document.getElementById("pCreateB").innerHTML = "Crear";
				
			
		}
		
		pListRefresh();

	});
	
}
function generateSite(saver)
{
	var action = saver.innerHTML;
	console.log(action);
	
	var info = {};
	
	if(action == "Crear")
	{
		action = "c";
	}
	else
	{
		action = "e";
		info.eCode = actualScode;
	}

	info.sName = document.getElementById("sName").value;
	info.sType = document.getElementById("sType").value;
	info.sLoc = document.getElementById("sLoc").value;
	info.sAddress = document.getElementById("sAddress").value;
	info.sPhone = document.getElementById("sPhone").value;
	info.sMail = document.getElementById("sMail").value;
	info.sDesc = document.getElementById("sDesc").value;
	info.sEndate = document.getElementById("sEndate").value;
	info.action = action;
	
	if(info.sName == "")
	{
		alertBox(language["alert"],language["mustDetailS"],300);
		return;
	}
	if(info.sAddress == "")
	{
		alertBox(language["alert"],language["mustAddress"],300);
		return;
	}
	if(info.sPhone == "")
	{
		alertBox(language["alert"],language["mustPhone"],300);
		return;
	}
	if(info.sMail == "")
	{
		alertBox(language["alert"],language["mustMail"],300);
		return;
	}
	if(info.sEndate == "")
	{
		alertBox(language["alert"],language["mustEndate"],300);
		return;
	}


	sendAjax("users","generateSite",info,function(response)
	{
		var ans = response.message;
		
		
		tableCreator("sitesList", ans);
		
		document.getElementById("sName").value = "";
		document.getElementById("sType").value = "";
		document.getElementById("sLoc").value = "";
		document.getElementById("sAddress").value = "";
		document.getElementById("sPhone").value = "";
		document.getElementById("sMail").value = "";
		document.getElementById("sDesc").value = "";
		document.getElementById("sEndate").value = "";
		
		if(info.action == "c")
		{
			alertBox("Completado", language["createdSite"], 300);
		}
		else
		{
			alertBox("Completado", language["editedSite"], 300);
			document.getElementById("sCreateB").innerHTML = "Crear";
		}

		sListRefresh();

	});
	
}
function cListRefresh(expo)
{
	// SET FILTERS SET COMM
	
	var info = {};
	info.fSerie = document.getElementById("fSerie").value;
	info.fType = document.getElementById("fType").value;
	info.fCode = document.getElementById("fCode").value;
	info.fDetail = document.getElementById("fDetail").value;
	info.fState = document.getElementById("fState").value;
	info.expo = expo;

	info.index = "";

	sendAjax("users","getCList",info,function(response)
	{
		var ans = response.message;
		tableCreator("codesList", ans);
		
		if(info.expo == 1)
		{
			var url = "lsts/listado.csv";
			openInNewTab(url);
		}
		
	});
}
function usersGetXls()
{
	// SET FILTERS SET COMM
	
	var info = {};

	sendAjax("users","usersGetXls",info,function(response)
	{
		var ans = response.message;
		var url = "lsts/users.csv";
		openInNewTab(url);
	});
}
function pListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getPList",info,function(response)
	{
		var ans = response.message;
				
		actualProductsList = ans;
		
		tableCreator("productsList", ans);
		
		if(info.expo == 1)
		{
			var url = "lsts/listado.csv";
			openInNewTab(url);
		}
		
	});
}
function promoListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getPromoList",info,function(response)
	{
		var ans = response.message;

		tableCreator("promosList", ans);
		
		actualPromoList = ans;
		codeTypeFiller();

		
	});
}
function servicesListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getServicesList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		tableCreator("servicesList", ans);
		
		// actualPromoList = ans;
		// codeTypeFiller();

		
	});
}
function uListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getUList",info,function(response)
	{
		var ans = response.message;

		tableCreator("usersList", ans);
		
	});
}
function sListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getSList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)

		tableCreator("sitesList", ans);
		
		if(info.expo == 1)
		{
			var url = "lsts/listado.csv";
			openInNewTab(url);
		}
		
	});
}
function exListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getExList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)

		tableCreator("exList", ans);
		

		
	});
}
function setCodeForm(val)
{
	if(val == "")
	{
		document.getElementById("sDetail").value = "";
		document.getElementById("sValue").value = "";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = false;
		document.getElementById("sValue").disabled = false;

	}
	else if(val == "CR")
	{
		document.getElementById("sDetail").value = "";
		document.getElementById("sValue").value = "";
		document.getElementById("sQty").value = "1";
		document.getElementById("sQty").disabled = true;
		document.getElementById("sDetail").disabled = false;
		document.getElementById("sValue").disabled = false;
	}
	else if(val == "CO")
	{
		document.getElementById("sDetail").value = "";
		document.getElementById("sValue").value = "";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = false;
		document.getElementById("sValue").disabled = false;
	}
	else if(val == "PR-1")
	{
		document.getElementById("sDetail").value = "1 mes membresía Premium";
		document.getElementById("sValue").value = "0";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = true;
		document.getElementById("sValue").disabled = true;
	}
	else if(val == "PR-3")
	{
		document.getElementById("sDetail").value = "3 meses membresía Premium";
		document.getElementById("sValue").value = "0";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = true;
		document.getElementById("sValue").disabled = true;
	}
	else if(val == "PR-6")
	{
		document.getElementById("sDetail").value = "6 meses membresía Premium";
		document.getElementById("sValue").value = "0";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = true;
		document.getElementById("sValue").disabled = true;
	}
	else if(val == "PR-12")
	{
		document.getElementById("sDetail").value = "12 meses membresía Premium";
		document.getElementById("sValue").value = "0";
		document.getElementById("sQty").value = "";
		document.getElementById("sQty").disabled = false;
		document.getElementById("sDetail").disabled = true;
		document.getElementById("sValue").disabled = true;
	}


	var value = val.split("-");
	
	var title = value[0];
	
	if(title == "promo")
	{
		actualPromoCcode = value[1];
		var pname = value[2];
		
		var detBox = document.getElementById("sDetail");
		var valueBox = document.getElementById("sValue");
		valueBox.innerHTML = "";
		valueBox.disabled = false;
		detBox.disabled = true;
		detBox.value = pname;
		
	}
	else
	{
		actualPromoCcode = "";
	}
	
	
}
function saveClaimIns()
{
	var text = document.getElementById("pInstrucs").value;

	console.log(text)

	pack = {};
	pack.text = text;
	
	sendAjax("users","instSave",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		alertBox(language["alert"], "Instrucciones guardadas!", 300);
	
		
	});
	
}
function savePromo()
{
	
	var action  = document.getElementById("promoSaveB").innerHTML;
	var name = document.getElementById("promoName").value;
	var detail = document.getElementById("promoDetail").value;
	var sdate = document.getElementById("promoSdate").value;
	var edate = document.getElementById("promoEdate").value;
	var text = document.getElementById("promoConds").value;


	var pack = {};
	pack.action =  action;
	pack.name = name;
	pack.detail = detail;
	pack.sdate = sdate;
	pack.edate = edate;
	pack.text = text;
	pack.pcode = actualPromocode;
	
	if(pack.name == ""){alertBox(language["alert"], language["mustNamePromo"], 300); return;}
	if(pack.detail == ""){alertBox(language["alert"], language["mustDetailPromo"], 300); return;}
	if(pack.sdate == ""){alertBox(language["alert"], language["mustSdatePromo"], 300); return;}
	if(pack.edate == ""){alertBox(language["alert"], language["mustEdatePromo"], 300); return;}
	if(pack.text == ""){alertBox(language["alert"], language["mustCondsPromo"], 300); return;}

	sendAjax("users","savePromo",pack,function(response)
	{
		var ans = response.message;
		
		document.getElementById("promoSaveB").innerHTML == "Crear";
		document.getElementById("promoName").value = "";
		document.getElementById("promoDetail").value = "";
		document.getElementById("promoSdate").value = "";
		document.getElementById("promoEdate").value = "";
		document.getElementById("promoConds").value = "";
		
		alertBox(language["alert"], language["savedPromo"], 300);
		promoListRefresh();
		
	});
	
}
function saveService()
{
	var action  = document.getElementById("serviceCreateB").innerHTML;
	var detail = document.getElementById("serviceName").value;
	var duration = document.getElementById("serviceDuration").value;
	var cost = document.getElementById("serviceCost").value;
	var give = document.getElementById("serviceGive").value;
		
	var pack = {};
	pack.action =  action;
	pack.detail =  detail;
	pack.cost =  cost;
	pack.give =  give;
	pack.duration = duration;
	pack.eServiceCode = eServiceCode;
	
	if(pack.detail == ""){alertBox(language["alert"], language["mustNameService"], 300); return;}
	if(pack.cost == ""){alertBox(language["alert"], language["mustCostService"], 300); return;}
	if(pack.give == ""){alertBox(language["alert"], language["mustGiveService"], 300); return;}

	
	sendAjax("users","saveService",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		document.getElementById("serviceCreateB").innerHTML = "Crear";
		document.getElementById("serviceName").value = "";
		document.getElementById("serviceDuration").value = "15";
		document.getElementById("serviceCost").value = "";
		document.getElementById("serviceGive").value = "";
		
		
		
		alertBox(language["alert"], language["savedService"], 300);
		servicesListRefresh();
		
	});
	
}

// SHOW RANKING
function showRanking(code)
{
	
	var info = {};
	info.pcode = code;
	
	console.log(info);

	sendAjax("users","getRanking",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		formBox("rankingBoxP","Tabla de puntajes",600);
		
		tableCreator("rankList", ans);
	
	});
}


// TABLES
function tableCreator(tableId, list)
{
	var table = document.getElementById(tableId);
	tableClear(tableId);
	setIFAutoFields(tableId, list);
	
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
	// CODES TABLE
	if(tableId == "codesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Serie', list[i].SERIE);
			
			var c = cellCreator('Código', list[i].CODE);
			var d = cellCreator('Detalle', list[i].DETAIL);

			if(list[i].STATUS == "1")
			{
					var statusL = "Nuevo";
			}
			else
			{
					var statusL = "Usado";
			}
			
			if(list[i].TYPE.split("PR").length > 1)
			{
				var f = cellCreator('Valor',list[i].AMOUNT+" BC");
				var type = "Código para membresía Premium";
			}
			else if(list[i].TYPE == "CO")
			{
				
				var f = cellCreator('Valor', addCommas(list[i].AMOUNT));
				var type = "Bono de Compra";
			}
			else
			{
				var f = cellCreator('Valor', list[i].AMOUNT);
				var type = "Código de promoción";
			}
			
			var b = cellCreator('Tipo', type);
			
			var e = cellCreator('Estado', statusL);
			
			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Eliminar');
			del.setAttribute('alt', 'Eliminar');
			del.onclick = function()
			{
					var tableId = this.parentNode.parentNode.parentNode.id;
					var param = [tableId, this.reg.SERIE+"-"+this.reg.CODE];
					
					confirmBox(language["confirm"], language["sys015"], deleteRecord, 300, param);
			}
			
			var stater = document.createElement("img");
			stater.reg = list[i];
			stater.setAttribute('title', 'Cambiar estado');
			stater.setAttribute('alt', 'Cambiar estado');
			stater.onclick = function()
			{
				
				var param = this.reg;
				
				confirmBox(language["confirm"], language["stateConfirm"], stChanger, 300, param);
			
			}

			if(list[i].STATUS == "1")
			{
					stater.src = 'irsc/unUsedIcon.png';
			}
			else
			{
					stater.src = 'irsc/usedIcon.png';
			}
			
			var icons = [stater, del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,f,e,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
		}
	}
	// PRODUCT TABLE
	if(tableId == "productsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var l = cellCreator('Nombre', list[i].PNAME);
			var a = cellCreator('Detalle', list[i].DETAIL);
			var b = cellCreator('Tipo', list[i].TYPE);
			var c = cellCreator('Valor', list[i].PRICE);
			var d = cellCreator('Disponible', list[i].AVAILABLE);
			var e = cellCreator('Posición', list[i].POS);
			
			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/editIcon.png";
			edit.setAttribute('title', 'Editar');
			edit.setAttribute('alt', 'Editar');
			edit.onclick = function()
			{
				var reg = this.reg;
				
				actualPcode = reg.CODE;
				
				document.getElementById("pName").value = reg.PNAME;
				document.getElementById("pDetail").value = reg.DETAIL;
				document.getElementById("pType").value = reg.TYPE;
				document.getElementById("pValue").value = reg.PRICE;
				document.getElementById("pQty").value = reg.AVAILABLE;
				document.getElementById("pPlace").value = reg.POS;
				document.getElementById("pLink").value = reg.LINK;
				
				document.getElementById("pCreateB").innerHTML = "Guardar";
				
			}

			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.CODE;
				actualPicType = "product";
				actualScode = this.reg.CODE;
				
				if(this.reg.HP == "1")
				{
					var path = "img/products/"+this.reg.CODE+".jpg"
					openPicSelector(language["cbTitle"], [400,260], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [400,260], "load", null)
				}

			}

			if(list[i].HP == "0")
			{
				pic.src = "irsc/nopic.png";	
			}
			else
			{
				pic.src = "irsc/yespic.png";
			}
			
			var n = celloneIconCreator('Foto', [pic]);

			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Eliminar');
			del.setAttribute('alt', 'Eliminar');
			del.onclick = function()
			{
					var tableId = this.parentNode.parentNode.parentNode.id;
					var param = [tableId, this.reg.CODE];
					
					confirmBox(language["confirm"], language["sys015"], deleteRecord, 300, param);
			}
			
			var icons = [pic, edit, del];

			var x = cellOptionsCreator('', icons)
			var cells = [l,a,b,c,d,e,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
		}
	}
	// SITES TABLE
	if(tableId == "sitesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Nombre', list[i].SNAME);
			var b = cellCreator('Tipo', list[i].STYPE);
			var c = cellCreator('Ciudad', list[i].LOCATION);
			var d = cellCreator('Dirección', list[i].ADDRESS);
			var e = cellCreator('Teléfono', list[i].PHONE);
			var f = cellCreator('Email', list[i].EMAIL);
			var n = cellCreator('Foto', list[i].SHP);
			
			var now = getNowSimple();
			
			if(list[i].ENDATE < now)
			{
				var endDate = "<span style='color: red;'>"+list[i].ENDATE+"</span>";
			}
			else
			{
				var endDate = "<span style='color: green;'>"+list[i].ENDATE+"</span>";
			}

			var o = cellCreator('Vence', endDate);


			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.SCODE;
				actualPicType = "site";
				actualScode = this.reg.SCODE;
				
				if(this.reg.SHP == "1")
				{
					var path = "img/sites/"+this.reg.SCODE+".jpg"
					openPicSelector(language["cbTitle"], [300,410], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [300,410], "load", null)
				}

			}

			if(list[i].SHP == "0")
			{
				pic.src = "irsc/nopic.png";	
			}
			else
			{
				pic.src = "irsc/yespic.png";
			}
			
			var n = celloneIconCreator('Foto', [pic]);
			
			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/editIcon.png";
			edit.setAttribute('title', 'Editar');
			edit.setAttribute('alt', 'Editar');
			edit.onclick = function()
			{
				var reg = this.reg;
				
				actualScode = reg.SCODE;
				
				document.getElementById("sName").value = reg.SNAME;
				document.getElementById("sType").value = reg.STYPE;
				document.getElementById("sLoc").value = reg.LOCATION;
				document.getElementById("sAddress").value = reg.ADDRESS;
				document.getElementById("sPhone").value = reg.PHONE;
				document.getElementById("sDesc").value = reg.DETAIL;
				document.getElementById("sMail").value = reg.EMAIL;
				document.getElementById("sEndate").value = reg.ENDATE;
				
				document.getElementById("sCreateB").innerHTML = "Guardar";
				
			}
			
			var sp1 = document.createElement("img");
			sp1.reg = list[i];
			sp1.setAttribute('title', 'Especialidad 1');
			sp1.setAttribute('alt', 'Especialidad 1');
			sp1.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC1";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp1"], stChangerSkill, 300, param);
			}
			if(list[i].SPEC1 == "0"){sp1.src = "irsc/sp1g.png";}
			else{sp1.src = "irsc/sp1.png";}
			var g = celloneIconCreator('Foto', [sp1]);

			var sp2 = document.createElement("img");
			sp2.reg = list[i];
			sp2.setAttribute('title', 'Especialidad 2');
			sp2.setAttribute('alt', 'Especialidad 2');
			sp2.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC2";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp2"], stChangerSkill, 300, param);
			}
			if(list[i].SPEC2 == "0"){sp2.src = "irsc/sp2g.png";}
			else{sp2.src = "irsc/sp2.png";}
			var h = celloneIconCreator('Foto', [sp2]);
			
			var sp3 = document.createElement("img");
			sp3.reg = list[i];
			sp3.setAttribute('title', 'Especialidad 3');
			sp3.setAttribute('alt', 'Especialidad 3');
			sp3.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC3";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp3"], stChangerSkill, 300, param);
			}

			
			if(list[i].SPEC3 == "0"){sp3.src = "irsc/sp3g.png";}
			else{sp3.src = "irsc/sp3.png";}
			var j = celloneIconCreator('Foto', [sp3]);

			var sp4 = document.createElement("img");
			sp4.reg = list[i];
			sp4.setAttribute('title', 'Especialidad 4');
			sp4.setAttribute('alt', 'Especialidad 4');
			sp4.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC4";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp4"], stChangerSkill, 300, param);
			}
			if(list[i].SPEC4 == "0"){sp4.src = "irsc/sp4g.png";}
			else{sp4.src = "irsc/sp4.png";}
			var k = celloneIconCreator('Foto', [sp4]);
			
			var sp5 = document.createElement("img");
			sp5.reg = list[i];
			sp5.setAttribute('title', 'Especialidad 5');
			sp5.setAttribute('alt', 'Especialidad 5');
			sp5.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC5";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp5"], stChangerSkill, 300, param);
			}
			if(list[i].SPEC5 == "0"){sp5.src = "irsc/sp5g.png";}
			else{sp5.src = "irsc/sp5.png";}
			var l = celloneIconCreator('Foto', [sp5]);
			
			var sp6 = document.createElement("img");
			sp6.reg = list[i];
			sp6.setAttribute('title', 'Especialidad 6');
			sp6.setAttribute('alt', 'Especialidad 6');
			sp6.onclick = function()
			{
				actualScode = this.reg.SCODE;
				actualSkill = "SPEC6";

				var param = this.reg;
				
				confirmBox(language["confirm"], language["stChangeSp6"], stChangerSkill, 300, param);
			}
			if(list[i].SPEC6 == "0"){sp6.src = "irsc/sp6g.png";}
			else{sp6.src = "irsc/sp6.png";}
			var m = celloneIconCreator('Foto', [sp6]);
			
			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Eliminar');
			del.setAttribute('alt', 'Eliminar');
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var param = [tableId, this.reg.SCODE];
				
				confirmBox(language["confirm"], language["sys015"], deleteRecord, 300, param);
			}
			
			var icons = [pic, edit, del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,f,o,g,h,j,k,l,m,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}
	}
	// PRODUCT TABLE
	if(tableId == "exList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			
			var a = cellCreator('Fecha', list[i].DATE);
			var b = cellCreator('Usuario', list[i].PCODE);
			var c = cellCreator('Cantidad', addCommas(list[i].VALUE));
			
			var state = "";
			
			if(list[i].STATE == "0"){state = "<b style='color: green;'>Activo</b>";}
			if(list[i].STATE == "4"){state = "<b style='color: red;'>Completada</b>";}
			if(list[i].STATE == "3"){state = "<b style='color: red;'>Pendiente</b>";}
			
			
			var d = cellCreator('Estado', state);
			
			
			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.CODE;
				actualPicType = "product";
				actualScode = this.reg.CODE;
				
				if(this.reg.HP == "1")
				{
					var path = "img/products/"+this.reg.CODE+".jpg"
					openPicSelector(language["cbTitle"], [400,260], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [400,260], "load", null)
				}

			}
			
			var aprobe = document.createElement("img");
			aprobe.reg = list[i];
			aprobe.src = "irsc/editIcon.png";
			aprobe.setAttribute('title', 'Editar');
			aprobe.setAttribute('alt', 'Editar');
			aprobe.onclick = function()
			{
				var reg = this.reg;
				
				autorizeTrans(this.reg, "1")
				
			}

			if(list[i].HP == "0")
			{
				pic.src = "irsc/nopic.png";	
			}
			else
			{
				pic.src = "irsc/yespic.png";
			}
			
			var n = celloneIconCreator('Foto', [pic]);

			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Cancelar');
			del.setAttribute('alt', 'Cancelar');
			del.onclick = function()
			{
				var reg = this.reg;
				autorizeTrans(this.reg, "0")
			}
			
			if(list[i].STATE == "3")
			{
				var icons = [aprobe, del];
			}
			else
			{
				var icons = [];
			}
			
			

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
		}
	}
	// USERS TABLE
	if(tableId == "usersList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var box = "<input type='checkbox' id='"+list[i].UCODE+"'/>";
			var cb = cellCreator('', box);
			var a = cellCreator('Nombre', list[i].NAME);
			var b = cellCreator('Email', list[i].EMAIL);
			var c = cellCreator('Cantidad', list[i].CITY);
			var d = cellCreator('Teléfono', list[i].PHONE);
			
			var tipo = "";
			
			if(list[i].UTYPE == "E"){tipo = "<b style='color: green;'>Estilista</b>";}
			if(list[i].UTYPE == "C"){tipo = "<b style='color: red;'>Cliente</b>";}
			if(list[i].TYPE == "2"){tipo = "<b style='color: #800080;'>SuperAdmin</b>";}
			
			var f = cellCreator('Tipo', tipo);
			var e = cellCreator('Fecha registro', list[i].REGDATE);
			
			if(list[i].PREMIUM == "1")
			{
				var premi = "Hasta "+list[i].PRENDATE.split(" ")[0];
			}
			else
			{
				var premi = "No";
			}
			
			var g = cellCreator('Premium', premi);
			
			
			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.CODE;
				actualPicType = "product";
				actualScode = this.reg.CODE;
				
				if(this.reg.HP == "1")
				{
					var path = "img/products/"+this.reg.CODE+".jpg"
					openPicSelector(language["cbTitle"], [400,260], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [400,260], "load", null)
				}

			}
			
			var n = celloneIconCreator('Foto', [pic]);

			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Cancelar');
			del.setAttribute('alt', 'Cancelar');
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var param = [tableId, this.reg.UCODE];
					
				confirmBox(language["confirm"], language["sys015"], deleteRecord, 300, param);
			}
			
			var prem = document.createElement("img");
			prem.reg = list[i];
			prem.setAttribute('title', 'Premium');
			prem.setAttribute('alt', 'Premium');
			prem.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var param = [tableId, this.reg.UCODE];
				
				console.log(this.reg);
				setPremium(this.reg);
				
			}
			
			if(list[i].PREMIUM == "1")
			{
				prem.src = "irsc/pricon.png";
			}
			else
			{
				prem.src = "irsc/priconG.png";
			}
			
			if(list[i].TYPE == "2")
			{
				var icons = [prem];
			}
			else
			{
				var icons = [prem, del];
			}
			
			
			var x = cellOptionsCreator('', icons)
			
			var cells = [cb, a,b,c,d,f,e,g,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
		}
	}
	// PROMOS TABLE
	if(tableId == "promosList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			
			var a = cellCreator('Nombre', list[i].NAME);
			var b = cellCreator('Detalle', list[i].DETAIL);
			var c = cellCreator('Fecha inicio', list[i].SDATE);
			var d = cellCreator('Fecha fin', list[i].EDATE);
			
			var del = document.createElement("img");
			del.src = "irsc/delIcon.png";
			del.reg = list[i];
			del.setAttribute('title', 'Cancelar');
			del.setAttribute('alt', 'Cancelar');
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var param = [tableId, this.reg.PCODE];
					
				confirmBox(language["confirm"], language["sys015"], deleteRecord, 300, param);
			}
			
			var rnk = document.createElement("img");
			rnk.src = "irsc/linkIcon.png";
			rnk.reg = list[i];
			rnk.setAttribute('title', 'Ranking');
			rnk.setAttribute('alt', 'Ranking');
			rnk.onclick = function()
			{
				showRanking(this.reg.PCODE);
			}
			
			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/editIcon.png";
			edit.setAttribute('title', 'Editar');
			edit.setAttribute('alt', 'Editar');
			edit.onclick = function()
			{
				var reg = this.reg;
				
				actualPromocode = reg.PCODE;
				
				document.getElementById("promoName").value = reg.NAME;
				document.getElementById("promoDetail").value = reg.DETAIL;
				document.getElementById("promoSdate").value = reg.SDATE;
				document.getElementById("promoEdate").value = reg.EDATE;
				document.getElementById("promoConds").value = reg.CONDS;
				
				document.getElementById("promoSaveB").innerHTML = "Guardar";
				
			}
			
			var active = document.createElement("img");
			active.reg = list[i];
			active.src = "irsc/unUsedIcon.png";
			active.setAttribute('title', 'Marcar como Activa');
			active.setAttribute('alt', 'Marcar como Activa');
			active.onclick = function()
			{
				var param = this.reg;
				
				confirmBox(language["confirm"], language["stateConfirm"], stPromoChanger, 300, param);
				
			}
			
			if(list[i].ACTIVE == "0")
			{
				active.src = "irsc/usedIcon.png";	
			}
			else
			{
				active.src = "irsc/unUsedIcon.png";
			}
			
			var pic1 = document.createElement("img");
			pic1.reg = list[i];
			pic1.setAttribute('title', 'Foto 1');
			pic1.setAttribute('alt', 'Foto 1');
			pic1.onclick = function()
			{
				actualPicCode = this.reg.PCODE;
				actualPicType = "promo";
				actualScode = this.reg.PCODE;
				
				if(this.reg.HP == "1")
				{
					var path = "img/prpics/"+this.reg.PCODE+".jpg"
					openPicSelector(language["cbTitle"], [1200,500], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [1200,500], "load", null)
				}

			}

			if(list[i].HP == "0")
			{
				pic1.src = "irsc/nopic.png";	
			}
			else
			{
				pic1.src = "irsc/yespic.png";
			}
			
			var icons = [edit, pic1,active,rnk,del];
			
			var x = cellOptionsCreator('', icons)
			
			var cells = [a,b,c,d,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
		}
	}
	// SERVICES TABLE
	if(tableId == "servicesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Código', list[i].SRCODE);
			var b = cellCreator('Detalle', list[i].DETAIL);
			var c = cellCreator('Duración', list[i].MINUTES);
			var d = cellCreator('Costo', list[i].COST);
			var e = cellCreator('Regala', list[i].GIVE);
			
			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/editIcon.png";
			edit.setAttribute('title', 'Editar');
			edit.setAttribute('alt', 'Editar');
			edit.onclick = function()
			{
				var reg = this.reg;
				
				eServiceCode = reg.SRCODE;
				document.getElementById("serviceName").value = reg.DETAIL;
				document.getElementById("serviceDuration").value = reg.MINUTES;
				document.getElementById("serviceCost").value = reg.COST;
				document.getElementById("serviceGive").value = reg.GIVE;
				
				document.getElementById("serviceCreateB").innerHTML = "Guardar";

			}
			
			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.SRCODE;
				actualPicType = "service";
				actualScode = this.reg.SRCODE;

				
				if(this.reg.HP == "1")
				{
					var path = "img/spics/"+this.reg.SRCODE+".jpg"
					openPicSelector(language["cbTitle"], [400,200], "edit", path);
				}
				else
				{
					openPicSelector(language["cbTitle"], [400,200], "load", null)
				}

			}

			if(list[i].HP == "0")
			{
				pic.src = "irsc/nopic.png";	
			}
			else
			{
				pic.src = "irsc/yespic.png";
			}
			
			var icons = [pic,edit];
			
			var x = cellOptionsCreator('', icons)
			
			var cells = [a,b,c,d,e,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
			if(aud.TYPE == "P")
			{
					edit.click();
			}
				
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
	
	resSet();
}
function stChanger(info)
{
	var actual = info.STATUS;
	
	if(actual == "1")
	{
		var nactual = "2";
	}
	else
	{
		var nactual = "1";
	}
	
	pack = {};
	pack.serie = info.SERIE;
	pack.code = info.CODE;
	pack.nactual = nactual;
	
	sendAjax("users","stater",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		cListRefresh(0);
	});
}
function stPromoChanger(info)
{
	var actual = info.ACTIVE;
	
	if(actual == "0")
	{
		var nactual = "1";
	}
	else
	{
		var nactual = "0";
	}
	
	pack = {};
	pack.code = info.PCODE;
	pack.nactual = nactual;
	
	sendAjax("users","staterPromo",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		promoListRefresh(0);
	});
}
function stChangerSkill(info)
{
	var actual = info[actualSkill];
	
	if(actual == "0")
	{
		var nactual = "1";
	}
	else
	{
		var nactual = "0";
	}
	
	pack = {};
	pack.code = info.SCODE;
	pack.skill = actualSkill; 
	pack.nactual = nactual;
	
	sendAjax("users","staterSkill",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		sListRefresh();
	});
}
// DELETER
function deleteRecord(param)
{
        var info = {};
        info.autor = aud.RESPNAME;
        info.date = getNow();
        
        if(param[0] == "codesList")
        {
                info.table = "stickers";
                info.code = param[1];
                info.delType = "sticker";
				info.ucode  = aud.UCODE;
				
				console.log(info)
				
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;
						console.log(ans);
                        // alertBox(language["alert"], language["sys012"],300);

                        cListRefresh(0);
                });
                
        }
		if(param[0] == "sitesList")
        {
                info.table = "hfame";
                info.code = param[1];
                info.delType = "site";
				info.ucode  = aud.UCODE;
				
				console.log(info)
				
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                       sListRefresh()
                });
                
        }
		if(param[0] == "productsList")
        {
                info.table = "products";
                info.code = param[1];
                info.delType = "product";
				info.ucode  = aud.UCODE;
				
				console.log(info)
				
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;
						console.log(ans)
                       pListRefresh()
                });
                
        }
		if(param[0] == "usersList")
        {
                info.table = "users";
                info.code = param[1];
                info.delType = "user";
				info.ucode  = aud.UCODE;
				
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;
						console.log(ans)
                       uListRefresh()
                });
                
        }
		if(param[0] == "promosList")
        {
                info.table = "promos";
                info.code = param[1];
                info.delType = "promo";
				info.ucode  = aud.UCODE;
				
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;
						console.log(ans)
                       promoListRefresh()
                });
                
        }
}
function openPriceDeliver()
{
	
	descBox = document.getElementById("prizeResumeBox");
	descBox.innerHTML = "";
	desCover = document.createElement("img");
	desCover.src = "irsc/desCover.png";
	descBox.appendChild(desCover);
	document.getElementById("codeCheckBox").value = "";
	actualDeliverCode = "";
	formBox("claimPrizeDiv",language["claimPopTitle"],300);
	
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
		descSpan.innerHTML = language["noCodeLine"];
		return;
	}
	
	sendAjax("users","codeCheck",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(response.founded)
		{
			if(ans.STATUS == "2")
			{
				descSpan.innerHTML = language["alreadyDelivered"];
				adc = "";
			}
			else
			{
				
				console.log(ans)
				
				if(ans.TYPE.split("-")[0] == "BC")
				{
					descSpan.innerHTML = language["deliverTitle1"]+ans.DETAIL+"<br>"+ language["deliverTitle2"]+ans.AMOUNT+" BC";
				}
				else
				{
					descSpan.innerHTML = language["deliverTitle1"]+ans.DETAIL+"<br>"+ language["deliverTitle2"]+"$"+ans.AMOUNT;
				}
				
				adc = ans.SERIE+"-"+ans.CODE;

				var modalArea = document.getElementById("modal");
				centererPop(modalArea);
			}
		}
		else
		{
			descSpan.innerHTML = language["invalidCodePrize"];
			adc = "";
		}
		
	});
	
}
function markPrize()
{
	if(adc == "")
	{
		descBox.innerHTML = "";
		descSpan = document.createElement("span");
		descBox.appendChild(descSpan);
		descSpan.innerHTML = language["noDeliverCode"];
	}
	else
	{
		var info = {};
		info.code = adc;
		confirmBox(language["confirm"],language["markPrizeConfirm"],sendMarkFlag,300, info);
	}
}
function sendMarkFlag(info)
{
	sendAjax("users","markCode",info,function(response)
	{
		var ans = response.message;
		
		if(ans)
		{
			descBox.innerHTML = "";
			descSpan = document.createElement("span");
			descBox.appendChild(descSpan);
			descSpan.innerHTML = language["prizeClaimedTwice"];
		}
		else
		{
			descBox.innerHTML = "";
			descSpan = document.createElement("span");
			descBox.appendChild(descSpan);
			descSpan.innerHTML = language["prizeClaimed"];
		}
		
	});
}
function prepareImgCropper1()
{
	var picSelector = document.getElementById("picSelector");
	picSelector.addEventListener('change', handleFileSelect, false);
	
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
			setTimeout(function()
			{
				setCBsize();
			},200);
			
		}
		reader.readAsDataURL(this.files[0]);
		var img = cropper.getDataURL();
		
	})
	document.querySelector('#btnCrop').addEventListener('click', function(){
		var img = cropper.getDataURL();
		actualCroppedPic = img;
		savepPic()
		hide_pop_form();
		var pickSelector = document.getElementById('picSelector').value = "";
	})
	document.querySelector('#btnZoomIn').addEventListener('click', function(){cropper.zoomIn();})
	document.querySelector('#btnZoomOut').addEventListener('click', function(){cropper.zoomOut();})
}
function prepareImgCropper2()
{
	options2 =
	{
		imageBox: '.imageBox2',
		thumbBox: '.thumbBox2',
		spinner: '.spinner2',
		imgSrc: 'irsc/imageSample.png'
	}
	cropper2 = new cropbox(options2);
	document.querySelector('#picSelector2').addEventListener('change', function()
	{
		var reader2 = new FileReader();
		reader2.onload = function(e) 
		{
			var img = new Image;

			img.onload = function() 
			{
				var pickSelector2 = document.getElementById('picSelector2');
				
				var w = img.width;
				var h = img.height;
				var format = pickSelector2.value.split(".")[1];
				
				if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
				{
					actualCroppedPic = "";
					alertBox(language["alert"], language["wrongFormatJpg"], 300);
					pickSelector2.value = "";
					// document.getElementById("img-"+actualPicType).src = "../images/slider/pcs0.jpg";
					return;
				}
				
				if(w != 1600 || h != 900)
				{
					actualCroppedPic = "";
					alertBox(language["alert"], language["wrongFormatJpg"], 300);
					pickSelector2.value = "";
					// document.getElementById("img-"+actualPicType).src = "../images/slider/pcs0.jpg";
					return;
				}
				
				options2.imgSrc = e.target.result;
				cropper2 = new cropbox(options2);
				actualCroppedPic = e.target.result;
				
				document.getElementById("img-"+actualPicType).src = e.target.result;
				document.getElementById('picSelector2').value = "";
				
				console.log("save file and notify")
				savepPic();
			};
			
			img.src = reader2.result;
		}
		reader2.readAsDataURL(this.files[0]);
	})
}
function pickpic()
{
	document.getElementById("picSelector").click();
}
function openPicSelector(title, size, action, path)
{
	actualImgWidth = size[0];
	actualImgHeight = size[1];
	
	 setCBsize();
	
	var sample = document.getElementById("imgBox");
	if(path != null)
	{
		tail = "?r="+Math.random();
		console.log("yes it does")
		sample.style.backgroundImage = "url('"+path+tail+"')";
	}
	else
	{
		sample.style.backgroundImage  = "url('irsc/imageSample.png')";
	}
	sample.style.backgroundSize = "100% 100%";
	sample.style.backgroundPosition  = "0 0";
	
	if(action == "edit")
	{
		document.getElementById("btnCrop").style.display = "none";
		document.getElementById("btnZoomIn").style.display = "none";
		document.getElementById("btnZoomOut").style.display = "none";
	}
	
	formBox("cropBoxBox",title,(actualImgWidth+30));
}
function setCBsize()
{
	var imageBox = document.getElementById("imgBox");
	var thumbBox = document.getElementById("thumbBox");
	imageBox.style.width = actualImgWidth+"px";
	imageBox.style.height = actualImgHeight+"px";
	thumbBox.style.width = actualImgWidth+"px";
	thumbBox.style.height = actualImgHeight+"px";
}
function handleFileSelect(evt) 
{
		var pickSelector = document.getElementById('picSelector');
		var format = pickSelector.value.split(".")[1];
		
		var blankImg = document.createElement("img");
		blankImg.src = "irsc/imageSample.png";
		blankImg.id = "imageSample";
		blankImg.className = "imageSample";
		
		console.log(format)
		
		if(format != "jpg" && format != "JPG" && format != "JPEG" && format != "jpeg")
		{
			alertBox(language["alert"], language["wrongFormatPic"], 300);
			pickSelector.value = "";
			// document.getElementById('sampleImageCox').innerHTML = "";
			// document.getElementById('sampleImageCox').appendChild(blankImg);
			actualCroppedPic = "";
			return;
		}
		document.getElementById("btnCrop").style.display = "initial";
		document.getElementById("btnZoomIn").style.display = "initial";
		document.getElementById("btnZoomOut").style.display = "initial";
		
		
}
function savepPic()
{
	var info = {};
	info.pic = actualCroppedPic;
	info.code = actualPicCode;
	info.scode = actualScode;
	info.picType = actualPicType;
	
	console.log(info)
	// return
	
	sendAjax("users","picsave",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		actualCroppedPic = "";
		alertBox(language["alert"], language["picDone"], 300);
		
		if(info.picType == "site")
		{
			sListRefresh()
		}
		if(info.picType == "product")
		{
			pListRefresh()
		}
		if(info.picType == "promo")
		{
			promoListRefresh();
		}
		if(info.picType == "service")
		{
			servicesListRefresh();
		}
	});
}

// SET PREMIUM STATE
function setPremium(reg)
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
	input1.placeholder = "Fecha vencimiento";
	
	if(reg.PRENDATE != null)
	{
		input1.value = reg.PRENDATE.split(" ")[0];
	}
	else
	{
		input1.value = getNow().split(" ")[0];
	}

	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButton";
	recMailSend.data = reg;
	recMailSend.innerHTML = language["accept"];
	recMailSend.onclick = function()
	{
		
		var info = {};
		info.newDate = $("#input1").val();
		info.ucode = reg.UCODE;
		
		var nd = new Date(info.newDate).getTime();
		var ad = new Date(getNow().split(" ")[0]).getTime();
		console.log(nd);
		console.log(ad);
		
		if(nd > ad)
		{
			info.state = "1";
		}
		else
		{
			info.state = "0";
		}

		if(info.newDate == "")
		{
			alertBox(language["alert"], language["mustPrdate"],300);
			return;
		}
		
		console.log(info)
		
		sendAjax("users","setPrDate",info,function(response)
		{
			var ans = response.message;
			console.log(ans);
			hide_pop_form();
			alertBox(language["alert"],language["prSetted"],300);
			uListRefresh();
			
		});
	}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButton";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input1);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);
	
	jQuery('#input1').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });
	
	var title = "Configurar Vencimiento Premium";
	
		
	formBox("pssRecBox",title,300);
}

// ACTIVATE COURSES
// SET PREMIUM STATE
function activatePop(reg)
{
	
	var rows = document.getElementById("usersList").children;
	
	var pickedUsers = [];
	var list = rows;
	for(var i=1; i<list.length; i++)
	{
		var item = list[i];
		var box = item.children[0].children[0];
		if(box.checked)
		{
			pickedUsers.push(box.id);
		}
	}
	
	if(pickedUsers.length == 0)
	{
		alertBox(language["alert"], language["notPicked"], 300);
		return;
	}
	
	
	var container = document.getElementById("pssRecBox");
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
	option.innerHTML = "Selecciona un curso";
	input1.appendChild(option);

	var list = actualProductsList;
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.TYPE == "c")
		{
			var option = document.createElement("option");
			option.value = item.CODE;
			option.innerHTML = item.PNAME;
			input1.appendChild(option);
		}
	}

	var send = document.createElement("div");
	send.className = "dualButton";
	send.data = reg;
	send.innerHTML = language["accept"];
	send.onclick = function()
	{
		

		var info = {};
		info.users = pickedUsers;
		info.course = $("#input1").val();
		
		// CHECK PICKED COURSE
		if(info.course == "")
		{
			alertBox(language["alert"], language["mustCourse"],300);
			return;
		}
		
		sendAjax("users","activateCourse",info,function(response)
		{
			var ans = response.message;
			hide_pop_form();
			alertBox(language["alert"], language["activatedCourses"], 300);
			uListRefresh();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButton";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input1);
	container.appendChild(send);
	container.appendChild(cancel);

	var title = "Activación de curso como obsequio";
	formBox("pssRecBox",title,300);
}
function activeCourses()
{
	
	
	
	
}

// APP CORE END
// ------------------- DELETE --------------------
























function checkStart()
{
        var d = window.location.href;
        
        var t = d.split("?");
		if(t.length > 1){var a = t[1];ifLoad('ifPassRec');pssReCode = a.split("key=")[1];pssReCode = pssReCode.split("&")[0];history.pushState({}, null, "http://incocrea.com/gold/");return true;}
			return false
        
}
function respMenu() 
{
        document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
function getDV(field)
{
	var nit = field.value;
	
	if(nit != "")
	{
		var dv =calcularDigitoVerificacion(nit);
		
		document.getElementById("a-providerContact").value = dv;
		document.getElementById("a-providerRut").value = nit+"-"+dv;
		
	}
	else
	{
		document.getElementById("a-providerContact").value = "";
		document.getElementById("a-providerRut").value = "";
		
	}
}
function  calcularDigitoVerificacion ( myNit )  
{
	var vpri,
	x,
	y,
	z;

	// Se limpia el Nit
	myNit = myNit.replace ( /\s/g, "" ) ; // Espacios
	myNit = myNit.replace ( /,/g,  "" ) ; // Comas
	myNit = myNit.replace ( /\./g, "" ) ; // Puntos
	myNit = myNit.replace ( /-/g,  "" ) ; // Guiones

	// Se valida el nit
	if  ( isNaN ( myNit ) )  {
	console.log ("El nit/cédula '" + myNit + "' no es válido(a).") ;
	return "" ;
	};

	// Procedimiento
	vpri = new Array(16) ; 
	z = myNit.length ;

	vpri[1]  =  3 ;
	vpri[2]  =  7 ;
	vpri[3]  = 13 ; 
	vpri[4]  = 17 ;
	vpri[5]  = 19 ;
	vpri[6]  = 23 ;
	vpri[7]  = 29 ;
	vpri[8]  = 37 ;
	vpri[9]  = 41 ;
	vpri[10] = 43 ;
	vpri[11] = 47 ;  
	vpri[12] = 53 ;  
	vpri[13] = 59 ; 
	vpri[14] = 67 ; 
	vpri[15] = 71 ;

	x = 0 ;
	y = 0 ;
	for  ( var i = 0; i < z; i++ )  { 
	y = ( myNit.substr (i, 1 ) ) ;
	// console.log ( y + "x" + vpri[z-i] + ":" ) ;

	x += ( y * vpri [z-i] ) ;
	// console.log ( x ) ;    
	}

	y = x % 11 ;
	// console.log ( y ) ;

	return ( y > 1 ) ? 11 - y : y ;
}


// SAVERS
function providerSave(item)
{
        var  info = infoHarvest(a_provider_targets);

        if(item.innerHTML == "Crear"){info.saveType = "c";}
        if(item.innerHTML == "Guardar"){info.saveType = "e";}
		
		console.log(info.saveType)
        
        info.utype = "P";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "PV";
        info.target = info["a-providerName"];
        
        if(info["a-providerName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir los nombres del proveedor",300); return}
		if(info["a-providerLastName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir los apellidos del proveedor",300); return}
        else if(info["a-providerNIT"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un NIT o ID",300); return}
		 else if(info["a-providerContact"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un digito de verificación",300); return}
        else if(info["a-providerLocation"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el departamento y municipio del proveedor",300); return}
        else if(info["a-providerAddress"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una dirección",300); return}
        else if(info["a-providerPhone"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un teléfono",300); return}
        else if(info["a-providerEmail"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un Email",300); return}
		else if(info["a-providerRut"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un RUT",300); return}
		else if(info["a-providerCiiu"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un CIIU",300); return}
		else if(info["a-providerPIN"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un PIN",300); return}
		else if(info["a-budgetEnddate"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar la fecha de vencimiento del PIN",300); return}
	
		console.log(info)
		
        if(info.saveType == "c")
        {

                sendAjax("users","providerSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys002"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_provider_targets, "a-provider");
                                providerGet();
                        }
                });
        }
        else
        {
				info.ccode = actualProviderCode;
				
				console.log(actualProviderCode)
                
                sendAjax("users","providerSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_provider_targets, "a-provider");
                        providerSaveButton.innerHTML = "Crear";
                        providerGet();
                });
        }
}
function budgetSave(item)
{
        var  info = {};

        info.date = getNow();
		info.pdata = actualClientInfo;
		info.qty = document.getElementById("a-budgetcQty").value;

        if(info["a-budgetcName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una identificación de cliente",300); return}
		if(info.qty == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una cantidad en gramos.",300); return}
		if(info.pdata == "ne"){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La identificación de cliente no existe.",300); return}
		if(pindepleted == 1){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Este vendedor tiene vencido el PIN, no se puede realizar la compra.",300); return}
		if(parseFloat(info.qty) > avbuy){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La cantidad a comprar hace que se exceda el limite mensual.",300); return}
		
		
		sendAjax("users","budgetSave",info,function(response)
		{
				var ans = response.message;
				console.log(ans);
				
				document.getElementById("a-budgetcName").value = "";
				document.getElementById("a-budgetcQty").value = "";
				
				var name = document.getElementById("opName");
				var pin = document.getElementById("opPin");
				var pinState = document.getElementById("opPinState");
				var thisSaled = document.getElementById("thisSaled");
				var thisAvalilable = document.getElementById("thisAvalilable");
				
				name.innerHTML = "-";
				pin.innerHTML = "-";
				pinState.innerHTML = "-";
				thisSaled.innerHTML = "-";
				thisAvalilable.innerHTML = "-";
				
				
				actualClientInfo = "ne";
				
				budgetGet();
				
				generatePdf("0",ans.code,ans.num);
				
		});

}
function pritemSave(item)
{
        var  info = {};

        info.date = getNow();
		info.prcId = document.getElementById("prcId").value;
		info.prcName = document.getElementById("prcName").value;
		info.prcDet = document.getElementById("prcDet").value;
		info.prQty = document.getElementById("prQty").value;
		info.endDate = getNow(4);
		
		if(document.getElementById("prCustomDate").value != "")
		{
			 info.date = document.getElementById("prCustomDate").value;
			 
			 info.endDate = getNowCustom(info.date, 4);
		}
		

        if(info["prcId"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una identificación de cliente",300); return}
		if(info["prcName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de cliente",300); return}
		if(info["prcDet"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un detalle de la prenda",300); return}
		if(info.prQty == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el valor de empeño.",300); return}

		
		sendAjax("users","pritemSave",info,function(response)
		{
				var ans = response.message;
				console.log(ans);
				
				document.getElementById("prcId").value = "";
				document.getElementById("prcName").value = "";
				document.getElementById("prcDet").value = "";
				document.getElementById("prQty").value = "";
				document.getElementById("prCustomDate").value = "";

				pritemGet();
				generatePdfPR("0",ans.code,ans.num);
				
		});

}
function checkPpay()
{
	var ppayval = document.getElementById("ppayField").value;
	
	if  ( isNaN ( ppayval ) ) 
	{
		alertBox("Información", language["nanppay"], 300);
		document.getElementById("ppayField").value = "";
		return;
	}
	
	if(ppayval < 1)
	{
		alertBox("Información", language["mustppay"], 300);
		return;
	}
	
	var param = [];
	
	confirmBox(language["confirm"], language["checkPpay"]+addCommas(ppayval)+" al recibo "+actualPpayNum+"?", addPpaysend, 300, param);
}
function checkClaim()
{
	var param = [];
	confirmBox(language["confirm"], language["checkclaim"]+actualClaimNum+"?", claimPrsend, 300, param);
}
function addPpaysend()
{

	var ppayval = document.getElementById("ppayField").value;

	var ppay = {};
	ppay.DATE = getNow();
	ppay.VALUE = ppayval;

	actualPpayList.push(ppay);
	console.log(actualPpayList)
	
	var info = {};
	info.code = actualPpayCode;
	info.ppay = JSON.stringify(actualPpayList);
	info.ppayval = ppayval;
	info.ppayDate = getNow();
	
	
	sendAjax("users","setPpay",info,function(response)
	{
		var ans = response.message;
		console.log()
		hide_pop_form();
		pritemGet();
		document.getElementById("ppayField").value = "";
		
		var url = "prendrec/"+ans.NUM+"-Abono.pdf";
		openInNewTab(url);
		
	});

}
function claimPrsend()
{

	var info = {};
	info.code = actualClaimCode;
	info.date = getNow();
	
	sendAjax("users","claimPr",info,function(response)
	{
		var ans = response.message;
		hide_pop_form();
		pritemGet();
	
	});

}
function refreshPpayList()
{
	var container = document.getElementById("ppayListBox");
	container.innerHTML = "";
	
	for(var i=0; i<actualPpayList.length; i++)
	{
		var reg = actualPpayList[i];
		var ppayLine = document.createElement("div");
		ppayLine.className = "ppayLine";
		var ppayLineDate = document.createElement("div");
		ppayLineDate.className = "ppayLineDate";
		var ppayLineVal = document.createElement("div");
		ppayLineVal.className = "ppayLineVal";
		
		ppayLineDate.innerHTML = reg.DATE;
		ppayLineVal.innerHTML = addCommas(reg.VALUE);
		
		
		ppayLine.appendChild(ppayLineDate);
		ppayLine.appendChild(ppayLineVal);
		
		container.appendChild(ppayLine)
		
	}
}
function refreshPpayListRep()
{
	var container = document.getElementById("ppayListBoxRep");
	container.innerHTML = "";
	
	for(var i=0; i<actualPpayList.length; i++)
	{
		var reg = actualPpayList[i];
		var ppayLine = document.createElement("div");
		ppayLine.className = "ppayLine";
		var ppayLineDate = document.createElement("div");
		ppayLineDate.className = "ppayLineDate";
		var ppayLineVal = document.createElement("div");
		ppayLineVal.className = "ppayLineVal";
		
		ppayLineDate.innerHTML = reg.DATE;
		ppayLineVal.innerHTML = addCommas(reg.VALUE);
		
		
		ppayLine.appendChild(ppayLineDate);
		ppayLine.appendChild(ppayLineVal);
		
		container.appendChild(ppayLine)
		
	}
}
function clearprfilter()
{
	document.getElementById("f-prcName").value = "";
	document.getElementById("f-prNumber").value = "";
	
	pritemGet();
	
}
function oprecover(info)
{
	sendAjax("users","oprecover",info,function(response)
	{
		var ans = response.message;
		budgetGet();
		
	});
}
function proprecover(info)
{
	sendAjax("users","proprecover",info,function(response)
	{
		var ans = response.message;
		pritemGet();
		
	});
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
function picellCreator(name, content)
{
        var cell = document.createElement("div");
        cell.className = "column";
        cell.setAttribute('data-label',name);
        cell.appendChild(content);
        return cell;
}
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
function setIFAutoFields(table, list)
{
        if(table == "budgetTable")
        {
                var extractFields = ["NIT"];
                var arrays = extractArrays(extractFields, plist);

                setAutoField("a-budgetcName", arrays.NIT);
                setAutoField("f-budgetcName", arrays.NIT);
        }
        else if(table == "providerTable")
        {
                var extractFields = ["NAME", "RESPNAME", "NIT", "LOCATION", "ADDRESS"];
                var arrays = extractArrays(extractFields, list);
                
                setAutoField("a-providerName", arrays.NAME);
                setAutoField("f-providerName", arrays.NAME);
                setAutoField("a-providerContact", arrays.RESPNAME);
                setAutoField("f-providerID", arrays.NIT);
                // setAutoField("f-providerLocation", arrays.LOCATION);
                setAutoField("a-providerLocation", arrays.LOCATION);
                setAutoField("a-providerAddress", arrays.ADDRESS);
        }
		else if(table == "itemsTable")
        {
                var extractFields = ["CNIT", "CNAME"];
                var arrays = extractArrays(extractFields, ilist);

                setAutoField("prcId", arrays.CNIT);
                setAutoField("f-prcName", arrays.CNIT);
        }

}
function extractArrays(fields, list)
{
        var items = {};
        
        for(var i=0; i<fields.length; i++)
        {
                var field = fields[i];
                
                var array = [];
                
                for(var j=0; j<list.length; j++)
                {
                        var value = list[j][field]
                        
                        if(!array.in_array(value))
                        {
                                array.push(value);
                        }
                }

                items[field] = array;

        }

        return items;
        
}
function setAutoField(field, values)
{
        $( function() {$( "#"+field ).autocomplete({source: values});});
}
function ordeGet()
{
        var info = {};
        var  info = infoHarvest(f_orde_targets);
        info.techcode = "";
        sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
		tableCreator("codesList", ans);
	});
}
function orderSave(item)
{
	var  info = infoHarvest(a_orde_targets);
	
	if(item.innerHTML == "Crear"){info.saveType = "c";}
	if(item.innerHTML == "Guardar"){info.saveType = "e";}
	
	info.utype = "O";
	info.autor = aud.RESPNAME;
	info.date = getNow();
	info.type = "O";
   
			
	info["a-orderMaquis"] = JSON.stringify(actualMaquiPicks);
	
	info["a-orderParentName"] = $("#a-orderParent option:selected").text();
	info["a-orderSucuName"] = $("#a-orderSucu option:selected").text();
	
	info.target = info["a-orderParentName"];

	if(info["a-orderParent"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente",300); return}
	else if(info["a-orderSucu"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una sucursal",300); return}
	else if(info["a-orderDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un detalle para la orden de trabajo",300); return}
	else if(info["a-orderPriority"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una prioridad",300); return}
   
	
	if(info.saveType == "c")
	{

		sendAjax("users","orderSave",info,function(response)
		{
			var ans = response.message;
			
			if(ans == "exist")
			{
				alertBox(language["alert"], language["sys002"],300);
			}
			else
			{
				alertBox(language["alert"], language["sys003"],300);
				clearFields(a_orde_targets, "a-orde");
				ordeGet();
			}
		});
	}
	else
	{

		info.ocode = actualOrderCode;
		info.ostate = actualOrderState;
		
		sendAjax("users","orderSave",info,function(response)
		{
				var ans = response.message;

				alertBox(language["alert"], language["sys004"],300);
				clearFields(a_orde_targets, "a-orde");
				orderSaveButton.innerHTML = "Crear";
				ordeGet();
		});
	}
}
function productSave(item)
{
        var  info = infoHarvest(a_product_targets);

        if(item.innerHTML == "Crear"){info.saveType = "c";}
        if(item.innerHTML == "Guardar"){info.saveType = "e";}
        
        info.utype = "P";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "PD";
        info.target = info["a-productName"];
        
        if(info["a-productName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de producto",300); return}
        else if(info["a-productDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una descripción de producto",300); return}
        else if(info["a-productType"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un tipo de producto",300); return}
        else if(info["a-productBrand"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir la marca del producto",300); return}
        else if(info["a-productPrice"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el precio de venta",300); return}
        else if(actualProviders.length == 0){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar por lo menos un proveedor para el producto",300); return}


        info.providers = JSON.stringify(actualProviders);
        
        var providerNames = [];
        
        for(var i=0; i<actualProviders.length; i++)
        {
                var code = actualProviders[i];
                for(var j=0; j<providerList.length; j++)
                {
                        if(code == providerList[j].CODE)
                        {
                                var providerName = providerList[j].NAME;
                        }
                }
                providerNames.push(providerName);
        }
        
        info.providerNames = JSON.stringify(providerNames);
        
        // return
        if(info.saveType == "c")
        {

                sendAjax("users","productSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys002"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_product_targets, "a-product");
                                productGet();
                        }
                });
        }
        else
        {
                 info.ccode = actualProductCode;
                
                sendAjax("users","productSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_product_targets, "a-product");
                        productSaveButton.innerHTML = "Crear";
                        productGet();
                });
        }
}
function itemSave(type, targets, method, code)
{
        var info = infoHarvest(targets);
        info.autor = aud.RESPNAME;
        info.date = getNow();
        // code = "941f9a9a08e1551df0b9505a70ceac33";
        info.code = code;

        if(code == "")
        {
                info.saveType = "c"
        }
        else
        {       
                info.saveType = "e"
        }

        if(type == "item")
        {
                info.utype = "I";
                info.type = type;
                info.link = actualLink;
                var reloader = bItemGet;
                var targets = a_item_targets;
                info.target = info["a-bItemName"];
                var fields = ["a-bItemName", "a-bItemQty", "a-bItemUnit", "a-bItemCost"];
                var alerts = ["escribir un nombre de producto", "escribir una cantidad de producto", "escribir la unidad de producto", "escribir el costo del producto"];
                info.bcode = budgetData[0].CODE;
        }
        
        if(!fillChecker(fields, alerts)){return} ;

        sendAjax("users",method,info,function(response)
        {       
                var ans = response.message;

                reloader();
                clearFields(targets);
                actualSaveCode = "";

        });
}
function sendMessage()
{
        var info = {};
        
        info.ucode = aud.CODE;
        info.uname = aud.NAME;
        info.utype = aud.TYPE;
        info.date = getNow();
        info.content = document.getElementById("comentContentbox").value;
        info.bcode = actualBudgetCode;
        
        
        if(info.content == "")
        {
                alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un mensaje",300);
                return false;
        }
        
        
        sendAjax("users","sendMessage",info,function(response)
        {
                var ans = response.message;
                document.getElementById("comentContentbox").value = "";
                messagesRefhesher(ans);
        });

}
// LISTERS
function providerGet(sorter)
{
        var info = {};
        var info = infoHarvest(f_provider_targets);
        if(sorter !=  null)
        {
                if(sorter == "nombre"){sorter = "NAME"}
                if(sorter == "encargado"){sorter = "RESPNAME"}
                if(sorter == "nit"){sorter = "NIT"}
                if(sorter == "address"){sorter = "ADDRESS"}
                if(sorter == "phone"){sorter = "PHONE"}
                if(sorter == "email"){sorter = "MAIL"}
                if(sorter == "location"){sorter = "LOCATION"}

                info.index = sorter;
        }
        else{info.index = ""}
        
        sendAjax("users","getProviderList",info,function(response)
	{
		var ans = response.message;
                providerList = ans;

                tableCreator("providerTable", ans);
	});
}
function budgetGet(sorter)
{
		var info = {};
		var info = infoHarvest(f_budget_targets);
		info.index = "";
        
        sendAjax("users","getBudgetList", info,function(response)
	{
		var ans = response.message;
		budgetList = ans;
		plist = response.plist;
		
		tableCreator("budgetTable", ans);
	});
}
function pritemGet(sorter)
{
	var info = {};
	info.cname = document.getElementById("f-prcName").value;
	info.num = document.getElementById("f-prNumber").value;

	info.index = "";
        
	sendAjax("users","getPrList", info,function(response)
	{
		var ans = response.message;
		
		prList = ans;
		ilist = response.ilist;
		
		tableCreator("itemsTable", ans);
	});
}
function budgetStarter()
{
        sendAjax("users","budgetStarter","",function(response)
        {
                var ans = response.message;

                plist = ans.plist;
                budgetList = ans.budgetList;
				tableCreator("budgetTable", budgetList);
        });
}
function generatePdf(type, code, num)
{
        var info = {};
        info.code = code;
        info.type = type;
        info.num = num;

        sendAjax("users","pdfGenerate",info,function(response)
        {
			var ans = response.message;
			var code = ans.CODE;
			var num = ans.NUM;
			var type = "Recibo";

			var url = "pdocs/"+code+"/"+type+" "+info.num+".pdf";

			// downloadFile(url);
			openInNewTab(url);

        });
        
}
function generatePdfPR(type, code, num)
{
        var info = {};
        info.code = code;
        info.type = type;
        info.num = num;

        sendAjax("users","pdfGeneratePR",info,function(response)
        {
			var ans = response.message;
			var code = ans.CODE;
			var num = ans.NUM;
			var type = "Recibo";
			
			console.log("test")

			var url = "prendrec/"+info.num+".pdf";

			// downloadFile(url);
			openInNewTab(url);

        });
        
}
function openInNewTab(url) 
{
  var win = window.open(url, '_blank');
  win.focus();
}
function regEditer(table, reg)
{
        if(table == "budgetTable")
        {
                var info = reg;

                actualBudgetCode = reg.CODE;
                actualClientCode = reg.CCODE;
                actualConds = reg.CONDS;
                editMode = 1;
                
                var items = [decry(info.CNAME), decry(info.CADDRESS), decry(info.CLOCATION), decry(info.CEMAIL),  info.DATE, info.ENDDATE, info.CURRENCY];
                infoFiller(items, a_budget_targets);

                budgetSaveButton = document.getElementById("budgetSaveButton");
                budgetSaveButton.innerHTML = "Guardar";  
        }
        
}

// FAST FIELD UPDATERS
function clientFupdater(item)
{
        var value = item.value;
        var clist = extractArrays(["NIT"], plist);
		
		var name = document.getElementById("opName");
		var pin = document.getElementById("opPin");
		var pinState = document.getElementById("opPinState");
		var thisSaled = document.getElementById("thisSaled");
		var thisAvalilable = document.getElementById("thisAvalilable");
		var ps = "-";
		
		pindepleted = 0;
		

        if(clist.NIT.in_array(value))
        {

                for(var i=0; i<plist.length; i++)
                {
                        if(value == plist[i].NIT)
                        {
                                var reg = plist[i];
                        }
                        
                }
				
				var vd = reg.PDATE;
                var saled = 0;
				
				if(getNow() > vd)
				{
					ps = "Vencido";
					pindepleted = 1;
				}
				else
				{
					ps = "Activo";
					pindepleted = 0;
				}
				
				var fd = getFirstday();
				
				total = 0;
				
				for(var i=0; i<budgetList.length; i++)
				{
					var myn = reg.NIT;
					
					if(budgetList[i].CNIT == myn)
					{
						if(budgetList[i].STATE == "1" && budgetList[i].DATE > fd)
						{
							total = total + parseFloat(budgetList[i].QTY);
						}
					}
					
				}
				
				avbuy = (35-total).toFixed(2);

				name.innerHTML = reg.NAME;
				pin.innerHTML = reg.PIN;
				pinState.innerHTML = ps;
				thisSaled.innerHTML = total.toFixed(2);
				thisAvalilable.innerHTML = avbuy;
				
                clientExists = 1;
				
				actualClientInfo = reg;

        }
        else
        {       
                actualClientInfo = "ne";

				name.innerHTML = "-";
				pin.innerHTML = "-";
				pinState.innerHTML = ps;
				thisSaled.innerHTML = "-";
				thisAvalilable.innerHTML = "-";
                clientExists = 0;

        }
}
// FAST FIELD PREND
function prFupdater(item)
{
        var value = item.value;
		
		
		
		
        var clist = extractArrays(["CNIT", "CNAME"], ilist);
		console.log(clist);
		
		var name = document.getElementById("prcName");

        if(clist.CNIT.in_array(value))
        {

                for(var i=0; i<ilist.length; i++)
                {
                        if(value == ilist[i].CNIT)
                        {
                                var reg = ilist[i];
                        }
                        
                }

				name.value = reg.CNAME;

        }
        else
        {       
                name.value = "";

        }
}
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
	recMailBox.placeholder = "Digite el Código";
	
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

	formBox("pssRecBox","Verificar Código",300);
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
function getNow(extra)
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
	
	return datetime;
}
function getNowSimple(extra)
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
	
	var datetime =  year + "-" +  month + "-" + day;	
	
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

	 var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
	 var info = {};
	 info.class = obj;
	 info.method = method;
	 info.data = data;
		
	
	// UNCOMMENT FOR ENCRYPT
	 // $.ajax({
		// type: 'POST',
		// url: 'libs/php/mentry.php',
		// contentType: 'application/json',
		// data: CryptoJS.AES.encrypt(JSON.stringify(info), k, {format: CryptoJSAesJson}).toString(),
		// cache: false,
		// success: function(data){

			 // try
			 // {
				// var tmpJson = $.parseJSON(CryptoJS.AES.decrypt(data, k, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
				// responseFunction(tmpJson.data);
				// $("#loaderDiv").fadeOut();
				// showLoader = 0;
			 // }
			 // catch(e)
			 // {
				 // console.log(data)
				 // $("#loaderDiv").fadeOut();
				 // showLoader = 0;
			 // }
			 
		// },
		// error: function( jqXhr, textStatus, errorThrown ){ 
			// $("#loaderDiv").fadeOut();
			// console.log(errorThrown)
		// }

	// });
	
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