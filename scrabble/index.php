<html>
    <head>
	<style>
	 @font-face {
	     font-family: Melodica;
	     src: url('../fonts/Melodica.otf');
	 }
	 body {
	     font-family: Melodica
	 }
	 h1, h2 {
	     text-align: center;
	     margin: 0;
	 }
	 #toolbar {
	     margin: 0 auto;
	     gap: 1rem;
	 }
	 .toolbar-button {
	     text-decoration: underline;
	 }
	 #game {
	     gap: 5px;
	     flex-wrap: wrap;
	     width: min(calc(100vw - 10px), 600px);
	     margin: 2rem auto;
	 }
	 #rack {
	     background: #025418;
	     width: 100%;
	     gap: 5px;
	     padding: 5px;
	 }
	 .tile {
	     height: 28px;
	     aspect-ratio: 1 / 1;
	     border: 2px solid #a9a0a4;
	     border-radius: 3px;
	     box-sizing: border-box;
	     background-color: #ede4d7;
	     font-size: 2rem;
	     position: relative;
	 }
	 .tile-active {
	     border-color: red;
	     cursor: pointer;
	 }
	 #board {
	     flex-basis: 100%;
	     display: flex;
	     flex-wrap: wrap;
	     gap: 2px;
	     background-color: grey;
	 }
	 .slot {
	     flex-basis: calc(calc(100% / 15) - 2px);
	     flex-grow: 1;
	     aspect-ratio: 1 / 1;
	     background-color: #f9eacd;
	 }
	 .slot > .tile {
	     width: 90%;
	     height: 90%;
	 }
	 .slot, .tile, #rack, #game, #toolbar {
	     display: flex;
	     justify-content: center;
	     align-items: center;
	 }
	 .double-letter {
	     background-color: #b4eefc;
	 }
	 .triple-letter {
	     background-color: #1daee0;
	 }
	 .double-word {
	     background-color: #fbb8c3;
	 }
	 .triple-letter {
	     background-color: #f95f6c;
	 }
	 .in-hand {
	     border: 2px solid white;
	 }
	 .tile:after {
	     font-size: 1rem;
	     position: absolute;
	     bottom: -0.25rem;
	     right: 0rem;
	 }
	 .A:after, .E:after, .I:after, .L:after, .N:after, .O:after, .R:after, .S:after, .T:after, .U:after {
	     content: '1';
	 }
	 .D:after, .G:after {
	     content: '2';
	 }
	 .B:after, .C:after, .G:after {
	     content: '3';
	 }
	 .F:after, .H:after, .V:after, .W:after, .Y:after {
	     content: '4';
	 }
	 .K:after {
	     content: '5';
	 }
	 .J:After, .X:After {
	     content: '8';
	 }
	 .Q:after, .Z: after {
	     content: '10';
	 }
	 #error-message {
	     color: red;
	 }
	</style>
    </head>
    <body>
	<h1>hog scrabble</h1>
	<h2>free and multiplayer</h2>
	<div id="toolbar">
	    <div class="toolbar-button">HOME</div>
	    <div class="toolbar-button">PLAY</div>
	    <div class="toolbar-button">ABOUT</div>
	</div>
	<div id="game">
	    <div id="error-message"></div>
	    <div id="rack"></div>
	    <div id="board"></div>
	</div>
    </body>
</html>

