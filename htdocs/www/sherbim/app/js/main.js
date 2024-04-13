$(document).ready( function()
{
	loadCheck();
	console.log("hi");
});
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
		
		// console.log("log error")			
		// return;
		
		editingAct = 0;
		exportFile = 0;
		
        makeBoxpand("clientAdminBS","Administrar Clientes","Administrar Clientes", 1);
		makeBoxpand("clientSearchBS","Buscar Clientes","Buscar Clientes", 1);
	
		makeBoxpand("sucuAdminBS","Administrar Sucursales","Administrar Sucursales", 1);
        makeBoxpand("sucuSearchBS","Buscar Sucursales","Buscar Sucursales", 1);
        
        makeBoxpand("maquiAdminBS","Administrar Equipos","Administrar Equipos", 1);
        makeBoxpand("maquiSearchBS","Buscar Equipos","Buscar Equipos", 1);
        
        makeBoxpand("techiAdminBS","Administrar Técnicos","Administrar Técnicos", 1);
        makeBoxpand("techiSearchBS","Buscar Técnicos","Buscar Técnicos", 1);
        
        makeBoxpand("actiAdminBS","Administrar Actividades","Administrar Actividades", 1);
        makeBoxpand("actiSearchBS","Buscar Actividades","Buscar Actividades", 1);
        
        makeBoxpand("inveAdminBS","Administrar Inventario","Administrar Inventario", 1);
        makeBoxpand("inveSearchBS","Buscar Inventario","Buscar Inventario", 1);
        
        makeBoxpand("logSearchBS","Buscar Log de Movimientos","Buscar Log de Movimientos", 1);
        
        makeBoxpand("ocreateAdminBS","Administrar Orden de Trabajo","Administrar Orden de Trabajo", 1);
        makeBoxpand("orderSearchBS","Buscar Orden","Buscar Orden", 0);
        
        makeBoxpand("ocreateAdminBSCL","Crear Orden de Trabajo","Crear Orden de Trabajo", 1);
        makeBoxpand("orderSearchBSCL","Buscar Orden","Buscar Orden", 1);
        
        makeBoxpand("repSearchBS","Reportes de Orden","Reportes de Orden", 1);
        
        makeBoxpand("recSearchBS","Maestro de Facturación","Maestro de Facturación", 1);
		
        makeBoxpand("checklistBS","Listas de checkeo","Listas de checkeo", 1);
		
		
        makeBoxpand("sessBS","Sesiones de trabajo","Sesiones de trabajo", 1);
        
        makeBoxpand("recAdminBS","Resolucion de facturación","Resolucion de facturación", 0);
        
        makeBoxpand("orderTSearchBS","Buscar Orden","Buscar Orden", 1);
        
        makeBoxpand("reportsSearchBS","Filtro","Filtro", 1);

        ltt1 = "Creación";
        ltt2 = "Edición";
        ltt3 = "Eliminación";
        ltt4 = "Ingreso";
		ltt5 = "Cambio Password"
		
		
		var pickMax = 1001;
		
		var repicker = document.getElementById("a-orderQtyPicker");
		repicker.innerHTML = "";
		for(var i=1; i<pickMax; i++)
		{
			var option = document.createElement("option");
			option.value = i;
			option.innerHTML = i;
			repicker.appendChild(option);
		}
		
		
		var otherpicker = document.getElementById("a-otherQtyPicker");
		otherpicker.innerHTML = "";
		for(var i=1; i<pickMax; i++)
		{
			var option = document.createElement("option");
			option.value = i;
			option.innerHTML = i;
			otherpicker.appendChild(option);
		}
		

        
        clientSaveButton = document.getElementById("clientSaveButton");
        sucusavebutton = document.getElementById("sucuSaveButton");
        maquiSaveButton = document.getElementById("maquiSaveButton");
        techiSaveButton = document.getElementById("techiSaveButton");
        actiSaveButton = document.getElementById("actiSaveButton");
        inveSaveButton = document.getElementById("inveSaveButton");
        orderSaveButton = document.getElementById("orderSaveButton");
        orderSaveButtonCL = document.getElementById("orderSaveButtonCL");
        

        a_clients_targets = ["a-clientName", "a-clientManager", "a-clientNit", "a-clientNature", "a-clientPhone", "a-clientAddress", "a-clientEmail", "a-clientLocation"];
        f_clients_targets = ["f-clientName", "f-clientNit", "f-clientEmail"];
        
        a_sucu_targets = ["a-sucuParent", "a-sucuCode", "a-sucuName", "a-sucuAddress", "a-sucuPhone", "a-sucuCountry", "a-sucuDepto", "a-sucuCity"];
        f_sucu_targets = ["f-sucuParent", "f-sucuName", "f-sucuCode"];
        
        a_maqui_targets = ["a-maquiParent", "a-maquiSucu", "a-maquiPlate", "a-maquiName", "a-maquiModel", "a-maquiSerial", "a-maquiVolt", "a-maquiCurrent", "a-maquiPower", "a-maquiPhase", "a-maquiDetails"];
        f_maqui_targets = ["f-maquiParent", "f-maquiSucu", "f-maquiPlate"];
        
        a_techi_targets = ["a-techiId", "a-techiName", "a-techiCat", "a-techiMastery", "a-techiEmail", "a-techiAddress", "a-techiPhone", "a-techiDetails"];
        f_techi_targets = ["f-techiId", "f-techiCat", "f-techiName"];
        
        a_acti_targets = ["a-actiType", "a-actiDesc", "a-actiTime", "a-actiValue", "a-actiValueMat"];
        f_acti_targets = ["f-actiType", "f-actiCode", "f-actiDesc"];
        
        a_inve_targets = ["a-inveCode", "a-inveDesc", "a-inveCost", "a-inveMargin", "a-inveAmount"];
        f_inve_targets = ["f-inveCode", "f-inveDesc"];
        
        a_orde_targets = ["a-orderParent", "a-orderSucu", "a-orderMaquis", "a-orderPriority", "a-orderDesc", "a-orderType", "a-orderOrderClient"];
        f_orde_targets = ["f-orderParent", "f-orderSucu", "f-orderNum", "f-orderState", "f-orderType", "f-orderDetail"];
        
        a_orde_targetsCL = ["a-orderSucuCL", "a-orderMaquisCL", "a-orderPriorityCL", "a-orderDescCL", "a-orderOrderClientCL"];
        f_orde_targetsCL = ["f-orderSucuCL", "f-orderNumCL", "f-orderStateCL"];
        
        
        f_log_targets = ["f-logResp", "f-logInidate", "f-logEndate", "f-logType", "f-logTarget","f-logMove"];

        f_rep_targets = ["f-repParent", "f-repSucu", "f-repNumber", "f-repInidate", "f-repEndate"];
        
        f_rec_targets = ["f-recNumber", "f-recParent", "f-repOnum", "f-recInidate", "f-recEndate"];
        
        a_rec_targets = ["a-resoNumber", "a-resoDate", "a-resoIninum", "a-resoEndnum", "a-resoActualnum"];
        
        f_orde_targetsT = ["f-orderParentT", "f-orderSucuT", "f-orderTypeT", "f-orderNumT"];
        
		laborTypes = ["Ejecución actividad", "Compra repuestos", "Desplazamiento", "Mensajería", "Legalizaciones", "Incapacidad/Licencia", "Otros"];
				
		
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
        
		var budgetSelectorOrder = document.getElementById("budgetSelectorOrder");
		budgetSelectorOrder.addEventListener('change', handleFileSelectBudget, false);
		
        var picSelectorIni = document.getElementById("picSelectorIni");
        picSelectorIni.addEventListener('change', handleFileSelectIni, false);
        
        var picSelectorEnd = document.getElementById("picSelectorEnd");
        picSelectorEnd.addEventListener('change', handleFileSelectEnd, false);
		
		var picSelectorOrder = document.getElementById("picSelectorOrder");
	picSelectorOrder.addEventListener('change', handleFileSelectOrder, false);

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
		
		jQuery('#sessionIni').datetimepicker();
		jQuery('#sessionEnd').datetimepicker();
		
        jQuery('#a-resoDate').datetimepicker({ dateFormat: 'yy-mm-dd' });


		 jQuery('#hollyBox').datetimepicker
		({
				timepicker:false,
				format:'Y-m-d',
			}).on('change', function() {
				$('.xdsoft_datetimepicker').hide();
				var str = $(this).val();
				str = str.split(".");
				
		});
        
        if(localStorage["tmpOrder"])
        {
                actualOrderData = JSON.parse(localStorage["tmpOrder"]);
        }
        else
        {
                actualOrderData = [];
        }
        
	liveRefresh();
	langPickIni();
}
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	
	imported.src = 'js/live.js';
	
	if(loc.includes("192.168"))
	{
		document.head.appendChild(imported);
	}
}
function checkStart()
{
        var d = window.location.href;
	var t = d.split("?");
	if(t.length > 1){var a = t[1];ifLoad('ifPassRec');pssReCode = a.split("key=")[1];pssReCode = pssReCode.split("&")[0];history.pushState({}, null, "http://www.sherbim.co/app/");return true;}
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
	if (window.localStorage.getItem("userLoged")) 
	{
		var workArea = document.getElementById("workArea");
		workArea.style.display = "initial";
		var loginCover = document.getElementById("loginArea");
		loginCover.style.display = "none";
		
		document.getElementById("exitIcon").style.display = "block";
		
		aud = JSON.parse(window.localStorage.getItem("aud"));
		actualUtype = window.localStorage.getItem("userLoged");
				
		setMenuItems(actualUtype);
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

			localStorage.setItem("aud",JSON.stringify(aud));
			actualUcode = aud.CODE;
			actualUname = aud.BNAME;
					
			var loginCover = document.getElementById("loginArea");
			loginCover.style.display = "none";
			
			var workArea = document.getElementById("workArea");
			workArea.style.display = "block";
			
			document.getElementById("exitIcon").style.display = "block";
			
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
		mainMenu.appendChild(menuCreator("menuMasterCH"));
		mainMenu.appendChild(menuCreator("menuMasterSess"));
		mainMenu.appendChild(menuCreator("menuMasterL"));
		mainMenu.appendChild(menuCreator("menuMasterH"));

		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		// ifLoad('ifMasterA');
		ifLoad('ifMasterO');

		// ifLoad('iforderMain');
		// orderStarter("30d1b4565e9e0af385eb86e37e653603");
		
		// ifLoad('ifMasterSess');
		// ifLoad('ifMasterM');
		// ifLoad('ifMasterREP');
		// ifLoad('ifMasterF');
	}
	else if(value == "C")
	{
		mainMenu.appendChild(menuCreator("menuMasterCL"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterREP"));
		mainMenu.appendChild(menuCreator("menuMasterSess"));
		mainMenu.appendChild(menuCreator("menuMasterM"));
		
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		ifLoad('ifMasterCL');
	}
	else
	{
		mainMenu.appendChild(menuCreator("menuMasterTO"));
		mainMenu.appendChild(menuCreator("menuMasterR"));
		mainMenu.appendChild(menuCreator("menuMasterSess"));
		var icon = document.getElementById("respIcon");
		mainMenu.appendChild(icon);
		
		 ifLoad('ifMasterTO');

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

        document.getElementById("exitIcon").style.display = "none";

        var icon = document.getElementById("respIcon");

        document.getElementById("hidden").appendChild(icon)

        actualUtype = null;
        aud = null;
        backHome();
        
        
        
}
// IFLOAD
function ifLoad(code)
{
	
	if(code == "ifMasterH")
	{
		console.log("lol");
		
		formBox("hollydayBox","Días festivos",300);
		refreshollydays();
		return;
	}
	
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
                        
						if(actualUtype == "C")
						{
							alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No puedes realizar esta acción", 300);
							return;
						}
						
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
                
				if(actualUtype != "C"){maquiGet();}
				
				
				
				
				
				
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
                initialPics = [];
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
               clearFields(f_orde_targets);
               actualMaquiPicks = [];
               actualMaquisList = [];
               
               orderSaveButton.innerHTML = "Crear";
               clearFields(a_sucu_targets, "a-orde");
               ordeGet();
	}
        if(code == "iforderMain")
	{
                
		makeBoxpand("oResumeSection","Resumen de Orden de trabajo","Resumen de Orden de trabajo", 1);
		makeBoxpand("oActisSection","Actividades de Orden","Actividades de Orden", 1);
		makeBoxpand("oChecklist","Lista de acciones preventivas","Lista de acciones preventivas", 1);
		makeBoxpand("oPartsSection","Repuestos","Repuestos", 1);
		makeBoxpand("oOthersSection","Otros Conceptos","Otros Conceptos", 1);
		makeBoxpand("oDetailsSection","Detalles de Orden","Detalles de Orden", 1);
		makeBoxpand("opicsAdminBS","Imagenes","Imagenes", 1);
		makeBoxpand("oTimesSection","Cierre de Orden","Cierre de Orden", 1);
		
		
		// orderStarter("f42dc1646054e4779778d19e148f2926");
                
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
    if(code == "ifMasterCH")
	{

	   refreshActionsChecks();
	   
	}
	if(code == "ifMasterSess")
	{

		loadSessLists();
	   
	   jQuery('#sessRepIni').datetimepicker
		({
				timepicker:false,
				format:'Y-m-d',
			}).on('change', function() {
				$('.xdsoft_datetimepicker').hide();
				var str = $(this).val();
				str = str.split(".");
				
		});
		
		jQuery('#sessRepEnd').datetimepicker
		({
				timepicker:false,
				format:'Y-m-d',
			}).on('change', function() {
				$('.xdsoft_datetimepicker').hide();
				var str = $(this).val();
				str = str.split(".");
				
		});
	   
	   
	  
	   
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
                        var rTypes =    [         {"NAME": "Actividades por actividad", "VAL":"12"},
                                                        {"NAME": "Actividades por cliente", "VAL":"4"},
                                                        {"NAME": "Actividades por equipo", "VAL":"1"},
                                                        {"NAME": "Costos y uso de inventario", "VAL":"9"},
                                                        {"NAME": "Informe de Repuestos ", "VAL":"5"},
                                                        // {"NAME": "Imagenes de Orden de trabajo", "VAL":"3"},
                                                        {"NAME": "Observaciones, Pendientes y Recomendaciones", "VAL":"8"},
                                                        {"NAME": "Ordenes de trabajo", "VAL":"2"},
                                                        {"NAME": "Otros por cliente", "VAL":"6"},
                                                        {"NAME": "Otros por tipo", "VAL":"7"},
                                                        {"NAME": "Sesiones de trabajo por técnico", "VAL":"11"},
                                                        {"NAME": "Tiempos de trabajo por ordenes", "VAL":"10"},
														{"NAME": "Costos y materiales", "VAL":"13"}
                                               ]
                                               
                }
                if(aud.TYPE == "C")
                {
                        var rTypes =    [         {"NAME": "Actividades por cliente", "VAL":"4"},
                                                        {"NAME": "Actividades por equipo", "VAL":"1"},
                                                        {"NAME": "Informe de Repuestos ", "VAL":"5"},
                                                        // {"NAME": "Imagenes de Orden de trabajo", "VAL":"3"},
                                                        {"NAME": "Observaciones, Pendientes y Recomendaciones", "VAL":"8"},
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
				
                picker.value = "2";
                
				picker.onchange();
                
	}

	resSet();
}
function addHollyday()
{
	var info = {};
	info.day = document.getElementById("hollyBox").value;
	
	if(info.day == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar una fecha", 300);
		return;
	}
	
	console.log(info);
	
	sendAjax("users","addHollyday",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		refreshollydays();
	});
	
}
function refreshollydays()
{
	var info = {};
        
    sendAjax("users","refreshollydays",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("hollyTable", ans);
		
	});
}
function createCheck()
{
	var info = {};
	
	var checkName = document.getElementById("checkListDetail").value;
	
	if(checkName == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir el nombre de la lista de chequeo", 300);
		return;
	}
	
	info.checkName = checkName;
	
	sendAjax("users","saveCheckList",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		alertBox(language["alert"],language["sys003"],300);
		refreshActionsChecks();
		document.getElementById("checkListDetail").value = "";

	});
}

function refreshActionsChecks()
{
	var info = {};
	
	sendAjax("users","getActionsChecks",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		actualActions = ans.actions;
		setActions(ans.actions);

		tableCreator("checklistsTable", ans.checklists);
	});
	
}
function setActions(list)
{
	var picker = document.getElementById("actionsList");
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Acciones";
	picker.appendChild(option);
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var option = document.createElement("option");
		option.value = item.CODE;
		option.innerHTML = item.DETAIL;
		picker.appendChild(option);
		
	}
}
function addAction()
{
	var container = document.getElementById("addAction");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoIcon";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var newActionBox = document.createElement("input");
	newActionBox.id = "newActionBox";
	newActionBox.type = "text";
	newActionBox.className = "recMailBox";
	newActionBox.placeholder = "Describe la acción a realizar";
	
	var recMailSend = document.createElement("div");
	recMailSend.className = "dualButtonPop";
	recMailSend.innerHTML = "Crear";
	recMailSend.onclick = function()
	{
		var info = {};
		info.action = $("#newActionBox").val();

		if(info.action == "")
		{
			alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una acción a realizar",300);
			return;
		}
		
		sendAjax("users","saveAction",info,function(response)
		{
			if(response.status)
			{
				hide_pop_form();
				alertBox(language["alert"],language["sys003"],300);
				refreshActionsChecks();
			}
		});
	}
	
	var recMailCancel = document.createElement("div");
	recMailCancel.className = "dualButtonPop";
	recMailCancel.innerHTML = language["cancel"];
	recMailCancel.onclick = function(){hide_pop_form()};
	
	// container.appendChild(icon);
	container.appendChild(newActionBox);
	container.appendChild(recMailSend);
	container.appendChild(recMailCancel);

	formBox("addAction","Agregar Acción",600);
}
function deleteAction()
{
	var picker = document.getElementById("actionsList");
	var action = picker.value;
	if(action == "")
	{
		alertBox(language["alert"], "Debe seleccionar una acción para eliminar", 300);
		return;
	}
	else
	{
		var param = [action];
		confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Desea eliminar esta acción, recuerde que no debe estar asociada a ningun checklist?", delActConfirm, 300, param);

	}
	
}
function delActConfirm(data)
{
	var info = {};
	info.code = data[0];
	
	sendAjax("users","deleteAction",info,function(response)
	{
		var ans = response.message;
		refreshActionsChecks();
	});
}
function ordeGetCL()
{

	var  info = {};
	
	info["f-orderParent"] = document.getElementById("f-orderParentCL").value;
	info["f-orderSucu"] = document.getElementById("f-orderSucuCL").value;
	info["f-orderNum"] = document.getElementById("f-orderNumCL").value;
	info["f-orderType"] = document.getElementById("f-orderTypeT").value;
	info["f-orderDetail"] = "";
	info["f-orderState"] = document.getElementById("f-orderStateCL").value;
	info.techcode = "";
	
	sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
		maquiCodePlates = response.maquis;
		tableCreator("ordersTableCL", ans);
	});
}
function refreshOrderTParents()
{
        var info = {};
        
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
        info["f-orderType"] = document.getElementById("f-orderTypeT").value;
        info["f-orderDetail"] = "";
        info["f-orderNum"] = document.getElementById("f-orderNumT").value;
        info["f-orderState"] = "2";
        info["techcode"] = aud.CODE;
		
		console.log(info)
        
        sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
		maquiCodePlates = response.maquis;
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
				
				// TESTING FILLING
				// console.log("TESTING FILLING");
				// document.getElementById("a-orderType").value = "2";
				// document.getElementById("a-orderPriority").value = "Normal";
				// document.getElementById("a-orderDesc").value = "PAJARON CUCU";
				
        }
        if(release == "a-log"){}
        
        for(var i = 0; i<items.length; i++)
        {
                document.getElementById(items[i]).value = "";
        }
        
}

