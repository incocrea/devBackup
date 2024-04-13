
alertIsOpen = 0;
formIsOpen = 0;

function formBox(content, title, wide)
{
	var modal = document.getElementById("modalCover");
	modal.className = "modalCoverForm";
	$("#modalCover").fadeIn(100);
	modal.style.display = "block";
	var modalTitle =  document.getElementById("modalTitle");
	modalTitle.innerHTML = title;
	var modalSubTitle =  document.getElementById("modalSubTitle");
	var modalArea = document.getElementById("modal");
	var modalContainer = document.getElementById("modalContent");
	var modalContent = document.getElementById(content);

	var elemCount = modalContainer.children.length;
	
	if (elemCount > 0) {
		for (i=0; i < 1; i++) {
			document.getElementById("hidden").appendChild(modalContainer.children[i]);
		}
	}

	modalContainer.appendChild(modalContent);
	modalArea.style.maxWidth  = wide+"px";
	modalArea.style.height  = "initial";
	
	centererPop(modalArea);
	
	modalArea.style.backgroundImage = "url('irsc/mainBGB.png";
	modalArea.style.backgroundSize ="auto auto";
	
	
	formIsOpen = 1;
}
function confirmBox(title,content,method,wide,param)
{
	var modal = document.getElementById("box");
	modal.className = "modalCoverForm topModal";
	modal.style.display = "block";
	var modalTitle =  document.getElementById("boxTitle");
	modalTitle.innerHTML = title;
	var modalArea = document.getElementById("modalBox");
	var contentDiv = document.getElementById("boxContent");

	modalArea.style.maxWidth  = wide+"px";
	modalArea.style.height  = "initial";

	var aceptb = document.createElement("button");
	aceptb.id = "alertAccept";
	aceptb.innerHTML = language["accept"];
        
        if(param != "none")
        {
                aceptb.onclick = function(e){hide_pop(); method(param);};
        }
        else
        {
                aceptb.onclick = function(e){hide_pop(); method();};
        }

	var cancelb = document.createElement("button");
	cancelb.innerHTML = language["cancel"];
	cancelb.className = "separatedButton";
	cancelb.onclick = hide_pop;

	contentDiv.innerHTML = content;

	var buttonDiv = document.createElement("div");
	buttonDiv.className = "modalButtons";
	buttonDiv.id = "mebutDiv";
	buttonDiv.innerHTML = "";
	buttonDiv.appendChild(aceptb);
	buttonDiv.appendChild(cancelb);
	contentDiv.appendChild(buttonDiv);
	
	centererPopA(modalArea);
	
	
	alertIsOpen = 1;
}
function alertBox(title,content,wide,aTxt)
{
	var modal = document.getElementById("box");
	modal.className = "modalCoverForm topModal";
	modal.style.display = "block";
	
	var modalTitle =  document.getElementById("boxTitle");
	modalTitle.innerHTML = title;
	var modalArea = document.getElementById("modalBox");
	var contentDiv = document.getElementById("boxContent");
	contentDiv.innerHTML = "";

	modalArea.style.maxWidth  = wide+"px";
	modalArea.style.height  = "initial";

	var aceptb = document.createElement("button");
	aceptb.id = "alertAccept";
	aceptb.onclick = hide_pop;

	if(aTxt == null)
	{
		aceptb.innerHTML = language["accept"];
	}
	else
	{
		aceptb.innerHTML = aTxt;
	}

	contentDiv.innerHTML = content;

	var buttonDiv = document.createElement("div");
	buttonDiv.className = "modalButtons";
	buttonDiv.innerHTML = "";
	buttonDiv.appendChild(aceptb);
	contentDiv.appendChild(buttonDiv);
	
	aceptb.focus();
	
	centererPopA(modalArea);
	
	alertIsOpen = 1;
	
}
function centererPop(item)
{
	var box = item;
	var boxHeight = item.offsetHeight;
	var papa = item.parentNode;
	var papaHeight =papa.offsetHeight;
	
	var extraTop = (papaHeight/25)/2;
	var marginTop = (papaHeight/2) - (boxHeight/2) - extraTop+10;
	
	item.style.marginTop = marginTop+"px";
	
	var popParentWidth = $("#modalCover").width();
	
	var cB = document.getElementById("closeB");
	var cBright = (popParentWidth/2)-(box.clientWidth/2)-4;
	cB.style.right = cBright-5+"px";
	cB.style.top = marginTop-5+"px";

}
function centererPopA(item)
{
	var box = item;
	var boxHeight =item.offsetHeight;
	var papa = item.parentNode;
	var papaHeight =papa.offsetHeight;
	
	var extraTop = (papaHeight/25)/2;
	var marginTop = (papaHeight/2) - (boxHeight/2) - extraTop;
	item.style.marginTop = marginTop+"px";
	
	var popParentWidth = $("#box").width();
	
	var cB = document.getElementById("closeBa");
	var cBright = (popParentWidth/2)-(box.clientWidth/2)-5;
	cB.style.right = cBright-5+"px";
	cB.style.top = marginTop-5+"px";

}
function centerer(item)
{
	var box = item;
	var boxHeight =item.offsetHeight;
	var papa = item.parentNode;
	var papaHeight =papa.offsetHeight;
	
	var marginTop = (papaHeight/2) - (boxHeight/2);
	
	if(marginTop < 0)
	{
			marginTop = 0;
	}
        
	marginTop = 0;
        
	item.style.marginTop = marginTop+"px";
	
}
function centererLogin(item)
{
	var box = item;
	var boxHeight =item.offsetHeight;
	var papa = item.parentNode;
	var papaHeight =papa.offsetHeight;
	
	var marginTop = (papaHeight/2) - (boxHeight/2);
	
	if(marginTop < 0)
        {
                marginTop = 0;
        }
        
	item.style.marginTop = marginTop+"px";
}
function hide_pop_form()
{
	var modal = document.getElementById("modalCover");
	$("#modalCover").fadeOut(100);
	
	saveDateState = "0";
	console.log(saveDateState)
	
	if(videoPromoRuning == 1)
	{
		videoPromoRuning = 0;
		hidePromoPop();
	}
	
	if(formIsOpen == 1 || alertIsOpen == 1);
	{
		formIsOpen = 0;
		return;
	}
	
	// if(demoShowcase == "1")
	// {
		// document.getElementById("showBox").style.display = "none";
	// }
	
	formIsOpen = 0;
	
	
	
}
function hide_pop()
{
	var modal = document.getElementById("box");
	modal.style.display = "none";
	document.getElementById("boxContent").innerHTML = "";
	
	if(alertIsOpen == 1 || formIsOpen == 1)
	{
		alertIsOpen = 0;
		return;
	}
	
	// if(demoShowcase == "1")
	// {
		// document.getElementById("showBox").style.display = "none";
	// }
	
	alertIsOpen = 0;

}