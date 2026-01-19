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
	 }
	 #map {
	     position: relative;
	     top: 0px;
	     left: 0px;
	     width: fit-content;
	     height: fit-content;
	 }
	 #map-background {
	     margin: auto;
	 }
	 .map-link {
	     position: absolute;
	     background: grey;
	     color: white;
	     transform: translate(-50%, -50%);
	 }
	 .map-link:hover {
	     transform: scale(1.2) translate(-50%, -50%);
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
	    <div class="map-link" id="tinsel-town-tavern">Tinsel Town Tavern</div>
	</div>
    </body>

    <script>
     var real_mouse_position = [0,0];
     var start_drag_position = [0,0];
     var dragging = false;
     const map = document.getElementById('map');
     const half_map_width = map.offsetWidth / 2;
     const half_map_height = map.offsetHeight / 2;

     const map_positions = {
	 'tinsel-town-tavern': [0,0]
     }

     // Mouse Functions
     function startDrag(){
	 dragging = true;
	 start_drag_position = [real_mouse_position[0] - parseInt(map.style.left), real_mouse_position[1] - parseInt(map.style.top)];
     }
     function endDrag(){
	 dragging = false;
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
	 initialiseMapItems();
	 map.addEventListener('mousedown', startDrag);
	 document.addEventListener('mouseup', endDrag);
	 document.addEventListener('mousemove', updateRealMousePosition);
	 updateMapPosition();
     }
    </script>
</html>
