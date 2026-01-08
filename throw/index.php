<html>
    <head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<style>
	 #game-container {
	     background: #f4f4f4;
	     width: min(95vw, 1200px);
	     aspect-ratio: 4 / 3;
	     position: fixed;
	     left: 50%;
	     top: 50%;
	     transform: translate(-50%, -50%);
	     cursor: none;
	 }
	 #cursor {
	     width: 10px;
	     aspect-ratio: 1 / 1;
	     border-radius: 5px;
	     position: absolute;
	     transform: translate(-50%, -50%);
	     background: red;
	     transition: left 0.1s, top 0.1s;
	 }
	 #hog {
	     width: 15px;
	     aspect-ratio: 1 / 1;
	     border-radius: 7.5px;
	     position: absolute;
	     transform: translate(-50%, -50%);
	     background: brown;
	 }
	 #vector {
	     width: 20px;
	     height: 2px;
	     background: black;
	     position: absolute;
	     transform: translate(-50%, -50%);
	 }
	</style>
    </head>

    <body>
	<div id="game-container">
	    <div id="vector"></div>
	    <div id="hog"></div>
	    <div id="cursor"></div>
	</div>
    </body>

    <script>
     const game_width = 400;
     const game_height = 300;
     var cursor_position; // Array of [x, y] in pixels
     var game_bounds;
     var multiplier_x;
     var multiplier_y;
     var hog_x; // Position in coords (0 to game_width)
     var hog_y;
     const minimum_hog_x = 0.5; // Don't start *right* in the corner
     const minimum_hog_y = 0.5;
     var hog_flying = false;
     var hog_p; // X velocity
     var hog_t; // Flight time
     var hog_u; // Initial vertical velocity
     var hog_v; // Current vertical velocityv
     var hog_flight; // setInterval object of active flight
     const gravity = -9.81; // Downward acceleration
     var last_refresh = 0; // Timestamp of last update to prevent bogging down
     const fps = 15;
     const frame_length_ms = (1 / fps) * 1000;

     function updateGameBounds(){
	 game_bounds = $('#game-container')[0].getBoundingClientRect();
	 multiplier_x = game_width / (game_bounds.right - game_bounds.left);
	 multiplier_y = game_height / (game_bounds.bottom - game_bounds.top);
     }
     function clamp(number, min, max){
	 return Math.min(Math.max(number, min), max);
     }
     function getGameCursorPositionPixels(real_position){
	 return [
	     clamp(real_position[0], game_bounds.left, game_bounds.right) - game_bounds.left,
	     clamp(real_position[1], game_bounds.top, game_bounds.bottom) - game_bounds.top];
     }
     function pixelPositionToCoords(pixel_position){
	 return [
	     (pixel_position[0] * multiplier_x),
	     (game_height - (pixel_position[1] * multiplier_y))]; // Convert to positive Y
     }
     function coordsToPixelPosition(coords){
	 return [
	     (coords[0] / multiplier_x),
	     ((game_height - coords[1]) / multiplier_y)]; // Convert to negative Y
     }
     
     function timeToRefresh(){ // Return bool depending on if a screen refresh is required
	 const current_time = Date.now()
	 if (current_time - last_refresh > frame_length_ms){
	     last_refresh = current_time;
	     return true;
	 } else {
	     return false;
	 }
     }
     
     function incrementHogFlight(){
	 hog_t += 0.02; // Increment time
	 hog_x += hog_p; // Increment the hog's horizontal position (no acceleration)
	 hog_y = (hog_u * hog_t) + (0.5 * gravity * hog_t * hog_t); // Calculate the hog's vertical position
	 if (hog_y <= 0){ // The hog has landed
	     hog_y = 0;
	     hog_flying = false;
	     clearInterval(hog_flight);
	 }
     }
     function getCursorVector(){
	 cursor_coords = pixelPositionToCoords(cursor_position);
	 velocity_x = cursor_coords[0] / game_width;
	 velocity_y = cursor_coords[1] / game_height;
	 return [velocity_x, velocity_y];
     }
     function beginFlight(){
	 resetHogPosition();
	 hog_flying = true;
	 hog_t = 0;	 
	 const initial_velocity = getCursorVector();
	 hog_p = initial_velocity[0];
	 hog_u = initial_velocity[1] * 40;
	 hog_flight = setInterval(incrementHogFlight, 10);
     }
     function resetHogPosition(){
	 hog_x = minimum_hog_x;
	 hog_y = minimum_hog_y;
     }
     function fireHog(){
	 if (!hog_flying){
	     resetHogPosition();
	     beginFlight();
	 }
     }

     // Display Functions
     function updateCannon(){
	 const coords = pixelPositionToCoords(cursor_position);
	 const angle = Math.atan(coords[1] / -coords[0]) * (180 / Math.PI);
	 $('#vector')[0].style.webkitTransform = 'rotate('+angle+'deg)';
     }
     function updateHog(){
	 const hog_position = coordsToPixelPosition([hog_x, hog_y]);
	 $('#hog')[0].style.left = hog_position[0];
	 $('#hog')[0].style.top = hog_position[1];
     }
     function updateCursor(event){
	 cursor_position = getGameCursorPositionPixels([event.clientX, event.clientY]);
	 $('#cursor')[0].style.left = cursor_position[0];
	 $('#cursor')[0].style.top = cursor_position[1];
     }
     function updateAll(event){
	 if (timeToRefresh()){
	     updateGameBounds();
	     updateCursor(event);
	     updateCannon();
	     updateHog();
	 }
     }
	 
     document.addEventListener('mousemove', updateCursor);
     document.addEventListener('click', fireHog);
     updateGameBounds();
     resetHogPosition();
     updateHog();
     console.log(hog_x);
    </script>
</html>
