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
