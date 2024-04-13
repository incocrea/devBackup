// APP START START
$(document).ready( function()
{
	loadCheck();
});
function loadCheck()
{
	loadingNow = 1;
	// if (location.protocol != 'https:')
	// {
	 // location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
	// }
	langPickIni();
	
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
		getGeneral();
		
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
}
function checkLogin()
{
	
	
	console.log(imfoo)
	
	if (window.localStorage.getItem("acd")) 
	{
		var c = localStorage.getItem("acd");
		var info = {};
		info.c = c;
		
		if(imfoo == "profile"){var method = "rlAudPro";}
		else{	var method = "rlAud";}
		
		actualUcode = c;
		console.log(imfoo)
		
		
		sendAjax("users",method,info,function(response)
		{
			
			userData = response.message;
			
			console.log(userData)
			
			setLoged("1");
			
			if(imfoo == "profile")
			{
				var orders = response.orders;
				
				console.log(orders)
				
				document.getElementById("rName").value = userData.NAME;
				document.getElementById("rEmail").value = userData.EMAIL;
				document.getElementById("rAddress").value = userData.ADDRESS;
				document.getElementById("rPhone").value = userData.PHONE;
				document.getElementById("idType").value = userData.IDTYPE;
				document.getElementById("idNumber").value = userData.IDN;
				
				document.getElementById("rEmail").disabled = true;
				tableCreator("ordersList", orders);
			}
			
		});
	}
	else
	{
		userData = "";
		setLoged("0");
	}
	
	if(localStorage.getItem("lastLoc"))
	{
		myLocation = localStorage.getItem("lastLoc")
		locode = localStorage.getItem("lastLocode");
	}
	else
	{
		myLocation = "";
		locode = "";
		localStorage.setItem("lastLocode", locode);
		$('#alertZoneFirst').modal('show');
	}
	
	
	if(imfoo != "profile")
	{
		if(localStorage.getItem("wpck")){var state = localStorage.getItem("wpck");}
		else{var state = "0";}
		if(state == "1"){document.getElementById("willPick").checked = true;}else{document.getElementById("willPick").checked = false;}
		
		searchBox = document.getElementById("search-input");
		document.getElementById("search-input").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){search();}});
		
		starter(myLocation);
	}
	
}

