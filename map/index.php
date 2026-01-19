<!DOCTYPE html>
<html lang="en">
    <head>
	<title>Map</title>
	<style>
	 :root {
	     --beige-pale: #F7F6D8;
	     --beige-dark: #C4C19B;
	 }
	 body {
	     overflow: hidden;
	     position: relative;
	     height: 100vh;
	     margin: 0;
	 }
	 #map {
	     position: fixed;
	     width: fit-content;
	     height: fit-content;
	 }
	 #map-background {
	 }
	 .map-item {
	     position: absolute;
	     background: grey;
	     color: white;
	     transform: translate(-50%, -50%);
	     transform-origin: center;
	     transition: transform 0.2s;
	 }
	 .map-link:hover {
	     cursor: pointer;
	     transform: scale(1.2) translate(-40%, -40%);
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
	<div id="map" draggable="false">
	    <img id="map-background" src="map.jpg" draggable="false">
	    <div class="map-item map-link" id="tinsel-town-tavern">Tinsel Town Tavern</div>
	    <div class="map-item map-link" id="bunker-hill">Bunker Hill</div>
	    <div class="map-item map-link" id="russel">Russel</div>
	    <div class="map-item map-link" id="firehouse">Firehouse</div>
	</div>
    </body>

    <script>
     var snapping = true;
     var real_mouse_position = [0,0];
     var start_drag_position = [0,0];
     var dragging = false;
     var map;
     var half_map_width;
     var half_map_height;

     const map_positions = {
	 'tinsel-town-tavern': [0, 0],
	 'bunker-hill': [-50, -500],
	 'russel': [300, 450],
	 'firehouse': [-100, -200]
     }

     // Mathematical Functions
     function distanceBetweenCoords(x1, y1, x2, y2){
	 return Math.abs(Math.sqrt(((x2 - x1)**2) + ((y2 - y1)**2)));
     }
     function findNearestLink(){
	 x1 = document.body.clientWidth / 2;
	 y1 = document.body.clientHeight / 2;
	 var smallest_distance = 99999;
	 var closest_coords = [0, 0];
	 for (var place in map_positions){
	     x2 = parseInt(map.style.left) + half_map_width + map_positions[place][0];
	     y2 = parseInt(map.style.top) + half_map_height + map_positions[place][1];
	     distance = distanceBetweenCoords(x1, y1, x2, y2);
	     if (distance < smallest_distance){
		 smallest_distance = distance;
		 closest_coords = map_positions[place];
	     }
	 }
	 return closest_coords;
     }

     // Mouse Functions
     function startDrag(){
	 dragging = true;
	 start_drag_position = [real_mouse_position[0] - parseInt(map.style.left), real_mouse_position[1] - parseInt(map.style.top)];
     }
     function endDrag(){
	 dragging = false;
	 coords = findNearestLink();
	 focusMapCoordinates(coords[0], coords[1]);
     }
     function updateMapPosition(){
	 map.style.left = (real_mouse_position[0] - start_drag_position[0]) + 'px';
	 map.style.top = (real_mouse_position[1] - start_drag_position[1]) + 'px';
     }
     function updateRealMousePosition(event){
	 real_mouse_position = [event.pageX, event.pageY];
	 if (dragging == true){
	     updateMapPosition();
	 }
     }

     // Map Movement Functions
     function findNearestLink(){
	 x1 = document.body.clientWidth / 2;
	 y1 = document.body.clientHeight / 2;
	 var smallest_distance = 99999;
	 var closest_coords = [0, 0];
	 for (var place in map_positions){
	     x2 = parseInt(map.style.left) + half_map_width + map_positions[place][0];
	     y2 = parseInt(map.style.top) + half_map_height + map_positions[place][1];
	     distance = distanceBetweenCoords(x1, y1, x2, y2);
	     if (distance < smallest_distance){
		 smallest_distance = distance;
		 closest_coords = map_positions[place];
	     }
	 }
	 return closest_coords;
     }
     function focusMapCoordinates(x, y){
	 if (snapping){
	     map.style.transition = 'top 0.2s, left 0.2s';
	     setTimeout(() => { map.style.transition = ''; }, 200);
	 }
	 map.style.left = ((document.body.clientWidth / 2) - half_map_width - x) + 'px';
	 map.style.top = ((document.body.clientHeight / 2) - half_map_height - y) + 'px';
     }
     
     // Map Initialisation Functions
     function placeMapItem(item,x,y){
	 item.style.left = (x + half_map_width) + 'px';
	 item.style.top = (y + half_map_height) + 'px';
     }
     function initialiseMapItems(){
	 for (var place in map_positions){
	     const location_element = document.getElementById(place);
	     placeMapItem(location_element, map_positions[place][0], map_positions[place][1])
	 }
     }

     // Page Initialisation
     window.onload = function(){
	 map = document.getElementById('map');
	 half_map_width = map.offsetWidth / 2;
	 half_map_height = map.offsetHeight / 2;
	 initialiseMapItems();
	 map.addEventListener('mousedown', startDrag);
	 map.addEventListener('touchstart', startDrag);
	 document.addEventListener('mouseup', endDrag);
	 document.addEventListener('touchend', endDrag);
	 document.addEventListener('mousemove', updateRealMousePosition);
	 document.addEventListener('touchmove', updateRealMousePosition);
	 focusMapCoordinates(0,0);
     }
    </script>
</html>
