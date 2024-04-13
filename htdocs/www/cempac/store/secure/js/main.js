// APP START
$(document).ready( function()
{
	loadCheck();
});
function loadCheck()
{

	document.querySelector('#userLoginBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	document.querySelector('#userPassBox').addEventListener('keypress', function (e){var key = e.which || e.keyCode; if (key === 13){login();}});
	
	var picSelector = document.getElementById("picSelector");
	picSelector.addEventListener('change', handleFileSelect, false);
	
	plainSelector = document.getElementById("plainSelector");
	plainSelector.addEventListener('change', handlePlainSelect, false);
	
	actualZeditCode = "";
	
	loadingPlain = 0;
	
	langPickIni();
	
	prepareImgCropper();
	
	jQuery.datetimepicker.setLocale("es");
	jQuery('#zIniDate').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });
	jQuery('#zEndDate').datetimepicker
	({
            timepicker:false,
            format:'Y-m-d',
        }).on('change', function() {
            $('.xdsoft_datetimepicker').hide();
            var str = $(this).val();
            str = str.split(".");
            
    });
	
	jQuery('#deliverDateField').datetimepicker
	({
		timepicker:false,
		format:'Y-m-d',
	}).on('change', function() {
		$('.xdsoft_datetimepicker').hide();
		var str = $(this).val();
		str = str.split(".");
		
	});
	
	return;

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
		console.log(response)
		inventories = response.inventories;
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
		
		mainMenu.appendChild(menuCreator("sProd", "menProd"));
		mainMenu.appendChild(menuCreator("sShopAd", "menShopAd"));
		mainMenu.appendChild(menuCreator("sOrders", "menOrders"));
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
	
	
	
	orderDaemonStarter();
	setAutoInventory();
	
}
function synchronizeInventories()
{
	
	var picked = document.getElementById("loadPicker").value;
	console.log(picked)
	
	if(picked.split("INV").length > 1)
	{
		console.log("Es inventario")
	}
	else
	{
		console.log("NO Es inventario")
		alertBox(language["alert"], "<span class='explain'>Debe seleccionar un inventario desde el cual sincronizar a los demás</span>", 300);
		return;
	}
	
	var param = [picked];
	
	confirmBox(language["confirm"], "<span class='explain2'>Esta operación copiará los atributos de Línea, Detalle, Descripción, Foto y Estado de oferta a todos los productos de todos los inventarios, basado en el inventario actual seleccionado:<br/><br/><b class='importantB'> "+picked+"</b><br/><br/> <b>Esta operación no se puede revertir y puede tomar varios minutos, desea continuar?</b></span> ",requestSync, 400, param);
}
function deleteInventories()
{
	
	var picked = document.getElementById("loadPicker").value;
	console.log(picked)
	
	if(picked.split("INV").length > 1)
	{
		console.log("Es inventario")
	}
	else
	{
		console.log("NO Es inventario")
		alertBox(language["alert"], "<span class='explain'>Debe seleccionar un inventario para eliminar</span>", 300);
		return;
	}
	
	var param = [picked];
	
	confirmBox(language["confirm"], "<span class='explain2'>Esta operación eliminara el inventario seleccionado:<br/><br/><b class='importantB'> "+picked+"</b><br/><br/> <b>Esta operación no se puede revertir y puede tomar varios minutos, desea continuar?</b></span> ",deleteInv, 400, param);
}

function requestSync(inv)
{
	var info = {};
	info.BASE = inv[0];
	sendAjax("lang","syncInventory",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
	});
}
function deleteInv(inv)
{
	var info = {};
	info.INV = inv[0];
	sendAjax("lang","deleteInv",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		// return;
		
		window.location.reload();
	});
}

function setAutoInventory()
{
	var topPicker = document.getElementById("loadPicker");
	var botPicker = document.getElementById("zArea");
	
	// botPicker.innerHTML = "";
	
	for(var i=0; i<inventories.length; i++)
	{
		var INVCODE = inventories[i].INVCODE;
		var INVDESC = inventories[i].INVDESC;
		
		var option = document.createElement("option");
		option.innerHTML = INVDESC;
		option.value = INVCODE;
		
		topPicker.appendChild(option);
		botPicker.appendChild(option.cloneNode(true));
	}
	
}
// NEW ORDERS DAEMON
function orderDaemonStarter()
{
	getNew();
	orderchecker = setInterval(getNew, 300000);
}
function getNew()
{
	
	if(loadingPlain == 1)
	{
		console.log("is loading cancel daemon")
		return;
	}
	else
	{
		console.log("update order")
	}
	
	var info = {};
		
	sendAjax("users","getNewOrders",info,function(response)
	{
		var list = response.message;
		if(list.length > 0)
		{
			var audio = new Audio('ding.WAV');
			audio.play();
			document.getElementById("orderWarn").innerHTML = language["warnOrderYes"];
		}
		else
		{
			document.getElementById("orderWarn").innerHTML = language["warnOrderNo"];
		}
		
	});
}
function showOrders()
{
	document.getElementById("orderPicker").value = "ORDERS";
	document.getElementById("orderPicker").onchange();
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
			}
		}

        var li = document.createElement("li");
		li.className = "nav-item";
        li.appendChild(item);
		
        return li;
}
//END APP START

