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
	     font-family: Melodica;
	     font-size: 10px;
	 }
	 .map-item > span {
	     position: absolute;
	 }
	 .map-item > img {
	     width: 100%;
	     image-rendering: pixelated;
	 }
	 .map-link:hover, .map-link:focus {
	     cursor: pointer;
	     /*transform: scale(1.2) translate(-40%, -40%);*/
	     border: none;
	     outline: none;
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
	    <div id="map-background" draggable="false"></div>
	    <div class="map-item map-link" id="tinsel-town-tavern" tabindex="0"  draggable="false">Tinsel Town Tavern</div>
	    <div class="map-item map-link" id="bunker-hill" tabindex="0"  draggable="false">Bunker Hill</div>
	    <div class="map-item map-link" id="russel" tabindex="0"  draggable="false">Russel</div>
	    <div class="map-item map-link" id="firehouse" tabindex="0"  draggable="false">Firehouse</div>
	    <div class="map-item map-link" id="the-swamp" tabindex="0"  draggable="false">
		<img src="images/the-swamp.png">
		<span style="">The Swamp</span>
	    </div>
	    <div class="map-item map-link" id="the-shack" tabindex=0"  draggable="false">
		<span style="top: -20px">The Shack</span>
		<img src="images/the-shack.png">
	    </div>
	    <div class="map-item map-link" id="lady-garden-lake" tabindex=0"  draggable="false">
		<span style="top: -5px; left: 40px">Lady Garden Lake</span>
		<img src="images/lady-garden-lake.png">
	    </div>
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
     var target;

     const map_positions = {
	 'tinsel-town-tavern': [0, 0],
	 'bunker-hill': [-50, -500],
	 'russel': [300, 450],
	 'firehouse': [-100, -200],
	 'the-swamp': [420, -400],
	 'the-shack': [380, -460],
	 'lady-garden-lake': [200, -350]
     };

     // Mathematical Functions
     function distanceBetweenCoords(x1, y1, x2, y2){
	 return Math.abs(Math.sqrt(((x2 - x1)**2) + ((y2 - y1)**2)));
     }
     function findNearestLink(){
	 x1 = document.body.clientWidth / 2;
	 y1 = document.body.clientHeight / 2;
	 var smallest_distance = 99999;
	 for (var place in map_positions){
	     x2 = parseInt(map.style.left) + half_map_width + map_positions[place][0];
	     y2 = parseInt(map.style.top) + half_map_height + map_positions[place][1];
	     distance = distanceBetweenCoords(x1, y1, x2, y2);
	     if (distance < smallest_distance){
		 smallest_distance = distance;
		 nearest_link = place;
	     }
	 }
	 return nearest_link;
     }

     // Mouse Functions
     function startDrag(event){
	 dragging = true;
	 target.style.filter = 'opacity(1)';
	 if (event.type.startsWith('touch')) {
	     start_drag_position = [event.touches[0].pageX - parseInt(map.style.left), event.touches[0].pageY - parseInt(map.style.top)];
	 } else {
	     start_drag_position = [real_mouse_position[0] - parseInt(map.style.left), real_mouse_position[1] - parseInt(map.style.top)];
	 }
     }
     function endDrag(){
	 dragging = false;
	 target.style.filter = 'opacity(0)';
	 nearest_link = findNearestLink();
	 focusMapCoordinates(...map_positions[nearest_link]);
	 window.setTimeout(() => document.getElementById(nearest_link).focus(), 0);
     }
     function updateMapPosition(){
	 map.style.left = (real_mouse_position[0] - start_drag_position[0]) + 'px';
	 map.style.top = (real_mouse_position[1] - start_drag_position[1]) + 'px';
     }
     function updateRealMousePosition(event){
	 if (event.type.startsWith('touch')) {
	     real_mouse_position = [event.touches[0].pageX, event.touches[0].pageY];
	 } else {
	     real_mouse_position = [event.pageX, event.pageY];
	 }
	 if (dragging == true){
	     updateMapPosition();
	 }
     }

     // Map Movement Functions
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
	     placeMapItem(location_element, map_positions[place][0], map_positions[place][1]);
	 }
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
	 focusMapCoordinates(0,0);
	 findNearestLink();
     };
    </script>
</html>
