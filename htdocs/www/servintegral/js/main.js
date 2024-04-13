$(document).ready( function()
{
	loadCheck();
	
});
function liveRefresh()
{
	var loc = window.location.href;
	if(loc.includes("192"))
	{
		var imported = document.createElement('script');
		imported.src = 'js/live.js';
		document.head.appendChild(imported);
	}
	if(loc.includes("192"))
	{
		var imported = document.createElement('script');
		imported.src = 'js/live.js';
		document.head.appendChild(imported);
	}
}
function resSet()
{
	var width = document.getElementById('middleArea').offsetWidth;
	var mainMid = document.getElementById('mainMiddleContent');
	var copyLine = document.getElementById("copyright");
		
	if(width < 1300)
	{
		copyLine.style.float  = "none";
		copyLine.style.marginRight   = "0px";
		resType = "t";
	}
	else
	{
		copyLine.style.float  = "right";
		copyLine.style.marginRight   = "20px";
	}
	
	centerer(document.getElementById("wa"));
	centererLogin(document.getElementById("loginBox"));
        
}
window.onmousedown = function (e) 
{
    var el = e.target;
    if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
        e.preventDefault();

        // toggle selection
        if (el.hasAttribute('selected')) el.removeAttribute('selected');
        else el.setAttribute('selected', '');

        // hack to correct buggy behavior
        var select = el.parentNode.cloneNode(true);
        el.parentNode.parentNode.replaceChild(select, el.parentNode);
    }
}
function loadCheck()
{
	
	makeBoxpand("clientAdminBS","Administrar Clientes","Administrar Clientes", 1);
	makeBoxpand("clientSearchBS","Buscar Clientes","Buscar Clientes", 1);
	
	makeBoxpand("sucuAdminBS","Administrar Sucursales","Administrar Sucursales", 1);
	makeBoxpand("sucuSearchBS","Buscar Sucursales","Buscar Sucursales", 1);
	
	makeBoxpand("maquiAdminBS","Administrar Equipos","Administrar Equipos", 1);
	makeBoxpand("maquiSearchBS","Buscar Equipos","Buscar Equipos", 1);
	
	makeBoxpand("techiAdminBS","Administrar Usuarios","Administrar Usuarios", 1);
	makeBoxpand("techiSearchBS","Buscar Usuarios","Buscar Usuarios", 0);
	
	makeBoxpand("actiAdminBS","Administrar Actividades","Administrar Actividades", 1);
	makeBoxpand("actiSearchBS","Buscar Actividades","Buscar Actividades", 1);
	
	makeBoxpand("inveAdminBS","Administrar Inventario","Administrar Inventario", 1);
	makeBoxpand("inveSearchBS","Buscar Inventario","Buscar Inventario", 1);
	
	makeBoxpand("logSearchBS","Buscar Log de Movimientos","Buscar Log de Movimientos", 1);
	
	makeBoxpand("ocreateAdminBS","Administrar Orden de Trabajo","Administrar Orden de Trabajo", 1);
	makeBoxpand("orderSearchBS","Buscar Orden","Buscar Orden", 1);
	
	makeBoxpand("ocreateAdminBSCL","Crear Orden de Trabajo","Crear Orden de Trabajo", 1);
	makeBoxpand("orderSearchBSCL","Buscar Orden","Buscar Orden", 1);
	
	makeBoxpand("repSearchBS","Reportes de Orden","Reportes de Orden", 1);
	makeBoxpand("legBS","Legalización de anticipos","Legalización de anticipos", 1);
	
	makeBoxpand("recSearchBS","Maestro de Facturación","Maestro de Facturación", 1);
	
	makeBoxpand("recAdminBS","Resolucion de facturación","Resolucion de facturación", 0);
        
	makeBoxpand("orderTSearchBS","Buscar Orden","Buscar Orden", 1);
	
	makeBoxpand("reportsSearchBS","Filtro","Filtro", 1);

	ltt1 = "Creación";
	ltt2 = "Edición";
	ltt3 = "Eliminación";
	ltt4 = "Ingreso";
	ltt5 = "Cambio Password"
	
	
	clientSaveButton = document.getElementById("clientSaveButton");
	sucusavebutton = document.getElementById("sucuSaveButton");
	maquiSaveButton = document.getElementById("maquiSaveButton");
	techiSaveButton = document.getElementById("techiSaveButton");
	actiSaveButton = document.getElementById("actiSaveButton");
	inveSaveButton = document.getElementById("inveSaveButton");
	orderSaveButton = document.getElementById("orderSaveButton");
	orderSaveButtonCL = document.getElementById("orderSaveButtonCL");
	
	actualLegState = "0" ;
        

	a_clients_targets = ["a-clientName", "a-clientManager", "a-clientNit", "a-clientNature", "a-clientPhone", "a-clientAddress", "a-clientEmail", "a-clientLocation"];
	f_clients_targets = ["f-clientName", "f-clientNit", "f-clientEmail"];
	
	a_sucu_targets = ["a-sucuParent", "a-sucuCode", "a-sucuName", "a-sucuAddress", "a-sucuPhone", "a-sucuCountry", "a-sucuDepto", "a-sucuCity"];
	f_sucu_targets = ["f-sucuParent", "f-sucuName", "f-sucuCode"];
	
	a_maqui_targets = ["a-maquiParent", "a-maquiSucu", "a-maquiPlate", "a-maquiName", "a-maquiModel", "a-maquiSerial", "a-maquiVolt", "a-maquiCurrent", "a-maquiPower", "a-maquiPhase", "a-maquiDetails"];
	f_maqui_targets = ["f-maquiParent", "f-maquiSucu", "f-maquiPlate"];
	
	a_techi_targets = ["a-techiId", "a-techiName", "a-techiCat", "a-techiMastery", "a-techiEmail", "a-techiCity", "a-techiAddress", "a-techiPhone", "a-techiDetails"];
	f_techi_targets = ["f-techiId", "f-techiCat", "f-techiName", "f-techiLocation"];
	
	a_acti_targets = ["a-actiType", "a-actiDesc", "a-actiTime", "a-actiValue"];
	f_acti_targets = ["f-actiType", "f-actiCode", "f-actiDesc"];
	
	a_inve_targets = ["a-inveCode", "a-inveDesc", "a-inveCost", "a-inveMargin", "a-inveAmount"];
	f_inve_targets = ["f-inveCode", "f-inveDesc"];
	
	a_orde_targets = ["a-orderParent", "a-orderSucu", "a-orderMaquis", "a-orderPriority", "a-orderPriority2", "a-orderDesc", "a-orderContact", "a-orderOrderClient"];
	f_orde_targets = ["f-orderParent", "f-orderSucu", "f-orderNum", "f-orderAuthor", "f-orderState", "f-orderLocation"];
	
	a_orde_targetsCL = ["a-orderSucuCL", "a-orderMaquisCL", "a-orderPriorityCL", "a-orderDescCL", "a-orderOrderClientCL"];
	f_orde_targetsCL = ["f-orderSucuCL", "f-orderNumCL", "f-orderStateCL"];
	
	
	f_log_targets = ["f-logResp", "f-logInidate", "f-logEndate", "f-logType", "f-logTarget","f-logMove"];

	f_rep_targets = ["f-repParent", "f-repSucu", "f-repNumber", "f-repInidate", "f-repEndate"];
	
	f_rec_targets = ["f-recNumber", "f-recParent", "f-repOnum", "f-recInidate", "f-recEndate"];
	
	a_rec_targets = ["a-resoNumber", "a-resoDate", "a-resoIninum", "a-resoEndnum", "a-resoActualnum"];
	
	f_orde_targetsT = ["f-orderParentT", "f-orderSucuT", "f-orderNumT"];
	
	legTargets = ["legCode", "legItemParent", "legItemOrder", "legItemDate", "legItemNumber", "legItemConcept", "legItemDetail", "legItemCname", "legItemId",  "legItemBase", "legItemBase", "legItemTax" , "legItemTotal", "legItemRetFont", "legItemRetFont", "legItemRetICA", "legItemPayment" ];
	
	liveRefresh();
	
	costConcepts = ["601 Viáticos", "602 Alimentación", "603 Transporte materiales", "604 Transporte de personal", "605 Transporte de herramienta", "606 Compra de materiales", "607 Compra Insumos", "608 Compra de repuestos", "609 Compra de herramientas", "610 Compra de epp", "611 Alquiler de andamios", "612 Alquiler de escalera", "613 Alquiler de herramienta", "614 Alquiler de equipos", "615 Alquiler equipo de alturas", "616 Alquiler", "617 Hospedaje", "618 Transporte y disposición de escombros", "619 Flete de materiales", "620 Flete de equipo", "621 Flete de anticipos", "622 Publicidad", "623 Gastos de rodamiento técnicos", "624 Gastos de rodamiento Jefes zona", "625 Gastos de rodamiento otros", "626 Compra de combustible", "627 Peajes", "628 Parqueaderos", "629 Servicios externos - soldadura", "630 Servicios externos - cerrajeria", "631 Servicios externos - puertas", "632 Servicios externos - vidrios", "633 Servicios externos - Ornamentación", "634 Servicios externos - Plomería", "635 Servicios externos - Jardinería", "636 Mano de obra - Oficial construcción", "637 Mano de obra - Ayudante", "638 Servicios externos - Electricista", "639 Servicios externos - otros", "640 Horas extras", "641 Turnos fin de semana", "642 Disponibilidad fin de semana Tecnico", "643 Auxilio celular", "644 Reparación de herramientas", "645 Elementos de aseo y cafeteria", "646 Compra de papelería", "647 Gastos de fotocopias y papelería"];
	
	refreshConceptFields();
	
	aud = null;
	actualUtype = null;
	editMode = 0;
	actualMaquisList = [];
	actualMaquiPicks = [];
	lastStartTime = "";
	partsTotal = 0;
	etimeTotal = 0;
	actisTotal = 0;
	othersTotal = 0;
	
	ofilters = ["","","","","",""];
	
	var picSelectorIni = document.getElementById("picSelectorIni");
	picSelectorIni.addEventListener('change', handleFileSelectIni, false);
	
	var picSelectorEnd = document.getElementById("picSelectorEnd");
	picSelectorEnd.addEventListener('change', handleFileSelectEnd, false);
	
	var picSelectorOrder = document.getElementById("picSelectorOrder");
	picSelectorOrder.addEventListener('change', handleFileSelectOrder, false);
	
	var budgetSelectorOrder = document.getElementById("budgetSelectorOrder");
	budgetSelectorOrder.addEventListener('change', handleFileSelectBudget, false);

	if(localStorage.getItem("lastMail")){document.getElementById("userLoginBox").value = localStorage.getItem("lastMail");}
	document.querySelector('#userLoginBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	document.querySelector('#userPassBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
        
	jQuery.datetimepicker.setLocale("es");
	// jQuery('#a-ostartTime').datetimepicker();
	jQuery('#f-logInidate').datetimepicker();
	jQuery('#f-logEndate').datetimepicker();
	jQuery('#f-repInidate').datetimepicker();
	jQuery('#f-repEndate').datetimepicker();
	jQuery('#f-recInidate').datetimepicker();
	jQuery('#f-recEndate').datetimepicker();
	jQuery('#a-orderPriority').datetimepicker();
	jQuery('#a-orderPriority2').datetimepicker();
	jQuery('#a-resoDate').datetimepicker({ dateFormat: 'yy-mm-dd' });
	
	jQuery('#legItemDate').datetimepicker({timepicker:false,format:'Y-m-d',}).on('change', function(){$('.xdsoft_datetimepicker').hide(); var str = $(this).val(); str = str.split(".");});

        
	if(localStorage["tmpOrder"])
	{
			actualOrderData = JSON.parse(localStorage["tmpOrder"]);
	}
	else
	{
			actualOrderData = [];
	}
        
	langPickIni();
}
function refreshConceptFields()
{
	var picker1 = document.getElementById("a-orderOtherType");
	var picker2 = document.getElementById("legItemConcept");
	
	
	picker1.innerHTML = "";
	picker2.innerHTML = "";
	
	
	var list = costConcepts;
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona concepto";
	
	picker1.appendChild(option);
	picker2.appendChild(option.cloneNode(true));
	
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var option = document.createElement("option");
		option.value = item.split(" ")[0];	
		option.innerHTML = item;
		
		picker1.appendChild(option);
		picker2.appendChild(option.cloneNode(true));
	}
	
	
	
}
function checkStart()
{
	var d = window.location.href;
	var t = d.split("?");
	if(t.length > 1){var a = t[1];ifLoad('ifPassRec');pssReCode = a.split("key=")[1];pssReCode = pssReCode.split("&")[0];history.pushState({}, null, "http://incocrea.com/servintegral/");return true;}
        return false
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
function checkLogin()
{
	
	if(checkStart()){return}
	
	$(window).resize(function(){resSet();});
	if (window.localStorage.getItem("aud")) 
	{
		var workArea = document.getElementById("workArea");
		workArea.style.display = "initial";
		var loginCover = document.getElementById("loginArea");
		loginCover.style.display = "none";
		
		document.getElementById("exitIcon").style.display = "block";

		aud = JSON.parse(window.localStorage.getItem("aud"));
		actualUtype = window.localStorage.getItem("userLoged");

		var utype = getUtype(aud.TYPE);
		var name = aud.RESPNAME;
		document.getElementById("userTypeInfo").innerHTML = utype+" - "+name;

		setMenuItems(actualUtype);1
	}
	else
	{
		var workArea = document.getElementById("workArea");
		workArea.style.display = "none";
		var loginCover = document.getElementById("loginArea");
		loginCover.style.display = "initial";

		if(localStorage.getItem("aud"))
		{
			localStorage.removeItem("aud");
		}
		setTimeout(function(){ resSet() }, 400);
	}
	
	// ifLoad("ifMasterLeg")
	
	// ifLoad('ifMasterR');
	// ifLoad('iforderMain');
	// orderStarter("d54feeb03e5bd1f12005d23154906925");
	
}
function getUtype(utype)
{
	if(utype == "A"){var uclass = "Administrador";}
	else if(utype == "CO"){var uclass = "Coordinador";}
	else if(utype == "JZ"){var uclass = "Jefe de Zona";}
	else if(utype == "C"){var uclass = "Cliente";}
	else if(utype == "T"){var uclass = "Técnico";}
	
	return uclass;
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
function backHome()
{
	document.getElementById("loginTitle1").innerHTML = language["loginTitle1"];
	document.getElementById("loginTitle2").innerHTML = language["loginTitle2"];
	resSet();
}
function login()
{
	var info = {};
	
	var type = document.getElementById("userTypeBox").value; 
	var email = document.getElementById("userLoginBox").value; 
	var pin = encry(document.getElementById("userPassBox").value); 

	if(type == "")
	{
                alertBox(language["alert"],language["sys022"],300);
		return;
	}
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
	info.type = type;
	info.date = getNow();
	info.optype = ltt4;
	info.target = email;

	
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
			// document.getElementById("userLoginBox").value = ""; 
			document.getElementById("userPassBox").value = ""; 
		
			aud = ans;
			
			document.getElementById("mymenu").style.display = "block";
			
			localStorage.setItem("aud",JSON.stringify(aud));
			actualUcode = aud.CODE;
			actualUname = aud.BNAME;
					
			var loginCover = document.getElementById("loginArea");
			loginCover.style.display = "none";
			
			var workArea = document.getElementById("workArea");
			workArea.style.display = "block";
			
			document.getElementById("exitIcon").style.display = "block";
			
			var utype = getUtype(aud.TYPE);
			var name = aud.RESPNAME;
			document.getElementById("userTypeInfo").innerHTML = utype+" - "+name;
			
			actualUtype = aud.TYPE;
			localStorage.setItem("userLoged",actualUtype);
			setMenuItems(actualUtype);
                        
		}
		else
		{
			alertBox(language["alert"],language["missAuth"],300);
		}
		
	});

}
function setMenuItems(value)
{
	var mainMenu = document.getElementById("mymenu");
	mainMenu.innerHTML = "";
	
	var utypePicker = document.getElementById("a-techiCat");
	var utypePickerF = document.getElementById("f-techiCat");
	
	utypePicker.value = "T";
	utypePickerF.value = "T";
	
	if(value == "A")
	{
		
		mainMenu.appendChild(menuCreator("menuMasterO"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterC"));
		mainMenu.appendChild(menuCreator("menuMasterS"));
		mainMenu.appendChild(menuCreator("menuMasterM"));
		mainMenu.appendChild(menuCreator("menuMasterT"));
		mainMenu.appendChild(menuCreator("menuMasterA"));
		mainMenu.appendChild(menuCreator("menuMasterREP"));
		mainMenu.appendChild(menuCreator("menuMasterI"));
		mainMenu.appendChild(menuCreator("menuMasterF"));
		mainMenu.appendChild(menuCreator("menuMasterLeg"));
		mainMenu.appendChild(menuCreator("menuMasterL"));
		
		
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterO');
		
		utypePicker.disabled = false;
		utypePickerF.disabled = false;
			
        
	}
	else if(value == "CO")
	{
		mainMenu.appendChild(menuCreator("menuMasterO"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterC"));
		mainMenu.appendChild(menuCreator("menuMasterS"));
		mainMenu.appendChild(menuCreator("menuMasterM"));
		mainMenu.appendChild(menuCreator("menuMasterT"));
		mainMenu.appendChild(menuCreator("menuMasterA"));
		// mainMenu.appendChild(menuCreator("menuMasterREP"));
		mainMenu.appendChild(menuCreator("menuMasterI"));
		mainMenu.appendChild(menuCreator("menuMasterF"));
		// mainMenu.appendChild(menuCreator("menuMasterL"));
		mainMenu.appendChild(menuCreator("menuMasterLeg"));
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterO');
		
		utypePicker.disabled = true;
		utypePickerF.disabled = true;
		
	}
	else if(value == "JZ")
	{
		mainMenu.appendChild(menuCreator("menuMasterO"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterC"));
		mainMenu.appendChild(menuCreator("menuMasterS"));
		mainMenu.appendChild(menuCreator("menuMasterM"));
		mainMenu.appendChild(menuCreator("menuMasterT"));
		mainMenu.appendChild(menuCreator("menuMasterA"));
		// mainMenu.appendChild(menuCreator("menuMasterREP"));
		mainMenu.appendChild(menuCreator("menuMasterI"));
		mainMenu.appendChild(menuCreator("menuMasterF"));
		// mainMenu.appendChild(menuCreator("menuMasterL"));
		mainMenu.appendChild(menuCreator("menuMasterLeg"));
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterO');
		
		utypePicker.disabled = true;
		utypePickerF.disabled = true;
		
	}
	else if(value == "C")
	{
		mainMenu.appendChild(menuCreator("menuMasterCL"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterREP"));
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterCL');
		
		utypePicker.disabled = true;
		utypePickerF.disabled = true;
		
	}
	else
	{
		mainMenu.appendChild(menuCreator("menuMasterTO"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterTO');
		
		utypePicker.disabled = true;
		utypePickerF.disabled = true;

	}
	
	
}
function respMenu() 
{
        document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
function menuCreator(id)
{
        var iface = "if"+id.split("menu")[1];
        
        var item = document.createElement("a");
        item.onclick = function(){ifLoad(iface)}
        item.innerHTML = language[id];
        var li = document.createElement("li");
        li.appendChild(item);
        return li;
}
function logout()
{
        actualInterface = "";

        var loginCover = document.getElementById("loginArea");
        loginCover.style.display = "block";
        var workArea = document.getElementById("workArea");
        workArea.style.display = "none";
        localStorage.removeItem("userLoged");
        localStorage.removeItem("aud");
		
		document.getElementById("mymenu").style.display = "none";
		
        document.getElementById("exitIcon").style.display = "none";

        var icon = document.getElementById("respIcon");

        document.getElementById("hidden").appendChild(icon)
		
		document.getElementById("userTypeInfo").innerHTML = "";
		
        actualUtype = null;
        aud = null;
        backHome();
        
        
        
}
function setSearchBoxAhead(list)
{
	var aheadOpts = [];
	for(var i=0; i<list.length; i++)
	{
		var pr = list[i];
		var desc = pr.DESCRIPTION;
		desc = desc.toLowerCase();
		if(desc[0] == "-"){desc = desc.substring(1);}
		// desc = toPhrase(desc);
		aheadOpts.push(desc);
	}
	$('#a-orderActiPicker').typeahead('destroy');
	// SET AUTOCOMPLETE FROM ARRAY
	$('#a-orderActiPicker').typeahead({fitToElement: false,source: aheadOpts});
	// document.getElementById("a-orderActiPicker").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){search();}});
}
function setSearchBoxLegs(list)
{

	var aheadOpts = [];
	for(var i=0; i<list.length; i++)
	{
		var pr = list[i];
		var desc = pr.LEGCODE;
		desc = desc.toLowerCase();
		if(desc[0] == "-"){desc = desc.substring(1);}
		// desc = toPhrase(desc);
		aheadOpts.push(desc);
	}
		
	// SET AUTOCOMPLETE FROM ARRAY
	$('#legCode').typeahead({fitToElement: false,source: aheadOpts});
	// document.getElementById("legCode").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){getLeg();}});
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
	
	if(code == "ifPassRec")
	{
		document.getElementById("workArea").style.display = "initial";
                
                
                
                return
	}
	if(code == "ifMasterC")
	{
		
                document.getElementById("a-clearerClients").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_clients_targets, "a-clients");
                        }
                        else
                        {
                                clearFields(a_clients_targets, "a-clients");
                                clientsGet();
                                clientSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                        
                        
                }
                document.getElementById("f-clearerClients").onclick = function()
                {
                        clearFields(f_clients_targets);
                        clientsGet();
                }
                clientSaveButton.innerHTML = "Crear";
                clearFields(a_clients_targets, "a-clients");
                clientsGet();
	}
	if(code == "ifMasterS")
	{
                refreshSucuParents();
                
                document.getElementById("s-clearerSucus").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_sucu_targets, "a-sucu");
                        }
                        else
                        {
                                clearFields(a_sucu_targets, "a-sucu");
                                sucuGet();
                                sucuSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                }
                document.getElementById("f-clearerSucus").onclick = function()
                {
                        clearFields(f_sucu_targets);
                        sucuGet();
                }
               sucuSaveButton.innerHTML = "Crear";
                clearFields(a_sucu_targets, "a-sucu");
                sucuGet();
	}
	if(code == "ifMasterM")
	{
                refreshMaquiParents();
    
                document.getElementById("s-clearerMaquis").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_maqui_targets, "a-maqui");
                        }
                        else
                        {
                                clearFields(a_maqui_targets, "a-maqui");
                                maquiGet();
                                maquiSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                }
                document.getElementById("f-clearerMaquis").onclick = function()
                {
                        clearFields(f_maqui_targets);
                        maquiGet();
                }
                maquiSaveButton.innerHTML = "Crear";
                clearFields(a_maqui_targets, "a-maqui");
                maquiGet();
	}
	if(code == "ifMasterT")
	{
                document.getElementById("s-clearerTechis").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_techi_targets, "a-techi");
                        }
                        else
                        {
                                clearFields(a_techi_targets, "a-techi");
                                techisGet();
                                techiSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                }
                document.getElementById("f-clearerTechis").onclick = function()
                {
                        clearFields(f_techi_targets);
                        techisGet();
                }
                techiSaveButton.innerHTML = "Crear";
                clearFields(a_techi_targets, "a-techi");
                techisGet();
	}
	if(code == "ifMasterA")
	{
                document.getElementById("s-clearerActis").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_acti_targets, "a-acti");
                        }
                        else
                        {
                                clearFields(a_acti_targets, "a-acti");
                                actisGet();
                                actiSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                }
                document.getElementById("f-clearerActis").onclick = function()
                {
                        clearFields(f_acti_targets);
                        actisGet();
                }
                actiSaveButton.innerHTML = "Crear";
                clearFields(a_acti_targets, "a-acti");
                actTypesRefresh();
                actisGet();
	}
	if(code == "ifMasterI")
	{
                document.getElementById("s-clearerInve").onclick = function()
                {
                        if(editMode == 0)
                        {
                                clearFields(a_inve_targets, "a-inve");
                        }
                        else
                        {
                                clearFields(a_inve_targets, "a-inve");
                                inveGet();
                                inveSaveButton.innerHTML = "Crear";
                                editMode = 0;
                        }
                }
                document.getElementById("f-clearerInve").onclick = function()
                {
                        clearFields(f_inve_targets);
                        inveGet();
                }
                inveSaveButton.innerHTML = "Crear";
                clearFields(a_inve_targets, "a-inve");
                inveGet();
	}
	if(code == "ifMasterL")
	{
                document.getElementById("f-clearerLog").onclick = function()
                {
                        clearFields(f_log_targets);
                        logGet();
                }
                clearFields(f_log_targets, "a-log");
                logGet();
	}
	if(code == "ifMasterO")
	{
		refreshOrderParents();
		
		document.getElementById("s-clearerOrders").onclick = function()
		{
			if(editMode == 0)
			{
				clearFields(a_orde_targets, "a-orde");
			}
			else
			{
				clearFields(a_orde_targets, "a-orde");
				ordeGet();
				orderSaveButton.innerHTML = "Crear";
				editMode = 0;
			}
		}
		document.getElementById("f-clearerOrders").onclick = function()
		{
			clearFields(f_orde_targets);
			ordeGet();
		}
	   
	   clearFields(a_orde_targets, "a-orde");
	   // clearFields(f_orde_targets);
	   actualMaquiPicks = [];
	   actualMaquisList = [];


	   orderSaveButton.innerHTML = "Crear";
	   clearFields(a_sucu_targets, "a-orde");
	   
	}
	if(code == "iforderMain")
	{
                makeBoxpand("oResumeSection","Resumen de Orden de trabajo","Resumen de Orden de trabajo", 1);
                makeBoxpand("oActisSection","Actividades de Orden","Actividades de Orden", 1);
                makeBoxpand("oPartsSection","Repuestos","Repuestos", 1);
                makeBoxpand("oOthersSection","Otros Conceptos","Otros Conceptos", 1);
                makeBoxpand("oDetailsSection","Detalles de Orden","Detalles de Orden", 1);
                makeBoxpand("opicsAdminBS","Imágenes","Imágenes", 1);
                makeBoxpand("oTimesSection","Cierre de Orden","Cierre de Orden", 1);
                
                // orderStarter("05c110845b3e8604d49c15c7a70ffbca");
                
	}
	if(code == "ifMasterR")
	{
		if(aud.TYPE == "C")
		{
				f_rep_targets = ["f-repSucu", "f-repNumber", "f-repInidate", "f-repEndate"];
				clearFields(f_rep_targets, "a-rep");
		}
		else
		{
				f_rep_targets = ["f-repParent", "f-repSucu", "f-repNumber", "f-repInidate", "f-repEndate"];
				clearFields(f_rep_targets, "a-rep");
		}
		document.getElementById("f-clearerRep").onclick = function()
		{
				
				clearFields(f_rep_targets);
				repGet();
		}
		
	   refreshReportsParents();
	   repGet();
	}
	if(code == "ifMasterLeg")
	{
		// leg_targets = ["legCode", "legItemDate"];

		document.getElementById("f-clearerLeg").onclick = function()
		{
			clearFields(legTargets);
		}
		console.log("lala")
		
		refreshLegCodes()
		
		// getLeg();

	}
	if(code == "ifMasterF")
	{
                
                clearFields(a_rec_targets);
                resoGet();
                document.getElementById("a-setReso").onclick = function()
                {
                        setResolution();
                }
                
                document.getElementById("f-clearerRec").onclick = function()
                {
                        clearFields(f_rec_targets);
                        recGet();
                }
                
               refreshReceiptParents();
               recGet();
	}
	if(code == "ifMasterTO")
	{
                refreshOrderTParents();
                
                
                document.getElementById("f-clearerOrdersT").onclick = function()
                {
                        clearFields(f_orde_targetsT);
                        ordeGetT();
                }
               
               clearFields(f_orde_targetsT);
               ordeGetT();
	}
	if(code == "ifMasterCL")
	{
		refreshOrderParentsCL();
		document.getElementById("s-clearerOrdersCL").onclick = function()
		{
				
				clearFields(a_orde_targetsCL, "a-orde");
		}
		document.getElementById("f-clearerOrdersCL").onclick = function()
		{
				clearFields(f_orde_targetsCL);
				ordeGetCL();
		}
	   

	   clearFields(f_orde_targetsCL);

	   actualMaquiPicks = [];
	   actualMaquisList = [];
	   
	   orderSaveButtonCL.innerHTML = "Crear";
	   
	   clearFields(a_orde_targetsCL, "a-orde");

	   ordeGetCL();
	}
	if(code == "ifMasterREP")
	{
		if(aud.TYPE == "A")
		{
			var rTypes =    [         
										// {"NAME": "Actividades por actividad", "VAL":"12"},
										{"NAME": "Actividades por cliente", "VAL":"4"},
										// {"NAME": "Actividades por equipo", "VAL":"1"},
										{"NAME": "Costos y uso de inventario", "VAL":"9"},
										// {"NAME": "Informe de Repuestos ", "VAL":"5"},
										{"NAME": "Imágenes de Orden de trabajo", "VAL":"3"},
										// {"NAME": "Observaciones, Pendientes y Recomendaciones", "VAL":"8"},
										{"NAME": "Ordenes de trabajo", "VAL":"2"},
										// {"NAME": "Otros por cliente", "VAL":"6"},
										// {"NAME": "Otros por tipo", "VAL":"7"},
										// {"NAME": "Tiempos de trabajo por Actividad", "VAL":"11"},
										// {"NAME": "Tiempos de trabajo por ordenes", "VAL":"10"}
								   ]
									   
		}
		if(aud.TYPE == "C")
		{
			var rTypes =    [         
										{"NAME": "Actividades por cliente", "VAL":"4"},
										// {"NAME": "Actividades por equipo", "VAL":"1"},
										// {"NAME": "Informe de Repuestos ", "VAL":"5"},
										{"NAME": "Imágenes de Orden de trabajo", "VAL":"3"},
										// {"NAME": "Observaciones, Pendientes y Recomendaciones", "VAL":"8"},
										{"NAME": "Ordenes de trabajo", "VAL":"2"},
										{"NAME": "Otros por cliente", "VAL":"6"}
											
								   ]
									   
		}

		var picker = document.getElementById("reportSelector");
		picker.innerHTML = "";
		var option = document.createElement("option");
		option.innerHTML = "Seleccione un tipo de reporte";
		option.value = "";
		picker.appendChild(option);
		
		for(var i=0; i<rTypes.length; i++)
		{
			var oData = rTypes[i];
			var option = document.createElement("option");
			option.innerHTML = oData.NAME;
			option.value = oData.VAL;
			picker.appendChild(option);
		}

		picker.value = "";
		picker.onchange();
                
	}

	resSet();
}
function refreshLegCodes()
{
	var info = {};
	info.ucode = aud.CODE;
	
	sendAjax("users","refreshLegCodes",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		setSearchBoxLegs(ans);
	});
	
}
function ordeGetCL()
{

        var  info = {};
        
        info["f-orderParent"] = document.getElementById("f-orderParentCL").value;
        info["f-orderSucu"] = document.getElementById("f-orderSucuCL").value;
        info["f-orderNum"] = document.getElementById("f-orderNumCL").value;
        info["f-orderState"] = document.getElementById("f-orderStateCL").value;
        info.techcode = "";
		info.ucode = aud.CODE;
		info.askType = aud.TYPE;
		info.places = [];
		$.each(aud.LOCATION.split("-"), function()
		{info.places.push($.trim(this));});	
        
        sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
                tableCreator("ordersTableCL", ans);
	});
}
function refreshOrderTParents()
{
        var info = {};
		info.ucode = aud.CODE;
        
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
		parents = pas.parents;
		sucus = pas.sucus;

		var a_order_parentField = document.getElementById("f-orderParentT");
		var a_order_sucuField = document.getElementById("f-orderSucuT");
		
		a_order_parentField.innerHTML = "";
		a_order_sucuField.innerHTML = "";

		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = language["a-maquiBlankClient"];
		
		a_order_parentField.appendChild(option)

		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = language["a-maquiBlankSucu"];
		
		a_order_sucuField.appendChild(option)


		for(var i=0; i<parents.length; i++)
		{
				var option = document.createElement("option");
				option.value = parents[i].CODE;
				option.innerHTML = parents[i].CNAME;
				
				a_order_parentField.appendChild(option);
		}
		

		a_order_parentField.onchange = function()
		{
			var code = this.value;
			var a_order_sucuField = document.getElementById("f-orderSucuT");
			a_order_sucuField.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = language["a-maquiBlankSucu"];
			a_order_sucuField.appendChild(option);
				
			var pickSucuList = [];
				
			for(var s=0; s<sucus.length; s++)
			{
					if(sucus[s].PARENTCODE == code)
					{
							pickSucuList.push(sucus[s]);
					}
			}
			
			for(var i=0; i<pickSucuList.length; i++)
			{
					var option = document.createElement("option");
					option.value = pickSucuList[i].CODE;
					if(pickSucuList[i].NAME == "-")
					{
							option.innerHTML = pickSucuList[i].CODE;
					}
					else
					{
							option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
					}
					
					a_order_sucuField.appendChild(option);
			}
	}
               
	});
}
function ordeGetT()
{
        var info = {};
        info["f-orderParent"] = document.getElementById("f-orderParentT").value;
        info["f-orderSucu"] = document.getElementById("f-orderSucuT").value;
        info["f-orderNum"] = document.getElementById("f-orderNumT").value;
        info["f-orderState"] = "2";
        info["techcode"] = aud.CODE;
		info.ucode = aud.CODE;
		info.askType = aud.TYPE;
		info.places = [];
		$.each(aud.LOCATION.split("-"), function()
		{info.places.push($.trim(this));});	
        
        sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;

                tableCreator("ordersTableT", ans);
	});
}
function setResolution()
{
        var  info = infoHarvest(a_rec_targets);

        if(info["a-resoNumber"] == language["a-maquiBlankClient"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un numero de resolución",300); return}
        else if(info["a-resoDate"] == language["a-maquiBlankSucu"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una fecha de resolución",300); return}
        else if(info["a-resoIninum"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un OTT inicial de resolución",300); return}
        else if(info["a-resoEndnum"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un OTT final de resolución",300); return}
        else if(info["a-resoActualnum"] == ""){info["a-resoActualnum"] = info["a-resoIninum"]}
        
        sendAjax("users","setResolution",info,function(response)
	{
		var ans = response.message;
                
                if(ans == "exist")
                {
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Ya se ha usado este OTT de resolución, no podrá usarse nuevamente", 300);
                        return;
                }
                
                
                clearFields(a_rec_targets);
                resoGet();
	});
        
        
}
function resoGet()
{
        var info = {};
        
        
        sendAjax("users","getResoList",info,function(response)
	{
		var ans = response.message;
                tableCreator("resoTable", ans);
	});
}
function repGet()
{
        var info = {};
        
        var  info = infoHarvest(f_rep_targets);
        
        if(aud.TYPE == "T"){info.f_repTech = aud.CODE;}else{info.f_repTech = "";}
        if(aud.TYPE == "C"){info["f-repParent"] = aud.CODE;}
        
        sendAjax("users","getRepList",info,function(response)
	{
		var ans = response.message;
                tableCreator("repTable", ans);
	});
}
function recGet()
{
        var info = {};
        var  info = infoHarvest(f_rec_targets);
        
        sendAjax("users","getRecList",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
                tableCreator("recTable", ans);
	});
}
function refreshReceiptParents()
{
        var info = {};
		info.ucode = aud.CODE;
        
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;

                var a_rep_parentField = document.getElementById("f-recParent");
                
                a_rep_parentField.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-repBlankClient"];
                
                a_rep_parentField.appendChild(option)
                
                for(var i=0; i<parents.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = parents[i].CODE;
                        option.innerHTML = parents[i].CNAME;
                        
                        a_rep_parentField.appendChild(option);
                        
                }
                                
	});
}
function refreshReportsParents()
{
        var info = {};
        info.ucode = aud.CODE;
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;

                var a_rep_parentField = document.getElementById("f-repParent");
                var a_rep_sucuField = document.getElementById("f-repSucu");
                
                a_rep_parentField.innerHTML = "";
                a_rep_sucuField.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-repBlankClient"];
                
                a_rep_parentField.appendChild(option)
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-repBlankSucu"];
                
                a_rep_sucuField.appendChild(option)
                
                for(var i=0; i<parents.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = parents[i].CODE;
                        option.innerHTML = parents[i].CNAME;
                        
                        a_rep_parentField.appendChild(option);
                        
                }
                
                a_rep_parentField.onchange = function()
                {
                        var code = this.value;

                        var a_rep_sucuField = document.getElementById("f-repSucu");
                        a_rep_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-repBlankSucu"];
                        a_rep_sucuField.appendChild(option);
                            
                        var pickSucuList = [];
                            
                        for(var s=0; s<sucus.length; s++)
                        {
                                if(sucus[s].PARENTCODE == code)
                                {
                                        pickSucuList.push(sucus[s]);
                                }
                        }
                        
                        for(var i=0; i<pickSucuList.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = pickSucuList[i].CODE;
                                if(pickSucuList[i].NAME == "-")
                                {
                                        option.innerHTML = pickSucuList[i].CODE;
                                }
                                else
                                {
                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                }
                                a_rep_sucuField.appendChild(option);
                        }
                }
                
                if(aud.TYPE == "C")
                {
                        a_rep_parentField.value = aud.CODE;
                        a_rep_parentField.onchange();
                        a_rep_parentField.disabled = true;
                }
                else
                {
                        // a_rep_parentField.value = "";
                        a_rep_parentField.disabled = false;
                }
                
                
	});
}
function clearFields(items, release)
{
        if(release == "a-clients"){document.getElementById("a-clientEmail").disabled = false;}
        if(release == "a-sucu"){document.getElementById("a-sucuCode").disabled = false; document.getElementById("a-sucuParent").disabled = false;}
        if(release == "a-maqui"){document.getElementById("a-maquiPlate").disabled = false; document.getElementById("a-maquiSucu").disabled = false; document.getElementById("a-maquiName").disabled = false; document.getElementById("a-maquiParent").disabled = false;}
        if(release == "a-techi"){document.getElementById("a-techiId").disabled = false; document.getElementById("a-techiEmail").disabled = false;}
        if(release == "a-acti"){document.getElementById("a-actiType").disabled = false;}
        if(release == "a-inve"){document.getElementById("a-inveCode").disabled = false;}
        if(release == "a-log"){}
        if(release == "a-orde")
        {
                document.getElementById("a-orderParent").disabled = false; 
                document.getElementById("a-orderSucu").disabled = false;
                var a_orderMaquisField = document.getElementById("a-orderMaquis");
                a_orderMaquisField.innerHTML = "";
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Equipos";
                a_orderMaquisField.appendChild(option);
				
        }
        if(release == "a-log"){}
        
        for(var i = 0; i<items.length; i++)
        {
                if(items[i] == "a-techiCat"){continue;}
                if(items[i] == "f-techiCat"){continue;}
                // if(items[i] == "legCode"){continue;}
				document.getElementById(items[i]).value = "";
        }
        
}
function orderStarter(code)
{
        var info = {};
        
        info.ocode = code;
        
        sendAjax("users","orderFullGet",info,function(response)
        {
                var ans = response.message;
                console.log(ans)
                actualOrderData = ans.oData;
                
                localStorage.setItem("tmpOrder", JSON.stringify(actualOrderData));

                var num = actualOrderData.CCODE;
                
                
                if(num.length == 1){num = "000"+num;}
                else if(num.length == 2){num = "00"+num;}
                else if(num.length == 3){num = "0"+num;}
                else{num = num;}
                
                if(actualOrderData.CLOSEDATE != null)
                {
                        var endate = actualOrderData.CLOSEDATE; 
                        var rtime = getdDiff(actualOrderData.STARTIME, actualOrderData.CLOSEDATE)+" Min";
                }
                else
                {
                        var endate = "Pendiente"; 
                        var rtime = "Pendiente";
                }
                
                if(actualOrderData.STATE == "1"){var state = "Nueva";}
                if(actualOrderData.STATE == "2"){var state = "Proceso";}
                if(actualOrderData.STATE == "3"){var state = "Revisión";}
                if(actualOrderData.STATE == "4"){var state = "Por facturar";}
                if(actualOrderData.STATE == "5"){var state = "Facturada";}
                if(actualOrderData.STATE == "6"){var state = "Previsita";}
                if(actualOrderData.STATE == "7"){var state = "Cotizado";}
                
                
                // HEADERFILL
                // if(actualOrderData.STARTIME == null){ document.getElementById("a-ostartTime").value = "";}else{document.getElementById("a-ostartTime").value = actualOrderData.STARTIME;}
                document.getElementById("oResNum").innerHTML = num;
                document.getElementById("oResPriority").innerHTML = actualOrderData.STARTIME;
                document.getElementById("ostartTime").innerHTML = actualOrderData.ENDTIME;
                document.getElementById("oResClient").innerHTML = actualOrderData.PARENTNAME;
                
                if(actualOrderData.SUCUNAME == "-")
                {
                        document.getElementById("oResSucu").innerHTML = actualOrderData.SUCUCODE;
                }
                else
                {
                        document.getElementById("oResSucu").innerHTML = actualOrderData.SUCUNAME;
                }
                
                
                
                document.getElementById("oResDate").innerHTML = actualOrderData.DATE;
                document.getElementById("oResState").innerHTML = state;
                // document.getElementById("oResClosed").innerHTML = endate;
                // document.getElementById("oReported").innerHTML = rtime;
                document.getElementById("oResTech").innerHTML = actualOrderData.TECHNAME;
                document.getElementById("oResDetail").innerHTML = actualOrderData.DETAIL;
                
                if(actualOrderData.ICODE != null && actualOrderData.ICODE != ""){var icode = actualOrderData.ICODE;}
                else{var icode = "-"}
                
                
                document.getElementById("oResIcode").innerHTML = icode;

                // MAQUILISTFILLER
                actualMaquisList = ans.maquPlist;
                actualMaquiPicks = JSON.parse(ans.oData.MAQUIS);
                maquiManage();
                maquiListPickFiller();
                
                // ACTPICKERFILL
                actiPlist = ans.actPlist;
                var picker = document.getElementById("a-orderActiPicker");
                picker.value = "";
				setSearchBoxAhead(actiPlist)
                // var option = document.createElement("option");
                // option.value = "";
                // option.innerHTML = "Actividad";
                // picker.appendChild(option);

                // for(var i=0; i < actiPlist.length; i++)
                // {
                        // var option = document.createElement("option");
                        // option.value = actiPlist[i].CODE+">"+actiPlist[i].DESCRIPTION+">"+actiPlist[i].COST+">"+actiPlist[i].DURATION;
                        // option.innerHTML = actiPlist[i].CODE+" - "+actiPlist[i].DESCRIPTION;
                        // picker.appendChild(option);
                // }
                
				document.getElementById("a-orderActPricePicker").value = "";
				document.getElementById("a-orderActDurationPicker").value = "";
				document.getElementById("a-orderActQtyPicker").value = "";
				
                // ACTLISTFILLER
                tableCreator("oActsTable", ans.oActs);
				
                actualOrderActs = ans.oActs;
                // PARTTPICKFILLER
                var partPlist = ans.partPlist;
                var picker = document.getElementById("a-orderPartPicker");
                picker.innerHTML = "";
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Repuesto";
                picker.appendChild(option);
                var option = document.createElement("option");
                option.value = "NI";
                option.innerHTML = "No inventariable";
                picker.appendChild(option);
                for(var i=0; i < partPlist.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = partPlist[i].CODE+">"+partPlist[i].DESCRIPTION+">"+parseInt(parseInt(partPlist[i].COST)+((parseInt(partPlist[i].COST)*parseInt(partPlist[i].MARGIN))/100));
                        option.innerHTML = partPlist[i].CODE+" - "+partPlist[i].DESCRIPTION;
                        picker.appendChild(option);
                }

                // PARTLISTFILLER
                tableCreator("oPartsTable", ans.oParts);
                
                 // OTHERSLISTFILLER
                tableCreator("oOthersTable", ans.oOthers);

                // DETAILFILL
                document.getElementById("a-oDetailsText").value = "";
                // document.getElementById("a-oRecomText").value = "";
                // document.getElementById("a-oPendingsText").value = "";
                document.getElementById("a-oDetailsText").value = actualOrderData.OBSERVATIONS; 
                // document.getElementById("a-oRecomText").value = actualOrderData.RECOMENDATIONS
                // document.getElementById("a-oPendingsText").value = actualOrderData.PENDINGS
                
                // PICSFILLER
                var pics = ans.oPics;
                var iniList = pics.ini;
                var endList = pics.end;
                var orderList = pics.order;
                
                var inibox = document.getElementById("picturesBoxIni");
                var endbox = document.getElementById("picturesBoxEnd");
                var orderbox = document.getElementById("picturesBoxOrder");

                
                inibox.innerHTML = "";
                endbox.innerHTML = "";
                orderbox.innerHTML = "";
				
				
                for(var i=0; i<iniList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(iniList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/ini/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/ini/'+filename;
                        span.num = i+1;
                        span.onclick = function(){showPicBox(this.path, "Foto inicial");};inibox.appendChild(span);
                }
				
                for(var i=0; i<endList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(endList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/end/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/end/'+filename;
                        span.num = i+1;
                        span.onclick = function(){showPicBox(this.path, "Foto final");};endbox.appendChild(span);
                }
				for(var i=0; i<orderList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(orderList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/order/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/order/'+filename;
                        span.num = i+1;
                        span.onclick = function(){showPicBox(this.path, "Foto final");};orderbox.appendChild(span);
                }

                if(ans.oData.STATE == "5")
                {
                        facturedLock(1);
                }
                else
                {
                        facturedLock(0);
                }
                

                // SETUPLOADFIELDS
                document.getElementById("picSelectorIni").name = actualOrderData.CODE+"[]";
                document.getElementById("picSelectorEnd").name = actualOrderData.CODE+"[]";
				document.getElementById("picSelectorOrder").name = actualOrderData.CODE+"[]";
        });
}
function facturedLock(set)
{
        if(set == 1)
        {
                // document.getElementById("a-ostartTime").disabled = true;
                document.getElementById("addActButton").disabled = true;
                document.getElementById("addPartButton").disabled = true;
                document.getElementById("addOtherButton").disabled = true;
                document.getElementById("a-oDetailsText").disabled = true;
                // document.getElementById("a-oRecomText").disabled = true;
                // document.getElementById("a-oPendingsText").disabled = true;
                // document.getElementById("picSelectorIni").disabled = true;
                // document.getElementById("picSelectorEnd").disabled = true;
                document.getElementById("oCloseButton").disabled = true;
                document.getElementById("oAprobeButton").disabled = true;
                
                
        }
        else
        {
                // document.getElementById("a-ostartTime").disabled = false;
                document.getElementById("addActButton").disabled = false;
                document.getElementById("addPartButton").disabled = false;
                document.getElementById("addOtherButton").disabled = false;
                document.getElementById("a-oDetailsText").disabled = false;
                // document.getElementById("a-oRecomText").disabled = false;
                // document.getElementById("a-oPendingsText").disabled = false;
                document.getElementById("picSelectorIni").disabled = false;
                document.getElementById("picSelectorEnd").disabled = false;
                document.getElementById("oCloseButton").disabled = false;
                document.getElementById("oAprobeButton").disabled = false;
        }
}
function setStarttime(value)
{
        var thisTime = value;
        
        if(thisTime != lastStartTime)
        {
                var info = {};
                info.ocode = actualOrderData.CODE;
                // info.date = document.getElementById("a-ostartTime").value;

                sendAjax("users","updateStarTime",info,function(response)
                {
                        var ans = response.message;
                        actualOrderData.STARTIME = info.date;
                })
        }
        lastStartTime = value;
}
function oClose()
{
        var state = actualOrderData.STATE;
        
        if(state != "2")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes cerrar ordenes que se encuentren en estado 'Proceso'", 300);
                return;
        }
        else
        {
                var param = "none";
                confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Desea hacer el cierre técnico de la orden actual?", oCloseConfirmed, 300, param);
        }
}
function oCloseConfirmed()
{
        
        var info = {};
        info.ocode = actualOrderData.CODE;
        info.odate = getNow();
        info.partial = "0";
        
        var diff = getdDiff(actualOrderData.STARTIME, getNow());
        
        info.diff = diff;
        
        // if(document.getElementById("a-ostartTime").value == "0000-00-00 00:00:00" || document.getElementById("a-ostartTime").value == "")
        // {
                // alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No ha definido una fecha de inicio valida.", 300);
                // return;
        // }
        
        if(document.getElementById("a-oDetailsText").value == "")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir alguna observación sobre la orden.", 300);
                return;
        }
        
        if(actualOrderActs.length == 0)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe agregar al menos una actividad a la orden.", 300);
                return;
        }

        document.getElementById("oCloseButton").onclick = function(){console.log("locked")}
        
        sendAjax("users","reportCreate",info,function(response)
        {
			var ans = response.message;
			
			 // ON RETURN
			document.getElementById("oResState").innerHTML = "Revisión";
			var diff = getdDiff(actualOrderData.STARTIME, getNow());
			// document.getElementById("oReported").innerHTML = diff+" Minutos";
			actualOrderData.STATE = "3";
			document.getElementById("oCloseButton").onclick = function(){oClose();}
			
			// EXIT TO ORDER LIST TECHIES
			if(aud.TYPE == "T")
			{
					ifLoad("ifMasterTO");
			}
        });
}
function oPartialRep()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        info.odate = getNow();
        info.partial = "1";
        
        var state = actualOrderData.STATE;
        // if(state != "2")
        // {
                // alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes generar reportes parciales para ordenes en 'Proceso'", 300);
                // return;
        // }
        
        var diff = getdDiff(actualOrderData.STARTIME, getNow());
        
        info.diff = diff;
        
        // if(document.getElementById("a-ostartTime").value == "0000-00-00 00:00:00" || document.getElementById("a-ostartTime").value == "")
        // {
                // alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No ha definido una fecha de inicio valida.", 300);
                // return;
        // }
        
		var iniPicsCheck = document.getElementById("picturesBoxIni").children.length;
	
		if(iniPicsCheck == 0)
		{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar como mínimo una imagen inicial.", 300);
			return;
		}
		
		var endPicsCheck = document.getElementById("picturesBoxEnd").children.length;
		
		if(endPicsCheck == 0)
		{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar como mínimo una imagen final.", 300);
			return;
		}
		
		var orderPicsCheck = document.getElementById("picturesBoxOrder").children.length;
		
		if(orderPicsCheck == 0)
		{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar la imagen de la orden de trabajo.", 300);
			return;
		}
		

        if(document.getElementById("a-oDetailsText").value == "")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir alguna observación sobre la orden.", 300);
                return;
        }
        
        if(actualOrderActs.length == 0)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe agregar al menos una actividad a la orden.", 300);
                return;
        }

        document.getElementById("parcialReport").onclick = function(){console.log("locked")}
        
        
        
        sendAjax("users","reportCreate",info,function(response)
        {
                var ans = response.message;
                console.log(ans)
                 // ON RETURN
               
                document.getElementById("parcialReport").onclick = function(){oPartialRep();}
                
                // EXIT TO ORDER LIST TECHIES
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha generado un reporte parcial de esta orden.", 300);

        });
}
function oAprobe()
{
	
	
	var iniPicsCheck = document.getElementById("picturesBoxIni").children.length;
	
	if(iniPicsCheck == 0)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar como mínimo una imagen inicial.", 300);
		return;
	}
	
	var endPicsCheck = document.getElementById("picturesBoxEnd").children.length;
	
	if(endPicsCheck == 0)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar como mínimo una imagen final.", 300);
		return;
	}
	
	var orderPicsCheck = document.getElementById("picturesBoxOrder").children.length;
	
	if(orderPicsCheck == 0)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes cargar la imagen de la orden de trabajo.", 300);
		return;
	}
	

	var state = actualOrderData.STATE;
	if(aud.TYPE != "A" && aud.TYPE != "CO" && aud.TYPE != "JZ")
	{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Tu perfil no permite aprobar ordenes", 300);
			return;
	}
	// if(state != "3")
	// {
			// alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes Aprobar ordenes que se encuentren en estado 'Revisión'", 300);
			// return;
	// }

	var param = "none";
	confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿DeseasAprobar la orden actual? esta cambiará a estado 'Por facturar'.", oAprobeConfirmed, 300, param);

}
function oAprobeConfirmed()
{
        // document.getElementById("oResState").innerHTML = "Por facturar";
        // actualOrderData.STATE = "4";
		
        var info = {};
        info.odate = getNow();
        info.ocode = actualOrderData.CODE;
        
        var diff = getdDiff(actualOrderData.STARTIME, actualOrderData.CLOSEDATE);
        
        info.diff = diff;
        
        sendAjax("users","reportCreateTotalized",info,function(response)
        {
                var ans = response.message;

                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden ha cambiado a estado 'Por facturar' ya puede ser incluida en facturación", 300);
                // EXIT TO ORDER LIST TECHIES
                // ifLoad("ifMasterO");
        });
        
}
function getdDiff(startDate, endDate) 
{
        var startTime = new Date(startDate); 
        var endTime = new Date(endDate);
        var difference = endTime.getTime() - startTime.getTime();
        return Math.round(difference / 60000);
}
function refreshOpics()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getOpics",info,function(response)
        {
                var ans = response.message;
                var iniList = ans.ini;
                var endList = ans.end;
                var orderList = ans.order;
                
                var inibox = document.getElementById("picturesBoxIni");
                var endbox = document.getElementById("picturesBoxEnd");
                var orderbox = document.getElementById("picturesBoxOrder");
                
                inibox.innerHTML = "";
                endbox.innerHTML = "";
                orderbox.innerHTML = "";
                
                
                for(var i=0; i<iniList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(iniList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/ini/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/ini/'+filename;
                        span.num = i+1;
                        span.onclick = function()
                        {
                                showPicBox(this.path, "Foto inicial");
                        }
                        inibox.appendChild(span);
                }
                
                for(var i=0; i<endList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(endList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/end/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/end/'+filename;
                        span.num = i+1;
                        span.onclick = function()
                        {
                                showPicBox(this.path, "Foto final");
                        }
                        endbox.appendChild(span);
                }
				
				for(var i=0; i<orderList.length; i++)
                {
                        var span = document.createElement('span');
                        var filename = encry(orderList[i]);
                        
                        span.innerHTML = "<img class='imageBoxView' src='irsc/pics/"+actualOrderData.CODE+"/order/"+filename+"'/>";
                        span.path = 'irsc/pics/'+actualOrderData.CODE+'/order/'+filename;
                        span.num = i+1;
                        span.onclick = function()
                        {
							showPicBox(this.path, "Foto Orden");
                        }
                        orderbox.appendChild(span);
                }
               
        });
}
function showPicBox(path, title)
{
        var picBox = document.getElementById("modalPicBox");
        picBox.innerHTML = "";
                                
        var image = document.createElement("img");
        image.src = path;
        image.className = "modalPicBox";
        
        var exit = document.createElement("button");
        exit.className = "singleButtonPop";
        exit.innerHTML = "Cerrar";
        exit.onclick = function(){hide_pop_form()};

        picBox.appendChild(image);
        
        var exitBox = document.createElement("div");
        exitBox.className = "dualButtonsDiv";
        
        exitBox.appendChild(exit);
        
        picBox.appendChild(exitBox);

        image.parentNode.style.textAlign = "center";
        
        formBox("modalPicBox",title,640);
}
function refreshoDetails()
{
        var info = {};
        info.ocode = actualOrderData.CODE;

        sendAjax("users","getoDetails",info,function(response)
        {
                var ans = response.message;

                document.getElementById("a-oDetailsText").value = "";
                // document.getElementById("a-oRecomText").value = "";
                // document.getElementById("a-oPendingsText").value = "";

                document.getElementById("a-oDetailsText").value = ans.obs; 
                // document.getElementById("a-oRecomText").value = ans.rec; 
                // document.getElementById("a-oPendingsText").value = ans.pen; 

        });
}
function updateOdetails()
{
        var info = {};
        info.ocode = actualOrderData.CODE;

        info.obs = document.getElementById("a-oDetailsText").value;
        // info.rec = document.getElementById("a-oRecomText").value;
        // info.pen = document.getElementById("a-oPendingsText").value;
        
         sendAjax("users","updateoDets",info,function(response)
        {
                
        });

}
function refreshoActList()
{
        var info = {};
        info.value = document.getElementById("preActFilter").value;
        
        sendAjax("users","getoActiList",info,function(response)
        {
                var ans = response.message;
                
                var picker = document.getElementById("a-orderActiPicker");
                
                picker.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Actividad";
                
                picker.appendChild(option);

                for(var i=0; i < ans.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = ans[i].CODE+">"+ans[i].DESCRIPTION+">"+ans[i].COST+">"+ans[i].DURATION;
                        option.innerHTML = ans[i].CODE+" - "+ans[i].DESCRIPTION;
                        
                        picker.appendChild(option);
                }

        });
}
function refreshoPartsList()
{
        var info = {};
        info.value = document.getElementById("prePartFilter").value;
        
        sendAjax("users","getoPartList",info,function(response)
        {
                var ans = response.message;
                
                var picker = document.getElementById("a-orderPartPicker");
                
                picker.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Repuesto";
                
                picker.appendChild(option);
                
                var option = document.createElement("option");
                option.value = "NI";
                option.innerHTML = "No inventariable";
                
                picker.appendChild(option);

                for(var i=0; i < ans.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = ans[i].CODE+">"+ans[i].DESCRIPTION+">"+ans[i].COST;
                        option.innerHTML = ans[i].CODE+" - "+ans[i].DESCRIPTION;
                        
                        picker.appendChild(option);
                }

        });
}
function setPartForm(value)
{
	var pdescField = document.getElementById("a-oPartDesc");
	var pqtyField = document.getElementById("a-orderQtyPicker");
	var pcostField = document.getElementById("a-oPartCost");
	var pdocField = document.getElementById("a-oPartDoc");
	
	pdescField.value = "";
	pqtyField.value = "1";
	pcostField.value = "";
	pdocField.value = "";
	
	if(value == "")
	{
		pdescField.disabled = true;
		pcostField.disabled = true;
		pdocField.disabled = true;
	}
	else if(value == "NI")
	{
		pdescField.disabled = false;
		pcostField.disabled = false;
		pdocField.disabled = false;
	}
	else
	{
		var valDesc = value.split(">")[1];
		var valCost = value.split(">")[2];

		if(aud.TYPE == "A" || aud.TYPE == "JZ" || aud.TYPE == "CO"){pcostField.value = valCost;}
		else{pcostField.value = "-";}

		pdescField.value = valDesc;
		
		pdescField.disabled = true;
		pcostField.disabled = true;
		pdocField.disabled = true;
	}
}
function setOthersForm(picker) 
{
	var value = picker.value;
	
	var odescField = document.getElementById("a-oOtherDesc");
	var oqtyField = document.getElementById("a-otherQtyPicker");
	var ocostField = document.getElementById("a-oOtherCost");
	var odocField = document.getElementById("a-oOtherDoc");
	
	odescField.value = "";
	oqtyField.value = "1";
	ocostField.value = "";
	odocField.value = "";
	
	if(value == "")
	{
			odescField.disabled = true;
			ocostField.disabled = true;
			odocField.disabled = true;
	}
	else if(value == "Otros")
	{
			odescField.disabled = false;
			ocostField.disabled = false;
			odocField.disabled = false;
	}
	else
	{
			odescField.value = $('#a-orderOtherType option:selected').html();
			odescField.disabled = false;
			ocostField.disabled = false;
			odocField.disabled = false;
	}

        
}
function addPart()
{
        var value = document.getElementById("a-orderPartPicker").value;
        var info = {};
        info.pamount = document.getElementById("a-orderQtyPicker").value;
        info.ocode = actualOrderData.CODE;
        info.date = getNow();
        
         if(value == "")
        {
                alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un repuesto", 300);
                return;
        }
        else if(value == "NI")
        {
                info.pcode = "NI";
                info.pdesc = document.getElementById("a-oPartDesc").value;
                info.pcost = document.getElementById("a-oPartCost").value;
                info.pdoc = document.getElementById("a-oPartDoc").value;
                
                if(info.pcost == "")
                {
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el costo del repuesto", 300);
                        return
                }
                
                if(info.pdoc == "")
                {
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el documento de compra del repuesto", 300);
                        return
                }
        }
        else
        {
                info.pcode = value.split(">")[0];
                info.pdesc = value.split(">")[1];
                info.pcost = value.split(">")[2];
                info.pdoc = "";
        }
        
		console.log(info)
        
		// return
        
	sendAjax("users","saveoPart",info,function(response)
	{
		var ans = response.message;
		refreshoParts();
        });
}
function addOther()
{
	   alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Para agregar costos a la orden debes hacerlo desde el módulo de legalización", 300); 
	   
	   return
		
		var value = document.getElementById("a-orderOtherType").value;
        var info = {};
        info.oamount = document.getElementById("a-otherQtyPicker").value;
        info.ocode = actualOrderData.CODE;
        info.date = getNow();

         if(value == "")
        {
                alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un tipo de concepto", 300);
                return;
        }

        info.otype = document.getElementById("a-orderOtherType").value;
        info.odesc = document.getElementById("a-oOtherDesc").value;
        info.ocost = document.getElementById("a-oOtherCost").value;
        info.odoc = document.getElementById("a-oOtherDoc").value;

        if(info.odesc == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una descripción", 300); return}
        if(info.ocost == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un costo", 300);return}
        if(info.odoc == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un numero de recibo o factura", 300);return}
        

	sendAjax("users","saveoOther",info,function(response)
	{
		var ans = response.message;
		document.getElementById("a-orderOtherType").value = "";
		document.getElementById("a-orderOtherType").onchange();
		refreshoOther();
	});
}
function refreshoOther()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getOothers",info,function(response)
        {
                var list = response.message;
                document.getElementById("a-oOtherDesc").value = "";
                document.getElementById("a-oOtherCost").value = "";
                document.getElementById("a-oOtherCost").value = "";
                document.getElementById("a-oOtherDoc").value = "";
                tableCreator("oOthersTable", list);
        });
}
function refreshOrderParents()
{
	var info = {};
	info.ucode = aud.CODE;
	
        
	sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
		parents = pas.parents;
		sucus = pas.sucus;
		orders = pas.orders;
		legs = pas.legs;
		
		
		var a_order_parentField = document.getElementById("a-orderParent");
		var a_order_sucuField = document.getElementById("a-orderSucu");
		var f_order_parentField = document.getElementById("f-orderParent");
		var f_order_sucuField = document.getElementById("f-orderSucu");
		var a_orderMaquisField = document.getElementById("a-orderMaquis");
		
		var legParentField = document.getElementById("legItemParent");

		a_order_parentField.innerHTML = "";
		legParentField.innerHTML = "";
		a_order_sucuField.innerHTML = "";
		f_order_parentField.innerHTML = "";
		f_order_sucuField.innerHTML = "";
		a_orderMaquisField.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = language["a-maquiBlankClient"];
		
		a_order_parentField.appendChild(option)
		f_order_parentField.appendChild(option.cloneNode(true));
		legParentField.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = language["a-maquiBlankSucu"];
		
		a_order_sucuField.appendChild(option)
		f_order_sucuField.appendChild(option.cloneNode(true));
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Equipos";
		a_orderMaquisField.appendChild(option.cloneNode(true));
		
		for(var i=0; i<parents.length; i++)
		{
				var option = document.createElement("option");
				option.value = parents[i].CODE;
				option.innerHTML = parents[i].CNAME;
				
				a_order_parentField.appendChild(option);
				f_order_parentField.appendChild(option.cloneNode(true));
				legParentField.appendChild(option.cloneNode(true));
		}
		
		a_order_parentField.onchange = function()
		{
			var code = this.value;
			var a_order_sucuField = document.getElementById("a-orderSucu");
			a_order_sucuField.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = language["a-maquiBlankSucu"];
			a_order_sucuField.appendChild(option);
			
			console.log(sucus)
				
			var pickSucuList = [];
				
			for(var s=0; s<sucus.length; s++)
			{
					if(sucus[s].PARENTCODE == code)
					{
							pickSucuList.push(sucus[s]);
					}
			}
			
			for(var i=0; i<pickSucuList.length; i++)
			{
					var option = document.createElement("option");
					option.value = pickSucuList[i].CODE;
					if(pickSucuList[i].NAME == "-")
					{
							option.innerHTML = pickSucuList[i].CODE;
					}
					else
					{
							option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
					}
					a_order_sucuField.appendChild(option);
			}
		}
		
		f_order_parentField.onchange = function()
		{
			var code = this.value;
			var f_order_sucuField = document.getElementById("f-orderSucu");
			f_order_sucuField.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = language["a-maquiBlankSucu"];
			f_order_sucuField.appendChild(option);
				
			var pickSucuList = [];
				
			for(var s=0; s<sucus.length; s++)
			{
					if(sucus[s].PARENTCODE == code)
					{
							pickSucuList.push(sucus[s]);
					}
			}
			
			for(var i=0; i<pickSucuList.length; i++)
			{
					var option = document.createElement("option");
					option.value = pickSucuList[i].CODE;
					if(pickSucuList[i].NAME == "-")
					{
							option.innerHTML = pickSucuList[i].CODE;
					}
					else
					{
							option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
					}
					f_order_sucuField.appendChild(option);
			}
			
			ordeGet();
		}
		
		a_order_sucuField.onchange = function()
		{
			var code = this.value;
			var info = {};
			info.code = code;
			
			actualSucuCity = getActualLocation(code);

			
			actualMaquisList = [];
			
			sendAjax("users","getMaquiListSelect",info,function(response)
			{
				var ans = response.message;

				var a_orderMaquisField = document.getElementById("a-orderMaquis");
				a_orderMaquisField.innerHTML = "";
				var option = document.createElement("option");
				option.value = "";
				option.innerHTML = "Equipos";
				a_orderMaquisField.appendChild(option);
				
				actualMaquisList = ans;
				
				console.log(actualMaquisList)
				
				// if(editMode == 1)
				// {
					// maquiManage();
					// maquiListPickFiller();
				// }
				// else
				// {
					// actualMaquiPicks = [];
				// }
				
				// PRESET LOCATIVAS
				
				var list = actualMaquisList; 

				
				for(var i=0; i<list.length; i++)
				{
					var item = list[i];
					var option = document.createElement("option");
					option.value = item.CODE;
					option.innerHTML = "Locativas";
					a_orderMaquisField.appendChild(option);
					
					a_orderMaquisField.value =  item.CODE;
					break;
				}
				

			});

		}
		
		legParentField.onchange = function()
		{
			var code = this.value;
			var ordersField = document.getElementById("legItemOrder");
			var olocation = document.getElementById("legItemZone").value.toUpperCase();
			// console.log(orders)
			// console.log(olocation)
			
			ordersField.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "Selecciona orden";
			ordersField.appendChild(option);
				
			var pickOrderList = [];
				
			for(var s=0; s<orders.length; s++)
			{
					if(orders[s].PARENTCODE == code)
					{
						if(olocation != "")
						{
							
							var oloc = orders[s].LOCATION.toUpperCase();
							
							
							if(oloc.indexOf(olocation) > -1)
							{
								pickOrderList.push(orders[s]);
								console.log(oloc)
								console.log(olocation)
							}
						}
						else
						{
							pickOrderList.push(orders[s]);
						}
						
					}
			}
		
			for(var i=0; i<pickOrderList.length; i++)
			{
					
					var num = pickOrderList[i].CCODE;
					var sucu = pickOrderList[i].SUCUNAME;
				
					if(num.length == 1){num = "000"+num;}
					else if(num.length == 2){num = "00"+num;}
					else if(num.length == 3){num = "0"+num;}
					else{num = num;}
					
					
					
					var option = document.createElement("option");
					option.value = pickOrderList[i].CODE;
					option.innerHTML = num+" - "+sucu;
					ordersField.appendChild(option);
			}
		}
		
		
		// DELETE TESTING PREFILLS
		// document.getElementById("legCode").value = "001";
		// document.getElementById("legItemParent").value = "74794a751c3454131024878ada8b60db";
		// document.getElementById("legItemDate").value = "2018-10-18";
		// document.getElementById("legItemNumber").value = "015";
		// document.getElementById("legItemConcept").value = "620";
		// document.getElementById("legItemCname").value = "El cliente";
		// document.getElementById("legItemId").value = "10031785";
		// document.getElementById("legItemBase").value = "100000";
		// document.getElementById("legItemTax").value = "19000";
		// document.getElementById("legItemTotal").value = "119000";
		// document.getElementById("legItemRetFont").value = "5000";
		// document.getElementById("legItemRetICA").value = "4000";
		// document.getElementById("legItemPayment").value = "112000";
		
		var orderParent = ofilters[0];
		var orderSucu = ofilters[1];
		var orderLocation = ofilters[2];
		var orderAuthor = ofilters[3];
		var orderNum = ofilters[4];
		var orderState = ofilters[5];

		if(orderParent != "")
		{
			document.getElementById("f-orderParent").value = orderParent;
			document.getElementById("f-orderParent").onchange();
		}
		if(orderSucu != ""){document.getElementById("f-orderSucu").value = orderSucu;}
		if(orderLocation != ""){document.getElementById("f-orderLocation").value = orderLocation;}
		if(orderAuthor != ""){document.getElementById("f-orderAuthor").value = orderAuthor;}
		if(orderNum != ""){document.getElementById("f-orderNum").value = orderNum;}
		if(orderState != ""){document.getElementById("f-orderState").value = orderState;}
		
		ordeGet();
		
	});
}
function shootFilter()
{
	document.getElementById("legItemParent").onchange();
}
function getActualLocation(code)
{
	var list = sucus;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.CODE == code)
		{
			var actualSucuCity = item.CITY+" - "+item.DEPTO;
			return actualSucuCity;
			break;
		}
	}
	return false;
	
}
function refreshOrderParentsCL()
{
        var info = {};
		info.ucode = aud.CODE;
        
	sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;

                var a_order_parentField = document.getElementById("a-orderParentCL");
                var a_order_sucuField = document.getElementById("a-orderSucuCL");
                var f_order_parentField = document.getElementById("f-orderParentCL");
                var f_order_sucuField = document.getElementById("f-orderSucuCL");
                var a_orderMaquisField = document.getElementById("a-orderMaquisCL");

                a_order_parentField.innerHTML = "";
                a_order_sucuField.innerHTML = "";
                f_order_parentField.innerHTML = "";
                f_order_sucuField.innerHTML = "";
                a_orderMaquisField.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-maquiBlankClient"];
                
                a_order_parentField.appendChild(option)
                f_order_parentField.appendChild(option.cloneNode(true));
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-maquiBlankSucu"];
                
                a_order_sucuField.appendChild(option)
                f_order_sucuField.appendChild(option.cloneNode(true));
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Equipos";
                a_orderMaquisField.appendChild(option.cloneNode(true));
                
                for(var i=0; i<parents.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = parents[i].CODE;
                        option.innerHTML = parents[i].CNAME;
                        
                        a_order_parentField.appendChild(option);
                        f_order_parentField.appendChild(option.cloneNode(true));
                }
                
                a_order_parentField.onchange = function()
                {
                        var code = this.value;
                        var a_order_sucuField = document.getElementById("a-orderSucuCL");
                        a_order_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-maquiBlankSucu"];
                        a_order_sucuField.appendChild(option);
                            
                        var pickSucuList = [];
                            
                        for(var s=0; s<sucus.length; s++)
                        {
                                if(sucus[s].PARENTCODE == code)
                                {
                                        pickSucuList.push(sucus[s]);
                                }
                        }
                        
                        for(var i=0; i<pickSucuList.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = pickSucuList[i].CODE;
                                if(pickSucuList[i].NAME == "-")
                                {
                                        option.innerHTML = pickSucuList[i].CODE;
                                }
                                else
                                {
                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                }
                                a_order_sucuField.appendChild(option);
                        }
                }
                
                f_order_parentField.onchange = function()
                {
                        var code = this.value;
                        var f_order_sucuField = document.getElementById("f-orderSucuCL");
                        f_order_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-maquiBlankSucu"];
                        f_order_sucuField.appendChild(option);
                            
                        var pickSucuList = [];
                            
                        for(var s=0; s<sucus.length; s++)
                        {
                                if(sucus[s].PARENTCODE == code)
                                {
                                        pickSucuList.push(sucus[s]);
                                }
                        }
                        
                        for(var i=0; i<pickSucuList.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = pickSucuList[i].CODE;
                                if(pickSucuList[i].NAME == "-")
                                {
                                        option.innerHTML = pickSucuList[i].CODE;
                                }
                                else
                                {
                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                }
                                f_order_sucuField.appendChild(option);
                        }
                        
                        ordeGetCL();
                }
                
                a_order_sucuField.onchange = function()
                {
                        var code = this.value;

                        var info = {};
                        info.code = code;
                        
                        actualMaquisList = [];
                        
                        sendAjax("users","getMaquiListSelect",info,function(response)
                        {
                                var ans = response.message;

                                var a_orderMaquisField = document.getElementById("a-orderMaquisCL");
                                a_orderMaquisField.innerHTML = "";
                                var option = document.createElement("option");
                                option.value = "";
                                option.innerHTML = "Equipos";
                                a_orderMaquisField.appendChild(option);
                                
                                actualMaquisList = ans;
                                

                                if(editMode == 1)
                                {
                                        maquiManage();
                                        maquiListPickFiller();
                                }
                                else
                                {
                                        actualMaquiPicks = [];
                                }
  
                        });

                }
                
                a_order_parentField.value = aud.CODE;
                a_order_parentField.onchange();
                
                f_order_parentField.value = aud.CODE;
                f_order_parentField.onchange();
                
                a_order_parentField.disabled = true;
                f_order_parentField.disabled = true;
                
                
                
	});
}
function handleFileSelectIni(evt) 
{
        var files = evt.target.files; // FileList object
        var pickBox = document.getElementById('picturesBoxIni');
        var pickSelector = document.getElementById('picSelectorIni');
        
        if(files.length > 6)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar hasta 6 fotos Iniciales", 300);
                pickBox.innerHTML = "";
                pickSelector.value = "";
                return;
        }
        
        pickBox.innerHTML = " ";
        
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0; i < files.length; i++) 
        {
                // Only process image files.
                var f = files[i];
                
                files[i].name = "ini-"+files[i].name;
                
                if(parseInt(files[i].size) > 500000)
                {
                        pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>El tamaño máximo por fotografia es de 500K", 300);
                        
                        setTimeout(function()
                        {
                                document.getElementById('picturesBoxIni').innerHTML = "";
                        },100);
                        break;
                }
				
				console.log(files[i])
				var fname = files[i].name;
				var ext = fname.split(".")[(fname.split(".").length)-1];

				if(ext == "JPE" || ext == "jpe")
				{
					 pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo debes cargar imágenes jpg o jpeg o png", 300);
                        
                        setTimeout(function()
                        {
                                document.getElementById('picturesBoxIni').innerHTML = "";
                        },100);
                        break;
				}
				
				console.log("testing")
        
                if (!f.type.match('image.*')){continue;}
                var reader = new FileReader();

                // Closure to capture the file Información.
                reader.onload = (function(theFile)
                {
                        return function(e) 
                        {
                                // Render thumbnail.
                                var span = document.createElement('span');
                                span.innerHTML = ['<img class="imageBoxView" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                                pickBox.appendChild(span, null);
                                span.path = e.target.result;
                                span.onclick = function()
                                {
                                        showPicBox(this.path, "Foto inicial ");
                                }
                        };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
        }
}
function handleFileSelectEnd(evt) 
{
        var files = evt.target.files; // FileList object
        var pickBox = document.getElementById('picturesBoxEnd');
        var pickSelector = document.getElementById('picSelectorEnd');
        
        if(files.length > 6)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar hasta 6 fotos finales", 300);
                pickBox.innerHTML = "";
                pickSelector.value = "";
                return;
        }
        
        pickBox.innerHTML = "";
        
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0; i < files.length; i++) 
        {
                // Only process image files.
                var f = files[i];
                
                if(parseInt(files[i].size) > 500000)
                {
                        pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>El tamaño máximo por fotografia es de 500K", 300);
                        
                        setTimeout(function()
                        {
                                document.getElementById('picturesBoxEnd').innerHTML = "";
                        },100);
                        break;
                }
				
				console.log(files[i])
				var fname = files[i].name;
				var ext = fname.split(".")[(fname.split(".").length)-1];

				if(ext == "JPE" || ext == "jpe")
				{
					 pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo debes cargar imágenes jpg o jpeg o png", 300);
                        
                        setTimeout(function()
                        {
                                document.getElementById('picturesBoxEnd').innerHTML = "";
                        },100);
                        break;
				}
				
                if (!f.type.match('image.*')){continue;}
                var reader = new FileReader();

                // Closure to capture the file Información.
                reader.onload = (function(theFile)
                {
                        return function(e) 
                        {
                                // Render thumbnail.
                                var span = document.createElement('span');
                                span.innerHTML = ['<img class="imageBoxView" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                                pickBox.appendChild(span, null);
                                span.path = e.target.result;
                                span.onclick = function()
                                {
                                        showPicBox(this.path, "Foto Final ");
                                }
                        };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
        }
}
function handleFileSelectOrder(evt) 
{
        var files = evt.target.files; // FileList object
        var pickBox = document.getElementById('picturesBoxOrder');
        var pickSelector = document.getElementById('picSelectorOrder');
        
        if(files.length > 1)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar 1 foto de orden", 300);
                pickBox.innerHTML = "";
                pickSelector.value = "";
                return;
        }
        
        pickBox.innerHTML = "";
        
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0; i < files.length; i++) 
        {
                // Only process image files.
                var f = files[i];
                
                if(parseInt(files[i].size) > 500000)
                {
                        pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>El tamaño máximo por fotografia es de 500K", 300);
                        
                        setTimeout(function()
                        {
							document.getElementById('picturesBoxOrder').innerHTML = "";
                        },100);
                        break;
                }
				
				
				console.log(files[i])
				var fname = files[i].name;
				var ext = fname.split(".")[(fname.split(".").length)-1];

				if(ext == "JPE" || ext == "jpe")
				{
					 pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo debes cargar imágenes jpg o jpeg o png", 300);
                        
                        setTimeout(function()
                        {
                                document.getElementById('picturesBoxOrder').innerHTML = "";
                        },100);
                        break;
				}
				
                if (!f.type.match('image.*')){continue;}
                var reader = new FileReader();

                // Closure to capture the file Información.
                reader.onload = (function(theFile)
                {
                        return function(e) 
                        {
                                // Render thumbnail.
                                var span = document.createElement('span');
                                span.innerHTML = ['<img class="imageBoxView" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                                pickBox.appendChild(span, null);
                                span.path = e.target.result;
                                span.onclick = function()
                                {
                                        showPicBox(this.path, "Foto Final");
                                }
                        };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
        }
		
		
}
function handleFileSelectBudget(evt) 
{
        var files = evt.target.files; // FileList object
        var pickSelector = document.getElementById('budgetSelectorOrder');
        actualLoadType = "bud";
		
		loadFileName = files[0].name;
		console.log(loadFileName)
		
        if(files.length > 1)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar 1 archivo de cotización.", 300);
                pickBox.innerHTML = "";
                pickSelector.value = "";
                return;
        }
        
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0; i < files.length; i++) 
        {
                // Only process image files.
                var f = files[i];
                
                if(parseInt(files[i].size) > 500000)
                {
                        pickSelector.value = "";
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>El tamaño máximo por archivo es de 500K", 300);
                        
                        setTimeout(function()
                        {
							document.getElementById('picturesBoxOrder').innerHTML = "";
                        },100);
                        break;
                }
        
                if (!f.type.match('image.*')){continue;}
                var reader = new FileReader();

        }
		
		document.getElementById("upButtonBudget").click();
		$("#loaderDiv").fadeIn();
		
		pickSelector.value = "";
		
		return;
		
		
}
function loadPics(param)
{
	actualLoadType = param;
	
	var pickSelector = document.getElementById("picSelector"+param);

	if(pickSelector.value == "")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar por lo menos una imagen para cargar",300);
		return;
	}
        // document.getElementById(param+'_upload_process').style.display = 'block';
	document.getElementById("upButton"+param).click();
}
function loadFinish(result)
{
	
	if (result == 1)
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Carga completada",300);
	}
	else 
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Error en la carga",300);
	}
	
	if(actualLoadType != "bud")
	{
		document.getElementById("picSelector"+actualLoadType).value = "";
	}
	else
	{
		
		saveFilePath();
	}

}
function saveFilePath()
{
	console.log(loadFileName)
	$("#loaderDiv").fadeOut();
	
	var info = {};
	info.ocode = actualLoadOrder;
	info.fileLink = loadFileName;
	
	console.log(info);
        
	sendAjax("users","setFileLink",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		ordeGet();
	});
	
	
	
	// ACTUALIZAR FILE PATH ORDER
}
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
function clientsGet()
{
        var info = {};
        var  info = infoHarvest(f_clients_targets);
        
        sendAjax("users","getClientList",info,function(response)
	{
		var ans = response.message;
                tableCreator("clientesTable", ans);
	});
}
function clientsSave(item)
{
        var  info = infoHarvest(a_clients_targets);
        
       
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info.utype = "C";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "C";
        info.target = info["a-clientEmail"];
        
        if(info["a-clientName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de cliente",300); return}
        else if(info["a-clientManager"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de responsable",300); return}
        else if(info["a-clientNit"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un NIT o ID",300); return}
        else if(info["a-clientNature"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar la naturaleza del cliente",300); return}
        else if(info["a-clientLocation"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir Ciudad y Depto",300); return}
        else if(info["a-clientAddress"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una dirección",300); return}
        else if(info["a-clientEmail"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un Email",300); return}
        else if(info["a-clientPhone"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir al menos un teléfono",300); return}

        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","clientSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys002"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_clients_targets, "a-clients");
                                clientsGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                 info.ccode = actualClientCode;
                
                sendAjax("users","clientSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_clients_targets, "a-clients");
                        clientSaveButton.innerHTML = "Crear";
                        clientsGet();
                });
        }
}
function refreshSucuParents()
{
        
        var info = {};
        
        sendAjax("users","getSucuParents",info,function(response)
	{
		var list = response.message;
                
                var a_field = document.getElementById("a-sucuParent");
                a_field.innerHTML = "";
                
                var f_field = document.getElementById("f-sucuParent");
                f_field.innerHTML = "";

                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Seleccionar cliente";

                a_field.appendChild(option);
                var option = option.cloneNode(true);
                f_field.appendChild(option);
                
                for(var i = 0; i<list.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = list[i].CODE;
                        option.innerHTML = list[i].CNAME;
                        a_field.appendChild(option);
                        
                        var option = option.cloneNode(true);
                        f_field.appendChild(option);
                }
	});
}
function a_sucuPickedCountry(selection)
{
	var dtoSelector = document.getElementById("a-sucuDepto");
	var ctySelector = document.getElementById("a-sucuCity");
	ctySelector.innerHTML = '<option id="a-sucuPickCityBlank" value="">'+language["a-sucuPickCityBlank"]+'</option>';
	
	a_sucuActualCountry = selection;
	
	if(selection == "")
	{
		dtoSelector.innerHTML = '<option id="a-sucuPickDeptoBlank" value="">'+language["a-sucuPickDeptoBlank"]+'</option>';
	}
	else
	{
		dtoSelector.innerHTML = '<option id="a-sucuPickDeptoBlank" value="">'+language["a-sucuPickDeptoBlank"]+'</option>';
		
		if(selection == "Colombia")
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

		var ctySelector = document.getElementById("a-sucuCity");
		ctySelector.innerHTML = '<option id="a-sucuPickCityBlank" value="">'+language["a-sucuPickCityBlank"]+'</option>';
	}
}
function a_sucuPickedDepto(selection)
{
	var ctySelector = document.getElementById("a-sucuCity");
	ctySelector.innerHTML = '<option id="a-sucuPickCityBlank" value="">'+language["a-sucuPickCityBlank"]+'</option>';
	
	if(selection == "")
	{
		ctySelector.innerHTML = '<option id="a-sucuPickCityBlank" value="">'+language["a-sucuPickCityBlank"]+'</option>';
		$("#promoCountrySelector").trigger("change");
	}
	else
	{
		ctySelector.innerHTML = '<option id="a-sucuPickCityBlank" value="">'+language["a-sucuPickCityBlank"]+'</option>';

		if(a_sucuActualCountry == "Colombia")
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
function sucuGet()
{
        var info = {};
        var  info = infoHarvest(f_sucu_targets);
        sendAjax("users","getSucuList",info,function(response)
	{
		var ans = response.message;
                tableCreator("sucusTable", ans);
	});
}
function sucuSave(item)
{
        var  info = infoHarvest(a_sucu_targets);
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info["a-sucuParentName"] = $("#a-sucuParent option:selected").text();
        
        info.utype = "S";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "S";
        info.target = info["a-sucuCode"];
        
        info["a-sucuCountry"] = $("#a-sucuCountry option:selected").text();
        info["a-sucuDepto"] = $("#a-sucuDepto option:selected").text();
        info["a-sucuCity"] = $("#a-sucuCity option:selected").text();

        if(info["a-sucuParent"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente",300); return}
        else if(info["a-sucuCode"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un código de sucursal",300); return}
        else if(info["a-sucuName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de sucursal",300); return}
        else if(info["a-sucuAddress"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una dirección",300); return}
        else if(info["a-sucuPhone"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir al menos un teléfono",300); return}
        else if(info["a-sucuCountry"] == language["a-sucuPickCountryBlank"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un país",300); return}
        else if(info["a-sucuDepto"] == language["a-sucuPickDeptoBlank"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un departamento",300); return}
        else if(info["a-sucuCity"] == language["a-sucuPickCityBlank"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una ciudad o municipio",300); return}

        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","sucuSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys014"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_sucu_targets, "a-sucu");
                                sucuGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                
                sendAjax("users","sucuSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_sucu_targets, "a-sucu");
                        sucuSaveButton.innerHTML = "Crear";
                        sucuGet();
                });
        }
}
function refreshMaquiParents()
{
        var info = {};
		info.ucode = aud.CODE;
		console.log(info)
        
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;

                var a_maqui_parentField = document.getElementById("a-maquiParent");
                var a_maqui_sucuField = document.getElementById("a-maquiSucu");
                var f_maqui_parentField = document.getElementById("f-maquiParent");
                var f_maqui_sucuField = document.getElementById("f-maquiSucu");
                
                a_maqui_parentField.innerHTML = "";
                a_maqui_sucuField.innerHTML = "";
                f_maqui_parentField.innerHTML = "";
                f_maqui_sucuField.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-maquiBlankClient"];
                
                a_maqui_parentField.appendChild(option)
                f_maqui_parentField.appendChild(option.cloneNode(true));
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = language["a-maquiBlankSucu"];
                
                a_maqui_sucuField.appendChild(option)
                f_maqui_sucuField.appendChild(option.cloneNode(true));
                
                for(var i=0; i<parents.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = parents[i].CODE;
                        option.innerHTML = parents[i].CNAME;
                        
                        a_maqui_parentField.appendChild(option);
                        f_maqui_parentField.appendChild(option.cloneNode(true));
                        
                }
                
                a_maqui_parentField.onchange = function()
                {
                        var code = this.value;
                        var a_maqui_sucuField = document.getElementById("a-maquiSucu");
                        a_maqui_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-maquiBlankSucu"];
                        a_maqui_sucuField.appendChild(option);
                            
                        var pickSucuList = [];
                            
                        for(var s=0; s<sucus.length; s++)
                        {
                                if(sucus[s].PARENTCODE == code)
                                {
                                        pickSucuList.push(sucus[s]);
                                }
                        }
                        
                        for(var i=0; i<pickSucuList.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = pickSucuList[i].CODE;
                                if(pickSucuList[i].NAME == "-")
                                {
                                        option.innerHTML = pickSucuList[i].CODE;
                                }
                                else
                                {
                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                }
                                a_maqui_sucuField.appendChild(option);
                        }
                }
                
                f_maqui_parentField.onchange = function()
                {
                        var code = this.value;
                        var f_maqui_sucuField = document.getElementById("f-maquiSucu");
                        f_maqui_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-maquiBlankSucu"];
                        f_maqui_sucuField.appendChild(option);
                            
                        var pickSucuList = [];
                            
                        for(var s=0; s<sucus.length; s++)
                        {
                                if(sucus[s].PARENTCODE == code)
                                {
                                        pickSucuList.push(sucus[s]);
                                }
                        }
                        
                        for(var i=0; i<pickSucuList.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = pickSucuList[i].CODE;
                                if(pickSucuList[i].NAME == "-")
                                {
                                        option.innerHTML = pickSucuList[i].CODE;
                                }
                                else
                                {
                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                }
                                f_maqui_sucuField.appendChild(option);
                        }
                        
                        maquiGet();
                }
	});
}
function maquiGet()
{
        var info = {};
        var  info = infoHarvest(f_maqui_targets);
        sendAjax("users","getMaquiList",info,function(response)
	{
		var ans = response.message;
                tableCreator("maquisTable", ans);
	});
}
function maquiSave(item)
{
        var  info = infoHarvest(a_maqui_targets);
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info["a-maquiParentName"] = $("#a-maquiParent option:selected").text();
        info["a-maquiSucuName"] = $("#a-maquiSucu option:selected").text();
        
        info.utype = "M";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "M";
        info.target = info["a-maquiPlate"];

        if(info["a-maquiParent"] == language["a-maquiBlankClient"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente",300); return}
        else if(info["a-maquiSucu"] == language["a-maquiBlankSucu"]){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una sucursal",300); return}
        else if(info["a-maquiPlate"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una placa",300); return}
        else if(info["a-maquiName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre para la maquina",300); return}
        // else if(info["a-maquiModel"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el modelo",300); return}
        // else if(info["a-maquiSerial"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un serial",300); return}
        // else if(info["a-maquiVolt"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un voltaje",300); return}
        // else if(info["a-maquiCurrent"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una corriente",300); return}
        // else if(info["a-maquiPower"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una potencia",300); return}
        // else if(info["a-maquiPhase"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir unas fases",300); return}
        // else if(info["a-maquiDetails"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir las opbervaciones de la maquina",300); return}
        
        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","maquiSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys014"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_maqui_targets, "a-maqui");
                                maquiGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                
                sendAjax("users","maquiSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_maqui_targets, "a-maqui");
                        sucuSaveButton.innerHTML = "Crear";
                        maquiGet();
                });
        }
}
function techisGet()
{
	var info = {};
	var  info = infoHarvest(f_techi_targets);
	
	sendAjax("users","getTechiList",info,function(response)
	{
		var ans = response.message;
		tableCreator("techisTable", ans);
	});
}
function techisSave(item)
{
        var  info = infoHarvest(a_techi_targets);
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info.utype = "T";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "T";
        info.target = info["a-techiEmail"];
        
        
        if(info["a-techiId"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una identificación",300); return}
        else if(info["a-techiName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre",300); return}
        else if(info["a-techiCat"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una categoría",300); return}
        else if(info["a-techiMastery"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una especialidad",300); return}
        else if(info["a-techiEmail"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un Email",300); return} 		else if(info["a-techiCity"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una ciudad y departamento",300); return}
        else if(info["a-techiAddress"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una dirección",300); return}
        else if(info["a-techiPhone"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir al menos un teléfono",300); return}
        // else if(info["a-techiDetails"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir observaciones",300); return}

        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","techiSave",info,function(response)
                {
                        var ans = response.message;
                        
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys002"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_techi_targets, "a-techi");
                                techisGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                info.techiCode = actualTechiCode;
                
                sendAjax("users","techiSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_techi_targets, "a-techi");
                        techiSaveButton.innerHTML = "Crear";
                        techisGet();
                });
        }
}
function addActType()
{
	var container = document.getElementById("addActType");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var newTypeBox = document.createElement("input");
	newTypeBox.id = "newTypeBox";
	newTypeBox.type = "text";
	newTypeBox.className = "recMailBox";
	newTypeBox.placeholder = "Tipo de actividad";
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButtonPop";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
		{
			var info = {};
			info.newAct = $("#newTypeBox").val();

			if(info.newAct == "")
			{
				hide_pop_form();
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un tipo de actividad",300);
				return;
			}
			
			sendAjax("users","saveActType",info,function(response)
			{
				if(response.status)
				{
					hide_pop_form();
					alertBox(language["alert"],language["sys003"],300);
                                        actTypesRefresh();
				}
			});
		}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButtonPop";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(newTypeBox);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("addActType","Agregar Tipo",300);
}
function addInvQty(code, name)
{
	var container = document.getElementById("addInvQty");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var inputBox = document.createElement("input");
	inputBox.id = "qtyBox";
	inputBox.type = "text";
	inputBox.className = "recMailBox";
	inputBox.placeholder = "Cantidad";
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["send"];
        send.code = code;
	send.onclick = function()
		{
			var info = {};
			info.qty = $("#qtyBox").val();
                        info.code = this.code;

			if(info.qty== "")
			{
				hide_pop_form();
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una cantidad",300);
				return;
			}
			
			sendAjax("users","addInvQty",info,function(response)
			{
                                if(response.status)
				{
					hide_pop_form();
					alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Adición exitosa",300);
                                        inveGet();
				}
			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(inputBox);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("addInvQty","Agregar cantidad a "+name,300);
}
function delActType(info)
{
        var info = info[0];
        sendAjax("users","delActType",info,function(response)
	{
		var ans = response.message;
                actTypesRefresh();
        });
}
function actTypesRefresh()
{
        var info = {};
        
        sendAjax("users","getActTypeList",info,function(response)
	{
		var ans = response.message;
                
                var a_field = document.getElementById("a-actiType");
                var f_field = document.getElementById("f-actiType");
                
                a_field.innerHTML = "";
                f_field.innerHTML = "";
                
                var option = document.createElement("option");
                option.value = "";
                option.innerHTML = "Tipo actividad";
                
                a_field.appendChild(option);
                f_field.appendChild(option.cloneNode(true));
                
                for(var i = 0; i<ans.length; i++)
                {
                        var option = document.createElement("option");
                        option.value = ans[i].TYPE;
                        option.innerHTML = ans[i].TYPE;
                        
                        a_field.appendChild(option);
                        f_field.appendChild(option.cloneNode(true));
                }
                
                
                // tableCreator("actisTable", ans);
	});
}
function actisGet()
{
        var info = {};
        var  info = infoHarvest(f_acti_targets);
        
        sendAjax("users","getActiList",info,function(response)
	{
		var ans = response.message;
                tableCreator("actisTable", ans);
	});
}
function delActTypeConfirm()
{
        var a_field = document.getElementById("a-actiType");
         
        var info = {};
        info.actCode = a_field.value;
         
        if(info.actCode == "")
        {
                alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un tipo de actividad", 300);
                return;
        }
        else
        {
                var param = [info];
                confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Desea eliminar el tipo de actividad "+info.actCode+"?", delActType, 300, param);
        }
}
function actisSave(item)
{
        var  info = infoHarvest(a_acti_targets);
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info.utype = "AC";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "AC";
        info.target = info["a-actiType"];
        
        if(info["a-actiType"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un tipo de actividad",300); return}
        else if(info["a-actiDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una descripción",300); return}
        else if(info["a-actiTime"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una duración en minutos",300); return}
        else if(info["a-actiValue"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un valor",300); return}

        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","actiSave",info,function(response)
                {
                        var ans = response.message;

                        if(ans == "exist")
                        {
                                alertBox(language["alert"], language["sys002"],300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_acti_targets, "a-acti");
                                actisGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                info.acode = actualActCode;
                
                sendAjax("users","actiSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_acti_targets, "a-acti");
                        actiSaveButton.innerHTML = "Crear";
                        actisGet();
                });
        }
}
function inveGet()
{
        var info = {};
        var  info = infoHarvest(f_inve_targets);
        sendAjax("users","getInveList",info,function(response)
	{
		var ans = response.message;

                tableCreator("inveTable", ans);
	});
}
function inveSave(item)
{
        var  info = infoHarvest(a_inve_targets);
        
        if(item.innerHTML == "Crear"){info.otype = "c";}
        if(item.innerHTML == "Guardar"){info.otype = "e";}
        
        info.utype = "I";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "I";
        info.target = info["a-inveCode"];

        if(info["a-inveCode"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un código",300); return}
        else if(info["a-inveDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una descripción",300); return}
        else if(info["a-inveCost"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un valor de compra",300); return}
        else if(info["a-inveMargin"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un % de margen de ganancia",300); return}

        if(info.otype == "c")
        {
                info.optype = ltt1;

                sendAjax("users","inveSave",info,function(response)
                {
                        var ans = response.message;
         
                        if(ans == "exist")
                        {
                                alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Ya existe un item con este código",300);
                        }
                        else
                        {
                                alertBox(language["alert"], language["sys003"],300);
                                clearFields(a_inve_targets, "a-inve");
                                inveGet();
                        }
                });
        }
        else
        {
                info.optype = ltt2;
                
                sendAjax("users","inveSave",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys004"],300);
                        clearFields(a_inve_targets, "a-inve");
                        inveSaveButton.innerHTML = "Crear";
                        inveGet();
                });
        }
}
function logGet()
{
        var info = {};
        var  info = infoHarvest(f_log_targets);
        sendAjax("users","getLogList",info,function(response)
	{
		var ans = response.message;
                tableCreator("logTable", ans);
	});
}
function ordeGet()
{
	var info = {};
	var  info = infoHarvest(f_orde_targets);
	info.techcode = "";
	info.ucode = aud.CODE;
	info.askType = aud.TYPE;
	info.places = [];
	$.each(aud.LOCATION.split("-"), function()
	{info.places.push($.trim(this));});	
	
	
	
	ofilters = [info["f-orderParent"],info["f-orderSucu"],info["f-orderLocation"],info["f-orderAuthor"],info["f-orderNum"],info["f-orderState"]];
	
	console.log(ofilters);
	

	sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
		tableCreator("ordersTable", ans);
	});
}
function maquiManage(popOpen)
{
	if(actualMaquisList.length == [])
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No hay un listado de equipos para la sucursal seleccionada", 300);
                return;
        }
        
	var container = document.getElementById("addInvQty");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var inputBox = document.createElement("select");
	inputBox.type = "select";
	inputBox.multiple = true;
	inputBox.id = "maquiPicker";
	inputBox.className = "maquiPicker";
	inputBox.placeholder = "Cantidad";
        
	for(var i=0; i<actualMaquisList.length; i++)
	{
		var maqui = actualMaquisList[i];
		var option = document.createElement("option");
		option.value = maqui.PLATE;
		if(maqui.NAME == "Locativas")
		{
				option.innerHTML = maqui.NAME;
		}
		else
		{
				option.innerHTML = maqui.NAME+" > "+maqui.PLATE;
		}
		
		
		inputBox.appendChild(option);
		
		if(actualMaquiPicks.in_array(maqui.PLATE))
		{
				option.selected = true;
		}
			
	}
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["accept"];
	send.onclick = function()
		{
                       maquiListPickFiller();
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	// container.appendChild(icon);
	container.appendChild(inputBox);
	container.appendChild(send);
	container.appendChild(cancel);
        
	if(popOpen == 1)
	{
			formBox("addInvQty","Equipos de Sucursal",300);
	}

}
function maquiListPickFiller()
{

        if($('#maquiPicker').val() != null)
        {
                actualMaquiPicks = $('#maquiPicker').val();
        }
        else
        {
                actualMaquiPicks = [];
        }
                
    
        var maquiLister1 = document.getElementById("a-orderMaquis");
        var maquiLister2 = document.getElementById("a-orderDetailMaquis");
        var maquiLister3 = document.getElementById("a-orderMaquisCL");
        
        maquiLister1.innerHTML = "";
        maquiLister2.innerHTML = "";
        maquiLister3.innerHTML = "";
        
        var option = document.createElement("option");
        option.value = "";
        option.innerHTML = "Equipos";
        
        maquiLister1.appendChild(option);
        maquiLister2.appendChild(option.cloneNode(true));
        maquiLister3.appendChild(option.cloneNode(true));
        
        
        for(var i=0; i<actualMaquiPicks.length; i++)
        {
                
                var actualPick = actualMaquiPicks[i];
                
                for(var j=0; j<actualMaquisList.length; j++)
                {
                        if(actualMaquisList[j].PLATE == actualPick)
                        {
                                var code = actualMaquisList[j].PLATE;
                                var name = actualMaquisList[j].NAME;
                                var unique = actualMaquisList[j].CODE;
                        }
                }

                var option = document.createElement("option");
                // option.value = code+">"+actualMaquisList[j].CODE;
                option.value = code+">"+unique;
                
                if(name == "Locativas")
                {
                        option.innerHTML = name;
                }
                else
                {
                        option.innerHTML = name+" > "+code;
                }

                maquiLister1.appendChild(option);
                maquiLister2.appendChild(option.cloneNode(true));
                maquiLister3.appendChild(option.cloneNode(true));
                
        }
        
        hide_pop_form();
}
function orderSave(item)
{
	var  info = infoHarvest(a_orde_targets);
	
	if(item.innerHTML == "Crear"){info.otype = "c";}
	if(item.innerHTML == "Guardar"){info.otype = "e";}
	
	console.log(actualMaquiPicks)
	
	info.utype = "O";
	info.autor = aud.RESPNAME;
	info.autorCode = aud.CODE;
	info.date = getNow();
	info.type = "O";
	
	// TMP MULTIMAQUI DISABLED
	info["a-orderMaquis"] = JSON.stringify(actualMaquiPicks);
	
	
	info["a-orderMaquis"] = JSON.stringify([document.getElementById("a-orderMaquis").value]);
	
	
	
	
	
	info["a-orderParentName"] = $("#a-orderParent option:selected").text();
	info["a-orderSucuName"] = $("#a-orderSucu option:selected").text();
	info.target = info["a-orderParentName"];
	info.userType = aud.TYPE;
	info.location = actualSucuCity;

	if(info["a-orderParent"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente",300); return}
	else if(info["a-orderSucu"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una sucursal",300); return}
	else if(info["a-orderDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un detalle para la orden de trabajo",300); return}
	
	else if(info["a-orderPriority"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una fecha y hora de inicio estimado",300); return}
	
	else if(info["a-orderPriority2"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una fecha y hora de terminación estimado",300); return}
	
	var date1 = info["a-orderPriority"];
	var date2 = info["a-orderPriority2"];
	
	if(date1 >= date2)
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes la fecha de fin debe ser posterior a la fecha de inicio",300); return
	}
	
	if(info.otype == "c")
	{
		info.optype = ltt1;
		
		console.log(info)
		
		// return
		
		sendAjax("users","orderSave",info,function(response)
		{
			var ans = response.message;

			if(ans == "ticket")
			{
				alertBox(language["alert"], language["ticketWarn"],300);
				return;
			}
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
		info.optype = ltt2;
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
function orderSaveCL(item)
{
        var  info ={};

        info["a-orderParent"] = document.getElementById("a-orderParentCL").value;
        info["a-orderSucu"] = document.getElementById("a-orderSucuCL").value;
        info["a-orderPriority"] = document.getElementById("a-orderPriorityCL").value;
        info["a-orderDesc"] = document.getElementById("a-orderDescCL").value;
        info["a-orderOrderClient"] = document.getElementById("a-orderOrderClientCL").value;
        
        
        info.otype = "c";
        info.utype = "O";
        info.autor = aud.RESPNAME;
        info.date = getNow();
        info.type = "O";
       
                
        info["a-orderMaquis"] = JSON.stringify(actualMaquiPicks);
        info["a-orderParentName"] = $("#a-orderParentCL option:selected").text();
        info["a-orderSucuName"] = $("#a-orderSucuCL option:selected").text();
        
        info.target = info["a-orderParentName"];

        if(info["a-orderParent"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente",300); return}
        else if(info["a-orderSucu"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una sucursal",300); return}
        else if(info["a-orderDesc"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un detalle para la orden de trabajo",300); return}
        else if(info["a-orderPriority"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una prioridad",300); return}
       
        info.optype = ltt1;

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
                        clearFields(a_orde_targetsCL, "a-orde");
                        ordeGetCL();
                }
        });
}
function showMaquiDet()
{
        var plate = document.getElementById("a-orderDetailMaquis").value;

}
function showMaquiDetail()
{
        if(document.getElementById("a-orderDetailMaquis").value == "")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un equipo de orden", 300);
                return;
        }
        
        var code = document.getElementById("a-orderDetailMaquis").value.split(">")[1];

        
        var info = {};
        info.code = code;
        
        sendAjax("users","getMaquiListInfo",info,function(response)
        {
                var ans = response.message[0];

                var maquInfo = "<b style='color: #006633;'>Nombre: </b>"+ans.NAME+"<br><b style='color: #006633;'>Serial: </b>"+ans.SERIAL+"<br><b style='color: #006633;'>Modelo: </b>"+ans.MODEL+"<br><b style='color: #006633;'>Voltaje: </b>"+ans.VOLT+"<br><b style='color: #006633;'>Corriente: </b>"+ans.CURRENT+"<br><b style='color: #006633;'>Potencia: </b>"+ans.POWER+"<br><b style='color: #006633;'>Fases: </b>"+ans.PHASES+"<br><b style='color: #006633;'>Detalles: </b>"+ans.DETAIL;

                alertBox("Detalle de equipo "+ans.PLATE, maquInfo, 300);
                
        });
        
        
}
function setActFields()
{
	var desc = document.getElementById("a-orderActiPicker").value;
	var picked = "";
	
	var list = actiPlist;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var itemDesc = item.DESCRIPTION.toUpperCase();
		var compareDesc = desc.toUpperCase();
		
		// console.log(item.DESCRIPTION)
		// console.log(desc)
		
		if(itemDesc == compareDesc)
		{
			picked = item;
			break;
		}
		
	}
	
	if(picked != "")
	{
		document.getElementById("a-orderActiPicker").duration = picked.DURATION;
		document.getElementById("a-orderActiPicker").code = picked.CODE;
		document.getElementById("a-orderActPricePicker").value = picked.COST;
		document.getElementById("a-orderActDurationPicker").value = picked.DURATION;
	}
	else
	{
		document.getElementById("a-orderActiPicker").duration = "0";
		document.getElementById("a-orderActiPicker").code = "CTM";
		document.getElementById("a-orderActPricePicker").value = "";
		document.getElementById("a-orderActDurationPicker").value = "";
	}
	
	
}
function setActPrice()
{
	var qty = document.getElementById("a-orderActQtyPicker").value;
	var price = document.getElementById("a-orderActPricePicker").value;
	var duration = document.getElementById("a-orderActiPicker").duration;
	
	if(qty == ""){qty = 0;}
	if(price == ""){price = 0;}
	if(duration == ""){duration = 0;}

	document.getElementById("a-orderActSubtotalPicker").value = parseFloat(qty)*parseFloat(price);
	
	document.getElementById("a-orderActDurationPicker").value = parseFloat(qty)*parseFloat(duration);
	
}
function addAct()
{

        var maqui = document.getElementById("a-orderDetailMaquis").value.split(">")[0];
        var actiAll = document.getElementById("a-orderActiPicker").value;
		var actiCode = document.getElementById("a-orderActiPicker").code;
		var actiDuration = document.getElementById("a-orderActDurationPicker").value;
        var maquicode = document.getElementById("a-orderDetailMaquis").value.split(">")[1];
        
        if(maqui == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una maquina",300); return}
        if(actiAll == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una actividad",300); return}
      
		var actQty = document.getElementById("a-orderActQtyPicker").value;
		var actUniVal = document.getElementById("a-orderActPricePicker").value;
		
		
        var actiCode = actiCode;
        var actiDesc = actiAll;
        var actiCost = document.getElementById("a-orderActSubtotalPicker").value;
        var actiDuration = actiDuration;

        var info = {};
        
        info.ocode = actualOrderData.CODE;
        info.date = getNow();
        info.actiCode = actiCode;
        info.actQty = actQty;
        info.actUniVal = actUniVal;
        info.actiDesc = actiDesc;
        info.actiCost = actiCost;
        info.actiDuration = actiDuration;
        info.maqui = maqui;
        info.maquiCode = maquicode;
        info.maquiName = ($("#a-orderDetailMaquis option:selected").text().split(" >" ))[0];
        info.tech = actualOrderData.TECHNAME;
        info.techcode = actualOrderData.TECHCODE;
        info.occode = actualOrderData.CCODE;
        
		console.log(info)
		

        sendAjax("users","saveoAct",info,function(response)
        {
                var ans = response.message;
                // document.getElementById("a-orderDetailMaquis").value = "";
                document.getElementById("a-orderActiPicker").value = "";
				document.getElementById("a-orderActPricePicker").value = "";
				document.getElementById("a-orderActDurationPicker").value = "";
				document.getElementById("a-orderActQtyPicker").value = "";
                
                refreshoActs();
        });
   
}
function refreshoActs()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getOActs",info,function(response)
        {
			var list = response.message;
			actualOrderActs = list;
			// document.getElementById("a-orderDetailMaquis").value = "";
			document.getElementById("a-orderActiPicker").value = "";
			tableCreator("oActsTable", list);
        });
}
function editActPrice()
{
	var container = document.getElementById("actPriceEdit");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var input = document.createElement("input");
	input.id = "editCostBox";
	input.type = "text";
	input.className = "recMailBox";
	input.placeholder = "Costo de actividad";
        
        input.value = actualCost;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["send"];
	send.onclick = function()
		{
			var info = {};
			info.newCost = $("#editCostBox").val();
                        info.actCode = actualActCode;
                        
			if(info.newCost == "")
			{
				hide_pop_form();
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un costo de actividad",300);
				return;
			}

			sendAjax("users","updateActCost",info,function(response)
			{
				if(response.status)
				{
					hide_pop_form();
					// alertBox(language["alert"],language["sys004"],300);
                                        refreshoActs();
				}
			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("actPriceEdit","Editar costo de actividad",300);
}
function refreshoParts()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getOParts",info,function(response)
        {
                var list = response.message;
                
                document.getElementById("a-orderPartPicker").value = "";
                document.getElementById("a-orderPartPicker").onchange();

                tableCreator("oPartsTable", list);
        });
}
function editPartPrice()
{
	var container = document.getElementById("partPriceEdit");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var input = document.createElement("input");
	input.id = "editCostBox";
	input.type = "text";
	input.className = "recMailBox";
	input.placeholder = "Costo unitario de repuesto";
        
        input.value = actualCost;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["send"];
	send.onclick = function()
		{
			var info = {};
			info.newCost = $("#editCostBox").val();
                        info.partCode = actualPartCode;
                        
			if(info.newCost == "")
			{
				hide_pop_form();
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un costo unitario de repuesto",300);
				return;
			}

			sendAjax("users","updatePartCost",info,function(response)
			{
				if(response.status)
				{
					hide_pop_form();
					// alertBox(language["alert"],language["sys004"],300);
                                        refreshoParts();
				}
			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("partPriceEdit","Editar costo de repuesto",300);
}
function editOtherPrice()
{
	var container = document.getElementById("otherPriceEdit");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var input = document.createElement("input");
	input.id = "editCostBox";
	input.type = "text";
	input.className = "recMailBox";
	input.placeholder = "Costo unitario de repuesto";
        
        input.value = actualCost;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["send"];
	send.onclick = function()
		{
			var info = {};
			info.newCost = $("#editCostBox").val();
                        info.otherCode = actualOtherCode;
                        
			if(info.newCost == "")
			{
				hide_pop_form();
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un costo unitario de repuesto",300);
				return;
			}

			sendAjax("users","updateOtherCost",info,function(response)
			{
				if(response.status)
				{
					hide_pop_form();
					// alertBox(language["alert"],language["sys004"],300);
                                        refreshoOther();
				}
			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(input);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("otherPriceEdit","Editar costo de concepto",300);
}
function cascadeInfoFiller(fields, values, type )
{
        
        if(type == "t")
        {
                for(var z=0; z<fields.length; z++)
                {
                        selectByText(fields[z], values[z]);
                        
                }
        }
        if(type == "v")
        {
                for(var z=0; z<fields.length; z++)
                {
                        var field = document.getElementById(fields[z])
                        field.value = values[z]
                        if(z != fields.length-1)
                        {
                                field.onchange();
                        }
                        
                }
        }
}
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
function getFactPick()
{
        var table = document.getElementById("ordersTable");
        var boxes = table.getElementsByTagName("input");
        
        var picks = [];
        var clients = [];
        
        for(var i=0; i<boxes.length; i++)
        {
                if(boxes[i].checked)
                {
                        picks.push(boxes[i].reg.CODE);
                        clients.push(boxes[i].reg.PARENTCODE);
                }
        }
        
        if(picks.length == 0)
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar por lo menos una orden para facturar", 300);
                return;
        }
        
        var flag = clients[0];

        
        for(var i= 0; i<clients.length; i++)
        {
                var pos = clients[i];
                if(pos != flag)
                {
                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Todas las ordenes para la factura deben ser del mismo cliente", 300);
                        return;
                }
        }
        
        document.getElementById("retCheck").checked = true;
        
        actualRecOrders = picks;
        
        refreshOtotals();
        
        tableCreator("factResumeTable", []);
        formBox("preFactBox","Resumen de factura",1200);
        
}
function refreshOtotals()
{
        var info = {};
        info.picks = actualRecOrders;
        if(document.getElementById("retCheck").checked){info.retCheck = "1";}else{info.retCheck = "0";}
        
         sendAjax("users","getOtotals",info,function(response)
        {
                var ans = response.message;
                console.log(ans);
                var list = ans.detailed;
                var totaled = ans.totaled;
                
                document.getElementById("totaLineAct").innerHTML = addCommas(totaled.actis);
                document.getElementById("totaLineRep").innerHTML = addCommas(totaled.repu);
                document.getElementById("totaLineOth").innerHTML = addCommas(totaled.othe);
                document.getElementById("totaLineIva").innerHTML = addCommas(totaled.iva);
                document.getElementById("totaLineRe4").innerHTML = addCommas(totaled.rete4);
                document.getElementById("totaLineRe2").innerHTML = addCommas(totaled.rete25);
                document.getElementById("totaLineFull").innerHTML = addCommas(totaled.fullTotal);
                
                tableCreator("factResumeTable", list);
                formBox("preFactBox","Resumen de factura",1200);

        });
}
function generateRecepit()
{
        var info= {};
        
        info.picks = actualRecOrders.reverse();
        info.date = getNow();
        info.diedate = getNow(parseInt(document.getElementById("recLife").value));
        if(document.getElementById("retCheck").checked){info.retCheck = "1";}else{info.retCheck = "0";}
        
        info.life = document.getElementById("recLife").value;

        if(info.life == "")
        {
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir el número de dias de vigencia de la factura", 300);
                return;
        }
        
        // document.getElementById("sendPrefacButton").onclick = function(){console.log("locked")}

        sendAjax("users","generateRecepit",info,function(response)
        {
                
                var ans = response.message;
				console.log(ans)
				// return
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
                downloadReport(ans);
        });
        
        
}

// REPORT BLOCK START ----------
function reportPick(pick)
{
        actualReport = "";
        
        var reporTableBox = document.getElementById("reporTableBox");
        var tables = reporTableBox.children;

        for(var i = 0; i<tables.length; i++)
        {
                var table = tables[i];
                table.style.display = "none";
        }
        
        var box = document.getElementById("repFilterBox");
        box.innerHTML = "";
        
        tableClear("maquiStoryR");
        tableClear("ordersR");
        tableClear("ordersRIM");
        tableClear("actisPclient");
        tableClear("repusPclient");
        tableClear("othersPclient");
        tableClear("othersPtype");
        tableClear("pendAndrec");
        tableClear("repusCosts");
        tableClear("orderTimesByTech");
        tableClear("orderTimesByActi");
        tableClear("actisPacti");
        
        if(pick == ""){return}
        else if(pick == "1"){actualReport = "maquiStoryR";}
        else if(pick == "2"){actualReport = "ordersR";}
        else if(pick == "3"){actualReport = "ordersRIM";}
        else if(pick == "4"){actualReport = "actisPclient";}
        else if(pick == "5"){actualReport = "repusPclient";}
        else if(pick == "6"){actualReport = "othersPclient";}
        else if(pick == "7"){actualReport = "othersPtype";}
        else if(pick == "8"){actualReport = "pendAndrec";}
        else if(pick == "9"){actualReport = "repusCosts";}
        else if(pick == "10"){actualReport = "orderTimesByTech";}
        else if(pick == "11"){actualReport = "orderTimesByActi";}
        else if(pick == "12"){actualReport = "actisPacti";}

        
        filterBuilder("repFilterBox", actualReport);
        
        document.getElementById(actualReport).style.display = "table";
}
function filterBuilder(id, type)
{
        var box = document.getElementById(id);
        box.innerHTML = "";
        
        var repoParent = fieldCreator([12,4,4,2], "Cliente", "select", "repoParent");
        var repoSucu = fieldCreator([12,4,4,2], "Sucursal", "select", "repoSucu");
        var repoMaqui = fieldCreator([12,4,4,2], "Equipo", "select", "repoMaqui");
        var repoIniDate = fieldCreator([12,4,4,2], "Fecha Inicial", "input", "repoIniDate");
        var repoEndDate = fieldCreator([12,4,4,2], "Fecha Final", "input", "repoEndDate");
        var repoOrderNum = fieldCreator([12,4,4,2], "OTT", "input", "repoOrderNum");
        var repoRepu = fieldCreator([12,4,4,2], "Repuesto", "select", "repoRepu");
        var repoOtype = fieldCreator([12,4,4,2], "Tipo", "select", "repoOtype");
        var repoTech = fieldCreator([12,4,4,2], "Técnico", "select", "repoTech");
        var repoActi = fieldCreator([12,4,4,2], "Actividad", "select", "repoActi");
        var repoState = fieldCreator([12,4,4,2], "Estado", "select", "repoState");
        
        var searchButton = buttonCreator([12,4,4,2], "Buscar", reposearch)
        
        if(type == "maquiStoryR")
        {
        
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoMaqui);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "ordersR")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "ordersRIM")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "actisPclient")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "actisPacti")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoActi);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshActiParents();
        }
        else if(type == "repusPclient")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoRepu);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshRepuParents();
                
        }
        else if(type == "repusCosts")
        {
                box.appendChild(repoParent);
                box.appendChild(repoState);
                box.appendChild(repoRepu);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshRepuParents();
                refreshStateParents()
        }
        else if(type == "othersPclient")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "othersPtype")
        {
                box.appendChild(repoOtype);
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshOtypeParents();
        }
        else if(type == "pendAndrec")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
        }
        else if(type == "orderTimesByTech")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoTech);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshTechParents();
        }
        else if(type == "orderTimesByActi")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoActi);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshActiParents();
        }
        
        jQuery('#repoIniDate').datetimepicker();
        jQuery('#repoEndDate').datetimepicker();
}
function refreshStateParents()
{
        var picker = document.getElementById("repoState");
        picker.innerHTML = "";
        
        var option = document.createElement("option");
        option.value = "";
        option.innerHTML = "Estado de orden";
        picker.appendChild(option);

        var option = document.createElement("option");
        option.value = "2";
        option.innerHTML = "Proceso";
        picker.appendChild(option);
        
        var option = document.createElement("option");
        option.value = "3";
        option.innerHTML = "Revisión";
        picker.appendChild(option);
        
        var option = document.createElement("option");
        option.value = "4";
        option.innerHTML = "Por facturar";
        picker.appendChild(option);

        var option = document.createElement("option");
        option.value = "5";
        option.innerHTML = "Facturada";
        picker.appendChild(option);
 
}
function refreshOtypeParents()
{
        var picker = document.getElementById("repoOtype");
        picker.innerHTML = "";
        
        var option = document.createElement("option");
        option.value = "";
        option.innerHTML = "Tipo de concepto";
        picker.appendChild(option);

        var option = document.createElement("option");
        option.value = "Mensajería";
        option.innerHTML = "Mensajería";
        picker.appendChild(option);
        
        var option = document.createElement("option");
        option.value = "Viaticos";
        option.innerHTML = "Viaticos";
        picker.appendChild(option);
        
        var option = document.createElement("option");
        option.value = "Transporte equipos";
        option.innerHTML = "Transporte equipos";
        picker.appendChild(option);

        var option = document.createElement("option");
        option.value = "Otros";
        option.innerHTML = "Otros";
        picker.appendChild(option);
 
}
function refreshRepoParents()
{
        var info = {};
		info.ucode = aud.CODE;
        
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;
                
                if(actualReport != "repusCosts")
                {
                        if(document.getElementById("repoSucu"))
                        {
                                var a_order_sucuField = document.getElementById("repoSucu");
                                a_order_sucuField.innerHTML = "";
                                var option = document.createElement("option");
                                option.value = "";
                                option.innerHTML = language["a-maquiBlankSucu"];
                                a_order_sucuField.appendChild(option)
                                a_order_sucuField.onchange = function()
                                {
                                        
                                        if(document.getElementById("repoMaqui"))
                                        {
                                                var code = this.value;

                                                var info = {};
                                                info.code = code;
                                                
                                                actualMaquisList = [];
                                                
                                                sendAjax("users","getMaquiListSelect",info,function(response)
                                                {
                                                        var ans = response.message;

                                                        var a_orderMaquisField = document.getElementById("repoMaqui");
                                                        a_orderMaquisField.innerHTML = "";
                                                        var option = document.createElement("option");
                                                        option.value = "";
                                                        option.innerHTML = "Equipo";
                                                        a_orderMaquisField.appendChild(option);
                                                        
                                                        for(var i=0; i<ans.length; i++)
                                                        {
                                                                var option = document.createElement("option");
                                                                option.value = ans[i].CODE;
                                                                option.innerHTML = ans[i].PLATE+" - "+ans[i].NAME;
                                                                a_orderMaquisField.appendChild(option);
                                                        }
                                                        
                                                        a_orderMaquisField.onchange = function(){reposearch();}
                                                        
                                                });
                                        }
                                }
                        }
                }
                
                if(document.getElementById("repoParent"))
                {
                        var a_order_parentField = document.getElementById("repoParent");
                        a_order_parentField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = language["a-maquiBlankClient"];
                        a_order_parentField.appendChild(option)
                        for(var i=0; i<parents.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = parents[i].CODE;
                                option.innerHTML = parents[i].CNAME;
                                
                                a_order_parentField.appendChild(option);
                        }
                        if(actualReport != "repusCosts")
                        {
                                a_order_parentField.onchange = function()
                                {
                                        
                                        var code = this.value;
                                        var a_order_sucuField = document.getElementById("repoSucu");
                                        a_order_sucuField.innerHTML = "";
                                        var option = document.createElement("option");
                                        option.value = "";
                                        option.innerHTML = language["a-maquiBlankSucu"];
                                        a_order_sucuField.appendChild(option);
                                            
                                        var pickSucuList = [];
                                            
                                        for(var s=0; s<sucus.length; s++)
                                        {
                                                if(sucus[s].PARENTCODE == code)
                                                {
                                                        pickSucuList.push(sucus[s]);
                                                }
                                        }
                                        
                                        for(var i=0; i<pickSucuList.length; i++)
                                        {
                                                var option = document.createElement("option");
                                                option.value = pickSucuList[i].CODE;
                                                if(pickSucuList[i].NAME == "-")
                                                {
                                                        option.innerHTML = pickSucuList[i].CODE;
                                                }
                                                else
                                                {
                                                        option.innerHTML = pickSucuList[i].CODE+" - "+pickSucuList[i].NAME;
                                                }
                                                a_order_sucuField.appendChild(option);
                                        }
                                        
                                        if(document.getElementById("repoMaqui"))
                                        {
                                                var a_orderMaquisField = document.getElementById("repoMaqui");
                                                a_orderMaquisField.innerHTML = "";
                                                var option = document.createElement("option");
                                                option.value = "";
                                                option.innerHTML = "Equipo";
                                                a_orderMaquisField.appendChild(option);
                                        }
                                }
                        }
                        
                        if(aud.TYPE == "C")
                        {
                                a_order_parentField.value = aud.CODE;
                                a_order_parentField.onchange();
                                a_order_parentField.disabled = true;
                        }
                        
                }

                if(document.getElementById("repoMaqui"))
                {

                        var a_orderMaquisField = document.getElementById("repoMaqui");
                        a_orderMaquisField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = "Equipo";
                        a_orderMaquisField.appendChild(option.cloneNode(true));
                }

	});
}
function refreshRepuParents()
{
        var info = {};
        
        sendAjax("users","getMaquiListReport",info,function(response)
	{
		var repus = response.message;

                if(document.getElementById("repoRepu"))
                {
                        var a_order_sucuField = document.getElementById("repoRepu");
                        a_order_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = "Código Repuesto";
                        a_order_sucuField.appendChild(option);
                        
                        if(actualReport != "repusCosts")
                        {
                                var option = document.createElement("option");
                                option.value = "NI";
                                option.innerHTML = "NI";
                                a_order_sucuField.appendChild(option);
                        }

                        for(var i=0; i<repus.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = repus[i].CODE;
                                option.innerHTML = repus[i].DESCRIPTION;
                                a_order_sucuField.appendChild(option)
                        }
                }
        });
}
function refreshTechParents()
{
        var info = {};
        
        sendAjax("users","getTechiListO",info,function(response)
	{
		var techs = response.message;

                if(document.getElementById("repoTech"))
                {
                        var a_order_sucuField = document.getElementById("repoTech");
                        a_order_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = "Técnico";
                        a_order_sucuField.appendChild(option);

                        for(var i=0; i<techs.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = techs[i].CODE;
                                option.innerHTML = techs[i].RESPNAME;
                                a_order_sucuField.appendChild(option);
                        }
                }
        });
}
function refreshActiParents()
{
        var info = {};
        info.value = "";
        sendAjax("users","getoActiList",info,function(response)
	{
		var actis = response.message;
                console.log(actis)

                if(document.getElementById("repoActi"))
                {
                        var a_order_sucuField = document.getElementById("repoActi");
                        a_order_sucuField.innerHTML = "";
                        var option = document.createElement("option");
                        option.value = "";
                        option.innerHTML = "Actividad";
                        a_order_sucuField.appendChild(option);

                        for(var i=0; i<actis.length; i++)
                        {
                                var option = document.createElement("option");
                                option.value = actis[i].CODE;
                                option.innerHTML = actis[i].CODE+" - "+actis[i].DESCRIPTION;
                                a_order_sucuField.appendChild(option)
                        }
                }
        });
}
function fieldCreator(sizes, title, type, id)
{
        var label = document.createElement("span");
        label.innerHTML = title;
        
        var box = document.createElement("div");
        var classname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
        box.className = classname;
        
        var field = document.createElement(type);
        field.id = id;
        field.type = "text";
        
        box.appendChild(label);
        box.appendChild(field);
        
        return box;
}
function buttonCreator(sizes, title, fun)
{
        var button = document.createElement("button");
        button.innerHTML = title;
        button.onclick = function(){fun()}
        
        var box = document.createElement("div");
        var classname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
        box.className = classname;
        
        var br = document.createElement("br");
        br.className = "hidden-xs";
        
        box.appendChild(br);
        box.appendChild(button);
        
        return box;
}
function reposearch()
{
        var info = {};
        info["repoType"] = actualReport;
        info["repoParent"] = "";
        info["repoSucu"] = "";
        info["repoMaqui"] = "";
        info["repoIniDate"] = "";
        info["repoEndDate"] = "";
        info["repoParentName"] = "";
        info["repoSucuName"] = "";
        info["repoOrderNum"] = "";
        info["repoRepu"] = "";
        info["repoOtype"] = "";
        info["repoTech"] = "";
        info["repoActi"] = "";
        info["repoState"] = "";
        
        var fields = [];
        var filters = document.getElementById("repFilterBox").children;
        for(var i = 0; i<filters.length-1; i++){var filter = filters[i].children[1];fields.push(filter.id);}
        for(var i=0; i<fields.length; i++)
        {
                info[fields[i]] = document.getElementById(fields[i]).value;
                if(fields[i] == "repoOrderNum")
                {
                        info[fields[i]] = parseInt(document.getElementById(fields[i]).value);
                }
        }
        
        if(actualReport == "maquiStoryR")
        {
                if(info["repoParent"] == "" || info["repoSucu"] == "" || info["repoMaqui"] == ""){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar sucursal y equipo para este reporte", 300); return}
        }
        else if(actualReport == "actisPclient" || actualReport == "othersPclient")
        {
                if(info["repoParent"] == "" ){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar un cliente para este reporte", 300); return}
        }
        
        console.log(info)
        
        sendAjax("users","getReport",info,function(response)
	{
		var list = response.message;
                console.log(list)
                tableCreatorRepo(actualReport, list);
        });

}
function tableCreatorRepo(tableId, list)
{
        var table = document.getElementById(tableId);
        tableClear(tableId);
        
        console.log("reach")
        
        if(list.length == 0)
        {
                var nInYet = document.createElement("div");
                nInYet.innerHTML = language["noResults"];
                nInYet.className = "blankProducts";
                table.appendChild(nInYet);
                resSet();

                return;
        }
        // MAQUI STORY
        if(tableId == "maquiStoryR")
        {
                
                var costTotal = 0;

                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Fecha', list[i].DATE);
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}

                        var b = cellCreator('Orden', num);
                        var c = cellCreator('Actividad', list[i].ADESC);
                        var n = cellCreator('Costo', addCommas(list[i].ACOST));
                        var d = cellCreator('Técnico', list[i].TECHNAME);
                        
                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }


                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,n,d, x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        costTotal += parseInt(list[i].ACOST);
                }

                var line = ["", "", "Total costo actividades Antes de Impuestos", addCommas(costTotal), "", ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
        }
        // ORDERS
        if(tableId == "ordersR")
        {
                var costTotal  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].CCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        var a = cellCreator('OTT', num);
                        var b = cellCreator('Cliente',  list[i].PARENTNAME);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        
                        var maquiList = JSON.parse(list[i].MAQUIS);
                        var maquis = "";
                        for(var x=0; x<maquiList.length; x++)
                        {
                                var label = maquiList[x];
                                
                                if(label.split("-")[1] == "Locativas")
                                {
                                        label = "Locativas";
                                }
                                
                                if(x == maquiList.length-1)
                                {
                                        maquis = maquis+label;
                                }
                                else
                                {
                                        maquis = maquis+label+", "; 
                                }
                        }
                        
                        
                        var d= cellCreator('Equipos', maquis);
                        var e = cellCreator('Fecha Solicitud', list[i].DATE);
                        
                        
                        var startDate = list[i].STARTIME;
                        if(startDate == "" || startDate == "0000-00-00 00:00:00")
                        {
                                startDate = "Pendiente";
                        }
                        
                        var f = cellCreator('Fecha Atención', startDate);
                        var m = cellCreator('Fecha Atención', list[i].TECHNAME);
                        
                        
                        var g = cellCreator('Detalle', list[i].DETAIL);
                        
                        var totalCost = list[i].TOTALCOST;
                        if(totalCost == null || totalCost == "")
                        {
                                totalCost = "-";
                        }
                        else
                        {
                                totalCost = addCommas(totalCost);
                        }
                        
                        if(list[i].STATE == "4" || list[i].STATE == "5")
                        {
                                var n = cellCreator('Valor(AI)', totalCost);
                        }
                        else
                        {
                                var n = cellCreator('Valor(AI)', "Sin liquidar");
                        }
                        
                        
                        
                        if(list[i].STATE == "1"){var state = "Nueva"}
                        if(list[i].STATE == "2"){var state = "Proceso"}
                        if(list[i].STATE == "3"){var state = "Revisión"}
                        if(list[i].STATE == "4"){var state = "Por facturar"}
                        if(list[i].STATE == "5"){var state = "Facturada"}
                        if(list[i].STATE == "6"){var state = "Previsita"}
                        if(list[i].STATE == "7"){var state = "Cotizado"}
                        
                        var h = cellCreator('Estado', state);
                        
                        var detail = document.createElement("img");
                        detail.src = "irsc/downIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Descargar Reporte');
                        detail.setAttribute('alt', 'Descargar Reporte');
                        detail.onclick = function()
                        {
                                if(this.reg.STATE != "3" && this.reg.STATE != "4" && this.reg.STATE != "5")
                                {
                                        return;
                                }
                                var info = this.reg;
                                var url = "reports/"+info.CODE+"-T.pdf";
                                downloadReport(url);
                        }
                        
                        if(list[i].STATE != "4" && list[i].STATE != "5")
                        {
                                detail.src = "irsc/downIconG.png";
                        }
                        
                        
                        var icons = [detail];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,m,g,n,h,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].TOTALCOST == "" || list[i].TOTALCOST == null)
                        {
                                list[i].TOTALCOST = 0;
                        }
                        
                        costTotal += parseInt(list[i].TOTALCOST);
                }
                
                var line = ["", "", "", "", "", "", "",  "Total Antes de Impuestos", addCommas(costTotal), "", ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER PENDINGS
        if(tableId == "pendAndrec")
        {

                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].CCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}

                        var a = cellCreator('Cliente',  list[i].PARENTNAME);
                        var b = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var c = cellCreator('OTT', num);
                        var d = cellCreator('Fecha cierre',  list[i].CLOSEDATE);
                        var e = cellCreator('Observaciones',  list[i].OBSERVATIONS);
                        var f = cellCreator('Recomendaciones',  list[i].RECOMENDATIONS);
                        var g = cellCreator('Pendientes',  list[i].PENDINGS);

                        var detail = document.createElement("img");
                        detail.src = "irsc/downIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Descargar Reporte');
                        detail.setAttribute('alt', 'Descargar Reporte');
                        detail.onclick = function()
                        {
                                if(this.reg.STATE != "3" && this.reg.STATE != "4" && this.reg.STATE != "5")
                                {
                                        return;
                                }
                                var info = this.reg;
                                var url = "reports/"+info.CODE+"-T.pdf";
                                downloadReport(url);
                        }
                        
                        if(list[i].STATE != "4" && list[i].STATE != "5")
                        {
                                detail.src = "irsc/downIconG.png";
                        }
                        
                        
                        var icons = [detail];
                        var x = cellOptionsCreator('', icons)
                        var cells = [c,a,b,d,e,f,g,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);

                }
        }
        // ORDER IMAGES
        if(tableId == "ordersRIM")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var num = list[i].CCODE;
				if(num.length == 1){num = "000"+num;}
				else if(num.length == 2){num = "00"+num;}
				else if(num.length == 3){num = "0"+num;}
				else{num = num;}
				
				var a = cellCreator('OTT', num);
				var b = cellCreator('Cliente',  list[i].PARENTNAME);
				var c = cellCreator('Sucursal',  list[i].SUCUNAME);
				
				var maquiList = JSON.parse(list[i].MAQUIS);
				var maquis = "";
				for(var x=0; x<maquiList.length; x++)
				{
						var label = maquiList[x];
						
						if(label.split("-")[1] == "Locativas")
						{
								label = "Locativas";
						}
						
						if(x == maquiList.length-1)
						{
								maquis = maquis+label;
						}
						else
						{
								maquis = maquis+label+", "; 
						}
				}

				var d= cellCreator('Equipos', maquis);
				var e= cellCreator('Detalle', list[i].DETAIL);

				var abox = document.createElement("div");
				abox.className = "rPicBox";
				var aList = list[i].PICS.ini;
				
				for(var j=0; j<aList.length; j++)
				{
						var span = document.createElement('span');
						var filename = encry(aList[j]);
						
						span.innerHTML = "<img class='imageBoxViewReport' src='irsc/pics/"+list[i].CODE+"/ini/"+filename+"'/>";
						span.path = 'irsc/pics/'+list[i].CODE+'/ini/'+filename;

						span.num = j+1;
						span.onclick = function(){showPicBox(this.path, "Foto inicial");};abox.appendChild(span);
				}
				
				
				var dbox = document.createElement("div");
				dbox.className = "rPicBox";
				var dList = list[i].PICS.end;
				
				 for(var j=0; j<dList.length; j++)
				{
						var span = document.createElement('span');
						var filename = encry(dList[j]);
						
						span.innerHTML = "<img class='imageBoxViewReport' src='irsc/pics/"+list[i].CODE+"/end/"+filename+"'/>";
						span.path = 'irsc/pics/'+list[i].CODE+'/end/'+filename;

						span.num = j+1;
						span.onclick = function(){showPicBox(this.path, "Foto Final");};dbox.appendChild(span);
				}
				
				var obox = document.createElement("div");
				obox.className = "rPicBox";
				var oList = list[i].PICS.order;
				
				for(var j=0; j<oList.length; j++)
				{
					var span = document.createElement('span');
					var filename = encry(oList[j]);
					
					span.innerHTML = "<img class='imageBoxViewReport' src='irsc/pics/"+list[i].CODE+"/order/"+filename+"'/>";
					span.path = 'irsc/pics/'+list[i].CODE+'/order/'+filename;

					span.num = j+1;
					span.onclick = function(){showPicBox(this.path, "Foto Orden");};obox.appendChild(span);
				}
				
				var f = picellCreator('Imágenes Iniciales', abox);
				var g = picellCreator('Imágenes Finales', dbox);
				var o = picellCreator('Orden de trabajo', obox);

				var icons = [];
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,d,e,f,g,o];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
                
        }
        // ORDER ACTIS
        if(tableId == "actisPclient")
        {
                var costTotal  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var a = cellCreator('Actividad', list[i].ADESC);
                        var b = cellCreator('Fecha',  list[i].DATE);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        
                        var maquiCode =  list[i].MAQUI;
                        if(maquiCode.split("-")[1] == "Locativas"){maquiCode = "Locativas";}

                        var d = cellCreator('Equipo',  maquiCode+" - "+list[i].MAQUINAME);
                        var e= cellCreator('Técnico', list[i].TECHNAME);
                        var f = cellCreator('Orden', num);
                        var g = cellCreator('Costo', addCommas(list[i].ACOST));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].ACOST == "" || list[i].ACOST == null)
                        {
                                list[i].ACOST = 0;
                        }
                        
                        costTotal += parseInt(list[i].ACOST);
                }
                
                var line = ["", "", "", "", "",  "Total", addCommas(costTotal), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER ACTIS PER ACTI
        if(tableId == "actisPacti")
        {
                var costTotal  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var a = cellCreator('Actividad', list[i].ADESC);
                        var b = cellCreator('Fecha',  list[i].DATE);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        
                        var maquiCode =  list[i].MAQUI;
                        if(maquiCode.split("-")[1] == "Locativas"){maquiCode = "Locativas";}

                        var d = cellCreator('Equipo',  maquiCode+" - "+list[i].MAQUINAME);
                        var e= cellCreator('Técnico', list[i].TECHNAME);
                        var f = cellCreator('Orden', num);
                        var g = cellCreator('Costo', addCommas(list[i].ACOST));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].ACOST == "" || list[i].ACOST == null)
                        {
                                list[i].ACOST = 0;
                        }
                        
                        costTotal += parseInt(list[i].ACOST);
                }
                
                var line = ["", "", "", "", "",  "Total", addCommas(costTotal), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER RESPUS
        if(tableId == "repusPclient")
        {
                var costTotal1  = 0;
                var costTotal2  = 0;
                var costTotal3  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var a = cellCreator('Código', list[i].PCODE);
                        var b = cellCreator('Repuesto',  list[i].PDESC);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var d= cellCreator('Técnico', list[i].TECHNAME);
                        var e = cellCreator('Orden', num);
                        var m = cellCreator('Cantidad', list[i].PAMOUNT);
                        var f = cellCreator('Costo Un.', addCommas(list[i].PCOST));
                        
                        var subtotal = list[i].PAMOUNT * list[i].PCOST;
                        
                        var n = cellCreator('Subtotal', addCommas(subtotal));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,m,f,n,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].PCOST == "" || list[i].PCOST == null)
                        {
                                list[i].PCOST = 0;
                        }
                        
                        costTotal1 += parseInt(list[i].PCOST);
                        costTotal2 += parseInt(list[i].PAMOUNT);
                        costTotal3 += parseInt(subtotal);
                }
                
                var line = ["", "", "", "",  "Total", costTotal2, addCommas(costTotal1),  addCommas(costTotal3), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER OTHERS
        if(tableId == "othersPclient")
        {
                var costTotal1  = 0;
                var costTotal2  = 0;
                var costTotal3  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var a = cellCreator('Descripción', list[i].ODESC);
                        var b = cellCreator('Documento',  list[i].DOC);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var d= cellCreator('Técnico', list[i].TECHNAME);
                        var e = cellCreator('Orden', num);
                        var m = cellCreator('Cantidad', list[i].AMOUNT);
                        var f = cellCreator('Costo Un.', addCommas(list[i].COST));
                        
                        var subtotal = list[i].AMOUNT * list[i].COST;
                        
                        var n = cellCreator('Subtotal', addCommas(subtotal));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,m,f,n,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].COST == "" || list[i].COST == null)
                        {
                                list[i].PCOST = 0;
                        }
                        
                        costTotal1 += parseInt(list[i].COST);
                        costTotal2 += parseInt(list[i].AMOUNT);
                        costTotal3 += parseInt(subtotal);
                }
                
                var line = ["", "", "", "",  "Total", costTotal2, addCommas(costTotal1),  addCommas(costTotal3), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER OTHERS PTYPE
        if(tableId == "othersPtype")
        {
                var costTotal1  = 0;
                var costTotal2  = 0;
                var costTotal3  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var h = cellCreator('Tipo', list[i].OTYPE);
                        var a = cellCreator('Descripción', list[i].ODESC);
                        var b = cellCreator('Documento',  list[i].DOC);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var d= cellCreator('Técnico', list[i].TECHNAME);
                        var e = cellCreator('Orden', num);
                        var m = cellCreator('Cantidad', list[i].AMOUNT);
                        var f = cellCreator('Costo Un.', addCommas(list[i].COST));
                        
                        var subtotal = list[i].AMOUNT * list[i].COST;
                        
                        var n = cellCreator('Subtotal', addCommas(subtotal));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        
                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }

                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [h,a,b,c,d,e,m,f,n,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].COST == "" || list[i].COST == null)
                        {
                                list[i].PCOST = 0;
                        }
                        
                        costTotal1 += parseInt(list[i].COST);
                        costTotal2 += parseInt(list[i].AMOUNT);
                        costTotal3 += parseInt(subtotal);
                }
                
                var line = ["", "", "", "",  "Total", costTotal2, addCommas(costTotal1),  addCommas(costTotal3), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // RESPUS COSTS
        if(tableId == "repusCosts")
        {
                var costTotal1  = 0;
                var costTotal2  = 0;
                var costTotal3  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                num = num+"-"+list[i].ICODE;
                        }
                        
                        var a = cellCreator('Código', list[i].PCODE);
                        var b = cellCreator('Repuesto',  list[i].PDESC);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var d= cellCreator('Técnico', list[i].TECHNAME);
                        var e = cellCreator('Orden', num);
                        var m = cellCreator('Cantidad', list[i].PAMOUNT);
                        var f = cellCreator('Costo Un.', addCommas(list[i].REALCOST));
                        
                        var subtotal = list[i].PAMOUNT * list[i].REALCOST;
                        
                        var n = cellCreator('Subtotal', addCommas(subtotal));

                        var report = document.createElement("img");
                        report.src = "irsc/downIcon.png";
                        report.reg = list[i];
                        report.setAttribute('title', 'Descargar Reporte');
                        report.setAttribute('alt', 'Descargar Reporte');
                        report.onclick = function()
                        {
                                var info = {};
                                info.ocode = this.reg.OCODE;

                                sendAjax("users","getRePath",info,function(response)
                                {
                                        var url = response.message;

                                        if(url == "none")
                                        {
                                                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La orden se encuentra en progreso aún no existe reporte", 300);
                                                return
                                        }
                                        else if(url == "0")
                                        {
                                                var url = "reports/"+info.ocode+".pdf";
                                        }
                                        else
                                        {
                                                var url = "reports/"+info.ocode+"-T.pdf";
                                        }
                                        downloadReport(url);
                                });
                        }
                        
                        var icons = [report];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,m,f,n,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        if(list[i].REALCOST == "" || list[i].REALCOST == null)
                        {
                                list[i].REALCOST = 0;
                        }
                        
                        costTotal1 += parseInt(list[i].REALCOST);
                        costTotal2 += parseInt(list[i].PAMOUNT);
                        costTotal3 += parseInt(subtotal);
                }
                
                var line = ["", "", "", "",  "Total", costTotal2, addCommas(costTotal1),  addCommas(costTotal3), ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER TIMES
        if(tableId == "orderTimesByTech")
        {
                var timeTotal  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].CCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        var a = cellCreator('OTT', num);
                        var b = cellCreator('Cliente',  list[i].PARENTNAME);
                        var c = cellCreator('Sucursal',  list[i].SUCUNAME);
                        
                        var maquiList = JSON.parse(list[i].MAQUIS);
                        var maquis = "";
                        for(var x=0; x<maquiList.length; x++)
                        {
                                var label = maquiList[x];
                                
                                if(label.split("-")[1] == "Locativas")
                                {
                                        label = "Locativas";
                                }
                                
                                if(x == maquiList.length-1)
                                {
                                        maquis = maquis+label;
                                }
                                else
                                {
                                        maquis = maquis+label+", "; 
                                }
                        }
                        
                        
                        var d= cellCreator('Equipos', maquis);
                        
                        if(list[i].TECHNAME == null || list[i].TECHNAME == "")
                        {
                                var e = cellCreator('Técnico', "-");
                        }
                        else
                        {
                                var e = cellCreator('Técnico', list[i].TECHNAME);
                        }
                        
                        
                        var f = cellCreator('Detalle', list[i].DETAIL);
                        var startDate = list[i].STARTIME;
                        if(startDate == "" || startDate == "0000-00-00 00:00:00")
                        {
                                startDate = "Pendiente";
                                var g = cellCreator('Fecha Inicio', startDate);
                                var h = cellCreator('Fecha Cierre', "Pendiente");
                                var j = cellCreator('Tiempo Reportado', "Pendiente");
                                
                                var addTime = 0;
                                
                        }
                        else
                        {
                                var g = cellCreator('Fecha Inicio', list[i].STARTIME);
                                var h = cellCreator('Fecha Cierre',  list[i].CLOSEDATE);
                                
                                var addTime = getdDiff(list[i].STARTIME, list[i].CLOSEDATE);
                                
                                var j = cellCreator('Tiempo/Horas', Math.round((addTime/60) * 100) / 100);
                        }
                        


                        var detail = document.createElement("img");
                        detail.src = "irsc/downIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Descargar Reporte');
                        detail.setAttribute('alt', 'Descargar Reporte');
                        detail.onclick = function()
                        {
                                if(this.reg.STATE != "3" && this.reg.STATE != "4" && this.reg.STATE != "5")
                                {
                                        return;
                                }
                                var info = this.reg;
                                var url = "reports/"+info.CODE+"-T.pdf";
                                downloadReport(url);
                        }
                        
                        if(list[i].STATE != "4" && list[i].STATE != "5")
                        {
                                detail.src = "irsc/downIconG.png";
                        }
                        
                        
                        var icons = [detail];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g,h,j,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);

                        
                        timeTotal += parseInt(addTime);
                }
                
                timeTotal = Math.round(((timeTotal/60) * 100) / 100)
                
                var line = ["", "", "", "", "", "", "",  "Total horas", timeTotal, "Ordenes"+list.length, ""];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
        // ORDER TIMES BY ACTI
        if(tableId == "orderTimesByActi")
        {
                var timeTotal  = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Actividad', list[i].ADESC);
                        var b = cellCreator('Fecha',  list[i].DATE);
                        var c = cellCreator('Cliente',  list[i].PARENTNAME);
                        var d = cellCreator('Sucursal',  list[i].SUCUNAME);
                        var e = cellCreator('Equipo',  list[i].MAQUINAME);
                        var f = cellCreator('Técnico',  list[i].TECHNAME);

                        var addTime = list[i].ADURATION;

                        var g = cellCreator('Tiempo/Minutos',  addTime);
                        

                        var cells = [a,b,c,d,e,f,g];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        
                        table.appendChild(row);

                        
                        timeTotal += parseInt(addTime);
                        
                         console.log("gets2")
                }
                
                timeTotal = (timeTotal/60).toFixed(2);
                
                var line = ["", "", "", "", "", "Total horas", timeTotal];
                var totalRow = enderRow(line);
                table.appendChild(totalRow);
                
        }
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
// REPORT BLOCK STA ----------

// TABLES
function tableCreator(tableId, list)
{
        var table = document.getElementById(tableId);
        tableClear(tableId);
        
        if(list.length == 0)
        {
                var nInYet = document.createElement("div");
                nInYet.innerHTML = language["noResults"];
                nInYet.className = "blankProducts";
                table.appendChild(nInYet);
                resSet();
                
                if(tableId == "oActsTable")
                {
                        etimeTotal = 0;
                        actisTotal = 0;
                        
                        if(aud.TYPE != "C"){document.getElementById("oEstimated").innerHTML = etimeTotal+" Min";document.getElementById("oActotal").innerHTML = addCommas(actisTotal);}else{document.getElementById("oEstimated").innerHTML = etimeTotal+" Min";document.getElementById("oActotal").innerHTML = "-";}setTotals();
                }
                if(tableId == "oPartsTable")
                {
                         partsTotal = 0;
                        
                        if(aud.TYPE != "C"){document.getElementById("oReptotal").innerHTML = addCommas(partsTotal);}else{document.getElementById("oReptotal").innerHTML = "-";}setTotals();
                }
                if(tableId == "oOthersTable")
                {
                         othersTotal = 0;
                        
                        if(aud.TYPE != "C"){document.getElementById("oOtherstotal").innerHTML = addCommas(othersTotal);}else{document.getElementById("oOtherstotal").innerHTML = "-";}setTotals();
                }
                
                return;
        }
        // CLIENTS TABLE
        if(tableId == "clientesTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Nombre cliente', list[i].CNAME)
				var b = cellCreator('Nombre encargado', list[i].RESPNAME)
				var c = cellCreator('NIT/ID', list[i].NIT)
				var d = cellCreator('Teléfonos', list[i].PHONE)
				var e = cellCreator('Dirección Principal', list[i].ADDRESS)
				var f = cellCreator('Email', list[i].MAIL)
				var g= cellCreator('Ciudad y Depto', list[i].LOCATION)
				
				var edit = document.createElement("img");
				edit.src = "irsc/editIcon.png";
				edit.reg = list[i];
				edit.setAttribute('title', 'Editar');
				edit.setAttribute('alt', 'Editar');
				edit.onclick = function()
				{
						actualClientCode = this.reg.CODE;
						editMode = 1;
						var info = this.reg;
						var items = [decry(info.CNAME), decry(info.RESPNAME), info.NIT, info.CNATURE,  info.PHONE, decry(info.ADDRESS), info.MAIL, decry(info.LOCATION)];
						infoFiller(items, a_clients_targets);
						

						
						// document.getElementById("a-clientEmail").disabled = true;
						clientSaveButton = document.getElementById("clientSaveButton");
						clientSaveButton.innerHTML = "Guardar";

					   return false;
				}
				var pass = document.createElement("img");
				pass.src = "irsc/passIcon.png";
				pass.reg = list[i];
				pass.setAttribute('title', 'Cambiar Clave');
				pass.setAttribute('alt', 'Cambiar Clave');
				pass.onclick = function()
				{
						pssChange(this.reg.MAIL, "C");
				}
				var del = document.createElement("img");
				del.src = "irsc/delIcon.png";
				del.reg = list[i];
				del.setAttribute('title', 'Eliminar');
				del.setAttribute('alt', 'Eliminar');
				del.onclick = function()
				{
						var tableId = this.parentNode.parentNode.parentNode.id;
						var param = [tableId, this.reg.MAIL];
						
						confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}
				var disable = document.createElement("img");
				disable.src = "irsc/disableIcon.png";
				disable.reg = list[i];
				disable.setAttribute('title', 'Desactivar');
				disable.setAttribute('alt', 'Desactivar');
				disable.onclick = function()
				{
						var data = this.reg;
						var info = {};
						info.code = data.CODE;
						info.actual = data.STATUS;
						

						sendAjax("users","changeClientState",info,function(response)
						{
								var ans = response.message;

								clientsGet()
						});
				}
				
				if(list[i].STATUS == "0")
				{
					   disable.src = "irsc/disableIconG.png"; 
				}

				if(aud.TYPE == "A")
				{
					var icons = [edit, pass, del, disable];
				}
				else
				{
					var icons = [edit, pass, disable];
				}
				
				
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,d,e,f,g,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
        // SUCUS TABLE
        if(tableId == "sucusTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Cliente', list[i].PARENTNAME)
                        var b = cellCreator('Código', list[i].CODE)
                        var c = cellCreator('Nombre Sucursal', list[i].NAME)
                        var d = cellCreator('Dirección', list[i].ADDRESS)
                        var e = cellCreator('Teléfonos', list[i].PHONE)
                        var f = cellCreator('País', list[i].COUNTRY)
                        var g= cellCreator('Departamento', list[i].DEPTO)
                        var h= cellCreator('Ciudad/Municipio', list[i].CITY)
                        
                        var edit = document.createElement("img");
                        edit.src = "irsc/editIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                
                                editMode = 1;
                                var info = this.reg;
                                var items = [decry(info.PARENTCODE), decry(info.CODE), info.NAME, info.ADDRESS, decry(info.PHONE)];
                                infoFiller(items, a_sucu_targets);
                                
                                var locationFields = ["a-sucuCountry", "a-sucuDepto", "a-sucuCity"];
                                var values = [info.COUNTRY, info.DEPTO, info.CITY];
                                
                                document.getElementById("a-sucuCode").disabled = true;
                                document.getElementById("a-sucuParent").disabled = true;
                                sucuSaveButton.innerHTML = "Guardar";
                               
                                cascadeInfoFiller(locationFields, values, "t");
                        }
                        var detail = document.createElement("img");
                        detail.src = "irsc/detailIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Equipos de sucursal');
                        detail.setAttribute('alt', 'Equipos de sucursal');
                        detail.onclick = function()
                        {
                                
                                actualParentCode = this.reg.PARENTCODE;
                                actualSucuCode = this.reg.CODE;
                                
                                ifLoad('ifMasterM');
                                
                                setTimeout(function()
                                {
                                        var fields = ["f-maquiParent", "f-maquiSucu"];
                                        var values = [actualParentCode, actualSucuCode];
                                        cascadeInfoFiller(fields, values, "v");
                                        maquiGet();
                                },100);

                        }
                        
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        var icons = [edit, detail, del];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g,h,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // MAQUIS TABLE
        if(tableId == "maquisTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Cliente', list[i].PARENTNAME)
                        if(list[i].SUCUNAME == "-")
                        {
                                var b = cellCreator('Sucursal', list[i].SUCUCODE);
                        }
                        else
                        {
                                var b = cellCreator('Sucursal', list[i].SUCUNAME);
                        }
                        
                        
                        if(list[i].PLATE.split("-")[1] == "Locativas")
                        {
                                if(list[i].PLATE.split("-")[1] == "Locativas")
                                {
                                        var c = cellCreator('Placa', "Locativas");
                                }
                                
                        }
                        else
                        {
                                var c = cellCreator('Placa', list[i].PLATE);
                        }
                        
                        
                        var d = cellCreator('Nombre', list[i].NAME)
                        var e = cellCreator('Modelo', list[i].MODEL)
                        var f = cellCreator('Serial', list[i].SERIAL)
                        var g= cellCreator('Voltaje', list[i].VOLT)
                        var h= cellCreator('Corriente', list[i].CURRENT)
                        var j= cellCreator('Potencia', list[i].POWER)
                        var k= cellCreator('Fases', list[i].PHASES)
                        var l= cellCreator('observaciones', list[i].DETAIL)
                        
                        var edit = document.createElement("img");
                        edit.src = "irsc/editIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                
                                if(this.reg.PLATE.split("-")[1] == "Locativas"){return;}
                                
                                editMode = 1;
                                var info = this.reg;
                                
                                var targets = ["a-maquiPlate", "a-maquiName", "a-maquiModel", "a-maquiSerial", "a-maquiVolt", "a-maquiCurrent", "a-maquiPower", "a-maquiPhase", "a-maquiDetails"];
                                var items = [info.PLATE, info.NAME, info.MODEL, info.SERIAL, info.VOLT, info.CURRENT, info.POWER, info.PHASES, info.DETAIL];
                                infoFiller(items, targets);
                                
                                if(this.reg.PLATE.split("-")[1] == "Locativas")
                                {
                                        document.getElementById("a-maquiParent").disabled = true;
                                        document.getElementById("a-maquiPlate").disabled = true;
                                        document.getElementById("a-maquiSucu").disabled = true;
                                        document.getElementById("a-maquiName").disabled = true;
                                }
                                else
                                {
                                        document.getElementById("a-maquiParent").disabled = true;
                                        document.getElementById("a-maquiPlate").disabled = true;
                                        document.getElementById("a-maquiSucu").disabled = true; 
                                        document.getElementById("a-maquiName").disabled = false;
                                }
                                
                                maquiSaveButton.innerHTML = "Guardar";
                                
                                var fields = ["a-maquiParent", "a-maquiSucu"];
                                var values = [info.PARENTCODE, info.SUCUCODE];
                                cascadeInfoFiller(fields, values, "v");
                        }
                        var history = document.createElement("img");
                        history.src = "irsc/history.png";
                        history.reg = list[i];
                        history.setAttribute('title', 'Ver historial');
                        history.setAttribute('alt', 'Ver historial');
                        history.onclick = function()
                        {
                                showMaquiStory(this.reg.CODE);
                        }
                        var del = document.createElement("img");
                        if(list[i].PLATE.split("-")[1] == "Locativas")
                        {
                                edit.src = "irsc/editIconG.png";
                                del.src = "irsc/delIconG.png";
                        }
                        else
                        {
                                edit.src = "irsc/editIcon.png";
                                del.src = "irsc/delIcon.png";
                        }
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                if(this.reg.PLATE.split("-")[1] == "Locativas"){return;}

                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.PLATE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        var icons = [edit, history, del];
                        var x = cellOptionsCreator('', icons)
                        var cells = [c,d,a,b,e,f,g,h,j,k,l,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // TECHIS TABLE
        if(tableId == "techisTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Identificación', list[i].NIT)
				var b = cellCreator('Nombre', list[i].RESPNAME)
				var c = cellCreator('Tipo', list[i].
				TYPE)
				var d = cellCreator('Especialidad', list[i].MASTERY)
				var loc = cellCreator('Ciudad', list[i].LOCATION)
				var e = cellCreator('Email', list[i].MAIL)
				var f = cellCreator('Dirección', list[i].ADDRESS)
				var g= cellCreator('Teléfonos', list[i].PHONE)
				var h= cellCreator('Observaciones', list[i].DETAILS)
				
				
				var edit = document.createElement("img");
				edit.src = "irsc/editIcon.png";
				edit.reg = list[i];
				edit.setAttribute('title', 'Editar');
				edit.setAttribute('alt', 'Editar');
				edit.onclick = function()
				{
						
						editMode = 1;
						var info = this.reg;

						var items = [decry(info.NIT), decry(info.RESPNAME), info.TYPE, info.MASTERY, info.MAIL, info.LOCATION, info.ADDRESS, info.PHONE, info.DETAILS];
						infoFiller(items, a_techi_targets);
						document.getElementById("a-techiId").disabled = true;
						// document.getElementById("a-techiEmail").disabled = true;
						techiSaveButton.innerHTML = "Guardar";
						actualTechiCode = this.reg.CODE;

					   return false;
				}
				var pass = document.createElement("img");
				pass.src = "irsc/passIcon.png";
				pass.reg = list[i];
				pass.setAttribute('title', 'Cambiar Contraseña');
				pass.setAttribute('alt', 'Cambiar Contraseña');
				pass.onclick = function()
				{
						pssChange(this.reg.MAIL, this.reg.TYPE);
				}
				var del = document.createElement("img");
				del.src = "irsc/delIcon.png";
				del.reg = list[i];
				del.setAttribute('title', 'Eliminar');
				del.setAttribute('alt', 'Eliminar');
				del.onclick = function()
				{
						var tableId = this.parentNode.parentNode.parentNode.id;
						var param = [tableId, this.reg.MAIL, this.reg.TYPE];
						
						confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}

				var icons = [edit, pass, del];
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,d,loc,e,f,g,h,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
        // ACTIS TABLE
        if(tableId == "actisTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Código', list[i].CODE)
                        var b = cellCreator('Tipo', list[i].ACTYPE)
                        var c = cellCreator('Descripción', list[i].DESCRIPTION)
                        var d = cellCreator('Duración', list[i].DURATION)
                        var e = cellCreator('Valor', addCommas(list[i].COST))
                        
                        var edit = document.createElement("img");
                        edit.src = "irsc/editIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                
                                editMode = 1;
                                var info = this.reg;
                                actualActCode = this.reg.CODE;
                                var items = [info.ACTYPE, info.DESCRIPTION, info.DURATION, info.COST];
                                document.getElementById("a-actiType").disabled = true;
                                infoFiller(items, a_acti_targets);
                                actiSaveButton.innerHTML = "Guardar";

                               return false;
                        }
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        var icons = [edit, del];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // INVE TABLE
        if(tableId == "inveTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Código', list[i].CODE)
                        var b = cellCreator('Descripción', list[i].DESCRIPTION)
                        var c = cellCreator('Valor compra', addCommas(list[i].COST))
                        var d = cellCreator('% Margen', list[i].MARGIN)
                        var sellValue = parseInt(list[i].COST)+((parseInt(list[i].COST)*parseInt(list[i].MARGIN))/100);
                        var e = cellCreator('Valor venta', addCommas(sellValue));
                        var f = cellCreator('% Margen', list[i].AMOUNT);
                        
                        var edit = document.createElement("img");
                        edit.src = "irsc/editIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                
                                editMode = 1;
                                var info = this.reg;
                               
                                var items = [info.CODE, info.DESCRIPTION, info.COST, info.MARGIN, info.AMOUNT];
                                document.getElementById("a-inveCode").disabled = true;
                                inveSaveButton.innerHTML = "Guardar";
                                infoFiller(items, a_inve_targets);
                        }
                        var add = document.createElement("img");
                        add.src = "irsc/addIcon.png";
                        add.reg = list[i];
                        add.onclick = function()
                        {

                                var info = this.reg;
                               
                               addInvQty(info.CODE, info.DESCRIPTION);
                                
                        }
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        var icons = [edit, add, del];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // LOG TABLE
        if(tableId == "logTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Responsable', list[i].AUTOR)
				var b = cellCreator('Fecha', list[i].DATE)
				
				var type = "";
				if(list[i].TYPE == "A"){type = "Administrador"}
				if(list[i].TYPE == "AC"){type = "Actividad"}
				if(list[i].TYPE == "C"){type = "Cliente"}
				if(list[i].TYPE == "I"){type = "Inventario"}
				if(list[i].TYPE == "M"){type = "Equipo"}
				if(list[i].TYPE == "S"){type = "Sucursal"}
				if(list[i].TYPE == "T"){type = "Técnico"}
				if(list[i].TYPE == "O"){type = "Orden"}
				if(list[i].TYPE == "CO"){type = "Coordinador"}
				if(list[i].TYPE == "JZ"){type = "Jefe de Zona"}
				
				
				
				var c = cellCreator('Tipo', type)
				var d = cellCreator('Objetivo', list[i].TARGET)
				var e = cellCreator('Movimiento', list[i].OPTYPE);

				var cells = [a,b,c,d,e];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
         // ORDERS TABLE
        if(tableId == "ordersTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Cliente', list[i].PARENTNAME)
				
				if(list[i].SUCUNAME == "-")
				{
						var b = cellCreator('Sucursal', list[i].SUCUCODE);
				}
				else
				{
						var b = cellCreator('Sucursal', list[i].SUCUNAME);
				}
				
				var loc = cellCreator('Ubicación', list[i].LOCATION)
				
				var maquiList = JSON.parse(list[i].MAQUIS);
				var maquis = "";
				
				for(var x=0; x<maquiList.length; x++)
				{
					var label = maquiList[x];
					
					if(label.split("-")[1] == "Locativas")
					{
							label = "Locativas";
					}
					
					if(x == maquiList.length-1)
					{
							maquis = maquis+label;
					}
					else
					{
							maquis = maquis+label+", "; 
					}
				}
				
				if(list[i].MAQUIS = "[]"){	maquis = "Locativas";	}				
				var c = cellCreator('Equipos', maquis)
				var num = list[i].CCODE;
				
				if(num.length == 1){num = "000"+num;}
				else if(num.length == 2){num = "00"+num;}
				else if(num.length == 3){num = "0"+num;}
				else{num = num;}

				if(list[i].STARTIME < getNow() && list[i].STATE == "1") 
				{
					var start = "<p class='lateDate'>"+list[i].DATE+"</p>";
					var end = "<p class='lateDate'>"+list[i].STARTIME+"</p>";
					
				}
				else
				{
					var start = "<p class='coolDate'>"+list[i].DATE+"</p>";
					var end = "<p class='coolDate'>"+list[i].STARTIME+"</p>";
				}

				var n = cellCreator('OTT', num);
				
				if(list[i].ICODE != null && list[i].ICODE != "")
				{
						var m = cellCreator('Orden-Cliente', list[i].ICODE);
				}
				else
				{
						var m = cellCreator('Orden-Cliente', "-");
				}
				
				
				var d = cellCreator('Fecha Creación', start);
				var e = cellCreator('Fecha Inicio', end);
				var f = cellCreator('Detalle', list[i].DETAIL);
				
				if(list[i].STATE == "1"){var state = "Nueva"}
				if(list[i].STATE == "2"){var state = "Proceso"}
				if(list[i].STATE == "3"){var state = "Revisión"}
				if(list[i].STATE == "4"){var state = "Por facturar"}
				if(list[i].STATE == "5"){var state = "Facturada"}
				if(list[i].STATE == "6"){var state = "Previsita"}
				if(list[i].STATE == "7"){var state = "Cotizado"}
				
				var g = cellCreator('Estado', state);
				var h = cellCreator('Autor', list[i].AUTOR);
				
				
				var edit = document.createElement("img");
				edit.src = "irsc/editIcon.png";
				edit.reg = list[i];
				edit.setAttribute('title', 'Editar');
				edit.setAttribute('alt', 'Editar');
				edit.onclick = function()
				{
						
						editMode = 1;
						var info = this.reg;
						var items = [info.STARTIME, info.ENDTIME, info.DETAIL, info.ICODE];
						var targets = ["a-orderPriority", "a-orderPriority2", "a-orderDesc", "a-orderOrderClient"];
						infoFiller(items, targets);
						
						actualOrderCode = info.CODE;
						actualOrderState = info.STATE;
						
						var parentFields= ["a-orderParent", "a-orderSucu"];
						var parentValues= [info.PARENTCODE, info.SUCUCODE];
						cascadeInfoFiller(parentFields, parentValues, "v");
						
						actualMaquiPicks = JSON.parse(info.MAQUIS);
						
						orderSaveButton.innerHTML = "Guardar";
						
						document.getElementById("a-orderParent").disabled = true;
						document.getElementById("a-orderSucu").disabled = true;

						var a_order_sucuField = document.getElementById("a-orderSucu");
						a_order_sucuField.onchange();
						
				}
				var asign = document.createElement("img");
				
				asign.reg = list[i];
				asign.setAttribute('title', 'Asignar Responsable');
				asign.setAttribute('alt', 'Asignar Responsable');
				asign.onclick = function()
				{
						var info = this.reg;
						
						if(info.STATE != "1" && info.STATE != "2" && info.STATE != "6" && info.STATE != "7")
						{
								alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puede asignar o modificar técnico a ordenes 'Nuevas' o en 'Proceso'", 300);
								return;
						}
						if(info.RESPTYPE == "")
						{
							actualTechVal = "";
						}
						else if(info.RESPTYPE == "T")
						{
							actualTechVal = info.TECHCODE+">"+info.TECHNAME+">"+info.RESPTYPE;
						}
						else if(info.RESPTYPE == "CO")
						{
							actualTechVal = info.AUTORCODE+">"+info.TECHNAME+">"+info.RESPTYPE;
						}
						else if(info.RESPTYPE == "JZ")
						{
							actualTechVal = info.JZCODE+">"+info.TECHNAME+">"+info.RESPTYPE;
						}
						
						sendAjax("users","getTechiListO","",function(response)
						{
								var ans = response.message;
								
								actualTechList = ans;
								asignTechBox(info.CODE, info.CCODE);
								
						});
				}
				
				
				if(list[i].TECHCODE == "")
				{
					asign.src = "irsc/techIconG.png";
				}
				else
				{
					asign.src = "irsc/techIcon.png";
				}
				
				
				var detail = document.createElement("img");
				detail.src = "irsc/openIcon.png";
				detail.reg = list[i];
				detail.setAttribute('title', 'Detalle');
				detail.setAttribute('alt', 'Detalle');
				detail.onclick = function()
				{
						var info = this.reg;
						
						if(info.TECHCODE == "")
						{
								alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Antes de ver el detalle de orden debe asignarse a un técnico!", 300);
								return;
						}
						
						ifLoad('iforderMain');
						orderStarter(info.CODE)
				}

				var del = document.createElement("img");
				del.src = "irsc/delIcon.png";
				del.reg = list[i];
				del.setAttribute('title', 'Eliminar');
				del.setAttribute('alt', 'Eliminar');
				del.onclick = function()
				{
						var tableId = this.parentNode.parentNode.parentNode.id;
						var param = [tableId, this.reg.CODE];
						
						confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}
				
				var upload = document.createElement("img");
				upload.src = "irsc/upload.png";
				upload.reg = list[i];
				upload.setAttribute('title', 'Cargar Cotización');
				upload.setAttribute('alt', 'Cargar Cotización');
				upload.onclick = function()
				{
						
						var info = this.reg;
						var picker =document.getElementById("budgetSelectorOrder");
						actualLoadOrder = info.CODE;
						picker.click();
						picker.name = info.CODE+"[]";
						
						console.log(picker);
				}
				
				var download = document.createElement("img");
				download.src = "irsc/downIcon.png";
				download.reg = list[i];
				download.setAttribute('title', 'Descargar Cotización');
				download.setAttribute('alt', 'Descargar Cotización');
				
				download.onclick = function()
				{
					
					var info = this.reg;
					var filename = info.FILELINK;
					var url = "budgets/"+info.CODE+"/"+filename;
					// console.log(decry(url));
					downloadReport(decry(url));
					
				}
				
				var selector = document.createElement("input");
				selector.type = "checkbox";
				selector.reg = list[i];
				selector.setAttribute('title', 'Seleccionar para facturación');
				selector.setAttribute('alt', 'Seleccionar para facturación');
				
				selector.id = list[i].CODE;
				

				
				if(list[i].STATE == "4")
				{
					
					if(aud.TYPE == "A" )
					{
						if(list[i].FILELINK != "")
						{
							var icons = [edit, asign, download, detail, del, selector];
						}
						else
						{
							var icons = [edit, asign, detail, del, selector];
						}
					}
					else
					{
						if(list[i].FILELINK != "")
						{
							var icons = [edit, asign, download, detail, del, selector];
						}
						else
						{
							var icons = [edit, asign, detail, del, selector];
						}
						
					}
				}
				else if(list[i].STATE == "5")
				{
					if(list[i].FILELINK != "")
					{
						var icons = [detail, download];
					}
					else
					{
						var icons = [detail];
					}
				}
				else if(list[i].STATE == "6" || list[i].STATE == "7")
				{
					if(list[i].FILELINK != "")
						{
							var icons = [edit, asign, upload, download, detail, del, selector];
						}
						else
						{
							var icons = [edit, asign, upload, detail, del, selector];
						}
				}
				else
				{
					if(aud.TYPE == "A")
					{
						if(list[i].FILELINK != "")
						{
							var icons = [edit, asign, download, detail, del];
						}
						else
						{
							var icons = [edit, asign, detail, del];
						}
					}
					else
					{
						if(list[i].FILELINK != "")
						{
							var icons = [edit, asign, download, detail, del];
						}
						else
						{
							var icons = [edit, asign, detail, del];
						}
					}
					
					
					
				}
				
				var x = cellOptionsCreator('', icons)
				
				
				var cells = [a,b,loc,c,n,m,d,e,f,g,h,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
			
        }
         // ORDERS ACTIS TABLE
        if(tableId == "oActsTable")
        {
                etimeTotal = 0;
                actisTotal = 0;
                
                
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        if(list[i].MAQUI.split("-")[1] == "Locativas")
                        {
                                var a = cellCreator('Placa', "Locativas");
                        }
                        else
                        {
                                var a = cellCreator('Placa', list[i].MAQUI);
                        }
                        
                        
                        var b = cellCreator('Nombre', list[i].MAQUINAME);
   
                        var c = cellCreator('Descripción', list[i].ADESC);
                        var d = cellCreator('Duración', list[i].ADURATION);
                        
                        etimeTotal = etimeTotal+parseInt(list[i].ADURATION);
                        actisTotal = actisTotal+parseInt(list[i].ACOST);
                        
                        if(aud.TYPE != "C")
                        {
                                var e = cellCreator('Valor', addCommas(list[i].ACOST));
                        }
                        else
                        {
                                var e = cellCreator('Valor', "-");
                        }


                        var edit = document.createElement("img");
                        edit.src = "irsc/cPriceIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                
                                var info = this.reg;

                              
                                
                                actualActCode = info.CODE;
                                actualCost = info.ACOST;
                                editActPrice();
                                
                        }
                        
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }
                        
                        
                        
                        if(aud.TYPE == "A")
                        {
                                var icons = [edit, del];
                        }
                        else
                        {
                                var icons = [del];
                        }
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c, d, e, x];
                        
                        
                        
                        for(var r=0; r<cells.length; r++)
                        {
      
                                row.appendChild(cells[r]);
                                
                        }
                        table.appendChild(row);

                }

                if(aud.TYPE == "A"){document.getElementById("oEstimated").innerHTML = etimeTotal+" Min";document.getElementById("oActotal").innerHTML = addCommas(actisTotal);}else{document.getElementById("oEstimated").innerHTML = etimeTotal+" Min";document.getElementById("oActotal").innerHTML = "-";}setTotals();
                
        }
         // ORDERS PARTS TABLE
        if(tableId == "oPartsTable")
        {
                partsTotal = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";

                        var a = cellCreator('Código', list[i].PCODE);
                        var b = cellCreator('Descripción', list[i].PDESC);
                        var c = cellCreator('Cantidad', list[i].PAMOUNT);
                        var cost = parseInt(list[i].PAMOUNT)*parseInt(list[i].PCOST);
                        
                        partsTotal = partsTotal+parseInt(cost);
                        
                        if(aud.TYPE == "A" || aud.TYPE == "JZ" || aud.TYPE == "CO" )
                        {
                                var d = cellCreator('Valor unitario', addCommas(list[i].PCOST));
                                var e = cellCreator('Subtotal', addCommas(cost));
                        }
                        else
                        {
                                var d = cellCreator('Valor unitario', "-");
                                var e = cellCreator('Subtotal', "-");
                        }

                        
                        var edit = document.createElement("img");
                        edit.src = "irsc/cPriceIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                var info = this.reg;

                                
                                actualPartCode = info.CODE;
                                actualCost = info.PCOST;
                                editPartPrice();
                                
                        }
                        
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        if(aud.TYPE == "A")
                        {
                                var icons = [edit, del];
                        }
                        else
                        {
                                var icons = [del];
                        }
                        
                         var doc = "-";
                        if(list[i].PDOC != null && list[i].PDOC != "")
                        {
                                doc = list[i].PDOC;
                        }
                        
                        var p = cellCreator('Factura', doc);
                        
                        var x = cellOptionsCreator('', icons)
                        var cells = [a, b, c, d, e, p, x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
                
                if(aud.TYPE == "A"){document.getElementById("oReptotal").innerHTML = addCommas(partsTotal);}else{document.getElementById("oReptotal").innerHTML = "-";}setTotals();
        }
        // ORDERS OTHERS TABLE
        if(tableId == "oOthersTable")
        {
                othersTotal = 0;
                
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";

                        var a = cellCreator('Descripción', list[i].ODESC);
                        var b = cellCreator('Cantidad', list[i].AMOUNT);
                        
                        var cost = parseInt(list[i].AMOUNT)*parseInt(list[i].COST);
                        
                        othersTotal = othersTotal+parseInt(cost);
                        
                        if(aud.TYPE == "C")
                        {
                                var c = cellCreator('Valor unitario', "-");
                                var d = cellCreator('Subtotal', "-");
                        }
                        else
                        {
                                
								var c = cellCreator('Valor unitario', addCommas(list[i].COST));
                                var d = cellCreator('Subtotal', addCommas(cost));
                        }

                        var edit = document.createElement("img");
                        edit.src = "irsc/cPriceIcon.png";
                        edit.reg = list[i];
                        edit.setAttribute('title', 'Editar');
                        edit.setAttribute('alt', 'Editar');
                        edit.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                var info = this.reg;

                                actualOtherCode = info.CODE;
                                actualCost = info.COST;
                                editOtherPrice();
                                
                        }
                        
                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                if(actualOrderData.STATE == "5"){alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta orden se encuentra facturada no podrá hacer ningún cambio", 300);return;}
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }

                        if(aud.TYPE == "A")
                        {
                                var icons = [edit, del];
                                var icons = [];
                        }
                        else
                        {
                                var icons = [del];
                                var icons = [];
                        }
                        
                        var doc = "-";
                        if(list[i].DOC != null && list[i].DOC != "")
                        {
                                doc = list[i].DOC;
                        }
                        
                        var p = cellCreator('Factura', doc);
                        
                        var x = cellOptionsCreator('', icons)
                        var cells = [a, b, c, d, p, x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
                
                if(aud.TYPE != "C"){document.getElementById("oOtherstotal").innerHTML = addCommas(othersTotal);}else{document.getElementById("oOtherstotal").innerHTML = "-";}setTotals();
        }
        // MAQUISTORY TABLE
        if(tableId == "maquiStoryTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";

                        var a = cellCreator('Fecha', list[i].DATE)
                        var num = list[i].OCCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}

                        var b = cellCreator('Orden', num)
                        var c = cellCreator('Actividad', list[i].ADESC)
                        var d = cellCreator('Técnico', list[i].TECHNAME)

                        var cells = [a,b,c,d];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // REPORTS TABLE
        if(tableId == "repTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var a = cellCreator('Cliente', list[i].PARENTNAME);

				if(list[i].SUCUNAME == "-")
				{
						var b = cellCreator('Sucursal', list[i].SUCUCODE);
				}
				else
				{
						var b = cellCreator('Sucursal', list[i].SUCUNAME);
				}
				
				var num = list[i].OCCODE;
				if(num.length == 1){num = "000"+num;}
				else if(num.length == 2){num = "00"+num;}
				else if(num.length == 3){num = "0"+num;}
				else{num = num;}
				
				
				var c = cellCreator('OTT', num);
				var d = cellCreator('Técnico', list[i].TECHNAME);
				var e = cellCreator('Fecha', list[i].DATE);
				
				var download = document.createElement("img");
				download.src = "irsc/downIcon.png";
				download.reg = list[i];
				download.setAttribute('title', 'Descargar reporte de servicio');
				download.setAttribute('alt', 'Descargar reporte de servicio');
				download.onclick = function()
				{
						
						var info = this.reg;
						var url = "reports/"+info.OCODE+".pdf";
						downloadReport(url);
				}

				var downloadT = document.createElement("img");
				downloadT.src = "irsc/downIconT.png";
				downloadT.reg = list[i];
				downloadT.setAttribute('title', 'Descargar reporte totalizado');
				downloadT.setAttribute('alt', 'Descargar reporte totalizado');
				downloadT.onclick = function()
				{
						
						var info = this.reg;
						var url = "reports/"+info.OCODE+"-T.pdf";
						downloadReport(url);
				}
				
				var downloadE = document.createElement("img");
				downloadE.src = "irsc/downIconE.png";
				downloadE.reg = list[i];
				downloadE.setAttribute('title', 'Descargar reporte Excel');
				downloadE.setAttribute('alt', 'Descargar reporte Excel');
				downloadE.onclick = function()
				{
						var info = this.reg;
						var url = "reports/"+info.OCODE+".csv";
						info.url = url;
						info.code = this.reg.OCODE;
						info.rtype = "rt";
						downloadCvsOrder(info);
				}
				
				if(list[i].TYPE == "0")
				{
						var icons = [download, downloadE];
				}
				else
				{
						var icons = [download, downloadT, downloadE];
				}
				
				if(aud.TYPE == "T")
				{
						var icons = [download];
				}
				
				
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,d,e,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
		// LEGS TABLE
        if(tableId == "legTable")
        {
			
			
			var costTotal1  = 0;
			var costTotal2  = 0;
			var costTotal3  = 0;
			var costTotal4  = 0;
			var costTotal5  = 0;
			var costTotal6  = 0;
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				
				
				var a = cellCreator('Cliente', list[i].LEGPARENT);
				var b = cellCreator('Orden', list[i].LEGORDER);
				var c = cellCreator('Fecha', list[i].LEGDATE);
				var d = cellCreator('Id', list[i].LEGCID);
				var e = cellCreator('Razón social', list[i].LEGCNAME);
				var f = cellCreator('Número', list[i].DOC);
				var g = cellCreator('Concepto', list[i].ODESC);
				var h = cellCreator('Base', addCommas(list[i].LEGBASE));
				var j = cellCreator('IVA', addCommas(list[i].LEGTAX));
				var k = cellCreator('Total', addCommas(list[i].LEGTOTAL));
				var l = cellCreator('Rtefte', addCommas(list[i].LEGRETFONT));
				var m = cellCreator('RteIVA', addCommas(list[i].LEGRETICA));
				var n = cellCreator('Total pagado', addCommas(list[i].LEGTOTAL));

				var del = document.createElement("img");
				
				del.reg = list[i];
				del.setAttribute('title', 'Eliminar registro');
				del.setAttribute('alt', 'Eliminar registro');
				del.onclick = function()
				{
					 var param = ["legTable", this.reg.CODE];
					confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}
				
				if(list[i].LEGSTATE == "0")
				{
					del.src = "irsc/delIcon.png";
					var icons = [del];
					
				}
				else
				{
					del.src = "irsc/delIconG.png";
					var icons = [];
				}
				
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,d,e,f,g,h,j,k,l,m,n,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
				
				console.log(list[i].COST)
				
				costTotal1 += parseInt(list[i].LEGBASE);
				costTotal2 += parseInt(list[i].LEGTAX);
				costTotal3 += parseInt(list[i].LEGTOTAL);
				costTotal4 += parseInt(list[i].LEGRETFONT);
				costTotal5 += parseInt(list[i].LEGRETICA);
				costTotal6 += parseInt(list[i].LEGTOTAL);

			}
			
			var line = ["", "", "", "", "", "", "Totales", addCommas(costTotal1), addCommas(costTotal2),  addCommas(costTotal3), addCommas(costTotal4), addCommas(costTotal5), addCommas(costTotal6),];
			var totalRow = enderRow(line);
                table.appendChild(totalRow);
			
			
        }
		
        // FACT RESUME TABLE
        if(tableId == "factResumeTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var num = list[i].oNumber;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        
                        var a = cellCreator('Orden', num);
                        var b = cellCreator('Actividades', addCommas(list[i].tActis));
                        var c = cellCreator('Repuestos', addCommas(list[i].tReps));
                        var d = cellCreator('Otros', addCommas(list[i].tOthers));
                        var e = cellCreator('Subtotal', addCommas(list[i].osubTotal));
                        var f = cellCreator('IVA 19%', addCommas(list[i].oTax));
                        var g = cellCreator('Retefuente 4%', addCommas(list[i].oRet4));
                        var h = cellCreator('Retefuente 2.5%', addCommas(list[i].oRet25));
                        var j = cellCreator('Total Orden', addCommas(list[i].oTotal));

                        var cells = [a,b,c,d,e,f,g,h,j];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // RESO MASTER TABLE
        if(tableId == "resoTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        
                        var state = "Activa";
                        
                        if(list[i].ACTIVE == "0")
                        {
                                state = "Usada";
                        }
                                                
                        var actual = list[i].ACTUAL;
                        if(actual.length == 1){actual = "000"+actual;}
                        else if(actual.length == 2){actual = "00"+actual;}
                        else if(actual.length == 3){actual = "0"+actual;}
                        else{actual = actual;}
                        
                        if(parseInt(list[i].ACTUAL) > parseInt(list[i].END))
                        {
                                actual = "Agotada";
                        }
                        
                        var a = cellCreator('Resolución', list[i].RESOLUTION);
                        var b = cellCreator('Fecha',  list[i].DATE);
                        var c = cellCreator('Número Inicial', list[i].START);
                        var d = cellCreator('Número Final', list[i].END);
                        var e = cellCreator('Número Actual', actual);
                        var f = cellCreator('Estado', state);
                        
                        
                        
                        
                        var h = cellCreator('Estado', state);

                        var cells = [a,b,c,d,e,f];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // FACT TABLE
        if(tableId == "recTable")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                                                
                        var num = list[i].NUM;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        
                        var a = cellCreator('Número', num);
                        var b = cellCreator('Resolución',  list[i].RESOLUTION);
                        var c = cellCreator('Cliente', list[i].PARENTNAME);
                        var d = cellCreator('Ordenes', list[i].ORDERS);
                        var e = cellCreator('Fecha Expedición', list[i].DATE.split(" ")[0]);
                        var f = cellCreator('Fecha Vencimiento', list[i].DIEDATE.split(" ")[0]);
                        var g = cellCreator('Valor Total', addCommas(list[i].TOTAL));
                        
                        var state = "<span style='color:green;'>Activa</span>";
                        
                        if(list[i].STATE == "0")
                        {
                                state = "<span style='color:red;'>Anulada</span>";
                        }
                        
                        var h = cellCreator('Estado', state);
                        
                        
                        var download = document.createElement("img");
                        download.src = "irsc/downIcon.png";
                        download.reg = list[i];
                        download.onclick = function()
                        {

                                var info = this.reg;
                                var url = "receipts/"+info.PARENTCODE+"/"+info.RESOLUTION+"-"+info.NUM+".pdf";
                                downloadReport(url);
                        }
                        
                        var nuller = document.createElement("img");
                        nuller.src = "irsc/delIcon.png";
                        nuller.reg = list[i];
                        nuller.onclick = function()
                        {
                                
                                var info = this.reg;
                                
                                if(info.STATE == "0")
                                {
                                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta factura ya se encuentra anulada", 300);
                                        return;
                                }
                                
                                var param = info;
                                confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Desea anular la factura actual? Las ordenes facturadas seran devueltas a estado 'Por facturar'.", nullifyRec, 300, param);
                        }
                        
                        var redater = document.createElement("img");
                        redater.src = "irsc/addIcon.png";
                        redater.reg = list[i];
                        redater.onclick = function()
                        {
                                
                                var info = this.reg;
                                redateRec(info);
                                
                        }
                        
                        var icons = [download, nuller];
                        var x = cellOptionsCreator('', icons)

                        var cells = [a,c,d,e,f,g,h, x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
         // ORDERS TABLE TECH
        if(tableId == "ordersTableT")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Cliente', list[i].PARENTNAME)
                        var b = cellCreator('Sucursal', list[i].SUCUNAME)
                        
                        var maquiList = JSON.parse(list[i].MAQUIS);
                        var maquis = "";
                        for(var x=0; x<maquiList.length; x++)
                        {
                                var label = maquiList[x];
                                
                                if(label.split("-")[1] == "Locativas")
                                {
                                        label = "Locativas";
                                }
                                
                                if(x == maquiList.length-1)
                                {
                                        maquis = maquis+label;
                                }
                                else
                                {
                                        maquis = maquis+label+", "; 
                                }
                        }
                        var c = cellCreator('Equipos', maquis)
                        
                        var num = list[i].CCODE;

                        
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        var prior = "<img class='loneIcon' src='irsc/"+list[i].PRIORITY+".png'/>";
                        
                        
                        var n = cellCreator('OTT', num);
                        var d = cellCreator('', prior);
                        var e = cellCreator('Fecha solicitud', list[i].DATE);
                        var f = cellCreator('Detalle', list[i].DETAIL);
                        
                        if(list[i].STATE == "1"){var state = "Nueva"}
                        if(list[i].STATE == "2"){var state = "Proceso"}
                        if(list[i].STATE == "3"){var state = "Revisión"}
                        if(list[i].STATE == "4"){var state = "Por facturar"}
                        if(list[i].STATE == "5"){var state = "Facturada"}
                        
                        var g = cellCreator('Estado', state);
                        var h = cellCreator('Autor', list[i].AUTOR);
                        
                        
                        
                        var detail = document.createElement("img");
                        detail.src = "irsc/openIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Detalle');
                        detail.setAttribute('alt', 'Detalle');
                        detail.onclick = function()
                        {
                                var info = this.reg;
                                
                                if(info.TECHCODE == null)
                                {
                                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No se ha asignado un tecnico a la orden!", 300);
                                        return;
                                }
                                
                                ifLoad('iforderMain');
                                orderStarter(info.CODE)
                        }

                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }
                        

                        if(list[i].STATE == "4")
                        {
                                var icons = [edit, asign, detail, del, selector];
                        }
                        else
                        {
                                
                        }
                        
                        var icons = [detail];
                        
                        
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c, n, d,e,f,g,h,x];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        // ORDERS TABLE CLIENT
        if(tableId == "ordersTableCL")
        {
                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Cliente', list[i].PARENTNAME)
                        var b = cellCreator('Sucursal', list[i].SUCUNAME)
                        
                        var maquiList = JSON.parse(list[i].MAQUIS);
                        var maquis = "";
                        for(var x=0; x<maquiList.length; x++)
                        {
                                var label = maquiList[x];
                                
                                if(label.split("-")[1] == "Locativas")
                                {
                                        label = "Locativas";
                                }
                                
                                if(x == maquiList.length-1)
                                {
                                        maquis = maquis+label;
                                }
                                else
                                {
                                        maquis = maquis+label+", "; 
                                }
                        }
                        var c = cellCreator('Equipos', maquis)
                        
                        var num = list[i].CCODE;

                        
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        
                        var prior = "<img class='loneIcon' src='irsc/"+list[i].PRIORITY+".png'/>";
                        
                        
                        var n = cellCreator('OTT', num);
                        
                        
                        if(list[i].ICODE != null && list[i].ICODE != "")
                        {
                                var m = cellCreator('Orden-Cliente', list[i].ICODE);
                        }
                        else
                        {
                                var m = cellCreator('Orden-Cliente', "-");
                        }
                        
                        
                        
                        var d = cellCreator('', prior);
                        var e = cellCreator('Fecha solicitud', list[i].DATE);
                        var f = cellCreator('Detalle', list[i].DETAIL);
                        
                        if(list[i].STATE == "1"){var state = "Nueva"}
                        if(list[i].STATE == "2"){var state = "Proceso"}
                        if(list[i].STATE == "3"){var state = "Revisión"}
                        if(list[i].STATE == "4"){var state = "Por facturar"}
                        if(list[i].STATE == "5"){var state = "Facturada"}
                        
                        var g = cellCreator('Estado', state);
                        var h = cellCreator('Autor', list[i].AUTOR);
                        
                        
                        
                        var detail = document.createElement("img");
                        detail.src = "irsc/openIcon.png";
                        detail.reg = list[i];
                        detail.setAttribute('title', 'Detalle');
                        detail.setAttribute('alt', 'Detalle');
                        detail.onclick = function()
                        {
                                var info = this.reg;
                                
                                if(info.TECHCODE == null)
                                {
                                        alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No se ha asignado un tecnico a la orden!", 300);
                                        return;
                                }
                                
                                ifLoad('iforderMain');
                                orderStarter(info.CODE)
                        }

                        var del = document.createElement("img");
                        del.src = "irsc/delIcon.png";
                        del.reg = list[i];
                        del.setAttribute('title', 'Eliminar');
                        del.setAttribute('alt', 'Eliminar');
                        del.onclick = function()
                        {
                                var tableId = this.parentNode.parentNode.parentNode.id;
                                var param = [tableId, this.reg.CODE];
                                
                                confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
                        }
                        

                        if(list[i].STATE == "4")
                        {
                                var icons = [edit, asign, detail, del, selector];
                        }
                        else
                        {
                                
                        }
                        
                        var icons = [detail];
                        
                        
                        var x = cellOptionsCreator('', icons)
                        var cells = [b,c, n, m, d,e,f,g];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                }
        }
        
        
        resSet();
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
function nullifyRec(info)
{
        
        var data = {};
        data.nullnum = info.NUM;
        data.nullres = info.RESOLUTION;
        data.picks = info.ORDERS.split(", ");
        data.date = info.DATE;
        data.diedate = info.DIEDATE;
        data.retCheck = info.RETCHECK;
        data.parent = info.PARENTCODE;

        sendAjax("users","nullifyReceipt",data,function(response)
        {
                if(response.status)
                {
                        hide_pop_form();
                        alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha anulado la factura.",300);
                        recGet();
                }
        });
}
function redateRec(info)
{
        
        var data = {};
        data.nullnum = info.NUM;
        data.nullres = info.RESOLUTION;
        data.picks = info.ORDERS.split(", ");
        data.date = info.DATE;
        data.diedate = info.DIEDATE;
        data.retCheck = info.RETCHECK;
        data.parent = info.PARENTCODE;
        
        console.log(data)

        sendAjax("users","redateReceipt",data,function(response)
        {
                if(response.status)
                {
                        hide_pop_form();
                        alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha anulado la factura.",300);
                        recGet();
                }
        });
}
function downloadReport(url) 
{

        document.getElementById('downframe').setAttribute("href", url);
        document.getElementById('downframe').click();
};
function showMaquiStory(code)
{
        var info = {};
        info.code = code;
        
        sendAjax("users","getMaquiStory",info,function(response)
        {
                
                var story = response.message;
                
                if(story.length == 0)
                {
                        alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Este equipo no tiene historial de actividades",300);
                        return;
                }
                
                var title = "Historial "+story[0].MAQUINAME;

                tableCreator("maquiStoryTable",story);
                formBox("maquiStoryBox",title,1200);
                
        });
}
function setTotals()
{

        var subtotal = parseInt(actisTotal+partsTotal+othersTotal);
        var iva = parseInt((subtotal*19)/100);
        
        if(aud.TYPE != "C")
        {
                document.getElementById("oSubtotal").innerHTML = addCommas(subtotal);
                document.getElementById("oIVA").innerHTML = addCommas(iva);
                document.getElementById("oTotal").innerHTML = addCommas(subtotal*1.19);
        }
        else
        {
                document.getElementById("oSubtotal").innerHTML = "-";
                document.getElementById("oIVA").innerHTML = "-";
                document.getElementById("oTotal").innerHTML = "-";
        }
        
}
function asignTechBox(ocode, num)
{
	var container = document.getElementById("asignTechBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
        
	var icon = document.createElement("img");
	icon.src = "irsc/techIconB.png";
	icon.className = "";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
        
	var inputBox = document.createElement("select");
	inputBox.id = "techBox";
	inputBox.className = "recMailBox";
        
        
	container.appendChild(icon);
	container.appendChild(inputBox);

	var picker = document.getElementById("techBox");
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona un responsable";
	picker.appendChild(option);
	
	for(var i = 0; i<actualTechList.length; i++)
	{
		var option = document.createElement("option");
		option.value = actualTechList[i].CODE+">"+actualTechList[i].RESPNAME+">"+actualTechList[i].TYPE;
		
		var type = "";
		
		if(actualTechList[i].TYPE == "T")
		{
			type = "Técnico";
		}
		else if(actualTechList[i].TYPE == "CO")
		{
			type = "Coordinador";
		}
		else if(actualTechList[i].TYPE == "JZ")
		{
			type = "Jefe de Zona";
		}
		
		option.innerHTML = type+" > "+actualTechList[i].RESPNAME+" > "+actualTechList[i].LOCATION+" > "+actualTechList[i].MASTERY;

		picker.appendChild(option);
	}
	
	
	if(actualTechVal != ""){picker.value = actualTechVal}
	else{picker.value = ""}
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["send"];
	send.ocode = ocode;
	send.onclick = function()
	{
		var info = {};
		var tmpVal = document.getElementById("techBox").value;
		if(tmpVal == "")
		{
			alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un responsable de orden", 300);
			return;
		}
		
		info.code = tmpVal.split(">")[0];
		info.name = tmpVal.split(">")[1];
		info.resptype = tmpVal.split(">")[2];
		info.ocode = this.ocode;
		
		sendAjax("users","setTechO",info,function(response)
		{
			ordeGet();
			hide_pop_form();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};

	container.appendChild(send);
	container.appendChild(cancel);
        
	if(num.length == 1){num = "000"+num;}
	else if(num.length == 2){num = "00"+num;}
	else if(num.length == 3){num = "0"+num;}
	else{num = num;}

	formBox("asignTechBox","Asignar responsable a orden "+num,500);
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
function deleteRecord(param)
{
        var info = {};
        info.autor = aud.RESPNAME;
        info.optype = ltt3;
        info.date = getNow();
        
        if(param[0] == "clientesTable")
        {
                info.table = "users";
                info.mail = param[1];
                info.delType = "client";
                
                info.type = "C";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_clients_targets, "a-clients");
                        clientsGet();
                });
                
        }
        if(param[0] == "sucusTable")
        {
                info.table = "sucus";
                info.code = param[1];
                info.delType = "sucu";
                
                info.type = "S";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_sucu_targets, "a-sucu");
                        sucuGet();
                });
                
        }
        if(param[0] == "maquisTable")
        {
                info.table = "maquis";
                info.plate = param[1];
                info.delType = "maqui";
                
                info.type = "M";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_maqui_targets, "a-maqui");
                        maquiGet();
                });
                
        }
        if(param[0] == "techisTable")
        {
                info.table = "techis";
                info.mail = param[1];
                info.delType = "techi";
                
                info.type = param[2];
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_techi_targets, "a-techi");
                        techisGet();
                });
                
        }
        if(param[0] == "actisTable")
        {
                info.table = "actis";
                info.code = param[1];
                info.delType = "actis";
                
                info.type = "AC";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_acti_targets, "a-acti");
                        actisGet();
                });
                
        }
        if(param[0] == "inveTable")
        {
                info.table = "inve";
                info.code = param[1];
                info.delType = "inve";
                
                info.type = "I";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_inve_targets, "a-inve");
                        inveGet();
                });
                
        }
         if(param[0] == "ordersTable")
        {
                info.table = "orders";
                info.code = param[1];
                info.delType = "order";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        clearFields(a_orde_targets, "a-orde");
                        ordeGet();
                });
                
        }
        if(param[0] == "oActsTable")
        {
                info.table = "oactis";
                info.code = param[1];
                info.delType = "oacti";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshoActs()
                });
                
        }
        if(param[0] == "oPartsTable")
        {
                info.table = "oparts";
                info.code = param[1];
                info.delType = "opart";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshoParts()
                });
                
        }
        if(param[0] == "oOthersTable")
        {
                info.table = "others";
                info.code = param[1];
                info.delType = "oother";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshoOther();
                });
                
        }
		if(param[0] == "legTable")
        {
                info.table = "others";
                info.code = param[1];
                info.delType = "oother";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        getLeg();
                });
                
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
                        
                        info.optype = ltt5;
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
function pssRec()
{
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var recMailType = document.createElement("select");
	recMailType.id = "recMailType";
	recMailType.type = "select";
	recMailType.className = "recMailBox";
        
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Tipo de Usuario";
	recMailType.appendChild(option);

	var option = document.createElement("option");
	option.value = "A";
	option.innerHTML = "Administrador";
	recMailType.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "CO";
	option.innerHTML = "Coordinador";
	recMailType.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "JZ";
	option.innerHTML = "Jefe de Zona";
	recMailType.appendChild(option);
        
	// var option = document.createElement("option");
	// option.value = "C";
	// option.innerHTML = "Empresa Cliente";
	// recMailType.appendChild(option);
        
	// var option = document.createElement("option");
	// option.value = "T";
	// option.innerHTML = "Técnico";
	// recMailType.appendChild(option);
        
	var recMailBox = document.createElement("input");
	recMailBox.id = "recMailBox";
	recMailBox.type = "text";
	recMailBox.className = "recMailBox";
	recMailBox.placeholder = language["adminLoginMail"];
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButtonPop";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
	{
		var info = {};
		info.mail = $("#recMailBox").val();
		info.type = $("#recMailType").val();
		info.lang = lang;
		
		if(info.type == "")
		{
			alertBox(language["alert"],"<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar un tipo de usuario.",300);
			return;
		}
					
		if(info.mail == "")
		{
			hide_pop_form();
			alertBox(language["alert"], language["sys005"],300);
			return;
		}
		
		console.log(info)
		
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
	recMailCancel.className = "dualButtonPop";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	// container.appendChild(icon);
	container.appendChild(recMailType);
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
               setTimeout(function(){window.location.replace('http://incocrea.com/servintegral/');}, 2500)
               

        });
        
}
function getNow(extra)
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
        var actualCurrency = "COP";
	
	
	
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
		 var info = {};
		 info.class = obj;
		 info.method = method;
		 info.data = data;

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
function calcIVA(field)
{
	
	var val = field.value;
	
	if(val != "")
	{
		if(isNaN(val)){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Este valor debe ser numérico.", 300); field.value = "";  return}
		
		val = parseInt(val);
		var iva = round(val*0.19);
		document.getElementById("legItemTax").value = iva;
		document.getElementById("legItemTotal").value = val+iva;
		
		calcrts();
	}
}
function calcIVA2(field)
{
	
	var val = field.value;
	
	console.log(val)
	if(val != "")
	{
		if(isNaN(val)){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Este valor debe ser numérico.", 300); field.value = "";  return}
		val = parseInt(val);
		document.getElementById("legItemTotal").value = parseFloat(document.getElementById("legItemBase").value) + val;
		
		calcrts();

	}
}
function round(num, decimales = 0) 
{
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}
function calcrts()
{
	
	var total = document.getElementById("legItemTotal").value;
	var rtfte = document.getElementById("legItemRetFont").value;
	var rtica = document.getElementById("legItemRetICA").value;
	if(total == ""){total = 0;}
	if(rtfte == ""){rtfte = 0;}
	if(rtica == ""){rtica = 0;}
	
	document.getElementById("legItemPayment").value = parseInt(total - rtfte - rtica);
	
		
	
}
function legExportBox(closeV)
{
	closeVal = closeV;
	
	
	if(actualLegState == "1")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta legalización ya esta cerrada, no podrá realizar exportarla o realizar cambios en ella.", 300); return
	}
	if(actualLegState == "1")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta legalización ya esta cerrada, no podrá realizar exportarla o realizar cambios en ella.", 300); return
	}

	
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
		
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var input1 = document.createElement("input");
	input1.id = "legValue";
	input1.type = "text";
	input1.className = "recMailBox";
	input1.placeholder = "Valor Anticipo";
	
	var input2 = document.createElement("input");
	input2.id = "legCenter";
	input2.type = "text";
	input2.className = "recMailBox";
	input2.placeholder = "Centro de costos";
	
	var input3 = document.createElement("input");
	input3.id = "legMainConcept";
	input3.type = "text";
	input3.className = "recMailBox";
	input3.placeholder = "Concepto anticipo";
	
	var input4 = document.createElement("input");
	input4.id = "legExportDate";
	input4.type = "text";
	input4.className = "recMailBox";
	input4.placeholder = "Fecha Legalización";
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButtonPop";
	recMailSend.innerHTML = language["send"];
	recMailSend.onclick = function()
	{
		exportD = {};
		
		exportD.legValue = document.getElementById("legValue").value;
		exportD.legCenter = document.getElementById("legCenter").value;
		exportD.legMainConcept = document.getElementById("legMainConcept").value;
		exportD.legMainDate = getNow().split(" ")[0];
				
		if(exportD.legValue == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el monto del anticipo a legalizar", 300); return}
		if(exportD.legCenter == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el centro de costos", 300); return}
		if(exportD.legMainConcept == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el concepto de la legalización", 300); return}
		
		
		if(isNaN(exportD.legValue)){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>El valor del anticipo debe ser numérico.", 300); return}
		
		legExport();
	}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButtonPop";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(input1);
	container.appendChild(input2);
	container.appendChild(input3);
	// container.appendChild(input4);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);
	
	jQuery('#legExportDate').datetimepicker({timepicker:false,format:'Y-m-d',}).on('change', function(){$('.xdsoft_datetimepicker').hide(); var str = $(this).val(); str = str.split(".");});

	formBox("pssRecBox","Exportar legalización",300);
}
function legExport()
{
	var info = infoHarvest(legTargets);
	info.ucode = aud.CODE;
	info.uname = aud.RESPNAME;
	info.lang = "es_co";
	info.rtype = "leg";
	info.uid = aud.NIT;
	info.closeVal = closeVal;
	
	if(info.legCode == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir código de legalización", 300); return}

	info = Object.assign({}, info, exportD);
	
	sendAjax("users","exportCVS",info,function(response)
	{
		var ans = response.message;
		var url = "legs/"+encry(ans)+".xls";
		downloadReport(url);
		
		hide_pop_form();
		getLeg();
	});
	
}
function legCreate()
{
	var info = infoHarvest(legTargets);
	info.ucode = aud.CODE;
	info.uname = aud.RESPNAME;
	
	if(actualLegState == "1")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Esta legalización ya esta cerrada, no podrá realizar cambios en ella.", 300); return
	}
	
   if(info.legCode == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir código de legalización", 300); return}
	if(info.legItemParent == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un cliente", 300);return}
	if(info.legItemOrder == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una orden", 300);return}
	if(info.legItemDate == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una fecha", 300);return}
	if(info.legItemNumber == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el número de factura o documento", 300);return}
	if(info.legItemConcept == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar el concepto", 300);return}
	if(info.legItemCname == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir la razón social", 300);return}
	if(info.legItemId == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir el id de la factura", 300);return}
	if(info.legItemBase == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir la base de la factura", 300);return}
	
	if(info.legItemRetFont == ""){info.legItemRetFont = 0;}
	if(info.legItemRetICA == ""){info.legItemRetICA = 0;}
	

	info.legItemConcept = $("#legItemConcept option:selected").text();
	
	if(document.getElementById("legItemDetail").value != "")
	{
		info.legItemConcept += " / "+document.getElementById("legItemDetail").value;
	}
	
	info.legItemParentName = $("#legItemParent option:selected").text();
	info.legItemOrderNumber = $("#legItemOrder option:selected").text().split(" - ")[0];
	
	console.log(info)
	
	// return
	
	sendAjax("users","saveoOtherLeg",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("legTable", ans);
		
	});
	
}
function getLeg()
{
	var code = document.getElementById("legCode").value;
	
	var info = {};
	info.code = code;
	info.autor = aud.CODE;
	
	sendAjax("users","getLeg",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		tableCreator("legTable", ans);
		
		
		if(ans.length > 0)
		{
			actualLegState = ans[0].LEGSTATE;
		}
		else
		{
			actualLegState = '0';
		}

		
	});
	
}
function getUserLegs()
{
	if(aud.TYPE != "A")
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo el Administrador puede restaurar legalizaciones.", 300);return
	}
	
	var info = {};
	
	sendAjax("users","getUserLegs",info,function(response)
	{
		var ans = response.message;
		console.log(ans);

		legRestoreBox(ans)
		
	});
}
function legRestoreBox(list)
{
		
	var container = document.getElementById("pssRecBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
		
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var input1 = document.createElement("select");
	input1.id = "legAutor";
	input1.type = "select";
	input1.className = "recMailBox";
	input1.legList = list.legs;
	input1.onchange = function ()
	{
		setLegList(this.value, this.legList);
	}
	
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona usuario";
	
	input1.appendChild(option);
	
	var ulist = list.users;
	
	for(var i=0; i<ulist.length; i++)
	{
		var item = ulist[i];
		
		var type = "";
		
		if(item.TYPE == "CO")
		{
			type = "Coordinador";
		}
		else if(item.TYPE == "JZ")
		{
			type = "Jefe de Zona";
		}
		else
		{
			type = "Super Administrador";
		}
		
		var option = document.createElement("option");
		option.value = item.CODE;
		option.innerHTML = item.CNAME+" - "+type;
		
		input1.appendChild(option);
	}
	
	
	var input2 = document.createElement("select");
	input2.id = "restoreLegsPicker";
	input2.type = "select";
	input2.className = "recMailBox";
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = "Restaurar";
	send.onclick = function()
	{
		var info = {};
		
		info.legAutor = document.getElementById("legAutor").value;
		info.legCode = document.getElementById("restoreLegsPicker").value;
		
				
		if(info.legAutor == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar un usuario", 300); return}
		if(info.legCode == ""){alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Seleccionar una legalización", 300); return}
		
		console.log(info)
		
		sendAjax("users","restoreLeg",info,function(response)
		{
			var ans = response.message;
			console.log(ans);
			hide_pop_form();
			alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha restaurado la legalización.", 300);
			// tableCreator("legTable", ans);
			// actualLegState = "0";
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(input1);
	container.appendChild(input2);
	container.appendChild(send);
	container.appendChild(cancel);
	
	jQuery('#legExportDate').datetimepicker({timepicker:false,format:'Y-m-d',}).on('change', function(){$('.xdsoft_datetimepicker').hide(); var str = $(this).val(); str = str.split(".");});

	formBox("pssRecBox","Restaurar legalización",300);
}
function setLegList(code, list)
{
	
	var picker = document.getElementById("restoreLegsPicker");
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona Legalización";
	picker.appendChild(option);
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.LEGAUTOR == code)
		{
			var state = "";
			if(item.LEGSTATE == "0")
			{
				state = "Abierta";
			}
			else
			{
				state = "Cerrada";
			}
			
			var option = document.createElement("option");
			option.value = item.LEGCODE;
			option.innerHTML = item.LEGCODE+" - "+state;
			
			picker.appendChild(option);
		}

	}
}
function downloadCvsOrder(info)
{
	info.lang = "es_co";

	sendAjax("users","exportCVS",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		// return
		
		var url = "reports/"+encry(ans)+".csv";
		console.log(url);
		downloadReport(url) 
		
		
	 });
}


// $.rand = function(arg) {if ($.isArray(arg)){return arg[$.rand(arg.length)];}else if (typeof arg === "number"){return Math.floor(Math.random() * arg);}else{return 4;}};
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



deptosCol = {"1":"DISTRITO CAPITAL","2":"AMAZONAS","3":"ANTIOQUIA","4":"ARAUCA","5":"ATLANTICO","6":"BOLIVAR","7":"BOYACA","8":"CALDAS","9":"CAQUETA","10":"CASANARE","11":"CAUCA","12":"CESAR","13":"CHOCO","14":"CORDOBA","15":"CUNDINAMARCA","16":"GUAINIA","17":"GUAJIRA","18":"GUAVIARE","19":"HUILA","20":"MAGDALENA","21":"META","22":"N SANTANDER","23":"NARINO","24":"PUTUMAYO","25":"QUINDIO","26":"RISARALDA","27":"SAN ANDRES","28":"SANTANDER","29":"SUCRE","30":"TOLIMA","31":"VALLE DEL CAUCA","32":"VAUPES","33":"VICHADA"};

mpiosCol = {"1":{"1":"BOGOTA"},"2":{"1":"LETICIA","2":"EL ENCANTO","3":"LA CHORRERA","4":"LA PEDRERA","5":"LA VICTORIA","6":"MIRITI-PARANA","7":"PUERTO ALEGRIA","8":"PUERTO ARICA","9":"PUERTO NARINO","10":"SANTANDER","11":"TARAPACA"},"3":{"1":"ABEJORRAL","2":"ABRIAQUI","3":"ALEJANDRIA","4":"AMAGA","5":"AMALFI","6":"ANDES","7":"ANGELOPOLIS","8":"ANGOSTURA","9":"ANORI","10":"ANZA","11":"APARTADO","12":"ARBOLETES","13":"ARGELIA","14":"ARMENIA","15":"BARBOSA","16":"BELLO","17":"BELMIRA","18":"BETANIA","19":"BETULIA","20":"BRICENO","21":"BURITICA","22":"CACERES","23":"CAICEDO","24":"CALDAS","25":"CAMPAMENTO","26":"CANASGORDAS","27":"CARACOLI","28":"CARAMANTA","29":"CAREPA","30":"CARMEN DE VIBORAL","31":"CAROLINA","32":"CAUCASIA","33":"CHIGORODO","34":"CISNEROS","35":"CIUDAD BOLIVAR","36":"COCORNA","37":"CONCEPCION","38":"CONCORDIA","39":"COPACABANA","40":"DABEIBA","41":"DON MATIAS","42":"EBEJICO","43":"EL BAGRE","44":"ENTRERRIOS","45":"ENVIGADO","46":"FREDONIA","47":"FRONTINO","48":"GIRALDO","49":"GIRARDOTA","50":"GOMEZ PLATA","51":"GRANADA","52":"GUADALUPE","53":"GUARNE","54":"GUATAPE","55":"HELICONIA","56":"HISPANIA","57":"ITAG&Uuml;I","58":"ITUANGO","59":"JARDIN","60":"JERICO","61":"LA CEJA","62":"LA ESTRELLA","63":"LA PINTADA","64":"LA UNION","65":"LIBORINA","66":"MACEO","67":"MARINILLA","68":"MEDELLIN","69":"MONTEBELLO","70":"MURINDO","71":"MUTATA","72":"NARINO","73":"NECHI","74":"NECOCLI","75":"OLAYA","76":"PENOL","77":"PEQUE","78":"PUEBLORRICO","79":"PUERTO BERRIO","80":"PUERTO NARE","81":"PUERTO TRIUNFO","82":"REMEDIOS","83":"RETIRO","84":"RIONEGRO","85":"SABANALARGA","86":"SABANETA","87":"SALGAR","88":"SAN ANDRES","89":"SAN CARLOS","90":"SAN FRANCISCO","91":"SAN JERONIMO","92":"SAN JOSE DE LA MONTANA","93":"SAN JUAN DE URABA","94":"SAN LUIS","95":"SAN PEDRO","96":"SAN PEDRO DE URABA","97":"SAN RAFAEL","98":"SAN ROQUE","99":"SAN VICENTE","100":"SANTA BARBARA","101":"SANTA FE DE ANTIOQUIA","102":"SANTA ROSA DE OSOS","103":"SANTO DOMINGO","104":"SANTUARIO","105":"SEGOVIA","106":"SONSON","107":"SOPETRAN","108":"TAMESIS","109":"TARAZA","110":"TARSO","111":"TITIRIBI","112":"TOLEDO","113":"TURBO","114":"URAMITA","115":"URRAO","116":"VALDIVIA","117":"VALPARAISO","118":"VEGACHI","119":"VENECIA","120":"VIGIA DEL FUERTE","121":"YALI","122":"YARUMAL","123":"YOLOMBO","124":"YONDO","125":"ZARAGOZA"},"4":{"1":"ARAUCA","2":"ARAUQUITA","3":"CRAVO NORTE","4":"FORTUL","5":"PUERTO RONDON","6":"SARAVENA","7":"TAME"},"5":{"1":"BARANOA","2":"BARRANQUILLA","3":"CAMPO DE LA CRUZ","4":"CANDELARIA","5":"GALAPA","6":"JUAN DE ACOSTA","7":"LURUACO","8":"MALAMBO","9":"MANATI","10":"PALMAR DE VARELA","11":"PIOJO","12":"POLONUEVO","13":"PONEDERA","14":"PUERTO COLOMBIA","15":"REPELON","16":"SABANAGRANDE","17":"SABANALARGA","18":"SANTA LUCIA","19":"SANTO TOMAS","20":"SOLEDAD","21":"SUAN","22":"TUBARA","23":"USIACURI"},"6":{"1":"ACHI","2":"ALTOS DEL ROSARIO","3":"ARENAL","4":"ARJONA","5":"ARROYOHONDO","6":"BARRANCO DE LOBA","7":"CALAMAR","8":"CANTAGALLO","9":"CARTAGENA DE INDIAS","10":"CICUCO","11":"CLEMENCIA","12":"CORDOBA","13":"EL CARMEN DE BOLIVAR","14":"EL GUAMO","15":"EL PENON","16":"HATILLO DE LOBA","17":"MAGANGUE","18":"MAHATES","19":"MARGARITA","20":"MARIA LA BAJA","21":"MOMPOS","22":"MONTECRISTO","23":"MORALES","24":"PINILLOS","25":"REGIDOR","26":"RIOVIEJO","27":"SAN CRISTOBAL","28":"SAN ESTANISLAO","29":"SAN FERNANDO","30":"SAN JACINTO","31":"SAN JACINTO DEL CAUCA","32":"SAN JUAN NEPOMUCENO","33":"SAN MARTIN DE LOBA","34":"SAN PABLO","35":"SANTA CATALINA","36":"SANTA ROSA","37":"SANTA ROSA DEL SUR","38":"SIMITI","39":"SOPLAVIENTO","40":"TALAIGUA NUEVO","41":"TIQUISIO","42":"TURBACO","43":"TURBANA","44":"VILLANUEVA","45":"ZAMBRANO"},"7":{"1":"ALMEIDA","2":"AQUITANIA","3":"ARCABUCO","4":"BELEN","5":"BERBEO","6":"BETEITIVA","7":"BOAVITA","8":"BOYACA","9":"BRICENO","10":"BUENAVISTA","11":"BUSBANZA","12":"CALDAS","13":"CAMPOHERMOSO","14":"CERINZA","15":"CHINAVITA","16":"CHIQUINQUIRA","17":"CHIQUIZA","18":"CHISCAS","19":"CHITA","20":"CHITARAQUE","21":"CHIVATA","22":"CHIVOR","23":"CIENEGA","24":"COMBITA","25":"COPER","26":"CORRALES","27":"COVARACHIA","28":"CUBARA","29":"CUCAITA","30":"CUITIVA","31":"DUITAMA","32":"EL COCUY","33":"EL ESPINO","34":"FIRAVITOBA","35":"FLORESTA","36":"GACHANTIVA","37":"GAMEZA","38":"GARAGOA","39":"GUACAMAYAS","40":"GUATEQUE","41":"GUAYATA","42":"GUICAN","43":"IZA","44":"JENESANO","45":"JERICO","46":"LA CAPILLA","47":"LA UVITA","48":"LA VICTORIA","49":"LABRANZAGRANDE","50":"MACANAL","51":"MARIPI","52":"MIRAFLORES","53":"MONGUA","54":"MONGUI","55":"MONIQUIRA","56":"MOTAVITA","57":"MUZO","58":"NOBSA","59":"NUEVO COLON","60":"OICATA","61":"OTANCHE","62":"PACHAVITA","63":"PAEZ","64":"PAIPA","65":"PAJARITO","66":"PANQUEBA","67":"PAUNA","68":"PAYA","69":"PAZ DE RIO","70":"PESCA","71":"PISVA","72":"PUERTO BOYACA","73":"QUIPAMA","74":"RAMIRIQUI","75":"RAQUIRA","76":"RONDON","77":"SABOYA","78":"SACHICA","79":"SAMACA","80":"SAN EDUARDO","81":"SAN JOSEDE PARE","82":"SAN LUIS DE GACENO","83":"SAN MATEO","84":"SAN MIGUEL DE SEMA","85":"SAN PABLO DE BORBUR","86":"SANTA MARIA","87":"SANTA ROSA DE VITERBO","88":"SANTA SOFIA","89":"SANTANA","90":"SATIVANORTE","91":"SATIVASUR","92":"SIACHOQUE","93":"SOATA","94":"SOCHA","95":"SOCOTA","96":"SOGAMOSO","97":"SOMONDOCO","98":"SORA","99":"SORACA","100":"SOTAQUIRA","101":"SUSACON","102":"SUTAMARCHAN","103":"SUTATENZA","104":"TASCO","105":"TENZA","106":"TIBANA","107":"TIBASOSA","108":"TINJACA","109":"TIPACOQUE","110":"TOCA","111":"TOG&Uuml;I","112":"TOPAGA","113":"TOTA","114":"TUNJA","115":"TUNUNGUA","116":"TURMEQUE","117":"TUTA","118":"TUTAZA","119":"UMBITA","120":"VENTAQUEMADA","121":"VILLA DE LEIVA","122":"VIRACACHA","123":"ZETAQUIRA"},"8":{"1":"AGUADAS","2":"ANSERMA","3":"ARANZAZU","4":"BELALCAZAR","5":"CHINCHINA","6":"FILADELFIA","7":"LA DORADA","8":"LA MERCED","9":"MANIZALES","10":"MANZANARES","11":"MARMATO","12":"MARQUETALIA","13":"MARULANDA","14":"NEIRA","15":"NORCASIA","16":"PACORA","17":"PALESTINA","18":"PENSILVANIA","19":"RIOSUCIO","20":"RISARALDA","21":"SALAMINA","22":"SAMANA","23":"SAN JOSE","24":"SUPIA","25":"VICTORIA","26":"VILLAMARIA","27":"VITERBO"},"9":{"1":"ALBANIA","2":"BELEN DE LOS ANDAQUIES","3":"CARTAGENA DEL CHAIRA","4":"CURILLO","5":"EL DONCELLO","6":"EL PAUJIL","7":"FLORENCIA","8":"MILAN","9":"MONTANITA","10":"MORELIA","11":"PUERTO RICO","12":"SAN JOSE DEL FRAGUA","13":"SAN VICENTE DEL CAGUAN","14":"SOLANO","15":"SOLITA","16":"VALPARAISO"},"10":{"1":"AGUAZUL","2":"CHAMEZA","3":"HATO COROZAL","4":"LA SALINA","5":"MANI","6":"MONTERREY","7":"NUNCHIA","8":"OROCUE","9":"PAZ DE ARIPORO","10":"PORE","11":"RECETOR","12":"SABANALARGA","13":"SACAMA","14":"SAN LUIS DE PALENQUE","15":"TAMARA","16":"TAURAMENA","17":"TRINIDAD","18":"VILLANUEVA","19":"YOPAL"},"11":{"1":"ALMAGUER","2":"ARGELIA","3":"BALBOA","4":"BOLIVAR","5":"BUENOS AIRES","6":"CAJIBIO","7":"CALDONO","8":"CALOTO","9":"CORINTO","10":"EL TAMBO","11":"FLORENCIA","12":"GUAPI","13":"INZA","14":"JAMBALO","15":"LA SIERRA","16":"LA VEGA","17":"LOPEZ","18":"MERCADERES","19":"MIRANDA","20":"MORALES","21":"PADILLA","22":"PAEZ","23":"PATIA","24":"PIAMONTE","25":"PIENDAMO","26":"POPAYAN","27":"PUERTO TEJADA","28":"PURACE","29":"ROSAS","30":"SAN SEBASTIAN","31":"SANTA ROSA","32":"SANTANDER DE QUILICHAO","33":"SILVIA","34":"SOTARA","35":"SUAREZ","36":"SUCRE","37":"TIMBIO","38":"TIMBIQUI","39":"TORIBIO","40":"TOTORO","41":"VILLA RICA"},"12":{"1":"AGUACHICA","2":"AGUSTIN CODAZZI","3":"ASTREA","4":"BECERRIL","5":"BOSCONIA","6":"CHIMI HAGUA","7":"CHIRIGUANA","8":"CURUMANI","9":"EL COPEY","10":"EL PASO","11":"GAMARRA","12":"GONZALEZ","13":"LA GLORIA","14":"LA JAGUA DE IBIRICO","15":"LA PAZ","16":"MANAURE BALCON DEL CESAR","17":"PAILITAS","18":"PELAYA","19":"PUEBLO BELLO","20":"RIO DE ORO","21":"SAN ALBERTO","22":"SAN DIEGO","23":"SAN MARTIN","24":"TAMALAMEQUE","25":"VALLEDUPAR"},"13":{"1":"ACANDI","2":"ALTO BAUDO","3":"ATRATO","4":"BAGADO","5":"BAHIA SOLANO","6":"BAJO BAUDO","7":"BOJAYA","8":"CARMEN DEL DARIEN","9":"CERTEGUI","10":"CONDOTO","11":"EL CANTON DEL SAN PABLO","12":"EL CARMEN","13":"EL LITORAL DEL SAN JUAN","14":"ITSMINA","15":"JURADO","16":"LLORO","17":"MEDIO ATRATO","18":"MEDIO BAUDO","19":"MEDIO SAN JUAN","20":"NOVITA","21":"NUQUI","22":"QUIBDO","23":"RIO IRO","24":"RIO QUITO","25":"RIOSUCIO","26":"SAN JOSE DEL PALMAR","27":"SIPI","28":"TADO","29":"UNGUIA","30":"UNION PANAMERICANA"},"14":{"1":"AYAPEL","2":"BUENAVISTA","3":"CANALETE","4":"CERETE","5":"CHIMA","6":"CHINU","7":"CIENAGA DE ORO","8":"COTORRA","9":"LA APARTADA","10":"LORICA","11":"LOS CORDOBAS","12":"MOMIL","13":"MONITOS","14":"MONTELIBANO","15":"MONTERIA","16":"PLANETA RICA","17":"PUEBLO NUEVO","18":"PUERTO ESCONDIDO","19":"PUERTO LIBERTADOR","20":"PURISIMA","21":"SAHAGUN","22":"SAN ANDRES DE SOTAVENTO","23":"SAN ANTERO","24":"SAN BERNARDO DEL VIENTO","25":"SAN CARLOS","26":"SAN PELAYO","27":"TIERRALTA","28":"VALENCIA"},"15":{"1":"AGUA DE DIOS","2":"ALBAN","3":"ANAPOIMA","4":"ANOLAIMA","5":"APULO","6":"ARBELAEZ","7":"BELTRAN","8":"BITUIMA","10":"BOJACA","11":"CABRERA","12":"CACHIPAY","13":"CAJICA","14":"CAPARRAPI","15":"CAQUEZA","16":"CARMEN DE CARUPA","17":"CHAGUANI","18":"CHIA","19":"CHIPAQUE","20":"CHOACHI","21":"CHOCONTA","22":"COGUA","23":"COTA","24":"CUCUNUBA","25":"EL COLEGIO","26":"EL PENON","27":"EL ROSAL","28":"FACATATIVA","29":"FOMEQUE","30":"FOSCA","31":"FUNZA","32":"FUQUENE","33":"FUSAGASUGA","34":"GACHALA","35":"GACHANCIPA","36":"GACHETA","37":"GAMA","38":"GIRARDOT","39":"GRANADA","40":"GUACHETA","41":"GUADUAS","42":"GUASCA","43":"GUATAQUI","44":"GUATAVITA","45":"GUAYABAL DE SIQUIMA","46":"GUAYABETAL","47":"GUTIERREZ","48":"JERUSALEN","49":"JUNIN","50":"LA CALERA","51":"LA MESA","52":"LA PALMA","53":"LA PENA","54":"LA VEGA","55":"LENGUAZAQUE","56":"MACHETA","57":"MADRID","58":"MANTA","59":"MEDINA","60":"MOSQUERA","61":"NARINO","62":"NEMOCON","63":"NILO","64":"NIMAIMA","65":"NOCAIMA","66":"PACHO","67":"PAIME","68":"PANDI","69":"PARATEBUENO","70":"PASCA","71":"PUERTO SALGAR","72":"PULI","73":"QUEBRADANEGRA","74":"QUETAME","75":"QUIPILE","76":"RICAURTE","77":"SAN ANTONIO DE TEQUENDAMA","78":"SAN BERNARDO","79":"SAN CAYETANO","80":"SAN FRANCISCO","81":"SAN JUAN DE RIOSECO","82":"SASAIMA","83":"SESQUILE","84":"SIBATE","85":"SILVANIA","86":"SIMIJACA","87":"SOACHA","88":"SOPO","89":"SUBACHOQUE","90":"SUESCA","91":"SUPATA","92":"SUSA","93":"SUTATAUSA","94":"TABIO","95":"TAUSA","96":"TENA","97":"TENJO","98":"TIBACUY","99":"TIBIRITA","100":"TOCAIMA","101":"TOCANCIPA","102":"TOPAIPI","103":"UBALA","104":"UBAQUE","105":"UBATE","106":"UNE","107":"UTICA","108":"VENECIA","109":"VERGARA","110":"VIANI","111":"VILLAGOMEZ","112":"VILLAPINZON","113":"VILLETA","114":"VIOTA","115":"YACOPI","116":"ZIPACON","117":"ZIPAQUIRA"},"16":{"1":"BARRANCO MINA","2":"CACAHUAL","3":"INIRIDA","4":"LA GUADALUPE","5":"MAPIRIPANA","6":"MORICHAL","7":"PANA-PANA","8":"PUERTO COLOMBIA","9":"SAN FELIPE"},"17":{"1":"ALBANIA","2":"BARRANCAS","3":"DIBULLA","4":"DISTRACCION","5":"EL MOLINO","6":"FONSECA","7":"HATO NUEVO","8":"LA JAGUA DEL PILAR","9":"MAICAO","10":"MANAURE","11":"RIOHACHA","12":"SAN JUAN DEL CESAR","13":"URIBIA","14":"URUMITA","15":"VILLANUEVA"},"18":{"1":"CALAMAR","2":"EL RETORNO","3":"MIRAFLORES","4":"SAN JOSE DEL GUAVIARE"},"19":{"1":"ACEVEDO","2":"AGRADO","3":"AIPE","4":"ALGECIRAS","5":"ALTAMIRA","6":"BARAYA","7":"CAMPOALEGRE","8":"COLOMBIA","9":"ELIAS","10":"GARZON","11":"GIGANTE","12":"GUADALUPE","13":"HOBO","14":"IQUIRA","15":"ISNOS","16":"LA ARGENTINA","17":"LA PLATA","18":"NATAGA","19":"NEIVA","20":"OPORAPA","21":"PAICOL","22":"PALERMO","23":"PALESTINA","24":"PITAL","25":"PITALITO","26":"RIVERA","27":"SALADOBLANCO","28":"SAN AGUSTIN","29":"SANTA MARIA","30":"SUAZA","31":"TARQUI","32":"TELLO","33":"TERUEL","34":"TESALIA","35":"TIMANA","36":"VILLAVIEJA","37":"YAGUARA"},"20":{"1":"ALGARROBO","2":"ARACATACA","3":"ARIGUANI","4":"CERRO DE SAN ANTONIO","5":"CHIVOLO","6":"CIENAGA","7":"CONCORDIA","8":"EL BANCO","9":"EL PINON","10":"EL RETEN","11":"FUNDACION","12":"GUAMAL","13":"NUEVA GRANADA","14":"PEDRAZA","15":"PIJINO DEL CARMEN","16":"PIVIJAY","17":"PLATO","18":"PUEBLOVIEJO","19":"REMOLINO","20":"SABANAS DE SAN ANGEL","21":"SALAMINA","22":"SAN SEBASTIAN DE BUENAVISTA","23":"SAN ZENON","24":"SANTA ANA","25":"SANTA BARBARA DE PINTO","26":"SANTA MARTA","27":"SITIONUEVO","28":"TENERIFE","29":"ZAPAYAN","30":"ZONA BANANERA"},"21":{"1":"ACACIAS","2":"BARRANCA DE UPIA","3":"CABUYARO","4":"CASTILLA LA NUEVA","5":"CUBARRAL","6":"CUMARAL","7":"EL CALVARIO","8":"EL CASTILLO","9":"EL DORADO","10":"FUENTE DE ORO","11":"GRANADA","12":"GUAMAL","13":"LA MACARENA","14":"LEJANIAS","15":"MAPIRIPAN","16":"MESETAS","17":"PUERTO CONCORDIA","18":"PUERTO GAITAN","19":"PUERTO LLERAS","20":"PUERTO LOPEZ","21":"PUERTO RICO","22":"RESTREPO","23":"SAN CARLOS DE GUAROA","24":"SAN JUAN DE ARAMA","25":"SAN JUANITO","26":"SAN MARTIN","27":"URIBE","28":"VILLAVICENCIO","29":"VISTAHERMOSA"},"22":{"1":"ABREGO","2":"ARBOLEDAS","3":"BOCHALEMA","4":"BUCARASICA","5":"CACHIRA","6":"CACOTA","7":"CHINACOTA","8":"CHITAGA","9":"CONVENCION","10":"CUCUTA","11":"CUCUTILLA","12":"DURANIA","13":"EL CARMEN","14":"EL TARRA","15":"EL ZULIA","16":"GRAMALOTE","17":"HACARI","18":"HERRAN","19":"LA ESPERANZA","20":"LA PLAYA","21":"LABATECA","22":"LOS PATIOS","23":"LOURDES","24":"MUTISCUA","25":"OCANA","26":"PAMPLONA","27":"PAMPLONITA","28":"PUERTO SANTANDER","29":"RAGONVALIA","30":"SALAZAR","31":"SAN CALIXTO","32":"SAN CAYETANO","33":"SANTIAGO","34":"SARDINATA","35":"SILOS","36":"TEORAMA","37":"TIBU","38":"TOLEDO","39":"VILLA CARO","40":"VILLA DEL ROSARIO"},"23":{"1":"ALBAN","2":"ALDANA","3":"ANCUYA","4":"ARBOLEDA","5":"BARBACOAS","6":"BELEN","7":"BUESACO","8":"CHACHAGUI","9":"COLON (GEnova)","10":"CONSACA","11":"CONTADERO","12":"CORDOBA","13":"CUASPUD","14":"CUMBAL","15":"CUMBITARA","16":"EL CHARCO","17":"EL PENOL","18":"EL ROSARIO","19":"EL TABLON","20":"EL TAMBO","21":"FRANCISCO PIZARRO","22":"FUNES","23":"GUACHUCAL","24":"GUAITARILLA","25":"GUALMATAN","26":"ILES","27":"IMUES","28":"IPIALES","29":"LA CRUZ","30":"LA FLORIDA","31":"LA LLANADA","32":"LA TOLA","33":"LA UNION","34":"LEIVA","35":"LINARES","36":"LOS ANDES","37":"MAG&Uuml;I","38":"MALLAMA","39":"MOSQUERA","40":"NARINO","41":"OLAYA HERRERA","42":"OSPINA","43":"PASTO","44":"POLICARPA","45":"POTOSI","46":"PROVIDENCIA","47":"PUERRES","48":"PUPIALES","49":"RICAURTE","50":"ROBERTO PAYAN","51":"SAMANIEGO","52":"SAN BERNARDO","53":"SAN LORENZO","54":"SAN PABLO","55":"SAN PEDRO DE CARTAGO","56":"SANDONA","57":"SANTA BARBARA","58":"SANTA CRUZ","59":"SAPUYES","60":"TAMINANGO","61":"TANGUA","62":"TUMACO","63":"TUQUERRES","64":"YACUANQUER"},"24":{"1":"COLON","2":"MOCOA","3":"ORITO","4":"PUERTO ASIS","5":"PUERTO CAICEDO","6":"PUERTO GUZMAN","7":"PUERTO LEGUIZAMO","8":"SAN FRANCISCO","9":"SAN MIGUEL","10":"SANTIAGO","11":"SIBUNDOY","12":"VALLE DEL GUAMUEZ","13":"VILLAGARZON"},"25":{"1":"ARMENIA","2":"BUENAVISTA","3":"CALARCA","4":"CIRCASIA","5":"CORDOBA","6":"FILANDIA","7":"GENOVA","8":"LA TEBAIDA","9":"MONTENEGRO","10":"PIJAO","11":"QUIMBAYA","12":"SALENTO"},"26":{"1":"APIA","2":"BALBOA","3":"BELEN DE UMBRIA","4":"DOSQUEBRADAS","5":"GUATICA","6":"LA CELIA","7":"LA VIRGINIA","8":"MARSELLA","9":"MISTRATO","10":"PEREIRA","11":"PUEBLO RICO","12":"QUINCHIA","13":"SANTA ROSA DE CABAL","14":"SANTUARIO"},"27":{"1":"PROVIDENCIA Y SANTA CATALINA","2":"SAN ANDRES"},"28":{"1":"AGUADA","2":"ALBANIA","3":"ARATOCA","4":"BARBOSA","5":"BARICHARA","6":"BARRANCABERMEJA","7":"BETULIA","8":"BOLIVAR","9":"BUCARAMANGA","10":"CABRERA","11":"CALIFORNIA","12":"CAPITANEJO","13":"CARCASI","14":"CEPITA","15":"CERRITO","16":"CHARALA","17":"CHARTA","18":"CHIMA","19":"CHIPATA","20":"CIMITARRA","21":"CONCEPCION","22":"CONFINES","23":"CONTRATACION","24":"COROMORO","25":"CURITI","26":"EL CARMEN","27":"EL GUACAMAYO","28":"EL PENON","29":"EL PLAYON","30":"ENCINO","31":"ENCISO","32":"FLORIAN","33":"FLORIDABLANCA","34":"GALAN","35":"GAMBITA","36":"GIRON","37":"GUACA","38":"GUADALUPE","39":"GUAPOTA","40":"GUAVATA","41":"G&Uuml;EPSA","42":"HATO","43":"JESUS MARIA","44":"JORDAN","45":"LA BELLEZA","46":"LA PAZ","47":"LANDAZURI","48":"LEBRIJA","49":"LOS SANTOS","50":"MACARAVITA","51":"MALAGA","52":"MATANZA","53":"MOGOTES","54":"MOLAGAVITA","55":"OCAMONTE","56":"OIBA","57":"ONZAGA","58":"PALMAR","59":"PALMAS DEL SOCORRO","60":"PARAMO","61":"PIEDECUESTA","62":"PINCHOTE","63":"PUENTE NACIONAL","64":"PUERTO PARRA","65":"PUERTO WILCHES","66":"RIONEGRO","67":"SABANA DE TORRES","68":"SAN ANDRES","69":"SAN BENITO","70":"SAN GIL","71":"SAN JOAQUIN","72":"SAN JOSE DE MIRANDA","73":"SAN MIGUEL","74":"SAN VICENTE DE CHUCURI","75":"SANTA BARBARA","76":"SANTA HELENA DEL OPON","77":"SIMACOTA","78":"SOCORRO","79":"SUAITA","80":"SUCRE","81":"SURATA","82":"TONA","83":"VALLE DE SAN JOSE","84":"VELEZ","85":"VETAS","86":"VILLANUEVA","87":"ZAPATOCA"},"29":{"1":"BUENAVISTA","2":"CAIMITO","3":"CHALAN","4":"COLOSO","5":"COROZAL","6":"COVENAS","7":"EL ROBLE","8":"GALERAS","9":"GUARANDA","10":"LA UNION","11":"LOS PALMITOS","12":"MAJAGUAL","13":"MORROA","14":"OVEJAS","15":"PALMITO","16":"SAMPUES","17":"SAN BENITO ABAD","18":"SAN JUAN DE BETULIA","19":"SAN MARCOS","20":"SAN ONOFRE","21":"SAN PEDRO","22":"SINCE","23":"SINCELEJO","24":"SUCRE","25":"TOLU","26":"TOLUVIEJO"},"30":{"1":"ALPUJARRA","2":"ALVARADO","3":"AMBALEMA","4":"ANZOATEGUI","5":"ARMERO","6":"ATACO","7":"CAJAMARCA","8":"CARMEN DE APICALA","9":"CASABIANCA","10":"CHAPARRAL","11":"COELLO","12":"COYAIMA","13":"CUNDAY","14":"DOLORES","15":"ESPINAL","16":"FALAN","17":"FLANDES","18":"FRESNO","19":"GUAMO","20":"HERVEO","21":"HONDA","22":"IBAGUE","23":"ICONONZO","24":"LERIDA","25":"LIBANO","26":"MARIQUITA","27":"MELGAR","28":"MURILLO","29":"NATAGAIMA","30":"ORTEGA","31":"PALOCABILDO","32":"PIEDRAS","33":"PLANADAS","34":"PRADO","35":"PURIFICACION","36":"RIOBLANCO","37":"RONCESVALLES","38":"ROVIRA","39":"SALDANA","40":"SAN ANTONIO","41":"SAN LUIS","42":"SANTA ISABEL","43":"SUAREZ","44":"VALLE DE SAN JUAN","45":"VENADILLO","46":"VILLAHERMOSA","47":"VILLARRICA"},"31":{"1":"ALCALA","2":"ANDALUCIA","3":"ANSERMANUEVO","4":"ARGELIA","5":"BOLIVAR","6":"BUENAVENTURA","7":"BUGA","8":"BUGALAGRANDE","9":"CAICEDONIA","10":"CALI","11":"CALIMA","12":"CANDELARIA","13":"CARTAGO","14":"DAGUA","15":"EL AGUILA","16":"EL CAIRO","17":"EL CERRITO","18":"EL DOVIO","19":"FLORIDA","20":"GINEBRA","21":"GUACARI","22":"JAMUNDI","23":"LA CUMBRE","24":"LA UNION","25":"LA VICTORIA","26":"OBANDO","27":"PALMIRA","28":"PRADERA","29":"RESTREPO","30":"RIOFRIO","31":"ROLDANILLO","32":"SAN PEDRO","33":"SEVILLA","34":"TORO","35":"TRUJILLO","36":"TULUA","37":"ULLOA","38":"VERSALLES","39":"VIJES","40":"YOTOCO","41":"YUMBO","42":"ZARZAL"},"32":{"1":"CARURU","2":"MITU","3":"PACOA","4":"PAPUNAUA","5":"TARAIRA","6":"YAVARATE"},"33":{"1":"CUMARIBO","2":"LA PRIMAVERA","3":"PUERTO CARRENO","4":"SANTA ROSALIA"}};















