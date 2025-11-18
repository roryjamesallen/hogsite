<?php
include '../lib/generic_content.php';

openSqlConnection('wildhog_analytics', '../sql_login_wildhog_analytics.php');

$force_leaderboard = false;
$limit = 5;
if (isset($_POST['username'])){
	$username = $_POST['username'];
	$points = $_POST['points'];
	$result = sqlQuery('SELECT * FROM fishing_points WHERE username="'.$username.'"');
	$submit_result = true;
    if ($result != []){
        // user has submitted a score before
        foreach ($result as $old_points){
			if ($old_points['points'] >= $points){
				// this is not the users highest score ever
				$submit_result = false;
			}
		}
    }
	if ($submit_result){
		sqlQuery('INSERT INTO fishing_points (username, points) VALUES ("'.urlencode($username).'", "'.$points.'")');
	}
} else if (isset($_GET['leaderboard'])){
    $force_leaderboard = true; // user just wants to view it but not submit
    $limit = 500;
}
$leaderboard = json_encode(sqlQuery('SELECT * FROM fishing_points ORDER BY points DESC LIMIT '.$limit));
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
body {
	overflow-x: hidden;
    font-family: Arial;
}
.big-note {
    display: flex;
	flex-wrap: wrap;
    align-items: center;
	align-content: start;
	gap: 2rem;
    justify-content: center;
    height: 100%;
    text-align: center;
    font-size: 2rem;
}
.leaderboard > * {
	flex-grow: 1;
}
.leaderboard, .leaderboard > div {
	flex-basis: 100%;
    display: flex;
	flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
}
.leaderboard > div {
	padding: 0.5rem 0;
	border-bottom: 1px solid black;
}
.leaderboard input {
	height: 3rem;
	box-sizing: border-box;
	font-size: 2rem;
	text-align: center;
	border-radius: 0;
}
.leaderboard div span:first-child, .leaderboard input {
	flex-basis: 70%;
}
.leaderboard input[type='submit'], .leaderboard div span:not(:first-child) {
	flex-basis: 25%;
}
#bath-background {
    position: absolute;
    z-index: -1;
    width: 900px;
    height: 600px;
    left: -50px;
}
#game-container {
	position: relative;
	width: 800px;
	height: 500px;
	margin: 50px auto;
}
#fish-container {
    height: 100vh;
    width: 100vw;
}
#fishing-rod {
    position: absolute;
    top: 0;
    transition: left var(--fast-transition), top var(--fast-transition);
    aspect-ratio: 58 / 1790;
}
#fish-caught {
    position: relative;
    color: green;
    font-size: 2rem;
    z-index: 2;
    margin: 1rem 2rem;
}
.fish {
    position: absolute;
    transition: left var(--fast-transition), top var(--slow-transition), filter var(--slow-transition);
    background-image: url('images/hog-fishing/duck.png');
    background-size: contain;
    width: 35px;
    aspect-ratio: 100 / 82;
    box-sizing: border-box;
    padding: 14px;
}
.fish:not(.caught){
    filter: opacity(0.99);
}
.caught {
    top: 0 !important;
    filter: opacity(0.25);
}
</style>
</head>
<body>
	<div id='game-container'>
        <img id='bath-background' src='images/hog-fishing/bath.png'>
        <div id='fish-caught'></div>
        <img id='fishing-rod' src='images/hog-fishing/rod-wire.png'/>
        <div id='fish-container'></div>
    </div>
    <div class='neh-hogwild-footer' style='width: fit-content; margin: 6rem auto; font-family: Arial; text-align: center;'>A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation</div>
</body>

<script type='module'>
// Customisable globals      
var framerate = 15;
var max_tick = 500;
var average_fish_speed = 5;
var position_hitbox = 15;
var height_hitbox = 25;

// Non-customisable globals
var delay_per_tick = (1 / framerate) * 1000; // Convert framerate to ms per frame (tick)
var fish = []; // [ID, Position, Speed]
var mouse_position = []; // Updated with mouse coords every time mouse moves
var rod_status = 0; // 0=ready to drop 1=dropping 2=coming back up
var rod_position = 0; // Horizontal rod position (mouse position but clamped to game size and not updated during rod drops)
var rod_height = 0; // Vertical rod position (updated during rod drops)
var max_rod_height = document.getElementById('game-container').clientHeight; // Maximum distance the rod can drop (based on game size)
var rod_increment = 50; // Increment per frame of rod dropping (speed of rod)
var fish_caught = 0; // Points
var mouse_offset = document.getElementById('game-container').getBoundingClientRect().left; // Offset mouse for calculating hits based on game size
var mouse_height_offset = document.getElementById('game-container').getBoundingClientRect().top - 50;
var game_width = document.getElementById('game-container').clientWidth;
var fish_width = 25; // Hitbox of fish
var rod_width = 10; // So the rod doesn't overflow the game container

