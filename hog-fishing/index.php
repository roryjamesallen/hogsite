<?php
include '../lib/generic_content.php';

?>

<!DOCTYPE html>
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk/hog-fishing" />
    <title>Hog Fishing</title>
<style>
:root {
    --slow-transition: 2s;
    --fast-transition: 0.1s
}
#game-container {
	position: relative;
	width: 800px;
	height: 500px;
	margin: auto;
	border: 2px solid black;
}
#fish-container {
    height: 100vh;
    width: 100vw;
}
#fishing-rod {
    position: absolute;
    top: 0;
    transition: left var(--fast-transition), top var(--fast-transition);
}
#fish-caught {
    color: green;
    font-size: 20px;
}
.fish {
    position: absolute;
    transition: left var(--fast-transition), top var(--slow-transition);
}
.caught {
    color: red;
    top: 0 !important;
}
</style>
</head>
<body>
	<div id='game-container'>
    <div id='fish-caught'></div>
    <div id='fishing-rod'>R</div>
    <div id='fish-container'></div>
	</div>
</body>

<script type='module'>
// Customisable globals      
var framerate = 15;
var max_tick = 1000;
var average_fish_speed = 5;
var position_hitbox = 15;
var height_hitbox = 25;

// Non-customisable globals
var delay_per_tick = (1 / framerate) * 1000;
var fish = []; // [ID, Position]
var mouse_position = [];
var rod_status = 0; // 0=ready to drop 1=dropping 2=coming back up
var rod_position = 0;
var rod_height = 0;
var max_rod_height = document.getElementById('game-container').clientHeight;
console.log(max_rod_height);
var rod_increment = 50;
var fish_caught = 0;
var mouse_offset = document.getElementById('game-container').getBoundingClientRect().left;
var game_width = document.getElementById('game-container').clientWidth;
var fish_width = 25;
var rod_width = 10;

// Rendering Functions
function renderFish(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const fish_position = fish[fish_index][1];
        const this_fish = document.getElementById('fish-' + fish_index)
            if (!this_fish.classList.contains('caught')){
                this_fish.style.left = fish_position + 'px';
            }
    }
}
function renderRod(){
    document.getElementById('fishing-rod').setAttribute('style','left: ' + rod_position + 'px; top: ' + rod_height + 'px');
}
function renderFishCaught(){
    document.getElementById('fish-caught').innerHTML = fish_caught;
}
function renderAll(){ // Update the real HTML positions
    renderFish();
    renderRod();
    renderFishCaught();
}

// Basic data processing
function getLastFishId(){
    if (fish.length == 0){
        return -1; // First ever fish, gets incremented to 0
    } else {
        return fish[fish.length - 1][0];
    }
}
function spawnFish(){
    const new_fish_id = getLastFishId() + 1;
    const new_fish_speed = Math.floor(average_fish_speed * ((Math.random() * 1.75) + 0.5));
    fish.push([new_fish_id, 0, new_fish_speed]);
    createFishElement(new_fish_id);
}
function maybeSpawnFish(){
    if (Math.floor(Math.random() * 50) == 1){ // 1 in 10 chance
        spawnFish();
    }
}
function incrementAllFish(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const this_fish = fish[fish_index]
        this_fish[1] += this_fish[2]; // Increment each fish position by its speed
		const this_fish_element = document.getElementById('fish-'+fish_index);	
		if (parseInt(this_fish_element.style.left) >= (game_width - fish_width)){
			this_fish_element.style.display = 'none';
		}
    }
}
function checkRodCatch(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const horizontal_distance = Math.abs(fish[fish_index][1] - rod_position);
        const fish_coords = document.getElementById('fish-'+fish_index).getBoundingClientRect();
        const vertical_distance = Math.abs(fish_coords.top - rod_height);
        if (horizontal_distance < position_hitbox && vertical_distance < height_hitbox){ // If the rod is close enough (laterally) to the fish
            rod_status = 2; // Rod coming back up
            //fish.splice(fish_index, 1); // Remove the fish from array
            document.getElementById('fish-'+fish_index).classList.add('caught');
            fish_caught += fish[fish_index][2]; // As many points as the speed of the fish
            break // Only allow one fish catch even if two are within hitbox (end loop now)
        }
    }
}
function incrementRod(){
    if (rod_status == 1){
        checkRodCatch(); // Can only catch on the way down
        rod_height += rod_increment; // Drop rod a bit
        if (rod_height >= max_rod_height){
            rod_height = max_rod_height;
            rod_status = 2; // Rod coming back up
        } else {
            
        }
    }
    if (rod_status == 2) { // Rod coming back up
        rod_height -= rod_increment; // Bring rod back up a bit
        if (rod_height <= 0){
            rod_height = 0;
            rod_status = 0; // Rod fully back up
        }
    }
    if (rod_status == 0){
        rod_position = clampValue(mouse_position[0] - mouse_offset, 0, (game_width - rod_width));
    }
}
function clampValue(value, min, max){
	return Math.min(Math.max(value, min), max);
}

// HTML Functions
function createFishElement(id){
    const para = document.createElement('p');
    const node = document.createTextNode('X');
    para.appendChild(node);
    para.setAttribute('id', 'fish-' + id);
    para.classList.add('fish');
    para.style.top = (Math.floor(Math.random() * 250) + 50) + 'px';
    document.getElementById('fish-container').appendChild(para);
}

// User input processing
function processClick(){
    if (rod_status == 0){ // Only if not already dropped rod
        rod_status = 1;
    }
}

// Main program functions
function tickFish(tick){
    setTimeout(function(){
        maybeSpawnFish();
        incrementAllFish();
        incrementRod();
        renderAll();
    }, delay_per_tick * tick);
}
function beginTick(){
    for (let tick=0; tick<max_tick; tick++){
        tickFish(tick);
    }
}

// Track mouse position
onmousemove = function(e){mouse_position = [e.clientX, e.clientY]}
onmousedown = function(){processClick()}

// Main
spawnFish();
beginTick();
</script>
