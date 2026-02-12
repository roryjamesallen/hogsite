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
	    <div id="rack"></div>
	    <div id="board"></div>
	</div>
    </body>
</html>

<script>
 // Constants
 const rack = document.getElementById('rack');
 const board = document.getElementById('board');
 const score_multiplier_reference = {
     0: 'normal',
     1: 'double-letter',
     2: 'triple-letter',
     3: 'double-word',
     4: 'triple-word'
 };
 const board_slots = [
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
 var rack_tiles = ['X','A','B','C','D','E','F'];
 var tile_in_hand = false;
 
 // Setup Functions
 function createSlot(score_multiplier){ // multiplier 0-4 (see score_multiplier_reference)
     const slot = document.createElement('div');
     slot.id = 'slot-'+slot_index; // id e.g. slot-1
     slot.classList.add('slot', score_multiplier_reference[score_multiplier]) // add class(es) e.g. slot & triple-letter
     return slot
 }
 function generateBoardSlots(){ // populate board with slots
     for (slot_index=0; slot_index<board_slots.length; ++slot_index){
	 const slot = createSlot(board_slots[slot_index]);
	 slot.addEventListener('click', placeTile);
	 board.appendChild(slot);
     }
 }
 function createTile(letter, id){ // create tile element with given letter
     const tile = document.createElement('div');
     tile.id = id;
     tile.classList.add('tile', letter) // add class(es) e.g. slot & triple-letter
     tile.innerText = letter;
     return tile
 }
 function generateRackTiles(){ // populate rack with tiles
     for (tile_index=0; tile_index<rack_tiles.length; ++tile_index){
	 const tile = createTile(rack_tiles[tile_index], 'tile-'+tile_index);
	 tile.addEventListener('click', pickUpTile);
	 rack.appendChild(tile);
     }
 }

 // Game Functions
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
     tile.parentNode.removeChild(tile);
     rack.appendChild(tile);
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
	 emptyHand();
     }
 }
 
 // Setup (On Window Load)
 window.addEventListener("load", (event) => {
     generateBoardSlots();
     generateRackTiles();
 });
</script>
