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
	</style>
    </head>

    <body>
	<div id="game-container">
	    <div id="cursor"></div>
	    <div id="hog"></div>
	</div>
    </body>

    <script>
     const game_width = 400;
     const game_height = 300;
     var cursor_position = [0,0];
     var game_bounds;
     var multiplier_x;
     var multiplier_y;
     var hog_x = 0; // Position in coords (0 to game_width)
     var hog_y = 0;
     var hog_flying = false;
     var hog_p; // X velocity
     var hog_t; // Flight time
     var hog_u; // Initial vertical velocity
     var hog_v; // Current vertical velocityv
     var hog_flight; // setInterval object of active flight
     const gravity = -9.81; // Downward acceleration

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
     function updateCursor(event){
	 updateGameBounds();
	 const cursor_position = getGameCursorPositionPixels([event.clientX, event.clientY]);
	 $('#cursor')[0].style.left = cursor_position[0];
	 $('#cursor')[0].style.top = cursor_position[1];
     }
     function updateHog(){
	 const hog_position = coordsToPixelPosition([hog_x, hog_y]);
	 $('#hog')[0].style.left = hog_position[0];
	 $('#hog')[0].style.top = hog_position[1];
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
	 updateHog();
     }
     function beginFlight(){
	 hog_flying = true;
	 hog_t = 0;
	 hog_u = 30;
	 hog_p = 1;
	 hog_flight = setInterval(incrementHogFlight, 10);
     }
     function resetHogPosition(){
	 hog_x = 0;
	 hog_y = 0;
	 updateHog();
     }
     function fireHog(){
	 if (!hog_flying){
	     resetHogPosition();
	     beginFlight();
	 }
     }

     document.addEventListener('mousemove', updateCursor);
     document.addEventListener('click', fireHog);
     updateGameBounds();
     updateHog();
    </script>
</html>