<script>
 // Constants
 const error_message = document.getElementById('error-message');
 const rack = document.getElementById('rack');
 const board = document.getElementById('board');
 const score_multiplier_reference = {
     0: 'normal',
     1: 'double-letter',
     2: 'triple-letter',
     3: 'double-word',
     4: 'triple-word'
 };
 const board_slots = [ // score multiplier per board slot (see above reference)
     4,0,0,1,0,0,0,4,0,0,0,1,0,0,4,
     0,3,0,0,0,2,0,0,0,2,0,0,0,2,0,
     0,0,3,0,0,0,1,0,1,0,0,0,3,0,0,
     1,0,0,3,0,0,0,1,0,0,0,3,0,0,1,
     0,0,0,0,3,0,0,0,0,0,3,0,0,0,0,
     0,2,0,0,0,2,0,0,0,2,0,0,0,2,0,
     0,0,1,0,0,0,1,0,1,0,0,0,1,0,0,
     4,0,0,1,0,0,0,3,0,0,0,1,0,0,4,
     0,0,1,0,0,0,1,0,1,0,0,0,1,0,0,
     0,2,0,0,0,2,0,0,0,2,0,0,0,2,0,
     0,0,0,0,3,0,0,0,0,0,3,0,0,0,0,
     1,0,0,3,0,0,0,1,0,0,0,3,0,0,1,
     0,0,3,0,0,0,1,0,1,0,0,0,3,0,0,
     0,3,0,0,0,2,0,0,0,2,0,0,0,2,0,
     4,0,0,1,0,0,0,4,0,0,0,1,0,0,4,
 ];

 // Live Variables
 var board_state = [ // actual state of the board using letters - initialised using PHP on page load
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
     '','','','','','','','','','','','','','','',
 ];
 var rack_tiles = ['X','A','B','C','D','E','F'];
 var tile_in_hand = false;
 
 // Setup Functions
 function createSlot(score_multiplier, letter=''){ // multiplier 0-4 (see score_multiplier_reference)
     const slot = document.createElement('div');
     slot.id = 'slot-'+slot_index; // id e.g. slot-1
     slot.classList.add('slot', score_multiplier_reference[score_multiplier]) // add class(es) e.g. slot & triple-letter
     if (letter != ''){ // if a tile is already in that slot
	 slot.appendChild(createTile(letter, 'slot-'+slot_index+'-letter')); // add the tile that already exists there
     } else {
	 slot.addEventListener('click', placeTile); // otherwise let it have a tile added to it interactively
     }
     return slot
 }
 function generateBoardSlots(){ // populate board with slots
     for (slot_index=0; slot_index<board_slots.length; ++slot_index){
	 const slot = createSlot(board_slots[slot_index], board_state[slot_index]);
	 board.appendChild(slot);
     }
 }
 function createTile(letter, id, active=false){ // create tile element with given letter
     const tile = document.createElement('div');
     tile.id = id;
     tile.classList.add('tile', letter) // add class(es) e.g. slot & triple-letter
     if (active){
	 tile.classList.add('tile-active');
     }
     tile.innerText = letter;
     return tile
 }
 function generateRackTiles(){ // populate rack with tiles
     for (tile_index=0; tile_index<rack_tiles.length; ++tile_index){
	 const tile = createTile(rack_tiles[tile_index], 'tile-'+tile_index, true);
	 tile.addEventListener('click', pickUpTile);
	 rack.appendChild(tile);
     }
 }

 // Tile Movement Functions
 function addToHand(new_tile){
     tile_in_hand = new_tile;
     tile_in_hand.classList.add('in-hand');
 }
 function emptyHand(){
     tile_in_hand.classList.remove('in-hand');
     tile_in_hand = false;
 }
 function swapTile(new_tile){ // swap the tile currently in hand with the new tile
     emptyHand();
     addToHand(new_tile);
 }
 function returnToRack(tile){
     board_state[tile.parentNode.id.replace('slot-','')] = '';
     tile.parentNode.removeChild(tile);     
     rack.appendChild(tile);
     validatePlacement();
 }
 function pickUpTile(event){ // add the clicked tile to hand
     const tile = event.target;
     if (!tile_in_hand){
	 if (tile.parentNode.id == 'rack'){
	     addToHand(tile); // just pick it up
	 } else {
	     returnToRack(tile); // already in slot so return to rack
	 }
     } else {
	 swapTile(tile)
     }
 }
 function placeTile(event){ // try to place tile in hand in clicked slot
     const slot = event.target;
     if (tile_in_hand && slot.children.length == 0){ // if holding a tile and clicking an empty slot
	 tile_in_hand.parentNode.removeChild(tile_in_hand); // remove tile from hand
	 slot.appendChild(tile_in_hand); // add tile to slot
	 board_state[slot.id.replace('slot-','')] = tile_in_hand.innerText;
	 emptyHand();
	 validatePlacement();
     }
 }

 // Game Scoring Functions
 function updateErrorMessage(new_message){
     error_message.innerHTML = new_message;
 }
 function validatePlacement(){
     let new_message = '';
     const tile_coordinates = getTileCoordinates(true);
     const direction = checkColinearity(tile_coordinates);
     if (!direction){
	 new_message += 'tiles must be in a line<br>';
     } else if (!checkAllTilesTouch()) {
	 new_message += 'tiles must be touching<br>';
     }
     // check words without active
     // check words with active and compare to get new words
     // dictionary check all new words
     updateErrorMessage(new_message);
 }
 function getTileCoordinates(active_only=false){ // active only will only return a coord list of the active tiles
     let tile_coordinates = [];
     for (slot_index=0; slot_index<board_slots.length; ++slot_index){ // for every slot
	 slot = board.children[slot_index];
	 if (slot.children.length != 0){ // if the slot contains a tile
	     if (slot.children[0].classList.contains('tile-active') || active_only == false){ // if the tile is active or active_only is off
		 tile_coordinates.push([slot_index % 15, Math.floor(slot_index/15)]); // get the tile coords as [x,y]
	     }
	 }
     }
     return tile_coordinates;
 }
 function getBoardState2D(border=true){ // instead of a flat board state, get in form [x1,y1] with a 1 item border of blanks to allow indexing in each direction
     let board_state_2d = ['.'.repeat(16).split('.')];
     for (y=0; y<15; ++y){
	 let column = [];
	 if (border){
	     column.push(null);
	 }
	 for (x=0; x<15; ++x){
	     column.push(board_state[(x*15)+y]);
	 }
	 if (border){
	     column.push(null);
	 }
	 board_state_2d.push(column);
     }
     if (border){
	 board_state_2d.push('.'.repeat(16).split('.'));
     }
     console.log(board_state_2d);
     return board_state_2d
 }
 function checkAllTilesTouch(){
     let board_state_2d = getBoardState2D(); // board state as 2D array of letters
     let blob_found = false; // blob of letters
     let allowed_coords = [];
     const coord_offsets = [[-1,0],[0,-1],[1,0],[0,1]];
     for (x=1; x<=15; ++x){
	 for (y=1; y<=15; ++y){
	     if (board_state_2d[x][y] != ''){ // if there's a letter there
		 if (!blob_found){
		     blob_found = true; // the blob (of letters) has been found
		 } else if (!allowed_coords.includes[x,y]){ // if this tile is in a new blob (can only fail if not the first letter of the blob)
		     return false // fail the touching test
		 }
		     
		 for (offset=0; offset<coord_offsets.length; ++offset){ // check all surrounding slots
		     allowed_coords.push([x+coord_offsets[offset][0],y+coord_offsets[offset][1]]);
		 }
	     }
	 }
     }
     console.log(allowed_coords);
     return true
 }
 function checkColinearity(tile_coordinates){ // check all placed tiles are colinear
     let x = y = direction = null; // will contain the row/column value (0-15 each) of the placed word
     const coords = [x,y];
     for (tile_index=0; tile_index<tile_coordinates.length; ++tile_index){
	 if (x == null){ // not set x and y from the first tile yet
	     x = tile_coordinates[tile_index][0]; // set them
	     y = tile_coordinates[tile_index][1];
	 } else if (direction == null){ // direction not yet set but not the first tile being checked (second tile being checked)
	     if (tile_coordinates[tile_index][0] == x){ // if x is the same
		 direction = 0; // its a vertical word
	     } else if (tile_coordinates[tile_index][1] == y){ // or if y is the same
		 direction = 1; // its a horizontal word
	     } else { // neither x or y is the same
		 return false
	     }
	 } else if (tile_coordinates[tile_index][direction] != coords[direction]){ // if direction set
	     return false
	 }
     }
     return [direction] // tiles colinear or no tiles placed
 }
 
 // Setup (On Window Load)
 window.addEventListener("load", (event) => {
     generateBoardSlots();
     generateRackTiles();
 });
</script>
