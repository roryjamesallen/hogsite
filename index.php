
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
$query = 'INSERT INTO home_visits (visit_id, visitor_ip, visit_time) VALUES ("vst'.uniqid().'", "'.$ip_address.'", NOW())';
sqlQuery($conn, $query);
?>

<?php 
include 'html_header.php';

if (!$_POST['thompson-room']){
	$_POST['thompson-room'] = 'lounge';
}
?>
     
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


	
	<h1><a href="https://hogwild.uk/thompson-world">Thompson World</a></h1>
	
</div>

<script>
function start_image_loop(image_id_prefix, limit, delay){
	var i = 1;
	function increment_image() {
		if(i <= limit) {
			setTimeout(function(){
				for (let i=1; i<=limit; i++) { 
					var image_id = image_id_prefix + i;
					document.getElementById(image_id).style.display = 'none';
				}
				var image_id = image_id_prefix + i;
				document.getElementById(image_id).style.display = 'block';
				i++;
				increment_image();
			}, delay);
	  } else {
			i = 1;
			increment_image();
	  }
	}
	increment_image();
}

start_image_loop('hogspin', 8, 150);
</script>