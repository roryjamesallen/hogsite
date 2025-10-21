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

$visits = sqlQuery("SELECT * from home_visits");
$unique_visitors = getUniqueVisitors($visits);
$client_visit_number = $unique_visitors[$ip_address];

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
}
?>

<html>
<head>
    <?php echo $standard_header_content;?>
    <title>hogwild.uk <?php echo $country_emoji ?></title>
</head>

<body>
<div class="page-banner">
<?php echo 'hogwild.uk has had '.count($visits).' visits from '.count($unique_visitors).' visitors, you\'ve been here '.$client_visit_number.' times.'.$temperature_sentence?>
</div>
    
<div class="button-container">
    <img style="width: 100%;" src="images/hogwilduk-banner.png"></img>
     
    <a class="button" href="https://notoalgorithms.hogwild.uk">
		<img src="images/buttons/notoalgorithms.png" class="button-image">
	</a>

	<div class="hogspin-container">
		<img id="hogspin1" src="images/hogspin/1.png" style="display: block">
		<img id="hogspin2" src="images/hogspin/2.png" style="display: none">
		<img id="hogspin3" src="images/hogspin/3.png" style="display: none">
		<img id="hogspin4" src="images/hogspin/4.png" style="display: none">
		<img id="hogspin5" src="images/hogspin/5.png" style="display: none">
		<img id="hogspin6" src="images/hogspin/6.png" style="display: none">
		<img id="hogspin7" src="images/hogspin/7.png" style="display: none">
		<img id="hogspin8" src="images/hogspin/8.png" style="display: none">
	</div>


	<a class="button" href="https://tw.hogwild.uk">
		<img src="images/buttons/thompson-world.png" class="button-image">
	</a>
	
</div>
</body>

<script type="module">
    import { start_image_loop } from './lib/hoglib.js';
    start_image_loop('hogspin', 8, 150);
</script>
</html>
