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
function goReg()
{
	console.log(actualCart)
	location.replace("register.html");
}
function langGetIni(l) 
{
	var info ={};
	info.lang = l;
	sendAjax("lang","langGet",info,function(response)
	{
		language = response.message;
		setLang();
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
function login()
{
	var email = document.getElementById("InputUsername").value;
	var pssw = document.getElementById("InputPassword").value;
	
	var info = {};
	info.autor = email;
	info.pssw = pssw;
	
	console.log(info)
	
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
			userData = ans;
			localStorage.setItem("acd", userData.UCODE);
			location.replace("index.html")
			$('#LoginModal').modal('hide');
			
		}
	});
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
function register()
{
	var info = {};
	info.name = document.getElementById("rName").value;
	info.email = document.getElementById("rEmail").value;
	info.rIdtype = $( "#rIdtype option:selected" ).text();
	info.idnumber = document.getElementById("rId").value;
	info.address = document.getElementById("rAddress").value;
	info.phone = document.getElementById("rPhone").value;
	info.pass1 = document.getElementById("rPassword1").value;
	info.pass2 = document.getElementById("rPassword2").value;
	info.pass = document.getElementById("rPassword1").value;
	info.isreging = "1";
	info.lang = lang;
	
	// VERIFICATIONS
	
	console.log(info)
	
	if(info.name == "" || info.email == "" || info.rIdtype == "" || info.idnumber == "" || info.address == ""  || info.phone == "" || info.pass1 == "" || info.pass2 == "" || info.idtype == "" || info.idnumber == "")
	{
		$('#alertMustFields').modal('show');
		return;
	}
	
	var checked = document.getElementById("condCheck").checked;
	
	if(!checked)
	{
		$('#alertMustCheck').modal('show');
		return;
	}
	
	if(info.pass1 != info.pass2)
	{
		$('#alertPassMatch').modal('show');
		return;
	}

	sendAjax("users","register",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(ans == "exists")
		{
			$('#alertExistPass').modal('show');
			
			return;
		}
		else
		{
			
			$('#alertRegSuccess').modal('show');
			
			setTimeout(function()
			{
				document.getElementById("InputUsername").value = info.email;
				document.getElementById("InputPassword").value = info.pass;
				login();
				
			}, 3000);
			
			
		}
		

	});
	
	
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
	actualCart = JSON.parse(localStorage.getItem("cart"));
	console.log(actualCart)
	if(actualCart.ITEMS.length == 0)
	{
		closeOffsetMenu();
		$('#alertEmptyModal').modal('show');
		return;
	}
	else
	{
		location.replace("cart.html");
	}
	
	

}
function goCheckOut()
{
	actualCart = JSON.parse(localStorage.getItem("cart"));
	console.log(actualCart)
	if(actualCart.ITEMS.length == 0)
	{
		closeOffsetMenu();
		$('#alertEmptyModal').modal('show');
		return;
	}
	else
	{
		location.replace("checkout.html");
	}
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
function getGeneral()
{
	var imported = document.createElement('script');
	imported.src = 'js/general.js';
	document.head.appendChild(imported);
	
	if(localStorage.getItem("actualZoneFM"))
	{
		actualZoneFM = localStorage.getItem("actualZoneFM");
		console.log(actualZoneFM)
		
		document.getElementById("regWarning").innerHTML = "El primer pedido mínimo para tu zona deberá ser de: "+addCommas(actualZoneFM);
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
