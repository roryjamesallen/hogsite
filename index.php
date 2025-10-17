
<?php
ob_start(); // Begin output buffering to allow output to be rendered after html head
error_reporting(E_ALL);

if ($_SERVER
    ['REMOTE_ADDR'] == '127.0.0.1') {
	$user = 'root';
	$password = '';
	$db = 'nothingeverhappens';
} else {
	$user = 'wildhog_analytics';
	$password = 'kX7V4,UC2[9ULS3s';
	$db = 'wildhog_analytics';
}
$conn = mysqli_connect('localhost', $user, $password, $db) or die("Couldn't connect to database");

function sqlQuery($conn, $query){
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

/* Record user visit */
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];  
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];  
} else{  
    $ip_address = $_SERVER['REMOTE_ADDR'];  
}
$query = 'INSERT INTO home_visits (visit_id, visitor_ip, visit_time) VALUES ("vst'.uniqid().'", "'.$ip_address.'", NOW()")';
    echo $query;
sqlQuery($conn, $query);
?>

<head>
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
<link rel="shortcut icon" href="/favicon/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="hogwild.uk" />
<link rel="manifest" href="/favicon/site.webmanifest" />
     </head>

<style>
body {
     margin: 0;
 }
.button-container {
     display: flex;
    flex-wrap: wrap;
     gap: 10px;
     justify-content: center;
     padding: 50px 0;
 }
.button {
     position: relative;
 }
.button:hover .button-image {
     filter: invert(0.4);
 }
.button-image {
    flex-basis: 300px;
     max-width: 300px;
 }
</style>
     
<div class="button-container">
     <img style="width: 100%;" src="images/hogwilduk-banner.png"></img>
     
     <a class="button" href="https://notoalgorithms.hogwild.uk">
     <img src="images/buttons/notoalgorithms.png" class="button-image">
     </a>
</div>
