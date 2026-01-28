<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head

openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');
recordUserVisit();
?>
<!DOCTYPE html>
<html lang="en">
    <head>

	<link rel='canonical' href='https://hogwild.uk' />
	<?php echo $standard_header_content ?>
	<title>Home of The Wild Hogs</title>
	
	<style>
	 :root {
	     --beige-pale: #F7F6D8;
	     --beige-dark: #C4C19B;
	     --blue: #069;
	 }
	 body {
	     overflow: hidden;
	     position: relative;
	     height: 100vh;
	     margin: 0;
	     background-image: url('images/map/the-wilderness.png');
	     background-color: var(--beige-dark);
	     font-family: Melodica;
	 }
	 input[type="checkbox"]{
	     scale: 1.5;
	 }
	 .blue {
	     color: var(--blue);
	 }
	</style>
    </head>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'G-6BQYQMEP06');
    </script>
    
    <body>
	<img id="target" src="images/map/target.png">
	<div id="map" draggable="false">
	    <div id="map-background"></div>
	    <div class="map-item" id="the-bomb"><img src="images/map/the-bomb.png"></div>
	    <div class="map-item" id="cherokee-1"><img src="images/map/cherokee-1.png"></div>
	    <a class="map-item" id="ol-dusty">
		<img src="images/map/ol-dusty.png">
		<span style="left: -10px; top: -10px">Ol' Dusty</span>
	    </a>
	    <div class="map-item" id="the-cottage">
		<img src="images/map/the-cottage.png">
	    </div>
	    <div class="map-item" id="path-1">
		<img src="images/map/path-1.png">
	    </div>
	    <div class="map-item" id="path-2">
		<img src="images/map/path-2.png">
	    </div>
	    <a class="map-item" id="music-shop" href="https://notoalgorithms.hogwild.uk">
		<img src="images/map/music-shop.png">
		<span style="top: 38px; left: -5px; text-align: center">Music Shop<br><span class="blue">No To Algorithms!</span></span>
		<img src="images/map/note.gif" style="width: unset; position: absolute; left: 20px; top: -10px;">
	    </a>
	    <a class="map-item" id="tinsel-town-tavern">
		<img src="images/map/tinsel-town-tavern.png">
		<span style="top: 52px; left: 20px">Triple T</span>
		<img src="images/map/smoke.gif" style="width: unset; position: absolute; left: 41px; top: -10px;">
	    </a>
	    <a class="map-item" id="it-suite" href="https://wiki.hogwild.uk">
		<img src="images/map/it-suite.png">
		<span style="top: -10px; left: 20px">Internet Cafe<br><span class="blue">Hogipedia</span></span>
		<img src="images/map/wifi.gif" style="width: unset; position: absolute; left: 5px; top: -8px;">
	    </a>
	    <a class="map-item" id="thompson-world" href="https://tw.hogwild.uk">
		<img src="images/map/thompson-world.png">
		<span class="blue" style="top: 5px; left: 30px">Thompson<br>World</span>
	    </a>
	    <a class="map-item" id="casino" href="https://hogwild.uk/nothingeverhappens">
		<img src="images/map/casino.png">
		<span style="top: -5px; left: -55px; text-align: right">Casino<br><span class="blue">Nothing<br>Ever Happens</span></span>
	    </a>
	    <a class="map-item" id="bunker-hill">Bunker Hill</a>
	    <a class="map-item" id="russel">Russel</a>
	    <a class="map-item" id="hoisington">Hoisington</a>
	    <a class="map-item" id="great-bend">Great Bend</a>
	    <a class="map-item" id="firehouse" style="display: none">
		<span style="top: -10px; left: 10px">Firehouse</span>
		<img src="images/map/firehouse.png">
	    </a>
	    <a class="map-item" id="the-baths" href="https://fishing.hogwild.uk">
		<img src="images/map/the-baths.png">
		<span style="top: 0px; left: -50px; text-align: right">The Baths<br><span class="blue">Hook-A-Duck</span></span>
		<img src="images/map/bubble.gif" style="width: unset; position: absolute; left: 30px; top: 10px;">
		<img src="images/map/wisp.gif" style="width: unset; position: absolute; left: 25px; top: 15px;">
		<img src="images/map/wisp.gif" style="width: unset; position: absolute; left: 10px; top: 0px;">		
	    </a>
	    <a class="map-item" id="corner-shop" href="https://hogwild.uk/mealdeal">
		<img src="images/map/corner-shop.png">
		<span style="top: 0px; left: 30px">Corner Shop<br><span class="blue">Meal Deal Maker</span></span>
	    </a>
	    <div class="map-item" id="radio-tower">
		<span style="top: -20px; left: 10px">Radio<br>Tower</span>
		<img src="images/map/radio-tower.png">
		<img src="images/map/radio-wave.gif" style="width: unset; position: absolute; left: 35px; top: 0px;">
	    </div>
	    <a class="map-item" id="lady-garden-lake">
		<span style="top: 80px; left: 150px">Lady Garden Lake</span>
		<img src="images/map/lady-garden-lake.png">
	    </a>
	    <div class="map-item map-link" id="valve" href="https://valve.hogwild.uk">
		<img src="images/map/valve.png">
		<img src="images/map/valve-splash.gif" style="width: unset; position: absolute; left: -7px; top: -4px">
		<span class="blue" style="top: -23px; left: -15px; text-align: center">The Valve<br>That Failed</span>
	    </div>
	    <a class="map-item" id="the-swamp">
		<img src="images/map/the-swamp.png">
		<span style="left: 50px">The<br>Swamp</span>
	    </a>
	    <a class="map-item" id="the-shack" href="https://wiki.hogwild.uk?page=the-swamp">
		<span style="top: -12px">The Shack</span>
		<img src="images/map/the-shack.png">
		<img src="images/map/smoke.gif" style="width: unset; position: absolute; left: 21px; top: -50px;">
	    </a>
	    <a class="map-item" id="the-ranch">
		<img src="images/map/the-ranch.png">
		<span style="left: 0px; top: -15px; text-align: right">The<br>Ranch</span>
		<img src="images/map/smoke.gif" style="width: unset; position: absolute; left: 26px; top: -50px;">
	    </a>
	</div>
	<div id="controls">
	    <div>
		<a href="https://hogwild.uk/what?" style="color: var(--blue); text-decoration: none">?</a>
	    </div>
	    <div>
		<label for="checkbox-snapping">Snap</label>
		<input id="checkbox-snapping" class="js-checkbox" type="checkbox">
	    </div>
	    <div>
		<label for="checkbox-zoom">2x</label>
		<input id="checkbox-zoom" class="js-checkbox" type="checkbox">
	    </div>
	</div>
	
    </body>

    <script>
     var snapping = false; // If off the user can scroll freely, if on on mouseup the map will jump the target (middle) to the closest map-link element (not just map-item)
     var real_mouse_position = [0,0]; // Current mouse position
     var start_drag_position = [0,0]; // Position of mouse when starting to drag the map
     var dragging = false; // Currently dragging the map?
     var map; // Map element
     var half_map_width; // Pixel value of half the map width
     var half_map_height; // Pixel value of half the map height
     var target; // Target (cursor) element
     var zoom = false;
     var zoom_scale = 1;

     const map_positions = { // Pixel positions of elements with 0,0 being the centre of the screen and positive Y values being further *down* the screen
	 'tinsel-town-tavern': [0, 0], // Element ID: [x, y]
			     'it-suite': [30, -80],
			     'the-cottage': [80, -30],
			     'the-bomb': [100, 30],
			     'cherokee-1': [-65, -65],
			     'thompson-world': [-225, -160],
			     'music-shop': [10, 195],
			     'bunker-hill': [150, -870],
			     'hoisington': [-50, 700],
			     'great-bend': [-40, 800],
			     'russel': [-50, -900],
			     //'firehouse': [180, -30],
			     'corner-shop': [-35, 135],
			     'the-swamp': [420, -400],
			     'the-shack': [380, -460],
			     'lady-garden-lake': [200, -350],
			     'valve': [200, -432],
			     'ol-dusty': [-110, -20],
			     'the-ranch': [-480, -30],
			     'radio-tower': [-395, -155],
			     'casino': [-70, 190],
			     'path-1': [-70, 120],
			     'path-2': [-300, -150],
			     'the-baths': [-200, -300]
     };

     // Mathematical Functions
     function distanceBetweenCoords(x1, y1, x2, y2){
	 return Math.abs(Math.sqrt(((x2 - x1)**2) + ((y2 - y1)**2))); // Absolute distance to allow for easy comparison regardless of direction
     }
     function findNearestLink(){ // Return ID of the nearest map-link (class) element to the middle of the screen
	 x1 = document.body.clientWidth / 2;
	 y1 = document.body.clientHeight / 2;
	 var smallest_distance = 99999; // Set really high so that the first distance will override
	 for (var place in map_positions){ // For each ID (key) in the map positions array
	     if (document.getElementById(place).classList.contains('map-link')){ // If the element is a map-link (not just a map-item)
		 x2 = parseInt(map.style.left) + half_map_width + (map_positions[place][0] * zoom_scale); // Get the location of the element
		 y2 = parseInt(map.style.top) + half_map_height + (map_positions[place][1] * zoom_scale);
		 distance = distanceBetweenCoords(x1, y1, x2, y2); // Work out the distance from the target (middle of screen) to the element
		 if (distance < smallest_distance){ // If it's closer than any previous element
		     smallest_distance = distance; // Set the distance for comparison to other elements
		     nearest_link = place; // Set the ID to return if it ends up being the closest
		 }
	     }
	 }
	 return nearest_link; // Return the ID of the nearest link to the middle of the screen
     }

     // Mouse Functions
     function startDrag(event){
	 dragging = true; // Currently dragging
	 target.style.filter = 'opacity(1)'; // Show the target/cursor
	 if (event.type.startsWith('touch')) { // If on mobile use a slightly different way of getting the cursor position
	     start_drag_position = [event.touches[0].pageX - parseInt(map.style.left), event.touches[0].pageY - parseInt(map.style.top)];
	 } else { // On desktop get the cursor position
	     start_drag_position = [real_mouse_position[0] - parseInt(map.style.left), real_mouse_position[1] - parseInt(map.style.top)];
	 }
     }
     function endDrag(event){
	 dragging = false; // Not dragging anymore
	 target.style.filter = 'opacity(0)'; // Hide the target/cursor
	 updateSnappedLocation();
     }
     function updateMapPosition(){ // Move the map based on the current cursor position while dragging
	 map.style.left = (real_mouse_position[0] - start_drag_position[0]) + 'px';
	 map.style.top = (real_mouse_position[1] - start_drag_position[1]) + 'px';
     }
     function updateRealMousePosition(event){
	 if (event.type.startsWith('touch')) { // If on mobile work out the mouse position slightly differently
	     real_mouse_position = [event.touches[0].pageX, event.touches[0].pageY];
	 } else { // Get mouse position on desktop
	     real_mouse_position = [event.pageX, event.pageY];
	 }
	 if (dragging == true){
	     updateMapPosition(); // Move the map if currently dragging
	 }
     }
     function handleLinkClick(event){
	 if (distanceBetweenCoords(...start_drag_position, event.pageX - parseInt(map.style.left), event.pageY - parseInt(map.style.top)) > 5){
	     return false; // Don't open the link if the mouse has moved more than 5px from the element (at the end of a drag rather than a deliberate click)
	 }
     }

     // Control Functions
     function updateControlVariable(event){ // Update a variable that's linked to a checkbox
	 related_bool = event.target.id.replace('checkbox-',''); // Get the string of the variable name
	 window[related_bool] = event.target.checked; // Update the actual variable
	 updateSnappedLocation(); // Update snapped location in case snapping just turned on and needs to snap to closest
	 updateZoom(); // Update zoom in case zoom just turned on/off
     }

     // Map Movement Functions
     function updateZoom(){
	 if (zoom){
	     zoom_scale = 2;
	     map.style.transform = 'scale('+zoom_scale+')';
	 } else {
	     zoom_scale = 1;
	     map.style.transform = '';
	 }
	 updateSnappedLocation();
     }
     function updateSnappedLocation(){
	 if (snapping){ // Only snap to nearest if snapping is on
	     snapToNearestLink();
	 }
     }
     function snapToNearestLink(){
	 nearest_link = findNearestLink(); // Find the ID of the nearest map-link to the target/cursor
	 focusMapCoordinates(...map_positions[nearest_link]); // Move the map to make the closest element in the middle of the screen
	 window.setTimeout(() => document.getElementById(nearest_link).focus(), 0); // Focus the element
     }
     function focusMapCoordinates(x, y){
	 if (snapping){ // If the map should snap to the closest map-link
	     map.style.transition = 'top 0.2s, left 0.2s'; // Add a transition so it looks smoother
	     setTimeout(() => { map.style.transition = ''; }, 200); // Remove the transition the instant it ends
	 }
	 map.style.left = ((document.body.clientWidth / 2) - half_map_width - (x * zoom_scale)) + 'px'; // Move the map to the coordinates
	 map.style.top = ((document.body.clientHeight / 2) - half_map_height - (y * zoom_scale)) + 'px';
     }
     
     // Map Initialisation Functions
     function placeMapItem(item,x,y){ // Position a map-item according to set coordinates with origin in the middle of the screen
	 item.style.left = (x + half_map_width) + 'px';
	 item.style.top = (y + half_map_height) + 'px';
     }
     function initialiseMapItems(){
	 for (var place in map_positions){ // For every element ID in the array
	     const location_element = document.getElementById(place); // Get the corresponding element
	     placeMapItem(location_element, map_positions[place][0], map_positions[place][1]); // Position the element according to its coordinates
	 }
     }
     function initialiseChildren(){
	 Array.from(map.querySelectorAll('*')).forEach(child => { // For all children including sub-children
	     child.setAttribute('draggable', false); // Make them non-draggable to stop weird visual stuff as dragging is custom
	 });
	 Array.from(map.querySelectorAll('a')).forEach(child => { // Only direct children
	     if (!child.getAttribute('href')){ // If href isn't set then it should be a default wiki link
		 child.setAttribute('href', 'https://wiki.hogwild.uk?page='+child.id); // Add the default wiki link
	     }
	     child.onclick = handleLinkClick; // Override the normal click to prevent weird link clicking when dragging
	     child.classList.add('map-link'); // Add map-link class
	     child.setAttribute('tabindex', 0); // Allow them to be focused
	 });
     }
     function initialiseControls(){
	 Array.from(document.querySelectorAll('.js-checkbox')).forEach(child => { // Only direct children	     
	     child.addEventListener('change', updateControlVariable)
	 });
     }
     
     // Page Initialisation
     window.onload = function(){
	 map = document.getElementById('map');
	 target = document.getElementById('target');
	 half_map_width = map.offsetWidth / 2;
	 half_map_height = map.offsetHeight / 2;
	 initialiseMapItems();
	 map.addEventListener('mousedown', startDrag);
	 map.addEventListener('touchstart', startDrag);
	 document.addEventListener('mouseup', endDrag);
	 document.addEventListener('touchend', endDrag);
	 document.addEventListener('mousemove', updateRealMousePosition);
	 document.addEventListener('touchmove', updateRealMousePosition);
	 initialiseChildren();
	 initialiseControls();
	 focusMapCoordinates(0,0);
     };
    </script>
</html>
