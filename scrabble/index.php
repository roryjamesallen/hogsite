<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'lib.php';

$playable = false; // read by JS
$game_over = false;
if (isset($_GET['game'])){
    $game_path = gamePathFromId($_GET['game']);
    $game_id = gameIdFromPath($game_path);
    if (!file_exists($game_path)){ // if game file doesn't exist (gets made as soon as game set up)
        renderHeading();
        echo 'that game doesn\'t exist :( <a href="index.php">go home</a>';
        die();
    } else if (!isset($_SESSION[$game_id])){ // game exists but php doesn't know who is playing
        header('Location: ./select-player?game='.$game_id);
    } else { // playin time
        $game_data = json_decode(file_get_contents($game_path),true);
        $turn = $game_data['turn']; // e.g. index of currently playing user
        if ($turn >= count($game_data['users'])){ // waiting for a player who hasn't joined yet
            $nickname_playing = 'someone who is yet to join the game';
        } else {
            $nickname_playing = $game_data['users'][$turn];
        }
        $board_state = $game_data['board_state'];
	$session_nickname = $_SESSION[$game_id];
        if (array_key_exists($session_nickname,$game_data)){
            $rack_tiles = $game_data[$session_nickname]['rack'];
            if ($game_data['turn'] == -1){ // game is over
                $game_over = true;
            } else if ($nickname_playing == $session_nickname){ // this user's go
                $playable = true;
            }
        } else {
            header('Location: ./select-player?game='.$game_id);
        }
    }
} else {
    renderHeading();
    if (count($_SESSION) > 0){
	echo '<br><br><h2>Rejoin Game</h2><form>';
	for ($game_index=0; $game_index<count($_SESSION); $game_index++){
	    $game_id = array_keys($_SESSION)[$game_index];
	    $game_users_string = getGameUsersString($game_id);
	    echo '<span><a href="./?game='.$game_id.'">'.$game_id.'</a>'.$game_users_string.'</span>';
	}
	echo '</form>';
    }
    echo '<br><br><h2>Create Game</h2><form action="create_game.php" method="POST"><p>Number of Players:</p>';
    for ($players=2; $players<=8; $players++){
	echo '<input type="radio" name="players" value="'.$players.'" id="players-'.$players.'">';
	echo '<label for="players-'.$players.'">'.$players.'</label>';
    }
    echo '<label for="nickname-input">Your Nickname</label><input id="nickname-input" name="nickname"><input type="submit" value="Create Game"></form>';
    die();
}
$game_over_text = '';
if ($game_over){
    $game_over_text = '<br>GAME OVER';
}
?>

<html>
    <body>
	<div id="info-block">
	    <?php renderHeading();?>
	    <div id="rack"></div>
	    <div id="this-user">You are <?php echo $session_nickname;?>. <span id="user-turn-text"></span><?php echo $game_over_text;?></div>
	    <div id="error-message"></div>
	    <div id="play-button" class="play-false">PLAY</div>
	</div>
	<div id="game">
	    <div id="board"></div>
	</div>
    </body>
</html>

