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
function getTemperatureComment($temperature){
    if ($temperature < 0) {
        $temperature_comment = 'What\'s cooler than being cool? ICE COLD!';
    } else if ($temperature < 10) {
        $temperature_comment = 'Wear a jumper...';
    } else if ($temperature < 25) {
        $temperature_comment = 'That\'s a normal temperature...';
    } else if ($temperature < 35) {
        $temperature_comment = 'Don\'t forget sun cream!';
    } else if ($temperature < 40) {
        $temperature_comment = 'Hot one today!! Be careful...';
    } else {
        $temperature_comment = 'You are dead.';
    }
    return $temperature_comment;
}
function getEmojiFromCountryCode($country_code){
    return mb_convert_encoding( '&#' . ( 127397 + ord( $country_code[0] ) ) . ';', 'UTF-8', 'HTML-ENTITIES').mb_convert_encoding( '&#' . ( 127397 + ord( $country_code[1] ) ) . ';', 'UTF-8', 'HTML-ENTITIES');
}
$visits = sqlQuery("SELECT * from home_visits");
$unique_visitors = getUniqueVisitors($visits);
$client_visit_number = $unique_visitors[$ip_address];

/*
$ip_api_url = 'http://ip-api.com/json/'.$ip_address;
$response = apiCall($ip_api_url);
if ($response['status'] == 'success'){
    $country_code = $response['countryCode'];
    $country_emoji = mb_convert_encoding( '&#' . ( 127397 + ord( $country_code[0] ) ) . ';', 'UTF-8', 'HTML-ENTITIES').mb_convert_encoding( '&#' . ( 127397 + ord( $country_code[1] ) ) . ';', 'UTF-8', 'HTML-ENTITIES');
    $city = $response['city'];
    $latitude = $response['lat'];
    $longitude = $response['lon'];
    $weather_api_url = 'https://api.open-meteo.com/v1/forecast?latitude='.$latitude.'&longitude='.$longitude.'&hourly=apparent_temperature&forecast_days=1';
    $weather_response = apiCall($weather_api_url);
    $temperature = round($weather_response['hourly']['apparent_temperature'][1]);
    $temperature_comment = getTemperatureComment($temperature);
    $temperature_sentence = ' it\'s about '.$temperature.'°C near '.$city.' '.$country_emoji.' '.$temperature_comment;
} else {
    $temperature_sentence = '';
    }*/
/*
try {
    $latitude = (random_int(0, 1800) - 900) / 10;
    $longitude = (random_int(0, 3600) - 1800) / 10;
    $location_info = apiCall('https://api.bigdatacloud.net/data/reverse-geocode-client?latitude='.$latitude.'&longitude='.$longitude.'&localityLanguage=en');
    $country_code = $location_info['countryCode'];
    if ($country_code == ""){
        $location_message = ' this time you landed in the '.$location_info['localityInfo']['informative'][0]['name']. ' bozo 🌊';
    } else {
        $location_message = ' this time you landed in '.$location_info['countryName'].' '.getEmojiFromCountryCode($country_code).'!';
    }
} catch (Exception $e) {
    $location_message = '';
}
*/

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
    
.home-sections {
    overflow: hidden;
    padding-bottom: 250px;
}
#home-page-message {
    display: flex;
    justify-content: center;
    align-items: center;
    position: sticky;
    z-index: 99;
    top: 0;
    width: 100%;
    height: 2rem;
    background-color: #f4f4f4;
}
.home-section-container {
    position: relative;
    background-size: contain;
}
.height-medium {
    height: 700px;
}
.height-small {
    height: max(30vw, 250px);
}
.home-section-container a:hover .home-section-image:not(.no-hover) {
    filter: drop-shadow(0 0 10px grey);;
}
.home-section-image {
    position: absolute;
}
</style>
    
