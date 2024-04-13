// APP START START
$(document).ready( function()
{
	if(!localStorage.getItem("lup")){localStorage.setItem("lup", "v0.0");}
	loadCheck();
});


function loadCheck()
{
	
	tail = "?r="+Math.random();
	
	loginTo = "0";
	
	liveRefresh();

	infoIcon = "<img src='img/logo.png"+tail+"' class='infoIcon'/><br>";
	flag_ES = "<img src='img/es_es.png"+tail+"' class='tableFlag'/>";
	flag_EN = "<img src='img/en_us.png"+tail+"' class='tableFlag'/>";
	flag_PT = "<img src='img/pt_br.png"+tail+"' class='tableFlag'/>";
	
	actualCoursePic = "";
	actualCourseFileEs = "";
	actualCourseFileEn = "";
	actualCourseFilePt = "";
	actualFileName = "";
	actualPlainFile = "";
	actualCourseSlide = "";
	saveMode = "new";
	plansOrigin = "0";
	userPlansCode = "";
	myPass = "1";
	actualFormat = "";
	actualModule = "1";
	
	
	passBase = 60;
	
	usersLimit = 0;
	
	checkPassRecPop();
	
	backPopConfig();

	// ENTER LOGINFIELDS
	if(document.getElementById("InputUsername"))
	{
		document.getElementById("InputUsername").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){login();}});
	}
	if(document.getElementById("InputPassword"))
	{
		document.getElementById("InputPassword").addEventListener('keypress', function (e){var key = e.which || e.keyCode;if (key === 13){login();}});
	}
	
	$('#myModal').on('shown.bs.modal', function (){$('#myInput').trigger('focus')})
}

// ------------------------------STARTERS
// ------------------------------STARTERS
// ------------------------------STARTERS

function fix()
{
	
	var info = {};
	
	sendAjax("users","fixNames",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
	});
}


function liveRefresh()
{
	var loc = window.location.href;
	var imported = document.createElement('script');
	
	if(imfoo == "recover"){imported.src = 'js/live.js';}
	else{imported.src = 'js/live.js';}
	if(loc.includes("192")){document.head.appendChild(imported);}
	
	
	langPickIni();
}
function checkPassRecPop()
{
	var furl = window.location.href;
	if(furl.split("tmpkey=").length > 1)
	{
		ucode = furl.split("tmpkey=")[1];
		setTimeout(function(){showModal("pssSetModal");},500);
		return
	}
}
function langPickIni()
{
	
	if(imfoo == "courseCheck")
	{
		var url =  new URL(document.URL);
		console.log(url)
		lang = url.searchParams.get("lang");
		langGetIni(lang);
		localStorage.setItem("language", lang);
		return;
	}
	
	if(imfoo == "register")
	{
		
		if (!localStorage.getItem("language")){lang = "ES";}
		else{lang = localStorage.getItem("language");}
	
		langGetIni(lang);
		localStorage.setItem("language", lang);

		return;
	}
	
	
	if(imfoo == "contact")
	{
		console.log("contecto")
		
		
		return;
	}
	
	
	if (!localStorage.getItem("language")) 
	{
		lang = "ES"; 
		langGetIni(lang);
		localStorage.setItem("language", lang);
	}
	
	else
	{
		lang = localStorage.getItem("language");
		langGetIni(lang);
	}
}
function langGetIni(l) 
{
	var info ={};
	info.lang = l;
	
	sendAjax("users","langGet",info,function(response)
	{
		language = response.message.lang;
		// console.log(response);
		
		masterUsers = response.message.users;
		masterCourses = response.message.courses;
		masterBundles = response.message.bundles;
		masterCats = response.message.cats;
		
		// console.log(masterUsers)
		// console.log(masterCourses)
		console.log(masterBundles)
		
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
			if(element.type == "email" || element.type == "password"){element.placeholder = language[text];}
			if(element.type == "textarea" || element.type == "password"){element.innerHTML = "";element.placeholder = language[text];}
		}
	}
	
	
	
	
	checkLogin();
	
	var inputLang = lang.toLowerCase();
	jQuery.datetimepicker.setLocale(inputLang);
	
	
	
}
function setLangR()
{
	for (var text in language)
	{
		if(document.getElementById(text))
		{
			var element = document.getElementById(text);
			element.innerHTML = language[text];
			
	

			if(element.type == "text" || element.type == "password"){element.placeholder = language[text];}
			if(element.type == "email" || element.type == "password"){element.placeholder = language[text];}
			if(element.type == "textarea" || element.type == "password"){element.innerHTML = "";element.placeholder = language[text];}
		}
	}
	
	var inputLang = lang.toLowerCase();
	jQuery.datetimepicker.setLocale(inputLang);
	
}
function setLangGeneral(lang)
{
	localStorage.setItem("language", lang);
	location.reload();
}
function checkLogin()
{
	// CERTCHECK
	
	
	if(imfoo == "login")
	{
		console.log("lologin")
	}
	if(imfoo == "courseCheck")
	{
		
		var url =  new URL(document.URL);

		var checkUser = url.searchParams.get("user");
		var checkCourse = url.searchParams.get("course");
		var checkLang = url.searchParams.get("lang");

		document.body.classList.add('loginBgBody');
		
		var info = {};
		info.UCODE = checkUser;
		info.COURSE = checkCourse;
		info.LANG = checkLang;
		
		sendAjax("users","checkCert",info,function(response)
		{
			var ans = response.message;
			var user = response.user;
			var course = response.course;
			
			if(ans == "fakeCert")
			{
				document.getElementById("certCheckLine2").innerHTML = "<b>"+language["fakeCert"]+"</b>";
				document.getElementById("certCheckLine4").innerHTML = "<b>"+language["fakeCert"]+"</b>";
				document.getElementById("certCheckLine6").innerHTML = "<b>"+language["fakeCert"]+"</b>";
			}
			if(ans == "expired")
			{
				document.getElementById("certCheckLine2").innerHTML = "<b>"+language["expiredCertWarn"]+"</b>";
				document.getElementById("certCheckLine4").innerHTML = "<b>"+user+"</b>";
				document.getElementById("certCheckLine6").innerHTML = "<b>"+course+"</b>";
			}
			if(ans == "active")
			{
				document.getElementById("certCheckLine2").innerHTML = "<b>"+language["activeCertWarn"]+"</b>";
				document.getElementById("certCheckLine4").innerHTML = "<b>"+user+"</b>";
				document.getElementById("certCheckLine6").innerHTML = "<b>"+course+"</b>";
			}
			

			document.getElementById("coverLoad").style.display = "none";

		});
		
		return
	}
		
	if (window.localStorage.getItem("auc")) 
	{
		document.body.style.background = "#ffffff";
		
		var c = localStorage.getItem("auc");
		var info = {};
		info.c = c;
		info.type = "0";
		
		if(imfoo == "login")
		{
			// console.log("logueado pero carga loguin")
		}
		else
		{
			// console.log("logueado pero desde adentro")
		}
		
		var method = "rlAud";
		sendAjax("users",method,info,function(response)
		{
			var ans = response.message;
			uplans = response.uplans;
			console.log(uplans)
			
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
			
			userCourses = [];
	
			for(var i=0; i<uplans.length; i++)
			{
				var plan = uplans[i];
				var courses = JSON.parse(plan.COURSES)

				for(var p=0; p<courses.length; p++)
				{
					var code = courses[p];
					if(!userCourses.includes(code)){userCourses.push(code);}
				}
			}
			
			
			setMenuItems();
			checkPssChange();
			
			// CHECK FOR VENCIMIENTOS FOR ADMINS
			daemon();
			
		});
		
		
	}
	else
	{
		console.log("Logoff")
		document.body.classList.add('loginBgBody');
		userData = "";
		starter("0");
		
	}
}
function starter(mode)
{
	
	console.log(imfoo)
	
	if(document.getElementById("coverLoad"))
	{
		document.getElementById("coverLoad").style.display = "none";
	}
	if(mode != "0" && imfoo == "login")
	{
		window.location.replace( "index.html");
	}
	else
	{
		// window.location.replace( "login.html");
	}
	
}
function login()
{
	var email = document.getElementById("inputEmail").value;
	var type = document.getElementById("inputType").value;
	var pssw = document.getElementById("inputPassword").value;
		
	var info = {};
	info.user = email;
	info.pssw = pssw;
	info.type = type.split("-")[0];
	
		
	if(email == "")
	{
		alertBox(language["alert"], infoIcon+language["mustUser"]); return;
	}
	if(type == "")
	{
		alertBox(language["alert"], infoIcon+language["mustType"]); return;
	}
	if(pssw == "")
	{
		alertBox(language["alert"], infoIcon+language["mustPass"]); return;
	}
	
	if(loginTo == "1")
	{
		info.autor = email;
		info.pssw = pssw;
		info.type = type;
		info.date = getNow();
		info.optype = language["ltt4"];
		info.target = email;
	}

	
	console.log(info)
	
	sendAjax("users","login",info,function(response)
	{
		var ans = response.message;
		
		console.log(response)
		
		// return;
		
		if(loginTo == "0")
		{
			uplans = response.uplans;
			
			if(ans == "Disabled")
			{
				alertBox(language["alert"], infoIcon+language["disabledUser"]);
				return;
			}
			
			
			if(ans == "")
			{
				alertBox(language["alert"], infoIcon+language["wrongPass"]);
			}
			else
			{
				console.log("entra a idg")
				
				userData = ans;
				localStorage.setItem("auc", userData.CODE);
				window.location.replace( "index.html");
				
				// CHECK FOR VENCIMIENTOS FOR ADMINS
				daemon();
			}
		}
		if(loginTo == "1")
		{
			if(response.status)
			{
				
				console.log("entra a Operational Web Interface")
				
				// checkPssChange();
				
				
				localStorage.setItem("lastMail", info.user);
				
				aud = ans;
				console.log(aud)
				localStorage.setItem("aud",JSON.stringify(aud));
				actualUtype = aud.TYPE;
				localStorage.setItem("userLoged",actualUtype);
				
				window.location.replace("../app2/index.php");
				
				return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["wrongPass"]);
				return;
			}
			
		}
		
		
		
	});
}
function checkPssChange()
{
	console.log(userData);
	var type = userData.TYPE;
	var changePwd = userData.PCHANGED;
	

	
	
	if(userData.TYPE == "1" || userData.TYPE == "4")
	{
		if(changePwd == "0")
		{
			setMyPass();
			alertBox(language["alert"], language["mustChangePass"], 300);
		}
	}
	
	
}
function logout()
{
	userData = "";
	localStorage.removeItem("auc");
	window.location.replace( "login.html");
}
function setMenuItems()
{
	var menuBox = document.getElementById("menuBar");
	menuBox.innerHTML = "";
	
	document.getElementById("userName").innerHTML = userData.NAME;
	
	// GET USERTYPE
	// console.log(userData.TYPE)
	
	if(userData.TYPE == "0")
	{
		menuBox.appendChild(menuCreator("homeUsers", "users", language["homeUsers"]));
		menuBox.appendChild(menuCreator("homeCourses", "courses", language["homeCourses"]));
		menuBox.appendChild(menuCreator("homeCats", "cats", language["catsAdminTit"]));
		menuBox.appendChild(menuCreator("homeCourses_client", "courses_client", language["homeMyCourses"]));
		menuBox.appendChild(menuCreator("homeTests", "tests", language["homeTests"]));
		menuBox.appendChild(menuCreator("homeQuestions", "questions", language["homeQuestions"]));
		menuBox.appendChild(menuCreator("homePlans", "plans", language["homePlans"]));
		menuBox.appendChild(menuCreator("homeAnswers", "answers", language["answersAdminTit"]));
		
		
		
		// actualCourseCode = "SEG-003";
		// actualCourseName = "lalala";
		
		// ifLoad("courses")
		// ifLoad("content")
		// ifLoad("courses_client")
		ifLoad("users")
		// ifLoad("cats")
		// ifLoad("answers")
		// ifLoad("docs")
		// ifLoad("tests")
		// ifLoad("questions")
		// ifLoad("users")
		// ifLoad("plans")
		// ifLoad("coursepics");
		
		// loadForm("courses")
		// loadForm("slide")
		
		// buildTest();
		
		// createItem("plans")
		return;
	}
	if(userData.TYPE == "1")
	{
		if(uplans.length > 0){menuBox.appendChild(menuCreator("homeUsers", "users", language["homeUsers"]));}
		menuBox.appendChild(menuCreator("homeCourses_client", "courses_client", language["homeMyCourses"]));
		if(uplans.length > 0){menuBox.appendChild(menuCreator("homeBundles", "bundles", language["homeBundles"]));}
		menuBox.appendChild(menuCreator("homeAnswers", "answers", language["answersAdminTit"]));
		// ifLoad("bundles")
		ifLoad("users")
		return;
	}
	if(userData.TYPE == "2")
	{
		menuBox.appendChild(menuCreator("homeCourses_client", "courses_client", language["homeMyCourses"]));
		
		ifLoad("courses_client")
	
		return;
	}
	if(userData.TYPE == "3")
	{
		menuBox.appendChild(menuCreator("homeCourses_client", "courses_client", language["homeMyCourses"]));
		
		ifLoad("courses_client")
		return;
	}
	if(userData.TYPE == "4")
	{
		menuBox.appendChild(menuCreator("homeCourses_client", "courses_client", language["homeMyCourses"]));
		menuBox.appendChild(menuCreator("homeUsers", "users", language["homeUsers"]));
		menuBox.appendChild(menuCreator("homeAnswers", "answers", language["answersAdminTit"]));
		ifLoad("users")
		// ifLoad("courses_client")

		return;
	}

	
}
function menuCreator(id, iface, content)
{
	
	var item = document.createElement("a");
	item.href = "javascript:void(0)";
	item.innerHTML = content;
	item.iface = iface;
	item.className = "nav-link";
	item.id = id;
	
	item.onclick = function (){ifLoad(this.iface,this);}
	
	return item;
}
function sendContact()
{
	
	
	var info = {};
	info.name = document.getElementById("form_name").value;
	info.email = document.getElementById("form_email").value;
	info.phone = document.getElementById("form_phone").value;
	info.subject = document.getElementById("form_subject").value;
	info.message = document.getElementById("contact_message").value;
	
	console.log(info)
	
	// SEND VERIFICATIONS
	
	
	info.messageFull = "From: "+info.name+"<br>Email: "+info.email+"<br>Phone: "+info.phone+"<br>Subject: "+info.subject+"<br>Message: "+info.message;
	
	sendAjax("users","sendContact",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		alert("Message Sent, thank you")
		
		
		window.location.href = "https://idgwindtech.com/";
		
		
	});
	
	
}

function platPick(pick)
{
	
	var picker = document.getElementById("inputType");
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = language["utypeOptH"];
	picker.appendChild(option);

	
	if(pick == 0)
	{
		var options = [
			{"VAL":"0", "TXT": language["utypeOpt0H"]},
			{"VAL":"1", "TXT": language["utypeOpt1H"]},
			{"VAL":"1", "TXT": language["utypeOpt9H"]},
			{"VAL":"1", "TXT": language["utypeOpt1H"]},
			{"VAL":"2", "TXT": language["utypeOpt2H"]},
			{"VAL":"3", "TXT": language["utypeOpt3H"]}
			];
			
		loginTo = "0";
		
	}
	else
	{
		var options = [
			{"VAL":"A", "TXT": language["utypeOpt4H"]},
			{"VAL":"CO", "TXT": language["utypeOpt1H"]},
			{"VAL":"S", "TXT": language["utypeOpt2H"]},
			
			
			];
		loginTo = "1";
	
	}
	for(var i=0; i<options.length; i++)
	{
		var item = options[i];
		var option = document.createElement("option");
		option.value = item.VAL;
		option.innerHTML = item.TXT;
		picker.appendChild(option);
	}

}

// ------------------------------MAIN
// ------------------------------MAIN
// ------------------------------MAIN