<script>
 // Variables From PHP
 const playable = <?php echo json_encode($playable);?>; // bool of if this user can play
 const nickname_playing = '<?php echo $nickname_playing;?>'; // nickname of playing player
 var board_state = <?php echo json_encode($board_state);?>;
 const original_board_state = JSON.parse(JSON.stringify(board_state));
 const original_board_state_2d = getBoardState2D(original_board_state);
 const original_words = findWords(original_board_state_2d);
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
 const letter_points = {
     'A': 1, 'E': 1, 'I': 1, 'L': 1, 'N': 1, 'O': 1, 'R': 1, 'S': 1, 'T': 1, 'U': 1,
     'D': 2, 'G': 2,
     'B': 3, 'C': 3, 'G': 3, 'P': 3,
     'F': 4, 'H': 4, 'V': 4, 'W': 4, 'Y': 4,
     'K': 5,
     'J': 8, 'X': 8,
     'Q': 10, 'Z': 10
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
     if (nickname_playing == '<?php echo $session_nickname;?>'){
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
             //console.log("Status:", xhr.responseText);
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
     if (tile_in_hand && slot.id.includes('slot-') && slot.children.length == 0){ // if holding a tile and clicking an empty slot
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
	 const original_words = findWords(getBoardState2D(original_board_state));
	 const total_words = findWords(getBoardState2D());
	 const new_words = arrayDifference(total_words, original_words);
	 const word_keys = Object.keys(new_words);
	 if (word_keys.length > 0){
	     let max_word_points = 0;
	     let max_word = null;
	     for (let i=0; i<word_keys.length; ++i){ // get max values of each word
		 const word_string = word_keys[i];
		 const word_coords = new_words[word_string];
		 const word_points = getWordPoints(word_string, word_coords);
		 if (word_points[0] > max_word_points){
		     max_word_points = word_points[0];
		     max_word = word_points;
		 }
	     }
	     // get points of biggest word and remove from list then subsequently get other word points using used multipliers
	     const used_multipliers = max_word[1]; // array of used multiplier slots
	     let total_points = max_word_points; // minimum score is max word with mults
	     for (let i=0; i<new_words.length; ++i){ // for any other words
		 if (new_words[i] != max_word){ // as long as its not the max word
		     total_points = total_points + getWordPoints(word_keys[i], new_words[word_string]);
		 }
	     }
	     new_message += word_keys.join(' & ')+' ('+total_points+'pts)';
	 }
     }
     updateErrorMessage(new_message);
 }
 function arrayDifference(arr1, arr2){
     const arr1_keys = Object.keys(arr1);
     const arr2_keys = Object.keys(arr2);
     let arr3 = {};
     for (let i=0; i<arr1_keys.length; ++i){
	 if (!arr2_keys.includes(arr1_keys[i])){
	     arr3[arr1_keys[i]] = arr1[arr1_keys[i]];
	 }
     }
     return arr3;
 }
 function removeBlanks(arr, min_length=1){
     new_arr = [];
     for(let i=0; i<arr.length; ++i){
	 if (arr[i].length >= min_length){
	     new_arr.push(arr[i]);
	 }
     }
     return new_arr;
 }
 function getRowAsArray(row, board_state_2d){
     let row_arr = [];
     for (let column=0; column<board_state_2d.length; ++column){
	 row_arr.push(board_state_2d[column][row]);
     }
     return row_arr;
 }
 function findWordsWithCoords(arr, other_coord, direction,  min_length=1){
     let words = {};
     let reading_word = false;
     let word_coords = [];
     arr.push(''); // add a blank on the end in case a word goes up to the last index
     for (let i=0; i<arr.length; ++i){
	 if (arr[i] != ''){
	     if (reading_word == false){
		 reading_word = arr[i];
	     } else {
		 reading_word = reading_word + arr[i];
	     }
	     if (direction == 0){ // its a row
		 word_coords.push([i, other_coord]);
	     } else { // its a column
		 word_coords.push([other_coord, i]);
	     }
	 } else {
	     if (reading_word != false){ // end of a word
		 if (word_coords.length > min_length){
		     words[reading_word] = word_coords;
		 }
		 word_coords = [];
		 reading_word = false;
	     }
	 }
     }
     return words;
 }
 function getWordPoints(word, word_coords, used_multipliers=[]){ // WORD: [[x1,y1],[x2,y2],[x3,y3],[x4,y4]]
     let word_score = 0;
     let word_multipliers = [];
     for (let coord_index=0; coord_index<word_coords.length; ++coord_index){ // for each letter in the word
	 const letter_coords = word_coords[coord_index]; // get its coords [x,y]
	 const x = letter_coords[0] - 1; // -1 to remove blank border
	 const y = letter_coords[1] - 1;
	 const flat_coordinate = x + (y * 15); // to access flat array instead of 2d
	 const letter_multiplier = board_slots[flat_coordinate]; // board slot multiplier
	 let letter_score = letter_points[word[coord_index]]; // letter score with no multiplier
	 console.log('word '+word+' letter '+word[coord_index]+' points '+letter_score);
	 if (!used_multipliers.includes([x,y])){
	     if (letter_multiplier == 1){
		 letter_score = letter_score * 2;
	     } else if (letter_multiplier == 2){
		 letter_score = letter_score * 3;
	     } else if (letter_multiplier == 3){
		 word_multipliers.push(2);
	     } else if (letter_multiplier == 4){
		 word_multipliers.push(3);
	     }
	     used_multipliers.push([x,y]);
	 }
	 word_score = word_score + letter_score;
     }
     for (word_multiplier=0; word_multiplier<word_multipliers.length; ++word_multiplier){
	 word_score = word_score * word_multipliers[word_multiplier];
     }
     return [word_score, used_multipliers];
 }
 function findWords(board_state_2d){
     let words = {};
     for (let roc=0; roc<board_state_2d.length; ++roc){ // roc = row or column (index)
	 const row_array = getRowAsArray(roc, board_state_2d);
	 const row_words = findWordsWithCoords(row_array, roc, 0);
	 
	 const column_array = board_state_2d[roc];
	 const column_words = findWordsWithCoords(column_array, roc, 1);

	 words = Object.assign({}, words, column_words, row_words);

	 //let column_words = removeBlanks(board_state_2d[column].join('').split(' '),2);
	 //let row_words = removeBlanks(getRowAsArray(column, board_state_2d).join('').split(' '),2);
     }
     return words;
 }
 function getTileCoordinates(active_only=false){ // active only will only return a coord list of the active tiles
     let tile_coordinates = [];
     for (let slot_index=0; slot_index<board_slots.length; ++slot_index){ // for every slot
	 slot = board.children[slot_index];
	 if (slot.children.length != 0){ // if the slot contains a tile
	     if (slot.children[0].classList.contains('tile-active') || active_only == false){ // if the tile is active or active_only is off
		 tile_coordinates.push([slot_index % 15, Math.floor(slot_index/15)]); // get the tile coords as [x,y]
	     }
	 }
     }
     return tile_coordinates;
 }
 function getBoardState2D(board_state_1d=board_state){ // instead of a flat board state, get in form [x1,y1] with 1 item border of blanks to allow indexing of adjacent tiles
     let board_state_2d = ['.'.repeat(16).split('.')];
     for (y=0; y<15; ++y){
	 let column = [];
	 column.push('');
	 for (x=0; x<15; ++x){
	     column.push(board_state_1d[(x*15)+y]);
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
     if (!playable){
         //longpoll
         //setTimeout(() => { location.reload();}, 1000);
     }
 });
</script>
