<html>
    <head>
	<style>
	 body {
	     margin: 0;
	     font-size: 20px;
	     font-family: Arial;
	 }
	 #background {
	     position: fixed;
	     width: 100vw;
	     height: 100vh;
	 }
	 h1 {
	     font-size: 2rem;
	 }
	 #settings {
	     width: fit-content;
	     height: fit-content;
	     position: fixed;
	     left: 50%;
	     top: 50%;
	     transform: translate(-50%, -50%);
	     display: flex;
	     justify-content: center;
	     align-items: center;
	     gap: 1rem;
	     flex-wrap: wrap;
	     padding: 1rem;
	     background: #f4f4f4;
	     border: 2px solid black;
	 }
	 #settings > * {
	     flex-basis: 100%;
	     text-align: center;
	     padding: 0;
	     margin: 0;
	 }
	 input {
	     font-size: inherit;
	     text-align: center;
	     background: white;
	     border-radius: 0;
	     border: 2px solid black;
	 }
	 input:hover {
	     background: #f4f4f4;
	 }
	 .range-container {
	     display: flex;
	     gap: 1rem;
	 }
	 .range-container > input {
	     flex-grow: 1;
	 }
	 .range-container > span {
	     flex-basis: 20%;
	 }
	 #start {
	     padding: 0.5rem;
	 }
	 #colours {
	     display: flex;
	     gap: 0.5rem;
	     justify-content: center;
	     flex-wrap: wrap;
	 }
	 #colours > * {
	     min-width: 2rem;
	     height: 2rem;
	 }
	 
	</style>
    </head>
    
    <body>
	<div id="background"></div>
	<div id="settings">
	    <h1>STROBE MACHINE</h1>
	    <hr>
	    <label for="interval">INTERVAL</label>
	    <div class="range-container">
		<input id="interval" type="range" value="5" min="1" max="1000" step="1">
		<span id="interval-text">5ms</span>
	    </div>
	    <hr>
	    <span>COLOURS</span>
	    <ul id="colours">
		<input id="colour-0" type="color" value="#ffffff">
		<input id="colour-1" type="color" value="#000000">
		<input type="submit" value="-" id="remove-colour">
		<input type="submit" value="+" id="add-colour">
	    </ul>
	    <hr>
	    <input id="start" type="submit" value="START">
	</div>
    </body>

    <script>
     var strobe = false; // false if not running, interval object if running
     var colours = ['white','black'];
     var current_colour = 0;
     const interval_element = document.getElementById('interval');
     const interval_text = document.getElementById('interval-text');
     const settings = document.getElementById('settings');
     const background_element = document.getElementById('background');
     const add_colour_element = document.getElementById('add-colour');
     const remove_colour_element = document.getElementById('remove-colour');
     var colour_list = document.getElementById('colours');

     function updateColours(){
	 colours = [];
	 const colour_count = colour_list.childElementCount - 2; // -2 to remove + and - buttons
	 for (let i = 0; i < colour_count; i++) {
	     colours.push(document.getElementById('colour-' + i).value);
	 }
     }
     function stopStrobe(){
	 clearInterval(strobe);
	 strobe = false;
	 settings.style.display = 'flex';
	 background_element.style.background = 'white';
     }
     function startStrobe(){
	 updateColours();
	 var interval = interval_element.value;
	 strobe = setInterval(singleStrobe, interval);
	 settings.style.display = 'none';
     }
     function toggleStrobe(){
	 if (strobe == false){
	     startStrobe();
	 } else {
	     stopStrobe();
	 }
     }
     function incrementCurrentColour(){
	 ++current_colour;
	 if (current_colour == colours.length){
	     current_colour = 0;
	 }
     }
     function singleStrobe(){
	 background_element.style.background = colours[current_colour];
	 incrementCurrentColour();
     }
     function updateIntervalText(){
	 console.log('yeah');
	 interval_text.innerText = interval_element.value + 'ms';
     }
     function addColour(){
	 var last_colour = colour_list.lastElementChild.previousElementSibling.previousElementSibling; // before + and - buttons
	 var new_colour = last_colour.cloneNode(true);
	 new_colour.value = '#'+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0');
	 new_colour.id = 'colour-' + (parseInt(last_colour.id.replace('colour-','')) + 1);
	 colour_list.insertBefore(new_colour, add_colour_element.previousElementSibling);
     }
     function removeColour(){
	 updateColours();
	 if (colours.length > 2){
	     var last_colour = colour_list.lastElementChild.previousElementSibling.previousElementSibling; // before + and - buttons
	     colour_list.removeChild(last_colour);
	 }
     }

     remove_colour_element.addEventListener('click', removeColour);
     add_colour_element.addEventListener('click', addColour);
     interval_element.addEventListener('input', updateIntervalText);
     document.getElementById('start').addEventListener('click', toggleStrobe);
     background_element.addEventListener('click', stopStrobe);
    </script>
</html>