// PLAIN TXT LOAD
function handlePlainSelect(evt) 
{

	var type = document.getElementById('loadPicker').value;
	
	if(type == "")
	{
		alertBox(language["alert"], language["typeFirst"], 300);
		plainSelector.value = "";
		return;
	}

	var plainSelector = document.getElementById('plainSelector');
	var format = plainSelector.value.split(".")[1];
	var name = plainSelector.value.split(".")[0].split("\\fakepath\\")[1];

	if(name.substr(0, 5) != "PLIST")
	{
		if(type != name)
		{
			alertBox(language["alert"], language["fileTypeMiss"], 300);
			plainSelector.value = "";
			return;
		}
	}

	if(format != "TXT" && format != "txt")
	{
		alertBox(language["alert"], language["wrongFormat"], 300);
		plainSelector.value = "";
	}

}
function loadPlainFile()
{
	actFileType = document.getElementById("loadPicker").value;

	if(actFileType == "")
	{
		alertBox(language["alert"],language["mustTable"],300);
		return;
	}
	
	var fileSelector = document.getElementById("plainSelector");

	if(fileSelector.value == "")
	{
		alertBox(language["alert"],language["mustFile"],300);
		return;
	}
	
	fileSelector.name = actFileType;
	$("#loaderDiv").fadeIn();
	document.getElementById("upPlainButton").click();
}
function loadPlainFinish(result)
{
        if (result == 1)
        {
			var info = {};
			info.filename = actFileType;
			
			loadingPlain = 1;
			$("#loaderDiv").show();
			sendAjax("users","updateFromFile",info,function(response)
			{
				var ans = response.message;
				
				// console.log(actFileType)
				$("#loaderDiv").hide();
				if(actFileType == "CATS")
				{
					console.log("send rest")
					console.log(ans)
					$("#loaderDiv").show();
					sendRest(ans);
				}
				else
				{
					alertBox(language["alert"],language["loaDone"],300);
					document.getElementById("plainSelector").value = "";
				}
			}, "no");
        }
        else 
        {
			alertBox(language["alert"],language["loadFail"],300);
        }

}
function sendRest(rest)
{
	var info = {};
	info.rest = rest;
	sendAjax("users","updateFromFileCatRest",info,function(response)
	{
		var ans = response.message;
		ans.shift();
		console.log(ans);
		
		if(ans.length > 0)
		{
			console.log("resent");
			sendRest(ans);
			return;
		}
		else
		{
			loadingPlain = 0;
			alertBox(language["alert"],language["loaDone"],300);
			document.getElementById("plainSelector").value = "";
			$("#loaderDiv").hide();
		}
		
		
	}, "no");
}
//END PLAIN TXT LOAD

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

			console.log("logued")
			zStarter();
			
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
		alertBox(language["alert"],language["mustEmail"],300);
		return;
	}
	if(pin == "")
	{
		alertBox(language["alert"],language["mustPass"],300);
		return;
	}
	
	info.autor = email;
	info.pssw = pin;

	sendAjax("users","login",info,function(response)
	{
                
		var ans = response.message;

		if(ans == "Disabled")
		{
				alertBox(language["alert"],language["userBanned"],300);
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
//END LOGIN AND SESSION START

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
	// INVENTORY TABLE
	if(tableId == "productsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Código', list[i].CODE);
			if(list[i].FDETAIL == "")
			{
				var b = cellCreator('Detalle Original', encry(list[i].DETAIL));
			}
			else
			{
				var b = cellCreator('Detalle Original', encry(list[i].FDETAIL));
			}

			var e = cellCreator('Oferta', list[i].PROMO);
			var f = cellCreator('Cantidad', list[i].AVAILABLE);
			
			var cat = document.createElement("img");
			cat.reg = list[i];
			cat.setAttribute('title', list[i].FDETAIL);
			cat.setAttribute('alt', list[i].FDETAIL);
			cat.onclick = function()
			{
				var data = this.reg;
				lineSetBox(data);
			}

			if(list[i].CAT == "")
			{
				cat.src = "irsc/nocat.png";	
			}
			else
			{
				cat.src = "irsc/yescat.png";
			}
			
			var cat = celloneIconCreator('Detalle Nuevo', [cat]);
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', list[i].FDETAIL);
			detail.setAttribute('alt', list[i].FDETAIL);
			detail.onclick = function()
			{
				var data = this.reg;
				detailAddBox(data);
			}

			if(list[i].FDETAIL == "")
			{
				detail.src = "irsc/nodesc.png";	
			}
			else
			{
				detail.src = "irsc/yesdesc.png";
			}
			
			var c = celloneIconCreator('Detalle Nuevo', [detail]);
			
			var description = document.createElement("img");
			description.reg = list[i];
			description.setAttribute('title', list[i].LONDESC);
			description.setAttribute('alt', list[i].LONDESC);
			description.onclick = function()
			{
				var data = this.reg;
				detaiLongAddBox(data);
			}
			
			if(list[i].LONDESC == "" || list[i].LONDESC == null)
			{
				description.src = "irsc/nodesc.png";	
			}
			else
			{
				description.src = "irsc/yesdesc.png";
			}
			
			var ld = celloneIconCreator('Detalle largo', [description]);
			
			var pic = document.createElement("img");
			pic.reg = list[i];
			pic.setAttribute('title', 'Foto');
			pic.setAttribute('alt', 'Foto');
			pic.onclick = function()
			{
				actualPicCode = this.reg.CODE;
				document.getElementById("btnCrop").style.display = "none";
				document.getElementById("btnZoomIn").style.display = "none";
				document.getElementById("btnZoomOut").style.display = "none";
				
				var sample = document.getElementById("imgBox");
				
				console.log(this.reg.HP)
				
				if(this.reg.HP == "1")
				{
					sample.style.backgroundImage = "url('../images/product/"+this.reg.CODE+".jpg')";
					
					document.getElementById("deletePic").style.display = "initial";
				}
				else
				{
					sample.style.backgroundImage  = "url('../secure/irsc/imageSample.png')";
					document.getElementById("deletePic").style.display = "none";
				}
				
				sample.style.backgroundSize = "100% 100%";
				sample.style.backgroundPosition  = "0 0";
				
				formBox("cropBoxBox",language["cbTitle"],390);
				
			}

			if(list[i].HP == "0")
			{
				pic.src = "irsc/nopic.png";	
			}
			else
			{
				pic.src = "irsc/yespic.png";
			}
			
			var d = celloneIconCreator('Foto', [pic]);
			
			var promo = document.createElement("img");
			promo.reg = list[i];
			promo.onclick = function()
			{
				var param = this.reg;
				actualProdCode = this.reg.CODE;
				actualProdArea = this.reg.AREA;
				document.getElementById("markedStatePicker").value = this.reg.PROMO;
				formBox("setRemarkBox","Definir estado",600);
			}
			
			if(list[i].PROMO == "0")
			{
				promo.src = "irsc/nopromo.png";	
				promo.setAttribute('title', 'Normal');
				promo.setAttribute('alt', 'Normal');
			}
			else if(list[i].PROMO == "1")
			{
				promo.src = "irsc/yespromoD.png";	
				promo.setAttribute('title', 'Destacado');
				promo.setAttribute('alt', 'Destacado');
			}
			else
			{
				promo.src = "irsc/yespromo.png";
				promo.setAttribute('title', 'Oferta');
				promo.setAttribute('alt', 'Oferta');
			}
			
			var e = celloneIconCreator('Oferta', [promo]);
			
			var promoG = document.createElement("img");
			promoG.reg = list[i];
			promoG.onclick = function()
			{
				var param = this.reg;
				actualProdCode = this.reg.CODE;
				actualProdArea = this.reg.AREA;
				document.getElementById("markedStatePickerG").value = this.reg.PROMOG;
				formBox("setRemarkBoxG","Definir estado",600);
			}
			
			if(list[i].PROMOG == "0")
			{
				promoG.src = "irsc/nopromoG.png";	
				promoG.setAttribute('title', 'Normal');
				promoG.setAttribute('alt', 'Normal');
			}
			else if(list[i].PROMOG == "1")
			{
				promoG.src = "irsc/yespromoGD.png";	
				promoG.setAttribute('title', 'Destacado');
				promoG.setAttribute('alt', 'Destacado');
			}
			else
			{
				promoG.src = "irsc/yespromoG.png";
				promoG.setAttribute('title', 'Oferta');
				promoG.setAttribute('alt', 'Oferta');
			}
			
			var r = celloneIconCreator('Oferta G', [promoG]);

			var visible = document.createElement("img");
			visible.reg = list[i];
			visible.setAttribute('title', 'Cambiar estado');
			visible.setAttribute('alt', 'Cambiar estado');
			visible.onclick = function()
			{
				
				var param = this.reg;
				param.table = "products";
				
				if(this.reg.VISIBLE == "0")
				{
					confirmBox(language["confirm"], language["stateToVisible"], stChangerVisible, 300, param);
				}
				else
				{
					confirmBox(language["confirm"], language["stateToHidden"], stChangerVisible, 300, param);
				}
			}

			if(list[i].VISIBLE == "0")
			{
				visible.src = 'irsc/novisible.png';
			}
			else
			{
				visible.src = 'irsc/yesvisible.png';
			}
			
			var g = celloneIconCreator('Visible', [visible]);
			
			var icons = [];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,cat,c,ld,d,e,r,g,f];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	
	// LINES TABLE
	if(tableId == "catsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Código', list[i].CODE);
			
			if(list[i].FDETAIL == "")
			{
				var b = cellCreator('Detalle Original', encry(list[i].DETAIL));
			}
			else
			{
				var b = cellCreator('Detalle Original', encry(list[i].FDETAIL));
			}
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', list[i].FDETAIL);
			detail.setAttribute('alt', list[i].FDETAIL);
			detail.onclick = function()
			{
				var data = this.reg;
				detailAddBoxCat(data);
			}

			if(list[i].FDETAIL == "")
			{
				detail.src = "irsc/nodesc.png";	
			}
			else
			{
				detail.src = "irsc/yesdesc.png";
			}
			
			var c = celloneIconCreator('Detalle Nuevo', [detail]);
			
			var visible = document.createElement("img");
			visible.reg = list[i];
			visible.setAttribute('title', 'Cambiar estado');
			visible.setAttribute('alt', 'Cambiar estado');
			visible.onclick = function()
			{
				
				var param = this.reg;
				param.table = "cats";
				
				if(this.reg.VISIBLE == "0")
				{
					confirmBox(language["confirm"], language["stateToVisible"], stChangerVisible, 300, param);
				}
				else
				{
					confirmBox(language["confirm"], language["stateToHidden"], stChangerVisible, 300, param);
				}
			}

			if(list[i].VISIBLE == "0")
			{
				visible.src = 'irsc/novisible.png';
			}
			else
			{
				visible.src = 'irsc/yesvisible.png';
			}
			
			var d = celloneIconCreator('Visible', [visible]);
			
			var icons = [];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
		
		
	}
	
	// EXTS TABLE
	if(tableId == "rfList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Código', list[i].CODE);
			
			if(list[i].FDETAIL == "")
			{
				var b = cellCreator('Detalle Original', encry(list[i].DETAIL));
			}
			else
			{
				var b = cellCreator('Detalle Original', encry(list[i].FDETAIL));
			}
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', list[i].FDETAIL);
			detail.setAttribute('alt', list[i].FDETAIL);
			detail.onclick = function()
			{
				var data = this.reg;
				detailAddBoxExt(data);
			}

			if(list[i].FDETAIL == "")
			{
				detail.src = "irsc/nodesc.png";	
			}
			else
			{
				detail.src = "irsc/yesdesc.png";
			}
			
			var c = celloneIconCreator('Detalle Nuevo', [detail]);
			
			var visible = document.createElement("img");
			visible.reg = list[i];
			visible.setAttribute('title', 'Cambiar estado');
			visible.setAttribute('alt', 'Cambiar estado');
			visible.onclick = function()
			{
				
				var param = this.reg;
				param.table = "exts";
				
				if(this.reg.VISIBLE == "0")
				{
					confirmBox(language["confirm"], language["stateToVisible"], stChangerVisible, 300, param);
				}
				else
				{
					confirmBox(language["confirm"], language["stateToHidden"], stChangerVisible, 300, param);
				}
			}

			if(list[i].VISIBLE == "0")
			{
				visible.src = 'irsc/novisible.png';
			}
			else
			{
				visible.src = 'irsc/yesvisible.png';
			}
			
			var d = celloneIconCreator('Visible', [visible]);
			
			cBox = document.createElement("input");
			cBox.type = "color";
			cBox.value = "#eeeeee";
			cBox.code = list[i].CODE;
			cBox.className = "cBoxDefault";
			cBox.onchange = function()
			{
				var info = {};
				info.code = this.code;
				info.color = this.value;
				
				sendAjax("users","setColor",info,function(response)
				{
					var list = response.message;
					console.log(list)
					document.getElementById("refreshButton").click();
					
				});
				
			}
			if(list[i].COLOR != ""){cBox.value = list[i].COLOR;}
			
			var z = cellChildrenCreator("Color", cBox);
			
			var icons = [];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,z];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	
	// ZONES TABLE
	if(tableId == "zonesList")
	{
		console.log("ss")
		
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Nombre', list[i].NAME);
			var b = cellCreator('Inventario', list[i].AREA);
			var c = cellCreator('Lista 1', list[i].PL1);
			var d = cellCreator('Lista 2', list[i].PL2);
			var d2 = cellCreator('Lista 3', list[i].PL5);
			// var e = cellCreator('Lista 3', list[i].PL3);
			// var f = cellCreator('Lista 4', list[i].PL4);
			var z = cellCreator('Tope envío', addCommas(list[i].DTOP));
			var g = cellCreator('Tope', addCommas(list[i].BTOP));
			var f = cellCreator('Tope T.', addCommas(list[i].DTOPT));
			var h = cellCreator('Temporada', list[i].DRANGE);
			var j = cellCreator('Mínimo inicial', addCommas(list[i].MINFIRST));
			
			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/edIcon.png";	
			edit.setAttribute('title', "Editar");
			edit.setAttribute('alt', "Editar");
			edit.onclick = function()
			{
				
				var reg = this.reg;
				
				actualZeditCode = reg.CODE;
				
				document.getElementById("pCreateB").innerHTML = "Guardar";
				
				document.getElementById("zDetail").value = reg.NAME;
				document.getElementById("zArea").value = reg.AREA;
				document.getElementById("zPl1").value = reg.PL1;
				document.getElementById("zPl2").value = reg.PL2;
				document.getElementById("zPl5").value = reg.PL5;
				// document.getElementById("zPl3").value = reg.PL3;
				// document.getElementById("zPl4").value = reg.PL4;
				document.getElementById("zDtop").value = reg.DTOP;
				document.getElementById("zBtop").value = reg.BTOP;
				document.getElementById("zBtopT").value = reg.DTOPT;
				document.getElementById("zMinFirst").value = reg.MINFIRST;
				
				if(reg.DRANGE != "")
				{
					var value = reg.DRANGE.split("<->");
					var ini = value[0];
					var end = value[1];

					document.getElementById("zIniDate").value = ini;
					document.getElementById("zEndDate").value = end;
				}
				else
				{
					document.getElementById("zIniDate").value = "";
					document.getElementById("zEndDate").value = "";
				}
			}
			
			var visible = document.createElement("img");
			visible.reg = list[i];
			visible.setAttribute('title', list[i].FDETAIL);
			visible.setAttribute('alt', list[i].FDETAIL);
			visible.onclick = function()
			{
				var param = this.reg;
				param.table = "zones";
				
				if(this.reg.VISIBLE == "0")
				{
					confirmBox(language["confirm"], language["stateToVisible"], stChangerVisible, 300, param);
				}
				else
				{
					confirmBox(language["confirm"], language["stateToHidden"], stChangerVisible, 300, param);
				}
			}
			
			if(list[i].VISIBLE == "0")
			{
				visible.src = "irsc/novisible.png";
			}
			else
			{
				visible.src = "irsc/yesvisible.png";
			}
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "irsc/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualZcode = data.CODE;
				showDeliverDates(data.CODE);
			}
			
			var del = document.createElement("img");
			del.reg = list[i];
			del.src = "irsc/delIcon.png";
			del.setAttribute('title', "Eliminar");
			del.setAttribute('alt', "Eliminar");
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var data = this.reg;
				var param = [tableId, data];
				
				confirmBox(language["confirm"], language["delAsk"], deleteRecord, 300, param);

			}

			var icons = [edit, visible, detail, del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,d2,z,g,f,h,j,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	
	// CLIENTS TABLE
	if(tableId == "clientList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Nombre', list[i].NAME);
			var b = cellCreator('Email', list[i].EMAIL);
			var c = cellCreator('Dirección', list[i].ADDRESS);
			var d = cellCreator('Teléfono', list[i].PHONE);
			
			var j = cellCreator('Tipo', list[i].IDTYPE);
			var k = cellCreator('ID/NIT', list[i].IDN);

			var del = document.createElement("img");
			del.reg = list[i];
			del.src = "irsc/delIcon.png";
			del.setAttribute('title', "Eliminar");
			del.setAttribute('alt', "Eliminar");
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var data = this.reg;
				var param = [tableId, data];
				
				confirmBox(language["confirm"], language["delAsk"], deleteRecord, 300, param);

			}
			
			var icons = [del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,j,k,b,c,d,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	
	// ORDERS TABLE
	if(tableId == "ordersList")
	{
		var torder = 0;
		var tselled = 0;
		
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Nombre', list[i].UNAME);
			var b = cellCreator('Ubicación', list[i].OLOCATION);
			var n = cellCreator('Dirección', list[i].UADDRESS);
			var m = cellCreator('Teléfono', list[i].UPHONE);
			var c = cellCreator('Fecha', list[i].DATE);
			var d = cellCreator('Valor Orden', addCommas(list[i].ORDERED));
			
			if(list[i].ORDERED != list[i].DISPATCHED)
			{
				var dispatched = "<p style='color: red'>"+addCommas(list[i].DISPATCHED)+"</p>";
			}
			else
			{
				var dispatched = addCommas(list[i].DISPATCHED);
			}
			var z = cellCreator('Valor Orden', dispatched);
			
			if(list[i].WPCK == "0")
			{
				var wpck = "Enviar"
			}
			else
			{
				var wpck = "Recoge"
			}
			
			var e = cellCreator('Entrega', wpck);
			
			var state = "";
			
			if(list[i].STATE == "0"){state = "Nuevo";}
			else if(list[i].STATE == "1"){state = "Digitado";	}
			else if(list[i].STATE == "2"){state = "Despachado";}
			else if(list[i].STATE == "3"){state = "Devuelto";	}
			else if(list[i].STATE == "4"){state = "Anulado";}
			
			
			var f = cellCreator('Estado', state);

			var edit = document.createElement("img");
			edit.reg = list[i];
			edit.src = "irsc/edIcon.png";	
			edit.setAttribute('title', "Editar");
			edit.setAttribute('alt', "Editar");
			edit.onclick = function()
			{
				var data = this.reg;
				orderStateSet(data);
			}
			
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "irsc/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualOcode = data.OCODE;
				
				
				var clientData = document.getElementById("clientDataLine");
				
				clientData.innerHTML = "Cliente: <b>"+data.UNAME+"</b> Tipo: <b>"+data.UIDTYPE+"</b> Nit/Id: <b>"+data.UIDNUM+"</b>";

				showOrderItems(data.OCODE);
			}
			
			
			
			torder += parseInt(list[i].ORDERED);
			tselled += parseInt(list[i].DISPATCHED);
			
			var icons = [edit, detail];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,n,m,c,d,z,e,f,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
		
		var line = ["", "","", "", "Total",addCommas(torder),addCommas(tselled),"","",""];
		var totalRow = enderRow(line);
		table.appendChild(totalRow);
	}
	
	// ORDERS ITEMS
	if(tableId == "ordersItems")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			console.log(i);
			
			var a = cellCreator('Código', list[i].CODE);
			var b = cellCreator('Detalle', encry(list[i].DETAIL));
			var c = cellCreator('Pedido', list[i].REQUESTED);
			
			var dispField = document.createElement("input");
			dispField.type = "text";
			dispField.reg = list[i];
			dispField.className = "tableField";
			
			dispField.value = list[i].DISPATCHED;
			
			dispField.onblur = function()
			{
				var data = this.reg;
				var value = this.value;
				
				if((isNaN(value)) || value == "")
				{
					this.value = data.DISPATCHED;
					alertBox(language["alert"], language["mustQty"], 300);
					return;
				}
				if(value == data.DISPATCHED){return;}
				
				var code = data.CODE;
				var qty = value;

				var newTotal = getOtotal(code, qty);
				
				var info = {};
				info.orderCode = actualOcode;
				info.itemCode = code;
				info.qty = qty;
				info.total = newTotal;
				
				sendAjax("users","setDispatched",info,function(response)
				{
					var ans = response.message;
					tableCreator("ordersList", actualOlist);
					tableCreator("ordersItems", actualOitems);
				});
			}

			var d = celloneIconCreator('Despachado', [dispField]);
			var e = cellCreator('Precio', addCommas(list[i].PRICE));
			var st = parseInt(list[i].DISPATCHED)*parseInt(list[i].PRICE);
			var f= cellCreator('Subtotal', addCommas(st));
	
			var icons = [];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,f];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	
	// LOSES TABLE
	if(tableId == "losesList")
	{
		
		var tqty = 0;
		var tval = 0;
		
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Código', list[i].CODE);
			var b = cellCreator('Detalle', list[i].DETAIL);
			var m = cellCreator('Fecha', list[i].DATE);
			var c = cellCreator('Inventario', list[i].INVENTORY);
			var lost = list[i].REQUESTED - list[i].DISPATCHED;
			var d = cellCreator('Perdida', lost);
			var lostVal = lost*list[i].PRICE;
			var e = cellCreator('Valor', addCommas(lostVal));
			
			tqty += parseInt(lost);
			tval += parseInt(lostVal);
			
			var icons = [];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,m,c,d,e];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}
		
		var line = ["", "", "", "Total",tqty,addCommas(tval)];
		var totalRow = enderRow(line);
		table.appendChild(totalRow);
	}
	
	// UNABLE TABLE
	if(tableId == "unableList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Fecha', list[i].DATE);
			
			
			var del = document.createElement("img");
			del.reg = list[i];
			del.src = "irsc/delIcon.png";	
			del.setAttribute('title', "Eliminar");
			del.setAttribute('alt', "Eliminar");
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var data = this.reg;
				var param = [tableId, data];
				
				confirmBox(language["confirm"], language["delAsk"], deleteRecord, 300, param);
			}

			var icons = [del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}
		
	}
		
	// UNABLE TABLE
	if(tableId == "deliverDates")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator('Fecha', list[i].DATE);
			
			
			var del = document.createElement("img");
			del.reg = list[i];
			del.src = "irsc/delIcon.png";	
			del.setAttribute('title', "Eliminar");
			del.setAttribute('alt', "Eliminar");
			del.onclick = function()
			{
				var tableId = this.parentNode.parentNode.parentNode.id;
				var data = this.reg;
				var param = [tableId, data];
				
				confirmBox(language["confirm"], language["delAsk"], deleteRecord, 300, param);
			}

			var icons = [del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}

	}
	
	resSet();
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

