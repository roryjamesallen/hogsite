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
} else if (isset($_GET['light-bulb'])){
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
    flex-basis: 100%;
        display: flex;
        justify-content: center;
        margin-top: 3rem;
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
</style>

<body>
<div style="display: none"><?php echo $ip_address;?></div>
<div class="page-banner" style="margin-top: 0.5rem">
<?php echo 'hogwild.uk has had '.count($visits).' visits from '.count($unique_visitors).' visitors, you\'ve been here '.$client_visit_number.' times.';?>

    <form style="position: absolute; top: 0; right: 0; width: 452px; height: 655px; transform-origin: 100% 0%; transform: scale(0.25);">
    <input type="submit" value="" name="light-bulb" id="light-bulb" style="position: absolute; top: 0; left: 0; background-size: contain; width: 100%; height: 100%; background: none; border: none">
    </form>
</div>
    
<div class="button-container">
    <h1 class="hidden-heading">hogwild.uk - Home of The Wild Hogs</h1>
    <img style="width: 100%;" src="images/hogwilduk-banner.png" alt="Hand drawn banner image that spells out the domain name hogwild.uk"></img>
    
	<div class="hogspin-container" style="flex-basis: 100%; display: flex; justify-content: center; margin-top: -5rem">
		<img id="hogspin1" src="images/hogspin/1.png" style="display: block" alt="Hand drawn frame 1 of an animation of a rotating hog">
		<img id="hogspin2" src="images/hogspin/2.png" style="display: none" alt="Hand drawn frame 2 of an animation of a rotating hog">
		<img id="hogspin3" src="images/hogspin/3.png" style="display: none" alt="Hand drawn frame 3 of an animation of a rotating hog">
		<img id="hogspin4" src="images/hogspin/4.png" style="display: none" alt="Hand drawn frame 4 of an animation of a rotating hog">
		<img id="hogspin5" src="images/hogspin/5.png" style="display: none" alt="Hand drawn frame 5 of an animation of a rotating hog">
		<img id="hogspin6" src="images/hogspin/6.png" style="display: none" alt="Hand drawn frame 6 of an animation of a rotating hog">
		<img id="hogspin7" src="images/hogspin/7.png" style="display: none" alt="Hand drawn frame 7 of an animation of a rotating hog">
		<img id="hogspin8" src="images/hogspin/8.png" style="display: none" alt="Hand drawn frame 8 of an animation of a rotating hog">
	</div>

    <div class="page-banner">
    <img src="images/banner-pages.png" alt="Banner for Hog Wild pages">
    </div>
    
    <a class="button" href="https://hogwild.uk/wiki">
        <h2 class="hidden-heading">Hogipedia</h2>
		<img src="images/buttons/hogipedia.png" class="button-image" alt="Hand drawn button for the Hogipedia page, a Wikipedia style encyclopedia for The Wild Hogs">
	</a>
    
	<a class="button" href="https://hogwild.uk/thompson-world">
        <h2 class="hidden-heading">Thompson World</h2>
		<img src="images/buttons/thompson-world.png" class="button-image" alt="Hand drawn button for Thompson World page">
	</a>

    <a class="button" href="https://hogwild.uk/hogdivmosaic">
        <h2 class="hidden-heading">Hog Mosaic</h2>
		<img src="images/buttons/hogmosaic.png" class="button-image" alt="Hand drawn button for Hog Mosaic page">
	</a>

    <a class="button" href="https://hogwild.uk/notoalgorithms">
        <h2 class="hidden-heading">No To Algorithms!</h2>
		<img src="images/buttons/notoalgorithms.png" class="button-image" alt="Hand drawn button for No To Algorithms music recommendations page">
	</a>

    <a class="button" href="https://hogwild.uk/nothingeverhappens">
        <h2 class="hidden-heading">Hog Mosaic</h2>
		<img src="images/buttons/nothingeverhappens.png" class="button-image" alt="Hand drawn button for Nothing Ever Happens">
	</a>

    <div class="page-banner">
    <img src="images/banner-gubbins.png" alt="Banner for Hog Wild pages">
    </div>

    <div style="flex-basis: 100%; display: flex; justify-content: center; flex-wrap: wrap; gap: 1rem;">
    <form action="" style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
    <h2 class="hidden-heading">Subscribe to the Hog Wild Mailing List</h2>
    <img src="images/buttons/mailing-list.png" class="button-image" alt="Hand drawn button for the Hog Wild Mailing List" style="transform: scale(0.7);">
    <input type="email" placeholder="Email Address" name="mail" class="drawn-border-text-input" required style="background-image: url(images/buttons/mailing-list-email-border.png); background-position-y: 0.9rem;">
    <input type="submit" value="Subscribe" class="drawn-border-text-input" required style="background-image: url(images/buttons/mailing-list-email-border.png); background-position-y: 0.9rem; background-color: rgba(0,0,0,0); margin-top: -1.25rem">
    </form>

    <form method="POST" action="" style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
    <h2 class="hidden-heading">Submit a song recommendation</h2>
    <div id='song-text' class="song-link" style="width: 80%; margin-top: 1.5rem;"></div>
    <input placeholder="Spotify Link" name="song_link" class="drawn-border-text-input" required style="background-image: url(images/buttons/mailing-list-email-border.png); background-position-y: 0.9rem;">
    <input type="submit" value="Recommend" class="drawn-border-text-input" required style="background-image: url(images/buttons/mailing-list-email-border.png); background-position-y: 0.9rem; background-color: rgba(0,0,0,0); margin-top: -1.25rem">
    </form>


    <?php 
		$lisboa = apiCall('http://app.metrolisboa.pt/status/getLinhas.php')['resposta']; 
		$amarela = $lisboa['amarela'];
		$azul = $lisboa['azul'];
		$verde = $lisboa['verde'];
		$vermelha = $lisboa['vermelha'];
	?>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
        <div style="width: 80%; margin-top: 1.5rem">
            <a class="button-as-link" href="https://www.metrolisboa.pt/en/">Lisboa Metro</a> Status:
            <div class="lisboa-container"><div class="lisboa-status" style="color: yellow"><?php echo $amarela;?></div></div>
            <div class="lisboa-container"><div class="lisboa-status" style="color: blue"><?php echo $azul;?></div></div>
            <div class="lisboa-container"><div class="lisboa-status" style="color: green"><?php echo $verde;?></div></div>
            <div class="lisboa-container"><div class="lisboa-status" style="color: red"><?php echo $vermelha;?></div></div>
         </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
            <a style="width: 80%; margin-top: 1.5rem; font-size: 2rem;" class="button-as-link" href="https://www.tristandc.com/population.php"><?php echo $tristan_inhabitants_text;?></a>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
            <div class="random-joke" style="width: 80%; margin-top: 1.5rem;;">Hog Joke:<br><?php echo apiCall("https://official-joke-api.appspot.com/random_joke")['setup'].' <span style="font-family: Jokerman; text-decoration: underline">'.apiCall("https://official-joke-api.appspot.com/random_joke")['punchline'].'</span>';?></div>
    </div>
</div>

<div class="footer">
<strong>What the hell is this website!??!?</strong><br><a class="button-as-link" href="https://hogwild.uk">hogwild.uk</a> is a collection of ideas and art by anyone who wants to have their ideas and art published. If you've made or are making something you'd like to share, or just have something to say, please <a class="button-as-link" href="mailto:rory@hogwild.uk">email Rory</a> at rory (@) hogwild.uk
</div>

</div>
</body>

<script type='module'>
    import { start_image_loop } from './lib/hoglib.js';
    start_image_loop('hogspin', 8, 150);

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
    updateLightBulb(values['light']);
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
