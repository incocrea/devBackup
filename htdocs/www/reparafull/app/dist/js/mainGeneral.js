// APP START START
$(document).ready( function()
{
	if(!localStorage.getItem("lup")){localStorage.setItem("lup", "v0.0");}
	loadCheck();
	
});
function loadCheck()
{
	comcount = 0;
	tail = "?r="+Math.random();
	liveRefresh();
	langPickIni();
	actualIf = "home";
	theCroppie = null;
	loadProps = 0;
	
	backPopConfig();
	if(imfoo == "products" || imfoo == "checkout" || imfoo == "cart"){}
	if(imfoo != "recover")
	{
		infoIcon = "<img src='img/logo.png"+tail+"' class='infoIcon'/><br>";
	}
	else
	{
		infoIcon = "<img src='images/logo0.jpg"+tail+"' class='infoIcon'/><br>";
	}
	checkPassRecPop();

	// ENTER LOGINFIELDS
	if(document.getElementById("InputUsername"))
	{
		document.getElementById("InputUsername").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){login();}});
	}
	if(document.getElementById("InputPassword"))
	{
		document.getElementById("InputPassword").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){login();}});
	}
	if(document.getElementById("searchTop"))
	{
		document.getElementById("searchTop").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){filterWorks();}});
	}
	if(document.getElementById("mobileSearch"))
	{
		document.getElementById("mobileSearch").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){filterWorks();}});
	}
	
}
function checkPassRecPop()
{
	var furl = window.location.href;
	if(furl.split("me=").length > 1)
	{
		
		var m1 = furl.split("me")[1];
		var mail = m1.split("&tmpkey=")[0];
		actualRecoverMail = mail;
		actualRecoverKey = m1.split("&tmpkey=")[1];
		showModal("pssSetModal");
	}
}
function setPass()
{
	var info = {};
	info.code = actualRecoverKey;
	
	var p1 = document.getElementById("newPass1").value
	var p2 = document.getElementById("newPass2").value
	
	if(p1 == "")
	{
		alertBox(language["alert"], infoIcon+language["mustPassChange"], 300);
		return;
	}
	if(p1 != p2)
	{
		alertBox(language["alert"], infoIcon+language["passMatch"], 300);
		return;
	}
	
	info.pass = p1;
	
	console.log(info);
	
	
	sendAjax("users","setPass",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		document.getElementById("newPass1").value
		document.getElementById("newPass2").value
		hideModal("pssSetModal");
		
		alertBox(language["alert"], infoIcon+language["passSet"], 300);
		ifLoad("login-if");
		
	});
	
	
}
function backPopConfig()
{
	if (window.history && window.history.pushState)
	{
		$(window).on('popstate', function () {
			if (!window.userInteractionInHTMLArea) 
			{
				hideModal("QuickViewModal");
				hideModal("alertsBox");
			}
		if(window.onBrowserHistoryButtonClicked ){
		window.onBrowserHistoryButtonClicked ();
			}
		});
	}

	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
	history.pushState("", "empty", "");
}
function langPickIni()
{
	actualScode = "1";
	if (!localStorage.getItem(actualScode+"-language")) 
	{
		lang = "es_co"; 
		langGetIni(lang);
		localStorage.setItem(actualScode+"-language", lang);
	}
	else
	{
		lang = localStorage.getItem(actualScode+"-language");
		langGetIni(lang);
	}
}
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	
	if(imfoo == "recover")
	{
		imported.src = 'dist/js/live.js';
	}
	else
	{
		imported.src = 'dist/js/live.js';
	}

	if(loc.includes("192"))
	{
		document.head.appendChild(imported);
	}
}
function langGetIni(l) 
{
	var info ={};
	info.lang = l;

	if(imfoo == "home")
	{
		info.count = "1";
	}
	else
	{
		info.count = "0";
	}
	sendAjax("users","langGet",info,function(response)
	{
		language = response.message.lang;
		localStorage.setItem(actualScode+"-lang", JSON.stringify(language));
		vcount = response.message.visits;
		cats = response.message.cats;
		
		var lastUp = localStorage.getItem("lup");
		var newUp = language["lup"];
		
		if(lastUp != newUp)
		{
			cacheRefresh();
			return;
		}
		setLang();
	});
}
function setLang()
{
	for (var text in language)
	{
		if(document.getElementById(text))
		{
			var element = document.getElementById(text);
			element.innerHTML = language[text];

			if(element.type == "text" || element.type == "password"){element.placeholder = language[text];}
			if(element.type == "textarea" || element.type == "password"){element.innerHTML = "";element.placeholder = language[text];}
		}
	}
	
	checkLogin();
	
	setLocations("4");
	setLocations("5");
}
function login()
{
	var email = document.getElementById("loginUsername").value;
	var pssw = document.getElementById("loginPassword").value;
	var info = {};
	info.autor = email;
	info.pssw = pssw;
	info.type = "0";
	sendAjax("users","login",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(ans == "Disabled")
		{
			alertBox(language["alert"], infoIcon+language["disabledUser"]);
			return;
		}
		
		
		if(ans == ""){alertBox(language["alert"], infoIcon+language["wrongPass"]);}
		else
		{
			userData = ans;
			localStorage.setItem("auc", userData.UCODE);
			goSite("home");
		}
		
	});
}
function checkLogin()
{
	if (window.localStorage.getItem("auc")) 
	{
		var c = localStorage.getItem("auc");
		var info = {};
		info.c = c;
		info.type = "0";
		var method = "rlAud";
		sendAjax("users",method,info,function(response)
		{
			var ans = response.message;
			
			if(ans == "Disabled")
			{
				logout();
				return;
			}
			
			if(response.message == "ne")
			{
				userData = "";
				starter("0");
			}
			else
			{
				userData = response.message;
				starter("1");
			}
			prepareImgCropper();
		});
	}
	else
	{
		userData = "";
		starter("0");
	}
}
function starter(mode)
{
	if(document.getElementById("coverLoad")){document.getElementById("coverLoad").style.display = "none";}
	if($(window).width() < 600){closeOffsetMenu(0);}
	directLoadCheck();
	setLoged(mode);
}
function directLoadCheck(code)
{
	var furl = window.location.href;
	
	if(localStorage.getItem("actualFtype")){actualFtype = localStorage.getItem("actualFtype");}
	else{actualFtype = "1";}

	// LOAD DIRECT WORK
	if(furl.split("direct=").length > 1)
	{var code = furl.split("direct=")[1];setTimeout(function(){loadWork(code);},400);}
	// LOAD MODE
	var t = furl.split("?");
	if(t.length > 1){if(t[1] == "publica"){ actualFtype = 1; setTimeout(function(){createWork();},400);}}
	if(t.length > 1){if(t[1] == "repara"){actualFtype = 1;}}
	if(t.length > 1){if(t[1] == "busca"){actualFtype = 3;}}
	if(t.length > 1){if(t[1] == "comercia"){actualFtype = 2;}}
}
function setLoged(mode)
{
	var myJobsMenu = document.getElementById("myJobsMenu");
	var myPartsMenu = document.getElementById("myPartsMenu");
	var myProfileMenu = document.getElementById("myProfileMenu");
	var mypProfileMenu = document.getElementById("mypProfileMenu");
	var myCfgMenu = document.getElementById("myCfgMenu");
	var myCloseMenu = document.getElementById("myCloseMenu");
	var myLoginMenu = document.getElementById("myLoginMenu");
	var myLogOutMenu = document.getElementById("myLogOutMenu");
	var myLoginMenuTop = document.getElementById("myLoginMenuTop");
	
	if(mode == "1")
	{
		myJobsMenu.style.display = "block";
		myPartsMenu.style.display = "block";
		myProfileMenu.style.display = "block";
		mypProfileMenu.style.display = "block";
		myCloseMenu.style.display = "block";
		myLogOutMenu.style.display = "block";
		myLoginMenu.style.display = "none";
		myLoginMenuTop.style.display = "none";
		myCfgMenu.style.display = "none";
		myCloseMenu.onclick = function(){logout();}
		if(userData.logued == "2"){myCfgMenu.style.display = "block";}
		
		if(userData.LASTFILTER != "" && userData.CATS != null)
		{
			var lastFilter = JSON.parse(userData.LASTFILTER);
			
			// mainCatsPicked = lastFilter.main;
			// subCatsPicked = lastFilter.sub;
			
			document.getElementById("locPicker").value = lastFilter.loc;
			document.getElementById("locPickerTop").value = lastFilter.loc;
			document.getElementById("searchTop").value = lastFilter.search;
			document.getElementById("mobileSearch").value = lastFilter.search;
		}
		else
		{
			mainCatsPicked = [];
			subCatsPicked = [];
		}
		
		
		if(userData.CATS != "" && userData.CATS != null)
		{
			var userCats = JSON.parse(userData.CATS);

			mainCatsPickedPro = userCats.main;
			subCatsPickedPro = userCats.sub;
			
			// SET USER CATS AS FILTER--------
			mainCatsPicked = userCats.main;
			subCatsPicked = userCats.sub;
			// SET USER CATS AS FILTER--------
		}
		else
		{
			mainCatsPickedPro =[];
			subCatsPickedPro = [];
		}
		actualProCats = {};
		actualProCats.main = mainCatsPickedPro;
		actualProCats.sub = subCatsPickedPro;
		// DELETE FOR MAIN LOAD
		
		if(localStorage.getItem("newGuy"))
		{
			if(localStorage.getItem("newGuy") == "1")
			{
				console.log("postregister question")
				showModal("postregisterModal");
				localStorage.setItem("newGuy","0")
			}
		}
		
		// IGNORE SAVED FILTERS
		// IGNORE SAVED FILTERS
		// IGNORE SAVED FILTERS
		
		mainCatsPicked = [];
		subCatsPicked = [];
		
		mainCatsPickedPro =[];
		subCatsPickedPro = [];
		
		document.getElementById("locPicker").value = "";
		document.getElementById("locPickerTop").value = "";
		document.getElementById("searchTop").value = "";
		document.getElementById("mobileSearch").value = "";
		
		// IGNORE SAVED FILTERS
		// IGNORE SAVED FILTERS
		// IGNORE SAVED FILTERS
	}
	else
	{
		myCloseMenu.style.display = "none";
		myJobsMenu.style.display = "none";
		myPartsMenu.style.display = "none";
		myProfileMenu.style.display = "none";
		mypProfileMenu.style.display = "none";
		myCfgMenu.style.display = "none";
		myLogOutMenu.style.display = "none";
		myLoginMenu.style.display = "block";
		myLoginMenuTop.style.display = "block";
		
		if(localStorage.getItem("lastFilter"))
		{
			var lastFilter = JSON.parse(localStorage.getItem("lastFilter"));
			mainCatsPicked = lastFilter.main;
			subCatsPicked = lastFilter.sub;
			document.getElementById("locPicker").value = lastFilter.loc;
			document.getElementById("locPickerTop").value = lastFilter.loc;
			document.getElementById("searchTop").value = lastFilter.search;
			document.getElementById("mobileSearch").value = lastFilter.search;
		}
		else
		{
			mainCatsPicked = [];
			subCatsPicked = [];
		}
	}
	
	catBuilder(cats);
	// TURN TO 0 FOR DEVELOP ELSE MUST 1
	doSearch = 0;
	// TURN TO 0 FOR DEVELOP ELSE MUST 1
	buildFilter();

	setFilter(actualFtype);
	
}
function postOption(pick)
{
	if(pick == "1")
	{
		console.log("Go profile")
		loadProfile(2);
		hideModal("postregisterModal");
	}
	else
	{
		createWork('1')
		hideModal("postregisterModal");
		console.log("Go post")
	}
}
function logout()
{
	userData = "";
	localStorage.removeItem("auc");
	goSite("home");
}
function checkEmail(email) 
{

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email)) 
	{
		return false;
	}
	else
	{
		return true;
	}
 }