function daemon()
{
	var info = {};
	
	if(userData.TYPE == "1"){info.COMPANY = userData.CODE;}
	else if(userData.TYPE == "4"){info.COMPANY = userData.COMPANY;}
	else if(userData.TYPE == "0"){info.COMPANY = userData.COMPANY;}
	else{return;}
	
	
	sendAjax("users","daemon",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
	});
}
function ifLoad(iface)
{
	actualIf = iface;
	
	
	if(iface == "home")
	{
		location.replace("index.html");
	}
	else
	{		

		document.getElementById("main-content").innerHTML = "";
		$("#main-content").load(iface+".html"+tail, function ()
		{
			actualIf = iface;
			
			if(iface == "courses")
			{
				setTimeout(function(){listGet('courses');},100);
			}
			if(iface == "tests")
			{
				setTimeout(function(){listGet('tests');},100);
			}
			if(iface == "questions")
			{
				setTimeout(function(){listGet('questions');},100);
			}
			if(iface == "courses_client")
			{
				setTimeout(function()
				{
					listGet('courses_client');
					
				},100);
			}
			if(iface == "content")
			{
				setTimeout(function()
				{
					
					document.getElementById("courseTit").innerHTML = actualCourseName;
					
					
					var info = {};
					info.LANG = lang;
					info.COURSE = actualCourseCode;
					info.UCODE = userData.CODE;
					
					// GET MODU FROM PICKER
					
					info.MODU = document.getElementById("moduPicker").value;
					
					// console.log(masterCourses)
					
					console.log(info)
					
					for(var i=0; i<masterCourses.length; i++)
					{
						var item = masterCourses[i];
						if(item.CODE == actualCourseCode){actualCourseData = item; break;}
					}
					
					document.getElementById("videoBox").style.display = "none";
	
					sendAjax("users","getSlides",info,function(response)
					{
						actualSlides = response.message;
						
						console.log(response)
						
						if(response.ctype == "I")
						{
							console.log("lol")
							
							
							var modPicker = document.getElementById("moduPicker");
							var sliderBoxBox = document.getElementById("sliderBoxBox");
							var videoBox = document.getElementById("videoBox");
							var ispringBox = document.getElementById("ispringBox");
							
							
							modPicker.style.display = "none";
							sliderBoxBox.style.display = "none";
							videoBox.style.display = "none";
														
							var code = actualCourseData["CODE"];
							var url = "courses/files/ispring/"+code+"/"+code+"_"+lang+"/index.html";
							console.log(url)
							
							ispringBox.innerHTML = "<iframe frameborder='0' scrolling='no' margin width='100%' height='100%' type='text/html' src='"+url+"'></iframe>";
										
							// box.style.display = "flex";
							
							console.log("lololol")
							
							
						}
						else
						{
							
							
							var ispringBox = document.getElementById("ispringBox");
							ispringBox.style.display = "none";
							
							var modQty = parseInt(response.modQty);
							var courseDetail = response.detail;
							var modSlides = {};
							
							var count = 0;
							var actualMod = "";
							
							for(var i=0; i<actualSlides.length; i++)
							{
								var sli = actualSlides[i]
								
								if(sli.MODU != actualMod)
								{
									
									count = 1;
									modSlides[sli.MODU] = count;
									actualMod = sli.MODU;
									
								}
								else
								{
									count++;
									modSlides[sli.MODU] = count;
								}
								
							}
							
							// console.log(modSlides)
							
							var moduPicker = document.getElementById("moduPicker")
							moduPicker.innerHTML = "";
							
							for(var i=0; i<modQty; i++)
							{
								var item = modQty[i];
								var mstate = courseDetail[i];
								if(mstate == 0){var stateDesc = language["pendModu"];}
								else{var stateDesc = language["passModu"];}
								
								
								var option = document.createElement("option");
								option.value = i+1;
								option.innerHTML = language["testPickerQmod"]+": "+(i+1)+" -> "+modSlides[i+1]+" "+language["slides"]+" "+stateDesc;
								moduPicker.appendChild(option);
								
							}
							
							
							
							
							var showSlides = [];
							var modu = document.getElementById("moduPicker").value;
							for(var i=0; i<actualSlides.length; i++)
							{
								var slide = actualSlides[i];
								if(slide.MODU == modu){showSlides.push(slide);}
							}
							
							var attachments = response.attached;

							if(attachments.length == 0)
							{
								document.getElementById("attachedTit").style.display = "none";
							}
							else
							{
								document.getElementById("attachedTit").style.display = "initial";
							}
							
							
							var slideBox = document.getElementById("sliderTrack");
							slideBox.innerHTML = "";
							
							var max = showSlides.length;
							
							for(var i=1; i<=max; i++)
							{
								var slide = document.createElement("div");
								slide.className = "slide";
								
								var img = "url('courses/files/"+actualCourseCode+"-"+i+"-"+info.LANG+" M "+modu+".jpg')";
								slide.style.backgroundImage  = img;
								slideBox.appendChild(slide)
							}
							
							var attBox = document.getElementById("attachementsBox");
							attBox.innerHTML = "";
							
							for(var i=0; i<attachments.length; i++)
							{
								var att = attachments[i];
								var line = document.createElement("span");
								line.className = "attachmentLine";
								line.innerHTML = att.NAME;
								line.reg = att;
								attBox.appendChild(line);
								
								line.onclick = function ()
								{
									var data = this.reg;
									console.log(data)
									if(data.TYPE == 0)
									{
										console.log("abrir link")
										
										var link = data.LINK;
										window.open(link, '_blank');
									}
									else
									{
										console.log("abrir archivo")
										
										var link = 'courses/files/ATT-'+data.COURSE+"-"+data.POS+"-"+data.LANG+'.'+data.EXT;
										console.log(link)
										window.open(link, '_blank');
									}
									
								}
								
								
							}
							

							setSlide();
							
							if(actualCourseData["VIDEO_"+lang] != "")
							{
								var vidButton = document.createElement("button");
								vidButton.className = "btn btn-primary filterButton1C";
								vidButton.innerHTML = "Video";
								vidButton.video = actualCourseData["VIDEO_"+lang];
								vidButton.onclick = function ()
								{
									
									
									if(this.innerHTML != language["slides"])
									{
										var box = document.getElementById("videoBox");
										var slideBox = document.getElementById("slideBox");
										
										var url = actualCourseData["VIDEO_"+lang];
										
										console.log(url)
										
										box.innerHTML = "<iframe frameborder='0' scrolling='no' margin width='100%' height='100%' type='text/html' src='"+url+"#embed?embedVideo=true'></iframe>";
										
										box.style.display = "flex";
										slideBox.style.display = "none";
										
										this.innerHTML = language["slides"];
									}
									else
									{
										ifLoad("content");
									}

								}

								document.getElementById("contentButtons").appendChild(vidButton);
								
							}

						}

					});

				},500);
			}
			if(iface == "users")
			{
				setTimeout(function()
				{
					
					if(uplans.length == 0){usersLimit = 0;}
					else{usersLimit = uplans[0].USERS;}
					listGet('users');
					
					if(userData.TYPE == "1" && uplans.length > 0)
					{
						
						var container = document.getElementById("plainBox");
						container.className = "plainBox";
						
						var templateLink = document.createElement("span");
						templateLink.className = "templateLink";
						templateLink.innerHTML = language["templateDownload"]
						templateLink.onclick = function ()
						{
							var url = "template_"+lang+".csv";
							console.log(url)
							window.open(url, '_blank');
						}
						
						container.appendChild(templateLink);
						
						var PLAIN = fieldCreator([12,12,12,6], language["usersPlain"], "file", "text", "PLAIN");
						container.appendChild(PLAIN);
						
						
						document.getElementById("PLAIN").classList.add("midFile");
						
						var saveButton = document.createElement("button");
						saveButton.className = "btn btn-primary filterButton1 sideButton";
						saveButton.innerHTML = language["savePlain"];
						saveButton.onclick = function ()
						{
							// console.log(actualFileName)
							// console.log(actualPlainFile)
							// console.log(usersLimit)
							// console.log(uplans)
							
							var info = {};
							info.CODE = userData.CODE;
							info.ULIMIT = uplans[0].USERS;
							info.FILE = actualPlainFile;
							info.LANG = lang;
							
							// console.log()
							
							if(info.FILE == "")
							{
								alertBox(language["alert"], infoIcon+language["noPlain"], 300);
								return;
							}
							
							
							sendAjax("users","savePlain",info,function(response)
							{
								var ans = response.message;
								console.log(ans)
								
								// return;
								
								if(ans == "qtyLimit")
								{
									alertBox(language["alert"], infoIcon+language["plainLimit"], 300);
									return;
								}
								if(ans.includes("exist"))
								{
									var mail = ans.split(" ")[1];
									alertBox(language["alert"], language["plainExist"]+" "+mail, 300);
									return;
								}
								
								
								listGet('users');
								
								
								
							});

						}
						container.appendChild(saveButton);
					}
					
				},100);
			}
			if(iface == "plans")
			{
				setTimeout(function()
				{
					
					if(plansOrigin == "1")
					{
						document.getElementById("plaNameFilter").value = userPlansCode;
						plansOrigin = "0";
						listGet('plans');
					}
					else
					{
						listGet('plans');
					}
					
				},500);
			}
			if(iface == "bundles")
			{
				setTimeout(function()
				{
					
					if(plansOrigin == "1")
					{
						document.getElementById("plaNameFilter").value = userPlansCode;
						plansOrigin = "0";
						listGet('bundles');
					}
					else
					{
						listGet('bundles');
					}
					
				},500);
			}
			if(iface == "coursepics")
			{
				console.log(actualCourseCode)
				setTimeout(function(){listGet('slides');},100);
			}
			if(iface == "docs")
			{
				console.log(actualCourseCode)
				setTimeout(function(){listGet('docs');},100);
			}
			if(iface == "answers")
			{
				setTimeout(function(){listGet('answers');},100);
				
				setDateField("STARTDATE");
				setDateField("ENDATE");
				
			}
			if(iface == "cats")
			{
				setTimeout(function(){listGet('cats');},100);
			}

			setLangR();

		});
		
		setTimeout(function()
		{
			
			if(iface == "users" && userData.TYPE == "1")
			{
				document.getElementById("usersAdminTit").innerHTML = language["usersAdminTit"]+"<b class='vuntil'>"+language["usersTop"]+usersLimit+")</b>";
			}
		
		},500);
		
		
	}
}
function reloadSB()
{
	var sliderBoxBox = document.getElementById("sliderBoxBox");
	document.getElementById("slideBox").remove();
	
	var slideBox = document.createElement("div");
	slideBox.className = "slider";
	slideBox.id = "slideBox";
	
	var sliderList = document.createElement("div");
	sliderList.className = "slider-list grab";
	
	var sliderTrack = document.createElement("div");
	sliderTrack.className = "slider-track";
	sliderTrack.id = "sliderTrack";
	sliderTrack.style = "transform: translate3d(0px, 0px, 0px); transition: transform 0.5s ease 0s;";
	
	
	sliderList.appendChild(sliderTrack);
	slideBox.appendChild(sliderList);
	
	var sliderArrows = document.createElement("div");
	sliderArrows.className = "slider-arrows";
	
	var prev = document.createElement("button");
	prev.className = "prev";
	prev.innerHTML = "&larr;";
	
	var next = document.createElement("button");
	next.className = "next";
	next.innerHTML = "&rarr;";
	
	sliderArrows.appendChild(prev);
	sliderArrows.appendChild(next);
	
	slideBox.appendChild(sliderArrows);
	sliderBoxBox.appendChild(slideBox);
	
}
function loadModule(pick)
{
	
	actualModule = pick;
	
	reloadSB();
	
	setTimeout(function()
	{
		
						
		var showSlides = [];
		var modu = document.getElementById("moduPicker").value;
		for(var i=0; i<actualSlides.length; i++)
		{
			var slide = actualSlides[i];
			if(slide.MODU == modu){showSlides.push(slide);}
		}
		console.log(showSlides);
		
		var slideBox = document.getElementById("sliderTrack");
		slideBox.innerHTML = "";
		
		var max = showSlides.length;
		console.log(max)
		
		for(var i=1; i<=max; i++)
		{
			var slide = document.createElement("div");
			slide.className = "slide";
			
			var img = "url('courses/files/"+actualCourseCode+"-"+i+"-"+lang+" M "+modu+".jpg')";
			slide.style.backgroundImage  = img;
			slideBox.appendChild(slide)
		}
		
		setSlide();

	
	},100);

	
	
}
function multiActionUser(value)
{
	var table = document.getElementById("usersList");
	var rows = table.children;
	pickedUsers = [];
	
	for(var i=1; i<rows.length; i++)
	{
		var row = rows[i];
		var check = row.children[0].children[0];
		if(check.checked)
		{
			var code = check.id.split("-")[1];
			pickedUsers.push(code);
		}
	}
	
	if(pickedUsers.length == 0)
	{
		alertBox(language["alert"], infoIcon+language["mustSelectUsers"], 300);
		document.getElementById("userMultiActions").value = "";
		return;
	}
	
	
	if(value == "1")
	{
		
		var info = {};
		if(userData.TYPE == "1"){info.COMPANY = userData.CODE;}
		if(userData.TYPE == "4"){info.COMPANY = userData.COMPANY;}
		if(userData.TYPE == "0")
		{
			alertBox(language["alert"], language["justForCompanyOrManager"], 300);
			document.getElementById("userMultiActions").value = "";
			return;
		}
		
		actualAllowUser = pickedUsers;
		
		sendAjax("users","getCoursesByCompany",info,function(response)
		{
			var ans = response.message;
			var actualUserCourses = ans[0].COURSES;
			
			var setterBox = document.getElementById("coursesSetBox");
			setterBox.innerHTML = "";
			
			document.getElementById("limitDaysSingle").value = 15;
			
			var COURSES = fieldCreator([12,4,3,12], language["plansForm_Courses"], "multiselect", "select", "COURSES");
						
			setterBox.appendChild(COURSES);
			document.getElementById("COURSES").classList.add("floatMultiSelect");
			
			var myCourses = [];
					
			for(var i=0; i<masterCourses.length; i++)
			{
				var masterCode = masterCourses[i].CODE;
				var cat = getCat(masterCourses[i].CAT)
				if(actualUserCourses.includes(masterCode))
				{
					masterCourses[i]["FULLDESC"] = cat+" - "+masterCourses[i]["CODE"]+" * "+masterCourses[i]["CNAME_"+lang];
					myCourses.push(masterCourses[i]);
				}
			}
			
			
			
			
			var clistP = [];
			multiSelectFillerDicF("COURSES", "CODE", "FULLDESC" ,myCourses,clistP,"1","0");
			showModal("coursesSetModal");
			document.getElementById("userMultiActions").value = "";
		});
	}
	if(value == "2")
	{
		console.log("bundle")
		
		var info = {};
		if(userData.TYPE == "1"){info.COMPANY = userData.CODE;}
		if(userData.TYPE == "4"){info.COMPANY = userData.COMPANY;}
		if(userData.TYPE == "0")
		{
			alertBox(language["alert"], language["justForCompanyOrManager"], 300);
			document.getElementById("userMultiActions").value = "";
			return;
		}

		actualBundleUser = pickedUsers;
		
		sendAjax("users","getBundlesByCompany",info,function(response)
		{
			var ans = response.message;
			console.log(ans)
			
			document.getElementById("limitDaysBundle").value = 15;
			
			var setterBox = document.getElementById("bundlesSetBox");
			setterBox.innerHTML = "";
			
			var COURSES_BUNDLE = fieldCreator([12,4,3,12], language["plansForm_Bundle"], "multiselect", "select", "COURSES_BUNDLE");
			setterBox.appendChild(COURSES_BUNDLE);
			document.getElementById("COURSES_BUNDLE").classList.add("floatMultiSelect");
			
			var bundles = [];
			var clistP = bundles;
			multiSelectFillerDicF("COURSES_BUNDLE", "CODE", "NAME",ans,clistP,"1","0");
			showModal("bundleSetModal");
		});
	}
	
}
// LIST GET
function listGet(type)
{
	var info = {};
	info.type = type;
	info.utype = userData.TYPE;
	info.ucode = userData.CODE;
	
	
	if(type == "courses"){info.filter = document.getElementById("courseNameFilter").value;}	
	if(type == "tests"){info.filter = document.getElementById("testNameFilter").value;}	
	if(type == "questions"){info.filter = document.getElementById("questionNameFilter").value;}	
	if(type == "testPicker"){info.filter = "";}	
	if(type == "testPickerQ"){info.filter = "";}	
	if(type == "courses_client"){info.filter = document.getElementById("courseNameFilter").value;}	
	if(type == "users")
	{
		info.filter = document.getElementById("userNameFilter").value;
		if(userData.TYPE == "4"){info.company = userData.COMPANY;}
		
		info.status = document.getElementById("userActiveFilter").value;
		
		
		
	}	
	if(type == "bundles")
	{
		info.filter = document.getElementById("bundleNameFilter").value;
		if(userData.TYPE == "4" ){info.COMPANY = userData.COMPANY;}
		else if(userData.TYPE == "2" ){info.COMPANY = userData.CODE;}
		else{info.COMPANY = userData.CODE;}
	}	
	if(type == "plans"){info.filter = document.getElementById("plaNameFilter").value;}	
	if(type == "slides"){info.filter = actualCourseCode;}	
	if(type == "docs")
	{
		info.filter = actualCourseCode;
		info.lang = lang;
	}
	
	if(type == "answers")
	{
		info.filter = document.getElementById("ansTrueFilter").value;
		info.STARTDATE = document.getElementById("STARTDATE").value;
		info.ENDATE = document.getElementById("ENDATE").value;
		info.USER = document.getElementById("ansUserFilter").value;
		if(userData.TYPE == "4")
		{
			info.COMPANY = userData.COMPANY;
		}
		else if(userData.TYPE == "1" )
		{
			info.COMPANY = userData.CODE;
		}
		else
		{
			info.COMPANY = "";
		}
		info.lang = lang;
	}	
	if(type == "cats")
	{
		info.filter = document.getElementById("catsNameFilter").value;;
		info.lang = lang;
	}
	
	console.log(info)
	
	sendAjax("users","listGet",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		
		if(info.type == "courses"){tableCreator("coursesList", ans);}
		if(info.type == "tests"){tableCreator("testsList", ans);}
		if(info.type == "testPicker")
		{
			selectFiller("testPicker", language["defaultTestPicker"], ans, "CODE", "TESTNAME");
			showModal("testSetModal");
			console.log(actualAssignedTest)
			if(actualAssignedTest != ""){document.getElementById("testPicker").value = actualAssignedTest;}
		}
		if(info.type == "testPickerQ")
		{
			selectFiller("testPickerQ", language["defaultTestPicker"], ans, "CODE", "TESTNAME");
			showModal("testSetModalQ");
			if(actualAssignedTest != "")
			{$("#testPickerQ option:contains("+actualAssignedTest+")").attr('selected', true);}
			if(actualAssignedMod != "")
			{document.getElementById("testPickerQmod").value = actualAssignedMod}
		}
		if(info.type == "questions"){tableCreator("questionsList", ans);}
		if(info.type == "courses_client")
		{
			myCoursesFiller(ans);
			
			if(userData.TYPE == "2")
			{
				var progress_allowed = response.progress_allowed;
				progress_pending = response.progress_pending;

				var allowQty = progress_allowed.length;
				var pendingQty = progress_pending.length;
				var doneQty = allowQty-pendingQty;
				
				console.log(allowQty)
				console.log(pendingQty)
				console.log(doneQty)
				
				var rate = parseInt(doneQty/allowQty*100);
				if(isNaN(rate)){rate = 0}
				
				console.log(rate)
				
				var done = rate+"%";
				
				document.getElementById("coursesClientAdminTit").innerHTML = language["coursesClientAdminTit"]+" "+language["userProgress1"]+done+language["userProgress2"];
				
			}
			
			
			
		}
		if(info.type == "users"){tableCreator("usersList", ans);}
		if(info.type == "plans"){tableCreator("plansList", ans);}
		if(info.type == "bundles"){tableCreator("bundlesList", ans);}
		if(info.type == "slides"){tableCreator("slidesList", ans);}
		if(info.type == "docs"){tableCreator("docsList", ans);}
		if(info.type == "answers"){tableCreator("answersList", ans);}
		if(info.type == "cats"){tableCreator("catsList", ans);}
		
		
	});
	
}
function showProgDet()
{
	console.log(progress_pending)
	
	// FRIENDLY CNAMES
	var courses = progress_pending;
	var cline = "";
	for(var n = 0; n<courses.length; n++)
	{
		var crs = courses[n];
		for(var m=0; m<masterCourses.length; m++)
		{
			var master = masterCourses[m];
			if(crs == master.CODE)
			{
				cline += "* "+master["CNAME_"+lang];
				if(n < courses.length-1){cline += "<br>"}
				break;
			}
		}
		
	}
	console.log(cline)
	
	alertBox(language["alert"], cline, 500);
	
	
}
function listExport(type)
{
	var info = {};
	info.type = type;
	info.utype = userData.TYPE;
	info.ucode = userData.CODE;
	info.lang = lang;
	info.completed = document.getElementById("userProgressFilter").value
	info.status = document.getElementById("userActiveFilter").value;
	
	if(info.status == "0"){alertBox(language["alert"], infoIcon+language["onlyForActive"], 300);return;}
	
	
	if(type == "users")
	{
		info.filter = document.getElementById("userNameFilter").value;
		if(userData.TYPE == "4"){info.company = userData.COMPANY;}
	}	
	
	
	sendAjax("users","listExport",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		if(info.type == "users")
		{
			tableCreator("usersList", ans);
			var url = "excel/"+response.file;
			downloadReport(decry(url));
		}
		if(info.type == "answers")
		{
			tableCreator("usersList", ans);
			var url = "excel/"+response.file;
			downloadReport(decry(url));
		}

	});
	
}
function downloadReport(url) 
{
	document.getElementById('downframe').setAttribute("href", url);
	document.getElementById('downframe').click();
};
function myCoursesFiller(list)
{
	
	var mainBox = document.getElementById("myCoursesBox");
	mainBox.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		// console.log(userCourses)
		var item = list[i];
		if(userCourses.includes(item.CODE))
		{item.OPEN = 1;}
		else{item.OPEN = 0;}
		
		
		// GET ENDATE
		for(var p=0; p<uplans.length; p++)
		{
			var plan = uplans[p];
			if(plan.COURSES.includes(item.CODE))
			{var validUntil = plan.ENDATE;}
			else{var validUntil = "";}
		}
		
		// console.log(validUntil)
		
		item.VUNTIL = validUntil;
		
		if(userData.TYPE == "0"){item.OPEN = 1;}
		
		var course_box = document.createElement("div");
		course_box.className = "col-xs-12 col-sm-4 col-md-3 col-lg-2 courseBox";
		
		var pic_box = document.createElement("div");
		pic_box.className = "col-12 pic_box";
		
		
		var pic = document.createElement("img");
		pic.className = "course_client_pic";
		pic.src = "courses/pics/"+item.CODE+".jpg";
		pic_box.appendChild(pic);
		
		
		var picOpen = document.createElement("img");
		picOpen.className = "openPic";
		picOpen.src = "img/open_"+lang+".png";
		
		course_box.data = item;
		// console.log(item)
		
		var title = document.createElement("span");
		title.className = "course_title";
		title.innerHTML = item["CNAME_"+lang];
		
		var desc = document.createElement("span");
		desc.className = "course_desc";
		desc.innerHTML = item["DESC_"+lang];
		
		
		var ccode = document.createElement("span");
		ccode.className = "course_code";
		ccode.innerHTML = language["ccode"]+item["CODE"];
		
		var price = document.createElement("span");
		price.className = "course_price";
		
		if(item.OPEN == 1)
		{
			pic_box.appendChild(picOpen);
			price.innerHTML = language["enterCourse"];
			course_box.onclick = function(){openCourse(this.data)}
		}
		else
		{
			
			if(userData.TYPE == "1" || userData.TYPE == "2"){continue;}
			
			price.innerHTML = "$"+item["COURSE_PRICE"]+" USD";
			course_box.onclick = function(){buyCourse(this.data)}
			course_box.appendChild(price);
		}
		
		course_box.appendChild(pic_box);
		course_box.appendChild(ccode);
		course_box.appendChild(title);
		course_box.appendChild(desc);
		
		// SHOW COURSES FILTER, ALLOWED AND BUNDLED ONLY
		if(userData.TYPE == "2" || userData.TYPE == "4")
		{
			var allowed = [];
			if(userData.ALLOWED != "" && userData.ALLOWED != null){allowed = JSON.parse(userData.ALLOWED);}
			var bundles = [];
			if(userData.BUNDLES != "" && userData.BUNDLES != null){bundles = JSON.parse(userData.BUNDLES);}
			var bundledCourses = getBundledCourses(bundles);
			allowed = [... new Set([...allowed, ...bundledCourses])]
			if(!allowed.includes(item.CODE)){continue;}
		}
				
		
		mainBox.appendChild(course_box);
	
	}
	
}
function getBundledCourses(bundles)
{
	var courses = [];
	for(var i=0; i<bundles.length; i++)
	{
		var bcode = bundles[i];
		for(var b=0; b<masterBundles.length; b++)
		{
			var mbcode = masterBundles[b].CODE;
			if(bcode == mbcode)
			{
				if(masterBundles[b].COURSES != "" && masterBundles[b].COURSES != null)
				{var bcourses =   JSON.parse(masterBundles[b].COURSES);}
				else{var bcourses = []}
				courses = [... new Set([...courses, ...bcourses])]
			}
		}
	}
	return courses;
}
function openCourse(data)
{
		
	if(data.OPEN == 1)
	{
		actualCourseCode = data.CODE;
		actualCourseName = data["CNAME_"+lang]+"<b class='vuntil'> ("+language["vuntil"]+data.VUNTIL+")<b>";
		
		
		ifLoad("content");
	}
	else
	{
		console.log("Comprar")
	}
}
function buyCourse(data)
{
	console.log(data)	
	
}
function setCourseTest()
{

	var pickedTest = document.getElementById("testPicker").value;
	
	var info = {};
	info.course = actualCourseCode;
	info.pickedTest = pickedTest;
	
	sendAjax("users","setCourseTest",info,function(response)
	{
		var ans = response.message;
		hideModal("testSetModal");
		listGet("courses");
	});

}
function setCourseTestQ()
{

	var pickedTest = $("#testPickerQ option:selected").text();
	var pickedMod = document.getElementById("testPickerQmod").value;
	
	var info = {};
	info.question = actualQuestionCode;
	info.pickedTest = pickedTest;
	info.pickedMod = pickedMod;
	
	console.log(info)
	
	sendAjax("users","setCourseTestQ",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		hideModal("testSetModalQ");
		listGet("questions");
	});

}
function createItem(type)
{
	if(type == "courses")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "tests")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "questions")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "users")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "users")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "plans")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "bundles")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "slide")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "docs")
	{
		saveMode = "new";
		loadForm(type);
	}
	if(type == "cats")
	{
		saveMode = "new";
		loadForm(type);
	}
}
function editItem(type)
{
	if(type == "courses")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "tests")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "questions")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "users")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "plans")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "bundles")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "slide")
	{
		saveMode = "edit";
		loadForm(type);
	}
	if(type == "cats")
	{
		saveMode = "edit";
		loadForm(type);
	}
}
function buildTest()
{
	
	// actualCourseCode = "SEG-003";
	
	var info = {};
	info.CODE = actualCourseCode;
	info.UCODE = userData.CODE;
	
	
	if(actualCourseData["TYPE"] == "I")
	{
		info.MODU = 1;
	}
	else
	{
		info.MODU = document.getElementById("moduPicker").value;
	}

	
	// CHECK TRIAL STORY
	console.log(userData.CODE)
	console.log(userCourses)
	
	// GET LAST USER TRIAL FOR THIS COURSE
	// GET LAST DONE
	console.log(info)
	
		
	sendAjax("users","getQuest",info,function(response)
	{
		actualQuestions = response.message;
		var trials = response.trials;
		
		console.log(trials)
		console.log(actualQuestions)
		
		if(trials.length == 0)
		{
			var lastTrial = "";
			var lastScore = "0";
		}
		else
		{
			var lastTrial = trials[0].PRESENTED;
			var lastScore = trials[0].SCORE;
		}
		
		if(lastTrial != "")
		{
			
			if(parseInt(lastScore) < passBase)
			{
				
				var datetime = getNow();
				var retry = 1;
				var lapse = getdDiffMin(lastTrial, datetime);
				console.log(lapse)
				if(lapse < 120){var retry = 1;}
				
				if(retry == 1){confirmBox(language["confirm"], language["firstExam"],starTest, []);}
				else
				{
					var missing = 120 - lapse;
					// alertBox(language["alert"], language["trialBlocked"]+missing+language["trialBlocked2"], 300);
					// return;
				}
			}
			else
			{
				console.log("ultimo intento aprobado")
				// confirmBox(language["confirm"], language["examPrevPassed"],starTest, []);
				starTest()
				
			}
		}
		else
		{
			
			console.log("primera vez")
			// CONFIRM EXAM ****
			// confirmBox(language["confirm"], language["firstExam"],starTest, []);
			starTest()
		}
		
		return;
		
	});
}
function setMyPass()
{
	myPass = "1";
	showModal("pssSetModal");
}
function pssSetCheck()
{
	var info = {};
	
	if(myPass == "1"){info.CODE = userData.CODE;}
	else{info.CODE = changePassFor;}
	
	info.PASSWD = document.getElementById("InputPass1").value;
	
	
	
	var testSymbols = /[!@$%&#]/.test(info.PASSWD)
	var testNumbers = /\d/.test(info.PASSWD);
	var testCapital = info.PASSWD !== info.PASSWD.toLowerCase();
	
	
	
	console.log(testSymbols);
	console.log(testNumbers);
	console.log(testCapital);
	
	// must have !@$%&#
	if(testSymbols == false || testNumbers == false || testCapital == false)
	{
		alertBox(language["alert"], language["passInstruction"], 300);
		return
	}
	
	console.log("good pass")
	
	
	// return;
	
	
	
	var p1 = document.getElementById("InputPass1").value;
	var p2 = document.getElementById("InputPass2").value;
	
	if(p1 == "")
	{
		alertBox(language["alert"], language["mussPass"], 300);
		return;
	}
	if(p1 != p2)
	{
		alertBox(language["alert"], language["mussPass"], 300);
		return;
	}
	
	console.log(info);
	
	// return;
	sendAjax("users","setPass",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		alertBox(language["alert"], language["pssChanged"], 300);
		
		document.getElementById("InputPass1").value = "";
		document.getElementById("InputPass2").value = "";
		
		hideModal("pssSetModal");
	});
}
function pssSetCheckRec()
{
	var info = {};
	
	console.log(ucode)
	
	info.CODE = ucode;
	info.PASSWD = document.getElementById("InputPass1").value;
	
	var p1 = document.getElementById("InputPass1").value;
	var p2 = document.getElementById("InputPass2").value;
	
	if(p1 == "")
	{
		alertBox(language["alert"], language["mussPass"], 300);
		return;
	}
	if(p1 != p2)
	{
		alertBox(language["alert"], language["mussPass"], 300);
		return;
	}
	
	console.log(info);
	
	sendAjax("users","setPass",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		alertBox(language["alert"], language["pssChanged"], 300);
		
		
		setTimeout(function(){window.location.href = 'login.html';},2000);
		
		
	});
}

