<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//session_destroy();

$playable = false; // read by JS
if (isset($_GET['game'])){
    $game_path = 'games/'.$_GET['game'].'.json';
    if (!file_exists($game_path)){ // if game file doesn't exist (gets made as soon as game set up)
	echo 'that game doesn\'t exist :( <a href="index.php">go home</a>';
	die();
    } else if (!isset($_SESSION['nickname'])){ // game exists but php doesn't know who is playing
	$game_id = str_replace('.json','',str_replace('games/','',$game_path));
	echo '<a href="select-player?game='.$game_id.'">set your nickname</a>';
	die();
    } else { // playin time
	$game_data = json_decode(file_get_contents($game_path),true);
        $turn = $game_data['turn']; // e.g. index of currently playing user
	if ($turn >= count($game_data['users'])){ // waiting for a player who hasn't joined yet
	    $nickname_playing = 'someone who is yet to join the game';
	} else {
            $nickname_playing = $game_data['users'][$turn];
	}
        $board_state = $game_data['board_state'];
        $rack_tiles = $game_data[$_SESSION['nickname']]['rack'];
        if ($nickname_playing == $_SESSION['nickname']){ // this user's go
            $playable = true;
        }
    }
} else {
    echo 'home page';
    die();
}
?>

<html>
    <head>
	<style>
	 @font-face {
	     font-family: Melodica;
	     src: url('../fonts/Melodica.otf');
	 }
	 body {
	     font-family: Melodica;
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
	     border-bottom: 5px solid #003206;
	     box-sizing: border-box;
	     width: 100%;
	     gap: 5px;
	     padding: 5px 5px 0 5px;
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
	 .tile:not(.tile-active){
	     cursor: no-drop;
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
	 #error-message, #user-turn-text, #this-user {
	     flex-basis: 100%;
	     text-align: center;
	 }
	 #error-message {
	     color: red;
	 }
	 #play-button {
	     padding: 5px;
	     width: fit-content;
	     margin: 0 auto;
	 }
	 .play-true {
	     border: 2px solid red;
	     color: black;
	     background: #eee;
	     cursor: pointer;
	 }
	 .play-false {
	     border: 2px solid #eee;
	     color: #777;
	     background: white;
	     cursor: unset;
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
	    <div id="this-user">You are <?php echo $_SESSION['nickname'];?></div>
	    <div id="user-turn-text"></div>
	    <div id="error-message"></div>
	    <div id="rack"></div>
	    <div id="board"></div>
	</div>
	<div id="play-button" class="play-false">PLAY</div>
    </body>
</html>

<script>
 // Variables From PHP
 const playable = <?php echo json_encode($playable);?>; // bool of if this user can play
 const nickname_playing = '<?php echo $nickname_playing;?>'; // nickname of playing player
 var board_state = <?php echo json_encode($board_state);?>;
 var rack_tiles = <?php echo json_encode($rack_tiles);?>;
 
 // JS Constants
 const play_button = document.getElementById('play-button');
 const user_turn_text = document.getElementById('user-turn-text');
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
 var tile_in_hand = false;
 
 // Setup Functions
 function updateUserTurnText(){
     let subject = nickname_playing + '\'s';
     if (nickname_playing == '<?php echo $_SESSION['nickname'];?>'){
	 subject = 'your';
     }
     user_turn_text.innerText = 'It is '+subject+' turn';
 }
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
	 tile.addEventListener('click', pickUpTile);
     }
     tile.innerText = letter;
     return tile
 }
 function generateRackTiles(){ // populate rack with tiles
     for (tile_index=0; tile_index<rack_tiles.length; ++tile_index){
	 const tile = createTile(rack_tiles[tile_index], 'tile-'+tile_index, playable); // pass playable as active so if not playable rack tiles arent active
	 rack.appendChild(tile);
     }
 }
 function attemptPlay(){
     if ([...play_button.classList].includes('play-true')){
	 var dataToSend = "board_state=" + JSON.stringify(board_state) + "&game_path=" + "<?php echo $game_path;?>";
	 var xhr = new XMLHttpRequest();
	 xhr.open("POST", "make_play.php", false);
	 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	 xhr.onreadystatechange = function () {
	     if (xhr.readyState === XMLHttpRequest.DONE) { // request done
		 if (xhr.status === 200) { // request successful
		     location.reload();
		 } else {
		     console.error("Error:", xhr.status);
		 }
	     }
	 };
	 xhr.send(dataToSend);
	 
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
 function validatePlacement(){
     let new_message = '';
     const tile_coordinates = getTileCoordinates(true);
     const direction = checkColinearity(tile_coordinates);
     let board_state_2d = getBoardState2D(); // board state as 2D array of letters
     const first_letter_coords = findFirstLetterCoords(board_state_2d); // get x,y of first letter on board
     if (!first_letter_coords){
	 new_message += 'you must place at least one tile<br>';
     } else if (!direction){
	 new_message += 'tiles must be in a line<br>';
     } else if (!checkAllTilesTouch(board_state_2d, first_letter_coords)){
	 new_message += 'tiles must be touching<br>';
     } else {
	 const invalid_word = findFirstInvalidWord();
	 if (invalid_word != false){
	     new_message += invalid_word+' is not a valid word<br>';
	 }
     }
     updateErrorMessage(new_message);
 }
 function findFirstInvalidWord(){
     return false
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
 function getBoardState2D(){ // instead of a flat board state, get in form [x1,y1] with 1 item border of blanks to allow indexing of adjacent tiles
     let board_state_2d = ['.'.repeat(16).split('.')];
     for (y=0; y<15; ++y){
	 let column = [];
	 column.push('');
	 for (x=0; x<15; ++x){
	     column.push(board_state[(x*15)+y]);
	 }
	 column.push('');
	 board_state_2d.push(column);
     }
     board_state_2d.push('.'.repeat(16).split('.'));
     return board_state_2d
 }
 function removeAdjacentLetters(board_state_2d, x, y, tiles_to_remove=[], level=0){ // remove letter and recursively remove adjacent letters if present
     tiles_to_remove.push((x+':'+y)); // at the very least remove the letter itself
     const coord_offsets = [[-1,0],[0,-1],[1,0],[0,1]]; // list of [x,y] offsets to check for letters (adjacent but not diagonal)
     for (let offset=0; offset<coord_offsets.length; ++offset){ // check all adjacent slots
	 let adjacent_tile_x = x+coord_offsets[offset][0]; // coord of the adjacent tile
	 let adjacent_tile_y = y+coord_offsets[offset][1];
	 if (board_state_2d[adjacent_tile_x][adjacent_tile_y] != '' && !tiles_to_remove.includes((adjacent_tile_x+':'+adjacent_tile_y))){
	     extra_tiles_to_remove = removeAdjacentLetters(board_state_2d, adjacent_tile_x, adjacent_tile_y, tiles_to_remove, level+1);
	     tiles_to_remove = tiles_to_remove.concat(extra_tiles_to_remove); // recursively remove adjacent letters
	 }
     }
     return tiles_to_remove
 }
 function findFirstLetterCoords(board_state_2d){
     for (y=1; y<=15; ++y){
	 for (x=1; x<=15; ++x){
	     if (board_state_2d[x][y] != ''){ // if there's a letter there
		 letter_found = [x,y];
		 return letter_found
	     }
	 }
     }
     return false // no letters on board
 }
 function checkAllTilesTouch(board_state_2d, first_letter_coords){
     if (first_letter_coords != false){ // if there are any letters on the board
	 tiles_to_remove = removeAdjacentLetters(board_state_2d, first_letter_coords[0], first_letter_coords[1]); // recursively remove all touching letters
	 for (coord_index=0; coord_index<tiles_to_remove.length; ++coord_index){
	     coords = tiles_to_remove[coord_index].split(':');
	     board_state_2d[coords[0]][coords[1]] = '';
	 }
     } else {
	 return true // just true if there aren't any letters down
     }
     if (findFirstLetterCoords(board_state_2d) != false){ // if any letters still on board
	 return false // not all touching
     } else {
	 return true // must all be touching
     }
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
		 coords[0] = x; // set the required x for the word
	     } else if (tile_coordinates[tile_index][1] == y){ // or if y is the same
		 direction = 1; // its a horizontal word
		 coords[1] = y; // set the required y for the word
	     } else { // neither x or y is the same
		 return false
	     }
	 } else if (tile_coordinates[tile_index][direction] != coords[direction]){ // if direction set but this letter not in the line
	     return false
	 }
     }
     return [direction] // tiles colinear or no tiles placed
 }

 // Other Live Functions (Text etc)
 function setPlayButton(value){
     if (play_button.classList.contains('play-'+(!value).toString())){ // only swap if its not already that value
	 play_button.classList.remove('play-'+(!value).toString()); // remove opposite value class
	 play_button.classList.add('play-'+value.toString());
     }
 }
 function updateErrorMessage(new_message){
     error_message.innerHTML = new_message;
     if (error_message.innerText != ''){
	 setPlayButton(false); // disable play button if there's an error
     } else {
	 setPlayButton(true); // make play button active if there's not an error
     }
 }
 
 // Setup (On Window Load)
 window.addEventListener("load", (event) => {
     generateBoardSlots();
     generateRackTiles();
     updateUserTurnText();
     play_button.addEventListener('click', attemptPlay);
 });
</script>
