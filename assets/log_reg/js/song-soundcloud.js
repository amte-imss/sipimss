/*
http://codepen.io/ge1doot/pen/RPdazv
<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/215002139&amp;color=ff5500&amp;auto_play=true&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>
*/
! function() {
	"use strict";
	function txtTyper () {
		if ( idx <= str.length) {
			if (str.charAt(idx) == '<') {
				while (str.charAt(idx) != '>' || str.charAt(idx+1) == '<') idx++;
				idx++
			}
			if (str.charAt(idx) == '&' && str.charAt(idx+1) != ' ') {
				while (str.charAt(idx) != ';') idx++; 
				idx++;
			}
			var tmp0 = str.slice(0,idx);
			var tmp1 = str.charAt(idx++);
			idObj.innerHTML = '<span class="c1">'+tmp0+'</span><span class="c2">'+tmp1+'_</span>';
			if (idx < str.length) {
				setTimeout(function () {
					txtTyper();
				}, 120);
			} else {
				sound = false;
			}
		}
	}
	var str = "<br>---- beginning of transmission ----<br><br>Who bears the greater blame<br>for the encroachment of tyranny:<br><br>those who plan to smother our freedoms tomorrow,<br>or those who act to smother our questions today?<br><br>---- end of transmission ----<br> <br> <br>";
	var sound = true;
	var idx = 0;
	var idObj = document.getElementById('ttl0');
	if (window.Audio) {
		var notlogical = new Audio('sound/');
		notlogical.addEventListener('ended', function() {
			this.currentTime = 0;
			if (sound) this.play();
	}, false);
notlogical.play();
	}
 	txtTyper();
}();