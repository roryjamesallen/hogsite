<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head

openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');
recordUserVisit();

function getUniqueVisitors($visits){
	$visitors = [];
	foreach($visits as $visit){
		$visitor_ip = $visit['visitor_ip'];
		if (array_key_exists($visitor_ip, $visitors)){
			$visitors[$visitor_ip] += 1;
		} else {
			$visitors[$visitor_ip] = 1;
		}
	}
	return $visitors;
}

$tristan_webpage = file_get_contents("https://www.tristandc.com/population.php");
foreach (explode("strong>",$tristan_webpage) as $strong_element){
    if (str_contains($strong_element, "There are") and str_contains($strong_element, "Tristan da Cunha Islanders")){
        $tristan_inhabitants_text = htmlspecialchars(str_replace('"','',str_replace("</","",$strong_element)));
    }
}

$prevent_long_polling = false;
$interactive_element_states = getInteractiveElementStates();
    
if (isset($_GET['mail'])){
    if (count(sqlQuery("SELECT * FROM mailing_list WHERE email='".$_GET['mail']."'")) == 0){ // Only if user isn't already in mailing list
        sqlQuery("INSERT INTO mailing_list (email, time) VALUES ('".$_GET['mail']."', '".time()."')");
    }
} else if (isset($_GET['qr'])){
	sqlQuery('INSERT INTO home_visits (visit_id, visitor_ip, visit_time) VALUES ("vst'.uniqid().'", "qr'.$_GET['qr'].'", NOW())');
} else if (isset($_POST['song_link'])){ // User set a song link
    $link = $_POST['song_link'];
    $song_text = '';
    $prevent_long_polling = false;
    if ($link != null){
        $link = explode("?",$link)[0];
        if (sqlQuery('SELECT * FROM song_links WHERE link="'.$link.'"') == null and str_contains($link, "spotify")){
            sqlQuery('INSERT INTO song_links (link, submitted, ip_address) VALUES ("'.$link.'", "'.time().'", "'.$ip_address.'")');
        } else if (str_contains($link, "spotify")){
            $interactive_element_states['song_text'] = "Song has been submitted before";
        } else {
            $interactive_element_states['song_text'] = "That's not a valid Spotify link";
        }
    } else {
        $interactive_element_states['song_text'] = "Link can't be blank";
    }
    if ($song_text == ''){
        $info = getSongInfoFromLink(getNewestSongLink());
        $interactive_element_states['song_text'] = 'Someone recommends listening to '.$info['name'].' by '.$info['artist'];
    } else {
        $prevent_long_polling = true;
    }
} else if (isset($_POST['light-bulb'])){
    $old_state = getLightBulbState();
    $new_state = strval(1 - intval($old_state));
    setLightBulbState($new_state);
    $interactive_element_states['light'] = $new_state;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Home of The Wild Hogs</title>
</head>

    <style>
.drawn-border-text-input {
    color: black;
    width: 100%;
    border: none;
    padding: 8px;
    font-size: 1.5rem;
    transform: scale(0.9);
    background-size: contain;
    background-repeat: no-repeat;
                         }
.page-banner {
        margin: auto;
        flex-basis: 100%;
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 3rem;
        text-align: left;
                         }
input:focus-visible {
    outline: none;
    border: none;
    box-shadow: none;
}
form input[type="submit"]:hover {
    filter: opacity(0.6);
    cursor: pointer;
}
.button-with-caption {
    display: flex;
    align-content: center;
    font-size: 1.5rem;
    flex-wrap: wrap;
}
.button-caption {
    flex-basis: 100%;
    width: 0;
    text-align: center;
    font-family: monospace;
    font-size: 1.5rem;
    filter: opacity(0.5);
}
.button-container {
    gap: 2rem;
    margin: 0 2rem;
}
.hogspin-container:after {
    content: "hogwild.uk";
    display: flex;
    position: absolute;
    font-size: 5rem;
    font-family: arial;
    z-index: -1;
    top: 4.5rem;
}
@media screen and (max-width: 750px){
    .page-banner {
        margin-left: 1rem !important;
        text-align: left;
    }
}
</style>


<style>
body {
    font-family: Arial;
}
a, a:visited {
    color: black;
}
#header-bar {
display: flex;
width: calc(100% - 1rem);
padding: 0 0.5rem;
height: 2rem;
background-color: #f4f4f4;
position: sticky;
z-index: 99;
top: 0;
justify-content: space-between;
align-items: center;
}   
#home-page-message {
}
.home-section {
flex-basis: 25%;
}
.home-section-container a:hover .home-section-image:not(.no-hover) {
    filter: drop-shadow(0 0 10px grey);;
}
</style>
    
<body>
  <div id='header-bar'>
    <div id='mail'>🖂</div>
    <div id='home-page-message'></div>
    <div id='help'>⍰</div>
  </div>

  <div id='home-container'>
    <div class='home-section'><a class='home-section-link' href='https://hogwild.uk/thompson-world' title='explore the Thompson World'></div>
    <div class='home-section'></div>
    <div class='home-section'></div>
    <div class='home-section'></div>
  </div>
</body>

<script>
    function updatePageMessage(text){
        document.getElementById('home-page-message').innerHTML = text;
    }
    function resetPageMessage(){
        updatePageMessage("<span>welcome to <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a></span>")
    }

    resetPageMessage();
    document.querySelectorAll(".home-section-link").forEach(element => {
            element.addEventListener("mouseover", () => { updatePageMessage(element.title) });
            element.addEventListener("mouseout", () => { resetPageMessage() });
    });
</script>

<script type='module'>
import { start_image_loop } from './lib/hoglib.js';
//start_image_loop('hogspin', 8, 150);

var prevent_long_polling = <?php echo json_encode($prevent_long_polling);?>;
var interactive_element_states = <?php echo json_encode($interactive_element_states);?>;
console.log(interactive_element_states);
processLongPollValues(interactive_element_states);

function processLongPollValues(values){
    try {
        values = JSON.parse(values);
    } catch {
    }
    //console.log(values);
    updateSongText(values['song_text']);
    //updateLightBulb(values['light']);
}
function updateSongText(text){
    document.getElementById('song-text').innerHTML = text;
}
function updateLightBulb(state){
    document.getElementById('light-bulb').style.backgroundImage = 'url(images/buttons/light-bulb-'+state+'.png)';
}

function longPoll(){
    $.ajax({
        type: 'GET',
        url: 'long_poll.php',
        async: true, // Prevent browser loading
        cache: false,
        timeout: 50000, // Give up after 50s
        success: function(values){
            processLongPollValues(values);
            setTimeout(longPoll, 1000); // Request update after 1s
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){} // Catch errors
    });
}

$(document).ready(function(){
    if (!prevent_long_polling){
        //longPoll(); /* Start the inital request */
    }
});

</script>
</html>
