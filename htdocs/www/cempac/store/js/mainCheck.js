// APP START START
$(document).ready( function()
{
	loadCheck();
	
});
function loadCheck()
{
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
	if (window.localStorage.getItem("acd")) 
	{
		var c = localStorage.getItem("acd");
		var info = {};
		info.c = c;

		sendAjax("users","rlAud",info,function(response)
		{
			userData = response.message;
			setLoged("1");
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
	}
	else
	{
		myLocation = "";
	}
	
	if(localStorage.getItem("wpck")){var state = localStorage.getItem("wpck");}
	else{var state = "0";}
	if(state == "1"){document.getElementById("willPick").checked = true;}else{document.getElementById("willPick").checked = false;}
	
	if(localStorage.getItem("lastDeliver"))
	{
		var lastDeliver = JSON.parse(localStorage.getItem("lastDeliver"));
		
		document.getElementById("dAddress").value = lastDeliver.ADDRESS;
		document.getElementById("dPhone").value = lastDeliver.PHONE;
	}
	
	
	starter(myLocation);

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
	0
	sendAjax("users","mailExist",info,function(response)
	{
		var ans = response.message;
		
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
		name = name.toLowerCase();
		name = toPhrase(name);
		
		var exit = document.createElement("span");
		exit.innerHTML = "Cerrar sesión";
		exit.className = "exitLink";
		exit.onclick = function()
		{
			logout();
		}
		logBoxIn.innerHTML = "Usuario: "+name;
		logBoxMin.innerHTML = "Usuario: "+name+" - ";
		logBoxMin.appendChild(exit);
	}
	else
	{
		logBoxIn.style.display = "none";
		logBoxMin.style.display = "none";
		
		logBoxOut.style.display = "initial";
		logBoxMout.style.display = "initial";
		
		logBoxIn.innerHTML = "";
		logBoxMin.innerHTML = "";

	}

}
function starter(loc)
{
	var info ={};
	info.loc = loc;
	info.locode = localStorage.getItem("lastLocode");
	info.group = [];
	
	selectGroup(info);

	sendAjax("users","starter",info,function(response)
	{
		var ans = response.message;

		forbidden = ans.forbidden;
		
		nextDelDate = ans.nextDel;
		if(nextDelDate == "setNextDay"){nextDelDate = getNextDay();}
		actualPlist = ans.products;
		refSpliter(actualPlist);
		actualZlist = ans.zones;
		actualClist = ans.cats;
		actualElist = ans.exts;
		isDescOn = "0";
		actualTop = 0;
		setPriceLists();
		getSetCart();

		actualDtop = getDtop();

	});
}
function getDtop()
{
	var list = actualZlist;
	console.log(list)
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		if(item.AREA == actualCart.LOC)
		{
			var dtop = parseInt(item.DTOP);
			break;
		}
	}
	
	return dtop;
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
			}
		}
		
		actualDeliverDate = date
		var infoLabel = document.getElementById("topInfoLabel");
		infoLabel.innerHTML = "La fecha estimada para entrega de tu pedido es: <b style='color: red;'>"+formatDate(date)+"</b>";

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
function selectGroup(info)
{
	if(localStorage.getItem("cart"))
	{
		actualCart = JSON.parse(localStorage.getItem("cart"));
	}
	else
	{
		actualCart = {};
		actualCart.LOC = myLocation;
		actualCart.ITEMS = [];
		
		localStorage.setItem("cart", JSON.stringify(actualCart));
	}
	
	for(var i=0; i<actualCart.ITEMS.length; i++)
	{
		info.group.push(actualCart.ITEMS[i].CODE);
	}
		
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
		actualCart.ITEMS = [];
		
		localStorage.setItem("cart", JSON.stringify(actualCart));
	}
	updateCart();
}
function setPriceLists()
{
	if(myLocation != "")
	{
		var locationDesc = actualCart.LOCDESC;
		
		for(var i=0; i<actualZlist.length; i++)
		{
			var reg = actualZlist[i];
			if(reg.NAME == locationDesc)
			{
				actualTop = getActualTop(reg);
				
				actualPl1 = reg.PL1;
				actualPl2 = reg.PL2;
				
				var wpck = localStorage.getItem("wpck");
				if(wpck == "1")
				{
					console.log("que hacer si recoge pedido con los precios")
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
				list[i].CODE = list[i].CODE+"-"+list[i].EXT;
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
	actualRlist = refs;
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
	for(var i=0; i<actualZlist.length; i++)
	{
		var reg = actualZlist[i];
		if(reg.NAME == actualCart.LOCDESC)
		{
			return reg.BTOP;
		}
	}
}
function refreshPlist()
{

	var items = actualCart.ITEMS;

	var plistBox = document.getElementById("plistBox");
	plistBox.innerHTML = "";

	for(var i=0; i<items.length; i++)
	{
		var data = items[i];
		
		var itemInfo = getPdata(data.CODE);
		
		var row = document.createElement("div");
		row.className = "media mb-2";
		
		var content = document.createElement("div");
		content.className = "media-body";
		
		var title = document.createElement("div");
		title.className = "mt-0 text-default";
		
		if(itemInfo.FDETAIL != ""){var tit = itemInfo.FDETAIL;}
		else{var tit = itemInfo.DETAIL;}
		
		if(tit[0] == "-"){tit = tit.substring(1);}
		
		var details = document.createElement("div");

		title.innerHTML = tit;
		
		row.appendChild(content);
		content.appendChild(title);
		
		var pricesTx = document.createElement("span");

		var modalSub = document.createElement("span");
		modalSub.className = "activePrice";
		
		if(isDescOn == "1")
		{
			
			var list = actualPl2;
			
			var price = itemInfo[list];
			price = price.replace(".00", "");
			price = price.replace(",", "");
			
			var subtotal = parseInt(data.QTY) * parseInt(price);
			modalSub.innerHTML = addCommas(subtotal);

			var dcto = actualSaving;
			var total = actualTotal2;
		}
		else
		{
			
			var list = actualPl1;
			
			var price = itemInfo[list];
			price = price.replace(".00", "");
			price = price.replace(",", "");
			
			var subtotal = parseInt(data.QTY) * parseInt(price);
			modalSub.innerHTML = addCommas(subtotal);
			
			var dcto = 0;
			var total = actualTotal1;
		}
		
		actualTotal = total;
		
		pricesTx.className = "activePrice";
		pricesTx.innerHTML = addCommas(price);

		
		var priceTit = document.createElement("span");
		priceTit.innerHTML = "Precio: ";
		
		var qtyTit = document.createElement("span");
		qtyTit.innerHTML = " | Cantidad: ";
		
		var qty = document.createElement("span");
		qty.className = "activePrice";
		qty.innerHTML = parseInt(data.QTY);
		
		var subTit = document.createElement("span");
		subTit.innerHTML = " | Subtotal: ";
		
		details.appendChild(priceTit);
		details.appendChild(pricesTx);
		details.appendChild(qtyTit);
		details.appendChild(qty);
		details.appendChild(subTit);
		
		details.appendChild(modalSub);

		content.appendChild(details);
		
		plistBox.appendChild(row);
		
		// UPDATE CART ITEMS
		var updatedP = {};
		updatedP.CODE = data.CODE;
		updatedP.QTY = data.QTY;
		updatedP.DESC = tit;
		updatedP.INVENTORY = localStorage.getItem("lastLoc");
		updatedP.PLIST = list;
		updatedP.PRICE = price;
		actualCart.ITEMS[i] = updatedP;

	}
	
	document.getElementById("mainSubTotal").innerHTML = addCommas(actualTotal1);
	
	document.getElementById("discLine").innerHTML = addCommas(dcto);
	
	document.getElementById("mainTotal").innerHTML = addCommas(total);
	
	desDelDate();
}
function removeItem(code)
{
	for(var i=0; i<actualCart.ITEMS.length; i++)
	{
		var icode = actualCart.ITEMS[i].CODE;
		
		if(icode == code)
		{
			actualCart.ITEMS.splice(i, 1);
		}
	}
	localStorage.setItem("cart", JSON.stringify(actualCart));
	getSetCart();
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
function setPickup(cb)
{
	console.log(actualCart.LOCDESC)
	var loc = actualCart.LOCDESC;
	if(checkValidZone(loc))
	{
		if(cb.checked){localStorage.setItem("wpck", "1");}
		else{localStorage.setItem("wpck", "0");}
		setPriceLists();
		updateCart();
	}
	else
	{
		document.getElementById("willPick").checked = false;
		localStorage.setItem("wpck", "0");
		
		$('#alertInvalidPick').modal('show');
	}
	return
	
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
	
	refreshPlist();

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
	guide.innerHTML = "¡Si tu pedido es superior a: <b class='discVal'>"+addCommas(actualTop)+"</b> recibes descuento en todos los productos!";
	
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
		
		guide.innerHTML = "<b>¡Felicidades, por tu valor de pedido tienes descuento en todos los productos!</b>";
		
		isDescOn = "1";
	}
	else
	{
		txtS.innerHTML = " -  Descuento: "+"<b class='discVal'>"+"$0"+"</b>";
		star.src = "secure/irsc/discIconG.png";
		isDescOn = "0";
	}
	
	if(actualTop == "0")
	{
		guide.innerHTML = "<b>¡Selecciona ubiación de entrega o recolección de tu pedido!</b>";
	}
	
	label.appendChild(txtV)
	label.appendChild(txtS)
	
	
	document.getElementById("locationLabel").innerHTML = "Ubicación de entrega: "+ actualCart.LOCDESC;
	

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
function goCart()
{
	if(myLocation == "")
	{
		closeOffsetMenu();
		$('#alertLocModal').modal('show');
	}
	else
	{
		if(actualCart.ITEMS.length == 0)
		{
			closeOffsetMenu();
			$('#alertEmptyModal').modal('show');
			return;
		}
		console.log(actualCart)
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
		if(actualCart.ITEMS.length == 0)
		{
			closeOffsetMenu();
			$('#alertEmptyModal').modal('show');
			return;
		}
		console.log(actualCart)
		location.replace("checkout.html");
	}
}

// ORDER SEND
function orderPreSend()
{
	if(userData == "")
	{
		$('#alertMustLogin').modal('show');
		return;
	}
	
	var dAddress = document.getElementById("dAddress").value;
	var dPhone = document.getElementById("dPhone").value;
		
	if(dAddress == "" || dPhone == "")
	{
		$('#alertMustAddress').modal('show');
		return;
	}
	
	
	// if(localStorage.getItem("wpck"))
	// {
		// var wpck = localStorage.getItem("wpck");
		
		// if(wpck == "1")
		// {
			// console.log("recoge")
		// }
		// else
		// {
			
			// if(actualTotal2 < actualDtop)
			// {
				// console.log("despacho no alcanza")
			// }
			// else
			// {
				
			// }
		// }
	// }
	
	document.getElementById("dtopLabel").innerHTML = addCommas(actualDtop);
	
	console.log(actualTotal2)
	console.log(actualDtop)
	
	if(actualTotal2 < actualDtop)
	{
		console.log("despacho no alcanza")
		$('#alertDtop').modal('show');
		return;
	}
	
	var label = document.getElementById("deliverConfirmText");
	var text = "<b style='color: black; font-size: 1rem;'>El total de tu pedido es: <br><b style='color: red; font-size: 1rem;'>"+addCommas(actualTotal)+"</b><br><br>La fecha de entrega aproximada es: <br><b style='color: red; font-size: 1rem;'>"+formatDate(actualDeliverDate)+"</b><br><br>¿Aceptas esta fecha de entrega y deseas envíar tu pedido ahora?</b>"
	
	label.innerHTML = text;
	
	$('#preOrderModal').modal('show');
	// $('#orderSent').modal('show');
}
function orderSend()
{
	
	var dAddress = document.getElementById("dAddress").value;
	var dPhone = document.getElementById("dPhone").value;
	
	var lastDeliver = {};
	lastDeliver.ADDRESS = dAddress;
	lastDeliver.PHONE = dPhone;
	localStorage.setItem("lastDeliver", JSON.stringify(lastDeliver));

	var info = {};
	info.dAddress = dAddress;
	info.dPhone = dPhone;
	info.locDesc = actualCart.LOCDESC;
	info.inventory = actualCart.LOC;
	info.items = actualCart.ITEMS;
	info.ucode = userData.UCODE;
	info.uname = userData.NAME;
	info.umail = userData.EMAIL;
	info.uIdType = userData.IDTYPE;
	info.uIdNum = userData.IDN;
	
	if(localStorage.getItem("wpck"))
	{
		info.wpck = localStorage.getItem("wpck");
	}
	else
	{
		info.wpck = "0";
	}

	if(isDescOn == "1")
	{
		info.total = actualTotal2;
	}
	else
	{
		info.total = actualTotal1;
	}
	
	
	
	
	sendAjax("users","orderGet",info,function(response)
	{
		
		var ans = response.message;
		console.log(ans)
		$('#preOrderModal').modal('hide');
		
		$('#orderSent').modal('show');
		actualCart.ITEMS = [];
		localStorage.setItem("cart", JSON.stringify(actualCart));
		
		setTimeout(function(){location.replace("index.html");},4000);
		
		
		
	});

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
	var imported = document.createElement('script');
	imported.src = 'js/general.js';
	document.head.appendChild(imported);
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
				$("#loaderDiv").fadeIn();
			}	
		},1000);
	 }

	 var k = ([]+{})[!+[]+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+[]+[])+(+!![]+[])+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!+[]+!![]+[])+(+[]+[])+(+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]+!![]+[]);
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
