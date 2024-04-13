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
	centererPop(modalArea);
}
function confirmBox(title,content,method,wide,param)
{
	var modal = document.getElementById("box");
	modal.className = "modalCover";
	modal.style.display = "block";
	var modalTitle =  document.getElementById("boxTitle");
	modalTitle.innerHTML = title;
	var modalArea = document.getElementById("modalBox");
	var contentDiv = document.getElementById("boxContent");

	modalArea.style.maxWidth  = wide+"px";

	var aceptb = document.createElement("button");
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

	centererPop(modalArea);
}
function alertBox(title,content,wide,aTxt)
{
	var modal = document.getElementById("box");

	modal.className = "modalCover";
	modal.style.display = "block";
        
	var modalTitle =  document.getElementById("boxTitle");
	modalTitle.innerHTML = title;
	var modalArea = document.getElementById("modalBox");
	var contentDiv = document.getElementById("boxContent");
	contentDiv.innerHTML = "";

	modalArea.style.maxWidth  = wide+"px";

	var aceptb = document.createElement("button");
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
	
	centererPop(modalArea);
}
function hide_pop_form()
{
	var modal = document.getElementById("modalCover");
	$("#modalCover").fadeOut(100);
}
function hide_pop()
{
	var modal = document.getElementById("box");
	modal.style.display = "none";
	document.getElementById("boxContent").innerHTML = "";
}
function centererPop(item)
{
	var box = item;
	var boxHeight =item.offsetHeight;
	var papa = item.parentNode;
	var papaHeight =papa.offsetHeight;
	
	var extraTop = (papaHeight/25)/2;
	var marginTop = (papaHeight/2) - (boxHeight/2) - extraTop;
	
	if(aud != null)
	{
		if(marginTop < 40)
		{
			marginTop = 40;
		}
	}
	else
	{
		if(marginTop < 0)
		{
			marginTop = 0;
		}
	}
	
	
	item.style.marginTop = marginTop+"px";
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
