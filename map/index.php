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
	   position: absolute;
	   top: 0px;
	   left: 0px;
       }
       .map-link {
	   position: absolute;
	   background: grey;
	   color: white;
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
	  <img src="map.jpg" draggable="false">
	  <div class="map-link" id="tinsel-town-tavern">Tinsel Town Tavern</div>
  </body>

  <script>
   var real_mouse_position = [0,0];
   var start_drag_position = [0,0];
   var dragging = false;
   const map = document.getElementById('map');
   const half_map_width = map.offsetWidth;
   const half_map_height = map.offsetHeight;
   map.addEventListener('mousedown', startDrag);
   document.addEventListener('mouseup', endDrag);
   document.addEventListener('mousemove', updateRealMousePosition);
   updateMapPosition();

   const map_positions = {
       'tinsel-town-tavern': [0,0]
   }
   
   function startDrag(){
       dragging = true;
       start_drag_position = [real_mouse_position[0] - parseInt(map.style.left), real_mouse_position[1] - parseInt(map.style.top)];
       console.log(start_drag_position);
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
   function placeMapItem(item,x,y){
       item.left = x - half_map_width;
       item.top = y - half_map_height;
   }

   for (var location in map_positions){
       var location_element = document.getElementById(location);
       location_element.left = map_positions[location][0];
       location_element.top = map_positions[location][1];       
   }
  </script>
</html>
