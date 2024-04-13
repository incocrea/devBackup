$(document).ready( function()
{
	
	tail = "?r="+Math.random();
	if(findGetParameter("id"))
	{
		actualId = findGetParameter("id");
		liveRefresh();
		getStoreData(actualId);
	}
	
});
function getStoreData(id)
{
	var info = {};
	info.code = id;
	
	sendAjax("users","getStoreData",info,function(response)
	{
		var ans = response.message;
		
		
		actualUdata = ans.user;
		actualPremium = actualUdata.PREMIUM;
		console.log(actualPremium)
		services = ans.services;
		actualAllpros = ans.allpros;
		actualSaloons = ans.saloons;
		var skills = [];
		var list = ans.pros;
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			
			var sks = JSON.parse(item.SKILLS);
			for(var j=0; j<sks.length; j++)
			{
				var item2 = sks[j];
				if(!skills.in_array(item2)){skills.push(item2)}
			}
			
		}
		actualServices = skills;
		
		myServices = [];
		var list = services;
		for(var i=0; i<list.length; i++)
		{
			var item = list[i];
			var code = item.SRCODE;
			if(actualServices.in_array(code)){myServices.push(item);}
		}
		
		var frontPic = document.getElementById("home");
		
		if(actualUdata.HPF == "1")
		{
			
			frontPic.style.backgroundImage = "url('img/frontPics/"+actualUdata.UCODE+".jpg"+tail+"')";
			
			console.log("1")
		}
		else
		{
			frontPic.style.backgroundImage = "url('img/frontPics/default.jpg')";
			console.log("2")
		}

		
		sloop = "";
		
		for(var i=0; i<myServices.length; i++)
		{
			var item = myServices[i];
			sloop +=item.DETAIL;
			sloop +=",";
		}
		
		var addressLine = document.getElementById("addressLine");
		var phoneLine = document.getElementById("phoneLine");
		var emailLine = document.getElementById("emailLine");
		
		addressLine.innerHTML = actualUdata.ADDRESS;
		phoneLine.innerHTML = actualUdata.PHONE;
		emailLine.innerHTML = actualUdata.EMAIL;
		
		var profPanel = document.getElementById("agPanelE");
		profPanel.style.display = "none";
		var ePanel = document.getElementById("agPanelC");
		ePanel.style.display = "none";
		
		servicesFiller();
		startNatural();
		setActualCities(actualSaloons);
		addDate();
		// actualPremium = "1";
		
		// if(actualPremium == "0")
		// {
			// document.getElementById("locker").style.display = "none";
		// }
		// else
		// {
			// document.getElementById("locker").style.display = "none";
		// }
		
	});
	
	
	
}
// ------AGENDA
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
function getServDetail(code)
{
	var list = services;
	
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
function getMyScoreForS(saloon)
{
	actualTrans = [];
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
		// scoreLabel.style.display = "none";
		// var field3 = document.getElementById("input3");
		// field3.innerHTML = "";
		// var option = document.createElement("option");
		// option.value = "";
		// option.innerHTML = "Selecciona profesional";
		// field3.appendChild(option);
		
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
function getSkillCost(code)
{
	var list = services;
	
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
function addDate()
{
	var container = document.getElementById("addDateBox");
	container.innerHTML = "";
	container.style.textAlign = "center";
	
	var input0 = document.createElement("input");
	input0.type = "text";
	input0.placeholder = "Nombre completo";
	input0.id = "input0";
	input0.className = "dateCreateInput";
	
	var inputT = document.createElement("input");
	inputT.type = "text";
	inputT.placeholder = "Teléfono";
	inputT.id = "inputT";
	inputT.className = "dateCreateInput";
	
	var input1 = document.createElement("select");
	input1.id = "input1";
	input1.className = "dateCreateSelect";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = "Selecciona ciudad";
	input1.appendChild(option);
	
	setDateCities(input1);
	
	var city = actualUdata.CITY;
	input1.value = city;
	
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
	save.className = "singleButton";
	save.innerHTML = "Crear cita";
	save.onclick = function ()
	{
		saveDateSend(0);
	}
	
	var cancel = document.createElement("div");
	cancel.className = "dualButton";
	cancel.innerHTML = "Cancelar";
	cancel.onclick = function(){hide_pop_form()};
	
	// container.appendChild(icon);
	container.appendChild(input0);
	container.appendChild(inputT);
	container.appendChild(input1);
	container.appendChild(input2);
	container.appendChild(myscore);
	container.appendChild(input3);
	container.appendChild(input4);
	
	container.appendChild(input5);
	container.appendChild(exchange);
	container.appendChild(save);
	// container.appendChild(cancel);
	jQuery.datetimepicker.setLocale("es");
	jQuery('#input5').datetimepicker();

	
	input1.style.display = "none";
	input1.value = actualUdata.CITY;
	input1.onchange();
	
	setTimeout(function()
	{
		
		var input2 = document.getElementById("input2Adate");
		input2.style.display = "none";
		input2.value = actualUdata.UCODE;
		input2.onchange();
		console.log("set")
		
	},50);
	
	
	// formBox("addDateBox",language["createDate"],400);

	
	
}
function saveDateSend(payway)
{
	payway = "0";
	saveDateState = "0";
	var info = {};
	info.city = $("#input1").val();
	info.saloon = $("#input2Adate").val();
	info.saloonName = $("#input2Adate option:selected").text();
	info.prof = $("#input3").val();
	info.profName = $("#input3 option:selected").text();
	info.treat = $("#input4").val();
	info.treatName = $("#input4 option:selected").text();
	info.saveDateState = saveDateState;
	info.editDateCode = "";
	info.payway = payway;
	info.skillCost = "0";
	

	if(saveDateState == "1")
	{
		info.date = $("#input5").val();
	}
	else
	{
		info.date = $("#input5").val()+":00";
	}
	
	
	info.ucode = "x";
	info.uname = document.getElementById("input0").value;
	info.cuphone = document.getElementById("inputT").value;
	
	var dateDate= new Date(info.date).getTime();
	var dateNow= new Date(getNow()).getTime();

		
	if(info.uname == "")
	{
		alert("Debes escribir tu nombre para la cita.")
		return;
	}
	if(info.cuphone == "")
	{
		alert("Debes escribir tu teléfono para la cita.")
		return;
	}
	if(info.prof == "")
	{
		alert("Debes seleccionar un profesional para la cita.")
		return;
	}
	if(info.treat == "")
	{
		alert("Debes seleccionar un procedimiento para la cita.")
		return;
	}
	if($("#input5").val() == "")
	{
		alert("Debes seleccionar una fecha y hora para la cita.")
		return;
	}
	if(dateDate < dateNow)
	{
		alert("Debes seleccionar una fecha y hora válidos para la cita.")
		return;
	}
	
	console.log(info)
	
	sendAjax("users","createDate",info,function(response)
	{
		var ans = response.message;
		
		console.log(ans);
		// return;
		
		if(ans == "cool")
		{
			alert("Se ha agendado tu cita con éxito!")
			clearfieldsDate("2");
			document.getElementById("input0").value = "";
			document.getElementById("inputT").value = "";
			document.getElementById("input5").value = "";
		}
		else if(ans == "NoProf")
		{
			alert("El profesional seleccionado ya tiene separado en este horario.")
		}
		else if(ans == "NoServD")
		{
			alert("No hay servicio al cliente el día seleccionado.")
		}
		else if(ans == "NoServH1")
		{
			alert("Ya se ha cerrado el sitio a la hora seleccionada.")
		}
		else if(ans == "NoServH2")
		{
			alert("Aún no han abierto el sitio a la hora seleccionada.")
		}
		else if(ans == "NoServH3")
		{
			alert("Este es horario de break, selecciona otra hora.")
		}
		
		saveDateState = "0";
		
		
		

	});

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
// ------AGENDA
function sendContact()
{
	var name = document.getElementById("nameField").value;
	var mail = document.getElementById("emailField").value;
	var message = document.getElementById("messageField").value;
	
	console.log(name.length)
	
	if(name == ""){return;}
	if(name.length < 10){return;}
	if(mail == ""){return;}
	if(message == ""){return;}

	var info = {};
	info.scode = actualUdata.UCODE;
	info.name = name;
	info.mail = mail;
	info.umail = actualUdata.EMAIL;
	info.message = message;
	
	console.log(info)

	// return;
	sendAjax("users","contactSendMS",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		document.getElementById("nameField").value = "";
		document.getElementById("emailField").value = "";
		document.getElementById("messageField").value = "";
		alert("¡Se ha enviado tu mensaje, pronto te responderemos!")
	});

}
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	imported.src = '../js/live.js';
	if(loc.includes("192")){document.head.appendChild(imported);}
	
}
function servicesFiller()
{
	var sbox = document.getElementById("servicesBox");
	sbox.innerHTML = "";
	
	var list = myServices;
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var box = document.createElement("div");
		box.className = "col-md-4";
		var boxa = document.createElement("div");
		boxa.className = "service-box";
		var boxa1 = document.createElement("div");
		boxa1.className = "service-ico";
		var spic = document.createElement("img");
		spic.classList = "servicePic";
		spic.src = "../../bcadmin/img/spics/"+item.SRCODE+".jpg"+tail;
		var boxa2 = document.createElement("div");
		boxa2.className = "service-content";
		boxa2.innerHTML = "<h2 class='s-title'>"+item.DETAIL+"</h2>";
		
		boxa1.appendChild(spic);
		boxa.appendChild(boxa1);
		boxa.appendChild(boxa2);
		box.appendChild(boxa);
		
		sbox.appendChild(box);
		
	}
	
	
	
}
function startNatural()
{
	var siteTitle = document.getElementById("siteTitle");
	siteTitle.innerHTML = actualUdata.NAME;
	var textSlider = document.getElementById("textSlider");
	textSlider.innerHTML = sloop;
	var aboutBlock = document.getElementById("aboutBlock");
	aboutBlock.innerHTML = actualUdata.ABOUT;
	
	
	
	(function ($) {
		"use strict";
		var nav = $('nav');
	  var navHeight = nav.outerHeight();
	  
	  $('.navbar-toggler').on('click', function() {
		if( ! $('#mainNav').hasClass('navbar-reduce')) {
		  $('#mainNav').addClass('navbar-reduce');
		}
	  })

	  // Preloader
	  $(window).on('load', function () {
		if ($('#preloader').length) {
		  $('#preloader').delay(100).fadeOut('slow', function () {
			$(this).remove();
		  });
		}
	  });

	  // Back to top button
	  $(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
		  $('.back-to-top').fadeIn('slow');
		} else {
		  $('.back-to-top').fadeOut('slow');
		}
	  });
	  $('.back-to-top').click(function(){
		$('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
		return false;
	  });

		/*--/ Star ScrollTop /--*/
		$('.scrolltop-mf').on("click", function () {
			$('html, body').animate({
				scrollTop: 0
			}, 1000);
		});

		/*--/ Star Counter /--*/
		$('.counter').counterUp({
			delay: 15,
			time: 2000
		});

		/*--/ Star Scrolling nav /--*/
		$('a.js-scroll[href*="#"]:not([href="#"])').on("click", function () {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html, body').animate({
						scrollTop: (target.offset().top - navHeight + 5)
					}, 1000, "easeInOutExpo");
					return false;
				}
			}
		});

		// Closes responsive menu when a scroll trigger link is clicked
		$('.js-scroll').on("click", function () {
			$('.navbar-collapse').collapse('hide');
		});

		// Activate scrollspy to add active class to navbar items on scroll
		$('body').scrollspy({
			target: '#mainNav',
			offset: navHeight
		});
		/*--/ End Scrolling nav /--*/

		/*--/ Navbar Menu Reduce /--*/
		$(window).trigger('scroll');
		$(window).on('scroll', function () {
			var pixels = 50; 
			var top = 1200;
			if ($(window).scrollTop() > pixels) {
				$('.navbar-expand-md').addClass('navbar-reduce');
				$('.navbar-expand-md').removeClass('navbar-trans');
			} else {
				$('.navbar-expand-md').addClass('navbar-trans');
				$('.navbar-expand-md').removeClass('navbar-reduce');
			}
			if ($(window).scrollTop() > top) {
				$('.scrolltop-mf').fadeIn(1000, "easeInOutExpo");
			} else {
				$('.scrolltop-mf').fadeOut(1000, "easeInOutExpo");
			}
		});

		/*--/ Star Typed /--*/
		if ($('.text-slider').length == 1) {
		var typed_strings = $('.text-slider-items').text();
			var typed = new Typed('.text-slider', {
				strings: typed_strings.split(','),
				typeSpeed: 30,
				loop: true,
				backDelay: 1300,
				backSpeed: 10
			});
		}

		/*--/ Testimonials owl /--*/
		$('#testimonial-mf').owlCarousel({
			margin: 20,
			autoplay: true,
			autoplayTimeout: 4000,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1,
				}
			}
		});

	})(jQuery);
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
		
	
	// UNCOMMENT FOR DEVELOPMENT
	$.ajax({
			type: 'POST',
			url: '../libs/php/mentry.php',
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