// ORDER STARTER
// ORDER STARTER
// ORDER STARTER

function orderStarter(code)
{
        var info = {};
        
        info.ocode = code;
		console.log(info)
        
        sendAjax("users","orderFullGet",info,function(response)
        {
			var ans = response.message;
			console.log(ans)

			actualOrderData = ans.oData;
			
			actualOrderCode = actualOrderData.CODE;
			
			localStorage.setItem("tmpOrder", JSON.stringify(actualOrderData));
			
			var num = actualOrderData.CCODE;
			
			if(actualOrderData.OTYPE == "2")
			{
				document.getElementById("oChecklist").style.display = "block";
			}
			else
			{
				document.getElementById("oChecklist").style.display = "none";
			}
			
			
			if(num.length == 1){num = "000"+num;}
			else if(num.length == 2){num = "00"+num;}
			else if(num.length == 3){num = "0"+num;}
			else{num = num;}
			
			if(actualOrderData.CLOSEDATE != null)
			{
					var endate = actualOrderData.CLOSEDATE; 
					var rtime = getdDiff(actualOrderData.STARTIME, actualOrderData.CLOSEDATE)+" Minutos";
			}
			else
			{
					var endate = "Pendiente"; 
					var rtime = "Pendiente";
			}
			
			if(actualOrderData.STATE == "2"){var state = "Proceso";}
			if(actualOrderData.STATE == "3"){var state = "Revisión";}
			if(actualOrderData.STATE == "4"){var state = "Por facturar";}
			if(actualOrderData.STATE == "5"){var state = "Facturada";}
			if(actualOrderData.STATE == "6"){var state = "Anulada";}
			
			
			// HEADERFILL
			// if(actualOrderData.STARTIME == null){ document.getElementById("a-ostartTime").value = "";}else{document.getElementById("a-ostartTime").value = actualOrderData.STARTIME;}
			document.getElementById("oResNum").innerHTML = num;
			document.getElementById("oResPriority").innerHTML = "<img class='loneIconForm' src='irsc/"+actualOrderData.PRIORITY+".png'/>";
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
			
			var assigned = fixAssigned(actualOrderData.TECHNAME);
			
			
			document.getElementById("oResTech").innerHTML = assigned;
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

			document.getElementById("a-orderActPricePicker").value = "";
			document.getElementById("a-orderActPricePicker2").value = "";
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
					option.value = partPlist[i].CODE+">"+partPlist[i].DESCRIPTION+">"+parseFloat(parseFloat(partPlist[i].COST)+((parseFloat(partPlist[i].COST)*parseFloat(partPlist[i].MARGIN))/100));
					option.innerHTML = partPlist[i].CODE+" - "+partPlist[i].DESCRIPTION;
					picker.appendChild(option);
			}

			// PARTLISTFILLER
			tableCreator("oPartsTable", ans.oParts);
			
			 // OTHERSLISTFILLER
			tableCreator("oOthersTable", ans.oOthers);
			// CHECKLIST FILLER
			tableCreator("oChecksTable", ans.oChecks);
			
			// DETAILFILL
			document.getElementById("a-oDetailsText").value = "";
			document.getElementById("a-oRecomText").value = "";
			document.getElementById("a-oPendingsText").value = "";
			document.getElementById("a-oDetailsText").value = actualOrderData.OBSERVATIONS; 
			document.getElementById("a-oRecomText").value = actualOrderData.RECOMENDATIONS
			document.getElementById("a-oPendingsText").value = actualOrderData.PENDINGS
			
			// PICSFILLER
			// var pics = ans.oPics;
			// var iniList = pics.ini;
			// var endList = pics.end;
			// var orderList = pics.order;
			
			var iniList = actualOrderData.OINIPICS;
			var endList = actualOrderData.OENDPICS;
			var orderList = actualOrderData.OORDPICS;
			
			// UNPACK IMAGE FILES
			if(iniList != null && iniList != "")
			{initialPics = JSON.parse(iniList)}
			else{initialPics = [];}
			
			if(endList != null && endList != "")
			{finalPics = JSON.parse(endList)}
			else{finalPics = [];}
			
			if(orderList != null && orderList != "")
			{orderPics = JSON.parse(orderList)}
			else{orderPics = [];}
			
			console.log(initialPics)
			console.log(finalPics)
			console.log(orderPics)
			
			var inibox = document.getElementById("picturesBoxIni");
			var endbox = document.getElementById("picturesBoxEnd");
			var orderbox = document.getElementById("picturesBoxOrder");
			
			inibox.innerHTML = "";
			endbox.innerHTML = "";
			orderbox.innerHTML = "";

			for(var i=0; i<initialPics.length; i++)
			{
				var fileSrc = initialPics[i];
				var span = document.createElement('span');
				span.innerHTML = "<img class='imageBoxView' src='"+fileSrc+"'/>";
				span.path = fileSrc;
				span.num = i+1;
				span.onclick = function(){showPicBox(this.path, "Foto inicial", "ini");};
				inibox.appendChild(span);
			}
			for(var i=0; i<finalPics.length; i++)
			{
				var fileSrc = finalPics[i];
				var span = document.createElement('span');
				span.innerHTML = "<img class='imageBoxView' src='"+fileSrc+"'/>";
				span.path = fileSrc;
				span.num = i+1;
				span.onclick = function(){showPicBox(this.path, "Foto final", "end");};endbox.appendChild(span);
			}
			for(var i=0; i<orderPics.length; i++)
			{
				var fileSrc = orderPics[i];
				var span = document.createElement('span');
				span.innerHTML = "<img class='imageBoxView' src='"+fileSrc+"'/>";
				span.path = fileSrc;
				span.num = i+1;
				span.onclick = function(){showPicBox(this.path, "Foto Órden", "ord");};orderbox.appendChild(span);
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
   
			
			getOsessions();
		});
				
}
function fixAssigned(assigned)
{

	assigned = assigned.replace("[", "");
	assigned = assigned.replace("]", "");
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace('"', '');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	assigned = assigned.replace(',', ' - ');
	
	return assigned;
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
                document.getElementById("a-oRecomText").disabled = true;
                document.getElementById("a-oPendingsText").disabled = true;
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
                document.getElementById("a-oRecomText").disabled = false;
                document.getElementById("a-oPendingsText").disabled = false;
                document.getElementById("picSelectorIni").disabled = false;
                document.getElementById("picSelectorEnd").disabled = false;
                document.getElementById("oCloseButton").disabled = false;
                document.getElementById("oAprobeButton").disabled = false;
        }
}