function openContact()
{
	closeOffsetMenu(0);
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
	info.scode = actualScode;

	if(info.name == "" || info.mail == "" || info.message == "")
	{
		alertBox(language["alert"], infoIcon+language["mustFieldsContact"]);
		return;
	}
	
	sendAjax("users","contactSend",info,function(response)
	{
		var ans = response.message;
		alertBox(language["alert"], infoIcon+language["messageSent"]);
		hideModal("contactModal");
	});
}
function closeOffsetMenu(mode)
{
	var sideBar = document.getElementById("main-containerX")
	// console.log(mode)
	if(mode == 0 || mode == 1)
	{
		if(mode == 0)
		{
			if($(window).width() < 600)
			{
				console.log("hide");
				sideBar.className = "container-fluid sidebar-collapse";
				$('body').removeClass('modal-open').find('.sidebar-backdrop').remove()
				
				
			}
		}
		else
		{
			if($(window).width() < 600)
			{
				console.log("show");
				sideBar.className = "container-fluid";
				sideBar.removeClass('sidebar-collapse')
				
			}
		}
		
	}
	else
	{
		if(sideBar.className == "container-fluid")
		{
			if($(window).width() < 600)
			{
				sideBar.className = "container-fluid sidebar-collapse";
				$('body').removeClass('modal-open').find('.sidebar-backdrop').remove()
				
				document.getElementById("main-sidebar").style.display = "none";
				$(document).trigger('sidebar.changed')
				console.log("ordered")
				
			}
		}
		else
		{
			if($(window).width() < 600)
			{
				sideBar.className = "container-fluid";
				$(document).trigger('sidebar.changed')
				document.getElementById("main-sidebar").style.display = "initial";
				$("main-sidebar").show();
				// sideBar.removeClass('sidebar-collapse')
				// body.addClass('modal-open').append('<div class="sidebar-backdrop"></div>')
				// $(document).trigger('sidebar.changed')
			}
		}
	}

	
	
}
// IFLOAD
function ifLoad(iface)
{
	actualIf = iface;

	if(iface == "home")
	{
		console.log("gohome")
		location.replace("index.php");
	}
	else
	{		

		document.getElementById("main-content").innerHTML = "";
		$("#main-content").load("sources/"+iface+".html"+tail, function ()
		{
			actualIf = iface;
			if(iface == "detail-if")
			{
				
				setTimeout(function()
				{
					document.getElementById("rDuration").value = "30";
					document.getElementById("liveBox").style.display = "none";
					
					
					
				},100);
					
			}
			if(iface == "login-if")
			{

				setTimeout(function()
				{
					setLocations("1");
					clearlogin();
					document.getElementById("rEmail").disabled = false;
				},1000);
			}
			if(iface == "profile-if")
			{
				setTimeout(function()
				{
					setLocations("2");
				},1000);
			}
			if(iface == "pprofile-if")
			{
				setTimeout(function()
				{
					document.getElementById("proResume").value = userData.RESUME;
					
					var statusLabel = document.getElementById("profileState");

					var upIdIcon = document.getElementById("upIdIcon");
					var downIdIcon = document.getElementById("downIdIcon");
					
					var upDocIcon1 = document.getElementById("upDocIcon1");
					var downDocIcon1 = document.getElementById("downDocIcon1");
					
					var upDocIcon2 = document.getElementById("upDocIcon2");
					var downDocIcon2 = document.getElementById("downDocIcon2");
					
					var upDocIcon3 = document.getElementById("upDocIcon3");
					var downDocIcon3 = document.getElementById("downDocIcon3");
					
					var savePpButton = document.getElementById("savePpButton");
					
					if(userData.DOCFILE == "1")
					{
						upIdIcon.className = "fa fa-check-circle fa-lg aprobed";
						upIdIcon.onclick = function (){loadFileClick("Doc");}
						downIdIcon.style.display = "inline-block";
					}
					else
					{
						upIdIcon.className = "fa fa-upload fa-lg pending"; 
						upIdIcon.onclick = function (){loadFileClick("Doc");}
						downIdIcon.style.display = "none";
					}
					
					if(userData.SOPFILE1 == "1")
					{
						upDocIcon1.className = "fa fa-check-circle fa-lg aprobed";
						upDocIcon1.onclick = function (){loadFileClick("Sop1");}
						downDocIcon1.style.display = "inline-block";
					}
					else
					{
						upDocIcon1.className = "fa fa-upload fa-lg pending";
						upDocIcon1.onclick = function (){loadFileClick("Sop1");}
						downDocIcon1.style.display = "none";
					}
					
					
					if(userData.SOPFILE2 == "1")
					{
						upDocIcon2.className = "fa fa-check-circle fa-lg aprobed";
						upDocIcon2.onclick = function (){loadFileClick("Sop2");}
						downDocIcon2.style.display = "inline-block";
					}
					else
					{
						upDocIcon2.className = "fa fa-upload fa-lg pending";
						upDocIcon2.onclick = function (){loadFileClick("Sop2");}
						downDocIcon2.style.display = "none";
					}
					
					if(userData.SOPFILE3 == "1")
					{
						upDocIcon3.className = "fa fa-check-circle fa-lg aprobed";
						upDocIcon3.onclick = function (){loadFileClick("Sop3");}
						downDocIcon3.style.display = "inline-block";
					}
					else
					{
						upDocIcon3.className = "fa fa-upload fa-lg pending";
						upDocIcon3.onclick = function (){loadFileClick("Sop3");}
						downDocIcon3.style.display = "none";
					}
					
					
					
					if(userData.PASSED == "1")
					{
						statusLabel.innerHTML = "Perfil profesional aprobado";
						statusLabel.style.color = "#007bff";
						savePpButton.innerHTML = "Guardar cambios";
						upIdIcon.onclick = function ()
						{
							alertBox(language["alert"], infoIcon+language["idApproved"], 300);
						}
					}
					else
					{
						statusLabel.innerHTML = "Pendiente de aprobación";
						statusLabel.style.color = "red";
						savePpButton.innerHTML = "Guardar y solicitar aprobación";
					}
					
					catBuilderPro();
					buildFilterPro();
					
					var fileSelector = document.getElementById("upFileSelector");
					fileSelector.addEventListener('change', handleFile, false);
					
				},100);
			}
			if(iface == "orders-if")
			{
				setTimeout(function()
				{
					getMyWorks("0");
					
					var formTitle = document.getElementById("ifTitle");
					var hi = helpIcon(language["helpText3"]);
					formTitle.appendChild(hi);
					
				},500);
			}
			if(iface == "parts-if")
			{
				setTimeout(function()
				{
					getMyParts("0");
					
					var formTitle = document.getElementById("ifTitle");
					var hi = helpIcon(language["helpText4"]);
					formTitle.appendChild(hi);
				},500);
			}
			if(iface == "postulate-if")
			{
				setTimeout(function()
				{
					// jQuery.datetimepicker.setLocale("es");
					// jQuery('#avaDate').datetimepicker();
					// document.getElementById("avaDate").value = getNow();
					getExecuted();
				},1000);
			}
			if(iface == "admin-if")
			{
				setTimeout(function()
				{
					var cover = document.getElementById("cover");
					cover.style.display = "none";
					
					jQuery.datetimepicker.setLocale("es");
					jQuery('#commDateF').datetimepicker();
					
					listGet("users");
					
					setLocations("6");
					
				},100);
			}
		});
	
	}
}
function tabLoad(type)
{
	if(type == "users")
	{
		document.getElementById("userNameF").value = "";
		document.getElementById("userIdF").value = "";
		listGet("users");
		
	}
	if(type == "jobs")
	{
		document.getElementById("jobsNameF").value = "";
		document.getElementById("jobsModeF").value = "";
		document.getElementById("jobsStateF").value = "";
		document.getElementById("jobsLocationF").value = "";
		listGet("jobs");
	}
	if(type == "parts")
	{
		document.getElementById("partsNameF").value = "";
		document.getElementById("partsModeF").value = "";
		document.getElementById("partsStateF").value = "";
		document.getElementById("partsLocationF").value = "";
		listGet("parts");
	}
	if(type == "comments")
	{
		document.getElementById("commNameF").value = "";
		document.getElementById("commWordF").value = "";
		document.getElementById("commDateF").value = "";
		listGet("comments");
	}
	if(type == "offers")
	{
		document.getElementById("offersNameF").value = "";
		document.getElementById("offersWordF").value = "";
		document.getElementById("offersDateF").value = "";
		document.getElementById("offersStateF").value = "";
		listGet("offers");
	}
	if(type == "cats")
	{
		listGet("cats");
	}
}
function clearFilters(type)
{
	if(type == "users")
	{
		document.getElementById("userNameF").value = "";
		document.getElementById("userIdF").value = "";
		listGet("users");
		
	}
	if(type == "jobs")
	{
		document.getElementById("jobsNameF").value = "";
		document.getElementById("jobsModeF").value = "";
		document.getElementById("jobsStateF").value = "";
		document.getElementById("jobsLocationF").value = "";
		listGet("jobs");
	}
	if(type == "parts")
	{
		document.getElementById("partsNameF").value = "";
		document.getElementById("partsModeF").value = "";
		document.getElementById("partsStateF").value = "";
		document.getElementById("partsLocationF").value = "";
		listGet("jobs");
	}
	if(type == "comments")
	{
		document.getElementById("commNameF").value = "";
		document.getElementById("commWordF").value = "";
		document.getElementById("commDateF").value = "";
		listGet("comments");
	}
	if(type == "offers")
	{
		document.getElementById("offersNameF").value = "";
		document.getElementById("offersWordF").value = "";
		document.getElementById("offersDateF").value = "";
		document.getElementById("offersStateF").value = "";
		listGet("offers");
	}
	
}
function listGet(type)
{
	var info = {};
	info.type = type;
	
	if(type == "users")
	{
		info.name = document.getElementById("userNameF").value;
		info.id = document.getElementById("userIdF").value;
	}
	if(type == "jobs")
	{
		info.name = document.getElementById("jobsNameF").value;
		info.mode = document.getElementById("jobsModeF").value;
		info.state = document.getElementById("jobsStateF").value;
		info.location = document.getElementById("jobsLocationF").value;
	}
	if(type == "parts")
	{
		info.name = document.getElementById("partsNameF").value;
		info.mode = document.getElementById("partsModeF").value;
		info.state = document.getElementById("partsStateF").value;
		info.location = document.getElementById("partsLocationF").value;
	}
	if(type == "comments")
	{
		info.name = document.getElementById("commNameF").value;
		info.key = document.getElementById("commWordF").value;
		info.date = document.getElementById("commDateF").value;
		
		if(info.date != "")
		{	
			info.date = info.date.replace("/", "-");	
			info.date = info.date.replace("/", "-")+":00";	
		}
	}
	if(type == "offers")
	{
		info.name = document.getElementById("offersNameF").value;
		info.key = document.getElementById("offersWordF").value;
		info.date = document.getElementById("offersDateF").value;
		info.state = document.getElementById("offersStateF").value;
		
		if(info.date != "")
		{	
			info.date = info.date.replace("/", "-");	
			info.date = info.date.replace("/", "-")+":00";	
		}
	}
	if(type == "cats"){}
	
	sendAjax("users","listGet",info,function(response)
	{
		var ans = response.message;
		
		if(info.type == "users")
		{tableCreator("usersList", ans);}
		if(info.type == "jobs")
		{tableCreator("worksListA", ans);}
		if(info.type == "parts")
		{tableCreator("partsListA", ans);}
		if(info.type == "comments")
		{tableCreator("commentsList", ans);}
		if(info.type == "offers")
		{tableCreator("offersList", ans);}
		if(info.type == "cats")
		{
			actualCats = ans;
			tableCreator("catsList", ans);
		}

		
	});
	
}
function getExecuted()
{
	var info = {};
	info.code = userData.UCODE;
	sendAjax("users","getExecuted",info,function(response)
	{
		var ans = response.message;
		actualExecuted = ans;
		
		if(actualExecuted < 5)
		{alertBox(language["alert"], infoIcon+language["freeRansomYet"]+(5-actualExecuted), 300);}
		
		document.getElementById("price").value = "10000";
		document.getElementById("price").onblur();
	});
	
}
function clearlogin()
{
	document.getElementById("loginUsername").value = "";
	document.getElementById("loginPassword").value = "";
	
	document.getElementById("rName").value ="";
	document.getElementById("rLastName").value ="";
	document.getElementById("rEmail").value ="";
	document.getElementById("rAddress").value ="";
	document.getElementById("rPhone").value ="";
	document.getElementById("idType").value ="";
	document.getElementById("idNumber").value ="";
	document.getElementById("rPassword1").value ="";
	document.getElementById("rPassword2").value ="";
	document.getElementById("rLocation").value ="";
	document.getElementById("condsCheck").checked = false;
	
	// document.getElementById("loginUsername").value = "hvelez@incocrea.com";
	// document.getElementById("loginPassword").value = "123456";
	
	// document.getElementById("rName").value ="usuario";
	// document.getElementById("rLastName").value ="de pruebas";
	// document.getElementById("rEmail").value ="hvelez@incocrea.com";
	// document.getElementById("rAddress").value ="test house";
	// document.getElementById("rPhone").value ="301451245";
	// document.getElementById("idType").value ="CC";
	// document.getElementById("idNumber").value ="10031785";
	// document.getElementById("rPassword1").value ="123456";
	// document.getElementById("rPassword2").value ="123456";
	// document.getElementById("rLocation").value ="Acacías - Meta";

}
// FILTER CATS
function catBuilder(cats)
{
	var list = cats;
	mainCats = [];
	subCats = [];
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.TYPE == "0"){mainCats.push(item);}
		else{subCats.push(item);}
	}
	
	var catsBox = document.getElementById("cats");
	catsBox.innerHTML = "";
	
	for(var i=0; i<mainCats.length; i++)
	{
		var item = mainCats[i];
		var menu = document.createElement("div");
		menu.className = "list-group-item list-group-item-action sub";
		
		var box = document.createElement("input");
		box.type = "checkbox";
		box.className = "checkboxCat"
		box.code = item.CODE;
		box.subs = getSubs(item.CODE);
		box.onchange = function ()
		{
			doSearch = 1;
			buildFilter();
		}
		
		var label = document.createElement("span");
		label.innerHTML = item.DETAIL;
		label.onclick = function ()
		{
			var box = this.parentNode.children[0];
			if(box.checked){box.checked = false;}
			else{box.checked = true;}
			box.onchange();
		}
		
		if(mainCatsPicked.includes(box.code))
		{
			box.checked = true;
			label.style.color = "#0071c1";
		}
		
		var subItemBox = document.createElement("div");
		subItemBox.className = "subItemBox";
		
		menu.appendChild(box);
		menu.appendChild(label);
		menu.appendChild(subItemBox);
		catsBox.appendChild(menu);
	}
	
	
}
function buildFilter()
{
	var cats = document.getElementById("cats").children;
	mainCatsPicked = [];
	
	for(var i=0; i<cats.length; i++)
	{
		var catLine = cats[i];
		var catBox = catLine.children[0];
		var catLabel = catLine.children[1];
		var subCatsBox = catLine.children[2];;
		if(catBox.checked)
		{
			mainCatsPicked.push(catBox.code);
			catLabel.style.color = "#0071c1";
			
			var subCats = catBox.subs;
			subCatsBox.innerHTML = "";
			
			for(var j=0; j<subCats.length; j++)
			{
				var item = subCats[j];
				var menu = document.createElement("span");
				menu.className = "list-group-item list-group-item-action sub";
				
				var box = document.createElement("input");
				box.type = "checkbox";
				box.className = "checkboxCat"
				box.code = item.CODE;
				box.subs = getSubs(item.CODE);
				box.onchange = function ()
				{
					doSearch = 1;
					refreshSubPicks(this);
				}
				
				var label = document.createElement("span");
				label.innerHTML = item.DETAIL;
				label.onclick = function ()
				{
					var box = this.parentNode.children[0];
					if(box.checked){box.checked = false;}
					else{box.checked = true;}
					box.onchange();
				}
				
				if(subCatsPicked.includes(box.code))
				{
					box.checked = true;
					label.style.color = "#0071c1";
				}

				menu.appendChild(box);
				menu.appendChild(label);
				subCatsBox.appendChild(menu);
			}
		}
		else
		{
			catLabel.style.color = "#869099";
			subCatsBox.innerHTML = "";
			clearSubs(catBox.subs);
		}
		
	}

	
	if(doSearch == 1)
	{
		if(actualIf != "home"){ifLoad("home");}
		filterWorks();
	}
}
function refreshSubPicks(box)
{
	var subCats = box.parentNode.parentNode.children;
	
	for(var i=0; i<subCats.length; i++)
	{
		var catLine = subCats[i];
		var catBox = catLine.children[0];
		var catLabel = catLine.children[1];
		if(catBox.checked)
		{
			if(!subCatsPicked.includes(catBox.code)){subCatsPicked.push(catBox.code);}
			catLabel.style.color = "#0071c1";
		}
		else
		{
			var index = subCatsPicked.indexOf(catBox.code);
			if (index > -1){subCatsPicked.splice(index, 1);}

			catLabel.style.color = "#869099";
		}
	}
	if(doSearch == 1)
	{
		if(actualIf != "home"){ifLoad("home");}
		filterWorks();
	}
}
function clearSubs(subs)
{
	
	for(var i=0; i<subs.length; i++)
	{
		var code = subs[i].CODE;
		var index = subCatsPicked.indexOf(code);
		if (index > -1){subCatsPicked.splice(index, 1);}
	}
}
// PROFILE CATS
function catBuilderPro()
{
	
	var catsBox = document.getElementById("profileCatsBox");
	catsBox.innerHTML = "";
	
	for(var i=0; i<mainCats.length; i++)
	{
		var item = mainCats[i];
		var menu = document.createElement("div");
		menu.className = "list-group-item list-group-item-action sub";
		
		var box = document.createElement("input");
		box.type = "checkbox";
		box.className = "checkboxCat"
		box.code = item.CODE;
		box.subs = getSubs(item.CODE);
		box.onchange = function ()
		{
			buildFilterPro();
		}
		
		var label = document.createElement("span");
		label.className = "catPicker";
		label.innerHTML = item.DETAIL;
		label.onclick = function ()
		{
			var box = this.parentNode.children[0];
			if(box.checked){box.checked = false;}
			else{box.checked = true;}
			box.onchange();
		}
		
		if(mainCatsPickedPro.includes(box.code))
		{
			box.checked = true;
			label.style.color = "#0071c1";
		}
		
		var subItemBox = document.createElement("div");
		subItemBox.className = "subItemBox";
		
		menu.appendChild(box);
		menu.appendChild(label);
		menu.appendChild(subItemBox);
		catsBox.appendChild(menu);
	}
	
	
}
function buildFilterPro()
{
	var cats = document.getElementById("profileCatsBox").children;
	mainCatsPickedPro = [];
	
	for(var i=0; i<cats.length; i++)
	{
		var catLine = cats[i];
		var catBox = catLine.children[0];
		var catLabel = catLine.children[1];
		var subCatsBox = catLine.children[2];;
		if(catBox.checked)
		{
			mainCatsPickedPro.push(catBox.code);
			catLabel.style.color = "#0071c1";
			
			var subCats = catBox.subs;
			subCatsBox.innerHTML = "";
			
			for(var j=0; j<subCats.length; j++)
			{
				var item = subCats[j];
				var menu = document.createElement("span");
				menu.className = "list-group-item list-group-item-action sub";
				
				var box = document.createElement("input");
				box.type = "checkbox";
				box.className = "checkboxCat"
				box.code = item.CODE;
				box.subs = getSubs(item.CODE);
				box.onchange = function ()
				{
					refreshSubPicksPro(this);
				}
				
				var label = document.createElement("span");
				label.innerHTML = item.DETAIL;
				label.onclick = function ()
				{
					var box = this.parentNode.children[0];
					if(box.checked){box.checked = false;}
					else{box.checked = true;}
					box.onchange();
				}
				
				if(subCatsPickedPro.includes(box.code))
				{
					box.checked = true;
					label.style.color = "#0071c1";
				}

				menu.appendChild(box);
				menu.appendChild(label);
				subCatsBox.appendChild(menu);
			}
		}
		else
		{
			catLabel.style.color = "#869099";
			subCatsBox.innerHTML = "";
			clearSubsPro(catBox.subs);
		}
		
	}
	
}
function clearSubsPro(subs)
{
	
	for(var i=0; i<subs.length; i++)
	{
		var code = subs[i].CODE;
		var index = subCatsPickedPro.indexOf(code);
		if (index > -1){subCatsPickedPro.splice(index, 1);}
	}
}
function refreshSubPicksPro(box)
{
	var subCats = box.parentNode.parentNode.children;
	
	for(var i=0; i<subCats.length; i++)
	{
		var catLine = subCats[i];
		var catBox = catLine.children[0];
		var catLabel = catLine.children[1];
		if(catBox.checked)
		{
			if(!subCatsPickedPro.includes(catBox.code)){subCatsPickedPro.push(catBox.code);}
			catLabel.style.color = "#0071c1";
		}
		else
		{
			var index = subCatsPickedPro.indexOf(catBox.code);
			if (index > -1){subCatsPickedPro.splice(index, 1);}

			catLabel.style.color = "#869099";
		}
	}
}
function getSubs(code)
{
	var subs = [];
	for(var j=0; j<subCats.length; j++)
	{
		var item = subCats[j]
		if(item.PARENT == code)
		{
			subs.push(item);
		}
	}
	return subs;
}
// REPLACE FOR NEW SEACH METHOD
function preFilterWorks()
{
	if(actualIf != "home"){ifLoad("home");}
	filterWorks();
}
function filterWorks()
{
	var info = {};
	info.main = mainCatsPicked;
	info.sub = subCatsPicked;
	info.search = document.getElementById("searchTop").value;
	info.ftype = actualFtype;
	
	// GET LOCATION
	if($(window).width() < 600)
	{
		if(actualIf == "home"){info.loc = document.getElementById("locPicker").value;}
		else{info.loc = document.getElementById("locPickerTop").value;}
		info.search = document.getElementById("mobileSearch").value;
	}	
	else{info.loc = document.getElementById("locPickerTop").value;}

	localStorage.setItem("lastFilter", JSON.stringify(info));
	
	info.lastFilter = JSON.stringify(info);
	
	if(userData != ""){info.ucode = userData.UCODE;}
	else{info.ucode = "";}
	
	sendAjax("users","filterWorks",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		var gridTitle = document.getElementById("gridTitle");
		var gridSubTitle = document.getElementById("gridSubTitle");
		
		if(actualFtype == "1")
		{
			gridTitle.innerHTML = "Trabajos disponibles";
			gridSubTitle.innerHTML = language["descWorks"];
			
			// HELPICON---------------
			// var hi = helpIcon("Encuentra aqui");
			// gridTitle.appendChild(hi);
			
		}
		if(actualFtype == "2")
		{
			gridTitle.innerHTML = "Repuestos disponibles";
			gridSubTitle.innerHTML = language["descParts"];
		}
		if(actualFtype == "3")
		{
			gridTitle.innerHTML = "Listado de profesionales";
			gridSubTitle.innerHTML = language["descTech"];
			
			var preFiltered = [];
			for(var i=0; i<ans.length; i++)
			{
				var item = ans[i];
				if(item.RATE > 0)
				{
					preFiltered.push(item);
				}
			}
			ans = preFiltered;
		}
		
		buildGrid(ans);
		
		// DEV ONLY---------------
		// loadCfg();
	});

}
function helpIcon(text)
{
	var icon = document.createElement("i");
	icon.className = "fa fa-question-circle hi";
	icon.setAttribute('title', text);
	icon.setAttribute('alt', text);
	icon.desc = text;
	icon.onclick = function ()
	{
		if($( window ).width() < 800)
		{alertBox(language["help"], infoIcon+this.desc, 300);}
	}
	return icon;
}
function loadCfg()
{
	ifLoad("admin-if");
}
function viewAll()
{
	
	// CLEAR ALL SEARCH FIELD EXCEPT LOCATION
	mainCatsPicked = [];
	subCatsPicked = [];
	document.getElementById("searchTop").value = "";
	doSearch = 1;
	catBuilder(cats);
	buildFilter();
	
	closeOffsetMenu();
	
	// goSite("home");
}
function buildGrid(list)
{
	var container = document.getElementById("worksBox");
	container.innerHTML = "";
	
	if(list.length == 0)
	{
		var nores = document.createElement("span");
		nores.className = "nores";
		nores.innerHTML = "No hay resultados para el filtro actual";
		container.appendChild(nores);
		return;
	}
	
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.STATUS == "0"){continue;}
		
		// ELEMENTS ----------
		var box = document.createElement("div");
		box.className = "col-6 col-md-3 mb-2";
		var card = document.createElement("div");
		card.className = "card card-product";
		var cardb = document.createElement("div");
		cardb.className = "card-body";
		var clabel = document.createElement("span");
		clabel.className = "bg-pink text-white";
		var ribbon = document.createElement("div");
		ribbon.className = "ribbon";
		ribbon.appendChild(clabel);
		var pic = document.createElement("div");
		pic.className = "card-img-top gridPic";
		var title = document.createElement("span");
		title.className = "card-title h6 blueColor";
		var action = document.createElement("button");
		action.className = "btn btn-outline-info btn-sm fullW";
		var bottom = document.createElement("div");
		bottom.className = "d-flex justify-content-between align-items-center";
		// ELEMENTS ----------
		
		
		
		// TECH BOX
		if(actualFtype == "3")
		{
			
			if(item.RATE == "0"){continue;}
			
			var img1 = "img/works/samplePro.jpg";
			
			var rate = document.createElement("span");
			rate.innerHTML = ratedBoxCustom(item.RATE);
			rate.className = "techRateGrid";
			card.appendChild(rate);
			console.log(rate)
			
			clabel.innerHTML = "Experto";
			action.innerHTML = "Información de contacto";
			
			ribbon.code = item.UCODE;
			ribbon.onclick = function(){loadPro(this.code);}

			pic.code = item.UCODE;
			pic.onclick = function(){loadPro(this.code);}
			pic.style.backgroundImage = "url('"+img1+"')";

			action.code = item.UCODE;
			action.onclick = function (){loadPro(this.code);}
			
			var string = item.NAME.replace('-', '');
			var length = 60;
			var trimmedString = string.substring(0, length);
			title.innerHTML = trimmedString;

		}
		// WORK/PART BOX
		else
		{
			if(item.HP1 == "0"){var img1 = "img/works/sample.jpg";}
			else{var img1 = "img/works/"+item.CODE+"/1.jpg"+tail;}
			clabel.innerHTML = "Nuevo";
			action.innerHTML = "Ver detalles";
			
			ribbon.code = item.CODE;
			ribbon.onclick = function(){loadWork(this.code);}

			pic.code = item.CODE;
			pic.onclick = function(){loadWork(this.code);}
			pic.style.backgroundImage = "url('"+img1+"')";
			
			action.code = item.CODE;
			action.onclick = function (){loadWork(this.code);}
			
			var string = item.DETAIL;
			var length = 32;
			var trimmedString = string.substring(0, length)+"...";
			title.innerHTML = trimmedString;
			
			var actual = getNow();
			var wDate = item.CREATED;
			var pased = getdDiff(wDate, actual) 
			var days = item.DURATION;
			
			// CHECK VENCIMIENTO
			
			// if(pased > days){continue};
		}

		bottom.appendChild(action);
		cardb.appendChild(title);
		cardb.appendChild(bottom);
		card.appendChild(ribbon);
		card.appendChild(pic);
		card.appendChild(cardb);
		box.appendChild(card);
		
		container.appendChild(box);
	}
}
function loadWork(code)
{
	var iface = "detail-if";
	actualIf = iface;
	$("#main-content").load("sources/"+iface+".html", function ()
	{
		var info = {};
		info.code = code;
		actualWorkCode = code;
		sendAjax("users","loadWork",info,function(response)
		{
			var ans = response.message;
			
			actualWorkData = ans.data;
			actualComments = ans.comments;
			actualOffers = ans.offers;
			
			refreshComments(actualComments);
			
			var tab1 = document.getElementById("comments-tab");
			tab1.innerHTML = "Comentarios ("+ans.comments.length+")";
			tab1.code = actualWorkData.CODE;
			tab1.onclick=function ()
			{
				refreshCommentsCall();
			};
			
			var tab2 = document.getElementById("review-tab");
			
			if(actualWorkData.TYPE == "1"){var preTitle = "Propuestas de servicio (";}
			if(actualWorkData.TYPE == "2"){var preTitle = "Ofertas de compra (";}
			tab2.innerHTML = preTitle+actualOffers.length+")";
			
			tab2.code = actualWorkData.CODE;
			tab2.onclick=function ()
			{
				refreshProposalsCall();
			};
			
			// "0" = "Nueva"
			// "1" = "Asignada"
			// "2" = "Calificada"
			// "3" = "Cancelada"
			
			// NUEVO
			if(actualWorkData.STATE == "0")
			{
				// PROPIO
				if(actualWorkData.AUTORCODE == userData.UCODE){actualLoadState = "3";}
				// AJENO
				else{actualLoadState = "1";}
			}
			// ASIGNADO
			if(actualWorkData.STATE == "1")
			{
				// PROPIO
				if(actualWorkData.AUTORCODE == userData.UCODE){actualLoadState = "4";}
				// AJENO
				else{actualLoadState = "5";}
			}
			// CALIFICADO
			if(actualWorkData.STATE == "2")
			{
				// PROPIO
				if(actualWorkData.AUTORCODE == userData.UCODE){actualLoadState = "4";}
				// AJENO
				else{actualLoadState = "5";}
			}
			// CANCELADO
			if(actualWorkData.STATE == "3")
			{
				actualLoadState = "6";
			}
			setWorkState(actualLoadState);
			
			jQuery('html, body').animate( {scrollTop : 0}, 300 );
			fillWork(actualWorkData);
		});
		
	});
	
}
function fillWork(data)
{
	
	var content = 
	"<b>Ciudad: </b>"+data.LOCATION+
	"<br>"+
	"<b>Creado por: </b>"+data.AUTOR.split("-")[0]+
	"<br>"+
	"<b>Fecha creación: </b>"+data.CREATED+
	"<br>"+
	"<b>Categoría: </b>"+data.MNAME+
	"<br>"+
	"<b>Sub categoría: </b>"+data.SNAME+
	"<br>";
	if(actualWorkData.TYPE == "1")
	{
		content +="<b>Propuestas recibidas: </b>"+actualOffers.length+" de "+data.PROPTOP+
	"<br>";
	}
	
	
	
	
	if(data.STATE == "1")
	{
		content+=
		"<b>Asignado a: </b>"+data.TECHNAME+
		"<br>";
	}
	
	if(data.TYPE == "1"){var preTitle = "Detalle de trabajo: ";}
	if(data.TYPE == "2"){var preTitle = "Detalle de repuesto: ";}
	
	content += "<b>"+preTitle+"</b>"+data.DETAIL;
	
	if(data.TYPE == "2"){content += "<br><b>Precio: </b>$"+data.RPRICE;}

	if(data.STATE == "2")
	{
		if(data.TYPE == "1")
		{
			content += "<br><b style='color: #0071c1 ;'>Calificación recibida: </b>"+data.RATE;
			content+= ratedBox(data.RATE);
			content += "<br><b style='color: #0071c1 ;'>Comentarios del cliente: </b>"+data.COMMENTS;
		}
		if(data.TYPE == "2")
		{
			content += "<br><b style='color: #0071c1 ;'>Finalizado: </b>"+data.COMMENTS;
		}
	}
	
	
	if(data.STATE == "3")
	{
		var pretitle = "";
		content += "<b style='color: #f44336;'>"+pretitle+"<br>"+data.CANCELED+"</b>";
	}

	document.getElementById("workDetailLabel").innerHTML = content;
	
	var code = data.CODE;
	
	var pic1 = document.getElementById("detPic1");
	var pic2 = document.getElementById("detPic2");
	var pic3 = document.getElementById("detPic3");
	
	
	
	if(data.HP1 == "0")
	{var img1 = "img/works/sample.jpg";}
	else
	{var img1 = "img/works/"+code+"/1.jpg"+tail;}

	document.getElementById("img-detail").src = img1;

	if(data.HP2 == "0")
	{var img2 = "img/works/sample.jpg";}
	else
	{var img2 = "img/works/"+code+"/2.jpg"+tail;}

	if(data.HP3 == "0")
	{var img3 = "img/works/sample.jpg";}
	else
	{var img3 = "img/works/"+code+"/3.jpg"+tail;}
	
	$("#detPic1").data('large-src',img1); //setter
	pic1.src = img1;
	pic1.code = code;
	pic1.type = "1";
	pic1.onclick = function ()
	{loadPic(this.code, this.type)}
	
	
	$("#detPic2").data('large-src',img2); //setter
	pic2.src = img2;
	pic2.code = code;
	pic2.type = "2";
	pic2.onclick = function ()
	{loadPic(this.code, this.type)}
	
	
	$("#detPic3").data('large-src',img3); //setter
	pic3.src = img3;
	pic3.code = code;
	pic3.type = "3";
	pic3.onclick = function ()
	{loadPic(this.code, this.type)}

	
}
function loadPro(code)
{
	console.log(code);
	showContactData(code);
}
function setFilter(type)
{
	actualFtype = type;
	var filters = document.getElementById("gridFilters").children;
	var f1 = filters[0];
	var f2 = filters[1];
	var f3 = filters[2];
	
	f1.style.backgroundColor = "#7d7d82";
	f2.style.backgroundColor = "#7d7d82";
	f3.style.backgroundColor = "#7d7d82";
	
	var pubRepaMid = document.getElementById("pubRepaMid");
	var pubRepuMid = document.getElementById("pubRepuMid");
	
	pubRepaMid.style.display = "none";
	pubRepuMid.style.display = "none";
		
	if(actualFtype == "1")
	{
		f1.style.backgroundColor = "#0071c1";
		pubRepaMid.style.display = "inline-block";
	}
	if(actualFtype == "2")
	{
		f2.style.backgroundColor = "#0071c1";
		pubRepuMid.style.display = "inline-block";
	}
	if(actualFtype == "3")
	{
		f3.style.backgroundColor = "#0071c1";
	}
	localStorage.setItem("actualFtype", actualFtype);
	filterWorks();
}
function refreshProposalsCall()
{
	var info = {};
	info.code = actualWorkCode;
	sendAjax("users","getProposals",info,function(response)
	{
		var ans = response.message;
		actualOffers = ans;
		orderOffers("1");
	});
}
function refreshProposals(list)
{
	
	var filtersBox = document.getElementById("filtersBox");
	if(actualWorkData.TYPE == "1"){filtersBox.style.display = "block";}
	if(actualWorkData.TYPE == "2"){filtersBox.style.display = "none";}
	
	
	var container = document.getElementById("offersBox");
	container.innerHTML = "";

	var tab2 = document.getElementById("review-tab");
	
	if(actualWorkData.TYPE == "1"){var preTitle = "Propuestas de servicio (";}
	if(actualWorkData.TYPE == "2"){var preTitle = "Ofertas de compra (";}
	tab2.innerHTML = preTitle+actualOffers.length+")";
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];

		var line = document.createElement("div");
		line.className = "row propLine";
		var halfOne = document.createElement("div");
		halfOne.className = "col-xs-12 col-md-8";

		var name = document.createElement("h5");
		name.className = "mb-0";
		
		if(item.STATE == "1")
		{
			name.innerHTML = item.TECHNAME.split("-")[0]+ "- Propuesta seleccionada";
			name.style.color = "#0071c1";
		}
		else
		{
			name.innerHTML = item.TECHNAME.split("-")[0];
		}
		
		var rate = parseFloat(item.RATE);
		console.log(rate)
		var stars = ratedBoxTable(Math.round(rate));
		var rate = stars;
		
		var rateSpan = document.createElement("span");
		rateSpan.innerHTML = rate;
		
		var small = document.createElement("small");
		small.className = "ml-2";
		small.innerHTML = item.CREATED;
		
		var breaker = document.createElement("br");
		
		var prev = document.createElement("small");
		prev.className = "ml-2";
		prev.innerHTML = "Ver calificaciones anteriores";
		prev.code = item.TECHCODE;
		prev.style.color = "#0071c1";
		prev.style.cursor = "pointer";
		prev.onclick =function ()
		{
			showTechStory(this.code);
		}
		
		var content = document.createElement("p");
		content.className = "contentProp";
		
		if(actualWorkData.TYPE == "1")
		{
			var dataSet = 
			item.COMMENTS+
			"<br><b>Valor total: </b>$"+addCommas(parseInt(item.PRICE)+parseInt(item.RANSOM))+
			"<br><b>Disponibilidad: </b>"+item.AVAILABLE+
			"<br><b>Garantía: </b>"+item.GUARANTEE+
			"<br><b>Tipo de servicio: </b>"+item.WORKLOCATION+
			"<br><b>Duración: </b>"+item.WORKTIME;
		}
		if(actualWorkData.TYPE == "2")
		{
			if(item.COMMENTS == "")
			{
				item.COMMENTS = "Oferta de compra"
			}
			else
			{
				
			}
			var dataSet = 
			item.COMMENTS+
			"<br><b>Valor total: </b>$"+addCommas(parseInt(item.PRICE)+parseInt(item.RANSOM))+
			"<br><b>Ciudad comprador: </b>"+item.WORKLOCATION;
			
			
		}
		
		content.innerHTML = dataSet;
		
		var halfTwo = document.createElement("div");
		halfTwo.className = "col-6 col-md-2 noPadds5";
		var killButton = document.createElement("button");		
		killButton.className = "fwbSm btn btn-secondary";
		killButton.innerHTML = "Eliminar";
		halfTwo.appendChild(killButton);
		killButton.code = item.CODE;
		killButton.onclick = function ()
		{
			actualOfferCode = this.code;
			confirmBox("Confirmación de eliminación", "¿Desea eliminar esta propuesta? No podrá deshacer esta operación.", killOffer);
		}
		
		var halfThree = document.createElement("div");
		halfThree.className = "col-6 col-md-2 noPadds5";
		var acceptButton = document.createElement("button");		
		acceptButton.className = "fwbSm btn btn-primary";
		acceptButton.innerHTML = "Seleccionar";
		halfThree.appendChild(acceptButton);
		acceptButton.code = item.CODE;
		acceptButton.data = item;
		acceptButton.onclick = function ()
		{
			actualOfferData = this.data;
			actualOfferCode = this.code;
			
			if(actualWorkData.TYPE == "1")
			{
				confirmBox("Confirmación de selección", language["pickCheck"],pickOffer);
			}
			if(actualWorkData.TYPE == "2")
			{
				confirmBox("Confirmación de selección", language["pickCheckR"],pickOffer);
			}
		}

		halfOne.appendChild(name);
		
		if(actualWorkData.TYPE == "1")
		{
			halfOne.appendChild(rateSpan);
			halfOne.appendChild(small);
			if($(window).width() < 600)	
			{halfOne.appendChild(breaker);}
			halfOne.appendChild(prev);
		}
		
		halfOne.appendChild(content);

		line.appendChild(halfOne);
		
		var halfFour = document.createElement("div");
		halfFour.className = "col-6 col-md-2 noPadds5";
		var showDataButton = document.createElement("button");		
		showDataButton.className = "fwbSm btn btn-primary";
		showDataButton.innerHTML = "Ver datos de contacto";
		halfFour.appendChild(showDataButton);
		showDataButton.code = item.CODE;
		showDataButton.data = item;
		showDataButton.onclick = function ()
		{
			showContactData(this.data.TECHCODE);
		}
		
		if(actualWorkData.STATE == "0")
		{
			line.appendChild(halfTwo);
			line.appendChild(halfThree);
		}
		
		
		if(item.STATE == "1")
		{
			line.appendChild(halfFour);
		}
		
		container.appendChild(line);
	}
	
}
function showTechStory(code)
{
	var info = {};
	info.code = code;
	
	sendAjax("users","getUStory",info,function(response)
	{
		var ans = response.message;

		if(ans.length > 0)
		{
			refreshStory(ans);
			showModal("storyBox");
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["noStory"], 300);
		}
		
		
	});
}
function refreshStory(list)
{
	var container = document.getElementById("storyList");
	container.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];

		var line = document.createElement("div");
		line.className = "row propLine";
		var halfOne = document.createElement("div");
		halfOne.className = "col-xs-12 col-md-10";
		var name = document.createElement("h5");
		name.className = "mb-0";
		name.innerHTML = "<b style='color: #797878; font-size: 14px;'>Cliente</b>: "+item.AUTOR.split("-")[0];
		name.style.color = "#0071c1";
		
		var small = document.createElement("small");
		small.className = "ml-2";
		small.innerHTML = item.CREATED.split(" ")[0];
		
		var rate = parseFloat(item.RATE);
		console.log(rate);
		if(rate == "0")
		{
			var stars = ratedBoxTable(Math.round(rate));
		}
		else
		{
			var stars = ratedBoxTable(rate);
		}
		
		var rate = stars;
		
		var rateSpan = document.createElement("span");
		rateSpan.innerHTML = rate;
		
		var breaker = document.createElement("br");

		var dataSet = item.COMMENTS;
		var content = document.createElement("p");
		content.className = "contentProp";
		content.innerHTML = dataSet;

		halfOne.appendChild(name);
		halfOne.appendChild(rateSpan);
		halfOne.appendChild(small);
		if($(window).width() < 600)
		{halfOne.appendChild(breaker);}
		halfOne.appendChild(content);
		line.appendChild(halfOne);
		container.appendChild(line);
	}
	
}
function showContactData(code)
{
	var info = {};
	info.code = code;
	
	sendAjax("users","getUdata",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		var data = 
		ans.NAME.replace("-", "")+"<br>"+
		"Email: "+ans.EMAIL+"<br>"+
		ans.ADDRESS+" "+ans.LOCATION+" / "+ans.PHONE+"<br><br>";
		
		var ancho = 300;
		
		if(parseFloat(ans.RATE)>0)
		{
			var openDiv = "<div class='rateBox'>";
			var rate =  "<span style='color: #000000 !important;'>Calificación</span> "+ratedBoxCustom(ans.RATE);
			var closeDiv = "</div>";
			data += openDiv+rate+closeDiv+"<br>";
		}
		
		if(ans.RESUME != "" && ans.RESUME != null)
		{
			actualUserCode = ans.UCODE;
			
			var downLinkId = "<span class='downLinkProfile' onclick=downFile('DocAD')><i class='fa fa-id-card' style='color: #58eaad;'></i> Ver documento identidad</span><br>";
			var downLinkDocs1 = "<span class='downLinkProfile' onclick=downFile('SopAD1')><i class='fa fa-folder-open' style='color: #eaa958;'></i> Certificado 1</span>";
			var downLinkDocs2 = "<span class='downLinkProfile' onclick=downFile('SopAD2')><i class='fa fa-folder-open' style='color: #94d067;'></i> Certificado 2</span>";
			var downLinkDocs3 = "<span class='downLinkProfile' onclick=downFile('SopAD3')><i class='fa fa-folder-open' style='color: #f16ce0;'></i> Certificado 3</span>";
			
			var downLinkDocs = "";
			
			if(ans.SOPFILE1 == "1"){downLinkDocs += downLinkDocs1+"<br>";}
			if(ans.SOPFILE2 == "1"){downLinkDocs += downLinkDocs2+"<br>";}
			if(ans.SOPFILE3 == "1"){downLinkDocs += downLinkDocs3+"<br>";}
			
			if(actualIf == "detail-if")
			{
				if(actualWorkData.TYPE == "1")
				{
					data += "<b>Resumen profesional:</b><br> "+ans.RESUME+"<br><br>";
					var cats = getCatsFromCodes(ans.CATS);
					data += "<b>Categorías de servicio:</b><br> "+cats+"<br><br>";
					data += downLinkId;
					data += downLinkDocs;
					var ancho = 700;
				}
				else
				{
					var ancho = 300;
				}
			}
			else
			{
				data += "<b>Resumen profesional:</b><br> "+ans.RESUME+"<br><br>";
				var cats = getCatsFromCodes(ans.CATS);
				data += "<b>Categorías de servicio:</b><br> "+cats+"<br><br>";
				data += downLinkId;
				data += downLinkDocs;
				
				var ancho = 700;
			}
		}
		
		alertBox("Información de contacto", data, ancho);
	});
	
}
function getCatsFromCodes(cats)
{
	var cats = JSON.parse(cats);
	var catList = "";
	var main = cats.main;
	var sub = cats.sub;

	for(var i=0; i<main.length; i++)
	{
		var item = main[i];
		
		for(var j=0; j<mainCats.length; j++)
		{
			var itemM = mainCats[j];
			
			if(itemM.CODE == item)
			{
				if(i == 0){catList = catList+itemM.DETAIL;}
				else{catList += ", "+itemM.DETAIL;}
			}
		}
	}
	for(var n=0; n<sub.length; n++)
	{
		var item2 = sub[n];
		for(var m=0; m<subCats.length; m++)
		{
			var itemS = subCats[m];
			if(itemS.CODE == item2)
			{catList += ", "+itemS.DETAIL;}
		}
	}
	return catList;
}
function killOffer()
{
	var info = {};
	info.code = actualOfferCode;
	
	sendAjax("users","killOffer",info,function(response)
	{
		var ans = response.message;
		refreshProposalsCall();
		hideModal("confirmModal");
	});
	
}
function killCat()
{
	var info = {};
	info.code = actualCatCode;
	
	sendAjax("users","killCat",info,function(response)
	{
		var ans = response.message;
		listGet("cats");
		hideModal("confirmModal");
	});
	
}
function pickOffer()
{
	var info = {};
	info.code = actualOfferCode;
	info.wcode = actualWorkCode;
	info.tech = actualOfferData.TECHCODE;
	info.techName = actualOfferData.TECHNAME;
	info.price = actualOfferData.PRICE;
	info.ransom = actualOfferData.RANSOM;
	
	sendAjax("users","pickOffer",info,function(response)
	{
		var ans = response.message;
		
		if(actualWorkData.TYPE == "1")
		{
			alertBox(language["alert"], infoIcon+language["assigned"], 300);
		}
		if(actualWorkData.TYPE == "2")
		{
			alertBox(language["alert"], infoIcon+language["assignedR"], 300);
		}
		
		loadWork(actualWorkCode);
		hideModal("confirmModal");
	});
	
}
function orderOffers(type)
{
	if(type == "1")
	{var sorted = sortByFieldDesc(actualOffers, "RATE");}
	if(type == "2")
	{var sorted = sortByFieldDesc(actualOffers, "PRICE");}
	if(type == "3")
	{var sorted = sortByFieldDesc(actualOffers, "AVAILABLE");}
	refreshProposals(sorted);
}
function sortByFieldAsc(list, field)
{
	var arranged = list.sort(function (a, b) 
	{
	  if (a[field] > b[field]) 
	  {
		return 1;
	  }
	  if (a[field] < b[field]) 
	  {
		return -1;
	  }
	  
	  return 0;
	});
	
	return arranged;
}
function sortByFieldDesc(list, field)
{
	var arranged = list.sort(function (a, b) 
	{
	  if (b[field] > a[field]) 
	  {
		return 1;
	  }
	  if (b[field] < a[field]) 
	  {
		return -1;
	  }
	  
	  return 0;
	});
	
	return arranged;
}
function refreshCommentsCall()
{
	var info = {};
	info.code = actualWorkCode;
	sendAjax("users","getComments",info,function(response)
	{
		var ans = response.message;
		refreshComments(ans);
	});
}
function refreshComments(list)
{
	var container = document.getElementById("commentsBox");
	container.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.STATUS != "1"){continue;}
		
		var line = document.createElement("div");
		line.className = "media";
		var lineContent = document.createElement("div");
		lineContent.className = "media-body ml-3";
		var name = document.createElement("h5");
		name.className = "mb-0";
		name.innerHTML = item.AUTOR.split("-")[0];
		var small = document.createElement("small");
		small.className = "ml-2";
		small.innerHTML = item.DATE;
		var content = document.createElement("p");
		content.innerHTML = item.CONTENT;
		var hr = document.createElement("hr");
		hr.className = "commentMargin";
		
		if(actualWorkData.AUTORCODE == item.AUTORCODE)
		{name.style.color = "#0071c1";}
		
		line.appendChild(lineContent);
		lineContent.appendChild(name);
		lineContent.appendChild(small);
		lineContent.appendChild(content);
		lineContent.appendChild(hr);
		container.appendChild(line);
		
	}
}
function commentSend()
{
	var info = {};
	info.code = actualWorkCode;
	info.comments = document.getElementById("inputComment").value;
	info.autor = userData.UCODE;
	info.autorName = userData.NAME;
	
	if(info.comments == "")
	{
		alertBox(language["alert"], infoIcon+language["language"], 300);
		return;
	}
	
	sendAjax("users","commentSave",info,function(response)
	{
		var ans = response.message;
		refreshComments(ans);
		hideModal("commentFormModal");
		
	});
}
function cancelWork()
{
	document.getElementById("cancelCause").value = "";
	showModal("cancelModal");
}
function cancelWorkSend()
{

	var info = {};
	info.code = actualWorkCode;
	info.reason = document.getElementById("cancelCause").value;
	
	if(info.reason == "")
	{
		hideModal("cancelModal");
		alertBox(language["alert"], infoIcon+language["mustReason"], 300);
		return;
	}
	
	
	sendAjax("users","cancelWork",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		hideModal("cancelModal");
		
		if(actualWorkData.TYPE == "1")
		{
			alertBox(language["alert"], infoIcon+language["canceledW"], 300);
		}
		if(actualWorkData.TYPE == "2")
		{
			alertBox(language["alert"], infoIcon+language["canceledR"], 300);
		}
		
		
		loadWork(info.code);
		
	});
	
	$("#loaderDiv").fadeIn();
}
function createWork(mode)
{
	
	if(mode == "1" || mode == null){actualFtype = "1";}
	if(mode == "2"){actualFtype = "2";}
	localStorage.setItem("actualFtype", actualFtype);
	
	if(userData.UCODE)
	{
		ifLoad("detail-if");
		setWorkState("2");
	}
	else
	{
		alertBox(language["alert"], infoIcon+language["mustLogin"], 300);
		ifLoad("login-if");
	}
}
// S E T WORK STATES
function setWorkState(state)
{
	setTimeout(function()
	{
		var detailCover = document.getElementById("detCover")
		var workDetailLabel= document.getElementById("workDetailLabel");
		var workForm = document.getElementById("workForm");
		var postMeBox = document.getElementById("postMeBox");
		var rateThisBox = document.getElementById("rateThisBox");
		var cancelThisBox = document.getElementById("cancelThisBox");
		var saveWorkBox = document.getElementById("saveWorkBox");
		var saveWorkB = document.getElementById("saveWorkB");
		var picsBox = document.getElementById("picsBox");
		var comentOffers = document.getElementById("comentOffers");
		var commentButton = document.getElementById("commentButton");
		var postOfferButton = document.getElementById("postOfferButton");
		var picZone = document.getElementById("picZone");
		var rePriceBox = document.getElementById("rePriceBox")
		var rePrice = document.getElementById("rePrice");
		var cancelCauses = document.getElementById("cancelCause");
		var cancelMessage = document.getElementById("cancelMessage");
		var cancelModalTitle = document.getElementById("cancelModalTitle");
		var cancelButton = document.getElementById("cancelButton");
		var propsNumBox = document.getElementById("propsNumBox");
		console.log("Cargar estado "+state);
		
		// "0" = "Nueva"
		// "1" = "Asignada"
		// "2" = "Calificada"
		// "3" = "Cancelada"
		
		var formTitle = document.getElementById("formTitle");
		var wDetails = document.getElementById("wDetails");

		// CREAR
		if(state == "2")
		{
			console.log("nuevo / Crear")
			if(actualFtype == "1")
			{
				formTitle.innerHTML = "Ingresa los detalles de tu necesidad";
				wDetails.placeholder = "Escribe aquí tu necesidad describiendo con la mayor cantidad de detalle posible el problema a solucionar";
				
				var hi = helpIcon(language["helpText1"]);
				formTitle.appendChild(hi);
				
				saveWorkB.innerHTML = "Crear publicación y agregar imágenes";
				rePriceBox.style.display = "none";
				propsNumBox.style.display = "block";
			}
			if(actualFtype == "2")
			{
				formTitle.innerHTML = "Ingresa los detalles de tu repuesto";
				wDetails.placeholder = "Ingresa la información detallada de tu repuesto o dispositivo dañado que quieras vender como repuesto (Estado, marca, referencia y lo demás que consideres útil)";
				
				var hi = helpIcon(language["helpText2"]);
				formTitle.appendChild(hi);
				
				saveWorkB.innerHTML = "Crear repuesto y agregar imágenes";
				rePriceBox.style.display = "block";
				propsNumBox.style.display = "none";
			}
			
			document.getElementById("img-detail").src = "img/works/sample.jpg";
			document.getElementById("img-detail").onclick = function ()
			{
				console.log("debes guardar");
				$(".pswp").hide();
				alertBox(language["alert"], infoIcon+language["willPic"], 300);
			}
			workDetailLabel.style.display = "none";
			postMeBox.style.display = "none";
			rateThisBox.style.display = "none";
			cancelThisBox.style.display = "none";
			picsBox.style.display = "none";
			comentOffers.style.display = "none";
			
			$("#detPic1").data('large-src',"img/works/sample.jpg"+tail);
			$("#detPic2").data('large-src',"img/works/sample.jpg"+tail);
			$("#detPic3").data('large-src',"img/works/sample.jpg"+tail);
			
			setLocations("3");
			
			document.getElementById("rLocation").value = userData.LOCATION;
			saveWorkBox.style.display = "block";
			saveWorkB.onclick = function ()
			{
				saveWork("c");
			}
			
			catsPickLoader();
		}
		// NUEVO / PROPIO
		if(state == "3")
		{
			console.log("existente tecnico sin asignar / editar")
			
			if(actualWorkData.TYPE == "1")
			{
				formTitle.innerHTML = "Ingresa los detalles de tu necesidad";
				rePriceBox.style.display = "none";
			}
			if(actualWorkData.TYPE == "2")
			{
				formTitle.innerHTML = "Ingresa los detalles de tu repuesto";
				rePriceBox.style.display = "block";
				propsNumBox.style.display = "none";
			}
			
			setLocations("3");
			catsPickLoader();
			saveWorkBox.style.display = "block";
			workDetailLabel.style.display = "none";
			postMeBox.style.display = "none";
			rateThisBox.style.display = "none";
			cancelThisBox.style.display = "none";
			saveWorkB.innerHTML = "Guardar";
			picsBox.style.display = "block";
			comentOffers.style.display = "block";
			commentButton.style.display = "block";
			
			document.getElementById("rCat").value = actualWorkData.MPARENT;
			document.getElementById("rCat").onchange();
			document.getElementById("rDuration").value = actualWorkData.DURATION;
			document.getElementById("rPropTop").value = actualWorkData.PROPTOP;
			document.getElementById("rLocation").value = actualWorkData.LOCATION;
			
			setTimeout(function()
			{document.getElementById("rsCat").value = actualWorkData.SPARENT;}, 200);
			
			document.getElementById("rePrice").value = actualWorkData.RPRICE;
			document.getElementById("wDetails").value = actualWorkData.DETAIL;
			document.getElementById("rLocation").value = userData.LOCATION;
			saveWorkB.onclick = function ()
			{
				saveWork("e");
			}
			saveWorkB.innerHTML = "Guardar";
		}
		// NUEVO / AJENO
		if(state == "1")
		{
			console.log("existente visitante / only show")
			
			if(actualWorkData.TYPE == "1")
			{
				formTitle.innerHTML = "Detalles de la necesidad";
				postOfferButton.innerHTML = "Postular cotización";
				postOfferButton.onclick = function (){postOffer();}					
			}
			if(actualWorkData.TYPE == "2")
			{
				formTitle.innerHTML = "Detalles del repuesto";
				postOfferButton.innerHTML = "Comprar";
				postOfferButton.onclick = function (){buyRePop();}					
			}
			
			workDetailLabel.style.display = "block";
			postMeBox.style.display = "block";
			workForm.style.display = "none";
			rateThisBox.style.display = "none";
			cancelThisBox.style.display = "none";
			saveWorkBox.style.display = "none";
			picsBox.style.display = "block";
			comentOffers.style.display = "block";
			commentButton.style.display = "block";

		}
		// ASIGNADO / PROPIO - CALIFICAR
		if(state == "4")
		{
			console.log("existente tecnico asignado propio / calificar")
			
			cancelCauses.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "Seleccione la causa de cancelación";
			cancelCauses.appendChild(option);
			
			if(actualWorkData.TYPE == "1")
			{
				formTitle.innerHTML = "Detalles de la necesidad";
				cancelThisBox.innerHTML = "Cancelar trabajo";
				rateThisBox.innerHTML = "Calificar servicio";
				cancelModalTitle.innerHTML = "Cancelar trabajo";
				cancelMessage.innerHTML = "En caso de que el profesional no haya prestado el servicio o usted como cliente decida cancelarlo debe marcarlo como cancelado.";
				cancelButton.innerHTML = "Cancelar trabajo";
				
				var option = document.createElement("option");
				option.value = "Cancelado porque el profesional no se presentó";
				option.innerHTML = "Cancelado porque el profesional no se presentó";
				cancelCauses.appendChild(option);
				
				var option = document.createElement("option");
				option.value = "Trabajo cancelado por el cliente";
				option.innerHTML = "Trabajo cancelado por el cliente";
				cancelCauses.appendChild(option);
				
				rateThisBox.onclick = function(){openRater();}
				
				
			}
			if(actualWorkData.TYPE == "2")
			{
				formTitle.innerHTML = "Detalles del repuesto";
				cancelThisBox.innerHTML = "Cancelar venta";
				rateThisBox.innerHTML = "Marcar como vendido";
				cancelModalTitle.innerHTML = "Cancelar venta";
				cancelMessage.innerHTML = "En caso de que el cliente no haya confirmado la compra o usted como vendedor decida cancelarla debe marcarla como cancelada.";
				cancelButton.innerHTML = "Cancelar venta";
				
				var option = document.createElement("option");
				option.value = "Cancelado porque el cliente no confirmó la compra";
				option.innerHTML = "Cancelado porque el cliente no confirmó la compra";
				cancelCauses.appendChild(option);
				
				var option = document.createElement("option");
				option.value = "Venta cancelada por el vendedor";
				option.innerHTML = "Venta cancelada por el vendedor";
				cancelCauses.appendChild(option);
				
				rateThisBox.onclick = function(){confirmSold();}
			}
			
			workDetailLabel.style.display = "block";
			postMeBox.style.display = "none";
			workForm.style.display = "none";
			picsBox.style.display = "block";
			saveWorkBox.style.display = "none";
			comentOffers.style.display = "block";
			commentButton.style.display = "none";
			
			if(actualWorkData.RATE != "" && actualWorkData.STATE == "2")
			{
				cancelThisBox.style.display = "none";
				rateThisBox.style.display = "inline";
				if(actualWorkData.TYPE == "1")
				{
					rateThisBox.innerHTML = "Volver a calificar servicio";
				}
				if(actualWorkData.TYPE == "2")
				{
					rateThisBox.style.display = "none";
				}
			}
			if(actualWorkData.RATE == "" && actualWorkData.STATE == "1")
			{
				cancelThisBox.style.display = "inline";
				rateThisBox.style.display = "inline";
			}
			saveWorkBox.style.display = "none";
			saveWorkB.onclick = function ()
			{
				return;
			}
		}
		// ASIGNADO / AJENO - REVISAR
		if(state == "5")
		{
			console.log("existente tecnico asignado ajena / revisar")
			
			if(actualWorkData.TYPE == "1")
			{
				formTitle.innerHTML = "Detalles de la necesidad";
			}
			if(actualWorkData.TYPE == "2")
			{
				formTitle.innerHTML = "Detalles del repuesto";
			}
			
			workDetailLabel.style.display = "block";
			postMeBox.style.display = "none";
			workForm.style.display = "none";
			rateThisBox.style.display = "none";
			cancelThisBox.style.display = "none";
			saveWorkBox.style.display = "none";
			picsBox.style.display = "block";
			saveWorkBox.style.display = "none";
			comentOffers.style.display = "block";
			commentButton.style.display = "block";
			saveWorkB.onclick = function ()
			{
				return;
			}
		}
		// CANCELADO - REVISAR
		if(state == "6")
		{

			console.log("existente cancelado")
			
			if(actualWorkData.TYPE == "1")
			{
				formTitle.innerHTML = "Detalles de la necesidad";
			}
			if(actualWorkData.TYPE == "2")
			{
				formTitle.innerHTML = "Detalles del repuesto";
			}
			
			workDetailLabel.style.display = "block";
			postMeBox.style.display = "none";
			workForm.style.display = "none";
			rateThisBox.style.display = "none";
			cancelThisBox.style.display = "none";
			saveWorkBox.style.display = "none";
			picsBox.style.display = "block";
			comentOffers.style.display = "block";
			commentButton.style.display = "block";
		}
		
		var propsTab = document.getElementById("propsTab");
		var commentsButton = document.getElementById("commentButton");
		
		if(state != "2")
		{
			if(actualWorkData.AUTORCODE != userData.UCODE)
			{
				propsTab.style.display = "none";
				// commentsButton.style.display = "none";
			}
			else
			{
				propsTab.style.display = "block";
				// commentsButton.style.display = "block";
				if(loadProps == 1)
				{
					console.log("directo")
					document.getElementById("propsTab").click();
				}
			}
		}
		
		
		detailCover.style.display = "none";
	}, 500);
	
}
function catsPickLoader()
{
	var catsBox = document.getElementById("rCat");
	catsBox.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona categoría";
	catsBox.appendChild(option);
	
	for(var i=0; i<mainCats.length; i++)
	{
		var item = mainCats[i];
		var option = document.createElement("option");
		option.value = item.CODE;
		option.innerHTML = item.DETAIL;
		catsBox.appendChild(option);
	}
	
	catsBox.onchange = function ()
	{
		var code = this.value;
		var subitems = [];
		var spicker = document.getElementById("rsCat");
		spicker.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Selecciona sub categoría";
		spicker.appendChild(option);
		
		for(var i=0; i<subCats.length; i++)
		{
			var sitem = subCats[i];
			if(sitem.PARENT == code)
			{
				var option = document.createElement("option");
				option.value = sitem.CODE;
				option.innerHTML = sitem.DETAIL;
				spicker.appendChild(option);
			}
			
		}
		
		
	}
}
function saveWork(mode)
{
	
	var info = {};
	
	info.wLoc = document.getElementById("rLocation").value;
	info.wDuration = document.getElementById("rDuration").value;
	info.wPropTop = document.getElementById("rPropTop").value;
	info.wCat = document.getElementById("rCat").value;
	info.wCatDet = $( "#rCat option:selected" ).text();
	info.wsCat = document.getElementById("rsCat").value;
	info.wsCatDet = $( "#rsCat option:selected" ).text();
	info.wDetails = document.getElementById("wDetails").value;
	info.rprice = document.getElementById("rePrice").value;
	info.ucode = userData.UCODE;
	info.created = getNow();
	info.autor = userData.NAME;
	info.mode = mode;
	info.type = actualFtype;
	
	if(mode == "e")
	{info.actualCode = actualWorkCode;}
	
	if(info.wLoc == "" || info.wDuration == "" || info.wPropTop == "" || info.wCat == "" || info.wsCat == "" || info.wDetails == "")
	{
		alertBox(language["alert"], infoIcon+language["mustFieldsWork"], 300);
		return;
	}
	
	if(actualFtype == "2")
	{
		if(info.rprice == "")
		{
			alertBox(language["alert"], infoIcon+language["mustFieldsWork"], 300);
			return;
		}
		
	}
	
	console.log(info);
	// return;
	
	sendAjax("users","workSave",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		return;

		if(ans != "edited")
		{
			alertBox(language["alert"], infoIcon+language["savedCdataNew"], 300);
			setTimeout(function()
			{
				loadWork(ans);
			}, 2000);
			
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["savedCdata"], 300);
		}
		
		
		
		console.log(ans)
	});

	
}


