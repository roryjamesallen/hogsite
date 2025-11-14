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
<div id='fish-container'></div>
</body>

<script type='module'>
var speed = 100;
var max_tick = 100;
var fish = []; // [ID, Position]
function renderFish(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const fish_position = fish[fish_index][1];
        document.getElementById('fish-' + fish_index).setAttribute('style','margin-left: ' + fish_position + 'px');
    }
}
function getLastFishId(){
    if (fish.length == 0){
        return -1; // First ever fish, gets incremented to 0
    } else {
        return fish[fish.length - 1][1];
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
    fish.push([new_fish_id, 0]);
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
            fish[fish_index][1] += 1; // Increment each fish position
        }
        renderFish(); // Update the real HTML positions
    }, speed * tick);
}
function beginTick(){
    for (let tick=0; tick<max_tick; tick++){
        tickFish(tick);
    }
}
spawnFish();
beginTick();
</script>
