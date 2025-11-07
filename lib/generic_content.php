<?php

/* Get IP Address */
$ip_address = $_SERVER['REMOTE_ADDR'];  

/* Get url of served page */
$current_url = $_SERVER['REQUEST_URI'];

/* Check if running locally */
if (str_contains($current_url, 'hogsite')){
	$running_locally = true;
} else {
	$running_locally = false;
}

/* Local vs live site differences */
if ($running_locally){
    $base_content = '<base href="/hogsite/">';
    $home_location = 'index.php';
} else {
    $base_content = '<base href="https://hogwild.uk">';
    $home_location = 'https://hogwild.uk';
}

/* Helper functions */
function apiCall($api_url){
    return json_decode(file_get_contents($api_url),true);
}

/* Renderable content */
$standard_header_content = '
	<meta charset="utf-8">
	<meta name="description" content="Welcome to the Hog Universe. Explore the Hogipedia, walk around Thompson World, or just go hog wild in whatever way feels natural...">
    <meta property="og:title" content="Join The Wild Hogs">
    <meta property="og:description" content="Welcome to the Hog Universe. Explore the Hogipedia, walk around Thompson World, or just go hog wild in whatever way feels natural...">
    <meta property="og:image" content="https://hogwild.uk/favicon/apple-touch-icon.png">
    <meta property="og:url" content="https://hogwild.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1" />'.$base_content.'
    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
	<link rel="shortcut icon" href="favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="hogwild.uk" />
	<link rel="manifest" href="favicon/site.webmanifest" />
	<link rel="stylesheet" href="style.css">';

$standard_toolbar = '<a class="button toolbar-home" href="'.$home_location.'"><img class="button-image" src="images/buttons/home.png"></a>';
	
/* SQL Functions */
$conn = null;

function openSqlConnection($database, $login_file){
	global $running_locally, $conn;
	if ($running_locally) {
		$user = 'root';
		$password = '';
	} else {
		include $login_file; // e.g. sql_login_wildhog_notoalgorithms.php
	}
	$conn = mysqli_connect('localhost', $user, $password, $database) or die("Couldn't connect to database");
}

function sqlQuery($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$data = [];
	if (!is_bool($result)){
		if ($result->num_rows > 0) { 
			while ($row = $result->fetch_assoc()) { 
				$data[] = $row; // Add each row to the data array 
			}
		}		
	}
	return $data;
}

function recordUserVisit(){
	global $ip_address;
	sqlQuery('INSERT INTO home_visits (visit_id, visitor_ip, visit_time) VALUES ("vst'.uniqid().'", "'.$ip_address.'", NOW())');
}
function getNewestSongLink(){
    return sqlQuery("SELECT * FROM song_links ORDER BY submitted DESC")['0']['link'];
}
function getLightBulbState(){
    return sqlQuery("SELECT * FROM interactive_elements WHERE name='light'")['0']['state'];
}
function setLightBulbState($state){
    sqlQuery("UPDATE interactive_elements SET state='".$state."' WHERE name='light'");
}
function getInteractiveElementStates(){
    $values = [];
    $values['song_text'] = getSongTextFromInfo(getSongInfoFromLink(getNewestSongLink()));
    $values['light'] = getLightBulbState();
    return $values;
}

/* Other Functions */
function getSongInfoFromLink($link){
    $info = [];
    if (str_contains($link, "spotify")){
        $song_webpage = file_get_contents('https://spotify.detta.dev/?url='.$link);
        $info['name'] = explode('</span>',explode('<span data-song-title data-astro-cid-qrctrsxd>',$song_webpage)[1])[0];
        $info['artist'] = explode('</span>',explode('<span data-song-artist data-astro-cid-qrctrsxd>',$song_webpage)[1])[0];
        $info['link'] = $link;
    } else {
        $info['name'] = 'Invalid Link';
        $info['artist'] = 'Invalid Link';
        $info['link'] = 'Invalid Link';
    }
    return $info;
}
function getSongTextFromInfo($info){
    return 'Someone recommends listening to <a class="button-as-link" href="'.$info['link'].'">'.$info['name'].' by '.$info['artist'].'</a>';
}
?>	
