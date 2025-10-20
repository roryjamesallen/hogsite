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
