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

$latitude = (random_int(0, 1800) - 900) / 10;
$longitude = (random_int(0, 3600) - 1800) / 10;
$location_info = apiCall('https://api.bigdatacloud.net/data/reverse-geocode-client?latitude='.$latitude.'&longitude='.$longitude.'&localityLanguage=en');
$country_code = $location_info['countryCode'];
if ($country_code == ""){
    $location_message = ' this time you landed in the '.$location_info['localityInfo']['informative'][0]['name']. ' bozo 🌊';
} else {
    $location_message = ' this time you landed in '.$location_info['countryName'].' '.getEmojiFromCountryCode($country_code).'!';
}


$tristan_webpage = file_get_contents("https://www.tristandc.com/population.php");
foreach (explode("strong>",$tristan_webpage) as $strong_element){
    if (str_contains($strong_element, "There are") and str_contains($strong_element, "Tristan da Cunha Islanders")){
        $tristan_inhabitants_text = htmlspecialchars(str_replace('"','',str_replace("</","",$strong_element)));
    }
}


if (isset($_GET['mail'])){
    if (count(sqlQuery("SELECT * FROM mailing_list WHERE email='".$_GET['mail']."'")) == 0){ // Only if user isn't already in mailing list
        sqlQuery("INSERT INTO mailing_list (email, time) VALUES ('".$_GET['mail']."', '".time()."')");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk" />
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
</style>

<body>
<div style="display: none"><?php echo $ip_address;?></div>
<div class="page-banner" style="margin-top: 0.5rem">
<?php echo 'hogwild.uk has had '.count($visits).' visits from '.count($unique_visitors).' visitors, you\'ve been here '.$client_visit_number.' times.'.$location_message;?>
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

    <div style="flex-basis: 100%; display: flex; justify-content: center;">
    <form action="" style="display: flex; flex-wrap: wrap; justify-content: center; width: 250px; aspect-ratio: 250 / 226; background-image: url(images/buttons/mailing-list-border.png)">
    <h2 class="hidden-heading">Subscribe to the Hog Wild Mailing List</h2>
    <img src="images/buttons/mailing-list.png" class="button-image" alt="Hand drawn button for the Hog Wild Mailing List" style="transform: scale(0.7);">
    <input type="email" placeholder="Email Address" name="mail" class="drawn-border-text-input" required style="background-image: url(images/buttons/mailing-list-email-border.png);">
    <input type="submit" class="button" value="" style="background-image: url(images/buttons/subscribe.png); width: 250px;
 height: 96px; background-color: white; border: none; transform: scale(0.9); cursor: pointer;">
    </form>
    </div>
    
	<?php 
		$lisboa = apiCall('http://app.metrolisboa.pt/status/getLinhas.php')['resposta']; 
		$amarela = $lisboa['amarela'];
		$azul = $lisboa['azul'];
		$verde = $lisboa['verde'];
		$vermelha = $lisboa['vermelha'];
	?>
	<div class="lisboa-big-container">
		Lisboa Metro Status:
		<div class="lisboa-container"><div class="lisboa-status" style="background-color: yellow"><?php echo $amarela;?></div></div>
		<div class="lisboa-container"><div class="lisboa-status" style="background-color: blue"><?php echo $azul;?></div></div>
		<div class="lisboa-container"><div class="lisboa-status" style="background-color: green"><?php echo $verde;?></div></div>
		<div class="lisboa-container"><div class="lisboa-status" style="background-color: red"><?php echo $vermelha;?></div></div>
	</div>

            <div class="lisboa-big-container">
            <a class="button-as-link" href="https://www.tristandc.com/population.php"><?php echo $tristan_inhabitants_text;?></a>
            </div>

    <div class="lisboa-big-container">
	<div class="random-joke" style="max-width: 90%;">Today's Hog Joke: <?php echo apiCall("https://official-joke-api.appspot.com/random_joke")['setup'].' '.apiCall("https://official-joke-api.appspot.com/random_joke")['punchline'];?></div></div>



<div class="footer">
<strong>What the hell is this website!??!?</strong><br><a class="button-as-link" href="https://hogwild.uk">hogwild.uk</a> is a collection of ideas and art by anyone who wants to have their ideas and art published. If you've made or are making something you'd like to share, or just have something to say, please <a class="button-as-link" href="mailto:rory@hogwild.uk">email Rory</a> at rory (@) hogwild.uk
</div>

</div>
</body>

<script type="module">
    import { start_image_loop } from './lib/hoglib.js';
    start_image_loop('hogspin', 8, 150);
</script>
</html>