// REPORT BLOCK START ----------
function reportPick(pick)
{
        picker = pick;
		pick = pick.value;

		actualReport = "";

		if(picker.id ==  "orderPicker")
		{
			var reporTableBoxO = document.getElementById("reporTableBoxO");
			var tables = reporTableBoxO.children;

			for(var i = 0; i<tables.length; i++)
			{
				var table = tables[i];
				table.style.display = "none";
			}
		}
		else
		{
			var reporTableBox = document.getElementById("reporTableBox");
			var tables = reporTableBox.children;

			for(var i = 0; i<tables.length; i++)
			{
				var table = tables[i];
				table.style.display = "none";
			}

		}

        // tableClear("productsList");
        // tableClear("catsList");
        // tableClear("pList");
        // tableClear("rfList");
        // tableClear("ordersList");
        // tableClear("losesList");
        // tableClear("unableList");

        if(pick == "")
		{
			if(picker.id ==  "orderPicker")
			{
				var box = document.getElementById("repFilterBoxO");
			}
			else
			{
				var box = document.getElementById("repFilterBox");
			
			}
			box.innerHTML = "";
			return;
		}
		
		var initial = pick[0]+pick[1]+pick[2];

		if(initial == "INV"){pick = "INVENTORY";}
		
        if(pick == "INVENTORY"){actualReport = "productsList";}
        else if(pick == "CATS"){actualReport = "catsList";}
        else if(pick == "PLIST"){actualReport = "pList";}
        else if(pick == "RFLIST"){actualReport = "rfList";}
        else if(pick == "ORDERS"){actualReport = "ordersList";}
        else if(pick == "CLIENTS"){actualReport = "clientList";}
        else if(pick == "LOSES"){actualReport = "losesList";}
        else if(pick == "UNABLE"){actualReport = "unableList";}
        else if(pick == "BANNER"){actualReport = "bannerDiv";}
		
        filterBuilder("repFilterBox", actualReport);
        

		document.getElementById(actualReport).style.display = "table";

}
function filterBuilder(id, type)
{
        
		tableClear(actualReport);
		
		if(picker.id ==  "orderPicker")
		{var box = document.getElementById("repFilterBoxO");}
		else{var box = document.getElementById("repFilterBox");}
		box.innerHTML = "";
		
        var exportButton = buttonCreator([12,4,4,2], "Exportar", repoExport);

        if(type == "productsList")
        {
			
			var repoCode = fieldCreator([12,4,4,1], "Código", "input", "repoCode");
			var repoDesc = fieldCreator([12,4,4,2], "Detalle Original", "input", "repoDesc");
			var repoHasDet= fieldCreator([12,4,4,2], "Detalle Nuevo", "input", "repoHasDet");
			var repoTieneDet= fieldCreator([12,4,4,1], "Desc", "select", "repoTieneDet");
			var repoHasLine= fieldCreator([12,4,4,1], "Línea", "select", "repoHasLine");
			var repoHasPic = fieldCreator([12,4,4,1], "Foto", "select", "repoHasPic");
			var repoHasOff= fieldCreator([12,4,4,1], "Resalte", "select", "repoHasOff");
			var repoVisible= fieldCreator([12,4,4,1], "Visible", "select", "repoVisible");
			var searchButton = buttonCreator([12,4,4,2], "Buscar", reposearch, "refreshButton");
			
			box.appendChild(repoCode);
			box.appendChild(repoDesc);
			
			box.appendChild(repoHasDet);
			box.appendChild(repoHasLine);
			box.appendChild(repoTieneDet);
			box.appendChild(repoHasPic);
			box.appendChild(repoHasOff);
			box.appendChild(repoVisible);
			box.appendChild(searchButton);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoTieneDet").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "no";
			option.innerHTML = "no";
			document.getElementById("repoTieneDet").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "si";
			option.innerHTML = "si";
			document.getElementById("repoTieneDet").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoHasLine").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoHasPic").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoHasPic").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoHasPic").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoHasOff").appendChild(option);

			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "Normal";
			document.getElementById("repoHasOff").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "2";
			option.innerHTML = "Oferta";
			document.getElementById("repoHasOff").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Destacado";
			document.getElementById("repoHasOff").appendChild(option);

			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoVisible").appendChild(option);
			
			// document.getElementById("refreshButton").click();
			
			getCats();
			
			reposearch()
			
        }
		
		if(type == "catsList")
        {
			var repoCode = fieldCreator([12,4,4,2], "Código", "input", "repoCode");
			var repoDesc = fieldCreator([12,4,4,3], "Detalle Original", "input", "repoDesc");
			var repoHasDet= fieldCreator([12,4,4,3], "Detalle Nuevo", "input", "repoHasDet");
			var repoVisible= fieldCreator([12,4,4,1], "Visible", "select", "repoVisible");
			var searchButton = buttonCreator([12,4,4,3], "Buscar", reposearch, "refreshButton");
			
			box.appendChild(repoCode);
			box.appendChild(repoDesc);
			box.appendChild(repoHasDet);
			box.appendChild(repoVisible);
			box.appendChild(searchButton);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoVisible").appendChild(option);
			
			reposearch()
		}
		
		if(type == "rfList")
        {
			var repoCode = fieldCreator([12,4,4,1], "Extensión", "input", "repoCode");
			var repoDesc = fieldCreator([12,4,4,3], "Detalle Original", "input", "repoDesc");
			var repoHasDet= fieldCreator([12,4,4,3], "Detalle Nuevo", "input", "repoHasDet");
			var repoVisible= fieldCreator([12,4,4,1], "Visible", "select", "repoVisible");
			var repoColor= fieldCreator([12,4,4,1], "Color", "select", "repoColor");
			var searchButton = buttonCreator([12,4,4,3], "Buscar", reposearch, "refreshButton");
			
			box.appendChild(repoCode);
			box.appendChild(repoDesc);
			box.appendChild(repoHasDet);
			box.appendChild(repoVisible);
			box.appendChild(repoColor);
			box.appendChild(searchButton);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoColor").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoColor").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoColor").appendChild(option);
			
			
			reposearch();
		}

		if(type == "clientList")
        {
			var repoCode = fieldCreator([12,4,4,1], "Extensión", "input", "repoCode");
			var repoDesc = fieldCreator([12,4,4,3], "Detalle Original", "input", "repoDesc");
			var repoHasDet= fieldCreator([12,4,4,3], "Detalle Nuevo", "input", "repoHasDet");
			var repoVisible= fieldCreator([12,4,4,1], "Visible", "select", "repoVisible");
			var repoColor= fieldCreator([12,4,4,1], "Color", "select", "repoColor");
			var searchButton = buttonCreator([12,4,4,3], "Buscar", reposearch, "refreshButton");
			
			box.appendChild(repoCode);
			box.appendChild(repoDesc);
			box.appendChild(repoHasDet);
			box.appendChild(repoVisible);
			box.appendChild(repoColor);
			box.appendChild(searchButton);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoVisible").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = "";
			document.getElementById("repoColor").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Si";
			document.getElementById("repoColor").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "No";
			document.getElementById("repoColor").appendChild(option);
			
			
			reposearch();
		}
        
		if(type == "ordersList")
        {
			
			var repoUname = fieldCreator([12,4,4,2], "Cliente", "input", "repoUname");
			var repoLocation = fieldCreator([12,4,4,2], "Ubicación", "input", "repoLocation");
			var repoIniDate= fieldCreator([12,4,4,2], "Fecha inicial", "input", "repoIniDate");
			var repoEndDate= fieldCreator([12,4,4,2], "Fecha Final", "input", "repoEndDate");
			var repoStatus = fieldCreator([12,4,4,1], "Estado", "select", "repoStatus");
			
			repoStatus.onchange = function()
			{
				reposearch()
			}

			var searchButton = buttonCreator([12,4,4,3], "Buscar", reposearch, "refreshButtonO");
			
			box.appendChild(repoUname);
			box.appendChild(repoLocation);
			box.appendChild(repoIniDate);
			box.appendChild(repoEndDate);
			box.appendChild(repoStatus);
			box.appendChild(searchButton);
			
			var option = document.createElement("option");
			option.value = "0";
			option.innerHTML = "Nuevo";
			document.getElementById("repoStatus").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "1";
			option.innerHTML = "Digitado";
			document.getElementById("repoStatus").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "2";
			option.innerHTML = "Despachado";
			document.getElementById("repoStatus").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "3";
			option.innerHTML = "Devuelto";
			document.getElementById("repoStatus").appendChild(option);
			
			var option = document.createElement("option");
			option.value = "4";
			option.innerHTML = "Anulado";
			document.getElementById("repoStatus").appendChild(option);
			
			reposearch()

        }
		
		if(type == "losesList")
        {
			
			var repoCode = fieldCreator([12,4,4,2], "Código", "input", "repoCode");
			var repoProduct = fieldCreator([12,4,4,2], "Producto", "input", "repoProduct");
			var repoLocation = fieldCreator([12,4,4,2], "Inventario", "input", "repoLocation");
			var repoIniDate= fieldCreator([12,4,4,2], "Fecha inicial", "input", "repoIniDate");
			var repoEndDate= fieldCreator([12,4,4,2], "Fecha Final", "input", "repoEndDate");

			var searchButton = buttonCreator([12,4,4,2], "Buscar", reposearch, "refreshButtonO");
			
			box.appendChild(repoCode);
			box.appendChild(repoProduct);
			box.appendChild(repoLocation);
			box.appendChild(repoIniDate);
			box.appendChild(repoEndDate);
			box.appendChild(searchButton);
			
			reposearch()

        }
		
		if(type == "unableList")
        {
			
			var repoIniDateU= fieldCreator([12,4,4,2], "Fecha inicial", "input", "repoIniDateU");
			var searchButton = buttonCreator([12,4,4,2], "Agregar", saveUnable, "refreshButtonU");

			box.appendChild(repoIniDateU);
			box.appendChild(searchButton);
			
			jQuery('#repoIniDateU').datetimepicker
			({
					timepicker:false,
					format:'Y-m-d',
				}).on('change', function() {
					$('.xdsoft_datetimepicker').hide();
					var str = $(this).val();
					str = str.split(".");
					
			});
			
			getUnableList();

        }
		
		if(type == "bannerDiv")
        {
			
			var repoIniDateU= fieldCreator([12,4,4,10], "Texto de banner", "input", "repoBanner");
			var searchButton = buttonCreator([12,4,4,2], "Guardar", saveBanner, "refreshButtonU");

			box.appendChild(repoIniDateU);
			box.appendChild(searchButton);

			getBanner();

        }
		
		jQuery('#repoIniDate').datetimepicker
		({
				timepicker:false,
				format:'Y-m-d',
			}).on('change', function() {
				$('.xdsoft_datetimepicker').hide();
				var str = $(this).val();
				str = str.split(".");
				
		});
		
		jQuery('#repoEndDate').datetimepicker
		({
				timepicker:false,
				format:'Y-m-d',
			}).on('change', function() {
				$('.xdsoft_datetimepicker').hide();
				var str = $(this).val();
				str = str.split(".");
				
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
function buttonCreator(sizes, title, fun, id)
{
        var button = document.createElement("button");
        button.innerHTML = title;
        button.onclick = function()
		{
			actualReport = this.report;
			fun()
		}
		button.id = id;
		button.report = actualReport;
        
        var box = document.createElement("div");
        var classname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
        box.className = classname;
        
        var br = document.createElement("br");
        br.className = "hidden-xs";
        
        box.appendChild(br);
        box.appendChild(button);
        
        return box;
}
function getCats()
{
	var info = {};
	
	sendAjax("users","getCats",info,function(response)
	{
		cats = response.message;
		
		document.getElementById("repoHasLine").innerHTML = "";
		
		var option = document.createElement("option");
		option.value = "";
		option.innerHTML = "";
		document.getElementById("repoHasLine").appendChild(option);
		
		var option = document.createElement("option");
		option.value = "none";
		option.innerHTML = "Sin línea";
		document.getElementById("repoHasLine").appendChild(option);
		
		for(var i=0; i<cats.length; i++)
		{
			var reg = cats[i];
			
			var option = document.createElement("option");
			option.value = reg.CODE;
			
			if(reg.FDETAIL != "")
			{
				var detail = reg.FDETAIL;
			}
			else
			{
				var detail = reg.DETAIL;
			}
			
			option.innerHTML = reg.CODE+" - "+detail;
			document.getElementById("repoHasLine").appendChild(option);
		}
		
	});
	
}
function reposearch()
{
	var info = {};

	info["repoType"] = actualReport;

	if(actualReport == "productsList"){var limit = 1;}
	if(actualReport == "catsList"){var limit = 1;}
	if(actualReport == "rfList"){var limit = 1;}
	if(actualReport == "ordersList"){var limit = 1;}
	if(actualReport == "losesList"){var limit = 1;}

	var fields = [];
	
	if(actualReport == "ordersList" || actualReport == "losesList")
	{
		var filters = document.getElementById("repFilterBoxO").children;
	}
	else
	{
		var filters = document.getElementById("repFilterBox").children;
	}
	
	
	for(var i = 0; i<filters.length-limit; i++){var filter = filters[i].children[1];fields.push(filter.id);}
	for(var i=0; i<fields.length; i++)
	{
		info[fields[i]] = document.getElementById(fields[i]).value;
		if(fields[i] == "repoOrderNum")
		{
				info[fields[i]] = parseInt(document.getElementById(fields[i]).value);
		}
	}

	info.repoArea = document.getElementById("loadPicker").value;
	
	
	console.log(info)
	
	sendAjax("users","getReport",info,function(response)
	{
		var list = response.message;
		console.log(list)
		if(actualReport == "ordersList"){actualOlist = list;}
		
		tableCreator(actualReport, list);
		
	});

}
function repoExport()
{
	var info = {};
	info["repoType"] = actualReport;
	
	console.log("lol");
	
	
	var fields = [];
	var filters = document.getElementById("repFilterBox").children;
	for(var i = 0; i<filters.length-2; i++){var filter = filters[i].children[1];fields.push(filter.id);}
	for(var i=0; i<fields.length; i++)
	{
		info[fields[i]] = document.getElementById(fields[i]).value;
		if(fields[i] == "repoOrderNum")
		{
				info[fields[i]] = parseInt(document.getElementById(fields[i]).value);
		}
	}

	sendAjax("users","exportReport",info,function(response)
	{
		var list = response.message;

		tableCreatorRepo(actualReport, list);
		
		if(actualReport == "buystoryAll")
		{
			var url = "report/reporte.csv";
			downloadFile(url);
		}
		if(actualReport == "buystoryAllfree")
		{
			var url = "report/reportefundicion.csv";
			downloadFile(url);
		}
	});

}

function getClients()
{
	var info = {};
	info["repoType"] = "users";

	sendAjax("users","exportReport",info,function(response)
	{
		var list = response.message;
		console.log(list);
		
		var url = "report/reporte.csv";
		downloadFile(url);
	
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
// REPORT BLOCK END ----------

// DELETER
function deleteRecord(param)
{
	var info = {};
	
	if(param[0] == "zonesList")
	{
		info.table = "zones";
		info.code = param[1].CODE;
		info.delType = "zone";
		
		sendAjax("users","regDelete",info,function(response)
		{
			var ans = response.message;
			 zStarter();
		});
	}
	if(param[0] == "clientList")
	{
		info.table = "users";
		info.code = param[1].UCODE;
		info.delType = "clientList";
		
		sendAjax("users","regDelete",info,function(response)
		{
			var ans = response.message;
			 reposearch();
		});
	}
	if(param[0] == "unableList")
	{
		info.table = "unable";
		info.code = param[1].DATE;
		info.delType = "unable";
		
		sendAjax("users","regDelete",info,function(response)
		{
			var ans = response.message;
			 getUnableList();
		});
	}
	if(param[0] == "deliverDates")
	{
		info.table = "ddates";
		info.code = param[1].ZCODE;
		info.date = param[1].DATE;
		info.delType = "ddates";
		
		sendAjax("users","regDelete",info,function(response)
		{
			var ans = response.message;
			getDdates();
		});
	}
}
//END DELETER

// APP CORE
function stChangerVisible(info)
{
	
	var actual = info.VISIBLE;
	
	if(actual == "1")
	{
		var nactual = "0";
	}
	else
	{
		var nactual = "1";
	}
	
	var pack = {};
	pack.area = info.AREA;
	pack.code = info.CODE;
	pack.table = info.table;
	pack.nactual = nactual;
	
	sendAjax("users","staterVisible",pack,function(response)
	{
		var ans = response.message;
		console.log(pack.table)
		if(pack.table != "zones")
		{
			console.log(ans)
			document.getElementById("refreshButton").click();
		}
		else
		{
			zStarter();
		}
		
	});
}
function stChangerPromo()
{
	
	var nactual = document.getElementById("markedStatePicker").value;
	var pack = {};
	pack.area = actualProdArea;
	pack.code = actualProdCode;
	pack.nactual = nactual;

	sendAjax("users","staterPromo",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		hide_pop_form();
		document.getElementById("refreshButton").click();
	});
}
function stChangerPromoG()
{
	
	var nactual = document.getElementById("markedStatePickerG").value;
	
	var pack = {};
	pack.area = actualProdArea;
	pack.code = actualProdCode;
	pack.nactual = nactual;
	
	sendAjax("users","staterPromoG",pack,function(response)
	{
		var ans = response.message;
		console.log(ans)
		hide_pop_form();
		document.getElementById("refreshButton").click();
	});
}
function detailAddBox(data)
{
	
	var code = data.CODE;
	
	if(data.FDETAIL == "")
	{
		var actualdesc = data.DETAIL;
	}
	else
	{
		var actualdesc = data.FDETAIL;
	}
	
	
	var container = document.getElementById("detailAddBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("input");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "text";
	floatBoxInput.className = "floatBoxInput";
	floatBoxInput.placeholder = language["newDesc"];
	floatBoxInput.value = actualdesc;
	floatBoxInput.maxLength = 44;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
	{
		var info = {};
		info.code = code;
		info.input = ($("#floatBoxInput").val());
		
		sendAjax("users","setNewDet",info,function(response)
		{
			var ans = response.message;
			hide_pop_form();
			document.getElementById("refreshButton").click();

		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("detailAddBox",language["pdetail"],600);
}
function invCreate(data)
{
	
	// var code = data.CODE;
	// var actualdesc = data.LONDESC;

	var container = document.getElementById("detailAddBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var explain = document.createElement("span");
	explain.innerHTML = "El codigo para el nuevo inventario debe estar compuesto por INV y la ciudad de ubicación, todo en mayúsculas, por ejemplo:<br> <b>INVGUAJIRA</b> o <b>INVVALLEDELCAUCA</b> <b><br>NO DEBE CONTENER ESPACIOS, MINÚSCULAS O CARÁCTERES ESPECIALES</b>";
	explain.className = "explain";
	
	
	var floatBoxInput = document.createElement("input");
	floatBoxInput.id = "createInvName";
	floatBoxInput.type = "text";
	floatBoxInput.className = "floatBoxInput";
	floatBoxInput.placeholder = "Codigo del inventario";
	floatBoxInput.maxLength = 110;
	
	
	var explain2 = document.createElement("span");
	explain2.innerHTML = "Ingrese el nombre como aparecerá el inventario en la lista, por ejemplo:<br> <b>Inventario Armenia</b> o <b>Inventario Cajamarca</b>";
	explain2.className = "explain";
	
	
	var floatBoxInput2 = document.createElement("input");
	floatBoxInput2.id = "createInvDesc";
	floatBoxInput2.type = "text";
	floatBoxInput2.className = "floatBoxInput";
	floatBoxInput2.placeholder = "Nombre como aparecerá en la lista";
	floatBoxInput2.maxLength = 110;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
	{
		var info = {};
		info.createInvName = ($("#createInvName").val()).toUpperCase();
		info.createInvDesc = ($("#createInvDesc").val());
		
		if(info.createInvName == ""){alertBox(language["alert"], "Debe escribir el codigo de inventario", 300); return;}
		if(info.createInvDesc == ""){alertBox(language["alert"], "Debe escribir el nombre inventario", 300); return;}
		if(hasWhiteSpace(info.createInvName)){alertBox(language["alert"], "El codigo no puede tener espacios", 300); return;}
		
		console.log(info)
		
		// return;
		
		sendAjax("lang","createInventory",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			window.location.reload();
			// hide_pop_form();
			

		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(explain);
	container.appendChild(floatBoxInput);
	container.appendChild(explain2);
	container.appendChild(floatBoxInput2);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("detailAddBox","Crear Inventario",500);
}
function hasWhiteSpace(s) {
  return /\s/g.test(s);
}
function detaiLongAddBox(data)
{
	
	var code = data.CODE;
	var actualdesc = data.LONDESC;

	var container = document.getElementById("detailAddBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("input");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "text";
	floatBoxInput.className = "floatBoxInput";
	floatBoxInput.placeholder = language["newDesc"];
	floatBoxInput.value = actualdesc;
	floatBoxInput.maxLength = 110;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
	{
		var info = {};
		info.code = code;
		info.input = ($("#floatBoxInput").val());
		
		sendAjax("users","setNewLongDet",info,function(response)
		{
			var ans = response.message;
			hide_pop_form();
			document.getElementById("refreshButton").click();

		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("detailAddBox",language["pdetail"],600);
}
function detailAddBoxCat(data)
{
	
	var code = data.CODE;
	
	if(data.FDETAIL == "")
	{
		var actualdesc = data.DETAIL;
	}
	else
	{
		var actualdesc = data.FDETAIL;
	}
	
	
	var container = document.getElementById("detailAddBoxCat");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("input");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "text";
	floatBoxInput.className = "floatBoxInput";
	floatBoxInput.placeholder = language["newDesc"];
	floatBoxInput.value = actualdesc;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
	{
		var info = {};
		info.code = code;
		info.input = ($("#floatBoxInput").val());
		
		sendAjax("users","setNewDetCat",info,function(response)
		{
			var ans = response.message;
			hide_pop_form();
			document.getElementById("refreshButton").click();

		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("detailAddBoxCat",language["cdetail"],350);
}
function detailAddBoxExt(data)
{
	
	var code = data.CODE;
	
	if(data.FDETAIL == "")
	{
		var actualdesc = data.DETAIL;
	}
	else
	{
		var actualdesc = data.FDETAIL;
	}
	
	
	var container = document.getElementById("detailAddBoxCat");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("input");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "text";
	floatBoxInput.className = "floatBoxInput";
	floatBoxInput.placeholder = language["newDesc"];
	floatBoxInput.value = actualdesc;
	
	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
	{
		var info = {};
		info.code = code;
		info.input = ($("#floatBoxInput").val());
		
		sendAjax("users","setNewDetExt",info,function(response)
		{
			var ans = response.message;
			hide_pop_form();
			document.getElementById("refreshButton").click();

		});
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("detailAddBoxCat",language["cExt"],350);
}
function lineSetBox(data)
{
	
	var code = data.CODE;
	var actualCat = data.CAT;

	var container = document.getElementById("lineSetBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("select");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "select";
	floatBoxInput.className = "floatBoxInput";

	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
		{
			var info = {};
			info.code = code;
			info.input = ($("#floatBoxInput").val());
			
			sendAjax("users","setNewCat",info,function(response)
			{
				var ans = response.message;
				hide_pop_form();
				document.getElementById("refreshButton").click();

			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);
	
	refreshFcatList();
	
	
	floatBoxInput.value = actualCat;

	formBox("lineSetBox",language["pLine"],350);
}
function refreshFcatList()
{
		
	document.getElementById("floatBoxInput").innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "";
	document.getElementById("floatBoxInput").appendChild(option);
	
	var option = document.createElement("option");
	option.value = "none";
	option.innerHTML = "Sin línea";
	document.getElementById("floatBoxInput").appendChild(option);
	
	console.log(cats.length)
	
	for(var i=0; i<cats.length; i++)
	{
		
		var reg = cats[i];

		var option = document.createElement("option");
		option.value = reg.CODE;
		
		if(reg.FDETAIL != "")
		{
			var detail = reg.FDETAIL;
		}
		else
		{
			var detail = reg.DETAIL;
		}
		
		option.innerHTML = reg.CODE+" - "+detail;
		document.getElementById("floatBoxInput").appendChild(option);
	}
}
function orderStateSet(data)
{
	
	var code = data.OCODE;
	var actualCat = data.STATE;

	var container = document.getElementById("stateSetBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var icon = document.createElement("img");
	icon.src = "irsc/infoGeneral.png";
	icon.className = "infoLogo";
	icon.style.marginBottom = "10px";
	icon.style.marginTop = "4px";
	
	var floatBoxInput = document.createElement("select");
	floatBoxInput.id = "floatBoxInput";
	floatBoxInput.type = "select";
	floatBoxInput.className = "floatBoxInput";
	
	var option = document.createElement("option");
	option.value = "0";
	option.innerHTML = "Nuevo";
	floatBoxInput.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "1";
	option.innerHTML = "Digitado";
	floatBoxInput.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "2";
	option.innerHTML = "Despachado";
	floatBoxInput.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "3";
	option.innerHTML = "Devuelto";
	floatBoxInput.appendChild(option);
	
	var option = document.createElement("option");
	option.value = "4";
	option.innerHTML = "Anulado";
	floatBoxInput.appendChild(option);
	
	
	floatBoxInput.value = actualCat;

	var send = document.createElement("div");
	send.className = "dualButtonPop";
	send.innerHTML = language["save"];
	send.onclick = function()
		{
			var info = {};
			info.code = code;
			info.input = ($("#floatBoxInput").val());
			
			sendAjax("users","setOstate",info,function(response)
			{
				var ans = response.message;
				hide_pop_form();
				document.getElementById("refreshButtonO").click();

			});
		}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButtonPop";
	cancel.innerHTML = language["cancel"];
	cancel.onclick = function(){hide_pop_form()};
	
	container.appendChild(icon);
	container.appendChild(floatBoxInput);
	container.appendChild(send);
	container.appendChild(cancel);

	formBox("stateSetBox",language["oState"],350);
}
function zStarter()
{
	var info = {};
	sendAjax("users","zStarter",info,function(response)
	{
		var ans = response.message;
		var zones = ans.zones;
		var headers = ans.headers;
		console.log(ans)
		setHeaders(headers);

		tableCreator("zonesList", zones);

	});
}
function setHeaders(list)
{
	var fields= [];
	var lp1 = document.getElementById("zPl1");
	var lp2 = document.getElementById("zPl2");
	var lp5 = document.getElementById("zPl5");
	// var lp3 = document.getElementById("zPl3");
	// var lp4 = document.getElementById("zPl4");
	
	lp1.innerHTML = "";
	lp2.innerHTML = "";
	// lp3.innerHTML = "";
	// lp4.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona";
	
	lp1.appendChild(option);
	lp2.appendChild(option.cloneNode(true));
	// lp3.appendChild(option.cloneNode(true));
	// lp4.appendChild(option.cloneNode(true));
	
	for(var i=0; i<list.length; i++)
	{
		field = list[i].Field;
		
		if(field != "CODE")
		{
			fields.push(field);
			
			var option = document.createElement("option");
			option.value = field;
			option.innerHTML = field;
			
			lp1.appendChild(option);
			lp2.appendChild(option.cloneNode(true));
			lp5.appendChild(option.cloneNode(true));
			// lp3.appendChild(option.cloneNode(true));
			// lp4.appendChild(option.cloneNode(true));

		}
	}

}
function saveZone(button)
{
	var action = button.innerHTML;
	
	if(action == "Crear"){action = "c";}
	else{action = "e";}

	var info = {};
	
	info.action = action;
	info.name = document.getElementById("zDetail").value;
	info.inv = document.getElementById("zArea").value;
	info.l1 = document.getElementById("zPl1").value;
	info.l2 = document.getElementById("zPl2").value;
	info.l5 = document.getElementById("zPl5").value;
	// info.l3 = document.getElementById("zPl3").value;
	// info.l4 = document.getElementById("zPl4").value;
	info.topD = document.getElementById("zDtop").value;
	info.top = document.getElementById("zBtop").value;
	info.topT = document.getElementById("zBtopT").value;
	
	
	info.MINFIRST = document.getElementById("zMinFirst").value;
	
	info.ecode = actualZeditCode;
	
	info.start = document.getElementById("zIniDate").value;
	info.end = document.getElementById("zEndDate").value;

	if(info.name == ""){alertBox(language["alert"], language["mustZname"], 300); return;}
	if(info.inv == ""){alertBox(language["alert"], language["mustZInv"], 300); return;}
	if(info.l1 == ""){alertBox(language["alert"], language["mustZpl1"], 300); return;}
	if(info.l2 == ""){alertBox(language["alert"], language["mustZpl2"], 300); return;}
	if(info.l5 == ""){alertBox(language["alert"], language["mustZpl5"], 300); return;}
	if(info.topD == ""){alertBox(language["alert"], language["mustDtop"], 300); return;}
	if(info.top == ""){alertBox(language["alert"], language["mustZtop"], 300); return;}
	if(info.MINFIRST == ""){alertBox(language["alert"], language["mustZminF"], 300); return;}
	
	if(info.start != "" && info.end == ""){alertBox(language["alert"], language["mustZstart"], 300); return;}
	
	if(info.start == "" && info.end != ""){alertBox(language["alert"], language["mustZend"], 300); return;}
	
	console.log(info)
	
	sendAjax("users","saveZone",info,function(response)
	{
		var ans = response.message;

		document.getElementById("zDetail").value = "";
		document.getElementById("zArea").value = "";
		document.getElementById("zPl1").value = "";
		document.getElementById("zPl2").value = "";
		document.getElementById("zPl5").value = "";
		// document.getElementById("zPl3").value = "";
		// document.getElementById("zPl4").value = "";
		document.getElementById("zBtop").value = "";
		document.getElementById("zIniDate").value = "";
		document.getElementById("zEndDate").value = "";
		
		document.getElementById("pCreateB").innerHTML = "Crear";
		
		zStarter();
		
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
		tableCreator("ordersItems", ans);
		actualOitems = ans;
		formBox("orderItemsBox",language["oDetail"],800);
	});
	
}
function showDeliverDates(code)
{
	var info = {};
	info.code = code;
	
	sendAjax("users","getDdates",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		tableCreator("deliverDates", ans);
		formBox("deliverDatesBox",language["dDetail"],400);
	});
	
}
function getOtotal(code, qty)
{
	
	var cost = 0;
	
	for(var i=0; i<actualOitems.length; i++)
	{
		var item = actualOitems[i];
		if(item.CODE == code)
		{
			actualOitems[i].DISPATCHED = qty;
		}
	}
	
	for(var i=0; i<actualOitems.length; i++)
	{
		var item = actualOitems[i];
		var qty = parseInt(item.DISPATCHED);
		var price = parseInt(item.PRICE);
		var sub = qty*price;
		cost += sub;
	}
	
	for(var i=0; i<actualOlist.length; i++)
	{
		var item = actualOlist[i];
		if(item.OCODE == actualOcode)
		{
			actualOlist[i].DISPATCHED = cost;
		}
	}

	return cost;
}
function saveUnable()
{
	var date = document.getElementById("repoIniDateU").value;
	
	if(date == "")
	{
		alertBox(language["alert"], language["mustDate"], 300);
		return;
	}
	
	var info = {};
	info.date = date;
	
	sendAjax("users","saveUnable",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		if(ans == "exist")
		{
			alertBox(language["alert"], language["alreadyUnable"], 300);
		}
		else
		{
			document.getElementById("repoIniDateU").value = "";
			getUnableList();
		}
	});
	
}
function getBanner()
{
	var info = {};
	
	sendAjax("users","getBanner",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		document.getElementById("repoBanner").value = ans;
	});
}
function saveBanner()
{
	var text = document.getElementById("repoBanner").value;
	
	var info = {};
	info.btext = text;
	
	sendAjax("users","saveBanner",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		alertBox(language["alert"], "Guardado exitoso", 300);
		
	});
	
}
function getUnableList()
{
	var info = {};
	
	sendAjax("users","getUnableList",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("unableList", ans);
	});
}
function getDdates()
{
	var info = {};
	info.code = actualZcode;
	
	console.log(info)
	
	sendAjax("users","getDdates",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("deliverDates", ans);
	});
}
function addDeliverDate()
{
	var date = document.getElementById("deliverDateField").value;
	
	if(date == "")
	{
		alertBox(language["alert"], language["mustDate"], 300);
		return;
	}
	
	var info = {};
	info.code = actualZcode;
	info.date = date;
	
	sendAjax("users","addDeliverDate",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		if(ans == "exist")
		{
			alertBox(language["alert"], language["alreadyUnable"], 300);
		}
		else if(ans == "banned")
		{
			alertBox(language["alert"], language["dateIsBanned"], 300);
		}
		else
		{
			document.getElementById("deliverDateField").value = "";
			getDdates();
		}
	});
	
}
//END APP CORE

// IMAGE LOAD
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

		// document.getElementById("imageSample").src = img;
		
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
function pickpic()
{
	document.getElementById("picSelector").click();
}
function picDeleteConfirm()
{
	var param = [];
	
	confirmBox(language["confirm"], language["confirmPicDel"],delPic, 300, param);
}
function delPic()
{
	var info = {};
	info.code = actualPicCode;
	
	sendAjax("users","picDelete",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		hide_pop_form();
		document.getElementById("refreshButton").click();
	});
}
function openPicSelector()
{
	formBox("cropBoxBox",language["cbTitle"],390);
}
function handleFileSelect(evt) 
{
		var pickSelector = document.getElementById('picSelector');
		var format = pickSelector.value.split(".")[1];
		
		var blankImg = document.createElement("img");
		blankImg.src = "irsc/imageSample.png";
		blankImg.id = "imageSample";
		blankImg.className = "imageSample";
		
		if(format != "jpg" && format != "JPG" && format != "JPEG" && format != "jpeg")
		{
			alertBox(language["alert"], language["wrongFormatPic"], 300);
			pickSelector.value = "";
			document.getElementById('sampleImageCox').innerHTML = "";
			document.getElementById('sampleImageCox').appendChild(blankImg);
			actualCroppedPic = "";
			return;
		}
		
		document.getElementById("btnCrop").style.display = "initial";
		document.getElementById("btnZoomIn").style.display = "initial";
		document.getElementById("btnZoomOut").style.display = "initial";
		document.getElementById("deletePic").style.display = "none";

}
function savepPic()
{
	
	var info = {};
	info.pic = actualCroppedPic;
	info.code = actualPicCode;
	
	sendAjax("users","picsave",info,function(response)
	{
		var ans = response.message;
		actualCroppedPic = "";
		alertBox(language["alert"], language["picDone"], 300);
		document.getElementById("refreshButton").click();
	});
}
//END IMAGE LOAD



function encry (str) 
{  
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);  
}
function decry (str) 
{  
    return decodeURIComponent(str);  
}
function sendAjax(obj, method, data, responseFunction, noLoader, asValue)
{
	
	 if(!noLoader)
	 {
		 showLoader = 1;
		setTimeout(function()
		{
			
			if(showLoader == 1)
			{
				$("#loaderDiv").show();
			}	
		},1000);
	 }
	 else
	 {
		 showLoader = 0;
	 }

	 var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
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
					if(showLoader == 1)
					{
						$("#loaderDiv").hide();
						showLoader = 0;
					}
					
				 }
				 catch(e)
				 {
					 console.log(data);
					if(showLoader == 1)
					{
						$("#loaderDiv").hide();
						showLoader = 0;
					}
				 }
			},
			error: function( jqXhr, textStatus, errorThrown )
			{ 
				$("#loaderDiv").fadeOut();
				console.log( errorThrown );
			}
		});
}
// -------------------------------REALLY USED LIMIT----------------------------------
//REG AND PROFILE
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
				var option = options[i].innerHTML;
				
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
				var option = options[i].innerHTML;
				
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
//END REG AND PROFILE
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
            return m;
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