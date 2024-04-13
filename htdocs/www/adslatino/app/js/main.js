// APP START START
jQuery(document).ready( function(){loadCheck();});
function loadCheck()
{
	langPickIni();
	
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
	
	// jQuery("#username").on('keyup', function (e) { if (e.keyCode === 13) {login();}});
	// jQuery("#password").on('keyup', function (e) { if (e.keyCode === 13) {login();}});
	
	
	actualTitFont = "Roboto";
	actualDescFont = "Roboto";
	actualCroppedPic = "";
	
	actualAvatar = "0";
	actualLiked = [];
	theCroppie = null;
	
	gfonts = ['Anton','Eczar', 'Ranchers', 'Josefin Sans', 'Nerko One', 'Gloria Hallelujah', 'Indie Flower', 'Roboto', 'Slackey', 'Yeon Sung', "Roboto", "Open Sans", "Lato", "Oswald", "Roboto Condensed", "Montserrat", "Source Sans Pro", "Raleway", "PT Sans", "Playfair Display", "Bitter", "Libre Baskerville", "Archivo Narrow", "Alegreya Sans", "Ubuntu", "Crimson Text", "Heebo", "Cabin", "Lobster", "Pacifico", "Abril Fatface", "Barlow", "Bree Serif", "Bonbon", "Ropa Sans", "Amiri", "Orbitron", "Zilla Slab", "Great Vibes", "Playfair Display", "Cantata One", "Roboto Slab", "Cardo", "Montserrat", "Poppins", "Merriweather", "Lora", "Domine", "Karla", "Roboto Slab", "Crimson Text", "Slabo 27px", "EB Garamond", "Amiri", "Neuton", "Zilla Slab", "Josefin Slab", "Unna", "Abhaya Libre"];
	
	liveRefresh()
	
}
function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	
	if(imfoo == "home")
	{
		imported.src = 'app/js/live.js';
	}
	else
	{
		imported.src = '../app/js/live.js';
	}
	
	
	
	
	if(loc.includes("localhost"))
	{
		console.log("added")
		document.head.appendChild(imported);
	}
}
function langPickIni()
{
	
	if (!localStorage.getItem("language")) 
	{
		lang = "es_co"; 
		actualLang = lang;
		langGetIni(lang);
		localStorage.setItem("language", lang);
	}
	else
	{
		lang = localStorage.getItem("language");
		actualLang = lang;
		langGetIni(lang);
	}
	
	
}
// STARTER
function langGetIni(l) 
{
	var info ={};
	info.lang = l;
	if(localStorage.getItem("mainLocation"))
	{mainLocation = localStorage.getItem("mainLocation");}
	else
	{mainLocation = "Seatle";}
	info.mainLocation = mainLocation;
	
	sendAjax("users","langGet",info,function(response)
	{
		language = response.message.lang;
		setLang();
		zoneclients = response.message.clients;
		actualCats = response.message.cats;
		
		// SET WS BUTTON
		var wscontact = "https://api.whatsapp.com/send?phone=12069459753&text=Quiero%20m%C3%A1s%20informaci%C3%B3n%20en%20Ads%20Latino&source=&data=&app_absent=";
		document.getElementById("wsboton").onclick = function (){window.open(wscontact, "-blank");}
		
		if(typeof imfoo !== 'undefined') 
		{
			if(imfoo == "Seattle")
			{
				console.log("homeCity");
				// SET SUSCRIBE FORM
				setSuscribeForm();
				
				// SET CATS LISTS
				if(document.getElementById("dBox"))
				{setCatList(document.getElementById("dBox"));}
				if(document.getElementById("mdBox"))
				{setCatList(document.getElementById("mdBox"));}
			}
			else if(imfoo == "catDisplay")
			{
				console.log("catDisplay");
				var catPicker = document.getElementById("catPicker");
				catPicker.onchange=function (){refreshCats();}
				setCatListCats();
				actualCat = localStorage.getItem("fCat");
				catPicker.value = actualCat;
				refreshCats();
			}
			else if(imfoo == "manage")
			{

				// PUM.open(265);
				lm();
				
				setTimeout(function()
				{ 
					var loginB = document.getElementById("loginButton");
					loginB.onclick = function ()
					{
						console.log("login");
						
						var info = {};
						info.pass = document.getElementById("loginManagerField").value;
						
						sendAjax("users","login",info,function(response)
						{
							var ans = response.message;
							console.log(ans);
							if(ans == "1"){lm(); PUM.close(265);}
						});
					}
				
				}, 1000);
			}
			else if(imfoo == "clientdetail")
			{
				document.getElementsByClassName("wsbox")[0].style.display = "none";
				
				var urlParams = new URLSearchParams(window.location.search);
				var clientName = urlParams.get('client');
				
				startClient(clientName);
			}
			
		}
		else
		{
			console.log("article");
			// SET CATS LISTS
			if(document.getElementById("dBox"))
			{setCatList(document.getElementById("dBox"));}
			if(document.getElementById("mdBox"))
			{setCatList(document.getElementById("mdBox"));}
		}

		
		// SOCIAL ARTICLE SHARE OPTIONAL ---------------

		return
		

	});
}
function startClient(code)
{
	code = code.replaceAll("_"," ");
	code = code.replaceAll("%27","'");

	var info = {};
	info.code = code;
	
	console.log(info)

	sendAjax("users","getClient",info,function(response)
	{
		var ans = response.message;
		console.log(response);
		actualCmail = ans.EMAIL;

		
		var url = 'https://fonts.googleapis.com/css?family=' + ans.TITFONT.replace(/ /g,'+') + '&display=swap';
		jQuery('head').append(jQuery('<link>', {href:url, rel:'stylesheet', type:'text/css'}));
		
		var url = 'https://fonts.googleapis.com/css?family=' + ans.DESCFONT.replace(/ /g,'+') + '&display=swap';
		jQuery('head').append(jQuery('<link>', {href:url, rel:'stylesheet', type:'text/css'}));
		
		var banner = document.getElementById("clientBanner")
		
		var getBack = document.createElement("span");
		getBack.innerHTML = "Volver al directorio";
		getBack.className = "getBack";
		getBack.onclick = function (){window.location = "https://www.adslatinoweb.com/catdisplay/";}
		// getBack.onclick = function (){window.location = "http://localhost/www/adslatino/catdisplay/";}
		banner.appendChild(getBack);
		
		// SET BANNER BG PIC
		if(ans.TITBGPIC != "")
		{
			jQuery('#clientBanner').css('background-image', 'url(' + ans.TITBGPIC + ')');
		}
		
		// SET BANNER BG COLOR
		if(ans.TITBGCOLOR != "")
		{
			jQuery('#clientBanner').css('background-color', ans.TITBGCOLOR);
		}
		
		// SET TITLE VISIBLE AND ATTRIBS
		if(ans.TITSHOWNAME == "1")
		{
			
			var clientTitle = document.getElementById("clientTitle");
			clientTitle.innerHTML = ans.NAME;
			
			var titSize = ans.TITSIZE;
			
			if(jQuery(window).width() < 800)
			{
				var size = parseFloat(titSize.split("px")[0]);
				size = size - 10;
				console.log(size)
				titSize = size+"px";
			}
			
			jQuery('#clientTitle').css('color', ans.TITCOLOR);
			jQuery('#clientTitle').css('font-size', titSize);
			jQuery('#clientTitle').css('font-family', ans.TITFONT);
		}
		else
		{
			jQuery('#clientTitle').css('display', "none");
		}
		
		// HIDE DESC IF EMPTY
		if(ans.DETAIL != "")
		{
			jQuery('#clientDetails').css('display', "none");
		}

		// SET DESC FONT, SIZE, COLOR, ALIGN, BG COLOR
		jQuery('#clientDetails').css('background-color', ans.DESCBGCOLOR);
		jQuery('#clientDetails').css('font-family', ans.DESCFONT);
		jQuery('#clientDetails').css('font-size', ans.DESCSIZE);
		jQuery('#clientDetails').css('color', ans.DESCCOLOR);
		jQuery('#clientDetails').css('text-align', ans.DESCALIGN);
		
		
		jQuery('#picsPanel').css('background-color', ans.GALLERYBGCOLOR);

		var clientDetail = document.getElementById("clientDetails");
		clientDetail.innerHTML = ans.DETAIL;
		
		var videoBlock = document.getElementById("videoBlock");
		var gMapBlockD = document.getElementById("gMapBlockD");
		var gMapBlockM = document.getElementById("gMapBlockM");
		
		var cAddress = document.getElementById("cAddress");
		cAddress.innerHTML = "<i class='fas fa-map-marker-alt'></i> "+ ans.ADDRESS;
		
		var cPhone = document.getElementById("cPhone");
		var phone = ans.PHONE
		cPhone.href = "Tel:"+phone;
		cPhone.innerHTML = "<i class='fas fa-phone'></i> "+phone;
		
		var cEmail = document.getElementById("cEmail");
		cEmail.innerHTML = "<i class='fas fa-envelope'></i> "+ans.EMAIL;
		
		var webLink = document.getElementById("webLink");
		var fbLink = document.getElementById("fbLink");
		var igLink = document.getElementById("igLink");
		
		if(ans.WEB != "")
		{
			webLink.style.display = "initial";
			webLink.onclick = function ()
			{window.open(ans.WEB, "_blank");}
			
		}
		else{webLink.style.display = "none";}
		
		if(ans.FBLINK != "")
		{
			fbLink.style.display = "initial";
			fbLink.onclick = function ()
			{window.open(ans.FBLINK, "_blank");}
		}
		else{fbLink.style.display = "none";}
		
		if(ans.IGLINK != "")
		{
			igLink.style.display = "initial";
			igLink.onclick = function ()
			{window.open(ans.IGLINK, "_blank");}
		}
		else{igLink.style.display = "none";}
		
		var picsBox = document.getElementById("picsPanel");
		picsBox.innerHTML = "";
		
		
		var imgs = response.imgs;
		
		if(imgs.length == 0)
		{
			jQuery('#picsPanel').css('display', "none");
		}
		
		// BUILD GALLERY
		for(var i=0; i<imgs.length; i++)
		{
			var pic = document.createElement("img");
			pic.src = imgs[i].IMGSTRING;
			pic.id = "galImage"+i;
			pic.className = "galPic";
			pic.onclick = function ()
			{
				jQuery("#"+this.id).zoomify(
				{
				  duration: 200,
				  easing:   'linear',
				  scale:    0.8
				});
			}
			
			picsBox.appendChild(pic);
			jQuery("#"+"galImage"+i).zoomify({});
		}
		
		if(ans.GMAP != "")
		{
			var mapDesk = document.getElementById("gmap_canvas1");
			var mapMobile = document.getElementById("gmap_canvas2");
			mapDesk.src = ans.GMAP;
			mapMobile.src = ans.GMAP;
		}
		else
		{
			gMapBlockD.style.display = "none";
			gMapBlockM.style.display = "none";
			
		}
		
		if(ans.VIDEO != "")
		{
			var videoBox = document.getElementById("videoBox");
			videoBox.src = ans.VIDEO;
		}
		else
		{
			videoBlock.style.display = "none";
		}
		
		jQuery('html, body').animate( {scrollTop : 0}, 300 );
		
	});
	
}
function lm()
{
	// BUILD CLIENT ADMIN PANEL -------------
	var clientPanelBox = document.getElementById("clientPanelBox");
	clientPanelBox.innerHTML = "";
	
	// var clientListPanel = document.getElementById("clientListPanel");
	
	var city = fieldCreator([12,4,4,1], "Ciudad", "select", "text", "LOCATION");
	var cat = fieldCreator([12,4,4,1], "Categoría", "select", "text", "CAT");
	var clientName = fieldCreator([12,4,4,2], "Nombre", "input", "text", "NAME");
	var clientAddress = fieldCreator([12,4,4,2], "Dirección", "input", "text", "ADDRESS");
	var clientPhone = fieldCreator([12,4,4,2], "Teléfono", "input", "text", "PHONE");
	var clientEmail = fieldCreator([12,4,4,2], "Email", "input", "text", "EMAIL");
	var clientGmap = fieldCreator([12,4,4,2], "Gmap", "input", "text", "GMAP");
	var clientVideo = fieldCreator([12,4,4,2], "Video", "input", "text", "VIDEO");
	var clientWeb = fieldCreator([12,4,4,2], "Website", "input", "text", "WEB");
	var clientFb = fieldCreator([12,4,4,1], "Facebook", "input", "text", "FBLINK");
	var clientIg = fieldCreator([12,4,4,1], "Instagram", "input", "text", "IGLINK");
	
	var endDate = fieldCreator([12,4,4,2], "Vencimiento", "input", "text", "ENDATE");
	var clientPosition = fieldCreator([12,4,4,2], "Posición", "input", "text", "INDX");
	
	var saveButton = buttonCreator([12,4,4,1], "Crear", saveClient, "saveCbutton");
	var clearButton = buttonCreator([12,4,4,1], "Limpiar", clearForm);
	
	clientPanelBox.appendChild(city);
	clientPanelBox.appendChild(cat);
	clientPanelBox.appendChild(clientName);
	clientPanelBox.appendChild(clientAddress);
	clientPanelBox.appendChild(clientPhone);
	clientPanelBox.appendChild(clientEmail);
	clientPanelBox.appendChild(clientGmap);
	clientPanelBox.appendChild(clientVideo);
	clientPanelBox.appendChild(clientWeb);
	clientPanelBox.appendChild(clientPosition);
	clientPanelBox.appendChild(clientFb);
	clientPanelBox.appendChild(clientIg);
	
	clientPanelBox.appendChild(endDate);
	clientPanelBox.appendChild(saveButton);
	clientPanelBox.appendChild(clearButton);
	
	var option = document.createElement("option");
	option.value = "Seattle";
	option.innerHTML = "Seattle"; 
	
	var cityPicker = document.getElementById("LOCATION");
	cityPicker.appendChild(option);
	
	var catPicker = document.getElementById("CAT");
	
	for(var i=0; i<actualCats.length; i++)
	{
		var item = actualCats[i];
		
		var option = document.createElement("option");
		option.value = item.CATID;
		option.innerHTML = item.CATDESC;
		catPicker.appendChild(option);
	}
	
	setTimeout(function(){ document.getElementById("ENDATE").value = ""; }, 500);
	
	// BUILD CLIENT ADMIN PANEL -------------
	
	document.getElementsByClassName("wsbox")[0].style.display = "none";
	document.getElementById("popFormSaveButton").onclick = function (){saveDetails();}

	refreshClients();
	
	

	prepareImgCropper();
}
function loadForm(type)
{
	var formTitle = document.getElementById("popFormTitle");
	
	var popFormFieldBox = document.getElementById("popFormFieldBox");
	popFormFieldBox.innerHTML = "";
	
	var saveButton = document.getElementById("popFormSaveButton");
	
	var closeButton = document.getElementById("popFormExitButton");
	closeButton.onclick = function (){PUM.close(1557);}
	
	
	if(type == "styles")
	{
		formTitle.innerHTML = "Estilos de plantilla cliente > "+actualEditData.NAME;
		
		var titSampleSpan = document.createElement("span");
		titSampleSpan.className = "col-6 sampleTitSpan";
		titSampleSpan.innerHTML = "Muestra Titulo";
		titSampleSpan.id = "titSampleSpan"
		
		var descSampleSpan = document.createElement("span");
		descSampleSpan.className = "col-6 sampleTitSpan";
		descSampleSpan.innerHTML = "Muestra Descripción";
		descSampleSpan.id = "descSampleSpan"
		
		var titFont = fieldCreator([12,4,4,2], "Fuente título", "input", "text", "TITFONT");
		var titSize = fieldCreator([12,4,4,2], "Tamaño fuente título", "select", "text", "TITSIZE");
		var titColor = fieldCreator([12,4,4,2], "Color título", "input", "color", "TITCOLOR");
		var titShowName = fieldCreator([12,4,4,2], "Mostrar título", "select", "select", "TITSHOWNAME");
		var titBgColor = fieldCreator([12,4,4,2], "Color fondo portada", "input", "color", "TITBGCOLOR");
		var titBgPic = fieldCreator([12,4,4,2], "Imagen portada", "input", "text", "TITBGPIC");
		var descFont = fieldCreator([12,4,4,2], "Fuente descripcion", "input", "text", "DESCFONT");
		var descSize = fieldCreator([12,4,4,2], "Tamaño fuente descripcion", "select", "text", "DESCSIZE");
		var descColor = fieldCreator([12,4,4,2], "Color descripcion", "input", "color", "DESCCOLOR");
		var descAlign = fieldCreator([12,4,4,2], "Alineación descripcion", "select", "select", "DESCALIGN");
		var descBgColor = fieldCreator([12,4,4,2], "Color fondo descripcion", "input", "color", "DESCBGCOLOR");
		var galeryBgColor = fieldCreator([12,4,4,2], "Color fondo Galería", "input", "color", "GALLERYBGCOLOR");
		
		// popFormFieldBox.appendChild(titSampleSpan);
		// popFormFieldBox.appendChild(descSampleSpan);
		popFormFieldBox.appendChild(titFont);
		popFormFieldBox.appendChild(titSize);
		popFormFieldBox.appendChild(titColor);
		popFormFieldBox.appendChild(titShowName);
		popFormFieldBox.appendChild(titBgColor);
		popFormFieldBox.appendChild(titBgPic);
		popFormFieldBox.appendChild(descFont);
		popFormFieldBox.appendChild(descSize);
		popFormFieldBox.appendChild(descColor);
		popFormFieldBox.appendChild(descAlign);
		popFormFieldBox.appendChild(descBgColor);
		popFormFieldBox.appendChild(galeryBgColor);

		saveButton.onclick = function (){saveStyles();}
		
		
		
		jQuery('#TITFONT').fontpicker(
		{
		   variants: false,
		   nrRecents: 0,
		   showClear: true,
		   googleFonts: gfonts,
		   localFonts: false
		})
		.on('change', function() {
		   applyFont('#titSampleSpan', this.value, "Muestra titulo - ");
		   actualTitFont = this.value;
		});
		
		jQuery('#DESCFONT').fontpicker(
		{
		   variants: false,
		   nrRecents: 0,
		   showClear: true,
		   googleFonts: gfonts,
		   localFonts: false
		})
		.on('change', function() {
		   applyFont('#descSampleSpan', this.value, "Muestra descripción - ");
		   
		   actualDescFont = this.value;
		   
		});
		
		var titSizePicker = document.getElementById("TITSIZE");
		var descSizePicker = document.getElementById("DESCSIZE");
		
		var option = document.createElement("option");
		option.value = "12px";
		option.innerHTML = "12px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "16px";
		option.innerHTML = "16px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "20px";
		option.innerHTML = "20px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "24px";
		option.innerHTML = "24px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "26px";
		option.innerHTML = "26px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "30px";
		option.innerHTML = "30px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "35px";
		option.innerHTML = "35px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "40px";
		option.innerHTML = "40px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "45px";
		option.innerHTML = "45px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "50px";
		option.innerHTML = "50px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "55px";
		option.innerHTML = "55px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		var option = document.createElement("option");
		option.value = "60px";
		option.innerHTML = "60px";
		titSizePicker.appendChild(option);
		descSizePicker.appendChild(option.cloneNode(true));
		
		// ----------------------
		var showTitPicker = document.getElementById("TITSHOWNAME");
		
		var option = document.createElement("option");
		option.value = "1";
		option.innerHTML = "Si";
		showTitPicker.appendChild(option);
		
		var option = document.createElement("option");
		option.value = "0";
		option.innerHTML = "No";
		showTitPicker.appendChild(option);
		
		// ----------------------
		var alignPicker = document.getElementById("DESCALIGN");
		
		var option = document.createElement("option");
		option.value = "justify";
		option.innerHTML = "Justificar";
		alignPicker.appendChild(option);
		
		var option = document.createElement("option");
		option.value = "center";
		option.innerHTML = "Centrar";
		alignPicker.appendChild(option);
		
		var option = document.createElement("option");
		option.value = "left";
		option.innerHTML = "Izquierda";
		alignPicker.appendChild(option);
		
		var option = document.createElement("option");
		option.value = "right";
		option.innerHTML = "Derecha";
		alignPicker.appendChild(option);
		
		// -----------------------------------------
		
		var picPickerBanner = document.getElementById("TITBGPIC")
		picPickerBanner.onclick=function ()
		{
			actualPicType = "0";
			document.getElementById("fileSelector").click();
		}
		
		// -----------------------------------------
		
		formEditFiller("popFormFieldBox",actualEditData);

	}
	
	PUM.open(1557);
	
}
function applyFont(element, fontSpec, custom) {

  // Split font into family and weight/style
  var tmp = fontSpec.split(':'),
    family = tmp[0],
    variant = tmp[1] || '400',
    weight = parseInt(variant,10),
    italic = /i$/.test(variant);

  // Set selected font on paragraphs
  var css = {
    fontFamily: "'" + family + "'",
    fontWeight: weight,
    fontStyle: italic ? 'italic' : 'normal'
  };

  jQuery(element).css(css);
  jQuery(element).html(custom+family);
  
}

