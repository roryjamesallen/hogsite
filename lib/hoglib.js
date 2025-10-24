// Image that loops through frames
export function start_image_loop(image_id_prefix, limit, delay){
    var i = 1;
    function increment_image() {
	if(i <= limit) {
	    setTimeout(function(){
		for (let i=1; i<=limit; i++) { 
		    var image_id = image_id_prefix + i;
		    document.getElementById(image_id).style.display = 'none';
		}
		var image_id = image_id_prefix + i;
		document.getElementById(image_id).style.display = 'block';
		i++;
		increment_image();
	    }, delay);
	} else {
	    i = 1;
	    increment_image();
	}
    }
    increment_image();
}

// Cookies
export function createCookie(name,value,days) {
    if (days) {
	var date = new Date();
	date.setTime(date.getTime()+(days*24*60*60*1000));
	var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}
export function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
	var c = ca[i];
	while (c.charAt(0)==' ') c = c.substring(1,c.length);
	if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

// Flippable elements (show/hide with toggle element(s))
function setFlipperOnclicks(flipper_ids, flip_function){
	for (let element_id of flipper_ids){
		var element = document.getElementById(element_id);
		if (element != null){
			element.addEventListener('click', flip_function);
		}
	}
}
export function initialiseFlippableElements(element_ids, flipper_ids, flip_function){
	var main_id = element_ids[0];
    var old_state = readCookie(main_id+'-display');
    if (old_state == null){
	old_state = 'none';
    }
	setDisplayOfElements(element_ids, old_state);
	setFlipperOnclicks(flipper_ids, flip_function)
}
export function setDisplayOfElements(element_ids, state){
	for (let element_id of element_ids){
		var element = document.getElementById(element_id);
		if (element != null){
			element.style.display = state;
		}
	}
}
export function flipDisplayOfElements(element_ids){
	var main_id = element_ids[0];
    var current_state = document.getElementById(main_id).style.display;
    if (current_state == 'none'){
        var new_state = 'block';
    } else {
        var new_state = 'none';
    }
	createCookie(main_id+'-display', new_state, 1);
	setDisplayOfElements(element_ids, new_state);
}