<body>
    <div id='home-page-message'></div>

    <div class='home-sections'>
        <div class='home-section-container height-medium' style="aspect-ratio: 1080 / 1699; margin: 0 auto 0 2rem; background-image: url(images/thompson-world/thompson-world-front-door.png)">
            <a class='home-section-link' href='https://hogwild.uk/thompson-world' title='explore the Thompson World'>
                <img class='home-section-image' src='images/thompson-world/thompson-world-front-door-to-entrance-hallway.png' style='height: 29.3702%; top: 51%; left: 22%'/>
            </a>
            <a class='home-section-link' href='' title='join the mailing list'>
                <img class='home-section-image' src='images/mailbox.png' style='height: 29.3702%; bottom: min(20%, calc(20vw - 10%)); left: min(130%, 65vw)'/>
            </a>
        </div>

        <div class='home-section-container height-small' style="aspect-ratio: 1080 / 720; margin: 0;">
            <img class='home-section-image' src='images/rug.png' style='height: 60%; top: 10%; left: max(10%, 10vw)'/>
            <img class='home-section-image' src='images/speaker-l.png' style='height: 50%; top: 5%; left: 22%'/>
            <img class='home-section-image' src='images/speaker-r.png' style='height: 30%; top: 0; left: max(70%, 45vw)'/>
            <a class='home-section-link' href='https://hogwild.uk/notoalgorithms' title='no to algorithms! humans only music recommendations'>
                <img class='home-section-image' src='images/record-box.png' style='height: 30%; top: 40%; left: 70%'/>
            </a>
            <a class='home-section-link' href='https://hogwild.uk' title='put everyone onto something new'>
                <img class='home-section-image' src='images/stand-note.png' style='height: 40%; top: 60%; left: 15%'/>
                <div id='song-text' class='home-section-image no-hover' style='height: 30%; top: 62%; left: 17%; max-width: 38%; max-height: 30%; font-size: 80%; overflow: hidden'></div>
            </a>
        </div>
    
        <div class='home-section-container height-small' style="aspect-ratio: 1080 / 720; margin: max(-15vw, -250px) 15vw 0 auto;">
            <img class='home-section-image' src='images/gambling-items.png' style='height: 60%; top: 10%; left: max(10%, 10vw)'/>
            <a class='home-section-link' href='https://hogwild.uk/nothingeverhappens' title='nothing ever happens - friendly betting'>
                <img class='home-section-image' src='images/buttons/nothingeverhappens.png' style='height: 20%; top: 10%; left: max(170px, 25vw)'/>
            </a>
        </div>

        <?php 
		$lisboa = apiCall('http://app.metrolisboa.pt/status/getLinhas.php')['resposta']; 
		$amarela = $lisboa['amarela'];
		$azul = $lisboa['azul'];
		$verde = $lisboa['verde'];
		$vermelha = $lisboa['vermelha'];
	    ?>
    
        <div class='home-section-container height-small' style="aspect-ratio: 1080 / 720; margin: max(-25vw, -10%) 0 0;">
            <a class='home-section-link' href='https://www.metrolisboa.pt/en/' title='check the status of the Lisbon metro'>
            <div class='home-section-image no-hover' style='max-height: 26%; top: 30%; left: 21%; max-width: 32%; transform: scale(0.75, 1) skew(0deg, -28deg); overflow: hidden;'>amerela: <?php echo $amarela;?><br>azul: <?php echo $azul;?><br>verde: <?php echo $verde;?><br>vermelha: <?php echo $vermelha;?><br></div>
                <img class='home-section-image' src='images/noticeboard.png' style='height: 100%; top: -15%; left: 10%'/>
            </a>
        </div>

        <div class='home-section-container height-small' style="aspect-ratio: 1080 / 720; margin: max(-15vw, -250px) 15vw 0 auto;">
            <a class='home-section-link' href='https://hogwild.uk/wiki' title='hogipedia - learn the lore'>
                <iframe src="wiki/index.php" width="100%" height="300" style="position: relative; height: 51%; width: 45%; top: 18%; left: 18%; zoom: 0.2"></iframe>
                <img class='home-section-image' src='images/old-mouse.png' style='height: 35%; top: 60%; left: 60%'/>
                <img class='home-section-image' src='images/old-pc.png' style='height: 100%; top: 10%; left: 10%'/>
            </a>
        </div>
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
        longPoll(); /* Start the inital request */
    }
});

</script>
</html>
