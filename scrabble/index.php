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
	     display: flex;
	     justify-content: center;
	     margin: 0 auto;
	     gap: 1rem;
	 }
	 .toolbar-button {
	     text-decoration: underline;
	 }
	 #game {
	     display: flex;
	     gap: 5px;
	     flex-wrap: wrap;
	     width: min(calc(100vw - 10px), 600px);
	     margin: 2rem auto;
	 }
	 #rack {
	     background: #025418;
	     width: 100%;
	     display: flex;
	     justify-content: center;
	     gap: 5px;
	     padding: 5px;
	 }
	 .tile {
	     height: 25px;
	     aspect-ratio: 1 / 1;
	     display: flex;
	     justify-content: center;
	     align-items: center;
	     background-color: #ede4d7;
	     font-size: 2rem;
	     position: relative;
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
	 #rack > *:after {
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
 var rack_tiles = ['X','A','B','C','D','E','F'];
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

 function createSlot(score_multiplier){ // multiplier 0-4 (see score_multiplier_reference)
     const slot = document.createElement('div');
     slot.id = 'slot-'+slot_index; // id e.g. slot-1
     slot.classList.add('slot', score_multiplier_reference[score_multiplier]) // add class(es) e.g. slot & triple-letter
     return slot
 }
 function generateBoardSlots(){
     for (slot_index=0; slot_index<board_slots.length; ++slot_index){
	 slot = createSlot(board_slots[slot_index]);
	 board.appendChild(slot);
     }
 }

 function createTile(letter, id){
     const tile = document.createElement('div');
     tile.id = id;
     tile.classList.add('tile', letter) // add class(es) e.g. slot & triple-letter
     tile.innerText = letter;
     return tile
 }
 function generateRackTiles(){
     for (tile_index=0; tile_index<rack_tiles.length; ++tile_index){
	 tile = createTile(rack_tiles[tile_index]);
	 rack.appendChild(tile);
     }
 }
 
 window.addEventListener("load", (event) => {
     generateBoardSlots();
     generateRackTiles();
 });
</script>
