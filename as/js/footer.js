function getWindowHeight() {
	var windowHeight = 0;
	if (typeof(window.innerHeight) == 'number') {
		windowHeight = window.innerHeight;
	}
	else {
		if (document.documentElement && document.documentElement.clientHeight) {
			windowHeight = document.documentElement.clientHeight;
		}
		else {
			if (document.body && document.body.clientHeight) {
				windowHeight = document.body.clientHeight;
			}
		}
	}
	return windowHeight;
}


function setFooter() {
	if (document.getElementById) {
		var windowHeight = getWindowHeight();
		if (windowHeight > 0) {
			var contentHeight = document.getElementById('wrapper').offsetHeight;
			var need = windowHeight - contentHeight;
			if (need > 0) {
				document.getElementById('footer').style.marginTop = (30+need) + 'px';
			}
		}
	}
}

/*
window.onload = function() {
	setFooter();
}
*/

function addLoadEvent(func)
{
	var oldonload = window.onload;
	if(typeof window.onload != 'function')
	{
		window.onload = func;
	}
	else
	{
		window.onload = function()
		{
			oldonload();
			func();
		}
	}
}

addLoadEvent(setFooter);

/*
window.onresize = function() {
	setFooter();
}
*/