// IMG ADMIN------------------
function loadPic(code, type)
{
	console.log(actualLoadState);
	
	if(actualLoadState != "3" && actualLoadState != "1")
	{
		console.log("No puedes cambiar estas imagenes")
		return;
	}
	else
	{
		if(userData.UCODE == actualWorkData.AUTORCODE)
		{
			actualPicCode = code;
			actualPicType = type;
			document.getElementById("picSelector2").click();
		}
		else
		{
			console.log("not autor")
		}
	}
	
}
function prepareImgCropper()
{
	document.querySelector('#picSelector2').addEventListener('change', 		function()
	{
		var reader = new FileReader();
		reader.onload = function(e) 
		{
			var img = new Image;
			var pickSelector2 = document.getElementById('picSelector2');
			
			var spfname = pickSelector2.value.split('.');
			var spfnameLen = spfname.length;
			var format = spfname[(spfnameLen-1)];

			if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
			{
				actualCroppedPic = "";
				console.log("enter 1");
				alertBox(language["alert"], infoIcon+language["wrongFormatJpgFile"], 300);
				pickSelector2.value = "";

				return;
			}
			
			var size = parseInt(e.loaded/1000);
			
			img.onload = function() 
			{
				var pickSelector2 = document.getElementById('picSelector2');
				var spfname = pickSelector2.value.split('.');
				var spfnameLen = spfname.length;
				var format = spfname[(spfnameLen-1)];

				var w = img.width;
				var h = img.height;
				
				if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
				{
					actualCroppedPic = "";
					alertBox(language["alert"], infoIcon+language["wrongFormatJpgFile"], 300);
					pickSelector2.value = "";

					return;
				}
				croppieQ = 0.7;
				console.log(size)
				
				if(size <= 499)
				{
					croppieQ = 0.6;
				}
				if(size <= 500 && size >= 999)
				{
					croppieQ = 0.4;
				}
				if(size >= 1000)
				{
					croppieQ = 0.28;
				}
				args = 
				{
					url: e.target.result,
					orientation: 1, 
				}
				croppieSet();

			};
			
			img.src = reader.result;
		}
		reader.readAsDataURL(this.files[0]);
	})
}
function ratedBoxCustom(rate)
{
	var line = "";
	for(var i=0; i<5; i++)
	{
		if(i < rate){line += "<i class='fa fa-star'></i>";}
		else{line += "<i class='fa fa-star-o'></i>";}
	}
	return line;
}
function ratedBox(rate)
{
	if(rate != "0")
	{
		var line = " <span class='rating' data-value="+rate+"></span>";
	}
	else
	{
		var line = language["noprom"];
	}
	return line;
}
function ratedBoxTable(rate)
{
	if(rate == "0")
	{
		var stars = language["noprom"];
	}
	if(rate == "1")
	{
		var stars = " <span class='rating'><i class='fa fa-star'></i><i class='fa fa-star-o'><i class='fa fa-star-o'><i class='fa fa-star-o'><i class='fa fa-star-o'></i></span>"
	}
	if(rate == "2")
	{
		var stars = " <span class='rating' data-value='"+rate+"'><i class='fa fa-star'></i><i class='fa fa-star'><i class='fa fa-star-o'><i class='fa fa-star-o'><i class='fa fa-star-o'></i></span>"
	}
	if(rate == "3")
	{
		var stars = " <span class='rating' data-value='"+rate+"'><i class='fa fa-star'></i><i class='fa fa-star'><i class='fa fa-star'><i class='fa fa-star-o'><i class='fa fa-star-o'></i></span>"
	}
	if(rate == "4")
	{
		var stars = " <span class='rating' data-value='"+rate+"'><i class='fa fa-star'></i><i class='fa fa-star'><i class='fa fa-star'><i class='fa fa-star'><i class='fa fa-star-o'></i></span>"
	}
	if(rate == "5")
	{
		var stars = " <span class='rating' data-value='"+rate+"'><i class='fa fa-star'></i><i class='fa fa-star'><i class='fa fa-star'><i class='fa fa-star'><i class='fa fa-star'></i></span>"
	}
	
	return stars;
}
function goSite(site)
{
	if(site != "contact"){ifLoad(site)}
	else{openContact();}
}
function backToWork()
{
	confirmBox("Confirmación", "Si regresas a la información del trabajo sin envíar la propuesta, perderás la información ingresada. ¿Deseas continuar?", btwConfirmed);
}
function btwConfirmed()
{
	loadWork(actualWorkCode);
	hideModal("confirmModal");
}
function loadProfile(type)
{
	if(type == 1){ifLoad("profile-if");}
	if(type == 2){ifLoad("pprofile-if");}
	
	var info = {};
	info.code = userData.UCODE;
	info.type = type;
	
	console.log(info)
	
	sendAjax("users","guData",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(info.type == 1)
		{
			var name = ans.NAME.split("-")[0];
			var lastname = ans.NAME.split("- ")[1];
			document.getElementById("rName").value = name;
			document.getElementById("rLastName").value = lastname;
			document.getElementById("rEmail").value = ans.EMAIL;
			document.getElementById("rEmail").disabled = true;
			document.getElementById("rAddress").value = ans.ADDRESS;
			document.getElementById("rPhone").value = ans.PHONE;
			document.getElementById("idType").value = ans.IDTYPE;
			document.getElementById("idNumber").value = ans.IDNUMBER;
			document.getElementById("rLocation").value = ans.LOCATION;
		}
		if(info.type == 2)
		{
			
		}
		
	});
}
function getMyWorks(filter)
{
	var info = {};
	info.code = userData.UCODE;
	info.filter = filter;
	info.type = "1";

	sendAjax("users","getMyWorks",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("worksList", ans);
	});
}
function getMyParts(filter)
{
	var info = {};
	info.code = userData.UCODE;
	info.filter = filter;
	info.type = "2";

	sendAjax("users","getMyWorks",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("partsList", ans);
	});
}
function commentWork()
{
	if(!userData.UCODE)
	{
		alertBox(language["alert"], infoIcon+language["mustLoginComment"], 300);
		ifLoad("login-if");
		setTimeout(function()
		{
			console.log("lol")
			hideModal("commentFormModal");
		}, 600);
		
		
	}
}
function postOffer()
{
	if(userData.UCODE)
	{
		if(userData.PASSED == "0")
		{
			alertBox(language["alert"], infoIcon+language["mustBeAprobed"], 300);
			ifLoad("pprofile-if");
		}
		else
		{
			ifLoad("postulate-if");
		}
	}
	else
	{
		alertBox(language["alert"], infoIcon+language["mustLoginPostulate"], 300);
		ifLoad("login-if");
	}
}
function buyRePop()
{
	if(userData.UCODE)
	{
		var valueField = document.getElementById("InputBuyValue");
		var detailField = document.getElementById("InputBuyDetail");
		valueField.value = actualWorkData.RPRICE;
		detailField.value = "";
		showModal("buyOfferModal");
	}
	else
	{
		alertBox(language["alert"], infoIcon+language["mustLoginPostulateR"], 300);
		ifLoad("login-if");
	}
}
function openRater()
{
	if(actualWorkData.RATE != "")
	{
		$('#star-rating').raty('score', actualWorkData.RATE);
	}
	else
	{
		$('#star-rating').raty('score', 0);
	}
	
	document.getElementById("inputDesc").value = "";
	
	if(actualWorkData.RATE != "")
	{
		document.getElementById("inputDesc").value = actualWorkData.COMMENTS;
	}
	else
	{
		document.getElementById("inputDesc").value = "";
	}
	
	// $("#reviewFormModal").modal("show");
	showModal("reviewFormModal");
	
}
function setRate()
{
	var rating = $('#star-rating').raty('score');
	var obs = document.getElementById("inputDesc").value;
	$("#reviewFormModal").modal("hide");
	
	var info = {};
	info.rating = rating;
	info.obs = obs;
	info.code = actualWorkCode;
	
	if(parseFloat(info.rating) < 1)
	{
		info.rating = 1;
	}
	
	if(info.obs == "")
	{
		alertBox(language["alert"], infoIcon+language["mustComment"], 300);
		return;
	}
	sendAjax("users","setRate",info,function(response)
	{
		var ans = response.message;
		hideModal("reviewFormModal");
		setTimeout(function()
		{
			loadWork(info.code);
		}, 300);
	});
}
function confirmSold()
{
	confirmBox("Confirmación de venta", "¿Deseas marcar esta venta como completada?", setSold);
}
function setSold()
{
	var rating = "5";
	var obs = "Vendido";
	var info = {};
	info.rating = rating;
	info.obs = obs;
	info.code = actualWorkCode;
	console.log(info)
	sendAjax("users","setRate",info,function(response)
	{
		var ans = response.message;
		hideModal("confirmModal");
		setTimeout(function()
		{
			loadWork(info.code);
		}, 300);
	});
}
function changePassBox()
{
	$("#changePassModal").modal("show");
}
function savePass()
{
	var info = {};
	info.pass1 = document.getElementById("newPass1b").value;
	info.pass2 = document.getElementById("newPass2b").value;
	info.pass = document.getElementById("newPass1").value;
	info.scode = actualScode;
	info.ucode = userData.UCODE;
	
	if(info.pass1 == "" || info.pass2 == "")
	{
		alertBox(language["alert"], infoIcon+language["mustPassChange"]);
		return;
	}
	
	if(info.pass1 != info.pass2)
	{
		alertBox(language["alert"], infoIcon+language["passMatch"]);
		return;
	}
	
	sendAjax("users","savePass",info,function(response)
	{
		var ans = response.message;
		alertBox(language["alert"], infoIcon+language["passwordSaved"]);
		hideModal("changePassModal");
		
		document.getElementById("newPass1").value = "";
		document.getElementById("newPass2").value = "";
	});
	
}
// -----------CROPPIE--------------
function croppieSet()
{
	if(theCroppie != null){theCroppie.destroy();}
	
	var container = document.getElementById("croppieBox");
	container.innerHTML = "";
	var cpie = document.createElement("div");
	cpie.id = "cpie";
	
	var footer = document.createElement("div");
	footer.className = "modal-footer";
	
	var cancel = document.createElement("button");
	cancel.className = "btn btn-secondary btn-sm";
	cancel.onclick = function ()
	{
		hideModal("loadPicPop");
		document.getElementById("picSelector2").value = "";
	}
	cancel.innerHTML = "Cancelar";
	
	var accept = document.createElement("button");
	accept.className = "btn btn-primary btn-sm";
	accept.onclick = function ()
	{
		getCroppieR();
	}
	accept.innerHTML = "Guardar";

	footer.appendChild(cancel);
	footer.appendChild(accept);

	container.appendChild(cpie);
	container.appendChild(footer);

	if($(window).width() < 800)
	{
		var opts = 
		{
			viewport: { width: 300, height: 250 },
			boundary: { width: 300, height: 250 },
			showZoomer: true,
			enableOrientation: true,
			mouseWheelZoom: 'ctrl',
			
		}
	}
	else
	{
		var opts = 
		{
			viewport: { width: 500, height: 416 },
			boundary: { width: 500, height: 416 },
			showZoomer: true,
			enableOrientation: true,
			mouseWheelZoom: 'ctrl',
		}
	}
	
	theCroppie = new Croppie(document.getElementById('cpie'), opts);
	theCroppie.bind(args);
	showModal("loadPicPop");
	
	var zoomBar = document.getElementsByClassName("cr-slider")[0];
	
	if($(window).width() < 800)
	{
		zoomBar.value = "0.3";
		// zoomBar.min = "0.08";
		
		var pic = document.getElementsByClassName("cr-image")[0];
		setTimeout(function()
		{
			console.log(pic);	pic.style.transform = "scale(0.3)";
			// alertBox(language["alert"], "hola", 300);
		}, 500);

	}
	else
	{
		zoomBar.value = "1";
		zoomBar.min = "0.3";
		
	}
	zoomBar.max = "1.5";
	
	
}
function getCroppieR()
{
	var args =
	{
		type: 'base64',
		size: 'original',
		format: 'jpeg',
		quality: croppieQ,
		circle: false
	}	
	
	theCroppie.result(args).then(function(resp) 
	{
		actualCroppedPic = resp;
		savepPic();
	});

}
function savepPic()
{
	var info = {};
	info.pic = actualCroppedPic;
	info.code = actualPicCode;
	info.picType = actualPicType;
	
	tail = "?r="+Math.random();
	document.getElementById("coverLoad").style.display = "block";

	sendAjax("users","picsave",info,function(response)
	{
		var ans = response.message;
		actualCroppedPic = "";
		alertBox(language["alert"], infoIcon+language["picDone"], 300);
		
		var id = "detPic"+actualPicType;
		var path = "img/works/"+info.code+"/"+actualPicType+".jpg"+tail;

		$("#"+id).data('large-src', path); //setter
		document.getElementById("detPic"+actualPicType).src = path;
		document.getElementById("img-detail").src = path;
		document.getElementById("coverLoad").style.display = "none";
		
		console.log(ans);
		markLoaded(info.picType, info.code) 
	});
}
function markLoaded(type, code)
{
	var info = {};
	info.type = type;
	info.code = code;
	
	sendAjax("users","markLoaded",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		hideModal("loadPicPop");
	});
	
	
}
// -----------CROPPIE--------------
// TABLES
function tableCreator(tableId, list)
{
	var table = document.getElementById(tableId);
	tableClear(tableId);
	
	var qty = list.length+" Items";
	if(list.length == 1){var qty = list.length+" Item";}
	if(list.length == 0)
	{
		var nInYet = document.createElement("div");
		nInYet.innerHTML = language["noResults"];
		nInYet.className = "blankProducts";
		table.appendChild(nInYet);
		return;
	}
	
	// MY WORKS TABLE
	if(tableId == "worksList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			
			var details = encry(list[i].DETAIL);

			var a = cellCreator('Detalles', details);
			// var a = cellCreator('Detalles', "test");
			
			var b = cellCreator('Creada', list[i].CREATED.split(" ")[0]);
			
			if(list[i].STATE == "0")
			{var state = "Nueva";}
			if(list[i].STATE == "1")
			{var state = "Asignada";}
			if(list[i].STATE == "2")
			{var state = "Calificada";}
			if(list[i].STATE == "3")
			{var state = "Cancelada";}
			
			
			
			var c = cellCreator('Estado', state);
			var d = cellCreator('Duración', list[i].DURATION);
			var e = cellCreator('Creado por',  list[i].AUTOR.split("-")[0]);
			
			if(list[i].TECHNAME != "")
			{
				var asigned = list[i].TECHNAME.split("-")[0];
			}
			else
			{
				var asigned = "Sin asignar";
			}
			
			var g = cellCreator('Asignado a',  asigned);

			if(list[i].RATE != "")
			{
				var stars = ratedBoxTable(Math.round(list[i].RATE));
				var rate = Math.round(list[i].RATE)+stars;
			}
			else
			{
				var rate = "Pendiente";
				if(list[i].STATE == "3")
				{
					var rate = "Cancelado";
				}
			}
			var f = cellCreator('Calificación', rate);
			
			
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "img/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualWorkCode = data.CODE;
				loadWork(data.CODE);
			}
			
			if(list[i].AUTORCODE == userData.UCODE)
			{
				var icons = [detail];
			}
			
			
			if(list[i].TECH == userData.UCODE)
			{
				
				var cData = document.createElement("img");
				cData.reg = list[i];
				cData.setAttribute('title', "Datos del cliente");
				cData.setAttribute('alt', "Datos del cliente");
				cData.src = "img/cIcon2.png";
				cData.code = list[i].AUTORCODE;
				cData.onclick = function()
				{
					var code = this.code;
					showContactData(code);
				}

				var icons = [detail, cData];
			}

			if(list[i].TECH != userData.UCODE && list[i].TECH != "")
			{
				var cData = document.createElement("img");
				cData.reg = list[i];
				cData.setAttribute('title', "Datos del profesional");
				cData.setAttribute('alt', "Datos del profesional");
				cData.src = "img/cIcon.png";
				cData.code = list[i].TECH;
				cData.onclick = function()
				{
					var code = this.code;
					showContactData(code);
				}

				var icons = [detail, cData];
			}
			
			console.log(icons)
			
			var x = cellOptionsCreator('', icons)
			
			var cells = [a,b,c,d,e,g,f,x];
			
			console.log("3")
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			
			console.log("4")
			
			table.appendChild(row);
			
		}

	}
	// MY PARTS TABLE
	if(tableId == "partsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Detalles', list[i].DETAIL);
			var b = cellCreator('Creada', list[i].CREATED.split(" ")[0]);
			
			if(list[i].STATE == "0")
			{var state = "Nuevo";}
			if(list[i].STATE == "1")
			{var state = "Pendiente confirmación";}
			if(list[i].STATE == "2")
			{var state = "Vendido";}
			if(list[i].STATE == "3")
			{var state = "Cancelado";}
			
			var c = cellCreator('Estado', state);
			var d = cellCreator('Duración', list[i].DURATION);
			var e = cellCreator('Vendedor',  list[i].AUTOR.split("-")[0]);
			
			if(list[i].TECHNAME != "")
			{
				var asigned = list[i].TECHNAME.split("-")[0];
			}
			else
			{
				var asigned = "Sin asignar";
			}
			
			var g = cellCreator('Comprador',  asigned);

			
			var f = cellCreator('Precio', list[i].RPRICE);
			
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "img/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualWorkCode = data.CODE;
				loadWork(data.CODE);
			}
			
			var icons = [detail];
			
			if(list[i].TECH == userData.UCODE)
			{
				
				var cData = document.createElement("img");
				cData.reg = list[i];
				cData.setAttribute('title', "Datos del Vendedor");
				cData.setAttribute('alt', "Datos del Vendedor");
				cData.src = "img/cIcon2.png";
				cData.code = list[i].AUTORCODE;
				cData.onclick = function()
				{
					var code = this.code;
					showContactData(code);
				}

				var icons = [detail, cData];
			}
			if(list[i].TECH != userData.UCODE && list[i].TECH != "")
			{
				var cData = document.createElement("img");
				cData.reg = list[i];
				cData.setAttribute('title', "Datos del Comprador");
				cData.setAttribute('alt', "Datos del Comprador");
				cData.src = "img/cIcon.png";
				cData.code = list[i].TECH;
				cData.onclick = function()
				{
					var code = this.code;
					showContactData(code);
				}

				var icons = [detail, cData];
			}
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,g,f,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// USERS TABLE
	if(tableId == "usersList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Nombre', list[i].NAME.replace("-", ""));
			var b = cellCreator('Tipo Id.', list[i].IDTYPE);
			var c = cellCreator('Número Id.', list[i].IDNUMBER);
			
			
			if(list[i].DOCFILE == "1")
			{
				if(list[i].PASSED == "1"){var userType = "Profesional aprobado";}
				else{var userType = "Profesional pendiente de aprobación";}
			}
			else
			{
				var userType = "Usuario cliente";
			}
			
			
			var ca = cellCreator('Tipo usuario.', userType);
			var jobs = getJobsResume(list[i].UCODE, list[i].JOBS)
			var created = jobs.created;
			var completed = jobs.completed;
			var canceled = jobs.canceled;
			var d = cellCreator('Creados', created);
			var e = cellCreator('Completados', completed);
			var f = cellCreator('Canceled', canceled);
		
			if(list[i].RATE != "")
			{
				
				var stars = ratedBoxTable(Math.round(list[i].RATE));
				
				if(list[i].RATE != "0")
				{
					var rate = stars;
				}
				else
				{
					var rate = stars;
				}
				
			}
			else
			{
				var rate = "Pendiente";
			}
			var g = cellCreator('Puntos', rate);
		
			var udata = faIcon(list[i],"user-plus","Datos de usuario","#70b4ef");
			udata.onclick = function ()
			{
				var code = this.reg.UCODE;
				showContactData(code);
			}
			
			var downId = faIcon(list[i],"id-card","Descargar documento identidad","#58eaad");
			downId.onclick = function()
			{
				actualUserCode = this.reg.UCODE;
				downFile("DocAD");
			}

			
			var downSop1 = faIcon(list[i],"folder-open","Descargar certificado 1","#eaa958");
			downSop1.onclick = function()
			{
				actualUserCode = this.reg.UCODE;
				downFile("SopAD1");
			}
			
			var downSop2 = faIcon(list[i],"folder-open","Descargar certificado 2","#94d067");
			downSop2.onclick = function()
			{
				actualUserCode = this.reg.UCODE;
				downFile("SopAD2");
			}
			
			var downSop3 = faIcon(list[i],"folder-open","Descargar certificado 3","#f16ce0");
			downSop3.onclick = function()
			{
				actualUserCode = this.reg.UCODE;
				downFile("SopAD3");
			}
			
			if(list[i].STATUS == "1"){var activeColor = "#fda73c";}
			else{var activeColor = "#aba1aa";}
			
			var del = faIcon(list[i],"eye","Cambiar estado",activeColor);	
			del.onclick = function()
			{
				var code = this.reg.UCODE;
				var type = "u";
				if(this.reg.STATUS == "1"){var state = "0";}
				else{var state = "1"}
				statusChange(code,type,state);
			}
			
			if(list[i].PASSED == "1"){var aprobeColor = "#d03cc4";}
			else{var aprobeColor = "#aba1aa";}
			var aprobe = faIcon(list[i],"check-circle","Aprobar profesional",aprobeColor);
			aprobe.onclick = function()
			{
				actualUserCode = this.reg.UCODE;
				
				if(this.reg.PASSED == "1"){var newState = "0";}
				else{var newState = "1";}
				
				var info = {};
				info.ucode = this.reg.UCODE;
				info.state = newState;
				info.name = this.reg.NAME;
				sendAjax("users","aprobePro",info,function(response)
				{
					var ans = response.message;
					
					if(info.state == "1")
					{
						alertBox(language["alert"], infoIcon+language["aprobed"]+info.name, 300);
					}
					else
					{
						alertBox(language["alert"], infoIcon+language["disprobed"]+info.name, 300);
					}

					listGet("users");
				});
				
			}
			
			if(list[i].DOCFILE == "1")
			{
				var icons = [udata,downId];
				
				if(list[i].SOPFILE1 == "1"){icons.push(downSop1);}
				if(list[i].SOPFILE2 == "1"){icons.push(downSop2);}
				if(list[i].SOPFILE3 == "1"){icons.push(downSop3);}
				
				
				icons.push(aprobe);
				
			}
			else
			{
				var icons = [udata];
			}
			icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,ca,d,e,f,g,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// WORKS ADMIN TABLE
	if(tableId == "worksListA")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var detail = encry(list[i].DETAIL);

			var a = cellCreator('Detalles', detail);
			var b = cellCreator('Creada', list[i].CREATED.split(" ")[0]);
			
			if(list[i].STATE == "0")
			{var state = "Nueva";}
			if(list[i].STATE == "1")
			{var state = "Asignada";}
			if(list[i].STATE == "2")
			{var state = "Calificada";}
			if(list[i].STATE == "3")
			{var state = "Cancelada";}
			
			var c = cellCreator('Estado', state);
			var d = cellCreator('Duración', list[i].DURATION);
			var e = cellCreator('Creado por',  list[i].AUTOR.split("-")[0]);
			
			if(list[i].TECHNAME != "")
			{
				var asigned = list[i].TECHNAME.split("-")[0];
			}
			else
			{
				var asigned = "Sin asignar";
			}
			
			var g = cellCreator('Asignado a',  asigned);

			if(list[i].RATE != "")
			{
				var stars = ratedBoxTable(list[i].RATE);
				var rate = list[i].RATE+stars;
			}
			else
			{
				var rate = "Pendiente";
				if(list[i].STATE == "3")
				{
					var rate = "Cancelado";
				}
			}
			var f = cellCreator('Calificación', rate);

			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "img/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualWorkCode = data.CODE;
				var base = window.location.href;
				var url = base+"?direct="+actualWorkCode;
				window.open(url,'_blank');
			}
			
			if(list[i].STATUS == "1"){var activeColor = "#fda73c";}
			else{var activeColor = "#aba1aa";}
			var del = faIcon(list[i],"eye","Cambiar estado",activeColor);	
			del.onclick = function()
			{
				var code = this.reg.CODE;
				var type = "w";
				if(this.reg.STATUS == "1"){var state = "0";}
				else{var state = "1"}
				statusChange(code,type,state);
			}
			
			var icons = [detail,del];

			
			var x = cellOptionsCreator('', icons)
			var cells = [e,a,b,c,f,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// PARTS ADMIN TABLE
	if(tableId == "partsListA")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Detalles', list[i].DETAIL);
			var b = cellCreator('Creada', list[i].CREATED.split(" ")[0]);
			
			if(list[i].STATE == "0")
			{var state = "Nueva";}
			if(list[i].STATE == "1")
			{var state = "Pendiente confirmación";}
			if(list[i].STATE == "2")
			{var state = "Vendido";}
			if(list[i].STATE == "3")
			{var state = "Cancelada";}
			
			var c = cellCreator('Estado', state);
			var d = cellCreator('Duración', list[i].DURATION);
			var e = cellCreator('Vendedor',  list[i].AUTOR.split("-")[0]);
			
			if(list[i].TECHNAME != "")
			{
				var asigned = list[i].TECHNAME.split("-")[0];
			}
			else
			{
				var asigned = "Sin asignar";
			}
			
			var g = cellCreator('Cliente',  asigned);
			var f = cellCreator('Precio', list[i].RPRICE);

			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "img/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualWorkCode = data.CODE;
				var base = window.location.href;
				var url = base+"?direct="+actualWorkCode;
				window.open(url,'_blank');
			}
			
			if(list[i].STATUS == "1"){var activeColor = "#fda73c";}
			else{var activeColor = "#aba1aa";}
			var del = faIcon(list[i],"eye","Cambiar estado",activeColor);	
			del.onclick = function()
			{
				var code = this.reg.CODE;
				var type = "p";
				if(this.reg.STATUS == "1"){var state = "0";}
				else{var state = "1"}
				statusChange(code,type,state);
			}
			
			var icons = [detail, del];

			
			var x = cellOptionsCreator('', icons)
			var cells = [b,c,a,e,g,f,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// COMMENTS TABLE
	if(tableId == "commentsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Autor', list[i].AUTOR.replace("-", ""));
			var b = cellCreator('Contenido', list[i].CONTENT);
			var c = cellCreator('Fecha', list[i].DATE);

			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.wcode = list[i].WORKCODE;
			detail.setAttribute('title', "Detalle de trabajo");
			detail.setAttribute('alt', "Detalle de trabajo");
			detail.src = "img/yesdesc.png";
			detail.onclick = function()
			{
				actualWorkCode = this.wcode;
				var base = window.location.href;
				var url = base+"?direct="+actualWorkCode;
				window.open(url,'_blank');
			}
			
			if(list[i].STATUS == "1"){var activeColor = "#fda73c";}
			else{var activeColor = "#aba1aa";}
			var del = faIcon(list[i],"eye","Cambiar estado",activeColor);	
			del.onclick = function()
			{
				var code = this.reg.CODE;
				var type = "c";
				if(this.reg.STATUS == "1"){var state = "0";}
				else{var state = "1"}
				statusChange(code,type,state);
			}
			
			
			var icons = [detail, del];
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// OFFERS TABLE
	if(tableId == "offersList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Autor', list[i].TECHNAME.replace("-", ""));
			var b = cellCreator('Contenido', list[i].COMMENTS);
			var c = cellCreator('Fecha', list[i].CREATED);
			if(list[i].STATE == "0")
			{var state = "Sin aceptar";}
			if(list[i].STATE == "1")
			{var state = "Seleccionada";}
			var d = cellCreator('Estado', state);
			var e = cellCreator('Valor', list[i].PRICE);
			var f = cellCreator('Comisión', list[i].RANSOM);

			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.wcode = list[i].WORKCODE;
			detail.setAttribute('title', "Detalle de trabajo");
			detail.setAttribute('alt', "Detalle de trabajo");
			detail.src = "img/yesdesc.png";
			
			detail.onclick = function()
			{
				var data = this.reg;
				showPropDetail(data);
			}
			
			var cData = document.createElement("img");
			cData.reg = list[i];
			cData.setAttribute('title', "Datos del profesional");
			cData.setAttribute('alt', "Datos del profesional");
			cData.src = "img/cIcon.png";
			cData.code = list[i].TECHCODE;
			cData.onclick = function()
			{
				var code = this.code;
				showContactData(code);
			}
			
			var wdetail = document.createElement("img");
			wdetail.reg = list[i];
			wdetail.wcode = list[i].WORKCODE;
			wdetail.setAttribute('title', "Detalle de trabajo");
			wdetail.setAttribute('alt', "Detalle de trabajo");
			wdetail.src = "img/infoIcon.png";
			wdetail.onclick = function()
			{
				actualWorkCode = this.wcode;
				var base = window.location.href;
				var url = base+"?direct="+actualWorkCode;
				window.open(url,'_blank');
			}
			

			var icons = [detail, cData, wdetail];
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,f,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// CATS TABLE
	if(tableId == "catsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var jobs = list[i].JOBS.length;
			
			var a = cellCreator('Nombre', list[i].DETAIL+" ("+jobs+")");
			
			if(list[i].TYPE == "0")
			{var type = "Principal";}
			if(list[i].TYPE == "1")
			{var type = "Sub categoría";}
			var b = cellCreator('Tipo', type);
			
			if(list[i].STATUS == "0")
			{var state = "No visible";}
			if(list[i].STATUS == "1")
			{var state = "Visible";}
			var c = cellCreator('Estado', state);

			var del = document.createElement("img");
			del.reg = list[i];
			del.code = list[i].CODE;
			del.setAttribute('title', "Eliminar");
			del.setAttribute('alt', "Eliminar");
			del.src = "img/delIcon.png";
			del.onclick = function()
			{
				actualCatCode = this.code;
				confirmBox("Confirmación de eliminación", "¿Desea eliminar esta categoría? No podrá deshacer esta operación.", killCat);
			}

			var icons = [del];
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}

}
function statusChange(code,type,state)
{
	var info = {};
	
	info.code = code;
	info.type = type;
	info.state = state;
	
	sendAjax("users","statusChange",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(info.type == "u"){var list = "users";}
		if(info.type == "w"){var list = "jobs";}
		if(info.type == "c"){var list = "comments";}
		if(info.type == "p"){var list = "parts";}
		
		
		if(info.state == "1")
		{
			alertBox(language["alert"], infoIcon+language["activated"], 300);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["deactivated"], 300);
		}
		
		listGet(list);
		
	});
}
function faIcon(data, css, label, color)
{
	var icon = document.createElement("i");
	icon.reg = data;
	icon.className = "fa fa-"+css+" tableIcon";
	icon.style.color = color;
	icon.setAttribute('title', label);
	icon.setAttribute('alt', label);
	return icon;
}
function explainRep()
{
	alertBox(language["alert"], language["explainRep"], 300);
}
function showPropDetail(data)
{
	console.log(data)
	var dText = "Autor: "+data.TECHNAME.replace("-", "")+"<br>"+
	"Detalles: "+data.COMMENTS+"<br>"+
	"Precio: "+data.PRICE+"<br>"+
	"Comisión: "+data.RANSOM+"<br>"+
	"Duración: "+data.WORKTIME+"<br>"+
	"Disponibilidad: "+data.AVAILABLE+"<br>"+
	"Garantía': "+data.GUARANTEE+"<br>"+
	"Ciudad: "+data.WORKLOCATION+"<br>";

	alertBox("Resumen de propuesta", dText, 300);

}
function setMains()
{
	var picker = document.getElementById("mainPicker");
	picker.innerHTML = "";
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Seleccione la categoría padre";
	picker.appendChild(option);
	
	var list = actualCats;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i]
		var option = document.createElement("option");
		option.value = item.CODE;
		option.innerHTML = item.DETAIL;
		if(item.TYPE == "1")
		{
			continue
		}
		else
		{
			picker.appendChild(option);
		}
		
	}
	
}
function createCat(type)
{
	if(type == "main")
	{
		showModal("mainCreateModal");
	}
	if(type == "sub")
	{
		setMains();
		showModal("subCreateModal");
	}
}
function saveCat(type)
{
	console.log(type)
	var info = {}
	if(type == "main")
	{
		info.type = type;
		info.catName = document.getElementById("mainField").value;
	}
	else
	{
		info.type = type;
		info.catParent = document.getElementById("mainPicker").value;
		info.catName = document.getElementById("subField").value;
	}
	
	sendAjax("users","saveCat",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		listGet("cats");
		hideModal("mainCreateModal");
		hideModal("subCreateModal");
		alertBox(language["alert"], infoIcon+language["savedCat"], 300);
	});
	
	
}
function getJobsResume(code, jobs)
{
	var list = jobs;
	
	var created = [];
	var completed = [];
	var canceled = [];

	for(var i=0; i<list.length; i++)
	{
		var item = list[i];

		if(item.AUTORCODE == code)
		{
			// CREADOS
			created.push(item);
		}
		else
		{
			if(item.STATE == "2")
			{
				// COMPLETADO
				completed.push(item);
			}
			if(item.STATE == "3")
			{
				// CANCELADO
				canceled.push(item);
			}
		}
	}
	
	
	var result = {};
	result.created = created.length;
	result.completed = completed.length;
	result.canceled = canceled.length;
	
	return result;
	
	
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
	console.log("2.5")
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
//END TABLES

// SPECIAL METHODS START ----------------------------
function confirmBox(title, question, method)
{
	var box = document.getElementById("confirmModal");
	var titleSpan = document.getElementById("confirmModalLabel");
	var questionSpan = document.getElementById("confirmQuestion");
	var button = document.getElementById("confirmButton");
	
	titleSpan.innerHTML = title;
	questionSpan.innerHTML = question
	button.onclick = function ()
	{
		method();
	}
	
	showModal("confirmModal");
	
}
function addCommas(nStr)
{
	nStr = parseFloat(nStr);
	
	var d = 0;
	var actualCurrency = "COP";
	
	if(actualCurrency == "COP")
	{
		d = 0;
		var currency = "";
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
	
	return currency + "" + nStr.toFixed(d).replace(/./g, function(c, i, a) 
	{
		return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	});

}
function passForgot()
{
	var mailField = document.getElementById("InputPassrec");
	mailField.value = "";
	showModal("pssRecModal");
}
function pssRecCheck()
{
	var mailField = document.getElementById("InputPassrec");
	var mail = mailField.value;
	var info = {};
	info.mail = mail;
	info.lang = lang;
	
	sendAjax("users","mailExist",info,function(response)
	{
		var ans = response.message;
		if(ans == "notsent")
		{
			alertBox(language["alert"], infoIcon+language["norRmail"]);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["mailRecSent"]);
			hideModal("pssRecModal");
			hideModal("LoginModal");
		}
	});
	
}
function register()
{
	var info = {};
	info.name = document.getElementById("rName").value+" - "+document.getElementById("rLastName").value;
	info.email = document.getElementById("rEmail").value;
	info.address = document.getElementById("rAddress").value;
	info.phone = document.getElementById("rPhone").value;
	info.pass1 = document.getElementById("rPassword1").value;
	info.pass2 = document.getElementById("rPassword2").value;
	info.pass = document.getElementById("rPassword1").value;
	info.idtype = document.getElementById("idType").value;
	info.idnumber = document.getElementById("idNumber").value;
	info.rLocation = document.getElementById("rLocation").value;
	info.isreging = "1";
	info.lang = lang;
	info.type = "0";
	
	if(!checkEmail(info.email))
	{
		alertBox(language["alert"], infoIcon+language["mustValidMailReg"]);
		return;
	}
	
	if(info.name == "" || info.email == "" || info.address == "" || info.phone == "" || info.idtype == "" || info.idnumber == "" || info.pass1 == "" || info.pass2 == "" || info.rLocation == "")
	{
		alertBox(language["alert"], infoIcon+language["mustFieldsReg"]);
		return;
	}
	
	if(info.pass1 != info.pass2)
	{
		alertBox(language["alert"], infoIcon+language["passMatch"]);
		return;
	}

	if(!document.getElementById("condsCheck").checked)
	{
		alertBox(language["alert"], infoIcon+language["mustCheck"]);
		return;
	}
	
	// info.email = "hvelez@incocrea.com";
	// info.pass = "Harolito2015";

	sendAjax("users","register",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(ans == "exists")
		{
			alertBox(language["alert"], infoIcon+language["userExist"]);
			return;
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["regSuccess"]);
			
			document.getElementById("loginUsername").value = info.email;
			document.getElementById("loginPassword").value = info.pass;
			document.getElementById("login-tab").click();
			
			localStorage.setItem("newGuy","1");
			
			setTimeout(function(){login();}, 5000);
		}
	});
}
function setRansom(value)
{
	
	var completedW = parseInt(actualExecuted);
	
	var base = value;
	base = base.replace(",", "");
	base = base.replace(".", "");
	base = base.replace("$", "");
	
	if(!isNumber(base))
	{
		alertBox(language["alert"], infoIcon+language["mustNumber"], 300);
		document.getElementById("price").value = "10000";
		return;
	}
	if(base < 10000)
	{
		alertBox(language["alert"], infoIcon+language["mustMinimum"], 300);
		document.getElementById("price").value = "10000";
		return;
	}
	// GET NUMBER OF SERVICES IF < 5 RAMSOM 0
	var percent = parseFloat(userData.RANSOM);
	var ransom = parseInt(base)*percent;
	document.getElementById("ransom").value = addCommas(ransom);	
	document.getElementById("totalPrice").value = addCommas(parseInt(base)+parseInt(ransom));
	
	if(completedW < 5)
	{
		document.getElementById("ransom").value = "0";
		document.getElementById("totalPrice").value = base;
	}
	
}
function saveOffer()
{
	var info = {};
	info.workCode = actualWorkCode;
	info.tech = userData.UCODE;
	info.techName = userData.NAME;
	info.detail = document.getElementById("comments").value;
	var base = document.getElementById("price").value;
	base = base.replace(",", "");
	base = base.replace(".", "");
	base = base.replace("$", "");
	
	info.price = base;
	
	var baseR = document.getElementById("ransom").value;
	baseR = baseR.replace(",", "");
	baseR = baseR.replace(".", "");
	baseR = baseR.replace("$", "");
	
	info.ransom = baseR;
	
	info.totalPrice = document.getElementById("totalPrice").value;
	info.avaDate = document.getElementById("avaDate").value;
	if(document.getElementById("wTimeDays").value == "1")
	{var days = "día";}
	else
	{var days = "días";}
	if(document.getElementById("wTimeHours").value == "1")
	{var hours = "hora";}
	else
	{var hours = "horas";}
	var wTime = document.getElementById("wTimeDays").value+" "+days+" y "+document.getElementById("wTimeHours").value+" "+hours;
	info.workTime = wTime;
	info.guarantee = document.getElementById("wGuarantee").value;
	info.wLocation = document.getElementById("wLocation").value;

	if(info.detail == "" || info.price == "" || info.ransom == "" || info.totalPrice == "" || info.avaDate == "" || info.workTime == "" || info.guarantee == "" || info.wLocation == "")
	{
		alertBox(language["alert"], infoIcon+language["mustFieldsProposal"]);
		return;
	}
	
	if(document.getElementById("wTimeDays").value == "0" && document.getElementById("wTimeHours").value == "0")
	{
		alertBox(language["alert"], infoIcon+language["invalidWT"]);
		return;
	}
	// console.log(info);
	// return
	sendAjax("users","postulate",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		if(ans == "full")
		{
			alertBox(language["alert"], infoIcon+language["postfull"]);
			return;
		}
		if(ans == "created")
		{
			alertBox(language["alert"], infoIcon+language["postualed"]);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["repostualed"]);
		}
		
		setTimeout(function()
		{
			loadWork(actualWorkCode);
		}, 3000);
	});
}
function saveOfferBuy()
{
	
	var info = {};
	info.workCode = actualWorkCode;
	info.tech = userData.UCODE;
	info.techName = userData.NAME;
	info.wLocation = userData.LOCATION;
	info.detail = document.getElementById("InputBuyDetail").value;
	
	var base = document.getElementById("InputBuyValue").value;
	base = base.replace(",", "");
	base = base.replace(".", "");
	base = base.replace("$", "");
	console.log(base)
	
	if(base == "")
	{
		alertBox(language["alert"], infoIcon+language["mustPriceProposal"]);
		return;
	}
	
	info.price = base;
	
	
	console.log(info);
	
	sendAjax("users","postulateBuy",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(ans == "full")
		{
			alertBox(language["alert"], infoIcon+language["postfullR"]);
			return;
		}
		if(ans == "created")
		{
			alertBox(language["alert"], infoIcon+language["postualedR"]);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["reoffered"]);
		}
		
		hideModal("buyOfferModal");
		
		setTimeout(function()
		{
			loadWork(actualWorkCode);
		}, 1000);
		
	});
}
function fillConds()
{
	var text = language["condsText"];
	var newtext = text.replaceAll("ctag", "Reparafull.com");
	document.getElementById("condsText").innerHTML = newtext;
}
function saveProfile(type)
{
	if(type == 1)
	{
		var info = {};
		info.name = document.getElementById("rName").value+" - "+document.getElementById("rLastName").value;
		info.email = document.getElementById("rEmail").value;
		info.rLocation = document.getElementById("rLocation").value;
		info.address = document.getElementById("rAddress").value;
		info.phone = document.getElementById("rPhone").value;
		info.idtype = document.getElementById("idType").value;
		info.idnumber = document.getElementById("idNumber").value;
		info.lang = lang;
		info.ucode = userData.UCODE;

		if(info.name == "" || info.email == "" || info.address == "" || info.phone == "" || info.idtype == "" || info.idnumber == "" || info.rLocation == "")
		{
			alertBox(language["alert"], infoIcon+language["mustFieldsReg"]);
			return;
		}
	}
	if(type == 2)
	{
		actualProCats.main = mainCatsPickedPro;
		actualProCats.sub = subCatsPickedPro;

		var info = {};
		info.ucode = userData.UCODE;
		info.resume = document.getElementById("proResume").value;
		info.cats = JSON.stringify(actualProCats);
		
		if(info.resume == "")
		{
			alertBox(language["alert"], infoIcon+language["mustResumeReg"]);
			return;
		}
		if(subCatsPickedPro.length == 0)
		{
			alertBox(language["alert"], infoIcon+language["mustSubcatReg"]);
			return;
		}
		// files check
		if(userData.DOCFILE == "0" || (userData.SOPFILE1 == "0" && userData.SOPFILE2 == "0" && userData.SOPFILE3 == "0"))
		{
			alertBox(language["alert"], infoIcon+language["mustFilesReg"]);
			return;
		}
		
		
		console.log(info);
	}
	
	info.type = type;
	
	sendAjax("users","saveProfile",info,function(response)
	{
		var ans = response.message;
		
		if(info.type == "1")
		{
			alertBox(language["alert"], infoIcon+language["profileSaved"]);
			
			userData.LOCATION = info.rLocation;
		}
		else if(info.type == "2" && userData.PASSED == "1")
		{
			alertBox(language["alert"], infoIcon+language["profileSaved"]);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["profileSavedPro"]);
		}
		
		setTimeout(function(){goHome()},3500);
		
		
	});
}
function setLocations(field)
{
	var list = locations;
	var ready = [];
	
	for(var i=0; i<list.length; i++)
	{
		var depto = list[i].departamento;
		
		var list2 = list[i].ciudades;
		
		for(var j=0; j<list2.length; j++)
		{
			var city = list2[j];
			
			var munip = city+" - "+depto;
			ready.push(munip);
		}
		
	}
	
	
	ready.sort();
	
	var list = ready;
	
	var places = [];

	for(var i=0; i<list.length; i++)
	{
		var pr = list[i];
		var desc = pr;
		
		desc = desc.toLowerCase();
		if(desc[0] == "-"){desc = desc.substring(1);}
		// desc = toPhrase(desc);
		places.push(desc);
	}
	
	// SET AUTOCOMPLETE FROM ARRAY
	
	if(field == "1")
	{
		$('#rLocation').typeahead('destroy');
		$('#rLocation').typeahead({fitToElement: false,source: places});
	}
	if(field == "2")
	{
		$('#rLocation').typeahead('destroy');
		$('#rLocation').typeahead({fitToElement: false,source: places});
	}
	if(field == "3")
	{
		$('#rLocation').typeahead('destroy');
		$('#rLocation').typeahead({fitToElement: false,source: places});
	}
	if(field == "4")
	{
		$('#locPicker').typeahead('destroy');
		$('#locPicker').typeahead({fitToElement: false,source: places});
	}
	if(field == "5")
	{
		$('#locPickerTop').typeahead('destroy');
		$('#locPickerTop').typeahead({fitToElement: false,source: places});
	}
	if(field == "6")
	{
		$('#jobsLocationF').typeahead('destroy');
		$('#jobsLocationF').typeahead({fitToElement: false,source: places});
		$('#partsLocationF').typeahead('destroy');
		$('#partsLocationF').typeahead({fitToElement: false,source: places});
	}
	

	
}
function addCssRule(css)
{
	if (style.styleSheet){style.styleSheet.cssText = css;}
	else{style.appendChild(document.createTextNode(css));}
	document.getElementsByTagName('head')[0].appendChild(style);
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
function sendAjax(obj, method, data, responseFunction, noLoader, asValue)
{
	 showLoader = 1;
	 comcount++;
	 // console.log(method);
	 // console.log(comcount);
	 if(!noLoader)
	 {
		setTimeout(function()
		{if(showLoader == 1){$("#loaderDiv").fadeIn();}},1000);}

	 // var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
	 var info = {};
	 info.class = obj;
	 info.method = method;
	 info.data = data;

	 if(imfoo == "recover")
	 {
		 curl = 'secure/libs/php/mentry.php';
	 }
	 else
	 {
		 curl = 'secure/libs/php/mentry.php';
	 }
	 
	$.ajax({
			type: 'POST',
			url: curl,
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
function alertBox(header, message, width)
{
	var tittle = document.getElementById("alertsBoxTitle");
	tittle.innerHTML = header;
	var content = document.getElementById("alertsBoxMessage");
	content.innerHTML = message;
	var accept = document.getElementById("acceptButton");
	accept.innerHTML = language["accept"];
	
	if(width != null)
	{
		document.getElementById("alertBoxBox").style.maxWidth  = width+"px";
	}
	else
	{
		document.getElementById("alertBoxBox").style.maxWidth  = "300px";
	}

	$("#alertsBox").modal("show");
}
function showModal(id)
{
	$("#"+id).modal("show");
}
function getNow(extra, dayonly)
{
	var currentdate = new Date(); 
	
	if(extra != null)
	{
		currentdate.setDate(currentdate.getDate() + (extra));
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
	
	if(dayonly != null)
	{
		var datetime =  year + "-" +  month + "-" + day;	
	}
	else
	{
		var datetime =  year + "-" +  month + "-" + day + " "  + hour + ":"  + minute + ":"  + second;	
	}

	return datetime;
}
function hideModal(id)
{
	$("#"+id).modal("hide");
}
function isNumber(n) 
{
  return !isNaN(parseFloat(n)) && isFinite(n);
}
var locations = [  
    {  
        "id":0,
        "departamento":"Amazonas",
        "ciudades":[  
            "Leticia",
            "Puerto Nari\u00f1o"
        ]
    },
    {  
        "id":1,
        "departamento":"Antioquia",
        "ciudades":[  
            "Abejorral",
            "Abriaqu\u00ed",
            "Alejandr\u00eda",
            "Amag\u00e1",
            "Amalfi",
            "Andes",
            "Angel\u00f3polis",
            "Angostura",
            "Anor\u00ed",
            "Anz\u00e1",
            "Apartad\u00f3",
            "Arboletes",
            "Argelia",
            "Armenia",
            "Barbosa",
            "Bello",
            "Belmira",
            "Betania",
            "Betulia",
            "Brice\u00f1o",
            "Buritic\u00e1",
            "C\u00e1ceres",
            "Caicedo",
            "Caldas",
            "Campamento",
            "Ca\u00f1asgordas",
            "Caracol\u00ed",
            "Caramanta",
            "Carepa",
            "Carolina del Pr\u00edncipe",
            "Caucasia",
            "Chigorod\u00f3",
            "Cisneros",
            "Ciudad Bol\u00edvar",
            "Cocorn\u00e1",
            "Concepci\u00f3n",
            "Concordia",
            "Copacabana",
            "Dabeiba",
            "Donmat\u00edas",
            "Eb\u00e9jico",
            "El Bagre",
            "El Carmen de Viboral",
            "El Pe\u00f1ol",
            "El Retiro",
            "El Santuario",
            "Entrerr\u00edos",
            "Envigado",
            "Fredonia",
            "Frontino",
            "Giraldo",
            "Girardota",
            "G\u00f3mez Plata",
            "Granada",
            "Guadalupe",
            "Guarne",
            "Guatap\u00e9",
            "Heliconia",
            "Hispania",
            "Itag\u00fc\u00ed",
            "Ituango",
            "Jard\u00edn",
            "Jeric\u00f3",
            "La Ceja",
            "La Estrella",
            "La Pintada",
            "La Uni\u00f3n",
            "Liborina",
            "Maceo",
            "Marinilla",
            "Medell\u00edn",
            "Montebello",
            "Murind\u00f3",
            "Mutat\u00e1",
            "Nari\u00f1o",
            "Nech\u00ed",
            "Necocl\u00ed",
            "Olaya",
            "Peque",
            "Pueblorrico",
            "Puerto Berr\u00edo",
            "Puerto Nare",
            "Puerto Triunfo",
            "Remedios",
            "Rionegro",
            "Sabanalarga",
            "Sabaneta",
            "Salgar",
            "San Andr\u00e9s de Cuerquia",
            "San Carlos",
            "San Francisco",
            "San Jer\u00f3nimo",
            "San Jos\u00e9 de la Monta\u00f1a",
            "San Juan de Urab\u00e1",
            "San Luis",
            "San Pedro de Urab\u00e1",
            "San Pedro de los Milagros",
            "San Rafael",
            "San Roque",
            "San Vicente",
            "Santa B\u00e1rbara",
            "Santa Fe de Antioquia",
            "Santa Rosa de Osos",
            "Santo Domingo",
            "Segovia",
            "Sons\u00f3n",
            "Sopetr\u00e1n",
            "T\u00e1mesis",
            "Taraz\u00e1",
            "Tarso",
            "Titirib\u00ed",
            "Toledo",
            "Turbo",
            "Uramita",
            "Urrao",
            "Valdivia",
            "Valpara\u00edso",
            "Vegach\u00ed",
            "Venecia",
            "Vig\u00eda del Fuerte",
            "Yal\u00ed",
            "Yarumal",
            "Yolomb\u00f3",
            "Yond\u00f3",
            "Zaragoza"
        ]
    },
    {  
        "id":2,
        "departamento":"Arauca",
        "ciudades":[  
            "Arauca",
            "Arauquita",
            "Cravo Norte",
            "Fortul",
            "Puerto Rond\u00f3n",
            "Saravena",
            "Tame"
        ]
    },
    {  
        "id":3,
        "departamento":"Atl\u00e1ntico",
        "ciudades":[  
            "Baranoa",
            "Barranquilla",
            "Campo de la Cruz",
            "Candelaria",
            "Galapa",
            "Juan de Acosta",
            "Luruaco",
            "Malambo",
            "Manat\u00ed",
            "Palmar de Varela",
            "Pioj\u00f3",
            "Polonuevo",
            "Ponedera",
            "Puerto Colombia",
            "Repel\u00f3n",
            "Sabanagrande",
            "Sabanalarga",
            "Santa Luc\u00eda",
            "Santo Tom\u00e1s",
            "Soledad",
            "Su\u00e1n",
            "Tubar\u00e1",
            "Usiacur\u00ed"
        ]
    },
    {  
        "id":4,
        "departamento":"Bol\u00edvar",
        "ciudades":[  
            "Ach\u00ed",
            "Altos del Rosario",
            "Arenal",
            "Arjona",
            "Arroyohondo",
            "Barranco de Loba",
            "Brazuelo de Papayal",
            "Calamar",
            "Cantagallo",
            "Cartagena de Indias",
            "Cicuco",
            "Clemencia",
            "C\u00f3rdoba",
            "El Carmen de Bol\u00edvar",
            "El Guamo",
            "El Pe\u00f1\u00f3n",
            "Hatillo de Loba",
            "Magangu\u00e9",
            "Mahates",
            "Margarita",
            "Mar\u00eda la Baja",
            "Momp\u00f3s",
            "Montecristo",
            "Morales",
            "Noros\u00ed",
            "Pinillos",
            "Regidor",
            "R\u00edo Viejo",
            "San Crist\u00f3bal",
            "San Estanislao",
            "San Fernando",
            "San Jacinto del Cauca",
            "San Jacinto",
            "San Juan Nepomuceno",
            "San Mart\u00edn de Loba",
            "San Pablo",
            "Santa Catalina",
            "Santa Rosa",
            "Santa Rosa del Sur",
            "Simit\u00ed",
            "Soplaviento",
            "Talaigua Nuevo",
            "Tiquisio",
            "Turbaco",
            "Turban\u00e1",
            "Villanueva",
            "Zambrano"
        ]
    },
    {  
        "id":5,
        "departamento":"Boyac\u00e1",
        "ciudades":[  
            "Almeida",
            "Aquitania",
            "Arcabuco",
            "Bel\u00e9n",
            "Berbeo",
            "Bet\u00e9itiva",
            "Boavita",
            "Boyac\u00e1",
            "Brice\u00f1o",
            "Buenavista",
            "Busbanz\u00e1",
            "Caldas",
            "Campohermoso",
            "Cerinza",
            "Chinavita",
            "Chiquinquir\u00e1",
            "Ch\u00edquiza",
            "Chiscas",
            "Chita",
            "Chitaraque",
            "Chivat\u00e1",
            "Chivor",
            "Ci\u00e9nega",
            "C\u00f3mbita",
            "Coper",
            "Corrales",
            "Covarach\u00eda",
            "Cubar\u00e1",
            "Cucaita",
            "Cu\u00edtiva",
            "Duitama",
            "El Cocuy",
            "El Espino",
            "Firavitoba",
            "Floresta",
            "Gachantiv\u00e1",
            "G\u00e1meza",
            "Garagoa",
            "Guacamayas",
            "Guateque",
            "Guayat\u00e1",
            "G\u00fcic\u00e1n",
            "Iza",
            "Jenesano",
            "Jeric\u00f3",
            "La Capilla",
            "La Uvita",
            "La Victoria",
            "Labranzagrande",
            "Macanal",
            "Marip\u00ed",
            "Miraflores",
            "Mongua",
            "Mongu\u00ed",
            "Moniquir\u00e1",
            "Motavita",
            "Muzo",
            "Nobsa",
            "Nuevo Col\u00f3n",
            "Oicat\u00e1",
            "Otanche",
            "Pachavita",
            "P\u00e1ez",
            "Paipa",
            "Pajarito",
            "Panqueba",
            "Pauna",
            "Paya",
            "Paz del R\u00edo",
            "Pesca",
            "Pisba",
            "Puerto Boyac\u00e1",
            "Qu\u00edpama",
            "Ramiriqu\u00ed",
            "R\u00e1quira",
            "Rond\u00f3n",
            "Saboy\u00e1",
            "S\u00e1chica",
            "Samac\u00e1",
            "San Eduardo",
            "San Jos\u00e9 de Pare",
            "San Luis de Gaceno",
            "San Mateo",
            "San Miguel de Sema",
            "San Pablo de Borbur",
            "Santa Mar\u00eda",
            "Santa Rosa de Viterbo",
            "Santa Sof\u00eda",
            "Santana",
            "Sativanorte",
            "Sativasur",
            "Siachoque",
            "Soat\u00e1",
            "Socha",
            "Socot\u00e1",
            "Sogamoso",
            "Somondoco",
            "Sora",
            "Sorac\u00e1",
            "Sotaquir\u00e1",
            "Susac\u00f3n",
            "Sutamarch\u00e1n",
            "Sutatenza",
            "Tasco",
            "Tenza",
            "Tiban\u00e1",
            "Tibasosa",
            "Tinjac\u00e1",
            "Tipacoque",
            "Toca",
            "Tog\u00fc\u00ed",
            "T\u00f3paga",
            "Tota",
            "Tunja",
            "Tunungu\u00e1",
            "Turmequ\u00e9",
            "Tuta",
            "Tutaz\u00e1",
            "\u00dambita",
            "Ventaquemada",
            "Villa de Leyva",
            "Viracach\u00e1",
            "Zetaquira"
        ]
    },
    {  
        "id":6,
        "departamento":"Caldas",
        "ciudades":[  
            "Aguadas",
            "Anserma",
            "Aranzazu",
            "Belalc\u00e1zar",
            "Chinchin\u00e1",
            "Filadelfia",
            "La Dorada",
            "La Merced",
            "Manizales",
            "Manzanares",
            "Marmato",
            "Marquetalia",
            "Marulanda",
            "Neira",
            "Norcasia",
            "P\u00e1cora",
            "Palestina",
            "Pensilvania",
            "Riosucio",
            "Risaralda",
            "Salamina",
            "Saman\u00e1",
            "San Jos\u00e9",
            "Sup\u00eda",
            "Victoria",
            "Villamar\u00eda",
            "Viterbo"
        ]
    },
    {  
        "id":7,
        "departamento":"Caquet\u00e1",
        "ciudades":[  
            "Albania",
            "Bel\u00e9n de los Andaqu\u00edes",
            "Cartagena del Chair\u00e1",
            "Curillo",
            "El Doncello",
            "El Paujil",
            "Florencia",
            "La Monta\u00f1ita",
            "Mil\u00e1n",
            "Morelia",
            "Puerto Rico",
            "San Jos\u00e9 del Fragua",
            "San Vicente del Cagu\u00e1n",
            "Solano",
            "Solita",
            "Valpara\u00edso"
        ]
    },
    {  
        "id":8,
        "departamento":"Casanare",
        "ciudades":[  
            "Aguazul",
            "Ch\u00e1meza",
            "Hato Corozal",
            "La Salina",
            "Man\u00ed",
            "Monterrey",
            "Nunch\u00eda",
            "Orocu\u00e9",
            "Paz de Ariporo",
            "Pore",
            "Recetor",
            "Sabanalarga",
            "S\u00e1cama",
            "San Luis de Palenque",
            "T\u00e1mara",
            "Tauramena",
            "Trinidad",
            "Villanueva",
            "Yopal"
        ]
    },
    {  
        "id":9,
        "departamento":"Cauca",
        "ciudades":[  
            "Almaguer",
            "Argelia",
            "Balboa",
            "Bol\u00edvar",
            "Buenos Aires",
            "Cajib\u00edo",
            "Caldono",
            "Caloto",
            "Corinto",
            "El Tambo",
            "Florencia",
            "Guachen\u00e9",
            "Guap\u00ed",
            "Inz\u00e1",
            "Jambal\u00f3",
            "La Sierra",
            "La Vega",
            "L\u00f3pez de Micay",
            "Mercaderes",
            "Miranda",
            "Morales",
            "Padilla",
            "P\u00e1ez",
            "Pat\u00eda",
            "Piamonte",
            "Piendam\u00f3",
            "Popay\u00e1n",
            "Puerto Tejada",
            "Purac\u00e9",
            "Rosas",
            "San Sebasti\u00e1n",
            "Santa Rosa",
            "Santander de Quilichao",
            "Silvia",
            "Sotar\u00e1",
            "Su\u00e1rez",
            "Sucre",
            "Timb\u00edo",
            "Timbiqu\u00ed",
            "Torib\u00edo",
            "Totor\u00f3",
            "Villa Rica"
        ]
    },
    {  
        "id":10,
        "departamento":"Cesar",
        "ciudades":[  
            "Aguachica",
            "Agust\u00edn Codazzi",
            "Astrea",
            "Becerril",
            "Bosconia",
            "Chimichagua",
            "Chiriguan\u00e1",
            "Curuman\u00ed",
            "El Copey",
            "El Paso",
            "Gamarra",
            "Gonz\u00e1lez",
            "La Gloria (Cesar)",
            "La Jagua de Ibirico",
            "La Paz",
            "Manaure Balc\u00f3n del Cesar",
            "Pailitas",
            "Pelaya",
            "Pueblo Bello",
            "R\u00edo de Oro",
            "San Alberto",
            "San Diego",
            "San Mart\u00edn",
            "Tamalameque",
            "Valledupar"
        ]
    },
    {  
        "id":11,
        "departamento":"Choc\u00f3",
        "ciudades":[  
            "Acand\u00ed",
            "Alto Baud\u00f3",
            "Bagad\u00f3",
            "Bah\u00eda Solano",
            "Bajo Baud\u00f3",
            "Bojay\u00e1",
            "Cant\u00f3n de San Pablo",
            "C\u00e9rtegui",
            "Condoto",
            "El Atrato",
            "El Carmen de Atrato",
            "El Carmen del Dari\u00e9n",
            "Istmina",
            "Jurad\u00f3",
            "Litoral de San Juan",
            "Llor\u00f3",
            "Medio Atrato",
            "Medio Baud\u00f3",
            "Medio San Juan",
            "N\u00f3vita",
            "Nuqu\u00ed",
            "Quibd\u00f3",
            "R\u00edo Ir\u00f3",
            "R\u00edo Quito",
            "Riosucio",
            "San Jos\u00e9 del Palmar",
            "Sip\u00ed",
            "Tad\u00f3",
            "Uni\u00f3n Panamericana",
            "Ungu\u00eda"
        ]
    },
    {  
        "id":12,
        "departamento":"Cundinamarca",
        "ciudades":[  
            "Agua de Dios",
            "Alb\u00e1n",
            "Anapoima",
            "Anolaima",
            "Apulo",
            "Arbel\u00e1ez",
            "Beltr\u00e1n",
            "Bituima",
            "Bogot\u00e1",
            "Bojac\u00e1",
            "Cabrera",
            "Cachipay",
            "Cajic\u00e1",
            "Caparrap\u00ed",
            "C\u00e1queza",
            "Carmen de Carupa",
            "Chaguan\u00ed",
            "Ch\u00eda",
            "Chipaque",
            "Choach\u00ed",
            "Chocont\u00e1",
            "Cogua",
            "Cota",
            "Cucunub\u00e1",
            "El Colegio",
            "El Pe\u00f1\u00f3n",
            "El Rosal",
            "Facatativ\u00e1",
            "F\u00f3meque",
            "Fosca",
            "Funza",
            "F\u00faquene",
            "Fusagasug\u00e1",
            "Gachal\u00e1",
            "Gachancip\u00e1",
            "Gachet\u00e1",
            "Gama",
            "Girardot",
            "Granada",
            "Guachet\u00e1",
            "Guaduas",
            "Guasca",
            "Guataqu\u00ed",
            "Guatavita",
            "Guayabal de S\u00edquima",
            "Guayabetal",
            "Guti\u00e9rrez",
            "Jerusal\u00e9n",
            "Jun\u00edn",
            "La Calera",
            "La Mesa",
            "La Palma",
            "La Pe\u00f1a",
            "La Vega",
            "Lenguazaque",
            "Machet\u00e1",
            "Madrid",
            "Manta",
            "Medina",
            "Mosquera",
            "Nari\u00f1o",
            "Nemoc\u00f3n",
            "Nilo",
            "Nimaima",
            "Nocaima",
            "Pacho",
            "Paime",
            "Pandi",
            "Paratebueno",
            "Pasca",
            "Puerto Salgar",
            "Pul\u00ed",
            "Quebradanegra",
            "Quetame",
            "Quipile",
            "Ricaurte",
            "San Antonio del Tequendama",
            "San Bernardo",
            "San Cayetano",
            "San Francisco",
            "San Juan de Rioseco",
            "Sasaima",
            "Sesquil\u00e9",
            "Sibat\u00e9",
            "Silvania",
            "Simijaca",
            "Soacha",
            "Subachoque",
            "Suesca",
            "Supat\u00e1",
            "Susa",
            "Sutatausa",
            "Tabio",
            "Tausa",
            "Tena",
            "Tenjo",
            "Tibacuy",
            "Tibirita",
            "Tocaima",
            "Tocancip\u00e1",
            "Topaip\u00ed",
            "Ubal\u00e1",
            "Ubaque",
            "Ubat\u00e9",
            "Une",
            "\u00datica",
            "Venecia",
            "Vergara",
            "Vian\u00ed",
            "Villag\u00f3mez",
            "Villapinz\u00f3n",
            "Villeta",
            "Viot\u00e1",
            "Yacop\u00ed",
            "Zipac\u00f3n",
            "Zipaquir\u00e1"
        ]
    },
    {  
        "id":13,
        "departamento":"C\u00f3rdoba",
        "ciudades":[  
            "Ayapel",
            "Buenavista",
            "Canalete",
            "Ceret\u00e9",
            "Chim\u00e1",
            "Chin\u00fa",
            "Ci\u00e9naga de Oro",
            "Cotorra",
            "La Apartada",
            "Lorica",
            "Los C\u00f3rdobas",
            "Momil",
            "Montel\u00edbano",
            "Monter\u00eda",
            "Mo\u00f1itos",
            "Planeta Rica",
            "Pueblo Nuevo",
            "Puerto Escondido",
            "Puerto Libertador",
            "Pur\u00edsima",
            "Sahag\u00fan",
            "San Andr\u00e9s de Sotavento",
            "San Antero",
            "San Bernardo del Viento",
            "San Carlos",
            "San Jos\u00e9 de Ur\u00e9",
            "San Pelayo",
            "Tierralta",
            "Tuch\u00edn",
            "Valencia"
        ]
    },
    {  
        "id":14,
        "departamento":"Guain\u00eda",
        "ciudades":[  
            "In\u00edrida"
        ]
    },
    {  
        "id":15,
        "departamento":"Guaviare",
        "ciudades":[  
            "Calamar",
            "El Retorno",
            "Miraflores",
            "San Jos\u00e9 del Guaviare"
        ]
    },
    {  
        "id":16,
        "departamento":"Huila",
        "ciudades":[  
            "Acevedo",
            "Agrado",
            "Aipe",
            "Algeciras",
            "Altamira",
            "Baraya",
            "Campoalegre",
            "Colombia",
            "El Pital",
            "El\u00edas",
            "Garz\u00f3n",
            "Gigante",
            "Guadalupe",
            "Hobo",
            "\u00cdquira",
            "Isnos",
            "La Argentina",
            "La Plata",
            "N\u00e1taga",
            "Neiva",
            "Oporapa",
            "Paicol",
            "Palermo",
            "Palestina",
            "Pitalito",
            "Rivera",
            "Saladoblanco",
            "San Agust\u00edn",
            "Santa Mar\u00eda",
            "Suaza",
            "Tarqui",
            "Tello",
            "Teruel",
            "Tesalia",
            "Timan\u00e1",
            "Villavieja",
            "Yaguar\u00e1"
        ]
    },
    {  
        "id":17,
        "departamento":"La Guajira",
        "ciudades":[  
            "Albania",
            "Barrancas",
            "Dibulla",
            "Distracci\u00f3n",
            "El Molino",
            "Fonseca",
            "Hatonuevo",
            "La Jagua del Pilar",
            "Maicao",
            "Manaure",
            "Riohacha",
            "San Juan del Cesar",
            "Uribia",
            "Urumita",
            "Villanueva"
        ]
    },
    {  
        "id":18,
        "departamento":"Magdalena",
        "ciudades":[  
            "Algarrobo",
            "Aracataca",
            "Ariguan\u00ed",
            "Cerro de San Antonio",
            "Chibolo",
            "Chibolo",
            "Ci\u00e9naga",
            "Concordia",
            "El Banco",
            "El Pi\u00f1\u00f3n",
            "El Ret\u00e9n",
            "Fundaci\u00f3n",
            "Guamal",
            "Nueva Granada",
            "Pedraza",
            "Piji\u00f1o del Carmen",
            "Pivijay",
            "Plato",
            "Pueblo Viejo",
            "Remolino",
            "Sabanas de San \u00c1ngel",
            "Salamina",
            "San Sebasti\u00e1n de Buenavista",
            "San Zen\u00f3n",
            "Santa Ana",
            "Santa B\u00e1rbara de Pinto",
            "Santa Marta",
            "Sitionuevo",
            "Tenerife",
            "Zapay\u00e1n",
            "Zona Bananera"
        ]
    },
    {  
        "id":19,
        "departamento":"Meta",
        "ciudades":[  
            "Acac\u00edas",
            "Barranca de Up\u00eda",
            "Cabuyaro",
            "Castilla la Nueva",
            "Cubarral",
            "Cumaral",
            "El Calvario",
            "El Castillo",
            "El Dorado",
            "Fuente de Oro",
            "Granada",
            "Guamal",
            "La Macarena",
            "La Uribe",
            "Lejan\u00edas",
            "Mapirip\u00e1n",
            "Mesetas",
            "Puerto Concordia",
            "Puerto Gait\u00e1n",
            "Puerto Lleras",
            "Puerto L\u00f3pez",
            "Puerto Rico",
            "Restrepo",
            "San Carlos de Guaroa",
            "San Juan de Arama",
            "San Juanito",
            "San Mart\u00edn",
            "Villavicencio",
            "Vista Hermosa"
        ]
    },
    {  
        "id":20,
        "departamento":"Nari\u00f1o",
        "ciudades":[  
            "Aldana",
            "Ancuy\u00e1",
            "Arboleda",
            "Barbacoas",
            "Bel\u00e9n",
            "Buesaco",
            "Chachag\u00fc\u00ed",
            "Col\u00f3n",
            "Consac\u00e1",
            "Contadero",
            "C\u00f3rdoba",
            "Cuaspud",
            "Cumbal",
            "Cumbitara",
            "El Charco",
            "El Pe\u00f1ol",
            "El Rosario",
            "El Tabl\u00f3n",
            "El Tambo",
            "Francisco Pizarro",
            "Funes",
            "Guachucal",
            "Guaitarilla",
            "Gualmat\u00e1n",
            "Iles",
            "Imu\u00e9s",
            "Ipiales",
            "La Cruz",
            "La Florida",
            "La Llanada",
            "La Tola",
            "La Uni\u00f3n",
            "Leiva",
            "Linares",
            "Los Andes",
            "Mag\u00fc\u00ed Pay\u00e1n",
            "Mallama",
            "Mosquera",
            "Nari\u00f1o",
            "Olaya Herrera",
            "Ospina",
            "Pasto",
            "Policarpa",
            "Potos\u00ed",
            "Providencia",
            "Puerres",
            "Pupiales",
            "Ricaurte",
            "Roberto Pay\u00e1n",
            "Samaniego",
            "San Bernardo",
            "San Jos\u00e9 de Alb\u00e1n",
            "San Lorenzo",
            "San Pablo",
            "San Pedro de Cartago",
            "Sandon\u00e1",
            "Santa B\u00e1rbara",
            "Santacruz",
            "Sapuyes",
            "Taminango",
            "Tangua",
            "Tumaco",
            "T\u00faquerres",
            "Yacuanquer"
        ]
    },
    {  
        "id":21,
        "departamento":"Norte de Santander",
        "ciudades":[  
            "\u00c1brego",
            "Arboledas",
            "Bochalema",
            "Bucarasica",
            "C\u00e1chira",
            "C\u00e1cota",
            "Chin\u00e1cota",
            "Chitag\u00e1",
            "Convenci\u00f3n",
            "C\u00facuta",
            "Cucutilla",
            "Duran\u00eda",
            "El Carmen",
            "El Tarra",
            "El Zulia",
            "Gramalote",
            "Hacar\u00ed",
            "Herr\u00e1n",
            "La Esperanza",
            "La Playa de Bel\u00e9n",
            "Labateca",
            "Los Patios",
            "Lourdes",
            "Mutiscua",
            "Oca\u00f1a",
            "Pamplona",
            "Pamplonita",
            "Puerto Santander",
            "Ragonvalia",
            "Salazar de Las Palmas",
            "San Calixto",
            "San Cayetano",
            "Santiago",
            "Santo Domingo de Silos",
            "Sardinata",
            "Teorama",
            "Tib\u00fa",
            "Toledo",
            "Villa Caro",
            "Villa del Rosario"
        ]
    },
    {  
        "id":22,
        "departamento":"Putumayo",
        "ciudades":[  
            "Col\u00f3n",
            "Mocoa",
            "Orito",
            "Puerto As\u00eds",
            "Puerto Caicedo",
            "Puerto Guzm\u00e1n",
            "Puerto Legu\u00edzamo",
            "San Francisco",
            "San Miguel",
            "Santiago",
            "Sibundoy",
            "Valle del Guamuez",
            "Villagarz\u00f3n"
        ]
    },
    {  
        "id":23,
        "departamento":"Quind\u00edo",
        "ciudades":[  
            "Armenia",
            "Buenavista",
            "Calarc\u00e1",
            "Circasia",
            "C\u00f3rdoba",
            "Filandia",
            "G\u00e9nova",
            "La Tebaida",
            "Montenegro",
            "Pijao",
            "Quimbaya",
            "Salento"
        ]
    },
    {  
        "id":24,
        "departamento":"Risaralda",
        "ciudades":[  
            "Ap\u00eda",
            "Balboa",
            "Bel\u00e9n de Umbr\u00eda",
            "Dosquebradas",
            "Gu\u00e1tica",
            "La Celia",
            "La Virginia",
            "Marsella",
            "Mistrat\u00f3",
            "Pereira",
            "Pueblo Rico",
            "Quinch\u00eda",
            "Santa Rosa de Cabal",
            "Santuario"
        ]
    },
    {  
        "id":25,
        "departamento":"San Andr\u00e9s y Providencia",
        "ciudades":[  
            "Providencia y Santa Catalina Islas",
            "San Andr\u00e9s"
        ]
    },
    {  
        "id":26,
        "departamento":"Santander",
        "ciudades":[  
            "Aguada",
            "Albania",
            "Aratoca",
            "Barbosa",
            "Barichara",
            "Barrancabermeja",
            "Betulia",
            "Bol\u00edvar",
            "Bucaramanga",
            "Cabrera",
            "California",
            "Capitanejo",
            "Carcas\u00ed",
            "Cepit\u00e1",
            "Cerrito",
            "Charal\u00e1",
            "Charta",
            "Chima",
            "Chipat\u00e1",
            "Cimitarra",
            "Concepci\u00f3n",
            "Confines",
            "Contrataci\u00f3n",
            "Coromoro",
            "Curit\u00ed",
            "El Carmen de Chucur\u00ed",
            "El Guacamayo",
            "El Pe\u00f1\u00f3n",
            "El Play\u00f3n",
            "El Socorro",
            "Encino",
            "Enciso",
            "Flori\u00e1n",
            "Floridablanca",
            "Gal\u00e1n",
            "G\u00e1mbita",
            "Gir\u00f3n",
            "Guaca",
            "Guadalupe",
            "Guapot\u00e1",
            "Guavat\u00e1",
            "G\u00fcepsa",
            "Hato",
            "Jes\u00fas Mar\u00eda",
            "Jord\u00e1n",
            "La Belleza",
            "La Paz",
            "Land\u00e1zuri",
            "Lebrija",
            "Los Santos",
            "Macaravita",
            "M\u00e1laga",
            "Matanza",
            "Mogotes",
            "Molagavita",
            "Ocamonte",
            "Oiba",
            "Onzaga",
            "Palmar",
            "Palmas del Socorro",
            "P\u00e1ramo",
            "Piedecuesta",
            "Pinchote",
            "Puente Nacional",
            "Puerto Parra",
            "Puerto Wilches",
            "Rionegro",
            "Sabana de Torres",
            "San Andr\u00e9s",
            "San Benito",
            "San Gil",
            "San Joaqu\u00edn",
            "San Jos\u00e9 de Miranda",
            "San Miguel",
            "San Vicente de Chucur\u00ed",
            "Santa B\u00e1rbara",
            "Santa Helena del Op\u00f3n",
            "Simacota",
            "Suaita",
            "Sucre",
            "Surat\u00e1",
            "Tona",
            "Valle de San Jos\u00e9",
            "V\u00e9lez",
            "Vetas",
            "Villanueva",
            "Zapatoca"
        ]
    },
    {  
        "id":27,
        "departamento":"Sucre",
        "ciudades":[  
            "Buenavista",
            "Caimito",
            "Chal\u00e1n",
            "Colos\u00f3",
            "Corozal",
            "Cove\u00f1as",
            "El Roble",
            "Galeras",
            "Guaranda",
            "La Uni\u00f3n",
            "Los Palmitos",
            "Majagual",
            "Morroa",
            "Ovejas",
            "Sampu\u00e9s",
            "San Antonio de Palmito",
            "San Benito Abad",
            "San Juan de Betulia",
            "San Marcos",
            "San Onofre",
            "San Pedro",
            "Sinc\u00e9",
            "Sincelejo",
            "Sucre",
            "Tol\u00fa",
            "Tol\u00fa Viejo"
        ]
    },
    {  
        "id":28,
        "departamento":"Tolima",
        "ciudades":[  
            "Alpujarra",
            "Alvarado",
            "Ambalema",
            "Anzo\u00e1tegui",
            "Armero",
            "Ataco",
            "Cajamarca",
            "Carmen de Apical\u00e1",
            "Casabianca",
            "Chaparral",
            "Coello",
            "Coyaima",
            "Cunday",
            "Dolores",
            "El Espinal",
            "Fal\u00e1n",
            "Flandes",
            "Fresno",
            "Guamo",
            "Herveo",
            "Honda",
            "Ibagu\u00e9",
            "Icononzo",
            "L\u00e9rida",
            "L\u00edbano",
            "Mariquita",
            "Melgar",
            "Murillo",
            "Natagaima",
            "Ortega",
            "Palocabildo",
            "Piedras",
            "Planadas",
            "Prado",
            "Purificaci\u00f3n",
            "Rioblanco",
            "Roncesvalles",
            "Rovira",
            "Salda\u00f1a",
            "San Antonio",
            "San Luis",
            "Santa Isabel",
            "Su\u00e1rez",
            "Valle de San Juan",
            "Venadillo",
            "Villahermosa",
            "Villarrica"
        ]
    },
    {  
        "id":29,
        "departamento":"Valle del Cauca",
        "ciudades":[  
            "Alcal\u00e1",
            "Andaluc\u00eda",
            "Ansermanuevo",
            "Argelia",
            "Bol\u00edvar",
            "Buenaventura",
            "Buga",
            "Bugalagrande",
            "Caicedonia",
            "Cali",
            "Calima",
            "Candelaria",
            "Cartago",
            "Dagua",
            "El \u00c1guila",
            "El Cairo",
            "El Cerrito",
            "El Dovio",
            "Florida",
            "Ginebra",
            "Guacar\u00ed",
            "Jamund\u00ed",
            "La Cumbre",
            "La Uni\u00f3n",
            "La Victoria",
            "Obando",
            "Palmira",
            "Pradera",
            "Restrepo",
            "Riofr\u00edo",
            "Roldanillo",
            "San Pedro",
            "Sevilla",
            "Toro",
            "Trujillo",
            "Tulu\u00e1",
            "Ulloa",
            "Versalles",
            "Vijes",
            "Yotoco",
            "Yumbo",
            "Zarzal"
        ]
    },
    {  
        "id":30,
        "departamento":"Vaup\u00e9s",
        "ciudades":[  
            "Carur\u00fa",
            "Mit\u00fa",
            "Taraira"
        ]
    },
    {  
        "id":31,
        "departamento":"Vichada",
        "ciudades":[  
            "Cumaribo",
            "La Primavera",
            "Puerto Carre\u00f1o",
            "Santa Rosal\u00eda"
        ]
    }
];

// UPOLOAD FILE MANAGEMENT METHODS
function loadFileClick(type)
{
	
	if(document.getElementById("proResume").value == "")
	{
		alertBox(language["alert"], infoIcon+language["mustResumeReg"]);
		return;
	}
	if(subCatsPickedPro.length == 0)
	{
		alertBox(language["alert"], infoIcon+language["mustSubcatReg"]);
		return;
	}

	var picker = document.getElementById("upFileSelector");
	actualLoadType = type;
	actualLoadCode = userData.UCODE;
	picker.name = actualLoadType+"-"+userData.UCODE+"[]";
	picker.click();
}
function downFile(type)
{
	
	console.log(type)
	
	if(type == "Doc"){var url = "files/"+userData.UCODE+"-doc/Documento.jpg";}
	if(type == "DocAD"){var url = "files/"+actualUserCode+"-doc/Documento.jpg";}
	if(type == "Sop1"){var url = "files/"+userData.UCODE+"-sop1/Certificado 1.jpg";}
	if(type == "Sop2"){var url = "files/"+userData.UCODE+"-sop2/Certificado 2.jpg";}
	if(type == "Sop3"){var url = "files/"+userData.UCODE+"-sop3/Certificado 3.jpg";}
	if(type == "SopAD1"){var url = "files/"+actualUserCode+"-sop1/Certificado 1.jpg";}
	if(type == "SopAD2"){var url = "files/"+actualUserCode+"-sop2/Certificado 2.jpg";}
	if(type == "SopAD3"){var url = "files/"+actualUserCode+"-sop3/Certificado 3.jpg";}
	document.getElementById('downframe').setAttribute("href", decry(url));
	document.getElementById('downframe').click();
}
function handleFile(evt) 
{
	var files = evt.target.files; // FileList object
	var pickSelector = document.getElementById('upFileSelector');
	loadFileName = files[0].name;
	if(files.length > 1)
	{
		alertBox(language["alert"], infoIcon+language["justOneFile"], 300);
		pickBox.innerHTML = "";
		pickSelector.value = "";
		return;
	}
	for (var i = 0; i < files.length; i++) 
	{
		var f = files[i];
		
		// TYPE IMAGE CHECK
		if(actualLoadType == "Doc" || actualLoadType == "Sop1" || actualLoadType == "Sop2" || actualLoadType == "Sop3")
		{
			var fileSize = files[i].size/1024; 
			console.log(fileSize);
			if(parseInt(fileSize) > 20000)
			{
				alertBox(language["alert"], infoIcon+language["maxFileSize2000"], 300);
				pickSelector.value = "";
				return;
			}
			
			var picName = pickSelector.value.split('.');
			var picNameLen = picName.length;
			var format = picName[(picNameLen-1)];

			if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
			{
				alertBox(language["alert"], infoIcon+language["wrongFormatJpgFile"], 300);
				pickSelector.value = "";
				return;
			}
		}
		
		var reader = new FileReader();
	}
	
	$("#loaderDiv").fadeIn();
	document.getElementById("upButtonDoc").click();
	pickSelector.value = "";
}
function loadFinish(result)
{
	if(result == 1){alertBox(language["alert"],infoIcon+language["loadDone"],300); saveFilePathDoc();}
	else{alertBox(language["alert"],infoIcon+language["loadFail"],300);}
	
}
function saveFilePathDoc()
{
	
	var info = {};
	info.code = userData.UCODE;
	info.type = actualLoadType;

	sendAjax("users","setFileLink",info,function(response)
	{
		var ans = response.message;
		
		if(actualLoadType == "Doc")
		{
			var upIdIcon = document.getElementById("upIdIcon");
			upIdIcon.className = "fa fa-check-circle fa-lg aprobed";
			downIdIcon.style.display = "inline-block";
			userData.DOCFILE = "1";
		}
		if(actualLoadType == "Sop1")
		{
			var upDocIcon1 = document.getElementById("upDocIcon1");
			upDocIcon1.className = "fa fa-check-circle fa-lg aprobed";
			downDocIcon1.style.display = "inline-block";
			userData.SOPFILE1 = "1";
		}
		if(actualLoadType == "Sop2")
		{
			var upDocIcon2 = document.getElementById("upDocIcon2");
			upDocIcon2.className = "fa fa-check-circle fa-lg aprobed";
			downDocIcon2.style.display = "inline-block";
			userData.SOPFILE2 = "1";
		}
		if(actualLoadType == "Sop3")
		{
			var upDocIcon3 = document.getElementById("upDocIcon3");
			upDocIcon3.className = "fa fa-check-circle fa-lg aprobed";
			downDocIcon3.style.display = "inline-block";
			userData.SOPFILE3 = "1";
		}
		
		$("#loaderDiv").fadeOut();
	});

}
function encry(str) 
{  
	return encodeURIComponent(str).replace(/[!'()*]/g, escape);  
}
function decry(str) 
{  
	return decodeURIComponent(str);  
}


// SPECIAL METHODS END ----------------------------

































// NOT USED -----------------------------------------


function addCss(fileName) 
{
	var link = $("<link />",{rel: "stylesheet",type: "text/css",href: fileName });
	$('head').append(link);
}
function setOnlyShop()
{
	document.getElementById("menuHome").style.display = "none";
	document.getElementById("menuAbout").style.display = "none";
	document.getElementById("logoSmall").style.display = "none";
	document.getElementById("logoRegular").src = "../../images/logoB.jpg"+tail;
	if(imfoo == "home" || imfoo == "about")
	{
		goProducts();
	}
	if(document.getElementsByClassName("col-2 col-sm-1 d-block d-lg-none").length > 0)
	{

		document.getElementsByClassName("col-2 col-sm-1 d-block d-lg-none")[0].innerHTML = "";
		document.getElementsByClassName("col-2 col-sm-1 d-block d-lg-none")[0].className = "hidden";
		
		document.getElementsByClassName("col-2 col-sm-1 col-lg-3 pr-0")[0].style.display = "none";
		
		console.log(document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6"))
		console.log(document.getElementsByClassName("col-4 col-sm-4 col-md-3 col-lg-3 d-none d-sm-block"))
		
		document.getElementsByClassName("col-4 col-sm-4 col-md-3 col-lg-3 d-none d-sm-block")[0].className = "col-6 col-sm-6 col-md-4 col-lg-4 d-none d-sm-block marginTB";
		
		var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		if(w > 990)
		{
			document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-10 col-sm-6 col-md-8 col-lg-8 marginTB";
		}
		else
		{
			// document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-10 col-sm-6 col-md-8 col-lg-8 marginTB";
		}
		
		
		var css = ".breadcrumb-container {background: #ffffff !important;}";
		addCssRule(css);
		
		var css = ".top-header {border-radius: 0px 0px 15px 15px;}";
		addCssRule(css);
		
		var css = ".navbar-theme { background-color: #ffffff !important; box-shadow: 0 0px 0px rgba(0,0,0,0.2)}";
		addCssRule(css);
		
		// mim();
	}
}
function setFullShop()
{

	if(document.getElementsByClassName("col-2 col-sm-1 d-block d-lg-none").length > 0)
	{
		
		
		var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		if(w < 990)
		{
			
			document.getElementsByClassName("col-4 col-sm-4 col-md-3 col-lg-3 d-none d-sm-block")[0].className = "col-6 col-sm-6 col-md-4 col-lg-4 d-none d-sm-block marginTB";
			
			
			if(imfoo != "checkout")
			{
				document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-4 col-sm-6 col-md-8 col-lg-8 marginTB";
			}
			else
			{
				document.getElementsByClassName("col-8 col-sm-6 col-md-7 col-lg-6")[0].className = "col-4 col-sm-6 col-md-8 col-lg-8 marginTB";
			}
		
		}	

		// var css = ".breadcrumb-container {background: #ffffff !important;}";
		// addCssRule(css);
		
		var css = ".top-header {border-radius: 0px 0px 15px 15px;}";
		addCssRule(css);
		
		var css = ".navbar-theme { background-color: #ffffff !important; box-shadow: 0 0px 0px rgba(0,0,0,0.2)}";
		addCssRule(css);
		
	}
}
function ChangeUrl(title, url) 
{
    if (typeof (history.pushState) != "undefined") {
        var obj = { Title: title, Url: url };
        history.pushState(obj, obj.Title, obj.Url);
    } else {
        alert("Browser does not support HTML5.");
    }
}
function setColorTheme(color)
{
	style = document.createElement('style');

	var css = ".navbar-theme .navbar-nav .nav-link:hover, .navbar-theme .navbar-nav .show>.nav-link, .navbar-theme .navbar-nav .active>.nav-link { text-shadow: 0px 1px 5px #000000;}";
	addCssRule(css);
	
	var css = ".fa-angle-double-up {color: #ffffff !important;}";
	addCssRule(css);
	
	var css = ".card {border-radius: 8px;}";
	addCssRule(css);
		
	var css = ".table-head .column {background: "+actualMainColor+" !important;}";
	addCssRule(css);
	
	var css = ".fileLink {color: "+actualMainColor+" !important;}";
	addCssRule(css);
	
	var css = ".card-body {background: "+actualMainColor+" !important;}";
	addCssRule(css);
	
	var css = ".card-body {border-radius: 0px 0px 8px 8px;}";
	addCssRule(css);
	
	var css = ".card-text {color: #ffffff !important; margin-bottom: 3px !important;}";
	addCssRule(css);
	
	var css = ".badge-danger {background: #717372 !important;}";
	addCssRule(css);

	var css = ".owl-carousel .owl-item img{background-image: url(../../images/imgLoader.gif); background-size: 100% 100%;}";
	addCssRule(css);
	
	var css = ".navbar-theme {box-shadow: 0 2px 5px rgba(0,0,0,0.3) !important;}";
	addCssRule(css);
	
	var css = ".card-img-top {background: #ffffff; !important;}";
	addCssRule(css);
	
	var css = ".slideShadow {box-shadow: 0 3px 5px rgba(0,0,0,0.3) !important;}";
	addCssRule(css);
	
	var css = ".fa-minus {color: #ffffff !important; text-shadow: 0px 1px 4px #222222 !important;}";
	addCssRule(css);
	
	var css = ".condLinkAction {color: "+actualMainColor+" !important;}";
	addCssRule(css);
	
	var css = ".fa-plus {color: #ffffff !important; text-shadow: 0px 1px 4px #222222 !important;}";
	addCssRule(css);
	
	var css = ".fa-search {color: #ffffff !important; text-shadow: 0px 1px 4px #222222 !important;}";
	addCssRule(css);
	
	var css = ".img-fluid {margin-bottom: 5px; margin-top: 5px;}";
	addCssRule(css);
	
	var css = ".fa {text-shadow: 0px 0px 0px #000000; color: "+actualMainColor+";}";
	addCssRule(css);
	
	var css = ".top-header .nav-link {text-shadow: 0px 1px 8px #000000;}";
	addCssRule(css);
	
	var css = ".modal-title {display: none !important;}";
	addCssRule(css);
	
	var css = ".card-product .card-text {color: "+actualMainColor+"; font-weight: bold;}";
	addCssRule(css);
	
	var css = ".modal-title {color: "+actualMainColor+";}";
	addCssRule(css);
	
	var css = ".detTitle {display: block !important;}";
	addCssRule(css);
	
	var css = ".close {display: none !important;}";
	addCssRule(css);
	
	var css = ".activePrice {text-shadow: 1px 1px 2px #cccccc;}";
	// addCssRule(css);
	
	var css = ".card-product .card-body {padding: 0.1rem 0.6rem !important; text-align: center;}";
	addCssRule(css);
	
	var css = ".price {text-shadow: 1px 1px 2px #cccccc;}";
	addCssRule(css);
	
	var css = ".topGuide {text-shadow: 1px 1px 2px #cccccc;}";
	addCssRule(css);
	
	var css = ".badge-counter {text-shadow: 1px 1px 3px #000000 !important;}";
	addCssRule(css);

	var css = ".input-group-qty {height: 25px;}";
	addCssRule(css);
	var css = ".owl-theme .owl-nav {display: none;}";
	addCssRule(css);
	var css = ".card-product {background: #fbf8f8;}";
	addCssRule(css);
	var css = ".table td, .table th {padding: .5rem;}";
	addCssRule(css);
	var css = ".modal-body {padding-top: 8px; padding-bottom: 10px}";
	addCssRule(css);
	var css = ".modal-open .modal {padding-right: 0px !important;}";
	addCssRule(css);
	
	var css = ".offcanvas .list-menu .list-group-item:hover {color: "+actualMainColor+" !important;}";
	addCssRule(css);

	var css = ".badge-counter {right: -5px !important;}";
	addCssRule(css);
	var css = ".badge-primary {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".nav-link:hover {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".top-header {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".navbar-theme .navbar-nav .nav-link:hover, .navbar-theme .navbar-nav .show>.nav-link, .navbar-theme .navbar-nav .active>.nav-link {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".btn-theme {border-color:"+actualMainColor+"!important; text-shadow: 0px 1px 3px #222222;}";
	addCssRule(css);
	var css = ".btn-theme {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".badge-theme {background-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".input-group-qty input[type='text'] {border-color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".activePrice {color: #ffffff !important;}";
	addCssRule(css);
	var css = ".topGuide {color:"+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".title {border-bottom: 3px solid rgba(194, 194, 194, .5) !important;}";
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
	addCssRule(css);
	var css = ".custom-checkbox .custom-control-input:checked ~ .custom-control-label::before, .custom-radio .custom-control-input:checked ~ .custom-control-label::before {background-color: "+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".card-product:before {border-color: "+actualMainColor+"!important;}";
	addCssRule(css);
	var css = ".input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle), .input-group>.input-group-append:last-child>.input-group-text:not(:last-child), .input-group>.input-group-append:not(:last-child)>.btn, .input-group>.input-group-append:not(:last-child)>.input-group-text, .input-group>.input-group-prepend>.btn, .input-group>.input-group-prepend>.input-group-text {padding: .10rem .5rem !important;}";
	addCssRule(css);
	var css = ".form-control-sm, .input-group-sm>.form-control, .input-group-sm>.input-group-append>.btn, .input-group-sm>.input-group-append>.input-group-text, .input-group-sm>.input-group-prepend>.btn, .input-group-sm>.input-group-prepend>.input-group-text {padding: .10rem .5rem !important;}";
	addCssRule(css);
	
	if(imfoo == "products")
	{
		var css = ".container-fluid {padding-right: 0px; padding-left: 0px;}";
		addCssRule(css);
	}


}
function setItemContent(id, content)
{
	if(document.getElementById(id))
	{
		var item = document.getElementById(id);
		item.innerHTML = content;
	}
}
function setImageHome(id, pathstate)
{
	if(document.getElementById(id))
	{
		var item = document.getElementById(id);
		if(pathstate == "1")
		{
			item.src = "../../images/home/"+actualScode+"-"+id+".jpg"+tail;
		}
	}
}
function setImageAbout(id, pathstate)
{
	if(document.getElementById(id))
	{
		var item = document.getElementById(id);
		if(pathstate == "1")
		{
			item.src = "../../images/about/"+actualScode+"-"+id+".jpg"+tail;
		}
	}
}
function goAdmin()
{
	window.location.href = 'secure/';
}


function getSetCart()
{
	
	if(localStorage.getItem(actualScode+"-cart"))
	{
		actualCart = JSON.parse(localStorage.getItem(actualScode+"-cart"));
		if(!actualCart.ORDER){actualCart.ORDER = "";}
		if(actualCart.ORDER != "")
		{
			
			var order = actualCart.ORDER;
			var info = {};
			info.order = order;
			info.scode = actualScode;
			
			sendAjax("users","getOstatus",info,function(response)
			{
				var ans = response.message;
				
				if(ans == "1")
				{
					actualCart.ITEMS = [];
					actualCart.ORDER = "";
					localStorage.setItem(actualScode+"-cart", JSON.stringify(actualCart));
					goProducts();
				}
				
			});
		}
	}
	else
	{
		actualCart = {};
		actualCart.ITEMS = [];
		actualCart.ORDER = "";
		localStorage.setItem(actualScode+"-cart", JSON.stringify(actualCart));
	}
	updateCart();
}
function selectGroup(info)
{

	actualCart = JSON.parse(localStorage.getItem(actualScode+"-cart"));
	
	for(var i=0; i<actualCart.ITEMS.length; i++)
	{
		info.group.push(actualCart.ITEMS[i].CODE);
	}

}
function refSpliter(list)
{
	var actualRef = "";
	var nextRef = "";
	
	var products = [];
	var refs = [];

	for(var i=0; i<list.length; i++)
	{
		var product = list[i];
		
		if(i == 0){products.push(product);}
		if(i > 0)
		{
			
			var actualCode = product.CODE.split("-")[0];
			var lastCode = list[i-1].CODE.split("-")[0];
			
			if(actualCode != lastCode){products.push(product);}
			else{refs.push(product);	}
		}
		
	}
	actualPlist = products;
	actualRlist = refs;

}
function setDiscLabel()
{
	var guide = document.getElementById("topGuide");
	guide.innerHTML = "Total pedido actual: "+addCommas(actualTotal);
}
function goHome()
{
	location.replace("index.php"+"?link=index");
}
function goAbout()
{
	location.replace("index.php"+"?link=about");
}
function goProducts()
{
	location.replace("index.php"+"?link=products");
}
function goRegister()
{
	location.replace("index.php"+"?link=register");
}
function goProfile()
{
	location.replace("index.php"+"?link=profile");
}
function updateCart()
{
	var counter = document.getElementById("cartCount");
	var counterX = document.getElementById("cartCountX");
	counter.innerHTML = actualCart.ITEMS.length;
	counterX.innerHTML = actualCart.ITEMS.length;
	
	if(document.getElementById("cartCountM"))
	{
		document.getElementById("cartCountM").innerHTML = actualCart.ITEMS.length;
	}
	
	localStorage.setItem(actualScode+"-cart", JSON.stringify(actualCart));
	getCartValue();
}
function getCartValue()
{
	actualCart = JSON.parse(localStorage.getItem(actualScode+"-cart"));
	if(!actualCart.ORDER){actualCart.ORDER = "";}
	actualTotal = 0;
	cartValue = 0;
	
	for(var i=0; i<actualCart.ITEMS.length; i++)
	{
		var qty = actualCart.ITEMS[i].QTY;
		var code = actualCart.ITEMS[i].CODE;

		if(getPdata(code) != "ne")
		{
			var price = getPdata(code).PRICE;
			price = price.replace(".00", "");
			price = price.replace(",", "");
			var subtotal = qty*price;
			cartValue += parseFloat(subtotal);
		}
	}
	actualTotal = cartValue;
	setDiscLabel();
}
function desDelDate()
{
	var infoLabel = document.getElementById("topInfoLabel");
	infoLabel.innerHTML = "¡Lo mejor de nuestros productos en tu puerta!";
}
function getExtDesc(code)
{
	var detail = [];
	for(var i=0; i<actualElist.length; i++)
	{
		var reg = actualElist[i];
		if(reg.CODE == code)
		{
			if(reg.FDETAIL != "")
			{
				var desc = reg.FDETAIL;
			}
			else
			{
				var desc = reg.DETAIL;
			}
			
			if(reg.COLOR != "")
			{
				var color = reg.COLOR;
			}
			else
			{
				var color = "none";
			}
			var detail = [desc, color];
		}
	}
	return detail;
}
function getdDiff(startDate, endDate) 
{
	var date1 = new Date(startDate);
	var date2 = new Date(endDate);
	var timeDiff = date2.getTime() - date1.getTime();
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
	return diffDays;
}
function resizeFooter() 
{
	var list = document.getElementsByTagName("iframe");
	var obj = list[0];
	for(var i=0; i<list.length; i++)
	{
		var obj = list[i];
		obj.style.height = (obj.contentWindow.document.body.scrollHeight+20) + 'px ';
	}
	

}
function toPhrase(string)
{
  return string.charAt(0).toUpperCase() + string.slice(1);
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
String.prototype.replaceAll = function(search, replacement) 
{
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
// MIMITY IMPORT
function mim()
{
		
		var breakpoint = {
			refreshValue: function () {
				this.value = window.getComputedStyle(document.querySelector("body"), ":before").getPropertyValue("content").replace(/\"/g, "")
			}
		}, minifyInputSearch = function () {
			"sm" == breakpoint.value || "xs" == breakpoint.value ? $(".input-group-search").addClass("input-group-sm") : $(".input-group-search").removeClass("input-group-sm")
		}, setupOwlCover = function () {
			
			$(".owl-cover").each(function () {
				var a = $(this);
				var path  = a.data("src");
				var url= "../../images/slider/pcs0.jpg";
				
				if (typeof actualScode !== 'undefined') 
				{
					if(actualFooterData.SL1 != 0)
					{if(path.includes("pcs1")){var url= "../../images/slider/"+actualScode+"-pcs1.jpg"+tail;}}
					else{if(path.includes("pcs1")){var url= "../../images/slider/pcs1.jpg";}}
					
					if(actualFooterData.SL2 != 0)
					{if(path.includes("pcs2")){var url= "../../images/slider/"+actualScode+"-pcs2.jpg"+tail;}}
					else{if(path.includes("pcs2")){var url= "../../images/slider/pcs2.jpg";}}
					
					if(actualFooterData.SL3 != 0)
					{if(path.includes("pcs3")){var url= "../../images/slider/"+actualScode+"-pcs3.jpg"+tail;}}
					else{if(path.includes("pcs3")){var url= "../../images/slider/pcs3.jpg";}}
					
				}
				
				switch (a.css("background-image", "url(" + url + ")"), a.attr("data-height") && a.css("height", a.data("height")), breakpoint.value) {
				case "xs":
					a.attr("data-xs-height") && a.css("height", a.data("xs-height"));
					break;
				case "sm":
					a.attr("data-sm-height") && a.css("height", a.data("sm-height"));
					break;
				case "md":
					a.attr("data-md-height") && a.css("height", a.data("md-height"));
					break;
				case "lg":
					a.attr("data-lg-height") && a.css("height", a.data("lg-height"));
					break;
				case "xl":
					a.attr("data-xl-height") && a.css("height", a.data("xl-height"))
				}
			})
		}, removeClassOn = function () {
			["xs", "sm", "md", "lg", "xl"].forEach(function (a) {
				$("[remove-class-on-" + a + "]").each(function () {
					var t = $(this).attr("remove-class-on-" + a);
					breakpoint.value == a ? $(this).removeClass(t) : $(this).addClass(t)
				})
			})
		}, addClassOn = function () {
			["xs", "sm", "md", "lg", "xl"].forEach(function (a) {
				$("[add-class-on-" + a + "]").each(function () {
					var t = $(this).attr("add-class-on-" + a);
					breakpoint.value == a ? $(this).addClass(t) : $(this).removeClass(t)
				})
			})
		}, dropdownSelect = function () {
			var a = 1;
			$(".select-dropdown").each(function () {
				var t,
				e = $(this),
				i = e.val(),
				o = void 0 == (o = e.data("size")) || "" == o ? "" : " btn-" + o,
				n = void 0 == (n = e.data("width")) || "" == n ? "min-width:10rem" : "width:" + n,
				s = void 0 == (s = e.data("width")) || "" == s ? "" : 'style="min-width:' + s + '"',
				l = (t = void 0 == (t = e.find("option:selected").data("before")) || "" == t ? "" : t) + e.find("option:selected").html(),
				d = "";
				if (e.find("option").each(function () {
						var a = void 0 == $(this).data("before") || "" == $(this).data("before") ? "" : $(this).data("before"),
						t = $(this).val() == i ? " active" : "";
						d += '<button class="dropdown-item' + t + '" type="button" data-value="' + $(this).val() + '">' + a + $(this).html() + "</button>"
					}), e.parent(".input-group-prepend").length) {
					e.parent(".input-group-prepend").addClass("dropdown dropdown-select");
					var r = '<button class="btn btn-outline-default btn-select text-right dropdown-toggle' + o + '" type="button" id="dropdownSelect' + a + '"                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="' + n + '">                  <span class="float-left">' + l + '</span>                </button>                <div class="smooth dropdown-menu" aria-labelledby="dropdownSelect' + a + '" ' + s + ">                  " + d + "                </div>"
				} else
					r = '<div class="dropdown dropdown-select" style="' + n + '">                  <button class="btn btn-outline-default btn-select text-right dropdown-toggle' + o + '" type="button" id="dropdownSelect' + a + '"                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="' + n + '">                    <span class="float-left">' + l + '</span>                  </button>                  <div class="smooth dropdown-menu" aria-labelledby="dropdownSelect' + a + '" ' + s + ">                    " + d + "                  </div>                </div>";
				r = r.replace(/>[\n\t ]+</g, "><");
				e.prop("hidden", !0),
				e.before(r),
				a++
			}),
			$(".dropdown-select").each(function () {
				var a = $(this),
				t = a.siblings(".select-dropdown").length ? a.siblings(".select-dropdown") : a.find(".select-dropdown");
				a.find(".dropdown-item").click(function () {
					var a = $(this),
					e = a.html(),
					i = a.data("value");
					t.val() != i && (a.parents(".dropdown").find(".dropdown-toggle").html('<span class="float-left">' + e + "</span>"), a.parents(".dropdown").find(".dropdown-item.active").removeClass("active"), a.addClass("active"), t.val(i), t.trigger("change"))
				})
			})
		}, dropdownSelectNav = function () {
			$(".select-dropdown-nav").each(function () {
				var a,
				t = $(this),
				e = t.val(),
				i = void 0 == (i = t.data("width")) || "" == i ? "min-width:10rem" : "width:" + i,
				o = void 0 == (o = t.data("width")) || "" == o ? "" : 'style="min-width:' + o + '"',
				n = (a = void 0 == (a = t.find("option:selected").data("before")) || "" == a ? "" : a) + t.find("option:selected").html(),
				s = "";
				t.find("option").each(function () {
					var a = void 0 == $(this).data("before") || "" == $(this).data("before") ? "" : $(this).data("before"),
					t = $(this).val() == e ? " active" : "";
					s += '<button class="dropdown-item' + t + '" data-value="' + $(this).val() + '">' + a + $(this).html() + "</button>"
				});
				var l = (l = '<li class="nav-item dropdown dropdown-select-nav" style="' + i + '">                <a href="#" class="nav-link text-right dropdown-toggle" role="button"                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="' + i + '">                  <span class="float-left">' + n + '</span>                </a>                <div class="smooth dropdown-menu"  ' + o + ">                  " + s + "                </div>              </li>").replace(/>[\n\t ]+</g, "><");
				t.prop("hidden", !0),
				t.after(l),
				0
			}),
			$(".dropdown-select-nav").each(function () {
				var a = $(this),
				t = a.prev();
				a.find(".dropdown-item").click(function () {
					var a = $(this),
					e = a.html(),
					i = a.data("value");
					t.val() != i && ($(this).parents(".dropdown").find(".dropdown-toggle").html('<span class="float-left">' + e + "</span>"), a.parents(".dropdown").find(".dropdown-item.active").removeClass("active"), a.addClass("active"), t.val(i), t.trigger("change"))
				})
			})
		}, toggleMenuBtn = function (a) {
			var t = $(".menu-btn-wrapper").parent(),
			e = $(".logo-wrapper").parent();
			"lg" == breakpoint.value || "xl" == breakpoint.value ? ("show" == a && (t.removeClass("d-lg-none"), e.removeClass("col-lg-3"), e.addClass("col-lg-2")), "hide" == a && (t.addClass("d-lg-none"), e.removeClass("col-lg-2"), e.addClass("col-lg-3"))) : (t.addClass("d-lg-none"), e.removeClass("col-lg-2"))
		}, mh = $(".middle-header"), mhA = "animated slideInDown", wp = $("<div></div>");
		mh.before(wp);
		
		var ost = wp.offset().top, fixtop = "fixed-top", lst = $(window).scrollTop();
		
		$(window).on("load scroll resize", function () {
			var a = mh.height(),
			t = $(this).scrollTop();
			t < lst ? t <= ost && (mh.hasClass(fixtop) && (mh.removeClass(fixtop), mh.removeClass(mhA)), wp.height(0), toggleMenuBtn("hide")) : t >= ost + a + 55 && (1 != mh.hasClass(fixtop) && mh.addClass(mhA), mh.addClass(fixtop), wp.height(a), toggleMenuBtn("show")),
			lst = t
			
		});
		var setupCardProduct = function () {

			$(".tools").each(function () {
				var a = $(this);
				"xs" != breakpoint.value && "sm" != breakpoint.value ? (a.attr("hidden", !0), a.addClass("animated")) : (a.attr("hidden", !1), a.removeClass("animated"))
			}),
			$(".card-product").hover(function () {
				var a = $(this).find(".tools"),
				t = a.data("animate-in"),
				e = a.data("animate-out");
				a.hasClass("animated") && (a.attr("hidden", !1), a.removeClass(e), a.addClass(t))
			}, function () {
				var a = $(this).find(".tools"),
				t = a.data("animate-in"),
				e = a.data("animate-out");
				a.hasClass("animated") && (a.removeClass(t), a.addClass(e))
			})
		}, inputQty = function () {
			$(".input-group-qty").each(function () {
				var a = $(this),
				t = a.find('input[type="text"]'),
				e = a.find(".btn-down"),
				i = a.find(".btn-up"),
				o = t.data("min"),
				n = t.data("max");
				o = void 0 == o || "" == o || o < 0 ? 0 : o,
				n = void 0 == n || "" == n || n < 0 ? 1e3 : n;
				t.change(function () {
					!$.isNumeric($(this).val()) || $(this).val() < o ? $(this).val(o) : $(this).val() > n && $(this).val(n)
				}),
				i.click(function () {
					t.val(parseInt(t.val()) + 1).trigger("change")
				}),
				e.click(function () {
					t.val(parseInt(t.val()) - 1).trigger("change")
				})
			})
		};
		$(window).resize(function ()
		{
			breakpoint.refreshValue(),
			minifyInputSearch(),
			setupOwlCover(),
			removeClassOn(),
			addClassOn(),
			setupCardProduct()
		}).resize(),
		
		$(function () {
			
			$(".offcanvas");
			var a = $("body"),
			t = ($("#container"), "offcanvas-open"),
			e = function () {
				mh.removeClass(mhA),
				setTimeout(function () {
					a.toggleClass(t),
					$("html, body").toggleClass("offcanvas-overflow")
				}, 10)
			};
			$(document).keyup(function (i) {
				27 == i.keyCode && a.hasClass(t) && e()
			}),
			$(".offcanvas-btn, .content-overlay").on("click", function () {
				e()
			}),$(".list-menu a").addClass("list-group-item"),
			$(".list-menu i.fa").addClass("fa-fw"),
			dropdownSelect(),
			dropdownSelectNav(),
			// $('[data-toggle="tooltip"]').tooltip(),
			setupOwlCover(),
			removeClassOn(),
			addClassOn(),
			setupCardProduct(),
			inputQty(),
			$("body").on("mouseenter mouseleave", ".navbar-theme .nav-item.dropdown", function (a) {
				var t = $(a.target).closest(".dropdown");
				t.addClass("show"),
				setTimeout(function () {
					t[t.is(":hover") ? "addClass" : "removeClass"]("show")
				}, 0)
			})
			// $("#search-input").typeahead({fitToElement: !0,source: []});
			var i = $(".home-slider");
			i.length && (i.on("initialized.owl.carousel", function (a) {
					i.find(".owl-item.active").find(".animated").each(function () {
						$(this).addClass($(this).data("animate"))
					})
				}), i.owlCarousel({
					items: 1,
					loop: !0,
					dots: !1,
					nav: !0,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					autoplay: !0,
					autoplayTimeout: 4e3
				}), i.on("changed.owl.carousel", function (a) {
					var t = i.find(".owl-item");
					t.find(".animated").each(function () {
						$(this).removeClass($(this).data("animate"))
					}),
					t.eq(a.item.index).find(".animated").each(function () {
						$(this).addClass($(this).data("animate"))
					})
				}));
			var o = $(".product-slider");
			o.length && o.owlCarousel({
				dots: !1,
				nav: !0,
				navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
				responsive: {
					0: {
						items: 2
					},
					768: {
						items: 3
					},
					992: {
						items: 4
					},
					1200: {
						items: 5
					}
				}
			});
			var n = $(".brand-slider");
			n.length && n.owlCarousel({
				dots: !1,
				nav: !0,
				navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
				responsive: {
					0: {
						items: 2,
						margin: 10
					},
					576: {
						items: 3,
						margin: 10
					},
					768: {
						items: 4,
						margin: 15
					},
					992: {
						items: 5,
						margin: 30
					},
					1200: {
						items: 6,
						margin: 30
					}
				}
			});
			var s = $(".quickview-slider");
			if (s.length && s.owlCarousel({
					dots: !1,
					nav: !0,
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					responsive: {
						0: {
							items: 2
						},
						576: {
							items: 1
						}
					}
				}), $(".quick-view").click(function () {
					$("#QuickViewModal").modal("show");
					console.log("jojo")
				}), (l = $("#price")).length) {
				var l = document.getElementById("price");
				noUiSlider.create(l, {
					start: [20, 80],
					connect: !0,
					range: {
						min: 0,
						max: 100
					}
				}),
				l.noUiSlider.on("update", function (a, t) {
					var e = a[t];
					t ? $("#max-price").val(Math.round(e)).attr("value", Math.round(e)) : $("#min-price").val(Math.round(e)).attr("value", Math.round(e))
				}),
				$("#max-price").on("change", function () {
					l.noUiSlider.set([null, this.value])
				}),
				$("#min-price").on("change", function () {
					l.noUiSlider.set([this.value, null])
				})
			}
			if ((d = $("#rating-range")).length) {
				var d = document.getElementById("rating-range");
				noUiSlider.create(d, {
					start: [$("#min-range").val(), $("#max-range").val()],
					connect: !0,
					orientation: "vertical",
					snap: !0,
					direction: "rtl",
					range: {
						min: 1,
						"25%": 2,
						"50%": 3,
						"75%": 4,
						max: 5
					},
					pips: {
						mode: "values",
						values: [1, 2, 3, 4, 5]
					}
				}),
				d.noUiSlider.on("update", function (a, t) {
					var e = $("#rating-range");
					e.find('.noUi-value[style="bottom: 100%;"]').html('<div class="rating"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>'),
					e.find('.noUi-value[style="bottom: 75%;"]').html('<div class="rating"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>'),
					e.find('.noUi-value[style="bottom: 50%;"]').html('<div class="rating"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>'),
					e.find('.noUi-value[style="bottom: 25%;"]').html('<div class="rating"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>'),
					e.find('.noUi-value[style="bottom: 0%;"]').html('<div class="rating"><i class="fa fa-star-o"></i></div>');
					var i = a[t];
					t ? $("#max-range").val(Math.round(i)).attr("value", Math.round(i)) : $("#min-range").val(Math.round(i)).attr("value", Math.round(i));
					for (var o = $("#min-range").val(), n = "" == (n = $("#max-range").val()) ? o : n, s = o; s < parseInt(n) + 1; s++) {
						switch (s) {
						case 5:
						case "5":
							var l = "100%";
							break;
						case 4:
						case "4":
							l = "75%";
							break;
						case 3:
						case "3":
							l = "50%";
							break;
						case 2:
						case "2":
							l = "25%";
							break;
						case 1:
						case "1":
							l = "0%"
						}
						e.find('.noUi-value[style="bottom: ' + l + ';"]').find(".fa").addClass("fa-star").removeClass("fa-star-o")
					}
				}),
				$("#max-range").on("change", function () {
					d.noUiSlider.set([null, this.value])
				}),
				$("#min-range").on("change", function () {
					d.noUiSlider.set([this.value, null])
				})
			}
			var r = $(".products-slider-detail");
			if (r.length) {
				var c = $(".products-slider-detail a").length;
				r.owlCarousel({
					margin: 5,
					dots: !1,
					nav: !(c < 5),
					mouseDrag: !(c < 5),
					touchDrag: !(c < 5),
					navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					responsive: {
						0: {
							items: 4
						}
					}
				}),
				$(".products-slider-detail a").click(function () {
					var a = $(this).find("img").attr("src"),
					t = $(this).find("img").attr("data-zoom-image"),
					e = $(".image-detail");
					console.log(e)
					return e.attr("src", a),
					e.attr("data-zoom-image", t),
					$(".zoomWindow").css("background-image", 'url("' + t + '")'),
					!1
				})
			}
			var h = $(".input-rating");
			h.length && h.raty({
				half: !0,
				starType: "i"
			}),
			$(".image-detail").length && "sm" != breakpoint.value && "xs" != breakpoint.value && $(".image-detail").ezPlus({
				responsive: !0,
				respond: [{
						range: "1200-10000",
						zoomWindowHeight: 477,
						zoomWindowWidth: 762
					}, {
						range: "992-1200",
						zoomWindowHeight: 504,
						zoomWindowWidth: 562
					}, {
						range: "768-992",
						zoomWindowHeight: 449,
						zoomWindowWidth: 362
					}, {
						range: "100-768",
						zoomWindowHeight: 0,
						zoomWindowWidth: 0
					}
				]
			}),
			$(window).scroll(function () {
				$(this).scrollTop() > 100 ? $(".back-top").fadeIn() : $(".back-top").fadeOut()
			})
		});
}
function showOrderItems(code)
{
	var info = {};
	info.code = code;
	
	sendAjax("users","getOitems",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		document.getElementById("odetailTrigger").click();
		
		tableCreator("ordersItems", ans);
		return;
		
		actualOitems = ans;
		
	});
	
}