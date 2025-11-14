<?php
include '../lib/generic_content.php';

?>

<!DOCTYPE html>
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk/hog-fishing" />
    <title>Hog Fishing</title>
</head>
<body>
    <div id='fishing-rod'>R</div>
    <div id='fish-container'></div>
</body>

<script type='module'>
var framerate = 15;
var max_tick = 100;
var average_fish_speed = 5;

var delay_per_tick = (1 / framerate) * 1000;
var fish = []; // [ID, Position]
var mouse_position = [];

function renderFish(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const fish_position = fish[fish_index][1];
        document.getElementById('fish-' + fish_index).setAttribute('style','margin-left: ' + fish_position + 'px');
    }
}
function renderRod(){
    document.getElementById('fishing-rod').setAttribute('style','margin-left: ' + mouse_position[0] + 'px');
}
function renderAll(){ // Update the real HTML positions
    renderFish();
    renderRod();
}
function getLastFishId(){
    if (fish.length == 0){
        return -1; // First ever fish, gets incremented to 0
    } else {
        return fish[fish.length - 1][0];
    }
}
function createFishElement(id){
    const para = document.createElement('p');
    const node = document.createTextNode('X');
    para.appendChild(node);
    para.setAttribute('id', 'fish-' + id);
    document.getElementById('fish-container').appendChild(para);
}
function spawnFish(){
    const new_fish_id = getLastFishId() + 1;
    const new_fish_speed = average_fish_speed * ((Math.random() * 1.75) + 0.5)
        fish.push([new_fish_id, 0, new_fish_speed]);
    createFishElement(new_fish_id);
}
function maybeSpawnFish(){
    if (Math.floor(Math.random() * 10) == 1){ // 1 in 10 chance
        spawnFish();
    }
}
function tickFish(tick){
    setTimeout(function(){
        maybeSpawnFish();
        for (let fish_index=0; fish_index<fish.length; fish_index++){
            const this_fish = fish[fish_index]
            this_fish[1] += this_fish[2]; // Increment each fish position by its own speed
        }
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

// Main
spawnFish();
beginTick();
</script>