// SESSION MANAGEMENT
// SESSION MANAGEMENT
// SESSION MANAGEMENT
// SESSION MANAGEMENT
// SESSION MANAGEMENT

function loadSessLists()
{
	 var info = {};
	 
	 sendAjax("users","loadSessLists",info,function(response)
	{
		console.log(response.message);
		
		var lists = response.message;
		var orders = lists.orders;
		var techs = lists.techs;
		var orderPicker = document.getElementById("sessOrderList");
		orderPicker.innerHTML = "";
		var actualHolly = lists.holly;
		
		hollyDays = [];
		for(var i=0; i<actualHolly.length; i++){hollyDays.push(actualHolly[i].HOLLYDATE)}
		
		console.log(hollyDays);
		
		
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Seleccione órden";
		orderPicker.appendChild(option)
		
		for(var i=0; i<orders.length; i++)
		{
			
			// IF ACTUAL USER IS TECH CHECK IF ORDET IS ASIGNED
			
			
			
			if(orders[i].TECHCODE == null || orders[i].TECHCODE == "null"){continue;}
			
			
			// console.log(orders[i].TECHCODE);
			
			if(aud.TYPE == "T")
			{if(!orders[i].TECHCODE.includes(aud.CODE)){continue;}}
			
		
			var option = document.createElement("option");
			option.value = orders[i].CODE;
			var num = orders[i].CCODE;
			if(num.length == 1){num = "000"+num;}
			else if(num.length == 2){num = "00"+num;}
			else if(num.length == 3){num = "0"+num;}
			else{num = num;}
			option.innerHTML = num +" - "+orders[i].PARENTNAME;
			
			
			
			
			
			
			orderPicker.appendChild(option);
		}
		
		
		
		var techPicker = document.getElementById("sessTechList");
		techPicker.innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "Seleccione técnico";
		techPicker.appendChild(option)
		
		
		for(var i=0; i<techs.length; i++)
		{
			var option = document.createElement("option");
			option.value = techs[i]["CODE"];
			option.innerHTML = techs[i]["CNAME"];
			techPicker.appendChild(option)
		}
		
		
		
		if(aud.TYPE == "T")
		{
			techPicker.value = aud.CODE;
			techPicker.disabled = true;
		}
		else
		{
			techPicker.value = "";
			techPicker.disabled = false;
		}
		
		// document.getElementById("sessTechList").value = "86f8e608c996fbca0f2bf6029a2afa36";
		// document.getElementById("sessRepIni").value = "2021-11-01";
		// document.getElementById("sessRepEnd").value = "2021-11-30";
		
		
		refreshSessList();
	});
	
}
function addSessOrder()
{
	var code = document.getElementById("sessOrderList").value;
	if(code == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar la órden", 300);
		return;
	}

	var info = {};
	info.ocode = code;
	
	sendAjax("users","orderFullGet",info,function(response)
	{
		var ans = response.message;
		actualOrderData = ans.oData;
		sessionPop("o")
	});
}
function addSessTech()
{
	var code = document.getElementById("sessTechList").value;
	if(code == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar un técnico", 300);
		return;
	}
	sessionPop("t")
	
}
function sessionPop(mode)
{

	actualSessMode = mode;
	
	console.log(actualSessMode);
	
	
	if(actualSessMode == "o")
	{
		var info = actualOrderData;
		var codes = info.TECHCODE; 
		var names = info.TECHNAME; 
		
	}
	else
	{
		var codes = document.getElementById("sessTechList").value; 
		var names = $("#sessTechList option:selected").text();
	}
	

	
	var techs = [];
	

	if(codes.includes("["))
	{codes = JSON.parse(codes);}
	else{var codes = '["'+codes+'"]';codes = JSON.parse(codes);}
	
	if(names.includes("["))
	{names = JSON.parse(names);}
	else{var names = '["'+names+'"]';names = JSON.parse(names);}
	
	var picker = document.getElementById("sessionTech")
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Técnico";
	picker.appendChild(option);

	for(var i=0; i<codes.length; i++)
	{
		var tech = {"code":  codes[i], "name": names[i]}
		techs.push(tech);

		var option = document.createElement("option");
		option.value = codes[i];
		option.innerHTML = names[i];
		picker.appendChild(option);
	}
	
	console.log(aud.TYPE)
	
	if(aud.TYPE == "T")
	{
		picker.value = aud.CODE;
		picker.disabled = true;
	}
	else
	{
		picker.value = "";
		picker.disabled = false;
	}
	
	var typePicker = document.getElementById("sessionLabor");
	typePicker.innerHTML = "";
	
	var option = document.createElement("option");
	option.innerHTML = "Seleccione tipo de labor";
	option.value = "";
	typePicker.appendChild(option);
	
	for(var i=0; i<laborTypes.length; i++)
	{
		var type = laborTypes[i];
		
		var option = document.createElement("option");
		option.innerHTML = type;
		option.value = type;
		typePicker.appendChild(option);
		
	}
	
	getOsessions();
	
	if(actualSessMode == "o")
	{
		document.getElementById("sessionIni").value = "";
		document.getElementById("sessResume").style.display = "initial"
		formBox("sessionsBox","Sesiones de trabajo órden",840);
	}
	else
	{
		picker.value = codes[0];
		document.getElementById("sessResume").style.display = "none"
		formBox("sessionsBox","Sesiones de trabajo técnico",840);
	}
	
	document.getElementById("sessionIni").value = "";
	document.getElementById("sessionEnd").value = "";
	document.getElementById("sessionLabor").value = "";
	
}
function addSession()
{
	var info = {};
	
	var techCode = document.getElementById("sessionTech").value;
	var techName = $("#sessionTech option:selected").text();
	var sessionIni = document.getElementById("sessionIni").value;
	var sessionEnd = document.getElementById("sessionEnd").value;
	var laborType = document.getElementById("sessionLabor").value;
	
	var stamp1 = new Date(sessionIni.split(" ")[0]).getTime();
	var stamp2 = new Date(sessionEnd.split(" ")[0]).getTime();
	
	sessionIni = sessionIni.replaceAll("/", "-")+":00";
	sessionEnd = sessionEnd.replaceAll("/", "-")+":00";
	
	
	var dateIni = sessionIni.split(" ")[0];
	var dateEnd = sessionEnd.split(" ")[0];
	
	if(dateIni != dateEnd)
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes crear sesiones que inicien y terminen el mismo día.", 300);
		return;
	}
	
	
	
	var sessionDetails = document.getElementById("sessionDetails").value;
	
	if(techCode == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar un técnico para la sesión", 300);
		return;
	}
	
	if(stamp1 > stamp2)
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La fecha de inicio no puede ser posterior a la de fin", 300);
		return;
	}
	
	if(sessionIni == sessionEnd)
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>La fecha de inicio es igual a la fecha de fin", 300);
		return;
	}
	
	if(laborType == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar el tipo de labor", 300);
		return;
	}
	
	if(sessionDetails == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir las observaciones de la sesión", 300);
		return;
	}
	
	if(actualSessMode == "t")
	{
		info.ocode = "-";
	}
	else
	{
		info.ocode = actualOrderData.CODE;
	}
	
	info.techCode = techCode;
	info.techName = techName;
	info.sessionIni = sessionIni;
	info.sessionEnd = sessionEnd;
	info.sessionDetails = sessionDetails;
	info.laborType = laborType;
	info.sessMode = actualSessMode;
	
	console.log(info);
	
	sendAjax("users","addSession",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(ans == "crossini")
		{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Ya existe una sesión para este técnico en este horario de inicio.", 300);
			return;
		}
		if(ans == "crossend")
		{
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Ya existe una sesión para este técnico en este horario de fin.", 300);
			return;
		}
		
		
		if(info.sessMode == "o")
		{
			tableCreator("sessionsTable", ans);
		}
		else
		{
			hide_pop_form();
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha creado la sesión para el técnico", 300);
		}
		
		refreshSessList();
	});
	
}
function closeDate ()
{
	var sessionIni = document.getElementById("sessRepIni").value;
	var sessionEnd = document.getElementById("sessRepEnd").value;
	var tech = document.getElementById("sessTechList").value;
	
	var dateIni = sessionIni.split(" ")[0];
	var dateEnd = sessionEnd.split(" ")[0];
	
	if(tech == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar el técnico para el cierre del día.", 300);
		return;
	}
	
	
	if(dateIni != dateEnd)
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Para cerrar una fecha debes establecer la misma fecha inicial y final.", 300);
		return;
	}
	
	var info = {}
	info.dateIni = dateIni+" 00:00:00";
	info.dateEnd = dateIni+" 23:59:59";
	info.tech = tech;
	
	console.log(info);
	
	sendAjax("users","closeDate",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se han cerrado las sesiones del día para el técnico seleccionado.", 300);
		
		refreshSessList()
		
	});
	
}
function getOsessions()
{
	var info = {};
	info.code = actualOrderData.CODE;
	document.getElementById("oReported").innerHTML = "0 horas";
	sendAjax("users","getOsessions",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		tableCreator("sessionsTable", ans);
		
	});
}
function refreshSessList()
{
	var info = {};
	info.tech = document.getElementById("sessTechList").value;
	
	
	sendAjax("users","refreshSessList",info,function(response)
	{
		var ans = response.message;
		tableCreator("sesslistsTable", ans);
	});
	
}
function reportSessTech()
{
	
	var tech = document.getElementById("sessTechList").value;
	var iniDate = document.getElementById("sessRepIni").value;
	var endDate = document.getElementById("sessRepEnd").value;
	
	var info = {};
	info.tech = tech;
	info.ini = iniDate+" 00:00:00";
	info.end = endDate+" 23:59:59";
		
	
	if(tech == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar un técnico para el reporte", 300);
		return;
	}
	if(iniDate == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar una fecha de inicio para el reporte", 300);
		return;
	}
	if(endDate == "")
	{
		alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe seleccionar una fecha de fin para el reporte", 300);
		return;
	}
	
	
	console.log(info);
	
	
	sendAjax("users","reportSessTech",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		var totalOrder = 0;
		var totalTech = 0;
		var totalRegular = 0;
		var totalED = 0;
		var totalEN = 0;
		var totalSun = 0;
		var totalHolly = 0;
		
		var rangeIni = document.getElementById("sessRepIni").value;
		var rangeEnd = document.getElementById("sessRepEnd").value;
		var techName = $("#sessTechList option:selected").text();
		console.log(techName);
		
		for(var i=0; i<ans.length; i++)
		{
			var sess = ans[i];
			
			var resume = getSessionResume(sess);
			console.log(resume);
			totalOrder += resume.ORDER;
			totalTech += resume.TECH;
			totalRegular += resume.NORMAL;
			totalED += resume.ED;
			totalEN += resume.EN;
			totalSun += resume.SUNDAY;
			totalHolly += resume.HOLLY;
		}
		
		totalOrder = getSessionTime(totalOrder)+" h";
		totalTech = getSessionTime(totalTech)+" h";
		totalRegular = getSessionTime(totalRegular)+" h";
		totalED = getSessionTime(totalED)+" h";
		totalEN = getSessionTime(totalEN)+" h";
		totalSun = getSessionTime(totalSun)+" h";
		totalHolly = getSessionTime(totalHolly)+" h";
		
		var res = "Técnico: "+techName+"<br>Reporte desde: "+rangeIni+" hasta: "+rangeEnd+"<br><br>Total en ordenes: "+totalOrder+"<br>Total otras sesiones: "+totalTech+"<br><br>Horario normal: "+totalRegular+"<br>Adicional diurno: "+totalED+"<br>Horario nocturno: "+totalEN+"<br>Dominicales: "+totalSun+"<br>Festivos: "+totalHolly;
		
		 alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>"+res, 400);
		
		
	});
	
}
function getSessionResume(session)
{
	// console.log(session);
	
	var resume = {};
	
	var ini = session.INIDATE;
	var end = session.ENDATE;
	var minutes = minDiff(ini, end);
	resume.TOTALM = minutes;
	
	
	var iniNormal = ini.split(" ")[0]+" 06:00:00";
	var endNormal = end.split(" ")[0]+" 17:30:00";
	var iniED = end.split(" ")[0]+" 17:31:00";
	var endED = end.split(" ")[0]+" 22:00:00";
	
	var caso = "-";
	
	// DETECT HOUR RANGES
	if(ini >= iniNormal && end <= endNormal)
	{
		
		caso = "1";
		// console.log(ini);
		// console.log(end);
		resume.NORMAL = minutes;
		resume.EN = 0;
		resume.ED = 0;
	}
	
	if(ini < iniNormal && end >= iniNormal)
	{
		
		caso = "2";
		// console.log(ini);
		// console.log(end);
		
		resume.NORMAL = minDiff(iniNormal, end);
		resume.EN = minDiff(ini, iniNormal);
		resume.ED = 0;
	}
	
	if(ini <= endNormal && end > endNormal)
	{
		
		caso = "3";
		// console.log(ini);
		// console.log(end);
		
		resume.NORMAL = minDiff(ini, endNormal);
		resume.EN = 0;
		resume.ED = minDiff(endNormal, end);
		
		if(end > endED)
		{
			
			caso = "6";
			// console.log(ini);
			// console.log(end);
			resume.NORMAL = minDiff(ini, endNormal);
			resume.EN = minDiff(endED, end);
			resume.ED = minDiff(endNormal, endED);
		}
	}
	
	if(ini < iniNormal && end <= iniNormal)
	{
		
		caso = "4";
		// console.log(ini);
		// console.log(end);
		
		resume.NORMAL = 0;
		resume.EN = minutes;
		resume.ED = 0;
	}
	
	if(ini > endNormal && end > endNormal)
	{
		
		caso = "5";
		// console.log(ini);
		// console.log(end);
		
		resume.NORMAL = 0;
		resume.EN = 0;
		resume.ED = minutes;
		
		if(end > endED)
		{
			var caso = "6.1";
			// console.log(ini);
			// console.log(end);
			resume.NORMAL = 0;
			resume.EN = minDiff(endED, end);
			resume.ED = minDiff(ini, endED);
		}

	}
	
	
	if(caso == "-")
	{
		console.log(session);
	}
	
	
	// DETECT ORDER OR TECH
	if(session.OCODE == "-")
	{
		resume.ORDER = 0;
		resume.TECH = resume.TOTALM;
	}
	else
	{
		resume.ORDER = resume.TOTALM;
		resume.TECH = 0;
	}
	
	// DETECT SUNDAY
	var day = new Date(session.INIDATE.split(" ")[0]);
	var daynum = day.getDay();
	
	
	if(daynum == 6)
	{
		console.log("SUNDAY "+ session.INIDATE);
		resume.SUNDAY = minutes;
		
	}
	else
	{
		resume.SUNDAY = 0;
	}
	
	// DETECT HOLLY
	var checkDate = session.INIDATE.split(" ")[0];
	if(hollyDays.includes(checkDate))
	{
		resume.HOLLY = minutes;
	}
	else
	{
		resume.HOLLY = 0;
	}
	
	
	return resume;
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
                confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿Desea cerrar la orden actual? recuerde que no podrá revisarla ni hacer más cambios en ella una vez cerrada.", oCloseConfirmed, 300, param);
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

        // document.getElementById("oCloseButton").onclick = function(){console.log("locked")}
        
        sendAjax("users","reportCreate",info,function(response)
        {
                var ans = response.message;
				console.log(ans);
                 // ON RETURN
                document.getElementById("oResState").innerHTML = "Revisión";
                var diff = getdDiff(actualOrderData.STARTIME, getNow());
                // document.getElementById("oReported").innerHTML = diff+" Minutos";
                
				
				// RESTAURAR ON FINISH
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
        
        // var state = actualOrderData.STATE;
        // if(state != "2")
        // {
                // alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes generar reportes parciales para ordenes en 'Proceso'", 300);
                // return;
        // }
        
        var diff = getdDiff(actualOrderData.STARTIME, getNow());
        
        info.diff = diff;
        
         
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
function oPartialRepE()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        info.odate = getNow();
        info.partial = "1";

        var diff = getdDiff(actualOrderData.STARTIME, getNow());
        info.diff = diff;

        document.getElementById("parcialReportE").onclick = function(){console.log("locked")}

        sendAjax("users","reportCreateE",info,function(response)
        {
			var ans = response.message;
			console.log(ans)
			var url = "reports/"+info.ocode+"-V.pdf";
			downloadReport(url);
			 // ON RETURN
		   
			document.getElementById("parcialReportE").onclick = function(){oPartialRepE();}
			
			// EXIT TO ORDER LIST TECHIES
			// alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha generado un reporte parcial de esta orden.", 300);

        });
}
function oAprobe()
{
        
		// CHECK IF REQUIRED
		
		// var initialPics = document.getElementById("picturesBoxIni").children;
		// var finalPics = document.getElementById("picturesBoxEnd").children;
		// var orderPics = document.getElementById("picturesBoxOrder").children;

		
		// if(initialPics.length == 0 || finalPics.length == 0 || orderPics.length == 0)
		// {
			// alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe cargar por lo menos 1 imagen inicial, 1 final y la orden de trabajo.", 300);
			// return;
		// }
		
		
		var state = actualOrderData.STATE;
        if(aud.TYPE != "A")
        {
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo un administrador puede aprobar la orden", 300);
			return;
        }
        if(state != "3")
        {
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes Aprobar ordenes que se encuentren en estado 'Revisión'", 300);
			return;
        }
        else
        {
			var param = "none";
			confirmBox(language["confirm"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>¿DeseasAprobar la orden actual? esta cambiará a estado 'Por facturar'.", oAprobeConfirmed, 300, param);
        }
}
function oAprobeConfirmed()
{
        document.getElementById("oResState").innerHTML = "Por facturar";
        actualOrderData.STATE = "4";
        
        var info = {};
        info.odate = getNow();
        info.ocode = actualOrderData.CODE;
        
        var diff = getdDiff(actualOrderData.STARTIME, actualOrderData.CLOSEDATE);
        
        info.diff = diff;
        
        sendAjax("users","reportCreateTotalized",info,function(response)
        {
                var ans = response.message;
				console.log(ans)
				
				// var url = "reports/"+info.ocode+"-T.pdf";
				// downloadReport(url);
				
				// return
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
function showPicBox(path, title, group)
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
		
		// GET PICPOS
		if(group == "ini"){var list = initialPics;}
		if(group == "end"){var list = finalPics;}
		if(group == "ord"){var list = orderPics;}
		
		for(var p=0; p<list.length; p++)
		{if(path == list[p]){var pos = p;break}}
		
		console.log(pos)
		
		var del = document.createElement("button");
		del.group = group;
		del.pos = pos;
        del.className = "singleButtonPop";
        del.innerHTML = "Eiminar";
        del.onclick = function()
		{
			console.log("Desea eliminar?")
			
			
			if(this.group == "ini")
			{
				var list = initialPics;
				var mode = "inicial";
				var box = document.getElementById("picturesBoxIni");
			}
			if(this.group == "end")
			{
				var list = finalPics;
				var mode = "final";
				var box = document.getElementById("picturesBoxEnd");
			}
			if(this.group == "ord")
			{
				var list = orderPics;
				var mode = "Órden";
				var box = document.getElementById("picturesBoxOrder");
			}
			
			list.splice(this.pos, 1);
			
			box.innerHTML = "";
			
			for(var i=0; i<list.length; i++)
			{
				var fileSrc = list[i];
				var span = document.createElement('span');
				span.innerHTML = "<img class='imageBoxView' src='"+fileSrc+"'/>";
				span.path = fileSrc;
				span.num = i+1;
				span.mode = this.mode;
				span.group = this.group;
				span.onclick = function()
				{
					showPicBox(this.path, "Foto "+this.mode, this.group);
				};
				box.appendChild(span);
			}
			
			hide_pop_form();
			
		};

        picBox.appendChild(image);
        
        var exitBox = document.createElement("div");
		exitBox.className = "dualButtonsDiv";

        exitBox.appendChild(exit);
        exitBox.appendChild(del);
		
        picBox.appendChild(exitBox);
        image.parentNode.style.textAlign = "center";
		
		
		
		
        
        formBox("modalPicBox",title,500);
}
function refreshoDetails()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getoDetails",info,function(response)
        {
                var ans = response.message;

                document.getElementById("a-oDetailsText").value = "";
                document.getElementById("a-oRecomText").value = "";
                document.getElementById("a-oPendingsText").value = "";

                document.getElementById("a-oDetailsText").value = ans.obs; 
                document.getElementById("a-oRecomText").value = ans.rec; 
                document.getElementById("a-oPendingsText").value = ans.pen; 

        });
}
function updateOdetails()
{
        var info = {};
        info.ocode = actualOrderData.CODE;

        info.obs = document.getElementById("a-oDetailsText").value;
        info.rec = document.getElementById("a-oRecomText").value;
        info.pen = document.getElementById("a-oPendingsText").value;
        
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

                if(aud.TYPE == "A"){pcostField.value = valCost;}
                else{pcostField.value = "-";}

                pdescField.value = valDesc;
                
                pdescField.disabled = true;
                pcostField.disabled = true;
                pdocField.disabled = true;
        }
}
function setOthersForm(value) 
{
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
                odescField.value = value;
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
        
        
        
        sendAjax("users","saveoPart",info,function(response)
	{
		var ans = response.message;
		refreshoParts();
	});
}
function addOther()
{
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
        
        sendAjax("users","getParentSucus",info,function(response)
	{
		var pas = response.message;
                parents = pas.parents;
                sucus = pas.sucus;

                var a_order_parentField = document.getElementById("a-orderParent");
                var a_order_sucuField = document.getElementById("a-orderSucu");
                var f_order_parentField = document.getElementById("f-orderParent");
                var f_order_sucuField = document.getElementById("f-orderSucu");
                var a_orderMaquisField = document.getElementById("a-orderMaquis");

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
                        var a_order_sucuField = document.getElementById("a-orderSucu");
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
                        info.mode = "Ext";
                        
                        actualMaquisList = [];
                        
                        sendAjax("users","getMaquiListSelect",info,function(response)
                        {
                                var ans = response.message;
								console.log(ans)

                                var a_orderMaquisField = document.getElementById("a-orderMaquis");
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
                
	});
}
function refreshOrderParentsCL()
{
        var info = {};
        
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
	
	
	// pickBox.innerHTML = "";
	
	if(files.length > 10)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar hasta 10 fotos Iniciales", 300);
		pickSelector.value = "";
		return;
	}

	// RECORRE LOS ARCHIVOS SELECCIONADOS
	for (var i = 0; i < files.length; i++) 
	{
		// SOLO PROCESA IMAGENES
		var f = files[i];
		files[i].name = "ini-"+files[i].name;
		if (!f.type.match('image.*')){continue;}
		
		var reader = new FileReader();
		reader.readAsDataURL(f);
		reader.onload = function(event)
		{
			var resize_width = 600;
			
			var img = new Image();
			img.src = event.target.result;
			img.name = event.target.name;
			img.size = event.target.size;
			
			img.onload = function(el)
			{
				var elem = document.createElement('canvas');//create a canvas
				var scaleFactor = resize_width / el.target.width;
				elem.width = resize_width;
				elem.height = el.target.height * scaleFactor;

				var ctx = elem.getContext('2d');
				ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
				
				var pic = ctx.canvas.toDataURL('image/jpeg', 0.7);

				// CREA MINIATURA CON CLICK ZOOM
				var span = document.createElement('span');
				span.innerHTML = ['<img class="imageBoxView" src="', pic, '" title="', escape(event.name), '"/>'].join('');
				pickBox.appendChild(span, null);
				span.path = event.target.result;
				span.onclick = function()
				{showPicBox(this.path, "Foto inicial", "ini");}
				
				// AGREGA AL ARREGLO DE IMAGENES
				
				initialPics.push(pic);
			}
		}
	}
}
function handleFileSelectEnd(evt) 
{
	var files = evt.target.files; // FileList object
	var pickBox = document.getElementById('picturesBoxEnd');
	var pickSelector = document.getElementById('picSelectorEnd');
	// finalPics = [];
	
	// pickBox.innerHTML = " ";
	
	if(files.length > 10)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar hasta 10 fotos Finales", 300);
		pickSelector.value = "";
		return;
	}

	// RECORRE LOS ARCHIVOS SELECCIONADOS
	for (var i = 0; i < files.length; i++) 
	{
		// SOLO PROCESA IMAGENES
		var f = files[i];
		files[i].name = "end-"+files[i].name;
		if (!f.type.match('image.*')){continue;}
		
		var reader = new FileReader();
		reader.readAsDataURL(f);
		reader.onload = function(event)
		{
			var resize_width = 600;
			
			var img = new Image();
			img.src = event.target.result;
			img.name = event.target.name;
			img.size = event.target.size;
			
			img.onload = function(el)
			{
				var elem = document.createElement('canvas');//create a canvas
				var scaleFactor = resize_width / el.target.width;
				elem.width = resize_width;
				elem.height = el.target.height * scaleFactor;

				var ctx = elem.getContext('2d');
				ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
				
				var pic = ctx.canvas.toDataURL('image/jpeg', 0.7);
				
				// CREA MINIATURA CON CLICK ZOOM
				var span = document.createElement('span');
				span.innerHTML = ['<img class="imageBoxView" src="', pic, '" title="', escape(event.name), '"/>'].join('');
				pickBox.appendChild(span, null);
				span.path = event.target.result;
				span.onclick = function()
				{showPicBox(this.path, "Foto Final", "end");}
				
				// AGREGA AL ARREGLO DE IMAGENES
				
				finalPics.push(pic);
			}
		}
	}
}
function handleFileSelectOrder(evt) 
{
    var files = evt.target.files; // FileList object
	var pickBox = document.getElementById('picturesBoxOrder');
	var pickSelector = document.getElementById('picSelectorOrder');
	// orderPics = [];
	
	// pickBox.innerHTML = " ";
	
	if(files.length > 10)
	{
		alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puedes agregar hasta 10 fotos de orden", 300);
		pickSelector.value = "";
		return;
	}

	// RECORRE LOS ARCHIVOS SELECCIONADOS
	for (var i = 0; i < files.length; i++) 
	{
		// SOLO PROCESA IMAGENES
		var f = files[i];
		files[i].name = "end-"+files[i].name;
		if (!f.type.match('image.*')){continue;}
		
		var reader = new FileReader();
		reader.readAsDataURL(f);
		reader.onload = function(event)
		{
			var resize_width = 600;
			
			var img = new Image();
			img.src = event.target.result;
			img.name = event.target.name;
			img.size = event.target.size;
			
			img.onload = function(el)
			{
				var elem = document.createElement('canvas');//create a canvas
				var scaleFactor = resize_width / el.target.width;
				elem.width = resize_width;
				elem.height = el.target.height * scaleFactor;

				var ctx = elem.getContext('2d');
				ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
				
				var pic = ctx.canvas.toDataURL('image/jpeg', 0.7);
				
				// CREA MINIATURA CON CLICK ZOOM
				var span = document.createElement('span');
				span.innerHTML = ['<img class="imageBoxView" src="', pic, '" title="', escape(event.name), '"/>'].join('');
				pickBox.appendChild(span, null);
				span.path = event.target.result;
				span.onclick = function()
				{showPicBox(this.path, "Foto Órden", "ord");}
				
				// AGREGA AL ARREGLO DE IMAGENES
				
				orderPics.push(pic);
			}
		}
	}
}
function handleFileSelectBudget(evt) 
{
        var files = evt.target.files; // FileList object
        var pickSelector = document.getElementById('budgetSelectorOrder');
        actualLoadType = "bud";
		
		loadFileName = files[0].name;
		
        if(files.length > 1)
        {
			alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>You can only load one file.", 300);
			pickBox.innerHTML = "";
			pickSelector.value = "";
			return;
        }
        
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0; i < files.length; i++) 
        {
			// Only process image files.
			var f = files[i];
			console.log(files[i].size);
			
			if(parseFloat(files[i].size) > 10000000)
			{
				pickSelector.value = "";
				alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Tamaño máximo de archivo 10000Kb", 300);
				return;
			}

			var reader = new FileReader();

        }
		
		document.getElementById("upButtonBudget").click();
		$("#loaderDiv").show();
		
		pickSelector.value = "";
		
		return;
		
		
}
function loadPics(param)
{
	actualLoadType = param;
	
	var pickSelector = document.getElementById("picSelector"+param);

	var info = {}
	
	if(param == "Ini")
	{
		info.field = "OINIPICS";
		if(initialPics.length == 0)
		{
			alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar por lo menos una imagen para cargar",300);
			return;
		}
		var pics = JSON.stringify(initialPics);
		
	}
	if(param == "End")
	{
		info.field = "OENDPICS";
		if(finalPics.length == 0)
		{
			alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar por lo menos una imagen para cargar",300);
			return;
		}
		var pics = JSON.stringify(finalPics);
	}
	if(param == "Order")
	{
		info.field = "OORDPICS";
		if(orderPics.length == 0)
		{
			alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar por lo menos una imagen para cargar",300);
			return;
		}
		var pics = JSON.stringify(orderPics);
	}
	
	info.pics = pics;
	info.order = actualOrderCode;
	
	console.log(info)
	
	sendAjax("users","saveOpics",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		 alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Carga completada",300);
		 
		// $("#loaderDiv").hide();
		 
	});
	
	
	// OBSOLET LOAD METHOD
	
	// document.getElementById(param+'_upload_process').style.display = 'block';
	
	// document.getElementById("upButton"+param).click();
	// $("#loaderDiv").fadeIn();
}
// OBSOLET LOAD RESPONSES
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
        
        document.getElementById("picSelector"+actualLoadType).value = "";
		
		$("#loaderDiv").hide();
}
function loadFinishB(result)
{

	console.log(result);
	if (result == 1)
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Carga completada",300);
		saveFilePath();
	}
	else 
	{
		alertBox("Información","<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Error en la carga",300);
	}
	document.getElementById("budgetSelectorOrder").value = "";
        
}
function saveFilePath()
{
	
	
	var info = {};
	info.ocode = actualLoadOrder;
	info.fileLink = loadFileName;
	sendAjax("users","setFileLink",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		ordeGet();
		$("#loaderDiv").hide();
	});

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
					
					if(actualUtype == "C")
					{
						console.log(aud.CODE);
						document.getElementById("a-maquiParent").value = aud.CODE;
						document.getElementById("a-maquiParent").disabled = true;
						a_maqui_parentField.onchange();
						
						document.getElementById("f-maquiParent").value = aud.CODE;
						document.getElementById("f-maquiParent").disabled = true;
						f_maqui_parentField.onchange();
						
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
		console.log(ans)
		actualChecks = ans.checks;
		var maquis = ans.maquis;
		tableCreator("maquisTable", maquis);
	});
}
function maquiSave(item)
{
        
		if(actualUtype == "C")
		{
			alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No puedes realizar esta acción", 300);
			return;
		}

		
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
					alertBox(language["alert"], language["sys025"],300);
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
			info.editCode = actualEditMaquiCode;
			console.log(info)
			sendAjax("users","maquiSave",info,function(response)
			{
				var ans = response.message;
				
				if(ans == "existedit")
				{
					alertBox(language["alert"], language["sys025"],300);
				}
				

				alertBox(language["alert"], language["sys004"],300);
				clearFields(a_maqui_targets, "a-maqui");
				maquiSaveButton.innerHTML = "Crear";
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
        else if(info["a-techiName"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un nombre de técnico",300); return}
        else if(info["a-techiCat"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una categoría",300); return}
        else if(info["a-techiMastery"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir una especialidad",300); return}
        else if(info["a-techiEmail"] == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes escribir un Email",300); return}
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
function setActFields()
{
	var desc = document.getElementById("a-orderActiPicker").value;
	var picked = "";
	
	// console.log(actiPlist);
	
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
		document.getElementById("a-orderActPricePicker2").value = picked.COSTMAT;
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
	var price2 = document.getElementById("a-orderActPricePicker2").value;
	var duration = document.getElementById("a-orderActiPicker").duration;
	
	if(qty == ""){qty = 0;}
	if(price == ""){price = 0;}
	if(price2 == ""){price2 = 0;}
	if(duration == ""){duration = 0;}

	document.getElementById("a-orderActSubtotalPicker").value = parseFloat(qty)*(parseFloat(price)+parseFloat(price2));
	
	document.getElementById("a-orderActDurationPicker").value = parseFloat(qty)*parseFloat(duration);
	
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
        sendAjax("users","getOrdeList",info,function(response)
	{
		var ans = response.message;
		maquiCodePlates = response.maquis;
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
		option.value = maqui.CODE;
		if(maqui.NAME == "Locativas")
		{
			option.innerHTML = maqui.NAME;
		}
		else
		{
			option.innerHTML = maqui.NAME+" > "+maqui.PLATE;
		}
		
		
		inputBox.appendChild(option);
		
		if(actualMaquiPicks.in_array(maqui.CODE))
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
				if(actualMaquisList[j].CODE == actualPick)
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
       
	  
	 console.log(info);
        
	if(info.otype == "c")
	{
		info.optype = ltt1;

		sendAjax("users","orderSave",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
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
			console.log(ans)
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
function addAct()
{

		var maqui = document.getElementById("a-orderDetailMaquis").value.split(">")[0];
        var actiAll = document.getElementById("a-orderActiPicker").value;
		var actiCode = document.getElementById("a-orderActiPicker").code;
		var actiDuration = document.getElementById("a-orderActDurationPicker").value;
        var maquicode = document.getElementById("a-orderDetailMaquis").value.split(">")[1];
        
        if(maqui == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una maquina",300); return}
        if(actiAll == ""){alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debes seleccionar una actividad",300); return}
		
		var actQty = document.getElementById("a-orderActQtyPicker").value;
		var actUniVal = document.getElementById("a-orderActPricePicker").value;
		var actUniVal2 = document.getElementById("a-orderActPricePicker2").value;
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
        info.actUniVal2 = actUniVal2;
        info.actiDesc = actiDesc;
        info.actiCost = actiCost;
        info.actiDuration = actiDuration;
        info.maqui = maqui;
        info.maquiCode = maquicode;
        info.maquiName = ($("#a-orderDetailMaquis option:selected").text().split(" >" ))[0];
        info.tech = actualOrderData.TECHNAME;
        info.techcode = actualOrderData.TECHCODE;
        info.occode = actualOrderData.CCODE;
		info.editingAct = editingAct;
		
		if(editingAct == "1")
		{
			info.actualActCode = actualActCode;
		}
		else
		{
			info.actualActCode = "";
		}
		
        
		console.log(info)
		
		// return;
		

        sendAjax("users","saveoAct",info,function(response)
        {
                var ans = response.message;
				console.log(ans);
                document.getElementById("a-orderDetailMaquis").value = "";
                document.getElementById("a-orderActiPicker").value = "";
                editingAct = 0;
				
				
				
				document.getElementById("a-orderDetailMaquis").value = ""
				document.getElementById("a-orderActiPicker").value = ""
				document.getElementById("a-orderActiPicker").code = "";
				document.getElementById("a-orderActiPicker").duration = "";
				document.getElementById("a-orderActQtyPicker").value = ""
				document.getElementById("a-orderActPricePicker").value = ""
				document.getElementById("a-orderActPricePicker2").value = ""
				document.getElementById("a-orderActDurationPicker").value = ""
				document.getElementById("a-orderActSubtotalPicker").value = ""
				document.getElementById("addActButton").innerHTML = "Agregar";
			
				
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
                document.getElementById("a-orderDetailMaquis").value = "";
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

	formBox("actPriceEdit","Editar costo por unidad",300);
}
function refreshoParts()
{
        var info = {};
        info.ocode = actualOrderData.CODE;
        
        sendAjax("users","getOParts",info,function(response)
        {
                var list = response.message;
                console.log(list)
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
        info.diedate = getNow(parseFloat(document.getElementById("recLife").value));
        if(document.getElementById("retCheck").checked){info.retCheck = "1";}else{info.retCheck = "0";}
        
        info.life = document.getElementById("recLife").value;
        
        
        if(info.life == "")
        {
			alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Debe escribir el número de dias de vigencia de la factura", 300);
			return;
        }
        
		// ---------------------TEST COMMENT REMOVE ON PRODUCTIVE
        document.getElementById("sendPrefacButton").onclick = function(){console.log("locked")}
		// ---------------------
		
        sendAjax("users","generateRecepit",info,function(response)
        {
                
                var ans = response.message;
				
				// ---------------------TEST BLOCK REMOVE ON PRODUCTIVE
				// console.log(ans);
				// downloadReport(ans);
				// return;
				// ------------------------
				
                
                if(ans == "fullres")
                {
					alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha agotado la resolución de facturación, debe ingresar una nueva para continuar facturando", 300);
					return;
                }
                
                hide_pop_form();
                alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Se ha generado exitosamente la pre liquidación", 300);
                // ifLoad('ifMasterF');
				console.log(ans)
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
        tableClear("orderSessions");
        tableClear("actisPacti");
        tableClear("costmats");
        
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
        else if(pick == "11"){actualReport = "orderSessions";}
        else if(pick == "12"){actualReport = "actisPacti";}
        else if(pick == "13"){actualReport = "costmats";}

        
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
        var repoIniDate = fieldCreator([12,4,4,1], "Fecha Inicial", "input", "repoIniDate");
        var repoEndDate = fieldCreator([12,4,4,1], "Fecha Final", "input", "repoEndDate");
        var repoOrderNum = fieldCreator([12,4,4,2], "OTT", "input", "repoOrderNum");
        var repoRepu = fieldCreator([12,4,4,2], "Repuesto", "select", "repoRepu");
        var repoOtype = fieldCreator([12,4,4,2], "Tipo", "select", "repoOtype");
        var repoTech = fieldCreator([12,4,4,2], "Técnico", "select", "repoTech");
        var repoActi = fieldCreator([12,4,4,2], "Actividad", "select", "repoActi");
        var repoState = fieldCreator([12,4,4,2], "Estado", "select", "repoState");
        
        var searchButton = buttonCreator([12,4,4,1], "Buscar", reposearch)
        var exportButton = buttonCreator([12,4,4,1], "Exportar", reposearchExp)
        
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
                box.appendChild(repoState);
                box.appendChild(repoOrderNum);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(exportButton);
				box.appendChild(searchButton);
                
                refreshRepoParents();
				refreshStateParents(1)
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
		else if(type == "orderSessions")
        {
                // box.appendChild(repoParent);
                // box.appendChild(repoSucu);
                box.appendChild(repoTech);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                // refreshRepoParents();
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
		else if(type == "costmats")
        {
                box.appendChild(repoParent);
                box.appendChild(repoSucu);
                box.appendChild(repoTech);
                box.appendChild(repoIniDate);
                box.appendChild(repoEndDate);
                box.appendChild(searchButton);
                
                refreshRepoParents();
                refreshTechParents();
				

				// setTimeout(function()
				// {
					// document.getElementById("repoParent").value = "66ced461eda5c9f99dacbeee114e1c09";
					// document.getElementById("repoParent").onchange();
					
					// setTimeout(function()
					// {
						// document.getElementById("repoSucu").value = "Cínica San Rafael";
						
						// setTimeout(function()
						// {
							// document.getElementById("repoTech").value = "David Andrés López Rivas";
						
						// }, 500)
						
						
						
					
					// }, 500)
					
					
					
				
				// }, 500)
				
        }
        
        jQuery('#repoIniDate').datetimepicker();
        jQuery('#repoEndDate').datetimepicker();
}
function refreshStateParents(mode)
{
        var picker = document.getElementById("repoState");
        picker.innerHTML = "";
        
        var option = document.createElement("option");
        option.value = "";
        option.innerHTML = "Estado de orden";
        picker.appendChild(option);
		
		var option = document.createElement("option");
        option.value = "1";
        option.innerHTML = "Nueva";
		
		if(mode == 1)
		{
			picker.appendChild(option);
		}
       
		
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
					option.value = techs[i].RESPNAME;
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
function reposearchExp()
{
	exportFile = 1;
	reposearch();
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
		
		if(actualReport == "ordersR")
		{
			for(var i = 0; i<filters.length-2; i++){var filter = filters[i].children[1];fields.push(filter.id);}
		}
		else
		{
			for(var i = 0; i<filters.length-1; i++){var filter = filters[i].children[1];fields.push(filter.id);}
		}
        
		for(var i=0; i<fields.length; i++)
        {
			info[fields[i]] = document.getElementById(fields[i]).value;
			if(fields[i] == "repoOrderNum")
			{
				info[fields[i]] = parseFloat(document.getElementById(fields[i]).value);
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
			console.log(response)
			console.log(response.message)
			
			
			tableCreatorRepo(actualReport, list);
			
			if(actualReport == "ordersR")
			{
				if(exportFile == 1)
				{
					var url = "excel/"+response.file;
					downloadReport(decry(url));
					exportFile = 0;
				}
			}
			
			if(actualReport == "costmats")
			{
				
				var url = "excel/"+response.file;
				downloadReport(decry(url));
				exportFile = 0;
				
				if(exportFile == 1)
				{
					
				}
			}
			
			
			
        });

}
function tableCreatorRepo(tableId, list)
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

                return;
        }
        // COSTMATS STORY
        if(tableId == "costmats")
        {

                for(var i=0; i<list.length; i++)
                {
                        var row = document.createElement("div");
                        row.className = "rowT";
                        
                        var a = cellCreator('Cliente',  list[i].PARENTNAME);
						var b = cellCreator('Sucursal',  list[i].SUCUNAME);
						
                        var num = list[i].CCODE;
                        if(num.length == 1){num = "000"+num;}
                        else if(num.length == 2){num = "00"+num;}
                        else if(num.length == 3){num = "0"+num;}
                        else{num = num;}
                        var c = cellCreator('Orden', num);
						var d = cellCreator('Fecha', list[i].DATE);
						var e = cellCreator('Técnico', list[i].TECHLINENAME);
						var f = cellCreator('Mano de obra', addCommas(list[i].THISTECHMOVAL));
						var g = cellCreator('Materiales', addCommas(list[i].THISTECHMAVAL));
						

                        var cells = [a,b,c,d,e,f,g];
                        for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
                        table.appendChild(row);
                        
                        costTotal += parseFloat(list[i].ACOST);
                }

                // var line = ["", "", "Total costo actividades Antes de Impuestos", addCommas(costTotal), "", ""];
                // var totalRow = enderRow(line);
                // table.appendChild(totalRow);
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
						
						
                        var d = cellCreator('Técnico', fixAssigned(list[i].TECHNAME));
                        
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
                        
                        costTotal += parseFloat(list[i].ACOST);
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
					// var label = maquiList[x];
					var label = getPlateFromCode(maquiList[x]);
					
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

				var stime = getSessionTime(list[i].STIME)+" h";

				var f = cellCreator('Fecha Atención', stime);
				
				if(list[i].TECHNAME == null)
				{
					var techName = "['-']";
				}
				else
				{
					var techName = list[i].TECHNAME;
				}
				
	
				
				
				var m = cellCreator('Fecha Atención', fixAssigned(techName));
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
				if(list[i].STATE == "6"){var state = "Anulada"}
				
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
				
				costTotal += parseFloat(list[i].TOTALCOST);
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
                                // var label = maquiList[x];
								var label = getPlateFromCode(maquiList[x]);
                                
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
                                span.onclick = function(){showPicBox(this.path, "Foto inicial", "ini");};abox.appendChild(span);
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
                                span.onclick = function(){showPicBox(this.path, "Foto Final", "end");};dbox.appendChild(span);
                        }
                        
                        var f = picellCreator('Imagenes Iniciales', abox);
                        var g = picellCreator('Imagenes Finales', dbox);
 
                        var icons = [];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g];
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
                        
                        costTotal += parseFloat(list[i].ACOST);
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
                        
                        costTotal += parseFloat(list[i].ACOST);
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
                        
                        costTotal1 += parseFloat(list[i].PCOST);
                        costTotal2 += parseFloat(list[i].PAMOUNT);
                        costTotal3 += parseFloat(subtotal);
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
                        
                        costTotal1 += parseFloat(list[i].COST);
                        costTotal2 += parseFloat(list[i].AMOUNT);
                        costTotal3 += parseFloat(subtotal);
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
                        
                        costTotal1 += parseFloat(list[i].COST);
                        costTotal2 += parseFloat(list[i].AMOUNT);
                        costTotal3 += parseFloat(subtotal);
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
                        
                        costTotal1 += parseFloat(list[i].REALCOST);
                        costTotal2 += parseFloat(list[i].PAMOUNT);
                        costTotal3 += parseFloat(subtotal);
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
					// var label = maquiList[x];
					var label = getPlateFromCode(maquiList[x]);
					
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
					var e = cellCreator('Técnico', fixAssigned(list[i].TECHNAME));
				}
				
				
				var f = cellCreator('Detalle', list[i].DETAIL);
				
				
				var addTime = list[i].STIME;
				var stime = getSessionTime(list[i].STIME)+" h";
				var j = cellCreator('Tiempo/Horas', stime);

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
				var cells = [a,b,c,d,e,f,j,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);

				
				timeTotal += parseFloat(addTime);
			}
			
			timeTotal = getSessionTime(timeTotal);
			
			var line = ["", "", "", "",  "",  "Total horas", timeTotal, "Ordenes"+list.length, ""];
			var totalRow = enderRow(line);
			table.appendChild(totalRow);
                
        }
		// ORDER TIMES
        if(tableId == "orderSessions")
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
				var a1 = cellCreator('Cliente', list[i].PARENTNAME);
				var a2 = cellCreator('Sucursal', list[i].SUCUNAME);
				var b = cellCreator('Técnico', fixAssigned(list[i].TECHNAME));
				var c = cellCreator('Inicio',  list[i].INIDATE);
				var d = cellCreator('Fill',  list[i].ENDATE);
				
				var minuts = minDiff(list[i].INIDATE, list[i].ENDATE);
				
				var addTime = minuts;

				var stime = getSessionTime(minuts)+" h";
				
				var e = cellCreator('Fill',  stime);
				var f = cellCreator('Fill',  list[i].DETAILS);
				
				var cells = [a,a1,a2,b,c,d,e,f];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);

				
				timeTotal += parseFloat(addTime);
			}
			
			timeTotal = getSessionTime(timeTotal);
			
			var line = ["", "",  "", "", "",  "Total horas", timeTotal];
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

                        
                        timeTotal += parseFloat(addTime);
                        
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

// TABLES ------------------------
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
                        
                        if(aud.TYPE == "A"){document.getElementById("oEstimated").innerHTML = etimeTotal+" Minutos";document.getElementById("oActotal").innerHTML = addCommas(actisTotal);}else{document.getElementById("oEstimated").innerHTML = etimeTotal+" Minutos";document.getElementById("oActotal").innerHTML = "-";}setTotals();
                }
                if(tableId == "oPartsTable")
                {
                         partsTotal = 0;
                        
                        if(aud.TYPE == "A"){document.getElementById("oReptotal").innerHTML = addCommas(partsTotal);}else{document.getElementById("oReptotal").innerHTML = "-";}setTotals();
                }
                if(tableId == "oOthersTable")
                {
                         othersTotal = 0;
                        
                        if(aud.TYPE == "A"){document.getElementById("oOtherstotal").innerHTML = addCommas(othersTotal);}else{document.getElementById("oOtherstotal").innerHTML = "-";}setTotals();
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

                        var icons = [edit, pass, del, disable];
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
						
					
					if(actualUtype == "C")
					{
						alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No puedes realizar esta acción", 300);
						return;
					}
					
					
					if(this.reg.PLATE.split("-")[1] == "Locativas"){return;}
					
					editMode = 1;
					var info = this.reg;
					
					var targets = ["a-maquiPlate", "a-maquiName", "a-maquiModel", "a-maquiSerial", "a-maquiVolt", "a-maquiCurrent", "a-maquiPower", "a-maquiPhase", "a-maquiDetails"];
					var items = [info.PLATE, info.NAME, info.MODEL, info.SERIAL, info.VOLT, info.CURRENT, info.POWER, info.PHASES, info.DETAIL];
					infoFiller(items, targets);
					
					
					actualEditMaquiCode = this.reg.CODE;
					
					console.log(this.reg.PLATE)
					console.log(actualEditMaquiCode)
					
					if(this.reg.PLATE.split("-")[1] == "Locativas")
					{
						document.getElementById("a-maquiParent").disabled = true;
						// document.getElementById("a-maquiPlate").disabled = true;
						// document.getElementById("a-maquiSucu").disabled = true;
						document.getElementById("a-maquiName").disabled = true;
					}
					else
					{
						document.getElementById("a-maquiParent").disabled = true;
						// document.getElementById("a-maquiPlate").disabled = true;
						// document.getElementById("a-maquiSucu").disabled = true; 
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

				var linkCheck = document.createElement("img");
				linkCheck.src = "irsc/detailIcon.png";
				linkCheck.reg = list[i];
				linkCheck.setAttribute('title', 'Vincular checklist');
				linkCheck.setAttribute('alt', 'Vincular checklist');
				linkCheck.onclick = function()
				{
					
					if(actualUtype == "C")
					{
						alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No puedes realizar esta acción", 300);
						return;
					}
					
					actualCheckList = this.reg.CHECKLIST;
					showLinkPop(this.reg.CODE);
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
					
					if(actualUtype == "C")
					{
						alertBox(language["alert"], "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>No puedes realizar esta acción", 300);
						return;
					}
					
					
					if(this.reg.PLATE.split("-")[1] == "Locativas"){return;}

					var tableId = this.parentNode.parentNode.parentNode.id;
					var param = [tableId, this.reg.PLATE];
					
					confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}

				var icons = [edit, history, linkCheck, del];
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
                        var c = cellCreator('Categoría', list[i].CATEGORY)
                        var d = cellCreator('Especialidad', list[i].MASTERY)
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

                                var items = [decry(info.NIT), decry(info.RESPNAME), info.CATEGORY, info.MASTERY, info.MAIL, info.ADDRESS, info.PHONE, info.DETAILS];
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
                                pssChange(this.reg.MAIL, "T");
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
                        disable.setAttribute('title', 'Cambiar estado');
                        disable.setAttribute('alt', 'Cambiar estado');
                        disable.onclick = function()
                        {
                                var data = this.reg;
                                var info = {};
                                info.code = data.CODE;
                                info.actual = data.STATUS;
                                

                                sendAjax("users","changeTechState",info,function(response)
                                {
                                        var ans = response.message;
										techisGet()
                                });
                        }
                        
                        if(list[i].STATUS == "0")
                        {
                               disable.src = "irsc/disableIconG.png"; 
                        }
						
						
						
                        var icons = [edit, pass, del, disable];
                        var x = cellOptionsCreator('', icons)
                        var cells = [a,b,c,d,e,f,g,h,x];
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
                        var e = cellCreator('Valor MO', addCommas(list[i].COST))
                        var f = cellCreator('Valor Materiales', addCommas(list[i].COSTMAT))
                        
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
                                var items = [info.ACTYPE, info.DESCRIPTION, info.DURATION, info.COST, info.COSTMAT];
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
                        var cells = [a,b,c,d,e,f,x];
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
                        var sellValue = parseFloat(list[i].COST)+((parseFloat(list[i].COST)*parseFloat(list[i].MARGIN))/100);
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
			console.log(list)
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				
				console.log(list[i])
				
				var a = cellCreator('Cliente', list[i].PARENTNAME)
				
				
				
				if(list[i].SUCUNAME == "-")
				{
					var b = cellCreator('Sucursal', list[i].SUCUCODE);
				}
				else
				{
					var b = cellCreator('Sucursal', list[i].SUCUNAME);
				}
				
				// var b = cellCreator('Sucursal', list[i].SUCUNAME)
				
				
				
				
				var maquiList = JSON.parse(list[i].MAQUIS);
				
				var maquis = "";
				for(var x=0; x<maquiList.length; x++)
				{
					var label = getPlateFromCode(maquiList[x]);
					
					
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
				
				
				
				if(list[i].STATE == "1"){var state = "Nueva"}
				if(list[i].STATE == "2"){var state = "Proceso"}
				if(list[i].STATE == "3"){var state = "Revisión"}
				if(list[i].STATE == "4"){var state = "Por facturar"}
				if(list[i].STATE == "5"){var state = "Facturada"}
				if(list[i].STATE == "6"){var state = "Anulada"}
				
				var g = cellCreator('Estado', state);
				var h = cellCreator('Autor', list[i].AUTOR);
				
				if(list[i].OTYPE == "1")
				{var otype = "Gene";}
				
				if(list[i].OTYPE == "2")
				{var otype = "Prev";}
			
				if(list[i].OTYPE == "3")
				{var otype = "Corr";}
			
				if(list[i].OTYPE == "4")
				{var otype = "Loca";}
				
				if(list[i].OTYPE == "5")
				{var otype = "Otr";}
				
				
				var t = cellCreator('Tipo', otype);
				
				
				
				
				
				var edit = document.createElement("img");
				edit.src = "irsc/editIcon.png";
				edit.reg = list[i];
				edit.setAttribute('title', 'Editar');
				edit.setAttribute('alt', 'Editar');
				edit.onclick = function()
				{
						
					editMode = 1;
					var info = this.reg;
					var items = [info.PRIORITY, info.DETAIL, info.ICODE, info.OTYPE];
					var targets = ["a-orderPriority", "a-orderDesc", "a-orderOrderClient", "a-orderType"];
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
				asign.src = "irsc/techIcon.png";
				asign.reg = list[i];
				asign.setAttribute('title', 'Asignar Técnico');
				asign.setAttribute('alt', 'Asignar Técnico');
				asign.onclick = function()
				{
						var info = this.reg;
						if(info.TECHCODE == "" || info.TECHCODE == null)
						{
							actualAssT = [];
						}
						else
						{
							if(info.TECHCODE.includes("["))
							{
								actualAssT = JSON.parse(info.TECHCODE);
							}
							else
							{
								var code = '["'+info.TECHCODE+'"]';
								actualAssT = JSON.parse(code);
							}
						}

						if(info.STATE != "1" && info.STATE != "2")
						{
								alertBox("Información", "<img src='irsc/infoGeneral.png' class='infoIcon'/><br>Solo puede asignar o modificar técnico a ordenes 'Nuevas' o en 'Proceso'", 300);
								return;
						}
						if(info.TECHCODE != null)
						{
								actualTechVal = info.TECHCODE+">"+info.TECHNAME;
						}
						else
						{
								actualTechVal = null;
						}
						
						sendAjax("users","getTechiListO","",function(response)
						{
								var ans = response.message;
								
								actualTechList = ans;
								asignTechBox(info.CODE, info.CCODE);
								
						});
				}
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
					actualDelOrderCode = this.reg.CODE;
					formBox("delOrderBox","Eliminar orden",300);
					
					
					// confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}
				
				var deleted = document.createElement("img");
				deleted.src = "irsc/delIcon.png";
				deleted.reg = list[i];
				deleted.setAttribute('title', 'Eliminar');
				deleted.setAttribute('alt', 'Eliminar');
				deleted.onclick = function()
				{
					var detail = this.reg.DELDET;
					alertBox("Detalles de eliminación", detail, 350);
				}
				
				
				var upload = document.createElement("img");
				upload.src = "irsc/upload.png";
				upload.reg = list[i];
				upload.setAttribute('title', 'Upload file');
				upload.setAttribute('alt', 'Upload file');
				upload.onclick = function()
				{
					
					var info = this.reg;
					var picker =document.getElementById("budgetSelectorOrder");
					actualLoadOrder = info.CODE;
					picker.click();
					picker.name = info.CODE+"[]";

				}
				
				var download = document.createElement("img");
				download.src = "irsc/downIcon.png";
				download.reg = list[i];
				download.setAttribute('title', 'Download file');
				download.setAttribute('alt', 'Download file');
				download.onclick = function()
				{
					
					var info = this.reg;
					var filename = info.FILELINK;
					var url = "files/"+info.CODE+"/"+filename;
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
						var icons = [edit, asign, detail, del, selector];
				}
				else if(list[i].STATE == "5")
				{
						var icons = [detail];
				}
				else
				{
						var icons = [edit, asign, detail, del];
				}
				
				if(list[i].FILELINK != "")
				{
					icons.push(upload, download)
				}
				else
				{
					icons.push(upload)
				}
				
				var stater = document.createElement("img");
				stater.src = "irsc/detailIcon.png";
				stater.reg = list[i];
				stater.setAttribute('title', 'Cambiar estado');
				stater.setAttribute('alt', 'Cambiar estado');
				stater.onclick = function()
				{
					setStatusPop(this.reg.CODE, this.reg.STATE)
				}
			
				if(list[i].STATE != "5")
				{
					icons.push(stater)
				}
				
				if(list[i].STATE == "6")
				{
					icons = [deleted];
				}
				
				var deta = encry(list[i].DETAIL);
				// var deta = "lol";
				console.log(deta)
				var f = cellCreator('Detalle', deta);
				
				var x = cellOptionsCreator('', icons)
				
				
				
				var cells = [a,b,t,c,n,m,d,e,f,g,h,x];
				// var cells = [a];
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
   
                        var c = cellCreator('Descripción', escape(encry(list[i].ADESC)));
                        var d = cellCreator('Duración', list[i].ADURATION);
                        var d1 = cellCreator('Cantidad', list[i].UNIVALUE);
                        var d2 = cellCreator('Valor MO', addCommas(list[i].UNIPRICE));
                        var d3 = cellCreator('Valor Materiales', addCommas(list[i].UNICOSTMAT));
                        
                        etimeTotal = etimeTotal+parseFloat(list[i].ADURATION);
                        actisTotal = actisTotal+(parseFloat(list[i].UNIPRICE)*parseFloat(list[i].UNIVALUE))+(parseFloat(list[i].UNICOSTMAT)*parseFloat(list[i].UNIVALUE));
                        
                        if(aud.TYPE == "A")
                        {
                                var e = cellCreator('Valor', addCommas(list[i].UNIVALUE*list[i].UNIPRICE+list[i].UNIVALUE*list[i].UNICOSTMAT));
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
							
							editingAct = 1;
							actualActCode = info.CODE;
							actualCost = info.UNIPRICE;
							
							console.log(info)
							
							document.getElementById("a-orderDetailMaquis").value = info.MAQUICODE+">"+info.MAQUICODE;
							document.getElementById("a-orderActiPicker").value = info.ADESC;
							document.getElementById("a-orderActiPicker").code = info.ACODE;
							document.getElementById("a-orderActiPicker").duration = info.ADURATION;
							document.getElementById("a-orderActQtyPicker").value = info.UNIVALUE;
							document.getElementById("a-orderActPricePicker").value = info.UNIPRICE;
							document.getElementById("a-orderActPricePicker2").value = info.UNICOSTMAT;
							document.getElementById("a-orderActDurationPicker").value = info.ADURATION;
							document.getElementById("a-orderActSubtotalPicker").value = info.ACOST;
							document.getElementById("addActButton").innerHTML = "Guardar";

							
							// editActPrice();
                                
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
                        var cells = [a,b,c, d,d1, d2, d3, e, x];
                        
                        
                        
                        for(var r=0; r<cells.length; r++)
                        {
      
                                row.appendChild(cells[r]);
                                
                        }
                        table.appendChild(row);

                }
				
				var etime = getSessionTime(etimeTotal)+" horas";
				
                if(aud.TYPE == "A"){document.getElementById("oEstimated").innerHTML = etime;document.getElementById("oActotal").innerHTML = addCommas(actisTotal);}else{document.getElementById("oEstimated").innerHTML = etime; document.getElementById("oActotal").innerHTML = "-";}setTotals();
                
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
						
						var desc = escape(encry(list[i].PDESC));
						// var desc = "test";
						console.log(desc);
                        var b = cellCreator('Descripción', desc);
						console.log("pass");
                        var c = cellCreator('Cantidad', list[i].PAMOUNT);
                        
                        
                        var cost = parseFloat(list[i].PAMOUNT)*parseFloat(list[i].PCOST);
                        
                        partsTotal = partsTotal+parseFloat(cost);
                        
                        if(aud.TYPE == "A")
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
                        
                        var cost = parseFloat(list[i].AMOUNT)*parseFloat(list[i].COST);
                        
                        othersTotal = othersTotal+parseFloat(cost);
                        
                        if(aud.TYPE == "A")
                        {
                                var c = cellCreator('Valor unitario', addCommas(list[i].COST));
                                var d = cellCreator('Subtotal', addCommas(cost));
                        }
                        else
                        {
                                var c = cellCreator('Valor unitario', "-");
                                var d = cellCreator('Subtotal', "-");
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
                        }
                        else
                        {
                                var icons = [del];
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
                
                if(aud.TYPE == "A"){document.getElementById("oOtherstotal").innerHTML = addCommas(othersTotal);}else{document.getElementById("oOtherstotal").innerHTML = "-";}setTotals();
        }
		// SESSIONS TABLE
        if(tableId == "sessionsTable")
        {
			var timeTotal = 0;
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Técnico', list[i].TECHNAME);
				var b = cellCreator('Inicio', list[i].INIDATE);
				var c = cellCreator('Fin', list[i].ENDATE);
				var d = cellCreator('Detalles', list[i].DETAILS);
				var e = cellCreator('Labor', list[i].LTYPE);
				
				
				var minutes = minDiff(list[i].INIDATE, list[i].ENDATE);
				timeTotal += minutes;
				var sesTime = getSessionTime(minutes);
				
				var t = cellCreator('Tiempo', sesTime);
				
				// othersTotal = othersTotal+parseFloat(cost);
				

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
					var icons = [del];
				}
				else
				{
					console.log(actualUtype)
					if(actualUtype == "T")
					{
						console.log("soy tecnico")
						console.log(list[i].TECHCODE)
						console.log(aud.CODE)
						if(list[i].TECHCODE == aud.CODE)
						{
							var icons = [del];
						}
						else
						{
							var icons = [];
						}
						
						
						
						
					}
					
					
					
					
				}
				
				if(list[i].STATUS == "1"){var icons = [];}
				
				var x = cellOptionsCreator('', icons)
				var cells = [a,b,c,e,d,t,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
			
			var line = ["","","","Total en horas",getSessionTime(timeTotal),""];
			var totalRow = enderRow(line);
			table.appendChild(totalRow);
			
			document.getElementById("oReported").innerHTML = getSessionTime(timeTotal)+" horas";
			
			
        }
		// HOLLYDAYS
        if(tableId == "hollyTable")
        {
			var timeTotal  = 0;
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				

				var a = cellCreator('Fecha',  list[i].HOLLYDATE);
				
		
				var del = document.createElement("img");
				del.src = "irsc/delIcon.png";
				del.reg = list[i];
				del.setAttribute('title', 'Eliminar');
				del.setAttribute('alt', 'Eliminar');
				del.onclick = function()
				{
					var tableId = this.parentNode.parentNode.parentNode.id;
					var param = [tableId, this.reg.HOLLYDATE];
					confirmBox(language["confirm"], language["sys011"], deleteRecord, 300, param);
				}
				
				var icons = [del];
				
				var x = cellOptionsCreator('', icons)
				
				var cells = [a,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);

				
				
			}
			
			
			
			table.appendChild(totalRow);
                
        }
		// SESSIONS TABLE MAIN
        if(tableId == "sesslistsTable")
        {
			var timeTotal = 0;
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Técnico', list[i].TECHNAME);
				var b = cellCreator('Inicio', list[i].INIDATE);
				var c = cellCreator('Fin', list[i].ENDATE);
				var d = cellCreator('Detalles', list[i].DETAILS);
				var e = cellCreator('Labor', list[i].LTYPE);
				
				
				
				if(list[i].OCODE == "-")
				{
					var stype = "Técnico";
				}
				else
				{
					var stype = "Órden";
				}
				
				var f = cellCreator('Tipo', stype);
				
				
				
				var minutes = minDiff(list[i].INIDATE, list[i].ENDATE);
				
				timeTotal += minutes;
				
				var sesTime = getSessionTime(minutes);
				
				var t = cellCreator('Tiempo', sesTime);
				
				// othersTotal = othersTotal+parseFloat(cost);
				

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

				if(aud.TYPE == "A")
				{
					var icons = [del];
				}
				else
				{
					var icons = [del];
				}
				
				if(list[i].STATUS == "1"){var icons = [];}
				
				
				var x = cellOptionsCreator('', icons)
				var cells = [f,a,b,c,e,d,t,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
			
			var line = ["","","","Total en horas",getSessionTime(timeTotal),""];
			var totalRow = enderRow(line);
			table.appendChild(totalRow);
			
			// document.getElementById("oReported").innerHTML = getSessionTime(timeTotal)+" horas";
			
			
        }
		// CHECKLISTS TABLE
        if(tableId == "checklistsTable")
        {
			
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Detalle', list[i].DETAIL);
				
				
				var actionDets = getActionsDets(list[i].CHILDREN);
				
				var b = cellCreator('Acciones', actionDets);
				

				var edit = document.createElement("img");
				edit.src = "irsc/editIcon.png";
				edit.reg = list[i];
				edit.setAttribute('title', 'Editar');
				edit.setAttribute('alt', 'Editar');
				edit.onclick = function()
				{
				
					asignActionsBox(this.reg.CODE, this.reg.CHILDREN);
					
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
				var cells = [a,b,x];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}

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
				
				var tech = fixAssigned(list[i].TECHNAME);
				var d = cellCreator('Técnico', tech)

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
				var d = cellCreator('Técnico', fixAssigned(list[i].TECHNAME));
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

				
				if(list[i].TYPE == "0")
				{
					var icons = [download];
				}
				else
				{
					var icons = [download, downloadT];
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
		// TECHPICK TABLE
        if(tableId == "techPickTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";
				
				var info = list[i].RESPNAME+" > "+list[i].CATEGORY+" > "+list[i].DETAILS;
				
				var check = document.createElement("input");
				check.type = "checkbox";
				check.code = list[i].CODE;
				check.name = list[i].RESPNAME;
				
				if(actualAssT.in_array(check.code))
				{check.checked = true;}
				
				
				var a = cellCreator("", "");
				a.appendChild(check);
				
				var b = cellCreator('Técnico', info);

				var cells = [a,b];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
		// CHECKLIST MARK TABLE
        if(tableId == "oChecksTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var a = cellCreator('Técnico', list[i].DETAIL);
				
				var check = document.createElement("input");
				check.type = "checkbox";
				check.id = list[i].CODE;
				check.ocode = list[i].OCODE;
				check.code = list[i].CODE;
				check.state = list[i].STATUS;
				check.onchange = function ()
				{
					if(this.checked)
					{var state = "1";}
					else
					{var state = "0";}
					
					var info = {}
					info.ocode = this.ocode;
					info.code = this.code;
					info.state = state;
					
					
					sendAjax("users","setCheckState",info,function(response)
					{
						var ans = response.message;
						tableCreator("oChecksTable", ans);
						
					});
					
					
				}
				
				if(check.state == "1")
				{check.checked = true;}
				
				
				var b = cellCreator("", "");
				b.appendChild(check);
				
				

				var cells = [a,b];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
        }
		// ACTIONS PICK TABLE
        if(tableId == "actionPickTable")
        {
			for(var i=0; i<list.length; i++)
			{
				var row = document.createElement("div");
				row.className = "rowT";

				var info = list[i].DETAIL;
				
				var check = document.createElement("input");
				check.type = "checkbox";
				check.code = list[i].CODE;
				check.detail = list[i].DETAIL;
				
				if(actualCheckActions.in_array(check.code))
				{check.checked = true;}
				
				
				
				var a = cellCreator("", "");
				a.appendChild(check);
				
				var b = cellCreator('Accion', info);

				var cells = [a,b];
				for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
				table.appendChild(row);
			}
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
                        
                        if(parseFloat(list[i].ACTUAL) > parseFloat(list[i].END))
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
                                // var label = maquiList[x];
								var label = getPlateFromCode(maquiList[x]);
                                
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
                        if(list[i].STATE == "6"){var state = "Anulada"}
                        
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
                                // var label = maquiList[x];
								var label = getPlateFromCode(maquiList[x]);
                                
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
                        if(list[i].STATE == "6"){var state = "Anulada"}
                        
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
function deleteOrder()
{
	var info = {};
	info.table = "orders";
	info.code = actualDelOrderCode;
	info.delType = "order";
	info.deldet = document.getElementById("deldet").value;
	info.type = "O";
	info.target = actualDelOrderCode;
	
	if(info.deldet == "")
	{
		alertBox(language["alert"], "Debe escribir la causa de cancelación", 300);
		return;
	}
	
	console.log(info);
	// return;

	sendAjax("users","regDelete",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		hide_pop_form();
		alertBox(language["alert"], language["sys012"],300);
		clearFields(a_orde_targets, "a-orde");
		ordeGet();
	});
}
function getPlateFromCode(code)
{

	for(var i=0; i<maquiCodePlates.length; i++)
	{
		var item = maquiCodePlates[i];
		if(item.CODE == code)
		{
			var plate = item.PLATE;
			return plate;
		}
		
	}
	return "*";
}
function getActionsDets(children)
{
	var codes = JSON.parse(children);
	
	var actions = "";
	
	if(codes.length > 0)
	{
		
		for(var i=0; i<codes.length; i++)
		{
			var code = codes[i]
			
			for(var j=0; j<actualActions.length; j++)
			{
				var detail = actualActions[j].DETAIL;
				if(code == actualActions[j].CODE)
				{
					if(i == (codes.length-1))
					{
						actions += detail;
					}
					else
					{
						actions += detail+", ";
					}
				}
			}
		}
		
	}
	else
	{
		actions = "";
	}
	
	return actions;
}
// SESSION AND FORMAT TIME BLOCK -------------
function getSessionTime(minutes)
{
	var totalMinutes = minutes;

    var hours = Math.floor(totalMinutes / 60);          
    var minutes = totalMinutes % 60;
	
	if(hours == 1)
	{
		var hTag = "hora";
	}
	else
	{
		var hTag = "horas";
	}
	
	return hours+":"+minutes;
 
}
function minDiff(date1, date2)
{
	var d1 = new Date(date1);
	var d2 = new Date(date2);
	var diffMs = (d2 - d1); // milliseconds between now & Christmas
	return (diffMs/1000)/60;
}
// SESSION AND FORMAT TIME BLOCK -------------
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
        console.log(code)
        sendAjax("users","getMaquiStory",info,function(response)
        {
                
                var story = response.message;
				console.log(story)
                
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

        var subtotal = parseFloat(actisTotal+partsTotal+othersTotal);
        var iva = parseFloat((subtotal*19)/100);
        
        if(aud.TYPE == "A")
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
function setStatusPop(ocode, actual)
{
	var container = document.getElementById("setStatusPopBox");
	container.innerHTML = "";
	container.style.textAlign = "center";

	var inputBox = document.createElement("select");
	inputBox.id = "statePicker";
	inputBox.className = "recMailBox";
	
	container.appendChild(inputBox);
	
	var states = ["Nueva", "Proceso", "Revisión", "Por facturar"];
	for(var i=0; i<states.length; i++)
	{
		var item = states[i];
		
		var option = document.createElement("option");
		option.value = (i+1);
		option.innerHTML = item;
		inputBox.appendChild(option);
		
	}
	
	inputBox.value = actual;
	
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = "Asignar";
	send.ocode = ocode;
	send.onclick = function()
	{
		var info = {};
		var state = document.getElementById("statePicker").value
		info.ocode = this.ocode;
		info.state = state;
		
		console.log(info)
		
		sendAjax("users","setOstate",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			ordeGet()
			hide_pop_form();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};

	container.appendChild(send);
	container.appendChild(cancel);

	formBox("setStatusPopBox","Establecer estado de orden",300);
}
function showLinkPop(ccode, list)
{
	var container = document.getElementById("showLinkPopBox");
	container.innerHTML = "";
	container.style.textAlign = "center";

	var inputBox = document.createElement("select");
	inputBox.id = "checkPicker";
	inputBox.className = "recMailBox";
	
	container.appendChild(inputBox);
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona checklist";
	inputBox.appendChild(option);
	
	for(var i=0; i<actualChecks.length; i++)
	{
		var item = actualChecks[i];
		
		var option = document.createElement("option");
		option.value = item.CODE;
		option.innerHTML = item.DETAIL;
		inputBox.appendChild(option);
		
	}
	
	
	if(actualCheckList != ""){inputBox.value = actualCheckList;}
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = "Asignar";
	send.ccode = ccode;
	send.onclick = function()
	{
		var info = {};
		var picker = document.getElementById("id")
		
		info.ccode = this.ccode;
		
		var check = document.getElementById("checkPicker").value;
		
		if(check == "")
		{
			alertBox(language["alert"], "Debe seleccionar un checklist", 300);
			return;
		}
		
		info.checklist = check;
		
		sendAjax("users","linkCheck",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			alertBox(language["alert"], language["sys004"], 300);
			maquiGet()
			hide_pop_form();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};

	container.appendChild(send);
	container.appendChild(cancel);

	formBox("showLinkPopBox","Vincular Checklist",300);
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
	
	var inputBoxBox = document.createElement("div");
	inputBoxBox.className = "inputBoxBox";
	
	var inputBox = document.createElement("div");
	inputBox.id = "techPickTable";
	inputBox.className = "table";
	
	var header = document.createElement("div");
	header.className = "table-head";
	
	var c1 = document.createElement("div");
	c1.className = "column";
	c1.innerHTML = "";
	
	var c2 = document.createElement("div");
	c2.className = "column";
	c2.innerHTML = "Técnico";
	
	header.appendChild(c1);
	header.appendChild(c2);
	inputBox.appendChild(header);
	inputBoxBox.appendChild(inputBox);
        
	// container.appendChild(icon);
	container.appendChild(inputBoxBox);
        
	var picker = document.getElementById("techPickTable");
	tableCreator("techPickTable", actualTechList);
	
	// REFRESH ACTUAL ASSINGED
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = "Asignar";
	send.ocode = ocode;
	send.onclick = function()
	{
		var info = {};
		
		var picked = [];
		
		var boxes = document.getElementById("techPickTable").children;
		
		var codes = [];
		var names = [];
		
		var list = boxes;
		
		for(var i=1; i<list.length; i++)
		{
			var item = list[i];
			var box = item.children[0].children[0];
			if(box.checked)
			{
				var code = box.code;
				var name = box.name;
				
				codes.push(code);
				names.push(name);
				
			}
			
		}
		
		
		
		info.codes = JSON.stringify(codes);
		info.names = JSON.stringify(names);
		info.ocode = this.ocode;
		
		console.log(info);
		


		sendAjax("users","setTechO",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
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

	formBox("asignTechBox","Asignar Técnico(s) a orden "+num,700);
}
function asignActionsBox(ccode, actions)
{
	var container = document.getElementById("asignActionsBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
        
	var icon = document.createElement("img");
	icon.src = "irsc/techIconB.png";
	icon.className = "";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var inputBoxBox = document.createElement("div");
	inputBoxBox.className = "inputBoxBox";
	
	var inputBox = document.createElement("div");
	inputBox.id = "actionPickTable";
	inputBox.className = "table";
	
	var header = document.createElement("div");
	header.className = "table-head";
	
	var c1 = document.createElement("div");
	c1.className = "column";
	c1.innerHTML = "";
	
	var c2 = document.createElement("div");
	c2.className = "column";
	c2.innerHTML = "Detalle";
	
	header.appendChild(c1);
	header.appendChild(c2);
	inputBox.appendChild(header);
	inputBoxBox.appendChild(inputBox);
        
	// container.appendChild(icon);
	container.appendChild(inputBoxBox);
        
	actualCheckActions = JSON.parse(actions);
	
	console.log(actualCheckActions)
		
	var picker = document.getElementById("actionPickTable");
	tableCreator("actionPickTable", actualActions);
	
	// REFRESH ACTUAL ASSINGED
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = "Asignar";
	send.ccode = ccode;
	send.onclick = function()
	{
		var info = {};
		
		var picked = [];
		var boxes = document.getElementById("actionPickTable").children;
		var codes = [];
		var list = boxes;
		
		for(var i=1; i<list.length; i++)
		{
			var item = list[i];
			var box = item.children[0].children[0];
			if(box.checked)
			{
				var code = box.code;
				codes.push(code);
			}
			
		}
		
		
		
		info.codes = JSON.stringify(codes);
		info.ccode = this.ccode;
		
		console.log(info);
		


		sendAjax("users","setCheckA",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			refreshActionsChecks();
			hide_pop_form();
		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};

	
	container.appendChild(send);
	container.appendChild(cancel);
        
	

	formBox("asignActionsBox","Asignar acciones a checklist",700);
}
function cellCreator(name, content)
{
        var cell = document.createElement("div");
        cell.className = "column";
        cell.setAttribute('data-label',name);
		
        cell.innerHTML = decry(decodeURIComponent(content));
        
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
		
		console.log(param)
        
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
                
                info.type = "T";
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
				info.deldet = document.getElementById("deldet").value;
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;
						console.log(ans)

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
		if(param[0] == "sessionsTable")
        {
                info.table = "sessions";
                info.code = param[1];
                info.delType = "sessions";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        getOsessions();
                });
                
        }
		if(param[0] == "hollyTable")
        {
                info.table = "hollydays";
                info.code = param[1];
                info.delType = "hollydays";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshollydays();
                });
                
        }
		if(param[0] == "sesslistsTable")
        {
                info.table = "sessions";
                info.code = param[1];
                info.delType = "sessions";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshSessList();
                });
                
        }
		if(param[0] == "checklistsTable")
        {
                info.table = "checklists";
                info.code = param[1];
                info.delType = "checklists";
                
                info.type = "O";
                info.target = param[1];
                
                sendAjax("users","regDelete",info,function(response)
                {
                        var ans = response.message;

                        alertBox(language["alert"], language["sys012"],300);
                        refreshActionsChecks();
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
        option.value = "C";
        option.innerHTML = "Empresa Cliente";
	recMailType.appendChild(option);
        
        var option = document.createElement("option");
        option.value = "T";
        option.innerHTML = "Técnico";
	recMailType.appendChild(option);
        
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
               setTimeout(function(){window.location.replace('http://www.sherbim.co/app/');}, 2500)
               

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
		 
		 console.log(method)

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
					// console.log(tmpJson);
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















