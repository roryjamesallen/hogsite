<!DOCTYPE html>
<html lang="en">
    <head>
	<meta name="viewport" content="width=device-width, maximum-scale=1.0" />
	<title>Map</title>
	<style>
	 @font-face {
	     font-family: Melodica;
	     src: url(../fonts/Melodica.otf);
	 }
	 :root {
	     --beige-pale: #F7F6D8;
	     --beige-dark: #C4C19B;
	 }
	 body {
	     overflow: hidden;
	     position: relative;
	     height: 100vh;
	     margin: 0;
	     background-image: url('images/the-wilderness.png');
	     background-color: var(--beige-dark);
	     font-family: Melodica;
	 }
	 #map {
	     position: fixed;
	     width: fit-content;
	     height: fit-content;
	 }
	 #map-background {
	     width: 2500px;
	     height: 1500px;
	     background-image: url('images/tile.png');
	     background-color: var(--beige-pale);
	 }
	 .map-item {
	     position: absolute;
	     transform: scale(2) translate(-25%, -25%);
	     transform-origin: center;
	     transition: transform 0.2s;
	     font-size: 10px;
	     color: black;
	     text-decoration: none;
	 }
	 .map-item > span {
	     position: absolute;
	     white-space: nowrap;
	 }
	 .map-item > img {
	     width: 100%;
	     image-rendering: pixelated;
	 }
	 .map-link:hover, .map-link:hover span, .map-link:focus, .map-link:focus span {
	     cursor: pointer;
	     /*transform: scale(1.2) translate(-40%, -40%);*/
	     border: none;
	     outline: none;
	     text-decoration: underline;
	 }
	 #target {
	     position: absolute;
	     left: 50%;
	     top: 50%;
	     transform: scale(2) translate(-25%, -25%);
	     image-rendering: pixelated;
	     z-index: 99;
	     filter: opacity(0);
	     transition: filter 0.2s;
	     pointer-events: none;
	 }
	 #controls {
	     position: absolute;
	     top: 5px;
	     right: 5px;
	     display: flex;
	     align-items: center;
	     gap: 5px;
	     font-size: 30px;
	 }
	 input[type="checkbox"]{
	     scale: 1.5;
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
	<img id="target" src="images/target.png">
	<div id="map" draggable="false">
	    <div id="map-background"></div>
	    <div class="map-item" id="the-bomb"><img src="images/the-bomb.png"></div>
	    <a class="map-item" id="ol-dusty">
		<img src="images/ol-dusty.png">
		<span style="left: -10px; top: -10px">Ol' Dusty</span>
	    </a>
	    <a class="map-item" id="tinsel-town-tavern">
		<img src="images/tinsel-town-tavern.png">
		<span style="top: 50px; left: 20px">Tinsel Town Tavern</span>
	    </a>
	    <a class="map-item" id="bunker-hill">Bunker Hill</a>
	    <a class="map-item" id="russel">Russel</a>
	    <a class="map-item" id="firehouse">Firehouse</a>
	    <a class="map-item" id="lady-garden-lake">
		<span style="top: 80px; left: 150px">Lady Garden Lake</span>
		<img src="images/lady-garden-lake.png">
	    </a>
	    <a class="map-item" id="the-swamp">
		<img src="images/the-swamp.png">
		<span style="left: 50px">The<br>Swamp</span>
	    </a>
	    <a class="map-item" id="the-shack">
		<span style="top: -12px">The Shack</span>
		<img src="images/the-shack.png">
	    </a>
	</div>
	<div id="controls">
	    <label for="checkbox-snapping">SNAP</label>
	    <input id="checkbox-snapping" class="js-checkbox" type="checkbox" checked="true">
	</div>
	
    </body>

    <script>
     var snapping = true; // If off the user can scroll freely, if on on mouseup the map will jump the target (middle) to the closest map-link element (not just map-item)
     var real_mouse_position = [0,0]; // Current mouse position
     var start_drag_position = [0,0]; // Position of mouse when starting to drag the map
     var dragging = false; // Currently dragging the map?
     var map; // Map element
     var half_map_width; // Pixel value of half the map width
     var half_map_height; // Pixel value of half the map height
     var target; // Target (cursor) element

     const map_positions = { // Pixel positions of elements with 0,0 being the centre of the screen and positive Y values being further *down* the screen
	 'tinsel-town-tavern': [0, 0], // Element ID: [x, y]
			     'the-bomb': [100, 30],
			     'bunker-hill': [-50, -500],
			     'russel': [300, 450],
			     'firehouse': [-100, -200],
			     'the-swamp': [420, -400],
			     'the-shack': [380, -460],
			     'lady-garden-lake': [200, -350],
			     'ol-dusty': [-110, -20]
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
		 x2 = parseInt(map.style.left) + half_map_width + map_positions[place][0]; // Get the location of the element
		 y2 = parseInt(map.style.top) + half_map_height + map_positions[place][1];
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
     }

     // Map Movement Functions
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
	 map.style.left = ((document.body.clientWidth / 2) - half_map_width - x) + 'px'; // Move the map to the coordinates
	 map.style.top = ((document.body.clientHeight / 2) - half_map_height - y) + 'px';
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