// SAVE STYLES
function saveStyles()
{
	
	var info = {};
	
	info.CODE = actualEditCode;
	info.TITFONT = document.getElementById("TITFONT").value;
	info.TITSIZE = document.getElementById("TITSIZE").value;
	info.TITCOLOR = document.getElementById("TITCOLOR").value;
	info.TITSHOWNAME = document.getElementById("TITSHOWNAME").value;
	info.TITBGCOLOR = document.getElementById("TITBGCOLOR").value;
	// CLEAR PIC IF EMPTY
	if(document.getElementById("TITBGPIC").value == ""){actualCroppedPic = "";}
	info.TITBGPIC = actualCroppedPic;
	info.DESCFONT = document.getElementById("DESCFONT").value;
	info.DESCSIZE = document.getElementById("DESCSIZE").value;
	info.DESCCOLOR = document.getElementById("DESCCOLOR").value;
	info.DESCALIGN = document.getElementById("DESCALIGN").value;
	info.DESCBGCOLOR = document.getElementById("DESCBGCOLOR").value;
	info.GALLERYBGCOLOR = document.getElementById("GALLERYBGCOLOR").value;

	console.log(info);
	// SEND COMM
	
	sendAjax("users","saveStyles",info,function(response)
	{
		var ans = response.message;
		refreshClients();
		fastPop("Guardado", 1000);
	});
	
}
function formEditFiller(containerId, data)
{
	console.log(data)
	
	var fieldsBox = document.querySelector("#"+containerId);
	
	var keys = Object.keys(data);
	for(var i=0; i<keys.length; i++)
	{
		var item = keys[i];
		if(fieldsBox.querySelector("#"+item) != null)
		{document.getElementById(item).value = data[item];}
	}
	
	// SPECIAL BEHAVIORS
	if(data.TITBGPIC)
	{
		if(data.TITBGPIC != "")
		{document.getElementById("TITBGPIC").value = "Imágen";}
		actualCroppedPic = data.TITBGPIC;
	}
}
// SAVE CLIENT
function saveClient()
{
	var saveB = document.getElementById("saveCbutton");
	var info = {};
	
	if(saveB.innerHTML == "Crear"){var mode = "c";}
	else{var mode = "e";info.ECODE = actualEditCode;}
	
	info.MODE = mode;
	info.LOCATION = document.getElementById("LOCATION").value;
	info.CAT = document.getElementById("CAT").value;
	info.NAME = document.getElementById("NAME").value;
	info.ADDRESS = document.getElementById("ADDRESS").value;
	info.PHONE = document.getElementById("PHONE").value;
	info.EMAIL = document.getElementById("EMAIL").value;
	info.GMAP = document.getElementById("GMAP").value;
	info.VIDEO = document.getElementById("VIDEO").value;
	info.WEB = document.getElementById("WEB").value;
	info.FBLINK = document.getElementById("FBLINK").value;
	info.IGLINK = document.getElementById("IGLINK").value;
	info.ENDATE = document.getElementById("ENDATE").value;
	info.INDX = document.getElementById("INDX").value;
	
	console.log(info);
	
	if(info.NAME == "" || info.ADDRESS == "" || info.PHONE == "" || info.EMAIL == "" || info.ENDATE == "")
	{
		fastPop("Los campos nombre, dirección, teléfono, email y vencimiento son obligatorios.", 4000);
		return;
	}
	
	sendAjax("users","saveClient",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		fastPop("Guardado exitoso", 4000);
		clearForm();
		refreshClients();
	});
	
}
function saveDetails()
{
	var info = {};
	info.code = actualEditCode;
	info.details = document.getElementById("clientDetails").value;
	
	sendAjax("users","saveDetails",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		fastPop("Detalles guardados",2000);
		PUM.close(309);
		refreshClients();
		
	});
	
}
function clearForm()
{
	
	var saveB = document.getElementById("saveCbutton");
	saveB.innerHTML = "Crear";
	document.getElementById("CAT").value = "1";
	document.getElementById("NAME").value = "";
	document.getElementById("ADDRESS").value = "";
	document.getElementById("PHONE").value = "";
	document.getElementById("EMAIL").value = "";
	document.getElementById("GMAP").value = "";
	document.getElementById("VIDEO").value = "";
	document.getElementById("WEB").value = "";
	document.getElementById("FBLINK").value = "";
	document.getElementById("IGLINK").value = "";
	document.getElementById("INDX").value = "";
	document.getElementById("ENDATE").value = "";
	setTimeout(function(){ document.getElementById("ENDATE").value = ""; }, 500);
	
}
function fieldCreator(sizes, title, object, type, id)
{
	  var label = document.createElement("span");
	  label.innerHTML = title;
	  label.className = "fieldLabel";
	  
	  var box = document.createElement("div");
	  var classname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
	  box.className = classname;
	  
	  var field = document.createElement(object);
	  field.id = id;
	  field.type = type;
	  field.className = "formField";
	  
	  box.appendChild(label);
	  box.appendChild(field);
	  
	  return box;
}
function buttonCreator(sizes, title, fun, id)
{
  var button = document.createElement("button");
  button.innerHTML = title;
  button.onclick = function(){fun()}
  button.className = "formButton";
  button.id = id;
  
  var box = document.createElement("div");
  var classname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
  box.className = classname;
  
  var br = document.createElement("br");
  br.className = "hidden-xs";
    
  box.appendChild(br);
  box.appendChild(button);
  
  return box;
}
function setSuscribeForm()
{
	document.getElementById("suscribeConfirmButton").onclick=function ()
	{
		var name = document.getElementById("subscribeName").value;
		var email = document.getElementById("subscribeMail").value;
		var phone = document.getElementById("subscribePhone").value;
		
		if(name == ""){fastPop("Debes escribir tu nombre",2000);return;}
		if(email == ""){fastPop("Debes escribir tu email",2000);return;}
		if(phone == ""){fastPop("Debes escribir un teléfono",2000);return;}
		
		
		var info = {};
		info.name = name;
		info.email = email;
		info.phone = phone;
		
		sendAjax("users","suscribe",info,function(response)
		{
			var ans = response.message;
			console.log(ans);
			PUM.close(167);
			
			fastPop("Gracias por unirte a nuestra comunidad latina!",2000);
			localStorage.setItem("suscribed","1");
		});
	}
	suscribeCancelButton.onclick=function (){PUM.close(167);}
	if(typeof imfoo !== 'undefined')
	{
		if(!localStorage.getItem("suscribed")){PUM.open(167);}
	}
		
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
function setCatList(box)
{
	box.innerHTML = "";
	var catList = [];
	for(var i=0; i<actualCats.length; i++)
	{
		var item = actualCats[i];
		var subs = [];
		for(var j=0; j<zoneclients.length; j++)
		{
			var subitem = zoneclients[j];
			if(subitem.CAT == item.CATID){subs.push(subitem);}
		}
		if(subs.length > 0){catList.push(item);}
	}
	
	for(var i=0; i<catList.length; i++)
	{
		var item = catList[i];
		
		var dButton = document.createElement("button");
		dButton.className = "dButton";
		dButton.cat = item.CATID;
		dButton.innerHTML = item.CATDESC;
		dButton.loc = mainLocation;
		dButton.onclick = function ()
		{
			console.log("load cat "+this.cat+" Location "+this.loc);
			
			localStorage.setItem("fCat", this.cat);
			var url = "https://www.adslatinoweb.com/catdisplay/";
			// var url = "http://localhost/www/adslatino/catdisplay/";
			window.open(url, "-blank");
			
		}
		
		box.appendChild(dButton);
	}
}
function setCatListCats()
{
	var box = document.getElementById("catPicker");
	box.innerHTML = "";
	
	var catList = [];
	for(var i=0; i<actualCats.length; i++)
	{
		var item = actualCats[i];
		var subs = [];
		for(var j=0; j<zoneclients.length; j++)
		{
			var subitem = zoneclients[j];
			if(subitem.CAT == item.CATID){subs.push(subitem);}
		}
		if(subs.length > 0){catList.push(item);}
	}
	
	for(var i=0; i<catList.length; i++)
	{
		var item = catList[i];
		var cat = document.createElement("option");
		cat.value = item.CATID;
		// cat.innerHTML = item.CATDESC+" en "+mainLocation;
		cat.innerHTML = item.CATDESC;
		box.appendChild(cat);
	}
}
function refreshCats()
{
	var info = {};
	info.cat = document.getElementById("catPicker").value;
	info.loc = mainLocation;
	
	sendAjax("users","getClients",info,function(response)
	{
		var list = response.message;
		console.log(list);
		catBuilder(list);
	});
	localStorage.setItem("fCat",info.cat);
}
function catBuilder(list)
{
	
	var cBox = document.getElementById("catContent");
	cBox.innerHTML = "";
	
	var caja = document.createElement("div");
	caja.className = "row";
	
	cBox.appendChild(caja);
	
	
	for(var i=0; i<list.length; i++)
	{
		var item = list[i];
		
		var clientBox = document.createElement("div");
		clientBox.className  = "col-lg-4 col-md-6 col-sm-12 row nmsides pdsides5 clientDiv";
		clientBox.data = item;
		
		var pic = document.createElement("img");
		pic.className = "resultsPic";
		
		
		pic.src = "../app/files/"+item.CODE+"/1.jpg?"+fileTail;
		
		var title = document.createElement("span");
		title.className = "resTit";
		title.innerHTML = item.NAME;
		
		var resSubTitle = document.createElement("span");
		resSubTitle.className = "resSubTitle";
		resSubTitle.innerHTML = "Ver información";
		
		
		clientBox.appendChild(title);
		clientBox.appendChild(pic);
		clientBox.appendChild(resSubTitle);
		clientBox.onclick = function ()
		{
			console.log(this.data);
			
			var cname = this.data.NAME.replaceAll(" ","_");
			var cname = cname.replaceAll("'","%27");
			
			location = "https://www.adslatinoweb.com/clientdetail/?client="+cname;
			// location = "http://localhost/www/adslatino/clientdetail/?client="+cname;
		}
		
		caja.appendChild(clientBox);
	}
}
function refreshClients()
{
	var info = {};
	info.cat = "";
	info.loc = mainLocation;
	
	sendAjax("users","getClients",info,function(response)
	{
		var list = response.message;
		console.log(list);
		tableCreator("clientsList", list);		
	});
}

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
		nInYet.innerHTML = "Sin resultados";
		nInYet.className = "blankProducts";
		table.appendChild(nInYet);
		return;
	}

	// USERS TABLE
	if(tableId == "clientsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator('Ciudad', list[i].LOCATION);
			
			var cat = getCatFromCode(list[i].CAT);
			
			var b = cellCreator('Categoría', cat);
			var c = cellCreator('Nombre', list[i].NAME);
			var d = cellCreator('Dirección', list[i].ADDRESS);
			var e = cellCreator('Teléfono', list[i].PHONE);
			var f = cellCreator('Email', list[i].EMAIL);
			var f2 = cellCreator('Email', list[i].INDX);
			
			var g = cellCreator('Imágenes', list[i].PIC1);
						
			var yesPic = "#61c4ea";
			var yesPic2 = "#70ea61";
			var noPic = "#ced4d6";
			
			if(list[i].PIC1 == "0"){var piColor1 = noPic;}
			else{var piColor1 = yesPic;}

			var pic1 = faIcon(list[i],"camera","Imágenes",piColor1);
			pic1.onclick = function()
			{
				var data = this.reg;
				actualPicCode = data.CODE;
				actualPicType = "1";
				
				document.getElementById("picListTitle").innerHTML = "Imagenes de: "+data.NAME;
				
				getClientImages(data.CODE);
				
				// document.getElementById("fileSelector").click();
				PUM.open(1576);
			}

			var pics = [pic1];
			var g = cellOptionsCreator('', pics);
			
			var h = cellCreator('Vence', list[i].ENDATE);
			var j = cellCreator('Estado', list[i].STATE);
			
			var edit = faIcon(list[i],"edit","Editar","#007bff");
			edit.onclick = function()
			{
				console.log(this.reg);
				var data = this.reg;
				
				actualEditCode = data.CODE;
				
				document.getElementById("LOCATION").value = data.LOCATION;
				document.getElementById("CAT").value = data.CAT;
				document.getElementById("NAME").value = data.NAME;
				document.getElementById("ADDRESS").value = data.ADDRESS;
				document.getElementById("PHONE").value = data.PHONE;
				document.getElementById("EMAIL").value = data.EMAIL;
				document.getElementById("GMAP").value = data.GMAP;
				document.getElementById("VIDEO").value = data.VIDEO;
				document.getElementById("WEB").value = data.WEB;
				document.getElementById("FBLINK").value = data.FBLINK;
				document.getElementById("IGLINK").value = data.IGLINK;
				document.getElementById("INDX").value = data.INDX;
				document.getElementById("ENDATE").value = data.ENDATE;
				
				var saveB = document.getElementById("saveCbutton");
				saveB.innerHTML = "Guardar";
				
			}
			
			var styles = faIcon(list[i],"info-circle","Detalles","#fb8a48");
			styles.onclick = function()
			{
				actualEditData = this.reg;
				actualEditCode = actualEditData.CODE;
				
				PUM.open(1557);
				
				loadForm("styles");
				
			}
			
			var details = faIcon(list[i],"info-circle","Detalles","#c7a9c1");
			details.onclick = function()
			{
				var data = this.reg;
				actualEditCode = data.CODE;
				PUM.open(309);
				document.getElementById("clientDetails").value = data.DETAIL;
			}
			
			var del = faIcon(list[i],"trash-alt","Eliminar","#e83e8c");
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["client",data];
				confirmBox(language["confirm"], language["confirmDelClient"]+"<b>"+data.NAME+"</b>?",deleteItem, params);
			}
			
			var icons = [edit,details,styles,del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,f,f2,h,j,g,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}
	}
	
	// PICS TABLE
	if(tableId == "clientPicsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var pic = document.createElement("img");
			pic.src = list[i].IMGSTRING;
			pic.className = "listPic";

			var pics = [pic];
			var a = cellOptionsCreator('', pics);
			var b = cellCreator('Posición', list[i].IMGPOS);

			var del = faIcon(list[i],"trash-alt","Eliminar","#e83e8c");
			del.onclick = function()
			{
				var data = this.reg;
				actualClientCode = data.CLIENTCODE;
				var params = ["image",data];
				confirmBox(language["confirm"], "Deseas eliminar esta imágen?",deleteItem, params);
			}
			
			var icons = [del];

			var x = cellOptionsCreator('', icons)
			var cells = [a,b,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);

		}
	}
}
function openPickPicker()
{
	document.getElementById("fileSelector").click();
}
function getClientImages(code)
{
	var info = {};
	info.code = code;
	sendAjax("users","getClientImages",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		tableCreator("clientPicsList", ans);		
		
	});
	
}
function deleteItem(params)
{
	var type = params[0];
	var data = params[1];
	
	console.log(params);
	
	var info = {};
	info.type = type;
	if(type == "client"){info.code = data.CODE;}
	if(type == "image"){info.code = data.IMGCODE;}
	
	console.log(info)
	
	sendAjax("users","deleteItem",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		if(type == "client")
		{
			fastPop(language["deleted"], 1000);
			refreshClients();
		}
		if(type == "image")
		{
			fastPop(language["deleted"], 1000);
			getClientImages(actualClientCode);
		}
		
	});
}
function getCatFromCode(code)
{
	for(var i=0; i<actualCats.length; i++)
	{
		var item = actualCats[i];
		if(item.CATID == code){var desc = item.CATDESC; return desc;}
	}
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
function cellCreator(name, content)
{
	var cell = document.createElement("div");
	cell.className = "column";
	cell.setAttribute('data-label',name);
	cell.innerHTML = decodeURIComponent(content);

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
// TABLES END -------------------------


// IMG ADMIN------------------
function prepareImgCropper()
{
	document.querySelector('#fileSelector').addEventListener('change', function()
	{
		var reader = new FileReader();
		reader.onload = function(e) 
		{
			var img = new Image;
			var fileSelector = document.getElementById('fileSelector');
			
			var spfname = fileSelector.value.split('.');
			var spfnameLen = spfname.length;
			var format = spfname[(spfnameLen-1)];

			if(format != "jpg" && format != "JPG" && format != "jpeg" && format != "JPEG")
			{
				actualCroppedPic = "";
				fastPop(language["wrongFormatJpgFile"], 3000);
				fileSelector.value = "";
				return;
			}
			
			var size = parseInt(e.loaded/1000);
			
			img.onload = function() 
			{
				var fileSelector = document.getElementById('fileSelector');
				var spfname = fileSelector.value.split('.');
				var spfnameLen = spfname.length;
				var format = spfname[(spfnameLen-1)];

				var w = img.width;
				var h = img.height;

				croppieQ = 0.7;
				console.log(size)
				
				if(size <= 499)
				{
					croppieQ = 0.7;
				}
				if(size <= 500 && size >= 999)
				{
					croppieQ = 0.5;
				}
				if(size >= 1000)
				{
					croppieQ = 0.4;
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
		PUM.close(254);
		document.getElementById("fileSelector").value = "";
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

	if(jQuery(window).width() < 800)
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
		if(actualPicType == "0")
		{
			var opts = 
			{
				viewport: { width: 1200, height: 640},
				boundary: { width: 1200, height: 640 },
				showZoomer: true,
				enableOrientation: true,
				mouseWheelZoom: 'ctrl',
			}
		}
		else
		{
			var opts = 
			{
				viewport: { width: 980, height: 550 },
				boundary: { width: 980, height: 550 },
				showZoomer: true,
				enableOrientation: true,
				mouseWheelZoom: 'ctrl',
			}
		}
		
	}
	
	theCroppie = new Croppie(document.getElementById('cpie'), opts);
	theCroppie.bind(args);
	
	PUM.open(254);
	
	var zoomBar = document.getElementsByClassName("cr-slider")[0];
	
	if(jQuery(window).width() < 800)
	{
		zoomBar.value = "0.3";
		
		var pic = document.getElementsByClassName("cr-image")[0];
		setTimeout(function()
		{
			console.log(pic);	pic.style.transform = "scale(0.3)";
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
		
		if(actualPicType == "0")
		{
			PUM.close(254);
			document.getElementById("TITBGPIC").value = "Imágen";
			
		}
		else
		{
			savepPic();
		}
	});

}
function savepPic()
{
	var info = {};
	info.pic = actualCroppedPic;
	info.picPos = document.getElementById("IMGPOS").value;
	info.code = actualPicCode;
	info.picType = actualPicType;
	
	tail = "?r="+Math.random();
	
	console.log(info);
	
	sendAjax("users","picsave",info,function(response)
	{
		var ans = response.message;
		actualCroppedPic = "";
		fastPop(language["picDone"], 2000);
		
		document.getElementById("IMGPOS").value = "";
		// refreshClients();
		getClientImages(info.code);
		
		document.getElementById("fileSelector").value = "";
		
		PUM.close(254);
		console.log(ans);
	});
}
// -----------CROPPIE--------------

function sendContact()
{
	var info = {};
	info.name = document.getElementById("contactNameField").value;
	info.email = document.getElementById("contactMailField").value.toLowerCase().replace(/\s+/g, '');
	info.message = document.getElementById("contactMslField").value;
	console.log(actualCmail)
	info.cmail = actualCmail;
	
	if(info.name == "" || info.email == "" || info.message == "")
	{
		fastPop(language["mustFieldsReg"], 2000);return;
	}
	if(!checkEmail(info.email)){fastPop(language["mustValidMailReg"], 2000);return;}
	
	console.log(info);
	
	// return;
	
	sendAjax("users","sendContact",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		fastPop(language["messageSent"], 6000);
		clearDataForm("3");
	});
	
}









// --------------------- GENERAL FUNCS --------------------
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
function condsBox()
{
	PUM.open(332);
	
	var content = document.getElementById("condsText");
	content.innerHTML = language["condsText"];
	
	var accept = document.getElementById("acceptButtonConds");
	accept.innerHTML = language["acceptButtonConds"];
}
function closeConds()
{
	PUM.close(332)
}
function fastPop(message, time)
{
	PUM.open(180);
	document.getElementById("fastPopText").innerHTML = message;
	setTimeout(function(){ PUM.close(180); }, time);
}
function alertBox(header, message)
{
	PUM.open(174);
	var tittle = document.getElementById("alertTitle");
	tittle.innerHTML = header;
	var content = document.getElementById("alertContent");
	content.innerHTML = message;
	var accept = document.getElementById("acceptButtonAlert");
	accept.innerHTML = language["acceptButtonAlert"];
}
function closeAlert()
{
	PUM.close(174)
}
function confirmBox(title, message, method, params)
{
	PUM.open(246);
	document.getElementById("confirmTitle").innerHTML = title;
	document.getElementById("confirmContent").innerHTML = message;
	var acceptB = document.getElementById("acceptConfirmButton");
	acceptB.method = method;
	acceptB.innerHTML = language["acceptButtonAlert"];
	acceptB.params = params;
	acceptB.onclick = function()
	{this.method(this.params);closeConfirm();}
	var cancelB = document.getElementById("cancelConfirmButton");
	cancelB.innerHTML = language["cancel"];
	cancelB.onclick = function(){closeConfirm()}
}
function closeConfirm()
{
	PUM.close(246);
}
function getNow()
{
	var currentdate = new Date(); 
	
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
function getdDiff(startDate, endDate) 
{
	var date1 = new Date(startDate);
	var date2 = new Date(endDate);
	var timeDiff = date2.getTime() - date1.getTime();
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
	return diffDays;
}
function toPhrase(string)
{
  return string.charAt(0).toUpperCase() + string.slice(1);
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
function isNumber(n) 
{
  return !isNaN(parseFloat(n)) && isFinite(n);
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

// COMMS
function sendAjax(obj, method, data, responseFunction)
{
	var info = {};
	info.class = obj;
	info.method = method;
	info.data = data;
	
	if(typeof imfoo !== 'undefined') 
	{
		if(imfoo == "Seattle"){localStorage.setItem("mainLocation", imfoo);var root = "";}
		if(imfoo == "catDisplay"){root ="../";}
		if(imfoo == "manage"){root ="../";}
		if(imfoo == "clientdetail"){root ="../";}
	}
	else
	{
		root ="../";
	}
	
	curl = root+'app/php/mentry.php';
	jQuery.ajax(
	{
			type: 'POST',
			url: curl,
			contentType: 'application/json',
			data: JSON.stringify(info),
			cache: false,
			async: true,
			success: function(data)
			{
				 try
				 {
					var tmpJson = jQuery.parseJSON(data);
					setTimeout(function(){ responseFunction(tmpJson.data); }, 300);
				 }
				 catch(e)
				 {
					 console.log(data);
				 }
			},
			error: function( jqXhr, textStatus, errorThrown )
			{ 
				console.log( errorThrown );
			}
		});
}



// --------------------------- ASD END ----------------------








function popLang()
{
	PUM.open(1210);
}
function pickLang(lang)
{
	if(actualLang != lang)
	{
		localStorage.setItem("language", lang);
		location = "https://likereal.org/about/";
	}
	else
	{
		PUM.close(1210);
	}
}
function checkLogin()
{
	if (window.localStorage.getItem("tmpkey")) 
	{
		var c = localStorage.getItem("tmpkey");
		var info = {};
		info.c = c;
		
		var method = "rlAud";
		
		sendAjax("users",method,info,function(response)
		{
			if(response.message == "ne")
			{
				userData = "";
				setLoged("0");
			}
			else
			{
				userData = response.message;
				setLoged("1");
			}
			setUnread(userData.unread);
			setUnfriend(userData.unfriend);
		});
	}
	else
	{
		userData = "";
		setLoged("0");
	}

}
function whatsLike()
{
	fastPop(language["whatsLike"], 6000);
}


// -------------SESSION---------------
function login()
{
	var email = document.getElementById("username").value.toLowerCase().replace(/\s+/g, '');
	var pssw = document.getElementById("password").value;
	var info = {};
	info.email = email;
	info.pssw = pssw;
	
	if(email == "")
	{
		fastPop(language["mustUser"], 2000);
		return;
	}
	
	if(!checkEmail(email))
	{
		fastPop(language["mustValidMailReg"], 2000);
		return;
	}
	
	if(pssw == "")
	{
		fastPop(language["mustPass"], 2000);
		return;
	}
	
	loadManager(1, "loginButton");
	
	sendAjax("users","login",info,function(response)
	{
		loadManager(0, "loginButton");
		var ans = response.message;
		
		if(ans == "Disabled")
		{
			fastPop(language["userDisabled"], 5000);
			return;
		}
		if(ans == "")
		{
			fastPop(language["wrongUser"], 2000);
		}
		else
		{
			userData = ans;
			setUnread(userData.unread);
			setUnfriend(userData.unfriend);
			localStorage.setItem("tmpkey", userData.CODE);
			setLoged("1");
		}
	});
}
function logout()
{
	userData = "";
	localStorage.removeItem("tmpkey");
	document.getElementById("coverloader").style.display = "block";
	location.reload(true);
}
function register(mode)
{
	var info = {};
	info.name = document.getElementById("usernameReg").value;
	info.email1 = document.getElementById("usermailReg").value.toLowerCase().replace(/\s+/g, '');
	info.email2 = document.getElementById("usermailReg2").value.toLowerCase().replace(/\s+/g, '');
	info.bday = document.getElementById("userbdayReg").value;
	info.phone = document.getElementById("userCelReg").value;
	info.gender = document.getElementById("userGenderReg").value;
	info.loc = document.getElementById("userLocationReg").value;
	info.pass1 = document.getElementById("userPass1Reg").value;
	info.pass2 = document.getElementById("userPass2Reg").value;
	info.mode = mode;
	
	if(info.name == "" || info.email1 == "" || info.bday == "" || info.phone == "" || info.gender == "" || info.loc == "" || info.pass1 == "" || info.pass2 == "")
	{
		fastPop(language["mustFieldsReg"], 2000);
		return;
	}
	
	if(!checkEmail(info.email1))
	{
		fastPop(language["mustValidMailReg"], 2000);
		return;
	}

	if(info.pass1 != info.pass2)
	{
		fastPop(language["passMatch"], 2000);
		return;
	}
	
	if(info.email1 != info.email2)
	{
		fastPop(language["emailMatch"], 2000);
		return;
	}
	
	if(mode == "0")
	{
		if(!document.getElementById("condsCheck").checked)
		{
			fastPop(language["mustCheck"], 2000);
			return;
		}
	}
	else
	{
		if(info.pass1 != "******")
		{info.changePass = "1";}
		else{info.changePass = "0";}
		info.code = userData.CODE;
		
	}
	
	info.avatar = actualAvatar;
	
	loadManager(1, "saveDataButton");
	
	sendAjax("users","register",info,function(response)
	{
		loadManager(0, "saveDataButton");
		var ans = response.message;
		
		if(ans == "exists")
		{
			fastPop(language["userExist"], 5000);
			return;
		}
		else if(ans == "updatednpc")
		{
			fastPop(language["userUpdated"], 2000);
			// SAME PASS
			userData.NAME = info.name;
			userData.BDAY = info.bday;
			userData.LOCATION = info.loc;
			userData.PHONE = info.phone;
			userData.GENDER = info.gender;
			userData.AVATAR = info.avatar;
			
			document.getElementById("profileIconMenu").src = "app/isrc/avatars/av"+userData.AVATAR+".png";
			document.getElementById("menuLabelProfile").innerHTML = userData.NAME.split(" ")[0];
			return;
		}
		else if(ans == "updatedpc")
		{
			fastPop(language["userUpdated"], 2000);
			document.getElementById("userPass1Reg").value = "******";
			document.getElementById("userPass2Reg").value = "******";
			// CHANGED PASS
			userData.NAME = info.name;
			userData.BDAY = info.bday;
			userData.LOCATION = info.loc;
			userData.PHONE = info.phone;
			userData.GENDER = info.gender;
			userData.AVATAR = info.avatar;
			document.getElementById("profileIconMenu").src = "app/isrc/avatars/av"+userData.AVATAR+".png";
			document.getElementById("menuLabelProfile").innerHTML = userData.NAME.split(" ")[0];
			return;
		}
		else
		{
			alertBox(language["alert"], language["regSuccess"]);
			document.getElementById("username").value = info.email1;
			document.getElementById("password").value = info.pass1;
			login();
			clearDataForm("1");
		}
	});
}
function showReg()
{
	sections = ["#regBox"];
	showManager(sections,"1");
}
function recPop()
{
	PUM.open(948);
	document.getElementById("passRecField").value = "";
	
	var acceptB = document.getElementById("recoverConfirmButton");
	acceptB.innerHTML = language["recoverConfirmButton"];
	acceptB.onclick = function()
	{
		var email = document.getElementById("passRecField").value.replace(/\s+/g, '');
		
		if(email == "")
		{
			fastPop(language["mustValidMailReg"], 2000);
			return;
		}
		if(!checkEmail(email))
		{
			fastPop(language["mustValidMailReg"], 2000);
			return;
		}
		
		var info = {};
		info.email = email;
		info.lang = actualLang;
		
		loadManager(1, "recoverConfirmButton");
		sendAjax("users","mailExist",info,function(response)
		{
			loadManager(0, "recoverConfirmButton");
			var ans = response.message;
			if(ans =="notSent")
			{
				fastPop(language["notSentRec"], 3000);
				return;
			}
			else
			{
				fastPop(language["yesSentRec"], 5000);
				closeRecover();
			}
			
		});
		
	}
	var cancelB = document.getElementById("recoverCancelButton");
	cancelB.innerHTML = language["cancel"];
	cancelB.onclick = function(){closeRecover()}
	
}
function closeRecover()
{
	PUM.close(948);
}
function recSetPop()
{
	document.getElementById("coverloader").style.display = "block";
	PUM.open(944);
	tmpkey = getUrlParameter("tmpkey");
	document.getElementById("passRecSetField1").value = "";
	document.getElementById("passRecSetField2").value = "";
	
	var acceptB = document.getElementById("recoverSetConfirmButton");
	acceptB.innerHTML = language["recoverSetConfirmButton"];
	acceptB.onclick = function()
	{
		var pass1 = document.getElementById("passRecSetField1").value.replace(/\s+/g, '');
		var pass2 = document.getElementById("passRecSetField2").value.replace(/\s+/g, '');
		
		if(pass1 == "")
		{
			fastPop(language["mustPass"], 2000);
			return;
		}
		if(pass1 != pass2)
		{
			fastPop(language["passMatch"], 2000);
			return;
		}
	
		var info = {};
		info.code = tmpkey;
		info.pass = pass1;
		loadManager(1, "recoverSetConfirmButton");
		sendAjax("users","setPass",info,function(response)
		{
			loadManager(0, "recoverSetConfirmButton");
			var ans = response.message;
			userData = "";
			localStorage.removeItem("tmpkey");
			window.location.href = "https://likereal.org";
			fastPop(language["passSetted"], 3000);
			
		});
		
	}

}
function getUrlParameter(sParam) 
{
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

// FAST LOADER/BUTTON LOCKER -> AVOID DOUBLE COMM SEND
function loadManager(state, trigger)
{
	if(state == 1){PUM.open(889);}
	else{PUM.close(889);}
	if(trigger != null)
	{
		var thisTrigger = document.getElementById(trigger);
		if(state == 1)
		{
			thisTrigger.oldFunction = thisTrigger.onclick;
			thisTrigger.onclick = function (){console.log("isLocked: "+this.id);return;}
		}
		else
		{
			thisTrigger.onclick = thisTrigger.oldFunction;
		}
	}
}
// ----------------------------------
function setUnread(unread)
{
	if(unread > 0)
	{
		document.getElementById("notiAlert").innerHTML = unread;
		document.getElementById("notiAlert").className = "notiAlertV";
	}
	else
	{
		document.getElementById("notiAlert").innerHTML = "";
		document.getElementById("notiAlert").className = "notiAlertH";
	}
}
function setUnfriend(unfriend)
{
	if(unfriend > 0)
	{
		document.getElementById("friendAlert").innerHTML = unfriend;
		document.getElementById("friendAlert").className = "notiAlertV";
	}
	else
	{
		document.getElementById("friendAlert").innerHTML = "";
		document.getElementById("friendAlert").className = "notiAlertH";
	}
}
function setRegForm(mode)
{
	if(mode == "1")
	{
		document.getElementById("udataTitle").innerHTML = language["regTitle1"];
		document.getElementById("saveDataButton").innerHTML = language["saveData1"];
		document.getElementById("usermailReg").disabled = true;
		document.getElementById("usermailReg2").disabled = true;
		document.getElementById("termsLine").style.display = "none";
		document.getElementById("saveDataButton").onclick = function ()
		{
			register("1");
		};
		
	}
	else
	{
		document.getElementById("udataTitle").innerHTML = language["regTitle0"];
		document.getElementById("saveDataButton").innerHTML = language["saveData0"];
		document.getElementById("saveDataButton").onclick = function ()
		{
			register("0");
		};
		document.getElementById("usermailReg").disabled = false;
		document.getElementById("usermailReg2").disabled = false;
	}
}
function randomHome()
{
	var slider = document.getElementById("homeslider2");
	var bgs = [1,2,3,4,5,6,7,8];
	var posbg = bgs[Math.floor(Math.random() * bgs.length)];
	slider.style.backgroundImage = "url('app/isrc/bgs/hbg"+posbg+".jpg')";
	
	var  phrs = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19];
	var posphrs = phrs[Math.floor(Math.random() * phrs.length)];
	document.getElementById("homePhrase").innerHTML = language["homephrase"+posphrs];
	document.getElementById("homeautor").innerHTML = language["homeautor"+posphrs];
}
function clearDataForm(target)
{
	if(target == "1")
	{
		document.getElementById("usernameReg").value ="";
		document.getElementById("usermailReg").value ="";
		document.getElementById("usermailReg2").value ="";
		document.getElementById("userbdayReg").value ="";
		document.getElementById("userCelReg").value ="";
		document.getElementById("userGenderReg").value ="";
		document.getElementById("userLocationReg").value ="";
		document.getElementById("userPass1Reg").value ="";
		document.getElementById("userPass2Reg").value ="";
		document.getElementById("condsCheck").checked = false;
	}
	if(target == "2")
	{
		document.getElementById("username").value ="";
		document.getElementById("password").value ="";
	}
	if(target == "3")
	{
		document.getElementById("contactNameField").value ="";
		document.getElementById("contactMailField").value ="";
		document.getElementById("contactMslField").value ="";
	}
}

// -------------MENU---------------
function gomenu(menu)
{
	jQuery('html, body').animate( {scrollTop : 0}, 300 );
	var innerSections = ["#homeBox","#regBox","#contactsBox","#likesBox", "#statsBox","#friendProfileBox"];
	showManager(innerSections,"0");
	
	showManager(["#"+menu],"1");
	var width = jQuery( window ).width();
	if(width < 768){document.getElementById(menu).style.marginTop = "80px";}
	else{document.getElementById(menu).style.marginTop = "70px";}

	if(menu == "homeBox")
	{
		randomHome();
		return;
	}
	if(menu == "likesBox")
	{
		actualLikes = [];
		blockSize = 50;
		iniLikeRange = 0;
		endLikeRange = iniLikeRange+blockSize;
		actualLikeFilter = "2";
		
		var filter1 = document.getElementById("likeFilter1");
		filter1.className = "likeFilter";
		filter1.innerHTML = language["likeFilter1"];
		filter1.onclick = function (){actualLikeFilter = "";getLikes("likeFilter1");}
		
		var filter2 = document.getElementById("likeFilter2");
		filter2.className = "likeFilter";
		filter2.innerHTML = language["likeFilter2"];
		filter2.onclick = function (){actualLikeFilter = "1";getLikes("likeFilter2");}
		
		var filter3 = document.getElementById("likeFilter3");
		filter3.className = "likeFilter";
		filter3.innerHTML = language["likeFilter3"];
		filter3.onclick = function (){actualLikeFilter = "2";getLikes("likeFilter3");}

		getLikes("menuLikesBox");
	}
	if(menu == "contactsBox")
	{
		document.getElementById("inviteMail").value = "";
		getFriends(userData.CODE, "0");
		return;
	}
	if(menu == "regBox")
	{
		document.getElementById("usernameReg").value = userData.NAME;
		document.getElementById("usermailReg").value = userData.EMAIL;
		document.getElementById("usermailReg2").value = userData.EMAIL;
		document.getElementById("userbdayReg").value = userData.BDAY;
		document.getElementById("userCelReg").value = userData.PHONE;
		document.getElementById("userGenderReg").value = userData.GENDER;
		document.getElementById("userLocationReg").value = userData.LOCATION;
		document.getElementById("userPass1Reg").value = "******";
		document.getElementById("userPass2Reg").value = "******";
		actualAvatar = userData.AVATAR;
		document.getElementById("profileIcon").src = "app/isrc/avatars/av"+actualAvatar+".png";
		
		return;
	}
	if(menu == "statsBox")
	{
		getStats();
	}

}
// -------------MENU---------------

// -------------FUNCTIONS---------------

// -------------FUNCTIONS---------------


// -------------EXCEL EXPORT---------------
function exportXLS(type, mode)
{
	
	console.log("lol")
	
	
	var info = {};
	info.type = "clist";
	info.ucode = "00";
	info.lang = "es_co";
	info.mode = "";

	sendAjax("users","exportXLS",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		// return;
		
		var url = "https://www.adslatinoweb.com/app/excel/"+encry(ans);
		// var url = "http://localhost/www/adslatino/app/excel/"+encry(ans);
		
		downloadReport(url);
	});
	
}
function downloadReport(url) 
{
	document.getElementById('downframe').setAttribute("href", url);
	document.getElementById('downframe').click();
};
function encry (str) 
{  
	return encodeURIComponent(str).replace(/[!'()*]/g, escape);  
}
// -------------EXCEL EXPORT---------------