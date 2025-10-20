<?php

/* Get IP Address */
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];  
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];  
} else{  
    $ip_address = $_SERVER['REMOTE_ADDR'];  
}

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

$standard_header_content = '
	<meta charset="utf-8">
	<meta name="description" content="Welcome to the Hog Universe">
	<meta name="viewport" content="width=device-width, initial-scale=1" />'.$base_content.'
    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
	<link rel="shortcut icon" href="./favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="hogwild.uk" />
	<link rel="manifest" href="favicon/site.webmanifest" />
	<link rel="stylesheet" href="style.css">';

$standard_toolbar = '
    <div class="standard-toolbar">
    <a class="button" href="'.$home_location.'" style="background-image: url(images/buttons/hogwilduk.png)"></a>
    </div>';
	
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
	return json_encode($data);
}

function recordUserVisit(){
	global $ip_address;
	sqlQuery('INSERT INTO home_visits (visit_id, visitor_ip, visit_time) VALUES ("vst'.uniqid().'", "'.$ip_address.'", NOW())');
}
?>	
