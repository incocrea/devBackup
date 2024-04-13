// APP START START
$(document).ready( function()
{
	loadCheck();
	tail = "?r="+Math.random();
});
function loadCheck()
{
	langPickIni();
	document.getElementById("search-input").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){search();}});

	style = document.createElement('style');
	
	var css = ".form-control {border:1px solid #6d1f88 !important;}";
	addCssRule(css);
	var css = ".badge-danger {background-color: #8020b3 !important;}";
	addCssRule(css);
	var css = ".badge-primary {background-color: #de3ca7 !important;}";
	addCssRule(css);
	var css = ".card-product .card-body {padding: .0rem .0rem;}";
	addCssRule(css);
	
	var css = ".card-product {border-bottom-color: #ffffff !important;}";
	addCssRule(css);
	
	var css = ".card-product:before {border-color: #6d1f88 !important;}";
	addCssRule(css);
	
	var css = ".owl-carousel {display: block; max-width: 300px}";
	addCssRule(css);
	
	var css = ".table td, .table th {padding-left: 0.2rem}";
	addCssRule(css);
	
}
function exitPop()
{
	$("#QuickViewModal").modal("hide");
}
function addCssRule(css)
{
	if (style.styleSheet){style.styleSheet.cssText = css;}
	else{style.appendChild(document.createTextNode(css));}
	document.getElementsByTagName('head')[0].appendChild(style);
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
		sListRefresh();
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
function sListRefresh()
{
	var info = {};
	info.index = "";

	sendAjax("users","getSList",info,function(response)
	{
		var ans = response.message;
		actualPlist = ans;
		
		
		
		var list = actualPlist;
		
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			var criters = "";
			var certs = 0;
			
			criters += item.SNAME+" ";
			criters += item.LOCATION+" ";
			
			if(item.STYPE == "p")
			{
				criters += " estilista"+" profesional"+" ";
			}
			else
			{
				criters += " salón"+" peluquería"+" spa"+" ";
			}
			
			var item = list[i];
			
			if(item.SPEC1 == "1"){criters += language["sp1Desc"]+" "; certs++;}
			if(item.SPEC2 == "1"){criters += language["sp2Desc"]+" "; certs++;}
			if(item.SPEC3 == "1"){criters += language["sp3Desc"]+" "; certs++;}
			if(item.SPEC4 == "1"){criters += language["sp4Desc"]+" "; certs++;}
			if(item.SPEC5 == "1"){criters += language["sp5Desc"]+" "; certs++;}
			if(item.SPEC6 == "1"){criters += language["sp6Desc"]+" "; certs++;}
			
			item.criters = criters;
			item.certs = certs;
			
		}
		
		actualPlist.sort(compare);
		refreshPlist("pic", "");

	});
}
function compare(a,b) {
  if (a.certs < b.certs)
    return 1;
  if (a.certs > b.certs)
    return -1;
  return 0;
}
function search()
{
	var name = document.getElementById("search-input").value;
	refreshPlist("pic", name);
}
function refreshPlist(pic, name)
{

	var plistBox = document.getElementById("plistBox");
	plistBox.innerHTML = "";

	for(var i=0; i<actualPlist.length; i++)
	{
		var data = actualPlist[i];
		
		
		
		if(data.ENDATE<getNow(null, "1"))
		{
			continue;
		}
		console.log(data.ENDATE)
		console.log(getNow(null, "1"));
		
		// FILTER BLOCK----------
		// PIC
		if(pic == "pic"){if(data.HP == "0"){continue;}}	
		// DESC
		if(name != "")
		{
			name = name.toUpperCase();
			
			if(!data.criters.toUpperCase().includes(name))
			{
				continue;
			}
		}

		
		// FILTER BLOCK----------
		
		// MAIN BOX
		var mainPbox = document.createElement("div");
		mainPbox.className = "col-xl-2 col-lg-3 col-md-4 col-6";
		mainPbox.data = data;
		
		var text = data.SNAME;
		
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
		img.src = "../bcadmin/img/sites/"+data.SCODE+".jpg"+tail;
		

		// PROMO BADGE
		var promoBadge = document.createElement("span");
		
		
		if(data.STYPE == "p")
		{
			promoBadge.innerHTML = "Profesional";
			promoBadge.className = "badge badge-danger custom-badge label label-top-left";
		}
		else
		{
			promoBadge.innerHTML = "Salón de belleza";
			promoBadge.className = "badge badge-primary   custom-badge  label label-top-left";
		}

		imgWrap.appendChild(promoBadge);
		// if(data.STYPE == "p" ){}

		mainPbox.appendChild(subPbox);
		subPbox.appendChild(imgWrap);
		imgWrap.appendChild(img);

		// BOTTOM HALF----------------------
		
		// INFO WRAP
		var infoWrap = document.createElement("div");
		infoWrap.className = "card-body";
		
		// INFO TITLE
		var infoTitle = document.createElement("p");
		infoTitle.className = "card-text fixedH siteName";
		
		if(text[0] == "-"){text = text.substring(1);}
		
		infoTitle.innerHTML = text+" <br>";
		
		subPbox.appendChild(infoWrap);
		infoWrap.appendChild(infoTitle);
		
		
		// STARS BOX
		var starsBox = document.createElement("div");
		starsBox.className = "rating ratingCustom medalsBox";
		
		
		var spec1 = document.createElement("img");
		if(data.SPEC1 == "1"){spec1.src = "../bcadmin/irsc/sp1.png";}
		else{spec1.src = "../bcadmin/irsc/sp1g.png";}
		
		var spec2 = document.createElement("img");
		if(data.SPEC2 == "1"){spec2.src = "../bcadmin/irsc/sp2.png";}
		else{spec2.src = "../bcadmin/irsc/sp2g.png";}
		
		var spec3 = document.createElement("img");
		if(data.SPEC3 == "1"){spec3.src = "../bcadmin/irsc/sp3.png";}
		else{spec3.src = "../bcadmin/irsc/sp3g.png";}
		
		var spec4 = document.createElement("img");
		if(data.SPEC4 == "1"){spec4.src = "../bcadmin/irsc/sp4.png";}
		else{spec4.src = "../bcadmin/irsc/sp4g.png";}
		
		var spec5 = document.createElement("img");
		if(data.SPEC5 == "1"){spec5.src = "../bcadmin/irsc/sp5.png";}
		else{spec5.src = "../bcadmin/irsc/sp5g.png";}
		
		var spec6 = document.createElement("img");
		if(data.SPEC6 == "1"){spec6.src = "../bcadmin/irsc/sp6.png";}
		else{spec6.src = "../bcadmin/irsc/sp6g.png";}
		
		starsBox.appendChild(spec1);
		starsBox.appendChild(spec2);
		starsBox.appendChild(spec3);
		starsBox.appendChild(spec4);
		starsBox.appendChild(spec5);
		starsBox.appendChild(spec6);
		
		infoWrap.appendChild(starsBox);
	
		plistBox.appendChild(mainPbox);
	}
	
	if(self !== top) 
	{
		window.parent.setHeight();
	}
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

function setDetailData(data)
{
	
	var pic = document.getElementById("detImg");
	pic.src = "../bcadmin/img/sites/"+data.SCODE+".jpg"+tail;

	
	var text = data.SNAME;
	if(text[0] == "-"){text = text.substring(1);}
	var title = document.getElementById("detBoxTitle");
	title.innerHTML = text;
	
	actualSCode = data.SCODE;
	actualSname = data.SNAME;
	
	var detSp1 = document.getElementById("detSp1");
	var detSp2 = document.getElementById("detSp2");
	var detSp3 = document.getElementById("detSp3");
	var detSp4 = document.getElementById("detSp4");
	var detSp5 = document.getElementById("detSp5");
	var detSp6 = document.getElementById("detSp6");
	
	if(data.SPEC1 == "1"){detSp1.src =  "../bcadmin/irsc/sp1.png"+tail;}	
	else{detSp1.src =  "../bcadmin/irsc/sp1g.png"+tail;}
	
	if(data.SPEC2 == "1"){detSp2.src =  "../bcadmin/irsc/sp2.png"+tail;}	
	else{detSp2.src =  "../bcadmin/irsc/sp2g.png"+tail;}
	
	if(data.SPEC3 == "1"){detSp3.src =  "../bcadmin/irsc/sp3.png"+tail;}	
	else{detSp3.src =  "../bcadmin/irsc/sp3g.png"+tail;}
	
	if(data.SPEC4 == "1"){detSp4.src =  "../bcadmin/irsc/sp4.png"+tail;}	
	else{detSp4.src =  "../bcadmin/irsc/sp4g.png"+tail;}
	
	if(data.SPEC5 == "1"){detSp5.src =  "../bcadmin/irsc/sp5.png"+tail;}	
	else{detSp5.src =  "../bcadmin/irsc/sp5g.png"+tail;}
	
	if(data.SPEC6 == "1"){detSp6.src =  "../bcadmin/irsc/sp6.png"+tail;}	
	else{detSp6.src =  "../bcadmin/irsc/sp6g.png"+tail;}
	
	document.getElementById("phoneDet").innerHTML = "<b>Dirección: </b>"+data.ADDRESS +"<b><br>Teléfono: </b>"+data.PHONE + "<br><b> Correo: </b> "+data.EMAIL+"<br><b>"+data.LOCATION+"</b>";
	
	
	var pdetail = document.getElementById("pDetail");
	pdetail.innerHTML = data.DETAIL;
	$("#QuickViewModal").modal("show");

}
function showSpecDet(det)
{
	
	alertBox(language["detTit"+det],language["spectDet"+det]);
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
	console.log(actualSCode)
	document.getElementById("contactTitle").innerHTML = "Contactar a "+actualSname;
	
	$("#contactModal").modal("show");
	
}
function contactSend()
{

	var info = {};
	info.name = document.getElementById("nameField").value;
	info.mail = document.getElementById("mailField").value;
	info.message = document.getElementById("messageField").value;
	info.scode = actualSCode;

	if(info.name == "" || info.mail == "" || info.message == "")
	{
		alertBox(language["alert"],language["mustFieldsContact"]);
		return;
	}
	
	sendAjax("users","contactSend",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		alertBox(language["alert"],language["messageSent"]);
		$("#contactModal").modal("hide");
	});
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