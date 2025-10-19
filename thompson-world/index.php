<?php 
include '../html_header.php';



if (isset($_GET['lounge_x'])){
	$thompson_room = 'lounge';
} else if (isset($_GET['kitchen_x'])){
	$thompson_room = 'kitchen';
} else if (isset($_GET['entrance-hallway_x'])){
	$thompson_room = 'entrance-hallway';
} else if (isset($_GET['conservatory_x'])){
	$thompson_room = 'conservatory';
} else {
	$thompson_room = 'entrance-hallway';
}
$thompson_room_pretty = ucwords(str_replace('-', ' ', $thompson_room));
?>

<?php 
	if ($thompson_room == 'lounge'){
		$thompson_background_height = '710';
		$thompson_background_src = 'lounge';
		$thompson_room_links = '
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-lounge-to-hallway.png" name="entrance-hallway" width="258px" height="180px" style="left: 0px; bottom: 0px">
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-lounge-to-kitchen.png" name="kitchen" width="122px" height="208px" style="left: 544px; top: 110px">';
	} else if($thompson_room == 'entrance-hallway'){
		$thompson_background_height = '938';
		$thompson_background_src = 'front-hallway';
		$thompson_room_links = '
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-front-hallway-door-to-lounge.png" name="lounge" width="143px" height="352px" style="left: 549px; top: 174px">';
	} else if($thompson_room == 'kitchen'){
		$thompson_background_height = '1296';
		$thompson_background_src = 'kitchen';
		$thompson_room_links = '
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-kitchen-to-lounge.png" name="lounge" width="310px" height="211px" style="left: 0px; bottom: 0px">
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-kitchen-to-conservatory.png" name="conservatory" width="266px" height="484px" style="left: 389px; top: 191px">';
	} else if ($thompson_room == 'conservatory'){
		$thompson_background_height = '744';
		$thompson_background_src = 'conservatory';
		$thompson_room_links = '
			<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-conservatory-to-lounge.png" name="lounge" width="169px" height="152px" style="left: 0px; bottom: 0px">';
	}
?>

<div class="button-container">
	<h1 style="width: 100%; text-align: center;"><?php echo $thompson_room_pretty ?></h1>
	<div class="scene-container" style="width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<form action="" method="GET" class="thompson-world-form">
			<img class="scene-image scene-background" src="../images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
			<?php echo $thompson_room_links ?>
		</form>
	</div>
</div>