function starTest()
{
	actualQuestions = actualQuestions;
	loadForm("test");	
	hideModal("confirmModal");
}

// LOADFORMS-----------------
function loadForm(type)
{
	
	actualIf = type;
	
	var mainBox = document.getElementById("main-content");
	mainBox.innerHTML = "";
	
	var contentArea = document.createElement("div");
	contentArea.className = "container-fluid px-4 row";

	var formTitle = document.createElement("h3");
	formTitle.className = "mt-4";
	
	var ButtonsBox = document.createElement("div");
	ButtonsBox.className = "row";
	
	var bCage = document.createElement("div");
	bCage.className = "form-floating col-lg-6 bCage";
	
	var saveButton = document.createElement("button");
	saveButton.className = "btn btn-primary filterButton1";
	saveButton.innerHTML = language["save"];
	
	var cancelButton = document.createElement("button");
	cancelButton.className = "btn btn-warning filterButton2";
	cancelButton.innerHTML = language["cancel"];
	
	contentArea.appendChild(formTitle);
	mainBox.appendChild(contentArea);
	
	
	if(type == "courses")
	{

		
		var CODE = fieldCreator([12,4,3,2], language["coursesFormCode"], "input", "text", "CODE");
		var COURSE_PIC = fieldCreator([12,4,3,3], "", "picture", "selector", "COURSE_PIC");
		
		var COURSE_LIFE = fieldCreator([12,4,2,2], language["coursesFormLife"], "input", "number", "COURSE_LIFE");
		var COURSE_PRICE = fieldCreator([12,4,2,1], language["coursesFormPrice"], "input", "number", "COURSE_PRICE");
		var CERFT_LIFE = fieldCreator([12,4,2,2], language["coursesFormCertLife"], "input", "number", "CERFT_LIFE");
		
		
		var CAT = fieldCreator([12,4,2,1], language["coursesForm_cat"], "select", "select", "CAT");
		var TYPE = fieldCreator([12,4,2,1], language["coursesForm_Type"], "select", "select", "TYPE");
		
		var CNAME_ES = fieldCreator([12,4,3,3], language["coursesForm_cname_es"], "input", "text", "CNAME_ES");
		var DESC_ES = fieldCreator([12,4,3,6], language["coursesForm_desc_es"], "input", "text", "DESC_ES");
		var VIDEO_ES = fieldCreator([12,4,4,3], language["coursesForm_video_es"], "input", "text", "VIDEO_ES");
		// var FILE_ES = fieldCreator([12,4,3,2], language["coursesForm_file_es"], "file", "text", "FILE_ES");
		
		var CNAME_EN = fieldCreator([12,4,3,3], language["coursesForm_cname_en"], "input", "text", "CNAME_EN");
		var DESC_EN = fieldCreator([12,4,3,6], language["coursesForm_desc_en"], "input", "text", "DESC_EN");
		var VIDEO_EN = fieldCreator([12,4,4,3], language["coursesForm_video_en"], "input", "text", "VIDEO_EN");
		// var FILE_EN = fieldCreator([12,4,3,2], language["coursesForm_file_en"], "file", "text", "FILE_EN");
		
		var CNAME_PT = fieldCreator([12,4,3,3], language["coursesForm_cname_pt"], "input", "text", "CNAME_PT");
		var DESC_PT = fieldCreator([12,4,3,6], language["coursesForm_desc_pt"], "input", "text", "DESC_PT");
		var VIDEO_PT = fieldCreator([12,4,4,3], language["coursesForm_video_pt"], "input", "text", "VIDEO_PT");
		// var FILE_PT = fieldCreator([12,4,3,2], language["coursesForm_file_pt"], "file", "text", "FILE_PT");

		contentArea.appendChild(CODE);
		contentArea.appendChild(COURSE_LIFE);
		contentArea.appendChild(COURSE_PRICE);
		contentArea.appendChild(CERFT_LIFE);
		contentArea.appendChild(CAT);
		contentArea.appendChild(TYPE);
		
		document.getElementById("COURSE_LIFE").value = 360;
		document.getElementById("COURSE_PRICE").value = 100;
		document.getElementById("CERFT_LIFE").value = 360;
		
		
		document.getElementById("CODE").addEventListener('input', function(){toUpperCase(this);}, true);

		contentArea.appendChild(COURSE_PIC);
				
		var hr = document.createElement("hr");
		hr.className = "formBar";
		contentArea.appendChild(hr);
		
		contentArea.appendChild(CNAME_ES);
		contentArea.appendChild(DESC_ES);
		contentArea.appendChild(VIDEO_ES);
		// contentArea.appendChild(FILE_ES);
		
		var hr = document.createElement("hr");
		hr.className = "formBar";
		contentArea.appendChild(hr);
		
		contentArea.appendChild(CNAME_EN);
		contentArea.appendChild(DESC_EN);
		contentArea.appendChild(VIDEO_EN);
		// contentArea.appendChild(FILE_EN);
		
		var hr = document.createElement("hr");
		hr.className = "formBar";
		contentArea.appendChild(hr);
		
		contentArea.appendChild(CNAME_PT);
		contentArea.appendChild(DESC_PT);
		contentArea.appendChild(VIDEO_PT);
		// contentArea.appendChild(FILE_PT);
		
		selectFiller("CAT", language["catsAdminTit"], masterCats, "CODE", "CATNAME_"+lang);
		// selectFiller("CAT", language["catsAdminTit"], masterCats, "CODE", "CATNAME_"+lang);
		
		
		// FILL DOCTYPES
		var options = [language["ctype1"], language["ctype2"]];
		selectFiller("TYPE", "Seleccione tipo", options);
		
		
		
		// SET DATE FIELDS
		// setDateField("USER_BDAY");

		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["coursesFormTitCreate"];
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		
		
		
		var slidesButton = document.createElement("button");
		slidesButton.className = "btn btn-primary filterButton1";
		slidesButton.innerHTML = language["slides"];
		
		
		slidesButton.onclick = function ()
		{
			console.log(actualEditData.CODE)
			actualCourseCode = actualEditData.CODE;
			ifLoad("coursepics")
		}
		
		
		var docsButton = document.createElement("button");
		docsButton.className = "btn btn-primary filterButton1";
		docsButton.innerHTML = language["docsButton"];
		
		
		docsButton.onclick = function ()
		{
			console.log(actualEditData.CODE)
			actualCourseCode = actualEditData.CODE;
			ifLoad("docs")
		}
		
		
		
		
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		
		// document.getElementById("CODE").value = "SEG-003";
		// document.getElementById("CNAME_ES").value = "CNAME_ES";
		// document.getElementById("DESC_ES").value = "DESC_ES";
		// document.getElementById("VIDEO_ES").value = "VIDEO_ES";
		
		// document.getElementById("CNAME_EN").value = "CNAME_EN";
		// document.getElementById("DESC_EN").value = "DESC_EN";
		// document.getElementById("VIDEO_EN").value = "VIDEO_EN";
		
		// document.getElementById("CNAME_PT").value = "CNAME_PT";
		// document.getElementById("DESC_PT").value = "DESC_PT";
		// document.getElementById("VIDEO_PT").value = "VIDEO_PT";

		
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		
		
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		
		
		if(saveMode == "edit")
		{
			console.log(actualEditData)
			
			formTitle.innerHTML = language["coursesFormTitEdit"];
			formEditFiller("main-content", actualEditData);
			document.getElementById("CODE").disabled = true;
			document.getElementById("COURSE_PIC").src = "courses/pics/"+actualEditData.CODE+".jpg";
			// document.getElementById("FILE_ES").value = actualEditData.CODE+"_ES.pdf";
			// document.getElementById("FILE_EN").value = actualEditData.CODE+"_EN.pdf";
			// document.getElementById("FILE_PT").value = actualEditData.CODE+"_PT.pdf";
			
			bCage.appendChild(slidesButton);
			bCage.appendChild(docsButton);
			
		}
		
		
		
		
		ButtonsBox.appendChild(bCage);
		
		contentArea.appendChild(ButtonsBox);
	
	
	
	}
	if(type == "tests")
	{
		
		var TESTNAME = fieldCreator([12,4,3,3], language["testsForm_testName"], "input", "text", "TESTNAME");
		
		contentArea.appendChild(TESTNAME);
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["testsFormTitCreate"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["testsFormTitEdit"];
			formEditFiller("main-content", actualEditData);
		}
	}
	if(type == "questions")
	{

		var QUESTION_ES = fieldCreator([12,12,12,12], language["questionsForm_q_es"], "input", "text", "QUESTION_ES");
		var FAKE_1_ES = fieldCreator([12,6,6,6], language["questionsForm_f1_es"], "input", "text", "FAKE_1_ES");
		var FAKE_2_ES = fieldCreator([12,6,6,6], language["questionsForm_f2_es"], "input", "text", "FAKE_2_ES");
		var FAKE_3_ES = fieldCreator([12,6,6,6], language["questionsForm_f3_es"], "input", "text", "FAKE_3_ES");
		var ANS_ES = fieldCreator([12,6,6,6], language["questionsForm_r_es"], "input", "text", "ANS_ES");
		
		
		var QUESTION_EN = fieldCreator([12,12,12,12], language["questionsForm_q_en"], "input", "text", "QUESTION_EN");
		var FAKE_1_EN = fieldCreator([12,6,6,6], language["questionsForm_f1_en"], "input", "text", "FAKE_1_EN");
		var FAKE_2_EN = fieldCreator([12,6,6,6], language["questionsForm_f2_en"], "input", "text", "FAKE_2_EN");
		var FAKE_3_EN = fieldCreator([12,6,6,6], language["questionsForm_f3_en"], "input", "text", "FAKE_3_EN");
		var ANS_EN = fieldCreator([12,6,6,6], language["questionsForm_r_en"], "input", "text", "ANS_EN");
		
		
		var QUESTION_PT = fieldCreator([12,12,12,12], language["questionsForm_q_pt"], "input", "text", "QUESTION_PT");
		var FAKE_1_PT = fieldCreator([12,6,6,6], language["questionsForm_f1_pt"], "input", "text", "FAKE_1_PT");
		var FAKE_2_PT = fieldCreator([12,6,6,6], language["questionsForm_f2_pt"], "input", "text", "FAKE_2_PT");
		var FAKE_3_PT = fieldCreator([12,6,6,6], language["questionsForm_f3_pt"], "input", "text", "FAKE_3_PT");
		var ANS_PT = fieldCreator([12,6,6,6], language["questionsForm_r_pt"], "input", "text", "ANS_PT");
		

		contentArea.appendChild(QUESTION_ES);
		contentArea.appendChild(FAKE_1_ES);
		contentArea.appendChild(FAKE_2_ES);
		contentArea.appendChild(FAKE_3_ES);
		contentArea.appendChild(ANS_ES);
		
		
		var hr = document.createElement("hr");
		hr.className = "formBar";
		contentArea.appendChild(hr);
		
		contentArea.appendChild(QUESTION_EN);
		contentArea.appendChild(FAKE_1_EN);
		contentArea.appendChild(FAKE_2_EN);
		contentArea.appendChild(FAKE_3_EN);
		contentArea.appendChild(ANS_EN);
		
		
		var hr = document.createElement("hr");
		hr.className = "formBar";
		contentArea.appendChild(hr);
		
		contentArea.appendChild(QUESTION_PT);
		contentArea.appendChild(FAKE_1_PT);
		contentArea.appendChild(FAKE_2_PT);
		contentArea.appendChild(FAKE_3_PT);
		contentArea.appendChild(ANS_PT);

		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["questionsFormTitCreate"];
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		
		


		
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		// TESTING BLOCK------------------------
		

		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["questionsFormTitEdit"];
			formEditFiller("main-content", actualEditData);
		}


	}
	if(type == "users")
	{
		
		
		var unameLabel = language["usersForm_Name"];
		if(userData.TYPE == "0"){unameLabel = language["usersForm_Name2"];}
		
		var NAME = fieldCreator([12,4,3,3], unameLabel, "input", "text", "NAME");
		var IDTYPE = fieldCreator([12,4,3,3], language["usersForm_idtype"], "select", "select", "IDTYPE");
		var IDNUMBER = fieldCreator([12,4,3,3], language["usersForm_id"], "input", "text", "IDNUMBER");
		var EMAIL = fieldCreator([12,4,3,3], language["usersForm_email"], "input", "text", "EMAIL");
		var ADDRESS = fieldCreator([12,4,3,3], language["usersForm_address"], "input", "text", "ADDRESS");
		var PHONE = fieldCreator([12,4,3,3], language["usersForm_phone"], "input", "text", "PHONE");
		var TYPE = fieldCreator([12,4,3,3], language["usersForm_type"], "select", "select", "TYPE");
		var COMPANY = fieldCreator([12,4,3,3], language["usersForm_company"], "select", "select", "COMPANY");
		
		
		contentArea.appendChild(NAME);
		contentArea.appendChild(IDTYPE);
		contentArea.appendChild(IDNUMBER);
		contentArea.appendChild(EMAIL);
		contentArea.appendChild(ADDRESS);
		contentArea.appendChild(PHONE);
		contentArea.appendChild(TYPE);
		contentArea.appendChild(COMPANY);
		
		var options = [language["idType1"],language["idType2"],language["idType3"]];
		selectFiller("IDTYPE", language["pickIdType"], options);
		
		if(userData.TYPE == "1")
		{
			var options = [language["utypeOpt2"], language["utypeOpt9"]];
		}
		else if(userData.TYPE == "4")
		{
			var options = [language["utypeOpt2"]];
		}
		else
		{
			var options = [language["utypeOpt0"], language["utypeOpt1"], language["utypeOpt2"], language["utypeOpt3"], language["utypeOpt9"]];
		}

		
		selectFiller("TYPE", language["utypeOpt"], options);
		
		
		
		
		document.getElementById("TYPE").onchange = function ()
		{
			var pick = this.value.split("-")[0];
			
			var cpicker = document.getElementById("COMPANY");
			cpicker.innerHTML = "";
			var option = document.createElement("option");
			option.value = "";
			option.innerHTML = language["selectCompany"];
			
			if(pick == "2" || pick == "4")
			{
				
				document.getElementById("COMPANY_BOX").style.display = "initial";
				cpicker.appendChild(option);
				
				console.log(pick)
				
				for(var i=0; i<masterUsers.length; i++)
				{
					var user = masterUsers[i];
					var type = user.TYPE;
					
					if(user.TYPE == "1" || pick == "4")
					{
						var option = document.createElement("option");
						option.value = user.CODE;
						option.innerHTML = user.NAME;
						cpicker.appendChild(option);
					}
				}
				
				if(userData.TYPE == "4")
				{
					document.getElementById("COMPANY").value = userData.COMPANY;
				}
				if(userData.TYPE == "1")
				{
					document.getElementById("COMPANY").value = userData.CODE;
				}
				
			}
			else
			{
				document.getElementById("COMPANY_BOX").style.display = "none";
			}
		}
		
		
		document.getElementById("COMPANY_BOX").style.display = "none";
		
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["usersFormTitCreate"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(userData.TYPE == "1" || userData.TYPE == "4")
		{
			document.getElementById("TYPE").value = "2-"+language["utypeOpt2H"];
			document.getElementById("TYPE").onchange();
			
			
			if(userData.TYPE == "4")
			{
				document.getElementById("COMPANY").value = userData.COMPANY;
			}
			if(userData.TYPE == "1")
			{
				document.getElementById("COMPANY").value = userData.CODE;
			}
			
			// document.getElementById("COMPANY").value = userData.CODE;
			
			
			document.getElementById("COMPANY").disabled = true;
		}
		
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["usersFormTitEdit"];
			formEditFiller("main-content", actualEditData);
			
			if(actualEditData.TYPE == "0"){document.getElementById("TYPE").value = language["utypeOpt0"];}
			if(actualEditData.TYPE == "1"){document.getElementById("TYPE").value = language["utypeOpt1"];}
			if(actualEditData.TYPE == "2"){document.getElementById("TYPE").value = language["utypeOpt2"];}
			if(actualEditData.TYPE == "3"){document.getElementById("TYPE").value = language["utypeOpt3"];}
			if(actualEditData.TYPE == "4"){document.getElementById("TYPE").value = language["utypeOpt9"];}
			
			console.log(actualEditData.TYPE )
			
			document.getElementById("TYPE").onchange();
			document.getElementById("COMPANY").value = actualEditData.COMPANY
			document.getElementById("EMAIL").disabled = true;
			
			
		}
	}
	if(type == "plans")
	{
		
		
		var COURSES = fieldCreator([12,4,3,12], language["plansForm_Courses"], "multiselect", "select", "COURSES");
		var USER = fieldCreator([12,4,3,3], language["plansForm_Name"], "select", "select", "USER");
		var USERS = fieldCreator([12,4,3,3], language["plansForm_Users"], "input", "text", "USERS");
		var STARTDATE = fieldCreator([12,4,3,3], language["plansForm_Start"], "input", "text", "STARTDATE");
		var ENDATE = fieldCreator([12,4,3,3], language["plansForm_End"], "input", "text", "ENDATE");
		
		contentArea.appendChild(COURSES);
		contentArea.appendChild(USER);
		contentArea.appendChild(STARTDATE);
		contentArea.appendChild(ENDATE);
		contentArea.appendChild(USERS);
		
		var tmpUsers = [];
		
		for(var i=0; i<masterUsers.length; i++)
		{
			var user = masterUsers[i];
			var name = user.NAME;
			var id = user.IDNUMBER;
			
			if(user.TYPE == "0"){var type = language["utypeOpt0H"];}
			if(user.TYPE == "1"){var type = language["utypeOpt1H"];}
			if(user.TYPE == "2"){var type = language["utypeOpt2H"];}
			if(user.TYPE == "3"){var type = language["utypeOpt3H"];}
			
			var friendly = language["friendUser1"]+name+" - "+language["friendUser2"]+id+" - "+language["friendUser3"]+type;
			masterUsers[i]["FRIENDLY"] = friendly;
		}
		
		
		
		selectFiller("USER", "Usuario", masterUsers, "CODE", "FRIENDLY");
		
		document.getElementById("USER").onchange = function ()
		{
			var pick  = this.value;
			if(pick != "")
			{
				
				for(var i=0; i<masterUsers.length; i++)
				{
					var user = masterUsers[i];
					
					var code = user.CODE;
					var name = user.NAME;
					var id = user.IDNUMBER
					var type = user.TYPE
					
					if(code == pick)
					{
						planUserCode = code;
						planUserName = name;
						planUserId = id;
						planUserType = type;
						break;
					}
				}
				
				
				console.log(planUserId)
				
				
		}
			else
			{
				planUserCode = "";
				planUserName = "";
				planUserId = "";
				planUserType = "";
			}
			
			if(planUserType != "1")
			{
				document.getElementById("USERS").value = "1";
				document.getElementById("USERS").disabled = true;
			}
			else
			{
				document.getElementById("USERS").disabled = false;
			}
			
			
			
		}
		
		
		
		// GET COURSE NAME
		for(var i=0; i<masterCourses.length; i++)
		{
			var cat = getCat(masterCourses[i].CAT)
			masterCourses[i]["FULLDESC"] = cat+" - "+masterCourses[i]["CODE"]+" * "+masterCourses[i]["CNAME_"+lang];
		}
	
		
		
		
		
		
		
		var clistP = [];
		multiSelectFillerDicF("COURSES", "CODE", "FULLDESC",masterCourses,clistP,"1","0");
		// multiSelectFillerDicF("COURSES", "CODE", "FULLDESC",myCourses,clistP,"1","0");
		
		
		setDateField("STARTDATE");
		setDateField("ENDATE");
		
		document.getElementById("USER").onchange();
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["plansFormTitCreate"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["plansFormTitEdit"];
			
			
			setTimeout(function()
			{
				formEditFiller("main-content", actualEditData);
				
				var clistP = JSON.parse(actualEditData.COURSES);

				multiSelectFillerDicF("COURSES", "CODE", "FULLDESC",masterCourses,clistP,"1","0");
				document.getElementById("USER").value = actualEditData.UCODE;
				document.getElementById("USER").onchange();
				
				
			}, 200);
			
		
			
		}
	}
	if(type == "bundles")
	{
		
		
		var NAME = fieldCreator([12,4,3,3], language["bundleForm_Name"], "input", "text", "NAME");
		var COURSES = fieldCreator([12,4,3,12], language["plansForm_Courses"], "multiselect", "select", "COURSES");
		
		contentArea.appendChild(NAME);
		contentArea.appendChild(COURSES);
		
		console.log(uplans)
		
		var companyCourses = JSON.parse(uplans[0].COURSES);
		console.log(companyCourses)
		
		// SELECT ONLY PLAN COURSES
		var validCourses = [];
		
		for(var i=0; i<masterCourses.length; i++)
		{
			var ccode = masterCourses[i].CODE;
			if(!companyCourses.includes(ccode)){continue;}
			var cat = getCat(masterCourses[i].CAT)
			masterCourses[i]["FULLDESC"] = cat+" - "+masterCourses[i]["CODE"]+" * "+masterCourses[i]["CNAME_"+lang];
			validCourses.push(masterCourses[i]);
		}
		
		
		var clistP = [];
		
		
		multiSelectFillerDic("COURSES", "CODE", "FULLDESC",validCourses,clistP,"1","0");
		
				
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["bundleFormTitCreate"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["bundleFormTitEdit"];
			
			setTimeout(function()
			{
				formEditFiller("main-content", actualEditData);
				
				var clistP = JSON.parse(actualEditData.COURSES);
				multiSelectFillerDic("COURSES", "CODE", "FULLDESC",validCourses,clistP,"1","0");
				
			}, 200);

		}
	}
	if(type == "test")
	{
		
		// GET COURSE NAME
		for(var i=0; i<masterCourses.length; i++)
		{
			var course = masterCourses[i];
			if(course.CODE == actualCourseCode){var cname = course["CNAME_"+lang];}
		}
		
		
		questCodes = [];
		
		
		for(var i=0; i<actualQuestions.length; i++)
		{
			var question = actualQuestions[i];
			var pregunt = fieldCreator([12,4,3,12], question["QUESTION_"+lang], "multiselect", "select", question["CODE"]+i);
			
			questCodes.push(question["CODE"]+i);
			
			contentArea.appendChild(pregunt);
			
			var options = [];
			
			var a = {"TRUE":"0","TEXT":question["FAKE_1_"+lang], "QCODE":question["CODE"]+i+"a"};
			var b = {"TRUE":"0","TEXT":question["FAKE_2_"+lang], "QCODE":question["CODE"]+i+"b"};
			var c = {"TRUE":"0","TEXT":question["FAKE_3_"+lang], "QCODE":question["CODE"]+i+"c"};
			var d = {"TRUE":"1","TEXT":question["ANS_"+lang], "QCODE":question["CODE"]+i+"d"};
			
			options.push(a);
			options.push(b);
			options.push(c);
			options.push(d);
			options = shuffle(options);
			
			multiSelectFillerDic(question["CODE"]+i, "TRUE", "TEXT",options,[],"0","0");
			
		}

		// SET TITLE AND SAVE FUNCTION
		
		if(actualCourseData["TYPE"] == "I")
		{
			formTitle.innerHTML = language["testFor"]+actualCourseCode+" "+cname;
		}
		else
		{
			formTitle.innerHTML = language["testFor"]+actualCourseCode+" "+cname+" -> "+language["moduleContentLabel"]+": "+actualModule;
		}
		
		
		
		saveButton.innerHTML = language["sendTest"]
		
		saveButton.onclick = function ()
		{
			for(var i=0; i<questCodes.length; i++)
			{
				var code = questCodes[i];
				var ans = getPickedIds(code);
				if(ans.length == 0){alertBox(language["alert"], language["mustAnswerAll"], 300); return;}
			}
			
			confirmBox(language["confirm"], language["confirmTestSend"],scoreTest, []);
			
		}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		
		
		
		
		
		
		// bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);

		
	}
	if(type == "slide")
	{
		
		
		var COURSE = fieldCreator([12,4,3,3], language["slidesForm_Course"], "input", "text", "COURSE");
		var LANG = fieldCreator([12,4,3,2], language["slidesForm_Lang"], "select", "select", "LANG");
		var POS = fieldCreator([12,4,3,3], language["slidesForm_Pos"], "input", "number", "POS");
		var MODU = fieldCreator([12,4,3,2], language["slidesForm_modu"], "input", "number", "MODU");
		var FILE = fieldCreator([12,4,3,2], language["slide_file"], "file", "text", "FILE");
		
		contentArea.appendChild(COURSE);
		contentArea.appendChild(LANG);
		contentArea.appendChild(POS);
		contentArea.appendChild(MODU);
		contentArea.appendChild(FILE);
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["slidesFormTitCreate"];
		
		document.getElementById("COURSE").value = actualCourseCode;
		document.getElementById("COURSE").disabled = true;
		
		document.querySelector('#FILE').addEventListener('keypress', function (e) {
		if (e.key === 'Enter') 
		{
			console.log("lol")
			saveReg(actualIf);
		}
		});
		
		
		var options = ["EN", "ES", "PT"];
		selectFiller("LANG", language["pickLang"], options);
		
		
		cancelButton.innerHTML = language["exit"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["slidesFormTitEdit"];
			formEditFiller("main-content", actualEditData);
			
			document.getElementById("LANG").disabled = true;
			document.getElementById("POS").disabled = true;
			
			
		}
		
		

	}
	if(type == "docs")
	{
		
		
		var COURSE = fieldCreator([12,4,2,2], language["slidesForm_Course"], "input", "text", "COURSE");
		var NAME = fieldCreator([12,4,2,2], language["docs_name"], "input", "text", "NAME");
		var LANG = fieldCreator([12,4,2,2], language["slidesForm_Lang"], "select", "select", "LANG");
		var TYPE = fieldCreator([12,4,2,2], language["docsForm_type"], "select", "select", "TYPE");
		var POS = fieldCreator([12,4,2,2], language["slidesForm_Pos"], "input", "number", "POS");
		var FILE = fieldCreator([12,4,2,2], language["slide_file"], "file", "text", "FILE");
		var LINK = fieldCreator([12,4,2,2], language["docs_link"], "input", "text", "LINK");
		
		contentArea.appendChild(COURSE);
		contentArea.appendChild(NAME);
		contentArea.appendChild(LANG);
		contentArea.appendChild(POS);
		contentArea.appendChild(TYPE);
		contentArea.appendChild(FILE);
		contentArea.appendChild(LINK);
		
		document.getElementById("FILE_BOX").style.display = "none";
		document.getElementById("LINK_BOX").style.display = "none";
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["docsFormTitCreate"];
		
		document.getElementById("COURSE").value = actualCourseCode;
		document.getElementById("COURSE").disabled = true;
		
		
		var options = ["EN", "ES", "PT"];
		selectFiller("LANG", language["pickLang"], options);
		
		
		var fileTypes = [{"DESC": language["ft0"], "VAL": 0}, {"DESC": language["ft1"], "VAL": 1}];
		selectFiller("TYPE", language["defaultDocTypePicker"], fileTypes, "VAL", "DESC");
		
		document.getElementById("TYPE").onchange = function ()
		{
			var pick  =  this.value;
			if(pick == 0)
			{
				document.getElementById("LINK_BOX").style.display = "initial";
				document.getElementById("FILE_BOX").style.display = "none";
			}
			if(pick == 1)
			{
				document.getElementById("LINK_BOX").style.display = "none";
				document.getElementById("FILE_BOX").style.display = "initial";
			}
		}
		
		
		
		cancelButton.innerHTML = language["exit"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		

	}
	if(type == "cats")
	{
		
		var CATNAME_ES = fieldCreator([12,4,3,3], language["catsForm_catName_es"], "input", "text", "CATNAME_ES");
		var CATNAME_EN = fieldCreator([12,4,3,3], language["catsForm_catName_en"], "input", "text", "CATNAME_EN");
		var CATNAME_PT = fieldCreator([12,4,3,3], language["catsForm_catName_pt"], "input", "text", "CATNAME_PT");
		
		contentArea.appendChild(CATNAME_ES);
		contentArea.appendChild(CATNAME_EN);
		contentArea.appendChild(CATNAME_PT);
		
		// SET TITLE AND SAVE FUNCTION
		formTitle.innerHTML = language["catsFormTitCreate"];
		
		saveButton.onclick = function (){saveReg(actualIf);}
		cancelButton.onclick = function (){exitForm(actualIf);}
		bCage.appendChild(saveButton);
		bCage.appendChild(cancelButton);
		ButtonsBox.appendChild(bCage);
		contentArea.appendChild(ButtonsBox);
		
		if(saveMode == "edit")
		{
			formTitle.innerHTML = language["catsFormTitEdit"];
			formEditFiller("main-content", actualEditData);
		}
	}
	
}
function fixSlide()
{
	if(actualIf == "content"){setTimeout(function(){setSlide();},1000);}
}
function setSlide()
{
	let slider = document.querySelector('.slider'),
	  sliderList = slider.querySelector('.slider-list'),
	  sliderTrack = slider.querySelector('.slider-track'),
	  slides = slider.querySelectorAll('.slide'),
	  arrows = slider.querySelector('.slider-arrows'),
	  prev = arrows.children[0],
	  next = arrows.children[1],
	  slideWidth = slides[0].offsetWidth,
	  slideIndex = 0,
	  posInit = 0,
	  posX1 = 0,
	  posX2 = 0,
	  posY1 = 0,
	  posY2 = 0,
	  posFinal = 0,
	  isSwipe = false,
	  isScroll = false,
	  allowSwipe = true,
	  transition = true,
	  nextTrf = 0,
	  prevTrf = 0,
	  lastTrf = --slides.length * slideWidth,
	  posThreshold = slides[0].offsetWidth * 0.35,
	  trfRegExp = /([-0-9.]+(?=px))/,
	  swipeStartTime,
	  swipeEndTime,
	  getEvent = function() {
		return (event.type.search('touch') !== -1) ? event.touches[0] : event;
	  },
	  slide = function() {
		if (transition) {
		  sliderTrack.style.transition = 'transform .5s';
		}
		sliderTrack.style.transform = `translate3d(-${slideIndex * slideWidth}px, 0px, 0px)`;

		prev.classList.toggle('disabled', slideIndex === 0);
		next.classList.toggle('disabled', slideIndex === --slides.length);
	  },
	  swipeStart = function() {
		let evt = getEvent();

		if (allowSwipe) {

		  swipeStartTime = Date.now();
		  
		  transition = true;

		  nextTrf = (slideIndex + 1) * -slideWidth;
		  prevTrf = (slideIndex - 1) * -slideWidth;

		  posInit = posX1 = evt.clientX;
		  posY1 = evt.clientY;

		  sliderTrack.style.transition = '';

		  document.addEventListener('touchmove', swipeAction);
		  document.addEventListener('mousemove', swipeAction);
		  document.addEventListener('touchend', swipeEnd);
		  document.addEventListener('mouseup', swipeEnd);

		  sliderList.classList.remove('grab');
		  sliderList.classList.add('grabbing');
		}
	  },
	  swipeAction = function() {

		let evt = getEvent(),
		  style = sliderTrack.style.transform,
		  transform = +style.match(trfRegExp)[0];

		posX2 = posX1 - evt.clientX;
		posX1 = evt.clientX;

		posY2 = posY1 - evt.clientY;
		posY1 = evt.clientY;

		if (!isSwipe && !isScroll) {
		  let posY = Math.abs(posY2);
		  if (posY > 7 || posX2 === 0) {
			isScroll = true;
			allowSwipe = false;
		  } else if (posY < 7) {
			isSwipe = true;
		  }
		}

		if (isSwipe) {
		  if (slideIndex === 0) {
			if (posInit < posX1) {
			  setTransform(transform, 0);
			  return;
			} else {
			  allowSwipe = true;
			}
		  }

		  // запрет ухода вправо на последнем слайде
		  if (slideIndex === --slides.length) {
			if (posInit > posX1) {
			  setTransform(transform, lastTrf);
			  return;
			} else {
			  allowSwipe = true;
			}
		  }

		  if (posInit > posX1 && transform < nextTrf || posInit < posX1 && transform > prevTrf) {
			reachEdge();
			return;
		  }

		  sliderTrack.style.transform = `translate3d(${transform - posX2}px, 0px, 0px)`;
		}

	  },
	  swipeEnd = function() {
		posFinal = posInit - posX1;

		isScroll = false;
		isSwipe = false;

		document.removeEventListener('touchmove', swipeAction);
		document.removeEventListener('mousemove', swipeAction);
		document.removeEventListener('touchend', swipeEnd);
		document.removeEventListener('mouseup', swipeEnd);

		sliderList.classList.add('grab');
		sliderList.classList.remove('grabbing');

		if (allowSwipe) {
		  swipeEndTime = Date.now();
		  if (Math.abs(posFinal) > posThreshold || swipeEndTime - swipeStartTime < 300) {
			if (posInit < posX1) {
			  slideIndex--;
			} else if (posInit > posX1) {
			  slideIndex++;
			}
		  }

		  if (posInit !== posX1) {
			allowSwipe = false;
			slide();
		  } else {
			allowSwipe = true;
		  }

		} else {
		  allowSwipe = true;
		}

	  },
	  setTransform = function(transform, comapreTransform) {
		if (transform >= comapreTransform) {
		  if (transform > comapreTransform) {
			sliderTrack.style.transform = `translate3d(${comapreTransform}px, 0px, 0px)`;
		  }
		}
		allowSwipe = false;
	  },
	  reachEdge = function() {
		transition = false;
		swipeEnd();
		allowSwipe = true;
	  };

	sliderTrack.style.transform = 'translate3d(0px, 0px, 0px)';
	sliderList.classList.add('grab');

	sliderTrack.addEventListener('transitionend', () => allowSwipe = true);
	slider.addEventListener('touchstart', swipeStart);
	slider.addEventListener('mousedown', swipeStart);

	arrows.addEventListener('click', function() {
	  let target = event.target;

	  if (target.classList.contains('next')) {
		slideIndex++;
	  } else if (target.classList.contains('prev')) {
		slideIndex--;
	  } else {
		return;
	  }

	  slide();
	});
	
	
}
function scoreTest()
{
	
	var good = 0;
	
	console.log(questCodes)
	
	var answers = [];
	
	for(var i=0; i<questCodes.length; i++)
	{
		var code = questCodes[i];
		var ans = getPickedIds(code)[0].split("-")[0];
		
		var answer = {};
		
		if(ans == "1"){good++;var result = 1;}
		else{var result = 0;}
		
		answer.QCODE = code
		answer.UCODE = userData.CODE
		answer.DATE = getNow()
		answer.RESULT = result
		answer.LANG = lang
		
		answers.push(answer);
			
	}
	
	console.log(answers);
	
	
	var total = questCodes.length;
	
	console.log("correctas: "+good+" de "+total);
	
	var percent = parseInt(good/total*100);
	
	var info = {};
	info.UCODE = userData.CODE
	info.SCORE = percent;
	info.COURSE = actualCourseCode;
	info.MODU = actualModule;
	info.ANSWERS = answers;
	
	console.log(info)
	
	
	// return;
	
	sendAjax("users","saveTrial",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		
		if(info.SCORE >= passBase)
		{
			alertBox(language["alert"], infoIcon+language["approbed"], 300);
			ifLoad("content")
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["failed"] , 300);
			ifLoad("courses_client")
		}
	
		

		hideModal("confirmModal");
		
		
		
	});
	
	
	
	
}
function getCert()
{
	var info = {};
	info.UCODE = userData.CODE
	info.COURSE = actualCourseCode;
	info.LANG = lang;
	info.LIMIT = passBase;
	
	
	console.log(info)
	
	sendAjax("users","getCert",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		// return;
		
		if(ans == "new")
		{
			alertBox(language["alert"], language["newCert"], 300);
			return;
		}
		if(ans == "failed")
		{
			
			console.log()
			if(actualCourseData["TYPE"] == "I")
			{
				alertBox(language["alert"], language["failedCertIspring"], 300);
			}
			else
			{
				alertBox(language["alert"], language["failedCert"], 300);
			}
			
			
			
			return;
		}
		if(ans == "expired")
		{
			alertBox(language["alert"], language["expiredCert"], 300);
			return;
		}


		
		var url = "certs/"+ans+".pdf";
		console.log(url)
		
		// downloadURI("data:text/pdf", url);
		window.open(url, '_blank');
		
	});
	
}
function toUpperCase(a)
{
	setTimeout(function(){a.value = a.value.toUpperCase();}, 1);
}
function getPickedIds(id)
{
	var daddy = document.getElementById(id);
	var kids = daddy.getElementsByTagName("div");
	var picked = [];
	for(var i=0; i<kids.length; i++)
	{
		var kbox = kids[i].children[0];
		if(kbox.checked == true)
		{
			if(id == "COURSES")
			{picked.push(kbox.id.split("-")[1]+"-"+kbox.id.split("-")[2]);}
			else{picked.push(kbox.id.split("-")[1]);}
		}
	}
	return picked;
}
// SAVEREG-----------------
// SAVEREG-----------------
// SAVEREG-----------------
function saveReg(form)
{
	console.log(form)
	console.log(imfoo)
	
	var info = {};
	info.FORM = form;
	info.MODE = saveMode;
	info.LANG = lang;
	if(info.MODE == "edit")
	{
		info.EDITCODE = actualEditData.CODE;
	}
	
	if(form == "courses")
	{
		info.CODE = document.getElementById("CODE").value;
		info.COURSE_LIFE = document.getElementById("COURSE_LIFE").value;
		info.COURSE_PRICE = document.getElementById("COURSE_PRICE").value;
		info.CERFT_LIFE = document.getElementById("CERFT_LIFE").value;
		info.CAT = document.getElementById("CAT").value;
		info.PIC = actualCoursePic;
		info.CNAME_ES = document.getElementById("CNAME_ES").value;
		info.CNAME_EN = document.getElementById("CNAME_EN").value;
		info.CNAME_PT = document.getElementById("CNAME_PT").value;
		info.DESC_ES = document.getElementById("DESC_ES").value;
		info.DESC_EN = document.getElementById("DESC_EN").value;
		info.DESC_PT = document.getElementById("DESC_PT").value;
		info.VIDEO_ES = document.getElementById("VIDEO_ES").value;
		info.VIDEO_EN = document.getElementById("VIDEO_EN").value;
		info.VIDEO_PT = document.getElementById("VIDEO_PT").value;
		info.TYPE = document.getElementById("TYPE").value;
		// info.FILE_ES = actualCourseFileEs;
		// info.FILE_EN = actualCourseFileEn;
		// info.FILE_PT = actualCourseFilePt;
		
		if(info.CODE == ""){alertBox(language["alert"], infoIcon+language["mustCode"], 300); return;}
		if(info.COURSE_LIFE == ""){alertBox(language["alert"], infoIcon+language["mustLife"], 300); return;}
		if(info.COURSE_PRICE == ""){alertBox(language["alert"], infoIcon+language["mustPrice"], 300); return;}
		if(info.CERFT_LIFE == ""){alertBox(language["alert"], infoIcon+language["mustCertLife"], 300); return;}
		if(info.CAT == ""){alertBox(language["alert"], infoIcon+language["mustCat"], 300); return;}
		if(info.CODE == ""){alertBox(language["alert"], infoIcon+language["mustCode"], 300); return;}
		if(info.PIC == "" && info.MODE == "new"){alertBox(language["alert"], infoIcon+language["mustPic"], 300); return;}
		if(info.CNAME_ES == ""){alertBox(language["alert"], infoIcon+language["mustCnameEs"], 300); return;}
		if(info.CNAME_EN == ""){alertBox(language["alert"], infoIcon+language["mustCnameEn"], 300); return;}
		if(info.CNAME_PT == ""){alertBox(language["alert"], infoIcon+language["mustCnamePt"], 300); return;}
		if(info.DESC_ES == ""){alertBox(language["alert"], infoIcon+language["mustDescEs"], 300); return;}
		if(info.DESC_EN == ""){alertBox(language["alert"], infoIcon+language["mustDescEn"], 300); return;}
		if(info.DESC_PT == ""){alertBox(language["alert"], infoIcon+language["mustDescPt"], 300); return;}

	}
	
	if(form == "tests")
	{
		info.TESTNAME = document.getElementById("TESTNAME").value;
		if(info.TESTNAME == ""){alertBox(language["alert"], infoIcon+language["mustTestName"], 300); return;}
	}
	
	if(form == "questions")
	{
		info.QUESTION_ES = document.getElementById("QUESTION_ES").value;
		info.FAKE_1_ES = document.getElementById("FAKE_1_ES").value;
		info.FAKE_2_ES = document.getElementById("FAKE_2_ES").value;
		info.FAKE_3_ES = document.getElementById("FAKE_3_ES").value;
		info.ANS_ES = document.getElementById("ANS_ES").value;
		
		info.QUESTION_EN = document.getElementById("QUESTION_EN").value;
		info.FAKE_1_EN = document.getElementById("FAKE_1_EN").value;
		info.FAKE_2_EN = document.getElementById("FAKE_2_EN").value;
		info.FAKE_3_EN = document.getElementById("FAKE_3_EN").value;
		info.ANS_EN = document.getElementById("ANS_EN").value;
		
		info.QUESTION_PT = document.getElementById("QUESTION_PT").value;
		info.FAKE_1_PT = document.getElementById("FAKE_1_PT").value;
		info.FAKE_2_PT = document.getElementById("FAKE_2_PT").value;
		info.FAKE_3_PT = document.getElementById("FAKE_3_PT").value;
		info.ANS_PT = document.getElementById("ANS_PT").value;


		if(info.QUESTION_ES == ""){alertBox(language["alert"], infoIcon+language["mustQuestionEs"], 300); return;}
		if(info.FAKE_1_ES == ""){alertBox(language["alert"], infoIcon+language["mustF1Es"], 300); return;}
		if(info.FAKE_2_ES == ""){alertBox(language["alert"], infoIcon+language["mustF2Es"], 300); return;}
		if(info.FAKE_3_ES == ""){alertBox(language["alert"], infoIcon+language["mustF3Es"], 300); return;}
		if(info.ANS_ES == ""){alertBox(language["alert"], infoIcon+language["mustResEs"], 300); return;}
		
	}
	
	if(form == "users")
	{
		info.NAME = document.getElementById("NAME").value;
		info.IDTYPE = document.getElementById("IDTYPE").value;
		info.IDNUMBER = document.getElementById("IDNUMBER").value;
		info.EMAIL = document.getElementById("EMAIL").value;
		info.ADDRESS = document.getElementById("ADDRESS").value;
		info.PHONE = document.getElementById("PHONE").value;
		info.TYPE = document.getElementById("TYPE").value;
		info.COMPANY = document.getElementById("COMPANY").value;
		
		if(userData.TYPE == "1" || userData.TYPE == "4"){info.ULIMIT = usersLimit;}

		if(info.NAME == ""){alertBox(language["alert"], infoIcon+language["mustUserName"], 300); return;}
		if(info.IDTYPE == ""){alertBox(language["alert"], infoIcon+language["mustUserIdtype"], 300); return;}
		if(info.IDNUMBER == ""){alertBox(language["alert"], infoIcon+language["mustUserIdnum"], 300); return;}
		if(info.EMAIL == ""){alertBox(language["alert"], infoIcon+language["mustUser"], 300); return;}
		if(info.TYPE == ""){alertBox(language["alert"], infoIcon+language["mustUserType"], 300); return;}
	}
	
	if(form == "register")
	{
		info.NAME = document.getElementById("regNameField").value;
		info.IDTYPE = document.getElementById("regIdTypeField").value;
		info.IDNUMBER = document.getElementById("regIdNumberField").value;
		info.EMAIL = document.getElementById("regEmailField").value;
		info.ADDRESS = document.getElementById("regAddressField").value;
		info.PHONE = document.getElementById("regPhoneField").value;
		info.TYPE = document.getElementById("regUtypeField").value;
		// info.COMPANY = document.getElementById("regCompanyField").value;
		
		info.MODE = "new";

		if(info.NAME == ""){alertBox(language["alert"], infoIcon+language["mustUserName"], 300); return;}
		if(info.IDTYPE == ""){alertBox(language["alert"], infoIcon+language["mustUserIdtype"], 300); return;}
		if(info.IDNUMBER == ""){alertBox(language["alert"], infoIcon+language["mustUserIdnum"], 300); return;}
		if(info.EMAIL == ""){alertBox(language["alert"], infoIcon+language["mustUser"], 300); return;}
		if(info.TYPE == ""){alertBox(language["alert"], infoIcon+language["mustUserType"], 300); return;}
	}
	
	if(form == "plans")
	{
		info.UCODE = planUserCode;
		info.UNAME = planUserName;
		info.UTYPE = planUserType;
		info.UIDNUMBER = planUserId;
		info.STARTDATE = document.getElementById("STARTDATE").value;
		info.ENDATE = document.getElementById("ENDATE").value;
		info.USERS = document.getElementById("USERS").value;
		var coursesPicks = getPickedIds("COURSES")
		info.COURSES = JSON.stringify(coursesPicks);

		if(info.UCODE == ""){alertBox(language["alert"], infoIcon+language["mustUserPlan"], 300); return;}
		if(info.STARTDATE == ""){alertBox(language["alert"], infoIcon+language["mustStartPlan"], 300); return;}
		if(info.ENDATE == ""){alertBox(language["alert"], infoIcon+language["mustEndPlan"], 300); return;}
		if(info.UTYPE == "1"){if(info.USERS == ""){alertBox(language["alert"], infoIcon+language["mustUsersPlan"], 300); return;}}
		else{info.USERS = "1";}

	}
	
	if(form == "bundles")
	{
		
		info.NAME = document.getElementById("NAME").value;
		var coursesPicks = getPickedIds("COURSES");
		info.COURSES = JSON.stringify(coursesPicks);
		if(userData.TYPE == "1"){info.COMPANY = userData.CODE;}
		else{info.COMPANY = userData.COMPANY;}
		if(info.NAME == ""){alertBox(language["alert"], infoIcon+language["mustNameBundle"], 300); return;}
		
		
	}
	
	if(form == "slide")
	{
		info.COURSE = document.getElementById("COURSE").value;
		info.LANG = document.getElementById("LANG").value;
		info.POS = document.getElementById("POS").value;
		info.FILE = actualCourseSlide;
		info.MODU = document.getElementById("MODU").value;

		if(info.LANG == ""){alertBox(language["alert"], infoIcon+language["mustSlideLang"], 300); return;}
		if(info.POS == ""){alertBox(language["alert"], infoIcon+language["mustSlidePos"], 300); return;}
		if(info.FILE == "" && info.MODE != "edit"){alertBox(language["alert"], infoIcon+language["mustFileSlide"], 300); return;}
		if(info.MODU == "" && info.MODE != "edit"){alertBox(language["alert"], infoIcon+language["mustModuSlide"], 300); return;}
		
	}
	
	if(form == "docs")
	{
		info.COURSE = document.getElementById("COURSE").value;
		info.NAME = document.getElementById("NAME").value;
		info.LANG = document.getElementById("LANG").value;
		info.POS = document.getElementById("POS").value;
		info.TYPE = document.getElementById("TYPE").value;
		info.LINK = document.getElementById("LINK").value;
		info.FILE = actualCourseSlide;
		info.EXT = actualFormat;
		
		
		if(info.NAME == ""){alertBox(language["alert"], infoIcon+language["mustSlideName"], 300); return;}
		if(info.LANG == ""){alertBox(language["alert"], infoIcon+language["mustSlideLang"], 300); return;}
		if(info.POS == ""){alertBox(language["alert"], infoIcon+language["mustSlidePos"], 300); return;}
		if(info.TYPE == ""){alertBox(language["alert"], infoIcon+language["mustFileType"], 300); return;}
		
		if(info.TYPE == 0)
		{
			if(info.LINK == ""){alertBox(language["alert"], infoIcon+language["mustLink"], 300); return;}
		}
		if(info.TYPE == 1)
		{
			if(info.FILE == ""){alertBox(language["alert"], infoIcon+language["mustFile"], 300); return;}
		}
		
		
		
	}
	
	if(form == "cats")
	{
		info.CATNAME_ES = document.getElementById("CATNAME_ES").value;
		info.CATNAME_EN = document.getElementById("CATNAME_EN").value;
		info.CATNAME_PT = document.getElementById("CATNAME_PT").value;
		
		if(info.CATNAME_ES == ""){alertBox(language["alert"], infoIcon+language["mustCatName_ES"], 300); return;}
		if(info.CATNAME_EN == ""){alertBox(language["alert"], infoIcon+language["mustCatName_EN"], 300); return;}
		if(info.CATNAME_PT == ""){alertBox(language["alert"], infoIcon+language["mustCatName_PT"], 300); return;}
	}
	
	console.log(info)
	
	// return
	sendAjax("users","saveReg",info,function(response)
	{
		var ans = response.message;
		console.log(ans);
		
		
		if(info.FORM == "courses")
		{
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["codeExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				actualCoursePic = "";
				actualCourseFileEs = "";
				actualCourseFileEn = "";
				actualCourseFilePt = "";
				ifLoad("courses");
				return;
			}
		}
		if(info.FORM == "tests")
		{
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["testNameExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("tests");
				return;
			}
		}
		if(info.FORM == "questions")
		{
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["questionExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("questions");
				return;
			}
		}
		if(info.FORM == "users")
		{
			
			// console.log("user stop")
			// return
			
			if(ans == "qtyLimit")
			{
				alertBox(language["alert"], infoIcon+language["qtyLimit"]+" <br><b>("+info.ULIMIT+")</b>", 300);
				return;
			}
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["userExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("users");
				return;
			}
		}
		if(info.FORM == "register")
		{
			
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["userExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				
				setTimeout(function(){window.location.replace( "login.html");},1800);
				
				
				

				return;
			}
		}
		if(info.FORM == "plans")
		{
			if(ans == "exist")
			{
				// alertBox(language["alert"], infoIcon+language["userExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("plans");
				return;
			}
		}
		if(info.FORM == "bundles")
		{
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["bundleExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("bundles");
				return;
			}
		}
		if(info.FORM == "slide")
		{
			
			if(info.MODE == "edit")
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("coursepics");
				return;
			}
			
			
			// alertBox(language["alert"], infoIcon+language["saved"], 300);
			var newpos = parseInt(info.POS)+1;
			console.log(newpos)
			document.getElementById("POS").value = parseInt(newpos);
			document.getElementById("FILE").value = "";
			// ifLoad("coursepics");
			actualCourseSlide = "";
			return;
		}
		if(info.FORM == "docs")
		{
			var newpos = parseInt(info.POS)+1;
			console.log(newpos)
			document.getElementById("POS").value = parseInt(newpos);
			document.getElementById("FILE").value = "";
			document.getElementById("LINK").value = "";
			actualCourseSlide = "";
			return;
		}
		if(info.FORM == "cats")
		{
			if(ans == "exist")
			{
				alertBox(language["alert"], infoIcon+language["bundleExist"], 300);return;
			}
			else
			{
				alertBox(language["alert"], infoIcon+language["saved"], 300);
				ifLoad("cats");
				return;
			}
		}
	
	});
	
}
function exitForm(loc)
{
	
	console.log(loc)
	
	if(loc == "courses")
	{
		actualCoursePic = "";
		actualCourseFileEs = "";
		actualCourseFileEn = "";
		actualCourseFilePt = "";
		
		ifLoad("courses");
	}
	if(loc == "tests")
	{
		ifLoad("tests");
	}
	if(loc == "questions")
	{
		ifLoad("questions");
	}
	if(loc == "users")
	{
		ifLoad("users");
	}
	if(loc == "plans")
	{
		ifLoad("plans");
	}
	if(loc == "bundles")
	{
		ifLoad("bundles");
	}
	if(loc == "slide")
	{
		ifLoad("coursepics");
	}
	if(loc == "docs")
	{
		ifLoad("docs");
	}
	if(loc == "cats")
	{
		ifLoad("cats");
	}

}
function fieldCreator(sizes, title, object, type, id)
{
	  var label = document.createElement("span");
	  label.innerHTML = title;
	  label.className = "fieldLabel";
	  
	  var box = document.createElement("div");
	  box.id = id+"_BOX";
	  var cname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3];
	  box.className = cname;

	  if(object == "picture")
	  {
		var cname = "col-xs-"+sizes[0]+" col-sm-"+sizes[1]+" col-md-"+sizes[2]+" col-lg-"+sizes[3]+" picPicker";
		box.className = cname;
		
		var field = document.createElement("img");
		field.id = id;
		field.src = "img/courseBlank.jpg";
		field.type = "img";
		field.className = "coursePic";
		field.onclick = function ()
		{
			actualPicking = "coursePic";
			document.getElementById("fileSelector").click();
		}
	  }
	  else if(object == "tableField")
	  {
		var field = document.createElement("div");
		field.id = id;
		field.className = "tableField";  
	  }
	  else if(object == "multiselect")
	  {
		var field = document.createElement("div");
		field.id = id;
		field.className = "multiselectBox";  
	  }
	  else if(object == "file")
	  {
		var field = document.createElement("input");
		field.id = id;
		field.type = "text";
		field.placeholder = language["pickFile"];
		field.className = "form-control";
		field.onclick = function ()
		{
			actualPicking = id;
			document.getElementById("fileSelector").click();
		}
	  }
	  else
	  {
		var field = document.createElement(object);
		field.id = id;
		field.type = type;
		field.className = "form-control";
	  }

	  box.appendChild(label);
	  box.appendChild(field);
	  
	  return box;
}
function onFileSelected(event) 
{
	var selectedFile = event.target.files[0];
  
	actualFileName = selectedFile.name;
  
	var spfname = selectedFile.name.split('.');
	var spfnameLen = spfname.length;
	var format = spfname[(spfnameLen-1)];
	console.log(format)
	
	actualFormat = format;
	
	var reader = new FileReader();

	reader.onload = function(event) 
	{
		actualPickedFile64 = event.target.result;
		console.log();
		
		
		if(actualPicking == "coursePic")
		{
			var imgtag = document.getElementById("COURSE_PIC");
			imgtag.src = actualPickedFile64;
			actualCoursePic = actualPickedFile64;
			
		}
		if(actualPicking == "FILE_ES")
		{
			console.log(actualFileName)
			document.getElementById("FILE_ES").value = actualFileName;
			
			actualCourseFileEs = actualPickedFile64;
		}
		if(actualPicking == "FILE_EN")
		{
			console.log(actualFileName)
			document.getElementById("FILE_EN").value = actualFileName;
			
			actualCourseFileEn = actualPickedFile64;
		}
		if(actualPicking == "FILE_PT")
		{
			console.log(actualFileName)
			document.getElementById("FILE_PT").value = actualFileName;
			
			actualCourseFilePt = actualPickedFile64;
		}
		if(actualPicking == "FILE")
		{
			console.log(actualFileName)
			document.getElementById("FILE").value = actualFileName;
			actualCourseSlide = actualPickedFile64;
		}
		
		if(actualPicking == "PLAIN")
		{
			console.log(actualFileName)
			document.getElementById("PLAIN").value = actualFileName;
			
			actualPlainFile = actualPickedFile64;
		}
		
		document.getElementById("fileSelector").value = "";

	};
	
	reader.readAsDataURL(selectedFile);
	
	
	
}
function formEditFiller(containerId, data)
{
	var fieldsBox = document.querySelector("#"+containerId);
	var keys = Object.keys(data);
	
	var ignore = [];
	
	for(var i=0; i<keys.length; i++)
	{
		var item = keys[i];
		if(ignore.includes(item)){continue;}
		if(fieldsBox.querySelector("#"+item) != null)
		{document.getElementById(item).value = data[item];}
	}
	

}
// SET DATE FIELD ----------
function setDateField(id, time)
{
	if(time != null)
	{
		jQuery('#'+id).datetimepicker({ dateFormat: 'yy-mm-dd' });
	}
	else
	{
		jQuery('#'+id).datetimepicker
		({
			timepicker:false,
			format:'Y-m-d',
		}).on('change', function() {
			jQuery('.xdsoft_datetimepicker').hide();
			var str = jQuery(this).val();
			str = str.split(".");
		});
	}
}
// DELETE ITEMS
function deleteItem(params)
{
	
	console.log(params)
	
	var table = params[0];
	var data = params[1];

	var info = {};
	info.table = table;
	
	
	if(table == "courses"){info.field = "CODE";}
	if(table == "tests"){info.field = "CODE";}
	if(table == "questions"){info.field = "CODE";}
	if(table == "users"){info.field = "CODE";}
	if(table == "plans"){info.field = "CODE";}
	if(table == "bundles"){info.field = "CODE";}
	if(table == "slides"){info.field = "CODE";}
	if(table == "docs"){info.field = "CODE";}
	if(table == "cats"){info.field = "CODE";}



	info.code = data[info.field];
	
	
	console.log(info);
	
	sendAjax("users","deleteItem",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(info.table == "courses")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("courses");
		}
		if(info.table == "tests")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("tests");
		}
		if(info.table == "questions")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("questions");
		}
		if(info.table == "users")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("users");
		}
		if(info.table == "plans")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("plans");
		}
		if(info.table == "bundles")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("bundles");
		}
		if(info.table == "slides")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("slides");
		}
		if(info.table == "docs")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("docs");
		}
		if(info.table == "cats")
		{
			alertBox(language["alert"], infoIcon+language["deleted"], 300);
			listGet("cats");
		}
		
		hideModal("confirmModal");
		
		
	});
}
function multiSelectFillerDic(id, value, desc, list, compareList, single, locked)
{
	var picker = document.getElementById(id);
	picker.innerHTML = "";
	
	for(var i=0; i<list.length; i++)
	{
		var itemValue = list[i][value];
		var itemDesc = list[i][desc];
		
		var option = document.createElement("div");
		option.className = "custom-control custom-checkbox myCheck";
		
		var random = Math.random();
		
		var input = document.createElement("input");
		input.className = "custom-control-input";
		input.id = random+"-"+itemValue;
		input.type = "checkbox";
		
		// MARK IF IN ARRAY
		if(compareList != null)
		{
			if(compareList.includes(itemValue))
			{input.checked = true;}
		}
		
		// DISABLE INPUT IF LOCKED
		if(locked == "1"){input.disabled = true;}
				
		var label = document.createElement("label");
		label.innerHTML = itemDesc;
		label.htmlFor  = random+"-"+itemValue;
		label.className = "custom-control-label";
		
		option.appendChild(input);
		option.appendChild(label);

		// SINGLE BEHAVIOR
		if(single == "0" && locked != "1")
		{
			option.onclick = function()
			{
				var me = document.getElementById(this.children[0].id);
				var options = this.parentNode.children;
				for(var n=0; n<options.length; n++)
				{
					var box = options[n].children[0];
					box.checked = false;
				}
				me.checked = true;
			}
		}
		
		picker.appendChild(option);

	}
}
// MULTIFILLER SEARCHBOX_
function multiSelectFillerDicF(id, value, desc, list, compareList, single, locked)
{
	var picker = document.getElementById(id);
	picker.innerHTML = "";
	
	var searchField = document.createElement("input");
	searchField.type = "text";
	searchField.fieldId = id;
	searchField.id = "SEARCHFIELD_"+id;
	searchField.placeholder = language["Search"];
	searchField.className = "searchField";
	searchField.onkeyup = function ()
	{
		var myId = this.id;
		filterFunctionMultipicker(this);
	}
	
	var allPicker = document.createElement("input");
	allPicker.type = "checkbox";
	allPicker.id = "thisPicker-"+id;
	allPicker.className = "allPicker";
	allPicker.onchange = function ()
	{
		var state = this.checked;
		var dad = this.parentNode;
		var lines = dad.getElementsByTagName("div");
		for(var i=0; i<lines.length; i++)
		{
			var line = lines[i];
			var visible = line.style.display;
			if(visible != "none"){line.children[0].checked = state;}
		}
		
		pickedCheck(this, 1);
	}
	
	picker.myAllBox = allPicker;
	
	picker.appendChild(searchField);
	picker.appendChild(allPicker);
	if(locked == "1"){allPicker.disabled = true;}
	
	for(var i=0; i<list.length; i++)
	{
		var itemValue = list[i][value];
		var itemDesc = list[i][desc];
		
		var option = document.createElement("div");
		option.className = "custom-control custom-checkbox";
		
		var random = Math.random();
		
		var input = document.createElement("input");
		input.className = "custom-control-input";
		input.id = random+"-"+itemValue;
		input.type = "checkbox";
		
		input.checked = false;
		
		// MARK IF IN ARRAY
		if(compareList != null)
		{
			if(compareList.includes(itemValue)){input.checked = true;}
			else{input.checked = false;}
		}
		
		input.onchange = function ()
		{
			// pickedCheck(this, 2);
		}
		
		// DISABLE INPUT IF LOCKED
		if(locked == "1"){input.disabled = true;}
				
		var label = document.createElement("label");
		
		
		if(id == "CONTRACT_ACTIVITIES")
		{
			var parents = getActivityParents(itemValue);
			var projectCode = parents.split(" - ")[0];
			var programCode = parents.split(" - ")[1];
			
			for(var j=0; j<programs.length; j++)
			{
				var prog = programs[j];
				if(prog.PROGRAM_CODE == programCode){var progName = prog.PROGRAM_NAME; break;}
			}
			
			for(var j=0; j<projects.length; j++)
			{
				var proj = projects[j];
				if(proj.PROJECT_CODE == projectCode){var projName = proj.PROJECT_NAME; break;}
			}
			
			label.innerHTML = itemDesc+" - "+projName+" - "+progName;
		}
		else
		{
			label.innerHTML = itemDesc;
		}
		
		label.htmlFor  = random+"-"+itemValue;
		label.className = "custom-control-label speciaLine";
		
		option.appendChild(input);
		option.appendChild(label);

		// SINGLE BEHAVIOR
		if(single == "0" && locked != "1")
		{
			option.onclick = function()
			{
				var me = document.getElementById(this.children[0].id);
				var options = this.parentNode.children;
				for(var n=0; n<options.length; n++)
				{
					var box = options[n].children[0];
					box.checked = false;
				}
				me.checked = true;
			}
		}
		
		picker.appendChild(option);

	}
}
function filterFunctionMultipicker(me) 
{
  
  var input, filter, ul, li, a, i;
  input = me;
  filter = input.value.toUpperCase();

  var box = me.parentNode;

  a = box.getElementsByTagName("div");
  for (i = 0; i < a.length; i++) 
  {
    var line = a[i].children[1];
	txtValue = line.textContent || line.innerText;
    if(txtValue.toUpperCase().includes(filter)) 
	{
      line.parentNode.style.display = "";
    } else {
      line.parentNode.style.display = "none";
    }
  }
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
		nInYet.innerHTML = language["noResults"];
		nInYet.className = "blankProducts";
		table.appendChild(nInYet);
		return;
	}
	
	var thisLang = lang.toUpperCase();
	
	// COURSES TABLE
	if(tableId == "coursesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var cat = getCat(list[i].CAT);
			
			var code = cellCreator(language["coursesTT0"], cat+" - "+list[i].CODE);
			
			var coursePic = "<img id='cover_"+list[i].CODE+"' src='courses/pics/"+list[i].CODE+".jpg' class='coursePicAdmin' /><br>";
		
			
			var a = cellCreator(language["coursesTT3"], coursePic);

			var currentName_ES = flag_ES+" "+list[i].CNAME_ES;
			var currentName_EN = flag_EN+" "+list[i].CNAME_EN;
			var currentName_PT = flag_PT+" "+list[i].CNAME_PT;
			var courseNames = currentName_ES+"<br>"+currentName_EN+"<br>"+currentName_PT;
			var b = cellCreator(language["coursesTT1"], courseNames);
			
			var currentDesc_ES = flag_ES+" "+list[i].DESC_ES;
			var currentDesc_EN = flag_EN+" "+list[i].DESC_EN;
			var currentDesc_PT = flag_PT+" "+list[i].DESC_PT;
			var courseDescs = currentDesc_ES+"<br>"+currentDesc_EN+"<br>"+currentDesc_PT;
			var c = cellCreatorL(language["coursesTT2"], courseDescs);
			
			var g = cellCreator(language["coursesTT6"], list[i].COURSE_LIFE);
			var h = cellCreator(language["coursesTT7"], list[i].COURSE_PRICE);
			var j = cellCreator(language["coursesTT8"], list[i].CERFT_LIFE);
			
			var filesPath = "courses/files/";
			
			// var linkES = "<a class= 'tableFlagFile' href='courses/files/"+list[i].CODE+"_ES.pdf' target = 'blank'>"+flag_ES+"</a>";
			// var linkEN = "<a class= 'tableFlagFile' href='courses/files/"+list[i].CODE+"_ES.pdf' target = 'blank'>"+flag_EN+"</a>";
			// var linkPT = "<a class= 'tableFlagFile' href='courses/files/"+list[i].CODE+"_PT.pdf' target = 'blank'>"+flag_PT+"</a>";
			
			// var courseFiles = linkES+"<br>"+linkEN+"<br>"+linkPT;
			// var d = cellCreator(language["coursesTT4"], courseFiles);
			
			if(list[i].VIDEO_ES != "" && list[i].VIDEO_ES != null)
			{
				var vidES = "<a class= 'tableFlagFile' href='"+list[i].VIDEO_ES+"' target = 'blank'>"+flag_ES+"  Video Español</a> ";
			}
			else
			{
				var vidES = flag_ES+" No video";
			}
			
			if(list[i].VIDEO_EN != "" && list[i].VIDEO_EN != null)
			{
				var vidEN = "<a class= 'tableFlagFile' href='"+list[i].VIDEO_EN+"' target = 'blank'>"+flag_EN+"  English video</a> ";
			}
			else
			{
				var vidEN = flag_EN+" No video";
			}
			
			if(list[i].VIDEO_PT != "" && list[i].VIDEO_PT != null)
			{
				var vidPT = "<a class= 'tableFlagFile' href='"+list[i].VIDEO_PT+"' target = 'blank'>"+flag_PT+"  Portuguese video</a> ";
			}
			else
			{
				var vidPT = flag_PT+" No video";
			}
			
			var videoLinks = vidES+"<br>"+vidEN+"<br>"+vidPT;
			
			var e = cellCreatorL(language["coursesTT5"], videoLinks);
			
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "courses";
				editItem(type)
			}
			
			var link = document.createElement("img");
			
			if(list[i].TEST != "" && list[i].TEST != null)
			{
				link.src = "img/linkedTest.png";
			}
			else
			{
				link.src = "img/linkTest.png";
			}
			

			link.reg = list[i];
			link.setAttribute('title', language["setExamTool"]);
			link.setAttribute('alt', language["setExamTool"]);
			link.onclick = function()
			{
				actualCourseCode = this.reg.CODE;
				actualAssignedTest = this.reg.TEST;
				listGet("testPicker");
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["courses",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, link, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [code, a,b,c,e,g,h,j,x];
			
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
			
			var a = cellCreator(language["usersTT0"], list[i].NAME);
			var b = cellCreator(language["usersTT1"], list[i].IDNUMBER);
			
			var random = Math.random();
			var input = document.createElement("input");
			input.className = "custom-control-input";
			input.id = random+"-"+list[i].CODE;
			input.type = "checkbox";
			
			var chk = cellCheckCreator("", [input]);
			
			// console.log("reach")
			
		
			if(list[i].TYPE == "0"){var utype = language["utypeOpt0H"];}
			if(list[i].TYPE == "1"){var utype = language["utypeOpt1H"];}
			if(list[i].TYPE == "2"){var utype = language["utypeOpt2H"];}
			if(list[i].TYPE == "3"){var utype = language["utypeOpt3H"];}
			if(list[i].TYPE == "4"){var utype = language["utypeOpt9H"];}
			var c = cellCreator(language["usersTT2"], utype);
			
			var cName = "";
			var company = list[i].COMPANY;
			for(var u=0; u<masterUsers.length; u++)
			{
				var user = masterUsers[u];
				if(user.TYPE == "1")
				{if(user.CODE == company){var cName = user.NAME;break;}}
				else{var cName = "";}
			}
			
			var d = cellCreator(language["usersTT3"], cName);
			
			var e = cellCreator(language["usersTT4"], list[i].EMAIL);
			if(list[i].TRIALS == ""){list[i].TRIALS = [];}
			
			var passed = getCoursesFromTrials(list[i].TRIALS);
			
			var cline = "";
			
			for(var n = 0; n<passed.length; n++)
			{
				var crs = passed[n];
				cline += '<a href=javascript:getcertFromLink("' + list[i].CODE +"*"+ crs.COURSE + '")>*'+crs["NAME"]+'</a>';
				if(n < passed.length-1){cline += "<br>"}
			}
			
			if(list[i].TYPE != "2" && list[i].TYPE != "4")
			{
				var rate = "";
				var percent = rate;
				var unpassed = [];
			}
			else
			{
				var aprobbed = passed.length;
				if(JSON.parse(list[i].ALLOWED) == null)
				{
					var allowed = 0;
					var rate = 0;
				}
				else
				{
					var allowed = JSON.parse(list[i].ALLOWED);
					var bundles = [];
					if(list[i].BUNDLES != "" && list[i].BUNDLES != null){bundles = JSON.parse(list[i].BUNDLES);}
					var bundledCourses = getBundledCourses(bundles);
					allowed = [... new Set([...allowed, ...bundledCourses])]
					
					var allowedCount = allowed.length;
					var realCount = 0;
					
					for(var z=0; z<passed.length; z++)
					{
						var passedCode = passed[z].COURSE;
						// console.log(passedCode)
						if(allowed.includes(passedCode)){realCount++;}
					}
					var rate = parseInt(realCount/allowedCount*100);
					if(isNaN(rate)){rate = 0}
					
				}

				if(document.getElementById("userProgressFilter").value != "")
				{
					var limit = parseInt(document.getElementById("userProgressFilter").value)
					if(rate > limit){continue}
				}
				
				var color = "red";
				
				if(rate > 25){color = "#c54018"}; //red
				if(rate >= 50){color = "#e3b73a"}; //orange
				if(rate >= 75){color = "#d7b928"}; //yellow
				if(rate >= 100){color = "#00923f"}; //green
				
				var percent = "<b style='color:"+color+"'>"+parseInt(rate)+"%</b>";
				
				
				if(JSON.parse(list[i].ALLOWED) == null)
				{
					var asigned = [];
				}
				else
				{
					var asigned = JSON.parse(list[i].ALLOWED);
					var bundles = [];
					if(list[i].BUNDLES != "" && list[i].BUNDLES != null){bundles = JSON.parse(list[i].BUNDLES);}
					var bundledCourses = getBundledCourses(bundles);
					asigned = [... new Set([...asigned, ...bundledCourses])]
				}
				
				var unpassed = [];
				for(var m=0; m<masterCourses.length; m++)
				{
					var course = masterCourses[m];
					if(asigned.includes(course.CODE))
					{
						var item = {}
						item.NAME = getCourseName(course.CODE);
						unpassed.push(item)
					}
				}
			}
			
			var aline = "";
			
			for(var n = 0; n<unpassed.length; n++)
			{
				var crs = unpassed[n];
				aline += "*"+crs["NAME"];
				if(n < unpassed.length-1){aline += "<br>"}
			}
			
			var p = cellCreator(language["usersTT6"], encry(percent));
			var f = cellCreatorL(language["usersTT5"], cline);
			var z = cellCreatorL(language["usersTT7"], aline);
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "users";
				editItem(type)
			}
			
			var plan = document.createElement("img");
			plan.src = "img/plan.png";
			plan.reg = list[i];
			plan.setAttribute('title', language["planTool"]);
			plan.setAttribute('alt', language["planTool"]);
			plan.onclick = function()
			{
				var data = this.reg;
				userPlansCode = data.IDNUMBER;
				plansOrigin = "1";
				ifLoad('plans');
			}

			var password = document.createElement("img");
			password.src = "img/password.png";
			password.reg = list[i];
			password.setAttribute('title', language["setPassTool"]);
			password.setAttribute('alt', language["setPassTool"]);
			password.onclick = function()
			{
				var data = this.reg;
				changePassFor = data.CODE;
				myPass = "0";
				showModal("pssSetModal");
				
				// GET USER PLANS
				// console.log("GET USER PLANS, FLOATING LIST, ABLE TO ACTIVATE COURSES")
				
			}
			
			var status = document.createElement("img");
			if(list[i].STATUS == "1")
			{
				status.src = "img/active.png";
				status.setAttribute('title', language["setInactiveTool"]);
				status.setAttribute('alt', language["setInactiveTool"]);
			}
			else
			{
				status.setAttribute('title', language["setActiveTool"]);
				status.setAttribute('alt', language["setActiveTool"]);
				status.src = "img/activeG.png";
			}
			status.reg = list[i];
			status.onclick = function()
			{
				var data = this.reg;

				var info = {};
				info.CODE = data.CODE;
				info.ULIMIT = usersLimit;
				info.UTYPE = userData.TYPE;
				
				if(userData.TYPE == "1"){info.CCODE = userData.CODE;}
				if(userData.TYPE == "4"){info.CCODE = userData.COMPANY;}
				
				if(data.STATUS == "1"){info.STATUS = "0";}
				else{info.STATUS = "1";}
				
				
				console.log(info)
				// return
				
				sendAjax("users","statusChange",info,function(response)
				{
					
					var ans = response.message;
					
					if(ans == "qtyLimit")
					{
						alertBox(language["alert"], infoIcon+language["plainLimit"], 300);
						return;
					}
					
					console.log(ans)
					listGet("users");
					
				});
				
				
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["users",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var allow = document.createElement("img");
			allow.src = "img/allow.png";
			allow.reg = list[i];
			allow.setAttribute('title', language["allowSingleTool"]);
			allow.setAttribute('alt', language["allowSingleTool"]);
			allow.onclick = function()
			{
				var info = {};
				info.COMPANY = this.reg.COMPANY;
				info.ALLOWED = this.reg.ALLOWED;
				info.TYPE = this.reg.TYPE;
				info.BUNDLES = this.reg.BUNDLES;
				
				actualAllowUser = [this.reg.CODE];
				
				sendAjax("users","getCoursesByCompany",info,function(response)
				{
					var ans = response.message;
					var actualUserCourses = ans[0].COURSES;
					var setterBox = document.getElementById("coursesSetBox");
					setterBox.innerHTML = "";
					
					document.getElementById("limitDaysSingle").value = 15;
					
					var COURSES = fieldCreator([12,4,3,12], language["plansForm_Courses"], "multiselect", "select", "COURSES");
					
					// var GFILTERS_PICKER = fieldCreator([12,4,4,2], "Filtros gráfico", "multiselect", "select", "GFILTERS_PICKER");
					
					
					setterBox.appendChild(COURSES);
					document.getElementById("COURSES").classList.add("floatMultiSelect");
					
					var allowed = [];
					
					if(info.ALLOWED != "" && info.ALLOWED != null){allowed = JSON.parse(info.ALLOWED);}
					
					var myCourses = [];
					
					for(var i=0; i<masterCourses.length; i++)
					{
						var masterCode = masterCourses[i].CODE;
						var cat = getCat(masterCourses[i].CAT)
						masterCourses[i]["FULLDESC"] = cat+" - "+masterCourses[i]["CODE"]+" * "+masterCourses[i]["CNAME_"+lang];
						if(actualUserCourses.includes(masterCode)){myCourses.push(masterCourses[i]);}
					}
					
					
					if(info.TYPE == "2" || info.TYPE == "4")
					{
						var bundles = [];
						if(info.BUNDLES != "" && info.BUNDLES != null){bundles = JSON.parse(info.BUNDLES);}
						
						console.log(bundles)
						
						var bundledCourses = getBundledCourses(bundles);
						allowed = [... new Set([...allowed, ...bundledCourses])]
					}
					
					
					var clistP = allowed;
					
					console.log(allowed)
					
					
					multiSelectFillerDicF("COURSES", "CODE", "FULLDESC",myCourses,clistP,"1","0");
					
					
					showModal("coursesSetModal", 600);
				});
			
			}
			
			var allowBundle = document.createElement("img");
			allowBundle.src = "img/allowBundle.png";
			allowBundle.reg = list[i];
			allowBundle.setAttribute('title', language["allowBundleTool"]);
			allowBundle.setAttribute('alt', language["allowBundleTool"]);
			allowBundle.onclick = function()
			{
				var info = {};
				info.COMPANY = this.reg.COMPANY;
				info.BUNDLES = this.reg.BUNDLES;

				actualBundleUser = [this.reg.CODE];
				
				sendAjax("users","getBundlesByCompany",info,function(response)
				{
					var ans = response.message;
					console.log(ans)
					
					document.getElementById("limitDaysBundle").value = 15;
					
					var setterBox = document.getElementById("bundlesSetBox");
					setterBox.innerHTML = "";
					
					var COURSES_BUNDLE = fieldCreator([12,4,3,12], language["plansForm_Bundle"], "multiselect", "select", "COURSES_BUNDLE");
					setterBox.appendChild(COURSES_BUNDLE);
					document.getElementById("COURSES_BUNDLE").classList.add("floatMultiSelect");
					
					var bundles = [];
					
					if(info.BUNDLES != "" && info.BUNDLES != null){bundles = JSON.parse(info.BUNDLES);}
					
					
					
				
					var clistP = bundles;
					multiSelectFillerDicF("COURSES_BUNDLE", "CODE", "NAME",ans,clistP,"1","0");
					showModal("bundleSetModal");
				});
				
			}
			
			if(list[i].STATUS == "1")
			{
				if(userData.TYPE == "0")
				{
					if(list[i].TYPE == "2" || list[i].TYPE == "4")
					{
						var icons = [edit, allow, allowBundle, password, status, del];
					}
					else
					{
						var icons = [edit, plan, password, status, del];
					}
					var x = cellOptionsCreator('', icons)
					var cells = [chk,a,b,e,c,d,z,f,p,x];
				}
				else
				{
					document.getElementById("usersTT3").style.display = "none";
					
					if(list[i].TYPE == "2" || list[i].TYPE == "4")
					{
						var icons = [edit, allow, allowBundle, password, status, del];
					}
					else
					{
						var icons = [edit, password, status, del];
					}

					var x = cellOptionsCreator('', icons)
					var cells = [chk,a,b,e,c,z,f,p,x];
				}
			}
			else
			{
				if(userData.TYPE == "0")
				{
					var icons = [status, del];
					var x = cellOptionsCreator('', icons)
					var cells = [chk,a,b,e,c,d,z,f,p,x];
				}
				else
				{
					document.getElementById("usersTT3").style.display = "none";
					
					var icons = [status, del];
					var x = cellOptionsCreator('', icons)
					var cells = [chk,a,b,e,c,z,f,p,x];
				}
			}
			
			
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// TESTS TABLE
	if(tableId == "testsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator(language["testsTT0"], list[i].TESTNAME);
			
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "tests";
				editItem(type)
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["tests",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,x];
			
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

			var currentName_ES = flag_ES+" "+list[i].CATNAME_ES;
			var currentName_EN = flag_EN+" "+list[i].CATNAME_EN;
			var currentName_PT = flag_PT+" "+list[i].CATNAME_PT;
			var courseNames = currentName_ES+"<br>"+currentName_EN+"<br>"+currentName_PT;
			var a = cellCreator(language["catsTT0"], courseNames);

			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "cats";
				editItem(type)
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["cats",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// QUESTIONS TABLE
	if(tableId == "questionsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			
			var currentQuestion_ES = flag_ES+" "+list[i].QUESTION_ES;
			var currentQuestion_EN = flag_EN+" "+list[i].QUESTION_EN;
			var currentQuestion_PT = flag_PT+" "+list[i].QUESTION_PT;
			var questions = currentQuestion_ES+"<br>"+currentQuestion_EN+"<br>"+currentQuestion_PT;
			var a = cellCreator(language["questionsTT0"], questions);
			var b = cellCreator(language["questionsTT1"], list[i].TEST);
			var c = cellCreator(language["questionsTT2"], list[i].MODU);
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "questions";
				editItem(type)
			}
			
			var link = document.createElement("img");
			
			if(list[i].TEST != "" && list[i].TEST != null)
			{
				link.src = "img/linkedTest.png";
			}
			else
			{
				link.src = "img/linkTest.png";
			}
			

			link.reg = list[i];
			link.setAttribute('title', language["setExamTool"]);
			link.setAttribute('alt', language["setExamTool"]);
			link.onclick = function()
			{
				actualQuestionCode = this.reg.CODE;
				actualAssignedTest = this.reg.TEST;
				actualAssignedMod = this.reg.MODU;
				listGet("testPickerQ");
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["questions",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, link, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// PLANS TABLE
	if(tableId == "plansList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator(language["plansTT0"], list[i].UNAME);
			var b = cellCreator(language["plansTT1"], list[i].UIDNUMBER);
			if(list[i].UTYPE == "0"){var utype = language["utypeOpt0H"];}
			if(list[i].UTYPE == "1"){var utype = language["utypeOpt1H"];}
			if(list[i].UTYPE == "2"){var utype = language["utypeOpt2H"];}
			if(list[i].UTYPE == "3"){var utype = language["utypeOpt3H"];}
			var c = cellCreator(language["plansTT2"], utype);
			
			// FRIENDLY CNAMES
			var courses = JSON.parse(list[i].COURSES);
			var cline = "";
			for(var n = 0; n<courses.length; n++)
			{
				var crs = courses[n];
				for(var m=0; m<masterCourses.length; m++)
				{
					var master = masterCourses[m];
					if(crs == master.CODE)
					{
						cline += "* "+master["CNAME_"+lang];
						if(n < courses.length-1){cline += "<br>"}
						break;
					}
				}
				
			}
			var d = cellCreator(language["plansTT3"], cline);
			
			
			
			var e = cellCreator(language["plansTT4"], list[i].USERS);
			var f = cellCreator(language["plansTT5"], list[i].STARTDATE);
			var g = cellCreator(language["plansTT6"], list[i].ENDATE);
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "plans";
				editItem(type)
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["plans",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			
			var cells = [a,b,c,d,e,f,g,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// BUNDLES TABLE
	if(tableId == "bundlesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";
			
			var a = cellCreator(language["bundlesTT0"], list[i].NAME);
			
			// FRIENDLY CNAMES
			var courses = JSON.parse(list[i].COURSES);
			var cline = "";
			for(var n = 0; n<courses.length; n++)
			{
				var crs = courses[n];
				for(var m=0; m<masterCourses.length; m++)
				{
					var master = masterCourses[m];
					if(crs == master.CODE)
					{
						cline += "* "+master["CNAME_"+lang];
						if(n < courses.length-1){cline += "<br>"}
						break;
					}
				}
			}
			var b = cellCreator(language["bundlesTT1"], cline);
			
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "bundles";
				editItem(type)
			}
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["bundles",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// SLIDES TABLE
	if(tableId == "slidesList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator(language["slidesTT0"], list[i].COURSE);
			var b = cellCreator(language["slidesTT1"], list[i].LANG);
			var c = cellCreator(language["slidesTT2"], list[i].POS);
			
			
			var slide = "<img src='courses/files/"+list[i].COURSE+"-"+list[i].POS+"-"+list[i].LANG+" M "+list[i].MODU+".jpg"+tail+"' class='slidePic'/><br>";
			var d = cellCreator(language["slidesTT3"], slide);
			
			var e = cellCreator(language["slidesTT4"], list[i].MODU);
			
			
			var edit = document.createElement("img");
			edit.src = "img/edit.png";
			edit.reg = list[i];
			edit.setAttribute('title', language["editTool"]);
			edit.setAttribute('alt', language["editTool"]);
			edit.onclick = function()
			{
				actualEditData = this.reg;
				var type = "slide";
				editItem(type)
			}
			
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["slides",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [edit, del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,e,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// DOCS TABLE
	if(tableId == "docsList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator(language["docsTT0"], list[i].NAME);
			
			var type = "";
			
			if(list[i].TYPE == 0){type = language["ft0"];}
			if(list[i].TYPE == 1){type = language["ft1"];}
			
			
			var b = cellCreator(language["docsTT1"], type);
			var c = cellCreator(language["docsTT2"], list[i].LANG);
			var d = cellCreator(language["docsTT3"], list[i].POS);
			
			
			var del = document.createElement("img");
			del.src = "img/delete.png";
			del.reg = list[i];
			del.setAttribute('title', language["delTool"]);
			del.setAttribute('alt', language["delTool"]);
			del.onclick = function()
			{
				var data = this.reg;
				var params = ["docs",data];
				confirmBox(language["confirm"], language["confirmDelete"],deleteItem, params);
			}
			
			var icons = [del];
			

			// icons.push(del);
			
			var x = cellOptionsCreator('', icons)
			var cells = [a,b,c,d,x];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
	// ANSWERS TABLE
	if(tableId == "answersList")
	{
		for(var i=0; i<list.length; i++)
		{
			var row = document.createElement("div");
			row.className = "rowT";

			var a = cellCreator(language["answersTT0"], list[i].DESC);
			var b = cellCreator(language["answersTT1"], list[i].COURSE);
			var c = cellCreator(language["answersTT2"], list[i].MODU);
			var d = cellCreator(language["answersTT3"], list[i].UDATA);
			
			
			var cells = [a,b,c,d];
			
			for(var r=0; r<cells.length; r++){row.appendChild(cells[r]);}
			table.appendChild(row);
			
		}

	}
}
function showMyPic(img)
{
	
	var code = img.id.split("_")[1];
	
	img.src = "courses/pics/"+code+".jpg"+tail;
}
function getCat(code)
{
	
	for(var i=0; i<masterCats.length; i++)
	{
		var cat = masterCats[i];
		if(cat.CODE == code){var catName = cat["CATNAME_"+lang];return catName;}
	}
	
	return " NC ";
	
	
}
function createExpansive(text)
{
	var span = document.createElement("span");

	var maxLenght = 50;
	
	if(text.length > maxLenght)
	{
		if(text.includes("href")){var shorText = text.substring(0, 90);}
		else{var shorText = text.substring(0, maxLenght);}
		
		// console.log(shorText)
		
		var extraBox = document.createElement("span");
		extraBox.innerHTML = language["expansiveShow"];
		extraBox.className = "extraBox";
		extraBox.full = text+"<br>";
		extraBox.short = shorText+"<br>";
		extraBox.state = 0;
		extraBox.onclick = function ()
		{
			var fisrtSpan = this.parentNode.children[0];
			console.log(this.state);
			if(this.state == 0)
			{
				fisrtSpan.innerHTML = this.full;
				this.state = 1;
				this.innerHTML = language["expansiveHide"];
				this.style.color = "red";
				
			}
			else
			{
				fisrtSpan.innerHTML = this.short;
				this.state = 0;
				this.innerHTML = language["expansiveShow"];
				this.style.color = "#2b7bb3";
			}
		}
		
		var firstSpan = document.createElement("span");
		firstSpan.innerHTML = shorText+"<br>";

		
		span.appendChild(firstSpan);
		span.appendChild(extraBox);
	}
	else
	{
		span.innerHTML = text+"<br>";
	}

	
	
	
	return span;
}
function setAllowed()
{
	var info = {};
	
	var coursesPicks = getPickedIds("COURSES")
	info.CODE = actualAllowUser;
	info.COURSES = JSON.stringify(coursesPicks);
	info.LANG = lang;
	
	var limit = parseInt(document.getElementById("limitDaysSingle").value);
	if(limit == ""){limit = 15;}
	
	info.ASSIGNED = getNow().split(" ")[0];
	info.ASSIGNED_LIMIT = getNow(limit, "1")
	
	
	if(coursesPicks.length == 0)
	{
		info.ASSIGNED = "";
		info.ASSIGNED_LIMIT = "";
	}
	
		
	console.log(info)
	// return
	
	sendAjax("users","setUserAllowed",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		// return;
		
		alertBox(language["alert"], language["saved"], 300);
		
		listGet('users');
		document.getElementById("userMultiActions").value = "";
		hideModal("coursesSetModal");
		
	});
	
	
}
function setBundles()
{
	var info = {};
	
	var bundlePicks = getPickedIds("COURSES_BUNDLE")
	info.COURSES_BUNDLE = JSON.stringify(bundlePicks);
	info.CODE = actualBundleUser;
	info.LANG = lang;
	
	var limit = parseInt(document.getElementById("limitDaysBundle").value);
	if(limit == ""){limit = 15;}
	
	info.ASSIGNED = getNow().split(" ")[0];
	info.ASSIGNED_LIMIT = getNow(limit, "1")
	
	if(bundlePicks.length == 0)
	{
		info.ASSIGNED = "";
		info.ASSIGNED_LIMIT = "";
	}
	
	// console.log(info)
	
	sendAjax("users","setUserBundles",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		alertBox(language["alert"], language["saved"], 300);
		
		listGet('users');
		document.getElementById("userMultiActions").value = "";
		hideModal("bundleSetModal");
		
	});
	
}
function getcertFromLink(params)
{
	var data = params.split("*");
	
	var info = {};
	info.UCODE = data[0];
	info.COURSE = data[1];
	info.LANG = lang;
	info.LIMIT = passBase;
	
	
	console.log(info)
	
	sendAjax("users","getCert",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		
		if(ans == "new")
		{
			alertBox(language["alert"], language["newCert"], 300);
			return;
		}
		if(ans == "failed")
		{
			alertBox(language["alert"], language["failedCert"], 300);
			return;
		}
		if(ans == "expired")
		{
			alertBox(language["alert"], language["expiredCert"], 300);
			return;
		}


		
		var url = "certs/"+ans+".pdf";
		console.log(url)
		
		// downloadURI("data:text/pdf", url);
		window.open(url, '_blank');
		
	});
	
	
	
}
function getCoursesFromTrials(list)
{
	
	var added = []
	var filtered = [];
	
	for(var i=0; i<list.length; i++)
	{
		var trial = list[i];
		if(!added.includes(trial.COURSE))
		{
			added.push(trial.COURSE)
			var item = {}
			item.COURSE = trial.COURSE;
			item.PRESENTED = trial.PRESENTED;
			item.NAME = getCourseName(trial.COURSE);
			filtered.push(item)
		}
	}
	
	
	
	return filtered;
}
function getCourseName(code)
{
	var name = "-";
	
	for(var m=0; m<masterCourses.length; m++)
	{
		var master = masterCourses[m];
		if(code == master.CODE)
		{
			name = master["CNAME_"+lang];
			break;
		}
	}

	return name;

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
function cellCreatorL(name, content, espAlign)
{
	var cell = document.createElement("div");
	cell.className = "column";
	
	// SPECIAL ALIGN
	if(espAlign != null){cell.style.textAlign = espAlign;}
	
	// console.log(name);
	
	cell.setAttribute('data-label',name);
	var expansive = createExpansive(decodeURIComponent(content));
	cell.appendChild(expansive);
	return cell;
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









// ------------------------------UTILS
// ------------------------------UTILS
// ------------------------------UTILS
// ------------------------------UTILS
function shuffle(array) 
{
  let currentIndex = array.length,  randomIndex;

  // While there remain elements to shuffle.
  while (currentIndex != 0) {

    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex], array[currentIndex]];
  }

  return array;
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
		document.getElementById("alertBoxBox").style.maxWidth  = "400px";
	}

	$("#alertsBox").modal("show");
}
function showModal(id, width)
{
	$("#"+id).modal("show");
	
	if(width != null)
	{
		document.getElementById("modalBoxBig").style.maxWidth  = width+"px";
	}
	
}
function confirmBox(title, question, method, params, width)
{
	var box = document.getElementById("confirmModal");
	var titleSpan = document.getElementById("confirmModalLabel");
	var questionSpan = document.getElementById("confirmQuestion");
	var button = document.getElementById("confirmButton");
	
	titleSpan.innerHTML = title;
	questionSpan.innerHTML = question
	button.onclick = function (){method(params);}
	
	if(width != null)
	{
		document.getElementById("modalBox").style.maxWidth  = width+"px";
	}
	else
	{
		document.getElementById("modalBox").style.maxWidth  = "400px";
	}
	
	showModal("confirmModal");
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
	
	if(mail == "")
	{
		alertBox(language["alert"], infoIcon+language["mustUser"]); return;
	}
	

	sendAjax("users","mailExist",info,function(response)
	{
		var ans = response.message;
		console.log(ans)
		if(ans == "notsent")
		{
			alertBox(language["alert"], infoIcon+language["norRmail"]);
		}
		else
		{
			alertBox(language["alert"], infoIcon+language["mailRecSent"]);
			hideModal("pssRecModal");
		}
	});
	
}
function checkEmail(email) 
{
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email)){return false;}
	else{return true;}
 }
function selectFiller(id, initial, options, valueField, descField)
{
	var picker = document.getElementById(id);
	picker.innerHTML = "";
	
	var option = document.createElement("option");
	option.value = "";
	option.innerHTML = initial;
	picker.appendChild(option);
	
	for(var i=0; i<options.length; i++)
	{
		var item = options[i];
		if(valueField != null)
		{
			var value = item[valueField];
			var desc = item[descField];
		}
		else
		{
			var value = item;
			var desc = item;
		}
		
		var option = document.createElement("option");
		option.value = value;
		option.innerHTML = desc;
		picker.appendChild(option);
	}
}

function sendAjax(obj, method, data, responseFunction, noLoader, asValue)
{
	showLoader = 1;
	console.log(method);
	if(!noLoader)
	{
	setTimeout(function()
	{if(showLoader == 1){$("#loaderDiv").fadeIn();}},1000);}

	var info = {};
	info.class = obj;
	info.method = method;
	info.data = data;
	 
	curl = 'libs/php/mentry.php';
	
	if(imfoo == "contact")
	{
		curl = 'app/libs/php/mentry.php';
	}
	
	if(loginTo == "1")
	{
		curl = '../app2/libs/php/mentry.php';
	}
	
	// console.log(curl)

	 
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











// ------------------------------DELETE
// ------------------------------DELETE
// ------------------------------DELETE
// ------------------------------DELETE
// ------------------------------DELETE





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


// SPECIAL METHODS START ----------------------------

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
function getdDiffMin(startDate, endDate) 
{
	var date1 = new Date(startDate);
	var date2 = new Date(endDate);
	var timeDiff = date2.getTime() - date1.getTime();
	
	// console.log(timeDiff)
	
	
	var diffDays = Math.ceil(timeDiff / 1000 / 60) ; 
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