document.getElementById('fishing-rod').style.height = max_rod_height + 'px';

// Rendering Functions
function renderFish(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){ // For every fish
        const fish_position = fish[fish_index][1]; // Get its current position
        const this_fish = document.getElementById('fish-' + fish_index) // Get the HTML element of the fish the array item relates to
            if (!this_fish.classList.contains('caught')){ // Only update uncaught fish
                this_fish.style.left = fish_position + 'px'; // Update its position (absolute left alignment)
            }
    }
}
function renderRod(){
    document.getElementById('fishing-rod').style.left = rod_position + 'px';
    document.getElementById('fishing-rod').style.top = -max_rod_height +  mouse_height_offset + rod_height + 'px';
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
			this_fish_element.style.filter = 'opacity(0)';
		}
    }
}
function checkRodCatch(){
    for (let fish_index=0; fish_index<fish.length; fish_index++){
        const fish_coords = document.getElementById('fish-'+fish_index).getBoundingClientRect();
		const horizontal_distance = Math.abs(fish[fish_index][1] - rod_position);
        const vertical_distance = Math.abs(fish_coords.top - rod_height - mouse_height_offset);
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
    const img = document.createElement('img');
    img.setAttribute('id', 'fish-' + id);
    img.classList.add('fish');
    img.style.top = (Math.floor(Math.random() * 250) + 50) + 'px';
    //img.style.filter = 'brightness(' + Math.floor((Math.random() + 0.75) * 100) + '%)'; // 0.5 to 1.5
    document.getElementById('fish-container').appendChild(img);
}
function createLeaderboardEntry(entry){
	const container = document.createElement('div');
	const username = document.createElement('span');
	username.innerHTML = decodeURIComponent(entry['username'].replace(/\+/g, ' '));
	const points = document.createElement('span');
	points.innerHTML = entry['points'];
	container.appendChild(username);
	container.appendChild(points);
	return container;
}
function generateLeaderboard(){
    const leaderboard = <?php echo $leaderboard;?>;
	const leaderboard_text = document.createElement('p');
	leaderboard_text.classList.add('leaderboard');
	for (let leaderboard_entry=0; leaderboard_entry<leaderboard.length; leaderboard_entry++){
		leaderboard_text.appendChild(createLeaderboardEntry(leaderboard[leaderboard_entry]));
	}
    return leaderboard_text;
}
function generateFullLeaderboardLink(){
    const link = document.createElement('a');
    link.href = '<?php echo strtok($current_url, "?");?>' + '?leaderboard=true';
    link.innerHTML = 'view full leaderboard';
    link.classList.add('button-as-link');
    return link
}
function generatePlayLink(text, remove_parameters=false){
    let link = '';
    if (remove_parameters){
        link = '<?php echo strtok($current_url, "?");?>';
    } else {
        link = '<?php echo $current_url;?>';
    }
    return '<a href="'+link+'" style="flex-basis: 100%" class="button-as-link">'+text+'</a>';
}
function generateBigNote(content){
    const text = document.createElement('p');
    text.innerHTML = content;
    text.classList.add('big-note');
    return text
}
function showGameOver(){
    const text = generateBigNote(generatePlayLink('Play Again') + 'GAME OVER<br>You won ' + fish_caught + ' points');
	const form = document.createElement('form');
	form.classList.add('leaderboard');
	form.method = 'POST';
	const input = document.createElement('input');
	input.name = 'username';
	input.placeholder = 'nickname';
    input.maxLength = '32';
	const points = document.createElement('input');
	points.name = 'points';
	points.type = 'hidden';
	points.value = fish_caught;
	const submit = document.createElement('input');
	submit.type = 'submit';
	submit.value = 'submit';
	form.appendChild(input);
	form.appendChild(points);
	form.appendChild(submit);
	text.appendChild(form);
	text.appendChild(generateLeaderboard());
    text.appendChild(generateFullLeaderboardLink())
    clearGameContainerContent();
    appendGameContainerContent(text);
}
function clearGameContainerContent(){
    const game_container = document.getElementById('game-container');
    game_container.innerHTML = '';
    game_container.style.height = 'unset';
}
function appendGameContainerContent(content){
    const game_container = document.getElementById('game-container');
    game_container.appendChild(content);
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
    setTimeout(function(){
        showGameOver();
    }, delay_per_tick * (max_tick + 1)); // Show after the last game tick
}

if (!<?php echo json_encode($force_leaderboard);?>){
    // Track mouse position
    onmousemove = function(e){mouse_position = [e.clientX, e.clientY]}
    onmousedown = function(){processClick()}
        
    // Main
    spawnFish();
    beginTick();
} else {
    clearGameContainerContent();
    const big_note = generateBigNote(generatePlayLink('Play Game', true));
    big_note.appendChild(generateLeaderboard())
    appendGameContainerContent(big_note);
}
</script>
