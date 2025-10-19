
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

	<div class="scene-container" style="width: 1080px; height: 938px">
		<img class="scene-image scene-background" src="images/thompson-world/thompson-world-front-hallway.png">
		<a href="https://hogwild.uk/thompson-world/lounge" class="scene-image-link" style="width: 143px; height: 352px; left: 549px; top: 174px">
			<img class="scene-image" src="images/thompson-world/thompson-world-front-hallway-door-to-lounge.png">
		</a>
	</div>
	
	
	<?php 
	$thompson_room = $_POST['thompson-room'];
	if ($thompson_room == 'lounge'){
		$thompson_background_height: '710';
		$thompson_background_src = 'lounge';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/entrance-hallway" class="scene-image-link" style="width: 258px; height: 180px; left: 0px; bottom: 0px">
				<img class="scene-image" src="images/thompson-world/thompson-world-lounge-to-hallway.png">
			</a>
			<a href="https://hogwild.uk/thompson-world/kitchen" class="scene-image-link" style="width: 122px; height: 208px; left: 544px; top: 110px">
				<img class="scene-image" src="images/thompson-world/thompson-world-lounge-to-kitchen.png">
			</a>';
		$thompson_room_links = '
			<input class="scene-image" type="image" src="images/thompson-world/thompson-world-lounge-to-hallway.png" name="entrance-hallway" width="258px" height="180px" style="left: 0px; bottom: 0px">
			<input class="scene-image" type="image" src="images/thompson-world/thompson-world-lounge-to-kitchen.png" name="entrance-hallway" width="122px" height="208px" style="left: 544px; top: 110px">
			'
	} else if($thompson_room == 'entrance-hallway'){
		$thompson_background_height: '938';
		$thompson_background_src = 'front-hallway';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/lounge" class="scene-image-link" style="width: 143px; height: 352px; left: 549px; top: 174px">
				<img class="scene-image" src="images/thompson-world/thompson-world-front-hallway-door-to-lounge.png">
			</a>
		';
	} else if($thompson_room == 'kitchen'){
		$thompson_background_height: '1296';
		$thompson_background_src = 'kitchen';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/lounge" class="scene-image-link" style="width: 310px; height: 211px; left: 0px; bottom: 0px">
				<img class="scene-image" src="images/thompson-world/thompson-world-kitchen-to-lounge.png">
			</a>
		';
	} 
	?>
	<div class="scene-container" style="width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<img class="scene-image scene-background" src="images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
		<form>
			<?php echo $thompson_room_links ?>
		</form>
	</div>
	
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