function saveProfile()
{
	var info = {};
	info.name = document.getElementById("rName").value;
	info.email = document.getElementById("rEmail").value;
	info.address = document.getElementById("rAddress").value;
	info.phone = document.getElementById("rPhone").value;
	info.ucode = actualUcode;
	info.idtype = document.getElementById("idType").value;
	info.idnumber = document.getElementById("idNumber").value;
	
	
	if(!checkEmail(info.email))
	{
		alertBox(language["alert"], language["mustValidMailReg"]);
		return;
	}
	
	console.log(info)
	
	sendAjax("users","saveProfile",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		$('#alertSaved').modal('show');
	});
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
// TABLES
function tableCreator(tableId, list)
{
	var table = document.getElementById(tableId);
	
	console.log("loll")
	tableClear(tableId);
	
	
	
	var qty = list.length+" Items";
	if(list.length == 1){var qty = list.length+" Item";}
	if(list.length == 0)
	{
		var nInYet = document.createElement("div");
		nInYet.innerHTML = language["noResults"];
		nInYet.className = "blankProducts";
		table.appendChild(nInYet);
		resSet();
		
		if(tableId == "ordersList")
		{
			document.getElementById("orderWarn").innerHTML = language["warnOrderNo"];
		}
		
		return;
	}
	
	// ORDERS TABLE
	if(tableId == "ordersList")
	{
		
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var c = cellCreator('Fecha', list[i].DATE);
			var d = cellCreator('Total Pedido', addCommas(list[i].ORDERED));
			var e = cellCreator('Total Despachado', addCommas(list[i].DISPATCHED));
			

			
			if(list[i].ORDERED != list[i].DISPATCHED)
			{
				var dispatched = "<p style='color: red'>"+addCommas(list[i].DISPATCHED)+"</p>";
			}
			else
			{
				var dispatched = addCommas(list[i].DISPATCHED);
			}
			
			
			
			var z = cellCreator('Total Orden', dispatched);
			
						
			var detail = document.createElement("img");
			detail.reg = list[i];
			detail.setAttribute('title', "Detalle");
			detail.setAttribute('alt', "Detalle");
			detail.src = "images/yesdesc.png";
			detail.onclick = function()
			{
				var data = this.reg;
				actualOcode = data.OCODE;
				showOrderItems(data.OCODE);
			}

			var icons = [detail];
			var x = cellOptionsCreator('', icons)
			var cells = [c,d,e,x];
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	
	// ORDERS ITEMS
	if(tableId == "ordersItems")
	{
		
		
		console.log("lol1")
		
		
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var code = list[i].CODE.split("-")[0];
			
			
			console.log("lol2")
			
			var a = cellCreator('Código', code);
			var b = cellCreator('Detalle', list[i].DETAIL);
			var c = cellCreator('Pedido', list[i].REQUESTED);
			var d = cellCreator('Enviado', list[i].DISPATCHED);
			var st = parseInt(list[i].DISPATCHED)*parseInt(list[i].PRICE);
			var f= cellCreator('Subtotal', addCommas(st));
			
			// var stype = actualFooterData.STYPE;
			// console.log(stype);
			// if(stype == "1")
			// {
				// var price = "A cotizar";
				// var e = cellCreator('Precio', price);
				// var cells = [a,b,c,e];
				// document.getElementById("colSubtotal").style.display = "none";
			// }
			// else
			// {
				
			// }
			
			var price = addCommas(list[i].PRICE);
			var e = cellCreator('Precio', price);
			var cells = [a,b,c,d,e,f];
			document.getElementById("colSubtotal").style.display = "table-cell";
			
	
			var icons = [];

			var x = cellOptionsCreator('', icons)
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}
	}
	

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
function getSunday()
{
    var td = new Date(); 
	var nextSunday= new Date(td.getFullYear(),td.getMonth(),td.getDate()+(8-td.getDay()));
	
	var today = new Date(nextSunday);
	var dd = today.getDate();

	var mm = today.getMonth()+1; 
	var yyyy = today.getFullYear();
	if(dd<10) 
	{
		dd='0'+dd;
	} 

	if(mm<10) 
	{
		mm='0'+mm;
	} 
	today = yyyy+'-'+mm+'-'+dd+" 00:00:00";
	
	if(localStorage.getItem("sunKillDate"))
	{
		var killDate = localStorage.getItem("sunKillDate");
	}
	else
	{
		var killDate = today;
		localStorage.setItem("sunKillDate", killDate)
	}
	
	return killDate;
}
function getDomin()
{
	var td = new Date(); 
	var nextSunday= new Date(td.getFullYear(),td.getMonth(),td.getDate()+(8-td.getDay()));
	
	var today = new Date(nextSunday);
	var dd = today.getDate();

	var mm = today.getMonth()+1; 
	var yyyy = today.getFullYear();
	if(dd<10) 
	{
		dd='0'+dd;
	} 

	if(mm<10) 
	{
		mm='0'+mm;
	} 
	today = yyyy+'-'+mm+'-'+dd+" 00:00:00";
	return today;
}

function encry(str) 
{  
	return encodeURIComponent(str).replace(/[!'()*]/g, escape);  
}
function decry(str) 
{  
	return decodeURIComponent(str);  
}

function login()
{
	var email = document.getElementById("InputUsername").value;
	var pssw = document.getElementById("InputPassword").value;
	
	var info = {};
	info.autor = email;
	info.pssw = pssw;
	sendAjax("users","login",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		if(ans == "")
		{
			$('#alertWrongPass').modal('show');
		}
		else
		{
			$('#LoginModal').modal('hide');
			
			userData = ans;
			localStorage.setItem("acd", userData.UCODE);
			setLoged("1");
		}
	});
}
function logout()
{
	userData = "";
	localStorage.removeItem("acd");
	setLoged("0");
}
function passForgot()
{
	var mailField = document.getElementById("InputPassrec");
	mailField.value = "";
	$("#pssRecModal").modal("show");
}
function pssRecCheck()
{
	var mailField = document.getElementById("InputPassrec");
	var mail = mailField.value;
	var info = {};
	info.mail = mail;
	info.lang = lang;
	
    console.log(info)
	
	sendAjax("users","mailExist",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		if(ans == "notsent")
		{
			$("#pssRecNotModal").modal("show");
		}
		else
		{
			$("#pssRecYesModal").modal("show");
			$("#pssRecModal").modal("hide");
			$("#LoginModal").modal("hide");
		}
	});
	
}
function setLoged(mode)
{
	var logBoxOut = document.getElementById("logBoxOut");
	var logBoxMout = document.getElementById("logBoxMout");
	
	var logBoxIn = document.getElementById("logBoxIn");
	var logBoxMin = document.getElementById("logBoxMin");

	if(mode == "1")
	{
		
		logBoxIn.style.display = "initial";
		logBoxMin.style.display = "initial";
		
		logBoxOut.style.display = "none";
		logBoxMout.style.display = "none";
		
		var name = userData.NAME;
		name = name;
		name = toPhrase(name);
		
		var exit = document.createElement("span");
		exit.innerHTML = "Cerrar sesión";
		exit.className = "exitLink";
		exit.onclick = function()
		{
			logout();
		}
		logBoxIn.innerHTML = "<b onclick = 'goProfile()'>Perfil de cliente e historial de pedidos "+name+"</b>";
		logBoxMin.innerHTML = "<b onclick = 'goProfile()'>Perfil de cliente e historial de pedidos "+name+"</b> - ";
		logBoxMin.appendChild(exit);
		
		if(document.getElementById("profileLink"))
		{
			document.getElementById("profileLink").style.display = "initial";
		}
		
	}
	else
	{
		logBoxIn.style.display = "none";
		logBoxMin.style.display = "none";
		
		logBoxOut.style.display = "initial";
		logBoxMout.style.display = "initial";
		
		
		
		logBoxIn.innerHTML = "";
		logBoxMin.innerHTML = "";
		
		if(document.getElementById("profileLink"))
		{
			document.getElementById("profileLink").style.display = "none";
		}

	}

}
function starter(loc)
{
	var info ={};
	info.loc = loc;
	info.locode = locode;
	
	if(localStorage.getItem("zone"))
	{
		info.zone = localStorage.getItem("zone");
	}
	else
	{
		
	}
	
	
	info.group = [];
	
	
	$("#loaderDiv").show();
	
	console.log(info)

	sendAjax("users","starter",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		forbidden = ans.forbidden;
		
		// return;
		
		nextDelDate = ans.nextDel;
		hoy = ans.today;
		tomorrow = ans.tomorrow;
		// console.log(hoy);
		// console.log(tomorrow);
		// console.log(nextDelDate);
		// console.log(ans.enterTest);
		if(nextDelDate == "setNextDay"){nextDelDate = getNextDay();}
		actualPlist = ans.products;
		// console.log(actualPlist.length)
		refSpliter(actualPlist);
		actualZlist = ans.zones;
		actualClist = ans.cats;
		actualElist = ans.exts;
		setZones(actualZlist);
		setSearchBoxAhead();
		isDescOn = "0";
		actualTop = 0;
		searchDesc = "";
		setPriceLists();
		getSetCart();

		setCats(actualClist);
		
		var killDate = getSunday();
		
		if(getNow() > killDate)
		{
			actualCart.ITEMS.length = 0;
			console.log(actualCart)
			localStorage.setItem("cart", JSON.stringify(actualCart));
			getSetCart();
			
			var newKd = getDomin();
			console.log(newKd)
			localStorage.setItem("sunKillDate", newKd);
		}
		
		$("#loaderDiv").hide();
		
		getLongs();
		
		banner = ans.banner;
		if(document.getElementById("bannerText"))
		{
			document.getElementById("bannerText").innerHTML = banner;
		}
		
		// DIRECT LOAD------------------------------
		
		var cat1 = getUrlParameter("cat1");
		var cat2 = getUrlParameter("cat2");
		var cat3 = getUrlParameter("cat3");
		var cat4 = getUrlParameter("cat4");
		var cat5 = getUrlParameter("cat5");
		
		var picked = [];
		
		if(cat1 != null){picked.push(cat1);}
		if(cat2 != null){picked.push(cat2);}
		if(cat3 != null){picked.push(cat3);}
		if(cat4 != null){picked.push(cat4);}
		if(cat5 != null){picked.push(cat5);}
		
		
		for(var i=0; i<picked.length; i++)
		{var item = picked[i];	document.getElementById(item).checked = true;}
		if(picked.length > 0){search();}
		
		// DIRECT LOAD------------------------------
		
	});
}	
var getUrlParameter = function getUrlParameter(sParam) 
{
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) 
		{
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}
function restarter(loc)
{
	
	var thisLoc = getLoCode(actualCart.LOCDESC)
	console.log(thisLoc);
	
	localStorage.setItem("lastLocode",thisLoc);
	
	var info ={};
	info.loc = loc;
	info.locode = localStorage.getItem("lastLocode");
	info.group = [];
	
	$("#loaderDiv").show();
	
	console.log(info)
	
	sendAjax("users","starter",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		nextDelDate = ans.nextDel;
		if(nextDelDate == "setNextDay"){nextDelDate = getNextDay();}
		actualPlist = ans.products;
		console.log(actualPlist.length)
		refSpliter(actualPlist);
		isDescOn = "0";
		actualTop = 0;
		searchDesc = "";
		
		setZones(actualZlist);
		
		setPriceLists();
		getSetCart();
		setSearchBoxAhead();
		setCats(actualClist);
		search();
		
		$("#loaderDiv").hide();
		
		getLongs();
	});
}
function getLoCode(loc)
{
	for(var i=0; i<actualZlist.length; i++)
	{
		var reg = actualZlist[i];
		
		if(reg.NAME == loc)
		{
			return reg.CODE;
		}
	}
}
function getLongs()
{
	var info = {};
	info.location = myLocation;
	
	sendAjax("users","getLongs",info,function(response)
	{
		
		var ans = response.message;

		var longDescs = ans;
		
		for(var i=0; i<actualPlist.length; i++)
		{
			var item = actualPlist[i];
			
			var code = item.CODE;

			for(var j=0; j<longDescs.length; j++)
			{
				var item2 = longDescs[j];
				var code2 = item2.CODE;

				if(code == code2)
				{
					actualPlist[i].LONDESC = longDescs[j].LONDESC;
					break;
				}
			}
			
		}
		
		for(var i=0; i<actualRlist.length; i++)
		{
			var item = actualRlist[i];
			
			var code = item.CODE;

			for(var j=0; j<longDescs.length; j++)
			{
				var item2 = longDescs[j];
				var code2 = item2.CODE;

				if(code == code2)
				{
					actualRlist[i].LONDESC = longDescs[j].LONDESC;
					break;
				}
			}
			
		}
	});
	
}
function desDelDate()
{
	var date = nextDelDate;
	
	if(date == "blank")
	{
		var infoLabel = document.getElementById("topInfoLabel");
		infoLabel.innerHTML = "¡Selecciona la ubicación de entrega para conocer los precios y descuentos!";
	}
	else
	{
		if(localStorage.getItem("wpck"))
		{
			var wpck = localStorage.getItem("wpck");
			
			if(wpck == "1")	
			{			
				var date = getNextDay();
				console.log(date)
			}
		}
		
		console.log(date)
		
		var infoLabel = document.getElementById("topInfoLabel");
		infoLabel.innerHTML = " La fecha estimada para entrega de tu pedido es: <b style='color: red;'>"+formatDate(date)+"</b>";
		
		
		
		var infoLabel2 = document.getElementById("deliverPop");
		
		// console.log(infoLabel2)
		
		infoLabel2.innerHTML = "La fecha estimada para entrega es:<br><b style='color:red;'> "+formatDate(date)+"</b>, <br>Envío según términos y condiciones";

	}
}
function getNextDay()
{
	var plus = 1;
	var nextDay = new Date(getNow(plus));
	
	if((nextDay.getDay()==6))
	{plus = 3;}
	else if((nextDay.getDay()==0))
	{plus = 2;}
	
	var date = getNow(plus, "1");
	
	while(forbidden.in_array(date))
	{
		plus++;
		var date = getNow(plus, "1");
	}
	
	return date;
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
function getSetCart()
{
	if(localStorage.getItem("cart"))
	{
		actualCart = JSON.parse(localStorage.getItem("cart"));
	}
	else
	{
		actualCart = {};
		actualCart.LOC = myLocation;
		actualCart.LOCDESC = "";
		actualCart.ITEMS = [];
		
		localStorage.setItem("cart", JSON.stringify(actualCart));
	}
	updateCart();
}
function setPriceLists()
{
	if(myLocation != "")
	{
		var locPicker = document.getElementById("locationPicker");
		var locationDesc = locPicker.options[locPicker.selectedIndex].text;
		
		for(var i=0; i<actualZlist.length; i++)
		{
			var reg = actualZlist[i];
			
			if(reg.NAME == locationDesc)
			{
				actualTop = getActualTop(reg)
				console.log(reg)
				actualZoneFM = reg.MINFIRST;
				console.log(actualZoneFM)
				localStorage.setItem("actualZoneFM", actualZoneFM);
				
				actualPl1 = reg.PL1;
				actualPl2 = reg.PL2;
				actualPl5 = reg.PL5;

				var wpck = localStorage.getItem("wpck");
				if(wpck == "1")
				{
					// console.log("que hacer si recoge pedido con los precios")
					// actualPl1 = reg.PL2;
					// actualPl2 = reg.PL2;
				}
			}
		}

	}
	else
	{
		actualPl1 = "";
		actualPl2 = "";
		actualPl5 = "";
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
		
		if(list[i].EXT != "")
		{
			if(myLocation != "")
			{
				// list[i].CODE = list[i].CODE+"-"+list[i].EXT;
				list[i].CODE = list[i].CODE;
			}
		}
	}
	
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
	actualPlist = actualPlist.sort(compare);
	actualPlist = actualPlist.sort(compare2);
	actualRlist = refs;
}
function compare(a, b) 
{
	// Use toUpperCase() to ignore character casing
	const detailA = a.FDETAIL.toUpperCase();
	const detailB = b.FDETAIL.toUpperCase();

	let comparison = 0;
	
	if (detailA > detailB) 
	{
		comparison = 1;
	} 
	else if (detailA < detailB) 
	{
		comparison = -1;
	}
	return comparison;
}
function compare2(a, b) 
{
	// Use toUpperCase() to ignore character casing
	const detailA = a.PROMO;
	const detailB = b.PROMO;

	let comparison = 0;
	
	if (detailA < detailB) 
	{
		comparison = 1;
	} 
	else if (detailA > detailB) 
	{
		comparison = -1;
	}
	return comparison;
}
function setSearchBoxAhead()
{
	aheadOpts = [];
	for(var i=0; i<actualPlist.length; i++)
	{
		var pr = actualPlist[i];
		
		// if(pr.FDETAIL != ""){var desc = pr.FDETAIL;}
		// else{var desc = pr.DETAIL;}
		
		var desc = pr.FDETAIL;
		
		desc = desc;
		if(desc[0] == "-"){desc = desc.substring(1);}
		desc = toPhrase(desc);
		
		aheadOpts.push(desc);
	}
	
	// SET AUTOCOMPLETE FROM ARRAY
	// $('#search-input').typeahead({fitToElement: true,source: aheadOpts });
}
function setZones(list)
{
	var picker = document.getElementById("locationPicker");
	picker.innerHTML = "";
	var pickerFloat = document.getElementById("locationPickerFloat");
	pickerFloat.innerHTML = "";
	
	if(localStorage.getItem("cart"))
	{
		var savedLoc = JSON.parse(localStorage.getItem("cart")).LOCDESC;
	}
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona ubicación";
	picker.appendChild(option);
	pickerFloat.appendChild(option.cloneNode(true));
	
	for(var i=0; i<list.length; i++)
	{
		var reg = list[i];
		var option = document.createElement("option");
		option.value = reg.AREA;
		option.innerHTML = reg.NAME;
		picker.appendChild(option);
		pickerFloat.appendChild(option.cloneNode(true));

		if(reg.NAME == savedLoc)
		{
			// console.log(reg.NAME);
			// console.log(savedLoc);
			
			option.selected = true;
			localStorage.setItem("lastLocode", reg.CODE);
			locode = reg.CODE;
			
			
			var thistime = getNow();
		
			if(localStorage.getItem("lastAcc"))
			{var lastAcc = localStorage.getItem("lastAcc");}
			else
			{
				localStorage.setItem("lastAcc", thistime);
				var lastAcc = thistime;
			}

			if(thistime > lastAcc)
			{
				var now = new Date(thistime);
				var limit = new Date(add_minutes(new Date(lastAcc), 30).toString());
				
				if(now > limit)
				{
					console.log("show");
					localStorage.setItem("lastAcc", thistime);
					showZoneTops(reg.NAME);
				}
				else
				{
					if(loadingNow == 0){showZoneTops(reg.NAME);}
				}
			}
			else
			{showZoneTops(reg.NAME);}
			loadingNow = 0;
		}
		
	}

	myLocation = document.getElementById("locationPicker").value;
	// console.log("pasa 2")
	setCats(actualClist);
	
}
var add_minutes =  function (dt, minutes) 
{
    return new Date(dt.getTime() + minutes*60000);
}
function setCats(list)
{
	var catListBox = document.getElementById("catListBox");
	catListBox.innerHTML = "";
	
	// MAIN LINE
	var mainCline = document.createElement("div");
	mainCline.className = "custom-control custom-checkbox";
	
	// CBOX
	var cbox = document.createElement("input");
	cbox.type = "checkbox";
	cbox.value = "value";
	cbox.id = "cid-Promo";
	cbox.className = "custom-control-input";
	cbox.onchange = function()
	{
		if(this.checked)
		{
			document.getElementById("search-input").value = "";
			clearCats();
			search();
			this.checked = true;
		}
		else
		{
			clearCats();
			search();
		}
		
	}
	
	// LABEL
	var label = document.createElement("label");
	label.className = "custom-control-label";
	label.setAttribute("for", "cid-Promo");
	label.innerHTML = "Ofertas/Destacados";

	mainCline.appendChild(cbox);
	mainCline.appendChild(label);
	catListBox.appendChild(mainCline);
	
	for(var i=0; i<list.length; i++)
	{
		
		var data = actualClist[i];
		var ava = getCaTots(data.CODE, myLocation);
		if(ava == 0){continue};
		
		// MAIN LINE
		var mainCline = document.createElement("div");
		mainCline.className = "custom-control custom-checkbox";
		
		// CBOX
		var cbox = document.createElement("input");
		cbox.type = "checkbox";
		cbox.value = "value";
		cbox.id = "cid-"+data.CODE;
		cbox.className = "custom-control-input";
		cbox.onchange = function()
		{
			document.getElementById("search-input").value = "";
			search();
		}
		
		// if(data.FDETAIL != "")
		// {
			// var text = data.FDETAIL;
		// }
		// else
		// {
			// var text = data.DETAIL;
		// }
		
		var text = data.FDETAIL;
		
		// text = text+"("+ava+")";
		// text = toPhrase(text);
		
		
		// LABEL
		var label = document.createElement("label");
		label.className = "custom-control-label";
		label.setAttribute("for", "cid-"+data.CODE);
		label.innerHTML = text;
		
		mainCline.appendChild(cbox);
		mainCline.appendChild(label);

		catListBox.appendChild(mainCline);
	}
}
function locationSearch(picker)
{
	var locPicker = picker;
	var locationState = locPicker.value;
	var zone = $( "#locationPicker option:selected" ).text();
	
	console.log(zone)
	
	
	document.getElementById("willPick").checked = false;
	localStorage.setItem("wpck", "0");
	
	$('#alertZoneFirst').modal('hide');
	
	var locationDesc = locPicker.options[locPicker.selectedIndex].text;
	
	// showZoneTops(locationDesc);
	
	

	if(locationState == "")
	{
		myLocation = "";
		
		localStorage.removeItem("lastLoc");
		
		clearCats();
		var searchCats = getaCats();
		var catListBox = document.getElementById("catListBox");
		catListBox.innerHTML = "";
		actualCart.LOC = myLocation;
		actualCart.LOCDESC = locationDesc;
		localStorage.setItem("cart", JSON.stringify(actualCart));
		restarter(myLocation);
		// search();
		
		var infoLabel = document.getElementById("topInfoLabel");
		infoLabel.innerHTML = "¡Selecciona la ubicación de entrega para conocer los precios y descuentos!";

	}
	else
	{
		myLocation = locationState;
		actualCart.LOC = myLocation;
		actualCart.LOCDESC = locationDesc;
		localStorage.setItem("cart", JSON.stringify(actualCart));
		console.log("zonechange")
		restarter(myLocation);
		
	}

}
function showZoneTops(zone)
{
	
	var list = actualZlist
	console.log(zone)
	
	for(var i=0; i<list.length; i++)
	{
		var reg = list[i];
		var name = reg.NAME;
		
		console.log(name)
		console.log(zone)

		if(name == zone)
		{

			actualTop = getActualTop(reg);
			actualZoneFM = reg.MINFIRST;
			console.log(actualZoneFM)
			localStorage.setItem("actualZoneFM", actualZoneFM);

			$('#alertZoneData').modal('show');
			// var text = "El monto de pedido mínimo para envío a <b style='color: #0989d6'>"+name+"</b>, es de <b style='color: #0989d6'>"+addCommas(reg.DTOP)+" </b> pesos. <br><br> <b style='color: black'> Si el valor total de tu pedido supera los <b style='color: #0989d6'>"+addCommas(actualTop)+"</b> pesos recibes el mejor precio en todos los productos.</b><br><img class='infoImage' src='images/priceExp.jpg'/>"
			var text = "El monto de pedido mínimo para envío a <b style='color: #0989d6'>"+name+"</b>, es de <b style='color: #0989d6'>"+addCommas(reg.DTOP)+" </b> pesos. <br><br> <b style='color: black'> Si el valor total de tu pedido supera los <b style='color: #0989d6'>"+addCommas(actualTop)+"</b> pesos recibes el mejor precio en todos los productos.</b>"
			document.getElementById("mainInfoData").innerHTML = text;
			break;
		}
	}
	
}
function search()
{
	var locationState = document.getElementById("locationPicker").value;
	var pickupState = document.getElementById("willPick").checked;
	
	if(locationState == "")
	{
		myLocation = "";
		document.getElementById("willPick").checked = false;
		
		if(searchBox.value != "")
		{
			$('#alertLocModal').modal('show');
		}
		
		searchBox.value = "";
		searchDesc = "";
		actualTop = 0;
		clearCats();
		var searchCats = getaCats();

		refreshPlist("pic", "nzone", searchDesc, searchCats);
	}
	else
	{
		myLocation = locationState;
		localStorage.setItem("lastLoc", myLocation);
		actualTop = getaTop();
		actualPrices = getaPrices();
		
		if(cartValue >= actualTop){isDescOn = "1"}else{isDescOn = "0"}
		searchDesc = searchBox.value;
		if(searchDesc != ""){clearCats();}
		var searchCats = getaCats();
		
		refreshPlist("pic", myLocation, searchDesc, searchCats);
	}
	
	
}
function clearCats()
{
	
	var catListBox = document.getElementById("catListBox");
	var lines = catListBox.children;
	
	for(var i=0; i<lines.length; i++)
	{
		var line = lines[i];
		var box = line.children[0];
		box.checked = false;
	}

}
function getaCats()
{
	
	var catListBox = document.getElementById("catListBox");
	var lines = catListBox.children;
	var cats = [];
	
	for(var i=1; i<lines.length; i++)
	{
		var line = lines[i];
		var box = line.children[0];
		if(box.checked)
		{
			cats.push(box.id.split("-")[1]);
		}
	}
	
	return cats;
}
function getCaTots(cat)
{
	var count = 0;

	for(var i=0; i<actualPlist.length; i++)
	{
		var data = actualPlist[i];
		if(data.CAT == cat){count++;}
	}
	return count;
}
function getaPrices()
{
	for(var i=0; i<actualZlist.length; i++)
	{
		var reg = actualZlist[i];
		if(reg.CODE == myLocation)
		{
			var lists = [];
			lists[0] = reg.PL1
			lists[1] = reg.PL2
			return lists;
		}
	}
}
function getaTop()
{
	var locPicker = document.getElementById("locationPicker");
	var locationDesc = locPicker.options[locPicker.selectedIndex].text;
	
	for(var i=0; i<actualZlist.length; i++)
	{
		var reg = actualZlist[i];
		if(reg.NAME == locationDesc)
		{
			var actualTop = getActualTop(reg);
			return actualTop;
		}
	}
}
function refreshPlist(pic, zone, name, cat)
{

	var plistBox = document.getElementById("plistBox");
	plistBox.innerHTML = "";
	
	console.log(actualPlist)
	
	for(var i=0; i<actualPlist.length; i++)
	{
		var data = actualPlist[i];
		
		// FILTER BLOCK----------
		
		// PIC
		// if(pic == "pic"){if(data.HP == "0"){continue;}}	
		
		// ZONE
		// if(zone != "nzone"){if(data.AREA != zone){continue;}}
		
		// DESC
		if(name != "")
		{
			name = name.toUpperCase();
			
			// if(!data.DETAIL.toUpperCase().includes(name) && !data.FDETAIL.toUpperCase().includes(name))
			if(!data.FDETAIL.toUpperCase().includes(name))
			{
				if(data.LONDESC != null)
				{
					if(!data.LONDESC.toUpperCase().includes(name))
					{
						continue;
					}
				}
				else
				{
					continue;
				}
			}
		}

		// CATS
		if(cat.length > 0){if(!cat.in_array(data.CAT)){continue;}}
		else{if(name == ""){if(data.PROMO == "0"){continue;}}}

		// FILTER BLOCK----------
		
		// BRAND REPLACE -------
		var list = brands;
		
		for(var n=0; n<list.length; n++)
		{
			var brand = list[n].toLowerCase();
			var actual = data.FDETAIL.toLowerCase();
			
			if(actual.indexOf(brand) > -1)
			{
				var searchMask = brand;
				var re = new RegExp(searchMask, "ig");
				data.FDETAIL = data.FDETAIL.replace(re, brand.toUpperCase());
			}
		}
		// BRAND REPLACE -------
		
		
		// MAIN BOX
		var mainPbox = document.createElement("div");
		mainPbox.className = "col-xl-3 col-lg-4 col-6";
		mainPbox.data = data;
		
		// if(data.FDETAIL != "")
		// {
			// var text = data.FDETAIL;
		// }
		// else
		// {
			// var text = data.DETAIL;
		// }
		
		var text = decry(data.FDETAIL);

		mainPbox.onclick = function(){setDetailData(this.data);}
		
		// CONTENT BOX
		var subPbox = document.createElement("div");
		subPbox.className = "card card-product";
		
		// TOP HALF----------------------

		// IMG WRAP
		var imgWrap = document.createElement("div");
		imgWrap.className = "img-wrapper";
		
		// IMG
		var img = document.createElement("img");
		img.className = "card-img-top";
		img.src = "images/product/"+data.CODE+".jpg";
		
		// PROMO BADGE
		var promoBadge = document.createElement("span");
		promoBadge.className = "badge badge-danger custom-badge  label label-top-left borderWhite";
		promoBadge.innerHTML = "Oferta";
		
		// MARKED BADGE
		var markedBadge = document.createElement("span");
		markedBadge.className = "badge badge-success custom-badge  label label-top-left borderWhite";
		markedBadge.innerHTML = "Destacado";
		
		if(data.PROMO == "1" ){imgWrap.appendChild(markedBadge);}
		if(data.PROMO == "2" ){imgWrap.appendChild(promoBadge);}

		mainPbox.appendChild(subPbox);
		subPbox.appendChild(imgWrap);
		imgWrap.appendChild(img);
		
		// BOTTOM HALF----------------------
		
		// INFO WRAP
		var infoWrap = document.createElement("div");
		infoWrap.className = "card-body";
		
		// INFO TITLE
		var infoTitle = document.createElement("p");
		infoTitle.className = "card-text fixedH";
		
		if(text[0] == "-"){text = text.substring(1);}
		
		infoTitle.innerHTML = text+" <br>";

		// PRICES LINE 
		var pricesLine = document.createElement("ul");
		pricesLine.className = "card-text list-inline";
		
		// AVA LINE 
		var avaLine = document.createElement("ul");
		avaLine.className = "list-inline-item d-none d-sm-inline-block";
		
		// AVATEXT 
		var avatext = document.createElement("li");
		avatext.className = "list-inline-item d-sm-inline-block";
		var avatextTX = document.createElement("span");
		avatextTX.className = "badge badge-primary custom-badge label label-top-right borderWhite";
		
		// var avqty = parseInt(data.AVAILABLE.replace(/\s/g,''));
		var avqty = 1;
		
		if(avqty > 0)
		{
			// avatextTX.innerHTML = "Disponibles ("+data.AVAILABLE+")";
			avatextTX.innerHTML = "Disponible";
		}
		else
		{
			avatextTX.innerHTML = "No disponible";
		}
		
		if(data[actualPl1] == null || data[actualPl2] == null)
		{
			console.log("skip");
			continue;
		}
		
		// PRICE 1  
		var prices1 = document.createElement("li");
		// prices1.className = "list-inline-item";
		var prices1Tx = document.createElement("span");
		
		// PRICE 2  
		var prices2 = document.createElement("li");
		// prices2.className = "list-inline-item";
		var prices2Tx = document.createElement("span");

		if(myLocation == "")
		{
			var price1 = "Selecciona";
			var price2 = "Ubicación";
			prices1Tx.className = "activePrice";
			prices2Tx.className = "activePrice";
		}
		else
		{
			
			var price1 = data[actualPl1];
			var price2 = data[actualPl2];
			// SPECIAL LIST
			if(data[actualPl5] != null && data[actualPl5] != "null" && data[actualPl5] != "")
			{var price2 = data[actualPl5];}
			

			price1 = price1.replace(".00", "");
			price1 = price1.replace(",", "");

			price2 = price2.replace(".00", "");
			price2 = price2.replace(",", "");
			
		}

		prices1Tx.innerHTML = "<span style='color=#000000 !important; font-size: 0.8rem;'>Precio normal: </span>"+addCommas(price1);
		prices2Tx.innerHTML = "<span style='color=#000000 !important; font-size: 0.8rem;'>Con descuento: </span>"+addCommas(price2)+"<br>";
		avatext.appendChild(avatextTX);
		
		subPbox.appendChild(infoWrap);
		infoWrap.appendChild(infoTitle);
		prices1.appendChild(prices1Tx);
		prices2.appendChild(prices2Tx);
		
		// STARS BOX
		var starsBox = document.createElement("div");
		starsBox.className = "rating ratingCustom";
		
		var star1 = document.createElement("i");
		starsBox.appendChild(star1);

		var star2 = document.createElement("i");
		starsBox.appendChild(star2);
		
		var isDescOnTx = document.createElement("span");
		starsBox.appendChild(isDescOnTx);
		
		var star3 = document.createElement("i");
		starsBox.appendChild(star3);
		
		var star4 = document.createElement("i");
		starsBox.appendChild(star4);

		if(isDescOn == "1")
		{
			isDescOnTx.className = "isDescOnYes";
			isDescOnTx.innerHTML = " Con Descuento ";
			star1.className = "fa fa-star freeStar";
			star2.className = "fa fa-star freeStar";
			star3.className = "fa fa-star freeStar";
			star4.className = "fa fa-star freeStar";
			
			prices1Tx.className = "lockedPrice";
			prices2Tx.className = "activePrice";
			
			mainPbox.data.p1 = price2;
			mainPbox.data.p2 = price1;
		}
		else
		{
			isDescOnTx.className = "isDescOnNo";
			isDescOnTx.innerHTML = " Precio normal ";
			star1.className = "fa fa-star lockedStar";
			star2.className = "fa fa-star lockedStar";
			star3.className = "fa fa-star lockedStar";
			star4.className = "fa fa-star lockedStar";
			
			prices1Tx.className = "activePrice";
			prices2Tx.className = "lockedPrice";
			
			mainPbox.data.p1 = price1;
			mainPbox.data.p2 = price2;
		}
		
		prices1Tx.className = "lockedPrice";
		prices2Tx.className = "activePrice";
		
		if(myLocation == "")
		{
			var price1 = "Selecciona";
			var price2 = "Ubicación";
			prices1Tx.className = "activePrice";
			prices2Tx.className = "activePrice";
			prices1Tx.innerHTML = price1;
			prices2Tx.innerHTML = price2;
		}

		
		pricesLine.appendChild(prices2);
		pricesLine.appendChild(prices1);

		infoWrap.appendChild(pricesLine);
		infoTitle.appendChild(avatext);
		
		infoWrap.appendChild(pricesLine);
		if(myLocation != "")
		{
			// infoWrap.appendChild(starsBox);
		}
		
	
		plistBox.appendChild(mainPbox);
	}
	
	desDelDate();
}
function setDetailData(data)
{
	if(myLocation == "")
	{
		$("#alertZoneFirst").modal("show");
		return;
	}

	console.log(data)
	
	var pic = document.getElementById("detaImg");
	pic.src = "images/product/"+data.CODE+".jpg";
	
	var qtyField = document.getElementById("addQtyField");
	qtyField.value = 1;
	
	// if(data.FDETAIL != ""){var text = data.FDETAIL;	}
	// else{var text = data.DETAIL;}
	
	var text = data.FDETAIL;
	
	if(text[0] == "-"){text = text.substring(1);}
	var title = document.getElementById("detBoxTitle");
	title.innerHTML = text;
	
	
	
	actualPCode = data.CODE;
	actualPp1 = data.p1;
	actualPp2 = data.p2;
	
	setRefs(data);
	
	if(myLocation == "")
	{
		var price1 = "Selecciona";
		var price2 = "Ubicación";
		
		var p1Tx = document.getElementById("modalP1");
		p1Tx.innerHTML = price1;
		var p2Tx = document.getElementById("modalP2");
		p2Tx.innerHTML = price2;
		
		p1Tx.className = "activePrice";
		p2Tx.className = "activePrice";
		
	}
	else
	{
		var price1 = data[actualPl1];
		var price2 = data[actualPl2];
		// SPECIAL LIST
		if(data[actualPl5] != null && data[actualPl5] != "null" && data[actualPl5] != "")
		{var price2 = data[actualPl5];}
		
		price1 = price1.replace(".00", "");
		price1 = price1.replace(",", "");

		price2 = price2.replace(".00", "");
		price2 = price2.replace(",", "");
		
		var p1Tx = document.getElementById("modalP1");
		p1Tx.innerHTML = "Precio normal: "+addCommas(price1);
		var p2Tx = document.getElementById("modalP2");
		p2Tx.innerHTML = "Con descuento: "+addCommas(price2);
		
		
		if(isDescOn == "1")
		{
			p1Tx.className = "lockedPrice";
			p2Tx.className = "activePrice";
		}
		else
		{
			p1Tx.className = "activePrice";
			p2Tx.className = "lockedPrice";
		}
	}
	
	p1Tx.className = "lockedPrice";
	p2Tx.className = "activePrice";
	
	var longdesc = data.LONDESC;
	
	// var ava = data.AVAILABLE;
	var ava = 1;
	// var avqty = parseInt(data.AVAILABLE.replace(/\s/g,''));
	var avqty = 1;
	console.log(avqty)
	setAva(avqty);
	
	document.getElementById("lonDesc").innerHTML = longdesc;
	
	$("#QuickViewModal").modal("show");

}
function loadRef(value)
{
	
	var code = value.split("cl")[0];

	var data = getPdata(code);
	
	console.log(data);
	
	actualPCode = code;
	
	actualPp1 = data[actualPl1];
	actualPp2 = data[actualPl2];
	// SPECIAL LIST
	if(data[actualPl5] != null && data[actualPl5] != "null" && data[actualPl5] != "")
	{actualPp2 = data[actualPl5];}
	
	var pic = document.getElementById("detaImg");
	pic.src = "images/product/"+data.CODE+".jpg";

	// if(data.FDETAIL != ""){var text = data.FDETAIL;	}
	// else{var text = data.DETAIL;}
	
	var text = data.FDETAIL;
	
	if(text[0] == "-"){text = text.substring(1);}
	var title = document.getElementById("detBoxTitle");
	title.innerHTML = text;
	
	var longdesc = data.LONDESC;
	
	// var ava = data.AVAILABLE;
	var ava = 1;
	
	var avqty = 1;
	console.log(avqty)
	
	setAva(avqty);
	
	document.getElementById("lonDesc").innerHTML = longdesc;
	
}
function setAva(ava)
{
	
	var adderButton = document.getElementById("itemAdder");
	
	if(parseInt(ava) < 1)
	{
		adderButton.style.cssText  = "background-color: #cccccc !important;";
		adderButton.innerHTML = "No disponible";
		adderButton.onclick = function ()
		{
			alertBox(language["alert"], language["notAva"], 300);
		}
	}
	else
	{
		adderButton.style.cssText  = "background-color: #0989d6 !important;";
		adderButton.innerHTML = "Agregar al carrito";
		adderButton.onclick = function ()
		{
			addToCart();
		}
	}
}
function getPdata(code)
{
	var data = "";
	for(var i=0; i<actualPlist.length; i++)
	{
		var reg = actualPlist[i];
		if(reg.CODE == code)
		{
			data = reg;
		}
	}
	
	for(var i=0; i<actualRlist.length; i++)
	{
		var reg = actualRlist[i];
		if(reg.CODE == code)
		{
			data = reg;
		}
	}
	if(data != "")
	{
		return data;
	}
	else
	{
		return "ne";
	}
	
}
function setRefs(data)
{
	var code = data.CODE;
	
	var pickerBox = document.getElementById("refListBox");
	pickerBox.innerHTML = "";
	
	var refPicker = document.createElement("select");
	refPicker.className = "select-dropdown"
	
	pickerBox.appendChild(refPicker);
	
	var refs = [];
	refs[0] = data;

	for(var i=0; i<actualRlist.length; i++)
	{
		var ref = actualRlist[i];
		var rcode = ref.CODE.split("-")[0];
		var code = code.split("-")[0];
		
		if(rcode == code){refs.push(ref);}
	}

	for(var i=0; i<refs.length; i++)
	{
		var option = document.createElement("option");
		
		option.value = refs[i].CODE;
		
		if(refs[i].CODE.split("-").length > 1)
		{
			var extDesc = getExtDesc(refs[i].EXT);
			
			if(extDesc == []){extDesc = refs[i].EXT}
			else
			{
				var desc = extDesc[0];
				var color = extDesc[1];
			}
			
			if(color != "none")
			{
				option.value = refs[i].CODE+"cl"+color;
			}
			
			option.innerHTML = extDesc[0];
		}
		else
		{
			option.innerHTML = refs[i].CODE.split("-")[0];
		}
		refPicker.appendChild(option);
	}

	var i = 1;

	$('.select-dropdown').each(function() 
	{
		var t = $(this), tV = t.val();

		var tS = t.data('size');
		var tS = (tS == undefined) || (tS == '') ? '' : ' btn-'+tS;

		var tW = t.data('width');
		var tW = (tW == undefined) || (tW == '') ? 'min-width:10rem' : 'width:'+tW;

		var tMW = t.data('width');
		var tMW = (tMW == undefined) || (tMW == '') ? '' : 'style="min-width:'+tMW+'"';

		var sB = t.find('option:selected').data('before');
		var sB = (sB == undefined) || (sB == '') ? '' : sB;

		var st = sB+t.find('option:selected').html();

		var dI = '';
		t.find('option').each(function() {
		  var iB = ($(this).data('before') == undefined) || ($(this).data('before') == '') ? '' : $(this).data('before');
		  var ac = $(this).val() == tV ? ' active' : '';
		  
		  if($(this).val().split("cl").length > 1)
		  {
			var color = $(this).val().split("cl")[1];
		  }
		  else
		  {
			var color = "none";
		  }

		  
		  dI += '<button class="dropdown-item noPad'+ac+'" type="button" data-value="'+$(this).val()+'">'+iB+$(this).html()+'<span class="cample" style="background: '+color+';"></button>';
		});
		if (t.parent('.input-group-prepend').length) {
		  t.parent('.input-group-prepend').addClass('dropdown dropdown-select');
		  var dD = '<button class="btn btn-outline-default btn-select text-right dropdown-toggle'+tS+'" type="button" id="dropdownSelect'+i+'" \
					  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="'+tW+'">\
					  <span class="float-left cample">'+st+'lol</span>\
					</button>\
					<div class="smooth dropdown-menu" aria-labelledby="dropdownSelect'+i+'" '+tMW+'>\
					  '+dI+'\
					</div>';
		} else {
		  var dD = '<div class="dropdown dropdown-select" style="width: 100%;">\
					  <button class="escondido'+tS+'" type="button" id="dropdownSelect'+i+'" \
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="'+tW+'">\
						<span class="float-left">'+st+'lol</span>\
					  </button>\
					  <div class="smoothx dropdown-menux" aria-labelledby="dropdownSelect'+i+'" '+tMW+'>\
						'+dI+'\
					  </div>\
					</div>';
		
		var cample = document.createElement("div");
		cample.className = "cample";
		
		
		}
		var dD = dD.replace(/>[\n\t ]+</g, "><");
		t.prop('hidden',true);
		t.before(dD);
		i++;
	  });
	$('.dropdown-select').each(function() 
	{
		var t = $(this);
		var s = t.siblings('.select-dropdown').length ? t.siblings('.select-dropdown') : t.find('.select-dropdown');
		t.find('.dropdown-item').click(function() {
		  var tI = $(this), tC = tI.html(), tV = tI.data('value');
		  
		  if (s.val() != tV) {
			tI.parents('.dropdown').find('.dropdown-toggle').html('<span class="float-left">'+tC+'</span>');
			tI.parents('.dropdown').find('.dropdown-item.active').removeClass('active');
			tI.addClass('active');
			s.val(tV);
			loadRef(s.val());
			s.trigger('change');
		  }
		});
	});

}
// ADD TO CART
function addToCart()
{
	var qty = parseInt(document.getElementById("addQtyField").value);
	
	var exists = 0;
	
	console.log(actualPCode)
	
	for(var i=0; i<actualCart.ITEMS.length; i++)
	{
		var item = actualCart.ITEMS[i];

		if(item.CODE == actualPCode)
		{
			alertBox(language["alert"], "<img src='secure/irsc/infoGeneral.png' class='infoIcon'/><br>Este producto ya esta en tu carrito, para adicionar unidades debes hacerlo desde el carrito de compra");
			return;
			exists = 1;
			
			var qty1 = parseInt(actualCart.ITEMS[i].QTY);
			var qty2 = parseInt(qty);
			actualCart.ITEMS[i].QTY = qty1+qty2;
		}
	}

	if(exists == 0)
	{
		var cartItem = {};
		cartItem.CODE = actualPCode;
		cartItem.QTY = qty;

		// REVISAR ISSUE CEMPAC AQUI
		
		var valor1 = actualPp1.replace(".00", "");
		var valor1 = actualPp1.replace(",", "");
		
		var valor2 = actualPp2.replace(".00", "");
		var valor2 = actualPp2.replace(",", "");
		
		console.log(valor1)
		console.log(valor2)

		
		if(parseInt(valor1) < parseInt(valor2))
		{
			console.log("opt1")
			cartItem.P1 = actualPp2;
			cartItem.P2 = actualPp1;
		}
		else
		{
			console.log("opt2")
			cartItem.P1 = actualPp1;
			cartItem.P2 = actualPp2;
		}

		actualCart.ITEMS.push(cartItem);
	}

	updateCart();
	// $("#QuickViewModal").modal("hide");
	
	alertBox(language["alert"], "<img src='secure/irsc/infoGeneral.png' class='infoIcon'/><br>Producto agregado");
	setTimeout(function()
	{
		hideModal("alertsBox")
	}, 2000);
	
}
function exitProduct()
{
	$("#QuickViewModal").modal("hide");
}
function setPickup(cb)
{
	var loc = $("#locationPicker option:selected").text();
	if(checkValidZone(loc))
	{
		if(cb.checked){localStorage.setItem("wpck", "1");}
		else{localStorage.setItem("wpck", "0");}
		setPriceLists();
		updateCart();
	}
	else
	{
		cb.checked = false;
		localStorage.setItem("wpck", "0");
		
		$('#alertInvalidPick').modal('show');
	}
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
	
	localStorage.setItem("cart", JSON.stringify(actualCart));
	
	getCartValue();

}
function getCartValue()
{
	actualCart = JSON.parse(localStorage.getItem("cart"));

	actualTotal1 = 0;
	actualTotal2 = 0;
	
	if(actualPl1 != "" && actualPl2 != "")
	{

		var puffList = [];
		
		cartValue = 0;

		for(var i=0; i<actualCart.ITEMS.length; i++)
		{

			var qty = actualCart.ITEMS[i].QTY;
			var code = actualCart.ITEMS[i].CODE;

			if(getPdata(code) != "ne")
			{
				var price = getPdata(code)[actualPl1];
				price = price.replace(".00", "");
				price = price.replace(",", "");
				var subtotal = qty*price;
				cartValue += parseInt(subtotal);
			}
			else
			{
				puffList.push(code);
			}
			
		}

		actualTotal1 = cartValue;
		
		cartValue = 0;
		for(var i=0; i<actualCart.ITEMS.length; i++)
		{
			var qty = actualCart.ITEMS[i].QTY;
			var code = actualCart.ITEMS[i].CODE;
			
			if(getPdata(code) != "ne")
			{
				var price = getPdata(code)[actualPl2];
				price = price.replace(".00", "");
				price = price.replace(",", "");
				var subtotal = qty*price;
				cartValue += parseInt(subtotal);
			}
			else
			{
				puffList.push(code);
			}
		}
		
		actualTotal2 = cartValue;

		clearCart(puffList);
		search();
		
	}
	else
	{
		search();
	}
	
	actualSaving = actualTotal1-actualTotal2;

	// console.log(actualTop)
	// console.log(actualTotal1)
	// console.log(actualTotal2)
	// console.log(actualSaving)
	
	setDiscLabel();


}
function setDiscLabel()
{
	var guide = document.getElementById("topGuide");
	guide.innerHTML = "¡Si el valor total de tu pedido supera los: <b class='discVal'>"+addCommas(actualTop)+"</b> pesos, recibes descuento en todos los productos!";
	
	var guideDetail = document.getElementById("topDetailInfo");
	guideDetail.innerHTML = "¡Si el valor total de tu pedido supera los: <b class='discVal'>"+addCommas(actualTop)+"</b> pesos,  recibes descuento en todos los productos!";
	
	var label = document.getElementById("discountLabel");
	label.innerHTML = "";
	
	var star = document.createElement("img");
	star.className = "discStar"; 
	
	
	var txtV = document.createElement("span");
	txtV.innerHTML = "Valor pedido: "+"<b class='orderVal'>"+addCommas(actualTotal1)+"</b>";
	
	var txtS = document.createElement("span");
	
	if(actualTotal1 > actualTop)
	{
		txtS.innerHTML = " - Descuento: "+"<b class='discVal'>"+addCommas(actualSaving)+"</b>";
		star.src = "secure/irsc/discIcon.png";
		
		guide.innerHTML = "<b>¡Felicidades por tu valor de pedido, tienes descuento en todos los productos!</b>";
		guideDetail.innerHTML = "<b>¡Felicidades por tu valor de pedido, tienes descuento en todos los productos!</b>";
	}
	else
	{
		txtS.innerHTML = " -  Descuento: "+"<b class='discVal'>"+"$0"+"</b>";
		star.src = "secure/irsc/discIconG.png";
	}
	
	if(actualTop == "0")
	{
		guide.innerHTML = "<b>¡Selecciona ubiación de entrega o recolección de tu pedido!</b>";
	}

	label.appendChild(txtV)
	label.appendChild(txtS)
	// label.appendChild(star)

}
function clearCart(list)
{

	if(list.length > 0)
	{
		for(var i= 0; i<list.length; i++)
		{
			var dcode = list[i];
			
			for(var j=0; j<actualCart.ITEMS.length; j++)
			{
				var code = actualCart.ITEMS[j].CODE;
				
				if(code == dcode)
				{
					actualCart.ITEMS.splice(j, 1);
				}
			}
		}
	}

	localStorage.setItem("cart", JSON.stringify(actualCart));
	document.getElementById("cartCount").innerHTML = actualCart.ITEMS.length;
	document.getElementById("cartCountX").innerHTML = actualCart.ITEMS.length;
	
	// updateCart();
	
}
function closeOffsetMenu()
{
	body = $('body');
	offcanvasOpen  = 'offcanvas-open';
	if(body.hasClass(offcanvasOpen))
	{
		mh.removeClass(mhA);
		setTimeout(function() {
			
		  body.toggleClass(offcanvasOpen); $('html, body').toggleClass('offcanvas-overflow');
		},10);
	}
}
function goProfile()
{
	if(myLocation == "")
	{
		closeOffsetMenu();
		$('#alertLocModal').modal('show');
	}
	else
	{
		location.replace("profile.html");
	}
}
function goCart()
{
	if(myLocation == "")
	{
		closeOffsetMenu();
		$('#alertLocModal').modal('show');
	}
	else
	{
		if(imfoo != "profile")
		{
			if(actualCart.ITEMS.length == 0)
			{
				closeOffsetMenu();
				$('#alertEmptyModal').modal('show');
				return;
			}
			// console.log(actualCart)
		}
		location.replace("cart.html");
	}
}
function goCheckOut()
{
	if(myLocation == "")
	{
		closeOffsetMenu();
		$('#alertLocModal').modal('show');
	}
	else
	{
		if(imfoo != "profile")
		{
			if(actualCart.ITEMS.length == 0)
			{
				closeOffsetMenu();
				$('#alertEmptyModal').modal('show');
				return;
			}
		}
		// console.log(actualCart)
		location.replace("checkout.html");
	}
}
function goReg()
{
	console.log(actualCart)
	location.replace("register.html");
}
function getExtDesc(code)
{
	var detail = [];
	
	for(var i=0; i<actualElist.length; i++)
	{
		var reg = actualElist[i];
		if(reg.CODE == code)
		{
			// if(reg.FDETAIL != "")
			// {
				// var desc = reg.FDETAIL;
			// }
			// else
			// {
				// var desc = reg.DETAIL;
			// }
			
			var desc = reg.FDETAIL;
			
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
function toPhrase(string)
{
  return string.charAt(0).toUpperCase() + string.slice(1);
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
function getGeneral()
{
	if(imfoo != "profile")
	{
		var imported = document.createElement('script');
		imported.src = 'js/general.js';
		document.head.appendChild(imported);
	}

	
	
}
// COMMS
function sendAjax(obj, method, data, responseFunction, noLoader, asValue)
{
	 showLoader = 1;
	 
	 if(!noLoader)
	 {
		setTimeout(function()
		{
			if(showLoader == 1)
			{
				
			}	
		},1);
	 }

	 // var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
	 var info = {};
	 info.class = obj;
	 info.method = method;
	 info.data = data;

	$.ajax({
			type: 'POST',
			url: 'secure/libs/php/mentry.php',
			contentType: 'application/json',
			data: JSON.stringify(info),
			cache: false,
			async: true,
			success: function(data){

				 try
				 {
					var tmpJson = $.parseJSON(data);
					responseFunction(tmpJson.data);
					
					// showLoader = 0;
				 }
				 catch(e)
				 {
					 console.log(data);
					 // $("#loaderDiv").hide();
					 // showLoader = 0;
				 }
			},
			error: function( jqXhr, textStatus, errorThrown )
			{ 
				$("#loaderDiv").fadeOut();
				console.log( errorThrown );
			}
		});
}
