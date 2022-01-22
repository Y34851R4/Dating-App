var i=-10;
	document.addEventListener("mouseover",function(ev) {
		if(ev.target.tagName == "SPAN") {
			i*=-1;
			ev.target.style.cssText = "color: yellow;display: inline-block; transform: rotate("+i+"deg);";
		}
		if(ev.target.className=="sugi")
		{
			ev.target.style.cssText ="border:1px solid blue;";
		}
	})
	document.addEventListener("mouseout",function(ev) {
		if(ev.target.tagName == "SPAN") {
			ev.target.style.cssText = "color: white;display: inline-block; transform: rotate(0deg);";
		}
		if(ev.target.className=="sugi")
		{
			ev.target.style.cssText ="border:0.5px solid white;";
		}
	})
